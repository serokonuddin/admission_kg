<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\sttings\Classes;
use App\Models\sttings\Sessions;
use App\Models\sttings\Subjects;
use App\Models\Exam\Exam;

class SubjectMarkTerm extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'class_code','subject_id','marks_for', 'total_mark', 'pass_mark','created_by'
        // Add other fillable attributes here
    ];
    
    public function session(){
        return $this->hasOne(Sessions::class,'id','session_id');
    }
   
    public function subject(){
        return $this->hasOne(Subjects::class,'id','subject_id');
    }
}
