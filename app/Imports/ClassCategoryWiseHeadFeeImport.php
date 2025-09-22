<?php

namespace App\Imports;

use App\Models\ClassCategoryHeadFee;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;
use Auth;
class ClassCategoryWiseHeadFeeImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        
        $month=array(
            
            'January'=>"01",
            'February'=>"02",
            'March'=>"03",
            'April'=>'04',
            'May'=>'05',
            'June'=>'06',
            'July'=>'07',
            'August'=>'08',
            'September'=>'09',
            'Octobar'=>'10',
            'November'=>'11',
            'November'=>'12'
        );
        $gender=array(
            'Male'=>1, 
            'Female'=>2, 
        );
        $i=0;
        foreach ($rows as $key=> $row) 
        {
            
            if($key==0){
                $keys=$row;
            }else{
                
                if(count($row)==8){
                   
                    $data=[
                        // Map columns to model fields
                        'head_id' => $row[0],
                        'session_id' => DB::table('sessions')->where('session_name',$row[1])->pluck('id')->first(),
                        'version_id' => DB::table('versions')->where('version_name',$row[2])->pluck('id')->first(),
                        'class_code' => $row[3],
                        'category_id' => DB::table('Category')->where('category_name',$row[4])->pluck('id')->first(),
                        'amount' => $row[6],
                        'month' => date('m',strtotime($row[7])),
                        'effective_from' => $row[7],
                        'created_by'=>Auth::user()->id
                    ];
                   
                }else{
                    $data=[
                        // Map columns to model fields
                        'head_id' => $row[0],
                        'session_id' => DB::table('sessions')->where('session_name',$row[1])->pluck('id')->first(),
                        'version_id' => DB::table('versions')->where('version_name',$row[2])->pluck('id')->first(),
                        'class_code' => $row[3],
                        'category_id' => DB::table('Category')->where('category_name',$row[4])->pluck('id')->first(),
                        'gender' => $gender[$row[6]],
                        'amount' => $row[7],
                        'month' => date('m',strtotime($row[8])),
                        'effective_from' => $row[8],
                        'created_by'=>Auth::user()->id
                    ];
                }
                
                $ceckdata=ClassCategoryHeadFee::where('session_id',$data['session_id'])
                        ->where('version_id',$data['version_id'])
                        ->where('class_code',$data['class_code'])
                        ->where('head_id',$data['head_id']);
                        
                        if($data['category_id']){
                            $ceckdata=$ceckdata->where('category_id',$data['category_id']);
                        }
                        if(isset($data['gender']) && $data['gender']){
                            $ceckdata=$ceckdata->where('gender',$data['gender']);
                        }
                        
                        if($data['effective_from']){
                            $ceckdata=$ceckdata->where('effective_from',$data['effective_from']);
                        }
                        $ceckdata=$ceckdata->first();
                if($ceckdata){
                    $ceckdata->amount=(count($row)==8)?$row[7]:$row[8];
                    $ceckdata->updated_at=date('Y-m-d H:i:s');
                    $ceckdata->updated_by=Auth::user()->id;
                    $ceckdata->save();
                }else{
                    ClassCategoryHeadFee::insert($data);
                }
                
            }
           
            
        }
        
       return 1;
       
    }
}
