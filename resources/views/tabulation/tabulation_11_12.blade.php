<div id="ReportBox">
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
                            text-decoration: underline;
                        }

                        @media print {

                            /* Hide elements with the 'noprint' class during print */
                            .noprint {
                                display: none !important;

                            }

                        }
                    </style>
                    {{-- Header Table section --}}
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
                                                            Tabulation Sheet</h3>
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
                        {{-- Exam details table info --}}
                        {{-- <div class="mobileScreenInfo">
                            <div style="">
                                <table class="resultDetailsTable">
                                    <tbody>
                                        <tr>
                                            <td>Exam Name:</td>
                                            <td>Class: </td>
                                            <td>Exam Held: </td>
                                        </tr>
                                        <tr>
                                            <td>Group:</td>
                                            <td>Session:</td>
                                            <td>Section:</td>
                                        </tr>
                                        <tr>
                                            <td>Total Student:</td>
                                            <td>Total Passed:</td>
                                            <td>Total Failed:</td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div> --}}
                        <div class="mobileScreen">
                            <table class="resultDetailsTable" width="100%" cellspacing="0" cellpadding="0"
                                style="min-width:570px; border-bottom:1px solid black; border-right:1px solid black;">

                                <thead>
                                    <tr>
                                        <th style="text-align: center;">SL</th>
                                        <th style="text-align: center;">Class Roll & Name</th>
                                        <th style="text-align: center;">Result</th>
                                        <th style="text-align: center;">Sub Name</th>
                                        <th style="text-align: center;">CQ</th>
                                        <th style="text-align: center;">MCQ</th>
                                        <th style="text-align: center;">Prac</th>
                                        <th style="text-align: center;">Total</th>
                                        <th style="text-align: center;">Conv 70%</th>
                                        <th style="text-align: center;">CT</th>
                                        <th style="text-align: center;">Quiz</th>
                                        <th style="text-align: center;">Total</th>
                                        <th style="text-align: center;">Conv 30%</th>
                                        <th style="text-align: center;">Sub Total</th>
                                        <th style="text-align: center;">Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $k => $student)
                                        @for ($key = 0; $key < 7; $key++)
                                            @php
                                                $subjectId = $student->subjectwisemark[$key]->subject_id ?? null;
                                                $cqTotal = $student->subjectwisemark[$key]->cq_total ?? null;
                                                $mcqTotal = $student->subjectwisemark[$key]->mcq_total ?? null;
                                                $practicalTotal =
                                                    $student->subjectwisemark[$key]->practical_total ?? null;
                                                $isAbsent = $student->subjectwisemark[$key]->is_absent ?? null;

                                                $isCqAbsent = $student->subjectwisemark[$key]->is_cq_abs ?? 0;
                                                $isMcqAbsent = $student->subjectwisemark[$key]->is_mcq_abs ?? 0;
                                                $isPracAbsent = $student->subjectwisemark[$key]->is_prac_abs ?? 0;
                                                $isCtAbsent = $student->subjectwisemark[$key]->is_ct_abs ?? 0;
                                                $isQuizAbsent = $student->subjectwisemark[$key]->is_quiz_abs ?? 0;

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
                                            @if ($key <= 2)
                                                <tr>
                                                    @if ($key == 0)
                                                        <td rowspan="7" style="text-align: center;">
                                                            {{ $k + 1 }}</td>
                                                        <td rowspan="7"
                                                            style="text-align: center;white-space: normal;width: 200px;">
                                                            {{ $student->student_code }}</br></br>
                                                            {{ $student->first_name }}
                                                        </td>
                                                        <td rowspan="3"
                                                            style="text-align: center;white-space: normal;width: 90px;">
                                                            {{ isset($student->totalmark->position_in_section) && $student->totalmark->position_in_section != 0 ? $student->totalmark->grade_point : 0 }}
                                                        </td>
                                                    @endif

                                                    <td style="text-align: center;">
                                                        {{ $student->subjectwisemark[$key]->short_name ?? '' }}
                                                    </td>
                                                    <!-- CQ Total Column -->
                                                    <td
                                                        style="text-align: center; {{ $highlightCq || $isCqAbsent ? 'color: red; text-decoration: underline;' : '' }}">
                                                        {{-- {{ $isAbsent === 0 ? $cqTotal : '' }} --}}
                                                        {{ $isCqAbsent == 1 ? 'A' : $cqTotal ?? '' }}
                                                    </td>

                                                    <!-- MCQ Total Column -->
                                                    <td
                                                        style="text-align: center; {{ $highlightMcq || $isMcqAbsent ? 'color: red; text-decoration: underline;' : '' }}">
                                                        @if ($subjectId && in_array($subjectId, $specialSubjectsMcq))
                                                            {{ '-' }}
                                                        @else
                                                            {{ $isMcqAbsent == 1 ? 'A' : $mcqTotal ?? '' }}
                                                        @endif
                                                    </td>

                                                    <!-- Practical Total Column -->
                                                    <td
                                                        style="text-align: center; {{ $highlightPractical || $isPracAbsent ? 'color: red; text-decoration: underline;' : '' }}">
                                                        {{ $hidePractical ? '-' : ($isPracAbsent == 1 ? 'A' : $practicalTotal ?? '') }}
                                                    </td>

                                                    <td style="text-align: center;">
                                                        {{ $student->subjectwisemark[$key]->total ?? '' }}</td>
                                                    <td style="text-align: center;">
                                                        {{ $student->subjectwisemark[$key]->conv_total ?? '' }}</td>
                                                    <td
                                                        style="text-align: center; {{ $isCtAbsent ? 'color: red; text-decoration: underline;' : '' }}">
                                                        {{ $isCtAbsent == 1 ? 'A' : ($student->subjectwisemark[$key]->ct1 ?? 0) + ($student->subjectwisemark[$key]->ct2 ?? 0) }}
                                                    </td>
                                                    <td
                                                        style="text-align: center; {{ $isQuizAbsent ? 'color: red; text-decoration: underline;' : '' }}">
                                                        {{ $isQuizAbsent ? 'A' : ($student->subjectwisemark[$key]->ct3 ?? 0) + ($student->subjectwisemark[$key]->ct4 ?? 0) }}
                                                    </td>
                                                    <td style="text-align: center;">
                                                        {{ ($student->subjectwisemark[$key]->ct1 ?? 0) + ($student->subjectwisemark[$key]->ct2 ?? 0) + ($student->subjectwisemark[$key]->ct3 ?? 0) + ($student->subjectwisemark[$key]->ct4 ?? 0) }}
                                                    </td>
                                                    <td
                                                        style="text-align: center; {{ isset($student->subjectwisemark[$key]->ct) && $student->subjectwisemark[$key]->ct < 10 ? 'color: red; text-decoration: underline;' : '' }}">
                                                        {{ $student->subjectwisemark[$key]->ct ?? '' }}</td>
                                                    <td
                                                        style="text-align: center; {{ isset($student->subjectwisemark[$key]->gpa) && $student->subjectwisemark[$key]->gpa == 'F' ? 'color: red; text-decoration: underline;' : '' }}">
                                                        {{ $student->subjectwisemark[$key]->ct_conv_total ?? '' }}
                                                    </td>
                                                    <td
                                                        style="text-align: center; {{ isset($student->subjectwisemark[$key]->gpa) && $student->subjectwisemark[$key]->gpa == 'F' ? 'color: red; text-decoration: underline;' : '' }}">
                                                        {{ $student->subjectwisemark[$key]->gpa ?? '' }}
                                                    </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    @if ($key == 3)
                                                        {{-- <td rowspan="4" style="text-align: center;white-space: normal;width: 200px;">
                                                {{$student->first_name}}
                                                </td> --}}
                                                        <td rowspan="4"
                                                            style="text-align: center;white-space: normal;width: 90px;">
                                                            Position
                                                            in
                                                            Section:
                                                            {{ $student->totalmark->position_in_section ?? '' }}
                                                        </td>
                                                    @endif
                                                    <td style="text-align: center;">
                                                        {{ $student->subjectwisemark[$key]->short_name ?? '' }}</td>

                                                    <!-- CQ Total Column -->
                                                    <td
                                                        style="text-align: center; {{ $highlightCq || $isCqAbsent ? 'color: red; text-decoration: underline;' : '' }}">
                                                        {{-- {{ $isAbsent === 0 ? $cqTotal : '' }} --}}
                                                        {{ $isCqAbsent == 1 ? 'A' : $cqTotal ?? '' }}
                                                    </td>

                                                    <!-- MCQ Total Column -->
                                                    <td
                                                        style="text-align: center; {{ $highlightMcq || $isMcqAbsent ? 'color: red; text-decoration: underline;' : '' }}">
                                                        @if ($subjectId && in_array($subjectId, $specialSubjectsMcq))
                                                            {{ '-' }}
                                                        @else
                                                            {{ $isMcqAbsent == 1 ? 'A' : $mcqTotal ?? '' }}
                                                        @endif
                                                    </td>

                                                    <!-- Practical Total Column -->
                                                    <td
                                                        style="text-align: center; {{ $highlightPractical || $isPracAbsent ? 'color: red; text-decoration: underline;' : '' }}">
                                                        {{ $hidePractical ? '-' : ($isPracAbsent == 1 ? 'A' : $practicalTotal ?? '') }}
                                                    </td>

                                                    <td style="text-align: center;">
                                                        {{ $student->subjectwisemark[$key]->total ?? '' }}</td>
                                                    <td style="text-align: center;">
                                                        {{ $student->subjectwisemark[$key]->conv_total ?? '' }}</td>
                                                    <td
                                                        style="text-align: center; {{ $isCtAbsent ? 'color: red; text-decoration: underline;' : '' }}">
                                                        {{ $isCtAbsent == 1 ? 'A' : ($student->subjectwisemark[$key]->ct1 ?? 0) + ($student->subjectwisemark[$key]->ct2 ?? 0) }}
                                                    </td>
                                                    <td
                                                        style="text-align: center; {{ $isQuizAbsent ? 'color: red; text-decoration: underline;' : '' }}">
                                                        {{ $isQuizAbsent ? 'A' : ($student->subjectwisemark[$key]->ct3 ?? 0) + ($student->subjectwisemark[$key]->ct4 ?? 0) }}
                                                    </td>
                                                    <td style="text-align: center;">
                                                        {{ ($student->subjectwisemark[$key]->ct1 ?? 0) + ($student->subjectwisemark[$key]->ct2 ?? 0) + ($student->subjectwisemark[$key]->ct3 ?? 0) + ($student->subjectwisemark[$key]->ct4 ?? 0) }}
                                                    </td>
                                                    <td
                                                        style="text-align: center; {{ isset($student->subjectwisemark[$key]->ct) && $student->subjectwisemark[$key]->ct < 10 ? 'color: red; text-decoration: underline;' : '' }}">
                                                        {{ $student->subjectwisemark[$key]->ct ?? '' }}</td>
                                                    <td
                                                        style="text-align: center; {{ isset($student->subjectwisemark[$key]->gpa) && $student->subjectwisemark[$key]->gpa == 'F' ? 'color: red; text-decoration: underline;' : '' }}">
                                                        {{ $student->subjectwisemark[$key]->ct_conv_total ?? '' }}
                                                    </td>
                                                    <td
                                                        style="text-align: center; {{ isset($student->subjectwisemark[$key]->gpa) && $student->subjectwisemark[$key]->gpa == 'F' ? 'color: red; text-decoration: underline;' : '' }}">
                                                        {{ $student->subjectwisemark[$key]->gpa ?? '' }}
                                                    </td>

                                                </tr>
                                            @endif
                                        @endfor
                                    @endforeach
                                    <!-- <tr>
                                        <td style="text-align: center;">
                                            ENG-1
                                        </td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">
                                            ICT
                                        </td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                    </tr>

                                    <tr>
                                        <td style="text-align: center;">
                                            BOM-1
                                        </td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">
                                            FBI-1
                                        </td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;">
                                            PMM-1
                                        </td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                    </tr> -->
                                </tbody>
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


</div>
