<?php

namespace App\Http\Controllers;

use App\Models\Exam\Exam;
use App\Models\ExamTimeShedule;
use App\Models\sttings\Sessions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ExamTimeSheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'ex');
        $schedules = ExamTimeShedule::all();
        $sessions = Sessions::get();

        return view('exam_time_shedules.index', compact('schedules', 'sessions'));
    }
    public function getExamTimeShedules(Request $request)
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        $schedules = ExamTimeShedule::with(['classdata', 'session', 'exam', 'subject'])
            ->where('class_code', $request->class_code)
            ->where('session_id', $request->session_id)
            ->where('exam_id', $request->exam_id);
        if ($request->subject_id) {
            $schedules = $schedules->where('subject_id', $request->subject_id);
        }
        $schedules = $schedules->get();
        return view('exam_time_shedules.ajaxindex', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'ex');
        $sessions = Sessions::get();
        return view('exam_time_shedules.create', compact('sessions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        $request->validate([
            'session_id' => 'required|integer',
            'class_code' => 'required|integer',
            'exam_id' => 'required|integer',
            'subject_id.*' => 'required|integer',
            'exam_for.*' => 'required|integer',
            'exam_date.*' => 'required|date',
            'start_time.*' => 'required',
            'end_time.*' => 'required',
        ]);

        $text = 'Something is wrong.';
        foreach ($request->subject_id as $key => $subjectId) {
            $attributes = [
                'session_id' => $request->session_id,
                'class_code' => $request->class_code,
                'exam_id' => $request->exam_id,
                'subject_id' => $subjectId,
                'exam_for' => $request->exam_for[$key]
            ];
            $values = [
                'session_id' => $request->session_id,
                'class_code' => $request->class_code,
                'exam_id' => $request->exam_id,
                'subject_id' => $subjectId,
                'exam_for' => $request->exam_for[$key],
                'exam_date' => $request->exam_date[$key],
                'start_time' => $request->start_time[$key],
                'end_time' => $request->end_time[$key],
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ];

            $user = ExamTimeShedule::updateOrCreate($attributes, $values);

            $text = 'Exam created successfully.';
        }


        return redirect()->route('exam-time-shedules.index')->with('success', $text);
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
    public function edit(ExamTimeShedule $examTimeShedule)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'ex');
        $exams = Exam::with(['session', 'classdata'])->where('session_id', $examTimeShedule->session_id)->where('class_code', $examTimeShedule->class_code)->get();
        $sessions = Sessions::where('active', 1)->get();
        $subjects = DB::table('subjects')
            ->select('subjects.*')
            ->join('class_wise_subject', 'class_wise_subject.subject_id', '=', 'subjects.id')
            ->where('class_code', $examTimeShedule->class_code)
            ->groupBy('id', 'subject_name')
            ->orderBy('subject_name', 'asc')
            ->get();
        return view('exam_time_shedules.create', compact('examTimeShedule', 'exams', 'sessions', 'subjects'));
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
}
