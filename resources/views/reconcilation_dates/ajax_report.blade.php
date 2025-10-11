



@if ($students)
<table class="table table-hover rounded-lg main">
        <thead class="table-dark" style="position: sticky; top: 0; z-index: 1000;">
            <tr>
                <th style="width: 2%">SL.</th>
                <th style="width: 8%;word-wrap: break-word;text-align:center;">Class</th>
                <th style="width: 8%;word-wrap: break-word;text-align:center;">Version</th>
                <th style="width: 8%;word-wrap: break-word;text-align:center;">Shift</th>
                <th style="width: 8%;word-wrap: break-word;text-align:center;">Section</th>
                <th style="width: 8%;word-wrap: break-word;text-align:center;">PID</th>
                <th style="width: 20%;word-wrap: break-word;text-align:center;">Student Name</th>
                
                <th style="width: 20%;text-align:center;">Father Name</th>
                <th style="width: 10%;text-align:center;">Title</th>
                
                <th style="width: 8%;text-align:center;">Number</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @foreach ($students as $student)
                <tr>
                    <td rowspan="3" style="word-wrap: break-word;text-align:center;">
                        {{ $loop->iteration }}
                    </td>
                    <td rowspan="3" style="word-wrap: break-word;text-align:left;">
                    {{ $student->class_code }}
                    </td>
                    <td rowspan="3" style="word-wrap: break-word;text-align:left;">
                    {{ $student->section_name }}
                    </td>
                    <td rowspan="3" style="word-wrap: break-word;text-align:left;">
                    {{ $student->version_name }}
                    </td>
                    <td rowspan="3" style="word-wrap: break-word;text-align:left;">
                    {{ $student->shift_name }}
                    </td>
                    <td rowspan="3" style="word-wrap: break-word;text-align:left;">
                    {{ $student->PID }}
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
                            {{$student->final_absent}}
                    </td>
                    
                    
                </tr>
                <tr>
                    <td style="text-align:center;">
                       Late
                    </td>
                    
                    <td style="text-align:center;">
                            {{$student->final_late}}
                    </td>
                    
                </tr>
                <tr>
                    <td style="text-align:center;">
                       Missing
                    </td>
                    
                    <td style="text-align:center;">
                           {{$student->final_missing}}
                    </td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>
    
@else
<p class="text-center alert alert-warning mt-5">No records of absence or late</p>
   
@endif
