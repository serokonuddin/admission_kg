<!DOCTYPE html>
<html dir="ltr" lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Home</title>
      <meta name="title" content="">
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="shortcut icon" href="{{asset('/')}}public/frontend/uploads/school_content/logo/front_fav_icon-608ff44a5fdb33.94953981.png" type="image/x-icon">
      <link href="{{asset('/')}}public/frontend/themes/material_pink/css/bootstrap.min.css" rel="stylesheet">
      <link href="{{asset('/')}}public/frontend/themes/material_pink/css/owl.carousel.css" rel="stylesheet">
      <link href="{{asset('/')}}public/frontend/themes/material_pink/css/font-awesome.min.css" rel="stylesheet">
      <link href="{{asset('/')}}public/frontend/themes/material_pink/css/style.css" rel="stylesheet">
      <link rel="stylesheet" href="{{asset('/')}}public/frontend/dist/css/ss-print.css">
      <link rel="stylesheet" href="{{asset('/')}}public/frontend/themes/material_pink/datepicker/bootstrap-datepicker3.css"/>
      <script src="{{asset('/')}}public/frontend/dist/js/moment.min.js"></script>
      <!--file dropify-->
      <link rel="stylesheet" href="{{asset('/')}}public/frontend/dist/css/dropify.min.css">
      <script src="{{asset('/')}}public/frontend/custom/jquery.min.js"></script>
      <!--file dropify-->
      <script src="{{asset('/')}}public/frontend/dist/js/dropify.min.js"></script>
      <script type="text/javascript">
         var base_url = "index.html";
      </script>        
      <link rel="stylesheet" type="text/css" href="{{asset('/')}}public/frontend/dist/css/bootstrap-select.min.css">
      <script type="text/javascript" src="{{asset('/')}}public/frontend/dist/js/bootstrap-select.min.js"></script>
      <script type="text/javascript">
         $(function () {
             $('.languageselectpicker').selectpicker();
         });
      </script>
      <link rel="stylesheet" href="{{asset('/')}}public/frontend/themes/material_pink/css/online-course.css"/>
      <script async src="https://www.googletagmanager.com/gtag/js?id=GA_TRACKING_ID"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
      <script>
         window.dataLayer = window.dataLayer || [];
         function gtag(){dataLayer.push(arguments);}
         gtag('js', new Date());
         
         gtag('config', 'GA_TRACKING_ID');
      </script>    
   </head>
   <body>
      <div id="alert" class="">
         @include('frontend.topsection')
         <!--./topsection-->   
         <header class="shado">
            <link href="{{asset('/')}}public/frontend/toast-alert/toastr.css" rel="stylesheet"/>
            <script src="{{asset('/')}}public/frontend/toast-alert/toastr.js"></script>
            <style type="text/css">
               @keyframes spin3D {
               from { transform: rotateY(0deg) }
               to { transform: rotateY(360deg) }
               }
               .spin3D { animation: spin3D 3s ease-in-out infinite; }

               @font-face {
                  font-family: bebas;
                   src: url({{asset('public/frontend/fonts/Bebas-Regular.ttf')}});
                  }
                  @font-face {
                  font-family: Abril;
                   src: url({{asset('public/frontend/fonts/AbrilFatface-Regular.ttf')}});
                  }
                  body {
                        font-family: Source Sans Pro,Helvetica Neue,Helvetica,Arial,sans-serif!important;
                     }
               .logo {
                     font-size: 26px !important;
                     font-family: Abril;
                     font-weight: bold;
                     text-transform: uppercase;
                  }
                  .nav li a{
                     font-family: Source Sans Pro,Helvetica Neue,Helvetica,Arial,sans-serif!important;
                     font-weight: bold;
                     font-size: 1em;
                     font-weight:600;
                  }
                  h1, h2, h3, h4, h5, h6 {
                     font-family: Source Sans Pro, Helvetica Neue, Helvetica, Arial, sans-serif;
                     font-weight: 700;
                     line-height: 1.25em;
                  }
                  p {
                     margin-top: 0;
                     margin-bottom: .512em;
                  }
                  .navborder .navbar-nav>li>a {
                     padding: 10px 4px !important;
                  }
               form .form-bottom button.btn {
               min-width: 105px;
               }
               form .form-bottom .input-error {
               border-color: #d03e3e;
               color: #d03e3e;
               }
               form.gauthenticate-form {
               display: none;
               }
               
               .newscontent li {
                  min-height: 0px;
               }
               header {
                  top:40px;
                  padding: 3px 0 0;
               }
               .caret {
                  display: inline-block;
                  width: 0;
                  height: 0;
                  margin-left: 0px;
                  vertical-align: middle;
                  border-top: 4px dashed;
                  border-top: 4px solid\9;
                  border-right: 4px solid transparent;
                  border-left: 4px solid transparent;
               }
               .navbar{
                  min-height: 40px;
               }
               .fa-facebook-f:before, .fa-facebook:before {
                  content: "\f09a";
                  margin-left: 5px;
               }
               .header-extras li i{
                  font-size: 30px;
                  width: 32px;
               }
               .eiin {
                  font-size: 12px;
                  /* margin-top: -27px; */
                  position: relative;
                  /* margin-left: 94px; */
                  color: black;
                  /* display: block; */
               }
               .sticky-top .logo img {
                  height: 76px;
               }
               #resultdiv header{
                  z-index: 1!important;
               }
               .shado {
                  border-top: 1px solid #e8e8e8;
                  box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
                  background: #fff;
                  z-index: 99;
               }
               @media only screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait) {
                  .complainbtn{
                     font-size: 1em;
                     padding: 11px 14px;
                  }
                  .header-extras{
                     margin: 0px 0 0;
                  }
               }
               @media only screen and (min-device-width: 481px) and (max-device-width: 915px) and (orientation:portrait) {

                  .nav li a {
                        font-family: Source Sans Pro, Helvetica Neue, Helvetica, Arial, sans-serif !important;
                        font-weight: bold;
                        font-size: .7em;
                        font-weight: 600;
                     }
                     .logo span{
                        display: inline-block!important;
                     }
                     .col-sm-9{
                        width: 68%;
                     }
                     .col-sm-2{
                        width: 22%;
                     }
               }
               @media (max-width: 450px){
                  .bs-slider .carousel-inner>.item {
                     padding-top: 0px; 
                  }
                  .header-extras{
                     display: none;
                  }
                  .navborder .navbar-toggle{
                     top: -60px;
                  }
                   .spacet60{
                     
                        padding-top: 10px!important;
                     
                  }
                  .sticky-top .logo img {
                     height: 45px;
                  }
                  .logo{
                     font-size: 1em!important;
                     text-transform: uppercase;
                  }
                  .logo span{
                     margin-top: -5px;
                  }
                  /* .mobile-menu.col-md-1{
                     width: 8.33333333%!important;
                     display: inline-block!important;
                    
                    
                  }
                  .mobile-menu.col-md-9{
                     width: 75%!important;
                     display: inline-block!important;
                 
                  }
                  .mobile-menu.col-md-2{
                     width: 16.5%!important;
                     display: inline-block!important;
                    
                  } */
                 

                  .flex-container {
                     display: flex;
                     flex-wrap: nowrap;
                     }

                     .flex-container .mobile-menu.col-md-1 {
                       width: 10%;
                       
                     }
                     .flex-container .mobile-menu.col-md-9 {
                       width: 80%;
                       margin-left: 10px;
                     }
                     .flex-container .mobile-menu.col-md-2 {
                       width: 10%;
                       margin-left: 10px;
                     }
                  .logo span{
                     display: inline-block!important;
                  }
                  .navborder .navbar-toggle {
                     background-color: #337AB7;
                     border: 1px solid #000;
                     position: absolute;
                     right: -60px;
                     top: -45px;
                  }
                  
               }
               
            </style>
            <div class="container">
               <div class="row flex-container">
                 <div class="mobile-menu col-md-1 col-sm-1">
                     <a class="logo" href="{{url('/')}}">
                        <img class="spin3D" src="{{asset('/')}}public/frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png" alt="">
                        
                     </a>
                 </div>
                  <div class="mobile-menu col-md-9 col-sm-9">
                     <a class="logo" href="{{url('/')}}">
                      
                        <span>BAF Shaheen College Dhaka</span>
                        <span class="eiin" >শিক্ষা-সংযম-শৃঙ্খলা | EIIN-107858</span>
                     </a>
                     @include('frontend.menu')
                  </div>
                  
                  <!--./col-md-4-->
                  <div class="mobile-menu col-md-2 col-sm-2">
                     <ul class="header-extras">
                        <li>
                            <a href="https://www.facebook.com/dhakashaheen" target="_blank"><i class="fa fa-facebook"></i></a>
                           
                        </li>
                        
                        <!--li class="dropdown menuinlinemobile" id="">
                           <div class="dropdown-menu shop-chart-top13">
                              <div class="cart-wrapper cart-list" id="card_data_list_hide">
                                 <ul>
                                    <div id="card_data_list"></div>
                                 </ul>
                              </div>
                              <div class="cart-wrapper cart-list" id="card_data_list_show">
                                 <ul>
                                 </ul>
                              </div>
                              <div class="cart-footer">
                                 <div class="focarttotal-price">
                                    <b id="card_total_amount">
                                       Total $0.00
                                       <p><small>Your cart is empty, please add courses.</small></p>
                                    </b>
                                    <span id="total_course">
                                    </span>
                                 </div>
                                 <a href="cart.html" class="gotocartbtn btn btn-success">Go To Cart</a>
                              </div>
                             
                           </div>
                        </li> -->
                        <li>
                           <a class="complainbtn" href="{{url('login')}}" ><span class="fa fa-address-book" aria-hidden="true"></span> Login</a>
                        </li>
                     </ul>
                  </div>
                  <!--./col-md-8-->
               </div>
               <!--./row-->
            </div>
            <!--./container-->
            
         </header>
      </div>
      <!---   Guest Signup  --->
      <div id="myModal" class="modal fade" role="dialog" tabindex="-1">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header modal-header-small">
                  <button type="button" class="close closebtnmodal" data-dismiss="modal">&times;</button>
                  <h4 >Guest Registration</h4>
               </div>
               <form action="https://#/course/guestsignup" method="post" class="signupform" id="signupform">
                  <div class="modal-body">
                     <div class="form-group">
                        <label>Name</label><small class="req"> *</small>
                        <input type="text" class="form-control reg_name" name="name" id="name" autocomplete="off">
                        <span class="text-danger" id="error_refno"></span>
                     </div>
                     <div class="form-group mb10">
                        <label>Email ID</label><small class="req"> *</small>
                        <input type="text"  class="form-control reg_email"  name="email" id="email" autocomplete="off" >
                        <span class="text-danger" id="error_dob"></span>
                     </div>
                     <div class="form-group mb10">
                        <label>Password</label><small class="req"> *</small>
                        <input type="password"  class="form-control reg_password"  name="password" id="password" autocomplete="off" >
                        <span class="text-danger" id="error_dob"></span>
                     </div>
                     <div id="load_signup_captcha"></div>
                  </div>
                  <div class="modal-footer">
                     <button type="button"  class="modalclosebtn btn  mdbtn" onclick="openmodal()">Login</button>
                     <button type="submit" id="signupformbtn" class="onlineformbtn mdbtn" >Sign Up </button>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <!---   Guest Login  --->
      <div id="loginmodal" class="modal fade" role="dialog" tabindex="-1">
         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header modal-header-small">
                  <button type="button" class="close closebtnmodal" data-dismiss="modal">&times;</button>
                  <h4 class=>Feedback Massage</h4>
               </div>
               <form action="{{url('massage')}}" method="post" class="loginform" id="loginform">
                  <div class="modal-body">
                     <div class="form-group mb10">
                        <label>Name</label><small class="req"> *</small>
                        <input type="text"  class="form-control "  name="name" required="required" id="name" autocomplete="off">
                        <span class="text-danger" id="error_dob"></span>
                     </div>
                     <div class="form-group mb10">
                        <label>Email</label><small class="req"> *</small>
                        <input type="email"  class="form-control login_email" required="required"  name="email" id="email" autocomplete="off">
                        <span class="text-danger" id="error_dob"></span>
                     </div>
                     <div class="form-group mb10">
                        <label>Phone</label><small class="req"> *</small>
                        <input type="text"  class="form-control login_email" required="required"  name="phone" id="phone" autocomplete="off">
                        <span class="text-danger" id="error_dob"></span>
                     </div>
                     <div class="form-group mb10">
                        <label>Message</label><small class="req"> *</small>
                        <textarea   class="form-control " required="required" name="message" id="message" autocomplete="off"></textarea>
                        <span class="text-danger" id="error_dob"></span>
                     </div>
                     
                  </div>
                  <div class="modal-footer">
                    
                     <button type="submit" id="loginformbtn" class="onlineformbtn mdbtn" >Submit</button>
                     
                  </div>
               </form>
               
            </div>
         </div>
      </div>
     
      <script>
         $(document).ready(function () { 
             $('#myModal,#forgotmodal,#loginmodal').modal({
                 backdrop: 'static',
                 keyboard: false,
                 show: false
             });
         });
      </script> 
      <script>
         $(document).on('change','.currency_list',function(e){ 
             let currency_id=$(this).val();
             $.ajax({
                 type: 'POST',
                 url: base_url+'welcome/changeCurrencyFormat',
                 data: {'currency_id':currency_id},
                 dataType: 'json',
                 beforeSend: function() {
                      
                 },
                 success: function(data) {          
                     window.location.reload();
                 },
                 error: function(xhr) { // if error occured
             
                 },
                 complete: function() {
                     
                 }
              
             });
         });
      </script>        
      @yield('content')
      <!--./container-->
      <footer style="padding-top:0px">
         <script src="{{asset('/')}}public/frontend/js/online_course.js"></script>           
         <div class="container spacet00 spaceb40">
            <div class="row">
               <div class="col-md-5 col-sm-6">
                  <h3 class="fo-title">Links</h3>
                  <ul class="f1-list">
                     <li>
                        <a href="http://xiclassadmission.gov.bd" target="_blank" >
                        XI Class Admission: 2023-24
                        </a>
                     </li>
                    
                     <li>
                        <a href="https://dhakaeducationboard.gov.bd/" target="_blank" >
                        Dhaka Education Board
                        </a>
                     </li>
                     <li>
                        <a href="https://bafsk.edu.bd/" target="_blank" >
                        BAF Shaheen College Kurmitola
                        </a>
                     </li>
                     <li>
                        <a href="https://bafspkp.edu.bd" target="_blank" >
                        BAF Shaheen College PKP
                        </a>
                     </li>
                     <li>
                        <a href="http://www.bafss.edu.bd" target="_blank" >
                        BAF Shaheen College Shamshernagar
                        </a>
                     </li>
                     <li>
                        <a href="http://bafsj.edu.bd" target="_blank" >
                        BAF Shaheen College Jashore
                        </a>
                     </li>
                     <li>
                        <a href="https://www.bafsc.edu.bd" target="_blank" >
                        BAF Shaheen College Chattogram
                        </a>
                     </li>
                     
                     <li>
                        <a href="http://bafsb.edu.bd" target="_blank" >
                        BAF Shaheen College Bogura
                        </a>
                     </li>
                     <li>
                        <a href="https://mopme.gov.bd/" target="_blank" >
                        Ministry of Primary and Mass Education
                        </a>
                     </li>
                     
                     <li>
                        <a href="http://www.nctb.gov.bd/" target="_blank" >
                        National Curriculum and Textbook Board (NCTB)
                        </a>
                     </li>
                     
                     <li>
                        <a href="https://www.dpe.gov.bd" target="_blank" >
                        Directorate of Primary Education
                        </a>
                     </li>
                     
                     <li>
                        <a href="http://dshe.gov.bd" target="_blank" >
                        Directorate of Secondary and Higher Education
                        </a>
                     </li>
                   
                     
                     <li>
                        <a href="https://moedu.gov.bd" target="_blank" >
                        Ministry of Education
                        </a>
                     </li>
                    
                  </ul>
                  <!-- <ul class="f1-list">
                    @foreach($pages as $page)
                     <li class="">
                        <a href="{{url('page/'.$page['slug'])}}" >{{$page['title']}}</a>
                     </li>
                     @endforeach
                     
                  </ul> -->
               </div>
               <!--./col-md-3-->
               <div class="col-md-4 col-sm-6">
                  <h3 class="fo-title">Google Map</h3>
                  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.172643828997!2d90.38821047533675!3d23.776865778652436!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c74302a89761%3A0xd99a5c61d56e1d6d!2sBAF%20Shaheen%20College%20Dhaka!5e0!3m2!1sen!2sbd!4v1714009795417!5m2!1sen!2sbd" width="350" height="220" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                  <!-- <ul class="company-social">
                     <li><a href="https://www.whatsapp.com/a" target="_blank"><i class="fa fa-whatsapp"></i></a></li>
                     <li><a href="https://www.facebook.com/a" target="_blank"><i class="fa fa-facebook"></i></a></li>
                     <li><a href="https://twitter.com/a" target="_blank"><i class="fa fa-twitter"></i></a></li>
                     <li><a href="https://plus.google.com/a" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                     <li><a href="https://www.youtube.com/a" target="_blank"><i class="fa fa-youtube"></i></a></li>
                     <li><a href="https://www.linkedin.com/a" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                     <li><a href="https://www.instagram.com/a" target="_blank"><i class="fa fa-instagram"></i></a></li>
                     <li><a href="https://in.pinterest.com/a" target="_blank"><i class="fa fa-pinterest"></i></a></li>
                  </ul> -->
               </div>
               <!--./col-md-3-->
               <div class="col-md-3 col-sm-6">
                  <h3 class="fo-title">Feedback</h3>
                  <div class="complain"><a href="#" onclick="openmodal()"><i class="fa fa-pencil-square-o i-plain"></i>Massage Box</a>
                  </div>
                  <!-- <li><i class="fa fa-pencil-square-o i-plain"></i>
                     <div class="he-text">Feedback<span><a href="https://#/page/complain">Complain</a></span>
                     </div>
                     </li> -->
               </div>
            </div>
            <!--./row-->
            <div class="row">
               <div class="col-md-12">
                  <div class="infoborderb"></div>
                  <div class="col-md-4">
                     <div class="contacts-item">
                        <div class="cleft"><i class="fa fa-phone"></i></div>
                        <div class="cright">
                           <a href="#" class="content-title">Contact</a>
                           <p href="#" class="content-title"><a href="tel:02-9836440" class="content-title">02-9836440</a>
