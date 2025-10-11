<?php

namespace App\Http\Controllers;

use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeActivity;
use App\Models\Exam\Exam;
use App\Models\sttings\AcademySection;
use App\Models\sttings\Sessions;
use App\Models\sttings\Classes;
use App\Models\sttings\Sections;
use App\Models\sttings\Shifts;
use App\Models\sttings\Subjects;
use App\Models\Student\Student;
use App\Models\sttings\Versions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'ex');
        $exams = Exam::with(['session', 'classdata'])->orderBy('id', 'desc')->get();
        return view('exams.index', compact('exams'));
    }
    public function admitcard()
    {
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'adc');
        $sessions = Sessions::all();
        $versions = Versions::all();
        $exams = Exam::with(['session', 'classdata'])->orderBy('id', 'desc')->get();
        $classes = Classes::orderByRaw("CAST(class_code AS UNSIGNED)")->pluck('class_name', 'class_code');
        $shifts = Shifts::where('active', 1)->get();
        return view('exams.admitcard', compact('exams', 'sessions', 'versions', 'classes', 'shifts'));
    }
    public function ajaxadmitcard(Request $request)
    {
        $session_id = $request->session_id;
        $class_code = $request->class_code;
        $exam = Exam::with(['session', 'classdata'])->where('id', $request->exam_id)->orderBy('id', 'desc')->first();
        $students = Student::join('student_activity', 'student_activity.student_code', '=', 'students.student_code')
            ->where('student_activity.session_id', $request->session_id)
            ->where('student_activity.active', 1)
            ->where('students.active', 1)
            ->where('student_activity.class_code', $request->class_code)
            ->where('student_activity.section_id', $request->section_id)
            ->with(['studentActivity.classes'])
            ->with(['subjects' => function ($query) use ($session_id, $class_code) {
                $query->where('session_id', $session_id)->where('class_wise_subject.class_code', $class_code);
            }]);
        if ($request->version_id) {
            $students = $students->where('student_activity.version_id', $request->version_id);
        }

        $students = $students->orderBy('student_activity.roll')->get();

        $students = collect($students)->unique('student_code');

        if ($class_code == 11 || $class_code == 12) {
            return view('exams.ajaxadmitcard11_12', compact('students', 'exam', 'class_code'));
        }
        return view('exams.ajaxadmitcard', compact('students', 'exam', 'class_code'));
    }
    public function attendanceSheet()
    {
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'as');
        $sessions = Sessions::all();
        $versions = Versions::all();
        $exams = Exam::with(['session', 'classdata'])->orderBy('id', 'desc')->get();
        return view('exams.attendanceSheet', compact('exams', 'sessions', 'versions'));
    }
    public function ajaxattendanceSheet(Request $request)
    {
        $session_id = $request->session_id;
        $class_code = $request->class_code;
        $exam = Exam::with(['session', 'classdata'])->where('id', $request->exam_id)->orderBy('id', 'desc')->first();
        $students = Student::join('student_activity', 'student_activity.student_code', '=', 'students.student_code')
            ->where('student_activity.session_id', $request->session_id)
            ->where('student_activity.class_code', $request->class_code)
            ->where('student_activity.section_id', $request->section_id)
            ->with(['studentActivity.classes'])
            ->with(['subjects' => function ($query) use ($session_id, $class_code) {
                $query->where('session_id', $session_id)->where('class_wise_subject.class_code', $class_code);
            }]);
        if ($request->version_id) {
            $students = $students->where('student_activity.version_id', $request->version_id);
        }

        $students = $students->orderBy('student_activity.roll')->get();

        $students = collect($students)->unique('student_code');

        return view('exams.ajaxattendanceSheet', compact('students', 'exam'));
    }
    public function getExam(Request $request)
    {
        $exams = Exam::with(['session', 'classdata'])->where('session_id', $request->session_id)->where('class_code', $request->class_code)->orderBy('id', 'desc')->get();

        return view('exams.ajaxexam', compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'ex');
        $sessions = Sessions::where('active', 1)->get();
        return view('exams.create', compact('sessions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Auth::user()->group_id!=2){
            return 1;
        }
        $request->validate([
            'session_id' => 'required',
            'class_code' => 'required',
            'exam_title' => 'required|string|max:256',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
        if ($request->id == 0) {
            $examdata = $request->except('_token', 'id');
            $examdata['created_by'] = Auth::user()->id;
            $text = 'Exam created successfully.';
            Exam::create($examdata);
        } else {
            $examdata = $request->except('_token', 'id');
            $examdata['updated_by'] = Auth::user()->id;
            $text = 'Exam update successfully.';
            Exam::where('id', $request->id)->update($examdata);
        }


        return redirect()->route('exams.index')->with('success', $text);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exam $exam)
    {
        if(Auth::user()->group_id!=2){
            return 1;
        }
        $sessions = Sessions::where('active', 1)->get();
        return view('exams.create', compact('exam', 'sessions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(Auth::user()->group_id!=2){
            return 1;
        }
        $request->validate([
            'session_id' => 'required',
            'class_code' => 'required',
            'exam_title' => 'required|string|max:256',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $exam->update($request->all());

        return redirect()->route('exams.index')->with('success', 'Exam updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exam $exam)
    {
        if(Auth::user()->group_id!=2){
            return 1;
        }
        $exam->delete();
        return redirect()->route('exams.index')->with('success', 'Exam deleted successfully.');
    }

    /**
     * Subject Wise Student Result
     */
    public function subjectWiseStudentResult()
    {
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'swsr');
        $session_id = null;
        $version_id = null;
        $shift_id = null;
        $class_code = null;
        $section_id = null;
        $subject_id = null;
        $employee = null;
        $versions = Versions::all();
        $groups = AcademySection::all();
        $sessions = Sessions::pluck('session_name', 'session_code');

        // $classes = Classes::where('active', 1)->get();
        $classes = DB::select("SELECT DISTINCT(class_code), class_name
                       FROM classes
                       WHERE active = 1
                       ORDER BY CAST(class_code AS UNSIGNED), class_name");




        $shifts = Shifts::where('active', 1)->get();
        $sections = Sections::get();
        if (Auth::user()->group_id == 3) {

            $employee = Employee::where('id', Auth::user()->ref_id)->first();

            $activity = EmployeeActivity::where('employee_id', $employee->id)
                ->where('is_class_teacher', 1)
                ->orderBy('employee_id', 'desc')
                ->first();

            if (empty($activity)) {
                return redirect()->back();
            }

            $classes = EmployeeActivity::leftJoin('classes', 'classes.class_code', '=', 'employee_activity.class_code')
                ->where([
                    ['employee_id', $employee->id],
                    ['is_class_teacher', 1]
                ])
                ->select('employee_activity.class_code', 'classes.class_name')
                ->with(['version', 'shift'])
                ->distinct()
                ->orderBy('employee_activity.class_code')
                ->get();

            $shift_id = $activity->shift_id;
            $class_code = $activity->class_code;
            $section_id = $activity->section_id;
            $version_id = $activity->version_id;
            $session_id  = $activity->session_id;

            if ($activity->class_code == 11 || $activity->class_code == 12) {
                $sessions = Sessions::where('id', $activity->session_id)->pluck('college_session', 'session_code');
            } else {
                $sessions = Sessions::where('id', $activity->session_id)->pluck('session_name', 'session_code');
            }
            // dd($classdata);
            // dd($sessions);
        }
        return view('exams.subjectWiseStudentResult', compact('versions', 'classes', 'shifts', 'sections', 'session_id', 'shift_id', 'class_code', 'section_id', 'version_id', 'sessions', 'groups', 'employee'));
    }

    public function getSubjectWiseStudentResult(Request $request)
    {
        // dd($request->all());
        $session_id = $request->session_id;
        $class_code = $request->class_code;
        $section_id = $request->section_id;
        $subject_id = $request->subject_id;
        $version_id = $request->version_id;
        $exam_id = $request->exam_id;
        $shift_id = $request->shift_id;
        $version_text = $request->version_text;
        $shift_text = $request->shift_text;
        $class_text = $request->class_text;
        $section_text = $request->section_text;
        $subject_text = $request->subject_text;
        $exam_text = $request->exam_text;

        $teacher = array();

        // Check if mandatory fields are provided
        if (!$session_id || !$class_code || !$subject_id || !$exam_id) {
            return response()->json(['error' => 'Session, Class, Subject, and Exam are mandatory fields.'], 400);
        }

        // Start the query
        $query = Student::join('student_activity', 'student_activity.student_code', '=', 'students.student_code')
            ->join('student_subject_wise_mark', 'student_subject_wise_mark.student_code', '=', 'students.student_code')
            ->where('student_subject_wise_mark.subject_id', $subject_id)
            ->where('student_subject_wise_mark.session_id', $session_id)
            ->where('student_subject_wise_mark.class_code', $class_code)
            ->where('student_subject_wise_mark.exam_id', $exam_id)
            ->select(
                'students.student_code',
                'students.first_name',
                'student_activity.roll',
                'student_subject_wise_mark.subject_id',
                'student_subject_wise_mark.cq_total',
                'student_subject_wise_mark.mcq_total',
                'student_subject_wise_mark.practical_total',
                'student_subject_wise_mark.is_absent',
                'student_subject_wise_mark.ct1',
                'student_subject_wise_mark.ct2',
                'student_subject_wise_mark.ct3',
                'student_subject_wise_mark.ct4',
                'student_subject_wise_mark.total',
                'student_subject_wise_mark.conv_total',
                'student_subject_wise_mark.ct',
                'student_subject_wise_mark.ct_conv_total',
                'student_subject_wise_mark.gpa',
                'student_subject_wise_mark.is_cq_abs',
                'student_subject_wise_mark.is_mcq_abs',
                'student_subject_wise_mark.is_prac_abs',
                'student_subject_wise_mark.is_ct_abs',
                'student_subject_wise_mark.is_quiz_abs'
            );

        // Add optional conditions if they exist
        if ($section_id) {
            $query->where('student_activity.section_id', $section_id);
            $teacher = Employee::join('employee_activity', 'employees.id', '=', 'employee_activity.employee_id')
                ->where('employee_activity.class_code', $class_code)
                ->where('employee_activity.section_id', $section_id)
                ->where('employee_activity.session_id', $session_id)
                ->where('employee_activity.version_id', $version_id)
                ->where('employee_activity.shift_id', $shift_id)
                ->where('employee_activity.is_class_teacher', 1)
                ->select('employees.employee_name')
                ->first();
        }

        if ($version_id) {
            $query->where('student_activity.version_id', $version_id);
        }

        if ($shift_id) {
            $query->where('student_activity.shift_id', $shift_id);
        }

        // Fetch the students
        $students = $query->orderBy('roll', 'asc')->get();

        // dd($students[0]);

        // Ensure uniqueness by student_code
        $students = $students->unique('student_code');

        // Returning the view with the data
        return view('exams.ajaxSubjectWiseStudentResult', compact('students', 'class_code', 'subject_id', 'exam_id', 'session_id', 'section_id', 'version_id', 'shift_id', 'version_text', 'shift_text', 'class_text', 'section_text', 'subject_text', 'exam_text', 'teacher'));
    }
}
