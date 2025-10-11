<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\sttings\Sessions;

class Fine extends Model
{
    use HasFactory;
    protected $table="fine";
    public function session(){
        return $this->hasOne(Sessions::class,'id','session_id');
    }
}
