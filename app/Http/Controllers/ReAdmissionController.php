<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReAdmission;
use App\Models\sttings\Sessions;
use Session;
use DB;
use Auth;

class ReAdmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Session::put('activemenu','finance');
        Session::put('activesubmenu','rac');
        $session=Sessions::where('active',1)->first();
        $readmissions=ReAdmission::with('session')->get();
        return view('readmission.index',compact('readmissions','session'));
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
        $id=$request->id;
        $validated=$request->validate([
                'session_id' => 'required',
                'title' => 'required',
                'duration' => 'required',
                'unit' => 'required',
                'status' => 'required',
                'unit_value' => 'required'
        ]);
        if($id==0){
            
            $validated['created_by']=Auth::user()->id;
            ReAdmission::insert($validated);
            $sms="Successfully Inserted";
        }else{
            $validated['updated_by']=Auth::user()->id;
            ReAdmission::where('id',$id)->update($validated);
            $sms="Successfully Updated";
        }
        return redirect(route('readmission.index'))->with('success',$sms);
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
        try {
            $ReAdmission=ReAdmission::find($id);
            $ReAdmission->delete();
            return 1;
        } catch (Exception $e) {
            return $e;
        }
    }
}
