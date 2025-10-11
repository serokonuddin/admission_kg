<?php

namespace App\Models\Attendance;

use App\Models\Employee\EmployeeActivity;
use App\Models\Student\StudentActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
	
	protected $fillable = [
        'attendance_date',
        'student_code', 'time', 'status', 'device_id','active','created_by'
    ];
    public function studentAttendance(){
        return $this->hasOne(StudentActivity::class,'id','activity_id');
    }
    public function employeeAttendance(){
        return $this->hasOne(EmployeeActivity::class,'id','activity_id');
    }
}
