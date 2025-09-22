@extends('admin.layouts.layout')
@section('content')
    <style>
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            max-width: 700px;
            margin: auto;
        }

        .day,
        .header {
            border: 1px solid #dddddd;
            padding: 10px;
            text-align: center;
        }

        .header {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .Present {
            background-color: #047f08;
            color: white;
        }

        .Absent {
            background-color: #b81010;
            color: white;
        }

        .Leave {
            background-color: #d9b800;
            color: white;
        }

        .Late {
            background-color: #ea9ea6;
            color: white;
        }

        .Missing {
            background-color: #000000;
            color: white;
        }

        .remarks {
            font-size: 0.8em;
            color: white;
            font-weight: bold;
        }

        .header-container {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Attendance</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12 text-center my-3">
                            <h1>Student Monthly Attendance Calendar</h1>
                            <p><strong>Name:</strong> {{ $studentName }}</p>
                            <label for="month-select">Select Month:</label>
                            <select id="month-select" class="form-control w-auto d-inline-block mx-2">
                                @foreach ($months as $key => $month)
                                    <option value="{{ $key }}" {{ $key == $selectedMonth ? 'selected' : '' }}>
                                        {{ $month }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive" id="attendanceDetails">
                        <div class="calendar">
                            <div class="header">Sun</div>
                            <div class="header">Mon</div>
                            <div class="header">Tue</div>
                            <div class="header">Wed</div>
                            <div class="header">Thu</div>
                            <div class="header">Fri</div>
                            <div class="header">Sat</div>
                            @php
                                use Carbon\Carbon;
                                $startDate = new Carbon($startDate);
                                $endDate = new Carbon($endDate);
                                $currentDate = $startDate->copy();
                                $attendanceArray = $attendanceData->keyBy('attendance_date')->toArray();
                                $status = ['Present', 'Absent', 'Leave', 'Late', 'Missing'];
                            @endphp

                            @for ($i = 0; $i < $startDate->dayOfWeek; $i++)
                                <div class="day"></div>
                            @endfor

                            @while ($currentDate <= $endDate)
                                @php
                                    $dateString = $currentDate->format('Y-m-d');
                                    $attendanceRecord = $attendanceArray[$dateString] ?? null;
                                @endphp
                                <div class="day {{ $attendanceRecord ? $status[$attendanceRecord['status'] - 1] : '' }}">
                                    <div>{{ $currentDate->day }}</div>
                                    @if ($attendanceRecord)
                                        <div class="remarks">
                                            {{ $status[$attendanceRecord['status'] - 1] }}
                                        </div>
                                    @endif
                                </div>
                                @php
                                    $currentDate->addDay();
                                @endphp
                            @endwhile
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-backdrop fade"></div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#month-select').change(function() {
                var month = $(this).val();
                var student_code = '{{ $studentCode }}'; // you must pass this from the controller

                $.LoadingOverlay("show");

                $.ajax({
                    type: "POST",
                    url: "{{ route('getAttendanceByMonth') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        month: month,
                        student_code: student_code
                    },
                    success: function(response) {
                        $('#attendanceDetails').html(response);
                        $.LoadingOverlay("hide");
                    },
                    error: function(xhr, status, error) {
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            title: "Error",
                            text: error,
                            icon: "error"
                        });
                    }
                });
            });
        });
    </script>
@endsection
