@if (Auth::user()->group_id != 3)
    <option value="">Select Subject</option>
@endif
@foreach ($subjects as $key => $subject)
    <option value="{{ $subject->id }}">
        {{ $subject->subject_name }}</option>
@endforeach
