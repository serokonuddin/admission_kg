<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer Certificate</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
            border: 0px solid #000;
        }

        .header,
        .footer {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .content {
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0px;
        }

        .table td,
        .table th {
            border: 0px solid #000;
            padding: 8px;

        }

        p {
            font-size: 12px !important;
        }

        .transfer-title h2 {
            font-family: initial;
            font-size: 20px;
            color: #990000;
            padding: 10px 20px;
            background-color: #ffe6e6 !important;
            border: 2px solid #990000;
            display: inline-block;
            font-weight: bold;
            border-radius: 10px
        }

        .body td {
            font-size: 18px !important;
        }
    </style>
</head>
@php
    $roman[0] = 'Kg';
    $roman[1] = 'I';
    $roman[2] = 'II';
    $roman[3] = 'III';
    $roman[4] = 'IV';
    $roman[5] = 'V';
    $roman[6] = 'VI';
    $roman[7] = 'VII';
    $roman[8] = 'VIII';
    $roman[9] = 'IX';
    $roman[10] = 'X';
    $roman[11] = 'XI';
    $roman[12] = 'XII';
    $groupdata = [1 => 'Science', 2 => 'Humanities', 3 => 'Business Studies'];
@endphp

<body>
    <div class="container">
        <div class="header">
            <table class="table">
                <tr>
                    {{-- <td><img src="{{ asset('public/frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png') }}" style="width: 100px;height: auto;" alt="College Logo"><td>
                    <td style="vertical-align: top;text-align: center">
                        <h1
                    style="font-weight: bold;
        font-family: algerian!important;font-weight: bold;line-height: 25px;color: #00ADEF"
                    >BAF Shaheen College Dhaka</h1>
                    <p style="text-align: center!important">Jahangir Gate, Dhaka Cantonment, Dhaka-1206</p>
            <p style="text-align: center!important">Phone: 9858440, 8753420 Ext-5561 Cell: 01769975771</p>
            <p style="text-align: center!important">Web: www.bafsd.edu.bd, Email: info@bafsd.edu.bd</p>
                    <td>
                    <td style="width: 100px"><td> --}}
                </tr>
            </table>
            <div style="height: 200px;">&nbsp;</div>
            {{-- <table class="table">
                <tr>
                    <td style="width: 100px;"><td>
                    <td style="vertical-align: top;text-align: center;">
                    <div class="transfer-title">

                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="{{ asset('public/tc_image.jpg') }}" style="width: 40%;height: auto;" alt="Tc Logo">
                    </div>
                    <td>
                    <td style="width: 100px"><td>
                </tr>
            </table> --}}
        </div>



        <table class="table body">

            <tr>
                <td>Serial: <strong>{{ $student->student_code }}-{{ date('m') }}-{{ date('y') }}</strong></td>

                <td style="text-align: right" colspan="3">Issue Date:<strong> {{ now()->format('M d, Y') }}</strong>
                </td>
            </tr>
            <tr>
                <td>This is to certify that</td>
                <td colspan="3" style="border-bottom: 1px solid #000;text-align:center">
                    <span style="font-weight: bold">{{ $student->first_name }} </span>
                </td>

            </tr>
            <tr>
                <td>{{ $student->gender == 1 ? 'son' : 'daughter' }} of (Father) </td>
                <td colspan="3" style="border-bottom: 1px solid #000;text-align:center">
                    <span style="font-weight: bold">{{ $student->father_name }} </span>
                </td>

            </tr>

            <tr>
                <td>and (Mother) </td>
                <td colspan="2" style="border-bottom: 1px solid #000;text-align:center">
                    <span style="font-weight: bold">{{ $student->mother_name }} </span>
                </td>
                <td style="text-align: right;width: 10%">was a</td>
            </tr>
            <tr>
                <td>student of Class <span style="font-weight: bold">{{ $roman[$studentActivity->class_code] }}</span>
                </td>
                <td colspan="3">
                    Group&nbsp;&nbsp; <span
                        style="font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $groupdata[$studentActivity->group_id] }}&nbsp;&nbsp;&nbsp;&nbsp;</span>

                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Version&nbsp;&nbsp; <span
                        style="font-weight: bold">&nbsp;{{ $studentActivity->version_id == 1 ? 'Bangla' : 'English' }}&nbsp;</span>
                </td>

            </tr>
            <tr>
                <td>Section&nbsp;&nbsp;&nbsp;<span
                        style="font-weight: bold">&nbsp;{{ $studentActivity->section->section_name }}</span></td>
                <td colspan="3">
                    Class Roll <span
                        style="font-weight: bold">&nbsp;&nbsp;{{ $studentActivity->roll }}&nbsp;&nbsp;&nbsp;</span>


                    and Session <span style="font-weight: bold">
                        <?php
                        $year = $studentActivity->session_id;
                        $nextYear = $year + 1;
                        $academicYear = $year . '-' . substr($nextYear, -2);

                        echo $academicYear; // Outputs: 2024-25
                        ?>
                    </span>
                </td>
            </tr>
        </table>
        <table class="table body" style="margin-top:0px!important;paddint-top:0px!important">
            <tr>
                <td tyle="text-align: justify!important;white-space: normal!important; ">
                </td>
            </tr>
        </table>
        <p
            style="font-size:18px;text-align: justify!important;white-space: normal!important;padding-left:5px;margin-top:0px!important;padding-top:0px!important;">
            of &nbsp; this &nbsp; college. &nbsp; {{ $student->gender == 1 ? 'He' : 'She' }} &nbsp; has &nbsp; cleared
            &nbsp; all &nbsp; dues &nbsp; of &nbsp; this &nbsp; institution &nbsp; upto
            <br><strong>{{ now()->format('F, Y') }}</strong>.</p>
        <p
            style="font-size:18px;text-align: justify!important;white-space: normal!important;padding-left:5px;margin-top:0px!important;padding-top:0px!important;">
            {{ $student->gender == 1 ? 'He' : 'She' }} bears a good moral character and to the best of my knowledge,
            {{ $student->gender == 1 ? 'He' : 'She' }} did not take part in any activity subversive of the state or of
            discipline.</p>
        <table class="table body">
            <tr>
                <td tyle="text-align: justify!important;white-space: normal!important; ">

                    I wish {{ $student->gender == 1 ? 'Him' : 'Her' }} every success in life.

                </td>
            </tr>
        </table>
        <table class="table body" style="margin-top:170px;">
            <tr>
                <td style="width: 33%;border-bottom: 1px solid #000">
                </td>
                <td style="width: 34%">

                </td>
                <td style="width: 33%;border-bottom: 1px solid #000">
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
