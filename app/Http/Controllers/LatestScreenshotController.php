<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use App\Services\OpenAIService;

class LatestScreenshotController extends Controller
{
    protected $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    public function show()
    {
        $directory = 'screenshots';
        $files = Storage::disk('public')->files($directory);

        usort($files, function ($a, $b) {
            return Storage::disk('public')->lastModified($b) <=> Storage::disk('public')->lastModified($a);
        });

        $lastImage = Arr::first($files);

        if (empty($lastImage)) {
            return response()->json(['error' => 'No image found'], 404);
        }

        $url = Storage::disk('public')->url($lastImage);

        // Here, you can optionally use $this->openAIService for further processing
        // For example, extract text from the image or analyze it with OpenAI

        return response()->json(['latest_image_url' => $url]);
    }
}
