<div class="" id="ReportBox">
    <div class="row onlineResultPartial" style="margin:0px;">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="pull-right">
                    <input type="button" class="btn  btn-success btn-panel-head"
                        onclick="printElem('StudentAcademicTranscriptDiv')" value="Print">
                </div>
            </div>
            <div class="panel-body">
                <div id="StudentAcademicTranscriptDiv">
                    <style>
                        .tableBorderNo {
                            border: 0px solid #FFF;
                        }

                        .tableCenter {
                            margin-left: auto;
                            margin-right: auto;
                        }

                        .noBorder {
                            width: 100%;
                        }

                        .noBorder tr,
                        td {
                            border: none;
                        }

                        .resultDetailsTable {
                            width: 100%;
                        }

                        .resultDetailsTable td,
                        .resultDetailsTable th {
                            border-top: 1px solid black;
                            border-left: 1px solid black;
                            border-bottom: 1px solid black;
                            border-right: 1px solid black;
                            padding: 3px;
                        }

                        .page-break {
                            display: block;
                            page-break-before: always;

                        }

                        .redtext {
                            color: red !important;
                        }



                        .rotate-text {
                            transform: rotate(270deg);
                            /* Adjust the degree of rotation as needed */
                            text-wrap: wrap;
                            height: 120px;
                        }
                    </style>
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
                        ];
                        function getGradeByMark($grades, $mark)
                        {
                            foreach ($grades as $grade) {
                                if ($mark >= $grade->start_mark && $mark <= $grade->end_mark) {
                                    return $grade;
                                }
                            }
                            return null;
                        }
                        function getGrade($point, $isnegative)
                        {
                            if ($isnegative == -1) {
                                return 'F';
                            }
                            if ($point == 5) {
                                return 'A+';
                            } elseif ($point >= 4 && $point < 5) {
                                return 'A';
                            } elseif ($point >= 3.5 && $point < 4) {
                                return 'A-';
                            } elseif ($point >= 3 && $point < 3.5) {
                                return 'B';
                            } elseif ($point >= 2 && $point < 3) {
                                return 'C';
                            } elseif ($point >= 1 && $point < 2) {
                                return 'D';
                            } else {
                                return 'F';
                            }
                        }
                        function getPoint($grades, $count, $isnegative)
                        {
                            if ($isnegative == -1) {
                                return 0.0;
                            }
                            return round($grades / $count, 2);
                        }
                    @endphp
                    @foreach ($students as $key => $student)
                        <div class="mobileScreenInfo" style="overflow-y:hidden; margin-bottom:20px;">
                            <table cellpadding="0" cellspacing="0"
                                style="width:100%; text-align:center; page-break-inside: avoid;" class="tableBorderNo">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table cellpadding="0" cellspacing="0" class="tableCenter tableBorderNo">
                                                <tbody>
                                                    <tr>
                                                        <td style="width:15%; text-align:center;">
                                                            <img src="{{ asset('public/frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png') }}"
                                                                style="width:100px;">
                                                        </td>
                                                        <td
                                                            style="width:70%; text-align:center; padding:0px 20px 0px 20px;">
                                                            <h3
                                                                style="margin-top: 0px; margin-bottom: 4px; color:#0484BD; font-size:24px; font-weight:bold; white-space: nowrap;">
                                                                BAF Shaheen College Dhaka</h3>
                                                            <span
                                                                style="text-align:center; margin-top: 0px; margin-bottom: 0px; font-size:14px;">
                                                                Dhaka Cantonment, Dhaka-1206
                                                            </span>
                                                            <h3 class="text-center"
                                                                style="color:red; margin-top: 5px; margin-bottom: 0px; font-size:20px; font-weight:bold; white-space: nowrap;">
                                                                Academic Transcript</h3>
                                                        </td>
                                                        <td style="width:15%; text-align:center;"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="printHead" style="font-family:'Times New Roman, Times, serif';  margin-top:5px;">
                            <div class="mobileScreenInfo">
                                <div style="">
                                    <table class="resultDetailsTable">
                                        <tbody>
                                            <tr>
                                                <td style="width:40%;" colspan="2">Student's Name
                                                    :{{ $student->first_name ?? '' }}</td>
                                                <td style="width:60%;" colspan="3">Class Teacher : MD. SADIDUL ISLAM
                                                    (01784005420)</td>

                                            </tr>
                                            <tr>
                                                <td>Version:
                                                    {{ $student->studentActivity->version->version_name ?? '' }}</td>
                                                <td>Class : {{ $student->studentActivity->class_code }}</td>
                                                <td>Section:
                                                    {{ $student->studentActivity->section->section_name ?? '' }}</td>
                                                <td>Roll : {{ $student->studentActivity->roll ?? '' }}</td>
                                                <td>Year : {{ $student->studentActivity->session->session_name ?? '' }}
                                                </td>

                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div style="text-align:center; padding-bottom:0px;">
                                <span style="font-weight:bold;font-size:17px; ">Result in Details</span><br />
                                <span style="font-weight:bold;font-size:17px; ">{{ $exam->exam_title }}</span>
                            </div>
                            @php
                                $isnegative = 0;
                                $markforcount = count($subjects);

                                $subjectwisemark = collect($student->subjectwisemark)->groupBy('subject_id');
                                $avaragemark = collect($student->avaragemark)->groupBy('subject_id');
                                $halfExam = collect($student->halfExam)->groupBy('subject_id');

                            @endphp
                            <div class="mobileScreen">

                                <table class="resultDetailsTable" width="100%" cellspacing="0" cellpadding="0"
                                    style="min-width:570px; border-bottom:1px solid black;border-right:1px solid black;">
                                    <tbody>
                                        <tr style="font-weight:bold;">
                                            <td style="text-align:center;">Exam</td>
                                            <td style="text-align:center;">Type</td>
                                            @foreach ($subjects as $key1 => $subject)
                                                <td class="rotate-text">{{ $subject[0]->subject_name ?? '' }}</td>
                                            @endforeach
                                            <td class="rotate-text" style="text-align:center;">Grand Total
                                                Marks</td>
                                            <td class="rotate-text" style="text-align:center;">Grade</td>
                                            <td class="rotate-text" style="text-align:center;">GPA</td>
                                            <td class="rotate-text" style="text-align:center;">Percentage of Total Marks
                                            </td>


                                        </tr>

                                        <tr>
                                            @if ($class_code == 4)
                                                <td rowspan="7" class="rotate-text">Half Yearly</td>
                                                <td>CT</td>

                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $halfExam[$subject[0]->id][0]->ct ?? '' }}</td>
                                                @endforeach
                                                @php
                                                    $gpa_point = 0;
                                                    $total = 0;
                                                    foreach ($subjects as $key1 => $subject) {
                                                        if (
                                                            isset($halfExam[$subject[0]->id][0]->gpa_point) &&
                                                            $gpa_point != -1
                                                        ) {
                                                            if ($halfExam[$subject[0]->id][0]->gpa_point == 0) {
                                                                $gpa_point = -1;
                                                                $isnegative = -1;
                                                            }
                                                            $gpa_point += $halfExam[$subject[0]->id][0]->gpa_point;
                                                        }
                                                        if (isset($halfExam[$subject[0]->id][0]->ct_conv_total)) {
                                                            $total += $halfExam[$subject[0]->id][0]->ct_conv_total;
                                                        }
                                                    }
                                                    $point = '';
                                                    if ($gpa_point == -1) {
                                                        $point = 0;
                                                    } else {
                                                        $point = round($gpa_point / count($subjects), 2);
                                                    }

                                                @endphp
                                                <td rowspan="7">
                                                    {{ $total ?? '' }}
                                                </td>


                                                <td rowspan="7">
                                                    {{ $point ?? '' }}
                                                </td>
                                                <td rowspan="7">
                                                    {{ getGrade($point, $isnegative) }}
                                                </td>
                                                <td rowspan="7">
                                                    {{ round($total / count($subjects)) }}%
                                                </td>
                                            @elseif($class_code == 5)
                                                <td rowspan="7" class="rotate-text">Half Yearly</td>
                                                <td>CT</td>

                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $halfExam[$subject[0]->id][0]->ct ?? '' }}</td>
                                                @endforeach
                                                @php
                                                    $gpa_point = 0;
                                                    $total = 0;
                                                    foreach ($subjects as $key1 => $subject) {
                                                        if (
                                                            isset($halfExam[$subject[0]->id][0]->gpa_point) &&
                                                            $gpa_point != -1
                                                        ) {
                                                            if ($halfExam[$subject[0]->id][0]->gpa_point == 0) {
                                                                $gpa_point = -1;
                                                                $isnegative = -1;
                                                            }
                                                            $gpa_point += $halfExam[$subject[0]->id][0]->gpa_point;
                                                        }
                                                        if (isset($halfExam[$subject[0]->id][0]->ct_conv_total)) {
                                                            $total += $halfExam[$subject[0]->id][0]->ct_conv_total;
                                                        }
                                                    }
                                                    $point = '';
                                                    if ($gpa_point == -1) {
                                                        $point = 0;
                                                    } else {
                                                        $point = round($gpa_point / count($subjects), 2);
                                                    }

                                                @endphp
                                                <td rowspan="7">
                                                    {{ $total ?? '' }}
                                                </td>


                                                <td rowspan="7">
                                                    {{ $point ?? '' }}
                                                </td>
                                                <td rowspan="7">
                                                    {{ getGrade($point, $isnegative) }}
                                                </td>
                                                <td rowspan="7">
                                                    {{ round($total / count($subjects)) }}%
                                                </td>
                                            @elseif($class_code > 5)
                                                <td rowspan="10" class="rotate-text">Half Yearly</td>
                                                <td>Assignment Work</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $halfExam[$subject[0]->id][0]->ct1 ?? '' }}</td>
                                                @endforeach
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $halfExam[$subject[0]->id][0]->gpa_point ?? '' }}</td>
                                                @endforeach

                                                @php
                                                    $gpa_point = 0;
                                                    $total = 0;
                                                    foreach ($subjects as $key1 => $subject) {
                                                        if (
                                                            isset($halfExam[$subject[0]->id][0]->gpa_point) &&
                                                            $gpa_point != -1
                                                        ) {
                                                            if ($halfExam[$subject[0]->id][0]->gpa_point == 0) {
                                                                $gpa_point = -1;
                                                                $isnegative = -1;
                                                            }
                                                            $gpa_point += $halfExam[$subject[0]->id][0]->gpa_point;
                                                        }
                                                        if (isset($halfExam[$subject[0]->id][0]->ct_conv_total)) {
                                                            $total += $halfExam[$subject[0]->id][0]->ct_conv_total;
                                                        }
                                                    }
                                                    $point = '';
                                                    if ($gpa_point == -1) {
                                                        $point = 0;
                                                    } else {
                                                        $point = round($gpa_point / count($subjects), 2);
                                                    }

                                                @endphp
                                                <td rowspan="10">
                                                    {{ $total ?? '' }}
                                                </td>


                                                <td rowspan="10">
                                                    {{ $point ?? '' }}
                                                </td>
                                                <td rowspan="10">
                                                    {{ getGrade($point, $isnegative) }}
                                                </td>
                                                <td rowspan="10">
                                                    {{ round($total / count($subjects)) }}%
                                                </td>
                                            @endif
                                        </tr>
                                        @if ($class_code == 4)
                                            <tr>
                                                <td>Half Yearly</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $halfExam[$subject[0]->id][0]->cq_total ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Conv to 80%</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $halfExam[$subject[0]->id][0]->conv_total ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Grand</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $halfExam[$subject[0]->id][0]->ct_conv_total ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Grade</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $halfExam[$subject[0]->id][0]->gpa ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Grade Point</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $halfExam[$subject[0]->id][0]->gpa_point ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Highest Marks</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>
                                                        {{ $subjectHighestMark_pre[$subject[0]->id][0]->highest_mark ?? '' }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @elseif($class_code == 5)
                                            <tr>
                                                <td>Half Yearly</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $halfExam[$subject[0]->id][0]->cq_total ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Conv to 80%</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $halfExam[$subject[0]->id][0]->conv_total ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Grand</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $halfExam[$subject[0]->id][0]->ct_conv_total ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Grade</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $halfExam[$subject[0]->id][0]->gpa ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Grade Point</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $halfExam[$subject[0]->id][0]->gpa_point ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Highest Marks</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>
                                                        {{ $subjectHighestMark_pre[$subject[0]->id][0]->highest_mark ?? '' }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @elseif($class_code > 5)
                                            <tr>
                                                <td>Project Proposal</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $halfExam[$subject[0]->id][0]->ct2 ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Class Work</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $halfExam[$subject[0]->id][0]->ct3 ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>CA Total</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $halfExam[$subject[0]->id][0]->ct ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <td>Half Yearly</td>
                                            @foreach ($subjects as $key1 => $subject)
                                                <td>{{ $halfExam[$subject[0]->id][0]->cq_total ?? '' }}</td>
                                            @endforeach
                                            </tr>
                                            <tr>
                                                <td>Conv to 70%</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $halfExam[$subject[0]->id][0]->conv_total ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Grand</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $halfExam[$subject[0]->id][0]->ct_conv_total ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Grade</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $halfExam[$subject[0]->id][0]->gpa ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Grade Point</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $halfExam[$subject[0]->id][0]->gpa_point ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Highest Marks</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>
                                                        {{ $subjectHighestMark_pre[$subject[0]->id][0]->highest_mark ?? '' }}
                                                    </td>
                                                @endforeach

                                            </tr>
                                        @endif
                                        </tr>

                                        <!-- Annual exam -->

                                        <tr>
                                            @if ($class_code == 4)
                                                <td rowspan="7" class="rotate-text">Yearly</td>
                                                <td>CT</td>

                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $subjectwisemark[$subject[0]->id][0]->ct ?? '' }}</td>
                                                @endforeach

                                                @php
                                                    $gpa_point = 0;
                                                    $total = 0;
                                                    foreach ($subjects as $key1 => $subject) {
                                                        if (
                                                            isset($subjectwisemark[$subject[0]->id][0]->gpa_point) &&
                                                            $gpa_point != -1
                                                        ) {
                                                            if ($subjectwisemark[$subject[0]->id][0]->gpa_point == 0) {
                                                                $gpa_point = -1;
                                                                $isnegative = -1;
                                                            }
                                                            $gpa_point +=
                                                                $subjectwisemark[$subject[0]->id][0]->gpa_point;
                                                        }
                                                        if (
                                                            isset($subjectwisemark[$subject[0]->id][0]->ct_conv_total)
                                                        ) {
                                                            $total +=
                                                                $subjectwisemark[$subject[0]->id][0]->ct_conv_total;
                                                        }
                                                    }
                                                    $point = '';
                                                    if ($gpa_point == -1) {
                                                        $point = 0;
                                                    } else {
                                                        $point = round($gpa_point / count($subjects), 2);
                                                    }

                                                @endphp
                                                <td rowspan="7">
                                                    {{ $total ?? '' }}
                                                </td>


                                                <td rowspan="7">
                                                    {{ $point ?? '' }}
                                                </td>
                                                <td rowspan="7">
                                                    {{ getGrade($point, $isnegative) }}
                                                </td>
                                                <td rowspan="7">
                                                    {{ round($total / count($subjects)) }}%
                                                </td>
                                            @elseif($class_code == 5)
                                                <td rowspan="7" class="rotate-text">Yearly</td>
                                                <td>CT</td>

                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $subjectwisemark[$subject[0]->id][0]->ct ?? '' }}</td>
                                                @endforeach
                                                @php
                                                    $gpa_point = 0;
                                                    $total = 0;
                                                    foreach ($subjects as $key1 => $subject) {
                                                        if (
                                                            isset($subjectwisemark[$subject[0]->id][0]->gpa_point) &&
                                                            $gpa_point != -1
                                                        ) {
                                                            if ($subjectwisemark[$subject[0]->id][0]->gpa_point == 0) {
                                                                $gpa_point = -1;
                                                                $isnegative = -1;
                                                            }
                                                            $gpa_point +=
                                                                $subjectwisemark[$subject[0]->id][0]->gpa_point;
                                                        }
                                                        if (
                                                            isset($subjectwisemark[$subject[0]->id][0]->ct_conv_total)
                                                        ) {
                                                            $total +=
                                                                $subjectwisemark[$subject[0]->id][0]->ct_conv_total;
                                                        }
                                                    }
                                                    $point = '';
                                                    if ($gpa_point == -1) {
                                                        $point = 0;
                                                    } else {
                                                        $point = round($gpa_point / count($subjects), 2);
                                                    }

                                                @endphp
                                                <td rowspan="7">
                                                    {{ $total ?? '' }}
                                                </td>


                                                <td rowspan="7">
                                                    {{ $point ?? '' }}
                                                </td>
                                                <td rowspan="7">
                                                    {{ getGrade($point, $isnegative) }}
                                                </td>
                                                <td rowspan="7">
                                                    {{ round($total / count($subjects)) }}%
                                                </td>
                                            @elseif($class_code > 5)
                                                <td rowspan="10" class="rotate-text">Yearly</td>
                                                <td>Assignment Work</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $subjectwisemark[$subject[0]->id][0]->ct1 ?? '' }}</td>
                                                @endforeach
                                                @php
                                                    $gpa_point = 0;
                                                    $total = 0;
                                                    foreach ($subjects as $key1 => $subject) {
                                                        if (
                                                            isset($subjectwisemark[$subject[0]->id][0]->gpa_point) &&
                                                            $gpa_point != -1
                                                        ) {
                                                            if ($subjectwisemark[$subject[0]->id][0]->gpa_point == 0) {
                                                                $gpa_point = -1;
                                                                $isnegative = -1;
                                                            }
                                                            $gpa_point +=
                                                                $subjectwisemark[$subject[0]->id][0]->gpa_point;
                                                        }
                                                        if (
                                                            isset($subjectwisemark[$subject[0]->id][0]->ct_conv_total)
                                                        ) {
                                                            $total +=
                                                                $subjectwisemark[$subject[0]->id][0]->ct_conv_total;
                                                        }
                                                    }
                                                    $point = '';
                                                    if ($gpa_point == -1) {
                                                        $point = 0;
                                                    } else {
                                                        $point = round($gpa_point / count($subjects), 2);
                                                    }

                                                @endphp
                                                <td rowspan="10">
                                                    {{ $total ?? '' }}
                                                </td>


                                                <td rowspan="10">
                                                    {{ $point ?? '' }}
                                                </td>
                                                <td rowspan="10">
                                                    {{ getGrade($point, $isnegative) }}
                                                </td>
                                                <td rowspan="10">
                                                    {{ round($total / count($subjects)) }}%
                                                </td>
                                            @endif
                                        </tr>
                                        @if ($class_code == 4)
                                            <tr>
                                                <td>Yearly</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $subjectwisemark[$subject[0]->id][0]->cq_total ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Conv to 80%</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $subjectwisemark[$subject[0]->id][0]->conv_total ?? '' }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Grand</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $subjectwisemark[$subject[0]->id][0]->ct_conv_total ?? '' }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Grade</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $subjectwisemark[$subject[0]->id][0]->gpa ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Grade Point</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $subjectwisemark[$subject[0]->id][0]->gpa_point ?? '' }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Highest Marks</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>
                                                        {{ $subjectHighestMark[$subject[0]->id][0]->highest_mark ?? '' }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @elseif($class_code == 5)
                                            <tr>
                                                <td>Yearly</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $subjectwisemark[$subject[0]->id][0]->cq_total ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Conv to 80%</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $subjectwisemark[$subject[0]->id][0]->conv_total ?? '' }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Grand</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $subjectwisemark[$subject[0]->id][0]->ct_conv_total ?? '' }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Grade</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $subjectwisemark[$subject[0]->id][0]->gpa ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Grade Point</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $subjectwisemark[$subject[0]->id][0]->gpa_point ?? '' }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Highest Marks</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>
                                                        {{ $subjectHighestMark[$subject[0]->id][0]->highest_mark ?? '' }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @elseif($class_code > 5)
                                            <tr>
                                                <td>Project Proposal</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $subjectwisemark[$subject[0]->id][0]->ct2 ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Class Work</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $subjectwisemark[$subject[0]->id][0]->ct3 ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>CA Total</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $subjectwisemark[$subject[0]->id][0]->ct ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <td>Half Yearly</td>
                                            @foreach ($subjects as $key1 => $subject)
                                                <td>{{ $subjectwisemark[$subject[0]->id][0]->cq_total ?? '' }}</td>
                                            @endforeach
                                            </tr>
                                            <tr>
                                                <td>Conv to 70%</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $subjectwisemark[$subject[0]->id][0]->conv_total ?? '' }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Grand</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $subjectwisemark[$subject[0]->id][0]->ct_conv_total ?? '' }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Grade</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $subjectwisemark[$subject[0]->id][0]->gpa ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Grade Point</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $subjectwisemark[$subject[0]->id][0]->gpa_point ?? '' }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Highest Marks</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>
                                                        {{ $subjectHighestMark[$subject[0]->id][0]->highest_mark ?? '' }}
                                                    </td>
                                                @endforeach

                                            </tr>
                                        @endif
                                        </tr>


                                        <!-- Avarage mark -->


                                        <tr>
                                            @if ($class_code == 4)
                                                <td rowspan="7" class="rotate-text">Average</td>
                                                <td>CT</td>

                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $avaragemark[$subject[0]->id][0]->ct ?? '' }}</td>
                                                @endforeach
                                                @php
                                                    $isnegative = 0;
                                                    $gpa_point = 0;
                                                    $total = 0;
                                                    foreach ($subjects as $key1 => $subject) {
                                                        if (
                                                            isset($avaragemark[$subject[0]->id][0]->gpa_point) &&
                                                            $gpa_point != -1
                                                        ) {
                                                            if ($avaragemark[$subject[0]->id][0]->gpa_point == 0) {
                                                                $gpa_point = -1;
                                                                $isnegative = -1;
                                                            }
                                                            $gpa_point += $avaragemark[$subject[0]->id][0]->gpa_point;
                                                        }
                                                        if (isset($avaragemark[$subject[0]->id][0]->ct_conv_total)) {
                                                            $total += $avaragemark[$subject[0]->id][0]->ct_conv_total;
                                                        }
                                                    }
                                                    $point = '';
                                                    if ($gpa_point == -1) {
                                                        $point = 0;
                                                    } else {
                                                        $point = round($gpa_point / count($subjects), 2);
                                                    }

                                                @endphp
                                                <td rowspan="7">
                                                    {{ $total ?? '' }}
                                                </td>


                                                <td rowspan="7">
                                                    {{ $point ?? '' }}
                                                </td>
                                                <td rowspan="7">
                                                    {{ getGrade($point, $isnegative) }}
                                                </td>
                                                <td rowspan="7">
                                                    {{ round($total / count($subjects)) }}%
                                                </td>
                                            @elseif($class_code == 5)
                                                <td rowspan="7" class="rotate-text">Average</td>
                                                <td>CT</td>

                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $avaragemark[$subject[0]->id][0]->ct ?? '' }}</td>
                                                @endforeach
                                                @php
                                                    $isnegative = 0;
                                                    $gpa_point = 0;
                                                    $total = 0;
                                                    foreach ($subjects as $key1 => $subject) {
                                                        if (
                                                            isset($avaragemark[$subject[0]->id][0]->gpa_point) &&
                                                            $gpa_point != -1
                                                        ) {
                                                            if ($avaragemark[$subject[0]->id][0]->gpa_point == 0) {
                                                                $gpa_point = -1;
                                                                $isnegative = -1;
                                                            }
                                                            $gpa_point += $avaragemark[$subject[0]->id][0]->gpa_point;
                                                        }
                                                        if (isset($avaragemark[$subject[0]->id][0]->ct_conv_total)) {
                                                            $total += $avaragemark[$subject[0]->id][0]->ct_conv_total;
                                                        }
                                                    }
                                                    $point = '';
                                                    if ($gpa_point == -1) {
                                                        $point = 0;
                                                    } else {
                                                        $point = round($gpa_point / count($subjects), 2);
                                                    }

                                                @endphp
                                                <td rowspan="7">
                                                    {{ $total ?? '' }}
                                                </td>


                                                <td rowspan="7">
                                                    {{ $point ?? '' }}
                                                </td>
                                                <td rowspan="7">
                                                    {{ getGrade($point, $isnegative) }}
                                                </td>
                                                <td rowspan="7">
                                                    {{ round($total / count($subjects)) }}%
                                                </td>
                                            @elseif($class_code > 5)
                                                <td rowspan="10" class="rotate-text">Average</td>
                                                <td>Assignment Work</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $avaragemark[$subject[0]->id][0]->ct1 ?? '' }}</td>
                                                @endforeach
                                                @php
                                                    $isnegative = 0;
                                                    $gpa_point = 0;
                                                    $total = 0;
                                                    foreach ($subjects as $key1 => $subject) {
                                                        if (
                                                            isset($avaragemark[$subject[0]->id][0]->gpa_point) &&
                                                            $gpa_point != -1
                                                        ) {
                                                            if ($avaragemark[$subject[0]->id][0]->gpa_point == 0) {
                                                                $gpa_point = -1;
                                                                $isnegative = -1;
                                                            }
                                                            $gpa_point += $avaragemark[$subject[0]->id][0]->gpa_point;
                                                        }
                                                        if (isset($avaragemark[$subject[0]->id][0]->ct_conv_total)) {
                                                            $total += $avaragemark[$subject[0]->id][0]->ct_conv_total;
                                                        }
                                                    }
                                                    $point = '';
                                                    if ($gpa_point == -1) {
                                                        $point = 0;
                                                    } else {
                                                        $point = round($gpa_point / count($subjects), 2);
                                                    }

                                                @endphp
                                                <td rowspan="10">
                                                    {{ $total ?? '' }}
                                                </td>


                                                <td rowspan="10">
                                                    {{ $point ?? '' }}
                                                </td>
                                                <td rowspan="10">
                                                    {{ getGrade($point, $isnegative) }}
                                                </td>
                                                <td rowspan="10">
                                                    {{ round($total / count($subjects)) }}%
                                                </td>
                                            @endif
                                        </tr>
                                        @if ($class_code == 4)
                                            <tr>
                                                <td>Average</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $avaragemark[$subject[0]->id][0]->cq_total ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Conv to 80%</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $avaragemark[$subject[0]->id][0]->conv_total ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Grand</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $avaragemark[$subject[0]->id][0]->ct_conv_total ?? '' }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Grade</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $avaragemark[$subject[0]->id][0]->gpa ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Grade Point</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $avaragemark[$subject[0]->id][0]->gpa_point ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Highest Marks</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>
                                                        {{ $subjectHighestMark_avg[$subject[0]->id][0]->avarage_highest_mark ?? '' }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @elseif($class_code == 5)
                                            <tr>
                                                <td>Average</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $avaragemark[$subject[0]->id][0]->cq_total ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Conv to 80%</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $avaragemark[$subject[0]->id][0]->conv_total ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Grand</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $avaragemark[$subject[0]->id][0]->ct_conv_total ?? '' }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Grade</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $avaragemark[$subject[0]->id][0]->gpa ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Grade Point</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $avaragemark[$subject[0]->id][0]->gpa_point ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Highest Marks</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>
                                                        {{ $subjectHighestMark_avg[$subject[0]->id][0]->avarage_highest_mark ?? '' }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @elseif($class_code > 5)
                                            <tr>
                                                <td>Project Proposal</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $avaragemark[$subject[0]->id][0]->ct2 ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Class Work</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $avaragemark[$subject[0]->id][0]->ct3 ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>CA Total</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $avaragemark[$subject[0]->id][0]->ct ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <td>Half Yearly</td>
                                            @foreach ($subjects as $key1 => $subject)
                                                <td>{{ $avaragemark[$subject[0]->id][0]->cq_total ?? '' }}</td>
                                            @endforeach
                                            </tr>
                                            <tr>
                                                <td>Conv to 70%</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $avaragemark[$subject[0]->id][0]->conv_total ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Grand</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $avaragemark[$subject[0]->id][0]->ct_conv_total ?? '' }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Grade</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $avaragemark[$subject[0]->id][0]->gpa ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Grade Point</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>{{ $avaragemark[$subject[0]->id][0]->gpa_point ?? '' }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td>Highest Marks</td>
                                                @foreach ($subjects as $key1 => $subject)
                                                    <td>
                                                        {{ $subjectHighestMark_avg[$subject[0]->id][0]->avarage_highest_mark ?? '' }}
                                                    </td>
                                                @endforeach

                                            </tr>
                                        @endif
                                        </tr>
                                </table>


                            </div>
                            <br>
                            <div style="padding-top:10px; padding-bottom:5px">

                                <table class="resultDetailsTable" cellpadding="0" cellspacing="0"
                                    style="border-bottom: 1px solid black; border-right: 1px solid black;">

                                    <tr>

                                        <td style="text-align:center;">Position in Section</td>
                                        <td style="text-align:center;height: 40px;">Position in Class </td>
                                        <td style="text-align:center;">Next Class </td>
                                        <td style="text-align:center;">Next Section</td>
                                        <td style="text-align:center;">Next Roll </td>
                                        <td rowspan="2" style="text-align:center;">
                                            {{ $student->totalmark?->position_in_class ? 'Promoted' : 'Not Promoted' }}
                                        </td>

                                    </tr>
                                    <tr>
                                        <td style="text-align:center;">
                                            {{ $isnegative == -1 ? '' : $student->totalmark->position_in_section ?? '' }}
                                        </td>
                                        <td style="text-align:center;height: 40px;">
                                            {{ $isnegative == -1 ? '' : $student->totalmark->position_in_class ?? '' }}
                                        </td>

                                        <td style="text-align:center;">
                                            {{ $student->totalmark?->next_class ? $classroman[$student->totalmark->next_class] : '' }}
                                        </td>

                                        <td style="text-align:center;">{{ $student->totalmark->section_name ?? '' }}
                                        </td>
                                        <td style="text-align:center;">{{ $student->totalmark->next_roll ?? '' }}
                                        </td>
                                    </tr>
                                </table>
                                <br />
                                <table class="resultDetailsTable" cellpadding="0" cellspacing="0"
                                    style="border-bottom: 1px solid black; border-right: 1px solid black;">

                                    <tr>

                                        <td style="text-align:left;width: 25%!important">No. of Working Days :</td>
                                        <td style="text-align:center;width: 15%!important"></td>
                                        <td rowspan="5" style="text-align:center;width: 30%!important">Vice
                                            Principal</td>
                                        <td rowspan="5" style="text-align:center;width: 30%!important"><img
                                                src="{{ asset('public/psi.jpg') }}"
                                                style="height: 70px;" /><br />Principal</td>

                                    </tr>
                                    <tr>

                                        <td style="text-align:left;">Total Present :</td>
                                        <td style="text-align:center;"></td>

                                    </tr>
                                    <tr>

                                        <td style="text-align:left;">Remarks :</td>
                                        <td style="text-align:center;"></td>

                                    </tr>
                                    <tr>

                                        <td style="text-align:left;">Class Teacher's Signature :</td>
                                        <td style="text-align:center;"></td>

                                    </tr>
                                    <tr>

                                        <td style="text-align:left;">Gaurdian's Signature :</td>
                                        <td style="text-align:center;height: 40px;"></td>

                                    </tr>


                                </table>

                            </div>
                        </div>
                        <div class="page-break"></div>
                    @endforeach


                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function printElem(divId) {
            //var tocContent = document.getElementById(tocId).innerHTML;
            var msg = "";
            var content = document.getElementById(divId).innerHTML;
            var mywindow = window.open('', 'Print');

            //mywindow.document.write('<html><head><title> Testimonial Collection Sheet </title>');
            //mywindow.document.write('<style> .viewHead {display: none;} @page { size: portrait; size: A4; margin: 60mm 5mm 5mm 5mm; }</style>');
            mywindow.document.write('<style> @page { size: 210mm 297mm; margin: 5mm 5mm 5mm 5mm; } </style>');
            //mywindow.document.write('<style> .viewHead {display: none;} @page { size: portrait; size: 20.94cm 27.94cm; margin: 60mm 5mm 5mm 5mm; } </style>');
            mywindow.document.write('</head><body >');
            mywindow.document.write(content);
            mywindow.document.write('</body></html>');

            mywindow.document.close();
            mywindow.focus();
            mywindow.print();
            myDelay = setInterval(checkReadyState, 1000);

            function checkReadyState() {
                if (mywindow.document.readyState == "complete") {
                    clearInterval(myDelay);
                    mywindow.close();
                }
            }
            return true;
        }
    </script>
</div>


</div>
