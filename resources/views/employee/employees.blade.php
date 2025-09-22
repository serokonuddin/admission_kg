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
    @php
        function getCauserName($userId, $datetime)
        {
            // Check if the user ID is valid
            if (!$userId) {
                return 'N/A';
            }

            // Fetch the user data from the cache or database
            $user = Cache::remember("user_$userId", 60, function () use ($userId) {
                return DB::table('users')->find($userId);
            });

            // Return the user's name and datetime, or 'N/A' if the user doesn't exist
            return optional($user)->name ? $user->name . ' ' . $datetime : 'N/A';
        }
    @endphp
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            {{-- <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Employees</h4> --}}
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>

                    <li class="breadcrumb-item active" aria-current="page"> Employees Info </li>

                </ol>
            </nav>
            <!-- Basic Bootstrap Table -->
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="dataTables_length" id="DataTables_Table_0_length" style="padding: 5px">
                                <div class="row g-3 searchby">
                                    {{-- <div class="col-sm-3">
                                        <label class="form-label">
                                            <select id="session_id" name="session_id" class=" form-select" required="">
                                                <option value="">Select Session</option>
                                                @foreach ($sessions as $session_code => $session_name)
                                                    <option value="{{ $session_code }}"
                                                        {{ $session_id == $session_code ? 'selected="selected"' : '' }}>
                                                        {{ $session_name }}</option>
                                                @endforeach

                                            </select>
                                        </label>
                                    </div> --}}
                                    <div class="col-sm-3">
                                        <label class="form-label">
                                            <select name="category_id" id="category_id" class=" form-select" required="">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ $category_id == $category->id ? 'selected="selected"' : '' }}>
                                                        {{ $category->category_name }}</option>
                                                @endforeach

                                            </select>
                                        </label>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-label">
                                            <select id="version_id" name="version_id" class=" form-select" required="">
                                                <option value="">Select Version</option>
                                                @foreach ($versions as $version)
                                                    <option value="{{ $version->id }}"
                                                        {{ $version_id == $version->id ? 'selected="selected"' : '' }}>
                                                        {{ $version->version_name }}</option>
                                                @endforeach

                                            </select>
                                        </label>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-label">
                                            <select id="shift_id" name="shift_id" class=" form-select" required="">
                                                <option value="">Select Shift</option>
                                                @foreach ($shifts as $shift)
                                                    <option value="{{ $shift->id }}"
                                                        {{ $shift_id == $shift->id ? 'selected="selected"' : '' }}>
                                                        {{ $shift->shift_name }}</option>
                                                @endforeach

                                            </select>
                                        </label>
                                    </div>
                                    {{-- <div class="col-sm-3">
                                        <label class="form-label">

                                            <select id="class_id" name="class_id" class=" form-select" required="">
                                                <option value="">Select Class</option>
                                                @foreach ($classes as $class)
                                                    <option value="{{ $class->class_code }}"
                                                        {{ $class_id == $class->class_code ? 'selected="selected"' : '' }}>
                                                        {{ $class->class_name }}</option>
                                                @endforeach


                                            </select>
                                        </label>
                                    </div> --}}
                                    {{-- <div class="col-sm-3">
                                        <label class="form-label">
                                            <select id="section_id" name="section_id" class=" form-select" required="">
                                                <option value="">Select Section</option>
                                                @foreach ($sections as $sectiond)
                                                    <option value="{{ $sectiond->id }}"
                                                        {{ $section_id == $sectiond->id ? 'selected="selected"' : '' }}>
                                                        {{ $sectiond->section_name }}</option>
                                                @endforeach

                                            </select>
                                        </label>
                                    </div> --}}

                                    <div class="col-sm-3">
                                        <label class="form-label">
                                            <select id="designation_id" name="designation_id" class=" form-select"
                                                required="">
                                                <option value="">Select Designation</option>
                                                @foreach ($designations as $designation)
                                                    <option value="{{ $designation->id }}"
                                                        {{ $designation_id == $designation->id ? 'selected="selected"' : '' }}>
                                                        {{ $designation->designation_name }}</option>
                                                @endforeach

                                            </select>
                                        </label>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-label">
                                            <select id="for_id" name="for_id" class=" form-select" required="">
                                                <option value="">Select For</option>

                                                <option value="1" {{ $for_id == 1 ? 'selected="selected"' : '' }}>
                                                    Primary
                                                </option>
                                                <option value="2" {{ $for_id == 2 ? 'selected="selected"' : '' }}>
                                                    Secondary
                                                </option>
                                                <option value="3" {{ $for_id == 3 ? 'selected="selected"' : '' }}>
                                                    College
                                                </option>


                                            </select>
                                        </label>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-label">
                                            <input type="text" name="text_search" class="form-control" id="text_search"
                                                value="{{ $text_search }}" placeholder="search by name,id,mobile,email" />
                                    </div>
                                    <div class="col-sm-3 d-flex align-items-center">
                                        <button type="button" id="search" class="btn btn-primary me-2">Search</button>
                                        <button type="button" id="resetbtn"
                                            class="btn btn-danger me-2  btn-block">Reset</button>

                                    </div>
                                </div>
                            </div>
                        </div>
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
                                    <button type="button" id="printBtn" class="btn btn-success btn-sm">Print</button>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-success btn-sm" id="excelDownload">Excel
                                        Download</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="print-table">
                        @if ($employees->isEmpty())
                            <div class="text-center alert alert-warning">
                                No employees found. Use the search form to find employees.
                            </div>
                        @else
                            <table class="table" id="headerTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>SL</th>
                                        <th>Name</th>
                                        <th>JoinDate</th>
                                        <th>Email/Phone</th>
                                        <th>DOB</th>
                                        <th>Shift</th>
                                        <th>Subject</th>
                                        <th>Created By</th>
                                        <th>Updated By</th>
                                        @if ((Auth::user()->group_id == 2 || Auth::user()->group_id == 6) && Auth::user()->is_view_user == 0)
                                            <th>Actions</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($employees as $index => $employee)
                                        <tr id="row{{ $employee->id }}">
                                            <!-- Calculate sequential serial number -->
                                            <td>{{ ($employees->currentPage() - 1) * $employees->perPage() + $loop->iteration }}
                                            </td>
                                            <td data-bs-toggle="modal" class="employeeinfo"
                                                data-id="{{ $employee->id }}" data-bs-target="#fullscreenModal">
                                                <img src="{{ !empty($employee->photo) ? $employee->photo : asset('public/employee.png') }}"
                                                    alt="Avatar" class="rounded-circle avatar avatar-xs">
                                                {{ $employee->employee_name }}
                                            </td>
                                            <td>{{ $employee->join_date ?? '' }}</td>
                                            <td>{{ $employee->email ?? '' }}<br />{{ $employee->mobile ?? '' }}</td>
                                            <td>{{ $employee->dob ?? '' }}</td>
                                            <td>{{ $employee->shift->shift_name ?? '' }}</td>
                                            <td>{{ $employee->subject->subject_name ?? '' }}</td>
                                            <td>
                                                {{ getCauserName($employee->created_by, $employee->created_at) }}
                                            </td>
                                            <td>
                                                {{ getCauserName($employee->updated_by, $employee->updated_at) }}
                                            </td>
                                            @if ((Auth::user()->group_id == 2 || Auth::user()->group_id == 6) && Auth::user()->is_view_user == 0)
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn p-0 dropdown-toggle hide-arrow"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bx bx-dots-vertical-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            @if (Auth::user()->getMenu('employees.edit', 'name') && Auth::user()->is_view_user == 0)
                                                                <a class="dropdown-item edit"
                                                                    href="{{ route('employees.edit', $employee->id) }}">
                                                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                                                </a>
                                                            @endif
                                                            @if (Auth::user()->getMenu('employees.destroy', 'name') &&
                                                                    Auth::user()->group_id == 2 &&
                                                                    Auth::user()->is_view_user == 0)
                                                                <a class="dropdown-item delete"
                                                                    data-url="{{ route('employees.destroy', $employee->id) }}"
                                                                    data-id="{{ $employee->id }}"
                                                                    href="javascript:void(0);">
                                                                    <i class="bx bx-trash me-1"></i> Delete
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            <div class="d-flex justify-content-between align-items-center px-3 mt-3" id="total_records">
                                <!-- Page Range Display -->
                                <p>
                                    Showing
                                    <strong>{{ ($employees->currentPage() - 1) * $employees->perPage() + 1 }}</strong>
                                    to
                                    <strong>{{ min($employees->currentPage() * $employees->perPage(), $employees->total()) }}</strong>
                                    of <strong>{{ $employees->total() }}</strong> employees.
                                </p>

                                <!-- Pagination Links -->
                                <div class="dataTables_paginate paging_simple_numbers">
                                    {!! $employees->appends(request()->query())->links('bootstrap-4') !!}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="fullscreenModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalFullTitle">Employee Profile</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="background-color: #f5f2f2">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                Close
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->

        <div class="content-backdrop fade"></div>
    </div>

    <script type="text/javascript">
        $(function() {
            $('#printBtn').on('click', function() {
                // Hide pagination before printing
                $('.dataTables_paginate').hide();
                $('#total_records').hide();
                $('#headerTable th:nth-child(8), #headerTable td:nth-child(8)').hide();
                $('#headerTable th:nth-child(9), #headerTable td:nth-child(9)').hide();
                $('#headerTable th:nth-child(10), #headerTable td:nth-child(10)').hide();

                var createdBy = "{{ $createdBy }}"


                // Get the content element
                var contentElement = document.getElementById('print-table');
                var content = contentElement.innerHTML;
                var footerContent = `
        <footer style="position: absolute; bottom: 0; width: 100%; text-align: left; font-size: 12px; padding: 10px 0;">
            <p><strong>Created By:</strong> ${createdBy}</p>
        </footer>
    `;

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
                    '<h3 class="text-center" style="color:red; margin-top: 5px; margin-bottom: 0px; font-size:20px; font-weight:bold; white-space: nowrap;">Employee List</h3>' +
                    '</td>' +
                    '<td style="width:15%; text-align:center; border: none;"></td>' +
                    '</tr>' +
                    '</tbody>' +
                    '</table>' +
                    '</td>' +
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
                    'img.avatar { display: none }' + // Image styles
                    '</style>'
                );
                mywindow.document.write(
                    '<style>body { position: relative; min-height: 100%; padding-bottom: 65px; }</style>'
                );
                // Add the content from the print-table
                mywindow.document.write('</head><body>');
                mywindow.document.write(content);
                mywindow.document.write(footerContent)
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
                $('#headerTable th:nth-child(8), #headerTable td:nth-child(8)').show();
                $('#headerTable th:nth-child(9), #headerTable td:nth-child(9)').show();
                $('#headerTable th:nth-child(10), #headerTable td:nth-child(10)').show();
            });
        });
        $(function() {
            $(document.body).on('click', '.employeeinfo', function() {
                var id = $(this).data('id');

                var url = "{{ route('getEmployeeDetails') }}";
                $.LoadingOverlay("show");
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id
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
            $(document.body).on('click', '#print', function() {

            });

            $(document).ready(function() {
                // Trigger search when the Search button is clicked
                $('#search').on('click', function() {
                    performSearch();
                });

                // Trigger search when Enter key is pressed in the #text_search input
                $('#text_search').on('keypress', function(e) {
                    if (e.which === 13) { // Enter key code
                        e.preventDefault();
                        performSearch(); // Perform the search
                    }
                });

                $('#pageSize').on('change', function() {
                    performSearch(); // Reset to page 1 when the page size changes
                });

                var globalPage = 1;
                // Handle pagination links
                // $(document).on('click', '.pagination a', function(e) {
                //     e.preventDefault();
                //     var page = $(this).attr('href').split('page=')[1];
                //     globalPage = page; // Update the global page variable
                //     fetch_data(page);
                // });

                $('#excelDownload').on('click', function() {
                    $.LoadingOverlay("show");
                    downloadExcel(globalPage);
                    $.LoadingOverlay("hide");
                });



                // Perform the search
                function performSearch() {
                    // Collect input values
                    var session_id = $('#session_id').val();
                    var version_id = $('#version_id').val();
                    var shift_id = $('#shift_id').val();
                    var class_id = $('#class_id').val();
                    var section_id = $('#section_id').val();
                    var designation_id = $('#designation_id').val();
                    var category_id = $('#category_id').val();
                    var text_search = $('#text_search').val();
                    var for_id = $('#for_id').val();
                    var page_size = $('#pageSize').val();

                    // Build query parameters dynamically, excluding empty values
                    var queryParams = {};
                    if (session_id) queryParams.session_id = session_id;
                    if (version_id) queryParams.version_id = version_id;
                    if (shift_id) queryParams.shift_id = shift_id;
                    if (class_id) queryParams.class_id = class_id;
                    if (section_id) queryParams.section_id = section_id;
                    if (designation_id) queryParams.designation_id = designation_id;
                    if (category_id) queryParams.category_id = category_id;
                    if (text_search) queryParams.text_search = text_search;
                    if (for_id) queryParams.for_id = for_id;
                    if (page_size) queryParams.page_size = page_size;

                    // Construct the URL with query parameters
                    var queryString = $.param(queryParams);
                    var url = "{{ route('employees.index') }}" + (queryString ? '?' + queryString : '');

                    // Redirect to the constructed URL
                    location.href = url;
                }
            });

            // var url = "{{ route('employees.index') }}";

            // function fetch_data(page) {
            //     var category_id = $('#category_id').val();
            //     var version_id = $('#version_id').val();
            //     var shift_id = $('#shift_id').val();
            //     var for_id = $('#for_id').val();
            //     var text_search = $('#text_search').val()
            //     var page_size = $('#pageSize').val();

            //     // Build the query string
            //     var searchtext = '&shift_id=' + shift_id +
            //         '&version_id=' + version_id +
            //         '&category_id=' + category_id +
            //         '&shift_id=' + shift_id +
            //         '&for_id=' + for_id +
            //         '&text_search=' + text_search +
            //         '&page_size=' + page_size;

            //     // AJAX call to fetch data
            //     $.ajax({
            //         url: url + "?page=" + page + searchtext,
            //         success: function(data) {
            //             // console.log(data, "Data");
            //             $('#item-list').html(data); // Populate the student list
            //             window.history.pushState("", "", '?page=' + page +
            //                 searchtext); // Update the URL
            //             $('#excelDownload').show(); // Show
            //             $('#printBtn').show(); // Show
            //         }
            //     });
            // }

            function downloadExcel(globalPage) {

                // Collect input values
                var session_id = $('#session_id').val();
                var version_id = $('#version_id').val();
                var shift_id = $('#shift_id').val();
                var class_code = $('#class_id').val();
                var section_id = $('#section_id').val();
                var designation_id = $('#designation_id').val();
                var category_id = $('#category_id').val();
                var text_search = $('#text_search').val();
                var for_id = $('#for_id').val();
                var per_page = $('#pageSize').val();


                // Build the query string
                var queryString = '?page="' + globalPage + '&shift_id=' + shift_id +
                    '&version_id=' + version_id +
                    '&class_code=' + class_code +
                    '&section_id=' + section_id +
                    '&session_id=' + session_id +
                    '&text_search=' + text_search +
                    '&designation_id=' + designation_id +
                    '&category_id=' + category_id +
                    '&for_id=' + for_id +
                    '&per_page=' + per_page;

                // Trigger the download
                const APP_ENV = "{{ config('app.env') }}";

                if (APP_ENV === 'local') {
                    var downloadUrl = '/bafsd/admin/employee/export' + queryString;
                } else if (APP_ENV === 'production') {
                    var downloadUrl = '/admin/employee/export' + queryString
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


            // Reset button functionality
            $(document.body).on('click', '#resetbtn', function() {
                // Clear all inputs
                $('#session_id').val('');
                $('#version_id').val('');
                $('#shift_id').val('');
                $('#class_id').val('');
                $('#section_id').val('');
                $('#designation_id').val('');
                $('#category_id').val('');
                $('#text_search').val('');
                $('#for_id').val('');

                // Redirect to the base URL without query parameters
                location.href = "{{ route('employees.index') }}";
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
            $(document.body).on('click', '.delete', function() {
                var id = $(this).data('id');
                var url = $(this).data('url');
                Swal.fire({
                    title: 'Do you want to Delete this employee?',
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
