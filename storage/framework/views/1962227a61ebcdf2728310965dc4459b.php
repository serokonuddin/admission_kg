<?php $__env->startSection('content'); ?>
<style>
   .form-check{
      border-bottom: 1px solid #eee;
      font-size: 15px;
      padding: 5px;
      
   }
   .form-check a{
      color: black!important;
   }
   .form-check a:hover{
      color: #337AB7!important;
      font-weight: bold;
   }
   .sidecourse-title a{
      font-size: 16px;
      font-weight: bold;
   }
</style>
<div class="spacet20" style="background: #fff;padding: 20px;">
   <div class="row">
      <div class="col-md-12 spacet60 pt-0-mobile">
         
         <!--./coursebtnaddModal-->
         <div class="row">
            <div class="container spaceb50">
               <div class="row">
                  
                  <!--./col-md-12-->
                  <div class="refine-categ-header">
                    <h3 style="text-align: center">College Admission (কলেজ ভর্তি): (<?php echo e(((int)$sessions->session_name.'-'.(int)$sessions->session_name+1)); ?>)</h3>
                    <p style="text-align: center; font-size: 18px">Admission Payment is Completed. Check Your Email or Phone number for login information And Fill up the necessary information for admission.</p><p style="text-align: center;font-size: 16px;"><a href="<?php echo e(url('login')); ?>" style="color: red">Login here to complete your admission application<br/><u>https://bafsdadmission/login</u></a></p>
                    <p style="text-align: center; font-size: 18px">লগইন তথ্যের জন্য আপনার ইমেল বা ফোন নম্বর চেক করুন এবং ভর্তির জন্য প্রয়োজনীয় তথ্য পূরণ করুন।</p><p style="text-align: center;font-size: 16px;"><a href="<?php echo e(url('login')); ?>" style="color: red">আপনার ভর্তির আবেদন সম্পূর্ণ করতে এখানে লগইন করুন<br/><u>https://bafsdadmission/login</u><span></a></p>
                  </div>
                  <!--./refine-categ-header--> 
               </div>
               <!--./row-->
            </div>
            <!--./container-->
         </div>
                    
      </div>
   </div>
   <!--./row-->
</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend-new.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/bafsdadmission.com/httpdocs/resources/views/frontend-new/sslredirect.blade.php ENDPATH**/ ?>