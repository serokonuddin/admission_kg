<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        Session::put('activemenu', 'admission');
        Session::put('activesubmenu', 'tml');
        return view('registration.testimonial.index');
    }
}
