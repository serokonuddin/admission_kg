<?php $__env->startSection('content'); ?>
    <style>
        .form-check {
            border-bottom: 0;
            font-size: 13px;
            padding: 5px;
        }

        .form-check a {
            color: black !important;
        }

        .form-check a:hover {
            color: #337AB7 !important;
            font-weight: bold;
        }

        .sidecourse-title a {
            font-size: 16px;
            font-weight: bold;
        }

        .onlineformbtns,
        .onlineformbtn {
            border-radius: 30px !important;
            padding: 7px 20px;
            border: 0;
            font-size: 14px;
            background: #337AB7;
            color: #fff !important;
            text-align: center;
            transition: all 0.5s ease;
            box-shadow: 0px 5px 25px 0px rgba(189, 7, 69, 0.41);
            display: inline-block;
            text-decoration: none !important;
        }

        .mdbtn {
            width: auto;
            margin-top: 5px;
        }

        .form-check .form-check-input {
            float: left;
            margin-left: 0 !important;
        }

        .noborder td {
            border: none !important;
        }

        .modal-content {
            width: 100% !important;
        }

        .background-image {
            background-image: url('<?php echo e(asset('public/062.png')); ?>');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            padding: 0 !important;
            margin: 0 !important;
            max-width: 100% !important;
        }

        /* Default desktop */
        .table-desktop {
            display: block;
        }

        .table-mobile {
            display: none;
        }

        /* Mobile */
        @media (max-width: 768px) {

            .table-desktop {
                display: none;
            }

            .table-mobile {
                display: block;
            }

            .table-mobile .card {
                background: #fff;
                border: 1px solid #ddd;
                border-radius: 10px;
                overflow: hidden;
                margin-bottom: 15px;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            }

            .table-mobile .grid-table {
                display: grid;
                grid-template-columns: 1fr 1fr;
                /* two equal columns */
            }

            .table-mobile .grid-item {
                border-bottom: 1px solid #ddd;
                border-right: 1px solid #ddd;
                padding: 8px 12px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .table-mobile .grid-item:nth-child(2n) {
                border-right: none;
                /* remove right border for second column */
            }

            .table-mobile .grid-item:last-child {
                border-bottom: none;
                /* remove bottom border for last row */
            }

            .row-label {
                font-weight: 600;
                color: #222;
                text-align: left;
            }

            .row-value {
                color: #333;
                text-align: right;
                font-weight: 500;
            }

            /* Action button row full width */
            .table-mobile .grid-item.action {
                grid-column: span 2;
                display: flex;
                justify-content: center;
                border-bottom: none;
                border-right: none;
                padding: 10px 0;
            }

            .onlineformbtn {
                border-radius: 6px;
                padding: 6px 14px;
                font-size: 14px;
                background: #337AB7;
                color: #fff !important;
                text-decoration: none;
                transition: background 0.2s;
                width: 90%;
                text-align: center;
            }

            .onlineformbtn:hover {
                background: #235a91;
            }
        }

        @media (min-width: 768px) {
            .modal-content {
                width: 800px !important;
            }

            .modal-dialog {
                margin-left: 18%;
            }
			.notice .modal-dialog {
                margin-left: 700px;
            }
        }

        @media (max-width: 767px) {
            .modal-dialog {
                margin: 10px auto !important;
                max-width: 95% !important;
            }

            .background-image {
                background-image: url('<?php echo e(asset('public/kg-admission-mobile.jpg')); ?>');
            }

            h3,
            h4 {
                font-size: 1rem !important;
            }

            .btn {
                font-size: .75rem;
                padding: 5px 10px;
            }
        }

        p {
            font-size: 1rem;
            color: #666;
            font-weight: bold;
        }

        label {
            margin-bottom: 0.3rem;
            font-size: 0.9rem;
        }

        .form-check-input {
            border: 1px solid #1d1d1d;
        }

        .row {
            --bs-gutter-x: .75rem;
        }
		.admission-link {
        color: #337AB7;       /* Blue text */
        font-weight: bold;  /* Bold text */
        text-decoration: none; /* Remove underline if desired */
        animation: blink 3s step-start infinite; /* Blink effect */
		}

		@keyframes blink {
			20% {
				opacity: 0;
			}
		}
    </style>

	
    <div class="container my-4 notice">
		<div class="modal fade" id="loginBlockModal" tabindex="-1" aria-labelledby="loginBlockLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="loginBlockLabel" style="color: white;margin-left: 42%;">সতর্কতা</h5>
                    <!--button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button-->
                </div>
                <div class="modal-body">
                    অনলাইন ভর্তি প্রক্রিয়া রাত ১২:০০টা থেকে সকাল ৭:০০ টা পর্যন্ত বন্ধ থাকবে
                </div>
                <div class="modal-footer">
                    <!--button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Okay</button-->
                </div>
            </div>
        </div>
    </div>
        <div class="text-center mb-3">
            <h3>Online Admission (অনলাইন ভর্তি)</h3>
            <h4>
                <a href="<?php echo e(asset('public/admission/Admission Guidelines for XI Class-2025-Final-3-1.pdf')); ?>" target="_blank" class="admission-link">
                    Admission Instruction (ভর্তির নির্দেশনা)
                </a>
            </h4>
            <h4>
                <img src="<?php echo e(asset('public/call-thumbnail.png')); ?>" style="height: 25px" />
                <a href="tel:01759536622" style="color:red;font-weight:bold;">01759536622</a>,
                <a href="tel:01777521159" style="color:red;font-weight:bold;">01777521159</a>
            </h4>
        </div>

        <!-- Responsive Table -->
        <div class="table-responsive table-desktop">
            <table class="table table-striped table-bordered text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>SL</th>
                        <th>Class</th>
                        <th>Version</th>
                        <th>Session</th>
                        <th>Date</th>
                        <!--th>Seats</th-->
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $admissiondata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $admission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key + 1); ?></td>
                            <td><?php echo e($admission->class->class_name); ?></td>
                            <td><?php echo e($admission->version->version_name); ?></td>
                            <td>
                                <?php echo e($admission->class->class_code == 11
                                    ? $session->session_name . '-' . ((int) $session->session_name + 1)
                                    : $admission->session->session_name); ?>

                            </td>
                            <td>
                                Start: <?php echo e($admission->start_date); ?> <br>
                                <span style="color:red;font-weight:bold">End: <?php echo e($admission->end_date); ?></span>
                            </td>
                            <!--td><?php echo e($admission->number_of_admission); ?></td!-->
                            <td><?php echo e($admission->price); ?>৳</td>
                            <td>
                                <?php if($admission->class->class_code == 11): ?>
                                    <a href="javascript:void(0)" data-class_id="<?php echo e($admission->class_id); ?>"
                                        data-session_id="<?php echo e($admission->session_id); ?>"
                                        data-versionid="<?php echo e($admission->version_id); ?>"
                                        data-version="<?php echo e($admission->version->version_name); ?>"
                                        class="onlineformbtn mdbtn">Registration</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <!-- Mobile Grid Version -->
        <div class="table-mobile">
            <?php $__currentLoopData = $admissiondata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $admission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card">
                    <div class="grid-table">
                        <div class="grid-item"><span class="row-label">SL</span> <span
                                class="row-value"><?php echo e($key + 1); ?></span></div>
                        <div class="grid-item"><span class="row-label">Class</span> <span
                                class="row-value"><?php echo e($admission->class->class_name); ?></span></div>

                        <div class="grid-item"><span class="row-label">Version</span> <span
                                class="row-value"><?php echo e($admission->version->version_name); ?></span></div>
                        <div class="grid-item"><span class="row-label">Session</span>
                            <span
                                class="row-value"><?php echo e($admission->class->class_code == 11 ? $session->session_name . '-' . ((int) $session->session_name + 1) : $admission->session->session_name); ?></span>
                        </div>

                        <div class="grid-item"><span class="row-label">Start Date</span> <span
                                class="row-value"><?php echo e($admission->start_date); ?></span></div>
                        <div class="grid-item"><span class="row-label">End Date</span> <span
                                class="row-value text-danger fw-bold"><?php echo e($admission->end_date); ?></span></div>

                        <!--div class="grid-item"><span class="row-label">Seats</span> <span
                                class="row-value"><?php echo e($admission->number_of_admission); ?></span></div-->
                        <div class="grid-item"><span class="row-label">Amount</span> <span
                                class="row-value"><?php echo e($admission->price); ?>৳</span></div>

                        <div class="grid-item action">
                            <?php if($admission->class->class_code == 11): ?>
                                <a href="javascript:void(0)" data-class_id="<?php echo e($admission->class_id); ?>"
                                    data-session_id="<?php echo e($admission->session_id); ?>"
                                    data-versionid="<?php echo e($admission->version_id); ?>"
                                    data-version="<?php echo e($admission->version->version_name); ?>"
                                    class="onlineformbtn">Registration</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="text-center mt-3">
            <a class="onlineformbtn" href="<?php echo e(route('login')); ?>">Already Registered? Click Here</a>
        </div>
    </div>


    <!-- Modal -->
    <div id="checkOnlineAdmissionStatus" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="w-100">
                        <span id="version_name" style="color:red;font-weight:bold;font-size:17px;"></span>
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="<?php echo e(route('admissionData')); ?>" method="post" enctype="multipart/form-data"
                    id="checkstatusform">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="version_id" id="version_id">
                    <input type="hidden" name="class_id" id="class_id">
                    <input type="hidden" name="session_id" id="session_id">

                    <div class="modal-body">
                        <div class="row g-2">
                            <div class="col-md-6 col-12">
                                <label>SSC Roll Number (এসএসসি রোল নম্বর)<span style="color:red">*</span></label>
                                <input type="text" class="form-control" id="roll_number" name="roll_number"
                                    value="<?php echo e(old('roll_number')); ?>" required placeholder="SSC Roll Number">
                            </div>
                            <div class="col-md-6 col-12">
                                <label>Education Board (শিক্ষাবোর্ড)<span style="color:red">*</span></label>
                                <select class="form-control" name="board_id" id="board_id" required>
                                    <option value="">Select Board</option>
                                    <option value="Dhaka">Dhaka (ঢাকা)</option>
                                    <option value="Rajshahi">Rajshahi (রাজশাহী)</option>
                                    <option value="Cumilla">Cumilla (কুমিল্লা)</option>
                                    <option value="Jashore">Jashore (যশোর)</option>
                                    <option value="Chattogram">Chattogram (চট্টগ্রাম)</option>
                                    <option value="Barishal">Barishal (বরিশাল)</option>
                                    <option value="Sylhet">Sylhet (সিলেট)</option>
                                    <option value="Mymensingh">Mymensingh (ময়মনসিংহ)</option>
                                    <option value="Dinajpur">Dinajpur (দিনাজপুর)</option>
                                    <option value="Madrasah">Madrasah (মাদ্রাসা)</option>
                                    <option value="BTEB">BTEB (কারিগরি শিক্ষা)</option>
                                    <option value="BOU">BOU (বাউবি)</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-12">
                                <label>Full Name (সম্পূর্ণ নাম)<span style="color:red">*</span></label>
                                <input type="text" class="form-control" id="full_name" name="full_name"
                                    value="<?php echo e(old('full_name')); ?>" readonly required>
                            </div>
                            <div class="col-md-6 col-12">
                                <label>Group (বিভাগ)<span style="color:red">*</span></label>
                                <input type="text" class="form-control" id="group_name" name="group_name"
                                    value="<?php echo e(old('group_name')); ?>" readonly required>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="onlineformbtns mdbtn" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="onlineformbtns mdbtn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
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
                        var lastDayOfPrevMonth = new Date(today.getFullYear(), today.getMonth(), 0)
                            .getDate();
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
                    if ((totalAgeDays >= minAgeDays && totalAgeDays <= maxAgeDays) || (category_id == 2 ||
                            category_id == 4)) {
                        $('#age').text(years + ' years, ' + months + ' months, ' + days + ' days').css(
                            'color', 'green');
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
                $text = '';
                foreach ($errors->all() as $error) {
                    $text .= '<p>' . $error . '</p>';
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
        $(function() {

            $(document.body).on('click', '.kgadmission', function() {
                var versionid = $(this).data('versionid');
                var class_id = $(this).data('class_id');
                var session_id = $(this).data('session_id');
                var amount = $(this).data('amount');
                $('#versionid').val(versionid)
                $('#classid').val(class_id)
                $('#sessionid').val(session_id)
                $('#amount').val(amount)
                if (versionid == 1) {
                    $('#versiontext').text('ভার্সন বাংলা');
                } else {
                    $('#versiontext').text('Version English');
                }
                $('#exampleModalLong').modal('show');
            });
            $(document.body).on('click', '.findAdmitcard', function() {

                $('#exampleModal').modal('show');
            });
            $(document.body).on('click', '.onlineformbtn', function() {
                var versionid = $(this).data('versionid');
                var version_name = $(this).data('version');
                var class_id = $(this).data('class_id');
                var session_id = $(this).data('session_id');
                var price = $(this).data('price');
                $('#version_id').val(versionid);
                $('#class_id').val(class_id);
                $('#session_id').val(session_id);
                $('#price').val(price);
                var text = '';
                if (versionid == 1) {
                    text = "XI Class Admission-Bangla Version<br/> (একাদশ শ্রেণিতে ভর্তি-বাংলা ভার্শন)"
                } else {
                    text = "XI Class Admission-English Version<br/> (একাদশ শ্রেণিতে ভর্তি-ইংরেজি ভার্শন)"
                }
                $('#version_name').html(text);
                $('#checkOnlineAdmissionStatus').modal('show');
            });
            $(document.body).on('input', '#roll_number', function() {

                var roll_number = $('#roll_number').val();


                var board_id = $('#board_id').val();

                var url = "<?php echo e(route('checkRollRegistrationNumber')); ?>";
                if((roll_number.length==6 || roll_number.length==11) && board_id){
                    $.LoadingOverlay("show");
                    $.ajax({
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: url,
                        data: {
                            "_token": "<?php echo e(csrf_token()); ?>",
                            roll_number,
                            board_id
                        },
                        success: function(response) {

                            $.LoadingOverlay("hide");
                            if (response == 0) {

                                Swal.fire({
                                    title: "Error",
                                    text: 'Roll number or Board not found in BAF Shaheen College Dhaka Database',
                                    icon: "warning"
                                });
                                $('#roll_number').val('');
                                $('#board_id').val('');
                            } else if (response == 2) {

                                Swal.fire({
                                    title: "BAF Shaheen College Dhaka",
                                    text: 'Congratulations!  You have got a chance to get admission at BAF Shaheen college Dhaka by EQ/FQ. Contact College Office with the necessary documents for verification.',
                                    icon: "success"
                                });
                                $('#roll_number').val('');
                                $('#board_id').val('');
                            } else if (response == 1) {

                                Swal.fire({
                                    title: "Error",
                                    text: 'Allready applied',
                                    icon: "warning"
                                });
                                $('#roll_number').val('');
                                $('#board_id').val('');
                            } else {
                                var data = jQuery.parseJSON(response)
                                $('#full_name').val(data.full_name);
                                $('#group_name').val(data.group_name);
                            }



                        },
                        error: function(data, errorThrown) {
                            $.LoadingOverlay("hide");
                            Swal.fire({
                                title: "Error",
                                text: errorThrown,
                                icon: "warning"
                            });
                            $('#roll_number').val('');
                            $('#board_id').val('');
                        }
                    });
                }
            });
            $(document.body).on('submit', '#checkadmissionstatus', function(e) {


                e.preventDefault(); // avoid to execute the actual submit of the form.

                var form = $(this);
                var actionUrl = form.attr('action');
                $.LoadingOverlay("show");
                $.ajax({
                    type: "POST",
                    url: actionUrl,
                    data: form.serialize(), // serializes the form's elements.
                    success: function(data) {
                        $.LoadingOverlay("hide");
                        getPayment(data); // show response from the php script.
                    }
                });

            });
            $(document.body).on('change', '.category', function() {

                var category_id = $(this).val();
                $('#dob').val('');
                $('#age').html('');
                $('#message').html('');
                var url = "<?php echo e(route('getCategoryView')); ?>";
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "<?php echo e(csrf_token()); ?>",
                        category_id
                    },
                    success: function(response) {

                        $.LoadingOverlay("hide");
                        console.log(response);
                        $('#categoryview').html(response);

                    },
                    error: function(data, errorThrown) {
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
            $(document.body).on('change', '#onlineformbtn', function() {

            });
            $(document.body).on('change', '#board_id', function() {
                var roll_number = $('#roll_number').val();


                var board_id = $('#board_id').val();

                var url = "<?php echo e(route('checkRollRegistrationNumber')); ?>";
                if((roll_number.length==6 || roll_number.length==11) && board_id){
                    $.LoadingOverlay("show");
                    $.ajax({
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: url,
                        data: {
                            "_token": "<?php echo e(csrf_token()); ?>",
                            roll_number,
                            board_id
                        },
                        success: function(response) {

                            $.LoadingOverlay("hide");
                            if (response == 0) {
                                Swal.fire({
                                    title: "Error",
                                    text: 'Roll number or Board not found in BAF Shaheen College Dhaka Database',
                                    icon: "warning"
                                });


                            } else if (response == 1) {

                                Swal.fire({
                                    title: "Error",
                                    text: 'Allready applied',
                                    icon: "warning"
                                });

                            } else if (response == 2) {

                                Swal.fire({
                                    title: "BAF Shaheen College Dhaka",
                                    text: 'Congratulations!  You have got a chance to get admission at BAF Shaheen college Dhaka by EQ/FQ. Contact College Office with the necessary documents for verification.',
                                    icon: "success"
                                });

                            } else {
                                var data = jQuery.parseJSON(response)
                                $('#full_name').val(data.full_name);
                                $('#group_name').val(data.group_name);
                            }



                        },
                        error: function(data, errorThrown) {
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend-new.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\college_admission\resources\views/frontend-new/admissionlistxi.blade.php ENDPATH**/ ?>