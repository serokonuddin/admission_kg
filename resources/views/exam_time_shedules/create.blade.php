@extends('admin.layouts.layout')
@section('content')

<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/jquery-timepicker/jquery-timepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/pickr/pickr-themes.css" />
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
       <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Exam Time shedules</h4>
       <div class="row">
          <div class="col-md-12">

             <div class="card mb-4">
                <h5 class="card-header">Exam Time shedules</h5>
                <!-- Account -->


                <div class="card-body">
                   <form id="formAccountSettings" method="POST"  action="{{route('exam-time-shedules.store')}}">



                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="job_type" class="form-label">Session <span style="color: red">*</span></label>
                                <select id="session_id" name="session_id" class=" form-select" required="">

                                            @foreach($sessions as $session)
                                            <option value="{{$session->id}}" {{(isset($examTimeShedule) && $examTimeShedule->session_id==$session->id)?'selected="selected"':''}}>{{$session->session_name}}</option>
                                            @endforeach

                                </select>
                            </div>

                            @php
                            $class_id=(isset($examTimeShedule) && $examTimeShedule->class_code)?$examTimeShedule->class_code:null;
                            @endphp
                            <div class="mb-3 col-md-4">
                                <label for="class_code" class="form-label">Class <span style="color: red">*</span></label>
                                <select id="class_code" name="class_code" class=" form-select" required="">
                                        <option value="">Select Class</option>

                                            <option value="0" {{($class_id==0)?'selected="selected"':''}}>KG</option>
                                            <option value="1" {{($class_id==1)?'selected="selected"':''}}>CLass I</option>
                                            <option value="2" {{($class_id==2)?'selected="selected"':''}}>CLass II</option>
                                            <option value="3" {{($class_id==3)?'selected="selected"':''}}>CLass III</option>
                                            <option value="4" {{($class_id==4)?'selected="selected"':''}}>CLass IV</option>
                                            <option value="5" {{($class_id==5)?'selected="selected"':''}}>CLass V</option>
                                            <option value="6" {{($class_id==6)?'selected="selected"':''}}>CLass VI</option>
                                            <option value="7" {{($class_id==7)?'selected="selected"':''}}>CLass VII</option>
                                            <option value="8" {{($class_id==8)?'selected="selected"':''}}>CLass VIII</option>
                                            <option value="9" {{($class_id==9)?'selected="selected"':''}}>CLass IX</option>
                                            <option value="10" {{($class_id==10)?'selected="selected"':''}}>CLass X</option>
                                            <option value="11" {{($class_id==11)?'selected="selected"':''}}>CLass XI</option>
                                            <option value="12" {{($class_id==12)?'selected="selected"':''}}>CLass XII</option>
                            </select>
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="exam_id" class="form-label">Exam <span style="color: red">*</span></label>
                                <select id="exam_id" name="exam_id" class=" form-select" required="">
                                    <option value="">Select Exam</option>
                                    @if(isset($exams))
                                        @foreach($exams as $exam)
                                        <option value="{{ $exam->id}}" {{(isset($examTimeShedule) && $examTimeShedule->exam_id==$exam->id)?'selected="selected"':''}}>{{ $exam->exam_title.' '.$exam->session->session_name.' (class:'.($exam->class_code?$exam->class_code:'KG').')' }}</option>
                                        @endforeach
                                    @endif

                                    </select>
                            </div>
                        </div>

                            <div id="subject-wrapper">
                                <div class="subject-item">
                                    <div class="row">
                                        <div class="mb-3 col-md-3">
                                            <label for="subject_id" class="form-label">Subject <span style="color: red">*</span></label>
                                            <select  name="subject_id[]"  class=" form-select subject_id" required="">
                                            <option value="">Select Subject</option>
                                                @if(isset($subjects))
                                                    @foreach($subjects as $subject)
                                                    <option value="{{ $subject->id}}" {{(isset($examTimeShedule) && $examTimeShedule->subject_id==$subject->id)?'selected="selected"':''}}>{{ $subject->subject_name}}</option>
                                                    @endforeach
                                                @endif

                                            </select>

                                        </div>
                                        <div class="mb-3 col-md-2">
                                            <label for="exam_for" class="form-label">Exam For <span style="color: red">*</span></label>
                                            <select class="form-select" name="exam_for[]" required>
                                                <option value="1" {{(isset($examTimeShedule) && $examTimeShedule->exam_for==1)?'selected="selected"':''}}>Written & MCQ</option>
                                                <option value="2" {{(isset($examTimeShedule) && $examTimeShedule->exam_for==2)?'selected="selected"':''}}>Practical</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-2">
                                            <label for="exam_date" class="form-label">Exam Date <span style="color: red">*</span></label>
                                            <input type="date" class="form-control" name="exam_date[]" value="{{(isset($examTimeShedule))?$examTimeShedule->exam_date:''}}" required>
                                        </div>
                                        <div class="mb-3 col-md-2">
                                            <label for="start_time" class="form-label">Start Time <span style="color: red">*</span></label>
                                            <input type="time" class="form-control" name="start_time[]" value="{{(isset($examTimeShedule))?$examTimeShedule->start_time:''}}" required>
                                        </div>
                                        <div class="mb-3 col-md-2">
                                            <label for="end_time" class="form-label">End Time <span style="color: red">*</span></label>
                                            <input type="time" class="form-control" name="end_time[]"  value="{{(isset($examTimeShedule))?$examTimeShedule->end_time:''}}" required>
                                        </div>
                                        <div class="mb-3 col-md-1">
                                             <label for="exam_date" class="form-label" style="height: 45px"></label>
                                            <button type="button" class="btn btn-danger remove-subject">X</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-9">
                                    <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                    <a type="reset" href="{{route('exams.index')}}" class="btn btn-outline-secondary">Cancel</a>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <button type="button" id="add-more-subjects" class="btn btn-secondary me-2">Add More Subjects</button>
                                </div>

                            </div>
                   </form>
                </div>
                <!-- /Account -->
             </div>

          </div>
       </div>
    </div>
    <!-- / Content -->

    <div class="content-backdrop fade"></div>
 </div>
 <script src="{{asset('public/tinymce/js/tinymce/tinymce.min.js')}}" referrerpolicy="origin"></script>
 <script src="{{asset('public/vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
