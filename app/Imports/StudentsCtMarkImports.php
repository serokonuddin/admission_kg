<?php

namespace App\Imports;


use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Exam\StudentSubjectWiseMark;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class StudentsCtMarkImports implements ToCollection
{
    public function collection(Collection $rows)
    {


        $percentage = 70;
        $indexs = [];
        $input = Session::get('inputCt');

        if ($input['xl_type'] == 1) {
            foreach ($rows as $key => $row) {
                $i = 0;
                if ($key == 0) {
                    $indexs = $row;
                } else {
                    if ($row[1]) {
                        $subjectatt = [
                            'session_id' => $input['session_id'],
                            'class_code' => $input['class_code'],
                            'exam_id' => $input['exam_id'],
                            'subject_id' => $input['subject_id'],
                            'student_code' => $row[1],
                        ];
                        // dd($row);
                        $ct1 = strtoupper($row[3]) == 'A' ? 0 : (float)$row[3];
                        $ct2 = strtoupper($row[4]) == 'A' ? 0 : (float)$row[4];
                        $ct3 = strtoupper($row[5]) == 'A' ? 0 : (float)$row[5];
                        $ct4 = strtoupper($row[6]) == 'A' ? 0 : (float)$row[6];
                        $is_ct_abs = ((isset($row[3]) && strtoupper($row[3]) == 'A') &&
                            (isset($row[4]) && strtoupper($row[4]) == 'A')) ? 1 : 0;

                        $is_quiz_abs = ((isset($row[5]) && strtoupper($row[5]) == 'A') &&
                            (isset($row[6]) && strtoupper($row[6]) == 'A')) ? 1 : 0;
                        // dd((int)$is_ct_abs, (int)$is_quiz_abs);
                        // dd(gettype($is_ct_abs), gettype($is_quiz_abs));
                        $subjectdata = [
                            'session_id' => $input['session_id'],
                            'class_code' => $input['class_code'],
                            'exam_id' => $input['exam_id'],
                            'subject_id' => $input['subject_id'],
                            'student_code' => $row[1],
                            'ct1' => $ct1,
                            'ct2' => $ct2,
                            'ct3' => $ct3,
                            'ct4' => $ct4,
                            'is_ct_abs' => $is_ct_abs,
                            'is_quiz_abs' => $is_quiz_abs,
                            'ct' => round((($ct1 + $ct2 + $ct3 + $ct4) * 30) / 80),
                            'non_value' => 0,
                            'created_by' => auth()->user()->id,
                            'updated_by' => auth()->user()->id,
                        ];

                        $data = StudentSubjectWiseMark::updateOrCreate($subjectatt, $subjectdata);
                    }
                }
            }
        } else {
            $subject_mark_terms = DB::table('subject_mark_terms')
                ->where('session_id', $input['session_id'])
                ->where('class_code', $input['class_code'])
                ->where('subject_id', $input['subject_id'])->orderBy('marks_for', 'asc')->get();
            foreach ($rows as $key => $row) {
                $i = 0;
                if ($key < 2) {
                    $indexs = $row;
                } else {

                    $subjectatt = [
                        'session_id' => $input['session_id'],
                        'class_code' => $input['class_code'],
                        'exam_id' => $input['exam_id'],
                        'subject_id' => $input['subject_id'],
                        'student_code' => $row[0],
                    ];

                    $cq = strtoupper($row[2]) == 'A' ? 0 : (float)$row[2];
                    $cq_total = strtoupper($row[2]) == 'A' ? 0 : (float)$row[2];
                    $mcq = strtoupper($row[5]) == 'A' ? 0 : (float)$row[5];
                    $mcq_total = strtoupper($row[5]) == 'A' ? 0 : (float)$row[5];
                    $practical = strtoupper($row[3]) == 'A' ? 0 : (float)$row[3];
                    $practical_total = strtoupper($row[3]) == 'A' ? 0 : (float)$row[3];
                    $total = strtoupper($row[6]) == 'A' ? 0 : (float)$row[6];
                    $conv_total = round(($total * $percentage) / 100);
                    $cq_abs = (isset($row[2]) && strtoupper($row[2]) == 'A') ? 1 : 0;
                    $mcq_abs = (isset($row[5]) && strtoupper($row[5]) == 'A') ? 1 : 0;
                    $prac_abs = (isset($row[3]) && strtoupper($row[3]) == 'A') ? 1 : 0;
                    $subjectdata = [
                        'session_id' => $input['session_id'],
                        'class_code' => $input['class_code'],
                        'exam_id' => $input['exam_id'],
                        'subject_id' => $input['subject_id'],
                        'student_code' => $row[0],
                        'cq' => $cq,
                        'cq_total' => $cq_total,
                        'mcq' => $mcq,
                        'mcq_total' => $mcq_total,
                        'practical' => $practical,
                        'practical_total' => $practical_total,
                        'total' => $total,
                        'conv_total' => $conv_total,
                        'non_value' => 0,
                        'is_cq_abs' => $cq_abs,
                        'is_mcq_abs' => $mcq_abs,
                        'is_prac_abs' => $prac_abs,
                        'created_by' => auth()->user()->id,
                        'updated_by' => auth()->user()->id,
                    ];

                    $data = StudentSubjectWiseMark::updateOrCreate($subjectatt, $subjectdata);

                    $this->setGrade($data, $subject_mark_terms);
                }
            }
        }

        return 1;
    }
    public function setGrade($data, $subject_mark_terms)
    {
        $sujectdata = $data->toArray();

        $is_pass = 1;
        foreach ($subject_mark_terms as $term) {
            if ($term->marks_for == 0 && $is_pass == 1) {
                $is_pass = $this->checkPass($term->pass_mark, $data->ct);
            } else if ($term->marks_for == 1 && $is_pass == 1) {
                $is_pass = $this->checkPass($term->pass_mark, $data->cq_total);
            } else if ($term->marks_for == 2 && $is_pass == 1) {
                $is_pass = $this->checkPass($term->pass_mark, $data->mcq_total);
            } else if ($term->marks_for == 3 && $is_pass == 1) {
                $is_pass = $this->checkPass($term->pass_mark, $data->practical_total);
            }
        }
        $data->ct_conv_total = (float)$data->conv_total + (float)$data->ct;
        $data->gpa_point = ($is_pass == 1) ? $this->calculateGpaPoint($data->ct_conv_total) : 0;
        $data->gpa = ($is_pass == 1) ? $this->calculateGpa($data->ct_conv_total) : 'F';
        $data->save();
        return 1;
    }
    public function checkPass($pass_mark, $mark)
    {
        return ($pass_mark > $mark) ? 0 : 1;
    }

    public function calculateGpaPoint($marks)
    {
        if ($marks >= 80) {
            return 5.0;  // A+
        } else if ($marks >= 70) {
            return 4.0;  // A
        } else if ($marks >= 60) {
            return 3.5;  // A-
        } else if ($marks >= 50) {
            return 3.0;  // B
        } else if ($marks >= 40) {
            return 2.0;  // C
        } else if ($marks >= 33) {
            return 1.0;  // D
        } else {
            return 0.0;  // F
        }
    }

    // Helper function to calculate GPA (example logic)
    public function calculateGpa($marks)
    {
        if ($marks >= 80) {
            return 'A+';  // A+
        } else if ($marks >= 70) {
            return 'A';  // A
        } else if ($marks >= 60) {
            return 'A-';  // A-
        } else if ($marks >= 50) {
            return 'B';  // B
        } else if ($marks >= 40) {
            return 'C';  // C
        } else if ($marks >= 33) {
            return 'D';  // D
        } else {
            return 'F';  // F
        }
    }
}