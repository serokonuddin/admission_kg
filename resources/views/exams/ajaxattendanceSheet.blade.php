<div class="row admit-card-reportBox-mobile-app" id="ReportBox">
    <div class="panel panel-default">
        <div class="panel-heading">
            Attendence Sheet (Total Student: <span style="font-weight: bold;">{{ count($students) }}</span>)
            <div class="pull-right mt-2">
                <input type="button" class="btn btn-success" style="margin-top: -7px;"
                    onclick="printElem('AdmitCardPrintDiv')" value="Print" />
            </div>
        </div>

        <div class="panel-body" style="overflow: auto;">
            <div id="AdmitCardPrintDiv">
                <style>
                    #AdmitCard {
                        font-family: "Times New Roman", Times, serif;
                        color: black;
                    }



                    .tableBorder td {
                        border-right: 1px solid #000 !important;
                        border-bottom: 1px solid #000 !important;
                        padding-left: 5px;
                        padding-right: 5px;
                        padding-top: 3px;
                        padding-bottom: 3px;
                        color: black;
                    }

                    .tableBorder tr:first-child td {
                        border-top: 0;
                    }

                    .tableBorder tr:last-child td {
                        border-bottom: 0;
                    }

                    .tableBorder tr td:first-child {
                        border-left: 0;
                    }

                    .tableBorder tr td:last-child {
                        border-right: 0;
                    }

                    .tableBorderOuter {
                        border: 1px solid #000 !important;
                    }

                    .tableCenter {
                        margin-left: auto;
                        margin-right: auto;
                    }

                    @media print {
                        .rowHeight {
                            height: 35px;
                        }
                    }
                </style>
                <div class="AdmitCard">
                    @php
                        $groups = [
                            1 => 'Science',
                            2 => 'Humanities',
                            3 => 'Business studies',
                            '' => '',
                        ];

                    @endphp
                    @foreach ($students as $key => $student)
                        @php
                            $subjects = collect($student->subjects)->sortBy('is_fourth_subject');
                            $subjects = collect($student->subjects)->groupBy(['is_fourth_subject', 'short_subject']);

                        @endphp
                        <table cellpadding="0" cellspacing="0"
                            style="width: 100%; text-align: center; page-break-inside: avoid;border:none!important"
                            class="tableBorderNo">
                            <tbody>
                                <tr style="border:none!important">
                                    <td style="border:none!important">
                                        <table cellpadding="0" cellspacing="0" class="tableCenter tableBorderNo"
                                            style="border:none!important">
                                            <tbody>
                                                <tr style="border:none!important">
                                                    <td style="width: 15%; text-align: center;border:none!important">
                                                        <img src="{{ asset('public/logo/logo.png') }}"
                                                            style="width: 100px;" />
                                                    </td>
                                                    <td
                                                        style="width: 70%; text-align: center; padding: 0px 20px 0px 20px;border:none!important">
                                                        <h3
                                                            style="margin-bottom: 0; margin-top: 0px; margin-bottom: 4px; color: #000000; font-size: 24px; font-weight: bold; white-space: nowrap;">
                                                            BAF Shaheen College Dhaka</h3>
                                                        <span
                                                            style="text-align: center; margin-top: 0px; margin-bottom: 0px; font-size: 14px;">Dhaka
                                                            Cantonment, Dhaka-1206</span>
                                                        <h3 class="text-center"
                                                            style="color: red; margin-top: 5px; margin-bottom: 0px; font-size: 20px; font-weight: bold; white-space: nowrap;">
                                                            Attendence Sheet</h3>
                                                    </td>
                                                    <td rowspan="2"
                                                        style="width: 15%; text-align: center;border:none!important">
                                                        <img style="width: 110px; height: 125px; float: right; border: 1px solid #000;"
                                                            src="{{ $student->photo }}" />
                                                    </td>
                                                </tr>
                                                <tr style="border:none!important">
                                                    <td style="border:none!important"></td>
                                                    <td style="border:none!important">
                                                        <table class="tableBorderOuter" cellpadding="0" cellspacing="0"
                                                            style="margin-left: auto; margin-right: auto; margin-top: 15px; font-size: 14px;">
                                                            <tbody>
                                                                <tr>
                                                                    <td
                                                                        style="text-align: center; padding-left: 10px; padding-right: 10px; padding-bottom: 5px; padding-top: 5px;">
                                                                        Name of Examination :
                                                                        <span
                                                                            style="font-size: 16px; font-weight: bold; color: #000000;">
                                                                            {{ $exam->exam_title }} -
                                                                            {{ $exam->session->session_name }}
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr style="line-height: 10px;border:none!important">
                                    <td style="border:none!important">&nbsp;</td>
                                </tr>

                                <tr>
                                    <td>
                                        <table class="tableBorder tableBorderOuter" cellpadding="0" cellspacing="0"
                                            style="width: 100%; margin-top: 5px;">
                                            <tbody>
                                                <tr style="border: 1px solid #000!important;">
                                                    <td style="width: 7%; text-align: left;">Class :</td>
                                                    <td
                                                        style="width: 7%; text-align: left; font-weight: bold; color: #000000;">
                                                        {{ $student->studentActivity->classes->class_name }}</td>
                                                    <td style="width: 15%; text-align: right;">Section :</td>
                                                    <td
                                                        style="width: 15%; text-align: center; font-weight: bold; color: #000000;">
                                                        {{ $student->studentActivity->section->section_name }}</td>
                                                    <td style="width: 7%; text-align: left;">Class Roll :</td>
                                                    <td
                                                        style="width: 10%; text-align: center; font-weight: bold; color: darkred; letter-spacing: 3px; font-size: 16px;">
                                                        {{ $student->studentActivity->roll }}</td>
                                                </tr>
                                                <tr style="border: 1px solid #000!important; " class="rowHeight">
                                                    <td colspan="2" style="text-align: left;">Student Name :</td>
                                                    <td colspan="2" style="text-align: left; color: #000000;">
                                                        {{ $student->first_name }}</td>
                                                    <td style="text-align: left;">Version :</td>
                                                    <td style="text-align: left; color: #000000;">
                                                        {{ $student->studentActivity->version_id == 1 ? 'Bangla' : 'English' }}
                                                    </td>
                                                </tr>
                                                <tr style="">
                                                    <td colspan="2" style="text-align: left;" class="rowHeight">
                                                        Father's Name :</td>
                                                    <td colspan="2" style="text-align: left; color: #000000;">
                                                        {{ $student->father_name }}</td>
                                                    <td style="text-align: left;">Group :</td>
                                                    <td style="text-align: left; color: #000000;">
                                                        {{ $groups[$student->studentActivity->group_id ?? ''] ?? '' }}</td>
                                                </tr>
                                                <tr style="">
                                                    <td colspan="2" style="text-align: left;" class="rowHeight">
                                                        Mother's Name :</td>
                                                    <td colspan="2" style="text-align: left; color: #000000;">
                                                        {{ $student->mother_name }}</td>
                                                    <td style="text-align: left;">Type :</td>
                                                    <td style="text-align: left; color: #000000;">Regular</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                                <tr style="border:none!important">
                                    <td style="border:none!important">&nbsp;</td>
                                </tr>

                                <tr>
                                    <td>
                                        <table class="tableBorder tableBorderOuter" cellpadding="0" cellspacing="0"
                                            style="width: 100%; margin-top: 5px; text-align: center;">
                                            <tbody>
                                                <tr style="">
                                                    <td style="border: 1px solid #000!important;">Subject Code</td>
                                                    <td style="border: 1px solid #000!important;">Subject</td>
                                                    <td style="border: 1px solid #000!important;">Exam Date</td>
                                                    <td style="border: 1px solid #000!important;">Student's Signature
                                                    </td>
                                                    <td style="border: 1px solid #000!important;">Invigilator's
                                                        Signature</td>
                                                </tr>
                                                @foreach ($subjects as $key => $subject)
                                                    @foreach ($subject as $key1 => $sub)
                                                        <tr style="font-weight: bold;">

                                                            <td
                                                                style="padding-top: 15px;padding-bottom: 15px; border-bottom: 0; font-weight: bold; color: #000000;border: 1px solid #000!important;">
                                                                {{ $sub[0]->subject_code }}</td>
                                                            <td
                                                                style="padding-top: 15px;padding-bottom: 15px;border: 1px solid #000!important;">
                                                                {{ $key1 }}</td>
                                                            <td
                                                                style="padding-top: 15px;padding-bottom: 15px;border: 1px solid #000!important;">
                                                            </td>
                                                            <td
                                                                style="padding-top: 15px;padding-bottom: 15px;border: 1px solid #000!important;">
                                                            </td>
                                                            <td
                                                                style="padding-top: 15px;padding-bottom: 15px;border: 1px solid #000!important;">
                                                            </td>


                                                        </tr>
                                                    @endforeach
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                                <tr style="border:none!important">
                                    <td style="border:none!important">&nbsp;</td>
                                </tr>
                                <tr style="border:none!important">
                                    <td style="border:none!important">&nbsp;</td>
                                </tr>
                                <tr style="border:none!important">
                                    <td style="border:none!important">
                                        <table class="tableBorderNo" style="width: 100%;">
                                            <tbody>
                                                <tr style="border:none!important">
                                                    <td
                                                        style="border:none!important;text-align: center; width: 30%; padding-left: 10px; padding-right: 10px;">

                                                        <span
                                                            style="display: inline-block; margin-top: 10px; border-top: 1px solid black; width: 80%;"></span>
                                                        <br />
                                                        Class Teacher
                                                    </td>
                                                    <td
                                                        style="border:none!important;text-align: center; width: 40%; padding-left: 10px; padding-right: 10px;">
                                                    </td>

                                                    <td
                                                        style="border:none!important;text-align: center; width: 30%; padding-left: 10px; padding-right: 10px;">
                                                        <img src="{{ asset('public/assets/psi.jpg') }}"
                                                            style="width: 100px;" />
                                                        <br />
                                                        <span
                                                            style="display: inline-block; margin-top: 10px; border-top: 1px solid black; width: 80%;"></span>
                                                        <br />
                                                        Principal
                                                    </td>

                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr style="border:none!important">
                                    <td style="text-align: left; font-size: 8px;border:none!important;">
                                        <u>Directions:</u><br />
                                        1. The examinee must bring the admit card in the examination hall.<br />
                                        2. The examinee must sign the attendance sheet for each subject in the
                                        examination hall otherwise(s)he will be treated as absent in the respective
                                        subject(s).
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <hr style="margin-top: 5px; margin-bottom: 5px;" />
                        {{-- <p style="page-break-before: always;"></p> --}}
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function printElem(divId) {
        // Get the content element
        var contentElement = document.getElementById(divId);

        // Add the desired class (e.g., 'print-margin')
        // contentElement.classList.add('margin-200');

        // Get the content of the element with the added class
        var content = contentElement.innerHTML;

        // Open a new window for printing
        var mywindow = window.open('', 'Print');

        // Write HTML structure and styles to the new window
        mywindow.document.write('<html><head><title>Print Preview</title>');
        mywindow.document.write('<style> @page { size: 210mm 297mm; margin: 5mm 5mm 0mm 5mm; } </style>');

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
