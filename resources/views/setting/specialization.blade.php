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
          <span class="text-muted fw-light">Dashboard /</span> Specialization
       </h4>
       <div class="row mb-4">
          <!-- Browser Default -->
          <div class="col-md mb-4 mb-md-0">
             <div class="card">
                <h5 class="card-header">Specialization List</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                      <thead>
                        <tr class="text-nowrap">
                          <th>#</th>
                          <th>specialization Name</th>
                          <th>Discipline Name</th>

                          <th>Active</th>
                          @if (Auth::user()->is_view_user == 0)
                          <th>Action</th>
                          @endif
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                        @foreach ($specializations as $key => $specialization)
                        <tr id="row{{ $specialization->id }}">
                          <th scope="row">{{ $key + 1 }}</th>
                          <td>{{ $specialization->specialization_name }}</td>
                          <td>{{ $specialization->discipline->name ?? '' }}</td>
                          <td>
                            @if ($specialization->active == 1)
                            Active
                            @elseif($specialization->active == 0)
                            Inactive
                            @endif
                          </td>
                            @if (Auth::user()->is_view_user == 0)
                            <td>
                                <div class="dropdown">
                                     <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>
                                     <div class="dropdown-menu" style="">
                                         <a class="dropdown-item edit"
                                         data-id="{{ $specialization->id }}"
                                         data-specialization_name="{{ $specialization->specialization_name }}"
                                         data-active="{{ $specialization->active }}"
                                         data-discipline_id="{{ $specialization->discipline_id }}"
                                         href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                         <a class="dropdown-item delete" data-url="{{ route('specialization.destroy', $specialization->id) }}" data-id="{{ $specialization->id }}"  href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
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
          <div class="col-md">
    <div class="card">
        <h5 class="card-header">specialization Entry</h5>
        <div class="card-body">
            <form class="needs-validation" method="post" action="{{ route('specialization.store') }}" novalidate=""
                id="formsubmit">
                @csrf
                <input type="hidden" name="id" id="id" value="0" />


                <div class="mb-3">
                    <label class="form-label" for="bs-Active">Disciplines</label>
                    <select class="form-select" name="discipline_id" id="discipline_id" required="">
                        <option value="">Select Class</option>
                        @foreach ($disciplines as $descipline)
                            <option value="{{ $descipline->id }}">
                                {{ $descipline->name . '(' . $descipline->degree->degree_name . ')' }}</option>
                        @endforeach


                    </select>
                    <div class="valid-feedback"> Looks good! </div>
                    <div class="invalid-feedback"> Please select Disciplines </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="bs-validation-name">specialization Name</label>
                    <input type="text" class="form-control" name="specialization_name" id="specialization_name"
                        placeholder="specialization Name" required="">
                    <div class="valid-feedback"> Looks good! </div>
                    <div class="invalid-feedback"> Please enter specialization Name. </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="bs-Active">Active</label>
                    <select class="form-select" name="active" id="active" required="">
                        <option value="">Select Active</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>

                    </select>
                    <div class="valid-feedback"> Looks good! </div>
                    <div class="invalid-feedback"> Please select Active </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        @if (Auth::user()->is_view_user == 0)
                            <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                        @endif
                    </div>
                </div>
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
            });
        @endif

        $(function() {
            $(document.body).on('click', '.edit', function() {
                var id = $(this).data('id');
                var specialization_name = $(this).data('specialization_name');
                var discipline_id = $(this).data('discipline_id');
                var active = $(this).data('active');
                $('#id').val(id);
                $('#specialization_name').val(specialization_name);
                $('#discipline_id').val(discipline_id);
                $('#active').val(active);
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

        });
    </script>
@endsection
