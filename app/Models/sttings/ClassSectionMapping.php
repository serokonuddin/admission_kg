<?php

namespace App\Models\sttings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSectionMapping extends Model
{
    use HasFactory;
    protected $table="class_wise_student_mapping";
    public function classvalue(){
        return $this->hasOne(Classes::class,'class_code','class_code');
    }
    
    public function version(){
        return $this->hasOne(Versions::class,'id','version_id');
    }
    public function shift(){
        return $this->hasOne(Shifts::class,'id','shift_id');
    }
}
