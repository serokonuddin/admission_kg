@if (Auth::user()->group_id != 3)
    <option value="">Select Section</option>
@endif
@foreach ($sections as $key => $section)
    <option value="{{ $section->id }}">{{ $section->section_name }}</option>
@endforeach
