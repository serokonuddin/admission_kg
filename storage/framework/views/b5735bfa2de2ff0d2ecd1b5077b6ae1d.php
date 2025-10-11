                <?php 
                        $gender=array(1=>'Male',2=>'Female',''=>'');
                  ?>
            <?php $__currentLoopData = $studentdata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-12 col-xl-4 col-md-6 " style="margin-top: 10px;">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="bg-label-primary rounded-3 text-center mb-4 pt-6">
                        <img class="img-fluid" src="<?php echo e(asset($student->photo)); ?>" alt="Card girl image" style="height: 100px;width: auto">
                        </div>
                        <h5 class="mb-2 text-center" style="color: red"><?php echo e($student->name_bn); ?></h5>
                        <h5 class="mb-2 text-center" style="color: orange">Mobile: <?php echo e($student->mobile); ?></h5>
                        
                        <div class="row mb-4 g-3">
                        <div class="col-12">
                            <div>
                                <h6 class="mb-0 "><strong>Gurdian Name:</strong> <?php echo e($student->gurdian_name??''); ?></h6>
                                <h6 class="mb-0 text-nowrap"><strong>DOB:</strong> <?php echo e($student->dob??''); ?></h6>
                                <h6 class="mb-0 text-nowrap"><strong>Birth Number:</strong> <?php echo e($student->birth_registration_number??''); ?></h6>
                                <h6 class="mb-0 text-nowrap"><strong>Gender:</strong> <?php echo e($gender[$student->gender]??''); ?></h6>
                                <h6 class="mb-0 text-nowrap"><strong>Serial No:</strong> <?php echo e($student->temporary_id??''); ?></h6>
                            </div>
                            </div>
                        </div>
                        
                        </div>
                    
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php /**PATH /var/www/html/kgadmission/resources/views/admission/ajaxlotterylist.blade.php ENDPATH**/ ?>