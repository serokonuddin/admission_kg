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
use App\Models\Finance\StudentHeadWiseFee;
use App\Exports\CategoryWiseHeadFeeExport;
use App\Imports\ClassCategoryWiseHeadFeeImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\sttings\Category;
use Session;
use DB;
use Auth;

class SessionChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if(Auth::user()->group_id!=2){
            return 1;
        }
        Session::put('activemenu','finance');
        Session::put('activesubmenu','sc');
        $sessions=Sessions::where('active',1)->first();
        $versions=Versions::where('active',1)->get();
        $categories=Category::where('type',2)->where('active',1)->get();
        $fees=Fee::join('master_category_wise_head_mapping','master_category_wise_head_mapping.head_id','=','fee_head.id')
                ->orderBy('master_category_wise_head_mapping.id','desc')
                ->where('fee_for',2)
                ->select('fee_head.id','head_name')
                ->get();
        $payments=StudentFeeTansaction::with(['session','version','category'])->where('session_id',$sessions->id)
        ->where('fee_for',2)
        ->orderBy('id','desc')
        ->get();
        return view('fee.sessioncharge.index',compact('fees','sessions','versions','categories','payments'));
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
                'version_id' => 'required',
                'class_id' => 'required',
                'month' => 'required',
                'head_id' => 'required|array|min:1',
        ]);
        $session_id=$validated['session_id'];
        $version_id=$validated['version_id'];
        $class_code=$validated['class_id'];
        $head_ids=$validated['head_id'];
        $month=$validated['month'];
        $is_entry=false;
        
        $categorys=DB::table('class_category_wise_head_fee')
            //->join('fee_head','fee_head.id','=','class_category_wise_head_fee.head_id')
            ->where('version_id',$version_id)
            //->where('session_id',$session_id)
            ->where('class_code',$class_code)
            ->whereIn('head_id',$head_ids)
            ->where('class_category_wise_head_fee.status',1)
            ->orderBy('class_category_wise_head_fee.id','desc')
            ->selectRaw('category_id,amount,head_id')->get();
            
        $categorys=collect($categorys)->groupBy('category_id');
        $students=DB::table('student_activity')
        ->join('students','students.student_code','=','student_activity.student_code')
        ->where('version_id',$version_id)
        ->where('session_id',$session_id)
        ->where('class_code',$class_code)
        ->whereNotNull('student_activity.category_id')
        ->select('student_activity.student_code','student_activity.category_id')->get();
        $categoryamount=array();
        foreach($categorys as $key=>$heads){
            $categoryamount[$key]['amount']=0;
            $categoryamount[$key]['amounts']='';
            foreach($heads as $k=>$head){
               
                $categoryamount[$key]['amount']+=(int)$head->amount;
                if($k==0){
                    $categoryamount[$key]['amounts']=(int)$head->amount;
                    $categoryamount[$key]['heads']=$head->head_id;
                }else{
                    $categoryamount[$key]['amounts'].=','.(int)$head->amount;
                    $categoryamount[$key]['heads'].=','.$head->head_id;
                }
                
                
            }
            
        }
        $student_head_wise_fee=array();
        $student_fee=array();
        $i=0;
        foreach($students as $student){
            
                        $tranjection=StudentFeeTansaction::where('student_code',$student->student_code)
                            ->where('session_id',$session_id)
                            ->where('version_id',$version_id)
                            ->where('class_code',$class_code)
                            ->where('month',$month)
                            ->where('fee_for',2)
                            ->first();
                            $udpdate=array(
                                'amount'=>$categoryamount[$student->category_id]['amount']??$categoryamount[1]['amount'],
                                'updated_by'=>Auth::user()->id,
                                'updated_at'=>date('Y-m-d H:s:i'),
                            );
                            if($tranjection){
                                DB::table('student_fee_tranjection')->where('id',$tranjection->id)->update($udpdate);
                                
                                $tranjectionHead=StudentHeadWiseFee::where('student_code',$student->student_code)
                                ->where('session_id',$session_id)
                                ->where('version_id',$version_id)
                                ->where('class_code',$class_code)
                                ->where('month',$month)
                                ->where('fee_for',2)
                                ->first();
                                DB::table('student_head_wise_fee')->where('id',$tranjectionHead->id)->update($udpdate);
                            }else{
                                $student_head_wise_fee[$i]=array(
                                    'student_code'=>$student->student_code,
                                    'session_id'=>$session_id,
                                    'fee_for'=>2,
                                    'version_id'=>$version_id,
                                    'class_id'=>$class_code,
                                    'class_code'=>$class_code,
                                    'category_id'=>$student->category_id,
                                    'head_id'=>$categoryamount[$student->category_id]['heads']??$categoryamount[1]['heads'],
                                    'unit'=>1,
                                    'month'=>$month,
                                    'amount'=>$categoryamount[$student->category_id]['amounts']??$categoryamount[1]['amounts'],
                                    'created_by'=>Auth::user()->id
                                );
                                $student_fee[$i++]=array(
                                    'student_code'=>$student->student_code,
                                    'fee_for'=>2,
                                    'session_id'=>$session_id,
                                    'version_id'=>$version_id,
                                    'class_id'=>$class_code,
                                    'class_code'=>$class_code,
                                    'category_id'=>$student->category_id,
                                    'head_id'=>null,
                                    'month'=>$month,
                                    'amount'=>$categoryamount[$student->category_id]['amount']??$categoryamount[1]['amount'],
                                    'created_by'=>Auth::user()->id
                                );
                            }
        }
       
        if(count($student_head_wise_fee)>0){
            DB::table('student_head_wise_fee')->insert($student_head_wise_fee);
        }
        if(count($student_fee)>0){
            DB::table('student_fee_tranjection')->insert($student_fee);
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
