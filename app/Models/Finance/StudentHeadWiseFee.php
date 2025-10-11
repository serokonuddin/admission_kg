<?php

namespace App\Models\Finance;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\sttings\AcademySection;
use App\Models\sttings\Classes;
use App\Models\Student\Student;
use App\Models\sttings\Sections;
use App\Models\sttings\Sessions;
use App\Models\sttings\Shifts;
use App\Models\sttings\Versions;
use App\Models\sttings\Category;
use App\Models\sttings\House;
use App\Models\Fee;
class StudentHeadWiseFee extends Model
{
    use HasFactory;
    protected $table="student_head_wise_fee";

    protected $fillable = [
        'id','student_code',
        'session_id', 'version_id', 'class_id', 'class_code','head_id'
        ,'headid', 'unit', 'month_start_date', 'month','amount','created_by'
        // Add other fillable attributes here
    ];
    public function getHeadIdAttribute($value)
    {
        return explode(',', $value);
    }

    // Mutator for head_id to convert array back to comma-separated string
    public function setHeadIdAttribute($value)
    {
        $this->attributes['head_id'] = implode(',', $value);
    }
    public function getAmountAttribute($value)
    {
        return explode(',', $value);
    }

    // Mutator for head_id to convert array back to comma-separated string
    public function setAmountAttribute($value)
    {
        
        $this->attributes['amount'] = implode(',', $value);
    }

    // Custom relationship to fetch related Head models
    public function headdata()
    {
        return Fee::whereIn('id', $this->head_id)->get();
    }
    public function head()
    {
        return $this->belongsTo(Fee::class, 'head_id', 'id'); // Adjust the foreign and local keys if needed
    }


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
    
    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
    }
}