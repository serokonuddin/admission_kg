<table class="table">
    <thead>
      <tr>
        <th style="width: 10%"><div class="form-check mt-3">
          <input class="form-check-input" type="checkbox" name="all" value="" id="all" />
          <label class="form-check-label" for="all"> ALL </label>
        </div></th>
        
        <th style="width: 12%">Time</th>
        <th style="width: 20%;word-wrap: break-word;">Teacher Name</th>
        <th style="width: 12%">Subject</th>
        <th style="width: 12%">Version</th>
        <th style="width: 12%">Class</th>
        <th style="width: 12%">Section</th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">
        @foreach($employees as $teacher)
      <tr>
        <td>
            {{-- <div class="form-check mt-3">
              <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" />
              <label class="form-check-label" for="defaultCheck1"> Is Prosent </label>
            </div> --}}
            <input type="hidden" name="teacher_id[]" value="{{$teacher->id}}-{{$teacher->subject_id}}" />
            <div class="form-check form-check-inline mt-3">
              <input
                class="form-check-input Present"
                type="radio"
                {{(isset($teacher->employeeAttendance->status) && ($teacher->employeeAttendance->status==1 || $teacher->employeeAttendance->status==4))?'checked="checked"':''}}
                name="attendance{{$teacher->id}}-{{$teacher->subject_id}}"
                id="attendance{{$teacher->id}}-{{$teacher->subject_id}}1"

                value="1" />
              <label class="form-check-label {{(isset($teacher->employeeAttendance->status) && $teacher->employeeAttendance->status==1)?'present':''}}" for="attendance{{$teacher->id}}1" >Present</label>
            </div>
            <div class="form-check form-check-inline">
              <input
                class="form-check-input Absent"
                {{(isset($teacher->employeeAttendance->status) && $teacher->employeeAttendance->status==2)?'checked="checked"':''}}
                type="radio"
                name="attendance{{$teacher->id}}-{{$teacher->subject_id}}"
                id="attendance{{$teacher->id}}-{{$teacher->subject_id}}2"
                value="2" />
              <label class="form-check-label {{(isset($teacher->employeeAttendance->status) && $teacher->employeeAttendance->status==2)?'absent':''}}" for="attendance{{$teacher->id}}2" >Absent</label>
            </div>
            <div class="form-check form-check-inline">
              <input
                class="form-check-input Leave"
                type="radio"
                {{(isset($teacher->employeeAttendance->status) && $teacher->employeeAttendance->status==3)?'checked="checked"':''}}
                name="attendance{{$teacher->id}}-{{$teacher->subject_id}}"
                id="attendance{{$teacher->id}}-{{$teacher->subject_id}}3"
                value="3" />
              <label class="form-check-label {{(isset($teacher->employeeAttendance->status) && $teacher->employeeAttendance->status==3)?'leave':''}}" for="attendance{{$teacher->id}}3" >Leave</label>
            </div>
          </td>
        <td style="word-wrap: break-word;">
            <input class="form-control" name="time{{$teacher->id}}-{{$teacher->subject_id}}" value="{{(isset($teacher->employeeAttendance->time))?$teacher->employeeAttendance->time:$teacher->start_time}}" id="time{{$teacher->id}}" type="time"  id="html5-time-input" required>
            <input class="form-control" name="atime{{$teacher->id}}-{{$teacher->subject_id}}" value="{{(isset($teacher->employeeAttendance->time))?$teacher->employeeAttendance->time:$teacher->start_time}}" id="atime{{$teacher->id}}" type="hidden"  id="html5-time-input" >
        </td>
        <td style="word-wrap: break-word;">
          <img src="{{asset('public/backend')}}/assets/img/avatars/5.png" alt="Avatar" class="rounded-circle avatar avatar-xs">
        
          {{$teacher->employee_name}}<br>({{$teacher->designation_name}})
        </td>
        <td>
            {{$teacher->subject_name}}
        </td>
        <td>
            {{$teacher->version_name}}
        </td>
        <td>
            {{$teacher->class_name}}
        </td>
        <td>
            {{$teacher->section_name}}
        </td>
      </tr>
      @endforeach
      
    </tbody>
  </table>