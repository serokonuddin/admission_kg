@extends('admin.layouts.layout')
@section('content')
<style>
    .student,.teacher{
        display: none;
    }
	.admissionsendsms{
	float: right
	}
</style>
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/jquery-timepicker/jquery-timepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/pickr/pickr-themes.css" />
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
       <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> SMS Send</h4>
       <form id="formAccountSettings" method="POST" action="{{route('sendData')}}" enctype="multipart/form-data">
            <div class="row">
               <div class="col-md-12">

                  <div class="card mb-4">

                     <!-- Account -->
                     @csrf
                  </div>
                  <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                              <div class="mb-3 col-md-4 ">

                                <select id="role_id" name="role_id" class=" form-select">
                                    <option value="">Select Role</option>
                                    @foreach($roles as $role)
                                    <option value="{{$role->id}}" >{{$role->name}}</option>
                                    @endforeach

                                    </select>
                              </div>

                              <div class="mb-3 col-md-4">
                                 <input class="form-control" type="text" name="name" id="name"  placeholder="Search By Name,mobile,empid,email" >
                              </div>
                        </div>
                    </div>
                  </div>

               </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                   <div class="card mb-4">
                        <div class="card-body">
                           <div class="row gy-3">
                              <div class="col-md">
                                    <div class="table-responsive fixTableHead">
                                       <table class="table ">
                                            <thead class="table-info ">
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Name</th>
                                                    <th>Username</th>
                                                    <th>Mobile</th>

                                                </tr>
                                            </thead>
                                            <tbody id="smsdata">

                                            </tbody>
                                        </table>
                                        <button type="submit" class="btn btn-primary me-2 mt-4">SEND</button>
                                    </div>
                               </div>
                            </div>
                        </div>
                   </div>
                </div>

            </div>
      </form>
    </div>
    <!-- / Content -->

    <div class="content-backdrop fade"></div>
 </div>
 <script src="{{asset('public/vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
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
function countChar(val) {
  var len = val.value.length;
  var lang =$("input[name='lang']:checked").val();
  if(lang==1){
    len=len*2;
  }
    $('#charNum').text(len);
    $('#numberofchar').val(len);

}

$(function() {
    $("#unicode-input").keypress(function(event){
      var lang =$("input[name='lang']:checked").val();
      var charCode = event.which;

      var allowchar=[44,63,33,47,45,95,35,64,34,39,40,41,43,126,94,60,62,61,42]
      // Check if the character is a valid Unicode character
      if(lang==1){
        if (charCode >= 32 && charCode <= 126) {
            // Allow basic ASCII characters
            return false;
        } else if ($.inArray(charCode,allowchar)) {
            return true;
        } else if (charCode > 126) {
            // Allow other Unicode characters
            return true;
        } else {
            // Prevent any other input
            return false;
        }
      }else{
        if (charCode >= 32 && charCode <= 126) {
            // Allow basic ASCII characters
            return true;
        }else if (charCode > 126) {
            // Allow other Unicode characters
            return false;
        } else {
            // Prevent any other input
            return false;
        }
      }

    });
   $('#lfm').filemanager('image');
   $('#lfm1').filemanager('image');
      $(document.body).on('change',"input[name='lang']:checked",function() {
        $('#unicode-input').val('');
        $('#charNum').text(0);
        $('#numberofchar').val(0);
      });
      $(document.body).on('change',"input[name='sms_for']:checked",function() {
        var sms_for=$(this).val();
        if(sms_for==1){
            $('.teacher').hide();
            $('.student').show();

        }else if(sms_for==2){
            $('.student').hide();
            $('.teacher').show();

        }else{
            $('.teacher').hide();
            $('.student').hide();
        }
      });
      $(document.body).on('change','#class_code',function() {
         var class_code=$(this).val();
         var version_id=$("input[name='version']:checked").val();
         var shift_id=$("input[name='shift']:checked").val();
         var type_for=$("input[name='type']:checked").val();
            var url="{{route('getSectionsForSMS')}}";
            $.LoadingOverlay("show");
            $.ajax({
                type: "post",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: url,
                data:{"_token": "{{ csrf_token() }}",class_code,shift_id,version_id,type_for},
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
      $(document.body).on('click','.admissionsendsms',function() {
        var class_code=$('#class_code').val();
        var url="{{route('getAdmissionPhoneWithClass')}}";
        $.LoadingOverlay("show");
            $.ajax({
                type: "post",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: url,
                data:{"_token": "{{ csrf_token() }}",class_code},
                success: function(response){
                  $.LoadingOverlay("hide");
                //   var data=jQuery.parseJSON( response );
                //   consloe.log(data);
                    $('#phonenumbers').val(response);
                    $('#sendfor').val(1);

                },
                error: function(data, errorThrown)
                {
                    $('#sendfor').val(0);
                  $.LoadingOverlay("hide");
                    Swal.fire({
                        title: "Error",
                        text: errorThrown,
                        icon: "warning"
                    });

                }
            });
      });
      $(document.body).on('click','.searchforsms',function() {
        var class_code=$('#class_code').val();
        var category_id=$('#category_id').val();
        var session_id=$('#session_id').val();
        var group_id=$('#group_id').val();
        var section_id=$('#section_id').val();
        var name=$('#name').val();
        var designation_id=$('#designation_id').val();
        var subject_id=$('#subject_id').val();
         var sms_for=$("input[name='sms_for']:checked").val();
         var version_id=$("input[name='version']:checked").val();
         var shift_id=$("input[name='shift']:checked").val();
         var class_for=$("input[name='type']:checked").val();
            var url="{{route('getStudentOrTeacherData')}}";
            $.LoadingOverlay("show");
            $.ajax({
                type: "post",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: url,
                data:{"_token": "{{ csrf_token() }}",sms_for,subject_id,designation_id,name,section_id,class_code,category_id,group_id,class_code,shift_id,version_id,class_for,session_id},
                success: function(response){
                  $.LoadingOverlay("hide");
                        $('#smsdata').html(response);


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

      $(document).ready(function() {
        $('#role_id').on('change', function() {
        var role_id = $(this).val();

        if (role_id) {
            $.ajax({
                url: "{{ route('getUserDataByRole') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    role_id: role_id
                },
                beforeSend: function() {
                    $.LoadingOverlay("show"); // Show loading overlay
                },
                success: function(response) {
                    $.LoadingOverlay("hide"); // Hide loading overlay
                    $('#smsdata').html(response); // Populate table with user data
                },
                error: function(xhr, status, error) {
                    $.LoadingOverlay("hide");
                    Swal.fire({
                        title: "Error",
                        text: "Unable to fetch data",
                        icon: "warning"
                    });
                }
            });
        } else {
            $('#smsdata').html('<tr><td colspan="4">Please select a role</td></tr>');
        }
    });
});


});
</script>
@endsection
