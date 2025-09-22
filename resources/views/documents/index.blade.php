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
            color: black;
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
            color: black;
            font-weight: bold;
        }

        .form-label {
            width: 100% !important;
        }
    </style>
    @php 
        $status=array(1=>'Pendding',2=>'Approved',0=>'Cancel');
    @endphp
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
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Leave List</h4>
            <!-- Basic Bootstrap Table -->
            <div class="card">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="dataTables_length" id="DataTables_Table_0_length" style="padding: 5px">

                            <div class="row g-3 searchby">
                                @if (Auth::user()->getMenu('approval_stage.create', 'name'))
                                    <div class="col-sm-12 col-md-12 p-10 m-r-10" style="text-align: right">
                                        <a href="{{ route('approval_stage.create') }}" class=" btn btn-round btn-info">Create</a>
                                    </div>
                                @endif
                                

                            </div>
                        </div>

                    </div>

                </div>

            </div>
            <div class="table-responsive ">
                <table class="table" id="headerTable">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Subject</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Position</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($documents as $document)
                       <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>{{$document->subject}}</td>
                            <td>{{$document->start_date}}</td>
                            <td>{{$document->end_date}}</td>
                            <td></td>
                            <td>{{$status[$document->status]}}</td>
                            <td><a href="javascript:void(0);" class="btn btn-outline-primary" ><i class="fas fa-forward"></i></a>
                            <a href="{{ route('documents.show', $document->id) }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('documents.edit', $document->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('documents.destroy', $document->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                        </td> 
                       </tr>
                       @endforeach

                    </tbody>
                </table>

            </div>
            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_3_paginate"
                style="padding: 10px">

            </div>
        </div>
        <div class="content-backdrop fade"></div>
    </div>
    <!-- / Content -->
    <script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this document? This action cannot be undone.');
    }
</script>
    <script>
        @if (Session::has('success'))
            Swal.fire({
                title: "Good job!",
                text: "{{ Session::get('success') }}",
                icon: "success",
                confirmButtonText: "OK"
            });
        @endif

        @if (Session::has('warning'))
            Swal.fire({
                title: "Warning!",
                text: "{{ Session::get('warning') }}",
                icon: "warning",
                confirmButtonText: "OK"
            });
        @endif

        @if (Session::has('error'))
            Swal.fire({
                title: "Error!",
                text: "{{ Session::get('error') }}",
                icon: "error",
                confirmButtonText: "OK"
            });
        @endif
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
    <script type="text/javascript">
        $(function() {
            $(document.body).on('click', '#search', function() {

                var version_id = $('#version_id').val();
                var teacher_for = $('#teacher_for').val();
                var is_teacher = $('#is_teacher').val();
                var class_id = $('#class_id').val();
                var shift_id = $('#shift_id').val();

                location.href = "{{ route('users.index') }}" + '?shift_id=' + shift_id + ' & version_id=' +
                    version_id + '& class_id=' + class_id + '& teacher_for=' + teacher_for +
                    '& is_teacher=' + is_teacher;
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
