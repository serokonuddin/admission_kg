<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Student\Student;
use App\Models\Student\StudentActivity;
use App\Models\Student\StudentSubjects;
use Exception;
use DB;

class StudentBasicInfoUpload implements ToCollection
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

                    // Student Info
                    if (in_array($column_name, [
                        'student_code',
                        // 'first_name',
                        // 'last_name',
                        // 'bangla_name',
                        // 'gender',
                        // 'nationality',
                        // 'blood',
                        // 'mobile',
                        // 'religion',
                        // 'sms_notification',
                        'father_name',
                        'mother_name',
                        // 'father_phone',
                        // 'father_profession',
                        // 'father_email',
                        // 'mother_phone',
                        // 'mother_profession',
                        // 'mother_email',
                        // 'present_addr',
                        // 'present_police_station',
                        // 'present_district_id',
                        // 'permanent_addr',
                        // 'permanent_police_station',
                        // 'permanent_district_id',
                        // 'email',
                        // 'local_guardian_name',
                        // 'local_guardian_email',
                        // 'local_guardian_mobile',
                        // 'local_guardian_nid',
                        // 'local_guardian_address',
                        // 'local_guardian_police_station',
                        // 'local_guardian_district_id'
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
                $current_student_info['active'] = 1;
                $current_student_info['created_by'] = 1;

                $student_info[] = $current_student_info;



                // Insert or update student info
                Student::updateOrCreate(
                    [
                        'student_code' => $current_student_info['student_code']
                    ],
                    $current_student_info
                );

                // Insert subjects for the current student


            }
        }

        return 1;
    }
}
