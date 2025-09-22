<?php $__env->startSection('content'); ?>
    <style>
        .control {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
            position: relative;
            cursor: pointer;
        }

        th.control:before,
        td.control:before {
            background-color: #696cff;
            border: 2px solid #fff;
            box-shadow: 0 0 3px rgba(67, 89, 113, .8);
        }

        td.control:before,
        th.control:before {
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
            font-family: "Courier New", Courier, monospace;
            line-height: 1em;
            content: "+";
            background-color: #0d6efd;
        }

        .table-dark {
            background-color: #1c4d7c !important;
            color: #fff !important;
            font-weight: bold;
        }

        .table-dark {
            --bs-table-bg: #1c4d7c !important;
            --bs-table-striped-bg: #1c4d7c !important;
            --bs-table-striped-color: #fff !important;
            --bs-table-active-bg: #1c4d7c !important;
            --bs-table-active-color: #fff !important;
            --bs-table-hover-bg: #1c4d7c !important;
            --bs-table-hover-color: #fff !important;
            color: #fff !important;
            border-color: #1c4d7c !important;
        }

        .table:not(.table-dark) th {
            color: #ffffff;
        }

        .p-10 {
            padding: 10px !important;
        }

        .m-r-10 {
            margin-right: 10px !important;
        }

        .childdata {
            display: none;
            background-color: #98fded;
        }

        .btn {
            font-size: 11px !important;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span>Open Admission </h4>
            <!-- Basic Bootstrap Table -->
            <div class="card">

                <div class="col-sm-12 col-md-12 p-10 m-r-10" style="text-align: right">
                    <?php if(Auth::user()->is_view_user == 0): ?>
                        <a href="<?php echo e(route('admissionlist.create')); ?>" class=" btn btn-round btn-info">Open Admission</a>
                    <?php endif; ?>
                </div>

                <div class="table-responsive ">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Session</th>
                                <th>Class Name</th>
                                <th>Version Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Number Of Student</th>
                                <th>Price</th>
                                <th>Status</th>
                                <?php if(Auth::user()->is_view_user == 0): ?>
                                    <th>Action</th>
                                <?php endif; ?>

                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <?php $__currentLoopData = $admissiondata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php echo e($loop->index + 1); ?>

                                    </td>
                                    <td>
                                        <?php echo e($admission->session->session_name); ?>

                                    </td>
                                    <td>
                                        <?php echo e($admission->class->class_name ?? ''); ?>

                                    </td>
                                    <td>
                                        <?php echo e($admission->version->version_name); ?>

                                    </td>
                                    <td>
                                        <?php echo e($admission->start_date); ?>

                                    </td>
                                    <td>
                                        <?php echo e($admission->end_date); ?>

                                    </td>
                                    <td>
                                        <?php echo e($admission->number_of_admission); ?>

                                    </td>
                                    <td>
                                        <?php echo e($admission->price); ?>

                                    </td>
                                    <td>
                                        <?php if($admission->status == 1): ?>
                                            Open
                                        <?php elseif($admission->status == 2): ?>
                                            Close
                                        <?php else: ?>
                                            Inactive
                                        <?php endif; ?>
                                    </td>
                                    <?php if(Auth::user()->is_view_user == 0): ?>
                                        <td>
                                            <div class="dropdown">
                                                <button gallery="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="bx bx-dots-vertical-rounded"></i></button>
                                                <div class="dropdown-menu" style="">
                                                    <?php if(Auth::user()->getMenu('admissionlist.edit', 'name')): ?>
                                                        <a class="dropdown-item edit"
                                                            href="<?php echo e(route('admissionlist.edit', $admission->id)); ?>"><i
                                                                class="bx bx-edit-alt me-1"></i> Edit</a>
                                                    <?php endif; ?>
                                                    <?php if(Auth::user()->getMenu('admissionlist.destroy', 'name') && $admission->start_date > date('Y-m-d')): ?>
                                                        <a class="dropdown-item delete"
                                                            data-url="<?php echo e(route('admissionlist.destroy', $admission->id)); ?>"
                                                            data-id="<?php echo e($admission->id); ?>" href="javascript:void(0);"><i
                                                                class="bx bx-trash me-1"></i> Delete</a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>
                    </table>

                </div>

            </div>
            <!-- Modal -->

        </div>
        <!-- / Content -->

        <div class="content-backdrop fade"></div>
    </div>
    <script notice="text/javascript">
        $(function() {

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/bafsdadmission.com/httpdocs/resources/views/admission/admission_open.blade.php ENDPATH**/ ?>