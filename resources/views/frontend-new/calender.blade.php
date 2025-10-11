  
@extends('frontend-new.layout')
@section('content')

@php 
            $colors=array('bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink');
            $cs=array('primary','danger','success','info','purple','pink','info');
            $icons=array('fas fa-home','far fa-building','fas fa-graduation-cap','fas fa-balance-scale','fas fa-biking','fas fa-certificate','fas fa-comment-dots','fas fa-camera-retro','fas fa-map','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink','bg-primary','bg-danger','bg-success','bg-info','bg-purple',' bg-pink');
        @endphp

        @php
$years=["Jan-24"
  ,"Feb-24"
  ,"Mar-24"
  ,"Apr-24"
  ,"May-24"
  ,"Jun-24"
  ,"Jul-24"
  ,"Aug-24"
  ,"Sep-24"
  ,"Oct-24"
  ,"Nov-24"
  ,"Dec-24"
]
@endphp
<style>
   table{
      width:100%!important;
   }
   table td{
      text-align: center!important;
      border: 1px solid #56569e!important;
      padding: 2px!important;
      font-size:10px!important;
   }
   table td.red{
      color: white!important;
      background-color: #1dabcb!important;
   }
   table td.blue{
      color: white!important;
      background-color: #1c1c74!important;
   }
   th 
   {
   vertical-align: bottom;
   text-align: center;
   border: 1px solid #56569e!important;
   }

   th span 
   {
   -ms-writing-mode: tb-rl;
   -webkit-writing-mode: vertical-rl;
   writing-mode: vertical-rl;
   transform: rotate(180deg);
   white-space: nowrap;
   font-size: 10px!important;
   }
</style>
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
    <table class="table">
                  <tr>
                    <tr> <td colspan="37">Graphical Academic Calendar for all BAF Shaheen Colleges (School Section:{{date('Y')}})</td></tr>
                  </tr>
                  @foreach($data as $k=>$month)
                  <tr>
                     <th rowspan="3"><span>{{$years[$k-1]}}</span></th>
                     <td >Day</td>
                     @foreach($month['days'] as $key=>$day)
                     @if($day=='Fri' || $day=='Sat')
                     <td class="red">{{$day}}</td>
                     @else 
                     <td >{{$day}}</td>
                     @endif

                     @endforeach
                     
                  </tr>
                  <tr>
                   <td >Date</td>
                     @foreach($month['date'] as $key=>$date)
                     @if($month['days'][$key]=='Fri' || $month['days'][$key]=='Sat')
                     <td class="red">{{$date}}</td>
                     @else 
                     <td >{{$date}}</td>
                     @endif
                     @endforeach
                  </tr>
                  <tr>
                   <td >KG-X</td>
                     @php
                     $previoustitle='';
                     $endtitle=end($month['KG-X']);
                     $endresult=explode('-',$endtitle);
                     $extr=0;
                     @endphp
                     @foreach($month['KG-X'] as $key=>$kgx)
                        @php 
                        $result=explode('-',$kgx);
                        @endphp
                        @if($kgx=='')
                        <td></td>
                        @elseif(isset($endresult[3]) && isset($result[3]) && $endresult[3]==$result[3] && $key==0)
                        <td class="{{($result[2]==1)?'red':'blue'}}"></td>
                        @php 
                        $extr=1;
                        @endphp
                        @else
                        @php 
                           
                        
                        @endphp
                           
                           @if($result[0]==0)
                           <td>{{$result[1]}}</td>
                           @elseif($result[0]==2)
                           <td class="red"></td>
                           @elseif($result[0]==1)
                              @if($previoustitle!=$result[3])
                              <td class="{{($result[2]==1)?'red':'blue'}}" colspan="{{$result[1]-$extr}}">{{$result[3]}}</td>
                              @php 
                              $previoustitle=$result[3];
                              @endphp
                              @else 
                              
                              @endif

                           @endif
                        @endif
                     @endforeach
                  </tr>
                  @endforeach
               </table>
    </div>

    
  </div>
</section>   

</div>


@endsection