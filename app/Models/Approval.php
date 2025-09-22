<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\sttings\Desination;

class Approval extends Model
{
    use HasFactory;

    protected $fillable = [
        'designation_id',
        'document_id',
        'comment',
        'status',
        'created_by',
        'updated_by',
    ];
    
    public function desination(){
        return $this->hasOne(Desination::class,'id','designation_id');
    }
}

