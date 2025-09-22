@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Testimonial </li>
                </ol>
            </nav>
            <div>
                <div class="box">
                    <h2 class="text-center mb-4">Generate Testimonial</h2>
                    <form id="certificateForm" class="row g-3 mt-2">
                        <div class="col-md-8 d-flex align-items-center">
                            <input type="text" id="student_code" name="student_code" class="form-control"
                                placeholder="Enter Student ID" required>
                        </div>
                        <div class="col-md-4 d-flex align-items-center">
                            <button type="button" id="searchtop" class="btn btn-primary me-2">Search</button>
                        </div>
                    </form>
                </div>
                <!-- Testimonial Type Selection -->
                <div id="testimonialTypeContainer" class="mt-3" style="display: none;">
                    <h5>Select Testimonial Type:</h5>
                    <div id="testimonialTypeOptions"></div>
                </div>
                <div id="testimonialInputFieldContainer" class="mt-3" style="display: none;">
                    <div id="testimonialInputField"></div>
                </div>
            </div>
            <div class="table-responsive text-nowrap" id="tabledata"></div>
        </div>
    </div>

    <script>
        function fetchTestimonialData() {
            var student_code = $('#student_code').val();
            var testimonial_type = $('input[name="testimonial_type"]:checked').val() || "current"; // Default to 'current'

            if (!student_code) {
                Swal.fire({
                    title: "Error",
                    text: "Please enter a Student ID.",
                    icon: "warning"
                });
                return;
            }

            $.LoadingOverlay("show");

            $.ajax({
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('previewTestimonial') }}",
                data: {
                    student_code: student_code,
                    testimonial_type: testimonial_type
                },
                success: function(response) {
                    $('#tabledata').html(response.html);
                    $.LoadingOverlay("hide");

                    let selectedTestimonialType = response.testimonialType || "current";
                    let class_number = response.class_number;

                    // Testimonial Type Options
                    let testimonialTypes = [{
                            value: "current",
                            label: "Current Student"
                        },
                        {
                            value: "gazette",
                            label: "Gazette Exam"
                        },
                        {
                            value: "appeared",
                            label: "Appeared Exam"
                        },
                        {
                            value: "said",
                            label: "Said Exam"
                        },
                        {
                            value: "passed",
                            label: "Passed Exam"
                        }
                    ];

                    if (class_number <= 10) {
                        testimonialTypes.splice(2, 0, {
                            value: "cadet",
                            label: "Cadet Exam"
                        });
                    }

                    let optionsHtml = "";
                    testimonialTypes.forEach(type => {
                        let checked = (type.value === selectedTestimonialType) ? "checked" : "";
                        optionsHtml += `<div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="testimonial_type" id="testimonial_${type.value}" value="${type.value}" ${checked}>
                            <label class="form-check-label" for="testimonial_${type.value}">${type.label}</label>
                        </div>`;
                    });

                    $("#testimonialTypeOptions").html(optionsHtml);
                    $("#testimonialTypeContainer").show();

                    let inputField = "";
                    if (selectedTestimonialType === "gazette") {
                        inputField = `<div class="row g-3">
                            <div class="col-md-3">
                                <label for="roll_number" class="form-label">Roll Number</label>
                                <input type="text" id="roll_number" name="roll_number" class="form-control" value="${response.roll_number}">
                            </div>
                            <div class="col-md-3">
                                <label for="registration_number" class="form-label">Registration Number</label>
                                <input type="text" id="registration_number" name="registration_number" class="form-control" value="${response.registration_number}">
                            </div>
                            <div class="col-md-3">
                                <label for="gpa" class="form-label">GPA</label>
                                <input type="text" id="gpa" name="gpa" class="form-control" value="${response.gpa}">
                                </div>
                                <div class="col-md-3">
                                <label for="exam_year" class="form-label">Exam Year</label>
                                <input type="text" id="exam_year" name="exam_year" class="form-control" value="${response.exam_year}">
                                </div> `;
                    }
                    if (selectedTestimonialType === "appeared") {
                        inputField = `<div class="row g-3">
                            <div class="col-md-4">
                                <label for="roll_number" class="form-label">Roll Number</label>
                                <input type="text" id="roll_number" name="roll_number" class="form-control" value="${response.roll_number}">
                            </div>
                            <div class="col-md-4">
                                <label for="registration_number" class="form-label">Registration Number</label>
                                <input type="text" id="registration_number" name="registration_number" class="form-control" value="${response.registration_number}">
                            </div>
                            <div class="col-md-4">
                                <label for="exam_year" class="form-label">Exam Year</label>
                                <input type="text" id="exam_year" name="exam_year" class="form-control" value="${response.exam_year}">
                                </div>`;
                    }
                    if (selectedTestimonialType === "said") {
                        inputField = `<div class="row g-3">
                            <div class="col-md-4">
                                <label for="registration_number" class="form-label">Registration Number</label>
                                <input type="text" id="registration_number" name="registration_number" class="form-control" value="${response.registration_number}">
                            </div>
                            <div class="col-md-4">
                                <label for="gpa" class="form-label">GPA</label>
                                <input type="text" id="gpa" name="gpa" class="form-control" value="${response.gpa}">
                                </div>
                               <div class="col-md-4">
                                <label for="exam_year" class="form-label">Exam Year</label>
                                <input type="text" id="exam_year" name="exam_year" class="form-control" value="${response.exam_year}">
                                </div> `;
                    }
                    if (selectedTestimonialType === "passed") {
                        inputField = `<div class="row g-3">
                            <div class="col-md-6">
                                <label for="session" class="form-label">Session</label>
                                <input type="text" id="session" name="session" class="form-control" value="${response.session}">
                            </div>
                            <div class="col-md-6">
                                <label for="class_number" class="form-label">Class</label>
                                <input type="text" id="class_number" name="class_number" class="form-control" value="${response.class_number}">
                            </div>`;
                    }

                    $("#testimonialInputField").html(inputField);
                    $("#testimonialInputFieldContainer").show();
                },
                error: function(xhr, errorThrown) {
                    Swal.fire({
                        title: "Error",
                        text: errorThrown,
                        icon: "warning"
                    });
                    $.LoadingOverlay("hide");
                }
            });
        }

        $(document.body).on('click', '#searchtop', function() {
            fetchTestimonialData();
        });

        $(document.body).on('change', 'input[name="testimonial_type"]', function() {
            fetchTestimonialData();
        });
    </script>
    <script>
        $(document).on('input', '#roll_number, #registration_number, #gpa, #session, #class_number, #exam_year',
            function() {
                updateTestimonialPreview();
            });

        function updateTestimonialPreview() {
            var student_code = $('#student_code').val();
            var testimonial_type = $('input[name="testimonial_type"]:checked').val();
            var roll_number = $('#roll_number').val();
            var registration_number = $('#registration_number').val();
            var gpa = $('#gpa').val();
            var session = $('#session').val();
            var class_number = $('#class_number').val();
            var exam_year = $('#exam_year').val();

            if (!student_code) {
                Swal.fire({
                    title: "Error",
                    text: "Please enter a Student ID.",
                    icon: "warning"
                });
                return;
            }

            $.LoadingOverlay("show");

            $.ajax({
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('previewTestimonial') }}",
                data: {
                    student_code: student_code,
                    testimonial_type: testimonial_type,
                    roll_number: roll_number,
                    registration_number: registration_number,
                    gpa: gpa,
                    session: session,
                    class_number: class_number,
                    exam_year: exam_year
                },
                success: function(response) {
                    $('#tabledata').html(response.html);
                    $.LoadingOverlay("hide");
                },
                error: function(xhr, errorThrown) {
                    Swal.fire({
                        title: "Error",
                        text: errorThrown,
                        icon: "warning"
                    });
                    $.LoadingOverlay("hide");
                }
            });
        }
    </script>
@endsection
