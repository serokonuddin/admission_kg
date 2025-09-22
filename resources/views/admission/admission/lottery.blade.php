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
    .p-10{
        padding: 10px!important;
    }
    .m-r-10{
        margin-right: 10px!important;
    }
    .childdata{
      display: none;
      background-color: #98fded;
    }
    .btn{
        font-size: 11px!important;
    }
    .form-label{
      width: 100%!important;
    }

        .logo-container {

        }

    /* Logo styling */

    .logo-spging {
        width: 150px;
        height: 150px;
        background-image: url('your-logo.png'); /* Replace with your logo */
        background-size: cover;
        background-position: center;
         animation: spin .3s linear infinite;
         margin-left: 30%
        }

        @keyframes spin {
        from {
            transform: rotateY(0deg); /* Start rotation */
        }
        to {
            transform: rotateY(360deg); /* Complete 360-degree rotation */
        }
        }
</style>
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> KG Lottery (2025)</h4>
        <div class="card">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="dataTables_length" id="DataTables_Table_0_length" style="padding: 5px">
                        <form action="#" method="GET">
                            <div class="row g-3 searchby">
                               <div class="col-sm-6">
                                    <div class="col-sm-12">
                                        <label class="form-label">
                                            <select id="session_id" name="session_id" style="display: none" class="form-select" required="">
                                                @foreach($sessions as $session)
                                                    <option value="{{$session->id}}" >{{$session->session_name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="form-label">
                                            <select id="version_id" name="version_id" class="form-select">
                                                <option value="">Select Version</option>
                                                @foreach($versions as $version)
                                                    <option value="{{$version->id}}" >{{$version->version_name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="form-label">
                                            <select id="shift_id" name="shift_id" class="form-select">
                                                <option value="">Select Shift</option>
                                                @foreach($shifts as $shift)
                                                    <option value="{{$shift->id}}" >{{$shift->shift_name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                    </div>
                                    <div class="col-sm-12">
                                    <div class="col-md">
                                            <div class="form-check ">
                                                <input name="watting" id="watting" class="form-check-input "  type="checkbox" value="1" id="defaultRadio1">
                                                <label class="form-check-label" for="defaultRadio1">
                                                    Is Watting Selection?
                                                </label>
                                            </div>
                                            
                                           
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-12">
                                        <label class="form-label">
                                            <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Search By name,mobile,birth registration no,serial no" />
                                        </label>
                                    </div>

                                    <div class="col-sm-12">
                                        <label>
                                            <button type="button" class="btn btn-success me-2 search">Search</button>
                                        </label>
                                        <label>
                                            <button type="button" class="btn btn-primary me-2 start-lottery">Start</button>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                   <img src="{{asset('public/logo/logo.png')}}" style="display: none" class="logo-spging" width="150"/>
                                </div>
                            </div>
                        </form>

                        <!-- Buttons for different versions -->



                    </div>
                </div>
            </div>




        </div>

        <div class="row mb-6 g-6" style="margin-top: 15px" id="lottery-list">



        </div>
    </div>

<!-- Modal for Registration Form -->
        <div class="modal-onboarding modal fade animate__animated" id="onboardImageModal" tabindex="-1" style="display: none;" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content text-center datashow" id="datashow">

            </div>
          </div>
        </div>





    <!-- / Content -->

    <div class="content-backdrop fade"></div>
    <iframe id="txtArea1" style="display:none"></iframe>
 </div>
 <script type="text/javascript">

document.addEventListener('DOMContentLoaded', function () {
    // Select all buttons with the 'kgadmission' class
    document.querySelectorAll('.kgadmission').forEach(button => {
        button.addEventListener('click', function () {
            // Get data from the button's data attributes
            const classId = this.getAttribute('data-class_id');
            const sessionId = this.getAttribute('data-session_id');
            const versionId = this.getAttribute('data-versionid');
            const price = this.getAttribute('data-price');
            const versionText = this.textContent;

            // Set the form values in the modal
            document.getElementById('classid').value = classId;
            document.getElementById('sessionid').value = sessionId;
            document.getElementById('versionid').value = versionId;
            document.getElementById('amount').value = price;
            document.getElementById('versiontext').textContent = versionText;

            // Show the modal
            const exampleModal = new bootstrap.Modal(document.getElementById('exampleModalLong'));
            exampleModal.show();
        });
    });
});
function showlist(){
        var session_id=$('#session_id').val();
        var version_id=$('#version_id').val();
        var shift_id=$('#shift_id').val();
        var mobile=$('#mobile').val();
        let watting = $('#watting').is(':checked') ? $('#watting').val() : 0;
        var url="{{route('ajaxLottery')}}";
        $.ajax({
                            type: "post",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                            url: url,
                            data:{"_token": "{{ csrf_token() }}",mobile,watting,session_id,version_id,shift_id},
                            success: function(response){
                              $('#lottery-list').html(response);

                            },
                            error: function(data, errorThrown)
                            {
                                console.log(data, errorThrown);
                                Swal.fire({
                                    title: "Error",
                                    text: data?.responseJSON?.message,
                                    icon: "warning"
                                });
                            }
        });
}
$(document).ready(function() {
    $('.search').on('click', function() {
        showlist();
    });
    $('.start-lottery').on('click', function() {
        $('.logo-spging').css('display','flex');
        var session_id=$('#session_id').val();
        var version_id=$('#version_id').val();
        var shift_id=$('#shift_id').val();
        
        let watting = $('#watting').is(':checked') ? $('#watting').val() : 0;
        var url="{{route('ajaxWinnerLottery')}}";
        $.ajax({
                type: "post",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: url,
                data:{"_token": "{{ csrf_token() }}",session_id,watting,version_id,shift_id},
                success: function(response){

                 setTimeout(function () {
                     $('#datashow').html(response);
                    $('.logo-spging').css('display','none');
                    $('#onboardImageModal').modal('show');
                    showlist();
                }, 5000);


                },
                error: function(data, errorThrown)
                {

                    Swal.fire({
                                    title: "Error",
                                    text: data?.responseJSON?.message,
                                    icon: "warning"
                    });


                }
          });
    });
    $('#dob').on('change', function() {
      let category_id = $('input[name="category_id"]:checked').val();


        var dob = new Date($(this).val());
		if (!isNaN(dob.getTime())) { // Check if the date is valid
			var today = new Date(2025, 0, 1); // February 1, 2025

			// Calculate the age in terms of years, months, and days
			var years = today.getFullYear() - dob.getFullYear();
			var months = today.getMonth() - dob.getMonth();
			var days = today.getDate() - dob.getDate();

			// Adjust if the birth date hasn't occurred yet this month
			if (days < 0) {
				months--;
				// Get the last day of the previous month
				var lastDayOfPrevMonth = new Date(today.getFullYear(), today.getMonth(), 0).getDate();
				days += lastDayOfPrevMonth;
			}

			// Adjust if the birth month hasn't occurred yet this year
			if (months < 0) {
				years--;
				months += 12;
			}

			// Convert the calculated age to total days for comparison
			var totalAgeDays = years * 365 + months * 30 + days;

			// Minimum age: 4 years, 11 months, and 15 days
			var minAgeDays = (4 * 365) + (11 * 30) + 15;
			// Maximum age: 6 years and 15 days
			var maxAgeDays = (6 * 365) + 15;

			// Check if the total days fall within the valid range
			if ((totalAgeDays >= minAgeDays && totalAgeDays <= maxAgeDays) || (category_id==2 || category_id==4)) {
				$('#age').text(years + ' years, ' + months + ' months, ' + days + ' days').css('color', 'green');
				$('#message').text('Age is within the valid range').css('color', 'green');
			} else {
				Swal.fire({
					title: "Error",
					text: 'Age is not within the valid range',
					icon: "warning"
				});

				$('#age').text('');
				$(this).val('');
				$('#message').text('Age is not within the valid range').css('color', 'red');
			}
		} else {
			$('#message').text('Please select a valid date');
		}
    });
	$(document.body).on('change','.category',function(){

         var category_id=$(this).val();
         $('#dob').val('');
         $('#age').html('');
         $('#message').html('');
         var url="{{route('getCategoryView')}}";
         $.ajax({
                type: "post",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: url,
                data:{"_token": "{{ csrf_token() }}",category_id},
                success: function(response){

                  $.LoadingOverlay("hide");
                  console.log(response);
                  $('#categoryview').html(response);

                },
                error: function(data, errorThrown)
                {
                  $.LoadingOverlay("hide");
                    Swal.fire({
                        title: "Error",
                        text: errorThrown,
                        icon: "warning"
                    });
                    $('#categoryview').html('');

                }
          });
    });
    $(document.body).on('click','.kgadmission',function(){
         var id=$(this).data('id');
         var versionid=$(this).data('version_id');
         var class_id=$(this).data('class_id');
         var shift_id=$(this).data('shift_id');
         var session_id=$(this).data('session_id');
         var category_id=$(this).data('category_id');

         var temporary_id=$(this).data('temporary_id');
         var service_holder_name=$(this).data('service_holder_name');
         var service_name=$(this).data('service_name');
         var name_of_service=$(this).data('name_of_service');
         var in_service=$(this).data('in_service');
         var office_address=$(this).data('office_address');
        //  var name_of_staff=$(this).data('name_of_staff');
         var staff_designation=$(this).data('staff_designation');
         var staff_id=$(this).data('staff_id');
         var staff_certification=$(this).data('staff_certification');
         var arm_certification=$(this).data('arm_certification');
         var gen_id=$(this).data('gen_id');
         var section=$(this).data('section');
         var name_en=$(this).data('name_en');
         var name_bn=$(this).data('name_bn');
         var dob=$(this).data('dob');
         var gender=$(this).data('gender');
         var gurdian_name=$(this).data('gurdian_name');
         var mobile=$(this).data('mobile');
         var birth_registration_number=$(this).data('birth_registration_number');
         var birth_image=$(this).data('birth_image');
         var photo=$(this).data('photo');
         var payment_status=$(this).data('payment_status');


         $('#id').val(id);
         $('#versionid').val(versionid);
         $('#classid').val(class_id);
         $('#sessionid').val(session_id);
         $("input[name='shift_id'][value='"+shift_id+"']").prop("checked", true);
         $("input[name='category_id'][value='"+category_id+"']").prop("checked", true).trigger('change');
         setTimeout(function() {
                // Code to execute after delay
                $('#service_holder_name').val(service_holder_name);
                $('#temporary_id1').val(temporary_id);
                $('#service_name').val(service_name);
                $('#name_of_service').val(name_of_service);
                $('#office_address').val(office_address);
                $('#staff_designation').val(staff_designation);
                $('#staff_id').val(staff_id);
                $('#staff_certification_old').val(staff_certification);
                $('#arm_certification_old').val(arm_certification);
                $('#gen_id').val(gen_id);
                $('#section').val(section);
                $('#name_en').val(name_en);
                $('#name_bn').val(name_bn);
                $('#dob').val(dob);
                $('#gender').val(gender);
                $('#gurdian_name').val(gurdian_name);
                $('#mobile1').val(mobile);
                $('#birth_registration_number1').val(birth_registration_number);
                $('#birth_image_old').val(birth_image);
                $('#photo_old').val(photo);
                $('#payment_status').val(payment_status);
            }, 4000);

         if(versionid==1){
            $('#versiontext').text('ভার্সন বাংলা');
         }else{
            $('#versiontext').text('Version English');
         }
         $('#exampleModalLong').modal('show');
    });


});

function openAddModal() {
    const addModal = new bootstrap.Modal(document.getElementById('addModal'));
    addModal.show();
}

function openEditModal(student) {
    document.getElementById('student_id').value = student.id;
    document.getElementById('name_en').value = student.name_en;
    document.getElementById('temporary_id').value = student.temporary_id;
    document.getElementById('category_id').value = student.category_id;
    document.getElementById('version_id').value = student.version_id;
    document.getElementById('shift_id').value = student.shift_id;
    document.getElementById('birth_registration_number').value = student.birth_registration_number;
    document.getElementById('dob').value = student.dob;
    document.getElementById('gender').value = student.gender;
    document.getElementById('mobile').value = student.mobile;
    document.getElementById('payment_status').value = student.payment_status;

    const editModal = new bootstrap.Modal(document.getElementById('editModal'));
    editModal.show();
}


    function sendSMS(id) {
        var url="{{route('sendSmsForTemporaryID')}}";
        Swal.fire({
        title: "Do you want to Send an SMS?",
        showCancelButton: true,
        confirmButtonText: "Save",
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                    url: url,
                    data:{"_token": "{{ csrf_token() }}",id},
                    success: function(response){

                    $.LoadingOverlay("hide");
                    console.log(response);
                    if(response==0){
                        Swal.fire({
                            title: "Error",
                            text: "No Data Found",
                            icon: "warning"
                        });
                    }
                        Swal.fire({
                            title: "Success",
                            text: "SMS Send Successfully",
                            icon: "success"
                        });

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

    }
</script>

@endsection
