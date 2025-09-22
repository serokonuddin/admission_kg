<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact " dir="ltr"
    data-theme="theme-default" data-assets-path="<?php echo e(asset('public')); ?>/backend//assets/"
    data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>BAF Shaheen College Dhaka</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <meta name="description" content="BAF Shaheen College Dhaka" />
    <meta name="keywords" content="school,college,student,teacher">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('logo/favicon.png')); ?>" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap"
        rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="<?php echo e(asset('public')); ?>/backend//assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="<?php echo e(asset('public')); ?>/backend//assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="<?php echo e(asset('public')); ?>/backend//assets/vendor/fonts/flag-icons.css" />
    <!-- Core CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('public')); ?>/backend//assets/vendor/css/rtl/core.css"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?php echo e(asset('public')); ?>/backend//assets/vendor/css/rtl/theme-default.css"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?php echo e(asset('public')); ?>/backend//assets/css/demo.css" />
    <link rel="stylesheet" href="<?php echo e(asset('public')); ?>/backend//assets/css/dashboard.css" />
    <!-- Vendors CSS -->
    <link rel="stylesheet"
        href="<?php echo e(asset('public')); ?>/backend//assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="<?php echo e(asset('public')); ?>/backend//assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="<?php echo e(asset('public')); ?>/backend//assets/vendor/libs/apex-charts/apex-charts.css" />
    <!-- Page CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('public')); ?>/backend//assets/vendor/css/pages/card-analytics.css" />
    <link rel="stylesheet" href="<?php echo e(asset('public')); ?>/backend//css/index.min.css" />
    <!-- Helpers -->
    <script src="<?php echo e(asset('public')); ?>/backend//assets/vendor/libs/jquery/jquery.js"></script>
    <script src="<?php echo e(asset('public')); ?>/backend//assets/vendor/js/helpers.js"></script>
    <link rel="stylesheet"
        href="<?php echo e(asset('public')); ?>/backend//assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css">
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?php echo e(asset('public')); ?>/backend//assets/js/config.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?php echo e(asset('public')); ?>/backend//assets/vendor/js/template-customizer.js"></script>
    <script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        :root {
            --bs-breadcrumb-divider: ">";
        }

        .scrollable {
            overflow-y: scroll;
            max-height: 500px;
            scrollbar-width: thin;
            scrollbar-color: #888 #f1f1f1;
        }

        .breadcrumb a {
            text-decoration: none;
            color: #007bff;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
            color: #0056b3;
        }

        .clockdate-wrapper {
            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

            color: rgb(0, 149, 221) border-radius:5px;
            margin: 0 auto;
            text-align: center;

        }

        #clock {
            font-family: Digital-7, 'sans-serif';
            font-size: 20px;
            text-shadow: 0px 0px 1px #fff;
            color: rgb(0, 149, 221);
            font-weight: bold;
        }

        #clock span {
            color: rgb(0, 149, 221);
            text-shadow: 0px 0px 1px #333;
            font-size: 20px;
            position: relative;

            left: 5px;
        }

        #date {
            font-size: 14px;
            font-weight: bold;
            font-family: arial, sans-serif;
            color: rgb(0, 149, 221);
        }

        .avatar.avatar-online {
            position: relative;
            width: 3rem !important;
            height: 2rem !important;
            cursor: pointer;
        }

        .search-input-wrapper {
            width: 100%;
        }

        ::-webkit-scrollbar {
            width: 10px;
        }

        .fixTableHead,
        .fixed {
            overflow-y: auto;
            height: 90vh;
        }

        .fixed thead th,
        .fixTableHead thead th {
            position: sticky;
            top: 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        .pagination {
            padding: 10px;
        }

        .content-wrapper {
            height: calc(100vh - 60px);
            /* Subtract height of navbar and footer */
            overflow-y: auto;
            /* Vertical scrolling enabled */
        }

        /* Customize the scrollbar */
        .content-wrapper::-webkit-scrollbar {
            width: 15px;
        }

        .content-wrapper::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 4px;
        }

        .content-wrapper::-webkit-scrollbar-thumb:hover {
            background-color: #555;
            cursor: pointer;
        }


        @media (max-width: 600px) {
            .navbar-nav {
                width: 190px !important;
            }
        }
    </style>



