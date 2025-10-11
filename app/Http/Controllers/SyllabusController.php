<?php

namespace App\Http\Controllers;


use App\Models\Employee\Employee;
use App\Models\Setting\Group;
use App\Models\sttings\Classes;
use App\Models\sttings\Versions;
use App\Models\Syllabus;
use App\Models\sttings\Subjects;
use App\Models\sttings\Sessions;
use App\Models\sttings\Shifts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class SyllabusController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::user()->group_id!=2){
            return 1;
        }
        Session::put('activemenu', 'activity');
        Session::put('activesubmenu', 'sb');
        $class_code = $request->class_code;
        $session_id = $request->session_id;
        $version_id = $request->version_id;
        $shift_id = $request->shift_id;
        $subject_id = $request->subject_id;
        $employee_id = $request->employee_id;

        $syllabuss = Syllabus::with(['session', 'version', 'classes', 'employee', 'subject']);
        if ($session_id) {
            $syllabuss = $syllabuss->where('session_id', $session_id);
        }
        if ($version_id) {
            $syllabuss = $syllabuss->where('version_id', $version_id);
        }
        if ($class_code) {
            $syllabuss = $syllabuss->where('class_code', $class_code);
        }
        if ($subject_id) {
            $syllabuss = $syllabuss->where('subject_id', $subject_id);
        }


        $syllabuss = $syllabuss->get();
        $versions = Versions::where('active', 1)->get();
        // $sessions = Sessions::where('active', 1)->get();
        $sessions = Sessions::orderBy('id', 'desc')->get();
        $shifts = Shifts::where('active', 1)->get();
        $classes = Classes::orderByRaw("CAST(class_code AS UNSIGNED)")->pluck('class_name', 'class_code');
        $subjects = Subjects::where('active', 1)->get();
        $groups = DB::table('academygroups')->where('active', 1)->distinct('id')->pluck('group_name', 'id');
        $employees = Employee::where('active', 1)->where('category_id', 7)->get();
        return view('syllabus.index', compact(
            'employee_id',
            'subject_id',
            'class_code',
            'session_id',
            'version_id',
            'groups',
            'syllabuss',
            'employees',
            'versions',
            'sessions',
            'classes',
            'shifts',
            'subjects'
        ));
    }

    public function create()
    {
        if(Auth::user()->group_id!=2){
            return 1;
        }
        $versions = Versions::where('active', 1)->get();
        $sessions = Sessions::orderBy('id', 'desc')->get();
        $shifts = Shifts::where('active', 1)->get();
        $classes = Classes::orderByRaw("CAST(class_code AS UNSIGNED)")->pluck('class_name', 'class_code');
        $subjects = Subjects::where('active', 1)->get();
        $groups = DB::table('academygroups')->where('active', 1)->distinct('id')->pluck('group_name', 'id');
        return view('syllabus.create', compact('versions', 'groups', 'sessions', 'shifts', 'classes', 'subjects'));
    }

    public function store(Request $request)
    {
        if(Auth::user()->group_id!=2){
            return 1;
        }
        // Validate the incoming request
        $request->validate([
            'session_id' => 'required',
            'version_id' => 'required',
            'class_code' => 'required',
            // 'subject_id' => 'required',
            // 'details' => 'required',
            'pdf' => 'sometimes|mimes:pdf|max:500', // Ensure file is a PDF and max size is 1 MB
            'active' => 'required',
        ]);

        try {
            // Prepare data for saving
            $data = $request->except(['id', '_token', 'pdf']);
            // Handle file upload
            if ($request->id == 0) {
                $pdf = null;
                // Create a new syllabus
                if ($request->hasFile('pdf')) {
                    $file = $request->file('pdf');
                    $filename = $file->getClientOriginalName();
                    $destinationPath = 'sutdent/syllabus/' . $request->session_id . '/' . $request->class_code;
                    $filePath = public_path($destinationPath);
                    $file->move($filePath, $filename);
                    $pdf = asset('public/' . $destinationPath) . '/' . $filename;
                }
                $data['pdf'] = $pdf;
                $data['created_by'] = Auth::user()->id;
                // dd($data);
                Syllabus::create($data);
                return redirect()->route('syllabus.index')
                    ->with('success', 'Syllabus created successfully.');
            } else {
                // Update existing syllabus
                $syllabus = Syllabus::find($request->id);
                $pdf = $syllabus->pdf ?? null;
                // Create a new syllabus
                if ($request->hasFile('pdf')) {
                    $file = $request->file('pdf');
                    $filename = $file->getClientOriginalName();
                    $destinationPath = 'sutdent/syllabus/' . $request->session_id . '/' . $request->class_code;
                    $filePath = public_path($destinationPath);
                    // Remove the existing file
                    if ($pdf && file_exists(public_path(str_replace(asset('public/'), '', $pdf)))) {
                        unlink(public_path(str_replace(asset('public/'), '', $pdf)));
                    }
                    $file->move($filePath, $filename);
                    $pdf = asset('public/' . $destinationPath) . '/' . $filename;
                }
                $data['pdf'] = $pdf;
                if (!$syllabus) {
                    return redirect()->route('syllabus.index')
                        ->with(
                            'error',
                            'Syllabus not found.'
                        );
                }

                $data['updated_by'] = Auth::user()->id;
                $syllabus->update($data);

                return redirect()->route('syllabus.index')
                    ->with('success', 'Syllabus updated successfully.');
            }
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function show(Syllabus $syllabus)
    {
        if(Auth::user()->group_id!=2){
            return 1;
        }
        return view('syllabus.show', compact('syllabus'));
    }

    public function edit($id)
    {
        if(Auth::user()->group_id!=2){
            return 1;
        }
        $syllabus = Syllabus::find($id);
        $versions = Versions::where('active', 1)->get();
        $sessions = Sessions::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $classes = Classes::orderByRaw("CAST(class_code AS UNSIGNED)")->pluck('class_name', 'class_code');
        $subjects = Subjects::where('active', 1)->get();
        $groups = DB::table('academygroups')->where('active', 1)->distinct('id')->pluck('group_name', 'id');
        return view('syllabus.create', compact('versions', 'sessions', 'shifts', 'subjects', 'syllabus', 'classes', 'groups'));
    }

    public function update(Request $request, Syllabus $syllabus)
    {
        if(Auth::user()->group_id!=2){
            return 1;
        }
        $request->validate([
            'session_id' => 'required',
            'version_id' => 'required',
            'class_code' => 'required',
            'teacher_id' => 'required',
            'subject_id' => 'required',
            'pdf' => 'nullable',
            'details' => 'required',
        ]);

        $syllabus->update($request->all());

        return redirect()->route('syllabus.index')
            ->with('success', 'Syllabus updated successfully.');
    }

    public function destroy($id)
    {
        if(Auth::user()->group_id!=2){
            return 1;
        }
        $syllabus = Syllabus::find($id);

        if ($syllabus) {
            $syllabus->delete();
            return response()->json(['success' => 'Syllabus deleted successfully.']);
        } else {
            return response()->json(['error' => 'Syllabus not found.'], 404);
        }
    }
}
