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
            td {
        text-align: left!important;
        word-wrap: break-word!important;
        }

</style>
@php
$color=array('primary','warning','danger','info','success','primary','warning','danger','info','success','primary','warning','danger','info','success','primary','warning','danger','info','success','primary','warning','danger','info','success','primary','warning','danger','info','success','primary','warning','danger','info','success','primary','warning','danger','info','success');
@endphp
<div class="content-wrapper">
   <!-- Content -->
   <div class="container-xxl flex-grow-1 container-p-y">
   <h4 class="py-3 mb-4">
      <span class="text-muted fw-light"><a href="{{url('admin/dashboard')}}">Dashboard</a> /</span> {{$type}} Class Routine
   </h4>
   <!-- Card Border Shadow -->


            @foreach($sections as $key=>$section)
            @if(count($section->routinetime)>0)
             <div class="card mt-4">
                <h5 class="card-header ">Class: {{$section->class_name}} Section: {{$section->section_name}}</h5>
                <div class="table-responsive text-nowrap fixTableHead">
                    <table class="table table-bordered table-{{$color[$key]}}">
                        <thead >
                        <tr>

                            <th>#</th>
                            @foreach($section->routinetime as $key=>$routined)
                            <th style="text-align: center">{{$key+1}}<br/>
                                {{date('H:i',strtotime($routined->start_time)).'-'.date('H:i',strtotime($routined->end_time))}}
                            </th>
                            @endforeach

                        </tr>
                        </thead>
                        <tbody>
                            @foreach($section->routine as $key=>$data)

                            <tr>
                                <td>
                                    {{$key}}
                                </td>
                                @foreach($section->routinetime as $key2=>$routined)
                                @if(isset($data[$routined->start_time]))


                                <td >
                                @foreach($data[$routined->start_time] as $key1=>$value)
                                    <div class="bottom-bar" id="row{{$value->id}}">Teacher: {{$value->employee->employee_name??''}} <br/>
                                                    @if($value->is_class_teacher==1)
                                                    <span style="color: red;font-wigdth: bold">Class Teacher</span><br/>
                                                    @endif
                                                    Subject: {{$value->subject[0]->subject_name??''}}</br>


                                    </div>
                                    @endforeach
                                </td>

                                @endif
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
              </div>
            @endif
            @endforeach
</div>



   <!-- / Content -->
   <div class="content-backdrop fade"></div>
</div>
@endsection
