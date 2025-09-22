<?php $__env->startSection('content'); ?>
    <style>
        .form-label {
            font-weight: 600;
        }

        .upload-section {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 30px;
        }

        .breadcrumb {
            background: none;
            padding: 0;
            margin-bottom: 1.5rem;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            color: #6c757d;
        }

        .btn-primary,
        .btn-success {
            padding: 0.5rem 1.5rem;
            font-weight: 500;
        }

        .card {
            border: none;
        }

        .card-body {
            padding: 2rem;
        }

        .btn-group-custom {
            display: flex;
            gap: 1rem;
            align-items: flex-end;
        }

        .custom-label-note {
            font-size: 0.875rem;
            color: #6c757d;
        }
    </style>

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Students Payment ID Update</li>
                </ol>
            </nav>

            <!-- Upload Form Card -->
            <div class="card">
                <div class="card-body upload-section">
                    <form id="formAdmission" method="POST" action="<?php echo e(route('studentPIDUploadSave')); ?>"
                        enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="row g-4 align-items-center">
                            <!-- File Input -->
                            <div class="col-md-6">
                                <label for="studentXl" class="form-label">Upload Excel File</label>
                                <input type="file" name="studentXl" class="form-control" id="studentXl" required>
                                <small class="custom-label-note">Allowed formats: XLSX, XLS, CSV. Max file size:
                                    200KB.</small>
                            </div>

                            <?php if(Auth::user()->is_view_user == 0): ?>
                                <!-- Buttons -->
                                <div class="col-md-6 btn-group-custom">
                                    <button type="submit" class="btn btn-primary">Upload</button>
                                    <button type="button" id="excelDownload" class="btn btn-success">
                                        Download Format
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="content-backdrop fade"></div>
    </div>

    <script>
        $('#excelDownload').on('click', function() {
            downloadExcel();
        });

        function downloadExcel() {

            // Trigger the download
            const APP_ENV = "<?php echo e(config('app.env')); ?>";

            if (APP_ENV === 'local') {
                var downloadUrl = '/bafsd/admin/pidformat-export';
            } else if (APP_ENV === 'production') {
                var downloadUrl = '/admin/pidformat-export'
            }

            // Create a hidden iframe to detect when the download starts
            var iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            iframe.src = downloadUrl;
            // Append iframe to the body to trigger download
            document.body.appendChild(iframe);
            // Use a timeout to hide the loader after the download starts
            monitorDownload();
            // Fallback to hide loader after a maximum time in case of errors
            $.LoadingOverlay("hide");
        }
    </script>

    <!-- Toastr Alerts -->
    <script>
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

<?php echo $__env->make('admin.layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/bafsdadmission.com/httpdocs/resources/views/student/studentPIDUpload.blade.php ENDPATH**/ ?>