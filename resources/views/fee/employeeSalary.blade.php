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
@php
$months=array(
    '01'=>'January',
    '02'=>'February',
    '03'=>'March',
    '04'=>'April',
    '05'=>'May',
    '06'=>'June',
    '07'=>'July',
    '08'=>'August',
    '09'=>'September',
    '10'=>'Octobar',
    '11'=>'November',
    '12'=>'December'
);
@endphp
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
       <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Employee Fee</h4>
       <!-- Basic Bootstrap Table -->
       <div class="card">

          <div class="row">
            <div class="col-sm-12 col-md-12">
               <div class="dataTables_length" id="DataTables_Table_0_length" style="padding: 5px">
                     <label>
                     <select id="session_id" name="session_id" class=" form-select" required="">
                                 <option value=""> Session</option>
                                 @foreach($sessions as $session)
                                 <option value="{{$session->id}}" {{($session_id==$session->id)?'selected="selected"':''}}>{{$session->session_name}}</option>
                                 @endforeach

                     </select>
                      </label>
                     <label>
                     <select id="version_id" name="version_id" class=" form-select" required="">
                                    <option value=""> Version</option>
                                    @foreach($versions as $version)
                                    <option value="{{$version->id}}" {{($version_id==$version->id)?'selected="selected"':''}}>{{$version->version_name}}</option>
                                    @endforeach

                     </select>
                      </label>


                     <label>
                     <select id="month" name="month" class=" form-select" required="">
                                    <option value=""> Month</option>
                                    @foreach($months as $key=>$monthvalue)
                                    <option value="{{$key}}" {{($month==$key)?'selected="selected"':''}}>{{$monthvalue}}</option>
                                    @endforeach

                     </select>
                     </label>
                     <label>
                           <button type="button" id="search" class="btn btn-primary me-2">Search</button>
                     </label>
               </div>

            </div>
            <!-- <div class="col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end">
               <div style="padding: 5px" id="DataTables_Table_1_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control" id="search" placeholder="" aria-controls="DataTables_Table_1"></label></div>
            </div> -->
         </div>
          <div class="table-responsive ">
             <table class="table">
                <thead class="table-dark">
                   <tr>
                      <!-- <th>#</th> -->
                      <th>#</th>
                      <th>Name</th>
                      <th>Session</th>
                      <th>Version</th>
                      <th>Month</th>
                      <th>Amount</th>
                      <th>Action</th>
                   </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($salaries as $key=>$employee)
                   <tr>
                      <td >
                        {{$key+1}}
                      </td>
                      <td
                      > <img src="{{(!empty($employee->employee->photo))?$employee->employee->photo:asset('employee.png')}}" alt="Avatar" class="rounded-circle avatar avatar-xs"> {{$employee->employee->employee_name}}<br>{{$employee->employee->designation->designation_name??''}}</td>
<!--
                      <td>{{$employee->employee->employee_name??''}}</td> -->
                      <td>{{$employee->session->session_name??''}}</td>
                      <td>{{$employee->version->version_name??''}}</td>

                      <td>{{$months[$employee->month]}}</td>
                      <td>{{$employee->amount??''}}</td>
                      <td data-bs-toggle="#modal"
                      data-bs-target="#fullscreenModal"
                       class="employeehead" data-id="{{$employee->employee_id}}">
                       <a class="dropdown-item edit"
                                    data-href="{{route('employees.edit', $employee->id)}}"><i class="fa fa-eye me-1"></i></a>
                      </td>
                   </tr>
                   @endforeach

                </tbody>
             </table>

          </div>
          <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_3_paginate" style="padding: 10px">
            {{$salaries->links('pagination')}}
          </div>
       </div>
       <!-- Modal -->
       <div class="modal fade" id="fullscreenModal" tabindex="-1" aria-hidden="true">
         <div class="modal-dialog modal-fullscreen" role="document">
           <div class="modal-content">
             <div class="modal-header">
               <h5 class="modal-title" id="modalFullTitle">Employee Salary Head</h5>
               <button
                 type="button"
                 class="btn-close"
                 data-bs-dismiss="modal"
                 aria-label="Close"></button>
             </div>
             <div class="modal-body" style="background-color: #f5f2f2">

             </div>
             <div class="modal-footer">
               <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                 Close
               </button>

             </div>
           </div>
         </div>
       </div>
    </div>
    <!-- / Content -->

    <div class="content-backdrop fade"></div>
 </div>
 <script type="text/javascript">
