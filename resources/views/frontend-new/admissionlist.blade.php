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


   .btn:hover {
      color: black !important;
   }

   .form-check-input {

      border: var(--bs-border-width) solid #1d1d1d;
   }
</style>
<div class="modal fade" id="loginBlockModal" tabindex="-1" aria-labelledby="loginBlockLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header bg-danger text-white">
            <h5 class="modal-title" id="loginBlockLabel" style="color: white;margin-left: 42%;">সতর্কতা</h5>
            <!--button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button-->
         </div>
         <div class="modal-body">
            অনলাইন ভর্তি প্রক্রিয়া রাত ১২:০০টা থেকে সকাল ৭:০০ টা পর্যন্ত বন্ধ থাকবে।
         </div>
         <div class="modal-footer">
            <!--button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Okay</button-->
         </div>
      </div>
   </div>
</div>
<div class="container spacet20 background-image">
   <div class="row">
      <div class="col-md-12 spacet60 pt-0-mobile">


         <div class="row">
            <div class="container spaceb50">
               <div class="row">


                  <div class="refine-categ-header " style="margin-top: 10px;">

                     <h3 style="text-align: center;font-weight: bold">Online Admission KG (2025) (অনলাইন ভর্তি) </h3>

                     <h4 style="text-align: center"> <img title="Hotline Number" src="{{asset('public/call-thumbnail.png')}}" style="height: 25px" /> <a href="tel:01759536622" style="color: red;font-weight: bold;">01759536622, </a><a href="tel:01777521159" style="color: red;font-weight: bold;">01777521159</a> </h4>
                     {{-- <h4 style="text-align: center;color: black;font-weight: bold"> Last Date Of Application:<br/> --}}
                     <h4 style="text-align: center;color: black;font-weight: bold"> <br />
                        <div style="margin-top: 10px;">

                     </h4>
                     <!-- <div class="table-responsive">
                    <table class="table " >
                     
                     
                    <tr>
                     <td></td>
                     <td></td>
                    </tr>
                        
                       
                        
                     
                  </table>
                  
                  </div> -->
                     <section class=" d-sm-block ml-3" style="margin-top: 30px;">
                        <div class="container">
                           <div class="row wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">



                              @foreach($admissiondata as $key=>$admission)
                              <div class="col-sm-3">
                                 <a href="#gallery_home">
                                 </a>
                                 <div class="card @if($admission->version_id==1) bg-danger @else bg-success @endif card-hover" style="min-height: 164px"><a href="#gallery_home">
                                    </a>
                                    <div class="card-body text-center p-0"><a href="#gallery_home">
                                          <div class="card-icon-border-large  @if($admission->version_id==1) border-danger @else border-success @endif ">
                                             @if($admission->version_id==1) BN @else EN @endif
                                          </div>
                                          <p class="text-white  font-dosis">Last date {{ date("M j, Y", strtotime($admission->end_date)) }}
                                          </p>
                                       </a>
                                       <button type="button" class="btn @if($admission->version_id==1) btn-success @else btn-danger @endif kgadmission"
                                          data-versionid="{{$admission->version_id}}"
                                          data-class_id="{{$admission->class_id}}"
                                          data-session_id="{{$admission->session_id}}"
                                          data-amount="{{$admission->price}}" fdprocessedid="fyjlka">
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
                              <button type="button" class="btn btn-primary findAdmitcard" style="background-color: #00ADEF">
                                 Get Admit Card
                              </button>
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
<div class="modal fade mb-8" id="exampleModalLong" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header text-center">
            <h5 class="modal-title " style="font-weight: bold;width: 98%;"><span style="color: #20aee5">বিএএফ শাহীন কলেজ ঢাকা</span> <br /> <span style="color: red">(শিক্ষাবর্ষ ২০২৫ কেজি শ্রেণির ভর্তি)</span><br /> <span style="color: rgb(46,49,146)" id="versiontext"></span></h5>
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
                     <table class="noborder">
                        <tr>
                           <td>
                              <div class="form-check">
                                 <input class="form-check-input" type="radio" name="shift_id" id="flexRadioDefault1" value="1" checked="">
                                 <label class="form-check-label" for="flexRadioDefault1">
                                    &nbsp;Morning
                                 </label>
                              </div>
                           </td>
                           <td>
                              <div class="form-check">
                                 <input class="form-check-input" type="radio" name="shift_id" id="flexRadioDefault2" value="2">
                                 <label class="form-check-label" for="flexRadioDefault2">
                                    &nbsp;Day
                                 </label>
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
                           @if(isset($categories[0]->id))
                           <td>
                              <div class="form-check d-flex">
                                 <input class="form-check-input category" required="" type="radio" name="category_id" id="{{$categories[0]->id}}" value="{{$categories[0]->id}}" checked="">
                                 <label class="form-check-label" for="{{$categories[0]->id}}">
                                    &nbsp;{{$categories[0]->category_name}}
                                 </label>
                              </div>
                           </td>
                           @endif
                           
                           @if(isset($categories[1]->id))
                           <td>
                              <div class="form-check d-flex">
                                 <input class="form-check-input category" required="" type="radio" name="category_id" id="{{$categories[1]->id}}" value="{{$categories[1]->id}}" >
                                 <label class="form-check-label" for="{{$categories[1]->id}}">
                                    &nbsp;{{$categories[1]->category_name}}
                                 </label>
                              </div>
                           </td>
                           @endif
                        </tr>
                        
                        <tr>
                           
                              @if(isset($categories[2]->id))
                           <td>
                              <div class="form-check d-flex">
                                 <input class="form-check-input category" required="" type="radio" name="category_id" id="{{$categories[2]->id}}" value="{{$categories[2]->id}}" >
                                 <label class="form-check-label" for="{{$categories[2]->id}}">
                                    &nbsp;{{$categories[2]->category_name}}
                                 </label>
                              </div>
                           </td>
                           @endif
                           
                               @if(isset($categories[3]->id))
                           <td>
                              <div class="form-check d-flex">
                                 <input class="form-check-input category" required="" type="radio" name="category_id" id="{{$categories[3]->id}}" value="{{$categories[3]->id}}" >
                                 <label class="form-check-label" for="{{$categories[3]->id}}">
                                    &nbsp;{{$categories[3]->category_name}}
                                 </label>
                              </div>
                           </td>
                           @endif
                        </tr>
                     </table>


                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12" id="categoryview">
                  </div>
               </div>
               <div class="row">

                  <p>Personal Information</p>

                  <div class="col">
                     <label for="inputEmail4">Candidate's English Name<span style="color: red">*</span></label>
                     <input type="text" class="form-control" value="{{old('name_en')}}" style="text-transform:uppercase" required="" name="name_en" placeholder="English Name">
                  </div>
                  <div class="col">
                     <label for="inputEmail4">প্রার্থীর বাংলা নাম<span style="color: red">*</span></label>
                     <input type="text" class="form-control" required="" value="{{old('name_bn')}}" name="name_bn" placeholder="Bangla Name">
                  </div>


               </div>
               <br />
               <div class="row">

                  <div class="col">
                     <label for="inputEmail4">Candidate's Date Of Birth<span style="color: red">*</span><span id="age"></span></label>
                     <input type="date" class="form-control" required="" value="{{old('dob')}}" id="dob" name="dob" placeholder="Date of Birth">
                     <span id="message"></span>
                  </div>
                  <div class="col">
                     <label for="inputEmail4">Candidate's Gender<span style="color: red">*</span></label>
                     <select class="form-select form-control" required="" name="gender" aria-label="Default select example">
                        <option value="1" {{(old('gender')==1)?'selected="selected"':''}}>Male</option>
                        <option value="2" {{(old('gender')==2)?'selected="selected"':''}}>Female</option>
                     </select>
                  </div>


               </div>
               <br />
               <div class="row">

                  <div class="col">
                     <label for="inputEmail4">Gurdian's Name<span style="color: red">*</span></label>
                     <input type="text" class="form-control" required="" value="{{old('gurdian_name')}}" name="gurdian_name" placeholder="Gurdian Name">
                  </div>
                  <div class="col">
                     <label for="inputEmail4">Mobile Number<span style="color: red">*</span></label>
                     <input type="text" class="form-control" required="" value="{{old('mobile')}}" name="mobile" placeholder="Mobile">
                  </div>


               </div>
               <br />
               <div class="row">

                  <div class="col">
                     <label for="inputEmail4">Candidate's Birth Registration Number<span style="color: red">*</span></label>
                     <input type="text" class="form-control" value="{{old('birth_registration_number')}}" required="" name="birth_registration_number" placeholder="Birth Registration Number">
                  </div>
                  <div class="col">
                     <label for="inputEmail4">Candidate's Birth Registration Certificate<span style="color: red">*</span></label>
                     <input type="file" class="form-control" required="" name="birth_image" placeholder="Mobile">
                  </div>


               </div>
               <br />
               <div class="row">


                  <div class="col">
                     <label for="inputEmail4">Candidate's Photo<span style="color: red">*</span> (File size max 200 KB)</label>
                     <input type="file" class="form-control" required="" name="photo" placeholder="photo">
                  </div>
                  <div class="col">

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
            <h5 class="modal-title " style="font-weight: bold;width: 98%;"><span style="color: #20aee5">বিএএফ শাহিন কলেজ ঢাকা</span> <br /> <span style="color: red">(শিক্ষাবর্ষ ২০২৫ কেজি শ্রেণির ভর্তি)</span><br /> <span style="color: rgb(46,49,146)" id="versiontext"></span></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <form action="{{route('admissionsearch')}}" method="post" enctype="multipart/form-data" class="onlineform" id="checkstatusform">
            <div class="modal-body">
               <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />


               <div class="row">

                  <p>Enter Your Temporary ID</p>

                  <div class="col">
                     <label for="inputEmail4">Temporary ID<span style="color: red">*</span></label>
                     <input type="text" class="form-control" value="{{old('temporary_id')}}" style="text-transform:uppercase" required="" name="temporary_id" placeholder="Temporary ID">
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
<div id="checkOnlineAdmissionStatus" class="modal fade" role="dialog" tabindex="-1">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header modal-header-small">
            <button type="button" class="close closebtnmodal" data-dismiss="modal">&times;</button>
            <h4><span id="version_name" style="color: red; font-weight: bold;font-size:17px!important"></span></h4>
         </div>
         <form action="{{route('admissionData')}}" method="post" enctype="multipart/form-data" class="onlineform" id="checkstatusform">
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
            <input type="hidden" name="version_id" id="version_id" value="" />
            <input type="hidden" name="class_id" id="class_id" value="" />
            <input type="hidden" name="session_id" id="session_id" value="" />
            <div class="modal-body" style="padding:0px">

               <div class="col-md-6 col-sm-6" style="margin-top: 5px">
                  <div class="form-group">
                     <label>SSC Roll Number (এসএসসি রোল নম্বর)</label><small class="req"> *</small>
                     <input type="text" class="form-control" required="" name="roll_number" id="roll_number" autocomplete="off">
                     <span class="text-danger" id="error_status_roll_number"></span>
                  </div>
               </div>
               <!-- <div class="col-md-6 col-sm-6">
                           <div class="form-group">
                           <label>Registration Number (রেজিস্ট্রেশন নম্বর)</label><small class="req"> *</small>
                              <input type="text" class="form-control" required="" name="registration_number" id="registration_number" autocomplete="off">
                              <span class="text-danger" id="error_status_registration_number"></span>
                           </div>
                     </div> -->
               <div class="col-md-6 col-sm-6" style="margin-top: 5px">
                  <div class="form-group">
                     <label>Board (বোর্ড)</label><small class="req"> *</small>
                     <select class="form-control" name="board_id" id="board_id">

                        <option value=""> Select Education Board (শিক্ষাবোর্ড নির্বাচন করুণ) </option>
                        <option value="Dhaka">Dhaka (ঢাকা)</option>
                        <option value="Rajshahi">Rajshahi (রাজশাহী)</option>
                        <option value="Cumilla">Cumilla (কুমিল্লা)</option>
                        <option value="Jashore">Jashore (যশোর)</option>
                        <option value="Chattogram">Chattogram (চট্টগ্রাম)</option>
                        <option value="Barishal">Barishal (বরিশাল)</option>
                        <option value="Sylhet">Sylhet (সিলেট)</option>
                        <option value="Mymensingh">Mymensingh (ময়মনসিংহ)</option>
                        <option value="Dinajpur">Dinajpur (দিনাজপুর)</option>
                        <option value="Madrasah">Madrasah (মাদ্রাসা)</option>
                        <option value="BTEB">Bangladesh Technical Education (বাংলাদেশ কারিগরি শিক্ষা বোর্ড)</option>
                        <option value="BOU">BOU (বাউবি)</option>
                     </select>
                     <!-- <input type="text" class="form-control" required="" name="board_id" id="board_id"  readonly="readonly" autocomplete="off"> -->
                     <span class="text-danger" id="error_status_board_id"></span>
                  </div>
               </div>
               <div class="col-md-6 col-sm-6">
                  <div class="form-group">
                     <label>Full Name (সম্পূর্ণ নাম)</label><small class="req"> *</small>
                     <input type="text" class="form-control" required="" name="full_name" id="full_name" readonly="readonly" autocomplete="off">
                     <span class="text-danger" id="error_status_full_name"></span>
                  </div>
               </div>


               <!-- <div class="col-md-6 col-sm-6">
                           <div class="form-group">
                           <label>Admission Serial (এডমিশন সিরিয়াল)</label>
                              <input type="text" class="form-control"   readonly="readonly" name="serial" id="serial" autocomplete="off">
                              <span class="text-danger" id="error_status_serial"></span>
                           </div>
                     </div> -->
               <div class="col-md-6 col-sm-6">
                  <div class="form-group">
                     <label>Group (বিভাগ)</label><small class="req"> *</small>
                     <input type="text" class="form-control" required="" id="group_name" readonly="readonly" name="group_name" id="serial" autocomplete="off">
                     <span class="text-danger" id="error_status_group_name"></span>
                  </div>
               </div>






            </div>
            <div class="modal-footer">
               <button type="button" class="modalclosebtn btn  mdbtn" data-dismiss="modal">Close</button>
               <button type="submit" class="onlineformbtns mdbtn">Submit</button>
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
            var today = new Date(2025, 0, 1); // February 1, 2025

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
            var minAgeDays = (4 * 365) + (11 * 30) + 15;
            // Maximum age: 6 years and 15 days
            var maxAgeDays = (6 * 365) + 45;

            // Check if the total days fall within the valid range
            if ((totalAgeDays >= minAgeDays && totalAgeDays <= maxAgeDays) || (category_id == 2 || category_id == 4)) {
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

    <script>
        Swal.fire({
            title: "Warning!",
            html: `{!! $text !!}`,
            icon: "warning"
        });
    </script>
@endif

@if(Session::get('warning'))
    <script>
        Swal.fire({
            title: "Warning!",
            html: `{!! Session::get('warning') !!}`,
            icon: "warning"
        });
    </script>
@endif

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

@endsection