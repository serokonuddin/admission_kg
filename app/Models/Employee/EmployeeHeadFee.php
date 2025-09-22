<?php

namespace App\Models\Employee;
use App\Models\Fee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeHeadFee extends Model
{
    use HasFactory;
    protected $table="employee_head_fee";
    
    public function head(){
        return $this->hasOne(Fee::class,'id','head_id');
    }
    public function employee(){
        return $this->hasOne(Employee::class,'id','employee_id');
    }
}


