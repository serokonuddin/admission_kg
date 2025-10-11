@extends('frontend.layout')
@section('content')
<style>
   .form-check{
      border-bottom: 1px solid #eee;
      font-size: 15px;
      padding: 5px;
      
   }
   .form-check a{
      color: black!important;
   }
   .form-check a:hover{
      color: #337AB7!important;
      font-weight: bold;
   }
   .sidecourse-title a{
      font-size: 16px;
      font-weight: bold;
   }
   @media (min-width: 768px) {
      .modal-content{
         width: 620px!important;
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
</style>
<div class="container spacet20">
   <div class="row">
      <div class="col-md-12 spacet60 pt-0-mobile">
         
         <!--./coursebtnaddModal-->
         <div class="row">
            <div class="container spaceb50">
               <div class="row">
                  
                  <!--./col-md-12-->
                  <div class="refine-categ-header">
                    
                    <h3 style="text-align: center">Online Admission (অনলাইন ভর্তি) </h3>
                    <h4 style="text-align: center"> <a href="{{asset('public/admissionpdf/Onine Admission.pdf')}}" target="_blank">Admission Instruction (ভর্তির নির্দেশনা)</a> </h4>
                    <h4 style="text-align: center"> <img title="Hotline Number" src="{{asset('public/call-thumbnail.png')}}" style="height: 25px" /> <a href="tel:01759536622" style="color: red;font-weight: bold;">01759536622, </a><a href="tel:01777521159" style="color: red;font-weight: bold;">01777521159</a> </h4>
                    <table class="table table-striped table-bordered">
                     <thead>
                        <tr>
                           <th>SL</th>
                           <th>Class</th>
                           <th>Version</th>
                           <th>Session</th>
                          
                           <th>Date</th>
                           <th>Number Of Seat</th>
                           <th>Amount</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($admissiondata as $key=>$admission)
                        <tr>
                           <td>{{$key+1}}</td>
                           <td>{{$admission->class->class_name}}</td>
                           <td>{{$admission->version->version_name}}</td>
                           <td>{{($admission->class->class_code==11)?($session->session_name.'-'.((int)$session->session_name+1)):$admission->session->session_name}}</td>
                           
                           <td>Start Date:{{$admission->start_date}}<br/><span style="color: red;font-weight: bold">End Date:{{$admission->end_date}}</span></td>
                           <td>{{$admission->number_of_admission}}</td>
                           <td>{{$admission->amount}}৳</td>
                           <td>
                              @if($admission->class->class_code==11)
                                 <a href="javascript:void(0)" 
                                 data-class_id="{{$admission->class_id}}" 
                                 data-session_id="{{$admission->session_id}}" 
                                  data-versionid="{{$admission->version_id}}" data-version="{{$admission->version->version_name}}"   class="onlineformbtn mdbtn mb12" name="search" id="search_btn">Registration</a>
                              @else 

                              @endif
                              </td>
                        </tr>
                        @endforeach
                        
                     </tbody>
                  </table>
                  <table class="table">
                     <tr><td style="text-align: center;border: none;">
                     <a class="onlineformbtn" href="{{route('login')}}" style="">Already Registered Click Here</a>
                     </td></tr>
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
               <button type="button" class="close closebtnmodal" data-dismiss="modal">&times;</button>
               <h4 ><span id="version_name" style="color: red; font-weight: bold;font-size:17px!important"></span></h4>
               </div>
               <form action="{{route('admissionData')}}"  method="post" enctype="multipart/form-data" class="onlineform" id="checkstatusform">
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
                              <input type="text" class="form-control" required="" name="full_name" id="full_name"  readonly="readonly" autocomplete="off">
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
                     <button type="submit" class="onlineformbtns mdbtn" >Submit</button>
                  </div>
               </form>
            </div>
         </div>
   </div>
<script>
   @if(Session::get('warning'))
      
      Swal.fire({
         title: "Warning!",
         html: "{!!Session::get('warning')!!}",
         icon: "warning"
      });
      
   @endif
   $(function(){
      
      $(document.body).on('click','.onlineformbtn',function(){
         var versionid=$(this).data('versionid');
         var version_name=$(this).data('version');
         var class_id=$(this).data('class_id');
         var session_id=$(this).data('session_id');
         $('#version_id').val(versionid);
         $('#class_id').val(class_id);
         $('#session_id').val(session_id);
         var text='';
         if(versionid==1){
            text="XI Class Admission-Bangla Version (একাদশ শ্রেণিতে ভর্তি-বাংলা ভার্শন)"
         }else{
            text="XI Class Admission-English Version (একাদশ শ্রেণিতে ভর্তি-ইংরেজি ভার্শন)"
         }
         $('#version_name').html(text);
         $('#checkOnlineAdmissionStatus').modal('show'); 
      });
      $(document.body).on('input','#roll_number',function(){
        
         var roll_number=$('#roll_number').val();
         
         
         var board_id=$('#board_id').val();
        
         var url="{{route('checkRollRegistrationNumber')}}";
         if(roll_number.length==6 && board_id){
            $.LoadingOverlay("show");
         $.ajax({
                type: "post",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: url,
                data:{"_token": "{{ csrf_token() }}",roll_number,board_id},
                success: function(response){
                 
                  $.LoadingOverlay("hide");
                  if(response==0){
                    
                     Swal.fire({
                        title: "Error",
                        text: 'Roll number or Board not found in BAF Shaheen College Dhaka Database',
                        icon: "warning"
                    });
                    
                  }else if(response==2){
                    
                     Swal.fire({
                        title: "BAF Shaheen College Dhaka",
                        text: 'Congratulations!  You have got a chance to get admission at BAF Shaheen college Dhaka by EQ/FQ. Contact College Office with the necessary documents for verification.',
                        icon: "success"
                    });
                        
                  }else if(response==1){
                     
                     Swal.fire({
                        title: "Error",
                        text: 'Allready applied',
                        icon: "warning"
                    });
                     
                  }else{
                     var data=jQuery.parseJSON( response )
                     $('#full_name').val(data.full_name);
                     $('#group_name').val(data.group_name);
                  }
                     
                   
                  
                },
                error: function(data, errorThrown)
                {
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
      $(document.body).on('submit','#checkadmissionstatus',function(e){
     

         e.preventDefault(); // avoid to execute the actual submit of the form.

         var form = $(this);
         var actionUrl = form.attr('action');
         $.LoadingOverlay("show");
         $.ajax({
            type: "POST",
            url: actionUrl,
            data: form.serialize(), // serializes the form's elements.
            success: function(data)
            {
               $.LoadingOverlay("hide");
               getPayment(data); // show response from the php script.
            }
         });

      });
      $(document.body).on('change','#onlineformbtn',function(){

      });
      $(document.body).on('change','#board_id',function(){
         var roll_number=$('#roll_number').val();
         
         
         var board_id=$('#board_id').val();
        
         var url="{{route('checkRollRegistrationNumber')}}";
         if(roll_number.length==6 && board_id){
            $.LoadingOverlay("show");
            $.ajax({
                type: "post",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: url,
                data:{"_token": "{{ csrf_token() }}",roll_number,board_id},
                success: function(response){
                  
                  $.LoadingOverlay("hide");
                  if(response==0){
                     Swal.fire({
                        title: "Error",
                        text: 'Roll number or Board not found in BAF Shaheen College Dhaka Database',
                        icon: "warning"
                    });
                    
                   
                  }else if(response==1){
                     
                     Swal.fire({
                        title: "Error",
                        text: 'Allready applied',
                        icon: "warning"
                    });
                     
                  }else if(response==2){
                   
                     Swal.fire({
                        title: "BAF Shaheen College Dhaka",
                        text: 'Congratulations!  You have got a chance to get admission at BAF Shaheen college Dhaka by EQ/FQ. Contact College Office with the necessary documents for verification.',
                        icon: "success"
                    });
                     
                  }else{
                     var data=jQuery.parseJSON( response )
                     $('#full_name').val(data.full_name);
                     $('#group_name').val(data.group_name);
                  }
                     
                   
                  
                },
                error: function(data, errorThrown)
                {
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
   });
</script>
@endsection