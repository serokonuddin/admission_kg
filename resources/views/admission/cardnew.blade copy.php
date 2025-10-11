<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Cards</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .page {
            width: 100%;
            height: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 30px;
        }
        .id-card {
            width: 45%;
            border: 2px solid #000;
            border-radius: 10px;
            padding: 10px;
            margin: 5px;
            box-sizing: border-box;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
            text-align: center;
        }
        .header {
            background-color: #1E90FF;
            color: #fff;
            padding: 5px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }
        .sub-header {
            background-color: red;
            color: white;
            padding: 2px;
            text-align: center;
            font-size: 10px;
            margin-top: 5px;
        }
        .photo {
            width: 90px;
            height: 110px;
            margin: 10px auto;
        }
        .photo img {
            width: 100%;
            height: 100%;
            border-radius: 5px;
            border: 2px solid #000;
        }
        .info {
            font-size: 10px;
            text-align: left;
        }
        .info p {
            margin: 2px 0;
        }
        .info p span {
            font-weight: bold;
        }
        .qr-code {
            text-align: center;
            margin-top: 10px;
        }
        .qr-code img {
            width: 50px;
            height: 50px;
        }
        .footer {
            font-size: 10px;
            margin-top: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="page">
        @foreach($studentdata as $student)
        @php
            $student=collect($student)->toArray();
        
        @endphp
        @php 
			$url = $student['photo'];
           
			$base_url = 'https://bafsd.edu.bd/';

			// Remove the base URL from the full URL
			$relative_path = str_replace($base_url, '', $url);
			
			@endphp
        <div class="id-card">
            <div class="header">
                BAF Shaheen College Dhaka
            </div>
            <div class="sub-header">
                Student Roll # {{$student['student_code']}}
            </div>
            <table style="width: 370px;height: 330px;border: 1px solid #000;">
                
                <tr>
                    <td colspan="3" style="width: 60%" style="text-align: center;color: red;font-weight: bold;"> IDENTITY CARD</td>
                    <td rowspan="5" style="width: 20%"><img src="{{$student['photo']}}" style="height: 70px;" alt="Student Photo"></td>
                </tr>
                <tr>
                    <td colspan="4" style="width: 80%" style="font-weight: bold;">{{ $student['first_name'] }}</td>
                    
                </tr>
                <tr>
                    <td colspan="2" style="width: 40%">Class: {{ $student['class_code'] }}</td>
                    <td colspan="2" style="width: 40%">Section: {{ $student['section_name'] }}</td>
                </tr>
                <tr>
                <td colspan="2" style="width: 40%;font-size: 11px">Group: {{ $student['group_name'] }}</td>
                <td colspan="2" style="width: 40%">Session: {{ $student['session_name'] }}</td>
                </tr>
                <tr>
                <td colspan="2" style="color: red;font-weight: bold;width: 40%">Blood Group: {{ $student['blood'] }}</td>
                <td colspan="2" style="width: 40%">Version: {{ $student['version_name'] }}</td>
                </tr>
                <tr>
                <td colspan="3" style="height: 20px;font-weight: bold;width: 60%">Contact No:{{$student['local_guardian_mobile']}}</td>
                <td colspan="2" style="width: 40%"></td>
                
                </tr>
                <tr>
                <td colspan="3" style="width: 60%">Roll No:{{$student['student_code']}}</td>
               
                
                </tr>
            </table>
            <div class="footer">
                Principal
            </div>
        </div>
        @endforeach
    </div>
</body>
</html> -->

 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Cards</title>
    <style>
        

        

        .id-card {
            width: 100%;
            
            text-align:center!important;
           
            margin-bottom: 0px;
            margin: 1px;
            padding: 1px;
            background-repeat: no-repeat;
            background-image: url("{{ asset('public/logo/logob.png') }}");
            background-blend-mode:screen;
            background-size: 370px auto;
            background-position: bottom; 
           
        }

        

        .student-photo {
            border-radius: 5px; /* Border radius of 10px */
            border: 1px solid #2E3192; /* Optional border for visibility */
            height: 80px;
            
        }
        
        .header, .footer {
            text-align: center;
        }

        /* Styles for front and back of the ID */
        .college-info {
            text-align:center!important;
        }
        .college-info span {
            font-size: 11px!important;
            font-weight: bold;
            color: #000080;
            text-align: center;
        }

        .student-info h3 {
            font-size: 10px!important;
            color: #d32f2f;
        }

        .barcode-section {
            font-size: 10px!important;
            letter-spacing: 3px;
            font-family: 'Courier New', Courier, monospace;
        }

        .college-logo {
            width: 40px;
            height: auto;
        }
        .college-logo-back {
            width: 100px;
            height: auto;
        }
        td,p{
            line-height:14px;
            font-size: 10px;
        }
        .p9{
            line-height:14px!important;
            font-size: 9px!important;
        }
        td{
            text-align:left!important;
        }
        
        .text-center{
            text-align: center!important;
        }
        .info-footer{
            background: #2E3192;
            height: 20px;
        }
        .page-break {
            page-break-after: always;
        }

        /* Avoid page break within a specific section */
        .no-break {
            page-break-inside: avoid;
        }
        .a4-page{
           
           
        }
        .logo{
            width: 40px;
            height: auto;
        }
    </style>
</head>
<body style="display: flex; justify-content: center; align-items: center; height: 100%;">
   @php 
   function getroman($code){
     $romand=array('KG','I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII');
     return $romand[$code];
   }
   @endphp
@foreach($studentdata as $key=>$student)

        @php
            $student=collect($student)->toArray();
        
        @endphp
        @php 
			$url = $student['photo'];
           
			$base_url = 'https://bafsd.edu.bd/';

			// Remove the base URL from the full URL
			$relative_path = str_replace($base_url, '', $url);
			
			@endphp
    <div class="a4-page">
        <div class="id-card" >
            <div class="header" style="margin-top: 7px;">
                <table >
                    <tr>
                       <td><img src="{{ asset('public/logo/logo.png') }}" alt="BAF Shaheen College Logo" class="logo" ></td> 
                       <td >
                        <div class="college-info"  style="margin-top: 5px;text-align: center;">
                            <p style="text-align: center;font-size:12px;margin:0px;padding-top:5px;font-family: freeserif"><strong>BAF Shaheen College Dhaka</strong></p>
                            <p class="text-center p9" >&nbsp;&nbsp;&nbsp;Dhaka Cantonment, Dhaka-1206</p>
                        </div>
                       </td> 
                    </tr>
                </table>
                
            </div>
            
            <div class="photo-section" style="text-align: center;">
                <img src="{{$student['photo']}}" alt="Student Photo"  class="student-photo">
            </div>
            
                
               
                
            <div class="student-info" style="margin-top: 5px;text-align: center;">
               <div style="color: white;
                padding: 3px;
                background-color: red;
                width: 140px;
                margin-left: 27px;
                font-size: 10px;
                border-radius: 5px;
                font-weight: bold;"> Student ID # {{$student['student_code']}}</div>
            </div>
            <div class="student-info" style="margin-top: 5px;text-align: center;">
               
                <p style="text-align: center;font-size:10px;margin:0px;padding:3px"><strong>{{ $student['first_name'] }}</strong></p>
                
               
            </div>
            <table style="width: 100%;">
                    <tr>
                        <td><strong>Class:</strong> {{ getroman($student['class_code']) }} </td>
                        
                        <td><strong>Roll:</strong> {{ $student['roll'] }}</td>
                    </tr>
                    <tr>
                    <td><strong>Section:</strong> {{ $student['section_name'] }}</td>
                        <td>
                            @if($student['group_name'])
                            <strong>Group:</strong> {{ $student['group_name'] }}
                            @endif
                        </td>
                       
                    </tr>
                    <tr>
                        <td colspan="2"><strong>Blood Group: {{ $student['blood'] }}</strong></td>
                        
                       
                    </tr>
                    <tr>
                        <td colspan="2" class="p9"><strong class="p9">Guardian Name: {{$student['local_guardian_name']}}</strong></td>
                       
                       
                    </tr>
                    <tr>
                        <td colspan="2"><strong>Validity: 
                            @if($student['class_code']>10)
                            <?php
                                $year = (int)$student['session_name'];  // Replace with your input year
                                $nextYear = $year + 2;
                                //$yearRange = $year . '-' . substr($nextYear, -2);

                                //echo $yearRange;  // Output: 2024-25
                                ?>
                            30th June {{ $nextYear }}
                            @else 
                             31th Decembar {{ $student['session_name'] }}
                            @endif
                            
                        </strong></td>
                        
                    </tr>
                   
                    <!-- <tr>
                        <td colspan="2" class="text-center"><div style="text-align: center!important;background: red; padding: 5px!important;border-radius: 5px;color: white;font-weight: bold;"></div>
                    
                    </td> -->
                       
                       
                       
                    </tr>
                </table>
                <div class="student-info" style="margin-top: 2px;text-align: center;margin-top: 2px;">
                    <div style="color: white;
                    padding: 2px;
                    background-color: red;
                    width: 175px;
                    margin-left: 10px;
                    font-size: 9px;
                    border-radius: 5px;
                    font-weight: bold;">Emergency Call: {{$student['local_guardian_mobile']}} </div>
                </div>
        </div>
        <!-- <div class="id-card">
            
             <p style="line-height:16px;
            font-size: 16px;">If the card is lost and found somewhere, please return the card to the following address:</p>
            <div class="logo-section">
                <img src="{{ asset('public/logo/logo.png') }}" alt="BAF Shaheen College Logo" class="college-logo-back">
            </div>

            <div class="info-section">
                
                <h3 style="    padding: 0px;
                margin: 0px;">BAF Shaheen College Dhaka</h3>
                            <p style="line-height: 8px;
                font-size: 10px;">Dhaka Cantonment, Dhaka-1206</p>
                            <p style="line-height: 8px;
                font-size: 10px;"><strong>Cell:</strong> 01769-975771</p>
                            <p style="line-height: 8px;
                font-size: 10px;"><strong>Email:</strong> info@bafsd.edu.bd</p>
                            <p style="line-height: 8px;
                font-size: 10px;"><strong>Web:</strong> www.bafsd.edu.bd</p>
            </div>
            <div class="info-footer">
            </div>
        </div> -->
    </div>
   
    <div class="page-break"></div>
    
    @endforeach
    
    <div class="a4-page">
        
        <div class="id-card">
            
             <p style="line-height:16px;
            font-size: 13px;">If the card is lost and found somewhere, please return the card to the following address:</p>
            <div class="logo-section">
                <img src="{{ asset('public/logo/logo.png') }}" alt="BAF Shaheen College Logo" class="college-logo-back">
            </div>

            <div class="info-section">
                
                <h3 style="    padding: 0px;
                margin: 0px;">BAF Shaheen College Dhaka</h3>
                            <p style="line-height: 8px;
                font-size: 10px;">Dhaka Cantonment, Dhaka-1206</p>
                            <p style="line-height: 8px;
                font-size: 10px;"><strong>Cell:</strong> 01769-975771</p>
                            <p style="line-height: 8px;
                font-size: 10px;"><strong>Email:</strong> info@bafsd.edu.bd</p>
                            <p style="line-height: 8px;
                font-size: 10px;"><strong>Web:</strong> www.bafsd.edu.bd</p>
            </div>
            <div class="info-footer">
            </div>
        </div>
    </div>
</body>
</html> 





