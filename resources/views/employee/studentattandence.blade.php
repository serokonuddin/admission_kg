@extends('admin.layouts.layout')
@section('content')
    <style>
        @media only screen and (min-width:600px) {
            #attendance-part .nav-item {
                width: 23%;
                padding: 3px;

            }
        }

        @media only screen and (max-width:600px) {
            #attendance-part .nav-item {
                width: 98%;
                padding: 2%;

            }
        }

        #attendance-part .nav-pills .nav-link,
        #attendance-part .nav-pills .nav-link,
        #attendance-part .nav-pills .nav-link {
            background-color: white;
            color: #000;
            box-shadow: 0 2px 4px 0 rgba(233, 233, 248, 0.4);
        }

        #attendance-part .nav-pills .nav-link.active,
        #attendance-part .nav-pills .nav-link.active,
        #attendance-part .nav-pills .nav-link.active {
            background-color: #3d70a6;
            color: #fff;
            box-shadow: 0 2px 4px 0 rgba(233, 233, 248, 0.4);
        }

        #attendance-part .demo-inline-spacing>* {
            margin: 1.8rem 0.375rem 0 0 !important;
        }

        .avatar img {
            width: 40px;
            height: 40px;
        }

        .present {
            color: rgb(13, 70, 163);
            font-weight: bold
        }

        .absent {
            color: rgb(191, 5, 5);
            font-weight: bold
        }

        .leave {
            color: rgb(5, 191, 11);
            font-weight: bold
        }

        .late td {
            background: rgb(245 216 201);
            font-weight: bold
        }

        .table>:not(caption)>*>* {
            padding: .125rem .25rem !important;
        }

        ::-webkit-scrollbar {
            width: 3px !important;
            height: 3px !important;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px !important;
        }

        .table-dark {
            background-color: #1c4d7c !important;
            color: #fff !important;
            font-weight: bold;
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

        .table:not(.table-dark) th {
            color: #ffffff;
        }

        .table-info {
            --bs-table-bg: #0aacce !important;
            ;
            --bs-table-striped-bg: #c9eef7;
            --bs-table-striped-color: #435971;
            --bs-table-active-bg: #bfe4ed;
            --bs-table-active-color: #435971;
            --bs-table-hover-bg: #c5eaf3;
            --bs-table-hover-color: #435971;
            color: #435971;
            border-color: #bfe4ed;
        }

        .form-label {
            width: 100% !important;
        }

        tr:nth-child(even) {
            background-color: #d8d8d8 !important;
            /* Light gray for even rows */
        }

        tr:nth-child(odd) {
            background-color: #ffffff !important;
            /* White for odd rows */
        }
    </style>
    <link rel="stylesheet" href="{{ asset('public/backend') }}/assets/vendor/libs/flatpickr/flatpickr.css" />
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y" id="attendance-part">
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"> Students Attendance</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('studentAttendanceStore') }}" id="formsubmit">
                        @csrf
                        <input type="hidden" id="type" name="type" value="{{ Session::get('employee_for') }}">
                        <input type="hidden" id="session_id" name="session_id" value="{{ Session::get('session_id') }}">
                        <input type="hidden" id="section_id" name="section_id" value="{{ Session::get('section_id') }}">
                        <input type="hidden" id="version_id" name="version_id" value="{{ Session::get('version_id') }}">
                        <input type="hidden" id="shift_id" name="shift_id" value="{{ Session::get('shift_id') }}">
                        <input type="hidden" id="class_id" name="class_id" value="{{ Session::get('class_id') }}">

                        <div class="card mb-4">
                            <div class="card-header table-responsive rounded">
                                <small class="text-danger">NB: Please update attendance time if a student arrives
                                    late</small>
                                <table class="table table-hover table-bordered rounded-lg mt-2 mb-2 statistics">
                                    <thead class="table-dark">
                                        <tr>
                                            <th style="width: 12%;text-align:center;font-weight:bold;color:white;">
                                                Class
                                            </th>
                                            <th style="width: 13%;text-align:center;font-weight:bold;color:white;">
                                                Section</th>
                                            <th style="width: 13%;text-align:center;font-weight:bold;color:white;">
                                                Date
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        <tr>
                                            <td style="text-align:center;font-weight:bold;">
                                                {{ $employeeActivity->class_name }}
                                            </td>
                                            <td style="text-align:center;font-weight:bold;">
                                                {{ $employeeActivity->section_name }}
                                            </td>
                                            <td style="text-align:center;font-weight:bold;">
                                                {{ date('Y-m-d') }}
                                                <input type="hidden" id="attendance_date" name="attendance_date"
                                                    value="{{ Session::get('attendance_date') ? Session::get('attendance_date') : date('Y-m-d') }}"
                                                    placeholder="Attendance Date" required>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive rounded">
                                    <table class="table table-hover rounded-lg main">
                                        <thead class="table-info" style="position: sticky; top: 0; z-index: 1000;">
                                            <tr style="vertical-align: middle;">
                                                <th style="width:5%">SL</th>
                                                <th style="width: 10%">

                                                    @if (!data_get($students, '0.studentAttendance.status'))
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="all"
                                                                value="" id="all" />
                                                            <label class="form-check-label" for="all"> ALL </label>
                                                        </div>
                                                    @endif
                                                </th>
                                                <th style="width: 20%;word-wrap: break-word;">Student Name</th>
                                                <th style="width: 12%">Mobile</th>
                                                <th style="width: 12%">Father</th>
                                                <th style="width: 13%">Mother</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0 main">
                                            @foreach ($students as $student)
                                                <tr
                                                    class="{{ isset($student->studentAttendance->status) && $student->studentAttendance->status == 4 ? 'late' : '' }}">
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>
                                                        <input type="hidden" name="student_code[]"
                                                            value="{{ $student->student_code }}" />
                                                        <div class="form-check form-check-inline mt-3">
                                                            <input
                                                                class="form-check-input {{ !data_get($students, '0.studentAttendance.status') ? '' : 'attendance' }}  Present"
                                                                type="radio"
                                                                {{ isset($student->studentAttendance->status) && ($student->studentAttendance->status == 1 || $student->studentAttendance->status == 4) ? 'checked="checked"' : '' }}
                                                                name="attendance{{ $student->student_code }}"
                                                                id="attendance{{ $student->student_code }}1"
                                                                data-studentcode="{{ $student->student_code }}"
                                                                value="1" />
                                                            <label
                                                                class="form-check-label {{ isset($student->studentAttendance->status) && $student->studentAttendance->status == 1 ? 'present' : '' }}"
                                                                for="attendance{{ $student->student_code }}1">Present</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input
                                                                class="form-check-input {{ !data_get($students, '0.studentAttendance.status') ? '' : 'attendance' }} Absent"
                                                                {{ isset($student->studentAttendance->status) && $student->studentAttendance->status == 2 ? 'checked="checked"' : '' }}
                                                                type="radio"
                                                                name="attendance{{ $student->student_code }}"
                                                                id="attendance{{ $student->student_code }}2"
                                                                data-studentcode="{{ $student->student_code }}"
                                                                value="2" />
                                                            <label
                                                                class="form-check-label {{ isset($student->studentAttendance->status) && $student->studentAttendance->status == 2 ? 'absent' : '' }}"
                                                                for="attendance{{ $student->student_code }}2">Absent</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input
                                                                class="form-check-input {{ !data_get($students, '0.studentAttendance.status') ? '' : 'attendance' }} Leave"
                                                                type="radio"
                                                                {{ isset($student->studentAttendance->status) && $student->studentAttendance->status == 3 ? 'checked="checked"' : '' }}
                                                                name="attendance{{ $student->student_code }}"
                                                                id="attendance{{ $student->student_code }}3"
                                                                data-studentcode="{{ $student->student_code }}"
                                                                value="3" />
                                                            <label
                                                                class="form-check-label {{ isset($student->studentAttendance->status) && $student->studentAttendance->status == 3 ? 'leave' : '' }}"
                                                                for="attendance{{ $student->student_code }}3">Leave</label>
                                                        </div>
                                                        @if ($student->class_name > 10)
                                                            <div class="form-check form-check-inline">
                                                                <input
                                                                    class="form-check-input {{ !data_get($students, '0.studentAttendance.status') ? '' : 'attendance' }} Missing"
                                                                    type="radio"
                                                                    {{ isset($student->studentAttendance->status) && $student->studentAttendance->status == 5 ? 'checked="checked"' : '' }}
                                                                    name="attendance{{ $student->student_code }}"
                                                                    id="attendance{{ $student->student_code }}5"
                                                                    data-studentcode="{{ $student->student_code }}"
                                                                    value="5" />
                                                                <label
                                                                    class="form-check-label {{ isset($student->studentAttendance->status) && $student->studentAttendance->status == 5 ? 'Missing' : '' }}"
                                                                    for="attendance{{ $student->student_code }}5">Missing</label>
                                                            </div>
                                                        @endif
                                                        <input
                                                            class="form-control {{ !data_get($students, '0.studentAttendance.status') ? '' : 'attendance-time' }}"
                                                            name="time{{ $student->student_code }}"
                                                            id="time{{ $student->student_code }}" type="time"
                                                            value="{{ isset($student->studentAttendance->time) ? $student->studentAttendance->time : $start_time }}"
                                                            data-studentcode="{{ $student->student_code }}"
                                                            id="html5-time-input" required>
                                                    </td>
                                                    <td style="word-wrap: break-word;">
                                                        Roll: {{ $student->roll }}<br>
                                                        {{ $student->first_name . ' ' . $student->last_name }}
                                                    </td>

                                                    <td>
                                                        {{ $student->sms_notification ?? 'NA' }}
                                                        <input type="hidden"
                                                            id="sms_notification{{ $student->student_code }}"
                                                            name="sms_notification{{ $student->student_code }}"
                                                            value="{{ $student->sms_notification }}" />
                                                        <input type="hidden" id="first_name{{ $student->student_code }}"
                                                            name="first_name{{ $student->student_code }}"
                                                            value="{{ $student->first_name }}" />

                                                    </td>
                                                    <td>
                                                        {{ $student->father_name ?? 'NA' }} <br>
                                                        {{ $student->father_phone ?? 'NA' }}
                                                    </td>
                                                    <td>
                                                        {{ $student->mother_name ?? 'NA' }} <br>
                                                        {{ $student->mother_phone ?? 'NA' }}
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                @if (!data_get($students, '0.studentAttendance.status'))
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#attendanceModal" id="submit">Submit</button>
                                @endif
                               
                            </div>

                        </div>
                    </form>
                    <!-- Modal -->
                    <div class="modal fade" id="attendanceModal" tabindex="-1" aria-labelledby="attendanceModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-info" id="attendanceModalLabel">Attendance Summary</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-dark text-center">
                                            <tr>
                                                <th>Type</th>
                                                <th>Count</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Present</td>
                                                <td><span id="presentCount">0</span></td>
                                            </tr>
                                            <tr>
                                                <td>Absent</td>
                                                <td><span id="absentCount">0</span></td>
                                            </tr>
                                            <tr>
                                                <td>Late</td>
                                                <td><span id="lateCount">0</span></td>
                                            </tr>
                                            <tr>
                                                <td>Leave</td>
                                                <td><span id="leaveCount">0</span></td>
                                            </tr>
                                            <tr>
                                                <td>Missing</td>
                                                <td><span id="missingCount">0</span></td>
                                            </tr>
                                            <tr>
                                                <td>Total</td>
                                                <td><span id="totalCount">0</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary" id="confirmSubmit">Confirm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->
        <div class="content-backdrop fade"></div>
    </div>
    <script>
        // Get today's date in the format YYYY-MM-DD
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('attendance_date').setAttribute('min', today);
    </script>
    <script>
        @if ($errors->any())
            Swal.fire({
                title: "Error",
                text: "{{ implode(',', $errors->all(':message')) }}",
                icon: "warning"
            });
        @endif

        @if (Session::get('success'))
            Swal.fire({
                title: "Good job!",
                text: "{{ Session::get('success') }}",
                icon: "success"
            });
        @endif

        @if (Session::get('error'))
            Swal.fire({
                title: "Error",
                text: "{{ Session::get('error') }}",
                icon: "warning"
            });
        @endif
    </script>
    <script>
        $(function() {
            $(document.body).on('change', '.attendance-time', function() {
                var student_code = $(this).data('studentcode');
                var status = $('#attendance' + student_code).filter(':checked').val();
                var time = $('#time' + student_code).val();
                var attendance_date = $('#attendance_date').val();
                var session_id = $('#session_id').val();
                var section_id = $('#section_id').val();
                var version_id = $('#version_id').val();
                var shift_id = $('#shift_id').val();
                var class_id = $('#class_id').val();
                var sms_notification = $('#sms_notification' + student_code).val();
                var first_name = $('#first_name' + student_code).val();
                var url = "{{ route('updateAttendance') }}";
                $.LoadingOverlay("show");
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        session_id,
                        shift_id,
                        class_id,
                        section_id,
                        version_id,
                        attendance_date,
                        student_code,
                        status,
                        time,
                        sms_notification,
                        first_name

                    },
                    success: function(response) {
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            title: "Success",
                            text: response,
                            icon: "success"
                        });


                    },
                    error: function(data, errorThrown) {
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            title: "Error",
                            text: errorThrown,
                            icon: "warning"
                        });

                    }
                });
            });
            $(document.body).on('click', '.attendance', function() {
                var student_code = $(this).data('studentcode');
                var status = $(this).val();
                var time = $('#time' + student_code).val();
                var attendance_date = $('#attendance_date').val();
                var session_id = $('#session_id').val();
                var section_id = $('#section_id').val();
                var version_id = $('#version_id').val();
                var shift_id = $('#shift_id').val();
                var class_id = $('#class_id').val();
                var sms_notification = $('#sms_notification' + student_code).val();
                var first_name = $('#first_name' + student_code).val();
                var url = "{{ route('updateAttendance') }}";
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        session_id,
                        shift_id,
                        class_id,
                        section_id,
                        version_id,
                        attendance_date,
                        student_code,
                        status,
                        time,
                        sms_notification,
                        first_name

                    },
                    success: function(response) {
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            title: "Success",
                            text: response,
                            icon: "success"
                        });


                    },
                    error: function(data, errorThrown) {
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            title: "Error",
                            text: errorThrown,
                            icon: "warning"
                        });

                    }
                });
            });
            $(document.body).on('click', '.type', function() {
                var type = $(this).data('type');
                $('#type').val(type);
                var shift_id = $('input[name="shift_id"]:checked').val();
                var version_id = $('input[name="version_id"]:checked').val();
                $.LoadingOverlay("show");
                var id = $(this).val();
                var url = "{{ route('getTypeWiseClass') }}";
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        type: type,
                        shift_id,
                        version_id
                    },
                    success: function(response) {

                        $('#class_id').html(response)
                        $('#studentlist').html('');
                        $.LoadingOverlay("hide");

                    },
                    error: function(data, errorThrown) {
                        Swal.fire({
                            title: "Error",
                            text: errorThrown,
                            icon: "warning"
                        });

                    }
                });
                $('.type' + ' a').removeClass('active');
                $('.' + type + ' a').addClass('active');
            });
            $(document.body).on('change', 'input[type=radio][name=version_id]', function() {
                var type = $('#type').val();
                var shift_id = $('input[name="shift_id"]:checked').val();
                var version_id = $('input[name="version_id"]:checked').val();
                $.LoadingOverlay("show");
                var id = $(this).val();
                var url = "{{ route('getTypeWiseClass') }}";
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        type: type,
                        shift_id,
                        version_id
                    },
                    success: function(response) {

                        $('#class_id').html(response)
                        $.LoadingOverlay("hide");

                    },
                    error: function(data, errorThrown) {
                        Swal.fire({
                            title: "Error",
                            text: errorThrown,
                            icon: "warning"
                        });

                    }
                });
                $('.type' + ' a').removeClass('active');
                $('.' + type + ' a').addClass('active');
            });
            $(document.body).on('change', 'input[type=radio][name=shift_id]', function() {
                var type = $('#type').val();
                var shift_id = $('input[name="shift_id"]:checked').val();
                var version_id = $('input[name="version_id"]:checked').val();
                $.LoadingOverlay("show");
                var id = $(this).val();
                var url = "{{ route('getTypeWiseClass') }}";
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        type: type,
                        shift_id,
                        version_id
                    },
                    success: function(response) {

                        $('#class_id').html(response);
                        $('#studentlist').html('');
                        $.LoadingOverlay("hide");

                    },
                    error: function(data, errorThrown) {
                        Swal.fire({
                            title: "Error",
                            text: errorThrown,
                            icon: "warning"
                        });

                    }
                });
                $('.type' + ' a').removeClass('active');
                $('.' + type + ' a').addClass('active');
            });
            $(document.body).on('change', 'input[type=checkbox][name=all]', function() {

                if ($('#all').is(':checked')) {

                    $('table .form-check-input.Present').each(function() {
                        console.log(2);
                        $(this).prop('checked', true);

                    });
                } else {

                    $('table .form-check-input').each(function() {

                        $(this).prop('checked', false);

                    });
                }

            });
            $(document.body).on('click', '.datacync', function() {
                $.LoadingOverlay("show");
                setTimeout(
                    function() {
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            title: "Good job!",
                            text: "Successfully Import Student Attendance",
                            icon: "success"
                        });

                    }, 1000);


            });
            $(document.body).on('change', '#class_id', function() {
                var id = $(this).val();
                var shift_id = $('input[name="shift_id"]:checked').val();
                var version_id = $('input[name="version_id"]:checked').val();
                var url = "{{ route('getSections') }}";
                $.LoadingOverlay("show");
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        class_id: id,
                        shift_id,
                        version_id
                    },
                    success: function(response) {
                        $.LoadingOverlay("hide");
                        $('#section_id').html(response);
                        $('#studentlist').html('');

                    },
                    error: function(data, errorThrown) {
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            title: "Error",
                            text: errorThrown,
                            icon: "warning"
                        });

                    }
                });
            });
            $(document.body).on('change', '#section_id', function() {

                var attendance_date = $('#attendance_date').val();
                var class_id = $('#class_id').val();
                var session_id = $('#session_id').val();
                var shift_id = $('input[name="shift_id"]:checked').val();
                var version_id = $('input[name="version_id"]:checked').val();
                $.LoadingOverlay("show");
                var section_id = $('#section_id').val();
                if (section_id && attendance_date && version_id && shift_id && session_id && class_id) {
                    var url = "{{ route('getStudents') }}";
                    $.ajax({
                        type: "get",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: url,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            session_id,
                            shift_id,
                            class_id,
                            section_id,
                            version_id,
                            attendance_date
                        },
                        success: function(response) {
                            $.LoadingOverlay("hide");
                            $('#studentlist').html(response)


                        },
                        error: function(data, errorThrown) {
                            $.LoadingOverlay("hide");
                            Swal.fire({
                                title: "Error",
                                text: errorThrown,
                                icon: "warning"
                            });

                        }
                    });
                } else {
                    $('#studentlist').html('')
                }
                $.LoadingOverlay("hide");
            });
            $(document.body).on('change', '#attendance_date', function() {
                Swal.fire({
                    title: "Warning!",
                    text: "You can't update present or future attendance",
                    icon: "warning"
                });
                $('#attendance_date').val('{{ date('Y-m-d') }}');
                return true;
                var attendance_date = $('#attendance_date').val();
                var class_id = $('#class_id').val();
                var session_id = $('#session_id').val();
                var shift_id = $('#shift_id').val();
                var version_id = $('#version_id').val();
                $.LoadingOverlay("show");
                var section_id = $('#section_id').val();
                if (section_id && attendance_date && version_id && shift_id && session_id && class_id) {
                    var url = "{{ route('getStudents') }}";
                    $.ajax({
                        type: "get",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: url,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            session_id,
                            shift_id,
                            class_id,
                            section_id,
                            version_id,
                            attendance_date
                        },
                        success: function(response) {
                            $.LoadingOverlay("hide");
                            $('#studentlist').html(response)


                        },
                        error: function(data, errorThrown) {
                            $.LoadingOverlay("hide");
                            Swal.fire({
                                title: "Error",
                                text: errorThrown,
                                icon: "warning"
                            });

                        }
                    });
                } else {
                    $('#studentlist').html('')
                }
                $.LoadingOverlay("hide");
            });
            $(document).on('click', '#submit', function() {
                updateCounts();
            });
            // Submit the form when Confirm button is clicked
            $("#confirmSubmit").on("click", function(event) {
                event.preventDefault();
                $('#attendanceModal').modal('hide');
                $('#submit').hide();
                var form = $('#formsubmit')[0];
                var formData = new FormData(form);
                var url = "{{ route('studentAttendanceStore') }}";

                $.LoadingOverlay("show");

                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        handleSuccess(response);
                        $('input.form-check-input').addClass('attendance');
                        $('input[type="time"]').each(function() {
                            $(this).addClass('attendance-time');
                        });
                        $('#submit').hide();
                        $('#all').hide();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errorMessage = xhr.responseJSON?.error || "Validation error.";
                            Swal.fire({
                                title: "Warning",
                                text: errorMessage,
                                icon: "warning"
                            });
                        } else {
                            handleError(xhr);
                        }
                    },
                    complete: function() {
                        $.LoadingOverlay("hide");
                    }
                });
            });
        });
        // Handle different time for different classes depending on
        function getLateTimeThreshold() {
            // Define late time thresholds
            const lateTimeThresholds = {
                "1_1": "07:30:00", // Default for version_id=1, shift_id=1
                "1_2": "12:30:00", // Default for version_id=1, shift_id=2
                "2_1": "07:30:00", // Default for version_id=2, shift_id=1
                "2_2": "12:30:00", // Default for version_id=2, shift_id=2
            };
            // Get the values of the hidden fields
            const versionId = $('#version_id').val();
            const shiftId = $('#shift_id').val();
            const classId = $('#class_id').val();
            // Generate the key to match in the late time thresholds
            const key = `${versionId}_${shiftId}`;
            let lateTime = lateTimeThresholds[key] || "08:00:00";

            // Dynamically adjust late time for specific class_id if needed
            if (classId === "11" || classId === "12") {
                lateTime = "08:00:00";
            }
            // else if (classId === "0") {
            //     lateTime = "07:30:00";
            // }

            return lateTime;
        }

        function updateCounts() {

            let class_id = $('#class_id').val();
            let presentCount = 0;
            let absentCount = 0;
            let missingCount = 0;
            let leaveCount = 0;
            let lateCount = 0;
            let totalCount = -1;

            const lateTime = getLateTimeThreshold();

            // alert('Late time' + lateTime);

            // Iterate over each student row
            $('.main tr').each(function() {

                const selectedRadio = $(this).find('input[type="radio"]:checked');
                const timeValue = $(this).find('input[type="time"]').val();

                // If a radio button is selected (present, absent, leave, missing, late)
                if (selectedRadio.length > 0) {
                    const value = selectedRadio.val();
                    if (value === "1") {
                        presentCount++;
                        if (timeValue && timeValue > lateTime) { // Check if time exceeds late time
                            lateCount++;
                            presentCount--;
                        }
                    } else if (value === "2") {
                        absentCount++;
                    } else if (value === "5") {
                        missingCount++;
                    } else if (value === "3") {
                        leaveCount++;
                    }
                }
                totalCount++; //
            });

            // Update the modal counts
            $("#presentCount").text(presentCount);
            $("#absentCount").text(absentCount);
            $("#leaveCount").text(leaveCount);
            $("#missingCount").text(missingCount);
            $("#lateCount").text(lateCount);
            $("#totalCount").text(totalCount);
        }

        function showstudent() {
            var attendance_date = $('#attendance_date').val();
            var class_id = $('#class_id').val();
            var session_id = $('#session_id').val();
            var shift_id = $('input[name="shift_id"]:checked').val();
            var version_id = $('input[name="version_id"]:checked').val();
            $.LoadingOverlay("show");
            var section_id = $('#section_id').val();
            if (section_id && attendance_date && version_id && shift_id && session_id && class_id) {
                var url = "{{ route('getStudents') }}";
                $.ajax({
                    type: "get",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        session_id,
                        shift_id,
                        class_id,
                        section_id,
                        version_id,
                        attendance_date
                    },
                    success: function(response) {
                        $.LoadingOverlay("hide");
                        $('#studentlist').html(response)


                    },
                    error: function(data, errorThrown) {
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            title: "Error",
                            text: errorThrown,
                            icon: "warning"
                        });

                    }
                });
            } else {
                $('#studentlist').html('')
            }
            $.LoadingOverlay("hdie");
        }

        // Function to get student data from the form
        function handleSuccess(response) {
            Swal.fire({
                title: "Success",
                text: response.success,
                icon: "success"
            });
        }

        function handleError(xhr) {
            const errorMessage = xhr.responseJSON?.message || "An error occurred.";
            Swal.fire({
                title: "Error",
                text: errorMessage,
                icon: "warning"
            });
        }
    </script>
@endsection
