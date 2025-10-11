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

        th {
            text-align: center;
        }

        .form-check-input {
            border: 2px solid #a7acb2 !important;
        }

        h5 {
            font-size: 15px !important;
        }
    </style>

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
        $years = [
            1 => '2024',
            2 => '2025',
            3 => '2026',
            4 => '2027',
            5 => '2028',
        ];
    @endphp
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Student Payable</h4>
            <!-- Basic Bootstrap Table -->
            <div class="card">
                <div class="card-header text-center justify-content-between align-items-center">
                    <h4 class="card-title  mb-3">Pay Tuition Fee, Admission Fee & Other Charges</h4>
                    <h5 class="mb-1">Student ID: {{ $student->student_code }}</h5>
                    <h5 class="mb-1">Student Name: {{ $student->first_name }}</h5>
                    <h5 class="mb-1">Father's Name:{{ $student->father_name }}</h5>
                    <h5 class="mb-1">Mother's Name:{{ $student->mother_name }}</h5>
                    <h5 class="mb-1">Shift: {{ $student->studentActivity->shift->shift_name ?? '' }}</h5>

                </div>
                <div class="card-datatable table-responsive">

                    <table class=" table border-top " style="width: 95%;">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 7%">#</th>
                                <th>Payment Area</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php

                                $total = 0;

                            @endphp
                            @foreach ($othersfeehead as $fee)
                                @php

                                    $id = $othersfee[$fee->id][0]->id ?? 0;
                                    $amount = $othersfee[$fee->id][0]->amount ?? 0;
                                    $status = $othersfee[$fee->id][0]->status ?? '';
                                    $total += $othersfee[$fee->id][0]->amount ?? 0;

                                @endphp
                                <tr class="odd">
                                    <td class="  dt-checkboxes-cell text-center">
                                        @if ($id != 0)
                                            <input type="checkbox" value="{{ $fee->id }}" name="id"
                                                id="feeid{{ $fee->id }}" class="feeid dt-checkboxes form-check-input">
                                        @endif
                                    </td>

                                    <td class="text-center"><span>{{ $fee->head_name ?? '' }}</span></td>
                                    <td class="text-center"><span class="text-body">{{ $amount }}Tk</span></td>
                                    <td class="text-center">
                                        @if ($id != 0)
                                            <span class="text-body">{{ $status }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="odd">
                                <td class="  dt-checkboxes-cell text-center" colspan="2">
                                    <span>Sub Total</span>
                                </td>


                                <td class="text-center"><span class="text-body">{{ $total }}Tk</span></td>
                                <td class="text-center">

                                </td>
                            </tr>
                        </tbody>
                    </table>


                </div>
                @php
                    $monthdata = [
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
                    ];
                    $fee_for = [
                        1 => 'Admission Fee',
                        2 => 'Session Charge',
                        3 => 'Tuition Fee',
                        4 => 'Exam Fee',
                        5 => 'Government Charge',
                        6 => 'Board Fee',
                        7 => 'Coaching Fee',
                        8 => 'Conveyance Fee',
                        9 => 'Student Welfare',
                        10 => 'EMIS',
                        11 => 'MISC',
                        12 => 'Fine & Charge',
                        '' => '',
                    ];
                @endphp
                <div class="table-responsive ">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <!-- <th>#</th> -->
                                <!-- <th>Tuition</th>

                                            <th>Session</th> -->
                                <th>Month</th>
                                <th>Tuition</th>

                                <th>Fine</th>
                                <th>Status</th>
                                <th>Devt</th>
                                <th>StdWel</th>
                                <th>Status</th>
                                <th>SMS</th>
                                <th>Status</th>

                                <th>Session</th>
                                <th>Status</th>
                                <th>Total</th>

                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($monthvalue as $key => $month)
                                @php
                                    $total = 0;
                                    if ($month['tutionfee']) {
                                        $total = array_sum($month['tutionfee']->amount);
                                    }

                                @endphp
                                <tr>
                                    <!-- <td><input type="checkbox" value="{{ $key }}" data-month="{{ $key }}" data-id="{{ $month['tutionfeesatus']->id ?? 0 }}" data-amount="{{ $total }}" name="tuition{{ $key }}" id="tuition{{ $key }}" class="monthid dt-checkboxes checkboxsum form-check-input"></td>
                                                <td><input type="checkbox" value="{{ $key }}" data-month="{{ $key }}" data-id="{{ $month['sessioncharge']->id ?? 0 }}" data-amount="{{ $month['sessioncharge']->amount ?? 0 }}" name="sessioncharge{{ $key }}" id="sessioncharge{{ $key }}" class="sessioncharge checkboxsum dt-checkboxes form-check-input"></td> -->

                                    <td>{{ $monthdata[$key] . '-' . date('Y') }}</td>
                                    <td>{{ $month['tutionfee']->amount[2] ?? 0 }}</td>
                                    <td>{{ $month['latefee']->amount ?? 0 }}</td>
                                    <td>{{ $month['tutionfeesatus']->status ?? '' }}</td>
                                    <td>0</td>
                                    <td>{{ $month['tutionfee']->amount[1] ?? 0 }}</td>
                                    <td>{{ $month['tutionfeesatus']->status ?? '' }}</td>
                                    <td>{{ $month['tutionfee']->amount[0] ?? 0 }}</td>
                                    <td>{{ $month['tutionfeesatus']->status ?? '' }}</td>


                                    <td>{{ $month['sessioncharge']->amount ?? 0 }}</td>
                                    <td>{{ $month['sessioncharge']->status ?? '' }}</td>
                                    <td>{{ $total + ($month['sessioncharge']->amount ?? 0) }}</td>
                                </tr>
                            @endforeach
                            <!-- <tr>
                                             <td colspan="6"></td>
                                             <td colspan="6">
                                             <div class="col-lg-12 card-body p-md-8">

                                                    <div class="mt-1">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <p class="mb-0">Grand Total</p>
                                                            <h6 class="mb-0" id="addvalue">0Tk</h6>
                                                            <input type="hidden" name="grandtotal" id="addvalueInput" />
                                                        </div>


                                                        <div class="d-grid mt-5">
                                                            <button class="btn btn-success">
                                                            <span class="me-2">Proceed with Payment</span>
                                                            <i class="bx bx-right-arrow-alt scaleX-n1-rtl"></i>
                                                            </button>
                                                        </div>

                                                    </div>
                                                    </div>
                                             </td> -->
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalFullTitle">Payment Option</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="background-color: #f5f2f2;text-align: center ">
                            <div class="d-flex flex-wrap" id="icons-container">
                                <div class="card icon-card cursor-pointer text-center mb-4 mx-2">
                                    <div class="card-body">
                                        <a id="sslurl">
                                            <img src="{{ asset('public/ssl.png') }}" style="width: 160px">
                                            <p class="icon-name text-capitalize text-truncate mb-0">sslcommerz</p>
                                        </a>
                                    </div>
                                </div>
                                <div class="card icon-card cursor-pointer text-center mb-4 mx-2">
                                    <div class="card-body">
                                        <a id="ucblurl">
                                            <img src="{{ asset('public/ucbl.png') }}" style="width: 90px">
                                            <p class="icon-name text-capitalize text-truncate mb-0">UCBL</p>
                                        </a>
                                    </div>
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
        $(document).ready(function() {
            // Update the grand total whenever a checkbox is clicked
            $('.checkboxsum').on('change', function() {
                updateGrandTotal();
                enforceSequentialSelection();
            });

            // Function to calculate and update the grand total
            function updateGrandTotal() {
                let total = 0;

                // Iterate through each checkbox and add the amounts if selected
                $('.checkboxsum:checked').each(function() {
                    total += parseInt($(this).data('amount'));
                });

                // Update the grand total display
                $('#addvalue').text(total + 'Tk');
                $('#addvalueInput').val(total);
            }

            // Function to enforce the sequential selection of months
            function enforceSequentialSelection() {
                // Iterate through all the checkboxes
                $('.checkboxsum').each(function(index, checkbox) {
                    // Enable all checkboxes first
                    $(checkbox).prop('disabled', false);

                    // If any earlier month is unchecked, disable the current checkbox
                    if (index > 0) {
                        let previousCheckbox = $('.checkboxsum').eq(index - 1);
                        if (!previousCheckbox.is(':checked')) {
                            $(checkbox).prop('disabled', true);
                        }
                    }
                });
            }

            // Initially call enforceSequentialSelection to set the right state
            enforceSequentialSelection();
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $(document.body).on('click', '.feeInfo', function() {
                var urlssl = $(this).data('urlssl');
                var urlucbl = $(this).data('urlucbl');
                $('#sslurl').attr('href', urlssl);
                $('#ucblurl').attr('href', urlucbl);
                $('#modalCenter').modal('show');
            });
            $(document.body).on('click', '#search', function() {
                var month = $('#month').val();
                var session_id = $('#session_id').val();
                var version_id = $('#version_id').val();
                var shift_id = $('#shift_id').val();
                var class_id = $('#class_id').val();
                var category_id = $('#category_id').val();
                location.href = "{{ route('fees.create') }}" + '?shift_id=' + shift_id + ' & month=' +
                    month + ' & version_id=' + version_id + '& class_id=' + class_id + '& category_id=' +
                    category_id + '& session_id=' + session_id;





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
                var url = "{{ route('getSections') }}";
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
