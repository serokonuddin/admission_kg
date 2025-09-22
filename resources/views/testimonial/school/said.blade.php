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
            padding: 40px 20px;
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
            border-bottom: 2px dashed #000;
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
            border: 0px dashed #000;
        }
    </style>
</head>
@php
    $groupdata = [1 => 'Science', 2 => 'Humanities', 3 => 'Business Studies'];
    $examtype = [1 => 'Secondary School Certificate (SSC)', 2 => 'Higher Secondary Certificate (HSC)'];

    $classes = [
        0 => 'KG',
        1 => 'I',
        2 => 'II',
        3 => 'III',
        4 => 'IV',
        5 => 'V',
        6 => 'VI',
        7 => 'VII',
        8 => 'VIII',
        9 => 'IX',
        10 => 'X',
        11 => 'XI',
        12 => 'XII',
    ];
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
                        <div id="TestimonialDiv" style="position: relative;">
                            <div class="watermark-logo"
                                style="background-image: url('{{ asset('public/frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png') }}');
                   background-size: cover; background-position: center; background-repeat: no-repeat; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 350px; height: 350px; opacity: 0.08; z-index: 999999;">
                            </div>
                            <div>
                                <table cellpadding="0" cellspacing="0" class="tableCenter tableBorderNo">
                                    <tbody>
                                        <tr>
                                            <td style="width:20%; text-align:right;">
                                                <img src="{{ asset('public/frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png') }}"
                                                    style="width:100px; margin-top: -90px;">
                                            </td>
                                            <td style="width:70%;text-align:center; padding-right: 130px">
                                                <h3
                                                    style="margin-top: 0px; margin-bottom: 4px; color:#0484BD; font-size:34px; font-weight:bold; white-space: nowrap; letter-spacing: 1px;">
                                                    BAF Shaheen College Dhaka
                                                </h3>
                                                <p
                                                    style="text-align:center; margin-top: 0px; margin-bottom: 0px; font-size:16px;">
                                                    Dhaka Cantonment, Dhaka-1206
                                                </p>
                                                <p
                                                    style="text-align:center; margin-top: 0px; margin-bottom: 0px; font-size:16px;">
                                                    Web: www.bafsd.edu.bd
                                                </p>
                                                <p
                                                    style="text-align:center; margin-top: 0px; margin-bottom: 0px; font-size:16px;">
                                                    Email: info@bafsd.edu.bd
                                                </p>
                                                <p
                                                    style="text-align:center; margin-top: 0px; margin-bottom: 0px; font-size:16px;">
                                                    Tel: 0088-02-9858440, 0088-08-8754830 Ext: 5561
                                                </p>
                                                <p
                                                    style="text-align:center; margin-top: 0px; margin-bottom: 0px; font-size:16px;">
                                                    Cell: 008801769975770
                                                </p>
                                                <p
                                                    style="text-align:center; margin-top: 0px; margin-bottom: 0px; font-size:16px;">
                                                    EIIN: 107858
                                                </p>
                                                <p
                                                    style="margin-top: 20px; margin-bottom: 4px; font-size:24px; text-decoration: underline; letter-spacing: 1.7px">
                                                    TO WHOM IT MAY CONCERN
                                                </p>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
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
                                    <div style="float:left; width:30%; "><span style="font-weight: bold;"></span>
                                    </div>
                                    <div style="float:left; width:30%; text-align:center; "></div>
                                    <div style="float:right; width:40%; text-align:right; ">Date: <span
                                            style="font-weight: bold;">{{ now()->format('M d, Y') }}</span></div>
                                    <div style="clear:both;"></div>
                                </div>
                            </div>
                            <div style="margin-bottom:20px;" class="reportDiv">
                                <div>
                                    <div style="float:left; width:30%;">This is to certify that,</div>
                                    <div class="fbold ffont"
                                        style="float:left; width:70%; border-bottom:1px dashed #000000; text-align:center;">
                                        {{ strtoupper($student->first_name) }}</div>
                                    <div style="clear:both;"></div>
                                </div>

                                <div>
                                    <div style="float:left; width:25%; text-align:left; word-spacing: 5px ">
                                        {{ $student->gender == 1 ? 'son' : 'daughter' }} of (Father)</div>
                                    <div class="fbold ffont"
                                        style="float:left; width:75%; border-bottom:1px dashed #000000; text-align:center; ">
                                        {{ strtoupper($student->father_name) }} </div>
                                    <div style="clear:both;"></div>
                                </div>

                                <div>
                                    <div style="float:left; width:20%; text-align:left; word-spacing: 5px ">and (Mother)
                                    </div>
                                    <div class="fbold ffont"
                                        style="float:left; width:80%; border-bottom:1px dashed #000000; text-align:center; ">
                                        {{ strtoupper($student->mother_name) }}</div>
                                    <div style="clear:both;"></div>
                                </div>

                                <div>
                                    <div style="float:left; width:23%; word-spacing: 5px"> bearing Roll No. </div>
                                    <div class="fbold"
                                        style="float:left; width:18%; border-bottom:1px dashed #000000; text-align:center; ">
                                        {{ $studentActivity->roll ?? '_' }}
                                    </div>
                                    <div style="float:left; width:20%; text-align: center">Regitration No.</div>
                                    <div class="fbold"
                                        style="float:left; width:29%; border-bottom:1px dashed #000000; text-align:center; ">
                                        {!! $registration_number !== '' ? $registration_number : '&nbsp;' !!}
                                    </div>
                                    <div style="float:right; width:10%; text-align: right">Session:</div>
                                    <div style="clear:both;"></div>
                                </div>

                                <div>
                                    <div class="fbold"
                                        style="float:left; width:12%; border-bottom:1px dashed #000000; text-align:center; ">
                                        {{-- {{ $session ?? '&nbsp;' }} --}}
                                        {!! $studentActivity->session_id ?? '&nbsp;' !!}
                                    </div>
                                </div>
                                <div style="float:left; width:10%; text-align:center;"> Group </div>
                                <div class="fbold"
                                    style="float:left; width:25%; border-bottom:1px dashed #000000; text-align:center; ">
                                    {!! $studentActivity->group_id ? $groupdata[$studentActivity->group_id] : '&nbsp;' !!}
                                </div>
                                <div style="float:left; width:53%; text-align:right; word-spacing: 5px "> is a candidate
                                    of SSC Examination
                                    {{ $exam_year ?? '' }}.
                                </div>
                                <div style="clear:both;"></div>
                                <div>
                                    <div style="float:left; width:27%; text-align:left; word-spacing: 5px ">
                                        {{ $student->gender == 1 ? 'He' : 'She' ?? '' }} may obtain GPA</div>
                                    <div class="fbold"
                                        style="float:left; width:10%; border-bottom:1px dashed #000000; text-align:center; ">
                                        {!! $gpa !== '' ? $gpa : '&nbsp;' !!}
                                    </div>
                                    <div style="float:left; width:36%; text-align:left">&nbsp; if
                                        {{ $student->gender == 1 ? 'he' : 'she' ?? '' }} appears in the said
                                        exam.
                                    </div>
                                    <div style="clear:both;"></div>
                                </div>
                            </div>

                            <div style="margin-bottom: 35px;"></div>
                            <div style="margin-bottom:10px;" class="reportDiv">
                                {{ $student->gender == 1 ? 'He' : 'She' ?? '' }} bears a good moral character. I wish
                                {{ $student->gender == 1 ? 'his' : 'her' ?? '' }} success in life.
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
                        </div>
                        {{-- <div class="page-break"></div> --}}
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

            mywindow.document.write('<html><head><title> Testimonial Said Exam School </title>');
            //mywindow.document.write('<style> .viewHead {display: none;} @page { size: portrait; size: A4; margin: 60mm 5mm 5mm 5mm; }</style>');
            mywindow.document.write(
                '<style> .viewHead {display: none;} .printHead{}  @page { size: 210mm 297mm; margin: 20mm 10mm 20mm 10mm; } </style>'
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
