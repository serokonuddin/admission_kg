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
                    <li class="breadcrumb-item">
                        <a href="{{ route('roles.index') }}">Roles</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"> Edit</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <h5 class="card-header">Role Information</h5>
                        <!-- Account -->
                        <div class="card-body mb-5">
                            @include('partials.message')
                            <form method="POST" action="{{ route('roles.update', $role->id) }}">
                                @method('patch')
                                @csrf
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Name</label>
                                    <input value="{{ old('name', $role->name) }}" type="text" class="form-control"
                                        name="name" placeholder="Name">
                                </div>
                                <label for="permissions" class="form-label">Assign Permissions</label>
                                <div class="col-md-2 mt-3">
                                    <label for="">Select All</label>
                                    <input type="checkbox" name="all_permission">
                                </div>
                                <hr>
                                <div class="row">
                                    @if ($permissions->isNotEmpty())
                                        @foreach ($permissions as $permission)
                                            <div class="col-md-3 mt-3">
                                                <input type="checkbox" name="permission[{{ $permission->name }}]"
                                                    id="permission-{{ $permission->id }}" value="{{ $permission->name }}"
                                                    class='permission'
                                                    {{ $hasPermissions->contains($permission->name) ? 'checked' : '' }}>

                                                <label
                                                    for="permission-{{ $permission->id }}">{{ $permission->name }}</label>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                {{-- <table class="table table-striped">
                                    <thead>
                                        <th scope="col" width="1%"><input type="checkbox" name="all_permission"></th>
                                        <th scope="col" width="20%">Name</th>
                                        <th scope="col" width="1%">Guard</th>
                                    </thead>
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="permission[{{ $permission->name }}]"
                                                    value="{{ $permission->name }}" class='permission'
                                                    {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                                            </td>
                                            <td>{{ $permission->name }}</td>
                                            <td>{{ $permission->guard_name }}</td>
                                        </tr>
                                    @endforeach
                                </table> --}}

                                <div class="d-flex justify-content-end align-items-center">
                                    <button type="submit" class="btn btn-primary me-2">Update</button>
                                    <a href="{{ route('roles.index') }}" type="button" class="btn btn-secondary">Back</a>
                                </div>
                            </form>
                        </div>
                        <!-- /Account -->
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
    </script>
@endsection
