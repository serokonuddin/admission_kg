@extends('admin.layouts.layout')
@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    @php
        $months = [
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'Octobar',
            '11' => 'November',
            '12' => 'December',
        ];
    @endphp
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
    </style>
    <style>
        .input-group {
            margin-top: 10px;
        }

        .input-group-text {
            width: 210px;
        }

        .amountclass {
            display: none;
        }

        .save {
            display: none;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> {{ $head->head_name }}</h4>

            <div class="row">
                <div class="col-md-12">


                    <div class="card">
                        <div class="card-body">
                            @php
                                $month = [
                                    '01' => 'January',
                                    '02' => 'February',
                                    '03' => 'March',
                                    '04' => 'April',
                                    '05' => 'May',
                                    '06' => 'June',
                                    '07' => 'July',
                                    '08' => 'August',
                                    '09' => 'September',
                                    '10' => 'October',
                                    '11' => 'November',
                                    '12' => 'December',
                                    '' => '',
                                ];

                            @endphp
                            <form id="formAccountSettings" method="POST" action="{{ route('feeclasswiseEntrySave') }}"
                                enctype="multipart/form-data">
                                <input type="hidden" value="{{ $head_id }}" name="head_id" id="head_id" />

                                @csrf
                                <div class="row">

                                    <div class="row mb-3 col-md-6">
                                        <label class="col-sm-4 col-form-label" for="basic-default-name">Session</label>
                                        <div class="col-sm-8">
                                            <select id="session_id" name="session_id" class=" form-select" required="">
                                                <option value="{{ $sessions->id }}"
                                                    {{ isset($categoryhead) && $categoryhead->session_id == $sessions->id ? 'selected="selected"' : '' }}>
                                                    {{ $sessions->session_name }}</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="row mb-3 col-md-6">
                                        <label class="col-sm-4 col-form-label" for="basic-default-name">Month</label>
                                        <div class="col-sm-8">
                                            <select id="month" name="month" class=" form-select" required="">
                                                <option value="">Select Month</option>
                                                @foreach ($month as $key => $m)
                                                    <option value="{{ $key }}">{{ $m }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3 col-md-6">
                                        <label class="col-sm-4 col-form-label" for="basic-default-name">Student ID</label>
                                        <div class="col-sm-8">
                                            <input class="form-control " type="text" name="student_code" value=""
                                                placeholder="Student ID" autofocus="" />
                                        </div>
                                    </div>
                                    <div class="row mb-3 col-md-6">
                                        <label class="col-sm-4 col-form-label" for="basic-default-name">Amount</label>
                                        <div class="col-sm-8">
                                            <input class="form-control " type="text" name="amount" value=""
                                                placeholder="Amount" autofocus="" />
                                        </div>
                                    </div>



                                    <div class="row mb-3 col-md-4">

                                        @if (Auth::user()->is_view_user == 0)
                                            <div class="col-sm-6">
                                                <button type="submit" id="submit"
                                                    class="btn btn-primary form-control me-2">Save/Update</button>
                                            </div>
                                        @endif

                                        <div class="col-sm-6">
                                            <button type="button" id="search"
                                                class="btn btn-info form-control me-2">Search</button>
                                        </div>
                                    </div>


                                    <!-- <div class="row mb-3 col-md-6">
                                            <label class="col-sm-4 col-form-label" for="basic-default-name">Effective from</label>
                                            <div class="col-sm-8">
                                               <input class="form-control " type="date" name="effective_from"  value="" placeholder="Effective from" autofocus="" />
                                            </div>
                                        </div> -->

                                    <input type="hidden" value="{{ $head_id }}" />


                                </div>



                            </form>

                            <div class="row" style="margin-bottom: 10px;margin-top: 20px;">
                                <small class="text-light fw-medium d-block">{{ $head->head_name }}</small>

                                <div class="table-responsive ">
                                    <table class="table" id="headerTable">
                                        <thead class="table-dark">
                                            <tr>
                                                <!-- <th>#</th> -->
                                                <th>#</th>
                                                <th>Student Name</th>
                                                <th>Student Code</th>
                                                <th>Version</th>
                                                <th>Class</th>

                                                <th>Month</th>
                                                <th>Amount</th>

                                                <th>Action</th>


                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">

                                            @foreach ($studentfees as $fee)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{{ $fee->student->first_name ?? '' }}</td>
                                                    <td>{{ $fee->student->studentActivity->student_code ?? '' }}</td>
                                                    <td>{{ $fee->version->version_name ?? '' }}</td>
                                                    <td>Class {{ $fee->class_code == 0 ? 'KG' : $fee->class_code }}</td>



                                                    <td>{{ $month[$fee->month] }}</td>

                                                    <td><span id="current{{ $fee->id }}"
                                                            class="viewamount">{{ $fee->amount[0] ?? '' }}</span>
                                                        <input class="form-control amountclass" type="text"
                                                            id="amount{{ $fee->id }}"
                                                            name="amount{{ $fee->id }}"
                                                            value="{{ $fee->amount[0] ?? '' }}" placeholder="Amount"
                                                            autofocus="" />
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-success edit edit{{ $fee->id }} viewinput"
                                                            data-id="{{ $fee->id }}"
                                                            id="action{{ $fee->id }}"><i class="fa fa-edit"></i></a>
                                                        <a class="btn btn-success save save{{ $fee->id }}"
                                                            data-class_code="{{ $fee->class_code }}"
                                                            data-head_id="{{ $fee->head_id[0] }}"
                                                            data-student_code="{{ $fee->student_code }}"
                                                            data-version_id="{{ $fee->version_id }}"
                                                            data-session_id="{{ $fee->session_id }}"
                                                            data-id="{{ $fee->id }}">Update</a>
                                                    </td>


                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>



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
            $(document.body).on('click', '.viewinput', function() {
                var id = $(this).data('id');
                $('#current' + id).hide();
                $('#amount' + id).show();
                $('.save' + id).show();
                $('.edit' + id).hide();
            });
            $(document.body).on('click', '.save', function() {
                var id = $(this).data('id');
                var head_id = $(this).data('head_id');
                var version_id = $(this).data('version_id');
                var session_id = $(this).data('session_id');
                var student_code = $(this).data('student_code');
                var class_code = $(this).data('class_code');

                var amount = $('#amount' + id).val();
                $.LoadingOverlay("show");
                var url = "{{ route('feeClassWiseUpdateStudent') }}";





                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        class_code,
                        id,
                        amount,
                        head_id,
                        version_id,
                        session_id,
                        student_code
                    },
                    success: function(data) {
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            title: "Success",
                            text: 'Update Successfully',
                            icon: "success"
                        });
                        $('#current' + id).html(amount);
                        $('#current' + id).show();
                        $('#amount' + id).hide();
                        $('.save' + id).hide();
                        $('.edit' + id).show();

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
            $(document.body).on('click', '.downloadxl', function() {
                var fee_for = $('#fee_for').val();
                var session_id = $('#session_id').val();
                var version_id = $('#version_id').val();
                var class_code = $('#class_id').val();
                var category_id = $('#category_id').val();
                var effective_from = $('#effective_from').val();
                var gender = null;

                if (fee_for == '') {
                    Swal.fire({
                        title: "Warging",
                        text: "Please Select Fee For",
                        icon: "warning"
                    });
                    return false;
                }
                if (session_id == '') {
                    Swal.fire({
                        title: "Warging",
                        text: "Please Select Session",
                        icon: "warning"
                    });
                    return false;
                }
                if (version_id == '') {
                    Swal.fire({
                        title: "Warging",
                        text: "Please Select Version",
                        icon: "warning"
                    });
                    return false;
                }
                if (class_code == '') {
                    Swal.fire({
                        title: "Warging",
                        text: "Please Select Class",
                        icon: "warning"
                    });
                    return false;
                }

                if (effective_from == '') {
                    Swal.fire({
                        title: "Warging",
                        text: "Please Select effective from",
                        icon: "warning"
                    });
                    return false;
                }

                $.LoadingOverlay("show");
                var url = "{{ route('getCategoryWiseHeadFeeExport') }}";

                var month = null;
                var feefor = $('#feefor').val();
                var session = $('#session_id option:selected').text();
                var version = $('#version_id option:selected').text();
                var classes = $('#class_id option:selected').text();
                var category = $('#category_id option:selected').text();



                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        month,
                        effective_from,
                        fee_for,
                        session_id,
                        version_id,
                        class_code,
                        category_id,
                        gender,
                        feefor,
                        session,
                        version,
                        classes,
                        category,
                        'xltext': 'tuitionFee'
                    },
                    xhrFields: {
                        responseType: 'blob' // Important for handling binary data
                    },
                    success: function(data, status, xhr) {
                        // Create a new Blob object using the response data
                        var blob = new Blob([data], {
                            type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                        });

                        // Create a link element
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = 'studentWlfare.xlsx'; // The name of the downloaded file

                        // Append to the document
                        document.body.appendChild(link);

                        // Simulate a click on the link
                        link.click();

                        // Remove the link from the document
                        document.body.removeChild(link);
                        $.LoadingOverlay("hide");
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
            $(document.body).on('change', '#class_id', function() {
                var id = $(this).val();

                var session_id = $('#session_id').val();
                var url = "{{ route('getStudentByClass') }}";
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
                        session_id
                    },
                    success: function(response) {
                        $.LoadingOverlay("hide");
                        $('#student_id').html(response);


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
        $(function() {



            $(document.body).on('click', '.delete', function() {
                var id = $(this).data('id');
                var url = $(this).data('url');
                $.ajax({

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
                            $('#id' + id).remove();
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
