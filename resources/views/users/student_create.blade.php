@extends('admin.layouts.layout')
@section('content')
    <link rel="stylesheet"
        href="{{ asset('public/backend') }}/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
    <link rel="stylesheet"
        href="{{ asset('public/backend') }}/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
    <link rel="stylesheet" href="{{ asset('public/backend') }}/assets/vendor/libs/jquery-timepicker/jquery-timepicker.css" />
    <link rel="stylesheet" href="{{ asset('public/backend') }}/assets/vendor/libs/pickr/pickr-themes.css" />
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> User</h4>
            <div class="row">
                <div class="col-md-12">

                    <div class="card mb-4">
                        <h5 class="card-header">User Information</h5>
                        <!-- Account -->


                        <div class="card-body">
                            <form id="formAccountSettings" method="POST" action="{{ route('parentUser') }}">

                                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                                <div class="row">

                                    <div class="mb-3 col-md-6">
                                        <label for="group_id" class="form-label">Version</label>
                                        <select class="form-control" name="version_id" required>
                                            <option value="">Select Version</option>
                                            <option value="1">Bangla</option>
                                            <option value="2">English</option>

                                        </select>

                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="group_id" class="form-label">Class</label>
                                        <select class="form-control" name="class_code" required>
                                            <option value="">Select Class</option>
                                            <option value="0">KG</option>
                                            <option value="1">CLass I</option>
                                            <option value="2">CLass II</option>
                                            <option value="3">CLass III</option>
                                            <option value="4">CLass IV</option>
                                            <option value="5">CLass V</option>
                                            <option value="6">CLass VI</option>
                                            <option value="7">CLass VII</option>
                                            <option value="8">CLass VIII</option>
                                            <option value="9">CLass IX</option>
                                            <option value="10">CLass X</option>

                                        </select>

                                        </select>

                                    </div>

                                </div>
                                <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                <a type="reset" href="{{ route('users.index') }}"
                                    class="btn btn-outline-secondary">Cancel</a>
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
