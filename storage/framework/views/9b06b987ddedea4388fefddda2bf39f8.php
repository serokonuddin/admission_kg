<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?php echo e(route('users.index')); ?>">Users</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"> Create</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <h5 class="card-header">User Information</h5>
                        <!-- Account -->
                        <div class="card-body">
                            <form id="formAccountSettings" method="POST" action="<?php echo e(route('users.store')); ?>">

                                <input type="hidden" name="_token" id="csrf-token" value="<?php echo e(Session::token()); ?>" />
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label for="name" class="form-label">Name</label>
                                        <input value="<?php echo e(old('name')); ?>" type="text" class="form-control"
                                            name="name" placeholder="Name" value="<?php echo e(isset($user) ? $user->name : ''); ?>"
                                            required>

                                        <?php if($errors->has('name')): ?>
                                            <span class="text-danger text-left"><?php echo e($errors->first('name')); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="email" class="form-label">Email</label>
                                        <input value="<?php echo e(old('email')); ?>" type="email" class="form-control"
                                            name="email" placeholder="Email address"
                                            value="<?php echo e(isset($user) ? $user->email : ''); ?>" required>
                                        <?php if($errors->has('email')): ?>
                                            <span class="text-danger text-left"><?php echo e($errors->first('email')); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input value="<?php echo e(old('phone')); ?>" type="text" class="form-control"
                                            name="phone" placeholder="phone"
                                            value="<?php echo e(isset($user) ? $user->phone : ''); ?>" required>
                                        <?php if($errors->has('phone')): ?>
                                            <span class="text-danger text-left"><?php echo e($errors->first('phone')); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="password" class="form-label">Password</label>
                                        <input value="<?php echo e(old('password')); ?>" type="text" class="form-control"
                                            name="password" placeholder="password" required>
                                        <?php if($errors->has('password')): ?>
                                            <span class="text-danger text-left"><?php echo e($errors->first('password')); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="mb-3">
                                        <label for="group_id" class="form-label">Role</label>
                                        <select class="form-control" name="group_id" required>
                                            <option value="">Select role</option>
                                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($role->id); ?>"
                                                    <?php echo e(in_array($role->name, $userRole) ? 'selected' : ''); ?>>
                                                    <?php echo e($role->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php if($errors->has('group_id')): ?>
                                            <span class="text-danger text-left"><?php echo e($errors->first('group_id')); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="inputPhoto" class="col-form-label">Photo <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control" type="file"
                                            onchange="loadFile(event,'photo_preview')" id="photo" name="photo">
                                        <span style="color: rgb(0,149,221)">(File size max 200 KB)</span>
                                        <div class="mb-3 col-md-12">
                                            <img src="<?php echo e($user->photo ?? ''); ?>" id="photo_preview"
                                                style="height: 100px; width: 100px;" />
                                        </div>
                                        <?php if($errors->has('photo')): ?>
                                            <span class="text-danger text-left"><?php echo e($errors->first('photo')); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end align-items-center">
                                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                                    <a href="<?php echo e(route('users.index')); ?>" type="button" class="btn btn-secondary">Back</a>
                                </div>
                            </form>
                        </div>
                        <!-- /Account -->
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->
        <div class="content-backdrop fade"></div>
    </div>
    <script type="text/javascript">
        var loadFile = function(event, preview) {

            var sizevalue = (event.target.files[0].size);

            if (sizevalue > 200000) {

                Swal.fire({
                    title: "warning!",
                    text: "File Size Too Large",
                    icon: "warning"
                });
                var idvalue = preview.slice(0, -8);

                $('#' + idvalue).val('');
                return false;
            } else {
                var output = document.getElementById(preview);
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function() {
                    URL.revokeObjectURL(output.src) // free memory
                }
            }

        };

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/bafsdadmission.com/httpdocs/resources/views/users/create.blade.php ENDPATH**/ ?>