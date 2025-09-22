<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<h4 class="panel-title">{{ $subject->subject_name . '(' . $subject->subject_wise_class->subject_code . ')' }}<span
        style="font-size: 0.8em">: {{ !empty($students) ? count($students) : count($subjectMarks) }} students
        found</span>
</h4>
<style>
    .table-container {
        width: 100%;
        height: 100vh;
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

    /* ------------------- Mobile Responsive ------------------- */
    @media (max-width: 768px) {

        table,
        thead,
        tbody,
        th,
        td,
        tr {
            display: block;
        }

        thead {
            display: none;
        }

        tr {
            margin-bottom: 15px;
            border: 2px solid #1171b1;
            padding: 10px;
            background: #fff;
            border-radius: 8px;
        }

        td {
            text-align: left;
            padding: 8px;
            position: relative;
            border: none;
            border-bottom: 1px solid #eee;
        }

        td::before {
            content: attr(data-label);
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        td input {
            width: 100%;
            padding: 6px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .total_none {
            display: none;
        }

        td:not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(3)):not(:nth-child(4)):not(:nth-child(5)) {
            display: none;
        }

        /* Hide Name and Roll on mobile */
        td:nth-child(2),
        td:nth-child(3) {
            display: none;
        }

        /* Customize SL column to show all 3 items */
        td:nth-child(1)::before {
            content: "SL: " attr(data-sl) "\AName: " attr(data-name) "\ARoll: " attr(data-roll);
            white-space: pre-line;
            font-weight: bold;
            color: #555;
            display: block;
            margin-bottom: 5px;
        }

        .slnone {
            display: none;
        }
    }
</style>

@php
    $max_ct = 20;
    $max_cq = 100;
    if ($subject_id == 39) {
        $max_cq = 25;
    }
@endphp

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Roll</th>
                @if ($subject_id != 39 && $exam_type == 'ct')
                    <th>CA(CT + PT) ({{ $max_ct }})</th>
                @elseif ($exam_type == 'term')
                    <th>Term Exam ({{ $max_cq }})</th>
                @else
                    @if ($subject_id != 39)
                        <th>CA(CT + PT) ({{ $max_ct }})</th>
                    @endif
                    <th>Term Exam ({{ $max_cq }})</th>
                @endif
                <th>Conv 80% of Term Exam</th>
                <th>Total Marks</th>
                <th>Grade Letter</th>
                <th>Grade Point</th>
                <th>Is Absent</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                @php
                    $subjectmark = $student->subjectwisemark[0] ?? [];
                    $is_absentclass = $subjectmark->is_absent ?? 0;
                @endphp
                <tr class="{{ $is_absentclass == 1 ? 'isabsent' : '' }}">
                    <td data-label="SL" data-sl="{{ $loop->index + 1 }}" data-name="{{ strtoupper($student->first_name) }}"
                        data-roll="{{ $student->roll }}">
                        {{-- {{ $loop->index + 1 }} --}}
                        <span class="slnone">{{ $loop->index + 1 }}</span>
                        <input type="hidden" value="{{ $student->student_code }}" name="student_code[]" />
                        <input type="hidden" value="{{ $student->version_id }}" name="version_id[]" />
                        <input type="hidden" value="{{ $student->group_id }}" name="group_id[]" />
                        <input class="form-control marks ct1 text-center" value="{{ $subjectmark->ct1 ?? '' }}"
                            name="ct11{{ $student->student_code }}" id="ct1{{ $student->student_code }}"
                            data-student_code="{{ $student->student_code }}" data-maxvalue="{{ $max_ct }}"
                            type="hidden" min="0">
                        <input class="form-control marks cq text-center" value="{{ $subjectmark->cq ?? '' }}"
                            name="cq2{{ $student->student_code }}" id="cq{{ $student->student_code }}"
                            data-student_code="{{ $student->student_code }}" data-maxvalue="{{ $max_cq }}"
                            type="hidden" min="0">
                    </td>

                    <td data-label="Name">{{ strtoupper($student->first_name) }}</td>
                    <td data-label="Roll">{{ $student->roll }}</td>
                    @if ($subject_id != 39 && $exam_type == 'ct')
                        <td data-label="CA(CT + PT) ({{ $max_ct }})">
                            <input class="form-control marks ct1 text-center" value="{{ $subjectmark->ct1 ?? '' }}"
                                name="ct1{{ $student->student_code }}" id="ct1{{ $student->student_code }}"
                                data-student_code="{{ $student->student_code }}" data-maxvalue="{{ $max_ct }}"
                                type="number" min="0">
                        </td>
                    @elseif ($exam_type == 'term')
                        <td data-label="Term Exam ({{ $max_cq }})">
                            <input class="form-control marks cq text-center" value="{{ $subjectmark->cq ?? '' }}"
                                name="cq{{ $student->student_code }}" id="cq{{ $student->student_code }}"
                                data-student_code="{{ $student->student_code }}" data-maxvalue="{{ $max_cq }}"
                                type="number" min="0">
                        </td>
                    @else
                        @if ($subject_id != 39)
                            <td data-label="CA(CT + PT) ({{ $max_ct }})">
                                <input class="form-control marks ct1 text-center" value="{{ $subjectmark->ct1 ?? '' }}"
                                    name="ct1{{ $student->student_code }}" id="ct1{{ $student->student_code }}"
                                    data-student_code="{{ $student->student_code }}"
                                    data-maxvalue="{{ $max_ct }}" type="number" min="0">
                            </td>
                        @endif
                        <td data-label="Term Exam ({{ $max_cq }})">
                            <input class="form-control marks cq text-center" value="{{ $subjectmark->cq ?? '' }}"
                                name="cq{{ $student->student_code }}" id="cq{{ $student->student_code }}"
                                data-student_code="{{ $student->student_code }}" data-maxvalue="{{ $max_cq }}"
                                type="number" min="0">
                        </td>
                    @endif
                    <td class="total_none" data-label="Conv 80%">
                        <input class="form-control marks text-center" readonly
                            value="{{ $subjectmark->conv_total ?? '' }}" name="conv{{ $student->student_code }}"
                            id="conv{{ $student->student_code }}" type="number">
                    </td>
                    <td data-label="Total Mark">
                        <input class="form-control marks text-center" readonly value="{{ $subjectmark->total ?? '' }}"
                            name="totalmark{{ $student->student_code }}" id="totalmark{{ $student->student_code }}"
                            type="number">
                    </td>
                    <td data-label="GPA">
                        <input class="form-control marks text-center" readonly value="{{ $subjectmark->gpa ?? '' }}"
                            name="gpa{{ $student->student_code }}" id="gpa{{ $student->student_code }}"
                            type="text">
                    </td>
                    <td data-label="GPA Point">
                        <input class="form-control marks text-center" readonly
                            value="{{ $subjectmark->gpa_point ?? '' }}" name="gpapoint{{ $student->student_code }}"
                            id="gpapoint{{ $student->student_code }}" type="number">
                    </td>
                    <td data-label="Is Absent">
                        <input class="is_absent" {{ $is_absentclass == 1 ? "checked='checked'" : '' }} value="1"
                            name="is_absent{{ $student->student_code }}" id="is_absent{{ $student->student_code }}"
                            type="checkbox" />
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- <div class="mb-3  col-md-2">
    <label class="form-label" for="amount"> </label>
    <button type="submit" class="btn btn-primary form-control me-2 mt-1">Save</button>
</div> --}}
<script>
    $(document).ready(function() {
        $('#headerTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });

    var Num = function(n, p = 2) {
        return +(parseFloat(n, 10) || 0).toFixed(p);
    }
    var Val = function($n, v) {
        var $n = $($n);
        return (arguments.length > 1) ? $n.val(Num(v) || '') : Num($n.val());
    }
    var isDefined = function(v) {
        return typeof(v) !== 'undefined';
    }

    $(document).ready(function() {

        function calculateSums() {
            $.LoadingOverlay("show");
            var student_code = $(this).data('student_code');
            var maxvalue = $(this).data('maxvalue');
            var minvalue = $(this).data('minvalue');
            var currentvalue = $(this).val();
            var subject_id = $('#subject_id').val();
            var section_id = $('#section_id').val();
            var class_code = $('#class_code').val();
            var exam_id = $('#exam_id').val();
            var session_id = $('#session_id').val();
            if (maxvalue < currentvalue) {
                $(this).val('');
                Swal.fire({
                    title: "Warning",
                    text: "Over The Maximum Value",
                    icon: "warning"
                });
            }

            // NEW From Rezwan
            let ct1 = parseFloat($('input[name="ct1' + student_code + '"]').val()) || parseFloat($(
                'input[name="ct11' + student_code + '"]').val()) || 0; // Safeguard against NaN
            let cq = parseFloat($('input[name="cq' + student_code + '"]').val()) || parseFloat($(
                'input[name="cq2' + student_code + '"]').val()) || 0;
            let convertedCq = 0;

            if (parseInt(subject_id) !== 39) {
                convertedCq = Math.round(cq * 0.8);
            }

            let convertedSum = 0;

            if (parseInt(subject_id) === 39) {
                convertedSum = (cq / 25) * 100;
                $('input[name="totalmark' + student_code + '"]').val(cq);
            } else {
                convertedSum = ct1 + convertedCq;
                $('input[name="conv' + student_code + '"]').val(convertedCq);
                $('input[name="totalmark' + student_code + '"]').val(convertedSum);
            }




            // Calculate GPA Point based on 19th TD input value and set in 20th TD input
            let gpaPoint = calculateGpaPoint(convertedSum);
            $('input[name="gpapoint' + student_code + '"]').val(gpaPoint);

            // Calculate GPA based on 19th TD input value and set in 21st TD input
            let gpa = calculateGpa(convertedSum);
            $('input[name="gpa' + student_code + '"]').val(gpa);


            var non_value = 0;

            let data = {

                session_id: session_id,
                section_id: section_id,
                exam_id: exam_id,
                subject_id: subject_id,
                class_code: class_code,
                non_value: non_value,
                student_code: student_code,
                "_token": "{{ csrf_token() }}",
                marks_for: [1],
                // Use template literals or proper string concatenation for dynamic names
                ct1: $(`input[name='ct1${student_code}']`).val() || $(`input[name='ct11${student_code}']`)
                    .val(),
                cq1: '',
                cq: $(`input[name='cq${student_code}']`).val() || $(`input[name='cq2${student_code}']`)
                .val(),
                ct3: '',
                ct4: '',
                ct: $(`input[name='ct1${student_code}']`).val() || $(`input[name='ct11${student_code}']`)
                    .val(),
                min1: '',
                min2: '',
                min3: '',

                obtained1: '',
                grace1: '',
                totalmark1: '',

                obtained2: '',
                grace2: '',
                totalmark2: '',

                obtained3: '',
                grace3: '',
                totalmark3: '',

                totalmark: $(`input[name='totalmark${student_code}']`).val(),
                conv: $(`input[name='conv${student_code}']`).val(),
                ctconv: $(`input[name='ct1${student_code}']`).val(),
                gpapoint: $(`input[name='gpapoint${student_code}']`).val(),
                gpa: $(`input[name='gpa${student_code}']`).val(),

                is_absent: $(`input[name='is_absent${student_code}']`).is(':checked') ? 1 : 0
            };


            // AJAX request to send data
            $.ajax({
                url: "{{ route('saveStudentSubjectMark') }}",
                type: 'POST',
                data: data,
                success: function(response) {
                    console.log('Data sent successfully:', response);
                    // Process the response if needed
                    $.LoadingOverlay("hide");
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: "Error",
                        text: error,
                        icon: "warning"
                    });
                    $.LoadingOverlay("hide");
                }
            });
            $.LoadingOverlay("hide");

        }



        // Helper function to calculate GPA Point based on the final marks (example logic)
        function calculateGpaPoint(marks) {
            if (marks >= 80) {
                return 5.0; // A+
            } else if (marks >= 70) {
                return 4.0; // A
            } else if (marks >= 60) {
                return 3.5; // A-
            } else if (marks >= 50) {
                return 3.0; // B
            } else {
                return 0.0; // F
            }
        }

        // Helper function to calculate GPA (example logic)
        function calculateGpa(marks) {
            if (marks >= 80) {
                return 'A+'; // A+
            } else if (marks >= 70) {
                return 'A'; // A
            } else if (marks >= 60) {
                return 'A-'; // A-
            } else if (marks >= 50) {
                return 'B'; // B
            } else {
                return 'F'; // F
            }
        }

        // Attach event listener to relevant input fields
        $('input').on('input', calculateSums);
    });
</script>

<script>
    document.querySelectorAll('input[type="number"]').forEach(input => {
        // Prevent typing minus sign
        input.addEventListener('keydown', function(e) {
            if (e.key === '-' || e.key === 'Minus') {
                e.preventDefault();
            }
        });

        // Clear value if it's negative (in case pasted)
        input.addEventListener('input', function() {
            if (parseFloat(this.value) < 0) {
                this.value = '';
            }
        });
    });
</script>
