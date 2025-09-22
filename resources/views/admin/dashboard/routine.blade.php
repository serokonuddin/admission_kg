@extends('admin.layouts.layout')
@section('content')
    @php
        $color = [
            'primary',
            'secondary',
            'success',
            'danger',
            'warning',
            'info',
            'dark',
            'primary',
            'secondary',
            'success',
            'danger',
            'warning',
            'info',
            'dark',
            'primary',
            'secondary',
            'success',
            'danger',
            'warning',
            'info',
            'dark',
            'primary',
            'secondary',
            'success',
            'danger',
            'warning',
            'info',
            'dark',
            'primary',
            'secondary',
            'success',
            'danger',
            'warning',
            'info',
            'dark',
            'primary',
            'secondary',
            'success',
            'danger',
            'warning',
            'info',
            'dark',
            'primary',
            'secondary',
            'success',
            'danger',
            'warning',
            'info',
            'dark',
            'primary',
            'secondary',
            'success',
            'danger',
            'warning',
            'info',
            'dark',
        ];

        $colordata = [
            'primary',
            'secondary',
            'success',
            'danger',
            'warning',
            'info',
            'dark',
            'primary',
            'secondary',
            'success',
            'danger',
            'warning',
            'info',
            'dark',
            'primary',
            'secondary',
            'success',
            'danger',
            'warning',
            'info',
            'dark',
            'primary',
            'secondary',
            'success',
            'danger',
            'warning',
            'info',
            'dark',
        ];
    @endphp

    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Academy Activity</h4>
            <!-- Card Border Shadow -->
            <div class=" flex-grow-1 container-p-y">

                <div class="row">
                    <!-- Performance -->
                    <div class="col-md-6 col-lg-6 mt-4">
                        <a href="{{ route('studentNotice') }}">
                            <div class="card bg-{{ $color[2] }} text-white mb-3">
                                <div class="card-header">Notice</div>
                                <div class="card-body">
                                    <h5 class="card-title text-white">View Notice</h5>
                                    <p class="card-text"></p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-6 mt-4">
                        <a href="{{ route('studentRouten') }}">
                            <div class="card bg-{{ $color[4] }} text-white mb-3">
                                <div class="card-header">Routine</div>
                                <div class="card-body">
                                    <h5 class="card-title text-white">View Routine</h5>
                                    <p class="card-text"></p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-6 mt-4">
                        <a href="{{ route('studentSyllabus') }}">
                            <div class="card bg-{{ $color[0] }} text-white mb-3">
                                <div class="card-header">Sylabus</div>
                                <div class="card-body">
                                    <h5 class="card-title text-white">View Sylabus</h5>
                                    <p class="card-text"></p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-6 mt-4">
                        <a href="{{ route('lessonPlanStudent') }}">
                            <div class="card bg-{{ $color[3] }} text-white mb-3">
                                <div class="card-header">Lesson Plan</div>
                                <div class="card-body">
                                    <h5 class="card-title text-white">View Lesson Plan</h5>
                                    <p class="card-text"></p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!--/ Conversion rate -->

                    <!--/ Total Balance -->
                </div>
            </div>


        </div>
        <!-- / Content -->

        <div class="content-backdrop fade"></div>
    </div>
@endsection
