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

        .text-white td {
            color: white !important;
            font-weight: bold;
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
    </style>
    <link rel="stylesheet" href="{{ asset('public/backend') }}/assets/vendor/libs/flatpickr/flatpickr.css" />
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y" id="attendance-part">
            {{-- <h4 class="py-3 mb-4"><span class="text-muted fw-light">Attendance /</span> Student Attendance Report</h4> --}}
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"> Students Attendance Report</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-md-12">
                    <form class="needs-validation" method="post" action="#" novalidate="" id="formsubmit">
                        @csrf
                        <input type="hidden" id="type" name="type" value="{{ Session::get('employee_for') }}">
                        <input type="hidden" id="session_id" name="session_id" value="{{ Session::get('session_id') }}">
                        <input type="hidden" id="section_id" name="section_id" value="{{ Session::get('section_id') }}">
                        <input type="hidden" id="version_id" name="version_id" value="{{ Session::get('version_id') }}">
                        <input type="hidden" id="shift_id" name="shift_id" value="{{ Session::get('shift_id') }}">
                        <input type="hidden" id="class_id" name="class_id" value="{{ Session::get('class_id') }}">

                        <div class="card mb-4">
                            <div class="card-header">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered rounded-lg mt-2 mb-2 statistics">
                                        <thead class="table-info">
                                            <tr>
                                                <th style="width: 12%;text-align:center;font-weight:bold;">
                                                    Class
                                                </th>
                                                <th style="width: 13%;text-align:center;font-weight:bold;">
                                                    Section</th>
                                                <th style="width: 13%;text-align:center;font-weight:bold;">
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
                                                    <input type="text"
                                                        class="form-control flatpickr-validation flatpickr-input"
                                                        id="attendance_date" name="attendance_date"
                                                        value="{{ Session::get('attendance_date') ? Session::get('attendance_date') : date('Y-m-d') }}"
                                                        placeholder="Attendance Date" required>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="table-responsive">
                                    <table
                                        class="table table-hover table-sm table-md table-bordered rounded-lg mt-2 statistics-main">
                                        <thead class="table-light" style="position: sticky; top: 0; z-index: 1000;">
                                            <tr>
                                                <th
                                                    style="width: 20%;text-align:center; color:rgb(31, 212, 40);font-weight:bold;">
                                                    Present</th>
                                                <th
                                                    style="width: 20%;text-align:center;color:rgb(191, 5, 5);font-weight:bold;">
                                                    Absent</th>
                                                <th
                                                    style="width: 13%;text-align:center;color:rgb(11, 177, 228);font-weight:bold;">
                                                    Late</th>
                                                <th
                                                    style="width: 12%;text-align:center;color:  rgb(211, 226, 6);font-weight:bold;">
                                                    Leave</th>
                                                <th
                                                    style="width: 13%;text-align:center;color: rgb(19, 78, 187);font-weight:bold;">
                                                    Missing</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            <tr>
                                                <td style="text-align:center;font-weight:bold;">
                                                    {{ $data['present'] ?? '' }}
                                                </td>
                                                <td style="text-align:center;font-weight:bold;">
                                                    {{ $data['absent'] ?? '' }}
                                                </td>
                                                <td style="text-align:center;font-weight:bold;">
                                                    {{ $data['late'] ?? '' }}
                                                </td>
                                                <td style="text-align:center;font-weight:bold;">
                                                    {{ $data['leave'] ?? '' }}
                                                </td>
                                                <td style="text-align:center;font-weight:bold;">
                                                    {{ $data['missing'] ?? '' }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive scrollable rounded" id="studentlist">
                                    <table class="table table-hover rounded-lg main">
                                        <thead class="table-dark" style="position: sticky; top: 0; z-index: 1000;">
                                            <tr>
                                                <th>SL</th>
                                                <th style="width: 20%;word-wrap: break-word;">Student Name</th>
                                                <th style="width: 10%">Roll</th>
                                                <th style="width: 13%">Session</th>
                                                <th style="width: 12%">Version</th>
                                                <th style="width: 10%">Mobile</th>
                                                <th style="width: 12%">Father</th>
                                                <th style="width: 13%">Mother</th>
                                                <th style="width: 10%">Status</th>
                                                <th style="width: 10%">Time</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            @foreach ($students as $student)
                                                {{-- @dd($student) --}}
                                                @php
                                                    if (
                                                        isset($student->studentAttendance->status) &&
                                                        $student->studentAttendance->status == 1
                                                    ) {
                                                        $bg = 'bg-default';
                                                    } elseif (
                                                        isset($student->studentAttendance->status) &&
                                                        $student->studentAttendance->status == 4
                                                    ) {
                                                        $bg = 'bg-warning text-white';
                                                    } elseif (
                                                        isset($student->studentAttendance->status) &&
                                                        $student->studentAttendance->status == 2
                                                    ) {
                                                        $bg = 'bg-danger text-white';
                                                    } elseif (
                                                        isset($student->studentAttendance->status) &&
                                                        $student->studentAttendance->status == 3
                                                    ) {
                                                        $bg = 'bg-success text-white';
                                                    } elseif (
                                                        isset($student->studentAttendance->status) &&
                                                        $student->studentAttendance->status == 5
                                                    ) {
                                                        $bg = 'bg-primary text-white';
                                                    } else {
                                                        $bg = 'bg-default';
                                                    }
                                                @endphp
                                                <tr class="{{ $bg }}">
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td style="word-wrap: break-word;">
                                                        <img src="{{ $student->photo ?? asset('public/student.png') }}"
                                                            alt="Avatar" class="rounded-circle avatar avatar-xs">

                                                        {{ $student->first_name . ' ' . $student->last_name }}
                                                    </td>
                                                    <td>{{ $student->roll ?? 'N/A' }}</td>
                                                    <td>
                                                        {{ $student->session_name ?? 'N/A' }}
                                                    </td>
                                                    <td>
                                                        {{ $student->version_name ?? 'N/A' }}
                                                    </td>
                                                    <td>
                                                        {{ $student->sms_notification ?? 'N/A' }}
                                                    </td>
                                                    <td>
                                                        {{ $student->father_name ?? 'N/A' }}
                                                        <br>
                                                        {{ $student->father_phone ?? 'N/A' }}
                                                    </td>
                                                    <td>
                                                        {{ $student->mother_name ?? 'N/A' }}
                                                        <br>
                                                        {{ $student->mother_phone ?? 'N/A' }}
                                                    </td>
                                                    <td>
                                                        @if (isset($student->studentAttendance->status) && $student->studentAttendance->status == 1)
                                                            Present
                                                        @elseif(isset($student->studentAttendance->status) && $student->studentAttendance->status == 4)
                                                            Late
                                                        @elseif(isset($student->studentAttendance->status) && $student->studentAttendance->status == 2)
                                                            Absent
                                                        @elseif(isset($student->studentAttendance->status) && $student->studentAttendance->status == 3)
                                                            Leave
                                                        @elseif (isset($student->studentAttendance->status) && $student->studentAttendance->status == 5)
                                                            Missing
                                                        @endif

                                                    </td>
                                                    <td style="word-wrap: break-word;">
                                                        {{ isset($student->studentAttendance->time) ? $student->studentAttendance->time : '' }}
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- / Content -->
        <div class="content-backdrop fade"></div>
    </div>
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

        $(function() {
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

                    },
                    error: function(data, errorThrown) {
                        handleError(data, errorThrown);
                    },
                    complete: function() {
                        $.LoadingOverlay("hide");
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
                    },
                    error: function(data, errorThrown) {
                        handleError(data, errorThrown);
                    },
                    complete: function() {
                        $.LoadingOverlay("hide");
                    }
                });
                $('.type' + ' a').removeClass('active');
                $('.' + type + ' a').addClass('active');
            });

            $(document.body).on('change', 'input[type=radio][name=shift_id]', function() {

                var type = $('#type').val();
                var shift_id = $('input[name="shift_id"]:checked').val();
                var version_id = $('input[name="version_id"]:checked').val();
                var id = $(this).val();
                var url = "{{ route('getTypeWiseClass') }}";
                $.LoadingOverlay("show");
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
                    },
                    error: function(data, errorThrown) {
                        handleError(data, errorThrown);
                    },
                    complete: function() {
                        $.LoadingOverlay("hide");
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
                        $('#section_id').html(response);
                        $('#studentlist').html('');

                    },
                    error: function(data, errorThrown) {
                        handleError(data, errorThrown);

                    },
                    complete: function() {
                        $.LoadingOverlay("hide");
                    }
                });
            });
            $(document.body).on('change', '#section_id', function() {

                var attendance_date = $('#attendance_date').val();
                var class_id = $('#class_id').val();
                var session_id = $('#session_id').val();
                var shift_id = $('input[name="shift_id"]:checked').val();
                var version_id = $('input[name="version_id"]:checked').val();
                var section_id = $('#section_id').val();
                if (section_id && attendance_date && version_id && shift_id && session_id && class_id) {
                    var url = "{{ route('getStudents') }}";
                    $.LoadingOverlay("show");
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
                            $('#studentlist').html(response)
                        },
                        error: function(data, errorThrown) {
                            handleError(data, errorThrown);
                        },
                        complete: function() {
                            $.LoadingOverlay("hide");
                        }
                    });
                } else {
                    $('#studentlist').html('')
                    $.LoadingOverlay("hide");
                }
            });
            $(document.body).on('change', '#attendance_date', function() {

                var attendance_date = $('#attendance_date').val();
                var class_id = $('#class_id').val();
                var session_id = $('#session_id').val();
                var shift_id = $('#shift_id').val();
                var version_id = $('#version_id').val();

                var section_id = $('#section_id').val();

                if (section_id && attendance_date && version_id && shift_id && session_id && class_id) {
                    var url = "{{ route('getStudentsAttendanceStatusWithDate') }}";
                    $.LoadingOverlay("show");
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
                            $('#studentlist').html(response);
                            $('.statistics-main').hide();
                        },
                        error: function(data, errorThrown) {
                            handleError(data, errorThrown);
                        },
                        complete: function() {
                            $.LoadingOverlay("hide");
                        }

                    });
                } else {
                    $('#studentlist').html('')
                    $.LoadingOverlay("hide");
                }
            });
        });

        function handleSuccess(response) {
            Swal.fire({
                title: "Good job!",
                text: "Data Successfully Fetched.",
                icon: "success"
            });
        }

        function handleError(data, xhr) {
            const errorMessage = data?.responseJSON?.message || 'An error occurred';
            Swal.fire({
                title: "Error",
                text: errorMessage,
                icon: "warning"
            });
        }

        function showstudent() {
            var attendance_date = $('#attendance_date').val();
            var class_id = $('#class_id').val();
            var session_id = $('#session_id').val();
            var shift_id = $('input[name="shift_id"]:checked').val();
            var version_id = $('input[name="version_id"]:checked').val();
            var section_id = $('#section_id').val();
            if (section_id && attendance_date && version_id && shift_id && session_id && class_id) {
                var url = "{{ route('getStudents') }}";
                $.LoadingOverlay("show");
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
                        $('#studentlist').html(response)
                    },
                    error: function(data, errorThrown) {
                        handleError(data, errorThrown);
                    },
                    complete: function() {
                        $.LoadingOverlay("hide");
                    }
                });
            } else {
                $('#studentlist').html('')
                $.LoadingOverlay("hdie");
            }

        }
    </script>
@endsection
