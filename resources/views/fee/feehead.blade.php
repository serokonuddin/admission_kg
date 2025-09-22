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
          <span class="text-muted fw-light">Dashboard /</span> FeeHead
       </h4>
       <div class="row mb-4">
          <!-- Browser Default -->
          <div class="col-md-12 mb-4">
             <div class="card">
                <h5 class="card-header">fee Entry</h5>
                <div class="card-body">
                    @if (Auth::user()->getMenu('fees.store', 'name'))
                   <form class="needs-validation row g-6 fv-plugins-bootstrap5 fv-plugins-framework" method="post" action="{{ route('feeHead') }}"  novalidate="" id="formsubmit">
                    @csrf
                    @else
                    <form class="needs-validation row g-6 fv-plugins-bootstrap5 fv-plugins-framework" method="post" action="#"  novalidate="" id="formsubmit">
                    @endif
                    <input type="hidden" name="id" id="id" value="0" />
                      <div class="mb-3 col-md-4">
                         <label class="form-label" for="bs-name">Fee Head Name</label>
                         <input type="text" class="form-control" name="head_name"  id="head_name" placeholder="Fee Head  Name" required="">

                      </div>
                      <div class="mb-3 col-md-4">
                        <label class="form-label" for="bs-Active">Fee Head For</label>
                        <select class="form-select" name="head_type" id="head_type" required="">
                          <option value="1">Student</option>
                          <option value="2">Employee</option>

                        </select>

                      </div>
                      <div class="mb-3 col-md-4">
                        <label class="form-label" for="bs-Active">Payment Type</label>
                        <select class="form-select" name="payment_type" id="payment_type" required="">
                          <option value="1">Monthly</option>
                          <option value="2">Yearly 1 Time</option>
                          <option value="3">Yearly 2 Time</option>
                          <option value="4">Yearly 3 Time</option>
                          <option value="5">Yearly 4 Time</option>

                        </select>

                      </div>
                      <div class="mb-3 col-md-4">
                        <label class="form-label" for="bs-Active">Is Expanse</label>
                        <select class="form-select" name="is_expanse" id="is_expanse" required="">
                        <option value="2">Income</option>
                          <option value="1">Expanse</option>

                        </select>

                      </div>
                      <div class="mb-3 col-md-4">
                        <label class="form-label" for="bs-Active">Is System Generated</label>
                        <select class="form-select" name="is_system_generated" id="is_system_generated" required="">
                        <option value="0">No</option>
                        <option value="1">Yes</option>


                        </select>

                      </div>
                      <div class="mb-3 col-md-4">
                        <label class="form-label" for="bs-Active">Is Male Female</label>
                        <select class="form-select" name="is_male_female" id="is_male_female" required="">
                        <option value="0">No</option>
                        <option value="1">Yes</option>


                        </select>

                      </div>

                     <div class="mb-3 col-md-4">
                        <label class="form-label" for="bs-Active">Active</label>
                        <select class="form-select" name="status" id="status" required="">
                          <option value="1">Active</option>
                          <option value="0">Inactive</option>

                        </select>

                      </div>
                      <div class="mb-3 col-md-4">

                            @if (Auth::user()->is_view_user == 0)
                            <button type="submit" class="btn btn-primary mt-4" id="submit">Submit</button>
                            @endif

                      </div>
                   </form>
                </div>
             </div>
          </div>
          <div class="col-md-12 mb-4 mb-md-0">
             <div class="card">
                <h5 class="card-header">Fee Head List</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                      <thead>
                        <tr class="text-nowrap">
                          <th>#</th>
                          <th>Fee Head Name</th>
                          <th>Fee Head For</th>
                          <th>Payment Type</th>
                          <th>Is Auto</th>
                          <th>Is Male Female</th>
                          <th>Is Expanse?</th>
                          @if (Auth::user()->is_view_user == 0)
                          <th>Action</th>
                          @endif
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                        @foreach ($fees as $key => $fee)
                        <tr id="row{{ $fee->id }}">
                          <th scope="row">{{ $key + 1 }}</th>
                          <td>{{ $fee->head_name }}</td>
                          <td>
                           @if ($fee->head_type == 1)
                           Student
                            @elseif($fee->head_type == 2)
                            Employee
                            @endif
                          </td>
                          <td>
                            @if ($fee->payment_type == 1)
                            Monthly
                            @elseif($fee->payment_type == 2)
                            Yearly 1 Time
                            @elseif($fee->payment_type == 3)
                            Yearly 2 Time
                            @elseif($fee->payment_type == 4)
                            Yearly 3 Time
                            @elseif($fee->payment_type == 5)
                            Yearly 4 Time
                            @endif
                          </td>
                          <td>
                           @if ($fee->is_system_generated == 1)
                            Yes
                            @elseif($fee->is_system_generated == 0)
                            No
                            @endif
                          </td>
                          <td>
                           @if ($fee->is_male_female == 0)
                            No
                            @elseif($fee->is_male_female == 1)
                            Yes
                            @endif
                          </td>
                          <td>
                           @if ($fee->is_expanse == 1)
                            Expanse
                            @elseif($fee->is_expanse == 2)
                            Income
                            @endif
                          </td>

                          @if (Auth::user()->is_view_user == 0)
                          <td>
                            <div class="dropdown">
                                 <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>
                                 <div class="dropdown-menu" style="">
                                      @if (Auth::user()->getMenu('fees.edit', 'name'))
                                     <a class="dropdown-item edit"
                                     data-id="{{ $fee->id }}"
                                     data-head_name="{{ $fee->head_name }}"
                                     data-head_type="{{ $fee->head_type }}"
                                     data-is_expanse="{{ $fee->is_expanse }}"
                                     data-payment_type="{{ $fee->payment_type }}"
                                     data-is_system_generated="{{ $fee->is_system_generated }}"
                                     data-is_male_female="{{ $fee->is_male_female }}"
                                     data-status="{{ $fee->status }}"
                                     href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                     @endif
                                      @if (Auth::user()->getMenu('fees.destroy', 'name'))
                                     <a class="dropdown-item delete" data-url="{{ route('fees.destroy', $fee->id) }}" data-id="{{ $fee->id }}"  href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
                                     @endif
                                 </div>
                             </div>
                           </td>
                          @endif
                        </tr> @endforeach
                      </tbody>
                    </table>
                  </div>
             </div>
          </div>
          <!-- /Browser Default -->
          <!-- Bootstrap Validation -->

          <!-- /Bootstrap Validation -->
       </div>

    </div>
    <!-- / Content -->

    <div class="content-backdrop
        fade">
    </div>
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
            });
        @endif

        $(function() {
            $(document.body).on('click', '.edit', function() {
                var id = $(this).data('id');
                var head_name = $(this).data('head_name');
                var head_type = $(this).data('head_type');
                var status = $(this).data('status');
                var payment_type = $(this).data('payment_type');
                var is_system_generated = $(this).data('is_system_generated');
                var is_male_female = $(this).data('is_male_female');
                var is_expanse = $(this).data('is_expanse');
                $('#id').val(id);
                $('#head_name').val(head_name);
                $('#head_type').val(head_type);
                $('#status').val(status);
                $('#payment_type').val(payment_type);
                $('#is_expanse').val(is_expanse);
                $('#submit').text('Update');
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
            // $(document.body).on('click','.edit',function(){
            //     var id=$(this).data('id');
            //     var fee_name=$(this).data('fee_name');
            //     var fee_code=$(this).data('fee_code');
            //     var payment_type=$(this).data('payment_type');
            //     var active=$(this).data('active');
            //     $('#id').val(id);
            //     $('#fee_name').val(fee_name);
            //     $('#fee_code').val(fee_code);
            //     $('#payment_type').val(payment_type);
            //     $('#active').val(active);
            //     $('#submit').text('Update');
            // });
        });
    </script>
@endsection
