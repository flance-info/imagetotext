<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/upload-screenshot', 'App\Http\Controllers\ScreenshotController@store');
Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

Route::get('/ocr', [App\Http\Controllers\OcrController::class, 'ocrImage']);


Route::get('/chatbot-action', 'App\Http\Controllers\ChatbotActionController@getLastImage');


Route::get('/openapi', function () {
    $specification = [
        "openapi" => "3.0.0",
        "info"    => [
            "title"       => "ChatGPT Text Action API",
            "description" => "API for retrieving actions and data related to the last text in storage.",
            "version"     => "1.0.0"
        ],
        "servers" => [
            [
                "url"         => "https://one-aware-mole.ngrok-free.app",
                "description" => "Main API server"
            ]
        ],
        "paths"   => [
            "/chatbot-action" => [
                "get" => [
                    "summary"     => "Retrieve the last text action",
                    "description" => "Returns an action and the text for the last entry in storage.",
                    "operationId" => "getLastTextAction",
                    "responses"   => [
                        "200" => [
                            "description" => "A successful response containing the text.",
                            "content"     => [
                                "application/json" => [
                                    "schema" => [
                                        "type"       => "object",
                                        "properties" => [
                                            "text" => [
                                                "type"    => "string",
                                                "example" => "This is the text content retrieved from the last action."
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        "404" => [
                            "description" => "No text found in storage.",
                            "content"     => [
                                "application/json" => [
                                    "schema" => [
                                        "type"       => "object",
                                        "properties" => [
                                            "error" => [
                                                "type"    => "string",
                                                "example" => "No text found"
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ];

    return new Response( $specification, 200, [ 'Content-Type' => 'application/json' ] );
} );



