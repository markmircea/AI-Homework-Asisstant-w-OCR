<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use GuzzleHttp\Client;

use App\Models\Announcement;





class AskController extends Controller
{
    public function index(): Response
    {
        $user = Auth::user();
        $coins = $user->coins;

        Inertia::share('coins', $coins);

        //   $announcements = Announcement::where('user_id', $user->id)->get();
        $announcements = $user->announcements()->orderBy('order')->get();


        $announcements->transform(function ($announcement) {
            return [
                'title' => $announcement->title,
                'content' => $announcement->content,
                'user_id' => $announcement->user_id,
                'id' => $announcement->id,
                'aiquery' => $announcement->aiquery,
                'subject' => $announcement->subject,
                'extracted_text' => $announcement->extracted_text,
                'instructions' => $announcement->instructions,
                'created_at' => $announcement->created_at,
                'updated_at' => $announcement->updated_at,
                'deleted_at' => $announcement->deleted_at,
                'photo' => $announcement->photo_path ? URL::route('image', ['path' => $announcement->photo_path, 'w' => 400, 'h' => 400, 'fit' => 'crop']) : null,
            ];
        });

        // Transform the user object directly
        $userTransformed = [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'owner' => $user->owner,
            'photo' => $user->photo_path ? URL::route('image', ['path' => $user->photo_path, 'w' => 60, 'h' => 60, 'fit' => 'crop']) : null,
            'deleted_at' => $user->deleted_at,
        ];



        return Inertia::render('Ask/Index', [
            'coins' => $coins,
            'user' => $userTransformed,
            'announcements' => $announcements,
        ]);
    }




    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subject' => 'nullable|string',
            'level' => 'string|nullable',
            'question' => 'string|nullable',
            'explain' => 'boolean|nullable',
            'steps' => 'boolean|nullable',
            'photo' => 'nullable|file', // Validation rule for photo upload
        ]);

        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('public/announcements'); // Store photo
        }

        // Initialize $ocrResult as null
        $ocrResult = null;


        // Function to send text to ChatGPT API
        function sendToChatGPT($text, $instructions = null, $subject = null, $steps = null, $explain = null, $level = null)
        {
            $apiKey = env('OPENAI_API_KEY'); // Replace with your ChatGPT API key
            $endpoint = 'https://api.openai.com/v1/chat/completions'; // ChatGPT API endpoint

            $headers = [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $apiKey,
            ];



            // Use provided instructions or fallback to default
            $systemContent = 'The current subject is:' . $subject . 'If the subject is auto-detect, before your response include a string called "subject=" after which you specify in one word which of the following subjects catagorize it best: Biology,Chemistry,Computer-Science,Economics,English,Geography,History,Mathematics,Physics,Science' . $instructions ?? 'The current subject is:' . $subject . 'If the subject is auto-detect, before your response include a string called "subject=" after which you specify in one word what subject matter you believe the text to be in out of the 25 most common educational subjects, then Analyze the question and possible answers, select one answer from those provided. If there is no answer provided then answer the question to the best of your ability.';

            // Append instructions if provided
            if ($instructions) {
                $systemContent .= ' ' . $instructions;
            } else {
                $systemContent .= ' Analyze the question and possible answers, select one answer from those provided. If there are no answers provided then answer the best you can.';
            }

            // Append additional instructions based on the steps and explain flags
            if ($steps) {
                $systemContent .= ' After answering the question, Explain in numbered steps. The steps should follow the keyword steps= and should end with the delimiter $#$';
            }
            if ($explain) {
                $systemContent .= 'After the steps,  Explain why the answer is correct, The explanation should follow the keyword explain= and should end with the delimiter $#$;';
            }
            if ($level) {
                $systemContent .= ' Everything should be at a ' . $level . ' level';
            }




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
                'max_tokens' => 200, // Adjust max tokens as needed
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
            \Log::info($decodedResponse);

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

        // Traverse through regions and lines to extract words if $ocrResult is available
        if ($ocrResult && isset($ocrResult['regions'])) {
            foreach ($ocrResult['regions'] as $region) {
                foreach ($region['lines'] as $line) {
                    foreach ($line['words'] as $word) {
                        $extractedWords[] = $word['text'];
                    }
                }
            }
        }

        // Join the extracted words into a single string
        $extractedText = implode(' ', $extractedWords);

        // Get instructions from the request if provided
        $instructions = $request->input('instructions');
        $question = $request->input('question');
        $subject = $request->input('subject');
        $title = $request->input('title');
        $steps = $request->input('steps');
        $explain = $request->input('explain');
        $level = $request->input('level');


        // Send the extracted text to ChatGPT API with optional instructions
        if ($request->input('question')) {
            $chatGPTResponse = sendToChatGPT($question, $instructions, $subject, $steps, $explain, $level);
        } else {
            $chatGPTResponse = sendToChatGPT($extractedText, $instructions, $subject, $steps, $explain, $level);
        }

        // Ensure ChatGPT response is valid
        if ($chatGPTResponse === null || !isset($chatGPTResponse['choices'][0]['message']['content'])) {
            return redirect()->route('ask')->with('error', 'Nothing Submitted.');
        }

        // Extract the content from the ChatGPT response
        $chatGPTContent = $chatGPTResponse['choices'][0]['message']['content'];

        // Extract the Unix timestamp from the ChatGPT response and convert to a Carbon instance
        $unixTimestamp = $chatGPTResponse['created'] ?? time();
        $createdAt = \Carbon\Carbon::createFromTimestamp($unixTimestamp);

        if(null !== $request->input('title')){
            $title = $request->input('title') . "  |  " . $createdAt;
        } else {
            $title = $createdAt;
        }


        // Extract the subject value using regex
        preg_match('/subject=([^\s]+)/', $chatGPTContent, $matches);

        // Remove the subject part from the response
        $responseBody = preg_replace('/\bsubject=[^\s]+(\s|$)/', '', $chatGPTContent);

        // If a subject was found, capitalize the first letter
        $subject = isset($matches[1]) ? ucfirst($matches[1]) : null;


        $explainText = "";
        $stepsText = "";


        // Extract and remove 'steps=' section
        if (preg_match('/steps=([^$]*)\s*(\$#\$|$)/', $responseBody, $matches)) {
            $stepsText = trim($matches[1]);
            $responseBody = preg_replace('/steps=[^$]*(\$#\$|$)/', '', $responseBody);
        } else {
            $responseBody = preg_replace('/steps=[^$]*$/', '', $responseBody);
        }

        // Extract and remove 'explain=' section
        if (preg_match('/explain=([^$]*)\s*(\$#\$|$)/', $responseBody, $matches)) {
            $explainText = trim($matches[1]);
            $responseBody = preg_replace('/explain=[^$]*(\$#\$|$)/', '', $responseBody);
        } else {
            $responseBody = preg_replace('/explain=[^$]*$/', '', $responseBody);
        }


        $instructions = $explainText . " " . $stepsText;
        $responseBody = trim($responseBody);

        // Create announcement with photo path and created_at timestamp
        Auth::user()->announcements()->create([
            'extracted_text' => $extractedText,
            'title' => $title,
            'content' => $responseBody,
            'aiquery' => $question,
            'subject' => $subject,
            'instructions' => $instructions,
            'photo_path' => $photoPath, // Assign photo path to the announcement
            'created_at' => $createdAt, // Assign the created_at timestamp
        ]);

        $user = Auth::user();
        $coins = $user->coins;

        // Transform the user object directly
        $userTransformed = [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'owner' => $user->owner,
            'photo' => $user->photo_path ? URL::route('image', ['path' => $user->photo_path, 'w' => 60, 'h' => 60, 'fit' => 'crop']) : null,
            'deleted_at' => $user->deleted_at,
        ];



        return Inertia::render('Ask/Index', [
            'coins' => $coins,
            'user' => $userTransformed,
            'response' => $responseBody,
            'stepsResponse' => $stepsText,
            'explainResponse' => $explainText,
        ]);

        // return redirect()->route('ask')
        //->with('success', 'Question Analyzed. Response Generated.')
        //->with('response',json_encode($responseBody));
        // ->with('title', $title)
        // ->with('explain', $explain)
        // ->with('steps' , $steps);
    }
}
