@extends('frontend-new.layout')
@section('content')
    <style>
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2 !important;
        }

        /* .table-striped tr:nth-child(even) {
                            background-color: #f9f9f9;
                        } */
        .table-bordered th,
        .table-bordered td {
            border: 1px solid #000 !important;
        }

        .table-no-bordered tr,
        .table-no-bordered,
        .table-no-bordered th,
        .table-no-bordered td,
        .table-no-bordered tbody {
            border: 0px solid #fff !important;
        }

        p {
            margin: 0px !important;
            padding: 0px !important;
        }

        .text-center {
            text-align: center !important;
        }

        .baf2 td,
        .baf3 td,
        .baf4 td {
            background-color: #00ADEF !important;
        }

        .baf1.shift1.version1 td {
            background-color: #FEF101 !important;
        }

        .baf1.shift1.version2 td {
            background-color: orange !important;
        }

        .baf1.shift2.version1 td {
            background-color: rgb(190, 144, 212) !important;
        }

        .baf1.shift2.version2 td {
            background-color: #74A440 !important;
        }

        .background-image {
            background-color: white;
        }
    </style>
    <div class="container spacet20 background-image">
        <div class="row">
            <div class="col-md-12 spacet60 pt-0-mobile">
                @php
                    $classroman = [
                        '0' => 'KG',
                        '1' => 'I',
                        '2' => 'II',
                        '3' => 'III',
                        '4' => 'IV',
                        '5' => 'V',
                        '6' => 'VI',
                        '7' => 'VII',
                        '8' => 'VIII',
                        '9' => 'IX',
                        '10' => 'X',
                        '11' => 'XI',
                        '12' => 'XII',
                        '' => '',
                    ];
                    $category = [
                        1 => 'Civil',
                        2 => 'BAF Employee',
                        3 => 'BAFSD Employee',
                        4 => 'GEN',
                        '' => '',
                    ];
                    function calculateAge($birthDate)
                    {
                        $birthDate = new DateTime($birthDate);
                        $currentDate = new DateTime('2025-01-01');

                        $ageDifference = $currentDate->diff($birthDate);

                        $years = $ageDifference->y;
                        $months = $ageDifference->m;
                        $days = $ageDifference->d;

                        return $years . ' years, ' . $months . ' months, and ' . $days . ' days.';
                    }
                @endphp
                <table class="table table-striped table-no-bordered">
                    <tr>
                        <td style="width: 20%"></td>
                        <td style="width: 55%;text-align:center">
                            <img style="width: 80px" src="{{ $academy_info->logo }}" />
                            <h3
                                style="margin-top: 0px; margin-bottom: 4px; color:#0484BD; font-size:21px; font-weight:bold; white-space: nowrap;">
                                {{ $academy_info->academy_name }}</h3>
                            <span style="text-align:center; margin-top: 0px; margin-bottom: 0px; font-size:14px;">
                                {{ $academy_info->address }}
                            </span>

                        </td>
                        <td style="width: 25%;vertical-align: top;text-align: right">
                            @if ($student)
                                <img style="width: 100px;float: right;" src="{{ asset($student->photo) }}" />
                            @endif
                        </td>
                    </tr>
                </table>
                <table class="table table-striped table-no-bordered">
                    <tr>
                        <td style="width: 30%;border: 2px solid #c0c0c0 !important;">
                            <div style="font-weight: bold;font-size: 14px;padding: 10px;">
                                &nbsp;&nbsp;Serial Number: {{ $student->temporary_id ?? '' }}&nbsp;&nbsp;
                            </div>
                        </td>
                        <td style="width: 50%;">
                            <h3
                                style="color:red; margin-top: 5px; margin-bottom: 0px; font-size:18px; font-weight:bold; white-space: nowrap;">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Admit Card</h3>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;Class {{ $classroman[$student->class_id ?? ''] }}, Session:
                                {{ (int) $session->session_name + 1 }}</p>
                        </td>

                    </tr>
                </table>
                <table
                    class="table table-striped table-no-bordered baf{{ $student->category_id ?? '' }} shift{{ $student->shift_id ?? '' }} version{{ $student->version_id ?? '' }}">
                    <tr style="border: 2px solid #c0c0c0 !important">
                        <td class="text-center">Shift: {{ $student && $student->shift_id == 1 ? 'Morning' : 'Day' }}</td>
                        <td class="text-center">Version: {{ $student && $student->version_id == 1 ? 'Bangla' : 'English' }}
                        </td>
                        <td class="text-center">Gender: {{ $student && $student->gender == 1 ? 'Male' : 'Female' }}</td>
                        <td class="text-center">Category: {{ $category[$student->category_id ?? ''] }}</td>
                    </tr>
                </table>
                <table class="table table-striped table-no-bordered">

                    <tbody>
                        <tr style="border: 2px solid #c0c0c0 !important">
                            <td style="width:35%">Candidate's Name</td>
                            <td>: {{ $student ? strtoupper($student->name_en) : '' }}</td>
                        </tr>
                        <tr style="border: 2px solid #c0c0c0 !important">
                            <td>Date Of Birth</td>
                            <td>: {{ date('d F Y', strtotime($student->dob ?? '')) }}</td>
                        </tr>
                        <tr style="border: 2px solid #c0c0c0 !important">
                            <td>Age</td>
                            <td>: {{ calculateAge($student->dob ?? '') }}</td>
                        </tr>
                        <tr style="border: 2px solid #c0c0c0 !important">
                            <td>Gurdian's Name</td>
                            <td>: {{ $student->gurdian_name ?? '' }}</td>
                        </tr>
                        <tr style="border: 2px solid #c0c0c0 !important">
                            <td>Mobile Number</td>
                            <td>: {{ $student->mobile ?? '' }}</td>
                        </tr>
                        <tr style="border: 2px solid #c0c0c0 !important">
                            <td>Candidate's Birth Registration Number</td>
                            <td>: {{ $student->birth_registration_number ?? '' }}</td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-striped table-no-bordered " style="border: 2px solid #c0c0c0 !important">
                    <tr>
                        <td style="width:35%">

                            @if ($student && in_array($student->category_id, [2, 3, 4]))
                                Viva Date & Time
                            @elseif($student && $student->category_id == 1 && $student->version_id == 1)
                                Lottery Date & Time
                            @elseif($student && $student->category_id == 1 && $student->version_id == 2)
                                Lottery Date & Time
                            @endif
                        </td>
                        <td>:
                            @if ($student && in_array($student->category_id, [2, 3, 4]))
                                8th November, 10:00 AM
                            @elseif($student && $student->category_id == 1 && $student->version_id == 1)
                                30th November 10:00 AM To 11:00 AM
                            @elseif($student && $student->category_id == 1 && $student->version_id == 2)
                                30th November 12:00 AM To 01:00 PM
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Venue</td>
                        <td>: {{ $academy_info->academy_name }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">N.B. Candidate must bring a printed color Admit Card at the time of Lottery &
                            Viva</td>
                    </tr>
                </table>
                <br />
                <br />
                <br />
                <table class="table table-striped table-no-bordered ">
                    <tr>
                        <td style="float: right;padding:0px"></td>
                        <td style="float: right;padding:0px;text-align: right"><img src="{{ asset('public/psi.jpg') }}"
                                style="width: 90px;" /></td>
                    </tr>
                    <tr>
                        <td style="float: left;padding:0px">
                            @if ($student)
                                <a href="{{ url('admissionPrint/' . $student->temporary_id . '/0') }}" target="_blank"
                                    class="btn btn-primary findAdmitcard" style="background-color: #00ADEF">Print Admit
                                    Card</a>
                                <a href="{{ url('admissionPrint/' . $student->temporary_id . '/1') }}" target="_blank"
                                    class="btn btn-primary findAdmitcard" style="background-color: green">Save Admit
                                    Card</a>
                            @endif
                        </td>
                        <td style="float: right;padding:0px;font-size: 18px;font-weight: bold;text-align: right">Principal
                        </td>
                    </tr>
                </table>


            </div>
        </div>
        <!--./row-->
    </div>



    <script>
        @if (Session::get('success'))

            Swal.fire({
                title: "Success",
                html: "{!! Session::get('success') !!}",
                icon: "success"
            });
        @endif


        @if (Session::get('warning'))

            Swal.fire({
                title: "Warning!",
                html: "{!! Session::get('warning') !!}",
                icon: "warning"
            });
        @endif
    </script>
@endsection
