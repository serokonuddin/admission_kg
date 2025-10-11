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

        .fa-close {
            color: red;
            font-size: 22px;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            {{-- <h4 class="py-3 mb-4">
      <span class="text-muted fw-light">Dashboard /</span>My Routine
   </h4> --}}
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"> My Routine</li>
                </ol>
            </nav>
            <!-- Card Border Shadow -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-2">
                        <div class="table-responsive fixTableHead">
                            <table class="table">
                                <thead class="table-dark">
                                    <tr>

                                        <th>#</th>
                                        @foreach ($routinetime as $key => $routined)
                                            <th style="text-align: center">{{ $key + 1 }}<br />
                                                {{ date('h:i A', strtotime($routined->start_time)) . '-' . date('h:i A', strtotime($routined->end_time)) }}
                                            </th>
                                        @endforeach

                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = count($routinetime);
                                        $routinetime = collect($routinetime)->groupBy('start_time');

                                    @endphp
                                    @foreach ($routine as $key => $data)
                                        <tr>
                                            <td>
                                                {{ $key }}
                                            </td>
                                            @php $i=1;@endphp
                                            @foreach ($routinetime as $key1 => $value)
                                                <td style="text-align: center">

                                                    @if (isset($data[$key1][0]->start_time))
                                                        Class: {{ $data[$key1][0]->classes->class_name ?? '' }} <br />
                                                        Section: {{ $data[$key1][0]->section->section_name ?? '' }} <br />
                                                        @if ($data[$key1][0]->is_class_teacher == 1)
                                                            <span style="color: red;font-wigdth: bold">Class
                                                                Teacher</span><br />
                                                        @endif
                                                        Subject: {{ $data[$key1][0]->subject[0]->subject_name ?? '' }}
                                                    @else
                                                        <i class="fa fa-close"></i>
                                                    @endif
                                                </td>
                                                @php $i++;@endphp
                                            @endforeach
                                            @if ($count == $i)
                                                @for ($k = $i; $count == $k; $k++)
                                                    <td style="text-align: center">
                                                        <i class="fa fa-close"></i>
                                                    </td>
                                                @endfor
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- / Content -->

        <div class="content-backdrop fade"></div>
    </div>
@endsection
