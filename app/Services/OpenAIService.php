<?php

namespace App\Services;

use GuzzleHttp\Client;

class OpenAIService {

    public function extractTextFromImage( $imagePath ) {
        // Assuming you have an OCR package or facade configured
        $text = \OCR::scan( $imagePath );

        return $text;
    }

    public function sendTextToOpenAI( $text ) {
        $client   = new Client();
        $response = $client->post( 'https://api.openai.com/v1/completions', [
            'headers' => [
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer ' . env( 'OPENAI_API_KEY' ),
            ],
            'json'    => [
                'model'       => 'text-davinci-003', // Specify the model
                'prompt'      => $text,
                'temperature' => 0.7,
                'max_tokens'  => 150,
            ],
        ] );
        $body = json_decode( $response->getBody(), true );

        return $body['choices'][0]['text'];
    }

}
