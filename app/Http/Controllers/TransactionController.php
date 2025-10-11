<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\Attendance\Attendance;
use App\Models\Attendance\TeacherAttendance;
use App\Models\Employee\Employee;
use App\Models\Student\Student;
use App\Models\sttings\Sections;
use App\Models\sttings\ClassWiseSubject;
use App\Models\sttings\Classes;
use App\Models\sttings\Subjects;
use App\Models\YearCalendar;
use App\Models\Employee\EmployeeActivity;
use App\Models\sttings\Sessions;
use App\Models\sttings\Shifts;
use App\Models\sttings\Versions;
use DB;
use Auth;
class TransactionController extends Controller
{
    public function index(){
        
    }
    
    
}
