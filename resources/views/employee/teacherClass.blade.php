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
    </style>
    @php
        $color = [
            'primary',
            'warning',
            'danger',
            'info',
            'success',
            'primary',
            'warning',
            'danger',
            'info',
            'success',
            'primary',
            'warning',
            'danger',
            'info',
            'success',
            'primary',
            'warning',
            'danger',
            'info',
            'success',
            'primary',
            'warning',
            'danger',
            'info',
            'success',
            'primary',
            'warning',
            'danger',
            'info',
            'success',
            'primary',
            'warning',
            'danger',
            'info',
            'success',
            'primary',
            'warning',
            'danger',
            'info',
            'success',
        ];
    @endphp
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            {{-- <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">Dashboard /</span> Class
            </h4> --}}
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"> Class</li>
                </ol>
            </nav>
            <!-- Card Border Shadow -->
            <div class="row">

                @foreach ($classes as $key => $class)
                    <div class="col-sm-6 col-lg-3 mb-4">
                        <div class="card bg-{{ $color[$key] }} text-white mb-3">
                            <a href="{{ url('admin/teacherSectionRoutine/' . $class->section_id) }}">
                                <div class="card-header text-white">Class: {{ $class->class_name ?? '' }}
                                    ({{ $class->section_name ?? '' }})
                                </div>
                                <div class="card-body">
                                    <p class="card-title text-white">Shift: {{ $class->shift->shift_name ?? '' }}</p>
                                    <p class="card-text text-white">Version: {{ $class->version->version_name ?? '' }}</p>
                                </div>
                            </a>
                        </div>

                    </div>
                @endforeach

            </div>


        </div>
        <!-- / Content -->

        <div class="content-backdrop fade"></div>
    </div>
@endsection
