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
            .fixTableHead {
        overflow-y: auto;
        height: 90vh;
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
    <h4 class="py-3 mb-4"><a class="text-muted fw-light" href="{{url('admin/dashboard')}}">Dashboard /</a> <a class="text-muted fw-light" href="{{url('admin/studentsDashboard')}}">Student /</a> <a class="text-muted fw-light" href="{{url('admin/studentGetTypeStudent/'.$type)}}">{{$typedata[$type]}} /</a><a class="text-muted fw-light" href="{{url('admin/studentClassWise/'.$shifts->id.'/'.$type.'/'.$versions->id)}}">{{$shifts->shift_name}} /</a><a class="text-muted fw-light" href="{{url('admin/studentClassWise/'.$shifts->id.'/'.$type.'/'.$versions->id)}}">{{$versions->version_name}} /</a><a  href="{{url('admin/studentClassWiseSection/'.$shifts->id.'/'.$type.'/'.$versions->id.'/'.$class->id)}}">{{$class->class_name}}/</a>{{$section->section_name}}</h4>
    <div class="row">
    @php
            $i=0;
            @endphp





            <div class="table-responsive fixTableHead">
             <table class="table">
                <thead class="table-info">
                   <tr>
                      <!-- <th>#</th> -->
                      <th>Student ID</th>
                      <th>Name</th>
                      <th>Session</th>
                      <th>Version</th>
                      <th>Shift</th>
                      <th>Class</th>
                      <th>Section</th>
                      <th>Email/Phone</th>
                      <!-- <th>Actions</th> -->
                   </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($studentdata as $student)
                   <tr>
                      <!-- <td class="control">
                      </td> -->
                      <td>
                         {{$student->student_code??''}}
                      </td>
                      <td
                      data-bs-toggle="#modal"
                      data-bs-target="#fullscreenModal"
                       class="studentinfo" data-studentcode="{{$student->student_code}}">
                       <img src="{{$student->photo??asset('public/student.png')}}" alt="Avatar" class="rounded-circle avatar avatar-xs">
                      {{$student->first_name.' '.$student->last_name}}
                       </td>

                      <td>{{$student->session_name??''}}</td>
                      <td>{{$student->version_name??''}}</td>
                      <td>{{$student->shift_name??''}}</td>
                      <td>{{$student->class_name??''}}</td>
                      <td>{{$student->section_name??''}}</td>
                      <td>{{$student->email??''}}<br/>{{$student->mobile??''}}</td>
                      <!-- <td>
                         <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>
                                <div class="dropdown-menu" style="">
                                    <a class="dropdown-item edit"
                                    href="{{route('students.edit', $student->id)}}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                    <a class="dropdown-item delete" data-url="{{route('students.destroy', $student->id)}}" data-id="{{$student->id}}"  href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
                                </div>
                            </div>
                      </td> -->
                   </tr>
                   @endforeach

                </tbody>
             </table>

          </div>







    </div>
</div>
   <!-- / Content -->

   <div class="content-backdrop fade"></div>
</div>



@endsection
