<?php

namespace App\Models;

use App\Models\Employee\Employee;
use App\Models\Student\Student;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'password',
        'photo',
        'status',
        'group_id',
        'is_admission',
        'ref_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Always encrypt password when it is updated.
     *
     * @param $value
     * @return string
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'group_id');
    }
    public function permissionmenu()
    {
        return $this->hasMany(RolePermissons::class, 'role_id', 'group_id');
    }

    public function getMenu($menuname, $column)
    {
        $role_id = Auth::user()->group_id;
        if ($role_id == 2) {
            return 1;
        }
        return RolePermissons::join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where('role_id', $role_id)
            ->where($column, $menuname)
            ->exists();
    }
    public function student()
    {
        return $this->hasOne(Student::class, 'student_code', 'ref_id');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'id', 'ref_id');
    }
}
