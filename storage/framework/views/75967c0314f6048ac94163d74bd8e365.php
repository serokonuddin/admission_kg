<?php $__env->startSection('content'); ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">Dashboard /</span> Subject Mapping
            </h4>
            <div class="row mb-4">
                <!-- Browser Default -->
                <div class="col-md-4">
                    <div class="card">
                        <h5 class="card-header">Section Entry</h5>
                        <div class="card-body">
                            <form class="needs-validation" method="post" action="<?php echo e(route('subjectmapping.store')); ?>"
                                novalidate="" id="formsubmit">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="id" id="id" value="0" />


                                <div class="mb-3">
                                    <label class="form-label" for="bs-Active">Class</label>
                                    <select class="form-select" name="class_code" id="class_id" required="">
                                        <option value="">Select Class</option>


                                        <option value="0">KG</option>
                                        <option value="1">CLass I</option>
                                        <option value="2">CLass II</option>
                                        <option value="3">CLass III</option>
                                        <option value="4">CLass IV</option>
                                        <option value="5">CLass V</option>
                                        <option value="6">CLass VI</option>
                                        <option value="7">CLass VII</option>
                                        <option value="8">CLass VIII</option>
                                        <option value="9">CLass IX</option>
                                        <option value="10">CLass X</option>
                                        <option value="11">CLass XI</option>
                                        <option value="12">CLass XII</option>


                                    </select>
                                    <div class="valid-feedback"> Looks good! </div>
                                    <div class="invalid-feedback"> Please select Class </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="bs-Active">Group</label>
                                    <select class="form-select" name="group_id" id="group_id">
                                        <option value="">Select Group</option>
                                        <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($group->id); ?>"><?php echo e($group->group_name); ?> </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                    </select>
                                    <div class="valid-feedback"> Looks good! </div>
                                    <div class="invalid-feedback"> Please select Group </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="bs-Active">Subject</label>
                                    <select class="form-select" name="subject_id" id="subject_id" required="">
                                        <option value="">Select Subject</option>
                                        <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($subject->id); ?>"><?php echo e($subject->subject_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                    </select>
                                    <div class="valid-feedback"> Looks good! </div>
                                    <div class="invalid-feedback"> Please select Class </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="bs-validation-name">Subject Code</label>
                                    <input type="text" class="form-control" name="subject_code" id="subject_code"
                                        placeholder="Section Name" required="">
                                    <div class="valid-feedback"> Looks good! </div>
                                    <div class="invalid-feedback"> Please enter Subject Code. </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="bs-Active">Subject Type</label>
                                    <select class="form-select" name="subject_type" id="subject_type" required="">
                                        <option value="">Select Subject</option>
                                        <option value="1">Compulsory</option>
                                        <option value="2">Group Subject</option>
                                        <option value="3">Optional</option>
                                        <option value="4">4th Subject</option>


                                    </select>
                                    <div class="valid-feedback"> Looks good! </div>
                                    <div class="invalid-feedback"> Please select Class </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="bs-Active">Is Main</label>
                                    <select class="form-select" name="is_main" id="is_main" required="">
                                        <option value="">Select Is Main</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>

                                    </select>
                                    <div class="valid-feedback"> Looks good! </div>
                                    <div class="invalid-feedback"> Please select Active </div>
                                </div>
                                <div class="mb-3">
                                    

                                    <div class="valid-feedback"> Looks good! </div>
                                    <div class="invalid-feedback"> Please select Active </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="bs-Active">Active</label>
                                    <select class="form-select" name="active" id="active" required="">
                                        <option value="">Select Active</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>

                                    </select>
                                    <div class="valid-feedback"> Looks good! </div>
                                    <div class="invalid-feedback"> Please select Active </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <?php if(Auth::user()->is_view_user == 0): ?>
                                            <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
                    $words = [
                        '0' => 'KG',
                        '1' => 'One',
                        '2' => 'Two',
                        '3' => 'Three',
                        '4' => 'Four',
                        '5' => 'Five',
                        '6' => 'Six',
                        '7' => 'Seven',
                        '8' => 'Eight',
                        '9' => 'Nine',
                        '10' => 'Ten',
                        '11' => 'Eleven',
                        '12' => 'Twelve',
                    ];
                ?>
                <div class="col-md-8 mb-4 mb-md-0">
                    <div class="card">
                        <h5 class="card-header">Subject Mapping List</h5>
                        <div class="table-responsive ">
                            <table class="table" id="headerTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Subject Code</th>
                                        <th>Subject Name</th>
                                        <th>Group Name</th>
                                        <th>Class Name</th>

                                        <th>Active</th>
                                        <?php if(Auth::user()->is_view_user == 0): ?>
                                            <th>Action</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    <?php $__currentLoopData = $classWiseSubject; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr id="row<?php echo e($subject->id); ?>">
                                            <th scope="row"><?php echo e($key + 1); ?></th>
                                            <td><?php echo e($subject->subject_code); ?></td>
                                            <td style="word-wrap: break-word!important">
                                                <?php echo e($subject->subject->subject_name ?? ''); ?></td>
                                            <td style="word-wrap: break-word!important">
                                                <?php echo e($subject->group->group_name ?? ''); ?></td>
                                            <td style="word-wrap: break-word!important">Class
                                                <?php echo e($words[$subject->class_code] ?? ''); ?></td>


                                            <td>
                                                <?php if($subject->active == 1): ?>
                                                    Active
                                                <?php elseif($subject->active == 0): ?>
                                                    Inactive
                                                <?php endif; ?>
                                            </td>
                                            <?php if(Auth::user()->is_view_user == 0): ?>
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                            data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                class="bx bx-dots-vertical-rounded"></i></button>
                                                        <div class="dropdown-menu" style="">
                                                            <a class="dropdown-item edit" data-id="<?php echo e($subject->id); ?>"
                                                                data-subject_code="<?php echo e($subject->subject_code); ?>"
                                                                data-subject_type="<?php echo e($subject->subject_type); ?>"
                                                                data-active="<?php echo e($subject->active); ?>"
                                                                data-is_main="<?php echo e($subject->is_main); ?>"
                                                                data-group_id="<?php echo e($subject->group_id); ?>"
                                                                data-class_id="<?php echo e($subject->class_code); ?>"
                                                                data-subject_id="<?php echo e($subject->subject_id); ?>"
                                                                href="javascript:void(0);"><i
                                                                    class="bx bx-edit-alt me-1"></i>
                                                                Edit</a>
                                                            <a class="dropdown-item delete"
                                                                data-url="<?php echo e(route('subjectmapping.destroy', $subject->id)); ?>"
                                                                data-id="<?php echo e($subject->id); ?>"
                                                                href="javascript:void(0);"><i
                                                                    class="bx bx-trash me-1"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <!-- /Browser Default -->
                <!-- Bootstrap Validation -->

                <!-- /Bootstrap Validation -->
            </div>

        </div>
        <!-- / Content -->

        <div class="content-backdrop fade"></div>
    </div>
    <script>
        $(document).ready(function() {
            $('#headerTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
    <script>
        <?php if($errors->any()): ?>

            Swal.fire({
                title: "Error",
                text: "<?php echo e(implode(',', $errors->all(':message'))); ?>",
                icon: "warning"
            });
        <?php endif; ?>
        <?php if(Session::get('success')): ?>

            Swal.fire({
                title: "Good job!",
                text: "<?php echo e(Session::get('success')); ?>",
                icon: "success"
            });
        <?php endif; ?>

        <?php if(Session::get('error')): ?>

            Swal.fire({
                title: "Error",
                text: "<?php echo e(Session::get('error')); ?>",
                icon: "warning"
            });
        <?php endif; ?>

        $(function() {
            $(document.body).on('click', '.edit', function() {
                var id = $(this).data('id');
                var subject_code = $(this).data('subject_code');
                var class_id = $(this).data('class_id');
                var group_id = $(this).data('group_id');
                var is_main = $(this).data('is_main');
                var subject_id = $(this).data('subject_id');
                var subject_type = $(this).data('subject_type');
                var active = $(this).data('active');
                $('#id').val(id);
                $('#subject_code').val(subject_code);
                $('#subject_type').val(subject_type);
                $('#class_id').val(class_id);
                $('#subject_id').val(subject_id);
                $('#group_id').val(group_id);
                $('#is_main').val(is_main);
                $('#active').val(active);
                $('#submit').text('Update');
            });


            $(document.body).on('click', '.delete', function() {
                var id = $(this).data('id');
                var url = $(this).data('url');
                $.ajax({
                    type: "delete",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "<?php echo e(csrf_token()); ?>"
                    },
                    success: function(response) {
                        if (response == 1) {
                            Swal.fire({
                                title: "Good job!",
                                text: "Deleted successfully",
                                icon: "success"
                            });
                            $('#row' + id).remove();
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: response,
                                icon: "warning"
                            });
                        }

                    },
                    error: function(data, errorThrown) {
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/bafsdadmission.com/httpdocs/resources/views/setting/subjectmappint.blade.php ENDPATH**/ ?>