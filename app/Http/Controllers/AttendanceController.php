<?php

namespace App\Http\Controllers;

use App\Models\Attendance\Attendance;
use App\Models\Attendance\TeacherAttendance;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeActivity;
use App\Models\sttings\AcademySection;
use App\Models\sttings\Classes;
use App\Models\sttings\Sections;
use App\Models\sttings\Sessions;
use App\Models\sttings\Versions;
use App\Models\sttings\Shifts;
use App\Helpers\Helpers;
use App\Models\SMS;
use App\Models\sttings\Teachers;
use App\Models\Student\Student;
use App\Models\Student\StudentActivity;
use App\Models\Student\StudentAttendance;
use App\Models\Student\TcInactive;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mpdf\Mpdf;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function studentAttendance()
    {

        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        Session::put('activemenu', 'attendance');
        Session::put('activesubmenu', 'sa');


        if (Session::get('type') == 1) {
            $type = 1;
            $type_name = 'primary';
        } elseif (Session::get('type') == 2) {
            $type = 2;
            $type_name = 'secondary';
        } else {
            $type = 3;
            $type_name = 'college';
        }
        $sections = [];

        if (Session::get('class_id') || Session::get('class_id') == 0) {
            $class_id = Session::get('class_id');
            $sections = Sections::where('active', 1)->where('class_code', Session::get('class_id'))->get();
        }
        $sessions = Sessions::all();
        $classess = Classes::where('active', 1)->where('class_for', $type)->where('version_id', 1)->get();

        $shifts = Shifts::where('active', 1)->get();
        return view('attendance.student.student', compact('sessions', 'type_name', 'type', 'classess', 'shifts', 'sections'));
    }
    public function teacherAttendance()
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        Session::put('activemenu', 'attendance');
        Session::put('activesubmenu', 'ta');
        if (Session::get('type_t') == 1) {
            $type = 1;
            $type_name = 'primary';
        } elseif (Session::get('type_t') == 2) {
            $type = 2;
            $type_name = 'secondary';
        } else {
            $type = 3;
            $type_name = 'college';
        }
        $sections = [];
        if (Session::get('class_id_t')) {
            $class_id = Session::get('class_id_t');
            $sections = Sections::where('active', 1)->where('class_id', $class_id)->get();
        }
        $sessions = Sessions::where('active', 1)->get();
        $classess = Classes::where('active', 1)->where('class_for', $type)->get();
        $shifts = Shifts::where('active', 1)->get();
        return view('attendance.teacher.teacher', compact('sessions', 'type_name', 'type', 'classess', 'shifts', 'sections'));
    }
    public function staffAttendance()
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        Session::put('activemenu', 'attendance');
        Session::put('activesubmenu', 'st');
        if (Session::get('type_s') == 1) {
            $type = 1;
            $type_name = 'primary';
        } elseif (Session::get('type_s') == 2) {
            $type = 2;
            $type_name = 'secondary';
        } else {
            $type = 3;
            $type_name = 'college';
        }
        $shifts = Shifts::where('active', 1)->get();

        return view('attendance.staff.staff', compact('shifts', 'type_name', 'type'));
    }
    public function getSections(Request $request)
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        if (isset($request->shift_id) || isset($request->version_id)) {
            $sections = Sections::where('active', 1)
                ->select('sections.*')

                ->where('shift_id', $request->shift_id);
            //->where('version_id',$request->version_id)
            //->where('class_id',$request->class_id)
            if (isset($request->version_id)) {
                $sections = $sections->where('version_id', $request->version_id);
            }
            $sections = $sections->where('class_id', $request->class_id)
                ->get();
        } else {
            $sections = Sections::where('active', 1)
                ->select('sections.*')

                ->where('class_id', $request->class_id)
                ->get();
        }
        if (Auth::user()->group_id == 3) {
            $employee = Employee::where('id', Auth::user()->ref_id)->first();
            $session = Sessions::where('session_name', date('Y'))->first();
            $sections = EmployeeActivity::join('classes', 'classes.class_code', '=', 'employee_activity.class_code')
                ->join('sections', 'sections.id', '=', 'employee_activity.section_id')
                ->where('employee_id', $employee->id)
                ->where('is_class_teacher', 1)
                ->where('employee_activity.session_id', $session->id)
                ->where('employee_activity.shift_id', $employee->shift_id)
                ->select('sections.id', 'section_name')
                ->with(['version', 'shift'])
                ->DISTINCT('section_name')
                ->groupBy('sections.id')
                ->groupBy('section_name')
                ->get();
        }

        return view('attendance.student.section', compact('sections'));
    }
    public function getSectionsForSMS(Request $request)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        $option = $request->option;
        if ($request->class_code == 11) {
            $sections = Sections::where('sections.active', 1)
                ->select('sections.*')
                ->join('classes', 'classes.id', '=', 'sections.class_id')
                ->where('sections.class_code', $request->class_code)
                ->get();
        } else {
            $sections = Sections::where('sections.active', 1)
                ->select('sections.*')
                ->join('classes', 'classes.id', '=', 'sections.class_id')
                ->where('sections.class_code', $request->class_code)
                ->where('sections.version_id', $request->version_id)
                ->where('sections.shift_id', $request->shift_id)
                ->where('classes.class_for', $request->type_for)
                ->get();
        }

        return view('attendance.student.section', compact('sections', 'option'));
    }

    public function getStudentOrTeacherData(Request $request)
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        //dd($request->all());
        $searchdata = $request->all();
        if ($request->sms_for == 1) {

            $studentdata = getStudent('roll,student_code,first_name,last_name,sms_notification,email,mobile', 'roll,student_code,first_name,last_name,sms_notification,email,mobile', $searchdata);
            $studentdata = json_decode(json_encode($studentdata), true);

            // Option 2: Using Laravel's collection to work with array-like syntax

            $mobiles = collect($studentdata)->pluck('sms_notification');
            $students = collect($studentdata)->filter(function ($item) {
                return !empty($item['sms_notification']) && strlen($item['sms_notification']) >= 11;
            });

            return view('sms.student', compact('students', 'mobiles'));
        } elseif ($request->sms_for == 2) {
            $searchdata['employee_for'] = $searchdata['class_for'] ?? '';
            $searchdata['category_id'] = 7;
            $employees = getEmployee('emp_id,employee_name,designation_name,email,mobile', 'emp_id,employee_name,designation_name,email,mobile', $searchdata);
            return view('sms.employee', compact('employees'));
        } elseif ($request->sms_for == 3) {
            $searchdata['employee_for'] = $searchdata['class_for'] ?? '';
            $searchdata['category_id'] = 8;
            $employees = getEmployee('emp_id,employee_name,designation_name,email,mobile', 'emp_id,employee_name,designation_name,email,mobile', $searchdata);
            return view('sms.employee', compact('employees'));
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function getStudents(Request $request)
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        $session_id = $request->session_id;
        $shift_id = $request->shift_id;
        $class_id = $request->class_id;
        $class_code = $request->class_code;
        $section_id = $request->section_id;
        $version_id = $request->version_id;
        $attendance_date = $request->attendance_date;

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
            $condition .= ' and attendances.class_id=' . $class_id;
        }
        if ($section_id) {
            $conditions .= ' and student_activity.section_id=' . $section_id;
            $condition .= ' and attendances.section_id=' . $section_id;
        }
        if ($attendance_date) {
            $condition .= ' and attendance_date="' . $attendance_date . '"';
        }
        // dd($conditions, $condition);
        $students = Student::where('students.active', 1)
            ->join('student_activity', 'student_activity.student_code', '=', 'students.student_code')
            ->join('versions', 'versions.id', '=', 'student_activity.version_id')
            ->join('shifts', 'shifts.id', '=', 'student_activity.shift_id')
            ->join('classes', 'classes.class_code', '=', 'student_activity.class_code')
            ->join('sections', 'sections.id', '=', 'student_activity.section_id')
            ->join('sessions', 'sessions.id', '=', 'student_activity.session_id')
            ->whereRaw($conditions)
            ->with(["studentAttendance" => function ($query) use ($condition) {
                return $query->whereRaw($condition);
            }]);



        if (Auth::user()->class_id) {
            $students->whereIn('student_activity.class_id', implode(',', Auth::user()->class_id));
        }
        if (Auth::user()->version_id) {
            $students->where('student_activity.version_id', Auth::user()->version_id);
        }
        if (Auth::user()->shift_id) {
            $students->where('student_activity.shift_id', Auth::user()->shift_id);
        }
        $students = $students->selectRaw('students.*,version_name,shift_name,class_name,section_name,roll,session_name,start_time')
            ->orderBy('student_activity.roll', 'asc')
            ->get();
        $students = collect($students)->unique('student_code');
        return view('attendance.student.search', compact('students'));
    }
    public function getAttendanceByDate(Request $request)
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        $attendances = Attendance::where('student_code', $request->student_code)
            ->whereBetween('attendance_date', [$request->start_date, $request->end_date])->get();
        return view('attendance.student.attendance', compact('attendances'));
    }

    public function getAttendanceByMonth(Request $request)
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        $month = $request->input('month');
        $studentCode = $request->input('student_code');

        if (!$month || !$studentCode) {
            return response()->json(['error' => 'Invalid request'], 400);
        }

        try {
            $year = Carbon::now()->year;
            $startDate = Carbon::create($year, $month)->startOfMonth();
            $endDate = $startDate->copy()->endOfMonth();

            $attendanceData = Attendance::where('student_code', $studentCode)
                ->whereBetween('attendance_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                ->orderBy('attendance_date', 'asc')
                ->get();

            $view = view('student.calendar', [
                'attendanceData' => $attendanceData,
                'startDate' => $startDate->format('Y-m-d'),
                'endDate' => $endDate->format('Y-m-d'),
            ])->render();

            return response()->json($view);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function getStudentsReport(Request $request)
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        $session_id = $request->session_id;
        $shift_id = $request->shift_id;
        $class_id = $request->class_id;
        $section_id = $request->section_id;
        $version_id = $request->version_id;
        $attendance_date = $request->attendance_date;
        $status = $request->status;
        Session::put('status', $status);
        $conditions = " 1=1";
        $condition = " 1=1";
        if ($session_id) {
            //$conditions.=' and session_id='.$session_id;
            $condition .= ' and student_activity.session_id=' . $session_id;
        }
        if ($version_id) {
            //$conditions.=' and student_activity.version_id='.$version_id;
            $condition .= ' and student_activity.version_id=' . $version_id;
        }
        if ($shift_id) {
            //$conditions.=' and student_activity.shift_id='.$shift_id;
            $condition .= ' and student_activity.shift_id=' . $shift_id;
        }
        if ($class_id) {
            //$conditions.=' and student_activity.class_code='.$class_id;
            $condition .= ' and student_activity.class_code=' . $class_id;
        }
        if ($section_id) {
            //$conditions.=' and attendances.section_id='.$section_id;
            $condition .= ' and student_activity.section_id=' . $section_id;
        }
        if ($attendance_date) {
            $condition .= ' and attendances.attendance_date like "%' . $attendance_date . '%"';
        }
        if ($status) {
            if ($status == 1) {
                $condition .= ' and attendances.status in (1,4)';
            } else {
                $condition .= ' and attendances.status=' . $status;
            }
        }
        //dd($condition);
        $classteacher = DB::table('employee_activity')
            ->join('employees', 'employees.id', '=', 'employee_activity.employee_id')
            ->join('designations', 'designations.id', '=', 'employees.designation_id')
            ->where('employee_activity.session_id', $session_id)
            ->where('employee_activity.version_id', $version_id)
            ->where('employee_activity.shift_id', $shift_id)
            ->where('employee_activity.class_code', $class_id)
            ->where('employee_activity.section_id', $section_id)
            ->where('is_class_teacher', 1)
            ->first();

        $students = Student::where('students.active', 1)
            ->join('student_activity', 'student_activity.student_code', '=', 'students.student_code')
            ->join('attendances', 'attendances.student_code', '=', 'students.student_code')
            ->join('versions', 'versions.id', '=', 'student_activity.version_id')
            ->join('classes', 'classes.class_code', '=', 'student_activity.class_code')
            ->join('shifts', 'shifts.id', '=', 'student_activity.shift_id')
            ->join('sections', 'sections.id', '=', 'student_activity.section_id')
            ->join('sessions', 'sessions.id', '=', 'student_activity.session_id')
            ->whereRaw($condition)
            // ->with(["studentAttendance" => function ($query) use($condition){
            //     return $query->whereRaw($condition);
            //  }])
            ->selectRaw('students.*,version_name,shift_name,class_name,section_name,roll,session_name,attendances.status, attendances.time')
            ->orderBy('student_activity.roll', 'asc')
            ->get();
        $students = collect($students)->unique('student_code');
        return view('report.attendance.studentsearch', compact('students', 'classteacher'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function getStartTime($shift_id, $class_code)
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
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
    function storeSms($sms_notification, $body, $student_code = null)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        $smscount = explode(',', $sms_notification);
        $sms = new SMS();
        $sms->session_id = Session::get('session_id');
        $sms->student_code = $student_code;
        $sms->lang = 2;
        $sms->send_for = 1;
        $sms->number_of_sms = count($smscount);
        $sms->smscount = 1;
        $sms->numbers = $sms_notification;
        $sms->sms_body = $body;
        $sms->status = 202;
        $sms->created_by = Auth::user()->id;
        $sms->save();
        return 1;
    }
    function sendSMSForAttbulk($status, $sms_notification)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        $mobile = $sms_notification ?? null;

        if ($mobile) {
            if ($status == 2) {
                $text = "Your child was absent today";
                sms_send($mobile, $text);
                $this->storeSms($mobile, $text);
            } elseif ($status == 4) {
                $text = "Your child was late today";
                sms_send($mobile, $text);
                $this->storeSms($mobile, $text);
            } elseif ($status == 5) {
                $text = "Your child is missing from the class right now";
                sms_send($mobile, $text);
                $this->storeSms($mobile, $text);
            }
        }
        return 1;
    }
    function sendSMSForAtt($status, $sms_notification, $first_name, $student_code = null)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3) {
            return 1;
        }

        // dd($status, $sms_notification, $first_name, $student_code);
        $mobile = $sms_notification ?? null;

        if ($mobile) {
            if ($status == 2) {
                $text = "Your child " . $first_name . " was absent today";
                sms_send($mobile, $text);
                $this->storeSms($mobile, $text, $student_code);
            } elseif ($status == 4) {
                $text = "Your child " . $first_name . " was late today";
                sms_send($mobile, $text);
                $this->storeSms($mobile, $text, $student_code);
            } elseif ($status == 5) {
                $text = "Your child is missing from the class right now";
                sms_send($mobile, $text);
                $this->storeSms($mobile, $text, $student_code);
            }
        }
        return 1;
    }
    function lasttime($class_code, $shift_id)
    {
        if ($class_code == 11 || $class_code == 12) {
            return 60;
        } else {
            return 60;
        }
    }
    public function studentAttendanceStore(Request $request)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3) {

            return 1;
        }
        $version_id = $request->version_id;
        $session_id = $request->session_id;

        $type = match ($request->type) {
            'college' => 3,
            'secondary' => 2,
            default => 1
        };

        $attendance_date = $request->attendance_date;
        $shift_id = $request->shift_id;
        $class_id = $request->class_id;
        $section_id = $request->section_id;

        Session::put('version_id', $version_id);
        Session::put('session_id', $session_id);
        Session::put('attendance_date', $attendance_date);
        Session::put('type', $type);
        Session::put('shift_id', $shift_id);
        Session::put('class_id', $class_id);
        Session::put('section_id', $section_id);

        $student_code = $request->student_code;
        $attendance = [];
        $phonedata = [];
        $todayatt = [];

        if (isset($student_code[0])) {
            $todayatt = Attendance::where('attendance_date', $attendance_date)
                ->where('student_code', $student_code[0])->first();
        }
        // dd($todayatt);
        if ($todayatt) {
            return response()->json([
                'error' => "Already Submit students attendance."
            ], 422);
        }
        foreach ($student_code as $key => $id) {
            $attend = 'attendance' . $id;
            $time = 'time' . $id;
            $sms_notification = 'sms_notification' . $id;
            $first_name = 'first_name' . $id;
            $timedata = $request->$time;
            $status = $request->$attend;

            if (!isset($status)) {
                return response()->json([
                    'error' => "Please select attendance for all students."
                ], 422);
            }

            // if ($status == 1) {
            //     $minitrs = date('H:i', strtotime($timedata));
            //     $max_time = $this->getStartTime($shift_id, $class_id);

            //     if ($minitrs > $max_time) {
            //         $status = 4;
            //     }
            // }

            $phonedata[$key]['mobile'] = $request->$sms_notification;
            $phonedata[$key]['first_name'] = $request->$first_name;
            $attendance[$key] = [
                'session_id' => $session_id,
                'version_id' => $version_id,
                'shift_id' => $shift_id,
                'class_id' => $class_id,
                'class_code' => $class_id,
                'section_id' => $section_id,
                'attendance_date' => $attendance_date,
                'time' => ($status == 1 || $status == 4) ? $timedata : null,
                'student_code' => $id,
                'status' => $status ?? 2, // Default to 2 if status is empty
                'active' => 1,
                'created_by' => Auth::user()->id,
                'created_at' => date('Y-m-d H:i:s')
            ];
        }
        //dd($absent,$late,$missing);
        Attendance::insert($attendance);

        foreach ($attendance as $k => $value) {
            // dd($value);
            $this->sendSMSForAtt($value['status'], $phonedata[$k]['mobile'], $phonedata[$k]['first_name'], $value['student_code']);
        }

        return response()->json([
            'success' => "Attendance Successfully Saved"
        ], 200);
    }


    public function updateAttendance(Request $request)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3) {
            return 1;
        }
        $version_id = $request->version_id;
        $session_id = $request->session_id;
        $attendance_date = $request->attendance_date;
        $shift_id = $request->shift_id;
        $class_id = $request->class_id;
        $class_code = $request->class_id;
        $section_id = $request->section_id;
        $student_code = $request->student_code;
        $timedata = $request->time;
        $status = $request->status;

        if ($status == 1) {
            $minitrs = date('H:i', strtotime($timedata));

            $max_time = $this->getStartTime($shift_id, $class_code);

            if ($minitrs > $max_time) {
                $status = 4;
            }
        }
        if (empty($status)) {
            $status = 2;
        }
        $phonedata['mobile'] = $request->sms_notification;
        $phonedata['first_name'] = $request->first_name;
        $attendance['session_id'] = $session_id;
        $attendance['version_id'] = $version_id;
        $attendance['shift_id'] = $shift_id;
        $attendance['class_id'] = $class_id;
        $attendance['class_code'] = $class_id;
        $attendance['section_id'] = $section_id;
        $attendance['attendance_date'] = $attendance_date;
        $attendance['time'] = ($status == 1 || $status == 4) ? $timedata : null;
        $attendance['student_code'] = $student_code;
        $attendance['status'] = $status;
        $attendance['active'] = 1;
        $attendance['updated_by'] = Auth::user()->id;
        $attendance['updated_at'] = date('Y-m-d H:i:s');

        Attendance::where('attendance_date', $attendance_date)->where('student_code', $student_code)->update($attendance);

        if ($class_id == 11 || $class_id == 12) {
            if ($status == 5) {
                $this->sendSMSForAtt($status, $phonedata['mobile'], $phonedata['first_name'], $student_code);
            }
        }

        if ($attendance) {
            return $sms = "Successfully Inserted";
        }
    }
    public function getTeachers(Request $request)
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        $session_id = $request->session_id;
        $shift_id = $request->shift_id;
        $class_id = $request->class_id;
        $section_id = $request->section_id;
        $version_id = $request->version_id;
        $attendance_date = $request->attendance_date;
        $conditions = " 1=1";
        $condition = " 1=1";
        if ($session_id) {
            $conditions .= ' and employee_activity.session_id=' . $session_id;
            $condition .= ' and session_id=' . $session_id;
        }
        if ($version_id) {
            $conditions .= ' and employee_activity.version_id=' . $version_id;
            $condition .= ' and version_id=' . $version_id;
        }
        if ($shift_id) {
            $conditions .= ' and employee_activity.shift_id=' . $shift_id;
            $condition .= ' and shift_id=' . $shift_id;
        }
        if ($class_id) {
            $conditions .= ' and employee_activity.class_id=' . $class_id;
            $condition .= ' and class_id=' . $class_id;
        }
        if ($section_id) {
            $conditions .= ' and employee_activity.section_id=' . $section_id;
            $condition .= ' and section_id=' . $section_id;
        }
        if ($attendance_date) {
            $condition .= ' and attendance_date="' . $attendance_date . '"';

            $timestamp = strtotime($attendance_date);

            $day = strtolower(date('D', $timestamp));

            $conditions .= ' and day_name="' . $day . '"';
        }

        //dd($conditions);

        $employees = Employee::where('employees.active', 1)
            ->join('employee_activity', 'employee_activity.employee_id', '=', 'employees.id')
            ->leftJoin('versions', 'versions.id', '=', 'employee_activity.version_id')
            ->leftJoin('shifts', 'shifts.id', '=', 'employee_activity.shift_id')
            ->leftJoin('classes', 'classes.id', '=', 'employee_activity.class_id')
            ->leftJoin('sections', 'sections.id', '=', 'employee_activity.section_id')
            ->leftJoin('sessions', 'sessions.id', '=', 'employee_activity.session_id')
            ->leftJoin('subjects', 'subjects.id', '=', 'employee_activity.subject_id')
            ->leftJoin('designations', 'designations.id', '=', 'employees.designation_id')
            ->whereRaw($conditions)
            ->with(["employeeAttendance" => function ($query) use ($condition) {
                return $query->whereRaw($condition);
            }])
            ->selectRaw('employees.*,employee_activity.day_name,employee_activity.start_time,designation_name,employee_activity.subject_id,subject_name,employee_activity.start_time,end_time,version_name,shift_name,class_name,section_name,session_name')
            ->get();

        return view('attendance.teacher.search', compact('employees'));
    }
    public function getTeachersReport(Request $request)
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        $session_id = $request->session_id;
        $shift_id = $request->shift_id;
        $class_id = $request->class_id;
        $section_id = $request->section_id;
        $version_id = $request->version_id;
        $attendance_date = $request->attendance_date;
        $conditions = " 1=1";
        $condition = " 1=1";
        if ($session_id) {
            $conditions .= ' and session_id=' . $session_id;
            $condition .= ' and session_id=' . $session_id;
        }
        if ($version_id) {
            $conditions .= ' and employee_activity.version_id=' . $version_id;
            $condition .= ' and version_id=' . $version_id;
        }
        if ($shift_id) {
            $conditions .= ' and employee_activity.shift_id=' . $shift_id;
            $condition .= ' and shift_id=' . $shift_id;
        }
        if ($class_id) {
            $conditions .= ' and employee_activity.class_id=' . $class_id;
            $condition .= ' and class_id=' . $class_id;
        }
        if ($section_id) {
            $conditions .= ' and section_id=' . $section_id;
            $condition .= ' and section_id=' . $section_id;
        }
        if ($attendance_date) {
            $condition .= ' and attendance_date="' . $attendance_date . '"';

            $timestamp = strtotime($attendance_date);

            $day = strtolower(date('D', $timestamp));

            $conditions .= ' and day_name="' . $day . '"';
        }



        $employees = Employee::where('employees.active', 1)
            ->join('employee_activity', 'employee_activity.employee_id', '=', 'employees.id')
            ->leftJoin('versions', 'versions.id', '=', 'employee_activity.version_id')
            ->leftJoin('shifts', 'shifts.id', '=', 'employee_activity.shift_id')
            ->leftJoin('classes', 'classes.id', '=', 'employee_activity.class_id')
            ->leftJoin('sections', 'sections.id', '=', 'employee_activity.section_id')
            ->leftJoin('sessions', 'sessions.id', '=', 'employee_activity.session_id')
            ->leftJoin('subjects', 'subjects.id', '=', 'employee_activity.subject_id')
            ->leftJoin('designations', 'designations.id', '=', 'employees.designation_id')
            ->whereRaw($conditions)
            ->with(["employeeAttendance" => function ($query) use ($condition) {
                return $query->whereRaw($condition);
            }])
            ->selectRaw('employees.*,employee_activity.day_name,employee_activity.start_time,designation_name,subject_name,employee_activity.start_time,end_time,version_name,shift_name,class_name,section_name,session_name')
            ->get();

        return view('report.attendance.teachersearch', compact('employees'));
    }
    public function getStaffs(Request $request)
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        $shift_id = $request->shift_id;

        $attendance_date = $request->attendance_date;
        if ($request->type == 'college') {
            $type = 3;
        } elseif ($request->type == 'secondary') {
            $type = 2;
        } else {
            $type = 1;
        }
        $category = 8;
        $condition = " 1=1";
        $conditions = " employees.category_id=" . $category;
        // $conditions="  category_id=".$category." and employee_for=".$type;

        if ($shift_id) {
            //$condition.=' and attendances_teacher.shift_id='.$shift_id;
            //$conditions.=' and employees.shift_id='.$shift_id;
        }

        if ($attendance_date) {
            $condition .= ' and attendance_date="' . $attendance_date . '"';
        }



        $employees = Employee::where('employees.active', 1)
            //->join('employee_activity','employee_activity.employee_id','=','employees.id')
            ->leftJoin('designations', 'designations.id', '=', 'employees.designation_id')
            ->whereRaw($conditions)
            ->with(["employeeAttendance" => function ($query) use ($condition) {
                return $query->whereRaw($condition);
            }])
            ->selectRaw('employees.*,designation_name')
            ->get();

        return view('attendance.staff.search', compact('employees'));
    }
    public function getStaffsReport(Request $request)
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        $shift_id = $request->shift_id;

        $attendance_date = $request->attendance_date;
        if ($request->type == 'college') {
            $type = 3;
        } elseif ($request->type == 'secondary') {
            $type = 2;
        } else {
            $type = 1;
        }
        $category = 8;
        $condition = " 1=1";
        $conditions = " category_id=" . $category . " and employee_for=" . $type;

        if ($shift_id) {
            $condition .= ' and shift_id=' . $shift_id;
            $conditions .= ' and shift_id=' . $shift_id;
        }

        if ($attendance_date) {
            $condition .= ' and attendance_date="' . $attendance_date . '"';
        }



        $employees = Employee::where('employees.active', 1)
            ->join('employee_activity', 'employee_activity.employee_id', '=', 'employees.id')
            ->leftJoin('shifts', 'shifts.id', '=', 'employee_activity.shift_id')
            ->leftJoin('designations', 'designations.id', '=', 'employees.designation_id')
            ->whereRaw($conditions)
            ->with(["employeeAttendance" => function ($query) use ($condition) {
                return $query->whereRaw($condition);
            }])
            ->selectRaw('employees.*,designation_name,shift_name')
            ->get();

        return view('report.attendance.staffsearch', compact('employees'));
    }
    public function teacherAttendanceStore(Request $request)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        $version_id = $request->version_id;
        $session_id = $request->session_id;
        if ($request->type == 'college') {
            $type = 3;
        } elseif ($request->type == 'secondary') {
            $type = 2;
        } else {
            $type = 1;
        }
        $attendance_date = $request->attendance_date;
        $shift_id = $request->shift_id;
        $class_id = $request->class_id;
        $section_id = $request->section_id;
        Session::put('version_id_t', $version_id);
        Session::put('session_id_t', $session_id);
        Session::put('attendance_date_t', $attendance_date);
        Session::put('type_t', $type);
        Session::put('shift_id_t', $shift_id);
        Session::put('class_id_t', $class_id);
        Session::put('section_id_t', $section_id);
        //try {

        $teacher_id = $request->teacher_id;

        $attendance = [];
        foreach ($teacher_id as $key => $id) {
            $attend = 'attendance' . $id;
            $time = 'time' . $id;
            $atime = 'atime' . $id;
            //dd($atime);
            $teachersubjectid = explode("-", $id);
            $teacher_id = $teachersubjectid[0];
            $subject_id = $teachersubjectid[1];
            if (TeacherAttendance::where('attendance_date', $attendance_date)
                ->where('session_id', $session_id)
                ->where('version_id', $version_id)
                ->where('shift_id', $shift_id)
                ->where('class_id', $class_id)
                ->where('section_id', $section_id)
                ->where('subject_id', $subject_id)
                ->where('attendance_date', $attendance_date)
                ->where('employee_id', $teacher_id)->exists()
            ) {
                $time = $request->$time;

                $status = $request->$attend;
                if ($request->$attend == 1) {
                    $atime = $request->$atime;
                    $minitrs = (strtotime($time) - strtotime($atime)) / 60;

                    if ($minitrs > 9) {
                        $status = 4;
                    }
                }
                TeacherAttendance::where('attendance_date', $attendance_date)
                    ->where('session_id', $session_id)
                    ->where('version_id', $version_id)
                    ->where('shift_id', $shift_id)
                    ->where('class_id', $class_id)
                    ->where('section_id', $section_id)
                    ->where('subject_id', $subject_id)
                    ->where('attendance_date', $attendance_date)
                    ->where('employee_id', $teacher_id)->update(['status' => $status, 'attendance_date' => $attendance_date, 'time' => ($status == 1 || $status == 4) ? $time : null, 'updated_by' => Auth::user()->id]);
                $sms = "Successfully Updated";
                $ta = TeacherAttendance::where('attendance_date', $attendance_date)
                    ->where('session_id', $session_id)
                    ->where('version_id', $version_id)
                    ->where('shift_id', $shift_id)
                    ->where('class_id', $class_id)
                    ->where('section_id', $section_id)
                    ->where('subject_id', $subject_id)
                    ->where('attendance_date', $attendance_date)
                    ->where('employee_id', $teacher_id)->first();
                if ($status == 4) {
                    $notifications = array(
                        'table_name' => 'attendances_teacher',
                        'table_id' => $ta->id,
                        'status' => 1,
                        'created_by' => Auth::user()->id,
                    );
                    DB::table('notifications')->insert($notifications);
                } else {
                    DB::table('notifications')
                        ->where('table_name', 'attendances_teacher')
                        ->where('table_id', $ta->id)->delete();
                }
            } else {
                $time = $request->$time;

                $status = $request->$attend;
                if ($request->$attend == 1) {
                    $atime = $request->$atime;
                    $minitrs = (strtotime($time) - strtotime($atime)) / 60;
                    if ($minitrs > 6) {
                        $status = 4;
                    }
                }
                $attendance['session_id'] = $session_id;
                $attendance['version_id'] = $version_id;
                $attendance['shift_id'] = $shift_id;
                $attendance['class_id'] = $class_id;
                $attendance['section_id'] = $section_id;
                $attendance['subject_id'] = $subject_id;
                $attendance['attendance_date'] = $attendance_date;
                $attendance['time'] = ($status == 1 || $status == 4) ? $time : null;
                $attendance['employee_id'] = $teacher_id;
                $attendance['status'] = $status;
                $attendance['active'] = 1;
                $attendance['created_by'] = Auth::user()->id;

                $id = TeacherAttendance::insertGetId($attendance);

                if ($status == 4) {
                    $notifications = array(
                        'table_name' => 'attendances_teacher',
                        'table_id' => $id,
                        'status' => 1,
                        'created_by' => Auth::user()->id,
                    );
                    DB::table('notifications')->insert($notifications);
                } else {
                    DB::table('notifications')
                        ->where('table_name', 'attendances_teacher')
                        ->where('table_id', $id)->delete();
                }
            }
        }
        if ($attendance) {
            $sms = "Successfully Inserted";
        }


        return redirect(route('allteacherAttendance'))->with('success', $sms);
        // } catch (Exception $e) {

        //     return redirect(route('teacherAttendance'))->with(['msg' => $e]);
        // }
    }
    public function staffAttendanceStore(Request $request)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        $session = Sessions::where('session_name', date('Y'))->first();
        $version_id = $request->version_id;
        $session_id = $session->id;
        if ($request->type == 'college') {
            $type = 3;
        } elseif ($request->type == 'secondary') {
            $type = 2;
        } else {
            $type = 1;
        }
        $attendance_date = $request->attendance_date;
        $shift_id = $request->shift_id;
        $section_id = $request->section_id;
        Session::put('attendance_date_s', $attendance_date);
        Session::put('type_s', $type);
        Session::put('shift_id_s', $shift_id);
        try {

            $teacher_id = $request->teacher_id;
            $attendance = [];
            foreach ($teacher_id as $key => $id) {
                $attend = 'attendance' . $id;
                $time = 'time' . $id;
                if (TeacherAttendance::where('attendance_date', $attendance_date)
                    ->where('shift_id', $shift_id)
                    ->where('session_id', $session_id)
                    ->where('attendance_date', $attendance_date)
                    ->where('employee_id', $id)->exists()
                ) {
                    TeacherAttendance::where('attendance_date', $attendance_date)
                        ->where('shift_id', $shift_id)
                        ->where('session_id', $session_id)
                        ->where('attendance_date', $attendance_date)
                        ->where('employee_id', $id)->update(['status' => $request->$attend, 'attendance_date' => $attendance_date, 'time' => ($request->$attend == 1) ? $request->$time : null, 'updated_by' => Auth::user()->id]);
                    $sms = "Successfully Updated";
                } else {
                    $attendance[$key]['session_id'] = $session_id;
                    $attendance[$key]['shift_id'] = $shift_id;
                    $attendance[$key]['attendance_date'] = $attendance_date;
                    $attendance[$key]['time'] = $time;
                    $attendance[$key]['employee_id'] = $id;
                    $attendance[$key]['status'] = $request->$attend;
                    $attendance[$key]['time'] = ($request->$attend == 1) ? $request->$time : null;
                    $attendance[$key]['active'] = 1;
                    $attendance[$key]['created_by'] = Auth::user()->id;
                }
            }
            if ($attendance) {
                $sms = "Successfully Inserted";
                TeacherAttendance::insert($attendance);
            }


            return redirect(route('staffAttendance'))->with('success', $sms);
        } catch (\Exception $e) {

            return redirect(route('staffAttendance'))->with(['msg' => $e]);
        }
    }

    public function studentAttendanceReport(Request $request)
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        Session::put('activemenu', 'report');
        Session::put('activesubmenu', 'satt');

        if ($request->all()) {
            Session::put('type', $request->type);
            Session::put('class_id', $request->class_id);
            Session::put('version_id', $request->version_id);
            Session::put('shift_id', $request->shift_id);
            Session::put('session_id', $request->session_id);
            Session::put('section_id', $request->section_id);
            Session::put('status', $request->status);
        }
        if (Session::get('type') == 1) {
            $type = 1;
            $type_name = 'primary';
        } elseif (Session::get('type') == 2) {
            $type = 2;
            $type_name = 'secondary';
        } else {
            $type = 3;
            $type_name = 'college';
        }
        $sections = [];
        if (Session::get('class_id') || Session::get('class_id') == 0) {
            $class_id = Session::get('class_id');
            $sections = Sections::where('active', 1)->where('class_code', Session::get('class_id'))->get();
        }
        $sessions = Sessions::get();
        $classess = Classes::where('active', 1)->where('class_for', $type)->where('version_id', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        return view('report.attendance.student', compact('sessions', 'type_name', 'type', 'classess', 'shifts', 'sections'));
    }
    public function teacherAttendanceReport()
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        Session::put('activemenu', 'report');
        Session::put('activesubmenu', 'tatt');
        if (Session::get('type_t') == 1) {
            $type = 1;
            $type_name = 'primary';
        } elseif (Session::get('type_t') == 2) {
            $type = 2;
            $type_name = 'secondary';
        } else {
            $type = 3;
            $type_name = 'college';
        }
        $sections = [];
        if (Session::get('class_id_t')) {
            $class_id = Session::get('class_id_t');
            $sections = Sections::where('active', 1)->where('class_id', $class_id)->get();
        }
        $sessions = Sessions::where('active', 1)->get();
        $classess = Classes::where('active', 1)->where('class_for', $type)->get();
        $shifts = Shifts::where('active', 1)->get();
        return view('report.attendance.teacher', compact('sessions', 'type_name', 'type', 'classess', 'shifts', 'sections'));
    }
    public function staffAttendanceReport()
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        Session::put('activemenu', 'report');
        Session::put('activesubmenu', 'statt');
        if (Session::get('type_s') == 1) {
            $type = 1;
            $type_name = 'primary';
        } elseif (Session::get('type_s') == 2) {
            $type = 2;
            $type_name = 'secondary';
        } else {
            $type = 3;
            $type_name = 'college';
        }
        $shifts = Shifts::where('active', 1)->get();

        return view('report.attendance.staff', compact('shifts', 'type_name', 'type'));
    }
    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function storeBulkStudent(Request $request)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        $jsonData = $request->all();
        $fileName = time() . 'response.txt';

        // Store the JSON string as a .txt file in the storage
        Storage::disk('local')->put($fileName, $jsonData);

        // Provide a download link or response
        return response()->download(storage_path("app/{$fileName}"));
    }
    public function storeBulkStudent1(Request $request)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        //PUSH_KEY="letmein#$@%RU@93366%@$#"
        $data = $request->all();

        if ($data['push_key'] == 'letmein#$@%RU@93366%@$#') {

            $session_id = Sessions::where('active', 1)->first()->pluck('id');
            $attandance = $data['data'];
            if ($attandance) {
                $finger_print_ids = Attendance::where('attendance_date', date('Y-m-d'))->get()->pluck('student_code')->toArray();

                $attandanceCollection = collect($attandance);
                $filteredAttendance = $attandanceCollection->reject(function ($item) use ($finger_print_ids) {
                    return in_array($item['finger_print_id'], $finger_print_ids);
                })->values()->all();
                $values = array();

                foreach ($filteredAttendance as $key => $student) {
                    $dateTime = new DateTime($student['log_time']);
                    // Get the date part
                    $date = $dateTime->format('Y-m-d'); // "2024-09-11"
                    // Get the time part
                    $time = $dateTime->format('H:i:s');
                    $values[$key] = [
                        'attendance_date' => $date,
                        'student_code' => $student['finger_print_id'],
                        'device_id' => $student['identifier'],
                        'time' => $time,
                        'status' => 1,
                        'active' => 1,
                        'created_by' => 1
                    ];
                }

                Attendance::insert($values);
            }
        }


        // Return a simple message confirming the operation
        return response()->json(['message' => 'Data stored successfully']);
    }
    public function storeBulkTeacher(Request $request)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        return $request->all();
    }

    public function studentAttendence()
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'sma');

        $versions = Versions::all();
        $groups = AcademySection::all();
        $sessions = Sessions::where('active', 1)->get();
        $classdata = array();
        if (Auth::user()->group_id == 3) {
            $employee = Employee::where('id', Auth::user()->ref_id)->first();
            // dd($employee);
            $session = Sessions::where('active', 1)->first();
            $session = Sessions::where('session_name', date('Y'))->first();

            $classdata = EmployeeActivity::leftJoin('classes', 'classes.class_code', '=', 'employee_activity.class_code')
                ->where('employee_id', $employee->id)
                ->where('is_class_teacher', 1)
                ->select(
                    'employee_activity.class_code',
                    'employee_activity.session_id'
                )
                ->with(['version', 'shift'])
                ->orderBy('employee_activity.class_code')

                ->DISTINCT('class_code')
                ->get();
            Session::put('class_code', $classdata[0]->class_code);
            Session::put('session_id', $classdata[0]->session_id);
        }


        return view('subject_marks.studentAttendence', compact('versions', 'sessions', 'groups', 'classdata'));
    }

    public function getStudentsExamAttendence(Request $request)
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        $students = Student::join('student_activity', 'student_activity.student_code', '=', 'students.student_code')
            ->select('students.id', 'students.first_name', 'students.student_code', 'student_activity.roll')
            ->where('student_activity.session_id', $request->session_id)
            ->where('student_activity.class_code', $request->class_code)
            ->where('student_activity.section_id', $request->section_id)
            ->orderBy('student_activity.roll', 'asc')
            ->get();

        $attendanceData = StudentAttendance::whereIn('student_code', $students->pluck('student_code'))
            ->where('exam_id', $request->exam_id)
            ->get()
            ->keyBy('student_code');

        $noOfWorkingDays = StudentAttendance::where('session_id', $request->session_id)->where('exam_id', $request->exam_id);
        if (isset($students[0]->student_code)) {

            $noOfWorkingDays = $noOfWorkingDays->where('student_code', $students[0]->student_code);
        }

        $noOfWorkingDays = $noOfWorkingDays->value('no_of_working_days');

        foreach ($students as $student) {
            $student->attendance = $attendanceData->get($student->student_code);
        }

        // dd($students);

        return response()->json([
            'students' => $students,
            'no_of_working_days' => $noOfWorkingDays,
        ]);
    }

    public function storeAttendance(Request $request)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }

        $request->validate([
            'session_id' => 'required|exists:sessions,id',
            'exam_id' => 'required',
            'no_of_working_days' => 'required|numeric',
            'students.*.total_attendance' => 'nullable|numeric',
        ]);

        $sessionId = $request->input('session_id');
        $exam_id = $request->input('exam_id');
        $noOfWorkingDays = $request->input('no_of_working_days');
        $attendanceData = $request->input('students', []);

        // Fetch all students to map `student_code` to `id`
        //$studentsMap = Student::pluck('id', 'student_code');

        foreach ($attendanceData as $studentCode => $data) {
            // Find the student's ID using their student_code


            $attendancedata = [
                'student_code' => $studentCode,
                'exam_id' => $exam_id,
                'session_id' => $sessionId,
                'no_of_working_days' => $noOfWorkingDays,
                'total_attendance' => $data['total_attendance'] ?? null,
                'created_by' => Auth::user()->id
            ];

            StudentAttendance::updateOrCreate(
                [
                    'student_code' => $studentCode,
                    'session_id' => $sessionId,
                    'exam_id' => $exam_id
                ],
                $attendancedata
            );
        }

        return redirect()->back()->with('success', 'Attendance saved successfully.');
    }


    // public function storeAttendance(Request $request)
    // {
    //     // dd($request->all());

    //     $request->validate([
    //         'session_id' => 'required|exists:sessions,id',
    //         'no_of_working_days' => 'required|numeric',
    //         'students.*.total_attendance' => 'nullable|numeric',
    //     ]);

    //     $sessionId = $request->input('session_id');
    //     $noOfWorkingDays = $request->input('no_of_working_days');
    //     $attendanceData = $request->input('students', []);

    //     foreach ($attendanceData as $studentCode => $data) {
    //         $attendancedata = array(
    //             'student_code' => $studentCode,
    //             'session_id' => $sessionId,
    //             'no_of_working_days' => $noOfWorkingDays,
    //             'total_attendance' => $data['total_attendance'] ?? null,
    //             'created_by' => Auth::user()->id
    //         );


    //         StudentAttendance::updateOrCreate(
    //             [
    //                 'student_code' => $studentCode,
    //                 'session_id' => $sessionId,
    //             ],
    //             $attendancedata
    //         );
    //     }


    //     return redirect()->back()->with('success', 'Attendance saved successfully.');
    // }


    public function showCertificateForm()
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 7) {
            return 1;
        }
        Session::put('activemenu', 'admission');
        Session::put('activesubmenu', 'tcf');
        return view('transferCertificateForm');
    }
    // public function showCertificateList(Request $request)
    // {
    //     //$session = Sessions::where('active', 1)->orderBy('id', 'desc')->first();
    //     $sessions = Sessions::get();
    //     $versions = Versions::where('active', 1)->get();
    //     $shifts = Shifts::where('active', 1)->get();
    //     $classes = Classes::where('active', 1)
    //         ->where('session_id', $request->session_id)
    //         ->where('shift_id', $request->shift_id)
    //         ->where('version_id', $request->version_id)
    //         ->get();
    //     $class_code = (int)$request->class_code;
    //     $sections = Sections::where('active', 1);
    //     if ($class_code) {
    //         $sections = $sections->where('class_code', $class_code);
    //     }

    //     // $sections = $sections->get();
    //     $version_id = (int)$request->version_id;
    //     $session_id = (int)$request->session_id;
    //     $shift_id = (int)$request->shift_id;

    //     $section_id = (int)$request->section_id;
    //     $text_search = $request->text_search;

    //     Session::put('activemenu', 'admission');
    //     Session::put('activesubmenu', 'scl');
    //     $students = Student::where('active', 0)
    //         ->with([
    //             'studentActivity.session',
    //             'studentActivity.version',
    //             'studentActivity.shift',
    //             'studentActivity.classes',
    //             'studentActivity.group',
    //             'studentActivity.section'
    //         ]);

    //     $students = $students->whereIn('student_code', function ($row) use ($session_id, $version_id, $shift_id, $class_code, $section_id) {

    //         $row->select('student_code')
    //             ->from('student_activity')
    //             ->where('active', 0);
    //         if ($session_id) {

    //             $row->whereRaw('session_id = "' . $session_id . '"');
    //         }
    //         if ($version_id) {
    //             $row->whereRaw('version_id = "' . $version_id . '"');
    //         }
    //         if ($shift_id) {
    //             $row->whereRaw('shift_id = "' . $shift_id . '"');
    //         }
    //         if ($class_code) {
    //             $row->whereRaw('class_code = "' . $class_code . '"');
    //         }
    //         if ($section_id) {
    //             $row->whereRaw('section_id = "' . $section_id . '"');
    //         }
    //     });

    //     if (!empty($text_search)) {
    //         $students = $students->whereRaw("first_name LIKE '%" . $text_search . "%' or student_code LIKE '%" . $text_search . "%' or mobile LIKE '%" . $text_search . "%' or email LIKE '%" . $text_search . "%'");
    //     }

    //     if ($request->has('search')) {
    //         $students = $students
    //             ->where('email', 'like', '%' . $request->input('search') . '%')
    //             ->orWhere('first_name', 'like', '%' . $request->input('search') . '%')
    //             ->orWhere('student_code', 'like', '%' . $request->input('search') . '%')
    //             ->orWhere('sms_notification', 'like', '%' . $request->input('search') . '%')
    //             ->orWhere('father_name', 'like', '%' . $request->input('search') . '%');
    //     }
    //     $students = $students->paginate(50);

    //     if ($request->ajax()) {
    //         return view('transferCertificatelistajax', compact('students'))->render();
    //     }

    //     return view('transferCertificatelist', compact('students', 'sessions', 'versions', 'shifts', 'classes', 'sections', 'session_id', 'version_id', 'shift_id', 'class_code', 'section_id', 'text_search'));
    //     // return view('transferCertificatelist',compact('students','session'));
    // }

    public function showCertificateList(Request $request)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 7) {
            return 1;
        }
        Session::put('activemenu', 'admission');
        Session::put('activesubmenu', 'scl');
        $sessions = Sessions::get();
        $versions = Versions::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $classes = Classes::where('active', 1)
            ->when($request->session_id, function ($query, $session_id) {
                return $query->where('session_id', $session_id);
            })
            ->when($request->shift_id, function ($query, $shift_id) {
                return $query->where('shift_id', $shift_id);
            })
            ->when($request->version_id, function ($query, $version_id) {
                return $query->where('version_id', $version_id);
            })
            ->get();

        $sections = Sections::where('active', 1)
            ->when($request->class_code, function ($query, $class_code) {
                return $query->where('class_code', $class_code);
            })
            ->when($request->version_id, function ($query, $version_id) {
                return $query->where('version_id', $version_id);
            })
            ->when($request->shift_id, function ($query, $shift_id) {
                return $query->where('shift_id', $shift_id);
            })
            ->get();

        // Initialize variables for filters
        $session_id = $request->session_id;
        $version_id = $request->version_id;
        $shift_id = $request->shift_id;
        $class_code = $request->class_code;
        $section_id = $request->section_id;
        $text_search = $request->text_search;
        $page_size = $request->get('page_size', 50); // Default to 50 if not provided

        $students = collect(); // Default empty collection

        if ($request->hasAny(['session_id', 'version_id', 'shift_id', 'class_code', 'section_id', 'text_search', 'search'])) {

            // Start building the student query
            $studentsQuery = Student::where('students.active', 0)
                ->join('student_activity', 'students.student_code', '=', 'student_activity.student_code')
                ->leftjoin('users', 'students.tc_generated_by', '=', 'users.id')
                ->select('students.*', 'student_activity.section_id', 'student_activity.roll', 'student_activity.class_code', 'student_activity.active', 'student_activity.session_id', 'student_activity.version_id', 'student_activity.shift_id', 'users.name as generated_by');

            // Apply filters step by step
            if ($section_id) {
                $studentsQuery->where('student_activity.section_id', $section_id);
            }

            if ($session_id) {
                $studentsQuery->where('student_activity.session_id', $session_id);
            }

            if ($version_id) {
                $studentsQuery->where('student_activity.version_id', $version_id);
            }

            if ($shift_id) {
                $studentsQuery->where('student_activity.shift_id', $shift_id);
            }

            if ($request->class_code == '0') {
                $studentsQuery->where('student_activity.class_code', 0);
            } elseif (!is_null($class_code)) {
                $studentsQuery->where('student_activity.class_code', $class_code);
            }

            // Apply text search filter
            if ($request->text_search) {
                $studentsQuery->where(function ($query) use ($request) {
                    $query->where('students.first_name', 'like', '%' . $request->text_search . '%')
                        ->orWhere('students.student_code', 'like', '%' . $request->text_search . '%')
                        ->orWhere('students.mobile', 'like', '%' . $request->text_search . '%')
                        ->orWhere('students.email', 'like', '%' . $request->text_search . '%');
                });
                $studentsQuery->where('student_activity.active', 0);
            }

            // Fetch and paginate the filtered data
            $students = $studentsQuery->orderBy('student_activity.roll', 'asc') // Order by roll
                ->paginate($page_size); // Use the dynamic page size
        }

        // dd($students);

        // if ($request->ajax()) {
        //     return view('transferCertificatelistajax', compact('students'))->render();
        // }

        return view('transferCertificatelist', compact('students', 'sessions', 'versions', 'shifts', 'classes', 'sections', 'session_id', 'version_id', 'shift_id', 'class_code', 'section_id', 'text_search'));
        // return view('transferCertificatelist',compact('students','session'));
    }

    public function generateTransferCertificate(Request $request)
    {
        if ((Auth::user()->group_id != 2 && Auth::user()->group_id != 7) || Auth::user()->is_view_user != 0) {
            return 1;
        }
        $request->validate([
            'student_code' => 'required|exists:students,student_code',
            'reason_for_tc' => 'required|string'
        ]);

        $student = Student::where('student_code', $request->student_code)->first();
        $studentActivity = StudentActivity::where('student_code', $student->student_code)
            ->where('active', 1)
            ->with(['section'])
            ->orderBy('id', 'desc')
            ->first();

        if (!$studentActivity) {
            return 'Student already took TC.';
        }

        DB::beginTransaction();
        try {
            DB::table('student_activity')->where('id', $studentActivity->id)->update([
                'active' => 0,
                'reason_for_tc' => $request->reason_for_tc
            ]);

            DB::table('students')->where('student_code', $studentActivity->student_code)->update([
                'active' => 0,
                'tc_generated_by' => Auth::id()
            ]);

            DB::table('users')->where('ref_id', $studentActivity->student_code)->update(['status' => 'inactive']);

            // Insert into tc_inactives table
            TcInactive::create([
                'student_code' => $student->student_code,
                'reason' => $request->reason_for_tc,
                'date' => Carbon::now()->format('Y-m-d'),
                'purpose' => 1, // 1 means TC
                'status' => 1,
                'generated_by' => Auth::id(),
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            DB::commit();

            $studentActivity = StudentActivity::where('student_code', $student->student_code)
                ->with(['section'])
                ->orderBy('id', 'desc')
                ->first();

            return view('transferCertificate', compact('student', 'studentActivity'))
                ->with('success', 'Transfer Certificate generated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to generate TC: ' . $e->getMessage()]);
        }
    }



    public function previewTransferCertificate(Request $request)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 7) {
            return 1;
        }
        $request->validate([
            'student_code' => 'required|exists:students,student_code',
        ]);

        $student = Student::where('student_code', $request->student_code)->with(['boardResult'])->first();

        $studentActivity = StudentActivity::where('student_code', $student->student_code)
            ->with(['section'])
            ->orderBy('id', 'desc')
            ->first();

        $selectedMonth = \Carbon\Carbon::createFromDate(null, $request->selected_month, 1)->format('F, Y');

        // dd($selectedMonth);

        // dd($studentActivity);
        // Load the HTML content from view
        return view('transferCertificate', compact('student', 'studentActivity', 'selectedMonth'));
    }
    // public function previewTransferCertificate(Request $request)
    // {
    //     $request->validate([
    //         'student_code' => 'required|exists:students,student_code',
    //     ]);

    //     $student = Student::where('student_code', $request->student_code)->first();

    //     $studentActivity = StudentActivity::where('student_code', $student->student_code)
    //         ->where('active', 1)
    //         ->with(['section'])
    //         ->orderBy('id', 'desc')
    //         ->first();

    //     if (!$studentActivity) {
    //         return response()->json(['error' => 'Student already take TC.'], 404);
    //     }

    //     // Load the HTML content from view
    //     $html = view('transferCertificate_new', compact('student', 'studentActivity'))->render();

    //     // Initialize mPDF and generate the PDF
    //     $mpdf = new Mpdf();
    //     $mpdf->WriteHTML($html);

    //     // Output the PDF inline in the browser for preview
    //     return $mpdf->Output('transfer_certificate.pdf', 'I'); // 'I' means inline display
    // }
    public function getTransferCertificate($student_code)
    {

        if (Auth::user()->group_id != 2) {
            return 1;
        }
        $student = Student::where('student_code', $student_code)->first();

        $studentActivity = StudentActivity::where('student_code', $student_code)
            ->with(['section'])
            ->orderBy('id', 'desc')
            ->first();

        // Load the HTML content from view
        $html = view('transferCertificate_new', compact('student', 'studentActivity'));

        // Initialize mPDF and generate the PDF
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

        // Output to browser for download
        return $mpdf->Output('transfer_certificate.pdf', 'I');
    }
    public function showTestimialForm()
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        Session::put('activemenu', 'admission');
        Session::put('activesubmenu', 'tml');
        return view('testimonialForm');
    }
    // public function previewTestimonial(Request $request)
    // {
    //     $testimonialType = $request->testimonial_type;
    //     $request->validate([
    //         'student_code' => 'required|exists:students,student_code',
    //     ]);

    //     $student = Student::where('student_code', $request->student_code)->with(['boardResult'])->first();

    //     $studentActivity = StudentActivity::where('student_code', $student->student_code)
    //         ->with(['section'])
    //         ->orderBy('id', 'desc')
    //         ->first();

    //     // dd($studentActivity);
    //     // Load the HTML content from view
    //     return view('testimonial/school/current', compact('student', 'studentActivity', 'testimonialType'));
    // }
    public function previewTestimonial(Request $request)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 7) {
            return 1;
        }
        $testimonialType = $request->testimonial_type;
        $request->validate([
            'student_code' => 'required|exists:students,student_code',
        ]);

        $student = Student::where('student_code', $request->student_code)->with(['boardResult'])->first();

        // dd($student);

        $studentActivity = StudentActivity::where('student_code', $student->student_code)
            ->with(['section'])
            ->orderBy('id', 'desc')
            ->first();

        $roll_number = $request->roll_number ?? $student->boardResult->roll_number ?? '';
        $registration_number = $request->registration_number ?? $student->boardResult->registration_number ?? '';
        $gpa = $request->gpa ?? $student->boardResult->gpa ?? '';
        $session = $request->session ?? $studentActivity->session->session_name ?? '';
        $class_number = $request->class_number ?? $studentActivity->class_code ?? '';
        $exam_year = $request->exam_year ?? $student->boardResult->exam_year ?? '';

        // Return testimonial type in JSON response along with HTML
        if ($studentActivity->class_code < 11) {
            if ($testimonialType == 'current') {
                return response()->json([
                    'html' => view('testimonial.school.current', compact('student', 'studentActivity', 'testimonialType'))->render(),
                    'testimonialType' => $testimonialType,
                    'class_number' => $class_number,
                ]);
            } elseif ($testimonialType == 'gazette') {
                return response()->json([
                    'html' => view('testimonial.school.gazette', compact('student', 'studentActivity', 'testimonialType', 'roll_number', 'registration_number', 'gpa', 'exam_year'))->render(),
                    'testimonialType' => $testimonialType,
                    'class_number' => $class_number,
                    'roll_number' => $roll_number,
                    'registration_number' => $registration_number,
                    'gpa' => $gpa,
                    'exam_year' => $exam_year,
                ]);
            } elseif ($testimonialType == 'cadet') {
                return response()->json([
                    'html' => view('testimonial.school.cadet', compact('student', 'studentActivity', 'testimonialType'))->render(),
                    'testimonialType' => $testimonialType,
                    'class_number' => $class_number,
                ]);
            } elseif ($testimonialType == 'appeared') {
                return response()->json([
                    'html' => view('testimonial.school.appeared', compact('student', 'studentActivity', 'testimonialType', 'roll_number', 'registration_number', 'exam_year'))->render(),
                    'testimonialType' => $testimonialType,
                    'class_number' => $class_number,
                    'roll_number' => $roll_number,
                    'registration_number' => $registration_number,
                    'exam_year' => $exam_year,
                ]);
            } elseif ($testimonialType == 'said') {
                return response()->json([
                    'html' => view('testimonial.school.said', compact('student', 'studentActivity', 'testimonialType', 'registration_number', 'session', 'gpa', 'exam_year'))->render(),
                    'testimonialType' => $testimonialType,
                    'class_number' => $class_number,
                    'registration_number' => $registration_number,
                    'session' => $session,
                    'gpa' => $gpa,
                    'exam_year' => $exam_year,
                ]);
            } elseif ($testimonialType == 'passed') {
                return response()->json([
                    'html' => view('testimonial.school.passed', compact('student', 'studentActivity', 'testimonialType', 'class_number', 'session'))->render(),
                    'testimonialType' => $testimonialType,
                    'class_number' => $class_number,
                    'session' => $session,
                ]);
            }
        } else {
            if ($testimonialType == 'current') {
                return response()->json([
                    'html' => view('testimonial.college.current', compact('student', 'studentActivity', 'testimonialType'))->render(),
                    'testimonialType' => $testimonialType,
                    'class_number' => $class_number,
                ]);
            } elseif ($testimonialType == 'gazette') {
                return response()->json([
                    'html' => view('testimonial.college.gazette', compact('student', 'studentActivity', 'testimonialType', 'roll_number', 'registration_number', 'gpa', 'exam_year'))->render(),
                    'testimonialType' => $testimonialType,
                    'roll_number' => $roll_number,
                    'registration_number' => $registration_number,
                    'gpa' => $gpa,
                    'exam_year' => $exam_year,
                ]);
            } elseif ($testimonialType == 'appeared') {
                return response()->json([
                    'html' => view('testimonial.college.appeared', compact('student', 'studentActivity', 'testimonialType', 'roll_number', 'registration_number', 'exam_year'))->render(),
                    'testimonialType' => $testimonialType,
                    'roll_number' => $roll_number,
                    'registration_number' => $registration_number,
                    'exam_year' => $exam_year,
                ]);
            } elseif ($testimonialType == 'said') {
                return response()->json([
                    'html' => view('testimonial.college.said', compact('student', 'studentActivity', 'testimonialType', 'registration_number', 'session', 'gpa', 'exam_year'))->render(),
                    'testimonialType' => $testimonialType,
                    'registration_number' => $registration_number,
                    'session' => $session,
                    'gpa' => $gpa,
                    'exam_year' => $exam_year,
                ]);
            } elseif ($testimonialType == 'passed') {
                return response()->json([
                    'html' => view('testimonial.college.passed', compact('student', 'studentActivity', 'testimonialType', 'class_number', 'session'))->render(),
                    'testimonialType' => $testimonialType,
                    'class_number' => $class_number,
                    'session' => $session,
                ]);
            }
        }
    }
}
