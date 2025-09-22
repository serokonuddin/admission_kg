<?php $__env->startSection('content'); ?>

<!-- Display Messages -->
<?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<?php if(session('status')): ?>
    <div class="alert alert-success">
        <?php echo e(session('status')); ?>

    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="alert alert-danger">
        <?php echo e(session('error')); ?>

    </div>
<?php endif; ?>

<!-- Password Reset Form -->
<div class="modal-dialog modal-sm" role="document">
      <div class="modal-content shadow-lg" style="background: linear-gradient(45deg, #ff512f, #dd2476); border-radius: 15px;">
        <div class="app-brand justify-content-center mt-4 text-center" style="font-family: math">
          <h4 class="mb-3 text-center" style="color: #F0C24B; font-weight: bold">Set New Password</h4>
        </div>
        <div class="p-4">
          <form action="<?php echo e(route('password.reset.custom')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <!-- New Password Input -->
            <div class="form-group mb-3">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-lock text-primary"></i>
                </span>
                <input type="password" name="new_password" class="form-control" placeholder="New Password" required>
              </div>
            </div>
            
            <!-- Confirm Password Input -->
            <div class="form-group mb-3">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-lock text-primary"></i>
                </span>
                <input type="password" name="new_password_confirmation" class="form-control" placeholder="Confirm Password" required>
              </div>
            </div>
  
            <!-- Submit Button -->
            <div class="form-group">
              <button type="submit" class="btn btn-danger w-100 py-2 text-uppercase text-white" style="border-radius: 30px;">
                <span style="color: rgba(240, 194, 75, 1)">Reset Password</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  
  <?php $__env->stopSection(); ?>
  
<?php echo $__env->make('frontend-new.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/bafsdadmission.com/httpdocs/resources/views/auth/reset_password_form.blade.php ENDPATH**/ ?>