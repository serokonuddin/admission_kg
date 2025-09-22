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
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Pages</h4>
            <!-- Basic Bootstrap Table -->
            <div class="card">

                <div class="col-sm-12 col-md-12 p-10 m-r-10" style="text-align: right">
                    @if (Auth::user()->is_view_user == 0)
                        <a href="{{ route('pages.create') }}" class=" btn btn-round btn-info">Create Page</a>
                    @endif
                </div>

                <div class="table-responsive ">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Status</th>
                                @if (Auth::user()->is_view_user == 0)
                                    <th>Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($pages as $key => $page)
                                <tr id="row{{ $page['id'] }}">
                                    <td class="control" data-id="{{ $page['id'] }}">
                                        {{ $page['serial'] }}
                                    </td>
                                    <td>
                                        {{ $page['title'] }}
                                    </td>
                                    <td>
                                        {{ $page['slug'] }}
                                    </td>

                                    <td>{{ $page['serial'] ? 'Active' : 'Inactive' }}</td>

                                    @if (Auth::user()->is_view_user == 0)
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="bx bx-dots-vertical-rounded"></i></button>
                                                <div class="dropdown-menu" style="">
                                                    <a class="dropdown-item edit"
                                                        href="{{ route('pages.edit', $page['id']) }}"><i
                                                            class="bx bx-edit-alt me-1"></i> Edit</a>
                                                    <a class="dropdown-item delete"
                                                        data-url="{{ route('pages.destroy', $page['id']) }}"
                                                        data-id="{{ $page['id'] }}" href="javascript:void(0);"><i
                                                            class="bx bx-trash me-1"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                                @if (isset($page['tree']))
                                    @foreach ($page['tree'] as $key1 => $pagec)
                                        <tr class="childdata childdata{{ $page['id'] }}" id="row{{ $pagec['id'] }}">
                                            <td class="control" data-id="{{ $pagec['id'] }}">
                                                &nbsp;&nbsp;&nbsp;{{ $pagec['serial'] }}
                                            </td>
                                            <td>
                                                {{ $pagec['title'] }}
                                            </td>
                                            <td>
                                                {{ $pagec['slug'] }}
                                            </td>

                                            <td>{{ $pagec['serial'] ? 'Active' : 'Inactive' }}</td>

                                            @if (Auth::user()->is_view_user == 0)
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                            data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                class="bx bx-dots-vertical-rounded"></i></button>
                                                        <div class="dropdown-menu" style="">
                                                            <a class="dropdown-item edit"
                                                                href="{{ route('pages.edit', $pagec['id']) }}"><i
                                                                    class="bx bx-edit-alt me-1"></i> Edit</a>
                                                            <a class="dropdown-item delete"
                                                                data-url="{{ route('pages.destroy', $pagec['id']) }}"
                                                                data-id="{{ $pagec['id'] }}" href="javascript:void(0);"><i
                                                                    class="bx bx-trash me-1"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                        @if (isset($pagec['tree']))
                                            @foreach ($pagec['tree'] as $key1 => $pagecc)
                                                <tr class="childdata childdata{{ $pagec['id'] }}"
                                                    id="row{{ $pagecc['id'] }}">
                                                    <td class="control">
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $pagecc['serial'] }}
                                                    </td>
                                                    <td>
                                                        {{ $pagecc['title'] }}
                                                    </td>
                                                    <td>
                                                        {{ $pagecc['slug'] }}
                                                    </td>

                                                    <td>{{ $pagecc['serial'] ? 'Active' : 'Inactive' }}</td>

                                                    @if (Auth::user()->is_view_user == 0)
                                                        <td>
                                                            <div class="dropdown">
                                                                <button type="button"
                                                                    class="btn p-0 dropdown-toggle hide-arrow"
                                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                        class="bx bx-dots-vertical-rounded"></i></button>
                                                                <div class="dropdown-menu" style="">
                                                                    <a class="dropdown-item edit"
                                                                        href="{{ route('pages.edit', $pagecc['id']) }}"><i
                                                                            class="bx bx-edit-alt me-1"></i> Edit</a>
                                                                    <a class="dropdown-item delete"
                                                                        data-url="{{ route('pages.destroy', $pagecc['id']) }}"
                                                                        data-id="{{ $pagecc['id'] }}"
                                                                        href="javascript:void(0);"><i
                                                                            class="bx bx-trash me-1"></i> Delete</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
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
    <script type="text/javascript">
        $(function() {


            $(document.body).on('click', '.control', function() {
                var id = $(this).data('id');
                $('.childdata' + id).toggle();
            });
            $(document.body).on('click', '.delete', function() {
                var id = $(this).data('id');
                var url = $(this).data('url');
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
            });
        });
    </script>
@endsection
