<?php

namespace App\Http\Controllers;

use App\Models\sttings\Shifts;
use Illuminate\Http\Request;
use Session;
class ShiftsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->group_id!=2){
            return 1;
        }
        Session::put('activemenu','setting');
        Session::put('activesubmenu','sh');
        $shifts=Shifts::all();
        return view('setting.shift',compact('shifts'));
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
        if(Auth::user()->group_id!=2){
            return 1;
        }
        $id=$request->id;
        try {
           
            if($id==0){
               
                $validated = $request->validate([
                    'shift_name' => 'required',
                    'active' => 'required',
                ]);
            }else{
                $validated = $request->validate([
                    'shift_name' => 'required',
                    'active' => 'required',
                ]);
            }
            
            
            if($id==0){
                
                Shifts::insert($validated);
                $sms="Successfully Inserted";
            }else{
               
                Shifts::where('id',$id)->update($validated);
                $sms="Successfully Updated";
            }
            return redirect(route('shift.index'))->with('success',$sms);
          } catch (Exception $e) {
            
            return redirect(route('shift.index'))->with(['msg' => $e]);
          }
    }

    /**
     * Display the specified resource.
     */
    public function show(Shifts $shifts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shifts $shifts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shifts $shifts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if(Auth::user()->group_id!=2){
            return 1;
        }
        try {
            $Sessions=Shifts::find($id);
            $Sessions->delete();
            return 1;
        } catch (Exception $e) {
            return $e;
        }
    }
}
