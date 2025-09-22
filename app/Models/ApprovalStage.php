<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalStage extends Model
{
    use HasFactory;

    protected $table = 'approval_stage';
    protected $fillable = [
        'session_id',
        'approval_for',
        'designation_id',
        'level',
        'is_approved',
        'status',
        'created_by',
        'updated_by',
    ];
}

