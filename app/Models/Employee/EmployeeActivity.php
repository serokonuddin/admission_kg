<?php

namespace App\Models\Employee;
use App\Models\sttings\AcademySection;
use App\Models\sttings\Classes;
use App\Models\sttings\Sections;
use App\Models\sttings\Sessions;
use App\Models\sttings\Shifts;
use App\Models\sttings\Subjects;
use App\Models\sttings\Versions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeActivity extends Model
{
    use HasFactory;
    protected $table="employee_activity";
    protected $fillable = [
        'type_for', 'employee_id', 'session_id', 'version_id', 
        'shift_id','class_id','class_code','section_id','subject_id','day_name'
        ,'start_time','end_time','is_class_teacher','active'
        ,'created_by'
       // Add other fillable attributes here
   ];
    public function employee(){
        return $this->hasOne(Employee::class,'id','employee_id');
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
        return $this->hasOne(Classes::class,'class_code','class_code');
    }
    public function group(){
        return $this->hasOne(AcademySection::class,'id','group_id');
    }
    public function section(){
        return $this->hasOne(Sections::class,'id','section_id');
    }
    public function subject(){
        return $this->hasMany(Subjects::class,'id','subject_id');
    }
}
