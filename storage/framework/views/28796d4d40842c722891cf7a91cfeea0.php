<?php $__env->startSection('content'); ?>
    <style>
        .control {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
            position: relative;
            cursor: pointer;
        }

        th.control:before,
        td.control:before {
            background-color: #696cff;
            border: 2px solid #fff;
            box-shadow: 0 0 3px rgba(67, 89, 113, .8);
        }

        td.control:before,
        th.control:before {
            top: 50%;
            left: 50%;
            height: 0.8em;
            width: 0.8em;
            margin-top: -0.5em;
            margin-left: -0.5em;
            display: block;
            position: absolute;
            color: white;
            border: 0.15em solid white;
            border-radius: 1em;
            box-shadow: 0 0 0.2em #444;
            box-sizing: content-box;
            text-align: center;
            text-indent: 0 !important;
            font-family: "Courier New", Courier, monospace;
            line-height: 1em;
            content: "+";
            background-color: #0d6efd;
        }

        .table-dark {
            background-color: #1c4d7c !important;
            color: #fff !important;
            font-weight: bold;
        }

        .table-dark {
            --bs-table-bg: #1c4d7c !important;
            --bs-table-striped-bg: #1c4d7c !important;
            --bs-table-striped-color: #fff !important;
            --bs-table-active-bg: #1c4d7c !important;
            --bs-table-active-color: #fff !important;
            --bs-table-hover-bg: #1c4d7c !important;
            --bs-table-hover-color: #fff !important;
            color: #fff !important;
            border-color: #1c4d7c !important;
        }

        .table:not(.table-dark) th {
            color: #ffffff;
        }

        .p-10 {
            padding: 10px !important;
        }

        .m-r-10 {
            margin-right: 10px !important;
        }

        .childdata {
            display: none;
            background-color: #98fded;
        }

        .btn {
            font-size: 11px !important;
        }

        .form-label {
            width: 100% !important;
        }

        div:where(.swal2-container) h2:where(.swal2-title) {

            font-size: 1.375em !important;

        }

        .table-responsive table td,
        .table-responsive table th {
            border: 1px solid #000000;
            padding: 8px;
        }

        .tdcenter {
            text-align: center !important;
        }

        .tdright {
            text-align: right !important;
        }

        .bordernone {
            border: none !important;
        }
    </style>

    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Section Wise Subject Statistics (With
                Optional)</h4>
            <!-- Basic Bootstrap Table -->
            <div class="card">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="dataTables_length" id="DataTables_Table_0_length" style="padding: 5px">
                            <div class="row g-3 searchby">
                                <div class="col-sm-3">
                                    <label class="form-label">
                                        <select id="session_id" name="session_id" class=" form-select" required="">

                                            <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($session->id); ?>"
                                                    <?php echo e($session_id == $session->id ? 'selected="selected"' : ''); ?>>
                                                    <?php echo e($session->session_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </select>
                                    </label>
                                </div>
                                <div class="col-sm-3">
                                    <label class="form-label">
                                        <select id="version_id" name="version_id" class=" form-select" required="">
                                            <option value="">Select Version</option>
                                            <?php $__currentLoopData = $versions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $version): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($version->id); ?>"
                                                    <?php echo e($version_id == $version->id ? 'selected="selected"' : ''); ?>>
                                                    <?php echo e($version->version_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </select>
                                    </label>
                                </div>
                                <div class="col-sm-3">
                                    <label class="form-label">
                                        <select id="shift_id" name="shift_id" class=" form-select" required="">
                                            <option value="">Select Shift</option>
                                            <?php $__currentLoopData = $shifts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shift): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($shift->id); ?>"
                                                    <?php echo e($shift_id == $shift->id ? 'selected="selected"' : ''); ?>>
                                                    <?php echo e($shift->shift_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </select>
                                    </label>
                                </div>
                                <div class="col-sm-3">
                                    <label class="form-label">

                                        <select id="class_id" name="class_id" class=" form-select" required="">
                                            <option value="">Select Class</option>
                                            <option value="0"
                                                <?php echo e(Session::get('class_code') === '0' ? 'selected="selected"' : ''); ?>>KG
                                            </option>
                                            <option value="1"
                                                <?php echo e(Session::get('class_code') === '1' ? 'selected="selected"' : ''); ?>>
                                                Class I</option>
                                            <option value="2"
                                                <?php echo e(Session::get('class_code') === '2' ? 'selected="selected"' : ''); ?>>
                                                Class II</option>
                                            <option value="3"
                                                <?php echo e(Session::get('class_code') === '3' ? 'selected="selected"' : ''); ?>>
                                                Class III</option>
                                            <option value="4"
                                                <?php echo e(Session::get('class_code') === '4' ? 'selected="selected"' : ''); ?>>
                                                Class IV</option>
                                            <option value="5"
                                                <?php echo e(Session::get('class_code') === '5' ? 'selected="selected"' : ''); ?>>
                                                Class V</option>
                                            <option value="6"
                                                <?php echo e(Session::get('class_code') === '6' ? 'selected="selected"' : ''); ?>>
                                                Class VI</option>
                                            <option value="7"
                                                <?php echo e(Session::get('class_code') === '7' ? 'selected="selected"' : ''); ?>>
                                                Class VII</option>
                                            <option value="8"
                                                <?php echo e(Session::get('class_code') === '8' ? 'selected="selected"' : ''); ?>>
                                                Class VIII</option>
                                            <option value="9"
                                                <?php echo e(Session::get('class_code') === '9' ? 'selected="selected"' : ''); ?>>
                                                Class IX</option>
                                            <option value="10"
                                                <?php echo e(Session::get('class_code') === '10' ? 'selected="selected"' : ''); ?>>
                                                Class X</option>
                                            <option value="11"
                                                <?php echo e(Session::get('class_code') === '11' ? 'selected="selected"' : ''); ?>>
                                                Class XI</option>
                                            <option value="12"
                                                <?php echo e(Session::get('class_code') === '12' ? 'selected="selected"' : ''); ?>>
                                                Class XII</option>
                                        </select>
                                    </label>
                                </div>
                                <div class="col-sm-3">
                                    <label class="form-label">
                                        <select id="section_id" name="section_id" class=" form-select" required="">
                                            <option value="">Select Section</option>
                                            <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($section->id); ?>"
                                                    <?php echo e($section_id == $section->id ? 'selected="selected"' : ''); ?>>
                                                    <?php echo e($section->section_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </select>
                                    </label>
                                </div>

                                <div class="col-sm-3">
                                    <label>

                                        <button type="button" id="search" class="btn btn-primary me-2">Search</button>


                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- <div class="col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end">
                           <div style="padding: 5px" id="DataTables_Table_1_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control" id="search" placeholder="" aria-controls="DataTables_Table_1"></label></div>
                        </div> -->
                </div>
                <?php
                    $totalban = 0;
                    $totaltotal = 0;
                    $totaleng = 0;
                    $totalict = 0;
                    $totalagr = 0;
                    $totalsta = 0;
                    $groupData = collect($groupData)->groupBy(['group_id', 'version_id']);
                    $groupsubject = [
                        1 => ['BAN', 'ENG', 'ICT', 'PHY', 'CHE', 'BIO', 'HMM', 'PSY', 'AGR', 'STA', '(EDS)'],
                        2 => ['BAN', 'ENG', 'ICT', 'ECO', 'LOG', 'GEO', '(IHC)', 'SOW', '(CGG)', 'PSY', 'AGR', 'STA'],
                        3 => ['BAN', 'ENG', 'ICT', 'ACC', '(BOM)', '(PMM)', '(FBI)', 'AGR', 'STA'],
                    ];
                    $grouprowspan = [];
                    $versionrowspan = [];
                    foreach ($groupData as $key => $data) {
                        $grouprowspan[$key] = 0;
                        foreach ($data as $key1 => $value) {
                            $grouprowspan[$key] += $value ? count($value) : 0;
                            $versionrowspan[$key][$key1] = $value ? count($value) : 0;
                        }
                    }
                    $version = ['1' => 'Bangla', '2' => 'English'];
                    $group = ['1' => 'Science', 2 => 'Humanities', 3 => 'Business studies'];
                ?>
                <div class="table-responsive ">
                    <table>

                        <tr>
                            <td class="tdcenter bordernone" colspan="2"><img src="<?php echo e(asset('public/logo/logo.png')); ?>"
                                    style="width: 120px;"></td>
                            <td class="tdcenter bordernone" colspan="3">
                                <h3>BAF Shaheen College Dhaka</h3>
                                <p>Dhaka Cantonment Dhaka-1206</p>
                                <h4>Section Wise Subject Statistics (With Optional)</h4>
                            </td>
                            <td colspan="2" class="bordernone">

                            </td>

                        </tr>

                    </table>
                    <?php $__currentLoopData = $groupData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php

                            $i = 0;
                            $total = 0;
                            $total1 = 0;
                            $total2 = 0;
                            $total3 = 0;
                            $total4 = 0;
                            $total5 = 0;
                            $total6 = 0;
                            $total7 = 0;
                            $total8 = 0;
                            $total9 = 0;
                            $total10 = 0;
                            $total11 = 0;
                            $total12 = 0;
                            foreach ($groupsubject[$key] as $key2 => $subject) {
                                $total . ($subject = 0);
                            }

                        ?>
                        <table style="margin-top: 10px">


                            <tr>
                                <th style="width: 100px!important">Group</th>
                                <th style="width: 60px!important">Version</th>
                                <th style="width: 80px!important">Section</th>
                                <th style="width: 60px!important">Total Student</th>
                                <?php $__currentLoopData = $groupsubject[$key]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th style="vertical-align: center"><?php echo e($s); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>

                            <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key1 => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
							$j = 0;

                              
							?> 
							
                                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key0 => $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <?php if($i == 0): ?>
                                            <td rowspan="<?php echo e($grouprowspan[$key]); ?>"><?php echo e($group[$key]); ?></td>
                                        <?php endif; ?>
                                        <?php if($j == 0): ?>
                                            <td rowspan="<?php echo e($versionrowspan[$key][$key1]); ?>"><?php echo e($version[$key1]); ?></td>
                                        <?php endif; ?>
                                        <td><?php echo e($section->section_name); ?></td>
                                        <td>
                                            <?php
                                                $totaltotal += (int) $section->total_student ?? 0;
                                                $total += (int) $section->total_student ?? 0;
                                            ?>
                                            <?php echo e($section->total_student); ?>


                                        </td>
                                        <?php $__currentLoopData = $groupsubject[$key]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key2 => $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php

                                                if ($subject == 'BAN') {
                                                    $totalban += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($subject == 'ENG') {
                                                    $totaleng += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($subject == 'ICT') {
                                                    $totalict += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($subject == 'AGR') {
                                                    $totalagr += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($subject == 'STA') {
                                                    $totalsta += $section->subject[$subject][0]->subject_number ?? 0;
                                                }

                                                if ($key2 == 0) {
                                                    $total1 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 1) {
                                                    $total2 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 2) {
                                                    $total3 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 3) {
                                                    $total4 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 4) {
                                                    $total5 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 5) {
                                                    $total6 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 6) {
                                                    $total7 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 7) {
                                                    $total8 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 8) {
                                                    $total9 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 9) {
                                                    $total10 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 10) {
                                                    $total11 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 11) {
                                                    $total12 += $section->subject[$subject][0]->subject_number ?? 0;
                                                }
                                            ?>
                                            <td><a href="<?php echo e(url('admin/getTotalStudentBySectionSubject/' . $section->id . '/' . $subject)); ?>"
                                                    target="_blank"><?php echo e($section->subject[$subject][0]->subject_number ?? 0); ?></a>
                                            </td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>
                                    <?php $j++; ?>
                                    <?php $i++; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td colspan="3" style="text-align: right;font-weight: bold">Total</td>
                                <td><?php echo e($total); ?></td>
                                <?php if($key == 1): ?>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/BAN/' . $key)); ?>"
                                            target="_blank"><?php echo e($total1); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/ENG/' . $key)); ?>"
                                            target="_blank"><?php echo e($total2); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/ICT/' . $key)); ?>"
                                            target="_blank"><?php echo e($total3); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/PHY/' . $key)); ?>"
                                            target="_blank"><?php echo e($total4); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/CHE/' . $key)); ?>"
                                            target="_blank"><?php echo e($total5); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/BIO/' . $key)); ?>"
                                            target="_blank"><?php echo e($total6); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/HMM/' . $key)); ?>"
                                            target="_blank"><?php echo e($total7); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/PSY/' . $key)); ?>"
                                            target="_blank"><?php echo e($total8); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/AGR/' . $key)); ?>"
                                            target="_blank"><?php echo e($total9); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/STA/' . $key)); ?>"
                                            target="_blank"><?php echo e($total10); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/(EDS)/' . $key)); ?>"
                                            target="_blank"><?php echo e($total11); ?></a></td>
                                <?php elseif($key == 2): ?>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/BAN/' . $key)); ?>"
                                            target="_blank"><?php echo e($total1); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/ENG/' . $key)); ?>"
                                            target="_blank"><?php echo e($total2); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/ICT/' . $key)); ?>"
                                            target="_blank"><?php echo e($total3); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/ECO/' . $key)); ?>"
                                            target="_blank"><?php echo e($total4); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/LOG/' . $key)); ?>"
                                            target="_blank"><?php echo e($total5); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/GEO/' . $key)); ?>"
                                            target="_blank"><?php echo e($total6); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/(IHC)/' . $key)); ?>"
                                            target="_blank"><?php echo e($total7); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/SOW/' . $key)); ?>"
                                            target="_blank"><?php echo e($total8); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/(CGG)/' . $key)); ?>"
                                            target="_blank"><?php echo e($total9); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/PSY/' . $key)); ?>"
                                            target="_blank"><?php echo e($total10); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/AGR/' . $key)); ?>"
                                            target="_blank"><?php echo e($total11); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/STA/' . $key)); ?>"
                                            target="_blank"><?php echo e($total12); ?></a></td>
                                <?php else: ?>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/BAN/' . $key)); ?>"
                                            target="_blank"><?php echo e($total1); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/ENG/' . $key)); ?>"
                                            target="_blank"><?php echo e($total2); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/ICT/' . $key)); ?>"
                                            target="_blank"><?php echo e($total3); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/ACC/' . $key)); ?>"
                                            target="_blank"><?php echo e($total4); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/(BOM)/' . $key)); ?>"
                                            target="_blank"><?php echo e($total5); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/(PMM)/' . $key)); ?>"
                                            target="_blank"><?php echo e($total6); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/(FBI)/' . $key)); ?>"
                                            target="_blank"><?php echo e($total7); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/AGR/' . $key)); ?>"
                                            target="_blank"><?php echo e($total8); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/STA/' . $key)); ?>"
                                            target="_blank"><?php echo e($total9); ?></a></td>
                                <?php endif; ?>
                            </tr>

                        </table>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php if(count($groupData) > 0): ?>
                        <table style="margin-top: 10px">
                            <tr>
                                <td>Total Student</td>
                                <td>Total Student: <?php echo e($totaltotal); ?></td>
                                <td><a href="<?php echo e(url('admin/getTotalStudentBySubject/BAN')); ?>" target="_blank">BAN:
                                        <?php echo e($totalban); ?></a></td>
                                <td><a href="<?php echo e(url('admin/getTotalStudentBySubject/ENG')); ?>" target="_blank">ENG:
                                        <?php echo e($totaleng); ?></a></td>
                                <td><a href="<?php echo e(url('admin/getTotalStudentBySubject/ICT')); ?>" target="_blank">ICT:
                                        <?php echo e($totalict); ?></a></td>
                                <td><a href="<?php echo e(url('admin/getTotalStudentBySubject/AGR')); ?>" target="_blank">AGR:
                                        <?php echo e($totalagr); ?></a></td>
                                <td><a href="<?php echo e(url('admin/getTotalStudentBySubject/STA')); ?>" target="_blank">STA:
                                        <?php echo e($totalsta); ?></a></td>
                            </tr>
                        </table>
					<?php if(Auth::user()->is_view_user == 0): ?>
								<button type="button" id="print-view" class="btn btn-success me-2"><i
                                class="fa fa-print"></i></button>
							<?php endif; ?>
                        
                    <?php endif; ?>
                </div>

            </div>
            <!-- Modal -->

        </div>
        <!-- / Content -->

        <div class="content-backdrop fade"></div>
        <iframe id="txtArea1" style="display:none"></iframe>
    </div>

    <script type="text/javascript">
        $(function() {


            $(document.body).on('change', '.attendance_search', function() {
                var start_date = $('#start_date').val();
                var end_date = $('#end_date').val();
                var student_code = $('#student_code_value').val();
                var url = "<?php echo e(route('getAttendanceByDate')); ?>";
                if (start_date && end_date) {
                    $.LoadingOverlay("show");

                    $.ajax({
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: url,
                        data: {
                            "_token": "<?php echo e(csrf_token()); ?>",
                            start_date,
                            end_date,
                            student_code
                        },
                        success: function(response) {
                            $.LoadingOverlay("hide");
                            $('#attendanceDetails').html(response);


                        },
                        error: function(data, errorThrown) {
                            $.LoadingOverlay("hide");
                            Swal.fire({
                                title: "Error",
                                text: errorThrown,
                                icon: "warning"
                            });

                        }
                    });
                }
            });
            $(document.body).on('click', '.studentinfo', function() {
                var student_code = $(this).data('studentcode');
                var session_id = $('#session_id').val();
                var url = "<?php echo e(route('getStudentDetails')); ?>";
                $.LoadingOverlay("show");
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "<?php echo e(csrf_token()); ?>",
                        student_code,
                        session_id
                    },
                    success: function(response) {
                        $.LoadingOverlay("hide");
                        $('.modal-body').html(response);


                    },
                    error: function(data, errorThrown) {
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            title: "Error",
                            text: errorThrown,
                            icon: "warning"
                        });

                    }
                });
                $('#fullscreenModal').modal('show');
            });
            $(document.body).on('click', '#search', function() {
                var session_id = $('#session_id').val();
                var version_id = $('#version_id').val();
                var shift_id = $('#shift_id').val();
                var class_id = $('#class_id').val();
                var section_id = $('#section_id').val();
                location.href = "<?php echo e(route('subjectWiseStudent')); ?>" + '?shift_id=' + shift_id +
                    ' & version_id=' + version_id + '& class_id=' + class_id + '& section_id=' +
                    section_id + '& session_id=' + session_id;


            });
            $(document.body).on('click', '#print-view', function() {
                var session_id = $('#session_id').val();
                var version_id = $('#version_id').val();
                var shift_id = $('#shift_id').val();
                var class_id = $('#class_id').val();
                var section_id = $('#section_id').val();
                var print = 1;

                window.open("<?php echo e(route('subjectWiseStudent')); ?>" + '?shift_id=' + shift_id +
                    ' & version_id=' + version_id + '& class_id=' + class_id + '& section_id=' +
                    section_id + '& session_id=' + session_id + '& print=' + print);

            });
            $(document.body).on('change', '#search_by', function() {
                if ($('#search').val() && $(this).val()) {
                    location.href = "<?php echo e(route('students.index')); ?>" + '?search_by=' + $(this).val() +
                        ' & search=' + $('#search').val();
                }


            });
        });

        $(function() {


            $(document.body).on('change', '#class_id', function() {
                var id = $(this).val();
                var shift_id = $('#shift_id').val();
                var version_id = $('#version_id').val();
                var url = "<?php echo e(route('class-wise-sections')); ?>";
                $.LoadingOverlay("show");
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "<?php echo e(csrf_token()); ?>",
                        class_id: id,
                        shift_id,
                        version_id
                    },
                    success: function(response) {
                        $.LoadingOverlay("hide");
                        $('#section_id').html(response);


                    },
                    error: function(data, errorThrown) {
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            title: "Error",
                            text: errorThrown,
                            icon: "warning"
                        });

                    }
                });
            });
            $(document.body).on('change', '#shift_id', function() {

                var shift_id = $('#shift_id').val();
                var version_id = $('#version_id').val();
                if (version_id && shift_id) {
                    var url = "<?php echo e(route('getClass')); ?>";
                    $.LoadingOverlay("show");
                    $.ajax({
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: url,
                        data: {
                            "_token": "<?php echo e(csrf_token()); ?>",
                            shift_id,
                            version_id
                        },
                        success: function(response) {
                            $.LoadingOverlay("hide");
                            $('#class_id').html(response);
                            $('#section_id').html('');

                        },
                        error: function(data, errorThrown) {
                            $.LoadingOverlay("hide");
                            Swal.fire({
                                title: "Error",
                                text: errorThrown,
                                icon: "warning"
                            });

                        }
                    });
                }
            });
            $(document.body).on('change', '#version_id', function() {

                var shift_id = $('#shift_id').val();
                var version_id = $('#version_id').val();
                if (version_id && shift_id) {
                    var url = "<?php echo e(route('getClass')); ?>";
                    $.LoadingOverlay("show");
                    $.ajax({
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: url,
                        data: {
                            "_token": "<?php echo e(csrf_token()); ?>",
                            shift_id,
                            version_id
                        },
                        success: function(response) {
                            $.LoadingOverlay("hide");
                            $('#class_id').html(response);
                            $('#section_id').html('');

                        },
                        error: function(data, errorThrown) {
                            $.LoadingOverlay("hide");
                            Swal.fire({
                                title: "Error",
                                text: errorThrown,
                                icon: "warning"
                            });

                        }
                    });
                }

            });

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/bafsdadmission.com/httpdocs/resources/views/section/subject_wise_student.blade.php ENDPATH**/ ?>