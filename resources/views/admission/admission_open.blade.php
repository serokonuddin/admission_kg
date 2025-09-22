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

        .btn {
            font-size: 11px !important;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span>Open Admission </h4>
            <!-- Basic Bootstrap Table -->
            <div class="card">

                <div class="col-sm-12 col-md-12 p-10 m-r-10" style="text-align: right">
                    @if (Auth::user()->is_view_user == 0)
                        <a href="{{ route('admissionlist.create') }}" class=" btn btn-round btn-info">Open Admission</a>
                    @endif
                </div>

                <div class="table-responsive ">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Session</th>
                                <th>Class Name</th>
                                <th>Version Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Number Of Student</th>
                                <th>Price</th>
                                <th>Status</th>
                                @if (Auth::user()->is_view_user == 0)
                                    <th>Action</th>
                                @endif

                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($admissiondata as $admission)
                                <tr>
                                    <td>
                                        {{ $loop->index + 1 }}
                                    </td>
                                    <td>
                                        {{ $admission->session->session_name }}
                                    </td>
                                    <td>
                                        {{ $admission->class->class_name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $admission->version->version_name }}
                                    </td>
                                    <td>
                                        {{ $admission->start_date }}
                                    </td>
                                    <td>
                                        {{ $admission->end_date }}
                                    </td>
                                    <td>
                                        {{ $admission->number_of_admission }}
                                    </td>
                                    <td>
                                        {{ $admission->price }}
                                    </td>
                                    <td>
                                        @if ($admission->status == 1)
                                            Open
                                        @elseif($admission->status == 2)
                                            Close
                                        @else
                                            Inactive
                                        @endif
                                    </td>
                                    @if (Auth::user()->is_view_user == 0)
                                        <td>
                                            <div class="dropdown">
                                                <button gallery="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="bx bx-dots-vertical-rounded"></i></button>
                                                <div class="dropdown-menu" style="">
                                                    @if (Auth::user()->getMenu('admissionlist.edit', 'name'))
                                                        <a class="dropdown-item edit"
                                                            href="{{ route('admissionlist.edit', $admission->id) }}"><i
                                                                class="bx bx-edit-alt me-1"></i> Edit</a>
                                                    @endif
                                                    @if (Auth::user()->getMenu('admissionlist.destroy', 'name') && $admission->start_date > date('Y-m-d'))
                                                        <a class="dropdown-item delete"
                                                            data-url="{{ route('admissionlist.destroy', $admission->id) }}"
                                                            data-id="{{ $admission->id }}" href="javascript:void(0);"><i
                                                                class="bx bx-trash me-1"></i> Delete</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    @endif
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

        });
    </script>
@endsection
