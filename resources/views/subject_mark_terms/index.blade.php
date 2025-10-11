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
            {{-- <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">Dashboard /</span> Subject mark Terms
            </h4> --}}
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"> Subject mark Terms</li>
                </ol>
            </nav>

            <div class="col-md mb-4 mb-md-0">
                <div class="card">
                    <div class="card-header">
                        <div class="col-sm-12 col-md-12 p-10 m-r-10" style="text-align: right">
                            @if (Auth::user()->is_view_user == 0)
                                <a href="{{ route('subject_mark_terms.create') }}" class=" btn btn-round btn-info">Create
                                    Subject mark Terms</a>
                            @endif
                        </div>
                        <form id="formAccountSettings" method="POST" action="#">
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

                                <div class="mb-3 col-md-4">
                                    <label for="subject_id" class="form-label">Subject</label>
                                    <select id="subject_id" name="subject_id" class=" form-select" required="">
                                        <option value="">Select Subject</option>
                                        @foreach ($subjects as $key => $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="mb-3  col-md-2">
                                    <label class="form-label" for="amount"> </label>
                                    <button type="button" id="searchtop"
                                        class="btn btn-primary form-control me-2 mt-1">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive text-nowrap fixed" id="tabledata" style="padding: 10px;">

                            <table class="table " id="headerTable">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Session ID</th>
                                        <th>Class Code</th>
                                        <th>Subject ID</th>
                                        <th>Marks For</th>
                                        <th>Total Mark</th>
                                        <th>Pass Mark</th>
                                        <th>Converted To</th>
                                        @if (Auth::user()->is_view_user == 0)
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($terms as $term)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $term->session->session_name ?? '' }}</td>
                                            <td>{{ $term->class_code ?? '' }}</td>
                                            <td>{{ $term->subject->subject_name ?? '' }}</td>
                                            <td>
                                                @if ($term->marks_for == 0)
                                                    CT
                                                @elseif($term->marks_for == 1)
                                                    CQ
                                                @elseif($term->marks_for == 2)
                                                    MCQ
                                                @else
                                                    Practical
                                                @endif

                                            </td>

                                            <td>{{ $term->total_mark ?? '' }}</td>
                                            <td>{{ $term->pass_mark ?? '' }}</td>
                                            <td>{{ $term->converted_to ?? '' }}</td>
                                            @if (Auth::user()->is_view_user == 0)
                                                <td>
                                                    <a href="{{ route('subject_mark_terms.edit', $term->id) }}"
                                                        class="btn btn-warning btn-sm">Edit</a>

                                                    <form action="{{ route('subject_mark_terms.destroy', $term->id) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
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

        $(function() {
            // $(document.body).on('change','#class_code',function(){
            //     var session_id=$('#session_id').val();
            //     var class_code=$('#class_code').val();
            //     $.LoadingOverlay("show");
            //     if(class_code){

            //         $.ajax({
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
            //     }
            //     if(session_id && class_code){
            //         $.ajax({
            //             type: "post",
            //             headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
            //             url: "{{ route('getExam') }}",
            //             data:{"_token": "{{ csrf_token() }}",session_id,class_code},
            //             success: function(response){
            //                 $('#exam_id').html(response);
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
            //     }
            //     $.LoadingOverlay("hide");
            // });
            // $(document.body).on('change','#session_id',function(){
            //     var session_id=$('#session_id').val();
            //     var class_code=$('#class_code').val();

            //     if(session_id && class_code){
            //         $.LoadingOverlay("show");
            //         $.ajax({
            //             type: "post",
            //             headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
            //             url: "{{ route('getExam') }}",
            //             data:{"_token": "{{ csrf_token() }}",session_id,class_code},
            //             success: function(response){
            //                 $('#exam_id').html(response);
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
            //     }


            // });
            $(document.body).on('click', '#searchtop', function() {
                var session_id = $('#session_id').val();
                var class_code = $('#class_code').val();
                var subject_id = $('#subject_id').val();

                if (session_id && class_code) {
                    $.LoadingOverlay("show");
                    $.ajax({
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: "{{ route('getSubjectMarkTerms') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            session_id,
                            class_code,
                            subject_id
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
