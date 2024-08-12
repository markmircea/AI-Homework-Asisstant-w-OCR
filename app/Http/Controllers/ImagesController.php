<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Request;
use League\Glide\Responses\SymfonyResponseFactory;
use League\Glide\ServerFactory;

class ImagesController extends Controller
{
    public function show(Filesystem $filesystem, Request $request, $path)
    {
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
            \Log::error("File not found in any of the possible paths: " . $path);
            abort(404, 'Image not found');
        }

        \Log::info("Serving image from: " . $existingPath);

        try {
            $server = ServerFactory::create([
                'response' => new SymfonyResponseFactory($request),
                'source' => dirname($existingPath),
                'cache' => storage_path('app/.cache'),
                'cache_path_prefix' => '.glide-cache',
            ]);

            return $server->getImageResponse(basename($existingPath), $request->all());
        } catch (\Exception $e) {
            \Log::error("Error serving image: " . $e->getMessage());
            abort(500, 'Error serving image');
        }
    }
}
