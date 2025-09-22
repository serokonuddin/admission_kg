<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeasonPlan;
use App\Models\Employee\Employee;
use App\Models\Student\Student;
use App\Models\Student\StudentSubjects;
use App\Models\Student\StudentActivity;
use App\Models\sttings\Classes;
use App\Models\sttings\Versions;
use App\Models\sttings\Subjects;
use App\Models\sttings\ClassWiseSubject;
use App\Models\sttings\Sections;
use App\Models\sttings\Sessions;
use App\Models\sttings\Shifts;
use App\Models\sttings\Teachers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LeasonPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Session::put('activemenu', 'activity');
        Session::put('activesubmenu', 'lp');
        $session_id = $request->session_id;
        $version_id = $request->version_id;
        $shift_id = $request->shift_id;
        $class_code = $request->class_code;
        $section_id = $request->section_id;
        $subject_id = $request->subject_id;
        $employee_id = $request->employee_id;

        $leasonplans = LeasonPlan::with(['session', 'version', 'classes', 'employee', 'subject']);
        if ($session_id) {
            $leasonplans = $leasonplans->where('session_id', $session_id);
        }
        if ($version_id) {
            $leasonplans = $leasonplans->where('version_id', $version_id);
        }
        if ($shift_id) {
            $leasonplans = $leasonplans->where('shift_id', $shift_id);
        }
        if ($class_code) {
            $leasonplans = $leasonplans->where('class_code', $class_code);
        }
        if ($section_id) {
            $leasonplans = $leasonplans->where('section_id', $section_id);
        }
        if ($subject_id) {
            $leasonplans = $leasonplans->where('subject_id', $subject_id);
        }
        if ($employee_id) {
            $leasonplans = $leasonplans->where('teacher_id', $employee_id);
        }
        $leasonplans = $leasonplans->get();
        $versions = Versions::where('active', 1)->get();
        $sessions = Sessions::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $classes = Classes::orderByRaw("CAST(class_code AS UNSIGNED)")->pluck('class_name', 'class_code');
        $employees = Employee::where('active', 1)->with('designation')->where('category_id', 7)->get();
        return view('lessonplan.index', compact('employee_id', 'classes', 'subject_id', 'class_code', 'session_id', 'version_id', 'leasonplans', 'employees', 'versions', 'sessions', 'shifts'));
    }
    // public function lessonPlanStudent()
    // {
    //     Session::put('activemenu', 'academic');
    //     Session::put('activesubmenu', 'lessonplan');
    //     $student_code = Auth::user()->ref_id;
    //     $activity = StudentActivity::where('student_code', $student_code)->orderBy('id', 'desc')->first();
    //     if ($activity->class_code == 11) {
    //         $subjects = StudentSubjects::where('student_code', $student_code)->with(['subject', 'lessonPlan' => function ($query) use ($activity) {
    //             $query->where('session_id', $activity->session_id)->where('section_id', $activity->section_id); // Apply your condition here
    //         }])->orderBy('id', 'asc')->get();
    //     } else {
    //         $subjects = ClassWiseSubject::where('class_code', $activity->class_code)->with(['subject', 'lessonPlan' => function ($query) use ($activity) {
    //             $query->where('session_id', $activity->session_id)->where('section_id', $activity->section_id); // Apply your condition here
    //         }])->orderBy('subject_code', 'asc')->get();
    //     }

    //     return view('lessonplan.lessonPlanStudent', compact('subjects'));
    // }

    public function lessonPlanStudent()
    {
        // Set session menu for active tabs
        Session::put('activemenu', 'academic');
        Session::put('activesubmenu', 'lessonplan');

        // Get student activity
        $student_code = Auth::user()->ref_id;
        $activity = StudentActivity::where('student_code', $student_code)
            ->orderByDesc('id')
            ->first();

        if (!$activity) {
            // Handle the case when no activity is found
            return redirect()->back()->with('error', 'No student activity found.');
        }

        // Retrieve lesson plans for the student's class
        $lessonPlans = LeasonPlan::with(['session', 'version', 'shift', 'classes', 'section', 'employee', 'subject',])
            ->where('class_code', $activity->class_code)
            ->where('section_id', $activity->section_id)
            ->where('session_id', $activity->session_id)
            ->get();

        // Pass data to the view
        return view('lessonplan.lessonPlanStudent', compact('lessonPlans'));
    }


    public function create()
    {
        $versions = Versions::where('active', 1)->get();
        $sessions = Sessions::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $subjects = Subjects::where('active', 1)->get();
        $sections = Sections::where('active', 1)->get();
        $classes = Classes::orderByRaw("CAST(class_code AS UNSIGNED)")->pluck('class_name', 'class_code');
        $employees = Employee::where('category_id', 7)->with('designation')->where('active', 1)->get();

        return view('lessonplan.create', compact('versions', 'sessions', 'shifts', 'classes', 'subjects', 'employees', 'sections'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'session_id' => 'required',
            'version_id' => 'required',
            'shift_id' => 'required',
            'class_code' => 'required',
            'section_id' => 'required',
            'teacher_id' => 'required',
            'subject_id' => 'required',
            'date' => 'required',
            'time' => 'required',
            'pdf' => 'sometimes|mimes:pdf|max:200',
            'general_lesson' => 'required',
            'materials' => 'required',
            'objectives' => 'required',
            'wamp_up' => 'nullable',
            'wamp_up_for_student' => 'nullable',
            'procedure' => 'nullable',
            'procedure_for_student' => 'nullable',
            'assessment' => 'nullable',
            'assessment_for_student' => 'nullable',
            'home_work' => 'nullable',
            'home_work_for_student' => 'nullable',
            'number' => 'nullable|numeric|integer',
        ]);

        $data = $request->except([
            'id',
            '_token',
            'pdf'
        ]);

        if ($request->id == 0) {
            $pdf = null;
            // Create a new syllabus
            if ($request->hasFile('pdf')) {
                $file = $request->file('pdf');
                $filename = $file->getClientOriginalName();
                $destinationPath = 'sutdent/lesson_plan/' . $request->session_id . '/' . $request->class_code;
                $filePath = public_path($destinationPath);
                $file->move($filePath, $filename);
                $pdf = asset('public/' . $destinationPath) . '/' . $filename;
            }
            $data['pdf'] = $pdf;
            $data['created_by'] = Auth::user()->id;
            LeasonPlan::create($data);

            return redirect()->route('lessonplan.index')
                ->with('success', 'Lesson plan created successfully.');
        } else {
            $LeasonPlan = LeasonPlan::find($request->id);
            $pdf = $LeasonPlan->pdf ?? null;
            // Create a new syllabus
            if ($request->hasFile('pdf')) {
                $file = $request->file('pdf');
                $filename = $file->getClientOriginalName();
                $destinationPath = 'sutdent/lesson_plan/' . $request->session_id . '/' . $request->class_code;
                $filePath = public_path($destinationPath);
                // Remove the existing file
                if ($pdf && file_exists(public_path(str_replace(asset('public/'), '', $pdf)))) {
                    unlink(public_path(str_replace(asset('public/'), '', $pdf)));
                }
                $file->move($filePath, $filename);
                $pdf = asset('public/' . $destinationPath) . '/' . $filename;
            }
            $data['pdf'] = $pdf;
            $data['updated_by'] = Auth::user()->id;
            $LeasonPlan->update($data);
            return redirect()->route('lessonplan.index')
                ->with('success', 'Lesson plan updated successfully.');
        }
    }

    public function show(LeasonPlan $lesson_plan_master)
    {
        return view('lesson_plan_masters.show', compact('lesson_plan_master'));
    }

    public function edit($id)
    {
        $lesson_plan = LeasonPlan::find($id);
        $versions = Versions::where('active', 1)->get();
        $sessions = Sessions::where('active', 1)->get();
        $sections = Sections::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $subjects = Subjects::where('active', 1)->get();
        $classes = Classes::orderByRaw("CAST(class_code AS UNSIGNED)")->pluck('class_name', 'class_code');
        $employees = Employee::where('category_id', 7)->with('designation')->where('active', 1)->get();
        return view('lessonplan.create', compact('versions', 'sessions', 'shifts', 'subjects', 'sections', 'classes', 'employees', 'lesson_plan'));
    }

    public function destroy($id)
    {
        $lesson_plan = LeasonPlan::find($id);

        if ($lesson_plan) {
            $lesson_plan->delete();;
            return response()->json(['success' => 'Lesson plan deleted successfully.']);
        } else {
            return response()->json(['error' => 'Lesson plan not found.'], 404);
        }
    }
}
