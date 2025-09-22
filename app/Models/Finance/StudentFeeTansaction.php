<?php

namespace App\Models\Finance;
use App\Models\sttings\Classes;
use App\Models\sttings\Sessions;
use App\Models\sttings\Shifts;
use App\Models\sttings\Versions;
use App\Models\sttings\Category;
use App\Models\Student\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Fee;
class StudentFeeTansaction extends Model
{
    use HasFactory;
    protected $table="student_fee_tranjection";
    protected $fillable = [
        'id','student_code',
        'session_id', 'version_id', 'class_id', 'class_code','head_id'
        ,'headid', 'unit', 'month_start_date', 'month','amount','created_by'
        // Add other fillable attributes here
    ];
    public function Student(){
        return $this->hasOne(Student::class,'student_code','student_code');
    }
    public function session(){
        return $this->hasOne(Sessions::class,'id','session_id');
    }
    public function version(){
        return $this->hasOne(Versions::class,'id','version_id');
    }
    public function shift(){
        return $this->hasOne(Shifts::class,'id','shift_id');
    }
    public function classes(){
        return $this->hasOne(Classes::class,'id','class_id');
    }
    public function heads(){
        return $this->hasOne(StudentHeadWiseFee::class,'payment_final_id','common_id');
    }
    public function headdata(){
        return $this->hasOne(Fee::class,'id','head_id');
    }
    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
    }
}
