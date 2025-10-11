@extends('admin.layouts.layout')
@section('content')
    <style>
        #payment-info .input-group-text {
            width: 180px;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('public/backend') }}/assets/vendor/libs/bs-stepper/bs-stepper.css" />
    <link rel="stylesheet"
        href="{{ asset('public/backend') }}/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
    <link rel="stylesheet"
        href="{{ asset('public/backend') }}/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
    <link rel="stylesheet" href="{{ asset('public/backend') }}/assets/vendor/libs/jquery-timepicker/jquery-timepicker.css" />
    <link rel="stylesheet" href="{{ asset('public/backend') }}/assets/vendor/libs/pickr/pickr-themes.css" />
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            {{-- <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Employee</h4> --}}
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>

                    <li class="breadcrumb-item">
                        <a href="{{ route('employees.index') }}">Employees Info</a>
                    </li>

                    <li class="breadcrumb-item active" aria-current="page"> Create</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-md-12">
                    <div class="bs-stepper wizard-numbered mt-2">
                        <div class="bs-stepper-header">
                            <div class="step crossed" data-target="#account-details">
                                <button type="button" class="step-trigger" aria-selected="false">
                                    <span class="bs-stepper-circle">1</span>
                                    <span class="bs-stepper-label mt-1">
                                        <span class="bs-stepper-title">Employee</span>
                                        <span class="bs-stepper-subtitle">Add Employee Details</span>
                                    </span>
                                </button>
                            </div>
                            <div class="line">
                                <i class="bx bx-chevron-right"></i>
                            </div>
                            <div class="step " data-target="#personal-info">
                                <button type="button" class="step-trigger" aria-selected="false">
                                    <span class="bs-stepper-circle">2</span>
                                    <span class="bs-stepper-label mt-1">
                                        <span class="bs-stepper-title">Academic Info</span>
                                        <span class="bs-stepper-subtitle">Add Academic info</span>

                                    </span>
                                </button>
                            </div>
                            <div class="line">
                                <i class="bx bx-chevron-right"></i>
                            </div>
                            <div class="step " data-target="#payment-info">
                                <button type="button" class="step-trigger" aria-selected="false">
                                    <span class="bs-stepper-circle">3</span>
                                    <span class="bs-stepper-label mt-1">
                                        <span class="bs-stepper-title">Salary Info</span>
                                        <span class="bs-stepper-subtitle">Add Payment Head</span>

                                    </span>
                                </button>
                            </div>


                        </div>
                        <div class="bs-stepper-content">

                            <!-- Account Details -->
                            <div id="account-details" class="content">
                                <div class="content-header mb-3">
                                    <h6 class="mb-0">Employee Personal Information</h6>
                                    <small>Enter Employee Details.</small>
                                </div>
                                <div class="row g-3">
                                    <div class="card-body">
                                        @if (Auth::user()->getMenu('teacherAttendanceStore', 'name'))
                                            <form method="POST" action="{{ route('employees.store') }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                            @else
                                                <form method="post" action="#" novalidate="">
                                        @endif

                                        <input type="hidden" name="id" value="{{ $employee->id ?? 0 }}" />
                                        @csrf
                                        <div class="row">
                                            <div class="mb-3 col-md-4">
                                                <label for="first_name" class="form-label">Employee Name</label>
                                                <input class="form-control" required="required" type="text"
                                                    id="employee_name" name="employee_name"
                                                    value="{{ $employee->employee_name ?? '' }}" placeholder="Employee Name"
                                                    autofocus="">
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label for="first_name" class="form-label">Employee Name Bangla</label>
                                                <input class="form-control" required="required" type="text"
                                                    id="employee_name_bn" name="employee_name_bn"
                                                    value="{{ $employee->employee_name_bn ?? '' }}"
                                                    placeholder="Employee Name Bn" autofocus="">
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label for="first_name" class="form-label">Employee Code</label>
                                                <input class="form-control" type="text" id="emp_id" name="emp_id"
                                                    value="{{ $employee->emp_id ?? '' }}" placeholder="Employee Code"
                                                    autofocus="">
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <label for="first_name" class="form-label">Father Name</label>
                                                <input class="form-control" type="text" id="father_name"
                                                    name="father_name" placeholder="Father Name"
                                                    value="{{ $employee->father_name ?? '' }}" autofocus="">
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="last_name" class="form-label">Mother Name</label>
                                                <input class="form-control" type="text" name="mother_name"
                                                    id="mother_name" placeholder="Mother Name"
                                                    value="{{ $employee->mother_name ?? '' }}">
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="email" class="form-label">E-mail</label>
                                                <input class="form-control" type="text" id="email" name="email"
                                                    value="{{ $employee->email ?? '' }}"
                                                    placeholder="john.doe@example.com">
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="organization" class="form-label">Mobile</label>
                                                <div class="input-group input-group-merge">
                                                    <span class="input-group-text">BD (+88)</span>
                                                    <input type="text" id="mobile" name="mobile"
                                                        value="{{ $employee->mobile ?? '' }}" class="form-control"
                                                        placeholder="01XXXXXXXXX">
                                                </div>
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label for="gender" class="form-label">Gender</label>
                                                <select id="gender" name="gender" required="required"
                                                    class="form-select" required="">
                                                    <option value="">Select Gender</option>
                                                    <option
                                                        {{ isset($employee->gender) && $employee->gender == 1 ? 'selected="selected"' : '' }}
                                                        value="1">Male</option>
                                                    <option
                                                        {{ isset($employee->gender) && $employee->gender == 2 ? 'selected="selected"' : '' }}
                                                        value="2">Female</option>
                                                    <option
                                                        {{ isset($employee->gender) && $employee->gender == 3 ? 'selected="selected"' : '' }}
                                                        value="3">Other</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label for="religion" class="form-label">Religion</label>
                                                <select id="religion" required="required" name="religion"
                                                    class="select form-select">
                                                    <option value="">Select Religion</option>
                                                    <option
                                                        {{ isset($employee->religion) && $employee->religion == 1 ? 'selected="selected"' : '' }}
                                                        value="1">Islam</option>
                                                    <option
                                                        {{ isset($employee->religion) && $employee->religion == 2 ? 'selected="selected"' : '' }}
                                                        value="2">Hindu</option>
                                                    <option
                                                        {{ isset($employee->religion) && $employee->religion == 3 ? 'selected="selected"' : '' }}
                                                        value="3">christian</option>
                                                    <option
                                                        {{ isset($employee->religion) && $employee->religion == 4 ? 'selected="selected"' : '' }}
                                                        value="4">Buddhism</option>
                                                    <option
                                                        {{ isset($employee->religion) && $employee->religion == 5 ? 'selected="selected"' : '' }}
                                                        value="5">Others</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label for="blood" class="form-label">Blood</label>
                                                <select id="blood" name="blood" id="blood"
                                                    class="select form-select">
                                                    <option value="">Select Blood</option>
                                                    <option
                                                        {{ isset($employee->blood) && $employee->blood == 'O+' ? 'selected="selected"' : '' }}
                                                        value="O+">O+</option>
                                                    <option
                                                        {{ isset($employee->blood) && $employee->blood == 'O-' ? 'selected="selected"' : '' }}
                                                        value="O-">O-</option>
                                                    <option
                                                        {{ isset($employee->blood) && $employee->blood == 'A+' ? 'selected="selected"' : '' }}
                                                        value="A+">A+</option>
                                                    <option
                                                        {{ isset($employee->blood) && $employee->blood == 'A-' ? 'selected="selected"' : '' }}
                                                        value="A-">A-</option>
                                                    <option
                                                        {{ isset($employee->blood) && $employee->blood == 'B+' ? 'selected="selected"' : '' }}
                                                        value="B+">B+</option>
                                                    <option
                                                        {{ isset($employee->blood) && $employee->blood == 'B-' ? 'selected="selected"' : '' }}
                                                        value="B-">B-</option>
                                                    <option
                                                        {{ isset($employee->blood) && $employee->blood == 'AB+' ? 'selected="selected"' : '' }}
                                                        value="AB+">AB+</option>
                                                    <option
                                                        {{ isset($employee->blood) && $employee->blood == 'AB-' ? 'selected="selected"' : '' }}
                                                        value="AB-">AB-</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="state" class="form-label">Birth Date</label>
                                                <input class="form-control" type="date" id="dob"
                                                    value="{{ $employee->dob ?? '' }}" name="dob"
                                                    placeholder="Birth Date">
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="state" class="form-label">Join Date</label>
                                                <input class="form-control" type="date" id="join_date"
                                                    value="{{ $employee->join_date ?? '' }}" name="join_date"
                                                    placeholder="Join Date">
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <label for="present_address" class="form-label">Present Address</label>
                                                <textarea type="text" class="form-control" id="present_address" name="present_address"
                                                    placeholder="Present Address">{{ $employee->present_address ?? '' }}</textarea>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="permanent_addr" class="form-label">Permanent Address</label>
                                                <textarea type="text" class="form-control" id="permanent_address" name="permanent_address"
                                                    placeholder="Present Address">{{ $employee->permanent_address ?? '' }}</textarea>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="nationality" class="form-label">Nationality</label>
                                                <input type="text" class="form-control" id="nationality"
                                                    value="{{ $employee->nationality ?? 'Bangladeshi' }}"
                                                    name="nationality" placeholder="Nationality">
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="NID" class="form-label">NID</label>
                                                <input type="text" class="form-control" id="nid" name="nid"
                                                    placeholder="NID" value="{{ $employee->nid ?? '' }}">
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="passport" class="form-label">Passport</label>
                                                <input type="text" class="form-control" id="passport"
                                                    name="passport" placeholder="Passport"
                                                    value="{{ $employee->passport ?? '' }}">
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label for="job_type" class="form-label">Job Type</label>
                                                <select id="job_type" required="required" name="job_type"
                                                    id="job_type" class="select form-select">
                                                    <option value="">Select Type</option>
                                                    <option
                                                        {{ isset($employee->job_type) && $employee->job_type == 1 ? 'selected="selected"' : '' }}
                                                        value="1">Permanent</option>
                                                    <option
                                                        {{ isset($employee->job_type) && $employee->job_type == 2 ? 'selected="selected"' : '' }}
                                                        value="2">Per Time</option>

                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label for="employee_for" class="form-label">Employee For</label>
                                                <select id="employee_for" name="employee_for" id="employee_for"
                                                    class="select form-select">
                                                    <option value="">Select Type</option>
                                                    <option
                                                        {{ isset($employee->job_type) && $employee->employee_for == 1 ? 'selected="selected"' : '' }}
                                                        value="1">Primary</option>
                                                    <option
                                                        {{ isset($employee->job_type) && $employee->employee_for == 2 ? 'selected="selected"' : '' }}
                                                        value="2">School</option>
                                                    <option
                                                        {{ isset($employee->job_type) && $employee->employee_for == 3 ? 'selected="selected"' : '' }}
                                                        value="3">College</option>

                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label for="employee_for" class="form-label">Shift</label>
                                                <select id="employee_for" name="shift_id" id="shift_id"
                                                    class="select form-select">
                                                    <option value="">Select Shift</option>
                                                    @foreach ($shifts as $shift)
                                                        <option
                                                            {{ isset($employee->shift_id) && $employee->shift_id == $shift->id ? 'selected="selected"' : '' }}
                                                            value="{{ $shift->id }}">{{ $shift->shift_name }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label for="category_id" class="form-label">Category</label>
                                                <select id="category_id" name="category_id" id="category_id"
                                                    class="select form-select">
                                                    <option value="">Select Type</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ isset($employee->category_id) && $employee->category_id == $category->id ? 'selected="selected"' : '' }}>
                                                            {{ $category->category_name }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label for="designation_id" class="form-label">Designation</label>
                                                <select id="designation_id" required="required" name="designation_id"
                                                    id="designation_id" class="select form-select">
                                                    <option value="">Select Designation</option>
                                                    @foreach ($designationes as $designation)
                                                        <option value="{{ $designation->id }}"
                                                            {{ isset($employee->designation_id) && $employee->designation_id == $designation->id ? 'selected="selected"' : '' }}>
                                                            {{ $designation->designation_name }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label for="subject_id" class="form-label">Subject</label>
                                                <select id="subject_id" name="subject_id" id="subject_id"
                                                    class="select form-select">
                                                    <option value="">Select Subject</option>
                                                    @foreach ($subjects as $subject)
                                                        <option value="{{ $subject->id }}"
                                                            {{ isset($employee->subject_id) && $employee->subject_id == $subject->id ? 'selected="selected"' : '' }}>
                                                            {{ $subject->subject_name }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label for="version_id" class="form-label">Versions</label>
                                                <select id="version_id" name="version_id" id="version_id"
                                                    class="select form-select">
                                                    <option value="">Select Version</option>
                                                    @foreach ($versions as $version)
                                                        <option value="{{ $version->id }}"
                                                            {{ isset($employee->version_id) && $employee->version_id == $version->id ? 'selected="selected"' : '' }}>
                                                            {{ $version->version_name }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-6 form-group gallery" id="photo_gallery">
                                                <label for="inputPhoto" class="col-form-label">Photo <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input id="thumbnail" class="form-control" type="file"
                                                        name="photo" onchange="previewPhoto(event)">
                                                </div>

                                                <!-- Hidden Input to Store the Old Photo Path -->
                                                <input type="hidden" name="photo_old"
                                                    value="{{ $employee->photo ?? '' }}">

                                                <!-- Preview Section -->
                                                <div class="mt-2">
                                                    <!-- Show the old photo if it exists -->
                                                    @if (!empty($employee->photo))
                                                        <img id="photoPreview" src="{{ $employee->photo }}"
                                                            alt="Old Photo" width="100" class="img-thumbnail">
                                                    @else
                                                        <img id="photoPreview" src="#" alt="Photo Preview"
                                                            width="100" class="img-thumbnail d-none">
                                                    @endif
                                                </div>
                                            </div>




                                        </div>
                                        <!-- <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                                                                                                            <button type="reset" class="btn btn-outline-secondary">Cancel</button> -->
                                        @if (Auth::user()->is_view_user == 0)
                                            <div class="col-12 d-flex justify-content-between">
                                                <button class="btn btn-label-secondary btn-prev" disabled="">
                                                    <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                                </button>
                                                <button class="btn btn-primary " type="submit">
                                                    <span
                                                        class="align-middle d-sm-inline-block d-none me-sm-1 saveemployeeInfo">Next</span>
                                                    <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                                </button>
                                            </div>
                                        @endif
                                        </form>
                                    </div>

                                </div>
                            </div>
                            <!-- Personal Info -->
                            <div id="personal-info" class="content">
                                <input type="hidden" id="employee_id" value="{{ $employee->id ?? 0 }}" />
                                <input type="hidden" id="education_id" value="0" />
                                <div class="row g-3">
                                    <div class="col-sm-4">
                                        <label class="form-label" for="country">Level [highest degree first]<span
                                                style="color:red">*</span></label>

                                        <select class="form-select" name="degree_id" id="degree_id">
                                            <option value="">Select Class</option>
                                            @foreach ($degrees as $degree)
                                                <option value="{{ $degree->id }}">{{ $degree->degree_name }}</option>
                                            @endforeach


                                        </select>

                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label" for="country">Discipline<span
                                                style="color:red">*</span></label>

                                        <select id="discipline_id" required="required" id="discipline_id"
                                            class=" form-select">
                                            <option value="">Select Discipline</option>
                                            @foreach ($disciplines as $discipline)
                                                <option value="{{ $discipline->id }}">{{ $discipline->name }}</option>
                                            @endforeach


                                        </select>

                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label" for="country">Specialization<span
                                                style="color:red">*</span></label>

                                        <select required="required" id="specialization_id" class=" form-select">
                                            <option value="">Select Specialization</option>
                                            @foreach ($specializationes as $specialization)
                                                <option value="{{ $specialization->id }}">
                                                    {{ $specialization->specialization_name }}</option>
                                            @endforeach


                                        </select>

                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label" for="degree_name">Name of degree</label>
                                        <input type="text" id="degree_name" class="form-control"
                                            placeholder="Name of degree">
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label" for="last-name">Years of schooling<span
                                                style="color:red">*</span></label>
                                        <input type="number" id="yearOfSchooling" class="form-control"
                                            placeholder="Years of schooling">
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label" for="last-name">Educational institute<span
                                                style="color:red">*</span></label>
                                        <input type="text" id="institute" class="form-control"
                                            placeholder="Educational institute">
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label" for="country">Passing Year<span
                                                style="color:red">*</span></label>
                                        <select id="passingYear" class=" form-select">
                                            <option value="">Please select</option>
                                            @for ($i = date('Y'); $i > 1940; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor

                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label" for="country">Result Type<span
                                                style="color:red">*</span></label>

                                        <select id="grade_division" class="form-select">
                                            <option value="">Please Grade</option>
                                            <option value="Grade">Grade</option>
                                            <option value="CGPA">CGPA</option>
                                            <option value="Division">Division</option>
                                            <option value="Percentage">Percentage</option>
                                        </select>


                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label" for="result">Result<span
                                                style="color:red">*</span></label>
                                        <input type="text" id="result" class="form-control" placeholder="Result">
                                    </div>
                                    <div class="mb-3 col-md-6 form-group">
                                        <label for="inputPhoto" class="col-form-label">File <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input id="file" class="form-control" type="file" />
                                        </div>
                                        <div id="file-preview" style="margin-top: 10px;"></div>
                                    </div>
                                    @if (Auth::user()->is_view_user == 0)
                                        <div class="col-sm-12">
                                            <button class="btn btn-primary btn-next" id="education_info">
                                                <span class="align-middle d-sm-inline-block d-none me-sm-1 ">Save</span>

                                            </button>
                                        </div>
                                    @endif
                                    <div class="table-responsive">
                                        <div class="col-sm-12">
                                            <table class="table">
                                                <thead>
                                                    <tr class="table-info">
                                                        <th>Level of Education</th>
                                                        <th>Discipline</th>
                                                        <th>Specialization</th>
                                                        <th>Educational Institue</th>
                                                        <th>Passing Year</th>
                                                        <th>Class/CGPA/ Grade/ Percentage</th>

                                                        <th colspan="2">Action</th>

                                                    </tr>
                                                </thead>
                                                <tbody id="educationinfo">
                                                    <tr class="table-default">
                                                        @foreach ($educations as $education)
                                                    <tr>
                                                        <td>{{ $education->degree->degree_name ?? '' }}</td>
                                                        <td>{{ $education->discipline->name ?? '' }}</td>
                                                        <td>{{ $education->specialization->specialization_name ?? '' }}
                                                        </td>
                                                        <td>{{ $education->institute ?? '' }}</td>
                                                        <td>{{ $education->passingYear ?? '' }}</td>
                                                        <td>{{ $education->grade_division }}:{{ $education->result }}</td>
                                                        <td>

                                                            <div class="dropdown">
                                                                <button type="button"
                                                                    class="btn p-0 dropdown-toggle hide-arrow"
                                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                        class="bx bx-dots-vertical-rounded"></i></button>
                                                                <div class="dropdown-menu" style="">
                                                                    <a class="dropdown-item edit"
                                                                        data-id="{{ $education->id }}"
                                                                        data-employee_id="{{ $education->employee_id }}"
                                                                        data-degree_id="{{ $education->degree_id }}"
                                                                        data-discipline_id="{{ $education->discipline_id }}"
                                                                        data-specialization_id="{{ $education->specialization_id }}"
                                                                        data-institute="{{ $education->institute }}"
                                                                        data-yearofschooling="{{ $education->yearOfSchooling }}"
                                                                        data-passingyear="{{ $education->passingYear }}"
                                                                        data-degree_name="{{ $education->degree_name }}"
                                                                        data-grade_division="{{ $education->grade_division }}"
                                                                        data-result="{{ $education->result }}"
                                                                        data-file="{{ $education->file }}"
                                                                        href="javascript:void(0);"><i
                                                                            class="bx bx-edit-alt me-1"></i> Edit</a>

                                                                </div>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                    @if (Auth::user()->is_view_user == 0)
                                        <div class="col-12 d-flex justify-content-between">
                                            <button class="btn btn-primary btn-prev">
                                                <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                                <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                            </button>
                                            <a class="btn btn-primary btn-next" href="{{ route('employees.index') }}">
                                                <span class="align-middle d-sm-inline-block d-none me-sm-1">Save</span>
                                                <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <!-- Social Links -->
                            <div id="payment-info" class="content">
                                <form method="POST" action="{{ route('employeeSalary') }}">
                                    <div class="row g-3">
                                        @csrf
                                        <input type="hidden" name="employee_id" value="{{ $employee->id ?? 0 }}" />
                                        <input type="hidden" name="version_id"
                                            value="{{ $employee->version_id ?? 0 }}" />
                                        <input type="hidden" name="session_id"
                                            value="{{ $employee->session_id ?? 0 }}" />
                                        <input type="hidden" name="salary_for"
                                            value="{{ $employee->employee_for ?? 0 }}" />
                                        <input type="hidden" name="status" value="1" />
                                        <small class="text-light fw-medium d-block">Fee Head</small>

                                        @foreach ($fees as $key => $fee)
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        <input class="form-check-input mt-0"
                                                            id="amount{{ $fee->id }}"
                                                            {{ isset($employeeHeadFee[$fee->id]) ? 'checked="checked"' : '' }}
                                                            name="head_id[]" type="checkbox" value="{{ $fee->id }}"
                                                            aria-label="Checkbox for following text input">
                                                        {{ $fee->head_name }}
                                                    </div>
                                                    <input type="number" class="form-control amount"
                                                        data-id="{{ $fee->id }}" name="amount{{ $fee->id }}"
                                                        value="{{ isset($employeeHeadFee[$fee->id]) ? $employeeHeadFee[$fee->id][0]->amount : '' }}"
                                                        placeholder="Amount" aria-label="Text input with checkbox">
                                                </div>
                                            </div>
                                        @endforeach
                                        @if (Auth::user()->is_view_user == 0)
                                            <div class="col-12 d-flex justify-content-between">
                                                <button class="btn btn-primary btn-prev">
                                                    <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                                </button>
                                                <button type="submit" class="btn btn-primary btn-next">
                                                    <span class="align-middle d-sm-inline-block d-none me-sm-1">Save</span>
                                                    <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                                    </buttona>
                                            </div>
                                        @endif
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>
        <!-- / Content -->

        <div class="content-backdrop fade"></div>
    </div>
    <script src="{{ asset('public/backend') }}/assets/vendor/libs/bs-stepper/bs-stepper.js"></script>
    <script src="{{ asset('public/backend/assets/js/form-wizard-numbered.js') }}"></script>
    <script src="{{ asset('public/backend/assets/js/form-wizard-validation.js') }}"></script>
    <script src="{{ asset('public/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
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
    <script>
        $(function() {

            $('#lfm').filemanager('photo');
            $('#file1').filemanager('photo', 'PDF');
            $(document.body).on('input', '.amount', function() {
                var value = $(this).val();
                var id = $(this).data('id');
                if (value == 0 || value == '') {
                    $('#amount' + id).removeAttr('checked');
                } else {
                    $('#amount' + id).attr('checked', 'checked');
                }
            });
            $(document.body).on('click', '.edit', function() {
                var id = $(this).data('id');
                var specialization_id = $(this).data('specialization_id');
                var file = $(this).data('file');
                var employee_id = $(this).data('employee_id');
                var degree_id = $(this).data('degree_id');
                var discipline_id = $(this).data('discipline_id');
                var passingYear = $(this).data('passingyear');
                var yearOfSchooling = $(this).data('yearofschooling');
                var institute = $(this).data('institute');
                var degree_name = $(this).data('degree_name');
                var grade_division = $(this).data('grade_division');
                var result = $(this).data('result');
                $('#file').val(file);
                $('#education_id').val(id);
                $('#specialization_id').val(specialization_id);
                $('#employee_id').val(employee_id);
                $('#degree_id').val(degree_id);
                $('#discipline_id').val(discipline_id);
                $('#passingYear').val(passingYear);
                $('#yearOfSchooling').val(yearOfSchooling);
                $('#institute').val(institute);
                $('#degree_name').val(degree_name);
                $('#grade_division').val(grade_division);
                $('#result').val(result);
                $('#submit').text('Update');
            });
            // $(document.body).on('click', '#education_info', function() {
            //     var id = $('#education_id').val();
            //     var employee_id = $('#employee_id').val();
            //     var degree_id = $('#degree_id').val();
            //     var file = $('#file').val();
            //     var discipline_id = $('#discipline_id').val();
            //     var specialization_id = $('#specialization_id').val();
            //     var yearOfSchooling = $('#yearOfSchooling').val();
            //     var degree_name = $('#degree_name').val();
            //     var passingYear = $('#passingYear').val();
            //     var institute = $('#institute').val();
            //     var grade_division = $('#grade_division').val();
            //     var result = $('#result').val();
            //     var url = "{{ route('saveEducation') }}";
            //     if (id && degree_id && discipline_id && passingYear && result && institute &&
            //         grade_division, result) {


            //         $.LoadingOverlay("show");
            //         $.ajax({
            //             type: "post",
            //             headers: {
            //                 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            //             },
            //             url: url,
            //             data: {
            //                 "_token": "{{ csrf_token() }}",
            //                 degree_id,
            //                 file,
            //                 yearOfSchooling,
            //                 institute,
            //                 id,
            //                 employee_id,
            //                 discipline_id,
            //                 specialization_id,
            //                 degree_name,
            //                 passingYear,
            //                 grade_division,
            //                 result
            //             },
            //             success: function(response) {
            //                 $.LoadingOverlay("hide");
            //                 $('#educationinfo').html(response);


            //             },
            //             error: function(data, errorThrown) {
            //                 $.LoadingOverlay("hide");
            //                 Swal.fire({
            //                     title: "Error",
            //                     text: errorThrown,
            //                     icon: "warning"
            //                 });

            //             }
            //         });
            //     } else {
            //         Swal.fire({
            //             title: "Error",
            //             text: "Please fill up * mark input field",
            //             icon: "warning"
            //         });
            //     }
            // });
            $('#education_info').on('click', function() {
                const formData = new FormData();
                const fileInput = $('#file')[0].files[0];

                if (fileInput) {
                    formData.append('file', fileInput); // Add the file as binary
                }

                // Add other form data
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('degree_id', $('#degree_id').val());
                formData.append('discipline_id', $('#discipline_id').val());
                formData.append('specialization_id', $('#specialization_id').val());
                formData.append('yearOfSchooling', $('#yearOfSchooling').val());
                formData.append('degree_name', $('#degree_name').val());
                formData.append('passingYear', $('#passingYear').val());
                formData.append('institute', $('#institute').val());
                formData.append('grade_division', $('#grade_division').val());
                formData.append('result', $('#result').val());
                formData.append('id', '0');
                formData.append('employee_id', $('#employee_id').val());

                // AJAX request
                $.ajax({
                    type: "POST",
                    url: "{{ route('saveEducation') }}",
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            title: "Success",
                            text: "File uploaded successfully!",
                            icon: "success"
                        }).then(() => {
                            location
                                .reload(); // Reload the page after the user clicks "OK"
                        });
                    },
                    error: function(data, errorThrown) {
                        handleError(data, errorThrown);
                    },
                    complete: function() {
                        $.LoadingOverlay("hide");
                    }
                });
            });

            $(document.body).on('change', '#degree_id', function() {
                var id = $(this).val();
                var degree_id = $('#degree_id').val();
                var url = "{{ route('getDiscipline') }}";
                $.LoadingOverlay("show");
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        degree_id
                    },
                    success: function(response) {
                        $.LoadingOverlay("hide");
                        $('#discipline_id').html(response);


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
            $(document.body).on('change', '#discipline_id', function() {
                var id = $(this).val();
                var discipline_id = $('#discipline_id').val();
                var url = "{{ route('getSpecialization') }}";
                $.LoadingOverlay("show");
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        discipline_id
                    },
                    success: function(response) {
                        $.LoadingOverlay("hide");
                        $('#specialization_id').html(response);


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
            $(document.body).on('change', '#class_id', function() {
                var id = $(this).val();
                var shift_id = $('#shift_id').val();
                var version_id = $('#version_id').val();
                var url = "{{ route('getSections') }}";
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
    <script>
        function previewPhoto(event) {
            const photoPreview = document.getElementById('photoPreview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    photoPreview.src = e.target.result;
                    photoPreview.classList.remove('d-none'); // Show the preview
                };
                reader.readAsDataURL(file);
            } else {
                photoPreview.src = '#';
                photoPreview.classList.add('d-none'); // Hide the preview if no file selected
            }
        }

        document.getElementById('file').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const previewContainer = document.getElementById('file-preview');
            previewContainer.innerHTML = ''; // Clear previous previews

            if (file) {
                const fileType = file.type;
                const url = URL.createObjectURL(file);

                if (fileType.includes('image')) {
                    // Preview image
                    const img = document.createElement('img');
                    img.src = url;
                    img.alt = 'Image preview';
                    img.style.maxWidth = '200px'; // Small preview size
                    img.style.border = '1px solid #ccc';
                    img.style.borderRadius = '8px';
                    img.style.boxShadow = '0 2px 4px rgba(0, 0, 0, 0.1)';
                    img.style.marginTop = '10px';
                    previewContainer.appendChild(img);
                } else if (fileType === 'application/pdf') {
                    // Preview PDF
                    const pdfEmbed = document.createElement('embed');
                    pdfEmbed.src = url;
                    pdfEmbed.type = 'application/pdf';
                    pdfEmbed.style.width = '200px'; // Small preview size
                    pdfEmbed.style.height = '250px'; // Small preview size
                    pdfEmbed.style.border = '1px solid #ccc';
                    pdfEmbed.style.borderRadius = '8px';
                    pdfEmbed.style.boxShadow = '0 2px 4px rgba(0, 0, 0, 0.1)';
                    pdfEmbed.style.marginTop = '10px';
                    previewContainer.appendChild(pdfEmbed);
                } else {
                    // Unsupported file type
                    const errorMsg = document.createElement('p');
                    errorMsg.innerText = 'File preview not available for this type.';
                    errorMsg.style.color = '#ff4d4d';
                    errorMsg.style.fontSize = '12px';
                    errorMsg.style.marginTop = '10px';
                    previewContainer.appendChild(errorMsg);
                }
            }
        });
    </script>
@endsection
