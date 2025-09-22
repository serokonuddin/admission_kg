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

    @media screen and (max-width: 600px) {
        .wrap-text {
            word-wrap: break-word;
            white-space: normal;
            width: 100px !important;
        }
    }
</style>
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
    function getPoint($marks, $isnegative)
    {
        if ($isnegative == -1) {
            return 0;
        }
        if ($marks >= 80) {
            return 5.0; // A+
        } elseif ($marks >= 70) {
            return 4.0; // A
        } elseif ($marks >= 60) {
            return 3.5; // A-
        } elseif ($marks >= 50) {
            return 3.0; // B
        } elseif ($marks >= 40) {
            return 2.0; // C
        } elseif ($marks >= 33) {
            return 1.0; // D
        } else {
            return 0.0; // F
        }
    }
    function getGrade($point, $isnegative)
    {
        if ($isnegative == -1) {
            return 'F';
        }
        if ($point >= 5) {
            return 'A+';
        } elseif ($point >= 4 && $point < 5) {
            return 'A';
        } elseif ($point >= 3.5 && $point < 4) {
            return 'A-';
        } elseif ($point >= 3 && $point < 3.5) {
            return 'B';
        } elseif ($point >= 2 && $point < 3) {
            return 'C';
        } elseif ($point >= 1 && $point < 2) {
            return 'D';
        } else {
            return 'F';
        }
    }
