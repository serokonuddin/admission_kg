

@extends('frontend.layout')
@section('content')
<style>
   .bg-gray{
      background-color: #f4f4f4;
   }
   .bg-white{
      background-color: #fff;
   }
   .box
{
    position: relative;
    width: 100%;
    height: 400px;
    overflow: hidden;
    border-radius: 10px;
    background: #000;
    box-shadow: 0 5px 15px rgba(0,0,0,.5);
    transition: .5s;
    margin-bottom: 35px;
}

.box:hover
{
    transform: translateY(-30px);
    box-shadow: 0 50px 50x rgba(0,0,0,.5);
}

.box .imgbox
{
    position: relative;
}

.box .imgbox img
{
    transition: .5s;
}

.box:hover .imgbox img
{
   opacity: .5;
    transform: translateY(-40px);
}

.box .content
{
    position: absolute;
    bottom: -40px;
    left: 0;
    padding: 20px;
    box-sizing: border-box;
    transition: .5s;
    opacity: 0;
    
}

.box .content1
{
    position: absolute;
    bottom: 0px;
    left: 0;
    padding: 20px;
    box-sizing: border-box;
    transition: .5s;
    opacity: 1;
    
}

.box:hover .content
{
    opacity: 1;
    bottom: 0;
}
.box:hover .content1
{
    opacity: 0;
    bottom: -40px;
}
.box .content1 h3
{
    font-size: 48px;
    color: #fff;
    font-weight: 700;
}

.box .content1 p
{
    font-size: 18px;
    color: #fff;
    font-weight: 400;
}
.box .content h3
{
    font-size: 48px;
    color: #fff;
    font-weight: 700;
}

.box .content p
{
    font-size: 18px;
    color: #fff;
    font-weight: 400;
}

.box .content .btnD
{
    border: none;
    background: #ff0000;
    color: #fff;
    font-size: 18px;
    padding: 10px 20px;
    font-weight: 700;
    transition: .5s;
}

.box .content .btnD:hover
{
    background: #ff3232;
    
}
.service-box{
   opacity: .7;
}
.courses-box h4,.courses-box p{
   color: black;
}
.courses-box:hover h4,.courses-box:hover p{
   color: white;
}
.modal-body {
    position: relative;
    padding: 0px;
}
.blink {
        animation: blink-animation 1s steps(5, start) infinite;
        -webkit-animation: blink-animation 1s steps(5, start) infinite;
       
        font-weight: bold!important;
        font-size: 22px!important;
      }
      @keyframes blink-animation {
        to {
          visibility: hidden;
        }
      }
      @-webkit-keyframes blink-animation {
        to {
          visibility: hidden;
        }
      }
