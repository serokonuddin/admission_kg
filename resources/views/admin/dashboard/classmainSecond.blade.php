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
   <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{url('admin/dashboard')}}">Dashboard</a> /</span><a href="{{url('admin/classDashboard')}}">Class</a>/<span class="text-muted fw-light">{{($for==1)?'Ongoing Class':'Class Routing'}}</span></h4>
    @if($for==1)
   <div class="row">

        <div class="col-md-6 col-12 mb-md-0 mb-4">
         <a href="{{url('admin/classDashboardOngoingDetails/1/1/College')}}">
                        <div class="card bg-{{$color[6]}} text-white mb-3">
                            <div class="card-header">College Ongoing Class</div>
                            <div class="card-body">
                            <h5 class="card-title text-white">Shift: Morning</h5>
                            <p class="card-text">Version: Bangla</p>
                            </div>
                        </div>
        </a>
        </div>
         @php
            $i=0;
            @endphp
            @foreach($type_for as $key=>$type)
                @foreach($shifts as $key1=>$shift)
                    @foreach($versions as $key1=>$version)
                <div class="col-md-6 col-12 mb-md-0 mb-4">
                        <a href="{{url('admin/classDashboardOngoingDetails/'.$shift->id.'/'.$version->id.'/'.$type)}}">
                            <div class="card bg-{{$color[$i++]}} text-white mb-3">
                                <div class="card-header">{{$type}} Ongoing Class</div>
                                <div class="card-body">
                                <h5 class="card-title text-white">Shift: {{$shift->shift_name}}</h5>
                                <p class="card-text">Version: {{$version->version_name}}</p>
                                </div>
                            </div>
                        </a>
            </div>
                    @endforeach
                @endforeach
            @endforeach



        </div>

      </div>


   </div>
   @else
   <div class="row">

        <div class="col-md-6 col-12 mb-md-0 mb-4">
         <a href="{{url('admin/classDashboardDetailsRoutine/1/1/College')}}">
                        <div class="card bg-{{$color[6]}} text-white mb-3">
                            <div class="card-header">College Routine Class</div>
                            <div class="card-body">
                            <h5 class="card-title text-white">Shift: Morning</h5>
                            <p class="card-text">Version: Bangla</p>
                            </div>
                        </div>
        </a>
        </div>
         @php
            $i=0;
            @endphp
            @foreach($type_for as $key=>$type)
                @foreach($shifts as $key1=>$shift)
                    @foreach($versions as $key1=>$version)
                <div class="col-md-6 col-12 mb-md-0 mb-4">
                        <a href="{{url('admin/classDashboardDetailsRoutine/'.$shift->id.'/'.$version->id.'/'.$type)}}">
                            <div class="card bg-{{$color[$i++]}} text-white mb-3">
                                <div class="card-header">{{$type}} Routine Class</div>
                                <div class="card-body">
                                <h5 class="card-title text-white">Shift: {{$shift->shift_name}}</h5>
                                <p class="card-text">Version: {{$version->version_name}}</p>
                                </div>
                            </div>
                        </a>
            </div>
                    @endforeach
                @endforeach
            @endforeach



        </div>

      </div>


   </div>
   @endif
   <!-- / Content -->
   <div class="content-backdrop fade"></div>
</div>
@endsection
