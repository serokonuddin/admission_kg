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
       <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Student Fee Generate</h4>
       <form id="formAccountSettings" method="POST" action="{{route('employeeSalaryGenerateStore')}}" enctype="multipart/form-data">
            <div class="row">
               <div class="col-md-12">


                     @csrf

                  <div class="card">
                     <div class="card-body">


                        <div class="row">

                              <!-- <div class="mb-3 col-md-4">
                                 <label for="session_id" class="form-label">Session</label>
                                 <select id="session_id" name="session_id" class=" form-select" required="">
                                 <option value="">Select Session</option>
                                 @foreach($sessions as $session)
                                 <option value="{{$session->id}}" {{(isset($activity) && $activity->session_id==$session->id)?'selected="selected"':''}}>{{$session->session_name}}</option>
                                 @endforeach

                                 </select>
                              </div> -->
                              <!-- <div class="mb-3 col-md-4">
                                    <label for="version_id" class="form-label">Version</label>
                                    <select id="version_id" name="version_id" class=" form-select" required="">
                                    <option value="">Select Version</option>
                                    @foreach($versions as $version)
                                    <option value="{{$version->id}}" {{(isset($activity) && $activity->version_id==$version->id)?'selected="selected"':''}}>{{$version->version_name}}</option>
                                    @endforeach

                                    </select>
                              </div> -->

                              <!-- <div class="mb-3 col-md-4">
                                    <label for="shift_id" class="form-label">Shift</label>
                                    <select id="shift_id" name="shift_id" class=" form-select" required="">
                                    <option value="">Select Shift</option>
                                    @foreach($shifts as $shift)
                                    <option value="{{$shift->id}}" {{(isset($activity) && $activity->shift_id==$shift->id)?'selected="selected"':''}}>{{$shift->shift_name}}</option>
                                    @endforeach

                                    </select>
                              </div> -->
                              <!-- <div class="mb-3 col-md-4">
                                 <label for="class_id" class="form-label">Class</label>
                                 <select id="class_id" name="class_id" class=" form-select" required="">
                                 <option value="">Select Class</option>
                                 @foreach($classes as $class)
                                 <option value="{{$class->id}}" {{(isset($activity) && $activity->class_id==$class->id)?'selected="selected"':''}}>{{$class->class_name}}</option>
                                 @endforeach

                                 </select>
                              </div> -->
                              <!-- <div class="mb-3 col-md-4">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select id="category_id" name="category_id" class=" form-select" required="">
                                    <option value="">Select Category</option>

                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{(isset($activity) && $activity->category_id==$category->category_id)?'selected="selected"':''}}>{{$category->category_name}}</option>
                                    @endforeach
                                    </select>
                              </div> -->
                              <div class="mb-3 col-md-4">
                                    <label for="category_id" class="form-label">Month</label>
                                    <select id="month" name="month" class=" form-select" >
                                                    <option value="">Select Month</option>
                                                    @foreach($months as $key=>$monthvalue)
                                                    <option value="{{$key}}" {{($month==$key)?'selected="selected"':''}}>{{$monthvalue}}</option>
                                                    @endforeach

                                    </select>
                              </div>
                              <div class="mb-3 col-md-4">

                                    <button type="submit" class="btn btn-primary me-2 " style="margin-top: 30px;">Generate</button>
                              </div>
                            </div>
                            <!-- <div class="row" style="margin-bottom: 10px;">
                            <small class="text-light fw-medium d-block">Fee Head</small>

                               @foreach($fees as $fee)
                               <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                        <input class="form-check-input mt-0" name="head_id[]" type="checkbox" value="{{$fee->id}}" aria-label="Checkbox for following text input">
                                        {{$fee->head_name}}
                                        </div>
                                        <input type="number" class="form-control" name="amount{{$fee->id}}" value="" placeholder="Amount" aria-label="Text input with checkbox">
                                    </div>
                                </div>
                                @endforeach



                            </div> -->




                     </div>
                  </div>
               </div>
            </div>
      </form>
    </div>
    <!-- / Content -->

    <div class="content-backdrop fade"></div>
 </div>
 <script src="{{asset('vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
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

   $('#lfm').filemanager('image');
   $('#lfm1').filemanager('image');
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
