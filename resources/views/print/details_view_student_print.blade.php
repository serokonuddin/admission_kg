<!doctype html>
<html>

<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>BAF Shanheen College Dhaka</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/backend_css/bootstrap.min.css') }}" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style type="text/css">
        a {
            text-decoration: none
        }

        body {
            /* font-family: 'NikoshBAN'; */
            font-size: 15px;
            /*font-size: 14px !important;*/
        }

        #bangla {
            font-family: 'NikoshBAN';
        }

        tr.sectorvaluefonts td span {

            /* font-family: 'NikoshBAN'; */
        }

        @page {
            header: page-header;
            footer: page-footer;
            sheet-size: A4;
            margin: 1.54cm 1.54cm 1.54cm 1.54cm;

        }

        table {
            /* font-family: "NikoshBAN"; */
            border: none;
            border-collapse: collapse;
            width: 100%;
            font-size: 15px;
        }

        th,
        td {
            padding: 1px !important;
            border: 1px solid #000;
            vertical-align: top;
        }

        th {
            text-align: center;
        }

        .fake {
            border: 0px;
            width: 0px !important;
            visibility: hidden;
            padding: 0px !important;
            font-size: 0px;
        }

        .no-subsector {
            border: 0px;
            visibility: hidden;
            padding: 0px !important;
            font-size: 0px !important;
            background-color: yellow;
        }

        div.fake {
            display: none !important;
            ;
            font-size: 0px !important;
        }


        .noboder {
            border: 0px;
            padding: 5px;
            font-weight: bold;
            font-size: 15px;

        }

        .sectorhide0 {
            border: 0px;
            width: 0px !important;
            visibility: hidden;
            padding: 0px !important;
        }

        .rahenrashi {
            font-family: 'NikoshBAN';
        }

        tr td {
            /* font-family: 'NikoshBAN'; */
        }
    </style>
    @php
        $genders = [1 => 'Male', 2 => 'Female', 3 => 'Others'];
        $bloods = [1 => 'Islam', 2 => 'Hindu', 3 => 'christian', 4 => 'Buddhism', 5 => 'Others'];
    @endphp
    <style>
        .table th,
        .table td {
            text-align: center !important;
            vertical-align: top !important;
            border-top: 1px solid #000 !important;
            border-left: 1px solid #000 !important;
        }

        .table td:last-child,
        .table th:last-child {
            border-right: 1px solid #000 !important;
        }

        .table tr:last-child {
            border-bottom: 1px solid #000 !important;
        }

        #projecttitle {
            text-align: left !important;
            padding-left: 5px !important;
        }

        .x-footer {
            width: 100%;
            border: 0 none !important;
            border-collapse: collapse;
        }

        .x-footer td {
            border: 0 none !important;
        }

        .nowrap {
            white-space: nowrap;
        }

        .head span {
            display: inline;
        }

        td {
            font-size: 15px !important;
            height: 30px !important;
        }
    </style>

</head>

