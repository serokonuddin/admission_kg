@extends('admin.layouts.layout')
@section('content')
<style>
   @media only screen and (min-width:600px) {
    #attendance-part .nav-item{
        width: 23%;
        padding: 3px;

    }
   }
   @media only screen and (max-width:600px) {
      #attendance-part .nav-item{
        width: 98%;
        padding: 2%;

    }
   }
   #attendance-part  .nav-pills .nav-link,#attendance-part  .nav-pills .nav-link,#attendance-part  .nav-pills .nav-link {
        background-color: white;
        color: #000;
        box-shadow: 0 2px 4px 0 rgba(233, 233, 248, 0.4);
    }
    #attendance-part  .nav-pills .nav-link.active,#attendance-part  .nav-pills .nav-link.active,#attendance-part  .nav-pills .nav-link.active{
        background-color: #3d70a6;
        color: #fff;
        box-shadow: 0 2px 4px 0 rgba(233, 233, 248, 0.4);
    }
    #attendance-part .demo-inline-spacing > * {
         margin: 1.8rem 0.375rem 0 0 !important;
      }
      .avatar img{
        width: 40px;
        height: 40px;
      }
      table th{
        background-color: #3d70a6!important;
        color: white!important;
      }
      .table>:not(caption)>*>* {
        padding: 0.025rem 1.25rem!important;
      }
      .present{
        color: rgb(13, 70, 163);
        font-weight: bold

      }
      .absent{
        color: rgb(191, 5, 5);
        font-weight: bold

      }
      .leave{
        color: rgb(5, 191, 11);
        font-weight: bold

      }
      .fixTableHead {
        overflow-y: auto;
        height: 90vh;
        }
        .fixTableHead thead th {
        position: sticky;
        top: 0;
        }
        table {
        border-collapse: collapse;
        width: 100%;
        }
