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
            $employee_for=array(1=>'Primary',2=>'Secondary',3=>'College');
@endphp

<div class="content-wrapper">
   <!-- Content -->
   <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><a class="text-muted fw-light" href="{{url('admin/dashboard')}}">Dashboard /</a> {{$typedata[$for]}} Teacher</h4>
    <div class="row">
    @php
            $i=0;
            @endphp





            <div class="table-responsive fixTableHead">
             <table class="table">
                <thead class="table-info">
                   <tr>
                      <!-- <th>#</th> -->
                      <th>Employee ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Designation</th>

                      <!-- <th>Actions</th> -->
                   </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($employeedata as $employee)
                   <tr>
                      <!-- <td class="control">
                      </td> -->
                      <td>
                         {{$employee->emp_id??''}}
                      </td>
                      <td
                      data-bs-toggle="#modal"
                      data-bs-target="#fullscreenModal"
                       class="studentinfo" data-studentcode="{{$employee->id}}">
                       <img src="{{$employee->photo??asset('public/student.png')}}" alt="Avatar" class="rounded-circle avatar avatar-xs">
                      {{$employee->employee_name}}
                       </td>

                      <td>{{$student->email??''}}</td>
                      <td>{{$student->mobile??''}}</td>
                      <td>{{$student->designation_name??''}}</td>

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
