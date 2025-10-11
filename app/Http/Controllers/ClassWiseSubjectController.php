<?php

namespace App\Http\Controllers;

use App\Models\sttings\ClassWiseSubject;
use App\Models\sttings\Classes;
use App\Models\sttings\Subjects;
use App\Models\sttings\AcademySection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ClassWiseSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        Session::put('activemenu', 'class');
        Session::put('activesubmenu', 'sm');
        $classes = Classes::where('active', 1)->with(['shift', 'version'])->get();

        $subjects = Subjects::where('active', 1)->get();
        $groups = AcademySection::where('active', 1)->get();
        $subjects = Subjects::with('group')->where('active', 1)->orderBy('subject_name', 'asc')->get();
        $pairs = Subjects::with('group')->whereNotNull('parent_subject')->where('active', 1)->get();
        $classWiseSubject = ClassWiseSubject::with('subject')->with(['classdata.shift', 'classdata.version', 'group'])->orderBy('id', 'desc')->get();

        return view('setting.subjectmappint', compact('classWiseSubject', 'pairs', 'groups', 'classes', 'subjects'));
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
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        $id = $request->id;
        try {

            if ($id == 0) {

                $validated = $request->validate([
                    'class_code' => 'required',
                    'subject_id' => 'nullable',
                    'subject_type' => 'nullable',
                    'group_id' => 'nullable',
                    'is_main' => 'nullable',
                    'subject_code' => 'required',
                    'active' => 'required',
                ]);
            } else {
                $validated = $request->validate([
                    'class_code' => 'required',
                    'subject_id' => 'nullable',
                    'group_id' => 'nullable',
                    'subject_type' => 'nullable',
                    'is_main' => 'nullable',
                    //'pair' => 'nullable',
                    'subject_code' => 'required',
                    'active' => 'required',
                ]);
            }


            if ($id == 0) {

                ClassWiseSubject::insert($validated);
                $sms = "Successfully Inserted";
            } else {

                ClassWiseSubject::where('id', $id)->update($validated);
                $sms = "Successfully Updated";
            }
            return redirect(route('subjectmapping.index'))->with('success', $sms);
        } catch (\Exception $e) {

            return redirect(route('subjectmapping.index'))->with(['msg' => $e]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ClassWiseSubject $classWiseSubject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClassWiseSubject $classWiseSubject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClassWiseSubject $classWiseSubject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        try {
            $ClassWiseSubject = ClassWiseSubject::find($id);
            $ClassWiseSubject->delete();
            return 1;
        } catch (\Exception $e) {
            return $e;
        }
    }
}