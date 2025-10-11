@if ($attendance_details->isEmpty())
    <p class="text-center alert alert-warning mt-5">No records of student attendance</p>
@else
    {{-- Attendance Table --}}
    <table class="table table-bordered table-hover align-middle text-center mb-0 bg-white">
        <thead class="table-dark" style="position: sticky; top: 0; z-index: 1020;">
            <tr>
                <th colspan="3" class="text-center">
                    Total Working Days: <span class="fw-bold">{{ $total_days }}</span>
                </th>
                <th colspan="4" class="text-center">
                    Sections Working Days: <span class="fw-bold">{{ $total_days_section }}</span>
                </th>
            </tr>
            <tr>
                <th style="width: 5%">SL.</th>
                <th style="width: 10%">Roll</th>
                <th style="width: 25%; text-align: left">Student Name</th>
                <th style="width: 15%">Total Days</th>
                <th style="width: 15%">Present (%)</th>
                <th style="width: 15%">Absent (%)</th>
                <th style="width: 15%">Leave (%)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attendance_details as $student)
                @php
                    $final_absent = $student->total_absent - $student->re_absent + $student->re_final_absent;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $student->roll }}</td>
                    <td class="text-start">{{ strtoupper($student->first_name) }}</td>
                    <td>{{ $student->total_records }} </td>
                    <td class="text-success fw-bold">
                        {{ $student->total_present }}
                        <hr>
                        {{ number_format(($student->total_present / $total_days) * 100, 2) }}%
                    </td>
                    <td class="text-danger fw-bold">
                        {{ $final_absent }}
                        <hr>
                        {{ number_format(($final_absent / $total_days) * 100, 2) }}%
                    </td>
                    <td class="text-info fw-bold">
                        {{ $student->total_leave + ($student->total_absent - $final_absent) }}
                        <hr>
                        {{ number_format((($student->total_leave + ($student->total_absent - $final_absent)) / $total_days) * 100, 2) }}%
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
@endif
