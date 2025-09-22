<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Report</title>
    <style>
        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table-bordered th,
        .table-bordered td {
            padding: 8px;
            text-align: center;
            border: 1px solid #d8d6d6;
        }

        #main th,
        td {
            padding: 8px;
            text-align: center;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table-dark th {
            background-color: #1c4d7c;
            color: #fff;
        }

        .tableBorderNo {
            border: 0px solid #FFF !important;
        }

        .tableCenter {
            margin-left: auto;
            margin-right: auto;
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
    <div id="main">
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
    <div class="table-responsive">
        <table class="table table-bordered">
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

                @foreach ($students as $student)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($student->attendance_date)->format('d-m-Y') }}</td>
                        <td>{{ $student->roll }}</td>
                        <td>{{ $student->first_name . ' ' . $student->last_name }}</td>
                        <td>{{ $student->father_name }}</td>
                        <td>{{ $student->sms_notification }}</td>
                        <td>{{ $student->class_name }}</td>
                        <td>{{ $student->section_name }}</td>
                        <td>{{ isset($student->attendance_status) && $student->attendance_status != null ? $student->attendance_status : '' }}
                        </td>
                        <td>{{ isset($student->time) && $student->time != null ? $student->time : '' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
