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
          <span class="text-muted fw-light">Dashboard /</span> House
       </h4>
       <div class="row mb-4">
          <!-- Browser Default -->
          <div class="col-md mb-4 mb-md-0">
             <div class="card">
                <h5 class="card-header">House List</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                      <thead>
                        <tr class="text-nowrap">
                          <th>#</th>
                          <th>House Name</th>
                          <th>Status</th>
                          <?php if(Auth::user()->is_view_user == 0): ?>
                          <th>Action</th>
                          <?php endif; ?>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                        <?php $__currentLoopData = $houses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $house): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr id="row<?php echo e($house->id); ?>">
                          <th scope="row"><?php echo e($key + 1); ?></th>
                          <td><?php echo e($house->house_name); ?></td>


                          <td>
                            <?php if($house->active == 1): ?>
                            Active
                            <?php elseif($house->active == 0): ?>
                            Inactive
                            <?php endif; ?>
                          </td>
                          <?php if(Auth::user()->is_view_user == 0): ?>
                          <td>
                            <div class="dropdown">
                                 <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>
                                 <div class="dropdown-menu" style="">
                                     <a class="dropdown-item edit"
                                     data-id="<?php echo e($house->id); ?>"
                                     data-house_name="<?php echo e($house->house_name); ?>"
                                     data-active="<?php echo e($house->active); ?>"
                                     href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                     <a class="dropdown-item delete" data-url="<?php echo e(route('house.destroy', $house->id)); ?>" data-id="<?php echo e($house->id); ?>"  href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
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
        <h5 class="card-header">House Entry</h5>
        <div class="card-body">
            <form class="needs-validation" method="post" action="<?php echo e(route('house.store')); ?>" novalidate=""
                id="formsubmit">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" id="id" value="0" />
                <div class="mb-3">
                    <label class="form-label" for="bs-name">House Name</label>
                    <input type="text" class="form-control" name="house_name" id="house_name" placeholder="House Name"
                        required="">
                    <div class="valid-feedback"> Looks good! </div>
                    <div class="invalid-feedback"> Please enter House Name. </div>
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
                var house_name = $(this).data('house_name');
                var active = $(this).data('active');
                $('#id').val(id);
                $('#house_name').val(house_name);
                $('#active').val(active);
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

<?php echo $__env->make('admin.layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/kgadmission/resources/views/setting/house.blade.php ENDPATH**/ ?>