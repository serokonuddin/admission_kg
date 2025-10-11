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
$color=array('primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark');
$typedata=array(1=>'Primary',2=>'Secondary',3=>'College');
            $colordata=array('primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark');
@endphp

<div class="content-wrapper">
   <!-- Content -->
   <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> <span class="text-muted fw-light">Student /</span> <span class="text-muted fw-light">{{$typedata[$type]}} /</span><span class="text-muted fw-light">{{$shifts->shift_name}} /</span><span class="text-muted fw-light">{{$versions->version_name}} /</span>{{$class->class_name}}</h4>
    <div class="row">
    @php
            $i=0;
            @endphp

            @foreach($studentdata as $key4=>$section)




                    <div class="col-md-6 col-xl-4">
                        <a href="{{url('admin/studentList/'.$section[0]->shift_id.'/'.$type.'/'.$section[0]->version_id.'/'.$section[0]->class_code.'/'.$section[0]->section_id)}}">
                                <div class="card bg-{{$color[$i++]}} text-white mb-3">
                                <div class="card-header">{{$section[0]->section_name}} ({{$section[0]->class_name}})</div>
                                <div class="card-body">
                                <h5 class="card-title text-white">Shift: {{$section[0]->shift_name}}</h5>
                                <p class="card-text">Version: {{$section[0]->version_name}}</p>
                                <p class="card-text">Total: {{$section[0]->count}}</p>
                                </div>
                                </div>
                        </a>
                    </div>



            @endforeach


    </div>
</div>
   <!-- / Content -->

   <div class="content-backdrop fade"></div>
</div>



@endsection
