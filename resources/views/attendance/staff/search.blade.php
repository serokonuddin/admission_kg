<table class="table">
    <thead>
      <tr>
        <th style="width: 10%"><div class="form-check mt-3">
          <input class="form-check-input" type="checkbox" name="all" value="" id="all" />
          <label class="form-check-label" for="all"> ALL </label>
        </div></th>
        
        <th style="width: 10%">Time</th>
        <th style="width: 40%;word-wrap: break-word;">Teacher Name</th>
        <th style="width: 40%">Designation</th>
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
            <input type="hidden" name="teacher_id[]" value="{{$teacher->id}}" />
            <div class="form-check form-check-inline mt-3">
              <input
                class="form-check-input Present"
                type="radio"
                {{(isset($teacher->employeeAttendance->status) && $teacher->employeeAttendance->status==1)?'checked="checked"':''}}
                name="attendance{{$teacher->id}}"
                id="attendance{{$teacher->id}}1"
                value="1" />
              <label class="form-check-label {{(isset($teacher->employeeAttendance->status) && $teacher->employeeAttendance->status==1)?'present':''}}" for="attendance{{$teacher->id}}1" >Present</label>
            </div>
            <div class="form-check form-check-inline">
              <input
                class="form-check-input Absent"
                {{(isset($teacher->employeeAttendance->status) && $teacher->employeeAttendance->status==2)?'checked="checked"':''}}
                type="radio"
                name="attendance{{$teacher->id}}"
                id="attendance{{$teacher->id}}2"
                value="2" />
              <label class="form-check-label {{(isset($teacher->employeeAttendance->status) && $teacher->employeeAttendance->status==2)?'absent':''}}" for="attendance{{$teacher->id}}2" >Absent</label>
            </div>
            <div class="form-check form-check-inline">
              <input
                class="form-check-input Leave"
                type="radio"
                {{(isset($teacher->employeeAttendance->status) && $teacher->employeeAttendance->status==3)?'checked="checked"':''}}
                name="attendance{{$teacher->id}}"
                id="attendance{{$teacher->id}}3"
                value="3" />
              <label class="form-check-label {{(isset($teacher->employeeAttendance->status) && $teacher->employeeAttendance->status==3)?'leave':''}}" for="attendance{{$teacher->id}}3" >Leave</label>
            </div>
          </td>
        <td style="word-wrap: break-word;">
            <input class="form-control" name="time{{$teacher->id}}" value="{{(isset($teacher->employeeAttendance->time))?$teacher->employeeAttendance->time:'07:30'}}" id="time{{$teacher->id}}" type="time"  id="html5-time-input" required>
        </td>
        <td style="word-wrap: break-word;">
          <img src="{{asset('public/backend')}}/assets/img/avatars/5.png" alt="Avatar" class="rounded-circle avatar avatar-xs">
        
          {{$teacher->employee_name}}
        </td>
        <td>
            {{$teacher->designation_name}}
        </td>
        
      </tr>
      @endforeach
      
    </tbody>
  </table>