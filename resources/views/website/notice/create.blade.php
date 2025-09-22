@extends('admin.layouts.layout')
@section('content')
    <link rel="stylesheet"
        href="{{ asset('public/backend') }}/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
    <link rel="stylesheet"
        href="{{ asset('public/backend') }}/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
    <link rel="stylesheet" href="{{ asset('public/backend') }}/assets/vendor/libs/jquery-timepicker/jquery-timepicker.css" />
    <link rel="stylesheet" href="{{ asset('public/backend') }}/assets/vendor/libs/pickr/pickr-themes.css" />
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            {{-- <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Notice</h4> --}}
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ route('notice.index') }}">Notice</a>
                </li>

                <li class="breadcrumb-item active" aria-current="page"> Create</li>
            </ol>
            <div class="row">
                <div class="col-md-12">

                    <div class="card mb-4">
                        <h5 class="card-header">Notice Information</h5>
                        <!-- Account -->


                        <div class="card-body">
                            <form id="formAccountSettings" method="POST" action="{{ route('notice.store') }}"
                                enctype="multipart/form-data">
                                <input type="hidden" value="{{ isset($notice) ? $notice->id : '' }}" name="id" />
                                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label for="job_type" class="form-label">Notice Type</label>
                                        <select id="job_type" name="type_id" id="type_id" class="select2 form-select"
                                            required="required">
                                            <option value="0">Select Notice Type</option>
                                            @foreach ($types as $type)
                                                <option value="{{ $type->id }}"
                                                    {{ isset($notice) && $notice->type_id == $type->id ? 'selected="selected"' : '' }}>
                                                    {{ $type->title }}</option>
                                            @endforeach


                                        </select>
                                    </div>

                                    <div class="mb-3 col-md-12">
                                        <label for="title" class="form-label">notice Name</label>
                                        <input class="form-control" type="text" id="title" name="title"
                                            required="required" value="{{ isset($notice) ? $notice->title : '' }}"
                                            placeholder="notice Name" autofocus="">
                                    </div>


                                    <div class="mb-3 col-md-12">
                                        <label for="permanent_addr" class="form-label">Details</label>
                                        <textarea type="text" class="form-control" id="details" name="details" placeholder="Details">{!! isset($notice) ? $notice->details : '' !!}</textarea>
                                    </div>
                                    {{-- <div class="mb-3 col-md-12 form-group gallery" id="photo_gallery">
                                        <label for="inputPhoto" class="col-form-label">Pdf File <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">

                                            <input id="thumbnail" class="form-control" type="text" name="image"
                                                value="{{ isset($notice) ? $notice->image : '' }}">
                                            <span class="input-group-btn">
                                                <a id="lfm" data-input="thumbnail" data-preview="holder"
                                                    class="btn btn-primary">
                                                    <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                        </div>
                                    </div> --}}
                                    <div class="mb-3 col-md-12 form-group gallery" id="photo_gallery">
                                        <label for="inputPhoto" class="col-form-label">PDF File <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input id="pdfFile" class="form-control" type="file" name="pdf"
                                                accept="application/pdf">
                                            <input type="hidden" name="file_old" id="fileOld"
                                                value="{{ isset($notice) ? $notice->image : '' }}">
                                        </div>
                                        <div id="pdfPreview" class="mt-3" style="display: none;">
                                            <p>PDF Preview:</p>
                                            <iframe id="previewFrame" src="" width="100%" height="500px"
                                                style="border: 1px solid #ccc;"></iframe>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="permanent_addr" class="form-label">Publish Date</label>
                                        <input class="form-control" type="date" id="publish_date" required="required"
                                            name="publish_date" value="{{ isset($notice) ? $notice->publish_date : '' }}"
                                            placeholder="Publish Date" autofocus="">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="permanent_addr" class="form-label">Validity Date</label>
                                        <input class="form-control" type="date" id="validity_date"
                                            required="required" name="validity_date"
                                            value="{{ isset($notice) ? $notice->validity_date : '' }}"
                                            placeholder="Publish Date" autofocus="">
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <div class="btn-group" role="group"
                                            aria-label="Basic radio toggle button group">
                                            <input type="radio" class="btn-check" name="active" id="active1"
                                                value="1" required="required"
                                                {{ isset($notice) && $notice->active == 1 ? 'checked="checked"' : '' }}
                                                autocomplete="off">
                                            <label class="btn btn-outline-primary" for="active1">Active</label>

                                            <input type="radio" class="btn-check" name="active" id="active0"
                                                value="0" required="required"
                                                {{ isset($notice) && $notice->active == 0 ? 'checked="checked"' : '' }}
                                                autocomplete="off">
                                            <label class="btn btn-outline-primary" for="active0">Inactive</label>


                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <div class="btn-group" role="group"
                                            aria-label="Basic radio toggle button group">
                                            <input type="radio" class="btn-check" name="is_notice" id="is_notice1"
                                                value="1" required="required"
                                                {{ isset($notice) && $notice->is_notice == 1 ? 'checked="checked"' : '' }}
                                                autocomplete="off">
                                            <label class="btn btn-outline-primary" for="is_notice1">Notice Yes</label>

                                            <input type="radio" class="btn-check" name="is_notice" id="is_notice0"
                                                value="0" required="required"
                                                {{ isset($notice) && $notice->is_notice == 0 ? 'checked="checked"' : '' }}
                                                autocomplete="off">
                                            <label class="btn btn-outline-primary" for="is_notice0">Notice No</label>


                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                <a type="reset" href="{{ route('notice.index') }}"
                                    class="btn btn-outline-secondary">Cancel</a>
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
    <script src="{{ asset('public/tinymce/js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    <script src="{{ asset('public/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pdfFileInput = document.getElementById('pdfFile');
            const previewDiv = document.getElementById('pdfPreview');
            const previewFrame = document.getElementById('previewFrame');
            const oldFile = document.getElementById('fileOld').value; // Check if old file exists

            // If an old file exists, show the preview
            if (oldFile) {
                previewFrame.src = oldFile; // Set the old file as the iframe's source
                previewDiv.style.display = 'block'; // Show the preview section
            }

            // Handle file input change event
            pdfFileInput.addEventListener('change', function(event) {
                const file = event.target.files[0];

                if (file && file.type === 'application/pdf') {
                    const fileURL = URL.createObjectURL(file); // Create a blob URL for the selected file
                    previewFrame.src = fileURL; // Set the blob URL as the iframe's source
                    previewDiv.style.display = 'block'; // Show the preview section
                } else {
                    alert('Please upload a valid PDF file.');
                    previewDiv.style.display = 'none'; // Hide the preview section if invalid
                }
            });
        });
    </script>


    <script>
        $(function() {
            $('#lfm').filemanager();
            $(document.body).on('change', 'input[name=is_parent]', function() {
                var parent_id = $(this).val();
                var text = $('#title').val();
                ///text=text.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
                text = text.replace(/[_\s]/g, '-').replace(/,/g, '');
                text = text.split(' ').join('_');
                if (parent_id == 0) {
                    $('#slug').val(text.toLowerCase());
                } else {
                    $('#slug').val('#');
                }
            });
            $(document.body).on('change', '#title', function() {
                var text = $(this).val();
                var parent_id = $('input[name=is_parent]:checked').val();
                //text=text.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
                text = text.replace(/[_\s]/g, '-').replace(/,/g, '');
                text = text.split(' ').join('_');
                if (parent_id == 0) {
                    $('#slug').val(text.toLowerCase());
                } else {
                    $('#slug').val('#');
                }

            });
        });
    </script>

    <script>
        var editor_config = {
            path_absolute: "{{ url('/') }}/",
            selector: 'textarea',
            relative_urls: false,
            plugins: 'iframe pageembed code preview anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'iframe | pageembed code preview | undo redo | blocks fontfamily fontsize | bold italic underline strikethrough| link image media | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | link image media',
            tiny_pageembed_classes: [{
                    text: 'Big embed',
                    value: 'my-big-class'
                },
                {
                    text: 'Small embed',
                    value: 'my-small-class'
                }
            ],
            file_picker_callback: function(callback, value, meta) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName(
                    'body')[0].clientWidth;
                var y = window.innerHeight || document.documentElement.clientHeight || document
                    .getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?editor=' + meta.fieldname;
                if (meta.filetype == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.openUrl({
                    url: cmsURL,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: "yes",
                    close_previous: "no",
                    onMessage: (api, message) => {
                        callback(message.content);
                    }
                });
            },
            setup: function(editor) {
                editor.ui.registry.addButton('iframe', {
                    icon: 'media',
                    tooltip: 'Insert iframe',
                    onAction: function(_) {
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
