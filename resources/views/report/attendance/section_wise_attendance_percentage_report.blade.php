<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Percentage Report</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #fff;
            margin: 20px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 60px;
            height: auto;
            margin-right: 15px;
        }

        .header-content {
            text-align: center;
        }

        .header-content h3 {
            margin: 0;
            color: #0484BD;
            font-size: 22px;
            font-weight: bold;
        }

        .header-content p {
            margin: 2px 0;
            font-size: 13px;
            color: #555;
        }

        .report-title {
            margin-top: 5px;
            font-size: 20px;
            font-weight: bold;
            color: #d9534f;
        }

        .info-section {
            width: 100%;
            margin: 0 auto 10px auto;
            padding: 10px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
        }

        .info-section table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .info-section td {
            padding: 6px 8px;
            border: 1px solid #dee2e6;
        }

        .info-section td strong {
            color: #343a40;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 11px;
        }

        .table th,
        .table td {
            padding: 6px 8px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .table th {
            background-color: #1c4d7c;
            color: #fff;
            font-size: 12px;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .present {
            color: green;
            font-weight: bold;
        }

        .absent {
            color: red;
            font-weight: bold;
        }

        .leave {
            color: #04c3ec;
            font-weight: bold;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .table th {
                background-color: #1c4d7c !important;
                -webkit-print-color-adjust: exact;
            }

            .info-section {
                border: none;
                background: transparent;
            }
        }
    </style>
</head>

@php
    $class = [
        '0' => 'KG',
        '1' => 'I',
        '2' => 'II',
        '3' => 'III',
        '4' => 'IV',
        '5' => 'V',
        '6' => 'VI',
        '7' => 'VII',
        '8' => 'VIII',
        '9' => 'IX',
        '10' => 'X',
        '11' => 'XI',
        '12' => 'XII',
    ];
@endphp

<body>

    <div class="header">
        <img style="width: 80px; height: auto;"
            src="{{ asset('public/frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png') }}"
            alt="School Logo">
        <div class="header-content">
            <h3>BAF Shaheen College Dhaka</h3>
            <p>Dhaka Cantonment, Dhaka-1206</p>
            <div class="report-title">
                Attendance Percentage Report
            </div>
        </div>
    </div>

    <!-- BEAUTIFIED INFO SECTION -->
    <div class="info-section">
        <table>
            <tr>
                <td><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($start_date)->format('d-m-Y') }}</td>
                <td><strong>End Date:</strong> {{ \Carbon\Carbon::parse($end_date)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <td><strong>Session:</strong> {{ $session_id }}</td>
                <td><strong>Version:</strong> {{ $version_id == 1 ? 'Bangla' : 'English' }}</td>
            </tr>
            <tr>
                <td><strong>Shift:</strong> {{ $shift_id == 1 ? 'Morning' : 'Bangla' }}</td>
                <td><strong>Class:</strong> {{ $class[$class_code] }}</td>
            </tr>
            <tr>
                <td><strong>Section Name:</strong> {{ $section_name }}</td>
                <td><strong>Teacher Name:</strong> {{ $teacher_name }}</td>
            </tr>
            <tr>
                <td><strong>Total Working Days:</strong> {{ $total_days }}</td>
                <td><strong>Total Section Working Days:</strong> {{ $total_days_section }}</td>
            </tr>
        </table>
    </div>
    <!-- END INFO SECTION -->

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>SL.</th>
                    <th>Roll</th>
                    <th style="text-align: left">Student Name</th>
                    <th>Total Days</th>
                    <th>Present(%)</th>
                    <th>Absent(%)</th>
                    <th>Leave(%)</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($attendance_details as $student)
                    @php
                        $final_absent = $student->total_absent - $student->re_absent + $student->re_final_absent;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $student->roll }}</td>
                        <td style="text-align: left">{{ strtoupper($student->first_name) }}</td>
                        <td>{{ $student->total_records }}</td>
                        <td class="present">
                            {{ number_format(($student->total_present / $total_days) * 100, 2) }}%
                        </td>
                        <td class="absent">
                            {{ number_format(($final_absent / $total_days) * 100, 2) }}%
                        </td>
                        <td class="leave">
                            {{ number_format((($student->total_leave + ($student->total_absent - $final_absent)) / $total_days) * 100, 2) }}%
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>
