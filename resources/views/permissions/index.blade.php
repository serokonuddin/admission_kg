@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"> Permissions</li>
                </ol>
            </nav>
            <!-- Basic Bootstrap Table -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-5">
                        <div class="card-header">
                            @if (Auth::user()->getMenu('permissions.create', 'name'))
                                <div class="col-sm-12 col-md-12 p-10 m-r-10" style="text-align: right">
                                    @if (Auth::user()->is_view_user == 0)
                                        <a href="{{ route('permissions.create') }}"
                                            class="btn btn-primary btn-md float-right">Add Permission</a>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="card-body shadow-sm">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead class="table-dark">
                                        <tr class="text-left">
                                            <td width="1%">#</td>
                                            <th class="text-white">Name</th>
                                            <th class="text-white text-center">Guard</th>
                                            <th class="text-white text-center">Created At</th>
                                            @if (Auth::user()->is_view_user == 0)
                                                <th class="text-white
                                            <th class="text-white
                                                    text-center">Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        @if ($permissions->isNotEmpty())
                                            @foreach ($permissions as $key => $permission)
                                                <tr id="row{{ $permission->id }}">
                                                    <td>{{ ($permissions->currentPage() - 1) * $permissions->perPage() + $loop->iteration }}
                                                    <td class="text-left">{{ $permission->name }}</td>
                                                    <td class="text-center">{{ $permission->guard_name }}</td>
                                                    <td class="text-center">
                                                        {{ \Carbon\Carbon::parse($permission->created_at)->format('d M, Y') }}
                                                    </td>
                                                    @if (Auth::user()->is_view_user == 0)
                                                        <td class="text-center">
                                                            <div class="dropdown">
                                                                <button type="button"
                                                                    class="btn p-0 dropdown-toggle hide-arrow"
                                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                        class="bx bx-dots-vertical-rounded"></i></button>
                                                                <div class="dropdown-menu" style="">
                                                                    @if (Auth::user()->getMenu('permissions.edit', 'name'))
                                                                        <a class="dropdown-item edit"
                                                                            href="{{ route('permissions.edit', $permission->id) }}"><i
                                                                                class="bx bx-edit-alt me-1"></i> Edit</a>
                                                                    @endif
                                                                    @if (Auth::user()->getMenu('permissions.destroy', 'name'))
                                                                        <a class="dropdown-item delete"
                                                                            data-url="{{ route('permissions.destroy', $permission->id) }}"
                                                                            data-id="{{ $permission->id }}"
                                                                            href="javascript:void(0);"><i
                                                                                class="bx bx-trash me-1"></i> Delete</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <div class="d-flex mt-3 justify-content-end items-center">
                                    {!! $permissions->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-backdrop fade"></div>
        <!-- / Content -->
    </div>
    <script type="text/javascript">
        $(function() {
            $(document.body).on('click', '.delete', function() {
                var id = $(this).data('id');
                var url = $(this).data('url');
                $.ajax({
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    url: url,
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
