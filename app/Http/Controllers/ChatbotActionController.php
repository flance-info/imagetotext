<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class ChatbotActionController extends Controller {
    public function getLastImage() {

        $directory = 'screenshots';
        $files = Storage::disk( 'public' )->files( $directory );
        usort( $files, function ( $a, $b ) {
            return Storage::disk( 'public' )->lastModified( $b ) <=> Storage::disk( 'public' )->lastModified( $a );
        } );
        $lastImage = Arr::first( $files );
        if ( empty( $lastImage ) ) {
            return response()->json( [ 'error' => 'No image found' ], 404 );
        }
        $absolutePath = Storage::disk( 'public' )->path( $lastImage );

        // Call OCR and pass the absolute path to scan
        $text = \OCR::scan( $absolutePath );

        return response()->json( [
            "text" => $text,
        ] );

    }
}

