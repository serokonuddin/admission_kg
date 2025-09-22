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
                    <li class="breadcrumb-item active" aria-current="page">Generate Transfer Certificate </li>
                </ol>
            </nav>
            <!-- Basic Bootstrap Table -->
            <div>
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        {{-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> --}}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        {{-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> --}}
                    </div>
                @endif
                <div class="container">
                    <h2 class="text-center mb-4">Generate Transfer Certificate</h2>
                    <form action="#" method="POST" class="row g-3 mt-2">

                        <!-- Student ID Input -->
                        <div class="col-md-8 d-flex align-items-center">
                            {{-- <label for="student_code" class="form-label fw-bold me-3 mb-0">Student ID:</label> --}}
                            <input type="text" id="student_code" name="student_code" class="form-control"
                                placeholder="Enter Student ID" required>
                        </div>
                        <!-- Month Selection -->
                        <div class="col-md-4 d-flex align-items-center">
                            <select id="selected_month" name="selected_month" class="form-control" required>
                                <option value="" disabled>Select Month</option>
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ $m == date('n') ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                    </option>
                                @endfor
                            </select>
                        </div>


                        <!-- Buttons -->
                        <div class="col-md-4 d-flex align-items-center justify-content-end">
                            <button type="button" id="searchtop" class="btn btn-primary me-2">Search</button>
                            <button type="button" class="btn btn-warning"
                                onclick="openConfirmationModal()">Generate</button>
                        </div>
                    </form>
                </div>
                <div class="table-responsive text-nowrap" id="tabledata"></div>
            </div>
        </div>
    </div>

    <!-- Modal Structure -->
    <div id="confirmationModal">
        <div class="modal-content">
            <form id="certificateForm" action="{{ route('generateCertificate') }}" method="POST">
                <p id="confirmationText"></p>
                @csrf
                <input type="hidden" id="student_code_g" name="student_code" class="form-control">
                <div class="form-group">
                    <label for="reason_for_tc" style="font-size: 20px; font-weight: bold;">Reason for TC:</label>
                    <input type="text" id="reason_for_tc" name="reason_for_tc" class="form-control" required>
                </div>
                <br>
                <button type="button" class="btn btn-primary" onclick="submitForm()">Confirm</button>
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
            </form>
        </div>
    </div>


    <!-- CSS for Beautiful Design -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 800px;
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
        // document.getElementById('certificateForm').addEventListener('keydown', function(event) {
        //     //if (event.key === 'Enter') {
        //         event.preventDefault();
        //     //}
        // });

        $(document).ready(function() {
            $('#certificateForm').on('submit', function(event) {
                closeModal();
            });
        });

        function openConfirmationModal() {
            const studentCode = document.getElementById('student_code').value;

            if (!studentCode) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Missing Input',
                    text: 'Please enter a Student ID.',
                });
                return;
            }
            $('#student_code_g').val(studentCode);
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
            var formData = $('#certificateForm').serialize(); // Serialize form data to send it

            // Send the form data using AJAX
            $.ajax({
                url: "{{ route('generateCertificate') }}", // URL to submit the form data to
                method: 'POST',
                data: formData,
                success: function(response) {
                    console.log(response);
                    closeModal();
                    $('#tabledata').html(response);
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Certificate',
                        text: error,
                    });
                    closeModal();
                    return 1;
                }
            });
            // const form = document.getElementById('certificateForm');
            // const reasonInput = document.createElement('input');
            // reasonInput.type = 'hidden';
            // reasonInput.name = 'reason_for_tc';
            // reasonInput.value = reasonForTC;
            // form.appendChild(reasonInput);
            // $.ajax({
            //     url: '{{ route('generateCertificate') }}', // URL to submit the form data to
            //     method: 'POST',
            //     data: form,
            //     success: function(response) {
            //         alert('Form successfully submitted: ' + response);
            //     },
            //     error: function(xhr, status, error) {
            //         alert('Error submitting form: ' + error);
            //     }
            // });
            //form.submit();

        }

        // function previewPDF() {
        //     const studentCode = document.getElementById('student_code').value;

        //     if (!studentCode) {
        //         alert("Please enter a Student ID.");
        //         return;
        //     }

        //     // Open the preview route in a new tab
        //     const previewUrl = `{{ route('previewCertificate') }}?student_code=${studentCode}`;
        //     window.open(previewUrl, '_blank');
        // }
        function previewPDF() {
            const studentCode = document.getElementById('student_code').value;

            if (!studentCode) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Missing Input',
                    text: 'Please enter a Student ID.',
                });
                return;
            }

            // Call the backend API to validate the student and open the preview
            fetch(`{{ route('previewCertificate') }}?student_code=${studentCode}`, {
                    method: 'GET'
                })
                .then((response) => {
                    if (!response.ok) {
                        return response.json().then((data) => {
                            throw new Error(data.error || "An unexpected error occurred.");
                        });
                    }

                    // If the response is okay, open the PDF preview
                    window.open(`{{ route('previewCertificate') }}?student_code=${studentCode}`, '_blank');
                })
                .catch((error) => {
                    // Show SweetAlert2 for error messages
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message,
                    });
                });
        }
    </script>

    <script>
        $(document.body).on('click', '#searchtop', function() {
            var student_code = $('#student_code').val();
            var selected_month = $('#selected_month').val();

            // Validate input
            if (!selected_month) {
                Swal.fire({
                    title: "Error",
                    text: "Please select a month.",
                    icon: "warning"
                });
                return;
            }

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
                url: "{{ route('previewCertificate') }}", // Replace this with the actual route to fetch details
                data: {
                    "_token": "{{ csrf_token() }}",
                    student_code: student_code,
                    selected_month: selected_month
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
