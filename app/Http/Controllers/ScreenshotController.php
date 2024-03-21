<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ScreenshotController extends Controller
{
    public function store(Request $request)
    {
        // Decode the image
        $imageData = $request->input('screenshot');
        list($type, $imageData) = explode(';', $imageData);
        list(, $imageData)      = explode(',', $imageData);
        $imageData = base64_decode($imageData);

        // Create a file name
        $fileName = 'screenshots/' . uniqid() . '.png';

        // Save the image
        Storage::disk('public')->put($fileName, $imageData);

        // Generate a URL to the saved image
        $url = Storage::url($fileName);

        // Return the URL to the client
        return response()->json(['url' => $url]);
    }
}
