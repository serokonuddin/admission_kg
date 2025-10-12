<?php $__env->startSection('content'); ?>


 
<style>
       
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2!important;
        }
        /* .table-striped tr:nth-child(even) {
            background-color: #f9f9f9;
        } */
        .table-bordered th, .table-bordered td {
            border: 1px solid #000!important;
        }
        .table-no-bordered tr,.table-no-bordered,.table-no-bordered th,.table-no-bordered td, .table-no-bordered tbody {
            border: 0px solid #fff!important;
        }
        p{
            margin: 0px!important;
            padding: 0px!important;
        }
        .text-center{
            text-align: center!important;
        }
        .baf2 td,.baf3 td,.baf4 td{
            background-color: #00ADEF!important;
        }
        .baf1.shift1.version1 td{
            background-color: #FEF101!important;
        }
        .baf1.shift1.version2 td{
            background-color: orange!important;
        }
        .baf1.shift2.version1 td{
            background-color: rgb(190,144,212)!important;
        }
        .baf1.shift2.version2 td{
            background-color: #74A440!important;
        }
        .background-image{
            background-color: white;
        }
    </style>
<div class="container spacet20 background-image" >
   <div class="row">
      <div class="col-md-12 spacet60 pt-0-mobile" >
      <?php 
                                        $classroman=array(
                                            '0'=>'KG',
                                            '1'=>'I',
                                            '2'=>'II',
                                            '3'=>'III',
                                            '4'=>'IV',
                                            '5'=>'V',
                                            '6'=>'VI',
                                            '7'=>'VII',
                                            '8'=>'VIII',
                                            '9'=>'IX',
                                            '10'=>'X',
                                            '11'=>'XI',
                                            '12'=>'XII',
                                            ''=>'',
                                        );
                                        $category=array(
                                            1=>'Civil',
                                            2=>'BAF Employee',
                                            3=>'BAFSD Employee',
                                            4=>'GEN',
                                            ''=>''
                                        );
                                        function calculateAge($birthDate) {
                                            

                                            $birthDate = new DateTime($birthDate);
                                            $currentDate = new DateTime('2025-01-01');

                                            $ageDifference = $currentDate->diff($birthDate);

                                            $years = $ageDifference->y;
                                            $months = $ageDifference->m;
                                            $days = $ageDifference->d;

                                            return $years . " years, " . $months . " months, and " . $days . " days.";
                                        }
