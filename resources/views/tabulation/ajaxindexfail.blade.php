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
                    @endphp

                    <div class="mobileScreenInfo " style="overflow-y:hidden; margin-bottom:20px;">
                        <table cellpadding="0" cellspacing="0"
                            style="width:100%; text-align:center;page-break-inside: auto;" class="tableBorderNo">
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
                                                            Fail Report </h3>
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


                        <div style="text-align:center; padding-bottom:0px;">
                            <spn style="font-weight:bold;font-size:17px; ">Result in Details</spn>
                        </div>

                        <div class="mobileScreen">
                            <table class="resultDetailsTable" width="100%" cellspacing="0" cellpadding="0"
                                style="min-width:570px;">
                                <tbody>
                                    <tr>
                                        <td style="border: none;">
                                            <b>Examination Name:Class {{ $classroman[$exam->class_code] }}
                                                {{ $exam->exam_title }}</b>
                                        </td>
                                        <td style="border: none;text-align: right">
                                            <b>Date: {{ date('M-y') }}</b>
                                        </td>
                                    </tr>
                                    @php
                                        $genders = collect($students)->groupBy('gender');

                                    @endphp
                                    <tr>
                                        <td style="border: none;">
                                            <b>Total Fail: {{ count($students) }}</b>
                                        </td>
                                        <td style="border: none;text-align: right">
                                            <b>Male:
                                                {{ isset($genders[1]) ? count($genders[1]) : '' }}</b>&nbsp;&nbsp;&nbsp;
                                            <b>Female: {{ isset($genders[2]) ? count($genders[2]) : '' }}</b>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="resultDetailsTable" width="100%" cellspacing="0" cellpadding="0"
                                style="min-width:570px; border-bottom:1px solid black;border-right:1px solid black;">
                                <tbody>
                                    <tr style="font-weight:bold;">
                                        <!-- <td rowspan="2" style="text-align:center;">Subject Type<br></td> -->
                                        <td style="text-align:center;">Sl</td>
                                        <td style="text-align:center;">Section</td>
                                        <td style="text-align:center;">Class Roll</td>
                                        <td style="text-align:center;">Student Name </td>
                                        <td style="text-align:center;">Mobile</td>
                                        <td style="text-align:center;">Subjects</td>





                                    </tr>
                                    @foreach ($students as $key => $student)
                                        <tr style="font-weight:bold;">
                                            <td style="text-align:center;">{{ $key + 1 }}</td>
                                            <td style="text-align:center;">{{ $student->section_name }}</td>
                                            <td style="text-align:center;">{{ $student->studentActivity->roll }}</td>
                                            <td style="text-align:left;">{{ $student->first_name }}</td>
                                            <td style="text-align:center;">{{ $student->sms_notification }}</td>
                                            <td style="text-align:left;">
                                                @php

                                                    $studentdata = $student->subjectwisemark ?? [];

                                                    $text = '';

                                                    foreach ($studentdata as $key1 => $subject) {
                                                        $terms = collect($subject->subjectmarkterms)
                                                            ->unique('marks_for')
                                                            ->sortBy('marks_for');

                                                        $markshow = '';
                                                        foreach ($terms as $term) {
                                                            if ($term->marks_for == 1) {
                                                                $markshow .= 'CQ(' . $subject->cq_total . ')';
                                                            }

                                                            if ($term->marks_for == 2) {
                                                                $markshow .= ', MCQ(' . $subject->mcq_total . ')';
                                                            }

                                                            if ($term->marks_for == 3) {
                                                                $markshow .=
                                                                    ', Practical(' . $subject->practical_total . ') ';
                                                            }
                                                        }

                                                        $text .= $subject->subject_name . ': (' . $markshow . ')<br/>';
                                                    }

                                                @endphp
                                                {!! $text !!}
                                            </td>



                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                        <br>

                    </div>
                    <!-- <div class="page-break"></div> -->



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
            // Created by
            var createdBy = "{{ $createdBy }}";
            // var createdByContent = `<p><strong>Created By:</strong> ${createdBy}</p>`;
            var footerContent = `
                <footer style="position: fixed; bottom: 0; width: 100%; text-align: Left; font-size: 12px; border-top: 1px solid #ccc; padding: 5px 0;">
                    <p><strong>Created By:</strong> ${createdBy}</p>
                </footer>
            `;
            // Open a new window for printing
            var mywindow = window.open('', 'Print');

            // Write HTML structure and styles to the new window
            mywindow.document.write('<html><head><title>Fail List</title>');
            mywindow.document.write('<style>@page { size: 210mm 297mm; margin: 5mm 5mm 10mm 5mm; }</style>');

            mywindow.document.write('</head><body>');
            mywindow.document.write(content); // Print the content
            // mywindow.document.write(footerContent)
            mywindow.document.write(`
            <div style="margin-top: 10px; font-size: 12px; text-align: left;">
                <p><strong>Created By:</strong> ${createdBy}</p>
            </div>
        `);
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
