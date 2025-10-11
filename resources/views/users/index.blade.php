@extends('admin.layouts.layout')
@section('content')
    <style>
        .control {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
            position: relative;
            cursor: pointer;
        }

        th.control:before,
        td.control:before {
            background-color: #696cff;
            border: 2px solid #fff;
            box-shadow: 0 0 3px rgba(67, 89, 113, .8);
        }

        td.control:before,
        th.control:before {
            top: 50%;
            left: 50%;
            height: 0.8em;
            width: 0.8em;
            margin-top: -0.5em;
            margin-left: -0.5em;
            display: block;
            position: absolute;
            color: black;
            border: 0.15em solid white;
            border-radius: 1em;
            box-shadow: 0 0 0.2em #444;
            box-sizing: content-box;
            text-align: center;
            text-indent: 0 !important;
            font-family: "Courier New", Courier, monospace;
            line-height: 1em;
            content: "+";
            background-color: #0d6efd;
        }

        .table-dark {
            --bs-table-bg: #1c4d7c !important;
            --bs-table-striped-bg: #1c4d7c !important;
            --bs-table-striped-color: #fff !important;
            --bs-table-active-bg: #1c4d7c !important;
            --bs-table-active-color: #fff !important;
            --bs-table-hover-bg: #1c4d7c !important;
            --bs-table-hover-color: #fff !important;
            color: #fff !important;
            border-color: #1c4d7c !important;
        }

        .table:not(.table-dark) th {
            color: black;
            font-weight: bold;
        }

        .form-label {
            width: 100% !important;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"> Users</li>
                </ol>
            </nav>
            <!-- Basic Bootstrap Table -->
            <div class="card mb-5">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        @include('partials.message')

                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Search Users</h5>
                                @if (Auth::user()->group_id == 2 && Auth::user()->getMenu('users.create', 'name') && Auth::user()->is_view_user == 0)
                                    <a href="{{ route('users.create') }}" class="btn btn-info btn-md">Create</a>
                                @endif
                            </div>
                            <div class="card-body">
                                <div class="row g-3 row-cols-md-2 row-cols-lg-3">
                                    @if (Auth::user()->group_id == 2)
                                        <div class="col">
                                            <label class="form-label">Select Type</label>
                                            <select id="is_teacher" name="is_teacher" class="form-select">
                                                <option value="">Select Type</option>
                                                <option value="1" {{ $is_teacher == 1 ? 'selected' : '' }}>Teacher
                                                </option>
                                                <option value="0" {{ $is_teacher == 0 ? 'selected' : '' }}>Student
                                                </option>
                                            </select>
                                        </div>
                                    @endif
                                    <div class="col">
                                        <label class="form-label">Select Version</label>
                                        <select id="version_id" name="version_id" class="form-select">
                                            <option value="">Select Version</option>
                                            @foreach ($versions as $version)
                                                <option value="{{ $version->id }}"
                                                    {{ $version_id == $version->id ? 'selected' : '' }}>
                                                    {{ $version->version_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Select Shift</label>
                                        <select id="shift_id" name="shift_id" class="form-select">
                                            <option value="">Select Shift</option>
                                            @foreach ($shifts as $shift)
                                                <option value="{{ $shift->id }}"
                                                    {{ $shift_id == $shift->id ? 'selected' : '' }}>
                                                    {{ $shift->shift_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Select Class</label>
                                        <select id="class_code" name="class_code" class="form-select">
                                            <option value="" {{ empty($class_code) ? 'selected' : '' }}>Select Class
                                            <option {{ isset($class_code) && $class_code == 0 ? 'selected' : '' }}
                                                value="0">KG</option>
                                            <option {{ isset($class_code) && $class_code == 1 ? 'selected' : '' }}
                                                value="1">Class I</option>
                                            <option {{ isset($class_code) && $class_code == 2 ? 'selected' : '' }}
                                                value="2">Class II</option>
                                            <option {{ isset($class_code) && $class_code == 3 ? 'selected' : '' }}
                                                value="3">Class III</option>
                                            <option {{ isset($class_code) && $class_code == 4 ? 'selected' : '' }}
                                                value="4">Class IV</option>
                                            <option {{ isset($class_code) && $class_code == 5 ? 'selected' : '' }}
                                                value="5">Class V</option>
                                            <option {{ isset($class_code) && $class_code == 6 ? 'selected' : '' }}
                                                value="6">Class VI</option>
                                            <option {{ isset($class_code) && $class_code == 7 ? 'selected' : '' }}
                                                value="7">Class VII</option>
                                            <option {{ isset($class_code) && $class_code == 8 ? 'selected' : '' }}
                                                value="8">Class VIII</option>
                                            <option {{ isset($class_code) && $class_code == 9 ? 'selected' : '' }}
                                                value="9">Class IX</option>
                                            <option {{ isset($class_code) && $class_code == 10 ? 'selected' : '' }}
                                                value="10">Class X</option>
                                            <option {{ isset($class_code) && $class_code == 11 ? 'selected' : '' }}
                                                value="11">Class XI</option>
                                            <option {{ isset($class_code) && $class_code == 12 ? 'selected' : '' }}
                                                value="12">Class XII</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Select Section</label>
                                        <select id="section_id" name="section_id" class="form-select">
                                            <option value="">Select Section</option>
                                            @foreach ($sections as $section)
                                                <option value="{{ $section->id }}"
                                                    {{ $section_id == $section->id ? 'selected' : '' }}>
                                                    {{ $section->section_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Search</label>
                                        <input value="{{ $search_input }}" type="text" id="search_input"
                                            name="search_input" class="form-control" placeholder="Seach by name, phone">
                                    </div>

                                </div>
                                <div class="mt-3 d-flex justify-content-end">
                                    @if (Auth::user()->group_id == 2)
                                        <button type="button" id="sms_send" class="btn btn-primary me-2">Sms Send</button>
                                    @endif
                                    <button type="button" id="search" class="btn btn-primary me-2">Search</button>
                                    <button type="button" id="reset" class="btn btn-danger">Reset</button>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card-body mb-2">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover rounded-md">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="1%" class="text-white">#</th>
                                        <th class="text-white">Name</th>
                                        <th class="text-white">User Name</th>
                                        @if (Auth::user()->group_id == 2)
                                            <th class="text-white">Password</th>
                                        @endif
                                        <th class="text-white">Phone</th>
                                        <th class="text-white">Section</th>
                                        <th class="text-white">Status</th>
                                        @if (Auth::user()->group_id == 2)
                                            <th class="text-white">Role</th>
                                        @endif
                                        @if (Auth::user()->is_view_user == 0)
                                            <th class="text-center text-white">Actions</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($users as $key => $user)
                                        <tr id="row{{ $user->id }}">
                                            <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                            <td>{{ $user->name }}</td>
                                            <td data-bs-toggle="#modal" data-bs-target="#fullscreenModal"
                                                class="userinfo" data-id="{{ $user->id }}">
                                                {{-- <img src="{{ asset($user->photo) ?? asset('public/student.png') }}"
                                                    alt="Avatar" class="rounded-circle avatar avatar-xs"> --}}
                                                {{ $user->group_id == 4 ? $user->ref_id ?? '' : $user->username }}
                                            </td>
                                            @if (Auth::user()->group_id == 2)
                                                <td>{{ $user->password_text ?? '' }}</td>
                                            @endif
                                            <td>{{ $user->group_id == 4 ? $user->sms_notification ?? $user->phone : $user->phone }}
                                            </td>
                                            <td>{{ $user->section_name ?? '' }}</td>
                                            <td>{{ $user->status ? 'Active' : 'Inactive' }}</td>
                                            @if (Auth::user()->group_id == 2)
                                                <td>{{ $user->role_name ?? '' }}</td>
                                            @endif

                                            @if (Auth::user()->is_view_user == 0)
                                                @if (Auth::user()->group_id == 2)
                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button"
                                                                class="btn p-0 dropdown-toggle hide-arrow"
                                                                data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                    class="bx bx-dots-vertical-rounded"></i></button>
                                                            <div class="dropdown-menu" style="">
                                                                @if (Auth::user()->getMenu('users.edit', 'name'))
                                                                    <a class="dropdown-item edit"
                                                                        href="{{ route('users.edit', $user->id) }}"><i
                                                                            class="bx bx-edit-alt me-1"></i> Edit</a>
                                                                @endif
                                                                @if (Auth::user()->getMenu('users.destroy', 'name'))
                                                                    <a class="dropdown-item delete"
                                                                        data-url="{{ route('users.destroy', $user->id) }}"
                                                                        data-id="{{ $user->id }}"
                                                                        href="javascript:void(0);"><i
                                                                            class="bx bx-trash me-1"></i> Delete</a>
                                                                @endif
                                                                @if (Auth::user()->getMenu('users.resetPassword', 'name'))
                                                                    <!-- Check if the user has permission to reset password -->
                                                                    <a class="dropdown-item resetPassword"
                                                                        href="{{ route('users.resetPassword', $user->id) }}">
                                                                        <i class="bx bx-refresh me-1"></i> Reset
                                                                        Password</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                @else
                                                    <td class="text-center">
                                                        <a href="{{ route('users.resetPassword', $user->id) }}"
                                                            class="btn btn-sm btn-warning d-flex align-items-center gap-1">
                                                            <i class="bx bx-refresh"></i> Resend Password
                                                        </a>
                                                    </td>
                                                @endif
                                            @endif
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <div class="d-flex pt-3 justify-content-end items-center">
                                {!! $users->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-backdrop fade"></div>
    </div>
    <!-- / Content -->
    <script>
        @if (Session::has('success'))
            Swal.fire({
                title: "Good job!",
                text: "{{ Session::get('success') }}",
                icon: "success",
                confirmButtonText: "OK"
            });
        @endif

        @if (Session::has('warning'))
            Swal.fire({
                title: "Warning!",
                text: "{{ Session::get('warning') }}",
                icon: "warning",
                confirmButtonText: "OK"
            });
        @endif

        @if (Session::has('error'))
            Swal.fire({
                title: "Error!",
                text: "{{ Session::get('error') }}",
                icon: "error",
                confirmButtonText: "OK"
            });
        @endif
    </script>
    <script type="text/javascript">
        $(function() {
            $(document.body).on('click', '#sms_send', function() {
                executeSms();
            });
            $(document.body).on('click', '#search', function() {
                executeSearch();
            });

            // Trigger search when Enter key is pressed
            $(document).on('keypress', '#search_input', function(e) {
                if (e.which === 13) { // 13 is the Enter key
                    executeSearch();
                }
            });

            function executeSearch() {
                var version_id = $('#version_id').val();
                var is_teacher = $('#is_teacher').val();
                var class_code = $('#class_code').val();
                var shift_id = $('#shift_id').val();
                var section_id = $('#section_id').val();
                var search_input = $('#search_input').val();

                location.href = "{{ route('users.index') }}" + '?shift_id=' + shift_id +
                    '&version_id=' + version_id + '&class_code=' + class_code +
                    '&section_id=' + section_id + '&search_input=' + search_input +
                    '&is_teacher=' + is_teacher;
            }

            function executeSms() {
                var is_teacher = $('#is_teacher').val();
                var version_id = $('#version_id').val();

                var class_code = $('#class_code').val();
                var shift_id = $('#shift_id').val();
                var section_id = $('#section_id').val();

                if (shift_id && version_id) {
                    location.href = "{{ route('sendSmsUser') }}" + '?shift_id=' + shift_id +
                        '&version_id=' + version_id + '&class_code=' + class_code +
                        '&section_id=' + section_id + '&is_teacher=' + is_teacher +
                        '&is_sms=' + 1;
                }

            }
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
            $(document.body).on('click', '#reset', function() {
                $('class_code').val('');
                $('shift_id').val('');
                $('is_teacher').val('');
                $('version_id').val('');
                $('section_id').val('');
                $('search_input').val('');
                location.href = "{{ route('users.index') }}";
            });

        });

        $(document.body).on('change', '#class_code', function() {
            var id = $(this).val();
            var shift_id = $('#shift_id').val();
            var version_id = $('#version_id').val();
            var url = "{{ route('class-wise-sections') }}";
            $.LoadingOverlay("show");
            $.ajax({
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                },
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}",
                    class_id: id,
                    shift_id,
                    version_id
                },
                success: function(response) {
                    $('#section_id').html(response);
                    $('#studentlist').html('');

                },
                error: function(data, errorThrown) {
                    Swal.fire({
                        title: "Error",
                        text: errorThrown,
                        icon: "warning"
                    });

                },
                complete: function() {
                    $.LoadingOverlay("hide");
                }
            });
        });
    </script>
@endsection
