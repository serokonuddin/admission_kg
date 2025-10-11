<?php

namespace App\Http\Controllers;


use App\Models\sttings\Discipline;
use App\Models\sttings\Specialization;
use Illuminate\Http\Request;
use Session;
class SpecializationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        Session::put('activemenu','setting');
        Session::put('activesubmenu','sp');
        $specializations=Specialization::where('active',1)->with('discipline')->get();
        $disciplines=Discipline::where('active',1)->with('degree')->get();
        return view('setting.specialization',compact('disciplines','specializations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getSpecialization(Request $request)
    {
        $specializationes=Specialization::where('active',1)->where('discipline_id',$request->discipline_id)->get();
        return view('setting.ajaxspecialization',compact('specializationes'));
    }
   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id=$request->id;
        try {
           
            $validated = $request->validate([
                'discipline_id' => 'required',
                'specialization_name' => 'required',
            ]);
               
                
            
            
            
            if($id==0){
                
                Specialization::insert($validated);
                $sms="Successfully Inserted";
            }else{
               
                Specialization::where('id',$id)->update($validated);
                $sms="Successfully Updated";
            }
            return redirect(route('specialization.index'))->with('success',$sms);
          } catch (Exception $e) {
            
            return redirect(route('specialization.index'))->with(['msg' => $e]);
          }
    }

    /**
     * Display the specified resource.
     */
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Specialization $discipline)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Specialization $discipline)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specialization $discipline)
    {
        try {
            $Specialization=Specialization::find($id);
            $Specialization->delete();
            return 1;
        } catch (Exception $e) {
            return $e;
        }
    }
}
