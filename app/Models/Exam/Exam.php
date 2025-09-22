<?php

namespace App\Models\Exam;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\sttings\Classes;
use App\Models\sttings\Sessions;

class Exam extends Model
{
    use HasFactory;
    protected $table="exam";

    protected $fillable = [
        'session_id',
        'class_code', 'exam_title', 'start_date', 'end_date','created_by'
        // Add other fillable attributes here
    ];

    public function classdata(){
        return $this->hasOne(Classes::class,'class_code','class_code');
    }
    public function session(){
        return $this->hasOne(Sessions::class,'id','session_id');
    }
    
}
