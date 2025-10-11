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
<style>
    .input-group{
        margin-top: 10px;
    }
    .input-group-text{
        width: 210px;
    }
</style>
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
       <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Government Charge</h4>

            <div class="row">
               <div class="col-md-12">


                  <div class="card">
                     <div class="card-body">

                     <form id="formAccountSettings" method="POST" action="{{route('governmentCharge.store')}}" enctype="multipart/form-data">
                        <input type="hidden" value="0" name="id" id="id" />
                        <input type="hidden" value="5" name="fee_for" id="fee_for" />
                        <input type="hidden" value="Government Charge" name="feefor" id="feefor" />
                            @csrf
                            <div class="row">
                                    <div class="row mb-3 col-md-4">
                                        <label class="col-sm-5 col-form-label" for="basic-default-name">Session</label>
                                        <div class="col-sm-7">
                                        <select id="session_id" name="session_id" class=" form-select" required="">
                                            <option value="{{$sessions->id}}" {{(isset($categoryhead) && $categoryhead->session_id==$sessions->id)?'selected="selected"':''}}>{{$sessions->session_name}}</option>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3 col-md-4">
                                        <label class="col-sm-5 col-form-label" for="basic-default-name">Version</label>
                                        <div class="col-sm-7">
                                        <select id="version_id" name="version_id" class=" form-select" required="">
                                        <option value="">Select Version</option>
                                        @foreach($versions as $version)
                                        <option value="{{$version->id}}" {{(isset($categoryhead) && $categoryhead->version_id==$version->id)?'selected="selected"':''}}>{{$version->version_name}}</option>
                                        @endforeach

                                        </select>
                                        </div>
                                    </div>




                                @php
                                    $class_id=(isset($categoryhead) && $categoryhead->class_code)?$syllabus->class_code:null;
                                    @endphp
                                    <div class="row mb-3 col-md-4">
                                        <label class="col-sm-5 col-form-label" for="basic-default-name">Class</label>
                                        <div class="col-sm-7">
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
                                    <div class="row mb-3 col-md-4">
                                        <label class="col-sm-5 col-form-label" for="basic-default-name">Gender</label>
                                        <div class="col-sm-7">
                                        <select id="gender" name="gender" class=" form-select" required="">
                                        <option value="">Select Gender</option>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3 col-md-4">
                                        <label class="col-sm-5 col-form-label" for="basic-default-name">Month</label>
                                        <div class="col-sm-7">
                                        <select id="month" name="month" class=" form-select">
                                            <option value="01" {{(isset($categoryhead) && $categoryhead->month=='01')?'selected="selected"':''}}>January</option>
                                            <option value="02" {{(isset($categoryhead) && $categoryhead->month=='02')?'selected="selected"':''}}>February</option>
                                            <option value="03" {{(isset($categoryhead) && $categoryhead->month=='03')?'selected="selected"':''}}>March</option>
                                            <option value="04" {{(isset($categoryhead) && $categoryhead->month=='04')?'selected="selected"':''}}>April</option>
                                            <option value="05" {{(isset($categoryhead) && $categoryhead->month=='05')?'selected="selected"':''}}>May</option>
                                            <option value="06" {{(isset($categoryhead) && $categoryhead->month=='06')?'selected="selected"':''}}>June</option>
                                            <option value="07" {{(isset($categoryhead) && $categoryhead->month=='07')?'selected="selected"':''}}>July</option>
                                            <option value="08" {{(isset($categoryhead) && $categoryhead->month=='08')?'selected="selected"':''}}>August</option>
                                            <option value="09" {{(isset($categoryhead) && $categoryhead->month=='09')?'selected="selected"':''}}>September</option>
                                            <option value="10" {{(isset($categoryhead) && $categoryhead->month=='10')?'selected="selected"':''}}>October</option>
                                            <option value="11" {{(isset($categoryhead) && $categoryhead->month=='11')?'selected="selected"':''}} >November</option>
                                            <option value="12" {{(isset($categoryhead) && $categoryhead->month=='12')?'selected="selected"':''}}>December</option>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                @foreach($fees as $fee)
                                <input type="hidden" value="{{$fee->id}}" name="head_id[]"  />
                                <div class="row mb-3 col-md-4">
                                <label class="col-sm-5 col-form-label" for="basic-default-name">{{$fee->head_name}}</label>
                                <div class="col-sm-7">
                                <input type="text" id="amount{{$fee->id}}" name="amount{{$fee->id}}" class="form-control" placeholder="{{$fee->head_name}} amount">
                                </div>
                                </div>
                                @endforeach

                                <div class="row mb-3 col-md-4">

                                <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary form-control me-2 mt-1">Save</button>
                                </div>
                                </div>
                                <div class="mb-3  col-md-2">
                                            <label class="form-label" for="amount"> </label>

                                </div>

                            </div>


                        </form>
                        <form action="{{ route('ClassCategoryWiseHeadFeeImport') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <h4>Xl Upload From</h4>
                                <div class="mb-3  col-md-4">
                                    <label class="form-label" for="amount">Xl File </label>
                                    <input type="file" id="file" name="file" class="form-control " placeholder="Importxl">
                                </div>
                                <div class="mb-3  col-md-2">
                                            <label class="form-label" for="amount"> </label>
                                        <button type="submit" class="btn btn-info me-2 mt-1 form-control uploadxl">Upload</button>
                                </div>
                                <div class="mb-3  col-md-3">
                                            <label class="form-label" for="amount"> </label>
                                        <button type="button" class="btn btn-success me-2 mt-1 form-control downloadxl">Download Sample XL &nbsp;<i class="fa fa-download"></i></button>
                                </div>

                        </div>
                        </form>
                        <div class="row" style="margin-bottom: 10px;margin-top: 20px;">
                            <small class="text-light fw-medium d-block">Government Charge</small>
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
                                $gender=array('1'=>"Male",2=>"Female");
                            @endphp
                            <div class="table-responsive ">
                                <table class="table" id="headerTable">
                                    <thead class="table-dark">
                                    <tr>
                                        <!-- <th>#</th> -->
                                        <th>#</th>
                                        <th>Fee For</th>
                                        <th>Session</th>
                                        <th>Version</th>
                                        <th>Class</th>
                                        <th>Gender</th>
                                        <th>Head Name</th>
                                        <th>Month</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        @foreach($payments as $key=>$payment)
                                    <tr id="id{{$payment->id}}">
                                        <td >
                                            {{$key+1}}
                                        </td>
                                        <td>
                                            {{$fee_for[$payment->fee_for]}}

                                        </td>


                                        <td>{{$payment->session->session_name??''}}</td>
                                        <td>{{$payment->version->version_name??''}}</td>
                                        <td>Class {{$payment->class_code??''}}</td>
                                        <td>{{$gender[$payment->gender]??''}}</td>
                                        <td>{{$payment->head->head_name??''}}</td>
                                        <td>{{$month[$payment->month]}}</td>
                                        <td>{{$payment->amount??''}}</td>
                                        <td >
                                        <div class="dropdown">
                                            <button gallery="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>
                                            <div class="dropdown-menu" style="">
                                                <a class="dropdown-item edit"

                                                data-id="{{$payment->id}}"
                                                data-fee_for="{{$payment->fee_for}}"
                                                data-session_id="{{$payment->session_id}}"
                                                data-version_id="{{$payment->version_id}}"
                                                data-shift_id="{{$payment->shift_id}}"
                                                data-class_id="{{$payment->class_id}}"
                                                data-gender="{{$payment->gender}}"
                                                data-head_id="{{$payment->head_id}}"
                                                data-amount="{{$payment->amount}}"
                                                data-month="{{$payment->month}}"
                                                ><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                                <a class="dropdown-item delete"  data-url="{{url('admin/categorywiseheaddelete/'. $payment->id)}}" data-id="{{$payment->id}}"  href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
                                            </div>
                                        </div>
                                        </td>
                                    </tr>
                                    @endforeach

                                    </tbody>
                                </table>

                            </div>



                            </div>
                     </div>
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
<script>
   @if($errors->any())

    Swal.fire({
        title: "Error",
        text: "{{ implode(',', $errors->all(':message')) }}",
        icon: "warning"
    });
