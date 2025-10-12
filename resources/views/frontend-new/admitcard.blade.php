<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

        /* .table-striped tr:nth-child(even) {
            background-color: #f9f9f9;
        } */
        .table-bordered th,
        .table-bordered td {
            border: 1px solid #000;
        }

        .table-no-bordered th,
        .table-no-bordered td {
            border: 0px solid #fff;
        }

        p {
            margin: 0px;
            padding: 0px;
        }

        .text-center {
            text-align: center !important;
        }

        .baf2 td,
        .baf3 td,
        .baf4 td {
            background-color: #00ADEF;
        }

        .baf1.shift1.version1 td {
            background-color: #FEF101;
        }

        .baf1.shift1.version2 td {
            background-color: orange;
        }

        .baf1.shift2.version1 td {
            background-color: rgb(190, 144, 212);
        }

        .baf1.shift2.version2 td {
            background-color: #74A440;
        }
    </style>
</head>

<body>@php
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
    ];
    $category = [
        1 => 'Civil',
        2 => 'BAF Employee',
        3 => 'BAFSD Employee',
        4 => 'GEN',
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
                <img style="width: 80px" src="{{ $logoRelativePath }}" />
                <h3
                    style="margin-top: 0px; margin-bottom: 4px; color:#0484BD; font-size:21px; font-weight:bold; white-space: nowrap;">
                    {{ $academy_info->academy_name }}</h3>
                <span style="text-align:center; margin-top: 0px; margin-bottom: 0px; font-size:14px;">
                    {{ $academy_info->address }}
                </span>

            </td>
            @php
                $photo = $modified_url = str_replace('www.', '', $student->photo);
            @endphp
            <td style="width: 25%;vertical-align: top;text-align: right">
                <img style="width: 100px;float: right;" src="{{ $photo }}" />
            </td>
        </tr>
    </table>
    <table class="table table-striped table-no-bordered">
        <tr>
            <td style="width: 30%;border: 2px solid #eee;">
                <div style="font-weight: bold;font-size: 16px;padding: 10px;">
                    &nbsp;&nbsp;Serial Number: {{ $student->temporary_id }}&nbsp;&nbsp;
                </div>
            </td>
            <td style="width: 40%;">
                <h3
                    style="color:red; margin-top: 5px; margin-bottom: 0px; font-size:18px; font-weight:bold; white-space: nowrap;">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Admit Card</h3>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;Class {{ $classroman[$student->class_id] }}, Session:
                    {{ (int) $session->session_name + 1 }}</p>
            </td>
            <td style="width: 25%">

            </td>
        </tr>
    </table>
    <table
        class="table table-striped table-no-bordered baf{{ $student->category_id }} shift{{ $student->shift_id }} version{{ $student->version_id }}">
        <tr style="border: 2px solid #eee">
            <td class="text-center">Shift: {{ $student->shift_id == 1 ? 'Morning' : 'Day' }}</td>
            <td class="text-center">Version: {{ $student->version_id == 1 ? 'Bangla' : 'English' }}</td>
            <td class="text-center">Gender: {{ $student->gender == 1 ? 'Male' : 'Female' }}</td>
            <td class="text-center">Category: {{ $category[$student->category_id] }}</td>
        </tr>
    </table>
    <table class="table table-striped table-no-bordered">

        <tbody>
            <tr style="border: 2px solid #eee">
                <td style="width:35%">Candidate's Name</td>
                <td>: {{ strtoupper($student->name_en) }}</td>
            </tr>
            <tr style="border: 2px solid #eee">
                <td>Date Of Birth</td>
                <td>: {{ date('d F Y', strtotime($student->dob)) }}</td>
            </tr>
            <tr style="border: 2px solid #eee">
                <td>Age</td>
                <td>: {{ calculateAge($student->dob) }}</td>
            </tr>
            <tr style="border: 2px solid #eee">
                <td>Gurdian's Name</td>
                <td>: {{ $student->gurdian_name }}</td>
            </tr>
            <tr style="border: 2px solid #eee">
                <td>Mobile Number</td>
                <td>: {{ $student->mobile }}</td>
            </tr>
            <tr style="border: 2px solid #eee">
                <td>Candidate's Birth Registration Number</td>
                <td>: {{ $student->birth_registration_number }}</td>
            </tr>
        </tbody>
    </table>
    <table class="table table-striped table-no-bordered " style="border: 2px solid #eee">
        <tr>
            <td style="width:35%">

                @if (in_array($student->category_id, [2, 3, 4]))
                    Viva Date & Time
                @elseif($student->category_id == 1 && $student->version_id == 1)
                    Lottery Date & Time
                @elseif($student->category_id == 1 && $student->version_id == 2)
                    Lottery Date & Time
                @endif
            </td>
            <td>:
                @if (in_array($student->category_id, [2, 3, 4]))
                    8th November, 10:00 AM
                @elseif($student->category_id == 1 && $student->version_id == 1)
                    30th November 10:00 AM To 11:00 AM
                @elseif($student->category_id == 1 && $student->version_id == 2)
                    30th November 12:00 AM To 01:00 PM
                @endif
            </td>
        </tr>
        <tr>
            <td>Venue</td>
            <td>: {{ $academy_info->academy_name }}</td>
        </tr>
        <tr>
            <td colspan="2">N.B. Candidate must bring a printed color Admit Card at the time of Lottery & Viva</td>
        </tr>
    </table>
    <br />
    <br />
    <br />
    <table class="table table-striped table-no-bordered ">
        <tr>
            <td style="float: right;padding:0px"></td>
            <td style="float: right;padding:0px;text-align: right"><img src="{{ asset('public/principal.jpg') }}"
                    style="width: 90px;" /></td>
        </tr>
        <tr>
            <td style="float: right;padding:0px"></td>
            <td style="float: right;padding:0px;font-size: 18px;font-weight: bold;text-align: right">Principal</td>
        </tr>
    </table>
</body>

</html>
