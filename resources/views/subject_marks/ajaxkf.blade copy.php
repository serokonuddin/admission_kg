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
</style>

<table class="table ">
    <thead>
        <tr>
            <th>SL</th>
            <th>Student</th>
            <th>Roll</th>
            @php
                $max_mark = 50;
                if ($subject_id == 38) {
                    $max_mark = 25;
                    if ($class_code == 0) {
                        $max_mark = 12.5;
                    }
                }
                if ($subject_id == 104) {
                    $max_mark = 12.5;
                }
                if ($subject_id == 39) {
                    $max_mark = 12.5;
                }
                if ($subject_id == 117) {
                    $max_project = 5;
                    $max_work = 15;
                }

            @endphp


            <th style="text-align: center">
                CT 1
            </th>
            <th style="text-align: center">
                CT 2
            </th>
            <th>Total Mark </th>

            <th>GPA Point</th>
            <th>GPA</th>
            <th>Is Absent</th>
        </tr>

    </thead>
    <tbody>
        @foreach ($students as $student)
            @php
                $is_absentclass = $student->subjectwisemark[0]->is_absent ?? 0;
            @endphp
            <tr class="{{ $is_absentclass == 1 ? 'isabsent' : '' }}">
                <td>
                    {{ $loop->index + 1 }}
                    <input type="hidden" value="{{ $student->student_code }}" name="student_code[]" />
                    <input type="hidden" value="{{ $student->version_id }}" name="version_id[]" />
                    <input type="hidden" value="{{ $student->group_id }}" name="group_id[]" />

                </td>
                <td>{{ $student->first_name }}</td>
                <td>{{ $student->roll }}</td>
                @php
                    $total = 0;
                    $subjectmark = $student->subjectwisemark[0] ?? [];
                    // var_dump($subjectmark);
                @endphp


                <td>
                    <input class="form-control marks ct1   text-center " value="{{ $subjectmark->ct1 ?? '' }}"
                        name="ct1{{ $student->student_code }}" id="ct1{{ $student->student_code }}"
                        data-student_code="{{ $student->student_code }}" data-maxvalue="{{ $max_mark }}"
                        data-marks_for="" min="0" type="number">
                </td>
                <td>
                    <input class="form-control marks ct2   text-center " value="{{ $subjectmark->ct2 ?? '' }}"
                        name="ct2{{ $student->student_code }}" id="ct2{{ $student->student_code }}"
                        data-student_code="{{ $student->student_code }}" data-maxvalue="{{ $max_mark }}"
                        data-marks_for="" type="number" min="0">
                </td>
                <td>
                    <input class="form-control marks text-center" readonly=""
                        value="{{ $subjectmark->total ?? '' }}" name="totalmark{{ $student->student_code }}"
                        id="totalmark{{ $student->student_code }}" type="text">
                </td>
                <td>
                    <input class="form-control marks    text-center " readonly=""
                        value="{{ $subjectmark->gpa_point ?? '' }}" name="gpapoint{{ $student->student_code }}"
                        id="gpapoint{{ $student->student_code }}" type="text">
                </td>
                <td>
                    <input class="form-control marks    text-center " readonly=""
                        value="{{ $subjectmark->gpa ?? '' }}" name="gpa{{ $student->student_code }}"
                        id="gpa{{ $student->student_code }}" type="text">
                </td>
                <td>
                    <input class="is_absent" {{ $is_absentclass == 1 ? "checked='checked'" : '' }} value="1"
                        name="is_absent{{ $student->student_code }}" data-student_code="{{ $student->student_code }}"
                        data-maxvalue="{{ $max_mark }}" data-marks_for="" min="0"
                        id="is_absent{{ $student->student_code }}" type="checkbox" />
                </td>
            </tr>
        @endforeach
    </tbody>

</table>
<div class="mb-3  col-md-2">
    <label class="form-label" for="amount"> </label>
    <button type="submit" class="btn btn-primary form-control me-2 mt-1">Save</button>
</div>
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

    function isabsent() {
        $('.isabsent').find('.marks').each(function() {
            // Set the readonly attribute based on the checkbox state

            $(this).prop('readonly', true);


        });
    }
    $(document).ready(function() {
        isabsent();
        $('.is_absent').on('click', function() {
            // Get the checkbox element
            const checkbox = $(this);

            // Determine if the checkbox is checked
            const isReadonly = checkbox.is(':checked');

            // Find the nearest parent row (tr) and only select .obtained and .grace input fields
            checkbox.closest('tr').find('.marks').each(function() {
                // Set the readonly attribute based on the checkbox state

                $(this).prop('readonly', isReadonly);


            });
            checkbox.closest('tr').find('input[type="text"],input[type="number"]').each(function() {
                // Set the readonly attribute based on the checkbox state

                $(this).val('');


            });

            //calculateSums();
        });
    });

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
        let ct1 = parseFloat($('input[name="ct1' + student_code + '"]').val()) ||
            0; // Safeguard against NaN
        let ct2 = parseFloat($('input[name="ct2' + student_code + '"]').val()) || 0;
        let sum1 = ct1 + ct2;

        let convertedSum = sum1; // default, unscaled

        if (parseInt(subject_id) === 38) {
            let divisor = (parseInt(class_code) === 0) ? 25 : 50;
            convertedSum = (sum1 / divisor) * 100;
        }
        if (parseInt(subject_id) === 39) {
            convertedSum = (sum1 / 25) * 100;
        }
        if (parseInt(subject_id) === 104) {
            convertedSum = (sum1 / 25) * 100;
        }

        convertedSum = parseFloat(convertedSum.toFixed(2));

        $('input[name="totalmark' + student_code + '"]').val(sum1);


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
            ct1: $(`input[name='ct1${student_code}']`).val(),
            ct2: $(`input[name='ct2${student_code}']`).val(),
            ct3: '',
            ct4: '',
            ct: '',
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
            ctconv: $(`input[name='ctconv${student_code}']`).val(),
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
    $('input').on('change', calculateSums);
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