</style>
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/flatpickr/flatpickr.css" />
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y" id="attendance-part">
       <h4 class="py-3 mb-4"><span class="text-muted fw-light">Attendance /</span> Teacher</h4>
       <div class="row">
          <div class="col-md-12">
             @if(Auth::user()->getMenu('teacherAttendanceStore','name'))
            <form class="needs-validation" method="post" action="{{route('teacherAttendanceStore')}}"  novalidate="" id="formsubmit">
              @csrf
              @else
              <form class="needs-validation" method="post" action="#"  novalidate="" id="formsubmit">
              @endif


            <input type="hidden" id="type" name="type" value="{{$type_name}}">
             <ul class="nav nav-pills flex-column flex-md-row mb-3" >
                <li class="nav-item type college"  data-type="college">
                   <a class="nav-link {{($type==3 || $type=='')?'active':''}}" href="javascript:void(0);"><img src="{{asset('public/image/college.png')}}"> College</a>
                </li>
                <li class="nav-item secondary type" data-type="secondary">
                   <a class="nav-link {{($type==2)?'active':''}}" href="javascript:void(0);"><img src="{{asset('public/image/secondary.png')}}"> Secondary</a>
                <li class="nav-item primary type" data-type="primary">
                   <a class="nav-link {{($type==1)?'active':''}}" href="javascript:void(0);"><img src="{{asset('public/image/primary.png')}}"> Primary</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link university" href="javascript:void(0);"><img src="{{asset('public/image/university.png')}}"> English</a>
                 </li> --}}
                 <li class="nav-item ">
                    <a class="nav-link datacync" href="javascript:void(0);"><img src="{{asset('public/image/sync.png')}}"> Data Sync</a>
                </li>
             </ul>
             <div class="card mb-4">
                <div class="card-body">
                  <div class="row gy-3">

                    <div class="col-md">

                      <div class="form-check form-check-inline mt-3">
                        <input class="form-check-input" type="radio" checked="checked" name="version_id" {{(Session::get('version_id_t')==1)?'checked="checked"':''}} id="bangla" value="1">
                        <label class="form-check-label" for="bangla">Bangla</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="version_id" id="english" {{(Session::get('version_id_t')==2)?'checked="checked"':''}} value="2">
                        <label class="form-check-label" for="english">English</label>
                      </div>

                      <div class="form-check form-check-inline">
                        <input type="text" class="form-control flatpickr-validation flatpickr-input active" id="attendance_date" name="attendance_date" value="{{(Session::get('attendance_date_t'))?Session::get('attendance_date_t'):date('Y-m-d')}}" placeholder="Attendance Date" required>
                      </div>
                      <div class="form-check form-check-inline mt-3">
                        <input class="form-check-input" type="radio" checked="checked" name="shift_id" id="Morning" {{(Session::get('shift_id_t')==1)?'checked="checked"':''}} value="1">
                        <label class="form-check-label" for="Morning">Morning</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="shift_id" id="Day" {{(Session::get('shift_id_t')==2)?'checked="checked"':''}} value="2">
                        <label class="form-check-label" for="Day">Day</label>
                      </div>

                    </div>
                  </div>
                </div>
                <div class="card-body">
                   <form id="formAccountSettings" method="POST" onsubmit="return false">
                      <div class="row">
                        <div class="mb-2 col-md-3">
                          <label class="form-label" for="session_id">Year</label>
                          <select id="session_id" name="session_id" class=" form-select" required>
                             <option value="">Select Year</option>
                             @foreach($sessions as $key=>$session)
                             <option value="{{$session->id}}" {{(Session::get('session_id_t')==$session->id)?'selected="selected"':''}}>{{$session->session_name}}</option>
                             @endforeach

                          </select>
                        </div>
                        {{-- <div class="mb-2 col-md-2">
                           <label class="form-label" for="country">Shift</label>
                           <select id="shift_id" class=" form-select">
                              <option value="">Select Shift</option>
                              @foreach($shifts as $key=>$shift)
                              <option value="{{$shift->id}}">{{$shift->shift_name}}</option>
                              @endforeach

                           </select>
                        </div> --}}
                        <div class="mb-2 col-md-3">
                           <label class="form-label" for="country">Class</label>
                           <select id="class_id" name="class_id" class=" form-select" required>
                              <option value="">Select Class</option>
                              @foreach($classess as $key=>$class)
                              <option value="{{$class->class_code}}" {{(Session::get('class_id_t')==$class->id)?'selected="selected"':''}}>{{$class->class_name}}</option>
                              @endforeach

                           </select>
                        </div>
                        <div class="mb-2 col-md-3">
                           <label class="form-label" for="section">Section</label>
                           <select id="section_id" name="section_id" class=" form-select">
                            <option value="">Select Section</option>
                            @foreach($sections as $key=>$section)
                            <option value="{{$section->id}}" {{(Session::get('section_id_t')==$section->id)?'selected="selected"':''}}>{{$section->section_name}}</option>
                            @endforeach

                           </select>
                        </div>
                        {{-- <div class="mb-4 col-md-3">
                           <div class="demo-inline-spacing searchstudent">

                              <button type="button" class="btn rounded-pill btn-outline-primary">
                              <span class="bx bx-search bx-sm"></span>Search
                              </button>

                           </div>
                         </div> --}}

                      </div>

                   </form>
                </div>
                <!-- /Account -->
                <div class="table-responsive fixTableHead" id="teacherlist">

                </div>
                <div class="mb-3 col-md-3">
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-primary">Submit</button>
                </div>
             </div>
            </form>
          </div>
       </div>
    </div>
    <!-- / Content -->

    <div class="content-backdrop fade"></div>
 </div>

