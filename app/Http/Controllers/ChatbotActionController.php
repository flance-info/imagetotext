<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class ChatbotActionController extends Controller {
    public function getLastImage() {
        // Define the path to the screenshots directory
        $directory = 'screenshots';
        // Retrieve all files in the directory
        $files = Storage::disk( 'public' )->files( $directory );
        // Sort files by last modified descending
        usort( $files, function ( $a, $b ) {
            return Storage::disk( 'public' )->lastModified( $b ) <=> Storage::disk( 'public' )->lastModified( $a );
        } );
        // Get the last modified file (which should be the last one)
        $lastImage = Arr::first( $files );
        // If no files found, handle the error
        if ( empty( $lastImage ) ) {
            return response()->json( [ 'error' => 'No image found' ], 404 );
        }
// Retrieve the image content
        $imageContent = Storage::disk( 'public' )->get( $lastImage );
        // Convert the image content to a base64-encoded string
        $base64Image = base64_encode( $imageContent );

        // Return the base64-encoded image in the response
        return response()->json( [
            "image" => "data:image/jpeg;base64," . $base64Image,
        ] );
    }
}

