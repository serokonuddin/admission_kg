@extends('admin.layouts.layout')
@section('content')
    <style>
        /* .bx {
                vertical-align: middle;
                font-size: 2.15rem;
                line-height: 1;
            } */

        .text-capitalize {
            text-transform: capitalize !important;
            font-size: 25px;
        }

        .text-white,
        .text-white .text-muted,
        .text-white .mb-0 {
            color: white !important;
            font-weight: bold;
            padding: 10px !important;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            {{-- <h4 class="py-3 mb-4">
      <span class="text-muted fw-light">Dashboard /</span> Attendance
   </h4> --}}
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">My Attendance</li>
                </ol>
            </nav>
            <!-- Card Border Shadow -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <!-- Activity Timeline -->
                    <div class="card card-action mb-2">
                        <div class="card-header align-items-center">
                            <h5 class="card-action-title mb-0"><i class="bx bx-list-ul me-2"></i>Activity Timeline</h5>
                            <div class="card-action-element">


                                <div class="input-group input-daterange">
                                    <input type="date" name="start_date" id="start_date" placeholder="MM/DD/YYYY"
                                        class="form-control">
                                    <span class="input-group-text">to</span>
                                    <input type="date" name="end_date" id="end_date" placeholder="MM/DD/YYYY"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="card-body" id="attendanceDetails">
                            <ul class="timeline ms-2">
                                @if (isset($teacher->teacherlastWeekAttendance))
                                    @foreach ($teacher->teacherlastWeekAttendance as $teachera)
                                        @php
                                            if ($teachera->status == 1) {
                                                $bg = 'bg-default';
                                            } elseif ($teachera->status == 4) {
                                                $bg = 'bg-warning text-white';
                                            } elseif ($teachera->status == 2) {
                                                $bg = 'bg-danger text-white';
                                            } elseif ($teachera->status == 3) {
                                                $bg = 'bg-success text-white';
                                            }
                                        @endphp
                                        <li class="timeline-item timeline-item-transparent ">
                                            <span class="timeline-point-wrapper"><span
                                                    class="timeline-point timeline-point-warning"></span></span>
                                            <div class="timeline-event {{ $bg }}">
                                                <div class="timeline-header mb-1">
                                                    @php
                                                        $status = ['Present', 'Absent', 'Leave', 'Late'];
                                                    @endphp
                                                    <h6 class="mb-0">{{ $status[$teachera->status - 1] ?? '' }}</h6>
                                                    <small class="text-muted">{{ $teachera->attendance_date ?? '' }}</small>
                                                </div>
                                                <p class="mb-2">Subject: {{ $teachera->subject_name ?? '' }}</p>
                                                <p class="mb-2">Attendance at {{ $teachera->time ?? '' }}</p>
                                                <!-- <div class="d-flex flex-wrap">

                                 <div>
                                 <h6 class="mb-0">English (Class 9) </h6>
                                 <span>Attendance at 8:00am</span>
                                 </div>

                              </div>
                              <div class="d-flex flex-wrap">

                                 <div>
                                       <h6 class="mb-0">Bangla (Class 10) </h6>
                                       <span>Attendance at 8:30am</span>
                                    </div>

                                 </div>
                           </div> -->
                                        </li>
                                    @endforeach
                                @endif

                                {{-- <li class="timeline-item timeline-item-transparent">
               <span class="timeline-point-wrapper"><span class="timeline-point timeline-point-success"></span></span>

               </li> --}}

                            </ul>
                        </div>
                    </div>
                    <!--/ Activity Timeline -->

                    <!-- Projects table -->

                    <!--/ Projects table -->
                </div>
            </div>

        </div>
        <!-- / Content -->

        <div class="content-backdrop fade"></div>
    </div>
@endsection
