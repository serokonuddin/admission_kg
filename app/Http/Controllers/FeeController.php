<?php

namespace App\Http\Controllers;
use App\Models\Fee;
use App\Models\PaymentFinal;
use App\Models\ClassCategoryHeadFee;
use App\Models\Attendance\Attendance;
use App\Models\sttings\Sessions;
use App\Models\sttings\Shifts;
use App\Models\sttings\Classes;
use App\Models\sttings\Sections;
use App\Models\sttings\Versions;
use App\Models\Student\Student;
use App\Models\Student\StudentActivity;
use App\Models\sttings\Category;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeHeadFee;
use App\Models\Employee\EmployeeFeeTranjection;
use App\Models\Finance\StudentFeeTansaction;
use App\Models\Finance\StudentHeadWiseFee;
use App\Exports\CategoryWiseHeadFeeExport;
use App\Exports\StudentFeeHeadWiseExport;
use App\Imports\StudentFeeStatusUpdate;
use App\Imports\ClassCategoryWiseHeadFeeImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use DB;
use DateTime;
use Auth;

class FeeController extends Controller
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
        Session::put('activesubmenu','fh');
        
        $fees=Fee::all();
        return view('fee.feehead',compact('fees'));
    }
    public function getCategoryWiseHeadFeeExport(Request $request){
        if(Auth::user()->group_id!=2){
            return 1;
        }
        $effective_from=$request->effective_from;
        
        $head_id=$request->head_id;
       
        $head=$request->head;
        $session_id=$request->session_id;
        $version_id=$request->version_id;
        $class_code=$request->class_code;
        $category_id=$request->category_id;
        $is_male_female=$request->is_male_female;
        

        $session=$request->session;
        $version=$request->version;
        $classes=$request->classes;
        $category=$request->category;
        $xltext=$request->xltext;
       
        return Excel::download(new CategoryWiseHeadFeeExport($head_id,$head,$effective_from, $session_id,$version_id,$class_code,$category_id,$is_male_female,$session,$version,$classes,$category,$xltext), $xltext.'.xlsx');
        
    }
    public function getHeadWiseStudentFeeExport(Request $request){
        if(Auth::user()->group_id!=2){
            return 1;
        }
        $month=$request->month;
        $month_name=$request->month_name;
        
        $head_id=$request->head_id;
       
        $head_name=$request->head_name;
        $session_id=$request->session_id;
        $class_code=$request->class_code;
        

        $session_name=$request->session_name;
        $class_name=$request->class_name;
        $status=$request->status;
        
        return Excel::download(new StudentFeeHeadWiseExport($head_id,$month,$session_id,$class_code,$head_name,$session_name,$class_name,$month_name,$status), $session_name.'_'.$class_name.'_'.$head_name.'_'.$month_name.'.xlsx');
        
    }
    public function ClassCategoryWiseHeadFeeImport(Request $request)
    {
        if(Auth::user()->group_id!=2){
            return 1;
        }
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);
        if ($request->hasFile('file')) {
            $destinationPath = 'classcategoryhead';
            $myimage = date('YmdHi').$request->file->getClientOriginalName();
            $request->file->move(public_path($destinationPath), $myimage);
            $file=public_path($destinationPath).'/'.$myimage;
            //$this->saveXLList($file,$request->all());

            Excel::import(new ClassCategoryWiseHeadFeeImport, $file);

            return back()->with('success', 'Data imported successfully.');
        }
        
    }
    /**
     * Show the form for creating a new resource.
     */
    public function feeHeadamountsave(Request $request){
        if(Auth::user()->group_id!=2){
            return 1;
        }
        $id=$request->id;
        $validated=$request->validate([
                'session_id' => 'required',
                'version_id' => 'required',
                'class_id' => 'required',
                'category_id' => 'required',
                'head_id' => 'required',
                'amount' => 'required',
                'effective_from' => 'required',
        ]);
        $class=DB::table('classes')
                ->where('id',$request->class_id)
                ->first();
        
            $validated['is_admission']=0;
        
        if($id==0){
            
            $validated['class_code']=$request->class_id;
            $validated['created_by']=Auth::user()->id;
            ClassCategoryHeadFee::insert($validated);
            $sms="Successfully Inserted";
        }else{
            $validated['class_code']=$request->class_id;
            $validated['updated_by']=Auth::user()->id;
            ClassCategoryHeadFee::where('id',$id)->update($validated);
            $sms="Successfully Updated";
        }
        return redirect(route('feeHeadamount'))->with('success',$sms);
    }
    public function categorywiseheaddelete($id){
        if(Auth::user()->group_id!=2){
            return 1;
        }
        ClassCategoryHeadFee::where('id',$id)->delete();
        return 1;
    }
    public function feeHeadamount(){
        if(Auth::user()->group_id!=2){
            return 1;
        }
        $sessions=Sessions::where('active',1)->first();
        $versions=Versions::where('active',1)->get();
        $shifts=Shifts::where('active',1)->get();
        //$shifts=Shifts::where('active',1)->get();
        $categories=Category::where('type',2)->where('active',1)->get();
        //$classes=Classes::all();
        $payments=ClassCategoryHeadFee::with([
             'session'
             ,'version'
             ,'shift'
             ,'classes'
             ,'category'
             ,'head'
        ]);
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
    
        
        Session::put('activemenu','finance');
        Session::put('activesubmenu','fha');
      
        $fees=Fee::where('head_type',1)->get();
        return view('fee.categorywiseheadfee',compact('fees','payments','categories','sessions','versions','shifts'));
    }
    public function studentFeeGenerate(Request $request){
        if(Auth::user()->group_id!=2){
            return 1;
        }
        $sessions=Sessions::where('active',1)->first();
        $versions=Versions::where('active',1)->get();
        $shifts=Shifts::where('active',1)->get();
        $categories=Category::where('type',2)->where('active',1)->get();
        $classes=[];
        $studentfees=[];
        $fees=[];
        $peremiter=$request->all();
        $month='';
        $class_id='';
        
        if(!empty($peremiter) && $peremiter['class_id']!=''){
            
            $studentfees=StudentHeadWiseFee::
            select('first_name','sms_notification','roll','student_head_wise_fee.*','section_name')
            ->join('students','students.student_code','=','student_head_wise_fee.student_code')
            ->join('student_activity','student_activity.student_code','=','student_head_wise_fee.student_code')
            ->join('sections','sections.id','=','student_activity.section_id')
            ->where('student_head_wise_fee.session_id',$sessions->id)
            ->where('student_head_wise_fee.class_code',$peremiter['class_id']);
            if($peremiter['month']){
                $studentfees=$studentfees->where('month',$peremiter['month']);
            }
            if($peremiter['version_id']){
                $studentfees=$studentfees->where('student_head_wise_fee.version_id',$peremiter['version_id']);
            }
            $studentfees=$studentfees->where('fee_for',1);
            $studentfees=$studentfees->get();
           
            $class_id=$peremiter['class_id'];
            $month=$peremiter['month'];
        }
        $fees=Fee::where('head_type',1)->get();
        $fees=collect($fees)->groupBy('id');
       
        
        
        
        Session::put('activemenu','finance');
        Session::put('activesubmenu','sfg');
        
        
        return view('fee.studentFeeGenerate',compact('class_id','fees','studentfees','month','categories','sessions','versions','shifts','classes'));
    }
    public function create(Request $request)
    {
        if(Auth::user()->group_id!=2){
            return 1;
        }
        $sessions=Sessions::where('active',1)->get();
        $versions=Versions::where('active',1)->get();
        $shifts=Shifts::where('active',1)->get();
        $categories=Category::where('type',2)->where('active',1)->get();
        $classes=Classes::where('active',1)
        ->where('session_id',$request->session_id)
        ->where('shift_id',$request->shift_id)
        ->where('version_id',$request->version_id)
        ->get();
        $sections=Sections::where('active',1)
        ->where('class_id',(int)$request->class_id)
        ->get();
        
        $class_id=$request->class_id;
        $shift_id=$request->shift_id;
        $version_id=$request->version_id;
        $category_id=$request->category_id;
        $section_id=$request->section_id;
        $student_code=$request->student_code;
        $start_month=$request->start_month;
        $start_year=$request->start_year;
        $end_year=$request->end_year;
        $end_month=$request->end_month;
        $status=$request->status;

        
       
       
        $payments=[];
        $fees=[];
        if($class_id && $class_id){
            // $payments=StudentFeeTansaction::with([
            //     'session'
            //      ,'version'
            //      ,'shift'
            //      ,'classes'
            //      ,'category'
            //      ,'student.studentActivity'
            // ]);
            // $payments->whereRaw('session_id = "'.$session_id.'"');
            // $start_date = date('Y-m-d',strtotime($sessions->session_name."-$request->month-01"));
            // $end_date = date('Y-m-t',strtotime($start_date));
            // $payments->whereRaw('class_id = "'.$class_id.'"');
            // $payments= $payments->get();

            
            if($request->class_id){
                $payments=StudentFeeTansaction::with('heads')->
                select('first_name','sms_notification','roll','student_fee_tranjection.*','section_name')
                ->join('students','students.student_code','=','student_fee_tranjection.student_code')
                ->join('student_activity','student_activity.student_code','=','student_fee_tranjection.student_code')
                ->join('sections','sections.id','=','student_activity.section_id');
                if($request->shift_id){
                    $payments=$payments->where('student_activity.shift_id',$shift_id);
                }
                if($request->version_id){
                    $payments=$payments->where('student_activity.version_id',$version_id);
                }
                if($request->student_code){
                    $payments=$payments->where('student_activity.student_code',$student_code);
                }
                
                if($request->start_month && $request->start_year){
                    $payments=$payments->where('student_activity.session_id','>=',$start_year)
                                ->where('student_fee_tranjection.month','>=',$start_month);
                }
                if($request->end_month && $request->end_year){
                    $payments=$payments->where('student_activity.session_id','<=',$end_year)
                                ->where('student_fee_tranjection.month','<=',$end_month);
                }

                if($request->status){
                    $payments=$payments->whereIn('student_fee_tranjection.status',explode(",", $request->status));
                }

                // ->where('student_fee_tranjection.session_id',$sessions[0]->id)
                // ->where('fee_for',$request->fee_for)
                // ->where('student_fee_tranjection.class_code',$request->class_id)
                // ->where('month',$request->month)
                $payments=$payments->get();
               
            }
            
            $fees=Fee::where('head_type',1)->get();
            $fees=collect($fees)->groupBy('id');
        }
        
        
        
        
        Session::put('activemenu','finance');
        Session::put('activesubmenu','sf');
        return view('fee.studentFee',compact('payments','fees','status','student_code','end_month','start_month','end_year','start_year','categories','sessions','versions','shifts','classes','sections','category_id','version_id','shift_id','class_id','section_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function studentFeeAutoGenerate(Request $request){
        if(Auth::user()->group_id!=2){
            return 1;
        }
        $class_code=$request->class_id;
        $version_id=$request->version_id;
        $session_id=$request->session_id;
        
        $check=DB::table('student_fee_tranjection')
                    ->where('session_id',$session_id)
                    ->where('version_id',$version_id)
                    ->where('class_code',$class_code)
                    ->where('fee_for',1)
                    ->first();
        //dd($check);
        if(empty($check)){
            $this->generateautofee($session_id,$version_id,$class_code);
        }else{
            
            return back()->with('success', 'Already Generate fee.');
        }
        return back()->with('success', 'Successfully Generate fee.');     
    }
    public function generateautofee($session_id,$version_id,$class_code){
        if($class_code==11 || $class_code==12){
            $months=array('07','08','09','10','11','12','01','02','03','04','05','06');
        }else{
            $months=array('01','02','03','04','05','06','07','08','09','10','11','12');
        }
        
        
        
        $categorys=DB::table('class_category_wise_head_fee')
                        ->join('fee_head','fee_head.id','=','class_category_wise_head_fee.head_id')
                        ->where('version_id',$version_id)
                        ->where('class_code',$class_code)
                        ->where('class_category_wise_head_fee.status',1)
                        ->where('is_system_generated',1)
                        ->where('payment_type',1)
                        ->where('fee_head.status',1)
                        ->orderBy('class_category_wise_head_fee.id','desc')
                        ->get();
        $categorys=collect($categorys)->groupBy('category_id');
        
        $i=0;
        $j=0;
        foreach($months as $v=>$month){
            foreach($categorys as $key=>$category){
                            
                $totalpayment=0;
                $heads='';
                $headamounts='';
                foreach($category as $k=>$head){
                        
                        // $totalpayment+=$head->amount;
                        // if($k==0){
                        //     $heads.=$head->head_id;
                        //     $headamounts.=$head->amount;
                        // }else{
                        //     $heads.=','.$head->head_id;
                        //     $headamounts.=','.($head->amount??0);
                        // }
                        
                    
                    //dd($headamounts,$totalpayment,$heads);
                    
                // $payment_final_id=23;
                    $students=DB::table('student_activity')
                    ->where('session_id',$session_id)
                    ->where('version_id',$version_id)
                    ->where('class_code',$class_code)
                    ->where('category_id',$key)->pluck('student_code')->toArray();
                    
                    foreach($students as $student_code){
                        
                        $student_head_wise_fee[$i++]=array(
                                    'student_code'=>$student_code,
                                    'fee_for'=>1,
                                    'session_id'=>$session_id,
                                    'version_id'=>$version_id,
                                    'class_id'=>$class_code,
                                    'class_code'=>$class_code,
                                    'category_id'=>$key,
                                    'head_id'=>$head->head_id,
                                    'headid'=>$head->head_id,
                                    'unit'=>1,
                                    'month'=>$month,
                                    'month_start_date'=>date('Y-'.$month.'-01'),
                                    'amount'=>$headamounts,
                                    'created_by'=>Auth::user()->id
                                );
                        $student_fee[$j++]=array(
                            'student_code'=>$student_code,
                            'fee_for'=>1,
                            'session_id'=>$session_id,
                            'version_id'=>$version_id,
                            'class_id'=>$class_code,
                            'class_code'=>$class_code,
                            'category_id'=>$key,
                            'month'=>$month,
                            'headid'=>$head->head_id,
                            'head_id'=>$head->head_id,
                            'month_start_date'=>date('Y-'.$month.'-01'),
                            'amount'=>$totalpayment,
                            'created_by'=>Auth::user()->id
                        );
                        
                    }
                }
            }
        }
        
        
        if(count($student_head_wise_fee)>0){
            DB::table('student_head_wise_fee')->insert($student_head_wise_fee);
        }
        if(count($student_fee)>0){
            DB::table('student_fee_tranjection')->insert($student_fee);
        }
    }
    public function sessionCharge($request){
        if(Auth::user()->group_id!=2){
            return 1;
        }
        $totalpayment=0;
            $i=0;
            $j=0;
            $sessions=DB::table('sessions')->where('active',1)->first();
            $versions=DB::table('versions')->where('active',1)->orderBy('id','asc')->get();
            $check=DB::table('student_fee_tranjection')->where('fee_for',$request->fee_for)
            ->where('session_id',$sessions->id)
            ->where('class_code',$request->class_id)
            ->where('month',$request->month)->first();
            if($check){
                return  $sms="Already Generate fee";
                return redirect(route('studentFeeGenerate'))->with('error',$sms);
            }
            $student_head_wise_fee=[];
            $student_fee=[];
            foreach($versions as $version){
                
                        $categorys=DB::table('class_category_wise_head_fee')
                        ->where('session_id',$sessions->id)
                        ->where('version_id',$version->id)
                        ->where('class_code',$request->class_id)
                        ->where('month','<=',date('m'))
                        ->where('status',1)
                        ->orderBy('id','desc')
                        ->get();
                        $categorys=collect($categorys)->groupBy('category_id');
                        
                        foreach($categorys as $key=>$category){
                            
                            $totalpayment=0;
                            $heads='';
                            $headamounts='';
                            foreach($category as $k=>$head){
                                
                                $totalpayment+=$head->amount;
                                if($k==0){
                                    $heads.=$head->head_id;
                                    $headamounts.=$head->amount;
                                }else{
                                    $heads.=','.$head->head_id;
                                    $headamounts.=','.$head->amount;
                                }
                                
                            }
                            
                            $payment_fee=array(
                                'session_id'=>$sessions->id,
                                'version_id'=>$version->id,
                                'class_id'=>$request->class_id,
                                'category_id'=>$key,
                                'payment_type'=>1,
                                'month'=>$request->month,
                                'amount'=>$totalpayment,
                                'head_id'=>$heads,
                                'created_by'=>Auth::user()->id
                            );
                            
                            $payment_final_id=DB::table('payment_final')->insertGetId($payment_fee);
                           // $payment_final_id=23;
                            $students=DB::table('student_activity')
                            ->where('session_id',$sessions->id)
                            ->where('version_id',$version->id)
                            ->where('class_code',$request->class_id)
                            ->where('category_id',$key)->pluck('student_code')->toArray();
                            
                            foreach($students as $student_code){
                                
                                $student_head_wise_fee[$i++]=array(
                                            'payment_final_id'=>$payment_final_id,
                                            'student_code'=>$student_code,
                                            'session_id'=>$sessions->id,
                                            'version_id'=>$version->id,
                                            'class_id'=>$request->class_id,
                                            'class_code'=>$request->class_id,
                                            'category_id'=>$key,
                                            'head_id'=>$heads,
                                            'unit'=>1,
                                            'amount'=>$headamounts,
                                            'created_by'=>Auth::user()->id
                                        );
                                $student_fee[$j++]=array(
                                    'common_id'=>$payment_final_id,
                                    'student_code'=>$student_code,
                                    'session_id'=>$sessions->id,
                                    'version_id'=>$version->id,
                                    'class_id'=>$request->class_id,
                                    'class_code'=>$request->class_id,
                                    'category_id'=>$key,
                                    'month'=>$request->month,
                                    'amount'=>$totalpayment,
                                    'created_by'=>Auth::user()->id
                                );
                            }
                        }
                   
            }
           // dd($student_head_wise_fee,$student_fee);
            
        if(count($student_head_wise_fee)>0){
            DB::table('student_head_wise_fee')->insert($student_head_wise_fee);
        }
        if(count($student_fee)>0){
            DB::table('student_fee_tranjection')->insert($student_fee);
        }
    }
    public function tutionFee($request){
        if(Auth::user()->group_id!=2){
            return 1;
        }
        $totalpayment=0;
            $i=0;
            $j=0;
        $sessions=DB::table('sessions')->where('active',1)->first();
        $versions=DB::table('versions')->where('active',1)->orderBy('id','asc')->get();
        $check=DB::table('student_fee_tranjection')->where('fee_for',$request->fee_for)
            ->where('session_id',$sessions->id)
            ->where('class_code',$request->class_id)
            ->where('month',$request->month)->first();
        if($check){
            return $sms="Already Generate fee";
            return redirect(route('studentFeeGenerate'))->with('error',$sms);
        }
        $student_head_wise_fee=[];
        $student_fee=[];
        foreach($versions as $version){
                    $categorys=DB::table('class_category_wise_head_fee')
                    ->where('fee_for',$request->fee_for)
                    ->where('session_id',$sessions->id)
                    ->where('version_id',$version->id)
                    ->where('class_code',$request->class_id)
                    ->where('effective_from','<=',date('Y-m-d'))
                    ->where('status',1)
                    ->orderBy('effective_from','desc')
                    ->get();
                    
                    $categorys=collect($categorys)->groupBy('category_id');
                   
                    foreach($categorys as $key=>$category){
                        $tp=0;
                        $heads='';
                        $hm='';
                        foreach($category as $k=>$head){
                            if($head->head_id==1){
                                $tp+=$head->amount;
                                $hm.=$head->amount;
                                $heads=1;
                            }
                            
                            // if($k==0){
                            //     $heads.=$head->head_id;
                            // }else{
                            //     $heads.=','.$head->head_id;
                            // }
                            
                        }
                        
                        $payment_fee=array(
                            'fee_for'=>$request->fee_for,
                            'session_id'=>$sessions->id,
                            'version_id'=>$version->id,
                            'class_id'=>$request->class_id,
                            'category_id'=>$key,
                            'payment_type'=>1,
                            'month'=>$request->month,
                            'amount'=>$totalpayment,
                            'head_id'=>$heads,
                            'created_by'=>Auth::user()->id
                        );
                        $payment_final_id=DB::table('payment_final')->insertGetId($payment_fee);
                        $students=DB::table('student_activity')
                        ->where('session_id',$sessions->id)
                        ->where('version_id',$version->id)
                        ->where('class_code',$request->class_id)
                        ->where('category_id',$key)->pluck('student_code')->toArray();
                        foreach($students as $student_code){
                            $heads=1;
                            $headamounts=$hm;
                            $totalpayment=$tp;
                                $unit=1;
                                $start_date = date('Y-m-d',strtotime($sessions->session_name."-$request->month-01"));
                               
                                // Clone the start date and modify to get the last day of the month
                                $end_date = date('Y-m-t',strtotime($start_date));
                                
                                
                                    $unit=DB::table('attendances')->where('status',2)->where('student_code',$student_code)->whereBetween('attendance_date',[$start_date,$end_date])->count();
                                    $totalpayment+=(int)(($head->amount)*$unit);
                                    $headamounts.=','.(int)(($head->amount)*$unit);
                                    $heads.=',5';
                                
                                
                                    $unit=DB::table('attendances')->where('status',4)->where('student_code',$student_code)->whereBetween('attendance_date',[$start_date,$end_date])->count();
                                    $totalpayment+=(int)(($head->amount)*$unit);
                                    $headamounts.=','.(int)(($head->amount)*$unit);
                                    $heads.=',4';
                                
                                
                            
                           
                            $student_head_wise_fee[$i++]=array(
                                'payment_final_id'=>$payment_final_id,
                                'student_code'=>$student_code,
                                'fee_for'=>$request->fee_for,
                                'session_id'=>$sessions->id,
                                'version_id'=>$version->id,
                                'class_id'=>$request->class_id,
                                'class_code'=>$request->class_id,
                                'category_id'=>$key,
                                'head_id'=>$heads,
                                'unit'=>$unit,
                                'amount'=>$headamounts,
                                'created_by'=>Auth::user()->id
                            );
                            $student_fee[$j++]=array(
                                'common_id'=>$payment_final_id,
                                'student_code'=>$student_code,
                                'fee_for'=>$request->fee_for,
                                'session_id'=>$sessions->id,
                                'version_id'=>$version->id,
                                'class_id'=>$request->class_id,
                                    'class_code'=>$request->class_id,
                                'category_id'=>$key,
                                'month'=>$request->month,
                                'amount'=>$totalpayment,
                                'created_by'=>Auth::user()->id
                            );
                        }
                    }
        }
        //dd($student_head_wise_fee,$student_fee);
        
         if(count($student_head_wise_fee)>0){
            DB::table('student_head_wise_fee')->insert($student_head_wise_fee);
        }
        if(count($student_fee)>0){
            DB::table('student_fee_tranjection')->insert($student_fee);
        }
    }
    public function examFee($request){
        $totalpayment=0;
        $i=0;
        $j=0;
        $sessions=DB::table('sessions')->where('active',1)->first();
        $versions=DB::table('versions')->where('active',1)->orderBy('id','asc')->get();
        $check=DB::table('student_fee_tranjection')->where('fee_for',$request->fee_for)
        ->where('session_id',$sessions->id)
        ->where('class_code',$request->class_id)
        ->where('month',$request->month)->first();
        if($check){
            return $sms="Already Generate fee";
            return redirect(route('studentFeeGenerate'))->with('error',$sms);
        }
        $student_head_wise_fee=[];
        $student_fee=[];
        foreach($versions as $version){
            
                    $categorys=DB::table('class_category_wise_head_fee')
                    ->where('fee_for',$request->fee_for)
                    ->where('session_id',$sessions->id)
                    ->where('version_id',$version->id)
                    ->where('class_code',$request->class_id)
                    ->whereRaw('ifnull(effective_from,0)!=0')
                    ->where('effective_from','<=',date('Y-m-d'))
                    ->where('status',1)
                    ->orderBy('id','desc')
                    ->get();
                   
                    $categorys=collect($categorys)->groupBy('category_id');
                    
                    foreach($categorys as $key=>$category){
                        
                        $totalpayment=0;
                        $heads='';
                        $headamounts='';
                        foreach($category as $k=>$head){
                            
                            $totalpayment+=$head->amount;
                            if($k==0){
                                $heads.=$head->head_id;
                                $headamounts.=$head->amount;
                            }else{
                                $heads.=','.$head->head_id;
                                $headamounts.=','.$head->amount;
                            }
                            
                        }
                        
                        $payment_fee=array(
                            'fee_for'=>$request->fee_for,
                            'session_id'=>$sessions->id,
                            'version_id'=>$version->id,
                            'class_id'=>$request->class_id,
                            'category_id'=>($key=='')?null:$key,
                            'payment_type'=>1,
                            'month'=>$request->month,
                            'amount'=>$totalpayment,
                            'head_id'=>$heads,
                            'created_by'=>Auth::user()->id
                        );
                        
                        $payment_final_id=DB::table('payment_final')->insertGetId($payment_fee);
                       // $payment_final_id=23;
                        $students=DB::table('student_activity')
                        ->where('session_id',$sessions->id)
                        ->where('version_id',$version->id)
                        ->where('class_code',$request->class_id)
                        ->pluck('student_code')->toArray();
                        
                        foreach($students as $student_code){
                            
                            $student_head_wise_fee[$i++]=array(
                                        'payment_final_id'=>$payment_final_id,
                                        'student_code'=>$student_code,
                                        'fee_for'=>$request->fee_for,
                                        'session_id'=>$sessions->id,
                                        'version_id'=>$version->id,
                                        'class_id'=>$request->class_id,
                                        'class_code'=>$request->class_id,
                                        'category_id'=>($key=='')?null:$key,
                                        'head_id'=>$heads,
                                        'unit'=>1,
                                        'amount'=>$headamounts,
                                        'created_by'=>Auth::user()->id
                                    );
                            $student_fee[$j++]=array(
                                'common_id'=>$payment_final_id,
                                'student_code'=>$student_code,
                                'fee_for'=>$request->fee_for,
                                'session_id'=>$sessions->id,
                                'version_id'=>$version->id,
                                'class_id'=>$request->class_id,
                                    'class_code'=>$request->class_id,
                                'category_id'=>($key=='')?null:$key,
                                'month'=>$request->month,
                                'amount'=>$totalpayment,
                                'created_by'=>Auth::user()->id
                            );
                        }
                    }
               
        }
       // dd($student_head_wise_fee,$student_fee);
        
         if(count($student_head_wise_fee)>0){
            DB::table('student_head_wise_fee')->insert($student_head_wise_fee);
        }
        if(count($student_fee)>0){
            DB::table('student_fee_tranjection')->insert($student_fee);
        }
    }
    public function governmentCharge($request){
        if(Auth::user()->group_id!=2){
            return 1;
        }
        $totalpayment=0;
            $i=0;
            $j=0;
            $sessions=DB::table('sessions')->where('active',1)->first();
            $versions=DB::table('versions')->where('active',1)->orderBy('id','asc')->get();
            $check=DB::table('student_fee_tranjection')->where('fee_for',$request->fee_for)
            ->where('session_id',$sessions->id)
            ->where('class_code',$request->class_id)
            ->where('month',$request->month)->first();
            if($check){
                return $sms="Already Generate fee";
               
            }
            $student_head_wise_fee=[];
            $student_fee=[];
            foreach($versions as $version){
                
                        $categorys=DB::table('class_category_wise_head_fee')
                        ->where('fee_for',$request->fee_for)
                        ->where('session_id',$sessions->id)
                        ->where('version_id',$version->id)
                        ->where('class_code',$request->class_id)
                        ->where('month','<=',date('m'))
                        ->where('status',1)
                        ->orderBy('id','desc')
                        ->get();
                        
                        $categorys=collect($categorys)->groupBy('gender');
                       
                        foreach($categorys as $key=>$category){
                           
                            $totalpayment=0;
                            $heads='';
                            $headamounts='';
                            foreach($category as $k=>$head){
                                
                                $totalpayment+=$head->amount;
                                if($k==0){
                                    $heads.=$head->head_id;
                                    $headamounts.=$head->amount;
                                }else{
                                    $heads.=','.$head->head_id;
                                    $headamounts.=','.$head->amount;
                                }
                                
                            }
                           
                            $payment_fee=array(
                                'fee_for'=>$request->fee_for,
                                'session_id'=>$sessions->id,
                                'version_id'=>$version->id,
                                'class_id'=>$request->class_id,
                                'category_id'=>($key=='')?null:$key,
                                'payment_type'=>1,
                                'month'=>$request->month,
                                'amount'=>$totalpayment,
                                'head_id'=>$heads,
                                'created_by'=>Auth::user()->id
                            );
                           
                            $payment_final_id=DB::table('payment_final')->insertGetId($payment_fee);
                           // $payment_final_id=23;
                            $students=DB::table('student_activity')
                            ->join('students','students.student_code','=','student_activity.student_code')
                            ->where('session_id',$sessions->id)
                            ->where('version_id',$version->id)
                            ->where('class_code',$request->class_id)
                            ->where('gender',$key)
                            ->pluck('student_activity.student_code')->toArray();
                            
                            foreach($students as $student_code){
                                
                                $student_head_wise_fee[$i++]=array(
                                            'payment_final_id'=>$payment_final_id,
                                            'student_code'=>$student_code,
                                            'fee_for'=>$request->fee_for,
                                            'session_id'=>$sessions->id,
                                            'version_id'=>$version->id,
                                            'class_id'=>$request->class_id,
                                            'class_code'=>$request->class_id,
                                            'category_id'=>($key=='')?null:$key,
                                            'head_id'=>$heads,
                                            'unit'=>1,
                                            'amount'=>$headamounts,
                                            'created_by'=>Auth::user()->id
                                        );
                               
                                $student_fee[$j++]=array(
                                    'common_id'=>$payment_final_id,
                                    'student_code'=>$student_code,
                                    'fee_for'=>$request->fee_for,
                                    'session_id'=>$sessions->id,
                                    'version_id'=>$version->id,
                                    'class_id'=>$request->class_id,
                                    'class_code'=>$request->class_id,
                                    'category_id'=>($key=='')?null:$key,
                                    'month'=>$request->month,
                                    'amount'=>$totalpayment,
                                    'created_by'=>Auth::user()->id
                                );
                            }
                        }
                   
            }
           
            if(count($student_head_wise_fee)>0){
                DB::table('student_head_wise_fee')->insert($student_head_wise_fee);
            }
            if(count($student_fee)>0){
                DB::table('student_fee_tranjection')->insert($student_fee);
            }
          
    }
    public function boardFee($request){
        if(Auth::user()->group_id!=2){
            return 1;
        }
        $totalpayment=0;
        $i=0;
        $j=0;
        $sessions=DB::table('sessions')->where('active',1)->first();
        $versions=DB::table('versions')->where('active',1)->orderBy('id','asc')->get();
        $check=DB::table('student_fee_tranjection')->where('fee_for',$request->fee_for)
        ->where('session_id',$sessions->id)
        ->where('class_code',$request->class_id)
        ->where('month',$request->month)->first();
        if($check){
           return $sms="Already Generate fee";
            return redirect(route('studentFeeGenerate'))->with('error',$sms);
        }
        $student_head_wise_fee=[];
        $student_fee=[];
        foreach($versions as $version){
            
                    $categorys=DB::table('class_category_wise_head_fee')
                    ->where('fee_for',$request->fee_for)
                    ->where('session_id',$sessions->id)
                    ->where('version_id',$version->id)
                    ->where('class_code',$request->class_id)
                    ->where('status',1)
                    ->orderBy('id','desc')
                    ->get();
                    $categorys=collect($categorys)->groupBy('category_id');
                    
                    foreach($categorys as $key=>$category){
                        
                        $totalpayment=0;
                        $heads='';
                        $headamounts='';
                        foreach($category as $k=>$head){
                            
                            $totalpayment+=$head->amount;
                            if($k==0){
                                $heads.=$head->head_id;
                                $headamounts.=$head->amount;
                            }else{
                                $heads.=','.$head->head_id;
                                $headamounts.=','.$head->amount;
                            }
                            
                        }
                        
                        $payment_fee=array(
                            'fee_for'=>$request->fee_for,
                            'session_id'=>$sessions->id,
                            'version_id'=>$version->id,
                            'class_id'=>$request->class_id,
                            'category_id'=>($key=='')?null:$key,
                            'payment_type'=>1,
                            'month'=>$request->month,
                            'amount'=>$totalpayment,
                            'head_id'=>$heads,
                            'created_by'=>Auth::user()->id
                        );
                        
                        $payment_final_id=DB::table('payment_final')->insertGetId($payment_fee);
                       // $payment_final_id=23;
                        $students=DB::table('student_activity')
                        ->where('session_id',$sessions->id)
                        ->where('version_id',$version->id)
                        ->where('class_code',$request->class_id)
                        ->pluck('student_code')->toArray();
                        
                        foreach($students as $student_code){
                            
                            $student_head_wise_fee[$i++]=array(
                                        'payment_final_id'=>$payment_final_id,
                                        'student_code'=>$student_code,
                                        'fee_for'=>$request->fee_for,
                                        'session_id'=>$sessions->id,
                                        'version_id'=>$version->id,
                                        'class_id'=>$request->class_id,
                                        'class_code'=>$request->class_id,
                                        'category_id'=>($key=='')?null:$key,
                                        'head_id'=>$heads,
                                        'unit'=>1,
                                        'amount'=>$headamounts,
                                        'created_by'=>Auth::user()->id
                                    );
                            $student_fee[$j++]=array(
                                'common_id'=>$payment_final_id,
                                'student_code'=>$student_code,
                                'fee_for'=>$request->fee_for,
                                'session_id'=>$sessions->id,
                                'version_id'=>$version->id,
                                'class_id'=>$request->class_id,
                                'class_code'=>$request->class_id,
                                'category_id'=>($key=='')?null:$key,
                                'month'=>$request->month,
                                'amount'=>$totalpayment,
                                'created_by'=>Auth::user()->id
                            );
                        }
                    }
               
        }
       // dd($student_head_wise_fee,$student_fee);
       
         if(count($student_head_wise_fee)>0){
            DB::table('student_head_wise_fee')->insert($student_head_wise_fee);
        }
        if(count($student_fee)>0){
            DB::table('student_fee_tranjection')->insert($student_fee);
        }
    }
    public function coachingFee($request){
        
    }
    public function conveyanceFee($request){
        
    }
    public function studentWelfare($request){
        if(Auth::user()->group_id!=2){
            return 1;
        }
        $totalpayment=0;
        $i=0;
        $j=0;
        $sessions=DB::table('sessions')->where('active',1)->first();
        $versions=DB::table('versions')->where('active',1)->orderBy('id','asc')->get();
        $check=DB::table('student_fee_tranjection')->where('fee_for',$request->fee_for)
        ->where('session_id',$sessions->id)
        ->where('class_code',$request->class_id)
        ->where('month',$request->month)->first();
        if($check){
            return $sms="Already Generate fee";
             redirect(route('studentFeeGenerate'))->with('error',$sms);
        }
       
        foreach($versions as $version){
            
                    $categorys=DB::table('class_category_wise_head_fee')
                    ->where('fee_for',$request->fee_for)
                    ->where('session_id',$sessions->id)
                    ->where('version_id',$version->id)
                    ->where('class_code',$request->class_id)
                    ->where('effective_from','<=',date('Y-m-d'))
                    ->where('status',1)
                    ->orderBy('id','desc')
                    ->get();
                    $categorys=collect($categorys)->groupBy('category_id');
                    
                    foreach($categorys as $key=>$category){
                        
                        $totalpayment=0;
                        $heads='';
                        $headamounts='';
                        foreach($category as $k=>$head){
                            
                            $totalpayment+=$head->amount;
                            if($k==0){
                                $heads.=$head->head_id;
                                $headamounts.=$head->amount;
                            }else{
                                $heads.=','.$head->head_id;
                                $headamounts.=','.$head->amount;
                            }
                            
                        }
                        
                        $payment_fee=array(
                            'fee_for'=>$request->fee_for,
                            'session_id'=>$sessions->id,
                            'version_id'=>$version->id,
                            'class_id'=>$request->class_id,
                            'category_id'=>$key,
                            'payment_type'=>1,
                            'month'=>$request->month,
                            'amount'=>$totalpayment,
                            'head_id'=>$heads,
                            'created_by'=>Auth::user()->id
                        );
                        
                        $payment_final_id=DB::table('payment_final')->insertGetId($payment_fee);
                       // $payment_final_id=23;
                        $students=DB::table('student_activity')
                        ->where('session_id',$sessions->id)
                        ->where('version_id',$version->id)
                        ->where('class_code',$request->class_id)
                        ->where('category_id',$key)->pluck('student_code')->toArray();
                        
                        foreach($students as $student_code){
                            
                            $student_head_wise_fee[$i++]=array(
                                        'payment_final_id'=>$payment_final_id,
                                        'student_code'=>$student_code,
                                        'fee_for'=>$request->fee_for,
                                        'session_id'=>$sessions->id,
                                        'version_id'=>$version->id,
                                        'class_id'=>$request->class_id,
                                        'class_code'=>$request->class_id,
                                        'category_id'=>$key,
                                        'head_id'=>$heads,
                                        'unit'=>1,
                                        'amount'=>$headamounts,
                                        'created_by'=>Auth::user()->id
                                    );
                            $student_fee[$j++]=array(
                                'common_id'=>$payment_final_id,
                                'student_code'=>$student_code,
                                'fee_for'=>$request->fee_for,
                                'session_id'=>$sessions->id,
                                'version_id'=>$version->id,
                                'class_id'=>$request->class_id,
                                'class_code'=>$request->class_id,
                                'category_id'=>$key,
                                'month'=>$request->month,
                                'amount'=>$totalpayment,
                                'created_by'=>Auth::user()->id
                            );
                        }
                    }
               
        }
       // dd($student_head_wise_fee,$student_fee);
        
         if(count($student_head_wise_fee)>0){
            DB::table('student_head_wise_fee')->insert($student_head_wise_fee);
        }
        if(count($student_fee)>0){
            DB::table('student_fee_tranjection')->insert($student_fee);
        }
    }
    public function EMIS($request){
        
    }
    public function MISC($request){
        
    }

    public function store(Request $request){
        if(Auth::user()->group_id!=2){
            return 1;
        }
       //  dd($request->all());
        
            //  $request->validate([
            //     'fee_for' => 'required',
            //     'session_id' => 'required',
            //     'version_id' => 'required',
            //     'shift_id' => 'required',
            //     'class_id' => 'required',
            //     'category_id' => 'required',
            //     'head_id' => 'required',
            // ]);
            $totalpayment=0;
            $i=0;
            $j=0;
        // foreach($request->head_id as $key=>$head_id){
        //  $amountext='amount'.$head_id;
        //     if($head_id!=5 && $head_id!=4){
        //         $totalpayment+=(int)$request->$amountext;
        //     }
         
        // }
        
        if($request->fee_for==2){
            $sms=$this->sessionCharge($request);
        }elseif($request->fee_for==3){
            $sms=$this->tutionFee($request);
        }elseif($request->fee_for==4){
            $sms=$this->examFee($request);
        }elseif($request->fee_for==5){
            $sms=$this->governmentCharge($request);
        }elseif($request->fee_for==6){
            $sms=$this->boardFee($request);
        }elseif($request->fee_for==7){
            $sms=$this->coachingFee($request);
        }elseif($request->fee_for==8){
            $sms=$this->conveyanceFee($request);
        }elseif($request->fee_for==9){
            $sms=$this->studentWelfare($request);
        }elseif($request->fee_for==10){
            $sms=$this->EMIS($request);
        }elseif($request->fee_for==11){
            $sms=$this->MISC($request);
        }
        if($sms=="Already Generate fee"){
            return redirect(route('studentFeeGenerate'))->with('error',$sms);
        }
        



        $sms="Successfully Generate";
        return redirect(route('fees.create'))->with('success',$sms);
    }
    public function viewStudentFee($id){
        $sessions=DB::table('sessions')->where('active',1)->first();
        //$payment_final=DB::table('payment_final')->where('id',$id)->first();
        $students=DB::table('student_fee_tranjection')
        ->leftjoin('students','students.student_code','=','student_fee_tranjection.student_code')
        ->student_fee_tranjection('versions','versions.id','=','student_fee_tranjection.version_id')
        ->student_fee_tranjection('sessions','sessions.id','=','student_fee_tranjection.session_id')
        ->student_fee_tranjection('classes','classes.id','=','student_fee_tranjection.class_id')
        ->student_fee_tranjection('shifts','shifts.id','=','student_fee_tranjection.shift_id')
        ->student_fee_tranjection('Category','category.id','=','student_fee_tranjection.category_id')
        ->select('students.first_name'
        ,'students.last_name'
        ,'students.photo'
        ,'student_fee_tranjection.*'
        ,'class_name'
        ,'Category.category_name'
        ,'shifts.shift_name'
        ,'sessions.session_name'
        ,'versions.version_name'
        )
        ->where('student_fee_tranjection.session_id',$sessions->id)
        ->get();
      
        return view('fee.viewStudentFee',compact('students'));
    }
    public function feeHead(Request $request)
    {
        
        $id=$request->id;
        try {
           
            if($id==0){
               
                $validated = $request->validate([
                    'head_name' => 'required',
                    'head_type' => 'required',
                    'is_expanse' => 'required',
                    'status' => 'required',
                ]);
            }else{
                $validated = $request->validate([
                    'head_name' => 'required',
                    'head_type' => 'required',
                    'is_expanse' => 'required',
                    'payment_type' => 'required',
                    'is_system_generated' => 'required',
                    'is_male_female' => 'required',
                    'status' => 'required',
                ]);
            }
            
            
            if($id==0){
                
                Fee::insert($validated);
                $sms="Successfully Inserted";
            }else{
               
                Fee::where('id',$id)->update($validated);
                $sms="Successfully Updated";
            }
            return redirect(route('fees.index'))->with('success',$sms);
          } catch (Exception $e) {
            
            return redirect(route('fees.index'))->with(['msg' => $e]);
          }
    }
    public function employeeSalaryGenerate(){
        $sessions=Sessions::where('active',1)->get();
        $versions=Versions::where('active',1)->get();
        $shifts=Shifts::where('active',1)->get();
        $categories=Category::where('type',2)->where('active',1)->get();
        $classes=[];
        
       
        
        Session::put('activemenu','finance');
        Session::put('activesubmenu','sfg');
        $month='';
        $fees=Fee::where('head_type',1)->get();
        return view('fee.employeeSalaryGenerate',compact('fees','month','categories','sessions','versions','shifts','classes'));
    }
    public function employeeSalaryGenerateStore(Request $request){
        $months=array(
            '01'=>'January',
            '02'=>'February',
            '03'=>'March',
            '04'=>'April',
            '05'=>'May',
            '06'=>'June',
            '07'=>'July',
            '08'=>'August',
            '09'=>'September',
            '10'=>'Octobar',
            '11'=>'November',
            '12'=>'December'
        );
        $sessions=DB::table('sessions')->where('active',1)->first();
        $versions=DB::table('versions')->where('active',1)->orderBy('id','asc')->get();
        $employees=EmployeeHeadFee::with('head')->with('employee')
                    ->selectRaw('employee_id,session_id,version_id,sum(ifnull(amount,0)) as amount')
                    ->whereIn('employee_id',function($q){
                        $q->select('id')
                        ->from('employees')
                        ->where('status', 1);
                    })
                    ->where('status',1)->groupBy('employee_id')->groupBy('session_id')->groupBy('version_id')->get();
        foreach($employees as $employee){
            $array=array(
                'employee_id'=>$employee->employee_id,
                'version_id'=>$employee->version_id,
                'session_id'=>$sessions->id,
                'month'=>$request->month,
                'amount'=>$employee->amount,
                'details'=>$employee->employee_name." ".$months[$request->month]." month salary",
                'created_by'=>Auth::user()->id
            );
            DB::table('employee_fee_tranjection')->insert($array);
        }
        $sms="Salary Generate Successfully";
        return redirect(route('employeeSalary'))->with('success',$sms);
        
    }
    public function employeeSalary(Request $request){
        $sessions=Sessions::where('active',1)->get();
        $versions=Versions::where('active',1)->get();
       
        $version_id=$request->version_id;
        $session_id=$request->session_id;
        $month=$request->month;
      
        $month=$request->month;
        $salaries=EmployeeFeeTranjection::with(['employee','employee.designation'])
        ->where('version_id',$version_id)
        ->where('session_id',$session_id)
        ->where('month', 'like', '%' . $month . '%')
        ->paginate(50);
        // $payments=PaymentFinal::with([
        //     'session'
        //      ,'version'
        //      ,'shift'
        //      ,'classes'
        //      ,'category'
        // ]);
        // if($session_id){
                    
        //     $payments->whereRaw('session_id = "'.$session_id.'"');
        // }
        // if($version_id){
        //     $payments->whereRaw('version_id = "'.$version_id.'"');
        // }
        
        
        // $payments= $payments->paginate(50);
        Session::put('activemenu','finance');
        Session::put('activesubmenu','sf');
        return view('fee.employeeSalary',compact('salaries','month','sessions','versions','session_id','version_id'));
    }
    
    /**
     * Display the specified resource.
     */
    public function feeCollection(Request $request)
    {
        $version_id=$request->version_id;
        $class_id=$request->class_id;
        $start_date=$request->start_date;
        $end_date=$request->end_date;
        $fee_id=$request->fee_id;
        
        $sessions=Sessions::where('active',1)->first();
        $versions=Versions::where('active',1)->get();
        $shifts=Shifts::where('active',1)->get();
        //$shifts=Shifts::where('active',1)->get();
        $fees=Fee::where('status',1)->get();
        //$classes=Classes::all();
        $students=StudentFeeTansaction::with(['headdata','version','shift','classes','category'])
        ->where('student_fee_tranjection.status','Complete')
        ->join('students','students.student_code','=','student_fee_tranjection.student_code');
        if($request->start_date && $request->end_date){
            $startDate = date('Y-m-d 00:00:00',strtotime($request->start_date));
            $endDate = date('Y-m-d 23:59:59',strtotime($request->end_date));
            $students=$students->whereBetween('student_fee_tranjection.updated_at', [$startDate, $endDate]);
        }else{
            $students=$students->where('student_fee_tranjection.updated_at', '>=', Carbon::now()->subDays(60));
            $start_date=date('Y-m-d',strtotime('-30 days'));
            $end_date=date('Y-m-d');
        }   
        
        if($request->version_id){
            $students=$students->where('student_fee_tranjection.version_id', $request->version_id);
        }
        if($request->class_id){
            $students=$students->where('student_fee_tranjection.class_code', $request->class_id);
        }
        if($request->fee_id){
            $students=$students->where('student_fee_tranjection.head_id', $request->fee_id);
        }
        if ($request->has('search')) {
            $students=$students
            ->where('students.email', 'like', '%' . $request->input('search') . '%')
            ->orWhere('students.first_name', 'like', '%' . $request->input('search') . '%')
            ->orWhere('students.student_code', 'like', '%' . $request->input('search') . '%')
            ->orWhere('students.sms_notification', 'like', '%' . $request->input('search') . '%')
            ->orWhere('students.father_name', 'like', '%' . $request->input('search') . '%');
        }
        $students=$students->orderBy('student_fee_tranjection.updated_at','desc')->paginate(50);
        
        if ($request->ajax()) {
            return view('fee.pagination', compact('students'))->render();
        }
        
        Session::put('activemenu','finance-report');
        Session::put('activesubmenu','fc');
        
        return view('fee.feeCollection',compact('versions','fees','fee_id','version_id','class_id','students','start_date','end_date'));
    }

    public function outstandingTuitionFee(Request $request)
    {
        $version_id=$request->version_id;
        $class_id=$request->class_id;
        $start_date=$request->start_date;
        $end_date=$request->end_date;
        $sessions=Sessions::where('active',1)->first();
        $versions=Versions::where('active',1)->get();
        $shifts=Shifts::where('active',1)->get();
        //$shifts=Shifts::where('active',1)->get();
        $categories=Category::where('type',2)->where('active',1)->get();
        //$classes=Classes::all();
        $students=StudentFeeTansaction::with(['headdata','version','shift','classes','category'])
        ->where('student_fee_tranjection.status','!=','Complete')
        ->whereNull('student_fee_tranjection.fee_ids')
        ->where('headid', 'like', '%,1%')
        ->join('students','students.student_code','=','student_fee_tranjection.student_code');
        if($request->start_date && $request->end_date){
            $startYear = date('Y-m-d 00:00:00',strtotime($request->start_date));
            $endYear = date('Y-m-d 23:59:59',strtotime($request->end_date));
            $students=$students->whereBetween('student_fee_tranjection.month_start_date', [$startDate, $endDate]);
        }else{
            $students=$students->where('student_fee_tranjection.month_start_date', '>=', Carbon::now()->subDays(30));
            $start_date=date('Y-m-d',strtotime('-30 days'));
            $end_date=date('Y-m-d');
        }   
        
        if($request->version_id){
            $students=$students->where('student_fee_tranjection.version_id', $request->version_id);
        }
        if($request->class_id){
            $students=$students->where('student_fee_tranjection.class_code', $request->class_id);
        }
        if ($request->has('search')) {
            $students=$students
            ->where('students.email', 'like', '%' . $request->input('search') . '%')
            ->orWhere('students.first_name', 'like', '%' . $request->input('search') . '%')
            ->orWhere('students.student_code', 'like', '%' . $request->input('search') . '%')
            ->orWhere('students.sms_notification', 'like', '%' . $request->input('search') . '%')
            ->orWhere('students.father_name', 'like', '%' . $request->input('search') . '%');
        }
        $students=$students->orderBy('student_fee_tranjection.month_start_date','asc')->paginate(50);
        
        if ($request->ajax()) {
            return view('fee.outstandingTuitionFeepagination', compact('students'))->render();
        }
        
        Session::put('activemenu','finance-report');
        Session::put('activesubmenu','otf');
      
        return view('fee.outstandingTuitionFee',compact('versions','version_id','class_id','students','start_date','end_date'));
    }
   

    public function outstandingDue(Request $request)
    {
        $version_id=$request->version_id;
        $class_id=$request->class_id;
        $start_date=$request->start_date;
        $end_date=$request->end_date;
        $sessions=Sessions::where('active',1)->first();
        $versions=Versions::where('active',1)->get();
        $shifts=Shifts::where('active',1)->get();
        //$shifts=Shifts::where('active',1)->get();
        $categories=Category::where('type',2)->where('active',1)->get();
        //$classes=Classes::all();
        $students=StudentFeeTansaction::with(['headdata','version','shift','classes','category'])
        ->where('student_fee_tranjection.status','!=','Complete')
        ->whereNull('student_fee_tranjection.fee_ids')
        ->join('students','students.student_code','=','student_fee_tranjection.student_code');
        if($request->start_date && $request->end_date){
            $startYear = date('Y-m-d 00:00:00',strtotime($request->start_date));
            $endYear = date('Y-m-d 23:59:59',strtotime($request->end_date));
            $students=$students->whereBetween('student_fee_tranjection.month_start_date', [$startDate, $endDate]);
        }else{
            $students=$students->where('student_fee_tranjection.month_start_date', '>=', Carbon::now()->subDays(30));
            $start_date=date('Y-m-d',strtotime('-30 days'));
            $end_date=date('Y-m-d');
        }   
        
        if($request->version_id){
            $students=$students->where('student_fee_tranjection.version_id', $request->version_id);
        }
        if($request->class_id){
            $students=$students->where('student_fee_tranjection.class_code', $request->class_id);
        }
        if ($request->has('search')) {
            $students=$students
            ->where('students.email', 'like', '%' . $request->input('search') . '%')
            ->orWhere('students.first_name', 'like', '%' . $request->input('search') . '%')
            ->orWhere('students.student_code', 'like', '%' . $request->input('search') . '%')
            ->orWhere('students.sms_notification', 'like', '%' . $request->input('search') . '%')
            ->orWhere('students.father_name', 'like', '%' . $request->input('search') . '%');
        }
        $students=$students->orderBy('student_fee_tranjection.month_start_date','asc')->paginate(50);
        
        if ($request->ajax()) {
            return view('fee.outstandingpagination', compact('students'))->render();
        }
        
        Session::put('activemenu','finance-report');
        Session::put('activesubmenu','oad');
      
        return view('fee.outstanding',compact('versions','version_id','class_id','students','start_date','end_date'));
    }

    public function outstandingTuitionFeeSummary(Request $request)
    {
        $version_id=$request->version_id;
        $class_id=$request->class_id;
        $start_date=$request->start_date;
        $end_date=$request->end_date;
        $sessions=Sessions::where('active',1)->first();
        $versions=Versions::where('active',1)->get();
        $shifts=Shifts::where('active',1)->get();
        //$shifts=Shifts::where('active',1)->get();
        $categories=Category::where('type',2)->where('active',1)->get();
        //$classes=Classes::all();
        $students=StudentFeeTansaction::with(['headdata','version','shift','classes','category'])
        ->where('student_fee_tranjection.status','!=','Complete')
        ->whereNull('student_fee_tranjection.fee_ids')
        ->where('headid', 'like', '%,1%')
        ->join('students','students.student_code','=','student_fee_tranjection.student_code');
        if($request->start_date && $request->end_date){
            $startYear = date('Y-m-d 00:00:00',strtotime($request->start_date));
            $endYear = date('Y-m-d 23:59:59',strtotime($request->end_date));
            $students=$students->whereBetween('student_fee_tranjection.month_start_date', [$startDate, $endDate]);
        }else{
            $students=$students->where('student_fee_tranjection.month_start_date', '>=', Carbon::now()->subDays(30));
            $start_date=date('Y-m-d',strtotime('-30 days'));
            $end_date=date('Y-m-d');
        }   
        
        if($request->version_id){
            $students=$students->where('student_fee_tranjection.version_id', $request->version_id);
        }
        if($request->class_id){
            $students=$students->where('student_fee_tranjection.class_code', $request->class_id);
        }
        if ($request->has('search')) {
            $students=$students
            ->where('students.email', 'like', '%' . $request->input('search') . '%')
            ->orWhere('students.first_name', 'like', '%' . $request->input('search') . '%')
            ->orWhere('students.student_code', 'like', '%' . $request->input('search') . '%')
            ->orWhere('students.sms_notification', 'like', '%' . $request->input('search') . '%')
            ->orWhere('students.father_name', 'like', '%' . $request->input('search') . '%');
        }
        $students=$students->paginate(50);
        
        if ($request->ajax()) {
            return view('fee.outstandingTuitionFeepaginationsummary', compact('students'))->render();
        }
        
        Session::put('activemenu','finance-report');
        Session::put('activesubmenu','otfs');
      
        return view('fee.outstandingTuitionFeesummary',compact('versions','version_id','class_id','students','start_date','end_date'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function feeHeadAmountView(Request $request)
    {
        Session::put('activemenu','finance');
        Session::put('activesubmenu','fhav');
        $sessions=Sessions::where('active',1)->first();
        $versions=Versions::where('active',1)->get();
        //$shifts=Shifts::where('active',1)->get();
        $categories=Category::where('type',2)->where('active',1)->get();
        //$classes=Classes::all();
        $version_id=$request->version_id;
        $shift_id=$request->shift_id;
        $class_id=$request->class_id;
        $category_id=$request->category_id;
        $session_id=$request->session_id;
        $head_id=$request->head_id;
        $effective_from=$request->effective_from;
        $payments=ClassCategoryHeadFee::with([
             'session'
             ,'version'
             ,'shift'
             ,'classes'
             ,'category'
             ,'head'
        ]);
        if($sessions){
                    
            $payments->whereRaw('session_id = "'.$sessions->id.'"');
        }
        // if($session_id){
        //     $payments->whereRaw('session_id = "'.$session_id.'"');
        // }
        if($version_id){
            $payments->whereRaw('version_id = "'.$version_id.'"');
        }
        // // if($shift_id){
        // //     $payments->whereRaw('shift_id = "'.$shift_id.'"');
        // // }
        if($class_id){
            $payments->whereRaw('class_code = "'.$class_id.'"');
        }
        
        if($category_id){
            $payments->whereRaw('category_id = "'.$category_id.'"');
        }
        if($head_id){
            $payments->whereRaw('head_id = "'.$head_id.'"');
        }
        if($effective_from){
            $payments->whereRaw('effective_from = "'.$effective_from.'"');
        }
        
        $payments= $payments->orderBy('id','desc')->get();
        $fees=Fee::where('head_type',1)->get();
        return view('fee.feeHeadAmountView',compact('categories','sessions','versions','payments','fees','session_id','version_id','class_id','head_id','category_id','effective_from'));
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function absentorletfee($session_id,$version_id,$class_code,$head_id,$month){
        
       
        $year = date('Y');

        // Start date of the month
        $startDate = date('Y-'.$month.'-01');
       
        // End date of the month
        $endDate = date('Y-m-t',strtotime($startDate));
        if($head_id==5){
            $status=2;
            $text='Absent Fee';
        }else{
            $status=4;
            $text='Late Fee';
        }
        // Query using whereBetween
        $records = Attendance::whereBetween('attendance_date', [$startDate, $endDate])
            ->selectRaw('count(id) count,student_code')
            ->where('status',$status)
            ->where('version_id',$version_id)
            ->where('class_code',$class_code)
            ->groupBy('student_code')
            ->get();
        $fine=DB::table('fine')->where('name',$text)->where('status',1)->first();
        $i=0;
        $student_head_wise_fee=array();
        $student_fee=array();
        foreach($records as $value){
            $student_code=$value->student_code;
            $headamounts=$fine->amount*$value->count;
                $tranjection=StudentFeeTansaction::where('student_code',$value->student_code)
                ->where('session_id',$session_id)
                ->where('version_id',$version_id)
                ->where('class_code',$class_code)
                ->where('head_id',$head_id)
                ->where('month',$month)
                ->first();
                $udpdate=array(
                    'amount'=>$headamounts,
                    'updated_by'=>Auth::user()->id,
                    'updated_at'=>date('Y-m-d H:s:i'),
                );
                if($tranjection){
                    DB::table('student_fee_tranjection')->where('id',$tranjection->id)->update($udpdate);
                    
                    $tranjectionHead=StudentHeadWiseFee::where('student_code',$value->student_code)
                    ->where('session_id',$session_id)
                    ->where('version_id',$version_id)
                    ->where('class_code',$class_code)
                    ->where('head_id',$head_id)
                    ->where('month',$month)
                    ->first();
                    DB::table('student_head_wise_fee')->where('id',$tranjectionHead->id)->update($udpdate);
                }
            
            
            if($tranjection){
                
            }else{
                $student_head_wise_fee[$i]=array(
                    'student_code'=>$student_code,
                    'session_id'=>$session_id,
                    'version_id'=>$version_id,
                    'class_id'=>$class_code,
                    'class_code'=>$class_code,
                    'head_id'=>$head_id,
                    'headid'=>$head_id,
                    'unit'=>1,
                    'month_start_date'=>date('Y-'.$month.'-01'),
                    'month'=>$month,
                    'amount'=>$headamounts,
                    'created_by'=>Auth::user()->id
                );
                $student_fee[$i++]=array(
                    'student_code'=>$student_code,
                    'session_id'=>$session_id,
                    'version_id'=>$version_id,
                    'class_id'=>$class_code,
                    'class_code'=>$class_code,
                    'head_id'=>$head_id,
                    'headid'=>$head_id,
                    'month_start_date'=>date('Y-'.$month.'-01'),
                    'month'=>$month,
                    'amount'=>$headamounts,
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
        return 1;

    }
    public function feeclasswiseUpdateSave(Request $request){
        //dd($request->all());
        $class_code=$request->class_id;
        $session_id=$request->session_id;
        $head_id=$request->head_id;
        $is_male_female=$request->is_male_female;
        $amount=$request->amount;
        $female_amount=$request->female_amount??'';
        $versions=DB::table('versions')->orderBy('id','asc')->get();
        $check=DB::table('student_head_wise_fee')
                    ->where('session_id',$session_id)
                    ->where('head_id',$head_id)
                    ->where('class_code',$class_code)
                    ->first();
       
        if(empty($check)){
            foreach($versions as $version){
                if($head_id==5 || $head_id==4){
                    $month=$request->month;
                    $this->absentorletfee($session_id,$version->id,$class_code,$head_id,$month);
                }else{
                    $this->generateYearlyFee($session_id,$version->id,$class_code,$head_id,$amount,$female_amount,$update=0);
                }
            }
            

        }else{
            if($is_male_female==1){
                if(!empty($amount) && !empty($female_amount)){
                    foreach($versions as $version){
                        $this->generateYearlyFee($session_id,$version->id,$class_code,$head_id,$amount,$female_amount,$update=1);
                    }
                }
            }elseif(!empty($amount)){
                foreach($versions as $version){
                    $this->generateYearlyFee($session_id,$version->id,$class_code,$head_id,$amount,$female_amount,$update=1);
                }
            }
            if($check){
                return redirect(url('admin/feeClassWiseUpdate/' . $head_id))->with(['msg' => 'Already Generate fee']);
                
            }
        }
        
        return redirect(url('admin/feeClassWiseUpdate/' . $head_id))->with(['msg' => 'Generate Success']);
    }
    public function generateYearlyFee($session_id,$version_id,$class_code,$head_id,$amount,$female_amount,$update){
        // if($class_code==11 || $class_code==12){
        //     $months=array('07','08','09','10','11','12','01','02','03','04','05','06');
        // }else{
        //     $months=array('01','02','03','04','05','06','07','08','09','10','11','12');
        // }
        
        
        
        $categorys=DB::table('class_category_wise_head_fee')
                        ->join('fee_head','fee_head.id','=','class_category_wise_head_fee.head_id')
                        ->where('version_id',$version_id)
                        //->where('session_id',$session_id)
                        ->where('class_code',$class_code)
                        ->where('head_id',$head_id)
                        ->where('class_category_wise_head_fee.status',1)
                        ->orderBy('class_category_wise_head_fee.id','desc')
                        ->get();
        
        $categorys=collect($categorys)->groupBy('category_id');
        
        $student_head_wise_fee=array();
        $student_fee=array();
        $i=0;
        $j=0;
     
            foreach($categorys as $key=>$category){
               
                
                foreach($category as $k=>$head){
                        $totalpayment=0;
                        $heads='';
                        $headamounts='';
                        $totalpayment+=$head->amount;
                        if($k==0){
                            $heads.=$head->head_id;
                            $headamounts.=$head->amount;
                        }else{
                            $heads.=','.$head->head_id;
                            $headamounts.=','.($head->amount??0);
                        }
                        
                    

                    if($head->gender==1 && !empty($amount)){
                        $headamounts=$amount;
                        $totalpayment=$amount;
                    }elseif($head->gender==2 && !empty($female_amount)){
                        $headamounts=$female_amount;
                        $totalpayment=$female_amount;
                    }elseif($update==1 && !empty($amount)){
                        $headamounts=$amount;
                        $totalpayment=$amount;
                    }
                
               
                    //dd($headamounts,$totalpayment,$heads);
                    
                // $payment_final_id=23;
                if($head->gender==1 || $head->gender==2){
                    $students=DB::table('student_activity')
                    ->join('students','students.student_code','=','student_activity.student_code')
                    ->where('gender',$head->gender)
                    ->where('version_id',$version_id)
                    ->where('session_id',$session_id)
                    ->where('class_code',$class_code)
                    ->where('student_activity.category_id',$key)->pluck('student_activity.student_code')->toArray();
                }else{
                    
                    $students=DB::table('student_activity')
                    ->join('students','students.student_code','=','student_activity.student_code')
                    ->where('version_id',$version_id)
                    ->where('session_id',$session_id)
                    ->where('class_code',$class_code)
                    ->where('student_activity.category_id',$key)->pluck('student_activity.student_code')->toArray();
                }
                
                    
                    foreach($students as $student_code){
                    
                        if($update==1){
                            $tranjection=StudentFeeTansaction::where('student_code',$student_code)
                            ->where('session_id',$session_id)
                            ->where('version_id',$version_id)
                            ->where('class_code',$class_code)
                            ->where('head_id',$head_id)
                            ->first();
                            $udpdate=array(
                                'amount'=>$headamounts,
                                'updated_by'=>Auth::user()->id,
                                'updated_at'=>date('Y-m-d H:s:i'),
                            );
                            if($tranjection){
                                DB::table('student_fee_tranjection')->where('id',$tranjection->id)->update($udpdate);
                                
                                $tranjectionHead=StudentHeadWiseFee::where('student_code',$student_code)
                                ->where('session_id',$session_id)
                                ->where('version_id',$version_id)
                                ->where('class_code',$class_code)
                                ->where('head_id',$head_id)
                                ->first();
                                DB::table('student_head_wise_fee')->where('id',$tranjectionHead->id)->update($udpdate);
                            }
                        }else{
                            $tranjection=array();
                        }
                        
                        if($tranjection){
                            
                        }else{
                            $student_head_wise_fee[$i]=array(
                                'student_code'=>$student_code,
                                'session_id'=>$session_id,
                                'version_id'=>$version_id,
                                'class_id'=>$class_code,
                                'class_code'=>$class_code,
                                'category_id'=>$key,
                                'head_id'=>$head_id,
                                'headid'=>$head_id,
                                'unit'=>1,
                                'month'=>null,
                                'amount'=>$headamounts,
                                'created_by'=>Auth::user()->id
                            );
                            $student_fee[$i++]=array(
                                'student_code'=>$student_code,
                                'session_id'=>$session_id,
                                'version_id'=>$version_id,
                                'class_id'=>$class_code,
                                'class_code'=>$class_code,
                                'category_id'=>$key,
                                'head_id'=>$head_id,
                                'headid'=>$head_id,
                                'month'=>null,
                                'amount'=>$totalpayment,
                                'created_by'=>Auth::user()->id
                            );
                        }
                        
                    }
                }
            }
        
        
        
        if(count($student_head_wise_fee)>0){
            DB::table('student_head_wise_fee')->insert($student_head_wise_fee);
        }
        if(count($student_fee)>0){
            DB::table('student_fee_tranjection')->insert($student_fee);
        }
        return 1;
    }
    public function feeClassWiseUpdateStudent(Request $request){
        $headamounts=$request->amount;
        $id=$request->id;
        $session_id=$request->session_id;
        $version_id=$request->version_id;
        $class_code=$request->class_code;
        $student_code=$request->student_code;
        $head_id=$request->head_id;
        
                            $udpdate=array(
                                'amount'=>$headamounts,
                                'updated_by'=>Auth::user()->id,
                                'updated_at'=>date('Y-m-d H:s:i'),
                            );
                            
                            DB::table('student_head_wise_fee')->where('id',$id)->update($udpdate);
                            
                            $tranjection=StudentFeeTansaction::where('student_code',$student_code)
                            ->where('session_id',$session_id)
                            ->where('version_id',$version_id)
                            ->where('class_code',$class_code)
                            ->where('head_id',$head_id)
                            ->first();
                            
                            DB::table('student_fee_tranjection')->where('id',$tranjection->id)->update($udpdate);
        return 1;          
    }
    public function feeSutdentWiseEntry(Request $request,$head_id){
        Session::put('activemenu','finance');
        Session::put('activesubmenu',$head_id);
        $sessions=Sessions::where('active',1)->first();
        $head=DB::table('fee_head')->where('id',$head_id)->first();
        $studentfees=StudentHeadWiseFee::with('session','version','shift','classes','student.studentActivity');
        
        $studentfees=$studentfees->where('head_id', $head_id);
        
        
        $studentfees=$studentfees->where('session_id',$sessions->id)->get();
       
        return view('fee.feeSutdentWiseEntry',compact('sessions','head_id','head','studentfees'));
    }
    public function feeclasswiseEntrySave(Request $request){
        $session_id=$request->session_id;
        $student_code=$request->student_code;
        $head_id=$request->head_id;
        $month=$request->month;
        $student=DB::table('student_activity')
                    ->where('session_id',$session_id)
                    ->where('student_code',$student_code)
                    ->first();
        $version_id=$student->version_id;
        $class_code=$student->class_code;
        $headamounts=$request->amount;
                    $tranjection=StudentFeeTansaction::where('student_code',$student_code)
                    ->where('session_id',$session_id)
                    ->where('version_id',$version_id)
                    ->where('class_code',$class_code)
                    ->where('head_id',$head_id)
                    ->where('month',$month)
                    ->first();
                    $udpdate=array(
                        'amount'=>$headamounts,
                        'updated_by'=>Auth::user()->id,
                        'updated_at'=>date('Y-m-d H:s:i'),
                    );
                    if($tranjection){
                        DB::table('student_fee_tranjection')->where('id',$tranjection->id)->update($udpdate);
                        
                        $tranjectionHead=StudentHeadWiseFee::where('student_code',$student_code)
                        ->where('session_id',$session_id)
                        ->where('version_id',$version_id)
                        ->where('class_code',$class_code)
                        ->where('head_id',$head_id)
                        ->where('month',$month)
                        ->first();
                        DB::table('student_head_wise_fee')->where('id',$tranjectionHead->id)->update($udpdate);
                    }else{
                        $student_head_wise_fee=array(
                            'student_code'=>$student_code,
                            'session_id'=>$session_id,
                            'version_id'=>$version_id,
                            'class_id'=>$class_code,
                            'class_code'=>$class_code,
                            'head_id'=>$head_id,
                            'headid'=>$head_id,
                            'unit'=>1,
                            'month_start_date'=>date('Y-'.$month.'-01'),
                            'month'=>$month,
                            'amount'=>$headamounts,
                            'created_by'=>Auth::user()->id
                        );
                        $student_fee=array(
                            'student_code'=>$student_code,
                            'session_id'=>$session_id,
                            'version_id'=>$version_id,
                            'class_id'=>$class_code,
                            'class_code'=>$class_code,
                            'headid'=>$head_id,
                            'head_id'=>$head_id,
                            'month_start_date'=>date('Y-'.$month.'-01'),
                            'month'=>$month,
                            'amount'=>$headamounts,
                            'created_by'=>Auth::user()->id
                        );
                        DB::table('student_head_wise_fee')->insert($student_head_wise_fee);
                        DB::table('student_fee_tranjection')->insert($student_fee);
                    }
        return redirect(url('admin/feeSutdentWiseEntry/' . $head_id))->with(['msg' => 'Generate Success']);
    }
    public function feeClassWiseUpdate(Request $request,$head_id)
    {
        Session::put('activemenu','finance');
        Session::put('activesubmenu',$head_id);
        $sessions=Sessions::where('active',1)->first();
        $head=DB::table('fee_head')->where('id',$head_id)->first();
        $class_id=$request->class_id;
        $month=$request->month;
        $session_id=$request->session_id;
        $student_code=$request->student_code;
        // $class_id=$request->class_id;
        // $class_id=$request->class_id;
        $studentfees=array();
        if($request->class_id){
            $studentfees=StudentHeadWiseFee::with('session','version','shift','classes','student.studentActivity');
            //if($head_id==29 || $head_id==34){
            //     $studentfees=$studentfees->where('headid',$head_id);
            // }elseif($head_id==1){
            //     $studentfees=$studentfees->where('head_id', 'like', '%,'.$head_id.'%');
            // }else{
                $studentfees=$studentfees->where('head_id', $head_id);
            //}
            if($request->session_id){
                $studentfees=$studentfees->where('session_id', $request->session_id);
            }else{
                $studentfees=$studentfees->where('session_id',$sessions->id);
            }

            if($request->class_id){
                $studentfees=$studentfees->where('class_code', $request->class_id);
            }
            if($request->month){
                $studentfees=$studentfees->where('month', $request->month);
            }
            if($request->student_code){
                $studentfees=$studentfees->where('student_code', $request->student_code);
            }
            
            $studentfees=$studentfees->get();
        }
        return view('fee.feeClassWiseUpdate',compact('sessions','head_id','head','studentfees','class_id','session_id','month','class_id','student_code'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function outstandingReport($type)
    {
       
    }
    public function studentXLFeeUpload(Request $request)
    {
        Session::put('activemenu','finance');
        Session::put('activesubmenu','sxfu');
        $sessions=Sessions::where('active',1)->first();
       
        
        
        $fees=Fee::where('head_type',1)->get();
        return view('fee.feeHeadAmountExportImport',compact('sessions','fees'));
    }
    public function studentfeeHeadWise(Request $request)
    {
        //dd($request->all());
        $class_id=$request->class_code;
        $month=$request->month;
        $session_id=$request->session_id;
        $head_id=$request->head_id;
        $status=$request->status;
        // $class_id=$request->class_id;
        // $class_id=$request->class_id;
        $studentfees=array();
        if($request->class_code>=0){
            $studentfees=StudentFeeTansaction::with('session','headdata','version','shift','classes','student.studentActivity.section');
            if($head_id){
              
                $studentfees=$studentfees->where('head_id', $head_id);
            }
            if($request->session_id){
                $studentfees=$studentfees->where('session_id', $request->session_id);
            }

            if($request->class_code){
                $studentfees=$studentfees->where('class_code', $request->class_code);
            }
            if($request->month){
                $studentfees=$studentfees->where('month', $request->month);
            }
            if($request->status){
                $studentfees=$studentfees->where('status', $request->status);
            }
            
            $studentfees=$studentfees->get();
           
        }
        return view('fee.ajaxstudentfeeHeadWise',compact('studentfees'));
        
    }
    public function StudentFeeStatusUpdate(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);
        if ($request->hasFile('file')) {
            $destinationPath = 'FeeStatusUpdate';
            $myimage = date('YmdHi').$request->file->getClientOriginalName();
            $request->file->move(public_path($destinationPath), $myimage);
            $file=public_path($destinationPath).'/'.$myimage;
            //$this->saveXLList($file,$request->all());

            Excel::import(new StudentFeeStatusUpdate, $file);

            return back()->with('success', 'Data imported successfully.');
        }
        
    }
    public function monthlyfeeFine()
    {
        // StudentFeeTansaction::where('session_id',1)
        //         ->where('head_id',1)
        //         ->where('status','Pending')
        //         ->pluck('id');
        $sessions=Sessions::where('active',1)->first();
        $tranjections=StudentFeeTansaction::where('session_id',$sessions->id)
                ->where('head_id',1)
                ->where('status','Pending')
                ->where('month','<',date('m'))
                ->orderBy('month','asc')
                ->get();
        foreach($tranjections as $tran){
           
            // $date1 = new DateTime($tran->month_start_date);
            // $date2 = new DateTime("Y-m-d");
            // $interval = $date1->diff($date2);
            //66
            $date1 = $tran->month_start_date;
            $dt = strtotime($date1);
            $date1=date("Y-m-d", strtotime("+1 month", $dt));
            $date2 = date("Y-m-d");

            $date1 = new DateTime($date1);
            $date2 = new DateTime($date2);
           
            $interval = $date1->diff($date2);
            $days=$interval->days;
            $amount=0;
            if($days>=16 && $days<20){
                $amount=15;
            }elseif($days>20 && $days<25){
                $amount=20;
            }elseif($days>25 && $days<=30){
                $amount=20;
            }elseif($days>31 && $days<61){
                $amount=30;
            }elseif($days>61){
                $amount=$tran->amount;
            }
           
            
            // if($days==16){
            //         $amount=15;
            // }elseif($days=21){
            //         $amount=20;
            // }elseif($days==26){
            //         $amount=20;
            // }elseif($days==31){
            //         $amount=30;
            // }elseif($days==61){
            //         $amount=$tran->amount;
            // }
            
            if($amount>0){
                $activity=array(
                    'student_code'=>$tran->student_code,
                    'session_id'=>$tran->session_id,
                    'class_code'=>$tran->class_code,
                    'head_id'=>66,
                    'headid'=>66,
                    'month'=>$tran->month,
                );
                $student_head_wise_fee=array(
                    'student_code'=>$tran->student_code,
                    'session_id'=>$tran->session_id,
                    'version_id'=>$tran->version_id,
                    'class_id'=>$tran->class_code,
                    'class_code'=>$tran->class_code,
                    'head_id'=>66,
                    'headid'=>66,
                    'unit'=>1,
                    'month_start_date'=>$tran->month_start_date,
                    'month'=>$tran->month,
                    'amount'=>$amount,
                    'created_by'=>1
                );
                $student_fee=array(
                    'student_code'=>$tran->student_code,
                    'session_id'=>$tran->session_id,
                    'version_id'=>$tran->version_id,
                    'class_id'=>$tran->class_code,
                    'class_code'=>$tran->class_code,
                    'headid'=>66,
                    'head_id'=>66,
                    'month_start_date'=>$tran->month_start_date,
                    'month'=>$tran->month,
                    'amount'=>$amount,
                    'created_by'=>1
                );

                StudentHeadWiseFee::updateOrCreate($activity,$student_head_wise_fee);
                $data=StudentFeeTansaction::updateOrCreate($activity,$student_fee);
                
                StudentFeeTansaction::where('id',$tran->id)->update(['late_ref_id'=>$data->id]);
            }
            
        }
    }
}
