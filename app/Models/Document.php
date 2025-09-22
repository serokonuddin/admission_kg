<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'document_for',
        'ref_id',
        'subject',
        'details',
        'start_date',
        'end_date',
        'date',
        'attach_file',
        'status',
        'created_by',
        'updated_by',
    ];
    public function position(){
        return $this->hasOne(Approval::class,'document_id','id');
    }
    

}

