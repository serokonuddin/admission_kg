<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sttings\Sessions;
use App\Models\sttings\Versions;
use App\Models\sttings\Classes;
use App\Models\Student\Student;
use App\Models\Student\StudentActivity;
use App\Models\Fee;
use App\Models\PaymentFinal;
use App\Models\ClassCategoryHeadFee;
use App\Models\Finance\StudentFeeTansaction;
use App\Exports\CategoryWiseHeadFeeExport;
use App\Imports\ClassCategoryWiseHeadFeeImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\sttings\Category;
use Session;
use DB;
use Auth;

class GovernmentChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->group_id!=2 && Auth::user()->group_id!=10){
            return 1;
        }
        Session::put('activemenu','finance');
        Session::put('activesubmenu','gc');
        $sessions=Sessions::where('active',1)->first();
        $versions=Versions::where('active',1)->get();
        $categories=Category::where('type',2)->where('active',1)->get();
        $fees=Fee::join('master_category_wise_head_mapping','master_category_wise_head_mapping.head_id','=','fee_head.id')
                ->where('fee_for',5)->orderBy('master_category_wise_head_mapping.id','desc')->get();
        $payments=ClassCategoryHeadFee::with([
            'session'
            ,'version'
            ,'shift'
            ,'classes'
            ,'category'
            ,'head'
       ])->where('fee_for',5);
       if($sessions){
                   
           $payments->whereRaw('session_id = "'.$sessions->id.'"');
       }
       // if($version_id){
       //     $payments->whereRaw('version_id = "'.$version_id.'"');
       // }
       // if($shift_id){
       //     $payments->whereRaw('shift_id = "'.$shift_id.'"');
       // }
       // if($class_id){
       //     $payments->whereRaw('class_id = "'.$class_id.'"');
       // }
       // if($category_id){
       //     $payments->whereRaw('category_id = "'.$category_id.'"');
       // }
       
       $payments= $payments->orderBy('id','desc')->get();
        return view('fee.governmentcharge.index',compact('fees','sessions','versions','categories','payments'));
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
        $validated=$request->validate([
                'fee_for' => 'required',
                'session_id' => 'required',
                'version_id' => 'required',
                'class_id' => 'required',
                'head_id' => 'required',
                'month' => 'required',
                'gender' => 'required',
        ]);
        $is_entry=false;
        foreach($request->head_id as $head_id){
            $amount='amount'.$head_id;
            
           
            if($request->$amount>0){
                $ceckdata=ClassCategoryHeadFee::where('fee_for',$validated['fee_for'])
                        ->where('session_id',$validated['session_id'])
                        ->where('version_id',$validated['version_id'])
                        ->where('class_code',$validated['class_id'])
                        ->where('head_id',$head_id)
                        ->where('month',$validated['month'])
                        ->where('gender',$validated['gender'])
                        ->first();
                if($ceckdata){
                    
                    $ceckdata->class_code=$validated['class_id'];
                    $ceckdata->head_id=$head_id;
                    $ceckdata->amount=$request->$amount;
                    $ceckdata->updated_at=date('Y-m-d H:i:s');
                    $ceckdata->updated_by=Auth::user()->id;
                    $ceckdata->save();
                }else{
                    $validated['class_code']=$validated['class_id'];
                    $validated['head_id']=$head_id;
                    $validated['amount']=$request->$amount;
                    $validated['created_by']=Auth::user()->id;
                    ClassCategoryHeadFee::insert($validated);
                }
                $is_entry=true;
            }
            
        }
        if($is_entry==false){
            return back()->with('error', 'Head amount Not found.');
        }
        return back()->with('success', 'Data successfully Store.');
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
