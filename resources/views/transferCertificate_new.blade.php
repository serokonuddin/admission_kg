<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Transfer Certificate</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: "Roboto", sans-serif;
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
        .table th,
        {
        border: 0px solid #000;
        /* padding: 8px; */
        /* padding-top: 17px; */

        }

        p {
            font-size: 12px !important;
        }


        .pt {
            padding-top: 20px;
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
                </tr>
            </table>
            <div style="height: 200px;">&nbsp;</div>
        </div>
        <br>
        <table class="table body">
            <tr>
                <td style="text-align: left; font-size: 17px">Serial:
                    <span>{{ $student->student_code }}-{{ date('m') }}-{{ date('y') }}</span>
                </td>
                <td style="text-align: right; font-size: 16px;">Issue Date:<span>
                        {{ now()->format('M d, Y') }}</span>
                </td>
            </tr>
            <br>
            <tr>
                <td style="padding-bottom: 25px"></td>
            </tr>
            <br>
            <tr>
                <td style="width: {{ $studentActivity->group_id != null ? '26%' : '28%' }}" class="pt">
                    This is to certify that
                </td>
                <td style="border-bottom: 2px dotted #000; text-align: center; width: {{ $studentActivity->group_id != null ? '74%' : '72%' }}"
                    class="pt">
                    <span>{{ strtoupper($student->first_name) }}</span>
                </td>
            </tr>

            <br>
            <tr>
                <td class="pt">{{ $student->gender == 1 ? 'son' : 'daughter' }} of (Father) </td>
                <td colspan="3" style="border-bottom: 2px dotted #000;text-align:center" class="pt">
                    <span>{{ strtoupper($student->father_name) }} </span>
                </td>

            </tr>
            <br>
            <tr>
                <td class="pt">and (Mother) </td>
                <td colspan="2" style="border-bottom: 2px dotted #000;text-align:center;" class="pt">
                    <span>{{ strtoupper($student->mother_name) }} </span>
                </td>
                <td style="text-align: right;width: 10%" class="pt">was a</td>
            </tr>
            <br>
            <tr>
                <td class="pt">
                    student of Class:

                    <span style="border-bottom: 2px dotted #000;text-align:center">
                        @if ($studentActivity->group_id == null)
                            &nbsp;
                        @endif
                        &nbsp;{{ $roman[$studentActivity->class_code] }}&nbsp;
                        @if ($studentActivity->group_id == null)
                            &nbsp;
                        @endif
                    </span>
                </td>
                <td class="pt">
                    @if ($studentActivity->group_id != null)
                        Group:&nbsp;
                        <span style="border-bottom: 2px dotted #000; display: inline-block; width: 50%">
                            @if ($studentActivity->group_id != 3)
                                &nbsp;&nbsp;
                            @else
                                &nbsp;
                            @endif
                            {{ isset($studentActivity->group_id) ? $groupdata[$studentActivity->group_id] : '' }}
                            @if ($studentActivity->group_id != 3)
                                &nbsp;&nbsp;
                            @endif
                        </span>
                    @endif
                    @if ($studentActivity->group_id == null)
                        &nbsp;&nbsp;
                    @endif
                    &nbsp;Version:
                    @if ($studentActivity->group_id == null)
                        &nbsp;
                    @endif
                    <span style="border-bottom: 2px dotted #000; display: inline-block;">
                        @if ($studentActivity->group_id != 3)
                            &nbsp;&nbsp;
                        @else
                            &nbsp;
                        @endif
                        @if ($studentActivity->group_id == null)
                            &nbsp;&nbsp;
                        @endif
                        {{ $studentActivity->version_id == 1 ? 'Bangla' : 'English' }}
                        @if ($studentActivity->group_id != 3)
                            &nbsp;&nbsp;
                        @else
                            &nbsp;
                        @endif
                        @if ($studentActivity->group_id == null)
                            &nbsp;&nbsp;
                        @endif
                    </span>
                    @if ($studentActivity->group_id == null)
                        &nbsp;&nbsp;
                    @endif
                    &nbsp;Section:
                    @if ($studentActivity->group_id == null)
                        &nbsp;
                    @endif
                    <span style="border-bottom: 2px dotted #000; display: inline-block; ">
                        @if ($studentActivity->group_id != 3)
                            &nbsp;&nbsp;
                            {{-- @else
                            &nbsp; --}}
                        @endif
                        @if ($studentActivity->group_id == null)
                            &nbsp;
                        @endif
                        {{ $studentActivity->section->section_name }}
                        @if ($studentActivity->group_id != 3)
                            &nbsp;
                            {{-- @else
                            &nbsp; --}}
                        @endif
                        @if ($studentActivity->group_id == null)
                            &nbsp;
                        @endif
                    </span>
                </td>
            </tr>
            <br>
            <tr>
                <td class="pt">
                    Class Roll:
                    <span style="border-bottom: 2px dotted #000;text-align:center;">
                        @if ($studentActivity->group_id == null)
                            &nbsp;
                        @endif
                        &nbsp;
                        {{ $studentActivity->roll }}
                        &nbsp;
                        @if ($studentActivity->group_id == null)
                            &nbsp;
                        @endif
                    </span>
                </td>
                <td class="pt">
                    @if ($studentActivity->group_id == null)
                        &nbsp;
                    @endif
                    and Session:&nbsp;&nbsp;
                    <span style="border-bottom: 2px dotted #000;text-align:center;">
                        &nbsp;&nbsp;&nbsp;
                        @if ($studentActivity->group_id != null)
                            &nbsp;
                        @endif
                        @if ($studentActivity->class_code < 11)
                            &nbsp;
                        @endif
                        <?php
                        if ($studentActivity->class_code > 10) {
                            $year = $studentActivity->session_id;
                            $nextYear = $year + 1;
                            $academicYear = $year . '-' . substr($nextYear, -2);
                            echo $academicYear;
                        } else {
                            echo $studentActivity->session_id;
                        }
                        ?>
                        @if ($studentActivity->class_code < 11)
                            &nbsp;
                        @endif
                        &nbsp;&nbsp;
                        @if ($studentActivity->group_id != null)
                        @endif
                    </span>
                    &nbsp; of this college. {{ $student->gender == 1 ? 'He' : 'She' }}
                    has cleared
                </td>
            </tr>
        </table>
        <br>

        <p style="font-size:18px;text-align: justify!important;white-space: normal!important;margin-top:0px!important;">
            all &nbsp; dues &nbsp; of &nbsp; this &nbsp; institution &nbsp; upto&nbsp;
            <span
                style="border-bottom: 2px dotted #000;text-align:center">&nbsp;&nbsp;{{ now()->format('F, Y') }}&nbsp;&nbsp;</span>.
        </p>
        <br>
        <p
            style="font-size:17px;text-align: justify!important;white-space: normal!important;margin-top:0px!important;padding-top:0px!important; line-height:2.8rem;">
            {{ $student->gender == 1 ? 'He' : 'She' }} bears a good moral character and to the best of my knowledge,
            {{ $student->gender == 1 ? 'he' : 'she' }} did not take part in any activity subversive of the state or of
            discipline.
        </p>
        <br>
        <table class="table body">
            <tr>
                <td tyle="text-align: justify!important;white-space: normal!important;font-size:17px; ">
                    I wish {{ $student->gender == 1 ? 'him' : 'her' }} every success in life.
                </td>
            </tr>
        </table>
        <br><br>
        <table class="table body" style="margin-top:170px;">
            <tr>
                <td style="width: 33%;border-bottom: 1px solid #000"></td>
                <td style="width: 34%"></td>
                <td style="width: 33%;border-bottom: 1px solid #000"></td>
            </tr>
        </table>
    </div>
</body>

</html>
