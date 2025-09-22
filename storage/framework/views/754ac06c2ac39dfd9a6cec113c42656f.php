<?php $__env->startSection('content'); ?>
<style>
   .form-check{
      border-bottom: 1px solid #eee;
      font-size: 13px;
      padding: 5px;

   }
   .form-check a{
      color: black!important;
   }
   .form-check a:hover{
      color: #337AB7!important;
      font-weight: bold;
   }
   .sidecourse-title a{
      font-size: 16px;
      font-weight: bold;
   }
   @media (min-width: 768px) {
      .modal-content{
         width: 620px!important;
      }
   }
   .onlineformbtns {
    border-radius: 30px !important;
    padding: 7px 20px;
    border: 0;
    display: inline-block;
    font-size: 14px;
    border-radius: 30px;
    background: #337AB7;
    text-decoration: none !important;
    color: #fff !important;
    text-align: center;
    /* line-height: 24px; */
    transition: all 0.5s ease 0s;
    box-shadow: 0px 5px 25px 0px rgba(189, 7, 69, 0.41);
}
.mdbtn {
    width: 114px;
    margin-top: 2px;
}
.form-check .form-check-input {
    float: left;
    margin-left: 0em!important;
}
table{
   width: 35%;
}
.noborder tbody,.noborder td,.noborder tr{
   border: none!important;
}
.form-check {
    border-bottom: 0px solid #eee;
    font-size: 13px;
    padding: 1px;
}
.modal-body p {
    margin-top: 0;
    margin-bottom: .2rem;
}
.background-image table{
   width: 310px!important;
   text-align: center;
   margin: 0px auto;
   border: 0px solid !important;
   --bs-table-bg: transparent;
}
.findAdmitcardt{
         width: 195px!important;
         text-align: center;
         margin: 0px auto;
         border: 0px solid !important;
         --bs-table-bg: transparent;
}
@media (min-width: 768px) {
    .modal-content {
        width: 800px !important;
    }
    .modal-dialog{
      margin-left: 18%;
    }
}
.background-image {
    background-image: url(<?php echo e(asset('public/062.png')); ?>);
    background-size: cover; /* Make the background cover the entire area */
    background-repeat: no-repeat; /* Prevent the background from repeating */
    background-position: center; /* Center the background image */
    padding: 0px!important;
    margin: 0px!important;
    max-width: 100%!important;
}
@media (max-width: 600px) {
   .modal-dialog{
      margin-left: 5%;
    }
    .modal-content {
        width: 90% !important;
    }
    h3, .h3,h4, .h4 {
      font-size: calc(.808125rem + 0.3375vw);
   }
   h4 span{
      font-size: 14px!important;
   }
   .btn {
         box-shadow: 0 0.25rem 0 rgba(0, 0, 0, 0.1);
         font-size: .7rem;
      }
      .background-image table{
         width: 240px!important;
         text-align: center;
         margin: 0px auto;
         border: 0px solid !important;

      }
      table.findAdmitcardt{
         width: 145px!important;
         text-align: center;
         margin: 0px auto;
         border: 0px solid !important;

      }
      .background-image {
         background-image: url(<?php echo e(asset('public/kg-admission-mobile.jpg')); ?>);
         background-size: cover; /* Make the background cover the entire area */
         background-repeat: no-repeat; /* Prevent the background from repeating */
         background-position: center; /* Center the background image */
         padding: 0px!important;
         margin: 0px!important;
         max-width: 100%!important;
      }
      .modal-content {
         width: 100% !important;
      }
      .modal-dialog{
         margin-left: 0%;
      }
}
.width-100{
   width: 100%;
}
p {
    font-size: 1.175rem;
    color: #666;
    font-weight: bold;
}
label {
    margin-bottom: 0.2rem;
}
.background-image tr, .background-image tbody, .background-image td,.background-image .table {

     border: 0px solid !important;
}

@media (min-width: 768px) {
   .background-image {
      min-height: 455px;
   }
}


