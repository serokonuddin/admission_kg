<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermissons extends Model
{
    use HasFactory;
    protected $table="role_has_permissions";
    public function permission(){
        return $this->hasOne(Permissions::class,'id','permission_id');
    }
}
