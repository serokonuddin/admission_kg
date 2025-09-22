<?php

namespace App\Models\sttings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SubjectMarkTerm;
use App\Models\Exam\ExamHighestMark;
use App\Models\sttings\ClassWiseSubject;

class Subjects extends Model
{
    use HasFactory;
    public function group(){
        return $this->hasOne(AcademySection::class,'id','group_id');
    }

    public function subjectMarkTerms(){
        return $this->hasMany(SubjectMarkTerm::class,'subject_id','id');
    }

    public function subject_wise_class(){
        return $this->hasOne(ClassWiseSubject::class,'subject_id','id');
    }
    public function subjectHighestMark(){
        return $this->hasOne(ExamHighestMark::class,'subject_id','subject_id');
    }
}
