<div class="mb-3 col-md-6">
    <div class="col-md">
        @php

            // dd($comsubjects);
            // dd($groupsubjects);
            // dd($optionalsubjects);
            // dd($fourthsubjects);
            // dd($group_id);
            // dd($class_code);

            $colors = [
                'primary',
                'secondary',
                'success',
                'danger',
                'warning',
                'info',
                'primary',
                'secondary',
                'success',
                'danger',
                'warning',
                'info',
                'primary',
                'secondary',
                'success',
                'danger',
                'warning',
                'info',
                'primary',
                'secondary',
                'success',
                'danger',
                'warning',
                'info',
                'primary',
                'secondary',
                'success',
                'danger',
                'warning',
                'info',
            ];
            $i = 0;
        @endphp
        <label for="disabledRange" class="form-label" style="font-weight: bold">Compulsory Subjects</label>
        @foreach ($comsubjects as $key => $subject)
            @php
                $ids = '';
                foreach ($subject as $kye => $sub) {
                    if ($kye == 0) {
                        $ids = $sub->id;
                    } else {
                        $ids = $ids . '-' . $sub->id;
                    }
                }

            @endphp
            <input type="hidden" name="mainsubject[]" value="{{ $ids }}">
            <div class="form-check form-check-{{ $colors[0] }} ">
                <input class="form-check-input" type="radio" value="{{ $ids }}" id="customRadioPrimary"
                    checked="">
                <label class="form-check-label" for="customRadio{{ $colors[0] }}">
                    {{ $key }} </label>
            </div>
        @endforeach
        @if ($group_id != 2)
            <label for="disabledRange" class="form-label" style="font-weight: bold">Group Subjects</label>
            @foreach ($groupsubjects as $key => $subject)
                @php
                    $ids = '';
                    foreach ($subject as $kye => $sub) {
                        if ($kye == 0) {
                            $ids = $sub->id;
                        } else {
                            $ids = $ids . '-' . $sub->id;
                        }
                    }
                @endphp
                <input type="hidden" name="mainsubject[]" value="{{ $ids }}">
                <div class="form-check form-check-{{ $colors[4] }} ">
                    <input class="form-check-input" type="radio" value="{{ $ids }}" id="customRadioPrimary"
                        checked="">
                    <label class="form-check-label" for="customRadio{{ $colors[4] }}">
                        {{ $key }} </label>
                </div>
            @endforeach
        @endif
    </div>
</div>
<div class="mb-3 col-md-6">
    <span style="font-size: .80rem;font-weight: bold;">Select 3rd Subject(s)</span>
    @foreach ($optionalsubjects as $key => $subject)
        @php
            $ids = [];
            $pair = [];
            foreach ($subject as $kye => $sub) {
                if ($kye == 0) {
                    $ids[0] = $sub->id;
                    $pair[0] = $sub->pair;
                } else {
                    $ids[1] = $sub->id;
                    $pair[1] = $sub->pair;
                }
            }

            if ($pair) {
                sort($pair);
                $pair = implode('-', $pair);
            }
            if ($ids) {
                sort($ids);
                $ids = implode('-', $ids);
            }

            if (isset($group_id) && in_array($group_id, [1, 3])) {
                $text = 'radio';
            } else {
                $text = 'checkbox';
            }

            if (isset($student_third_subject[$key])) {
                $checked = 'checked="checked"';
            } else {
                $checked = '';
            }
        @endphp
        <div class="form-check form-check-{{ $colors[2] }} ">
            <input class="form-check-input third_subject subject{{ $pair }}" type="{{ $text }}"
                name="third_subject[]" data-pair="{{ $pair }}" value="{{ $ids }}"
                id="customRadio{{ $colors[$i] }}" {{ $checked }}>
            <label class="form-check-label" for="customRadio{{ $colors[2] }}">
                {{ $key }}
            </label>
        </div>
    @endforeach
    <span style="font-size: .80rem;font-weight: bold;">Select 4th Subject</span>
    @php
        $pre_pair1 = '';
        $pre_pair2 = '';
    @endphp
    @foreach ($fourthsubjects as $key => $subject)
        @php
            $ids = [];
            $pair = [];
            foreach ($subject as $kye => $sub) {
                if ($kye == 0) {
                    $pre_pair1 = $sub->id;
                    $ids[0] = $sub->id;
                    $pair[0] = $sub->pair;
                } else {
                    $pre_pair2 = $sub->id;
                    $ids[1] = $sub->id;
                    $pair[1] = $sub->pair;
                }
            }

            if ($pair) {
                sort($pair);
                $pair = implode('-', $pair);
            }
            if ($ids) {
                sort($ids);
                $ids = implode('-', $ids);
            }
            if (isset($student_fourth_subject[$key])) {
                $checked = 'checked="checked"';
            } else {
                $checked = '';
            }
        @endphp
        <div class="form-check form-check-{{ $colors[3] }} ">
            <input class="form-check-input fourth_subject subject{{ $pair }}" type="radio"
                name="fourth_subject[]" value="{{ $ids }}" data-pair="{{ $pair }}"
                id="subject{{ $colors[$i] }}" {{ $checked }}>
            <label class="form-check-label" for="subject{{ $colors[3] }}">
                {{ $key }}
            </label>
        </div>
    @endforeach
