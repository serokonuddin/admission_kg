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
            {{-- <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Student</h4> --}}
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>

                    <li class="breadcrumb-item">
                        <a href="{{ route('students.index') }}">Student Info</a>
                    </li>

                    <li class="breadcrumb-item active" aria-current="page"> Create</li>
                </ol>
            </nav>
            <form id="formAccountSettings" method="POST" action="{{ route('students.store') }}"
                enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">

                        <div class="card mb-4">
                            <h5 class="card-header">Student Information</h5>
                            <!-- Account -->
                            @csrf
                            <input type="hidden" name="student_code" id="student_code"
                                value="{{ old('student_code', $student->student_code ?? '') }}" />

                            <div class="card-body">

                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input class="form-control" type="text" id="first_name" name="first_name"
                                            value="{{ old('first_name', $student->first_name ?? '') }}" required
                                            placeholder="First Name" autofocus="">

                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input class="form-control" type="text" name="last_name" id="last_name"
                                            placeholder="Last Name"
                                            value="{{ old('last_name', $student->last_name ?? '') }}">
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="last_name" class="form-label">Bangla Name</label>
                                        <input class="form-control" type="text" name="bangla_name" id="bangla_name"
                                            placeholder="Bangla Name"
                                            value="{{ old('bangla_name', $student->bangla_name ?? '') }}">
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="email" class="form-label">E-mail</label>
                                        <input class="form-control" type="text" id="email" name="email" required
                                            placeholder="john.doe@example.com"
                                            value="{{ old('email', $student->email ?? '') }}"
                                            placeholder="john.doe@example.com">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="organization" class="form-label">Mobile</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text">BD (+88)</span>
                                            <input type="text" id="mobile" name="mobile" class="form-control"
                                                required placeholder="01XXXXXXXXX"
                                                value="{{ old('mobile', $student->mobile ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select id="gender" name="gender" class="form-select" required="">
                                            <option value="">Select Gender</option>
                                            <option value="1"
                                                {{ old('gender', $student->gender ?? '') == '1' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="2"
                                                {{ old('gender', $student->gender ?? '') == '2' ? 'selected' : '' }}>Female
                                            </option>
                                            <option value="3"
                                                {{ old('gender', $student->gender ?? '') == '3' ? 'selected' : '' }}>Other
                                            </option>
                                        </select>
                                    </div>

                                    <div class="mb-3 col-md-4">
                                        <label for="religion" class="form-label">Religion</label>
                                        <select id="religion" name="religion" class="form-select" required="">
                                            <option value="">Select Religion</option>
                                            <option value="1"
                                                {{ old('religion', $student->religion ?? '') == '1' ? 'selected' : '' }}>
                                                Islam</option>
                                            <option value="2"
                                                {{ old('religion', $student->religion ?? '') == '2' ? 'selected' : '' }}>
                                                Hindu</option>
                                            <option value="3"
                                                {{ old('religion', $student->religion ?? '') == '3' ? 'selected' : '' }}>
                                                Christian</option>
                                            <option value="4"
                                                {{ old('religion', $student->religion ?? '') == '4' ? 'selected' : '' }}>
                                                Buddhism</option>
                                            <option value="5"
                                                {{ old('religion', $student->religion ?? '') == '5' ? 'selected' : '' }}>
                                                Others</option>
                                        </select>
                                    </div>



                                    <div class="mb-3 col-md-4">
                                        <label for="blood" class="form-label">Blood</label>
                                        <select id="blood" name="blood" class="form-select">
                                            <option value="">Select Blood</option>
                                            <option value="O+"
                                                {{ old('blood', $student->blood ?? '') == 'O+' ? 'selected' : '' }}>O+
                                            </option>
                                            <option value="O-"
                                                {{ old('blood', $student->blood ?? '') == 'O-' ? 'selected' : '' }}>O-
                                            </option>
                                            <option value="A+"
                                                {{ old('blood', $student->blood ?? '') == 'A+' ? 'selected' : '' }}>A+
                                            </option>
                                            <option value="A-"
                                                {{ old('blood', $student->blood ?? '') == 'A-' ? 'selected' : '' }}>A-
                                            </option>
                                            <option value="B+"
                                                {{ old('blood', $student->blood ?? '') == 'B+' ? 'selected' : '' }}>B+
                                            </option>
                                            <option value="B-"
                                                {{ old('blood', $student->blood ?? '') == 'B-' ? 'selected' : '' }}>B-
                                            </option>
                                            <option value="AB+"
                                                {{ old('blood', $student->blood ?? '') == 'AB+' ? 'selected' : '' }}>AB+
                                            </option>
                                            <option value="AB-"
                                                {{ old('blood', $student->blood ?? '') == 'AB-' ? 'selected' : '' }}>AB-
                                            </option>
                                        </select>
                                    </div>


                                    {{-- <div class="mb-3 col-md-6">
                                        <label for="state" class="form-label">Birth Date</label>
                                        <input class="form-control" type="date" id="birthdate" name="birthdate"
                                            placeholder="Birth Date" value="{{ $student->birthdate ?? '' }}">
                                    </div> --}}
                                    <div class="mb-3 col-md-6">
                                        <label for="birthdate" class="form-label">Birth Date</label>
                                        <input class="form-control flatpickr" type="text" id="birthdate"
                                            name="birthdate" placeholder="DD/MM/YYYY"
                                            value="{{ old('birthdate', isset($student) ? $student->birthdate : '') }}">
                                    </div>


                                    <div class="mb-3 col-md-6">
                                        <label for="nationality" class="form-label">Nationality</label>
                                        <input type="text" class="form-control" id="nationality" name="nationality"
                                            placeholder="Nationality"
                                            value="{{ old('nationality', $student->nationality ?? 'Bangladeshi') }}">
                                    </div>
                                    <div class="mb-3 col-md-3">
                                        <label for="first_name" class="form-label">Father Name</label>
                                        <input class="form-control" type="text" id="father_name" name="father_name"
                                            placeholder="Father Name"
                                            value="{{ old('father_name', $student->father_name ?? '') }}" autofocus="">
                                    </div>
                                    <div class="mb-3 col-md-3">
                                        <label for="father_email" class="form-label">Father Email</label>
                                        <input class="form-control" type="text" id="father_email" name="father_email"
                                            placeholder="Father Email"
                                            value="{{ old('father_email', $student->father_email ?? '') }}"
                                            autofocus="">
                                    </div>
                                    <div class="mb-3 col-md-3">
                                        <label for="father_phone" class="form-label">Father Phone</label>
                                        <input class="form-control" type="text" id="father_phone" name="father_phone"
                                            placeholder="Father Phone"
                                            value="{{ old('father_phone', $student->father_phone ?? '') }}"
                                            autofocus="">
                                    </div>
                                    <div class="mb-3 col-md-3">
                                        <label for="father_profession" class="form-label">Father profession</label>
                                        <input class="form-control" type="text" id="father_profession"
                                            name="father_profession" placeholder="Father NID"
                                            value="{{ old('father_profession', $student->father_nid ?? '') }}"
                                            autofocus="">
                                    </div>
                                    <div class="mb-3 col-md-3">
                                        <label for="mother_name" class="form-label">Mother Name</label>
                                        <input class="form-control" type="text" name="mother_name" id="mother_name"
                                            placeholder="Mother Name"
                                            value="{{ old('mother_name', $student->mother_name ?? '') }}">
                                    </div>
                                    <div class="mb-3 col-md-3">
                                        <label for="mother_email" class="form-label">Mother Email</label>
                                        <input class="form-control" type="text" name="mother_email" id="mother_email"
                                            placeholder="Mother Email"
                                            value="{{ old('mother_email', $student->mother_email ?? '') }}">
                                    </div>
                                    <div class="mb-3 col-md-3">
                                        <label for="mother_phone" class="form-label">Mother Phone</label>
                                        <input class="form-control" type="text" name="mother_phone" id="mother_phone"
                                            placeholder="Mother Phone"
                                            value="{{ old('mother_phone', $student->mother_phone ?? '') }}">
                                    </div>
                                    <div class="mb-3 col-md-3">
                                        <label for="mother_profession" class="form-label">Mother profession</label>
                                        <input class="form-control" type="text" name="mother_profession"
                                            id="mother_profession" placeholder="Mother NID"
                                            value="{{ old('mother_profession', $student->mother_nid ?? '') }}">
                                    </div>

                                    <div class="mb-3 col-md-4">
                                        <label for="present_addr" class="form-label">Present Address</label>
                                        <input type="text" id="present_addr" name="present_addr" class="form-control"
                                            placeholder="Present Address"
                                            value="{{ old('present_addr', $student->present_addr ?? '') }}">

                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="present_police_station" class="form-label">Present Police
                                            Station</label>
                                        <input type="text" id="present_police_station" name="present_police_station"
                                            class="form-control" placeholder="Present Police Station"
                                            value="{{ old('present_police_station', $student->present_police_station ?? '') }}">

                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="present_district_id" class="form-label">Present District</label>
                                        <select id="present_district_id" name="present_district_id" class="form-select"
                                            required="">
                                            <option value="">Select District</option>
                                            @foreach ($districts as $district)
                                                <option value="{{ $district->id }}"
                                                    {{ old('present_district_id', isset($student) ? $student->present_district_id : '') == $district->id ? 'selected' : '' }}>
                                                    {{ $district->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="mb-3 col-md-4">
                                        <label for="permanent_addr" class="form-label">Permanent Address</label>
                                        <input type="text" id="permanent_addr" name="permanent_addr"
                                            class="form-control" placeholder="Permanent Address"
                                            value="{{ old('permanent_addr', $student->permanent_addr ?? '') }}">

                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="permanent_police_station" class="form-label">Permanent Police
                                            Station</label>
                                        <input type="text" id="permanent_police_station"
                                            name="permanent_police_station" class="form-control"
                                            placeholder="Permanent Police Station"
                                            value="{{ old('permanent_police_station', $student->permanent_police_station ?? '') }}">

                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="permanent_district_id" class="form-label">Permanent District</label>
                                        <select id="permanent_district_id" name="permanent_district_id"
                                            class="form-select" required>
                                            <option value="">Select District</option>
                                            @foreach ($districts as $district)
                                                <option value="{{ $district->id }}"
                                                    {{ old('permanent_district_id', isset($student) ? $student->permanent_district_id : '') == $district->id ? 'selected' : '' }}>
                                                    {{ $district->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>



                                    <div class="mb-3 col-md-3">
                                        <label for="local_guardian_name" class="form-label">Local Guardian Name</label>
                                        <input type="text" class="form-control" id="local_guardian_name"
                                            name="local_guardian_name" placeholder="Guardian Name"
                                            value="{{ old('local_guardian_name', $student->local_guardian_name ?? '') }}">
                                    </div>
                                    <div class="mb-3 col-md-3">
                                        <label for="guardian_name" class="form-label">Local Guardian Mobile</label>
                                        <input type="text" class="form-control" id="local_guardian_mobile"
                                            name="local_guardian_mobile" placeholder="Guardian Mobile"
                                            value="{{ old('local_guardian_mobile', $student->local_guardian_mobile ?? '') }}">
                                    </div>
                                    <div class="mb-3 col-md-3">
                                        <label for="guardian_email" class="form-label">Local Guardian Email</label>
                                        <input type="text" class="form-control" id="local_guardian_email"
                                            name="local_guardian_email" placeholder="Guardian Email"
                                            value="{{ old('local_guardian_email', $student->local_guardian_email ?? '') }}">
                                    </div>
                                    <div class="mb-3 col-md-3">
                                        <label for="local_guardian_nid" class="form-label">Local Guardian NID</label>
                                        <input type="text" id="local_guardian_nid" name="local_guardian_nid"
                                            class="form-control" placeholder="Local guardian Police Station"
                                            value="{{ old('local_guardian_nid', $student->local_guardian_nid ?? '') }}">

                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="local_guardian_address" class="form-label">Local Guardian
                                            Address</label>
                                        <input type="text" id="local_guardian_address" name="local_guardian_address"
                                            class="form-control" placeholder="Local guardian Address"
                                            value="{{ old('local_guardian_address', $student->local_guardian_addr ?? '') }}">

                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="local_guardian_police_station" class="form-label">Local Police
                                            Station</label>
                                        <input type="text" id="local_guardian_police_station"
                                            name="local_guardian_police_station" class="form-control"
                                            placeholder="Local guardian Police Station"
                                            value="{{ old('local_guardian_police_station', $student->local_guardian_police_station ?? '') }}">

                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="local_guardian_district_id" class="form-label">Local Guardian
                                            District</label>
                                        <select id="local_guardian_district_id" name="local_guardian_district_id"
                                            class="form-select" required>
                                            <option value="">Select District</option>
                                            @foreach ($districts as $district)
                                                <option value="{{ $district->id }}"
                                                    {{ old('local_guardian_district_id', isset($student) ? $student->local_guardian_district_id : '') == $district->id ? 'selected' : '' }}>
                                                    {{ $district->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    {{-- <div class="mb-3 col-md-6 form-group gallery" id="photo_gallery">
                                        <label for="inputPhoto" class="col-form-label">Photo <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">

                                            <input id="thumbnail" class="form-control" type="text" name="photo">
                                            <span class="input-group-btn">
                                                <a id="lfm" data-input="thumbnail" data-preview="holder"
                                                    class="btn btn-primary">
                                                    <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                        </div>
                                    </div> --}}
                                    <div class="mb-3 col-md-6 form-group gallery" id="photo_gallery">
                                        <label for="inputPhoto" class="col-form-label">Photo (Accepted formats: JPG, JPEG.
                                            Max file size: 200 KB.) <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <!-- File input for selecting image -->
                                            <input id="thumbnail" class="form-control" type="file" name="photo"
                                                accept="image/*" onchange="previewImage(this)">
                                        </div>
                                        <!-- Image preview section -->
                                        <div id="imagePreview" class="mt-2" style="max-width: 200px;">
                                            <img id="previewImg" src="" alt="Preview"
                                                style="width: 100%; display: none; border: 1px solid #ddd; padding: 5px; border-radius: 5px;">
                                        </div>
                                    </div>

                                    {{-- <div class="mb-3 col-md-6 form-group gallery" id="photo_gallery">
                                        <label for="inputPhoto" class="col-form-label">Birth Certificate </label>
                                        <div class="input-group">

                                            <input id="thumbnail1" class="form-control" type="text"
                                                name="birth_certificate">
                                            <span class="input-group-btn">
                                                <a id="lfm1" data-input="thumbnail1" data-preview="holder"
                                                    class="btn btn-primary">
                                                    <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                        </div>
                                    </div> --}}
                                    <div class="mb-3 col-md-6 form-group gallery" id="birth_certificate_gallery">
                                        <label for="birthCertificate" class="col-form-label">Birth Certificate (Allowed
                                            formats: JPG, JPEG, PDF. Max file size: 200 KB.)</label>
                                        <div class="input-group">
                                            <!-- File input for selecting image -->
                                            <input id="birthCertificateInput" class="form-control" type="file"
                                                name="birth_certificate" accept="image/*"
                                                onchange="previewBirthCertificate(this)">
                                        </div>
                                        <!-- Image preview section -->
                                        <div id="birthCertificatePreview" class="mt-2" style="max-width: 200px;">
                                            <img id="birthCertificateImg" src="" alt="Preview"
                                                style="width: 100%; display: none; border: 1px solid #ddd; padding: 5px; border-radius: 5px;">
                                        </div>
                                    </div>

                                </div>


                            </div>
                            <!-- /Account -->
                        </div>
                        <div class="card">
                            <h5 class="card-header">Academic Information</h5>
                            <div class="card-body">


                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label for="session_id" class="form-label">Session</label>
                                        <select id="session_id" name="session_id" class=" form-select" required="">
                                            <option value="">Select Session</option>
                                            @foreach ($sessions as $session)
                                                <option value="{{ $session->id }}"
                                                    {{ isset($activity) && $activity->session_id == $session->id ? 'selected="selected"' : '' }}>
                                                    {{ $session->session_name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="version_id" class="form-label">Version</label>
                                        <select id="version_id" name="version_id" class=" form-select" required="">
                                            <option value="">Select Version</option>
                                            @foreach ($versions as $version)
                                                <option value="{{ $version->id }}"
                                                    {{ isset($activity) && $activity->version_id == $version->id ? 'selected="selected"' : '' }}>
                                                    {{ $version->version_name }}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="mb-3 col-md-4">
                                        <label for="shift_id" class="form-label">Shift</label>
                                        <select id="shift_id" name="shift_id" class=" form-select" required="">
                                            <option value="">Select Shift</option>
                                            @foreach ($shifts as $shift)
                                                <option value="{{ $shift->id }}"
                                                    {{ isset($activity) && $activity->shift_id == $shift->id ? 'selected="selected"' : '' }}>
                                                    {{ $shift->shift_name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="class_id" class="form-label">Class</label>
                                        <select id="class_id" name="class_id" class=" form-select" required="">
                                            <option value="">Select Class</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}"
                                                    {{ isset($activity) && $activity->class_id == $class->id ? 'selected="selected"' : '' }}>
                                                    {{ $class->class_name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="category_id" class="form-label">Category</label>
                                        <select id="category_id" name="category_id" class=" form-select" required="">
                                            <option value="">Select Category</option>

                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ isset($activity) && $activity->category_id == $category->category_id ? 'selected="selected"' : '' }}>
                                                    {{ $category->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="group_id" class="form-label">Group</label>
                                        <select id="group_id" name="group_id" class=" form-select">
                                            <option value="">Select Group</option>

                                            @foreach ($groups as $group)
                                                <option value="{{ $group->id }}"
                                                    {{ isset($activity) && $activity->group_id == $group->id ? 'selected="selected"' : '' }}>
                                                    {{ $group->group_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3 col-md-4">
                                        <label for="section_id" class="form-label">Section</label>
                                        <select id="section_id" name="section_id" class=" form-select" required="">
                                            <option value="">Select Section</option>
                                            @foreach ($sections as $section)
                                                <option value="{{ $section->id }}"
                                                    {{ isset($activity) && $activity->section_id == $section->id ? 'selected="selected"' : '' }}>
                                                    {{ $section->section_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="roll" class="form-label">Roll</label>
                                        <input class="form-control" type="text" id="roll" name="roll"
                                            value="{{ $activity->roll ?? '' }}" placeholder="Roll" autofocus="">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Save</button>
                                <button type="reset" class="btn btn-outline-secondary">Cancel</button>

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
    <!-- Include Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Include Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 1500
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
                showConfirmButton: true
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validation Errors',
                html: '<ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>',
                showConfirmButton: true
            });
        @endif
    </script>

    <!-- Initialize Flatpickr -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#birthdate", {
                dateFormat: "d/m/Y", // Set the desired date format to dd/mm/yyyy
                defaultDate: "{{ old('birthdate', isset($student) ? $student->birthdate : '') }}", // Set old or existing value as default
                allowInput: true, // Allow manual input
            });
        });
    </script>

    <script>
        // Trigger the file input click
        function triggerFileInput() {
            document.getElementById('thumbnail').click();
        }

        // Preview the selected image
        function previewImage(input) {
            const previewImg = document.getElementById('previewImg');
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                previewImg.src = '';
                previewImg.style.display = 'none';
            }
        }
    </script>
    <script>
        // Preview the selected image for the Birth Certificate field
        function previewBirthCertificate(input) {
            const previewImg = document.getElementById('birthCertificateImg');
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                previewImg.src = '';
                previewImg.style.display = 'none';
            }
        }
    </script>
    <script>
        $(function() {

            $('#lfm').filemanager('image');
            $('#lfm1').filemanager('image');
            $(document.body).on('change', '#class_id', function() {
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
                        $.LoadingOverlay("hide");
                        $('#section_id').html(response);


                    },
                    error: function(data, errorThrown) {
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            title: "Error",
                            text: errorThrown,
                            icon: "warning"
                        });

                    }
                });
            });
            $(document.body).on('change', '#shift_id', function() {

                var shift_id = $('#shift_id').val();
                var version_id = $('#version_id').val();
                if (version_id && shift_id) {
                    var url = "{{ route('getClass') }}";
                    $.LoadingOverlay("show");
                    $.ajax({
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: url,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            shift_id,
                            version_id
                        },
                        success: function(response) {
                            $.LoadingOverlay("hide");
                            $('#class_id').html(response);
                            $('#section_id').html('');

                        },
                        error: function(data, errorThrown) {
                            $.LoadingOverlay("hide");
                            Swal.fire({
                                title: "Error",
                                text: errorThrown,
                                icon: "warning"
                            });

                        }
                    });
                }
            });
            $(document.body).on('change', '#version_id', function() {

                var shift_id = $('#shift_id').val();
                var version_id = $('#version_id').val();
                if (version_id && shift_id) {
                    var url = "{{ route('getClass') }}";
                    $.LoadingOverlay("show");
                    $.ajax({
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: url,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            shift_id,
                            version_id
                        },
                        success: function(response) {
                            $.LoadingOverlay("hide");
                            $('#class_id').html(response);
                            $('#section_id').html('');

                        },
                        error: function(data, errorThrown) {
                            $.LoadingOverlay("hide");
                            Swal.fire({
                                title: "Error",
                                text: errorThrown,
                                icon: "warning"
                            });

                        }
                    });
                }

            });
            $(document.body).on('change', '#section_id', function() {

                var session_id = $('#session_id').val();
                var version_id = $('#version_id').val();
                var shift_id = $('#shift_id').val();
                var class_id = $('#class_id').val();
                var section_id = $('#section_id').val();
                if (version_id && shift_id && class_id && session_id && section_id) {
                    var url = "{{ route('getLastRoll') }}";
                    $.LoadingOverlay("show");
                    $.ajax({
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: url,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            shift_id,
                            version_id,
                            class_id,
                            session_id,
                            section_id
                        },
                        success: function(response) {
                            $.LoadingOverlay("hide");
                            $('#roll').val(response);
                            // if ($('#roll').val()) {
                            //     $('#roll').prop('disabled', true);
                            // }
                        },
                        error: function(data, errorThrown) {
                            $.LoadingOverlay("hide");
                            Swal.fire({
                                title: "Error",
                                text: errorThrown,
                                icon: "warning"
                            });

                        }
                    });
                }

            });
        });
    </script>
@endsection
