<div id="print-table">
    <div id="result-table">
        <p class="border border-gray-500 p-2 dynamic-data" style="display: flex; justify-content: space-between;">
            @if ($section_id)
                <span>Teacher: <strong style="margin-left: 5px">{{ $teacher->employee_name }}</strong> </span>
            @endif
            @if ($subject_id)
                <span>Subject: <strong style="margin-left: 5px">{{ $subject_text }}</strong> </span>
            @endif
            @if ($exam_id)
                <span>Exam: <strong style="margin-left: 5px">{{ $exam_text }}</strong> </span>
            @endif
        </p>
        <p class="border border-gray-500 p-2 dynamic-data" style="display: flex; justify-content: space-between;">
            @if ($session_id)
                <span>Session: <strong style="margin-left: 5px">{{ $session_id }}</strong> </span>
            @endif
            @if ($version_id)
                <span>Version: <strong style="margin-left: 5px">{{ $version_text }}</strong> </span>
            @endif
            @if ($shift_id)
                <span>Shift: <strong style="margin-left: 5px">{{ $shift_text }}</strong> </span>
            @endif
            @if ($class_code)
                <span>Class: <strong style="margin-left: 5px">{{ $class_text }}</strong> </span>
            @endif
            @if ($section_id)
                <span>Section: <strong style="margin-left: 5px">{{ $section_text }}</strong> </span>
            @endif
        </p>

        @php
            $totalStudents = $students->count();
            $passedStudents = $students
                ->filter(fn($student) => $student->gpa !== 'F' && !is_null($student->gpa))
                ->count();
            $absentStudents = $students->filter(fn($student) => is_null($student->gpa))->count();
            $failedStudents = $totalStudents - ($passedStudents + $absentStudents);
            $highestMark = $students->max('ct_conv_total'); // or 'sub_total' if needed

            $passPercentage = $totalStudents > 0 ? round(($passedStudents / $totalStudents) * 100, 2) : 0;
            $failPercentage = $totalStudents > 0 ? round(($failedStudents / $totalStudents) * 100, 2) : 0;
            $absentPercentage = $totalStudents > 0 ? round(($absentStudents / $totalStudents) * 100, 2) : 0;

            $averageMark = $totalStudents > 0 ? round($students->avg('ct_conv_total'), 2) : 0; // or 'sub_total'
        @endphp



        <p class="border border-gray-500 p-2 dynamic-data" style="display: flex; justify-content: space-between;">
            <span>Total Students: <strong>{{ $totalStudents }}</strong></span>
            <span>Passed: <strong>{{ $passedStudents }}</strong> ({{ $passPercentage }}%)</span>
            <span>Failed: <strong>{{ $failedStudents }}</strong> ({{ $failPercentage }}%)</span>
            <span>Absent: <strong>{{ $absentStudents }}</strong> ({{ $absentPercentage }}%)</span>
            <span>Highest Mark: <strong>{{ $highestMark }}</strong></span>
            <span>Average Mark: <strong>{{ $averageMark }}</strong></span>
        </p>


    </div>

    <div class="table-responsive" id="item-list">
        @if ($students->isEmpty())
            <p class="text-center alert alert-warning">No students found. Use the search form to find
                students.</p>
        @else
            <table class="w-full border border-gray-200 rounded-lg shadow-md bg-white" id="headerTable">
                <thead class="bg-gray-100 sticky top-0">
                    <tr class="text-gray-700 text-left text-sm">
                        <th class="p-3 border">SL</th>
                        <th class="p-3 border">Roll</th>
                        <th class="p-3 border">SID</th>
                        <th class="p-3 border">Name</th>
                        <th class="p-3 border">CQ</th>
                        <th class="p-3 border">MCQ</th>
                        <th class="p-3 border">Prac</th>
                        <th class="p-3 border">Total</th>
                        <th class="p-3 border">Conv </br> 70%</th>
                        <th class="p-3 border">CT</th>
                        <th class="p-3 border">Quiz</th>
                        <th class="p-3 border">Total</th>
                        <th class="p-3 border">Conv </br> 30%</th>
                        <th class="p-3 border">Sub </br> Total</th>
                        <th class="p-3 border">GPA</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($students as $index => $student)
                        @php
                            $subjectId = $student->subject_id ?? null;
                            $cqTotal = $student->cq_total ?? null;
                            $mcqTotal = $student->mcq_total ?? null;
                            $practicalTotal = $student->practical_total ?? null;
                            $isAbsent = $student->is_absent ?? null;

                            $isCqAbsent = $student->is_cq_abs ?? 0;
                            $isMcqAbsent = $student->is_mcq_abs ?? 0;
                            $isPracAbsent = $student->is_prac_abs ?? 0;
                            $isCtAbsent = $student->is_ct_abs ?? 0;
                            $isQuizAbsent = $student->is_quiz_abs ?? 0;

                            $specialSubjectsPrac = [
                                58,
                                59,
                                61,
                                62,
                                84,
                                92,
                                88,
                                96,
                                75,
                                76,
                                77,
                                78,
                                85,
                                93,
                                80,
                                83,
                                87,
                                95,
                                89,
                                98,
                                79,
                                81,
                            ];
                            $specialSubjectsMcq = [61, 62, 71, 72];

                            // Determine CQ Highlight Condition
                            $highlightCq =
                                $subjectId &&
                                ((in_array($subjectId, $specialSubjectsPrac) &&
                                    $cqTotal !== null &&
                                    ($cqTotal < 23 || (($subjectId == 71 || $subjectId == 72) && $cqTotal < 20))) ||
                                    (!in_array($subjectId, $specialSubjectsPrac) &&
                                        $cqTotal !== null &&
                                        $cqTotal < 17));

                            // Determine MCQ Highlight Condition
                            $highlightMcq =
                                $subjectId &&
                                !in_array($subjectId, $specialSubjectsMcq) &&
                                ((in_array($subjectId, $specialSubjectsPrac) && $mcqTotal !== null && $mcqTotal < 10) ||
                                    (!in_array($subjectId, $specialSubjectsPrac) &&
                                        $mcqTotal !== null &&
                                        $mcqTotal < 8));

                            // Determine Practical Total Highlight Condition
                            $highlightPractical =
                                $subjectId &&
                                !in_array($subjectId, $specialSubjectsPrac) &&
                                (($practicalTotal !== null && $practicalTotal < 8) ||
                                    (in_array($subjectId, [71, 72]) &&
                                        $practicalTotal !== null &&
                                        $practicalTotal < 13));

                            // Determine if Practical Total should be hidden
                            $hidePractical = $subjectId && in_array($subjectId, $specialSubjectsPrac);
                        @endphp
                        <tr class="text-gray-700 text-sm odd:bg-white even:bg-gray-50 hover:bg-gray-100 transition">
                            <td class="p-3 border">{{ $loop->iteration }}</td>
                            <td class="p-3 border">{{ $student->studentActivity->roll ?? '' }}</td>
                            <td class="p-3 border">{{ $student->student_code ?? '' }}</td>
                            <td class="p-3 border font-medium" style="text-align: left">
                                {{ strtoupper($student->first_name) }}</td>

                            <td class="p-3 border text-center"
                                style="@if ($highlightCq || $isCqAbsent) color:red;text-decoration: underline @endif">
                                {{ $isCqAbsent ? 'A' : $cqTotal ?? '' }}
                            </td>

                            <td class="p-3 border text-center"
                                style="@if ($highlightMcq || $isMcqAbsent) color:red;text-decoration: underline @endif">
                                @if ($subjectId && in_array($subjectId, $specialSubjectsMcq))
                                    -
                                @else
                                    {{ $isMcqAbsent ? 'A' : $mcqTotal ?? '' }}
                                @endif
                            </td>

                            <td class="p-3 border text-center"
                                style="
                                @if ($highlightPractical || $isPracAbsent) color:red;text-decoration: underline @endif">
                                {{ $hidePractical ? '-' : ($isPracAbsent ? 'A' : $practicalTotal ?? '') }}
                            </td>

                            <td class="p-3 border text-center">{{ $student->total }}</td>
                            <td class="p-3 border text-center">{{ $student->conv_total }}</td>

                            <td class="p-3 border text-center"
                                style="
                                @if ($isCtAbsent) color:red;text-decoration: underline @endif">
                                {{ $isCtAbsent ? 'A' : ($student->ct1 ?? 0) + ($student->ct2 ?? 0) }}
                            </td>

                            <td class="p-3 border text-center"
                                style="
                                @if ($isQuizAbsent) color:red;text-decoration: underline @endif">
                                {{ $isQuizAbsent ? 'A' : ($student->ct3 ?? 0) + ($student->ct4 ?? 0) }}
                            </td>

                            <td class="p-3 border text-center">
                                {{ ($student->ct1 ?? 0) + ($student->ct2 ?? 0) + ($student->ct3 ?? 0) + ($student->ct4 ?? 0) }}
                            </td>

                            <td class="p-3 border text-center"
                                style="
                                @if ($student->gpa == 'F') color:red;text-decoration: underline @endif">
                                {{ $student->ct }}
                            </td>

                            <td class="p-3 border text-center"
                                style="
                                @if ($student->gpa == 'F') color:red;text-decoration: underline @endif">
                                {{ $student->ct_conv_total ?? '' }}
                            </td>

                            <td class="p-3 border text-center"
                                style="
                                @if ($student->gpa == 'F') color:red;text-decoration: underline @endif">
                                {{ $student->gpa }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
