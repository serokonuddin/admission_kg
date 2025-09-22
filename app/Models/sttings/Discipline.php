<?php

namespace App\Models\sttings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    use HasFactory;
    protected $table="disciplines";
    public function degree(){
        return $this->hasOne(Degree::class,'id','degree_id');
    }
}
