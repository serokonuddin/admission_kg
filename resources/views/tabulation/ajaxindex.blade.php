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
                                                border-bottom: none;
                                                border-right: none;
                                                padding: 3px;
                                            }

                                            .page-break {
                                                display: block;
                                                page-break-before: always;
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
                                        @endphp
                                        @foreach ($students as $key => $student)
                                            <div class="mobileScreenInfo"
                                                style="overflow-y:hidden; margin-bottom:20px;">
                                                <table cellpadding="0" cellspacing="0"
                                                    style="width:100%; text-align:center; page-break-inside: avoid;"
                                                    class="tableBorderNo">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <table cellpadding="0" cellspacing="0"
                                                                    class="tableCenter tableBorderNo">
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
                                                                            <td style="width:15%; text-align:center;">
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="printHead"
                                                style="font-family:'Times New Roman, Times, serif';  margin-top:5px;">
                                                <div class="mobileScreenInfo">
                                                    <div style="border:1px solid black; padding:5px;  min-width:560px;">
                                                        <table class="noBorder">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="width:15%;">Name</td>
                                                                    <td colspan="3"> : {{ $student->first_name ?? '' }}
                                                                    </td>
                                                                    <td>Class</td>
                                                                    <td> :
                                                                        {{ $classroman[$student->studentActivity->class_code] ?? '' }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Father's Name</td>
                                                                    <td colspan="3"> :
                                                                        {{ $student->father_name ?? '' }}</td>
                                                                    <td>Class Roll</td>
                                                                    <td> :
                                                                        <strong>{{ $student->studentActivity->roll ?? '' }}</strong>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Mother's Name</td>
                                                                    <td colspan="3"> :
                                                                        {{ $student->mother_name ?? '' }}</td>
                                                                    <td
                                                                        style="width:10%; color:blue; font-weight:bold;">
                                                                        &nbsp;</td>
                                                                    <td
                                                                        style="width:13%; color:blue; font-weight:bold;">
                                                                        &nbsp; </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width:10%;">Group</td>
                                                                    <td> :
                                                                        {{ $student->studentActivity->group->group_name ?? '' }}
                                                                    </td>
                                                                    <td>Version</td>
                                                                    <td> :
                                                                        {{ $student->studentActivity->version->version_name ?? '' }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Gender</td>
                                                                    <td> : {{ $student->gender ?? '' }}</td>
                                                                    <td>Section</td>
                                                                    <td> :
                                                                        {{ $student->studentActivity->section->section_name ?? '' }}
                                                                    </td>
                                                                    <td>Session</td>
                                                                    <td><span>:</span>
                                                                        {{ $student->studentActivity->session->session_name ?? '' }}-{{ (int) $student->studentActivity->session->session_name + 1 }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td> </td>
                                                                    <td>House</td>
                                                                    <td> :
                                                                        {{ $student->studentActivity->house->house_name ?? '' }}
                                                                    </td>
                                                                    <td>SSC GPA</td>
                                                                    <td> : {{ $student->result ?? '' }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <table
                                                    style="margin-left:auto; margin-right:auto; margin-top:15px; margin-bottom:10px; font-size:18px; font-weight:bold;">
                                                    <tbody>
                                                        <tr>
                                                            <td
                                                                style="border:2px solid black; padding-left:7px; padding-right:7px;">
                                                                Exam Name : {{ $exam->exam_title }}</td>
                                                            <td>&nbsp;</td>
                                                            <td
                                                                style="border:2px solid black; padding-left:7px; padding-right:7px;">
                                                                Exam Held :
                                                                {{ date('M-y', strtotime($exam->start_date)) }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div style="text-align:center; padding-bottom:0px;">
                                                    <spn style="font-weight:bold;font-size:17px; ">Result in Details
                                                    </spn>
                                                </div>
                                                @php
                                                    $markforcount = count($subjectsmapping) + 1;

                                                    $subjects = collect($student->subjectmark)->groupBy([
                                                        'subject_id',
                                                        'marks_for',
                                                    ]);

                                                    $fourthSubjects = collect($student->subjectmark)->filter(function (
                                                        $subjectmark,
                                                    ) {
                                                        return $subjectmark->is_fourth_subject == 1;
                                                    });
                                                    $fsubjects = collect($fourthSubjects)->groupBy(['subject_id']);
                                                    $fourthsubjectscount = count($fsubjects);

                                                    $subjectcount = count($subjects) - count($fourthSubjects);
                                                @endphp
                                                <div class="mobileScreen">
                                                    <table class="resultDetailsTable" width="100%" cellspacing="0"
                                                        cellpadding="0"
                                                        style="min-width:570px; border-bottom:1px solid black;border-right:1px solid black;">
                                                        <tbody>
                                                            <tr style="font-weight:bold;">
                                                                <!-- <td rowspan="2" style="text-align:center;">Subject Type<br></td> -->
                                                                <td rowspan="2" style="text-align:center;">Subject
                                                                    Name</td>
                                                                <td colspan="{{ $markforcount }}"
                                                                    style="text-align:center;">Marks Obtained</td>
                                                                <td rowspan="2" style="text-align:center;">Letter
                                                                    Grade</td>
                                                                <td rowspan="2" style="text-align:center;">Grade
                                                                    Point</td>
                                                                <td rowspan="2" style="text-align:center;">Highest
                                                                    Marks</td>
                                                                <td rowspan="{{ $subjectcount > 7 ? $subjectcount + 2 : $subjectcount + 2 }}"
                                                                    style="text-align:right; vertical-align:top;">
                                                                    <div
                                                                        style="transform: rotate(90deg); text-align:center; vertical-align:middle; white-space:nowrap; width:15px; margin-left:10px; margin-right:2px; font-weight:normal; font-size:11px;">
                                                                        &nbsp;&nbsp;GP added from 4th subject above 2.0
                                                                    </div>
                                                                </td>
                                                                <td rowspan="2" style="text-align:center;">
                                                                    GPA<br><span style="font-size:10px;">Without 4th
                                                                        sub.</span> </td>
                                                                <td rowspan="2" style="text-align:center;">
                                                                    GPA<br><span style="font-size:10px;">With 4th
                                                                        sub.</span> </td>
                                                            </tr>
                                                            <tr style="font-weight:bold;">
                                                                @foreach ($subjectsmapping as $key => $subject)
                                                                    <td style="text-align:center;">
                                                                        @if ($subject == 0)
                                                                            Theory
                                                                        @elseif($subject == 1)
                                                                            CQ
                                                                        @elseif($subject == 2)
                                                                            MCQ
                                                                        @else
                                                                            Practical
                                                                        @endif
                                                                    </td>
                                                                @endforeach


                                                                <td style="text-align:center;">Total</td>
                                                            </tr>
                                                            @foreach ($subjects as $key => $subject)
                                                                <tr>
                                                                    <!-- <td rowspan="3" style="text-align:center; font-weight:bold;">
                                                        Compulsory
                                                    </td> -->
                                                                    <td style="text-align:center;">
                                                                        {{ $subject[1][0]->subject->subject_name ?? '' }}
                                                                    </td>
                                                                    @php
                                                                        $total_mark = 0;
                                                                        $is_fourth_subject = 0;
                                                                    @endphp
                                                                    @foreach ($subjectsmapping as $key => $subj)
                                                                        @if (isset($subject[$subj][0]->total_mark))
                                                                            <td style="text-align:center;"
                                                                                class="">
                                                                                {{ $subject[$subj][0]->total_mark }}
                                                                                @php
                                                                                    if (
                                                                                        $subject[$subj][0]
                                                                                            ->is_fourth_subject
                                                                                    ) {
                                                                                        $is_fourth_subject = 1;
                                                                                    }
                                                                                    $total_mark +=
                                                                                        (int) $subject[$subj][0]
                                                                                            ->total_mark;
                                                                                @endphp
                                                                            </td>
                                                                        @else
                                                                            <td>

                                                                            </td>
                                                                        @endif
                                                                    @endforeach

                                                                    <td style="text-align:center;" class="">
                                                                        {{ $total_mark }}</td>
                                                                    @php
                                                                        $grade = getGradeByMark($grades, $total_mark);

                                                                    @endphp
                                                                    <td style="text-align:center;">{{ $grade->grade }}
                                                                    </td>
                                                                    <td style="text-align:center;">
                                                                        {{ $grade->grade_point }}</td>
                                                                    <td style="text-align:center;"></td>
                                                                    @if ($is_fourth_subject)
                                                                        <td style="text-align:center;">
                                                                            {{ $grade->grade_point > 2 ? $grade->grade_point - 2 : 0 }}
                                                                        </td>
                                                                    @endif
                                                                    <!-- <td style="text-align:center;" rowspan="{{ $subjectscount }}">4.08</td>
                                                    <td style="text-align:center;" rowspan="{{ $subjectscount }}">4.33</td> -->
                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div style="padding-top:10px; padding-bottom:5px">
                                                    <table class="resultDetailsTable" cellpadding="0" cellspacing="0"
                                                        style="border-bottom: 1px solid black; border-right: 1px solid black;">
                                                        <tbody>
                                                            <tr>
                                                                <td width="22%" style="border-right:none;">Result
                                                                </td>
                                                                <td width="1%"
                                                                    style="border-left:none;border-right:none;">:</td>
                                                                <td width="37%"
                                                                    style="text-align:center; font-weight:bold;border-left:none; ">
                                                                    <span>Passed</span>
                                                                </td>
                                                                <td width="30%" rowspan="9"></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border-right:none;">Total Marks</td>
                                                                <td style="border-left:none;border-right:none;">:</td>
                                                                <td
                                                                    style="text-align:center; font-weight:bold;border-left:none; ">
                                                                    494</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border-right:none;">Position in Section</td>
                                                                <td style="border-left:none; border-right:none;">:</td>
                                                                <td
                                                                    style="border-left:none; text-align:center; font-weight:bold;">
                                                                    <span>4</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border-right:none;">Position in Group</td>
                                                                <td style="border-left:none; border-right:none;">:</td>
                                                                <td
                                                                    style="border-left:none; text-align:center; font-weight:bold;">
                                                                    <span>
                                                                        18
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border-right:none;">Remarks</td>
                                                                <td style="border-left:none;border-right:none;">:</td>
                                                                <td style="border-left:none; text-align:center;">
                                                                    <span>Congratulations! Keep it.</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border-right:none;">No. of Working Days</td>
                                                                <td style="border-left:none;border-right:none;">:</td>
                                                                <td
                                                                    style="border-left:none; text-align:center; font-weight:bold;">
                                                                    0</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border-right:none;">Total Attendance</td>
                                                                <td style="border-left:none;border-right:none;">:</td>
                                                                <td
                                                                    style="border-left:none; text-align:center; font-weight:bold;">
                                                                    0</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border-right:none;">Total Absent</td>
                                                                <td style="border-left:none;border-right:none;">:</td>
                                                                <td
                                                                    style="border-left:none; text-align:center; font-weight:bold;">
                                                                    0</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border-right:none;">Class Teacher's
                                                                    Signature</td>
                                                                <td style="border-left:none;border-right:none;">:</td>
                                                                <td
                                                                    style="border-left:none; text-align:center; font-weight:bold;">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border-right:none;">Guardian's Signature
                                                                </td>
                                                                <td style="border-left:none;border-right:none;">:</td>
                                                                <td
                                                                    style="border-left:none; text-align:center; font-weight:bold;">
                                                                </td>
                                                                <td style="text-align:center;font-weight:bold;"
                                                                    nowrap="">Principal / Vice-Principal</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table class="noBorder" width="100%" style="margin-top:18px;">
                                                        <tbody>
                                                            <tr style="border:1px thin black;">
                                                                <td
                                                                    style="float:left; font-size:12px; font-weight:bold;">
                                                                    Result Published Date : </td>
                                                                <td
                                                                    style="float:right; font-size:12px; font-weight:bold; color: gray;">
                                                                    Developed by : </td>
                                                            </tr>
                                                        </tbody>
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
