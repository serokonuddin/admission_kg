<?php

namespace App\Http\Controllers;

use App\Models\AcademyInfo;
use Illuminate\Http\Request;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {



        Session::put('activemenu', 'dashboard');
        Session::put('activesubmenu', '');
        //dd(Auth::user());
        if (Auth::user()->group_id == 2) {
            $academy_info = AcademyInfo::first();
            return view('admin.dashboard.mainadmin', compact('academy_info'));
        } elseif (Auth::user()->group_id == 3) {
            return view('admin.dashboard.teacher');
        } elseif (Auth::user()->group_id == 7) {
            return view('admin.dashboard.register');
        } elseif (Auth::user()->group_id == 4 && Auth::user()->is_admission == 0 && Auth::user()->is_profile_update == 0) {

            return Redirect(route('StudentProfile', 0));
            //return view('admin.dashboard.student');
        } elseif (Auth::user()->group_id == 4 && Auth::user()->is_admission == 1) {
            //dd(Auth::user()->ref_id);
            $version_id = DB::table('student_activity')
                ->where('student_code', Auth::user()->ref_id)
                ->value('version_id');
            //dd($version_id);
            //return Redirect(route('StudentProfile',0));
            return view('admin.dashboard.student', compact('version_id'));
        } elseif (Auth::user()->group_id == 4) {
            $version_id = DB::table('student_activity')
                ->where('student_code', Auth::user()->ref_id)
                ->value('version_id');
            //return Redirect(route('StudentProfile',0));
            return view('admin.dashboard.student', compact('version_id'));
        } else {
            return view('admin.dashboard.mainadmin');
        }
    }
    public function feesDashboard()
    {
        return view('admin.dashboard.finance');
    }
    public function academyDashboard()
    {
        return view('admin.dashboard.routine');
    }
    public function calendarDashboard()
    {
        return view('admin.dashboard.calendar');
    }
    // public function studentsDashboard()
    // {
    //     // $session = Sessions::where('session_name', date('Y'))->first();
    //     $session = Sessions::where('session_name', '2025')->first();
    //     $type_for = array(1 => 'Primary', 2 => 'Secondary', 3 => 'College');
    //     // $shifts=Shifts::where('active',1)->whereIn('id',[1,2])->get();
    //     //$versions=Versions::where('active',1)->get();
    //     $econdition = array(
    //         'session_id' => $session->id,
    //         'version_id' => '',
    //         'shift_id' => '',
    //         'class_id' => '',
    //         'section_id' => '',
    //         'student_code' => '',
    //     );
    //     $studentdata = getStudent('class_for', 'class_for,count(student_code) count', $econdition);

    //     $studentdata = collect($studentdata)->groupBy('class_for');

    //     return view('admin.dashboard.studentd', compact('type_for', 'studentdata'));
    // }

    public function studentsDashboard()
    {
        // Fetch the session for the year 2025
        $session = Sessions::where('active', 1)->orderBy('created_at', 'desc')->first();

        if (!$session) {
            return back()->with('error', 'Session not found!');
        }

        // Define types for classes
        $type_for = [
            0 => 'Primary',
            1 => 'Secondary',
            2 => 'College',
        ];

        // Fetch student data
        $studentdata = getStudentByClassType($session->id);

        $studentcollege = getStudentByCollegeClassType($session->id - ((date('m') > 7) ? 0 : 1));
        if (count($studentdata) > 1) {
            $studentdata[2] = $studentcollege[2];
        }

        // dd($studentdata);

        // Return view with data
        return view('admin.dashboard.studentd', compact('type_for', 'studentdata'));
    }

    public function studentGetTypeStudent($type)
    {
        $session = Sessions::where('session_name', date('Y'))->first();
        $shifts = Shifts::where('active', 1)->whereIn('id', [1, 2])->orderBy('id', 'asc')->get();

        $versions = Versions::where('active', 1)->orderBy('id', 'asc')->get();

        $econdition = array(
            'session_id' => $session->id,
            'version_id' => '',
            'shift_id' => '',
            'class_id' => '',
            'section_id' => '',
            'student_code' => '',
            'class_for' => $type,
        );
        $studentdata = getStudent('shift_id,version_id', 'shift_id,version_id,shift_name,version_name,count(student_code) count', $econdition);

        $studentdata = collect($studentdata)->groupBy(['shift_name', 'version_name']);


        return view('admin.dashboard.studentshift', compact('versions', 'shifts', 'type', 'studentdata'));
    }
    public function studentClassWise($shift_id, $type, $version_id)
    {

        $session = Sessions::where('session_name', date('Y'))->first();
        $shifts = Shifts::where('active', 1)->where('id', $shift_id)->orderBy('id', 'asc')->first();

        $versions = Versions::where('active', 1)->where('id', $version_id)->orderBy('id', 'asc')->first();

        $econdition = array(
            'session_id' => $session->id,
            'version_id' => $version_id,
            'shift_id' => $shift_id,
            'class_code' => '',
            'section_id' => '',
            'student_code' => '',
            'class_for' => $type,
        );
        $studentdata = getStudent('shift_id,version_id,class_code,shift_name,version_name,class_name', 'shift_id,version_id,class_code,shift_name,version_name,class_name,count(student_code) count', $econdition);

        $studentdata = collect($studentdata)->groupBy(['class_name']);


        return view('admin.dashboard.studentClass', compact('studentdata', 'type', 'shifts', 'versions'));
    }
    public function studentClassWiseSection($shift_id, $type, $version_id, $class_code)
    {

        $session = Sessions::where('session_name', date('Y'))->first();
        $shifts = Shifts::where('active', 1)->where('id', $shift_id)->whereIn('id', [1, 2])->orderBy('id', 'asc')->first();

        $versions = Versions::where('active', 1)->where('id', $version_id)->orderBy('id', 'asc')->first();
        $class = Classes::where('active', 1)->where('class_code', $class_code)->orderBy('id', 'asc')->first();

        $econdition = array(
            'session_id' => $session->id,
            'version_id' => $version_id,
            'shift_id' => $shift_id,
            'class_code' => $class_code,
            'section_id' => '',
            'student_code' => '',
            'class_for' => $type,
        );
        $studentdata = getStudent('shift_id,version_id,class_code,section_id,shift_name,version_name,class_name,section_name', 'shift_id,version_id,class_code,section_id,shift_name,version_name,class_name,section_name,count(student_code) count', $econdition);

        $studentdata = collect($studentdata)->groupBy(['section_name']);
        // dd($studentdata);

        return view('admin.dashboard.studentSection', compact('studentdata', 'class', 'shifts', 'versions', 'type'));
    }
    public function studentList($shift_id, $type, $version_id, $class_code, $section_id)
    {

        $session = Sessions::where('session_name', date('Y'))->first();
        $shifts = Shifts::where('active', 1)->where('id', $shift_id)->whereIn('id', [1, 2])->orderBy('id', 'asc')->first();

        $versions = Versions::where('active', 1)->where('id', $version_id)->orderBy('id', 'asc')->first();
        $class = Classes::where('active', 1)->where('class_code', $class_code)->orderBy('id', 'asc')->first();
        $section = Sections::where('active', 1)->where('id', $section_id)->orderBy('id', 'asc')->first();

        $econdition = array(
            'session_id' => $session->id,
            'version_id' => $version_id,
            'shift_id' => $shift_id,
            'class_code' => $class_code,
            'section_id' => $section_id,
            'student_code' => '',
            'class_for' => $type,
        );
        $studentdata = getStudent('', 'id,shift_id,version_id,class_code,section_id,shift_name,version_name,class_name,section_name,student_code,mobile,email,photo,first_name,last_name', $econdition);




        return view('admin.dashboard.studentList', compact('studentdata', 'section', 'shifts', 'versions', 'class', 'type'));
    }
    public function studentStudentList(Request $request)
    {
        $session = Sessions::where('session_name', date('Y'))->first();
        $shifts = Shifts::where('active', 1)->whereIn('id', [1, 2])->orderBy('id', 'asc')->get();

        $versions = Versions::where('active', 1)->orderBy('id', 'asc')->get();
        return view('admin.dashboard.studentClass', compact('versions', 'shifts', 'type'));
    }

    public function employeesDashboard()
    {
        $session = Sessions::where('session_name', date('Y'))->first();
        $conditiona = array(
            'session_id' => $session->id,
            'category_id' => '',
            'version_id' => '',
            'shift_id' => '',
            'class_id' => '',
            'section_id' => '',
            'emp_id' => '',
            'start_date' => date('Y-m-26'),
            'end_date' => date('Y-m-26'),
        );
        $employeedata = getEmployee('category_name', 'category_name,count(em.id) count', $conditiona);
        // dd($employeedata);
        $employeedata = collect($employeedata)->groupBy('category_name');

        return view('admin.dashboard.employeesd', compact('employeedata'));
    }
    public function getTeacherFor($type)
    {
        if ($type == 'Staff') {
            $session = Sessions::where('session_name', date('Y'))->first();
            $conditiona = array(
                'session_id' => $session->id,
                'category_id' => '8',
                'version_id' => '',
                'shift_id' => '',
                'class_id' => '',
                'section_id' => '',
                'emp_id' => '',
                'start_date' => date('Y-m-26'),
                'end_date' => date('Y-m-26'),
            );
            $employeedata = getEmployee('', 'emp_id,em.id,employee_name,email,mobile,photo,designation_name', $conditiona);

            return view('admin.dashboard.stafflist', compact('employeedata'));
        } else {
            $session = Sessions::where('session_name', date('Y'))->first();
            $conditiona = array(
                'session_id' => $session->id,
                'category_id' => '7',
                'version_id' => '',
                'shift_id' => '',
                'class_id' => '',
                'section_id' => '',
                'emp_id' => '',
                'start_date' => date('Y-m-26'),
                'end_date' => date('Y-m-26'),
            );
            $employeedata = getEmployee('employee_for', 'employee_for,count(em.id) count', $conditiona);
            // dd($employeedata);
            $employeedata = collect($employeedata)->groupBy('employee_for');

            return view('admin.dashboard.employeesdfor', compact('employeedata'));
        }
    }
    public function getTeacherList($for)
    {
        $session = Sessions::where('session_name', date('Y'))->first();
        $conditiona = array(
            'session_id' => $session->id,
            'category_id' => '7',
            'employee_for' => $for,
            'version_id' => '',
            'shift_id' => '',
            'class_id' => '',
            'section_id' => '',
            'emp_id' => '',
            'start_date' => date('Y-m-26'),
            'end_date' => date('Y-m-26'),
        );
        $employeedata = getEmployee('', 'emp_id,em.id,employee_name,email,mobile,photo,designation_name', $conditiona);

        return view('admin.dashboard.getTeacherList', compact('employeedata', 'for'));
    }
    public function classDashboardDetailsRoutine($shift_id, $version_id, $type)
    {
        // $dayname = date('D', strtotime(date('Y-m-d')));
        // $daytime = date('H:i:s');

        if ($type == 'college') {
            $type_for = 3;
        } elseif ($type == 'Primary') {
            $type_for = 1;
        } else {
            $type_for = 2;
        }


        $session = Sessions::where('session_name', date('Y'))->first();

        $sections = Sections::join('classes', 'classes.id', '=', 'sections.class_id')
            ->where('classes.session_id', $session->id)
            ->where('classes.shift_id', $shift_id)
            ->where('classes.version_id', $version_id)
            ->where('classes.class_for', $type_for)
            ->select('sections.*', 'class_name')
            ->get();
        foreach ($sections as $key => $section) {
            $routines = EmployeeActivity::with(['employee', 'subject', 'classes', 'section'])

                ->join('classes', 'classes.id', '=', 'employee_activity.class_id')
                ->join('sections', 'sections.id', '=', 'employee_activity.section_id')
                ->where('employee_activity.section_id', $section->id)
                ->where('employee_activity.class_id', $section->class_id)
                ->where('employee_activity.session_id', $session->id)
                ->where('employee_activity.shift_id', $shift_id)
                ->distinct('start_time')->orderBy('start_time')
                ->selectRaw("employee_activity.*,
            case day_name
            when 'Mon' then 3
            when 'Tue' then 4
            when 'Wed' then 5
            when 'Thu' then 6
            when 'Fri' then 7
            when 'Sat' then 1
            when 'Sun' then 2
            end as day_nr
            ")
                ->get();
            $routines = collect($routines)->sortBy('day_nr');
            $routines = collect($routines)->groupBy(['day_name', 'start_time']);

            $sections[$key]->routine = $routines;
            // dd($routine);
            $routinetime = EmployeeActivity::select('start_time', 'end_time')
                ->where('section_id', $section->id)
                ->where('class_id', $section->class_id)
                ->where('session_id', $session->id)
                ->where('shift_id', $shift_id)
                ->whereNotNull('day_name')->distinct('start_time')->orderBy('start_time')->get();
            $sections[$key]->routinetime = $routinetime;
        }

        return view('admin.dashboard.classRoutine', compact('sections', 'type'));
    }
    public function classDashboardOngoingDetails($shift_id, $version_id, $type)
    {

        // $dayname = date('D', strtotime(date('Y-m-d')));
        // $daytime = date('H:i:s');
        $dayname = 'Sun';
        $daytime = '08:20:00';
        if ($type == 'college') {
            $type_for = 3;
        } elseif ($type == 'Primary') {
            $type_for = 1;
        } else {
            $type_for = 2;
        }


        $routinecurrenttime = EmployeeActivity::with(['employee', 'subject', 'classes', 'section', 'shift', 'version'])
            ->where('shift_id', $shift_id)
            ->where('version_id', $version_id)
            ->where('type_for', $type_for)
            ->where('day_name', $dayname)
            ->where('start_time', '<=', $daytime)
            ->where('end_time', '>=', $daytime)
            ->distinct('start_time')->orderBy('start_time')
            ->selectRaw("employee_activity.*")
            ->get();
        $session = Sessions::where('session_name', date('Y'))->first();
        $routines = EmployeeActivity::with(['employee', 'subject', 'classes', 'section'])

            ->join('classes', 'classes.id', '=', 'employee_activity.class_id')
            ->join('sections', 'sections.id', '=', 'employee_activity.section_id')
            ->where('employee_activity.session_id', $session->id)
            ->where('employee_activity.shift_id', $shift_id)
            ->where('employee_activity.version_id', $version_id)
            ->where('employee_activity.type_for', $type_for)
            ->where('day_name', $dayname)->distinct('start_time')->orderBy('start_time')
            ->selectRaw("employee_activity.*,
                 case day_name
                 when 'Mon' then 3
                 when 'Tue' then 4
                 when 'Wed' then 5
                 when 'Thu' then 6
                 when 'Fri' then 7
                 when 'Sat' then 1
                 when 'Sun' then 2
                 end as day_nr
                 ")
            ->get();
        $routines = collect($routines)->sortBy('day_nr');
        $routines = collect($routines)->groupBy(['day_name', 'start_time']);
        // dd($routine);
        $routinetime = EmployeeActivity::select('start_time', 'end_time', 'class_id', 'section_id')
            ->where('day_name', $dayname)->distinct('start_time')->orderBy('start_time')->get();

        return view('admin.dashboard.class', compact('routines', 'routinecurrenttime', 'routinetime'));
    }
    public function classDashboardDetails()
    {
        // $dayname = date('D', strtotime(date('Y-m-d')));
        // $daytime = date('H:i:s');
        $dayname = 'Sun';
        $daytime = '08:20:00';
        // $routines=EmployeeActivity::with(['employee','subject','section','shift','version'])
        //         ->join('classes','classes.id','=','employee_activity.class_id')
        //         ->join('sections','sections.id','=','employee_activity.section_id')
        //         ->where('day_name',$dayname)->distinct('start_time')->orderBy('start_time')
        //         ->selectRaw("employee_activity.*,classes.class_name,sections.section_name")
        //         ->get();
        //         $routines=collect($routines)->groupBy(['class_name','section_name']);

        $routinecurrenttime = EmployeeActivity::with(['employee', 'subject', 'classes', 'section', 'shift', 'version'])

            ->where('day_name', $dayname)
            ->where('start_time', '<=', $daytime)
            ->where('end_time', '>=', $daytime)
            ->distinct('start_time')->orderBy('start_time')
            ->selectRaw("employee_activity.*")
            ->get();
        $session = Sessions::where('session_name', date('Y'))->first();
        $routines = EmployeeActivity::with(['employee', 'subject', 'classes', 'section'])
            ->join('classes', 'classes.id', '=', 'employee_activity.class_id')
            ->join('sections', 'sections.id', '=', 'employee_activity.section_id')
            ->where('day_name', $dayname)->distinct('start_time')->orderBy('start_time')
            ->selectRaw("employee_activity.*,
                 case day_name
                 when 'Mon' then 3
                 when 'Tue' then 4
                 when 'Wed' then 5
                 when 'Thu' then 6
                 when 'Fri' then 7
                 when 'Sat' then 1
                 when 'Sun' then 2
                 end as day_nr
                 ")
            ->get();
        $routines = collect($routines)->sortBy('day_nr');
        $routines = collect($routines)->groupBy(['day_name', 'start_time']);
        // dd($routine);
        $routinetime = EmployeeActivity::select('start_time', 'end_time')
            ->where('day_name', $dayname)->distinct('start_time')->orderBy('start_time')->get();

        return view('admin.dashboard.class', compact('routines', 'routinecurrenttime', 'routinetime'));
    }
    public function classDashboard()
    {
        $type_for = array(1 => 'Primary', 2 => 'Secondary');
        $shifts = Shifts::where('active', 1)->whereIn('id', [1, 2])->get();
        $versions = Versions::where('active', 1)->get();



        return view('admin.dashboard.classmain', compact('versions', 'shifts', 'type_for'));
    }
    public function classDashboardSecond($for)
    {
        $type_for = array(1 => 'Primary', 2 => 'Secondary');
        $shifts = Shifts::where('active', 1)->whereIn('id', [1, 2])->get();
        $versions = Versions::where('active', 1)->get();



        return view('admin.dashboard.classmainSecond', compact('versions', 'shifts', 'type_for', 'for'));
    }
    public function attendanceDashboard()
    {
        Session::put('activemenu', 'dashboard');
        Session::put('activesubmenu', '');

        $type_for = array(
            1 => 'Primary',
            2 => 'Secondary',
            3 => 'College'
        );
        $session = Sessions::where('session_name', date('Y'))->first();
        $condition = array(
            'session_id' => $session->id,
            'version_id' => '',
            'shift_id' => '',
            'class_id' => '',
            'section_id' => '',
            'student_code' => '',
        );
        $econdition = array(
            'session_id' => '',
            'version_id' => '',
            'shift_id' => '',
            'class_id' => '',
            'section_id' => '',
            'student_code' => '',
        );
        $studentdata = getStudent('class_for', 'class_for,count(student_code) count', $condition);

        $studentdata = collect($studentdata)->groupBy('class_for');

        $conditiona = array(
            'session_id' => $session->id,
            'version_id' => '',
            'shift_id' => '',
            'class_id' => '',
            'section_id' => '',
            'student_code' => '',
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d'),
        );
        $studentAttandance = getStudentAttandance('class_for,status', 'class_for,status,count(student_code) count', $conditiona);

        $studentAttandance = collect($studentAttandance)->groupBy('class_for');
        $conditiona = array(
            'session_id' => $session->id,
            'category_id' => '',
            'version_id' => '',
            'shift_id' => '',
            'class_id' => '',
            'section_id' => '',
            'emp_id' => '',
            'start_date' => date('Y-m-26'),
            'end_date' => date('Y-m-26'),
        );
        // dd($studentAttandance);
        $employeedata = getEmployee('category_name', 'category_name,count(em.id) count', $conditiona);
        // dd($employeedata);
        $employeedata = collect($employeedata)->groupBy('category_name');

        $conditiona = array(
            'session_id' => $session->id,
            'category_id' => '',
            'version_id' => '',
            'shift_id' => '',
            'class_id' => '',
            'section_id' => '',
            'emp_id' => '',
            'start_date' => date('Y-m-26'),
            'end_date' => date('Y-m-26'),
        );
        $employeedataAttandance = getEmployeeAttandance('category_name,category_id,status', 'category_name,category_id,status,count(id) count', $conditiona);
        $employeedataAttandance = collect($employeedataAttandance)->groupBy('category_id');
        //dd($employeedataAttandance);
        // dd($employeedataAttandance);

        //dd($studentseventvalue);
        return view('admin.dashboard.admin', compact('type_for', 'studentdata', 'studentAttandance', 'employeedata', 'employeedataAttandance', 'employeedata', 'studentdata'));
    }
    public function attendanceDashboardDetails($type)
    {
        Session::put('activemenu', 'dashboard');
        Session::put('activesubmenu', '');
        if ($type == 'College') {
            $type_for = 3;
        } elseif ($type == 'Primary') {
            $type_for = 1;
        } else {
            $type_for = 2;
        }
        $session = DB::table('sessions')->where('session_name', date('Y'))->first();
        $sections = Sections::join('classes', 'classes.id', '=', 'sections.class_id')
            ->join('shifts', 'shifts.id', '=', 'classes.shift_id')
            ->select(
                'sections.*',
                'shifts.shift_name',
                'classes.class_name',
                'classes.class_code',
                'classes.session_id',
                'classes.version_id',
                'classes.class_for',
                'classes.shift_id'
            )
            ->where('class_for', $type_for)
            ->where('classes.session_id', $session->id)
            ->get();
        $sections = $sections->groupBy('shift_name')->map(function ($q) {
            return $q->groupBy('class_name');
        })->toArray();


        $studentcount = Student::join('student_activity', 'student_activity.student_code', '=', 'students.student_code')
            ->join('classes', 'classes.id', '=', 'student_activity.class_id')
            ->where('students.active', 1)
            ->where('class_for', $type_for)
            ->where('classes.session_id', $session->id)
            ->selectRaw('count(students.id) count,classes.shift_id')
            ->groupBy('classes.shift_id')
            ->orderBy('classes.shift_id', 'asc')
            ->get();
        //dd($studentcount);

        foreach ($sections as $key => $shift) {

            foreach ($shift as $k => $classdata) {

                foreach ($classdata as $i => $secttiondata) {
                    $sections[$key][$k][$i]['attendance'] = array();
                    $sections[$key][$k][$i]['attendance'] = Attendance::selectRaw('count(attendances.id) count,attendances.status')
                        ->join('student_activity', 'student_activity.student_code', '=', 'attendances.student_code')
                        ->where('student_activity.section_id', $secttiondata['id'])
                        ->where('student_activity.session_id', $session->id)
                        ->where('attendance_date', date('Y-m-d'))
                        ->groupBy('attendances.status')->orderBy('attendances.status')->get();
                }
            }
        }

        $todayattendancestudent = Attendance::selectRaw('count(attendances.id) count,attendances.status')
            ->join('student_activity', 'student_activity.student_code', '=', 'attendances.student_code')
            ->where('attendance_date', date('Y-m-d'))->groupBy('student_activity.shift_id')->groupBy('attendances.status')->orderBy('student_activity.shift_id')->orderBy('attendances.status')->get();



        $employeetotalcount = Employee::selectRaw('count(id) count,shift_id')->whereIn('shift_id', [1, 2])->where('category_id', 7)->groupBy('shift_id')->orderBy('shift_id', 'asc')->get();
        $nonemployeetotalcount = Employee::selectRaw('count(id) count,shift_id')->where('category_id', 8)->groupBy('shift_id')->get();

        $teacherAttendance = TeacherAttendance::selectRaw('count(attendances_teacher.id) count,attendances_teacher.status')
            ->join('employees', 'employees.id', '=', 'attendances_teacher.employee_id')
            ->whereIn('attendances_teacher.id', function ($row) {
                return $row->from('attendances_teacher')->selectRaw('max(id) id')
                    ->where('attendance_date', date('Y-m-d'))->groupBy('employee_id');
            })
            ->where('category_id', 7)
            ->where('attendances_teacher.shift_id', 1)
            ->where('attendance_date', date('Y-m-d'))->groupBy('attendances_teacher.status')->get();
        $stafAttendance = TeacherAttendance::selectRaw('count(attendances_teacher.id) count,attendances_teacher.status')
            ->join('employees', 'employees.id', '=', 'attendances_teacher.employee_id')
            ->whereIn('attendances_teacher.id', function ($row) {
                return $row->from('attendances_teacher')->selectRaw('max(id) id')
                    ->where('attendance_date', date('Y-m-d'))->groupBy('employee_id');
            })
            ->where('attendances_teacher.shift_id', 1)
            ->where('category_id', 8)
            ->where('attendance_date', date('Y-m-d'))->groupBy('attendances_teacher.status')->get();


        $teacherAttendanced = TeacherAttendance::selectRaw('count(attendances_teacher.id) count,attendances_teacher.status')
            ->join('employees', 'employees.id', '=', 'attendances_teacher.employee_id')
            ->whereIn('attendances_teacher.id', function ($row) {
                return $row->from('attendances_teacher')->selectRaw('max(id) id')
                    ->where('attendance_date', date('Y-m-d'))->groupBy('employee_id');
            })
            ->where('category_id', 7)
            ->where('attendances_teacher.shift_id', 2)
            ->where('attendance_date', date('Y-m-d'))->groupBy('attendances_teacher.status')->get();
        $stafAttendanced = TeacherAttendance::selectRaw('count(attendances_teacher.id) count,attendances_teacher.status')
            ->join('employees', 'employees.id', '=', 'attendances_teacher.employee_id')
            ->whereIn('attendances_teacher.id', function ($row) {
                return $row->from('attendances_teacher')->selectRaw('max(id) id')
                    ->where('attendance_date', date('Y-m-d'))->groupBy('employee_id');
            })
            ->where('attendances_teacher.shift_id', 2)
            ->where('category_id', 8)
            ->where('attendance_date', date('Y-m-d'))->groupBy('attendances_teacher.status')->get();
        //dd($stafAttendance);



        //dd($studentseventvalue);
        if ($type_for == 3) {
            return view('admin.dashboard.adminDetailsCollege', compact('stafAttendance', 'stafAttendanced', 'nonemployeetotalcount', 'sections', 'teacherAttendance', 'teacherAttendanced', 'employeetotalcount', 'todayattendancestudent', 'todayattendancestudent', 'studentcount'));
        } else {
            return view('admin.dashboard.adminDetails', compact('stafAttendance', 'stafAttendanced', 'nonemployeetotalcount', 'sections', 'teacherAttendance', 'teacherAttendanced', 'employeetotalcount', 'todayattendancestudent', 'todayattendancestudent', 'studentcount'));
        }
    }
    public function attendanceDashboardDetailsEmployee($id)
    {

        Session::put('activemenu', 'dashboard');
        Session::put('activesubmenu', '');

        $type_for = array(
            1 => 'Primary',
            2 => 'Secondary',
            3 => 'College'
        );
        $session = Sessions::where('session_name', date('Y'))->first();

        // dd($studentAttandance);
        $conditiona = array(
            'session_id' => $session->id,
            'category_id' => ($id == 1) ? 7 : 8,
            'version_id' => '',
            'shift_id' => '',
            'class_id' => '',
            'section_id' => '',
            'emp_id' => '',
            'start_date' => date('Y-m-26'),
            'end_date' => date('Y-m-26'),
        );
        $employeedata = getEmployee('employee_for', 'employee_for,category_name,category_id,count(em.id) count', $conditiona);

        $employeedata = collect($employeedata)->groupBy('employee_for');
        //dd($employeedata);
        $conditiona = array(
            'session_id' => $session->id,
            'category_id' => ($id == 1) ? 7 : 8,
            'version_id' => '',
            'shift_id' => '',
            'class_id' => '',
            'section_id' => '',
            'emp_id' => '',
            'start_date' => date('Y-m-26'),
            'end_date' => date('Y-m-26'),
        );
        $employeedataAttandance = getEmployeeAttandance('employee_for,status', 'category_name,employee_for,status,count(id) count', $conditiona);

        $employeedataAttandance = collect($employeedataAttandance)->groupBy('employee_for');

        // dd($employeedataAttandance);









        //     $employeetotalcount=Employee::selectRaw('count(id) count,shift_id')->whereIn('shift_id',[1,2])->where('category_id',7)->groupBy('shift_id')->orderBy('shift_id','asc')->get();
        //     $nonemployeetotalcount=Employee::selectRaw('count(id) count,shift_id')->where('category_id',8)->groupBy('shift_id')->get();

        //     $teacherAttendance=TeacherAttendance::selectRaw('count(attendances_teacher.id) count,attendances_teacher.status')
        //                         ->join('employees','employees.id','=','attendances_teacher.employee_id')
        //                         ->whereIn('attendances_teacher.id',function($row) {
        //                             return $row->from('attendances_teacher')->selectRaw('max(id) id')
        //                             ->where('attendance_date',date('Y-m-d'))->groupBy('employee_id');
        //                         })
        //                         ->where('category_id',7)
        //                         ->where('attendances_teacher.shift_id',1)
        //                         ->where('attendance_date',date('Y-m-d'))->groupBy('attendances_teacher.status')->get();
        //     $stafAttendance=TeacherAttendance::selectRaw('count(attendances_teacher.id) count,attendances_teacher.status')
        //                         ->join('employees','employees.id','=','attendances_teacher.employee_id')
        //                         ->whereIn('attendances_teacher.id',function($row) {
        //                             return $row->from('attendances_teacher')->selectRaw('max(id) id')
        //                             ->where('attendance_date',date('Y-m-d'))->groupBy('employee_id');
        //                         })
        //                         ->where('attendances_teacher.shift_id',1)
        //                         ->where('category_id',8)
        //                         ->where('attendance_date',date('Y-m-d'))->groupBy('attendances_teacher.status')->get();


        // $teacherAttendanced=TeacherAttendance::selectRaw('count(attendances_teacher.id) count,attendances_teacher.status')
        //                         ->join('employees','employees.id','=','attendances_teacher.employee_id')
        //                         ->whereIn('attendances_teacher.id',function($row) {
        //                             return $row->from('attendances_teacher')->selectRaw('max(id) id')
        //                             ->where('attendance_date',date('Y-m-d'))->groupBy('employee_id');
        //                         })
        //                         ->where('category_id',7)
        //                         ->where('attendances_teacher.shift_id',2)
        //                         ->where('attendance_date',date('Y-m-d'))->groupBy('attendances_teacher.status')->get();
        //     $stafAttendanced=TeacherAttendance::selectRaw('count(attendances_teacher.id) count,attendances_teacher.status')
        //                         ->join('employees','employees.id','=','attendances_teacher.employee_id')
        //                         ->whereIn('attendances_teacher.id',function($row) {
        //                             return $row->from('attendances_teacher')->selectRaw('max(id) id')
        //                             ->where('attendance_date',date('Y-m-d'))->groupBy('employee_id');
        //                         })
        //                         ->where('attendances_teacher.shift_id',2)
        //                         ->where('category_id',8)
        //                         ->where('attendance_date',date('Y-m-d'))->groupBy('attendances_teacher.status')->get();
        //     //dd($stafAttendance);



        //dd($studentseventvalue);

        return view('admin.dashboard.adminDetailsTeacher', compact('employeedataAttandance', 'employeedata', 'type_for'));
    }
    public function calendarDashboardType($type)
    {
        if ($type == 1) {
            $date_start = date('Y-m-d');


            $date = strtotime(date("Y-m-d", strtotime($date_start)) . "+2 months");
            $date_end = date("Y-m-d", $date);
        } elseif ($type == 2) {
            $date_start = date('Y-m-d');
            $date_end = '';
        } else {
            $date_start = '';
            $date_end = date('Y-m-d');
        }
        $sessions = Sessions::where('active', '1')->first();
        $YearCalendars = YearCalendar::with('session');
        // dd($date_start,$date_end);
        $date_start = '';
        $date_end = '';
        if ($date_start != '' && $date_end != '') {
            $YearCalendars = $YearCalendars->whereBetween('start_date', [$date_start, $date_end]);
        } elseif ($date_start != '' && $date_end == '') {
            $YearCalendars = $YearCalendars->where('start_date', '>', $date_start);
        } elseif ($date_start == '' && $date_end != '') {
            $YearCalendars = $YearCalendars->where('start_date', '<', $date_end);
        }
        $YearCalendars = $YearCalendars->where('year', $sessions->id)->get();

        return view('admin.dashboard.calendarDashboardType', compact('YearCalendars', 'type'));
    }
    public function common($table, $condision)
    {
        $data = DB::table($table);
        if ($condision != '') {
            $data = $data->where($condision);
        }
        $data = $data->get();
    }
    public function admissionstatus()
    {
        Session::put('activemenu', 'admission');
        Session::put('activesubmenu', 'cas');
        $m = date('m');
        if ($m > 6) {
            $sessions = Sessions::where('active', '1')->first();
        } else {
            $sessions = Sessions::where('id', (date('Y') - 1))->first();
        }
        $sectordata = DB::select("
        with groupdata as(
        select class_code,group_id,version_id,count(id) rowdata from sections

        where class_code=11 and ifnull(group_id,0)!=0
        group by class_code,group_id,version_id order by version_id
        )
        select groupdata.* from groupdata
        ");

        // dd($sectordata);

        foreach ($sectordata as $key => $sector) {

            $sectordata[$key]->data = DB::select("with sectordata as (
                        select sections.* from sections
                        where sections.class_code=" . $sector->class_code . "
                        and version_id=" . $sector->version_id . "
                        and group_id=" . $sector->group_id . "

                        ),
                        currentadmitmale as (
                        select section_id,count(sa.student_code) male_count from student_activity sa
                        join students s on s.student_code=sa.student_code
                        where class_code=" . $sector->class_code . " and gender=1
                        and session_id=" . $sessions->id . "
                        and version_id=" . $sector->version_id . "
                        and group_id=" . $sector->group_id . "
                        and s.active=1
                        and sa.active=1
                        group by sa.section_id
                        ),
                        currentadmitfemale as (
                        select section_id,count(sa.student_code) female_count from student_activity sa
                        join students s on s.student_code=sa.student_code
                        where class_code=" . $sector->class_code . " and gender=2
                        and session_id=" . $sessions->id . "
                        and version_id=" . $sector->version_id . "
                        and group_id=" . $sector->group_id . "
                        and s.active=1
                        and sa.active=1
                        group by sa.section_id
                        )
                        select *,ifnull(male_count,0)+ifnull(female_count,0) total_count from sectordata
                        left join currentadmitmale on currentadmitmale.section_id=sectordata.id
                        left join currentadmitfemale on currentadmitfemale.section_id=sectordata.id");
        }


        return view('admin.dashboard.admission', compact('sectordata'));
    }
}
