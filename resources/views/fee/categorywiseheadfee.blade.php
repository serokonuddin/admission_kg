@extends('admin.layouts.layout')
@section('content')
    <link rel="stylesheet"
        href="{{ asset('public/backend') }}/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
    <link rel="stylesheet"
        href="{{ asset('public/backend') }}/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
    <link rel="stylesheet" href="{{ asset('public/backend') }}/assets/vendor/libs/jquery-timepicker/jquery-timepicker.css" />
    <link rel="stylesheet" href="{{ asset('public/backend') }}/assets/vendor/libs/pickr/pickr-themes.css" />
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
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Class , Category Wise Head Fee</h4>

            <div class="row">
                <div class="col-md-12">


                    <div class="card">
                        <div class="card-body">

                            <form id="formAccountSettings" method="POST" action="{{ route('feeHeadamountSave') }}"
                                enctype="multipart/form-data">
                                <input type="hidden" value="0" name="id" id="id" />
                                @csrf
                                <div class="row">


                                    <div class="mb-3 col-md-4">
                                        <label for="fee_for" class="form-label">Fee For</label>
                                        <select id="fee_for" name="fee_for" class=" form-select" required="">
                                            <option value="">Select Fee For</option>

                                            <option value="1">Admission Fee</option>
                                            <option value="2">Session Charge</option>
                                            <option value="3">Tuition Fee</option>
                                            <option value="4">Exam Fee</option>
                                            <option value="5">Government Charge</option>
                                            <option value="6">Board Fee</option>
                                            <option value="7">Coaching Fee</option>
                                            <option value="8">Conveyance Fee</option>
                                            <option value="9">Student Welfare</option>
                                            <option value="10">EMIS</option>
                                            <option value="11">MISC</option>
                                            <option value="12">Fine & Charge</option>


                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="session_id" class="form-label">Session</label>
                                        <select id="session_id" name="session_id" class=" form-select" required="">


                                            <option value="{{ $sessions->id }}"
                                                {{ isset($categoryhead) && $categoryhead->session_id == $sessions->id ? 'selected="selected"' : '' }}>
                                                {{ $sessions->session_name }}</option>


                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="version_id" class="form-label">Version</label>
                                        <select id="version_id" name="version_id" class=" form-select" required="">
                                            <option value="">Select Version</option>
                                            @foreach ($versions as $version)
                                                <option value="{{ $version->id }}"
                                                    {{ isset($categoryhead) && $categoryhead->version_id == $version->id ? 'selected="selected"' : '' }}>
                                                    {{ $version->version_name }}</option>
                                            @endforeach

                                        </select>
                                    </div>


                                    @php
                                        $class_id =
                                            isset($categoryhead) && $categoryhead->class_code
                                                ? $syllabus->class_code
                                                : null;
                                    @endphp
                                    <div class="mb-3 col-md-4">
                                        <label for="class_id" class="form-label">Class</label>
                                        <select id="class_id" name="class_id" class=" form-select" required="">
                                            <option value="">Select Class</option>
                                            <option value="0" {{ $class_id == 0 ? 'selected="selected"' : '' }}>KG
                                            </option>
                                            <option value="1" {{ $class_id == 1 ? 'selected="selected"' : '' }}>CLass
                                                I
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
                                            <option value="5" {{ $class_id == 5 ? 'selected="selected"' : '' }}>CLass
                                                V
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
                                        <label for="category_id" class="form-label">Category</label>
                                        <select id="category_id" name="category_id" class=" form-select" required="">
                                            <option value="">Select Category</option>

                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ isset($categoryhead) && $categoryhead->category_id == $category->category_id ? 'selected="selected"' : '' }}>
                                                    {{ $category->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="category_id" class="form-label">Head</label>
                                        <select id="head_id" name="head_id" class=" form-select">
                                            <option value="">Select Head</option>
                                            @foreach ($fees as $key => $fee)
                                                <option value="{{ $fee->id }}"
                                                    {{ isset($categoryhead) && $categoryhead->head_id == $fee->id ? 'selected="selected"' : '' }}>
                                                    {{ $fee->head_name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="mb-3  col-md-4">
                                        <label class="form-label" for="amount">Amount<span
                                                style="color:red">*</span></label>
                                        <input type="text" id="amount" name="amount" class="form-control"
                                            placeholder="amount">
                                    </div>
                                    <div class="mb-3  col-md-4">
                                        <label class="form-label" for="amount">Effective Date<span
                                                style="color:red">*</span></label>
                                        <input type="date" id="effective_from" name="effective_from"
                                            class="form-control" placeholder="Effective Date">
                                    </div>
                                    @if (Auth::user()->is_view_user == 0)
                                        <div class="mb-3  col-md-2">
                                            <label class="form-label" for="amount"> </label>
                                            <button type="submit"
                                                class="btn btn-primary form-control me-2 mt-1">Save</button>
                                        </div>
                                    @endif

                                </div>


                            </form>
                            <form action="{{ route('ClassCategoryWiseHeadFeeImport') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                    <h4>Xl Upload From</h4>
                                    <div class="mb-3  col-md-4">
                                        <label class="form-label" for="amount">Xl File </label>
                                        <input type="file" id="file" name="file" class="form-control "
                                            placeholder="Importxl">
                                    </div>
                                    @if (Auth::user()->is_view_user == 0)
                                        <div class="mb-3  col-md-2">
                                            <label class="form-label" for="amount"> </label>
                                            <button type="submit"
                                                class="btn btn-info me-2 mt-1 form-control uploadxl">Upload</button>
                                        </div>
                                    @endif
                                    <div class="mb-3  col-md-3">
                                        <label class="form-label" for="amount"> </label>
                                        <button type="button"
                                            class="btn btn-success me-2 mt-1 form-control downloadxl">Download Sample XL
                                            &nbsp;<i class="fa fa-download"></i></button>
                                    </div>

                                </div>
                            </form>
                            <div class="row" style="margin-bottom: 10px;margin-top: 20px;">
                                <small class="text-light fw-medium d-block">Class, Category Wise Fee Head Amount</small>

                                <div class="table-responsive ">
                                    <table class="table">
                                        <thead class="table-dark">
                                            <tr>
                                                <!-- <th>#</th> -->
                                                <th>#</th>
                                                <th>Fee For</th>
                                                <th>Session</th>
                                                <th>Version</th>
                                                <th>Shift</th>
                                                <th>Class</th>
                                                <th>Category</th>
                                                <th>Head Name</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            @foreach ($payments as $key => $payment)
                                                <tr id="id{{ $payment->id }}">
                                                    <td>
                                                        {{ $key + 1 }}
                                                    </td>
                                                    <td>
                                                        @if ($payment->fee_for == 1)
                                                            Adminssion Fee
                                                        @elseif($payment->fee_for == 2)
                                                            Tuition Fee
                                                        @else
                                                            Exam Fee
                                                        @endif
                                                    </td>


                                                    <td>{{ $payment->session->session_name ?? '' }}</td>
                                                    <td>{{ $payment->version->version_name ?? '' }}</td>
                                                    <td>{{ $payment->shift->shift_name ?? '' }}</td>
                                                    <td>{{ $payment->classes->class_name ?? '' }}</td>
                                                    <td>{{ $payment->category->category_name ?? '' }}</td>
                                                    <td>{{ $payment->head->head_name ?? '' }}</td>
                                                    <td>{{ $payment->amount ?? '' }}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button gallery="button"
                                                                class="btn p-0 dropdown-toggle hide-arrow"
                                                                data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                    class="bx bx-dots-vertical-rounded"></i></button>
                                                            @if (Auth::user()->is_view_user == 0)
                                                                <div class="dropdown-menu" style="">
                                                                    <a class="dropdown-item edit"
                                                                        data-id="{{ $payment->id }}"
                                                                        data-fee_for="{{ $payment->fee_for }}"
                                                                        data-session_id="{{ $payment->session_id }}"
                                                                        data-version_id="{{ $payment->version_id }}"
                                                                        data-shift_id="{{ $payment->shift_id }}"
                                                                        data-class_id="{{ $payment->class_id }}"
                                                                        data-category_id="{{ $payment->category_id }}"
                                                                        data-head_id="{{ $payment->head_id }}"
                                                                        data-amount="{{ $payment->amount }}"><i
                                                                            class="bx bx-edit-alt me-1"></i> Edit</a>
                                                                    <a class="dropdown-item delete"
                                                                        data-url="{{ url('admin/categorywiseheaddelete/' . $payment->id) }}"
                                                                        data-id="{{ $payment->id }}"
                                                                        href="javascript:void(0);"><i
                                                                            class="bx bx-trash me-1"></i> Delete</a>
                                                                </div>
                                                            @endif
                                                        </div>
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


            $(document.body).on('click', '.downloadxl', function() {
                var fee_for = $('#fee_for').val();
                var session_id = $('#session_id').val();
                var version_id = $('#version_id').val();
                var class_code = $('#class_id').val();
                var category_id = $('#category_id').val();
                var effective_from = $('#effective_from').val();

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
                // if(category_id==''){
                //     Swal.fire({
                //                 title: "Warging",
                //                 text: "Please Select Category",
                //                 icon: "warning"
                //             });
                //             return false;
                // }
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


                var feefor = $('#fee_for option:selected').text();
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
                        effective_from,
                        fee_for,
                        session_id,
                        version_id,
                        class_code,
                        category_id,
                        feefor,
                        session,
                        version,
                        classes,
                        category
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
                        link.download =
                            'CategoryWiseHeadFeeExport.xlsx'; // The name of the downloaded file

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

    <script>
        $(function() {
            $(document.body).on('click', '.edit', function() {
                var id = $(this).data('id');
                var fee_for = $(this).data('fee_for');
                var session_id = $(this).data('session_id');
                var version_id = $(this).data('version_id');
                var shift_id = $(this).data('shift_id');
                var class_id = $(this).data('class_id');
                var category_id = $(this).data('category_id');
                var head_id = $(this).data('head_id');
                var amount = $(this).data('amount');
                $('#id').val(id);
                $('#fee_for').val(fee_for);
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
