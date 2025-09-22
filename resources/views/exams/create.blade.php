@extends('admin.layouts.layout')
@section('content')

<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/jquery-timepicker/jquery-timepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/pickr/pickr-themes.css" />
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
       <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Exam</h4>
       <div class="row">
          <div class="col-md-12">

             <div class="card mb-4">
                <h5 class="card-header">Exam Information</h5>
                <!-- Account -->


                <div class="card-body">
                   <form id="formAccountSettings" method="POST"  action="{{route('exams.store')}}">

                    <input type="hidden" value="{{isset($exam)?$exam->id:0}}" name="id" />

                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                      <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="job_type" class="form-label">Session</label>
                            <select id="session_id" name="session_id" class=" form-select" required="">

                                        @foreach($sessions as $session)
                                        <option value="{{$session->id}}" {{(isset($exam) && $exam->session_id==$session->id)?'selected="selected"':''}}>{{$session->session_name}}</option>
                                        @endforeach

                            </select>
                         </div>

                         @php
                           $class_id=(isset($exam) && $exam->class_code)?$exam->class_code:null;
                         @endphp
                         <div class="mb-3 col-md-6">
                            <label for="job_type" class="form-label">Class</label>
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

                         <div class="mb-3 col-md-12">
                            <label for="permanent_addr" class="form-label">Exam Title</label>
                            <input type="text" class="form-control" id="exam_title" name="exam_title" value="{{(isset($exam))?$exam->exam_title:old('exam_title')}}" placeholder="Exam title" >
                         </div>



                         <div class="mb-3 col-md-6">
                            <label for="permanent_addr" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{(isset($exam))?$exam->start_date:old('start_date')}}" placeholder="Start Date" >
                         </div>
                         <div class="mb-3 col-md-6">
                            <label for="permanent_addr" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{(isset($exam))?$exam->end_date:old('end_date')}}" placeholder="End Date" >
                         </div>



                      </div>

                      <button type="submit" class="btn btn-primary me-2">Save changes</button>
                      <a type="reset" href="{{route('exams.index')}}" class="btn btn-outline-secondary">Cancel</a>
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

 $(function(){
   $('#lfm').filemanager();
   $(document.body).on('change','input[name=is_parent]',function(){
      var parent_id=$(this).val();
      var text=$('#title').val();
      ///text=text.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
      text=text.replace(/[_\s]/g, '-').replace(/,/g , '');
      text=text.split(' ').join('_');
      if(parent_id==0){
        $('#slug').val(text.toLowerCase());
      }else{
        $('#slug').val('#');
      }
    });
    $(document.body).on('change','#title',function(){
      var text=$(this).val();
      var parent_id=$('input[name=is_parent]:checked').val();
      //text=text.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
      text=text.replace(/[_\s]/g, '-').replace(/,/g , '');
      text=text.split(' ').join('_');
      if(parent_id==0){
        $('#slug').val(text.toLowerCase());
      }else{
        $('#slug').val('#');
      }

    });
 });
</script>

<script>
  var editor_config = {
    path_absolute : "{{url('/')}}/",
    selector: 'textarea',
    relative_urls: false,
    plugins: 'iframe pageembed code preview anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'iframe | pageembed code preview | undo redo | blocks fontfamily fontsize | bold italic underline strikethrough| link image media | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | link image media',
    tiny_pageembed_classes: [
        { text: 'Big embed', value: 'my-big-class' },
        { text: 'Small embed', value: 'my-small-class' }
    ],
    file_picker_callback : function(callback, value, meta) {
      var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
      var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

      var cmsURL = editor_config.path_absolute + 'laravel-filemanager?editor=' + meta.fieldname;
      if (meta.filetype == 'image') {
        cmsURL = cmsURL + "&type=Images";
      } else {
        cmsURL = cmsURL + "&type=Files";
      }

      tinyMCE.activeEditor.windowManager.openUrl({
        url : cmsURL,
        title : 'Filemanager',
        width : x * 0.8,
        height : y * 0.8,
        resizable : "yes",
        close_previous : "no",
        onMessage: (api, message) => {
          callback(message.content);
        }
      });
    },
    setup: function (editor) {
                editor.ui.registry.addButton('iframe', {
                    icon: 'media',
                    tooltip: 'Insert iframe',
                    onAction: function (_) {
                        // Implement the logic to insert an iframe here
                        var iframeCode = prompt('Enter the iframe code:');
                        if (iframeCode) {
                            editor.insertContent(iframeCode);
                        }
                    }
                });
            }
  };

  tinymce.init(editor_config);
</script>
<script>
$(function() {





});
</script>
@endsection
