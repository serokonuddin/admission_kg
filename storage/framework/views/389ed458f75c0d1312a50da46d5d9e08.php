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
                <span class="text-muted fw-light">Dashboard /</span> Section
            </h4>
            <div class="row mb-4">
                <!-- Browser Default -->
                <div class="col-md mb-4 mb-md-0">
                    <div class="card">
                        <h5 class="card-header">Section List</h5>
                        <div class="table-responsive text-nowrap">
                            <table class="table" id="headerTable">
                                <thead>
                                    <tr class="text-nowrap">
                                        <th>#</th>
                                        <th>Section Name</th>
                                        <th>Class Name</th>
                                        <th>Version</th>
                                        <th>Shift</th>
                                       
                                        <th>Male</th>
                                        <th>Female</th>
                                        <th>Total</th>
                                         <th>Serial</th>
                                        <th>Active</th>
                                        <?php if(Auth::user()->is_view_user == 0): ?>
                                            <th>Action</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr id="row<?php echo e($section->id); ?>">
                                            <th scope="row"><?php echo e($key + 1); ?></th>
                                            <td><?php echo e($section->section_name); ?></td>
                                            <td><?php echo e($section->classvalue->class_name ?? ''); ?></td>
                                            <td><?php echo e($section->version->version_name ?? ''); ?></td>
                                            
                                            <td><?php echo e(($section->shift_id==1)?'Morning':'Day'); ?></td>
                                            <td><?php echo e($section->male); ?></td>
                                            <td><?php echo e($section->female); ?></td>
                                            <td><?php echo e($section->student_number); ?></td>
                                            <td><?php echo e($section->serial); ?></td>
                                            <td>
                                                <?php if($section->active == 1): ?>
                                                    Active
                                                <?php elseif($section->active == 0): ?>
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
                                                            <a class="dropdown-item edit" data-id="<?php echo e($section->id); ?>"
                                                                data-section_name="<?php echo e($section->section_name); ?>"
                                                                data-active="<?php echo e($section->active); ?>"
                                                                data-class_code="<?php echo e($section->class_code); ?>"
                                                                data-group_id="<?php echo e($section->group_id); ?>"
                                                                data-version_id="<?php echo e($section->version_id); ?>"
                                                                data-serial="<?php echo e($section->serial); ?>"
                                                                data-student_number="<?php echo e($section->student_number); ?>"
                                                                data-shift_id="<?php echo e($section->shift_id); ?>"
                                                                href="javascript:void(0);"><i
                                                                    class="bx bx-edit-alt me-1"></i>
                                                                Edit</a>
                                                            <a class="dropdown-item delete"
                                                                data-url="<?php echo e(route('section.destroy', $section->id)); ?>"
                                                                data-id="<?php echo e($section->id); ?>" href="javascript:void(0);"><i
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
                <div class="col-md">
                    <div class="card">
                        <h5 class="card-header">Section Entry</h5>
                        <div class="card-body">
                            <form class="needs-validation" method="post" action="<?php echo e(route('section.store')); ?>"
                                novalidate="" id="formsubmit">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="id" id="id" value="0" />
                                <div class="mb-3">
                                    <label class="form-label" for="bs-validation-name">Section Name</label>
                                    <input type="text" class="form-control" name="section_name" id="section_name"
                                        placeholder="Section Name" required="">
                                    <div class="valid-feedback"> Looks good! </div>
                                    <div class="invalid-feedback"> Please enter Section Name. </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="bs-Active">Class</label>
                                    <select class="form-select" name="class_code" id="class_code" required="">
                                      
                                        <option value="0">KG</option>
                                        

                                    </select>
                                    <div class="valid-feedback"> Looks good! </div>
                                    <div class="invalid-feedback"> Please select Class </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="bs-Active">Version</label>
                                    <select class="form-select" name="version_id" id="version_id">
                                        <option value="">Select Version</option>
                                        <?php $__currentLoopData = $versions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $version): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($version->id); ?>"><?php echo e($version->version_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                    </select>

                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="bs-Active">Shift</label>
                                    <select class="form-select" name="shift_id" id="shift_id">
                                        <option value="1">Morning</option>
                                        <option value="2">Day</option>
                                        


                                    </select>

                                </div>
                                <div class="mb-3 " style="display: none;">
                                    <label class="form-label" for="bs-Active">Group</label>
                                    <select class="form-select" name="group_id" id="group_id">
                                        <option value="">Select Class</option>
                                        


                                    </select>

                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="bs-validation-name">Section Serial</label>
                                    <input type="text" class="form-control" name="serial" id="serial"
                                        placeholder="Section Serial" required="">
                                    <div class="valid-feedback"> Looks good! </div>
                                    <div class="invalid-feedback"> Please enter Serial. </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="bs-validation-name">Number of Student</label>
                                    <input type="number" class="form-control" name="student_number" id="student_number"
                                        placeholder="Number Of Student" required="">
                                    <div class="valid-feedback"> Looks good! </div>
                                    <div class="invalid-feedback"> Please enter Male Number. </div>
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
                var section_name = $(this).data('section_name');
                var class_code = $(this).data('class_code');
                var group_id = $(this).data('group_id');
                var serial = $(this).data('serial');
                var student_number = $(this).data('student_number');
                var shift_id = $(this).data('shift_id');
                var version_id = $(this).data('version_id');
                var active = $(this).data('active');
                $('#id').val(id);
                $('#section_name').val(section_name);
                $('#class_code').val(class_code);
                $('#group_id').val(group_id);
                $('#version_id').val(version_id);
                $('#serial').val(serial);
                $('#shift_id').val(shift_id);
                $('#student_number').val(student_number);
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

<?php echo $__env->make('admin.layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/kgadmission/resources/views/setting/section.blade.php ENDPATH**/ ?>