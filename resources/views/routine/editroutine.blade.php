@extends('admin.layouts.layout')
@section('content')

<style>
    .control {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
        position: relative;
        cursor: pointer;
    }
    th.control:before,td.control:before {
        background-color: #696cff;
        border: 2px solid #fff;
        box-shadow: 0 0 3px rgba(67,89,113,.8);
    }
    td.control:before, th.control:before {
        top: 50%;
        left: 50%;
        height: 0.8em;
        width: 0.8em;
        margin-top: -0.5em;
        margin-left: -0.5em;
        display: block;
        position: absolute;
        color: white;
        border: 0.15em solid white;
        border-radius: 1em;
        box-shadow: 0 0 0.2em #444;
        box-sizing: content-box;
        text-align: center;
        text-indent: 0 !important;
        font-family: "Courier New",Courier,monospace;
        line-height: 1em;
        content: "+";
        background-color: #0d6efd;
    }
    .table-dark {
        background-color: #1c4d7c!important;
        color: #fff!important;
        font-weight: bold;
    }
    .table-dark {
        --bs-table-bg: #1c4d7c!important;
        --bs-table-striped-bg: #1c4d7c!important;
        --bs-table-striped-color: #fff!important;
        --bs-table-active-bg: #1c4d7c!important;
        --bs-table-active-color: #fff!important;
        --bs-table-hover-bg: #1c4d7c!important;
        --bs-table-hover-color: #fff!important;
        color: #fff!important;
        border-color: #1c4d7c!important;
    }
    .table:not(.table-dark) th {
        color: #ffffff;
    }

