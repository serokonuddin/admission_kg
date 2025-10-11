<table class="table">
    <thead>
      <tr>
      <th style="width: 5%">Time</th>
        <th style="width: 10%"><div class="form-check mt-3">
          <input class="form-check-input" type="checkbox" name="all" value="" id="all" />
          <label class="form-check-label" for="all"> ALL </label>
        </div></th>
        <th style="width: 10%">Time</th>
        <th style="width: 10%">Roll</th>
        <th style="width: 20%;word-wrap: break-word;">Student Name</th>
        <th style="width: 10%">Session</th>
        <th style="width: 10%">Version</th>
        <th style="width: 12%">Class</th>
        <th style="width: 13%">Section</th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">
        @foreach($students as $key=>$student)
      <tr>
      <td style="word-wrap: break-word;">
          {{$loop->index+1}}
      </td>
        <td>
            {{-- <div class="form-check mt-3">
              <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" />
              <label class="form-check-label" for="defaultCheck1"> Is Prosent </label>
            </div> --}}
            <input type="hidden" name="student_code[]" value="{{$student->student_code}}" />
            <div class="form-check form-check-inline mt-3">
              <input
                class="form-check-input Present"
                type="radio"
                {{(isset($student->studentAttendance->status) && ($student->studentAttendance->status==1 ||$student->studentAttendance->status==4))?'checked="checked"':''}}
                name="attendance{{$student->student_code}}"
                id="attendance{{$student->student_code}}1"
                value="1" />
              <label class="form-check-label {{(isset($student->studentAttendance->status) && $student->studentAttendance->status==1)?'present':''}}" for="attendance{{$student->student_code}}1" >Present</label>
            </div>
            <div class="form-check form-check-inline">
              <input
                class="form-check-input Absent"
                {{(isset($student->studentAttendance->status) && $student->studentAttendance->status==2)?'checked="checked"':''}}
                type="radio"
                name="attendance{{$student->student_code}}"
                id="attendance{{$student->student_code}}2"
                value="2" />
              <label class="form-check-label {{(isset($student->studentAttendance->status) && $student->studentAttendance->status==2)?'absent':''}}" for="attendance{{$student->student_code}}2" >Absent</label>
            </div>
            <div class="form-check form-check-inline">
              <input
                class="form-check-input Leave"
                type="radio"
                {{(isset($student->studentAttendance->status) && $student->studentAttendance->status==3)?'checked="checked"':''}}
                name="attendance{{$student->student_code}}"
                id="attendance{{$student->student_code}}3"
                value="3" />
              <label class="form-check-label {{(isset($student->studentAttendance->status) && $student->studentAttendance->status==3)?'leave':''}}" for="attendance{{$student->student_code}}3" >Leave</label>
            </div>
            @if($student->class_name>10)
                            <div class="form-check form-check-inline">
                            <input
                                class="form-check-input Missing"
                                type="radio"
                                {{(isset($student->studentAttendance->status) && $student->studentAttendance->status==5)?'checked="checked"':''}}
                                name="attendance{{$student->student_code}}"
                                id="attendance{{$student->student_code}}5"
                                value="5" />
                            <label class="form-check-label {{(isset($student->studentAttendance->status) && $student->studentAttendance->status==5)?'Missing':''}}" for="attendance{{$student->student_code}}5" >Missing</label>
                            </div>
            @endif
          </td>
        <td style="word-wrap: break-word;">
            <input class="form-control" name="time{{$student->student_code}}" id="time{{$student->student_code}}" type="time" value="{{(isset($student->studentAttendance->time))?$student->studentAttendance->time:date('H:i',strtotime($student->start_time))}}" id="html5-time-input" required>
        </td>
        <td>{{$student->roll}}</td>
        <td style="word-wrap: break-word;">
          <img src="{{asset('public/backend')}}/assets/img/avatars/5.png" alt="Avatar" class="rounded-circle avatar avatar-xs">
        
          {{$student->first_name.' '.$student->last_name}}
        </td>
        <td>
            {{$student->session_name}}
        </td>
        <td>
            {{$student->version_name}}
        </td>
        <td>
            {{$student->class_name}}
        </td>
        <td>
            {{$student->section_name}}
        </td>
      </tr>
      @endforeach
      
    </tbody>
  </table>