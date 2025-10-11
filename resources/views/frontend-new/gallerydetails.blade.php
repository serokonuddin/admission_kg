  
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
               <h1 class="breadcrumb-title">{{$gallery->title}}</h1>
               <ul class="breadcrumb breadcrumb-transparent">
                  <li class="breadcrumb-item">
                     <a class="text-white" href="{{url('/')}}">Home</a>
                  </li>
                  <li class="breadcrumb-item text-white active" aria-current="page">
                  {{$gallery->title}}
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </section>
   <!-- ====================================
      ———	BLOG GRID LEFT SIDEBAR
      ===================================== -->
      @php
                    $files=explode(",",$gallery->file)
                    @endphp
   <section class="py-1 py-md-1">
      <div class="container">
      <div class="row">
      <div id="gallery-grid">
         <div class="row grid" style="position: relative; height: 487.458px;">
            @foreach($files as $file)
            <div class="col-md-4 col-lg-3 col-xs-12 element-item nature" style="position: absolute; left: 0px; top: 0px;">
               <div class="media media-hoverable justify-content-center">
                  <div class="position-relative w-100">
                     <img class="media-img w-100" src="{{$file}}" data-src="{{$file}}" alt="gallery-img">
                     <a class="media-img-overlay" data-fancybox="gallery" href="{{$file}}">
                        <div class="btn btn-squre">
                           <i class="fa fa-search-plus"></i>
                        </div>
                     </a>
                  </div>
               </div>
            </div>
            @endforeach
            
         </div>
      </div>
         </div>
      </div>
      
   </section>
</div>


@endsection