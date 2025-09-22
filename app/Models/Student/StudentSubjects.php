<?php

namespace App\Models\Student;

use App\Models\Attendance\Attendance;
use App\Models\sttings\AcademySection;
use App\Models\sttings\Classes;
use App\Models\sttings\Sections;
use App\Models\sttings\Sessions;
use App\Models\sttings\Shifts;
use App\Models\sttings\Versions;
use App\Models\sttings\Category;
use App\Models\sttings\Subjects;
use App\Models\sttings\ClassWiseSubject;
use App\Models\LeasonPlan;
use App\Models\Syllabus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSubjects extends Model
{
    use HasFactory;
    protected $table="student_subject";
    protected $fillable = [
         'session_id', 'version_id', 'class_id', 'class_code', 
                        'student_code','subject_id','is_fourth_subject','created_by'
        // Add other fillable attributes here
    ];

    public function subject(){
        return $this->hasOne(Subjects::class,'id','subject_id');
    }
    public function lessonPlan(){
        return $this->hasMany(LeasonPlan::class,'subject_id','subject_id');
    }
    public function syllabus(){
        return $this->hasOne(Syllabus::class,'subject_id','subject_id');
    }
    public function subjectCode(){
        return $this->hasOne(ClassWiseSubject::class,'subject_id','subject_id')->orderBy('serial','asc');
    }
}