?>
        <table class="table table-striped table-no-bordered">
            <tr>
                <td style="width: 20%"></td>
                <td style="width: 55%;text-align:center">
                    <img style="width: 80px" src="<?php echo e(asset('public/frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png')); ?>" />
                    <h3 style="margin-top: 0px; margin-bottom: 4px; color:#0484BD; font-size:21px; font-weight:bold; white-space: nowrap;">BAF Shaheen College Dhaka</h3>
                        <span style="text-align:center; margin-top: 0px; margin-bottom: 0px; font-size:14px;">
                            Dhaka Cantonment, Dhaka-1206
                        </span>
                    
                </td>
                <td style="width: 25%;vertical-align: top;text-align: right">
                <?php if($student): ?>
                <img style="width: 100px;float: right;" src="<?php echo e(asset($student->photo)); ?>" />
                <?php endif; ?>
                </td>
            </tr>
        </table>
        <table class="table table-striped table-no-bordered">
            <tr>
                <td style="width: 30%;border: 2px solid #c0c0c0 !important;">
                <div style="font-weight: bold;font-size: 14px;padding: 10px;">
                &nbsp;&nbsp;Serial Number: <?php echo e($student->temporary_id??''); ?>&nbsp;&nbsp;
                </div>
                </td>
                <td style="width: 50%;">
                <h3  style="color:red; margin-top: 5px; margin-bottom: 0px; font-size:18px; font-weight:bold; white-space: nowrap;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Admit Card</h3>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;Class <?php echo e($classroman[$student->class_id??'']); ?>, Session: <?php echo e((int)$session->session_name+1); ?></p>
                </td>
                
            </tr>
        </table>
        <table class="table table-striped table-no-bordered baf<?php echo e($student->category_id??''); ?> shift<?php echo e($student->shift_id??''); ?> version<?php echo e($student->version_id??''); ?>">
            <tr style="border: 2px solid #c0c0c0 !important">
                <td class="text-center">Shift: <?php echo e(($student && $student->shift_id==1)?'Morning':'Day'); ?></td>
                <td class="text-center">Version: <?php echo e(($student && $student->version_id==1)?'Bangla':'English'); ?></td>
                <td class="text-center">Gender: <?php echo e(($student && $student->gender==1)?'Male':'Female'); ?></td>
                <td class="text-center">Category: <?php echo e($category[$student->category_id??'']); ?></td>
            </tr>
        </table>
        <table class="table table-striped table-no-bordered">
            
            <tbody>
                <tr style="border: 2px solid #c0c0c0 !important">
                    <td style="width:35%">Candidate's Name</td>
                    <td>: <?php echo e(($student)?strtoupper($student->name_en):''); ?></td>
                </tr>
                <tr style="border: 2px solid #c0c0c0 !important">
                    <td>Date Of Birth</td>
                    <td>: <?php echo e(date('d F Y',strtotime(($student->dob??'')))); ?></td>
                </tr>
                <tr style="border: 2px solid #c0c0c0 !important">
                    <td>Age</td>
                    <td>: <?php echo e(calculateAge(($student->dob??''))); ?></td>
                </tr>
                <tr style="border: 2px solid #c0c0c0 !important">
                    <td>Gurdian's Name</td>
                    <td>: <?php echo e($student->gurdian_name??''); ?></td>
                </tr>
                <tr style="border: 2px solid #c0c0c0 !important">
                    <td>Mobile Number</td>
                    <td>: <?php echo e($student->mobile??''); ?></td>
                </tr>
                <tr style="border: 2px solid #c0c0c0 !important">
                    <td>Candidate's Birth Registration Number</td>
                    <td>: <?php echo e($student->birth_registration_number??''); ?></td>
                </tr>
            </tbody>
        </table>
        <table class="table table-striped table-no-bordered " style="border: 2px solid #c0c0c0 !important">
            <tr >
                <td style="width:35%">
                
                    <?php if($student && in_array($student->category_id, [2,3,4])): ?>
                    Viva Date & Time
                    <?php elseif($student && $student->category_id==1 && $student->version_id==1): ?>
                    Lottery Date & Time
                    <?php elseif($student && $student->category_id==1 && $student->version_id==2): ?>
                    Lottery Date & Time
                    <?php endif; ?>
                </td>
                <td >:
                    <?php if($student && in_array($student->category_id, [2,3,4])): ?>
                    8th November, 10:00 AM
                    <?php elseif($student && $student->category_id==1 && $student->version_id==1): ?>
                    30th November 10:00 AM To 11:00 AM
                    <?php elseif($student && $student->category_id==1 && $student->version_id==2): ?>
                    30th November 12:00 AM To 01:00 PM
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td >Venue</td>
                <td >: Shaheen Hall, BAF Shaheen College Dhaka</td>
            </tr>
            <tr>
                <td colspan="2">N.B. Candidate must bring a printed color Admit Card at the time of Lottery & Viva</td>
            </tr>
        </table>
        <br/>
        <br/>
        <br/>
        <table class="table table-striped table-no-bordered ">
            <tr >
                <td style="float: right;padding:0px"></td>
                <td style="float: right;padding:0px;text-align: right" ><img src="<?php echo e(asset('public/psi.jpg')); ?>" style="width: 90px;" /></td>
            </tr>
            <tr >
                <td style="float: left;padding:0px">
                    <?php if($student): ?>
                    <a href="<?php echo e(url('admissionPrint/'.$student->temporary_id.'/0')); ?>" target="_blank" class="btn btn-primary findAdmitcard"  style="background-color: #00ADEF">Print Admit Card</a>
                    <a href="<?php echo e(url('admissionPrint/'.$student->temporary_id.'/1')); ?>" target="_blank" class="btn btn-primary findAdmitcard"  style="background-color: green">Save Admit Card</a>
                    <?php endif; ?>
                </td>
                <td style="float: right;padding:0px;font-size: 18px;font-weight: bold;text-align: right">Principal</td>
            </tr>
        </table>
        
         
      </div>
   </div>
   <!--./row-->
</div>


   
<script>
  

  <?php if(Session::get('success')): ?>
      
      Swal.fire({
         title: "Success",
         html: "<?php echo Session::get('success'); ?>",
         icon: "success"
      });
      
   <?php endif; ?>
 

   <?php if(Session::get('warning')): ?>
      
      Swal.fire({
         title: "Warning!",
         html: "<?php echo Session::get('warning'); ?>",
         icon: "warning"
      });
      
   <?php endif; ?>
   
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend-new.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/kgadmission/resources/views/frontend-new/admit-card.blade.php ENDPATH**/ ?>