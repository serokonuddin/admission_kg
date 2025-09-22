@extends('admin.layouts.layout')
@section('content')
    <style>
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
            vertical-align: middle !important;
        }

        .table:not(.table-dark) th {
            color: #ffffff;
        }

        .form-label {

            width: 100%;
        }

        .rounded {
            border-radius: 8px;

        }

        .present {
            color: rgb(31, 212, 40);
            font-weight: bold
        }

        .absent {
            color: rgb(191, 5, 5);
            font-weight: bold
        }

        .leave {
            color: rgb(11, 177, 228);
            font-weight: bold
        }

        .late {
            color: rgb(211, 226, 6);
            font-weight: bold
        }

        .missing {
            color: rgb(19, 78, 187);
            font-weight: bold
        }
    </style>
    <link rel="stylesheet" href="{{ asset('public/backend') }}/assets/vendor/libs/flatpickr/flatpickr.css" />
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            {{-- Breadcumbs --}}
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"> Attendnace Reconcilation </li>
                </ol>
            </nav>
            {{-- Search Panel --}}
            <div class="card">
                <div class="card-header">
                    <div class="row">

                        <div class="col-sm-12 col-md-12">
                            <form method="POST" action="{{ route('getSectionWiseStudentsReconcilationxl') }}"
                                id="attendanceForm">
                                <div class="row g-3 searchby">


                                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                                    <div class="col-sm-4">
                                        <label for="version_id" class="form-label">Version <span
                                                class="text-danger">*</span></label>
                                        <select id="version_id" name="version_id" class="form-select">
                                            <option value="">Select Version</option>
                                            @foreach ($versions as $version)
                                                <option value="{{ $version->id }}"
                                                    {{ isset($activity) && $activity->version_id == $version->id ? 'selected="selected"' : '' }}>
                                                    {{ $version->version_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="shift_id" class="form-label">Shift <span
                                                class="text-danger">*</span></label>
                                        <select id="shift_id" name="shift_id" class="form-select">
                                            <option value="">Select Shift</option>
                                            @foreach ($shifts as $shift)
                                                <option value="{{ $shift->id }}"
                                                    {{ isset($activity) && $activity->shift_id == $shift->id ? 'selected="selected"' : '' }}>
                                                    {{ $shift->shift_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="class_code" class="form-label">Class <span
                                                class="text-danger">*</span></label>
                                        <select id="class_code" name="class_code" class="form-select">
                                            <option value="">Select Class</option>
                                            @foreach ($classes as $class_code => $class_name)
                                                <option value="{{ $class_code }}"
                                                    {{ isset($activity) && $activity->class_code == $class_code ? 'selected="selected"' : '' }}>
                                                    {{ $class_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-3">
                                        <label for="section_id" class="form-label">Section <span
                                                class="text-danger">*</span></label>
                                        <select id="section_id" name="section_id" class="form-select">
                                            <option value="">Select Section</option>

                                        </select>
                                    </div>


                                    <div class="col-sm-3">
                                        <label for="start_date" class="form-label">
                                            Start Date <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" @if (Auth::user()->group_id == 3) disabled="disabled" @endif
                                            class="form-control  @if (Auth::user()->group_id != 3) flatpickr-validation flatpickr-input @endif"
                                            id="start_date" name="start_date" value="{{ $reconcilationDate->start_date }}"
                                            required placeholder="yyyy-mm-dd">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="end_date" class="form-label">
                                            End Date <span class="text-danger">*</span>
                                        </label>
                                        <input type="date"
                                            class="form-control @if (Auth::user()->group_id != 3) flatpickr-validation flatpickr-input @endif"
                                            id="end_date" value="{{ $reconcilationDate->end_date }}"
                                            @if (Auth::user()->group_id == 3) disabled="disabled" @endif name="end_date"
                                            required placeholder="yyyy-mm-dd">
                                    </div>

                                    <div class="col-sm-3 d-flex align-items-end">
                                        <div>
                                            <button type="button" id="search"
                                                class="btn btn-primary me-2">Search</button>
                                            @if (Auth::user()->is_view_user == 0)
                                                <button type="submit" id="xlexport"
                                                    class="btn btn-danger me-2">XL</button>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- Table --}}
                <div class="card-body mb-5">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="row">
                                <form action="#" method="POST" id="attendanceForm">
                                    @csrf


                                    <div class="col-sm-12 col-md-12">
                                        <div class="table-responsive scrollable rounded" id="attendanceTable">

                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="d-flex justify-content-end mt-2">
                                            <button type="submit" id="reconcile" class="btn btn-primary me-2"
                                                style="display: none;">Reconcile</button>
                                        </div>
                                    </div>
                                </form>
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
    {{-- <script>
        $(document).ready(function() {
            const allowedStartDate = new Date($('#allowedStartDate').val());
            const allowedEndDate = new Date($('#allowedEndDate').val());
            const today = new Date();
            if (today < allowedStartDate || today > allowedEndDate) {
                $('#reconcile').prop('disabled', true);
                Swal.fire({
                    title: "Warning!",
                    text: `Attendance reconciliation is allowed only from ${allowedStartDate.toDateString()} to ${allowedEndDate.toDateString()}.`,
                    icon: "warning",
                });
            }
        });
    </script> --}}
    <script notice="text/javascript">
        $(document).ready(function() {
            @if (Auth::user()->group_id == 3)
                console.log('loadStudentsBySection');
                loadStudentsBySection();
            @endif
            $(document.body).on('change', '#shift_id', function() {
                var shift_id = $('#shift_id').val();
                var version_id = $('#version_id').val();
                if (version_id && shift_id) {
                    var url = "{{ route('getClass') }}";
                    $.LoadingOverlay("show");
                    $.ajax({
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: url,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            shift_id,
                            version_id
                        },
                        success: function(response) {
                            $('#class_code').html(response);
                        },
                        error: function(data, errorThrown) {
                            handleError(data, errorThrown);
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
            $(document.body).on('click', '#search', function() {

                var section_id = $('#section_id').val();
                var start_date = $('#start_date').val();
                var end_date = $('#end_date').val();
                var version_id = $('#version_id').val();
                var shift_id = $('#shift_id').val();
                var class_code = $('#class_code').val();
                var url = "{{ route('getSectionWiseStudentsReconcilation') }}";
                $.LoadingOverlay("show");
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        start_date,
                        end_date,
                        section_id,
                        class_code,
                        shift_id,
                        version_id,
                    },
                    success: function(response) {
                        $('#attendanceTable').html(response);
                    },
                    error: function(data, errorThrown) {
                        handleError(data, errorThrown);
                    },
                    complete: function() {
                        $.LoadingOverlay("hide");
                    }
                });
            });

            $(document.body).on('change', '.adjust', function() {
                $.LoadingOverlay("show");
                var status = $(this).data('status');
                var student_code = $(this).data('code');
                var value = $(this).val();
                var current = $('#' + status + '_current' + student_code).val();
                var url = "{{ route('attendanceAdjustment') }}";
                $.LoadingOverlay("show");
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        status,
                        current,
                        student_code,
                        value
                    },
                    success: function(response) {
                        Swal.fire({
                            title: "Success",
                            text: `Update Successfully.`,
                            icon: "success",
                        });
                    },
                    error: function(data, errorThrown) {
                        handleError(data, errorThrown);
                    },
                    complete: function() {
                        $.LoadingOverlay("hide");
                    }
                });
            });
            $(document.body).on('click', '#reset', function() {
                $.LoadingOverlay("show");
                $('#class_code').val('');
                $('#shift_id').val('');
                $('#version_id').val('');
                $('#session_id').val('');
                $('#section_id').val('');
                $('#start_date').val('');
                $('#end_date').val('');
                $('#attendanceTable').html('');
                $('#reconcile').fadeOut();
                $.LoadingOverlay("hide");
            });
            // $(document.body).on('click', '#search', function() {

            //     var start_date = $('#start_date').val();
            //     var end_date = $('#end_date').val();
            //     var class_id = $('#class_code').val();
            //     var session_id = $('#session_id').val();
            //     var version_id = $('#version_id').val();
            //     var shift_id = $('#shift_id').val();
            //     var section_id = $('#section_id').val();
            //     var student_code = $('#student_code').val();

            //     if (section_id && start_date && end_date && version_id && shift_id && session_id &&
            //         class_id && student_code) {
            //         var url = "{{ route('attendance.getStudents') }}";
            //         $.LoadingOverlay("show");
            //         $.ajax({
            //             type: "get",
            //             headers: {
            //                 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            //             },
            //             url: url,
            //             data: {
            //                 "_token": "{{ csrf_token() }}",
            //                 session_id,
            //                 shift_id,
            //                 class_id,
            //                 section_id,
            //                 version_id,
            //                 start_date,
            //                 end_date,
            //                 student_code
            //             },
            //             success: function(response) {
            //                 console.log(response);
            //                 $('#attendanceTable').html(response);
            //                 var statisticsRows = $('#attendanceTable .statistics tbody tr')
            //                     .length;
            //                 var mainTableRows = $('#attendanceTable .main tbody tr').length;

            //                 // Toggle visibility of the reconcile button
            //                 if (statisticsRows === 0 || mainTableRows <= 1) {
            //                     $('#reconcile').fadeOut();
            //                 } else {
            //                     $('#reconcile').fadeIn();
            //                 }
            //             },
            //             error: function(data, errorThrown) {
            //                 handleError(data, errorThrown);
            //             },
            //             complete: function() {
            //                 $.LoadingOverlay("hide");
            //             }
            //         });
            //     } else {
            //         $('#attendanceTable').html('');
            //         $.LoadingOverlay("hide");

            //         Swal.fire({
            //             title: "Attention!",
            //             text: "Please Select All Required Fields.",
            //             icon: "warning"
            //         });
            //     }

            // });
            // Check all as present
            $(document.body).on('change', 'input[type=checkbox][name=all]', function() {

                if ($('#all').is(':checked')) {

                    $('table .form-check-input.Present').each(function() {

                        $(this).prop('checked', true);

                    });
                } else {

                    $('table .form-check-input').each(function() {

                        $(this).prop('checked', false);

                    });
                }

            });

            $('#reconcile').on('click', function(e) {
                e.preventDefault();
                // Get values from dropdowns and inputs
                $('#hidden_session_id').val($('#session_id').val());
                $('#hidden_version_id').val($('#version_id').val());
                $('#hidden_shift_id').val($('#shift_id').val());
                $('#hidden_class_code').val($('#class_code').val());
                $('#hidden_section_id').val($('#section_id').val());
                $('#hidden_end_date').val($('#end_date').val());
                $('#hidden_start_date').val($('#start_date').val());
                $('#hidden_student_id').val($('#student_code').val());


                console.log({
                    session_id: $('#hidden_session_id').val(),
                    version_id: $('#hidden_version_id').val(),
                    shift_id: $('#hidden_shift_id').val(),
                    class_code: $('#hidden_class_code').val(),
                    section_id: $('#hidden_section_id').val(),
                    end_date: $('#hidden_end_date').val(),
                    start_date: $('#hidden_start_date').val(),
                    student_code: $('#hidden_student_id').val()
                });
                // Submit the form
                $(this).closest('form').submit();

            });

            $('#attendanceForm').on('submit', function() {
                $.LoadingOverlay("show");
            });

            function handleSuccess(response, id) {
                Swal.fire({
                    title: "Good job!",
                    text: "Deleted successfully",
                    icon: "success"
                });
                $('#row' + id).remove();
            }

            function handleError(data, xhr) {
                const errorMessage = data?.responseJSON?.message || 'An error occurred';
                Swal.fire({
                    title: "Error",
                    text: errorMessage,
                    icon: "warning"
                });
            }

            function loadStudentsBySection() {
                var id = $('#section_id').val();
                if (id) {

                    var version_id = $('#version_id').val();
                    var shift_id = $('#shift_id').val();
                    var class_code = $('#class_code').val();
                    var url = "{{ route('getSectionWiseStudents') }}";
                    var start_date = $('#start_date').val();
                    var end_date = $('#end_date').val();
                    // Show loading overlay
                    $.LoadingOverlay("show");

                    // Make AJAX call
                    $.ajax({
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: url,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            section_id: id,
                            class_code,
                            start_date,
                            end_date,
                            shift_id,
                            version_id,
                        },
                        success: function(response) {
                            if (response) {
                                $('#attendanceTable').html(response);
                            }
                        },
                        error: function(data, errorThrown) {

                            handleError(data, errorThrown);
                        },
                        complete: function() {
                            $.LoadingOverlay("hide");
                        }
                    });
                } else {
                    // Clear the student dropdown if no section is selected
                    $('#student_code').html('<option value="">Select a section first</option>');
                }
            }

        });
    </script>
@endsection
