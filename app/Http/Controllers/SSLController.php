<?php

namespace App\Http\Controllers;

use App\Models\SMS;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeActivity;
use App\Models\sttings\Sessions;
use App\Models\sttings\Shifts;
use App\Models\sttings\Versions;
use App\Models\Student\Student;
use App\Models\sttings\Category;
use App\Models\sttings\Designation;
use App\Models\sttings\Subjects;
use App\Models\sttings\Classes;
use App\Models\sttings\Sections;
use Illuminate\Http\Request;

class SSLController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sessions = Sessions::where('active', 1)->get();
        $versions = Versions::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $classes = Classes::where('active', 1)
            ->where('session_id', $request->session_id)
            ->where('shift_id', $request->shift_id)
            ->where('version_id', $request->version_id)
            ->get();
        $subjects = Subjects::where('active', 1)
            ->get();
        $designationes = Designation::where('active', 1)->orderBy('designation_name', 'asc')->get();


        return view('ssl.index', compact('sessions', 'versions', 'shifts', 'classes', 'subjects', 'designationes'));
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
    public function show(SMS $sMS)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SMS $sMS)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SMS $sMS)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SMS $sMS)
    {
        //
    }
}
