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
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Student Fee Generate</h4>
            <!-- <form id="formAccountSettings" method="POST" action="{{ route('fees.store') }}" enctype="multipart/form-data"> -->
            <form id="formAccountSettings" method="POST" action="{{ route('studentFeeAutoGenerate') }}"
                enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">

                        <input type="hidden" value="{{ $sessions->id }}" name="session_id" />
                        @csrf

                        <div class="card">
                            <div class="card-body">


                                <div class="row">

                                    <div class="mb-3 col-md-4">
                                        <label for="fee_for" class="form-label">Class</label>
                                        <select id="class_id" name="class_id" class=" form-select" required="">
                                            <option value="">Select Class</option>
                                            <option value="0" {{ $class_id == 0 ? 'selected="selected"' : '' }}>KG
                                            </option>
                                            <option value="1" {{ $class_id == 1 ? 'selected="selected"' : '' }}>CLass I
                                            </option>
                                            <option value="2" {{ $class_id == 2 ? 'selected="selected"' : '' }}>CLass
                                                II
                                            </option>
                                            <option value="3" {{ $class_id == 3 ? 'selected="selected"' : '' }}>CLass
                                                III
                                            </option>
                                            <option value="4" {{ $class_id == 4 ? 'selected="selected"' : '' }}>CLass
                                                IV
                                            </option>
                                            <option value="5" {{ $class_id == 5 ? 'selected="selected"' : '' }}>CLass V
                                            </option>
                                            <option value="6" {{ $class_id == 6 ? 'selected="selected"' : '' }}>CLass
                                                VI
                                            </option>
                                            <option value="7" {{ $class_id == 7 ? 'selected="selected"' : '' }}>CLass
                                                VII
                                            </option>
                                            <option value="8" {{ $class_id == 8 ? 'selected="selected"' : '' }}>CLass
                                                VIII
                                            </option>
                                            <option value="9" {{ $class_id == 9 ? 'selected="selected"' : '' }}>CLass
                                                IX
                                            </option>
                                            <option value="10" {{ $class_id == 10 ? 'selected="selected"' : '' }}>CLass
                                                X
                                            </option>
                                            <option value="11" {{ $class_id == 11 ? 'selected="selected"' : '' }}>CLass
                                                XI
                                            </option>
                                            <option value="12" {{ $class_id == 12 ? 'selected="selected"' : '' }}>CLass
                                                XII
                                            </option>

                                        </select>
                                    </div>


                                    <div class="mb-3 col-md-4">
                                        <label for="version_id" class="form-label">Version</label>
                                        <select id="version_id" name="version_id" class=" form-select" required="">
                                            <option value="">Select Version</option>
                                            @foreach ($versions as $version)
                                                <option value="{{ $version->id }}"
                                                    {{ isset($activity) && $activity->version_id == $version->id ? 'selected="selected"' : '' }}>
                                                    {{ $version->version_name }}</option>
                                            @endforeach

                                        </select>
                                    </div>


                                    <div class="mb-3 col-md-4">
                                        <label for="category_id" class="form-label">Month</label>
                                        <select id="month" name="month" class=" form-select">
                                            <option value="">Select Month</option>
                                            @foreach ($months as $key => $monthvalue)
                                                <option value="{{ $key }}"
                                                    {{ $month == $key ? 'selected="selected"' : '' }}>{{ $monthvalue }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                    @if (Auth::user()->is_view_user == 0)
                                        <div class="mb-3 col-md-4">
                                            <button type="button" class="btn btn-primary me-2 submit"
                                                style="margin-top: 30px;">Generate</button>

                                        </div>
                                    @endif
                                    <div class="mb-3 col-md-4">
                                        <button type="button" class="btn btn-info me-2 search"
                                            style="margin-top: 30px;">Search</button>

                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 10px;">


                                    <small class="text-light fw-medium d-block">Student Fee</small>
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
                                        ];
                                        $fee_for = [
                                            1 => 'Tuition Fee',
                                            2 => 'Session Charge',
                                            3 => '',
                                            4 => 'Exam Fee',
                                            5 => 'Government Charge',
                                            6 => 'Board Fee',
                                            7 => 'Coaching Fee',
                                            8 => 'Conveyance Fee',
                                            9 => 'Student Welfare',
                                            10 => 'EMIS',
                                            11 => 'MISC',
                                            12 => 'Fine & Charge',
                                        ];
                                        $feesdata = [];

                                        if (count($studentfees) > 0) {
                                            $feesdata = $studentfees[0]->head_id;
                                        }
                                    @endphp
                                    <div class="table-responsive ">
                                        <table class="table" id="headerTable">
                                            <thead class="table-dark">
                                                <tr>
                                                    <!-- <th>#</th> -->
                                                    <th>#</th>
                                                    <th>Student Name</th>
                                                    <th>Roll</th>
                                                    <th>Fee For</th>
                                                    <th>Class</th>
                                                    <th>Month</th>
                                                    @if ($feesdata)
                                                        @foreach ($feesdata as $value)
                                                            <th>{{ $fees[$value][0]->head_name ?? '' }}</th>
                                                        @endforeach
                                                    @endif
                                                    <th>Total Amount</th>

                                                </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0">
                                                @foreach ($studentfees as $key => $payment)
                                                    <tr id="id{{ $payment->id }}">
                                                        <td>
                                                            {{ $key + 1 }}
                                                        </td>
                                                        <td>{{ $payment->first_name ?? '' }}</td>
                                                        <td>{{ $payment->roll ?? '' }}</td>
                                                        <td>
                                                            {{ $fee_for[$payment->fee_for] }}

                                                        </td>

                                                        <td>Class {{ $payment->class_code ?? '' }}</td>

                                                        <td>{{ $month[$payment->month] ?? '' }}</td>


                                                        @foreach ($payment->amount as $value)
                                                            <td>{{ $value }}</td>
                                                        @endforeach

                                                        <td>{{ $payment->amount ? array_sum($payment->amount) : '' }}</td>

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
            </form>
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


            $(document.body).on('click', '.submit', function() {

                $('#formAccountSettings').attr('action', '{{ route('studentFeeAutoGenerate') }}');
                $('#formAccountSettings').attr('method', 'POST');
                $(this).attr('disabled', true);
                setTimeout(function() {
                    $('#formAccountSettings').submit();

                }, 500);

            });
            $(document.body).on('click', '.search', function() {

                $('#formAccountSettings').attr('action', '{{ route('studentFeeGenerate') }}');
                $('#formAccountSettings').attr('method', 'GET');
                setTimeout(function() {
                    $('#formAccountSettings').submit();
                }, 500);

            });
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