@endphp
<input type="hidden" id="percentage" name="percentage" value="{{ $class_percentage?->percentage }}" />
<input type="hidden" value="1" name="non_value" />
<table class="table ">
    <thead>
        <tr>
            <th>SL</th>
            <th class="wrap-text">Student</th>
            <th>Roll</th>
            @php
                $max_assigment = 10;
                $max_project = 10;
                $max_work = 10;
                if ($subject_id == 117) {
                    $max_project = 5;
                    $max_work = 15;
                }
                $total_mark = 0;
                $pass_mark = 0;
            @endphp
            @foreach ($subject->subjectMarkTerms as $term)
                @php

                    $total_mark += $term->total_mark;
                    $pass_mark += $term->pass_mark;
                @endphp

                <th style="text-align: center">

                    @if ($term->marks_for != 0)
                        <input type="hidden" value="{{ $term->marks_for }}" name="marks_for[]" />
                        <input type="hidden" value="{{ $term->pass_mark }}" name="pass_mark[]"
                            id="marks_for_pass{{ $term->marks_for }}" />
                    @endif
                    @if ($term->marks_for == 0)
                        Obtained Mark
                    @elseif($term->marks_for == 1)
                        CQ
                    @elseif($term->marks_for == 2)
                        MCQ
                    @else
                        Practical
                    @endif
                    <br />(T:{{ $term->total_mark }}, P:{{ $term->pass_mark }})
                </th>
            @endforeach
            <!-- <th colspan="3" style="text-align: center">MCQ <br/>(T:25.00, P:8.00)</th>
                            <th colspan="3" style="text-align: center">Practical<br/>(T:25.00, P:8.00)</th> -->
            <!-- <th >Total Mark <br/> (T:{{ $total_mark }}, P:{{ $pass_mark }})</th>
                            <th >Conv ({{ $class_percentage?->percentage }})</th>
                            <th >CA/CT + Conv ({{ $class_percentage?->percentage }})</th>
                            <th >GPA Point</th>
                            <th >GPA</th>
                            <th >Is Absent?</th> -->

        </tr>

    </thead>
    <tbody>
        @foreach ($students as $student)
            @php
                $total_mark = 0;
                $total_mark_cq = 0;
                $total_mark_70 = 0;
                $total_mark_ct = 0;
                $isnegative = 1;
                $subjectmark = $student->subjectwisemark[0] ?? [];

                $is_absentclass = $subjectmark->is_absent ?? 0;
            @endphp
            <tr>
                <td>
                    {{ $loop->index + 1 }}
                    <input type="hidden" value="{{ $student->student_code }}" name="student_code[]" />
                    <!-- <input type="hidden" value="{{ $student->version_id }}" name="version_id[]"/>
                                     <input type="hidden" value="{{ $student->group_id }}" name="group_id[]"/> -->


                </td>
                <td class="wrap-text">{{ $student->first_name }}</td>
                <td>{{ $student->roll }}</td>

                @foreach ($subject->subjectMarkTerms as $key2 => $term)
                    @if ($term->marks_for == 0)
                        <input class="form-control marks ct1   text-center " step="1"
                            value="{{ $subjectmark->ct1 ?? '' }}" name="ct1{{ $student->student_code }}"
                            id="ct1{{ $student->student_code }}" data-student_code="{{ $student->student_code }}"
                            data-maxvalue="{{ $max_assigment }}" data-marks_for="" type="hidden">


                        <input class="form-control marks ct2   text-center " step="1"
                            value="{{ $subjectmark->ct2 ?? '' }}" name="ct2{{ $student->student_code }}"
                            id="ct2{{ $student->student_code }}" data-student_code="{{ $student->student_code }}"
                            data-maxvalue="{{ $max_project }}" data-marks_for="" type="hidden">




                        <input class="form-control marks ct3   text-center " step="1"
                            value="{{ $subjectmark->ct3 ?? '' }}" name="ct3{{ $student->student_code }}"
                            id="ct3{{ $student->student_code }}" data-student_code="{{ $student->student_code }}"
                            data-maxvalue="{{ $max_work }}" data-marks_for="" type="hidden">

                        <td>

                            <input class="form-control marks obtained    text-center " step="1"
                                value="{{ $subjectmark->ct ?? '' }}" name="ct{{ $student->student_code }}"
                                id="ct{{ $student->student_code }}" data-student_code="{{ $student->student_code }}"
                                data-marks_for="ct" type="number" data-maxvalue="{{ $term->total_mark }}"
                                data-minvalue="{{ $term->pass_mark }}">
                        </td>
                        @php
                            $total_mark_cq += $subjectmark->cq ?? 0;
                        @endphp
                    @else
                        @php
                            $obtained = '';

                            $grace = '';
                            $total = '';
                            if ($term->marks_for == 1) {
                                $obtained = $subjectmark->cq ?? '';
                                $grace = $subjectmark->cq_grace ?? '';
                                $total = $subjectmark->cq_total ?? '';
                                $total_mark += $subjectmark->cq_total ?? 0;
                                $cq_total_value = $subjectmark->cq_total ?? 0;
                                if ($cq_total_value < $term->pass_mark) {
                                    $isnegative = -1;
                                }
                            } elseif ($term->marks_for == 2) {
                                $obtained = $subjectmark->mcq ?? '';
                                $grace = $subjectmark->mcq_grace ?? '';
                                $total = $subjectmark->mcq_total ?? '';
                                $total_mark += $subjectmark->mcq_total ?? 0;
                                $mcq_total_value = $subjectmark->mcq_total ?? 0;
                                if ($mcq_total_value < $term->pass_mark) {
                                    $isnegative = -1;
                                }
                            } else {
                                $obtained = $subjectmark->practical ?? '';
                                $grace = $subjectmark->practical_grace ?? '';
                                $total = $subjectmark->practical_total ?? '';
                                $total_mark += $subjectmark->practical_total ?? 0;
                                $practical_total_value = $subjectmark->practical_total ?? 0;
                                if ($practical_total_value < $term->pass_mark) {
                                    $isnegative = -1;
                                }
                            }
                        @endphp
                        <td>
                            <input type="hidden" name="min{{ $term->marks_for }}{{ $student->student_code }}"
                                value="{{ $term->pass_mark }}" />
                            <input class="form-control marks obtained   text-center " step="1"
                                value="{{ $obtained }}"
                                name="obtained{{ $term->marks_for }}{{ $student->student_code }}"
                                id="obtained{{ $term->marks_for }}{{ $student->student_code }}"
                                data-maxvalue="{{ $term->total_mark }}" data-minvalue="{{ $term->pass_mark }}"
                                data-student_code="{{ $student->student_code }}"
                                data-marks_for="{{ $term->marks_for }}" type="number">
                        </td>

                        <input class="form-control marks grace text-center" step="1" value="{{ $grace }}"
                            name="grace{{ $term->marks_for }}{{ $student->student_code }}"
                            id="grace{{ $term->marks_for }}{{ $student->student_code }}"
                            data-student_code="{{ $student->student_code }}" data-marks_for="{{ $term->marks_for }}"
                            type="hidden">



                        <input class="form-control marks    text-center " readonly="" value="{{ $total }}"
                            name="totalmark{{ $term->marks_for }}{{ $student->student_code }}"
                            id="totalmark{{ $term->marks_for }}{{ $student->student_code }}"
                            data-maxvalue="{{ $term->total_mark }}" data-minvalue="{{ $term->pass_mark }}"
                            data-student_code="{{ $student->student_code }}" data-marks_for="{{ $term->marks_for }}"
                            type="hidden">
                    @endif
                @endforeach
                <!-- <input type="hidden" id="cti{{ $student->student_code }}" name="cti{{ $student->student_code }}" value="" />
                                <input type="hidden" id="totalmarki{{ $student->student_code }}" name="totalmarki{{ $student->student_code }}" value="" />
                                <input type="hidden" id="totalconvi{{ $student->student_code }}" name="totalconvi{{ $student->student_code }}" value="" />
                                <input type="hidden" id="ctconvi{{ $student->student_code }}" name="ctconvi{{ $student->student_code }}" value="" />
                                <input type="hidden" id="gpapoint{{ $student->student_code }}" name="gpapoint{{ $student->student_code }}" value="" />
                                <input type="hidden" id="gpa{{ $student->student_code }}" name="gpa{{ $student->student_code }}" value="" /> -->
                @php
                    $total_mark_70 = ($total_mark * (int) $class_percentage?->percentage) / 100;
                    $total_mark_ct = $total_mark_70 + $total_mark_cq;
                    $point = getPoint($total_mark_ct, $isnegative);
                    if ($subject_id == 124) {
                        $point = getPoint($total_mark_ct * 2, $isnegative);
                    }

                    $grade = getGrade($point, $isnegative);
                @endphp

                <input class="form-control marks    text-center " readonly="" value="{{ $total_mark ?? '' }}"
                    name="totalmark{{ $student->student_code }}" id="totalmark{{ $student->student_code }}"
                    type="hidden">


                <input class="form-control marks    text-center " readonly="" value="{{ $total_mark_70 }}"
                    name="conv{{ $student->student_code }}" id="conv{{ $student->student_code }}" type="hidden">


                <input class="form-control marks    text-center " readonly="" value="{{ $total_mark_ct }}"
                    name="ctconv{{ $student->student_code }}" id="ctconv{{ $student->student_code }}"
                    type="hidden">


                <input class="form-control marks    text-center " readonly="" value="{{ $point }}"
                    name="gpapoint{{ $student->student_code }}" id="gpapoint{{ $student->student_code }}"
                    type="hidden">


                <input class="form-control marks    text-center " readonly="" value="{{ $grade }}"
                    name="gpa{{ $student->student_code }}" id="gpa{{ $student->student_code }}" type="hidden">


                <input class="is_absent" {{ $is_absentclass == 1 ? "checked='checked'" : '' }}
                    data-studentcode="{{ $student->student_code }}" value="1"
                    name="is_absent{{ $student->student_code }}" id="is_absent{{ $student->student_code }}"
                    type="hidden" />

            </tr>
        @endforeach
    </tbody>

