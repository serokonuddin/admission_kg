@extends('admin.layouts.layout')
@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">Dashboard /</span> Section
            </h4>
            <div class="row mb-4">
                <!-- Browser Default -->
                <div class="col-md mb-4 mb-md-0">
                    <div class="card">
                        <h5 class="card-header">Section List</h5>
                        <div class="table-responsive text-nowrap">
                            <table class="table" id="headerTable">
                                <thead>
                                    <tr class="text-nowrap">
                                        <th>#</th>
                                        <th>Section Name</th>
                                        <th>Class Name</th>
                                        <th>Version</th>
                                        <th>Group</th>
                                        <th>Active</th>
                                        @if (Auth::user()->is_view_user == 0)
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($sections as $key => $section)
                                        <tr id="row{{ $section->id }}">
                                            <th scope="row">{{ $key + 1 }}</th>
                                            <td>{{ $section->section_name }}</td>
                                            <td>{{ $section->classvalue->class_name ?? '' }}</td>
                                            <td>{{ $section->version->version_name ?? '' }}</td>
                                            <td>{{ $section->group->group_name ?? '' }}</td>
                                            <td>
                                                @if ($section->active == 1)
                                                    Active
                                                @elseif($section->active == 0)
                                                    Inactive
                                                @endif
                                            </td>
                                            @if (Auth::user()->is_view_user == 0)
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                            data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                class="bx bx-dots-vertical-rounded"></i></button>
                                                        <div class="dropdown-menu" style="">
                                                            <a class="dropdown-item edit" data-id="{{ $section->id }}"
                                                                data-section_name="{{ $section->section_name }}"
                                                                data-active="{{ $section->active }}"
                                                                data-class_code="{{ $section->class_code }}"
                                                                data-group_id="{{ $section->group_id }}"
                                                                data-version_id="{{ $section->version_id }}"
                                                                data-serial="{{ $section->serial }}"
                                                                href="javascript:void(0);"><i
                                                                    class="bx bx-edit-alt me-1"></i>
                                                                Edit</a>
                                                            <a class="dropdown-item delete"
                                                                data-url="{{ route('section.destroy', $section->id) }}"
                                                                data-id="{{ $section->id }}" href="javascript:void(0);"><i
                                                                    class="bx bx-trash me-1"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <!-- /Browser Default -->
                <!-- Bootstrap Validation -->
                <div class="col-md">
                    <div class="card">
                        <h5 class="card-header">Section Entry</h5>
                        <div class="card-body">
                            <form class="needs-validation" method="post" action="{{ route('section.store') }}"
                                novalidate="" id="formsubmit">
                                @csrf
                                <input type="hidden" name="id" id="id" value="0" />
                                <div class="mb-3">
                                    <label class="form-label" for="bs-validation-name">Section Name</label>
                                    <input type="text" class="form-control" name="section_name" id="section_name"
                                        placeholder="Section Name" required="">
                                    <div class="valid-feedback"> Looks good! </div>
                                    <div class="invalid-feedback"> Please enter Section Name. </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="bs-Active">Class</label>
                                    <select class="form-select" name="class_code" id="class_code" required="">
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
                                        <option value="11">CLass XI</option>
                                        <option value="12">CLass XII</option>


                                    </select>
                                    <div class="valid-feedback"> Looks good! </div>
                                    <div class="invalid-feedback"> Please select Class </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="bs-Active">Version</label>
                                    <select class="form-select" name="version_id" id="version_id">
                                        <option value="">Select Version</option>
                                        @foreach ($versions as $version)
                                            <option value="{{ $version->id }}">{{ $version->version_name }}</option>
                                        @endforeach


                                    </select>

                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="bs-Active">Group</label>
                                    <select class="form-select" name="group_id" id="group_id">
                                        <option value="">Select Class</option>
                                        @foreach ($groups as $group)
                                            <option value="{{ $group->id }}">{{ $group->group_name }}</option>
                                        @endforeach


                                    </select>

                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="bs-validation-name">Section Serial</label>
                                    <input type="text" class="form-control" name="serial" id="serial"
                                        placeholder="Section Serial" required="">
                                    <div class="valid-feedback"> Looks good! </div>
                                    <div class="invalid-feedback"> Please enter Serial. </div>
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
        $(document).ready(function() {
            $('#headerTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
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
                var section_name = $(this).data('section_name');
                var class_code = $(this).data('class_code');
                var group_id = $(this).data('group_id');
                var serial = $(this).data('serial');
                var version_id = $(this).data('version_id');
                var active = $(this).data('active');
                $('#id').val(id);
                $('#section_name').val(section_name);
                $('#class_code').val(class_code);
                $('#group_id').val(group_id);
                $('#version_id').val(version_id);
                $('#serial').val(serial);
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
