  
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
    <div class="table-responsive-sm table-cart">
      <table class="table mb-0">
        <thead>
          <tr>
                        <th style="width: 10%">SL</th>
                        <th style="width: 15%">Dete</th>
                        <th  style="text-wrap: nowrap;width: 60%">Title</th>
                        <th style="width: 15%">Action</th>
          </tr>
        </thead>
        <tbody>

        @foreach($notices as $key=>$notice)
                     <tr class="alert border border-start-0 border-top-0 border-end-0 fade show" role="alert">
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
</section>   

</div>


@endsection