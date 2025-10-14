@extends('admin.layouts.layout')
@section('content')
    <style>
        /* .bx {
                                    vertical-align: middle;
                                    font-size: 2.15rem;
                                    line-height: 1;
                                } */

        .text-capitalize {
            text-transform: capitalize !important;
            font-size: 25px;
        }

        .text-right {
            margin-left: 100%;
        }

        .demo-wrap {
            overflow: hidden;
            position: relative;
        }

        .demo-bg {
            opacity: 0.3;
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: -webkit-fill-available !important;
        }

        .demo-content {
            position: relative;
        }

        .modal-body {
            height: 300px;
            font-size: 26px;
            color: #0004ee;
            font-weight: bold;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">Dashboard </span>
            </h4>
            <!-- Card Border Shadow -->
            <div class="row mt-4">
                <div class="col-sm-6 col-lg-4">
                    <div class="card icon-card card-border-shadow-warning cursor-pointer text-center">
                        <a href="{{ route('StudentProfile', 0) }}">
                            <div class="card-body bg-label-danger">
                                <div class="avatar flex-shrink-0 " style="margin: 0px auto">
                                    <img src="{{ asset('public/dashboard/student.jpg') }}" alt="cube" class="rounded">
                                </div>
                                <p class="icon-name text-capitalize text-truncate mb-0">Profile</p>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="card icon-card card-border-shadow-primary cursor-pointer text-center">
                        <a href="{{ route('getidcardd') }}" target="_blank">
                            <div class="card-body bg-label-info">
                                <div class="avatar flex-shrink-0 " style="margin: 0px auto">
                                    <img src="{{ asset('public/dashboard/student.jpg') }}" alt="form" class="rounded">
                                </div>
                                <p class="icon-name text-capitalize text-truncate mb-0">Print
                                    Temporary ID Card</p>
                            </div>
                        </a>
                    </div>
                </div>



            </div>
        </div>
        <!-- / Content -->
        <div class="content-backdrop fade"></div>
    </div>
    <div class="modal fade" id="modalCenter" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <img class="demo-bg" src="{{ asset('public/congratulation.png') }}" alt="">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="text-align: center">
                    <p style="font-size:25px;margin-bottom: .1rem;color: #ee00bb">Congratulations!
                    <p><br>
                        {{-- Your Admission Process is completed in BAF Shaheen College Dhaka. --}}
                        Your Admission Process is completed.
                        {{-- No need to come at school physically.
                        You will get a Payment ID via SMS in January,2025 & have to complete your payment. --}}
                </div>
            </div>
        </div>
    </div>
    <script>
        @if (Session::get('success'))
            $(document).ready(function() {
                // Trigger the modal
                $('#modalCenter').modal('show');
            });
            // Swal.fire({
            //    title: "Good job!",
            //    text: "{{ Session::get('success') }}",
            //    icon: "success"
            // });
        @endif
        @if (Session::get('warning'))

            Swal.fire({
                title: "warning!",
                text: "{{ Session::get('warning') }}",
                icon: "warning"
            });
        @endif
    </script>
@endsection
