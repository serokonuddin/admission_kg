<?php

namespace App\Models\Attendance;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherAttendance extends Model
{
    use HasFactory;
    
    protected $table = 'attendances_teacher';
}
