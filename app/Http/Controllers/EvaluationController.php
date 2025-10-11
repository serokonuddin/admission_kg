<?php

namespace App\Http\Controllers;
use App\Models\sttings\Classes;
use App\Models\Fee;
use App\Models\ClassCategoryHeadFee;
use App\Models\sttings\Sessions;
use App\Models\sttings\Versions;
use App\Models\sttings\Shifts;
use Illuminate\Http\Request;
use App\Models\sttings\Category;
use Session;
use DB;
use Auth;
class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $head_id=36;
        Session::put('activemenu','finance');
        Session::put('activesubmenu','ec');
        $sessions=Sessions::orderBy('session_name','desc')->get();
        $shifts=Shifts::where('active',1)->orderBy('id','asc')->get();
        $versions=Versions::where('active',1)->orderBy('id','asc')->get();
        $groups=DB::table('academygroups')->get();
        $feehead=Fee::where('id',$head_id)->first();
        $classes=Classes::with(['shift','version'])->orderBy('version_id','asc')->orderBy('shift_id','asc')->orderBy('class_code','asc')->get();
        $classwiseemischarge=ClassCategoryHeadFee::with([
            'session'
            ,'version'
            ,'shift'
            ,'classes'
            ,'category'
            ,'head'
       ])->where('head_id',$head_id)->where('session_id',$sessions[0]->id)->get();
       
       //$classwiseemischarge=collect($classwiseemischarge)->groupBy('class_id');
     
        return view('evaluation.index',compact('feehead','head_id','sessions','versions','groups','shifts','classes','classwiseemischarge'));
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
        $validated=$request->validate([
            'session_id' => 'required',
            'class_id' => 'required',
            'version_id' => 'required',
            'shift_id' => 'required',
            'head_id' => 'required',
            'amount' => 'required',
    ]);
    $categorys=Category::where('active',1)->where('type',2)->get();
    foreach($validated['class_id'] as $class_id){
        $classdata=Classes::find($class_id);
        $idtext='id'.$class_id;
        $amounttext='amount'.$class_id;
        $effective_fromtext='effective_from'.$class_id;
        $idtext='id'.$class_id;
        $id=$request->$idtext;
        $amount=$request->$amounttext;
        $effective_from=$request->$effective_fromtext;

        $insertdata=array(
            'fee_for'=>$classdata->class_for,
            'session_id'=>$request->session_id,
            'version_id'=>$classdata->version_id,
            'shift_id'=>$classdata->shift_id,
            'class_id'=>$class_id,
            'head_id'=>$request->head_id,
            'amount'=>$amount,
            'effective_from'=>$effective_from
        );
      
        if($id==0){
        
            $insertdata['created_by']=Auth::user()->id;
            $id=ClassCategoryHeadFee::insertGetId($insertdata);
            $sms="Successfully Inserted";
        }else{
            $insertdata['updated_by']=Auth::user()->id;
            ClassCategoryHeadFee::where('id',$id)->update($insertdata);
            $sms="Successfully Updated";
        }
        DB::table('category_wise_fee_amount')->where('master_id',$id)->delete();
        foreach($categorys as $category){
            $insertcategorywisedata=array(
                'master_id'=>$id,
                'category_id'=>$category->id,
                'head_id'=>$request->head_id,
                'amount'=>$amount,
                'effective_from'=>$effective_from,
                'payment_type'=>1,
                'created_by'=>Auth::user()->id
            );
            DB::table('category_wise_fee_amount')->insert($insertcategorywisedata);
        }
    }
    
    return redirect(route('emisCharge.index'))->with('success',$sms);
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
        //
    }
}
