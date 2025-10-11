<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReconcilationDate extends Model
{
    use HasFactory;
    protected $table = 'reconcilation_date';
    
    protected $fillable = [
        'start_date', 'end_date', 'submit_date', 'status', 'created_by', 'updated_by'
    ];
}
