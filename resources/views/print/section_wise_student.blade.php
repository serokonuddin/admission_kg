<?php
$bang_month = array(
    '01'=>'জানুয়ারি', 
    '02'=>'ফেব্রুয়ারী', 
    '03'=>'মার্চ', 
    '04'=>'এপ্রিল', 
    '05'=>'মে',
    '06'=>'জুন', 
    '07'=>'জুলাই', 
    '08'=>'আগষ্ট', 
    '09'=>'সেপ্টেম্বর', 
    '10'=>'অক্টোবর',
    '11'=>'নভেম্বর',
    '12'=>'ডিসেম্বর');
$eng_month = array(
    '01'=>'January', 
    '02'=>'February', 
    '03'=>'March', 
    '04'=>'April', 
    '05'=>'May',
    '06'=>'June', 
    '07'=>'July', 
    '08'=>'August', 
    '09'=>'September', 
    '10'=>'October',
    '11'=>'November',
    '12'=>'December');
class numberformatClass{
    public function __construct($cc)
    {
        $this->cc=$cc;
    }
    public function numdash($n,$bracket=0,$d='--'){
       $v=$n?(Session::get('lan')=='en'?$n:$this->cc->en2bnNumber($n)):$d;
       return $bracket?"($v)":$v;
    }

}

?>



