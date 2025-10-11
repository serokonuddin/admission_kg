@extends('admin.layouts.layout')
@section('content')
<style>
    .bx {
        vertical-align: middle;
        font-size: 2.15rem;
        line-height: 1;
    }
    .text-capitalize {
        text-transform: capitalize !important;
        font-size: 25px;
    }
    .table-dark {
      --bs-table-bg: #1c4d7c !important;
      --bs-table-striped-bg: #1c4d7c !important;
      --bs-table-striped-color: #fff !important;
      --bs-table-active-bg: #1c4d7c !important;
      --bs-table-active-color: #fff !important;
      --bs-table-hover-bg: #1c4d7c !important;
      --bs-table-hover-color: #fff !important;
      color: #fff !important;
      border-color: #1c4d7c !important;
      }
      .table-dark {
      background-color: #1c4d7c !important;
      color: #fff !important;
      font-weight: bold;
      }
      .table:not(.table-dark) th {
            color: #ffffff;
         }
</style>
<div class="content-wrapper">
   <!-- Content -->
   <div class="container-xxl flex-grow-1 container-p-y">
   <h4 class="py-3 mb-4">
      <span class="text-muted fw-light">Dashboard /</span> Student
   </h4>
   <!-- Card Border Shadow -->
    @if(isset($studentdata) && count($studentdata)>1)

      <div class="row">
               <div class="col-md-12">

                  <div class="card mb-4">
                     <h5 class="card-header">Student Information</h5>
                     <div class="card-body">
                     @foreach($student as $stu)
                     <a
                     class="btn btn-primary"
                     href="{{route('StudentProfile',$stu->id)}}"
                     >
                     {{$stu->student_code.'-'.$stu->first_name.' '.$stu->last_name}}
                     </a>
                     @endforeach
                     </div>
                  </div>

               </div>
      </div>

    @else
    <form id="formAdmission" method="POST"
    @if($student->submit!=2)
    action="{{route('students.store')}}"
    @endif
    enctype="multipart/form-data">
            <div class="row">
               <div class="col-md-12">

                  <div class="card mb-4">
                     <h5 class="card-header">Student Information</h5>

                     <!-- Account -->
                     @csrf
                    <input type="hidden" name="student_code" id="student_code" value="{{$student->student_code??''}}" />
                    <input type="hidden" name="id" id="id" value="{{$id??''}}" />

                     <div class="card-body">

                           <div class="row">
                              <div class="mb-3 col-md-12">
                                 <p style="color: rgb(0,149,221)">Student Information:</p>
                                 <p class="text-danger">Asterisk(*) fields need to be completed.</p>
                              </div>
                              <div class="mb-3 col-md-6">
                                 <label for="first_name" class="form-label">First Name<span class="text-danger">*</span></label>
                                 <input class="form-control" type="text" readonly="readonly" id="first_name" name="first_name" value="{{$student->first_name??''}}" required placeholder="First Name" autofocus="">
                              </div>
                              <!-- <div class="mb-3 col-md-4">
                                 <label for="last_name" class="form-label">Last Name</label>
                                 <input class="form-control" type="text" name="last_name" id="last_name" required placeholder="Last Name" value="{{$student->last_name??''}}">
                              </div> -->
                              <div class="mb-3 col-md-6">
                                 <label for="last_name" class="form-label">Bangla Name</label>
                                 <input class="form-control" type="text" name="bangla_name" id="bangla_name"  placeholder="Bangla Name" value="{{$student->bangla_name??''}}">
                              </div>
                              <div class="mb-3 col-md-6">
                                 <label for="state" class="form-label">Birth Date<span class="text-danger">*</span></label>
                                 <input class="form-control" type="date" id="birthdate" name="birthdate" placeholder="Birth Date" value="{{$student->birthdate??''}}">
                              </div>
                              <div class="mb-3 col-md-6">
                                 <label for="state" class="form-label">Birth Registration No</label>
                                 <input class="form-control" type="text" id="birth_no" name="birth_no" placeholder="Birth Registration No" value="{{$student->birth_no??''}}">
                              </div>
                              <div class="mb-3 col-md-6">
                                 <label for="religion" class="form-label">Religion<span class="text-danger">*</span></label>
                                 <select id="religion" name="religion" class="select2 form-select"  required="">
                                    <option value="">Select Religion</option>
                                    <option value="1" {{(isset($student) && $student->religion=='1')?'selected="selected"':''}}>Islam</option>
                                    <option value="2" {{(isset($student) && $student->religion=='2')?'selected="selected"':''}}>Hindu</option>
                                    <option value="3" {{(isset($student) && $student->religion=='3')?'selected="selected"':''}}>christian</option>
                                    <option value="4" {{(isset($student) && $student->religion=='4')?'selected="selected"':''}}>Buddhism</option>
                                    <option value="5" {{(isset($student) && $student->religion=='5')?'selected="selected"':''}}>Others</option>
                                 </select>
                              </div>
                              <div class="mb-3 col-md-6">
                                 <label for="nationality" class="form-label">Nationality<span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" id="nationality" name="nationality" placeholder="Nationality" value="{{$student->nationality??''}}">
                              </div>
                              <div class="mb-3 col-md-6">
                                 <label for="email" class="form-label">E-mail<span class="text-danger">*</span></label>
                                 <input class="form-control" type="text" id="email"  name="email" required placeholder="john.doe@example.com" value="{{$student->email??''}}" placeholder="john.doe@example.com">
                              </div>
                              <div class="mb-3 col-md-6">
                                 <label for="organization" class="form-label">Mobile<span class="text-danger">*</span></label>
                                 <div class="input-group input-group-merge">
                                    <span class="input-group-text">BD (+88)</span>
                                    <input type="number" id="mobile" name="mobile" class="form-control" required placeholder="01XXXXXXXXX" value="{{$student->mobile??''}}">
                                 </div>
                              </div>
                              <div class="mb-3 col-md-6">
                                 <label for="gender" class="form-label">Gender<span class="text-danger">*</span></label>
                                 <select id="gender" name="gender" class="form-select" required="">
                                    <option value="">Select Gender</option>
                                    <option value="1" {{(isset($student) && $student->gender=='1')?'selected="selected"':''}}>Male</option>
                                    <option value="2" {{(isset($student) && $student->gender=='2')?'selected="selected"':''}}>Female</option>
                                    <option value="3" {{(isset($student) && $student->gender=='3')?'selected="selected"':''}}>Other</option>
                                 </select>
                              </div>

                              <div class="mb-3 col-md-6">
                                 <label for="blood" class="form-label">Blood</label>
                                 <select id="blood" name="blood" id="blood" class="select2 form-select">
                                    <option value="">Select Blood</option>
                                    <option value="O+" {{(isset($student) && $student->blood=='O+')?'selected="selected"':''}}>O+</option>
                                    <option value="O-" {{(isset($student) && $student->blood=='O-')?'selected="selected"':''}}>O-</option>
                                    <option value="A+" {{(isset($student) && $student->blood=='A+')?'selected="selected"':''}}>A+</option>
                                    <option value="A-" {{(isset($student) && $student->blood=='A-')?'selected="selected"':''}}>A-</option>
                                    <option value="B+" {{(isset($student) && $student->blood=='B+')?'selected="selected"':''}}>B+</option>
                                    <option value="B-" {{(isset($student) && $student->blood=='B-')?'selected="selected"':''}}>B-</option>
                                    <option value="AB+" {{(isset($student) && $student->blood=='AB+')?'selected="selected"':''}}>AB+</option>
                                    <option value="AB-" {{(isset($student) && $student->blood=='AB-')?'selected="selected"':''}}>AB-</option>
                                 </select>
                              </div>
                              <div class="mb-3 col-md-12">
                                 <p style="color: rgb(0,149,221)">Desired Subject (According ot the college prospectus):</p>
                              </div>
                              <div class="mb-3 col-md-6">
                                 <div class="col-md">
                                    @php
                                    $colors=array('primary','secondary','success','danger','warning','info','primary','secondary','success','danger','warning','info','primary','secondary','success','danger','warning','info','primary','secondary','success','danger','warning','info','primary','secondary','success','danger','warning','info');
                                    $i=0;
                                    @endphp
                                    <label for="disabledRange" class="form-label" style="font-weight: bold">Compulsory Subjects</label>
                                    @foreach($comsubjects as $key=>$subject)

                                    @php
                                    $ids='';
                                    foreach($subject as $kye=>$sub){
                                       if($kye==0){
                                          $ids=$sub->id;
                                       }else{
                                          $ids=$ids.'-'.$sub->id;
                                       }
                                    }

                                    @endphp
                                    <input  type="hidden" name="mainsubject[]" value="{{$ids}}" >
                                    <div class="form-check form-check-{{$colors[$i]}} ">
                                    <input  class="form-check-input" type="radio"  value="{{$ids}}" id="customRadioPrimary" checked="">
                                    <label class="form-check-label" for="customRadio{{$colors[$i++]}}"> {{$key}} </label>
                                    </div>

                                    @endforeach
                                    <label for="disabledRange" class="form-label" style="font-weight: bold">Group Subjects</label>
                                    @foreach($groupsubjects as $key=>$subject)
                                    @php
                                    $ids='';
                                    foreach($subject as $kye=>$sub){
                                       if($kye==0){
                                          $ids=$sub->id;
                                       }else{
                                          $ids=$ids.'-'.$sub->id;
                                       }
                                    }

                                    @endphp
                                    <div class="form-check form-check-{{$colors[$i]}} ">
                                    <input  class="form-check-input" type="radio"  value="{{$ids}}" id="customRadioPrimary" checked="">
                                    <label class="form-check-label" for="customRadio{{$colors[$i++]}}"> {{$key}} </label>
                                    </div>

                                    @endforeach
                                 </div>
                              </div>
                              <div class="mb-3 col-md-6">
                                 <label for="disabledRange" class="form-label" style="font-weight: bold">3TH Subject Select</label>
                                 @foreach($optionalsubjects as $key=>$subject)
                                 @php
                                    $ids=[];
                                    $pair=[];
                                    foreach($subject as $kye=>$sub){
                                       if($kye==0){
                                          $ids[0]=$sub->id;
                                          $pair[0]=$sub->pair;
                                       }else{
                                          $ids[1]=$sub->id;
                                          $pair[1]=$sub->pair;
                                       }
                                    }

                                    if($pair){
                                       sort($pair);
                                       $pair=implode('-', $pair);
                                    }
                                    if($ids){
                                       sort($ids);
                                       $ids=implode('-', $ids);
                                    }

                                    if(isset($activity) && in_array($activity->group_id,[1,3])){
                                       $text='radio';
                                    }else{
                                       $text='checkbox';
                                    }

                                    if(isset($student_third_subject[$key])){
                                       $checked='checked="checked"';
                                    }else{
                                       $checked='';
                                    }
                                    @endphp
                                    <div class="form-check form-check-{{$colors[$i]}} ">
                                    <input  class="form-check-input third_subject subject{{$pair}}" type="{{$text}}" name="third_subject[]" data-pair="{{$pair}}" value="{{$ids}}" id="customRadio{{$colors[$i]}}" {{$checked}}>
                                    <label class="form-check-label" for="customRadio{{$colors[$i++]}}"> {{$key}} </label>
                                 </div>

                                 @endforeach
                              <label for="disabledRange" class="form-label" style="font-weight: bold">4TH Subject Select</label>
                             @php
                             $pre_pair1='';
                             $pre_pair2='';
                             @endphp
                              @foreach($fourthsubjects as $key=>$subject)
                               @php

                                 $ids=[];
                                 $pair=[];
                                 foreach($subject as $kye=>$sub){

                                    if($kye==0){
                                       $pre_pair1=$sub->id;
                                       $ids[0]=$sub->id;
                                       $pair[0]=$sub->pair;
                                    }else{
                                       $pre_pair2=$sub->id;
                                       $ids[1]=$sub->id;
                                       $pair[1]=$sub->pair;
                                    }
                                 }

                                 if($pair){
                                    sort($pair);
                                    $pair=implode('-', $pair);
                                 }
                                 if($ids){
                                    sort($ids);
                                    $ids=implode('-', $ids);
                                 }
                                 if(isset($student_fourth_subject[$key])){
                                    $checked='checked="checked"';
                                 }else{
                                    $checked='';
                                 }
                                 @endphp
                                 <div class="form-check form-check-{{$colors[$i]}} ">
                                 <input  class="form-check-input fourth_subject subject{{$pair}}" type="radio" name="fourth_subject[]" value="{{$ids}}" data-pair="{{$pair}}" id="subject{{$colors[$i]}}" {{$checked}}>
                                 <label class="form-check-label" for="subject{{$colors[$i++]}}"> {{$key}} </label>
                                 </div>

                                 @endforeach
                              </div>
                              <div class="mb-3 col-md-12">
                                 <p style="color: rgb(0,149,221)">Secondary (SSC) exam details:</p>

                              </div>
                              <div class="mb-3 col-md-6">
                                 <label for="first_name" class="form-label">Name Of School</label>
                                 <input class="form-control" type="text" id="school_name" name="school_name"   placeholder="Name Of School" value="{{$student->school_name??''}}" autofocus="">
                              </div>
                              <div class="mb-3 col-md-6">
                                 <label for="father_email" class="form-label">Upozilla/Thana</label>
                                 <input class="form-control" type="text" id="thana" name="thana"   placeholder="Upozilla/Thana" value="{{$student->thana??''}}" autofocus="">
                              </div>
                              <div class="mb-3 col-md-4">
                                 <label for="first_name" class="form-label">Exam Center</label>
                                 <input class="form-control" type="text" id="exam_center" name="exam_center"   placeholder="Exam Center" value="{{$student->exam_center??''}}" autofocus="">
                              </div>
                              <div class="mb-3 col-md-4">
                                 <label for="father_email" class="form-label">Roll Number</label>
                                 <input class="form-control" type="text" id="roll_number" name="roll_number"   placeholder="Roll Number" value="{{$student->roll_number??''}}" autofocus="">
                              </div>
                              <div class="mb-3 col-md-4">
                                 <label for="father_email" class="form-label">Registration Number</label>
                                 <input class="form-control" type="text" id="registration_number" name="registration_number"   placeholder="Registration Number" value="{{$student->registration_number??''}}" autofocus="">
                              </div>

                              <div class="mb-3 col-md-4">
                                 <label for="father_email" class="form-label">Session: </label>
                                 <input class="form-control" type="text" id="session" name="session"   placeholder="Session" value="{{$student->session??''}}" autofocus="">
                              </div>
                              <div class="mb-3 col-md-4">
                                 <label for="father_email" class="form-label">Board Name</label>
                                 <input class="form-control" type="text" id="board" name="board"   placeholder="Board Name" value="{{$student->board??''}}" autofocus="">
                              </div>
                              <div class="mb-3 col-md-4">
                                 <label for="first_name" class="form-label">Year of passing</label>
                                 <input class="form-control" type="text" id="passing_year" name="passing_year"   placeholder="Year of passing" value="{{$student->passing_year??''}}" autofocus="">
                              </div>
                              <div class="mb-3 col-md-6">
                                 <label for="father_email" class="form-label">Result GPA</label>
                                 <input class="form-control" type="text" id="result" name="result"   placeholder="Registration Number" value="{{$student->result??''}}" autofocus="">
                              </div>
                              <div class="mb-3 col-md-6">
                                 <label for="first_name" class="form-label">GPA without 4th subject</label>
                                 <input class="form-control" type="text" id="result_fourth_subject" name="result_fourth_subject"   placeholder="GPA without 4th subject" value="{{$student->result_fourth_subject??''}}" autofocus="">
                              </div>
                              <div class="mb-3 col-md-12">
                                 <p style="color: rgb(0,149,221)">Parent Information:</p>
                              </div>

                              <div class="mb-3 col-md-3">
                                 <label for="first_name" class="form-label">Father Name</label>
                                 <input class="form-control" type="text" id="father_name" name="father_name"   placeholder="Father Name" value="{{$student->father_name??''}}" autofocus="">
                              </div>
                              <div class="mb-3 col-md-3">
                                 <label for="father_email" class="form-label">Father Email</label>
                                 <input class="form-control" type="text" id="father_email" name="father_email"   placeholder="Father Email" value="{{$student->father_email??''}}" autofocus="">
                              </div>
                              <div class="mb-3 col-md-3">
                                 <label for="father_phone" class="form-label">Father Phone</label>
                                 <input class="form-control" type="number" id="father_phone" name="father_phone"   placeholder="Father Phone" value="{{$student->father_phone??''}}" autofocus="">
                              </div>
                              <div class="mb-3 col-md-3">
                                 <label for="father_profession" class="form-label">Father Profession</label>
                                 <input class="form-control" type="text" id="father_profession" name="father_profession"   placeholder="Father Profession" value="{{$student->father_profession??''}}" autofocus="">
                              </div>
                              <div class="mb-3 col-md-3">
                                 <label for="mother_name" class="form-label">Mother Name</label>
                                 <input class="form-control" type="text" name="mother_name" id="mother_name"  placeholder="Mother Name" value="{{$student->mother_name??''}}">
                              </div>
                              <div class="mb-3 col-md-3">
                                 <label for="mother_email" class="form-label">Mother Email</label>
                                 <input class="form-control" type="text" name="mother_email" id="mother_email"  placeholder="Mother Email" value="{{$student->mother_email??''}}">
                              </div>
                              <div class="mb-3 col-md-3">
                                 <label for="mother_phone" class="form-label">Mother Phone</label>
                                 <input class="form-control" type="number" name="mother_phone" id="mother_phone"  placeholder="Mother Phone" value="{{$student->mother_phone??''}}">
                              </div>
                              <div class="mb-3 col-md-3">
                                 <label for="mother_profession" class="form-label">Mother Profession</label>
                                 <input class="form-control" type="text" name="mother_profession" id="mother_profession"  placeholder="Mother Profession" value="{{$student->mother_profession??''}}">
                              </div>
                              <div class="mb-3 col-md-6">
                                 <label for="sms_notification" class="form-label">SMS Notification<span class="text-danger">*</span></label>
                                 <input class="form-control" type="number" name="sms_notification" required="required" id="sms_notification"  placeholder="SMS Notification" value="{{$student->sms_notification??''}}">
                              </div>
                              <div class="mb-3 col-md-6">
                                 <label for="parent_income" class="form-label">Parent's Annual Income</label>
                                 <input class="form-control" type="text" name="parent_income" id="parent_income"  placeholder="Parent's Annual Income" value="{{$student->parent_income??''}}">
                              </div>

                              <div class="mb-3 col-md-12">
                                 <p style="color: rgb(0,149,221)">Address:</p>
                              </div>
                              <div class="mb-3 col-md-4">
                                 <label for="present_addr" class="form-label">Present Address</label>
                                 <input type="text" id="present_addr" name="present_addr" class="form-control" placeholder="Present Address" value="{{$student->present_addr??''}}">

                              </div>
                              <div class="mb-3 col-md-4">
                                 <label for="present_police_station" class="form-label">Present Police Station</label>
                                 <input type="text" id="present_police_station" name="present_police_station" class="form-control" placeholder="Present Police Station" value="{{$student->present_police_station??''}}">

                              </div>
                              <div class="mb-3 col-md-4">
                                 <label for="present_district_id" class="form-label">Present District</label>
                                 <select id="present_district_id" name="present_district_id" id="present_district_id" class="select2 form-select">
                                    <option value="">Select District</option>
                                    @foreach($districts as $district)
                                    <option value="{{$district->id}}" {{(isset($student) && $student->permanent_district_id==$district->id)?'selected="selected"':''}}>{{$district->name}}</option>
                                    @endforeach
                                 </select>
                              </div>

                              <div class="mb-3 col-md-4">
                                 <label for="permanent_addr" class="form-label">Permanent Address</label>
                                 <input type="text" id="permanent_addr" name="permanent_addr" class="form-control" placeholder="Permanent Address" value="{{$student->permanent_addr??''}}">

                              </div>
                              <div class="mb-3 col-md-4">
                                 <label for="permanent_police_station" class="form-label">Permanent Police Station</label>
                                 <input type="text" id="permanent_police_station" name="permanent_police_station" class="form-control" placeholder="Permanent Police Station" value="{{$student->permanent_police_station??''}}">

                              </div>
                              <div class="mb-3 col-md-4">
                                 <label for="permanent_district_id" class="form-label">Permanent District</label>
                                 <select id="permanent_district_id" name="permanent_district_id" id="permanent_district_id" class="select2 form-select">
                                    <option value="">Select District</option>
                                    @foreach($districts as $district)
                                    <option value="{{$district->id}}" {{(isset($student) && $student->permanent_district_id==$district->id)?'selected="selected"':''}}>{{$district->name}}</option>
                                    @endforeach
                                 </select>
                              </div>
                              <div class="mb-3 col-md-12">
                                 <p style="color: rgb(0,149,221)">Local Guardian:</p>
                              </div>
                              <div class="mb-3 col-md-3">
                                 <label for="local_guardian_name" class="form-label">Local Guardian Name</label>
                                 <input type="text" class="form-control" id="local_guardian_name" name="local_guardian_name" placeholder="Guardian Name" value="{{$student->local_guardian_name??''}}">
                              </div>
                              <div class="mb-3 col-md-3">
                                 <label for="guardian_name" class="form-label">Local Guardian Mobile</label>
                                 <input type="text" class="form-control" id="local_guardian_mobile" name="local_guardian_mobile" placeholder="Guardian Mobile" value="{{$student->local_guardian_mobile??''}}">
                              </div>
                              <div class="mb-3 col-md-3">
                                 <label for="guardian_email" class="form-label">Local Guardian Email</label>
                                 <input type="text" class="form-control" id="local_guardian_email" name="local_guardian_email" placeholder="Guardian Email" value="{{$student->local_guardian_email??''}}">
                              </div>
                              <div class="mb-3 col-md-3">
                                 <label for="student_relation" class="form-label">Student's Relation</label>
                                 <input type="text" id="student_relation" name="student_relation" class="form-control" placeholder="Local guardian Police Station" value="{{$student->student_relation??''}}">

                              </div>
                              <div class="mb-3 col-md-4">
                                 <label for="local_guardian_address" class="form-label">Local Guardian Address</label>
                                 <input type="text" id="local_guardian_address" name="local_guardian_address" class="form-control" placeholder="Local guardian Address" value="{{$student->local_guardian_addr??''}}">

                              </div>
                              <div class="mb-3 col-md-4">
                                 <label for="local_guardian_police_station" class="form-label">Local Police Station</label>
                                 <input type="text" id="local_guardian_police_station" name="local_guardian_police_station" class="form-control" placeholder="Local guardian Police Station" value="{{$student->local_guardian_police_station??''}}">

                              </div>
                              <div class="mb-3 col-md-4">
                                 <label for="local_guardian_district_id" class="form-label">Local guardian District</label>
                                 <select id="local_guardian_district_id" name="local_guardian_district_id" id="local_permanent_district_id" class="select2 form-select">
                                    <option value="">Select District</option>
                                    @foreach($districts as $district)
                                    <option value="{{$district->id}}" {{(isset($student) && $student->local_guardian_district_id==$district->id)?'selected="selected"':''}}>{{$district->name}}</option>
                                    @endforeach
                                 </select>
                              </div>
                              <div class="mb-3 col-md-12">
                                 <p style="color: rgb(0,149,221)">For the children of armed force's members (In sevice/Retired):</p>
                              </div>
                              <div class="mb-3 col-md-4">
                                 <label for="local_guardian_name" class="form-label">Service number</label>
                                 <input type="text" class="form-control" id="service_number" name="service_number" placeholder="Service number" value="{{$student->service_number??''}}">
                              </div>
                              <div class="mb-3 col-md-4">
                                 <label for="guardian_name" class="form-label">Designation</label>
                                 <input type="text" class="form-control" id="designation" name="designation" placeholder="Designation" value="{{$student->designation??''}}">
                              </div>
                              <div class="mb-3 col-md-4">
                                 <label for="guardian_email" class="form-label">Name</label>
                                 <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{$student->name??''}}">
                              </div>
                              <div class="mb-3 col-md-6">
                                 <label for="guardian_name" class="form-label">Force Name</label>
                                 <input type="text" class="form-control" id="arms_name" name="arms_name" placeholder="Force Name" value="{{$student->arms_name??''}}">
                              </div>
                              <div class="mb-3 col-md-6">
                                 <label for="guardian_email" class="form-label">In service</label>
                                 <select id="is_service" name="is_service"  class="select2 form-select">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>

                                 </select>
                              </div>
                              <div class="mb-3 col-md-6">
                                 <label for="guardian_email" class="form-label">Office Address</label>
                                 <input type="text" class="form-control" id="office_address" name="office_address" placeholder="Office Address" value="{{$student->office_address??''}}">
                              </div>
                              <div class="mb-3 col-md-6">
                                 <label for="guardian_name" class="form-label">Mobile/Telephone Number</label>
                                 <input type="text" class="form-control" id="telephone_number" name="telephone_number" placeholder="Mobile/Telephone Number" value="{{$student->telephone_number??''}}">
                              </div>

                              <div class="mb-3 col-md-6">
                                 <label for="photo" class="form-label">Photo <span class="text-danger">(Passport Size Photo White Background:591x709 pixels)*</span></label>
                                 <input class="form-control" type="file" id="photo" onchange="loadFile(event,'photo_preview')" name="photo" {{(!empty($student->photo))?'':'required=""'}}>
                                 <span style="color: rgb(0,149,221)">আপনার ফটো সংযুক্ত করুন (সর্বোচ্চ ৫০০ কেবি)</span>
                                 <input class="form-control" type="hidden" id="photo_old" value="{{$student->photo??''}}" name="photo_old" >

                                 <div class="mb-3 col-md-12">
                                    <img src="{{$student->photo??''}}" id="photo_preview" style="height: 100px; width: auto" />
                                  </div>
                              </div>

                              <div class="mb-3 col-md-6">
                                 <label for="testimonial" class="form-label">Testimonial Of The School<span class="text-danger">*</span></label>
                                 <input class="form-control" type="file" id="testimonial" onchange="loadFile(event,'testimonial_preview')" name="testimonial" {{(!empty($student->testimonial))?'':'required=""'}}>
                                 <span style="color: rgb(0,149,221)">আপনার সার্টিফিকেটে এর ফাইল সংযুক্ত করুন (সর্বোচ্চ ৫০০ কেবি)</span>
                                 <input class="form-control" type="hidden" id="testimonial_old" value="{{$student->testimonial??''}}" name="testimonial_old" >
                                 <div class="mb-3 col-md-12">
                                    <img src="{{$student->testimonial??''}}" id="testimonial_preview" style="height: 100px; width: auto" />
                                  </div>
                              </div>
                              <div class="mb-3 col-md-6">
                                 <label for="academic_transcript" class="form-label">Academic Transcript<span class="text-danger">*</span></label>
                                 <input class="form-control" type="file" onchange="loadFile(event,'academic_transcript_preview')" id="academic_transcript" {{(!empty($student->academic_transcript))?'':'required=""'}} name="academic_transcript">
                                 <span style="color: rgb(0,149,221)"> আপনার সার্টিফিকেটে এর ফাইল সংযুক্ত করুন (সর্বোচ্চ ৫০০ কেবি)</span>
                                 <input class="form-control" type="hidden" id="academic_transcript_old" value="{{$student->academic_transcript??''}}" name="academic_transcript_old" >
                                 <div class="mb-3 col-md-12">
                                    <img src="{{$student->academic_transcript??''}}" id="academic_transcript_preview" style="height: 100px; width: auto" />
                                  </div>
                              </div>

                           </div>


                     </div>
                     <!-- /Account -->
                  </div>
                  <div class="card">
                     <h5 class="card-header" style="color: rgb(0,149,221)">Academic Information</h5>
                     <div class="card-body">
                        @if(isset($activity) && $activity->class_id==59)
                        <input type="hidden" name="class_id" value="{{$activity->class_id}}" />
                        <input type="hidden" name="session_id" value="{{$activity->session_id}}" />
                        <input type="hidden" name="version_id" value="{{$activity->version_id}}" />
                        @endif

                        <div class="row">
                              <div class="mb-3 col-md-4">
                                 <label for="session_id" class="form-label">Session</label>
                                 <select id="session_id" disabled="disabled" name="session_id" class=" form-select" required="">
                                 <option value="">Select Session</option>
                                 @foreach($sessions as $session)
                                 <option value="{{$session->id}}" {{(isset($activity) && $activity->session_id==$session->id)?'selected="selected"':''}}>{{$session->session_name}}</option>
                                 @endforeach

                                 </select>
                              </div>
                              <div class="mb-3 col-md-4">
                                    <label for="version_id" class="form-label">Version</label>
                                    <select id="version_id"  disabled="disabled" name="version_id" class=" form-select" required="">
                                    <option value="">Select Version</option>
                                    @foreach($versions as $version)
                                    <option value="{{$version->id}}" {{(isset($activity) && $activity->version_id==$version->id)?'selected="selected"':''}}>{{$version->version_name}}</option>
                                    @endforeach

                                    </select>
                              </div>

                              <div class="mb-3 col-md-4">
                                    <label for="shift_id"  class="form-label">Shift</label>
                                    <select id="shift_id" disabled="disabled" name="shift_id" class=" form-select" required="">
                                    <option value="">Select Shift</option>
                                    @foreach($shifts as $shift)
                                    <option value="{{$shift->id}}" {{(isset($activity) && $activity->shift_id==$shift->id)?'selected="selected"':''}}>{{$shift->shift_name}}</option>
                                    @endforeach

                                    </select>
                              </div>
                              <div class="mb-3 col-md-4">
                                 <label for="class_id" class="form-label">Class</label>
                                 <select id="class_id" disabled="disabled" name="class_id" class=" form-select" required="">
                                 <option value="">Select Class</option>
                                 @foreach($classes as $class)
                                 <option value="{{$class->id}}" {{(isset($activity) && $activity->class_id==$class->id)?'selected="selected"':''}}>{{$class->class_name}}</option>
                                 @endforeach

                                 </select>
                              </div>
							<!--
                              <div class="mb-3 col-md-4">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select id="category_id"  name="category_id" disabled="disabled" class=" form-select" >
                                    <option value="">Select Category</option>

                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{(isset($activity) && $activity->category_id==$category->category_id)?'selected="selected"':''}}>{{$category->category_name}}</option>
                                    @endforeach
                                    </select>
                              </div>
								-->
                              <div class="mb-3 col-md-4">
                                    <label for="group_id" class="form-label">Group</label>
                                    <select id="group_id" name="group_id" disabled="disabled" class=" form-select" required="">
                                    <option value="">Select Group</option>

                                    @foreach($groups as $group)
                                    <option value="{{$group->id}}"  {{(isset($activity) && $activity->group_id==$group->id)?'selected="selected"':''}}>{{$group->group_name}}</option>
                                    @endforeach
                                    </select>
                              </div>

                              <div class="mb-3 col-md-4">
                                    <label for="section_id" class="form-label">Section</label>
                                    <select id="section_id" disabled="disabled" name="section_id" class=" form-select" >
                                    <option value="">Select Section</option>
                                    @foreach($sections as $section)
                                    <option value="{{$section->id}}" {{(isset($activity) && $activity->section_id==$section->id)?'selected="selected"':''}}>{{$section->section_name}}</option>
                                    @endforeach
                                    </select>
                              </div>
                              <div class="mb-3 col-md-4">
                                    <label for="house_id" class="form-label">House</label>
                                    <select id="house_id" disabled="disabled" name="house_id" class=" form-select" >
                                    <option value="">Select House</option>
                                    @foreach($houses as $house)
                                    <option value="{{$house->id}}" {{(isset($activity) && $activity->house_id==$house->id)?'selected="selected"':''}}>{{$house->house_name}}</option>
                                    @endforeach
                                    </select>
                              </div>
                              <div class="mb-3 col-md-4">
                                 <label for="roll" class="form-label">Roll</label>
                                 <input class="form-control" disabled="disabled" type="text" id="roll" name="roll"  value="{{ $activity->roll??''}}" placeholder="Roll" autofocus="">
                              </div>
                        </div>
                        @if($student->submit!=2)
                        <input type="hidden" class="btn btn-warning me-2" name="submit" id="submit"  value="1">
                        <button type="button" class="btn btn-outline-warning" id="final_submit">Final Submit</button>
                        <button type="submit" class="btn btn-outline-primary" id="savebuuton">Save</button>
                        <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                        @else
                        <a href="{{url('admin/studentPrint/'.$student->id)}}" class="btn btn-outline-primary">Print</a>
                        @endif
                     </div>
                  </div>
               </div>
            </div>
      </form>
    @endif

