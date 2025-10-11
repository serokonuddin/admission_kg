@extends('admin.layouts.layout')
@section('content')
    <style>
        input[readonly] {
            background-color: #f6f6f6 !important;
        }

        td,
        th {
            border: 1px solid #333;
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
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">Dashboard /</span> Exam Time Schedules
            </h4>
            <div class="col-md mb-4 mb-md-0">
                <div class="card">
                    <div class="card-body">
                        <div class="col-sm-12 col-md-12 p-10 m-r-10" style="text-align: right">
                            @if (Auth::user()->is_view_user == 0)
                                <a href="{{ route('exam-time-shedules.create') }}" class=" btn btn-round btn-info">Create
                                    Exam
                                    Time Schedules</a>
                            @endif
                        </div>
                        <form id="formAccountSettings" method="POST" action="#">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="session_id" class="form-label">Session <span
                                            style="color: red">*</span></label>
                                    <select id="session_id" name="session_id" class=" form-select" required="">
                                        <option value="">Select Session</option>
                                        @foreach ($sessions as $session)
                                            <option value="{{ $session->id }}">{{ $session->session_name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="class_code" class="form-label">Class <span
                                            style="color: red">*</span></label>
                                    <select id="class_code" name="class_code" class=" form-select" required="">
                                        <option value="">Select Class</option>
                                        <option value="0">KG</option>
                                        <option value="1">CLass I</option>
                                        <option value="2">CLass II</option>
                                        <option value="3">CLass III</option>
                                        <option value="4">CLass IV</option>
                                        <option value="5">CLass V</option>
                                        <option value="6">CLass VI</option>
                                        <option value="7">CLass VII</option>
                                        <option value="8">CLass VIII</option>
                                        <option value="9">CLass IX</option>
                                        <option value="10">CLass X</option>
                                        <option value="11">CLass XI</option>
                                        <option value="12">CLass XII</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="exam_id" class="form-label">Exam <span style="color: red">*</span></label>
                                    <select id="exam_id" name="exam_id" class=" form-select" required="">
                                        <option value="">Select Exam</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="subject_id" class="form-label">Subject</label>
                                    <select id="subject_id" name="subject_id" class=" form-select" required="">
                                        <option value="">Select Subject</option>
                                    </select>
                                </div>
                                <div class="mb-3  col-md-2">
                                    <label class="form-label" for="amount"> </label>
                                    <button type="button" id="searchtop"
                                        class="btn btn-primary form-control me-2 mt-1">Search</button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive text-nowrap fixed" id="tabledata" style="padding: 10px;">
                            <table class="table " id="headerTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Session</th>
                                        <th>Class Code</th>
                                        <th>Exam </th>
                                        <th>Subject</th>
                                        <th>Exam For</th>
                                        <th>Exam Date</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        @if (Auth::user()->is_view_user == 0)
                                            <th>Actions</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($schedules as $schedule)
                                        <tr>
                                            <td>{{ $schedule->id }}</td>
                                            <td>{{ optional($schedule->session)->session_name }}</td>
                                            <td>{{ $schedule->class_code ?? '' }}</td>
                                            <td>{{ $schedule->exam->exam_title . ' ' . $schedule->session->session_name . ' (class:' . ($schedule->class_code ? $schedule->class_code : 'KG') . ')' }}
                                            </td>
                                            {{-- <td>{{ $schedule->subject->subject_name }}</td> --}}
                                            <td>{{ optional($schedule->subject)->subject_name }}</td>
                                            <td>{{ $schedule->exam_for == 1 ? 'Written & MCQ' : 'Practical' }}</td>
                                            <td>{{ $schedule->exam_date ?? '' }}</td>
                                            <td>{{ $schedule->start_time ?? '' }}</td>
                                            <td>{{ $schedule->end_time ?? '' }}</td>
                                            @if (Auth::user()->is_view_user == 0)
                                                <td>
                                                    <a href="{{ route('exam-time-shedules.edit', $schedule->id) }}"
                                                        class="btn btn-warning">Edit</a>
                                                    <form action="{{ route('exam-time-shedules.destroy', $schedule->id) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->
        <div class="content-backdrop fade"></div>
    </div>
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

                        },
                        complete: function() {
                            $.LoadingOverlay("hide");
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
                var exam_id = $('#exam_id').val();

                if (exam_id && session_id && class_code) {
                    $.LoadingOverlay("show");
                    $.ajax({
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: "{{ route('getExamTimeShedules') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            session_id,
                            class_code,
                            subject_id,
                            exam_id
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
            $(document.body).on('click', '.update', function() {
                var classid = $(this).data('classid');
                if ($('#amount' + classid).prop("readonly") == true) {
                    $('#effective_from' + classid).prop('readonly', false);
                    $('#amount' + classid).prop('readonly', false);
                } else {
                    $('#effective_from' + classid).prop('readonly', true);
                    $('#amount' + classid).prop('readonly', true);
                }
                $('#submit').text('Update');
            });


            $(document.body).on('click', '.delete', function() {
                var id = $(this).data('id');
                var url = $(this).data('url');
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

                    },
                    complete: function() {
                        $.LoadingOverlay("hide");
                    }
                });
            });

        });
    </script>
@endsection
