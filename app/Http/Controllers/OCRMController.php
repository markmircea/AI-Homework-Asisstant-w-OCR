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
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'photo' => 'nullable|image', // Validation rule for photo upload
        ]);

        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('public/announcements'); // Store photo
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

        // Create announcement with photo path
        Auth::user()->announcements()->create([
            'title' => $request->title,
            'content' => $extractedText,
            'photo_path' => $photoPath, // Assign photo path to the announcement
        ]);

        return redirect()->route('dashboard')->with('success', 'Announcement created.');
    }
}
