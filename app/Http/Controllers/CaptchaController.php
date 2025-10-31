<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CaptchaController extends Controller
{
    public function show()
    {
        // Generate 2-digit random number
        $captcha = rand(10, 9999);

        // Store in session
        Session::put('custom_captcha', $captcha);

        // Create image
        $width = 80;
        $height = 40;
        $image = imagecreate($width, $height);

        // Colors
        $bgColor = imagecolorallocate($image, 0, 128, 0); // green background
        $textColor = imagecolorallocate($image, 255, 255, 255); // white text

        // Fill background
        imagefilledrectangle($image, 0, 0, $width, $height, $bgColor);

        // Add text
        imagestring($image, 5, 20, 10, $captcha, $textColor);

        // Output image
        header('Content-Type: image/png');
        imagepng($image);
        imagedestroy($image);
    }
}
