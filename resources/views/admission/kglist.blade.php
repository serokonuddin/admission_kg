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
            color: white;
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
            background-color: #1c4d7c !important;
            color: #fff !important;
            font-weight: bold;
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
            color: #ffffff;
        }

        .p-10 {
            padding: 10px !important;
        }

        .m-r-10 {
            margin-right: 10px !important;
        }

        .childdata {
            display: none;
            background-color: #98fded;
        }

        .btn {
            font-size: 11px !important;
        }

        .form-label {
            width: 100% !important;
        }

        td {
            color: #000 !important;
        }
    </style>
    @php
        $classroman = [
            '0' => 'KG',
            '1' => 'I One',
            '2' => 'II Two',
            '3' => 'III Three',
            '4' => 'IV Four',
            '5' => 'V Five',
            '6' => 'VI Six',
            '7' => 'VII Seven',
            '8' => 'VIII Eight',
            '9' => 'IX Nine',
            '10' => 'X Ten',
            '11' => 'XI Eleven',
            '12' => 'XII Twelve',
        ];
    @endphp
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            {{-- <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Student Admission List</h4> --}}
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Primary and Secondary Statistics</li>
                </ol>
            </nav>
            <div class="card">
                <div class="card-header">
                    <div class="col-sm-12 col-md-12">
                        <div class="dataTables_length" id="DataTables_Table_0_length" style="padding: 5px">
                            <form action="{{ route('showStudentCounts') }}" method="GET">
                                <div class="row g-3 searchby">
                                    <div class="col-sm-3">
                                        <label class="form-label">
                                            <select id="session_id" name="session_id" class="form-select" required="">
                                                @foreach ($sessions as $session)
                                                    <option value="{{ $session->id }}"
                                                        {{ $session_id == $session->id ? 'selected="selected"' : '' }}>
                                                        {{ $session->session_name }}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-label">
                                            <select id="version_id" name="version_id" class="form-select">
                                                <option value="">Select Version</option>
                                                @foreach ($versions as $version)
                                                    <option value="{{ $version->id }}"
                                                        {{ $version_id == $version->id ? 'selected="selected"' : '' }}>
                                                        {{ $version->version_name }}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-label">
                                            <select id="shift_id" name="shift_id" class="form-select">
                                                <option value="">Select Shift</option>
                                                @foreach ($shifts as $shift)
                                                    <option value="{{ $shift->id }}"
                                                        {{ $shift_id == $shift->id ? 'selected="selected"' : '' }}>
                                                        {{ $shift->shift_name }}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-label">
                                            <select id="class" name="class_id" id="class_id" class="form-select">
                                                <option value="">Select Class</option>

                                                <option value="0"
                                                    {{ isset($admission) && $admission->class_id == 0 ? 'selected="selected"' : '' }}>
                                                    KG</option>
                                            </select>
                                        </label>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>
                                            <button type="submit" class="btn btn-primary me-2">Search</button>
                                        </label>
                                        <button class="btn btn-info" onclick="printTable()">Print</button>
                                    </div>
                                </div>
                            </form>

                            <!-- Buttons for different versions -->



                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        @php
                            $total = 0;
                            $male = 0;
                            $female = 0;
                        @endphp

                        @foreach ($versiondata as $j => $version)
                            @php
                                $totals = 0;
                                $males = 0;
                                $females = 0;
                            @endphp

                            @foreach ($version as $k => $shift)
                                <div class="col-sm-12">
                                    <table class="table"
                                        style="border: 1px solid #ddd; border-collapse: collapse; width: 100%;">
                                        <thead
                                            style="background-color: #4A90E2; color: #fff !important; border: 1px solid #ddd;">
                                            <tr>
                                                <th colspan="4" style="border: 1px solid #ddd; text-align: center;">
                                                    Version: {{ $j }}</th>
                                                <th style="border: 1px solid #ddd; text-align: center;">Shift:
                                                    {{ $k }}</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                                @foreach ($shift as $key11 => $classess)
                                    <div class="col-sm-6">
                                        <div class="table-responsive">
                                            <table class="table"
                                                style="border: 1px solid #ddd; border-collapse: collapse; width: 100%;">
                                                <thead
                                                    style="background-color: #2C3E50; color: #fff !important; border: 1px solid #ddd;">
                                                    <tr>
                                                        <th style="border: 1px solid #ddd; text-align: center;">Class</th>
                                                        <th style="border: 1px solid #ddd; text-align: center;">Section</th>
                                                        <th style="border: 1px solid #ddd; text-align: center;">Male</th>
                                                        <th style="border: 1px solid #ddd; text-align: center;">Female</th>
                                                        <th style="border: 1px solid #ddd; text-align: center;">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($classess as $key => $student)
                                                        <tr>
                                                            @if ($key == 0)
                                                                <td rowspan="{{ count($classess) }}"
                                                                    style="border: 1px solid #ddd; text-align: center;">
                                                                    {{ $classroman[$student->class_code] }}
                                                                </td>
                                                            @endif
                                                            <td>{{ $student->section_name }}</td>
                                                            @php
                                                                $total = $student->male_count + $student->female_count;
                                                            @endphp
                                                            <td style="border: 1px solid #ddd; text-align: center;">
                                                                {{ $student->male_count }}</td>
                                                            <td style="border: 1px solid #ddd; text-align: center;">
                                                                {{ $student->female_count }}</td>
                                                            <td style="border: 1px solid #ddd; text-align: center;">
                                                                {{ $total }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr style="background-color: #E67E22; color: white; font-weight: bold;">

                                                        <!-- Warm orange for subtotal -->
                                                        <td colspan="2"
                                                            style="border: 1px solid #ddd; text-align: right;">Total:</td>
                                                        <td style="border: 1px solid #ddd; text-align: center;">
                                                            {{ collect($classess)->sum('male_count') }}</td>
                                                        <td style="border: 1px solid #ddd; text-align: center;">
                                                            {{ collect($classess)->sum('female_count') }}</td>
                                                        <td style="border: 1px solid #ddd; text-align: center;">
                                                            {{ collect($classess)->sum('male_count') + collect($classess)->sum('female_count') }}
                                                        </td>


                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                    @php
                                        $totals +=
                                            collect($classess)->sum('male_count') +
                                            collect($classess)->sum('female_count');
                                        $males += collect($classess)->sum('male_count');
                                        $females += collect($classess)->sum('female_count');
                                        $total +=
                                            collect($classess)->sum('male_count') +
                                            collect($classess)->sum('female_count');
                                        $male += collect($classess)->sum('male_count');
                                        $female += collect($classess)->sum('female_count');
                                    @endphp
                                @endforeach

                                <div class="col-sm-12">
                                    <table class="table"
                                        style="border: 1px solid #ddd; border-collapse: collapse; width: 100%;">
                                        <thead style="background-color: #16A085; color: white; border: 1px solid #ddd;">
                                            <tr>
                                                <td colspan="2" style="border: 1px solid #ddd; text-align: center;">Sub
                                                    Total</td>
                                                <td style="border: 1px solid #ddd; text-align: center;">Total:
                                                    {{ $totals }}</td>
                                                <td style="border: 1px solid #ddd; text-align: center;">Male:
                                                    {{ $males }}</td>
                                                <td style="border: 1px solid #ddd; text-align: center;">Female:
                                                    {{ $females }}</td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            @endforeach
                        @endforeach

                        <div class="col-sm-12">
                            <table class="table table-bordered">
                                <thead style="background-color: #3e9bd1; color: white;">
                                    <!-- Royal purple for grand total -->
                                    <tr>
                                        <td colspan="2">Grand Total</td>
                                        <td>Total: {{ $male + $female }}</td>
                                        <td>Male: {{ $male }}</td>
                                        <td>Female: {{ $female }}</td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Registration Form -->
        <div class="modal fade" id="exampleModalLong" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content p-4">
                    <div class="modal-header text-center">
                        <h5 class="modal-title" style="width: 100%;">
                            <span style="color: #20aee5">বিএএফ শাহীন কলেজ ঢাকা</span> <br />
                            <span style="color: red">(শিক্ষাবর্ষ ২০২৫ কেজি শ্রেণির ভর্তি)</span><br />
                            <span style="color: rgb(46,49,146)" id="versiontext"></span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admissionupdate') }}" method="POST" enctype="multipart/form-data"
                        id="checkstatusform">
                        @csrf
                        <input type="hidden" id="id" name="id">
                        <input type="hidden" id="versionid" name="version_id">
                        <input type="hidden" id="classid" name="class_id">
                        <input type="hidden" id="sessionid" name="session_id">
                        <input type="hidden" id="temporary_id1" name="temporary_id">

                        <p style="font-size: 1.2rem;font-weight: bold">Which Shift Do You Want To Get Admitted Into KG?</p>

                        <div class="row">
                            <div class="col-md-12">
                                <table class="noborder">
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="shift_id"
                                                    id="flexRadioDefault1" value="1" checked="">
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    &nbsp;Morning
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="shift_id"
                                                    id="flexRadioDefault2" value="2">
                                                <label class="form-check-label" for="flexRadioDefault2">
                                                    &nbsp;Day
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                </table>


                            </div>
                        </div>
                        <p style="font-size: 1.2rem;font-weight: bold">Select Candidate's Category</p>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="noborder width-100">
                                    <tr>
                                        <td>
                                            <div class="form-check d-flex">
                                                <input class="form-check-input category" required="" type="radio"
                                                    name="category_id" id="1" value="1" checked="">
                                                <label class="form-check-label" for="1">
                                                    &nbsp;Civil- Child of Civil Person
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check d-flex">
                                                <input class="form-check-input category " required="" type="radio"
                                                    name="category_id" id="2" value="2">
                                                <label class="form-check-label" for="2">
                                                    &nbsp;BAF- Child of BAF Employee (Active Service Only)
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check d-flex">
                                                <input class="form-check-input category" type="radio" required=""
                                                    name="category_id" id="3" value="3">
                                                <label class="form-check-label " for="3">
                                                    &nbsp;SD- Child of BAF Shaheen College Employee
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check d-flex">
                                                <input class="form-check-input category" type="radio" required=""
                                                    name="category_id" id="4" value="4">
                                                <label class="form-check-label" for="4">
                                                    &nbsp;GEN- Student of Golden Eagle Nursery, Dhaka
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                </table>


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" id="categoryview">
                            </div>
                        </div>
                        <div class="row">

                            <p style="font-size: 1.2rem;font-weight: bold">Personal Information</p>

                            <div class="col">
                                <label for="inputEmail4">Candidate's English Name<span style="color: red">*</span></label>
                                <input type="text" class="form-control" value="{{ old('name_en') }}"
                                    style="text-transform:uppercase" required="" name="name_en" id="name_en"
                                    placeholder="English Name">
                            </div>
                            <div class="col">
                                <label for="inputEmail4">প্রার্থীর বাংলা নাম<span style="color: red">*</span></label>
                                <input type="text" class="form-control" required="" value="{{ old('name_bn') }}"
                                    name="name_bn" id="name_bn" placeholder="Bangla Name">
                            </div>


                        </div>
                        <br />
                        <div class="row">

                            <div class="col">
                                <label for="inputEmail4">Candidate's Date Of Birth<span style="color: red">*</span><span
                                        id="age"></span></label>
                                <input type="date" class="form-control" required="" value="{{ old('dob') }}"
                                    id="dob" name="dob" placeholder="Date of Birth">
                                <span id="message"></span>
                            </div>
                            <div class="col">
                                <label for="inputEmail4">Candidate's Gender<span style="color: red">*</span></label>
                                <select class="form-select form-control" required="" id="gender" name="gender"
                                    aria-label="Default select example">
                                    <option value="1" {{ old('gender') == 1 ? 'selected="selected"' : '' }}>Male
                                    </option>
                                    <option value="2" {{ old('gender') == 2 ? 'selected="selected"' : '' }}>Female
                                    </option>
                                </select>
                            </div>


                        </div>
                        <br />
                        <div class="row">

                            <div class="col">
                                <label for="inputEmail4">Gurdian's Name<span style="color: red">*</span></label>
                                <input type="text" class="form-control" required=""
                                    value="{{ old('gurdian_name') }}" id="gurdian_name" name="gurdian_name"
                                    placeholder="Gurdian Name">
                            </div>
                            <div class="col">
                                <label for="inputEmail4">Mobile Number<span style="color: red">*</span></label>
                                <input type="text" class="form-control" required="" value="{{ old('mobile') }}"
                                    id="mobile1" name="mobile" placeholder="Mobile">
                            </div>


                        </div>
                        <br />
                        <div class="row">

                            <div class="col">
                                <label for="inputEmail4">Candidate's Birth Registration Number<span
                                        style="color: red">*</span></label>
                                <input type="text" class="form-control"
                                    value="{{ old('birth_registration_number') }}" id="birth_registration_number1"
                                    required="" name="birth_registration_number"
                                    placeholder="Birth Registration Number">
                            </div>
                            <div class="col">
                                <label for="inputEmail4">Candidate's Birth Registration Certificate<span
                                        style="color: red">*</span></label>
                                <input type="file" class="form-control" name="birth_image" placeholder="Mobile">
                                <input type="hidden" class="form-control" name="birth_image_old" id="birth_image_old"
                                    placeholder="Mobile">
                            </div>


                        </div>
                        <br />
                        <div class="row">


                            <div class="col">
                                <label for="inputEmail4">Candidate's Photo<span style="color: red">*</span> (File size max
                                    200 KB)</label>
                                <input type="file" class="form-control" name="photo" placeholder="photo">
                                <input type="hidden" class="form-control" name="photo_old" id="photo_old"
                                    placeholder="photo">
                            </div>
                            <div class="col">
                                <label for="inputEmail4">Payment Status<span style="color: red">*</span></label>
                                <select class="form-select form-control" required="" id="payment_status"
                                    name="payment_status" aria-label="Default select example">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                </div>


                </form>
            </div>
        </div>
        <div class="content-backdrop fade"></div>
        <iframe id="txtArea1" style="display:none"></iframe>
    </div>



    <!-- Edit Modal -->
    <!-- <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                                                                                                                        <div class="modal-dialog">
                                                                                                                                            <div class="modal-content">
                                                                                                                                                <form id="editForm" method="POST" action="{{ route('admission.update') }}">
                                                                                                                                                    @csrf
                                                                                                                                                    <input type="hidden" name="id" id="id">
                                                                                                                                                    <div class="modal-header">
                                                                                                                                                        <h5 class="modal-title" id="editModalLabel">Edit Student Admission</h5>
                                                                                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                                                                                    </div>
                                                                                                                                                    <div class="modal-body">
                                                                                                                                                        <div class="mb-3">
                                                                                                                                                            <label for="name_en" class="form-label">Name</label>
                                                                                                                                                            <input type="text" class="form-control" id="name_en" name="name_en">
                                                                                                                                                        </div>
                                                                                                                                                        <div class="mb-3">
                                                                                                                                                            <label for="temporary_id" class="form-label">Temporary ID</label>
                                                                                                                                                            <input type="text" class="form-control" id="temporary_id" name="temporary_id" disabled>
                                                                                                                                                        </div>
                                                                                                                                                        <div class="mb-3">
                                                                                                                                                            <label for="category_id" class="form-label">Category</label>
                                                                                                                                                            <select class="form-select" id="category_id" name="category_id">
                                                                                                                                                                <option value="1">Civil</option>
                                                                                                                                                                <option value="2">BAF</option>
                                                                                                                                                                <option value="3">SD</option>
                                                                                                                                                                <option value="4">GEN</option>
                                                                                                                                                            </select>
                                                                                                                                                        </div>
                                                                                                                                                        <div class="mb-3">
                                                                                                                                                            <label for="version_id" class="form-label">Version</label>
                                                                                                                                                            <select class="form-select" id="version_id" name="version_id" disabled>
                                                                                                                                                                <option value="1">Bangla</option>
                                                                                                                                                                <option value="2">English</option>
                                                                                                                                                            </select>
                                                                                                                                                        </div>
                                                                                                                                                        <div class="mb-3">
                                                                                                                                                            <label for="shift_id" class="form-label">Shift</label>
                                                                                                                                                            <select class="form-select" id="shift_id" name="shift_id" disabled>
                                                                                                                                                                <option value="1">Morning</option>
                                                                                                                                                                <option value="2">Day</option>
                                                                                                                                                            </select>
                                                                                                                                                        </div>
                                                                                                                                                        <div class="mb-3">
                                                                                                                                                            <label for="birth_registration_number" class="form-label">Birth ID</label>
                                                                                                                                                            <input type="text" class="form-control" id="birth_registration_number" name="birth_registration_number">
                                                                                                                                                        </div>
                                                                                                                                                        <div class="mb-3">
                                                                                                                                                            <label for="dob" class="form-label">Birth Date</label>
                                                                                                                                                            <input type="date" class="form-control" id="dob" name="dob">
                                                                                                                                                        </div>
                                                                                                                                                        <div class="mb-3">
                                                                                                                                                            <label for="gender" class="form-label">Gender</label>
                                                                                                                                                            <select class="form-select" id="gender" name="gender">
                                                                                                                                                                <option value="1">Male</option>
                                                                                                                                                                <option value="2">Female</option>
                                                                                                                                                            </select>
                                                                                                                                                        </div>
                                                                                                                                                        <div class="mb-3">
                                                                                                                                                            <label for="mobile" class="form-label">Mobile</label>
                                                                                                                                                            <input type="text" class="form-control" id="mobile" name="mobile">
                                                                                                                                                        </div>
                                                                                                                                                        <div class="mb-3">
                                                                                                                                                            <label for="payment_status" class="form-label">Payment Status</label>
                                                                                                                                                            <select class="form-select" id="payment_status" name="payment_status">
                                                                                                                                                                <option value="1">Success</option>
                                                                                                                                                                <option value="0">Unsuccess</option>
                                                                                                                                                            </select>
                                                                                                                                                        </div>
                                                                                                                                                    </div>
                                                                                                                                                    <div class="modal-footer">
                                                                                                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                                                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                                                                                                                    </div>
                                                                                                                                                </form>
                                                                                                                                            </div>
                                                                                                                                        </div>
                                                                                                                                    </div> -->



    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            // Select all buttons with the 'kgadmission' class
            document.querySelectorAll('.kgadmission').forEach(button => {
                button.addEventListener('click', function() {
                    // Get data from the button's data attributes
                    const classId = this.getAttribute('data-class_id');
                    const sessionId = this.getAttribute('data-session_id');
                    const versionId = this.getAttribute('data-versionid');
                    const price = this.getAttribute('data-price');
                    const versionText = this.textContent;

                    // Set the form values in the modal
                    document.getElementById('classid').value = classId;
                    document.getElementById('sessionid').value = sessionId;
                    document.getElementById('versionid').value = versionId;
                    document.getElementById('amount').value = price;
                    document.getElementById('versiontext').textContent = versionText;

                    // Show the modal
                    const exampleModal = new bootstrap.Modal(document.getElementById(
                        'exampleModalLong'));
                    exampleModal.show();
                });
            });
        });

        $(document).ready(function() {
            $('#dob').on('change', function() {
                let category_id = $('input[name="category_id"]:checked').val();


                var dob = new Date($(this).val());
                if (!isNaN(dob.getTime())) { // Check if the date is valid
                    var today = new Date(2025, 0, 1); // February 1, 2025

                    // Calculate the age in terms of years, months, and days
                    var years = today.getFullYear() - dob.getFullYear();
                    var months = today.getMonth() - dob.getMonth();
                    var days = today.getDate() - dob.getDate();

                    // Adjust if the birth date hasn't occurred yet this month
                    if (days < 0) {
                        months--;
                        // Get the last day of the previous month
                        var lastDayOfPrevMonth = new Date(today.getFullYear(), today.getMonth(), 0)
                            .getDate();
                        days += lastDayOfPrevMonth;
                    }

                    // Adjust if the birth month hasn't occurred yet this year
                    if (months < 0) {
                        years--;
                        months += 12;
                    }

                    // Convert the calculated age to total days for comparison
                    var totalAgeDays = years * 365 + months * 30 + days;

                    // Minimum age: 4 years, 11 months, and 15 days
                    var minAgeDays = (4 * 365) + (11 * 30) + 15;
                    // Maximum age: 6 years and 15 days
                    var maxAgeDays = (6 * 365) + 15;

                    // Check if the total days fall within the valid range
                    if ((totalAgeDays >= minAgeDays && totalAgeDays <= maxAgeDays) || (category_id == 2 ||
                            category_id == 4)) {
                        $('#age').text(years + ' years, ' + months + ' months, ' + days + ' days').css(
                            'color', 'green');
                        $('#message').text('Age is within the valid range').css('color', 'green');
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: 'Age is not within the valid range',
                            icon: "warning"
                        });

                        $('#age').text('');
                        $(this).val('');
                        $('#message').text('Age is not within the valid range').css('color', 'red');
                    }
                } else {
                    $('#message').text('Please select a valid date');
                }
            });
            $(document.body).on('change', '.category', function() {

                var category_id = $(this).val();
                $('#dob').val('');
                $('#age').html('');
                $('#message').html('');
                var url = "{{ route('getCategoryView') }}";
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        category_id
                    },
                    success: function(response) {

                        $.LoadingOverlay("hide");
                        console.log(response);
                        $('#categoryview').html(response);

                    },
                    error: function(data, errorThrown) {
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            title: "Error",
                            text: errorThrown,
                            icon: "warning"
                        });
                        $('#categoryview').html('');

                    }
                });
            });
            $(document.body).on('click', '.kgadmission', function() {
                var id = $(this).data('id');
                var versionid = $(this).data('version_id');
                var class_id = $(this).data('class_id');
                var shift_id = $(this).data('shift_id');
                var session_id = $(this).data('session_id');
                var category_id = $(this).data('category_id');

                var temporary_id = $(this).data('temporary_id');
                var service_holder_name = $(this).data('service_holder_name');
                var service_name = $(this).data('service_name');
                var name_of_service = $(this).data('name_of_service');
                var in_service = $(this).data('in_service');
                var office_address = $(this).data('office_address');
                //  var name_of_staff=$(this).data('name_of_staff');
                var staff_designation = $(this).data('staff_designation');
                var staff_id = $(this).data('staff_id');
                var staff_certification = $(this).data('staff_certification');
                var arm_certification = $(this).data('arm_certification');
                var gen_id = $(this).data('gen_id');
                var section = $(this).data('section');
                var name_en = $(this).data('name_en');
                var name_bn = $(this).data('name_bn');
                var dob = $(this).data('dob');
                var gender = $(this).data('gender');
                var gurdian_name = $(this).data('gurdian_name');
                var mobile = $(this).data('mobile');
                var birth_registration_number = $(this).data('birth_registration_number');
                var birth_image = $(this).data('birth_image');
                var photo = $(this).data('photo');
                var payment_status = $(this).data('payment_status');


                $('#id').val(id);
                $('#versionid').val(versionid);
                $('#classid').val(class_id);
                $('#sessionid').val(session_id);
                $("input[name='shift_id'][value='" + shift_id + "']").prop("checked", true);
                $("input[name='category_id'][value='" + category_id + "']").prop("checked", true).trigger(
                    'change');
                setTimeout(function() {
                    // Code to execute after delay
                    $('#service_holder_name').val(service_holder_name);
                    $('#temporary_id1').val(temporary_id);
                    $('#service_name').val(service_name);
                    $('#name_of_service').val(name_of_service);
                    $('#office_address').val(office_address);
                    $('#staff_designation').val(staff_designation);
                    $('#staff_id').val(staff_id);
                    $('#staff_certification_old').val(staff_certification);
                    $('#arm_certification_old').val(arm_certification);
                    $('#gen_id').val(gen_id);
                    $('#section').val(section);
                    $('#name_en').val(name_en);
                    $('#name_bn').val(name_bn);
                    $('#dob').val(dob);
                    $('#gender').val(gender);
                    $('#gurdian_name').val(gurdian_name);
                    $('#mobile1').val(mobile);
                    $('#birth_registration_number1').val(birth_registration_number);
                    $('#birth_image_old').val(birth_image);
                    $('#photo_old').val(photo);
                    $('#payment_status').val(payment_status);
                }, 4000);

                if (versionid == 1) {
                    $('#versiontext').text('ভার্সন বাংলা');
                } else {
                    $('#versiontext').text('Version English');
                }
                $('#exampleModalLong').modal('show');
            });


        });

        function openAddModal() {
            const addModal = new bootstrap.Modal(document.getElementById('addModal'));
            addModal.show();
        }

        function openEditModal(student) {
            document.getElementById('student_id').value = student.id;
            document.getElementById('name_en').value = student.name_en;
            document.getElementById('temporary_id').value = student.temporary_id;
            document.getElementById('category_id').value = student.category_id;
            document.getElementById('version_id').value = student.version_id;
            document.getElementById('shift_id').value = student.shift_id;
            document.getElementById('birth_registration_number').value = student.birth_registration_number;
            document.getElementById('dob').value = student.dob;
            document.getElementById('gender').value = student.gender;
            document.getElementById('mobile').value = student.mobile;
            document.getElementById('payment_status').value = student.payment_status;

            const editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        }


        function sendSMS(id) {
            var url = "{{ route('sendSmsForTemporaryID') }}";
            Swal.fire({
                title: "Do you want to Send an SMS?",
                showCancelButton: true,
                confirmButtonText: "Save",
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: url,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id
                        },
                        success: function(response) {

                            $.LoadingOverlay("hide");
                            console.log(response);
                            if (response == 0) {
                                Swal.fire({
                                    title: "Error",
                                    text: "No Data Found",
                                    icon: "warning"
                                });
                            }
                            Swal.fire({
                                title: "Success",
                                text: "SMS Send Successfully",
                                icon: "success"
                            });

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

        }
    </script>
    <script>
        function printTable() {

            // Trigger the print window for the card-body section
            const content = document.querySelector('.card-body');
            const printWindow = window.open('', '');

            printWindow.document.write('<html><head><title>Print</title>');
            printWindow.document.write(
                '<style>/* Add custom print styles here */ body {font-family: Arial, sans-serif;} .table {width: 100%; border-collapse: collapse;} .table-bordered {border: 1px solid #ddd;} th, td {padding: 8px; text-align: center;} th {background-color: #f2f2f2;}</style>'
            );
            printWindow.document.write('</head><body>');
            printWindow.document.write(content.innerHTML);
            printWindow.document.write('</body></html>');

            printWindow.document.close(); // Necessary for IE >= 10

            // Wait for the document to be fully loaded, then trigger the print
            printWindow.onload = function() {
                printWindow.print();
                // Show the print button again after printing
                printButton.style.display = 'inline-block';
            };
        }
    </script>
@endsection
