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
            border: none;
            border-radius: 10px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            margin: 20px 10px;
        }

        .gradient-card {
            background: linear-gradient(45deg, #92d9e6, #007EA7);
            border: none;
            border-radius: 10px;
            padding: 1rem;
            color: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        /* Table Styling */
        .custom-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .custom-table thead th {
            background-color: #9aa0a2;
            color: white !important;
            text-align: center;
            padding: 12px;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        .custom-table tbody td {
            padding: 10px;
            text-align: center;
            font-size: 0.9rem;
            border: 1px solid #ddd;
            color: #333;
        }

        .custom-table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .custom-table tbody tr:hover {
            background-color: #e9f7fe;
            transition: background-color 0.3s ease;
        }

        /* Responsive Design */
        @media (max-width: 768px) {

            .custom-table thead th,
            .custom-table tbody td {
                font-size: 0.8rem;
                padding: 8px;
            }

            .card-title {
                font-size: 1.25rem;
            }
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
                <div class="card">
                    <div class="card-body mb-5 ">
                        <h5 class="card-title text-center font-weight-bold gradient-card">Highest Mark Report</h5>
                        <table class="table table-bordered custom-table">
                            <thead>
                                <tr>
                                    <th>Session</th>
                                    <th>Version</th>
                                    <th>Shift</th>
                                    <th>Class</th>
                                    <th>Section</th>
                                    {{-- <th>Class Teacher</th> --}}
                                    <th>Exam</th>
                                    <th>Subject Name</th>
                                    <th>Highest Obtained Mark</th>
                                </tr>
                            </thead>
                            <tbody id="subjectTableBody">
                                @foreach ($results as $key => $item)
                                    <tr>
                                        <td>{{ $item->session_name }}</td>
                                        <td>{{ $item->version_name }}</td>
                                        <td>{{ $item->shift_name }}</td>
                                        <td>{{ $item->class_name }}</td>
                                        <td>{{ $item->section_name }}</td>
                                        {{-- <td>{{ $item->class_teacher_name }}</td> --}}
                                        <td>{{ $item->exam_title }}</td>
                                        <td>{{ $item->subject_name }}</td>
                                        <td>{{ number_format($item->highest_mark, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-backdrop fade"></div>
    </div>

    <script></script>
@endsection
