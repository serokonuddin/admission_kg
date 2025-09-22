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

        @media print {

            /* Hide action buttons and images during printing */
            .btn-group,
            .btn,
            .studentinfo img {
                display: none !important;
            }

            /* Make the table span the entire width for print */
            .table {
                width: 100% !important;
            }

            /* Avoid breaking the table */
            .table-responsive {
                overflow: visible !important;
            }
        }

        .statistics.table>:not(caption)>*>* {
            padding: 0.125rem 1.25rem !important;
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
                    <li class="breadcrumb-item active" aria-current="page">Students</li>
                </ol>
            </nav>
            <!-- Basic Bootstrap Table -->
            <div class="card" id="print-table">
                @php
                    $genderdata = collect($students)->groupBy('gender');
                @endphp
                <div class="card-header">
                    <button class="btn btn-primary mb-3" onclick="printTables()" id="printBtn"
                        style="float: right">Print</button>
                    {{-- <table class="table table-hover table-bordered rounded-lg mt-2 mb-2 statistics">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>Session</th>
                                <th>Class</th>
                                <th>Section</th>
                                <th>Total</th>
                                <th>Male</th>
                                <th>Female</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <tr>
                                <td style="text-align:center;font-weight:bold;">
                                    {{$employeeActivity->session_name  }}
                                </td>
                                <td style="text-align:center;font-weight:bold;">
                                    {{ $employeeActivity->class_name }}
                                </td>
                                <td style="text-align:center;font-weight:bold;">
                                    {{ $employeeActivity->section_name }}
                                </td>
                                <td style="text-align:center;font-weight:bold;">
                                    {{ count($students ?? []) }}
                                </td>
                                <td style="text-align:center;font-weight:bold;">
                                    {{ count($genderdata[1] ?? []) }}
                                </td>
                                <td style="text-align:center;font-weight:bold;">
                                    {{ count($genderdata[2] ?? []) }}
                                </td>
                            </tr>
                        </tbody>
                    </table> --}}
                    <div class="table-responsive">
                        <table class="table table-bordered statistics">
                            <tr>
                                <td>Session:</td>
                                <td> {{ $employeeActivity->classes->class_code > 10
                                    ? $employeeActivity->session->college_session ?? '-'
                                    : $employeeActivity->session->session_name ?? '-' }}
                                </td>
                                {{-- <td>{{ isset($employeeActivity->session_name) ? $employeeActivity->session_name : '' }}</td> --}}
                                <td>Section:</td>
                                <td>{{ isset($employeeActivity->section_name) ? $employeeActivity->section_name : '' }}</td>

                            </tr>
                            <tr>
                                <td>Version:</td>
                                <td>{{ isset($employeeActivity->version_name) ? $employeeActivity->version_name : '' }}</td>


                                <td>
                                    Total
                                </td>
                                <td>
                                    {{ count($students ?? []) }}
                                </td>
                            </tr>
                            <tr>
                                <td>Shift:</td>
                                <td>{{ isset($employeeActivity->shift_name) ? $employeeActivity->shift_name : '' }}</td>
                                <td>
                                    Male
                                </td>
                                <td>
                                    {{ count($genderdata[1] ?? []) }}
                                </td>

                            </tr>
                            <tr>
                                <td>Class:</td>
                                <td>{{ isset($employeeActivity->class_name) ? $employeeActivity->class_name : '' }}</td>
                                <td>
                                    Female
                                </td>
                                <td>
                                    {{ count($genderdata[2] ?? []) }}
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Add fixed height and overflow styles -->
                    <div class="table-responsive scrollable rounded" style="max-height: 600px;">
                        <table class="table table-hover table-bordered rounded-lg" id="headerTable">
                            <thead class="table-dark" style="position: sticky; top: 0; z-index: 1000;">
                                <tr>
                                    <th>SL</th>
                                    <th>Roll</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Father</th>
                                    <th>Mother</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($students as $student)
                                    <tr id="row{{ $student->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $student->studentActivity->roll ?? '-' }}</td>
                                        <td data-bs-toggle="#modal" data-bs-target="#fullscreenModal" class="studentinfo"
                                            data-studentcode="{{ $student->student_code }}">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $student->photo ?? asset('public/student.png') }}"
                                                    alt="Avatar" class="rounded-circle avatar avatar-xs me-2"
                                                    style="width: 35px; height: 35px; object-fit: cover;">
                                                {{ $student->first_name . ' ' . $student->last_name }}
                                            </div>
                                        </td>
                                        <td>
                                            {{ $student->sms_notification ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $student->father_name ?? 'NA' }}<br>
                                            {{ $student->father_phone ?? 'NA' }}
                                        </td>
                                        <td>
                                            {{ $student->mother_name ?? 'NA' }}<br>
                                            {{ $student->mother_phone ?? 'NA' }}
                                        </td>
                                        {{-- <td> <span class="badge bg-gray">
                                                {{ $student->studentActivity->classes->class_code > 10
                                                    ? $student->studentActivity->session->college_session ?? '-'
                                                    : $student->studentActivity->session->session_name ?? '-' }}
                                            </span>
                                        </td> --}}

                                        <td>
                                            <div class="btn-group" role="group" aria-label="Action Buttons">
                                                <a class="btn btn-sm btn-primary d-flex align-items-center gap-1"
                                                    href="{{ route('students.edit', $student->id) }}">
                                                    <i class="bx bx-edit-alt"></i>
                                                    Edit
                                                </a>
                                                <a class="btn btn-sm btn-secondary d-flex align-items-center gap-1"
                                                    href="{{ route('students.show', $student->id) }}">
                                                    <i class="bx bx-low-vision"></i>
                                                    View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="fullscreenModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalFullTitle">Student Profile</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="background-color: #f5f2f2"></div>
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
            $(document.body).on('click', '#search', function() {
                var session_id = $('#session_id').val();
                var version_id = $('#version_id').val();
                var shift_id = $('#shift_id').val();
                var class_id = $('#class_id').val();
                var section_id = $('#section_id').val();
                var text_search = $('#text_search').val();
                location.href = "{{ route('students.index') }}" + '?shift_id=' + shift_id +
                    ' & version_id=' + version_id + '& class_id=' + class_id + '& section_id=' +
                    section_id + '& session_id=' + session_id + '& text_search=' + text_search;





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
    <script>
        function printTables() {
            // Hide pagination and unwanted elements before printing
            $('#printBtn').hide();
            $('#headerTable th:nth-child(8), #headerTable td:nth-child(8)').hide();
            $('#headerTable th:nth-child(7), #headerTable td:nth-child(7)').hide();
            $('#headerTable th:nth-child(10), #headerTable td:nth-child(10)').hide();

            // Get the createdBy variable from the Blade template
            var createdBy = 'Admin';

            // Get the content element
            var contentElement = document.getElementById('print-table');
            var content = contentElement.innerHTML;
            var footerContent = `
                <footer style="position: absolute; bottom: 0; width: 100%; text-align: left; font-size: 12px; padding: 0 0;">
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
                'th { background-color: #f2f2f2; border-bottom: 2px solid black; }' + // Style for header
                'tr:nth-child(even) { background-color: #f9f9f9; }' + // Alternate row color
                'img.avatar { display: none }' + // Image styles
                'table th, table td { border: 1px solid black; }' + // Ensure borders for both header and data cells
                '</style>'
            );

            // Add the content from the print-table
            mywindow.document.write('</head><body>');
            mywindow.document.write(content);
            // mywindow.document.write(footerContent);
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

            $('#printBtn').show();
            $('#headerTable th:nth-child(8), #headerTable td:nth-child(8)').show();
            $('#headerTable th:nth-child(7), #headerTable td:nth-child(7)').show();
            $('#headerTable th:nth-child(10), #headerTable td:nth-child(10)').show();
        }
    </script>
@endsection
