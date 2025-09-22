<?php 

namespace App\Imports;


use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;
class EmployeeImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $employees=array();
        $employees_activity=array();
        $l=0;
        $keys=[];
        foreach ($rows as $key=> $row) 
        {
            $i=0;
            if($key==0){
                $keys=$row;
            }else{
                foreach ($keys as $k=>$value){
                    if($value=='Name'){
                        $employees[$l]['teacher_name']=$row[$i];
                    }elseif($value=='Emp. ID'){
                        $employees[$l]['emp_id']=$row[$i];
                    }elseif($value=='Category'){
                        $category=DB::table('category')->where('category_name',$row[$i])->first();
                        $employees[$l]['category_id']=$category->id??null;
                       
                    }elseif($value=='Designation'){
                        $designation=DB::table('designations')->where('designation_name',$row[$i])->first();
                        $employees[$l]['designation_id']=$designation->id??null;
                    }elseif($value=='Joining Date'){
                        
                        $date = strtotime($row[$i]); 
                        $date = date('Y-m-d', $date);
                        $employees[$l]['join_date']=$date??null;

                    }elseif($value=='NID'){
                        $employees[$l]['nid']=$row[$i];
                    }elseif($value=='Date of Birth'){
                        $date = strtotime($row[$i]); 
                        $date = date('Y-m-d', $date);
                        $employees[$l]['dob']=$date??'';
                    }elseif($value=='Religion'){
                        if($row[$i]=='Islam'){
                            $Religion=1;
                        }elseif($row[$i]=='Hindu'){
                            $Religion=2;
                        }elseif($row[$i]=='Christian'){
                            $Religion=3;
                        }elseif($row[$i]=='Buddhism'){
                            $Religion=4;
                        }else{
                            $Religion=5;
                        }
                        $employees[$l]['religion']=$Religion;
                    }elseif($value=='Blood Group'){
                        $employees[$l]['blood']=$row[$i];
                    }elseif($value=='SMS Number'){
                        $employees[$l]['sms_notification_number']=$row[$i];
                        $employees[$l]['mobile']=$row[$i];
                    }elseif($value=='Email'){
                        $employees[$l]['email']=$row[$i];
                    }elseif($value=='Address'){
                        $employees[$l]['present_address']=$row[$i];
                        $employees[$l]['permanent_address']=$row[$i];
                    }elseif($value=='Gender'){
                        if($row[$i]=='Male'){
                            $gender=1;
                        }elseif($row[$i]=='Female'){
                            $gender=2;
                        }else{
                            $gender=3;
                        }
                        $employees[$l]['gender']=$gender;
                    }elseif($value=='Shift'){
                        $shift=DB::table('shifts')->where('shift_name',$row[$i])->first();
                       
                        $employees_activity[$l]['shift_id']=$shift->id??null;
                      
                    }elseif($value=='Subject'){
                        $subject=DB::table('subjects')->where('subject_name',$row[$i])->first();
                        if($subject){
                            $employees_activity[$l]['subject_id']=$subject->id??null;
                        }else{
                            $employees_activity[$l]['subject_id']=null;
                        }
                        
                    }
                    $employees[$l]['status']=1;

                    $employees_activity[$l]['active']=1;
                    $employees_activity[$l]['created_by']=1;
                    $employees[$l]['created_by']=1;
                    $i++;
                }
                $l++;
            }
            
        }
        foreach ($employees as $k=>$employee){
            $id=DB::table('employees')->insertGetId($employee);
            $employeesactivity=$employees_activity[$k];
            $employeesactivity['employee_id']=$id;
            DB::table('teacher_activity')->insertGetId($employeesactivity);
        }
    }
}