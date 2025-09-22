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
        <div class="container-xxl flex-grow-1 container-p-y">

            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">Dashboard /</span> Student Promotion
            </h4>

            <div class="col-md mb-4 mb-md-0">
                <form id="formAccountSettings" method="POST" action="{{ route('studentPromotionxl') }}"
                    enctype="multipart/form-data">
                    <div class="card">

                        <div class="card-body">

                            <!-- Filter Form -->
                            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />

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
                                    <label for="version_id" class="form-label">Version </label>
                                    <select id="version_id" name="version_id" class=" form-select" required="">
                                        <option value="">Select Version</option>
                                        @foreach ($versions as $version)
                                            <option value="{{ $version->id }}">{{ $version->version_name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="shift_id" class="form-label">Shift </label>
                                    <select id="shift_id" name="shift_id" class=" form-select" required="">
                                        <option value="">Select Shift</option>
                                        @foreach ($shifts as $shift)
                                            <option value="{{ $shift->id }}">{{ $shift->shift_name }}</option>
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
                                    <label for="section_id" class="form-label">Section <span
                                            style="color: red">*</span></label>
                                    <select id="section_id" name="section_id" class=" form-select" required="">
                                        <option value="">Select Section</option>

                                    </select>
                                </div>

                                <div class="col-sm-4">
                                    <label for="studentXl" class="form-label">Excel (Allowed formats: XLSX, XLS, CSV. Max
                                        file size: 200 KB.)</label>
                                    <input type="file" name="studentXl" class="form-control" id="studentXl" />
                                </div>


                                @if (Auth::user()->is_view_user == 0)
                                    <div class="mb-3 col-md-2">
                                        <label class="form-label" for="search"></label>
                                        <button type="submit" class="btn btn-info form-control me-2 mt-1">Upload</button>
                                    </div>
                                @endif
                                <div class="mb-3 col-md-2">
                                    <label class="form-label" for="search"></label>
                                    <button type="button" id="getPromostionStudent"
                                        class="btn btn-primary form-control me-2 mt-1">Search</button>
                                </div>


                            </div>


                        </div>
                    </div>
                </form>
            </div>

            <!-- Merit List Results -->
            <form id="formAccountSettings" method="POST" action="{{ route('studentPromotion.store') }}"
                enctype="multipart/form-data"> <input type="hidden" name="_token" id="csrf-token"
                    value="{{ Session::token() }}" />
                <div class="table-responsive text-nowrap" id="resultdata">
                    <!-- Results will be dynamically loaded here -->
                </div>
            </form>
        </div>

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




        $(document).ready(function() {
            $('#getPromostionStudent').on('click', function() {
                var session_id = $('#session_id').val();
                var class_code = $('#class_code').val();
                var section_id = $('#section_id').val();
                var version_id = $('#version_id').val();
                var shift_id = $('#shift_id').val();

                if (session_id && class_code && shift_id && section_id) {
                    $.LoadingOverlay("show");
                    $.ajax({
                        type: "POST",
                        url: "{{ route('getPromostionStudent') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            session_id: session_id,
                            class_code: class_code,
                            section_id: section_id,
                            version_id: version_id,
                            shift_id: shift_id
                        },
                        success: function(response) {
                            $('#resultdata').html(response);
                            $.LoadingOverlay("hide");
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                title: "Error",
                                text: error,
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
        });
    </script>
@endsection
