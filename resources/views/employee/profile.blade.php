<div class="row">
    <div class="col-12">
      <div class="card mb-2">
        {{-- <div class="user-profile-header-banner">
          <img src="{{asset('profile-banner.png')}}" alt="Banner image" class="rounded-top">
        </div> --}}
        <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
          <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
            <img src="{{$teacher->photo??asset('public/employee.png')}}" style="width: 100px;margin-top:15px" alt="user image" class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img">
          </div>
          <div class="flex-grow-1 mt-3 mt-sm-5">
            <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
              <div class="user-profile-info">
                <h4>{{$teacher->employee_name}}</h4>
                <h5>{{$teacher->designation->designation_name??''}}</h5>
                <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                  <li class="list-inline-item fw-medium">
                    <i class="bx bx-pen"></i> 
                    {{$teacher->subject->subject_name??''}}
                  </li>
                  <li class="list-inline-item fw-medium">
                    <i class="bx bx-grid-alt me-1"></i> {{($teacher->job_type==1)?'Permanent':'Pertime'}}
                  </li>
                  <li class="list-inline-item fw-medium">
                    <i class="bx bx-calendar-alt"></i> Joined: {{$teacher->join_date}}
                  </li>
                  
                  @php 
                    $type=array('Primary','School','College','English Medium');
                  @endphp
                  {{-- <li class="list-inline-item fw-medium">
                    <i class="bx bx-grid-alt me-1"></i>
                  </li> --}}
                </ul>
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 mb-2">
      <ul class="nav nav-pills flex-column flex-sm-row mb-4">
        <li class="nav-item"><a class="nav-link " href="javascript:void(0);"><i class="bx bx-user me-1"></i> Academic Information</a></li>
        <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i class="bx bx-group me-1"></i> Attendance</a></li>
        <li class="nav-item"><a class="nav-link" href="javascript:void(0);"><i class="bx bx-group me-1"></i> Payment</a></li>
        <li class="nav-item"><a class="nav-link" href="javascript:void(0);"><i class="bx bx-grid-alt me-1"></i> Routine</a></li>
        <li class="nav-item"><a class="nav-link" href="javascript:void(0);"><i class="bx bx-grid-alt me-1"></i> Exam</a></li>
      </ul>
    </div>
  </div>
  <div class="row">
    <div class="col-xl-4 col-lg-5 col-md-5">
      <!-- About User -->
      <div class="card mb-2">
        <div class="card-body">
          <small class="text-muted text-uppercase">About</small>
          <ul class="list-unstyled mb-4 mt-3">
            
            <li class="d-flex align-items-center mb-3"><i class="bx bx-detail"></i><span class="fw-medium mx-2">Job Type:</span> <span>{{($teacher->job_type==1)?'Permanent':'Pertime'}}</span></li>
            <li class="d-flex align-items-center mb-3"><i class="bx bx-detail"></i><span class="fw-medium mx-2">DOB:</span> <span>{{$teacher->dob}}</span></li>
            <li class="d-flex align-items-center mb-3"><i class="bx bx-detail"></i><span class="fw-medium mx-2">Employee For:</span> <span>{{$type[$teacher->employee_for]??''}}</span></li>
            <li class="d-flex align-items-center mb-3"><i class="bx bx-user"></i><span class="fw-medium mx-2">Father Name:</span> <span>{{$teacher->father_name}}</span></li>
            <li class="d-flex align-items-center mb-3"><i class="bx bx-user"></i><span class="fw-medium mx-2">Mother Name:</span> <span>{{$teacher->mother_name}}</span></li>
            <li class="d-flex align-items-center mb-3"><i class="bx bx-user"></i><span class="fw-medium mx-2">Spouse:</span> <span>{{$teacher->spouse}}</span></li>
            <li class="d-flex align-items-center mb-3"><i class="bx bx-star"></i><span class="fw-medium mx-2">Gender:</span> <span>{{($teacher->gender==1)?'Male':'Female'}}</span></li>
            <li class="d-flex align-items-center mb-3"><i class="bx bx-flag"></i><span class="fw-medium mx-2">Blood:</span> <span>{{$teacher->blood}}</span></li>
            @php 
              $religion=array('Islam','Hindu','christian','Buddhism','Others');
            @endphp
            <li class="d-flex align-items-center mb-3"><i class="bx bx-detail"></i><span class="fw-medium mx-2">Religion:</span> <span>{{$religion[($teacher->religion-1)]??''}}</span></li>

            <li class="d-flex align-items-center mb-3"><i class="bx bx-detail"></i><span class="fw-medium mx-2">NID:</span> <span>{{$teacher->nid}}</span></li>
            <li class="d-flex align-items-center mb-3"><i class="bx bx-detail"></i><span class="fw-medium mx-2">Passport:</span> <span>{{$teacher->passport}}</span></li>
            
          </ul>
          <small class="text-muted text-uppercase">Contacts</small>
          <ul class="list-unstyled mb-4 mt-3">
            <li class="d-flex align-items-center mb-3"><i class="bx bx-phone"></i><span class="fw-medium mx-2">Contact:</span> <span>{{$teacher->mobile}}</span></li>
           
            <li class="d-flex align-items-center mb-3"><i class="bx bx-envelope"></i><span class="fw-medium mx-2">Email:</span> <span>{{$teacher->email}}</span></li>
            <li class="d-flex align-items-center mb-3"><i class="bx bx-chat"></i><span class="fw-medium mx-2">Address:</span> <span>{{$teacher->present_address}}</span></li>
          </ul>
          {{-- <small class="text-muted text-uppercase">Teams</small>
          <ul class="list-unstyled mt-3 mb-0">
            <li class="d-flex align-items-center mb-3"><i class="bx bxl-github text-primary me-2"></i>
              <div class="d-flex flex-wrap"><span class="fw-medium me-2">Backend Developer</span><span>(126 Members)</span></div>
            </li>
            <li class="d-flex align-items-center"><i class="bx bxl-react text-info me-2"></i>
              <div class="d-flex flex-wrap"><span class="fw-medium me-2">React Developer</span><span>(98 Members)</span></div>
            </li>
          </ul> --}}
        </div>
      </div>
      <!--/ About User -->
      <!-- Profile Overview -->
      {{-- <div class="card mb-2">
        <div class="card-body">
          <small class="text-muted text-uppercase">Overview</small>
          <ul class="list-unstyled mt-3 mb-0">
            <li class="d-flex align-items-center mb-3"><i class="bx bx-check"></i><span class="fw-medium mx-2">Task Compiled:</span> <span>13.5k</span></li>
            <li class="d-flex align-items-center mb-3"><i class="bx bx-customize"></i><span class="fw-medium mx-2">Projects Compiled:</span> <span>146</span></li>
            <li class="d-flex align-items-center"><i class="bx bx-user"></i><span class="fw-medium mx-2">Connections:</span> <span>897</span></li>
          </ul>
        </div>
      </div> --}}
      <!--/ Profile Overview -->
    </div>
    <div class="col-xl-8 col-lg-7 col-md-7">
      <!-- Activity Timeline -->
      <div class="card card-action mb-2">
        <div class="card-header align-items-center">
          <h5 class="card-action-title mb-0"><i class="bx bx-list-ul me-2"></i>Activity Timeline</h5>
          <div class="card-action-element">
            
              
              <div class="input-group input-daterange" >
                <input type="date" name="start_date"  placeholder="MM/DD/YYYY" class="form-control">
                <span class="input-group-text">to</span>
                <input type="date" name="end_date" placeholder="MM/DD/YYYY" class="form-control">
              </div>
          </div>
        </div>
        <div class="card-body" id="attendanceDetails">
          <ul class="timeline ms-2">
            @foreach($teacher->teacherlastWeekAttendance as $teachera)
           
            <li class="timeline-item timeline-item-transparent">
              <span class="timeline-point-wrapper"><span class="timeline-point timeline-point-warning"></span></span>
              <div class="timeline-event">
                <div class="timeline-header mb-1">
                  @php 
                    $status=['Present','Absent','Leave'];
                  @endphp
                  <h6 class="mb-0">{{$status[($teachera->status-1)]}}</h6>
                  <small class="text-muted">{{$teachera->attendance_date}}</small>
                </div>
                <p class="mb-2">Attendance at {{$teachera->time}}</p>
                <div class="d-flex flex-wrap">
                  
                  <div>
                    <h6 class="mb-0">English (Class 9) </h6>
                    <span>Attendance at 8:00am</span>
                  </div>
                  
                </div>
                <div class="d-flex flex-wrap">
                  
                    <div>
                        <h6 class="mb-0">Bangla (Class 10) </h6>
                        <span>Attendance at 8:30am</span>
                      </div>
                   
                  </div>
              </div>
            </li>
            @endforeach
            
            {{-- <li class="timeline-item timeline-item-transparent">
              <span class="timeline-point-wrapper"><span class="timeline-point timeline-point-success"></span></span>
              
            </li> --}}
            
          </ul>
        </div>
      </div>
      <!--/ Activity Timeline -->
     
      <!-- Projects table -->
      
      <!--/ Projects table -->
    </div>
  </div>