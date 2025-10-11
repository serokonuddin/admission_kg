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
    </style>
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> XL Payment Export/Import</h4>

            <div class="row">
                <div class="col-md-12">


                    <div class="card">
                        <div class="card-body">

                            <form id="formAccountSettings" method="POST" action="#" enctype="multipart/form-data">
                                <input type="hidden" value="0" name="id" id="id" />
                                @csrf
                                <div class="row">



                                    <div class="mb-3 col-md-4">
                                        <label for="session_id" class="form-label">Session</label>
                                        <select id="session_id" name="session_id" class=" form-select" required="">


                                            <option value="{{ $sessions->id }}">{{ $sessions->session_name }}</option>


                                        </select>
                                    </div>




                                    <div class="mb-3 col-md-4">
                                        <label for="class_id" class="form-label">Class</label>
                                        <select id="class_id" name="class_id" class=" form-select" required="">
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
                                        <label for="month" class="form-label">Month</label>
                                        <select id="month" name="month" class=" form-select">
                                            <option value="">Select Month</option>
                                            <option value="01">January</option>
                                            <option value="02">February</option>
                                            <option value="03">March</option>
                                            <option value="04">April</option>
                                            <option value="05">May</option>
                                            <option value="06">June</option>
                                            <option value="07">July</option>
                                            <option value="08">August</option>
                                            <option value="09">September</option>
                                            <option value="10">Octobar</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>


                                        </select>
                                    </div>
                                    @php

                                    @endphp

                                    <div class="mb-3 col-md-4">
                                        <label for="category_id" class="form-label">Head</label>
                                        <select id="head_id" name="head_id" class=" form-select">
                                            <option value="">Select Head</option>
                                            @foreach ($fees as $key => $fee)
                                                <option value="{{ $fee->id }}"
                                                    data-is_male_female="{{ $fee->is_male_female }}">{{ $fee->head_name }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="status" class="form-label">Status</label>
                                        <select id="status" name="status" class=" form-select">
                                            <option value="Pending">Unpaid</option>
                                            <option value="Complete">Paid</option>

                                        </select>
                                    </div>
                                    <div class="mb-3  col-md-3">
                                    </div>
                                    <div class="mb-3  col-md-3">
                                        <label class="form-label" for="amount"> </label>
                                        @if (Auth::user()->is_view_user == 0)
                                            <button type="button"
                                                class="btn btn-success me-2 mt-1 form-control downloadxl">Export XL<i
                                                    class="fa fa-download"></i></button>
                                        @endif
                                    </div>
                                    <div class="mb-3  col-md-2">
                                        <label class="form-label" for="amount"> </label>
                                        <button type="button"
                                            class="btn btn-warning form-control me-2 mt-1 Search">Search</button>
                                    </div>

                                </div>


                            </form>
                            <form action="{{ route('StudentFeeStatusUpdate') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                    <h4>Xl Upload From</h4>
                                    <div class="mb-3  col-md-4">
                                        <label class="form-label" for="amount">Xl File </label>
                                        <input type="file" id="file" name="file" class="form-control "
                                            placeholder="Importxl">
                                    </div>
                                    <div class="mb-3  col-md-2">
                                        <label class="form-label" for="amount"> </label>
                                        @if (Auth::user()->is_view_user == 0)
                                            <button type="submit"
                                                class="btn btn-info me-2 mt-1 form-control uploadxl">Upload</button>
                                        @endif
                                    </div>


                                </div>
                            </form>
                            <div class="row" style="margin-bottom: 10px;margin-top: 20px;">
                                <small class="text-light fw-medium d-block">XL Payment Export/Import</small>

                                <div class="table-responsive " id="showpayemnt">
                                    <table class="table" id="headerTable">
                                        <thead class="table-dark">
                                            <tr>
                                                <!-- <th>#</th> -->
                                                <th>#</th>
                                                <th>Student Code</th>
                                                <th>Student Name</th>
                                                <th>Section</th>
                                                <th>Roll</th>
                                                <th>Payment Date</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">


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


            $(document.body).on('click', '.Search', function() {
                var session_id = $('#session_id').val();
                var class_code = $('#class_id').val();
                var status = $('#status').val();
                var month = $('#month').val();
                var head_id = $('#head_id option:selected').val();

                var url = "{{ route('studentfeeHeadWise') }}";
                $.LoadingOverlay("show");
                $.ajax({
                    type: "post",
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        head_id,
                        month,
                        session_id,
                        class_code,
                        status
                    },
                    success: function(data) {
                        // Create a new Blob object using the response data
                        $('#showpayemnt').html(data);
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
            $(document.body).on('click', '.downloadxl', function() {

                var session_id = $('#session_id option:selected').val();
                var class_code = $('#class_id option:selected').val();
                var month = $('#month option:selected').val();
                var head_id = $('#head_id option:selected').val();
                var status = $('#status').val();


                if (head_id == '') {
                    Swal.fire({
                        title: "Warging",
                        text: "Please Select Fee Head",
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
                if (month == '') {
                    Swal.fire({
                        title: "Warging",
                        text: "Please Select month",
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
                // if(category_id==''){
                //     Swal.fire({
                //                 title: "Warging",
                //                 text: "Please Select Category",
                //                 icon: "warning"
                //             });
                //             return false;
                // }


                $.LoadingOverlay("show");
                var url = "{{ route('getHeadWiseStudentFeeExport') }}";


                var session_name = $('#session_id option:selected').text();
                var class_name = $('#class_id option:selected').text();
                var head_name = $('#head_id option:selected').text();
                var month_name = $('#month option:selected').text();



                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        status,
                        head_id,
                        head_name,
                        month,
                        month_name,
                        session_id,
                        session_name,
                        class_code,
                        class_name
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
                        link.download = head_name + '_' + month_name + '_' + class_name + '_' +
                            session_name + '_' + '.xlsx'; // The name of the downloaded file

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



        });
    </script>

    <script>
        $(function() {
            $(document.body).on('click', '.edit', function() {
                var id = $(this).data('id');
                var effective_from = $(this).data('effective_from');
                var session_id = $(this).data('session_id');
                var version_id = $(this).data('version_id');
                var shift_id = $(this).data('shift_id');
                var class_id = $(this).data('class_id');
                var category_id = $(this).data('category_id');
                var head_id = $(this).data('head_id');
                var amount = $(this).data('amount');
                $('#id').val(id);
                $('#effective_from').val(effective_from);
                $('#session_id').val(session_id);
                $('#version_id').val(version_id);
                $('#shift_id').val(shift_id);
                $('#class_id').val(class_id);
                $('#category_id').val(category_id);
                $('#head_id').val(head_id);
                $('#amount').val(amount);
                $('#submit').text('Update');
            });


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
