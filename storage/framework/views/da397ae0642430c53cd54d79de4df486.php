<?php $__env->startSection('content'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/backend')); ?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="<?php echo e(asset('public/backend')); ?>/assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="<?php echo e(asset('public/backend')); ?>/assets/vendor/libs/bootstrap-select/bootstrap-select.css" />
    <link rel="stylesheet" href="<?php echo e(asset('public/backend')); ?>/assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="<?php echo e(asset('public/backend')); ?>/assets/vendor/libs/flatpickr/flatpickr.css" />
    <link rel="stylesheet" href="<?php echo e(asset('public/backend')); ?>/assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="<?php echo e(asset('public/backend')); ?>/assets/vendor/libs/tagify/tagify.css" />
    <link rel="stylesheet"
        href="<?php echo e(asset('public/backend')); ?>/assets/vendor/libs/@form-validation/umd/styles/index.min.css" />
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
       <h4 class="py-3 mb-4">
          <span class="text-muted fw-light">Dashboard /</span> Class
       </h4>
       <div class="row mb-4">
          <!-- Browser Default -->
          <div class="col-md mb-4 mb-md-0">
             <div class="card">
                <h5 class="card-header">Class List</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                      <thead>
                        <tr class="text-nowrap">
                          <th>#</th>
                          <th>Class Name</th>
                          <th>Class For</th>
                          <th>Shift</th>
                          <th>Active</th>
                          <?php if(Auth::user()->is_view_user == 0): ?>
                          <th>Action</th>
                          <?php endif; ?>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                        <?php $__currentLoopData = $classvalue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $classdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr id="row<?php echo e($classdata->id); ?>">
                          <th scope="row"><?php echo e($key + 1); ?></th>
                          <td><?php echo e($classdata->class_name); ?></td>
                          <td>
                            <?php if($classdata->class_for == 1): ?>
                            Primary
                            <?php elseif($classdata->class_for == 2): ?>
                            Secondary
                            <?php elseif($classdata->class_for == 3): ?>
                            Collage
                            <?php elseif($classdata->class_for == 4): ?>
                            University
                            <?php elseif($classdata->class_for == 5): ?>
                            English Medium
                            <?php endif; ?>
                          </td>
                          <td><?php echo e($classdata->shift->shift_name ?? ''); ?></td>
                          <td>
                            <?php if($classdata->active == 1): ?>
                            Active
                            <?php elseif($classdata->active == 0): ?>
                            Inactive
                            <?php endif; ?>
                          </td>
                          <?php if(Auth::user()->is_view_user == 0): ?>
                          <td>
                            <div class="dropdown">
                                 <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>
                                 <div class="dropdown-menu" style="">
                                     <a class="dropdown-item edit"
                                     data-id="<?php echo e($classdata->id); ?>"
                                     data-class_name="<?php echo e($classdata->class_name); ?>"
                                     data-class_code="<?php echo e($classdata->class_code); ?>"
                                     data-active="<?php echo e($classdata->active); ?>"
                                     data-shift_id="<?php echo e($classdata->shift_id); ?>"
                                     data-class_for="<?php echo e($classdata->class_for); ?>"
                                     data-version_id="<?php echo e($classdata->version_id); ?>"
                                     href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                     <a class="dropdown-item delete" data-url="<?php echo e(route('classes.destroy', $classdata->id)); ?>" data-id="<?php echo e($classdata->id); ?>"  href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
                                 </div>
                             </div>
                           </td>
                          <?php endif; ?>
                        </tr> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </tbody>
                    </table>
                  </div>
             </div>
          </div>
          <!-- /Browser Default -->
          <!-- Bootstrap Validation -->
          <div class="col-md">
    <div class="card">
        <h5 class="card-header">Class Entry</h5>
        <div class="card-body">
            <form class="needs-validation" method="post" action="<?php echo e(route('classes.store')); ?>" novalidate=""
                id="formsubmit">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" id="id" value="0" />
                <div class="mb-3">
                    <label class="form-label" for="bs-validation-name">Class Name</label>
                    <input type="text" class="form-control" name="class_name" id="class_name" placeholder="Class Name"
                        required="">
                    <div class="valid-feedback"> Looks good! </div>
                    <div class="invalid-feedback"> Please enter Class Name. </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="bs-validation-name">Class Code</label>
                    <input type="text" class="form-control" name="class_code" id="class_code" placeholder="Class Code"
                        required="">
                    <div class="valid-feedback"> Looks good! </div>
                    <div class="invalid-feedback"> Please enter Class Code. </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="bs-Session For">Class For</label>
                    <select class="form-select" name="class_for" id="class_for" required="">
                        <option value="">Select Class For</option>
                        <option value="1">Primary</option>
                        <option value="2">Secondary</option>
                        <option value="3">Collage</option>
                        <option value="5">English Medium</option>
                        


                    </select>
                    <div class="valid-feedback"> Looks good! </div>
                    <div class="invalid-feedback"> Please select Session For </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="bs-Active">Version</label>
                    <select class="form-select" name="version_id" id="version_id" required="">
                        <option value="">Select Version</option>
                        <?php $__currentLoopData = $versions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $version): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($version->id); ?>"><?php echo e($version->version_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                    </select>
                    <div class="valid-feedback"> Looks good! </div>
                    <div class="invalid-feedback"> Please select Active </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="bs-Active">Shift</label>
                    <select class="form-select" name="shift_id" id="shift_id" required="">
                        <option value="">Select Shift</option>
                        <?php $__currentLoopData = $shifts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shift): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($shift->id); ?>"><?php echo e($shift->shift_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                    </select>
                    <div class="valid-feedback"> Looks good! </div>
                    <div class="invalid-feedback"> Please select Active </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="bs-Active">Active</label>
                    <select class="form-select" name="active" id="active" required="">
                        <option value="">Select Active</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>

                    </select>
                    <div class="valid-feedback"> Looks good! </div>
                    <div class="invalid-feedback"> Please select Active </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <?php if(Auth::user()->is_view_user == 0): ?>
                            <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
    <!-- /Bootstrap Validation -->
    </div>

    </div>
    <!-- / Content -->

    <div class="content-backdrop fade"></div>
    </div>

    <script>
        <?php if($errors->any()): ?>

            Swal.fire({
                title: "Error",
                text: "<?php echo e(implode(',', $errors->all(':message'))); ?>",
                icon: "warning"
            });
        <?php endif; ?>
        <?php if(Session::get('success')): ?>

            Swal.fire({
                title: "Good job!",
                text: "<?php echo e(Session::get('success')); ?>",
                icon: "success"
            });
        <?php endif; ?>

        <?php if(Session::get('error')): ?>

            Swal.fire({
                title: "Error",
                text: "<?php echo e(Session::get('error')); ?>",
                icon: "warning"
            });
        <?php endif; ?>

        $(function() {
            $(document.body).on('click', '.edit', function() {
                var id = $(this).data('id');
                var class_name = $(this).data('class_name');
                var class_code = $(this).data('class_code');
                var active = $(this).data('active');
                var shift_id = $(this).data('shift_id');
                var version_id = $(this).data('version_id');
                var class_for = $(this).data('class_for');
                $('#id').val(id);
                $('#class_name').val(class_name);
                $('#class_code').val(class_code);
                $('#active').val(active);
                $('#shift_id').val(shift_id);
                $('#version_id').val(version_id);
                $('#class_for').val(class_for);
                $('#submit').text('Update');
            });


            $(document.body).on('click', '.delete', function() {
                var id = $(this).data('id');
                var url = $(this).data('url');
                $.ajax({
                    type: "delete",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "<?php echo e(csrf_token()); ?>"
                    },
                    success: function(response) {
                        if (response == 1) {
                            Swal.fire({
                                title: "Good job!",
                                text: "Deleted successfully",
                                icon: "success"
                            });
                            $('#row' + id).remove();
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: response,
                                icon: "warning"
                            });
                        }

                    },
                    error: function(data, errorThrown) {
                        Swal.fire({
                            title: "Error",
                            text: errorThrown,
                            icon: "warning"
                        });

                    }
                });
            });

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/bafsdadmission.com/httpdocs/resources/views/setting/classes.blade.php ENDPATH**/ ?>