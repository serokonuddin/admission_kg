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
                    $totalban = 0;
                    $totaltotal = 0;
                    $totaleng = 0;
                    $totalict = 0;
                    $totalagr = 0;
                    $totalsta = 0;
                    $groupData = collect($groupData)->groupBy(['group_id', 'version_id']);
                    $groupsubject = [
                        1 => ['BAN', 'ENG', 'ICT', 'PHY', 'CHE', 'BIO', 'HMM', 'PSY', 'AGR', 'STA', '(EDS)'],
                        2 => ['BAN', 'ENG', 'ICT', 'ECO', 'LOG', 'GEO', '(IHC)', 'SOW', '(CGG)', 'PSY', 'AGR', 'STA'],
                        3 => ['BAN', 'ENG', 'ICT', 'ACC', '(BOM)', '(PMM)', '(FBI)', 'AGR', 'STA'],
                    ];
                    $grouprowspan = [];
                    $versionrowspan = [];
                    foreach ($groupData as $key => $data) {
                        $grouprowspan[$key] = 0;
                        foreach ($data as $key1 => $value) {
                            $grouprowspan[$key] += $value ? count($value) : 0;
                            $versionrowspan[$key][$key1] = $value ? count($value) : 0;
                        }
                    }
                    $version = ['1' => 'Bangla', '2' => 'English'];
                    $group = ['1' => 'Science', 2 => 'Humanities', 3 => 'Business studies'];
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
			</table>
			
			@foreach ($groupData as $key => $value)
                        @php

                            $i = 0;
                            $total = 0;
                            $total1 = 0;
                            $total2 = 0;
                            $total3 = 0;
                            $total4 = 0;
                            $total5 = 0;
                            $total6 = 0;
                            $total7 = 0;
                            $total8 = 0;
                            $total9 = 0;
                            $total10 = 0;
                            $total11 = 0;
                            $total12 = 0;
                            foreach ($groupsubject[$key] as $key2 => $subject) {
                                $total . ($subject = 0);
                            }

                        @endphp
                        <table style="margin-top: 10px">


                            <tr>
                                <th style="width: 100px!important">Group</th>
                                <th style="width: 60px!important">Version</th>
                                <th style="width: 80px!important">Section</th>
                                <th style="width: 60px!important">Total Student</th>
                                @foreach ($groupsubject[$key] as $s)
                                    <th style="vertical-align: center">{{ $s }}</th>
                                @endforeach
                            </tr>

                            @foreach ($value as $key1 => $data)
                                @php
							$j = 0;

                              
							@endphp 
							
                                @foreach ($data as $key0 => $section)
                                    <tr>
                                        @if ($i == 0)
                                            <td rowspan="{{ $grouprowspan[$key] }}">{{ $group[$key] }}</td>
                                        @endif
                                        @if ($j == 0)
                                            <td rowspan="{{ $versionrowspan[$key][$key1] }}">{{ $version[$key1] }}</td>
                                        @endif
                                        <td>{{ $section->section_name }}</td>
                                        <td>
                                            @php
                                                $totaltotal += (int) $section->total_student ?? 0;
                                                $total += (int) $section->total_student ?? 0;
                                            @endphp
                                            {{ $section->total_student }}

                                        </td>
                                        @foreach ($groupsubject[$key] as $key2 => $subject)
                                            @php

                                                if ($subject == 'BAN') {
                                                    $totalban += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($subject == 'ENG') {
                                                    $totaleng += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($subject == 'ICT') {
                                                    $totalict += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($subject == 'AGR') {
                                                    $totalagr += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($subject == 'STA') {
                                                    $totalsta += $section->subject[$subject][0]->subject_number ?? 0;
                                                }

                                                if ($key2 == 0) {
                                                    $total1 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 1) {
                                                    $total2 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 2) {
                                                    $total3 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 3) {
                                                    $total4 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 4) {
                                                    $total5 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 5) {
                                                    $total6 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 6) {
                                                    $total7 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 7) {
                                                    $total8 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 8) {
                                                    $total9 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 9) {
                                                    $total10 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 10) {
                                                    $total11 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 11) {
                                                    $total12 += $section->subject[$subject][0]->subject_number ?? 0;
                                                }
                                            @endphp
                                            <td><a href="{{ url('admin/getTotalStudentBySectionSubject/' . $section->id . '/' . $subject) }}"
                                                    target="_blank">{{ $section->subject[$subject][0]->subject_number ?? 0 }}</a>
                                            </td>
                                        @endforeach
                                    </tr>
                                    @php $j++; @endphp
                                    @php $i++; @endphp
                                @endforeach
                            @endforeach
                            <tr>
                                <td colspan="3" style="text-align: right;font-weight: bold">Total</td>
                                <td>{{ $total }}</td>
                                @if ($key == 1)
                                    <td><a href="{{ url('admin/getTotalStudentBySubjectGroup/BAN/' . $key) }}"
                                            target="_blank">{{ $total1 }}</a></td>
                                    <td><a href="{{ url('admin/getTotalStudentBySubjectGroup/ENG/' . $key) }}"
                                            target="_blank">{{ $total2 }}</a></td>
                                    <td><a href="{{ url('admin/getTotalStudentBySubjectGroup/ICT/' . $key) }}"
                                            target="_blank">{{ $total3 }}</a></td>
                                    <td><a href="{{ url('admin/getTotalStudentBySubjectGroup/PHY/' . $key) }}"
                                            target="_blank">{{ $total4 }}</a></td>
                                    <td><a href="{{ url('admin/getTotalStudentBySubjectGroup/CHE/' . $key) }}"
                                            target="_blank">{{ $total5 }}</a></td>
                                    <td><a href="{{ url('admin/getTotalStudentBySubjectGroup/BIO/' . $key) }}"
                                            target="_blank">{{ $total6 }}</a></td>
                                    <td><a href="{{ url('admin/getTotalStudentBySubjectGroup/HMM/' . $key) }}"
                                            target="_blank">{{ $total7 }}</a></td>
                                    <td><a href="{{ url('admin/getTotalStudentBySubjectGroup/PSY/' . $key) }}"
                                            target="_blank">{{ $total8 }}</a></td>
                                    <td><a href="{{ url('admin/getTotalStudentBySubjectGroup/AGR/' . $key) }}"
                                            target="_blank">{{ $total9 }}</a></td>
                                    <td><a href="{{ url('admin/getTotalStudentBySubjectGroup/STA/' . $key) }}"
                                            target="_blank">{{ $total10 }}</a></td>
                                    <td><a href="{{ url('admin/getTotalStudentBySubjectGroup/(EDS)/' . $key) }}"
                                            target="_blank">{{ $total11 }}</a></td>
                                @elseif($key == 2)
                                    <td><a href="{{ url('admin/getTotalStudentBySubjectGroup/BAN/' . $key) }}"
                                            target="_blank">{{ $total1 }}</a></td>
                                    <td><a href="{{ url('admin/getTotalStudentBySubjectGroup/ENG/' . $key) }}"
                                            target="_blank">{{ $total2 }}</a></td>
                                    <td><a href="{{ url('admin/getTotalStudentBySubjectGroup/ICT/' . $key) }}"
                                            target="_blank">{{ $total3 }}</a></td>
                                    <td><a href="{{ url('admin/getTotalStudentBySubjectGroup/ECO/' . $key) }}"
                                            target="_blank">{{ $total4 }}</a></td>
                                    <td><a href="{{ url('admin/getTotalStudentBySubjectGroup/LOG/' . $key) }}"
                                            target="_blank">{{ $total5 }}</a></td>
                                    <td><a href="{{ url('admin/getTotalStudentBySubjectGroup/GEO/' . $key) }}"
                                            target="_blank">{{ $total6 }}</a></td>
                                    <td><a href="{{ url('admin/getTotalStudentBySubjectGroup/(IHC)/' . $key) }}"
                                            target="_blank">{{ $total7 }}</a></td>
                                    <td><a href="{{ url('admin/getTotalStudentBySubjectGroup/SOW/' . $key) }}"
                                            target="_blank">{{ $total8 }}</a></td>
                                    <td><a href="{{ url('admin/getTotalStudentBySubjectGroup/(CGG)/' . $key) }}"
                                            target="_blank">{{ $total9 }}</a></td>
                                    <td><a href="{{ url('admin/getTotalStudentBySubjectGroup/PSY/' . $key) }}"
                                            target="_blank">{{ $total10 }}</a></td>
                                    <td><a href="{{ url('admin/getTotalStudentBySubjectGroup/AGR/' . $key) }}"
                                            target="_blank">{{ $total11 }}</a></td>
                                    <td><a href="{{ url('admin/getTotalStudentBySubjectGroup/STA/' . $key) }}"
                                            target="_blank">{{ $total12 }}</a></td>
                                @else
                                    <td><a href="{{ url('admin/getTotalStudentBySubjectGroup/BAN/' . $key) }}"
                                            target="_blank">{{ $total1 }}</a></td>
                                    <td><a href="{{ url('admin/getTotalStudentBySubjectGroup/ENG/' . $key) }}"
                                            target="_blank">{{ $total2 }}</a></td>
                                    <td><a href="{{ url('admin/getTotalStudentBySubjectGroup/ICT/' . $key) }}"
                                            target="_blank">{{ $total3 }}</a></td>
                                    <td><a href="{{ url('admin/getTotalStudentBySubjectGroup/ACC/' . $key) }}"
                                            target="_blank">{{ $total4 }}</a></td>
                                    <td><a href="{{ url('admin/getTotalStudentBySubjectGroup/(BOM)/' . $key) }}"
                                            target="_blank">{{ $total5 }}</a></td>
                                    <td><a href="{{ url('admin/getTotalStudentBySubjectGroup/(PMM)/' . $key) }}"
                                            target="_blank">{{ $total6 }}</a></td>
                                    <td><a href="{{ url('admin/getTotalStudentBySubjectGroup/(FBI)/' . $key) }}"
                                            target="_blank">{{ $total7 }}</a></td>
                                    <td><a href="{{ url('admin/getTotalStudentBySubjectGroup/AGR/' . $key) }}"
                                            target="_blank">{{ $total8 }}</a></td>
                                    <td><a href="{{ url('admin/getTotalStudentBySubjectGroup/STA/' . $key) }}"
                                            target="_blank">{{ $total9 }}</a></td>
                                @endif
                            </tr>

                        </table>
                    @endforeach

                    @if (count($groupData) > 0)
                        <table style="margin-top: 10px">
                            <tr>
                                <td>Total Student</td>
                                <td>Total Student: {{ $totaltotal }}</td>
                                <td><a href="{{ url('admin/getTotalStudentBySubject/BAN') }}" target="_blank">BAN:
                                        {{ $totalban }}</a></td>
                                <td><a href="{{ url('admin/getTotalStudentBySubject/ENG') }}" target="_blank">ENG:
                                        {{ $totaleng }}</a></td>
                                <td><a href="{{ url('admin/getTotalStudentBySubject/ICT') }}" target="_blank">ICT:
                                        {{ $totalict }}</a></td>
                                <td><a href="{{ url('admin/getTotalStudentBySubject/AGR') }}" target="_blank">AGR:
                                        {{ $totalagr }}</a></td>
                                <td><a href="{{ url('admin/getTotalStudentBySubject/STA') }}" target="_blank">STA:
                                        {{ $totalsta }}</a></td>
                            </tr>
                        </table>
        			@endif
            
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
