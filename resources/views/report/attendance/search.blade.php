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
                {{-- <td style="text-align:center;font-weight:bold;">
                    {{ count($filteredDateRange) }}
                </td> --}}
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

@if ($filteredDateRange->isEmpty())
    <p class="text-center alert alert-warning mt-5">No records of absence or late</p>
@else
    <table class="table table-hover rounded-lg main">
        <thead class="table-dark" style="position: sticky; top: 0; z-index: 1000;">
            <tr>
                <th style="width: 5%">SL.</th>

                <th style="width: 20%;text-align:center;">Date</th>
                <th style="width: 10%;text-align:center;">Roll</th>
                <th style="width: 20%;word-wrap: break-word;;text-align:center;">Student Name</th>
                <th style="width: 20%;text-align:center;">Father Name</th>
                <th style="width: 20%;text-align:center;">SMS Notification</th>
                <th style="width: 12%;text-align:center;">Class</th>
                <th style="width: 13%;text-align:center;">Section</th>
                <th style="width: 10%;"> Status</th>
                <th style="width: 10%">Time</th>
            </tr>
        </thead>
        @php
            $statuses = [
                1 => 'Present',
                2 => 'Absent',
                3 => 'Leave',
                4 => 'Late',
                5 => 'Missing',
            ];
        @endphp
        <tbody class="table-border-bottom-0">
            @foreach ($filteredDateRange as $date)
                <tr>
                    <td style="word-wrap: break-word;text-align:center;">
                        {{ $loop->iteration }}
                    </td>

                    <td style="text-align:left;">
                        {{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}
                    </td>
                    <td style="text-align:center;">{{ $student->roll }}</td>
                    <td style="word-wrap: break-word;text-align:left;">
                        <img src="{{ asset('public/backend') }}/assets/img/avatars/5.png" alt="Avatar"
                            class="rounded-circle avatar avatar-xs">
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
                        @if (isset($attendance[$date]) && $attendance[$date]['status'] == 1)
                            <label class="form-check-label {{ $attendance[$date]['status'] == 1 ? 'present' : '' }}"
                                for="attendance[{{ $date }}1">Present</label>
                        @elseif (isset($attendance[$date]) && $attendance[$date]['status'] == 4)
                            <label
                                class="form-check-label {{ isset($attendance[$date]) && $attendance[$date]['status'] == 4 ? 'late' : '' }}"
                                for="attendance[{{ $date }}4">Late</label>
                        @elseif (isset($attendance[$date]) && $attendance[$date]['status'] == 2)
                            <label
                                class="form-check-label {{ isset($attendance[$date]) && $attendance[$date]['status'] == 2 ? 'absent' : '' }}"
                                for="attendance[{{ $date }}2">Absent</label>
                        @elseif (isset($attendance[$date]) && $attendance[$date]['status'] == 3)
                            <label
                                class="form-check-label {{ isset($attendance[$date]) && $attendance[$date]['status'] == 3 ? 'leave' : '' }}"
                                for="attendance[{{ $date }}2">Leave</label>
                        @elseif (isset($attendance[$date]) && $attendance[$date]['status'] == 5)
                            <label
                                class="form-check-label {{ isset($attendance[$date]) && $attendance[$date]['status'] == 5 ? 'missing' : '' }}"
                                for="attendance[{{ $date }}5">Missing</label>
                        @else
                            <label class="form-check-label">N/A</label>
                        @endif
                    </td>
                    <td>
                        @if (isset($attendance[$date]) && $attendance[$date]['status'] == 4)
                            <label
                                class="form-check-label {{ isset($attendance[$date]) && $attendance[$date]['status'] == 4 ? 'absent' : '' }}"
                                for="attendance[{{ $date }}4">{{ $attendance[$date]['time'] }}</label>
                        @else
                            {{ isset($attendance[$date]) && $attendance[$date]['time'] ? $attendance[$date]['time'] : 'N/A' }}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
@endif