</table>
<div class="mb-3  col-md-2">
    <label class="form-label" for="amount"> </label>
    <button type="submit" class="btn btn-primary form-control me-2 mt-1">Save</button>
</div>
<script>
    function getGPA(marks) {
        if (marks >= 80) {
            return 'A+'; // A+
        } else if (marks >= 70) {
            return 'A'; // A
        } else if (marks >= 60) {
            return 'A-'; // A-
        } else if (marks >= 50) {
            return 'B'; // B
        } else if (marks >= 40) {
            return 'C'; // C
        } else if (marks >= 33) {
            return 'D'; // D
        } else {
            return 'F'; // F
        }
    }

    function getGPAPoint(marks) {
        if (marks >= 80) {
            return 5.0; // A+
        } else if (marks >= 70) {
            return 4.0; // A
        } else if (marks >= 60) {
            return 3.5; // A-
        } else if (marks >= 50) {
            return 3.0; // B
        } else if (marks >= 40) {
            return 2.0; // C
        } else if (marks >= 33) {
            return 1.0; // D
        } else {
            return 0.0; // F
        }
    }
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
        $('.isabsent').find('.obtained, .grace').each(function() {
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
            checkbox.closest('tr').find('.obtained, .grace').each(function() {
                // Set the readonly attribute based on the checkbox state

                $(this).prop('readonly', isReadonly);


            });
            checkbox.closest('tr').find('input[type="text"],input[type="number"]').each(function() {
                // Set the readonly attribute based on the checkbox state

                $(this).val('');


            });
        });

        function calculateSums() {
            var student_code = $(this).data('student_code');
            var maxvalue = $(this).data('maxvalue');
            var minvalue = $(this).data('minvalue');
            var currentvalue = $(this).val();
            var subject_id = $('#subject_id').val();

            if (!Number.isInteger(parseFloat(currentvalue))) {
                $(this).val(''); // Option 1: Round down to integer
                // $(this).val(''); // Option 2: Clear the input field
                Swal.fire({
                    title: "Warning",
                    text: "Only integers are allowed",
                    icon: "warning"
                });
                currentvalue = 0;
            }



            if (maxvalue < currentvalue) {
                $(this).val('');
                Swal.fire({
                    title: "Warning",
                    text: "Over The Maximum Value",
                    icon: "warning"
                });
            }
            var is_pass = 1;

            // Sum of 4th, 5th, 6th TD inputs (CT1, CT2, CT3) and set in 7th TD input

            let ct1 = Num($('input[name="ct1' + student_code + '"]').val());
            let ct2 = Num($('input[name="ct2' + student_code + '"]').val());
            let ct3 = Num($('input[name="ct3' + student_code + '"]').val());
            let ct = Num($('input[name="ct' + student_code + '"]').val());
            let sum1 = ct;
            // $('input[name="ct'+student_code+'"]').val(sum1);




            // Sum of 8th, 9th TD inputs (Obtained Marks 1 and Grace Marks 1) and set in 10th TD input
            let obtained1 = Num($('input[name="obtained1' + student_code + '"]').val());
            let minvalue1 = Num($('input[name="obtained1' + student_code + '"]').data('minvalue'));
            let grace1 = 0;
            let sum2 = obtained1 + grace1;
            //$('input[name="totalmark1'+student_code+'"]').val(sum2);

            if (minvalue1 > obtained1) {
                is_pass = 0;
            }

            // Sum of 11th, 12th TD inputs (Obtained Marks 2 and Grace Marks 2) and set in 13th TD input
            let obtained2 = 0;
            let minvalue2 = 0;
            let grace2 = 0;
            let sum3 = obtained2 + grace2;
            //$('input[name="totalmark2'+student_code+'"]').val(sum3);

            // Sum of 14th, 15th TD inputs (Obtained Marks 3 and Grace Marks 3) and set in 16th TD input
            let obtained3 = Num($('input[name="obtained3' + student_code + '"]').val());
            let minvalue3 = Num($('input[name="obtained3' + student_code + '"]').data('minvalue'));
            let grace3 = 0;
            let sum4 = obtained3 + grace3;
            // $('input[name="totalmark3'+student_code+'"]').val(sum4);

            // Sum of 10th, 13th, 16th TD inputs and set in 17th TD input
            let total1 = sum1;
            let total2 = sum3;
            let total3 = sum4;
            let grandTotal = total1 + total2 + total3;
            $('input[name="totalmark' + student_code + '"]').val(grandTotal);

            // Convert 17th TD input to 70% and set value in 18th TD input
            var percentage = $('#percentage').val();
            let percentage70 = Math.round((grandTotal * percentage) / 100);
            $('input[name="conv' + student_code + '"]').val(percentage70);

            // Sum of 18th and 7th TD input and set value in 19th TD input
            let totalCT = Num($('input[name="ct' + student_code + '"]').val());
            let finalTotal = totalCT + percentage70;
            $('input[name="ctconv' + student_code + '"]').val(finalTotal);
            if (subject_id == 9) {
                finalTotal = finalTotal * 2;
            }
            if (subject_id == 124) {
                finalTotal = finalTotal * 2;
            }
            // Calculate GPA Point based on 19th TD input value and set in 20th TD input
            let gpaPoint = is_pass ? calculateGpaPoint(finalTotal) : 0;
            $('input[name="gpapoint' + student_code + '"]').val(gpaPoint);

            // Calculate GPA based on 19th TD input value and set in 21st TD input
            let gpa = is_pass ? calculateGpa(finalTotal) : 'F';
            $('input[name="gpa' + student_code + '"]').val(gpa);
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
            } else if (marks >= 40) {
                return 2.0; // C
            } else if (marks >= 33) {
                return 1.0; // D
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
            } else if (marks >= 40) {
                return 'C'; // C
            } else if (marks >= 33) {
                return 'D'; // D
            } else {
                return 'F'; // F
            }
        }

        // Attach event listener to relevant input fields
        $('input[type="number"]').on('input', calculateSums);

    });
</script>
