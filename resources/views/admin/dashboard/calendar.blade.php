@extends('admin.layouts.layout')
@section('content')
@php
$color=array('primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark');

            $colordata=array('primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark');
@endphp

<div class="content-wrapper">
   <!-- Content -->
   <div class="container-xxl flex-grow-1 container-p-y">
   <h4 class="py-3 mb-4">
      <span class="text-muted fw-light">Dashboard </span>
   </h4>
   <!-- Card Border Shadow -->
   <div class=" flex-grow-1 container-p-y">

   <div class="row">
      <!-- Performance -->

      <div class="col-md-6 col-lg-6 mt-4">
      <a href="{{url('admin/calendarDashboard/1')}}">
                    <div class="card bg-{{$color[0]}} text-white mb-3">
                        <div class="card-header">Year Calendar</div>
                        <div class="card-body">
                        <h5 class="card-title text-white">Current Year Calendar</h5>
                        <p class="card-text"></p>
                        </div>
                    </div>
                    </a>
      </div>
      <div class="col-md-6 col-lg-6 mt-4">
      <a href="{{url('admin/calendarDashboard/3')}}">
                    <div class="card bg-{{$color[3]}} text-white mb-3">
                        <div class="card-header">Year Calendar</div>
                        <div class="card-body">
                        <h5 class="card-title text-white">Year Calendar Upcomming</h5>
                        <p class="card-text"></p>
                        </div>
                    </div>
                    </a>
      </div>
      <div class="col-md-6 col-lg-6 mt-4">
      <a href="{{url('admin/calendarDashboard/2')}}">
                    <div class="card bg-{{$color[2]}} text-white mb-3">
                        <div class="card-header">Year Calendar</div>
                        <div class="card-body">
                        <h5 class="card-title text-white">Year Calendar Present</h5>
                        <p class="card-text"></p>
                        </div>
                    </div>
                    </a>
      </div>
      <div class="col-md-6 col-lg-6 mt-4">
      <a href="{{url('admin/calendarDashboard/4')}}">
                    <div class="card bg-{{$color[5]}} text-white mb-3">
                        <div class="card-header">Year Calendar</div>
                        <div class="card-body">
                        <h5 class="card-title text-white">Full Year Calendar</h5>
                        <p class="card-text"></p>
                        </div>
                    </div>
                    </a>
      </div>

      <!--/ Conversion rate -->

      <!--/ Total Balance -->
   </div>
</div>


</div>
   <!-- / Content -->
   <div class="content-backdrop fade"></div>
</div>
@endsection