.btn:hover{
   color: black!important;
}
.form-check-input {

    border: var(--bs-border-width) solid #1d1d1d;
}
</style>
<div class="modal fade" id="loginBlockModal" tabindex="-1" aria-labelledby="loginBlockLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="loginBlockLabel" style="color: white;margin-left: 42%;">সতর্কতা</h5>
                    <!--button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button-->
                </div>
                <div class="modal-body">
                    অনলাইন ভর্তি প্রক্রিয়া রাত ১২:০০টা থেকে সকাল ৭:০০ টা পর্যন্ত বন্ধ থাকবেে।
                </div>
                <div class="modal-footer">
                    <!--button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Okay</button-->
                </div>
            </div>
        </div>
    </div>
<div class="container spacet20 " >
   <div class="row">
      <div class="col-md-12 spacet60 pt-0-mobile">


         <div class="row">
            <div class="container spaceb50">
               <div class="row">


                  <div class="refine-categ-header " style="margin-top: 10px;">

                  <h3 style="text-align: center">College Admission (কলেজ ভর্তি): (<?php echo e($sessions->session_name.'-'.((int)$sessions->session_name+1)); ?>) </h3>
                    <form action="<?php echo e(route('payment')); ?>"  method="post" enctype="multipart/form-data" class="onlineform" id="checkstatusform">
                        <input type="hidden" name="_token" id="csrf-token" value="<?php echo e(Session::token()); ?>" />
                        <input type="hidden" name="version_id" id="version_id" value="<?php echo e($checkadmission->version_id); ?>" />
                        <input type="hidden" name="class_id" id="class_id" value="<?php echo e($checkadmission->class_id); ?>" />
                        <input type="hidden" name="session_id" id="session_id" value="<?php echo e($checkadmission->session_id); ?>" />
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                    <label>SSC Roll Number</label><small class="req"> *</small>
                                        <input type="text" readonly="" class="form-control" required="" value="<?php echo e($checkadmission->roll_number); ?>" name="roll_number" id="roll_number" autocomplete="off">
                                        <span class="text-danger" id="error_status_roll_number"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                    <label>Board (বোর্ড)</label><small class="req"> *</small>
                                        <select class="form-control" name="board_id" id="board_id">

                                            <option value=""> শিক্ষাবোর্ড নির্বাচন করুণ </option>
                                            <option value="Dhaka" <?php echo e((strtolower($checkadmission->board)=='dhaka')?'selected="selected"':''); ?>>Dhaka (ঢাকা)</option>
                                            <option value="Rajshahi" <?php echo e((strtolower($checkadmission->board)=='rajshahi')?'selected="selected"':''); ?>>Rajshahi (রাজশাহী)</option>
                                            <option value="Cumilla" <?php echo e((strtolower($checkadmission->board)=='cumilla')?'selected="selected"':''); ?>>Cumilla (কুমিল্লা)</option>
                                            <option value="Jashore
" <?php echo e((strtolower($checkadmission->board)=='jashore')?'selected="selected"':''); ?>>Jashore (যশোর)</option>
                                            <option value="Chattogram
