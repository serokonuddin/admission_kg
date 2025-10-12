<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Site Tittle -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $academy_info->academy_name }}</title>

    <!-- Plugins css Style -->
    <link href='{{ asset('public/') }}/assets/plugins/fontawesome-5.15.2/css/all.min.css' rel='stylesheet'>
    <link href='{{ asset('public/') }}/assets/plugins/fontawesome-5.15.2/css/fontawesome.min.css' rel='stylesheet'>
    <link href='{{ asset('public/') }}/assets/plugins/animate/animate.css' rel='stylesheet'>

    <link href='{{ asset('public/') }}/assets/plugins/fancybox/jquery.fancybox.min.css' rel='stylesheet'>
    <link href='{{ asset('public/') }}/assets/plugins/isotope/isotope.min.css' rel='stylesheet'>


    <link href='{{ asset('public/') }}/assets/plugins/owl-carousel/owl.carousel.min.css' rel='stylesheet'
        media='screen'>
    <link href='{{ asset('public/') }}/assets/plugins/owl-carousel/owl.theme.default.min.css' rel='stylesheet'
        media='screen'>
    <link href='{{ asset('public/') }}/assets/plugins/revolution/css/settings.css' rel='stylesheet'>
    <link href='{{ asset('public/') }}/assets/plugins/revolution/css/layers.css' rel='stylesheet'>
    <link href='{{ asset('public/') }}/assets/plugins/revolution/css/navigation.css' rel='stylesheet'>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Dosis:300,400,600,700|Open+Sans:300,400,600,700"
        rel="stylesheet">

    <!-- Custom css -->
    <link href="{{ asset('public/') }}/assets/css/kidz.css" id="option_style" rel="stylesheet">
    <link href="{{ asset('public/') }}/assets/css/custom.css" id="option_style" rel="stylesheet">

    <!-- Favicon -->
    <link href="{{ $academy_info->icon }}" rel="shortcut icon">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

    <!-- Javascript -->
    <script src='{{ asset('public/') }}/assets/plugins/jquery/jquery.min.js'></script>
    <script src='{{ asset('public/') }}/assets/plugins/bootstrap/js/bootstrap.bundle.min.js'></script>

    <script src='{{ asset('public/') }}/assets/plugins/fancybox/jquery.fancybox.min.js'></script>
    <script src='{{ asset('public/') }}/assets/plugins/isotope/isotope.min.js'></script>
    <script src='{{ asset('public/') }}/assets/plugins/images-loaded/js/imagesloaded.pkgd.min.js'></script>

    <script src='{{ asset('public/') }}/assets/plugins/lazyestload/lazyestload.js'></script>
    <script src='{{ asset('public/') }}/assets/plugins/velocity/velocity.min.js'></script>
    <script src='{{ asset('public/') }}/assets/plugins/smoothscroll/SmoothScroll.js'></script>


    <script src='{{ asset('public/') }}/assets/plugins/owl-carousel/owl.carousel.min.js'></script>
    <script src='{{ asset('public/') }}/assets/plugins/revolution/js/jquery.themepunch.tools.min.js'></script>
    <script src='{{ asset('public/') }}/assets/plugins/revolution/js/jquery.themepunch.revolution.min.js'></script>

    <!-- Load revolution slider only on Local File Systems. The following part can be removed on Server -->

    <script src='{{ asset('public/') }}/assets/plugins/revolution/js/extensions/revolution.extension.slideanims.min.js'>
    </script>
    <script
        src='{{ asset('public/') }}/assets/plugins/revolution/js/extensions/revolution.extension.layeranimation.min.js'>
    </script>
    <script src='{{ asset('public/') }}/assets/plugins/revolution/js/extensions/revolution.extension.navigation.min.js'>
    </script>


    <script src='{{ asset('public/') }}/assets/plugins/wow/wow.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>