</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar  ">
        <div class="layout-container">
            <!-- Menu -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo ">
                    <a href="<?php echo e(route('dashboard')); ?>" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <img src="<?php echo e(asset('public/logo/logo.png')); ?>" width="50" />
                        </span>

                    </a>
                    <a href="javascript:void(0);">
                        <div class="navbar-nav " style="margin-left:5%;width: 100%;">
                            <!-- Digital Clock HTML -->
                            <div id="clockdate">
                                <div class="clockdate-wrapper">
                                    <div id="clock"></div>
                                    <div id="date"></div>
                                </div>
                            </div>
                            <!-- End Digital Clock HTML -->
                        </div>
                    </a>
                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>
                <div class="menu-inner-shadow"></div>
                <?php echo $__env->make('admin.layouts.leftnav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </aside>
            <!-- / Menu -->
            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <?php echo $__env->make('admin.layouts.topnav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="content-wrapper">
                    <?php echo $__env->yieldContent('content'); ?> <!-- Dynamic content goes here -->
                </div>
                <?php echo $__env->make('admin.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <!-- / Layout page -->
        </div>
        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="<?php echo e(asset('public')); ?>/backend//assets/vendor/libs/popper/popper.js"></script>
    <script src="<?php echo e(asset('public')); ?>/backend//assets/vendor/js/bootstrap.js"></script>
    <script src="<?php echo e(asset('public')); ?>/backend//assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="<?php echo e(asset('public')); ?>/backend//assets/vendor/libs/hammer/hammer.js"></script>
    <script src="<?php echo e(asset('public')); ?>/backend//assets/vendor/libs/i18n/i18n.js"></script>
    <script src="<?php echo e(asset('public')); ?>/backend//assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="<?php echo e(asset('public')); ?>/backend//assets/vendor/js/menu.js"></script>
    <!-- endbuild -->
    <!-- Vendors JS -->
    <script src="<?php echo e(asset('public')); ?>/backend//assets/vendor/libs/apex-charts/apexcharts.js"></script>
    <!-- Main JS -->

    <!-- Page JS -->


    <script src="<?php echo e(asset('public')); ?>/backend//assets/vendor/libs/select2/select2.js"></script>
    <script src="<?php echo e(asset('public')); ?>/backend//assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
    <script src="<?php echo e(asset('public')); ?>/backend//assets/vendor/libs/moment/moment.js"></script>
    <script src="<?php echo e(asset('public')); ?>/backend//assets/vendor/libs/flatpickr/flatpickr.js"></script>
    <script src="<?php echo e(asset('public')); ?>/backend//assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="<?php echo e(asset('public')); ?>/backend//assets/vendor/libs/tagify/tagify.js"></script>
    <script src="<?php echo e(asset('public')); ?>/backend//assets/vendor/libs/@form-validation/umd/bundle/popular.min.js">
    </script>
    <script
        src="<?php echo e(asset('public')); ?>/backend//assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js">
    </script>
    <script
        src="<?php echo e(asset('public')); ?>/backend//assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js">
    </script>

    <script src="<?php echo e(asset('public')); ?>/backend//assets/js/main.js"></script>


    <!-- Page JS -->
    <script src="<?php echo e(asset('public')); ?>/backend//assets/js/form-validation.js"></script>

    <script src="<?php echo e(asset('public')); ?>/backend/assets/vendor/libs/bs-stepper/bs-stepper.js"></script>
    <script src="<?php echo e(asset('public')); ?>/backend/assets/js/form-wizard-icons.js"></script>

    <script>
        $(function() {
            $(document.body).on('click', '.viewsearch', function() {
                $('.search-input-wrapper').removeClass('d-none');
                //$('.navbar-search-suggestion').toggle('tt-open');
                $('#navbar-collapse').addClass('d-none');
            });
            $(document.body).on('click', '.close-search', function() {

                $('.search-input-wrapper').addClass('d-none');
                //$('.navbar-search-suggestion').toggle('tt-open');
                $('#navbar-collapse').removeClass('d-none');
            });
            // $(document.body).on('click','.d-md-inline-block',function(){
            //    $('.search-input-wrapper').toggleClass('d-none');
            //   $('#navbar-collapse').toggleClass('d-none');
            // });
        });

        function startTime() {
            var today = new Date();
            var hr = today.getHours();
            var min = today.getMinutes();
            var sec = today.getSeconds();
            ap = (hr < 12) ? "<span>AM</span>" : "<span>PM</span>";
            hr = (hr == 0) ? 12 : hr;
            hr = (hr > 12) ? hr - 12 : hr;
            //Add a zero in front of numbers<10
            hr = checkTime(hr);
            min = checkTime(min);
            sec = checkTime(sec);
            document.getElementById("clock").innerHTML = hr + ":" + min + ":" + sec + " " + ap;

            var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October',
                'November', 'December'
            ];
            var days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            var curWeekDay = days[today.getDay()];
            var curDay = today.getDate();
            var curMonth = months[today.getMonth()];
            var curYear = today.getFullYear();
            var date = curWeekDay + ", " + curDay + " " + curMonth + " " + curYear;
            document.getElementById("date").innerHTML = date;

            var time = setTimeout(function() {
                startTime()
            }, 500);
        }

        function checkTime(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }
        startTime();

        function fnExcelReport() {
            var tab_text = "<table border='2px'><tr bgcolor='#87AFC6'>";
            var j = 0;
            var tab = document.getElementById('headerTable'); // id of table

            for (j = 0; j < tab.rows.length; j++) {
                tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
                //tab_text=tab_text+"</tr>";
            }

            tab_text = tab_text + "</table>";
            tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, ""); //remove if u want links in your table
            tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
            tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

            var msie = window.navigator.userAgent.indexOf("MSIE ");

            // If Internet Explorer
            if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
                txtArea1.document.open("txt/html", "replace");
                txtArea1.document.write(tab_text);
                txtArea1.document.close();
                txtArea1.focus();

                sa = txtArea1.document.execCommand("SaveAs", true, "Say Thanks to Sumit.xls");
            } else {
                // other browser not tested on IE 11
                sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
            }

            return sa;
        }
    </script>
</body>

</html>
<?php /**PATH /var/www/vhosts/bafsdadmission.com/httpdocs/resources/views/admin/layouts/layout.blade.php ENDPATH**/ ?>