@endif
@if(Session::get('success'))

    Swal.fire({
        title: "Good job!",
        text: "{{Session::get('success')}}",
        icon: "success"
    });
@endif

@if(Session::get('error'))

    Swal.fire({
        title: "Error",
        text: "{{Session::get('error')}}",
        icon: "warning"
    });
@endif
$(function() {


      $(document.body).on('click','.downloadxl',function() {
        var fee_for=$('#fee_for').val();
        var session_id=$('#session_id').val();
        var version_id=$('#version_id').val();
        var class_code=$('#class_id').val();
        var month=$('#month').val();
        var gender=$('#gender').val();
        var effective_from=null;

        if(fee_for==''){
            Swal.fire({
                        title: "Warging",
                        text: "Please Select Fee For",
                        icon: "warning"
                    });
                    return false;
        }
        if(session_id==''){
            Swal.fire({
                        title: "Warging",
                        text: "Please Select Session",
                        icon: "warning"
                    });
                    return false;
        }
        if(version_id==''){
            Swal.fire({
                        title: "Warging",
                        text: "Please Select Version",
                        icon: "warning"
                    });
                    return false;
        }
        if(class_code==''){
            Swal.fire({
                        title: "Warging",
                        text: "Please Select Class",
                        icon: "warning"
                    });
                    return false;
        }

        if(month==''){
            Swal.fire({
                        title: "Warging",
                        text: "Please Select effective from",
                        icon: "warning"
                    });
                    return false;
        }
        if(gender==''){
            Swal.fire({
                        title: "Warging",
                        text: "Please Select Gender",
                        icon: "warning"
                    });
                    return false;
        }

        $.LoadingOverlay("show");
        var url="{{route('getCategoryWiseHeadFeeExport')}}";

        var category_id=null;
        var feefor=$('#feefor').val();
        var session=$('#session_id option:selected').text();
        var version=$('#version_id option:selected').text();
        var classes=$('#class_id option:selected').text();
        var category=null;



        $.ajax({
                type: "post",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: url,
                data:{"_token": "{{ csrf_token() }}",month,effective_from,fee_for,session_id,version_id,class_code,category_id,gender,feefor,session,version,classes,category,'xltext':'governmentcharge'},
                xhrFields: {
                    responseType: 'blob' // Important for handling binary data
                },
                success: function(data, status, xhr) {
                    // Create a new Blob object using the response data
                    var blob = new Blob([data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });

                    // Create a link element
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = 'governmentcharge.xlsx'; // The name of the downloaded file

                    // Append to the document
                    document.body.appendChild(link);

                    // Simulate a click on the link
                    link.click();

                    // Remove the link from the document
                    document.body.removeChild(link);
                    $.LoadingOverlay("hide");
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

<script>



    $(function(){
        $(document.body).on('click','.edit',function(){
            var id=$(this).data('id');
            var fee_for=$(this).data('fee_for');
            var session_id=$(this).data('session_id');
            var version_id=$(this).data('version_id');
            var shift_id=$(this).data('shift_id');
            var class_id=$(this).data('class_id');
            var category_id=$(this).data('category_id');
            var head_id=$(this).data('head_id');
            var amount=$(this).data('amount');
            $('#id').val(id);
            $('#fee_for').val(fee_for);
            $('#session_id').val(session_id);
            $('#version_id').val(version_id);
            $('#shift_id').val(shift_id);
            $('#class_id').val(class_id);
            $('#category_id').val(category_id);
            $('#head_id').val(head_id);
            $('#amount').val(amount);
            $('#submit').text('Update');
        });


        $(document.body).on('click','.delete',function(){
            var id=$(this).data('id');
            var url=$(this).data('url');
            $.ajax({

                url: url,
                data:{"_token": "{{ csrf_token() }}"},
                success: function(response){
                    if(response==1){
                        Swal.fire({
                            title: "Good job!",
                            text: "Deleted successfully",
                            icon: "success"
                        });
                        $('#id'+id).remove();
                    }else{
                        Swal.fire({
                            title: "Error!",
                            text: response,
                            icon: "warning"
                        });
                    }

                },
                error: function(data, errorThrown)
                {
                    Swal.fire({
                        title: "Error",
                        text: errorThrown,
                        icon: "warning"
                    });

                }
            });
        });

    });
</script>
@endsection
