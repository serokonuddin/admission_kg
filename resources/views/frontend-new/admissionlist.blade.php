@extends('frontend-new.layout')
@section('content')
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
      background-image: url({{asset('public/062.png')}});
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

   .ml-3 {
      margin-left: 33%;
   }

   @media (max-width: 600px) {
      .ml-3 {
         margin-left: 3%;
      }

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
         background-image: url({{asset('public/kg-admission-mobile.jpg')}});
   background-size: cover;
   /* Make the background cover the entire area */
   background-repeat: no-repeat;
   /* Prevent the background from repeating */
   background-position: center center;
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


   .btn:hover {
      color: black !important;
   }

   .form-check-input {

      border: var(--bs-border-width) solid #1d1d1d;
   }
	
	.admission-link {
        color: #337AB7;       /* Blue text */
        font-weight: bold;  /* Bold text */
        text-decoration: none; /* Remove underline if desired */
        animation: blink 3s step-start infinite; /* Blink effect */
		}

		@keyframes blink {
			20% {
				opacity: 0;
			}
		}
	 @media (max-width: 767px) {
        .col-sm-3 {
            margin-top: 25px; /* adds spacing between stacked cards */
        }
        .card {
            width: 100%; 
            min-height: auto; /* prevents height forcing overlap */
        }
    }
</style>
<style>
        .top-right-link {
            position: absolute;
            top: 155px;
            right: 15px;
            background-color: #f8f9fa;
            padding: 8px 15px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            z-index: 1000;
            font-weight: bold;
            border: 1px solid #dee2e6;
        }
        .top-right-link a {
            text-decoration: none;
            color: #0d6efd;
        }
        .top-right-link a:hover {
            text-decoration: underline;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease;
        }
        .card-icon-border-large {
            border: 2px solid;
            border-radius: 50%;
            width: 80px;
            height: 80px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            line-height: 1.5;
        }
        .admission-link {
            color: #0d6efd;
            text-decoration: none;
        }
        .admission-link:hover {
            text-decoration: underline;
        }
        .spacet60 {
            padding-top: 60px;
        }
        .spaceb50 {
            padding-bottom: 50px;
        }
        .spacet20 {
            padding-top: 20px;
        }
        .refine-categ-header {
            position: relative;
        }
        @media (max-width: 768px) {
            .pt-0-mobile {
                padding-top: 0 !important;
            }
            .top-right-link {
                position: relative;
                top: 0;
                right: 0;
                text-align: center;
                margin-bottom: 15px;
            }
        }
    </style>
<div class="modal fade" id="loginBlockModal" tabindex="-1" aria-labelledby="loginBlockLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header bg-danger text-white">
            <h5 class="modal-title" id="loginBlockLabel" style="color: white;margin-left: 42%;">সতর্কতা</h5>
         </div>
         <div class="modal-body">
            অনলাইন ভর্তি প্রক্রিয়া রাত ১২:০০টা থেকে সকাল ৭:০০ টা পর্যন্ত বন্ধ থাকবে।
         </div>
      </div>
   </div>
</div>

<div class="container spacet20 background-image">
   <div class="row">
      <div class="col-md-12 spacet60 pt-0-mobile">
		  <div class="top-right-link">
                    <a href="https://online.bafsdadmission.com/">
                        ১ম থেকে ৮ম শ্রেণির অনলাইন ভর্তি। শিক্ষাবর্ষ : ২০২৬
                    </a>
                </div>
         <div class="row">
            <div class="container spaceb50">
               <div class="row">
                  <div class="refine-categ-header" style="margin-top: 10px;">
                     <h3 style="text-align: center;font-weight: bold">Online Admission KG (2026) (অনলাইন ভর্তি)</h3>
                     <h4 style="text-align: center;font-weight: bold">
                        <a href="{{ asset('public/admission/KG _ Admission.pdf') }}"
                           target="_blank" class="admission-link">
                           Application Instruction (ভর্তির আবেদনের নির্দেশিকা)
                        </a>
                     </h4>

                     <h4 style="text-align: center">
                        <img title="Hotline Number" src="{{asset('public/call-thumbnail.png')}}" style="height: 25px" />
                        <a href="tel:01759536622" style="color: red;font-weight: bold;">01759536622, </a>
                        <a href="tel:01777521159" style="color: red;font-weight: bold;">01777521159</a>
                     </h4>

                     <div style="text-align: center;">
                        <h4 style="color: #212529; font-weight: bold; font-size: 20px; margin-bottom: 15px;">
                           Last Date of Application
                        </h4>
                        <div
                                        style="display: inline-block; background-color: #f8f9fa; padding: 15px 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-top: -10px; min-width: 320px;">
                                        <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                                            <span style="font-size: 16px; font-weight: 600; color: #333;"><strong>BAF, SD/SEMC &
                                                    GEN:</strong></span>
                                            <span style="font-size: 16px; font-weight: bold; color: #d63384;">08 November
                                                2025</span>
                                        </div>
                                        <div style="display: flex; justify-content: space-between;">
                                            <span
                                                style="font-size: 16px; font-weight: 600; color: #333;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Civil:</strong>&nbsp;&nbsp;
                                            </span>
                                            <span style="font-size: 16px; font-weight: bold; color: #d63384;">22 November
                                                2025</span>
                                        </div>
                                    </div>

                     </div>
					<h4 style="text-align: center;color: black;font-weight: bold"> <br />
                                    <div style="margin-top: 10px;">
                                    </div>
                                </h4>
                     <section class="d-sm-block ml-3" style="margin-top: 30px;">
                        <div class="container">
                           <div class="row wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                              @foreach ($admissiondata as $key => $admission)
                                                <div class="col-sm-3">
                                                    <div class="card @if ($admission->version_id == 1) bg-danger @else bg-success @endif card-hover"
                                                        style="min-height: 164px">
                                                        <div class="card-body text-center p-0 pb-2">
                                                            <div class="card-icon-border-large @if ($admission->version_id == 1) border-danger @else border-success @endif"
                                                                style="font-size: 18px; line-height: 1.5; padding: 6px; display: flex; align-items: center; justify-content: center;">
                                                                @if ($admission->version_id == 1)
                                                                    <strong>বাংলা<br>ভার্শন</strong>
                                                                @else
                                                                    <strong>English<br>Version</strong>
                                                                @endif
                                                            </div>
                                                            <button type="button"
                                                                class="btn mt-3 @if ($admission->version_id == 1) btn-success @else btn-danger @endif kgadmission"
                                                                data-versionid="{{ $admission->version_id }}"
                                                                data-class_id="{{ $admission->class_id }}"
                                                                data-session_id="{{ $admission->session_id }}"
                                                                data-amount="{{ $admission->price }}"
                                                                fdprocessedid="fyjlka">
                                                                Apply Now
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                           </div>
                        </div>
                     </section>

                     <table class="table findAdmitcardt" style="margin-top: 10px;">
                        <tr>
                           <td style="text-align: center;border: none;">
                              <button type="button" class="btn btn-primary findAdmitcard" style="background-color: #00ADEF; margin-top: -40px">
                                 Get Admit Card
                              </button>
                           </td>
                        </tr>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="modal fade mb-8" id="exampleModalLong" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header text-center">
            <h5 class="modal-title" style="font-weight: bold;width: 98%;">
               <span style="color: #20aee5">বিএএফ শাহীন কলেজ ঢাকা</span><br>
               <span style="color: red">(শিক্ষাবর্ষ ২০২৬ কেজি শ্রেণির ভর্তি)</span><br>
               <span style="color: rgb(46,49,146)" id="versiontext"></span>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <form action="{{route('admissionstore')}}" method="post" enctype="multipart/form-data" class="onlineform" id="checkstatusform">
            <div class="modal-body">
               <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
               <input type="hidden" id="versionid" name="version_id" />
               <input type="hidden" id="classid" name="class_id" />
               <input type="hidden" id="sessionid" name="session_id" />
               <input type="hidden" id="amount" name="amount" />
               
               <p>Which Shift Do You Want To Get Admitted Into KG?</p>
               <div class="row">
                  <div class="col-md-12">
                     <table class="noborder width-100">
                        <tr>
                           <td>
                              <div class="form-check">
                                 <input class="form-check-input" type="radio" name="shift_id" id="flexRadioDefault1" value="1" checked="">
                                 <label class="form-check-label" for="flexRadioDefault1">&nbsp;Morning</label>
								  <span id="seatInfo1" class="mt-2 text-center"
                                                    style="font-weight: bold; color: #198754;"></span>
                              </div>
                           </td>
                           <td>
                              <div class="form-check">
                                 <input class="form-check-input" type="radio" name="shift_id" id="flexRadioDefault2" value="2">
                                 <label class="form-check-label" for="flexRadioDefault2">&nbsp;Day</label>
								  <span id="seatInfo2" class="mt-2 text-center"
                                                    style="font-weight: bold; color: #198754;"></span>
                              </div>
                           </td>
                        </tr>
                     </table>
                  </div>
               </div>

               <p>Select Candidate's Category</p>
               <div class="row">
                  <div class="col-md-12">
                     <table class="noborder width-100">
                        <tr>
                           <td>
                              <div class="form-check d-flex">
                                 <input class="form-check-input category" required type="radio" name="category_id" id="1" value="1" checked="">
                                 <label class="form-check-label" for="1">&nbsp;Civil- Child of Civil Person</label>
                              </div>
                           </td>
							<!--
                           <td>
                              <div class="form-check d-flex">
                                 <input class="form-check-input category" required type="radio" name="category_id" id="2" value="2">
                                 <label class="form-check-label" for="2">&nbsp;BAF- Child of BAF Employee (Active Service Only)</label>
                              </div>
                           </td> -->
                        </tr>
						 <!--
                        <tr>
                           <td>
                              <div class="form-check d-flex">
                                 <input class="form-check-input category" type="radio" required name="category_id" id="3" value="3">
                                 <label class="form-check-label" for="3">&nbsp;SD/SEMC- Child of BAF Shaheen College Employee</label>
                              </div>
                           </td>
                           <td>
                              <div class="form-check d-flex">
                                 <input class="form-check-input category" type="radio" required name="category_id" id="4" value="4">
                                 <label class="form-check-label" for="4">&nbsp;GEN- Student of Golden Eagle Nursery, Dhaka</label>
                              </div>
                           </td>
                        </tr> -->
                     </table>
                  </div>
               </div>

               <div class="row">
                  <div class="col-md-12" id="categoryview"></div>
               </div>

               <div class="row">
                  <p>Personal Information</p>
                  <div class="col">
                     <label for="inputEmail4">Candidate's English Name<span style="color: red">*</span></label>
                     <input type="text" class="form-control" value="{{old('name_en')}}" style="text-transform:uppercase" required name="name_en" placeholder="English Name">
                  </div>
                  <div class="col">
                     <label for="inputEmail4">প্রার্থীর বাংলা নাম<span style="color: red">*</span></label>
                     <input type="text" class="form-control" required value="{{old('name_bn')}}" name="name_bn" placeholder="Bangla Name">
                  </div>
               </div>

               <br>

               <div class="row">
                  <div class="col">
                     <label for="inputEmail4">Candidate's Date Of Birth<span style="color: red">*</span><span id="age"></span></label>
                     <input type="date" class="form-control" required value="{{old('dob')}}" id="dob" name="dob" placeholder="Date of Birth">
                     <span id="message"></span>
                  </div>
                  <div class="col">
                     <label for="inputEmail4">Candidate's Gender<span style="color: red">*</span></label>
                     <select class="form-select form-control" required name="gender" aria-label="Default select example">
                        <option value="1" {{(old('gender')==1)?'selected="selected"':''}}>Male</option>
                        <option value="2" {{(old('gender')==2)?'selected="selected"':''}}>Female</option>
                     </select>
                  </div>
               </div>

               <br>

               <div class="row">
                  <div class="col">
                     <label for="inputEmail4">Gurdian's Name<span style="color: red">*</span></label>
                     <input type="text" class="form-control" required value="{{old('gurdian_name')}}" name="gurdian_name" placeholder="Gurdian Name">
                  </div>
                  <div class="col">
                     <label for="inputEmail4">Mobile Number<span style="color: red">*</span></label>
                     <input type="text" class="form-control" required value="{{old('mobile')}}" name="mobile" placeholder="Mobile">
                  </div>
               </div>

               <br>

               <div class="row">
                  <div class="col">
                     <label for="inputEmail4">Candidate's Birth Registration Number<span style="color: red">*</span></label>
                     <input type="text" class="form-control" value="{{old('birth_registration_number')}}" required name="birth_registration_number" placeholder="Birth Registration Number">
                  </div>
               </div>

               <br>

               <div class="row">
                  <div class="col">
                     <label for="photo">Candidate's Photo<span style="color: red">*</span>(File size max 200 KB, accepted formats: .jpg, .jpeg)</label>
                     <input type="file" class="form-control" required id="photo" name="photo" accept=".jpg,.jpeg" placeholder="photo">
                     <div class="mt-2">
                        <img id="photo-preview" src="#" alt="Preview" style="display:none; max-width:150px; border-radius:6px; border:1px solid #ddd; padding:3px;">
                     </div>
                  </div>
                  <div class="col">
                     <label for="birth_image">Candidate's Birth Registration Certificate<span style="color: red">*</span>(File size max 200 KB, accepted formats: .pdf, .jpg, .jpeg)</label>
                     <input type="file" class="form-control" required id="birth_image" name="birth_image" accept=".pdf,.jpg,.jpeg">
                     <div class="mt-2" id="birth-preview-box" style="display:none;">
                        <img id="birth-preview-img" src="#" alt="Preview" style="max-width:150px; border:1px solid #ddd; border-radius:6px; padding:3px; display:none;">
                        <div id="birth-preview-pdf" style="display:none; border:1px solid #ddd; border-radius:6px; padding:6px; max-width:250px;">
                           <i class="fa fa-file-pdf-o" style="color:red; margin-right:8px;"></i>
                           <span id="birth-pdf-name" style="font-size:14px;"></span>
                        </div>
                     </div>
                  </div>
				   
               </div>
				<div class="row">
				<div class="col-6">
                                
                                 <label for="inputEmail4">Captcha<span
                                        style="color: red">*</span></label></br>
                                   <img src="{{ route('captcha.image') }}" alt="captcha" style="width: 25%;display: inline">
                                
                                    <input type="text" name="captcha" required="" style="width: 70%;display: inline" class="form-control" placeholder="Enter the Captcha">
                               
                            </div>
				</div>
            </div>

            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary">Pay Now</button>
            </div>
         </form>
      </div>
   </div>
</div>

<div class="modal fade mb-8" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header text-center">
            <h5 class="modal-title" style="font-weight: bold;width: 98%;">
               <span style="color: #20aee5">বিএএফ শাহীন কলেজ ঢাকা</span><br>
               <span style="color: red">(শিক্ষাবর্ষ ২০২৬ কেজি শ্রেণির ভর্তি)</span><br>
               <span style="color: rgb(46,49,146)" id="versiontext"></span>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <form action="{{route('admissionsearch')}}" method="post" enctype="multipart/form-data" class="onlineform" id="checkstatusform">
            <div class="modal-body">
               <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
               <div class="row">
                  <p>Enter Your Temporary ID</p>
                  <div class="col">
                     <label for="inputEmail4">Temporary ID<span style="color: red">*</span></label>
                     <input type="text" class="form-control" value="{{old('temporary_id')}}" style="text-transform:uppercase" required name="temporary_id" placeholder="Temporary ID">
                  </div>
                  <div class="col">
                     <label for="inputEmail4"></label><br>
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
      $('#dob').on('change', function() {
         let category_id = $('input[name="category_id"]:checked').val();


         var dob = new Date($(this).val());
         if (!isNaN(dob.getTime())) { // Check if the date is valid
            var today = new Date(2026, 0, 1); // February 1, 2025

            // Calculate the age in terms of years, months, and days
            var years = today.getFullYear() - dob.getFullYear();
            var months = today.getMonth() - dob.getMonth();
            var days = today.getDate() - dob.getDate();

            // Adjust if the birth date hasn't occurred yet this month
            if (days < 0) {
               months--;
               // Get the last day of the previous month
               var lastDayOfPrevMonth = new Date(today.getFullYear(), today.getMonth(), 0).getDate();
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
            var minAgeDays = (4 * 365) + (10 * 30)+1;
            // Maximum age: 6 years and 60 days
            var maxAgeDays = (6 * 365) + 60;

            // Check if the total days fall within the valid range
            if ((totalAgeDays >= minAgeDays && totalAgeDays <= maxAgeDays)) {
               $('#age').text(years + ' years, ' + months + ' months, ' + days + ' days').css('color', 'green');
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


  @if($errors->any())
    @php
        $text = '';
        foreach($errors->all() as $error) {
            $text .= '<p>' . $error . '</p>';
        }
    @endphp
        Swal.fire({
            title: "Warning!",
            html: `{!! $text !!}`,
            icon: "warning"
        });
    
@endif
	</script>

@if(Session::get('warning'))
    <script>
        Swal.fire({
            title: "Warning!",
            html: `{!! Session::get('warning') !!}`,
            icon: "warning"
        });
    </script>
@endif
<script>
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
                    $('#versiontext').text('ভার্শন বাংলা');
                } else {
                    $('#versiontext').text('Version English');
                    
                }
		  if(versionid == 2){
			  $('#seatInfo1').html(
                        '(Avaiable Seats - <span style="color:#dc3545;">20</span>)'
                    );
                    $('#seatInfo2').html(
                        '(Avaiable Seats - <span style="color:#dc3545;">25</span>)'
                    );
		  }else{
		  	  $('#seatInfo1').html('');
              $('#seatInfo2').html('');
		  }
			  
         $('#exampleModalLong').modal('show');
      });
      $(document.body).on('click', '.findAdmitcard', function() {

         $('#exampleModal').modal('show');
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
         var url = "{{route('getCategoryView')}}";
         $.ajax({
            type: "post",
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            },
            url: url,
            data: {
               "_token": "{{ csrf_token() }}",
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

   });
</script>
<script>
   $(function() {
      var currentHour = new Date().getHours();

      // Show modal if time is between 9 PM (21) and 8 AM (8)
      if (currentHour >= 0 && currentHour < 7) {
         $('#loginBlockModal').modal({
            backdrop: 'static', // Prevent closing by clicking outside
            keyboard: false // Prevent closing with ESC key
         });
         $('#loginBlockModal').modal('show');
      }
   });
</script>
<script>
   $(function() {
      var currentHour = new Date().getHours();

      $('#loginBlockModal1').modal({
            backdrop: 'static', // Prevent closing by clicking outside
            keyboard: false // Prevent closing with ESC key
         });
         $('#loginBlockModal1').modal('show');
   });
</script>
	<script>
document.getElementById('birth_image').addEventListener('change', function() {
    const file = this.files[0];
    const previewBox = document.getElementById('birth-preview-box');
    const imgPreview = document.getElementById('birth-preview-img');
    const pdfPreview = document.getElementById('birth-preview-pdf');
    const pdfName = document.getElementById('birth-pdf-name');

    previewBox.style.display = "none";
    imgPreview.style.display = "none";
    pdfPreview.style.display = "none";

    if (file) {
        const allowedTypes = ['application/pdf', 'image/jpeg'];
        const maxSize = 200 * 1024; // 200 KB

        // ✅ Validate file type
        if (!allowedTypes.includes(file.type)) {
            Swal.fire({
                title: "Warning!",
                html: "Only PDF, JPG, or JPEG files are allowed.",
                icon: "warning"
            });
            this.value = ''; // reset input
            return;
        }

        // ✅ Validate file size
        if (file.size > maxSize) {
            Swal.fire({
                title: "Warning!",
                html: "File size must not exceed <b>200 KB</b>.",
                icon: "warning"
            });
            this.value = ''; // reset input
            return;
        }

        // ✅ Show preview
        previewBox.style.display = "block";
        if (file.type === 'image/jpeg') {
            const reader = new FileReader();
            reader.onload = function(e) {
                imgPreview.src = e.target.result;
                imgPreview.style.display = "block";
                pdfPreview.style.display = "none";
            };
            reader.readAsDataURL(file);
        } else if (file.type === 'application/pdf') {
            pdfName.textContent = file.name;
            imgPreview.style.display = "none";
            pdfPreview.style.display = "flex";
            pdfPreview.style.alignItems = "center";
        }
    }
});
</script>

    <script>
document.getElementById('photo').addEventListener('change', function() {
    const file = this.files[0];
    const preview = document.getElementById('photo-preview');

    if (file) {
        const allowedTypes = ['image/jpeg'];
        const maxSize = 200 * 1024; // 200 KB

        // ✅ Check file type
        if (!allowedTypes.includes(file.type)) {
            Swal.fire({
                title: "Warning!",
                html: "Only JPG or JPEG files are allowed.",
                icon: "warning"
            });
            this.value = ''; // Reset input
            preview.style.display = "none";
            return;
        }

        // ✅ Check file size
        if (file.size > maxSize) {
            Swal.fire({
                title: "Warning!",
                html: "File size must not exceed <b>200 KB</b>.",
                icon: "warning"
            });
            this.value = ''; // Reset input
            preview.style.display = "none";
            return;
        }

        // ✅ Show image preview
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = "block";
        };
        reader.readAsDataURL(file);
    } else {
        preview.style.display = "none";
    }
});
</script>
@endsection