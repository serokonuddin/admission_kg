@extends('frontend.layout')
@section('content')




<div class="container spacet60">
   <div class="row">
      <div class="col-md-12 spacet60 pt-0-mobile">
         <h1>{{$pagedata->title}}</h1>
         {!! $pagedata->details !!}
         <div class="mediarow spaceb50">
            <div class="row">
               <div class="gallery">
                @if($pagedata->image)
               <iframe
                    src="{{$pagedata->image}}"
                    width="100%"
                    height="600px"
                    loading="lazy"
                    title="PDF-file"
                ></iframe>
                @endif
               </div>
            </div>
         </div>
      </div>
   </div>
   <!--./row-->
</div>
@endsection