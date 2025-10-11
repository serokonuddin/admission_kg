<?php

namespace App\Models;

use App\Models\sttings\Versions;
use App\Models\sttings\Sessions;
use App\Models\sttings\Classes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KgStudentAdmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'temporary_id',
        'category_id',
        'version_id',
        'shift_id',
        'birth_registration_number',
        'dob',
        'gender',
        'mobile',
        'payment_status',
        '_token',
    ];


    protected $table = "student_admission";

    public function session()
    {
        return $this->hasOne(Sessions::class, 'id', 'session_id');
    }

    public function version()
    {
        return $this->hasOne(Versions::class, 'id', 'version_id');
    }

    public function class()
    {
        return $this->hasOne(Classes::class, 'id', 'class_id');
    }
}
