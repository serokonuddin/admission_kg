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
                    <h3 style="text-align: center">College Admission (কলেজ ভর্তি): ({{$sessions->session_name.'-'.((int)$sessions->session_name+1)}}) </h3>
                    <form action="{{route('payment')}}"  method="post" enctype="multipart/form-data" class="onlineform" id="checkstatusform">
                        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                        <input type="hidden" name="version_id" id="version_id" value="{{$checkadmission->version_id}}" />
                        <input type="hidden" name="class_id" id="class_id" value="{{$checkadmission->class_id}}" />
                        <input type="hidden" name="session_id" id="session_id" value="{{$checkadmission->session_id}}" />
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                    <label>SSC Roll Number</label><small class="req"> *</small>
                                        <input type="text" readonly="" class="form-control" required="" value="{{$checkadmission->roll_number}}" name="roll_number" id="roll_number" autocomplete="off">
                                        <span class="text-danger" id="error_status_roll_number"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                    <label>Board (বোর্ড)</label><small class="req"> *</small>
                                        <select class="form-control" name="board_id" id="board_id">

                                            <option value=""> শিক্ষাবোর্ড নির্বাচন করুণ </option>
                                            <option value="Dhaka" {{(strtolower($checkadmission->board)=='dhaka')?'selected="selected"':''}}>Dhaka (ঢাকা)</option>
                                            <option value="Rajshahi" {{(strtolower(strtolower($checkadmission->board))=='Rajshahi')?'selected="selected"':''}}>Rajshahi (রাজশাহী)</option>
                                            <option value="Comilla" {{(strtolower($checkadmission->board)=='comilla')?'selected="selected"':''}}>Comilla (কুমিল্লা)</option>
                                            <option value="Jessore" {{(strtolower($checkadmission->board)=='jessore')?'selected="selected"':''}}>Jessore (যশোর)</option>
                                            <option value="Chittagong" {{(strtolower($checkadmission->board)=='chittagong')?'selected="selected"':''}}>Chittagong (চট্টগ্রাম)</option>
                                            <option value="Barisal" {{(strtolower($checkadmission->board)=='barisal')?'selected="selected"':''}}>Barisal (বরিশাল)</option>
                                            <option value="Sylhet" {{(strtolower($checkadmission->board)=='sylhet')?'selected="selected"':''}}>Sylhet (সিলেট)</option>
                                            <option value="Dinajpur" {{(strtolower($checkadmission->board)=='dinajpur')?'selected="selected"':''}}>Dinajpur (দিনাজপুর)</option>
                                            <option value="Madrasa" {{(strtolower($checkadmission->board)=='madrasa')?'selected="selected"':''}}>Madrasa (মাদ্রাসা)</option>
                                            <option value="TEC" {{(strtolower($checkadmission->board)=='tec')?'selected="selected"':''}}>Bangladesh Technical Education (বাংলাদেশ কারিগরি শিক্ষা বোর্ড)</option>
                                            <option value="BOU" {{(strtolower($checkadmission->board)=='bou')?'selected="selected"':''}}>BOU (বাউবি)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                    <label>Full Name</label><small class="req"> *</small>
                                        <input type="text" readonly="" class="form-control" required="" value="{{$checkadmission->full_name}}" name="full_name" id="full_name" autocomplete="off">
                                        <span class="text-danger" id="error_status_full_name"></span>
                                    </div>
                                </div>
                                <!-- <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                    <label>Board</label><small class="req"> *</small>
                                    <input type="text"  readonly="" class="form-control" required="" value="{{strtolower($checkadmission->board)}}" name="board" id="board" autocomplete="off">
                                       
                                    <span class="text-danger" id="error_status_board"></span>
                                    </div>
                                </div> -->
                                    <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Group (বিভাগ):</label><small class="req"> *</small>
                                                <div><input type="text" readonly="readonly" class="form-control" placeholder="Group Name" required="" value="{{$checkadmission->group_name}}" readonly="readonly" name="group_name" id="group_name" autocomplete="off">
                                                </div>
                                                <span class="text-danger" id="error_status_serial"></span>
                                            </div>
                                        
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                        <label>Username (ইউজার নাম)</label><small class="req"> *</small>
                                            <input type="text" class="form-control" placeholder="Valid Email,phone or username. Username should not contain spaces and spacial character" required="" name="username" id="username" autocomplete="off">
                                            <span class="text-danger" id="error_status_email"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                        <label>Email (ই-মেইল)</label>
                                            <input type="text" class="form-control" placeholder="Valid Email"  name="email" id="email" autocomplete="off">
                                            <span class="text-danger" id="error_status_email"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                        <label>Phone (ফোন) (This Number Must be Used While Enrolled In Shaheen College Dhaka)</label><small class="req"> *</small>
                                            <input type="number" class="form-control" value="{{$checkadmission->mobile}}" placeholder="Valid Phone Number Ex. 01XXXXXXXXX (ফোন)" required="" name="phone" id="phone" autocomplete="off">
                                            <span class="text-danger" id="error_status_phone"></span>
                                        </div>
                                    </div>
                                    
                                    <!-- <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label>Admission Serial (এডমিশন সিরিয়াল):</label>
                                                <div><input type="text" readonly="readonly" class="form-control" placeholder="Valid S.S.C Serial"  value="{{$serial}}" readonly="readonly" name="serial" id="serial" autocomplete="off">
                                                </div>
                                                <span class="text-danger" id="error_status_serial"></span>
                                            </div>
                                        
                                    </div> -->
                                    
                                    <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <br>
                                        <div>
                                        <button type="submit" class="onlineformbtn mdbtn" >Pay Now</button>
                                        </div>
                                    </div>
                                    </div>
                        </form>
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
<script>
    $(function(){
        $(document.body).on('change','#username',function(){
            
            var username=$('#username').val();
            username=username.replace(/\s/g,'');
            
           
        
            var url="{{route('usernamecheck')}}";
            if(username.length>0){
            $.LoadingOverlay("show");
            $.ajax({
                type: "post",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: url,
                data:{"_token": "{{ csrf_token() }}",username},
                success: function(response){
                    
                    $.LoadingOverlay("hide");
                    if(response==1){
                        $('#username').val('');
                        Swal.fire({
                            title: "Error",
                            text: 'Username Already Exist.',
                            icon: "warning"
                        });
                    }else{
                        $('#username').val(username);
                    }
                    
                },
                error: function(data, errorThrown)
                {
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

@endsection