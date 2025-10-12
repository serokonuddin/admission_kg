@extends('admin.layouts.layout')
@section('content')
    <link rel="stylesheet" href="{{ asset('public/backend') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset('public/backend') }}/assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="{{ asset('public/backend') }}/assets/vendor/libs/bootstrap-select/bootstrap-select.css" />
    <link rel="stylesheet" href="{{ asset('public/backend') }}/assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="{{ asset('public/backend') }}/assets/vendor/libs/flatpickr/flatpickr.css" />
    <link rel="stylesheet" href="{{ asset('public/backend') }}/assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="{{ asset('public/backend') }}/assets/vendor/libs/tagify/tagify.css" />
    <link rel="stylesheet"
        href="{{ asset('public/backend') }}/assets/vendor/libs/@form-validation/umd/styles/index.min.css" />
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
       <h4 class="py-3 mb-4">
          <span class="text-muted fw-light">Dashboard /</span> Academic Info
       </h4>
       <div class="row mb-4">
          <!-- Browser Default -->

          <!-- /Browser Default -->
          <!-- Bootstrap Validation -->
          <div class="col-md">
            <div class="card">
                <h5 class="card-header">Academic Info</h5>
                <div class="card-body">
                    <form class="needs-validation" method="post" action="{{ route('academyinfos.store') }}" novalidate=""
                        id="formsubmit">
                        @csrf
                        <input type="hidden" name="id" id="id" value="0" />
                        <div class="mb-3">
                            <label class="form-label" for="bs-name">Academy Name</label>
                            <input type="text" class="form-control" name="academy_name" id="academy_name" value="{{ $AcademyInfo->academy_name }}" placeholder="Academy Name"
                                required="">
                            <div class="valid-feedback"> Looks good! </div>
                            <div class="invalid-feedback"> Please enter Academy Name. </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="bs-code">Short Name</label>
                            <input type="text" class="form-control" name="short_name" id="short_name" value="{{ $AcademyInfo->short_name }}" placeholder="Short Name"
                                required="">
                            <div class="valid-feedback"> Looks good! </div>
                            <div class="invalid-feedback"> Please enter Short Name. </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="bs-code">EIIN</label>
                            <input type="text" class="form-control" name="eiin" id="eiin" value="{{ $AcademyInfo->eiin }}" placeholder="Email"
                                required="">
                            <div class="valid-feedback"> Looks good! </div>
                            <div class="invalid-feedback"> Please enter EIIN Name. </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="bs-code">Established Year</label>
                            <input type="text" class="form-control" name="established_year" id="established_year" value="{{ $AcademyInfo->established_year }}" placeholder="Established Year"
                                required="">
                            <div class="valid-feedback"> Looks good! </div>
                            <div class="invalid-feedback"> Please enter Established Year. </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="bs-code">Email</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="{{ $AcademyInfo->email }}"
                                required="">
                            <div class="valid-feedback"> Looks good! </div>
                            <div class="invalid-feedback"> Please enter Email. </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="bs-code">Phone Number</label>
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone Number" value="{{ $AcademyInfo->phone }}"
                                required="">
                            <div class="valid-feedback"> Looks good! </div>
                            <div class="invalid-feedback"> Please enter Phone Number. </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="bs-code">Helpline Number</label>
                            <input type="text" class="form-control" name="helpline_number" id="helpline_number" value="{{ $AcademyInfo->helpline_number }}" placeholder="Helpline Number"
                                required="">
                            <div class="valid-feedback"> Looks good! </div>
                            <div class="invalid-feedback"> Please enter Helpline Number. </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="bs-code">Payment transfer bank account number</label>
                            <input type="text" class="form-control" name="bank_account" id="bank_account" value="{{ $AcademyInfo->bank_account }}" placeholder="Payment transfer bank account number"
                                required="">
                            <div class="valid-feedback"> Looks good! </div>
                            <div class="invalid-feedback"> Please enter Payment transfer bank account number. </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="bs-Address">Address</label>
                            <input type="text" class="form-control" name="address" id="address" value="{{ $AcademyInfo->address }}" placeholder="Address"
                                required="">
                            <div class="valid-feedback"> Looks good! </div>
                            <div class="invalid-feedback"> Please enter Address. </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="bs-Address">Logo</label>
                            <input type="file" class="form-control" name="logo" id="logo" value="{{ $AcademyInfo->logo }}" placeholder="logo"
                                required="">
                            <div class="valid-feedback"> Looks good! </div>
                            <div class="invalid-feedback"> Please upload Logo. </div>
                            <input type="hidden" class="form-control" name="logo_old" id="logo_old" value="{{ $AcademyInfo->logo }}" placeholder="logo"
                                >
                        </div>
                        <div class="col-md-6 mb-3">
                            <img src="{{ asset($AcademyInfo->logo) }}" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="bs-Address">Logo Icon</label>
                            <input type="file" class="form-control" name="icon" id="icon" value="{{ $AcademyInfo->icon }}" placeholder="Logo Icon"
                                required="">
                            <div class="valid-feedback"> Looks good! </div>
                            <div class="invalid-feedback"> Please upload Logo Icon. </div>
                            <input type="hidden" class="form-control" name="icon_old" id="icon_old" value="{{ $AcademyInfo->icon }}" placeholder="Logo Icon"
                                >
                        </div>
                        <div class="col-md-6 mb-3">
                            <img src="{{ asset($AcademyInfo->icon) }}" />
                        </div>
                        {{-- <div class="row">
                            <div class="col-12">
                                @if (Auth::user()->is_view_user == 0)
                                    <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                                @endif
                            </div>
                        </div> --}}
                    </form>
                </div>
            </div>
        </div>
    <!-- /Bootstrap Validation -->
    </div>

    </div>
    <!-- / Content -->

    <div class="content-backdrop fade"></div>
    </div>

    <script>
        @if ($errors->any())

            Swal.fire({
                title: "Error",
                text: "{{ implode(',', $errors->all(':message')) }}",
                icon: "warning"
            });
        @endif
        @if (Session::get('success'))

            Swal.fire({
                title: "Good job!",
                text: "{{ Session::get('success') }}",
                icon: "success"
            });
        @endif

        @if (Session::get('error'))

            Swal.fire({
                title: "Error",
                text: "{{ Session::get('error') }}",
                icon: "warning"
            }); @endif

        $(function() {
            $(document.body).on('click', '.edit', function() {
                var id = $(this).data('id');
                var branch_name = $(this).data('branch_name');
                var branch_code = $(this).data('branch_code');
                var active = $(this).data('active');
                var address = $(this).data('address');
                $('#id').val(id);
                $('#branch_name').val(branch_name);
                $('#branch_code').val(branch_code);
                $('#active').val(active);
                $('#address').val(address);
                $('#submit').text('Update');
            });


            $(document.body).on('click', '.delete', function() {
                var id = $(this).data('id');
                var url = $(this).data('url');
                $.ajax({
                    type: "delete",
        headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf_token" ]').attr('content') }, url: url, data: { "_token"
        : "{{ csrf_token() }}" }, success: function(response) { if (response==1) { Swal.fire({ title: "Good job!" ,
        text: "Deleted successfully" , icon: "success" }); $('#row' + id).remove(); } else { Swal.fire({ title: "Error!" ,
        text: response, icon: "warning" }); } }, error: function(data, errorThrown) { Swal.fire({ title: "Error" , text:
        errorThrown, icon: "warning" }); } }); }); $(document.body).on('click', '.edit' , function() { var
        id=$(this).data('id'); var branch_name=$(this).data('branch_name'); var branch_code=$(this).data('branch_code'); var
        active=$(this).data('active'); $('#id').val(id); $('#branch_name').val(branch_name);
        $('#branch_code').val(branch_code); $('#active').val(active); $('#submit').text('Update'); }); }); </script>
@endsection
