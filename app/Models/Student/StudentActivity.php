<?php

namespace App\Models\Student;

use App\Models\Attendance\Attendance;
use App\Models\sttings\AcademySection;
use App\Models\sttings\Classes;
use App\Models\sttings\Sections;
use App\Models\sttings\Sessions;
use App\Models\sttings\Shifts;
use App\Models\sttings\Versions;
use App\Models\sttings\Category;
use App\Models\sttings\House;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentActivity extends Model
{
    use HasFactory;
    protected $table="student_activity";
    protected $fillable = [
         'session_id', 'version_id', 'shift_id', 'class_id', 'class_code', 
                        'group_id', 'section_id', 'category_id', 'roll', 'student_code','active','created_by'
        // Add other fillable attributes here
    ];
    public function Student(){
        return $this->hasOne(Student::class,'student_code','student_code');
    }
    public function attendance(){
        return $this->hasOne(Attendance::class,'activity_id','id');
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
    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
    }
    public function house(){
        return $this->hasOne(House::class,'id','house_id');
    }
}