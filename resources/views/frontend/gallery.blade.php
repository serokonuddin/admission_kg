@extends('frontend.layout')
@section('content')
<div class="container spacet60">
<div class="row">
   <div class="col-md-12 spacet60 pt-0-mobile">
      <h2>Gallery</h2>
      <!-- <h2 class="courses-head text-center">Gallery</h2> -->
      <input type="hidden" name="page_content_type" id="page_content_type" value="gallery">
      <div class="post-list spaceb50" id="postList" style="overflow:hidden;">
         <div class="row">
            @foreach($galleries as $gallery)
            <div class="col-md-4 col-sm-4">
               <div class="eventbox">
                  <a href="{{url('gallarydetails/'.$gallery->id)}}">
                    @php
                    $files=explode(",",$gallery->file)
                    @endphp
                     <img src="{{$files[0]??''}}" alt="" title="">
                     <div class="evcontentfix">
                        <h3>{{$gallery->title}}</h3>                                      
                     </div>
                     <!--./around20-->
                  </a>
               </div>
               <!--./eventbox-->
            </div>
            @endforeach
            
         </div>
         
      </div>
      <script>
            
      </script>                
   </div>
</div>
<!--./row-->
</div><!--./container-->
@endsection