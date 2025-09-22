<?php

namespace App\Http\Controllers;

use App\Models\Attendance\Attendance;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeActivity;
use App\Models\sttings\Classes;
use App\Models\sttings\Sections;
use App\Models\sttings\Sessions;
use App\Models\sttings\Shifts;
use App\Models\sttings\Versions;
use App\Models\Student\Student;
use App\Models\ReconcilationDate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AttendanceReconcilationController extends Controller
{
    public function index(Request $request)
    {
        Session::put('activemenu', 'attendance');
        Session::put('activesubmenu', 'atr');

        $activity = [];
        $sessions = [];
        $versions = [];
        $sections = [];
        $classes = [];
        $shifts = [];

        // Calculate allowed date range dynamically for the current month
        $reconcilationDate = ReconcilationDate::where('status', 1)->orderBy('id', 'desc')->first();
        $versions = Versions::where('active', 1)->get();

        $shifts = Shifts::where('active', 1)->get();
        $sections = Sections::where('active', 1)->get();
        $classes = Classes::orderByRaw("CAST(class_code AS UNSIGNED)")->pluck('class_name', 'class_code');

        if (Auth::user()->group_id == 3) {
            $employee = Employee::where('id', Auth::user()->ref_id)->first();
            $activity = EmployeeActivity::where('employee_id', $employee->id)
                ->where('is_class_teacher', 1)
                ->where('active', 1)
                ->orderBy('id', 'desc')
                ->first();
        }

        // dd($reconcilationDate);

        return view('attendance.reconcilation.index', compact(
            'reconcilationDate',
            'versions',
            'sessions',
            'shifts',
            'classes',
            'sections',
            'activity',
        ));
    }


    public function getStudentAttendances(Request $request)
    {

        $session_id = $request->session_id;
        $version_id = $request->version_id;
        $shift_id = $request->shift_id;
        $class_code = $request->class_code;
        $section_id = $request->section_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $student_code = $request->student_code;

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
        if ($student_code) {
            $conditions .= ' and student_activity.student_code=' . $student_code;
            $condition .= ' and attendances.student_code=' . $student_code;
        }

        if ($start_date && $end_date) {
            $condition .= " and attendances.attendance_date BETWEEN '$start_date' AND '$end_date'";
        }

        $query = Student::where('students.active', 1)
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
            ->orderBy('student_activity.roll', 'asc');

        $student = $query->first();
        $startDate = Carbon::parse($start_date);
        $endDate = Carbon::parse($end_date);
        $dateRange = collect();
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            if (!in_array($date->dayOfWeek, [Carbon::FRIDAY, Carbon::SATURDAY])) {
                $dateRange->push($date->toDateString());
            }
        }

        $filteredDateRange = collect();
        $counts = [
            'present' => 0,
            'absent' => 0,
            'late' => 0,
            'leave' => 0,
            'missing' => 0,
        ];
        $attendance = [];

        if ($student) {
            if (isset($student->studentAttendance)) {
                foreach ($dateRange as $date) {
                    // Fetch the attendance record for this date
                    $attendanceRecord = $student->studentAttendance
                        ->where('attendance_date', $date)
                        ->where('student_code', $student_code)
                        ->first();

                    $filterdRecord = $student->studentAttendance
                        ->where('attendance_date', $date)
                        ->where('student_code', $student_code)
                        ->whereIn('status', [2, 4])
                        ->first();

                    if ($filterdRecord) {
                        $attendance[$date] = $filterdRecord->status;
                        // Push only the dates with status 2 or 4
                        $filteredDateRange->push($filterdRecord->attendance_date);
                    }

                    if ($attendanceRecord) {
                        $attendance[$date] = $attendanceRecord->status;
                        switch ($attendanceRecord->status) {
                            case 1: // Present
                                $counts['present']++;
                                break;
                            case 2: // Absent
                                $counts['absent']++;
                                break;
                            case 3: // Leave
                                $counts['leave']++;
                                break;
                            case 4: // Late
                                $counts['late']++;
                                break;
                            default: // Missing or unknown status
                                $counts['missing']++;
                                break;
                        }
                    }
                }
            }
            return view('attendance.reconcilation.search', compact('student', 'filteredDateRange', 'attendance', 'counts'));
        } else {
            return response()->json(['message' => 'Student not found.'], 400);
        }
    }

    private function lasttime($class_code, $shift_id)
    {
        if ($class_code == 11 || $class_code == 12) {
            return 60;
        } else {
            return 60;
        }
    }


    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'session_id' => 'required|integer',
            'version_id' => 'required|integer',
            'shift_id' => 'required|integer',
            'class_code' => 'required|integer',
            'section_id' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'student_id' => 'required|integer',
            'attendance' => 'required|array',
        ]);

        // Extract necessary data
        $version_id = $request->version_id;
        $session_id = $request->session_id;
        $shift_id = $request->shift_id;
        $class_code = $request->class_code;
        $section_id = $request->section_id;
        $student_id = $request->student_id;
        $attendanceData = $request->attendance;
        // Get shift details
        $shift = Shifts::find($shift_id);
        if (!$shift) {
            return redirect()->back()->with('error', 'Invalid shift ID.');
        }

        // Initialize response message
        $message = "Attendance Successfully Processed";

        foreach ($attendanceData as $date => $status) {
            // Parse the date
            $attendance_date = Carbon::parse($date);
            // // Check if attendance record exists or create a new one
            $attendance = Attendance::firstOrNew([
                'attendance_date' => $attendance_date,
                'session_id' => $session_id,
                'version_id' => $version_id,
                'shift_id' => $shift_id,
                'class_code' => $class_code,
                'section_id' => $section_id,
                'student_code' => $student_id,
            ]);

            // Update or set attendance details
            $attendance->session_id = $session_id;
            $attendance->version_id = $version_id;
            $attendance->shift_id = $shift_id;
            $attendance->class_id = $class_code;
            $attendance->class_code = $class_code;
            $attendance->section_id = $section_id;
            $attendance->status = $status;
            $attendance->time = ($status == 1 || $status == 4) ? $attendance->time : "08:00:00"; // Update time only if necessary
            $attendance->created_by = Auth::user()->id;
            $attendance->updated_by = Auth::user()->id;
            $attendance->active = 1;
            // Save attendance record
            $attendance->save();
        }

        return redirect()->back()->with('success', $message);
    }


    public function getSectionWiseStudents(Request $request)
    {
        // dd($request->all());

        $reconcilationDate = ReconcilationDate::where('status', 1)->first();

        $session_id = $request->session_id;
        $version_id = $request->version_id;
        $shift_id = $request->shift_id;
        $class_code = $request->class_code;
        $section_id = $request->section_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $session_id = date('Y');

        if (!$request->start_date) {
            $start_date = $reconcilationDate->start_date;
        }
        if (!$request->end_date) {
            $end_date = $reconcilationDate->end_date;
        }
        if ($class_code == 11 || $class_code == 12) {
            $m = date('m');
            if ($m <= 6) {
                $session_id = date('Y') - 1;
            }
        }
        // Initialize query with base conditions
        $ext = '';
        // if ($class_code == 0) {
        //     $ext = 'and s.submit=2';
        // }
        $sql = "with stu as (select
                s.student_code
                ,s.first_name
                ,s.last_name
                ,father_name
                ,sms_notification
                ,sa.roll
                from students s
                join student_activity sa on sa.student_code =s.student_code
                where s.active=1 and sa.active=1 " . $ext . " and section_id=" . $section_id . " and session_id =" . $session_id . "
                ),
                absentcount as (
                    select student_code,count(id) absentcount from attendances a
                    where a.section_id=" . $section_id . "
                    and attendance_date between '" . $start_date . "' and '" . $end_date . "'
                    and status=2 group by student_code,status
                ),
                missingCount as (
                    select student_code,count(id) missingCount from attendances a
                    where a.section_id=" . $section_id . "
                    and attendance_date between '" . $start_date . "' and '" . $end_date . "'
                    and status=5 group by student_code,status
                )
                ,
                lateCount as (
                    select student_code,count(id) lateCount from attendances a
                    where a.section_id=" . $section_id . "
                    and attendance_date between '" . $start_date . "' and '" . $end_date . "'
                    and status=4 group by student_code
                ),
                reconcilation as (
                    select student_code,final_absent,final_late,final_missing from reconcilation_attendance ra
                    JOIN reconcilation_date rd ON rd.id=ra.reconcilation_date_id
                    where start_date='" . $start_date . "'
                )
                select stu.*,absentcount,missingCount,lateCount,final_absent,final_late,final_missing from stu
                left join absentcount on absentcount.student_code=stu.student_code
                left join missingCount on missingCount.student_code=stu.student_code
                left join lateCount on lateCount.student_code=stu.student_code
                left join reconcilation on reconcilation.student_code=stu.student_code
                order by stu.roll asc";

        $students = DB::select($sql);


        // Return view with students data
        return view(
            'attendance.reconcilation.sectionWiseStudent',
            compact('students')
        );
    }
    public function attendanceAdjustment(Request $request)
    {
        // dd($request->all());
        $reconcilationDate = ReconcilationDate::where('status', 1)->orderBy('id', 'desc')->first();
        $adjustment = DB::table('reconcilation_attendance')->where('student_code', $request->student_code)->where('reconcilation_date_id', $reconcilationDate->id)->first();
        if ($adjustment) {
            $current = 'current_' . $request->status;
            $final = 'final_' . $request->status;
            $addjustdata = array(
                $final => $request->value,
                $current => $request->current,
                'submit_date' => date('Y-m-d'),
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => Auth::user()->id,
            );
            DB::table('reconcilation_attendance')->where('id', $adjustment->id)->update($addjustdata);
        } else {
            $current = 'current_' . $request->status;
            $final = 'final_' . $request->status;
            $addjustdata = array(
                $final => $request->value,
                $current => $request->current,
                'submit_date' => date('Y-m-d'),
                'reconcilation_date_id' => $reconcilationDate->id,
                'student_code' => $request->student_code,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => Auth::user()->id,
            );
            DB::table('reconcilation_attendance')->insert($addjustdata);
        }
        return 1;
    }
}
