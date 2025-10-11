<?php

namespace App\Http\Controllers;


use App\Models\sttings\Degree;
use App\Models\sttings\Discipline;
use Illuminate\Http\Request;
use Session;
class DisciplineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        Session::put('activemenu','setting');
        Session::put('activesubmenu','di');
        $disciplines=Discipline::where('active',1)->get();
        $degrees=Degree::where('active',1)->get();
        return view('setting.discipline',compact('disciplines','degrees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getDiscipline(Request $request)
    {
        $disciplines=Discipline::where('active',1)->where('degree_id',$request->degree_id)->get();
        return view('setting.ajaxdiscipline',compact('disciplines'));
    }
   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id=$request->id;
        try {
           
            $validated = $request->validate([
                'name' => 'required',
                'degree_id' => 'required',
                'active' => 'required',
            ]);
               
                
            
            
            
            if($id==0){
                
                Discipline::insert($validated);
                $sms="Successfully Inserted";
            }else{
               
                Discipline::where('id',$id)->update($validated);
                $sms="Successfully Updated";
            }
            return redirect(route('discipline.index'))->with('success',$sms);
          } catch (Exception $e) {
            
            return redirect(route('discipline.index'))->with(['msg' => $e]);
          }
    }

    /**
     * Display the specified resource.
     */
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discipline $discipline)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Discipline $discipline)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discipline $discipline)
    {
        try {
            $Discipline=Discipline::find($id);
            $Discipline->delete();
            return 1;
        } catch (Exception $e) {
            return $e;
        }
    }
}
