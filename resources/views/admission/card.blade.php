<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Cards</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            
        }
        .page {
            width: 210mm;
            height: 297mm;
            padding: 5mm;
           
        }
        .card {
            width: calc(110mm - 10px);
            height: calc(70mm - 10px);
            background: white;
            padding: 5mm;
            box-sizing: border-box;
            border: 1px solid #ccc;
            
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            text-align: left;
            margin-bottom: 10px;
        }
        .card-header {
           
            justify-content: space-between;
            width: 100%;
        }
        .card img {
            max-width: 60px;
           
        }
        .card-content {
            width: 100%;
        }
        .card-content h2 {
            font-size: 16px;
            margin-bottom: 5px;
        }
        .card-content p {
            font-size: 12px;
            margin: 2px 0;
        }
        .card-footer {
            width: 100%;
           
            justify-content: space-between;
        }
        .card-footer .signature {
            font-size: 12px;
        }

        .div-49 {
            float: left;
            width: 50%;
            box-sizing: border-box;
        }
        .div-50 {
            float: left;
            width: 50%;
            box-sizing: border-box;
        }
        .clearfix {
            clear: both;
        }
    </style>
</head>
<body>
@if(count($studentdata)>0)
    @foreach($studentdata as $student)
      @php
        $student=collect($student)->toArray();
      
      @endphp
        @if($loop->index % 7 == 0 && !$loop->first)
            <div style="page-break-after: always;"></div>
        @endif
        @if($loop->index % 7 == 0)
            <div class="page" >
        @endif

        <div  
        @if($loop->index % 2 == 0)
        class="div-49"
        @else 
        class="div-50"
        @endif
        
        >
			@php 
			$url = $student['photo'];
			$base_url = 'https://bafsd.edu.bd/';

			// Remove the base URL from the full URL
			$relative_path = str_replace($base_url, '', $url);
			
			@endphp
            <table style="width: 370px;height: 330px;border: 1px solid #000;">
                <tr>
                    <td rowspan="2" style="width: 20%"> <img style="width: 60px" src="{{asset('public/frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png')}}" alt="Student Photo"></td>
                    <td colspan="4" style="width: 80%" style="color: Green;font-weight: bold;font-size: 18px;">BAF Shaheen College Dhaka</td>
                </tr>
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
                <td colspan="2" style="width: 40%;height: 50px;text-align: center;">Principal</td>
                
                </tr>
            </table>
            
        </div>
        
        @if($loop->index % 2 == 0 && $loop->index!=0)
        <div class="clearfix"></div>
        @endif
        @if($loop->index % 7 == 6 || $loop->last)
            </div>
        @endif
    @endforeach
@endif
</body>
</html>
