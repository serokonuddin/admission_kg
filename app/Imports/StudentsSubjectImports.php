<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Student\Student;
use App\Models\Student\StudentActivity;
use App\Models\Student\StudentSubjects;
use Exception;
use DB;

class StudentsSubjectImports implements ToCollection
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
                    

                    // Subject Info
                    if (in_array($column_name, [
                        
                        'main subject',
                        'third subject',
                        'fourth subject'
                    ])) {
                       
                        // Handle subjects
                        if ($column_name == 'main subject') {
                            $subjects = explode(",", $value);
                            foreach ($subjects as $subject) {
                                $subject_data['class_id'] = $row[5];
                                $subject_data['class_code'] = $row[5];
                                $subject_data['session_id'] = $row[3];
                                $subject_data['version_id'] = $row[4];
                                $subject_data['student_code'] = $row[1];
                                $subject_data['is_fourth_subject'] = 0;
                                $subject_data['subject_id'] = $subject;
                                $student_subject[] = $subject_data;
                            }
                        }

                        // Handle 4th subjects
                        if ($column_name == 'fourth subject') {
                            $subjects = explode(",", $value);
                            foreach ($subjects as $subject) {
                                $subject_data['class_id'] = $row[5];
                                $subject_data['class_code'] = $row[5];
                                $subject_data['session_id'] = $row[3];
                                $subject_data['version_id'] = $row[4];
                                $subject_data['student_code'] = $row[1];
                                $subject_data['is_fourth_subject'] = 1;
                                $subject_data['subject_id'] = $subject;
                                $student_subject[] = $subject_data;
                            }
                        }

                        // Handle 3th subjects
                        if ($column_name == 'third subject') {
                            $subjects = explode(",", $value);
                            foreach ($subjects as $subject) {
                                $subject_data['class_id'] = $row[5];
                                $subject_data['class_code'] = $row[5];
                                $subject_data['session_id'] = $row[3];
                                $subject_data['version_id'] = $row[4];
                                $subject_data['student_code'] = $row[1];
                                $subject_data['is_fourth_subject'] = 2;
                                $subject_data['subject_id'] = $subject;
                                $student_subject[] = $subject_data;
                            }
                        }
                    }

                   
                }



                // Insert subjects for the current student
				
                if (count($student_subject)) {
					StudentSubjects::where('student_code',$row[1])->where('session_id',$row[3])->delete();
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
