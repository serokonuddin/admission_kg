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

        .swal2-container {
            z-index: 9999 !important;
            /* Ensure it is above Bootstrap modals */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #dee2e6;
            /* Adjust thickness if needed */
            padding: 10px;
            /* Consistent padding */
            vertical-align: middle;
            /* Align content properly */
        }

        tr {
            border-bottom: 1px solid #dee2e6;
            /* Ensure row separation */
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
                    <li class="breadcrumb-item active" aria-current="page">Inactive Students</li>
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
                                <div class="d-flex align-items-center">
                                    <label class="form-label d-flex align-items-center mb-0">
                                        Select per page:
                                        <select id="pageSize" name="page_size" class="form-select mx-2"
                                            style="width: auto;">
                                            <option value="10" {{ request('page_size', 50) == 10 ? 'selected' : '' }}>
                                                10
                                            </option>
                                            <option value="25" {{ request('page_size', 50) == 25 ? 'selected' : '' }}>
                                                25
                                            </option>
                                            <option value="50" {{ request('page_size', 50) == 50 ? 'selected' : '' }}>
                                                50
                                            </option>
                                            <option value="100" {{ request('page_size', 50) == 100 ? 'selected' : '' }}>
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
                                @if (Auth::user()->group_id != 8)
                                    <div>
                                        <button type="button" class="btn btn-success btn-sm" id="excelDownload"
                                            style="display: none">Excel
                                            Download</button>
                                    </div>
                                @endif
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
                            @if ($students->isEmpty())
                                <p class="text-center alert alert-warning">No students found. Use the search form to find
                                    students.</p>
                            @else
                                <table class="table table-hover table-striped align-middle" id="headerTable">
                                    <thead class="table-dark text-center">
                                        <tr>
                                            <th>SL</th>
                                            <th>Roll</th>
                                            <th>SID</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Remark</th>
                                            <th>Status</th>
                                            @if (Auth::user()->group_id == 2 && Auth::user()->is_view_user == 0)
                                                <th>Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0 text-center">
                                        @foreach ($students as $index => $student)
                                            <tr id="row{{ $student->id }}" class="align-middle">
                                                <td>{{ ($students->currentPage() - 1) * $students->perPage() + $loop->iteration }}
                                                </td>
                                                <td><strong>{{ $student->studentActivity->roll ?? '-' }}</strong></td>
                                                <td style="width: 140px;"><span
                                                        class="badge bg-primary">{{ $student->student_code ?? '-' }}</span>
                                                </td>
                                                <td style="text-align: left">
                                                    <span
                                                        class="fw-bold">{{ $student->first_name . ' ' . $student->last_name }}</span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="text-muted">{{ $student->mobile ? $student->mobile : ($student->father_phone ? $student->father_phone : $student->sms_notification) }}</span>
                                                </td>
                                                <td>
                                                    <div class="remark-box border rounded px-2 py-2 bg-light text-start">
                                                        @if (!empty($student->remark))
                                                            {!! $student->remark !!}
                                                        @else
                                                            <p class="text-muted">No remarks available</p>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($student->studentActivity->status == 0)
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @else
                                                        <span class="badge bg-success">Active</span>
                                                    @endif
                                                </td>
                                                @if (Auth::user()->group_id == 2 && Auth::user()->is_view_user == 0)
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-success px-3"
                                                            onclick="openInactiveModal({{ $student->id }})">
                                                            <i class="bx bx-check-circle"></i> Activate
                                                        </button>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>


                                <!-- Pagination Links -->
                                <div class="d-flex mt-3 justify-content-end items-center dataTables_paginate">
                                    {!! $students->appends([
                                            'search' => request('search'),
                                            'shift_id' => request('shift_id'),
                                            'version_id' => request('version_id'),
                                            'session_id' => request('session_id'),
                                            'class_code' => request('class_code'),
                                            'section_id' => request('section_id'),
                                            'text_search' => request('text_search'),
                                            'searchQuery' => request('searchQuery'),
                                        ])->links() !!}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- Inactive Reason Modal -->
            <div class="modal fade" id="inactiveModal" tabindex="-1" aria-labelledby="inactiveModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="inactiveModalLabel">Make Student as Active</h5>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="inactiveStudentId">
                            <div class="mb-3">
                                <label for="inactiveReason" class="form-label">Reason for Activation</label>
                                <textarea id="inactiveReason" class="form-control" placeholder="Enter reason"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" onclick="confirmInactive()">Confirm</button>
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
        function openInactiveModal(studentId) {
            document.getElementById('inactiveStudentId').value = studentId;
            document.getElementById('inactiveReason').value = ''; // Clear previous reason
            var myModal = new bootstrap.Modal(document.getElementById('inactiveModal'));
            myModal.show();
        }

        function confirmInactive() {
            let studentId = document.getElementById('inactiveStudentId').value;
            let reason = document.getElementById('inactiveReason').value.trim();

            if (!reason) {
                Swal.fire({
                    title: 'Error',
                    text: 'Please enter a reason for inactivation.',
                    icon: 'warning',
                    zIndex: 9999 // Adjust the z-index here (higher than Bootstrap modal's default z-index of 1050)
                });
                return;
            }

            // Send AJAX request using jQuery
            $.ajax({
                type: "POST",
                url: `{{ route('studentActive', '') }}/${studentId}`,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                },
                data: {
                    "_token": "{{ csrf_token() }}", // CSRF token
                    reason: reason
                },
                success: function(response) {
                    // Check if there's a message indicating success
                    if (response.message) {
                        Swal.fire({
                            title: 'Success',
                            text: response.message,
                            icon: 'success',
                            zIndex: 9999 // Adjust the z-index here too
                        }).then(() => {
                            location.reload(); // Reload page to reflect changes
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'Failed to mark inactive.',
                            icon: 'error',
                            zIndex: 9999 // Adjust the z-index here too
                        });
                    }
                },
                error: function(data, errorThrown) {
                    // Handle errors
                    Swal.fire({
                        title: "Error",
                        text: errorThrown,
                        icon: "error",
                        zIndex: 9999 // Adjust the z-index here too
                    });
                }
            });
        }
    </script>
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
                $('#headerTable th:nth-child(8), #headerTable td:nth-child(8)').hide();
                $('#headerTable th:nth-child(9), #headerTable td:nth-child(9)').hide();
                $('#headerTable th:nth-child(10), #headerTable td:nth-child(10)').hide();

                var createdBy = "{{ $createdBy }}";

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
                mywindow.document.write(
                    '<table cellpadding="0" cellspacing="0" class="tableCenter" style="width:100%; border: none;">' +
                    '<tbody>' +
                    '<tr>' +
                    '<td style="width:15%; text-align:center; border: none;">' +
                    '<img src="' + logoUrl + '" style="width:100px;">' +
                    '</td>' +
                    '<td style="width:70%; text-align:center; padding:0px 20px 0px 20px; border: none;">' +
                    '<h3 style="margin-top: 0px; margin-bottom: 4px; color:#0484BD; font-size:24px; font-weight:bold; white-space: nowrap;">BAF Shaheen College Dhaka</h3>' +
                    '<span style="text-align:center; margin-top: 0px; margin-bottom: 0px; font-size:14px;">' +
                    'Dhaka Cantonment, Dhaka-1206' +
                    '</span>' +
                    '<h3 class="text-center" style="color:red; margin-top: 5px; margin-bottom: 0px; font-size:20px; font-weight:bold; white-space: nowrap;">Student List</h3>' +
                    '</td>' +
                    '<td style="width:15%; text-align:center; border: none;"></td>' +
                    '</tr>' +
                    '</tbody>' +
                    '</table>'
                );

                // Add styles
                mywindow.document.write(
                    '<style>' +
                    '@page { size: 210mm 297mm; margin: 5mm 5mm 5mm 5mm; }' +
                    'table { width: 100%; border-collapse: collapse; }' +
                    'th, td { border: 1px solid black; padding: 8px; text-align: left; }' +
                    'th { background-color: #f2f2f2; }' + // Style for header
                    'tr:nth-child(even) { background-color: #f9f9f9; }' + // Alternate row color
                    'img.avatar { display: none }' + // Hide any images with class "avatar"
                    '</style>'
                );

                // Add the content from the print-table and append "Created By" dynamically
                mywindow.document.write('</head><body>');
                mywindow.document.write('<div id="printContent">' + content +
                    '</div>'); // Wrap content in a div

                // "Created By" section after content
                mywindow.document.write(`
            <div style="margin-top: 10px; font-size: 12px; text-align: left;">
                <p><strong>Created By:</strong> ${createdBy}</p>
            </div>
        `);

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

                // Restore pagination and other elements after printing
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

            $('#excelDownload').on('click', function() {
                $.LoadingOverlay("show");
                downloadExcel(globalPage);
                $.LoadingOverlay("hide");
            });
        });

        var url = "{{ route('studentInactiveList') }}";

        function fetch_data(page) {
            var searchQuery = $('#search').val();
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
                '&search=' + searchQuery +
                '&page_size=' + page_size;

            // AJAX call to fetch data
            $.ajax({
                url: url + "?page=" + page + searchtext,
                success: function(data) {
                    // console.log(data, "Data");
                    $('#item-list').html(data); // Populate the student list
                    window.history.pushState("", "", '?page=' + page + searchtext); // Update the URL
                    $('#excelDownload').show(); // Show
                    $('#printBtn').show(); // Show
                }
            });
        }

        function downloadExcel(globalPage) {

            var searchQuery = $('#search').val();
            var session_id = $('#session_id').val();
            var version_id = $('#version_id').val();
            var shift_id = $('#shift_id').val();
            var class_code = $('#class_id').val();
            var section_id = $('#section_id').val();
            var text_search = $('#text_search').val()
            var per_page = $('#pageSize').val();

            // Build the query string
            var queryString = '?page="' + globalPage + '&shift_id=' + shift_id +
                '&version_id=' + version_id +
                '&class_code=' + class_code +
                '&section_id=' + section_id +
                '&session_id=' + session_id +
                '&text_search=' + text_search +
                '&search=' + searchQuery +
                '&per_page=' + per_page;

            // Trigger the download
            const APP_ENV = "{{ config('app.env') }}";

            if (APP_ENV === 'local') {
                var downloadUrl = '/smsnew/admin/export' + queryString;
            } else if (APP_ENV === 'production') {
                var downloadUrl = '/admin/export' + queryString
            }

            // Create a hidden iframe to detect when the download starts
            var iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            iframe.src = downloadUrl;
            // Append iframe to the body to trigger download
            document.body.appendChild(iframe);
            // Use a timeout to hide the loader after the download starts
            monitorDownload();
            // Fallback to hide loader after a maximum time in case of errors
            setTimeout(function() {
                $.LoadingOverlay("hide");
                if (document.body.contains(iframe)) {
                    document.body.removeChild(iframe);
                }
            }, 30000);
        }

        function monitorDownload() {
            // Use a timeout or user action to hide the loader
            setTimeout(function() {
                $.LoadingOverlay("hide");
            }, 5000); // Assume download starts within 5 seconds
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
            $(document.body).on('change', '.attendance_search', function() {
                var start_date = $('#start_date').val();
                var end_date = $('#end_date').val();
                var student_code = $('#student_code_value').val();
                var url = "{{ route('getAttendanceByDate') }}";
                if (start_date && end_date) {
                    $.LoadingOverlay("show");

                    $.ajax({
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: url,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            start_date,
                            end_date,
                            student_code
                        },
                        success: function(response) {
                            $.LoadingOverlay("hide");
                            $('#attendanceDetails').html(response);


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
            $(document.body).on('click', '.studentinfo', function() {
                var student_code = $(this).data('studentcode');
                var session_id = $('#session_id').val();
                var url = "{{ route('getStudentDetails') }}";
                $.LoadingOverlay("show");
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        student_code,
                        session_id
                    },
                    success: function(response) {
                        $.LoadingOverlay("hide");
                        $('.modal-body').html(response);


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
                $('#fullscreenModal').modal('show');
            });
            // dynamic table generation
            $(document.body).on('click', '#searchtop', function() {
                // Get filter values
                var session_id = $('#session_id').val();
                var session_text = $('#session_id option:selected').text();
                var version_id = $('#version_id').val();
                var version_text = $('#version_id option:selected').text();
                var shift_id = $('#shift_id').val();
                var shift_text = $('#shift_id option:selected').text();
                var class_code = $('#class_id').val();
                var class_text = $('#class_id option:selected').text();
                var section_id = $('#section_id').val();
                var section_text = $('#section_id option:selected').text();
                var text_search = $('#text_search').val();
                // Loop through each row in the students table

                // Hide the result table initially
                $('#result-table').hide();
                $('.dynamic-data').empty(); // Clear previous results

                // Logic to generate table rows based on conditions
                var innerData = '';

                // Create a row based on the session_id (if present)
                if (session_id) {
                    innerData += `
            <span>Session: <strong style="margin-left: 5px">${session_id}</strong></span>`;
                }

                // Create a row based on the version_id (if present)
                if (version_id) {
                    innerData +=
                        `<span>Version: <strong style="margin-left: 5px">${version_text}</strong> </span>`;
                }

                // Create a row based on the shift_id (if present)
                if (shift_id) {
                    innerData +=
                        `<span>Shift: <strong style="margin-left: 5px">${shift_text}</strong></span>`;
                }

                // Create a row based on the class_code (if present)
                if (class_code) {
                    innerData +=
                        `<span>Class: <strong style="margin-left: 5px">${class_text}</strong></span>`;
                }

                // Create a row based on the section_id (if present)
                if (section_id) {
                    innerData +=
                        `<span>Section: <strong style="margin-left: 5px" >${section_text}</strong></span>`;
                }

                if (!session_id && !version_id && !shift_id && !class_code && !section_id) {
                    document.getElementById('result-table').style.display = 'none';
                    return;
                }

                // Add closing tag for row
                // innerData += '</tr>';
                $('.dynamic-data').append(innerData);
                // Show the result table after populating rows
                $('#result-table').show();
            });
            // dynamic table generation ends
            $(document.body).on('change', '#search_by', function() {
                if ($('#search').val() && $(this).val()) {
                    location.href = "{{ route('studentInactiveList') }}" + '?search_by=' + $(this)
                        .val() +
                        ' & search=' + $('#search').val();
                }
            });
        });
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
            $(document.body).on('click', '.delete', function() {
                var id = $(this).data('id');
                var url = $(this).data('url');
                Swal.fire({
                    title: 'Do you want to Delete this Student?',
                    showDenyButton: true,
                    confirmButtonText: 'Yes',
                    denyButtonText: 'No',
                    customClass: {
                        actions: 'my-actions',
                        cancelButton: 'order-1 right-gap',
                        confirmButton: 'order-2',
                        denyButton: 'order-3',
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
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
                    } else if (result.isDenied) {

                    }
                })

            });


        });
    </script>
@endsection
