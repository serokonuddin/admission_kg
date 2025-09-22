<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $table = 'article'; // Set table name
    protected $primaryKey = 'id';
    public $timestamps = false; // Disable timestamps if you prefer to manage them manually

    protected $fillable = [
        'article_type', 'article_title', 'article', 'image', 
        'publish_date', 'status', 'created_by', 'updated_by'
    ];
}

