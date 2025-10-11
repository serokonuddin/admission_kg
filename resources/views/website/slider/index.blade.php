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
          <span class="text-muted fw-light">Dashboard /</span> Group
       </h4>
       <div class="row mb-4">
          <!-- Browser Default -->
          <div class="col-md-7 mb-4 mb-md-0">
             <div class="card">
                <h5 class="card-header">Slider List</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                      <thead>
                        <tr class="text-nowrap">
                          <th>#</th>
                          <th>Slider Title</th>
                          <th>Image</th>
                          <th>Serial</th>
                          <th>Active</th>
                          @if (Auth::user()->is_view_user == 0)
                          <th>Action</th>
                          @endif
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                        @foreach ($sliders as $key => $slider)
                        <tr id="row{{ $slider->id }}">
                          <th scope="row">{{ $key + 1 }}</th>
                          <td>{{ $slider->title }}</td>
                          <td><img src="{{ $slider->image }}" class="img-fluid" /></td>
                          <td>{{ $slider->serial }}</td>
                          <td>{{ $slider->active ? 'Active' : 'Inactive' }}</td>

                          @if (Auth::user()->is_view_user == 0)
                          <td>
                            <div class="dropdown">
                                 <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>
                                 <div class="dropdown-menu" style="">
                                     <a class="dropdown-item edit"
                                     data-id="{{ $slider->id }}"
                                     data-title="{{ $slider->title }}"
                                     data-image="{{ $slider->image }}"
                                     data-serial="{{ $slider->serial }}"
                                     data-active="{{ $slider->active }}"
                                     href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                     <a class="dropdown-item delete" data-url="{{ route('slider.destroy', $slider->id) }}" data-id="{{ $slider->id }}"  href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
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
          <div class="col-md-5">
    <div class="card">
        <h5 class="card-header">Slider Entry</h5>
        <div class="card-body">
            <form class="needs-validation" method="post" action="{{ route('slider.store') }}" novalidate=""
                id="formsubmit">
                @csrf
                <input type="hidden" name="id" id="id" value="0" />
                <div class="mb-3 col-md-12">
                    <label class="form-label" for="bs-validation-name">Slider Title</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="Slider Title"
                        required="">
                    <div class="valid-feedback"> Looks good! </div>
                    <div class="invalid-feedback"> Please enter Slider Title. </div>
                </div>

                <div class="mb-3 col-md-12 form-group gallery" id="photo_gallery">
                    <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
                    <div class="input-group">

                        <input id="thumbnail" class="form-control" type="text" name="image">
                        <span class="input-group-btn">
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                <i class="fa fa-picture-o"></i> Choose
                            </a>
                        </span>
                    </div>
                </div>
                <div class="mb-3 col-md-12">
                    <label class="form-label" for="bs-validation-name">Serial</label>
                    <input type="text" class="form-control" name="serial" id="serial" placeholder="Serial"
                        required="">
                    <div class="valid-feedback"> Looks good! </div>
                    <div class="invalid-feedback"> Please enter Serial . </div>
                </div>
                <div class="mb-3 col-md-4">
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="active" id="active1" value="1"
                            required="required" {{ isset($gallery) && $gallery->active == 1 ? 'checked="checked"' : '' }}
                            autocomplete="off">
                        <label class="btn btn-outline-primary" for="active1">Active</label>

                        <input type="radio" class="btn-check" name="active" id="active0" value="0"
                            required="required" {{ isset($gallery) && $gallery->active == 0 ? 'checked="checked"' : '' }}
                            autocomplete="off">
                        <label class="btn btn-outline-primary" for="active0">Inactive</label>


                    </div>
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
    <script src="{{ asset('public/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
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
        $('#lfm').filemanager('image');
        $(function() {
            $(document.body).on('click', '.edit', function() {
                var id = $(this).data('id');
                var title = $(this).data('title');
                var image = $(this).data('image');
                var serial = $(this).data('serial');
                var active = $(this).data('active');
                $('#id').val(id);
                $('#title').val(title);
                $('#active').val(active);
                $('#thumbnail').val(image);
                $('#serial').val(serial);
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
