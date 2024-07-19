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
            'title' => 'string|max:255',
            'content' => 'string',
            'instructions' => 'string|nullable',
            'photo' => 'nullable|image', // Validation rule for photo upload
        ]);

        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('public/announcements'); // Store photo
        }

        // Function to send text to ChatGPT API
        function sendToChatGPT($text, $instructions = null)
        {
            $apiKey = env('OPENAI_API_KEY'); // Replace with your ChatGPT API key
            $endpoint = 'https://api.openai.com/v1/chat/completions'; // ChatGPT API endpoint

            $headers = [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $apiKey,
            ];

            // Use provided instructions or fallback to default
            $systemContent = $instructions ?? 'Analyze the question and possible answers, select one answer from those provided. If there is no answer provided then answer the question to the best of your ability.';

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

        // Send the extracted text to ChatGPT API with optional instructions
        $chatGPTResponse = sendToChatGPT($extractedText, $instructions);

        // Ensure ChatGPT response is valid
        if ($chatGPTResponse === null || !isset($chatGPTResponse['choices'][0]['message']['content'])) {
            return redirect()->route('dashboard')->with('error', 'Error creating announcement.');
        }

        // Extract the content from the ChatGPT response
        $chatGPTContent = $chatGPTResponse['choices'][0]['message']['content'];

        // Extract the Unix timestamp from the ChatGPT response and convert to a Carbon instance
        $unixTimestamp = $chatGPTResponse['created'] ?? time();
        $createdAt = \Carbon\Carbon::createFromTimestamp($unixTimestamp);

        // Create announcement with photo path and created_at timestamp
        Auth::user()->announcements()->create([
            'title' => $extractedText,
            'content' => $chatGPTContent,
            'photo_path' => $photoPath, // Assign photo path to the announcement
            'created_at' => $createdAt, // Assign the created_at timestamp
        ]);

        return redirect()->route('dashboard')->with('success', 'Announcement created.');
    }
}
