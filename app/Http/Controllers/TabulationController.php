<?php

namespace App\Http\Controllers;

use App\Exports\FailListExport;
use App\Exports\PassListExport;
use Illuminate\Http\Request;
use App\Models\SubjectMarkTerm;
use App\Models\SubjectMark;
use App\Models\Exam\Exam;
use App\Models\Exam\ExamHighestMark;
use App\Models\ExamTimeShedule;
use App\Models\sttings\Sessions;
use App\Models\sttings\Classes;
use App\Models\sttings\Shifts;
use App\Models\sttings\Sections;
use App\Models\sttings\AcademySection;
use App\Models\sttings\Subjects;
use App\Models\Student\Student;
use App\Models\sttings\Versions;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class TabulationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3 && Auth::user()->group_id != 7  && Auth::user()->group_id != 12) {
            return 1;
        }
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'at');
        $session_id = null;
        if (Auth::user()->group_id == 3) {

            $employee = Employee::where('id', Auth::user()->ref_id)->first();

            $activity = EmployeeActivity::where('employee_id', $employee->id)
                ->where('is_class_teacher', 1)
                ->latest('id')          // same as ->orderByDesc('id')
                ->first();              // gives the most-recent (last) record
            if (empty($activity)) {
                return redirect()->back();
            }
            $session_id = $activity->session_id;
        }
        $versions = Versions::all();
        $groups = AcademySection::all();
        $sessions = Sessions::all();
        // $sessions = Sessions::where('active', 1)->get();

        return view('tabulation.index', compact('versions', 'sessions', 'groups', 'session_id'));
    }
    public function academicTranscript()
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3 && Auth::user()->group_id != 7  && Auth::user()->group_id != 12) {
            return 1;
        }
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'eact');
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
        $classes = Classes::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $sections = Sections::get();
        if (Auth::user()->group_id == 3) {

            $employee = Employee::where('id', Auth::user()->ref_id)->first();

            $activity = EmployeeActivity::where('employee_id', $employee->id)
                ->where('is_class_teacher', 1)
                ->latest('id')          // same as ->orderByDesc('id')
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
        }

        return view('tabulation.indexteacher', compact('versions', 'classes', 'shifts', 'sections', 'session_id', 'shift_id', 'class_code', 'section_id', 'version_id', 'sessions', 'groups', 'employee'));
    }
    public function meritlistTeacher()
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3 && Auth::user()->group_id != 7  && Auth::user()->group_id != 12) {
            return 1;
        }
        // $versions = Versions::all();
        //$groups = AcademySection::all();
        $session = Sessions::where('active', 1)->first();

        $employee = Employee::where('id', Auth::user()->ref_id)->first();
        $activity = EmployeeActivity::where('employee_id', $employee->id)
            ->where('employee_activity.session_id', $session->id)
            ->where('is_class_teacher', 1)->first();
        if (empty($activity)) {
            return redirect()->back();
        }
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'ml');

        $versions = Versions::all();
        $groups = AcademySection::all();
        $sessions = Sessions::get();


        $employeeActivity = EmployeeActivity::join('classes', 'classes.class_code', '=', 'employee_activity.class_code')
            ->join('sections', 'sections.id', '=', 'employee_activity.section_id')
            ->where('employee_id', $employee->id)
            ->where('employee_activity.session_id', $session->id)
            ->where('employee_activity.is_class_teacher', 1)
            // ->where('employee_activity.shift_id', $employee->shift_id)
            ->where('employee_activity.section_id', $activity->section_id)
            ->select('employee_activity.class_id', 'class_for', 'class_name', 'section_name', 'employee_activity.section_id', 'employee_activity.shift_id', 'employee_activity.version_id')
            ->with(['version', 'shift'])
            ->orderBy('employee_activity.class_id')
            ->orderBy('employee_activity.section_id')
            ->groupBy('employee_activity.shift_id')
            ->groupBy('employee_activity.version_id')
            ->groupBy('employee_activity.class_id')
            ->groupBy('employee_activity.section_id')
            ->groupBy('class_for')
            ->groupBy('class_name')
            ->groupBy('section_name')
            ->first();


        $classdata = Classes::where('class_code', $activity->class_code);
        $shift_id = $activity->shift_id;
        $class_code = $activity->class_code;
        $section_id = $activity->section_id;
        $version_id = $activity->version_id;
        $session_id  = $session->id;

        return view('tabulation.teacher_merit', compact('versions', 'session_id', 'shift_id', 'class_code', 'section_id', 'version_id', 'sessions', 'groups', 'employee'));
    }
    public function passlistTeacher()
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3 && Auth::user()->group_id != 7  && Auth::user()->group_id != 12) {
            return 1;
        }
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'pl');
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
        $classes = Classes::where('active', 1)->get();
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
        }

        return view('tabulation.indexteacherpass', compact('versions', 'classes', 'shifts', 'sections', 'session_id', 'shift_id', 'class_code', 'section_id', 'version_id', 'sessions', 'groups', 'employee'));
    }
    public function faillistTeacher()
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3 && Auth::user()->group_id != 7  && Auth::user()->group_id != 12) {
            return 1;
        }
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'fl');
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
        $classes = Classes::where('active', 1)->get();
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
        }

        return view('tabulation.indexteacherfail', compact('versions', 'classes', 'shifts', 'sections', 'session_id', 'shift_id', 'class_code', 'section_id', 'version_id', 'sessions', 'groups', 'employee'));
    }
    public function tabulationSectionTeacher()
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3 && Auth::user()->group_id != 7  && Auth::user()->group_id != 12) {
            return 1;
        }
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'ets');

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
        $classes = Classes::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $sections = Sections::get();
        if (Auth::user()->group_id == 3) {

            $employee = Employee::where('id', Auth::user()->ref_id)->first();

            $activity = EmployeeActivity::where('employee_id', $employee->id)
                ->where('is_class_teacher', 1)
                ->latest('id')          // same as ->orderByDesc('id')
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
        }

        return view('tabulation.indexteachertabulation', compact('versions', 'classes', 'shifts', 'sections', 'session_id', 'shift_id', 'class_code', 'section_id', 'version_id', 'sessions', 'groups', 'employee'));
    }
    public function tabulationSection()
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3 && Auth::user()->group_id != 7  && Auth::user()->group_id != 12) {
            return 1;
        }
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'tb');

        $session_id = null;
        if (Auth::user()->group_id == 3) {

            $employee = Employee::where('id', Auth::user()->ref_id)->first();

            $activity = EmployeeActivity::where('employee_id', $employee->id)
                ->where('is_class_teacher', 1)
                ->latest('id')          // same as ->orderByDesc('id')
                ->first();              // gives the most-recent (last) record
            if (empty($activity)) {
                return redirect()->back();
            }
            $session_id = $activity->session_id;
        }

        $versions = Versions::all();
        $groups = AcademySection::all();
        $sessions = Sessions::get();

        return view('tabulation.tabulationSection', compact('versions', 'sessions', 'groups', 'session_id'));
    }
    public function pass_list()
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3 && Auth::user()->group_id != 7  && Auth::user()->group_id != 12) {
            return 1;
        }
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'pl');
        $versions = Versions::all();
        $groups = AcademySection::all();
        $sessions = Sessions::get();

        return view('tabulation.index_pass', compact('versions', 'sessions', 'groups'));
    }
    public function fail_list()
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3 && Auth::user()->group_id != 7  && Auth::user()->group_id != 12) {
            return 1;
        }
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'fl');

        $versions = Versions::all();
        $groups = AcademySection::all();
        $sessions = Sessions::get();

        return view('tabulation.index_fail', compact('versions', 'sessions', 'groups'));
    }
    public function getTabulation(Request $request)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3 && Auth::user()->group_id != 7  && Auth::user()->group_id != 12) {
            return 1;
        }
        $session_id = $request->session_id;
        $class_code = $request->class_code;
        $section_id = $request->section_id;
        $exam_id = $request->exam_id;
        $version_id = $request->version_id;
        $group_id = $request->group_id;
        $exam = Exam::find($exam_id);
        $pr_exam_id = 0;
        if ($exam->is_final == 1) {
            $pr_exam = Exam::where('id', '!=', $exam_id)->where('class_code', $class_code)->where('session_id', $session_id)->orderBy('id', 'desc')->first();
            $pr_exam_id = $pr_exam->id;
        }

        $classteacher = DB::table('employee_activity')
            ->join('employees', 'employees.id', '=', 'employee_activity.employee_id')
            ->join('designations', 'designations.id', '=', 'employees.designation_id')
            ->where('employee_activity.session_id', $session_id)
            ->where('employee_activity.class_code', $class_code)
            ->where('employee_activity.section_id', $section_id)
            ->where('is_class_teacher', 1)
            ->first();
        $subjectsmapping = Subjects::join('subject_mark_terms', 'subject_mark_terms.subject_id', '=', 'subjects.id')
            ->whereNotIn('subjects.id', [124, 46])
            ->where('session_id', $session_id)->where('class_code', $class_code)
            ->orderBy('serial', 'asc')
            ->orderBy('marks_for', 'asc')
            ->pluck('marks_for')->unique()->toArray();

        // $subjects = DB::table('exam_time_shedules')
        //     ->select('subjects.*')
        //     ->join('subjects', 'subjects.id', '=', 'exam_time_shedules.subject_id')
        //     ->where('exam_for', 1)
        //     ->whereNotIn('subjects.id', [124, 46])
        //     ->where('class_code', $class_code)
        //     ->where('session_id', $session_id)
        //     ->where('exam_id', $exam_id)
        //     ->orderBy('serial', 'asc')
        //     ->get();



        $term_marks = SubjectMarkTerm::where('session_id', $session_id)
            ->where('class_code', $class_code)
            ->orderBy('subject_id', 'asc')->orderBy('marks_for', 'asc')->get();
        $term_marks = collect($term_marks)->groupBy(['subject_id', 'marks_for']);

        $subjects = DB::table('exam_time_shedules')
            ->select('subjects.*')
            ->join('subjects', 'subjects.id', '=', 'exam_time_shedules.subject_id')
            ->where('exam_for', 1)
            ->whereNotIn('subjects.id', [124, 46])
            ->where('class_code', $class_code)
            ->where('session_id', $session_id)
            ->where('exam_id', $exam_id)
            ->when(
                in_array($class_code, [0, 1, 2]) && $version_id == 1,
                function ($query) {
                    $query->whereNotIn('subjects.id', [38, 39, 104]);
                }
            )
            ->when(
                in_array($class_code, [6, 7, 8]),
                function ($query) {
                    $query->whereNotIn('subjects.id', [19, 28, 34]);
                }
            )
            ->orderBy('serial', 'asc')
            ->get();


        // dd($subjects);

        $subjectscount = count($subjects);
        $grades = DB::table('grading')->get();

        // $subjects=DB::table('subjects')
        //     ->select('subject_name','id')->get();
        $subjects = collect($subjects)->groupBy('id');

        $subjectHighestMark = ExamHighestMark::where('session_id', $session_id)->where('class_code', $class_code)->where('exam_id', $exam_id)->get();

        $subjectHighestMark_avg = ExamHighestMark::where('session_id', $session_id)->where('class_code', $class_code)->where('version_id', $version_id)->where('exam_id', $exam_id)->get();

        $subjectHighestMark_pre = ExamHighestMark::where('session_id', $session_id)->where('class_code', $class_code)->where('exam_id', $pr_exam_id)->get();

        $subjectHighestMark = collect($subjectHighestMark)->groupBy('subject_id');
        $subjectHighestMark_avg = collect($subjectHighestMark_avg)->groupBy('subject_id');
        $subjectHighestMark_pre = collect($subjectHighestMark_pre)->groupBy('subject_id');

        $subjectIds = in_array($request->class_code, [9, 10])
            ? [124, 46]
            : [19, 28, 34, 129, 130];

        // dd($subjectHighestMark_avg);

        //if(count($subjectMarks)==0){
        $students = Student::join('student_activity', 'student_activity.student_code', '=', 'students.student_code')
            ->where('student_activity.session_id', $request->session_id)
            ->where('student_activity.class_code', $request->class_code)
            ->where('student_activity.section_id', $request->section_id)
            ->where('student_activity.active', 1)
            ->where('students.active', 1)
            ->with(['studentExamAttendance' => function ($query) use ($session_id, $exam_id) {
                $query->where('session_id', $session_id)->where('exam_id', $exam_id);
            }])
            ->with(['subjectwisemark' => function ($query) use ($session_id, $exam_id, $subjectIds) {
                $query->where('session_id', $session_id)->where('exam_id', $exam_id)->whereNotIn('subject_id', $subjectIds);
            }])
            ->with(['subjectwisemarkother' => function ($query) use ($session_id, $exam_id, $subjectIds) {
                $query->where('session_id', $session_id)->where('exam_id', $exam_id)->whereIn('subject_id', $subjectIds);
            }])
            ->with(['totalmark' => function ($query) use ($session_id, $exam_id) {
                $query->where('session_id', $session_id)->where('exam_id', $exam_id);
            }])
            ->with(['totalmark_half' => function ($query) use ($session_id, $pr_exam_id) {
                $query->where('session_id', $session_id)->where('exam_id', $pr_exam_id);
            }])
            ->with(['halfExam' => function ($query) use ($session_id, $pr_exam_id, $subjectIds) {
                $query->where('session_id', $session_id)->where('exam_id', $pr_exam_id)->whereNotIn('subject_id', $subjectIds);
            }])
            ->with(['avaragemark' => function ($query) use ($session_id, $exam_id, $subjectIds) {
                $query->where('session_id', $session_id)->where('exam_id', $exam_id)->whereNotIn('subject_id', $subjectIds);
            }, 'studentActivity']);
        if ($request->version_id) {
            $students = $students->where('student_activity.version_id', $request->version_id);
        }
        if ($request->group_id) {
            $students = $students->where('student_activity.group_id', $request->group_id);
        }
        $students = $students
            ->orderBy('student_activity.roll')

            ->get();

        $students = collect($students)->unique('student_code');

        $marks = collect($students[0]->subjectwisemark)->groupBy('subject_id');
        // dd($marks);

        //}
        if ($class_code < 3) {

            // dd($subjects);
            return view('tabulation.ajaxindex_kg_three', compact('students', 'classteacher', 'class_code', 'subjectHighestMark_avg', 'subjects', 'subjectHighestMark', 'subjectsmapping', 'students', 'subjectscount', 'exam', 'grades', 'term_marks'));
        }
        if ($class_code < 6) {

            // dd($students[0]->subjectwisemark[0]->total);
            return view('tabulation.ajaxindex_three_five', compact('students', 'classteacher', 'class_code', 'subjectHighestMark_avg', 'subjects', 'subjectHighestMark', 'subjectsmapping', 'students', 'subjectscount', 'exam', 'grades', 'term_marks'));
        }
        // if ($class_code == 6) {
        //     // dd($students[0]->subjectwisemarkother);
        //     return view('tabulation.ajaxindex_six_eight', compact('students', 'classteacher', 'class_code', 'subjectHighestMark_avg', 'subjects', 'subjectHighestMark', 'subjectsmapping', 'students', 'subjectscount', 'exam', 'grades'));
        //     // return view('tabulation.ajaxindex_nine', compact('students', 'classteacher', 'class_code', 'subjectHighestMark_avg', 'subjects', 'subjectHighestMark', 'subjectsmapping', 'students', 'subjectscount', 'exam', 'grades'));
        // }
        if ($class_code == 7 || $class_code == 8 || $class_code == 6) {
            // dd($students[0]->subjectwisemarkother);
            return view('tabulation.ajaxindex_seven_eight', compact('students', 'term_marks', 'classteacher', 'class_code', 'subjectHighestMark_avg', 'subjects', 'subjectHighestMark', 'subjectsmapping', 'students', 'subjectscount', 'exam', 'grades', 'term_marks'));
        }
        if ($class_code >= 11) {


            return view('tabulation.ajaxindex_11_12', compact('students', 'term_marks', 'classteacher', 'class_code', 'subjectHighestMark_avg', 'subjects', 'subjectHighestMark', 'subjectsmapping', 'students', 'subjectscount', 'exam', 'grades', 'term_marks'));
        }
        if ($class_code == 9) {


            // dd($students[0]->subjectwisemark->others);
            return view('tabulation.ajaxindex_nine', compact('students', 'term_marks', 'classteacher', 'class_code', 'subjectHighestMark_avg', 'subjects', 'subjectHighestMark', 'subjectsmapping', 'students', 'subjectscount', 'exam', 'grades', 'term_marks'));
        }
        if ($class_code == 10) {
            // dd($term_marks->firstWhere('id', 1));
            // $matches = $term_marks->flatten(3)
            //     ->where('subject_id', 62)
            //     ->where('marks_for', 2)
            //     ->first()?->pass_mark;

            // dd($matches);

            return view('tabulation.ajaxindex_10', compact('students', 'classteacher', 'class_code', 'subjectHighestMark_avg', 'subjects', 'subjectHighestMark', 'subjectsmapping', 'students', 'subjectscount', 'exam', 'grades', 'term_marks', 'term_marks'));
        }
        if ($class_code < 11) {

            if ($exam->is_final == 1) {

                return view('tabulation.ajaxindex_final', compact('students', 'classteacher', 'class_code', 'subjects', 'subjectHighestMark', 'subjectHighestMark_avg', 'subjectHighestMark_pre', 'subjectsmapping', 'students', 'subjectscount', 'exam', 'grades', 'term_marks'));
            }

            return view('tabulation.ajaxindex_down', compact('subjects', 'classteacher', 'subjectHighestMark', 'subjectsmapping', 'students', 'subjectscount', 'exam', 'grades', 'term_marks'));
        }

        return view('tabulation.ajaxindex', compact('subjects', 'classteacher', 'subjectsmapping', 'students', 'subjectscount', 'exam', 'grades', 'term_marks'));
    }
    public function getTabulationSection(Request $request)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3 && Auth::user()->group_id != 7  && Auth::user()->group_id != 12) {
            return 1;
        }
        $session_id = $request->session_id;
        $class_code = $request->class_code;
        $section_id = $request->section_id;
        $exam_id = $request->exam_id;
        $version_id = $request->version_id;
        $group_id = $request->group_id;
        $exam = Exam::find($exam_id);
        $sectiondata = Sections::find($section_id);
        $pr_exam_id = 0;
        if ($exam->is_final == 1) {
            $pr_exam = Exam::where('id', '!=', $exam_id)->where('class_code', $class_code)->where('session_id', $session_id)->orderBy('id', 'desc')->first();
            $pr_exam_id = $pr_exam->id;
        }

        $classteacher = EmployeeActivity::join('employees', 'employees.id', '=', 'employee_activity.employee_id')
            ->join('designations', 'designations.id', '=', 'employees.designation_id')
            ->with(['version', 'shift', 'session', 'classes', 'section'])
            ->where('employee_activity.session_id', $session_id)
            ->where('employee_activity.class_code', $class_code)
            ->where('employee_activity.section_id', $section_id)
            ->where('is_class_teacher', 1)
            ->first();

        $subjectsmapping = Subjects::join('subject_mark_terms', 'subject_mark_terms.subject_id', '=', 'subjects.id')
            ->whereNotIn('subjects.id', [124, 46])
            ->where('session_id', $session_id)->where('class_code', $class_code)
            ->orderBy('serial', 'asc')
            ->orderBy('marks_for', 'asc')
            ->pluck('marks_for')->unique()->toArray();

        $subjects = DB::table('exam_time_shedules')
            ->select('subjects.*')
            ->join('subjects', 'subjects.id', '=', 'exam_time_shedules.subject_id')
            ->where('exam_for', 1)
            ->whereNotIn('subjects.id', [124, 46])
            ->where('class_code', $class_code)
            ->where('session_id', $session_id)
            ->where('exam_id', $exam_id)
            ->orderBy('serial', 'asc')
            ->get();

        $term_marks = SubjectMarkTerm::where('session_id', $session_id)
            ->where('class_code', $class_code)
            ->orderBy('subject_id', 'asc')->orderBy('marks_for', 'asc')->get();
        $term_marks = collect($term_marks)->groupBy(['subject_id', 'marks_for']);

        $subjectscount = count($subjects);
        $grades = DB::table('grading')->get();
        // $subjects=DB::table('subjects')
        //     ->select('subject_name','id')->get();
        $subjects = collect($subjects)->groupBy('id');

        $subjectHighestMark = ExamHighestMark::where('session_id', $session_id)->where('class_code', $class_code)->where('exam_id', $exam_id)->get();

        $subjectHighestMark_avg = ExamHighestMark::where('session_id', $session_id)->where('class_code', $class_code)->whereNull('exam_id')->get();

        $subjectHighestMark_pre = ExamHighestMark::where('session_id', $session_id)->where('class_code', $class_code)->where('exam_id', $pr_exam_id)->get();

        $subjectHighestMark = collect($subjectHighestMark)->groupBy('subject_id');
        $subjectHighestMark_avg = collect($subjectHighestMark_avg)->groupBy('subject_id');
        $subjectHighestMark_pre = collect($subjectHighestMark_pre)->groupBy('subject_id');

        $totalsubject = "SELECT
        subject_name,
        session_id,
        group_id,
        class_code,
        exam_id,
        subject_id,
        non_value
    FROM
        student_avarage_mark
    join subjects on subjects.id=student_avarage_mark.subject_id
    WHERE
        session_id = " . $request->session_id . "
        AND class_code = " . $request->class_code . "
        AND exam_id = " . $request->exam_id;
        if ($sectiondata->group_id) {
            $totalsubject .= " AND group_id = " . $sectiondata->group_id;
        }
        $totalsubject .= "
        AND section_id = " . $section_id . "
        AND non_value = 0
        group by session_id,
        group_id,
        class_code,
        exam_id,
        subject_id,subject_name,non_value";
        $subjects = DB::select($totalsubject);
        $subjectsdata = collect($subjects)->groupBy('subject_id');

        //if(count($subjectMarks)==0){
        $students = Student::join('student_activity', 'student_activity.student_code', '=', 'students.student_code')
            ->where('student_activity.session_id', $request->session_id)
            ->where('student_activity.class_code', $request->class_code)
            ->where('student_activity.section_id', $request->section_id)
            ->where('student_activity.active', 1)
            ->where('students.active', 1)
            ->with(['subjectwisemark' => function ($query) use ($session_id, $exam_id) {
                $query->where('session_id', $session_id)->where('exam_id', $exam_id)->whereNotIn('subject_id', [124, 46]);
            }])
            ->with(['subjectwisemarkother' => function ($query) use ($session_id, $exam_id) {
                $query->where('session_id', $session_id)->where('exam_id', $exam_id)->whereIn('subject_id', [124, 46]);
            }])
            ->with(['totalmark' => function ($query) use ($session_id, $exam_id) {
                $query->where('session_id', $session_id)->where('exam_id', $exam_id);
            }])
            ->with(['totalmark_half' => function ($query) use ($session_id, $pr_exam_id) {
                $query->where('session_id', $session_id)->where('exam_id', $pr_exam_id);
            }])
            ->with(['halfExam' => function ($query) use ($session_id, $pr_exam_id) {
                $query->where('session_id', $session_id)->where('exam_id', $pr_exam_id)->whereNotIn('subject_id', [124, 46]);
            }])
            ->with(['avaragemark' => function ($query) use ($session_id, $exam_id) {
                $query->where('session_id', $session_id)->where('exam_id', $exam_id)->whereNotIn('subject_id', [124, 46]);
            }, 'studentActivity']);
        if ($request->version_id) {
            $students = $students->where('student_activity.version_id', $request->version_id);
        }
        if ($request->group_id) {
            $students = $students->where('student_activity.group_id', $request->group_id);
        }
        $students = $students
            ->orderBy('student_activity.roll')

            ->get();

        $students = collect($students)->unique('student_code');
        //}
        if ($class_code < 3) {

            // dd($subjects);
            // dd($students[0]);
            return view('tabulation.tabulation_kg_2', compact('students', 'classteacher', 'class_code', 'subjectHighestMark_avg', 'subjects', 'subjectHighestMark', 'subjectsmapping', 'students', 'subjectscount', 'exam', 'grades'));
        }
        if ($class_code < 6) {

            // dd($subjects);
            // dd($students[0]);
            return view('tabulation.tabulation_3_5', compact('students', 'classteacher', 'class_code', 'subjectHighestMark_avg', 'subjects', 'subjectHighestMark', 'subjectsmapping', 'students', 'subjectscount', 'exam', 'grades'));
        }
        if ($class_code < 9) {
            // dd($students[0]->subjectwisemark);
            return view('tabulation.tabulation_6_8', compact('students', 'classteacher', 'class_code', 'subjectHighestMark_avg', 'subjects', 'subjectHighestMark', 'subjectsmapping', 'students', 'subjectscount', 'exam', 'grades', 'term_marks'));
        }
        if ($class_code == 9) {
            // dd($students[0]->subjectwisemark);
            return view('tabulation.tabulation_9', compact('students', 'classteacher', 'class_code', 'subjectHighestMark_avg', 'subjects', 'subjectHighestMark', 'subjectsmapping', 'students', 'subjectscount', 'exam', 'grades', 'term_marks'));
        }
        if ($class_code >= 11) {

            // dd($students[0]->totalmark);
            return view('tabulation.tabulation_11_12', compact('students', 'classteacher', 'class_code', 'subjectHighestMark_avg', 'subjects', 'subjectHighestMark', 'subjectsmapping', 'students', 'subjectscount', 'exam', 'grades'));

            // return view('tabulation.ajaxindex_11_12', compact('students', 'classteacher', 'class_code', 'subjectHighestMark_avg', 'subjects', 'subjectHighestMark', 'subjectsmapping', 'students', 'subjectscount', 'exam', 'grades'));
        }
        if ($class_code == 10) {
            // dd($students[0]->subjectwisemark);
            return view('tabulation.tabulation_10', compact('students', 'classteacher', 'class_code', 'subjectHighestMark_avg', 'subjects', 'subjectHighestMark', 'subjectsmapping', 'students', 'subjectscount', 'exam', 'grades', 'term_marks'));
            // return view('tabulation.tabulationSectionsheet', compact('students', 'subjectsdata', 'classteacher', 'class_code', 'subjectHighestMark_avg', 'subjects', 'subjectHighestMark', 'subjectsmapping', 'students', 'subjectscount', 'exam', 'grades'));
        }
        if ($class_code < 11) {

            if ($exam->is_final == 1) {

                return view('tabulation.ajaxindex_final', compact('students', 'classteacher', 'class_code', 'subjects', 'subjectHighestMark', 'subjectHighestMark_avg', 'subjectHighestMark_pre', 'subjectsmapping', 'students', 'subjectscount', 'exam', 'grades'));
            }

            return view('tabulation.ajaxindex_down', compact('subjects', 'classteacher', 'subjectHighestMark', 'subjectsmapping', 'students', 'subjectscount', 'exam', 'grades'));
        }

        return view('tabulation.ajaxindex', compact('subjects', 'classteacher', 'subjectsmapping', 'students', 'subjectscount', 'exam', 'grades'));
    }
    public function getPassList(Request $request)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3 && Auth::user()->group_id != 7  && Auth::user()->group_id != 12) {
            return 1;
        }
        $session_id = $request->session_id;
        $class_code = $request->class_code;
        $section_id = $request->section_id;
        $exam_id = $request->exam_id;
        $version_id = $request->version_id;
        $group_id = $request->group_id;
        $exam = Exam::find($exam_id);
        $pr_exam_id = 0;

        $grades = DB::table('grading')->get();

        //if(count($subjectMarks)==0){
        $students = Student::join('student_activity', 'student_activity.student_code', '=', 'students.student_code')
            ->join('sections', 'sections.id', '=', 'student_activity.section_id')
            ->join('student_total_mark', 'student_total_mark.student_code', '=', 'students.student_code')
            ->where('student_activity.session_id', $request->session_id)
            ->where('student_activity.class_code', $request->class_code);
        if ($request->section_id) {
            $students = $students->where('student_activity.section_id', $request->section_id)->where('student_total_mark.section_id', $request->section_id);
        }
        if ($request->version_id) {
            $students = $students->where('student_activity.version_id', $request->version_id)->where('student_total_mark.version_id', $request->version_id);
        }
        if ($request->group_id) {
            $students = $students->where('student_activity.group_id', $request->group_id);
        }
        $students = $students->where('student_total_mark.session_id', $request->session_id);
        $students = $students->where('student_total_mark.class_code', $request->class_code)

            ->where('student_total_mark.position_in_section', '>', 0)
            ->with(['subjectwisemark' => function ($query) use ($session_id, $exam_id) {
                $query->where('session_id', $session_id)->where('exam_id', $exam_id)->whereNotIn('subject_id', [124, 46]);
            }])
            ->orderBy('student_activity.roll', 'asc')
            ->get();

        $createdBy = Auth::user()->name;
        return view('tabulation.ajaxindexpass', compact('students', 'exam', 'grades', 'createdBy'));
    }
    public function getFailList(Request $request)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3 && Auth::user()->group_id != 7  && Auth::user()->group_id != 12) {
            return 1;
        }
        $session_id = $request->session_id;
        $class_code = $request->class_code;
        $section_id = $request->section_id;
        $exam_id = $request->exam_id;
        $version_id = $request->version_id;
        $group_id = $request->group_id;
        $exam = Exam::find($exam_id);
        $pr_exam_id = 0;

        $grades = DB::table('grading')->get();

        //if(count($subjectMarks)==0){
        $students = Student::join('student_activity', 'student_activity.student_code', '=', 'students.student_code')
            ->join('sections', 'sections.id', '=', 'student_activity.section_id')
            ->join('student_total_mark', 'student_total_mark.student_code', '=', 'students.student_code')
            ->where('student_activity.session_id', $request->session_id)
            ->where('student_activity.class_code', $request->class_code);
        if ($request->section_id) {
            $students = $students->where('student_activity.section_id', $request->section_id)->where('student_total_mark.section_id', $request->section_id);
        }
        if ($request->version_id) {
            $students = $students->where('student_activity.version_id', $request->version_id)->where('student_total_mark.version_id', $request->version_id);
        }
        if ($request->group_id) {
            $students = $students->where('student_activity.group_id', $request->group_id);
        }
        $students = $students->where('student_total_mark.session_id', $request->session_id);
        $students = $students->where('student_total_mark.class_code', $request->class_code)

            ->whereRaw('ifnull(student_total_mark.position_in_section,0)=0')
            ->whereRaw('ifnull(student_total_mark.position_in_class,0)=0')
            ->with('studentActivity')
            ->with(['subjectwisemark' => function ($query) use ($session_id, $exam_id) {
                $query->where('session_id', $session_id)
                    ->where('exam_id', $exam_id)
                    ->whereRaw('ifnull(gpa_point,0)=0')
                    ->whereNotIn('subject_id', [124, 46]);
            }])
            ->where('students.active', 1)
            ->where('student_activity.active', 1)
            ->orderBy('student_activity.roll', 'asc')
            ->get();

        $createdBy = Auth::user()->name;
        return view('tabulation.ajaxindexfail', compact('students', 'exam', 'grades', 'createdBy'));
    }


    public function merit_list()
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3 && Auth::user()->group_id != 7  && Auth::user()->group_id != 12) {
            return 1;
        }
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'ml');

        $versions = Versions::all();
        $groups = AcademySection::all();
        $sessions = Sessions::get();
        $shifts = Shifts::all();

        return view('tabulation.index_merit', compact('versions', 'sessions', 'groups', 'shifts'));
    }

    public function getMeritList(Request $request)
    {
        // dd($request->all());
        // Fetch input parameters
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3 && Auth::user()->group_id != 7  && Auth::user()->group_id != 12) {
            return 1;
        }
        $session_id = $request->session_id;
        $class_code = $request->class_code;
        $section_id = $request->section_id;
        $exam_id = $request->exam_id;
        $version_id = $request->version_id;
        $shift_id = $request->shift_id;
        $group_id = $request->group_id;

        // Retrieve exam details
        $exam = Exam::find($exam_id);
        $grades = DB::table('grading')->get();

        // dd($grades);
        $sectiondata = array();
        $versiondata = array();
        $shiftdata = array();
        if ($section_id) {
            $sectiondata = Sections::find($section_id);
        }
        if ($version_id) {
            $versiondata = Versions::find($version_id);
        }
        if ($shift_id) {
            $shiftdata = Shifts::find($shift_id);
        }
        // Build the student query with necessary joins
        $students = Student::join('student_activity', 'student_activity.student_code', '=', 'students.student_code')
            ->join('sections', 'sections.id', '=', 'student_activity.section_id')
            ->leftJoin('student_attendance', 'student_attendance.student_code', '=', 'student_activity.student_code')
            ->join('student_total_mark', 'student_total_mark.student_code', '=', 'students.student_code') // Join for student_total_mark
            ->leftJoin('sections as nsections', 'nsections.id', '=', 'student_total_mark.next_section')
            ->where('student_activity.session_id', $session_id)
            ->where('student_activity.class_code', $class_code);

        $class_name = '';
        $shift_name = '';
        $version_name = '';
        $session_name = '';
        $exam_name = '';
        // Filter based on section, version, and group
        if ($section_id) {
            $students = $students->where('student_activity.section_id', $section_id);
        }

        if ($version_id) {
            $students = $students->where('student_activity.version_id', $version_id);
            $version_name = Versions::where('id', $version_id)->first()->version_name;
        }
        if ($shift_id) {
            $students = $students->where('student_activity.shift_id', $shift_id);
            $shift_name = Shifts::where('id', $shift_id)->first()->shift_name;
        }

        if ($group_id) {
            $students = $students->where('student_activity.group_id', $group_id);
        }

        if ($class_code) {
            $students = $students->where('student_activity.class_code', $class_code);
            $class_name = Classes::where('class_code', $class_code)->first()->class_name;
        }

        if ($session_id) {
            $students = $students->where('student_activity.session_id', $session_id);
            $session_name = Sessions::where('id', $session_id)->first()->session_name;
        }




        // Apply additional filters and sorting
        $students = $students->where('student_total_mark.position_in_section', '>', 0)
            ->where('student_total_mark.position_in_class', '>', 0)  // Ensure student has a class position

            ->select(
                'students.student_code',
                'students.first_name',
                'student_activity.roll',
                'student_total_mark.position_in_section',
                'student_total_mark.position_in_class',
                'student_total_mark.next_roll',
                'sections.section_name',
                'nsections.section_name as next_section',
                'student_total_mark.total_mark',
                'student_total_mark.grade_point',
                'student_attendance.no_of_working_days',
                'student_attendance.total_attendance'

            )
            ->with(['subjectwisemark' => function ($query) use ($session_id, $exam_id) {
                $query->where('session_id', $session_id)->where('exam_id', $exam_id)->whereNotIn('subject_id', [124, 46]);
            }]);
        if ($section_id) {
            $students = $students->orderBy('student_activity.roll', 'asc'); // Sort by class position for merit
            $students = $students->orderBy('student_total_mark.position_in_class', 'asc'); // Sort by class position for merit
            $students = $students->orderBy('student_total_mark.position_in_section', 'asc'); // Sort by class position for merit
        } else {
            $students = $students->orderBy('student_total_mark.position_in_class', 'asc'); // Sort by class position for merit
            $students = $students->orderBy('student_total_mark.position_in_section', 'asc'); // Sort by class position for merit
        }
        $students = $students->get();
        $students = collect($students)->unique('student_code');
        $createdBy = Auth::user()->name;
        // dd($students);
        return view('tabulation.ajaxindexmerit', compact('students', 'sectiondata', 'versiondata', 'class_code', 'shiftdata', 'exam', 'grades', 'class_name', 'shift_name', 'version_name', 'session_name', 'exam_name', 'createdBy'));
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
    public function getGradeByMark($grades, $mark)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3 && Auth::user()->group_id != 7  && Auth::user()->group_id != 12) {
            return 1;
        }
        foreach ($grades as $grade) {
            if ($mark >= $grade->start_mark && $mark <= $grade->end_mark) {
                return $grade;
            }
        }
        return null;
    }
    public function store(Request $request)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3 && Auth::user()->group_id != 7  && Auth::user()->group_id != 12) {
            return 1;
        }
        $request->validate([
            'session_id' => 'required|integer',
            'class_code' => 'required|integer',
            'exam_id' => 'required|integer',
            'subject_id' => 'required|integer',
            'section_id' => 'required|integer',

        ]);
        $grading = DB::table('grading')->get()->toArray();

        $text = 'Something is wrong.';
        foreach ($request->student_code as $key => $student_code) {
            foreach ($request->marks_for as $key1 => $marks_for) {
                $attributes = [
                    'session_id' => $request->session_id,
                    'class_code' => $request->class_code,
                    'exam_id' => $request->exam_id,
                    'subject_id' => $request->subject_id,
                    'section_id' => $request->section_id,
                    'student_code' => $student_code,
                    'marks_for' => $marks_for
                ];
                $obtained = 'obtained' . $student_code . $marks_for;
                $grace = 'grace' . $student_code . $marks_for;
                $obtainedvalue = $request->$obtained;
                $gracevalue = $request->$grace;
                $totalmark = (int)$obtainedvalue + (int)$gracevalue;
                $is_absent = 1;
                if ($obtainedvalue == 'A') {
                    $is_absent = 2;
                    $obtainedvalue = null;
                }
                $values = [
                    'session_id' => $request->session_id,
                    'class_code' => $request->class_code,
                    'exam_id' => $request->exam_id,
                    'subject_id' => $request->subject_id,
                    'section_id' => $request->section_id,
                    'student_code' => $student_code,
                    'version_id' => $request->version_id[$key],
                    'group_id' => $request->group_id[$key],
                    'marks_for' => $marks_for,
                    'obtained_mark' => $obtainedvalue,
                    'grace_mark' => $gracevalue,
                    'total_mark' => $totalmark,
                    'status' => $is_absent,
                    'created_by' => auth()->user()->id,
                    'updated_by' => auth()->user()->id,
                ];

                SubjectMark::updateOrCreate($attributes, $values);
            }
            $text = 'Subject Mark Added successfully.';
        }


        return redirect()->route('subject_marks.index')->with('success', $text);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function exportFailReport(Request $request)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3 && Auth::user()->group_id != 7  && Auth::user()->group_id != 12) {
            return 1;
        }
        return Excel::download(new FailListExport($request->all()), 'fail_list_export_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }
    public function exportPassReport(Request $request)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3 && Auth::user()->group_id != 7  && Auth::user()->group_id != 12) {
            return 1;
        }
        return Excel::download(new PassListExport($request->all()), 'pass_list_export_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }
    public function setFourthSubjectAddMark($session_id, $class_code, $exam_id)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3 && Auth::user()->group_id != 7  && Auth::user()->group_id != 12) {
            return 1;
        }
        // $data=DB::table('student_subject_wise_mark')
        // ->join('student_subject','student_subject.student_code','=','student_subject_wise_mark.student_code')
        // ->where('student_subject_wise_mark.session_id',$session_id)
        // ->where('student_subject_wise_mark.class_code',$class_code)
        // ->where('student_subject_wise_mark.exam_id',$exam_id)
        // ->whereIn('student_subject.is_fourth_subject',[1,2])->get();
        //->whereIn('student_subject.subject_id',[86,84,85,87,79,88,89,80,68,70]) third
        // $data=DB::table('student_subject')
        // ->where('student_subject.session_id',$session_id)
        // ->where('student_subject.class_code',$class_code)
        // ->whereIn('student_subject.is_fourth_subject',[1])
        // ->whereIn('student_subject.subject_id',[71,70,68,79,80,91,73,82])
        // ->get();
        // foreach($data as $student){
        //     $subjectdata=array('is_fourth_subject'=>1);
        //     $mark=DB::table('student_subject_wise_mark')->where('student_subject_wise_mark.session_id',$session_id)
        //      ->where('student_subject_wise_mark.class_code',$class_code)
        //      ->where('student_subject_wise_mark.exam_id',$exam_id)
        //      ->where('student_code',$student->student_code)
        //      ->where('subject_id',$student->subject_id)
        //      ->update($subjectdata);
        // }



        $data = DB::table('student_subject')
            ->where('session_id', $session_id)
            ->where('class_code', $class_code)
            ->whereIn('is_fourth_subject', [2])
            ->whereIn('subject_id', [86, 84, 85, 87, 79, 88, 89, 80, 68, 70])
            ->get();



        // Extract student_code and subject_id for batch update
        $studentSubjects = $data->map(function ($student) {
            return ['student_code' => $student->student_code, 'subject_id' => $student->subject_id];
        })->toArray();

        // Perform a batch update
        if (!empty($studentSubjects)) {
            DB::table('student_subject_wise_mark')
                ->where('session_id', $session_id)
                ->where('class_code', $class_code)
                ->where('exam_id', $exam_id)
                ->where(function ($query) use ($studentSubjects) {
                    foreach ($studentSubjects as $student) {
                        $query->orWhere(function ($q) use ($student) {
                            $q->where('student_code', $student['student_code'])
                                ->where('subject_id', $student['subject_id']);
                        });
                    }
                })
                ->update(['is_fourth_subject' => 2]);
        }
    }
}
