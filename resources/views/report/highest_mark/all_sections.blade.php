@extends('admin.layouts.layout')
@section('content')
    <style>
        :root {
            --bs-breadcrumb-divider: ">";
        }

        .breadcrumb a {
            text-decoration: none;
            color: #007bff;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
            color: #0056b3;
        }

        .card {
            background-color: #f8f9fa;
        }

        .card-header {
            font-size: 1rem;
            padding: 20px !important;
        }

        .card-header span {
            font-size: 1rem;
            color: #03C3EC;
        }

        .section-item {
            background-color: #ffffff;
            border-radius: 10px;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .section-item:hover {
            background-color: #eaf4ff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

       .btn-class {
            background-color: #2ab0c7;
            color: white;
            border: none;
            display: block !important;
            border-radius: 8px;
            width: 40%;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-class:hover {
            background-color: #086c87;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
        }

        .btn-class:focus {
            outline: none;
            box-shadow: 0 0 0 4px rgba(10, 151, 176, 0.3);
        }

        .average-mark {
            font-size: 1.2rem;
            color: #343a40;
            font-weight: 500;
        }

        .average-mark strong {
            color: #28a745;
        }

        .average-mark .text-muted {
            color: #6c757d;
        }

        .uppercase-title {
            text-transform: uppercase;
            letter-spacing: 2px;
            padding: 5px;
        }
        .gradient-card {
            background: linear-gradient(45deg, #92d9e6, #007EA7);
            border: none;
            border-radius: 10px;
            padding: 1rem;
            color: white;
            font-size: 18px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

    </style>
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <nav aria-label="breadcrumb" class="my-4">
                <ol class="breadcrumb">
                    @foreach ($breadcrumbs as $breadcrumb)
                        @if ($breadcrumb['url'])
                            <li class="breadcrumb-item">
                                <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a>
                            </li>
                        @else
                            <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['name'] }}</li>
                        @endif
                    @endforeach
                </ol>
            </nav>

            <div class="col-md mb-4 mb-md-0">
                <div class="card shadow-sm">
                    <div class="card-body">
                         <div class="card-header gradient-card text-center d-flex flex-wrap justify-content-around">
                            <strong>Session:&nbsp;{{ $headerData['session_name'] }}</strong>
                            <strong>Version:&nbsp;{{ $headerData['version_name'] }}</strong>
                            <strong>Shift:&nbsp;{{ $headerData['shift_name'] }}</strong>
                            <strong>Class:&nbsp;{{ $headerData['class_name'] }}</strong>
                        </div>

                        @foreach ($sections as $section)
                            <div class="section-item mb-4 p-3 rounded-lg border border-light shadow-sm">
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-class mx-1 my-1"
                                            id="sectionId" value="{{ $section->id }}" name="sectionId">
                                            {{ $section->section_name }}
                                        </button>
                                    </div>
                                    <div class="col-md-6 d-flex align-items-center justify-content-center">
                                        <p class="average-mark mb-0">
                                            <span class="text-muted">Highest Mark:</span>
                                            <strong>{{ number_format($sectionMarks[$section->id], 2) }}</strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
        <div class="content-backdrop fade"></div>
    </div>

    <script>
        // Handle section click

        $(document.body).on('click', '[name="sectionId"]', function() {

            var sectionId = $(this).val();
            const queryString = window.location.search;

            // Parse the query string
            const urlParams = new URLSearchParams(queryString);

            // Get specific parameters
            const classCode = urlParams.get('class_code');
            const versionId = urlParams.get('version_id');
            const shiftId = urlParams.get('shift_id');
            const sessionId = urlParams.get('session_id');
            const examId = urlParams.get('exam_id');

            // Output or use the values

            console.log('Class Code:', classCode);
            console.log('Version ID:', versionId);
            console.log('Shift ID:', shiftId);
            console.log('sectionId:', sectionId);
            console.log('sessionId:', sessionId);
            console.log('examId:', examId);


            if (shiftId && versionId && classCode && sectionId && sessionId && examId) {
                console.log('Version ID: ' + versionId + ', Shift ID: ' + shiftId + ', Class Code: ' + classCode +
                    ', Session ID: ' + sessionId + ', Exam ID: ' + examId);

                var url = "{{ route('get.average.highest.mark.report') }}";
                $.LoadingOverlay("show");
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        class_code: classCode,
                        version_id: versionId,
                        shift_id: shiftId,
                        section_id: sectionId,
                        session_id: sessionId,
                        exam_id: examId,
                    },
                    success: function(response) {

                        if (response.redirect_url) {
                            window.location.href = response.redirect_url;
                        }

                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: "Error",
                            text: xhr?.responseJSON?.error || "An unexpected error occurred.",
                            icon: "warning"
                        });
                    },
                    complete: function() {
                        $.LoadingOverlay("hide");
                    }
                });
            }
        });
    </script>
@endsection
