<?php

namespace App\Http\Controllers;
use App\Models\Fine;
use App\Models\sttings\Sessions;
use Illuminate\Http\Request;
use Session;
use DB;
use Auth;
class FineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->group_id!=2){
            return 1;
        }
        Session::put('activemenu','finance');
        Session::put('activesubmenu','fi');
        $session=Sessions::where('active',1)->first();
        $fines=Fine::with('session')->get();
        return view('fine.index',compact('fines','session'));
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
        $validated=$request->validate([
                'session_id' => 'required',
                'name' => 'required',
                'amount' => 'required',
                'unit' => 'required',
                'status' => 'required',
                'unit_value' => 'required'
        ]);
        if($id==0){
            
            $validated['created_by']=Auth::user()->id;
            Fine::insert($validated);
            $sms="Successfully Inserted";
        }else{
            $validated['updated_by']=Auth::user()->id;
            Fine::where('id',$id)->update($validated);
            $sms="Successfully Updated";
        }
        return redirect(route('fine.index'))->with('success',$sms);
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
        if(Auth::user()->group_id!=2){
            return 1;
        }
        try {
            $Fine=Fine::find($id);
            $Fine->delete();
            return 1;
        } catch (Exception $e) {
            return $e;
        }
    }
}
