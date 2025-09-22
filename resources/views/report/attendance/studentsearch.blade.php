<style type="text/css">
    .absent {
        background-color: bisque !important;
    }

    .leave {
        background-color: rgb(205, 251, 178) !important;
    }

    .late {
        background-color: rgb(255, 255, 0) !important;
    }

    .missing {
        background-color: #ef6b6e !important;
    }

    .table {
        border: 1px solid #3D70A6 !important;
    }

    .table-responsive {
        padding: 10px !important;
    }

    .table>:not(caption)>*>* {
        padding: 0.125rem 1.25rem !important;
    }
</style>
@php
    $data = collect($students)->groupBy('status');

@endphp
<table class="table ">
    @if ($classteacher)
        <tr>
            <td>Teacher Name:</td>
            <td>{{ $classteacher->employee_name ?? '' }}</td>
            <td>Designations:</td>
            <td>{{ $classteacher->designation_name ?? '' }}</td>
        </tr>
        <tr>
            <td>Mobile:</td>
            <td>{{ $classteacher->mobile ?? '' }}</td>
            <td>Email:</td>
            <td>{{ $classteacher->email ?? '' }}</td>
        </tr>
    @endif
    <tr>
        <td>Present:</td>
        <td>{{ isset($data[1]) ? count($data[1]) : 0 }}</td>
        <td>Absent:</td>
        <td>{{ isset($data[2]) ? count($data[2]) : 0 }}</td>
    </tr>
    <tr>
        <td>Leave:</td>
        <td>{{ isset($data[3]) ? count($data[3]) : 0 }}</td>
        <td>Late:</td>
        <td>{{ isset($data[4]) ? count($data[4]) : 0 }}</td>
    </tr>
    <tr>
        <td>Missing:</td>
        <td>{{ isset($data[5]) ? count($data[5]) : 0 }}</td>
    </tr>

</table>
<table class="table">
    <thead>
        <tr>
            <th>SL.</th>
            <th style="width: 10%">Roll</th>
            <th style="width: 20%;word-wrap: break-word;">Student Name</th>
            <th style="width: 13%">Session</th>
            <th style="width: 12%">Version</th>
            <th style="width: 12%">Class</th>
            <th style="width: 13%">Section</th>

            <th style="width: 10%">Time</th>
            <th style="width: 10%">Status</th>
        </tr>
    </thead>
    <tbody class="table-border-bottom-0">
        @foreach ($students as $student)
            <tr
                class="{{ isset($student->status) && $student->status == 2 ? 'absent' : '' }} {{ isset($student->status) && $student->status == 3 ? 'leave' : '' }} {{ isset($student->status) && $student->status == 4 ? 'late' : '' }} {{ isset($student->status) && $student->status == 5 ? 'missing' : '' }}">

                <td>{{ $loop->iteration }}</td>
                <td>{{ $student->roll }}</td>
                <td style="word-wrap: break-word;" data-bs-toggle="modal" data-bs-target="#fullscreenModal"
                    class="studentdetails" data-student_code="{{ $student->student_code }}">
                    <img src="{{ asset('public/backend') }}/assets/img/avatars/5.png" alt="Avatar"
                        class="rounded-circle avatar avatar-xs">
                    <span>{{ $student->first_name . ' ' . $student->last_name }}</span>
                </td>
                <td>
                    {{ $student->session_name }}
                </td>
                <td>
                    {{ $student->version_name }}
                </td>
                <td>
                    {{ $student->class_name }}
                </td>
                <td>
                    {{ $student->section_name }}
                </td>
                <td style="word-wrap: break-word;">

                    {{ isset($student->time) ? date('H:i', strtotime($student->time)) : '' }}
                </td>
                <td style="text-align: center">

                    {{ isset($student->status) && $student->status == 1 ? 'Present' : '' }}
                    {{ isset($student->status) && $student->status == 2 ? 'absent' : '' }}
                    {{ isset($student->status) && $student->status == 3 ? 'leave' : '' }}
                    {{ isset($student->status) && $student->status == 4 ? 'Late' : '' }}
                    {{ isset($student->status) && $student->status == 5 ? 'Missing' : '' }}
                    @if (isset($student->status) && $student->status == 3)
                        <br />
                        <a href="{{ asset('Leave_bangla.png') }}" data-bs-toggle="modal"
                            data-bs-target="#fullscreenModal"><i class="fa fa-file"></i></a>
                    @endif
                </td>

            </tr>
        @endforeach

    </tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="fullscreenModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFullTitle">Student Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="studentprofile" style="background-color: #f5f2f2">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Close
                </button>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $(document.body).on('click', '.studentdetails', function() {
            $.LoadingOverlay("show");
            var student_code = $(this).data('student_code');
            var url = "{{ route('getStudentDetails') }}";
            $.ajax({
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                },
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}",
                    student_code
                },
                success: function(response) {
                    $.LoadingOverlay("hide");
                    $('#studentprofile').html(response)


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
            $.LoadingOverlay("hide");
        });
    });
</script>
