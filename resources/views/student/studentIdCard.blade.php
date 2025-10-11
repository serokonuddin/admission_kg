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

        .form-label {
            width: 100% !important;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"> Students ID Card</li>
                </ol>
            </nav>
            <!-- Basic Bootstrap Table -->
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="dataTables_length" id="DataTables_Table_0_length" style="padding: 5px">
                                <div class="row g-3 searchby">
                                    <!-- Existing Filters -->
                                    <div class="col-sm-3">
                                        <label class="form-label">
                                            <select id="session_id" name="session_id" class="form-select" required="">
                                                <option value="">Select Session</option>
                                                @foreach ($sessions as $session)
                                                    <option value="{{ $session->id }}">{{ $session->session_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </label>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-label">
                                            <select id="version_id" name="version_id" class="form-select" required="">
                                                <option value="">Select Version</option>
                                                @foreach ($versions as $version)
                                                    <option value="{{ $version->id }}">{{ $version->version_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </label>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-label">
                                            <select id="shift_id" name="shift_id" class="form-select" required="">
                                                <option value="">Select Shift</option>
                                                @foreach ($shifts as $shift)
                                                    <option value="{{ $shift->id }}">{{ $shift->shift_name }}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                    </div>
                                    <div class="col-sm-3">
                                        <select id="class_id" name="class_id" class=" form-select" required="">
                                            <option value="">Select Class</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}"
                                                    {{ isset($activity) && $activity->class_id == $class->id ? 'selected="selected"' : '' }}>
                                                    {{ $class->class_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-label">
                                            <select id="section_id" name="section_id" class="form-select" required="">
                                                <option value="">Select Section</option>
                                                @foreach ($sections as $section)
                                                    <option value="{{ $section->id }}">{{ $section->section_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </label>
                                    </div>
                                    <div class="col-sm-3 me-1">
                                        <label class="form-label">
                                            <input type="text" name="text_search" class="form-control" id="text_search"
                                                value="" placeholder="Search by name, id, mobile, email" />
                                        </label>
                                    </div>
                                    <div class="col-sm-3 d-flex align-items-center">
                                        <button type="button" id="searchtop"
                                            class="btn btn-primary me-2  btn-block">Search</button>
                                        <button type="button" id="resetbtn"
                                            class="btn btn-danger me-2  btn-block">Reset</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Pagination Size Selector -->
                        <div class="d-flex justify-content-between align-items-center px-4 pb-2">
                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="d-flex align-items-center d-none">
                                    <label class="form-label d-flex align-items-center mb-0">
                                        Select per page:
                                        <select id="pageSize" name="page_size" class="form-select mx-2"
                                            style="width: auto;">
                                            <option value="10" {{ request('page_size', 10) == 10 ? 'selected' : '' }}>
                                                10
                                            </option>
                                            <option value="25" {{ request('page_size', 10) == 25 ? 'selected' : '' }}>
                                                25
                                            </option>
                                            <option value="50" {{ request('page_size', 10) == 50 ? 'selected' : '' }}>
                                                50
                                            </option>
                                            <option value="100" {{ request('page_size', 10) == 100 ? 'selected' : '' }}>
                                                100
                                            </option>
                                        </select>
                                        entries
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-sapce-beteween gap-3">

                                <div>
                                    <button type="button" id="printBtn" class="btn btn-success btn-sm"
                                        style="display: none">Print</button>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-success" id="excelDownload"
                                        style="display: none">Excel
                                        Download</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div id="print-table">
                        <div id="result-table" style="display: none;">
                            <p class="border border-gray-500 p-2 dynamic-data"
                                style="display: flex; justify-content: space-around;">
                            </p>
                        </div>

                        <div class="table-responsive" id="item-list">

                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="fullscreenModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalFullTitle">Student Profile</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="background-color: #f5f2f2">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                Close
                            </button>
                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->
        <div class="content-backdrop fade"></div>
    </div>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                showConfirmButton: true,
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
        // Print button click event
        $(function() {
            $('#printBtn').on('click', function() {
                // Hide pagination before printing
                $('.dataTables_paginate').hide();
                $('#total_records').hide();



                // Get the content element
                var contentElement = document.getElementById('print-table');
                var content = contentElement.innerHTML;
                // Laravel's asset() function resolved server-side
                var logoUrl =
                    "{{ asset('public/frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png') }}";

                // Open a new window for printing
                var mywindow = window.open('', 'Print');

                // Write HTML structure and styles to the new window
                mywindow.document.write('<html><head><title>Print Preview</title>');

                // Add the top section with college logo, title, and address
                // mywindow.document.write(
                //     '<table cellpadding="0" cellspacing="0" class="tableCenter" style="width:100%; border: none;">' +
                //     '<tbody>' +
                //     '<tr>' +
                //     '<td style="width:15%; text-align:center; border: none;">' +
                //     '<img src="' + logoUrl + '" style="width:100px;">' +
                //     '</td>' +
                //     '<td style="width:70%; text-align:center; padding:0px 20px 0px 20px; border: none;">' +
                //     '<h3 style="margin-top: 0px; margin-bottom: 4px; color:#0484BD; font-size:24px; font-weight:bold; white-space: nowrap;">BAF Shaheen College Dhaka</h3>' +
                //     '<span style="text-align:center; margin-top: 0px; margin-bottom: 0px; font-size:14px;">' +
                //     'Dhaka Cantonment, Dhaka-1206' +
                //     '</span>' +
                //     '<h3 class="text-center" style="color:red; margin-top: 5px; margin-bottom: 0px; font-size:20px; font-weight:bold; white-space: nowrap;">Student List</h3>' +
                //     '</td>' +
                //     '<td style="width:15%; text-align:center; border: none;"></td>' +
                //     '</tr>' +
                //     '</tbody>' +
                //     '</table>' +
                //     '</td>' +
                //     '</tr>' +
                //     '</tbody>' +
                //     '</table>'
                // );

                // Add styles
                mywindow.document.write(
                    '<style>' +
                    '@page { size: 210mm 297mm; margin: 5mm 5mm 5mm 5mm; }' +
                    'table { width: 100%; border-collapse: collapse; }' +
                    'th, td { border: 1px solid black; padding: 8px; text-align: left; }' +
                    'th { background-color: #f2f2f2; }' + // Style for header
                    'tr:nth-child(even) { background-color: #f9f9f9; }' + // Alternate row color
                    'img.avatar { display: none }' + // Image styles
                    '</style>'
                );
                mywindow.document.write(
                    '<style>body { position: relative; min-height: 100%;  }</style>'
                );
                // Add the content from the print-table
                mywindow.document.write('</head><body>');
                mywindow.document.write(content);
                mywindow.document.write('</body></html>');

                // Close the document and focus on the window
                mywindow.document.close();
                mywindow.focus();

                // Trigger the print dialog
                mywindow.print();

                // Close the print window after it's ready
                var myDelay = setInterval(checkReadyState, 1000);

                function checkReadyState() {
                    if (mywindow.document.readyState === 'complete') {
                        clearInterval(myDelay);
                        mywindow.close();
                    }
                }
                // Optionally, restore pagination and other elements after printing
                $('.dataTables_paginate').show();
                $('#total_records').show();
            });
        });
        // Search button click event
        $(function() {
            // Trigger search when the Search button is clicked
            $('#searchtop').on('click', function() {
                $.LoadingOverlay("show");
                fetch_data(1);
                $.LoadingOverlay("hide");
            });

            // Trigger search when Enter key is pressed in the #text_search input
            $('#text_search').on('keypress', function(e) {
                if (e.which === 13) { // Enter key code
                    e.preventDefault();
                    fetch_data(1); // Perform the search
                }
            });

            // Handle pagination size change
            $('#pageSize').on('change', function() {
                fetch_data(1); // Reset to page 1 when the page size changes
            });
            var globalPage = 1;
            // Handle pagination links
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                globalPage = page; // Update the global page variable
                fetch_data(page);
            });
        });

        var url = "{{ route('getStudentIDCards') }}";

        function fetch_data(page) {
            var session_id = $('#session_id').val();
            var version_id = $('#version_id').val();
            var shift_id = $('#shift_id').val();
            var class_code = $('#class_id').val();
            var section_id = $('#section_id').val();
            var text_search = $('#text_search').val()
            var page_size = $('#pageSize').val();

            // Build the query string
            var searchtext = '&shift_id=' + shift_id +
                '&version_id=' + version_id +
                '&class_code=' + class_code +
                '&section_id=' + section_id +
                '&session_id=' + session_id +
                '&text_search=' + text_search +
                '&page_size=' + page_size;

            // AJAX call to fetch data
            $.ajax({
                url: url + "?page=" + page + searchtext,
                success: function(data) {
                    // console.log(data, "Data");
                    $('#item-list').html(data); // Populate the student list
                    window.history.pushState("", "", '?page=' + page + searchtext); // Update the URL
                    $('#printBtn').show(); // Show
                }
            });
        }
    </script>
    <script>
        // Function to reset filters
        function resetFilters() {
            // Reset all dropdowns and input fields to their default state
            $('#session_id').val('');
            $('#version_id').val('');
            $('#shift_id').val('');
            $('#class_id').val('');
            $('#section_id').val('');
            $('#text_search').val('');

            // Hide the result table and clear dynamic data
            document.getElementById('result-table').style.display = 'none';
            $('.dynamic-data').empty();

            // Hide specific buttons or elements
            $('#excelDownload').hide();
        }

        // Function to clear the URL
        function clearURL() {
            const urlWithoutParams = window.location.origin + window.location.pathname;
            window.history.pushState({}, document.title, urlWithoutParams);
        }

        // Check sessionStorage for reload tracking
        $(document).ready(function() {
            if (!sessionStorage.getItem('reloadedOnce')) {
                // First reload: Clear the URL and reload the page
                clearURL();
                sessionStorage.setItem('reloadedOnce', true); // Mark as reloaded once
                location.reload();
            } else {
                // Second reload: Clear the table and reset filters
                sessionStorage.removeItem('reloadedOnce'); // Clear the reload tracking
                resetFilters();
            }
        });

        // Attach event listener to the reset button
        $(document.body).on('click', '#resetbtn', function() {
            sessionStorage.removeItem('reloadedOnce'); // Reset sessionStorage tracking
            location.reload(); // Reload the page to trigger the sequence
        });
    </script>

    <script type="text/javascript">
        $(function() {
            $(document.body).on('change', '#class_id', function() {
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
