<?php

namespace App\Models;
use App\Models\sttings\Versions;
use App\Models\sttings\Sessions;
use App\Models\sttings\Classes;
use App\Models\ClassCategoryHeadFee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionOpen extends Model
{
    use HasFactory;
    protected $table="admission_open";

    public function session(){
        return $this->hasOne(Sessions::class,'id','session_id');
    }
    public function version(){
        return $this->hasOne(Versions::class,'id','version_id');
    }
    public function class(){
        return $this->hasOne(classes::class,'class_code','class_id')->orderBy('id','desc');
    }
    public function admissionFee(){
        $session=DB::table('sessions')->where('active',1)->first();
        return $this->hasOne(ClassCategoryHeadFee::class,'id','class_id')
        ->where('effective_from','<=',date('Y-m-d'))->where('session_id',$session->id);
    }
}
