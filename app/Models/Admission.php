<?php

namespace App\Models;
use App\Models\sttings\Versions;
use App\Models\sttings\Sections;
use App\Models\sttings\Sessions;
use App\Models\sttings\classes;
use App\Models\sttings\AcademySection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    use HasFactory;
    protected $table="admission_temporary";

    public function session(){
        return $this->hasOne(Sessions::class,'id','session_id');
    }
    public function version(){
        return $this->hasOne(Versions::class,'id','version_id');
    }
    public function class(){
        return $this->hasOne(classes::class,'id','class_id');
    }
    public function group(){
        return $this->hasOne(AcademySection::class,'id','group_id');
    }
    public function section(){
        return $this->hasOne(Sections::class,'id','section_id');
    }
   
}
