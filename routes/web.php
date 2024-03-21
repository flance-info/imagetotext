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




Route::get('/chatbot-action', 'App\Http\Controllers\ChatbotActionController@getLastImage');


Route::get('/openapi', function () {
    $specification = [
        "openapi" => "3.0.0",
        "info" => [
            "title" => "ChatGPT Image Action API",
            "description" => "API for retrieving actions and data related to the last image in storage.",
            "version" => "1.0.0"
        ],
        "servers" => [
            [
                "url" => "https://5ab4-213-230-114-19.ngrok-free.app",
                "description" => "Main API server"
            ]
        ],
        "paths" => [
            "/chatbot-action" => [
                "get" => [
                    "summary" => "Retrieve the last image action",
                    "description" => "Returns an action and URL for the last image in storage.",
                    "responses" => [
                        "200" => [
                            "description" => "A successful response containing the action for the last image.",
                            "content" => [
                                "application/json" => [
                                    "schema" => [
                                        "type" => "object",
                                        "properties" => [
                                            "actions" => [
                                                "type" => "array",
                                                "items" => [
                                                    "type" => "object",
                                                    "properties" => [
                                                        "action" => [
                                                            "type" => "string",
                                                            "example" => "displayImage"
                                                        ],
                                                        "data" => [
                                                            "type" => "object",
                                                            "properties" => [
                                                                "imageUrl" => [
                                                                    "type" => "string",
                                                                    "example" => "https://5ab4-213-230-114-19.ngrok-free.app/storage/images/last-image.png"
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
                        ],
                        "404" => [
                            "description" => "No image found in storage.",
                            "content" => [
                                "application/json" => [
                                    "schema" => [
                                        "type" => "object",
                                        "properties" => [
                                            "error" => [
                                                "type" => "string",
                                                "example" => "No image found"
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

    return new Response($specification, 200, ['Content-Type' => 'application/json']);
});



