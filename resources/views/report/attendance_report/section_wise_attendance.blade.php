@if ($counts)
    <table class="table table-hover table-bordered rounded-lg mt-2 mb-2 statistics">
        <thead class="table-light" style="position: sticky; top: 0; z-index: 1000;">
            <tr>
                {{-- <th style="width: 20%;text-align:center; color:rgb(133, 134, 133);font-weight:bold;">Total</th> --}}
                <th style="width: 20%;text-align:center; color:rgb(31, 212, 40);font-weight:bold;">Present</th>
                <th style="width: 20%;text-align:center;color:rgb(191, 5, 5);font-weight:bold;">Absent</th>
                <th style="width: 12%;text-align:center;color:  rgb(211, 226, 6);font-weight:bold;">Late</th>
                <th style="width: 13%;text-align:center;color:rgb(11, 177, 228);font-weight:bold;">Leave</th>
                <th style="width: 13%;text-align:center;color: rgb(19, 78, 187);font-weight:bold;">Missing</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            <tr>
                <td style="text-align:center;font-weight:bold;">
                    {{ $counts['present'] }}
                </td>
                <td style="text-align:center;font-weight:bold;">
                    {{ $counts['absent'] }}
                </td>
                <td style="text-align:center;font-weight:bold;">
                    {{ $counts['late'] }}
                </td>
                <td style="text-align:center;font-weight:bold;">
                    {{ $counts['leave'] }}
                </td>
                <td style="text-align:center;font-weight:bold;">
                    {{ $counts['missing'] }}
                </td>
            </tr>
        </tbody>
    </table>
@endif

@if ($students->isEmpty())
    <p class="text-center alert alert-warning mt-5">No records of absence or late</p>
@else
    <table class="table table-hover rounded-lg main">
        <thead class="table-dark" style="position: sticky; top: 0; z-index: 1000;">
            <tr>
                <th style="width: 5%">SL.</th>
                <th style="width: 25%;text-align:center;">Date</th>
                <th style="width: 10%;text-align:center;">Roll</th>
                <th style="width: 20%;word-wrap: break-word;text-align:center;">Student Name</th>
                <th style="width: 20%;text-align:center;">Father Name</th>
                <th style="width: 20%;text-align:center;">SMS Notification</th>
                <th style="width: 12%;text-align:center;">Class</th>
                <th style="width: 13%;text-align:center;">Section</th>
                <th style="width: 10%;"> Status</th>
                <th style="width: 10%">Time</th>
            </tr>
        </thead>

        <tbody class="table-border-bottom-0">
            @foreach ($students as $student)
                <tr>
                    <td style="word-wrap: break-word;text-align:center;">
                        {{ $loop->iteration }}
                    </td>

                    <td style="text-align:left;">
                        {{ \Carbon\Carbon::parse($student->attendance_date)->format('d-m-Y') }}
                    </td>
                    <td style="text-align:center;">{{ $student->roll }}</td>
                    <td style="word-wrap: break-word;text-align:left;">
                        {{ $student->first_name . ' ' . $student->last_name }}
                    </td>
                    <td style="text-align:center;">
                        {{ $student->father_name }}
                    </td>
                    <td style="text-align:center;">
                        {{ $student->sms_notification }}
                    </td>
                    <td style="text-align:center;">
                        {{ $student->class_name }}
                    </td>
                    <td style="text-align:center;">
                        {{ $student->section_name }}
                    </td>
                    <td>
                        @if (isset($student->attendance_status) && $student->attendance_status == 'present')
                            <label
                                class="form-check-label {{ $student->attendance_status == 'present' ? 'present' : '' }}"
                                for="attendance[{{ $student }}1">Present</label>
                        @elseif (isset($student->attendance_status) && $student->attendance_status == 'late')
                            <label
                                class="form-check-label {{ isset($student->attendance_status) && $student->attendance_status == 'late' ? 'late' : '' }}"
                                for="attendance[{{ $student }}4">Late</label>
                        @elseif (isset($student->attendance_status) && $student->attendance_status == 'absent')
                            <label
                                class="form-check-label {{ isset($student->attendance_status) && $student->attendance_status == 'absent' ? 'absent' : '' }}"
                                for="attendance[{{ $student }}2">Absent</label>
                        @elseif (isset($student->attendance_status) && $student->attendance_status == 'leave')
                            <label
                                class="form-check-label {{ isset($student->attendance_status) && $student->attendance_status == 'leave' ? 'leave' : '' }}"
                                for="attendance[{{ $student }}2">Leave</label>
                        @elseif (isset($student->attendance_status) && $student->attendance_status == 'missing')
                            <label
                                class="form-check-label {{ isset($student->attendance_status) && $student->attendance_status == 'missing' ? 'missing' : '' }}"
                                for="attendance[{{ $student }}5">Missing</label>
                        @else
                            <label class="form-check-label"></label>
                        @endif
                    </td>
                    <td>
                        {{ isset($student->time) && $student->time != null ? $student->time : '' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
@endif
