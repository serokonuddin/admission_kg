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
    @php
        function getClassName($code)
        {
            $roman = [
                0 => 'Class Kg',
                1 => 'Class I',
                2 => 'Class II',
                3 => 'Class III',
                4 => 'Class IV',
                5 => 'Class V',
                6 => 'Class VI',
                7 => 'Class VII',
                8 => 'Class VIII',
                9 => 'Class IX',
                10 => 'Class X',
                11 => 'Class XI',
                12 => 'Class XII',
            ];
            return $roman[$code];
        }
    @endphp
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            {{-- <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">Dashboard /</span> Student Attendence
            </h4> --}}
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"> Student Attendence</li>
                </ol>
            </nav>

            <div class="col-md mb-4 mb-md-0">
                <div class="card">

                    <div class="card-header">

                        <form id="formAccountSettings" method="POST" action="{{ route('storeAttendance') }}">

                            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />

                            <div class="row">

                                <div class="mb-3 col-md-4">
                                    <label for="session_id" class="form-label">Session <span
                                            style="color: red">*</span></label>
                                    <select id="session_id" name="session_id" class="form-select" required>
                                        <option value="">Select Session</option>
                                        @foreach ($sessions as $session)
                                            <option value="{{ $session->id }}"
                                                {{ Session::get('session_id') == $session->id ? 'selected' : '' }}>
                                                {{ $session->session_name }}
                                            </option>
                                        @endforeach
                                    </select>


                                </div>

                                <div class="mb-3 col-md-4">
                                    <label for="class_code" class="form-label">
                                        Class <span style="color: red">*</span>
                                    </label>
                                    <select id="class_code" name="class_code" class="form-select" required>
                                        @if (Auth::user()->group_id == 3)
                                            @foreach ($classdata as $class)
                                                <option value="{{ $class->class_code }}"
                                                    {{ Session::get('class_code') == $class->class_code ? 'selected="selected"' : '' }}>
                                                    {{ getClassName($class->class_code) }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option value="">Select Class</option>
                                            <option value="0"
                                                {{ Session::get('class_code') === '0' ? 'selected="selected"' : '' }}>KG
                                            </option>
                                            <option value="1"
                                                {{ Session::get('class_code') === '1' ? 'selected="selected"' : '' }}>
                                                Class I</option>
                                            <option value="2"
                                                {{ Session::get('class_code') === '2' ? 'selected="selected"' : '' }}>
                                                Class II</option>
                                            <option value="3"
                                                {{ Session::get('class_code') === '3' ? 'selected="selected"' : '' }}>
                                                Class III</option>
                                            <option value="4"
                                                {{ Session::get('class_code') === '4' ? 'selected="selected"' : '' }}>
                                                Class IV</option>
                                            <option value="5"
                                                {{ Session::get('class_code') === '5' ? 'selected="selected"' : '' }}>
                                                Class V</option>
                                            <option value="6"
                                                {{ Session::get('class_code') === '6' ? 'selected="selected"' : '' }}>
                                                Class VI</option>
                                            <option value="7"
                                                {{ Session::get('class_code') === '7' ? 'selected="selected"' : '' }}>
                                                Class VII</option>
                                            <option value="8"
                                                {{ Session::get('class_code') === '8' ? 'selected="selected"' : '' }}>
                                                Class VIII</option>
                                            <option value="9"
                                                {{ Session::get('class_code') === '9' ? 'selected="selected"' : '' }}>
                                                Class IX</option>
                                            <option value="10"
                                                {{ Session::get('class_code') === '10' ? 'selected="selected"' : '' }}>
                                                Class X</option>
                                            <option value="11"
                                                {{ Session::get('class_code') === '11' ? 'selected="selected"' : '' }}>
                                                Class XI</option>
                                            <option value="12"
                                                {{ Session::get('class_code') === '12' ? 'selected="selected"' : '' }}>
                                                Class XII</option>
                                        @endif
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
                                {{-- <div class="mb-3  col-md-2">
                                <label class="form-label" for="amount"> </label>
                                <button type="button" id="searchtop" class="btn btn-primary form-control me-2 mt-1">Search</button>

                            </div> --}}
                            </div>

                            <div class="d-flex align-items-center mb-3 mt-4">
                                <label for="no_of_working_days" class="form-label fw-bold me-2">
                                    <span style="font-size: 20px;">Number of Working Days:</span>
                                </label>
                                <input type="number" name="no_of_working_days" class="form-control w-auto"
                                    id="no_of_working_days" required>
                            </div>

                            <br>
                            <div id="students-container">
                                <!-- Students will be loaded here -->
                            </div>

                            <button type="submit" class="btn btn-success mt-3 px-5 py-2 fw-bold shadow"
                                style="font-size: 16px; background-color: #28a745; border-color: #28a745;">
                                Save Attendance
                            </button>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-container text-nowrap" id="tabledata">
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Browser Default -->
            <!-- Bootstrap Validation -->


        </div>
        <!-- / Content -->

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
        $(document).ready(function() {
            $('#session_id, #class_code, #section_id, #exam_id').change(function() {
                const session_id = $('#session_id').val();
                const class_code = $('#class_code').val();
                const section_id = $('#section_id').val();
                const exam_id = $('#exam_id').val();

                if (session_id && class_code && section_id && exam_id) {
                    $.ajax({
                        url: "{{ route('getStudentsExamAttendence') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            session_id: session_id,
                            class_code: class_code,
                            section_id: section_id,
                            exam_id: exam_id,
                        },
                        success: function(response) {
                            // Set the value of No of Working Days
                            $('#no_of_working_days').val(response.no_of_working_days || '');

                            // Generate students table
                            let studentsHtml = `
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Student Name</th>
                                    <th>Roll</th>
                                    <th>Total Attendance</th>
                                </tr>
                            </thead>
                            <tbody>`;
                            response.students.forEach((student, index) => {
                                let totalAttendance = student.attendance ? student
                                    .attendance.total_attendance : '';
                                studentsHtml += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${student.first_name}</td>
                                <td>${student.roll}</td>
                                <td>
                                    <input type="number" class="form-control"
                                           name="students[${student.student_code}][total_attendance]"
                                           value="${totalAttendance}" placeholder="Total Attendance">
                                    <input type="hidden" name="students[${student.student_code}][id]" value="${student.student_code}">
                                </td>
                            </tr>`;
                            });
                            studentsHtml += `</tbody></table>`;
                            $('#students-container').html(studentsHtml);
                        },
                        error: function(xhr, status, error) {
                            console.log("AJAX Error: ", error);
                        },
                    });
                } else {
                    $('#students-container').html('');
                }
            });
        });
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
        @if (Session::get('class_code') || Session::get('session_id'))
            setTimeout(function() {
                // Set time to 10:30 AM after the delay
                $.LoadingOverlay("show");
                getHeaderinfo({{ Session::get('class_code') }}, {{ Session::get('session_id') }})
            }, 500);

            function getHeaderinfo(class_code, session_id) {
                // $.ajax({
                //             type: "post",
                //             headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                //             url: "{{ route('getSubjects') }}",
                //             data:{"_token": "{{ csrf_token() }}",class_code},
                //             success: function(response){
                //                 $('#subject_id').html(response);

                //             },
                //             error: function(data, errorThrown)
                //             {
                //                 Swal.fire({
                //                     title: "Error",
                //                     text: errorThrown,
                //                     icon: "warning"
                //                 });

                //             }
                //         });

                // $.ajax({
                //     type: "post",
                //     headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                //     url: "{{ route('getSections') }}",
                //     data:{"_token": "{{ csrf_token() }}","class_id":class_code},
                //     success: function(response){
                //         $('#section_id').html(response);

                //     },
                //     error: function(data, errorThrown)
                //     {
                //         Swal.fire({
                //             title: "Error",
                //             text: errorThrown,
                //             icon: "warning"
                //         });

                //     }
                // });
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
        @endif
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
        $(function() {
            $(document.body).on('change', '#class_code', function() {
                var session_id = $('#session_id').val();
                var class_code = $('#class_code').val();
                $.LoadingOverlay("show");
                if (class_code) {

                    // $.ajax({
                    //     type: "post",
                    //     headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                    //     url: "{{ route('getSubjects') }}",
                    //     data:{"_token": "{{ csrf_token() }}",class_code},
                    //     success: function(response){
                    //         $('#subject_id').html(response);

                    //     },
                    //     error: function(data, errorThrown)
                    //     {
                    //         Swal.fire({
                    //             title: "Error",
                    //             text: errorThrown,
                    //             icon: "warning"
                    //         });

                    //     }
                    // });

                    // $.ajax({
                    //     type: "post",
                    //     headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                    //     url: "{{ route('getSections') }}",
                    //     data:{"_token": "{{ csrf_token() }}","class_id":class_code},
                    //     success: function(response){
                    //         $('#section_id').html(response);

                    //     },
                    //     error: function(data, errorThrown)
                    //     {
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
            $(document.body).on('click', '#searchtop', function() {
                var session_id = $('#session_id').val();
                var class_code = $('#class_code').val();
                // var subject_id=$('#subject_id').val();
                var section_id = $('#section_id').val();
                var exam_id = $('#exam_id').val();
                // var version_id=$('#version_id').val();
                // var group_id=$('#group_id').val();
                var getdata = 0;
                if (session_id && class_code && section_id && exam_id) {
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
                            section_id,
                            exam_id
                        },
                        success: function(response) {
                            $('#tabledata').html(response);
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
                } else {
                    Swal.fire({
                        title: "Error",
                        text: 'Asterisk(*) fields need to be completed.',
                        icon: "warning"
                    });

                }

            });
            $(document.body).on('click', '#searchtop', function() {
                var session_id = $('#session_id').val();
                var class_code = $('#class_code').val();
                // var subject_id=$('#subject_id').val();
                var section_id = $('#section_id').val();
                var exam_id = $('#exam_id').val();
                // var version_id=$('#version_id').val();
                // var group_id=$('#group_id').val();
                var getdata = 0;
                if (session_id && class_code && section_id && exam_id) {
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
                            section_id,
                            exam_id
                        },
                        success: function(response) {
                            $('#tabledata').html(response);
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
                } else {
                    Swal.fire({
                        title: "Error",
                        text: 'Asterisk(*) fields need to be completed.',
                        icon: "warning"
                    });

                }

            });
            $(document.body).on('click', '#searchtop', function() {
                var session_id = $('#session_id').val();
                var class_code = $('#class_code').val();
                // var subject_id=$('#subject_id').val();
                var section_id = $('#section_id').val();
                var exam_id = $('#exam_id').val();
                // var version_id=$('#version_id').val();
                // var group_id=$('#group_id').val();
                var getdata = 0;
                if (session_id && class_code && section_id && exam_id) {
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
                            section_id,
                            exam_id
                        },
                        success: function(response) {
                            $('#tabledata').html(response);
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
                // $('#effective_from'+classid).removeAttr('readonly',false);

                $('#submit').text('Update');
            });


            $(document.body).on('click', '.delete', function() {
                var id = $(this).data('id');
                var url = $(this).data('url');
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
            });

        });
    </script>
@endsection
