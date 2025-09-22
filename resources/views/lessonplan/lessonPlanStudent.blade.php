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

        .p-10 {
            padding: 10px !important;
        }

        .m-r-10 {
            margin-right: 10px !important;
        }

        .childdata {
            display: none;
            background-color: #98fded;
        }

        .form-label {

            width: 100%;
        }

        .badge {
            float: right;
        }

        .tab-content {
            padding: .5px;
        }
    </style>
    <style>
        td,
        th {
            border: 1px solid #eee !important;
        }

        @media (min-width: 576px) {
            .accordion-body .col-sm-3 {
                flex: 0 0 auto;
                width: 26%;
            }

            .accordion-body .col-sm-9 {
                flex: 0 0 auto;
                width: 74%;
            }
        }

        .nav-link .color {
            color: white !important;
        }

        .nav-tabs .nav-item .nav-link {
            color: #ffffff;
            border: 0;
            border-radius: 0;
        }

        .table-class-schedule {
            border-radius: .625rem;
            border: 1px solid #e7e7e7;
            border-top: 0;
            border-bottom: 0;
        }

        .table {
            --bs-table-bg: transparent;
            --bs-table-accent-bg: transparent;
            --bs-table-striped-color: #222;
            --bs-table-striped-bg: rgba(0, 0, 0, 0.05);
            --bs-table-active-color: #222;
            --bs-table-active-bg: rgba(0, 0, 0, 0.1);
            --bs-table-hover-color: #222;
            --bs-table-hover-bg: rgba(0, 0, 0, 0.075);
            width: 100%;
            margin-bottom: 1rem;
            color: #222;
            vertical-align: top;
            border-color: #e7e7e7;
        }

        .font-size-18 {
            font-size: 1.13rem;
        }

        .bg-primary {
            background-color: #f0c24b !important;
        }

        .text-white {
            color: #fff !important;
            font-weight: bold;
        }

        .text-uppercase {
            text-transform: uppercase !important;
        }

        .bg-purple {
            background-color: #a597e7 !important;
        }

        .bg-pink {
            background-color: #ea77ad !important;
        }

        .text-primary {
            color: #f0c24b !important;
            font-weight: bold;
        }

        .text-purple {
            color: #a597e7 !important;
            font-weight: bold;
        }

        .text-pink {
            color: #ea77ad !important;
            font-weight: bold;
        }

        .text-danger,
        .text-info,
        .text-success,
        .text-danger,
        .text-secondary,
        .text-dark {
            font-weight: bold;
        }
    </style>
    @php
        $color = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'dark', 'success'];
    @endphp


    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Lesson Plan</li>
                </ol>
            </nav>

            <!-- Lesson Plan Table -->
            <div>
                <div>
                    <div class="table-responsive">
                        @if ($lessonPlans->isEmpty())
                            <div class="alert alert-warning text-center">
                                <h5>No lesson plans available.</h5>
                                <p>Please check back later or contact your teacher for more information.</p>
                            </div>
                        @else
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Lesson Title</th>
                                        <th>Objectives</th>
                                        <th>Materials</th>
                                        <th>Teacher</th>
                                        <th>Date</th>
                                        <th>PDF</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lessonPlans as $index => $lesson)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $lesson->general_lesson }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#objectiveModal{{ $lesson->id }}">
                                                    View Objectives
                                                </button>
                                            </td>
                                            <td>{{ $lesson->materials }}</td>
                                            <td>{{ $lesson->employee->employee_name ?? 'N/A' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($lesson->date)->format('d M, Y') }}</td>
                                            <td>
                                                @if ($lesson->pdf)
                                                    <a href="{{ $lesson->pdf }}" class="btn btn-sm btn-success"
                                                        target="_blank">
                                                        Download PDF
                                                    </a>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                        </tr>

                                        <!-- Objectives Modal -->
                                        <div class="modal fade" id="objectiveModal{{ $lesson->id }}" tabindex="-1"
                                            aria-labelledby="objectiveModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="objectiveModalLabel">Lesson Objectives
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {!! $lesson->objectives !!}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
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
    <script notice="text/javascript">
        $(function() {


            $(document.body).on('click', '.control', function() {
                var id = $(this).data('id');
                $('.childdata' + id).toggle();
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