$(function(){
   $(document.body).on('click', '.employeehead',function(){
      var employee_id=$(this).data('id');
      var url="{{route('getEmployeeHeadDetails')}}";
      $.LoadingOverlay("show");
               $.ajax({
                   type: "post",
                   headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                   url: url,
                   data:{"_token": "{{ csrf_token() }}",employee_id},
                   success: function(response){
                     $.LoadingOverlay("hide");
                           $('.modal-body').html(response);


                   },
                   error: function(data, errorThrown)
                   {
                     $.LoadingOverlay("hide");
                       Swal.fire({
                           title: "Error",
                           text: errorThrown,
                           icon: "warning"
                       });

                   }
               });
      $('#fullscreenModal').modal('show');
   });
   $(document.body).on('click', '#search',function(){
      var month=$('#month').val();
      var session_id=$('#session_id').val();
      var version_id=$('#version_id').val();
         location.href="{{route('employeeSalary')}}"+'?month='+month+' & version_id='+version_id+'& session_id='+session_id;





   });
   $(document.body).on('change', '#search_by',function(){
      if($('#search').val() && $(this).val()){
         location.href="{{route('students.index')}}"+'?search_by='+$(this).val()+' & search='+$('#search').val();
      }


   });
});
$(function() {


         $(document.body).on('change','#class_id',function() {
            var id=$(this).val();
            var shift_id=$('#shift_id').val();
            var version_id=$('#version_id').val();
               var url="{{route('getSections')}}";
               $.LoadingOverlay("show");
               $.ajax({
                   type: "post",
                   headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                   url: url,
                   data:{"_token": "{{ csrf_token() }}",class_id:id,shift_id,version_id},
                   success: function(response){
                     $.LoadingOverlay("hide");
                           $('#section_id').html(response);


                   },
                   error: function(data, errorThrown)
                   {
                     $.LoadingOverlay("hide");
                       Swal.fire({
                           title: "Error",
                           text: errorThrown,
                           icon: "warning"
                       });

                   }
               });
         });
         $(document.body).on('change','#shift_id',function() {

            var shift_id=$('#shift_id').val();
            var version_id=$('#version_id').val();
            if(version_id && shift_id){
               var url="{{route('getClass')}}";
               $.LoadingOverlay("show");
               $.ajax({
                   type: "post",
                   headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                   url: url,
                   data:{"_token": "{{ csrf_token() }}",shift_id,version_id},
                   success: function(response){
                     $.LoadingOverlay("hide");
                           $('#class_id').html(response);
                           $('#section_id').html('');

                   },
                   error: function(data, errorThrown)
                   {
                     $.LoadingOverlay("hide");
                       Swal.fire({
                           title: "Error",
                           text: errorThrown,
                           icon: "warning"
                       });

                   }
               });
            }
         });
         $(document.body).on('change','#version_id',function() {

            var shift_id=$('#shift_id').val();
            var version_id=$('#version_id').val();
           if(version_id && shift_id){
              var url="{{route('getClass')}}";
              $.LoadingOverlay("show");
              $.ajax({
                  type: "post",
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                  url: url,
                  data:{"_token": "{{ csrf_token() }}",shift_id,version_id},
                  success: function(response){
                    $.LoadingOverlay("hide");
                          $('#class_id').html(response);
                          $('#section_id').html('');

                  },
                  error: function(data, errorThrown)
                  {
                    $.LoadingOverlay("hide");
                      Swal.fire({
                          title: "Error",
                          text: errorThrown,
                          icon: "warning"
                      });

                  }
              });
           }

        });

   });
</script>

@endsection
