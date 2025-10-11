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
                        <a href="{{ route('reconcilation.index') }}">Reconcilation Date</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"> Create</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <h5 class="card-header">Reconcilation Date
                        </h5>
                        <!-- Account -->
                        <div class="card-body">
                            <form id="formAccountSettings" method="POST" action="{{ route('reconcilation.store') }}">

                                <input type="hidden" name="created_by"  value="{{Auth::user()->group_id}}" />
                                <input type="hidden" name="updated_by"  value="{{Auth::user()->group_id}}" />
                                <input type="hidden" name="status"  value="1" />
                                <input type="hidden" name="id"  value="{{ isset($reconcilationDate) ? $reconcilationDate->id : '' }}" />
                                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label for="name" class="form-label">Start Date:</label>
                                        <input type="date" class="form-control"
                                            name="start_date" placeholder="Start Date" value="{{ isset($reconcilationDate) ? $reconcilationDate->start_date : '' }}"
                                            required>

                                        @if ($errors->has('start_date'))
                                            <span class="text-danger text-left">{{ $errors->first('start_date') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="name" class="form-label">End Date:</label>
                                        <input type="date" class="form-control"
                                            name="end_date" placeholder="End Date" value="{{ isset($reconcilationDate) ? $reconcilationDate->end_date : '' }}"
                                            required>

                                        @if ($errors->has('end_date'))
                                            <span class="text-danger text-left">{{ $errors->first('end_date') }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="name" class="form-label">Submit Date:</label>
                                        <input  type="date" class="form-control"
                                            name="submit_date" placeholder="Submit Date" value="{{ isset($reconcilationDate) ? $reconcilationDate->submit_date : '' }}"
                                            required>

                                        @if ($errors->has('submit_date'))
                                            <span class="text-danger text-left">{{ $errors->first('submit_date') }}</span>
                                        @endif
                                    </div>
                                    
                                </div>
                                <div class="d-flex justify-content-end align-items-center">
                                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                                    <a href="{{ route('reconcilation.index') }}" type="button" class="btn btn-secondary">Back</a>
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
    
@endsection
