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
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Exam Mark Terms</h4>
            <div class="row">
                <div class="col-md-12">

                    <div class="card mb-4">
                        <h5 class="card-header">Exam Mark Terms</h5>
                        <!-- Account -->


                        <div class="card-body">
                            <form id="formAccountSettings" method="POST" action="{{ route('subject_mark_terms.store') }}">



                                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="job_type" class="form-label">Session <span
                                                style="color: red">*</span></label>
                                        <select id="session_id" name="session_id" class=" form-select" required="">

                                            @foreach ($sessions as $session)
                                                <option value="{{ $session->id }}"
                                                    {{ isset($subjectMarkTerm) && $subjectMarkTerm->session_id == $session->id ? 'selected="selected"' : '' }}>
                                                    {{ $session->session_name }}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                    @php
                                        $class_id =
                                            isset($subjectMarkTerm) && $subjectMarkTerm->class_code
                                                ? $subjectMarkTerm->class_code
                                                : null;
                                    @endphp
                                    <div class="mb-3 col-md-6">
                                        <label for="class_code" class="form-label">Class <span
                                                style="color: red">*</span></label>
                                        <select id="class_code" name="class_code" class=" form-select" required="">
                                            <option value="">Select Class</option>

                                            <option value="0" {{ $class_id == 0 ? 'selected="selected"' : '' }}>KG
                                            </option>
                                            <option value="1" {{ $class_id == 1 ? 'selected="selected"' : '' }}>CLass
                                                I
                                            </option>
                                            <option value="2" {{ $class_id == 2 ? 'selected="selected"' : '' }}>CLass
                                                II
                                            </option>
                                            <option value="3" {{ $class_id == 3 ? 'selected="selected"' : '' }}>CLass
                                                III
                                            </option>
                                            <option value="4" {{ $class_id == 4 ? 'selected="selected"' : '' }}>CLass
                                                IV
                                            </option>
                                            <option value="5" {{ $class_id == 5 ? 'selected="selected"' : '' }}>CLass
                                                V
                                            </option>
                                            <option value="6" {{ $class_id == 6 ? 'selected="selected"' : '' }}>CLass
                                                VI
                                            </option>
                                            <option value="7" {{ $class_id == 7 ? 'selected="selected"' : '' }}>CLass
                                                VII
                                            </option>
                                            <option value="8" {{ $class_id == 8 ? 'selected="selected"' : '' }}>CLass
                                                VIII
                                            </option>
                                            <option value="9" {{ $class_id == 9 ? 'selected="selected"' : '' }}>CLass
                                                IX
                                            </option>
                                            <option value="10" {{ $class_id == 10 ? 'selected="selected"' : '' }}>CLass
                                                X
                                            </option>
                                            <option value="11" {{ $class_id == 11 ? 'selected="selected"' : '' }}>CLass
                                                XI
                                            </option>
                                            <option value="12" {{ $class_id == 12 ? 'selected="selected"' : '' }}>CLass
                                                XII
                                            </option>
                                        </select>
                                    </div>


                                </div>

                                <div id="subject-wrapper">
                                    <div class="subject-item">
                                        <div class="row">
                                            <div class="mb-3 col-md-3">
                                                <label for="subject_id" class="form-label">Subject <span
                                                        style="color: red">*</span></label>
                                                <select name="subject_id[]" class=" form-select subject_id" required="">
                                                    <option value="">Select Subject</option>
                                                    @if (isset($subjects))
                                                        @foreach ($subjects as $subject)
                                                            <option value="{{ $subject->id }}"
                                                                {{ isset($subjectMarkTerm) && $subjectMarkTerm->subject_id == $subject->id ? 'selected="selected"' : '' }}>
                                                                {{ $subject->subject_name }}</option>
                                                        @endforeach
                                                    @endif

                                                </select>

                                            </div>
                                            <div class="mb-3 col-md-2">
                                                <label for="exam_for" class="form-label">Mark For <span
                                                        style="color: red">*</span></label>
                                                <select class="form-select" name="marks_for[]" required>
                                                    <option value="0"
                                                        {{ isset($subjectMarkTerm) && $subjectMarkTerm->marks_for == 0 ? 'selected="selected"' : '' }}>
                                                        CT</option>
                                                    <option value="1"
                                                        {{ isset($subjectMarkTerm) && $subjectMarkTerm->marks_for == 1 ? 'selected="selected"' : '' }}>
                                                        CQ</option>
                                                    <option value="2"
                                                        {{ isset($subjectMarkTerm) && $subjectMarkTerm->marks_for == 2 ? 'selected="selected"' : '' }}>
                                                        MCQ</option>
                                                    <option value="3"
                                                        {{ isset($subjectMarkTerm) && $subjectMarkTerm->marks_for == 3 ? 'selected="selected"' : '' }}>
                                                        Practical</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-2">
                                                <label for="total_mark" class="form-label">Total mark <span
                                                        style="color: red">*</span></label>
                                                <input type="number" step="0.1" class="form-control"
                                                    name="total_mark[]" placeholder="Total mark"
                                                    value="{{ isset($subjectMarkTerm) ? $subjectMarkTerm->total_mark : '' }}"
                                                    required>
                                            </div>
                                            <div class="mb-3 col-md-2">
                                                <label for="end_time" class="form-label">Pass mark <span
                                                        style="color: red">*</span></label>
                                                <input type="number" step="0.1" class="form-control" name="pass_mark[]"
                                                    placeholder="Pass mark"
                                                    value="{{ isset($subjectMarkTerm) ? $subjectMarkTerm->pass_mark : '' }}"
                                                    required>
                                            </div>
                                            <div class="mb-3 col-md-2">
                                                <label for="converted_to" class="form-label">Converted To </label>
                                                <input type="number" class="form-control" name="converted_to[]"
                                                    placeholder="Converted To"
                                                    value="{{ isset($subjectMarkTerm) ? $subjectMarkTerm->converted_to : '' }}">
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
                                        <a type="reset" href="{{ route('exams.index') }}"
                                            class="btn btn-outline-secondary">Cancel</a>
                                    </div>
                                    <div class="mb-3 col-md-3">
                                        <button type="button" id="add-more-subjects" class="btn btn-secondary me-2">Add
                                            More Subjects</button>
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
    <script src="{{ asset('public/tinymce/js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    <script src="{{ asset('public/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
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
        $(function() {
            $(document.body).on('change', '#class_code', function() {
                var session_id = $('#session_id').val();
                var class_code = $('#class_code').val();
                $.LoadingOverlay("show");
                if (class_code) {

                    $.ajax({
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: "{{ route('getSubjects') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            class_code
                        },
                        success: function(response) {
                            $('.subject_id').html(response);
                            $.LoadingOverlay("hide");
                        },
                        error: function(data, errorThrown) {
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
