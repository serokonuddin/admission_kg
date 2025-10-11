<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimonial</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 40px;
            line-height: 1.6;
        }

        .container {
            max-width: 800px;
            margin: auto;
            padding: 40px 50px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .header div {
            font-size: 16px;
        }

        .content {
            text-align: justify;
            font-size: 16px;
        }

        .content .line {
            display: inline-block;
            border-bottom: 2px dotted #000;
        }

        .line1 {
            width: 150px;
        }

        .line2 {
            width: 200px;
        }

        .line3 {
            width: 180px;
        }

        .line4 {
            width: 80px;
        }

        .line5 {
            width: 120px;
        }

        .line6 {
            width: 100px;
        }

        .line7 {
            width: 60px;
        }

        .line8 {
            width: 50px;
        }

        .line9 {
            width: 40px;
        }

        .full-width {
            width: calc(100% - 150px);
            display: inline-block;
            text-align: center;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }

        .footer div {
            text-align: center;
            min-width: 150px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0px;
        }

        .table td,
        .table th {
            border: 0px dotted #000;
        }
    </style>
</head>
@php
    $groupdata = [1 => 'Science', 2 => 'Humanities', 3 => 'Business Studies'];
    $examtype = [1 => 'Secondary School Certificate (SSC)', 2 => 'Higher Secondary Certificate (HSC)'];
@endphp

<body>
    <div class="container">


        <div class="row" id="testimonials">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="pull-right">
                            <input type="button" class="btn  btn-success btn-panel-head"
                                onclick="printElem('TestimonialDiv')" value="Print">
                        </div>
                    </div>
                    <div class="panel-body">
                        <div>
                            <table cellpadding="0" cellspacing="0" class="tableCenter tableBorderNo">
                                <tbody>
                                    <tr>
                                        <td style="width:15%; text-align:center;">
                                            <img src="{{ asset('public/frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png') }}"
                                                style="width:100px;">
                                        </td>
                                        <td style="width:70%; text-align:center; padding:0px 20px 0px 20px;">
                                            <h3
                                                style="margin-top: 0px; margin-bottom: 4px; color:#0484BD; font-size:24px; font-weight:bold; white-space: nowrap;">
                                                BAF Shaheen College Dhaka
                                            </h3>
                                            <span
                                                style="text-align:center; margin-top: 0px; margin-bottom: 0px; font-size:14px;">
                                                Dhaka Cantonment, Dhaka-1206
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="TestimonialDiv">
                            <style>
                                .reportDiv {
                                    font-family: 'Times New Roman', Times, serif;
                                    font-size: 20px;
                                    line-height: 30px;
                                }

                                .reportDiv>div {
                                    margin-bottom: 5px;
                                    margin:
                                }

                                .page-break {
                                    display: block;
                                    page-break-before: always;
                                }

                                .fbold {
                                    font-weight: bold;
                                    font-size: 18px;
                                }

                                .ffont {
                                    font-size: 15px;
                                }
                            </style>
                            <div style="margin-bottom: 30px;margin-top: 60px;" class="reportDiv">
                                <div>
                                    <div style="float:left; width:30%; ">Serial: <span
                                            style="font-weight: bold;">{{ $student->student_code }}-{{ date('m') }}-{{ date('y') }}</span>
                                    </div>
                                    <div style="float:left; width:30%; text-align:center; ">&nbsp;</div>
                                    <div style="float:left; width:40%; text-align:right; ">Issue Date: <span
                                            style="font-weight: bold;">{{ now()->format('M d, Y') }}</span></div>
                                    <div style="clear:both;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom:20px;" class="reportDiv">
                                <div>
                                    <div style="float:left; width:30%;">This is to certify that</div>
                                    <div class="fbold ffont"
                                        style="float:left; width:70%; border-bottom:2px dotted #000000; text-align:center;">
                                        {{ strtoupper($student->first_name) }}</div>
                                    <div style="clear:both;"></div>
                                </div>

                                <div>
                                    <div style="float:left; width:30%; text-align:left;">
                                        {{ $student->gender == 1 ? 'son' : 'daughter' }} of (Father)</div>
                                    <div class="fbold ffont"
                                        style="float:left; width:70%; border-bottom:2px dotted #000000; text-align:center; ">
                                        {{ strtoupper($student->father_name) }} </div>
                                    <div style="clear:both;"></div>
                                </div>

                                <div>
                                    <div style="float:left; width:20%; text-align:left;">and (Mother)</div>
                                    <div class="fbold ffont"
                                        style="float:left; width:70%; border-bottom:2px dotted #000000; text-align:center; ">
                                        {{ strtoupper($student->mother_name) }}</div>
                                    <div style="float:left; width:10%; text-align: right;"> of this </div>
                                    <div style="clear:both;"></div>
                                </div>

                                <div>
                                    <div style="float:left; width:36%;"> college bearing Roll No.</div>
                                    <div class="fbold"
                                        style="float:left; width:16%; border-bottom:2px dotted #000000; text-align:center; ">
                                        {{ $student->boardResult->roll_number ?? '' }}</div>
                                    <div style="float:left; width:28%; text-align:center;"> Registration No. </div>
                                    <div class="fbold"
                                        style="float:left; width:20%; border-bottom:2px dotted #000000; text-align:center; ">
                                        {{ $student->boardResult->registration_number ?? '' }}</div>
                                    <div style="clear:both;"></div>
                                </div>

                                <div>
                                    <div style="float:left; width:12%; text-align:left;"> Session </div>
                                    <div class="fbold"
                                        style="float:left; width:15%; border-bottom:2px dotted #000000; text-align:center; ">
                                        <?php
                                        $year = $studentActivity->session_id;
                                        $nextYear = $year + 1;
                                        $academicYear = $year . '-' . substr($nextYear, -2);
                                        echo $academicYear; // Outputs: 2024-25
                                        ?></div>
                                    <div style="float:left; width:73%; text-align:right; "> duly passed the
                                        {{ isset($student->boardResult->exam_type) ? $examtype[$student->boardResult->exam_type] : '' }}
                                    </div>
                                    <div style="clear:both;"></div>
                                </div>

                                <div>
                                    <div style="float:left; width:31%;"> Examination held in </div>
                                    <div class="fbold"
                                        style="float:left; width:16%; border-bottom:2px dotted #000000; text-align:center; ">
                                        {{ $student->boardResult->passing_year ?? '' }} </div>
                                    <div style="float:left; width:53%; text-align:right; "> under the Board of
                                        Intermediate and </div>
                                    <div style="clear:both;"></div>
                                </div>
                                <div>
                                    <div style="float:left; width:46%;text-align: left;word-spacing:2px;"> Secondary
                                        Education, Dhaka in </div>

                                    <div style="float:left; width:11%; text-align:center;"> Group </div>
                                    <div class="fbold"
                                        style="float:left; width:29%; border-bottom:2px dotted #000000; text-align:center;">
                                        {{ isset($studentActivity->group_id) ? $groupdata[$studentActivity->group_id] : '' }}
                                    </div>

                                    <div style="float:left; width:14%; text-align:center;"> Version</div>
                                    <div style="clear:both;"></div>
                                </div>
                                <div>
                                    <div class="fbold"
                                        style="float:left; width:15%; border-bottom:2px dotted #000000; text-align:center; ">
                                        {{ $studentActivity->version_id == 1 ? 'Bangla' : 'English' }}</div>

                                    <div style="float:left; width:30%; text-align:center; "> and obtained GPA</div>
                                    <div class="fbold"
                                        style="float:left; width:13%; border-bottom:2px dotted #000000; text-align:center;">
                                        {{ $student->boardResult->gpa ?? '' }} </div>
                                    <div style="float:left; width:20%; text-align: center;"> out of 5.00. </div>
                                    <div style="clear:both;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom:20px;" class="reportDiv">
                                <div style="text-align: justify;text-wrap: auto;">
                                    She bears a good moral character and to the best of my knowledge, she did not take
                                    part in any activity subversive of the state or of discipline.
                                </div>
                            </div>
                            <div style="margin-bottom:80px;" class="reportDiv">
                                I wish her every success in life.
                            </div>
                            <div style="margin-top: 140px;" class="reportDiv">
                                <div style="float:left; width:5%;">&nbsp;</div>
                                <div style="float:left; width:25%; border-top:1px solid #000000;  text-align:center; ">
                                    Verified by</div>
                                <div style="float:left; width:40%;">&nbsp;</div>
                                <div style="float:left; width:25%;border-top:1px solid #000000; text-align:center; ">
                                    Principal</div>
                                <div style="float:left; width:5%;">&nbsp;</div>
                                <div style="clear:both;"></div>
                            </div>
                            {{-- <div class="page-break"></div> --}}
                        </div>
                    </div>
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

            mywindow.document.write('<html><head><title> Testimonial </title>');
            //mywindow.document.write('<style> .viewHead {display: none;} @page { size: portrait; size: A4; margin: 60mm 5mm 5mm 5mm; }</style>');
            mywindow.document.write(
                '<style> .viewHead {display: none;} .printHead{}  @page { size: 210mm 297mm; margin: 70mm 25.4mm 25.4mm 25.4mm; } </style>'
            );
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
</body>

</html>
