<?php $__env->startSection('content'); ?>
    <style>
        /* .bx {
                                    vertical-align: middle;
                                    font-size: 2.15rem;
                                    line-height: 1;
                                }

                                 */

        .text-capitalize {
            text-transform: capitalize !important;
            font-size: 25px;
        }

        .avatar {
            position: relative;
            width: 4rem;
            height: 4rem;
            cursor: pointer;
        }
    </style>
    <link href="<?php echo e(asset('backend/vendor/fonts/boxicons.css')); ?>" />
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3" style="margin: 15px 0">
                <span class="text-muted fw-light">Dashboard </span>
            </h4>
            <!-- Card Border Shadow -->
            <div class="row">
                <div class="col-sm-6 col-lg-3 mb-4">
                    <div class="card icon-card card-border-shadow-primary cursor-pointer text-center h-100">
                        <a href="<?php echo e(route('studentsDashboard')); ?>">
                            <div class="card-body bg-label-danger">
                                <div class="avatar flex-shrink-0 " style="margin: 0px auto">
                                    <img src="<?php echo e(asset('public/dashboard/student.jpg')); ?>" alt="cube" class="rounded">
                                </div>

                                <p class="icon-name text-capitalize text-truncate mb-0">Students</p>
                            </div>
                        </a>
                    </div>
                </div>
               

            </div>
            <div class="row mt-4">

                

                <div class="col-sm-6 col-lg-3 mb-4">
                    <div class="card icon-card card-border-shadow-warning cursor-pointer text-center h-100">
                        <a href="<?php echo e(route('admissionstatus')); ?>">
                            <div class="card-body bg-label-primary ">
                                <div class="avatar flex-shrink-0 " style="margin: 0px auto">
                                    <img src="<?php echo e(asset('public/image/admission.png')); ?>" alt="cube" class="rounded">
                                </div>

                                <p class="icon-name text-capitalize text-truncate mb-0">Admission</p>
                            </div>
                        </a>
                    </div>
                </div>
                

            </div>

        </div>
        <!-- / Content -->

        <div class="content-backdrop fade"></div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/kgadmission/resources/views/admin/dashboard/mainadmin.blade.php ENDPATH**/ ?>