<?php

namespace App\Models\Employee;

use App\Models\Attendance\TeacherAttendance;
use App\Models\sttings\Designation;
use App\Models\sttings\Versions;
use App\Models\sttings\Subjects;
use App\Models\sttings\Shifts;
use App\Models\sttings\Category;
use App\Models\Employee\EmployeeHeadFee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    public function employeeActivity(){
        return $this->hasOne(EmployeeActivity::class,'employee_id','id');
    }
    public function designation(){
        return $this->hasOne(Designation::class,'id','designation_id');
    }
    public function subject(){
        return $this->hasOne(Subjects::class,'id','subject_id');
    }
    public function shift(){
        return $this->hasOne(Shifts::class,'id','shift_id');
    }
    public function version(){
        return $this->hasOne(Versions::class,'id','version_id');
    }
    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
    }
    public function versionemployee(){
        return $this->hasOne(Versions::class,'id','version_id');
    }
    public function employeeAttendance(){
        return $this->hasOne(TeacherAttendance::class,'employee_id','id');
        
    }
    public function employeeAllAttendance(){
        return $this->hasMany(TeacherAttendance::class,'employee_id','id');
        
    }
    public function headFee(){
        return $this->hasMany(EmployeeHeadFee::class,'employee_id','id')
                ->join('fee_head','fee_head.id','=','employee_head_fee.head_id');
    }

    public function teacherCurrentYearAttendance(){
        $end_date=date('Y-01-01');
        $start_date=date('Y-12-31', strtotime('-30 day', strtotime($end_date)));
        return $this->hasMany(TeacherAttendance::class,'employee_id','id')->whereBetween('attendance_date',[$start_date,$end_date])->orderBy('id','desc');
        
    }
    public function teacherlastMonthAttendance(){
        $end_date=date('Y-m-d');
        $start_date=date('Y-m-d', strtotime('-30 day', strtotime($end_date)));
        return $this->hasMany(TeacherAttendance::class,'employee_id','id')->whereBetween('attendance_date',[$start_date,$end_date])->orderBy('id','desc');
        
    }
    public function teacherlastWeekAttendance(){
        $end_date=date('Y-m-d');
        $start_date=date('Y-m-d', strtotime('-15 day', strtotime($end_date)));
        return $this->hasMany(TeacherAttendance::class,'employee_id','id')
        ->join('subjects','subjects.id','=','attendances_teacher.subject_id')
        ->whereBetween('attendance_date',[$start_date,$end_date])
        ->orderBy('attendance_date','desc');
        
    }
}
