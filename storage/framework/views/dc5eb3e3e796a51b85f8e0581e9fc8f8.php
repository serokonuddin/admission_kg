<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Cards</title>
    <style>
        .id-card {
            width: 100%;
            text-align: center !important;
            margin-bottom: 0px;
            margin: 1px;
            padding: .5px;
            background-repeat: no-repeat;
            background-image: url("<?php echo e(public_path('logo/logob.png')); ?>");
            background-blend-mode: screen;
            background-size: 370px auto;
            background-position: center 165px;
        }



        .student-photo {
            border-radius: 5px;
            /* Border radius of 10px */
            border: 1px solid #2E3192;
            /* Optional border for visibility */
            height: 80px;

        }

        .header,
        .footer {
            text-align: center;
        }

        /* Styles for front and back of the ID */
        .college-info {
            text-align: center !important;
        }

        .college-info span {
            font-size: 11px !important;
            font-weight: bold;
            color: #000080;
            text-align: center;
        }

        .student-info h3 {
            font-size: 10px !important;
            color: #d32f2f;
        }

        .barcode-section {
            font-size: 10px !important;
            letter-spacing: 3px;
            font-family: 'Courier New', Courier, monospace;
        }

        .college-logo {
            width: 40px;
            height: auto;
        }

        .college-logo-back {
            width: 100px;
            height: auto;
        }

        td,
        p {
            line-height: 12px;
            font-size: 10px;
        }

        .p9 {
            /* line-height: 14px !important; */
            font-size: 9px !important;
        }

        .p7 {
            /* line-height: 11px !important; */
            font-size: 7.5px !important;
        }

        td {
            text-align: left !important;
        }

        .text-center {
            text-align: center !important;
        }

        .info-footer {
            background: #2E3192;
            height: 20px;
        }

        .page-break {
            page-break-after: always;
        }

        /* Avoid page break within a specific section */
        .no-break {
            page-break-inside: avoid;
        }

        .a4-page {}

        .logo {
            width: 40px;
            height: auto;
        }
    </style>
</head>

