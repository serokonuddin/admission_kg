<!doctype html>
<html>

<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>BAF Shanheen College Dhaka</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo e(asset('css/backend_css/bootstrap.min.css')); ?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style type="text/css">
        a {
            text-decoration: none
        }

        body {
            /* font-family: 'NikoshBAN'; */
            font-size: 15px;
            /*font-size: 14px !important;*/
        }

        #bangla {
            font-family: 'NikoshBAN';
        }

        tr.sectorvaluefonts td span {

            /* font-family: 'NikoshBAN'; */
        }

        @page {
            header: page-header;
            footer: page-footer;
            sheet-size: A4;
            margin: 1.54cm 1.54cm 1.54cm 1.54cm;

        }

        table {
            /* font-family: "NikoshBAN"; */
            border: none;
            border-collapse: collapse;
            width: 100%;
            font-size: 15px;
        }

        th,
        td {
            padding: 1px !important;
            border: 1px solid #000;
            vertical-align: top;
        }

        th {
            text-align: center;
        }

        .fake {
            border: 0px;
            width: 0px !important;
            visibility: hidden;
            padding: 0px !important;
            font-size: 0px;
        }

        .no-subsector {
            border: 0px;
            visibility: hidden;
            padding: 0px !important;
            font-size: 0px !important;
            background-color: yellow;
        }

        div.fake {
            display: none !important;
            ;
            font-size: 0px !important;
        }


        .noboder {
            border: 0px;
            padding: 5px;
            font-weight: bold;
            font-size: 15px;

        }

        .sectorhide0 {
            border: 0px;
            width: 0px !important;
            visibility: hidden;
            padding: 0px !important;
        }

        .rahenrashi {
            font-family: 'NikoshBAN';
        }

        tr td {
            /* font-family: 'NikoshBAN'; */
        }
    </style>
    <?php
        $genders = [1 => 'Male', 2 => 'Female', 3 => 'Others'];
        $bloods = [1 => 'Islam', 2 => 'Hindu', 3 => 'christian', 4 => 'Buddhism', 5 => 'Others'];
    ?>
    <style>
        .table th,
        .table td {
            text-align: center !important;
            vertical-align: top !important;
            border-top: 1px solid #000 !important;
            border-left: 1px solid #000 !important;
        }

        .table td:last-child,
        .table th:last-child {
            border-right: 1px solid #000 !important;
        }

        .table tr:last-child {
            border-bottom: 1px solid #000 !important;
        }

        #projecttitle {
            text-align: left !important;
            padding-left: 5px !important;
        }

        .x-footer {
            width: 100%;
            border: 0 none !important;
            border-collapse: collapse;
        }

        .x-footer td {
            border: 0 none !important;
        }

        .nowrap {
            white-space: nowrap;
        }

        .head span {
            display: inline;
        }

        td {
            font-size: 15px !important;
            height: 30px !important;
        }
    </style>

</head>

