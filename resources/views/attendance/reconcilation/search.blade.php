@if ($counts)
    <table class="table table-hover table-bordered rounded-lg mt-2 mb-2 statistics">
        <thead class="table-light">
            <tr>
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

@if ($filteredDateRange->isEmpty())
    <p class="text-center alert alert-warning mt-5">No records of absence or late</p>
@else
    <table class="table table-hover rounded-lg main">
        <thead class="table-dark" style="position: sticky; top: 0; z-index: 1000;">
            <tr>
                <th style="width: 5%">SL.</th>
                <th style="width: 10%;padding-bottom: 18px;">
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" name="all" value="all" id="all" />
                        <label class="form-check-label" for="all"> ALL </label>
                    </div>
                </th>
                {{-- <th style="width: 10%">Time</th> --}}
                <th style="width: 12%;text-align:center;">Date</th>
                <th style="width: 10%;text-align:center;">Roll</th>
                <th style="width: 20%;word-wrap: break-word;;text-align:center;">Student Name</th>
                <th style="width: 20%;text-align:center;">Father Name</th>
                <th style="width: 20%;text-align:center;">SMS Notification</th>
                <th style="width: 12%;text-align:center;">Class</th>
                <th style="width: 13%;text-align:center;">Section</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @foreach ($filteredDateRange as $date)
                <tr>
                    <td style="word-wrap: break-word;text-align:center;">
                        {{ $loop->iteration }}
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input Present" type="radio"
                                name="attendance[{{ $date }}]" id="attendance[{{ $date }}]1"
                                value="1" />
                            <label class="form-check-label" for="attendance[{{ $date }}1">Present</label>

                            {{-- <input class="form-check-input Present" type="radio"
                            {{ isset($attendance[$date]) && $attendance[$date] == 1 ? 'checked="checked"' : '' }}
                            name="attendance[{{ $date }}]" id="attendance[{{ $date }}]1"
                            value="1" /> --}}
                            {{-- <label
                            class="form-check-label {{ isset($attendance[$date]) && $attendance[$date] == 1 ? 'present' : '' }}"
                            for="attendance[{{ $date }}1">Present</label> --}}
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input Late" type="radio"
                                {{ isset($attendance[$date]) && $attendance[$date] == 4 ? 'checked="checked"' : '' }}
                                name="attendance[{{ $date }}]" id="attendance[{{ $date }}]4"
                                value="4" />
                            <label
                                class="form-check-label {{ isset($attendance[$date]) && $attendance[$date] == 4 ? 'late' : '' }}"
                                for="attendance[{{ $date }}4">Late</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input Absent" type="radio"
                                {{ isset($attendance[$date]) && $attendance[$date] == 2 ? 'checked="checked"' : '' }}
                                name="attendance[{{ $date }}]" id="attendance[{{ $date }}]2"
                                value="2" />
                            <label
                                class="form-check-label {{ isset($attendance[$date]) && $attendance[$date] == 2 ? 'absent' : '' }}"
                                for="attendance[{{ $date }}2">Absent</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input Leave" type="radio"
                                {{ isset($attendance[$date]) && $attendance[$date] == 3 ? 'checked="checked"' : '' }}
                                name="attendance[{{ $date }}]" id="attendance[{{ $date }}]3"
                                value="3" />
                            <label
                                class="form-check-label {{ isset($attendance[$date]) && $attendance[$date] == 3 ? 'leave' : '' }}"
                                for="attendance[{{ $date }}2">Leave</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input Missing" type="radio"
                                {{ isset($attendance[$date]) && $attendance[$date] == 5 ? 'checked="checked"' : '' }}
                                name="attendance[{{ $date }}]" id="attendance[{{ $date }}]5"
                                value="5" />
                            <label
                                class="form-check-label {{ isset($attendance[$date]) && $attendance[$date] == 5 ? 'missing' : '' }}"
                                for="attendance[{{ $date }}5">Missing</label>
                        </div>
                        {{-- <input type="radio" name="attendance[{{ $date }}]" value="1"
                        {{ isset($attendance[$date]) && $attendance[$date] == '1' ? 'checked' : '' }}> Present
                    <input type="radio" name="attendance[{{ $date }}]" value="2"
                        {{ isset($attendance[$date]) && $attendance[$date] == '2' ? 'checked' : '' }}> Absent
                    <input type="radio" name="attendance[{{ $date }}]" value="4"
                        {{ isset($attendance[$date]) && $attendance[$date] == '4' ? 'checked' : '' }}> Late --}}
                        {{-- <input type="radio" name="attendance[{{ $date }}]" value="3"
                        {{ isset($attendance[$date]) && $attendance[$date] == '3' ? 'checked' : '' }}> Leave
                    <input type="radio" name="attendance[{{ $date }}]" value="5"
                        {{ isset($attendance[$date]) && $attendance[$date] == '5' ? 'checked' : '' }}> Missing --}}
                    </td>
                    {{-- <td style="word-wrap: break-word;text-align:center;">
                    <input class="form-control" name="time{{ $student->student_code }}"
                        id="time{{ $student->student_code }}" type="time"
                        value="{{ isset($student->studentAttendance->time) ? $student->studentAttendance->time : date('H:i', strtotime($student->start_time)) }}"
                        id="html5-time-input" required>
                </td> --}}
                    <td style="text-align:left;font-weight:bold;">
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
                </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
@endif
