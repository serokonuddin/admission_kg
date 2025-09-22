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
<div class="" id="ReportBox">
    <div class="row onlineResultPartial" style="margin:0px;">
        <div class="panel panel-default">
            <div class="panel-heading">
                Academic Merit List
                <div class="pull-right">
                    <input type="button" class="btn btn-success btn-panel-head" onclick="printElem('StudentAcademicMeritListDiv')" value="Print">
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
                        .noBorder tr, td {
                            border: none;
                        }
                        .resultDetailsTable {
                            width: 100%;
                        }
                        .resultDetailsTable td, .resultDetailsTable th {
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

                    <!-- <div class="mobileScreenInfo " style="overflow-y:hidden; margin-bottom:20px;">
                        <table cellpadding="0" cellspacing="0" style="width:100%; text-align:center; page-break-inside: auto;" class="tableBorderNo">
                            <tbody>
                                <tr>
                                    <td>
                                        <table cellpadding="0" cellspacing="0" class="tableCenter tableBorderNo">
                                            <tbody>
                                                <tr>
                                                    <td style="width:15%; text-align:center;">
                                                        <img src="{{ asset('public/frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png') }}" style="width:100px;">
                                                    </td>
                                                    <td style="width:70%; text-align:center; padding:0px 20px 0px 20px;">
                                                        <h3 style="margin-top: 0px; margin-bottom: 4px; color:#0484BD; font-size:24px; font-weight:bold; white-space: nowrap;">BAF Shaheen College Dhaka</h3>
                                                        <span style="text-align:center; margin-top: 0px; margin-bottom: 0px; font-size:14px;">
                                                            Dhaka Cantonment, Dhaka-1206
                                                        </span>
                                                        <h3 class="text-center" style="color:red; margin-top: 5px; margin-bottom: 0px; font-size:20px; font-weight:bold; white-space: nowrap;">Merit List</h3>
                                                    </td>
                                                    <td style="width:15%; text-align:center;"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div> -->

                    <div class="printHead" style="font-family:'Times New Roman, Times, serif';  margin-top:5px;">
                        <div style="text-align:center; padding-bottom:0px;">
                            <span style="font-weight:bold; font-size:17px;">Merit List Details</span>
                        </div>

                        <div class="mobileScreen">
                            <table class="resultDetailsTable" width="100%" cellspacing="0" cellpadding="0" style="min-width:570px; border-bottom:1px solid black; border-right:1px solid black;">
                                <tbody>
                                    <tr style="font-weight:bold;">
                                        <td style="text-align:center;">Sl</td>
                                        <td style="text-align:center;">Section</td>
                                        <td style="text-align:center;">Student Roll</td>
                                        <td style="text-align:center;">Student Name</td>
                                        <td  style="text-align:center;">Total</td>
                                                    <td  style="text-align:center;">Grade</td>
                                                    <td  style="text-align:center;">Grade
                                                    Point</td>
                                        <!-- <td style="text-align:center;">Position in Section</td>
                                        <td style="text-align:center;">Position in Class</td> -->
                                    </tr>

                                    @foreach($students as $key => $student)
                                        <tr>
                                            <td style="text-align:center;">
                                                {{ $key + 1 }}
                                                <input type="hidden" name="studentcode[]" value="{{$student->student_code}}" />
                                            </td>
                                            <td style="text-align:center;">{{ $student->section_name }}</td>
                                            <td style="text-align:center;">{{ $student->roll }}</td>
                                            <td style="text-align:center;">{{ $student->first_name }}</td>
                                            <td  style="text-align:center;">
                                                @php 
                                                      
                                                $studentdata=$student->subjectwisemark??[];
                                                
                                                $total=0;
                                                $gpa_point=0;
                                                foreach($studentdata as $key1=>$subject){
                                                  $pair_name=$subject->parent_subject;
                                                  
                                                  if($pair_name!=null && isset($studentdata[$key1+1]->parent_subject) && $pair_name==$studentdata[$key1+1]->parent_subject){

                                                  }else if($pair_name!=null && isset($studentdata[$key1-1]->parent_subject) &&  $pair_name==$studentdata[$key1-1]->parent_subject){
                                                      if($subject->gpa_point==0){
                                                          $gpa_point=-1;
                                                          $isnegative=-1;
                                                      }
                                                  
                                                      if($gpa_point!=-1){
                                                      
                                                          
                                                              $gpa_point+=(float)$subject->gpa_point;
                                                          
                                                               
                                                      }
                                                          
                                                     
                                                      
                                                  }else{
                                                     
                                                      if($gpa_point!=-1){
                                                              
                                                              if($subject->gpa_point==0 || $subject->gpa_point=='' || $subject->gpa_point==null){
                                                                  if($subject->is_fourth_subject!=1){
                                                                  $gpa_point=-1;
                                                                  $isnegative=-1;
                                                                  }
                                                                  
                                                              }
                                                              if($subject->is_fourth_subject==1){
                                                                  if($subject->gpa_point>2){
                                                                      $gpa_point+=(float)($subject->gpa_point-2);
                                                                     
                                                                  }
                                                              }else{
                                                                  $gpa_point+=(float)$subject->gpa_point;
                                                                  
                                                              }
                                                              
                                                          }
                                               
                                             
                                                 
                                                  }

                                                  $total+=$subject->ct_conv_total??0;
                                                 
                                                }
                                            
                                                      if($gpa_point==-1){
                                                          $point=0;
                                                      }elseif(count($studentdata)>3){
                                                         
                                                          if($subject->class_code<4){
                                                             $point=round($gpa_point/(count($studentdata)),2);
                                                          }elseif($subject->class_code>10){
                                                            $subjectcount=count($studentdata)-1;
                                                            $point=round($gpa_point/$subjectcount,2);
                                                          }else{
                                                             $subjectcount=count($studentdata)-3;
                                                             $point=round($gpa_point/$subjectcount,2);
                                                          }
                                                         
                                                      }else{
                                                        $point=0;
                                                      }
                                                   
                                                @endphp
                                                     {{$student->total_mark??''}}
                                                     <!-- <input type="hidden" name="point{{$student->student_code}}" value="{{$student->total_mark}}" /> -->
                                                  </td>
                                                      <td style="text-align:center;">
                                                        
                                                      {{getGrade($point,1)}}
                                                      </td >
                                                      <td style="text-align:center;">
                                                      {{$point>5?'5':$point}}
                                                      <input type="hidden" name="point{{$student->student_code}}" value="{{$point>5?'5':$point}}" />
                                                      </td>
                                            
                                            
                                            
                                           
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mb-3  col-md-2 text-right">
                                        <label class="form-label" for="amount"> </label>
                                        <button type="submit"  class="btn btn-info form-control me-2 mt-1">Save</button>
                                        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
