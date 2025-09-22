  
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
   <section class="breadcrumb-bg" style="background-image: url({{asset('public')}}/assets/img/background/page-title-bg.jpg); ">
      <div class="container">
         <div class="breadcrumb-holder">
            <div>
               <h1 class="breadcrumb-title">{{$parent->title}}</h1>
               <ul class="breadcrumb breadcrumb-transparent">
                  <li class="breadcrumb-item">
                     <a class="text-white" href="{{url('/')}}">Home</a>
                  </li>
                  <li class="breadcrumb-item text-white active" aria-current="page">
                  {{$parent->title}}
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </section>
   <!-- ====================================
      ———	BLOG GRID LEFT SIDEBAR
      ===================================== -->
   <section class="py-1 py-md-1">
      <div class="container">
      <div class="row mt-8">
        <div class="col-md-4 col-lg-3 mb-lg-8">
            <div class="card card-product border-primary">
            <a class="img-link" href="{{url('page/red-health-club')}}">
                <img src="{{asset('public/club/Red Heart.jpg')}}" alt="products-category-img1">
            </a>
            <h3 class="bg-primary mb-0 py-4 ps-4">
                <a class="text-white font-size-20 font-weight-bold" href="{{url('page/red-health-club')}}">Red Heart Club</a>
            </h3>
            </div>
        </div>
        <div class="col-md-4 col-lg-3 mb-lg-8">
            <div class="card card-product border-primary">
            <a class="img-link" href="{{url('page/art-club')}}">
                <img src="{{asset('public/club/Art Club.jpeg')}}" alt="products-category-img1">
            </a>
            <h3 class="bg-primary mb-0 py-4 ps-4">
                <a class="text-white font-size-20 font-weight-bold" href="{{url('page/art-club')}}">Art Club</a>
            </h3>
            </div>
        </div>
        <div class="col-md-4 col-lg-3 mb-lg-8">
            <div class="card card-product border-primary">
            <a class="img-link" href="{{url('page/bncc')}}">
                <img src="{{asset('frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png')}}" alt="products-category-img1">
            </a>
            <h3 class="bg-primary mb-0 py-4 ps-4">
                <a class="text-white font-size-20 font-weight-bold" href="{{url('page/bncc')}}">BNCC</a>
            </h3>
            </div>
        </div>
        <div class="col-md-4 col-lg-3 mb-lg-8">
            <div class="card card-product border-primary">
            <a class="img-link" href="{{url('page/business-club')}}">
                <img src="{{asset('public/club/business.jpg')}}" alt="products-category-img1">
            </a>
            <h3 class="bg-primary mb-0 py-4 ps-4">
                <a class="text-white font-size-20 font-weight-bold" href="{{url('page/business-club')}}">Business Club</a>
            </h3>
            </div>
        </div>

            
            
        <div class="col-md-4 col-lg-3 mb-lg-8">
            <div class="card card-product border-primary">
            <a class="img-link" href="{{url('page/cultural-club')}}">
                <img src="{{asset('public/club/cultural.jpg')}}" alt="products-category-img1">
            </a>
            <h3 class="bg-primary mb-0 py-4 ps-4">
                <a class="text-white font-size-20 font-weight-bold" href="{{url('page/cultural-club')}}">Cultural Club</a>
            </h3>
            </div>
        </div>
        <div class="col-md-4 col-lg-3 mb-lg-8">
            <div class="card card-product border-primary">
            <a class="img-link" href="{{url('page/debate-club')}}">
                <img src="{{asset('public/club/debate.jpg')}}" alt="products-category-img1">
            </a>
            <h3 class="bg-primary mb-0 py-4 ps-4">
                <a class="text-white font-size-20 font-weight-bold" href="{{url('page/debate-club')}}">Debate Club</a>
            </h3>
            </div>
        </div>
        <div class="col-md-4 col-lg-3 mb-lg-8">
            <div class="card card-product border-primary">
            <a class="img-link" href="{{url('page/girls-guide')}}">
                <img src="{{asset('frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png')}}" alt="products-category-img1">
            </a>
            <h3 class="bg-primary mb-0 py-4 ps-4">
                <a class="text-white font-size-20 font-weight-bold" href="{{url('page/girls-guide')}}">Girls-Guide</a>
            </h3>
            </div>
        </div> 
            
        <div class="col-md-4 col-lg-3 mb-lg-8">
            <div class="card card-product border-primary">
            <a class="img-link" href="{{url('page/green-thumb')}}">
                <img src="{{asset('public/club/greenthumb.png')}}" alt="products-category-img1">
            </a>
            <h3 class="bg-primary mb-0 py-4 ps-4">
                <a class="text-white font-size-20 font-weight-bold" href="{{url('page/green-thumb')}}">Green Thumb</a>
            </h3>
            </div>
        </div>  
        <div class="col-md-4 col-lg-3 mb-lg-8">
            <div class="card card-product border-primary">
            <a class="img-link" href="{{url('page/it-club')}}">
                <img src="{{asset('public/club/IT Club.jpg')}}" alt="products-category-img1">
            </a>
            <h3 class="bg-primary mb-0 py-4 ps-4">
                <a class="text-white font-size-20 font-weight-bold" href="{{url('page/it-club')}}">IT Club</a>
            </h3>
            </div>
        </div>    
            
        <div class="col-md-4 col-lg-3 mb-lg-8">
            <div class="card card-product border-primary">
            <a class="img-link" href="{{url('page/language-club')}}">
                <img src="{{asset('public/club/language.jpg')}}" alt="products-category-img1">
            </a>
            <h3 class="bg-primary mb-0 py-4 ps-4">
                <a class="text-white font-size-20 font-weight-bold" href="{{url('page/language-club')}}">Language Club</a>
            </h3>
            </div>
        </div> 
            
        <div class="col-md-4 col-lg-3 mb-lg-8">
            <div class="card card-product border-primary">
            <a class="img-link" href="{{url('page/mental-health-&-well-being-club')}}">
                <img src="{{asset('public/club/Mental Health.jpg')}}" alt="products-category-img1">
            </a>
            <h3 class="bg-primary mb-0 py-4 ps-4">
                <a class="text-white font-size-20 font-weight-bold" href="{{url('page/mental-health-&-well-being-club')}}">Mental health & well being</a>
            </h3>
            </div>
        </div> 
        <div class="col-md-4 col-lg-3 mb-lg-8">
            <div class="card card-product border-primary">
            <a class="img-link" href="{{url('page/photography-club')}}">
                <img src="{{asset('public/club/photography.jpg')}}" alt="products-category-img1">
            </a>
            <h3 class="bg-primary mb-0 py-4 ps-4">
                <a class="text-white font-size-20 font-weight-bold" href="{{url('page/photography-club')}}">Photography Club</a>
            </h3>
            </div>
        </div> 
        <div class="col-md-4 col-lg-3 mb-lg-8">
            <div class="card card-product border-primary">
            <a class="img-link" href="{{url('page/ranger')}}">
                <img src="{{asset('frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png')}}" alt="products-category-img1">
            </a>
            <h3 class="bg-primary mb-0 py-4 ps-4">
                <a class="text-white font-size-20 font-weight-bold" href="{{url('page/ranger')}}">Ranger</a>
            </h3>
            </div>
        </div>  
        <div class="col-md-4 col-lg-3 mb-lg-8">
            <div class="card card-product border-primary">
            <a class="img-link" href="{{url('page/science-club')}}">
                <img src="{{asset('public/club/science.jpg')}}" alt="products-category-img1">
            </a>
            <h3 class="bg-primary mb-0 py-4 ps-4">
                <a class="text-white font-size-20 font-weight-bold" href="{{url('page/science-club')}}">Science Club</a>
            </h3>
            </div>
        </div>   
        <div class="col-md-4 col-lg-3 mb-lg-8">
            <div class="card card-product border-primary">
            <a class="img-link" href="{{url('page/scout')}}">
                <img src="{{asset('frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png')}}" alt="products-category-img1">
            </a>
            <h3 class="bg-primary mb-0 py-4 ps-4">
                <a class="text-white font-size-20 font-weight-bold" href="{{url('page/scout')}}">Scout</a>
            </h3>
            </div>
        </div>   
           
        <div class="col-md-4 col-lg-3 mb-lg-8">
            <div class="card card-product border-primary">
            <a class="img-link" href="{{url('page/sports-club')}}">
                <img src="{{asset('frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png')}}" alt="products-category-img1">
            </a>
            <h3 class="bg-primary mb-0 py-4 ps-4">
                <a class="text-white font-size-20 font-weight-bold" href="{{url('page/sports-club')}}">Sports Club</a>
            </h3>
            </div>
        </div>  
            
        <div class="col-md-4 col-lg-3 mb-lg-8">
            <div class="card card-product border-primary">
            <a class="img-link" href="{{url('page/writers-club')}}">
                <img src="{{asset('frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png')}}" alt="products-category-img1">
            </a>
            <h3 class="bg-primary mb-0 py-4 ps-4">
                <a class="text-white font-size-20 font-weight-bold" href="{{url('page/writers-club')}}">Writers Club</a>
            </h3>
            </div>
        </div>  
           

            
            
            
         </div>
      </div>
      
   </section>
</div>


@endsection