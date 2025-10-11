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
                font-size: 1.275rem;
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
$color=array('primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark');

            $colordata=array('primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark');
@endphp
<div class="content-wrapper">
   <!-- Content -->
   <div class="container-xxl flex-grow-1 container-p-y">
   <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{url('admin/dashboard')}}">Dashboard </a>/</span>Class</h4>
    <div class="row">
        <div class="col-md-6 col-12 mb-md-0 mb-4">

         <a href="{{url('admin/classDashboardSecond/1')}}">
                        <div class="card bg-{{$color[3]}} text-white mb-3">
                            <div class="card-header">Ongoing Class</div>
                            <div class="card-body">
                            <h5 class="card-title text-white">Shift: Morning</h5>
                            <p class="card-text">Version: Bangla</p>
                            </div>
                        </div>
        </a>




        </div>
        <div class="col-md-6 col-12">

            <a href="{{url('admin/classDashboardSecond/2')}}">
                        <div class="card bg-{{$color[2]}} text-white mb-3">
                            <div class="card-header">College Class Routine</div>
                            <div class="card-body">
                            <h5 class="card-title text-white">Shift: Day</h5>
                            <p class="card-text">Version: Bangla</p>
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
