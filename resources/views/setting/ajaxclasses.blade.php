<option value="">Select Class</option>
@foreach ($classvalue as $class)
    <option value="{{ $class['class_code'] }}">{{ $class['class_name'] }}</option>
@endforeach
