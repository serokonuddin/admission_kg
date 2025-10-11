<ul class="timeline ms-2">
            @php 
              $status=['Present','Absent','Leave'];
            @endphp
            @foreach($attendances as $student)
            <li class="timeline-item timeline-item-transparent">
              <span class="timeline-point-wrapper"><span class="timeline-point timeline-point-warning"></span></span>
              <div class="timeline-event">
                <div class="timeline-header mb-1">
                  <h6 class="mb-0">{{$status[($student->status-1)]}}</h6>
                  <small class="text-muted">{{$student->attendance_date}}</small>
                </div>
                <p class="mb-2">Attendance at {{$student->time}}</p>
               
              </div>
            </li>
            @endforeach
            
          </ul>