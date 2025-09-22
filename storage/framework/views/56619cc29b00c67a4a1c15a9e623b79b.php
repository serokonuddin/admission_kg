<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Site Tittle -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BAF Shaheen College Dhaka</title>

    <!-- Plugins css Style -->
    <link href='<?php echo e(asset('public/')); ?>/assets/plugins/fontawesome-5.15.2/css/all.min.css' rel='stylesheet'>
    <link href='<?php echo e(asset('public/')); ?>/assets/plugins/fontawesome-5.15.2/css/fontawesome.min.css' rel='stylesheet'>
    <link href='<?php echo e(asset('public/')); ?>/assets/plugins/animate/animate.css' rel='stylesheet'>

    <link href='<?php echo e(asset('public/')); ?>/assets/plugins/fancybox/jquery.fancybox.min.css' rel='stylesheet'>
    <link href='<?php echo e(asset('public/')); ?>/assets/plugins/isotope/isotope.min.css' rel='stylesheet'>


    <link href='<?php echo e(asset('public/')); ?>/assets/plugins/owl-carousel/owl.carousel.min.css' rel='stylesheet'
        media='screen'>
    <link href='<?php echo e(asset('public/')); ?>/assets/plugins/owl-carousel/owl.theme.default.min.css' rel='stylesheet'
        media='screen'>
    <link href='<?php echo e(asset('public/')); ?>/assets/plugins/revolution/css/settings.css' rel='stylesheet'>
    <link href='<?php echo e(asset('public/')); ?>/assets/plugins/revolution/css/layers.css' rel='stylesheet'>
    <link href='<?php echo e(asset('public/')); ?>/assets/plugins/revolution/css/navigation.css' rel='stylesheet'>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Dosis:300,400,600,700|Open+Sans:300,400,600,700"
        rel="stylesheet">

    <!-- Custom css -->
    <link href="<?php echo e(asset('public/')); ?>/assets/css/kidz.css" id="option_style" rel="stylesheet">
    <link href="<?php echo e(asset('public/')); ?>/assets/css/custom.css" id="option_style" rel="stylesheet">

    <!-- Favicon -->
    <link
        href="<?php echo e(asset('/')); ?>public/frontend/uploads/school_content/logo/front_fav_icon-608ff44a5fdb33.94953981.png"
        rel="shortcut icon">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

    <!-- Javascript -->
    <script src='<?php echo e(asset('public/')); ?>/assets/plugins/jquery/jquery.min.js'></script>
    <script src='<?php echo e(asset('public/')); ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js'></script>

    <script src='<?php echo e(asset('public/')); ?>/assets/plugins/fancybox/jquery.fancybox.min.js'></script>
    <script src='<?php echo e(asset('public/')); ?>/assets/plugins/isotope/isotope.min.js'></script>
    <script src='<?php echo e(asset('public/')); ?>/assets/plugins/images-loaded/js/imagesloaded.pkgd.min.js'></script>

    <script src='<?php echo e(asset('public/')); ?>/assets/plugins/lazyestload/lazyestload.js'></script>
    <script src='<?php echo e(asset('public/')); ?>/assets/plugins/velocity/velocity.min.js'></script>
    <script src='<?php echo e(asset('public/')); ?>/assets/plugins/smoothscroll/SmoothScroll.js'></script>


    <script src='<?php echo e(asset('public/')); ?>/assets/plugins/owl-carousel/owl.carousel.min.js'></script>
    <script src='<?php echo e(asset('public/')); ?>/assets/plugins/revolution/js/jquery.themepunch.tools.min.js'></script>
    <script src='<?php echo e(asset('public/')); ?>/assets/plugins/revolution/js/jquery.themepunch.revolution.min.js'></script>

    <!-- Load revolution slider only on Local File Systems. The following part can be removed on Server -->

    <script src='<?php echo e(asset('public/')); ?>/assets/plugins/revolution/js/extensions/revolution.extension.slideanims.min.js'>
    </script>
    <script
        src='<?php echo e(asset('public/')); ?>/assets/plugins/revolution/js/extensions/revolution.extension.layeranimation.min.js'>
    </script>
    <script src='<?php echo e(asset('public/')); ?>/assets/plugins/revolution/js/extensions/revolution.extension.navigation.min.js'>
    </script>


    <script src='<?php echo e(asset('public/')); ?>/assets/plugins/wow/wow.min.js'></script>
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
        src: url('<?php echo e(asset('public/font/BroadwayLT.woff')); ?>') format('woff');
    }

    @font-face {
        font-family: 'forte';
        src: url('<?php echo e(asset('public/font/Forte.woff')); ?>') format('woff');
    }

    @font-face {
        font-family: 'algerian';
        src: url('<?php echo e(asset('public/font/Algerian.woff')); ?>') format('woff');
    }

    @font-face {
        font-family: 'monotype corsiva';
        src: url('<?php echo e(asset('public/font/Corsiva.woff')); ?>') format('woff');
    }

    @font-face {
        font-family: 'Viner hand ITC';
        src: url('<?php echo e(asset('public/font/Viner Hand ITC.woff')); ?>') format('woff');
    }

    @font-face {
        font-family: 'Bradley Hand ITC';
        src: url('<?php echo e(asset('public/font/Bradley Hand ITC V2.woff')); ?>') format('woff');
    }

    @font-face {
        font-family: 'Book Antiqua';
        src: url('<?php echo e(asset('public/font/Book Antiqua.woff')); ?>') format('woff');
    }
