<table class="table">
    <thead>
      <tr>
        
        
       
        <th style="width: 20%;word-wrap: break-word;">Teacher Name</th>
        <th style="width: 12%">Subject</th>
        <th style="width: 12%">Version</th>
        <th style="width: 12%">Class</th>
        <th style="width: 12%">Section</th>
        <th style="width: 12%">Time</th>
        <th style="width: 10%">Status</th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">
        @foreach($employees as $teacher)
      <tr>
        
        <td style="word-wrap: break-word;" data-bs-toggle="modal"
        data-bs-target="#fullscreenModal" class="teacherdetails" data-id="{{$teacher->id}}">
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
        <td>
            {{-- <div class="form-check mt-3">
              <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" />
              <label class="form-check-label" for="defaultCheck1"> Is Prosent </label>
            </div> --}}
            {{(isset($teacher->employeeAttendance->status) && $teacher->employeeAttendance->status==1)?'Present':''}}
            {{(isset($teacher->employeeAttendance->status) && $teacher->employeeAttendance->status==2)?'absent':''}}
            {{(isset($teacher->employeeAttendance->status) && $teacher->employeeAttendance->status==3)?'leave':''}}
            @if(isset($student->employeeAttendance->status) && $student->employeeAttendance->status==3)
              <br/>
              <a href="{{asset('Leave_bangla.png')}}" data-bs-toggle="modal"
              data-bs-target="#fullscreenModal"><i class="fa fa-file"></i></a>
            @endif
          </td>
        <td style="word-wrap: break-word;">
            {{(isset($teacher->employeeAttendance->time))?date('H:i',strtotime($teacher->employeeAttendance->time)):''}}
        </td>
      </tr>
      @endforeach
      
    </tbody>
  </table>

  <!-- Modal -->
  <div class="modal fade" id="fullscreenModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalFullTitle">Employee Profile</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"></button>
        </div>
        <div class="modal-body" id="teacherprofile" style="background-color: #f5f2f2">
          @include('employee.profile')
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Close
          </button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>