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
            font-size: 11px !important;
        }

        .form-label {
            width: 100% !important;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            {{-- <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> ID Card</h4> --}}
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"> ID Card</li>
                </ol>
            </nav>
            <!-- Basic Bootstrap Table -->
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="dataTables_length" id="DataTables_Table_0_length" style="padding: 5px">
                                <div class="row g-3 searchby">
                                    <div class="col-sm-3">
                                        <label class="form-label">
                                            <select id="session_id" name="session_id" class=" form-select" required="">

                                                @foreach ($sessions as $session)
                                                    <option value="{{ $session->id }}">{{ $session->session_name }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </label>
                                    </div>

                                    <div class="col-sm-3">
                                        <label class="form-label">
                                            <select id="version_id" name="version_id" class=" form-select">
                                                <option value="">Select Version</option>
                                                <option value="1">Bangla</option>
                                                <option value="2">English</option>
                                            </select>
                                        </label>
                                    </div>

                                    <div class="col-sm-3">
                                        <label class="form-label">
                                            <select id="shift_id" name="shift_id" class=" form-select">
                                                <option value="">Select Shift</option>
                                                <option value="1">Morning</option>
                                                <option value="2">Day</option>
                                            </select>
                                        </label>
                                    </div>

                                    <div class="col-sm-3">
                                        <label class="form-label">

                                            <select id="class_id" name="class_id" class=" form-select" required="">
                                                <option value="">Select Class</option>
                                                <option value="0">KG</option>
                                            </select>
                                        </label>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-label">
                                            <select id="section_id" name="section_id" class=" form-select" required="">
                                                <option value="">Select Section</option>

                                            </select>
                                        </label>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-label">
                                            <input type="text" name="text_search" class="form-control" id="text_search"
                                                placeholder="search by name, roll, mobile" />
                                    </div>
                                    <div class="col-sm-3">
                                        <label>

                                            <button type="button" id="search"
                                                class="btn btn-primary me-2">Print</button>


                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->

        </div>
        <!-- / Content -->

        <div class="content-backdrop fade"></div>
        <iframe id="txtArea1" style="display:none"></iframe>
    </div>
    <script type="text/javascript">
        $(function() {

            $(document.body).on('click', '.studentinfo', function() {
                var student_code = $(this).data('studentcode');
                var session_id = $('#session_id').val();
                var url = "{{ route('getStudentDetails') }}";
                $.LoadingOverlay("show");
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        student_code,
                        session_id
                    },
                    success: function(response) {
                        $.LoadingOverlay("hide");
                        $('.modal-body').html(response);


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
                $('#fullscreenModal').modal('show');
            });
            $(document.body).on('click', '#search', function() {
                var session_id = $('#session_id').val();
                var section_id = $('#section_id').val();
                var class_id = $('#class_id').val();
                var text_search = $('#text_search').val();
                var url = "{{ route('admissionIdCard') }}" + '?session_id=' + session_id + '& class_id=' +
                    class_id + '& section_id=' + section_id + '& text_search=' + text_search;
                window.open(url, '_blank');
            });
            $(document.body).on('click', '#print-view', function() {
                var session_id = $('#session_id').val();
                var version_id = $('#version_id').val();
                var shift_id = $('#shift_id').val();
                var class_id = $('#class_id').val();
                var section_id = $('#section_id').val();
                var text_search = $('#text_search').val();
                var print = 1;

                window.open("{{ route('admissionlist.index') }}" + '?shift_id=' + shift_id +
                    ' & version_id=' + version_id + '& class_id=' + class_id + '& section_id=' +
                    section_id + '& session_id=' + session_id + '& text_search=' + text_search +
                    '& print=' + print);

            });
            $(document.body).on('change', '#search_by', function() {
                if ($('#search').val() && $(this).val()) {
                    location.href = "{{ route('students.index') }}" + '?search_by=' + $(this).val() +
                        ' & search=' + $('#search').val();
                }


            });
        });

        $(function() {


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
            });
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
                            $.LoadingOverlay("hide");
                            $('#class_id').html(response);
                            $('#section_id').html('');

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
            $(document.body).on('change', '#version_id', function() {

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
                            $.LoadingOverlay("hide");
                            $('#class_id').html(response);
                            $('#section_id').html('');

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

        });
    </script>
@endsection