<body>
    <div class="flex-center position-ref full-height">
        <table style="border:0px">
            <tr>
                <td style="width:13.33%;border:0px;text-align:left">
                    <img src="{{ asset('public/frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png') }}"
                        style="width: auto;height: 80px;" />
                </td>
                <td class="head" style="width:73.33%;border:0px;text-align:center;">
                    <h2 style="color: rgb(0,173,239)">BAF Shaheen College Dhaka</h2>
                    <span>Dhaka Cantonmnet, Dhaka-1206</span>
                    <br /><span>Web: www.bafsd.edu.bd</span><br />
                    <span>Email: info@bafsd.edu.bd</span>
                </td>
                <td style="width:13.33%;border:0px;text-align:right">
                    <img src="{{ $student->photo ?? '' }}" id="photo_preview" style="height: 80px; width: auto" />
                </td>
            </tr>
        </table>
        <table style="border:0px">
            <tr>
                <td
                    style="width:100%;border:0px;font-size: 15pt;text-align:center;color: rgb(0,173,239);font-weight: bold">
                    Admission Form</td>

            </tr>
            <tr>
                @if ($activity->class_id < 11)
                    <td style="width:100%;border:0px;font-size: 13pt;text-align:center;"> (KG Admission:
                        {{ $activity->session_id }})</td>
                @else
                    <td style="width:100%;border:0px;font-size: 13pt;text-align:center;"> (College Admission:
                        {{ $activity->session_id . '-' . ($activity->session_id + 1) }})</td>
                @endif


            </tr>

        </table>
        <table style="border:0px;margin-top: 20px;">

            <tr styel="padding: 10px;">
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold">1.</td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;font-weight: bold">Student's Name
                    (English): {{ $student->first_name ?? '' }}

                </td>
                <td class="rahenrashi" style="padding: 10px;width:48%;border:0px;font-size: 11pt;font-weight: bold">
                    Student's Name (Bangla): {{ $student->bangla_name ?? '' }}


                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Date of Birth:
                    {{ $student->birthdate ?? '' }}


                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Birth Registration No:
                    {{ $student->birth_no ?? '' }}


                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Religion:
                    {{ $bloods[$student->religion] ?? '' }}</td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Nationality:
                    {{ $student->nationality ?? '' }}


                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">E-mail: {{ $student->email ?? '' }}

                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Mobile: {{ $student->mobile ?? '' }}
                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Gender:
                    {{ $genders[$student->gender] ?? '' }}</td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Blood: {{ $student->blood ?? '' }}</td>
            </tr>
            @if ($activity->classes->class_code == 11 || $activity->classes->class_code == 12)
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold">2.</td>
                    <td colspan="2" style="padding: 10px;width:96%;border:0px;font-size: 11pt;font-weight: bold">
                        Desired Subject (According to the college prospectus)</td>

                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">


                        COMPULSORY SUBJECTS:<br />
                        @php $roman=[0=>'i',1=>'ii',2=>'iii',3=>'iv',4=>'v',5=>'vi',6=>'vii'];@endphp
                        @foreach ($comsubjects as $key => $subject)
                            {{ $roman[$loop->index] }}. {{ $key }}<br />
                        @endforeach
                        <br />
                        GROUP SUBJECTS:<br />
                        @foreach ($groupsubjects as $key => $subject)
                            {{ $roman[$loop->index] }}. {{ $key }}<br />
                        @endforeach
                    </td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">ELECTIVE SUBJECT(S):<br />

                        @foreach ($student_third_subject as $key => $subject)
                            {{ $roman[$loop->index] }}. {{ $key }}<br />
                        @endforeach
                        <br />
                        4TH SUBJECT:<br />
                        @foreach ($student_fourth_subject as $key => $subject)
                            {{ $roman[$loop->index] }}. {{ $key }}<br />
                        @endforeach


                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold">3.</td>
                    <td colspan="2" style="padding: 10px;width:96%;border:0px;font-size: 11pt;font-weight: bold">
                        Secondary (SSC) Exam Details:</td>

                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Name of School:
                        {{ $student->school_name ?? '' }}


                    </td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Upozila/Thana:
                        {{ $student->thana ?? '' }}


                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Exam Center:
                        {{ $student->exam_center ?? '' }}



                    </td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Roll Number:
                        {{ $student->roll_number ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Registration Number:
                        {{ $student->registration_number ?? '' }}


                    </td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Session:
                        {{ $student->session ?? '' }}


                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Board's Name:
                        {{ $student->board ?? '' }}</td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Year of Passing:
                        {{ $student->passing_year ?? '' }}


                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">GPA: {{ $student->result ?? '' }}


                    </td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">GPA without 4th subject:
                        {{ $student->result_fourth_subject ?? '' }}


                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Total Marks:
                        {{ $student->total_mark ?? '' }}


                    </td>
                </tr>
            @endif
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold">3.</td>
                <td colspan="2" style="padding: 10px;width:96%;border:0px;font-size: 11pt;font-weight: bold">Parent's
                    Information:</td>

            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Father's Name:
                    {{ $student->father_name ?? '' }}


                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Father's Email:
                    {{ $student->father_email ?? '' }}


                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Father's Phone:
                    {{ $student->father_phone ?? '' }}


                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Father's Profession:
                    {{ $student->father_profession ?? '' }}



                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">FATHER'S NID NUMBER:
                    {{ $student->father_nid_number ?? '' }}


                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">

                </td>
            </tr>

            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Mother's Name:
                    {{ $student->mother_name ?? '' }}


                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Mother's Email:
                    {{ $student->mother_email ?? '' }}


                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Mother's Phone:
                    {{ $student->mother_phone ?? '' }}


                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Mother's Profession:
                    {{ $student->mother_profession ?? '' }}


                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Mother'S NID NUMBER:
                    {{ $student->mother_nid_number ?? '' }}


                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">

                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Parent's Income:
                    {{ $student->parent_income ?? '' }}

                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">SMS Notificaton:
                    {{ $student->sms_notification ?? '' }}</td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold">4.</td>
                <td colspan="2" style="padding: 10px;width:96%;border:0px;font-size: 11pt;font-weight: bold">Address
                </td>

            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Present Address:
                    {{ $student->present_addr ?? '' }}


                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Police Station:
                    {{ $student->present_police_station ?? '' }}


                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Present District:
                    {{ $student->present->name ?? '' }}</td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Permanent Address:
                    {{ $student->permanent_addr ?? '' }}


                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Police Station:
                    {{ $student->permanent_police_station ?? '' }}


                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Permanent District:
                    {{ $student->permanent->name ?? '' }}</td>
            </tr>


            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold">5.</td>
                <td colspan="2" style="padding: 10px;width:96%;border:0px;font-size: 11pt;font-weight: bold">Local
                    Guardian</td>

            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Guardian Name:
                    {{ $student->local_guardian_name ?? '' }}

                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Guardian Mobile:
                    {{ $student->local_guardian_mobile ?? '' }}

                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Guardian Email:
                    {{ $student->local_guardian_email ?? '' }}

                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Relation:
                    {{ $student->student_relation ?? '' }}

                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Guardian Address:
                    {{ $student->local_guardian_address ?? '' }}

                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Police Station:
                    {{ $student->local_guardian_police_station ?? '' }}

                </td>
            </tr>

            @if ($student->categoryid == 2)
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold">6.</td>
                    <td colspan="2" style="padding: 10px;width:96%;border:0px;font-size: 11pt;font-weight: bold">
                        Special Information for Force:</td>

                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
					<td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Category: <span>Son/daughter of
                            Armed Forces' Member</span>
                    </td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Service
                        Number:{{ $student->service_number ?? '' }}
                    </td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Rank/Designation:
                        {{ $student->designation ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Name: {{ $student->name ?? '' }}


                    </td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">

                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Force Name:
                        {{ $student->arms_name ?? '' }}


                    </td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Serving/Retired: @if ($student->is_service)
                            {{ $student->is_service == 1 ? 'Serving' : 'Retired' }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Office Address:
                        {{ $student->office_address ?? '' }}


                    </td>
                </tr>
            @elseif($student->categoryid == 3)
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold">6.</td>
                    <td colspan="2" style="padding: 10px;width:96%;border:0px;font-size: 11pt;font-weight: bold">
                        Special information for Parent:</td>

                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">NAME OF THE
                        STAFF:{{ $student->name_of_staff ?? '' }}

                    </td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">DESIGNATION:
                        {{ $student->staff_designation ?? '' }}


                    </td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Category: <span>Son/daughter of
                            Teaching/Non-Teaching staff of BAFSD</span>


                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">STAFF ID:
                        {{ $student->staff_id ?? '' }}

                    </td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">
                    </td>
                </tr>
            @else
               <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold">6.</td>
                    <td colspan="2" style="padding: 10px;width:96%;border:0px;font-size: 11pt;font-weight: bold">
                        Special information for Parent:</td>

                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Category: Civil
                    </td>
                </tr>
            @endif
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold">7.</td>
                <td colspan="2" style="padding: 10px;width:96%;border:0px;font-size: 11pt;font-weight: bold">
                    Academic Information:</td>

            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Session:
                    {{ $activity->session_id ?? '' }}</td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Version:
                    {{ $activity->version->version_name ?? '' }}</td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Shift:
                    {{ $activity->shift->shift_name ?? '' }}</td>
				<td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Group:
                    {{ $activity->group->group_name ?? '' }}</td>
				<!--
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Category:
                    {{ $activity->category->category_name ?? '' }}</td> -->
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">House:
                    {{ $activity->house->house_name ?? '' }}</td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Class:
                    {{ $activity->classes->class_name ?? '' }}</td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Section:
                    {{ $activity->section->section_name ?? '' }}</td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Roll: {{ $activity->roll ?? '' }}</td>
            </tr>
			<!--
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Group:
                    {{ $activity->group->group_name ?? '' }}</td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;"></td>
            </tr> -->

        </table>




    </div>
    <htmlpagefooter name="page-footer">
        <table class="x-footer">

            <tr>
                <td style="width: 50%;text-align: left;">{{ date('d-m-Y H:s') }}</td>
                <td style="text-align: right;">@lang('Page') ({PAGENO}/{nb})</td>
            </tr>

        </table>


    </htmlpagefooter>
</body>

</html>
