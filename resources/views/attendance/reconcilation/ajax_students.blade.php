



@if ($students)
<table class="table table-hover rounded-lg main">
        <thead class="table-dark" style="position: sticky; top: 0; z-index: 1000;">
            <tr>
                <th style="width: 5%">SL.</th>
                
                <th style="width: 20%;word-wrap: break-word;;text-align:center;">Student Name</th>
                
                <th style="width: 20%;text-align:center;">Father Name</th>
                <th style="width: 10%;text-align:center;">Title</th>
                <th style="width: 20%;text-align:center;">Current</th>
                <th style="width: 20%;text-align:center;">Final</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @foreach ($students as $student)
                <tr>
                    <td rowspan="3" style="word-wrap: break-word;text-align:center;">
                        {{ $loop->iteration }}
                    </td>
                    
                    
                    <td rowspan="3" style="word-wrap: break-word;text-align:left;">
                    {{ $student->roll }}-{{ $student->first_name . ' ' . $student->last_name }}
                    </td>

                    <td rowspan="3" style="text-align:center;">
                        {{ $student->father_name }}<br/>{{ $student->sms_notification }}
                    </td>
                     
                    <td style="text-align:center;">
                       Absent
                    </td>
                    <td style="text-align:center;">
                            <input type="text" disabled="disabled" class="form-control" id="absent_current{{ $student->student_code }}" value="{{ $student->absentcount }}"  >
                    </td>
                    <td style="text-align:center;">
                            <input type="text"  class="form-control adjust" id="absent_adjustment{{ $student->student_code }}" data-status="absent" data-code="{{ $student->student_code }}"  value="{{$student->final_absent}}"  >
                    </td>
                    
                    
                </tr>
                <tr>
                    <td style="text-align:center;">
                       Late
                    </td>
                    <td style="text-align:center;">
                            <input type="text" disabled="disabled" class="form-control" id="late_current{{ $student->student_code }}" value="{{ $student->lateCount }}"  >
                    </td>
                    <td style="text-align:center;">
                            <input type="text"  class="form-control adjust" id="late_adjustment{{ $student->student_code }}" data-status="late" data-code="{{ $student->student_code }}"  value="{{$student->final_late}}"  >
                    </td>
                    
                </tr>
                <tr>
                    <td style="text-align:center;">
                       Missing
                    </td>
                    <td style="text-align:center;">
                            <input type="text" disabled="disabled" class="form-control" id="missing_current{{ $student->student_code }}" value="{{ $student->missingCount }}"  >
                    </td>
                    <td style="text-align:center;">
                            <input type="text"  class="form-control adjust" id="missing_adjustment{{ $student->student_code }}" data-status="missing" data-code="{{ $student->student_code }}"  value="{{$student->final_missing}}"  >
                    </td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>
    
@else
<p class="text-center alert alert-warning mt-5">No records of absence or late</p>
   
@endif