</div>
   <!-- / Content -->

   <div class="content-backdrop fade"></div>
</div>
<script src="{{asset('public/vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
<img id="output"/>
<script>
  var loadFile = function(event,preview) {

   var sizevalue=(event.target.files[0].size);

        if(sizevalue > 500000) {

            Swal.fire({
               title: "warning!",
               text: "File Size Too Large",
               icon: "warning"
            });
            var idvalue=preview.slice(0, -8);

            $('#'+idvalue).val('');
            return false;
        }else{
         var output = document.getElementById(preview);
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
               URL.revokeObjectURL(output.src) // free memory
            }
        }

  };
</script>
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
         title: "warning!",
         text: "{{Session::get('warning')}}",
         icon: "warning"
      });
   @endif
    $(function(){
      $(document.body).on('click','#final_submit',function(){

         Swal.fire({
			  title: 'Do you want to Final Submit For Admission?',
			  showDenyButton: true,
			  confirmButtonText: 'Yes',
			  denyButtonText: 'No',
			  customClass: {
				actions: 'my-actions',
				cancelButton: 'order-1 right-gap',
				confirmButton: 'order-2',
				denyButton: 'order-3',
			  },
			}).then((result) => {
			  if (result.isConfirmed) {

            $('#submit').val(2);
            var btn = document.getElementById('savebuuton');
            btn.click();
            btn.disabled = true;
            //$('#savebuuton').trigger('click');
			  } else if (result.isDenied) {

			  }
			})

      });
      $('#lfm').filemanager('image');
      $('#lfm1').filemanager('image');
         @if(count($studentdata)>1)
         $('#modalToggle').modal('show');
         @endif
         $('.form-check-input.third_subject').change(function(){
            var checkvalue=$(this).val();
            var pair=$(this).data('pair');
            var third_subject = [];
            var third_pair_subject = [];
            var pre_pair='';
            $('.form-check-input.third_subject:checked').each(function(){
               if(pre_pair==$(this).val()){
                  $(this).prop( "checked", false );
                  return false;
               }else{
                  pre_pair=$(this).data('pair');
               }

               third_subject.push($(this).val());

            });
            // selectedThirdValues = [];
            // $('.form-check-input.third_subject:checked').each(function(){
            //    selectedThirdValues.push($(this).val());
            // });
            var fourth_pair_subject = [];
            $('.form-check-input.fourth_subject:checked').each(function(){

               if($(this).val()==checkvalue){
                  $(this).prop( "checked", false );
               }

            });
            var fourth_subject = [];
            $('.form-check-input.fourth_subject:checked').each(function(){
               fourth_subject.push($(this).val());

            });
            console.log(pair, fourth_subject);

            // third to array
            if ($.inArray(pair, fourth_subject) >= 0) {
                $('.subject'+pair).prop( "checked", false );
                return false;
            }
            $('.form-check-input.third_subject:checked').each(function(){
               third_subject.push($(this).val());

            });
            var url="{{route('checksection')}}";
            if(fourth_subject.length>0 && third_subject.length>0){
               var class_id=$('#class_id').val();
               var session_id=$('#session_id').val();
               var version_id=$('#version_id').val();
               var group_id=$('#group_id').val();
               var roll=$('#roll').val();
               $.LoadingOverlay("show");
               $.ajax({
                  type: "post",
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                  url: url,
                  data:{"_token": "{{ csrf_token() }}",fourth_subject,third_subject,student_code:roll,class_id,session_id,version_id,group_id},
                  success: function(response){

                     $.LoadingOverlay("hide");

                     $('#section_id').val(response);


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
         $('.form-check-input.fourth_subject').change(function(){
            var checkvalue=$(this).val();
            var pair=$(this).data('pair');
            var fourth_subject = [];
            $('.form-check-input.fourth_subject:checked').each(function(){
               fourth_subject.push($(this).val());

            });
            // selectedThirdValues = [];
            // $('.form-check-input.third_subject:checked').each(function(){
            //    selectedThirdValues.push($(this).val());
            // });

            $('.form-check-input.third_subject:checked').each(function(){

               if($(this).val()==checkvalue){
                  $(this).prop( "checked", false );
               }
            });

            var third_subject = [];
            $('.form-check-input.third_subject:checked').each(function(){
               third_subject.push($(this).val());

            });
              // fourth to array
              console.log(pair, third_subject);
              if ($.inArray(pair, third_subject) >= 0) {
                $('.subject'+pair).prop( "checked", false );
                return false;
              }

              $('.form-check-input.fourth_subject:checked').each(function(){
               fourth_subject.push($(this).val());

               });
            var url="{{route('checksection')}}";
            if(fourth_subject.length>0 && third_subject.length>0){
               var class_id=$('#class_id').val();
               var session_id=$('#session_id').val();
               var version_id=$('#version_id').val();
               var group_id=$('#group_id').val();
               var roll=$('#roll').val();
               $.LoadingOverlay("show");
               $.ajax({
                  type: "post",
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                  url: url,
                  data:{"_token": "{{ csrf_token() }}",fourth_subject,third_subject,student_code:roll,class_id,session_id,version_id,group_id},
                  success: function(response){

                     $.LoadingOverlay("hide");

                     $('#section_id').val(response);


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

         @if(isset($student->submit) && $student->submit==2)

         $("input,select,textarea").prop("disabled", true);
         @endif
    });
</script>
@endsection