<body style="display: flex; justify-content: center; align-items: center; height: 100%;">
    
    <?php $__currentLoopData = $studentdata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $student = collect($student)->toArray();

        ?>
        
        <?php
        $first_name_length = strlen($student['first_name']);
        $local_guardian_length = strlen($student['local_guardian_name'] ?? ($student['father_name'] ?? $student['mother_name']));
        
        if ($first_name_length >= 22 && $local_guardian_length >= 27) {
            $marginTop = '0px'; // Both exceed their limits
            $headerMarginTop = '5px';
            $imageMarginTop = '5px';
        } elseif ($first_name_length >= 22) {
            $marginTop = '5px'; // Only first_name exceeds limit
            $headerMarginTop = '7px';
            $imageMarginTop = '10px';
        } elseif ($local_guardian_length >= 27) {
            $marginTop = '5px'; // Only local_guardian_name exceeds limit
            $headerMarginTop = '7px';
            $imageMarginTop = '10px';
        } else {
            $marginTop = '12px'; // Neither exceeds the limit
            $headerMarginTop = '10px';
            $imageMarginTop = '10px';
        }
        ?>
        <div class="a4-page">
            <div class="id-card">
                <div class="header" style="margin-top:  <?= $headerMarginTop ?>; padding-left: 2px;">
                    <table>
                        <tr>
                            <td><img src="<?php echo e(public_path('logo/logo.png')); ?>" alt="BAF Shaheen College Logo"
                                    class="logo" style="width: 35px; height: auto;"></td>
                            <td>
                                <div class="college-info" style="text-align: center;  font-family: freeserif">
                                    <p style="text-align: center;font-size:12.5px;">
                                        <strong>BAF Shaheen College Dhaka</strong>
                                    </p>
                                    <p class="text-center" style="color: #000; font-size: 9.5px;font-weight:bold">
                                        &nbsp;&nbsp;&nbsp;Dhaka
                                        Cantonment,
                                        Dhaka-1206</p>
                                    <p class="text-center" style="color: #000; font-size: 7.6px; font-weight:bold;">
                                        Email:
                                        info@bafsd.edu.bd ||
                                        Cell:
                                        01769975771</p>
                                </div>
                            </td>
                        </tr>
                    </table>

                </div>

                <div class="photo-section" style="text-align: center;margin-top: <?= $imageMarginTop ?>;">
                    <?php if($student['photo'] && File::exists(public_path(getRelativePath($student['photo'])))): ?>
                        <img src="<?php echo e(public_path(getRelativePath($student['photo']))); ?>" alt="Student Photo"
                            class="student-photo">
                    <?php else: ?>
                        <img src="<?php echo e(public_path('logo/logo.png')); ?>" alt="Student Photo" class="student-photo">
                    <?php endif; ?>
                    
                </div>




                <div style="padding: 2px .5px 2px 4px">
                    <div class="student-info" style="margin-top: 5px;text-align: center;">
                        <div
                            style="color: white;
                    padding: 3px;
                    background-color: red;
                    width: 140px;
                    margin-left: 27px;
                    font-size: 11px;
                    font-family: sans-serif">
                            <strong>Student ID: <?php echo e($student['student_code']); ?></strong>
                        </div>
                    </div>
                    <div class="student-info" style="margin-top: 5px;text-align: center;">

                        <p
                            style="text-align: center;font-size:12px;margin:0px;padding:3px; color: blue; font-family: sans-serif">
                            <strong><?php echo e(strtoupper($student['first_name'])); ?></strong>
                        </p>
                    </div>
                    <div style="font-size: 9px; margin-top: 5px;">
                        <div style="float:left; width:57%; text-align:left;">
                            <strong>&nbsp;Payment ID:</strong> <?php echo e($student['PID']); ?>

                        </div>
                        <div style="float:left; width:40%; text-align:left;">
                            <strong>Shift:</strong> <?php echo e($student['shift_id'] == 2 ? 'Day' : 'Morning'); ?>

                        </div>
                        <div style="clear:both;"></div>
                    </div>
                    <div style="font-size: 9px; margin-top: 5px;">
                        <div style="float:left; width:55%; text-align:left;">
                            <strong>&nbsp;Version:</strong> <?php echo e($student['version_id'] == 1 ? 'Bangla' : 'English'); ?>

                        </div>
                        <?php if($student['blood']): ?>
                            <div style="float:right; width:43%; text-align:left;">
                                <strong>Blood Group: <span style="color: red"><?php echo e($student['blood']); ?></span></strong>
                            </div>
                        <?php endif; ?>
                        <div style="clear:both;"></div>
                    </div>
                    <div style="font-size: 9px; margin-top: 4px;">
                        <div style="float:left; width:100%;text-align:left;">
                            <strong>&nbsp;Guardian:</strong>
                            <span
                                style="font-size: 9px; padding-left: 2px;"><?php echo e(ucwords(strtolower($student['local_guardian_name'] ?? ($student['father_name'] ?? $student['mother_name'])))); ?></span>
                        </div>
                        <div style="clear:both;"></div>
                    </div>
                    <div style="font-size: 9px; margin-top:  <?= $marginTop ?>;">

                        <div
                            style="float:left; width:65%; border:1px solid red; padding: 3px; margin-top:15px; border-radius: 3px; margin-left: 2px;">
                            <span style="font-weight: bold; font-size: 9px">
                                Validity till:
                                <?php if(in_array($student['class_code'], [9, 10])): ?>
                                    March
                                <?php elseif(in_array($student['class_code'], [11])): ?>
                                    June
                                <?php else: ?>
                                    Dec
                                <?php endif; ?>
                                <?php echo e(in_array($student['class_code'], [0, 3, 6, 9, 11])
                                    ? $student['session_id'] + 2
                                    : (in_array($student['class_code'], [1, 4, 7, 10])
                                        ? $student['session_id'] + 1
                                        : $student['session_id'])); ?>

                            </span>
                        </div>

                        <div style="float:right; width:25%; text-align:center; margin-top:-10px; margin-right: 2px;">
                            <img src="<?php echo e(public_path('psi.jpg')); ?>" alt="Signature"
                                style="height: 20px; margin: 0; padding: 0;">
                            <p style="margin: 0; padding: 0; border-top: 1px solid #000">Principal</p>
                        </div>
                        <div style="clear:both;"></div>
                    </div>
                </div>
                <div class="student-info"
                    style="text-align: center;margin-top: 2px; color: white;
                    padding: 2px .5px 2px 4px;
                    background-color: red;
                    font-size: 11px;
                    border-radius: 3px;
                    font-weight: bold;
                    font-family: sans-serif">
                    Emergency Call: <?php echo e($student['local_guardian_mobile'] ?? $student['sms_notification']); ?>

                </div>
            </div>

            
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    
</body>

</html>
<?php /**PATH /var/www/vhosts/bafsdadmission.com/httpdocs/resources/views/admission/cardnew.blade.php ENDPATH**/ ?>