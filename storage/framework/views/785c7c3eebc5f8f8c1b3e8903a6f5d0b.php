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

        .form-label {
            width: 100% !important;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"> Board Result</li>
                </ol>
            </nav>
            <!-- Basic Bootstrap Table -->
            <div class="card">

                <div class="row">
                    <div class="card-header">
                        <div class="dataTables_length" id="DataTables_Table_0_length" style="padding: 5px">
                            <form id="formAdmission" method="POST" action="<?php echo e(route('boardResulXlUploadSave')); ?>"
                                enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="row g-3 align-items-end">
                                    <!-- File Upload -->
                                    <div class="col-sm-4">
                                        <label for="boardResultesultXL" class="form-label">Excel (Allowed formats: XLSX,
                                            XLS, CSV.
                                            Max file size: 200 KB.)</label>
                                        <input type="file" name="boardResultesultXL" class="form-control"
                                            id="boardResultesultXL" />
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="col-sm-4 mt-8">
                                        <?php if(Auth::user()->is_view_user == 0): ?>
                                            <button type="submit" id="save_button" class="btn btn-primary">Save</button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="d-flex align-items-end gap-3 mt-2">
                            <div class="col-sm-4">
                                <label for="exam_type" class="form-label">Exam Type</label>
                                <select name="exam_type" id="exam_type" class="form-control">
                                    <option value="">Select Exam Type</option>
                                    <option value="1">Exam Type 1</option>
                                    <option value="2">Exam Type 2</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="passing_year" class="form-label">Passing Year</label>
                                <select name="passing_year" id="passing_year" class="form-control">
                                    <option value="">Select Passing Year</option>
                                    <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($session->id); ?>"><?php echo e($session->session_name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <!-- Search Button -->
                            <div class="col-sm-4 mt-4">
                                <button type="button" id="search_button" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="result_table" class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>Student ID</th>
                                    <th>Roll Number</th>
                                    <th>Registration Number</th>
                                    <th>Passing Year</th>
                                    <th>GPA</th>
                                    <th>Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dynamic content will be appended here -->
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
            <!-- Modal -->

        </div>
        <!-- / Content -->
        <div class="content-backdrop fade"></div>
    </div>
    <script>
        $(document.body).on('click', '#search_button', function() {
            const examType = $('#exam_type').val();
            const passingYear = $('#passing_year').val();

            if (!examType) {
                Swal.fire({
                    title: "Error",
                    text: "Please select an exam type.",
                    icon: "warning"
                });
                return;
            }

            const url = "<?php echo e(route('getBoardResults')); ?>";
            $.LoadingOverlay("show");

            $.ajax({
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                data: {
                    exam_type: examType,
                    passing_year: passingYear
                }, // Send data as query parameters
                success: function(response) {
                    $.LoadingOverlay("hide");

                    const tbody = $('#result_table tbody');
                    tbody.html(''); // Clear existing table rows

                    if (response.length === 0) {
                        tbody.html('<tr><td colspan="7" class="text-center">No data found.</td></tr>');
                    } else {
                        response.forEach((row, index) => {
                            const tr = `
                                <tr>
                                    <td>${index + 1}</td> <!-- Serial number -->
                                    <td>${row.student ? row.student.first_name : ''}</td>
                                    <td>${row.student ? row.student.student_code : ''}</td>
                                    <td>${row.roll_number}</td>
                                    <td>${row.registration_number}</td>
                                    <td>${row.passing_year}</td>
                                    <td>${row.gpa}</td>
                                    <td>${row.grade}</td>
                                </tr>`;
                            tbody.append(tr);
                        });
                    }
                },
                error: function(xhr, status, error) {
                    $.LoadingOverlay("hide");
                    Swal.fire({
                        title: "Error",
                        text: "Something went wrong. Please try again later.",
                        icon: "error"
                    });
                    console.error('Error fetching results:', error);
                }
            });
        });
    </script>

    <script>
        $(function() {
            $('#search').on('change', function() {
                fetch_data(1); // Start from the first page when searching
            });
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                alert(page);
                fetch_data(page);
            });
        });
        var url = "<?php echo e(route('students.index')); ?>"

        function fetch_data(page) {
            var searchQuery = $('#search').val();
            var session_id = $('#session_id').val();
            var version_id = $('#version_id').val();
            var shift_id = $('#shift_id').val();
            var class_id = $('#class_id').val();
            var section_id = $('#section_id').val();
            var text_search = $('#text_search').val();
            var searchtext = ' & shift_id=' + shift_id + ' & version_id=' + version_id + '& class_id=' + class_id +
                '& section_id=' + section_id + '& session_id=' + session_id + '& text_search=' + text_search + '& search=' +
                searchQuery;
            url = "<?php echo e(route('students.index')); ?>";
            $.ajax({
                url: url + "?page=" + page + searchtext,
                success: function(data) {
                    $('#item-list').html(data);
                    window.history.pushState("", "", '?page=' + page + searchtext);
                }
            });
        }
    </script>
    <!-- <script>
        $(document).ready(function() {
            $('#headerTable').DataTable({
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                "pagingType": "full_numbers", // Optional: This gives you 'First', 'Previous', 'Next', 'Last' buttons
                "dom": 'lfrtip', // 'l' indicates the length menu dropdown
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script> -->
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
            $(document.body).on('click', '#searchtop', function() {
                var session_id = $('#session_id').val();
                var version_id = $('#version_id').val();
                var shift_id = $('#shift_id').val();
                var class_id = $('#class_id').val();
                var section_id = $('#section_id').val();
                var text_search = $('#text_search').val();
                location.href = "<?php echo e(route('students.index')); ?>" + '?shift_id=' + shift_id +
                    ' & version_id=' + version_id + '& class_id=' + class_id + '& section_id=' +
                    section_id + '& session_id=' + session_id + '& text_search=' + text_search;





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
                var url = "<?php echo e(route('getSections')); ?>";
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
            $(document.body).on('click', '.delete', function() {
                var id = $(this).data('id');
                var url = $(this).data('url');
                Swal.fire({
                    title: 'Do you want to Delete this Student?',
                    showDenyButton: true,
                    confirmButtonText: 'Yes',
                    denyButtonText: 'No',
                    customClass: {
                        actions: 'my-actions',
                        cancelButton: 'order-1 right-gap',
                        confirmButton: 'order-2',
                        denyButton: 'order-3',
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
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
                    } else if (result.isDenied) {

                    }
                })

            });
        });
    </script>
    <!-- Toastr.js -->



    <script>
        // Display Laravel success or error messages with Toastr
        <?php if(session('success')): ?>
            toastr.success("<?php echo e(session('success')); ?>", "Success", {
                closeButton: true,
                progressBar: true,
                timeOut: 3000,
            });
        <?php endif; ?>

        <?php if(session('error')): ?>
            toastr.error("<?php echo e(session('error')); ?>", "Error", {
                closeButton: true,
                progressBar: true,
                timeOut: 3000,
            });
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                toastr.error("<?php echo e($error); ?>", "Validation Error", {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 3000,
                });
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/bafsdadmission.com/httpdocs/resources/views/student/boardResult.blade.php ENDPATH**/ ?>