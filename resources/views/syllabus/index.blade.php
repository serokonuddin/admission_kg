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

        .form-label {

            width: 100%;
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

                    <li class="breadcrumb-item active" aria-current="page"> Syllabus </li>

                </ol>
            </nav>
            <!-- Basic Bootstrap Table -->
            <div class="card">
                @if (Auth::user()->is_view_user == 0)
                    <div class="card-header" style="text-align: right">
                        <a href="{{ route('syllabus.create') }}" class=" btn btn-round btn-info">Create Syllabus</a>
                    </div>
                @endif
                <div class="card-body">
                    <div class="row mb-5">
                        <div class="col-sm-12 col-md-12">
                            <div class="dataTables_length" id="DataTables_Table_0_length" style="padding: 5px">
                                <form id="formAccountSettings" method="get" action="{{ route('syllabus.index') }}">
                                    <div class="row g-3 searchby">
                                        <div class="col-sm-3">
                                            <label class="form-label">
                                                <select id="session_id" name="session_id" class=" form-select">
                                                    <option value="">Select Session</option>
                                                    @foreach ($sessions as $session)
                                                        <option value="{{ $session->id }}">
                                                            {{ $session->session_name }}</option>
                                                    @endforeach
                                                </select>
                                            </label>
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="form-label">
                                                <select id="version_id" name="version_id" class=" form-select"
                                                    required="">
                                                    <option value="">Select Version</option>
                                                    @foreach ($versions as $version)
                                                        <option value="{{ $version->id }}">
                                                            {{ $version->version_name }}</option>
                                                    @endforeach

                                                </select>
                                            </label>
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="form-label">
                                                <select id="shift_id" name="shift_id" class=" form-select" required="">
                                                    <option value="">Select Shift</option>
                                                    @foreach ($shifts as $shift)
                                                        <option value="{{ $shift->id }}">
                                                            {{ $shift->shift_name }}</option>
                                                    @endforeach

                                                </select>
                                            </label>
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="form-label">
                                                <select id="group_id" name="group_id" class=" form-select">
                                                    <option value="">Select Group</option>
                                                    @foreach ($groups as $group => $group_name)
                                                        <option value="{{ $group }}">
                                                            {{ $group_name }}</option>
                                                    @endforeach
                                                </select>
                                            </label>
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="form-label">
                                                <select id="class_code" name="class_code" class=" form-select"
                                                    required="">
                                                    <option value="">Select Class</option>
                                                    @foreach ($classes as $class_code => $class_name)
                                                        <option value="{{ $class_code }}">

                                                            {{ $class_name }}</option>
                                                    @endforeach
                                                </select>
                                            </label>
                                        </div>

                                        <div class="col-sm-3">
                                            <label class="form-label">
                                                <select id="subject_id" name="subject_id" class=" form-select">
                                                    <option value="">Select Subject</option>

                                                </select>
                                            </label>
                                        </div>
                                        <div class="col-sm-3">
                                            <button id="reset" class="btn btn-danger me-2">Reset</button>
                                            <button type="submit" id="search"
                                                class="btn btn-primary me-2">Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table pt-2" id="headerTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Session</th>
                                    <th>Version</th>
                                    <th>Class</th>
                                    <th>Subject</th>
                                    <th>Details</th>
                                    <th>PDF</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($syllabuss as $key => $syllabus)
                                    <tr id="row{{ $syllabus->id }}">
                                        <td scope="row">{{ $key + 1 }}</td>
                                        <td>{{ $syllabus->session->session_name ?? '' }}</td>
                                        <td>{{ $syllabus->version->version_name ?? '' }}</td>
                                        <td>{{ $syllabus->classes->class_name ?? '' }}</td>
                                        <td>{{ $syllabus->subject->subject_name ?? '' }}</td>
                                        <td>{!! $syllabus->details ?? '' !!}</td>
                                        <td>
                                            @if ($syllabus->pdf)
                                                <a href="{{ $syllabus->pdf }}" target="_blank"
                                                    class="btn btn-success btn-sm">View</a>
                                            @else
                                                <button class="btn btn-danger btn-sm">No PDF Available</button>
                                            @endif
                                        </td>
                                        <td>
                                            @if (Auth::user()->is_view_user == 0)
                                                <div class="dropdown">
                                                    <button syllabus="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown" aria-expanded="false"><i
                                                            class="bx bx-dots-vertical-rounded"></i></button>
                                                    <div class="dropdown-menu" style="">
                                                        <a class="dropdown-item edit"
                                                            href="{{ route('syllabus.edit', $syllabus->id) }}"><i
                                                                class="bx bx-edit-alt me-1"></i> Edit</a>
                                                        <a class="dropdown-item delete"
                                                            data-url="{{ route('syllabus.destroy', $syllabus->id) }}"
                                                            data-id="{{ $syllabus->id }}" href="javascript:void(0);"><i
                                                                class="bx bx-trash me-1"></i> Delete</a>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Modal -->
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
    <script notice="text/javascript">
        $(document).ready(function() {
            $('#headerTable').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        className: 'btn btn-primary btn-sm'
                    },
                    {
                        extend: 'csv',
                        className: 'btn btn-success btn-sm'
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-warning btn-sm'
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-danger btn-sm'
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-info btn-sm'
                    }
                ]
            });
            $(document.body).on('change', '#class_code', function() {
                var id = $(this).val();
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
                        class_id: id,
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

            $(document.body).on('click', '#reset', function() {
                $.LoadingOverlay("show");
                $('#class_code').val('');
                $('#shift_id').val('');
                $('#group_id').val('');
                $('#version_id').val('');
                $('#session_id').val('');
                $.LoadingOverlay("hide");
            });
            $(document.body).on('click', '.control', function() {
                var id = $(this).data('id');
                $('.childdata' + id).toggle();
            });
            $(document.body).on('click', '.delete', function() {
                var id = $(this).data('id');
                var url = $(this).data('url');
                Swal.fire({
                    title: 'Do you want to delete this Syllabus?',
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
                        $.LoadingOverlay("show");
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
                                handleSuccess(response, id);
                            },
                            error: function(data, errorThrown) {
                                handleError(data, errorThrown);
                            },
                            complete: function() {
                                $.LoadingOverlay("hide");
                            }
                        });
                    } else if (result.isDenied) {
                        console.log('Denied');
                    }
                })
            });

            function handleSuccess(response, id) {
                console.log(response + 'success');
                Swal.fire({
                    title: "Good job!",
                    text: "Deleted successfully",
                    icon: "success"
                });
                $('#row' + id).remove();
            }

            function handleError(data, xhr) {
                console.log(data + 'success');
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
