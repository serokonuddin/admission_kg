@extends('admin.layouts.layout')
@section('content')
<style>
   #payment-info .input-group-text{
      width: 180px;
   }
</style>
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/bs-stepper/bs-stepper.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/jquery-timepicker/jquery-timepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/pickr/pickr-themes.css" />
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
       <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Employee</h4>
       <div class="row">
          <div class="col-md-12">
            <div class="bs-stepper wizard-numbered mt-2">
               <div class="bs-stepper-header">
                  <div class="step crossed" data-target="#account-details">
                     <button type="button" class="step-trigger" aria-selected="false">
                     <span class="bs-stepper-circle">1</span>
                     <span class="bs-stepper-label mt-1">
                     <span class="bs-stepper-title">Employee</span>
                     <span class="bs-stepper-subtitle">Add Employee Details</span>
                     </span>
                     </button>
                  </div>
                  <div class="line">
                     <i class="bx bx-chevron-right"></i>
                  </div>
                  <div class="step " data-target="#personal-info">
                     <button type="button" class="step-trigger" aria-selected="false">
                     <span class="bs-stepper-circle">2</span>
                     <span class="bs-stepper-label mt-1">
                     <span class="bs-stepper-title">Academic Info</span>
                     <span class="bs-stepper-subtitle">Add Academic info</span>

                     </span>
                     </button>
                  </div>
                  <div class="line">
                     <i class="bx bx-chevron-right"></i>
                  </div>
                  <div class="step " data-target="#payment-info">
                     <button type="button" class="step-trigger" aria-selected="false">
                     <span class="bs-stepper-circle">3</span>
                     <span class="bs-stepper-label mt-1">
                     <span class="bs-stepper-title">Salary Info</span>
                     <span class="bs-stepper-subtitle">Add Payment Head</span>

                     </span>
                     </button>
                  </div>


               </div>
               <div class="bs-stepper-content">

                     <!-- Account Details -->
                     <div id="account-details" class="content">
                        <div class="content-header mb-3">
                           <h6 class="mb-0">Employee Personal Information</h6>
                           <small>Enter Employee Details.</small>
                        </div>
                        <div class="row g-3">
                            <div class="card-body">
                                 <form  method="POST" action="{{route('employees.store')}}" >
                                    <input type="hidden" name="id" value="{{$employee->id??0}}" />
                                    @csrf
                                    <div class="row">
                                       <div class="mb-3 col-md-4">
                                          <label for="first_name" class="form-label">Employee Name</label>
                                          <input class="form-control" required="required" type="text" id="employee_name" name="employee_name" value="{{$employee->employee_name??''}}" placeholder="Employee Name" autofocus="">
                                       </div>
                                       <div class="mb-3 col-md-4">
                                          <label for="first_name" class="form-label">Employee Name Bangla</label>
                                          <input class="form-control" required="required" type="text" id="employee_name_bn" name="employee_name_bn" value="{{$employee->employee_name_bn??''}}" placeholder="Employee Name Bn" autofocus="">
                                       </div>
                                       <div class="mb-3 col-md-4">
                                          <label for="first_name" class="form-label">Employee Code</label>
                                          <input class="form-control"  type="text" id="emp_id" name="emp_id" value="{{$employee->emp_id??''}}" placeholder="Employee Code" autofocus="">
                                       </div>

                                       <div class="mb-3 col-md-6">
                                          <label for="first_name" class="form-label">Father Name</label>
                                          <input class="form-control"  type="text" id="father_name" name="father_name" placeholder="Father Name" value="{{$employee->father_name??''}}" autofocus="">
                                       </div>
                                       <div class="mb-3 col-md-6">
                                          <label for="last_name" class="form-label">Mother Name</label>
                                          <input class="form-control" type="text" name="mother_name" id="mother_name" placeholder="Mother Name" value="{{$employee->mother_name??''}}">
                                       </div>
                                       <div class="mb-3 col-md-6">
                                          <label for="email" class="form-label">E-mail</label>
                                          <input class="form-control"  type="text" id="email" name="email" value="{{$employee->email??''}}" placeholder="john.doe@example.com">
                                       </div>
                                       <div class="mb-3 col-md-6">
                                          <label for="organization" class="form-label">Mobile</label>
                                          <div class="input-group input-group-merge">
                                             <span class="input-group-text">BD (+88)</span>
                                             <input type="text"  id="mobile" name="mobile" value="{{$employee->mobile??''}}" class="form-control" placeholder="01XXXXXXXXX">
                                          </div>
                                       </div>
                                       <div class="mb-3 col-md-4">
                                          <label for="gender" class="form-label">Gender</label>
                                          <select id="gender" name="gender" disabled="disabled" required="required" class="form-select" required="">
                                             <option value="">Select Gender</option>
                                             <option {{(isset($employee->gender) && $employee->gender==1)?'selected="selected"':''}} value="1">Male</option>
                                             <option {{(isset($employee->gender) && $employee->gender==2)?'selected="selected"':''}} value="2">Female</option>
                                             <option {{(isset($employee->gender) && $employee->gender==3)?'selected="selected"':''}}  value="3">Other</option>
                                          </select>
                                       </div>
                                       <div class="mb-3 col-md-4">
                                          <label for="religion"  class="form-label">Religion</label>
                                          <select id="religion" required="required" disabled="disabled" name="religion" class=" form-select">
                                             <option value="">Select Religion</option>
                                             <option {{(isset($employee->religion) && $employee->religion==1)?'selected="selected"':''}}  value="1">Islam</option>
                                             <option {{(isset($employee->religion) && $employee->religion==2)?'selected="selected"':''}}  value="2">Hindu</option>
                                             <option {{(isset($employee->religion) && $employee->religion==3)?'selected="selected"':''}}  value="3">christian</option>
                                             <option {{(isset($employee->religion) && $employee->religion==4)?'selected="selected"':''}}  value="4">Buddhism</option>
                                             <option {{(isset($employee->religion) && $employee->religion==5)?'selected="selected"':''}}  value="5">Others</option>
                                          </select>
                                       </div>
                                       <div class="mb-3 col-md-4">
                                          <label for="blood" class="form-label">Blood</label>
                                          <select id="blood"  name="blood" id="blood" disabled="disabled" class=" form-select">
                                             <option value="">Select Blood</option>
                                             <option {{(isset($employee->blood) && $employee->blood=='O+')?'selected="selected"':''}} value="O+">O+</option>
                                             <option {{(isset($employee->blood) && $employee->blood=='O-')?'selected="selected"':''}} value="O-">O-</option>
                                             <option {{(isset($employee->blood) && $employee->blood=='A+')?'selected="selected"':''}} value="A+">A+</option>
                                             <option {{(isset($employee->blood) && $employee->blood=='A-')?'selected="selected"':''}} value="A-">A-</option>
                                             <option {{(isset($employee->blood) && $employee->blood=='B+')?'selected="selected"':''}} value="B+">B+</option>
                                             <option {{(isset($employee->blood) && $employee->blood=='B-')?'selected="selected"':''}} value="B-">B-</option>
                                             <option {{(isset($employee->blood) && $employee->blood=='AB+')?'selected="selected"':''}}  value="AB+">AB+</option>
                                             <option {{(isset($employee->blood) && $employee->blood=='AB-')?'selected="selected"':''}} value="AB-">AB-</option>
                                          </select>
                                       </div>
                                       <div class="mb-3 col-md-6">
                                          <label for="state" class="form-label">Birth Date</label>
                                          <input class="form-control"  type="date" id="dob" value="{{$employee->dob??''}}" name="dob" placeholder="Birth Date">
                                       </div>
                                       <div class="mb-3 col-md-6">
                                          <label for="state" class="form-label">Join Date</label>
                                          <input class="form-control"  type="date" id="join_date" value="{{$employee->join_date??''}}" name="join_date" placeholder="Join Date">
                                       </div>

                                       <div class="mb-3 col-md-6">
                                          <label for="present_address" class="form-label">Present Address</label>
                                          <textarea type="text"  class="form-control" id="present_address"  name="present_address" placeholder="Present Address" >{{$employee->present_address??''}}</textarea>
                                       </div>
                                       <div class="mb-3 col-md-6">
                                          <label for="permanent_addr" class="form-label">Permanent Address</label>
                                          <textarea type="text"  class="form-control" id="permanent_address" name="permanent_address" placeholder="Present Address" >{{$employee->permanent_address??''}}</textarea>
                                       </div>
                                       <div class="mb-3 col-md-6">
                                          <label for="nationality" class="form-label">Nationality</label>
                                          <input type="text"  class="form-control" id="nationality" value="{{$employee->nationality??''}}" name="nationality" placeholder="Nationality" >
                                       </div>
                                       <div class="mb-3 col-md-6">
                                          <label for="NID" class="form-label">NID</label>
                                          <input type="text" class="form-control" id="nid" name="nid" placeholder="NID" value="{{$employee->nid??''}}">
                                       </div>
                                       <div class="mb-3 col-md-6">
                                          <label for="passport" class="form-label">Passport</label>
                                          <input type="text" class="form-control" id="passport" name="passport" placeholder="Passport" value="{{$employee->passport??''}}">
                                       </div>
                                       <div class="mb-3 col-md-4">
                                          <label for="job_type" class="form-label">Job Type</label>

                                             @if($employee->job_type==1)
                                             <input type="text" class="form-control" id="nid" name="nid" placeholder="Permanent" value="Permanent">
                                             @else
                                             <input type="text" class="form-control" id="nid" name="nid" placeholder="Per Time" value="Per Time">
                                             @endif
                                       </div>
                                       <div class="mb-3 col-md-4">
                                          <label for="employee_for" class="form-label">Employee For</label>

                                             @if($employee->employee_for==1)
                                             <input type="text" class="form-control" id="nid" name="nid" placeholder="Primary" value="Primary">
                                             @elseif($employee->employee_for==2)
                                             <input type="text" class="form-control" id="nid" name="nid" placeholder="School" value="School">
                                             @else
                                             <input type="text" class="form-control" id="nid" name="nid" placeholder="College" value="College">
                                             @endif
                                       </div>
                                       <div class="mb-3 col-md-4">
                                          <label for="employee_for" class="form-label">Shift</label>

                                             <input type="text" class="form-control" id="nid" name="nid" placeholder="shift name" value="{{$shifts->shift_name??''}}">

                                       </div>
                                       <div class="mb-3 col-md-4">
                                          <label for="category_id" class="form-label">Category</label>

                                          <input type="text" class="form-control" id="nid" name="nid" placeholder="category name" value="{{$categorys->category_name??''}}">
                                       </div>
                                       <div class="mb-3 col-md-4">
                                          <label for="designation_id" class="form-label">Designation</label>

                                          <input type="text" class="form-control" id="nid" name="nid" placeholder="designation name" value="{{$designations->designation_name??''}}">
                                       </div>
                                       <div class="mb-3 col-md-4">
                                          <label for="subject_id" class="form-label">Subject</label>

                                          <input type="text" class="form-control" id="nid" name="nid" placeholder="subject name" value="{{$subjects->subject_name??''}}">
                                       </div>
                                       <div class="mb-3 col-md-4">
                                          <label for="version_id" class="form-label">Versions</label>

                                             <input type="text" class="form-control" id="nid" name="nid" placeholder="version name" value="{{$versions->version_name??''}}">

                                       </div>
                                       <div class="mb-3 col-md-6 form-group gallery" id="photo_gallery">
                                             <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
                                             <div class="input-group">
                                               <img src="{{$employee->photo??''}}" class="img-responsive" />
                                             </div>
                                       </div>


                                    </div>
                                    <!-- <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                    <button type="reset" class="btn btn-outline-secondary">Cancel</button> -->

                                 </form>
                              </div>

                        </div>
                     </div>
                     <!-- Personal Info -->
                     <div id="personal-info" class="content">
                        <input type="hidden" id="employee_id" value="{{$employee->id??0}}" />
                        <input type="hidden" id="education_id" value="0" />
                        <div class="row g-3">


                           <div class="table-responsive">
                              <div class="col-sm-12">
                              <table class="table" >
                              <thead>
                              <tr class="table-info">
                                 <th>Level of Education</th>
                                 <th>Discipline</th>
                                 <th>Specialization</th>
                                 <th>Educational Institue</th>
                                 <th>Passing Year</th>
                                 <th>Class/CGPA/ Grade/ Percentage</th>

                                 <th colspan="2">Action</th>

                              </tr>
                              </thead>
                                  <tbody id="educationinfo"><tr class="table-default">
                                    @foreach($educations as $education)
                                             <tr>
                                                <td>{{$education->degree->degree_name}}</td>
                                                <td>{{$education->discipline->name}}</td>
                                                <td>{{$education->specialization->specialization_name}}</td>
                                                <td>{{$education->institute}}</td>
                                                <td>{{$education->passingYear}}</td>
                                                <td>{{$education->grade_division}}:{{$education->result}}</td>
                                                <td>

                                                <div class="dropdown">
                                                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>
                                                      <div class="dropdown-menu" style="">
                                                            <a class="dropdown-item edit"
                                                            data-id="{{$education->id}}"
                                                            data-employee_id="{{$education->employee_id}}"
                                                            data-degree_id="{{$education->degree_id}}"
                                                            data-discipline_id="{{$education->discipline_id}}"
                                                            data-specialization_id="{{$education->specialization_id}}"
                                                            data-institute="{{$education->institute}}"
                                                            data-yearofschooling="{{$education->yearOfSchooling}}"
                                                            data-passingyear="{{$education->passingYear}}"
                                                            data-degree_name="{{$education->degree_name}}"
                                                            data-grade_division="{{$education->grade_division}}"
                                                            data-result="{{$education->result}}"
                                                            data-file="{{$education->file}}"
                                                            href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>

                                                      </div>
                                                   </div>
                                                </td>

                                             </tr>
                                    @endforeach
                                        </tbody>
                                 </table>

                              </div>
                           </div>

                        </div>
                     </div>
                     <!-- Social Links -->
                     <div id="payment-info" class="content">
                     <form  method="POST" action="{{route('employeeSalary')}}" >
                        <div class="row g-3">
                        @csrf
                            <input type="hidden" name="employee_id" value="{{$employee->id??0}}" />
                           <input type="hidden" name="version_id" value="{{$employee->version_id??0}}" />
                           <input type="hidden" name="session_id" value="{{$employee->session_id??0}}" />
                           <input type="hidden" name="salary_for" value="{{$employee->employee_for??0}}" />
                           <input type="hidden" name="status" value="1" />
                            <small class="text-light fw-medium d-block">Fee Head</small>
                            @php
                                    $total=0;
                               @endphp
                               @foreach($fees as $key=>$fee)
                               @if(isset($employeeHeadFee[$fee->id]))
                               @php
                                    $total+=$employeeHeadFee[$fee->id][0]->amount??0;
                               @endphp
                               <div class="col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-text">

                                        {{$fee->head_name}}
                                        </div>
                                        <input type="text" class="form-control amount" data-id="{{$fee->id}}" name="amount{{$fee->id}}" value="{{(isset($employeeHeadFee[$fee->id]))?$employeeHeadFee[$fee->id][0]->amount:''}}" readonly="" placeholder="Amount" aria-label="Text input with checkbox">
                                    </div>
                                </div>
                                @endif
                                @endforeach
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-text">

                                        Total
                                        </div>
                                        <input type="text" class="form-control amount" data-id="{{$fee->id}}" name="amount{{$fee->id}}" value="{{$total}}" readonly="" placeholder="Amount" aria-label="Text input with checkbox">
                                    </div>
                                </div>






                        </div>
                       </form>
                     </div>

               </div>
            </div>


          </div>
       </div>
    </div>
    <!-- / Content -->

    <div class="content-backdrop fade"></div>
 </div>
 <script src="{{asset('public/backend')}}/assets/vendor/libs/bs-stepper/bs-stepper.js"></script>
 <script src="{{asset('backend/assets/js/form-wizard-numbered.js')}}"></script>
