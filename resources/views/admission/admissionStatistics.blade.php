@extends('admin.layouts.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Admission Statistics</h4>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Admission Statistics</h5>
                            <div>
                                <button class="btn btn-primary" onclick="printStatistics()">
                                    <i class="bx bx-printer me-1"></i> Print Report
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Summary Cards -->
                            <div class="row mb-4">
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h6 class="text-white">Total Admissions</h6>
                                                    <h4 class="text-white">{{ $admissionStatistics->sum('Total') }}</h4>
                                                </div>
                                                <div class="avatar">
                                                    <span class="avatar-initial rounded-circle bg-white bg-opacity-25">
                                                        <i class="bx bx-user text-black"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="card bg-info text-white">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h6 class="text-white">Total Categories</h6>
                                                    <h4 class="text-white">
                                                        {{ $admissionStatistics->unique('Category')->count() }}</h4>
                                                </div>
                                                <div class="avatar">
                                                    <span class="avatar-initial rounded-circle bg-white bg-opacity-25">
                                                        <i class="bx bx-category text-black"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="card bg-success text-white">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h6 class="text-white">Total Versions</h6>
                                                    <h4 class="text-white">
                                                        {{ $admissionStatistics->unique('Version')->count() }}</h4>
                                                </div>
                                                <div class="avatar">
                                                    <span class="avatar-initial rounded-circle bg-white bg-opacity-25">
                                                        <i class="bx bx-book text-black"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h6 class="text-white">Total Shifts</h6>
                                                    <h4 class="text-white">
                                                        {{ $admissionStatistics->unique('Shift')->count() }}</h4>
                                                </div>
                                                <div class="avatar">
                                                    <span class="avatar-initial rounded-circle bg-white bg-opacity-25">
                                                        <i class="bx bx-time text-black"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Statistics Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="statisticsTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>SL</th>
                                            <th>Version</th>
                                            <th>Shift</th>
                                            <th>Category</th>
                                            <th>Total Admissions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($admissionStatistics as $index => $stat)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $stat->Version }}</td>
                                                <td>{{ $stat->Shift }}</td>
                                                <td>{{ $stat->Category }}</td>
                                                <td class="text-center">
                                                    {{ $stat->Total }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No admission statistics found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    @if ($admissionStatistics->isNotEmpty())
                                        <tfoot>
                                            <tr class="table-secondary">
                                                <td colspan="4" class="text-end"><strong>Grand Total:</strong></td>
                                                <td class="text-center">
                                                    <strong>{{ $admissionStatistics->sum('Total') }}</strong>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #printSection,
            #printSection * {
                visibility: visible;
            }

            #printSection {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .no-print {
                display: none !important;
            }

            .card {
                border: none !important;
                box-shadow: none !important;
            }

            .table-bordered th,
            .table-bordered td {
                border: 1px solid #000 !important;
            }
        }
    </style>
    <script>
        function printStatistics() {
            // Create a new window for printing
            const printWindow = window.open('', '_blank');
            const table = document.getElementById('statisticsTable');

            // Get current date for report
            const currentDate = new Date().toLocaleDateString();

            // School logo URL
            var logoUrl =
                "{{ asset('public/frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png') }}";

            // Build print content
            const printContent = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Admission Statistics Report</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .header { margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
                .header h2 { margin: 0; color: #333; }
                .header p { margin: 5px 0; color: #666; }
                .tableCenter { width:100%; border: none; }
                .tableCenter td { border: none; vertical-align: middle; }
                .school-name { color:#0484BD; font-size:24px; font-weight:bold; margin-top: 0px; margin-bottom: 4px; white-space: nowrap; }
                .school-address { text-align:center; margin-top: 0px; margin-bottom: 0px; font-size:14px; }
                .report-title { color:red; margin-top: 5px; margin-bottom: 0px; font-size:20px; font-weight:bold; white-space: nowrap; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { border: 1px solid #000; padding: 8px; text-align: left; }
                th { background-color: #f8f9fa; font-weight: bold; }
                .total-row { background-color: #e9ecef; font-weight: bold; }
                .footer { margin-top: 30px; text-align: right; font-size: 12px; color: #666; }
                .badge { background-color: #007bff; color: white; padding: 4px 8px; border-radius: 10px; font-size: 12px; }
            </style>
        </head>
        <body>
            <div class="header">
                <table cellpadding="0" cellspacing="0" class="tableCenter">
                    <tbody>
                        <tr>
                            <td style="width:15%; text-align:center; border: none;">
                                <img src="${logoUrl}" style="width:100px;">
                            </td>
                            <td style="width:70%; text-align:center; padding:0px 20px 0px 20px; border: none;">
                                <h3 class="school-name">BAF Shaheen College Dhaka</h3>
                                <span class="school-address">Dhaka Cantonment, Dhaka-1206</span>
                                <h3 class="report-title">Admission Statistics Report</h3>
                            </td>
                            <td style="width:15%; text-align:center; border: none;"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Version</th>
                        <th>Shift</th>
                        <th>Category</th>
                        <th>Total Admissions</th>
                    </tr>
                </thead>
                <tbody>
                    ${Array.from(table.querySelectorAll('tbody tr')).map((row, index) => {
                        const cells = row.querySelectorAll('td');
                        return `
                                                                    <tr>
                                                                        <td>${index + 1}</td>
                                                                        <td>${cells[1]?.textContent || ''}</td>
                                                                        <td>${cells[2]?.textContent || ''}</td>
                                                                        <td>${cells[3]?.textContent || ''}</td>
                                                                        <td>${cells[4]?.textContent || ''}</td>
                                                                    </tr>
                                                                `;
                    }).join('')}
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td colspan="4" style="text-align: right;"><strong>Grand Total:</strong></td>
                        <td><strong>{{ $admissionStatistics->sum('Total') }}</strong></td>
                    </tr>
                </tfoot>
            </table>

            <div class="footer">
                <p>Generated on: ${currentDate}</p>
            </div>
        </body>
        </html>
    `;

            printWindow.document.write(printContent);
            printWindow.document.close();

            // Wait for content to load then print
            printWindow.onload = function() {
                printWindow.print();
                printWindow.onafterprint = function() {
                    printWindow.close();
                };
            };
        }

        // Alternative print function for better browser compatibility
        function printStatisticsAlternative() {
            window.print();
        }
    </script>
@endsection
