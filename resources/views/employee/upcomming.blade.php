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
       <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> {{$title}}</h4>
       <div class="col-sm-12 col-lg-12 mb-4" >
                  <div class="card bg-default text-black text-center p-3">
                    <figure class="mb-0 ">
                      <blockquote class="blockquote">
                        <p>{{$title}} Coming Soon</p>
                      </blockquote>
                      <!-- <figcaption class="blockquote-footer mb-0 text-black">
                        Someone famous in <cite title="Source Title">Source Title</cite>
                      </figcaption> -->
                    </figure>
                  </div>
      </div>
    </div>
    <!-- / Content -->

    <div class="content-backdrop fade"></div>
 </div>
 <script src="{{asset('public/backend')}}/assets/vendor/libs/bs-stepper/bs-stepper.js"></script>
 <script src="{{asset('public/backend/assets/js/form-wizard-numbered.js')}}"></script>
<script src="{{asset('public/backend/assets/js/form-wizard-validation.js')}}"></script>
 <script src="{{asset('public/vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>

@endsection


