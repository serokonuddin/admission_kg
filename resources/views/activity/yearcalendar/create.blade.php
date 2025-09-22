@extends('admin.layouts.layout')
@section('content')

<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/jquery-timepicker/jquery-timepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/pickr/pickr-themes.css" />
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
       <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Year Calendar</h4>
       <div class="row">
          <div class="col-md-12">

             <div class="card mb-4">
                <h5 class="card-header">Year Calendar Information</h5>
                <!-- Account -->


                <div class="card-body">
                   <form id="formAccountSettings" method="POST"  action="{{route('year-calendar.store')}}">
                    <input type="hidden" value="{{isset($yearCalendar)?$yearCalendar->id:''}}" name="id" />
                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                      <div class="row">

                        <div class="mb-3 col-md-12">
                            <label for="year" class="form-label">Year</label>
                            <select  name="year" id="year"  class="select2 form-select" required="required">
                               <option value="">Select Year Type</option>
                               @foreach($sessions as $session)
                               <option value="{{$session->id}}" {{(isset($yearCalendar) && $yearCalendar->year==$session->id)?'selected="selected"':''}}>{{$session->session_name}}</option>
                               @endforeach


                            </select>
                         </div>

                         <div class="mb-3 col-md-12">
                            <label for="title" class="form-label">Title</label>
                            <input class="form-control" type="text" id="title" name="title" required="required" value="{{isset($yearCalendar)?$yearCalendar->title:''}}" placeholder="calendar Name" autofocus="">
                         </div>

                         <div class="mb-3 col-md-12">
                            <label for="title" class="form-label">Title BN</label>
                            <input class="form-control" type="text" id="title_bn" name="title_bn" required="required" value="{{isset($yearCalendar)?$yearCalendar->title:''}}" placeholder="calendar Name" autofocus="">
                         </div>
                         <div class="mb-3 col-md-12">
                            <label for="title" class="form-label">Short Title</label>
                            <input class="form-control" type="text" id="short_title" name="short_title"  value="{{isset($yearCalendar)?$yearCalendar->title:''}}" placeholder="calendar Name" autofocus="">
                         </div>

                         <div class="mb-3 col-md-12">
                            <label for="title" class="form-label">Short Title BN</label>
                            <input class="form-control" type="text" id="short_title_bn" name="short_title_bn"  value="{{isset($yearCalendar)?$yearCalendar->title:''}}" placeholder="calendar Name" autofocus="">
                         </div>
                         <div class="mb-3 col-md-6">
                            <label for="permanent_addr" class="form-label">Start Date</label>
                            <input class="form-control" type="date" id="start_date" required="required" name="start_date" value="{{isset($yearCalendar)?$yearCalendar->start_date:''}}" placeholder="Start Date" autofocus="">
                         </div>
                         <div class="mb-3 col-md-6">
                            <label for="permanent_addr" class="form-label">End Date</label>
                            <input class="form-control" type="date" id="end_date"  name="end_date" value="{{isset($yearCalendar)?$yearCalendar->end_date:''}}" placeholder="End Date" autofocus="">
                         </div>
                         <div class="mb-3 col-md-6">
                            <label for="permanent_addr" class="form-label">Number Of Holi-days</label>
                            <input class="form-control" type="number" id="number_of_days" required="required" name="number_of_days" value="{{isset($yearCalendar)?$yearCalendar->number_of_days:'00'}}" placeholder="End Date" autofocus="">
                         </div>

                         <div class="mb-3 col-md-4">
                           <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                              <input type="radio" class="btn-check" name="is_exam_date" id="is_exam_date1" value="1" required="required" {{(isset($yearCalendar) && $yearCalendar->is_exam_date==1)?'checked="checked"':''}} autocomplete="off" >
                              <label class="btn btn-outline-primary" for="is_exam_date1">Exam Date Yes</label>

                              <input type="radio" class="btn-check" name="is_exam_date" id="is_exam_date0" value="0" required="required" {{(isset($yearCalendar) && $yearCalendar->is_exam_date==0)?'checked="checked"':''}} autocomplete="off" >
                              <label class="btn btn-outline-primary" for="is_exam_date0">Exam Date No</label>


                           </div>
                         </div>
                      </div>
                      <button type="submit" class="btn btn-primary me-2">Save changes</button>
                      <a type="reset" href="{{route('year-calendar.index')}}" class="btn btn-outline-secondary">Cancel</a>
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
 <script src="{{asset('tinymce/js/tinymce/tinymce.min.js')}}" referrerpolicy="origin"></script>

<!-- Place the following <script> and <textarea> tags your HTML's <body> -->
<script>
 $(function(){
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
    path_absolute : "http://127.0.0.1:8000/",
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
