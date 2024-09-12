<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class TestHackedController extends Controller
{
    public function index()
    {
        return Inertia::render('TestHacked/Index');
    }

    public function uploadImage(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $file = $request->file('image');
            $filePath = $this->handleFileUpload($file);

            $claudeResponse = $this->getClaudeResponse($filePath);

            return Inertia::render('TestHacked/Index', [
                'analysis' => $claudeResponse,
            ]);
        } catch (\Exception $e) {
            Log::error('Error in TestHackedController@uploadImage: ' . $e->getMessage());
            return Inertia::render('TestHacked/Index', [
                'error' => $this->getReadableErrorMessage($e),
            ]);
        }
    }

    private function handleFileUpload($file)
    {
        $path = $file->store('uploads', 'public');
        return Storage::disk('public')->path($path);
    }

    private function getClaudeResponse($filePath)
    {
        $apiKey = env('ANTHROPIC_API_KEY');
        $endpoint = 'https://api.anthropic.com/v1/messages';

        $headers = [
            'Content-Type: application/json',
            'x-api-key: ' . $apiKey,
            'anthropic-version: 2023-06-01',
        ];

        $fileContent = base64_encode(file_get_contents($filePath));
        $mimeType = mime_content_type($filePath);

        $messages = [
            [
                'role' => 'user',
                'content' => [
                    ['type' => 'text', 'text' => 'Do not describe the image, extract the text and respond with the correct result.'],
                    ['type' => 'image', 'source' => ['type' => 'base64', 'media_type' => $mimeType, 'data' => $fileContent]]
                ]
            ]
        ];

        $data = [
            'model' => 'claude-3-sonnet-20240229',
            'messages' => $messages,
            'max_tokens' => 1000,
            'temperature' => 0.7,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $decodedResponse = json_decode($response, true);

        if ($httpCode !== 200) {
            Log::error("Error response from Claude API (HTTP $httpCode):", ['response' => $decodedResponse]);
            throw new \Exception("Error from Claude API: " . ($decodedResponse['error']['message'] ?? 'Unknown error'));
        }

        return $decodedResponse['content'][0]['text'] ?? 'No analysis available';
    }

    private function getReadableErrorMessage(\Exception $e)
    {
        $message = $e->getMessage();

        $readableMessages = [
            'InvalidImageSize' => 'The uploaded image is too large. Please try with a smaller image.',
            'Error processing the image.' => 'We had trouble reading your image. Please try a different image.',
            'Error connecting to Claude.' => 'We\'re having trouble connecting to our AI. Please try again in a few minutes.',
            'Error processing the response from Claude.' => 'We received an unexpected response from our AI. Please try uploading the image again.',
            'No response received from Claude.' => 'We didn\'t get a response from our AI. Please try uploading the image again.',
        ];

        foreach ($readableMessages as $key => $readableMessage) {
            if (strpos($message, $key) !== false) {
                return $readableMessage;
            }
        }

        return 'An unexpected error occurred. Please try again or contact support if the problem persists.';
    }
}
