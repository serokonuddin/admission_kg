<?php

namespace App\Models;
use App\Models\sttings\Versions;
use App\Models\sttings\Sections;
use App\Models\sttings\Sessions;
use App\Models\sttings\classes;
use App\Models\sttings\AcademySection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAdmission extends Model
{
	use HasFactory;
    protected $table="student_admission";
    protected $fillable = [
        'session_id',
        'class_id', 'version_id','shift_id','category_id', 'service_holder_name', 'service_name', 'name_of_service','in_service',
        'office_address',
        'name_of_staff', 'staff_designation','staff_id', 'staff_certification', 'arm_certification', 'gen_id','section'
        ,'name_en', 'name_bn','dob', 'gender', 'gurdian_name', 'mobile','birth_registration_number', 'birth_image','photo'
        // Add other fillable attributes here
    ];
}