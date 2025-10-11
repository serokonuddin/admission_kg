<?php

namespace App\Models\Employee;
use App\Models\Fee;
use App\Models\sttings\Sessions;
use App\Models\sttings\Versions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeFeeTranjection extends Model
{
    use HasFactory;
    protected $table="employee_fee_tranjection";
    
    
    public function employee(){
        return $this->hasOne(Employee::class,'id','employee_id');
    }
    
    public function session(){
        return $this->hasOne(Sessions::class,'id','session_id');
    }
    public function version(){
        return $this->hasOne(Versions::class,'id','version_id');
    }
}


