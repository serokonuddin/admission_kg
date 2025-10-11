<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TcInactive extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_code',
        'reason',
        'date',
        'purpose',
        'status',
        'generated_by',
        'created_by',
        'updated_by',
    ];
}
