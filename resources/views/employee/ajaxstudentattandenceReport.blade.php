<div class="table-responsive">
    <table class="table table-hover table-bordered rounded-lg statistics">
        <thead class="table-light" style="position: sticky; top: 0; z-index: 1000;">
            <tr>
                <th style="width: 20%;text-align:center; color:rgb(31, 212, 40);font-weight:bold;">
                    Present</th>
                <th style="width: 20%;text-align:center;color:rgb(191, 5, 5);font-weight:bold;">
                    Absent</th>
                <th style="width: 12%;text-align:center;color:  rgb(211, 226, 6);font-weight:bold;">
                    Late</th>
                <th style="width: 13%;text-align:center;color:rgb(11, 177, 228);font-weight:bold;">
                    Leave</th>
                <th style="width: 13%;text-align:center;color: rgb(19, 78, 187);font-weight:bold;">
                    Missing</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            <tr>
                <td style="text-align:center;font-weight:bold;">
                    {{ $count['present'] }}
                </td>
                <td style="text-align:center;font-weight:bold;">
                    {{ $count['absent'] }}
                </td>
                <td style="text-align:center;font-weight:bold;">
                    {{ $count['late'] }}
                </td>
                <td style="text-align:center;font-weight:bold;">
                    {{ $count['leave'] }}
                </td>
                <td style="text-align:center;font-weight:bold;">
                    {{ $count['missing'] }}
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="table-responsive">
    <table class="table table-hover rounded-lg mt-2 mb-2 main">
        <thead class="table-dark" style="position: sticky; top: 0; z-index: 1000;">
            <tr>
                <th>SL.</th>
                <th style="width: 20%;word-wrap: break-word;">Student Name</th>
                <th style="width: 10%">Roll</th>
                <th style="width: 13%">Session</th>
                <th style="width: 12%">Version</th>
                <th style="width: 10%">Mobile</th>
                <th style="width: 12%">Father</th>
                <th style="width: 13%">Mother</th>
                <th style="width: 10%"> Status </th>
                <th style="width: 10%">Time</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @foreach ($students as $student)
                @php
                    if (isset($student->studentAttendance->status) && $student->studentAttendance->status == 1) {
                        $bg = 'bg-default';
                    } elseif (isset($student->studentAttendance->status) && $student->studentAttendance->status == 4) {
                        $bg = 'bg-warning text-white';
                    } elseif (isset($student->studentAttendance->status) && $student->studentAttendance->status == 2) {
                        $bg = 'bg-danger text-white';
                    } elseif (isset($student->studentAttendance->status) && $student->studentAttendance->status == 3) {
                        $bg = 'bg-success text-white';
                    } else {
                        $bg = 'bg-default';
                    }
                @endphp
                <tr class="{{ $bg }}">
                    <td>{{ $loop->index + 1 }}</td>
                    <td style="word-wrap: break-word;">
                        <img src="{{ $student->photo ?? asset('public/student.png') }}" alt="Avatar"
                            class="rounded-circle avatar avatar-xs">

                        {{ $student->first_name . ' ' . $student->last_name }}
                    </td>
                    <td>{{ $student->roll }}</td>
                    <td>
                        {{ $student->session_name ?? 'N/A' }}
                    </td>
                    <td>
                        {{ $student->version_name ?? 'N/A' }}
                    </td>
                    <td>
                        {{ $student->sms_notification ?? 'N/A' }}
                    </td>
                    <td>
                        {{ $student->father_name ?? 'N/A' }}
                        <br>
                        {{ $student->father_phone ?? 'N/A' }}
                    </td>
                    <td>
                        {{ $student->mother_name ?? 'N/A' }}
                        <br>
                        {{ $student->mother_phone ?? 'N/A' }}
                    </td>
                    <td>
                        @if (isset($student->studentAttendance->status) && $student->studentAttendance->status == 1)
                            Present
                        @elseif(isset($student->studentAttendance->status) && $student->studentAttendance->status == 4)
                            Late
                        @elseif(isset($student->studentAttendance->status) && $student->studentAttendance->status == 2)
                            Absent
                        @elseif(isset($student->studentAttendance->status) && $student->studentAttendance->status == 3)
                            Leave
                        @endif

                    </td>
                    <td style="word-wrap: break-word;">
                        {{ isset($student->studentAttendance->time) ? $student->studentAttendance->time : '' }}
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>
