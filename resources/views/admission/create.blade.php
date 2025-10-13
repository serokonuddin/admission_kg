@extends('admin.layouts.layout')
@section('content')

<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/jquery-timepicker/jquery-timepicker.css" />
<link rel="stylesheet" href="{{asset('public/backend')}}/assets/vendor/libs/pickr/pickr-themes.css" />
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
       <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Admission</h4>
       <div class="row">
          <div class="col-md-12">

             <div class="card mb-4">
                <h5 class="card-header">Open Admission From</h5>
                <!-- Account -->


                <div class="card-body">
                   <form id="formAccountSettings" method="POST"  action="{{route('admissionlist.store')}}" enctype="multipart/form-data">
                    <input type="hidden" value="{{isset($admission)?$admission->id:''}}" name="id" />
                    <input type="hidden" value="{{isset($admission)?$admission->session_id:$session->id}}" name="session_id" />
                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                      <div class="row">
                         <div class="mb-3 col-md-12">
                            <label for="class" class="form-label">Version</label>
                            <select id="class" name="version_id" id="version_id"  class="select2 form-select" required="required">
                               <option value="0">Select Version</option>
                               @foreach($versions as $version)
                               <option value="{{$version->id}}" {{(isset($admission) && $admission->version_id==$version->id)?'selected="selected"':''}}>{{$version->version_name}}</option>
                               @endforeach


                            </select>
                         </div>
                         <div class="mb-3 col-md-12">
                            <label for="class" class="form-label">Class</label>
                            <select id="class" name="class_id" id="class_id"  class="select2 form-select" required="required">
                              
                               <option value="0" {{(isset($admission) && $admission->class_id==0)?'selected="selected"':''}}>KG</option>
                               

                            </select>
                         </div>

                         <div class="mb-3 col-md-12">
                            <label for="title" class="form-label">Number Of Student</label>
                            <input class="form-control" type="text" id="number_of_admission" name="number_of_admission" required="required" value="{{isset($admission)?$admission->number_of_admission:''}}" placeholder="Number Of Admission" autofocus="">
                         </div>


                         <div class="mb-3 col-md-12">
                            <label for="permanent_addr" class="form-label">Details</label>
                            <textarea type="text" class="form-control" id="details" name="details" placeholder="Details" >{!!isset($admission)?$admission->details:''!!}</textarea>
                         </div>

                         <div class="mb-3 col-md-6">
                            <label for="permanent_addr" class="form-label">Start Date</label>
                            <input class="form-control" type="date" id="start_date" required="required" name="start_date" value="{{isset($admission)?$admission->start_date:''}}" placeholder="Start Date" autofocus="">
                         </div>
                         <div class="mb-3 col-md-6">
                            <label for="permanent_addr" class="form-label">End Date</label>
                            <input class="form-control" type="date" id="end_date" required="required" name="end_date" value="{{isset($admission)?$admission->end_date:''}}" placeholder="End Date" autofocus="">
                         </div>
                         <div class="mb-3 col-md-6">
                            <label for="permanent_addr" class="form-label">Final Admission Start Date</label>
                            <input class="form-control" type="date" id="admission_start_date" required="required" name="admission_start_date" value="{{isset($admission)?$admission->admission_start_date:''}}" placeholder="Final Admission Start Date" autofocus="">
                         </div>
                         <div class="mb-3 col-md-6">
                            <label for="permanent_addr" class="form-label">Final Admission End Date</label>
                            <input class="form-control" type="date" id="admission_end_date" required="required" name="admission_end_date" value="{{isset($admission)?$admission->admission_end_date:''}}" placeholder="Final Admission End Date" autofocus="">
                         </div>
                         <div class="mb-3 col-md-4">
                           <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                              <input type="radio" class="btn-check" name="status" id="active1" value="1" required="required" {{(isset($admission) && $admission->status==1)?'checked="checked"':''}} autocomplete="off" >
                              <label class="btn btn-outline-success" for="active1">Active</label>
                              <input type="radio" class="btn-check" name="status" id="active2" value="2" required="required" {{(isset($admission) && $admission->status==2)?'checked="checked"':''}} autocomplete="off" >
                              <label class="btn btn-outline-info" for="active2">Close</label>
                              <input type="radio" class="btn-check" name="status" id="active0" value="0" required="required" {{(isset($admission) && $admission->status==0)?'checked="checked"':''}} autocomplete="off" >
                              <label class="btn btn-outline-primary" for="active0">Inactive</label>


                           </div>
                         </div>
                         <div class="mb-3">
                            <label for="formFile" class="form-label">Default file input example (Allowed formats: XLSX, XLS, CSV. Max file size: 200 KB)</label>
                            <input class="form-control" type="file" name="file" id="formFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                            <input class="form-control" type="hidden" name="file_old" id="formFile1" value="{{(isset($admission))?$admission->file:''}}">
                        </div>
                      </div>
                      <div class="mb-3 col-md-12">
                            <label for="title" class="form-label">Price</label>
                            <input class="form-control" type="text" id="price" name="price" required="required" value="{{isset($admission)?$admission->price:''}}" placeholder="price" autofocus="">
                         </div>

                      <button type="submit" class="btn btn-primary me-2">Save changes</button>
                      <a type="reset" href="{{route('admissionlist.index')}}" class="btn btn-outline-secondary">Cancel</a>
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
    // Display Laravel success or error messages with Toastr
    @if (session('success'))
        toastr.success("{{ session('success') }}", "Success", {
            closeButton: true,
            progressBar: true,
            timeOut: 3000,
        });
    @endif

    @if (session('error'))
        toastr.error("{{ session('error') }}", "Error", {
            closeButton: true,
            progressBar: true,
            timeOut: 3000,
        });
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}", "Validation Error", {
                closeButton: true,
                progressBar: true,
                timeOut: 3000,
            });
        @endforeach
    @endif
</script>
@endsection
