<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ScreenshotController extends Controller {
    public function store( Request $request ) {
        // Decode the image
        $imageData = $request->input( 'screenshot' );
        list( $type, $imageData ) = explode( ';', $imageData );
        list( , $imageData ) = explode( ',', $imageData );
        $imageData = base64_decode( $imageData );
        // Create a file name
        $fileName = 'screenshots/' . uniqid() . '.png';
        // Save the image
        Storage::disk( 'public' )->put( $fileName, $imageData );
        // Extract text from the saved image using an OCR library or API
        $extractedText = $this->extractTextFromImage( storage_path( 'app/public/' . $fileName ) );
        // Generate a URL to the saved image
        $url = Storage::url( $fileName );
        // Send the extracted text to OpenAI for analysis
        $response = $this->sendTextToOpenAI( $extractedText );

        // Return the OpenAI response to the client
        return response()->json( [
            'openai_response' => $response,
            'url'             => $url
        ] );

    }

    private function extractTextFromImage( $imagePath ) {
        // Placeholder for OCR processing
        // You need to replace this with actual OCR logic
        return 'Extracted text from the image';
    }

    private function sendTextToOpenAI( $text ) {
        $client   = new Client();
        $response = $client->post( 'https://api.openai.com/v1/completions', [
            'headers' => [
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer YOUR_OPENAI_API_KEY_HERE',
            ],
            'json'    => [
                'model'       => 'text-davinci-003', // Specify the model
                'prompt'      => $text,
                'temperature' => 0.7,
                'max_tokens'  => 150,
            ],
        ] );
        $body     = json_decode( $response->getBody(), true );

        return $body['choices'][0]['text'];
    }
}
