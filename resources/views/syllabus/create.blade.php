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
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('syllabus.index') }}">Syllabus</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"> Create </li>

                </ol>
            </nav>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header shadow-sm mb-3 bg-gray text-white">Create Syllabus</div>
                        <div class="card-body">
                            <form id="form" method="POST" action="{{ route('syllabus.store') }}"
                                enctype="multipart/form-data">
                                <input type="hidden" value="{{ isset($syllabus) ? $syllabus->id : '' }}" name="id" />
                                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            @php
                                                $session_id =
                                                    isset($syllabus) && !is_null($syllabus->session_id)
                                                        ? $syllabus->session_id
                                                        : old('session_id') ?? '';
                                            @endphp
                                            <div class="col-sm-3">
                                                <select id="session_id" name="session_id" class=" form-select"
                                                    required="">
                                                    <option value="">Select Session</option>
                                                    @foreach ($sessions as $session)
                                                        <option value="{{ $session->id }}"
                                                            {{ $session_id == $session->id ? 'selected="selected"' : '' }}>
                                                            {{ $session->session_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @php
                                                $version_id =
                                                    isset($syllabus) && !is_null($syllabus->version_id)
                                                        ? $syllabus->version_id
                                                        : old('version_id') ?? '';
                                            @endphp
                                            <div class="col-sm-3">
                                                <select id="version_id" name="version_id" class=" form-select"
                                                    required="">
                                                    <option value="">Select Version</option>
                                                    @foreach ($versions as $version)
                                                        <option value="{{ $version->id }}"
                                                            {{ $version_id == $version->id ? 'selected="selected"' : '' }}>
                                                            {{ $version->version_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @php
                                                $shift_id =
                                                    isset($syllabus) && !is_null($syllabus->shift_id)
                                                        ? $syllabus->shift_id
                                                        : old('shift_id') ?? '';
                                            @endphp
                                            <div class="col-sm-3">
                                                <select id="shift_id" name="shift_id" class=" form-select">
                                                    <option value="">Select Shift</option>
                                                    @foreach ($shifts as $shift)
                                                        <option value="{{ $shift->id }}"
                                                            {{ $shift_id == $shift->id ? 'selected="selected"' : '' }}>
                                                            {{ $shift->shift_name }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            <div class="mb-3 col-sm-3">
                                                <select id="group_id" name="group_id" class=" form-select">
                                                    <option value="">Select Group</option>
                                                    @foreach ($groups as $group => $group_name)
                                                        <option value="{{ $group }}">
                                                            {{ $group_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @php
                                                $class_id =
                                                    isset($syllabus) && !is_null($syllabus->class_code)
                                                        ? $syllabus->class_code
                                                        : old('class_code') ?? '';
                                            @endphp
                                            <div class="mb-3 col-sm-3">
                                                <select id="class_code" name="class_code" class=" form-select"
                                                    required="">
                                                    <option value="">Select Class</option>
                                                    @foreach ($classes as $class_code => $class_name)
                                                        <option value="{{ $class_code }}"
                                                            {{ $class_id == $class_code ? 'selected="selected"' : '' }}>
                                                            {{ $class_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @php
                                                $subject_id =
                                                    isset($syllabus) && $syllabus
                                                        ? $syllabus->subject_id
                                                        : old('subject_id');
                                            @endphp
                                            <div class="mb-3 col-sm-3">
                                                <select id="subject_id" name="subject_id" class=" form-select">
                                                    <option value="">Select Subject</option>
                                                    @foreach ($subjects as $subject)
                                                        <option value="{{ $subject->id }}"
                                                            {{ $subject_id == $subject->id ? 'selected="selected"' : '' }}>
                                                            {{ $subject->subject_name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 col-md-12">
                                        <label for="permanent_addr" class="form-label">Details</label>
                                        <textarea type="text" class="form-control" id="details" name="details" placeholder="Details">{!! isset($syllabus) ? $syllabus->details : '' !!}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="pdf" class="form-label">PDF File <span
                                                class="text-danger">*</span></label>
                                        <input type="file" class="form-control" accept=".pdf" id="pdf"
                                            name="pdf">
                                        @if (isset($syllabus) && $syllabus->pdf)
                                            <p class="mt-2">Current File:
                                                <a href="{{ asset($syllabus->pdf) }}" target="_blank" class="text-danger">
                                                    <i class="fa-solid fa-file-pdf"></i> View PDF
                                                </a>
                                            </p>
                                        @endif
                                    </div>

                                    <div class="mb-3 col-md-4">
                                        <div class="btn-group" role="group"
                                            aria-label="Basic radio toggle button group">
                                            <input type="radio" class="btn-check" name="active" id="active1"
                                                value="1" required="required"
                                                {{ isset($syllabus) && $syllabus->active == 1 ? 'checked="checked"' : '' }}
                                                autocomplete="off">
                                            <label class="btn btn-outline-primary" for="active1">Active</label>

                                            <input type="radio" class="btn-check" name="active" id="active0"
                                                value="0" required="required"
                                                {{ isset($syllabus) && $syllabus->active == 0 ? 'checked="checked"' : '' }}
                                                autocomplete="off">
                                            <label class="btn btn-outline-primary" for="active0">Inactive</label>
                                        </div>
                                    </div>

                                </div>

                                <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                <a type="reset" href="{{ route('syllabus.index') }}"
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
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 1500
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
                showConfirmButton: true
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validation Errors',
                html: '<ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>',
                showConfirmButton: true
            });
        @endif
    </script>
    <script>
        $(function() {
            $(document.body).on('change', '#class_code', function() {
                var id = $(this).val();
                var shift_id = $('#shift_id').val();
                var group_id = $('#group_id').val();
                var version_id = $('#version_id').val();
                var session_id = $('#session_id').val();
                var url = "{{ route('getClassWiseSubjects') }}";
                $.LoadingOverlay("show");
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        class_id: id,
                        shift_id,
                        group_id,
                        session_id,
                        version_id
                    },
                    success: function(response) {
                        $('#subject_id').html(response);
                    },
                    error: function(data, errorThrown) {

                        Swal.fire({
                            title: "Error",
                            text: errorThrown,
                            icon: "warning"
                        });

                    },
                    complete: function() {
                        $.LoadingOverlay("hide");
                    }
                });
            });
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
        $(function() {});
    </script>
@endsection
