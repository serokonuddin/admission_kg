  
@extends('frontend-new.layout')
@section('content')

@php 
            $colors=array('bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink');
            $cs=array('primary','danger','success','info','purple','pink','info');
            $icons=array('fas fa-home','far fa-building','fas fa-graduation-cap','fas fa-balance-scale','fas fa-biking','fas fa-certificate','fas fa-comment-dots','fas fa-camera-retro','fas fa-map','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink');
        @endphp
<style>
    .table-cart thead tr th {
    color: #fff;
    background-color: #ffc107;
    padding: 15px 8px;
   
}
	iframe img{
		width: 90%;
	}
</style>
<div class="main-wrapper blog-grid-left-sidebar">
   <!-- ====================================
      ———	BREADCRUMB
      ===================================== -->
      <section class="breadcrumb-bg" style="background-image: url({{asset('public')}}/assets/img/background/page-title-bg.jpg); ">
      <div class="container">
         <div class="breadcrumb-holder">
            <div>
               <h1 class="breadcrumb-title"> {{$pagedata->title}}</h1>
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
            <div class="py-5">
            <div class="section-title align-items-baseline">
                <h3 class="text-primary font-weight-bold pl-0 mb-3">{{$pagedata->title}}</h3>
            </div>
            {!! $pagedata->details !!}
				
			@php 
				$allowedExtensions = ['jpg', 'png', 'gif','pdf'];
				$file = $pagedata->image;
				$extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
				
			@endphp
            <div class="mediarow spaceb50">
                <div class="row">
                    <div class="gallery">
                        @if($pagedata->image)
						@if($extension=='pdf' || $extension=='PDF')
                         <iframe
                            src="{{$pagedata->image}}"
                            width="100%"
                            height="600px"
                            loading="lazy"
                            title="PDF-file"
                        ></iframe>
						@else
						 <img src="{{$pagedata->image}}" style="width: 100%!important">
						@endif
						
                        @endif
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>


@endsection