@extends('frontend-new.layout')
@section('content')
    @php
        $colors = [
            'bg-primary',
            'bg-danger',
            'bg-success',
            'bg-info',
            'bg-purple',
            ' bg-pink',
            'bg-primary',
            'bg-danger',
            'bg-success',
            'bg-info',
            'bg-purple',
            ' bg-pink',
            'bg-primary',
            'bg-danger',
            'bg-success',
            'bg-info',
            'bg-purple',
            ' bg-pink',
            'bg-primary',
            'bg-danger',
            'bg-success',
            'bg-info',
            'bg-purple',
            ' bg-pink',
            'bg-primary',
            'bg-danger',
            'bg-success',
            'bg-info',
            'bg-purple',
            ' bg-pink',
            'bg-primary',
            'bg-danger',
            'bg-success',
            'bg-info',
            'bg-purple',
            ' bg-pink',
        ];
        $cs = ['primary', 'danger', 'success', 'info', 'purple', ' pink'];
        $icons = [
            'fas fa-home',
            'far fa-building',
            'fas fa-graduation-cap',
            'fas fa-balance-scale',
            'fas fa-biking',
            'fas fa-certificate',
            'fas fa-comment-dots',
            'fas fa-camera-retro',
            'fas fa-map',
            'bg-info',
            'bg-purple',
            ' bg-pink',
            'bg-primary',
            'bg-danger',
            'bg-success',
            'bg-info',
            'bg-purple',
            ' bg-pink',
            'bg-primary',
            'bg-danger',
            'bg-success',
            'bg-info',
            'bg-purple',
            ' bg-pink',
            'bg-primary',
            'bg-danger',
            'bg-success',
            'bg-info',
            'bg-purple',
            ' bg-pink',
            'bg-primary',
            'bg-danger',
            'bg-success',
            'bg-info',
            'bg-purple',
            ' bg-pink',
        ];
    @endphp
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/animate.css') }}" /> -->
    <style>
        .owl-carousel .owl-item img {
            display: block;
            width: 100%;
            height: 200px;
        }


        .text-capitalize:hover {
            font-size: 2rem !important;
        }

        .hesperiden .tp-bullet {
            background: linear-gradient(to bottom, #b62020 0%, #1781b9 100%) !important;
        }

        .hesperiden .tp-bullet:hover,
        .hesperiden .tp-bullet.selected {
            background: green !important;
        }



        .text-white {
            color: white;
            font-weight: bold;
        }

        .blink-hard {
            animation: blinker 1s step-end infinite;
        }

        .blink-soft {
            animation: blinker 1.5s linear infinite;
        }

        .notice_portion a {
            font-size: 15px;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
    </style>

    <style>
        .fade-out {
            position: absolute;
            bottom: 0px;
            /* Adjust based on button position */
            left: 0;
            right: 0;
            height: 157px;
            /* Adjust as needed */
            background: linear-gradient(transparent, black);
            /* Fade effect */

        }

        .read-more {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            padding: 10px 20px;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            background: unset;
        }

        .hero.hero-homepage-video {
            height: auto;
            min-height: auto;
            opacity: 1;
            -webkit-animation-name: showvideo;
            animation-name: showvideo;
            -webkit-animation-duration: 2s;
            animation-duration: 2s;
        }

        .hero {
            background-size: cover;
            /* background-color: #000; */
            background-color: #84BED6;
            color: #fff;
        }

        .hero__shadows {
            position: absolute;
            height: 100%;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 2;
        }

        .hero.hero-homepage-video .hero__shadows:before {
            position: absolute;
            left: 0;
            bottom: 0;
            content: '';
            display: block;
            width: 100%;

            background-image: linear-gradient(180deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.77) 100%);
            opacity: 0.8;
            height: 359px;
        }

        .hero.hero-homepage-video .video {
            display: block;
            margin: 0;
        }

        .video {
            position: relative;
        }

        .video-inline {
            position: relative;
        }

        .hero {
            background-size: cover;
            /* background-color: #000; */
            color: #fff;
            min-height: 400px;
            position: relative;
        }

        .video-inline__video {
            pointer-events: none;
        }

        video {
            object-fit: contain;
            overflow-clip-margin: content-box;
            overflow: clip;
        }

        .video-button {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 2;
            border: none;
            background: none;
        }

        button {

            appearance: none;
            font-family: "Roboto", Helvetica, Arial, sans-serif;
            padding: 0;
        }

        .video-button::before {
            content: '';
            display: block;
            width: 100%;
            bottom: 0;
            top: 0;
            left: 0;
            opacity: 0.6;
            background-image: radial-gradient(50% 147%, rgba(0, 0, 0, 0) 48%, #000000 100%);
        }

        .hero.hero-homepage-video.hero--text-left .video-button__circle {
            right: 27px;
            left: initial;
        }

        .video-button__circle {
            background: rgba(0, 0, 0, 0.23);
            border: 2px solid rgba(255, 255, 255, 0.55);
            border-radius: 100%;
            width: 43px;
            height: 43px;
            position: absolute;
            bottom: 34px;
        }

        .video-button--pause .icon {
            background: url({{ asset('public/assets/img/icon-pause.svg') }}) no-repeat 50% 50%;
        }

        .video-button .icon {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }

        .sr-only,
        .a11y,
        .access {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            clip-path: inset(50%);
            border: 0;
        }

        .video-button::after {
            content: '';
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .hero.hero-homepage-video .contain {
            z-index: initial;
        }

        .hero .contain {
            margin: 0 auto;
            position: relative;
            height: 100%;
        }

        .contain--wide {
            max-width: 1450px;
        }

        .contain {
            padding: 0 20px;
            width: 100%;
        }

        .hero__content {
            height: 130px;
            margin-left: 20px;
            margin-top: 15px;
            /* position: absolute;
                                                                                                                                                                                  left: 0;
                                                                                                                                                                                  top: 0;
                                                                                                                                                                                  z-index: 2;
                                                                                                                                                                                  margin-top: -630px;
                                                                                                                                                                                  width: 35%; */
        }

        .hero__text {}

        .hero__text {
            transition: all .25s ease-in-out;

        }

        .hero__category {
            font-family: "Roboto", Helvetica, Arial, sans-serif;
            font-weight: 700;
            font-size: 1.4rem;
            color: #FFF;
            letter-spacing: 1.8px;
            text-transform: uppercase;
            margin: 0 0 25px;
            text-decoration: none;
        }

        .hero__link {
            color: #FFF;
            text-decoration: none;
            display: block;
            position: relative;
        }

        .hero__title {
            font-size: 2rem;
            font-family: Bradley Hand ITC !important;
            font-style: italic;
            font-weight: bold;
        }

        .hero__excerpt {
            font-size: 1.12rem;
            color: #FFF;
            line-height: 1.631578947;
            font-family: bradley;
            margin: 0;
            height: 0;
            opacity: 1;
            transition: visibility .125s linear .25s, opacity .25s;
        }

        @media (max-width: 768px) {
            .hero__title {
                font-size: 1rem;
            }

            /* .hero__content {
                                                                                                                                                                                      margin-top: auto;
                                                                                                                                                                                      width: 100%;
                                                                                                                                                                                      height: 150px;
                                                                                                                                                                                      position: absolute;
                                                                                                                                                                                      left: 0;
                                                                                                                                                                                      bottom: 0;
                                                                                                                                                                                      z-index: 2;
                                                                                                                                                                                      padding-top: 0;
                                                                                                                                                                                  } */
            .hero__content {
                margin: 18px 0 18px 0;
            }

        }
    </style>

    <style>
        .media-events-list {
            flex-direction: column;
            align-items: center;
        }

        .media-events-list .media-img {
            width: 100%;
        }

        .media-events-list .media-img img {
            height: 450px;
        }

        .media-img-overlay {
            position: absolute;
            top: auto;
            right: 0;
            bottom: 0;
            left: 0;
        }

        .badge-rounded {
            width: 100%;
            border-radius: 0px;
        }

        @media (max-width: 768px) {
            .hero__title {
                font-size: 2rem !important;
            }

            .media-events-list .media-img img {
                height: 280px;
            }

            .notice_portion a {
                font-size: 19px;
            }
        }

        .first {
            font-size: 48px;
            opacity: 0.8;
            font-weight: bold;
        }

        .second {
            font-size: 18px;
            opacity: 0.8;
        }

        .btn-quickview {
            height: 117px;
            line-height: 30px;
            opacity: 1;
            visibility: visible;
            font-size: 32px;
            font-weight: bold;
            background-color: unset !important;
            text-align: left;
            font-family: book antiqua;
            text-transform: none;
        }

        .btnhover:hover {
            background-color: unset !important;
            color: #fff !important;
        }

        .hidden-content {}

        .hiddencontent1 {
            display: none;
            font-family: book antiqua;
        }

        .hidden-content2,
        .hidden-content4 {
            height: 230px;
            display: none;
        }

        .btnD {
            border: none !important;
            background: #ff0000 !important;
            color: #fff !important;
            font-size: 18px !important;
            padding: 10px 20px !important;
            font-weight: 700 !important;
            transition: .5s !important;

        }

        .btnD:hover {
            border: none !important;
            background: #ff0000 !important;
            color: #fff !important;
            font-size: 18px !important;
            padding: 10px 20px !important;
            font-weight: 700 !important;
            transition: .5s !important;
        }

        .d-block a:hover {
            color: black !important;
        }

        /* Custom button styles (smaller version) */
        .custom-btn-search,
        .custom-btn-close {
            display: inline-block;
            padding: 8px 16px;
            /* Reduced padding */
            font-size: 14px;
            /* Smaller font size */
            font-weight: bold;
            text-transform: uppercase;
            border: none;
            border-radius: 20px;
            /* Slightly smaller radius */
            transition: all 0.3s ease-in-out;
            cursor: pointer;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Subtle shadow */
        }

        /* Close Button */
        .custom-btn-close {
            background-color: #f44336;
            /* Red */
            color: white;
            border: 1px solid #f44336;
        }

        .custom-btn-close:hover {
            background-color: white;
            color: #f44336;
            border: 1px solid #f44336;
            transform: scale(1.05);
        }

        /* Search Button */
        .custom-btn-search {
            background-color: #00ADEF;
            /* Custom Blue */
            color: white;
            border: 1px solid #00ADEF;
        }

        .custom-btn-search:hover {
            background-color: white;
            color: #00ADEF;
            border: 1px solid #00ADEF;
            transform: scale(1.05);
        }

        /* Button focus effect */
        .custom-btn-search:focus,
        .custom-btn-close:focus {
            outline: none;
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.2);
        }

        
        @media (min-width: 768px) {
            .animate-on-scroll {
                opacity: 0;
                transform: translateY(30px);
                transition: all 0.5s ease-in-out;
            }

            /* Visible state once it scrolls into view */
            .animate-on-scroll.animate {
                opacity: 1;
                transform: translateY(0);
            }
            .left-to-right {
                position: absulate;
                opacity: 0;
                transform: translateX(-100%);
                transition: all .5s ease-in-out;
            }

            .left-to-right.animate {
                opacity: 1;
                transform: translateX(0);
            }

            /* Right to Left Animation */
            .right-to-left {
                position: absulate;
                opacity: 0;
                transform: translateX(100%);
                transition: all .5s ease-in-out;
            }

            .right-to-left.animate {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>

    <div class="main-wrapper home">


        <!--====================================
                                                                                                                                                                            ——— BEGIN MAIN SLIDE LIST
                                                                                                                                                                            ===================================== -->
        <section class="rev_slider_wrapper fullwidthbanner-container over" dir="ltr">

            <!-- the ID here will be used in the JavaScript below to initialize the slider -->
            <div id="rev_slider_1" class="rev_slider  rev-slider-kidz-school" data-version="5.4.5" style="display:none">

                <ul>
                    <!-- SLIDE 1  -->
                    @foreach ($sliders as $key => $slider)
                        <li data-transition="fade">
                            <img src="{{ asset($slider->image) }}" alt="Sky" class="rev-slidebg">
                            <div class="tp-bgimg defaultimg"
                                style="background-repeat: no-repeat;
            background-image: url('{{ asset($slider->image) }}');
            background-size: cover;
            background-position: center center;
            width: 100%;
            height: 100%;
            opacity: 1;
            visibility: inherit;
            z-index: 20;">
                            </div>
                        </li>
                    @endforeach

                </ul>
            </div>
        </section>

        <!-- ====================================
                                                                                                                                                                            ———	BOX SECTION
                                                                                                                                                                            ===================================== -->
        <section class="d-sm-block section-top">
            <div class="container">
                <div class="row wow fadeInUp">

                    <!-- Notice Section -->
                    <div class="col-12 col-md-3 mb-3   ">
                        <a href="{{ url('page', 'students-notice') }}">
                            <div class="card bg-info card-hover section" style="height: 229px;">
                                <div class="card-body text-center p-0">
                                    <div class="card-icon-border-large border-info">
                                        <i class="fa fa-bell" aria-hidden="true"></i>
                                    </div>
                                    <h2 class="text-white font-size-32 pt-1 pt-lg-5 pb-2 pb-lg-6 mb-0 font-dosis">Notice
                                    </h2>
                                    <div style="position: relative;bottom: 8px;" class="notice_portion">
                                        @foreach ($notices as $notice)
                                            <a href="{{ url('detiales', $notice->id) }}" class="pb-4 pb-lg-5"
                                                style="font-style: italic;color: #AA5486;font-weight: bold">
                                                <div>&#x2022; {{ $notice->title }}</div>
                                            </a>
                                        @endforeach

                                        {{-- <a href="https://bafsd.edu.bd/detiales/115" class="pb-4 pb-lg-5 blink-hard"
                                            style="font-style: italic;color: #00a9c4;font-weight: bold">
                                            <div style="">&#x2022; দরপত্র বিজ্ঞপ্তি</div>
                                        </a>
                                        <a href="https://bafsd.edu.bd/detiales/114" class="pb-4 pb-lg-5"
                                            style="font-style: italic;color: #AA5486;font-weight: bold">
                                            <div style="">&#x2022; স্থায়ী শিক্ষক-কর্মচারী নিয়োগ শ্রেণিকক্ষে
                                                পাঠদান/ব্যবহারিক পরীক্ষার (০৮ জানু ২৫) ফলাফল</div>
                                        </a> --}}
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Online Admission Section -->
                    <div class="col-12 col-md-3 mb-3  ">
                        {{-- <a href="{{ route('admissionviewkg') }}"> --}}
                        <div class="card bg-success card-hover  " style="height: 229px;">
                            <div class="card-body text-center p-0">
                                <div class="card-icon-border-large border-success">
                                    <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                                </div>
                                <h2 class="text-white font-size-32 pt-1 pt-lg-5 pb-2 pb-lg-6 mb-0 font-dosis">Online
                                    Admission</h2>
                                 <a class="findAdmitcard"
                                    style="font-style: italic;color: #00a4e3;font-size: 20px;font-weight: bold; cursor: pointer">Get
                                    Admit Card</a> <br>
                                <a href="{{ route('admissionviewxi') }}" class="pb-4 pb-lg-5"
                                    style="font-style: italic;color: yellow;font-size: 20px;font-weight: bold;">
                                    KG admission
                                </a> 
                                <!-- <p class="text-lg font-dosis mb-2" style="color: red; font-weight: bold; font-size: 16px">🚫
                                    Online Admission
                                    is Closed</p>
                                <p class="text-sm font-dosis" style="color: black">There are no ongoing admissions at the
                                    moment. Please stay
                                    tuned for
                                    updates.</p> -->
                            </div>
                        </div>
                        {{-- </a> --}}
                    </div>

                    <!-- Online Payment Section -->
                    <div class="col-6 col-md-3 mb-3   ">
                        <a href="https://epay.dutchbanglabank.com/bafshaheen/StudentLogIn.aspx">
                            <div class="card bg-primary card-hover " style="height: 229px;">
                                <div class="card-body text-center p-0">
                                    <div class="card-icon-border-large border-primary">
                                        <i class="far fa-credit-card" aria-hidden="true"></i>
                                    </div>
                                    <h2 class="text-white font-size-32 pt-1 pt-lg-5 pb-2 pb-lg-6 mb-0 font-dosis">Online
                                        Payment</h2>
                                    <div class="d-flax">
                                        <a href="https://epay.dutchbanglabank.com/bafshaheen/StudentLogIn.aspx"
                                            class="text-white font-size-20">
                                            <img src="{{ asset('public/assets/dbbl.jpg') }}" style="width: 100px">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- My Portal Section -->
                    <div class="col-6 col-md-3 mb-3 ">
                        <a class="text-white font-weight-medium opacity-80" href="javascript:void(0)" data-bs-toggle="modal"
                            data-bs-target="#modal-login">
                            <div class="card bg-danger card-hover " style="height: 229px;">
                                <div class="card-body text-center p-0">
                                    <div class="card-icon-border-large border-danger">
                                        <i class="fas fa-users" aria-hidden="true"></i>
                                    </div>
                                    <h2 class="text-white font-size-32 pt-1 pt-lg-5 pb-2 pb-lg-6 mb-0 font-dosis">My Portal
                                    </h2>
                                    <p class="pb-4 pb-lg-5"
                                        style="font-family: cursive;color: yellow;font-size: 18px; font-weight: bold">
                                        Login to Your Portal
                                    </p>
                                    {{-- <a href="#" class="pb-4 pb-lg-5 blink-hard"
                                        style="font-family: cursive;color: yellow;font-size: 17px;">
                                        Coming Soon
                                    </a> --}}
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </section>


        <!-- ====================================
                                                                                                                                                                            ———	HOME FEATURE
                                                                                                                                                                            ===================================== -->
        {{-- <section class="pt-6 pb-6 py-md-7">
            <div class="container">
                <div class="section-title justify-content-center mb-4 mb-md-8 wow fadeInUp">
                    <h2 class="text-danger" style="font-family: Viner hand ITC">Take a Tour</h2>
                </div>
                <div class="row wow fadeInUp">
                    <!-- Media -->
                    <div class="col-md-12">

                        <div class="card hero-homepage hero hero--light   hero--text-left background--center-center hero-homepage-video"
                            style="--bs-card-spacer-x: 0px!important">
                            //history-of-the-college
                            <a href="{{ url('page/a-glance-into-the-past') }}" class="hero__link">
                                <div class="video">
                                    <div class="video-inline video-autoplay">
                                        <div class="fitvid"
                                            style="width: 100%; height: 0px; position: relative; padding-top: 56.25%;">
                                            <video loop="" muted="" playsinline="" autoplay="autoplay"
                                                class="video-inline__video " data-fitvid="56.25"
                                                style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%;">
                                                <source src="{{ asset('public/assets/videos/baf.mp4') }}" type="video/mp4">
                                            </video>
                                        </div>
                                        <button class="video-button video-button--play-toggle video-button--pause">
                                            <span class="video-button__circle">
                                                <span class="icon"></span>
                                            </span>
                                            <span class="a11y">pause</span>
                                        </button>
                                    </div>
                                </div>
                            </a>
                            <div class="contain contain--wide">
                                <div class="hero__content">
                                    <div class="hero__text">
                                        <a href="{{ url('page/a-glance-into-the-past') }}" class="hero__link">
                                            <h1 class="hero__title">A Glance into the Past........</h1>
                                            <p class="hero__excerpt">BAF Shaheen College Dhaka is one of the most
                                                prestigious educational institutions in the country. It is established on
                                                March 1, 1960, as "Shaheen School,"..........</p>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
        </section> --}}

        {{-- <section class="pt-9 pb-6 py-md-7" style="background-color: red">
  <div class="container">
    <div class="row wow fadeInUp">
			<!-- Media -->
      <div class="col-md-12">

          <div class="contain contain--wide">
            <div class="hero__content">
              <div class="hero__text">
              <a href="{{url('page/a-glance-into-the-past')}}" class="hero__link">
                <h1 class="hero__title">A Glance into the <br>Past........</h1>
                <p class="hero__excerpt">BAF Shaheen College Dhaka is one of the most prestigious educational institutions in the country. It is established on March 1, 1960, as "Shaheen School,"..........</p>
                </a>
              </div>
            </div>
          </div>
      </div>
    </div>
</section>   --}}


        <!-- ====================================
                                                                                                                                                                            ———	DOMAINS SECTION
                                                                                                                                                                            ===================================== -->
        <section class="py-5" id="courses">
            <div class="">
                <div class="section-title justify-content-center mb-4 mb-md-8">
                    {{-- <span class="shape shape-left bg-info"></span> --}}
                    <h2 class="text-danger">Our Domains</h2>
                    {{-- <span class="shape shape-right bg-info"></span> --}}
                </div>

                <div class="row">
                    <div class="col-sm-6 col-lg-4 col-xs-12">
                        <div class="card section">
                            <a href="{{ url('from-campus') }}" class="position-relative">
                                <img class="card-img-top lazyestload" data-src="{{ asset('public/FromCampus.jpg') }}"
                                    src="{{ asset('public/FromCampus.jpg') }}" alt="Card image">
                            </a>
                            <div class="card-body border-top-5 px-3 border-primary">
                                @if ($fromCampus->count())
                                    @foreach ($fromCampus as $article)
                                        <p>
                                            <a style="text-decoration: underline;"
                                                href="{{ url('details/' . $article->id) }}">
                                                {{ $article->article_title }}
                                            </a>
                                        </p>
                                    @endforeach
                                @else
                                    <p>No articles available.</p>
                                @endif
                                <div class="d-block">
                                    <a href="{{ url('from-campus') }}"
                                        class="btn btn-link text-hover-primary ps-2 ps-lg-0">
                                        <i class="fas fa-angle-double-right me-1" aria-hidden="true"></i> More
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-4 col-xs-12">
                        <div class="card section">
                            <a href="{{ url('student-corner') }}" class="position-relative">
                                <img class="card-img-top lazyestload" data-src="{{ asset('public/1.jpg') }}"
                                    src="{{ asset('public/1.jpg') }}" alt="Card image">
                            </a>
                            <div class="card-body border-top-5 px-3 border-primary">

                                @if ($studentCorner->count())
                                    @foreach ($studentCorner as $article)
                                        <p>
                                            <a style="text-decoration: underline;"
                                                href="{{ url('details/' . $article->id) }}">
                                                {{ $article->article_title }}
                                            </a>
                                        </p>
                                    @endforeach
                                @else
                                    <p>No articles available.</p>
                                @endif

                                <div class="d-block">
                                    <a href="{{ url('student-corner') }}"
                                        class="btn btn-link text-hover-primary ps-2 ps-lg-0">
                                        <i class="fas fa-angle-double-right me-1" aria-hidden="true"></i> More
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Card -->
                    <div class="col-sm-6 col-lg-4 col-xs-12">
                        <div class="card section">
                            <a href="{{ url('page/photo-gallery') }}" class="position-relative">
                                <img class="card-img-top lazyestload" data-src="{{ asset('public/photo_archive2.jpg') }}"
                                    src="{{ asset('public/photo_archive.jpg') }}" alt="Card image">
                                <!-- <div class="card-img-overlay">
                                                                                                                                                                                          <span class="badge bg-danger badge-rounded-circle">$50</span>
                                                                                                                                                                                        </div> -->
                            </a>
                            <div class="card-body border-top-5 px-3 border-danger">
                                <h3 class="card-title">
                                    <a class="text-danger text-capitalize d-block text-truncate"
                                        href="{{ url('page/photo-gallery') }}" style="color: #000000 !important"></a>
                                </h3>
                                <!-- <ul class="list-unstyled text-muted">
                                                                                                                                                                                          <li class="mb-1">
                                                                                                                                                                                            <i class="far fa-calendar me-2" aria-hidden="true"></i>Age 2 to 4 Years
                                                                                                                                                                                          </li>
                                                                                                                                                                                          <li>
                                                                                                                                                                                            <i class="far fa-clock me-2" aria-hidden="true"></i>9.00AM-11.00AM
                                                                                                                                                                                          </li>
                                                                                                                                                                                        </ul> -->
                                <p> All over the world, human beings create an immense and ever-increasing volume of data,
                                    with new kinds of data regularly... </p>
                                <div class="d-block">
                                    <!-- <a href="product-cart.html" class="btn btn-white text-uppercase mb-1 btn-hover-danger">
                                                                                                                                                                                            <i class="fas fa-shopping-basket me-2" aria-hidden="true"></i>Add to Cart
                                                                                                                                                                                          </a> -->
                                    <a href="{{ url('/page/photo-gallery') }}"
                                        class="btn btn-link text-hover-danger ps-2 ps-lg-0">
                                        <i class="fas fa-angle-double-right me-1" aria-hidden="true"></i> More
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4 col-xs-12">
                        <div class="card section  ">
                            <a href="{{ url('pages/clubs') }}" class="position-relative">
                                <img class="card-img-top lazyestload"
                                    data-src="https://bafsd.edu.bd/public/storage/photos/4/new_club.jpg"
                                    src="https://bafsd.edu.bd/public/storage/photos/4/new_club.jpg" alt="Card image">
                                <!-- <div class="card-img-overlay">
                                                                                                                                                                                          <span class="badge bg-success badge-rounded-circle">$50</span>
                                                                                                                                                                                        </div> -->
                            </a>
                            <div class="card-body border-top-5 px-3 border-success">
                                <h3 class="card-title">
                                    <a class="text-success text-capitalize d-block text-truncate"
                                        href="{{ url('pages/clubs') }}" style="color: #000000 !important">Our Clubs </a>
                                </h3>
                                <!-- <ul class="list-unstyled text-muted">
                                                                                                                                                                                          <li class="mb-1">
                                                                                                                                                                                            <i class="far fa-calendar me-2" aria-hidden="true"></i>Age 2 to 4 Years
                                                                                                                                                                                          </li>
                                                                                                                                                                                          <li>
                                                                                                                                                                                            <i class="far fa-clock me-2" aria-hidden="true"></i>9.00AM-11.00AM
                                                                                                                                                                                          </li>
                                                                                                                                                                                        </ul> -->
                                <p> All over the world, human beings create an immense and ever-increasing volume of data,
                                    with new kinds of data regularly... </p>
                                <div class="d-block">

                                    <a href="course-single-left-sidebar.html"
                                        class="btn btn-link text-hover-success ps-2 ps-lg-0">
                                        <i class="fas fa-angle-double-right me-1" aria-hidden="true"></i> More
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Card -->
                    <div class="col-sm-6 col-lg-4 col-xs-12">
                        <div class="card section right-to-left">
                            <a href="https://baf.mil.bd/index.php" class="position-relative">
                                <img class="card-img-top lazyestload"
                                    data-src="{{ asset('/') }}public/frontend/uploads/images/airforce.jpg"
                                    src="{{ asset('/') }}public/frontend/uploads/images/baf.png" alt="Card image">
                                <!-- <div class="card-img-overlay">
                                                                                                                                                                                          <span class="badge bg-primary badge-rounded-circle">$50</span>
                                                                                                                                                                                        </div> -->
                            </a>
                            <div class="card-body border-top-5 px-3 border-primary">
                                <h3 class="card-title">
                                    <a class="text-primary text-capitalize d-block text-truncate"
                                        href="https://baf.mil.bd/index.php" style="color: #000000 !important">Bangladesh
                                        Air Force (BAF)</a>
                                </h3>
                                <!-- <ul class="list-unstyled text-muted">
                                                                                                                                                                                          <li class="mb-1">
                                                                                                                                                                                            <i class="far fa-calendar me-2" aria-hidden="true"></i>Age 2 to 4 Years
                                                                                                                                                                                          </li>
                                                                                                                                                                                          <li>
                                                                                                                                                                                            <i class="far fa-clock me-2" aria-hidden="true"></i>9.00AM-11.00AM
                                                                                                                                                                                          </li>
                                                                                                                                                                                        </ul> -->

                                <p> The origin of Bangladesh Air Force (BAF) dates back to 1920 in British India when the
                                    Indian politicians demanded.... </p>
                                <div class="d-block">

                                    <a href="https://baf.mil.bd/index.php"
                                        class="btn btn-link text-hover-primary ps-2 ps-lg-0">
                                        <i class="fas fa-angle-double-right me-1" aria-hidden="true"></i> More
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <!-- ====================================
                                                                                                                                                                            ———	CALL TO ACTION
                                                                                                                                                                            ===================================== -->
        <section class="py-10 bg-parallax"
            style="background-image: url({{ asset('public/') }}/assets/1-min.jpg); padding-bottom: 10.25rem !important;">
            <div class="container">
                <!-- <div class="wow fadeInUp">
                                                                                                                                                                                  <div class="section-title justify-content-center">
                                                                                                                                                                                    <h2 class="text-white text-center">Need More Information?</h2>
                                                                                                                                                                                  </div>
                                                                                                                                                                                  <div class="text-center">
                                                                                                                                                                                    <p class="text-white font-size-18 mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod</p>
                                                                                                                                                                                    <a href="contact-us.html" class="btn btn-danger shadow-sm text-uppercase mt-4">
                                                                                                                                                                                      <i class="fas fa-phone-alt me-2" aria-hidden="true"></i>Contact
                                                                                                                                                                                    </a>
                                                                                                                                                                                  </div>
                                                                                                                                                                                </div> -->
            </div>
        </section>


        <section class="py-9 pb-8 bg-parallax"
            style="background-image: url({{ asset('public/') }}/storage/photos/4/Slider%20Photo/11-min.jpg);">
            <div class="container section ">
                <div class="section-title justify-content-center mb-4 mb-md-8">
                    {{-- <span class="shape shape-left bg-info"></span> --}}
                    <h2 class="text-danger" style="color: #000!important">Achievements- Milestone and Statistics</h2>
                    {{-- <span class="shape shape-right bg-info"></span> --}}
                </div>


                <div class="row wow fadeInUp" id="counter">
                    <div class="col-sm-3 col-xs-12">
                        <div class="text-center text-white mb-5">
                            <div class="counter-value " data-count="15"
                                style="color: #000!important;border: 4px solid #000!important;">0</div>
                            <span
                                class="d-inline-block bg-primary text-uppercase font-weight-medium rounded-sm shadow-sm mt-1 py-2 px-3">
                                Achievements</span>
                        </div>
                    </div>

                    <div class="col-sm-3 col-xs-12">
                        <div class="text-center text-white mb-5">
                            <div class="counter-value " data-count="99.20"
                                style="color: #000!important;border: 4px solid #000!important;">0</div>
                            <span
                                class="d-inline-block bg-success text-uppercase font-weight-medium rounded-sm shadow-sm mt-1 py-2 px-3">H.S.C
                                Passed (%)</span>
                        </div>
                    </div>

                    <div class="col-sm-3 col-xs-12">
                        <div class="text-center text-white mb-5">
                            <div class="counter-value " data-count="1126"
                                style="color: #000!important;border: 4px solid #000!important;">0</div>
                            <span
                                class="d-inline-block bg-danger text-uppercase font-weight-medium rounded-sm shadow-sm mt-1 py-2 px-3">H.S.C
                                GPA 5</span>
                        </div>
                    </div>

                    <div class="col-sm-3 col-xs-12">
                        <div class="text-center text-white mb-5">
                            <div class="counter-value " data-count={{ $totalStudents }}
                                style="color: #000!important;border: 4px solid #000!important;">0</div>
                            <span
                                class="d-inline-block bg-info text-uppercase font-weight-medium rounded-sm shadow-sm mt-1 py-2 px-3">Students</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="py-6 section-title justify-content-center mb-4 mb-md-8 wow fadeInUp">
                {{-- <span class="shape shape-left bg-info"></span> --}}
                <h2 class="text-danger">Message</h2>
                {{-- <span class="shape shape-right bg-info"></span> --}}
            </div>

            <div class="row fadeInUp">
                <div class="col-md-6 ">
                    <div class="card  border-primary card-hover bg-white section left-to-right " id="card1">
                        <a class="position-relative " href="https://bafsd.edu.bd/page/message-of-the-chairman"
                            style="color: white;">
                            <img class="card-img-top mx-auto d-block py-0 w-100" style="height: 338px;object-fit: cover;"
                                src="{{ asset('/') }}public/gb3.jpg" alt="Card image">
                            <button class="btn btn-quickview shadow-none btnhover hidden-content1"
                                style="margin-left: 15px;margin-bottom: 15px;color: white!important;">
                                GB Chairman<br>
                                <span style="font-size: 18px!important;color: white;">Air Vice Marshal Mohammed Khair Ul
                                    Afsar, GUP, ndc, psc</span></br>
                                <!-- <a href="https://bafsd.edu.bd/page/message-of-the-chairman" class="btn btn-default btnD">Read More</a> -->
                            </button>

                            <button class="btn btn-quickview shadow-none btnhover hidden-content2"
                                style="margin-left: 15px;margin-bottom: 15px;color: white!important;">
                                GB Chairman<br>
                                <span style="font-size: 18px!important;color: white;">Air Vice Marshal Mohammed Khair Ul
                                    Afsar</span></br>
                                <p style="color: white;line-height: 20px;">BAF Shaheen College Dhaka is a reputed and
                                    profound educational institution run by Bangladesh Air Force. Since 1960, Shaheen has
                                    soared to new heights like an eagle with its guiding principles of education, restraint,
                                    and discipline...</p>
                                <a href="https://bafsd.edu.bd/page/message-of-the-chairman"
                                    class="btn btn-default btnD">Read More</a>
                            </button>

                        </a>
                    </div>

                </div>
                <div class="col-md-6 section ">
                    <div class="card  border-primary card-hover bg-white section right-to-left " id="card2">
                        <a class="position-relative " href="https://bafsd.edu.bd/page/message-of-the-principal"
                            style="color: white;">
                            <img class="card-img-top mx-auto d-block py-0 w-100" style="height: 338px;object-fit: cover;"
                                src="{{ asset('public/P sir1.jpg') }}" alt="Card image">
                            <button class="btn btn-quickview shadow-none btnhover hidden-content3"
                                style="margin-left: 10px;margin-bottom: 15px;color: white!important;">
                                Principal<br>
                                <span style="font-size: 18px!important;color: white;">Group Captain Mohammad Kaisul Hassan,
                                    psc</span></br>

                            </button>
                            <button class="btn btn-quickview shadow-none btnhover hidden-content4"
                                style="margin-left: 10px;margin-bottom: 15px;color: white!important;">
                                Principal<br>
                                <span style="font-size: 18px!important;color: white;">Group Captain Mohammad Kaisul Hassan,
                                    psc</span></br>
                                <p style="color: white;line-height: 20px;color: white;">BAF Shaheen College Dhaka is a well
                                    renowned educational institution under Ministry of Education, Secondary and Higher
                                    Secondary Education Directorates, Board of Intermediate and Secondary Education (BISE)
                                    Dhaka.....</p>
                                <a href="https://bafsd.edu.bd/page/message-of-the-principal"
                                    class="btn btn-default btnD">Read More</a>
                            </button>
                        </a>

                    </div>
                </div>
                <div>


                </div>
        </section>

        <section class="pt-9 pb-7" id="blog">
            <div class="container">
                <div class="section-title justify-content-center mb-4 mb-md-8 wow fadeInUp">
                    {{-- <span class="shape shape-left bg-info"></span> --}}
                    <h2 class="text-danger">Our Team</h2>
                    {{-- <span class="shape shape-right bg-info"></span> --}}
                </div>

                <div class="row wow fadeInUp">
                    @foreach ($managements as $key => $employee)
                        @php
                            if ($key == 0) {
                                $url = '/page/principal';
                            } elseif ($key == 1) {
                                $url = '/page/vice-principal-(admin)';
                            } else {
                                $url = '/page/adjutant';
                            }
                        @endphp
                        <div class="col-md-4">
                            <div class="card  section 
                            @if ($key == 1 || $key == 2) left-to-right @else right-to-left @endif
                            "
                                style="height: 350px;">
                                <div class="position-relative">
                                    {{-- <a href="{{ url($url) }}"> --}}
                                    <img class="card-img-top lazyestload" style="max-height: 330px;object-fit: cover;"
                                        data-src="{{ $employee->photo }}" src="{{ $employee->photo }}"
                                        alt="Card image">
                                    {{-- </a> --}}

                                </div>

                                <div class="card-body border-top-5 px-3 border-{{ $cs[$key] }}">
                                    <h3 class="card-title">
                                        {{-- <a class="text-{{$cs[$key]}} text-capitalize d-block text-truncate" href="{{ url($url) }}" style="color: #000000 !important"> --}}
                                        {{ $employee->designation->designation_name ?? '' }}
                                        {{-- </a> --}}
                                    </h3>
                                    <!-- <ul class="list-unstyled d-flex flex-md-column flex-lg-row">
                                                                                                                                                                                          <li class="me-2">
                                                                                                                                                                                    <a class="text-muted" href="#">
                                                                                                                                                                                     <i class="fab fa-facebook-square me-2" aria-hidden="true"></i>Facebook
                                                                                                                                                                                    </a>
                                                                                                                                                                                          </li>
                                                                                                                                                                                          <li class="me-2">
                                                                                                                                                                                    <a class="text-muted" href="#">
                                                                                                                                                                                     <i class="fab fa-twitter-square me-2" aria-hidden="true"></i>Twitter
                                                                                                                                                                                    </a>
                                                                                                                                                                                          </li>
                                                                                                                                                                                        </ul> -->
                                    <p class="mb-2" style="font-size: 1rem;"> {{ $employee->employee_name }}</p>

                                </div>
                            </div>
                        </div>
                    @endforeach



                </div>

                <!-- <div class="btn-aria text-center mt-4 wow fadeInUp">
                                                                                                                                                                               <a href="blog-grid.html" class="btn btn-danger text-uppercase">View More</a>
                                                                                                                                                                              </div> -->
            </div>
        </section>
        <!-- ====================================
                                                                                                                                                                            ———	TEACHERS SECTION
                                                                                                                                                                            ===================================== -->
        <section class="pt-9 pb-2 py-md-10 bg-purple" id="teachers"
            style="background-image: url({{ asset('public/') }}/assets/img/background/avator-bg.png);">
            <div class="container">
                <div class="section-title justify-content-center mb-2 mb-md-8 wow fadeInUp">
                    {{-- <span class="shape shape-left bg-danger"></span> --}}
                    <h2 class="text-white">OUR TEACHERS</h2>
                    {{-- <span class="shape shape-right bg-danger"></span> --}}
                </div>

                <div class="team-slider owl-carousel owl-theme wow fadeInUp" dir="ltr">
                    @foreach ($employees as $employee)
                        <div class="card card-product border-primary card-hover">
                            <div class="card-img-wrapper position-relative shadow-sm rounded-circle mx-auto">
                                <img class="card-img-top rounded-circle lazyestload" data-src="{{ $employee->photo }}"
                                    src="{{ $employee->photo }}" alt="carousel-img" />
                                <div class="card-img-overlay text-center rounded-circle">

                                </div>
                            </div>
                            <div class="card-body text-center">
                                <p class="font-size-20 font-weight-medium d-block" href="#"
                                    style="color: #000000 !important">
                                    {{ $employee->employee_name }}
                                </p>
                                <span class="text-white"
                                    style="color: #000000 !important">{{ $employee->designation->designation_name ?? '' }}</span>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>

        <!-- ====================================
                                                                                                                                                                            ———	GALLERY
                                                                                                                                                                            ===================================== -->


        <!-- ====================================
                                                                                                                                                                            ———	COUNTER-UP SECTION
                                                                                                                                                                            ===================================== -->


        <!-- ====================================
                                                                                                                                                                            ———	BLOG SECTION
                                                                                                                                                                            ===================================== -->


        <!-- ====================================
                                                                                                                                                                            ———	CONTACT SECTION
                                                                                                                                                                            ===================================== -->
        <!-- <section class="bg-light py-7 py-md-10">
                                                                                                                                                                              <div class="container">
                                                                                                                                                                                <div class="row wow fadeInUp">
                                                                                                                                                                                  <div class="col-sm-6 col-xs-12">
                                                                                                                                                                                    <div class="section-title align-items-baseline mb-4">
                                                                                                                                                                                      <h2 class="text-danger px-0 mb-0">Our Address</h2>
                                                                                                                                                                                    </div>
                                                                                                                                                                                    <p class="text-dark font-size-15">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                                                                                                                                                                    <ul class="list-unstyled">
                                                                                                                                                                                      <li class="media align-items-center mb-3">
                                                                                                                                                                                        <div class="icon-rounded-circle-small bg-primary me-2">
                                                                                                                                                                                          <i class="fas fa-map-marker-alt text-white"></i>
                                                                                                                                                                                        </div>
                                                                                                                                                                                        <div class="media-body">
                                                                                                                                                                                          <p class="mb-0">9/4/C Ring Road,Garden Street Dhaka,Bangladesh-1200</p>
                                                                                                                                                                                        </div>
                                                                                                                                                                                      </li>
                                                                                                                                                                                      <li class="media align-items-center mb-3">
                                                                                                                                                                                        <div class="icon-rounded-circle-small bg-success me-2">
                                                                                                                                                                                          <i class="fas fa-envelope text-white"></i>
                                                                                                                                                                                        </div>
                                                                                                                                                                                        <div class="media-body">
                                                                                                                                                                                          <p class="mb-0"><a class="text-color" href="mailto:hello@example.com">hello@example.com</a></p>
                                                                                                                                                                                        </div>
                                                                                                                                                                                      </li>
                                                                                                                                                                                      <li class="media align-items-center mb-3">
                                                                                                                                                                                        <div class="icon-rounded-circle-small bg-info me-2">
                                                                                                                                                                                          <i class="fas fa-phone-alt text-white"></i>
                                                                                                                                                                                        </div>
                                                                                                                                                                                        <div class="media-body">
                                                                                                                                                                                          <p class="mb-0"><a class="text-color" href="tel:[00] 333 555 888">333 555 888</a></p>
                                                                                                                                                                                        </div>
                                                                                                                                                                                      </li>
                                                                                                                                                                                    </ul>
                                                                                                                                                                                  </div>
                                                                                                                                                                                  <div class="col-sm-6 col-xs-12">
                                                                                                                                                                                    <form>
                                                                                                                                                                                      <div class="form-group form-group-icon">
                                                                                                                                                                                        <i class="fas fa-user" aria-hidden="true"></i>
                                                                                                                                                                                        <input type="text" class="form-control border-primary" placeholder="First name" required>
                                                                                                                                                                                      </div>
                                                                                                                                                                                      <div class="form-group form-group-icon">
                                                                                                                                                                                        <i class="fas fa-envelope" aria-hidden="true"></i>
                                                                                                                                                                                        <input type="email" class="form-control border-success" placeholder="Email address" required>
                                                                                                                                                                                      </div>
                                                                                                                                                                                      <div class="form-group form-group-icon">
                                                                                                                                                                                        <i class="fas fa-comments" aria-hidden="true"></i>
                                                                                                                                                                                        <textarea class="form-control border-info" placeholder="Write message" rows="6"></textarea>
                                                                                                                                                                                      </div>
                                                                                                                                                                                        <button type="submit" class="btn btn-danger float-right text-uppercase">
                                                                                                                                                                                          Send Message
                                                                                                                                                                                        </button>
                                                                                                                                                                                    </form>
                                                                                                                                                                                  </div>
                                                                                                                                                                                </div>
                                                                                                                                                                              </div>
                                                                                                                                                                            </section> -->

    </div> <!-- element wrapper ends -->

    <!-- ====================================
                                                                                                                                                                            ———	FOOTER
                                                                                                                                                                            ===================================== -->
    <div class="modal fade mb-8" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center">
                    <h5 class="modal-title w-100" style="font-weight: bold;">
                        <span style="color: #20aee5;">বিএএফ শাহিন কলেজ ঢাকা</span> <br />
                        <span style="color: red;">(শিক্ষাবর্ষ ২০২৫ কেজি শ্রেণির ভর্তি)</span><br />
                        <span style="color: rgb(46,49,146)" id="versiontext"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Form -->
                <form action="{{ route('admissionsearch') }}" method="post" enctype="multipart/form-data"
                    id="checkstatusform">
                    <div class="modal-body">
                        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />

                        <div class="row g-3">
                            <!-- Temporary ID Input -->
                            <div class="col-12">
                                <label for="temporary_id" class="form-label" style="font-weight: 500;">
                                    Temporary ID <span style="color: red">*</span>
                                </label>
                                <input type="text" class="form-control" id="temporary_id" name="temporary_id"
                                    value="{{ old('temporary_id') }}" placeholder="Enter your temporary ID..."
                                    style="text-transform: uppercase;" required>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer d-flex justify-content-between">
                        <!-- Custom Close Button -->
                        <button type="button" class="custom-btn-close" data-bs-dismiss="modal">
                            Close
                        </button>
                        <!-- Custom Search Button -->
                        <button type="submit" class="custom-btn-search">
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
        
            $(document.body).on('click', '.findAdmitcard', function() {

                $('#exampleModal').modal('show');
            });
            $('#dob').on('change', function() {
                let category_id = $('input[name="category_id"]:checked').val();


                var dob = new Date($(this).val());
                if (!isNaN(dob.getTime())) { // Check if the date is valid
                    var today = new Date(2025, 0, 1); // February 1, 2025

                    // Calculate the age in terms of years, months, and days
                    var years = today.getFullYear() - dob.getFullYear();
                    var months = today.getMonth() - dob.getMonth();
                    var days = today.getDate() - dob.getDate();

                    // Adjust if the birth date hasn't occurred yet this month
                    if (days < 0) {
                        months--;
                        // Get the last day of the previous month
                        var lastDayOfPrevMonth = new Date(today.getFullYear(), today.getMonth(), 0)
                            .getDate();
                        days += lastDayOfPrevMonth;
                    }

                    // Adjust if the birth month hasn't occurred yet this year
                    if (months < 0) {
                        years--;
                        months += 12;
                    }

                    // Convert the calculated age to total days for comparison
                    var totalAgeDays = years * 365 + months * 30 + days;

                    // Minimum age: 4 years, 11 months, and 15 days
                    var minAgeDays = (4 * 365) + (11 * 30) + 15;
                    // Maximum age: 6 years and 15 days
                    var maxAgeDays = (6 * 365) + 15;

                    // Check if the total days fall within the valid range
                    if ((totalAgeDays >= minAgeDays && totalAgeDays <= maxAgeDays) || (category_id == 2 ||
                            category_id == 4)) {
                        $('#age').text(years + ' years, ' + months + ' months, ' + days + ' days').css(
                            'color', 'green');
                        $('#message').text('Age is within the valid range').css('color', 'green');
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: 'Age is not within the valid range',
                            icon: "warning"
                        });

                        $('#age').text('');
                        $(this).val('');
                        $('#message').text('Age is not within the valid range').css('color', 'red');
                    }
                } else {
                    $('#message').text('Please select a valid date');
                }
            });
        });
        $(document.body).on('click', '.findAdmitcard', function() {

            $('#exampleModal').modal('show');
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("animate");
                    }
                });
            });

            document.querySelectorAll(".animate-on-scroll").forEach((element) => {
                observer.observe(element);
            });
        });

        document.addEventListener('scroll', function() {
            const sections = document.querySelectorAll('.section');
            sections.forEach(section => {
                const rect = section.getBoundingClientRect();
                const windowHeight = window.innerHeight || document.documentElement.clientHeight;

                // Check if section is in the viewport
                if (rect.top <= windowHeight && rect.bottom >= 0) {
                    section.classList.add('animate');
                }
            });
        });
    </script>
@endsection
