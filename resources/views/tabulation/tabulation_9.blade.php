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
                                        <th style="text-align: center;">CT</th>
                                        <th style="text-align: center;">PT</th>
                                        <th style="text-align: center;">Total</th>
                                        <th style="text-align: center;">CQ</th>
                                        <th style="text-align: center;">MCQ</th>
                                        <th style="text-align: center;">Practical</th>
                                        <th style="text-align: center;">Total</th>
                                        <th style="text-align: center;">Conv to 80%</th>
                                        <th style="text-align: center;">Subject Marks</th>
                                        <th style="text-align: center;">Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $k => $student)
                                        @php
                                            $version = $student->version_id ?? null;
                                            $class = $student->class_code ?? null;
                                        @endphp
                                        @for ($key = 0; $key < 12; $key++)
                                            @php
                                                $subjectId = $student->subjectwisemark[$key]->subject_id ?? null;
                                                $ct1 = $student->subjectwisemark[$key]->ct1 ?? null;
                                                $ct2 = $student->subjectwisemark[$key]->ct2 ?? null;
                                                $ct = $student->subjectwisemark[$key]->ct ?? null;
                                                $cq_total = $student->subjectwisemark[$key]->cq_total ?? null;
                                                $mcq_total = $student->subjectwisemark[$key]->mcq_total ?? null;
                                                $practical_total =
                                                    $student->subjectwisemark[$key]->practical_total ?? null;
                                                $total = $student->subjectwisemark[$key]->total ?? null;
                                                $conv_total = $student->subjectwisemark[$key]->conv_total ?? null;
                                                $ct_conv_total = $student->subjectwisemark[$key]->ct_conv_total ?? null;
                                                $grade = $student->subjectwisemark[$key]->gpa ?? null;
                                                $iscq = $term_marks
                                                    ->flatten(3)
                                                    ->where('subject_id', $subjectId)
                                                    ->where('marks_for', 1)
                                                    ->first()?->pass_mark;
                                                $ismcq = $term_marks
                                                    ->flatten(3)
                                                    ->where('subject_id', $subjectId)
                                                    ->where('marks_for', 2)
                                                    ->first()?->pass_mark;
                                                $ispractical = $term_marks
                                                    ->flatten(3)
                                                    ->where('subject_id', $subjectId)
                                                    ->where('marks_for', 3)
                                                    ->first()?->pass_mark;
                                                $totalpassmark = 33;
                                                if ($subjectId == 9) {
                                                    $totalpassmark = 17;
                                                }
                                            @endphp
                                            @if ($key < 4)
                                                <tr>
                                                    @if ($key == 0)
                                                        <td rowspan="12" style="text-align: center;">
                                                            {{ $k + 1 }}</td>
                                                        <td rowspan="12"
                                                            style="text-align: center;white-space: normal;width: 200px;">
                                                            {{ $student->roll }}</br>
                                                            {{ $student->first_name }}
                                                        </td>
                                                        <td rowspan="4"
                                                            style="text-align: center;white-space: normal;width: 90px;">
                                                            {{ isset($student->totalmark->position_in_section) && $student->totalmark->position_in_section != 0 ? $student->totalmark->grade_point : 0 }}
                                                        </td>
                                                    @endif

                                                    <td style="text-align: left;">
                                                        {{ $student->subjectwisemark[$key]->subject_name ?? '' }}
                                                    </td>
                                                    <!-- CT1 Total Column -->
                                                    <td style="text-align: center;">
                                                        {{ $ct1 ?? '' }}
                                                    </td>
                                                    <td style="text-align: center;">
                                                        {{ $ct2 ?? '' }}
                                                    </td>
                                                    <td style="text-align: center;">
                                                        {{ $ct ?? '' }}
                                                    </td>


                                                    <!-- CT2 Total Column -->
                                                    <td
                                                        style="text-align: center; {{ $iscq > $cq_total ? 'color: red; text-decoration: underline;' : '' }}">
                                                        {{ $iscq ? $cq_total ?? '' : '-' }}
                                                    </td>
                                                    <td
                                                        style="text-align: center; {{ $ismcq > $mcq_total ? 'color: red; text-decoration: underline;' : '' }}">
                                                        {{ $ismcq ? $mcq_total ?? '' : '-' }}
                                                    </td>
                                                    <td
                                                        style="text-align: center; {{ $ispractical > $practical_total ? 'color: red; text-decoration: underline;' : '' }}">
                                                        {{ $ispractical ? $practical_total ?? '' : '-' }}
                                                    </td>
                                                    <td
                                                        style="text-align: center; {{ $total > $totalpassmark ? '' : 'color: red; text-decoration: underline;' }}">
                                                        {{ $total ?? '' }}
                                                    </td>
                                                    <!-- Converted Total Column -->
                                                    <td style="text-align: center;">
                                                        {{ $conv_total ?? '' }}
                                                    </td>

                                                    <!-- Total Marks Column -->
                                                    <td
                                                        style="text-align: center; {{ $ct_conv_total > $totalpassmark ? '' : 'color: red; text-decoration: underline;' }}">
                                                        {{ $ct_conv_total ?? '' }}
                                                    </td>
                                                    <!-- Grade Column -->
                                                    <td
                                                        style="text-align: center; {{ isset($student->subjectwisemark[$key]->gpa) && $student->subjectwisemark[$key]->gpa == 'F' ? 'color: red; text-decoration: underline;' : '' }}">
                                                        {{ $grade ?? '' }}
                                                    </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    @if ($key == 4)
                                                        <td rowspan="8"
                                                            style="text-align: center;white-space: normal;width: 90px;">
                                                            Position
                                                            in
                                                            Section:
                                                            {{ $student->totalmark->position_in_section ?? '' }}
                                                        </td>
                                                    @endif

                                                    <td style="text-align: left;">
                                                        {{ $student->subjectwisemark[$key]->subject_name ?? '' }}
                                                    </td>
                                                    <!-- CT1 Total Column -->
                                                    <td style="text-align: center;">
                                                        {{ $ct1 ?? '' }}
                                                    </td>

                                                    <td style="text-align: center;">
                                                        {{ $ct2 ?? '' }}
                                                    </td>
                                                    <td style="text-align: center;">
                                                        {{ $ct ?? '' }}
                                                    </td>


                                                    <!-- CT2 Total Column -->
                                                    <td
                                                        style="text-align: center; {{ $iscq > $cq_total ? 'color: red; text-decoration: underline;' : '' }}">
                                                        {{ $iscq ? $cq_total ?? '' : '-' }}
                                                    </td>
                                                    <td
                                                        style="text-align: center; {{ $ismcq > $mcq_total ? 'color: red; text-decoration: underline;' : '' }}">
                                                        {{ $ismcq ? $mcq_total ?? '' : '-' }}
                                                    </td>
                                                    <td
                                                        style="text-align: center; {{ $ispractical > $practical_total ? 'color: red; text-decoration: underline;' : '' }}">
                                                        {{ $ispractical ? $practical_total ?? '' : '-' }}
                                                    </td>
                                                    <td
                                                        style="text-align: center; {{ $total > $totalpassmark ? '' : 'color: red; text-decoration: underline;' }}">
                                                        {{ $total ?? '' }}
                                                    </td>

                                                    <!-- Converted Total Column -->
                                                    <td style="text-align: center;">
                                                        {{ $conv_total ?? '' }}
                                                    </td>

                                                    <!-- Total Marks Column -->
                                                    <td
                                                        style="text-align: center; {{ $ct_conv_total > $totalpassmark ? '' : 'color: red; text-decoration: underline;' }}">
                                                        {{ $ct_conv_total ?? '' }}
                                                    </td>
                                                    <!-- Grade Column -->
                                                    <td
                                                        style="text-align: center; {{ isset($student->subjectwisemark[$key]->gpa) && $student->subjectwisemark[$key]->gpa == 'F' ? 'color: red; text-decoration: underline;' : '' }}">
                                                        {{ $grade ?? '' }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endfor
                                    @endforeach
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
