<option value="">Select Section</option>

@foreach ($sessions as $session_code => $session_name)
    <option value="{{ $session_code }}">{{ $session_name }}</option>
@endforeach
