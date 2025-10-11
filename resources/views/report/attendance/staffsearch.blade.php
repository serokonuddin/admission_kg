<table class="table">
    <thead>
      <tr>
        
        <th style="width: 40%;word-wrap: break-word;">Teacher Name</th>
        <th style="width: 40%">Designation</th>
        
        <th style="width: 10%">Time</th>
        <th style="width: 10%">Status</th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">
        @foreach($employees as $teacher)
      <tr>
        
        
        <td style="word-wrap: break-word;">
          <img src="{{asset('public/backend')}}/assets/img/avatars/5.png" alt="Avatar" class="rounded-circle avatar avatar-xs">
        
          {{$teacher->employee_name}}
        </td>
        <td>
            {{$teacher->designation_name}}
        </td>
        <td>
            
            {{(isset($student->employeeAttendance->status) && $student->employeeAttendance->status==1)?'Present':''}}
            {{(isset($student->employeeAttendance->status) && $student->employeeAttendance->status==2)?'absent':''}}
            {{(isset($student->employeeAttendance->status) && $student->employeeAttendance->status==3)?'leave':''}}
            
          </td>
        <td style="word-wrap: break-word;">
            {{(isset($student->employeeAttendance->time))?date('H:i',strtotime($student->employeeAttendance->time)):''}}
        </td>
      </tr>
      @endforeach
      
    </tbody>
  </table>