</div>
@if ($group_id == 1)
    <div class="mb-3 col-md-10">
        <label for="first_name" class="form-label bn-node">N.B.</label><br>
        <label for="first_name" class="form-label nb">* If 3rd subject is Biology,
            EDS
            cannot be taken as the 4th subject</label><br>
        @if ($group_id == 1)
            <label for="first_name" class="form-label nb">* If 3rd subject is
                Higher Math,
                Psychology cannot be taken as the 4th subject</label><br>
        @endif
        <label for="first_name" class="form-label nb">* If 3rd subject is Biology,
            Statistics cannot be taken as the 4th subject</label><br>
    </div>
@elseif($group_id == 2)
    <div class="mb-3 col-md-10">
        <label for="first_name" class="form-label bn-node">N.B.</label><br>
        <label for="first_name" class="form-label nb">* ৩য় বিষয় হিসেবে IHC/ECO,
            GEO/LOGIC এবং CGG/SW থেকে ৩টি বিষয় নির্বাচন করতে হবে।</label><br>
        <label for="first_name" class="form-label nb">* ৩য় বিষয় হিসেবে LOGIC
            নির্বাচন
            করলে ৪র্থ বিষয় হিসেবে Agri নির্বাচন করা যাবে না।</label>
    </div>
@endif
<div class="col-12 d-flex justify-content-between">
    <button type="button" class="btn btn-primary btn-prev">
        <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
        <span class="align-middle d-sm-inline-block d-none Previous" data-next="academicinfo"
            data-currentdata="personal-info" data-target="#academic-info">Previous</span>
    </button>
    <button style="margin-left: 60%;" type="button" data-value="force" data-pre="academicinfo"
        data-target="#academic-info" class="btn btn-info" id="saveButton">
        <span class="align-right d-sm-inline-block d-none me-sm-1">Save</span>
    </button>
    <button type="button" data-value="desiredsubject" data-currentdata="desiredsubject" data-pre="academic-info"
        data-target="#social-links" class="btn btn-primary btn-next" id="nextButton">
        <span class="align-middle d-sm-inline-block d-none me-sm-1">
            Next</span>
        <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
    </button>
</div>


