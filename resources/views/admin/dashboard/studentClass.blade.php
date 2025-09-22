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
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> <span class="text-muted fw-light">Student /</span> <span class="text-muted fw-light">{{$typedata[$type]}} /</span><span class="text-muted fw-light">{{$shifts->shift_name}} /</span>{{$versions->version_name}}</h4>
    <div class="row">
    @php
            $i=0;
            @endphp

            @foreach($studentdata as $key4=>$class)




                    <div class="col-md-6 col-xl-4">
                        <a href="{{url('admin/studentClassWiseSection/'.$class[0]->shift_id.'/'.$type.'/'.$class[0]->version_id.'/'.$class[0]->class_code)}}">
                                <div class="card bg-{{$color[$i++]}} text-white mb-3">
                                <div class="card-header">{{$class[0]->class_name}}</div>
                                <div class="card-body">
                                <h5 class="card-title text-white">Shift: {{$class[0]->shift_name}}</h5>
                                <p class="card-text">Version: {{$class[0]->version_name}}</p>
                                <p class="card-text">Total: {{$class[0]->count}}</p>
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
