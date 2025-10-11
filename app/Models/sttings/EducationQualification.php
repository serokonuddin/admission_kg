<?php

namespace App\Models\sttings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationQualification extends Model
{
    use HasFactory;
    protected $table="employee_education";
    public function discipline(){
        return $this->hasOne(Discipline::class,'id','discipline_id');
    }
    public function specialization(){
        return $this->hasOne(Specialization::class,'id','specialization_id');
    }
    public function degree(){
        return $this->hasOne(Degree::class,'id','degree_id');
    }

}
