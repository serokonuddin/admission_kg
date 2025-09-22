<?php

namespace App\Http\Controllers;

use App\Models\sttings\AcademySection;
use App\Models\sttings\Classes;
use Illuminate\Http\Request;
use Session;
class AcademySectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Session::put('activemenu','setting');
        Session::put('activesubmenu','gu');
        $classvalue=Classes::where('active',1)->whereIn('class_for',[2,3,4])->get();
        $academyGroups=AcademySection::all();
        return view('setting.group',compact('classvalue','academyGroups'));
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
                    'group_name' => 'required',
                    'active' => 'required',
                    'class_id' => 'required',
                ]);
            }else{
                $validated = $request->validate([
                    'group_name' => 'required',
                    'active' => 'required',
                    'class_id' => 'required',
                ]);
            }
            
            
            if($id==0){
                
                AcademySection::insert($validated);
                $sms="Successfully Inserted";
            }else{
               
                AcademySection::where('id',$id)->update($validated);
                $sms="Successfully Updated";
            }
            return redirect(route('group.index'))->with('success',$sms);
          } catch (Exception $e) {
            
            return redirect(route('group.index'))->with(['msg' => $e]);
          }
    }

    /**
     * Display the specified resource.
     */
    public function show(AcademySection $academySection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcademySection $academySection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AcademySection $academySection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $Sessions=AcademySection::find($id);
            $Sessions->delete();
            return 1;
        } catch (Exception $e) {
            return $e;
        }
    }
}
