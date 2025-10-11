@extends('admin.layouts.layout')
@section('content')
<style>
    .bx {
        vertical-align: middle;
        font-size: 2.15rem;
        line-height: 1;
    }
    .text-capitalize {
        text-transform: capitalize !important;
        font-size: 25px;
    }
    @media (min-width: 1200px) {
            h4, .h4 {
                font-size: 1.075rem;
            }
        }

        .table:not(.table-dark) th {


            color: rgb(0,149,221)!important;
        }
        .table-dark th {
                border-bottom-color: rgb(0,149,221)!important;
            }
</style>
@php
$color=array('primary','warning','danger','info','success','primary','warning','danger','info','success','primary','warning','danger','info','success','primary','warning','danger','info','success','primary','warning','danger','info','success','primary','warning','danger','info','success','primary','warning','danger','info','success','primary','warning','danger','info','success');
@endphp
<div class="content-wrapper">
   <!-- Content -->
   <div class="container-xxl flex-grow-1 container-p-y">
   <h4 class="py-3 mb-4">
      <span class="text-muted fw-light">Dashboard </span>
   </h4>
   <!-- Card Border Shadow -->
   <div class="row">
   <h5 class="m-0 me-2">Ongoing Class</h5>

    @foreach($routinecurrenttime as $key=>$value)
   <div class="col-sm-6 col-lg-3 mb-4">
      <div class="card card-border-shadow-{{$color[$key]}} h-100">
         <div class="card-body">
            <div class="d-flex align-items-center mb-2 pb-1">

               <h4 class="ms-1 mb-0 text-warning">{{$value->employee->employee_name??''}}</h4>
            </div>
            <p class="mb-1 text-info">{{$value->subject[0]->subject_name??''}}</p>
            <p class="mb-0">

               <small class="text-muted text-primary">{{$value->classes->class_name??''}} ({{$value->section->section_name??''}})</small>
               <span class="fw-medium me-1 text-danger" style="display:block ">{{$value->start_time??''}}-{{$value->end_time??''}}</span>
            </p>
         </div>
      </div>
   </div>
   @endforeach

</div>


</div>
   <!-- / Content -->
   <div class="content-backdrop fade"></div>
</div>
@endsection
