<?php

namespace App\Models\sttings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    use HasFactory;
    protected $table = "specializations";
    protected $fillable = ['specialization_name'];
    public function discipline()
    {
        return $this->hasOne(Discipline::class, 'id', 'discipline_id');
    }
}
