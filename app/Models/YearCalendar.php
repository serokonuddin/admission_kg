<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\sttings\Sessions;

class YearCalendar extends Model
{
    use HasFactory;
    public function session(){
        return $this->hasOne(Sessions::class,'id','year');
    }
}
