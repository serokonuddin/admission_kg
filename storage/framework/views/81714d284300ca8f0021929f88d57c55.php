
<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-wide customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="<?php echo e(asset('/')); ?>public/backend/assets/"
  data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>BAF Shaheen College</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('/')); ?>public/backend/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="<?php echo e(asset('/')); ?>public/backend/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('/')); ?>public/backend/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?php echo e(asset('/')); ?>public/backend/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?php echo e(asset('/')); ?>public/backend/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('/')); ?>public/backend/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="<?php echo e(asset('/')); ?>public/backend/assets/vendor/css/pages/page-auth.css" />

    <!-- Helpers -->
    <script src="<?php echo e(asset('/')); ?>public/backend/assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?php echo e(asset('/')); ?>public/backend/assets/js/config.js"></script>
  </head>

  <body>
    <!-- Content -->
	<div class="modal fade" id="loginBlockModal" tabindex="-1" aria-labelledby="loginBlockLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="loginBlockLabel" style="color: white;margin-left: 42%;">সতর্কতা</h5>
                    <!--button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button-->
                </div>
                <div class="modal-body">
                    সকাল ৮:০০ ঘটিকা হতে রাত ১২:০০ ঘটিকা পর্যন্ত অনলাইন ভর্তি কার্যক্রম চালু থাকবে।
                </div>
                <div class="modal-footer">
                    <!--button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Okay</button-->
                </div>
            </div>
        </div>
    </div>
    <div class="container-xxl">
		
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                <a href="<?php echo e(url('/')); ?>" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">
                   <img src="<?php echo e(asset('public/logo/logo.png')); ?>" height="100" />
                  </span>
                  
                </a>
                <p style="display: block;    position: absolute;
    margin-top: 140px;">SHAHEEN SOFT</p>
              </div>
              <!-- /Logo -->
              <h4 class="mb-2">BAF SHAHEEN COLLEGE DHAKA</h4>
              

              <form  class="mb-3" action="<?php echo e(route('login')); ?>" method="POST">
              <?php echo csrf_field(); ?>
                <div class="mb-3">
                  <label for="email" class="form-label">Email or Username</label>
                  <input
                    type="text"
                    class="form-control"
                    id="email"
                    name="email"
                    placeholder="Enter your email or username"
                    autofocus />
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Password</label>
                    <a href="auth-forgot-password-basic.html">
                      <small>Forgot Password?</small>
                    </a>
                  </div>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password" />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                <div class="mb-3">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember-me" />
                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                  </div>
                </div>
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                </div>
              </form>

              
            </div>
          </div>
          <!-- /Register -->
        </div>
      </div>
    </div>

    <!-- / Content -->

    

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="<?php echo e(asset('/')); ?>public/backend/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="<?php echo e(asset('/')); ?>public/backend/assets/vendor/libs/popper/popper.js"></script>
    <script src="<?php echo e(asset('/')); ?>public/backend/assets/vendor/js/bootstrap.js"></script>
    <script src="<?php echo e(asset('/')); ?>public/backend/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="<?php echo e(asset('/')); ?>public/backend/assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="<?php echo e(asset('/')); ?>public/backend/assets/js/main.js"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
	  <script>
		$(function () {
			var currentHour = new Date().getHours();

			// Show modal if time is between 9 PM (21) and 8 AM (8)
			if (currentHour >= 0 && currentHour < 7) {
				$('#loginBlockModal').modal({
					backdrop: 'static', // Prevent closing by clicking outside
					keyboard: false      // Prevent closing with ESC key
				});
				$('#loginBlockModal').modal('show');
			}
		});
	</script>
  </body>
</html>





















<?php /**PATH /var/www/vhosts/bafsdadmission.com/httpdocs/resources/views/auth/login.blade.php ENDPATH**/ ?>