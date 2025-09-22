@if(Auth::user()->group_id!=3)
<option value="">Select Section</option>
@endif
@foreach($sections as $key=>$section)
<option value="{{$section->id}}" {{(Session::get('section_id')==$section->id)?'selected="selected"':''}}>{{$section->section_name}}</option>
@endforeach
