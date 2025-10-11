@extends('frontend.layout')
@section('content')
<div class="container spacet60">
   <div class="row">
    <h1 style="text-align: center">{{$pagedata->title}}</h1>
      <div class="col-md-12 pt-0-mobile">
      
         <div class="container spaceb60">
            <div class="row">
            <div class="col-md-12">
               <table class="table table-striped table-bordered">
                  <thead>
                     <tr>
                        <th>SL</th>
                        <th>Dete</th>
                        <th>Title</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($notices as $key=>$notice)
                     <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$notice->publish_date}}</td>
                        <td>{{$notice->title}}</td>
                        <td><a href="{{url('detiales/'.$notice->id)}}" class="onlineformbtn mdbtn mb12" name="search" id="search_btn">View</a></td>
                     </tr>
                     @endforeach
                     
                  </tbody>
               </table>
            </div>
               
            </div>
         </div>
         <!-- <h2 class="courses-head text-center"></h2> -->
         <input type="hidden" name="page_content_type" id="page_content_type" value="">
         <div class="post-list spaceb50" id="postList" style="overflow:hidden;">
         </div>
         <script>
            function searchFilter(page_num) {
                page_num = page_num ? page_num : 0;
                var page_content_type = $('#page_content_type').val();
            
                $.ajax({
                    type: 'POST',
                    url: 'https://#/welcome/ajaxPaginationData/' + page_num,
                    data: 'page=' + page_num + '&page_content_type=' + page_content_type,
                    beforeSend: function () {
                        $('.loading').show();
                    },
                    success: function (html) {
                        $('#postList').html(html);
                        $('.loading').fadeOut("slow");
                    }
                });
            }
            function refreshCaptcha(){
                $.ajax({
                    type: "POST",
                    url: "https://#/site/refreshCaptcha",
                    data: {},
                    success: function(captcha){
                        $("#captcha_image").html(captcha);
                    }
                });
            }    
         </script>                
      </div>
   </div>
   <!--./row-->
</div>
@endsection