<!-- Place the following <script> and <textarea> tags your HTML's <body> -->
<script>
document.getElementById('add-more-subjects').addEventListener('click', function() {
    var subjectWrapper = document.getElementById('subject-wrapper');
    var newSubjectItem = document.querySelector('.subject-item').cloneNode(true);
    newSubjectItem.querySelectorAll('input').forEach(input => input.value = '');
    subjectWrapper.appendChild(newSubjectItem);
});

document.getElementById('subject-wrapper').addEventListener('click', function(e) {
    if (e.target && e.target.classList.contains('remove-subject')) {
        e.target.closest('.subject-item').remove();
    }
});
</script>
<script>

 $(function(){
    $(document.body).on('change','#class_code',function(){
            var session_id=$('#session_id').val();
            var class_code=$('#class_code').val();
            $.LoadingOverlay("show");
            if(class_code){

                $.ajax({
                    type: "post",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                    url: "{{route('getSubjects')}}",
                    data:{"_token": "{{ csrf_token() }}",class_code},
                    success: function(response){
                        $('.subject_id').html(response);

                    },
                    error: function(data, errorThrown)
                    {
                        Swal.fire({
                            title: "Error",
                            text: errorThrown,
                            icon: "warning"
                        });

                    }
                });
            }
            if(session_id && class_code){
                $.ajax({
                    type: "post",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                    url: "{{route('getExam')}}",
                    data:{"_token": "{{ csrf_token() }}",session_id,class_code},
                    success: function(response){
                        $('#exam_id').html(response);
                        $.LoadingOverlay("hide");
                    },
                    error: function(data, errorThrown)
                    {
                        Swal.fire({
                            title: "Error",
                            text: errorThrown,
                            icon: "warning"
                        });
                        $.LoadingOverlay("hide");
                    }
                });
            }
            $.LoadingOverlay("hide");
        });
        $(document.body).on('change','#session_id',function(){
            var session_id=$('#session_id').val();
            var class_code=$('#class_code').val();

            if(session_id && class_code){
                $.LoadingOverlay("show");
                $.ajax({
                    type: "post",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                    url: "{{route('getExam')}}",
                    data:{"_token": "{{ csrf_token() }}",session_id,class_code},
                    success: function(response){
                        $('#exam_id').html(response);
                        $.LoadingOverlay("hide");
                    },
                    error: function(data, errorThrown)
                    {
                        Swal.fire({
                            title: "Error",
                            text: errorThrown,
                            icon: "warning"
                        });
                        $.LoadingOverlay("hide");
                    }
                });
            }


        });

 });
</script>


@endsection
