<?php

namespace App\Http\Controllers;

use App\Models\sttings\Degree;
use Illuminate\Http\Request;
use Session;
class DegreeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Session::put('activemenu','setting');
        Session::put('activesubmenu','deg');
        $degrees=Degree::all();
        return view('setting.degree',compact('degrees'));
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
                    'degree_name' => 'required',
                    'degree_code' => 'nullable',
                    'level' => 'required',
                    'active' => 'required',
                ]);
            }else{
                $validated = $request->validate([
                    'degree_name' => 'required',
                    'degree_code' => 'nullable',
                    'level' => 'required',
                    'active' => 'required',
                ]);
            }
            
            
            if($id==0){
                
                Degree::insert($validated);
                $sms="Successfully Inserted";
            }else{
               
                Degree::where('id',$id)->update($validated);
                $sms="Successfully Updated";
            }
            return redirect(route('degree.index'))->with('success',$sms);
          } catch (Exception $e) {
            
            return redirect(route('degree.index'))->with(['msg' => $e]);
          }
    }

    /**
     * Display the specified resource.
     */
    public function show(Degree $degree)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Degree $degree)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Degree $degree)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $Degree=Degree::find($id);
            $Degree->delete();
            return 1;
        } catch (Exception $e) {
            return $e;
        }
    }
}
