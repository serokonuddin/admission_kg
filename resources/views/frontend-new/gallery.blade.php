  
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
               <h1 class="breadcrumb-title">{{$pagedata->title}}</h1>
               <ul class="breadcrumb breadcrumb-transparent">
                  <li class="breadcrumb-item">
                     <a class="text-white" href="{{url('/')}}">Home</a>
                  </li>
                  <li class="breadcrumb-item text-white active" aria-current="page">
                  {{$pagedata->title}}
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
      @foreach($galleries as $gallery)
       <div class="col-md-6 col-lg-4">
            <div class="gallery card">
                <div class="position-relative">
                    <a href="{{url('gallarydetails/'.$gallery->id)}}">
                    @php
                    $files=explode(",",$gallery->file)
                    @endphp
                    <img class="card-img-top" src="{{$files[0]??''}}" alt="Card image">
                    </a>
                    <div class="card-img-overlay p-0 border-primary border-bottom-0">
                        {{-- <span class="badge badge-rounded bg-primary m-4"> {{count($files)}}</span> --}}
                    </div>
                </div>
                <div class="card-body px-3 rounded-bottom border-primary">
                    <h3 class="card-title">
                        <a class="text-primary text-capitalize d-block text-truncate" href="{{url('gallarydetails/'.$gallery->id)}}">{{$gallery->title}}</a>
                    </h3>
                </div>
            </div>
        </div>
      @endforeach
         </div>
      </div>
      
   </section>
</div>


@endsection