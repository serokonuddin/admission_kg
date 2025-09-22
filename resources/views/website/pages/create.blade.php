@extends('admin.layouts.layout')
@section('content')

<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/jquery-timepicker/jquery-timepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/pickr/pickr-themes.css" />
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
       <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Page</h4>
       <div class="row">
          <div class="col-md-12">

             <div class="card mb-4">
                <h5 class="card-header">Page Information</h5>
                <!-- Account -->


                <div class="card-body">
                   <form id="formAccountSettings" method="POST"  action="{{route('pages.store')}}">
                    <input type="hidden" value="{{isset($page)?$page->id:''}}" name="id" />
                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                      <div class="row">
                        <div class="mb-3 col-md-12">
                            <label for="job_type" class="form-label">Parent Page</label>
                            <select id="job_type" name="parent_id" id="parent_id"  class="select2 form-select">
                               <option value="0">Select Page</option>
                               @foreach($pageies as $paged)
                               <option value="{{$paged->id}}" {{(isset($page) && $page->parent_id==$paged->id)?'selected="selected"':''}}>{{$paged->title}}</option>
                               @endforeach


                            </select>
                         </div>
                         <div class="mb-3 col-md-12">

                           <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                              <input type="radio" class="btn-check" name="is_parent" id="is_parent1" {{(isset($page) && $page->is_parent==1)?'checked="checked"':''}} value="1" autocomplete="off" >
                              <label class="btn btn-outline-primary" for="is_parent1">Parent Yes</label>

                              <input type="radio" class="btn-check" name="is_parent" id="is_parent0" value="0" {{(isset($page) && $page->is_parent==0)?'checked="checked"':''}} autocomplete="off" >
                              <label class="btn btn-outline-primary" for="is_parent0">Parent No</label>


                           </div>
                         </div>
                         <div class="mb-3 col-md-12">
                            <label for="title" class="form-label">Page Name</label>
                            <input class="form-control" type="text" id="title" name="title" value="{{isset($page)?$page->title:''}}" placeholder="Page Name" autofocus="">
                         </div>
                         <div class="mb-3 col-md-12">
                            <label for="first_name" class="form-label">Page Slug</label>
                            <input class="form-control" type="text" id="slug" name="slug" readonly="readonly" value="{{isset($page)?$page->slug:''}}" placeholder="Page Slug" autofocus="">
                         </div>


                         <div class="mb-3 col-md-12">
                            <label for="permanent_addr" class="form-label">Details</label>
                            <textarea type="text" class="form-control" id="details" name="details" placeholder="Details" >{!!isset($page)?$page->details:''!!}</textarea>
                         </div>
                         <div class="mb-3 col-md-4">
                            <input class="form-control" type="number" id="serial" name="serial" value="{{isset($page)?$page->serial:''}}" placeholder="Page Serial" autofocus="">
                         </div>

                         <div class="mb-3 col-md-4">
                           <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                              <input type="radio" class="btn-check" name="active" id="active1" value="1" {{(isset($page) && $page->active==0)?'checked="checked"':''}} autocomplete="off" >
                              <label class="btn btn-outline-primary" for="active1">Active</label>

                              <input type="radio" class="btn-check" name="active" id="active0" value="0" {{(isset($page) && $page->active==0)?'checked="checked"':''}} autocomplete="off" >
                              <label class="btn btn-outline-primary" for="active0">Inactive</label>


                           </div>
                         </div>
                         <div class="mb-3 col-md-12 form-group gallery" id="photo_gallery">
                                <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
                                <div class="input-group">

                                <input id="thumbnail" class="form-control" type="text" name="images" value="{{(isset($page))?$page->images:''}}">
                                <span class="input-group-btn">
                                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                        <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                </div>
                         </div>
                      </div>
                      <button type="submit" class="btn btn-primary me-2">Save changes</button>
                      <a type="reset" href="{{route('pages.index')}}" class="btn btn-outline-secondary">Cancel</a>
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
 <script src="{{asset('public/vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
 <script src="{{asset('public/tinymce/js/tinymce/tinymce.min.js')}}" referrerpolicy="origin"></script>

<!-- Place the following <script> and <textarea> tags your HTML's <body> -->
<script>
 $(function(){
   $('#lfm').filemanager('image');
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
