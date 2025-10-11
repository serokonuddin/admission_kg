<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\sttings\Classes;
use App\Models\sttings\Sessions;
use App\Models\sttings\Subjects;
use App\Models\Exam\Exam;

class ExamTimeShedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'class_code', 'exam_id','subject_id','exam_for', 'exam_date', 'start_time', 'end_time','created_by'
        // Add other fillable attributes here
    ];
    public function classdata(){
        return $this->hasOne(Classes::class,'class_code','class_code');
    }
    public function session(){
        return $this->hasOne(Sessions::class,'id','session_id');
    }
    public function exam(){
        return $this->hasOne(Exam::class,'id','exam_id');
    }
    public function subject(){
        return $this->hasOne(Subjects::class,'id','subject_id');
    }
}
