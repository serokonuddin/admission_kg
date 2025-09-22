<option value="">Select Teacher</option>
@foreach($teachers as $teacher)
<option value="{{ $teacher->id}}">{{ $teacher->employee_name }} ({{ $teacher->designation_name }})</option>
@endforeach