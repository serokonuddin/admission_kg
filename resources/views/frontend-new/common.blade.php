  
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
   <section class="py-8 py-md-10">
      <div class="container">
         <div class="row">
            <div class="col-md-8 col-lg-9 order-md-1">
               <div class="row">
                    {!! $pagedata->details !!}
               </div>
            </div>
            @if(count($subpages)>0)
            <div class="col-md-4 col-lg-3">
               
               <div class="card shadow-none bg-transparent">
                  <h4 class="card-header font-weight-bold bg-success rounded-top text-white">{{$parent->title}}</h4>
                  <div class="card-body border border-top-0 rounded-bottom">
                     <ul class="list-unstyled mb-0">
                       @foreach($subpages as $sub)
                       
                        <li class="mb-2">
                        @if($sub->slug!='#')
                            <a class="text-muted font-weight-medium d-block border rounded py-2 ps-3" href="{{$sub->slug}}">{{$sub->title}}</a>
                        @else 
                            <a class="text-muted font-weight-medium d-block border rounded py-2 ps-3" href="#">{{$sub->title}}</a>
                        @endif
                          
                        </li>
                        @endforeach
                        
                     </ul>
                  </div>
               </div>
               
            </div>
            @endif
         </div>
      </div>
      
   </section>
</div>


@endsection