</style>
<script type="text/javascript" src="{{asset('backend/js/index.global.min.js')}}"></script>
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y" id="attendance-part">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Academy /</span> Routine</h4>
        <div class="row">
           <div class="col-md-12">
             <form class="event-form pt-0 fv-plugins-bootstrap5 fv-plugins-framework" action="{{route('routine.store')}}" method="post" id="eventForm" >
                 @csrf
                 <input type="hidden" name="id" id="id" value="0" />
                 <div class="mb-3">
                     <label class="form-label" for="eventLabel">Routine For</label>
                     <div class="position-relative">
                        <select class="select2 select-event-label form-select select2-hidden-accessible" id="type_for" name="type_for" >
                           <option value="">Select Routine</option>

                           <option  value="primary" >Primary</option>
                           <option  value="secondary" >Secondary</option>
                           <option  value="college" >College</option>


                        </select>

                     </div>
                  </div>
                 <div class="mb-3">
                     <label class="form-label" for="eventLabel">Session</label>
                     <div class="position-relative">
                        <select class="select2 select-event-label form-select select2-hidden-accessible" id="session_id" name="session_id" >
                           <option value="">Select Session</option>
                           @foreach($sessiondata as $s)
                           <option  value="{{$s->id}}" {{($s->session_name==date('Y'))?'selected="selected"':''}}>{{$s->session_name}}</option>
                           @endforeach

                        </select>

                     </div>
                  </div>
                 <div class="mb-3">
                     <label class="form-label" for="eventLabel">Version</label>
                     <div class="position-relative">
                        <select class="select2 select-event-label form-select select2-hidden-accessible" id="version_id" name="version_id" >
                           <option value="">Select Version</option>
                           @foreach($versions as $version)
                           <option  value="{{$version->id}}">{{$version->version_name}}</option>
                           @endforeach

                        </select>

                     </div>
                  </div>
                 <div class="mb-3">
                     <label class="form-label" for="eventLabel">Shift</label>
                     <div class="position-relative">
                        <select class="select2 select-event-label form-select select2-hidden-accessible" id="shift_id" name="shift_id" >
                           <option value="">Select Shift</option>
                           @foreach($shifts as $shift)
                           <option  value="{{$shift->id}}">{{$shift->shift_name}}</option>
                           @endforeach

                        </select>

                     </div>
                  </div>
                  <div class="mb-3">
                     <label class="form-label" for="eventLabel">Class</label>
                     <div class="position-relative">
                        <select class="select2 select-event-label form-select select2-hidden-accessible" id="class_id" name="class_id" >
                           <option value="">Select Class</option>
                        </select>
                     </div>
                  </div>
                  <div class="mb-3">
                     <label class="form-label" for="eventLabel">Section</label>
                     <div class="position-relative">
                        <select class="select2 select-event-label form-select select2-hidden-accessible" id="section_id" name="section_id" >
                           <option value="">Select Section</option>


                        </select>

                     </div>
                  </div>
                  <div class="mb-3">
                     <label class="form-label" for="eventLabel">Subject</label>
                     <div class="position-relative">
                        <select class="select2 select-event-label form-select select2-hidden-accessible" id="subject_id" name="subject_id" >
                           <option value="">Select Subject</option>


                        </select>

                     </div>
                  </div>
                  <div class="mb-3">
                     <label class="form-label" for="eventLabel">Teacher</label>
                     <div class="position-relative">
                        <select class="select2 select-event-label form-select select2-hidden-accessible" id="employee_id" name="employee_id" >
                           <option value="">Select Teacher</option>


                        </select>

                     </div>
                  </div>
                  <div class="mb-3">
                     <label class="form-label" for="eventLabel">Day</label>
                     <div class="position-relative">
                        <select class="select2 select-event-label form-select select2-hidden-accessible" id="day_name" name="day_name" >
                           <option value="">Select Day</option>
                           @foreach($days as $day)
                           <option  value="{{$day->day_name}}" >{{$day->day_name}}</option>
                           @endforeach



                        </select>

                     </div>
                  </div>
                  <div class="mb-3">
                     <label class="form-label" for="eventLabel">Time</label>
                     <div class="position-relative">
                        <select class="select2 select-event-label form-select select2-hidden-accessible" id="time" name="time" >


                        </select>

                     </div>
                     <!-- <div class="position-relative secondarys primarys">
                        <select class="select2 select-event-label form-select select2-hidden-accessible" id="time" name="time" >
                           <option value="">Select Time</option>
                           <option value="07:30 AM-08:10 AM">07:30 AM-08:10 AM</option>
                           <option value="08:10 AM-08:50 AM">08:10 AM-08:50 AM</option>
                           <option value="08:50 AM-09:30 AM">08:50 AM-09:30 AM</option>
                           <option value="09:30 AM-09:50 AM">09:30 AM-09:50 AM</option>
                           <option value="09:50 AM-10:30 AM">09:50 AM-10:30 AM</option>
                           <option value="10:30 AM-11:00 AM">10:30 AM-11:00 AM</option>
                           <option value="11:00 AM-11:30 AM">11:00 AM-11:30 AM</option>

                        </select>

                     </div> -->

                  </div>

                  <!-- <div class="mb-3">
                     <label class="form-label" for="eventDescription">Start Time</label>
                     <input class="form-control" name="start_time" id="start_time" type="time" value="12:04" required="">
                  </div>
                  <div class="mb-3">
                     <label class="form-label" for="eventDescription">End Time</label>
                     <input class="form-control" name="end_time" id="end_time" type="time" value="12:04" required="">
                  </div> -->
                  <div class="mb-3">
                       <div class="form-check form-check-inline">
                         <input class="form-check-input" type="checkbox" name="is_class_teacher" id="is_class_teacher" value="1">
                         <label class="form-check-label" for="english">Is Class Teacher</label>
                       </div>
                  </div>
                  <div class="mb-3 d-flex justify-content-sm-between justify-content-start my-4">
                     <div>
                        <button type="submit" class="btn btn-primary btn-add-event me-sm-3 me-1">Add</button>
                        <button type="reset" class="btn btn-label-secondary btn-cancel me-sm-0 me-1" data-bs-dismiss="offcanvas">Cancel</button>
                     </div>
                     <div><button class="btn btn-label-danger btn-delete-event d-none">Delete</button></div>
                  </div>
                  <input type="hidden">
               </form>
           </div>
        </div>

     </div>

    <!-- / Content -->

    <div class="content-backdrop fade"></div>
 </div>

    <!-- / Footer -->


    <script>



      </script>
 <script type="text/javascript">

</script>

@endsection
