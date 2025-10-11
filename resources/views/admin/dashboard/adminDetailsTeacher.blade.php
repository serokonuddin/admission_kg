@extends('admin.layouts.layout')
@section('content')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<style type="text/css">
.highcharts-figure,
.highcharts-data-table table {
    min-width: 320px;
    max-width: 800px;
    margin: 1em auto;
}

.highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #ebebeb;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
}

.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}

.highcharts-data-table th {
    font-weight: 600;
    padding: 0.5em;
}

.highcharts-data-table td,
.highcharts-data-table th,
.highcharts-data-table caption {
    padding: 0.5em;
}

.highcharts-data-table thead tr,
.highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}

.highcharts-data-table tr:hover {
    background: #f1f7ff;
}

input[type="number"] {
    min-width: 50px;
}
.content-wrapper .badge.badge-notifications:not(.badge-dot) {
    padding: 0.7rem 0.9rem !important;
    font-size: .882rem !important;
    line-height: 1.0rem !important;
}
.badge.badge-notifications {
    position: absolute;
    top: auto;
    display: inline-block;
    margin: 0;
    margin-top: -10px;
    margin-right: 0px;
    margin-bottom: 0px;
    margin-left: 0px;
}
.ml-1{
  margin-left: 25px!important;
}
.ml-2{
    margin-left: 20px!important;
}
.ml-4{
    margin-left: 40px!important;
}
.rounded-circle {
    border-radius: 50% !important;
    border: 1px solid #eee!important;
}
.avatar-xs{
    border-radius: 50% !important;
    border: 1px solid #7a7878!important;
    width: 1.825rem!important;
    height: 1.825rem!important;
}
.avatar-xs a{
    margin-left: 4px;
}
.avatar {
    position: relative;
    width: 1.675rem!important;
    height: 1.675rem!important;
    cursor: pointer;
}
.badge {
    --bs-badge-padding-x: 0.193em;
    --bs-badge-padding-y: 0.22em;
    --bs-badge-font-size: 1.0em;
}
</style>
@php
            $colordata=array('primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark');
@endphp
<div class="content-wrapper">
   <!-- Content -->
   <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      @foreach($type_for as $key=>$type)
      @php
           $statusdata=array();
            if(isset($employeedataAttandance[$key])){
                $statusdata=collect($employeedataAttandance[$key])->groupBy('status');
            }

      @endphp
        <div class="col-md-6 col-12 mb-md-0 mb-4">
          <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between pb-0">
               <div class="card-title mb-0">
                  <h5 class="m-0 me-2">{{$type}} Teacher</h5>
               </div>

            </div>
            <div class="card-body">
               <div class="d-flex justify-content-between align-items-center mb-3" style="position: relative;">
                  <div class="resize-triggers">
                     <div class="expand-trigger">
                        <div style="width: 253px; height: 139px;"></div>
                     </div>
                     <div class="contract-trigger"></div>
                  </div>
               </div>
               <ul class="p-0 m-0">
                  <li class="d-flex mb-4 pb-1">
                     <div class="avatar flex-shrink-0 me-3">
                        <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-group"></i></span>
                     </div>
                     <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                           <h6 class="badge bg-label-primary me-1">Total Teacher</h6>
                           <!-- <small class="text-muted">Mobile, Earbuds, TV</small> -->
                        </div>
                        <div class="user-progress">
                           <small class="fw-medium badge bg-label-primary me-1">{{$employeedata[$key][0]->count??""}}</small>
                        </div>
                     </div>
                  </li>
                  <li class="d-flex mb-4 pb-1">
                     <div class="avatar flex-shrink-0 me-3">
                        <span class="avatar-initial rounded bg-label-success"><i class="bx bx-user"></i></span>
                     </div>
                     <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                           <h6 class="badge bg-label-success me-1">Present</h6>
                        </div>
                        <div class="user-progress">
                           <small class="fw-medium badge bg-label-success me-1">{{$statusdata[1][0]->count??''}}</small>
                        </div>
                     </div>
                  </li>
                  <li class="d-flex mb-4 pb-1">
                     <div class="avatar flex-shrink-0 me-3">
                        <span class="avatar-initial rounded bg-label-info"><i class="bx bx-time-five"></i></span>
                     </div>
                     <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                           <h6 class="badge bg-label-info me-1">Late</h6>
                        </div>
                        <div class="user-progress">
                           <small class="fw-medium badge bg-label-info me-1">{{$statusdata[4][0]->count??''}}</small>
                        </div>
                     </div>
                  </li>
                  <li class="d-flex mb-4 pb-1">
                     <div class="avatar flex-shrink-0 me-3">
                        <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-user-x"></i></span>
                     </div>
                     <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                           <h6 class="badge bg-label-warning me-1">Absent</h6>
                        </div>
                        <div class="user-progress">
                           <small class="fw-medium badge bg-label-warning me-1">{{$statusdata[2][0]->count??''}}</small>
                        </div>
                     </div>
                  </li>
                  <li class="d-flex">
                     <div class="avatar flex-shrink-0 me-3">
                        <span class="avatar-initial rounded bg-label-secondary"><i class="bx bx-user-minus"></i></span>
                     </div>
                     <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                           <h6 class="badge bg-label-secondary me-1">Leave</h6>
                        </div>
                        <div class="user-progress">
                           <small class="fw-medium badge bg-label-secondary me-1">{{$statusdata[3][0]->count??''}}</small>
                        </div>
                     </div>
                  </li>
               </ul>
            </div>
         </div>




        </div>
      @endforeach


   </div>
   <!-- / Content -->
   <div class="content-backdrop fade"></div>
</div>
<script>


document.getElementById('small').addEventListener('click', function () {
chart.setSize(400);
});

document.getElementById('large').addEventListener('click', function () {
chart.setSize(600);
});

document.getElementById('auto').addEventListener('click', function () {
chart.setSize(null);
});
</script>
@endsection
