
<div class="" id="ReportBox">
    <div class="row onlineResultPartial" style="margin:0px;">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="pull-right">
                    <input type="button" class="btn btn-success btn-panel-head"
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
                            } else {
                                return 0.0; // F
                            }
                        }
                        function getGrade($point)
                        {
                            if ($point == 5) {
                                return 'A+';
                            } elseif ($point >= 4 && $point < 5) {
                                return 'A';
                            } elseif ($point >= 3.5 && $point < 4) {
                                return 'A-';
                            } elseif ($point >= 3 && $point < 3.5) {
                                return 'B';
                            } else {
                                return 'F';
                            }
                        }

                        function getRemarks($grade)
                        {
                            switch ($grade) {
                                case 'A+':
                                    return 'Outstanding';
                                case 'A':
                                    return 'Very Good';
                                case 'A-':
                                    return 'Satisfactory';
                                case 'B':
                                    return 'Not Satisfactory';
                                default:
                                    return 'Be Cautious';
                            }
                        }

                        function getGradeByMark($grades, $mark)
                        {
                            foreach ($grades as $grade) {
                                if ($mark >= $grade->start_mark && $mark <= $grade->end_mark) {
                                    return $grade;
                                }
                            }
                            return null;
                        }

                    @endphp
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
                                                         <h3 class="text-center"
                                                            style="color:red; margin-top: 5px; margin-bottom: 0px; font-size:20px; font-weight:bold; white-space: nowrap;">
                                                            Academic Transcript</h3>
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
                                            <td style="width:40%;" colspan="2">Student's Name
                                                :{{ strtoupper($student->first_name ?? '') }} </td>
                                            <td style="width:60%;" colspan="3">Class Teacher :
                                                {{ $classteacher->employee_name ?? '' }}
                                                ({{ $classteacher->mobile ?? '' }})</td>

                                        </tr>
                                        <tr>
                                            <td>Version:
                                                {{ $activity->version->version_name ?? '' }}
                                            </td>
                                            <td>Class : {{ $classroman[$activity->class_code] }}
                                            </td>
                                            <td>Section:
                                                {{ $activity->section->section_name ?? '' }}
                                            </td>
                                            <td>Roll : {{ $activity->roll ?? '' }}</td>
                                            <td>Year : {{ $activity->session->session_name ?? '' }}
                                            </td>

                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div style="text-align:center; padding-bottom:0px;">
                            <span style="font-weight:bold;font-size:17px; ">Result in Details</span><br />
                            <span style="font-weight:bold;font-size:17px; ">{{ $exam->exam_title }}
                                {{ ':' }} {{ $activity->session->session_name ?? '' }}
                            </span>
                        </div>

                        <div class="mobileScreen">
                            <table class="resultDetailsTable" width="100%" cellspacing="0" cellpadding="0"
                                style="min-width:570px; border-bottom:1px solid black;border-right:1px solid black;">
                                <tbody>
                                    <tr style="font-weight:bold;">
                                        <!-- <td rowspan="2" style="text-align:center;">Subject Type<br></td> -->
                                        <td style="text-align:center;">Subject Name</td>
                                        <td style="text-align:center;">CT-1</td>
                                        <td style="text-align:center;">CT-2</td>
                                        <td style="text-align:center;">Total Marks</td>
                                        <td style="text-align:center;">Converted To</td>
                                        <td style="text-align:center;">Grade Point</td>
                                        <td style="text-align:center;">Grade</td>
                                        <td style="text-align:center;">Highest Marks </td>



                                    </tr>

                                    @php
                                        $totalsubject = 0;
                                        $totalgpa = 0;
                                        $totalmark = 0;
                                        $total = 0;
                                        if ($exam->class_code == 0) {
                                            $totalmarkvalue = (count($subjects) - 1) * 100;
                                        } else {
                                            $totalmarkvalue = count($subjects) * 100;
                                        }

                                    @endphp
                                    @foreach ($subjects as $key => $subject)
                                        @php
                                            $marks = [];

                                            if (isset($student->subjectwisemark)) {
                                                $marks = collect($student->subjectwisemark)->groupBy('subject_id');
                                            }

                                            if ($subject[0]->id != 39 && $subject[0]->id != 38) {
                                                $totalsubject++;
                                                $total += $marks[$subject[0]->id][0]->conv_total ?? 0;
                                                $totalmark += $marks[$subject[0]->id][0]->conv_total ?? 0;
                                                $totalgpa += $marks[$subject[0]->id][0]->gpa_point ?? 0;
                                            } elseif ($subject[0]->id == 39) {
                                                //   $markvalue = $marks[$subject[0]->id][0]->ct2 ?? 0; -->
                                                //  $total += $markvalue * 4;
                                            } elseif ($subject[0]->id == 38) {
                                                $markvalue = $marks[$subject[0]->id][0]->ct2 ?? 0;
                                                $total += $markvalue * 4;
                                                $totalsubject++;
                                                $totalmark += $marks[$subject[0]->id][0]->conv_total ?? 0;
                                                $totalgpa += $marks[$subject[0]->id][0]->gpa_point ?? 0;
                                            }
                                        @endphp
                                        <tr>
                                            <td style="text-align:center;">{{ $subject[0]->subject_name ?? '' }}
                                            </td>
                                            <td style="text-align:center;">
                                                {{ $marks[$subject[0]->id][0]->ct1 ?? '' }}</td>
                                            <td style="text-align:center;">
                                                {{ $marks[$subject[0]->id][0]->ct2 ?? '' }}</td>
                                            <td style="text-align:center;">
                                                {{ ($marks[$subject[0]->id][0]->ct1 ?? 0) + ($marks[$subject[0]->id][0]->ct2 ?? 0) }}
                                            </td>
                                            <td style="text-align:center;">
                                                {{ $marks[$subject[0]->id][0]->conv_total ?? '' }}</td>
                                            <td style="text-align:center;">
                                                {{ $marks[$subject[0]->id][0]->gpa_point ?? '' }}</td>
                                            <td style="text-align:center;">
                                                {{ $marks[$subject[0]->id][0]->gpa ?? '' }}</td>
                                            <td style="text-align:center;">
                                                {{ $subjectHighestMark_avg[$subject[0]->id][0]->highest_mark ?? '' }}

                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td style="text-align:center;">Grand Total Marks, GPA, Grade</td>
                                        <td style="text-align:center;"></td>
                                        <td style="text-align:center;"></td>
                                        <td style="text-align:center;"></td>
                                        <td style="text-align:center;">{{ $totalmark ?? '' }}</td>
                                        <td style="text-align:center;">{{ round($totalgpa / $totalsubject, 2) }}
                                        </td>
                                        <td style="text-align:center;">
                                            {{ getGrade(round($totalgpa / $totalsubject, 2)) }}</td>
                                        <td style="text-align:center;"></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center;">Percentage of Total Marks</td>
                                        <td style="text-align:center;"></td>
                                        <td style="text-align:center;"></td>
                                        <td style="text-align:center;"></td>
                                        <td style="text-align:center;">
                                            {{ round(($total * 100) / $totalmarkvalue, 2) }}%
                                        </td>
                                        <td style="text-align:center;"></td>
                                        <td style="text-align:center;"></td>
                                        <td style="text-align:center;"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div style="padding-top:10px; padding-bottom:5px">
                            <table class="resultDetailsTable" cellpadding="0" cellspacing="0"
                                style="border-bottom: 1px solid black; border-right: 1px solid black;">
                                <tr>
                                    <!-- Conditionally render the 'Position in Class' cell -->
                                    @if ($activity->class_code != 0)
                                        <td style="text-align:center;height: 40px;">Position in Class</td>
                                    @endif
                                    <td style="text-align:center;">Next Class </td>
                                    <td style="text-align:center;">Next Section</td>
                                    <td style="text-align:center;">Next Roll </td>
                                    <td rowspan="2" style="text-align:center;">
                                        {{-- {{ $student->totalmark->position_in_class==0? 'Promoted' : 'Not Promoted' }} --}}
                                        {{ $student->totalmark->position_in_class != 0 ? 'Promoted' : 'Not Promoted' }}
                                    </td>
                                </tr>
                                <tr>
                                    <!-- Conditionally render the 'Position in Class' data cell -->
                                    @if ($activity->class_code != 0)
                                        <td style="text-align:center;height: 40px;">
                                            {{ $student->totalmark->position_in_class ?? '' }}
                                        </td>
                                    @endif
                                    <td style="text-align:center;">
                                        {{ isset($student->totalmark->next_class) ? $classroman[$student->totalmark->next_class] ?? '' : '' }}
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
                                    <td style="text-align:center;width: 15%!important">
                                        {{ $student->studentExamAttendance->no_of_working_days ?? '' }}</td>
                                    <td rowspan="5" style="text-align:center;width: 30%!important">
                                        {{-- @dd($student->studentActivities); --}}
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
                                    <td style="text-align:center;">
                                        {{ $student->studentExamAttendance->total_attendance ?? '' }}</td>

                                </tr>
                                <tr>
                                    <td style="text-align:left;">Remarks :</td>
                                    <td style="text-align:center;">
                                        {{ getRemarks(getGrade(round($totalgpa / $totalsubject, 2))) }}
                                    </td>
                                </tr>
                                <tr>

                                    <td style="text-align:left;">Class Teacher's Signature :</td>
                                    <td style="text-align:center;"></td>

                                </tr>
                                <tr>

                                    <td style="text-align:left;">Guardian's Signature :</td>
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
            contentElement.classList.add('margin-300');

            // Get the content of the element with the added class
            var content = contentElement.innerHTML;

            // Open a new window for printing
            var mywindow = window.open('', 'Print');

            // Write HTML structure and styles to the new window
            mywindow.document.write('<html><head><title>Print Preview</title>');
            mywindow.document.write('<style>@page { size: A4; margin: 150px 5mm 5mm 5mm; }</style>');
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

