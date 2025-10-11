@extends('frontend.layout')
@section('content')
<div class="container spacet60">
   <div class="row">
      <div class="col-md-12 spacet60 pt-0-mobile">
         <h1>{{$gallery->title}}</h1>
         <p></p>
        {!!$gallery->details!!}
         <p></p>
         @php
                    $files=explode(",",$gallery->file)
                    @endphp
         <div class="mediarow spaceb50">
            <div class="row">
               <div class="gallery">
                @foreach($files as $file)
                  <div class="col-sm-6 col-md-4 col-lg-4 img_div_modal">
                     <div class="galleryfancy">
                        <div class="gallheight">
                           <a href="{{$file}}" data-toggle="lightbox" data-gallery="mixedgallery" data-title="a">
                              <img alt="" src="{{$file}}">
                              <div class="content-overlay"></div>
                              <div class="overlay-details fadeIn-bottom">
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
   </div>
   <!--./row-->
</div>
@endsection