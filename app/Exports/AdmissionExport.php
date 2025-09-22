<?php

namespace App\Exports;

use App\Models\Student\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;
class AdmissionExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $class_id;
    protected $section_id;

    public function __construct($class_id, $section_id)
    {
        $this->class_id = $class_id;
        $this->section_id = $section_id;
    }
    public function headings(): array
    {
        return [
            'Class','Group','Version','Class Roll','Name','Section','Gender','Father`s Name',
            'Mother`s Name','Guardian`s Name','Relation','Father`s Contact Number','Mother`s Contact Number',
            'Guardian`s Contact Number','SMS Notification','House','DOB','Religion','Blood Group',
            'SSC Roll','SSC Reg','Marks','Student Category','3rd Subject(s)','4rd Subject(s)'
        ];
    }
    public function collection()
    {
        
        $data= Student::join('student_activity','student_activity.student_code','=','students.student_code')
                ->select('class_name','group_name','version_name','student_activity.roll','first_name',
                'section_name','gender','father_name','mother_name','local_guardian_name','student_relation',
                'father_phone','mother_phone','local_guardian_mobile','sms_notification','house_id','birthdate','religion'
                ,'blood','roll_number','registration_number','total_mark','categoryid','student_activity.class_id'
                )
                ->leftJoin('classes','classes.id','=','student_activity.class_id')
                ->leftJoin('academygroups','academygroups.id','=','student_activity.group_id')
                ->leftJoin('sections','sections.id','=','student_activity.section_id')
                ->leftJoin('versions','versions.id','=','student_activity.version_id')
                ->where('student_activity.class_id',$this->class_id)
                ->where('students.active',1)
                ->where('student_activity.active',1)
                ->where('student_activity.section_id',$this->section_id)
                ->get();
        $session=DB::table('sessions')->where('active',1)->first();
        $house=array(1=>'Nazrul',2=>'Isha Kha',3=>'Titumir',4=>'Sher-E-Bangla');
        $gender=array(1=>'Male',2=>'Female');
        $categoryid=array(1=>'Civil',2=>'Son/daughter of Armed Forces` Member',3=>'Son/daughter of Teaching/Non-Teaching staff of BAFSD');
        $religion=array(1=>'Islam',2=>'Hindu',2=>'christian',2=>'Buddhism',2=>'Others');
        foreach($data as $key=>$student){
            $data[$key]->house_id=$house[$data[$key]->house_id]??'Nazrul';
            $data[$key]->gender=$gender[$data[$key]->gender]??'None';
            $data[$key]->religion=$religion[$data[$key]->religion]??'None';
            $data[$key]->categoryid=$categoryid[$data[$key]->categoryid]??'Civil';
            $third=DB::table('student_subject')->where('session_id',$session->id)
                                ->join('subjects','subjects.id','=','student_subject.subject_id')
                                ->where('class_id',$this->class_id)
                                ->where('is_fourth_subject',2)
                                ->distinct()
                                ->where('student_code',$student->roll)->pluck('parent_subject')->toArray();
            
            
            $data[$key]->third=implode(", ",$third);
            $fourth=DB::table('student_subject')->where('session_id',$session->id)
            ->join('subjects','subjects.id','=','student_subject.subject_id')
            ->where('class_id',$this->class_id)
            ->where('is_fourth_subject',1)
            ->distinct()
            ->where('student_code',$student->roll)->pluck('parent_subject')->toArray();
            $data[$key]->fourth=implode(", ",$fourth);
            unset($data[$key]->class_id);
        }
       
       return $data;
    }
    
    
}
