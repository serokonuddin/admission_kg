<?php
    $genders = [1 => 'Male', 2 => 'Female', 3 => 'Others'];
    $bloods = [1 => 'Islam', 2 => 'Hindu', 3 => 'christian', 4 => 'Buddhism', 5 => 'Others'];
?>
<style>
    .font-bold {
        font-weight: bold !important;
    }

    input:read-only {
        background-color: #e3e3e3 !important;
    }

    .red {
        color: red;
        font-size: 20px;
        font-weight: bold;
        text-align: center;
    }
</style>

<?php echo csrf_field(); ?>
<input type="hidden" name="student_code" value="<?php echo e($student->student_code ?? ''); ?>" />
<input type="hidden" name="id" value="<?php echo e($student->id ?? ''); ?>" />
<input type="hidden" name="submit" value="2" />
<div class="row">
    <div class="col-xl-12">
        <table style="border:0px;">
            <tr styel="padding: 10px;">

                <td style="padding: 10px;width:10%;border:0px;font-size: 11pt;font-weight: bold;float: left"><img
                        src="<?php echo e(asset('public/logo/logo.png')); ?>" style="width: auto;height: 68px;"></td>
                <td>
                    <p class="red"> Please check the admission form for final correction than press the confirm
                        button given below.</p>
                </td>
                <td rowspan="2" style="padding: 10px;width:8%;border:0px;font-size: 11pt;font-weight: bold"> <img
                        src="<?php echo e($student->photo ?? ''); ?>" style="width: auto;height: 60px;" /></td>
            </tr>
        </table>
        <table style="border:0px;margin-top: 20px;">

            <tr styel="padding: 10px;">
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold">1.</td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;font-weight: bold">Student's Name
                    (English): <?php echo e($student->first_name ?? ''); ?>


                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;font-weight: bold">Student's Name
                    (Bangla):

                    <div class="input-group">
                        <input type="text" class="form-control" readonly="" name="bangla_name"
                            value="<?php echo e($student->bangla_name ?? ''); ?>" placeholder="Bangla Name">
                        <a href="javascript:void(0)" class="input-group-text edit-icon" data-forvalue="bangla_name"><i
                                class="fa fa-edit"></i></a>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Date of Birth:

                    <div class="input-group">
                        <input type="date" class="form-control" readonly="" name="birthdate"
                            value="<?php echo e($student->birthdate ?? ''); ?>" placeholder="birth date">
                        <a href="javascript:void(0)" class="input-group-text edit-icon" data-forvalue="birthdate"><i
                                class="fa fa-edit"></i></a>
                    </div>
                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Birth Registration No:

                    <div class="input-group">
                        <input type="number" class="form-control" readonly="" name="birth_no"
                            value="<?php echo e($student->birth_no ?? ''); ?>" placeholder="birth no">
                        <a href="javascript:void(0)" class="input-group-text edit-icon" data-forvalue="birth_no"><i
                                class="fa fa-edit"></i></a>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Religion:
                    <?php echo e($bloods[$student->religion] ?? ''); ?></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Nationality:

                    <div class="input-group">
                        <input type="text" class="form-control" readonly="" name="nationality"
                            value="<?php echo e($student->nationality ?? ''); ?>" placeholder="nationality">
                        <a href="javascript:void(0)" class="input-group-text edit-icon" data-forvalue="nationality"><i
                                class="fa fa-edit"></i></a>
                    </div>
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
                    <?php echo e($genders[$student->gender] ?? ''); ?>

                    <input type="hidden" value="<?php echo e($student->gender); ?>" name="gender" />

                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Blood: <?php echo e($student->blood ?? ''); ?></td>
            </tr>
            <?php if($activity->class_code == 11 || $activity->class_code == 12): ?>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold">2.</td>
                    <td colspan="2" style="padding: 10px;width:96%;border:0px;font-size: 11pt;font-weight: bold">
                        Desired Subject (According to the college prospectus)</td>

                </tr>

                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">
                        <?php $__currentLoopData = $comsubjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $ids = '';
                                foreach ($subject as $kye => $sub) {
                                    if ($kye == 0) {
                                        $ids = $sub->id;
                                    } else {
                                        $ids = $ids . '-' . $sub->id;
                                    }
                                }

                            ?>

                            <input type="hidden" name="mainsubject[]" value="<?php echo e($ids); ?>">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if($activity->group_id != 2): ?>
                            <?php $__currentLoopData = $groupsubjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $ids = '';
                                    foreach ($subject as $kye => $sub) {
                                        if ($kye == 0) {
                                            $ids = $sub->id;
                                        } else {
                                            $ids = $ids . '-' . $sub->id;
                                        }
                                    }

                                ?>

                                <input type="hidden" name="mainsubject[]" value="<?php echo e($ids); ?>">
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

                        <?php $__currentLoopData = $student_third_subject; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $ids = '';
                                foreach ($subject as $kye => $sub) {
                                    if ($kye == 0) {
                                        $ids = $sub->id;
                                    } else {
                                        $ids = $ids . '-' . $sub->id;
                                    }
                                }

                            ?>

                            <input type="hidden" name="third_subject[]" value="<?php echo e($ids); ?>">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php $__currentLoopData = $student_fourth_subject; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $ids = '';
                                foreach ($subject as $kye => $sub) {
                                    if ($kye == 0) {
                                        $ids = $sub->id;
                                    } else {
                                        $ids = $ids . '-' . $sub->id;
                                    }
                                }

                            ?>

                            <input type="hidden" name="fourth_subject[]" value="<?php echo e($ids); ?>">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

                        <div class="input-group">
                            <input type="text" class="form-control" readonly="" name="school_name"
                                value="<?php echo e($student->school_name ?? ''); ?>" placeholder="School Name">
                            <a href="javascript:void(0)" class="input-group-text edit-icon"
                                data-forvalue="school_name"><i class="fa fa-edit"></i></a>
                        </div>
                    </td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Upozila/Thana:

                        <div class="input-group">
                            <input type="text" class="form-control" readonly="" name="thana"
                                value="<?php echo e($student->thana ?? ''); ?>" placeholder="Thana">
                            <a href="javascript:void(0)" class="input-group-text edit-icon" data-forvalue="thana"><i
                                    class="fa fa-edit"></i></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Exam Center:


                        <div class="input-group">
                            <input type="text" class="form-control" readonly="" name="exam_center"
                                value="<?php echo e($student->exam_center ?? ''); ?>" placeholder="Exam Center">
                            <a href="javascript:void(0)" class="input-group-text edit-icon"
                                data-forvalue="exam_center"><i class="fa fa-edit"></i></a>
                        </div>
                    </td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Roll Number:
                        <?php echo e($student->roll_number ?? ''); ?>

                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Registration Number:

                        <div class="input-group">
                            <input type="number" class="form-control" readonly="" name="registration_number"
                                value="<?php echo e($student->registration_number ?? ''); ?>" placeholder="Registration Number">
                            <a href="javascript:void(0)" class="input-group-text edit-icon"
                                data-forvalue="registration_number"><i class="fa fa-edit"></i></a>
                        </div>
                    </td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Session:

                        <div class="input-group">
                            <input type="number" class="form-control" readonly="" name="session"
                                value="<?php echo e($student->session ?? ''); ?>" placeholder="session">
                            <a href="javascript:void(0)" class="input-group-text edit-icon"
                                data-forvalue="session"><i class="fa fa-edit"></i></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Board's Name:
                        <?php echo e($student->board ?? ''); ?></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Year of Passing:

                        <div class="input-group">
                            <input type="number" class="form-control" readonly="" name="passing_year"
                                value="<?php echo e($student->passing_year ?? ''); ?>" placeholder="passing year">
                            <a href="javascript:void(0)" class="input-group-text edit-icon"
                                data-forvalue="passing_year"><i class="fa fa-edit"></i></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">GPA:

                        <div class="input-group">
                            <input type="number" class="form-control" readonly="" name="result"
                                value="<?php echo e($student->result ?? ''); ?>" placeholder="result">
                            <a href="javascript:void(0)" class="input-group-text edit-icon" data-forvalue="result"><i
                                    class="fa fa-edit"></i></a>
                        </div>
                    </td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">GPA without 4th subject:

                        <div class="input-group">
                            <input type="number" class="form-control" readonly="" name="result_fourth_subject"
                                value="<?php echo e($student->result_fourth_subject ?? ''); ?>"
                                placeholder="GPA without 4th subject">
                            <a href="javascript:void(0)" class="input-group-text edit-icon"
                                data-forvalue="result_fourth_subject"><i class="fa fa-edit"></i></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Total Marks:

                        <div class="input-group">
                            <input type="number" class="form-control" readonly="" name="total_mark"
                                value="<?php echo e($student->total_mark ?? ''); ?>" placeholder="total mark">
                            <a href="javascript:void(0)" class="input-group-text edit-icon"
                                data-forvalue="total_mark"><i class="fa fa-edit"></i></a>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold">3.</td>
                <td colspan="2" style="padding: 10px;width:96%;border:0px;font-size: 11pt;font-weight: bold">
                    Parent's Information:</td>

            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Father's Name:

                    <div class="input-group">
                        <input type="text" class="form-control" readonly="" name="father_name"
                            value="<?php echo e($student->father_name ?? ''); ?>" placeholder="father name">
                        <a href="javascript:void(0)" class="input-group-text edit-icon"
                            data-forvalue="father_name"><i class="fa fa-edit"></i></a>
                    </div>
                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Father's Email:

                    <div class="input-group">
                        <input type="text" class="form-control" readonly="" name="father_email"
                            value="<?php echo e($student->father_email ?? ''); ?>" placeholder="father email">
                        <a href="javascript:void(0)" class="input-group-text edit-icon"
                            data-forvalue="father_email"><i class="fa fa-edit"></i></a>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Father's Phone:

                    <div class="input-group">
                        <input type="text" class="form-control" readonly="" name="father_phone"
                            value="<?php echo e($student->father_phone ?? ''); ?>" placeholder="father phone">
                        <a href="javascript:void(0)" class="input-group-text edit-icon"
                            data-forvalue="father_phone"><i class="fa fa-edit"></i></a>
                    </div>
                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Father's Profession:


                    <div class="input-group">
                        <input type="text" class="form-control" readonly="" name="father_profession"
                            value="<?php echo e($student->father_profession ?? ''); ?>" placeholder="father profession">
                        <a href="javascript:void(0)" class="input-group-text edit-icon"
                            data-forvalue="father_profession"><i class="fa fa-edit"></i></a>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">FATHER'S NID NUMBER:

                    <div class="input-group">
                        <input type="text" class="form-control" readonly="" name="father_nid_number"
                            value="<?php echo e($student->father_nid_number ?? ''); ?>" placeholder="FATHER'S NID NUMBER">
                        <a href="javascript:void(0)" class="input-group-text edit-icon" data-forvalue="father_nid"><i
                                class="fa fa-edit"></i></a>
                    </div>
                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">

                </td>
            </tr>

            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Mother's Name:

                    <div class="input-group">
                        <input type="text" class="form-control" readonly="" name="mother_name"
                            value="<?php echo e($student->mother_name ?? ''); ?>" placeholder="mother name">
                        <a href="javascript:void(0)" class="input-group-text edit-icon"
                            data-forvalue="mother_name"><i class="fa fa-edit"></i></a>
                    </div>
                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Mother's Email:

                    <div class="input-group">
                        <input type="text" class="form-control" readonly="" name="mother_email"
                            value="<?php echo e($student->mother_email ?? ''); ?>" placeholder="mother email">
                        <a href="javascript:void(0)" class="input-group-text edit-icon"
                            data-forvalue="mother_email"><i class="fa fa-edit"></i></a>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Mother's Phone:


                    <div class="input-group">
                        <input type="text" class="form-control" readonly="" name="mother_phone"
                            value="<?php echo e($student->mother_phone ?? ''); ?>" placeholder="mother phone">
                        <a href="javascript:void(0)" class="input-group-text edit-icon"
                            data-forvalue="mother_phone"><i class="fa fa-edit"></i></a>
                    </div>
                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Mother's Profession:

                    <div class="input-group">
                        <input type="text" class="form-control" readonly="" name="mother_profession"
                            value="<?php echo e($student->mother_profession ?? ''); ?>" placeholder="mother profession">
                        <a href="javascript:void(0)" class="input-group-text edit-icon"
                            data-forvalue="mother_profession"><i class="fa fa-edit"></i></a>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Mother'S NID NUMBER:

                    <div class="input-group">
                        <input type="text" class="form-control" readonly="" name="mother_nid_number"
                            value="<?php echo e($student->mother_nid_number ?? ''); ?>" placeholder="Mother'S NID NUMBER">
                        <a href="javascript:void(0)" class="input-group-text edit-icon" data-forvalue="mother_nid"><i
                                class="fa fa-edit"></i></a>
                    </div>
                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">

                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Parent's Income:
                    <div class="input-group">
                        <input type="number" class="form-control" readonly="" name="parent_income"
                            value="<?php echo e($student->parent_income ?? ''); ?>" placeholder="parent income">
                        <a href="javascript:void(0)" class="input-group-text edit-icon"
                            data-forvalue="parent_income"><i class="fa fa-edit"></i></a>
                    </div>
                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">SMS Notificaton:
                    <?php echo e($student->sms_notification ?? ''); ?></td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold">4.</td>
                <td colspan="2" style="padding: 10px;width:96%;border:0px;font-size: 11pt;font-weight: bold">
                    Address</td>

            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Present Address:

                    <div class="input-group">
                        <input type="text" class="form-control" readonly="" name="present_addr"
                            value="<?php echo e($student->present_addr ?? ''); ?>" placeholder="present addr">
                        <a href="javascript:void(0)" class="input-group-text edit-icon"
                            data-forvalue="present_addr"><i class="fa fa-edit"></i></a>
                    </div>
                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Police Station:

                    <div class="input-group">
                        <input type="text" class="form-control" readonly="" name="present_police_station"
                            value="<?php echo e($student->present_police_station ?? ''); ?>" placeholder="present police station">
                        <a href="javascript:void(0)" class="input-group-text edit-icon"
                            data-forvalue="present_police_station"><i class="fa fa-edit"></i></a>
                    </div>
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
                    <div class="input-group">
                        <input type="text" class="form-control" readonly="" name="permanent_addr"
                            value="<?php echo e($student->permanent_addr ?? ''); ?>" placeholder="permanent addr">
                        <a href="javascript:void(0)" class="input-group-text edit-icon"
                            data-forvalue="permanent_addr"><i class="fa fa-edit"></i></a>
                    </div>

                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Police Station:

                    <div class="input-group">
                        <input type="text" class="form-control" readonly="" name="permanent_police_station"
                            value="<?php echo e($student->permanent_police_station ?? ''); ?>"
                            placeholder="permanent police station">
                        <a href="javascript:void(0)" class="input-group-text edit-icon"
                            data-forvalue="permanent_police_station"><i class="fa fa-edit"></i></a>
                    </div>
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
                    <div class="input-group">
                        <input type="text" class="form-control" readonly="" name="local_guardian_name"
                            value="<?php echo e($student->local_guardian_name ?? ''); ?>" placeholder="Guardian Name">
                        <a href="javascript:void(0)" class="input-group-text edit-icon"
                            data-forvalue="local_guardian_name"><i class="fa fa-edit"></i></a>
                    </div>
                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Guardian Mobile:
                    <div class="input-group">
                        <input type="text" class="form-control" readonly="" name="local_guardian_mobile"
                            value="<?php echo e($student->local_guardian_mobile ?? ''); ?>" placeholder="Guardian Mobile">
                        <a href="javascript:void(0)" class="input-group-text edit-icon"
                            data-forvalue="local_guardian_mobile"><i class="fa fa-edit"></i></a>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Guardian Email:
                    <div class="input-group">
                        <input type="text" class="form-control" readonly="" name="local_guardian_email"
                            value="<?php echo e($student->local_guardian_email ?? ''); ?>" placeholder="Guardian Email">
                        <a href="javascript:void(0)" class="input-group-text edit-icon"
                            data-forvalue="local_guardian_email"><i class="fa fa-edit"></i></a>
                    </div>
                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Relation:
                    <div class="input-group">
                        <input type="text" class="form-control" readonly="" name="student_relation"
                            value="<?php echo e($student->student_relation ?? ''); ?>" placeholder="Relation">
                        <a href="javascript:void(0)" class="input-group-text edit-icon"
                            data-forvalue="student_relation"><i class="fa fa-edit"></i></a>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Guardian Address:
                    <div class="input-group">
                        <input type="text" class="form-control" readonly="" name="local_guardian_address"
                            value="<?php echo e($student->local_guardian_address ?? ''); ?>" placeholder="Guardian Address">
                        <a href="javascript:void(0)" class="input-group-text edit-icon"
                            data-forvalue="local_guardian_address"><i class="fa fa-edit"></i></a>
                    </div>
                </td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Police Station:
                    <div class="input-group">
                        <input type="text" class="form-control" readonly=""
                            name="local_guardian_police_station"
                            value="<?php echo e($student->local_guardian_police_station ?? ''); ?>" placeholder="Police Station">
                        <a href="javascript:void(0)" class="input-group-text edit-icon"
                            data-forvalue="local_guardian_police_station"><i class="fa fa-edit"></i></a>
                    </div>
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
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Service Number:
                        <div class="input-group">
                            <input type="text" class="form-control" readonly="" name="service_number"
                                value="<?php echo e($student->service_number ?? ''); ?>" placeholder="Service Number">
                            <a href="javascript:void(0)" class="input-group-text edit-icon"
                                data-forvalue="service_number"><i class="fa fa-edit"></i></a>
                        </div>
                    </td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Designation:

                        <div class="input-group">
                            <input type="text" class="form-control" readonly="" name="designation"
                                value="<?php echo e($student->designation ?? ''); ?>" placeholder="designation">
                            <a href="javascript:void(0)" class="input-group-text edit-icon"
                                data-forvalue="designation"><i class="fa fa-edit"></i></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Name:

                        <div class="input-group">
                            <input type="text" class="form-control" readonly="" name="name"
                                value="<?php echo e($student->name ?? ''); ?>" placeholder="Name">
                            <a href="javascript:void(0)" class="input-group-text edit-icon" data-forvalue="name"><i
                                    class="fa fa-edit"></i></a>
                        </div>
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
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">
                        <?php if($student->is_service == 1): ?>
                            Office Address:

                            <div class="input-group">
                                <input type="text" class="form-control" readonly="" name="office_address"
                                    value="<?php echo e($student->office_address ?? ''); ?>" placeholder="office address">
                                <a href="javascript:void(0)" class="input-group-text edit-icon"
                                    data-forvalue="office_address"><i class="fa fa-edit"></i></a>
                            </div>
                        <?php endif; ?>
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
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">NAME OF THE STAFF:
                        <div class="input-group">
                            <input type="text" class="form-control" readonly="" name="name_of_staff"
                                value="<?php echo e($student->name_of_staff ?? ''); ?>" placeholder="NAME OF THE STAFF">
                            <a href="javascript:void(0)" class="input-group-text edit-icon"
                                data-forvalue="name_of_staff"><i class="fa fa-edit"></i></a>
                        </div>
                    </td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">DESIGNATION:

                        <div class="input-group">
                            <input type="text" class="form-control" readonly="" name="staff_designation"
                                value="<?php echo e($student->staff_designation ?? ''); ?>" placeholder="designation">
                            <a href="javascript:void(0)" class="input-group-text edit-icon"
                                data-forvalue="staff_designation"><i class="fa fa-edit"></i></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">STAFF ID:

                        <div class="input-group">
                            <input type="text" class="form-control" readonly="" name="staff_id"
                                value="<?php echo e($student->staff_id ?? ''); ?>" placeholder="staff id">
                            <a href="javascript:void(0)" class="input-group-text edit-icon"
                                data-forvalue="staff_id"><i class="fa fa-edit"></i></a>
                        </div>
                    </td>
                    <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">
                    </td>
                </tr>
            <?php else: ?>
            <?php endif; ?>
            <tr class="hide">
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold">7.</td>
                <td colspan="2" style="padding: 10px;width:96%;border:0px;font-size: 11pt;font-weight: bold">
                    Academic Information:</td>

            </tr>
            <tr class="hide">
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Session:
                    <?php echo e($activity->session->session_name ?? ''); ?></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Version:
                    <?php echo e($activity->version->version_name ?? ''); ?></td>
            </tr>
            <tr class="hide">
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Shift:
                    <?php echo e($activity->shift->shift_name ?? ''); ?></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Category:
                    <?php echo e($activity->category->category_name ?? ''); ?></td>
            </tr>
            <tr class="hide">
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">House:
                    <?php echo e($activity->house->house_name ?? ''); ?></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Class:
                    <?php echo e($activity->classes->class_name ?? ''); ?></td>
            </tr>
            <tr class="hide">
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Section:
                    <?php echo e($activity->section->section_name ?? ''); ?></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Roll: <?php echo e($activity->roll ?? ''); ?></td>
            </tr>
            <tr class="hide">
                <td style="padding: 10px;width:4%;border:0px;font-size: 11pt;font-weight: bold"></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;">Group:
                    <?php echo e($activity->group->group_name ?? ''); ?></td>
                <td style="padding: 10px;width:48%;border:0px;font-size: 11pt;"></td>
            </tr>

        </table>
    </div>
</div>
<?php /**PATH /var/www/vhosts/bafsdadmission.com/httpdocs/resources/views/student/preview.blade.php ENDPATH**/ ?>