<?php

namespace App\Http\Controllers;
use App\Models\sttings\Classes;
use App\Models\Fee;
use App\Models\ClassCategoryHeadFee;
use App\Models\sttings\Sessions;
use Illuminate\Http\Request;
use App\Models\sttings\Category;
use Session;
use DB;
use Auth;

class ExamFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Session::put('activemenu','finance');
        Session::put('activesubmenu','ef');
        $sessions=Sessions::where('active',1)->get();
        $session=Sessions::where('active',1)->first();
        $feehead=Fee::where('id',2)->first();
        $classes=Classes::with(['shift','version'])
        ->select('class_code','class_name','version_id')
        ->groupBy('class_code')
        ->groupBy('class_name')
        ->groupBy('version_id')
        ->orderBy('version_id','asc')
        ->orderBy('class_code','asc')
        ->get();
        $classwiseemischarge=ClassCategoryHeadFee::with([
            'session'
            ,'version'
            ,'shift'
            ,'classes'
            ,'category'
            ,'head'
       ])->where('head_id',2)->where('session_id',$session->id)->get();
      
       $classwiseemischarge=collect($classwiseemischarge)->groupBy('version_id');
       $emisdata=array();
       $emisdatadate=array();
       $emisdataid=array();
       foreach($classwiseemischarge as $key=>$values){
        $values=collect($values)->groupBy('class_code');
        foreach($values as $key1=>$value){

            $emisdata[$key.'-'.$key1]=$value[0]->amount??0;
            $emisdatadate[$key.'-'.$key1]=$value[0]->effective_from??null;
            $emisdataid[$key.'-'.$key1]=$value[0]->id??null;
        }
       }
       
        return view('examfee.index',compact('feehead','sessions','classes','emisdata','emisdatadate','emisdataid'));
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
        //$id=$request->id;
       // dd($request);
        $validated=$request->validate([
                'session_id' => 'required',
                'class_id' => 'required',
                'head_id' => 'required',
        ]);
        $categorys=Category::where('active',1)->where('type',2)->get();
        foreach($validated['class_id'] as $class_id){
            $classdata=explode("-",$class_id);
           
            //$classdata=Classes::find($class_id);
            $idtext='id'.$class_id;
            $amounttext='amount'.$class_id;
            $effective_fromtext='effective_from'.$class_id;
            $idtext='id'.$class_id;
            $id=$request->$idtext;
            $amount=$request->$amounttext;
            $effective_from=$request->$effective_fromtext;

            $insertdata=array(
                'fee_for'=>4,
                'session_id'=>$request->session_id,
                'version_id'=>$classdata[1],
                'class_id'=>$classdata[0],
                'class_code'=>$classdata[0],
                'head_id'=>$request->head_id,
                'amount'=>$amount,
                'effective_from'=>$effective_from,
                'month'=>date('m',strtotime($effective_from))
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
           // DB::table('category_wise_fee_amount')->where('master_id',$id)->delete();
            // foreach($categorys as $category){
            //     $insertcategorywisedata=array(
            //         'master_id'=>$id,
            //         'category_id'=>$category->id,
            //         'head_id'=>$request->head_id,
            //         'amount'=>$amount,
            //         'effective_from'=>$effective_from,
            //         'payment_type'=>1,
            //         'created_by'=>Auth::user()->id
            //     );
            //     DB::table('category_wise_fee_amount')->insert($insertcategorywisedata);
            // }
        }
        
        return redirect(route('examfee.index'))->with('success',$sms);
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
