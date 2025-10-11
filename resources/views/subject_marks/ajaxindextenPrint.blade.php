<style>
    .table-container {
        width: 100%;
        height: 100vh;
        /* Set height for the scrollable part */
        overflow: auto;
        border: 1px solid #ccc;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: center;
    }

    td:nth-child(1),
    td:nth-child(2),
    td:nth-child(3) {
        position: sticky;
        left: 0;
        background-color: #f2f2f2;
        z-index: 3;
    }

    th:nth-child(1),
    th:nth-child(2),
    th:nth-child(3) {
        position: sticky;
        left: 0;
        background-color: #f2f2f2;
        z-index: 1;
    }

    /* Layer the columns properly */


    /* Optional: Freeze the table header */


    /* Set the width of the table header cells */
    thead {
        position: sticky;
        top: 0;
        background-color: #f2f2f2;
        z-index: 1;
    }

    .table-container input {
        min-width: 80px;
    }

    .none {
        display: none;
    }

    .table-no-bordered th,
    .table-no-bordered td {
        border: 0px solid #fff;
    }
</style>
<style>
    .marksheet-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .marksheet-table th,
    .marksheet-table td {
        border: 1px solid #ccc;
        padding: 6px 8px;
        text-align: center;
        vertical-align: middle;
    }

    .marksheet-table thead {
        background-color: #f1f5f9;
        font-weight: bold;
    }

    .col-sl {
        width: 40px;
    }

    .col-roll {
        width: 60px;
    }

    .col-name {
        width: 250px;
        text-align: left !important;
        padding-left: 10px;
    }

    .col-mark {
        width: 80px;
    }

    .col-remark {
        width: 120px;
    }

    .marksheet-table tbody tr:hover {
        background-color: #f9f9f9;
    }
</style>
<table class="table table-striped table-no-bordered">
    <thead>
        <tr>
            @php
                $classroman = [
                    '0' => 'KG',
                    '1' => 'I',
                    '2' => 'II',
                    '3' => 'III',
                    '4' => 'IV',
                    '5' => 'V',
                    '6' => 'VI',
                    '7' => 'VII',
                    '8' => 'VIII',
                    '9' => 'IX',
                    '10' => 'X',
                    '11' => 'XI',
                    '12' => 'XII',
                    '' => '',
                ];
            @endphp
            <td style="width: 100%;text-align:center">
                <table style="width: 100%;">
                    <tr>
                        <!-- Logo on the left -->
                        <td style="width: 100px; text-align:left; vertical-align: top;">
                            <img style="width: 80px"
                                src="{{ asset('public/frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png') }}" />
                        </td>

                        <!-- School details centered -->
                        <td style="text-align: center;">
                            <h3
                                style="margin: 0px 0px 4px 0px; color:#0484BD; font-size:21px; font-weight:bold; white-space: nowrap;">
                                BAF Shaheen College Dhaka
                            </h3>
                            <span style="font-size:14px;">
                                Dhaka Cantonment, Dhaka-1206
                            </span>
                            <br />
                            <span style="text-align:center; margin-top: 0px; margin-bottom: 0px; font-size:14px;">
                                {{-- {{$subject->subject_name.'('.$subject->subject_wise_class->subject_code.')'}}<span style="font-size: 0.8em">: {{(!empty($students))?count($students):count($subjectMarks)}} students found --}}
                                Exam:&nbsp;{{ $exam->exam_title }} - {{ $exam->session->session_name }}
                                <br />
                                Class: {{ $classroman[$exam->class_code] }} &nbsp; Section: {{ $section->section_name }}
                                <br />
                                {{-- Exam: {{$exam->exam_title}} (Class {{$classroman[$exam->class_code]}}) --}}
                                Shift: {{ $students[0]->shift_name ?? 'N/A' }} &nbsp; Version:
                                {{ $students[0]->version_name ?? 'N/A' }} &nbsp;
                                <br />
                            </span>
                            {{-- <span style="text-align: left;font-size:14px;">Subject:</span> --}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 100%;">
                <table style="width: 100%;">
                    <tr>
                        <td style="text-align: left; font-size: 14px; widht: 50%;">
                            Subject:
                        </td>
                        <td style="text-align: left; font-size: 14px; width: 50%;">
                            Subject Teacher:
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </thead>
</table>
<table class="marksheet-table">
    <thead>
        <tr>
            <th class="col-sl" rowspan="2">SL</th>
            <th class="col-roll" rowspan="2">Roll</th>
            <th class="col-name" rowspan="2">Name</th>
            @php
                $max_mark = 25;
                if ($subject_id == 117) {
                    $max_project = 5;
                    $max_work = 15;
                }
            @endphp
            <th class="col-mark" colspan="4">Evaluation Test / Pre Test</th>
            <th class="col-mark" colspan="4">Evaluation Test / Test</th>
        </tr>
        <tr>
            <th class="col-mark">MCQ</th>
            <th class="col-mark">CQ</th>
            <th class="col-remark">Practical</th>
            <th class="col-mark">Total</th>
            <th class="col-mark">MCQ</th>
            <th class="col-mark">CQ</th>
            <th class="col-remark">Practical</th>
            <th class="col-mark">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($students as $student)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $student->roll }}</td>
                <td class="col-name" style="text-align: left">{{ strtoupper($student->first_name) }}</td>
                @php
                    $total = 0;
                    $subjectmark = $student->subjectwisemark[0] ?? [];
                @endphp
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endforeach
    </tbody>

</table>
<!-- Teacher Signature and Date -->
<!-- Teacher Signature and Date -->
<table style="width: 100%; margin-top: 250px; border-collapse: collapse;">
    <tr>
        <td style="width: 60%; border: none; background: none;"></td>
        <td style="text-align: left; font-size: 14px; padding-right: 30px; border: none; background: none;">
            Teacher's Signature:
        </td>
    </tr>
    <tr>
        <td style="width: 60%; border: none; background: none;"></td>
        <td style="text-align: left; font-size: 14px; padding-right: 30px; border: none; background: none;">
            Date:
        </td>
    </tr>
</table>