<script src="{{asset('backend/assets/js/form-wizard-validation.js')}}"></script>
 <script src="{{asset('vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
<script>
$(function() {
   $("input").prop("disabled", true);
   $("textarea").prop("disabled", true);
   $('#lfm').filemanager('photo');
   $('#file1').filemanager('photo','PDF');
   $(document.body).on('input','.amount',function(){
      var value=$(this).val();
      var id=$(this).data('id');
      if(value==0 || value==''){
         $('#amount'+id).removeAttr('checked');
      }else{
         $('#amount'+id).attr('checked','checked');
      }
   });
   $(document.body).on('click','.edit',function(){
            var id=$(this).data('id');
            var specialization_id=$(this).data('specialization_id');
            var file=$(this).data('file');
            var employee_id=$(this).data('employee_id');
            var degree_id=$(this).data('degree_id');
            var discipline_id=$(this).data('discipline_id');
            var passingYear=$(this).data('passingyear');
            var yearOfSchooling=$(this).data('yearofschooling');
            var institute=$(this).data('institute');
            var degree_name=$(this).data('degree_name');
            var grade_division=$(this).data('grade_division');
            var result=$(this).data('result');
            $('#file').val(file);
            $('#education_id').val(id);
            $('#specialization_id').val(specialization_id);
            $('#employee_id').val(employee_id);
            $('#degree_id').val(degree_id);
            $('#discipline_id').val(discipline_id);
            $('#passingYear').val(passingYear);
            $('#yearOfSchooling').val(yearOfSchooling);
            $('#institute').val(institute);
            $('#degree_name').val(degree_name);
            $('#grade_division').val(grade_division);
            $('#result').val(result);
            $('#submit').text('Update');
        });
      $(document.body).on('click','#education_info',function() {
         var id=$('#education_id').val();
         var employee_id=$('#employee_id').val();
         var degree_id=$('#degree_id').val();
         var file=$('#thumbnail').val();
         var discipline_id=$('#discipline_id').val();
         var specialization_id=$('#specialization_id').val();
         var yearOfSchooling=$('#yearOfSchooling').val();
         var degree_name=$('#degree_name').val();
         var passingYear=$('#passingYear').val();
         var institute=$('#institute').val();
         var grade_division=$('#grade_division').val();
         var result=$('#result').val();
            var url="{{route('saveEducation')}}";
            if(id && degree_id && discipline_id && passingYear && result && institute && grade_division,result){


            $.LoadingOverlay("show");
            $.ajax({
                type: "post",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: url,
                data:{"_token": "{{ csrf_token() }}",degree_id,file,yearOfSchooling,institute,id,employee_id,discipline_id,specialization_id,degree_name,passingYear,grade_division,result},
                success: function(response){
                  $.LoadingOverlay("hide");
                        $('#educationinfo').html(response);


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
         }else{
            Swal.fire({
                        title: "Error",
                        text: "Please fill up * mark input field",
                        icon: "warning"
                    });
         }
      });
      $(document.body).on('change','#degree_id',function() {
         var id=$(this).val();
         var degree_id=$('#degree_id').val();
            var url="{{route('getDiscipline')}}";
            $.LoadingOverlay("show");
            $.ajax({
                type: "post",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: url,
                data:{"_token": "{{ csrf_token() }}",degree_id},
                success: function(response){
                  $.LoadingOverlay("hide");
                        $('#discipline_id').html(response);


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
      });
      $(document.body).on('change','#discipline_id',function() {
         var id=$(this).val();
         var discipline_id=$('#discipline_id').val();
            var url="{{route('getSpecialization')}}";
            $.LoadingOverlay("show");
            $.ajax({
                type: "post",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: url,
                data:{"_token": "{{ csrf_token() }}",discipline_id},
                success: function(response){
                  $.LoadingOverlay("hide");
                        $('#specialization_id').html(response);


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
      });
      $(document.body).on('change','#class_id',function() {
         var id=$(this).val();
         var shift_id=$('#shift_id').val();
         var version_id=$('#version_id').val();
            var url="{{route('getSections')}}";
            $.LoadingOverlay("show");
            $.ajax({
                type: "post",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: url,
                data:{"_token": "{{ csrf_token() }}",class_id:id,shift_id,version_id},
                success: function(response){
                  $.LoadingOverlay("hide");
                        $('#section_id').html(response);


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
      });
      $(document.body).on('change','#shift_id',function() {

         var shift_id=$('#shift_id').val();
         var version_id=$('#version_id').val();
         if(version_id && shift_id){
            var url="{{route('getClass')}}";
            $.LoadingOverlay("show");
            $.ajax({
                type: "post",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: url,
                data:{"_token": "{{ csrf_token() }}",shift_id,version_id},
                success: function(response){
                  $.LoadingOverlay("hide");
                        $('#class_id').html(response);
                        $('#section_id').html('');

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
      $(document.body).on('change','#version_id',function() {

         var shift_id=$('#shift_id').val();
         var version_id=$('#version_id').val();
        if(version_id && shift_id){
           var url="{{route('getClass')}}";
           $.LoadingOverlay("show");
           $.ajax({
               type: "post",
               headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
               url: url,
               data:{"_token": "{{ csrf_token() }}",shift_id,version_id},
               success: function(response){
                 $.LoadingOverlay("hide");
                       $('#class_id').html(response);
                       $('#section_id').html('');

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


