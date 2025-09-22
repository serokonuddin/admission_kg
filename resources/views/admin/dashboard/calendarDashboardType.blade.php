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
        @if($type!=4)
        .text-white td{
            color: white!important;
        }
        @endif
</style>
@php
$colortr=array('success','secondary','warning','default');
@endphp
<div class="content-wrapper">
   <!-- Content -->
   <div class="container-xxl flex-grow-1 container-p-y">
     <div class="row">

     <div class="card">
      <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="table-success">
                   <tr>
                      <th>#</th>
                      <th>Sessions</th>
                      <th>Exam/Occasion/Festival</th>
                      <th>Exam/Occasion/Festival Bn</th>
                      <th>Date</th>
                      <th>Holi-days</th>
                      <th>Is Exam</th>

                   </tr>
                </thead>
                <tbody class="table-border-bottom-0">

                    @foreach($YearCalendars as $key=>$YearCalendar)
                        <tr id="row{{$YearCalendar->id}}" class="bg-{{$colortr[$type-1]}} text-white">
                          <td scope="row">{{$key+1}}</td>
                          <td>{{$YearCalendar->session->session_name??''}}</td>
                          <td>{{$YearCalendar->title??''}}</td>
                          <td>{{$YearCalendar->title_bn??''}}</td>
                          <td>{{date('D d F Y',strtotime($YearCalendar->start_date))}}{{($YearCalendar->end_date)?'-'.date('D d F Y',strtotime($YearCalendar->end_date)):''}}
                          </td>
                          <td>{{$YearCalendar->number_of_days}}</td>
                          <td>{{($YearCalendar->is_notice==1)?'Yes':'No'}}</td>



                        </tr>
                        @endforeach
                </tbody>
             </table>
      </div>
    </div>






      </div>


   </div>
   <!-- / Content -->
   <div class="content-backdrop fade"></div>
</div>
@endsection
