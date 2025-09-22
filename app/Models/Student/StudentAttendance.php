<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
    use HasFactory;
    protected $table = 'student_attendance';

    protected $fillable = [
        'student_code',
        'session_id',
        'exam_id',
        'no_of_working_days',
        'total_attendance',
        'created_by',
    ];

    /**
     * Define the relationship with the Student model.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
