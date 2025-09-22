<?php $__env->startSection('content'); ?>
    <style>
        /* .bx {
                        vertical-align: middle;
                        font-size: 2.15rem;
                        line-height: 1;
                    } */

        .text-capitalize {
            text-transform: capitalize !important;
            font-size: 25px;
        }

        .text-right {
            margin-left: 100%;
        }

        .demo-wrap {
            overflow: hidden;
            position: relative;
        }

        .demo-bg {
            opacity: 0.3;
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: -webkit-fill-available !important;
        }

        .demo-content {
            position: relative;
        }

        .modal-body {
            height: 300px;
            font-size: 26px;
            color: #0004ee;
            font-weight: bold;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">Dashboard </span>
            </h4>
            <!-- Card Border Shadow -->
            <div class="row mt-4">
                <div class="col-sm-6 col-lg-4">
                    <div class="card icon-card card-border-shadow-warning cursor-pointer text-center">
                        <a href="<?php echo e(route('StudentProfile', 0)); ?>">
                            <div class="card-body bg-label-danger">
                                <div class="avatar flex-shrink-0 " style="margin: 0px auto">
                                    <img src="<?php echo e(asset('public/dashboard/student.jpg')); ?>" alt="cube" class="rounded">
                                </div>
                                <p class="icon-name text-capitalize text-truncate mb-0">Profile</p>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- div class="col-sm-6 col-lg-3">
                    <div class="card icon-card card-border-shadow-warning cursor-pointer text-center">
                        <a href="<?php echo e(route('studentAttendanceparentAttendance')); ?>">
                            <div class="card-body bg-label-danger">
                                <div class="avatar flex-shrink-0 " style="margin: 0px auto">
                                    <img src="<?php echo e(asset('public/dashboard/attendance.webp')); ?>" alt="cube"
                                        class="rounded">
                                </div>
                                <p class="icon-name text-capitalize text-truncate mb-0">Attendance</p>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card icon-card card-border-shadow-warning cursor-pointer text-center">
                        <a href="<?php echo e(route('calendarDashboard')); ?>">
                            <div class="card-body bg-label-danger">
                                <div class="avatar flex-shrink-0 " style="margin: 0px auto">
                                    <img src="<?php echo e(asset('public/dashboard/calendar.png')); ?>" alt="calendar" class="rounded">
                                </div>
                                <p class="icon-name text-capitalize text-truncate mb-0">Academic Calender</p>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card icon-card card-border-shadow-primary cursor-pointer text-center">
                        <a href="<?php echo e(route('academyDashboard')); ?>">
                            <div class="card-body bg-label-primary">
                                <div class="avatar flex-shrink-0 " style="margin: 0px auto">
                                    <img src="<?php echo e(asset('public/dashboard/activity.png')); ?>" alt="syllabus" class="rounded">
                                </div>
                                <p class="icon-name text-capitalize text-truncate mb-0">Academy Activity</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="card icon-card card-border-shadow-primary cursor-pointer text-center">
                        <a href="<?php echo e(route('studentNotice')); ?>">
                            <div class="card-body bg-label-info">
                                <div class="avatar flex-shrink-0 " style="margin: 0px auto">
                                    <img src="<?php echo e(asset('public/dashboard/notice.webp')); ?>" alt="notice" class="rounded">
                                </div>
                                <p class="icon-name text-capitalize text-truncate mb-0">Notice</p>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card icon-card card-border-shadow-primary cursor-pointer text-center">
                        <a href="<?php echo e(route('studentSyllabus')); ?>">
                            <div class="card-body bg-label-primary">
                                <div class="avatar flex-shrink-0 " style="margin: 0px auto">
                                    <img src="<?php echo e(asset('public/dashboard/syllabus.png')); ?>" alt="syllabus" class="rounded">
                                </div>
                                <p class="icon-name text-capitalize text-truncate mb-0">Syllabus</p>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card icon-card card-border-shadow-warning cursor-pointer text-center">
                        <a href="<?php echo e(route('student.academicTranscript')); ?>">
                            <div class="card-body bg-label-warning">
                                <div class="avatar flex-shrink-0 " style="margin: 0px auto">
                                    <img src="<?php echo e(asset('public/dashboard/result.png')); ?>" alt="result" class="rounded">
                                </div>
                                <p class="icon-name text-capitalize text-truncate mb-0">Result</p>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card icon-card card-border-shadow-primary cursor-pointer text-center">
                        <a href="<?php echo e(route('lessonPlanStudent')); ?>">
                            <div class="card-body bg-label-primary">
                                <div class="avatar flex-shrink-0 " style="margin: 0px auto">
                                    <img src="<?php echo e(asset('public/dashboard/lessonPlan.png')); ?>" alt="lessonPlan"
                                        class="rounded">
                                </div>
                                <p class="icon-name text-capitalize text-truncate mb-0">Lesson Plan</p>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
            <div class="row mt-4">

                <div class="col-sm-6 col-lg-3">
                    <div class="card icon-card card-border-shadow-warning cursor-pointer text-center">
                        <a href="<?php echo e(route('studentRouten')); ?>">
                            <div class="card-body bg-label-warning">
                                <div class="avatar flex-shrink-0 " style="margin: 0px auto">
                                    <img src="<?php echo e(asset('public/dashboard/routine.png')); ?>" alt="routine" class="rounded">
                                </div>
                                <p class="icon-name text-capitalize text-truncate mb-0">Routine</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card icon-card card-border-shadow-primary cursor-pointer text-center">
                        <a href="<?php echo e(route('studentPrint', Auth::user()->ref_id)); ?>" target="_blank">
                            <div class="card-body bg-label-info">
                                <div class="avatar flex-shrink-0 " style="margin: 0px auto">
                                    <img src="<?php echo e(asset('public/dashboard/admission.png')); ?>" alt="form"
                                        class="rounded">
                                </div>
                                <p class="icon-name text-capitalize text-truncate mb-0">Admission Form</p>
                            </div>
                        </a>
                    </div>
                </div -->
				<div class="col-sm-6 col-lg-4">
                    <div class="card icon-card card-border-shadow-primary cursor-pointer text-center">
                        <a href="<?php echo e(route('getidcardd')); ?>" target="_blank">
                            <div class="card-body bg-label-info">
                                <div class="avatar flex-shrink-0 " style="margin: 0px auto">
                                    <img src="<?php echo e(asset('public/dashboard/student.jpg')); ?>" alt="form"
                                        class="rounded">
                                </div>
                                <p class="icon-name text-capitalize text-truncate mb-0"><a href="<?php echo e(url('admin/studentPrint/' . Auth::user()->ref_id)); ?>" target="_blank"
																						   >Print Admission Form</a></p>
                            </div>
                        </a>
                    </div>
                </div> 
				<div class="col-sm-6 col-lg-4">
                    <div class="card icon-card card-border-shadow-primary cursor-pointer text-center">
                        <a href="<?php echo e(route('getidcardd')); ?>" target="_blank">
                            <div class="card-body bg-label-info">
                                <div class="avatar flex-shrink-0 " style="margin: 0px auto">
                                    <img src="<?php echo e(asset('public/dashboard/student.jpg')); ?>" alt="form"
                                        class="rounded">
                                </div>
                                <p class="icon-name text-capitalize text-truncate mb-0">ID Card</p>
                            </div>
                        </a>
                    </div>
                </div>
                 
				<!--
				<div class="col-sm-6 col-lg-3">
                    <div class="card icon-card card-border-shadow-primary cursor-pointer text-center">
                        <a href="<?php echo e(route('getidcardd')); ?>" target="_blank">
                            <div class="card-body bg-label-warning">
                                <div class="avatar flex-shrink-0 " style="margin: 0px auto">
                                    <img src="<?php echo e(asset('public/dashboard/brochure.png')); ?>" alt="form"
                                        class="rounded">
                                </div>
                                <p class="icon-name text-capitalize text-truncate mb-0">Prospectus</p>
                            </div>
                        </a>
                    </div>
                </div> -->
				<div class="col-sm-6 col-lg-4 mt-3">
					<div class="card icon-card card-border-shadow-primary cursor-pointer text-center">
						<a href="
							<?php if($version_id == 1): ?>
								https://bafsdadmission.com/public/admission/BAF%20Shaheen%20College%20Inner%20Bangla.pdf
							<?php elseif($version_id == 2): ?>
								https://bafsdadmission.com/public/admission/BAF%20Shaheen%20College%20English.pdf
							<?php endif; ?>
						" target="_blank">
							<div class="card-body bg-label-warning">
								<div class="avatar flex-shrink-0" style="margin: 0px auto">
									<img src="<?php echo e(asset('public/dashboard/brochure.png')); ?>" alt="form" class="rounded">
								</div>
								<p class="icon-name text-capitalize text-truncate mb-0">Prospectus</p>
							</div>
						</a>
					</div>
				</div>

            </div>
        </div>
        <!-- / Content -->
        <div class="content-backdrop fade"></div>
    </div>
    <div class="modal fade" id="modalCenter" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <img class="demo-bg" src="<?php echo e(asset('public/popsheen.png')); ?>" alt="">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="text-align: center">
                    <p style="font-size:25px;margin-bottom: .1rem;color: #ee00bb">Congratulations!
                    <p><br>
                        
                        Your Admission Process is completed.
                        
                </div>
            </div>
        </div>
    </div>
    <script>
        <?php if(Session::get('success')): ?>
            $(document).ready(function() {
                // Trigger the modal
                $('#modalCenter').modal('show');
            });
            // Swal.fire({
            //    title: "Good job!",
            //    text: "<?php echo e(Session::get('success')); ?>",
            //    icon: "success"
            // });
        <?php endif; ?>
        <?php if(Session::get('warning')): ?>

            Swal.fire({
                title: "warning!",
                text: "<?php echo e(Session::get('warning')); ?>",
                icon: "warning"
            });
        <?php endif; ?>
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/bafsdadmission.com/httpdocs/resources/views/admin/dashboard/student.blade.php ENDPATH**/ ?>