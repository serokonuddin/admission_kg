<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcademyActivity\AcademyActivityStoreRequest;
use App\Models\sttings\ClassWiseSubject;
use App\Models\sttings\Classes;
use App\Models\sttings\Subjects;
use App\Models\sttings\Teachers;
use App\Models\Employee\EmployeeActivity;
use App\Models\Employee\Employee;
use App\Models\sttings\Sessions;
use App\Models\sttings\Shifts;
use App\Models\sttings\Versions;
use App\Models\sttings\Sections;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Imports\RoutineImport;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ClassRoutineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        Session::put('activemenu', 'activity');
        Session::put('activesubmenu', 'rg');
        $shifts = Shifts::where('active', 1)->get();
        $versions = Versions::where('active', 1)->get();
        $classvalue = Classes::where('active', 1)->get();
        $sessiondata = Sessions::orderBy('created_at', 'desc')->get();
        $days = DB::table('days')->where('status', 1)->get();
        $sessions = Sessions::orderBy('created_at', 'desc')->get();

        return view('routine.index', compact('classvalue', 'days', 'shifts', 'versions', 'sessiondata', 'sessions'));
    }
    public function routineXlUpload(AcademyActivityStoreRequest $request)
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        $sms = "No File Found";

        if ($request->hasFile('file')) {
            $destinationPath = 'rutine';
            $myimage = $request->file->getClientOriginalName();
            $filePath = $request->file->storeAs($destinationPath, $myimage, 'public');
            $file = storage_path('app/public/' . $filePath);  // Correct path

            try {
                // Import the file using Excel
                Excel::import(new RoutineImport, $file);

                $sms = "Successfully Updated";
            } catch (\Exception $e) {
                session()->flash('error', $e->getMessage());
                return back()->withInput();
            }
        }

        return redirect(route('routine.index'))->with(['msg' => $sms]);
    }


    // public function getSubject(Request $request){
    //     $subjects=DB::table('subjects')
    //     ->select('subjects.*')
    //     ->join('class_wise_subject','class_wise_subject.subject_id','=','subjects.id')
    //     ->join('classes','classes.id','=','class_wise_subject.class_id')
    //     ->where('class_id',$request->class_id)
    //     ->where('version_id',$request->version_id)
    // 	->orderBy('subject_name','asc')
    //     ->get();
    //     return view('routine.ajaxsubject',compact('subjects'));
    // }

    public function getSubject(Request $request)
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        $subjects = DB::table('subjects')
            ->select('subjects.id', 'subject_name')
            ->join('class_wise_subject', 'class_wise_subject.subject_id', '=', 'subjects.id')
            ->where('class_code', $request->class_id)
            ->groupBy('id', 'subject_name')
            ->orderBy('subject_name', 'asc')
            ->get();

        return view('routine.ajaxsubject', compact('subjects'));
    }

    public function getSubjects(Request $request)
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        $subjects = DB::table('subjects')
            ->select('subjects.id', 'subject_name')
            ->join('class_wise_subject', 'class_wise_subject.subject_id', '=', 'subjects.id')
            ->where('class_code', $request->class_code)
            // ->whereNotIn('subjects.id', [124, 46])
            ->where('subject_name', '!=', 'TIFFIN')
            ->groupBy('id', 'subject_name')
            ->orderBy('subject_name', 'asc')
            ->get();
        return view('routine.ajaxsubject', compact('subjects'));
    }
    public function getOtherSubjects(Request $request)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3) {
            return 1;
        }

        $subjectIds = in_array($request->class_code, [9, 10])
            ? [124, 46]
            : [19, 28, 34, 129, 130];
        $subjects = DB::table('subjects')
            ->select('subjects.id', 'subject_name')
            ->join('class_wise_subject', 'class_wise_subject.subject_id', '=', 'subjects.id')
            ->where('class_code', $request->class_code)
            ->whereIn('subjects.id', $subjectIds)
            ->where('subject_name', '!=', 'TIFFIN')
            ->groupBy('id', 'subject_name')
            ->orderBy('subject_name', 'asc')
            ->get();
        return view('routine.ajaxsubject', compact('subjects'));
    }

    public function getTeachers(Request $request)
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        if ($request->type == 'college') {
            $class_for = 3;
        } elseif ($request->type == 'secondary') {
            $class_for = 2;
        } else {
            $class_for = 1;
        }
        $class = DB::table('classes')->where('id', $request->class_id)->first();

        // if($class->class_name=='KG' || $class->class_name=='I - One' || $class->class_name=='II - Two'){
        //     $teachers=DB::select("select employees.*,designation_name from employees
        //     join designations on designations.id=employees.designation_id
        //     where employee_for=".$class_for." and version_id=".$request->version_id." and shift_id=".$request->shift_id." order by employee_name asc
        //     ");
        // }else{

        // }
        $teachers = DB::select("select employees.*,designation_name from employees
        join designations on designations.id=employees.designation_id
        where category_id=7 order by employee_name asc
        ");


        return view('routine.ajaxteacher', compact('teachers'));
    }
    public function getTime(Request $request)
    {

        $type = $request->value;
        return view('routine.time', compact('type'));
    }
    public function getRoutine(Request $request)
    {

        $session_id = $request->session_id;
        $session = Sessions::where('active', 1)->orderBy('created_at', 'desc')->first();
        $sessions = Sessions::where('active', 1)->orderBy('created_at', 'desc')->get();
        $routine = EmployeeActivity::with(['employee', 'subject', 'classes', 'section'])
            ->where('section_id', $request->section_id)
            ->where('class_code', $request->class_id)
            ->where('session_id', $session_id)
            ->where('is_class_teacher', 1)
            ->where('shift_id', $request->shift_id)
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
        $routine = collect($routine)->sortBy('day_nr');
        $routine = collect($routine)->groupBy(['day_name', 'start_time']);
        // dd($routine);
        $routinetime = EmployeeActivity::select('start_time', 'end_time')
            ->where('section_id', $request->section_id)
            ->where('class_code', $request->class_id)
            ->where('session_id', $session_id)
            ->where('is_class_teacher', 1)
            ->where('shift_id', $request->shift_id)
            ->whereNotNull('day_name')->distinct('start_time')->orderBy('start_time')->get();


        return view('routine.ajaxRoutine', compact('routine', 'routinetime', 'sessions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        if ($request->type_for == 'college') {
            $type_for = 3;
        } else if ($request->type_for == 'secondary') {
            $type_for = 2;
        } else {
            $type_for = 1;
        }
        $routine = new EmployeeActivity();
        if ($request->id != 0) {
            $routine = EmployeeActivity::find($request->id);
        }

        $time = explode('-', $request->time);
        $date = strtotime($time[0]);
        $date1 = strtotime($time[1]);
        $stime = date('H:i:s', $date);
        $stime1 = date('H:i:s', $date1);

        $routine->employee_id = $request->employee_id;
        $routine->session_id = $request->session_id;
        $routine->version_id = $request->version_id;
        $routine->shift_id = $request->shift_id;
        $routine->class_id = $request->class_id;
        $routine->class_code = $request->class_id;
        $routine->section_id = $request->section_id;
        $routine->subject_id = $request->subject_id;
        $routine->day_name = $request->day_name;
        $routine->type_for = $type_for;
        $routine->start_time = $stime;
        $routine->end_time = $stime1;
        $routine->active = 1;
        $routine->is_class_teacher = $request->is_class_teacher ?? 0;
        $routine->is_main_teacher = $request->is_main_teacher ?? 0;
        $routine->created_by = Auth::user()->id;

        $routine->save();

        return redirect(route('routine.index'))->with('success', 'Successfully insert');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $routine = EmployeeActivity::with(['employee', 'session', 'version', 'shift', 'classes', 'section', 'subject'])->find($id);

        if ($routine) {
            // Create a human-readable time format like "08:15 AM-08:30 AM"
            $routine->time = date('h:i A', strtotime($routine->start_time)) . '-' . date('h:i A', strtotime($routine->end_time));
        }

        // dd($routine);

        Session::put('activemenu', 'activity');
        Session::put('activesubmenu', 'rg');

        $shifts = Shifts::where('active', 1)->get();
        $versions = Versions::where('active', 1)->get();
        $sessiondata = Sessions::orderBy('created_at', 'desc')->get();

        $subjects = DB::table('subjects')
            ->select('subjects.*')
            ->join('class_wise_subject', 'class_wise_subject.subject_id', '=', 'subjects.id')
            ->where('class_wise_subject.class_code', $routine->class_code)
            ->orderBy('subject_name', 'asc')
            ->get();

        $sections = Sections::where('active', 1)->where('class_code', $routine->class_code)->get();

        $teachers = DB::select("SELECT employees.*, designation_name
                            FROM employees
                            JOIN designations ON designations.id = employees.designation_id
                            WHERE category_id = 7 AND employees.active = 1
                            ORDER BY employee_name ASC");

        $days = DB::table('days')->where('status', 1)->get();

        return view('routine.edit', compact('routine', 'teachers', 'subjects', 'sections', 'days', 'shifts', 'versions', 'sessiondata'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        try {
            $EmployeeActivity = EmployeeActivity::find($id);
            $EmployeeActivity->delete();
            return 1;
        } catch (Exception $e) {
            return $e;
        }
    }
}