</style>

<body id="body" class="boxed pattern-04">
    <!-- ====================================
  ——— PRELOADER
  ===================================== -->
    

    <!-- ====================================
  ——— HEADER
  ===================================== -->
    <header class="header" id="pageTop">
        <!-- Top Color Bar -->
        <!-- <div class="color-bars">
      <div class="container-fluid">
        <div class="row">
          <div class="col color-bar bg-warning d-none d-md-block"></div>
          <div class="col color-bar bg-success d-none d-md-block"></div>
          <div class="col color-bar bg-danger d-none d-md-block"></div>
          <div class="col color-bar bg-info d-none d-md-block"></div>
          <div class="col color-bar bg-purple d-none d-md-block"></div>
          <div class="col color-bar bg-pink d-none d-md-block"></div>
          <div class="col color-bar bg-warning"></div>
          <div class="col color-bar bg-success"></div>
          <div class="col color-bar bg-danger"></div>
          <div class="col color-bar bg-info"></div>
          <div class="col color-bar bg-purple"></div>
          <div class="col color-bar bg-pink"></div>
        </div>
      </div>
    </div> -->

        <!-- Top Bar-->
        <!-- d-none d-md-block -->
        <div class="bg-stone navbar navbar-expand-md top-bar scroll-down-div"
            style="background-color: #A51C30 !important;">
            <div class="container" style=" display: block!important;">
                <div class="row">
                    <div class="col-lg-7 mobile-9">
                        <ul class="list-inline d-flex justify-content-xl-start align-items-center h-100 mb-0">
                            <li>
                                <div class="d-flex">
                                    <span class="  me-xl-0">

                                        <a href="<?php echo e(url('/')); ?>">
                                            <img class="d-inline-block logoicon" style="width: 65px!important;"
                                                src="<?php echo e(asset('/')); ?>public/frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png"
                                                alt="">
                                        </a>

                                    </span>
                                    <a href="<?php echo e(url('/')); ?>"
                                        class="me-lg-4 me-xl-6 text-white opacity-100 short-text"
                                        style="margin-top: 19px;line-height: 0px;"><span
                                            style=" font-family: 'broadway1'!important;font-size: 30px;"
                                            class="bafsd">BAFSD</span>
                                        <hr style="width: 130px" />
                                        <span style="font-family: forte!important;font-size: 15px">DHAKA SHAHEEN</span>
                                    </a>
                                </div>


                            </li>


                        </ul>
                    </div>

                    <div class="col-lg-5 mobile-3">
                        <ul
                            class="top-menu list-inline d-flex mt-2 justify-content-xl-end justify-content-center align-items-center me-xl-2">



                            <li class="text-white me-md-3 me-lg-2 me-xl-5">
                                <span class="bg-purple icon-header me-1 me-md-2 me-lg-1 me-xl-2">
                                    <i class="fas fa-unlock-alt text-white font-size-13" aria-hidden="true"></i>
                                </span>
                                <a class="text-white font-weight-medium opacity-80" href="javascript:void(0)"
                                    data-bs-toggle="modal" data-bs-target="#modal-login">
                                    Login
                                </a>

                            </li>
                            <li class="text-white me-md-3 me-lg-2 me-xl-5 ml-4 mobile" style="margin-left: 10px;">
                                <button class="navbar-toggler py-2" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false"
                                    aria-label="Toggle navigation">
                                    <i class="fa fa-bars"></i>
                                </button>

                            </li>

                            <li class="cart-dropdown d-none d-md-block">
                                <div class="cart-icon" aria-haspopup="true" aria-expanded="false"
                                    data-display="static">
                                    <a href="https://www.facebook.com/dhakashaheen" target="_blank">

                                        <span class="rounded-sm bg-pink icon-small icon-badge shopping-icon">
                                            <i class="fab fa-facebook-f text-white" aria-hidden="true"></i>

                                        </span>
                                    </a>
                                </div>

                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        <!-- Navbar -->
        <nav class="navbar navbar-expand-md  mobile-menu  navbar-white scroll-up-div">
            <div class="container">
                <a class="navbar-brand" href="<?php echo e(url('/')); ?>"
                    style="font-family: algerian!important;font-size:x-large;font-weight: bold;line-height: 25px;color: #00ADEF">
                    BAF Shaheen College Dhaka<br>
                    <span
                        style="
        font-size: 11px;
        margin-top: -5px;
        position: absolute;
        font-family: monotype corsiva!important;
        z-index: 1;
        color: black!important;



        ">ESTD
                        1960|EIIN-107858</span>
                </a>

                <!-- cart-dropdown -->
                <!-- <div class="dropdown cart-dropdown ms-auto me-5 d-md-none">
          <div class="cart-icon" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <a href="javascript:void(0)">
              <span class="rounded-sm bg-pink icon-small icon-badge close-icon">
                <i class="fas fa-times text-white" aria-hidden="true"></i>
              </span>
              <span class="rounded-sm bg-pink icon-small icon-badge shopping-icon">
                <i class="fa fa-shopping-basket text-white" aria-hidden="true"></i>
                <span class="badge bg-warning">3</span>
              </span>
            </a>
          </div>
          <div class="dropdown-menu dropdown-menu-end">
            <ul class="bg-white list-unstyled">
              <li class="d-flex align-items-center">
                <i class="fa fa-shopping-basket font-size-20 me-3" aria-hidden="true"></i>
                <h3 class="text-capitalize font-weight-bold mb-0">3 items in your cart</h3>
              </li>
              <hr>
              <li>
                <a href="product-single.html">
                  <div class="media">
                    <div class="image">
                      <img class="bg-light rounded-sm px-5 py-3 me-4" src="<?php echo e(asset('public/')); ?>/assets/img/products/product-sm.png" alt="cart-Image">
                    </div>
                    <div class="media-body">
                      <div class="d-flex justify-content-between">
                        <h4 class="text-dark">Barbie Racing Car</h4>
                        <span class="cancel">
                          <i class="fas fa-times text-muted" aria-hidden="true"></i>
                        </span>
                      </div>
                      <div class="price">
                        <span class="text-primary font-weight-medium">$50</span>
                      </div>
                      <span class="text-muted font-weight-medium text-muted">Qnt: 1</span>
                    </div>
                  </div>
                </a>
                <hr>
              </li>
              <li>
                <a href="product-single.html">
                  <div class="media">
                    <div class="image">
                      <img class="bg-light rounded-sm px-5 py-3 me-4" src="<?php echo e(asset('public/')); ?>/assets/img/products/product-sm.png" alt="cart-Image">
                    </div>
                    <div class="media-body">
                      <div class="d-flex justify-content-between">
                        <h4 class="text-dark">Barbie Racing Car</h4>
                        <span class="cancel">
                          <i class="fas fa-times text-muted" aria-hidden="true"></i>
                        </span>
                      </div>
                      <div class="price">
                        <span class="text-primary font-weight-medium">$50</span>
                      </div>
                      <span class="text-muted font-weight-medium">Qnt: 1</span>
                    </div>
                  </div>
                </a>
                <hr>
              </li>
              <li>
                <a href="product-single.html">
                  <div class="media">
                    <div class="image">
                      <img class="bg-light rounded-sm px-5 py-3 me-4" src="<?php echo e(asset('public/')); ?>/assets/img/products/product-sm.png" alt="cart-Image">
                    </div>
                    <div class="media-body">
                      <div class="d-flex justify-content-between">
                        <h4 class="text-dark font-weight-bold">Barbie Racing Car</h4>
                        <span class="cancel">
                          <i class="fas fa-times text-muted" aria-hidden="true"></i>
                        </span>
                      </div>
                      <div class="price">
                        <span class="text-primary font-weight-medium">$50</span>
                      </div>
                      <span class="text-muted font-weight-medium">Qnt: 1</span>
                    </div>
                  </div>
                </a>
                <hr>
              </li>
              <li>
                <div class="d-flex justify-content-between mb-3">
                  <h3 class="cart-total font-weight-bold">Subtotal</h3>
                  <h3 class="cart-price font-weight-bold">$150</h3>
                </div>
                <div class="cart-button d-flex justify-content-between">
                  <button type="button" class="btn btn-danger text-uppercase px-4 shadow-sm me-3" onclick="location.href='product-checkout-step-1.html';">Checkout</button>
                  <button type="button" class="btn btn-danger text-uppercase px-4 shadow-sm" onclick="location.href='product-cart.html';">View
                    Cart</button>
                </div>
              </li>
            </ul>
          </div>
        </div> -->

                <!-- <button class="navbar-toggler py-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
          aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fa fa-bars"></i>
        </button> -->
                <?php
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
                        'fa fa-bell',
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
                ?>
                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav ms-lg-auto">

                        <?php if(isset($pages)): ?>
                            <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ke => $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li
                                    class="nav-item dropdown <?php echo e($colors[$loop->index]); ?>  <?php echo e($ke == 0 ? 'active' : ''); ?>">

                                    <?php if(isset($page['tree'])): ?>
                                        <a class="nav-link dropdown-toggle   " href="javascript:void(0)"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="<?php echo e($icons[$loop->index]); ?> nav-icon" aria-hidden="true"></i>
                                            <span><?php echo e($page['title']); ?></span>
                                        </a>

                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown1">
                                            <?php $__currentLoopData = $page['tree']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $childpage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(isset($childpage['tree']) && !empty($childpage['tree'])): ?>
                                                    <li>
                                                        <a class="dropdown-item "
                                                            href="#"><?php echo e($childpage['title']); ?><i
                                                                class="fa fa-chevron-right" aria-hidden="true"></i></a>
                                                        <ul class="sub-menu">
                                                            <?php $__currentLoopData = $childpage['tree']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key1 => $subchildpage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <li><a
                                                                        href="<?php echo e(url('page/' . $subchildpage['slug'])); ?>"><?php echo e($subchildpage['title']); ?></a>
                                                                </li>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                        </ul>
                                                    </li>
                                                <?php else: ?>
                                                    <li>
                                                        <a class="dropdown-item "
                                                            href="<?php echo e(url('page/' . $childpage['slug'])); ?>"><?php echo e($childpage['title']); ?></a>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    <?php else: ?>
                                        <?php if($page['title'] == 'Home'): ?>
                                            <a class="nav-link    " href="<?php echo e(url('/')); ?>">
                                                <i class="fas fa-home nav-icon" aria-hidden="true"></i>
                                                <span><?php echo e($page['title']); ?></span>
                                            </a>
                                            <!-- <a class="nav-link dropdown-toggle " href="<?php echo e(url('/')); ?>" ><?php echo e($page['title']); ?></a> -->
                                        <?php else: ?>
                                            <a class="nav-link  " href="<?php echo e(url('page/' . $page['slug'])); ?>">
                                                <i class="fas fa-map nav-icon" aria-hidden="true"></i>
                                                <span><?php echo e($page['title']); ?></span>
                                            </a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

                    </ul>
                </div>
            </div>
        </nav>
    </header>







    <?php echo $__env->yieldContent('content'); ?>





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

        <div class="pt-8 pb-7  bg-repeat"
            style="background-image: url(<?php echo e(asset('public/')); ?>/assets/img/background/footer-bg-img-1.png);">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-lg-3 col-xs-12">
                        <h4 class="section-title-sm font-weight-bold text-white mb-2">Useful Links</h4>
                        <ul class="list-unstyled">
                            <li class="mb-4">
                                <a href="http://xiclassadmission.gov.bd" target="_blank">
                                    <i class="fas fa-angle-double-right me-2" aria-hidden="true"></i> XI Class
                                    Admission: 2023-24
                                </a>
                            </li>

                            <li class="mb-4">
                                <a href="https://dhakaeducationboard.gov.bd/" target="_blank">
                                    <i class="fas fa-angle-double-right me-2" aria-hidden="true"></i> Dhaka Education
                                    Board
                                </a>
                            </li>
                            <li class="mb-4">
                                <a href="https://bafsk.edu.bd/" target="_blank">
                                    <i class="fas fa-angle-double-right me-2" aria-hidden="true"></i> BAF Shaheen
                                    College Kurmitola
                                </a>
                            </li>
                            <li class="mb-4">
                                <a href="https://bafspkp.edu.bd" target="_blank">
                                    <i class="fas fa-angle-double-right me-2" aria-hidden="true"></i> BAF Shaheen
                                    College PKP
                                </a>
                            </li>
                            <li class="mb-4">
                                <a href="http://www.bafss.edu.bd" target="_blank">
                                    <i class="fas fa-angle-double-right me-2" aria-hidden="true"></i> BAF Shaheen
                                    College Shamshernagar
                                </a>
                            </li>
                            <li class="mb-4">
                                <a href="http://bafsj.edu.bd" target="_blank">
                                    <i class="fas fa-angle-double-right me-2" aria-hidden="true"></i> BAF Shaheen
                                    College Jashore
                                </a>
                            </li>
                            <li class="mb-4">
                                <a href="https://www.bafsc.edu.bd" target="_blank">
                                    <i class="fas fa-angle-double-right me-2" aria-hidden="true"></i> BAF Shaheen
                                    College Chattogram
                                </a>
                            </li>

                        </ul>
                    </div>

                    <div class="col-sm-6 col-lg-3 col-xs-12">

                        <ul class="list-unstyled">
                            <li class="mb-4">
                                <a href="http://bafsb.edu.bd" target="_blank">
                                    <i class="fas fa-angle-double-right me-2" aria-hidden="true"></i> BAF Shaheen
                                    College Bogura
                                </a>
                            </li>
                            <li class="mb-4">
                                <a href="https://mopme.gov.bd/" target="_blank">
                                    <i class="fas fa-angle-double-right me-2" aria-hidden="true"></i> Ministry of
                                    Primary and Mass Education
                                </a>
                            </li>

                            <li class="mb-4">
                                <a href="http://www.nctb.gov.bd/" target="_blank">
                                    <i class="fas fa-angle-double-right me-2" aria-hidden="true"></i> National
                                    Curriculum and Textbook Board (NCTB)
                                </a>
                            </li>

                            <li class="mb-4">
                                <a href="https://www.dpe.gov.bd" target="_blank">
                                    <i class="fas fa-angle-double-right me-2" aria-hidden="true"></i> Directorate of
                                    Primary Education
                                </a>
                            </li>

                            <li class="mb-4">
                                <a href="http://dshe.gov.bd" target="_blank">
                                    <i class="fas fa-angle-double-right me-2" aria-hidden="true"></i> Directorate of
                                    Secondary and Higher Education
                                </a>
                            </li>


                            <li class="mb-4">
                                <a href="https://moedu.portal.gov.bd/" target="_blank">
                                    <i class="fas fa-angle-double-right me-2" aria-hidden="true"></i> Ministry of
                                    Education
                                </a>
                            </li>

                        </ul>
                    </div>

                    <div class="col-sm-6 col-lg-4 col-xs-12">
                        <h4 class="section-title-sm font-weight-bold text-white mb-2">Contact</h4>
                        <p style="margin-bottom: .5rem;">02-9836440</p>
                        <h4 class="section-title-sm font-weight-bold text-white mb-2">Google Map</h4>
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.172643828997!2d90.38821047533675!3d23.776865778652436!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c74302a89761%3A0xd99a5c61d56e1d6d!2sBAF%20Shaheen%20College%20Dhaka!5e0!3m2!1sen!2sbd!4v1714009795417!5m2!1sen!2sbd"
                            width="350" height="220" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>

                    <div class="col-sm-6 col-lg-2 col-xs-12">
                        <!-- <h4 class="section-title-sm font-weight-bold text-white mb-3">Feedback</h4> -->

                        <!-- <div class="mb-1 ">
              <a href="http://localhost/schoolerp/page/message-of-the-principal" class="bg-success btn btn-white btn-sm text-uppercase text-hover-default">Massage Box</a>
            </div> -->
                        <h4 class="section-title-sm font-weight-bold text-white mb-3">Address</h4>
                        <p>3rd Gate, Near Shaheed Jahangir Gate, Dhaka 1206</p>

                        <h4 class="section-title-sm font-weight-bold text-white mb-3">Email Us</h4>
                        <p style="margin-bottom: .5rem;">info@bafsd.edu.bd</p>
                        <p style="margin-bottom: .5rem;">infobafsd@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Copy Right -->
        <div class="copyright" style="background-color: #337AB7 !important">
            <div class="container">
                <div class="row py-4 align-items-center">
                    <div class="col-sm-7 col-xs-12 order-1 order-md-0">
                        <p class="copyright-text"> © <span id="copy-year"></span> BAF Shaheen College Dhaka, Powered
                            By : Shahin TECH</p>
                    </div>

                    <div class="col-sm-5 col-xs-12">
                        <ul
                            class="list-inline d-flex align-items-center justify-content-md-end justify-content-center mb-md-0">
                            <li class="me-3">
                                <a class="icon-rounded-circle-small bg-primary"
                                    href="https://www.facebook.com/dhakashaheen" target="_blank">
                                    <i class="fab fa-facebook-f text-white" aria-hidden="true"></i>
                                </a>
                            </li>

                            <!-- <li class="me-3">
              <a class="icon-rounded-circle-small bg-danger" href="javascript:void(0)">
                <i class="fab fa-google-plus-g text-white" aria-hidden="true"></i>
              </a>
            </li>
            <li class="me-3">
              <a class="icon-rounded-circle-small bg-info" href="javascript:void(0)">
                <i class="fab fa-pinterest-p text-white" aria-hidden="true"></i>
              </a>
            </li>
            <li class="">
              <a class="icon-rounded-circle-small bg-purple" href="javascript:void(0)">
                <i class="fab fa-vimeo-v text-white" aria-hidden="true"></i>
              </a>
            </li> -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Modal Login Login -->
    

    
    <div class="modal fade" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content shadow-lg"
                style="background: linear-gradient(45deg, #ff512f, #dd2476); border-radius: 15px;">
                <!-- Logo and School Name -->
                <div class="app-brand justify-content-center mt-4 text-center" style="font-family: math">
                    <a href="<?php echo e(url('/')); ?>" class="app-brand-link gap-2">
                        <span class="app-brand-logo demo">
                            <img src="<?php echo e(asset('public/logo/logo.png')); ?>" height="80" alt="Logo" />
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
                            <?php echo e(session('login_error')); ?>

                        </div>
                        <form action="<?php echo e(route('login')); ?>" method="POST" role="form">
                            <?php echo csrf_field(); ?>
                            <!-- Email Input -->
                            <div class="form-group mb-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="email-addon">
                                        <i class="fas fa-user text-primary"></i>
                                    </span>
                                    <input type="text" id="email" name="email" class="form-control"
                                        placeholder="User name" aria-describedby="email-addon" required=""
                                        value="<?php echo e(old('email')); ?>">
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
            <?php if(session('login_error')): ?>
                // Show the modal
                const loginModal = new bootstrap.Modal(document.getElementById('modal-login'));
                loginModal.show();

                // Display the error message
                const errorDiv = document.getElementById('login-error');
                errorDiv.classList.remove('d-none');
            <?php endif; ?>
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
                    <form action="<?php echo e(route('password.reset.verify')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
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
                                src="<?php echo e(asset('public/')); ?>/assets/img/products/products-preview01.jpg"
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

    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if(session('login_error')): ?>
                // Show the modal
                const loginModal = new bootstrap.Modal(document.getElementById('modal-login'));
                loginModal.show();

                // Display the error message
                const errorDiv = document.getElementById('login-error');
                errorDiv.classList.remove('d-none');
            <?php endif; ?>
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


        <?php if(Session::get('success')): ?>

            Swal.fire({
                title: "Good job!",
                text: "<?php echo e(Session::get('success')); ?>",
                icon: "success"
            });
        <?php endif; ?>
        <?php if(Session::get('warning')): ?>

            Swal.fire({
                title: "Warning!",
                html: "<?php echo Session::get('warning'); ?>",
                icon: "warning"
            });
        <?php endif; ?>
    </script>
    <script src='<?php echo e(asset('public/')); ?>/assets/js/kidz.js'></script>



</body>

</html>
<?php /**PATH C:\laragon\www\college_admission\resources\views/frontend-new/layout.blade.php ENDPATH**/ ?>