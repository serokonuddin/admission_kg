<?php

namespace App\Http\Controllers;

use App\Models\sttings\Designation;
use Illuminate\Http\Request;
use Session;
class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        Session::put('activemenu','setting');
        Session::put('activesubmenu','de');
        $designations=Designation::all();
        return view('setting.designation',compact('designations'));
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
        try {
           
            if($id==0){
               
                $validated = $request->validate([
                    'designation_name' => 'required',
                    'details' => 'nullable',
                    'serial' => 'required',
                    'active' => 'required',
                ]);
            }else{
                $validated = $request->validate([
                    'designation_name' => 'required',
                    'details' => 'nullable',
                    'serial' => 'required',
                    'active' => 'required',
                ]);
            }
            
            
            if($id==0){
                
                Designation::insert($validated);
                $sms="Successfully Inserted";
            }else{
               
                Designation::where('id',$id)->update($validated);
                $sms="Successfully Updated";
            }
            return redirect(route('designation.index'))->with('success',$sms);
          } catch (Exception $e) {
            
            return redirect(route('designation.index'))->with(['msg' => $e]);
          }
    }

    /**
     * Display the specified resource.
     */
    public function show(Designation $designation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Designation $designation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Designation $designation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $Designation=Designation::find($id);
            $Designation->delete();
            return 1;
        } catch (Exception $e) {
            return $e;
        }
    }
}
