<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Smalot\PdfParser\Parser as PdfParser;
use PhpOffice\PhpWord\IOFactory;
use App\Models\Announcement;
use Carbon\Carbon;
use App\Models\DailyQuestionCount;
use Illuminate\Support\Facades\DB;
use App\Models\PublicQuestionCount;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PublicAskController extends Controller
{
    public function index(Request $request): Response
    {
        $remainingQuestions = $this->getRemainingPublicQuestions();

        return Inertia::render('Dashboard/PublicAsk', [
            'remainingQuestions' => $remainingQuestions,
            'selectedSubject' => $request->query('subject', ''),
        ]);
    }


    public function store(Request $request)
    {
        $remainingQuestions = $this->getRemainingPublicQuestions();

        if ($remainingQuestions <= 0) {
            return redirect()->route('public.ask')->with('error', 'You have reached your daily question limit.');
        }

        DB::beginTransaction();

        try {
            $this->validateRequest($request);

            $file = $request->file('photo');
            $filePath = null;

            if ($file) {
                $mimeType = $file->getMimeType();
                $extension = $file->getClientOriginalExtension();

                $filePath = $this->handleFileUpload($file);

                if (strpos($mimeType, 'image/') === 0) {
                    // No need to process the image, we'll use the file path directly
                } elseif ($mimeType === 'application/pdf') {
                    $filePath = $this->extractTextFromPDF($filePath);
                } elseif (in_array($extension, ['doc', 'docx']) || in_array($mimeType, ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])) {
                    $filePath = $this->extractTextFromWord($filePath);
                } else {
                    throw new \Exception('Unsupported file type.');
                }
            }

            $chatGPTResponse = $this->getChatGPTResponse(
                $request,
                $filePath,
                $request->input('instructions'),
                $request->input('subject', 'auto-detect'),
                $request->boolean('steps', false),
                $request->boolean('explain', false),
                $request->input('level')
            );

            if ($chatGPTResponse === null) {
                throw new \Exception('No response received from ChatGPT.');
            }

            $processedResponse = $this->processChatGPTResponse($chatGPTResponse, $request);

            $this->incrementPublicQuestionCount();

            DB::commit();

            return $this->renderResponse($processedResponse);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error in PublicAskController@store: ' . $e->getMessage());
            return redirect()->route('public.ask')->with('error', $this->getReadableErrorMessage($e));
        }
    }

    private function getPublicQuestionCount()
    {
        $ipAddress = request()->ip();
        $sessionId = Session::getId();
        $today = Carbon::today();

        return PublicQuestionCount::where(function ($query) use ($ipAddress, $sessionId, $today) {
            $query->where('ip_address', $ipAddress)
                  ->orWhere('session_id', $sessionId);
        })
        ->where('date', $today)
        ->first();
    }

    private function incrementPublicQuestionCount()
    {
        $ipAddress = request()->ip();
        $sessionId = Session::getId();
        $today = Carbon::today();

        $existingCount = $this->getPublicQuestionCount();

        if ($existingCount) {
            $existingCount->increment('count');
            $existingCount->ip_address = $ipAddress;
            $existingCount->session_id = $sessionId;
            $existingCount->save();
        } else {
            PublicQuestionCount::create([
                'ip_address' => $ipAddress,
                'session_id' => $sessionId,
                'date' => $today,
                'count' => 1
            ]);
        }
    }

    private function getRemainingPublicQuestions()
    {
        $count = $this->getPublicQuestionCount();
        return 3 - ($count ? $count->count : 0);
    }

    private function extractTextFromWord($filePath)
    {
        try {
            $phpWord = IOFactory::load($filePath);

            $text = '';
            foreach ($phpWord->getSections() as $section) {
                foreach ($section->getElements() as $element) {
                    if (method_exists($element, 'getText')) {
                        $text .= $element->getText() . ' ';
                    } elseif (method_exists($element, 'getElements')) {
                        foreach ($element->getElements() as $childElement) {
                            if (method_exists($childElement, 'getText')) {
                                $text .= $childElement->getText() . ' ';
                            }
                        }
                    }
                }
            }

            \Log::info('Extracted text from Word document:', ['text' => $text]);
            return $text;
        } catch (\Exception $e) {
            \Log::error('Error extracting text from Word document: ' . $e->getMessage());
            throw new \Exception('Unable to extract text from the Word document.');
        }
    }
    private function validateRequest(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:255',
            'level' => 'string|nullable|max:255',
            'question' => 'string|nullable',
            'explain' => 'boolean|nullable',
            'steps' => 'boolean|nullable',
            'photo' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf,doc,docx',
            'tokensCost' => 'nullable|integer',
            'temperature' => 'nullable|numeric|min:0|max:1',
            'model' => 'nullable|string',
        ]);
    }

    private function handleFileUpload($file)
    {
        try {
            $path = $file->store('uploads', 'public');
            return Storage::disk('public')->path($path);
        } catch (\Exception $e) {
            \Log::error('Error uploading file: ' . $e->getMessage());
            throw new \Exception('Unable to upload the file. Please try again.');
        }
    }

    private function performOCR($imagePath)
    {
        try {
            $client = new Client();
            $photoFullPath = storage_path('app/' . $imagePath);
            $response = $client->post('https://ocrphp.cognitiveservices.azure.com/vision/v3.2/ocr', [
                'headers' => [
                    'Ocp-Apim-Subscription-Key' => env('AZURE_OCR_SUBSCRIPTION_KEY'),
                    'Content-Type' => 'application/octet-stream',
                ],
                'body' => fopen($photoFullPath, 'r'),
            ]);

            $ocrResult = json_decode($response->getBody()->getContents(), true);
            \Log::info('OCR Result: ', $ocrResult);

            return $this->extractTextFromOCRResult($ocrResult);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $errorBody = json_decode($response->getBody()->getContents(), true);
            $errorMessage = $errorBody['error']['message'] ?? 'Unknown error occurred during OCR.';

            if (isset($errorBody['error']['innererror']['code']) && $errorBody['error']['innererror']['code'] === 'InvalidImageSize') {
                $errorMessage = 'The uploaded image is too large. Please try with a smaller image.';
            }

            throw new \Exception($errorMessage);
        } catch (\Exception $e) {
            \Log::error('Error calling Azure OCR API: ' . $e->getMessage());
            throw new \Exception('Error processing the image. Please try again or use a different image.');
        }
    }

    private function extractTextFromOCRResult($ocrResult)
    {
        $extractedWords = [];
        if ($ocrResult && isset($ocrResult['regions'])) {
            foreach ($ocrResult['regions'] as $region) {
                foreach ($region['lines'] as $line) {
                    foreach ($line['words'] as $word) {
                        $extractedWords[] = $word['text'];
                    }
                }
            }
        }
        return implode(' ', $extractedWords);
    }

    private function extractTextFromPDF($pdfPath)
    {
        try {
            $parser = new PdfParser();
            $pdf = $parser->parseFile($pdfPath);
            $extractedText = $pdf->getText();
            \Log::info('Extracted text from PDF:', ['text' => $extractedText]);
            return $extractedText;
        } catch (\Exception $e) {
            \Log::error('Error extracting text from PDF: ' . $e->getMessage());
            throw new \Exception('Unable to extract text from the PDF. Please try a different file.');
        }
    }

    private function getChatGPTResponse(Request $request, $filePath, $instructions, $subject, $steps, $explain, $level)
    {
        $text = $request->input('question') ?: '';
        return $this->sendToChatGPT(
            $text,
            $filePath,
            $instructions,
            $subject,
            $steps,
            $explain,
            $level,
            $request->input('tokensCost', 1500),
            $request->input('temperature', 0.6),
            $request->input('model', 'gpt-4-vision-preview')
        );
    }


    private function sendToChatGPT($text, $filePath, $instructions, $subject, $steps, $explain, $level, $maxTokens, $temperature, $model)
    {
        $apiKey = env('OPENAI_API_KEY');
        $endpoint = 'https://api.openai.com/v1/chat/completions';

        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey,
        ];

        $systemContent = $this->buildSystemContent($subject, $instructions, $steps, $explain, $level);

        $messages = [
            ['role' => 'system', 'content' => $systemContent],
        ];

        if ($filePath && file_exists($filePath)) {
            $base64Image = base64_encode(file_get_contents($filePath));
            $messages[] = [
                'role' => 'user',
                'content' => [
                    ['type' => 'text', 'text' => $text ?: 'Describe this image.'],
                    ['type' => 'image_url', 'image_url' => ['url' => "data:image/jpeg;base64,{$base64Image}"]]
                ]
            ];
        } else {
            $messages[] = ['role' => 'user', 'content' => $text];
        }

        $data = [
            'model' => $model,
            'messages' => $messages,
            'max_tokens' => (int) $maxTokens,
            'temperature' => (float) $temperature,
            'top_p' => 1.0,
            'n' => 1,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            \Log::error('cURL Error: ' . $error);
            throw new \Exception('Error connecting to ChatGPT. Please try again later.');
        }

        $decodedResponse = json_decode($response, true);
        \Log::info($decodedResponse);

        if (json_last_error() !== JSON_ERROR_NONE) {
            \Log::error('Error decoding JSON response from ChatGPT: ' . json_last_error_msg());
            throw new \Exception('Error processing the response from ChatGPT. Please try again.');
        }

        return $decodedResponse;
    }

    private function buildSystemContent($subject, $instructions, $steps, $explain, $level)
    {
        $content = "Do not describe the image, extract the text then do the following: You are a homework/test assistant. The current subject is: $subject. If no subject was included, include a string called \"subject=\" followed by one word from this list that best categorizes the content:
        Biology,Chemistry,Computer-Science,Economics,English,Geography,History,Mathematics,Physics,Science. Then, the first sentence should be the exact answer if its a multiple choice, select and respond with the correct answer from the list of answers given, if not solve it and provide the answer. ";
        $content .= "Your response should be structured as follows:\n";
        $content .= "first: Main content (without any specific keyword)\n";

        if ($steps) {
            $content .= "second: Keyword 'steps=' followed by numbered steps explaining key points, ending with '$#$'\n";
        }

        if ($explain) {
            $content .= "third: Keyword 'explain=' followed by an explanation of the main concepts, ending with '$#$'\n";
        }

        if ($instructions) {
            $content .= $instructions . " ";
        }

        if ($level) {
            $content .= "Ensure all content is presented at a $level level. ";
        }

        return $content;
    }

    private function processChatGPTResponse($chatGPTResponse, Request $request)
    {
        $content = $chatGPTResponse['choices'][0]['message']['content'];
        $createdAt = Carbon::createFromTimestamp($chatGPTResponse['created'] ?? time());

        $subject = $this->extractSubject($content);
        $responseBody = $this->removeSubjectFromResponse($content);

        $stepsText = $this->extractAndRemoveSection($responseBody, 'steps=');
        $explainText = $this->extractAndRemoveSection($responseBody, 'explain=');

        if (empty($stepsText) && empty($explainText)) {
            $mainContent = $responseBody;
        } else {
            $mainContent = trim($responseBody);
        }

        $title = $this->generateTitle($request->input('title'), $createdAt);

        return [
            'responseBody' => $mainContent,
            'stepsText' => $stepsText,
            'explainText' => $explainText,
            'subject' => $subject,
            'title' => $title,
            'createdAt' => $createdAt,
        ];
    }

    private function extractSubject(&$content)
    {
        preg_match('/subject=([^\s]+)/', $content, $matches);
        return isset($matches[1]) ? ucfirst($matches[1]) : null;
    }

    private function removeSubjectFromResponse($content)
    {
        return preg_replace('/\bsubject=[^\s]+(\s|$)/', '', $content);
    }

    private function extractAndRemoveSection(&$content, $keyword)
    {
        $text = "";
        if (preg_match('/' . $keyword . '([^$]*)\s*(\$#\$|$)/', $content, $matches)) {
            $text = trim($matches[1]);
            $content = preg_replace('/' . $keyword . '[^$]*(\$#\$|$)/', '', $content);
        } else {
            $content = preg_replace('/' . $keyword . '[^$]*$/', '', $content);
        }
        return $text;
    }

    private function generateTitle($requestTitle, $createdAt)
    {
        $titleFormatted = $createdAt->format('H:i d M Y');
        return $requestTitle ? "$requestTitle  |  $titleFormatted" : $titleFormatted;
    }

    private function renderResponse($processedResponse)
    {
        $remainingQuestions = $this->getRemainingPublicQuestions();

        return Inertia::render('Dashboard/PublicAsk', [
            'shouldScrollToResult' => true,
            'response' => $processedResponse['responseBody'],
            'stepsResponse' => $processedResponse['stepsText'],
            'explainResponse' => $processedResponse['explainText'],
            'remainingQuestions' => $remainingQuestions,
        ]);
    }

    private function getReadableErrorMessage(\Exception $e)
    {
        $message = $e->getMessage();

        $readableMessages = [
            'InvalidImageSize' => 'The uploaded image is too large. Please try with a smaller image.',
            'Unsupported file type.' => 'The file type you uploaded is not supported. Please try a different file.',
            'Unable to extract text from the Word document.' => 'We couldn\'t read the content of your Word document. Please try a different file or copy the text into the question field.',
            'Unable to extract text from the PDF.' => 'We couldn\'t read the content of your PDF. Please try a different file or copy the text into the question field.',
            'Error processing the image.' => 'We had trouble reading your image. Please try a different image or type your question instead.',
            'Error connecting to ChatGPT.' => 'We\'re having trouble connecting to our AI. Please try again in a few minutes.',
            'Error processing the response from ChatGPT.' => 'We received an unexpected response from our AI. Please try your question again.',
            'No response received from ChatGPT.' => 'We didn\'t get a response from our AI. Please try your question again.',
        ];

        foreach ($readableMessages as $key => $readableMessage) {
            if (strpos($message, $key) !== false) {
                return $readableMessage;
            }
        }

        // If no specific message is found, return a generic error message
        return 'An unexpected error occurred. Please try again or contact support if the problem persists.';
    }
}
