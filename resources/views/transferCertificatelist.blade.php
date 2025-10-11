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

        .form-label {
            width: 100% !important;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            {{-- <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Students TC</h4> --}}
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"> Students TC</li>
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
                                                <option value="">Select Session</option>
                                                @foreach ($sessions as $session)
                                                    <option value="{{ $session->id }}"
                                                        {{ $session_id == $session->id ? 'selected="selected"' : '' }}>
                                                        {{ $session->session_name }}</option>
                                                @endforeach

                                            </select>
                                        </label>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-label">
                                            <select id="version_id" name="version_id" class=" form-select" required="">
                                                <option value="">Select Version</option>
                                                @foreach ($versions as $version)
                                                    <option value="{{ $version->id }}"
                                                        {{ $version_id == $version->id ? 'selected="selected"' : '' }}>
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
                                                    <option value="{{ $shift->id }}"
                                                        {{ $shift_id == $shift->id ? 'selected="selected"' : '' }}>
                                                        {{ $shift->shift_name }}</option>
                                                @endforeach

                                            </select>
                                        </label>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-label">

                                            <select id="class_id" name="class_id" class=" form-select" required="">
                                                <option value="" {{ empty($class_code) ? 'selected' : '' }}>Select
                                                    Class</option>
                                                <option {{ isset($class_code) && $class_code == 0 ? 'selected' : '' }}
                                                    value="0">KG</option>
                                                <option {{ isset($class_code) && $class_code == 1 ? 'selected' : '' }}
                                                    value="1">Class I</option>
                                                <option {{ isset($class_code) && $class_code == 2 ? 'selected' : '' }}
                                                    value="2">Class II</option>
                                                <option {{ isset($class_code) && $class_code == 3 ? 'selected' : '' }}
                                                    value="3">Class III</option>
                                                <option {{ isset($class_code) && $class_code == 4 ? 'selected' : '' }}
                                                    value="4">Class IV</option>
                                                <option {{ isset($class_code) && $class_code == 5 ? 'selected' : '' }}
                                                    value="5">Class V</option>
                                                <option {{ isset($class_code) && $class_code == 6 ? 'selected' : '' }}
                                                    value="6">Class VI</option>
                                                <option {{ isset($class_code) && $class_code == 7 ? 'selected' : '' }}
                                                    value="7">Class VII</option>
                                                <option {{ isset($class_code) && $class_code == 8 ? 'selected' : '' }}
                                                    value="8">Class VIII</option>
                                                <option {{ isset($class_code) && $class_code == 9 ? 'selected' : '' }}
                                                    value="9">Class IX</option>
                                                <option {{ isset($class_code) && $class_code == 10 ? 'selected' : '' }}
                                                    value="10">Class X</option>
                                                <option {{ isset($class_code) && $class_code == 11 ? 'selected' : '' }}
                                                    value="11">Class XI</option>
                                                <option {{ isset($class_code) && $class_code == 12 ? 'selected' : '' }}
                                                    value="12">Class XII</option>
                                            </select>
                                        </label>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-label">
                                            <select id="section_id" name="section_id" class=" form-select" required="">
                                                <option value="">Select Section</option>
                                                @foreach ($sections as $section)
                                                    <option value="{{ $section->id }}"
                                                        {{ $section_id == $section->id ? 'selected="selected"' : '' }}>
                                                        {{ $section->section_name }}</option>
                                                @endforeach

                                            </select>
                                        </label>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-label">
                                            <input type="text" name="text_search" class="form-control" id="text_search"
                                                value="{{ $text_search }}" placeholder="search by name,id,mobile,email" />
                                    </div>
                                    <div class="col-sm-3">
                                        <label>
                                            <button type="button" id="searchtop"
                                                class="btn btn-primary me-2">Search</button>
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- <div class="col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end">
                                                                                       <div style="padding: 5px" id="DataTables_Table_1_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control" id="search" placeholder="" aria-controls="DataTables_Table_1"></label></div>
                                                                                    </div> -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <!-- <div class="dataTables_length" id="DataTables_Table_0_length">
                                                                                        <label>
                                                                                            Show
                                                                                            <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="form-select">
                                                                                              <option value="7">7</option>
                                                                                              <option value="10">10</option>
                                                                                              <option value="25">25</option>
                                                                                              <option value="50">50</option>
                                                                                              <option value="75">75</option>
                                                                                              <option value="100">100</option>
                                                                                            </select>
                                                                                            entries
                                                                                        </label>
                                                                                      </div> -->
                    </div>
                    {{-- <div class="col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end mt-n6 mt-md-0">
                        <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>Search:<input type="text"
                                    id="search" class="form-control" value="{{ request('search') }}"
                                    placeholder="Search..." aria-controls="DataTables_Table_0"></label></div>
                    </div> --}}
                </div>
                <div class="card-body">
                    <div class="table-responsive " id="item-list">
                        @if ($students->isEmpty())
                            <p class="text-center alert alert-warning">No students found. Use the search form to find
                                students.</p>
                        @else
                            <table class="table" id="headerTable">
                                <thead class="table-dark">
                                    <tr>
                                        <!-- <th>#</th> -->
                                        <th>Roll</th>
                                        <th>Name/Email/Phone</th>
                                        <th>Shift</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Reason</th>
                                        <th>TC Generated By</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($students as $student)
                                        <tr id="row{{ $student->id }}">
                                            <td>
                                                {{ $student->studentActivity->roll ?? 'N/A' }}
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <div>
                                                        <img src="{{ $student->photo ?? asset('public/student.png') }}"
                                                            alt="Avatar" class="rounded-circle"
                                                            style="width: 50px; height: 50px; object-fit: cover; margin-right: 15px;" />
                                                    </div>
                                                    <div>
                                                        <span class="fw-bold d-block">
                                                            {{ $student->first_name . ' ' . $student->last_name ?? 'N/A' }}
                                                        </span>
                                                        <small class="text-muted d-block">
                                                            {{ $student->email ?? 'Email not available' }}
                                                        </small>
                                                        <small class="text-muted d-block">
                                                            {{ $student->mobile ?? 'Phone not available' }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $student->studentActivity->shift->shift_name ?? 'N/A' }}
                                            </td>
                                            <td>
                                                {{ $student->studentActivity->classes->class_name ?? 'N/A' }}
                                            </td>
                                            <td>
                                                {{ $student->studentActivity->section->section_name ?? 'N/A' }}
                                            </td>
                                            <td>
                                                {{ $student->studentActivity->reason_for_tc ?? 'N/A' }}
                                            </td>
                                            <td>
                                                {{ $student->generated_by ?? 'N/A' }}
                                            </td>
                                            <td>
                                                <a class="btn btn-success"
                                                    href="{{ route('getCertificate', $student->student_code) }}"
                                                    target="_blank">
                                                    Download
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_3_paginate"
                                style="padding: 10px">
                                {{ $students->links('pagination') }}

                                {!! $students->appends([
                                        'search' => request('search'),
                                        'shift_id' => request('shift_id'),
                                        'version_id' => request('version_id'),
                                        'session_id' => request('session_id'),
                                        'class_code' => request('class_code'),
                                        'section_id' => request('section_id'),
                                        'text_search' => request('text_search'),
                                        'searchQuery' => request('searchQuery'),
                                    ])->links('bootstrap-4') !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="fullscreenModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalFullTitle">Student Profile</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="background-color: #f5f2f2">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->

        <div class="content-backdrop fade"></div>
    </div>
    <script>
        $(function() {


            $('#search').on('change', function() {

                fetch_data(1); // Start from the first page when searching
            });
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];

                fetch_data(page);
            });
        });
        var url = "{{ route('showCertificateList') }}"

        function fetch_data(page) {
            var searchQuery = $('#search').val();
            var session_id = $('#session_id').val();
            var version_id = $('#version_id').val();
            var shift_id = $('#shift_id').val();
            var class_code = $('#class_id').val();
            var section_id = $('#section_id').val();
            var text_search = $('#text_search').val();
            var searchtext = ' & shift_id=' + shift_id + ' & version_id=' + version_id + '& class_code=' + class_code +
                '& section_id=' + section_id + '& session_id=' + session_id + '& text_search=' + text_search + '& search=' +
                searchQuery;
            url = "{{ route('showCertificateList') }}";
            $.ajax({
                url: url + "?page=" + page + searchtext,
                success: function(data) {
                    $('#item-list').html(data);
                    window.history.pushState("", "", '?page=' + page + searchtext);
                }
            });
        }
    </script>
    <!-- <script>
        $(document).ready(function() {
            $('#headerTable').DataTable({
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                "pagingType": "full_numbers", // Optional: This gives you 'First', 'Previous', 'Next', 'Last' buttons
                "dom": 'lfrtip', // 'l' indicates the length menu dropdown
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script> -->
    <script type="text/javascript">
        $(function() {
            $(document.body).on('change', '.attendance_search', function() {
                var start_date = $('#start_date').val();
                var end_date = $('#end_date').val();
                var student_code = $('#student_code_value').val();
                var url = "{{ route('getAttendanceByDate') }}";
                if (start_date && end_date) {
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
                            student_code
                        },
                        success: function(response) {
                            $.LoadingOverlay("hide");
                            $('#attendanceDetails').html(response);


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
            $(document.body).on('click', '#searchtop', function() {
                var session_id = $('#session_id').val();
                var version_id = $('#version_id').val();
                var shift_id = $('#shift_id').val();
                var class_code = $('#class_id').val();
                var section_id = $('#section_id').val();
                var text_search = $('#text_search').val();
                location.href = "{{ route('showCertificateList') }}" + '?shift_id=' + shift_id +
                    ' & version_id=' + version_id + '& class_code=' + class_code + '& section_id=' +
                    section_id + '& session_id=' + session_id + '& text_search=' + text_search;





            });
            $(document.body).on('change', '#search_by', function() {
                if ($('#search').val() && $(this).val()) {
                    location.href = "{{ route('showCertificateList') }}" + '?search_by=' + $(this).val() +
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
                // if(version_id && shift_id){
                //    var url="{{ route('getClass') }}";
                //    $.LoadingOverlay("show");
                //    $.ajax({
                //        type: "post",
                //        headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                //        url: url,
                //        data:{"_token": "{{ csrf_token() }}",shift_id,version_id},
                //        success: function(response){
                //          $.LoadingOverlay("hide");
                //                $('#class_id').html(response);
                //                $('#section_id').html('');

                //        },
                //        error: function(data, errorThrown)
                //        {
                //          $.LoadingOverlay("hide");
                //            Swal.fire({
                //                title: "Error",
                //                text: errorThrown,
                //                icon: "warning"
                //            });

                //        }
                //    });
                // }
            });
            $(document.body).on('change', '#version_id', function() {

                var shift_id = $('#shift_id').val();
                var version_id = $('#version_id').val();
                //  if(version_id && shift_id){
                //     var url="{{ route('getClass') }}";
                //     $.LoadingOverlay("show");
                //     $.ajax({
                //         type: "post",
                //         headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                //         url: url,
                //         data:{"_token": "{{ csrf_token() }}",shift_id,version_id},
                //         success: function(response){
                //           $.LoadingOverlay("hide");
                //                 $('#class_id').html(response);
                //                 $('#section_id').html('');

                //         },
                //         error: function(data, errorThrown)
                //         {
                //           $.LoadingOverlay("hide");
                //             Swal.fire({
                //                 title: "Error",
                //                 text: errorThrown,
                //                 icon: "warning"
                //             });

                //         }
                //     });
                //  }

            });
            $(document.body).on('click', '.delete', function() {
                var id = $(this).data('id');
                var url = $(this).data('url');
                Swal.fire({
                    title: 'Do you want to Delete this Student?',
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
@endsection
