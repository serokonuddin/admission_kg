<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryWiseLeaveBalance extends Model
{
    use HasFactory;

    protected $table = 'category_wise_leave_balance';
    protected $fillable = [
        'session_id',
        'category_id',
        'yearly_total',
        'status',
        'created_by',
        'updated_by',
    ];
}

