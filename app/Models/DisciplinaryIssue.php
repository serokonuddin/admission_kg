<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisciplinaryIssue extends Model
{
    use HasFactory;
    protected $table = 'disciplinary_issue';
    protected $fillable = [
        'student_code',
        'file',
        'details',
        'date',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];
}
