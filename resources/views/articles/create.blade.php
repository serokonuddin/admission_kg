@extends('admin.layouts.layout')
@section('content')

<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/jquery-timepicker/jquery-timepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/pickr/pickr-themes.css" />
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
       <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Articles</h4>
       <div class="row">
          <div class="col-md-12">

             <div class="card mb-4">
                <h5 class="card-header">Articles Information</h5>
                <!-- Account -->


                <div class="card-body">
                   <form id="formAccountSettings" method="POST"  action="{{route('articles.store')}}">
                    <input type="hidden" value="{{isset($article)?$article->id:''}}" name="id" />
                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                      <div class="row">
                        <div class="mb-3 col-md-12">
                            <label for="article_type" class="form-label">Article Type</label>
                            <select  name="article_type" id="article_type"  class="select2 form-select" required="required">
                               <option value="">Select Article Type</option>
                               <option value="From Campus">From Campus</option>
                               <option value="Student Corner">Student Corner</option>


                            </select>
                         </div>

                         <div class="mb-3 col-md-12">
                            <label for="title" class="form-label">Article Title</label>
                            <input class="form-control" type="text" id="article_title" name="article_title" required="required" value="{{isset($article)?$article->article_title:''}}" placeholder="Article Name" autofocus="">
                         </div>


                         <div class="mb-3 col-md-12">
                            <label for="permanent_addr" class="form-label">Details</label>
                            <textarea type="text" class="form-control" id="article" name="article" placeholder="Details" >{!!isset($article)?$article->article:''!!}</textarea>
                         </div>
                         <div class="mb-3 col-md-12 form-group gallery" id="photo_gallery">
                                    <label for="inputPhoto" class="col-form-label">Pdf File <span class="text-danger">*</span></label>
                                    <div class="input-group">

                                    <input id="thumbnail" class="form-control" type="text" name="image" value="{{isset($article)?$article->image:''}}">
                                    <span class="input-group-btn">
                                             <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                             <i class="fa fa-picture-o"></i> Choose
                                             </a>
                                          </span>
                                    </div>
                        </div>
                         <div class="mb-3 col-md-6">
                            <label for="permanent_addr" class="form-label">Publish Date</label>
                            <input class="form-control" type="date" id="publish_date" required="required" name="publish_date" value="{{isset($article)?$article->publish_date:''}}" placeholder="Publish Date" autofocus="">
                         </div>

                         <div class="mb-3 col-md-4">
                           <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                              <input type="radio" class="btn-check" name="status" id="active1" value="1" required="required" {{(isset($article) && $article->status==1)?'checked="checked"':''}} autocomplete="off" >
                              <label class="btn btn-outline-primary" for="active1">Active</label>

                              <input type="radio" class="btn-check" name="status" id="active0" value="0" required="required" {{(isset($article) && $article->status==0)?'checked="checked"':''}} autocomplete="off" >
                              <label class="btn btn-outline-primary" for="active0">Inactive</label>


                           </div>
                         </div>

                      </div>

                      <button type="submit" class="btn btn-primary me-2">Save changes</button>
                      <a type="reset" href="{{route('articles.index')}}" class="btn btn-outline-secondary">Cancel</a>
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
