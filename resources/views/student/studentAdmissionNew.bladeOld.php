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

.text-bold button span {
    font-weight: bold !important;
    font-size: 18px !important;
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
        /* Set the height of the container */
        overflow-y: auto;
        /* Enable vertical scrolling */
        position: relative;
    }





    .bs-stepper-header {
        position: sticky;
        /* Make the header row sticky */
        top: 0;
        /* Stick the header to the top of the container */
        background-color: #e5e5e5;
        /* Background color for the header */
        margin-left: 10px;
    }


    .justify-content-between {
        position: sticky;
        /* Make the header row sticky */
        bottom: 0;
        /* Stick the header to the top of the container */
        background-color: #e5e5e5;
        /* Background color for the header */
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
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Dashboard/</span> Student Admission Form
        </h4>
        <!-- Default -->
        {{-- @if (isset($studentdata))
                <div class="row">
                    <div class="col-md-12">

                        <div class="card mb-4">
                            <h5 class="card-header">Student Information</h5>
                            <div class="card-body">
                                @foreach ($student as $stu)
                                    <a class="btn btn-primary" href="{{ route('StudentProfile', $student->id) }}">
        {{ $student->student_code . '-' . $student->first_name . ' ' . $student->last_name }}
        </a>
        @endforeach
    </div>
</div>

</div>
</div>
@else --}}
<div class="row">

    <!-- Default Wizard -->

    <!-- /Default Wizard -->
    <!-- Validation Wizard -->
    <div class="col-12 mb-4">
        <div class="bs-stepper wizard-icons wizard-icons-example mt-2">
            <div class="bs-stepper-header">
                <div class="step active text-bold " id="accountdetails">
                    <button type="button" class="step-trigger headermenu" data-currentdata="account-details"
                        data-pre="none" aria-selected="true">

                        <span class="bs-stepper-label">Personal Info</span>
                    </button>
                </div>
                <div class="line">
                    <i class="bx bx-chevron-right"></i>
                </div>
                <div class="step" id="desiredsubject">
                    <button type="button" class="step-trigger headermenu" data-currentdata="personal-info"
                        data-pre="account-details" aria-selected="false">

                        <span class="bs-stepper-label">Subject Selection</span>
                    </button>
                </div>
                <div class="line">
                    <i class="bx bx-chevron-right"></i>
                </div>
                <div class="step" id="sscexamdetails" id="sscexam">
                    <button type="button" class="step-trigger headermenu" data-currentdata="address"
                        data-pre="personal-info" aria-selected="false">

                        <span class="bs-stepper-label">SSC Exam Details</span>
                    </button>
                </div>
                <div class="line">
                    <i class="bx bx-chevron-right"></i>
                </div>
                <div class="step" id="force">
                    <button type="button" class="step-trigger headermenu" data-currentdata="social-links"
                        data-pre="address" aria-selected="false">

                        <span class="bs-stepper-label">Special Information</span>
                    </button>
                </div>
                <div class="line">
                    <i class="bx bx-chevron-right"></i>
                </div>
                <div class="step" id="academicinfo">
                    <button type="button" class="step-trigger headermenu" data-currentdata="review-submit"
                        data-pre="social-links" aria-selected="false">

                        <span class="bs-stepper-label">Admitted Class Info</span>
                    </button>
                </div>

            </div>
            <div class="bs-stepper-content">
                <form id="formAdmission" method="POST" action="{{ route('students.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="student_code" id="student_code"
                        value="{{ $student->student_code ?? '' }}" />
                    <input type="hidden" name="id" id="id" value="{{ $id ?? '' }}" />
                    <!-- Account Details -->
                    <div id="account-details" class="content active dstepper-block">
                        <div class="content-header mb-3">
                            <h6 class="mb-0" style="color: #da45dc;weight: bold;font-size: 16px;font-weight: bold">
                                Student Information</h6>
                            <small class="text-danger">Asterisk(*) fields need to be completed.</small>
                        </div>
                        <div class="row g-3">
                            <div class="mb-3 col-md-6">
                                <label for="first_name" class="form-label">Student's Name (English)<span
                                        class="text-danger">*</span></label>
                                <input class="form-control" type="text" readonly="readonly" id="first_name"
                                    name="first_name" value="{{ $student->first_name ?? '' }}" required
                                    placeholder="Student's Name (English)" autofocus="">

                            </div>
                            <!-- <div class="mb-3 col-md-4">
                                                    <label for="last_name" class="form-label">Last Name</label>
                                                    <input class="form-control" type="text" name="last_name" id="last_name" required placeholder="Last Name" value="{{ $student->last_name ?? '' }}">
                                                </div> -->
                            <div class="mb-3 col-md-6">
                                <label for="last_name" class="form-label">Student's Name (Bangla)</label>
                                <input class="form-control" type="text" name="bangla_name" id="bangla_name"
                                    placeholder="Student's Name (Bangla)" value="{{ $student->bangla_name ?? '' }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="state" class="form-label">Birth Date<span
                                        class="text-danger">*</span></label>
                                <input class="form-control" type="date" id="birthdate" name="birthdate"
                                    placeholder="Birth Date" value="{{ $student->birthdate ?? '' }}">
                                <div class="invalid-feedback">Please enter your Birth Date. </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="state" class="form-label">Birth Registration No</label>
                                <input class="form-control" type="text" id="birth_no" name="birth_no"
                                    placeholder="Birth Registration No" value="{{ $student->birth_no ?? '' }}">

                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="religion" class="form-label">Religion<span
                                        class="text-danger">*</span></label>
                                <select id="religion" name="religion" class=" form-select" required="">
                                    <option value="">Select Religion</option>
                                    <option value="1"
                                        {{ isset($student) && $student->religion == '1' ? 'selected="selected"' : '' }}>
                                        Islam</option>
                                    <option value="2"
                                        {{ isset($student) && $student->religion == '2' ? 'selected="selected"' : '' }}>
                                        Hindu</option>
                                    <option value="3"
                                        {{ isset($student) && $student->religion == '3' ? 'selected="selected"' : '' }}>
                                        christian</option>
                                    <option value="4"
                                        {{ isset($student) && $student->religion == '4' ? 'selected="selected"' : '' }}>
                                        Buddhism</option>
                                    <option value="5"
                                        {{ isset($student) && $student->religion == '5' ? 'selected="selected"' : '' }}>
                                        Others</option>
                                </select>
                                <div class="invalid-feedback">Please select your Religion. </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="nationality" class="form-label">Nationality<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" required id="nationality" name="nationality"
                                    placeholder="Nationality" value="{{ $student->nationality ?? '' }}">
                                <div class="invalid-feedback">Please enter your Nationality. </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">E-mail</label>
                                <input class="form-control" type="text" id="email" name="email"
                                    placeholder="john.doe@example.com" value="{{ $student->email ?? '' }}"
                                    placeholder="john.doe@example.com">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="organization" class="form-label">Mobile<span
                                        class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text">BD (+88)</span>
                                    <input type="number" id="mobile" name="mobile" class="form-control" required
                                        placeholder="01XXXXXXXXX" value="{{ $student->mobile ?? '' }}">
                                </div>
                                <div class="invalid-feedback">Please enter your Mobile. </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="gender" class="form-label">Gender<span class="text-danger">*</span></label>
                                <select id="gender" name="gender" class="form-select" required="">
                                    <option value="">Select Gender</option>
                                    <option value="1"
                                        {{ isset($student) && $student->gender == '1' ? 'selected="selected"' : '' }}>
                                        Male</option>
                                    <option value="2"
                                        {{ isset($student) && $student->gender == '2' ? 'selected="selected"' : '' }}>
                                        Female</option>
                                    <!-- <option value="3" {{ isset($student) && $student->gender == '3' ? 'selected="selected"' : '' }}>Other</option> -->
                                </select>
                                <div class="invalid-feedback">Please select your Gender. </div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="blood" class="form-label">Blood</label>
                                <select id="blood" name="blood" id="blood" class=" form-select">
                                    <option value="">Select Blood</option>
                                    <option value="O+"
                                        {{ isset($student) && $student->blood == 'O+' ? 'selected="selected"' : '' }}>
                                        O+</option>
                                    <option value="O-"
                                        {{ isset($student) && $student->blood == 'O-' ? 'selected="selected"' : '' }}>
                                        O-</option>
                                    <option value="A+"
                                        {{ isset($student) && $student->blood == 'A+' ? 'selected="selected"' : '' }}>
                                        A+</option>
                                    <option value="A-"
                                        {{ isset($student) && $student->blood == 'A-' ? 'selected="selected"' : '' }}>
                                        A-</option>
                                    <option value="B+"
                                        {{ isset($student) && $student->blood == 'B+' ? 'selected="selected"' : '' }}>
                                        B+</option>
                                    <option value="B-"
                                        {{ isset($student) && $student->blood == 'B-' ? 'selected="selected"' : '' }}>
                                        B-</option>
                                    <option value="AB+"
                                        {{ isset($student) && $student->blood == 'AB+' ? 'selected="selected"' : '' }}>
                                        AB+</option>
                                    <option value="AB-"
                                        {{ isset($student) && $student->blood == 'AB-' ? 'selected="selected"' : '' }}>
                                        AB-</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="first_name" class="form-label">Father's Name<span
                                        class="text-danger">*</span></label>
                                <input class="form-control" required="" type="text" id="father_name" name="father_name"
                                    placeholder="Father's Name" value="{{ $student->father_name ?? '' }}" autofocus="">
                                <div class="invalid-feedback">Please enter your Father's Name. </div>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="father_email" class="form-label">Father's Email</label>
                                <input class="form-control" type="text" id="father_email" name="father_email"
                                    placeholder="Father's Email" value="{{ $student->father_email ?? '' }}"
                                    autofocus="">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="father_phone" class="form-label">Father's Contact
                                    Number</label>
                                <input class="form-control" type="number" id="father_phone" name="father_phone"
                                    placeholder="Father's Phone" value="{{ $student->father_phone ?? '' }}"
                                    autofocus="">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="father_profession" class="form-label">Father's
                                    Profession</label>
                                <input class="form-control" type="text" id="father_profession" name="father_profession"
                                    placeholder="Father's Profession" value="{{ $student->father_profession ?? '' }}"
                                    autofocus="">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="mother_name" class="form-label">Mother's Name<span
                                        class="text-danger">*</span></label>
                                <input class="form-control" required="" type="text" name="mother_name" id="mother_name"
                                    placeholder="Mother's Name" value="{{ $student->mother_name ?? '' }}">
                                <div class="invalid-feedback">Please enter your Mother's Name. </div>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="mother_email" class="form-label">Mother's Email</label>
                                <input class="form-control" type="text" name="mother_email" id="mother_email"
                                    placeholder="Mother's Email" value="{{ $student->mother_email ?? '' }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="mother_phone" class="form-label">Mother's Contact
                                    Number</label>
                                <input class="form-control" type="number" name="mother_phone" id="mother_phone"
                                    placeholder="Mother's Phone" value="{{ $student->mother_phone ?? '' }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="mother_profession" class="form-label">Mother's
                                    Profession</label>
                                <input class="form-control" type="text" name="mother_profession" id="mother_profession"
                                    placeholder="Mother Profession" value="{{ $student->mother_profession ?? '' }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="mother_profession" class="form-label">Father's NID
                                    Number</label>
                                <input class="form-control" type="number" name="father_nid_number"
                                    id="father_nid_number" placeholder="Father's NID Number"
                                    value="{{ $student->father_nid_number ?? '' }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="mother_profession" class="form-label">Mother's NID
                                    Number</label>
                                <input class="form-control" type="number" name="mother_nid_number"
                                    id="mother_nid_number" placeholder="Mother's NID Number"
                                    value="{{ $student->mother_nid_number ?? '' }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="father_nid" class="form-label">Father's NID (jpg,jpeg,png
                                    format)</label>
                                <input class="form-control" type="file" onchange="loadFile(event,'father_nid_preview')"
                                    id="father_nid" name="father_nid">
                                <span style="color: rgb(0,149,221)">(File size max 200 KB)</span>
                                <input class="form-control" type="hidden" id="father_nid_old"
                                    value="{{ $student->father_nid ?? '' }}" name="father_nid_old">
                                <div class="mb-3 col-md-12">
                                    <img src="{{ $student->father_nid ?? '' }}" id="father_nid_preview"
                                        style="height: 100px; width: auto" />
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="mother_nid" class="form-label">Mother's NID (jpg,jpeg,png
                                    format)</label>
                                <input class="form-control" type="file" onchange="loadFile(event,'mother_nid_preview')"
                                    id="mother_nid" name="mother_nid">
                                <span style="color: rgb(0,149,221)">(File size max 200 KB)</span>
                                <input class="form-control" type="hidden" id="mother_nid_old"
                                    value="{{ $student->mother_nid ?? '' }}" name="mother_nid_old">
                                <div class="mb-3 col-md-12">
                                    <img src="{{ $student->mother_nid ?? '' }}" id="mother_nid_preview"
                                        style="height: 100px; width: auto" />
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="sms_notification" class="form-label">SMS Notification <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" type="number" name="sms_notification" required="required"
                                    id="sms_notification" placeholder="SMS Notification"
                                    value="{{ $student->sms_notification ?? '' }}">
                                <div class="invalid-feedback">Please enter your SMS Notification Number.
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="parent_income" class="form-label">Parent's Annual
                                    Income</label>
                                <input class="form-control" type="text" name="parent_income" id="parent_income"
                                    placeholder="Parent's Annual Income" value="{{ $student->parent_income ?? '' }}">
                            </div>

                            <div class="mb-3 col-md-12">
                                <p style="color: rgb(0,149,221)">Address:</p>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="present_addr" class="form-label">Present Address</label>
                                <input type="text" id="present_addr" name="present_addr" class="form-control"
                                    placeholder="Present Address" value="{{ $student->present_addr ?? '' }}">

                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="present_police_station" class="form-label">Present Police
                                    Station</label>
                                <input type="text" id="present_police_station" name="present_police_station"
                                    class="form-control" placeholder="Present Police Station"
                                    value="{{ $student->present_police_station ?? '' }}">

                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="present_district_id" class="form-label">Present
                                    District</label>
                                <select id="present_district_id" name="present_district_id" id="present_district_id"
                                    class=" form-select">
                                    <option value="">Select District</option>
                                    @foreach ($districts as $district)
                                    <option value="{{ $district->id }}"
                                        {{ isset($student) && $student->permanent_district_id == $district->id ? 'selected="selected"' : '' }}>
                                        {{ $district->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <div class="demo-inline-spacing">
                                    <label class="form-check m-0">
                                        <input type="checkbox" class="form-check-input"
                                            {{ isset($student) && $student->same_as == '1' ? 'checked="checked"' : '' }}
                                            id="same_as" name="same_as" value="1">
                                        <span class="form-check-label">SAME AS PRESENT ADDRESS</span>
                                    </label>


                                </div>
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="permanent_addr" class="form-label">Permanent Address</label>
                                <input type="text" id="permanent_addr" name="permanent_addr" class="form-control"
                                    placeholder="Permanent Address" value="{{ $student->permanent_addr ?? '' }}">

                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="permanent_police_station" class="form-label">Permanent Police
                                    Station</label>
                                <input type="text" id="permanent_police_station" name="permanent_police_station"
                                    class="form-control" placeholder="Permanent Police Station"
                                    value="{{ $student->permanent_police_station ?? '' }}">

                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="permanent_district_id" class="form-label">Permanent
                                    District</label>
                                <select id="permanent_district_id" name="permanent_district_id"
                                    id="permanent_district_id" class=" form-select">
                                    <option value="">Select District</option>
                                    @foreach ($districts as $district)
                                    <option value="{{ $district->id }}"
                                        {{ isset($student) && $student->permanent_district_id == $district->id ? 'selected="selected"' : '' }}>
                                        {{ $district->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-12">
                                <p style="color: rgb(0,149,221)">Local Guardian (Father/Mother/Relative):
                                </p>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="local_guardian_name" class="form-label">Local Guardian
                                    Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" required="" id="local_guardian_name"
                                    name="local_guardian_name" placeholder="Guardian Name"
                                    value="{{ $student->local_guardian_name ?? '' }}">
                                <div class="invalid-feedback">Please enter your Guardian Name. </div>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="guardian_name" class="form-label">Local Guardian Mobile<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" required="" id="local_guardian_mobile"
                                    name="local_guardian_mobile" placeholder="Guardian Mobile"
                                    value="{{ $student->local_guardian_mobile ?? '' }}">
                                <div class="invalid-feedback">Please enter your Guardian Mobile. </div>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="guardian_email" class="form-label">Local Guardian
                                    Email</label>
                                <input type="text" class="form-control" id="local_guardian_email"
                                    name="local_guardian_email" placeholder="Guardian Email"
                                    value="{{ $student->local_guardian_email ?? '' }}">

                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="student_relation" class="form-label">Relation with
                                    Student<span class="text-danger">*</span></label>
                                <input type="text" id="student_relation" required="" name="student_relation"
                                    class="form-control" placeholder="Relation With student"
                                    value="{{ $student->student_relation ?? '' }}">
                                <div class="invalid-feedback">Please enter your Guardian Name. </div>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="local_guardian_address" class="form-label">Local Guardian
                                    Address</label>
                                <input type="text" id="local_guardian_address" name="local_guardian_address"
                                    class="form-control" placeholder="Local guardian Address"
                                    value="{{ $student->local_guardian_addr ?? '' }}">

                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="local_guardian_police_station" class="form-label">Local Police
                                    Station</label>
                                <input type="text" id="local_guardian_police_station"
                                    name="local_guardian_police_station" class="form-control"
                                    placeholder="Local guardian Police Station"
                                    value="{{ $student->local_guardian_police_station ?? '' }}">

                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="local_guardian_district_id" class="form-label">Local guardian
                                    District</label>
                                <select id="local_guardian_district_id" name="local_guardian_district_id"
                                    id="local_permanent_district_id" class=" form-select">
                                    <option value="">Select District</option>
                                    @foreach ($districts as $district)
                                    <option value="{{ $district->id }}"
                                        {{ isset($student) && $student->local_guardian_district_id == $district->id ? 'selected="selected"' : '' }}>
                                        {{ $district->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="photo" class="form-label">Student's Recent Passport Size
                                    Photo (jpg,jpeg,png format)<span class="text-danger">*</span></label>
                                <input class="form-control" type="file" id="photo"
                                    onchange="loadFile(event,'photo_preview')" name="photo"
                                    {{ !empty($student->photo) ? '' : 'required=""' }}>
                                <span style="color: rgb(0,149,221)">(File size max 200 KB)</span>
                                <input class="form-control" type="hidden" id="photo_old"
                                    value="{{ $student->photo ?? '' }}" name="photo_old">

                                <div class="mb-3 col-md-12">
                                    <img src="{{ $student->photo ?? '' }}" id="photo_preview"
                                        style="height: 100px; width: auto" />
                                </div>
                                <div class="invalid-feedback">Please choose your Student's Photo. </div>
                            </div>


                            <div class="mb-3 col-md-6">
                                <label for="academic_transcript" class="form-label">BIRTH Certificate
                                    (jpg,jpeg,png format)</label>
                                <input class="form-control" type="file"
                                    onchange="loadFile(event,'birth_certificate_preview')" id="birth_certificate"
                                    name="birth_certificate">
                                <span style="color: rgb(0,149,221)">(File size max 200 KB)</span>
                                <input class="form-control" type="hidden" id="birth_certificate_old"
                                    value="{{ $student->birth_certificate ?? '' }}" name="birth_certificate_old">
                                <div class="mb-3 col-md-12">
                                    <img src="{{ $student->birth_certificate ?? '' }}" id="birth_certificate_preview"
                                        style="height: 100px; width: 100px;" />
                                </div>
                            </div>
                            @if ($student->submit != 2)
                            <div class="col-12 d-flex justify-content-between">
                                <button class="btn btn-label-secondary btn-prev" disabled="">
                                    <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                    <span class="align-middle d-sm-inline-block d-none Previous">Previous</span>
                                </button>
                                <button style="margin-left: 60%;" type="button" data-value="desiredsubject"
                                    data-pre="accountdetails" data-target="#personal-info" class="btn btn-info">
                                    <span class="align-right d-sm-inline-block d-none me-sm-1">Save</span>
                                </button>
                                <button type="button" data-value="desiredsubject" data-currentdata="account-details"
                                    data-pre="accountdetails" data-target="#personal-info"
                                    class="btn btn-primary nextbtn">
                                    <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                    <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                </button>
                            </div>
                            @else
                            <div class="col-12 d-flex justify-content-between">
                                <a href="{{ url('admin/studentPrint/' . $student->student_code) }}"
                                    class="btn btn-outline-primary" target="_blank">Print</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!-- Personal Info -->
                    <div id="personal-info" class="content">
                        <div class="content-header mb-3">
                            <h6 class="mb-0" style="color: #da45dc;font-weight: bold;font-size: 16px;">
                                Desired Subject</h6>
                            <small>According ot the college prospectus</small>
                        </div>
                        <div class="row g-3">
                            <div class="mb-3 col-md-6">
                                <div class="col-md">
                                    @php
                                    $colors = [
                                    'primary',
                                    'secondary',
                                    'success',
                                    'danger',
                                    'warning',
                                    'info',
                                    'primary',
                                    'secondary',
                                    'success',
                                    'danger',
                                    'warning',
                                    'info',
                                    'primary',
                                    'secondary',
                                    'success',
                                    'danger',
                                    'warning',
                                    'info',
                                    'primary',
                                    'secondary',
                                    'success',
                                    'danger',
                                    'warning',
                                    'info',
                                    'primary',
                                    'secondary',
                                    'success',
                                    'danger',
                                    'warning',
                                    'info',
                                    ];
                                    $i = 0;
                                    @endphp
                                    <label for="disabledRange" class="form-label" style="font-weight: bold">Compulsory
                                        Subjects</label>
                                    @foreach ($comsubjects as $key => $subject)
                                    @php
                                    $ids = '';
                                    foreach ($subject as $kye => $sub) {
                                    if ($kye == 0) {
                                    $ids = $sub->id;
                                    } else {
                                    $ids = $ids . '-' . $sub->id;
                                    }
                                    }

                                    @endphp
                                    <input type="hidden" name="mainsubject[]" value="{{ $ids }}">
                                    <div class="form-check form-check-{{ $colors[0] }} ">
                                        <input class="form-check-input" type="radio" value="{{ $ids }}"
                                            id="customRadioPrimary" checked="">
                                        <label class="form-check-label" for="customRadio{{ $colors[0] }}"> {{ $key }}
                                        </label>
                                    </div>
                                    @endforeach
                                    @if ($activity->group_id != 2)
                                    <label for="disabledRange" class="form-label" style="font-weight: bold">Group
                                        Subjects</label>
                                    @foreach ($groupsubjects as $key => $subject)
                                    @php
                                    $ids = '';
                                    foreach ($subject as $kye => $sub) {
                                    if ($kye == 0) {
                                    $ids = $sub->id;
                                    } else {
                                    $ids = $ids . '-' . $sub->id;
                                    }
                                    }

                                    @endphp
                                    <input type="hidden" name="mainsubject[]" value="{{ $ids }}">
                                    <div class="form-check form-check-{{ $colors[4] }} ">
                                        <input class="form-check-input" type="radio" value="{{ $ids }}"
                                            id="customRadioPrimary" checked="">
                                        <label class="form-check-label" for="customRadio{{ $colors[4] }}">
                                            {{ $key }} </label>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <span style="font-size: .80rem;font-weight: bold;">Select 3rd
                                    Subject(s)</span>
                                @foreach ($optionalsubjects as $key => $subject)
                                @php
                                $ids = [];
                                $pair = [];
                                foreach ($subject as $kye => $sub) {
                                if ($kye == 0) {
                                $ids[0] = $sub->id;
                                $pair[0] = $sub->pair;
                                } else {
                                $ids[1] = $sub->id;
                                $pair[1] = $sub->pair;
                                }
                                }

                                if ($pair) {
                                sort($pair);
                                $pair = implode('-', $pair);
                                }
                                if ($ids) {
                                sort($ids);
                                $ids = implode('-', $ids);
                                }

                                if (isset($activity) && in_array($activity->group_id, [1, 3])) {
                                $text = 'radio';
                                } else {
                                $text = 'checkbox';
                                }

                                if (isset($student_third_subject[$key])) {
                                $checked = 'checked="checked"';
                                } else {
                                $checked = '';
                                }
                                @endphp
                                <div class="form-check form-check-{{ $colors[2] }} ">
                                    <input class="form-check-input third_subject subject{{ $pair }}" type="{{ $text }}"
                                        name="third_subject[]" data-pair="{{ $pair }}" value="{{ $ids }}"
                                        id="customRadio{{ $colors[$i] }}" {{ $checked }}>
                                    <label class="form-check-label" for="customRadio{{ $colors[2] }}">
                                        {{ $key }}
                                    </label>
                                </div>
                                @endforeach
                                <span style="font-size: .80rem;font-weight: bold;">Select 4th
                                    Subject</span>
                                @php
                                $pre_pair1 = '';
                                $pre_pair2 = '';
                                @endphp
                                @foreach ($fourthsubjects as $key => $subject)
                                @php

                                $ids = [];
                                $pair = [];
                                foreach ($subject as $kye => $sub) {
                                if ($kye == 0) {
                                $pre_pair1 = $sub->id;
                                $ids[0] = $sub->id;
                                $pair[0] = $sub->pair;
                                } else {
                                $pre_pair2 = $sub->id;
                                $ids[1] = $sub->id;
                                $pair[1] = $sub->pair;
                                }
                                }

                                if ($pair) {
                                sort($pair);
                                $pair = implode('-', $pair);
                                }
                                if ($ids) {
                                sort($ids);
                                $ids = implode('-', $ids);
                                }
                                if (isset($student_fourth_subject[$key])) {
                                $checked = 'checked="checked"';
                                } else {
                                $checked = '';
                                }
                                @endphp
                                <div class="form-check form-check-{{ $colors[3] }} ">
                                    <input class="form-check-input fourth_subject subject{{ $pair }}" type="radio"
                                        name="fourth_subject[]" value="{{ $ids }}" data-pair="{{ $pair }}"
                                        id="subject{{ $colors[$i] }}" {{ $checked }}>
                                    <label class="form-check-label" for="subject{{ $colors[3] }}">
                                        {{ $key }} </label>
                                </div>
                                @endforeach
                            </div>
                            <div class="mb-3 col-md-2">
                            </div>
                            @if ($activity->group_id == 1)
                            <div class="mb-3 col-md-10">
                                <label for="first_name" class="form-label bn-node">N.B.</label><br>
                                <label for="first_name" class="form-label nb">* If 3rd subject is
                                    Biology, EDS cannot be taken as the 4th subject</label><br>
                                @if ($activity->version_id == 1)
                                <label for="first_name" class="form-label nb">* If 3rd subject is
                                    Higher Math, Psychology cannot be taken as the 4th
                                    subject</label><br>
                                @endif
                                <label for="first_name" class="form-label nb">* If 3rd subject is
                                    Biology, Statistics cannot be taken as the 4th subject</label><br>
                            </div>
                            @elseif($activity->group_id == 2)
                            <div class="mb-3 col-md-10">
                                <label for="first_name" class="form-label bn-node">N.B.</label><br>
                                <label for="first_name" class="form-label nb">* ৩য় বিষয় হিসেবে
                                    IHC/ECO, GEO/LOGIC এবং CGG/SW থেকে ৩টি বিষয় নির্বাচন করতে
                                    হবে।</label><br>
                                <label for="first_name" class="form-label nb">* ৩য় বিষয় হিসেবে LOGIC
                                    নির্বাচন করলে ৪র্থ বিষয় হিসেবে Agri নির্বাচন করা যাবে না।</label>
                            </div>
                            @endif

                            <div class="col-12 d-flex justify-content-between">
                                <button type="button" class="btn btn-primary btn-prev">
                                    <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                    <span class="align-middle d-sm-inline-block d-none Previous"
                                        data-next="accountdetails" data-currentdata="personal-info"
                                        data-target="#account-details">Previous</span>
                                </button>
                                <button style="margin-left: 60%;" type="button" data-value="desiredsubject"
                                    data-pre="accountdetails" data-target="#personal-info" class="btn btn-info">
                                    <span class="align-right d-sm-inline-block d-none me-sm-1">Save</span>
                                </button>
                                <button type="button" data-value="sscexamdetails" data-currentdata="personal-info"
                                    data-pre="desiredsubject" data-target="#address" class="btn btn-primary btn-next">
                                    <span class="align-middle d-sm-inline-block d-none me-sm-1">
                                        Next</span>
                                    <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                </button>
                            </div>

                        </div>
                    </div>
                    <!-- Address -->
                    <div id="address" class="content">
                        <div class="content-header mb-3">
                            <h6 class="mb-0" style="color: #da45dc;font-weight: bold;font-size: 16px;">
                                Secondary (SSC) Exam details</h6>
                            <small></small>
                        </div>
                        <div class="row g-3">
                            <div class="mb-3 col-md-6">
                                <label for="first_name" class="form-label">Name Of School</label>
                                <input class="form-control" type="text" id="school_name" name="school_name"
                                    placeholder="Name Of School" value="{{ $student->school_name ?? '' }}" autofocus="">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="father_email" class="form-label">Upozila/Thana</label>
                                <input class="form-control" type="text" id="thana" name="thana"
                                    placeholder="Upozila/Thana" value="{{ $student->thana ?? '' }}" autofocus="">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="first_name" class="form-label">Exam Center</label>
                                <input class="form-control" type="text" id="exam_center" name="exam_center"
                                    placeholder="Exam Center" value="{{ $student->exam_center ?? '' }}" autofocus="">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="father_email" class="form-label">Roll Number</label>
                                <input class="form-control" type="number" id="roll_number" name="roll_number"
                                    placeholder="Roll Number" value="{{ $student->roll_number ?? '' }}" autofocus="">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="father_email" class="form-label">Registration Number<span
                                        class="text-danger">*</span></label>
                                <input class="form-control" type="number" required="" id="registration_number"
                                    name="registration_number" placeholder="Registration Number"
                                    value="{{ $student->registration_number ?? '' }}" autofocus="">
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="father_email" class="form-label">Session: </label>
                                <input class="form-control" type="number" id="session" name="session"
                                    placeholder="Session" value="{{ $student->session ?? '' }}" autofocus="">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="father_email" class="form-label">Board Name</label>
                                <input class="form-control" type="text" id="board" name="board" placeholder="Board Name"
                                    value="{{ $student->board ?? '' }}" autofocus="">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="first_name" class="form-label">Year of passing</label>
                                <input class="form-control" type="number" id="passing_year" name="passing_year"
                                    placeholder="Year of passing" value="{{ $student->passing_year ?? '' }}"
                                    autofocus="">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="father_email" class="form-label">Result GPA</label>
                                <input class="form-control" type="number" id="result" name="result"
                                    placeholder="Result GPA" value="{{ $student->result ?? '' }}" autofocus="">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="first_name" class="form-label">GPA without 4th subject</label>
                                <input class="form-control" type="number" id="result_fourth_subject"
                                    name="result_fourth_subject" placeholder="GPA without 4th subject"
                                    value="{{ $student->result_fourth_subject ?? '' }}" autofocus="">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="total_mark" class="form-label">Total Marks</label>
                                <input class="form-control" type="number" id="total_mark" name="total_mark"
                                    placeholder="Total Marks" value="{{ $student->total_mark ?? '' }}" autofocus="">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="testimonial" class="form-label">SSC Testimonial Of The School
                                    (jpg,jpeg,png format)</label>
                                <input class="form-control" type="file" id="testimonial"
                                    onchange="loadFile(event,'testimonial_preview')" name="testimonial">
                                <span style="color: rgb(0,149,221)">(File size max 200 KB)</span>
                                <input class="form-control" type="hidden" id="testimonial_old"
                                    value="{{ $student->testimonial ?? '' }}" name="testimonial_old">
                                <div class="mb-3 col-md-12">
                                    <img src="{{ $student->testimonial ?? '' }}" id="testimonial_preview"
                                        style="height: 100px; width: 100px;" />
                                </div>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="academic_transcript" class="form-label">SSC Academic
                                    Transcript (jpg,jpeg,png format)<span class="text-danger">*</span></label>
                                <input class="form-control" type="file"
                                    onchange="loadFile(event,'academic_transcript_preview')" id="academic_transcript"
                                    {{ !empty($student->academic_transcript) ? '' : 'required=""' }}
                                    name="academic_transcript">
                                <span style="color: rgb(0,149,221)">(File size max 200 KB)</span>
                                <input class="form-control" type="hidden" id="academic_transcript_old"
                                    value="{{ $student->academic_transcript ?? '' }}" name="academic_transcript_old">
                                <div class="mb-3 col-md-12">
                                    <img src="{{ $student->academic_transcript ?? '' }}"
                                        id="academic_transcript_preview" style="height: 100px; width: 100px;" />
                                </div>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="academic_transcript" class="form-label">SSC Admit Card
                                    (jpg,jpeg,png format)<span class="text-danger">*</span></label>
                                <input class="form-control" type="file" onchange="loadFile(event,'admit_card_preview')"
                                    {{ !empty($student->admit_card) ? '' : 'required=""' }} id="admit_card"
                                    name="admit_card">
                                <span style="color: rgb(0,149,221)">(File size max 200 KB)</span>
                                <input class="form-control" type="hidden" id="admit_card_old"
                                    value="{{ $student->admit_card ?? '' }}" name="admit_card_old">
                                <div class="mb-3 col-md-12">
                                    <img src="{{ $student->admit_card ?? '' }}" id="admit_card_preview"
                                        style="height: 100px; width: 100px;" />
                                </div>
                            </div>

                            <div class="col-12 d-flex justify-content-between">
                                <button type="button" class="btn btn-primary btn-prev">
                                    <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                    <span class="align-middle d-sm-inline-block d-none Previous"
                                        data-next="desiredsubject" data-currentdata="address"
                                        data-target="#personal-info">Previous</span>
                                </button>
                                <button style="margin-left: 60%;" type="button" data-value="desiredsubject"
                                    data-pre="accountdetails" data-target="#personal-info" class="btn btn-info">
                                    <span class="align-right d-sm-inline-block d-none me-sm-1">Save</span>
                                </button>
                                <button type="button" data-value="force" data-currentdata="personal-info"
                                    data-pre="sscexamdetails" data-target="#social-links"
                                    class="btn btn-primary btn-next">
                                    <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                    <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                </button>
                            </div>

                        </div>
                    </div>
                    <!-- Social Links -->

                    <div id="social-links" class="content">
                        <div class="content-header mb-3" id="armedforce">
                            <h6 class="mb-0" style="color: #da45dc;font-weight: bold;font-size: 19px;">
                                Select Your Category</h6>
                            <div class="col-md">
                                <div class="form-check mt-3">
                                    <input name="categoryid" class="form-check-input specialinfo"
                                        {{ isset($student) && $student->categoryid == 1 ? 'checked="checked"' : '' }}
                                        type="radio" value="1" id="defaultRadio1">
                                    <label class="form-check-label" for="defaultRadio1">
                                        Civil
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input name="categoryid" class="form-check-input specialinfo" type="radio"
                                        {{ isset($student) && $student->categoryid == 2 ? 'checked="checked"' : '' }}
                                        value="2" id="defaultRadio2">
                                    <label class="form-check-label" for="defaultRadio2">
                                        Son/daughter of Armed Forces' Member
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input specialinfo" name="categoryid" type="radio"
                                        {{ isset($student) && $student->categoryid == 3 ? 'checked="checked"' : '' }}
                                        value="3" id="disabledRadio3">
                                    <label class="form-check-label" for="disabledRadio3">
                                        Son/daughter of Teaching/Non-Teaching staff of BAFSD
                                    </label>
                                </div>

                            </div>

                        </div>
                        <div class="row g-3  {{ isset($student) && $student->categoryid == 2 ? 'show' : 'hide' }}"
                            id="armforce">
                            <div class="mb-3 col-md-4">
                                <label for="guardian_email" class="form-label">Name of service Holder<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control"
                                    {{ isset($student) && $student->categoryid == 2 ? 'required' : '' }} id="name"
                                    name="name" placeholder="Name of service holder" value="{{ $student->name ?? '' }}">
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="guardian_name" class="form-label">Rank/Designation<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control"
                                    {{ isset($student) && $student->categoryid == 2 ? 'required' : '' }}
                                    id="designation" name="designation" placeholder="Rank/Designation"
                                    value="{{ $student->designation ?? '' }}">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="local_guardian_name" class="form-label">Service number<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control"
                                    {{ isset($student) && $student->categoryid == 2 ? 'required' : '' }}
                                    id="service_number" name="service_number" placeholder="Service number"
                                    value="{{ $student->service_number ?? '' }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="guardian_name" class="form-label">Name of Service<span
                                        class="text-danger">*</span></label>
                                <select id="arms_name" name="arms_name"
                                    {{ isset($student) && $student->categoryid == 2 ? 'required' : '' }}
                                    class=" form-select">
                                    <option value="">Select Option</option>
                                    <option
                                        {{ isset($student) && $student->arms_name == 'Air Force' ? 'selected="selected"' : '' }}
                                        value="Air Force">Air Force</option>
                                    <option
                                        {{ isset($student) && $student->arms_name == 'Army' ? 'selected="selected"' : '' }}
                                        value="Army">Army</option>
                                    <option
                                        {{ isset($student) && $student->arms_name == 'Navy' ? 'selected="selected"' : '' }}
                                        value="Navy">Navy</option>

                                </select>

                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="guardian_email" class="form-label">In service<span
                                        class="text-danger">*</span></label>
                                <select id="is_service" name="is_service"
                                    {{ isset($student) && $student->categoryid == 2 ? 'required' : '' }}
                                    class=" form-select">
                                    <option value="">Select Option</option>
                                    <option
                                        {{ isset($student) && $student->is_service == 1 ? 'selected="selected"' : '' }}
                                        value="1">Yes</option>
                                    <option
                                        {{ isset($student) && $student->is_service == 2 ? 'selected="selected"' : '' }}
                                        value="2">No</option>


                                </select>
                            </div>
                            @php
                            if (
                            isset($student) &&
                            $student->categoryid == 2 &&
                            $student->is_service == 2
                            ) {
                            $requird = '';
                            } elseif (isset($student) && $student->categoryid == 1) {
                            $requird = '';
                            } elseif (isset($student) && $student->categoryid == 3) {
                            $requird = '';
                            } elseif (
                            isset($student) &&
                            $student->categoryid == 2 &&
                            $student->is_service == 1
                            ) {
                            $requird = 'required';
                            } else {
                            $requird = '';
                            }

                            @endphp
                            <div class="mb-3 col-md-6 {{ $requird == 'required' ? 'showinput' : 'hide' }}"
                                id="office_address_div">
                                <label for="guardian_email" class="form-label">Present office Address<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="office_address" {{ $requird }}
                                    name="office_address" placeholder="Office Address"
                                    value="{{ $student->office_address ?? '' }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="arm_certification" class="form-label">Certification/Testimonial
                                    from office (jpg,jpeg,png
                                    format)<span class="text-danger">*</span></label>
                                <input class="form-control" type="file"
                                    onchange="loadFile(event,'arm_certification_preview')"
                                    {{ isset($student) && $student->categoryid == 2 && $student->arm_certification == '' && $student->arm_certification == null ? 'required' : '' }}
                                    id="arm_certification" name="arm_certification">
                                <span style="color: rgb(0,149,221)">(File size max 200 KB)</span>
                                <input class="form-control" type="hidden" id="arm_certification_old"
                                    value="{{ $student->arm_certification ?? '' }}" name="arm_certification_old">
                                <div class="mb-3 col-md-12">
                                    <img src="{{ $student->arm_certification ?? '' }}" id="arm_certification_preview"
                                        style="height: 100px; width: 100px;" />
                                </div>
                            </div>


                            <div class="col-12 d-flex justify-content-between">
                                <button type="button" class="btn btn-primary btn-prev">
                                    <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                    <span class="align-middle d-sm-inline-block d-none Previous"
                                        data-next="sscexamdetails" data-currentdata="social-links"
                                        data-target="#address">Previous</span>
                                </button>
                                <button style="margin-left: 60%;" type="button" data-value="desiredsubject"
                                    data-pre="accountdetails" data-target="#personal-info" class="btn btn-info">
                                    <span class="align-right d-sm-inline-block d-none me-sm-1">Save</span>
                                </button>
                                <button type="button" data-value="academicinfo" data-currentdata="address"
                                    data-pre="force" data-target="#review-submit" class="btn btn-primary nextbtn">
                                    <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                    <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                </button>
                            </div>

                        </div>
                        <div class="row g-3 {{ isset($student) && $student->categoryid == 3 ? 'show' : 'hide' }}"
                            id="teacherinfo">
                            <div class="mb-3 col-md-6">
                                <label for="local_guardian_name" class="form-label">Name of the
                                    staff<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name_of_staff"
                                    {{ isset($student) && $student->categoryid == 3 ? 'required' : '' }}
                                    name="name_of_staff" placeholder="Name of the staff"
                                    value="{{ $student->name_of_staff ?? '' }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="guardian_name" class="form-label">Designation<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="staff_designation"
                                    {{ isset($student) && $student->categoryid == 3 ? 'required' : '' }}
                                    name="staff_designation" placeholder="Designation"
                                    value="{{ $student->staff_designation ?? '' }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="guardian_email" class="form-label">Staff ID<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="staff_id" name="staff_id"
                                    {{ isset($student) && $student->categoryid == 3 ? 'required' : '' }}
                                    placeholder="Staff ID" value="{{ $student->staff_id ?? '' }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="academic_transcript" class="form-label">Staff
                                    Certification/Testimonial from BAFSD (jpg,jpeg,png format)<span
                                        class="text-danger">*</span></label>
                                <input class="form-control" type="file"
                                    onchange="loadFile(event,'staff_certification_preview')"
                                    {{ isset($student) && $student->categoryid == 3 && $student->staff_certification == '' && $student->staff_certification == null ? 'required' : '' }}
                                    id="staff_certification" name="staff_certification">
                                <span style="color: rgb(0,149,221)">(File size max 200 KB)</span>
                                <input class="form-control" type="hidden" id="staff_certification_old"
                                    value="{{ $student->staff_certification ?? '' }}" name="staff_certification_old">
                                <div class="mb-3 col-md-12">
                                    <img src="{{ $student->staff_certification ?? '' }}"
                                        id="staff_certification_preview" style="height: 100px; width: 100px;" />
                                </div>
                            </div>



                            <div class="col-12 d-flex justify-content-between">
                                <button type="button" class="btn btn-primary btn-prev">
                                    <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                    <span class="align-middle d-sm-inline-block d-none Previous"
                                        data-next="sscexamdetails" data-currentdata="social-links"
                                        data-target="#address">Previous</span>
                                </button>
                                <button style="margin-left: 60%;" type="button" data-value="desiredsubject"
                                    data-pre="accountdetails" data-target="#personal-info" class="btn btn-info">
                                    <span class="align-right d-sm-inline-block d-none me-sm-1">Save</span>
                                </button>
                                <button type="button" data-value="academicinfo" data-currentdata="address"
                                    data-pre="force" data-target="#review-submit" class="btn btn-primary nextbtn">
                                    <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                    <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                </button>
                            </div>

                        </div>
                        <div class="row g-3 {{ isset($student) && $student->categoryid == 1 ? 'show' : 'hide' }}"
                            id="civildata">


                            <div class="col-12 d-flex justify-content-between">
                                <button type="button" class="btn btn-primary btn-prev">
                                    <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                    <span class="align-middle d-sm-inline-block d-none Previous"
                                        data-next="sscexamdetails" data-currentdata="social-links"
                                        data-target="#address">Previous</span>
                                </button>
                                <button style="margin-left: 60%;" type="button" data-value="desiredsubject"
                                    data-pre="accountdetails" data-target="#personal-info" class="btn btn-info">
                                    <span class="align-right d-sm-inline-block d-none me-sm-1">Save</span>
                                </button>
                                <button type="button" data-value="academicinfo" data-currentdata="address"
                                    data-pre="force" data-target="#review-submit" class="btn btn-primary nextbtn">
                                    <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                    <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                                </button>
                            </div>

                        </div>
                    </div>
                    <!-- Review -->
                    <div id="review-submit" class="content">
                        <div class="content-header mb-3">
                            <h6 class="mb-0" style="color: #da45dc;font-weight: bold;font-size: 16px;">
                                Academic Info
                            </h6>
                        </div>

                        @if (isset($activity) && $activity->class_id == 11)
                        <input type="hidden" name="class_id" value="{{ $activity->class_id }}" />
                        <input type="hidden" name="session_id" value="{{ $activity->session_id }}" />
                        <input type="hidden" name="version_id" value="{{ $activity->version_id }}" />
                        <input type="hidden" name="shift_id" value="{{ $activity->shift_id }}" />
                        <input type="hidden" name="class_code" value="{{ $activity->class_code }}" />
                        <input type="hidden" name="category_id" value="{{ $activity->category_id }}" />
                        <input type="hidden" name="group_id" value="{{ $activity->group_id }}" />
                        <input type="hidden" name="section_id" value="{{ $activity->section_id }}" />
                        <input type="hidden" name="house_id" value="{{ $activity->house_id }}" />
                        <input type="hidden" name="roll" value="{{ $activity->roll }}" />
                        @endif
                        <div class="row g-3">
                            <div class="mb-3 col-md-4">
                                <label for="session_id" class="form-label">Session</label>
                                <select id="session_id" disabled="disabled" name="session_id" class=" form-select"
                                    required="">
                                    <option value="">Select Session</option>
                                    @foreach ($sessions as $session)
                                    <option value="{{ $session->id }}"
                                        {{ isset($activity) && $activity->session_id == $session->id ? 'selected="selected"' : '' }}>
                                        {{ $session->session_name }}
                                    </option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="version_id" class="form-label">Version</label>
                                <select id="version_id" disabled="disabled" name="version_id" class=" form-select"
                                    required="">
                                    <option value="">Select Version</option>
                                    @foreach ($versions as $version)
                                    <option value="{{ $version->id }}"
                                        {{ isset($activity) && $activity->version_id == $version->id ? 'selected="selected"' : '' }}>
                                        {{ $version->version_name }}
                                    </option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="shift_id" class="form-label">Shift</label>
                                <select id="shift_id" disabled="disabled" name="shift_id" class=" form-select"
                                    required="">
                                    <option value="">Select Shift</option>
                                    @foreach ($shifts as $shift)
                                    <option value="{{ $shift->id }}"
                                        {{ isset($activity) && $activity->shift_id == $shift->id ? 'selected="selected"' : '' }}>
                                        {{ $shift->shift_name }}
                                    </option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="class_id" class="form-label">Class</label>
                                <label for="class_code" class="form-label">Class</label>
                                <select id="class_code" disabled="disabled" name="class_code" class=" form-select"
                                    required="">
                                    <option value="">Select Class</option>

                                    <option value="0"
                                        {{ isset($activity) && $activity->class_code == 0 ? 'selected="selected"' : '' }}>
                                        KG</option>
                                    <option value="1"
                                        {{ isset($activity) && $activity->class_code == 1 ? 'selected="selected"' : '' }}>
                                        Class I</option>
                                    <option value="2"
                                        {{ isset($activity) && $activity->class_code == 2 ? 'selected="selected"' : '' }}>
                                        Class II</option>
                                    <option value="3"
                                        {{ isset($activity) && $activity->class_code == 3 ? 'selected="selected"' : '' }}>
                                        Class III</option>
                                    <option value="4"
                                        {{ isset($activity) && $activity->class_code == 4 ? 'selected="selected"' : '' }}>
                                        Class IV</option>
                                    <option value="5"
                                        {{ isset($activity) && $activity->class_code == 5 ? 'selected="selected"' : '' }}>
                                        Class V</option>
                                    <option value="6"
                                        {{ isset($activity) && $activity->class_code == 6 ? 'selected="selected"' : '' }}>
                                        Class VI</option>
                                    <option value="7"
                                        {{ isset($activity) && $activity->class_code == 7 ? 'selected="selected"' : '' }}>
                                        Class VII</option>
                                    <option value="8"
                                        {{ isset($activity) && $activity->class_code == 8 ? 'selected="selected"' : '' }}>
                                        Class VIII</option>
                                    <option value="9"
                                        {{ isset($activity) && $activity->class_code == 9 ? 'selected="selected"' : '' }}>
                                        Class IX</option>
                                    <option value="10"
                                        {{ isset($activity) && $activity->class_code == 10 ? 'selected="selected"' : '' }}>
                                        Class X</option>
                                    <option value="11"
                                        {{ isset($activity) && $activity->class_code == 11 ? 'selected="selected"' : '' }}>
                                        Class XI</option>
                                    <option value="12"
                                        {{ isset($activity) && $activity->class_code == 12 ? 'selected="selected"' : '' }}>
                                        Class XII</option>


                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="category_id" class="form-label">Category</label>
                                <select id="category_id" disabled="disabled" name="category_id" class=" form-select">
                                    <option value="">Select Category</option>

                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ isset($activity) && $activity->category_id == $category->id ? 'selected="selected"' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="group_id" class="form-label">Group</label>
                                <select id="group_id" disabled="disabled" name="group_id" class=" form-select"
                                    required="">
                                    <option value="">Select Group</option>

                                    @foreach ($groups as $group)
                                    <option value="{{ $group->id }}"
                                        {{ isset($activity) && $activity->group_id == $group->id ? 'selected="selected"' : '' }}>
                                        {{ $group->group_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="section_id" class="form-label">Section</label>
                                <select id="section_id" disabled="disabled" name="section_id" class=" form-select">
                                    <option value="">Select Section</option>
                                    @foreach ($sections as $section)
                                    <option value="{{ $section->id }}"
                                        {{ isset($activity) && $activity->section_id == $section->id ? 'selected="selected"' : '' }}>
                                        {{ $section->section_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="house_id" class="form-label">House</label>
                                <select id="house_id" disabled="disabled" name="house_id" class=" form-select">
                                    <option value="">Select House </option>
                                    @foreach ($houses as $house)
                                    <option value="{{ $house->id }}"
                                        {{ isset($activity) && $activity->house_id == $house->id ? 'selected="selected"' : '' }}>
                                        {{ $house->house_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="roll" class="form-label">Roll</label>
                                <input class="form-control" disabled="disabled" type="text" id="roll" name="roll"
                                    value="{{ $activity->roll ?? '' }}" placeholder="Roll" autofocus="">
                            </div>
                            <div class="col-12 d-flex justify-content-between">
                                @if ($student->submit != 2)
                                <input type="hidden" class="btn btn-warning me-2" name="submit" id="submit" value="1">
                                <button type="button" class="btn btn-primary btn-prev">
                                    <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                                    <span class="align-middle d-sm-inline-block d-none Previous" data-next="force"
                                        data-currentdata="review-submit" data-target="#social-links">Previous</span>
                                </button>
                                <!-- <button type="button" class="btn btn-info btn-save">Save</button> -->
                                <button type="button" class="btn btn-success " id="btn-submit">Submit
                                    & Preview</button>
                            </div>
                            <!-- <input type="hidden" class="btn btn-warning me-2" name="submit" id="submit"  value="1">
                                            <button type="button" class="btn btn-outline-warning" id="final_submit">Final Submit</button>
                                            <button type="submit" class="btn btn-outline-primary" id="savebuuton">Save</button>
                                            <button type="reset" class="btn btn-outline-secondary">Cancel</button> -->
                            @else
                            <a href="{{ url('admin/studentPrint/' . $student->id) }}" target="_blank"
                                class="btn btn-outline-primary">Print</a>
                            {{-- @endif --}}

                        </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Validation Wizard -->
    <!-- Vertical Wizard -->

    <!-- /Vertical Wizard -->
</div>
@endif

</div>
<!-- / Content -->

<div class="content-backdrop fade"></div>
</div>
<div class="modal fade" id="modalScrollable" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <form id="formAdmission" method="POST" action="{{ route('storePreview') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="student_code" value="{{ $student->student_code ?? '' }}" />
            <input type="hidden" name="id" value="{{ $student->id ?? '' }}" />
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFullTitle" style="margin-left:33%;">BAF SHAHEEN COLLEGE DHAKA
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
            <form>
    </div>
</div>
<script src="{{ asset('public/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
<script src="{{ asset('/') }}public/backend/assets/js/ui-modals.js"></script>

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

        var output = document.getElementById(preview);
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
        $.LoadingOverlay("show");
        var formElement = document.getElementById('formAdmission');
        var formData = new FormData(formElement);

        $.ajax({
            url: '{{ route('
            uploadimage ') }}',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {

                Swal.fire({
                    title: "Success!",
                    text: "Upload Successfully",
                    icon: "success"
                });
                $.LoadingOverlay("hide");

            },
            error: function(response) {
                Swal.fire({
                    title: "warning!",
                    text: "File Not Upload",
                    icon: "warning"
                });
                $.LoadingOverlay("hide");
            }
        });
    }

};
</script>
<script>
@if(Session::get('success'))

Swal.fire({
    title: "Good job!",
    text: "{{ Session::get('success') }}",
    icon: "success"
});
@endif
@if(Session::get('warning'))

Swal.fire({
    title: "warning!",
    text: "{{ Session::get('warning') }}",
    icon: "warning"
});
@endif
$(function() {

    checksection();

    $("#formAdmission").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var actionUrl = form.attr('action');

        $.ajax({
            type: "POST",
            url: actionUrl,
            data: form.serialize(), // serializes the form's elements.
            success: function(data) {
                // show response from the php script.
            }
        });

    });
    $(document).on('click', '.edit-icon', function() {
        var forvalue = $(this).data('forvalue');

        $("input[name='" + forvalue + "']").prop('readonly', false);
    });
    $(document).on('change', '#is_service', function() {
        if ($(this).val() == 1) {
            $("#office_address_div").removeClass('hide').addClass('showinput');
            $("#office_address").attr('required', true);
        } else {

            $("#office_address_div").addClass('hide').removeClass('showinput');
            $("#office_address").removeAttr('required');
        }

    });
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
    $(document.body).on('click', '.btn-info', function() {
        var form = $('#formAdmission')[0];
        var formData = new FormData(form);
        var actionUrl = "{{ route('admissionSave') }}";
        $.LoadingOverlay("show");
        $.ajax({
            type: "POST",
            url: actionUrl,
            data: formData, // Use FormData
            processData: false, // Prevent jQuery from processing the data
            contentType: false, // Prevent jQuery from setting the content type // serializes the form's elements.
            success: function(data) {
                Swal.fire({
                    title: "Success",
                    text: "Successfuly Save",
                    icon: "success"
                });
                $.LoadingOverlay("hide");

                //showpreview(data);
                //alert(data); // show response from the php script.
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
    $(document.body).on('click', '.headermenu', function() {
        var elementId = '';
        $('.active.dstepper-block').each(function() {
            // Get the id attribute value of each element
            elementId = $(this).attr('id');
            // console.log(elementId); // Output the id value
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
        if (isValid) {
            $('#formAdmission .content').removeClass('active dstepper-block');
            $('.step').removeClass('text-bold');
            $('.bs-stepper-header .step').removeClass('active');
            // $('.bs-stepper-header .step:first').addClass('crossed');
            $('#' + pre).removeClass('active dstepper-block');
            // $('#'+pre).addClass('crossed');
            $(this).parent().addClass('active dstepper-block text-bold');
            $('#' + currentdata).addClass('active dstepper-block');
        }

    });
    $(document.body).on('click', '.nextbtn,.btn-next', function() {
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
        var oldTestimonialValue = $('#testimonial_old').val();
        var testimonial = '';

        if (testimonialElement.files.length > 0 && testimonialElement.files[0].name) {
            testimonial = testimonialElement.files[0].name;
        } else if (oldTestimonialValue) {
            testimonial = oldTestimonialValue;
        } else {
            // // Display error message
            // alert('Please provide a testimonial or upload a file.');
            // return false;
            // // Alternatively, you can update the UI to show the error message
            // //$('#error-message').text('Please provide a testimonial or upload a file.').show();
        }


        var photoElement = $('#photo')[0];
        var oldPhotoValue = $('#photo_old').val();
        var photo = '';

        if (testimonialElement.files.length > 0 && testimonialElement.files[0].name) {
            photo = photoElement.files[0].name;
        } else if (oldPhotoValue) {
            photo = oldPhotoValue;
        } else {
            // // Display error message
            // alert('Please provide a testimonial or upload a file.');
            // return false;
            // // Alternatively, you can update the UI to show the error message
            // //$('#error-message').text('Please provide a testimonial or upload a file.').show();
        }

        var photoElement = $('#photo')[0];
        var oldPhotoValue = $('#photo_old').val();
        var academic_transcript = '';

        if (testimonialElement.files.length > 0 && testimonialElement.files[0].name) {
            academic_transcript = photoElement.files[0].name;
        } else if (oldPhotoValue) {
            academic_transcript = oldPhotoValue;
        } else {
            // // Display error message
            // alert('Please provide a testimonial or upload a file.');
            // return false;
            // // Alternatively, you can update the UI to show the error message
            // //$('#error-message').text('Please provide a testimonial or upload a file.').show();
        }

        var academicTranscriptElement = $('#academic_transcript')[0];
        var oldAcademicTranscriptValue = $('#academic_transcript_old').val();
        var academic_transcript;

        if (academicTranscriptElement.files.length > 0 && academicTranscriptElement.files[0].name) {
            academic_transcript = academicTranscriptElement.files[0].name;
        } else if (oldAcademicTranscriptValue) {
            academic_transcript = oldAcademicTranscriptValue;
        } else {
            // Display error message
            // alert('Please provide an academic transcript or upload a file.');
            // Alternatively, you can update the UI to show the error message
            // $('#error-message').text('Please provide an academic transcript or upload a file.').show();
        }
        var admit_cardElement = $('#admit_card')[0];
        var oldadmit_cardValue = $('#admit_card_old').val();
        var admit_card;

        if (admit_cardElement.files.length > 0 && admit_cardElement.files[0].name) {
            admit_card = admit_cardElement.files[0].name;
        } else if (oldadmit_cardValue) {
            admit_card = oldadmit_cardValue;
        } else {
            // Display error message
            // alert('Please provide an academic transcript or upload a file.');
            // Alternatively, you can update the UI to show the error message
            // $('#error-message').text('Please provide an academic transcript or upload a file.').show();
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
                return false; // Exit the .each loop
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
            return false; // Stop further execution
        }

        //return false;




        // if (typeof $('#photo')[0].files[0]['name'] !== 'undefined' && $('#photo')[0].files[0]['name'] !== null) {
        //     var photo=$('#photo')[0].files[0]['name'];
        // }else{
        //     var photo=$('#photo_old').val();
        // }
        // if (typeof $('#academic_transcript')[0].files[0]['name'] !== 'undefined' && $('#academic_transcript')[0].files[0]['name'] !== null) {
        //     var academic_transcript=$('#academic_transcript')[0].files[0]['name'];
        // }else{
        //     var academic_transcript=$('#academic_transcript_old').val();
        // }
        // var photo=$('#photo')[0].files[0]['name']?$('#photo')[0].files[0]['name']:$('#photo_old').val();
        // var testimonial=$('#testimonial')[0].files[0]['name']?$('#testimonial')[0].files[0]['name']:$('#testimonial_old').val();
        // var academic_transcript=$('#academic_transcript')[0].files[0]['name']?$('#academic_transcript')[0].files[0]['name']:$('#academic_transcript_old').val();
        //console.log(first_name,birthdate,religion,mobile,gender,sms_notification,photo,testimonial,academic_transcript)

        if (isValid) {
            $('#formAdmission .content').removeClass('active dstepper-block');
            $('.step').removeClass('text-bold');
            $('.bs-stepper-header .step').removeClass('active');
            // $('.bs-stepper-header .step:first').addClass('crossed');
            // $('#'+pre).addClass('crossed');
            $('#' + boxdata).addClass('active');
            $('#' + boxdata).first().addClass('text-bold');
            $(targetdiv).addClass('active dstepper-block');



            var form = $('#formAdmission')[0];
            var formData = new FormData(form);
            var actionUrl = "{{ route('admissionSave') }}";
            $.LoadingOverlay("show");
            $.ajax({
                type: "POST",
                url: actionUrl,
                data: formData, // Use FormData
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Prevent jQuery from setting the content type // serializes the form's elements.
                success: function(data) {
                    Swal.fire({
                        title: "Success",
                        text: "Successfuly Save",
                        icon: "success"
                    });
                    $.LoadingOverlay("hide");

                    //showpreview(data);
                    //alert(data); // show response from the php script.
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


        } else {
            Swal.fire({
                title: "Error",
                text: "Asterisk(*) fields need to be completed",
                icon: "warning"
            });
        }
    });
    $(document.body).on('click', '.Previous', function() {
        var elementId = '';
        $('.active.dstepper-block').each(function() {
            // Get the id attribute value of each element
            elementId = $(this).attr('id');
            // console.log(elementId); // Output the id value
        });
        var targetvalue = $(this).data('target');
        var next = $(this).data('next');
        var currentdata = $(this).data('currentdata');



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







        $('#formAdmission .content').removeClass('active dstepper-block');
        $('.bs-stepper-header .step').removeClass('active');
        $('.step').removeClass('text-bold');
        //$('.bs-stepper-header .step:first').addClass('crossed');

        $('#' + currentdata).removeClass('active dstepper-block').removeClass('crossed');
        $(targetvalue).addClass('active dstepper-block');
        $('#' + next).addClass('active text-bold');
    });
    $(document.body).on('click', '#same_as', function() {
        if ($('#same_as').is(':checked')) {
            var present_addr = $('#present_addr').val();
            var present_police_station = $('#present_police_station').val();
            var present_district_id = $('#present_district_id').val();

            $('#permanent_addr').val(present_addr);
            $('#permanent_police_station').val(present_police_station);
            $('#permanent_district_id').val(present_district_id);
        } else {
            $('#permanent_addr').val('');
            $('#permanent_police_station').val('');
            $('#permanent_district_id').val('');
        }
    });
    $(document.body).on('click', '.btn-save', function() {
        var form = $('#formAdmission')[0];
        var formData = new FormData(form);
        var actionUrl = "{{ route('admissionSave') }}";
        $.LoadingOverlay("show");
        $.ajax({
            type: "POST",
            url: actionUrl,
            data: formData, // Use FormData
            processData: false, // Prevent jQuery from processing the data
            contentType: false, // Prevent jQuery from setting the content type // serializes the form's elements.
            success: function(data) {
                Swal.fire({
                    title: "Success",
                    text: "Successfuly Save",
                    icon: "success"
                });
                $.LoadingOverlay("hide");

                //showpreview(data);
                //alert(data); // show response from the php script.
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
    $(document.body).on('click', '#btn-submit', function() {
        var form = $('#formAdmission')[0];
        var formData = new FormData(form);
        var actionUrl = "{{ route('admissionSave') }}";
        $.LoadingOverlay("show");
        $.ajax({
            type: "POST",
            url: actionUrl,
            data: formData, // Use FormData
            processData: false, // Prevent jQuery from processing the data
            contentType: false, // Prevent jQuery from setting the content type // serializes the form's elements.
            success: function(data) {
                // Swal.fire({
                //            title: "Success",
                //            text: "Successfuly Save",
                //            icon: "success"
                //      });
                //$.LoadingOverlay("hide");

                showpreview(data);
                //alert(data); // show response from the php script.
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

                $('#submit').val(2);
                var btn = document.getElementById('savebuuton');
                btn.click();
                btn.disabled = true;
                //$('#savebuuton').trigger('click');
            } else if (result.isDenied) {

            }
        })
    });
    $('#lfm').filemanager('image');
    $('#lfm1').filemanager('image');
    @if(isset($studentdata))
    $('#modalToggle').modal('show');
    @endif
    $('.form-check-input.third_subject').change(function() {
        var checkvalue = $(this).val();

        var pair = $(this).data('pair');
        var third_subject = [];
        var third_pair_subject = [];
        var pre_pair = 'na';
        $('.form-check-input.third_subject:checked').each(function() {
            // alert(pre_pair,$(this).val());
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
        // selectedThirdValues = [];
        // $('.form-check-input.third_subject:checked').each(function(){
        //    selectedThirdValues.push($(this).val());
        // });
        var fourth_pair_subject = [];
        var check = 0;
        $('.form-check-input.fourth_subject:checked').each(function() {

            if ($(this).val() == checkvalue || (checkvalue == '67-68' && $(this).val() ==
                    '82-90')) {
                Swal.fire({
                    title: "Error",
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
                title: "Error",
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
        @if(Auth::user() - > group_id == 2 && Auth::user() - > group_id == 5)
        var url = "#";
        @else
        var url = "{{ route('checksection') }}";
        @endif
        var gender = $('#gender').val();
        if (fourth_subject.length > 0 && third_subject.length > 0 && gender != '' && gender !=
            null) {

            var class_id = $('#class_id').val();
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
    });
    $('.form-check-input.fourth_subject').change(function() {
        var checkvalue = $(this).val();
        var pair = $(this).data('pair');
        var fourth_subject = [];
        $('.form-check-input.fourth_subject:checked').each(function() {
            fourth_subject.push($(this).val());

        });
        // selectedThirdValues = [];
        // $('.form-check-input.third_subject:checked').each(function(){
        //    selectedThirdValues.push($(this).val());
        // });
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
        @if(Auth::user() - > group_id == 2 && Auth::user() - > group_id == 5)
        var url = "#";
        @else
        var url = "{{ route('checksection') }}";
        @endif
        if (fourth_subject.length > 0 && third_subject.length > 0 && gender != '' && gender !=
            null) {

            var class_id = $('#class_id').val();
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
    });

    @if(isset($student - > submit) &&
        $student - > submit == 2 &&
        Auth::user() - > group_id != 2 &&
        Auth::user() - > group_id != 5 &&
        Auth::user() - > group_id != 3)

    $(":input:not([type=hidden]),select,textarea").prop("disabled", true);
    $("#photo").prop("disabled", false);
    @endif
});

function showpreview(studentcode) {
    var url = "{{ route('studentpreview') }}";
    $.ajax({
        type: "post",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
        },
        url: url,
        data: {
            "_token": "{{ csrf_token() }}",
            studentcode,
            studentcode
        },
        success: function(response) {
            $('#modalScrollable').modal('show');
            $.LoadingOverlay("hide");

            $('#studentpreview').html(response);


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

    @if(Auth::user() - > group_id == 2 && Auth::user() - > group_id == 5)
    var url = "#";
    @else
    var url = "{{ route('checksection') }}";
    @endif
    var gender = $('#gender').val();
    if (fourth_subject.length > 0 && third_subject.length > 0 && gender != '' && gender != null) {

        var class_id = $('#class_id').val();
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
</script>
@endsection
