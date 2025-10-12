<?php $__env->startSection('content'); ?>
    <style>
        .form-check {
            border-bottom: 1px solid #eee;
            font-size: 13px;
            padding: 5px;

        }

        .form-check a {
            color: black !important;
        }

        .form-check a:hover {
            color: #337AB7 !important;
            font-weight: bold;
        }

        .sidecourse-title a {
            font-size: 16px;
            font-weight: bold;
        }

        @media (min-width: 768px) {
            .modal-content {
                width: 620px !important;
            }
        }

        .onlineformbtns {
            border-radius: 30px !important;
            padding: 7px 20px;
            border: 0;
            display: inline-block;
            font-size: 14px;
            border-radius: 30px;
            background: #337AB7;
            text-decoration: none !important;
            color: #fff !important;
            text-align: center;
            /* line-height: 24px; */
            transition: all 0.5s ease 0s;
            box-shadow: 0px 5px 25px 0px rgba(189, 7, 69, 0.41);
        }

        .mdbtn {
            width: 114px;
            margin-top: 2px;
        }

        .form-check .form-check-input {
            float: left;
            margin-left: 0em !important;
        }

        table {
            width: 35%;
        }

        .noborder tbody,
        .noborder td,
        .noborder tr {
            border: none !important;
        }

        .form-check {
            border-bottom: 0px solid #eee;
            font-size: 13px;
            padding: 1px;
        }

        .modal-body p {
            margin-top: 0;
            margin-bottom: .2rem;
        }

        .background-image table {
            width: 310px !important;
            text-align: center;
            margin: 0px auto;
            border: 0px solid !important;
            --bs-table-bg: transparent;
        }

        .findAdmitcardt {
            width: 195px !important;
            text-align: center;
            margin: 0px auto;
            border: 0px solid !important;
            --bs-table-bg: transparent;
        }

        @media (min-width: 768px) {
            .modal-content {
                width: 800px !important;
            }

            .modal-dialog {
                margin-left: 18%;
            }
        }

        .background-image {
            background-image: url(<?php echo e(asset('public/062.png')); ?>);
            background-size: cover;
            /* Make the background cover the entire area */
            background-repeat: no-repeat;
            /* Prevent the background from repeating */
            background-position: center;
            /* Center the background image */
            padding: 0px !important;
            margin: 0px !important;
            max-width: 100% !important;
        }

        @media (max-width: 600px) {
            .modal-dialog {
                margin-left: 5%;
            }

            .modal-content {
                width: 90% !important;
            }

            h3,
            .h3,
            h4,
            .h4 {
                font-size: calc(.808125rem + 0.3375vw);
            }

            h4 span {
                font-size: 14px !important;
            }

            .btn {
                box-shadow: 0 0.25rem 0 rgba(0, 0, 0, 0.1);
                font-size: .7rem;
            }

            .background-image table {
                width: 240px !important;
                text-align: center;
                margin: 0px auto;
                border: 0px solid !important;

            }

            table.findAdmitcardt {
                width: 145px !important;
                text-align: center;
                margin: 0px auto;
                border: 0px solid !important;

            }

            .background-image {
                background-image: url(<?php echo e(asset('public/kg-admission-mobile.jpg')); ?>);
                background-size: cover;
                /* Make the background cover the entire area */
                background-repeat: no-repeat;
                /* Prevent the background from repeating */
                background-position: center;
                /* Center the background image */
                padding: 0px !important;
                margin: 0px !important;
                max-width: 100% !important;
            }

            .modal-content {
                width: 100% !important;
            }

            .modal-dialog {
                margin-left: 0%;
            }
        }

        .width-100 {
            width: 100%;
        }

        p {
            font-size: 1.175rem;
            color: #666;
            font-weight: bold;
        }

        label {
            margin-bottom: 0.2rem;
        }

        .background-image tr,
        .background-image tbody,
        .background-image td,
        .background-image .table {

            border: 0px solid !important;
        }

        @media (min-width: 768px) {
            .background-image {
                min-height: 455px;
            }
        }

        input:read-only {
            background-color: #f0f0f0;
            /* Light gray */
            color: #333;
            /* Dark text */
            border: 1px solid #ccc;
            /* Optional: border styling */
        }

        .btn:hover {
            color: black !important;
        }

        .form-check-input {

            border: var(--bs-border-width) solid #1d1d1d;
        }

        .row {
            --bs-gutter-x: .5rem;
            --bs-gutter-y: 0;
            display: flex;
            flex-wrap: wrap;
            margin-top: calc(-1* var(--bs-gutter-y));
            margin-right: calc(var(--bs-gutter-x));
            margin-left: calc(var(--bs-gutter-x));
        }

        .display-none {
            display: none !important;
        }

        .display-show {
            display: flex !important;
        }
    </style>
    <div class="container spacet20 ">
        <div class="row">
            <div class="col-md-12 spacet60 pt-0-mobile">


                <div class="row">
                    <div class="container spaceb50">
                        <div class="row">


                            <div class="refine-categ-header " style="margin-top: 10px;">

                                <h3 style="text-align: center">Online Admission (অনলাইন ভর্তি) </h3>
                                <h4 style="text-align: center"> <a
                                        href="<?php echo e(asset('public/admissionpdf/Onine Admission.pdf')); ?>"
                                        target="_blank">Admission Instruction (ভর্তির নির্দেশনা)</a> </h4>
                                <h4 style="text-align: center"> <img title="Hotline Number"
                                        src="<?php echo e(asset('public/call-thumbnail.png')); ?>" style="height: 25px" /> <a
                                        href="tel:01759536622" style="color: red;font-weight: bold;">01759536622, </a><a
                                        href="tel:01777521159" style="color: red;font-weight: bold;">01777521159</a> </h4>
                                <h4 style="text-align: center"> KG admission deadline: December 24, 2024 </h4>

                                <form action="<?php echo e(route('admissionDatakg')); ?>" method="post" enctype="multipart/form-data"
                                    class="onlineform" id="checkstatusform" style="min-height:400px">
                                    <input type="hidden" name="_token" id="csrf-token" value="<?php echo e(Session::token()); ?>" />
                                    <input type="hidden" name="version_id" id="version_id" value="" />
                                    <input type="hidden" name="class_id" id="class_id" value="" />
                                    <input type="hidden" name="session_id" id="session_id" value="" />
                                    <input type="hidden" name="shift_id" id="shift_id" value="" />
                                    <div class="modal-body" style="padding:0px">
                                        <div class="row">


                                            <div class="col-md-6" style="padding-bottom: 10px;">
                                                <label for="inputEmail4">Search By Admit Card Serial ID (সিরিয়াল আইডি
                                                    দ্বারা অনুসন্ধান করুন)<span style="color: red">*</span></label>
                                                <input type="text" class="form-control" id="temporary_id"
                                                    value="<?php echo e(old('temporary_id')); ?>" required="" name="temporary_id"
                                                    placeholder="Search By Admit Card Serial ID (সিরিয়াল আইডি দ্বারা অনুসন্ধান করুন)">
                                            </div>
                                            
                                        </div>
                                        <div class="row display-none">


                                            <div class="col">
                                                <label for="inputEmail4">Version (ভার্সন)<span
                                                        style="color: red">*</span></label>
                                                <input type="text" readonly="" class="form-control"
                                                    value="<?php echo e(old('version_name')); ?>" required="" id="version_name"
                                                    name="version_name" placeholder="Version Name">
                                            </div>
                                            <div class="col">
                                                <label for="inputEmail4">Shift (শিফট)<span
                                                        style="color: red">*</span></label>
                                                <input type="text" readonly="" class="form-control"
                                                    value="<?php echo e(old('shift_name')); ?>" required="" id="shift_name"
                                                    name="shift_name" placeholder="Shift Name">
                                            </div>

                                        </div>
                                        <div class="row display-none">
                                            <div class="col">
                                                <label for="inputEmail4">Candidate's English Name<span
                                                        style="color: red">*</span></label>
                                                <input type="text" readonly="" class="form-control"
                                                    value="<?php echo e(old('name_en')); ?>" style="text-transform:uppercase"
                                                    required="" id="name_en" name="name_en" placeholder="English Name">
                                            </div>
                                            <div class="col">
                                                <label for="inputEmail4">প্রার্থীর বাংলা নাম<span
                                                        style="color: red">*</span></label>
                                                <input type="text" readonly="" class="form-control" required=""
                                                    value="<?php echo e(old('name_bn')); ?>" id="name_bn" name="name_bn"
                                                    placeholder="Bangla Name">
                                            </div>


                                        </div>
                                        <div class="row display-none">
                                            <div class="col">
                                                <label for="inputEmail4">Phone (ফোন) (This Number Must be Used While
                                                    Enrolled In Shaheen College Dhaka)<span
                                                        style="color: red">*</span></label>
                                                <input type="text" class="form-control" required=""
                                                    value="<?php echo e(old('mobile')); ?>" name="mobile" id="mobile"
                                                    placeholder="Mobile" readonly disabled>
                                            </div>
                                            <div class="col">
                                                <label for="inputEmail4">Candidate's Birth Registration Number<span
                                                        style="color: red">*</span></label>
                                                <input type="text" readonly="" class="form-control"
                                                    value="<?php echo e(old('birth_registration_number')); ?>" required=""
                                                    id="birth_registration_number" name="birth_registration_number"
                                                    placeholder="Birth Registration Number">
                                            </div>


                                        </div>
                                        <div class="row display-none">

                                            <div class="col">
                                                <label for="inputEmail4">Username (ইউজার নাম) <span
                                                        style="color: red">*</span></label>
                                                <input type="text" class="form-control"
                                                    value="<?php echo e(old('full_name')); ?>" required="" id="username"
                                                    name="username" placeholder="Username (ইউজার নাম) ">
                                            </div>
                                            <div class="col">
                                                <label for="inputEmail4">Email (ই-মেইল)</label>
                                                <input type="text" class="form-control" value="<?php echo e(old('email')); ?>"
                                                    id="email" name="email" placeholder="Email (ই-মেইল)">
                                            </div>



                                        </div>




                                    </div>
                                    <div class="modal-footer display-none">
                                        <button type="button" class="onlineformbtns mdbtn"
                                            data-bs-dismiss="modal">Close</button>
                                        <input type="submit" class="onlineformbtns mdbtn"
                                            style="background-color: orange;width: 140px!important" name="submit"
                                            value="submit">
                                        <!-- <input type="submit" class="onlineformbtns mdbtn" style="background-color: green;" name="submit" value="Paynow"> -->
                                    </div>
                                </form>

                                <table class="table">
                                    <tr>
                                        <td style="text-align: center;border: none;">
                                            <a class="onlineformbtn" href="<?php echo e(route('login')); ?>" style="">Already
                                                Registered Click Here</a>
                                        </td>
                                    </tr>
                                </table>

                            </div>
                            <!--./refine-categ-header-->

                        </div>
                        <!--./row-->
                    </div>
                    <!--./container-->
                </div>

            </div>
        </div>
        <!--./row-->
    </div>


    <div id="checkOnlineAdmissionStatus" class="modal fade" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header modal-header-small">

                    <h4 style="width: 90%;text-align:center"><span
                            style="color: red; font-weight: bold;font-size:17px!important">KG Class Admission(কেজি শ্রেণিতে
                            ভর্তি)</span></h4>
                    <button type="button" class="close closebtnmodal" data-dismiss="modal">&times;</button>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade mb-8" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title " style="font-weight: bold;width: 98%;"><span style="color: #20aee5">বিএএফ
                            শাহিন কলেজ ঢাকা</span> <br /> <span style="color: red">(শিক্ষাবর্ষ ২০২৫ কেজি শ্রেণির
                            ভর্তি)</span><br /> <span style="color: rgb(46,49,146)" id="versiontext"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(route('admissionsearch')); ?>" method="post" enctype="multipart/form-data"
                    class="onlineform" id="checkstatusform">
                    <div class="modal-body">
                        <input type="hidden" name="_token" id="csrf-token" value="<?php echo e(Session::token()); ?>" />


                        <div class="row">

                            <p>Enter Your Temporary ID</p>

                            <div class="col">
                                <label for="inputEmail4">Temporary ID<span style="color: red">*</span></label>
                                <input type="text" class="form-control" value="<?php echo e(old('temporary_id')); ?>"
                                    style="text-transform:uppercase" required="" name="temporary_id"
                                    placeholder="Temporary ID">
                            </div>
                            <div class="col">
                                <label for="inputEmail4"></label><br />
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>


                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(document.body).on('click', '.findAdmitcard', function() {

                $('#exampleModal').modal('show');
            });
            $('#dob').on('change', function() {
                let category_id = $('input[name="category_id"]:checked').val();


                var dob = new Date($(this).val());
                if (!isNaN(dob.getTime())) { // Check if the date is valid
                    var today = new Date(2025, 0, 1); // February 1, 2025

                    // Calculate the age in terms of years, months, and days
                    var years = today.getFullYear() - dob.getFullYear();
                    var months = today.getMonth() - dob.getMonth();
                    var days = today.getDate() - dob.getDate();

                    // Adjust if the birth date hasn't occurred yet this month
                    if (days < 0) {
                        months--;
                        // Get the last day of the previous month
                        var lastDayOfPrevMonth = new Date(today.getFullYear(), today.getMonth(), 0)
                            .getDate();
                        days += lastDayOfPrevMonth;
                    }

                    // Adjust if the birth month hasn't occurred yet this year
                    if (months < 0) {
                        years--;
                        months += 12;
                    }

                    // Convert the calculated age to total days for comparison
                    var totalAgeDays = years * 365 + months * 30 + days;

                    // Minimum age: 4 years, 11 months, and 15 days
                    var minAgeDays = (4 * 365) + (11 * 30) + 15;
                    // Maximum age: 6 years and 15 days
                    var maxAgeDays = (6 * 365) + 15;

                    // Check if the total days fall within the valid range
                    if ((totalAgeDays >= minAgeDays && totalAgeDays <= maxAgeDays) || (category_id == 2 ||
                            category_id == 4)) {
                        $('#age').text(years + ' years, ' + months + ' months, ' + days + ' days').css(
                            'color', 'green');
                        $('#message').text('Age is within the valid range').css('color', 'green');
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: 'Age is not within the valid range',
                            icon: "warning"
                        });

                        $('#age').text('');
                        $(this).val('');
                        $('#message').text('Age is not within the valid range').css('color', 'red');
                    }
                } else {
                    $('#message').text('Please select a valid date');
                }
            });
        });


        <?php if($errors->any()): ?>

            <?php
                $text = '';
                foreach ($errors->all() as $error) {
                    $text .= '<p>' . $error . '</p>';
                }
            ?>


            Swal.fire({
                title: "Warning!",
                html: "<?php echo $text; ?>",
                icon: "warning"
            });
        <?php endif; ?>

        <?php if(Session::get('warning')): ?>

            Swal.fire({
                title: "Warning!",
                html: "<?php echo Session::get('warning'); ?>",
                icon: "warning"
            });
        <?php endif; ?>
        $(function() {

            $(document.body).on('click', '.kgadmission', function() {
                var versionid = $(this).data('versionid');
                var class_id = $(this).data('class_id');
                var session_id = $(this).data('session_id');
                var amount = $(this).data('amount');
                $('#versionid').val(versionid)
                $('#classid').val(class_id)
                $('#sessionid').val(session_id)
                $('#amount').val(amount)
                if (versionid == 1) {
                    $('#versiontext').text('ভার্সন বাংলা');
                } else {
                    $('#versiontext').text('Version English');
                }
                $('#exampleModalLong').modal('show');
            });
            $(document.body).on('click', '.findAdmitcard', function() {

                $('#exampleModal').modal('show');
            });
            $(document.body).on('click', '.onlineformbtn', function() {
                var versionid = $(this).data('versionid');
                var version_name = $(this).data('version');
                var class_id = $(this).data('class_id');
                var session_id = $(this).data('session_id');
                var price = $(this).data('price');
                $('#version_id').val(versionid);
                $('#class_id').val(class_id);
                $('#session_id').val(session_id);
                $('#price').val(price);
                var text = '';
                // if(versionid==1){
                //    text="KG Class Admission(কেজি শ্রেণিতে ভর্তি)"
                // }else{
                //    text="XI Class Admission-English Version<br/> (একাদশ শ্রেণিতে ভর্তি-ইংরেজি ভার্শন)"
                // }
                // $('#version_name').html(text);
                $('#checkOnlineAdmissionStatus').modal('show');
            });
            $(document.body).on('input', '#temporary_id', function() {

                var temporary_id = $('#temporary_id').val();

                var url = "<?php echo e(route('checkTemporaryId')); ?>";
                if (temporary_id?.length == 5) {
                    $.LoadingOverlay("show");
                    $.ajax({
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: url,
                        data: {
                            "_token": "<?php echo e(csrf_token()); ?>",
                            temporary_id
                        },
                        success: function(response) {

                            $.LoadingOverlay("hide");
                            if (response == 0) {

                                Swal.fire({
                                    title: "Warning",
                                    text: 'Serial No. of your admit card is not approved for admission',
                                    icon: "warning"
                                });
                                $('#version_name').val('');
                                $('#temporary_id').val('');
                                $('#version_id').val('');
                                $('#session_id').val('');
                                $('#shift_id').val('');
                                $('#shift_name').val('');
                                $('#name_en').val('');
                                $('#name_bn').val('');
                                $('#mobile').val('');
                                $('#birth_registration_number').val('');
                                $('.display-show').removeClass('display-show').addClass(
                                    'display-none');

                            } else if (response == 2) {

                                Swal.fire({
                                    title: "Warning",
                                    text: 'Allready admitted. Please login & update your admission form.',
                                    icon: "warning"
                                });
                                $('#version_name').val('');
                                $('#temporary_id').val('');
                                $('#version_name').val('');
                                $('#version_id').val('');
                                $('#session_id').val('');
                                $('#shift_id').val('');
                                $('#shift_name').val('');
                                $('#name_en').val('');
                                $('#name_bn').val('');
                                $('#mobile').val('');
                                $('#birth_registration_number').val('');
                                $('.display-show').removeClass('display-show').addClass(
                                    'display-none');
                            } else {
                                var data = jQuery.parseJSON(response)
                                $('#version_id').val(data.version_id);
                                $('#version_name').val(data.version_id == 1 ? 'Bangla' :
                                    'English');
                                $('#shift_name').val(data.shift_id == 1 ? 'Morning' : 'Day');

                                $('#session_id').val(2025);
                                $('#shift_id').val(data.shift_id);
                                $('#name_en').val(data.name_en);
                                $('#name_bn').val(data.name_bn);
                                $('#mobile').val(data.mobile);
                                $('#birth_registration_number').val(data
                                    .birth_registration_number);
                                $('.display-none').removeClass('display-none').addClass(
                                    'display-show');

                            }



                        },
                        error: function(data, errorThrown) {
                            $.LoadingOverlay("hide");
                            Swal.fire({
                                title: "Error",
                                text: errorThrown,
                                icon: "warning"
                            });
                            $('#version_name').val('');
                            $('#temporary_id').val('');
                            $('#version_name').val('');
                            $('#version_id').val('');
                            $('#session_id').val('');
                            $('#shift_id').val('');
                            $('#name_en').val('');
                            $('#name_bn').val('');
                            $('#mobile').val('');
                            $('#birth_registration_number').val('');

                        }
                    });
                }
            });
            $(document.body).on('submit', '#checkadmissionstatus', function(e) {


                e.preventDefault(); // avoid to execute the actual submit of the form.

                var form = $(this);
                var actionUrl = form.attr('action');
                $.LoadingOverlay("show");
                $.ajax({
                    type: "POST",
                    url: actionUrl,
                    data: form.serialize(), // serializes the form's elements.
                    success: function(data) {
                        $.LoadingOverlay("hide");
                        getPayment(data); // show response from the php script.
                    }
                });

            });
            $(document.body).on('change', '.category', function() {

                var category_id = $(this).val();
                $('#dob').val('');
                $('#age').html('');
                $('#message').html('');
                var url = "<?php echo e(route('getCategoryView')); ?>";
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "<?php echo e(csrf_token()); ?>",
                        category_id
                    },
                    success: function(response) {

                        $.LoadingOverlay("hide");
                        console.log(response);
                        $('#categoryview').html(response);

                    },
                    error: function(data, errorThrown) {
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            title: "Error",
                            text: errorThrown,
                            icon: "warning"
                        });
                        $('#categoryview').html('');

                    }
                });

            });
            $(document.body).on('change', '#onlineformbtn', function() {

            });
            $(document.body).on('change', '#username', function() {

                var username = $('#username').val();
                username = username.replace(/\s/g, '');



                var url = "<?php echo e(route('usernamecheck')); ?>";
                if (username.length > 0) {
                    $.LoadingOverlay("show");
                    $.ajax({
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: url,
                        data: {
                            "_token": "<?php echo e(csrf_token()); ?>",
                            username
                        },
                        success: function(response) {

                            $.LoadingOverlay("hide");
                            if (response == 1) {
                                $('#username').val('');
                                Swal.fire({
                                    title: "Error",
                                    text: 'Username Already Exist.',
                                    icon: "warning"
                                });
                            } else {
                                $('#username').val(username);
                            }

                        },
                        error: function(data, errorThrown) {
                            $.LoadingOverlay("hide");
                            $('#username').val('');
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

<?php echo $__env->make('frontend-new.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/kgadmission/resources/views/frontend-new/admissionlistkg.blade.php ENDPATH**/ ?>