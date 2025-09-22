<?php

namespace App\Models;

use App\Models\sttings\Classes;
use App\Models\sttings\Sections;
use App\Models\sttings\Sessions;
use App\Models\sttings\Shifts;
use App\Models\sttings\Versions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SMS extends Model
{
    use HasFactory;
    protected $table ="sms_master";

    public function session()
    {
        return $this->hasOne(Sessions::class, 'id', 'session_id');
    }
    public function version()
    {
        return $this->hasOne(Versions::class, 'id', 'version_id');
    }
    public function classes()
    {
        return $this->hasOne(Classes::class, 'class_code', 'class_code');
    }
    public function shift()
    {
        return $this->hasOne(Shifts::class, 'id', 'shift_id');
    }
    public function section()
    {
        return $this->hasOne(Sections::class, 'id', 'section_id');
    }

}
