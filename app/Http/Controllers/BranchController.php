<?php

namespace App\Http\Controllers;

use App\Models\sttings\Branch;
use Illuminate\Http\Request;
use Session;
class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Session::put('activemenu','setting');
        Session::put('activesubmenu','br');
        $branches=Branch::all();
        return view('setting.branch',compact('branches'));
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
                    'branch_name' => 'required|unique:Branch',
                    'branch_code' => 'required|unique:Branch',
                    'address' => 'required',
                    'active' => 'required',
                ]);
            }else{
                $validated = $request->validate([
                    'branch_name' => 'required|unique:Branch,branch_name,'.$request->id,
                    'branch_code' => 'required|unique:Branch,branch_code,'.$request->id,
                    'address' => 'required',
                    'active' => 'required',
                ]);
            }
            
            
            if($id==0){
                
                Branch::insert($validated);
                $sms="Successfully Inserted";
            }else{
               
                Branch::where('id',$id)->update($validated);
                $sms="Successfully Updated";
            }
            return redirect(route('branch.index'))->with('success',$sms);
          } catch (Exception $e) {
            
            return redirect(route('branch.index'))->with(['msg' => $e]);
          }
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $branch=Branch::find($id);
            $branch->delete();
            return 1;
        } catch (Exception $e) {
            return $e;
        }
    }
}
