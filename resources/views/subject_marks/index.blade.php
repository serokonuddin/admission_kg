@extends('admin.layouts.layout')
@section('content')
    <style>
        input[readonly] {
            background-color: #f6f6f6 !important;
        }

        td,
        th {
            border: 1px solid #333;
            color: #000000;
            text-align: center;
        }

        th {
            text-align: center;
        }

        .table>:not(caption)>*>* {
            padding: .125rem .25rem !important;
        }

        .table:not(.table-dark) th {
            color: #000000;
        }

        .redText {
            color: red !important;
            ;
        }

        .form-control {
            display: block;
            width: 100%;
            padding: .4375rem .875rem;
            font-size: 0.9375rem;
            font-weight: 400;
            line-height: 1.53;
            color: #606973;
            appearance: none;
            background-color: #fefefe !important;
            background-clip: padding-box;
            border: var(--bs-border-width) solid #8da5bd;
            border-radius: var(--bs-border-radius);
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Marks Entry</li>
                </ol>
            </nav>
            <div class="col-md mb-4 mb-md-0">
                <div class="card">
                    <div class="card-header">
                        @php
                            $user_group = Auth::user()->group_id;
                        @endphp
                        <form id="formAccountSettings" method="POST" action="{{ route('subject_marks.store') }}">
                            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                            <div class="row">
                                <div class="mb-3 col-sm-3" style="{{ Auth::user()->group_id == 3 ? 'display:none' : '' }}">
                                    <label for="session_id" class="form-label">Session <span
                                            style="color: red">*</span></label>
                                    <select id="session_id" name="session_id" class=" form-select" required=""
                                        @if (Auth::user()->group_id != 2 && Auth::user()->group_id != 5) disabled="disabled" @endif>
                                        <option value="">Select Session</option>
                                        @foreach ($sessions as $session_code => $session_name)
                                            <option value="{{ $session_code }}"
                                                {{ $session_id == $session_code ? 'selected="selected"' : '' }}>
                                                {{ $session_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-sm-3" style="{{ Auth::user()->group_id == 3 ? 'display:none' : '' }}">
                                    <label for="session_id" class="form-label">Version <span
                                            style="color: red">*</span></label>
                                    <select id="version_id" name="version_id" class=" form-select"
                                        @if (Auth::user()->group_id != 2 && Auth::user()->group_id != 5) disabled="disabled" @endif>
                                        <option value="">Select Version</option>
                                        @foreach ($versions as $version)
                                            <option value="{{ $version->id }}"
                                                {{ $version->id == $version_id ? 'selected="selected"' : '' }}>
                                                {{ $version->version_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-sm-3" style="{{ Auth::user()->group_id == 3 ? 'display:none' : '' }}">
                                    <label for="session_id" class="form-label">Shift <span
                                            style="color: red">*</span></label>
                                    <select id="shift_id" name="shift_id" class=" form-select"
                                        @if (Auth::user()->group_id != 2 && Auth::user()->group_id != 5) disabled="disabled" @endif>
                                        <option value="">Select Shift</option>
                                        @foreach ($shifts as $shift)
                                            <option value="{{ $shift->id }}"
                                                {{ $shift->id == $shift_id ? 'selected="selected"' : '' }}>
                                                {{ $shift->shift_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-sm-3" style="{{ Auth::user()->group_id == 3 ? 'display:none' : '' }}">
                                    <label for="class_code" class="form-label">
                                        Class <span style="color: red">*</span>
                                    </label>
                                    <select id="class_code" name="class_code" class="form-select" required
                                        @if (Auth::user()->group_id != 2 && Auth::user()->group_id != 5) disabled="disabled" @endif>
                                        <option value="">Select Class</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->class_code }}"
                                                {{ $class_code == $class->class_code ? 'selected="selected"' : '' }}>
                                                {{ $class->class_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-sm-3" style="{{ Auth::user()->group_id == 3 ? 'display:none' : '' }}">
                                    <label for="group_id" class="form-label">Group</label>
                                    <select id="group_id" name="group_id" class=" form-select">
                                        <option value="">Select Group</option>
                                        @foreach ($groups as $group)
                                            <option value="{{ $group->id }}"
                                                {{ $group_id == $group->id ? 'selected="selected"' : '' }}>
                                                {{ $group->group_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-sm-3" style="{{ Auth::user()->group_id == 3 ? 'display:none' : '' }}">
                                    <label for="class_code" class="form-label">
                                        Section <span style="color: red">*</span>
                                    </label>
                                    <select id="section_id" name="section_id" class="form-select"
                                        @if (Auth::user()->group_id != 2 && Auth::user()->group_id != 5) disabled="disabled" @endif>
                                        <option value="">Select Section</option>
                                        @foreach ($sections as $section)
                                            <option value="{{ $section->id }}"
                                                {{ $section_id == $section->id ? 'selected="selected"' : '' }}>
                                                {{ $section->section_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-sm-3">
                                    <label for="class_code" class="form-label">
                                        Subjects <span style="color: red">*</span>
                                    </label>
                                    <select id="subject_id" name="subject_id" class=" form-select">
                                        <option value="">Select Subject</option>

                                    </select>
                                </div>
                                <div class="mb-3 col-sm-3">
                                    <label for="exam_id" class="form-label">Exam <span style="color: red">*</span></label>
                                    <select id="exam_id" name="exam_id" class="form-select" required="">
                                        <option value="">Select Exam</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-sm-3">
                                    <label for="exam_type" class="form-label">Exam Type</label>
                                    <select id="exam_type" name="exam_type" class="form-select">
                                        <option value="">Select Exam Type</option>
                                    </select>
                                </div>

                            </div>
                        </form>
                        <div class="col-sm-12 d-flex justify-content-end">
                            <button type="button" id="searchtop" class="btn btn-primary me-2 btn-sm">Search</button>
                            <button type="button" id="searchblanktop" class="btn btn-info btn-sm">Blank Mark</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-container text-nowrap" id="tabledata">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->
        <div class="content-backdrop fade"></div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const examTypeOptions = {
                '0-2': ['ct1', 'ct2'],
                '3-5': ['ct', 'term'],
                '6-8': ['ct', 'cq', 'mcq'],
                '9': ['ct', 'cq', 'mcq', 'practical'],
                'default': ['cq', 'mcq', 'practical']
            };

            const classSelector = document.getElementById("class_code");
            const examTypeSelector = document.getElementById("exam_type");

            function updateExamType(classCode) {
                let types = [];

                if (classCode >= 0 && classCode <= 2) {
                    types = examTypeOptions['0-2'];
                } else if (classCode >= 3 && classCode <= 5) {
                    types = examTypeOptions['3-5'];
                } else if (classCode >= 6 && classCode <= 8) {
                    types = examTypeOptions['6-8'];
                } else if (classCode === 9) {
                    types = examTypeOptions['9'];
                } else {
                    types = examTypeOptions['default'];
                }

                examTypeSelector.innerHTML = '<option value="">Select Exam Type</option>';
                types.forEach(type => {
                    const option = document.createElement("option");
                    option.value = type;
                    option.textContent = type.toUpperCase();
                    examTypeSelector.appendChild(option);
                });
            }

            classSelector.addEventListener("change", function() {
                const classCode = parseInt(this.value);
                if (!isNaN(classCode)) {
                    updateExamType(classCode);
                }
            });

            // preload if already selected
            if (classSelector.value) {
                updateExamType(parseInt(classSelector.value));
            }
        });
    </script>

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
            $(document.body).on('change', '#shift_id', function() {
                var version_id = $('#version_id').val();
                var shift_id = $('#shift_id').val();
                if (version_id && shift_id) {
                    $.LoadingOverlay("show");
                    $.ajax({
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: "{{ route('getClass') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            version_id,
                            shift_id
                        },
                        success: function(response) {
                            $('#class_code').html(response);
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
                }

            });
            $(document.body).on('change', '#class_code', function() {
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
                        $('#section_id').html(response);
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
            $(document.body).on('change', '#group_id', function() {
                var id = $(this).val();
                var shift_id = $('#shift_id').val();
                var version_id = $('#version_id').val();
                var class_id = $('#class_code').val();
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
                        group_id: id,
                        class_id,
                        shift_id,
                        version_id
                    },
                    success: function(response) {
                        $('#section_id').html(response);
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
            $(document.body).on('change', '#class_code', function() {
                var session_id = $('#session_id').val();
                var class_code = $('#class_code').val();
                if (session_id && class_code) {
                    $.LoadingOverlay("show");
                    $.ajax({
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: "{{ route('getExam') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            session_id,
                            class_code
                        },
                        success: function(response) {
                            $('#exam_id').html(response);
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
                }

            });
            $(document.body).on('click', '#searchtop', function() {
                var session_id = $('#session_id').val();
                var class_code = $('#class_code').val();
                var subject_id = $('#subject_id').val();
                var section_id = $('#section_id').val();
                var exam_id = $('#exam_id').val();
                var exam_type = $('#exam_type').val();
                var version_id = $('#version_id').val();
                var group_id = $('#group_id').val();
                var getdata = 0;
                if (session_id && class_code && subject_id && section_id && exam_id) {
                    $.LoadingOverlay("show");
                    $.ajax({
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: "{{ route('getSubjectMarks') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            getdata,
                            session_id,
                            class_code,
                            subject_id,
                            group_id,
                            version_id,
                            section_id,
                            exam_id,
                            exam_type
                        },
                        success: function(response) {
                            $('#tabledata').html(response);
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
                } else {
                    Swal.fire({
                        title: "Error",
                        text: 'Asterisk(*) fields need to be completed.',
                        icon: "warning"
                    });

                }

            });
            $(document.body).on('click', '#searchblanktop', function() {
                var session_id = $('#session_id').val();
                var class_code = $('#class_code').val();
                var subject_id = $('#subject_id').val();
                var section_id = $('#section_id').val();
                var exam_id = $('#exam_id').val();
                var version_id = $('#version_id').val();
                var group_id = $('#group_id').val();
                var getdata = 0;
                if (session_id && class_code && subject_id && section_id && exam_id) {
                    $.LoadingOverlay("show");
                    $.ajax({
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: "{{ route('getSubjectMarksBlank') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            getdata,
                            session_id,
                            class_code,
                            subject_id,
                            group_id,
                            version_id,
                            section_id,
                            exam_id
                        },
                        success: function(response) {
                            window.open(response, '_blank');
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
                } else {
                    Swal.fire({
                        title: "Error",
                        text: 'Asterisk(*) fields need to be completed.',
                        icon: "warning"
                    });

                }

            });

            if ($('#section_id').val()) {
                fetchSubjects();
            }
            if ($('#session_id').val()) {
                fetchExams();
            }
        });

        function fetchExams() {
            var session_id = $('#session_id').val();
            var class_code = $('#class_code').val();
            if (session_id && class_code) {
                $.LoadingOverlay("show");
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: "{{ route('getExam') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        session_id,
                        class_code
                    },
                    success: function(response) {
                        $('#exam_id').html(response);
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
            }
        };

        function fetchSubjects() {
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
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#headerTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

        });
    </script>
    <script>
        var Num = function(n, p = 2) {
            return +(parseFloat(n, 10) || 0).toFixed(p);
        }
        var Val = function($n, v) {
            var $n = $($n);
            return (arguments.length > 1) ? $n.val(Num(v) || '') : Num($n.val());
        }
        var isDefined = function(v) {
            return typeof(v) !== 'undefined';
        }
    </script>
@endsection
