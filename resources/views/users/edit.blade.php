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
                        <a href="{{ route('users.index') }}">Users</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"> Edit</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            @include('partials.message')
                            <form method="post" action="{{ route('users.update', $user->id) }}">
                                @method('patch')
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name" placeholder="Name"
                                            value="{{ isset($user) ? $user->name : old('name') }}" required>

                                        @if ($errors->has('name'))
                                            <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email"
                                            placeholder="Email address"
                                            value="{{ isset($user) ? $user->email : old('email') }}" required>
                                        @if ($errors->has('email'))
                                            <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control" name="phone" placeholder="phone"
                                            value="{{ isset($user) ? $user->phone : old('phone') }}" required>
                                        @if ($errors->has('phone'))
                                            <span class="text-danger text-left">{{ $errors->first('phone') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="password" class="form-label">Password</label>
                                        <input value="{{ old('password') }}" type="text" class="form-control"
                                            name="password" placeholder="password" required>
                                        @if ($errors->has('password'))
                                            <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label for="group_id" class="form-label">Role</label>
                                        <select class="form-control" name="group_id" required>
                                            <option value="">Select role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}"
                                                    {{ $hasRole->contains($role->id) ? 'selected' : '' }}>
                                                    {{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('group_id'))
                                            <span class="text-danger text-left">{{ $errors->first('group_id') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="photo" class="col-form-label">Photo </label>
                                        <input class="form-control" type="file"
                                            onchange="loadFile(event,'photo_preview')" id="photo" name="photo">
                                        <span style="color: rgb(0,149,221)">(File size max 200 KB)</span>
                                        <input class="form-control" type="hidden" id="photo"
                                            value="{{ $user->photo ?? '' }}" name="photo_old">
                                        <div class="mb-3 col-md-12">
                                            <img src="{{ $user->photo ?? '' }}" id="photo_preview"
                                                style="height: 100px; width: 100px;" />
                                        </div>
                                        @if ($errors->has('photo'))
                                            <span class="text-danger text-left">{{ $errors->first('photo') }}</span>
                                        @endif
                                    </div>
                                    <div class="d-flex justify-content-end align-items-center">
                                        <button type="submit" class="btn btn-primary me-2">Update</button>
                                        <a href="{{ route('users.index') }}" type="button"
                                            class="btn btn-secondary">Back</a>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->
        <div class="content-backdrop fade"></div>
    </div>
    <script type="text/javascript">
        var loadFile = function(event, preview) {

            var sizevalue = (event.target.files[0].size);

            if (sizevalue > 200000) {

                Swal.fire({
                    title: "warning!",
                    text: "File Size Too Large",
                    icon: "warning"
                });
                var idvalue = preview.slice(0, -8);

                $('#' + idvalue).val('');
                return false;
            } else {
                var output = document.getElementById(preview);
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function() {
                    URL.revokeObjectURL(output.src) // free memory
                }
            }

        };
    </script>
@endsection
