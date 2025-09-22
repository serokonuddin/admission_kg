@extends('admin.layouts.layout')
@section('content')
    <style>
        th {
            text-align: center;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"> College Statistics</li>
                </ol>
            </nav>
            <div class="row mb-2 g-4">
                <div class="col-12 col-xl-12">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0 me-2">Admission Summary</h5>
                            <!-- Print Button -->
                            @if (Auth::user()->is_view_user == 0)
								<button class="btn btn-primary" onclick="printTable()">Print</button>
							@endif
                        </div>
                        @php
                            $version = [1 => 'Bangla', 2 => 'English'];
                            $group = [1 => 'Science', 2 => 'Humanities', 3 => 'Business Studies'];
                            $colors = [
                                0 => 'primary',
                                1 => 'success',
                                2 => 'danger',
                                3 => 'warning',
                                4 => 'info',
                                5 => 'dark',
                                6 => 'secondary',
                                7 => 'primary',
                                8 => 'success',
                                9 => 'danger',
                                10 => 'warning',
                                11 => 'info',
                                12 => 'dark',
                                13 => 'secondary',
                            ];
                        @endphp
                        <div class="card-body row g-3">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-bordered" id="admission-summary-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th rowspan="2">Group</th>
                                            <th rowspan="2">Version</th>
                                            <th rowspan="2">Section</th>
                                            <th colspan="3">Total Seat</th>
                                            <th colspan="3">Admitted</th>
                                            <th rowspan="2">Vacant</th>
                                        </tr>
                                        <tr>
                                            <th>Total</th>
                                            <th>Male</th>
                                            <th>Female</th>
                                            <th>Total</th>
                                            <th>Male</th>
                                            <th>Female</th>
                                        </tr>
                                    </thead>
                                    @php
                                        $t1 = 0;
                                        $t2 = 0;
                                        $t3 = 0;
                                        $t4 = 0;
                                        $t5 = 0;
                                        $t6 = 0;
                                        $t7 = 0;
                                    @endphp
                                    @foreach ($sectordata as $key => $section)
                                        <tr>
                                            <td rowspan="{{ $section->rowdata }}">{{ $group[$section->group_id] }}</td>
                                            <td rowspan="{{ $section->rowdata }}">{{ $version[$section->version_id] }}</td>
                                            <td>{{ $section->data[0]->section_name ?? '' }}</td>
                                            <td>
                                                @php
                                                    $t1 += $section->data[0]->student_number ?? 0;
                                                @endphp
                                                {{ $section->data[0]->student_number ?? '' }}
                                            </td>
                                            <td>
                                                @php
                                                    $t2 += $section->data[0]->male ?? 0;
                                                @endphp
                                                {{ $section->data[0]->male ?? '' }}
                                            </td>
                                            <td>
                                                @php
                                                    $t3 += $section->data[0]->female ?? 0;
                                                @endphp
                                                {{ $section->data[0]->female ?? '' }}
                                            </td>
                                            <td>{{ $section->data[0]->total_count ?? '' }}
                                                @php
                                                    $t4 += $section->data[0]->total_count ?? 0;
                                                @endphp
                                                @if (isset($section->data[0]->section_name) &&
                                                        isset($section->data[0]->total_count) &&
                                                        $section->data[0]->total_count > 0)
                                                    <br>
                                                    {{-- @if (Auth::user()->group_id == 2)
                                                        <a href="{{ url('admin/admissionXl/' . $section->data[0]->class_id . '/' . $section->data[0]->id) }}"
                                                            target="_blank"><i class='fas fa-file-excel'></i></a>
                                                    @endif --}}
                                                @endif
                                            </td>
                                            <td>{{ $section->data[0]->male_count ?? '' }}
                                                @php
                                                    $t5 += $section->data[0]->male_count ?? 0;
                                                @endphp
                                                @if (isset($section->data[0]->section_name) && isset($section->data[0]->male_count) && $section->data[0]->male_count > 0)
                                                    <br>
                                                    {{-- @if (Auth::user()->group_id == 2)
                                                        <a href="{{ url('admin/admissionXlMale/' . $section->data[0]->class_id . '/' . $section->data[0]->id) }}"
                                                            target="_blank"><i class='fas fa-file-excel'></i></a>
                                                    @endif --}}
                                                @endif
                                            </td>
                                            <td>
                                                {{ $section->data[0]->female_count ?? '' }}
                                                @php
                                                    $t6 += $section->data[0]->female_count ?? 0;
                                                @endphp
                                                @if (isset($section->data[0]->section_name) &&
                                                        isset($section->data[0]->female_count) &&
                                                        $section->data[0]->female_count > 0)
                                                    <br>
                                                    {{-- @if (Auth::user()->group_id == 2)
                                                        <a href="{{ url('admin/admissionXlFemale/' . $section->data[0]->class_id . '/' . $section->data[0]->id) }}"
                                                            target="_blank"><i class='fas fa-file-excel'></i></a>
                                                    @endif --}}
                                                @endif
                                            </td>
                                            <td>
                                                {{ ($section->data[0]->student_number ?? 0) - ($section->data[0]->total_count ?? 0) }}
                                                @php
                                                    $t7 +=
                                                        ($section->data[0]->student_number ?? 0) -
                                                        ($section->data[0]->total_count ?? 0);
                                                @endphp
                                            </td>
                                        </tr>
                                        @foreach ($section->data as $k => $secti)
                                            @if ($k != 0)
                                                <tr>
                                                    <td>{{ $secti->section_name ?? '' }}</td>
                                                    <td>
                                                        @php
                                                            $t1 += $secti->student_number ?? 0;
                                                        @endphp
                                                        {{ $secti->student_number ?? '' }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $t2 += $secti->male ?? 0;
                                                        @endphp
                                                        {{ $secti->male ?? '' }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $t3 += $secti->female ?? 0;
                                                        @endphp
                                                        {{ $secti->female ?? '' }}
                                                    </td>

                                                    <td>{{ $secti->total_count ?? '' }}
                                                        @php
                                                            $t4 += $secti->total_count ?? 0;
                                                        @endphp
                                                        @if (isset($secti->section_name) && isset($secti->total_count) && $secti->total_count > 0)
                                                            <br>
                                                            {{-- @if (Auth::user()->group_id == 2)
                                                                <a href="{{ url('admin/admissionXl/' . $secti->class_id . '/' . $secti->id) }}"
                                                                    target="_blank"><i class='fas fa-file-excel'></i></a>
                                                            @endif --}}
                                                        @endif
                                                    </td>
                                                    <td>{{ $secti->male_count ?? '' }}
                                                        @php
                                                            $t5 += $secti->male_count ?? 0;
                                                        @endphp
                                                        @if (isset($secti->section_name) && isset($secti->male_count) && $secti->male_count > 0)
                                                            <br>
                                                            {{-- @if (Auth::user()->group_id == 2)
                                                                <a href="{{ url('admin/admissionXlMale/' . $secti->class_id . '/' . $secti->id) }}"
                                                                    target="_blank"><i class='fas fa-file-excel'></i></a>
                                                            @endif --}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $secti->female_count ?? '' }}
                                                        @php
                                                            $t6 += $secti->female_count ?? 0;
                                                        @endphp
                                                        @if (isset($secti->section_name) && isset($secti->female_count) && $secti->female_count > 0)
                                                            <br>
                                                            {{-- @if (Auth::user()->group_id == 2)
                                                                <a href="{{ url('admin/admissionXlFemale/' . $secti->class_id . '/' . $secti->id) }}"
                                                                    target="_blank"><i class='fas fa-file-excel'></i></a>
                                                            @endif --}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @php
                                                            $t7 +=
                                                                ($secti->student_number ?? 0) -
                                                                ($secti->total_count ?? 0);
                                                        @endphp
                                                        {{ ($secti->student_number ?? 0) - ($secti->total_count ?? 0) }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endforeach
                                    <tr>
                                        <td colspan="3" style="text-align: center;font-size:18px;font-weight: bold">
                                            Total
                                        </td>
                                        <td>{{ $t1 }}</td>
                                        <td>{{ $t2 }}</td>
                                        <td>{{ $t3 }}</td>
                                        <td>{{ $t4 }}<br />
                                            {{-- @if ($t4 > 0 && Auth::user()->group_id == 2)
                                                <a href="{{ url('admin/admissionXlTotal/59') }}" target="_blank"><i
                                                        class='fas fa-file-excel'></i></a>
                                            @endif --}}
                                        </td>
                                        <td>{{ $t5 }}<br />
                                            {{-- @if ($t5 > 0 && Auth::user()->group_id == 2)
                                                <a href="{{ url('admin/admissionXlTotalMale/59') }}" target="_blank"><i
                                                        class='fas fa-file-excel'></i></a>
                                            @endif --}}
                                        </td>
                                        <td>{{ $t6 }}<br />
                                            {{-- @if ($t6 > 0 && Auth::user()->group_id == 2)
                                                <a href="{{ url('admin/admissionXlTotalFemale/59') }}" target="_blank"><i
                                                        class='fas fa-file-excel'></i></a>
                                            @endif --}}
                                        </td>
                                        <td>{{ $t7 }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <!-- Order Statistics -->

                <!--/ Order Statistics -->
                <!-- Expense Overview -->

                <!--/ Expense Overview -->
                <!-- Transactions -->


                <!--/ Transactions -->
            </div>
        </div>
        <!-- / Content -->
        <div class="content-backdrop fade"></div>
    </div>
    <script>
        function printTable() {
            var printContents = document.getElementById('admission-summary-table').outerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
@endsection
