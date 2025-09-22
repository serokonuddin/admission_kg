<div class="calendar">
    <div class="header">Sun</div>
    <div class="header">Mon</div>
    <div class="header">Tue</div>
    <div class="header">Wed</div>
    <div class="header">Thu</div>
    <div class="header">Fri</div>
    <div class="header">Sat</div>

    @php
        use Carbon\Carbon;
        $startDate = new Carbon($startDate);
        $endDate = new Carbon($endDate);
        $currentDate = $startDate->copy();
        $attendanceArray = $attendanceData->keyBy('attendance_date')->toArray();
        $status = ['Present', 'Absent', 'Leave', 'Late', 'Missing'];
    @endphp

    @for ($i = 0; $i < $startDate->dayOfWeek; $i++)
        <div class="day"></div>
    @endfor

    @while ($currentDate <= $endDate)
        @php
            $dateString = $currentDate->format('Y-m-d');
            $attendanceRecord = $attendanceArray[$dateString] ?? null;
        @endphp
        <div class="day {{ $attendanceRecord ? $status[$attendanceRecord['status'] - 1] : '' }}">
            <div>{{ $currentDate->day }}</div>
            @if ($attendanceRecord)
                <div class="remarks">{{ $status[$attendanceRecord['status'] - 1] }}</div>
            @endif
        </div>
        @php $currentDate->addDay(); @endphp
    @endwhile
</div>
