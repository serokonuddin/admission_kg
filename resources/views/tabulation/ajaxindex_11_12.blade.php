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
                        @media print {

                            /* Hide elements with the 'noprint' class during print */
                            .noprint {
                                display: none !important;

                            }

                            .yesprint {
                                display: block !important;
                            }

                        }

                        .margin-200 {
                            margin-top: 200px !important;
                        }

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
                            text-decoration: underline !important;
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
                    @endphp
                    @php
                        $ctdata = $subjectsmapping[0] ?? '';

                    array_shift($subjectsmapping); @endphp
                    @foreach ($students as $key => $student)
                        <div class="mobileScreenInfo" style="overflow-y:hidden; margin-bottom:20px;">
                            <table cellpadding="0" cellspacing="0" style="width:100%; page-break-inside: avoid;"
                                class="tableBorderNo">
                                <tbody>
                                    <tr>
                                        <!-- Main Logo and School Info Section -->
                                        <td class="noprint" style="width:75%; vertical-align: top;">
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
                                                                BAF Shaheen College Dhaka
                                                            </h3>
                                                            <span
                                                                style="text-align:center; margin-top: 0px; margin-bottom: 0px; font-size:14px;">
                                                                Dhaka Cantonment, Dhaka-1206
                                                            </span>
                                                        </td>
                                                        <td style="width:15%; text-align:center;"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>

                                        <td class="yesprint" style="width: 75%; display: none">

                                        </td>

                                        <!-- Grade Point Table Section -->
                                        <td class="noprint" style="width:25%; vertical-align: top; padding-left: 10px;">
                                            <table cellpadding="0" cellspacing="0"
                                                style="width:100%; border:1px solid #00; text-align:center; font-size:10px;">
                                                <thead>
                                                    <tr>
                                                        <th style="border: 1px solid #000; padding: 3px;">Marks Range
                                                        </th>
                                                        <th style="border: 1px solid #000; padding: 3px;">LG</th>
                                                        <th style="border: 1px solid #000; padding: 3px;">GP</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="border: 1px solid #000; padding: 3px;">80-100</td>
                                                        <td style="border: 1px solid #000; padding: 3px;">A+</td>
                                                        <td style="border: 1px solid #000; padding: 3px;">5.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid #000; padding: 3px;">70-79</td>
                                                        <td style="border: 1px solid #000; padding: 3px;">A</td>
                                                        <td style="border: 1px solid #000; padding: 3px;">4.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid #000; padding: 3px;">60-69</td>
                                                        <td style="border: 1px solid #000; padding: 3px;">A-</td>
                                                        <td style="border: 1px solid #000; padding: 3px;">3.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid #000; padding: 3px;">50-59</td>
                                                        <td style="border: 1px solid #000; padding: 3px;">B</td>
                                                        <td style="border: 1px solid #000; padding: 3px;">2.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid #000; padding: 3px;">0-49</td>
                                                        <td style="border: 1px solid #000; padding: 3px;">F</td>
                                                        <td style="border: 1px solid #000; padding: 3px;">0.00</td>
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
                                                <td style="width:40%;" colspan="2">Student's
                                                    Name-{{ $student->first_name ?? '' }}</td>
                                                <td style="width:60%;" colspan="3">Class Teacher :
                                                    {{ $classteacher->employee_name ?? '' }}
                                                    ({{ $classteacher->mobile ?? '' }})</td>

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
                                <spn style="font-weight:bold;font-size:17px; ">Result in Details</spn>
                            </div>
                            @php
                                $markforcount = count($subjectsmapping) + 3;

                                $studentdata = $student->subjectwisemark;

                            @endphp
                            <div class="mobileScreen">
                                <table class="resultDetailsTable" width="100%" cellspacing="0" cellpadding="0"
                                    style="min-width:570px; border-bottom:1px solid black;border-right:1px solid black;">
                                    <tbody>
                                        <tr style="font-weight:bold;">
                                            <td rowspan="2" style="text-align:center;">Sub Type<br></td>
                                            <td rowspan="2" style="text-align:center;">Sub Name</td>
                                            <td colspan="{{ $markforcount + 7 }}" style="text-align:center;">
                                                {{ $exam->exam_title }}</td>



                                        </tr>
                                        <tr style="font-weight:bold;">


                                            @foreach ($subjectsmapping as $key => $subject)
                                                @if ($subject == 0)
                                                @elseif($subject == 1)
                                                    <td style="text-align:center;">
                                                        CQ
                                                    </td>
                                                @elseif($subject == 2)
                                                    <td style="text-align:center;">
                                                        MCQ
                                                    </td>
                                                @else
                                                    <td style="text-align:center;">
                                                        Practical
                                                    </td>
                                                @endif
                                            @endforeach

                                            <td style="text-align:center;">Total</td>
                                            <td style="text-align:center;">Conv <br /> 70%</td>
                                            @if ($ctdata == 0)
                                                <td style="text-align:center;">
                                                    CT
                                                </td>

                                                <td style="text-align:center;">
                                                    Quiz
                                                </td>
                                                <td style="text-align:center;">
                                                    Total
                                                </td>
                                                <td style="text-align:center;">
                                                    Conv <br /> 30%
                                                </td>
                                            @endif
                                            <td style="text-align:center;">Subject <br /> Total</td>
                                            <td style="text-align:center;">Grade</td>
                                            <td style="text-align:center;">Grade <br /> Point</td>
                                            <td style="text-align:center;">Highest <br /> Marks</td>
                                        </tr>
                                        @php

                                            $total_total = 0;
                                            $gradepoint = 0;
                                            $count = 0;
                                            $hight = [];
                                            $isnegative = 0;

                                            $isnegative = 0;
                                            $gpa_point = 0;
                                            $total = 0;
                                            $point = '';
                                            $with_four_point = '';
                                            $forth_subject = 0;
                                            $forth_subject_mark = 0;
                                        @endphp
                                        @foreach ($studentdata as $key1 => $studen)
                                            @php
                                                $subjectId = $student->subjectwisemark[$key1]->subject_id ?? null;
                                                $cqTotal = $student->subjectwisemark[$key1]->cq_total ?? null;
                                                $mcqTotal = $student->subjectwisemark[$key1]->mcq_total ?? null;
                                                $practicalTotal =
                                                    $student->subjectwisemark[$key1]->practical_total ?? null;
                                                $isAbsent = $student->subjectwisemark[$key1]->is_absent ?? null;

                                                $isCqAbsent = $student->subjectwisemark[$key1]->is_cq_abs ?? 0;
                                                $isMcqAbsent = $student->subjectwisemark[$key1]->is_mcq_abs ?? 0;
                                                $isPracAbsent = $student->subjectwisemark[$key1]->is_prac_abs ?? 0;
                                                $isCtAbsent = $student->subjectwisemark[$key1]->is_ct_abs ?? 0;
                                                $isQuizAbsent = $student->subjectwisemark[$key1]->is_quiz_abs ?? 0;

                                                $specialSubjectsPrac = [
                                                    58,
                                                    59,
                                                    61,
                                                    62,
                                                    84,
                                                    92,
                                                    88,
                                                    96,
                                                    75,
                                                    76,
                                                    77,
                                                    78,
                                                    85,
                                                    93,
                                                    80,
                                                    83,
                                                    87,
                                                    95,
                                                    89,
                                                    98,
                                                    79,
                                                    81,
                                                ];
                                                $specialSubjectsMcq = [61, 62, 71, 72];

                                                // Determine CQ Highlight Condition
                                                $highlightCq =
                                                    $subjectId &&
                                                    ((in_array($subjectId, $specialSubjectsPrac) &&
                                                        $cqTotal !== null &&
                                                        ($cqTotal < 23 ||
                                                            (($subjectId == 71 || $subjectId == 72) &&
                                                                $cqTotal < 20))) ||
                                                        (!in_array($subjectId, $specialSubjectsPrac) &&
                                                            $cqTotal !== null &&
                                                            $cqTotal < 17));

                                                // Determine MCQ Highlight Condition
                                                $highlightMcq =
                                                    $subjectId &&
                                                    !in_array($subjectId, $specialSubjectsMcq) &&
                                                    ((in_array($subjectId, $specialSubjectsPrac) &&
                                                        $mcqTotal !== null &&
                                                        $mcqTotal < 10) ||
                                                        (!in_array($subjectId, $specialSubjectsPrac) &&
                                                            $mcqTotal !== null &&
                                                            $mcqTotal < 8));

                                                // Determine Practical Total Highlight Condition
                                                $highlightPractical =
                                                    $subjectId &&
                                                    !in_array($subjectId, $specialSubjectsPrac) &&
                                                    (($practicalTotal !== null && $practicalTotal < 8) ||
                                                        (in_array($subjectId, [71, 72]) &&
                                                            $practicalTotal !== null &&
                                                            $practicalTotal < 13));

                                                // Determine if Practical Total should be hidden
                                                $hidePractical =
                                                    $subjectId && in_array($subjectId, $specialSubjectsPrac);
                                            @endphp
                                            <tr>
                                                @if ($key1 == 0)
                                                    <td rowspan="3">Comp</td>
                                                @elseif($key1 == 3)
                                                    <td rowspan="3">Elec</td>
                                                @elseif($key1 == 6)
                                                    <td>Opt</td>
                                                @endif
                                                <td>{{ $subjects[$studen->subject_id][0]->short_name ?? '' }}
                                                </td>

                                                @foreach ($subjectsmapping as $key => $subject)
                                                    @if ($subject == 0)
                                                        <!-- <td style="text-align:center;">
                                                          {{ $studen->ct1 }}
                                                        </td>
                                                        <td style="text-align:center;">
                                                        {{ $studen->ct2 }}
                                                        </td>
                                                        <td style="text-align:center;">
                                                        {{ $studen->ct3 }}
                                                        </td>
                                                        <td style="text-align:center;">
                                                        {{ $studen->ct }}
                                                        </td> -->
                                                    @elseif($subject == 1)
                                                        {{-- <td style="text-align:center;">
                                                            {{ $studen->cq_total }}
                                                        </td> --}}
                                                        <td
                                                            style="text-align: center; {{ $highlightCq || $isCqAbsent ? 'color: red; text-decoration: underline;' : '' }}">
                                                            {{-- {{ $isAbsent === 0 ? $cqTotal : '' }} --}}
                                                            {{ $isCqAbsent == 1 ? 'A' : $cqTotal ?? '' }}
                                                        </td>
                                                    @elseif($subject == 2)
                                                        {{-- <td style="text-align:center;">
                                                            {{ $studen->mcq_total }}
                                                        </td> --}}
                                                        <td
                                                            style="text-align: center; {{ $highlightMcq || $isMcqAbsent ? 'color: red; text-decoration: underline;' : '' }}">
                                                            @if ($subjectId && in_array($subjectId, $specialSubjectsMcq))
                                                                {{ '-' }}
                                                            @else
                                                                {{ $isMcqAbsent == 1 ? 'A' : $mcqTotal ?? '' }}
                                                            @endif
                                                        </td>
                                                    @else
                                                        {{-- <td style="text-align:center;">
                                                            {{ $studen->practical_total }}
                                                        </td> --}}
                                                        <td
                                                            style="text-align: center; {{ $highlightPractical || $isPracAbsent ? 'color: red; text-decoration: underline;' : '' }}">
                                                            {{ $hidePractical ? '-' : ($isPracAbsent == 1 ? 'A' : $practicalTotal ?? '') }}
                                                        </td>
                                                    @endif
                                                @endforeach
                                                <td style="text-align:center;">
                                                    {{ $studen->total }}
                                                </td>
                                                <td style="text-align:center;">
                                                    {{ $studen->conv_total }}
                                                </td>
                                                @if ($ctdata == 0)
                                                    <!-- <td style="text-align:center;">
                                                            {{ $studen->ct1 }}
                                                            </td> -->
                                                    {{-- <td style="text-align:center;">
                                                        {{ ($studen->ct1 ?? 0) + ($studen->ct2 ?? 0) }}
                                                    </td> --}}
                                                    <td
                                                        style="text-align: center; {{ $isCtAbsent ? 'color: red; text-decoration: underline;' : '' }}">
                                                        {{ $isCtAbsent == 1 ? 'A' : ($studen->ct1 ?? 0) + ($studen->ct2 ?? 0) }}
                                                    </td>
                                                    {{-- <td style="text-align:center;">
                                                        {{ ($studen->ct3 ?? 0) + ($studen->ct4 ?? 0) }}
                                                    </td> --}}
                                                    <td
                                                        style="text-align: center; {{ $isQuizAbsent ? 'color: red; text-decoration: underline;' : '' }}">
                                                        {{ $isQuizAbsent ? 'A' : ($studen->ct3 ?? 0) + ($studen->ct4 ?? 0) }}
                                                    </td>
                                                    <td style="text-align:center;">
                                                        {{ ($studen->ct1 ?? 0) + ($studen->ct2 ?? 0) + ($studen->ct3 ?? 0) + ($studen->ct4 ?? 0) }}
                                                    </td>
                                                    <td
                                                        style="text-align:center; @if ($studen->ct < 10) color: red; text-decoration: underline; @endif">
                                                        {{ $studen->ct }}
                                                    </td>
                                                @endif
                                                <td style="text-align:center;">
                                                    {{ $studen->ct_conv_total }}
                                                </td>
                                                <td
                                                    style="text-align:center; @if ($studen->gpa == 'F') color: red; text-decoration: underline; @endif">
                                                    {{ $studen->gpa }}
                                                </td>

                                                <td
                                                    style="text-align:center;@if ($studen->gpa == 'F') color: red; text-decoration: underline; @endif">
                                                    {{ $studen->gpa_point }}
                                                </td>
                                                <td style="text-align:center;">
                                                    {{ $subjectHighestMark[$studen->subject_id][0]->highest_mark ?? '' }}
                                                </td>
                                                @php

                                                    if ($gpa_point != -1) {
                                                        if (
                                                            $studen->gpa_point == 0 ||
                                                            $studen->gpa_point == '' ||
                                                            $studen->gpa_point == null
                                                        ) {
                                                            if ($studen->is_fourth_subject != 1) {
                                                                $gpa_point = -1;
                                                                $isnegative = -1;
                                                            }
                                                        }
                                                        if ($studen->is_fourth_subject == 1) {
                                                            $forth_subject = $studen->gpa_point;
                                                            $forth_subject_mark = $studen->ct_conv_total;
                                                        } else {
                                                            $gpa_point += (float) $studen->gpa_point;
                                                        }
                                                    }

                                                    $total += (int) $studen->ct_conv_total;

                                                @endphp
                                            </tr>
                                        @endforeach
                                        @php
                                            if ($gpa_point == -1) {
                                                $point = 0;
                                                $with_four_point = 0;
                                            } else {
                                                $point =
                                                    count($studentdata) > 1
                                                        ? round($gpa_point / (count($studentdata) - 1), 2)
                                                        : '';
                                                if ($forth_subject > 2) {
                                                    $gpa_point += (float) ($forth_subject - 2);
                                                }
                                                $with_four_point =
                                                    count($studentdata) > 1
                                                        ? round($gpa_point / (count($studentdata) - 1), 2)
                                                        : '';
                                            }
                                        @endphp
                                        <tr style="font-weight:bold;">
                                            <td colspan="{{ $markforcount + 5 }}">
                                                {{-- Grand Total Marks, Grade and GPA without 4th subject --}}
                                                Grand Total Marks and GPA without 4th subject
                                            </td>

                                            <td style="text-align:center;">{{ $total - $forth_subject_mark ?? '' }}
                                            </td>
                                            <td style="text-align:center;"
                                                class="{{ $isnegative == -1 ? 'redtext' : '' }}">

                                            </td>
                                            <td style="text-align:center;"
                                                class="{{ $isnegative == -1 ? 'redtext' : '' }}">
                                                {{ $point > 5 ? 5 : $point }}
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr style="font-weight:bold;">
                                            <td colspan="{{ $markforcount + 7 }}">
                                                Gp added from 4th subject above 2.0
                                            </td>


                                            <td style="text-align:center;"
                                                class="{{ $isnegative == -1 ? 'redtext' : '' }}">
                                                {{ $forth_subject > 2 ? $forth_subject - 2 : '' }}
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr style="font-weight:bold;">
                                            <td colspan="{{ $markforcount + 7 }}">
                                                GPA with 4th subject
                                            </td>
                                            {{-- <td style="text-align:center;">{{ $total - $forth_subject_mark ?? '' }} --}}
                                            {{-- </td> --}}
                                            {{-- <td style="text-align:center;"
                                                class="{{ $isnegative == -1 ? 'redtext' : '' }}">

                                            </td> --}}
                                            <td style="text-align:center;"
                                                class="{{ $isnegative == -1 ? 'redtext' : '' }}">
                                                {{ $with_four_point > 5 ? 5 : $with_four_point }}
                                            </td>
                                            <td></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <div style="padding-top:10px; padding-bottom:5px">
                                <table class="resultDetailsTable" cellpadding="0" cellspacing="0"
                                    style="border-bottom: 1px solid black; border-right: 1px solid black;">
                                    <tr>
                                        <td style="text-align:center;">Position in Section</td>
                                        <td style="text-align:center;height: 40px;">Position in Group </td>
                                        <td style="text-align:center;">Next Class </td>
                                        <td style="text-align:center;">Next Section</td>
                                        <td style="text-align:center;">Next Roll </td>
                                        {{-- <td rowspan="2" style="text-align:center;">
                                           {{ isset($student->totalmark->position_in_class) ? 'Promoted' : 'Not Promoted' }}
                                        </td> --}}
                                    </tr>
                                    <tr>
                                        <td style="text-align:center;">
                                            {{ $isnegative == -1 ? '' : $student->totalmark->position_in_section ?? '' }}
                                        </td>
                                        <td style="text-align:center;height: 40px;">
                                            {{ $isnegative == -1 ? '' : $student->totalmark->position_in_class ?? '' }}
                                        </td>
                                        <td style="text-align:center;">
                                            {{ isset($student->totalmark->next_class) ? $classroman[$student->totalmark->next_class] : '' }}
                                        </td>
                                        <td style="text-align:center;">{{ $student->totalmark->section_name ?? '' }}
                                        </td>
                                        <td style="text-align:center;">{{ $student->totalmark->next_roll ?? '' }}</td>
                                    </tr>
                                </table>
                                <br />
                                <table class="resultDetailsTable" cellpadding="0" cellspacing="0"
                                    style="border-bottom: 1px solid black; border-right: 1px solid black;">
                                    <tr>
                                        <td style="text-align:left;width: 25%!important">No. of Working Days :</td>
                                        <td style="text-align:center;width: 15%!important"></td>
                                        <td rowspan="5" style="text-align:center;width: 30%!important">
                                            {{-- @if ($student->version_id == 1 && $student->class_code < 6)
                                                <img src="{{ asset('public/primary_bangla_vp_sign1.png') }}"
                                                    style="height: 70px;" />
                                            @elseif ($student->version_id == 2 && $student->class_code < 6)
                                                <img src="{{ asset('public/primary_english_vp_sign1.jpg') }}"
                                                    style="height: 70px;" />
                                            @endif --}}
                                            <img src="{{ asset('public/vp_shakila1.png') }}" style="height: 70px;" />
                                            </br>
                                            Vice Principal
                                        </td>
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
            // Get the content element
            var contentElement = document.getElementById(divId);

            // Add the desired class (e.g., 'print-margin')
            contentElement.classList.add('margin-200');

            // Get the content of the element with the added class
            var content = contentElement.innerHTML;

            // Open a new window for printing
            var mywindow = window.open('', 'Print');

            // Write HTML structure and styles to the new window
            mywindow.document.write('<html><head><title>Print Preview</title>');
            mywindow.document.write('<style>@page { size: 210mm 297mm; margin: 65mm 5mm 5mm 5mm; }</style>');

            mywindow.document.write('</head><body>');
            mywindow.document.write(content); // Print the content
            mywindow.document.write('</body></html>');

            // Close the document and focus on the window
            mywindow.document.close();
            mywindow.focus();

            // Trigger the print dialog
            mywindow.print();

            // Close the print window after it's ready
            var myDelay = setInterval(checkReadyState, 1000);

            function checkReadyState() {
                if (mywindow.document.readyState === "complete") {
                    clearInterval(myDelay);
                    mywindow.close();
                }
            }

            // Remove the class after printing
            contentElement.classList.remove('print-margin');

            return true;
        }
    </script>
</div>


</div>
