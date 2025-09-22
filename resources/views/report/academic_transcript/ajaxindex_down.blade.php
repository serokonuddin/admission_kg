@extends('admin.layouts.layout')
@section('content')
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

                        @media print {

                            /* Hide elements with the 'noprint' class during print */
                            .noprint {
                                display: none !important;

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
                    <div class="mobileScreenInfo noprint" style="overflow-y:hidden; margin-bottom:20px;">
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
                                            <td>Version: {{ $activity->version->version_name ?? '' }}
                                            </td>
                                            <td>Class : {{ $activity->class_code }}</td>
                                            <td>Section: {{ $activity->section->section_name ?? '' }}
                                            </td>
                                            <td>Roll : {{ $activity->roll ?? '' }}</td>
                                            <td>Year : {{ $activity->session->session_name ?? '' }}</td>

                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div style="text-align:center; padding-bottom:0px;">
                            <spn style="font-weight:bold;font-size:17px; ">Result in Details</spn>
                        </div>
                        @php
                            $markforcount = count($subjectsmapping) + 4;
                            $studentdata = $student->subjectwisemark;

                        @endphp
                        <div class="mobileScreen">
                            <table class="resultDetailsTable" width="100%" cellspacing="0" cellpadding="0"
                                style="min-width:570px; border-bottom:1px solid black;border-right:1px solid black;">
                                <tbody>
                                    <tr style="font-weight:bold;">
                                        <!-- <td rowspan="2" style="text-align:center;">Subject Type<br></td> -->
                                        <td rowspan="2" style="text-align:center;">Subject Name</td>

                                        <td rowspan="2" style="text-align:center;">Full Mark</td>
                                        @php
                                            $sumative = 0;
                                            $formative = 0;

                                            foreach ($subjectsmapping as $key => $subject) {
                                                if ($subject == 0) {
                                                    $formative = 4;
                                                } else {
                                                    $sumative = 1;
                                                }
                                            }

                                        @endphp

                                        @if ($formative > 0)
                                            <td colspan="4" style="text-align:center;">
                                                Formative
                                            </td>
                                        @endif
                                        @if ($sumative > 0)
                                            <td colspan="{{ $sumative + 1 }}" style="text-align:center;">
                                                Sumative
                                            </td>
                                        @endif
                                        <td rowspan="2" style="text-align:center;">Subject <br /> Total</td>
                                        <td rowspan="2" style="text-align:center;">Grade</td>
                                        <td rowspan="2" style="text-align:center;">Grade <br /> Point</td>
                                        <td rowspan="2" style="text-align:center;">Highest <br /> Marks</td>
                                    </tr>
                                    <tr style="font-weight:bold;">
                                        @if ($sumative == 1)
                                            <td style="text-align:center;">
                                                Assignment
                                            </td>
                                            <td style="text-align:center;">
                                                Project <br /> Proposal
                                            </td>
                                            <td style="text-align:center;">
                                                Class <br /> Work
                                            </td>
                                            <td style="text-align:center;">
                                                Total
                                            </td>
                                        @endif
                                        @foreach ($subjectsmapping as $key => $subject)
                                            <!-- @if ($subject == 1)
<td style="text-align:center;">
                                                          CQ
                                                        </td>
@elseif($subject == 2)
<td style="text-align:center;">
                                                          MCQ
                                                        </td>
@elseif($subject == 3)
<td style="text-align:center;">
                                                            Practical
                                                            </td>
@endif -->
                                        @endforeach
                                        <td style="text-align:center;">{{ $exam->exam_title }}</td>
                                        <td style="text-align:center;">Conv to<br /> 70%</td>

                                    </tr>
                                    @php
                                        $total_total = 0;
                                        $gradepoint = 0;
                                        $count = 0;
                                        $hight = [];
                                        $isnegative = 0;
                                        $gpa_point = 0;
                                        $total = 0;
                                        $point = '';
                                    @endphp
                                    @foreach ($studentdata as $key1 => $studen)
                                        <tr>
                                            <td>{{ $subjects[$studen->subject_id][0]->subject_name ?? '' }}</td>
                                            <td style="text-align:center;">100</td>
                                            @foreach ($subjectsmapping as $key => $subject)
                                                @if ($subject == 0)
                                                    <td style="text-align:center;">
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
                                                    </td>
                                                @elseif($subject == 1)
                                                    <td style="text-align:center;">
                                                        {{ $studen->cq_total }}
                                                    </td>
                                                @elseif($subject == 2)
                                                    <td style="text-align:center;">
                                                        {{ $studen->mcq_total }}
                                                    </td>
                                                @else
                                                    <td style="text-align:center;">
                                                        {{ $studen->practical_total }}
                                                    </td>
                                                @endif
                                            @endforeach
                                            <td style="text-align:center;">
                                                {{ $studen->total }}
                                            </td>
                                            <td style="text-align:center;">
                                                {{ $studen->conv_total }}
                                            </td>
                                            <td style="text-align:center;">
                                                {{ $studen->ct_conv_total }}
                                            </td>
                                            <td style="text-align:center;">
                                                {{ $studen->gpa }}
                                            </td>
                                            <td style="text-align:center;">
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
                                                        $gpa_point = -1;
                                                        $isnegative = -1;
                                                    }
                                                    $gpa_point += (int) $studen->gpa_point;
                                                }
                                                if (isset($studen->ct_conv_total)) {
                                                    $total += (int) $studen->ct_conv_total;
                                                }

                                                if ($gpa_point == -1) {
                                                    $point = 0;
                                                } else {
                                                    $point = round($gpa_point / count($subjects), 2);
                                                }

                                            @endphp
                                        </tr>
                                    @endforeach

                                    <tr style="font-weight:bold;">
                                        <td colspan="{{ $markforcount - 1 }}">
                                            Grand Total Marks, Grade and GPA
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td style="text-align:center;">{{ $total ?? '' }}</td>
                                        <td style="text-align:center;"
                                            class="{{ $isnegative == -1 ? 'redtext' : '' }}">
                                            {{ getGrade($point, $isnegative) }}</td>
                                        <td style="text-align:center;"
                                            class="{{ $isnegative == -1 ? 'redtext' : '' }}">
                                            {{ $point ?? '' }}
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr style="font-weight:bold;">
                                        <td colspan="{{ $markforcount - 1 }}">
                                            Percentage of Total Marks
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>

                                        <td></td>
                                        <td style="text-align:center;">{{ round($total / count($subjects)) }}%</td>
                                        <td></td>
                                        <td></td>
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
                                    <td style="text-align:center;height: 40px;">Position in Class </td>
                                    <td style="text-align:center;">Next Class </td>
                                    <td style="text-align:center;">Next Section</td>
                                    <td style="text-align:center;">Next Roll </td>
                                    <td rowspan="2" style="text-align:center;">
                                        {{ $student->totalmark->position_in_class ? 'Promoted' : 'Not Promoted' }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align:center;">
                                        {{ $isnegative == -1 ? '' : $student->totalmark->position_in_section ?? '' }}
                                    </td>
                                    <td style="text-align:center;height: 40px;">
                                        {{ $isnegative == -1 ? '' : $student->totalmark->position_in_class ?? '' }}
                                    </td>

                                    <td style="text-align:center;">
                                        {{ $student->totalmark->next_class ? $classroman[$student->totalmark->next_class] : '' }}
                                    </td>
                                    <td style="text-align:center;">{{ $student->totalmark->section_name ?? '' }}</td>
                                    <td style="text-align:center;">{{ $student->totalmark->next_roll }}</td>
                                </tr>
                            </table>
                            <br />
                            <table class="resultDetailsTable" cellpadding="0" cellspacing="0"
                                style="border-bottom: 1px solid black; border-right: 1px solid black;">

                                <tr>

                                    <td style="text-align:left;width: 25%!important">No. of Working Days :</td>
                                    <td style="text-align:center;width: 15%!important"></td>
                                    <td rowspan="5" style="text-align:center;width: 30%!important" >
                                        @if ($student->studentActivities->version_id == 1 && $student->studentActivities->class_code < 6)
                                            <img src="{{ asset('public/primary_bangla_vp_sign1.png') }}"
                                                style="height: 70px;" />
                                        @elseif ($student->studentActivities->version_id == 2 && $student->studentActivities->class_code < 6)
                                            <img src="{{ asset('public/primary_english_vp_sign1.jpg') }}"
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
@endsection
