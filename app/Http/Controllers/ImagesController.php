<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Request;
use League\Glide\Responses\SymfonyResponseFactory;
use League\Glide\ServerFactory;
use Illuminate\Support\Facades\Log;

class ImagesController extends Controller
{
    public function show(Filesystem $filesystem, Request $request, $path)
    {
        Log::info("ImagesController: Received path", ['path' => $path]);

        // Check if the path is a full URL
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            Log::info("ImagesController: Redirecting to external URL", ['url' => $path]);
            return redirect($path);
        }

        // If it's not a full URL, proceed with local file handling
        $possiblePaths = [
            storage_path('app/public/' . $path),
            storage_path('app/' . $path),
            public_path('storage/' . $path)
        ];

        $existingPath = null;
        foreach ($possiblePaths as $possiblePath) {
            if (file_exists($possiblePath)) {
                $existingPath = $possiblePath;
                break;
            }
        }

        if (!$existingPath) {
            Log::error("ImagesController: File not found in any of the possible paths", ['path' => $path]);
            abort(404, 'Image not found');
        }

        Log::info("ImagesController: Serving image from", ['path' => $existingPath]);

        try {
            $server = ServerFactory::create([
                'response' => new SymfonyResponseFactory($request),
                'source' => dirname($existingPath),
                'cache' => storage_path('app/.cache'),
                'cache_path_prefix' => '.glide-cache',
            ]);

            return $server->getImageResponse(basename($existingPath), $request->all());
        } catch (\Exception $e) {
            Log::error("ImagesController: Error serving image", ['error' => $e->getMessage()]);
            abort(500, 'Error serving image');
        }
    }
}
