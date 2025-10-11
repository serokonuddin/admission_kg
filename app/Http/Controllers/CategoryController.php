<?php

namespace App\Http\Controllers;

use App\Models\sttings\Category;
use Illuminate\Http\Request;
use Session;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Session::put('activemenu','setting');
        Session::put('activesubmenu','cat');
        $categories=Category::all();
        return view('setting.category',compact('categories'));
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
                    
                    'category_name' => 'required|unique:category',
                    'type' => 'nullable',
                    'active' => 'required',
                ]);
            }else{
                $validated = $request->validate([
                    'category_name' => 'required',
                    'type' => 'nullable',
                    'active' => 'required',
                ]);
            }
            
            
            if($id==0){
                
                Category::insert($validated);
                $sms="Successfully Inserted";
            }else{
               
                Category::where('id',$id)->update($validated);
                $sms="Successfully Updated";
            }
            return redirect(route('category.index'))->with('success',$sms);
          } catch (Exception $e) {
            
            return redirect(route('category.index'))->with(['msg' => $e]);
          }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $branch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $branch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $branch=Category::find($id);
            $branch->delete();
            return 1;
        } catch (Exception $e) {
            return $e;
        }
    }
}
