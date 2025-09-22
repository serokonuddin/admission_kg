@extends('admin.layouts.layout')
@section('content')
    <style>
        .bs-stepper .bs-stepper-header .step .step-trigger .bs-stepper-label .bs-stepper-title {
            font-size: 1rem !important;
        }

        .bs-stepper .line i {
            font-size: 1.5rem !important;
        }

        .modal {
            --bs-modal-width: 57rem !important;
        }

        .bn-node {
            text-transform: math-auto !important;
            margin-bottom: .2rem;
            font-size: 1.2rem !important;
            color: #0311ff;
        }

        .nb {
            text-transform: math-auto !important;
            font-size: 1rem !important;
            margin-bottom: .2rem;
            color: red !important;
        }

        span.text-danger {
            font-size: 16px;
        }

        .form-label,
        .col-form-label {
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: inherit;
        }

        .form-check-label {
            font-size: 16px;
        }

        .hide {
            display: none;
        }

        .show {
            display: flex;
        }

        .showinput {
            display: block;
        }

        .bs-stepper .bs-stepper-header .step .step-trigger {
            padding: 0 .4rem !important;
        }

        .error {
            border-color: red !important;
        }

        input:focus {
            outline: none;
            border-color: red !important;
            box-shadow: 0 0 5px red;
        }

        @media (min-width: 600px) {
            .bs-stepper {
                max-height: 80vh;
                overflow-y: auto;
                position: relative;
            }

            .bs-stepper-header {
                position: sticky;
                top: 0;
                background-color: #e5e5e5;
                margin: 10px;
                border-radius: 10px;
            }

            .justify-content-between {
                position: sticky;
                bottom: 0;
                background-color: #e5e5e5;
                padding: 10px !important;
            }

            .bs-stepper .bs-stepper-content {
                padding: .75rem .75rem !important;
            }

            .bs-stepper-content {
                padding: 0 8px 4px !important;
            }
        }

        @media (max-width: 600px) {
            .btn-info {
                margin-left: 40% !important;
            }

            .bs-stepper .bs-stepper-header {
                padding: .485rem 1.125rem !important;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('/') }}public/backend/assets/vendor/libs/bs-stepper/bs-stepper.css" />
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Student Admission Form</li>
                </ol>
            </nav>
            <!-- Default -->
            <div class="row">
                <!-- Validation Wizard -->
                <div class="col-12 mb-4">
                    <div class="bs-stepper wizard-icons wizard-icons-example mt-2">
                        <div class="bs-stepper-header" style="z-index: 1">
                            <div class="step active text-bold " id="accountdetails">
                                <button type="button" class="step-trigger headermenu" data-currentdata="account-details"
                                    data-pre="none" aria-selected="true">
                                    <span class="bs-stepper-label">Personal Info</span>
                                </button>
                            </div>
                            <div class="line">
                                <i class="bx bx-chevron-right"></i>
                            </div>
                            <div class="step" id="academicinfo">
                                <button type="button" class="step-trigger headermenu" data-currentdata="academic-info"
                                    data-pre="account-details" aria-selected="false">
                                    <span class="bs-stepper-label">Admitted Class Info</span>
                                </button>
                            </div>
                            <div class="line">
                                <i class="bx bx-chevron-right"></i>
                            </div>
                            <div class="step" id="desiredsubject">
                                <button type="button" class="step-trigger headermenu" data-currentdata="personal-info"
                                    data-pre="academic-info" aria-selected="false">

                                    <span class="bs-stepper-label">Subject Selection</span>
                                </button>
                            </div>
                            <div class="line" id="desiredsubjectline">
                                <i class="bx bx-chevron-right"></i>
                            </div>
                            <div class="step" id="force">
                                <button type="button" class="step-trigger headermenu" data-currentdata="social-links"
                                    data-pre="personal-info" aria-selected="false">
                                    <span class="bs-stepper-label">Special Information</span>
                                </button>
                            </div>
                            <div class="line" id="sscexamdetailsline">
                                <i class="bx bx-chevron-right"></i>
                            </div>
                            <div class="step" id="sscexamdetails">
                                <button type="button" class="step-trigger headermenu" data-currentdata="address"
                                    data-pre="social-links" aria-selected="false">

                                    <span class="bs-stepper-label">SSC Exam Details</span>
                                </button>
                            </div>
                        </div>
                        <div class="bs-stepper-content">
                            <form id="formAdmission" method="POST" action="{{ route('college-students.store') }}"
                                enctype="multipart/form-data">
                                <input type="hidden" name="class_code" value="11">
                                @csrf
                                <!-- Account Details stepper starts from here -->
                                <div id="account-details" class="content active dstepper-block">
                                    <div class="content-header mb-3">
                                        <h6 class="mb-0" style="color: #da45dc;font-size:16px;font-weight: bold">Student
                                            Information</h6>
                                        <small class="text-danger">Asterisk(*) fields need to be completed.</small>
                                    </div>
                                    <div class="row g-3">
                                        <div class="mb-3 col-md-6">
                                            <label for="first_name" class="form-label">Student's Name (English)<span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="first_name" name="first_name"
                                                required placeholder="Student's Name (English)" autofocus="">
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label for="last_name" class="form-label">Student's Name (Bangla)</label>
                                            <input class="form-control" type="text" name="bangla_name" id="bangla_name"
                                                placeholder="Student's Name (Bangla)">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="state" class="form-label">Birth Date
                                                {{-- <span class="text-danger">*</span></label> --}}
                                                <input class="form-control" type="date" id="birthdate"
                                                    name="birthdate" placeholder="Birth Date">
                                                <div class="invalid-feedback">Please enter your Birth Date. </div>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="state" class="form-label">Birth Registration No</label>
                                            <input class="form-control" type="number" id="birth_no" name="birth_no"
                                                placeholder="Birth Registration No">

                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="religion" class="form-label">Religion<span
                                                    class="text-danger">*</span></label>
                                            <select id="religion" name="religion" class=" form-select" required="">
                                                <option value="">Select Religion</option>
                                                <option value="1">
                                                    Islam</option>
                                                <option value="2">
                                                    Hindu</option>
                                                <option value="3">
                                                    christian</option>
                                                <option value="4">
                                                    Buddhism</option>
                                                <option value="5">
                                                    Others</option>
                                            </select>
                                            <div class="invalid-feedback">Please select your Religion. </div>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="nationality" class="form-label">Nationality<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" required id="nationality"
                                                name="nationality" placeholder="Nationality" value="Bangladeshi"
                                                readonly="">
                                            <div class="invalid-feedback">Please enter your Nationality. </div>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="email" class="form-label">E-mail</label>
                                            <input class="form-control" type="email" id="email" name="email"
                                                placeholder="john.doe@example.com">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="organization" class="form-label">Mobile<span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text">BD (+88)</span>
                                                <input type="number" id="mobile" name="mobile" class="form-control"
                                                    required placeholder="01XXXXXXXXX">
                                            </div>
                                            <div class="invalid-feedback">Please enter your Mobile. </div>
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label for="gender" class="form-label">Gender<span
                                                    class="text-danger">*</span></label>
                                            <select id="gender" name="gender" class="form-select" required="">
                                                <option value="">Select Gender</option>
                                                <option value="1">

                                                    Male</option>
                                                <option value="2">
                                                    Female</option>

                                            </select>
                                            <div class="invalid-feedback">Please select your Gender. </div>
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label for="blood" class="form-label">Blood</label>
                                            <select id="blood" name="blood" id="blood" class=" form-select">
                                                <option value="">Select Blood</option>
                                                <option value="O+">
                                                    O+</option>
                                                <option value="O-">
                                                    O-</option>
                                                <option value="A+">
                                                    A+</option>
                                                <option value="A-">
                                                    A-</option>
                                                <option value="B+">
                                                    B+</option>
                                                <option value="B-">
                                                    B-</option>
                                                <option value="AB+">
                                                    AB+</option>
                                                <option value="AB-">
                                                    AB-</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="first_name" class="form-label">Father's Name<span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" required="" type="text" id="father_name"
                                                name="father_name" placeholder="Father's Name" autofocus="">
                                            <div class="invalid-feedback">Please enter your Father's Name. </div>
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="father_email" class="form-label">Father's Email</label>
                                            <input class="form-control" type="text" id="father_email"
                                                name="father_email" placeholder="Father's Email" autofocus="">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="father_phone" class="form-label">Father's Contact Number</label>
                                            <input class="form-control" type="number" id="father_phone"
                                                name="father_phone" placeholder="Father's Phone" autofocus="">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="father_profession" class="form-label">Father's Profession</label>
                                            <input class="form-control" type="text" id="father_profession"
                                                name="father_profession" placeholder="Father's Profession"
                                                autofocus="">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="mother_name" class="form-label">Mother's Name
                                                {{-- <span class="text-danger">*</span></label> --}}
                                                <input class="form-control" type="text" name="mother_name"
                                                    id="mother_name" placeholder="Mother's Name">
                                                <div class="invalid-feedback">Please enter your Mother's Name. </div>
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="mother_email" class="form-label">Mother's Email</label>
                                            <input class="form-control" type="text" name="mother_email"
                                                id="mother_email" placeholder="Mother's Email">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="mother_phone" class="form-label">Mother's Contact Number</label>
                                            <input class="form-control" type="number" name="mother_phone"
                                                id="mother_phone" placeholder="Mother's Phone">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="mother_profession" class="form-label">Mother's Profession</label>
                                            <input class="form-control" type="text" name="mother_profession"
                                                id="mother_profession" placeholder="Mother Profession">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="mother_profession" class="form-label">Father's NID Number</label>
                                            <input class="form-control" type="number" name="father_nid_number"
                                                id="father_nid_number" placeholder="Father's NID Number">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="mother_profession" class="form-label">Mother's NID Number</label>
                                            <input class="form-control" type="number" name="mother_nid_number"
                                                id="mother_nid_number" placeholder="Mother's NID Number">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="father_nid" class="form-label">Father's NID (jpg,jpeg
                                                format)</label>
                                            <input class="form-control" type="file"
                                                onchange="loadFile(event,'father_nid_preview')" id="father_nid"
                                                name="father_nid">

                                            <img id="father_nid_preview" alt="Father NID Preview"
                                                style="max-width: 100px; display: none;">
                                            <span style="color: rgb(0,149,221)">(File size max 200 KB)</span>

                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="mother_nid" class="form-label">Mother's NID (jpg,jpeg
                                                format)</label>
                                            <input class="form-control" type="file"
                                                onchange="loadFile(event,'mother_nid_preview')" id="mother_nid"
                                                name="mother_nid">
                                            <img id="mother_nid_preview" alt="Mother NID Preview"
                                                style="max-width: 100px; display: none;">
                                            <span style="color: rgb(0,149,221)">(File size max 200 KB)</span>

                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="sms_notification" class="form-label">SMS Notification <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="number" name="sms_notification"
                                                required="required" id="sms_notification" placeholder="SMS Notification">
                                            <div class="invalid-feedback">Please enter your SMS Notification Number. </div>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="parent_income" class="form-label">Parent's Annual Income</label>
                                            <input class="form-control" type="text" name="parent_income"
                                                id="parent_income" placeholder="Parent's Annual Income">
                                        </div>

                                        <div class="mb-3 col-md-12">
                                            <p style="color: rgb(0,149,221)">Address:</p>
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="present_addr" class="form-label">Present Address</label>
                                            <input type="text" id="present_addr" name="present_addr"
                                                class="form-control" placeholder="Present Address">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="present_police_station" class="form-label">Present Police
                                                Station</label>
                                            <input type="text" id="present_police_station"
                                                name="present_police_station" class="form-control"
                                                placeholder="Present Police Station">

                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="present_district_id" class="form-label">Present District</label>
                                            <select id="present_district_id" name="present_district_id"
                                                id="present_district_id" class=" form-select">
                                                <option value="">Select District</option>
                                                @foreach ($districts as $district)
                                                    <option value="{{ $district->id }}">
                                                        {{ $district->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <div class="demo-inline-spacing">
                                                <label class="form-check m-0">
                                                    <input type="checkbox" class="form-check-input" id="same_as"
                                                        name="same_as" value="1">
                                                    <span class="form-check-label">SAME AS PRESENT ADDRESS</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label for="permanent_addr" class="form-label">Permanent Address</label>
                                            <input type="text" id="permanent_addr" name="permanent_addr"
                                                class="form-control" placeholder="Permanent Address">

                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="permanent_police_station" class="form-label">Permanent Police
                                                Station</label>
                                            <input type="text" id="permanent_police_station"
                                                name="permanent_police_station" class="form-control"
                                                placeholder="Permanent Police Station">

                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="permanent_district_id" class="form-label">Permanent
                                                District</label>
                                            <select id="permanent_district_id" name="permanent_district_id"
                                                id="permanent_district_id" class=" form-select">
                                                <option value="">Select District</option>
                                                @foreach ($districts as $district)
                                                    <option value="{{ $district->id }}">
                                                        {{ $district->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <p style="color: rgb(0,149,221)">Local Guardian (Father/Mother/Relative):</p>
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="local_guardian_name" class="form-label">Local Guardian Name
                                                {{-- <span class="text-danger">*</span></label> --}}
                                                <input type="text" class="form-control" id="local_guardian_name"
                                                    name="local_guardian_name" placeholder="Guardian Name">
                                                <div class="invalid-feedback">Please enter your Guardian Name. </div>
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="guardian_name" class="form-label">Local Guardian Mobile
                                                {{-- <span class="text-danger">*</span></label> --}}
                                                <input type="number" class="form-control" id="local_guardian_mobile"
                                                    name="local_guardian_mobile" placeholder="Guardian Mobile">
                                                <div class="invalid-feedback">Please enter your Guardian Mobile. </div>
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="guardian_email" class="form-label">Local Guardian Email</label>
                                            <input type="email" class="form-control" id="local_guardian_email"
                                                name="local_guardian_email" placeholder="Guardian Email">

                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="student_relation" class="form-label">Relation with Student
                                                {{-- <span class="text-danger">*</span></label> --}}
                                                <input type="text" id="student_relation" name="student_relation"
                                                    class="form-control" placeholder="Relation With student">
                                                <div class="invalid-feedback">Please enter your Guardian Name. </div>
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="local_guardian_address" class="form-label">Local Guardian
                                                Address</label>
                                            <input type="text" id="local_guardian_address"
                                                name="local_guardian_address" class="form-control"
                                                placeholder="Local guardian Address">

                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="local_guardian_police_station" class="form-label">Local Police
                                                Station</label>
                                            <input type="text" id="local_guardian_police_station"
                                                name="local_guardian_police_station" class="form-control"
                                                placeholder="Local guardian Police Station">

                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="local_guardian_district_id" class="form-label">Local guardian
                                                District</label>
                                            <select id="local_guardian_district_id" name="local_guardian_district_id"
                                                id="local_permanent_district_id" class=" form-select">
                                                <option value="">Select District</option>
                                                @foreach ($districts as $district)
                                                    <option value="{{ $district->id }}">
                                                        {{ $district->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="photo" class="form-label">Student's Recent Passport Size Photo
                                                (jpg,jpeg format)
                                                {{-- <span class="text-danger">*</span></label> --}}
                                                <input class="form-control" type="file" id="photo"
                                                    onchange="loadFile(event,'photo_preview')" name="photo">

                                                <img id="photo_preview" alt="Photo Preview"
                                                    style="max-width: 100px; display: none;">

                                                <span style="color: rgb(0,149,221)">(File size max 200 KB)</span>

                                        </div>


                                        <div class="mb-3 col-md-6">
                                            <label for="academic_transcript" class="form-label">BIRTH Certificate
                                                (jpg,jpeg format)</label>
                                            <input class="form-control" type="file"
                                                onchange="loadFile(event,'birth_certificate_preview')"
                                                id="birth_certificate" name="birth_certificate">

                                            <img id="birth_certificate_preview" alt="Birth Certificate Preview"
                                                style="max-width: 100px; display: none;">

                                            <span style="color: rgb(0,149,221)">(File size max 200 KB)</span>
                                        </div>

                                        @if (Auth::user()->is_view_user == 0)
                                            <div class="col-12 d-flex justify-content-between">
                                                <button class="btn btn-label-secondary btn-prev" disabled="">
                                                    <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                                    <span
                                                        class="align-middle d-sm-inline-block d-none Previous">Previous</span>
                                                </button>
                                                <button style="margin-left: 60%;" type="button"
                                                    data-value="academicinfo" data-pre="accountdetails"
                                                    data-target="#academic-info" class="btn btn-info savebtn">
                                                    <span class="align-right d-sm-inline-block d-none me-sm-1">Save</span>
                                                </button>
                                                <button type="button" data-value="academicinfo"
                                                    data-currentdata="account-details" data-pre="accountdetails"
                                                    data-target="#academic-info" class="btn btn-primary nextbtn">
                                                    <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                                    <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- Account Details stepper ends here -->
                                <!-- Review  and final submit section starts-->
                                <div id="academic-info" class="content">
                                    <div class="content-header mb-3">
                                        <h6 class="mb-0" style="color: #da45dc;font-weight: bold;font-size: 16px;">
                                            Academic Info</h6>
                                    </div>
                                    <div class="row g-3">
                                        <div class="mb-3 col-md-3">
                                            <label for="session" class="form-label">Session</label>
                                            <select id="session_id" name="session_id" class=" form-select"
                                                required="">
                                                <option value="">Select Session</option>
                                                @foreach ($sessions as $session_code => $session_name)
                                                    <option value="{{ $session_code }}">
                                                        {{ $session_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="version" class="form-label">Version</label>
                                            <select id="version_id" name="version_id" class="form-select">
                                                <option value="">Select Version</option>
                                                @foreach ($versions as $version_id => $version_name)
                                                    <option value="{{ $version_id }}">
                                                        {{ $version_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="shift" class="form-label">Shift</label>
                                            <select id="shift_id" name="shift_id" class=" form-select" required="">
                                                <option value="">Select Shift</option>
                                                @foreach ($shifts as $shift_id => $shift_name)
                                                    <option value="{{ $shift_id }}">
                                                        {{ $shift_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="class" class="form-label">Class</label>
                                            <select id="class_code" name="class_code" class=" form-select"
                                                required="">
                                                <option value="">Select Class</option>
                                                @foreach ($classes as $class_code => $class_name)
                                                    <option value="{{ $class_code }}">
                                                        {{ $class_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="section" class="form-label">Section</label>
                                            <select id="section_id" name="section_id" class=" form-select">
                                                <option value="">Select Section</option>
                                                @foreach ($sections as $section)
                                                    <option value="{{ $section->id }}">
                                                        {{ $section->section_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="category" class="form-label">Category</label>
                                            <select id="category_id" name="category_id" class=" form-select">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">
                                                        {{ $category->category_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="house" class="form-label">House</label>
                                            <select id="house_id" name="house_id" class=" form-select">
                                                <option value="">Select House </option>
                                                @foreach ($houses as $house)
                                                    <option value="{{ $house->id }}">
                                                        {{ $house->house_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {{-- <div class="mb-3 col-md-3">
                                            <label for="roll" class="form-label">Roll</label>
                                            <input class="form-control" type="number" id="roll" name="roll"
                                                placeholder="Roll" autofocus="">
                                        </div> --}}
                                        {{-- Previous , Next and Save Button --}}
                                        @if (Auth::user()->is_view_user == 0)
                                            <div class="row g-3" id="btn1-desired">
                                                <div class="col-12 d-flex justify-content-between">
                                                    <button type="button" class="btn btn-primary btn-prev">
                                                        <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                                        <span class="align-middle d-sm-inline-block d-none Previous"
                                                            data-next="accountdetails" data-currentdata="academicinfo"
                                                            data-target="#account-details">Previous</span>
                                                    </button>
                                                    <button style="margin-left: 60%;" type="button"
                                                        data-value="academicinfo" data-pre="accountdetails"
                                                        data-target="#personal-info" class="btn btn-info"
                                                        id="saveButton">
                                                        <span
                                                            class="align-right d-sm-inline-block d-none me-sm-1">Save</span>
                                                    </button>
                                                    <button type="button" data-value="desiredsubject"
                                                        data-currentdata="academic-info" data-pre="accountdetails"
                                                        data-target="#personal-info" class="btn btn-primary btn-next"
                                                        id="nextButton">
                                                        <span
                                                            class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                                        <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endif

                                        @if (Auth::user()->is_view_user == 0)
                                            <div class="row g-3" id="btn2-desired">
                                                <div class="col-12 d-flex justify-content-between">
                                                    <button type="button" class="btn btn-primary btn-prev">
                                                        <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                                        <span class="align-middle d-sm-inline-block d-none Previous"
                                                            data-next="accountdetails" data-currentdata="academicinfo"
                                                            data-target="#account-details">Previous</span>
                                                    </button>
                                                    <button style="margin-left: 60%;" type="button"
                                                        data-value="academicinfo" data-pre="accountdetails"
                                                        data-target="#personal-info" class="btn btn-info"
                                                        id="saveButton">
                                                        <span
                                                            class="align-right d-sm-inline-block d-none me-sm-1">Save</span>
                                                    </button>

                                                    <button type="button" data-value="social-links"
                                                        data-currentdata="academic-info" data-pre="accountdetails"
                                                        data-target="#social-links" class="btn btn-primary btn-next"
                                                        id="nextButton">
                                                        <span
                                                            class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                                        <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- Review  and final submit section ends-->
                                <!-- Personal Info starts from here -->
                                <div id="personal-info" class="content">
                                    <div class="content-header mb-3">
                                        <h6 class="mb-0" style="color: #da45dc;font-weight: bold;font-size: 16px;">
                                            Desired
                                            Subject</h6>
                                        <small>According ot the college prospectus</small>
                                    </div>
                                    <div class="row g-3">
                                        <div class="mb-3 col-md-4">
                                            <label for="group" class="form-label">Group</label>
                                            <select id="group_id" name="group_id" class="form-select">
                                                <option value="">Select Group</option>
                                                @foreach ($groups as $group)
                                                    <option value="{{ $group->id }}">
                                                        {{ $group->group_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{-- Dynamic subject will load here --}}
                                    <div class="row g-3" id="subjects_container"></div>
                                </div>
                                <!-- Personal Info starts from here -->
                                <!-- Social Links starts here -->
                                <div id="social-links" class="content">
                                    <div class="content-header mb-3" id="armedforce">
                                        <h6 class="mb-0" style="color: #da45dc;font-weight: bold;font-size: 19px;">
                                            Select Your Category</h6>
                                        <div class="col-md">
                                            <div class="form-check mt-3">
                                                <input name="categoryid" class="form-check-input specialinfo"
                                                    type="radio" value="1" id="defaultRadio1">
                                                <label class="form-check-label" for="defaultRadio1">
                                                    Civil
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input name="categoryid" class="form-check-input specialinfo"
                                                    type="radio" value="2" id="defaultRadio2">
                                                <label class="form-check-label" for="defaultRadio2">
                                                    Son/daughter of Armed Forces' Member
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input specialinfo" name="categoryid"
                                                    type="radio" value="3" id="disabledRadio3">
                                                <label class="form-check-label" for="disabledRadio3">
                                                    Son/daughter of Teaching/Non-Teaching staff of BAFSD
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Category 1 --}}
                                    @if (Auth::user()->is_view_user == 0)
                                        <div class="row g-3" id="civildata" style="display: none;">
                                            <div class="row g-3" id="prevsubmit1">
                                                <div class="col-12 d-flex justify-content-between">
                                                    <button type="button" class="btn btn-primary btn-prev">
                                                        <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                                        <span class="align-middle d-sm-inline-block d-none Previous"
                                                            data-next="personal-info" data-currentdata="social-links"
                                                            data-target="#personal-info">Previous</span>
                                                    </button>
                                                    <button style="margin-left: 60%;" type="button"
                                                        data-value="social-links" data-pre="personal-info"
                                                        data-target="#address" class="btn btn-info" id="saveButton">
                                                        <span
                                                            class="align-right d-sm-inline-block d-none me-sm-1">Save</span>
                                                    </button>
                                                    <button type="button" data-value="address"
                                                        data-currentdata="social-links" data-pre="personal-info"
                                                        data-target="#sscexamdetails" class="btn btn-primary nextbtn"
                                                        id="nextButton">
                                                        <span
                                                            class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                                        <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    {{-- Category 2 --}}
                                    <div class="row g-3" id="armforce" style="display: none;">
                                        <div class="mb-3 col-md-4">
                                            <label for="guardian_email" class="form-label">Name of service Holder<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="Name of service holder">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="guardian_name" class="form-label">Rank/Designation<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="designation"
                                                name="designation" placeholder="Rank/Designation">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="local_guardian_name" class="form-label">Service number<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="service_number"
                                                name="service_number" placeholder="Service number">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="guardian_name" class="form-label">Name of Service<span
                                                    class="text-danger">*</span></label>
                                            <select id="arms_name" name="arms_name" class=" form-select">
                                                <option value="">Select Option</option>
                                                <option value="Air Force">Air Force</option>
                                                <option value="Army">Army</option>
                                                <option value="Navy">Navy</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="guardian_email" class="form-label">In service<span
                                                    class="text-danger">*</span></label>
                                            <select id="is_service" name="is_service" class=" form-select">
                                                <option value="">Select Option</option>
                                                <option value="1">Yes</option>
                                                <option value="2">No</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-6" id="office_address_div">
                                            <label for="guardian_email" class="form-label">Present office Address<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="office_address" requird
                                                name="office_address" placeholder="Office Address">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="arm_certification" class="form-label">Certification/Testimonial
                                                from
                                                office (jpg,jpeg format)<span class="text-danger">*</span></label>
                                            <input class="form-control" type="file"
                                                onchange="loadFile(event,'arm_certification_preview')" requird
                                                id="arm_certification" name="arm_certification">
                                            <img id="arm_certification_preview" alt="Arm Certification Preview"
                                                style="max-width: 100px; display: none;">
                                            <span style="color: rgb(0,149,221)">(File size max 200 KB)</span>

                                        </div>
                                        @if (Auth::user()->is_view_user == 0)
                                            <div class="row g-3" id="prevsubmit2">
                                                <div class="col-12 d-flex justify-content-between">
                                                    <button type="button" class="btn btn-primary btn-prev">
                                                        <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                                        <span class="align-middle d-sm-inline-block d-none Previous"
                                                            data-next="personal-info" data-currentdata="social-links"
                                                            data-target="#personal-info">Previous</span>
                                                    </button>
                                                    <button style="margin-left: 60%;" type="button"
                                                        data-value="social-links" data-pre="personal-info"
                                                        data-target="#address" class="btn btn-info" id="saveButton">
                                                        <span
                                                            class="align-right d-sm-inline-block d-none me-sm-1">Save</span>
                                                    </button>
                                                    <button type="button" data-value="address"
                                                        data-currentdata="social-links" data-pre="personal-info"
                                                        data-target="#sscexamdetails" class="btn btn-primary nextbtn"
                                                        id="nextButton">
                                                        <span
                                                            class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                                        <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    {{-- Category 3 --}}
                                    <div class="row g-3" id="teacherinfo" style="display: none;">
                                        <div class="mb-3 col-md-6">
                                            <label for="local_guardian_name" class="form-label">Name of the staff<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="name_of_staff"
                                                name="name_of_staff" placeholder="Name of the staff">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="guardian_name" class="form-label">Designation<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="staff_designation"
                                                name="staff_designation" placeholder="Designation">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="guardian_email" class="form-label">Staff ID<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="staff_id" name="staff_id"
                                                placeholder="Staff ID">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="academic_transcript" class="form-label">Staff
                                                Certification/Testimonial from BAFSD (jpg,jpeg format)<span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="file"
                                                onchange="loadFile(event,'staff_certification_preview')" required
                                                id="staff_certification" name="staff_certification">
                                            <img id="staff_certification_preview" alt="Staff Certification Preview"
                                                style="max-width: 100px; display: none;">
                                            <span style="color: rgb(0,149,221)">(File size max 200 KB)</span>
                                        </div>
                                        @if (Auth::user()->is_view_user == 0)
                                            <div class="row g-3" id="prevsubmit3">
                                                <div class="col-12 d-flex justify-content-between">
                                                    <button type="button" class="btn btn-primary btn-prev">
                                                        <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                                        <span class="align-middle d-sm-inline-block d-none Previous"
                                                            data-next="personal-info" data-currentdata="social-links"
                                                            data-target="#personal-info">Previous</span>
                                                    </button>
                                                    <button style="margin-left: 60%;" type="button"
                                                        data-value="social-links" data-pre="personal-info"
                                                        data-target="#address" class="btn btn-info" id="saveButton">
                                                        <span
                                                            class="align-right d-sm-inline-block d-none me-sm-1">Save</span>
                                                    </button>
                                                    <button type="button" data-value="address"
                                                        data-currentdata="social-links" data-pre="personal-info"
                                                        data-target="#sscexamdetails" class="btn btn-primary nextbtn"
                                                        id="nextButton">
                                                        <span
                                                            class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                                        <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    {{-- Preview and submit dynamically will show --}}
                                    @if (Auth::user()->is_view_user == 0)
                                        <div class="row g-3" id="dynamicSubmit">
                                            <div class="col-12 d-flex justify-content-between">
                                                <input type="hidden" class="btn btn-warning me-2" name="submit"
                                                    id="submit" value="1">
                                                <button type="button" class="btn btn-primary btn-prev">
                                                    <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                                    <span class="align-middle d-sm-inline-block d-none Previous"
                                                        data-next="academic-info" data-currentdata="academicinfo"
                                                        data-target="#academic-info">Previous</span>
                                                </button>
                                                <button type="button" class="btn btn-success" id="btn-submit">Submit &
                                                    Preview</button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <!-- Social Links ends here -->
                                <!-- Address section starts here -->
                                <div id="address" class="content">
                                    <div class="content-header mb-3">
                                        <h6 class="mb-0" style="color: #da45dc;font-weight: bold;font-size: 16px;">
                                            Secondary (SSC) Exam details</h6>
                                        <small></small>
                                    </div>
                                    <div class="row g-3">
                                        <div class="mb-3 col-md-6">
                                            <label for="first_name" class="form-label">Name Of School</label>
                                            <input class="form-control" type="text" id="school_name"
                                                name="school_name" placeholder="Name Of School" autofocus="">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="father_email" class="form-label">Upozila/Thana</label>
                                            <input class="form-control" type="text" id="thana" name="thana"
                                                placeholder="Upozila/Thana" autofocus="">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="first_name" class="form-label">Exam Center</label>
                                            <input class="form-control" type="text" id="exam_center"
                                                name="exam_center" placeholder="Exam Center" autofocus="">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="father_email" class="form-label">Roll Number</label>
                                            <input class="form-control" type="number" id="roll_number"
                                                name="roll_number" placeholder="Roll Number" autofocus="">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="father_email" class="form-label">Registration Number<span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="number" required=""
                                                id="registration_number" name="registration_number"
                                                placeholder="Registration Number" autofocus="">
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label for="father_email" class="form-label">Session: </label>
                                            <input class="form-control" type="number" id="session" name="session"
                                                placeholder="Session" autofocus="">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="father_email" class="form-label">Board Name</label>
                                            <input class="form-control" type="text" id="board" name="board"
                                                placeholder="Board Name" autofocus="">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="first_name" class="form-label">Year of passing</label>
                                            <input class="form-control" type="number" id="passing_year"
                                                name="passing_year" placeholder="Year of passing" autofocus="">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="father_email" class="form-label">Result GPA</label>
                                            <input class="form-control" type="number" id="result" name="result"
                                                placeholder="Result GPA" autofocus="">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="first_name" class="form-label">GPA without 4th subject</label>
                                            <input class="form-control" type="number" id="result_fourth_subject"
                                                name="result_fourth_subject" placeholder="GPA without 4th subject"
                                                autofocus="">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="total_mark" class="form-label">Total Marks</label>
                                            <input class="form-control" type="number" id="total_mark" name="total_mark"
                                                placeholder="Total Marks" autofocus="">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="testimonial" class="form-label">SSC Testimonial Of The School
                                                (jpg,jpeg format)</label>
                                            <input class="form-control" type="file" id="testimonial"
                                                onchange="loadFile(event,'testimonial_preview')" name="testimonial">
                                            <img id="testimonial_preview" alt="Testimonial Preview"
                                                style="max-width: 100px; display: none;">
                                            <span style="color: rgb(0,149,221)">(File size max 200 KB)</span>
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="academic_transcript" class="form-label">SSC Academic Transcript
                                                (jpg,jpeg format)<span class="text-danger">*</span></label>
                                            <input class="form-control" type="file"
                                                onchange="loadFile(event,'academic_transcript_preview')"
                                                id="academic_transcript" name="academic_transcript">
                                            <img id="academic_transcript_preview" alt="Academic Transcript Preview"
                                                style="max-width: 100px; display: none;">
                                            <span style="color: rgb(0,149,221)">(File size max 200 KB)</span>

                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label for="academic_transcript" class="form-label">SSC Admit Card
                                                (jpg,jpeg
                                                format)<span class="text-danger">*</span></label>
                                            <input class="form-control" type="file"
                                                onchange="loadFile(event,'admit_card_preview')" id="admit_card"
                                                name="admit_card">
                                            <img id="admit_card_preview" alt="Admit Card Preview"
                                                style="max-width: 100px; display: none;">
                                            <span style="color: rgb(0,149,221)">(File size max 200 KB)</span>
                                        </div>

                                        @if (Auth::user()->is_view_user == 0)
                                            <div class="col-12 d-flex justify-content-between">
                                                <input type="hidden" class="btn btn-warning me-2" name="submit"
                                                    id="submit" value="1">
                                                <button type="button" class="btn btn-primary btn-prev">
                                                    <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                                    <span class="align-middle d-sm-inline-block d-none Previous"
                                                        data-next="force" data-currentdata="address"
                                                        data-target="#social-links">Previous</span>
                                                </button>
                                                <button type="button" class="btn btn-success" id="btn-submit">Submit
                                                    &
                                                    Preview</button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- Address section ends here -->
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /Validation Wizard -->
            </div>
        </div>
        <!-- / Content -->
        <div class="content-backdrop fade"></div>
    </div>
    {{-- Preview student Section --}}
    <div class="modal fade" id="modalScrollable" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <form id="formAdmission" method="POST" action="{{ route('storePreview') }}"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="student_code" value="{{ $student->student_code ?? '' }}" />
                <input type="hidden" name="id" value="{{ $student->id ?? '' }}" />
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalFullTitle" style="margin-left:33%;">BAF SHAHEEN COLLEGE DHAKA
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body" id="studentpreview">

                    </div>
                    <div class="modal-footer" style="text-align: center!important;display: block!important">
                        <button type="button" class="btn btn-outline-secondary btn-success" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="{{ asset('/') }}public/backend/assets/js/ui-modals.js"></script>
    {{-- File Upload Validation --}}
    <script>
        var loadFile = function(event, preview) {

            var sizevalue = (event.target.files[0].size);

            if (sizevalue > 200000) {

                Swal.fire({
                    title: "warning!",
                    text: "File Size Too Large",
                    icon: "warning"
                });
                var idvalue = preview.slice(0, -8);

                $('#' + idvalue).val('');
                return false;
            } else {

                const previewElement = document.getElementById(preview);
                if (previewElement) {
                    const file = event.target.files[0];
                    if (file) {
                        previewElement.src = URL.createObjectURL(file);
                        previewElement.style.display = 'block'; // Show the preview element
                    }
                } else {
                    console.error(`Preview element with ID "${preview}" not found.`);
                }

            }

        };
    </script>
    {{-- Error Message and succes message and warning message --}}
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
    {{-- Functionalities start from here --}}
    <script>
        $(function() {
            @if (Auth::user()->group_id == 4)
                checksection();
            @endif
            $("#formAdmission").submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var actionUrl = form.attr('action');
                $.ajax({
                    type: "POST",
                    url: actionUrl,
                    data: form.serialize(),
                    success: function(data) {
                        // show response from the php script.
                    }
                });
            });
            $(document).on('click', '.edit-icon', function() {
                var forvalue = $(this).data('forvalue');

                $("input[name='" + forvalue + "']").prop('readonly', false);
            });
            // Is service
            $(document).on('change', '#is_service', function() {
                if ($(this).val() == 1) {
                    $("#office_address_div").removeClass('hide').addClass('showinput');
                    $("#office_address").attr('required', true);
                } else {

                    $("#office_address_div").addClass('hide').removeClass('showinput');
                    $("#office_address").removeAttr('required');
                }

            });
            // Special info
            $(document.body).on('click', '.specialinfo', function() {
                var value = $(this).val();
                if (value == 1) {
                    $('#armforce').addClass('hide').removeClass('show');
                    $('#teacherinfo').addClass('hide').removeClass('show');
                    $('#civildata').removeClass('hide').addClass('show');
                    $('#teacherinfo select').removeAttr('required');
                    $('#teacherinfo input').removeAttr('required');
                    $('#armforce input').removeAttr('required');
                    $('#armforce select').removeAttr('required');
                } else if (value == 2) {
                    $('#armforce').removeClass('hide').addClass('show');
                    $('#teacherinfo').addClass('hide').removeClass('show');
                    $('#civildata').addClass('hide').removeClass('show');
                    $('#armforce input').attr('required', true);
                    $('#armforce select').attr('required', true);
                    $('#teacherinfo select').removeAttr('required');
                    $('#teacherinfo input').removeAttr('required');
                    $('#arm_certification_old').removeAttr('required');
                    $('#staff_certification_old').removeAttr('required');
                } else {
                    $('#armforce').addClass('hide').removeClass('show');
                    $('#teacherinfo').removeClass('hide').addClass('show');
                    $('#civildata').addClass('hide').removeClass('show');
                    $('#armforce input').removeAttr('required');
                    $('#armforce select').removeAttr('required');
                    $('#teacherinfo input').attr('required', true);
                    $('#teacherinfo select').attr('required', true);
                    $('#arm_certification_old').removeAttr('required');
                    $('#staff_certification_old').removeAttr('required');
                }
                $('#armforce input').val('');
                $('#teacherinfo input').val('');
            });
            // Btn info
            $(document.body).on('click', '#saveButton', function() {

                var elementId = '';
                $('.active.dstepper-block').each(function() {
                    elementId = $(this).attr('id');
                });

                var currentdata = $(this).data('currentdata');


                var pre = $(this).data('pre');

                var focustext = '';

                // Determine the focus text based on the current data and checked value
                var isValid = true;

                // Check for required fields and handle validation
                $('#' + elementId + ' :input[required]').each(function() {

                    if (!$(this).val()) {
                        $(this).addClass('error').focus();
                        isValid = false;
                        return false; // Exit the .each loop
                    } else {
                        $(this).removeClass('error');
                    }
                });

                if (elementId == 'personal-info') {
                    var group_id = $('#group_id').val();
                    var third_subject = [];
                    var fourth_subject = [];
                    $('.form-check-input.third_subject:checked').each(function() {
                        third_subject.push($(this).val());
                    });

                    $('.form-check-input.fourth_subject:checked').each(function() {
                        fourth_subject.push($(this).val());
                    });
                    var third_subjectcheck = false;
                    var third_subjectcheck3 = false;
                    var fourth_subjectcheck = false;
                    if (group_id == 2) {

                        if (third_subject.length != 3) {

                            third_subjectcheck3 = true;
                        }

                        if (fourth_subject.length != 1) {

                            fourth_subjectcheck == true;
                        }
                    } else {
                        if (third_subject.length != 1) {

                            third_subjectcheck = true;
                        }
                        if (fourth_subject.length != 1) {

                            fourth_subjectcheck == true;
                        }
                    }

                    if (third_subjectcheck3) {
                        Swal.fire({
                            title: "Error",
                            text: "Please choose 3 subject in 'Select 3rd Subject(s)' option",
                            icon: "warning"
                        });
                        return false;
                    }
                    if (third_subjectcheck) {
                        Swal.fire({
                            title: "Error",
                            text: "Please choose 1 subject in 'Select 3rd Subject(s)' option",
                            icon: "warning"
                        });
                        return false;
                    }
                    if (third_subjectcheck) {
                        Swal.fire({
                            title: "Error",
                            text: "Please choose 1 subject in 'Select 3rd Subject(s)' option",
                            icon: "warning"
                        });
                        return false;
                    }
                }

                if (!isValid) {
                    Swal.fire({
                        title: "Error",
                        text: "Asterisk(*) fields need to be completed",
                        icon: "warning"
                    });
                    return false; // Stop further execution
                }


                let studentData = JSON.parse(localStorage.getItem('studentData'));

                console.log(studentData, 'on Save')

                var form = $('#formAdmission')[0];
                var formData = new FormData(form);
                if (studentData) {
                    if (studentData?.student_code) {
                        formData.append('student_code', studentData?.student_code);
                    }
                    formData.append('student_id', studentData?.id);
                }

                var actionUrl = "{{ route('admission.college.save') }}";

                $.LoadingOverlay("show");

                $.ajax({
                    type: "POST",
                    url: actionUrl,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {

                        handleSuccess(data);
                    },
                    error: function(data, errorThrown) {

                        handleError(data, errorThrown);
                    },
                    complete: function() {
                        $.LoadingOverlay("hide");
                    }
                });
            });
            // Just Saving the data
            $(document.body).on('click', '.savebtn', function() {

                $.LoadingOverlay("show");
                var elementId = '';
                $('.active.dstepper-block').each(function() {
                    elementId = $(this).attr('id');
                });

                var currentdata = $(this).data('currentdata');


                var pre = $(this).data('pre');

                var focustext = '';

                // Determine the focus text based on the current data and checked value
                var isValid = true;

                // Check for required fields and handle validation
                $('#' + elementId + ' :input[required]').each(function() {

                    if (!$(this).val()) {
                        $(this).addClass('error').focus();
                        isValid = false;
                        $.LoadingOverlay("hide");
                        return false; // Exit the .each loop
                    } else {
                        $(this).removeClass('error');
                    }
                });

                if (elementId == 'personal-info') {
                    var group_id = $('#group_id').val();
                    var third_subject = [];
                    var fourth_subject = [];
                    $('.form-check-input.third_subject:checked').each(function() {
                        third_subject.push($(this).val());
                    });

                    $('.form-check-input.fourth_subject:checked').each(function() {
                        fourth_subject.push($(this).val());
                    });
                    var third_subjectcheck = false;
                    var third_subjectcheck3 = false;
                    var fourth_subjectcheck = false;
                    if (group_id == 2) {

                        if (third_subject.length != 3) {

                            third_subjectcheck3 = true;
                        }

                        if (fourth_subject.length != 1) {

                            fourth_subjectcheck == true;
                        }
                    } else {
                        if (third_subject.length != 1) {

                            third_subjectcheck = true;
                        }
                        if (fourth_subject.length != 1) {

                            fourth_subjectcheck == true;
                        }
                    }

                    if (third_subjectcheck3) {
                        Swal.fire({
                            title: "Error",
                            text: "Please choose 3 subject in 'Select 3rd Subject(s)' option",
                            icon: "warning"
                        });
                        $.LoadingOverlay("hide");
                        return false;
                    }
                    if (third_subjectcheck) {
                        Swal.fire({
                            title: "Error",
                            text: "Please choose 1 subject in 'Select 3rd Subject(s)' option",
                            icon: "warning"
                        });
                        $.LoadingOverlay("hide");
                        return false;
                    }
                    if (third_subjectcheck) {
                        Swal.fire({
                            title: "Error",
                            text: "Please choose 1 subject in 'Select 3rd Subject(s)' option",
                            icon: "warning"
                        });
                        $.LoadingOverlay("hide");
                        return false;
                    }
                }

                if (!isValid) {
                    Swal.fire({
                        title: "Error",
                        text: "Asterisk(*) fields need to be completed",
                        icon: "warning"
                    });
                    $.LoadingOverlay("hide");
                    return false; // Stop further execution
                }
                $.LoadingOverlay("hide");
            });
            // Headermenu navigation
            $(document.body).on('click', '.headermenu', function() {

                var elementId = '';
                $('.active.dstepper-block').each(function() {

                    elementId = $(this).attr('id');

                });
                var currentdata = $(this).data('currentdata');
                var pre = $(this).data('pre');

                var focustext = '';
                var isValid = true;

                // Check for required fields and handle validation
                $('#' + elementId + ' :input[required]').each(function() {

                    if (!$(this).val()) {
                        $(this).addClass('error').focus();
                        isValid = false;
                        return false; // Exit the .each loop
                    } else {
                        $(this).removeClass('error');
                    }
                });

                if (elementId == 'personal-info') {
                    var group_id = $('#group_id').val();
                    var third_subject = [];
                    var fourth_subject = [];
                    $('.form-check-input.third_subject:checked').each(function() {
                        third_subject.push($(this).val());
                    });

                    $('.form-check-input.fourth_subject:checked').each(function() {
                        fourth_subject.push($(this).val());
                    });
                    var third_subjectcheck = false;
                    var third_subjectcheck3 = false;
                    var fourth_subjectcheck = false;
                    if (group_id == 2) {

                        if (third_subject.length != 3) {

                            third_subjectcheck3 = true;
                        }

                        if (fourth_subject.length != 1) {

                            fourth_subjectcheck == true;
                        }
                    } else {
                        if (third_subject.length != 1) {

                            third_subjectcheck = true;
                        }
                        if (fourth_subject.length != 1) {

                            fourth_subjectcheck == true;
                        }
                    }

                    if (third_subjectcheck3) {
                        Swal.fire({
                            title: "Error",
                            text: "Please choose 3 subject in 'Select 3rd Subject(s)' option",
                            icon: "warning"
                        });
                        return false;
                    }
                    if (third_subjectcheck) {
                        Swal.fire({
                            title: "Error",
                            text: "Please choose 1 subject in 'Select 3rd Subject(s)' option",
                            icon: "warning"
                        });
                        return false;
                    }
                    if (third_subjectcheck) {
                        Swal.fire({
                            title: "Error",
                            text: "Please choose 1 subject in 'Select 3rd Subject(s)' option",
                            icon: "warning"
                        });
                        return false;
                    }
                }

                if (!isValid) {
                    Swal.fire({
                        title: "Error",
                        text: "Asterisk(*) fields need to be completed",
                        icon: "warning"
                    });
                    return false; // Stop further execution
                }
                if (isValid) {
                    $('#formAdmission .content').removeClass('active dstepper-block');
                    $('.step').removeClass('text-bold');
                    $('.bs-stepper-header .step').removeClass('active');
                    $('#' + pre).removeClass('active dstepper-block');
                    // $(this).parent().addClass('active dstepper-block text-bold');
                    $(this).parent().addClass('active dstepper-block');
                    $('#' + currentdata).addClass('active dstepper-block');
                }

            });
            // btn next and nextBtn
            $(document.body).on('click', '#nextButton', function() {

                var boxdata = $(this).data('value');
                var currentdata = $(this).data('currentdata');
                var pre = $(this).data('pre');
                var targetdiv = $(this).data('target');
                var first_name = $('#first_name').val();
                var father_name = $('#father_name').val();
                var mother_name = $('#mother_name').val();
                var birthdate = $('#birthdate').val();
                var religion = $('#religion').val();
                var email = $('#email').val();
                var mobile = $('#mobile').val();
                var gender = $('#gender').val();
                var sms_notification = $('#sms_notification').val();
                var local_guardian_name = $('#local_guardian_name').val();
                var local_guardian_mobile = $('#local_guardian_mobile').val();

                var testimonialElement = $('#testimonial')[0];
                var testimonial = '';

                if (testimonialElement.files.length > 0 && testimonialElement.files[0]?.name) {
                    testimonial = testimonialElement.files[0].name;
                }

                var photoElement = $('#photo')[0];
                var photo = '';

                if (testimonialElement.files.length > 0 && testimonialElement.files[0]?.name) {
                    photo = photoElement.files[0]?.name;
                }

                var photoElement = $('#photo')[0];
                var academic_transcript = '';

                if (testimonialElement.files.length > 0 && testimonialElement.files[0]?.name) {
                    academic_transcript = photoElement.files[0]?.name;
                }

                var academicTranscriptElement = $('#academic_transcript')[0];
                var academic_transcript;

                if (academicTranscriptElement.files.length > 0 && academicTranscriptElement?.files[0]
                    ?.name) {
                    academic_transcript = academicTranscriptElement.files[0]?.name;
                }
                var admit_cardElement = $('#admit_card')[0];
                var admit_card;

                if (admit_cardElement.files.length > 0 && admit_cardElement.files[0]?.name) {
                    admit_card = admit_cardElement.files[0]?.name;
                }
                var currentdata = $(this).data('currentdata');
                var checkedValue = $("input[name='categoryid']:checked").val();
                var focustext = '';

                if (currentdata == 'personal-info') {
                    var group_id = $('#group_id').val();
                    var third_subject = [];
                    var fourth_subject = [];
                    $('.form-check-input.third_subject:checked').each(function() {
                        third_subject.push($(this).val());
                    });

                    $('.form-check-input.fourth_subject:checked').each(function() {
                        fourth_subject.push($(this).val());
                    });
                    var third_subjectcheck = false;
                    var third_subjectcheck3 = false;
                    var fourth_subjectcheck = false;
                    if (group_id == 2) {

                        if (third_subject.length != 3) {

                            third_subjectcheck3 = true;
                        }

                        if (fourth_subject.length != 1) {

                            fourth_subjectcheck == true;
                        }
                    } else {
                        if (third_subject.length != 1) {

                            third_subjectcheck = true;
                        }
                        if (fourth_subject.length != 1) {

                            fourth_subjectcheck == true;
                        }
                    }

                    if (third_subjectcheck3) {
                        Swal.fire({
                            title: "Error",
                            text: "Please choose 3 subject in 'Select 3rd Subject(s)' option",
                            icon: "warning"
                        });
                        return false;
                    }
                    if (third_subjectcheck) {
                        Swal.fire({
                            title: "Error",
                            text: "Please choose 1 subject in 'Select 3rd Subject(s)' option",
                            icon: "warning"
                        });
                        return false;
                    }
                    if (third_subjectcheck) {
                        Swal.fire({
                            title: "Error",
                            text: "Please choose 1 subject in 'Select 3rd Subject(s)' option",
                            icon: "warning"
                        });
                        return false;
                    }
                }

                // Determine the focus text based on the current data and checked value
                if (currentdata == 'address') {
                    if (checkedValue == 2) {
                        focustext = 'armforce';
                    } else if (checkedValue == 3) {
                        focustext = 'teacherinfo';
                    } else {
                        focustext = 'civildata';
                    }
                } else {
                    focustext = currentdata;
                }

                var isValid = true;
                // Check for required fields and handle validation
                $('#' + focustext + ' :input[required]').each(function() {
                    if (!$(this).val()) {
                        $(this).addClass('error').focus();
                        isValid = false;
                        return false;
                    } else {
                        $(this).removeClass('error');
                    }
                });

                if (!isValid) {
                    Swal.fire({
                        title: "Error",
                        text: "Asterisk(*) fields need to be completed",
                        icon: "warning"
                    });
                    return false;
                }

                if (isValid) {

                    let studentData = JSON.parse(localStorage.getItem('studentData'));

                    console.log(studentData, 'on Next')

                    var form = $('#formAdmission')[0];
                    var formData = new FormData(form);

                    if (studentData) {
                        if (studentData.student_code) {
                            formData.append('student_code', studentData?.student_code);
                        }
                        formData.append('student_id', studentData?.id);
                    }

                    var actionUrl = "{{ route('admission.college.save') }}";

                    $.LoadingOverlay("show");

                    $.ajax({
                        type: "POST",
                        url: actionUrl,
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            handleSuccess(data);
                            // Move to next step after successfull request
                            $('#formAdmission .content').removeClass('active dstepper-block');
                            $('.step').removeClass('text-bold');
                            $('.bs-stepper-header .step').removeClass('active');
                            $('#' + boxdata).addClass('active');
                            $('#' + boxdata).first().addClass('text-bold');
                            $(targetdiv).addClass('active dstepper-block');
                        },
                        error: function(data, errorThrown) {

                            handleError(data, errorThrown)

                        },
                        complete: function() {
                            $.LoadingOverlay("hide");
                        }
                    });
                } else {
                    Swal.fire({
                        title: "Error",
                        text: "Asterisk(*) fields need to be completed",
                        icon: "warning"
                    });
                }
            });
            // Next page forwarding
            $(document.body).on('click', '.nextbtn', function() {

                var boxdata = $(this).data('value');
                var currentdata = $(this).data('currentdata');
                var pre = $(this).data('pre');
                var targetdiv = $(this).data('target');
                var first_name = $('#first_name').val();
                var father_name = $('#father_name').val();
                var mother_name = $('#mother_name').val();
                var birthdate = $('#birthdate').val();
                var religion = $('#religion').val();
                var email = $('#email').val();
                var mobile = $('#mobile').val();
                var gender = $('#gender').val();
                var sms_notification = $('#sms_notification').val();
                var local_guardian_name = $('#local_guardian_name').val();
                var local_guardian_mobile = $('#local_guardian_mobile').val();

                var testimonialElement = $('#testimonial')[0];
                var testimonial = '';

                if (testimonialElement.files.length > 0 && testimonialElement.files[0]?.name) {
                    testimonial = testimonialElement.files[0].name;
                }

                var photoElement = $('#photo')[0];
                var photo = '';

                if (testimonialElement.files.length > 0 && testimonialElement.files[0]?.name) {
                    photo = photoElement.files[0]?.name;
                }

                var photoElement = $('#photo')[0];
                var academic_transcript = '';

                if (testimonialElement.files.length > 0 && testimonialElement.files[0]?.name) {
                    academic_transcript = photoElement.files[0]?.name;
                }

                var academicTranscriptElement = $('#academic_transcript')[0];
                var academic_transcript;

                if (academicTranscriptElement.files.length > 0 && academicTranscriptElement?.files[0]
                    ?.name) {
                    academic_transcript = academicTranscriptElement.files[0]?.name;
                }
                var admit_cardElement = $('#admit_card')[0];
                var admit_card;

                if (admit_cardElement.files.length > 0 && admit_cardElement.files[0]?.name) {
                    admit_card = admit_cardElement.files[0]?.name;
                }
                var currentdata = $(this).data('currentdata');
                console.log(currentdata, 'CD');
                var checkedValue = $("input[name='categoryid']:checked").val();
                var focustext = '';

                if (currentdata == 'personal-info') {
                    var group_id = $('#group_id').val();
                    var third_subject = [];
                    var fourth_subject = [];
                    $('.form-check-input.third_subject:checked').each(function() {
                        third_subject.push($(this).val());
                    });

                    $('.form-check-input.fourth_subject:checked').each(function() {
                        fourth_subject.push($(this).val());
                    });
                    var third_subjectcheck = false;
                    var third_subjectcheck3 = false;
                    var fourth_subjectcheck = false;
                    if (group_id == 2) {

                        if (third_subject.length != 3) {

                            third_subjectcheck3 = true;
                        }

                        if (fourth_subject.length != 1) {

                            fourth_subjectcheck == true;
                        }
                    } else {
                        if (third_subject.length != 1) {

                            third_subjectcheck = true;
                        }
                        if (fourth_subject.length != 1) {

                            fourth_subjectcheck == true;
                        }
                    }

                    if (third_subjectcheck3) {
                        Swal.fire({
                            title: "Error",
                            text: "Please choose 3 subject in 'Select 3rd Subject(s)' option",
                            icon: "warning"
                        });
                        return false;
                    }
                    if (third_subjectcheck) {
                        Swal.fire({
                            title: "Error",
                            text: "Please choose 1 subject in 'Select 3rd Subject(s)' option",
                            icon: "warning"
                        });
                        return false;
                    }

                }

                // Determine the focus text based on the current data and checked value
                if (currentdata == 'address') {
                    if (checkedValue == 2) {
                        focustext = 'armforce';
                    } else if (checkedValue == 3) {
                        focustext = 'teacherinfo';
                    } else {
                        focustext = 'civildata';
                    }
                } else {
                    focustext = currentdata;
                }

                var isValid = true;
                // Check for required fields and handle validation
                $('#' + focustext + ' :input[required]').each(function() {
                    if (!$(this).val()) {
                        $(this).addClass('error').focus();
                        isValid = false;
                        return false;
                    } else {
                        $(this).removeClass('error');
                    }
                });

                if (!isValid) {
                    Swal.fire({
                        title: "Error",
                        text: "Asterisk(*) fields need to be completed",
                        icon: "warning"
                    });
                    return false;
                }

                if (isValid) {
                    $.LoadingOverlay("show");
                    // Move to next step after successfull request
                    $('#formAdmission .content').removeClass('active dstepper-block');
                    $('.step').removeClass('text-bold');
                    $('.bs-stepper-header .step').removeClass('active');
                    $('#' + boxdata).addClass('active');
                    $('#' + boxdata).first().addClass('text-bold');
                    $(targetdiv).addClass('active dstepper-block');
                    $.LoadingOverlay("hide");

                } else {
                    Swal.fire({
                        title: "Error",
                        text: "Asterisk(*) fields need to be completed",
                        icon: "warning"
                    });
                }
            });
            // Previous Button
            $(document.body).on('click', '.Previous', function() {
                var elementId = '';
                $('.active.dstepper-block').each(function() {
                    elementId = $(this).attr('id');
                });
                var targetvalue = $(this).data('target');
                var next = $(this).data('next');
                var currentdata = $(this).data('currentdata');


                var isValid = true;

                // $('#' + elementId + ' :input[required]').each(function() {
                //     if (!$(this).val()) {
                //         $(this).addClass('error').focus();
                //         isValid = false;
                //         return false; // Exit the .each loop
                //     } else {
                //         $(this).removeClass('error');
                //     }
                // });
                // if (elementId == 'personal-info') {
                //     var group_id = $('#group_id').val();
                //     var third_subject = [];
                //     var fourth_subject = [];
                //     $('.form-check-input.third_subject:checked').each(function() {
                //         third_subject.push($(this).val());
                //     });

                //     $('.form-check-input.fourth_subject:checked').each(function() {
                //         fourth_subject.push($(this).val());
                //     });
                //     var third_subjectcheck = false;
                //     var third_subjectcheck3 = false;
                //     var fourth_subjectcheck = false;
                //     if (group_id == 2) {

                //         if (third_subject.length != 3) {

                //             third_subjectcheck3 = true;
                //         }

                //         if (fourth_subject.length != 1) {

                //             fourth_subjectcheck == true;
                //         }
                //     } else {
                //         if (third_subject.length != 1) {

                //             third_subjectcheck = true;
                //         }
                //         if (fourth_subject.length != 1) {

                //             fourth_subjectcheck == true;
                //         }
                //     }

                //     if (third_subjectcheck3) {
                //         Swal.fire({
                //             title: "Error",
                //             text: "Please choose 3 subject in 'Select 3rd Subject(s)' option",
                //             icon: "warning"
                //         });
                //         return false;
                //     }
                //     if (third_subjectcheck) {
                //         Swal.fire({
                //             title: "Error",
                //             text: "Please choose 1 subject in 'Select 3rd Subject(s)' option",
                //             icon: "warning"
                //         });
                //         return false;
                //     }
                //     if (third_subjectcheck) {
                //         Swal.fire({
                //             title: "Error",
                //             text: "Please choose 1 subject in 'Select 3rd Subject(s)' option",
                //             icon: "warning"
                //         });
                //         return false;
                //     }
                // }
                // if (!isValid) {
                //     Swal.fire({
                //         title: "Error",
                //         text: "Asterisk(*) fields need to be completed",
                //         icon: "warning"
                //     });
                //     return false; // Stop further execution
                // }

                $('#formAdmission .content').removeClass('active dstepper-block');
                $('.bs-stepper-header .step').removeClass('active');
                $('.step').removeClass('text-bold');

                $('#' + currentdata).removeClass('active dstepper-block').removeClass('crossed');
                $(targetvalue).addClass('active dstepper-block');
                $('#' + next).addClass('active text-bold');
            });
            // Same as checkbox
            $(document.body).on('click', '#same_as', function() {
                if ($('#same_as').is(':checked')) {
                    var present_addr = $('#present_addr').val();
                    var present_police_station = $('#present_police_station').val();
                    var present_district_id = $('#present_district_id').val();

                    $('#permanent_addr').val(present_addr);
                    $('#permanent_police_station').val(present_police_station);
                    $('#permanent_district_id').val(present_district_id);
                    $('#same_as').val(1);
                } else {
                    $('#permanent_addr').val('');
                    $('#permanent_police_station').val('');
                    $('#permanent_district_id').val('');
                    $('#same_as').val(0);
                }
            });
            // Btn Submit
            $(document.body).on('click', '#btn-submit', function() {

                var form = $('#formAdmission')[0];
                var formData = new FormData(form);
                let studentData = JSON.parse(localStorage.getItem('studentData'));

                console.log(studentData, 'on submit')

                if (studentData) {
                    if (studentData.student_code) {
                        formData.append('student_code', studentData?.student_code);
                    }
                    formData.append('student_id', studentData?.id);
                }

                var actionUrl = "{{ route('admission.college.save') }}";
                $.LoadingOverlay("show");
                $.ajax({
                    type: "POST",
                    url: actionUrl,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        showpreview(data);
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
            // Final Submit
            $(document.body).on('click', '#final_submit', function() {
                Swal.fire({
                    title: 'Do you want to Final Submit For Admission?',
                    showDenyButton: true,
                    confirmButtonText: 'Yes',
                    denyButtonText: 'No',
                    customClass: {
                        actions: 'my-actions',
                        cancelButton: 'order-1 right-gap',
                        confirmButton: 'order-2',
                        denyButton: 'order-3',
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        alert('Final Submit')
                        $('#submit').val(2);
                        var btn = document.getElementById('savebuuton');
                        btn.disabled = true;
                        localStorage.removeItem('studentData');
                        localStorage.removeItem('activity');
                        localStorage.removeItem('subject');
                        localStorage.removeItem('group_id');
                        btn.click();

                    } else if (result.isDenied) {

                    }
                })

            });
            // Check Third Subject
            $('.form-check-input.third_subject').change(function() {
                var checkvalue = $(this).val();

                var pair = $(this).data('pair');
                var third_subject = [];
                var third_pair_subject = [];
                var pre_pair = 'na';
                $('.form-check-input.third_subject:checked').each(function() {

                    if (pre_pair == $(this).val()) {
                        $(this).prop("checked", false);
                        Swal.fire({
                            title: "Error",
                            text: "Subject Mismatch",
                            icon: "warning"
                        });
                        return false;
                    } else {
                        pre_pair = $(this).data('pair');
                    }

                    third_subject.push($(this).val());

                });

                var fourth_pair_subject = [];
                var check = 0;
                $('.form-check-input.fourth_subject:checked').each(function() {

                    if ($(this).val() == checkvalue || (checkvalue == '67-68' && $(this).val() ==
                            '82-90')) {
                        Swal.fire({
                            title: "warning",
                            text: "Subject Mismatch",
                            icon: "warning"
                        });
                        $(this).prop("checked", false);
                    } else if (checkvalue == '89-98' && $(this).val() == '73-74') {
                        check = 1;
                    }

                });
                if (check == 1) {
                    $(this).prop("checked", false);
                    Swal.fire({
                        title: "warning",
                        text: "Subject Mismatch",
                        icon: "warning"
                    });
                    return false;
                }
                var fourth_subject = [];
                $('.form-check-input.fourth_subject:checked').each(function() {
                    fourth_subject.push($(this).val());

                });
                console.log(pair, fourth_subject);

                // third to array
                if ($.inArray(pair, fourth_subject) >= 0) {
                    $('.subject' + pair).prop("checked", false);
                    Swal.fire({
                        title: "Error",
                        text: "Subject Mismatch",
                        icon: "warning"
                    });
                    return false;
                }
                $('.form-check-input.third_subject:checked').each(function() {
                    third_subject.push($(this).val());

                });


                var url = "{{ route('checksection') }}";

                var gender = $('#gender').val();
                if (fourth_subject.length > 0 && third_subject.length > 0 && gender != '' && gender !=
                    null) {

                    var class_id = $('#class_id').val();
                    var session_id = $('#session_id').val();
                    var version_id = $('#version_id').val();
                    var group_id = $('#group_id').val();

                    var roll = $('#roll').val();
                    @if (Auth::user()->group_id == 4)
                        $.LoadingOverlay("show");
                        $.ajax({
                            type: "post",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                            },
                            url: url,
                            data: {
                                "_token": "{{ csrf_token() }}",
                                gender,
                                fourth_subject,
                                third_subject,
                                student_code: roll,
                                class_id,
                                session_id,
                                version_id,
                                group_id
                            },
                            success: function(response) {

                                $.LoadingOverlay("hide");

                                $('#section_id').val(response);


                            },
                            error: function(data, errorThrown) {
                                handleError(data, errorThrown);

                            },
                            complete: function() {
                                $.LoadingOverlay("hide");
                            }
                        });
                    @endif
                }
            });
            // Check Fourth Subject
            $('.form-check-input.fourth_subject').change(function() {
                var checkvalue = $(this).val();
                var pair = $(this).data('pair');
                var fourth_subject = [];
                $('.form-check-input.fourth_subject:checked').each(function() {
                    fourth_subject.push($(this).val());

                });

                var check = 0;
                $('.form-check-input.third_subject:checked').each(function() {

                    if ($(this).val() == checkvalue) {
                        Swal.fire({
                            title: "Error",
                            text: "Subject Mismatch",
                            icon: "warning"
                        });
                        $(this).prop("checked", false);
                    } else if (checkvalue == '73-74' && $(this).val() == '89-98') {
                        check = 1;
                    }
                });
                if (check == 1) {
                    $(this).prop("checked", false);
                    Swal.fire({
                        title: "Error",
                        text: "Subject Mismatch",
                        icon: "warning"
                    });
                    return false;
                }
                var third_subject = [];
                $('.form-check-input.third_subject:checked').each(function() {
                    third_subject.push($(this).val());

                });
                // fourth to array
                console.log(pair, third_subject);
                if ($.inArray(pair, third_subject) >= 0) {

                    $('.subject' + pair).prop("checked", false);
                    Swal.fire({
                        title: "Error",
                        text: "Subject Mismatch",
                        icon: "warning"
                    });
                    return false;
                }

                $('.form-check-input.fourth_subject:checked').each(function() {
                    fourth_subject.push($(this).val());

                });
                var gender = $('#gender').val();


                var url = "{{ route('checksection') }}";

                if (fourth_subject.length > 0 && third_subject.length > 0 && gender != '' && gender !=
                    null) {

                    var class_id = $('#class_id').val();
                    var session_id = $('#session_id').val();
                    var version_id = $('#version_id').val();
                    var group_id = $('#group_id').val();
                    var roll = $('#roll').val();
                    @if (Auth::user()->group_id == 4)
                        $.LoadingOverlay("show");
                        $.ajax({
                            type: "post",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                            },
                            url: url,
                            data: {
                                "_token": "{{ csrf_token() }}",
                                gender,
                                fourth_subject,
                                third_subject,
                                student_code: roll,
                                class_id,
                                session_id,
                                version_id,
                                group_id
                            },
                            success: function(response) {

                                $.LoadingOverlay("hide");

                                $('#section_id').val(response);


                            },
                            error: function(data, errorThrown) {
                                handleError(data, errorThrown);

                            },
                            complete: function() {
                                $.LoadingOverlay("hide");
                            }
                        });
                    @endif
                }
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
                            $('#class_code').html(response);
                        },
                        error: function(data, errorThrown) {
                            handleError(data, errorThrown);
                        },
                        complete: function() {
                            $.LoadingOverlay("hide");
                        }
                    });
                }
            });
            $(document.body).on('change', '#class_code', function() {
                var id = $(this).val();
                var shift_id = $('#shift_id').val();
                var version_id = $('#version_id').val();
                var session_id = $('#session_id').val();
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
                        session_id,
                        version_id
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
            @if (isset($student->submit) && $student->submit == 2 && Auth::user()->group_id == 4)
                $(":input:not([type=hidden]),select,textarea").prop("disabled", true);
                $("#photo").prop("disabled", false);
            @endif
        });

        function showpreview(data) {
            var studentcode = data?.student?.student_code || data?.activity?.student_code;
            var url = "{{ route('college.student.preview') }}";
            $.ajax({
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                },
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}",
                    studentcode,
                },
                success: function(response) {
                    $('#modalScrollable').modal('show');
                    $.LoadingOverlay("hide");

                    $('#studentpreview').html(response);

                    localStorage.removeItem('studentData');
                    localStorage.removeItem('activity');
                    localStorage.removeItem('subject');
                    localStorage.removeItem('group_id');
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

        function checksection() {

            var third_subject = [];
            $('.form-check-input.third_subject:checked').each(function() {
                third_subject.push($(this).val());

            });
            var fourth_subject = [];
            $('.form-check-input.fourth_subject:checked').each(function() {
                fourth_subject.push($(this).val());
            });

            var gender = $('#gender').val();
            var url = "{{ route('checksection') }}";
            if (fourth_subject.length > 0 && third_subject.length > 0 && gender != '' && gender != null) {

                var class_id = $('#class_code').val();
                var session_id = $('#session_id').val();
                var version_id = $('#version_id').val();
                var group_id = $('#group_id').val();

                var roll = $('#roll').val();
                $.LoadingOverlay("show");
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        gender,
                        fourth_subject,
                        third_subject,
                        student_code: roll,
                        class_id,
                        session_id,
                        version_id,
                        group_id
                    },
                    success: function(response) {
                        $.LoadingOverlay("hide");
                        $('#section_id').val(response);
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
        }

        // Fetch subject
        function fetchSubjects(groupId, classCode, student_code, session) {
            $.ajax({
                url: "{{ route('fetch.subjects') }}",
                method: 'GET',
                data: {
                    group_id: groupId,
                    class_code: classCode,
                    student_code: student_code,
                    session_id: session,
                },
                success: function(response) {
                    $('#subjects_container').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching subjects:', error);
                }
            });
        }

        // Check Local Storage Data
        function checkLocalstorageData() {

            console.log('Localstorage checking...')
            const storedStudentData = localStorage.getItem('studentData');
            const storedActivityData = localStorage.getItem('activity');
            const storedSubjectData = localStorage.getItem('subject');
            const storedGroupId = localStorage.getItem('group_id');

            if (storedStudentData && storedStudentData !== null && storedStudentData !== undefined) {

                const studentData = JSON.parse(storedStudentData);

                $('#first_name').val(studentData.first_name);
                $('#bangla_name').val(studentData.bangla_name);
                $('#birthdate').val(studentData.birthdate);
                $('#birth_no').val(studentData.birth_no);
                $('#religion').val(studentData.religion);
                $('#nationality').val(studentData.nationality);
                $('#email').val(studentData.email);
                $('#mobile').val(studentData.mobile);
                $('#gender').val(studentData.gender);
                $('#blood').val(studentData.blood);
                $('#father_name').val(studentData.father_name);
                $('#father_email').val(studentData.father_email);
                $('#father_phone').val(studentData.father_phone);
                $('#father_profession').val(studentData.father_profession);
                $('#mother_name').val(studentData.mother_name);
                $('#mother_email').val(studentData.mother_email);
                $('#mother_phone').val(studentData.mother_phone);
                $('#mother_profession').val(studentData.mother_profession);
                $('#father_nid_number').val(studentData.father_nid_number);
                $('#mother_nid_number').val(studentData.mother_nid_number);
                $('#sms_notification').val(studentData.sms_notification);
                $('#parent_income').val(studentData.parent_income);
                $('#present_addr').val(studentData.present_addr);
                $('#present_police_station').val(studentData.present_police_station);
                $('#present_district_id').val(studentData.present_district_id);
                $('#permanent_addr').val(studentData.permanent_addr);
                $('#permanent_police_station').val(studentData.permanent_police_station);
                $('#permanent_district_id').val(studentData.permanent_district_id);
                $('#local_guardian_name').val(studentData.local_guardian_name);
                $('#local_guardian_mobile').val(studentData.local_guardian_mobile);
                $('#local_guardian_email').val(studentData.local_guardian_email);
                $('#student_relation').val(studentData.student_relation);
                $('#local_guardian_address').val(studentData.local_guardian_address);
                $('#local_guardian_police_station').val(studentData.local_guardian_police_station);
                $('#local_guardian_district_id').val(studentData.local_guardian_district_id);
                // Populate form fields with storedSubjectData
                const activity = JSON.parse(localStorage.getItem('activity'));
                var {
                    session
                } = activity?.session_id

                var {
                    student_code
                } = studentData?.student_code

                if (storedGroupId) {
                    $('#group_id').val(storedGroupId).trigger('change');
                    // Fetch subjects for the stored group_id
                    fetchSubjects(storedGroupId, 11, student_code, session);
                }
                const sameAsCheckbox = $('#same_as');
                sameAsCheckbox.prop('checked', studentData?.same_as);
            }
        }
        // Handle group change
        function handleGroupChange() {

            var groupId = $('#group_id').val();
            var classCode = 11;
            var student_code = null;
            var session = null;
            if (groupId) {
                localStorage.setItem('group_id', groupId);
                fetchSubjects(groupId, 11, student_code, session);
            }

        }
        // Handle group change
        function handleCategroyChange() {

            var category = $("input[name='categoryid']:checked").val();
            // Show relevant section based on selected category
            switch (category) {
                case '2': // Son/daughter of Armed Forces' Member
                    $("#armforce").show();
                    break;
                case '1': // Civil
                    $("#civildata").show();
                    break;
                case '3': // Teaching/Non-Teaching staff
                    $("#office_address_div").show();
                    $("#teacherinfo").show();
                    break;
                default: // Teaching/Non-Teaching staff
                    hideAllSections();
            }
        }

        function hideAllSections() {
            $("#armforce, #teacherinfo, #civildata", "#office_address_div").hide();
        }

        // Handle stepper state changes
        function handleClassCodeChange() {
            var class_code = $("#class_code").val();
            switch (class_code) {
                case '0':
                case '1':
                case '2':
                case '3':
                case '4':
                case '5':
                case '6':
                case '7':
                case '8':
                case '9':
                case '10':
                    $("#desiredsubject").hide();
                    $("#desiredsubjectline").hide();
                    $("#sscexamdetails").hide();
                    $("#sscexamdetailsline").hide();
                    $("#dynamicSubmit").show();
                    $("#prevsubmit1").hide();
                    $("#prevsubmit2").hide();
                    $("#prevsubmit3").hide();
                    $("#btn2-desired").show();
                    $("#btn1-desired").hide();
                    break;
                default:
                    showAllSections();
            }
        }

        // Function to show all sections (default behavior)
        function showAllSections() {
            $("#desiredsubject").show();
            $("#desiredsubjectline").show();
            $("#sscexamdetails").show();
            $("#sscexamdetailsline").show();
            $("#dynamicSubmit").hide();
            $("#btn2-desired").hide();
            $("#btn1-desired").show();
            $("#prevsubmit1").show();
            $("#prevsubmit2").show();
            $("#prevsubmit3").show();
        }

        // Function to get student data from the form
        function handleSuccess(response) {
            console.log(response, 'studentData');
            const group_id = $('#group_id').val();

            Swal.fire({
                title: "Success",
                text: "Successfully Saved",
                icon: "success"
            });

            // Store relevant data in localStorage if response is not undefined
            if (response != undefined) {
                const {
                    student,
                    activity,
                    subject
                } = response || {};

                // Check if student, activity, and subject exist before storing them
                if (student) {
                    localStorage.setItem('studentData', JSON.stringify(student));
                } else {
                    console.warn('Student data is missing in response.');
                }

                if (activity) {
                    localStorage.setItem('activity', JSON.stringify(activity));
                } else {
                    console.warn('Activity data is missing in response.');
                }

                if (subject) {
                    localStorage.setItem('subject', JSON.stringify(subject));
                } else {
                    console.warn('Subject data is missing in response.');
                }

                // Store group_id if it's available
                if (group_id) {
                    localStorage.setItem('group_id', group_id);
                }
            } else {
                console.error('Response is undefined or malformed.');
            }
        }
        // Handle error response
        function handleError(data, xhr) {
            const errorMessage = data?.responseJSON?.message || 'An error occurred';
            Swal.fire({
                title: "Error",
                text: errorMessage,
                icon: "warning"
            });
        }

        $(document).ready(function() {
            checkLocalstorageData();
            showAllSections();
            // Listen for changes on the category radio buttons
            $("input[name='categoryid']").change(handleCategroyChange);
            // Trigger the change event on page load to handle the initial state
            $("input[name='categoryid']:checked").trigger("change");

            // Attach change event listener
            $("#class_code").change(handleClassCodeChange);
            // Trigger the change event on page load to handle the initial state
            $("#class_code").trigger("change");

            // Attache change event Listener
            $('#group_id').change(handleGroupChange);
            $("#group_id").trigger("change");
        });
    </script>
@endsection
