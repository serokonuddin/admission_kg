<div class="" id="ReportBox">
                        <div class="row onlineResultPartial" style="margin:0px;">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Academic Transcript
                                    <div class="pull-right">
                                    <input type="button" class="btn  btn-success btn-panel-head" onclick="printElem('StudentAcademicTranscriptDiv')" value="Print">
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
                                        .noBorder tr, td {
                                        border: none;
                                        }
                                        .resultDetailsTable {
                                        width: 100%;
                                        }
                                        .resultDetailsTable td, .resultDetailsTable th {
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
                                        .redtext{
                                            color: red!important;
                                        }
                                        @media print {
                                                /* Hide elements with the 'noprint' class during print */
                                                .noprint {
                                                    display: none !important;
                                                   
                                                }
                                                
                                            }
                                            .tabulationdata td{
                                                font-size: 11px!important;
                                            }
                                    </style>
                                    @php 
                                        $classroman=array(
                                            '0'=>'KG',
                                            '1'=>'I',
                                            '2'=>'II',
                                            '3'=>'III',
                                            '4'=>'IV',
                                            '5'=>'V',
                                            '6'=>'VI',
                                            '7'=>'VII',
                                            '8'=>'VIII',
                                            '9'=>'IX',
                                            '10'=>'X',
                                            '11'=>'XI',
                                            '12'=>'XII',
                                            ''=>''
                                        );
                                        function getPoint($marks){
                                            if($marks >= 80) {
                                                return 5.0;  // A+
                                            }elseif ($marks >= 70) {
                                                return 4.0;  // A
                                            }elseif($marks >= 60) {
                                                return 3.5;  // A-
                                            }elseif($marks >= 50) {
                                                return 3.0;  // B
                                            }elseif($marks >= 40) {
                                                return 2.0;  // C
                                            }elseif($marks >= 33) {
                                                return 1.0;  // D
                                            }else{
                                                return 0.0;  // F
                                            }
                                        }
                                        function getGradeWithMark($marks){
                                            if($marks >= 80) {
                                                return 'A+';  // A+
                                            }elseif ($marks >= 70) {
                                                return 'A';  // A
                                            }elseif($marks >= 60) {
                                                return 'A-';  // A-
                                            }elseif($marks >= 50) {
                                                return 'B';  // B
                                            }elseif($marks >= 40) {
                                                return 'C';  // C
                                            }elseif($marks >= 33) {
                                                return 'D';  // D
                                            }else{
                                                return 'F';  // F
                                            }
                                        }
                                        function getGrade($point,$isnegative){
                                            if($isnegative==-1){
                                                return 'F';
                                            }
                                            if($point>=5){
                                                return 'A+';
                                            }elseif($point>=4 && $point<5){
                                                return 'A';
                                            }elseif($point>=3.5 && $point<4){
                                                return 'A-';
                                            }elseif($point>=3 && $point<3.5){
                                                return 'B';
                                            }elseif($point>=2 && $point<3){
                                                return 'C';
                                            }elseif($point>=1 && $point<2){
                                                return 'D';
                                            }else{
                                                return 'F';
                                            }

                                            
                                        }
                                    @endphp
                                    <div class="mobileScreenInfo printHead" style="overflow-y:hidden; margin-bottom:20px;">
                                        <table cellpadding="0" cellspacing="0" style="width:100%; text-align:center; page-break-inside: avoid;" class="tableBorderNo">
                                            <tbody>
                                                <tr>
                                                <td colspan="5">
                                                    <table cellpadding="0" cellspacing="0" class="tableCenter tableBorderNo">
                                                        <tbody>
                                                            <tr>
                                                            <td style="width:15%; text-align:center;">
                                                                <img src="{{asset('public/frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png')}}" style="width:100px;">
                                                            </td>
                                                            <td style="width:70%; text-align:center; padding:0px 20px 0px 20px;">
                                                                <h3 style="margin-top: 0px; margin-bottom: 4px; color:#0484BD; font-size:24px; font-weight:bold; white-space: nowrap;">BAF Shaheen College Dhaka</h3>
                                                                <span style="text-align:center; margin-top: 0px; margin-bottom: 0px; font-size:14px;">
                                                                Dhaka Cantonment, Dhaka-1206
                                                                </span>
                                                               
                                                            </td>
                                                            <td style="width:15%; text-align:center;"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                                </tr>
                                                <tr>
                                                    <td>Version: {{$classteacher->version->version_name??''}}</td>
                                                    <td>Shift: {{$classteacher->shift->shift_name??''}}</td>
                                                    <td>Session: {{$classteacher->session->session_name??''}}</td>
                                                    <td>Class: {{$classteacher->classes->class_name??''}}</td>
                                                    <td>Section: {{$classteacher->section->section_name??''}}</td>
                                                    
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div style="text-align:center; padding:2px;margin-top: 10px;">
                                            <spn style="font-weight:bold;font-size:17px;border: 2px solid #333;padding: 5px ">Tabulation Sheet</spn>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="printHead" style="font-family:'Times New Roman, Times, serif';  margin-top:5px;">
                                        
                                        
                                        
                                       
                                        <div class="mobileScreen">
                                            <table class="resultDetailsTable tabulationdata" width="100%" cellspacing="0" cellpadding="0" style="min-width:570px; border-bottom:1px solid black;border-right:1px solid black;">
                                                <tbody>
                                                
                                                
                                                @php 
                                                    $studentdata=$students[0]->subjectwisemark??[];
                                                   
                                                    $i=0;
                                                @endphp
                                                  
                                                   <tr>
                                                    <td></td>
                                                    <td></td>
                                                    @foreach($studentdata as $key1=>$subject)
                                                   
                                                    @if($i<6)
                                                        
                                                        <td colspan="5" style="text-transform: uppercase;">
                                                            {{$subject->subject_name}}
                                                        </td>
                                                        
                                                        
                                                       
                                                    @endif
                                                    @php 
                                                   
                                                        $i++;
                                                    @endphp
                                                    @endforeach
                                                   </tr>
                                                   @php 
                                                      
                                                        $i=0;
                                                    @endphp
                                                   <tr>
                                                    <td>Roll</td>
                                                    <td>Name</td>
                                                    @foreach($studentdata as $key1=>$subject)
                                                    
                                                    @if($i<6)
                                                        
                                                        
                                                        <td >
                                                            
                                                            CT1
                                                           
                                                            
                                                        </td>
                                                        <td >
                                                            
                                                            CT2
                                                           
                                                            
                                                        </td>
                                                        
                                                        <td>Total</td>
                                                        <td>Covn</td>
                                                        <td>Grade</td>
                                                        
                                                        
                                                        
                                                        
                                                    @endif
                                                    @php 
                                                   
                                                        $i++;
                                                    @endphp
                                                    @endforeach
                                                   </tr>
                                                   
                                                   @foreach($students as $key=>$student)
                                                   @php 
                                                        $studentdata=$student->subjectwisemark??[];
                                                        $i=0;
                                                    @endphp
                                                   <tr>
                                                    <td>{{$student->roll}}</td>
                                                    <td style="text-transform: uppercase;">{{$student->first_name}}</td>
                                                    @foreach($studentdata as $key1=>$subject)
                                                    
                                                    @if($i<6)
                                                        @php 
                                                         
                                                         $ct=0;
                                                         $cq_total=0;
                                                         $mcq_total=0;
                                                         $practical_total=0;
                                                         $total=0;
                                                         $sub_total=0;
                                                        @endphp
                                                        
                                                       
                                                        <td >
                                                            
                                                             {{$subject->ct1}}
                                                           
                                                            
                                                        </td>
                                                        <td >
                                                            
                                                             {{$subject->ct2}}
                                                           
                                                            
                                                        </td>
                                                       
                                                        <td>
                                                        {{($subject->ct1??0)+($subject->ct2??0)}}
                                                        </td>
                                                        <td>
                                                        @if($subject->subject_id==39)
                                                         {{(($subject->ct1??0)+($subject->ct2??0))}}
                                                        @else
                                                          {{(($subject->ct1??0)+($subject->ct2??0))*2}}
                                                        @endif
                                                        </td>
                                                        <td>
                                                        {{$subject->gpa}}
                                                            
                                                        </td>
                                                        
                                                        
                                                        
                                                        
                                                        
                                                    @endif
                                                    @php 
                                                   
                                                        $i++;
                                                    @endphp
                                                    @endforeach
                                                   </tr>
                                                   @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <br>
                                        
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

                                // Get the content of the element with the added class
                                var content = contentElement.innerHTML;

                                // Open a new window for printing
                                var mywindow = window.open('', 'Print');

                                // Write HTML structure and styles to the new window
                                mywindow.document.write('<html><head><title>Print Preview</title>');
                                mywindow.document.write('<style>@page { size: 210mm 297mm; margin: 50mm 5mm 5mm 5mm; }</style>');
                               
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