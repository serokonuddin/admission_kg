@extends('admin.layouts.layout')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
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
$years=array(
    1=>'2024',
    2=>'2025',
    3=>'2026',
    4=>'2027',
    5=>'2028',
);
@endphp
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
       <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Student Payable month Range</h4>
       <!-- Basic Bootstrap Table -->
       <div class="card">
               <div class="card-body">

                        <form id="formAccountSettings" method="get" action="{{route('fees.create')}}" enctype="multipart/form-data">

                               @csrf
                               <div class="row">
                                       <div class="row mb-3 col-md-6">
                                           <label class="col-sm-3 col-form-label" for="basic-default-name">Student ID</label>
                                           <div class="col-sm-9">
                                           <input type="number" id="student_code" name="student_code" value="{{$student_code}}" class="form-control" placeholder="Student ID">
                                           </div>
                                       </div>

                                       <div class="row mb-3 col-md-6">
                                           <label class="col-sm-3 col-form-label" for="basic-default-name">Class</label>
                                           <div class="col-sm-9">
                                           <select id="class_id" name="class_id" class=" form-select" required="">
                                       <option value="">Select Class</option>
                                       <option value="0" {{($class_id==0)?'selected="selected"':''}}>KG</option>
                                           <option value="1" {{($class_id==1)?'selected="selected"':''}}>CLass I</option>
                                           <option value="2" {{($class_id==2)?'selected="selected"':''}}>CLass II</option>
                                           <option value="3" {{($class_id==3)?'selected="selected"':''}}>CLass III</option>
                                           <option value="4" {{($class_id==4)?'selected="selected"':''}}>CLass IV</option>
                                           <option value="5" {{($class_id==5)?'selected="selected"':''}}>CLass V</option>
                                           <option value="6" {{($class_id==6)?'selected="selected"':''}}>CLass VI</option>
                                           <option value="7" {{($class_id==7)?'selected="selected"':''}}>CLass VII</option>
                                           <option value="8" {{($class_id==8)?'selected="selected"':''}}>CLass VIII</option>
                                           <option value="9" {{($class_id==9)?'selected="selected"':''}}>CLass IX</option>
                                           <option value="10" {{($class_id==10)?'selected="selected"':''}}>CLass X</option>
                                           <option value="11" {{($class_id==11)?'selected="selected"':''}}>CLass XI</option>
                                           <option value="12" {{($class_id==12)?'selected="selected"':''}}>CLass XII</option>

                                       </select>
                                           </div>
                                       </div>
                                       <div class="row mb-3 col-md-6">
                                           <label class="col-sm-3 col-form-label" for="basic-default-name">Version</label>
                                           <div class="col-sm-9">
                                            <select id="version_id" name="version_id" class=" form-select" >
                                            <option value="">Select Version</option>

                                            @foreach($versions as $key=>$version)
                                            <option value="{{$version->id}}" {{($version_id==$version->id)?'selected="selected"':''}}>{{$version->version_name}}</option>
                                            @endforeach
                                            </select>
                                           </div>
                                       </div>
                                       <div class="row mb-3 col-md-6">
                                           <label class="col-sm-3 col-form-label" for="basic-default-name">Shift</label>
                                           <div class="col-sm-9">
                                            <select id="shift_id" name="shift_id" class=" form-select" >
                                            <option value="">Select Shift</option>

                                            @foreach($shifts as $key=>$shift)
                                            <option value="{{$shift->id}}" {{($shift_id==$shift->id)?'selected="selected"':''}}>{{$shift->shift_name}}</option>
                                            @endforeach
                                            </select>
                                           </div>
                                       </div>
                                       <div class="row mb-3 col-md-6">
                                           <label class="col-sm-3 col-form-label" for="basic-default-name">Start Month</label>
                                           <div class="col-sm-9">
                                           <select id="start_month" name="start_month" class=" form-select" required="">
                                            @foreach($months as $key=>$month)
                                            <option value="{{$key}}" {{($start_month==$key)?'selected="selected"':''}}>{{$month}}</option>
                                            @endforeach
                                           </select>
                                           </div>
                                       </div>
                                       <div class="row mb-3 col-md-6">
                                           <label class="col-sm-3 col-form-label" for="basic-default-name">Start Year</label>
                                           <div class="col-sm-9">
                                           <select id="start_year" name="start_year" class=" form-select" required="">
                                           @foreach($years as $key=>$year)
                                            <option value="{{$key}}"   {{($start_year==$key)?'selected="selected"':''}}>{{$year}}</option>
                                            @endforeach
                                           </select>
                                           </div>
                                       </div>
                                       <div class="row mb-3 col-md-6">
                                           <label class="col-sm-3 col-form-label" for="basic-default-name">End Month</label>
                                           <div class="col-sm-9">
                                           <select id="end_month" name="end_month" class=" form-select" required="">
                                            @foreach($months as $key=>$month)
                                            <option value="{{$key}}" {{($end_month==$key)?'selected="selected"':''}}>{{$month}}</option>
                                            @endforeach
                                           </select>
                                           </div>
                                       </div>
                                       <div class="row mb-3 col-md-6">
                                           <label class="col-sm-3 col-form-label" for="basic-default-name">End Year</label>
                                           <div class="col-sm-9">
                                           <select id="end_year" name="end_year" class=" form-select" required="">
                                           @foreach($years as $key=>$year)
                                            <option value="{{$key}}" {{($end_year==$key)?'selected="selected"':''}}>{{$year}}</option>
                                            @endforeach
                                           </select>
                                           </div>
                                       </div>
                                       <div class="row mb-3 col-md-6">
                                           <label class="col-sm-3 col-form-label" for="basic-default-name">Payment Status</label>
                                           <div class="col-sm-9">
                                           <select id="status" name="status" class=" form-select" >

                                            <option value="Pending,Failed,Canceled,Invalid" {{($status=='Pending,Failed,Canceled,Invalid')?'selected="selected"':''}}>Unpaid</option>
                                            <option value="Complete" {{($status=='Complete')?'selected="selected"':''}}>Paid</option>

                                           </select>
                                           </div>
                                       </div>









                                       <div class="row mb-3 col-md-2">

                                           <div class="col-sm-12">
                                           <button type="submit" id="submit" class="btn btn-primary form-control me-2">search</button>
                                           </div>
                                       </div>
                                   </div>



                           </form>
               </div>
               @php
                            $month=array("01"=>'January',
                                "02"=>'February',
                                "03"=>'March',
                                "04"=>'April',
                                "05"=>'May',
                                "06"=>'June',
                                "07"=>'July',
                                "08"=>'August',
                                "09"=>'September',
                                "10"=>'October',
                                "11"=>'November',
                                "12"=>'December'
                            );
                            $fee_for=array(
                                        1=>'Admission Fee'
                                        ,2=>'Session Charge'
                                        ,3=>'Tuition Fee'
                                        ,4=>'Exam Fee'
                                        ,5=>'Government Charge'
                                        ,6=>'Board Fee'
                                        ,7=>'Coaching Fee'
                                        ,8=>'Conveyance Fee'
                                        ,9=>'Student Welfare'
                                        ,10=>'EMIS'
                                        ,11=>'MISC'
                                        ,12=>'Fine & Charge'
                                    );
                            @endphp
                            <div class="table-responsive ">
                                <table class="table" id="headerTable">
                                    <thead class="table-dark">
                                    <tr>
                                        <!-- <th>#</th> -->
                                        <th>#</th>
                                        <th>Student Name</th>
                                        <th>Roll</th>
                                        <th>Fee For</th>
                                        <th>Class</th>
                                        <th>Month</th>

                                        <th>Fee Head</th>

                                        <th>Total Amount</th>

                                    </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        @foreach($payments as $key=>$payment)
                                    <tr id="id{{$payment->id}}">
                                        <td >
                                            {{$key+1}}
                                        </td>
                                        <td>{{$payment->first_name??''}}</td>
                                        <td>{{$payment->roll??''}}</td>
                                        <td>
                                            {{$fee_for[$payment->fee_for]}}

                                        </td>

                                        <td>Class {{$payment->class_code??''}}</td>

                                        <td>{{$month[$payment->month]}}</td>
                                        @php
                                        $amountdata=array();


                                            $amountdata= $payment->heads->amount??[];
                                            $heads= $payment->heads->head_id??[];


                                        @endphp
                                        <td>
                                        @if($amountdata)
                                            @foreach($amountdata as $key22=>$value)
                                            {{$fees[$heads[$key22]][0]->head_name??''}}: {{$value}}<br/>
                                            @endforeach
                                        @endif
                                        </td>
                                        <td>{{$payment->amount??''}}</td>

                                    </tr>
                                    @endforeach

                                    </tbody>
                                </table>

                            </div>
       </div>
       <!-- Modal -->
       <div class="modal fade" id="fullscreenModal" tabindex="-1" aria-hidden="true">
         <div class="modal-dialog modal-fullscreen" role="document">
           <div class="modal-content">
             <div class="modal-header">
               <h5 class="modal-title" id="modalFullTitle">Student Payment List</h5>
               <button
                 type="button"
                 class="btn-close"
                 data-bs-dismiss="modal"
                 aria-label="Close"></button>
             </div>
             <div class="modal-body" style="background-color: #f5f2f2">

             </div>
             <!-- <div class="modal-footer">
               <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                 Close
               </button>
               <button type="button" class="btn btn-primary">Save changes</button>
             </div> -->
           </div>
         </div>
       </div>
    </div>
    <!-- / Content -->

    <div class="content-backdrop fade"></div>
 </div>
 <script>
        $(document).ready(function() {
            $('#headerTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
 <script type="text/javascript">
$(function(){
   $(document.body).on('click', '.feeInfo',function(){
      var id=$(this).data('id');
      var href=$(this).data('href');

      var url=href;
      $.LoadingOverlay("show");
               $.ajax({
                   type: "get",
                   url: url,
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
      var shift_id=$('#shift_id').val();
      var class_id=$('#class_id').val();
      var category_id=$('#category_id').val();
         location.href="{{route('fees.create')}}"+'?shift_id='+shift_id+' & month='+month+' & version_id='+version_id+'& class_id='+class_id+'& category_id='+category_id+'& session_id='+session_id;





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
