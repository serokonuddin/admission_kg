@extends('admin.layouts.layout')
@section('content')
    <style>
        .student,
        .teacher {
            display: none;
        }

        .admissionsendsms {
            float: right
        }
    </style>
    <link rel="stylesheet"
        href="{{ asset('public/backend') }}/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
    <link rel="stylesheet"
        href="{{ asset('public/backend') }}/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
    <link rel="stylesheet" href="{{ asset('public/backend') }}/assets/vendor/libs/jquery-timepicker/jquery-timepicker.css" />
    <link rel="stylesheet" href="{{ asset('public/backend') }}/assets/vendor/libs/pickr/pickr-themes.css" />
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    @if (Auth::user()->group_id == 2)
                        <li class="breadcrumb-item">
                            <a href="{{ route('sms.index') }}">SMS List</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page"> Create </li>
                </ol>
            </nav>
            <form id="sms_form" method="POST" action="{{ route('sms.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <input type="hidden" name="session_id" id="session_id" value="{{ $sessions->id }}" />
                            <div class="card-body">
                                <div class="row gy-3">
                                    <div class="col-md">
                                        <div class="form-check form-check-inline mt-1">
                                            <input class="form-check-input" type="radio" name="sms_for" id="inlineRadio1"
                                                value="1" {{ old('sms_for') == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="inlineRadio1">Student</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sms_for" id="inlineRadio2"
                                                value="2" {{ old('sms_for') == '2' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="inlineRadio2">Teacher</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sms_for" id="inlineRadio3"
                                                value="3" {{ old('sms_for') == '3' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="inlineRadio3">Non Teaching</label>
                                        </div>
                                    </div>

                                    <div class="col-md">
                                        <div class="form-check form-check-inline mt-1">
                                            <input class="form-check-input" type="radio" name="type" id="sms_for1"
                                                value="1" {{ old('type') == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="inlineCheckbox1">Primary</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="type" id="sms_for2"
                                                value="2" {{ old('type') == '2' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="inlineCheckbox2">Secondary</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="type" id="sms_for3"
                                                value="3" {{ old('type') == '3' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="inlineCheckbox3">College</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md">
                                        <div class="form-check form-check-inline mt-1">
                                            <input class="form-check-input" type="radio" name="version" id="version1"
                                                value="1" {{ old('version') == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="version1">Bangla</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="version" id="version2"
                                                value="2" {{ old('version') == '2' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="version2">English</label>
                                        </div>
                                    </div>

                                    <div class="col-md">
                                        <div class="form-check form-check-inline mt-1">
                                            <input class="form-check-input" type="radio" name="shift" id="shift1"
                                                value="1" {{ old('shift') == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="shift1">Morning</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="shift" id="shift2"
                                                value="2" {{ old('shift') == '2' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="shift2">Day</label>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="mb-3 col-md-4 teacher">
                                        <select id="designation_id" name="designation_id" class="form-select">
                                            <option value="">Select Designation</option>
                                            @foreach ($designationes as $designation)
                                                <option value="{{ $designation->id }}"
                                                    {{ old('designation_id') == $designation->id ? 'selected' : '' }}>
                                                    {{ $designation->designation_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3 col-md-4 teacher">
                                        <select id="subject_id" name="subject_id" class="form-select">
                                            <option value="">Select Subject</option>
                                            @foreach ($subjects as $subject)
                                                <option value="{{ $subject->id }}"
                                                    {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                                    {{ $subject->subject_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3 col-md-4 student teacher">
                                        <select id="class_code" name="class_code" class="form-select">
                                            <option value=""
                                                {{ is_null(old('class_code')) || old('class_code') === '' ? 'selected' : '' }}>
                                                Select Class</option>
                                            @foreach ($classes as $class_code => $class)
                                                <option value="{{ $class_code }}"
                                                    {{ old('class_code') !== null && old('class_code') == $class_code ? 'selected' : '' }}>
                                                    {{ $class }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="mb-3 col-md-4 student">
                                        <select id="category_id" name="category_id" class="form-select">
                                            <option value="">Select Category</option>
                                            @foreach ($studentcategoris as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->category_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3 col-md-4 student">
                                        <select id="group_id" name="group_id" class="form-select">
                                            <option value="">Select Group</option>
                                            @foreach ($groups as $group)
                                                <option value="{{ $group->id }}"
                                                    {{ old('group_id') == $group->id ? 'selected' : '' }}>
                                                    {{ $group->group_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3 col-md-4 student teacher">
                                        <select id="section_id" name="section_id" class="form-select">
                                            <option value="">Select Section</option>
                                        </select>
                                    </div>

                                    <div class="mb-3 col-md-4">
                                        <input class="form-control" type="text" name="name" id="name"
                                            placeholder="Search By Name, mobile, empid, email"
                                            value="{{ old('name') }}">
                                    </div>
                                </div>

                                <button type="button" class="btn btn-primary me-2 searchforsms">Search</button>
                                @if (Auth::user()->group_id == 2 && Auth::user()->is_view_user == 0)
                                    <button type="button"
                                        class="btn btn-primary me-2 text-right admissionsendsms">Admission Send
                                        SMS</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Table part --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row gy-3">
                                    <div class="col-md">
                                        <div class="table-responsive fixTableHead">
                                            <table class="table">
                                                <thead class="table-info">
                                                    <tr>
                                                        <th>SL</th>
                                                        <th>Roll/Emp ID</th>
                                                        <th>Name</th>
                                                        <th>Mobile</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="smsdata">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    @if (Auth::user()->group_id == 2)
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <input type="hidden" value="0" name="sendfor" id="sendfor" />
                                                <label class="form-label" for="basic-default-message">Mobile <span
                                                        class="text-danger">*</span></label>
                                                <textarea id="phonenumbers" name="mobile[]" class="form-control" placeholder="ex. 01913366387,0191XXXXXXX"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-check form-check-inline mt-1">
                                                <input class="form-check-input" type="radio" name="text_lang"
                                                    id="lang1" value="1">
                                                <label class="form-check-label" for="lang1">BN</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="text_lang"
                                                    id="lang2" value="2">
                                                <label class="form-check-label" for="lang2">EN</label>
                                            </div>
                                        </div>
                                    @endif
                                    {{-- <div class="mb-3 col-md-12">
                                        <label for="exampleFormControlTextarea1" class="form-label">SMS Body <span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control" id="unicode-input" onpaste="disablePaste(event)" onkeyup="countChar(this)" name="smsbody" rows="9"></textarea>
                                        <div id="charNum"></div>
                                        <input type="hidden" name="numberofchar" id="numberofchar" value="" />
                                    </div> --}}
                                    <div class="mb-3 col-md-12">
                                        <label for="exampleFormControlTextarea1" class="form-label">
                                            SMS Body <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control" id="unicode-input" onkeyup="countChar(this)" name="smsbody" rows="9">{{ old('smsbody') }}</textarea>
                                        {{-- <textarea class="form-control" id="unicode-input" onpaste="disablePaste(event)" onkeyup="countChar(this)"
                                            name="smsbody" rows="9">{{ old('smsbody') }}</textarea> --}}
                                        <div id="charNum"></div>
                                        <input type="hidden" name="numberofchar" id="numberofchar"
                                            value="{{ old('numberofchar') }}" />
                                    </div>

                                </div>
                                @if (Auth::user()->is_view_user == 0)
                                    <button type="submit" class="btn btn-primary me-2">SEND</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- / Content -->
        <div class="content-backdrop fade"></div>
    </div>
    <script src="{{ asset('public/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script>
        function disablePaste(event) {
            event.preventDefault();

            Swal.fire({
                title: "Warning",
                text: "Pasting is disabled in this field.",
                icon: "warning"
            });
        }
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
        function countChar(val) {
            var len = val.value.length;
            var lang = $("input[name='lang']:checked").val();
            if (lang == 1) {
                len = len * 2;
            }
            $('#charNum').text(len);
            $('#numberofchar').val(len);

        }
        $(function() {
            $("#unicode-input").keypress(function(event) {
                var lang = $("input[name='lang']:checked").val();
                var charCode = event.which;

                var allowchar = [44, 63, 33, 47, 45, 95, 35, 64, 34, 39, 40, 41, 43, 126, 94, 60, 62, 61,
                    42
                ];

                if (lang == 1) {
                    // Allow Bangla Unicode characters (U+0980 to U+09FF) & special characters
                    if ((charCode >= 0x0980 && charCode <= 0x09FF) || $.inArray(charCode, allowchar) !== -
                        1) {
                        return true;
                    }
                    // Block ASCII (U+0020 to U+007E)
                    if (charCode >= 32 && charCode <= 126) {
                        return false;
                    }
                    return true;
                } else {
                    // Allow only ASCII
                    if (charCode >= 32 && charCode <= 126) {
                        return true;
                    }
                    return false;
                }
            });

            $('#lfm').filemanager('image');
            $('#lfm1').filemanager('image');
            $(document.body).on('change', "input[name='lang']:checked", function() {
                $('#unicode-input').val('');
                $('#charNum').text(0);
                $('#numberofchar').val(0);
            });
            $(document.body).on('change', "input[name='sms_for']:checked", function() {
                var sms_for = $(this).val();
                if (sms_for == 1) {
                    $('.teacher').hide();
                    $('.student').show();

                } else if (sms_for == 2) {
                    $('.student').hide();
                    $('.teacher').show();

                } else {
                    $('.teacher').hide();
                    $('.student').hide();
                }
            });
            $(document.body).on('change', '#class_code', function() {
                var class_code = $(this).val();
                var version_id = $("input[name='version']:checked").val();
                var shift_id = $("input[name='shift']:checked").val();
                var type_for = $("input[name='type']:checked").val();
                var option = 1;
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
                        class_id: class_code,
                        shift_id,
                        version_id,
                        type_for,
                        option
                    },
                    success: function(response) {
                        $('#section_id').html(response);
                    },
                    error: function(data, errorThrown) {
                        handleError(data, errorThrown);
                    },
                    complete: function() {
                        $.LoadingOverlay("hide");
                    }
                });
            });
            $(document.body).on('click', '.admissionsendsms', function() {
                var class_code = $('#class_code').val();
                var url = "{{ route('getAdmissionPhoneWithClass') }}";
                $.LoadingOverlay("show");
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        class_code
                    },
                    success: function(response) {
                        $('#phonenumbers').val(response);
                        $('#sendfor').val(1);

                    },
                    error: function(data, errorThrown) {
                        $('#sendfor').val(0);
                        handleError(data, errorThrown);

                    },
                    complete: function() {
                        $.LoadingOverlay("hide");
                    }
                });
            });
            $(document.body).on('click', '.searchforsms', function() {
                var class_code = $('#class_code').val();
                var category_id = $('#category_id').val();
                var session_id = $('#session_id').val();
                var group_id = $('#group_id').val();
                var section_id = $('#section_id').val();
                var name = $('#name').val();
                var designation_id = $('#designation_id').val();
                var subject_id = $('#subject_id').val();
                var sms_for = $("input[name='sms_for']:checked").val();
                var version_id = $("input[name='version']:checked").val();
                var shift_id = $("input[name='shift']:checked").val();
                var class_for = $("input[name='type']:checked").val();
                var url = "{{ route('getStudentOrTeacherData') }}";
                $.LoadingOverlay("show");
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        sms_for,
                        subject_id,
                        designation_id,
                        name,
                        section_id,
                        class_code,
                        category_id,
                        group_id,
                        class_code,
                        shift_id,
                        version_id,
                        class_for,
                        session_id
                    },
                    success: function(response) {
                        $('#smsdata').html(response);
                    },
                    error: function(data, errorThrown) {
                        handleError(data, errorThrown);
                    },
                    complete: function() {
                        $.LoadingOverlay("hide");
                    }
                });
            });

            function handleError(data, xhr) {
                const errorMessage = data?.responseJSON?.message || 'An error occurred';
                Swal.fire({
                    title: "Error",
                    text: errorMessage,
                    icon: "warning"
                });
            }

        });
    </script>
@endsection
