@extends('admin.layouts.layout')
@section('content')
    <style>
        .bg-color {
            background: #5993a9;
            color: white !important;
            font-size: 18px;
            font-weight: bold;
        }

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

            h4,
            .h4 {
                font-size: 1.075rem;
            }
        }

        .table:not(.table-dark) th {


            color: rgb(0, 149, 221) !important;
        }

        .table-dark th {
            border-bottom-color: rgb(0, 149, 221) !important;
        }

        .card-text {
            font-size: 17px;
            font-weight: bold;
        }
    </style>
    @php
        $color = [
            'dark',
            'info',
            'primary',
            'warning',
            'danger',
            'success',
            'secondary',
            'dark',
            'info',
            'primary',
            'warning',
            'danger',
            'success',
            'secondary',
            'dark',
            'info',
            'primary',
            'warning',
            'danger',
            'success',
            'secondary',
        ];

        $colordata = [
            'success',
            'danger',
            'warning',
            'info',
            'dark',
            'primary',
            'secondary',
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
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Student</h4>
            <div class="row">
                @php
                    $i = 0;
                @endphp
                @foreach ($type_for as $key => $type)
                    <div class="col-md-6 col-xl-4">
                        <a href="{{ url('admin/studentGetTypeStudent/' . $key+1) }}">
                            <div
                                class="card icon-card card-border-shadow-{{ $color[$i++] }} cursor-pointer text-center h-100">
                                <div class="card-header bg-color">{{ $type }}</div>
                                <div class="card-body bg-label-{{ $colordata[$i++] }}">
                                    <p class="card-text">
                                        Total:
                                        {{ $studentdata[$key]->total ?? '0' }}
                                    </p>
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
