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
                <span class="text-muted fw-light">Dashboard /</span> Section Mapping
            </h4>

            <div class="row g-4 mb-4">
                <!-- Section List -->
                <div class="col-md-7">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-white"><i class="bx bx-list-ul me-2 "></i>Section List</h5>
                        </div>

                        <div class="table-responsive text-nowrap">
                            <table class="table table-hover align-middle mb-0" id="headerTable">
                                <thead class="table-light">
                                    <tr class="text-nowrap text-center">
                                        <th>#</th>
                                        <th>Class Name</th>
                                        <th>Version</th>
                                        <th>Shift</th>
                                        <th>Student Ratio Type</th>
                                        <th>Ratio</th>
                                        @if (Auth::user()->is_view_user == 0)
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @foreach ($classSectionMapping as $key => $section)
                                        <tr id="row{{ $section->id }}">
                                            <th scope="row">{{ $key + 1 }}</th>
                                            <td>{{ $section->classvalue->class_name ?? '' }}</td>
                                            <td>{{ $section->version->version_name ?? '' }}</td>
                                            <td>
                                                <span class="badge bg-info text-dark px-3 py-2">
                                                    {{ $section->shift_id == 1 ? 'Morning' : 'Day' }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($section->is_male_female == 1)
                                                    Female Ratio
                                                @elseif($section->is_male_female == 2)
                                                    Only Male
                                                @elseif($section->is_male_female == 3)
                                                    Only Female
                                                @endif
                                            </td>
                                            <td><strong>{{ $section->ratio ?? '' }}</strong></td>
                                            @if (Auth::user()->is_view_user == 0)
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button"
                                                            class="btn btn-sm btn-light border dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bx bx-dots-vertical-rounded"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <a class="dropdown-item edit" href="javascript:void(0);"
                                                                    data-id="{{ $section->id }}"
                                                                    data-is_male_female="{{ $section->is_male_female }}"
                                                                    data-class_code="{{ $section->class_code }}"
                                                                    data-version_id="{{ $section->version_id }}"
                                                                    data-serial="{{ $section->ratio }}"
                                                                    data-shift_id="{{ $section->shift_id }}">
                                                                    <i class="bx bx-edit-alt me-1 text-primary"></i> Edit
                                                                </a>
                                                            </li>
                                                            {{-- <li>
                                                                <a class="dropdown-item delete" href="javascript:void(0);"
                                                                    data-url="{{ route('sectionmappingDestroy', $section->id) }}"
                                                                    data-id="{{ $section->id }}">
                                                                    <i class="bx bx-trash me-1 text-danger"></i> Delete
                                                                </a>
                                                            </li> --}}
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

                <!-- Section Mapping Entry -->
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="bx bx-plus-circle me-2"></i>Student Section Mapping Entry</h5>
                        </div>
                        <div class="card-body">
                            <form class="needs-validation" method="post" action="{{ route('sectionMappingStore') }}"
                                novalidate id="formsubmit">
                                @csrf
                                <input type="hidden" name="id" id="id" value="0" />

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Class</label>
                                    <select class="form-select" name="class_code" id="class_code" required>
                                        <option value="0">KG</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a Class.</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Version</label>
                                    <select class="form-select" name="version_id" id="version_id" required>
                                        <option value="">Select Version</option>
                                        @foreach ($versions as $version)
                                            <option value="{{ $version->id }}">{{ $version->version_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select a Version.</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Shift</label>
                                    <select class="form-select" name="shift_id" id="shift_id" required>
                                        @foreach ($shifts as $shift)
                                            <option value="{{ $shift->id }}">{{ $shift->shift_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select a Shift.</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold d-block">Student Type</label>
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="form-check">
                                            <input name="is_male_female" class="form-check-input" type="radio"
                                                value="1" id="ratio1" required>
                                            <label class="form-check-label" for="ratio1">Male & Female Ratio</label>
                                        </div>
                                        <div class="form-check">
                                            <input name="is_male_female" class="form-check-input" type="radio"
                                                value="2" id="ratio2">
                                            <label class="form-check-label" for="ratio2">Male Only</label>
                                        </div>
                                        <div class="form-check">
                                            <input name="is_male_female" class="form-check-input" type="radio"
                                                value="3" id="ratio3">
                                            <label class="form-check-label" for="ratio3">Female Only</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Number of Female</label>
                                    <input type="number" class="form-control" name="ratio" id="ratio"
                                        placeholder="Enter ratio" required>
                                    <div class="invalid-feedback">Please enter ratio value.</div>
                                </div>

                                @if (Auth::user()->is_view_user == 0)
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="bx bx-save me-2"></i>Submit
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
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
                var class_code = $(this).data('class_code');
                var ratio = $(this).data('ratio');
                var shift_id = $(this).data('shift_id');
                var version_id = $(this).data('version_id');
                var is_male_female = $(this).data('is_male_female');
                $('#id').val(id);
                $('#class_code').val(class_code);
                $('#version_id').val(version_id);
                $('#ratio').val(ratio);
                $('#shift_id').val(shift_id);
                $('#disabledRadio' + is_male_female).prop('checked', true);
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
