<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademyInfo extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'academy_infos';

    // Fillable fields
    protected $fillable = [
        'academy_name',
        'short_name',
        'eiin',
        'address',
        'email',
        'phone',
        'established_year',
        'logo',
        'icon',
        'helpline_number',
        'bank_account',
    ];
}
