<?php

namespace App\Models;
use App\Models\sttings\Classes;
use App\Models\sttings\Sessions;
use App\Models\sttings\Shifts;
use App\Models\sttings\Versions;
use App\Models\sttings\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassCategoryHeadFee extends Model
{
    use HasFactory;
    protected $table="class_category_wise_head_fee";
    public function session(){
        return $this->hasOne(Sessions::class,'id','session_id');
    }
    public function version(){
        return $this->hasOne(Versions::class,'id','version_id');
    }
    public function shift(){
        return $this->hasOne(Shifts::class,'id','shift_id');
    }
    public function classes(){
        return $this->hasOne(Classes::class,'id','class_id');
    }
    
    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
    }
    
    public function head(){
        return $this->hasOne(Fee::class,'id','head_id');
    }
}
