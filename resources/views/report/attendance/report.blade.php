<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Report</title>
    <style>
        th,
        td {
            padding: 8px;
            text-align: center;

        }

        .tableBorderNo {
            border: 0px solid #FFF;
        }

        .tableCenter {
            margin-left: auto;
            margin-right: auto;
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
            vertical-align: middle !important;
        }

        .table:not(.table-dark) th {
            color: #ffffff;
        }

        .form-label {

            width: 100%;
        }

        .rounded {
            border-radius: 8px;

        }

        .present {
            color: rgb(31, 212, 40);
            font-weight: bold
        }

        .absent {
            color: rgb(191, 5, 5);
            font-weight: bold
        }

        .leave {
            color: rgb(11, 177, 228);
            font-weight: bold
        }

        .late {
            color: rgb(211, 226, 6);
            font-weight: bold
        }

        .missing {
            color: rgb(19, 78, 187);
            font-weight: bold
        }
    </style>

</head>

<body>
    <div>
        <table class="table tableBorderNo">
            <tbody>
                <tr>
                    <td>
                        <table>
                            <tbody>
                                <tr>
                                    <td style="width:15%; text-align:center;">
                                        <img src="{{ asset('public/frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png') }}"
                                            style="width:100px;">
                                    </td>
                                    <td style="width:70%; text-align:center; padding:0px 20px 0px 20px;">
                                        <h3
                                            style="margin-top: 0px; margin-bottom: 4px; color:#0484BD; font-size:24px; font-weight:bold; white-space: nowrap;">
                                            BAF Shaheen College Dhaka</h3>
                                        <span
                                            style="text-align:center; margin-top: 0px; margin-bottom: 0px; font-size:14px;">
                                            Dhaka Cantonment, Dhaka-1206
                                        </span>
                                        <h3 class="text-center"
                                            style="color:red; margin-top: 5px; margin-bottom: 0px; font-size:20px; font-weight:bold; white-space: nowrap;">
                                            Attendance Report</h3>
                                    </td>
                                    <td style="width:15%; text-align:center;"></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div>
        <table class="table table-responsive table-border-bottom-0">
            <thead class="table-dark">
                <tr>
                    <th>SL.</th>
                    <th>Date</th>
                    <th>Roll</th>
                    <th>Student Name</th>
                    <th>Father Name</th>
                    <th>SMS Notification</th>
                    <th>Class</th>
                    <th>Section</th>
                    <th>Status</th>
                    <th>Time</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $statuses = [
                        1 => 'Present',
                        2 => 'Absent',
                        3 => 'Leave',
                        4 => 'Late',
                        5 => 'Missing',
                    ];
                @endphp
                @foreach ($filteredDateRange as $date)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}</td>
                        <td>{{ $student->roll }}</td>
                        <td>{{ $student->first_name . ' ' . $student->last_name }}</td>
                        <td>{{ $student->father_name }}</td>
                        <td>{{ $student->sms_notification }}</td>
                        <td>{{ $student->class_name }}</td>
                        <td>{{ $student->section_name }}</td>
                        <td>{{ isset($attendance[$date]) && $attendance[$date]['status'] ? $statuses[$attendance[$date]['status']] : 'N/A' }}
                        </td>
                        <td>{{ isset($attendance[$date]) && $attendance[$date]['time'] ? $attendance[$date]['time'] : 'N/A' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
