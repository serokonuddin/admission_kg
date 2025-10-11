<?php 

namespace App\Imports;


use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;
class BoardListImport implements ToCollection
{
    public function collection(Collection $rows)
    {
       
        $boardlist=array();
        $i=0;
        foreach ($rows as $key=> $row) 
        {
            
           // dd($row);
           $group_name='';
           $version_id=0;
            if($key==0){
                $keys=$row;
            }else{
                foreach($keys as $k=>$index){
                    if($index=='group_name'){
                        $group_name=$row[$k];
                        //$groupname=DB::table('academygroups')->where('id',$row[$k])->first();
                        $boardlist[$i][$index]=$group_name;
                    }elseif($index=='version_id'){
                        $version_id=$row[$k];
                        $boardlist[$i][$index]=$row[$k];
                        $boardlist[$i]['lang']=$row[$k];
					}elseif($index=='quota'){
                        $quota=$row[$k];
                        $boardlist[$i][$index]=$row[$k];
						$status=1;
						if($quota==2 || $quota==2.1 || $quota==3){
							$status=0;
						}
                        $boardlist[$i]['status']=$status;
                    }else{
						if(!empty($row[$k])){
							$boardlist[$i][$index]=$row[$k];
						}
                        
                    }
                    
                }
                //$boardlist[$i]['student_code']=$this->getStudentCode($group_name,$version_id);
                $boardlist[$i]['created_by']=Auth()->user()->id;
                $i++;
            }
            
        }
        
        DB::table('board_list')->insert($boardlist);
       
    }
    public function getStudentCode($group_name,$version_id){
         //$groupdata = DB::table('academygroups')->where('group_name', $group_name)->first();

                        $count = DB::table('student_activity')
                            ->where('session_id', 2025)
                            ->where('version_id', $version_id)
                            ->where('class_code', 11)
                            ->where('group_id', $group_name)
                            ->count();
                        if ($group_name == 'Science' && $version_id == 1) {
                            $middel = 1000;
                        } else if ($group_name == 'Science' && $version_id == 2) {
                            $middel = 4000;
                        } else if ($group_name == 'Business studies' && $version_id == 1) {
                            $middel = 5000;
                        } else if ($group_name == 'Business studies' && $version_id == 2) {
                            $middel = 6000;
                        } else if ($group_name == 'Humanities' && $version_id == 1) {
                            $middel = 3000;
                        } else {
                            $middel = 3601;
                        }
            // $serial = $middel + $count + 1;
            return  date('y') . ($middel + $count + 1);
    }
}