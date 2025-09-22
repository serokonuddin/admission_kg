<?php

namespace App\Models\Exam;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\sttings\Classes;
use App\Models\sttings\Sessions;

class StudentTotalMark extends Model
{
    use HasFactory;
    protected $table="student_total_mark";

    
    protected $fillable = [
        'id','session_id','version_id','shift_id','class_code','section_id','group_id','exam_id','student_code','total_mark','total_avarage_mark','grade','grade_point','percentage','percentage_value','position_in_section','position_in_class','is_promoted','next_class',
        'number_of_working_days','total_present','total_absent','remarks','created_at','updated_at','created_by','updated_by'
        // Add other fillable attributes here
    ];
   
    
}
