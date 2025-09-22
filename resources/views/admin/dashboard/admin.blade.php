@extends('admin.layouts.layout')
@section('content')
<style type="text/css">
.highcharts-figure,
.highcharts-data-table table {
    min-width: 320px;
    max-width: 800px;
    margin: 1em auto;
}

.highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #ebebeb;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
}

.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}

.highcharts-data-table th {
    font-weight: 600;
    padding: 0.5em;
}

.highcharts-data-table td,
.highcharts-data-table th,
.highcharts-data-table caption {
    padding: 0.5em;
}

.highcharts-data-table thead tr,
.highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}

.highcharts-data-table tr:hover {
    background: #f1f7ff;
}

input[type="number"] {
    min-width: 50px;
}
.content-wrapper .badge.badge-notifications:not(.badge-dot) {
    padding: 0.7rem 0.9rem !important;
    font-size: .882rem !important;
    line-height: 1.0rem !important;
}
.badge.badge-notifications {
    position: absolute;
    top: auto;
    display: inline-block;
    margin: 0;
    margin-top: -10px;
    margin-right: 0px;
    margin-bottom: 0px;
    margin-left: 0px;
}
.ml-1{
  margin-left: 25px!important;
}
.ml-2{
    margin-left: 20px!important;
}
.ml-4{
    margin-left: 40px!important;
}
.rounded-circle {
    border-radius: 50% !important;
    border: 1px solid #eee!important;
}
.avatar-xs{
    border-radius: 50% !important;
    border: 1px solid #7a7878!important;
    width: 1.825rem!important;
    height: 1.825rem!important;
}
.avatar-xs a{
    margin-left: 4px;
}
.avatar {
    position: relative;
    width: 1.675rem!important;
    height: 1.675rem!important;
    cursor: pointer;
}
.badge {
    --bs-badge-padding-x: 0.193em;
    --bs-badge-padding-y: 0.22em;
    --bs-badge-font-size: 1.0em;
}
</style>
@php
            $colordata=array('primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark');
@endphp
<div class="content-wrapper">
   <!-- Content -->
   <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-md-12 col-12 mb-md-0 mb-4">
         <h3>Student Attendance</h3>
      </div>
      @foreach($type_for as $key=>$type)
      @php
           $statusdata=array();
            if(isset($studentAttandance[$key])){
                $statusdata=collect($studentAttandance[$key])->groupBy('status');
            }

      @endphp
      <div class="col-md-4 col-12 mb-md-0 mb-4">
        <a href="{{url('admin/attendanceDashboardDetails/'.$type)}}">
                    <div class="card bg-{{$colordata[$key]}} text-white mb-3">
                        <h4 class="card-header">{{$type}} Attendance </h4>
                        <div class="card-body">
                        <p class="card-title text-white">Total: {{$studentdata[$key][0]->count??''}}</p>
                        <p class="card-title text-white">Present: {{$statusdata[1][0]->count??''}}</p>
                        <p class="card-text">Absent: {{$statusdata[2][0]->count??''}}</p>
                        <p class="card-text">Late: {{$statusdata[4][0]->count??''}}</p>
                        <p class="card-text">Leave: {{$statusdata[3][0]->count??''}}</p>
                        </div>
                    </div>
                    </a>
      </div>
      @endforeach

       <div class="col-md-12 col-12 mb-md-0 mb-4">
            <h3>Employee Attendance</h3>
       </div>
       @php
           $statusdata=array();
            if(isset($employeedataAttandance[7])){
                $statusdata=collect($employeedataAttandance[7])->groupBy('status');
            }

      @endphp
         <div class="col-md-4 col-12 mb-md-0 mb-4">
                 <a href="{{url('admin/attendanceDashboardDetailsEmployee/1')}}">
                    <div class="card bg-{{$colordata[4]}} text-white mb-3">
                        <h4 class="card-header">Teacher Attendance</h4>
                        <div class="card-body">
                        <p class="card-title text-white">Total: {{$employeedata['Teacher'][0]->count??''}}</p>
                        <p class="card-title text-white">Present: {{$statusdata[1][0]->count??''}}</p>
                        <p class="card-text">Absent: {{$statusdata[2][0]->count??''}}</p>
                        <p class="card-text">Late: {{$statusdata[4][0]->count??''}}</p>
                        <p class="card-text">Leave: {{$statusdata[3][0]->count??''}}</p>
                        </div>
                    </div>
                    </a>
      </div>
      @php
           $statusdata=array();
            if(isset($employeedataAttandance[8])){
                $statusdata=collect($employeedataAttandance[8])->groupBy('status');
            }

      @endphp
      <div class="col-md-4 col-12 mb-md-0 mb-4">
                 <a href="#">
                    <div class="card bg-{{$colordata[5]}} text-white mb-3">
                        <div class="card-header">Non Teaching Attendance</div>
                        <div class="card-body">
                        <p class="card-title text-white">Total: {{$employeedata['Staff'][0]->count??''}}</p>
                        <p class="card-title text-white">Present: {{$statusdata[1][0]->count??''}}</p>
                        <p class="card-text">Absent: {{$statusdata[2][0]->count??''}}</p>
                        <p class="card-text">Late: {{$statusdata[4][0]->count??''}}</p>
                        <p class="card-text">Leave: {{$statusdata[3][0]->count??''}}</p>
                        </div>
                    </div>
                    </a>
      </div>
      </div>


   </div>
   <!-- / Content -->
   <div class="content-backdrop fade"></div>
</div>
@endsection
