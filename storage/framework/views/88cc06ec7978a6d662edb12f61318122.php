<?php if(Auth::user()->group_id!=3): ?>
<option value="">Select Section</option>
<?php endif; ?>
<?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<option value="<?php echo e($section->id); ?>" <?php echo e((Session::get('section_id')==$section->id)?'selected="selected"':''); ?>><?php echo e($section->section_name); ?></option>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /var/www/vhosts/bafsdadmission.com/httpdocs/resources/views/attendance/student/section.blade.php ENDPATH**/ ?>