</p>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="contacts-item">
                        <div class="cleft"><i class="fa fa-envelope"></i></div>
                        <div class="cright">
                           <a href="#" class="content-title">Email Us</a>
                           <p>
                              <a href="mailto:info@bafsd.edu.bd" class="content-title">info@bafsd.edu.bd </a><br/>
                              <a href="mailto:infobafsd@gmail.com" class="content-title">infobafsd@gmail.com </a>

                           </p>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="contacts-item">
                        <div class="cleft"><i class="fa fa-map-marker"></i></div>
                        <div class="cright">
                           <a href="#" class="content-title">Address</a>
                           <p href="#" class="content-title">3rd Gate, Near Shaheed Jahangir Gate, Dhaka 1206</p>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 col-sm-6">
                     <a class="twitter-timeline" data-tweet-limit="1" href="#"></a>
                  </div>
                  <!--./col-md-3-->   
               </div>
            </div>
         </div>
         </div><!--./container-->
         <div class="copy-right">
            <div class="container">
               <div class="row">
                  <div class="col-md-12 col-sm-12 text-center">
                     <p>©2024 BAF Shaheen College Dhaka, Powered By : Shahin TECH</p>
                  </div>
               </div>
               <!--./row-->
            </div>
            <!--./container-->
         </div>
         <!--./copy-right-->
      </footer>
      <a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a>
      <script>
         // function setsitecookies() {
         //     $.ajax({
         //         type: "POST",
         //         url: "https://#/welcome/setsitecookies",
         //         data: {},
         //         success: function (data) {
         //             $('.cookieConsent').hide();
         
         //         }
         //     });
         // }
         
         // function check_cookie_name(name)
         // {
         //     var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
         //     if (match) {
         //         console.log(match[2]);
         //         $('.cookieConsent').hide();
         //     }
         //     else{
         //        $('.cookieConsent').show();
         //     }
         // }
         // check_cookie_name('sitecookies');
      </script>
      <script src="{{asset('/')}}public/frontend/themes/material_pink/js/bootstrap.min.js"></script>
      <script src="{{asset('/')}}public/frontend/themes/material_pink/js/owl.carousel.min.js"></script>
      <script type="text/javascript" src="{{asset('/')}}public/frontend/themes/material_pink/js/jquery.waypoints.min.js"></script>
      <script type="text/javascript" src="{{asset('/')}}public/frontend/themes/material_pink/js/jquery.counterup.min.js"></script>
      <script src="{{asset('/')}}public/frontend/themes/material_pink/js/ss-lightbox.js"></script>
      <script src="{{asset('/')}}public/frontend/themes/material_pink/js/custom.js"></script>
      <!-- Include Date Range Picker -->
      <script type="text/javascript" src="{{asset('/')}}public/frontend/themes/material_pink/datepicker/bootstrap-datepicker.min.js"></script>
      
      <script type="text/javascript">
         $(function () {
           // $(".dropdown-toggle").on({
           //    mouseenter: function () {
            //      $(this).parent().addClass('open');
            //   },
            //   mouseleave: function () {
           //       $(this).parent().removeClass('open');
           //    }
           // });
            // $(document.body).on('mouseover','.dropdown-toggle',function(){
            //    $(this).parent().addClass('open');
            // }).on( "mouseout", function() {
            //    $(this).parent().removeClass('open');
            // } );
             jQuery('img.html').each(function () {
                 var $img = jQuery(this);
                 var imgID = $img.attr('id');
                 var imgClass = $img.attr('class');
                 var imgURL = $img.attr('src');
         
                 jQuery.get(imgURL, function (data) {
                     // Get the SVG tag, ignore the rest
                     var $svg = jQuery(data).find('svg');
         
                     // Add replaced image's ID to the new SVG
                     if (typeof imgID !== 'undefined') {
                         $svg = $svg.attr('id', imgID);
                     }
                     // Add replaced image's classes to the new SVG
                     if (typeof imgClass !== 'undefined') {
                         $svg = $svg.attr('class', imgClass + ' replaced-svg');
                     }
         
                     // Remove any invalid XML tags as per http://validator.w3.org
                     $svg = $svg.removeAttr('xmlns:a');
         
                     // Check if the viewport is set, else we gonna set it if we can.
                     if (!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
                         $svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
                     }
         
                     // Replace image with new SVG
                     $img.replaceWith($svg);
         
                 }, 'xml');
         
             });
         });
         
      </script>
      <!-- <script>
         (function (window, document) {
            var loader = function () {
                  var script = document.createElement("script"), tag = document.getElementsByTagName("script")[0];
                  script.src = "https://sandbox.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7);
                  tag.parentNode.insertBefore(script, tag);
            };

            window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);
         })(window, document);
      </script> -->
   </body>
</html>