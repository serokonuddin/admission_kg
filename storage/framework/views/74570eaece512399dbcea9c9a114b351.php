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
          <span class="text-muted fw-light">Dashboard /</span> Academic Info
       </h4>
       <div class="row mb-4">
          <!-- Browser Default -->
          
          <!-- /Browser Default -->
          <!-- Bootstrap Validation -->
          <div class="col-md">
            <div class="card">
                <h5 class="card-header">Academic Info</h5>
                <div class="card-body">
                    <form class="needs-validation" method="post" action="<?php echo e(route('academyinfos.store')); ?>" novalidate=""
                        id="formsubmit">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="id" id="id" value="0" />
                        <div class="mb-3">
                            <label class="form-label" for="bs-name">Academy Name</label>
                            <input type="text" class="form-control" name="academy_name" id="academy_name" value="<?php echo e($AcademyInfo->academy_name); ?>" placeholder="Academy Name"
                                required="">
                            <div class="valid-feedback"> Looks good! </div>
                            <div class="invalid-feedback"> Please enter Academy Name. </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="bs-code">Short Name</label>
                            <input type="text" class="form-control" name="short_name" id="short_name" value="<?php echo e($AcademyInfo->short_name); ?>" placeholder="Short Name"
                                required="">
                            <div class="valid-feedback"> Looks good! </div>
                            <div class="invalid-feedback"> Please enter Short Name. </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label" for="bs-code">EIIN</label>
                            <input type="text" class="form-control" name="eiin" id="eiin" value="<?php echo e($AcademyInfo->eiin); ?>" placeholder="Email"
                                required="">
                            <div class="valid-feedback"> Looks good! </div>
                            <div class="invalid-feedback"> Please enter EIIN Name. </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="bs-code">Established Year</label>
                            <input type="text" class="form-control" name="established_year" id="established_year" value="<?php echo e($AcademyInfo->established_year); ?>" placeholder="Established Year"
                                required="">
                            <div class="valid-feedback"> Looks good! </div>
                            <div class="invalid-feedback"> Please enter Established Year. </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="bs-code">Email</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo e($AcademyInfo->email); ?>"
                                required="">
                            <div class="valid-feedback"> Looks good! </div>
                            <div class="invalid-feedback"> Please enter Email. </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="bs-code">Phone Number</label>
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone Number" value="<?php echo e($AcademyInfo->phone); ?>"
                                required="">
                            <div class="valid-feedback"> Looks good! </div>
                            <div class="invalid-feedback"> Please enter Phone Number. </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="bs-code">Helpline Number</label>
                            <input type="text" class="form-control" name="helpline_number" id="helpline_number" value="<?php echo e($AcademyInfo->helpline_number); ?>" placeholder="Helpline Number"
                                required="">
                            <div class="valid-feedback"> Looks good! </div>
                            <div class="invalid-feedback"> Please enter Helpline Number. </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="bs-code">Payment transfer bank account number</label>
                            <input type="text" class="form-control" name="bank_account" id="bank_account" value="<?php echo e($AcademyInfo->bank_account); ?>" placeholder="Payment transfer bank account number"
                                required="">
                            <div class="valid-feedback"> Looks good! </div>
                            <div class="invalid-feedback"> Please enter Payment transfer bank account number. </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="bs-Address">Address</label>
                            <input type="text" class="form-control" name="address" id="address" value="<?php echo e($AcademyInfo->address); ?>" placeholder="Address"
                                required="">
                            <div class="valid-feedback"> Looks good! </div>
                            <div class="invalid-feedback"> Please enter Address. </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="bs-Address">Logo</label>
                            <input type="file" class="form-control" name="logo" id="logo" value="<?php echo e($AcademyInfo->logo); ?>" placeholder="logo"
                                required="">
                            <div class="valid-feedback"> Looks good! </div>
                            <div class="invalid-feedback"> Please upload Logo. </div>
                            <input type="hidden" class="form-control" name="logo_old" id="logo_old" value="<?php echo e($AcademyInfo->logo); ?>" placeholder="logo"
                                >
                        </div>
                        <div class="col-md-6 mb-3">
                            <img src="<?php echo e(asset($AcademyInfo->logo)); ?>" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="bs-Address">Logo Icon</label>
                            <input type="file" class="form-control" name="icon" id="icon" value="<?php echo e($AcademyInfo->icon); ?>" placeholder="Logo Icon"
                                required="">
                            <div class="valid-feedback"> Looks good! </div>
                            <div class="invalid-feedback"> Please upload Logo Icon. </div>
                            <input type="hidden" class="form-control" name="icon_old" id="icon_old" value="<?php echo e($AcademyInfo->icon); ?>" placeholder="Logo Icon"
                                >
                        </div>
                        <div class="col-md-6 mb-3">
                            <img src="<?php echo e(asset($AcademyInfo->icon)); ?>" />
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
                var branch_name = $(this).data('branch_name');
                var branch_code = $(this).data('branch_code');
                var active = $(this).data('active');
                var address = $(this).data('address');
                $('#id').val(id);
                $('#branch_name').val(branch_name);
                $('#branch_code').val(branch_code);
                $('#active').val(active);
                $('#address').val(address);
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
            $(document.body).on('click', '.edit', function() {
                var id = $(this).data('id');
                var branch_name = $(this).data('branch_name');
                var branch_code = $(this).data('branch_code');
                var active = $(this).data('active');
                $('#id').val(id);
                $('#branch_name').val(branch_name);
                $('#branch_code').val(branch_code);
                $('#active').val(active);
                $('#submit').text('Update');
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/kgadmission/resources/views/setting/academic_info.blade.php ENDPATH**/ ?>