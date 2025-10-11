  
@extends('frontend-new.layout')
@section('content')

@php 
            $colors=array('bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink');
            $cs=array('primary','danger','success','info','purple',' pink');
            $icons=array('fas fa-home','far fa-building','fas fa-graduation-cap','fas fa-balance-scale','fas fa-biking','fas fa-certificate','fas fa-comment-dots','fas fa-camera-retro','fas fa-map','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink');
        @endphp

        <div class="main-wrapper blog-grid-left-sidebar">
   <!-- ====================================
      ———	BREADCRUMB
      ===================================== -->
   <section class="breadcrumb-bg" style="background-image: url({{asset('public')}}/assets/img/background/page-title-bg-img.jpg); ">
      <div class="container">
         <div class="breadcrumb-holder">
            <div>
               <h1 class="breadcrumb-title">Contact</h1>
               <ul class="breadcrumb breadcrumb-transparent">
                  <li class="breadcrumb-item">
                     <a class="text-white" href="{{url('/')}}">Home</a>
                  </li>
                  <li class="breadcrumb-item text-white active" aria-current="page">
                  Contact
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </section>
   <!-- ====================================
      ———	BLOG GRID LEFT SIDEBAR
      ===================================== -->
      <section class="bg-light py-7 py-md-10">
        <div class="container">
            <div class="row wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
            <div class="col-sm-6 col-xs-12">
                <div class="section-title align-items-baseline mb-4">
                <h2 class="text-danger px-0 mb-0">Our Address</h2>
                </div>
                
                <ul class="list-unstyled">
                <li class="media align-items-center mb-3">
                    <div class="icon-rounded-circle-small bg-primary me-2">
                    <i class="fas fa-map-marker-alt text-white"></i>
                    </div>
                    <div class="media-body">
                    <p class="mb-0">3rd Gate, Near Shaheed Jahangir Gate, Dhaka 1206</p>
                    </div>
                </li>
                <li class="media align-items-center mb-3">
                    <div class="icon-rounded-circle-small bg-success me-2">
                    <i class="fas fa-envelope text-white"></i>
                    </div>
                    <div class="media-body">
                    <p class="mb-0"><a class="text-color" href="mailto:info@bafsd.edu.bd, infobafsd@gmail.com">info@bafsd.edu.bd, infobafsd@gmail.com</a></p>
                    </div>
                </li>
                <li class="media align-items-center mb-3">
                    <div class="icon-rounded-circle-small bg-info me-2">
                    <i class="fas fa-phone-alt text-white"></i>
                    </div>
                    <div class="media-body">
                    <p class="mb-0"><a class="text-color" href="tel:+৮৮০১৭০৪-০৯৬৪৫২">+৮৮০১৭০৪-০৯৬৪৫২ </a></p>
                    </div>
                </li>
                </ul>
            </div>
            <div class="col-sm-6 col-xs-12">
                <form>
                <div class="form-group form-group-icon">
                    <i class="fas fa-user" aria-hidden="true"></i>
                    <input type="text" class="form-control border-primary" placeholder="First name" required="">
                </div>
                <div class="form-group form-group-icon">
                    <i class="fas fa-envelope" aria-hidden="true"></i>
                    <input type="email" class="form-control border-success" placeholder="Email address" required="">
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
        </section>
</div>


@endsection