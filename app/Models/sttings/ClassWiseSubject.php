<?php

namespace App\Models\sttings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LeasonPlan;
use App\Models\Syllabus;

class ClassWiseSubject extends Model
{
    use HasFactory;
    protected $table="class_wise_subject";

    public function classdata(){
        return $this->hasOne(Classes::class,'id','class_id');
    }
    public function subject(){
        return $this->hasOne(Subjects::class,'id','subject_id');
    }
    public function group(){
        return $this->hasOne(AcademySection::class,'id','group_id');
    }
    public function lessonPlan(){
        return $this->hasMany(LeasonPlan::class,'subject_id','subject_id');
    }
    public function syllabus(){
        return $this->hasOne(Syllabus::class,'subject_id','subject_id');
    }
}
