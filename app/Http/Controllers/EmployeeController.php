<?php

namespace App\Http\Controllers;

use App\Exports\EmployeesExport;
use App\Imports\EmployeeImport;
use App\Models\Syllabus;
use App\Models\sttings\Teachers;
use App\Models\Employee\EmployeeHeadFee;
use App\Models\sttings\EducationQualification;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Student\StudentActivity;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeActivity;
use App\Models\sttings\Sessions;
use App\Models\sttings\Degree;
use App\Models\sttings\Discipline;
use App\Models\sttings\Specialization;
use App\Models\sttings\Shifts;
use App\Models\sttings\Versions;
use App\Models\Student\Student;
use App\Models\sttings\Category;
use App\Models\sttings\Designation;
use App\Models\sttings\Subjects;
use App\Models\sttings\ClassWiseSubject;
use App\Models\sttings\Classes;
use App\Models\sttings\Sections;
use App\Models\YearCalendar;
use App\Models\Fee;
use App\Models\LeasonPlan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{

    public function index(Request $request)
    {
        // dd($request->all());
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 6) {
            abort(403, 'You do not have permission to access this page.');
        }
        $sessions = Sessions::pluck('session_name', 'session_code');
        $versions = Versions::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $categories = Category::where('type', 1)->where('active', 1)->get();
        $classes = Classes::where('active', 1)
            ->where('shift_id', $request->shift_id)
            ->where('version_id', $request->version_id)
            ->get();
        $sections = Sections::where('active', 1)
            ->where('class_code', (int)$request->class_id)
            ->where('shift_id', $request->shift_id)
            ->where('version_id', $request->version_id)
            ->get();
        $subjects = Subjects::where('active', 1)->get();
        $designations = Designation::where('active', 1)->orderBy('designation_name', 'asc')->get();

        $version_id = $request->version_id;
        $session_id = $request->session_id;
        $shift_id = $request->shift_id;
        $class_id = $request->class_id;
        $section_id = (int)$request->section_id;
        $subject_id = $request->subject_id;
        $designation_id = $request->designation_id;
        $category_id = $request->category_id;
        $text_search = $request->text_search;
        $for_id = $request->for_id;

        Session::put('activemenu', 'employee');
        Session::put('activesubmenu', 'ei');

        // Start building the query
        $employees = Employee::where('active', 1)
            ->with([
                'version',
                'shift',
                'category',
                'designation',
                'subject',
            ]);
        // $employees = Employee::where('active', 1)
        //     ->with([
        //         'employeeActivity.session',
        //         'version',
        //         'shift',
        //         'category',
        //         'designation',
        //         'employeeActivity.classes',
        //         'employeeActivity.group',
        //         'employeeActivity.section',
        //         'subject',
        //     ]);

        $page_size = $request->get('page_size', 50);

        // Add filters to the query
        if ($session_id) {
            $employees = $employees->when($session_id, function ($query) use ($session_id) {
                $query->whereHas('employeeActivity', function ($subQuery) use ($session_id) {
                    $subQuery->where('session_id', $session_id);
                });
            });
        }

        if ($class_id) {
            $employees = $employees->when($class_id, function ($query) use ($class_id) {
                $query->whereHas('employeeActivity', function ($subQuery) use ($class_id) {
                    $subQuery->where('class_code', $class_id);
                });
            });
        }

        if ($section_id) {
            $employees = $employees->when($section_id, function ($query) use ($section_id) {
                $query->whereHas('employeeActivity', function ($subQuery) use ($section_id) {
                    $subQuery->where('section_id', $section_id);
                });
            });
        }
        if ($text_search) {
            $employees = $employees->when($text_search, function ($query) use ($text_search) {
                $query->where(function ($subQuery) use ($text_search) {
                    $subQuery->where('employee_name', 'LIKE', '%' . $text_search . '%')
                        ->orWhere('emp_id', 'LIKE', '%' . $text_search . '%')
                        ->orWhere('mobile', 'LIKE', '%' . $text_search . '%')
                        ->orWhere('email', 'LIKE', '%' . $text_search . '%');
                });
            });
        }
        if ($designation_id) {
            $employees = $employees->when($designation_id, function ($query) use ($designation_id) {
                $query->where('designation_id', $designation_id);
            });
        }
        if ($for_id) {
            $employees = $employees->when($for_id, function ($query) use ($for_id) {
                $query->where('employee_for', $for_id);
            });
        }
        if ($version_id) {
            $employees = $employees->when($version_id, function ($query) use ($version_id) {
                $query->where('version_id', $version_id);
            });
        }
        if ($shift_id) {
            $employees = $employees->when($shift_id, function ($query) use ($shift_id) {
                $query->where('shift_id', $shift_id);
            });
        }
        if ($subject_id) {
            $employees = $employees->when($subject_id, function ($query) use ($subject_id) {
                $query->where('subject_id', $subject_id);
            });
        }
        if ($category_id) {
            $employees = $employees->when($category_id, function ($query) use ($category_id) {
                $query->where('category_id', $category_id);
            });
        }

        // Fetch paginated employees if filters are provided or text search exists
        // if ($request->hasAny(['session_id', 'category_id', 'for_id', 'version_id', 'shift_id', 'class_id', 'section_id', 'subject_id']) || !empty($text_search)) {
        //     $employees = $employees->orderBy('id', 'desc')->paginate($page_size);
        // } else {
        //     $employees = collect(); // Default empty collection
        // }
        $employees = $employees->orderBy('id', 'desc')->paginate($page_size);

        $createdBy = Auth::user()->name;

        return view('employee.employees', compact(
            'employees',
            'sessions',
            'text_search',
            'designation_id',
            'designations',
            'versions',
            'shifts',
            'classes',
            'categories',
            'sections',
            'subjects',
            'session_id',
            'version_id',
            'shift_id',
            'class_id',
            'category_id',
            'section_id',
            'subject_id',
            'for_id',
            'page_size',
            'createdBy'
        ));
    }

    public function excelDownload(Request $request)
    {
        return Excel::download(new EmployeesExport($request->all()), 'employee_export_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }


    public function teacherAttendance(Request $request)
    {
        Session::put('activemenu', 'attendance');
        Session::put('activesubmenu', 'ta');
        $employee = Employee::where('id', Auth::user()->ref_id)->first();
        $session = Sessions::where('active', 1)->first();
        $id = $employee->id ?? 0;

        // $attandance=EmployeeActivity::where('employee_id',$id)->get();

        $teacher = Employee::with([
            'teacherlastWeekAttendance',
            'EmployeeActivity.version',
            'EmployeeActivity.shift',
            'EmployeeActivity.classes',
            'EmployeeActivity.group',
            'EmployeeActivity.section',
            'EmployeeActivity.subject',
            'designation'
        ])->find($id);

        $activity = array();
        return view('employee.teacherAttendance', compact('teacher'));
    }
    public function teacherRouten(Request $request)
    {
        Session::put('activemenu', 'Routen');
        Session::put('activesubmenu', '');

        $employee = Employee::where('id', Auth::user()->ref_id)->first();
        $session = Sessions::where('active', 1)->first();


        $session = Sessions::where('session_name', date('Y'))->first();
        $routine = EmployeeActivity::with(['employee', 'subject', 'classes', 'section'])
            ->selectRaw('
                CASE
                WHEN day_name = "Sun" THEN 1
                WHEN day_name = "Mon" THEN 2
                WHEN day_name = "Tue" THEN 3
                WHEN day_name = "Wed" THEN 4
                WHEN day_name = "Thu" THEN 5
                ELSE 0
                END dayserial,
                employee_activity.*
                ')
            ->where('employee_id', $employee->id)
            //->where('session_id',$session->id)
            //->where('shift_id',$employee->shift_id)
            ->whereNotNull('day_name')->distinct('start_time')->orderBy('start_time')->get();
        // dd($routine);
        $routine = collect($routine)->sortBy('dayserial')->groupBy(['day_name', 'start_time']);

        $routinetime = EmployeeActivity::select('start_time', 'end_time')
            ->where('employee_id', $employee->id)
            //->where('session_id',$session->id)
            //->where('shift_id',$employee->shift_id)
            ->whereNotNull('day_name')->distinct('start_time')->orderBy('start_time')->get();
        //dd($routinetime);

        return view('employee.teacherRouten', compact('routine', 'routinetime'));
    }
    public function teacherSectionRoutine($section_id)
    {
        Session::put('activemenu', 'Class');
        Session::put('activesubmenu', '');

        //$employee=Employee::where('mobile',Auth::user()->phone)->first();

        $session = Sessions::where('session_name', date('Y'))->first();

        $routine = EmployeeActivity::with(['employee', 'subject', 'version', 'shift', 'classes', 'section'])
            ->where('section_id', $section_id)
            ->where('session_id', $session->id)
            ->whereNotNull('day_name')->distinct('start_time')->orderBy('start_time')
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
        $class_name = $routine[0]->classes->class_name ?? '';
        $section_name = $routine[0]->section->section_name ?? '';
        $shift_name = $routine[0]->shift->shift_name ?? '';
        $version_name = $routine[0]->version->version_name ?? '';
        $routine = collect($routine)->sortBy('day_nr');
        $routine = collect($routine)->groupBy(['day_name', 'start_time']);

        $routinetime = EmployeeActivity::select('start_time', 'end_time')
            ->where('section_id', $section_id)
            ->where('session_id', $session->id)
            ->whereNotNull('day_name')->distinct('start_time')->orderBy('start_time')->get();



        return view('employee.teacherSectionRoutine', compact('routinetime', 'routine', 'shift_name', 'version_name', 'class_name', 'section_name'));
    }
    public function teacherClass(Request $request)
    {
        Session::put('activemenu', 'Class');
        Session::put('activesubmenu', '');

        $employee = Employee::where('id', Auth::user()->ref_id)->first();
        // $session = Sessions::where('active', 1)->first();
        //dd( Auth::user()->ref_id);
        $activity = EmployeeActivity::where('employee_id', $employee->id)
            // ->where('employee_activity.session_id', $session->id)
            ->where('is_class_teacher', 1)
            ->orderBy('id', 'desc')
            ->first();
        if (empty($activity)) {
            return redirect()->back();
        }
        $session = Sessions::where('session_name', date('Y'))->first();
        $classes = EmployeeActivity::join('classes', 'classes.class_code', '=', 'employee_activity.class_code')
            ->join('sections', 'sections.id', '=', 'employee_activity.section_id')
            ->where('employee_id', $employee->id)
            ->where('employee_activity.id', $activity->id)
            // ->where('employee_activity.shift_id', $employee->shift_id)
            ->select('employee_activity.id', 'employee_activity.class_id', 'employee_activity.class_code', 'class_name', 'section_name', 'employee_activity.section_id', 'employee_activity.shift_id', 'employee_activity.version_id')
            ->with(['version', 'shift'])
            ->orderBy('employee_activity.class_id')
            ->orderBy('employee_activity.section_id')
            ->groupBy('employee_activity.shift_id')
            ->groupBy('employee_activity.id')
            ->groupBy('employee_activity.version_id')
            ->groupBy('employee_activity.class_id')
            ->groupBy('employee_activity.class_code')
            ->groupBy('class_name')
            ->groupBy('employee_activity.section_id')
            ->groupBy('section_name')
            ->get();




        return view('employee.teacherClass', compact('classes'));
    }

    public function teacherStudent()
    {

        Session::put('activemenu', 'Student');
        Session::put('activesubmenu', 'Student');

        $employee = Employee::find(Auth::user()->ref_id);

        if (!$employee) {
            return redirect()->back()->with('error', 'Employee not found.');
        }

        // $activity = EmployeeActivity::where('employee_id', Auth::user()->ref_id)
        //     ->where('is_class_teacher', 1)
        //     ->where('active', 1)
        //     ->orderBy('id', 'desc')
        //     ->first();


        $activity = EmployeeActivity::join('classes', 'classes.class_code', '=', 'employee_activity.class_code')
            ->join('versions', 'versions.id', '=', 'employee_activity.version_id')
            ->join('shifts', 'shifts.id', '=', 'employee_activity.shift_id')
            ->join('sections', 'sections.id', '=', 'employee_activity.section_id')
            ->join('sessions', 'sessions.id', '=', 'employee_activity.session_id')
            ->where('employee_activity.employee_id', Auth::user()->ref_id)
            ->where('is_class_teacher', 1)
            ->where('employee_activity.active', 1)
            ->select('employee_activity.*',  'class_name', 'section_name', 'shift_name', 'version_name', 'session_name')
            ->orderBy('employee_activity.id', 'desc')
            ->first();

        // if (!$activity) {
        //     return redirect()->back()->with('error', 'Data not found.');
        // }
        // $session = Sessions::where('id', $activity->session_id)->first();

        // if (!$session) {
        //     return redirect()->back()->with('error', 'No session found for the employee.');
        // }
        if (!$activity) {
            return redirect()->back()->with('error', 'No activity found for the employee.');
        }

        // $employeeActivity = EmployeeActivity::join('classes', 'classes.class_code', '=', 'employee_activity.class_code')
        //     ->join('sections', 'sections.id', '=', 'employee_activity.section_id')
        //     ->where('employee_id', $employee->id)
        //     ->where('employee_activity.id', $activity->id)
        //     ->select('employee_activity.class_id', 'employee_activity.class_code', 'class_for', 'class_name', 'section_name', 'employee_activity.section_id', 'employee_activity.shift_id', 'employee_activity.version_id')
        //     ->with(['version', 'shift'])
        //     ->orderBy('employee_activity.class_id')
        //     ->orderBy('employee_activity.section_id')
        //     ->groupBy('employee_activity.shift_id')
        //     ->groupBy('employee_activity.version_id')
        //     ->groupBy('employee_activity.class_id')
        //     ->groupBy('employee_activity.class_code')
        //     ->groupBy('employee_activity.section_id')
        //     ->groupBy('class_for')
        //     ->groupBy('class_name')
        //     ->groupBy('section_name')
        //     ->first();

        //$classdata = Classes::find($employeeActivity->class_code);
        $employeeActivity = $activity;
        $session_id = $activity->session_id;
        $shift_id = $activity->shift_id;
        $class_code = $activity->class_code;
        $section_id = $activity->section_id;
        $version_id = $activity->version_id;


        // 51
        $conditions = " 1=1";
        $condition = " 1=1";
        if ($session_id) {
            $conditions .= ' and student_activity.session_id=' . $session_id;
            $condition .= ' and attendances.session_id=' . $session_id;
        }
        if ($version_id) {
            $conditions .= ' and student_activity.version_id=' . $version_id;
            $condition .= ' and attendances.version_id=' . $version_id;
        }
        if ($shift_id) {
            $conditions .= ' and student_activity.shift_id=' . $shift_id;
            $condition .= ' and attendances.shift_id=' . $shift_id;
        }
        if ($class_code) {
            $conditions .= ' and student_activity.class_code=' . $class_code;
            $condition .= ' and attendances.class_code=' . $class_code;
        }
        if ($section_id) {
            $conditions .= ' and student_activity.section_id=' . $section_id;
            $condition .= ' and attendances.section_id=' . $section_id;
        }
        //dd($conditions,$condition);
        $students = Student::where('students.active', 1)
            ->where('student_activity.active', 1)
            ->join('student_activity', 'student_activity.student_code', '=', 'students.student_code')
            ->join('versions', 'versions.id', '=', 'student_activity.version_id')
            ->join('shifts', 'shifts.id', '=', 'student_activity.shift_id')
            ->join('classes', 'classes.class_code', '=', 'student_activity.class_code')
            ->join('sections', 'sections.id', '=', 'student_activity.section_id')
            ->join('sessions', 'sessions.id', '=', 'student_activity.session_id')
            ->where('student_activity.class_code', $class_code)
            ->where('student_activity.session_id', $session_id)
            ->where('student_activity.section_id', $section_id)
            //->whereRaw($conditions)
            ->with(["studentAttendance" => function ($query) use ($condition) {
                return $query->whereRaw($condition);
            }])
            ->selectRaw('students.*,version_name,shift_name,class_name,section_name,roll,session_name,start_time')
            ->orderBy('roll')
            ->get();
        //dd($conditions);
        $students = collect($students)->unique('student_code');

        return view('employee.student', compact('students', 'employeeActivity'));
    }
    public function teacherStudentResult()
    {
        Session::put('activemenu', 'Student Result');
        Session::put('activesubmenu', '');
        $title = "Result";
        return view('employee.upcomming', compact('title'));
    }

    public function teacherSyllabus()
    {
        Session::put('activemenu', 'acac');
        Session::put('activesubmenu', 'syl');
        $title = "Syllabus";
        $employee = Employee::where('id', Auth::user()->ref_id)->first();
        if (!$employee) {
            return redirect()->back()->with('error', 'Employee not found.');
        }
        $activity = EmployeeActivity::where('employee_id', $employee->id)
            ->where('active', 1)
            ->orderByDesc('id')
            ->first();
        if (!$activity) {
            return redirect()->back()->with('error', 'No activity found for the employee.');
        }

        $syllabuses = Syllabus::with(['session', 'version', 'classes', 'employee', 'subject'])
            ->where('class_code', $activity->class_id)
            ->where('session_id', $activity->session_id)
            ->where('version_id', $activity->version_id)
            ->get();

        if (!$syllabuses) {
            return redirect()->back()->with('error', 'No syllabus found for the employee.');
        }
        return view('student.studentSyllabus', compact('syllabuses'));
    }

    public function teacherLessonplan()
    {
        Session::put('activemenu', 'acac');
        Session::put('activesubmenu', 'lp');
        $title = "Lesson Plan";
        $employee = Employee::where('id', Auth::user()->ref_id)->first();
        if (!$employee) {
            return redirect()->back()->with('error', 'Employee not found.');
        }
        $activity = EmployeeActivity::where('employee_id', $employee->id)
            ->where('active', 1)
            ->orderByDesc('id')
            ->first();

        if (!$activity) {
            return redirect()->back()->with('error', 'No activity found for the employee.');
        }
        $lessonPlans = LeasonPlan::with(['session', 'version', 'shift', 'classes', 'section', 'employee', 'subject',])
            ->where('class_code', $activity->class_code)
            ->where('section_id', $activity->section_id)
            ->where('session_id', $activity->session_id)
            ->where('teacher_id', $employee->id)
            ->get();

        if (!$lessonPlans) {
            return redirect()->back()->with('error', 'No lessonPlans found for the employee.');
        }
        return view('lessonplan.lessonPlanStudent', compact('lessonPlans'));
    }
    public function teacherStudentAttendance()
    {
        Session::put('activemenu', 'attendance');
        Session::put('activesubmenu', 'Student Attendance');
        $employee = Employee::where('id', Auth::user()->ref_id)->first();

        $activity = EmployeeActivity::join('classes', 'classes.class_code', '=', 'employee_activity.class_code')
            ->join('sections', 'sections.id', '=', 'employee_activity.section_id')
            ->where('employee_activity.employee_id', Auth::user()->ref_id)
            ->where('is_class_teacher', 1)
            ->where('employee_activity.active', 1)
            ->select('employee_activity.*',  'class_name', 'section_name')
            ->orderBy('employee_activity.id', 'desc')
            ->first();

        //$session = Sessions::where('id', $activity->session_id)->first();

        // if (!$session) {
        //     return redirect()->back()->with('error', 'Session not found.');
        // }
        if (!$activity) {
            return redirect()->back()->with('error', 'No activity found for the employee.');
        }
        // $employeeActivity = EmployeeActivity::join('classes', 'classes.class_code', '=', 'employee_activity.class_code')
        //     ->join('sections', 'sections.id', '=', 'employee_activity.section_id')
        //     ->where('employee_activity.id', $activity->id)
        //     ->select('employee_activity.class_id', 'employee_activity.class_code', 'class_for', 'class_name', 'section_name', 'employee_activity.section_id', 'employee_activity.shift_id', 'employee_activity.version_id')
        //     ->with(['version', 'shift'])
        //     ->orderBy('employee_activity.class_id')
        //     ->orderBy('employee_activity.section_id')
        //     ->groupBy('employee_activity.shift_id')
        //     ->groupBy('employee_activity.version_id')
        //     ->groupBy('employee_activity.class_id')
        //     ->groupBy('employee_activity.class_code')
        //     ->groupBy('employee_activity.section_id')
        //     ->groupBy('class_for')
        //     ->groupBy('class_name')
        //     ->groupBy('section_name')
        //     ->first();

        //$classdata = Classes::find($activity->class_code);
        $employeeActivity = $activity;
        $session_id = $activity->session_id;
        $shift_id = $activity->shift_id;
        $class_code = $classdata->class_code ?? $activity->class_code;
        $class_id = $activity->class_id;
        $section_id = $activity->section_id;
        $version_id = $activity->version_id;
        $employee_for = $activity->class_for;
        if ($employee_for == 3) {
            $employee_for = 'college';
        } elseif ($employee_for == 2) {
            $employee_for = 'secondary';
        } else {
            $employee_for = 'primary';
        }

        Session::put('employee_for', $employee_for);
        Session::put('session_id', $session_id);
        Session::put('shift_id', $shift_id);
        Session::put('class_id', $class_id);
        Session::put('class_code', $class_code);
        Session::put('section_id', $section_id);
        Session::put('version_id', $version_id);

        $attendance_date = date('Y-m-d');
        $conditions = " 1=1";
        $condition = " 1=1";
        if ($session_id) {
            $conditions .= ' and student_activity.session_id=' . $session_id;
            $condition .= ' and attendances.session_id=' . $session_id;
        }
        if ($version_id) {
            $conditions .= ' and student_activity.version_id=' . $version_id;
            $condition .= ' and attendances.version_id=' . $version_id;
        }
        if ($shift_id) {
            $conditions .= ' and student_activity.shift_id=' . $shift_id;
            $condition .= ' and attendances.shift_id=' . $shift_id;
        }
        if ($class_code) {
            $conditions .= ' and student_activity.class_code=' . $class_code;
            $condition .= ' and attendances.class_code=' . $class_code;
        }
        if ($section_id) {
            $conditions .= ' and student_activity.section_id=' . $section_id;
            $condition .= ' and attendances.section_id=' . $section_id;
        }
        if ($attendance_date) {
            $condition .= ' and attendance_date="' . $attendance_date . '"';
        }
        //dd($condition);
        $students = Student::where('students.active', 1)
            ->where('student_activity.active', 1)
            ->join('student_activity', 'student_activity.student_code', '=', 'students.student_code')
            ->join('versions', 'versions.id', '=', 'student_activity.version_id')
            ->join('shifts', 'shifts.id', '=', 'student_activity.shift_id')
            ->join('classes', 'classes.class_code', '=', 'student_activity.class_code')
            ->join('sections', 'sections.id', '=', 'student_activity.section_id')
            ->join('sessions', 'sessions.id', '=', 'student_activity.session_id')
            ->where('student_activity.class_code', $class_code)
            ->where('student_activity.session_id', $session_id)
            ->where('student_activity.section_id', $section_id)
            //->whereRaw($conditions)
            ->with(["studentAttendance" => function ($query) use ($condition) {
                return $query->whereRaw($condition);
            }])
            ->selectRaw('students.*,version_name,shift_name,class_name,section_name,roll,session_name,start_time')
            ->orderBy('roll')
            ->get();

        $students = collect($students)->unique('student_code');
        //dd($students[0]);
        $start_time = $this->getStartTime($shift_id, $class_code);

        return view('employee.studentattandence', compact('students', 'employeeActivity', 'start_time'));
    }
    public function getStartTime($shift_id, $class_code)
    {
        if ($class_code < 11) {
            $start_time = date('H:i', strtotime('12:30:00'));
            if ($shift_id == 1) {
                $start_time = date('H:i', strtotime('07:30:00'));
            }
        } else {
            $start_time = date('H:i', strtotime('08:00:00'));
        }
        return $start_time;
    }
    public function getidcardd($id)
    {
        $studentdata = DB::select('SELECT * FROM `students` WHERE `id` LIKE "' . $id . '"');

        foreach ($studentdata as $key => $student) {
            $studentdata[$key]->activity = StudentActivity::where('student_code', $student->student_code)
                ->with(['session', 'version', 'classes', 'section', 'group'])
                ->where('active', 1)->first();
            $studentdata[$key]->qrCode   = QrCode::size(100)->style('round')->generate($student->student_code . '-' . $student->first_name);
        }

        ini_set('max_execution_time', '300');
        ini_set("pcre.backtrack_limit", "5000000");

        $pdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => [85.6, 114],
            'default_font_size' => 9,
        ]);


        $pdf->WriteHTML('');
        $no_footer = 0;
        if (!$no_footer) {
            $footer = view('print.pdf_footer', []);
            // $pdf->setHTMLFooter($footer,'O');
            //$pdf->setHTMLFooter($footer,'E');
        }
        // $pdf->SetWatermarkImage(
        //     'https://bafsd.edu.bd/public/frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png',
        //     1,
        //     '',
        //     [160, 10]
        // );
        $pdf->showWatermarkImage = true;
        $view = 'student.cardD';
        $data = compact('studentdata');
        $html = view($view, $data);
        $pdf->WriteHTML($html);
        $pdf->Output($student->first_name . '.pdf', 'D');
    }
    public function teacherStudentAttendanceReport()
    {

        Session::put('activemenu', 'attendance');
        Session::put('activesubmenu', 'Student Attendance Report');

        $activity = EmployeeActivity::join('classes', 'classes.class_code', '=', 'employee_activity.class_code')
            ->join('sections', 'sections.id', '=', 'employee_activity.section_id')
            ->where('employee_activity.employee_id', Auth::user()->ref_id)
            ->where('is_class_teacher', 1)
            ->where('employee_activity.active', 1)
            ->select('employee_activity.*',  'class_name', 'section_name')
            ->orderBy('employee_activity.id', 'desc')
            ->first();



        if (empty($activity)) {
            return redirect()->back();
        }
        $employeeActivity = $activity;
        // EmployeeActivity::leftJoin('classes', 'classes.class_code', '=', 'employee_activity.class_code')
        //     ->join('sections', 'sections.id', '=', 'employee_activity.section_id')
        //     ->where('employee_id', $employee->id)
        //     ->where('employee_activity.session_id', $session->id)
        //     ->where('employee_activity.id', $activity->id)
        //     ->select('employee_activity.class_id', 'employee_activity.class_code', 'class_for', 'class_name', 'section_name', 'employee_activity.section_id', 'employee_activity.shift_id', 'employee_activity.version_id')
        //     ->with(['version', 'shift'])
        //     ->orderBy('employee_activity.class_id')
        //     ->orderBy('employee_activity.section_id')
        //     ->groupBy('employee_activity.shift_id')
        //     ->groupBy('employee_activity.version_id')
        //     ->groupBy('employee_activity.class_id')
        //     ->groupBy('employee_activity.class_code')
        //     ->groupBy('employee_activity.section_id')
        //     ->groupBy('class_for')
        //     ->groupBy('class_name')
        //     ->groupBy('section_name')
        //     ->first();
        $session_id = $employeeActivity->session_id;
        $shift_id = $employeeActivity->shift_id;
        $class_id = $employeeActivity->class_id;
        $class_code = $employeeActivity->class_code;
        $section_id = $employeeActivity->section_id;
        $version_id = $employeeActivity->version_id;
        $employee_for = $employeeActivity->class_for;

        if ($employee_for == 3) {
            $employee_for = 'college';
        } elseif ($employee_for == 2) {
            $employee_for = 'secondary';
        } else {
            $employee_for = 'primary';
        }

        Session::put('employee_for', $employee_for);
        Session::put('session_id', $session_id);
        Session::put('shift_id', $shift_id);
        Session::put('class_id', $class_id);
        Session::put('class_code', $class_code);
        Session::put('section_id', $section_id);
        Session::put('version_id', $version_id);

        $attendance_date = date('Y-m-d');
        $conditions = " 1=1";
        $condition = " 1=1";

        if ($session_id) {
            $conditions .= ' and student_activity.session_id=' . $session_id;
            //$condition .= ' and attendances.session_id=' . $session_id;
        }
        if ($version_id) {
            $conditions .= ' and student_activity.version_id=' . $version_id;
            // $condition .= ' and attendances.version_id=' . $version_id;
        }
        if ($shift_id) {
            $conditions .= ' and student_activity.shift_id=' . $shift_id;
            //$condition .= ' and attendances.shift_id=' . $shift_id;
        }
        if ($class_code) {
            $conditions .= ' and student_activity.class_id=' . $class_code;
            //$condition .= ' and attendances.class_id=' . $class_id;
        }
        if ($section_id) {
            $conditions .= ' and student_activity.section_id=' . $section_id;
            //$condition .= ' and attendances.section_id=' . $section_id;
        }
        if ($attendance_date) {
            $condition .= ' and attendance_date="' . $attendance_date . '"';
        }


        $students = Student::where('students.active', 1)->where('student_activity.active', 1)
            ->join('student_activity', 'student_activity.student_code', '=', 'students.student_code')
            ->join('versions', 'versions.id', '=', 'student_activity.version_id')
            ->join('shifts', 'shifts.id', '=', 'student_activity.shift_id')
            ->join('classes', 'classes.class_code', '=', 'student_activity.class_code')
            ->join('sections', 'sections.id', '=', 'student_activity.section_id')
            ->join('sessions', 'sessions.id', '=', 'student_activity.session_id')
            ->whereRaw($conditions)
            ->with(["studentAttendance" => function ($query) use ($condition) {
                return $query->whereRaw($condition);
            }])
            ->selectRaw('students.*,version_name,shift_name,class_name,section_name,roll,session_name,start_time')
            ->orderBy('roll')
            ->get();

        $students = collect($students)->unique('student_code');

        $data = $this->statusCount($students);

        return view('employee.studentattandenceReport', compact('students', 'employeeActivity', 'data'));
    }
    public function statusCount($students)
    {
        $count = [
            'present' => 0,
            'absent' => 0,
            'late' => 0,
            'leave' => 0,
            'missing' => 0,
        ];
        foreach ($students as $student) {
            $attendanceRecord = $student->studentAttendance;
            // Initialize status counters
            if ($attendanceRecord) {
                switch ($attendanceRecord->status) {
                    case 1:
                        $count['present']++;
                        break;
                    case 2:
                        $count['absent']++;
                        break;
                    case 3:
                        $count['leave']++;
                        break;
                    case 4:
                        $count['late']++;
                        break;
                    default:
                        $count['missing']++;
                        break;
                }
            }
        }
        return $count;
    }

    public function getStudentsAttendanceStatusWithDate(Request $request)
    {

        $employee = Employee::where('id', Auth::user()->ref_id)->first();

        if (!$employee) {
            return redirect()->back()->with('error', 'Employee not found.');
        }

        $activity = EmployeeActivity::join('classes', 'classes.class_code', '=', 'employee_activity.class_code')
            ->join('sections', 'sections.id', '=', 'employee_activity.section_id')
            ->where('employee_activity.employee_id', Auth::user()->ref_id)
            ->where('is_class_teacher', 1)
            ->where('employee_activity.active', 1)
            ->select('employee_activity.*',  'class_name', 'section_name')
            ->orderBy('employee_activity.id', 'desc')
            ->first();

        if (!$activity) {
            return redirect()->back()->with('error', 'Activity not found.');
        }

        $session = Sessions::where('id', $activity->session_id)->first();
        if (!$session) {
            return redirect()->back()->with('error', 'Session not found.');
        }

        $employeeActivity = EmployeeActivity::leftJoin('classes', 'classes.class_code', '=', 'employee_activity.class_code')
            ->join('sections', 'sections.id', '=', 'employee_activity.section_id')
            ->where('employee_id', $employee->id)
            ->where('employee_activity.session_id', $session->id)
            ->where('employee_activity.id', $activity->id)
            ->select('employee_activity.class_id', 'employee_activity.class_code', 'class_for', 'class_name', 'section_name', 'employee_activity.section_id', 'employee_activity.shift_id', 'employee_activity.version_id')
            ->with(['version', 'shift'])
            ->orderBy('employee_activity.class_id')
            ->orderBy('employee_activity.section_id')
            ->groupBy('employee_activity.shift_id')
            ->groupBy('employee_activity.version_id')
            ->groupBy('employee_activity.class_id')
            ->groupBy('employee_activity.class_code')
            ->groupBy('employee_activity.section_id')
            ->groupBy('class_for')
            ->groupBy('class_name')
            ->groupBy('section_name')
            ->first();

        $session_id = $request->session_id;
        $shift_id = $request->shift_id;
        $class_id = $request->class_id;
        $class_code = $request->class_code;
        $section_id = $request->section_id;
        $version_id = $request->version_id;
        $attendance_date = $request->attendance_date;


        Session::put('session_id', $session_id);
        Session::put('shift_id', $shift_id);
        Session::put('class_id', $class_id);
        Session::put('class_code', $class_code);
        Session::put('section_id', $section_id);
        Session::put('version_id', $version_id);

        $attendance_date = $attendance_date;

        $conditions = " 1=1";
        $condition = " 1=1";

        if ($session_id) {
            $conditions .= ' and student_activity.session_id=' . $session_id;
            //$condition .= ' and attendances.session_id=' . $session_id;
        }
        if ($version_id) {
            $conditions .= ' and student_activity.version_id=' . $version_id;
            // $condition .= ' and attendances.version_id=' . $version_id;
        }
        if ($shift_id) {
            $conditions .= ' and student_activity.shift_id=' . $shift_id;
            //$condition .= ' and attendances.shift_id=' . $shift_id;
        }
        if ($class_code) {
            $conditions .= ' and student_activity.class_id=' . $class_code;
            //$condition .= ' and attendances.class_id=' . $class_id;
        }
        if ($section_id) {
            $conditions .= ' and student_activity.section_id=' . $section_id;
            //$condition .= ' and attendances.section_id=' . $section_id;
        }
        if ($attendance_date) {
            $condition .= ' and attendance_date="' . $attendance_date . '"';
        }


        $students = Student::where('students.active', 1)->where('student_activity.active', 1)
            ->join('student_activity', 'student_activity.student_code', '=', 'students.student_code')
            ->join('versions', 'versions.id', '=', 'student_activity.version_id')
            ->join('shifts', 'shifts.id', '=', 'student_activity.shift_id')
            ->join('classes', 'classes.class_code', '=', 'student_activity.class_code')
            ->join('sections', 'sections.id', '=', 'student_activity.section_id')
            ->join('sessions', 'sessions.id', '=', 'student_activity.session_id')
            ->whereRaw($conditions)
            ->with(["studentAttendance" => function ($query) use ($condition) {
                return $query->whereRaw($condition);
            }])
            ->selectRaw('students.*,version_name,shift_name,class_name,section_name,roll,session_name,start_time')
            ->orderBy('roll')
            ->get();

        $students = collect($students)->unique('student_code');
        $count = [
            'present' => 0,
            'absent' => 0,
            'late' => 0,
            'leave' => 0,
            'missing' => 0,
        ];
        foreach ($students as $student) {
            $attendanceRecord = $student->studentAttendance;
            // Initialize status counters
            if ($attendanceRecord) {
                switch ($attendanceRecord->status) {
                    case 1:
                        $count['present']++;
                        break;
                    case 2:
                        $count['absent']++;
                        break;
                    case 3:
                        $count['leave']++;
                        break;
                    case 4:
                        $count['late']++;
                        break;
                    default:
                        $count['missing']++;
                        break;
                }
            }
        }
        return view('employee.ajaxstudentattandenceReport', compact('students', 'employeeActivity', 'count'));
    }
    public function teacherPayment(Request $request)
    {
        Session::put('activemenu', 'payment');
        Session::put('activesubmenu', 'p');
        $title = "Teacher Salary";
        return view('employee.upcomming', compact('title'));
    }
    public function teacherYearCalender(Request $request)
    {
        Session::put('activemenu', 'acac');
        Session::put('activesubmenu', 'yc');
        $type = 1;
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

        return view('employee.yearcalender', compact('YearCalendars', 'type'));
    }
    public function getEmployeeDetails(Request $request)
    {
        $teacher = Employee::with([
            'teacherlastWeekAttendance',
            'EmployeeActivity.version',
            'EmployeeActivity.shift',
            'EmployeeActivity.classes',
            'EmployeeActivity.group',
            'EmployeeActivity.section',
            'subject',
            'designation'
        ])->find($request->id);
        $activity = array();
        // $groupdata=collect($teacher->teacherlastWeekAttendance)->groupBy('attendance_date');

        // foreach($groupdata as $key=>$teacherdata){
        //     $activity[$key]=array();
        //     foreach($teacherdata as $k=>$tea){
        //         dd($tea);
        //         $attend=DB::table('attendances_teacher')
        //         ->join('sessions','sessions.id','=','attendances_teacher.session_id')
        //         ->join('versions','versions.id','=','attendances_teacher.version_id')
        //         ->join('shifts','shifts.id','=','attendances_teacher.shift_id')
        //         ->join('classes','classes.id','=','attendances_teacher.class_id')
        //         ->join('sections','sections.id','=','attendances_teacher.section_id')
        //         ->join('subjects','subjects.id','=','attendances_teacher.subject_id')
        //         ->where('attendances_teacher.id',$tea->id)
        //         ->first();
        //        // dd($attend);
        //         $activity[$key][$k]['class_name']=$attend->class_name??'';
        //         $activity[$key][$k]['version_name']=$attend->version_name??'';
        //         $activity[$key][$k]['section_name']=$attend->section_name??'';
        //         $activity[$key][$k]['subject_name']=$attend->subject_name??'';
        //         $activity[$key][$k]['attendance_date']=$attend->attendance_date??'';
        //         $activity[$key][$k]['time']=$attend->time??'';
        //     }

        // }

        return view('employee.profile', compact('teacher'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if ((Auth::user()->group_id != 2 && Auth::user()->group_id != 6) || Auth::user()->is_view_user != 0) {
            abort(403, 'You do not have permission to access this page.');
        }
        Session::put('activemenu', 'employee');
        Session::put('activesubmenu', 'ec');
        $disciplines = Discipline::where('active', 1)->get();
        $specializationes = Specialization::where('active', 1)->get();
        $designationes = Designation::where('active', 1)->orderBy('designation_name', 'asc')->get();
        $subjects = Subjects::where('active', 1)->get();
        $degrees = Degree::where('active', 1)->get();
        $sessions = Sessions::get();
        $versions = Versions::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $educations = [];
        $categories = Category::where('active', 1)->where('type', 1)->get();
        $fees = Fee::where('head_type', 2)->orderBy('id', 'asc')->get();
        return view('employee.create', compact('sessions', 'fees', 'subjects', 'educations', 'degrees', 'specializationes', 'disciplines', 'versions', 'shifts', 'categories', 'designationes'));
    }
    public function getEmployeeHeadDetails(Request $request)
    {
        $sessions = DB::table('sessions')->where('active', 1)->first();
        $heads = DB::table('employee_head_fee')
            ->join('fee_head', 'fee_head.id', '=', 'employee_head_fee.head_id')
            ->select('employee_head_fee.*', 'fee_head.head_name')
            ->where('employee_id', $request->employee_id)
            ->where('session_id', $sessions->id)
            ->get();

        return view('employee.headfee', compact('heads'));
    }
    public function employeeImport()
    {
        Excel::import(new EmployeeImport, 'xl/employee.xlsx');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function employeeSalary(Request $request)
    {
        foreach ($request->head_id as $key => $head_id) {
            $text = 'amount' . $head_id;
            $salary[$key] = array(
                'employee_id' => $request->employee_id,
                'version_id' => $request->version_id,
                'session_id' => $request->session_id,
                'salary_for' => $request->salary_for,
                'status' => $request->status,
                'amount' => $request->$text,
                'head_id' => $head_id,
                'created_by' => Auth::user()->id,
            );
        }
        DB::table('employee_head_fee')->insert($salary);
        $sms = "Successfully Inserted";
        return redirect(route('employees.edit', $request->employee_id))->with('success', $sms);
    }

    public function store(Request $request)
    {
        if ((Auth::user()->group_id != 2 && Auth::user()->group_id != 6) || Auth::user()->is_view_user != 0) {
            abort(403, 'You do not have permission to access this page.');
        }
        try {

            $id = (int)$request->id;
            $validated = [
                'employee_name' => $request->employee_name,
                'employee_name_bn' => $request->employee_name_bn,
                'emp_id' => $request->emp_id,
                'father_name' => $request->father_name,
                'mother_name' => $request->mother_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'gender' => $request->gender,
                'religion' => $request->religion,
                'blood' => $request->blood,
                'dob' => $request->dob,
                'join_date' => $request->join_date,
                'present_address' => $request->present_address,
                'permanent_address' => $request->permanent_address,
                'nationality' => $request->nationality,
                'nid' => $request->nid,
                'passport' => $request->passport,
                'job_type' => $request->job_type,
                'category_id' => $request->category_id,
                'subject_id' => $request->subject_id,
                'version_id' => $request->version_id,
                'shift_id' => $request->shift_id,
                'designation_id' => $request->designation_id,
                'employee_for' => $request->employee_for,
                'created_by' => Auth::user()->id,
                'status' => 1,
            ];

            if ($id == 0) {
                $validated['created_by'] = Auth::user()->id;
            } else {
                $validated['updated_by'] = Auth::user()->id;
            }

            if ($request->hasFile('photo')) {
                // Delete the old photo if it exists
                if (!empty($request->photo_old) && file_exists(public_path('employees/' . basename($request->photo_old)))) {
                    unlink(public_path('employees/' . basename($request->photo_old)));
                }

                // Save the new photo
                $destinationPath = 'employees';
                $myimage = $request->id . '_' . $request->photo->getClientOriginalName();
                $request->photo->move(public_path($destinationPath), $myimage);

                // Generate the full URL path for the photo
                $validated['photo'] = url('public/' . $destinationPath . '/' . $myimage);
            } else {
                // If no new photo uploaded, retain the old photo
                $validated['photo'] = $request->photo_old;
            }

            // Update the photo in both tables
            DB::table('employees')->where('id', $id)->update(['photo' => $validated['photo']]);
            DB::table('users')->where('group_id', 3)->where('ref_id', $request->id)->update(['photo' => $validated['photo']]);

            if ($id == 0) {
                // Insert a new record
                $id = Employee::insertGetId($validated);
                session()->flash('success', 'Successfully Inserted');
            } else {
                // Update existing record
                Employee::where('id', $id)->update($validated);
                session()->flash('success', 'Successfully Updated');
            }
        } catch (\Exception $e) {
            // Handle exception and return error message
            session()->flash('error', 'An error occurred: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

        if (Auth::user()->group_id == 3) {
            return redirect(route('teacherProfile'))->with('success', session('success'));
        }

        return redirect(route('employees.edit', $id))->with('success', session('success'));
    }




    public function uploadTeacherimage(Request $request)
    {
        if ((Auth::user()->group_id != 2 && Auth::user()->group_id != 6) || Auth::user()->is_view_user != 0) {
            abort(403, 'You do not have permission to access this page.');
        }
        try {
            // Validate the request
            $request->validate([
                'photo' => 'nullable|mimes:jpg,jpeg|max:200', // Allow only jpg/jpeg files with max size 200KB
            ], [
                'photo.mimes' => 'The photo must be a file of type: jpg, jpeg.',
                'photo.max' => 'The photo size must not exceed 200KB.',
            ]);

            // Handle the photo upload
            if ($request->hasFile('photo')) {
                // Delete the old photo if it exists
                if (!empty($request->photo_old) && file_exists(public_path('employees/' . basename($request->photo_old)))) {
                    unlink(public_path('employees/' . basename($request->photo_old)));
                }

                // Save the new photo
                $destinationPath = 'employees';
                $myimage = $request->id . '_' . $request->photo->getClientOriginalName();
                $request->photo->move(public_path($destinationPath), $myimage);

                // Generate the full URL path for the photo
                $photo = asset('public/' . $destinationPath . '/' . $myimage);
            } else {
                $photo = $request->photo_old;
            }

            // Prepare the data array for updating photo in both tables
            $data['photo'] = $photo;

            // Update the photo in both tables
            DB::table('employees')->where('id', $request->id)->update($data);
            DB::table('users')->where('group_id', 3)->where('ref_id', $request->id)->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Photo uploaded successfully.',
                'photo' => $photo,
            ], 200); // Return success response
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first(), // Return the first validation error message
            ], 422); // 422 Unprocessable Entity
        } catch (\Exception $e) {
            // Handle general exceptions
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500); // 500 Internal Server Error
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        Session::put('activemenu', 'employee');
        Session::put('activesubmenu', 'ec');
        $disciplines = Discipline::where('active', 1)->get();
        $specializationes = Specialization::where('active', 1)->get();
        $designationes = Designation::where('active', 1)->orderBy('serial', 'asc')->get();
        $subjects = Subjects::where('active', 1)->get();
        $degrees = Degree::where('active', 1)->get();
        $sessions = Sessions::where('active', 1)->get();
        $versions = Versions::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $categories = Category::where('active', 1)->where('type', 1)->get();
        $educations = EducationQualification::with(['discipline', 'specialization', 'degree'])->where('employee_id', $employee->id)->get();
        $fees = Fee::where('head_type', 2)->get();
        return view('employee.view', compact('sessions', 'fees', 'employee', 'educations', 'subjects', 'degrees', 'specializationes', 'disciplines', 'versions', 'shifts', 'categories', 'designationes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function teacherProfileView()
    {
        $employee = Employee::where('id', Auth::user()->ref_id)->first();

        Session::put('activemenu', 'employee');
        Session::put('activesubmenu', 'ec');
        $disciplines = Discipline::where('active', 1)->get();
        $specializationes = Specialization::where('active', 1)->get();
        $designationes = Designation::where('id', $employee->designation_id)->first();
        $subjects = Subjects::where('id', $employee->subject_id)->first();
        $degrees = Degree::where('active', 1)->get();
        $sessions = Sessions::where('active', 1)->get();
        $versions = Versions::where('id', $employee->version_id)->first();
        $shifts = Shifts::where('id', $employee->shift_id)->first();
        $employeeHeadFee = EmployeeHeadFee::where('employee_id', $employee->id)->orderBy('head_id', 'asc')->get();
        $employeeHeadFee = collect($employeeHeadFee)->groupBy('head_id');
        $categories = Category::where('id', $employee->category_id)->first();
        $educations = EducationQualification::with(['discipline', 'specialization', 'degree'])->where('employee_id', $employee->id)->get();
        $fees = Fee::where('head_type', 2)->orderBy('id', 'asc')->get();
        return view('employee.view', compact('sessions', 'employeeHeadFee', 'fees', 'employee', 'educations', 'subjects', 'degrees', 'specializationes', 'disciplines', 'versions', 'shifts', 'categories', 'designationes'));
    }
    public function teacherProfile()
    {
        $employee = Employee::where('id', Auth::user()->ref_id)->first();

        // Session::put('activemenu', 'employee');
        // Session::put('activesubmenu', 'ec');
        Session::put('activemenu', 'Profile');
        Session::put('activesubmenu', 'profile');
        $disciplines = Discipline::where('active', 1)->get();
        $specializationes = Specialization::where('active', 1)->get();
        $designationes = Designation::where('active', 1)->get();
        $subjects = Subjects::where('active', 1)->get();
        $degrees = Degree::where('active', 1)->get();
        $sessions = Sessions::where('active', 1)->get();
        $versions = Versions::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $employeeHeadFee = EmployeeHeadFee::where('employee_id', $employee->id)->orderBy('head_id', 'asc')->get();
        $employeeHeadFee = collect($employeeHeadFee)->groupBy('head_id');
        $categories = Category::where('active', 1)->get();
        $educations = EducationQualification::with(['discipline', 'specialization', 'degree'])->where('employee_id', $employee->id)->get();
        $fees = Fee::where('head_type', 2)->orderBy('id', 'asc')->get();
        return view('employee.teacherprofileupdate', compact('sessions', 'employeeHeadFee', 'fees', 'employee', 'educations', 'subjects', 'degrees', 'specializationes', 'disciplines', 'versions', 'shifts', 'categories', 'designationes'));
    }
    public function edit(Employee $employee)
    {
        if ((Auth::user()->group_id != 2 && Auth::user()->group_id != 6) || Auth::user()->is_view_user != 0) {
            abort(403, 'You do not have permission to access this page.');
        }
        Session::put('activemenu', 'employee');
        Session::put('activesubmenu', 'ec');
        $disciplines = Discipline::where('active', 1)->get();
        $specializationes = Specialization::where('active', 1)->get();
        $designationes = Designation::where('active', 1)->orderBy('serial', 'asc')->get();
        $subjects = Subjects::where('active', 1)->get();
        $degrees = Degree::where('active', 1)->get();
        $sessions = Sessions::where('active', 1)->get();
        $versions = Versions::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $employeeHeadFee = EmployeeHeadFee::where('employee_id', $employee->id)->orderBy('head_id', 'asc')->get();
        $employeeHeadFee = collect($employeeHeadFee)->groupBy('head_id');
        $categories = Category::where('active', 1)->where('type', 1)->get();
        $educations = EducationQualification::with(['discipline', 'specialization', 'degree'])->where('employee_id', $employee->id)->get();
        $fees = Fee::where('head_type', 2)->orderBy('id', 'asc')->get();
        return view('employee.create', compact('sessions', 'employeeHeadFee', 'fees', 'employee', 'educations', 'subjects', 'degrees', 'specializationes', 'disciplines', 'versions', 'shifts', 'categories', 'designationes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $Employee)
    {
        //
    }
    // public function saveEducation(Request $request)
    // {

    //     $request->validate([
    //         'specialization_name' => 'nullable|string',
    //     ]);
    //     $data = $request->except('_token', 'id', 'specialization_name');

    //     // Handle specialization_name: if provided, check if it's associated with the existing specialization
    //     if ($request->specialization_name) {
    //         // Find if there's an existing specialization with the given name for the employee's current education
    //         if ($request->id) {
    //             $education = EducationQualification::find($request->id);

    //             // If education exists, check its current specialization
    //             if ($education && $education->specialization_id) {
    //                 $specialization = Specialization::find($education->specialization_id);
    //                 if ($specialization) {
    //                     // Update the existing specialization if it matches
    //                     $specialization->specialization_name = $request->specialization_name;
    //                     $specialization->save();
    //                 } else {
    //                     // If no matching specialization found, create a new one
    //                     $newSpecialization = Specialization::create(['specialization_name' => $request->specialization_name]);
    //                     $data['specialization_id'] = $newSpecialization->id;
    //                 }
    //             } else {
    //                 // Create a new specialization if none exists for the employee
    //                 $newSpecialization = Specialization::create(['specialization_name' => $request->specialization_name]);
    //                 $data['specialization_id'] = $newSpecialization->id;
    //             }
    //         } else {
    //             // For new entries, just create a new specialization
    //             $newSpecialization = Specialization::create(['specialization_name' => $request->specialization_name]);
    //             $data['specialization_id'] = $newSpecialization->id;
    //         }
    //     } else {
    //         $data['specialization_id'] = null;
    //     }


    //     if ($request->id == 0) {
    //         DB::table('employee_education')->insert($data);
    //     } else {
    //         DB::table('employee_education')->where('id', $request->id)->update($data);
    //     }
    //     // $educations = EducationQualification::where('employee_id', $request->employee_id)->get();
    //     $educations = EducationQualification::where('employee_id', $request->employee_id)->with(['discipline', 'specialization', 'degree'])->get();
    //     return view('employee.educationinfo', compact('educations'));
    // }

    // public function saveEducation(Request $request)
    // {
    //     // dd($request->all());
    //     try {
    //         // Validate the request
    //         $request->validate([
    //             'file' => 'nullable|mimes:jpg,jpeg,pdf|max:200', // Only JPG, JPEG, PDF, max 200KB
    //             'specialization_name' => 'nullable|string',
    //         ]);

    //         $data = $request->except('_token', 'id', 'file'); // Exclude file from data

    //         // Handle file upload
    //         if ($request->hasFile('file')) {
    //             $file = $request->file('file');
    //             $filename = time() . '_' . $file->getClientOriginalName(); // Create a unique filename
    //             $destinationPath = public_path('employeeEducation'); // Path to the public/employeeEducation folder

    //             // Ensure the destination directory exists
    //             if (!file_exists($destinationPath)) {
    //                 mkdir($destinationPath, 0777, true); // Create the folder with appropriate permissions
    //             }

    //             // Move the file to the public/employeeEducation directory
    //             $file->move($destinationPath, $filename);

    //             // Store the relative path in the database
    //             $data['file'] = 'employeeEducation/' . $filename;
    //         }

    //         // Insert or update education data
    //         if ($request->id == 0) {
    //             DB::table('employee_education')->insert($data);
    //         } else {
    //             DB::table('employee_education')->where('id', $request->id)->update($data);
    //         }

    //         // Fetch updated education records
    //         $educations = EducationQualification::where('employee_id', $request->employee_id)
    //             ->with(['discipline', 'degree'])
    //             ->get();

    //         // Return success response
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Education details saved successfully!',
    //             'educations' => $educations,
    //         ]);
    //     } catch (\Exception $e) {
    //         // Return error response
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'An error occurred: ' . $e->getMessage(),
    //         ], 500);
    //     }
    // }

    public function saveEducation(Request $request)
    {
        // dd($request->all());
        if ((Auth::user()->group_id != 2 && Auth::user()->group_id != 6) || Auth::user()->is_view_user != 0) {
            abort(403, 'You do not have permission to access this page.');
        }
        try {
            // $data = $request->except('_token', 'id', 'file'); // Exclude file from data

            $data = [
                'employee_id' => (int) $request->employee_id,
                'degree_id' => (int) $request->degree_id,
                'discipline_name' => $request->discipline_name,
                'specialization_name' => $request->specialization_name,
                'yearOfSchooling' => $request->yearOfSchooling,
                'degree_name' => $request->degree_name,
                'passingYear' => $request->passingYear,
                'institute' => $request->institute,
                'grade_division' => $request->grade_division,
                'result' => $request->result,
            ];

            if ($request->hasFile('file')) {
                // Validate the file
                $request->validate([
                    'file' => 'nullable|mimes:jpg,jpeg,pdf|max:200', // Validate file type and size
                    'specialization_name' => 'nullable|string',
                ]);

                // Delete the old photo if it exists
                if (!empty($request->file_old) && file_exists(public_path('employeeEducation/' . basename($request->file_old)))) {
                    unlink(public_path('employeeEducation/' . basename($request->file_old)));
                }

                // Save the new photo
                $destinationPath = 'employeeEducation';
                $myimage = $request->id . '_' . $request->file->getClientOriginalName();
                $request->file->move(public_path($destinationPath), $myimage);

                // Generate the full URL path for the photo
                $data['file'] = url('public/' . $destinationPath . '/' . $myimage);
            } else {
                // If no new photo uploaded, retain the old photo
                $data['file'] = $request->file_old;
            }




            // Insert or update education data
            if ($request->id == 0) {
                DB::table('employee_education')->insert($data);
            } else {
                DB::table('employee_education')->where('id', $request->id)->update($data);
            }

            // Fetch updated education records
            $educations = EducationQualification::where('employee_id', $request->employee_id)
                ->with(['discipline', 'degree'])
                ->get();

            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => 'Education details saved successfully!',
                'educations' => $educations,
            ]);
        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }




    public function getEmployeeAcademicInfo(Request $request)
    {
        $educations = EducationQualification::where('employee_id', $request->id)->get();
        return view('employee.educationinfo', compact('educations'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            abort(403, 'You do not have permission to access this page.');
        }
        try {
            $Employee = Employee::find($id);
            $Employee->delete();
            return 1;
        } catch (Exception $e) {
            return $e;
        }
    }
    public function employeeUser()
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 6) {
            abort(403, 'You do not have permission to access this page.');
        }
        $employees = Employee::where('active', 1)->get();
        foreach ($employees as $key => $employee) {

            $username = null;
            if ($employee->email) {
                $username = $employee->email;
            } elseif ($employee->sms_notification_number) {
                $username = $employee->sms_notification_number;
            } elseif ($employee->mobile) {
                $username = $employee->mobile;
            }
            if ($username && $username != 'N/A') {
                $userexist = DB::table('users')->where('username', $username)->first();
                if (empty($userexist)) {
                    $userdata = [
                        'name' => $employee->employee_name,
                        'username' => $username,
                        'email' => $employee->email,
                        'phone' => $employee->sms_notification_number ?? $employee->mobile,
                        'photo' => $employee->photo,
                        'group_id' => ($employee->category_id == 7) ? 3 : 11,
                        'ref_id' => $employee->id,
                        'password' => bcrypt(123456)
                    ];
                    $id = DB::table('users')->insertGetId($userdata);
                    //$user->create(array_merge($request->validated()));
                    //$user->syncRoles($request->get('group_id'));
                    //dd($user);
                    $usersyncroles = array(
                        'role_id' => ($employee->category_id == 7) ? 3 : 11,
                        'model_type' => 'App\Models\User',
                        'model_id' => $id
                    );
                    DB::table('model_has_roles')->insert($usersyncroles);
                } else {
                    $userdata = [

                        'ref_id' => $employee->id

                    ];
                    DB::table('users')->where('id', $userexist->id)->update($userdata);
                }
            }
        }
    }
    public function parentUserCreate()
    {
        Session::put('activemenu', 'users');
        Session::put('activesubmenu', 'uc');

        return view('users.student_create');
    }
    public function parentUser(Request $request)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 6) {
            abort(403, 'You do not have permission to access this page.');
        }
        $version_id = $request->version_id;
        $class_code = $request->class_code;
        $students = Student::join('student_activity', 'student_activity.student_code', '=', 'students.student_code')
            ->where('students.active', 1)
            ->where('student_activity.class_code', $class_code)
            ->where('student_activity.version_id', $version_id)
            ->get();
        $i = 0;
        $usersyncroles = [];
        foreach ($students as $key => $student) {

            $username = null;
            if ($student->sms_notification) {
                $username = $student->sms_notification;
            } elseif ($student->local_guardian_mobile) {
                $username = $student->local_guardian_mobile;
            } elseif ($student->mobile) {
                $username = $student->mobile;
            } elseif ($student->email) {
                $username = $student->email;
            }
            if ($username && $username != 'N/A') {
                $userexist = DB::table('users')->where('username', $username)->first();
                if (empty($userexist)) {
                    $userdata = [
                        'name' => $student->first_name,
                        'username' => $username,
                        'email' => $student->email,
                        'phone' => $student->sms_notification ?? $student->mobile,
                        'photo' => $student->photo,
                        'group_id' => 4,
                        'ref_id' => $student->student_code,
                        'is_admission' => 0,
                        'password' => bcrypt(123456)
                    ];
                    $id = DB::table('users')->insertGetId($userdata);
                    //$user->create(array_merge($request->validated()));
                    //$user->syncRoles($request->get('group_id'));
                    //dd($user);
                    $usersyncroles[$i++] = array(
                        'role_id' => 4,
                        'model_type' => 'App\Models\User',
                        'model_id' => $id
                    );
                }
            }
        }
        if ($usersyncroles) {
            DB::table('model_has_roles')->insert($usersyncroles);
        }
        return redirect(route('parentUserCreate'))->with('success', "Class " . $class_code . "" . (($version_id == 1) ? 'Bangla' : 'English') . " Version User Create Succes");
    }

    public function getClassWiseEmployees(Request $request)
    {
        $employees = DB::table('employee_activity')
            ->join('employees', 'employees.id', '=', 'employee_activity.employee_id')
            ->select('employees.employee_name', 'employees.id')
            ->where('employees.active', 1)
            ->where('employee_activity.class_code', $request->class_code)
            ->where('employee_activity.version_id', $request->version_id)
            ->where('employee_activity.shift_id', $request->shift_id)
            ->where('employee_activity.session_id', $request->session_id)
            ->where('employee_activity.section_id', $request->section_id)
            ->distinct()
            ->get();

        return view('employee.class_wise_employee', compact('employees'));
    }
}
