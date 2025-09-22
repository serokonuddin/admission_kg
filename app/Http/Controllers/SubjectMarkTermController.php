<?php

namespace App\Http\Controllers;

use App\Models\SubjectMarkTerm;
use App\Models\Exam\Exam;
use App\Models\ExamTimeShedule;
use App\Models\sttings\Sessions;
use App\Models\sttings\Classes;
use App\Models\sttings\Sections;
use App\Models\sttings\Subjects;
use App\Models\Student\Student;
use App\Models\sttings\Versions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SubjectMarkTermController extends Controller
{
    public function index()
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'smt');
        $sessions = Sessions::where('active', 1)->get();
        $subjects = DB::table('subjects')
            ->select('subjects.*')
            ->orderBy('subject_name', 'asc')
            ->get();
        $terms = SubjectMarkTerm::with(['session', 'subject'])->orderBy('id', 'desc')->get();
        // dd($terms[0]->id);
        return view('subject_mark_terms.index', compact('terms', 'sessions', 'subjects'));
    }
    public function getSubjectMarkTerms(Request $request)
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        $terms = SubjectMarkTerm::with(['session', 'subject'])
            ->where('class_code', $request->class_code)
            ->where('session_id', $request->session_id);
        if ($request->subject_id) {
            $terms = $terms->where('subject_id', $request->subject_id);
        }
        // $terms = $terms->get();
        $terms = $terms->orderBy('id', 'desc')->get();

        return view('subject_mark_terms.ajaxindex', compact('terms'));
    }

    // Show the form for creating a new resource
    public function create()
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'smt');
        $sessions = Sessions::where('active', 1)->get();
        $subjects = DB::table('subjects')
            ->select('subjects.*')
            ->orderBy('subject_name', 'asc')
            ->get();
        return view('subject_mark_terms.create', compact('sessions', 'subjects'));
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        // dd($request->all());
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        $request->validate([
            'session_id' => 'required|integer',
            'class_code' => 'required|integer',
            'subject_id.*' => 'required|integer',
            'marks_for.*' => 'required|integer',
            'total_mark.*' => 'required',
            'pass_mark.*' => 'required',
            'converted_to.*' => 'nullable|integer',
        ]);

        $text = 'Something is wrong.';
        foreach ($request->subject_id as $key => $subjectId) {
            $attributes = [
                'session_id' => $request->session_id,
                'class_code' => $request->class_code,
                'subject_id' => $subjectId,
                'marks_for' => $request->marks_for[$key]
            ];
            $values = [
                'session_id' => $request->session_id,
                'class_code' => $request->class_code,
                'exam_id' => $request->exam_id,
                'subject_id' => $subjectId,
                'marks_for' => $request->marks_for[$key],
                'total_mark' => $request->total_mark[$key],
                'pass_mark' => $request->pass_mark[$key],
                'converted_to' => $request->converted_to[$key] ?? null,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ];

            $user = SubjectMarkTerm::updateOrCreate($attributes, $values);

            $text = 'Subject Mark Term created successfully.';
        }


        return redirect()->route('subject_mark_terms.index')
            ->with('success', $text);
    }

    // Show the form for editing the specified resource
    public function edit(SubjectMarkTerm $subjectMarkTerm)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'smt');
        $sessions = Sessions::where('active', 1)->get();
        $subjects = DB::table('subjects')
            ->select('subjects.*')
            ->orderBy('subject_name', 'asc')
            ->get();
        return view('subject_mark_terms.create', compact('subjectMarkTerm', 'sessions', 'subjects'));
    }

    // Update the specified resource in storage
    public function update(Request $request, SubjectMarkTerm $subjectMarkTerm)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        $request->validate([
            'session_id' => 'required|integer',
            'class_code' => 'required|integer',
            'subject_id' => 'required|integer',
            'marks_for' => 'required|integer',
            'total_mark' => 'required|integer',
            'pass_mark' => 'required|integer',
        ]);

        $subjectMarkTerm->update($request->all());
        return redirect()->route('subject_mark_terms.index')
            ->with('success', 'Subject Mark Term updated successfully.');
    }

    // Remove the specified resource from storage
    public function destroy(SubjectMarkTerm $subjectMarkTerm)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        $subjectMarkTerm->delete();
        return redirect()->route('subject_mark_terms.index')
            ->with('success', 'Subject Mark Term deleted successfully.');
    }
}