<?php

namespace App\Models\Website;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;
    public function type(){
        return $this->hasOne(NoticeType::class,'id','type_id');
    }
}
