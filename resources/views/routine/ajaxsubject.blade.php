@if($subjects->isEmpty())
    <option value="">No Subjects Available</option>
@else
    <option value="">Select Subject</option>
    @foreach ($subjects as $subject)
        <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
    @endforeach
@endif
