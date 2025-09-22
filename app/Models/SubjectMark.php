<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\sttings\Versions;
use App\Models\sttings\Sections;
use App\Models\sttings\Sessions;
use App\Models\sttings\Shifts;
use App\Models\sttings\Classes;
use App\Models\sttings\AcademySection;
use App\Models\sttings\Subjects;
use App\Models\Employee\Employee;
use App\Models\Exam\Exam;
use App\Models\Student\Student;
use App\Models\SubjectMarkTerm;

class SubjectMark extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id','version_id','section_id','exam_id',
        'class_code','subject_id','student_code','marks_for','obtained_mark','grace_mark', 'total_mark','status','created_by'
        // Add other fillable attributes here
    ];
    
    public function session(){
        return $this->hasOne(Sessions::class,'id','session_id');
    }
    public function section(){
        return $this->hasOne(Sections::class,'id','section_id');
    }
    public function exam(){
        return $this->hasOne(Exam::class,'id','exam_id');
    }
    public function version(){
        return $this->hasOne(Versions::class,'id','version_id');
    }
   
   
    
    public function group(){
        return $this->hasOne(AcademySection::class,'id','group_id');
    }
    public function subject(){
        return $this->hasOne(Subjects::class,'id','subject_id');
    }
    public function student(){
        return $this->hasOne(Student::class,'student_code','student_code');
    }
    public function subjectmarkterms(){
        return $this->hasOne(SubjectMarkTerm::class,'subject_id','subject_id');
    }
}
