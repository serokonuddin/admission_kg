<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Student\Student;
use App\Models\Student\StudentActivity;
use App\Models\Student\StudentSubjects;
use Exception;
use DB;

class StudentPromotion implements ToCollection
{
    public function collection(Collection $rows)
    {
        $student_academic_info = [];
        $student_info = [];

        // Process each row
        
        $keys = [];
        try {
            foreach ($rows as $key => $row) {
                if ($key == 0) {
                    // Header row: extract the column names
                    $keys = $row->toArray();
                  
                } else {
                   
                   
                   
                   $current_student_academic_info = [];
                   
                   
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
                            'House',
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
                            if ($column_name == 'class_code') {
                                $current_student_academic_info['class_code'] = $value;
                            }
                        }
                    }
                    
                    $current_student_academic_info['active'] = 1;
                    $current_student_academic_info['created_by'] = 1;
                    if(isset($keys[11]) && $keys[11]=='Old Class'){
                        $oldactivity=StudentActivity::where('class_code',$row[11])->where('roll',$row[12])->first();
                        $current_student_academic_info['student_code']=$oldactivity->student_code;
                        $oldactivity=array(
                            'active'=>0
                        );
                    }else{
                        $oldactivity=array(
                            'active'=>0
                        );
                    }
                    
                    StudentActivity::where('student_code',$current_student_academic_info['student_code'])
                    ->where('session_id',($current_student_academic_info['session_id']-1))
                    ->where('class_code',($current_student_academic_info['class_code']-1))
                    ->update(
                        $oldactivity
                    );
                    // Insert or update student activity and academic info
                    StudentActivity::updateOrCreate(
                        [
                            'student_code' => $current_student_academic_info['student_code'],
                            'session_id' => $current_student_academic_info['session_id'],
                            'class_code' => $current_student_academic_info['class_code']
                        ],
                        $current_student_academic_info
                    );
                }
            }    
        }
        catch(Exception $e) {
          //  dd($current_student_academic_info,$e);
            //dd($e);
        }
        

        return 1;
    }
}
