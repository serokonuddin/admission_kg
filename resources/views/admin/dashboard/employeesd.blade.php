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
      @php
      $i=2;
      @endphp
      @foreach($employeedata as $key=>$value)
      <div class="col-md-4 col-lg-6 mt-4">
      <a href="{{url('admin/getTeacherFor/'.$key)}}" target="_blank">
                    <div class="card bg-{{$color[$i++]}} text-white mb-3">
                        <div class="card-header">{{($key!='Staff')?'Teaching':'Non Teaching'}}</div>
                        <div class="card-body">
                        <h5 class="card-title text-white">Total: {{$value[0]->count}}</h5>
                        <p class="card-text"></p>
                        </div>
                    </div>
                    </a>
      </div>
      @endforeach



      <!--/ Conversion rate -->

      <!--/ Total Balance -->
   </div>
</div>


</div>
   <!-- / Content -->
   <div class="content-backdrop fade"></div>
</div>
@endsection
