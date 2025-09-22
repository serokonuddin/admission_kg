<?php $__env->startSection('content'); ?>
    <style>
        .bg-color {
            background: #5993a9;
            color: white !important;
            font-size: 18px;
            font-weight: bold;
        }

        .bx {
            vertical-align: middle;
            font-size: 2.15rem;
            line-height: 1;
        }

        .text-capitalize {
            text-transform: capitalize !important;
            font-size: 25px;
        }

        @media (min-width: 1200px) {

            h4,
            .h4 {
                font-size: 1.075rem;
            }
        }

        .table:not(.table-dark) th {


            color: rgb(0, 149, 221) !important;
        }

        .table-dark th {
            border-bottom-color: rgb(0, 149, 221) !important;
        }

        .card-text {
            font-size: 17px;
            font-weight: bold;
        }
    </style>
    <?php
        $color = [
            'dark',
            'info',
            'primary',
            'warning',
            'danger',
            'success',
            'secondary',
            'dark',
            'info',
            'primary',
            'warning',
            'danger',
            'success',
            'secondary',
            'dark',
            'info',
            'primary',
            'warning',
            'danger',
            'success',
            'secondary',
        ];

        $colordata = [
            'success',
            'danger',
            'warning',
            'info',
            'dark',
            'primary',
            'secondary',
            'primary',
            'secondary',
            'success',
            'danger',
            'warning',
            'info',
            'dark',
            'primary',
            'secondary',
            'success',
            'danger',
            'warning',
            'info',
            'dark',
            'primary',
            'secondary',
            'success',
            'danger',
            'warning',
            'info',
            'dark',
        ];
    ?>
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Student</h4>
            <div class="row">
                <?php
                    $i = 0;
                ?>
                <?php $__currentLoopData = $type_for; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6 col-xl-4">
                        <a href="<?php echo e(url('admin/studentGetTypeStudent/' . $key+1)); ?>">
                            <div
                                class="card icon-card card-border-shadow-<?php echo e($color[$i++]); ?> cursor-pointer text-center h-100">
                                <div class="card-header bg-color"><?php echo e($type); ?></div>
                                <div class="card-body bg-label-<?php echo e($colordata[$i++]); ?>">
                                    <p class="card-text">
                                        Total:
                                        <?php echo e($studentdata[$key]->total ?? '0'); ?>

                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



            </div>
        </div>
        <!-- / Content -->

        <div class="content-backdrop fade"></div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/bafsdadmission.com/httpdocs/resources/views/admin/dashboard/studentd.blade.php ENDPATH**/ ?>