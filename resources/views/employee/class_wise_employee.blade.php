@if (Auth::user()->group_id != 3)
    <option value="">Select Teacher</option>
@endif
@foreach ($employees as $employee)
    <option value="{{ $employee->id }}">
        {{ $employee->employee_name }}
    </option>
@endforeach
