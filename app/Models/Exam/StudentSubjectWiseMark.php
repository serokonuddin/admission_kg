<?php

namespace App\Models\Exam;

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

class StudentSubjectWiseMark extends Model
{
    use HasFactory;
    protected $table = "student_subject_wise_mark";
    protected $fillable = [
        'session_id',
        'exam_id',
        'class_code',
        'subject_id',
        'student_code',
        'ct1',
        'ct2',
        'ct3',
        'ct4',
        'ct',
        'cq',
        'cq_grace',
        'cq_total',
        'mcq',
        'mcq_grace',
        'mcq_total',
        'practical',
        'practical_grace',
        'practical_total',
        'total',
        'conv_total',
        'ct_conv_total',
        'gpa_point',
        'gpa',
        'is_fourth_subject',
        'is_absent',
        'non_value',
        'is_ct_abs',
        'is_quiz_abs',
        'is_prac_abs',
        'is_mcq_abs',
        'is_cq_abs',
        'status',
        'created_by'
        // Add other fillable attributes here
    ];

    public function session()
    {
        return $this->hasOne(Sessions::class, 'id', 'session_id');
    }

    public function exam()
    {
        return $this->hasOne(Exam::class, 'id', 'exam_id');
    }

    public function subject()
    {
        return $this->hasOne(Subjects::class, 'id', 'subject_id');
    }
    public function student()
    {
        return $this->hasOne(Student::class, 'student_code', 'student_code');
    }
    public function subjectmarkterms()
    {
        return $this->hasMany(SubjectMarkTerm::class, 'subject_id', 'subject_id');
    }
}