<!doctype html>
<html >
    <head>
        
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>BAF Shanheen College Dhaka</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
         <link rel="stylesheet" href="{{ asset('css/backend_css/bootstrap.min.css') }}" />
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
   <style type="text/css">
    a {text-decoration: none}

    body {
       
        /*font-size: 14px !important;*/
     }
     tr.sectorvaluefonts td span{
        
       
    }

    @page {
      header: page-header;
      footer: page-footer;
      sheet-size: A4;
      margin:2.54cm 2.54cm 1.54cm 2.54cm;
     
    }
    table {
        
        border: none;
        border-collapse: collapse; 
        width: 100%;
        font-size: 13px;
    }

    th, td {
        padding: 1px !important;
        border: 1px solid #000;
        vertical-align: top;
    }

    th {
        text-align: center;
    }
    .fake{
        border: 0px;
        width: 0px!important;
        visibility: hidden;
        padding: 0px!important;
        font-size: 0px;
    }

    .no-subsector{
        border: 0px;
        visibility: hidden;
        padding: 0px!important;
        font-size: 0px!important;
        background-color: yellow;
    }

    div.fake{ display: none!important; ;  font-size: 0px!important; }


    .noboder{
        border: 0px;
        padding: 5px;
        font-weight: bold;
        font-size: 15px;
        
    }
    .sectorhide0{
        border: 0px;
        width: 0px!important;
        visibility: hidden;
        padding: 0px!important;
    }
    
    tr td{
      
    }
    .tdcenter{
        text-align: center!important;
    }
    .tdright{
        text-align: right!important;
    }
    .bordernone{
        border: none!important;
        height: 10px!important;
    }

    </style>
         <style>
             .table th, .table td {
                text-align: center!important;
                vertical-align: top!important;
                border-top: 1px solid #000!important;
                border-left: 1px solid #000!important;
            }
           .table td:last-child, .table th:last-child { border-right: 1px solid #000!important; }
           .table tr:last-child { border-bottom: 1px solid #000!important; }
            #projecttitle{
                text-align: left!important;
                padding-left: 5px!important;
            }
            .x-footer{
                width: 100%;
                border: 0 none!important;
                border-collapse: collapse;
            }
            .x-footer td{
                border: 0 none!important;
            }
            .nowrap{
                white-space: nowrap;
            }
            .head span{
                display: inline;
            }
            h3{
                font-size: 18px;
                font-weight: bold;
            }
    </style>

    </head>
    @php 
            $gender=collect($students)->groupBy('gender');
            
          @endphp
    <body>
        <div class="flex-center position-ref full-height">
        <table  >
                <thead>
                    <tr>
                        <th class="tdcenter bordernone" colspan="2"><img src="{{asset('public/logo/logo.png')}}" style="width: auto;height: 80px;"></th>
                        <th class="tdcenter bordernone" colspan="3">
                        <h2 style="color: rgb(0,173,239)">BAF Shaheen College Dhaka</h2>
                            <span>Dhaka Cantonmnet, Dhaka-1206</span>
                            <br/><span>Web: www.bafsd.edu.bd</span><br/>
                            <span>Email: info@bafsd.edu.bd</span>
                            <h3>Section Wise Students' List</h3>
                        </th>
                        <th colspan="2" class="bordernone">

                        </th>
                        
                    </tr>
                    </thead>
                    <tr>
                        <th colspan="2">Section</th>
                        <th>{{$sectiondata->section_name??''}}</th>
                        <th>Total Students</th>
                        <th>{{$students->count()??''}}</th>
                        <th>Male: {{$gender[1]->count()??''}}</th>
                        <th>Female: {{$gender[2]->count()??''}}</th>
                    </tr>
                    <tr>
                        <th colspan="2">Class Room No.:</th>
                        <th colspan="2">{{$sectiondata->room_number??''}}</th>
                        <th>Location:</th>
                        <th colspan="2">{{$sectiondata->location??''}}</th>
                    
                    </tr>
                    <tr>
                        <th class="bordernone" colspan="7"></th>
                    </tr>
                    @foreach($employees as $employee)
                    <tr>
                        <th colspan="2">Class Teacher-1:</th>
                        <th colspan="1">{{$employee->employee->employee_name}}</th>
                        <th>Designation:</th>
                        <th colspan="1">{{$employee->employee->designation->designation_name}}</th>
                        <th>Contact Number:</th>
                        <th colspan="1">{{$employee->employee->sms_notification_number}}</th>
                    
                    </tr>
                    @endforeach
                    <!-- <tr>
                        <td colspan="2">Class Teacher-2:</td>
                        <td colspan="1"></td>
                        <td>Designation:</td>
                        <td colspan="1"></td>
                        <td>Contact Number:</td>
                        <td colspan="1"></td>
                    
                    </tr> -->
                    <tr>
                        <th class="bordernone" colspan="7"></th>
                    </tr>
                    <tr>
                        <th style="width: 5%">Sl</th>
                        <th style="width: 25%">Name of Student</th>
                        <th style="width: 20%">Contact Number</th>
                        <th style="width: 10%">Gender</th>
                        <th style="width: 10%">House</th>
                        <th style="width: 10%">Class Roll</th>
                        <th style="width: 20%">Category</th>
                    </tr>
            
                @php
                $house=array(1=>'Nazrul',2=>'Isha Kha',3=>'Titumir',4=>'Sher-E-Bangla');
                $gender=array(1=>'Male',2=>'Female');
                $categoryid=array(1=>'Civil',2=>'Son/daughter of Armed Forces` Member',3=>'Son/daughter of Teaching/Non-Teaching staff of BAFSD');
                $religion=array(1=>'Islam',2=>'Hindu',2=>'christian',2=>'Buddhism',2=>'Others');
                @endphp
                @foreach($students as $student)
                 <tr>
                    <td>{{$loop->index+1}}</td>
                    <td>{{$student->student->first_name}}</td>
                    <td>{{$student->student->sms_notification}}</td>
                    <td>{{$gender[$student->student->gender]??''}}</td>
                    <td>{{$house[$student->house_id]??''}}</td>
                    <td>{{$student->roll}}</td>
                    <td>{{$categoryid[$student->student->categoryid]??''}}</td>
                </tr>
                @endforeach
             </table>
            
        
            
            <style type="text/css">
                .cc,.cc td{
                    border: 0px solid #fff!important;
                    padding: 1px!important;
                    font-size: 16px!important;
                }
                .cc tr td:nth-child(3n+3) {
                    display: none!important;
                    width: 0px!important;
                    border: 0px solid #fff!important;
                    padding: 0px;
                }
                .cc-serial{
                    width: 10px!important;
                    padding: 2px!important;
                    text-align: right!important;
                    border: 0px solid #fff!important;
                }
            </style>
            
            
            
        </div>
        <htmlpagefooter name="page-footer">
          <table class="x-footer">
              
              <tr>
                  <td style="width: 50%;text-align: left;">{{ date('d-m-Y H:s') }}</td>
                  <td style="text-align: right;">@lang('Page') ({PAGENO}/{nb})</td>
              </tr>

          </table>

        
        </htmlpagefooter>
    </body>
</html>
