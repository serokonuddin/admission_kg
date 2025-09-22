<?php

namespace App\Models\sttings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sections extends Model
{
    use HasFactory;
    public function classvalue(){
        return $this->hasOne(Classes::class,'id','class_id');
    }
    public function group(){
        return $this->hasOne(AcademySection::class,'id','group_id');
    }
    public function version(){
        return $this->hasOne(Versions::class,'id','version_id');
    }
}
