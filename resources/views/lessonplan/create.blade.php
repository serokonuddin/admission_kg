@extends('admin.layouts.layout')
@section('content')
    <style>
        td,
        th {
            border: 1px solid #eee !important;
        }
    </style>
    <link rel="stylesheet"
        href="{{ asset('public/backend') }}/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
    <link rel="stylesheet"
        href="{{ asset('public/backend') }}/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
    <link rel="stylesheet" href="{{ asset('public/backend') }}/assets/vendor/libs/jquery-timepicker/jquery-timepicker.css" />
    <link rel="stylesheet" href="{{ asset('public/backend') }}/assets/vendor/libs/pickr/pickr-themes.css" />
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>

                    <li class="breadcrumb-item">
                        <a href="{{ route('lessonplan.index') }}">Lesson Plan</a>
                    </li>

                    <li class="breadcrumb-item active" aria-current="page"> Create</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-header shadow-sm mb-3 bg-gray text-white">Create Lesson Plan</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <form id="form" method="POST" action="{{ route('lessonplan.store') }}"
                                enctype="multipart/form-data">
                                <input type="hidden" value="{{ isset($lesson_plan) ? $lesson_plan->id : '' }}"
                                    name="id" />
                                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                                <div class="row">
                                    @php
                                        $session_id =
                                            isset($lesson_plan) && !is_null($lesson_plan->session_id)
                                                ? $lesson_plan->session_id
                                                : old('session_id') ?? '';
                                    @endphp
                                    <div class="mb-3 col-md-3">
                                        <label for="session" class="form-label">Session</label>
                                        <select id="session_id" name="session_id" class="form-select" required="">
                                            <option value="">Select Session</option>
                                            @foreach ($sessions as $session)
                                                <option value="{{ $session->id }}"
                                                    {{ $session_id == $session->id ? 'selected="selected"' : '' }}>
                                                    {{ $session->session_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @php
                                        $version_id =
                                            isset($lesson_plan) && !is_null($lesson_plan->version_id)
                                                ? $lesson_plan->version_id
                                                : old('version_id') ?? '';
                                    @endphp
                                    <div class="mb-3 col-md-3">
                                        <label for="job_type" class="form-label">Version</label>
                                        <select id="version_id" name="version_id" class=" form-select" required="">
                                            <option value="">Select Version</option>
                                            @foreach ($versions as $version)
                                                <option value="{{ $version->id }}"
                                                    {{ $version_id == $version->id ? 'selected="selected"' : '' }}>
                                                    {{ $version->version_name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    @php
                                        $shift_id =
                                            isset($lesson_plan) && !is_null($lesson_plan->shift_id)
                                                ? $lesson_plan->shift_id
                                                : old('shift_id') ?? '';
                                    @endphp
                                    <div class="mb-3 col-md-3">
                                        <label for="job_type" class="form-label">Shift</label>
                                        <select id="shift_id" name="shift_id" class=" form-select" required="">
                                            <option value="">Select Shift</option>
                                            @foreach ($shifts as $shift)
                                                <option value="{{ $shift->id }}"
                                                    {{ $shift_id == $shift->id ? 'selected="selected"' : '' }}>
                                                    {{ $shift->shift_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @php
                                        $class_id =
                                            isset($lesson_plan) && !is_null($lesson_plan->class_code)
                                                ? $lesson_plan->class_code
                                                : old('class_code') ?? '';
                                    @endphp
                                    <div class="mb-3 col-md-3">
                                        <label for="class_code" class="form-label">Class</label>
                                        <select id="class_code" name="class_code" class=" form-select" required="">
                                            <option value="">Select Class</option>
                                            @foreach ($classes as $class_code => $class_name)
                                                <option value="{{ $class_code }}"
                                                    {{ $class_id == $class_code ? 'selected="selected"' : '' }}>
                                                    {{ $class_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @php
                                        $section_id =
                                            isset($lesson_plan) && !is_null($lesson_plan->section_id)
                                                ? $lesson_plan->section_id
                                                : old('section_id') ?? '';
                                    @endphp
                                    <div class="mb-3 col-md-3">
                                        <label for="section_id" class="form-label">Section</label>
                                        <select id="section_id" name="section_id" class=" form-select" required="">
                                            <option value="">Select Section</option>
                                            @foreach ($sections as $section)
                                                <option value="{{ $section->id }}"
                                                    {{ $section_id == $section->id ? 'selected="selected"' : '' }}>
                                                    {{ $section->section_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-12 form-group">
                                        <label for="pdf" class="col-form-label">Pdf File <span
                                                class="text-danger">*</span></label>

                                        <input id="pdf" class="form-control" type="file" name="pdf">
                                        @if (isset($lesson_plan) && $lesson_plan->pdf)
                                            <p class="mt-2">Current File:
                                                <a href="{{ asset($lesson_plan->pdf) }}" target="_blank"
                                                    class="text-danger">
                                                    <i class="fa-solid fa-file-pdf"></i>View PDF
                                                </a>
                                            </p>
                                        @endif

                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <table class="table">
                                            <tr>
                                                <td rowspan="4"
                                                    style="writing-mode: vertical-rl; transform: rotate(180deg); text-align: center; vertical-align: middle;">
                                                    পরিচিতি (Introduction)
                                                </td>
                                                <td colspan="2">
                                                    @php
                                                        $number =
                                                            isset($lesson_plan) && $lesson_plan->number
                                                                ? $lesson_plan->number
                                                                : old('number');
                                                    @endphp
                                                    <div class="row mb-3 col-md-4 ">
                                                    </div>
                                                    <div class="row mb-3 col-md-6 ">
                                                        <label class="col-sm-7 col-form-label text-right"
                                                            style="text-align: right;" for="basic-default-name">Leason
                                                            Plan</label>
                                                        <div class="col-sm-5">
                                                            <input type="number" id="number" required=""
                                                                name="number" value="{{ $number }}"
                                                                class="form-control" placeholder="number">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 50%">
                                                    @php
                                                        $subject_id =
                                                            isset($lesson_plan) && $lesson_plan->subject_id
                                                                ? $lesson_plan->subject_id
                                                                : old('subject_id');
                                                    @endphp
                                                    <div class="row mb-3 col-md-12 ">
                                                        <label class="col-sm-4 col-form-label text-right"
                                                            for="basic-default-name">Subject</label>
                                                        <div class="col-sm-8">
                                                            <select id="subject_id" required="" name="subject_id"
                                                                class=" form-select" required="">
                                                                <option value="">Select Subject</option>
                                                                @foreach ($subjects as $subject)
                                                                    <option value="{{ $subject->id }}"
                                                                        {{ $subject_id == $subject->id ? 'selected="selected"' : '' }}>
                                                                        {{ $subject->subject_name }}</option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td style="width: 50%">
                                                    @php
                                                        $teacher_id =
                                                            isset($lesson_plan) && $lesson_plan->teacher_id
                                                                ? $lesson_plan->teacher_id
                                                                : old('teacher_id');
                                                    @endphp
                                                    <div class="row mb-3 col-md-12 ">
                                                        <label class="col-sm-4 col-form-label text-right"
                                                            for="basic-default-name">Teacher</label>
                                                        <div class="col-sm-8">
                                                            <select id="teacher_id" required="" name="teacher_id"
                                                                class=" form-select" required="">
                                                                <option value="">Select Teacher</option>
                                                                @foreach ($employees as $employee)
                                                                    @php
                                                                        $employeefor = 'College';
                                                                        if ($employee->employee_for == 1) {
                                                                            $employeefor = 'Primary';
                                                                        } elseif ($employee->employee_for == 2) {
                                                                            $employeefor = 'School';
                                                                        }
                                                                    @endphp
                                                                    <option value="{{ $employee->id }}"
                                                                        {{ $teacher_id == $employee->id ? 'selected="selected"' : '' }}>
                                                                        {{ $employee->employee_name }}
                                                                        ({{ $employee->designation->designation_name ?? '' }})
                                                                        Employee for: {{ $employeefor }}</option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                    </div>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 50%">
                                                </td>
                                                <td style="width: 50%">
                                                    @php
                                                        $general_lesson =
                                                            isset($lesson_plan) && $lesson_plan->general_lesson
                                                                ? $lesson_plan->general_lesson
                                                                : old('general_lesson');
                                                    @endphp
                                                    <div class="row mb-3 col-md-12 ">
                                                        <label class="col-sm-4 col-form-label text-right"
                                                            for="basic-default-name">Leason</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" required="" id="general_lesson"
                                                                name="general_lesson" value="{{ $general_lesson }}"
                                                                class="form-control" placeholder="Leason">
                                                        </div>
                                                    </div>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 50%">
                                                    @php
                                                        $date =
                                                            isset($lesson_plan) && $lesson_plan->date
                                                                ? $lesson_plan->date
                                                                : old('date');
                                                    @endphp
                                                    <div class="row mb-3 col-md-12 ">
                                                        <label class="col-sm-4 col-form-label text-right"
                                                            for="basic-default-name">Date</label>
                                                        <div class="col-sm-8">
                                                            <input type="date" required="" id="date"
                                                                name="date" value="{{ $date }}"
                                                                class="form-control" placeholder="date">
                                                        </div>
                                                    </div>

                                                </td>
                                                <td style="width: 50%">
                                                    @php
                                                        $time =
                                                            isset($lesson_plan) && $lesson_plan->time
                                                                ? $lesson_plan->time
                                                                : old('time');
                                                    @endphp
                                                    <div class="row mb-3 col-md-12 ">
                                                        <label class="col-sm-4 col-form-label text-right"
                                                            for="basic-default-name">Time</label>
                                                        <div class="col-sm-8">
                                                            <input type="number" required="" id="time"
                                                                name="time" value="{{ $time }}"
                                                                class="form-control" placeholder="Time">
                                                        </div>
                                                    </div>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="writing-mode: vertical-rl; transform: rotate(180deg); text-align: center; vertical-align: middle;">
                                                    শিখনফল (Objectives)
                                                </td>
                                                <td colspan="2">
                                                    @php
                                                        $objectives =
                                                            isset($lesson_plan) && $lesson_plan->objectives
                                                                ? $lesson_plan->objectives
                                                                : old('objectives');
                                                    @endphp
                                                    <textarea type="text" class="form-control textarea" id="objectives" name="objectives"
                                                        placeholder="শিখনফল (Objectives)">{!! $objectives !!}</textarea>
                                                <td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="writing-mode: vertical-rl; transform: rotate(180deg); text-align: center; vertical-align: middle;">
                                                    উপকরণ (Materials)
                                                </td>
                                                <td colspan="2">
                                                    @php
                                                        $materials =
                                                            isset($lesson_plan) && $lesson_plan->materials
                                                                ? $lesson_plan->materials
                                                                : old('materials');
                                                    @endphp
                                                    <textarea type="text" class="form-control" id="materials" name="materials" placeholder="উপকরণ (Materials)">{!! $materials !!}</textarea>
                                                <td>
                                            </tr>
                                        </table>
                                        <br />
                                        <table class="table">
                                            <tr>
                                                <th>
                                                    Stage
                                                </th>
                                                <th>
                                                    Teacher Work
                                                </th>
                                                <th>
                                                    Student Work
                                                </th>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="writing-mode: vertical-rl; transform: rotate(180deg); text-align: center; vertical-align: middle;">
                                                    প্রস্তুতি (wamp up)
                                                </td>
                                                <td>
                                                    @php
                                                        $wamp_up =
                                                            isset($lesson_plan) && $lesson_plan->wamp_up
                                                                ? $lesson_plan->wamp_up
                                                                : old('wamp_up');
                                                        $wamp_up_for_student =
                                                            isset($lesson_plan) && $lesson_plan->wamp_up_for_student
                                                                ? $lesson_plan->wamp_up_for_student
                                                                : old('wamp_up_for_student');
                                                    @endphp
                                                    <textarea type="text" class="form-control textarea" id="wamp_up" name="wamp_up"
                                                        placeholder="প্রস্তুতি (wamp up)">{!! $wamp_up !!}</textarea>
                                                </td>
                                                <td>
                                                    <textarea type="text" class="form-control textarea" id="wamp_up_for_student" name="wamp_up_for_student"
                                                        placeholder="প্রস্তুতি (wamp up)">{!! $wamp_up_for_student !!}</textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="writing-mode: vertical-rl; transform: rotate(180deg); text-align: center; vertical-align: middle;">
                                                    শিখন শিখানো কার্যক্রম (Procedure)
                                                </td>
                                                <td>
                                                    @php
                                                        $procedure =
                                                            isset($lesson_plan) && $lesson_plan->procedure
                                                                ? $lesson_plan->procedure
                                                                : old('procedure');
                                                        $procedure_for_student =
                                                            isset($lesson_plan) && $lesson_plan->procedure_for_student
                                                                ? $lesson_plan->procedure_for_student
                                                                : old('procedure_for_student');
                                                    @endphp
                                                    <textarea type="text" class="form-control textarea" id="procedure" name="procedure"
                                                        placeholder="শিখন শিখানো কার্যক্রম (Procedure)">{!! $procedure !!}</textarea>
                                                </td>
                                                <td>
                                                    <textarea type="text" class="form-control textarea" id="procedure_for_student" name="procedure_for_student"
                                                        placeholder="শিখন শিখানো কার্যক্রম (Procedure)">{!! $procedure_for_student !!}</textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="writing-mode: vertical-rl; transform: rotate(180deg); text-align: center; vertical-align: middle;">
                                                    মূল্যায়ন (Assessment)
                                                </td>
                                                <td>
                                                    @php
                                                        $assessment =
                                                            isset($lesson_plan) && $lesson_plan->assessment
                                                                ? $lesson_plan->assessment
                                                                : old('assessment');
                                                        $assessment_for_student =
                                                            isset($lesson_plan) && $lesson_plan->assessment_for_student
                                                                ? $lesson_plan->assessment_for_student
                                                                : old('assessment_for_student');
                                                    @endphp
                                                    <textarea type="text" class="form-control textarea" id="assessment" name="assessment"
                                                        placeholder=" মূল্যায়ন (Assessment)">{!! $assessment !!}</textarea>
                                                </td>
                                                <td>
                                                    <textarea type="text" class="form-control textarea" id="assessment_for_student" name="assessment_for_student"
                                                        placeholder=" মূল্যায়ন (Assessment)">{!! $assessment_for_student !!}</textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="writing-mode: vertical-rl; transform: rotate(180deg); text-align: center; vertical-align: middle;">
                                                    বাড়ির কাজ (Home Work)
                                                </td>
                                                <td>
                                                    @php
                                                        $home_work =
                                                            isset($lesson_plan) && $lesson_plan->home_work
                                                                ? $lesson_plan->home_work
                                                                : old('home_work');
                                                        $home_work_for_student =
                                                            isset($lesson_plan) && $lesson_plan->home_work_for_student
                                                                ? $lesson_plan->home_work_for_student
                                                                : old('home_work_for_student');
                                                    @endphp
                                                    <textarea type="text" class="form-control textarea" id="home_work" name="home_work"
                                                        placeholder="বাড়ির কাজ (Home Work)">{!! $home_work !!}</textarea>
                                                </td>
                                                <td>
                                                    <textarea type="text" class="form-control textarea" id="home_work_for_student" name="home_work_for_student"
                                                        placeholder="বাড়ির কাজ (Home Work)">{!! $home_work_for_student !!}</textarea>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                <a type="reset" href="{{ route('lessonplan.index') }}"
                                    class="btn btn-outline-secondary">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->
        <div class="content-backdrop fade"></div>
    </div>
    <script src="{{ asset('public/tinymce/js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    <script src="{{ asset('public/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                showConfirmButton: true,
                timer: 1500
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
                showConfirmButton: true
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validation Errors',
                html: '<ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>',
                showConfirmButton: true
            });
        @endif
    </script>
    <script>
        $(function() {
            $('#lfm').filemanager();
            $(document.body).on('change', 'input[name=is_parent]', function() {
                var parent_id = $(this).val();
                var text = $('#title').val();
                ///text=text.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
                text = text.replace(/[_\s]/g, '-').replace(/,/g, '');
                text = text.split(' ').join('_');
                if (parent_id == 0) {
                    $('#slug').val(text.toLowerCase());
                } else {
                    $('#slug').val('#');
                }
            });
            $(document.body).on('change', '#title', function() {
                var text = $(this).val();
                var parent_id = $('input[name=is_parent]:checked').val();
                //text=text.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
                text = text.replace(/[_\s]/g, '-').replace(/,/g, '');
                text = text.split(' ').join('_');
                if (parent_id == 0) {
                    $('#slug').val(text.toLowerCase());
                } else {
                    $('#slug').val('#');
                }

            });
        });
    </script>
    <script>
        var editor_config = {
            path_absolute: "{{ url('/') }}/",
            selector: '.textarea',
            relative_urls: false,
            plugins: 'iframe pageembed code preview anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'iframe | pageembed code preview | undo redo | blocks fontfamily fontsize | bold italic underline strikethrough| link image media | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | link image media',
            tiny_pageembed_classes: [{
                    text: 'Big embed',
                    value: 'my-big-class'
                },
                {
                    text: 'Small embed',
                    value: 'my-small-class'
                }
            ],
            file_picker_callback: function(callback, value, meta) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName(
                    'body')[0].clientWidth;
                var y = window.innerHeight || document.documentElement.clientHeight || document
                    .getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?editor=' + meta.fieldname;
                if (meta.filetype == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.openUrl({
                    url: cmsURL,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: "yes",
                    close_previous: "no",
                    onMessage: (api, message) => {
                        callback(message.content);
                    }
                });
            },
            setup: function(editor) {
                editor.ui.registry.addButton('iframe', {
                    icon: 'media',
                    tooltip: 'Insert iframe',
                    onAction: function(_) {
                        // Implement the logic to insert an iframe here
                        var iframeCode = prompt('Enter the iframe code:');
                        if (iframeCode) {
                            editor.insertContent(iframeCode);
                        }
                    }
                });
            }
        };

        tinymce.init(editor_config);
    </script>
    <script>
        $(function() {
            $(document.body).on('change', '#class_code', function() {
                var id = $(this).val();
                var shift_id = $('#shift_id').val();
                var group_id = $('#group_id').val();
                var version_id = $('#version_id').val();
                var session_id = $('#session_id').val();
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
                        session_id,
                        version_id
                    },
                    success: function(response) {
                        $('#section_id').html(response);
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
                var class_code = $('#class_code').val();
                var shift_id = $('#shift_id').val();
                var group_id = $('#group_id').val();
                var version_id = $('#version_id').val();
                var session_id = $('#session_id').val();
                var url = "{{ route('getClassWiseSubjects') }}";
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
                        group_id,
                        session_id,
                        version_id
                    },
                    success: function(response) {
                        $('#subject_id').html(response);
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
            $(document.body).on('change', '#subject_id', function() {
                var id = $(this).val();
                var class_code = $('#class_code').val();
                var shift_id = $('#shift_id').val();
                var group_id = $('#group_id').val();
                var version_id = $('#version_id').val();
                var session_id = $('#session_id').val();
                var section_id = $('#section_id').val();
                var url = "{{ route('getClassWiseEmployees') }}";
                $.LoadingOverlay("show");
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        subject_id: id,
                        class_code,
                        shift_id,
                        group_id,
                        session_id,
                        version_id,
                        section_id
                    },
                    success: function(response) {
                        $('#teacher_id').html(response);
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

            function handleSuccess(response) {
                Swal.fire({
                    title: "Good job!",
                    text: "Lesson Plan Created successfully",
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
        });
    </script>
@endsection
