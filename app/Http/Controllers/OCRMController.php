<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use GuzzleHttp\Client;

class OCRMController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'aiquery' => 'nullable|string',
            'subject' => 'nullable|string',
            'instructions' => 'string|nullable',
            'photo' => 'nullable|image', // Validation rule for photo upload
        ]);

        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('public/announcements'); // Store photo
        }

        // Function to send text to ChatGPT API
        function sendToChatGPT($text, $instructions = null, $subject = null)
        {
            $apiKey = env('OPENAI_API_KEY'); // Replace with your ChatGPT API key
            $endpoint = 'https://api.openai.com/v1/chat/completions'; // ChatGPT API endpoint

            $headers = [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $apiKey,
            ];

            // Use provided instructions or fallback to default
            $systemContent = 'The current subject is:' . $subject . 'If the subject is auto-detect, before your response include a string called "subject=" after which you specify in one word what subject matter you believe the text to be in out of the 25 most common educational subjects' . $instructions ?? 'The current subject is:' . $subject . 'If the subject is auto-detect, before your response include a string called "subject=" after which you specify in one word what subject matter you believe the text to be in out of the 25 most common educational subjects, then Analyze the question and possible answers, select one answer from those provided. If there is no answer provided then answer the question to the best of your ability.';

            $data = [
                'model' => 'gpt-4o-mini', // or another model if applicable
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $systemContent
                    ],
                    [
                        'role' => 'user',
                        'content' => $text
                    ]
                ],
                'max_tokens' => 150, // Adjust max tokens as needed
                'temperature' => 0.4, // Adjust temperature as needed
                'top_p' => 1.0,
                'n' => 1,
                'stop' => ['\n'],
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $endpoint);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($ch);
            curl_close($ch);

            // Ensure the response is decoded correctly
            $decodedResponse = json_decode($response, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                \Log::error('Error decoding JSON response from ChatGPT: ' . json_last_error_msg());
                return null;
            }

            return $decodedResponse;
        }

        // Call Azure Computer Vision OCR
        if ($photoPath) {
            try {
                $photoFullPath = storage_path('app/' . $photoPath);

                $client = new Client();
                $response = $client->post('https://ocrphp.cognitiveservices.azure.com/vision/v3.2/ocr', [
                    'headers' => [
                        'Ocp-Apim-Subscription-Key' => '4eafdaaa1d994e2c814538d47d2276d3',
                        'Content-Type' => 'application/octet-stream',
                    ],
                    'body' => fopen($photoFullPath, 'r'),
                ]);

                $ocrResult = json_decode($response->getBody()->getContents(), true);
                \Log::info('OCR Result: ', $ocrResult);
            } catch (\Exception $e) {
                \Log::error('Error calling Azure OCR API: ' . $e->getMessage());
            }
        }

        // Initialize an empty array to collect words
        $extractedWords = [];

        // Traverse through regions and lines to extract words
        foreach ($ocrResult['regions'] as $region) {
            foreach ($region['lines'] as $line) {
                foreach ($line['words'] as $word) {
                    $extractedWords[] = $word['text'];
                }
            }
        }

        // Join the extracted words into a single string
        $extractedText = implode(' ', $extractedWords);

        // Get instructions from the request if provided
        $instructions = $request->input('instructions');
        $aiquery = $request->input('aiquery');
        $subject = $request->input('subject');

        // Send the extracted text to ChatGPT API with optional instructions
        if ($request->input('aiquery')) {
            $chatGPTResponse = sendToChatGPT($aiquery, $instructions, $subject);
        } else {
            $chatGPTResponse = sendToChatGPT($aiquery . $extractedText, $instructions, $subject);
        }

        // Ensure ChatGPT response is valid
        if ($chatGPTResponse === null || !isset($chatGPTResponse['choices'][0]['message']['content'])) {
            return redirect()->route('dashboard')->with('error', 'Error creating announcement.');
        }

        // Extract the content from the ChatGPT response
        $chatGPTContent = $chatGPTResponse['choices'][0]['message']['content'];

        // Extract the Unix timestamp from the ChatGPT response and convert to a Carbon instance
        $unixTimestamp = $chatGPTResponse['created'] ?? time();
        $createdAt = \Carbon\Carbon::createFromTimestamp($unixTimestamp);


        if(null !== $request->input('title')){
            $title = $request->input('title') . "Created: " . $createdAt;
        } else {
            $title = $createdAt;
        }



        // Extract the subject value using regex
        preg_match('/subject=([^\s]+)/', $chatGPTContent, $matches);

        // If a subject was found, capitalize the first letter
        $subject = isset($matches[1]) ? ucfirst($matches[1]) : null;

        // Remove the subject part from the response
        $responseBody = preg_replace('/\bsubject=[^\s]+(\s|$)/', '', $chatGPTContent);

        // Create announcement with photo path and created_at timestamp
        Auth::user()->announcements()->create([
            'extracted_text' => $extractedText,
            'title' => $title,
            'content' => $responseBody,
            'aiquery' => $aiquery,
            'subject' => $subject,
            'instructions' => $instructions,
            'photo_path' => $photoPath, // Assign photo path to the announcement
            'created_at' => $createdAt, // Assign the created_at timestamp
        ]);

        return redirect()->route('history')->with('success', 'Question Analyzed .');
    }
}
