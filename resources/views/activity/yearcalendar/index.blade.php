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
    </style>
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Year Calendar</h4>
            <!-- Basic Bootstrap Table -->
            <div class="card">
                @if (Auth::user()->getMenu('year-calendar.create', 'name') && Auth::user()->is_view_user == 0)
                    <div class="col-sm-12 col-md-12 p-10 m-r-10" style="text-align: right">
                        <a href="{{ route('year-calendar.create') }}" class=" btn btn-round btn-info">Year Calendar Notice</a>
                    </div>
                @endif
                <div class="table-responsive ">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Sessions</th>
                                <th>Exam/Occasion/Festival</th>
                                <th>Exam/Occasion/Festival Bn</th>
                                <th>Date</th>
                                <th>Holi-days</th>
                                <th>Is Exam</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">

                            @foreach ($YearCalendars as $key => $YearCalendar)
                                <tr id="row{{ $YearCalendar->id }}">
                                    <td scope="row">{{ $key + 1 }}</td>
                                    <td>{{ $YearCalendar->session->session_name ?? '' }}</td>
                                    <td>{{ $YearCalendar->title ?? '' }}</td>
                                    <td>{{ $YearCalendar->title_bn ?? '' }}</td>
                                    <td>{{ date('D d F Y', strtotime($YearCalendar->start_date)) }}{{ $YearCalendar->end_date ? '-' . date('D d F Y', strtotime($YearCalendar->end_date)) : '' }}
                                    </td>
                                    <td>{{ $YearCalendar->number_of_days }}</td>
                                    <td>{{ $YearCalendar->is_notice == 1 ? 'Yes' : 'No' }}</td>


                                    <td>
                                        <div class="dropdown">
                                            <button notice="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown" aria-expanded="false"><i
                                                    class="bx bx-dots-vertical-rounded"></i></button>
                                            <div class="dropdown-menu" style="">
                                                @if (Auth::user()->getMenu('year-calendar.edit', 'name'))
                                                    <a class="dropdown-item edit"
                                                        href="{{ route('year-calendar.edit', $YearCalendar->id) }}"><i
                                                            class="bx bx-edit-alt me-1"></i> Edit</a>
                                                @endif
                                                @if (Auth::user()->getMenu('year-calendar.destroy', 'name'))
                                                    <a class="dropdown-item delete"
                                                        data-url="{{ route('year-calendar.destroy', $YearCalendar->id) }}"
                                                        data-id="{{ $YearCalendar->id }}" href="javascript:void(0);"><i
                                                            class="bx bx-trash me-1"></i> Delete</a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

            </div>
            <!-- Modal -->

        </div>
        <!-- / Content -->

        <div class="content-backdrop fade"></div>
    </div>
    <script notice="text/javascript">
        $(function() {


            $(document.body).on('click', '.control', function() {
                var id = $(this).data('id');
                $('.childdata' + id).toggle();
            });
            $(document.body).on('click', '.delete', function() {
                var id = $(this).data('id');
                var url = $(this).data('url');
                $.ajax({
                    notice: "delete",
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
            });
        });
    </script>
@endsection
