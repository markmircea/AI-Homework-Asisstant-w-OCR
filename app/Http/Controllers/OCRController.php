<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Illuminate\Support\Facades\Log; // Add this


class OCRController extends Controller
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
            try {
                // Store photo in the 'public/announcements' directory
                $photoPath = $request->file('photo')->store('public/announcements');
                \Log::info('Photo stored successfully: ' . $photoPath);
                $fullPhotoPath = storage_path('app/' . $photoPath); // Get the full path
                \Log::info('Full photo path: ' . $fullPhotoPath);

                // Extract text from the uploaded photo using Google Cloud Vision API
                $extractedText = $this->extractTextFromImage($fullPhotoPath);
                \Log::info('Extracted text: ' . $extractedText);
            } catch (\Exception $e) {
                \Log::error('Error storing photo or extracting text: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Failed to process the image.');
            }
        }

         // Create announcement with photo path and extracted text
         Auth::user()->announcements()->create([
            'title' => $request->title,
            'content' => $request->content . "\n\nExtracted Text: " . $extractedText,
            'photo_path' => $photoPath, // Assign photo path to the announcement
        ]);

        return redirect()->route('dashboard')->with('success', 'OCR created.');
    }

    private function extractTextFromImage($imagePath)
    {


        // Initialize the ImageAnnotatorClient
        $imageAnnotator = new ImageAnnotatorClient([
            'credentials' => storage_path('/app/spheric-temple-429707-m4-53e28f3ce00d.json')
        ]);

        // Read the image content
        $imageContent = file_get_contents($imagePath);

        // Prepare the image for text detection
        $image = $imageAnnotator->createImageObject($imageContent);

        // Perform text detection
        $response = $imageAnnotator->textDetection($image);

        // Extract the recognized text
        $textAnnotations = $response->getTextAnnotations();
        $fullText = isset($textAnnotations[0]) ? $textAnnotations[0]->getDescription() : '';

        // Close the client
        $imageAnnotator->close();

        return $fullText;
    }

}



