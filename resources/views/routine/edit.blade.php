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
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Route</h4>
            <div class="row">
                <div class="col-md-12">

                    <div class="card mb-4">
                        <h5 class="card-header">Route Update</h5>
                        <!-- Account -->


                        <div class="card-body">

                            <form class="event-form pt-0 fv-plugins-bootstrap5 fv-plugins-framework"
                                action="{{ route('routine.store') }}" method="post" id="eventForm">
                                @csrf
                                <input type="hidden" name="id" id="id" value="{{ $routine->id }}" />
                                <div class="mb-3">
                                    <label class="form-label" for="eventLabel">Routine For</label>
                                    <div class="position-relative">
                                        <select class=" select-event-label form-select select" id="type_for"
                                            name="type_for">
                                            <option value="">Select Routine</option>

                                            <option value="primary"
                                                {{ $routine->type_for == 1 ? 'selected="selected' : '' }}>
                                                Primary</option>
                                            <option value="secondary"
                                                {{ $routine->type_for == 2 ? 'selected="selected' : '' }}>
                                                Secondary</option>
                                            <option value="college"
                                                {{ $routine->type_for == 3 ? 'selected="selected' : '' }}>
                                                College</option>


                                        </select>

                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="eventLabel">Session</label>
                                    <div class="position-relative">
                                        <select class=" select-event-label form-select select" id="session_id"
                                            name="session_id">
                                            <option value="">Select Session</option>
                                            @foreach ($sessiondata as $s)
                                                <option value="{{ $s->id }}"
                                                    {{ $s->id == $routine->session_id ? 'selected="selected"' : '' }}>
                                                    {{ $s->session_name }}</option>
                                            @endforeach

                                        </select>

                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="eventLabel">Version</label>
                                    <div class="position-relative">
                                        <select class=" select-event-label form-select select" id="version_id"
                                            name="version_id">
                                            <option value="">Select Version</option>
                                            @foreach ($versions as $version)
                                                <option value="{{ $version->id }}"
                                                    {{ $version->id == $routine->version_id ? 'selected="selected"' : '' }}>
                                                    {{ $version->version_name }}</option>
                                            @endforeach

                                        </select>

                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="eventLabel">Shift</label>
                                    <div class="position-relative">
                                        <select class=" select-event-label form-select select" id="shift_id"
                                            name="shift_id">
                                            <option value="">Select Shift</option>
                                            @foreach ($shifts as $shift)
                                                <option value="{{ $shift->id }}"
                                                    {{ $shift->id == $routine->shift_id ? 'selected="selected"' : '' }}>
                                                    {{ $shift->shift_name }}</option>
                                            @endforeach

                                        </select>

                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="position-relative">
                                        <label for="class_id" class="form-label">Class</label>
                                        <select id="class_id" name="class_id" class=" form-select" required="">
                                            <option value="">Select Class</option>
                                            <option value="0"
                                                {{ 0 == $routine->class_code ? 'selected="selected"' : '' }}>KG</option>
                                            <option value="1"
                                                {{ 1 == $routine->class_code ? 'selected="selected"' : '' }}>CLass I
                                            </option>
                                            <option value="2"
                                                {{ 2 == $routine->class_code ? 'selected="selected"' : '' }}>CLass II
                                            </option>
                                            <option value="3"
                                                {{ 3 == $routine->class_code ? 'selected="selected"' : '' }}>CLass III
                                            </option>
                                            <option value="4"
                                                {{ 4 == $routine->class_code ? 'selected="selected"' : '' }}>CLass IV
                                            </option>
                                            <option value="5"
                                                {{ 5 == $routine->class_code ? 'selected="selected"' : '' }}>CLass V
                                            </option>
                                            <option value="6"
                                                {{ 6 == $routine->class_code ? 'selected="selected"' : '' }}>CLass VI
                                            </option>
                                            <option value="7"
                                                {{ 7 == $routine->class_code ? 'selected="selected"' : '' }}>CLass VII
                                            </option>
                                            <option value="8"
                                                {{ 8 == $routine->class_code ? 'selected="selected"' : '' }}>CLass VIII
                                            </option>
                                            <option value="9"
                                                {{ 9 == $routine->class_code ? 'selected="selected"' : '' }}>CLass IX
                                            </option>
                                            <option value="10"
                                                {{ 10 == $routine->class_code ? 'selected="selected"' : '' }}>CLass X
                                            </option>
                                            <option value="11"
                                                {{ 11 == $routine->class_code ? 'selected="selected"' : '' }}>CLass XI
                                            </option>
                                            <option value="12"
                                                {{ 12 == $routine->class_code ? 'selected="selected"' : '' }}>CLass XII
                                            </option>

                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="eventLabel">Section</label>
                                    <div class="position-relative">
                                        <select class=" select-event-label form-select select" id="section_id"
                                            name="section_id">
                                            <option value="">Select Section</option>

                                            @foreach ($sections as $section)
                                                <option value="{{ $section->id }}"
                                                    {{ $section->id == $routine->section_id ? 'selected="selected"' : '' }}>
                                                    {{ $section->section_name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="eventLabel">Subject</label>
                                    <div class="position-relative">
                                        <select class=" select-event-label form-select select" id="subject_id"
                                            name="subject_id">
                                            <option value="">Select Subject</option>
                                            @foreach ($subjects as $subject)
                                                <option value="{{ $subject->id }}"
                                                    {{ $subject->id == $routine->subject_id ? 'selected="selected"' : '' }}>
                                                    {{ $subject->subject_name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="eventLabel">Teacher</label>
                                    <div class="position-relative">
                                        <select class=" select-event-label form-select select2" id="employee_id"
                                            name="employee_id">
                                            <option value="">Select Teacher</option>
                                            @foreach ($teachers as $teacher)
                                                <option value="{{ $teacher->id }}"
                                                    {{ $routine->employee_id == $teacher->id ? 'selected="selected"' : '' }}>
                                                    {{ $teacher->employee_name }} ({{ $teacher->designation_name }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="eventLabel">Day</label>
                                    <div class="position-relative">
                                        <select class=" select-event-label form-select select" id="day_name"
                                            name="day_name">
                                            <option value="">Select Day</option>
                                            @foreach ($days as $day)
                                                <option value="{{ $day->day_name }}"
                                                    {{ $routine->day_name == $day->day_name ? 'selected="selected"' : '' }}>
                                                    {{ $day->day_name }}</option>
                                            @endforeach



                                        </select>

                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="eventLabel">Time</label>
                                    <div class="position-relative">
                                        <select class="form-select select-event-label" id="time" name="time">
                                            @php
                                                $selectedTime = $routine->time ?? '';
                                            @endphp

                                            @if ($routine->type_for == 1)
                                                <option value="">Select Time</option>
                                                <option value="07:30 AM-08:10 AM"
                                                    {{ $selectedTime == '07:30 AM-08:10 AM' ? 'selected' : '' }}>07:30
                                                    AM-08:10 AM</option>
                                                <option value="08:10 AM-08:50 AM"
                                                    {{ $selectedTime == '08:10 AM-08:50 AM' ? 'selected' : '' }}>08:10
                                                    AM-08:50 AM</option>
                                                <option value="08:50 AM-09:30 AM"
                                                    {{ $selectedTime == '08:50 AM-09:30 AM' ? 'selected' : '' }}>08:50
                                                    AM-09:30 AM</option>
                                                <option value="08:50 AM-09:20 AM"
                                                    {{ $selectedTime == '08:50 AM-09:20 AM' ? 'selected' : '' }}>08:50
                                                    AM-09:20 AM Tiffin</option>
                                                <option value="09:20 AM-10:00 AM"
                                                    {{ $selectedTime == '09:20 AM-10:00 AM' ? 'selected' : '' }}>09:20
                                                    AM-10:00 AM</option>
                                                <option value="09:30 AM-10:00 AM"
                                                    {{ $selectedTime == '09:30 AM-10:00 AM' ? 'selected' : '' }}>09:30
                                                    AM-10:00 AM Tiffin</option>
                                                <option value="10:00 AM-10:40 AM"
                                                    {{ $selectedTime == '10:00 AM-10:40 AM' ? 'selected' : '' }}>10:00
                                                    AM-10:40 AM</option>
                                                <option value="10:40 AM-11:20 AM"
                                                    {{ $selectedTime == '10:40 AM-11:20 AM' ? 'selected' : '' }}>10:40
                                                    AM-11:20 AM</option>
                                                <option value="12:30 PM-01:10 PM"
                                                    {{ $selectedTime == '12:30 PM-01:10 PM' ? 'selected' : '' }}>12:30
                                                    PM-01:10 PM</option>
                                                <option value="01:10 PM-01:50 PM"
                                                    {{ $selectedTime == '01:10 PM-01:50 PM' ? 'selected' : '' }}>01:10
                                                    PM-01:50 PM</option>
                                                <option value="01:50 PM-02:30 PM"
                                                    {{ $selectedTime == '01:50 PM-02:30 PM' ? 'selected' : '' }}>01:50
                                                    PM-02:30 PM</option>
                                                <option value="02:30 PM-03:00 PM"
                                                    {{ $selectedTime == '02:30 PM-03:00 PM' ? 'selected' : '' }}>02:30
                                                    PM-03:00 PM Tiffin</option>
                                                <option value="03:00 PM-03:40 PM"
                                                    {{ $selectedTime == '03:00 PM-03:40 PM' ? 'selected' : '' }}>03:00
                                                    PM-03:40 PM</option>
                                                <option value="03:40 PM-04:20 PM"
                                                    {{ $selectedTime == '03:40 PM-04:20 PM' ? 'selected' : '' }}>03:40
                                                    PM-04:20 PM</option>
                                            @elseif($routine->type_for == 2)
                                                <option value="">Select Time</option>
                                                <option value="07:30 AM-08:10 AM"
                                                    {{ $selectedTime == '07:30 AM-08:10 AM' ? 'selected' : '' }}>07:30
                                                    AM-08:10 AM</option>
                                                <option value="08:10 AM-08:50 AM"
                                                    {{ $selectedTime == '08:10 AM-08:50 AM' ? 'selected' : '' }}>08:10
                                                    AM-08:50 AM</option>
                                                <option value="08:50 AM-09:30 AM"
                                                    {{ $selectedTime == '08:50 AM-09:30 AM' ? 'selected' : '' }}>08:50
                                                    AM-09:30 AM</option>
                                                <option value="09:30 AM-09:50 AM"
                                                    {{ $selectedTime == '09:30 AM-09:50 AM' ? 'selected' : '' }}>09:30
                                                    AM-09:50 AM</option>
                                                <option value="09:50 AM-10:30 AM"
                                                    {{ $selectedTime == '09:50 AM-10:30 AM' ? 'selected' : '' }}>09:50
                                                    AM-10:30 AM</option>
                                                <option value="10:30 AM-11:00 AM"
                                                    {{ $selectedTime == '10:30 AM-11:00 AM' ? 'selected' : '' }}>10:30
                                                    AM-11:00 AM</option>
                                                <option value="11:00 AM-11:30 AM"
                                                    {{ $selectedTime == '11:00 AM-11:30 AM' ? 'selected' : '' }}>11:00
                                                    AM-11:30 AM</option>
                                                <option value="12:30 PM-01:10 PM"
                                                    {{ $selectedTime == '12:30 PM-01:10 PM' ? 'selected' : '' }}>12:30
                                                    PM-01:10 PM</option>
                                                <option value="01:10 PM-01:50 PM"
                                                    {{ $selectedTime == '01:10 PM-01:50 PM' ? 'selected' : '' }}>01:10
                                                    PM-01:50 PM</option>
                                                <option value="01:50 PM-02:30 PM"
                                                    {{ $selectedTime == '01:50 PM-02:30 PM' ? 'selected' : '' }}>01:50
                                                    PM-02:30 PM</option>
                                                <option value="02:30 PM-03:00 PM"
                                                    {{ $selectedTime == '02:30 PM-03:00 PM' ? 'selected' : '' }}>02:30
                                                    PM-03:00 PM Tiffin</option>
                                                <option value="03:00 PM-03:40 PM"
                                                    {{ $selectedTime == '03:00 PM-03:40 PM' ? 'selected' : '' }}>03:00
                                                    PM-03:40 PM</option>
                                                <option value="03:40 PM-04:10 PM"
                                                    {{ $selectedTime == '03:40 PM-04:10 PM' ? 'selected' : '' }}>03:40
                                                    PM-04:10 PM</option>
                                                <option value="04:10 PM-04:40 PM"
                                                    {{ $selectedTime == '04:10 PM-04:40 PM' ? 'selected' : '' }}>04:10
                                                    PM-04:40 PM</option>
                                            @else
                                                <option value="">Select Time</option>
                                                <option value="08:15 AM-08:30 AM"
                                                    {{ $selectedTime == '08:15 AM-08:30 AM' ? 'selected' : '' }}>08:15
                                                    AM-08:30 AM</option>
                                                <option value="08:30 AM-09:10 AM"
                                                    {{ $selectedTime == '08:30 AM-09:10 AM' ? 'selected' : '' }}>08:30
                                                    AM-09:10 AM</option>
                                                <option value="09:10 AM-09:50 AM"
                                                    {{ $selectedTime == '09:10 AM-09:50 AM' ? 'selected' : '' }}>09:10
                                                    AM-09:50 AM</option>
                                                <option value="09:50 AM-10:30 AM"
                                                    {{ $selectedTime == '09:50 AM-10:30 AM' ? 'selected' : '' }}>09:50
                                                    AM-10:30 AM</option>
                                                <option value="10:30 AM-11:10 AM"
                                                    {{ $selectedTime == '10:30 AM-11:10 AM' ? 'selected' : '' }}>10:30
                                                    AM-11:10 AM</option>
                                                <option value="11:10 AM-11:50 AM"
                                                    {{ $selectedTime == '11:10 AM-11:50 AM' ? 'selected' : '' }}>11:10
                                                    AM-11:50 AM</option>
                                                <option value="11:50 AM-12:30 PM"
                                                    {{ $selectedTime == '11:50 AM-12:30 PM' ? 'selected' : '' }}>11:50
                                                    AM-12:30 PM</option>
                                                <option value="12:30 PM-01:10 PM"
                                                    {{ $selectedTime == '12:30 PM-01:10 PM' ? 'selected' : '' }}>12:30
                                                    PM-01:10 PM</option>
                                                <option value="01:10 PM-01:50 PM"
                                                    {{ $selectedTime == '01:10 PM-01:50 PM' ? 'selected' : '' }}>01:10
                                                    PM-01:50 PM</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>



                                <!-- <div class="mb-3">
                                                     <label class="form-label" for="eventDescription">Start Time</label>
                                                     <input class="form-control" name="start_time" id="start_time" type="time" value="12:04" required="">
                                                  </div>
                                                  <div class="mb-3">
                                                     <label class="form-label" for="eventDescription">End Time</label>
                                                     <input class="form-control" name="end_time" id="end_time" type="time" value="12:04" required="">
                                                  </div> -->
                                <div class="mb-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="is_class_teacher"
                                            id="is_class_teacher"
                                            {{ $routine->is_class_teacher == '01:10 PM-01:50 PM' ? 'checked="checked"' : '' }}
                                            value="1">
                                        <label class="form-check-label" for="english">Is Class Teacher</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="is_main_teacher"
                                            id="is_main_teacher" value="1">
                                        <label class="form-check-label" for="english">Is Main Teacher</label>
                                    </div>
                                </div>
                                <div class="mb-3 d-flex justify-content-sm-between justify-content-start my-4">
                                    <div>
                                        <button type="submit"
                                            class="btn btn-primary btn-add-event me-sm-3 me-1">Update</button>
                                        <button type="reset" class="btn btn-label-secondary btn-cancel me-sm-0 me-1"
                                            data-bs-dismiss="offcanvas">Cancel</button>
                                    </div>

                                </div>
                                <input type="hidden">
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
    <script src="{{ asset('public/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script src="{{ asset('public/tinymce/js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>


    <script>
        $(function() {
            $('#lfm').filemanager('image');


        });



        $(function() {
            $(document.body).on('click', '.type', function() {
                var type = $(this).data('type');

                $('#type').val(type);
                var shift_id = $('input[name="shift_id"]:checked').val();
                var version_id = $('input[name="version_id"]:checked').val();
                $.LoadingOverlay("show");
                var id = $(this).val();
                var url = "{{ route('getTypeWiseClass') }}";
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        type: type,
                        shift_id,
                        version_id
                    },
                    success: function(response) {

                        $('#class_id_search').html(response)
                        $('#routinelist').html('');
                        $.LoadingOverlay("hide");

                    },
                    error: function(data, errorThrown) {
                        Swal.fire({
                            title: "Error",
                            text: errorThrown,
                            icon: "warning"
                        });

                    }
                });
                $('.type' + ' a').removeClass('active');
                $('.' + type + ' a').addClass('active');
            });


            $(document.body).on('change', 'input[type=radio][name=version_id]', function() {


                var type = $('#type_for').val()
                var shift_id = $('input[name="shift_id"]:checked').val();
                var version_id = $('input[name="version_id"]:checked').val();
                $.LoadingOverlay("show");
                var id = $(this).val();
                var url = "{{ route('getTypeWiseClass') }}";
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        type: type,
                        shift_id,
                        version_id
                    },
                    success: function(response) {

                        $('#class_id_search').html(response)
                        $.LoadingOverlay("hide");

                    },
                    error: function(data, errorThrown) {
                        Swal.fire({
                            title: "Error",
                            text: errorThrown,
                            icon: "warning"
                        });

                    }
                });
                $('.type' + ' a').removeClass('active');
                $('.' + type + ' a').addClass('active');
            });

            $(document.body).on('change', 'input[type=radio][name=shift_id]', function() {


                var type = $('#type_for').val()
                var shift_id = $('input[name="shift_id"]:checked').val();
                var version_id = $('input[name="version_id"]:checked').val();
                $.LoadingOverlay("show");
                var id = $(this).val();
                var url = "{{ route('getTypeWiseClass') }}";
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        type: type,
                        shift_id,
                        version_id
                    },
                    success: function(response) {

                        $('#class_id_search').html(response);
                        $('#routinelist').html('');
                        $.LoadingOverlay("hide");

                    },
                    error: function(data, errorThrown) {
                        Swal.fire({
                            title: "Error",
                            text: errorThrown,
                            icon: "warning"
                        });

                    }
                });
                $('.type' + ' a').removeClass('active');
                $('.' + type + ' a').addClass('active');
            });
            $(document.body).on('change', '#class_id_search', function() {
                var id = $(this).val();
                var shift_id = $('input[name="shift_id"]:checked').val();
                var version_id = $('input[name="version_id"]:checked').val();
                var url = "{{ route('getSections') }}";
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
                        version_id
                    },
                    success: function(response) {
                        $.LoadingOverlay("hide");
                        $('#section_id_search').html(response);
                        $('#routinelist').html('');

                    },
                    error: function(data, errorThrown) {
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            title: "Error",
                            text: errorThrown,
                            icon: "warning"
                        });

                    }
                });
            });
            $(document.body).on('change', '#section_id_search', function() {


                var class_id = $('#class_id_search').val();
                var shift_id = $('input[name="shift_id"]:checked').val();
                var version_id = $('input[name="version_id"]:checked').val();
                $.LoadingOverlay("show");
                var section_id = $('#section_id_search').val();
                if (section_id && version_id && shift_id && class_id) {
                    var url = "{{ route('getRoutine') }}";
                    $.ajax({
                        type: "get",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: url,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            shift_id,
                            class_id,
                            section_id,
                            version_id
                        },
                        success: function(response) {
                            $.LoadingOverlay("hide");
                            $('#routinelist').html(response)


                        },
                        error: function(data, errorThrown) {
                            $.LoadingOverlay("hide");
                            Swal.fire({
                                title: "Error",
                                text: errorThrown,
                                icon: "warning"
                            });

                        }
                    });
                } else {
                    $('#studentlist').html('')
                }
                $.LoadingOverlay("hide");
            });
            $(document.body).on('change', '#type_for', function() {
                var value = $(this).val();

                var url = "{{ route('getTime') }}";
                $.ajax({
                    type: "get",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        value
                    },
                    success: function(response) {
                        $.LoadingOverlay("hide");
                        $('#time').html(response)


                    },
                    error: function(data, errorThrown) {
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            title: "Error",
                            text: errorThrown,
                            icon: "warning"
                        });

                    }
                });
            });
            $(document.body).on('change', '#type', function() {


                var type = $('#type_for').val();

                var shift_id = $('#shift_id').val();
                var version_id = $('#version_id').val();
                $.LoadingOverlay("show");
                var id = $(this).val();
                var url = "{{ route('getTypeWiseClass') }}";
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        type: type,
                        shift_id,
                        version_id
                    },
                    success: function(response) {

                        $('#class_id').html(response)

                        $.LoadingOverlay("hide");

                    },
                    error: function(data, errorThrown) {
                        Swal.fire({
                            title: "Error",
                            text: errorThrown,
                            icon: "warning"
                        });

                    }
                });

            });


            $(document.body).on('change', '#version_id', function() {


                var type = $('#type_for').val()
                var shift_id = $('#shift_id').val();
                var version_id = $('#version_id').val();
                $.LoadingOverlay("show");
                var id = $(this).val();
                var url = "{{ route('getTypeWiseClass') }}";
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        type: type,
                        shift_id,
                        version_id
                    },
                    success: function(response) {

                        $('#class_id').html(response)
                        $.LoadingOverlay("hide");

                    },
                    error: function(data, errorThrown) {
                        Swal.fire({
                            title: "Error",
                            text: errorThrown,
                            icon: "warning"
                        });

                    }
                });

            });

            $(document.body).on('change', '#shift_id', function() {


                var type = $('#type_for').val()
                var shift_id = $('#shift_id').val();
                var version_id = $('#version_id').val();
                $.LoadingOverlay("show");
                var id = $(this).val();
                var url = "{{ route('getTypeWiseClass') }}";
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        type: type,
                        shift_id,
                        version_id
                    },
                    success: function(response) {

                        $('#class_id').html(response);

                        $.LoadingOverlay("hide");

                    },
                    error: function(data, errorThrown) {
                        Swal.fire({
                            title: "Error",
                            text: errorThrown,
                            icon: "warning"
                        });

                    }
                });

            });
            $(document.body).on('change', '#class_id', function() {
                var id = $(this).val();
                var shift_id = $('#shift_id').val();
                var version_id = $('#version_id').val();
                var url = "{{ route('getSections') }}";
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
                        version_id
                    },
                    success: function(response) {
                        $.LoadingOverlay("hide");
                        $('#section_id').html(response);

                    },
                    error: function(data, errorThrown) {
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            title: "Error",
                            text: errorThrown,
                            icon: "warning"
                        });

                    }
                });
                if (id) {
                    var url = "{{ route('getSubject') }}";
                    $.ajax({
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                        },
                        url: url,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            class_id: id,
                            version_id
                        },
                        success: function(response) {
                            $.LoadingOverlay("hide");
                            $('#subject_id').html(response);

                        },
                        error: function(data, errorThrown) {
                            $.LoadingOverlay("hide");
                            Swal.fire({
                                title: "Error",
                                text: errorThrown,
                                icon: "warning"
                            });

                        }
                    });
                }

            });
            // $(document.body).on('change','#subject_id',function() {


            //  var type =$('#type_for').val()
            //   var subject_id=$('#subject_id').val();
            //   var shift_id=$('#shift_id').val();
            //   var version_id=$('#version_id').val();
            //   var class_id=$('#class_id').val();
            //   $.LoadingOverlay("show");
            //   var id=$(this).val();
            //       var url="{{ route('getTeachersByPost') }}";
            //       $.ajax({
            //           type: "post",
            //           headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
            //           url: url,
            //           data:{"_token": "{{ csrf_token() }}",type:type,subject_id:subject_id,class_id,shift_id,version_id},
            //           success: function(response){

            //                   $('#employee_id').html(response)

            //                   $.LoadingOverlay("hide");

            //           },
            //           error: function(data, errorThrown)
            //           {
            //               Swal.fire({
            //                   title: "Error",
            //                   text: errorThrown,
            //                   icon: "warning"
            //               });

            //           }
            //       });

            // });
        });
    </script>
@endsection
