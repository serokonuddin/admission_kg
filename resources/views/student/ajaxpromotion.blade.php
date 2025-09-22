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

			<input type="hidden" name="version_id" value="{{$version_id}}" />
			<input type="hidden" name="session_id" value="{{$session_id}}" />
			<input type="hidden" name="shift_id" value="{{$shift_id}}" />
			<input type="hidden" name="class_code" value="{{$class_code}}" />
			<input type="hidden" name="section_id" value="{{$section_id}}" />
<div class="" id="ReportBox">
    <div class="row onlineResultPartial" style="margin:0px;">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="pull-right pt-2">
                    <input type="button" class="btn btn-success btn-panel-head"
                        onclick="printElem('StudentAcademicMeritListDiv')" value="Print">
                </div>
            </div>
            <div class="panel-body">
                <div id="StudentAcademicMeritListDiv">
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
                            border: 1px solid black;
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
                            .noprint {
                                display: none !important;
                            }
                        }
                    </style>

                    <div class="mobileScreenInfo " style="overflow-y:hidden; margin-bottom:20px;">
                        <table cellpadding="0" cellspacing="0"
                            style="width:100%; text-align:center; page-break-inside: auto;" class="tableBorderNo">
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
                                                            Promotion List</h3>
														<h4 class="text-center"
                                                            style="margin-top: 5px; margin-bottom: 0px; font-size:20px; white-space: nowrap;">
															Session: <strong>{{$session_name + 1}}</strong></h4>
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
                            <span style="font-weight:bold; font-size:20px;color: #0484BD;margin-right: 10px;">Version: {{$versiondata->version_name}}</span>
                            <span style="font-weight:bold; font-size:20px;color: #0484BD;margin-right: 10px;">Shift: {{$shiftdata->shift_name}}</span>
							<span style="font-weight:bold; font-size:20px;color: #0484BD;margin-right: 10px;">Class: {{$classroman[$class_code]}}</span>
                            @if($sectiondata)
                            <span style="font-weight:bold; font-size:20px;color: #0484BD;margin-right: 10px;">Section: {{$sectiondata->section_name??''}}</span>
                            @endif
                        </div>
                        {{-- <div id="result-table">
                            <p class="border border-gray-500 p-2 dynamic-data"
                                style="display: flex; justify-content: space-around; color: black;">
                                
                                <span class="text-left">Version: <strong>{{ $version_name }}</strong></span>
                                <span class="text-left">Shift: <strong>{{ $shift_name }}</strong></span>
								<span class="text-left">Class: <strong>{{ $class_name }}</strong></span>
                                <span class="text-left">Session: <strong>{{ $session_name }}</strong></span>
                            </p>
                        </div> --}}


                        <div class="mobileScreen">
                            <table class="resultDetailsTable" width="100%" cellspacing="0" cellpadding="0"
                                style="min-width:570px; border-bottom:1px solid black; border-right:1px solid black;">
                                <tbody>
                                    <tr style="font-weight:bold;">
                                        <td style="text-align:center;">Sl</td>
										 <td style="text-align:center;">ID</td>
                                        <td style="text-align:center;">House</td>
                                        <td style="text-align:center;">Roll</td>
                                        <td style="text-align:center;">Student Name</td>
                                        <td style="text-align:center;">Previous Section</td>
                                        <td style="text-align:center;">Previous Roll</td>
										<td style="text-align:center;">Gender</td>
										<td style="text-align:center;">Religion</td>
										<td style="text-align:center;">Category</td>
										<td style="text-align:center;">Mobile</td>
                                    </tr>

                                    @foreach ($students as $i => $student)
                                        <tr>
                                            <td style="text-align:center;">{{ $loop->index+1 }}</td>
											 <td style="text-align:center;">{{ $student->student_code }}</td>
                                            <td style="text-align:center;"></td>
                                            <td style="text-align:center;">{{ $student->next_roll }}</td>
                                            <td style="text-align:left;">{{ strtoupper($student->first_name) }}</td>
                                            
                                            <td style="text-align:center;">{{ $student->section_name }}</td>
                                            <td style="text-align:center;">{{ $student->roll }}</td>
											<td style="text-align:center;">{{ ($student->gender==1)?'Male':'Female' }}</td>
											<td style="text-align:center;">
												@switch($student->religion)
													@case(1)
														Islam
														@break
													@case(2)
														Hindu
														@break
													@case(3)
														Cristian
														@break
													@case(4)
														Buddhism
														@break
													@case(5)
														Others
														@break
													@default
														Unknown
												@endswitch
											</td>

											<td style="text-align:center;">{{ $student->category_name }}</td>
											<td style="text-align:center;">{{ $student->mobile }}</td>
                                            
                                           
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mb-3  col-md-2 text-right">
                                        <label class="form-label" for="amount"> </label>
                                        <button type="submit"  class="btn btn-info form-control me-2 mt-1 noprint">Promossion Now</button>
                                        
                            </div>
                        </div>
                    </div>
                </div>
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
        var createdBy = "{{ $createdBy }}"
        // Get the content of the element with the added class
        var content = contentElement.innerHTML;
        var footerContent = `
        <footer style="position: absolute; bottom: 0; width: 100%; text-align: left; font-size: 12px; padding: 10px 0;">
            <p><strong>Created By:</strong> ${createdBy}</p>
        </footer>
    `;
        // Open a new window for printing
        var mywindow = window.open('', 'Print');

        // Write HTML structure and styles to the new window
        mywindow.document.write('<html><head><title>Print Preview</title>');
        mywindow.document.write('<style>@page { size: 210mm 297mm; margin: 5mm 5mm 10mm 5mm; }</style>');
        mywindow.document.write('<style>body { position: relative; min-height: 100%; padding-bottom: 65px; }</style>');
        mywindow.document.write('</head><body>');
        mywindow.document.write(content); // Print the content
        mywindow.document.write(footerContent)
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
