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
        font-family: 'NikoshBAN';
        /*font-size: 14px !important;*/
     }
     tr.sectorvaluefonts td span{
        
        font-family: 'NikoshBAN';
    }

    @page {
      header: page-header;
      footer: page-footer;
      sheet-size: A4;
      margin:2.54cm 2.54cm 1.54cm 2.54cm;
     
    }
    table {
        font-family: "NikoshBAN";
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
    .rahenrashi{
      font-family: 'NikoshBAN';
    }
    tr td{
      font-family: 'NikoshBAN';
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
    </style>

    </head>

    <body>
        <div class="flex-center position-ref full-height">
        <table style="border:0px">
            <tr>
                <td style="width:13.33%;border:0px;text-align:left">
                    <img src="{{asset('public/frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png')}}" style="width: auto;height: 80px;" />
                </td>
                <td class="head" style="width:73.33%;border:0px;text-align:center;">
                    <h2 style="color: rgb(0,173,239)">BAF Shaheen College Dhaka</h2>
                    <span>Dhaka Cantonmnet, Dhaka-1206</span>
                    <br/><span>Web: www.bafsd.edu.bd</span><br/>
                    <span>Email: info@bafsd.edu.bd</span>
                </td>
                <td style="width:13.33%;border:0px;text-align:right">
                    
                </td>
            </tr>
       </table>
        <table style="border:0px">
            <tr>
                <td style="width:100%;border:0px;font-size: 17px;text-align:center;color: rgb(0,173,239);font-weight: bold"> Admission Report</td>
                
            </tr>
       </table>

         <p>  
            <b> বিষয়ঃ  " শীর্ষক প্রকল্পের অনুকূলে  বার্ষিক উন্নয়ন কর্মসূচিতে প্রদত্ত মোট বরাদ্দ অপরিবর্তিত রেখে রাজস্ব ও মূলধন অংশে ব্যয়খাত পরিবর্তন প্রসঙ্গে।</b></p>

       <table style="border:0px">
           
            <tr>
                <td style="width:100%;border:0px;font-size:12px">সূত্রঃ  &nbsp;&nbsp;&nbsp;(১) 
                   
                    পত্র নং-,&nbsp;তারিখঃ </td>
            </tr>
           
            <tr>
                <td style="width:100%;border:0px;font-size:12px">  &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(২) 
                    
                    পত্র নং-,&nbsp;তারিখঃ </td>
            </tr>
           
       
       </table>
       <br/>
       <table style="border:0px;">
            <tr>
                <td style="width:100%;border:0px;text-align:justify;">
                &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;উপর্যুক্ত বিষয় ও সূত্রের প্রেক্ষিতে,
             শীর্ষক প্রকল্পের অনুকূলে  অর্থ বছরের  বার্ষিক উন্নয়ন কর্মসূচিতে মোট বরাদ্দ অপরিবর্তিত রেখে রাজস্ব ও মূলধন অংশে নিমোক্ত ছক অনুযায়ী নির্দেশক্রমে ব্যয় খাত সংশোধন করা হলো:</p>

                </td>
            </tr>
       
       </table>
       <br/>
            
            <table class="table" style="border:1px solid #000;">
                <thead>
                   
                    <tr>
                        <th style="vertical-align: top;">মোট</th>
                        <th style="vertical-align: top;">রাজস্ব</th>
                        <th style="vertical-align: top;">মূলধন</th>
                        <th style="vertical-align: top;">মোট</th>
                        <th style="vertical-align: top;">রাজস্ব</th>
                        <th style="vertical-align: top;" class="border-right">মূলধন</th>
                    </tr>
                    <tr style="padding:0px">
                        <th style="padding:0px;border:1px solid #000;">১</th>
                        <th style="padding:0px">২</th>
                        <th style="padding:0px">৩</th>
                        <th style="padding:0px">৪</th>
                        <th style="padding:0px">৫</th>
                        <th style="padding:0px">৬</th>
                        <th style="padding:0px">৭</th>
                        <th style="padding:0px" class="border-right">৮</th>
                    </tr>
                    
                </thead>
                
            </table>
            <table style="border:0px">
                <tr>
                    <td rowspan="3" style="width: 0px;border: 0px;padding: 0px;"></td>
                    <td style="width:100%;border:0px;" colspan="2">
                        <p>&nbsp;২।   তবে শর্ত থাকবে যে,<br>
                           <strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(ক)  বরাদ্দকৃত অর্থ অনুমোদিত ডিপিপি’র অঙ্গওয়ারী সংস্থান অনুযায়ী সকল স্তরে এবং সকল আর্থিক বিধি বিধান অনুসরণপূর্বক ব্যয় করতে হবে; <br>
                           &nbsp; &nbsp;&nbsp;&nbsp;(খ)     অর্থছাড় ও ব্যয়ের ক্ষেত্রে সরকারি বিধি মোতাবেক অনুমোদনকারী কর্তৃপক্ষের অনুমোদন গ্রহণ করতে হবে। </strong>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="width:70%;border:0px;">
                    </td>
                    <td style="width:30%;border:0px">
                    
                    </td>
                </tr>
                <tr>
                    <td style="width:70%;border:0px;font-size: 18px!important;padding-left: 0px;" >
                    
                    </td>
                    <td style="width:30%;border:0px">
                    </td>
                </tr>
            </table>

            <p style="display: block;width: 100%">
               <b style="text-decoration:underline">সদয় অবগতি ও প্রয়োজনীয় ব্যবস্থা গ্রহণের জন্য অনুলিপি (জ্যেষ্ঠতার ক্রমানুসারে নয়):</b><br>
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