</head>
<style>
    .top-bar a,
    .top-bar .btn {
        font-size: 16px;
        font-weight: bold;
    }

    .tp-bullet {
        width: 10px !important;
        height: 10px !important;
        border-radius: 50px;
    }

    .top-bar {
        padding: 0.1125rem 0;
    }

    .mobile {
        display: none;
    }

    /* .navbar > .container, .navbar > .container-fluid, .navbar > .container-sm, .navbar > .container-md, .navbar > .container-lg, .navbar > .container-xl{
        display: block;
      } */
    .short-text {
        font-family: Ravie !important;
        font-size: 1.2rem;
        color: white !important;
    }

    .full-text {
        font-size: 1.3rem;
        font-weight: bold;
        margin-bottom: 0.0rem;
    }

    .logoicon {
        width: 90px !important;
    }

    .navbar-expand-md .navbar-nav .nav-link {
        padding-top: 0.55rem;
        padding-bottom: 0.55rem;
    }

    @media (min-width: 992px) {
        .col-lg-5 {
            flex: 0 0 auto;
            width: 39%;
        }
    }

    @media (max-width: 768px) {
        .bafsd {
            font-size: 35px !important;
        }

        .mobile {
            display: block;
        }

        .logoicon {
            width: 70px !important;
        }

        hr {
            width: 170px;
        }

        .top-bar {
            padding: 0.125rem 0 0.5125rem 0;
        }

        .mobile-9 {
            width: 80% !important;
            display: inline !important;
            margin-left: 1% !important;
        }

        .mobile-3 {
            width: 11% !important;
            display: inline !important;
        }

        /* .mobile-menu{
        margin-top: -10px!important;
      } */
        .short-text {
            font-family: Ravie !important;
            font-size: 1.2rem;
            color: white !important;
            margin-top: 20px !important;
        }

        .full-text {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 0.0rem;
        }

        .section-top {
            margin-top: 50px;
        }

    }

    .scroll-none {
        display: none;
        /* Hide the scroll-up div initially */
    }

    .d-hide {
        display: none;
        /* Hide the scroll-up div initially */
    }

    .icon-header {
        width: 30px;
        height: 30px;
        line-height: 27px;
    }

    .btn:hover {
        background-color: white !important;
        color: #eee !important;
    }

    .navbar-nav {
        padding-right: 0.0rem;
    }

    @font-face {
        font-family: 'broadway1';
        src: url('{{ asset('public/font/BroadwayLT.woff') }}') format('woff');
    }

    @font-face {
        font-family: 'forte';
        src: url('{{ asset('public/font/Forte.woff') }}') format('woff');
    }

    @font-face {
        font-family: 'algerian';
        src: url('{{ asset('public/font/Algerian.woff') }}') format('woff');
    }

    @font-face {
        font-family: 'monotype corsiva';
        src: url('{{ asset('public/font/Corsiva.woff') }}') format('woff');
    }

    @font-face {
        font-family: 'Viner hand ITC';
        src: url('{{ asset('public/font/Viner Hand ITC.woff') }}') format('woff');
    }

    @font-face {
        font-family: 'Bradley Hand ITC';
        src: url('{{ asset('public/font/Bradley Hand ITC V2.woff') }}') format('woff');
    }

    @font-face {
        font-family: 'Book Antiqua';
        src: url('{{ asset('public/font/Book Antiqua.woff') }}') format('woff');
    }

    /* Gradient header background */
    /* Force visible gradient background */
    .header-bar {
        background: linear-gradient(90deg, #1e3a8a, #3b82f6, #6366f1);
        background-size: 300% 300%;
        animation: gradientShift 8s ease infinite;
        color: #fff;
    }

    /* Smooth animated gradient */
    @keyframes gradientShift {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    /* Fix for Bootstrap overriding */
    .header-bar.bg-primary {
        background: linear-gradient(90deg, #1e3a8a, #3b82f6, #6366f1) !important;
    }

    /* Button styling */
    .login-btn:hover {
        background-color: #f3f4f6 !important;
        color: #1e3a8a !important;
        transform: translateY(-1px);
        transition: all 0.25s ease-in-out;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .header-bar img {
            width: 55px;
            height: 55px;
        }

        .header-bar h4 {
            font-size: 1.1rem;
        }
    }
</style>

<body id="body" class="boxed pattern-04">
    <!-- ====================================
  ——— PRELOADER
  ===================================== -->
    {{-- <div id="preloader" class="smooth-loader-wrapper">
        <div class="smooth-loader">
            <div class="loader">
                <span class="dot dot-1"></span>
                <span class="dot dot-2"></span>
                <span class="dot dot-3"></span>
                <span class="dot dot-4"></span>
            </div>
        </div>
    </div> --}}

    <!-- ====================================
  ——— HEADER
  ===================================== -->
    <header id="pageTop" class="header shadow-sm" style="z-index: 1000; position: relative;">
        <div class="header-bar text-white py-3">
            <div class="container d-flex justify-content-between align-items-center flex-wrap">
                <!-- Left: Logo + Academy Info -->
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ url('/') }}">
                        <img src="{{ $academy_info->logo }}" alt="Logo"
                            class="rounded-circle border border-light shadow-sm"
                            style="width: 65px; height: 65px; object-fit: cover;">
                    </a>
                    <div>
                        <h4 class="fw-bold mb-1">{{ $academy_info->academy_name }}</h4>
                        <small class="text-light opacity-90">
                            ESTD {{ $academy_info->established_year }} | EIIN: {{ $academy_info->eiin }}
                        </small>
                    </div>
                </div>

                <!-- Right: Login Button -->
                <div class="d-flex align-items-center mt-3 mt-md-0">
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modal-login"
                        class="btn btn-light btn-sm fw-semibold d-flex align-items-center px-3 py-2 shadow-sm login-btn">
                        <i class="fas fa-unlock-alt me-2 text-primary"></i> Login
                    </a>
                </div>
            </div>
        </div>
    </header>




    @yield('content')
    <footer class="footer-bg-img">
        <!-- Footer Color Bar -->
        <div class="color-bar">
            <div class="container-fluid">
                <div class="row">
                    <div class="col color-bar bg-warning"></div>
                    <div class="col color-bar bg-danger"></div>
                    <div class="col color-bar bg-success"></div>
                    <div class="col color-bar bg-info"></div>
                    <div class="col color-bar bg-purple"></div>
                    <div class="col color-bar bg-pink"></div>
                    <div class="col color-bar bg-warning d-none d-md-block"></div>
                    <div class="col color-bar bg-danger d-none d-md-block"></div>
                    <div class="col color-bar bg-success d-none d-md-block"></div>
                    <div class="col color-bar bg-info d-none d-md-block"></div>
                    <div class="col color-bar bg-purple d-none d-md-block"></div>
                    <div class="col color-bar bg-pink d-none d-md-block"></div>
                </div>
            </div>
        </div>

        <!-- Copy Right -->
        <div class="copyright" style="background-color: #337AB7 !important">
            <div class="container">
                <div class="row py-4 align-items-center">
                    <div class="col-sm-7 col-xs-12 order-1 order-md-0">
                        <p class="copyright-text"> © <span id="copy-year"></span> {{ $academy_info->academy_name }},
                            Powered
                            By : Shahin TECH</p>
                    </div>

                    <div class="col-sm-5 col-xs-12">
                        <ul
                            class="list-inline d-flex align-items-center justify-content-md-end justify-content-center mb-md-0">
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Modal Login Login -->
    {{-- <div class="modal fade" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="bg-warning rounded-top p-2">
        <h3 class="text-white font-weight-bold mb-0 ms-2">Login</h3>
      </div>

      <div class="rounded-bottom-md border-top-0">
        <div class="p-3">
          <form action="{{ route('login') }}" method="POST" role="form">
			   @csrf
            <div class="form-group form-group-icon">
              <input type="text"  id="email"
                    name="email" class="form-control border" placeholder="User name" required="">
            </div>

            <div class="form-group form-group-icon">
              <input type="password" id="password" name="password" class="form-control border" placeholder="Password" required="">
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-danger text-uppercase w-100">Log In</button>
            </div>

            <div class="form-group text-center text-secondary mb-0">
              <a class="text-danger" href="javascript:void(0)">Forgot password?</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div> --}}

    {{-- Modal Login New --}}
    <div class="modal fade" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content shadow-lg"
                style="background: linear-gradient(45deg, #ff512f, #dd2476); border-radius: 15px;">
                <!-- Logo and School Name -->
                <div class="app-brand justify-content-center mt-4 text-center" style="font-family: math">
                    <a href="{{ url('/') }}" class="app-brand-link gap-2">
                        <span class="app-brand-logo demo">
                            <img src="{{ asset('public/logo/logo.png') }}" height="80" alt="Logo" />
                        </span>
                    </a>
                    <p class="text-uppercase font-weight-bold mt-2" style="font-size: 18px; color: white;">SHAHEEN
                        SOFT</p>
                    <h4 class="mb-3 text-center" style="color: #F0C24B;font-weight: bold">BAF SHAHEEN COLLEGE DHAKA
                    </h4>
                </div>

                <!-- Form Content -->
                <div class="rounded-bottom-md border-top-0">
                    <div class="p-4">
                        <!-- Error Message -->
                        <div id="login-error" class="alert alert-danger text-danger text-center d-none"
                            style="font-size: 14px; border-radius: 5px;">
                            {{ session('login_error') }}
                        </div>
                        <form action="{{ route('login') }}" method="POST" role="form">
                            @csrf
                            <!-- Email Input -->
                            <div class="form-group mb-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="email-addon">
                                        <i class="fas fa-user text-primary"></i>
                                    </span>
                                    <input type="text" id="email" name="email" class="form-control"
                                        placeholder="User name" aria-describedby="email-addon" required=""
                                        value="{{ old('email') }}">
                                </div>
                            </div>

                            <!-- Password Input -->
                            <div class="form-group mb-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="password-addon">
                                        <i class="fas fa-lock text-primary"></i>
                                    </span>
                                    <input type="password" id="password" name="password" class="form-control"
                                        placeholder="Password" aria-describedby="password-addon" required="">
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-danger w-100 py-2 text-uppercase text-white"
                                    style="border-radius: 30px;">
                                    <span style="color: rgba(240, 194, 75, 1)">Log In</span>
                                </button>
                            </div>

                            <!-- Forgot Password -->
                            <div class="form-group text-center text-white mt-3 mb-0">
                                <a class="text-white" href="javascript:void(0)" data-bs-toggle="modal"
                                    data-bs-target="#modal-forgot-password">Forgot password?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('login_error'))
                // Show the modal
                const loginModal = new bootstrap.Modal(document.getElementById('modal-login'));
                loginModal.show();

                // Display the error message
                const errorDiv = document.getElementById('login-error');
                errorDiv.classList.remove('d-none');
            @endif
        });
    </script>


    <!-- Birthdate Verification Form -->
    <div class="modal fade" id="modal-forgot-password" tabindex="-1" role="dialog"
        aria-labelledby="forgotPasswordLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content shadow-lg"
                style="background: linear-gradient(45deg, #ff512f, #dd2476); border-radius: 15px;">
                <div class="app-brand justify-content-center mt-4 text-center" style="font-family: math">
                    <h4 class="mb-3 text-center" style="color: #F0C24B; font-weight: bold">Verify Birthdate</h4>
                </div>
                <div class="p-4">
                    <form action="{{ route('password.reset.verify') }}" method="POST">
                        @csrf
                        <!-- Birthdate Input -->
                        <div class="form-group mb-3">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-calendar-alt text-primary"></i>
                                </span>
                                <input type="date" name="birthdate" class="form-control"
                                    placeholder="Enter your birthdate" required>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-danger w-100 py-2 text-uppercase text-white"
                                style="border-radius: 30px;">
                                <span style="color: rgba(240, 194, 75, 1)">Verify Birthdate</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>








    <!-- Modal Create Account -->
    <div class="modal fade" id="modal-createAccount" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm rounded" role="document">
            <div class="modal-content">
                <div class="bg-warning rounded-top p-2">
                    <h3 class="text-white font-weight-bold mb-0 ms-2">Create An Account</h3>
                </div>

                <div class="rounded-bottom-md border-top-0">
                    <div class="p-3">
                        <form action="#" method="POST" role="form">
                            <div class="form-group form-group-icon">
                                <input type="text" class="form-control border" placeholder="Name" required="">
                            </div>

                            <div class="form-group form-group-icon">
                                <input type="text" class="form-control border" placeholder="User name"
                                    required="">
                            </div>

                            <div class="form-group form-group-icon">
                                <input type="text" class="form-control border" placeholder="Phone"
                                    required="">
                            </div>

                            <div class="form-group form-group-icon">
                                <input type="password" class="form-control border" placeholder="Password"
                                    required="">
                            </div>

                            <div class="form-group form-group-icon">
                                <input type="password" class="form-control border" placeholder="Re-Password"
                                    required="">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-danger text-uppercase w-100">Register</button>
                            </div>

                            <div class="form-group text-center text-secondary mb-0">
                                <p class="mb-0">Allready have an account? <a class="text-danger"
                                        href="javascript:void(0)">Log in</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Enroll -->
    <div class="modal fade" id="modal-enrolAccount" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm rounded" role="document">
            <div class="modal-content">
                <div class="bg-pink rounded-top p-2">
                    <h3 class="text-white font-weight-bold mb-0 ms-2">Create An Account</h3>
                </div>

                <div class="rounded-bottom-md border-top-0">
                    <div class="p-3">
                        <form action="#" method="POST" role="form">
                            <div class="form-group form-group-icon">
                                <input type="text" class="form-control border" placeholder="Name" required="">
                            </div>

                            <div class="form-group form-group-icon">
                                <input type="text" class="form-control border" placeholder="User name"
                                    required="">
                            </div>

                            <div class="form-group form-group-icon">
                                <input type="text" class="form-control border" placeholder="Phone"
                                    required="">
                            </div>

                            <div class="form-group form-group-icon">
                                <input type="password" class="form-control border" placeholder="Password"
                                    required="">
                            </div>

                            <div class="form-group form-group-icon">
                                <input type="password" class="form-control border" placeholder="Re-Password"
                                    required="">
                            </div>

                            <div class="form-group">
                                <button type="submit"
                                    class="btn btn-pink text-uppercase text-white w-100">Register</button>
                            </div>

                            <div class="form-group text-center text-secondary mb-0">
                                <p class="mb-0">Allready have an account? <a class="text-pink"
                                        href="javascript:void(0)">Log in</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Products -->
    <div class="modal fade" id="modal-products" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <img class="img-fluid d-block mx-auto"
                                src="{{ asset('public/') }}/assets/img/products/products-preview01.jpg"
                                alt="preview01.jpg">
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="product-single">
                                <h1>Barbie Racing Car</h1>

                                <span class="pricing font-size-55">$50 <del>$60</del></span>

                                <p class="mb-7">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                    eiusmod tempor
                                    incididunt ut
                                    labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                                    ullamco laboris nisi.</p>

                                <div class="add-cart mb-0">
                                    <div class="count-input">
                                        <input class="quantity btn-primary" type="text" value="1">
                                        <a class="incr-btn incr-up" data-action="decrease" href="#"><i
                                                class="fa fa-caret-up" aria-hidden="true"></i></a>
                                        <a class="incr-btn incr-down" data-action="increase" href="#"><i
                                                class="fa fa-caret-down" aria-hidden="true"></i></a>
                                    </div>
                                    <button type="button" class="btn btn-danger text-uppercase"
                                        onclick="location.href='product-cart.html';">Add to cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--scrolling-->
    <div class="">
        <a href="#pageTop" class="back-to-top" id="back-to-top" style="opacity: 1;">
            <i class="fas fa-arrow-up" aria-hidden="true"></i>
        </a>
    </div>

    {{-- Login Modal --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('login_error'))
                // Show the modal
                const loginModal = new bootstrap.Modal(document.getElementById('modal-login'));
                loginModal.show();

                // Display the error message
                const errorDiv = document.getElementById('login-error');
                errorDiv.classList.remove('d-none');
            @endif
        });
    </script>


    <script>
        $(document).ready(function() {
            $("#card1").hover(
                function() {

                    $(".hidden-content2").fadeIn(); // Show the corresponding div on hover
                    $(".hidden-content1").fadeOut(); // Show the corresponding div on hover
                },
                function() {

                    $(".hidden-content2").fadeOut(); // Show the corresponding div on hover
                    $(".hidden-content1").fadeIn(); // Show the corresponding div on hover
                }
            );
            $("#card2").hover(
                function() {

                    $(".hidden-content4").fadeIn(); // Show the corresponding div on hover
                    $(".hidden-content3").fadeOut(); // Show the corresponding div on hover
                },
                function() {

                    $(".hidden-content4").fadeOut(); // Show the corresponding div on hover
                    $(".hidden-content3").fadeIn(); // Show the corresponding div on hover
                }
            );
        });



        $(document).ready(function() {


            var browserWidth = $(window).width();
            console.log("Browser width: " + browserWidth + "px");

            // You can also check the width on window resize
            $(window).resize(function() {
                var browserWidth = $(window).width();
                console.log("Updated browser width: " + browserWidth + "px");
            });



            var $scrollUpDiv = $('.scroll-up-div');
            var $scrollUpDivi = $('.scroll-up-div i');

            // $(window).on('scroll', function() {
            //     // Check if the user has scrolled to the bottom of the page

            //     if ($(window).scrollTop() + $(window).height() >= 800) {
            //         if (browserWidth > 1900) {
            //             if ($(window).scrollTop() + $(window).height() >= 1000) {
            //                 $scrollUpDiv.css('margin-top', '0px'); // Sho
            //                 $scrollUpDivi.addClass('d-hide');
            //             } else {
            //                 $scrollUpDiv.css('margin-top', '0px'); // Sho
            //                 $scrollUpDivi.removeClass('d-hide');
            //             }
            //         } else {
            //             $scrollUpDiv.css('margin-top', '85px'); // Sho
            //             $scrollUpDivi.addClass('d-hide');
            //         }

            //     } else if ($(window).scrollTop() <= 80) {
            //         $scrollUpDiv.css('margin-top', '0px'); // Sho
            //         $scrollUpDivi.removeClass('d-hide');
            //     } else if ($(window).scrollTop() <= 180) {
            //         $scrollUpDiv.css('margin-top', '0px'); // Sho
            //         $scrollUpDivi.removeClass('d-hide');
            //     }

            // });
            $(window).on('scroll', function() {
                let scrollPos = $(window).scrollTop() + $(window).height();

                // --- First priority: top of page ---
                if ($(window).scrollTop() <= 180) {
                    $scrollUpDiv.css('margin-top', '0px');
                    $scrollUpDivi.removeClass('d-hide');
                }

                // --- Second priority: when scrolled down ---
                else if (scrollPos >= 800) {
                    if (browserWidth > 1900) {
                        if (scrollPos >= 1000) {
                            $scrollUpDiv.css('margin-top', '0px');
                            $scrollUpDivi.addClass('d-hide');
                        } else {
                            $scrollUpDiv.css('margin-top', '0px');
                            $scrollUpDivi.removeClass('d-hide');
                        }
                    } else {
                        $scrollUpDiv.css('margin-top', '85px');
                        $scrollUpDivi.addClass('d-hide');
                    }
                }
            });

        });








        var d = new Date();
        var year = d.getFullYear();
        document.getElementById("copy-year").innerHTML = year;


        @if (Session::get('success'))

            Swal.fire({
                title: "Good job!",
                text: "{{ Session::get('success') }}",
                icon: "success"
            });
        @endif
        @if (Session::get('warning'))

            Swal.fire({
                title: "Warning!",
                html: "{!! Session::get('warning') !!}",
                icon: "warning"
            });
        @endif
    </script>
    <script src='{{ asset('public/') }}/assets/js/kidz.js'></script>



</body>

</html>
