<option value="">Select Class</option>
<?php $__currentLoopData = $classvalue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <option value="<?php echo e($class['class_code']); ?>"><?php echo e($class['class_name']); ?></option>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /var/www/vhosts/bafsdadmission.com/httpdocs/resources/views/setting/ajaxclasses.blade.php ENDPATH**/ ?>