<?php

namespace App\Http\Controllers;

use App\Models\sttings\Subjects;
use App\Models\sttings\AcademySection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SubjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        Session::put('activemenu', 'setting');
        Session::put('activesubmenu', 'su');
        $subjects = Subjects::all();
        foreach ($subjects as $key => $subject) {
            $groupid = explode(",", $subject->group_id);
            $subjects[$key]->group = AcademySection::whereIn('id', $groupid)->get();
        }

        $groups = AcademySection::all();
        return view('setting.subject', compact('subjects', 'groups'));
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
                    'subject_name' => 'required|unique:subjects',
                    'subject_name_bn' => 'required|unique:subjects',
                    'publication' => 'nullable',
                    'details' => 'nullable',
                    'short_subject' => 'nullable',
                    'parent_subject' => 'nullable',
                    'active' => 'required',
                ]);
            } else {
                $validated = $request->validate([
                    'subject_name' => 'required',
                    'subject_name_bn' => 'required',
                    'publication' => 'nullable',
                    'details' => 'nullable',
                    'short_subject' => 'nullable',
                    'parent_subject' => 'nullable',
                    'active' => 'required',
                ]);
            }


            if ($id == 0) {

                Subjects::insert($validated);
                $sms = "Successfully Inserted";
            } else {

                Subjects::where('id', $id)->update($validated);
                $sms = "Successfully Updated";
            }
            return redirect(route('subject.index'))->with('success', $sms);
        } catch (\Exception $e) {

            return redirect(route('subject.index'))->with(['msg' => $e]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Subjects $subjects)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subjects $subjects)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subjects $subjects)
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
            $Subjects = Subjects::find($id);
            $Subjects->delete();
            return 1;
        } catch (\Exception $e) {
            return $e;
        }
    }
}