@extends('admin.layouts.layout')
@section('content')
    <style>
        input[readonly] {
            background-color: #f6f6f6 !important;
        }

        :root {
            --bs-breadcrumb-divider: ">";
        }

        .breadcrumb a {
            text-decoration: none;
            color: #007bff;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
            color: #0056b3;
        }

        td,
        th {
            border: 1px solid #333;
            color: #000000;

        }

        .uppercase-title {
            text-transform: uppercase;
            font-weight: 500;
            padding: 5px;
        }

        .shift-title {
            font-size: 1rem;
            color: #566A7F;
            padding-bottom: 15px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 1.25rem;
            color: #333;
        }


        .row.g-4 {
            gap: 1rem;
        }

        .gradient-card {
            /* background: linear-gradient(45deg, #92d9e6, #007EA7); */
            border: none;
            border-radius: 10px;
            padding: 1rem;
            /* color: white; */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .btn-icon {
            /* background-color: white; */
            color: #0A97B0;
            border: none;
            border-radius: 6px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            font-size: 1rem;
        }

        .btn-icon:hover {
            background-color: #007EA7;
            /* color: white; */
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
        }

        .btn-icon i {
            font-size: 1.2rem;
            margin-right: 0.5rem;
        }


        .btn-class {
            background-color: #0A97B0;
            /* color: white; */
            border: none;
            border-radius: 8px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-class:hover {
            background-color: #086c87;
            /* color: white; */
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
        }

        .btn-class:focus {
            outline: none;
            box-shadow: 0 0 0 4px rgba(10, 151, 176, 0.3);
        }

        th,
        td {
            border: 1px solid #000 !important;
            /* color: white !important; */
        }

        hr {
            margin: .1rem 0 !important;
            color: black !important;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            table {
                border-collapse: collapse;
                width: 100%;
            }

            th,
            td {
                border: 1px solid black !important;
                padding: 8px;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2 !important;
            }

            tr:nth-child(odd) {
                background-color: #ffffff !important;
            }

            tr {
                background-color: red !important;
            }

            hr {
                margin: .1rem 0 !important;
                color: black !important;
            }
        }
    </style>

    <div class="content-wrapper">
        @php
            $className = [
                '0' => 'KG',
                '1' => 'One',
                '2' => 'Two',
                '3' => 'Three',
                '4' => 'Four',
                '5' => 'Five',
                '6' => 'Six',
                '7' => 'Seven',
                '8' => 'Eight',
                '9' => 'Nine',
                '10' => 'Ten',
                '11' => 'Eleven',
                '12' => 'Twelve',
            ];

        @endphp


        <div class="container-xxl flex-grow-1 container-p-y">

            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>

                    <li class="breadcrumb-item active" aria-current="page"> Attendance Statistics </li>

                </ol>
            </nav>

            <div class="col-md mb-4 mb-md-0">
                <div class="card gradient-card">
                    <div class="card-header">
                        <h5 class="card-title text-center">
                            Attendance Statistics Report
                        </h5>
                        <div class="row">
                            <div class="col-12">
                                <form action="{{ route('student.attendance.statistics') }}" method="get">
                                    @csrf
                                    <div class="card shadow-sm p-4">
                                        <h5 class="mb-3 text-lg font-semibold text-gray-700">Filter Records</h5>
                                        <div class="row g-3">
                                            <!-- Date -->
                                            <div class="col-md-3">
                                                <label for="from_date" class="form-label fw-semibold">Date <span
                                                        class="text-danger">*</span></label>
                                                <input type="date" id="from_date" name="from_date" class="form-control"
                                                    value="{{ $todayDate ? $todayDate : date('Y-m-d') }}" required>
                                                <div class="invalid-feedback">Please select a date.</div>
                                            </div>

                                            <!-- Version -->
                                            <div class="col-md-3">
                                                <label for="version_id" class="form-label fw-semibold">Version</label>
                                                <select id="version_id" name="version_id" class="form-select">
                                                    <option value="">Select Version</option>

                                                    {{-- Check if user has a version_id, show only that version --}}
                                                    @if (Auth::user()->version_id)
                                                        <option value="{{ Auth::user()->version_id }}" selected>
                                                            {{ Auth::user()->version_id == 1 ? 'Bangla' : 'English' }}
                                                        </option>
                                                    @else
                                                        {{-- Show both versions if version_id is not set --}}
                                                        <option value="1"
                                                            {{ $version_id == 1 ? 'selected="selected"' : '' }}>Bangla
                                                        </option>
                                                        <option value="2"
                                                            {{ $version_id == 2 ? 'selected="selected"' : '' }}>English
                                                        </option>
                                                    @endif
                                                </select>
                                            </div>


                                            <!-- Shift -->
                                            <div class="col-md-3">
                                                <label for="shift_id" class="form-label fw-semibold">Shift</label>
                                                <select id="shift_id" name="shift_id" class="form-select">
                                                    <option value="">Select Shift</option>

                                                    {{-- Check if user has a shift_id, show only that shift --}}
                                                    @if (Auth::user()->shift_id)
                                                        <option value="{{ Auth::user()->shift_id }}" selected>
                                                            {{ Auth::user()->shift_id == 1 ? 'Morning' : 'Day' }}
                                                        </option>
                                                    @else
                                                        {{-- Show both shifts if shift_id is not set --}}
                                                        <option value="1"
                                                            {{ $shift_id == 1 ? 'selected="selected"' : '' }}>Morning
                                                        </option>
                                                        <option value="2"
                                                            {{ $shift_id == 2 ? 'selected="selected"' : '' }}>Day</option>
                                                    @endif
                                                </select>
                                            </div>


                                            <!-- Class -->
                                            <div class="col-md-3">
                                                <label for="class_for" class="form-label fw-semibold">Class For</label>
                                                <select id="class_for" name="class_for" class="form-select">
                                                    <option value="">Select Class For</option>

                                                    @php
                                                        $userClassId = Auth::user()->class_id;
                                                    @endphp

                                                    @if ($userClassId == 4)
                                                        {{-- Show both Primary and Secondary if class_id is 4 --}}
                                                        <option value="1"
                                                            {{ $class_for == 1 ? 'selected="selected"' : '' }}>Primary
                                                        </option>
                                                        <option value="2"
                                                            {{ $class_for == 2 ? 'selected="selected"' : '' }}>Secondary
                                                        </option>
                                                    @elseif ($userClassId)
                                                        {{-- Show only the class matching class_id --}}
                                                        <option value="{{ $userClassId }}" selected>
                                                            {{ $userClassId == 1 ? 'Primary' : ($userClassId == 2 ? 'Secondary' : 'College') }}
                                                        </option>
                                                    @else
                                                        {{-- Show all class options if class_id is not set --}}
                                                        <option value="1"
                                                            {{ $class_for == 1 ? 'selected="selected"' : '' }}>Primary
                                                        </option>
                                                        <option value="2"
                                                            {{ $class_for == 2 ? 'selected="selected"' : '' }}>Secondary
                                                        </option>
                                                        <option value="3"
                                                            {{ $class_for == 3 ? 'selected="selected"' : '' }}>College
                                                        </option>
                                                    @endif
                                                </select>
                                            </div>



                                            <!-- Buttons -->
                                            <div class="col-12 d-flex justify-content-start gap-3 mt-3">
                                                <button type="submit" id="searchtop" class="btn btn-primary">
                                                    <i class="fas fa-search"></i> Search
                                                </button>
                                                {{-- <button type="button" id="resetbtn" class="btn btn-secondary">
                                                    <i class="fas fa-sync-alt"></i> Reset
                                                </button> --}}
                                                <button id="printBtn" class="btn btn-success">
                                                    <i class="fas fa-print"></i> Print
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>

                        {{-- <div class="d-flex justify-content-between">
                            <div class="col-md-3 d-flex align-items-center gap-3">
                                <label for="from_date" class="form-label text-gray-700">Date<span
                                        class="text-red-500">*</span></label>
                                <input
                                    class="form-control border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                    type="date" id="from_date" name="from_date" placeholder="From Date"
                                    value="{{ date('Y-m-d') }}" required>
                                <div class="invalid-feedback text-red-500">Please select a date.</div>
                            </div>
                            <div>
                                <button
                                    class="btn btn-primary py-2 px-4 rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    id="printBtn">Print</button>
                            </div>
                        </div> --}}

                    </div>
                    <div class="card-body">
                        <!-- Filter Form -->
                        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                        <input type="hidden" name="version_id" id="versionId" value="" />
                        <input type="hidden" name="class_code" id="class_code" value="" />

                        <div class="row g-3">
                            <div class="table-responsive" id="studentlist">
                                {{-- <button id="printBtn" class="btn btn-primary mb-3">Print</button> --}}
                                <table class="table"
                                    style="border-collapse: collapse; width: 100%; border: 1px solid black;">
                                    <thead>
                                        <tr style="background-color: #f2f2f2; border: 1px solid black;">
                                            <th style="width: 10%; border: 1px solid black;">Version</th>
                                            <th style="width: 10%; border: 1px solid black;">Shift</th>
                                            <th style="width: 10%; border: 1px solid black;">Class</th>
                                            <th style="width: 15%; border: 1px solid black;">Section</th>
                                            <th style="width: 10%; border: 1px solid black;">Total Students</th>
                                            <th style="width: 10%; border: 1px solid black;">Present</th>
                                            <th style="width: 10%; border: 1px solid black;">Absent</th>
                                            <th style="width: 10%; border: 1px solid black;">Leave</th>
                                            <th style="width: 10%; border: 1px solid black;">Late</th>
                                            <th style="width: 10%; border: 1px solid black;">Missing</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $prevVersion = null;
                                            $prevShift = null;
                                            $prevClass = null;
                                            $grand_totalclass = 0;
                                            $grand_totalclassp = 0;
                                            $grand_totalclassa = 0;
                                            $grand_totalclassl = 0;
                                            $grand_totalclassla = 0;
                                            $grand_totalclassm = 0;
                                        @endphp

                                        @foreach ($studentsummary as $key => $version)
                                            @php
                                                $version_totalclass = 0;
                                                $version_totalclassp = 0;
                                                $version_totalclassa = 0;
                                                $version_totalclassl = 0;
                                                $version_totalclassla = 0;
                                                $version_totalclassm = 0;
                                            @endphp
                                            @foreach ($version as $key1 => $shift)
                                                @php
                                                    $shift_totalclass = 0;
                                                    $shift_totalclassp = 0;
                                                    $shift_totalclassa = 0;
                                                    $shift_totalclassl = 0;
                                                    $shift_totalclassla = 0;
                                                    $shift_totalclassm = 0;
                                                    $j = 0;
                                                @endphp
                                                @foreach ($shift as $key => $classes)
                                                    @php
                                                        $totalclass = 0;
                                                        $totalclassp = 0;
                                                        $totalclassa = 0;
                                                        $totalclassl = 0;
                                                        $totalclassla = 0;
                                                        $totalclassm = 0;
                                                        $i = 0;
                                                    @endphp
                                                    @foreach ($classes as $key => $class)
                                                        @php

                                                            $present = $class->Present ?? 0;
                                                            $totalclassp += $class->Present ?? 0;
                                                            $version_totalclassp += $class->Present ?? 0;
                                                            $shift_totalclassp += $class->Present ?? 0;
                                                            $grand_totalclassp += $class->Present ?? 0;
                                                            $totalclass += $class->totalstudent ?? 0;
                                                            $shift_totalclass += $class->totalstudent ?? 0;
                                                            $version_totalclass += $class->totalstudent ?? 0;
                                                            $grand_totalclass += $class->totalstudent ?? 0;
                                                            $absent = $class->Absent ?? 0;
                                                            $totalclassa += $class->Absent ?? 0;
                                                            $shift_totalclassa += $class->Absent ?? 0;
                                                            $version_totalclassa += $class->Absent ?? 0;
                                                            $grand_totalclassa += $class->Absent ?? 0;
                                                            $leaved = $class->Leaved ?? 0;
                                                            $totalclassl += $class->Leaved ?? 0;
                                                            $shift_totalclassl += $class->Leaved ?? 0;
                                                            $version_totalclassl += $class->Leaved ?? 0;
                                                            $grand_totalclassl += $class->Leaved ?? 0;
                                                            $late = $class->Late ?? 0;
                                                            $totalclassla += $class->Late ?? 0;
                                                            $shift_totalclassla += $class->Late ?? 0;
                                                            $version_totalclassla += $class->Late ?? 0;
                                                            $grand_totalclassla += $class->Late ?? 0;
                                                            $missing = $class->Missing ?? 0;
                                                            $totalclassm += $class->Missing ?? 0;
                                                            $shift_totalclassm += $class->Missing ?? 0;
                                                            $version_totalclassm += $class->Missing ?? 0;
                                                            $grand_totalclassm += $class->Missing ?? 0;
                                                            $totalStudents = $class->totalstudent ?? '';

                                                            $showVersion = $class->version_name !== $prevVersion;
                                                            $showShift = $class->shift_name !== $prevShift;
                                                            $showClass =
                                                                isset($class->class_code) &&
                                                                $className[$class->class_code] !== $prevClass;

                                                            $prevVersion = $class->version_name;
                                                            $prevShift = $class->shift_name;
                                                            $prevClass = isset($class->class_code)
                                                                ? $className[$class->class_code]
                                                                : null;
                                                        @endphp

                                                        <tr
                                                            style="background-color: {{ $present == 0 ? '#f8d7da' : '#ffffff' }}; border: 1px solid black;">


                                                            @if ($i == 0)
                                                                <td style="border: 1px solid black;"
                                                                    rowspan="{{ count($classes) + 1 }}">
                                                                    {{ $showVersion ? $class->version_name : '' }}</td>
                                                                <td style="border: 1px solid black;"
                                                                    rowspan="{{ count($classes) + 1 }}">
                                                                    {{ $showShift ? $class->shift_name : '' }}</td>

                                                                <td style="border: 1px solid black;"
                                                                    rowspan="{{ count($classes) + 1 }}">
                                                                    {{ $showClass ? (isset($class->class_code) ? $className[$class->class_code] : '') : '' }}
                                                                </td>
                                                            @endif
                                                            <td style="border: 1px solid black;">
                                                                {{ $class->section_name ?? '' }}</td>
                                                            <td
                                                                style="text-align: center; font-weight:500; border: 1px solid black;">
                                                                {{ $totalStudents == 0 ? '' : $totalStudents }}</td>
                                                            <td
                                                                style="text-align: center; color:#008000; font-weight:500; border: 1px solid black;">
                                                                {{ $present == 0 ? '' : $present }}
                                                                <hr>
                                                                {{ $present == 0 ? '' : getPercentage($totalStudents, $present) }}
                                                            </td>
                                                            <td
                                                                style="text-align: center; color:#ff0000; font-weight:500; border: 1px solid black;">
                                                                {{ $absent == 0 ? '' : $absent }}
                                                                <hr>
                                                                {{ $absent == 0 ? '' : getPercentage($totalStudents, $absent) }}
                                                            </td>
                                                            <td
                                                                style="text-align: center; color:#7cfc00; font-weight:500; border: 1px solid black;">
                                                                {{ $leaved == 0 ? '' : $leaved }}
                                                                <hr>
                                                                {{ $leaved == 0 ? '' : getPercentage($totalStudents, $leaved) }}
                                                            </td>
                                                            <td
                                                                style="text-align: center; color: #ff00ff; font-weight:500; border: 1px solid black;">
                                                                {{ $late == 0 ? '' : $late }}
                                                                <hr>
                                                                {{ $late == 0 ? '' : getPercentage($totalStudents, $late) }}
                                                            </td>
                                                            <td
                                                                style="text-align: center; color: #ff9900; font-weight:500; border: 1px solid black;">
                                                                {{ $missing == 0 ? '' : $missing }}
                                                                <hr>
                                                                {{ $missing == 0 ? '' : getPercentage($totalStudents, $missing) }}
                                                            </td>
                                                        </tr>
                                                        @php
                                                            $i += 1;
                                                            $j += 1;
                                                        @endphp
                                                    @endforeach
                                                    <tr style=" border: 1px solid black;">
                                                        <!-- <td style="border: 1px solid black;">
                                                                                                                                                                                                                {{ $class->version_name }}</td> -->
                                                        <!-- <td style="border: 1px solid black;">
                                                                                                                                                                                                                {{ $class->shift_name }}</td> -->
                                                        <!-- <td style="border: 1px solid black;">
                                                                                                                                                                                                                {{ $className[$class->class_code] }}
                                                                                                                                                                                                            </td> -->
                                                        <td style="border: 1px solid black;">
                                                            Total</td>
                                                        <td
                                                            style="text-align: center; font-weight:500; border: 1px solid black;">
                                                            {{ $totalclass }}</td>
                                                        <td
                                                            style="text-align: center; color:#008000; font-weight:500; border: 1px solid black;">
                                                            {{ $totalclassp }}
                                                            <hr>
                                                            {{ $totalclassp == 0 ? '' : getPercentage($totalclass, $totalclassp) }}
                                                        </td>
                                                        <td
                                                            style="text-align: center; color:#ff0000; font-weight:500; border: 1px solid black;">
                                                            {{ $totalclassa }}
                                                            <hr>
                                                            {{ $totalclassa == 0 ? '' : getPercentage($totalclass, $totalclassa) }}
                                                        </td>
                                                        <td
                                                            style="text-align: center; color:#7cfc00; font-weight:500; border: 1px solid black;">
                                                            {{ $totalclassl }}
                                                            <hr>
                                                            {{ $totalclassl == 0 ? '' : getPercentage($totalclass, $totalclassl) }}
                                                        </td>
                                                        <td
                                                            style="text-align: center; color: #ff00ff; font-weight:500; border: 1px solid black;">
                                                            {{ $totalclassla }}
                                                            <hr>
                                                            {{ $totalclassla == 0 ? '' : getPercentage($totalclass, $totalclassla) }}
                                                        </td>
                                                        <td
                                                            style="text-align: center; color: #ff9900; font-weight:500; border: 1px solid black;">
                                                            {{ $totalclassm }}
                                                            <hr>
                                                            {{ $totalclassm == 0 ? '' : getPercentage($totalclass, $totalclassm) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <tr style=" border: 1px solid black;">
                                                    <td style="border: 1px solid black;">
                                                        {{ $class->version_name }}</td>
                                                    <td style="border: 1px solid black;">
                                                        {{ $class->shift_name }}</td>
                                                    <td style="border: 1px solid black;text-align: center;"
                                                        colspan="2">
                                                        Total
                                                    </td>
                                                    <!-- <td style="border: 1px solid black;">
                                                                                                                                                                                                               </td> -->
                                                    <td
                                                        style="text-align: center; font-weight:500; border: 1px solid black;">
                                                        {{ $shift_totalclass }}</td>
                                                    <td
                                                        style="text-align: center; color:#008000; font-weight:500; border: 1px solid black;">
                                                        {{ $shift_totalclassp }}
                                                        <hr>
                                                        {{ $shift_totalclassp == 0 ? '' : getPercentage($shift_totalclass, $shift_totalclassp) }}
                                                    </td>
                                                    <td
                                                        style="text-align: center; color:#ff0000; font-weight:500; border: 1px solid black;">
                                                        {{ $shift_totalclassa }}
                                                        <hr>
                                                        {{ $shift_totalclassa == 0 ? '' : getPercentage($shift_totalclass, $shift_totalclassa) }}
                                                    </td>
                                                    <td
                                                        style="text-align: center; color:#7cfc00; font-weight:500; border: 1px solid black;">
                                                        {{ $shift_totalclassl }}
                                                        <hr>
                                                        {{ $shift_totalclassl == 0 ? '' : getPercentage($shift_totalclass, $shift_totalclassl) }}
                                                    </td>
                                                    <td
                                                        style="text-align: center; color: #ff00ff; font-weight:500; border: 1px solid black;">
                                                        {{ $shift_totalclassla }}
                                                        <hr>
                                                        {{ $shift_totalclassla == 0 ? '' : getPercentage($shift_totalclass, $shift_totalclassla) }}
                                                    </td>
                                                    <td
                                                        style="text-align: center; color: #ff9900; font-weight:500; border: 1px solid black;">
                                                        {{ $shift_totalclassm }}
                                                        <hr>
                                                        {{ $shift_totalclassm == 0 ? '' : getPercentage($shift_totalclass, $shift_totalclassm) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr style=" border: 1px solid black;">
                                                <td style="border: 1px solid black;">
                                                    {{ $class->version_name }}</td>
                                                <td style="border: 1px solid black;text-align: center;" colspan="3">
                                                    Total
                                                </td>
                                                <td style="text-align: center; font-weight:500; border: 1px solid black;">
                                                    {{ $version_totalclass }}</td>
                                                <td
                                                    style="text-align: center; color:#008000; font-weight:500; border: 1px solid black;">
                                                    {{ $version_totalclassp }}
                                                    <hr>
                                                    {{ $version_totalclassp == 0 ? '' : getPercentage($version_totalclass, $version_totalclassp) }}
                                                </td>
                                                <td
                                                    style="text-align: center; color:#ff0000; font-weight:500; border: 1px solid black;">
                                                    {{ $version_totalclassa }}
                                                    <hr>
                                                    {{ $version_totalclassa == 0 ? '' : getPercentage($version_totalclass, $version_totalclassa) }}
                                                </td>
                                                <td
                                                    style="text-align: center; color:#7cfc00; font-weight:500; border: 1px solid black;">
                                                    {{ $version_totalclassl }}
                                                    <hr>
                                                    {{ $version_totalclassl == 0 ? '' : getPercentage($version_totalclass, $version_totalclassl) }}
                                                </td>
                                                <td
                                                    style="text-align: center; color: #ff00ff; font-weight:500; border: 1px solid black;">
                                                    {{ $version_totalclassla }}
                                                    <hr>
                                                    {{ $version_totalclassla == 0 ? '' : getPercentage($version_totalclass, $version_totalclassla) }}
                                                </td>
                                                <td
                                                    style="text-align: center; color: #ff9900; font-weight:500; border: 1px solid black;">
                                                    {{ $version_totalclassm }}
                                                    <hr>
                                                    {{ $version_totalclassm == 0 ? '' : getPercentage($version_totalclass, $version_totalclassm) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr style=" border: 1px solid black;">
                                            <td colspan="4" style="border: 1px solid black;text-align: center; ">
                                                Grand Total
                                            </td>

                                            <td style="text-align: center; font-weight:500; border: 1px solid black;">
                                                {{ $grand_totalclass }}</td>
                                            <td
                                                style="text-align: center; color:#008000; font-weight:500; border: 1px solid black;">
                                                {{ $grand_totalclassp }}
                                                <hr>
                                                {{ $grand_totalclassp == 0 ? '' : getPercentage($grand_totalclass, $grand_totalclassp) }}
                                            </td>
                                            <td
                                                style="text-align: center; color:#ff0000; font-weight:500; border: 1px solid black;">
                                                {{ $grand_totalclassa }}
                                                <hr>
                                                {{ $grand_totalclassa == 0 ? '' : getPercentage($grand_totalclass, $grand_totalclassa) }}
                                            </td>
                                            <td
                                                style="text-align: center; color:#7cfc00; font-weight:500; border: 1px solid black;">
                                                {{ $grand_totalclassl }}
                                                <hr>
                                                {{ $grand_totalclassl == 0 ? '' : getPercentage($grand_totalclass, $grand_totalclassl) }}
                                            </td>
                                            <td
                                                style="text-align: center; color: #ff00ff; font-weight:500; border: 1px solid black;">
                                                {{ $grand_totalclassla }}
                                                <hr>
                                                {{ $grand_totalclassla == 0 ? '' : getPercentage($grand_totalclass, $grand_totalclassla) }}
                                            </td>
                                            <td
                                                style="text-align: center; color: #ff9900; font-weight:500; border: 1px solid black;">
                                                {{ $grand_totalclassm }}
                                                <hr>
                                                {{ $grand_totalclassm == 0 ? '' : getPercentage($grand_totalclass, $grand_totalclassm) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Version and shift --}}
                <div class="col-md my-4 mb-md-0" id="versionAndShift">

                </div>

            </div>

            <div class="content-backdrop fade"></div>
        </div>
        <script>
            $(function() {
                $('#printBtn').on('click', function() {
                    // Hide pagination before printing
                    $('.dataTables_paginate').hide();
                    $('#total_records').hide();
                    $('#headerTable th:nth-child(8), #headerTable td:nth-child(8)').hide();
                    $('#headerTable th:nth-child(9), #headerTable td:nth-child(9)').hide();
                    $('#headerTable th:nth-child(10), #headerTable td:nth-child(10)').hide();

                    var logoUrl =
                        "{{ asset('public/frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png') }}";

                    // Get the content element
                    var contentElement = document.getElementById('studentlist');
                    var content = contentElement.innerHTML;



                    // Open a new window for printing
                    var mywindow = window.open('', 'Print');

                    // Write HTML structure and styles to the new window
                    mywindow.document.write('<html><head><title>Print Preview</title>');

                    // Add the top section with college logo, title, and address
                    mywindow.document.write(`
            <table cellpadding="0" cellspacing="0" class="tableCenter" style="width:100%; border: none;">
                <tbody>
                    <tr>
                        <td style="width:15%; text-align:center; border: none;">
                            <img src="${logoUrl}" style="width:100px;">
                        </td>
                        <td style="width:70%; text-align:center; padding:0px 20px 0px 20px; border: none;">
                            <h3 style="margin-top: 0px; margin-bottom: 4px; color:#0484BD; font-size:24px; font-weight:bold;">BAF Shaheen College Dhaka</h3>
                            <span style="font-size:14px;">Dhaka Cantonment, Dhaka-1206</span>
                            <h3 class="text-center" style="color:red; margin-top: 5px; font-size:20px; font-weight:bold;">Attendance Statistics Report</h3>
                        </td>
                        <td style="width:15%; text-align:center; border: none;"></td>
                    </tr>
                </tbody>
            </table>
        `);

                    // Add the content from the print-table
                    mywindow.document.write('</head><body>');
                    mywindow.document.write(content);
                    mywindow.document.write('</body></html>');

                    // Add styles for printing
                    mywindow.document.write(`
            <style>
                @page { size: 210mm 297mm; margin: 10mm 5mm 5mm 5mm; }
                table { width: 100%; border-collapse: collapse; }
                th, td { border: 1px solid black; padding: 8px; }
                tr:nth-child(even) { background-color: #f2f2f2; }
                tr:nth-child(odd) { background-color: #ffffff; }
                tr[style*="background-color: #f8d7da"] { background-color: red; }
                body { position: relative; }
            </style>
        `);

                    // Close the document and focus on the window
                    mywindow.document.close();
                    mywindow.focus();

                    // Trigger the print dialog
                    mywindow.print();

                    // Close the print window after it's ready
                    var myDelay = setInterval(function() {
                        if (mywindow.document.readyState === 'complete') {
                            clearInterval(myDelay);
                            mywindow.close();
                        }
                    }, 1000);

                    // Optionally, restore pagination and other elements after printing
                    $('.dataTables_paginate').show();
                    $('#total_records').show();
                });
            });
        </script>
        <script>
            $(function() {
                $(document.body).on('click', '#class_code', function() {
                    var class_code = $(this).val();
                    $('#class_code').val(class_code);
                    var url = "{{ route('getVersion') }}";
                    $.LoadingOverlay("show");
                    $.ajax({
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: url,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            class_code: class_code,
                        },
                        success: function(response) {
                            $('#versionAndShift').html(response);
                        },
                        error: function(data, errorThrown) {
                            Swal.fire({
                                title: "Error",
                                text: errorThrown,
                                icon: "warning"
                            });

                        },
                        complete: function() {
                            $.LoadingOverlay("hide");
                        }
                    });
                });
            });
        </script>

        <script>
            // Handle version change
            $(document.body).on('click', '.version-btn', function() {
                $('.shift-container').empty();
                var version_id = $(this).val();
                $('#versionId').val(version_id);
                var class_code = $('#class_code').val();
                // var exam_id = $('#exam_id').val();
                var session_id = $('#session_id').val();

                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                var targetContainer = $(this).data('target');

                console.log('Selected Version ID:', version_id);
                console.log('Selected Class Code:', class_code);
                // console.log('Selected Exam:', exam_id);
                console.log('Selected session_id:', session_id);

                if (version_id && from_date && to_date) {
                    var url = "{{ route('attendance.getShiftsForVersion') }}";
                    $.LoadingOverlay("show");
                    $.ajax({
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: url,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            version_id: version_id,
                            class_code: class_code,
                            // exam_id: exam_id,
                            session_id: session_id,
                            from_date: from_date,
                            to_date: to_date,
                        },
                        success: function(response) {

                            $('#' + targetContainer).html(response.html);
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: "Error",
                                text: xhr?.responseJSON?.error ||
                                    "An unexpected error occurred while loading shifts.",
                                icon: "warning"
                            });
                        },
                        complete: function() {
                            $.LoadingOverlay("hide");
                        }
                    });
                } else {
                    Swal.fire({
                        title: "Error",
                        text: "Please select a valid version and date range.",
                        icon: "warning"
                    });
                }
            });

            // Handle the shift change
            $(document.body).on('click', '[name="shiftId"]', function() {


                var session_id = $('#session_id').val();
                var shiftId = $(this).val();
                var version_id = $('#versionId').val();
                var class_code = $('#class_code').val();
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();

                console.log('class_code:', class_code);
                console.log('version_id:', version_id);
                console.log('shiftId:', shiftId);


                if (shiftId && version_id && class_code) {
                    console.log('Version ID: ' + version_id + ', Shift ID: ' + shiftId + ', Class Code: ' + class_code);

                    var url = "{{ route('student_attendance_section_page') }}";
                    $.LoadingOverlay("show");
                    $.ajax({
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: url,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            class_code: class_code,
                            version_id: version_id,
                            shift_id: shiftId,
                            session_id: session_id,
                            from_date: from_date,
                            to_date: to_date,
                        },
                        success: function(response) {
                            if (response.redirect_url) {
                                window.location.href = response.redirect_url;
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: "Error",
                                text: xhr?.responseJSON?.error || "An unexpected error occurred.",
                                icon: "warning"
                            });
                        },
                        complete: function() {
                            $.LoadingOverlay("hide");
                        }
                    });
                }
            });
        </script>
    @endsection
