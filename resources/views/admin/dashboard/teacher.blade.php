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

        .avatar {
            position: relative;
            width: 4rem;
            height: 4rem;
            cursor: pointer;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            {{-- <h4 class="py-3 mb-4">
      <span class="text-muted fw-light">Dashboard </span>
   </h4> --}}

            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"> Dashboard</li>
                </ol>
            </nav>

            <!-- Display Success Message -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Display Error Message -->
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <!-- Card Border Shadow -->
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <div class="card icon-card card-border-shadow-warning cursor-pointer text-center">
                        <a href="{{ route('teacherProfile') }}">
                            <div class="card-body bg-label-danger">
                                <div class="avatar flex-shrink-0 " style="margin: 0px auto">
                                    <img src="{{ asset('public/dashboard/student.jpg') }}" alt="cube" class="rounded">
                                </div>
                                <p class="icon-name text-capitalize text-truncate mb-0">Profile</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 mb-4">
                    <div class="card icon-card card-border-shadow-danger cursor-pointer text-center h-100">
                        <a href="{{ url('admin/teacherClass') }}">
                            <div class="card-body bg-label-warning">
                                <div class="avatar flex-shrink-0 " style="margin: 0px auto">
                                    <img src="{{ asset('public/dashboard/class.png') }}" alt="cube" class="rounded">
                                </div>

                                <p class="icon-name text-capitalize text-truncate mb-0">Class</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 mb-4">
                    <div class="card icon-card card-border-shadow-primary cursor-pointer text-center h-100">
                        <a href="{{ url('admin/teacherStudent') }}">
                            <div class="card-body bg-label-danger">
                                <div class="avatar flex-shrink-0 " style="margin: 0px auto">
                                    <img src="{{ asset('public/dashboard/student.jpg') }}" alt="cube" class="rounded">
                                </div>

                                <p class="icon-name text-capitalize text-truncate mb-0">Students</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 mb-4">
                    <div class="card icon-card card-border-shadow-warning cursor-pointer text-center h-100">
                        <a href="{{ url('admin/teacherStudentAttendance') }}">
                            <div class="card-body bg-label-danger">
                                <div class="avatar flex-shrink-0 " style="margin: 0px auto">
                                    <img src="{{ asset('public/dashboard/attendance.webp') }}" alt="cube"
                                        class="rounded">
                                </div>

                                <p class="icon-name text-capitalize text-truncate mb-0">Attendance</p>
                            </div>
                        </a>
                    </div>
                </div>



            </div>
            <div class="row mt-4">

                <div class="col-sm-6 col-lg-3 mb-4">
                    <div class="card icon-card cursor-pointer card-border-shadow-primary text-center  h-100">
                        <a href="{{ url('admin/subject_marks') }}">
                            <div class="card-body bg-label-info">
                                <div class="avatar flex-shrink-0 " style="margin: 0px auto">
                                    <img src="{{ asset('public/dashboard/exam.png') }}" alt="cube" class="rounded">
                                </div>
                                <p class="icon-name text-capitalize text-truncate mb-0">Exam</p>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3 mb-4">
                    <div class="card icon-card cursor-pointer card-border-shadow-info text-center  h-100">
                        <a href="{{ url('admin/teacherSyllabus') }}">
                            <div class="card-body bg-label-primary">
                                <div class="avatar flex-shrink-0 " style="margin: 0px auto">
                                    <img src="{{ asset('public/dashboard/activity.png') }}" alt="cube" class="rounded">
                                </div>

                                <p class="icon-name text-capitalize text-truncate mb-0">Academy Activity</p>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3 mb-4">
                    <div class="card icon-card card-border-shadow-primary cursor-pointer text-center  h-100">
                        <a href="{{ url('admin/teacherPayment') }}">
                            <div class="card-body bg-label-info">
                                <div class="avatar flex-shrink-0 " style="margin: 0px auto">
                                    <img src="{{ asset('public/dashboard/payment.png') }}" alt="cube" class="rounded">
                                </div>

                                <p class="icon-name text-capitalize text-truncate mb-0">Salary</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 mb-4">
                    <div class="card icon-card cursor-pointer card-border-shadow-primary text-center  h-100">
                        <a href="{{ url('admin/teacherYearCalender') }}">
                            <div class="card-body bg-label-info">
                                <div class="avatar flex-shrink-0 " style="margin: 0px auto">
                                    <img src="{{ asset('public/dashboard/calendar.png') }}" alt="cube" class="rounded">
                                </div>

                                <p class="icon-name text-capitalize text-truncate mb-0">Year Calendar</p>
                            </div>
                        </a>
                    </div>
                </div>



            </div>
        </div>
        <!-- / Content -->

        <div class="content-backdrop fade"></div>
    </div>
@endsection
