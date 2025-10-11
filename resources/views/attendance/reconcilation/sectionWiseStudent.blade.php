@if (Auth::user()->group_id != 3)
    <option value="">Select Student</option>
@endif
@foreach ($students as $key => $student)
    <option value="{{ $student->student_code }}">{{ $student->first_name }}</option>
@endforeach
