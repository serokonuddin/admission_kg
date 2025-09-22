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

                        .resultDetailsTableContinuous {
                            border-collapse: collapse;
                            width: 100%;
                        }

                        .resultDetailsTableContinuous td,
                        .resultDetailsTableContinuous th {
                            border: 1px solid black;
                            padding: 8px;
                            text-align: center;
                        }

                        .page-break {
                            display: block;
                            page-break-before: always;
                        }

                        .redtext {
                            color: red !important;
                        }

                        @media print {

                            /* Hide elements with the 'noprint' class during print */
                            .noprint {
                                display: none !important;

                            }

                            .yesprint {
                                display: block !important;
                            }

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
                            '' => '',
                        ];
                        function getPoint($marks)
                        {
                            if ($marks >= 80) {
                                return 5.0; // A+
                            } elseif ($marks >= 70) {
                                return 4.0; // A
                            } elseif ($marks >= 60) {
                                return 3.5; // A-
                            } elseif ($marks >= 50) {
                                return 3.0; // B
                            } elseif ($marks >= 40) {
                                return 2.0; // C
                            } elseif ($marks >= 33) {
                                return 1.0; // D
                            } else {
                                return 0.0; // F
                            }
                        }
                        function getGrade($point, $isnegative)
                        {
                            if ($isnegative == -1) {
                                return 'F';
                            }
                            if ($point >= 5) {
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
                        function zeroToNull($value)
                        {
                            if ($value == 0) {
                                return '';
                            }
                            return $value;
                        }
                    @endphp
                    @foreach ($students as $key => $student)
                        {{-- <div class="mobileScreenInfo noprint" style="overflow-y:hidden; margin-bottom:20px;">
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
                        </div> --}}
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
                                        <td style="width:25%; vertical-align: top; padding-left: 10px;">
                                            <table cellpadding="0" cellspacing="0"
                                                style="width:100%; border:1px solid #00; text-align:center; font-size:10px;">
                                                <thead>
                                                    <tr>
                                                        <th style="border: 1px solid #000; padding: 3px;">Marks Range
                                                        </th>
                                                        <th style="border: 1px solid #000; padding: 3px;">GL</th>
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
                                                        <td style="border: 1px solid #000; padding: 3px;">3.50</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid #000; padding: 3px;">50-59</td>
                                                        <td style="border: 1px solid #000; padding: 3px;">B</td>
                                                        <td style="border: 1px solid #000; padding: 3px;">3.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid #000; padding: 3px;">40-49</td>
                                                        <td style="border: 1px solid #000; padding: 3px;">C</td>
                                                        <td style="border: 1px solid #000; padding: 3px;">2.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid #000; padding: 3px;">33-39</td>
                                                        <td style="border: 1px solid #000; padding: 3px;">D</td>
                                                        <td style="border: 1px solid #000; padding: 3px;">1.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid #000; padding: 3px;">0-32</td>
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
                                                <td style="width:40%;" colspan="2">Student's Name
                                                    :{{ $student->first_name ?? '' }}</td>
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
                                $markforcount = count($subjectsmapping) + 1;

                                $studentdata = $student->subjectwisemark ?? [];
                                $studentdataothers = $student->subjectwisemarkother ?? [];

                            @endphp
                            <div class="mobileScreen">
                                <table class="resultDetailsTable" width="100%" cellspacing="0" cellpadding="0"
                                    style="min-width:570px; border-bottom:1px solid black;border-right:1px solid black;">
                                    <tbody>
                                        <tr style="font-weight:bold;">
                                            <!-- <td rowspan="2" style="text-align:center;">Subject Type<br></td> -->
                                            <td rowspan="2" style="text-align:center;">Subject Name</td>
                                            <td colspan="{{ $markforcount + 6 }}" style="text-align:center;">
                                                {{ $exam->exam_title }}</td>



                                        </tr>
                                        <tr style="font-weight:bold;">

                                            <td colspan="" style="text-align:center;">Full Mark</td>
                                            @foreach ($subjectsmapping as $key => $subject)
                                                @if ($subject == 0)
                                                    <td style="text-align:center;">
                                                        CT
                                                    </td>
                                                    <td style="text-align:center;">
                                                        PT
                                                    </td>
                                                    <td style="text-align:center;">
                                                        Total
                                                    </td>
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
                                                $pair_name = $studen->parent_subject;
                                                $text = '';
                                                if ($studen->is_absent == 1) {
                                                    $text = 'Absent';
                                                }

                                                $iscq = $term_marks
                                                    ->flatten(3)
                                                    ->where('subject_id', $studen->subject_id)
                                                    ->where('marks_for', 1)
                                                    ->first()?->pass_mark;
                                                $ismcq = $term_marks
                                                    ->flatten(3)
                                                    ->where('subject_id', $studen->subject_id)
                                                    ->where('marks_for', 2)
                                                    ->first()?->pass_mark;
                                                $ispractical = $term_marks
                                                    ->flatten(3)
                                                    ->where('subject_id', $studen->subject_id)
                                                    ->where('marks_for', 3)
                                                    ->first()?->pass_mark;
                                            @endphp
                                            @if (
                                                $pair_name != null &&
                                                    isset($studentdata[$key1 + 1]->parent_subject) &&
                                                    $pair_name == $studentdata[$key1 + 1]->parent_subject)
                                                <tr>
                                                    <td>{{ $subjects[$studen->subject_id][0]->subject_name ?? '' }}{{ $studen->is_fourth_subject == 1 ? '(4th)' : '' }}
                                                    </td>
                                                    <td style="text-align:center;">
                                                        {{ $studen->subject_id == 9 ? 50 : 100 }}</td>
                                                    @foreach ($subjectsmapping as $key => $subject)
                                                        @if ($subject == 0)
                                                            <td style="text-align:center;">
                                                                {{ $studen->ct1 ? $studen->ct1 : '' }}
                                                            </td>
                                                            <td style="text-align:center;">
                                                                {{ $studen->ct2 ? $studen->ct2 : '' }}
                                                            </td>
                                                            <td style="text-align:center;">
                                                                {{ $studen->ct ?? '' }}
                                                            </td>
                                                        @elseif($subject == 1)
                                                            <td
                                                                style="text-align:center; {{ $iscq > $studen?->cq_total && !in_array($studen->subject_id, [58, 59, 61, 62])
                                                                    ? 'color:red; text-decoration: underline'
                                                                    : '' }}">
                                                                {{-- {{ isset($studen->cq_total) && $studen->cq_total > 0 ? $studen->cq_total : '' }} --}}
                                                                {{ $iscq ? $studen->cq_total : '-' }}
                                                            </td>
                                                        @elseif($subject == 2)
                                                            <td
                                                                style="text-align:center; {{ $ismcq > $studen?->mcq_total && !in_array($studen->subject_id, [58, 59, 61, 62]) ? 'color:red; text-decoration: underline' : '' }}">
                                                                {{ $ismcq ? $studen->mcq_total : '-' }}
                                                                {{-- {{ isset($studen->mcq_total) && $studen->mcq_total > 0 ? $studen->mcq_total : '' }} --}}
                                                            </td>
                                                        @else
                                                            <td
                                                                style="text-align:center; {{ $ispractical > $studen?->practical_total && !in_array($studen->subject_id, [58, 59, 61, 62]) ? 'color:red; text-decoration: underline' : '' }}">
                                                                {{-- {{ isset($studen->practical_total) && $studen->practical_total > 0 ? $studen->practical_total : '-' }} --}}
                                                                {{ $ispractical ? $studen->practical_total : '-' }}

                                                            </td>
                                                        @endif
                                                    @endforeach

                                                    <td style="text-align:center;">

                                                    </td>
                                                    <td style="text-align:center;">
                                                        {{ $text }}
                                                    </td>
                                                    <td style="text-align:center;">

                                                    </td>
                                                    <td style="text-align:center;">
                                                        {{ $subjectHighestMark[$studen->subject_id][0]->highest_mark ?? '' }}
                                                    </td>


                                                    @php

                                                    @endphp
                                                </tr>
                                            @elseif(
                                                $pair_name != null &&
                                                    isset($studentdata[$key1 - 1]->parent_subject) &&
                                                    $pair_name == $studentdata[$key1 - 1]->parent_subject)
                                                <tr>
                                                    <td>{{ $subjects[$studen->subject_id][0]->subject_name ?? '' }}{{ $studen->is_fourth_subject == 1 ? '(4th)' : '' }}
                                                    </td>
                                                    <td style="text-align:center;">
                                                        {{ $studen->subject_id == 9 ? 50 : 100 }}</td>
                                                    @foreach ($subjectsmapping as $key => $subject)
                                                        @if ($subject == 0)
                                                            <td style="text-align:center;">
                                                                {{ $studen->ct1 ? $studen->ct1 : '' }}
                                                            </td>
                                                            <td style="text-align:center;">
                                                                {{ $studen->ct2 ? $studen->ct2 : '' }}
                                                            </td>
                                                            <td style="text-align:center;">
                                                                {{ $studen->ct ?? '' }}
                                                            </td>
                                                        @elseif($subject == 1)
                                                            <td
                                                                style="text-align:center; {{ $iscq > $studen?->cq_total && !in_array($studen->subject_id, [58, 59, 61, 62])
                                                                    ? 'color:red; text-decoration: underline'
                                                                    : '' }}">
                                                                {{-- {{ isset($studen->cq_total) && $studen->cq_total > 0 ? $studen->cq_total : '' }} --}}
                                                                {{ $iscq ? $studen->cq_total : '-' }}
                                                            </td>
                                                        @elseif($subject == 2)
                                                            <td
                                                                style="text-align:center; {{ $ismcq > $studen?->mcq_total && !in_array($studen->subject_id, [58, 59, 61, 62]) ? 'color:red; text-decoration: underline' : '' }}">
                                                                {{-- {{ isset($studen->mcq_total) && $studen->mcq_total > 0 ? $studen->mcq_total : '' }} --}}
                                                                {{ $ismcq ? $studen->mcq_total : '-' }}
                                                            </td>
                                                        @else
                                                            <td
                                                                style="text-align:center; {{ $ispractical > $studen?->practical_total && !in_array($studen->subject_id, [58, 59, 61, 62]) ? 'color:red; text-decoration: underline' : '' }}">
                                                                {{-- {{ isset($studen->practical_total) && $studen->practical_total > 0 ? $studen->practical_total : '-' }} --}}
                                                                {{ $ispractical ? $studen->practical_total : '-' }}
                                                            </td>
                                                        @endif
                                                    @endforeach

                                                    <td style="text-align:center;">

                                                    </td>
                                                    <td style="text-align:center;">
                                                        {{ $text }}
                                                    </td>
                                                    <td style="text-align:center;">


                                                    </td>
                                                    <td style="text-align:center;">
                                                        {{ $subjectHighestMark[$studen->subject_id][0]->highest_mark ?? '' }}
                                                    </td>



                                                </tr>
                                                <tr>
                                                    <td>{{ $pair_name }}</td>
                                                    <td style="text-align:center;">200</td>
                                                    @php

                                                        $ct1 =
                                                            ($studen->ct1 ?? 0) + ($studentdata[$key1 - 1]->ct1 ?? 0);
                                                        $ct2 =
                                                            ($studen->ct2 ?? 0) + ($studentdata[$key1 - 1]->ct2 ?? 0);
                                                        $ct3 =
                                                            ($studen->ct3 ?? 0) + ($studentdata[$key1 - 1]->ct3 ?? 0);
                                                        $ct = ($studen->ct ?? 0) + ($studentdata[$key1 - 1]->ct ?? 0);
                                                        $cq_total =
                                                            ($studen->cq_total ?? 0) +
                                                            ($studentdata[$key1 - 1]->cq_total ?? 0);
                                                        $mcq_total =
                                                            ($studen->mcq_total ?? 0) +
                                                            ($studentdata[$key1 - 1]->mcq_total ?? 0);
                                                        $practical_total =
                                                            ($studen->practical_total ?? 0) +
                                                            ($studentdata[$key1 - 1]->practical_total ?? 0);
                                                        $pair_total_total =
                                                            ($subjectHighestMark[$studen->subject_id][0]
                                                                ->highest_mark ??
                                                                0) +
                                                            ($subjectHighestMark[$studentdata[$key1 - 1]->subject_id][0]
                                                                ->highest_mark ??
                                                                '');

                                                        $pair_total = $ct + $cq_total + $mcq_total + $practical_total;
                                                        $cq_pair_pass_mark = $pair_name == 'English' ? 66 : 46;
                                                        $mcq_pair_pass_mark = 20;
                                                    @endphp
                                                    @foreach ($subjectsmapping as $key => $subject)
                                                        @if ($subject == 0)
                                                            <td style="text-align:center;">
                                                                {{ $ct1 ?? '' }}
                                                            </td>
                                                            <td style="text-align:center;">
                                                                {{ $ct2 ?? '' }}
                                                            </td>
                                                            <td style="text-align:center;">
                                                                {{ $ct ?? '' }}
                                                            </td>
                                                        @elseif($subject == 1)
                                                            <td
                                                                style="text-align:center; {{ $cq_pair_pass_mark > $cq_total ? 'color:red; text-decoration: underline' : '' }}">
                                                                {{-- {{ isset($cq_total) && $cq_total > 0 ? $cq_total : '' }} --}}
                                                                {{ $cq_total > 0 ? $cq_total : '' }}
                                                                {{-- {{ $cq_total ? $cq_total : '' }}  --}}
                                                            </td>
                                                        @elseif($subject == 2)
                                                            <td
                                                                style="text-align:center;
                                                                {{ $mcq_pair_pass_mark > $mcq_total ? 'color:red; text-decoration: underline' : '' }}">
                                                                {{-- {{ isset($mcq_total) && $mcq_total > 0 ? $mcq_total : '' }} --}}
                                                                {{-- {{ $mcq_total ? $mcq_total : '' }} --}}
                                                                {{ $mcq_total > 0 ? $mcq_total : '' }}
                                                            </td>
                                                        @else
                                                            <td style="text-align:center;">
                                                                {{-- {{ $practical_total > 0 ? $practical_total : '-' }} --}}
                                                                {{ $ispractical ? $studen->practical_total : '-' }}
                                                            </td>
                                                        @endif
                                                    @endforeach

                                                    <td style="text-align:center;">
                                                        {{ $pair_total }}
                                                    </td>
                                                    <td style="text-align:center;"
                                                        class="{{ $studen->gpa_point == 0 ? 'redtext' : '' }}">
                                                        {{ $studen->gpa }}
                                                    </td>
                                                    <td style="text-align:center;"
                                                        class="{{ $studen->gpa_point == 0 ? 'redtext' : '' }}">
                                                        {{ $studen->gpa_point }}

                                                    </td>
                                                    <td style="text-align:center;">
                                                        <!-- {{ $pair_total_total ?? '' }} -->
                                                    </td>


                                                    @php
                                                        if ($studen->gpa_point == 0) {
                                                            $gpa_point = -1;
                                                            $isnegative = -1;
                                                        }

                                                        if ($gpa_point != -1) {
                                                            $gpa_point += (float) $studen->gpa_point;
                                                        }

                                                        $total += (int) $pair_total;

                                                    @endphp
                                                </tr>
                                            @else
                                                <tr>
                                                    <td>{{ $subjects[$studen->subject_id][0]->subject_name ?? '' }}{{ $studen->is_fourth_subject == 1 ? '(4th)' : '' }}
                                                    </td>
                                                    <td style="text-align:center;">
                                                        {{ $studen->subject_id == 9 ? 50 : 100 }}</td>
                                                    @foreach ($subjectsmapping as $key => $subject)
                                                        @if ($subject == 0)
                                                            <td style="text-align:center;">
                                                                {{ $studen->ct1 ? $studen->ct1 : '' }}
                                                            </td>
                                                            <td style="text-align:center;">
                                                                {{ $studen->ct2 ? $studen->ct2 : '' }}
                                                            </td>
                                                            <td style="text-align:center;">
                                                                {{ $studen->ct ?? '' }}
                                                            </td>
                                                        @elseif($subject == 1)
                                                            <td
                                                                style="text-align:center; {{ $iscq > $studen?->cq_total && !in_array($studen->subject_id, [58, 59, 61, 62])
                                                                    ? 'color:red; text-decoration: underline'
                                                                    : '' }}">
                                                                {{-- {{ isset($studen->cq_total) && $studen->cq_total > 0 ? $studen->cq_total : '' }} --}}
                                                                {{ $iscq ? $studen->cq_total : '-' }}
                                                            </td>
                                                        @elseif($subject == 2)
                                                            <td
                                                                style="text-align:center; {{ $ismcq > $studen?->mcq_total && !in_array($studen->subject_id, [58, 59, 61, 62]) ? 'color:red; text-decoration: underline' : '' }}">
                                                                {{-- {{ isset($studen->mcq_total) && $studen->mcq_total > 0 ? $studen->mcq_total : '' }} --}}
                                                                {{ $ismcq ? $studen->mcq_total : '-' }}

                                                            </td>
                                                        @else
                                                            <td
                                                                style="text-align:center; {{ $ispractical > $studen?->practical_total && !in_array($studen->subject_id, [58, 59, 61, 62]) ? 'color:red; text-decoration: underline' : '' }}">
                                                                {{-- {{ isset($studen->practical_total) && $studen->practical_total > 0 ? $studen->practical_total : '-' }} --}}
                                                                {{ $ispractical ? $studen->practical_total : '-' }}

                                                            </td>
                                                        @endif
                                                    @endforeach

                                                    <td style="text-align:center;">
                                                        {{ $studen->ct_conv_total }}
                                                    </td>
                                                    <td style="text-align:center;"
                                                        class="{{ $studen->gpa_point == 0 ? 'redtext' : '' }}">

                                                        {{ $text != '' ? $text : $studen->gpa }}
                                                    </td>
                                                    <td style="text-align:center;"
                                                        class="{{ $studen->gpa_point == 0 ? 'redtext' : '' }}">
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
                                            @endif
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
                                            <td colspan="{{ $markforcount + 3 }}">
                                                {{-- Grand Total Marks, Grade and GPA without 4th subject --}}
                                                Grand Total Marks and GPA without 4th subject {{ $markforcount }}
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
                                            <td colspan="{{ $markforcount + 5 }}">
                                                Gp added from 4th subject above 2.0
                                            </td>


                                            <td style="text-align:center;"
                                                class="{{ $isnegative == -1 ? 'redtext' : '' }}">
                                                {{ $forth_subject > 2 ? $forth_subject - 2 : '' }}
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr style="font-weight:bold;">
                                            <td colspan="{{ $markforcount + 5 }}">
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
                                {{-- <table class="resultDetailsTable" cellpadding="0" cellspacing="0"
                                    style="border-bottom: 1px solid black; border-right: 1px solid black;">

                                    <tr>

                                        <td style="text-align:center;">Position in Section</td>
                                        <td style="text-align:center;height: 40px;">Position in Class </td>
                                        <!-- <td style="text-align:center;">Next Class </td>
                                                       <td style="text-align:center;">Next Section</td>
                                                       <td style="text-align:center;">Next Roll </td> -->
                                        <td rowspan="2" style="text-align:center;">
                                            {{ $student->totalmark->position_in_class ?? '' ? 'Promoted' : 'Not Promoted' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center;">
                                            {{ $isnegative == -1 ? '' : $student->totalmark->position_in_section ?? '' }}
                                        </td>
                                        <td style="text-align:center;height: 40px;">
                                            {{ $isnegative == -1 ? '' : $student->totalmark->position_in_class ?? '' }}
                                        </td>

                                        <!-- <td style="text-align:center;"> {{ isset($student->totalmark->next_class) ? $classroman[$student->totalmark->next_class] : '' }} </td>
                                                       <td style="text-align:center;">{{ $student->totalmark->section_name ?? '' }}</td>
                                                       <td style="text-align:center;">{{ $student->totalmark->next_roll ?? '' }}</td> -->
                                    </tr>
                                </table>
                                <br /> --}}
                                {{-- <table class="resultDetailsTable" cellpadding="0" cellspacing="0" style="border-bottom: 1px solid black; border-right: 1px solid black;">

                                                    <tr>

                                                        <td style="text-align:center;" rowspan="3">Subject</td>
                                                        <td style="text-align:center;" colspan="6">Continuous Assessment</td>

                                                    </tr>
                                                    <tr>
                                                        <td style="text-align:center;" colspan="3">Cognitive Assessment</td>
                                                        <td style="text-align:center;" colspan="3">Affective Assessment</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align:center;" >Full Mark</td>
                                                        <td style="text-align:center;" >Theory</td>
                                                        <td style="text-align:center;" >Prac</td>
                                                        <td style="text-align:center;" >Total</td>
                                                        <td style="text-align:center;" >Obtained Marks</td>
                                                        <td style="text-align:center;" >Remarks</td>
                                                    </tr>
                                                    @foreach ($studentdataothers as $key => $subject)
                                                    @php

                                                    @endphp
                                                    <tr>
                                                        <td style="text-align:center;" >{{$subject->subject_name}}</td>
                                                        <!-- <td style="text-align:center;" >{{($subject->subject_id==124)?80:130}}</td> -->
                                                        <td style="text-align:center;" >{{$subject->cq??''}}</td>
                                                        <!-- <td style="text-align:center;" >{{$subject->practical??''}}</td>
                                                        <td style="text-align:center;" >30</td>
                                                        <td style="text-align:center;" >{{$subject->ct??''}}</td> -->
                                                        <td style="text-align:center;" >
                                                           {{$studen->gpa}}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </table> --}}

                                <table class="resultDetailsTableContinuous">
                                    <tr>
                                        <td rowspan="2" style="text-align:center; width: 25%;">Subject</td>
                                        <td colspan="4" style="text-align:center;">Continuous Assessment</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center; width: 15%;">Full Marks</td>
                                        <td style="text-align:center; width: 20%;">Obtained Marks</td>
                                        <td style="text-align:center; width: 15%;">Letter Grade</td>
                                        <td style="text-align:center; width: 25%;">Remarks</td>
                                    </tr>
                                    @foreach ($studentdataothers as $key => $subject)
                                        @php
                                            $fullMarks = $subject->subject_id == 46 ? 100 : 50;

                                            $obtainedMarks = $subject->cq ?? 0;

                                            if ($fullMarks == 50) {
                                                $scaledMarks = $obtainedMarks * 2;
                                            } else {
                                                $scaledMarks = $obtainedMarks;
                                            }

                                            if ($scaledMarks >= 80) {
                                                $grade = 'A+';
                                            } elseif ($scaledMarks >= 70) {
                                                $grade = 'A';
                                            } elseif ($scaledMarks >= 60) {
                                                $grade = 'A-';
                                            } elseif ($scaledMarks >= 50) {
                                                $grade = 'B';
                                            } elseif ($scaledMarks >= 40) {
                                                $grade = 'C';
                                            } elseif ($scaledMarks >= 33) {
                                                $grade = 'D';
                                            } else {
                                                $grade = 'F';
                                            }

                                            $remarks =
                                                $grade == 'A+'
                                                    ? 'Excellent'
                                                    : ($grade == 'A' || $grade == 'A-'
                                                        ? 'Good'
                                                        : ($grade == 'B' || $grade == 'C' || $grade == 'D'
                                                            ? 'Try More'
                                                            : 'Not Satisfactory'));
                                        @endphp
                                        <tr>
                                            <td style="text-align:center;">{{ $subject->subject_name }}</td>
                                            <td style="text-align:center;">{{ $fullMarks }}</td>
                                            <td style="text-align:center;">{{ $obtainedMarks }}</td>
                                            <td style="text-align:center;">{{ $grade }}</td>
                                            <td style="text-align:center;">{{ $remarks }}</td>
                                        </tr>
                                    @endforeach
                                </table>


                                <br />
                                <table class="resultDetailsTable" cellpadding="0" cellspacing="0"
                                    style="border-bottom: 1px solid black; border-right: 1px solid black;">

                                    <tr>

                                        <td style="text-align:left;width: 25%!important">No. of Working Days :</td>
                                        <td style="text-align:center;width: 15%!important">
                                            {{ $student->studentExamAttendance->no_of_working_days ?? '' }}</td>
                                        <td rowspan="5" style="text-align:center;width: 30%!important">
                                            @if ($student->version_id == 1 && $student->class_code > 5 && $student->class_code < 11)
                                                <img src="{{ asset('public/obayed ullah.png') }}"
                                                    style="height: 70px;" />
                                            @else
                                                <img src="{{ asset('public/humayara 02.png') }}"
                                                    style="height: 70px;" />
                                            @endif </br>
                                            Vice Principal
                                        </td>
                                        <td rowspan="5" style="text-align:center;width: 30%!important"><img
                                                src="{{ asset('public/psi.jpg') }}"
                                                style="height: 70px;" /><br />Principal</td>

                                    </tr>
                                    <tr>

                                        <td style="text-align:left;">Total Present :</td>
                                        <td style="text-align:center;">
                                            {{ $student->studentExamAttendance->total_attendance ?? '' }}
                                        </td>

                                    </tr>
                                    <tr>

                                        <td style="text-align:left;">Remarks :</td>
                                        {{-- <td style="text-align:center;">
                                                            @if ($percentage > 79)
                                                            Excelecnt
                                                            @elseif($percentage<79 && $percentage>59)
                                                            Good
                                                            @else
                                                            Bad
                                                            @endif
                                                        </td> --}}
                                        <td style="text-align:center;">
                                            @php
                                                $grade = getGrade($point, $isnegative);
                                            @endphp

                                            @if ($grade == 'A+')
                                                Excellent
                                            @elseif($grade == 'A' || $grade == 'A-')
                                                Good
                                            @elseif($grade == 'B' || $grade == 'C' || $grade == 'D')
                                                Try More
                                            @else
                                                Not Satisfactory
                                            @endif
                                        </td>


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
            contentElement.classList.add('margin-300');

            // Get the content of the element with the added class
            var content = contentElement.innerHTML;

            // Open a new window for printing
            var mywindow = window.open('', 'Print');

            // Write HTML structure and styles to the new window
            mywindow.document.write('<html><head><title>Print Preview</title>');
            mywindow.document.write('<style>@page { size: A4; margin: 200px 5mm 5mm 5mm; }</style>');
            mywindow.document.write('<style>table td { font-size: 13px;padding:1px!important }</style>');
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