<script>
  @if(Session::get('section_id_t'))
  $(function(){
    showstudent();
  });
  @endif
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
  function makeAlert(){

  };


   $(function() {
      $(document.body).on('click','.type',function() {
        var type=$(this).data('type');

        $('#type').val(type);
        var shift_id=$('input[name="shift_id"]:checked').val();
         var version_id=$('input[name="version_id"]:checked').val();
        $.LoadingOverlay("show");
        var id=$(this).val();
            var url="{{route('getTypeWiseClass')}}";
            $.ajax({
                type: "post",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: url,
                data:{"_token": "{{ csrf_token() }}",type:type,shift_id,version_id},
                success: function(response){

                        $('#class_id').html(response)
                        $('#teacherlist').html('');
                        $.LoadingOverlay("hide");

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
        $('.type'+' a').removeClass('active');
        $('.'+type+' a').addClass('active');
      });


      $(document.body).on('change','input[type=radio][name=version_id]',function() {


        var type=$('#type').val();
        var shift_id=$('input[name="shift_id"]:checked').val();
         var version_id=$('input[name="version_id"]:checked').val();
        $.LoadingOverlay("show");
        var id=$(this).val();
            var url="{{route('getTypeWiseClass')}}";
            $.ajax({
                type: "post",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: url,
                data:{"_token": "{{ csrf_token() }}",type:type,shift_id,version_id},
                success: function(response){

                        $('#class_id').html(response)
                        $.LoadingOverlay("hide");

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
        $('.type'+' a').removeClass('active');
        $('.'+type+' a').addClass('active');
      });

      $(document.body).on('change','input[type=radio][name=shift_id]',function() {


        var type=$('#type').val();
        var shift_id=$('input[name="shift_id"]:checked').val();
         var version_id=$('input[name="version_id"]:checked').val();
        $.LoadingOverlay("show");
        var id=$(this).val();
            var url="{{route('getTypeWiseClass')}}";
            $.ajax({
                type: "post",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: url,
                data:{"_token": "{{ csrf_token() }}",type:type,shift_id,version_id},
                success: function(response){

                        $('#class_id').html(response);
                        $('#teacherlist').html('');
                        $.LoadingOverlay("hide");

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
        $('.type'+' a').removeClass('active');
        $('.'+type+' a').addClass('active');
      });

      $(document.body).on('change','input[type=checkbox][name=all]',function() {

        if($('#all').is(':checked')){

          $('table .form-check-input.Present').each(function(){
              console.log(2);
              $(this).prop('checked',true);

          });
        }else{

          $('table .form-check-input').each(function(){

              $(this).prop('checked',false);

          });
        }

      });
      $(document.body).on('click','.datacync',function() {
        $.LoadingOverlay("show");
        setTimeout(
        function()
        {
          $.LoadingOverlay("hide");
          Swal.fire({
                            title: "Good job!",
                            text: "Successfully Import Student Attendance",
                            icon: "success"
                        });

        }, 1000);


      });
      $(document.body).on('change','#class_id',function() {
         var id=$(this).val();
         var shift_id=$('input[name="shift_id"]:checked').val();
         var version_id=$('input[name="version_id"]:checked').val();
            var url="{{route('class-wise-sections')}}";
            $.LoadingOverlay("show");
            $.ajax({
                type: "post",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: url,
                data:{"_token": "{{ csrf_token() }}",class_id:id,shift_id,version_id},
                success: function(response){
                  $.LoadingOverlay("hide");
                        $('#section_id').html(response);
                        $('#teacherlist').html('');

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
      $(document.body).on('change','#section_id',function() {

         var attendance_date=$('#attendance_date').val();
         var class_id=$('#class_id').val();
         var session_id=$('#session_id').val();
         var shift_id=$('input[name="shift_id"]:checked').val();
         var version_id=$('input[name="version_id"]:checked').val();
         $.LoadingOverlay("show");
         var section_id=$('#section_id').val();
         if(section_id && attendance_date && version_id && shift_id && session_id && class_id){
            var url="{{route('getTeachers')}}";
            $.ajax({
                type: "get",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: url,
                data:{"_token": "{{ csrf_token() }}",session_id,shift_id,class_id,section_id,version_id,attendance_date},
                success: function(response){
                  $.LoadingOverlay("hide");
                        $('#teacherlist').html(response)


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
          }else{
              $('#teacherlist').html('')
          }
          $.LoadingOverlay("hide");
      });
      $(document.body).on('change','#attendance_date',function() {

        var attendance_date=$('#attendance_date').val();
        var class_id=$('#class_id').val();
        var session_id=$('#session_id').val();
        var shift_id=$('input[name="shift_id"]:checked').val();
        var version_id=$('input[name="version_id"]:checked').val();
        $.LoadingOverlay("show");
        var section_id=$('#section_id').val();
        if(section_id && attendance_date && version_id && shift_id && session_id && class_id){


           var url="{{route('getTeachers')}}";
           $.ajax({
               type: "get",
               headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
               url: url,
               data:{"_token": "{{ csrf_token() }}",session_id,shift_id,class_id,section_id,version_id,attendance_date},
               success: function(response){
                 $.LoadingOverlay("hide");
                       $('#teacherlist').html(response)


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
        }else{
            $('#teacherlist').html('')
        }
        $.LoadingOverlay("hide");
     });
   });
   function showstudent(){
         var attendance_date=$('#attendance_date').val();
         var class_id=$('#class_id').val();
         var session_id=$('#session_id').val();
         var shift_id=$('input[name="shift_id"]:checked').val();
         var version_id=$('input[name="version_id"]:checked').val();
         $.LoadingOverlay("show");
         var section_id=$('#section_id').val();
         if(section_id && attendance_date && version_id && shift_id && session_id && class_id){
            var url="{{route('getTeachers')}}";
            $.ajax({
                type: "get",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: url,
                data:{"_token": "{{ csrf_token() }}",session_id,shift_id,class_id,section_id,version_id,attendance_date},
                success: function(response){
                  $.LoadingOverlay("hide");
                        $('#teacherlist').html(response)


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
          }else{
            $('#teacherlist').html('')
          }
          $.LoadingOverlay("hdie");
   }
</script>
@endsection
