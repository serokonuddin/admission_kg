<?php

namespace App\Models\Exam;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\sttings\Classes;
use App\Models\sttings\Sessions;
use App\Models\sttings\Subjects;

class StudentAvarageMark extends Model
{
    use HasFactory;
    protected $table="student_avarage_mark";
    protected $fillable = [
        'id','session_id','version_id','shift_id','class_code','group_id','section_id','group_id','exam_id','subject_id','student_code'
        ,'ct1','ct2'
        ,'ct3','ct','cq','cq_grace','cq_total'
        ,'practical','practical_grace','practical_total'
        ,'mcq','mcq_grace','mcq_total'
        ,'total','conv_total','ct_conv_total','gpa_point','gpa','is_fourth_subject'
        ,'created_at','updated_at','created_by','updated_by','non_value'
        // Add other fillable attributes here
    ];
    
    public function subject(){
        return $this->hasOne(Subjects::class,'id','subject_id');
    }
    
    
}
