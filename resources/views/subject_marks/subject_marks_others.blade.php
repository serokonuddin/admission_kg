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
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            {{-- <h4 class="py-3 mb-4">
          <span class="text-muted fw-light">Dashboard /</span> Others Subject Mark
       </h4> --}}
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"> Others Subject Mark</li>
                </ol>
            </nav>
            @php

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

            @endphp

            <div class="col-md mb-4 mb-md-0">
                <div class="card">

                    <div class="card-header">
                        <form id="formAccountSettings" method="POST" action="{{ route('subject_marks.store') }}">
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
                                <div class="mb-3 col-sm-3">
                                    <label for="class_code" class="form-label">
                                        Subjects <span style="color: red">*</span>
                                    </label>
                                    <select id="subject_id" name="subject_id" class=" form-select">
                                        <option value="">Select Subject</option>

                                    </select>
                                </div>
                                <div class="mb-3 col-sm-3">
                                    <label for="exam_id" class="form-label">Exam <span style="color: red">*</span></label>
                                    <select id="exam_id" name="exam_id" class="form-select" required="">
                                        <option value="">Select Exam</option>

                                    </select>
                                </div>
                            </div>
                        </form>
                        <div class="col-sm-12 d-flex justify-content-end">
                            <button type="button" id="searchtop" class="btn btn-primary me-2 btn-sm">Search</button>
                            {{-- <button type="button" id="searchblanktop" class="btn btn-info btn-sm">Blank Mark</button> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-container text-nowrap" id="tabledata">

                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th rowspan="2">SL</th>
                                        <th rowspan="2">Student</th>
                                        <th rowspan="2">Roll</th>
                                        <th colspan="3" style="text-align: center">Theory<br />(T:100.00, P:33.00)
                                        </th>
                                        <th colspan="3" style="text-align: center">CQ<br />(T:50.00, P:16.00)</th>
                                        <th colspan="3" style="text-align: center">MCQ <br />(T:25.00, P:8.00)</th>
                                        <th colspan="3" style="text-align: center">Practical<br />(T:25.00, P:8.00)
                                        </th>
                                        <th rowspan="2">Total<br /> Mark <br>(T:100.00, P:33.00)</th>

                                    </tr>
                                    <tr>
                                        <th>Obtained <br /> Marks</th>
                                        <th>Grace <br />Marks</th>
                                        <th>Total<br /> Marks</th>
                                        <th>Obtained <br /> Marks</th>
                                        <th>Grace <br />Marks</th>
                                        <th>Total<br /> Marks</th>
                                        <th>Obtained <br />Marks</th>
                                        <th>Grace<br /> Marks</th>
                                        <th>Total<br /> Marks</th>
                                        <th>Obtained<br /> Marks</th>
                                        <th>Grace<br /> Marks</th>
                                        <th>Total<br /> Marks</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>

                            </table>
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
            $(document.body).on('click', '#searchtop', function() {
                var session_id = $('#session_id').val();
                var class_code = $('#class_code').val();
                var subject_id = $('#subject_id').val();
                var section_id = $('#section_id').val();
                var exam_id = $('#exam_id').val();
                var version_id = $('#version_id').val();
                var group_id = $('#group_id').val();
                var getdata = 0;
                if (session_id && class_code && subject_id && section_id && exam_id) {
                    $.LoadingOverlay("show");
                    $.ajax({
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: "{{ route('getOthersSubjectMarks') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            getdata,
                            session_id,
                            class_code,
                            subject_id,
                            group_id,
                            version_id,
                            section_id,
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
            // $(document.body).on('click', '#searchblanktop', function() {
            //     var session_id = $('#session_id').val();
            //     var class_code = $('#class_code').val();
            //     var subject_id = $('#subject_id').val();
            //     var section_id = $('#section_id').val();
            //     var exam_id = $('#exam_id').val();
            //     var version_id = $('#version_id').val();
            //     var group_id = $('#group_id').val();
            //     var getdata = 0;
            //     if (session_id && class_code && subject_id && section_id && exam_id) {
            //         $.LoadingOverlay("show");
            //         $.ajax({
            //             type: "post",
            //             headers: {
            //                 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            //             },
            //             url: "{{ route('getSubjectMarksBlank') }}",
            //             data: {
            //                 "_token": "{{ csrf_token() }}",
            //                 getdata,
            //                 session_id,
            //                 class_code,
            //                 subject_id,
            //                 group_id,
            //                 version_id,
            //                 section_id,
            //                 exam_id
            //             },
            //             success: function(response) {
            //                 window.open(response, '_blank');
            //             },
            //             error: function(data, errorThrown) {
            //                 Swal.fire({
            //                     title: "Error",
            //                     text: errorThrown,
            //                     icon: "warning"
            //                 });
            //             },
            //             complete: function() {
            //                 $.LoadingOverlay("hide");
            //             }
            //         });
            //     } else {
            //         Swal.fire({
            //             title: "Error",
            //             text: 'Asterisk(*) fields need to be completed.',
            //             icon: "warning"
            //         });

            //     }

            // });

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
            var session_id = $('#session_id').val();
            var class_code = $('#class_code').val();
            $.LoadingOverlay("show");
            if (class_code) {

                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: "{{ route('getOtherSubjects') }}",
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
            }
            $.LoadingOverlay("hide");
        }
    </script>
    {{-- <script>
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
        @if ($class_code && Session::get('session_id'))
            setTimeout(function() {
                // Set time to 10:30 AM after the delay
                $.LoadingOverlay("show");
                getHeaderinfo({{ $class_code }}, {{ Session::get('session_id') }})
            }, 500);

            function getHeaderinfo(class_code, session_id) {
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: "{{ route('getOtherSubjects') }}",
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
                url: "{{ route('getOtherSubjects') }}",
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
            // $(document.body).on('input','.obtained',function(){
            //     var marks_for_pass0=Num($('#marks_for_pass0').val());
            //     var marks_for_pass1=Num($('#marks_for_pass1').val());
            //     var marks_for_pass2=Num($('#marks_for_pass2').val());
            //     var marks_for_pass3=Num($('#marks_for_pass3').val());
            //     var student_code=$(this).data('student_code');
            //     var marks_for=$(this).data('marks_for');

            //     var obtained0=Num($('#obtained'+student_code+'0').val());
            //     var grace0=Num($('#grace'+student_code+'0').val());
            //     var total0=obtained1+grace0;
            //     if(total0<marks_for_pass0){
            //         $('#obtained'+student_code+'0').addClass('redText');
            //         $('#totalmark'+student_code+'0').addClass('redText');
            //     }else{
            //         $('#obtained'+student_code+'0').removeClass('redText');
            //         $('#totalmark'+student_code+'0').removeClass('redText');
            //     }
            //     $('#totalmark'+student_code+'0').html(total0);
            //     $('#totalmarki'+student_code+'0').val(total0);


            //     var obtained1=Num($('#obtained'+student_code+'1').val());
            //     var grace1=Num($('#grace'+student_code+'1').val());
            //     var total1=obtained1+grace1;
            //     if(total1<marks_for_pass1){
            //         $('#obtained'+student_code+'1').addClass('redText');
            //         $('#totalmark'+student_code+'1').addClass('redText');
            //     }else{
            //         $('#obtained'+student_code+'1').removeClass('redText');
            //         $('#totalmark'+student_code+'1').removeClass('redText');
            //     }
            //     $('#totalmark'+student_code+'1').html(total1);
            //     $('#totalmarki'+student_code+'1').val(total1);

            //     var obtained2=Num($('#obtained'+student_code+'2').val());
            //     var grace2=Num($('#grace'+student_code+'2').val());
            //     var total2=obtained2+grace2;
            //     if(total2<marks_for_pass2){
            //         $('#obtained'+student_code+'2').addClass('redText');
            //         $('#totalmark'+student_code+'2').addClass('redText');
            //     }else{
            //         $('#obtained'+student_code+'2').removeClass('redText');
            //         $('#totalmark'+student_code+'2').removeClass('redText');
            //     }
            //     $('#totalmark'+student_code+'2').html(total2);
            //     $('#totalmarki'+student_code+'2').val(total2);

            //     var obtained3=Num($('#obtained'+student_code+'3').val());
            //     var grace3=Num($('#grace'+student_code+'3').val());
            //     var total3=obtained3+grace3;

            //     $('#totalmark'+student_code+'3').html(total3);
            //     $('#totalmarki'+student_code+'3').val(total3);
            //     if(total3<marks_for_pass3){
            //         $('#obtained'+student_code+'3').addClass('redText');
            //         $('#totalmark'+student_code+'3').addClass('redText');
            //     }else{
            //         $('#obtained'+student_code+'3').removeClass('redText');
            //         $('#totalmark'+student_code+'3').removeClass('redText');
            //     }
            //     var total=(Num(total0)+Num(total1)+Num(total2)+Num(total3));
            //     $('#totalmark'+student_code).html(total);
            //     $('#totalmarki'+student_code).val(total);
            // var marks_for_pass1=Num($('#marks_for_pass1').val());
            // var marks_for_pass2=Num($('#marks_for_pass2').val());
            // var marks_for_pass3=Num($('#marks_for_pass3').val());
            // var student_code=$(this).data('student_code');
            // var marks_for=$(this).data('marks_for');

            // var obtained1=Num($('#obtained'+student_code+'1').val());

            // var grace1=Num($('#grace'+student_code+'1').val());

            // var total1=obtained1+grace1;

            // if(total1<marks_for_pass1){
            //     $('#obtained'+student_code+'1').addClass('redText');
            //     $('#totalmark'+student_code+'1').addClass('redText');
            // }else{
            //     $('#obtained'+student_code+'1').removeClass('redText');
            //     $('#totalmark'+student_code+'1').removeClass('redText');
            // }
            // $('#totalmark'+student_code+'1').html(total1);

            // var obtained2=Num($('#obtained'+student_code+'2').val());
            // var grace2=Num($('#grace'+student_code+'2').val());
            // var total2=obtained2+grace2;
            // if(total2<marks_for_pass2){
            //     $('#obtained'+student_code+'2').addClass('redText');
            //     $('#totalmark'+student_code+'2').addClass('redText');
            // }else{
            //     $('#obtained'+student_code+'2').removeClass('redText');
            //     $('#totalmark'+student_code+'2').removeClass('redText');
            // }
            // $('#totalmark'+student_code+'2').html(total2);

            // var obtained3=Num($('#obtained'+student_code+'3').val());
            // var grace3=Num($('#grace'+student_code+'3').val());
            // var total3=obtained3+grace3;

            // $('#totalmark'+student_code+'3').html(total3);
            // if(total3<marks_for_pass3){
            //     $('#obtained'+student_code+'3').addClass('redText');
            //     $('#totalmark'+student_code+'3').addClass('redText');
            // }else{
            //     $('#obtained'+student_code+'3').removeClass('redText');
            //     $('#totalmark'+student_code+'3').removeClass('redText');
            // }
            // $('#totalmark'+student_code).html(obtained1+grace1+obtained2+grace2+obtained3+grace3);
            //});
            // $(document.body).on('input','.grace',function(){
            //     var marks_for_pass0=Num($('#marks_for_pass0').val());
            //     var marks_for_pass1=Num($('#marks_for_pass1').val());
            //     var marks_for_pass2=Num($('#marks_for_pass2').val());
            //     var marks_for_pass3=Num($('#marks_for_pass3').val());
            //     var student_code=$(this).data('student_code');
            //     var marks_for=$(this).data('marks_for');

            //     var obtained0=Num($('#obtained'+student_code+'0').val());
            //     var grace0=Num($('#grace'+student_code+'0').val());
            //     var total0=obtained1+grace0;
            //     if(total0<marks_for_pass0){
            //         $('#obtained'+student_code+'0').addClass('redText');
            //         $('#totalmark'+student_code+'0').addClass('redText');
            //     }else{
            //         $('#obtained'+student_code+'0').removeClass('redText');
            //         $('#totalmark'+student_code+'0').removeClass('redText');
            //     }
            //     $('#totalmark'+student_code+'0').html(total0);
            //     $('#totalmarki'+student_code+'0').val(total0);


            //     var obtained1=Num($('#obtained'+student_code+'1').val());
            //     var grace1=Num($('#grace'+student_code+'1').val());
            //     var total1=obtained1+grace1;
            //     if(total1<marks_for_pass1){
            //         $('#obtained'+student_code+'1').addClass('redText');
            //         $('#totalmark'+student_code+'1').addClass('redText');
            //     }else{
            //         $('#obtained'+student_code+'1').removeClass('redText');
            //         $('#totalmark'+student_code+'1').removeClass('redText');
            //     }
            //     $('#totalmark'+student_code+'1').html(total1);
            //     $('#totalmarki'+student_code+'1').val(total1);

            //     var obtained2=Num($('#obtained'+student_code+'2').val());
            //     var grace2=Num($('#grace'+student_code+'2').val());
            //     var total2=obtained2+grace2;
            //     if(total2<marks_for_pass2){
            //         $('#obtained'+student_code+'2').addClass('redText');
            //         $('#totalmark'+student_code+'2').addClass('redText');
            //     }else{
            //         $('#obtained'+student_code+'2').removeClass('redText');
            //         $('#totalmark'+student_code+'2').removeClass('redText');
            //     }
            //     $('#totalmark'+student_code+'2').html(total2);
            //     $('#totalmarki'+student_code+'2').val(total2);

            //     var obtained3=Num($('#obtained'+student_code+'3').val());
            //     var grace3=Num($('#grace'+student_code+'3').val());
            //     var total3=obtained3+grace3;

            //     $('#totalmark'+student_code+'3').html(total3);
            //     $('#totalmarki'+student_code+'3').val(total3);
            //     if(total3<marks_for_pass3){
            //         $('#obtained'+student_code+'3').addClass('redText');
            //         $('#totalmark'+student_code+'3').addClass('redText');
            //     }else{
            //         $('#obtained'+student_code+'3').removeClass('redText');
            //         $('#totalmark'+student_code+'3').removeClass('redText');
            //     }
            //     var total=(Num(total0)+Num(total1)+Num(total2)+Num(total3));
            //     $('#totalmark'+student_code).html(total);
            //     $('#totalmarki'+student_code).val(total);
            // });
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
                        url: "{{ route('getOtherSubjects') }}",
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
            $(document.body).on('click', '#searchtop', function() {
                var session_id = $('#session_id').val();
                var class_code = $('#class_code').val();
                var subject_id = $('#subject_id').val();
                var section_id = $('#section_id').val();
                var exam_id = $('#exam_id').val();
                var version_id = $('#version_id').val();
                var group_id = $('#group_id').val();
                var getdata = 0;
                if (session_id && class_code && subject_id && section_id && exam_id) {
                    $.LoadingOverlay("show");
                    $.ajax({
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: "{{ route('getOthersSubjectMarks') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            getdata,
                            session_id,
                            class_code,
                            subject_id,
                            group_id,
                            version_id,
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
                var subject_id = $('#subject_id').val();
                var section_id = $('#section_id').val();
                var exam_id = $('#exam_id').val();
                var version_id = $('#version_id').val();
                var group_id = $('#group_id').val();
                var getdata = 0;
                if (session_id && class_code && subject_id && section_id && exam_id) {
                    $.LoadingOverlay("show");
                    $.ajax({
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: "{{ route('getOthersSubjectMarks') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            getdata,
                            session_id,
                            class_code,
                            subject_id,
                            group_id,
                            version_id,
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
                var subject_id = $('#subject_id').val();
                var section_id = $('#section_id').val();
                var exam_id = $('#exam_id').val();
                var version_id = $('#version_id').val();
                var group_id = $('#group_id').val();
                var getdata = 0;
                if (session_id && class_code && subject_id && section_id && exam_id) {
                    $.LoadingOverlay("show");
                    $.ajax({
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: "{{ route('getOthersSubjectMarks') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            getdata,
                            session_id,
                            class_code,
                            subject_id,
                            group_id,
                            version_id,
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
            // $(document.body).on('click','#searchblanktop',function(){
            //     var session_id=$('#session_id').val();
            //     var class_code=$('#class_code').val();
            //     var subject_id=$('#subject_id').val();
            //     var section_id=$('#section_id').val();
            //     var exam_id=$('#exam_id').val();
            //     var version_id=$('#version_id').val();
            //     var group_id=$('#group_id').val();
            //    var getdata=0;
            //     if(session_id && class_code && subject_id && section_id && exam_id){
            //         $.LoadingOverlay("show");
            //         $.ajax({
            //             type: "post",
            //             headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
            //             url: "{{ route('getSubjectMarksBlank') }}",
            //             data:{"_token": "{{ csrf_token() }}",getdata,session_id,class_code,subject_id,group_id,version_id,section_id,exam_id},
            //             success: function(response){
            //                 window.open(response, '_blank');
            //                 $.LoadingOverlay("hide");
            //             },
            //             error: function(data, errorThrown)
            //             {
            //                 Swal.fire({
            //                     title: "Error",
            //                     text: errorThrown,
            //                     icon: "warning"
            //                 });
            //                 $.LoadingOverlay("hide");
            //             }
            //         });
            //     }else{
            //         Swal.fire({
            //                     title: "Error",
            //                     text: 'Asterisk(*) fields need to be completed.',
            //                     icon: "warning"
            //                 });

            //     }

            // });
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
    </script> --}}
@endsection