" <?php echo e((strtolower($checkadmission->board)=='chattogram')?'selected="selected"':''); ?>>Chattogram
 (চট্টগ্রাম)</option>
                                            <option value="Barishal" <?php echo e((strtolower($checkadmission->board)=='barishal')?'selected="selected"':''); ?>>Barishal (বরিশাল)</option>
                                            <option value="Sylhet" <?php echo e((strtolower($checkadmission->board)=='sylhet')?'selected="selected"':''); ?>>Sylhet (সিলেট)</option>
                                            <option value="Dinajpur" <?php echo e((strtolower($checkadmission->board)=='dinajpur')?'selected="selected"':''); ?>>Dinajpur (দিনাজপুর)</option>
                                            <option value="Madrasah" <?php echo e((strtolower($checkadmission->board)=='madrasah')?'selected="selected"':''); ?>>Madrasah (মাদ্রাসা)</option>
											<option <?php echo e((strtolower($checkadmission->board)=='mymensingh')?'selected="selected"':''); ?> value="Mymensingh">Mymensingh (ময়মনসিংহ)</option>
                                            <option value="BTEB" <?php echo e((strtolower($checkadmission->board)=='bteb')?'selected="selected"':''); ?>>Bangladesh Technical Education (বাংলাদেশ কারিগরি শিক্ষা বোর্ড)</option>
                                            <option value="BOU" <?php echo e((strtolower($checkadmission->board)=='bou')?'selected="selected"':''); ?>>BOU (বাউবি)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                    <label>Full Name</label><small class="req"> *</small>
                                        <input type="text" readonly="" class="form-control" required="" value="<?php echo e($checkadmission->full_name); ?>" name="full_name" id="full_name" autocomplete="off">
                                        <span class="text-danger" id="error_status_full_name"></span>
                                    </div>
                                </div>
                                <!-- <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                    <label>Board</label><small class="req"> *</small>
                                    <input type="text"  readonly="" class="form-control" required="" value="<?php echo e(strtolower($checkadmission->board)); ?>" name="board" id="board" autocomplete="off">

                                    <span class="text-danger" id="error_status_board"></span>
                                    </div>
                                </div> -->
                                    <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Group (বিভাগ):</label><small class="req"> *</small>
                                                <div><input type="text" readonly="readonly" class="form-control" placeholder="Group Name" required="" value="<?php echo e($checkadmission->group_name); ?>" readonly="readonly" name="group_name" id="group_name" autocomplete="off">
                                                </div>
                                                <span class="text-danger" id="error_status_serial"></span>
                                            </div>

                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                        <label>Username (ইউজার নাম)</label><small class="req"> *</small>
                                            <input type="text" readonly="readonly" value="<?php echo e($checkadmission->student_code); ?>" class="form-control" placeholder="Valid Email,phone or username. Username should not contain spaces and spacial character" required="" name="username" id="username" autocomplete="off">
                                            <span class="text-danger" id="error_status_email"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                        <label>Email (ই-মেইল)</label>
                                            <input type="text" class="form-control" placeholder="Valid Email"  name="email" id="email" autocomplete="off">
                                            <span class="text-danger" id="error_status_email"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                        <label>Phone (ফোন) (This Number Must be Used While Enrolled In Shaheen College Dhaka)</label><small class="req"> *</small>
                                            <input type="number" class="form-control" value="<?php echo e($checkadmission->mobile); ?>" placeholder="Valid Phone Number Ex. 01XXXXXXXXX (ফোন)" required="" name="phone" id="phone" autocomplete="off">
                                            <span class="text-danger" id="error_status_phone"></span>
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Admission Serial (এডমিশন সিরিয়াল):</label>
                                                <div><input type="text" readonly="readonly" class="form-control" placeholder="Valid S.S.C Serial"  value="<?php echo e($serial); ?>" readonly="readonly" name="serial" id="serial" autocomplete="off">
                                                </div>
                                                <span class="text-danger" id="error_status_serial"></span>
                                            </div>

                                    </div> -->

                                    <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <br>
                                        <div>
                                        <button type="submit" class="onlineformbtn mdbtn" >Pay Now</button>
                                        </div>
                                    </div>
                                    </div>
                            </div>
                        </form>

                  </div>
                  <!--./refine-categ-header-->

               </div>
               <!--./row-->
            </div>
            <!--./container-->
         </div>

      </div>
   </div>
   <!--./row-->
</div>
<script>
		$(function () {
			var currentHour = new Date().getHours();

			// Show modal if time is between 9 PM (21) and 8 AM (8)
			if (currentHour >= 0 && currentHour < 7) {
				$('#loginBlockModal').modal({
					backdrop: 'static', // Prevent closing by clicking outside
					keyboard: false      // Prevent closing with ESC key
				});
				$('#loginBlockModal').modal('show');
			}
		});
	</script>

<script>
  $(document).ready(function() {
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
});


<?php if($errors->any()): ?>

       <?php
         $text='';
         foreach ($errors->all() as $error){
            $text.='<p>'.$error.'</p>';
         }
       ?>


      Swal.fire({
         title: "Warning!",
         html: "<?php echo $text; ?>",
         icon: "warning"
      });

<?php endif; ?>

   <?php if(Session::get('warning')): ?>

      Swal.fire({
         title: "Warning!",
         html: "<?php echo Session::get('warning'); ?>",
         icon: "warning"
      });

   <?php endif; ?>
   $(function(){


      $(document.body).on('click','.findAdmitcard',function(){

         $('#exampleModal').modal('show');
      });






   });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend-new.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/bafsdadmission.com/httpdocs/resources/views/frontend-new/admission.blade.php ENDPATH**/ ?>