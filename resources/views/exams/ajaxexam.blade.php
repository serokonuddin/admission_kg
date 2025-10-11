<option value="">Select Exam</option>
@foreach($exams as $exam)
<option value="{{ $exam->id}}" {{(Session::get('exam_id')==$exam->id)?'selected="selected"':''}}>{{ $exam->exam_title.' '.$exam->session->session_name.' (class:'.($exam->class_code?$exam->class_code:'KG').')' }}</option>
@endforeach