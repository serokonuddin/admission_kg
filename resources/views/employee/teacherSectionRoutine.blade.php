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

        .table-dark {
            --bs-table-bg: #1c4d7c !important;
            --bs-table-striped-bg: #1c4d7c !important;
            --bs-table-striped-color: #fff !important;
            --bs-table-active-bg: #1c4d7c !important;
            --bs-table-active-color: #fff !important;
            --bs-table-hover-bg: #1c4d7c !important;
            --bs-table-hover-color: #fff !important;
            color: #fff !important;
            border-color: #1c4d7c !important;
        }

        .table-dark {
            background-color: #1c4d7c !important;
            color: #fff !important;
            font-weight: bold;
        }

        .table:not(.table-dark) th {
            color: #ffffff;
        }

        .table-class-schedule {
            border-radius: .625rem;
            border: 1px solid #e7e7e7;
            border-top: 0;
            border-bottom: 0;
        }

        .table {
            --bs-table-bg: transparent;
            --bs-table-accent-bg: transparent;
            --bs-table-striped-color: #222;
            --bs-table-striped-bg: rgba(0, 0, 0, 0.05);
            --bs-table-active-color: #222;
            --bs-table-active-bg: rgba(0, 0, 0, 0.1);
            --bs-table-hover-color: #222;
            --bs-table-hover-bg: rgba(0, 0, 0, 0.075);
            width: 100%;
            margin-bottom: 1rem;
            color: #222;
            vertical-align: top;
            border-color: #e7e7e7;
        }

        .font-size-18 {
            font-size: 1.13rem;
        }

        .bg-primary {
            background-color: #f0c24b !important;
        }

        .text-white {
            color: #fff !important;
            font-weight: bold;
        }

        .text-uppercase {
            text-transform: uppercase !important;
        }

        .bg-purple {
            background-color: #a597e7 !important;
        }

        .bg-pink {
            background-color: #ea77ad !important;
        }

        .text-primary {
            color: #f0c24b !important;
            font-weight: bold;
        }

        .text-purple {
            color: #a597e7 !important;
            font-weight: bold;
        }

        .text-pink {
            color: #ea77ad !important;
            font-weight: bold;
        }

        .text-danger,
        .text-info,
        .text-success,
        .text-danger,
        .text-secondary,
        .text-dark {
            font-weight: bold;
        }
    </style>
    @php
        $color = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'dark', 'purple', 'pink'];
    @endphp
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            {{-- <h4 class="py-3 mb-4">
      <span class="text-muted fw-light">Dashboard /</span> Routine
   </h4> --}}
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Routine</li>
                </ol>
            </nav>
            <!-- Card Border Shadow -->
            <div class="row">
                <div class="col-12">

                    <div class="card mb-2" style="padding: 10px;">
                        <table class="table">
                            <tr>
                                <td class="card-title text-primary">Shift: {{ $shift_name ?? '' }}</td>
                                <td class="card-title text-success">Version: {{ $version_name ?? '' }}</td>
                                <td class="card-title text-danger">Class: {{ $class_name ?? '' }}</td>
                                <td class="card-title text-info">Section: {{ $section_name ?? '' }}</td>
                            </tr>

                            @foreach ($routine as $key => $data)
                                <tr>
                                    @foreach ($routinetime as $key2 => $routined)
                                        @if (isset($data[$routined->start_time]))
                                            <td class="py-1 text-muted" style="text-align: left;">
                                                @foreach ($data[$routined->start_time] as $value)
                                                    <div class="employee-row">
                                                        <span class="d-block font-weight-bold font-size-12 mb-2">
                                                            Teacher: {{ $value->employee->employee_name ?? '' }}
                                                        </span>
                                                        <span>
                                                            Mobile: {{ $value->employee->mobile ?? 'N/A' }}
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </td>
                                        @else
                                            <td class="py-1 text-muted" style="text-align: left;">
                                                <!-- Empty cell if no data -->
                                            </td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                        </table>

                        <div class="table-responsive table-class-schedule fixTableHead">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;min-width: 50px" scope="col"
                                            class="bg-{{ $color[7] }} text-white text-uppercase font-size-18">#</th>
                                        @foreach ($routinetime as $key => $routined)
                                            <th style="text-align: center;min-width: 250px" scope="col"
                                                class="bg-{{ $color[$key % 9] }} text-white text-uppercase font-size-18">
                                                Class: {{ $key + 1 }}<br />
                                                {{ date('H:i', strtotime($routined->start_time)) . '-' . date('H:i', strtotime($routined->end_time)) }}
                                            </th>
                                        @endforeach

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($routine as $key => $data)
                                        <tr>
                                            <td
                                                class="py-1 align-middle text-muted font-weight-medium text-{{ $color[7] }}">
                                                {{ $key }}</td>

                                            @foreach ($routinetime as $key2 => $routined)
                                                @if (isset($data[$routined->start_time]))
                                                    <td class="py-1 text-muted" style="text-align: left;">
                                                        @foreach ($data[$routined->start_time] as $key1 => $value)
                                                            <span
                                                                class="text-{{ $color[$key2 % 9] }} d-block font-weight-bold font-size-12 mb-2">Teacher:
                                                                {{ $value->employee->employee_name ?? '' }}</span>
                                                            @if ($value->is_class_teacher == 1)
                                                                <span style="color: red;font-wigdth: bold"
                                                                    class="text-{{ $color[$key2 % 9] }}">Class
                                                                    Teacher</span><br />
                                                            @endif
                                                            <span class="text-{{ $color[$key2 % 9] }}">Subject:
                                                                {{ $value->subject[0]->subject_name ?? '' }}</span>
                                                        @endforeach
                                                    </td>
                                                @endif
                                            @endforeach

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                        <style>
                            .bottom-bar {
                                padding: 5px;
                                border-bottom: 2px solid rgb(0, 149, 221);
                            }

                            td .bottom-bar:last-child {
                                padding: 0px;
                                border-bottom: none;
                            }

                            .table tr>td .dropdown {
                                position: relative;
                            }

                            .table>:not(caption)>*>* {
                                padding: .125rem 0.15rem;
                            }
                        </style>



                    </div>
                </div>
            </div>

        </div>
        <!-- / Content -->

        <div class="content-backdrop fade"></div>
    </div>
@endsection
