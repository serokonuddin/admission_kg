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
          <span class="text-muted fw-light">Dashboard /</span> Subject
       </h4>
       <div class="row mb-4">
          <!-- Browser Default -->
          <div class="col-md-12">
             <div class="card">
                <h5 class="card-header">Subject Entry</h5>
                <div class="card-body">
                   <form class="needs-validation" method="post" action="<?php echo e(route('subject.store')); ?>"  novalidate="" id="formsubmit">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id" id="id" value="0" />
                      <div class="mb-3">
                         <label class="form-label" for="bs-name">Subject Name</label>
                         <input type="text" class="form-control" name="subject_name"  id="subject_name" placeholder="Subject Name" required="">
                         <div class="valid-feedback"> Looks good! </div>
                         <div class="invalid-feedback"> Please enter Subject Name. </div>
                      </div>
                      <div class="mb-3">
                         <label class="form-label" for="bs-name">Subject Short Name</label>
                         <input type="text" class="form-control" name="short_subject"  id="short_subject" placeholder="Subject Name" required="">
                         <div class="valid-feedback"> Looks good! </div>
                         <div class="invalid-feedback"> Please enter Subject Short Name. </div>
                      </div>
                      <div class="mb-3">
                         <label class="form-label" for="bs-name">Subject Name Bn</label>
                         <input type="text" class="form-control" name="subject_name_bn"  id="subject_name_bn" placeholder="Subject Name Bn" required="">
                         <div class="valid-feedback"> Looks good! </div>
                         <div class="invalid-feedback"> Please enter Subject Name BN. </div>
                      </div>
                      <div class="mb-3">
                         <label class="form-label" for="bs-name">Parent Subject</label>
                         <input type="text" class="form-control" name="parent_subject"  id="parent_subject" placeholder="Subject Name" required="">
                         <div class="valid-feedback"> Looks good! </div>
                         <div class="invalid-feedback"> Please enter Parent Subject. </div>
                      </div>

                      <div class="mb-3">
                         <label class="form-label" for="bs-name">Publication</label>
                         <input type="text" class="form-control" name="publication"  id="publication" placeholder="Publication" required="">
                         <div class="valid-feedback"> Looks good! </div>
                         <div class="invalid-feedback"> Please enter Publication. </div>
                      </div>

                     <div class="mb-3">
                        <label class="form-label" for="bs-Address">Details</label>
                        <input type="text" class="form-control" name="details" id="details" placeholder="Details" >
                        
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
          <div class="col-md-12 mb-4 mb-md-0">
             <div class="card">
                <h5 class="card-header">Subject List</h5>
                <div class="table-responsive ">
                    <table class="table">
                      <thead>
                        <tr >
                          <th>#</th>
                          <th>Subject Name</th>
                          <th>Subject Name Bn</th>
                          <th>Group</th>
                          <th>Parent</th>
                          <th>Status</th>
                          <?php if(Auth::user()->is_view_user == 0): ?>
                          <th>Action</th>
                          <?php endif; ?>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                        <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr id="row<?php echo e($subject->id); ?>">
                          <th scope="row"><?php echo e($key + 1); ?></th>
                          <td style="word-wrap: break-word!important;"><?php echo e($subject->subject_name); ?></td>
                          <td style="word-wrap: break-word!important"><?php echo e($subject->subject_name_bn); ?></td>
                            <td style="word-wrap: break-word!important"></td>
                          <td style="word-wrap: break-word!important"><?php echo e($subject->parent_subject); ?></td>

                          <td>
                            <?php if($subject->active == 1): ?>
                            Active
                            <?php elseif($subject->active == 0): ?>
                            Inactive
                            <?php endif; ?>
                          </td>
                            <?php if(Auth::user()->is_view_user == 0): ?>
                            <td>
                                <div class="dropdown">
                                     <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>
                                     <div class="dropdown-menu" style="">
                                         <a class="dropdown-item edit"
                                         data-id="<?php echo e($subject->id); ?>"
                                         data-subject_name="<?php echo e($subject->subject_name); ?>"
                                         data-subject_name_bn="<?php echo e($subject->subject_name_bn); ?>"

                                         data-short_subject="<?php echo e($subject->short_subject); ?>"
                                         data-parent_subject="<?php echo e($subject->parent_subject); ?>"
                                         data-publication="<?php echo e($subject->publication); ?>"
                                         data-details="<?php echo e($subject->details); ?>"
                                         data-active="<?php echo e($subject->active); ?>"
                                         href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                         <a class="dropdown-item delete" data-url="<?php echo e(route('subject.destroy', $subject->id)); ?>" data-id="<?php echo e($subject->id); ?>"  href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
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

          <!-- /Bootstrap Validation -->
       </div>

    </div>
    <!-- / Content -->

    <div class="content-backdrop
        fade">
    </div>
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
        <?php if(Session::get('warning')): ?>

            Swal.fire({
                title: "Good job!",
                text: "<?php echo e(Session::get('success')); ?>",
                icon: "warning"
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
                var subject_name = $(this).data('subject_name');
                var subject_name_bn = $(this).data('subject_name_bn');
                var publication = $(this).data('publication');
                var details = $(this).data('details');
                var group_id = $(this).data('group_id');
                var short_subject = $(this).data('short_subject');
                var parent_subject = $(this).data('parent_subject');
                var is_main = $(this).data('ismain');
                var active = $(this).data('active');
                $('#id').val(id);
                $('#subject_name').val(subject_name);
                $('#subject_name_bn').val(subject_name_bn);
                $('#group_id').val(group_id);
                $('#short_subject').val(short_subject);
                $('#is_main').val(is_main);
                $('#parent_subject').val(parent_subject);
                $('#publication').val(publication);
                $('#details').val(details);
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

<?php echo $__env->make('admin.layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/bafsdadmission.com/httpdocs/resources/views/setting/subject.blade.php ENDPATH**/ ?>