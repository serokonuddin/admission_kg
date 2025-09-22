<?php

namespace App\Models\Exam;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\sttings\Classes;
use App\Models\sttings\Sessions;

class ExamHighestMark extends Model
{
    use HasFactory;
    protected $table="exam_highest_mark";
    protected $fillable = [
        'id','session_id','version_id','class_code','section_id','group_id','exam_id','subject_id','student_code'
        ,'highest_mark','avarage_highest_mark','percentage_avarage_highest_mark','created_at','updated_at','created_by','updated_by'
        // Add other fillable attributes here
    ];
    

    
    
}
