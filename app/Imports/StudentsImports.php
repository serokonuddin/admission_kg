<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Student\Student;
use App\Models\Student\StudentActivity;
use App\Models\Student\StudentSubjects;
use Exception;
use DB;

class StudentsImports implements ToCollection
{
    public function collection(Collection $rows)
    {
        $student_academic_info = [];
        $student_info = [];

        // Process each row
        foreach ($rows as $key => $row) {
            if ($key == 0) {
                // Header row: extract the column names
                $keys = $row->toArray();
              
            } else {
                $current_student_info = [];
                $current_student_academic_info = [];
                $student_academic_subject = [];
                $student_subject = [];

                foreach ($row as $k => $value) {
                    $column_name = $keys[$k];
                    
                    // Academic Info
                    if (in_array($column_name, [
                        'session_id',
                        'version_id',
                        'shift_id',
                        'class_id',
                        'class_code',
                        'group_id',
                        'section_id',
                        'category_id',
                        'roll',
                        'student_code'
                    ])) {
                        if ($column_name == 'session_id') {
                            $value = trim($value);

                            if (empty($value) || !is_numeric($value)) {
                                throw new Exception("Invalid session_id at row $k");
                            }

                            $current_student_academic_info[$column_name] = (int)$value;
                        } else {
                            $current_student_academic_info[$column_name] = $value === '' ? null : $value;
                        }

                        if ($column_name == 'student_code') {
                           
                            $current_student_info['student_code'] = trim($value ?? '');
                           
                            if (empty($current_student_info['student_code'])) {
                                continue 2;
                            }
                        }

                        if ($column_name == 'class_code') {
                            $current_student_info['class_code'] = $value;
                            $current_student_academic_info['class_code'] = $value;
                        }
                    }

                    // Subject Info
                    if (in_array($column_name, [
                        'class_id',
                        'class_code',
                        'session_id',
                        'version_id',
                        'student_code',
                        'subjects',
                        '4th_subjects'
                    ])) {
                        if ($column_name != 'subjects' || $column_name != '4th_subjects') {
                            $student_academic_subject[$column_name] = $value === '' ? null : $value;
                        }

                        // Handle subjects
                        if ($column_name == 'subjects') {
                            $subjects = explode(",", $value);
                            foreach ($subjects as $subject) {
                                $subject_data = $student_academic_subject;
                                $subject_data['is_fourth_subject'] = 0;
                                $subject_data['subject_id'] = $subject;
                                $student_subject[] = $subject_data;
                            }
                        }

                        // Handle 4th subjects
                        if ($column_name == '4th_subjects') {
                            $subjects = explode(",", $value);
                            foreach ($subjects as $subject) {
                                $subject_data = $student_academic_subject;
                                $subject_data['is_fourth_subject'] = 1;
                                $subject_data['subject_id'] = $subject;
                                $student_subject[] = $subject_data;
                            }
                        }
                    }

                    // Student Info
                    if (in_array($column_name, [
                        'first_name',
                        'last_name',
                        'bangla_name',
                        'gender',
                        'nationality',
                        'blood',
                        'mobile',
                        'religion',
                        'sms_notification',
                        'father_name',
                        'mother_name',
                        'father_contact',
                        'father_profession',
                        'father_email',
                        'mother_contact',
                        'mother_profession',
                        'mother_email',
                        'present_addr',
                        'present_police_station',
                        'present_district_id',
                        'permanent_addr',
                        'permanent_police_station',
                        'permanent_district_id',
                        'email',
                        'local_guardian_name',
                        'local_guardian_email',
                        'local_guardian_mobile',
                        'local_guardian_nid',
                        'local_guardian_address',
                        'local_guardian_police_station',
                        'local_guardian_district_id'
                    ])) {
                        // Convert empty strings for integer fields to null
                        $current_student_info[$column_name] = $value === '' ? null : $value;

                        // Handle `religion` specifically
                        if ($column_name == 'religion') {
                            $current_student_info['religion'] = $value === '' ? null : intval($value);
                        }
                    }
                }

                // Set common fields
                $current_student_academic_info['active'] = 1;
                $current_student_info['active'] = 1;
                $current_student_academic_info['created_by'] = 1;
                $current_student_info['created_by'] = 1;

                $student_academic_info[] = $current_student_academic_info;
                $student_info[] = $current_student_info;

                // Insert or update student activity and academic info
               
                StudentActivity::updateOrCreate(
                    [
                        'student_code' => $current_student_info['student_code'],
                        'session_id' => $current_student_academic_info['session_id'],
                        'class_code' => $current_student_academic_info['class_code']
                    ],
                    $current_student_academic_info
                );

                // Insert or update student info
                Student::updateOrCreate(
                    [
                        'student_code' => $current_student_info['student_code']
                    ],
                    $current_student_info
                );

                // Insert subjects for the current student
				
                if (count($student_subject)) {
					StudentSubjects::where('student_code',$current_student_info['student_code'])->where('session_id',$current_student_academic_info['session_id'])->delete();
                    foreach ($student_subject as $subject) {
						
                        StudentSubjects::updateOrCreate(
                            [
                                'student_code' => $subject['student_code'],
                                'subject_id' => $subject['subject_id'],
                                'is_fourth_subject' => $subject['is_fourth_subject'],
                            ],
                            $subject
                        );
                    }
                }
            }
        }

        return 1;
    }
}
