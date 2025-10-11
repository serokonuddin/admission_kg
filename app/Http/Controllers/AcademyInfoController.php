<?php

namespace App\Http\Controllers;

use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeActivity;
use App\Models\Exam\Exam;
use App\Models\Exam\ExamHighestMark;
use App\Models\masterSttings\AcademyInfo;
use App\Models\sttings\Classes;
use App\Models\sttings\Sessions;
use App\Models\sttings\Subjects;
use App\Models\Student\Student;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AcademyInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Session::put('activemenu', 'setting');
        Session::put('activesubmenu', 'aci');
        $AcademyInfo=AcademyInfo::first();
        
        return view('setting.academic_info', compact('AcademyInfo'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AcademyInfo $academyInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcademyInfo $academyInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AcademyInfo $academyInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademyInfo $academyInfo)
    {
        //
    }

    public function getAcademicTranscript(Request $request)
    {
        $exam_id = $request->exam_id ?? null;
        $session_id = $request->session_id ?? null;
        $class_code = $request->class_code ?? null;
        $exam = Exam::find($exam_id);
        $pr_exam_id = 0;
        if ($exam->is_final == 1) {
            $pr_exam = Exam::where('id', '!=', $exam_id)->where('class_code', $class_code)->where('session_id', $session_id)->orderBy('id', 'desc')->first();
            $pr_exam_id = $pr_exam->id;
        }
        try {
            $student = Student::with(['studentExamAttendance' => function ($query) use ($session_id, $exam_id) {
                $query->where('session_id', $session_id)->where('exam_id', $exam_id);
            }])
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
                }, 'studentActivity'])
                ->where('student_code', Auth::user()->ref_id)
                ->first();
            // dd($student);
            $activity = $student->studentActivities ?? [];
            $group_id = $student->studentActivities->group_id ?? null;
            $version_id = $student->studentActivities->version_id ?? null;
            $section_id = $student->studentActivities->section_id ?? null;

            $exam = Exam::find($exam_id);
            if ($exam) {
                $exam_id = $exam->id;
                $pr_exam_id = 0;
                if ($exam->is_final == 1) {
                    $pr_exam = Exam::where('id', '!=', $exam_id)->where('class_code', $class_code)->where('session_id', $activity->session_id)->orderBy('id', 'desc')->first();
                    $pr_exam_id = $pr_exam->id;
                }
            }

            if (empty($activity)) {
                return response()->json(['error' => 'Student activity not found'], 404);
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

            $subjectscount = count($subjects);
            $grades = DB::table('grading')->get();
            $subjects = collect($subjects)->groupBy('id');

            $subjectHighestMark = ExamHighestMark::where('session_id', $session_id)->where('class_code', $class_code)->where('exam_id', $exam_id)->get();

            $subjectHighestMark_avg = ExamHighestMark::where('session_id', $session_id)->where('class_code', $class_code)->whereNull('exam_id')->get();

            $subjectHighestMark_pre = ExamHighestMark::where('session_id', $session_id)->where('class_code', $class_code)->where('exam_id', $pr_exam_id)->get();

            $subjectHighestMark = collect($subjectHighestMark)->groupBy('subject_id');
            $subjectHighestMark_avg = collect($subjectHighestMark_avg)->groupBy('subject_id');
            $subjectHighestMark_pre = collect($subjectHighestMark_pre)->groupBy('subject_id');

            if ($activity->class_code < 4) {

                return view('report.academic_transcript.ajaxindex_kg_three', compact('activity', 'student', 'classteacher', 'class_code', 'subjectHighestMark_avg', 'subjects', 'subjectHighestMark', 'subjectsmapping', 'subjectscount', 'exam', 'grades'));
            }
            if ($activity->class_code >= 11) {

                return view('report.academic_transcript.ajaxindex_11_12', compact('activity', 'student', 'classteacher', 'class_code', 'subjectHighestMark_avg', 'subjects', 'subjectHighestMark', 'subjectsmapping', 'subjectscount', 'exam', 'grades'));
            }
            if ($activity->class_code == 10) {

                return view('report.academic_transcript.ajaxindex_10', compact('activity', 'student', 'classteacher', 'class_code', 'subjectHighestMark_avg', 'subjects', 'subjectHighestMark', 'subjectsmapping', 'subjectscount', 'exam', 'grades'));
            }
            if ($activity->class_code < 11) {

                if ($exam->is_final == 1) {

                    return view('report.academic_transcript.ajaxindex_final', compact('activity', 'student', 'classteacher', 'class_code', 'subjects', 'subjectHighestMark', 'subjectHighestMark_avg', 'subjectHighestMark_pre', 'subjectsmapping', 'subjectscount', 'exam', 'grades'));
                }

                return view('report.academic_transcript.ajaxindex_down', compact('activity', 'subjects', 'student', 'classteacher', 'subjectHighestMark', 'subjectsmapping', 'subjectscount', 'exam', 'grades'));
            }

            return view('report.academic_transcript.ajaxindex', compact('activity', 'subjects', 'student', 'classteacher', 'subjectsmapping', 'subjectscount', 'exam', 'grades'));
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