<script>
    $('.form-check-input.third_subject').change(function() {
        var checkvalue = $(this).val();

        var pair = $(this).data('pair');
        var third_subject = [];
        var third_pair_subject = [];
        var pre_pair = 'na';
        $('.form-check-input.third_subject:checked').each(function() {
            // alert(pre_pair,$(this).val());
            if (pre_pair == $(this).val()) {
                $(this).prop("checked", false);
                Swal.fire({
                    title: "Error",
                    text: "Subject Mismatch",
                    icon: "warning"
                });
                return false;
            } else {
                pre_pair = $(this).data('pair');
            }

            third_subject.push($(this).val());

        });

        var fourth_pair_subject = [];
        var check = 0;
        $('.form-check-input.fourth_subject:checked').each(function() {

            if ($(this).val() == checkvalue || (checkvalue == '67-68' && $(this).val() ==
                    '82-90')) {
                Swal.fire({
                    title: "warning",
                    text: "Subject Mismatch",
                    icon: "warning"
                });
                $(this).prop("checked", false);
            } else if (checkvalue == '89-98' && $(this).val() == '73-74') {
                check = 1;
            }

        });
        if (check == 1) {
            $(this).prop("checked", false);
            Swal.fire({
                title: "warning",
                text: "Subject Mismatch",
                icon: "warning"
            });
            return false;
        }
        var fourth_subject = [];
        $('.form-check-input.fourth_subject:checked').each(function() {
            fourth_subject.push($(this).val());

        });
        console.log(pair, fourth_subject);

        // third to array
        if ($.inArray(pair, fourth_subject) >= 0) {
            $('.subject' + pair).prop("checked", false);
            Swal.fire({
                title: "Error",
                text: "Subject Mismatch",
                icon: "warning"
            });
            return false;
        }
        $('.form-check-input.third_subject:checked').each(function() {
            third_subject.push($(this).val());

        });


        var url = "{{ route('checksection') }}";

        var gender = $('#gender').val();
        if (fourth_subject.length > 0 && third_subject.length > 0 && gender != '' && gender !=
            null) {

            var class_id = $('#class_id').val();
            var session_id = $('#session_id').val();
            var version_id = $('#version_id').val();
            var group_id = $('#group_id').val();

            var roll = $('#roll').val();
            @if (Auth::user()->group_id == 4)
                $.LoadingOverlay("show");
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        gender,
                        fourth_subject,
                        third_subject,
                        student_code: roll,
                        class_id,
                        session_id,
                        version_id,
                        group_id
                    },
                    success: function(response) {

                        $.LoadingOverlay("hide");

                        $('#section_id').val(response);


                    },
                    error: function(data, errorThrown) {
                        handleError(data, errorThrown);

                    },
                    complete: function() {
                        $.LoadingOverlay("hide");
                    }
                });
            @endif
        }
    });

    $('.form-check-input.fourth_subject').change(function() {
        var checkvalue = $(this).val();
        var pair = $(this).data('pair');
        var fourth_subject = [];
        $('.form-check-input.fourth_subject:checked').each(function() {
            fourth_subject.push($(this).val());

        });

        var check = 0;
        $('.form-check-input.third_subject:checked').each(function() {

            if ($(this).val() == checkvalue) {
                Swal.fire({
                    title: "Error",
                    text: "Subject Mismatch",
                    icon: "warning"
                });
                $(this).prop("checked", false);
            } else if (checkvalue == '73-74' && $(this).val() == '89-98') {
                check = 1;
            }
        });
        if (check == 1) {
            $(this).prop("checked", false);
            Swal.fire({
                title: "Error",
                text: "Subject Mismatch",
                icon: "warning"
            });
            return false;
        }
        var third_subject = [];
        $('.form-check-input.third_subject:checked').each(function() {
            third_subject.push($(this).val());

        });
        // fourth to array
        console.log(pair, third_subject);
        if ($.inArray(pair, third_subject) >= 0) {

            $('.subject' + pair).prop("checked", false);
            Swal.fire({
                title: "Error",
                text: "Subject Mismatch",
                icon: "warning"
            });
            return false;
        }

        $('.form-check-input.fourth_subject:checked').each(function() {
            fourth_subject.push($(this).val());

        });
        var gender = $('#gender').val();


        var url = "{{ route('checksection') }}";

        if (fourth_subject.length > 0 && third_subject.length > 0 && gender != '' && gender !=
            null) {

            var class_id = $('#class_id').val();
            var session_id = $('#session_id').val();
            var version_id = $('#version_id').val();
            var group_id = $('#group_id').val();
            var roll = $('#roll').val();
            @if (Auth::user()->group_id == 4)
                $.LoadingOverlay("show");
                $.ajax({
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        gender,
                        fourth_subject,
                        third_subject,
                        student_code: roll,
                        class_id,
                        session_id,
                        version_id,
                        group_id
                    },
                    success: function(response) {

                        $.LoadingOverlay("hide");

                        $('#section_id').val(response);


                    },
                    error: function(data, errorThrown) {
                        handleError(data, errorThrown);

                    },
                    complete: function() {
                        $.LoadingOverlay("hide");
                    }
                });
            @endif
        }
    });

    function checksection() {

        var third_subject = [];
        $('.form-check-input.third_subject:checked').each(function() {
            third_subject.push($(this).val());

        });
        var fourth_subject = [];
        $('.form-check-input.fourth_subject:checked').each(function() {
            fourth_subject.push($(this).val());
        });

        var gender = $('#gender').val();
        var url = "{{ route('checksection') }}";
        if (fourth_subject.length > 0 && third_subject.length > 0 && gender != '' && gender != null) {

            var class_id = $('#class_code').val();
            var session_id = $('#session_id').val();
            var version_id = $('#version_id').val();
            var group_id = $('#group_id').val();

            var roll = $('#roll').val();
            $.LoadingOverlay("show");
            $.ajax({
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                },
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}",
                    gender,
                    fourth_subject,
                    third_subject,
                    student_code: roll,
                    class_id,
                    session_id,
                    version_id,
                    group_id
                },
                success: function(response) {
                    $.LoadingOverlay("hide");
                    $('#section_id').val(response);
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
    }
</script>
