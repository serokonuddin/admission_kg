<?php
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;

    function getCauserName($userId, $datetime)
    {
        // Check if the user ID is valid
        if (!$userId) {
            return 'N/A';
        }

        // Fetch the user data from the cache or database
        $user = Cache::remember("user_$userId", 60, function () use ($userId) {
            return DB::table('users')->find($userId);
        });

        // Return the user's name and datetime, or 'N/A' if the user doesn't exist
        return optional($user)->name ? $user->name . ' ' . $datetime : 'N/A';
    }
?>
<div id="print-table">
    <div id="result-table" style="display: none;">
        <p class="border border-gray-500 p-2 dynamic-data" style="display: flex; justify-content: space-around;">
        </p>
    </div>

    <div class="table-responsive" id="item-list">
        <?php if($students->isEmpty()): ?>
            <p class="text-center alert alert-warning">No students found. Use the search form to find
                students.</p>
        <?php else: ?>
            <table class="table" id="headerTable">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 30px;">SL</th>
                        <th style="width: 65px;">Roll</th>
                        <th style="width: 65px;">SID</th>
                        <th style="width: 70px;">PID</th>
                        <th style="width: 240px;">Name</th>
                        <th style="width: 200px;">Father Name</th>
                        <th style="width: 60px;">Gender</th>
                        <th style="width: 100px;">Phone</th>
                        <th style="width: 140px;">Created</th>
                        <th style="width: 140px;">Updated</th>
                        <th style="width: 65px;">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr id="row<?php echo e($student->id); ?>">
                            <!-- Calculate sequential serial number -->
                            <td style="width: 20px;text-align:center;">
                                <?php echo e(($students->currentPage() - 1) * $students->perPage() + $loop->iteration); ?></td>
                            <td style="width: 50px;text-align:center;"><?php echo e($student->studentActivity->roll ?? ''); ?></td>
                            <td style="width: 140px;text-align:center;"><?php echo e($student->student_code ?? ''); ?></td>
                            <td style="width: 140px;text-align:center;"><?php echo e($student->PID ?? 'NA'); ?></td>
                            <td class="studentinfo" data-studentcode="<?php echo e($student->student_code); ?>"
                                style="width: 200px;">
                                <img src="<?php echo e($student->photo ?? asset('public/student.png')); ?>" alt="Avatar"
                                    class="rounded avatar avatar-xl student-photo">
                                <?php echo e(strtoupper($student->first_name . ' ' . $student->last_name)); ?>

                            </td>
                            <td style="width: 200px;"><?php echo e(strtoupper($student->father_name) ?? ''); ?></td>
                            <td style="width: 100px;text-align:center;"><?php echo e($student->gender == 1 ? 'Male' : 'Female'); ?>

                            </td>
                            <td style="width: 100px;text-align:left;">
                                <?php echo e($student->mobile ? $student->mobile : ($student->father_phone ? $student->father_phone : $student->sms_notification)); ?>

                            </td>

                            <td style="width: 150px;">
                                <span><?php echo e(getCauserName($student->created_by, '')); ?></span><br>
                                <small
                                    class="text-muted"><?php echo e(\Carbon\Carbon::parse($student->created_at)->format('d M Y h:i A')); ?></small>
                            </td>
                            <td style="width: 150px;">
                                <span><?php echo e(getCauserName($student->updated_by, '')); ?></span><br>
                                <small
                                    class="text-muted"><?php echo e(\Carbon\Carbon::parse($student->updated_at)->format('d M Y h:i A')); ?></small>
                            </td>
                            <td style="width: 60px;text-align:center;">
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <?php if(Auth::user()->getMenu('students.edit', 'name') && Auth::user()->is_view_user == 0): ?>
                                            <a class="dropdown-item edit"
                                                href="<?php echo e(route('students.edit', $student->id)); ?>"><i
                                                    class="bx bx-edit-alt me-1"></i> Edit</a>
                                        <?php endif; ?>
                                        <?php if(Auth::user()->getMenu('students.show', 'name') || Auth::user()->group_id == 8 || Auth::user()->group_id == 6): ?>
                                            <a class="dropdown-item show"
                                                href="<?php echo e(route('students.show', $student->id)); ?>"><i
                                                    class='bx bx-low-vision me-1'></i>View</a>
                                        <?php endif; ?>
                                        <?php if(Auth::user()->getMenu('students.destroy', 'name') && Auth::user()->is_view_user == 0): ?>
                                            <a class="dropdown-item delete"
                                                data-url="<?php echo e(route('students.destroy', $student->id)); ?>"
                                                data-id="<?php echo e($student->id); ?>" href="javascript:void(0);"><i
                                                    class="bx bx-trash me-1"></i> Delete</a>
                                        <?php endif; ?>
                                        <?php if(Auth::user()->group_id == 2 && Auth::user()->is_view_user == 0): ?>
                                            <button class="dropdown-item text-danger"
                                                onclick="openInactiveModal(<?php echo e($student->id); ?>)">
                                                <i class="bx bx-block me-1"></i>Inactive
                                            </button>
                                        <?php endif; ?>
                                        <?php if(
                                            (Auth::user()->group_id == 2 || Auth::user()->group_id == 8) &&
                                                $student->pid == null &&
                                                Auth::user()->is_view_user == 0): ?>
                                            <button class="dropdown-item text-info"
                                                onclick="openPIDModal(<?php echo e($student->id); ?>)">
                                                <i class="bx bx-money me-1"></i> Add PID
                                            </button>
                                        <?php endif; ?>
                                        <?php if(
                                            (Auth::user()->group_id == 2 || Auth::user()->group_id == 8) &&
                                                $student->pid == null &&
                                                Auth::user()->is_view_user == 0): ?>
                                            <button class="dropdown-item text-info"
                                                onclick="disciplinaryIssuesModal(<?php echo e($student->id); ?>)">
                                                <i class="bx bx-money me-1"></i> disciplinary issues
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <div class="d-flex mt-3 justify-content-end items-center dataTables_paginate">
                <!-- Pagination Links -->
                <?php echo $students->appends([
                        'search' => request('search'),
                        'shift_id' => request('shift_id'),
                        'version_id' => request('version_id'),
                        'session_id' => request('session_id'),
                        'class_code' => request('class_code'),
                        'section_id' => request('section_id'),
                        'text_search' => request('text_search'),
                        'searchQuery' => request('searchQuery'),
                    ])->links(); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH /var/www/vhosts/bafsdadmission.com/httpdocs/resources/views/student/pagination.blade.php ENDPATH**/ ?>