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

            <h4 class="py-3 mb-8">
                <span class="text-muted fw-light">Dashboard /</span> Section
            </h4>

            <div class="row g-4 mb-4">
                <!-- Section List -->
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                            <h5 class="mb-0 fw-semibold text-white"><i class="bx bx-table me-2"></i> Section List</h5>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-center mb-0" id="headerTable">
                                <thead class="table-light">
                                    <tr class="text-nowrap">
                                        <th>#</th>
                                        <th>Section Name</th>
                                        <th>Class</th>
                                        <th>Version</th>
                                        <th>Shift</th>
                                        <th>Male</th>
                                        <th>Female</th>
                                        <th>Total</th>
                                        <th>Serial</th>
                                        <th>Status</th>
                                        @if (Auth::user()->is_view_user == 0)
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sections as $key => $section)
                                        <tr id="row{{ $section->id }}">
                                            <td>{{ $key + 1 }}</td>
                                            <td class="fw-semibold text-dark">{{ $section->section_name }}</td>
                                            <td>{{ $section->classvalue->class_name ?? '' }}</td>
                                            <td>{{ $section->version->version_name ?? '' }}</td>
                                            <td>
                                                <span class="badge bg-info text-dark px-3 py-2">
                                                    {{ $section->shift_id == 1 ? 'Morning' : 'Day' }}
                                                </span>
                                            </td>
                                            <td>{{ $section->male }}</td>
                                            <td>{{ $section->female }}</td>
                                            <td><strong>{{ $section->student_number }}</strong></td>
                                            <td>{{ $section->serial }}</td>
                                            <td>
                                                @if ($section->active == 1)
                                                    <span class="badge bg-success px-3 py-2">Active</span>
                                                @else
                                                    <span class="badge bg-secondary px-3 py-2">Inactive</span>
                                                @endif
                                            </td>

                                            @if (Auth::user()->is_view_user == 0)
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-light border-0" type="button"
                                                            data-bs-toggle="dropdown">
                                                            <i class="bx bx-dots-vertical-rounded fs-5"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                            <li>
                                                                <a class="dropdown-item edit" data-id="{{ $section->id }}"
                                                                    data-section_name="{{ $section->section_name }}"
                                                                    data-active="{{ $section->active }}"
                                                                    data-class_code="{{ $section->class_code }}"
                                                                    data-group_id="{{ $section->group_id }}"
                                                                    data-version_id="{{ $section->version_id }}"
                                                                    data-serial="{{ $section->serial }}"
                                                                    data-student_number="{{ $section->student_number }}"
                                                                    data-shift_id="{{ $section->shift_id }}"
                                                                    href="javascript:void(0);">
                                                                    <i class="bx bx-edit-alt me-1 text-primary"></i>Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item delete"
                                                                    data-url="{{ route('section.destroy', $section->id) }}"
                                                                    data-id="{{ $section->id }}"
                                                                    href="javascript:void(0);">
                                                                    <i class="bx bx-trash me-1 text-danger"></i>Delete
                                                                </a>
                                                            </li>
                                                        </ul>
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

                <!-- Section Entry Form -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0 fw-semibold"><i class="bx bx-plus-circle me-2"></i> Section Entry</h5>
                        </div>

                        <div class="card-body">
                            <form class="needs-validation" method="post" action="{{ route('section.store') }}" novalidate
                                id="formsubmit">
                                @csrf
                                <input type="hidden" name="id" id="id" value="0" />

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Section Name</label>
                                    <input type="text" class="form-control" name="section_name" id="section_name"
                                        placeholder="Enter section name" required>
                                    <div class="invalid-feedback">Please enter section name.</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Class</label>
                                    <select class="form-select" name="class_code" id="class_code" required>
                                        <option value="0">KG</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a class.</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Version</label>
                                    <select class="form-select" name="version_id" id="version_id" required>
                                        <option value="">Select version</option>
                                        @foreach ($versions as $version)
                                            <option value="{{ $version->id }}">{{ $version->version_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select a version.</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Shift</label>
                                    <select class="form-select" name="shift_id" id="shift_id" required>
                                        <option value="1">Morning</option>
                                        <option value="2">Day</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a shift.</div>
                                </div>

                                <div class="mb-3" style="display:none;">
                                    <label class="form-label fw-semibold">Group</label>
                                    <select class="form-select" name="group_id" id="group_id">
                                        <option value="">Select group</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Section Serial</label>
                                    <input type="text" class="form-control" name="serial" id="serial"
                                        placeholder="Enter serial" required>
                                    <div class="invalid-feedback">Please enter serial.</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Number of Students</label>
                                    <input type="number" class="form-control" name="student_number" id="student_number"
                                        placeholder="Enter student number" required>
                                    <div class="invalid-feedback">Please enter total number of students.</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Status</label>
                                    <select class="form-select" name="active" id="active" required>
                                        <option value="">Select Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    <div class="invalid-feedback">Please select status.</div>
                                </div>

                                @if (Auth::user()->is_view_user == 0)
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="bx bx-save me-2"></i>Save Section
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /Content -->

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
                var student_number = $(this).data('student_number');
                var shift_id = $(this).data('shift_id');
                var version_id = $(this).data('version_id');
                var active = $(this).data('active');
                $('#id').val(id);
                $('#section_name').val(section_name);
                $('#class_code').val(class_code);
                $('#group_id').val(group_id);
                $('#version_id').val(version_id);
                $('#serial').val(serial);
                $('#shift_id').val(shift_id);
                $('#student_number').val(student_number);
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
