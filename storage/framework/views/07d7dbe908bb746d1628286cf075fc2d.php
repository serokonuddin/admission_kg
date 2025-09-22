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
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Section Wise Students</h4>
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

                                            <option value="0" <?php echo e($class_id == 0 ? 'selected="selected"' : ''); ?>>KG</option>
                                            <option value="1" <?php echo e($class_id == 1 ? 'selected="selected"' : ''); ?>>CLass I
                                            </option>
                                            <option value="2" <?php echo e($class_id == 2 ? 'selected="selected"' : ''); ?>>CLass II
                                            </option>
                                            <option value="3" <?php echo e($class_id == 3 ? 'selected="selected"' : ''); ?>>CLass III
                                            </option>
                                            <option value="4" <?php echo e($class_id == 4 ? 'selected="selected"' : ''); ?>>CLass IV
                                            </option>
                                            <option value="5" <?php echo e($class_id == 5 ? 'selected="selected"' : ''); ?>>CLass V
                                            </option>
                                            <option value="6" <?php echo e($class_id == 6 ? 'selected="selected"' : ''); ?>>CLass VI
                                            </option>
                                            <option value="7" <?php echo e($class_id == 7 ? 'selected="selected"' : ''); ?>>CLass VII
                                            </option>
                                            <option value="8" <?php echo e($class_id == 8 ? 'selected="selected"' : ''); ?>>CLass VIII
                                            </option>
                                            <option value="9" <?php echo e($class_id == 9 ? 'selected="selected"' : ''); ?>>CLass IX
                                            </option>
                                            <option value="10" <?php echo e($class_id == 10 ? 'selected="selected"' : ''); ?>>CLass X
                                            </option>
                                            <option value="11" <?php echo e($class_id == 11 ? 'selected="selected"' : ''); ?>>CLass XI
                                            </option>
                                            <option value="12" <?php echo e($class_id == 12 ? 'selected="selected"' : ''); ?>>CLass XII
                                            </option>
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
                    $gender = collect($students)->groupBy('gender');

                ?>
                <div class="table-responsive ">
                    <table>

                        <tr>
                            <td class="tdcenter bordernone" colspan="2"><img src="<?php echo e(asset('public/logo/logo.png')); ?>"
                                    style="width: 120px;"></td>
                            <td class="tdcenter bordernone" colspan="3">
                                <h3>BAF Shaheen College Dhaka</h3>
                                <p>Dhaka Cantonment Dhaka-1206</p>
                                <h4>Section Wise Students' List</h4>
                            </td>
                            <td colspan="2" class="bordernone">

                            </td>

                        </tr>
                        <tr>
                            <td colspan="2">Section</td>
                            <td><?php echo e($sectiondata->section_name ?? ''); ?></td>
                            <td>Total Students</td>
                            <td><?php echo e(count($students) ?? ''); ?></td>
                            <td>Male: <?php echo e(isset($gender[1]) ? count($gender[1]) : 0); ?></td>
                            <td>Female: <?php echo e(isset($gender[2]) ? count($gender[2]) : 0); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">Class Room No.:</td>
                            <td colspan="2"><?php echo e($sectiondata->room_number ?? ''); ?></td>
                            <td>Location:</td>
                            <td colspan="2"><?php echo e($sectiondata->location ?? ''); ?></td>

                        </tr>
                        <tr>
                            <td class="bordernone" colspan="7"></td>
                        </tr>
                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td colspan="2">Class Teacher-1:</td>
                                <td colspan="1"><?php echo e($employee->employee->employee_name); ?></td>
                                <td>Designation:</td>
                                <td colspan="1"><?php echo e($employee->employee->designation->designation_name); ?></td>
                                <td>Contact Number:</td>
                                <td colspan="1"><?php echo e($employee->employee->sms_notification_number); ?></td>

                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <!-- <tr>
                        <td colspan="2">Class Teacher-2:</td>
                        <td colspan="1"></td>
                        <td>Designation:</td>
                        <td colspan="1"></td>
                        <td>Contact Number:</td>
                        <td colspan="1"></td>

                    </tr> -->
                        <tr>
                            <td class="bordernone" colspan="7"></td>
                        </tr>
                        <tr>
                            <th style="width: 5%">Sl</th>
                            <th style="width: 25%">Name of Student</th>
                            <th style="width: 20%">Contact Number</th>
                            <th style="width: 10%">Gender</th>
                            <th style="width: 10%">House</th>
                            <th style="width: 10%">Class Roll</th>
                            <th style="width: 20%">Category</th>
                        </tr>
                        <?php
                            $house = [1 => 'Nazrul', 2 => 'Isha Kha', 3 => 'Titumir', 4 => 'Sher-E-Bangla'];
                            $gender = [1 => 'Male', 2 => 'Female'];
                            $categoryid = [
                                1 => 'Civil',
                                2 => 'Son/daughter of Armed Forces` Member',
                                3 => 'Son/daughter of Teaching/Non-Teaching staff of BAFSD',
                            ];
                            $religion = [1 => 'Islam', 2 => 'Hindu', 2 => 'christian', 2 => 'Buddhism', 2 => 'Others'];
                        ?>
                        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($loop->index + 1); ?></td>
                                <td><?php echo e($student->student->first_name); ?></td>
                                <td><?php echo e($student->student->sms_notification); ?></td>
                                <td><?php echo e($gender[$student->student->gender] ?? ''); ?></td>
                                <td><?php echo e($house[$student->house_id] ?? ''); ?></td>
                                <td><?php echo e($student->roll); ?></td>
                                <td><?php echo e($categoryid[$student->student->categoryid] ?? ''); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </table>
                    <?php if(count($students) > 0 && Auth::user()->is_view_user == 0): ?>
                        <button type="button" id="print-view" class="btn btn-success me-2"><i
                                class="fa fa-print"></i></button>
                    <?php endif; ?>
                </div>

            </div>
            <!-- Modal -->

        </div>
        <!-- / Content -->

        <div class="content-backdrop fade"></div>
        <iframe id="txtArea1" style="display:none"></iframe>
    </div>

    <script>
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
        });
    </script>

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
                location.href = "<?php echo e(route('sectionWiseStudent')); ?>" + '?shift_id=' + shift_id +
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

                window.open("<?php echo e(route('sectionWiseStudent')); ?>" + '?shift_id=' + shift_id +
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




        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/bafsdadmission.com/httpdocs/resources/views/section/section_wise_student.blade.php ENDPATH**/ ?>