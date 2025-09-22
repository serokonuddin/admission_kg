<?php

namespace App\Models\Student;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardResult extends Model
{
    use HasFactory;
    protected $table = "board_results";

    protected $guarded = [];

    public function student()
    {
        return $this->hasOne(Student::class, 'student_code', 'student_code');
    }
}