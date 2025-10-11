<?php

namespace App\Http\Controllers;

use App\Models\ReconcilationDate;
use App\Models\sttings\Classes;
use App\Models\sttings\Sections;
use App\Models\sttings\Sessions;
use App\Models\sttings\Shifts;
use App\Models\sttings\Versions;
use App\Models\Student\Student;
use Illuminate\Http\Request;
use App\Exports\AttendanceReExport;
use App\Models\SMS;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class ReconcilationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 10) {
            return 1;
        }
        Session::put('activemenu', 'reconcilation');
        Session::put('activesubmenu', 'reconcilation');

        $records = ReconcilationDate::orderBy('id', 'desc')->get();
        return view('reconcilation_dates.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 10 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        Session::put('activemenu', 'reconcilation');
        Session::put('activesubmenu', 'reconcilation');
        return view('reconcilation_dates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'start_date' => 'required|date',
    //         'end_date' => 'required|date',
    //         'submit_date' => 'required|date',
    //     ]);
    //     $lastRow = ReconcilationDate::latest('id')->first();

    //     // Update all rows except the last one
    //     ReconcilationDate::where('status', 1)
    //         ->where('id', '!=', optional($lastRow)->id)
    //         ->update(['status' => 0]); // Change this to your desired status

    //     if ($request->id == 0) {
    //         ReconcilationDate::create($request->except(['_token', 'id']));
    //     } else {

    //         $reconcilationDate = ReconcilationDate::where('id', $request->id)->first();

    //         $reconcilationDate->update($request->except(['_token', 'id']));
    //     }


    //     return redirect()->route('reconcilation.index')->with('success', 'Record added successfully.');
    // }

    function storeSms($sms_notification, $body, $student_code = null)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 10) {
            return 1;
        }
        $smscount = explode(',', $sms_notification);
        $sms = new SMS();
        $sms->session_id = Session::get('session_id');
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

    function sendSMSForRecon($sms_notification, $message)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 10) {
            return 1;
        }
        $mobile = $sms_notification ?? null;

        if ($mobile) {
            sms_send($mobile, $message);
            $this->storeSms($mobile, $message);
        }
        return 1;
    }

    public function store(Request $request)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 10) {
            return 1;
        }
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'submit_date' => 'required|date',
        ]);

        $lastRow = ReconcilationDate::latest('id')->first();

        // Update all rows except the last one
        ReconcilationDate::where('status', 1)
            ->where('id', '!=', optional($lastRow)->id)
            ->update(['status' => 0]);

        if ($request->id == 0) {
            ReconcilationDate::create($request->except(['_token', 'id']));
        } else {
            $reconcilationDate = ReconcilationDate::find($request->id);
            $reconcilationDate->update($request->except(['_token', 'id']));
        }

        // ✅ Get teacher list using query builder
        $teachers = DB::table('employee_activity as ea')
            ->join('employees as e', 'ea.employee_id', '=', 'e.id')
            ->select('e.employee_name', 'e.mobile', 'ea.class_code', 'ea.is_class_teacher', 'ea.session_id')
            ->where('ea.is_class_teacher', 1)
            ->where('ea.class_code', '!=', 12)
            ->where(function ($query) {
                $query->whereBetween('ea.class_code', [0, 10])->where('ea.session_id', 2025)
                    ->orWhere(function ($q) {
                        $q->where('ea.class_code', 11)->where('ea.session_id', 2024);
                    });
            })
            ->groupBy('e.employee_name', 'e.mobile', 'ea.class_code', 'ea.is_class_teacher', 'ea.session_id')
            ->orderBy('ea.class_code')
            ->get();

        Session::put('session_id', 2025);

        // dd($teachers);

        // ✅ Format submitted date
        $formattedDate = \Carbon\Carbon::parse($request->submit_date)->format('jS F');

        // ✅ Message with dynamic date
        $message = "Dear Teacher, Kindly complete the attendance adjustment for your section via the Attendance Reconciliation option in your portal within {$formattedDate}.";

        // $this->sendSMSForRecon("01706695915", $message);

        // ✅ Send message to each teacher
        foreach ($teachers as $teacher) {
            $mobile = $teacher->mobile;
            Session::put('session_id', $teacher->session_id);
            // Replace this with your actual SMS service
            $this->sendSMSForRecon($mobile, $message);
        }

        return redirect()->route('reconcilation.index')->with('success', 'Record added and SMS sent to class teachers.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ReconcilationDate $reconcilationDate)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 10) {
            return 1;
        }
        Session::put('activemenu', 'reconcilation');
        Session::put('activesubmenu', 'reconcilation-show');

        $reconcilationDate = ReconcilationDate::orderBy('id', 'desc')->where('status', 1)->first();
        $versions = Versions::where('active', 1)->get();

        $shifts = Shifts::where('active', 1)->get();

        $classes = Classes::orderByRaw("CAST(class_code AS UNSIGNED)")->pluck('class_name', 'class_code');

        return view('reconcilation_dates.report', compact('reconcilationDate', 'versions', 'shifts', 'classes'));
    }

    public function getSectionWiseStudentsReconcilation(Request $request)
    {
        // dd($request->all());
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 10) {
            return 1;
        }
        $session_id = date('Y');
        $section_id = $request->section_id;
        $class_code = $request->class_code;
        $version_id = $request->version_id;
        $shift_id = $request->shift_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $m = date('m');
        if ($class_code == 11 || $class_code == 12) {

            if ($m <= 6) {
                $session_id = date('Y') - 1;
            }
        }
        // Initialize query with base conditions
        $ext = '';
        $extco = '';
        $extc = '';
        if ($section_id) {
            $extco .= ' and sa.section_id=' . $section_id;
            $extc .= ' and section_id=' . $section_id;
        }
        if ($version_id) {
            $extco .= ' and sa.version_id=' . $version_id;
            $extc .= ' and version_id=' . $version_id;
        }
        if ($shift_id) {
            $extco .= ' and sa.shift_id=' . $shift_id;
            $extc .= ' and shift_id=' . $shift_id;
        }
        if ($class_code) {
            $extco .= ' and sa.class_code=' . $class_code;
            $extc .= ' and class_code=' . $class_code;
        }

        // dd($extc);

        $sql = "with stu as (select
                s.student_code
                ,s.first_name
                ,s.last_name
                ,father_name
                ,sms_notification
                ,sa.roll
                ,s.PID
                ,version_name
                ,shift_name
                ,section_name
                ,sa.class_code
                from students s
                join student_activity sa on sa.student_code =s.student_code
                join versions v on v.id =sa.version_id
                join shifts sh on sh.id =sa.shift_id
                join sections sc on sc.id =sa.section_id
                where s.active=1 and sa.active=1 " . $ext . $extco . " and session_id=" . $session_id . "
                ),
                absentcount as (
                    select student_code,count(id) absentcount from attendances a
                    where 1=1 " . $extc . "
                    and attendance_date between '" . $start_date . "' and '" . $end_date . "'
                    and status=2 group by student_code,status
                ),
                missingCount as (
                    select student_code,count(id) missingCount from attendances a
                    where 1=1 " . $extc . "
                    and attendance_date between '" . $start_date . "' and '" . $end_date . "'
                    and status=5 group by student_code,status
                )
                ,
                lateCount as (
                    select student_code,count(id) lateCount from attendances a
                    where 1=1 " . $extc . "
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
                join reconcilation on reconcilation.student_code=stu.student_code
                order by stu.roll";
        $students = DB::select($sql);
        if (empty($class_code)) {
            if ($m <= 6) {
                $session_id = date('Y') - 1;
            }
            $sql = "with stu as (select
                s.student_code
                ,s.first_name
                ,s.last_name
                ,father_name
                ,sms_notification
                ,sa.roll
                ,s.PID
                ,version_name
                ,shift_name
                ,section_name
                ,sa.class_code
                from students s
                join student_activity sa on sa.student_code =s.student_code
                join versions v on v.id =sa.version_id
                join shifts sh on sh.id =sa.shift_id
                join sections sc on sc.id =sa.section_id
                where s.active=1 and sa.active=1 " . $ext . $extco . " and session_id=" . $session_id . "
                ),
                absentcount as (
                    select student_code,count(id) absentcount from attendances a
                    where 1=1 " . $extc . "
                    and attendance_date between '" . $start_date . "' and '" . $end_date . "'
                    and status=2 group by student_code,status
                ),
                missingCount as (
                    select student_code,count(id) missingCount from attendances a
                    where 1=1 " . $extc . "
                    and attendance_date between '" . $start_date . "' and '" . $end_date . "'
                    and status=5 group by student_code,status
                )
                ,
                lateCount as (
                    select student_code,count(id) lateCount from attendances a
                    where 1=1 " . $extc . "
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
                join reconcilation on reconcilation.student_code=stu.student_code
                order by stu.roll";
            $student11_12 = DB::select($sql);
            if ($student11_12) {
                if ($students) {
                    $students = $students + $student11_12;
                } else {
                    $students = $student11_12;
                }
            }
        }
        return view(
            'reconcilation_dates.ajax_report',
            compact('students')
        );
    }

    public function getSectionWiseStudentsReconcilationxl(Request $request)
    {
        // dd($request->all());
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 10 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        $section_id = $request->section_id;
        $class_code = $request->class_code;
        $version_id = $request->version_id;
        $shift_id = $request->shift_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $section_name = Sections::where('id', $section_id)->pluck('section_name')->first() ?? '';

        return Excel::download(new AttendanceReExport($section_id, $class_code, $version_id, $shift_id, $start_date, $end_date), 'attendanceReconcilation_' . $section_name . '_' . date("Y-m-d") . '.xlsx');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 10 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        Session::put('activemenu', 'reconcilation');
        Session::put('activesubmenu', 'reconcilation');
        $reconcilationDate = ReconcilationDate::find($id);

        return view('reconcilation_dates.create', compact('reconcilationDate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReconcilationDate $reconcilationDate)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 10 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required|integer',
            'updated_by' => 'nullable|integer',
        ]);

        $reconcilationDate->update($request->all());

        return redirect()->route('reconcilation.index')->with('success', 'Record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReconcilationDate $reconcilationDate)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 10 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        $reconcilationDate->delete();
        return redirect()->route('reconcilation.index')->with('success', 'Record deleted successfully.');
    }
}
