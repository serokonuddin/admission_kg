<?php

namespace App\Models\Website;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    public function parent()
    {
        return $this->hasOne(Page::class, 'id', 'parent_id')->orderBy('pages.serial','asc');
    }
    public function child()
    {
        return $this->hasMany(Page::class, 'parent_id', 'id')->where('status',1)->orderBy('pages.serial','asc');
    }
}
