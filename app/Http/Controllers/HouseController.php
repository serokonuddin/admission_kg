<?php

namespace App\Http\Controllers;

use App\Models\sttings\House;
use Illuminate\Http\Request;
use Session;
class HouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->group_id!=2 && Auth::user()->group_id!=10){
            return 1;
        }
        Session::put('activemenu','setting');
        Session::put('activesubmenu','ho');
        $houses=House::all();
        return view('setting.house',compact('houses'));
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
        if(Auth::user()->group_id!=2 && Auth::user()->group_id!=10){
            return 1;
        }
        $id=$request->id;
        try {
           
            if($id==0){
               
                $validated = $request->validate([
                    'house_name' => 'required',
                    'active' => 'required',
                ]);
            }else{
                $validated = $request->validate([
                    'house_name' => 'required',
                    'active' => 'required',
                ]);
            }
            
            
            if($id==0){
                
                House::insert($validated);
                $sms="Successfully Inserted";
            }else{
               
                House::where('id',$id)->update($validated);
                $sms="Successfully Updated";
            }
            return redirect(route('house.index'))->with('success',$sms);
          } catch (Exception $e) {
            
            return redirect(route('house.index'))->with(['msg' => $e]);
          }
    }

    /**
     * Display the specified resource.
     */
    public function show(House $house)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(House $house)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, House $house)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if(Auth::user()->group_id!=2 && Auth::user()->group_id!=10){
            return 1;
        }
        try {
            $House=House::find($id);
            $House->delete();
            return 1;
        } catch (Exception $e) {
            return $e;
        }
    }
}
