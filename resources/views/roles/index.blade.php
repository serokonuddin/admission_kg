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
                    <li class="breadcrumb-item active" aria-current="page"> Roles</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-5">
                        <div class="card-header d-flex mt-3 justify-content-end items-center">
                            @if (Auth::user()->is_view_user == 0)
                                <a href="{{ route('roles.create') }}" class="btn btn-primary btn-md float-right">Add
                                    role</a>
                            @endif
                        </div>
                        <div class="card-body">
                            {{-- @include('partials.message') --}}
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th width="1%" class="text-white">#</th>
                                            <th width="10%" class="text-white">Role Name</th>
                                            <th class="text-white">Role Permissions</th>
                                            <td>Guard</td>
                                            @if (Auth::user()->is_view_user == 0)
                                                <th width="3%" colspan="3" class="text-white">Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        @foreach ($roles as $key => $role)
                                            <tr id="row{{ $role->id }}">
                                                <td>{{ ($roles->currentPage() - 1) * $roles->perPage() + $loop->iteration }}
                                                <td>{{ $role->name }}</td>
                                                <td>{{ $role->permissions->pluck('name')->implode(', ') }}</td>
                                                <td>{{ $role->guard_name }}</td>

                                                @if (Auth::user()->is_view_user == 0)
                                                    <td class="text-center">
                                                        <div class="dropdown">
                                                            <button type="button"
                                                                class="btn p-0 dropdown-toggle hide-arrow"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="bx bx-dots-vertical-rounded"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                @if (Auth::user()->getMenu('roles.edit', 'name'))
                                                                    <a class="dropdown-item edit"
                                                                        href="{{ route('roles.edit', $role->id) }}"><i
                                                                            class="bx bx-edit-alt me-1"></i> Edit</a>
                                                                @endif
                                                                @if (Auth::user()->getMenu('roles.destroy', 'name'))
                                                                    <a class="dropdown-item delete"
                                                                        data-url="{{ route('roles.destroy', $role->id) }}"
                                                                        data-id="{{ $role->id }}"
                                                                        href="javascript:void(0);"><i
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
                                <div class="d-flex pt-3 justify-content-end items-center">
                                    {!! $roles->links() !!}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->
        <div class="content-backdrop fade"></div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('[name="all_permission"]').on('click', function() {

                if ($(this).is(':checked')) {
                    $.each($('.permission'), function() {
                        $(this).prop('checked', true);
                    });
                } else {
                    $.each($('.permission'), function() {
                        $(this).prop('checked', false);
                    });
                }

            });
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
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
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
                } else if (result.isDenied) {

                }
            })

        });
    </script>
@endsection
