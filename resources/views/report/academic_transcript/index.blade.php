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

        :root {
            --bs-breadcrumb-divider: ">";
        }

        .breadcrumb a {
            text-decoration: none;
            color: #007bff;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
            color: #0056b3;
        }

        .pull-right {
            text-align: right;
            margin-bottom: 10px;
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
                    <li class="breadcrumb-item active" aria-current="page"> Academic Transcript</li>
                </ol>
            </nav>
            <div class="col-md mb-4 mb-md-0">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="session_id" class="form-label">Session <span style="color: red">*</span></label>
                                <select id="session_id" name="session_id" class=" form-select" required="">
                                    @foreach ($sessions as $key => $session)
                                        <option value="{{ $key }}">{{ $session }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="class_code" class="form-label">Class <span style="color: red">*</span></label>
                                <select id="class_code" name="class_code" class=" form-select" required="">
                                    <option value="">Select Class</option>
                                    @foreach ($classes as $key => $class)
                                        <option value="{{ $class->class_code }}">{{ $class->class_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="exam_id" class="form-label">Exam <span style="color: red">*</span></label>
                                <select id="exam_id" name="exam_id" class=" form-select" required="">
                                    <option value="">Select Exam</option>

                                </select>
                            </div>
                            <div class="mb-3  col-md-2">
                                <label class="form-label" for="amount"> </label>
                                <button type="button" id="searchtop"
                                    class="btn btn-primary form-control me-2 ">Search</button>
                            </div>
                        </div>

                        <div class="table-responsive text-nowrap" id="tabledata">
                        </div>
                    </div>
                </div>
            </div>
            <!-- / Content -->
            <div class="content-backdrop fade"></div>
        </div>
        <script>
            $(document.body).on('change', '#class_code', function() {
                $.LoadingOverlay("show");
                var session_id = $('#session_id').val();
                var class_code = $('#class_code').val();

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
                $.LoadingOverlay("hide");
            });
            $(document.body).on('click', '#searchtop', function() {
                var session_id = $('#session_id').val();
                var class_code = $('#class_code').val();
                var exam_id = $('#exam_id').val();
                var getdata = 0;
                if (session_id && class_code && exam_id) {
                    $.LoadingOverlay("show");
                    $.ajax({
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: "{{ route('student.getAcademicTranscript') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            session_id,
                            class_code,
                            exam_id
                        },
                        success: function(response) {
                            console.log(response);
                            $('#tabledata').html(response);
                        },
                        error: function(data, errorThrown) {
                            console.log(data, errorThrown);
                            let errorMessage = data.responseJSON?.message ||
                                "An unexpected error occurred.";
                            Swal.fire({
                                title: "Error",
                                text: errorMessage,
                                icon: "error"
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
        </script>
    @endsection
