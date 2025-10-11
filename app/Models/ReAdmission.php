<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\sttings\Sessions;

class ReAdmission extends Model
{
    use HasFactory;
    protected $table="re_admission_condition";
    public function session(){
        return $this->hasOne(Sessions::class,'id','session_id');
    }
   
}
