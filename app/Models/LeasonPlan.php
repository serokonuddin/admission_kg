<?php

namespace App\Models;

use App\Models\sttings\Versions;
use App\Models\sttings\Sections;
use App\Models\sttings\Sessions;
use App\Models\sttings\Classes;
use App\Models\sttings\Subjects;
use App\Models\Employee\Employee;
use App\Models\sttings\ClassWiseSubject;
use App\Models\sttings\Shifts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeasonPlan extends Model
{
    use HasFactory;
    protected $table = "leason_plans";
    protected $fillable = [
        'session_id',
        'version_id',
        'shift_id',
        'class_code',
        'section_id',
        'teacher_id',
        'subject_id',
        'date',
        'time',
        'general_lesson',
        'objectives',
        'materials',
        'number',
        'wamp_up',
        'wamp_up_for_student',
        'procedure',
        'procedure_for_student',
        'assessment',
        'assessment_for_student',
        'home_work',
        'home_work_for_student',
        'status',
        'created_by',
        'updated_by',
        'pdf'
    ];

    public function session()
    {
        return $this->hasOne(Sessions::class, 'id', 'session_id');
    }
    public function version()
    {
        return $this->hasOne(Versions::class, 'id', 'version_id');
    }
    public function shift()
    {
        return $this->hasOne(Shifts::class, 'id', 'shift_id');
    }
    public function classes()
    {
        return $this->hasOne(Classes::class, 'class_code', 'class_code');
    }
    public function section()
    {
        return $this->hasOne(Sections::class, 'id', 'section_id');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'id', 'teacher_id');
    }
    public function subject()
    {
        return $this->hasOne(Subjects::class, 'id', 'subject_id');
    }
}
