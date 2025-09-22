<?php

namespace App\Models\Exam;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\sttings\Classes;
use App\Models\sttings\Sessions;
use App\Models\sttings\Subjects;

class StudentWiseGrage extends Model
{
    use HasFactory;
    protected $table="subject_wise_grage";
    protected $fillable = [
        'id','session_id','class_code','exam_id','subject_id','student_code','total_mark_sum','avarage_total_mark_sum'
        ,'grade','grade_point','avarage_grade','avarage_grade_point','created_at','updated_at','created_by','updated_by'
        // Add other fillable attributes here
    ];
    
    public function subject(){
        return $this->hasOne(Subjects::class,'id','subject_id');
    }
    
    
}
