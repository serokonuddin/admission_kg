<?php

namespace App\Models;
use App\Models\sttings\Versions;
use App\Models\sttings\Sections;
use App\Models\sttings\Sessions;
use App\Models\sttings\Classes;
use App\Models\sttings\Subjects;
use App\Models\Employee\Employee;
use App\Models\sttings\ClassWiseSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Syllabus extends Model
{
    use HasFactory;
    protected $table="syllabus";
    protected $fillable = [
        'session_id',
        'version_id',
        'class_code',
        'subject_id',
        'details',
        'pdf',
        'created_by',
        'updated_by',
    ];

    public function session(){
        return $this->hasOne(Sessions::class,'id','session_id');
    }
    public function version(){
        return $this->hasOne(Versions::class,'id','version_id');
    }
    public function classes(){
        return $this->hasOne(Classes::class,'class_code','class_code');
    }

    public function employee(){
        return $this->hasOne(Employee::class,'id','employee_id');
    }
    public function subject(){
        return $this->hasOne(Subjects::class,'id','subject_id');
    }
}
