@extends('admin.layouts.layout')
@section('content')

<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/jquery-timepicker/jquery-timepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/pickr/pickr-themes.css" />
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
       <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Leave</h4>
       <div class="row">
          <div class="col-md-12">

             <div class="card mb-4">
                <h5 class="card-header">Leave Request</h5>
                <!-- Account -->


                <div class="card-body">
                   <form id="formAccountSettings" method="POST"  action="{{route('documents.store')}}" enctype="multipart/form-data">
                    <input type="hidden" value="{{isset($document)?$document->id:''}}" name="id" />
                    <input type="hidden" value="{{isset($document)?$document->status:1}}" name="status" />
                    <input type="hidden" value="{{isset($document)?$document->created_by:Auth::user()->id}}" name="created_by" />
                    <input type="hidden" value="{{isset($document)?$document->session_id:date('Y')}}" name="session_id" />
                    <input type="hidden" value="{{isset($document)?$document->date:date('Y-m-d')}}" name="date" />
                    <input type="hidden" value="5" name="document_for" />
                    <input type="hidden" value="{{Auth::user()->ref_id}}" name="ref_id" />
                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                      <div class="row">
                        

                         <div class="mb-3 col-md-12">
                            <label for="title" class="form-label">Leave Title</label>
                            <input class="form-control" type="text" id="subject" name="subject" required="required" value="{{isset($document)?$document->subject:''}}" placeholder="Subject" autofocus="">
                         </div>
						 <div class="mb-3 col-md-6">
                            <label for="permanent_addr" class="form-label">Start Date</label>
                            <input class="form-control" type="date" id="start_date" required="required" name="start_date" value="{{isset($document)?$document->start_date:''}}" placeholder="Start Date" autofocus="">
                         </div>
                         <div class="mb-3 col-md-6">
                            <label for="permanent_addr" class="form-label">End Date</label>
                            <input class="form-control" type="date" id="end_date" required="required" name="end_date" value="{{isset($document)?$document->end_date:''}}" placeholder="End Date" autofocus="">
                         </div>

                         <div class="mb-3 col-md-12">
                            <label for="permanent_addr" class="form-label">Details</label>
                            <textarea type="text" class="form-control" id="details" name="details" placeholder="Details" >{!!isset($document)?$document->details:''!!}</textarea>
                         </div>
                         <div class="mb-3 col-md-4">
                                            <label for="attach_file" class="form-label">Attach File (jpg,jpeg,pdf format)</label>
                                            <input class="form-control" type="file" id="attach_file"
                                                onchange="loadFile(event,'attach_file_preview')" name="attach_file">
                                            <img id="attach_file_preview" alt="Attach File Preview"
                                                style="max-width: 100px; display: none;">
                                            <span style="color: rgb(0,149,221)">(File size max 1000 KB)</span>
                        </div>
                         
                         
                         
                      </div>

                      <button type="submit" class="btn btn-primary me-2">Save changes</button>
                      <a type="reset" href="{{route('documents.index')}}" class="btn btn-outline-secondary">Cancel</a>
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
  @if ($errors->any())
    @php 
    $text='';
    foreach ($errors->all() as $error){
      $text.=$error.'. ';
    }
      
    @endphp
    
    Swal.fire({
                      title: "warning!",
                      text: "{{$text}}",
                      icon: "warning"
      });
@endif
    function checkfilevalistion(filedata) {
     // let fileInput = filedata[0];
      
      console.log(event.target.files[0]);
      if (event.target.files.length === 0) {
       
        return 0;
      }

      let fileName = event.target.files[0].name;
      let allowedExtensions = /(\.jpg|\.jpeg|\.png|\.pdf)$/i;

      if (!allowedExtensions.exec(fileName)) {
       
       
        return 0;
      }

      return 1;
    }

        var loadFile = function(event, preview) {
            var check =checkfilevalistion(event);
            
            if(check==1){
              var sizevalue = (event.target.files[0].size);

              if (sizevalue > 1000000) {

                  Swal.fire({
                      title: "warning!",
                      text: "File Size Too Large",
                      icon: "warning"
                  });
                  var idvalue = preview.slice(0, -8);

                  $('#' + idvalue).val('');
                  return false;
              } else {
               
                  const previewElement = document.getElementById(preview);
                  if (previewElement) {
                      const file = event.target.files[0];
                      if (file) {
                          previewElement.src = URL.createObjectURL(file);
                          previewElement.style.display = 'block'; // Show the preview element
                      }
                  } else {
                      console.error(`Preview element with ID "${preview}" not found.`);
                  }

              }
            }else{
              Swal.fire({
                      title: "warning!",
                      text: "Only JPG, PNG, and PDF files are allowed.",
                      icon: "warning"
                  });
                  $('#' + idvalue).val('');
                  return false;
            }
            

        };
    </script>
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
