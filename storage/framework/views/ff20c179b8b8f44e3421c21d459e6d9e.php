<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0   d-xl-none ">
       <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
       <i class="bx bx-menu bx-sm"></i>
       </a>
    </div>
    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
       <!-- Search -->
       

       <!-- /Search -->
       <ul class="navbar-nav flex-row align-items-center ms-auto">
          <!-- Language -->

          <!-- /Language -->
          <!-- Quick links  -->

          <!-- Quick links -->
          <!-- Style Switcher -->

          <!-- / Style Switcher-->
          <!-- Notification -->

          <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
             
          </li>
          <!--/ Notification -->
          <!-- User -->

          <li class="nav-item navbar-dropdown dropdown-user dropdown">
             <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                <div class="avatar avatar-online">
                                 <?php if(Auth::user()->photo): ?>
                                <img src="<?php echo e(asset(Auth::user()->photo)); ?>"  alt style="width: 40px; height: 40px; border-radius: 50%">
                                <?php else: ?>
                                <img src="<?php echo e(asset('public/logo/logo.png')); ?>" alt style="width: 40px; height: 40px; border-radius: 50%">
                                <?php endif; ?>

                </div>
             </a>
             <ul class="dropdown-menu dropdown-menu-end">
                <li>
                   <a class="dropdown-item" href="#">
                      <div class="d-flex">
                         <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">

                                <?php if(Auth::user()->photo): ?>
                                <img src="<?php echo e(asset(Auth::user()->photo)); ?>" alt style="width: 40px; height: 40px; border-radius: 50%">
                                <?php else: ?>
                                <img src="<?php echo e(asset('public/logo/logo.png')); ?>" alt style="width: 40px; height: 40px; border-radius: 50%">
                                <?php endif; ?>

                            </div>
                         </div>
                         <div class="flex-grow-1">
                            <span class="fw-medium d-block"><?php echo e(Auth::user()->name); ?>


                            </span>
                            <small class="text-muted">
                              <?php if(Auth::user()->group_id==2): ?>
                              Admin
                              <?php elseif(Auth::user()->group_id==3): ?>
                              Class Teacher
                              <?php elseif(Auth::user()->group_id==4): ?>
                              Parent
                              <?php endif; ?>
                            </small>
                         </div>
                      </div>
                   </a>
                </li>
                <li>
                   <div class="dropdown-divider"></div>
                </li>
                <li>
                   <a class="dropdown-item" href="<?php echo e(route('change.password.form')); ?>">
                     <i class="bx bx-lock me-2"></i>
                   <span class="align-middle">Change Password</span>
                   </a>
                </li>

                <li>
                   <div class="dropdown-divider"></div>
                </li>
                <li>
					<a class="dropdown-item" href="<?php echo e(route('customlogout')); ?>"
                   >
                   <!--a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();"-->
                   <i class="bx bx-power-off me-2"></i>
                   <span class="align-middle">Log Out</span>
                   </a>

                  <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                  <?php echo csrf_field(); ?>
                  </form>
                </li>
             </ul>
          </li>
          <!--/ User -->
       </ul>
    </div>
    <!-- Search Small Screens -->


 </nav>
<?php /**PATH C:\laragon\www\college_admission\resources\views/admin/layouts/topnav.blade.php ENDPATH**/ ?>