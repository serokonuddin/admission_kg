@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Testimonial </li>
                </ol>
            </nav>
            <!-- Basic Bootstrap Table -->
            <div>
                <div class="box">
                    <h2 class="text-center mb-4">Generate Testimonial</h2>
                    <form id="certificateForm" action="{{ route('generateCertificate') }}" method="POST" target="_blank"
                        class="row g-3 mt-2">
                        @csrf
                        <!-- Student ID Input -->
                        <div class="col-md-8 d-flex align-items-center">
                            <input type="text" id="student_code" name="student_code" class="form-control"
                                placeholder="Enter Student ID" required>
                        </div>
                        <!-- Buttons -->
                        <div class="col-md-4 d-flex align-items-center">
                            <button type="button" id="searchtop" class="btn btn-primary me-2">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive text-nowrap" id="tabledata"></div>
        </div>
    </div>

    <!-- CSS for Beautiful Design -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .box {
            /* max-width: 800px; */
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #007bff;
        }

        .form-label {
            font-size: 1rem;
            color: #495057;
        }

        .form-control {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 10px;
        }

        .btn {
            font-size: 0.9rem;
            padding: 10px 20px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .btn-outline-primary {
            color: #007bff;
            border-color: #007bff;
        }

        .btn-outline-primary:hover {
            background-color: #007bff;
            color: #ffffff;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        /* Modal Styling */
        #confirmationModal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            visibility: hidden;
        }

        #confirmationModal.show {
            visibility: visible;
        }

        .modal-content {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .modal-content label {
            font-size: 1rem;
        }
    </style>


    <script>
        // Prevent form submission on Enter keypress
        document.getElementById('certificateForm').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
            }
        });

        function openConfirmationModal() {
            const studentCode = document.getElementById('student_code').value;
            if (!studentCode) {
                alert("Please enter a Student ID.");
                return;
            }
            const confirmationText = `Are you sure to generate TC of Student ID ${studentCode}?`;
            document.getElementById('confirmationText').innerText = confirmationText;

            // Show the modal
            const modal = document.getElementById('confirmationModal');
            modal.classList.add('show');
        }

        function closeModal() {
            const modal = document.getElementById('confirmationModal');
            modal.classList.remove('show');
        }

        function submitForm() {
            const reasonForTC = document.getElementById('reason_for_tc').value;
            if (!reasonForTC) {
                alert("Please provide a reason for TC.");
                return;
            }

            const form = document.getElementById('certificateForm');
            const reasonInput = document.createElement('input');
            reasonInput.type = 'hidden';
            reasonInput.name = 'reason_for_tc';
            reasonInput.value = reasonForTC;
            form.appendChild(reasonInput);

            form.submit();
            closeModal();
        }
    </script>
    {{-- <script>
        function previewPDF() {
            const studentCode = document.getElementById('student_code').value;

            if (!studentCode) {
                alert("Please enter a Student ID.");
                return;
            }

            // Open the preview route in a new tab
            const previewUrl = `{{ route('previewTestimonial') }}?student_code=${studentCode}`;
            window.open(previewUrl, '_blank');
        }
    </script> --}}
    <script>
        $(document.body).on('click', '#searchtop', function() {
            var student_code = $('#student_code').val();

            if (!student_code) {
                Swal.fire({
                    title: "Error",
                    text: "Please enter a Student ID.",
                    icon: "warning"
                });
                return;
            }

            // Show loader
            $.LoadingOverlay("show");

            $.ajax({
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('previewTestimonial') }}", // Replace this with the actual route to fetch details
                data: {
                    "_token": "{{ csrf_token() }}",
                    student_code: student_code
                },
                success: function(response) {
                    // Update table data
                    $('#tabledata').html(response);

                    // Hide loader
                    $.LoadingOverlay("hide");
                },
                error: function(xhr, errorThrown) {
                    Swal.fire({
                        title: "Error",
                        text: errorThrown,
                        icon: "warning"
                    });

                    // Hide loader
                    $.LoadingOverlay("hide");
                }
            });
        });
    </script>
@endsection
