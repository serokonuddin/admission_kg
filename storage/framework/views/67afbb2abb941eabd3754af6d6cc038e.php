<?php $__env->startSection('content'); ?>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }

        .border {
            background-color: #0095DD;
            width: 100%;

        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            border-radius: 10px 10px 0 0;
            padding: 19px 0px 0px 0px;
            text-align: center;
            background-color: #0095DD !important;

        }

        .student-photo {
            width: 250px;
            height: 250px;
            border-radius: 10px;
        }

        .section-title {
            margin-top: 20px;
            border-bottom: 2px solid #0095DD;
            display: flex;
            color: #0095DD;
            text-align: center !important;
            justify-content: start;
        }

        .info-item {
            margin-bottom: 10px;
            font-style: normal;
            font-size: 14px;

        }

        .info-item strong {
            color: #495057;
        }

        :root {
            --bs-breadcrumb-divider: ">";
        }

        .breadcrumb {
            margin-top: 10px;
        }

        .breadcrumb a {
            text-decoration: none;
            color: #007bff;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
            color: #0056b3;
        }

        h3,
        h4,
        h5 {
            font-weight: 600;
            color: white;
        }

        .special-title {
            padding-left: 5px;
            font-weight: 600;
            font-size: 14px;
            color: #007bff;
        }
    </style>
    <?php
        $sectionName = '';
        $className = '';
        $groupName = '';
        $houseName = '';
        $shiftName = '';
        $versionName = '';
        $prsDistName = '';
        $perDisName = '';
        $categoryName = '';
        $roman = [
            '0' => 'KG',
            '1' => 'Class  I',
            '2' => 'Class II',
            '3' => 'Class III',
            '4' => 'Class IV',
            '5' => 'Class V',
            '6' => 'Class VI',
            '7' => 'Class VII',
            '8' => 'Class VIII',
            '9' => 'Class IX',
            '10' => 'Class X',
            '11' => 'Class XI',
            '12' => 'Class XII',
        ];
        $groups = ['1' => 'Science', '2' => 'Humanities', '3' => 'Business studies', '4' => 'Others'];

        use App\Models\User;
        use App\Models\sttings\Sections;
        use App\Models\sttings\Shifts;
        use App\Models\sttings\Versions;
        use App\Models\sttings\Category;
        use App\Models\sttings\House;
        use App\Models\District;

        $createdBy = User::where('id', $studentdata->created_by)->first();
        $createdByNameAndDatetime = $createdBy ? $createdBy->name . ' (' . $studentdata->created_at . ')' : '';

        if (isset($activity) && isset($activity->class_code)) {
            $className = $roman[$activity->class_code];
        }
        if (isset($activity) && isset($activity->group_id)) {
            $groupName = $groups[$activity->group_id];
        }
        if (isset($activity->section_id) && $activity->section_id != null) {
            $sectionName = Sections::where('id', $activity->section_id)->value('section_name') ?? '';
        }
        if (isset($activity->house_id) && $activity->house_id != null) {
            $houseName = House::where('id', $activity->house_id)->value('house_name') ?? '';
        }
        if (isset($activity->version_id) && $activity->version_id != null) {
            $versionName = Versions::where('id', $activity->version_id)->value('version_name') ?? '';
        }
        if (isset($activity->shift_id) && $activity->shift_id != null) {
            $shiftName = Shifts::where('id', $activity->shift_id)->value('shift_name') ?? '';
        }
        if (isset($studentdata->present_district_id) && $studentdata->present_district_id != null) {
            $prsDistName = District::where('id', $studentdata->present_district_id)->value('name') ?? '';
        }
        if (isset($studentdata->permanent_district_id) && $studentdata->permanent_district_id != null) {
            $perDisName = District::where('id', $studentdata->permanent_district_id)->value('name') ?? '';
        }
        if (isset($studentdata->category_id) && $studentdata->category_id != null) {
            $categroyName = Category::where('id', $studentdata->category_id)->value('category_name') ?? '';
        }
        // dd($comsubjects);
        // dd($groupsubjects);
        // dd($activity);
    ?>
    <div class="content-wrapper">
        <!-- Content -->
        
        <div class="container-xxl flex-grow-1 container-p-y">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?php echo e(Auth::user()->group_id == 3 ? route('teacherStudent') : route('students.index')); ?>">
                            Students
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Details</li>
                </ol>
            </nav>
            <!-- Student Info -->
            <div class="card">
                <div class="card-header text-white text-center mb-3">
                    <h4>Student Detail Information</h4>
                </div>
                <div class="card-body">
                    <div class="col-md-12">
                        
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="info-item"><strong>Student
                                        Name:</strong><span
                                        class="text-primary special-title">&nbsp;<?php echo e($studentdata->first_name ?? ''); ?></span>
                                </div>
                                
                                <div class="info-item"><strong>Bangla
                                        Name:</strong>&nbsp;<?php echo e($studentdata->bangla_name ?? ''); ?>

                                </div>
                                <div class="info-item">
                                    <strong>Gender:</strong>&nbsp;<?php echo e(isset($studentdata->gender) ? ($studentdata->gender == 1 ? 'Male' : 'Female') : ''); ?>

                                </div>
                                <div class="info-item"><strong>Birth Certificate
                                        Number:</strong>&nbsp;<?php echo e($studentdata->birth_no ?? ''); ?></div>
                                <div class="info-item"><strong>Birthdate:</strong>&nbsp;<?php echo e($studentdata->birthdate ?? ''); ?>

                                </div>
                                <div class="info-item"><strong>Blood Group:</strong>&nbsp;<?php echo e($studentdata->blood ?? ''); ?>

                                </div>
                                <div class="info-item"><strong>Roll:</strong>&nbsp;<?php echo e($activity->roll ?? ''); ?>

                                </div>
                                <div class="info-item"><strong>Student ID:</strong>&nbsp;<?php echo e($activity->student_code ?? ''); ?>

                                </div>
                                <div class="info-item"><strong>Payment ID:</strong>&nbsp;<?php echo e($studentdata->PID ?? ''); ?>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-item"><strong>Class
                                        Name:</strong><span class="text-primary special-title"><?php echo e($className); ?></span>
                                </div>
                                <div class="info-item"><strong>Group:</strong>&nbsp;<span><?php echo e($groupName); ?></span></div>
                                <div class="info-item"><strong>Section:</strong>&nbsp;<span><?php echo e($sectionName); ?></span>
                                </div>
                                <div class="info-item"><strong>Version:</strong>&nbsp;<span><?php echo e($versionName); ?></span>
                                </div>
                                <div class="info-item"><strong>Shift:</strong>&nbsp;<span><?php echo e($shiftName); ?></span></div>
                                <div class="info-item"><strong>House:</strong>&nbsp;<span><?php echo e($houseName); ?></span></div>
                                <div class="info-item"><strong>Third Subject:</strong>
                                    <?php $__currentLoopData = $student_third_subject; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        &nbsp;<span><?php echo e($key); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <div class="info-item"><strong>Fourth Subject:</strong>
                                    <?php $__currentLoopData = $student_fourth_subject; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        &nbsp;<span><?php echo e($key); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <img src="<?php echo e($studentdata->photo); ?>" class="student-photo" alt="Student Photo">
                            </div>
                        </div>
                        
                        <h5 class="section-title">Guardian Information</h5>
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="info-item"><strong>Father's Name:</strong>&nbsp;<?php echo e($studentdata->father_name); ?>

                                </div>
                                <div class="info-item"><strong>Father's Phone:</strong>
                                    &nbsp;<?php echo e($studentdata->father_phone); ?>

                                </div>
                                <div class="info-item"><strong>Father's Email:</strong>
                                    &nbsp;<?php echo e($studentdata->father_email ?? ''); ?></div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-item"><strong>Mother's Name:</strong>&nbsp;<?php echo e($studentdata->mother_name); ?>

                                </div>
                                <div class="info-item"><strong>Mother's Phone:</strong>
                                    &nbsp;<?php echo e($studentdata->mother_phone); ?>

                                </div>
                                <div class="info-item"><strong>Mother's Email:</strong>
                                    &nbsp;<?php echo e($studentdata->mother_email ?? ''); ?></div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-item"><strong>Father's Profession:</strong>
                                    &nbsp;<?php echo e($studentdata->father_profession ?? ''); ?></div>

                                <div class="info-item"><strong>Father's NID:</strong>
                                    &nbsp;<?php echo e($studentdata->father_nid_number); ?>

                                </div>
                                <div class="info-item"><strong>Mother's NID:</strong>
                                    &nbsp;<?php echo e($studentdata->mother_nid_number); ?>

                                </div>
                            </div>
                        </div>
                        
                        <h5 class="section-title">Contact Information</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="info-item"><strong>Mobile:</strong>&nbsp;<?php echo e($studentdata->mobile ?? ''); ?></div>
                                <div class="info-item"><strong>SMS Notification:</strong>
                                    &nbsp;<?php echo e($studentdata->sms_notification ?? ''); ?></div>
                                <div class="info-item"><strong>Email:</strong>&nbsp;<?php echo e($studentdata->email ?? ''); ?></div>

                            </div>
                            <div class="col-md-6">
                                <div class="info-item"><strong>Local Guardian
                                        Name:</strong>&nbsp;<?php echo e($studentdata->local_guardian_name ?? ''); ?></div>
                                <div class="info-item"><strong>Local Guardian Mobile:</strong>
                                    &nbsp;<?php echo e($studentdata->local_guardian_mobile ?? ''); ?></div>
                                <div class="info-item"><strong>Local Guardian NID:</strong>
                                    &nbsp;<?php echo e($studentdata->local_guardian_nid ?? ''); ?></div>
                            </div>
                        </div>
                        
                        <h5 class="section-title">Address Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item"><strong>Present Address:</strong>
                                    &nbsp;<?php echo e(isset($studentdata->present_addr) ? $studentdata->present_addr : ''); ?>

                                </div>
                                <div class="info-item"><strong>Present Police Station:</strong>
                                    &nbsp;<?php echo e(isset($studentdata->present_police_station) ? $studentdata->present_police_station : ''); ?>

                                </div>
                                <div class="info-item"><strong>Present District Name:</strong>
                                    &nbsp;<?php echo e(isset($studentdata->present_district_id) ? $prsDistName : ''); ?>

                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="info-item"><strong>Permanent Address:</strong>
                                    &nbsp;<?php echo e(isset($studentdata->permanent_addr) ? $studentdata->permanent_addr : ''); ?>

                                </div>
                                <div class="info-item"><strong>Permanent Police Station:</strong>
                                    &nbsp;<?php echo e(isset($studentdata->permanent_police_station) ? $studentdata->permanent_police_station : ''); ?>

                                </div>
                                <div class="info-item"><strong>Permanent District Name:</strong>
                                    &nbsp;<?php echo e(isset($studentdata->permanent_district_id) ? $perDisName : ''); ?>

                                </div>

                            </div>
                        </div>
                        
                        <h5 class="section-title">Additional Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item"><strong>Religion:</strong>
                                    &nbsp;<?php echo e(isset($studentdata->religion)
                                        ? ['1' => 'Islam', '2' => 'Hindu', '3' => 'Christian', '4' => 'Buddhism', '5' => 'Others'][
                                                $studentdata->religion
                                            ] ?? 'Unknown'
                                        : ''); ?>

                                </div>
                                <div class="info-item">
                                    <strong>Nationality:</strong><?php echo e($studentdata->nationality ?? ''); ?>

                                </div>
                                <div class="info-item"><strong>Created By:</strong>
                                    &nbsp;<?php echo e($createdByNameAndDatetime); ?>

                                </div>
                                <div class="info-item">
                                    <strong>Active:</strong>&nbsp;<?php echo e($studentdata->active == 1 ? 'Active' : 'Inactive'); ?>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item"><strong>Academic Transcript:</strong> <a
                                        href="<?php echo e($studentdata->academic_transcript); ?>" target="_blank">View</a>
                                </div>
                                <div class="info-item"><strong>Testimonial:</strong> <a
                                        href="<?php echo e($studentdata->testimonial); ?>" target="_blank">View</a>
                                </div>
                                <div class="info-item"><strong>Birth Certificate:</strong> <a
                                        href="<?php echo e($studentdata->birth_certificate); ?>" target="_blank">View</a>
                                </div>
                                <div class="info-item"><strong>Admin Card:</strong> <a
                                        href="<?php echo e($studentdata->admit_card); ?>" target="_blank">View</a>
                                </div>
                                <div class="info-item"><strong>Father's NID Card:</strong> <a
                                        href="<?php echo e($studentdata->father_nid); ?>" target="_blank">View</a>
                                </div>
                                <div class="info-item"><strong>Mother's NID Card:</strong> <a
                                        href="<?php echo e($studentdata->mother_nid); ?>" target="_blank">View</a>
                                </div>
                            </div>
                        </div>
                        
                        <h5 class="section-title">School Information (S.S.C)</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item"><strong>School Name:</strong>
                                    &nbsp;<?php echo e($studentdata->school_name ?? ''); ?>

                                </div>
                                <div class="info-item">
                                    <strong>Thana:</strong>&nbsp;<?php echo e($studentdata->thana ?? ''); ?>

                                </div>
                                <div class="info-item">
                                    <strong>Exam Center:</strong>&nbsp;<?php echo e($studentdata->exam_center ?? ''); ?>

                                </div>
                                <div class="info-item">
                                    <strong>Category:</strong>&nbsp;<?php echo e($categroyName ?? ''); ?>

                                </div>
                                <div class="info-item"><strong>Roll Number:</strong>
                                    &nbsp;<?php echo e($studentdata->roll_number ?? ''); ?>

                                </div>
                                <div class="info-item"><strong>Registration Number:</strong>
                                    &nbsp;<?php echo e($studentdata->registration_number ?? ''); ?>

                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="info-item"><strong>Session:</strong>
                                    &nbsp;<?php echo e($studentdata->session ?? ''); ?>

                                </div>
                                <div class="info-item"><strong>Board:</strong>
                                    &nbsp;<?php echo e($studentdata->board ?? ''); ?>

                                </div>
                                <div class="info-item"><strong>Passing Year:</strong>
                                    &nbsp;<?php echo e($studentdata->passing_year ?? ''); ?>

                                </div>
                                <div class="info-item"><strong>Result:</strong>
                                    &nbsp;<?php echo e($studentdata->result ?? ''); ?>

                                </div>
                                <div class="info-item"><strong>Result Fourth Subject:</strong>
                                    &nbsp;<?php echo e($studentdata->result_fourth_subject ?? ''); ?>

                                </div>
                                <div class="info-item"><strong>Total Mark:</strong>
                                    &nbsp;<?php echo e($studentdata->total_mark ?? ''); ?>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- / Content -->

        <div class="content-backdrop fade"></div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/bafsdadmission.com/httpdocs/resources/views/student/details.blade.php ENDPATH**/ ?>