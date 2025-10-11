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
                        <a href="{{ route('permissions.index') }}">Permissions</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"> Create</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <h5 class="card-header">Permissions Information</h5>
                        <!-- Account -->
                        <div class="card-body">
                            @include('partials.message')
                            <form method="POST" action="{{ route('permissions.store') }}">
                                @csrf
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Name</label>
                                    <input value="{{ old('name') }}" type="text" class="form-control" name="name"
                                        placeholder="Name">

                                    @if ($errors->has('name'))
                                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>

                                <div class="d-flex justify-content-start align-items-center">
                                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                                    <a href="{{ route('permissions.index') }}" type="button" class="btn btn-secondary">Back</a>
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
    <script></script>
@endsection
