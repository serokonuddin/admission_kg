@extends('admin.layouts.layout')
@section('content')
    <style>
        input[readonly] {
            background-color: #f6f6f6 !important;
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

    @php
        $user = Auth::user();
        $allowedClasses = [];

        if ($user->class_id == 1) {
            $allowedClasses = [0, 1, 2, 3, 4, 5];
        } elseif ($user->class_id == 2) {
            $allowedClasses = [6, 7, 8, 9, 10];
        } elseif ($user->class_id == 3) {
            $allowedClasses = [11, 12];
        } elseif ($user->class_id == 4) {
            $allowedClasses = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        } else {
            $allowedClasses = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        }
    @endphp

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">

            {{-- <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">Dashboard /</span> Admit Card
            </h4> --}}
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"> Admit Card</li>
                </ol>
            </nav>

            <div class="col-md mb-4 mb-md-0">
                <div class="card">

                    <div class="card-header">
                        <form id="formAccountSettings" method="POST" action="{{ route('tabulation.store') }}">

                            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />

                            <div class="row">

                                <div class="mb-3 col-md-4">
                                    <label for="session_id" class="form-label">Session <span
                                            style="color: red">*</span></label>
                                    <select id="session_id" name="session_id" class=" form-select" required="">
                                        <option value="">Select Session</option>
                                        @foreach ($sessions as $session)
                                            <option value="{{ $session->id }}">{{ $session->session_name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="version_id" class="form-label">Version </label>
                                    <select id="version_id" name="version_id" class=" form-select">
                                        <option value="">Select Version</option>
                                        @if (Auth::user()->version_id)
                                            <option value="{{ Auth::user()->version_id }}" selected>
                                                {{ Auth::user()->version_id == 1 ? 'Bangla' : 'English' }}
                                            </option>
                                        @else
                                            @foreach ($versions as $version)
                                                <option value="{{ $version->id }}">{{ $version->version_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="shift_id" class="form-label">Shift <span
                                            class="text-danger">*</span></label>
                                    <select id="shift_id" name="shift_id" class="form-select"
                                        @if (Auth::user()->group_id == 3) disabled="disabled" @endif>
                                        <option value="">Select Shift</option>
                                        @if (Auth::user()->shift_id)
                                            <option value="{{ Auth::user()->shift_id }}" selected>
                                                {{ Auth::user()->shift_id == 1 ? 'Morning' : 'Day' }}
                                            </option>
                                        @else
                                            @foreach ($shifts as $shift)
                                                <option value="{{ $shift->id }}"
                                                    {{ isset($activity) && $activity->shift_id == $shift->id ? 'selected="selected"' : '' }}>
                                                    {{ $shift->shift_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="class_code" class="form-label">Class <span
                                            style="color: red">*</span></label>
                                    <select id="class_code" name="class_code" class=" form-select" required="">
                                        <option value="">Select Class</option>
                                        @foreach ($classes as $class_code => $class_name)
                                            @if (in_array($class_code, $allowedClasses))
                                                <option value="{{ $class_code }}"
                                                    {{ isset($activity) && $activity->class_code == $class_code ? 'selected="selected"' : '' }}>
                                                    {{ $class_name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3 col-md-4">
                                    <label for="section_id" class="form-label">Section <span
                                            style="color: red">*</span></label>
                                    <select id="section_id" name="section_id" class=" form-select" required="">
                                        <option value="">Select Section</option>

                                    </select>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="exam_id" class="form-label">Exam <span style="color: red">*</span></label>
                                    <select id="exam_id" name="exam_id" class=" form-select" required="">
                                        <option value="">Select Exam</option>

                                    </select>
                                </div>



                                <div class="mb-3 col-md-2">
                                    <label class="form-label" for="search"></label>
                                    @if (Auth::user()->is_view_user == 0)
                                        <button type="button" id="generateAdmitCard"
                                            class="btn btn-primary form-control me-2 mt-1">Generate</button>
                                    @endif
                                </div>

                            </div>



                            <div class="table-responsive text-nowrap" id="tabledata">


                        </form>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive text-nowrap" id="admitcard">
                            <!-- Results will be dynamically loaded here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="content-backdrop fade"></div>
    </div>

    <script>
        $(function() {
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
            });
        });
    </script>

    <script>
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

                // $.ajax({
                //     type: "post",
                //     headers: {
                //         'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                //     },
                //     url: "{{ route('getSections') }}",
                //     data: {
                //         "_token": "{{ csrf_token() }}",
                //         "class_id": class_code
                //     },
                //     success: function(response) {
                //         $('#section_id').html(response);

                //     },
                //     error: function(data, errorThrown) {
                //         Swal.fire({
                //             title: "Error",
                //             text: errorThrown,
                //             icon: "warning"
                //         });

                //     }
                // });
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
            $('#generateAdmitCard').on('click', function() {
                var session_id = $('#session_id').val();
                var class_code = $('#class_code').val();
                var section_id = $('#section_id').val();
                var exam_id = $('#exam_id').val();
                var version_id = $('#version_id').val();

                if (session_id && class_code && exam_id) {
                    $.LoadingOverlay("show");
                    $.ajax({
                        type: "POST",
                        url: "{{ route('ajaxadmitcard') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            session_id: session_id,
                            class_code: class_code,
                            section_id: section_id,
                            exam_id: exam_id,
                            version_id: version_id
                        },
                        success: function(response) {
                            $('#admitcard').html(response);
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
    </script>
@endsection
