<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Alimranahmed\LaraOCR\Facades\OCR;
use Illuminate\Support\Facades\Storage;

class OcrController extends Controller {
    public function ocrImage() {
        $imagePath = public_path( 'storage/screenshots/65fc3211781db.png' );
//$absolutePath = Storage::disk('public')->path($lastImage);
       //echo file_get_contents($imagePath);
       // echo $imagePath;
        $ocrText = OCR::scan( $imagePath );

        // Use $ocrText as needed in your application
        return response()->json( [ 'text' => $ocrText ] );
    }
}
