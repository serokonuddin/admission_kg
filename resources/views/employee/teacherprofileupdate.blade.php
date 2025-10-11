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
                    <li class="breadcrumb-item active" aria-current="page"> Profile</li>
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
                            {{-- <div class="line">
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
                  </div> --}}
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

                                        <form id="teacher" method="POST" action="{{ route('employees.store') }}"
                                            enctype="multipart/form-data">

                                            <input type="hidden" name="id" value="{{ $employee->id ?? '' }}" />

                                            @csrf
                                            <div class="row">
                                                <div class="mb-3 col-md-4">
                                                    <label for="first_name" class="form-label">Employee Name</label>
                                                    <input class="form-control" required="required" type="text"
                                                        id="employee_name" name="employee_name"
                                                        value="{{ $employee->employee_name ?? '' }}"
                                                        placeholder="Employee Name" autofocus="">
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
                                                    <input class="form-control" readonly="readonly" type="text"
                                                        id="emp_id" name="emp_id" value="{{ $employee->emp_id ?? '' }}"
                                                        placeholder="Employee Code" autofocus="">
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
                                                    <input class="form-control" type="text" id="email"
                                                        name="email" value="{{ $employee->email ?? '' }}"
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
                                                    @php
                                                        $text = '';
                                                        if (isset($employee->gender) && $employee->gender == 1) {
                                                            $text = 'Male';
                                                        } elseif (isset($employee->gender) && $employee->gender == 2) {
                                                            $text = 'Female';
                                                        } elseif (isset($employee->gender) && $employee->gender == 3) {
                                                            $text = 'Others';
                                                        }
                                                    @endphp
                                                    <label for="gender" class="form-label">Gender</label>
                                                    <input class="form-control" readonly="readonly" type="hidden"
                                                        id="gender" value="{{ $employee->gender ?? '' }}"
                                                        name="gender" placeholder="Gender">
                                                    <input class="form-control" readonly="readonly" type="text"
                                                        value="{{ $text }}" placeholder="Gender">

                                                </div>
                                                <div class="mb-3 col-md-4">
                                                    @php
                                                        $text1 = '';
                                                        if (isset($employee->religion) && $employee->religion == 1) {
                                                            $text1 = 'Islam';
                                                        } elseif (
                                                            isset($employee->religion) &&
                                                            $employee->religion == 2
                                                        ) {
                                                            $text1 = 'Hindu';
                                                        } elseif (
                                                            isset($employee->religion) &&
                                                            $employee->religion == 3
                                                        ) {
                                                            $text1 = 'christian';
                                                        } elseif (
                                                            isset($employee->religion) &&
                                                            $employee->religion == 4
                                                        ) {
                                                            $text1 = 'Buddhism';
                                                        } elseif (
                                                            isset($employee->religion) &&
                                                            $employee->religion == 5
                                                        ) {
                                                            $text1 = 'Others';
                                                        }
                                                    @endphp
                                                    <label for="gender" class="form-label">Religion</label>
                                                    <input class="form-control" type="hidden" id="religion"
                                                        value="{{ $employee->religion ?? '' }}" name="religion"
                                                        placeholder="religion">
                                                    <input class="form-control" type="text"
                                                        value="{{ $text1 }}" placeholder="Gender">

                                                </div>
                                                <div class="mb-3 col-md-4">

                                                    <label for="gender" class="form-label">Blood</label>
                                                    <input class="form-control" type="hidden" id="blood"
                                                        value="{{ $employee->blood ?? '' }}" name="blood"
                                                        placeholder="blood">
                                                    <input class="form-control" type="text"
                                                        value="{{ $employee->blood ?? '' }}" placeholder="Gender">

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
                                                    <label for="present_address" class="form-label">Present
                                                        Address</label>
                                                    <textarea type="text" class="form-control" id="present_address" name="present_address"
                                                        placeholder="Present Address">{{ $employee->present_address ?? '' }}</textarea>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="permanent_addr" class="form-label">Permanent
                                                        Address</label>
                                                    <textarea type="text" class="form-control" id="permanent_address" name="permanent_address"
                                                        placeholder="Present Address">{{ $employee->permanent_address ?? '' }}</textarea>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="nationality" class="form-label">Nationality</label>
                                                    <input type="text" class="form-control" id="nationality"
                                                        value="{{ $employee->nationality ?? '' }}" name="nationality"
                                                        placeholder="Nationality">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="NID" class="form-label">NID</label>
                                                    <input type="text" class="form-control" id="nid"
                                                        name="nid" placeholder="NID"
                                                        value="{{ $employee->nid ?? '' }}">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="passport" class="form-label">Passport</label>
                                                    <input type="text" class="form-control" id="passport"
                                                        name="passport" placeholder="Passport"
                                                        value="{{ $employee->passport ?? '' }}">
                                                </div>
                                                <div class="mb-3 col-md-4">
                                                    @php
                                                        $text2 = '';
                                                        if (isset($employee->job_type) && $employee->job_type == 1) {
                                                            $text2 = 'Permanent';
                                                        } elseif (
                                                            isset($employee->job_type) &&
                                                            $employee->gender == 2
                                                        ) {
                                                            $text2 = 'Per Time';
                                                        }
                                                    @endphp
                                                    <label for="gender" class="form-label">Job Type</label>
                                                    <input class="form-control" readonly="readonly" type="hidden"
                                                        id="job_type" value="{{ $employee->job_type ?? '' }}"
                                                        name="job_type" placeholder="job type">
                                                    <input class="form-control" readonly="readonly" type="text"
                                                        value="{{ $text2 }}" placeholder="job type">

                                                </div>


                                                <div class="mb-3 col-md-4">
                                                    @php
                                                        $text4 = '';
                                                        if (
                                                            isset($employee->employee_for) &&
                                                            $employee->employee_for == 1
                                                        ) {
                                                            $text4 = 'Primary';
                                                        } elseif (
                                                            isset($employee->employee_for) &&
                                                            $employee->employee_for == 2
                                                        ) {
                                                            $text4 = 'School';
                                                        } elseif (
                                                            isset($employee->employee_for) &&
                                                            $employee->employee_for == 3
                                                        ) {
                                                            $text4 = 'College';
                                                        }
                                                    @endphp

                                                    <label for="gender" class="form-label">Employee For</label>
                                                    <input class="form-control" readonly="readonly" type="hidden"
                                                        id="employee_for" value="{{ $employee->employee_for ?? '' }}"
                                                        name="employee_for" placeholder="employee for">
                                                    <input class="form-control" readonly="readonly" type="text"
                                                        value="{{ $text4 }}" placeholder="Employee For">

                                                </div>


                                                <div class="mb-3 col-md-4">

                                                    <label for="gender" class="form-label">Shift</label>
                                                    @foreach ($shifts as $shift)
                                                        @if (isset($employee->shift_id) && $employee->shift_id == $shift->id)
                                                            <input class="form-control" readonly="readonly"
                                                                type="hidden" id="shift_id"
                                                                value="{{ $employee->shift_id ?? '' }}" name="shift_id"
                                                                placeholder="employee for">
                                                            <input class="form-control" readonly="readonly"
                                                                type="text" value="{{ $shift->shift_name }}"
                                                                placeholder="shift">
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <div class="mb-3 col-md-4">

                                                    <label for="gender" class="form-label">Category</label>
                                                    @foreach ($categories as $category)
                                                        @if (isset($employee->category_id) && $employee->category_id == $category->id)
                                                            <input class="form-control" readonly="readonly"
                                                                type="hidden" id="category_id"
                                                                value="{{ $employee->category_id ?? '' }}"
                                                                name="category_id" placeholder="employee for">
                                                            <input class="form-control" readonly="readonly"
                                                                type="text" value="{{ $category->category_name }}"
                                                                placeholder="category">
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <div class="mb-3 col-md-4">
                                                    <label for="designation_id" class="form-label">Designation</label>

                                                    <select id="designation_id" required="required" name="designation_id"
                                                        class="select2 form-select">
                                                        <option value="">Select Designation</option>

                                                        @foreach ($designationes as $designation)
                                                            <option value="{{ $designation->id }}"
                                                                {{ isset($employee->designation_id) && $employee->designation_id == $designation->id ? 'selected="selected"' : '' }}>
                                                                {{ $designation->designation_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>


                                                <div class="mb-3 col-md-4">

                                                    <label for="gender" class="form-label">Subject</label>
                                                    @foreach ($subjects as $subject)
                                                        @if (isset($employee->subject_id) && $employee->subject_id == $subject->id)
                                                            <input class="form-control" readonly="readonly"
                                                                type="hidden" id="subject_id"
                                                                value="{{ $employee->subject_id ?? '' }}"
                                                                name="subject_id" placeholder="employee for">
                                                            <input class="form-control" readonly="readonly"
                                                                type="text" value="{{ $subject->subject_name }}"
                                                                placeholder="subject">
                                                        @endif
                                                    @endforeach
                                                </div>


                                                <div class="mb-3 col-md-4">

                                                    <label for="gender" class="form-label">Versions</label>
                                                    @foreach ($versions as $version)
                                                        @if (isset($employee->version_id) && $employee->version_id == $version->id)
                                                            <input class="form-control" readonly="readonly"
                                                                type="hidden" id="version_id"
                                                                value="{{ $employee->version_id ?? '' }}"
                                                                name="version_id" placeholder="employee for">
                                                            <input class="form-control" readonly="readonly"
                                                                type="text" value="{{ $version->version_name }}"
                                                                placeholder="version">
                                                        @endif
                                                    @endforeach
                                                </div>

                                                <div class="mb-3 col-md-6 form-group gallery" id="photo_gallery">
                                                    <label for="photo" class="form-label">Upload Photo (jpg,jpeg,png
                                                        format)<span class="text-danger">*</span></label>
                                                    <input class="form-control" type="file" id="photo"
                                                        onchange="loadFile(event,'photo_preview')" name="photo"
                                                        {{ !empty($employee->photo) ? '' : 'required=""' }}>
                                                    <span style="color: rgb(0,149,221)">(File size max 200 KB)</span>
                                                    <input class="form-control" type="hidden" id="photo_old"
                                                        value="{{ $employee->photo ?? '' }}" name="photo_old">

                                                    <div class="mb-3 col-md-12">
                                                        <img src="{{ $employee->photo ?? '' }}" id="photo_preview"
                                                            style="height: 100px; width: auto" />
                                                    </div>
                                                    <div class="invalid-feedback">Please choose your Photo. </div>
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex justify-content-between">
                                                <button class="btn btn-label-secondary btn-prev" disabled="">
                                                    <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                                </button>
                                                <button class="btn btn-primary btn-next" type="submit">
                                                    <span
                                                        class="align-middle d-sm-inline-block d-none me-sm-1 saveemployeeInfo">Save</span>
                                                    <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                                </button>
                                            </div>
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
                                        <label class="form-label" for="level">Level [highest degree first] <span
                                                style="color:red">*</span></label>
                                        <select class="form-select" name="degree_id" id="degree_id">
                                            <option value="">Select Class</option>
                                            @foreach ($degrees as $degree)
                                                <option value="{{ $degree->id }}">{{ $degree->degree_name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label" for="discipline_name">Discipline <span
                                                style="color:red">*</span></label>
                                        <input type="text" name="discipline_name" id="discipline_name"
                                            class="form-control" placeholder="Enter Discipline Name">
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label" for="specialization_name">Specialization</label>
                                        <input type="text" name="specialization_name" id="specialization_name"
                                            class="form-control" placeholder="Bangla/English Language & Literature">

                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label" for="degree_name">Name of degree</label>
                                        <input type="text" id="degree_name" class="form-control"
                                            placeholder="Name of degree">
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label" for="last-name">Years of schooling</label>
                                        <input type="number" id="yearOfSchooling" class="form-control"
                                            placeholder="Years of schooling">
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label" for="last-name">Educational institute</label>
                                        <input type="text" id="institute" class="form-control"
                                            placeholder="Educational institute">
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label" for="country">Passing Year</label>
                                        <select id="passingYear" class=" form-select">
                                            <option value="">Please select</option>
                                            @for ($i = date('Y'); $i > 1940; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor

                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label" for="country">Result Type</label>

                                        <select id="grade_division" class="form-select">
                                            <option value="">Please Grade</option>
                                            <option value="Grade">Grade</option>
                                            <option value="CGPA">CGPA</option>
                                            <option value="Division">Division</option>
                                            <option value="Percentage">Percentage</option>
                                        </select>


                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label" for="result">Result</label>
                                        <input type="number" id="result" class="form-control" placeholder="Result">
                                    </div>
                                    <div class="mb-3 col-md-6 form-group">
                                        <label for="inputPhoto" class="col-form-label">File <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input id="file" class="form-control" type="file" />
                                            <input class="form-control" type="hidden" id="file_old"
                                                value="{{ $education->file ?? '' }}" name="file_old">
                                        </div>
                                        <div id="file-preview" style="margin-top: 10px;"></div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-between">
                                        <button class="btn btn-label-secondary btn-prev">
                                            <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                        </button>
                                        <button class="btn btn-primary" id="education_info">
                                            <span class="align-middle d-sm-inline-block d-none me-sm-1 ">Save</span>
                                        </button>
                                    </div>
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
                                                        <td>{{ optional($education->degree)->degree_name ?? 'N/A' }}</td>
                                                        <td>{{ $education->discipline_name ?? 'N/A' }}</td>
                                                        <td>{{ $education->specialization_name ?? 'N/A' }}
                                                        </td>
                                                        <td>{{ $education->institute ?? 'NA' }}</td>
                                                        <td>{{ $education->passingYear ?? 'NA' }}</td>
                                                        <td>{{ $education->grade_division ?? 'NA' }}:{{ $education->result ?? '' }}
                                                        </td>
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
                                                                        data-discipline_name="{{ $education->discipline_name }}"
                                                                        data-specialization_name="{{ $education->specialization_name }}"
                                                                        data-institute="{{ $education->institute }}"
                                                                        data-yearofschooling="{{ $education->yearOfSchooling }}"
                                                                        data-passingyear="{{ $education->passingYear }}"
                                                                        data-degree_name="{{ $education->degree_name }}"
                                                                        data-grade_division="{{ $education->grade_division }}"
                                                                        data-result="{{ $education->result }}"
                                                                        data-file="{{ $education->file }}"
                                                                        data-file_old="{{ $education->file }}"
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
                                </div>
                            </div>
                            <!-- Social Links -->
                            <div id="payment-info" class="content">
                                <form method="POST" action="#">
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
                                        @php
                                            $total = 0;
                                        @endphp
                                        @foreach ($fees as $key => $fee)
                                            @if (isset($employeeHeadFee[$fee->id]))
                                                @php
                                                    $total += $employeeHeadFee[$fee->id][0]->amount ?? 0;
                                                @endphp
                                                <div class="col-md-12">
                                                    <div class="input-group">
                                                        <div class="input-group-text">

                                                            {{ $fee->head_name }}
                                                        </div>
                                                        <input type="text" class="form-control amount"
                                                            data-id="{{ $fee->id }}"
                                                            name="amount{{ $fee->id }}"
                                                            value="{{ isset($employeeHeadFee[$fee->id]) ? $employeeHeadFee[$fee->id][0]->amount : '' }}"
                                                            readonly="" placeholder="Amount"
                                                            aria-label="Text input with checkbox">
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <div class="input-group-text">

                                                    Total
                                                </div>
                                                <input type="text" class="form-control amount"
                                                    data-id="{{ $fee->id }}" name="amount{{ $fee->id }}"
                                                    value="{{ $total }}" readonly="" placeholder="Amount"
                                                    aria-label="Text input with checkbox">
                                            </div>
                                        </div>
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
        var loadFile = function(event, preview) {
            var file = event.target.files[0];

            if (!file) return; // If no file selected, exit function

            var sizeValue = file.size;
            var fileType = file.type;

            // Allowed file types
            var allowedTypes = ["image/jpeg", "image/jpg"];

            if (!allowedTypes.includes(fileType)) {
                Swal.fire({
                    title: "Warning!",
                    text: "Only JPG or JPEG files are allowed",
                    icon: "warning"
                });
                resetInput(event.target, preview);
                return false;
            }

            if (sizeValue > 200000) {
                Swal.fire({
                    title: "Warning!",
                    text: "File Size Too Large",
                    icon: "warning"
                });
                resetInput(event.target, preview);
                return false;
            }

            var output = document.getElementById(preview);
            output.src = URL.createObjectURL(file);
            output.onload = function() {
                URL.revokeObjectURL(output.src); // Free memory
            };
        };

        // Helper function to reset the file input
        function resetInput(inputElement, preview) {
            var idvalue = preview.slice(0, -8);
            $('#' + idvalue).val('');
            inputElement.value = ''; // Reset input field
        }
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
            $(document).ready(function() {
                $('#personal-info').hide();
                $('#payment-info').hide();

                $('.btn-next').on('click', function(e) {
                    e.preventDefault();

                    var formData = new FormData();

                    // Append each form field manually
                    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                    formData.append('id', $('input[name="id"]').val());
                    formData.append('employee_name', $('#employee_name').val());
                    formData.append('employee_name_bn', $('#employee_name_bn').val());
                    formData.append('emp_id', $('#emp_id').val());
                    formData.append('father_name', $('#father_name').val());
                    formData.append('mother_name', $('#mother_name').val());
                    formData.append('email', $('#email').val());
                    formData.append('mobile', $('#mobile').val());
                    formData.append('gender', $('#gender').val());
                    formData.append('religion', $('#religion').val());
                    formData.append('blood', $('#blood').val());
                    formData.append('dob', $('#dob').val());
                    formData.append('join_date', $('#join_date').val());
                    formData.append('present_address', $('#present_address').val());
                    formData.append('permanent_address', $('#permanent_address').val());
                    formData.append('nationality', $('#nationality').val());
                    formData.append('nid', $('#nid').val());
                    formData.append('passport', $('#passport').val());
                    formData.append('job_type', $('#job_type').val());
                    formData.append('category_id', $('#category_id').val());
                    formData.append('subject_id', $('#subject_id').val());
                    formData.append('version_id', $('#version_id').val());
                    formData.append('shift_id', $('#shift_id').val());
                    formData.append('designation_id', $('#designation_id').val());
                    formData.append('employee_for', $('#employee_for').val());
                    // formData.append('created_by', $('#created_by').val());
                    formData.append('status', 1);

                    // Get the photo input and the old photo value
                    var photoElement = $('#photo')[0];
                    var oldPhotoValue = $('#photo_old').val();

                    // Append old photo value to FormData
                    formData.append('photo_old', oldPhotoValue);

                    // Check if a new photo is selected, otherwise set the old photo value
                    if (photoElement.files.length > 0) {
                        formData.append('photo', photoElement.files[0]);
                    } else if (oldPhotoValue) {
                        formData.append('photo', oldPhotoValue);
                    }

                    $.LoadingOverlay("show");

                    $.ajax({
                        url: '{{ route('employees.store') }}',
                        type: 'POST',
                        data: formData,
                        processData: false, // Necessary for FormData
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $.LoadingOverlay("hide");

                            Swal.fire({
                                title: 'Success',
                                text: response.message,
                                icon: 'success'
                            }).then(() => {
                                $('#account-details').hide();
                                $('#personal-info').show();
                            });
                        },
                        error: function(xhr, status, error) {
                            // Hide the loading overlay (optional)
                            $.LoadingOverlay("hide");

                            // Show error message
                            Swal.fire({
                                title: 'Error',
                                text: 'An error occurred while saving the data. Please try again.',
                                icon: 'error'
                            });
                        }
                    });
                });

                // Handle "Previous" button click
                $('.btn-prev').on('click', function(e) {
                    e.preventDefault(); // Prevent default action

                    // Navigate back to the previous section
                    $('#personal-info').hide();
                    $('#account-details').show();
                });
            });

            // $(document.body).on('click', '.edit', function() {
            //     var id = $(this).data('id');
            //     var specialization_name = $(this).data('specialization_name');
            //     var file = $(this).data('file');
            //     var employee_id = $(this).data('employee_id');
            //     var degree_id = $(this).data('degree_id');
            //     var discipline_name = $(this).data('discipline_name');
            //     var passingYear = $(this).data('passingyear');
            //     var yearOfSchooling = $(this).data('yearofschooling');
            //     var institute = $(this).data('institute');
            //     var degree_name = $(this).data('degree_name');
            //     var grade_division = $(this).data('grade_division');
            //     var result = $(this).data('result');
            //     $('#file').val(file);
            //     $('#education_id').val(id);
            //     $('#specialization_name').val(specialization_name);
            //     $('#employee_id').val(employee_id);
            //     $('#degree_id').val(degree_id);
            //     $('#discipline_name').val(discipline_name);
            //     $('#passingYear').val(passingYear);
            //     $('#yearOfSchooling').val(yearOfSchooling);
            //     $('#institute').val(institute);
            //     $('#degree_name').val(degree_name);
            //     $('#grade_division').val(grade_division);
            //     $('#result').val(result);
            //     $('#submit').text('Update');
            // });
            $(document.body).on('click', '.edit', function() {
                var id = $(this).data('id');
                var specialization_name = $(this).data('specialization_name');
                var file = $(this).data('file'); // File URL from the database
                var file_old = $(this).data('file_old');
                var employee_id = $(this).data('employee_id');
                var degree_id = $(this).data('degree_id');
                var discipline_name = $(this).data('discipline_name');
                var passingYear = $(this).data('passingyear');
                var yearOfSchooling = $(this).data('yearofschooling');
                var institute = $(this).data('institute');
                var degree_name = $(this).data('degree_name');
                var grade_division = $(this).data('grade_division');
                var result = $(this).data('result');

                // Set form values
                $('#file').val(''); // Reset the file input field
                $('#file_old').val(file_old);
                $('#education_id').val(id);
                $('#specialization_name').val(specialization_name);
                $('#employee_id').val(employee_id);
                $('#degree_id').val(degree_id);
                $('#discipline_name').val(discipline_name);
                $('#passingYear').val(passingYear);
                $('#yearOfSchooling').val(yearOfSchooling);
                $('#institute').val(institute);
                $('#degree_name').val(degree_name);
                $('#grade_division').val(grade_division);
                $('#result').val(result);
                $('#submit').text('Update');

                // File preview
                const previewContainer = document.getElementById('file-preview');
                previewContainer.innerHTML = ''; // Clear previous previews

                if (file) {
                    const fileType = file.split('.').pop().toLowerCase(); // Get file extension

                    if (['jpg', 'jpeg', 'png', 'gif'].includes(fileType)) {
                        // Preview image
                        const img = document.createElement('img');
                        img.src = file; // File URL from the database
                        img.alt = 'Image preview';
                        img.style.maxWidth = '200px';
                        img.style.border = '1px solid #ccc';
                        img.style.borderRadius = '8px';
                        img.style.boxShadow = '0 2px 4px rgba(0, 0, 0, 0.1)';
                        img.style.marginTop = '10px';
                        previewContainer.appendChild(img);
                    } else if (fileType === 'pdf') {
                        // Preview PDF
                        const pdfEmbed = document.createElement('embed');
                        pdfEmbed.src = file; // File URL from the database
                        pdfEmbed.type = 'application/pdf';
                        pdfEmbed.style.width = '200px';
                        pdfEmbed.style.height = '250px';
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

            // $(document.body).on('click', '#education_info', function() {
            //     var id = $('#education_id').val();
            //     var employee_id = $('#employee_id').val();
            //     var degree_id = $('#degree_id').val();
            //     var file = $('#thumbnail').val();
            //     var discipline_name = $('#discipline_name').val();
            //     var specialization_name = $('#specialization_name').val();
            //     var yearOfSchooling = $('#yearOfSchooling').val();
            //     var degree_name = $('#degree_name').val();
            //     var passingYear = $('#passingYear').val();
            //     var institute = $('#institute').val();
            //     var grade_division = $('#grade_division').val();
            //     var result = $('#result').val();
            //     var url = "{{ route('saveEducation') }}";
            //     if (id && degree_id && discipline_name) {
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
            //                 discipline_name,
            //                 specialization_name,
            //                 degree_name,
            //                 passingYear,
            //                 grade_division,
            //                 result
            //             },
            //             success: function(response) {
            //                 Swal.fire({
            //                     title: "Success",
            //                     text: "Education details saved successfully!",
            //                     icon: "success"
            //                 }).then((result) => {
            //                     // $('#personal-info').hide();
            //                     // $('#account-details').show();
            //                     window.location.reload();
            //                 });

            //             },
            //             error: function(data, errorThrown) {
            //                 Swal.fire({
            //                     title: "Error",
            //                     text: errorThrown,
            //                     icon: "warning"
            //                 });
            //             },
            //             complete: function() {
            //                 $.LoadingOverlay("hide");
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
            $(document.body).on('click', '#education_info', function() {
                var id = $('#education_id').val();
                var employee_id = $('#employee_id').val();
                var degree_id = $('#degree_id').val();
                var file = $('#file')[0].files[0]; // Get the file from the input
                var file_old = $('#file_old').val(); // Get the old file URL
                var discipline_name = $('#discipline_name').val();
                var specialization_name = $('#specialization_name').val();
                var yearOfSchooling = $('#yearOfSchooling').val();
                var degree_name = $('#degree_name').val();
                var passingYear = $('#passingYear').val();
                var institute = $('#institute').val();
                var grade_division = $('#grade_division').val();
                var result = $('#result').val();
                var url = "{{ route('saveEducation') }}";

                if (degree_id && discipline_name) {
                    $.LoadingOverlay("show");

                    var formData = new FormData(); // Create a FormData object
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('id', id);
                    formData.append('employee_id', employee_id);
                    formData.append('degree_id', degree_id);
                    formData.append('file', file); // Attach the file
                    formData.append('file_old', file_old); // Attach the old file URL
                    formData.append('discipline_name', discipline_name);
                    formData.append('specialization_name', specialization_name);
                    formData.append('yearOfSchooling', yearOfSchooling);
                    formData.append('degree_name', degree_name);
                    formData.append('passingYear', passingYear);
                    formData.append('institute', institute);
                    formData.append('grade_division', grade_division);
                    formData.append('result', result);

                    $.ajax({
                        type: "POST",
                        url: url,
                        data: formData,
                        processData: false, // Prevent jQuery from automatically processing the data
                        contentType: false, // Set content type to false (multipart/form-data)
                        success: function(response) {
                            Swal.fire({
                                title: "Success",
                                text: "Education details saved successfully!",
                                icon: "success"
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: "Error",
                                text: xhr.responseJSON?.message || "An error occurred!",
                                icon: "warning"
                            });
                        },
                        complete: function() {
                            $.LoadingOverlay("hide");
                        }
                    });
                } else {
                    Swal.fire({
                        title: "Error",
                        text: "Please fill up all required fields!",
                        icon: "warning"
                    });
                }
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

        });
    </script>
    <script>
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
