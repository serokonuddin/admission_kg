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

        /* General container for select2 */
        .select2-container {
            width: 100% !important;
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            background-color: #ffffff;
            border: 1px solid #ced4da;
            z-index: 9999 !important;
        }

        /* Style for the selection box */
        .select2-container--default .select2-selection--single {
            border: 1px solid #ced4da;
            padding: 0.5rem 1rem;
            font-size: 1rem;
            color: #495057;
            border-radius: 0.5rem;
            transition: all 0.3s ease-in-out;
            cursor: pointer;
            background-color: #f8f9fa;
        }

        /* Focus and hover effects for the selection box */
        .select2-container--default .select2-selection--single:focus,
        .select2-container--default .select2-selection--single:hover {
            border-color: #80bdff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.25);
            background-color: #ffffff;
            outline: none;
        }

        /* Style for the placeholder text */
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            font-size: 1rem;
            color: #6c757d;
            font-weight: 400;
            padding-right: 1rem;
        }

        /* Style for the dropdown arrow */
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 50%;
            transform: translateY(-50%);
            right: 0.75rem;
            color: #6c757d;
            transition: color 0.3s ease;
        }

        .select2-container--default .select2-selection--single:hover .select2-selection__arrow {
            color: #495057;
        }

        /* Dropdown menu styles */
        .select2-dropdown {
            border: 1px solid #ced4da;
            border-radius: 0.5rem;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            background-color: #ffffff;
            z-index: 9999 !important;
        }

        /* Options in the dropdown menu */
        .select2-results__option {
            padding: 0.75rem 1rem;
            font-size: 1rem;
            color: #495057;
            cursor: pointer;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        /* Highlighted option (on hover or keyboard navigation) */
        .select2-results__option--highlighted {
            background-color: #007bff;
            color: #ffffff;
        }

        /* Selected option style */
        .select2-results__option[aria-selected="true"] {
            background-color: #0056b3;
            color: #ffffff;
            font-weight: 600;
        }

        /* Responsive adjustments for small screens */
        @media (max-width: 768px) {
            .select2-container--default .select2-selection--single {
                font-size: 0.9rem;
                padding: 0.5rem;
            }

            .select2-results__option {
                font-size: 0.9rem;
                padding: 0.5rem;
            }
        }
    </style>
    <script type="text/javascript" src="{{ asset('backend/js/index.global.min.js') }}"></script>
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y" id="attendance-part">
            {{-- <h4 class="py-3 mb-4"><span class="text-muted fw-light">Academy /</span> Routine</h4> --}}
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"> Students</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-md-12 card">
                    <!-- <form class="needs-validation" method="post" action="#"  novalidate="" id="formsubmit"> -->
                    <div class="mb-4">
                        <div class="card-header">
                            <input type="hidden" id="type" name="type" value="3">
                            @if (Auth::user()->is_view_user == 0)
                                <button class=" btn btn-info btn-toggle-sidebar text-white mb-3" data-bs-toggle="offcanvas"
                                    data-bs-target="#addEventSidebar" aria-controls="addEventSidebar"
                                    href="javascript:void(0);">Add Routine</button>
                            @endif
                            <form method="post" action="{{ route('routineXlUpload') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row gy-3">
                                    <div class="mb-3 col-md-4">
                                        <label for="formFile" class="form-label">Xl File (Allowed formats: XLSX, XLS, CSV.
                                            Max file size: 200 KB)</label>
                                        <input class="form-control" type="file" name="file" id="formFile"
                                            accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">

                                    </div>
                                    @if (Auth::user()->is_view_user == 0)
                                        <div class="mb-3 col-md-2">
                                            <br />
                                            <button type="submit" class="btn btn-primary me-2 mt-1">Upload XL</button>
                                        </div>
                                    @endif
                                </div>
                            </form>
                            <div class="row gy-3">
                                <div class="col-6">
                                    <div class="form-check form-check-inline mt-3">
                                        <input class="form-check-input" type="radio" name="version_id" id="bangla"
                                            value="1">
                                        <label class="form-check-label" for="bangla">Bangla</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="version_id" id="english"
                                            value="2">
                                        <label class="form-check-label" for="english">English</label>
                                    </div>
                                    <div class="form-check form-check-inline mt-3">
                                        <input class="form-check-input" type="radio" name="shift_id" id="Morning"
                                            value="1">
                                        <label class="form-check-label" for="Morning">Morning</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="shift_id" id="Day"
                                            value="2">
                                        <label class="form-check-label" for="Day">Day</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <ul
                                        class="nav nav-pills flex-column
                                    flex-md-row mb-3">
                                        <li class="nav-item type college" data-type="college">
                                            <a class="nav-link active" href="javascript:void(0);"><img
                                                    src="{{ asset('public/image/college.png') }}"> College</a>
                                        </li>
                                        <li class="nav-item secondary type" data-type="secondary">
                                            <a class="nav-link " href="javascript:void(0);"><img
                                                    src="{{ asset('public/image/secondary.png') }}"> Secondary</a>
                                        <li class="nav-item primary type" data-type="primary">
                                            <a class="nav-link " href="javascript:void(0);"><img
                                                    src="{{ asset('public/image/primary.png') }}"> Primary</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mb-2 col-md-3">
                                    <label class="form-label" for="country">Class</label>
                                    <select id="session_id" name="session_id" class=" form-select" required>
                                        <option value="">Select Class</option>
                                        @foreach ($sessions as $s)
                                            <option value="{{ $s->id }}"
                                                {{ $s->session_name == date('Y') ? 'selected="selected"' : '' }}>
                                                {{ $s->session_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-2 col-md-3">
                                    <label class="form-label" for="country">Class</label>
                                    <select id="class_id_search" name="class_id_search" class=" form-select" required>
                                        <option value="">Select Class</option>

                                    </select>
                                </div>
                                <div class="mb-2 col-md-3">
                                    <label class="form-label" for="section">Section</label>
                                    <select id="section_id_search" name="section_id_search" class=" form-select">
                                        <option value="">Select Section</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- /Account -->
                        <div class="card-body">
                            <div class="table-responsive " id="routinelist">

                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <div class="offcanvas offcanvas-end event-sidebar" tabindex="-1" id="addEventSidebar"
                aria-labelledby="addEventSidebarLabel">
                <div class="offcanvas-header border-bottom">
                    <h5 class="offcanvas-title mb-2" id="addEventSidebarLabel">Routine</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <form class="event-form pt-0 fv-plugins-bootstrap5 fv-plugins-framework"
                        action="{{ route('routine.store') }}" method="post" id="eventForm">
                        @csrf
                        <input type="hidden" name="id" id="id" value="0" />
                        <div class="mb-3">
                            <label class="form-label" for="eventLabel">Routine For</label>
                            <div class="position-relative">
                                <select class="select select-event-label form-select " id="type_for" name="type_for">
                                    <option value="">Select Routine</option>

                                    <option value="primary">Primary</option>
                                    <option value="secondary">Secondary</option>
                                    <option value="college">College</option>
                                </select>
                            </div>
                        </div>
                        {{-- {{$days}} --}}
                        <div class="mb-3">
                            <label class="form-label" for="eventLabel">Session</label>
                            <div class="position-relative">
                                <select class="select select-event-label form-select " id="session_id" name="session_id">
                                    <option value="">Select Session</option>
                                    @foreach ($sessiondata as $s)
                                        <option value="{{ $s->id }}"
                                            {{ $s->session_name == date('Y') ? 'selected="selected"' : '' }}>
                                            {{ $s->session_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="eventLabel">Version</label>
                            <div class="position-relative">
                                <select class="select select-event-label form-select " id="version_id" name="version_id">
                                    <option value="">Select Version</option>
                                    @foreach ($versions as $version)
                                        <option value="{{ $version->id }}">{{ $version->version_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="eventLabel">Shift</label>
                            <div class="position-relative">
                                <select class="select select-event-label form-select " id="shift_id" name="shift_id">
                                    <option value="">Select Shift</option>
                                    @foreach ($shifts as $shift)
                                        <option value="{{ $shift->id }}">{{ $shift->shift_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="eventLabel">Class</label>
                            <div class="position-relative">
                                <select class="select select-event-label form-select " id="class_id" name="class_id">
                                    <option value="">Select Class</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="eventLabel">Section</label>
                            <div class="position-relative">
                                <select class="select select-event-label form-select " id="section_id" name="section_id">
                                    <option value="">Select Section</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="eventLabel">Subject</label>
                            <div class="position-relative">
                                <select class="select select-event-label form-select " id="subject_id" name="subject_id">
                                    <option value="">Select Subject</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="eventLabel">Teacher</label>
                            <div class="position-relative">
                                <select class="select2 select-event-label form-select " id="employee_id"
                                    name="employee_id">
                                    <option value="">Select Teacher</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="eventLabel">Day</label>
                            <div class="position-relative">
                                <select class="select select-event-label form-select " id="day_name" name="day_name">
                                    <option value="">Select Day</option>
                                    @foreach ($days as $day)
                                        <option value="{{ $day->day_name }}">{{ $day->day_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="eventLabel">Time</label>
                            <div class="position-relative">
                                <select class="select select-event-label form-select " id="time" name="time">


                                </select>

                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="is_class_teacher"
                                    id="is_class_teacher" value="1">
                                <label class="form-check-label" for="english">Is Class Teacher</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="is_main_teacher"
                                    id="is_main_teacher" value="1">
                                <label class="form-check-label" for="english">Is Main Teacher</label>
                            </div>
                        </div>
                        <div class="mb-3 d-flex justify-content-sm-between justify-content-start my-4">
                            <div>
                                <button type="submit" class="btn btn-primary btn-add-event me-sm-3 me-1">Add</button>
                                <button type="reset" class="btn btn-label-secondary btn-cancel me-sm-0 me-1"
                                    data-bs-dismiss="offcanvas">Cancel</button>
                            </div>
                            <div><button class="btn btn-label-danger btn-delete-event d-none">Delete</button></div>
                        </div>
                        <input type="hidden">
                    </form>
                </div>
            </div>
        </div>

        <!-- / Content -->

        <div class="content-backdrop fade"></div>
    </div>

    <!-- / Footer -->


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialDate: '{{ date('Y-m-d') }}',
                editable: true,
                selectable: true,
                businessHours: true,
                dayMaxEvents: true, // allow "more" link when too many events
                events: [
                    @if (isset($routines))
                        @foreach ($routines as $routine)
                            {
                                groupId: '{{ $routine['groupId'] }}',
                                title: '{{ $routine['title'] }}',
                                start: '{{ $routine['start'] }}'
                            },
                        @endforeach
                    @endif
                    //   {
                    //     title: 'Long Event',
                    //     start: '2023-01-07',
                    //     end: '2023-01-10'
                    //   },
                    //   {
                    //     groupId: 999,
                    //     title: 'Repeating Event',
                    //     start: '2023-01-09T16:00:00'
                    //   },
                    //   {
                    //     groupId: 999,
                    //     title: 'Repeating Event',
                    //     start: '2023-01-16T16:00:00'
                    //   },
                    //   {
                    //     title: 'Conference',
                    //     start: '2023-01-11',
                    //     end: '2023-01-13'
                    //   },
                    //   {
                    //     title: 'Meeting',
                    //     start: '2023-01-12T10:30:00',
                    //     end: '2023-01-12T12:30:00'
                    //   },
                    //   {
                    //     title: 'Lunch',
                    //     start: '2023-01-12T12:00:00'
                    //   },
                    //   {
                    //     title: 'Meeting',
                    //     start: '2023-01-12T14:30:00'
                    //   },
                    //   {
                    //     title: 'Happy Hour',
                    //     start: '2023-01-12T17:30:00'
                    //   },
                    //   {
                    //     title: 'Dinner',
                    //     start: '2023-01-12T20:00:00'
                    //   },
                    //   {
                    //     title: 'Birthday Party',
                    //     start: '2023-01-13T07:00:00'
                    //   },
                    //   {
                    //     title: 'Click for Google',
                    //     url: 'http://google.com/',
                    //     start: '2023-01-28'
                    //   }
                ]
            });

            calendar.render();
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $(document.body).on('click', '.editbutton', function() {
                var id = $(this).data('id');

                var class_id = $(this).data('class_id');

                var session_id = $(this).data('session_id');
                var section_id = $(this).data('section_id');
                var version_id = $(this).data('version_id');
                var day_name = $(this).data('day_name');
                var start_time = $(this).data('start_time');
                var end_time = $(this).data('end_time');
                var employee_id = $(this).data('employee_id');

                var is_class_teacher = $(this).data('is_class_teacher');
                var shift_id = $(this).data('shift_id');
                var type_for = $(this).data('type_for');
                var type = '';
                if (type_for == 1) {
                    type = 'primary';
                } else if (type_for == 2) {
                    type = 'secondary';
                } else {
                    type = 'college';
                }
                var subject_id = $(this).data('subject_id');
                var time = start_time + '-' + end_time;

                $.LoadingOverlay("show");
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
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            title: "Error",
                            text: errorThrown,
                            icon: "warning"
                        });

                    }
                });
                var url = "{{ route('getSections') }}";

                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        class_id,
                        shift_id,
                        version_id
                    },
                    success: function(response) {

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

                var url = "{{ route('getSubject') }}";
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        class_id,
                        version_id
                    },
                    success: function(response) {

                        $('#subject_id').html(response);

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
                var url = "{{ route('getTeachersByPost') }}";
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        type,
                        subject_id,
                        class_id,
                        shift_id,
                        version_id
                    },
                    success: function(response) {

                        $('#employee_id').html(response)



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



                var url = "{{ route('getTime') }}";
                $.ajax({
                    type: "get",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        value: type
                    },
                    success: function(response) {
                        $.LoadingOverlay("hide");
                        $('#time').html(response)


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
                setInterval(function() {
                    $('#class_id').val(class_id);
                    $('#id').val(id);
                    $('#section_id').val(section_id);
                    $('#session_id').val(session_id);
                    $('#version_id').val(version_id);
                    $('#day_name').val(day_name);

                    $('#employee_id').val(employee_id);
                    is_c_t = (is_class_teacher == 1) ? true : false;
                    $("#is_class_teacher").prop("checked", is_c_t);

                    $('#shift_id').val(shift_id);
                    $('#subject_id').val(subject_id);
                    $('#type_for').val(type);
                    if (type == 'college') {
                        $('#time').val(time);
                        $('.colleges').show();
                        $('.secondarys').hide();
                        $('.primarys').hide();
                    } else {
                        $('#time').val(time);
                        $('.colleges').hide();
                        $('.secondarys').show();
                        $('.primarys').show();
                    }

                    $.LoadingOverlay("hide");
                }, 5000);



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

                        $('#class_id_search').html(response)
                        $('#routinelist').html('');
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


                var type = $('#type_for').val()
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

                        $('#class_id_search').html(response)
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


                var type = $('#type_for').val()
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

                        $('#class_id_search').html(response);
                        $('#routinelist').html('');
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
            $(document.body).on('change', '#class_id_search', function() {
                var id = $(this).val();
                var shift_id = $('input[name="shift_id"]:checked').val();
                var version_id = $('input[name="version_id"]:checked').val();
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
                        class_id: id,
                        shift_id,
                        version_id
                    },
                    success: function(response) {
                        $.LoadingOverlay("hide");
                        $('#section_id_search').html(response);
                        $('#routinelist').html('');

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
            $(document.body).on('change', '#section_id_search', function() {


                var class_id = $('#class_id_search').val();
                var shift_id = $('input[name="shift_id"]:checked').val();
                var version_id = $('input[name="version_id"]:checked').val();
                var session_id = $('#session_id').val();
                $.LoadingOverlay("show");
                var section_id = $('#section_id_search').val();
                if (section_id && version_id && shift_id && class_id) {
                    var url = "{{ route('getRoutine') }}";
                    $.ajax({
                        type: "get",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: url,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            shift_id,
                            class_id,
                            section_id,
                            version_id,
                            session_id
                        },
                        success: function(response) {
                            $.LoadingOverlay("hide");
                            $('#routinelist').html(response)


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
            $(document.body).on('change', '#type_for', function() {
                var value = $(this).val();

                var url = "{{ route('getTime') }}";
                $.ajax({
                    type: "get",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        value
                    },
                    success: function(response) {
                        $.LoadingOverlay("hide");
                        $('#time').html(response)


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
            $(document.body).on('change', '#type', function() {


                var type = $('#type_for').val();

                var shift_id = $('#shift_id').val();
                var version_id = $('#version_id').val();
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

            });


            $(document.body).on('change', '#version_id', function() {


                var type = $('#type_for').val()
                var shift_id = $('#shift_id').val();
                var version_id = $('#version_id').val();
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

            });

            $(document.body).on('change', '#shift_id', function() {


                var type = $('#type_for').val()
                var shift_id = $('#shift_id').val();
                var version_id = $('#version_id').val();
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

            });
            $(document.body).on('change', '#class_id', function() {
                var id = $(this).val();
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
                        class_id: id,
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
                var url = "{{ route('getSubject') }}";
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        class_id: id,
                        version_id
                    },
                    success: function(response) {
                        $.LoadingOverlay("hide");
                        $('#subject_id').html(response);

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
            $(document.body).on('change', '#subject_id', function() {


                var type = $('#type_for').val()
                var subject_id = $('#subject_id').val();
                var shift_id = $('#shift_id').val();
                var version_id = $('#version_id').val();
                var class_id = $('#class_id').val();
                $.LoadingOverlay("show");
                var id = $(this).val();
                var url = "{{ route('getTeachersByPost') }}";
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        type: type,
                        subject_id: subject_id,
                        class_id,
                        shift_id,
                        version_id
                    },
                    success: function(response) {

                        $('#employee_id').html(response)

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

            });
            $(document.body).on('change', '#search', function() {
                if ($('#search_by').val() && $(this).val()) {
                    location.href = "{{ route('students.index') }}" + '?search=' + $(this).val() +
                        ' & search_by=' + $('#search_by').val();
                }


            });
            $(document.body).on('change', '#search_by', function() {
                if ($('#search').val() && $(this).val()) {
                    location.href = "{{ route('students.index') }}" + '?search_by=' + $(this).val() +
                        ' & search=' + $('#search').val();
                }


            });
            $(document.body).on('click', '.delete', function() {
                var id = $(this).data('id');
                var url = $(this).data('url');
                Swal.fire({
                    title: 'Do you want to Delete this Routine?',
                    showDenyButton: true,
                    confirmButtonText: 'Yes',
                    denyButtonText: 'No',
                    customClass: {
                        actions: 'my-actions',
                        cancelButton: 'order-1 right-gap',
                        confirmButton: 'order-2',
                        denyButton: 'order-3',
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "delete",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                            },
                            url: url,
                            data: {
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                if (response == 1) {
                                    Swal.fire({
                                        title: "Good job!",
                                        text: "Deleted successfully",
                                        icon: "success"
                                    });
                                    $('#row' + id).remove();
                                } else {
                                    Swal.fire({
                                        title: "Error!",
                                        text: response,
                                        icon: "warning"
                                    });
                                }

                            },
                            error: function(data, errorThrown) {
                                Swal.fire({
                                    title: "Error",
                                    text: errorThrown,
                                    icon: "warning"
                                });

                            }
                        });
                    } else if (result.isDenied) {

                    }
                })

            });
        });
    </script>
    <script>
        // Display Laravel success or error messages with Toastr
        @if (session('success'))
            toastr.success("{{ session('success') }}", "Success", {
                closeButton: true,
                progressBar: true,
                timeOut: 3000,
            });
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}", "Error", {
                closeButton: true,
                progressBar: true,
                timeOut: 3000,
            });
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}", "Validation Error", {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 3000,
                });
            @endforeach
        @endif
    </script>
@endsection
