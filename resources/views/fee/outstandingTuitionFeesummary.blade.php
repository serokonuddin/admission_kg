@extends('admin.layouts.layout')
@section('content')

<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/jquery-timepicker/jquery-timepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/pickr/pickr-themes.css" />
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
       <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Outstanding Tuition Fee Summary</h4>

            <div class="row">
               <div class="col-md-12">


                  <div class="card">
                     <div class="card-body">

                     <form id="formAccountSettings" method="POST" action="{{route('outstandingTuitionFeeSummary')}}" enctype="multipart/form-data">

                            @csrf
                        <div class="row">




                              <div class="mb-3 col-md-6">
                                    <label for="version_id" class="form-label">Version</label>
                                    <select id="version_id" name="version_id" class=" form-select" required="">
                                    <option value="">Select Version</option>
                                    @foreach($versions as $version)
                                    <option value="{{$version->id}}" {{($version_id==$version->id)?'selected="selected"':''}}>{{$version->version_name}}</option>
                                    @endforeach

                                    </select>
                              </div>



                              <div class="mb-3 col-md-6">
                                 <label for="class_id" class="form-label">Class</label>
                                 <select id="class_id" name="class_id" class=" form-select" required="">
                                 <option value="" {{($class_id==null)?'selected="selected"':''}}>Select Class</option>
                                 <option value="0" {{($class_id==0 && $class_id!=null)?'selected="selected"':''}}>KG</option>
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


                              <div class="mb-3  col-md-6">
                                    <label class="form-label" for="amount">Start Date<span style="color:red">*</span></label>
                                    <input type="date" id="start_date" name="start_date" value="{{$start_date}}" class="form-control" placeholder="Start Date">
                                </div>
                                <div class="mb-3  col-md-6">
                                    <label class="form-label" for="amount">End Date<span style="color:red">*</span></label>
                                    <input type="date" id="end_date" name="end_date" value="{{$end_date}}"  class="form-control" placeholder="End Date">
                                </div>

                                <div class="mb-3  col-md-2">
                                            <label class="form-label" for="amount"> </label>
                                            <button type="button" id="searchtop" class="btn btn-primary form-control me-2 mt-1">Search</button>
                                </div>

                            </div>


                        </form>


                            <small class="text-light fw-medium d-block">Outstandine Tuition Fee Summary</small>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <!-- <div class="dataTables_length" id="DataTables_Table_0_length">
                                        <label>
                                            Show
                                            <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="form-select">
                                            <option value="7">7</option>
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="75">75</option>
                                            <option value="100">100</option>
                                            </select>
                                            entries
                                        </label>
                                    </div> -->
                                </div>
                                <div class="col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end mt-n6 mt-md-0">
                                    <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>Search:<input type="text" id="search" class="form-control" value="{{ request('search') }}" placeholder="Search..." aria-controls="DataTables_Table_0"></label></div>
                                </div>

                            <div class="table-responsive " id="item-list">
                                <table class="table">
                                    <thead class="table-dark">
                                    <tr>
                                        <!-- <th>#</th> -->
                                        <th>#</th>
                                        <th>Student Code</th>
                                        <th>Student Name</th>
                                        <th>Version</th>
                                        <th>Shift</th>
                                        <th>Section</th>
                                        <th>Class</th>
                                        <th>Category</th>
                                        <th>Payment Date</th>
                                        <th>Head Name</th>
                                        <th>Amount</th>

                                    </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                    @foreach($students as $key=>$student)
                   <tr id="row{{$student->id}}">
                      <!-- <td class="control">
                      </td> -->
                      <td>
                        {{$key+1}}
                        </td>
                        <td>
                            {{$student->student_code??''}}
                        </td>

                        <td
                        data-bs-toggle="#modal"
                        data-bs-target="#fullscreenModal"
                        class="studentinfo" data-studentcode="{{$student->student_code}}"> <img src="{{$student->photo??asset('public/student.png')}}" alt="Avatar" class="rounded-circle avatar avatar-xs">
                        {{$student->first_name.' '.$student->last_name}}
                        </td>

                        <td>{{$student->version->version_name??''}}</td>
                        <td>{{$student->shift->shift_name??''}}</td>
                        <td>{{$student->classes->class_name??''}}</td>
                        <td>{{$student->section->section_name??''}}</td>
                        <td>{{$student->category->category_name??''}}</td>
                        @php
                            if($student->fee_for==1){
                                $text="Tuition Fee";
                            }elseif($student->fee_for==2){
                                $text="Session Fee";
                            }elseif($student->is_admission==1){
                                $text="Admission Fee";
                            }else{
                                $text=$student->headdata->head_name??'';
                            }
                        @endphp
                        <td>
                           {{date('d-m-Y',strtotime($student->updated_at))}}
                        </td>
                        <td>{{$text}}</td>
                        <td>{{$student->amount??''}}</td>

                    </tr>
                    @endforeach
                                    </tbody>
                                </table>
                                <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_3_paginate" style="padding: 10px">
                                    <!-- {{$students->links('pagination')}} -->

                                    {!! $students->appends([
                    'search' => request('search')
                    ,'start_date' => request('start_date')
                    ,'end_date' => request('end_date')
                    ,'version_id' => request('version_id')
                    ,'class_id' => request('class_id')
                    ])->links('bootstrap-4') !!}
                                    </div>
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
    $(function(){
        $(document.body).on('click', '#searchtop',function(){
            var version_id=$('#version_id').val();
            var class_id=$('#class_id').val();
                location.href="{{route('outstandingTuitionFeeSummary')}}"+'?version_id='+version_id+'& class_id='+class_id;





        });

        $('#search').on('change', function() {

                fetch_data(1); // Start from the first page when searching
        });
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];

            fetch_data(page);
        });
    });
    var url="{{route('outstandingTuitionFeeSummary')}}";

    function fetch_data(page) {
        $.LoadingOverlay("show");
            var searchQuery = $('#search').val();
            var version_id=$('#version_id').val();
            var class_id=$('#class_id').val();
            var searchtext=' & version_id='+version_id+'& class_id='+class_id+'& search='+searchQuery;
            url="{{route('outstandingTuitionFeeSummary')}}";
            $.ajax({
                url: url+"?page=" + page + searchtext,
                success: function(data) {

                    $('#item-list').html(data);
                    window.history.pushState("", "", '?page=' + page + searchtext);
                    $.LoadingOverlay("hide");
                }
            });
        }
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
        var category_id=$('#category_id').val();
        var effective_from=$('#effective_from').val();

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
        // if(category_id==''){
        //     Swal.fire({
        //                 title: "Warging",
        //                 text: "Please Select Category",
        //                 icon: "warning"
        //             });
        //             return false;
        // }
        if(effective_from==''){
            Swal.fire({
                        title: "Warging",
                        text: "Please Select effective from",
                        icon: "warning"
                    });
                    return false;
        }

        $.LoadingOverlay("show");
        var url="{{route('getCategoryWiseHeadFeeExport')}}";


        var feefor=$('#fee_for option:selected').text();
        var session=$('#session_id option:selected').text();
        var version=$('#version_id option:selected').text();
        var classes=$('#class_id option:selected').text();
        var category=$('#category_id option:selected').text();



        $.ajax({
                type: "post",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: url,
                data:{"_token": "{{ csrf_token() }}",effective_from,fee_for,session_id,version_id,class_code,category_id,feefor,session,version,classes,category},
                xhrFields: {
                    responseType: 'blob' // Important for handling binary data
                },
                success: function(data, status, xhr) {
                    // Create a new Blob object using the response data
                    var blob = new Blob([data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });

                    // Create a link element
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = 'CategoryWiseHeadFeeExport.xlsx'; // The name of the downloaded file

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
