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
        <div class="container-xxl flex-grow-1 container-p-y">

            {{-- <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Dashboard /</span> Merit List
         </h4> --}}

            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"> Merit List</li>
                </ol>
            </nav>

            <div class="col-md mb-4 mb-md-0">
                <div class="card">

                    <div class="card-header">
                        <!-- Filter Form -->
                        <form id="formAccountSettings" method="POST" action="{{ route('tabulation.store') }}">

                            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />

                            <div class="row">
                                <div class="mb-3 col-sm-3">
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
                                <div class="mb-3 col-sm-3">
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
                                <div class="mb-3 col-sm-3">
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
                                <div class="mb-3 col-sm-3">
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
                                <div class="mb-3 col-sm-3">
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
                                {{-- <div class="mb-3 col-sm-3">
                                    <label for="class_code" class="form-label">
                                        Subjects <span style="color: red">*</span>
                                    </label>
                                    <select id="subject_id" name="subject_id" class=" form-select">
                                        <option value="">Select Subject</option>

                                    </select>
                                </div> --}}
                                <div class="mb-3 col-sm-3">
                                    <label for="exam_id" class="form-label">Exam <span style="color: red">*</span></label>
                                    <select id="exam_id" name="exam_id" class="form-select" required="">
                                        <option value="">Select Exam</option>

                                    </select>
                                </div>
                                <div class="mb-3  col-md-2">
                                    <label class="form-label" for="amount"> </label>
                                    <button type="button" id="searchtop"
                                        class="btn btn-primary form-control me-2 mt-1">Search</button>
                                </div>
                            </div>
                            {{-- <div class="table-responsive text-nowrap" id="tabledata"> --}}
                        </form>
                    </div>
                    <div class="card-body">
                        <!-- Merit List Results -->
                        <div class="table-responsive text-nowrap" id="meritListResults">
                            <!-- Results will be dynamically loaded here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>


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
            $(document).ready(function() {
                $('#searchtop').on('click', function() {
                    var session_id = $('#session_id').val();
                    var class_code = $('#class_code').val();
                    var section_id = $('#section_id').val();
                    var exam_id = $('#exam_id').val();
                    var version_id = $('#version_id').val();
                    var group_id = $('#group_id').val();
                    var shift_id = $('#shift_id').val();

                    if (session_id && class_code && exam_id) {
                        $.LoadingOverlay("show");
                        $.ajax({
                            type: "POST",
                            url: "{{ route('getMeritList') }}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                session_id: session_id,
                                class_code: class_code,
                                section_id: section_id,
                                exam_id: exam_id,
                                version_id: version_id,
                                group_id: group_id,
                                shift_id: shift_id
                            },
                            success: function(response) {
                                $('#meritListResults').html(response);
                                $.LoadingOverlay("hide");
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    title: "Error",
                                    text: error,
                                    icon: "warning"
                                });
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

    {{-- <script>
        function getSections(class_code, session_id) {
            $.ajax({
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                },
                url: "{{ route('getSections') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "class_id": class_code
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

                }
            });
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
                    $.LoadingOverlay("hide");
                },
                error: function(data, errorThrown) {
                    Swal.fire({
                        title: "Error",
                        text: errorThrown,
                        icon: "warning"
                    });
                    $.LoadingOverlay("hide");
                }
            });
        }
        $(function() {
            getSections({{ $class_code }}, {{ $session_id }});
        });
        $(document.body).on('change', '#class_code', function() {
            var session_id = $('#session_id').val();
            var class_code = $('#class_code').val();
            $.LoadingOverlay("show");
            if (class_code) {

                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: "{{ route('getSubjects') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        class_code
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

                    }
                });

                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: "{{ route('getSections') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "class_id": class_code
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

                    }
                });
            }
            if (session_id && class_code) {
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
                        $.LoadingOverlay("hide");
                    },
                    error: function(data, errorThrown) {
                        Swal.fire({
                            title: "Error",
                            text: errorThrown,
                            icon: "warning"
                        });
                        $.LoadingOverlay("hide");
                    }
                });
            }
            $.LoadingOverlay("hide");
        });
        $(document.body).on('change', '#session_id', function() {
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
                        $.LoadingOverlay("hide");
                    },
                    error: function(data, errorThrown) {
                        Swal.fire({
                            title: "Error",
                            text: errorThrown,
                            icon: "warning"
                        });
                        $.LoadingOverlay("hide");
                    }
                });
            }


        });


        $(document).ready(function() {
            $('#searchtop').on('click', function() {
                var session_id = $('#session_id').val();
                var class_code = $('#class_code').val();
                var section_id = $('#section_id').val();
                var exam_id = $('#exam_id').val();
                var version_id = $('#version_id').val();
                var group_id = $('#group_id').val();

                if (session_id && class_code && exam_id) {
                    $.LoadingOverlay("show");
                    $.ajax({
                        type: "POST",
                        url: "{{ route('getMeritList') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            session_id: session_id,
                            class_code: class_code,
                            section_id: section_id,
                            exam_id: exam_id,
                            version_id: version_id,
                            group_id: group_id
                        },
                        success: function(response) {
                            $('#meritListResults').html(response);
                            $.LoadingOverlay("hide");
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                title: "Error",
                                text: error,
                                icon: "warning"
                            });
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
        });
    </script> --}}
@endsection
