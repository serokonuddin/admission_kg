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

                    <li class="breadcrumb-item active" aria-current="page"> Attendance Report Summary </li>

                </ol>
            </nav>

            <div class="col-md mb-4 mb-md-0">
                <div class="card gradient-card">
                    <div class="card-header">
                        <h5 class="card-title text-center">
                            Attendance Report Summary
                        </h5>
                        <div class="row">
                            <div class="col-12">
                                <form action="{{ route('student.attendance.statistics2') }}" method="get">
                                    @csrf
                                    <div class="card shadow-sm p-4">
                                        <h5 class="mb-3 text-lg font-semibold text-gray-700">Filter Records</h5>
                                        <div class="row g-3">
                                            <!-- Start Date -->
                                            <div class="col-md-3">
                                                <label for="from_date" class="form-label fw-semibold">Start Date <span
                                                        class="text-danger">*</span></label>
                                                <input type="date" id="from_date" name="from_date" class="form-control"
                                                    value="{{ $todayDate ? $todayDate : date('Y-m-d') }}" required>
                                                <div class="invalid-feedback">Please select a date.</div>
                                            </div>

                                            <!-- End Date -->
                                            <div class="col-md-3">
                                                <label for="to_date" class="form-label fw-semibold">End Date <span
                                                        class="text-danger">*</span></label>
                                                <input type="date" id="to_date" name="to_date" class="form-control"
                                                    value="{{ $toDate ? $toDate : date('Y-m-d') }}" required>
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

                                            <!-- Class -->
                                            <div class="col-md-3">
                                                <label for="class_id" class="form-label fw-semibold">Class</label>
                                                <select id="class_id" name="class_id" class="form-select">
                                                    <option value="">Select Class</option>
                                                    {{-- Options will be dynamically populated by JavaScript --}}
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
                                @if (!empty($studentsummary) && count($studentsummary))
                                    @php
                                        $grand_total = ['total' => 0, 'present' => 0, 'absent' => 0];
                                    @endphp

                                    <table class="table"
                                        style="border-collapse: collapse; width: 100%; border: 1px solid black;">
                                        <thead>
                                            <tr style="background-color: #f2f2f2; border: 1px solid black;">
                                                <th rowspan="2" style="width: 10%; border: 1px solid black;">Version
                                                </th>
                                                <th rowspan="2" style="width: 10%; border: 1px solid black;">Shift</th>
                                                <th rowspan="2" style="width: 10%; border: 1px solid black;">Class</th>
                                                <th rowspan="2" style="width: 10%; border: 1px solid black;">Section
                                                </th>
                                                {{-- <th rowspan="2" style="width: 10%; border: 1px solid black;">Total Students
                                        </th> --}}
                                                <th rowspan="2" style="width: 15%; border: 1px solid black;">Total
                                                    Working
                                                    Days</th>
                                                <th rowspan="2" style="width: 10%; border: 1px solid black;">Present(%)
                                                </th>
                                                <th rowspan="2" style="width: 10%; border: 1px solid black;">Absent(%)
                                                </th>
                                                <th colspan="2"
                                                    style="width: 10%; border: 1px solid black; text-align: center">Total
                                                </th>
                                            </tr>
                                            <tr style="background-color: #f2f2f2; border: 1px solid black;">
                                                <th style="width: 10%; border: 1px solid black;">Present(%)</th>
                                                <th style="width: 10%; border: 1px solid black;">Absent(%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($studentsummary as $version_name => $versionGroup)
                                                @foreach ($versionGroup as $shift_name => $shiftGroup)
                                                    @foreach ($shiftGroup as $class_code => $classGroup)
                                                        @php
                                                            $shift_total = [
                                                                'total' => 0,
                                                                'present' => 0,
                                                                'absent' => 0,
                                                            ];
                                                            foreach ($classGroup as $class) {
                                                                $shift_total['total'] += $class->total_count ?? 0;
                                                                $shift_total['present'] += $class->present_count ?? 0;
                                                                $shift_total['absent'] += $class->absent_count ?? 0;
                                                            }
                                                        @endphp

                                                        @foreach ($classGroup as $index => $class)
                                                            @php
                                                                $total = $class->total_count ?? 0;
                                                                $present = $class->present_count ?? 0;
                                                                $absent = $class->absent_count ?? 0;
                                                                $working_days = $class->working_days ?? 0;

                                                                $grand_total['total'] += $total;
                                                                $grand_total['present'] += $present;
                                                                $grand_total['absent'] += $absent;
                                                            @endphp

                                                            <tr
                                                                style="background-color: {{ $present == 0 ? '#f8d7da' : '#ffffff' }}; border: 1px solid black;">
                                                                @if ($index === 0)
                                                                    <td style="border: 1px solid black;"
                                                                        rowspan="{{ count($classGroup) }}">
                                                                        {{ $version_name }}</td>
                                                                    <td style="border: 1px solid black;"
                                                                        rowspan="{{ count($classGroup) }}">
                                                                        {{ $shift_name }}</td>
                                                                    <td style="border: 1px solid black;"
                                                                        rowspan="{{ count($classGroup) }}">
                                                                        {{ $className[$class_code] ?? $class_code }}</td>
                                                                @endif

                                                                <td style="border: 1px solid black;">
                                                                    {{ $class->section_name ?? '' }}</td>
                                                                {{-- <td
                                                            style="text-align: center; font-weight:500; border: 1px solid black;">
                                                            {{ $class->total_count }}</td> --}}
                                                                <td
                                                                    style="text-align: center; font-weight:500; border: 1px solid black;">
                                                                    {{ $working_days }}</td>
                                                                <td
                                                                    style="text-align: center; color:#008000; font-weight:500; border: 1px solid black;">
                                                                    {{ $class->present_percentage ?? '0.00' }}%
                                                                </td>
                                                                <td
                                                                    style="text-align: center; color:#ff0000; font-weight:500; border: 1px solid black;">
                                                                    {{ $class->absent_percentage ?? '0.00' }}%
                                                                </td>

                                                                @if ($index === 0)
                                                                    <td style="text-align: center; color:#008000; font-weight:500; border: 1px solid black;"
                                                                        rowspan="{{ count($classGroup) }}">
                                                                        {{ $shift_total['present'] && $shift_total['total'] ? number_format(($shift_total['present'] / $shift_total['total']) * 100, 2) : '0.00' }}%
                                                                    </td>
                                                                    <td style="text-align: center; color:#ff0000; font-weight:500; border: 1px solid black;"
                                                                        rowspan="{{ count($classGroup) }}">
                                                                        {{ $shift_total['absent'] && $shift_total['total'] ? number_format(($shift_total['absent'] / $shift_total['total']) * 100, 2) : '0.00' }}%
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="alert alert-info text-center" role="alert">
                                        No attendance data found for the selected date range.
                                    </div>
                                @endif


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
        @php
            $oldClassFor = old('class_for', $class_for ?? '');
            $oldClassId = old('class_id', $class_id ?? '');
        @endphp

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const classForSelect = document.getElementById('class_for');
                const classSelect = document.getElementById('class_id');

                const classOptions = {
                    1: [0, 1, 2, 3, 4, 5],
                    2: [6, 7, 8, 9, 10],
                    3: [11, 12],
                    all: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                };

                const classes = {
                    0: 'KG',
                    1: 'I',
                    2: 'II',
                    3: 'III',
                    4: 'IV',
                    5: 'V',
                    6: 'VI',
                    7: 'VII',
                    8: 'VIII',
                    9: 'IX',
                    10: 'X',
                    11: 'XI',
                    12: 'XII'
                };

                const oldClassFor = "{{ $class_for ?? '' }}";
                const oldClassId = "{{ $class_code ?? '' }}"; // assuming class_code is class_id

                function populateClasses(classFor) {
                    const selected = parseInt(classFor);
                    let options = [];

                    if (selected === 1) {
                        options = classOptions[1];
                    } else if (selected === 2) {
                        options = classOptions[2];
                    } else if (selected === 3) {
                        options = classOptions[3];
                    } else {
                        options = classOptions['all'];
                    }

                    classSelect.innerHTML = '<option value="">Select Class</option>';
                    options.forEach(num => {
                        const opt = document.createElement('option');
                        opt.value = num;
                        opt.textContent = `Class ${classes[num]}`;
                        if (parseInt(oldClassId) === num) {
                            opt.selected = true;
                        }
                        classSelect.appendChild(opt);
                    });
                }

                // Set initial values
                if (oldClassFor) {
                    classForSelect.value = oldClassFor;
                    populateClasses(oldClassFor);
                }

                // Update on change
                classForSelect.addEventListener('change', function() {
                    populateClasses(this.value);
                });
            });
        </script>


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
