<?php

namespace App\Models\sttings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    public function shift()
    {
        return $this->hasOne(Shifts::class, 'id', 'shift_id');
    }
    public function version()
    {
        return $this->hasOne(Versions::class, 'id', 'version_id');
    }
    public function sections()
    {
        return $this->hasMany(Sections::class, 'class_code', 'class_code');
    }
}