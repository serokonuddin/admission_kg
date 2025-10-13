@extends('admin.layouts.layout')
@section('content')
    <style>
        .control {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
            position: relative;
            cursor: pointer;
        }

        th.control:before,
        td.control:before {
            background-color: #696cff;
            border: 2px solid #fff;
            box-shadow: 0 0 3px rgba(67, 89, 113, .8);
        }

        td.control:before,
        th.control:before {
            top: 50%;
            left: 50%;
            height: 0.8em;
            width: 0.8em;
            margin-top: -0.5em;
            margin-left: -0.5em;
            display: block;
            position: absolute;
            color: white;
            border: 0.15em solid white;
            border-radius: 1em;
            box-shadow: 0 0 0.2em #444;
            box-sizing: content-box;
            text-align: center;
            text-indent: 0 !important;
            font-family: "Courier New", Courier, monospace;
            line-height: 1em;
            content: "+";
            background-color: #0d6efd;
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

        .p-10 {
            padding: 10px !important;
        }

        .m-r-10 {
            margin-right: 10px !important;
        }

        .childdata {
            display: none;
            background-color: #98fded;
        }

        .btn {
            font-size: 13px !important;

        }

        .form-label {
            width: 100% !important;
        }

        .not-saved {
            color: red;
            font-weight: bold;
        }

        .saved {
            color: green;
            font-weight: bold;
        }

        .completed {
            color: blue;
            font-weight: bold;
        }

        .na {
            color: gray;
            font-weight: bold;
        }
    </style>

    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"> Students Admission List</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('CollegeAdmisionByTeacher') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="0" />
                                <div class="row g-3">
                                    <!-- Session -->
                                    <div class="col-md-4">
                                        <label for="version_id" class="form-label">Version<span
                                                class="text-danger ps-1">*</span></label>
                                        <select id="version_id" name="version_id" class="form-select" required>
                                            <option value="">Select Version</option>
                                            @foreach ($versions as $version)
                                                <option value="{{ $version->id }}"
                                                    {{ $version_id == $version->id ? 'selected' : '' }}>
                                                    {{ $version->version_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4" id="shift_div">
                                        <label for="shift_id" class="form-label">Shift<span
                                                class="text-danger ps-1">*</span></label>
                                        <select id="shift_id" name="shift_id" class="form-select" required>
                                            <option value="">Select Shift</option>

                                            <option value="1" {{ $shift_id == 1 ? 'selected' : '' }}>
                                                Morning
                                            </option>

                                            <option value="2" {{ $shift_id == 2 ? 'selected' : '' }}>
                                                Day
                                            </option>

                                        </select>
                                    </div>
                                    <div class="col-md-4" style="display: none;">
                                        <label for="class_code" class="form-label">Class</label>
                                        <select id="class_code" name="class_code" class="form-select" required>
                                         
                                            <option value="0"
                                                {{ isset($admission) && $admission->class_id == 0 ? 'selected="selected"' : '' }}>
                                                KG</option>
                                            

                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="section_id" class="form-label">Section</label>
                                        <select id="section_id" name="section_id" class="form-select" required>
                                            <option value="">Select Section</option>

                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="session_id" class="form-label">Session</label>
                                        <select id="session_id" name="session_id" class="form-select" required>
                                            <option value="">Select Session</option>
                                            @foreach ($sessions as $session)
                                                <option value="{{ $session->id }}"
                                                    {{ $session_id == $session->id ? 'selected' : '' }}>
                                                    {{ $session->college_session }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Version -->

                                    <!-- Group -->
                                    <div class="col-md-4" id="group_div">
                                        <label for="group_id" class="form-label">Group<span
                                                class="text-danger ps-1">*</span></label>
                                        <select id="group_id" name="group_id" class="form-select" required>
                                            <option value="0">Select Group</option>
                                            @foreach ($groups as $group)
                                                <option value="{{ $group->id }}"
                                                    {{ $group_id == $group->id ? 'selected' : '' }}>
                                                    {{ $group->group_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Class Roll -->
                                    <div class="col-md-4">
                                        <label for="student_code" class="form-label">Class Roll<span
                                                class="text-danger ps-1">*</span></label>
                                        <input type="number" id="student_code" name="student_code" class="form-control"
                                            value="{{ old('student_code') }}" placeholder="Class Roll" required>
                                    </div>

                                    <!-- Student Name -->
                                    <div class="col-md-4">
                                        <label for="first_name" class="form-label">Student Name<span
                                                class="text-danger ps-1">*</span></label>
                                        <input type="text" id="first_name" name="first_name" class="form-control"
                                            value="{{ old('first_name') }}" placeholder="Student Name" required>
                                    </div>

                                    <!-- House -->
                                    <div class="col-md-4">
                                        <label for="house_id" class="form-label">Select House<span
                                                class="text-danger ps-1">*</span></label>
                                        <select id="house_id" name="house_id" class="form-select" required>
                                            <option value="">Select House</option>
                                            @foreach ($houses as $house)
                                                <option value="{{ $house->id }}"
                                                    {{ $house_id == $house->id ? 'selected' : '' }}>
                                                    {{ $house->house_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Contact Number -->
                                    <div class="col-md-4">
                                        <label for="mobile" class="form-label">Contact Number <span
                                                class="text-danger ps-1">*</span></label>
                                        <input type="number" id="mobile" name="mobile" class="form-control"
                                            value="{{ old('mobile') }}" placeholder="Contact Number" required>
                                    </div>

                                    <!-- S.S.C Roll -->
                                    <div class="col-md-4" id="ssc_div">
                                        <label for="roll_number" class="form-label">S.S.C Roll<span
                                                class="text-danger ps-1">*</span></label>
                                        <input type="number" id="roll_number" name="roll_number" class="form-control"
                                            value="{{ old('roll_number') }}" placeholder="S.S.C Roll">
                                    </div>

                                    <!-- Division -->
                                    <div class="col-md-4" id="division_div">
                                        <label for="division_id" class="form-label">Division<span
                                                class="text-danger ps-1">*</span></label>
                                        <select id="division_id" name="division_id" class="form-select">
                                            <option value="">Select Option</option>
                                            @foreach ($divisions as $key => $division)
                                                <option value="{{ $key }}"
                                                    {{ $division_id == $key ? 'selected' : '' }}>
                                                    {{ $division }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Gender -->
                                    <div class="col-md-4">
                                        <label for="gender" class="from-label">Gender<span
                                                class="text-danger ps-1">*</span></label>
                                        <select id="gender" name="gender" class="form-select">
                                            <option value="">Select Gender</option>
                                            <option value="1">Male</option>
                                            <option value="2">Female</option>
                                        </select>
                                    </div>


                                    <!-- Father Name -->
                                    <div class="col-md-4">
                                        <label for="father_name" class="form-label">Father Name<span
                                                class="text-danger ps-1">*</span></label>
                                        <input type="text" id="father_name" name="father_name" class="form-control"
                                            value="{{ old('father_name') }}" placeholder="Father Name" required>
                                    </div>


                                    <!-- User Name -->
                                    {{-- <div class="col-md-4 d-flex align-items-end">
                                        <div class="flex-grow-1 me-3">
                                            <label for="username" class="form-label">User Name<span
                                                    class="text-danger ps-1">*</span></label>
                                            <input type="text" id="username" name="username" class="form-control"
                                                value="{{ old('username') }}" placeholder="User Name" required>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-12 d-flex justify-content-end align-items-end">
                                        @if (Auth::user()->is_view_user == 0)
                                            <div>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table" id="headerTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>ID</th>
                                        <th>Student Name</th>
                                        <th>Mobile</th>
                                        <th>Version</th>
                                        <th>Shift</th>
                                        <th>section</th>
                                        <th>Roll</th>
                                        <th>Application Status</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($students as $student)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $student->student_code }}</td>
                                            <td>{{ $student->first_name }}</td>
                                            <td>{{ $student->mobile }}</td>
                                            <td>{{ $student->version_name }}</td>
                                            <td>{{ $student->shift_name }}</td>
                                            <td>{{ $student->section_name }}</td>
                                            <td>{{ $student->roll }}</td>
                                            <td class="text-center">

                                                @if (isset($student->submit))
                                                    @switch((int)$student->submit)
                                                        @case(0)
                                                            <button class="btn btn-danger btn-sm rounded-1">Not Saved</button>
                                                        @break

                                                        @case(1)
                                                            <button class="btn btn-primary btn-sm rounded-1">Saved</button>
                                                        @break

                                                        @case(2)
                                                            <button class="btn btn-success btn-sm rounded-1">Completed</button>
                                                        @break

                                                        @default
                                                            <button class="btn btn-warning btn-sm rounded-1">NA</button>
                                                    @endswitch
                                                @else
                                                    <button class="btn btn-warning btn-sm rounded-1">NA</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_3_paginate"
                                style="padding: 10px">

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-backdrop fade"></div>
    </div>
    <script>
        @if (Session::has('success'))
            Swal.fire({
                title: "Good job!",
                text: "{{ Session::get('success') }}",
                icon: "success",
                confirmButtonText: "OK"
            });
        @endif

        @if (Session::has('warning'))
            Swal.fire({
                title: "Warning!",
                text: "{{ Session::get('warning') }}",
                icon: "warning",
                confirmButtonText: "OK"
            });
        @endif

        @if (Session::has('error'))
            Swal.fire({
                title: "Error!",
                text: "{{ Session::get('error') }}",
                icon: "error",
                confirmButtonText: "OK"
            });
        @endif
        $(document).on('change', '#version_id', function() {

            if ($('#class_code').val() >= 11) {
                $('#session_id').val({{ date('Y') - 1 }});
                session_id = {{ date('Y') - 1 }};
            } else if ($('#class_code').val() >= 9 && $('#class_code').val() <= 10) {
                $('#session_id').val({{ date('Y') }});
                session_id = {{ date('Y') }};
            } else {
                $('#session_id').val({{ date('Y') }});
                session_id = {{ date('Y') }};
            }

            var class_code = $('#class_code').val();
            var shift_id = $('#shift_id').val();
            var version_id = $('#version_id').val();
            var url = "{{ route('class-wise-sections') }}";
            $.LoadingOverlay("show");
            $.ajax({
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                },
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}",
                    class_id: class_code,
                    shift_id,
                    version_id

                },
                success: function(response) {
                    $.LoadingOverlay("hide");
                    $('#section_id').html(response);


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
            if (shift_id && version_id) {
                var url1 = "{{ route('getLastRollAdmission') }}";
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url1,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        class_id: class_code,
                        shift_id,
                        version_id,
                        session_id
                    },
                    success: function(response) {
                        $.LoadingOverlay("hide");
                        $('#student_code').val(response);
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
            }

        });
        $(document).on('change', '#shift_id', function() {
            var session_id = 0;
            if ($('#class_code').val() >= 11) {
                $('#session_id').val({{ date('Y') - 1 }});
                session_id = {{ date('Y') - 1 }};
            } else if ($('#class_code').val() >= 9 && $('#class_code').val() <= 10) {
                $('#session_id').val({{ date('Y') }});
                session_id = {{ date('Y') }};
            } else {
                $('#session_id').val({{ date('Y') }});
                session_id = {{ date('Y') }};
            }

            var class_code = $('#class_code').val();
            var shift_id = $('#shift_id').val();
            var version_id = $('#version_id').val();
            var url = "{{ route('class-wise-sections') }}";
            $.LoadingOverlay("show");
            $.ajax({
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                },
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}",
                    class_id: class_code,
                    shift_id,
                    version_id

                },
                success: function(response) {
                    $.LoadingOverlay("hide");
                    $('#section_id').html(response);


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
            if (shift_id && version_id) {
                var url1 = "{{ route('getLastRollAdmission') }}";
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url1,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        class_id: class_code,
                        shift_id,
                        version_id,
                        session_id
                    },
                    success: function(response) {
                        $.LoadingOverlay("hide");
                        $('#student_code').val(response);


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
            }

        });

        $(document).on('change', '#class_code', function() {

            var options = '<option value="">Select Session</option>';

            @foreach ($sessions as $session)
                if ($('#class_code').val() >= 11) {
                    $('#shit_id').val(1);

                    $('#shit_div').hide();

                    $('#group_id').val(0);
                    $('#division_div').show();
                    $('#ssc_div').show();
                    $('#group_div').show();
                    options += '<option value="{{ $session->id }}" >{{ $session->college_session }}</option>';
                } else if ($('#class_code').val() >= 9 && $('#class_code').val() <= 10) {

                    $('#group_id').val(0);
                    $('#division_div').hide();
                    $('#ssc_div').hide();
                    $('#group_div').show();

                    $('#shit_id').val(0);
                    $('#shit_div').show();
                    options += '<option value="{{ $session->id }}" >{{ $session->session_name }}</option>';
                } else {
                    $('#group_id').val(0);

                    $('#division_div').hide();
                    $('#ssc_div').hide();
                    $('#group_div').hide();
                    $('#shit_id').val(0);
                    $('#shit_div').show();
                    options += '<option value="{{ $session->id }}" >{{ $session->session_name }}</option>';
                }
            @endforeach

            $('#session_id').html(options);

            var session_id = 0;
            if ($('#class_code').val() >= 11) {
                $('#session_id').val({{ date('Y') - 1 }});
                session_id = {{ date('Y') - 1 }};
            } else if ($('#class_code').val() >= 9 && $('#class_code').val() <= 10) {
                $('#session_id').val({{ date('Y') }});
                session_id = {{ date('Y') }};
            } else {
                $('#session_id').val({{ date('Y') }});
                session_id = {{ date('Y') }};
            }

            var class_code = $('#class_code').val();
            var shift_id = $('#shift_id').val();
            var version_id = $('#version_id').val();
            var url = "{{ route('class-wise-sections') }}";
            $.LoadingOverlay("show");
            $.ajax({
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                },
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}",
                    class_id: class_code,
                    shift_id,
                    version_id

                },
                success: function(response) {
                    $.LoadingOverlay("hide");
                    $('#section_id').html(response);


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
            if (shift_id && version_id) {
                var url1 = "{{ route('getLastRollAdmission') }}";
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url1,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        class_id: class_code,
                        shift_id,
                        version_id,
                        session_id
                    },
                    success: function(response) {
                        $.LoadingOverlay("hide");
                        $('#student_code').val(response);


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
            }
        });
        $(document.body).on('change', '#username', function() {

            var username = $('#username').val();
            username = username.replace(/\s/g, '');



            var url = "{{ route('usernamecheck') }}";
            if (username.length > 0) {
                $.LoadingOverlay("show");
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        username
                    },
                    success: function(response) {

                        $.LoadingOverlay("hide");
                        if (response == 1) {
                            $('#username').val('');
                            Swal.fire({
                                title: "Error",
                                text: 'Username Already Exist.',
                                icon: "warning"
                            });
                        } else {
                            $('#username').val(username);
                        }

                    },
                    error: function(data, errorThrown) {
                        $.LoadingOverlay("hide");
                        $('#username').val('');
                        Swal.fire({
                            title: "Error",
                            text: errorThrown,
                            icon: "warning"
                        });

                    }
                });
            }
        });
    </script>
@endsection
