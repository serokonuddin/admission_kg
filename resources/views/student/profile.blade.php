<div class="row">
    <div class="col-12">
        <div class="card mb-2">
            {{-- <div class="user-profile-header-banner">
          <img src="{{asset('profile-banner.png')}}" alt="Banner image" class="rounded-top">
        </div> --}}
            <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                    <input type="hidden" id="student_code_value" value="{{ $student->student_code }}" />
                    <img src="{{ $student->photo ?? asset('student.png') }}" style="width: 100px;margin-top:15px"
                        alt="user image" class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img">
                </div>
                <div class="flex-grow-1 mt-3 mt-sm-5">
                    <div
                        class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                        <div class="user-profile-info">
                            <h4>{{ $student->first_name . ' ' . $student->last_name }}</h4>
                            <ul
                                class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                <li class="list-inline-item fw-medium">
                                    <i class="bx bx-pen"></i> {{ $student->first_name . ' ' . $student->last_name }}
                                </li>
                                <li class="list-inline-item fw-medium">
                                    <i
                                        class="bx bx-grid-alt me-1"></i>{{ $student->studentActivity->shift->shift_name ?? 'NA' }}
                                </li>
                                <li class="list-inline-item fw-medium">
                                    <i class="bx bx-grid-alt me-1"></i>
                                    {{ $student->studentActivity->classes->class_name ?? 'NA' }}
                                </li>
                                <li class="list-inline-item fw-medium">
                                    <i class="bx bx-calendar-alt"></i>
                                    {{ $student->studentActivity->section->section_name ?? 'NA' }}
                                </li>


                                <li class="list-inline-item fw-medium">
                                    <i class="bx bx-calendar-alt"></i> {{ $student->birthdate ?? 'NA' }}
                                </li>
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
            <!-- <li class="nav-item"><a class="nav-link " href="javascript:void(0);"><i class="bx bx-user me-1"></i> Academic Information</a></li> -->
            <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i class="bx bx-group me-1"></i>
                    Attendance</a></li>
            <li class="nav-item"><a class="nav-link" href="javascript:void(0);"><i class="bx bx-grid-alt me-1"></i>
                    Fee</a></li>
            <li class="nav-item"><a class="nav-link" href="javascript:void(0);"><i class="bx bx-grid-alt me-1"></i>
                    Routine</a></li>
            <li class="nav-item"><a class="nav-link" href="javascript:void(0);"><i class="bx bx-grid-alt me-1"></i>
                    Exam</a></li>
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

                    <li class="d-flex align-items-center mb-3"><i class="bx bx-detail"></i><span
                            class="fw-medium mx-2">Student For:</span>
                        <span>{{ $student->studentActivity->version->version_name ?? 'NA' }}</span>
                    </li>
                    <li class="d-flex align-items-center mb-3"><i class="bx bx-user"></i><span
                            class="fw-medium mx-2">Father Name:</span> <span>{{ $student->father_name ?? 'NA' }}</span>
                    </li>
                    <li class="d-flex align-items-center mb-3"><i class="bx bx-phone"></i><span
                            class="fw-medium mx-2">Father Phone:</span>
                        <span>{{ $student->father_phone ?? 'NA' }}</span>
                    </li>
                    <li class="d-flex align-items-center mb-3"><i class="bx bx-detail"></i><span
                            class="fw-medium mx-2">Mother Name:</span> <span>{{ $student->mother_name ?? 'NA' }}</span>
                    </li>
                    <li class="d-flex align-items-center mb-3"><i class="bx bx-phone"></i><span
                            class="fw-medium mx-2">Mother Phone:</span>
                        <span>{{ $student->mother_phone ?? 'NA' }}</span>
                    </li>
                    <li class="d-flex align-items-center mb-3"><i class="bx bx-star"></i><span
                            class="fw-medium mx-2">Gender:</span>
                        <span>{{ $student->gender == 1 ? 'Male' : 'Female' ?? 'NA' }}</span>
                    </li>
                    <li class="d-flex align-items-center mb-3"><i class="bx bx-flag"></i><span
                            class="fw-medium mx-2">Blood:</span> <span>{{ $student->blood ?? 'NA' }}</span></li>
                    @php
                        $religion = ['Islam', 'Hindu', 'christian', 'Buddhism', 'Others'];
                    @endphp
                    <li class="d-flex align-items-center mb-3"><i class="bx bx-detail"></i><span
                            class="fw-medium mx-2">Religion:</span>
                        <span>{{ $religion[$student->religion - 1] ?? 'NA' }}</span>
                    </li>
                    <li class="d-flex align-items-center mb-3"><i class="bx bx-home"></i><span
                            class="fw-medium mx-2">House:</span>
                        <span>{{ $student->studentActivity->house->house_name ?? 'NA' }}</span>
                    </li>
                    <li class="d-flex align-items-center mb-3"><i class="bx bx-category"></i><span
                            class="fw-medium mx-2">Category:</span>
                        <span>{{ $student->studentActivity->category->category_name ?? 'NA' }}</span>
                    </li>
                </ul>
                <small class="text-muted text-uppercase">Contacts</small>
                <ul class="list-unstyled mb-4 mt-3">
                    <li class="d-flex align-items-center mb-3"><i class="bx bx-phone"></i><span
                            class="fw-medium mx-2">Contact:</span>
                        <span>{{ $student->sms_notification ?? 'NA' }}</span>
                    </li>

                    <li class="d-flex align-items-center mb-3"><i class="bx bx-envelope"></i><span
                            class="fw-medium mx-2">Email:</span> <span>{{ $student->email ?? 'NA' }}</span></li>
                    <li class="d-flex align-items-center mb-3"><i class="bx bx-chat"></i><span
                            class="fw-medium mx-2">Address:</span> <span>{{ $student->present_addr ?? 'NA' }}</span>
                    </li>
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


                    <div class="input-group input-daterange">
                        <input type="date" name="start_date" id="start_date" placeholder="MM/DD/YYYY"
                            class="form-control attendance_search">
                        <span class="input-group-text">to</span>
                        <input type="date" name="end_date" id="end_date" placeholder="MM/DD/YYYY"
                            class="form-control attendance_search">
                    </div>
                </div>
                <!-- <div class="card-action-element">
            <div class="dropdown">
              <button type="button" class="btn dropdown-toggle hide-arrow p-0" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="javascript:void(0);">Last Week</a></li>
                <li><a class="dropdown-item" href="javascript:void(0);">Last Month</a></li>
                <li><a class="dropdown-item" href="javascript:void(0);">Current Year</a></li>

              </ul>
            </div>
          </div> -->

            </div>
            <div class="card-body" id="attendanceDetails">
                <ul class="timeline ms-2">
                    @php
                        $status = ['Present', 'Absent', 'Leave', 'Late'];
                    @endphp
                    @foreach ($student->studentlastWeekAttendance as $student)
                        <li class="timeline-item timeline-item-transparent">
                            <span class="timeline-point-wrapper"><span
                                    class="timeline-point timeline-point-warning"></span></span>
                            <div class="timeline-event">
                                <div class="timeline-header mb-1">
                                    <h6 class="mb-0">{{ $status[$student->status - 1] }}</h6>
                                    <small class="text-muted">{{ $student->attendance_date }}</small>
                                </div>
                                <p class="mb-2">Attendance at {{ $student->time }}</p>

                            </div>
                        </li>
                    @endforeach

                </ul>
            </div>
        </div>
        <!--/ Activity Timeline -->

        <!-- Projects table -->

        <!--/ Projects table -->
    </div>
</div>