</style>
<div id="bootstrap-touch-slider" class="carousel bs-slider slide  control-round" data-ride="carousel" data-interval="4000">
         <div class="carousel-inner">
            @foreach($sliders as $key=>$slider)
            <div class="item @if($key==0) active @endif">
               <img src="{{asset($slider->image)}}" alt="" />
            </div>
            @endforeach
         </div>
         <!--./carousel-inner-->
         <a class="left carousel-control" href="#bootstrap-touch-slider"  data-slide="prev">
         <span class="fa fa-angle-left"></span>
         <span class="sr-only">Previous</span>
         </a>
         <!-- Right Control-->
         <a class="right carousel-control" href="#bootstrap-touch-slider" data-slide="next">
         <span class="fa fa-angle-right"></span>
         <span class="sr-only">Next</span>
         </a>
      </div>
      <!--./bootstrap-touch-slider-->
      
      <div class="container ">
         <div class="row">
            <div class="col-md-12 spacet60  pt-0-mobile">
               <section class="services">
                  <div class="service-inner">
                     <div class="container">
                        <div class="row">
                           <div class="col-md-4 col-sm-4 service-box">
                              <div class="service-box-content">
                                 <h3><a target="_blank" href="https://epay.dutchbanglabank.com/bafshaheen/StudentLogIn.aspx"  target="_blank">Online Payment</a></h3>
                                 <p>Student Tuition Fee & Other Payment</p>
                                 <div class="service-box-icon"><img src="{{asset('/')}}public/frontend/uploads/gallery/media/payment.png" /></div>
                              </div>
                           </div>
                           <!--./col-md-4  -->
                           <div class="col-md-4 col-sm-4 service-box">
                          
                              <div class="service-box-content" 
                              
                              >
                                 <h3><a href="{{url('admissionview')}}" class="blink">Online Admission</a></h3>
                                 <p>Click Here For Online Admission.</p>
                                 <div class="service-box-icon"><img src="{{asset('/')}}public/frontend/uploads/gallery/media/admission-4-128.png" style="width: 68px"/></div>
                              </div>
                           </div>
                           <!-- <div class="col-md-4 col-sm-4 service-box">
                              <div class="service-box-content">
                                 <h3><a href="#">Notice/Announcement</a></h3>
                                 <p>Academic Notice/Announcement.</p>
                                 <div class="service-box-icon"><img src="{{asset('/')}}public/frontend/uploads/gallery/media/admission.png" /></div>
                              </div>
                           </div> -->
                           <!--./col-md-4-->
                           <div class="col-md-4 col-sm-4 service-box">
                              <div class="service-box-content">
                                 <h3><a href="https://bafsd.osl.ac/SC/OnlineResult" target="_blank">Result</a></h3>
                                 <p>Admission & Academic Exam Result</p>
                                 <div class="service-box-icon"><img src="{{asset('/')}}public/frontend/uploads/gallery/media/result.png" /></div>
                              </div>
                           </div>
                           <!--./col-md-4-->
                        </div>
                     </div>
                  </div>
               </section>
               <!-- <div class="container spacet40">
                  <div class="row">
                     <div class="col-md-8 col-sm-12 col-md-offset-2 text-center">
                        <h2 class="head-title">Residential School</h2>
                        <p class="pb40">Tmply dummy text of the printing and typesetting industry. Lorem Ipsum has been theindustry's standard dummy text ever since the 1500s, when an unknown printer took.</p>
                        <img class="img-responsive center-block" src="{{asset('/')}}public/frontend/uploads/gallery/media/about_bg.jpg" />
                     </div>
                  </div>
                 
               </div> -->
               <!--./container-->
               <!-- <section class="bg-gray fullwidth spaceb40 spacet40">
                  <div class="container">
                     <div class="row">
                        <div class="col-md-8 col-sm-12 col-md-offset-2 text-center">
                           <h2 class="head-title">Welcome Message</h2>
                           
                         
                        </div>
                        <div class="col-md-3 col-sm-3">
                           <div class="about_img">
                              <img class="img-responsive img-rounded" width="80"  src="{{asset('/')}}public/frontend/uploads/images/1696259890.jpg" />
                           
                        </div>
                        </div>
                       
                        <div class="col-md-9 col-sm-9 bg-white">
                           <div class="about-right">
                              <h3>Group Captain</h3>
                              <h4>Chy Md Zia-Ul-Kabir</h4>
                              <p class="pt10 pb10">BAF Shaheen College Dhaka is a well renowned educational institution under Ministry of Education, Secondary and Higher Secondary Education Directorates, Board of Intermediate and Secondary Education (BISE) Dhaka. It is  very successfully run by Bangladesh Air Force. It’s one of the seven Shaheen Colleges currently run in Bangladesh. The motto of this college is ‘Education – Restraint - Discipline’. The activities of this institution are run to materialize the motto with reverence. Each and every student of this institution is called a ‘Shaheen’ . Shaheen is a fetterless bird. It perambulates with free thinking, immaculate environment and bravery around human sphere.</p>
                              <p class="pt10 pb10">The future citizens of the progressive society will be well educated, restrained in behavior and sense of life as well as disciplined in life leading. That is why our motto is  ‘Education – Restraint - Discipline’. Besides academic education, we also focus on cultural exercise, sports and several co-curricular activities. Our aim is to make a student educated with philanthropic quality, honest, devoted and patriot citizen.</p>
                              <a href="{{url('page/message-of-the-principal')}}" style="text-align: right">...... Read More</a>
                           </div>
                           
                        </div>
                       
                     </div>
                    
                  </div>
                
               </section> -->
               <section class=" ">
                  <div class="container">
                  <div class="row">
                     
                        <div class="col-md-8 col-sm-12 col-md-offset-2 text-center" style="margin-bottom: 30px">
                           <h2 class="head-title">Message</h2>
                           
                        </div>
                           <div class="col-sm-6">
                           <div class="box">
                           <div class="imgbox">
                              
                                 <img src="{{asset('/')}}public/frontend/uploads/images/gb.jpg" class="img-responsive">
                                 </div>
                                 <div class="content">
                                    <a href="{{url('page/message-of-the-chairman')}}" >
                                       <h3>GB Chairman</h3>
                                        <h4 style="color: white">Air Vice Marshal Md. Sharif Uddin Sarkar, OSP, GUP, BPP,ndc, psc, Air Officer Commanding</h4>
                                       <p>Please Like press like button and post your comment below</p>
                                       <a href="{{url('page/message-of-the-chairman')}}" class="btn btn-default btnD">Read More</a>
                                    </a>
                                 </div>
                                 <div class="content1">
                                    <a href="{{url('page/message-of-the-chairman')}}" >
                                       <h3>GB Chairman</h3>
                                       <h4 style="color: white">Air Vice Marshal Md. Sharif Uddin Sarkar</h4>
                                    </a>
                                 </div>
                              
                           </div>
                           </div>
                           
                           
                           <div class="col-sm-6">
                           <div class="box">
                           <div class="imgbox">
                              <img src="https://bafsd.edu.bd/public/p.jpg" class="img-responsive">
                              </div>
                              <div class="content">
                              <a href="{{url('page/message-of-the-principal')}}" >
                              <h3>Principal</h3>
                              <h4 style="color: white">Group Captain Mohammad Kaisul Hassan, Psc</h4>
                              <p class="pt10 pb10">BAF Shaheen College Dhaka is a well renowned educational institution under Ministry of Education, Secondary and Higher Secondary Education Directorates, Board of Intermediate and Secondary Education (BISE) Dhaka.....</p>
                              
                                 <a href="{{url('page/message-of-the-principal')}}" class="btn btn-default btnD">Read More</a>
                              </a>
                              </div>
                              <div class="content1">
                              <a href="{{url('page/message-of-the-principal')}}" >
                                 <h3>Principal</h3>
                                 <h4 style="color: white">Group Captain Mohammad Kaisul Hassan, psc</h4>
                              </a>
                              </div>
                           </div>
                           </div>
                     </div>
                     <div class="row">
                        <div class="col-md-8 col-sm-12 col-md-offset-2 text-center pb30">
                           <h2 class="head-title">Our Main Activites</h2>
                           <!-- <p>Fusce sem dolor, interdum in fficitur at</p> -->
                           <div class="divider">&nbsp;</div>
                        </div>
                        <div class="row">
                           <div class="owl-carousel courses-carousel">
                              <div class="col-md-12 col-sm-12">
                                 <a target="_blank" href="https://bn.wikipedia.org/wiki/%E0%A6%B6%E0%A7%87%E0%A6%96_%E0%A6%AE%E0%A7%81%E0%A6%9C%E0%A6%BF%E0%A6%AC%E0%A7%81%E0%A6%B0_%E0%A6%B0%E0%A6%B9%E0%A6%AE%E0%A6%BE%E0%A6%A8">
                                    <div class="courses-box">
                                       <div class="courses-box-img"><img src="{{asset('/')}}public/frontend/uploads/images/Bangabandhu-Sheikh-Mujibur-Rahman.jpg" /></div>
                                       <!--./courses-box-img-->
                                       <div class="course-inner">
                                          <!-- <a class="course-subject" href="#">Bongobondhu Konar</a> -->
                                          <h4 >Bongobondhu Sheikh Mujibur Rahman</h4>
                                          <p>Father of the Nation Bangabandhu Sheikh Mujibur Rahman (1920-1975) is the architect of independent Bangladesh...</p>
                                          <!-- <a class="btn-read" href="#">apply now</a> -->
                                       </div>
                                    </div>
                                 </a>
                                 <!--./courses-box-->
                              </div>
                              <!--./col-md-12-->
                              <div class="col-md-12 col-sm-12">
                              <a target="_blank" href="https://baf.mil.bd/website/index.php">
                                 <div class="courses-box">
                                    <div class="courses-box-img"><img src="{{asset('/')}}public/frontend/uploads/images/baf.png" /></div>
                                    <!--./courses-box-img-->
                                    <div class="course-inner">
                                       <h4>Bangladesh Air Force (BAF)</h4>
                                       <p>The origin of Bangladesh Air Force (BAF) dates back to 1920 in British India when the Indian politicians demanded....</p>
                                       <!-- <a class="btn-read" href="#">apply now</a> -->
                                    </div>
                                 </div>
                              </a>
                                 <!--./courses-box-->
                              </div>
                              <div class="col-md-12 col-sm-12">
                              <a target="_blank" href="{{url('page/history-of-the-college')}}">
                                 <div class="courses-box">
                                    <div class="courses-box-img"><img src="{{asset('/')}}public/frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png" /></div>
                                    <!--./courses-box-img-->
                                    <div class="course-inner">
                                       <h4>History Of The College</h4>
                                       <p>History of BAF Shaheen College Dhaka BAF Shaheen College Dhaka is one of the most famous educational institutions in the country.....</p>
                                       <!-- <a class="btn-read" href="#">apply now</a> -->
                                    </div>
                                 </div>
                              </a>
                                 <!--./courses-box-->
                              </div>
                              <!--./col-md-12-->
                              <div class="col-md-12 col-sm-12">
                              <a  href="{{url('clubs')}}">
                                 <div class="courses-box">
                                    <div class="courses-box-img"><img src="{{asset('/')}}public/frontend/uploads/gallery/media/courseimg3.jpg" /></div>
                                    <!--./courses-box-img-->
                                    <div class="course-inner">
                                       <h4>Club Activites</h4>
                                       <p>All over the world, human beings create an immense and ever-increasing volume of data, with new kinds of data regularly...</p>
                                       <!-- <a class="btn-read" href="#">apply now</a> -->
                                    </div>
                                 </div>
                              </a>
                                 <!--./courses-box-->
                              </div>
                              <div class="col-md-12 col-sm-12">
                              <a  href="{{url('/page/photo-gallery')}}">
                                 <div class="courses-box">
                                    <div class="courses-box-img"><img src="{{asset('/')}}public/frontend/uploads/images/gallery.jpg" /></div>
                                    <!--./courses-box-img-->
                                    <div class="course-inner">
                                       <h4>Gallery</h4>
                                       <p>All over the world, human beings create an immense and ever-increasing volume of data, with new kinds of data regularly...</p>
                                       <!-- <a class="btn-read" href="#">apply now</a> -->
                                    </div>
                                 </div>
                                 </a>
                                 <!--./courses-box-->
                              </div>
                              <!--./col-md-12-->
                              
                              <!--./col-md-12-->
                           </div>
                        </div>
                        <!--./courses-carousel-->
                     </div>
                     <!--./row-->
                  </div>
                  <!--./container-->
               </section>
               <section class="countdown_bg fullwidth counter">
                  <div class="container">
                     <div class="row">
                        <div class="col-md-6 col-lg-6 col-sm-6">
                           <div class="counter-content">
                              <h2 class="counter-title mt0">Achievements- Milestone and Statistics</h2>
                              <div class="counter-text">
                                 <!-- <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart like mine.</p> -->
                              </div>
                              <div class="counter-img">
                                 <div class="about_img"><img class="img-responsive img-rounded" src="{{asset('/')}}public/frontend/uploads/gallery/media/achivement.jpg" /></div>
                              </div>
                           </div>
                        </div>
                        <!--./col-md-6-->
                        <div class="col-md-6 col-lg-6 col-sm-6">
                           <div class="row">
                              <div class="col-md-6 col-lg-6 col-sm-6">
                                 <div class="counter-main">
                                    <img class="svg" src="{{asset('/')}}public/frontend/uploads/gallery/media/cap.svg" />
                                    <h3 class="counter-value" data-count="15">15</h3>
                                    <span>Last 3 Years Achievements</span>
                                 </div>
                              </div>
                              <div class="col-md-6 col-lg-6 col-sm-6">
                                 <div class="counter-main">
                                    <img class="svg" src="{{asset('/')}}public/frontend/uploads/gallery/media/award.svg" />
                                    <h3 class="counter-value" data-count="99">99</h3>
                                    <span>S.S.C Result 2024 Passed (%)</span>
                                 </div>
                              </div>
                              <div class="col-md-6 col-lg-6 col-sm-6">
                                 <div class="counter-main">
                                    <img class="svg" src="{{asset('/')}}public/frontend/uploads/gallery/media/building-o.svg" />
                                    <h3 class="counter-value" data-count="224">224</h3>
                                    <span>S.S.C GPA 5</span>
                                 </div>
                              </div>
                              <div class="col-md-6 col-lg-6 col-sm-6">
                                 <div class="counter-main">
                                    <img class="svg" src="{{asset('/')}}public/frontend/uploads/gallery/media/people.svg" />
                                    <h3 class="counter-value" data-count="11923">11923</h3>
                                    <span>Students</span>
                                 </div>
                              </div>
                              <!--./col-md-6-->
                           </div>
                           <!--./row-->
                        </div>
                        <!--./col-md-6-->
                     </div>
                     <!--./row-->
                  </div>
                  <!--./container-->
               </section>
               <section class="bggray fullwidth">
                  <div class="container spaceb60 spacet60">
                     <div class="row">
                        <div class="col-sm-12 text-center">
                           <h2 class="head-title">Our Team</h2>
                           <p>Considering desire as primary motivation for the generation of narratives is a useful concept.</p>
                           <div class="divider">&nbsp;</div>
                        </div>
                        <!--./col-md-12-->
                       
                        @foreach($managements as $key=>$employee)
                        <div class="col-lg-4 col-md-4 col-sm-4">
                              <div class="staffteam">
                                       <div class="staffteamimg">
                                          @if($key>0)
                                          <img alt="" src="{{$employee->photo}}" style="object-fit: unset!important" />
                                          @else 
                                          <img alt="" src="{{$employee->photo}}"  />
                                          @endif
                                          <ul class="social-links">
                                             <li>Facebook</li>
                                             <li>Twitter</li>
                                             <li>Linkedin</li>
                                             <li>Google Plus</li>
                                          </ul>
                                       </div>
                                       <div class="staff-content">
                                          <h3>{{$employee->employee_name}}</h3>
                                          <span class="post">{{$employee->designation->designation_name??''}}</span>
                                       </div>
                                    </div>
                        </div>
                        @endforeach
                        
                       
                     </div>
                     <!--./row-->
                  </div>
                  <!--./container-->
               </section>
               <section class="spaceb40 spacet40">
                  <div class="container">
                     <div class="row">
                        
                        <!--./col-md-8-->
                        <div class="teamstaff">
                           <div class="row">
                              <div class="owl-carousel staff-carousel">
                                 @foreach($employees as $employee)
                                 <div class="col-md-12 col-sm-12">
                                    <div class="staffteam">
                                       <div class="staffteamimg">
                                          <img alt="" src="{{$employee->photo}}" style="object-fit: unset!important" />
                                          <ul class="social-links">
                                             <li>Facebook</li>
                                             <li>Twitter</li>
                                             <li>Linkedin</li>
                                             <li>Google Plus</li>
                                          </ul>
                                       </div>
                                       <div class="staff-content">
                                          <h3>{{$employee->employee_name}}</h3>
                                          <span class="post">{{$employee->designation->designation_name??''}}</span>
                                       </div>
                                    </div>
                                 </div>
                                 @endforeach
                                 
                              </div>
                           </div>
                           <!--./staff-->
                        </div>
                        <!--./teamstaff-->
                     </div>
                     <!--./row-->
                  </div>
                  <!--./container-->
               </section>
             
            </div>
         </div>
         <!--./row-->
      </div>
      
<script>
   @if(Session::get('success'))
      
      Swal.fire({
         title: "Good job!",
         text: "{{Session::get('success')}}",
         icon: "success"
      });
   @endif
   @if(Session::get('warning'))
      
      Swal.fire({
         title: "Warning!",
         html: "{!!Session::get('warning')!!}",
         icon: "warning"
      });
   @endif
   


   function getPayment(){
      var script = document.createElement("script"), tag = document.getElementsByTagName("script")[0];
            // script.src = "https://seamless-epay.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7); // USE THIS FOR LIVE
            script.src = "https://sandbox.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7); // USE THIS FOR SANDBOX
            tag.parentNode.insertBefore(script, tag);
   }
</script>

      @endsection