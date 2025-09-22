<?php

namespace App\Imports;

use App\Models\Finance\StudentFeeTansaction;
use App\Models\Finance\StudentHeadWiseFee;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use DB;
use Auth;
class StudentFeeStatusUpdate implements ToCollection
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
            'December'=>'12'
        );
        $head_name='';
        $session_name='';
        $i=0;
        foreach ($rows as $key=> $row) 
        {
            
            if($key==0){
                $keys=$row;
               
            }else{
                if($head_name=='' || $head_name!=$row[5]){
                    $head_id=DB::table('fee_head')->where('head_name',$row[5])->pluck('id')->first();
                    $head_name=$row[5];
                }
                if($session_name=='' || $session_name!=$row[6]){
                    $session_id=DB::table('sessions')->where('session_name',$row[6])->pluck('id')->first();
                    $session_name=$row[6];
                }
                $paymentdata=array();
                $student_code=$row[0];
                $class_code=$row[2];
               
               
                if(strtoupper($row[10])=='PAID'){
                    $status='Complete';
                }else{
                    $status='Pending';
                }
                if($class_code=='KG'){
                    $class_code=0;
                }
                $monthvaue=$month[$row[7]];
                
                $phpDate = Date::excelToDateTimeObject($row[8]);
                $payment_date = $phpDate->format('Y-m-d');
                $paymentdata['payment_date']=$payment_date;
                $paymentdata['updated_by']=Auth::user()->id;
                $paymentdata['status']=$status;
               
                StudentFeeTansaction::where('head_id',$head_id)
                ->where('session_id',$session_id)
                ->where('student_code',$student_code)
                ->where('class_code',$class_code)
                ->where('month',$monthvaue)
                ->update($paymentdata);
            }
           
            
        }
        
       return 1;
       
    }
}