<body>
    <div class="flex-center position-ref full-height">
        <table style="border:0px">
            <tr>
                <td style="width:13.33%;border:0px;text-align:left">
                    <img src="<?php echo e(asset('public/frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png')); ?>"
                        style="width: auto;height: 80px;" />
                </td>
                <td class="head" style="width:73.33%;border:0px;text-align:center;">
                    <h2 style="color: rgb(0,173,239)">BAF Shaheen College Dhaka</h2>
                    <span>Dhaka Cantonmnet, Dhaka-1206</span>
                    <br /><span>Web: www.bafsd.edu.bd</span><br />
                    <span>Email: info@bafsd.edu.bd</span>
                </td>
                <td style="width:13.33%;border:0px;text-align:right">
                    <img src="<?php echo e($student->photo ?? ''); ?>" id="photo_preview" style="height: 80px; width: auto" />
                </td>
            </tr>
        </table>
        <table style="border:0px">
            <tr>
                <td
                    style="width:100%;border:0px;font-size: 15pt;text-align:center;color: rgb(0,173,239);font-weight: bold">
                    Admission Form</td>

            </tr>
            <tr>
                <?php if($activity->class_id < 11): ?>
                    <td style="width:100%;border:0px;font-size: 13pt;text-align:center;"> (KG Admission:
                        <?php echo e($activity->session_id); ?>)</td>
                <?php else: ?>
                    <td style="width:100%;border:0px;font-size: 13pt;text-align:center;"> (College Admission:
                        <?php echo e($activity->session_id . '-' . ($activity->session_id + 1)); ?>)</td>
                <?php endif; ?>


            </tr>

        </table>
        <table style="border:0px;margin-top: 20px;">

            <tr styel="padding: 10px;">
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold">1.</td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;font-weight: bold">Student's Name
                    (English): <?php echo e($student->first_name ?? ''); ?>


                </td>
                <td class="rahenrashi" style="padding: 10px;width:48%;border:0px;font-size: 11pt;font-weight: bold">
                    Student's Name (Bangla): <?php echo e($student->bangla_name ?? ''); ?>



                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Date of Birth:
                    <?php echo e($student->birthdate ?? ''); ?>



                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Birth Registration No:
                    <?php echo e($student->birth_no ?? ''); ?>



                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Religion:
                    <?php echo e($bloods[$student->religion] ?? ''); ?></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Nationality:
                    <?php echo e($student->nationality ?? ''); ?>



                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">E-mail: <?php echo e($student->email ?? ''); ?>


                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Mobile: <?php echo e($student->mobile ?? ''); ?>

                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Gender:
                    <?php echo e($genders[$student->gender] ?? ''); ?></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Blood: <?php echo e($student->blood ?? ''); ?></td>
            </tr>
            <?php if($activity->classes->class_code == 11 || $activity->classes->class_code == 12): ?>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold">2.</td>
                    <td colspan="2" style="padding: 10px;width:96%;border:0px;font-size: 11pt;font-weight: bold">
                        Desired Subject (According to the college prospectus)</td>

                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">


                        COMPULSORY SUBJECTS:<br />
                        <?php $roman=[0=>'i',1=>'ii',2=>'iii',3=>'iv',4=>'v',5=>'vi',6=>'vii'];?>
                        <?php $__currentLoopData = $comsubjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e($roman[$loop->index]); ?>. <?php echo e($key); ?><br />
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <br />
                        GROUP SUBJECTS:<br />
                        <?php $__currentLoopData = $groupsubjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e($roman[$loop->index]); ?>. <?php echo e($key); ?><br />
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">ELECTIVE SUBJECT(S):<br />

                        <?php $__currentLoopData = $student_third_subject; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e($roman[$loop->index]); ?>. <?php echo e($key); ?><br />
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <br />
                        4TH SUBJECT:<br />
                        <?php $__currentLoopData = $student_fourth_subject; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e($roman[$loop->index]); ?>. <?php echo e($key); ?><br />
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold">3.</td>
                    <td colspan="2" style="padding: 10px;width:96%;border:0px;font-size: 11pt;font-weight: bold">
                        Secondary (SSC) Exam Details:</td>

                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Name of School:
                        <?php echo e($student->school_name ?? ''); ?>



                    </td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Upozila/Thana:
                        <?php echo e($student->thana ?? ''); ?>



                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Exam Center:
                        <?php echo e($student->exam_center ?? ''); ?>




                    </td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Roll Number:
                        <?php echo e($student->roll_number ?? ''); ?>

                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Registration Number:
                        <?php echo e($student->registration_number ?? ''); ?>



                    </td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Session:
                        <?php echo e($student->session ?? ''); ?>



                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Board's Name:
                        <?php echo e($student->board ?? ''); ?></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Year of Passing:
                        <?php echo e($student->passing_year ?? ''); ?>



                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">GPA: <?php echo e($student->result ?? ''); ?>



                    </td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">GPA without 4th subject:
                        <?php echo e($student->result_fourth_subject ?? ''); ?>



                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Total Marks:
                        <?php echo e($student->total_mark ?? ''); ?>



                    </td>
                </tr>
            <?php endif; ?>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold">3.</td>
                <td colspan="2" style="padding: 10px;width:96%;border:0px;font-size: 11pt;font-weight: bold">Parent's
                    Information:</td>

            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Father's Name:
                    <?php echo e($student->father_name ?? ''); ?>



                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Father's Email:
                    <?php echo e($student->father_email ?? ''); ?>



                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Father's Phone:
                    <?php echo e($student->father_phone ?? ''); ?>



                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Father's Profession:
                    <?php echo e($student->father_profession ?? ''); ?>




                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">FATHER'S NID NUMBER:
                    <?php echo e($student->father_nid_number ?? ''); ?>



                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">

                </td>
            </tr>

            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Mother's Name:
                    <?php echo e($student->mother_name ?? ''); ?>



                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Mother's Email:
                    <?php echo e($student->mother_email ?? ''); ?>



                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Mother's Phone:
                    <?php echo e($student->mother_phone ?? ''); ?>



                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Mother's Profession:
                    <?php echo e($student->mother_profession ?? ''); ?>



                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Mother'S NID NUMBER:
                    <?php echo e($student->mother_nid_number ?? ''); ?>



                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">

                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Parent's Income:
                    <?php echo e($student->parent_income ?? ''); ?>


                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">SMS Notificaton:
                    <?php echo e($student->sms_notification ?? ''); ?></td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold">4.</td>
                <td colspan="2" style="padding: 10px;width:96%;border:0px;font-size: 11pt;font-weight: bold">Address
                </td>

            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Present Address:
                    <?php echo e($student->present_addr ?? ''); ?>



                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Police Station:
                    <?php echo e($student->present_police_station ?? ''); ?>



                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Present District:
                    <?php echo e($student->present->name ?? ''); ?></td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Permanent Address:
                    <?php echo e($student->permanent_addr ?? ''); ?>



                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Police Station:
                    <?php echo e($student->permanent_police_station ?? ''); ?>



                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Permanent District:
                    <?php echo e($student->permanent->name ?? ''); ?></td>
            </tr>


            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold">5.</td>
                <td colspan="2" style="padding: 10px;width:96%;border:0px;font-size: 11pt;font-weight: bold">Local
                    Guardian</td>

            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Guardian Name:
                    <?php echo e($student->local_guardian_name ?? ''); ?>


                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Guardian Mobile:
                    <?php echo e($student->local_guardian_mobile ?? ''); ?>


                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Guardian Email:
                    <?php echo e($student->local_guardian_email ?? ''); ?>


                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Relation:
                    <?php echo e($student->student_relation ?? ''); ?>


                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Guardian Address:
                    <?php echo e($student->local_guardian_address ?? ''); ?>


                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Police Station:
                    <?php echo e($student->local_guardian_police_station ?? ''); ?>


                </td>
            </tr>

            <?php if($student->categoryid == 2): ?>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold">6.</td>
                    <td colspan="2" style="padding: 10px;width:96%;border:0px;font-size: 11pt;font-weight: bold">
                        Special Information for Force:</td>

                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
					<td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Category: <span>Son/daughter of
                            Armed Forces' Member</span>
                    </td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Service
                        Number:<?php echo e($student->service_number ?? ''); ?>

                    </td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Rank/Designation:
                        <?php echo e($student->designation ?? ''); ?>

                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Name: <?php echo e($student->name ?? ''); ?>



                    </td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">

                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Force Name:
                        <?php echo e($student->arms_name ?? ''); ?>



                    </td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Serving/Retired: <?php if($student->is_service): ?>
                            <?php echo e($student->is_service == 1 ? 'Serving' : 'Retired'); ?>

                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Office Address:
                        <?php echo e($student->office_address ?? ''); ?>



                    </td>
                </tr>
            <?php elseif($student->categoryid == 3): ?>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold">6.</td>
                    <td colspan="2" style="padding: 10px;width:96%;border:0px;font-size: 11pt;font-weight: bold">
                        Special information for Parent:</td>

                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">NAME OF THE
                        STAFF:<?php echo e($student->name_of_staff ?? ''); ?>


                    </td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">DESIGNATION:
                        <?php echo e($student->staff_designation ?? ''); ?>



                    </td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Category: <span>Son/daughter of
                            Teaching/Non-Teaching staff of BAFSD</span>


                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">STAFF ID:
                        <?php echo e($student->staff_id ?? ''); ?>


                    </td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">
                    </td>
                </tr>
            <?php else: ?>
               <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold">6.</td>
                    <td colspan="2" style="padding: 10px;width:96%;border:0px;font-size: 11pt;font-weight: bold">
                        Special information for Parent:</td>

                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Category: Civil
                    </td>
                </tr>
            <?php endif; ?>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold">7.</td>
                <td colspan="2" style="padding: 10px;width:96%;border:0px;font-size: 11pt;font-weight: bold">
                    Academic Information:</td>

            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Session:
                    <?php echo e($activity->session_id ?? ''); ?></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Version:
                    <?php echo e($activity->version->version_name ?? ''); ?></td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Shift:
                    <?php echo e($activity->shift->shift_name ?? ''); ?></td>
				<td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Group:
                    <?php echo e($activity->group->group_name ?? ''); ?></td>
				<!--
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Category:
                    <?php echo e($activity->category->category_name ?? ''); ?></td> -->
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">House:
                    <?php echo e($activity->house->house_name ?? ''); ?></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Class:
                    <?php echo e($activity->classes->class_name ?? ''); ?></td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Section:
                    <?php echo e($activity->section->section_name ?? ''); ?></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Roll: <?php echo e($activity->roll ?? ''); ?></td>
            </tr>
			<!--
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Group:
                    <?php echo e($activity->group->group_name ?? ''); ?></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;"></td>
            </tr> -->

        </table>




    </div>
    <htmlpagefooter name="page-footer">
        <table class="x-footer">

            <tr>
                <td style="width: 50%;text-align: left;"><?php echo e(date('d-m-Y H:s')); ?></td>
                <td style="text-align: right;"><?php echo app('translator')->get('Page'); ?> ({PAGENO}/{nb})</td>
            </tr>

        </table>


    </htmlpagefooter>
</body>

</html>
<?php /**PATH /var/www/vhosts/bafsdadmission.com/httpdocs/resources/views/print/details_view_student_print.blade.php ENDPATH**/ ?>