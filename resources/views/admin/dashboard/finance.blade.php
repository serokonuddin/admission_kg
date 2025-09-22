@extends('admin.layouts.layout')
@section('content')
@php
$color=array('primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark');

            $colordata=array('primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark','primary','secondary','success','danger','warning','info','dark');
@endphp

<div class="content-wrapper">
   <!-- Content -->
   <div class="container-xxl flex-grow-1 container-p-y">
   <h4 class="py-3 mb-4">
      <span class="text-muted fw-light">Dashboard </span>
   </h4>
   <!-- Card Border Shadow -->
   <div class="container-xxl flex-grow-1 container-p-y">

   <div class="row">
      <!-- Performance -->
      <div class="col-md-6 col-lg-4 mb-4 ">
         <div class="card h-100 bg-label-primary">
            <div class="card-header d-flex align-items-center justify-content-between">
               <div class="card-title mb-0">
                  <h5 class="m-0 me-2">Student Fee Collection</h5>
                  <small class="text-muted">Last Month</small>
               </div>

            </div>
            <div class="card-body">

               <ul class="p-0 m-0">
                  <li class="d-flex mb-4">
                     <div class="d-flex w-100 flex-wrap justify-content-between gap-2">
                        <div class="me-2">
                           <h6 class="mb-0">Total Fee</h6>
                           <small class="text-muted">12000 Students</small>
                        </div>
                        <div class="user-progress">
                          <span>2,26,45990Tk</span>
                        </div>
                     </div>
                  </li>
                  <li class="d-flex mb-4">
                     <div class="d-flex w-100 flex-wrap justify-content-between gap-2">
                        <div class="me-2">
                           <h6 class="mb-0">Total Collection</h6>
                           <small class="text-muted">9003 Students</small>
                        </div>
                        <div class="user-progress">
                            <span>1,26,45990Tk</span>
                        </div>
                     </div>
                  </li>
                  <li class="d-flex mb-4 ">
                     <div class="d-flex w-100 flex-wrap justify-content-between gap-2">
                        <div class="me-2">
                           <h6 class="mb-0">Total Due</h6>
                           <small class="text-muted">2997 Students</small>
                        </div>
                        <div class="user-progress">
                           <span>1,00,00000Tk</span>
                        </div>
                     </div>
                  </li>

               </ul>
            </div>
         </div>
      </div>
      <div class="col-md-6 col-lg-4 mb-4 ">
         <div class="card h-100 bg-label-danger">
            <div class="card-header d-flex align-items-center justify-content-between">
               <div class="card-title mb-0">
                  <h5 class="m-0 me-2">Student Admission</h5>
                  <small class="text-muted">Class XI</small>
               </div>

            </div>
            <div class="card-body">

               <ul class="p-0 m-0">
                  <li class="d-flex mb-4">
                     <div class="d-flex w-100 flex-wrap justify-content-between gap-2">
                        <div class="me-2">
                           <h6 class="mb-0">Total Student</h6>
                           <small class="text-muted">2600 Students</small>
                        </div>
                        <div class="user-progress">
                           <span></span>
                        </div>
                     </div>
                  </li>
                  <li class="d-flex mb-4">
                     <div class="d-flex w-100 flex-wrap justify-content-between gap-2">
                        <div class="me-2">
                           <h6 class="mb-0">Admission Student</h6>
                           <small class="text-muted">2000 Students</small>
                        </div>
                        <div class="user-progress">
                            <span>2,00,00,000Tk</span>
                        </div>
                     </div>
                  </li>
                  <li class="d-flex mb-4 ">
                     <div class="d-flex w-100 flex-wrap justify-content-between gap-2">
                        <div class="me-2">
                           <h6 class="mb-0">Due Admission</h6>
                           <small class="text-muted">600 Students</small>
                        </div>
                        <div class="user-progress">
                           <span></span>
                        </div>
                     </div>
                  </li>

               </ul>
            </div>
         </div>
      </div>
      <!--/ Performance -->
      <!-- Conversion rate -->
      <div class="col-md-6 col-lg-4 mb-4 ">
         <div class="card h-100 bg-label-warning">
            <div class="card-header d-flex align-items-center justify-content-between">
               <div class="card-title mb-0">
                  <h5 class="m-0 me-2">Employee Salary</h5>
                  <small class="text-muted">Last Month</small>
               </div>

            </div>
            <div class="card-body">

               <ul class="p-0 m-0">
                  <li class="d-flex mb-4">
                     <div class="d-flex w-100 flex-wrap justify-content-between gap-2">
                        <div class="me-2">
                           <h6 class="mb-0">Total Salary</h6>
                           <small class="text-muted">400 Employee</small>
                        </div>
                        <div class="user-progress">
                           <span>30,00,000Tk</span>
                        </div>
                     </div>
                  </li>
                  <li class="d-flex mb-4">
                     <div class="d-flex w-100 flex-wrap justify-content-between gap-2">
                        <div class="me-2">
                           <h6 class="mb-0">Teacher Salary</h6>
                           <small class="text-muted">400 Teacher</small>
                        </div>
                        <div class="user-progress">
                            <span>25,00,000Tk</span>
                        </div>
                     </div>
                  </li>
                  <li class="d-flex mb-4 ">
                     <div class="d-flex w-100 flex-wrap justify-content-between gap-2">
                        <div class="me-2">
                           <h6 class="mb-0">Staff Salary</h6>
                           <small class="text-muted">100 Staff</small>
                        </div>
                        <div class="user-progress">
                           <span>5,00,000Tk</span>
                        </div>
                     </div>
                  </li>

               </ul>
            </div>
         </div>
      </div>
      <div class="col-md-4 col-lg-4 mt-4">
      <a href="{{asset('pdf/Annual Budget-2024.pdf')}}" target="_blank">
                    <div class="card bg-{{$color[0]}} text-white mb-3">
                        <div class="card-header">Budget</div>
                        <div class="card-body">
                        <h5 class="card-title text-white">Last 3 Year Budget</h5>
                        <p class="card-text"></p>
                        </div>
                    </div>
                    </a>
      </div>
      <div class="col-md-4 col-lg-4 mt-4">
      <a href="{{asset('pdf/Monthly Balance Sheet April-24.pdf')}}" target="_blank">
                    <div class="card bg-{{$color[3]}} text-white mb-3">
                        <div class="card-header">Balance Sheet</div>
                        <div class="card-body">
                        <h5 class="card-title text-white">Balance Sheet PDF</h5>
                        <p class="card-text"></p>
                        </div>
                    </div>
                    </a>
      </div>
      <div class="col-md-4 col-lg-4 mt-4">
         <a href="{{asset('pdf/Tuition Fee Bengla-Morning-24 7B1 & 7B2.pdf')}}" target="_blank">
                    <div class="card bg-{{$color[4]}} text-white mb-3">
                        <div class="card-header">Student Fee</div>
                        <div class="card-body">
                        <h5 class="card-title text-white">Last Month Tution Fee</h5>
                        <p class="card-text"></p>
                        </div>
                    </div>
         </a>
      </div>
      <div class="col-md-4 col-lg-4 mt-4">
      <a href="#">
                    <div class="card bg-{{$color[5]}} text-white mb-3">
                        <div class="card-header">Student Fee</div>
                        <div class="card-body">
                        <h5 class="card-title text-white">Last 6 month Tution Fee</h5>
                        <p class="card-text"></p>
                        </div>
                    </div>
                    </a>
      </div>
      <!--/ Conversion rate -->

      <!--/ Total Balance -->
   </div>
</div>


</div>
   <!-- / Content -->
   <div class="content-backdrop fade"></div>
</div>
@endsection
