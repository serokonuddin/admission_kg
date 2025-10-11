@extends('admin.layouts.layout')
@section('content')
    <style>
        input[readonly] {
            background-color: #f6f6f6 !important;
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

        td,
        th {
            border: 1px solid #333;
            color: #000000;

        }

        .uppercase-title {
            text-transform: uppercase;
            font-weight: 500;
            padding: 5px;
        }

        .shift-title {
            font-size: 1rem;
            color: #566A7F;
            padding-bottom: 15px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 1.25rem;
            color: #333;
        }


        .row.g-4 {
            gap: 1rem;
        }

        .gradient-card {
            background: linear-gradient(45deg, #92d9e6, #007EA7);
            border: none;
            border-radius: 10px;
            padding: 1rem;
            color: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .btn-icon {
            background-color: white;
            color: #0A97B0;
            border: none;
            border-radius: 6px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            font-size: 1rem;
        }

        .btn-icon:hover {
            background-color: #007EA7;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
        }

        .btn-icon i {
            font-size: 1.2rem;
            margin-right: 0.5rem;
        }


        .btn-class {
            background-color: #0A97B0;
            color: white;
            border: none;
            border-radius: 8px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-class:hover {
            background-color: #086c87;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
        }

        .btn-class:focus {
            outline: none;
            box-shadow: 0 0 0 4px rgba(10, 151, 176, 0.3);
        }
    </style>

    <div class="content-wrapper">
        @php
            $classes = [
                'KG',
                'Class I',
                'Class II',
                'Class III',
                'Class IV',
                'Class V',
                'Class VI',
                'Class VII',
                'Class VIII',
                'Class IX',
                'Class X',
                'Class XI',
                'Class XII',
            ];

        @endphp

        <div class="container-xxl flex-grow-1 container-p-y">

            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>

                    <li class="breadcrumb-item active" aria-current="page"> Students Attendance Report </li>

                </ol>
            </nav>

            <div class="col-md mb-4 mb-md-0">
                <div class="card gradient-card">
                    <div class="card-body">
                        <h5 class="card-title text-center text-white">
                            Student Attendance Report
                        </h5>

                        <!-- Filter Form -->
                        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                        <input type="hidden" name="version_id" id="versionId" value="" />
                        <input type="hidden" name="class_code" id="class_code" value="" />
                        <div class="row mt-2">
                            <div class="mb-3 col-md-3">
                                <label for="state" class="form-label text-white">From Date<span
                                        class="text-danger">*</span></label>
                                <input class="form-control" type="date" id="from_date" name="from_date"
                                    placeholder="From Date" required>
                                <div class="invalid-feedback">From Date.</div>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="state" class="form-label text-white">To Date<span
                                        class="text-danger">*</span></label>
                                <input class="form-control" type="date" id="to_date" name="to_date"
                                    placeholder="To Date" required>
                                <div class="invalid-feedback">To Date. </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            @foreach ($classes as $key => $class)
                                <div class="col-6 col-md-4 col-lg-3">
                                    <button type="button" class="btn btn-icon w-100 py-2" data-bs-toggle="tooltip"
                                        id="class_code" data-bs-placement="bottom" title="{{ $class }}"
                                        value="{{ $key }}">
                                        <i class="fas fa-chalkboard-teacher me-2"></i> {{ $class }}
                                    </button>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>

            {{-- Version and shift --}}
            <div class="col-md my-4 mb-md-0" id="versionAndShift">

            </div>

        </div>

        <div class="content-backdrop fade"></div>
    </div>
    <script>
        $(function() {
            $(document.body).on('click', '#class_code', function() {
                var class_code = $(this).val();
                $('#class_code').val(class_code);
                var url = "{{ route('getVersion') }}";
                $.LoadingOverlay("show");
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        class_code: class_code,
                    },
                    success: function(response) {
                        $('#versionAndShift').html(response);
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
        });
    </script>

    <script>
        // Handle version change
        $(document.body).on('click', '.version-btn', function() {
            $('.shift-container').empty();
            var version_id = $(this).val();
            $('#versionId').val(version_id);
            var class_code = $('#class_code').val();
            // var exam_id = $('#exam_id').val();
            var session_id = $('#session_id').val();
            // var session_id = {{ $session->session_code }};
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            var targetContainer = $(this).data('target');

            console.log('Selected Version ID:', version_id);
            console.log('Selected Class Code:', class_code);
            // console.log('Selected Exam:', exam_id);
            console.log('Selected session_id:', session_id);

            if (version_id && from_date && to_date) {
                var url = "{{ route('attendance.getShiftsForVersion') }}";
                $.LoadingOverlay("show");
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        version_id: version_id,
                        class_code: class_code,
                        // exam_id: exam_id,
                        session_id: session_id,
                        from_date: from_date,
                        to_date: to_date,
                    },
                    success: function(response) {

                        $('#' + targetContainer).html(response.html);
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: "Error",
                            text: xhr?.responseJSON?.error ||
                                "An unexpected error occurred while loading shifts.",
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
                    text: "Please select a valid version and date range.",
                    icon: "warning"
                });
            }
        });

        // Handle the shift change
        $(document.body).on('click', '[name="shiftId"]', function() {

            // var session_id = {{ $session->session_code }};
            var session_id = $('#session_id').val();
            var shiftId = $(this).val();
            var version_id = $('#versionId').val();
            var class_code = $('#class_code').val();
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();

            console.log('class_code:', class_code);
            console.log('version_id:', version_id);
            console.log('shiftId:', shiftId);


            if (shiftId && version_id && class_code) {
                console.log('Version ID: ' + version_id + ', Shift ID: ' + shiftId + ', Class Code: ' + class_code);

                var url = "{{ route('student_attendance_section_page') }}";
                $.LoadingOverlay("show");
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        class_code: class_code,
                        version_id: version_id,
                        shift_id: shiftId,
                        session_id: session_id,
                        from_date: from_date,
                        to_date: to_date,
                    },
                    success: function(response) {
                        if (response.redirect_url) {
                            window.location.href = response.redirect_url;
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: "Error",
                            text: xhr?.responseJSON?.error || "An unexpected error occurred.",
                            icon: "warning"
                        });
                    },
                    complete: function() {
                        $.LoadingOverlay("hide");
                    }
                });
            }
        });
    </script>
@endsection
