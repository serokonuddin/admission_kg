<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Finance\StudentFeeTansaction;
use App\Models\Finance\StudentHeadWiseFee;
use App\Models\Settings\Category;
use Illuminate\Support\Facades\DB;

class StudentFeeHeadWiseExport implements FromCollection, WithHeadings
{
   
    protected $month;
    protected $head_id;
    protected $head_name;
    protected $session_id;
    protected $class_code;
    protected $class_name;

    protected $session_name;
    protected $month_name;
    protected $status;

    public function __construct($head_id,$month,$session_id,$class_code,$head_name,$session_name,$class_name,$month_name,$status)
    {
        $this->month = $month;
        $this->head_id = $head_id;
        $this->session_id = $session_id;
        $this->class_code = $class_code;
        $this->class_name = $class_name;

        $this->session_name = $session_name;
        $this->class_name = $class_name;
        $this->month_name = $month_name;
        $this->status = $status;
    }

    public function headings(): array
    {
        return [
            'Sutdent Code', 'Student Name','Class Code', 'Section Name','Roll',  'Head Name','Session', 'Month','Payment Date', 'Amount','status'
        ];
    }

    public function twelvemonth($index)
    {
        $months = [
            "01" => 'January',
            "02" => 'February',
            "03" => 'March',
            "04" => 'April',
            "05" => 'May',
            "06" => 'June',
            "07" => 'July',
            "08" => 'August',
            "09" => 'September',
            "10" => 'October',
            "11" => 'November',
            "12" => 'December'
        ];
        return $months[$index] ?? 'Unknown';
    }

    public function collection()
    {
        $statustext='';
        if($this->status=='Pending'){
            $statustext='Unpaid';
        }else{
            $statustext='Paid';
        }

        $query = StudentFeeTansaction::select('students.student_code','first_name'
        ,DB::raw('
            CASE 
                WHEN student_activity.class_code = 0 THEN "KG"
                ELSE student_activity.class_code
            END AS class_code
        ')
        ,'section_name'
        ,'student_activity.roll'
        ,'head_name'
        ,'session_name'
        ,DB::raw('"'.$this->month_name.'" as month')
        ,'payment_date'
        ,'amount'
        ,DB::raw('"'.$statustext.'" as status')
        )
        ->join('students','students.student_code','=','student_fee_tranjection.student_code')
        ->join('student_activity','student_activity.student_code','=','student_fee_tranjection.student_code')
        ->join('sections','sections.id','=','student_activity.section_id')
        ->join('sessions','sessions.id','=','student_activity.session_id')
        ->join('fee_head','fee_head.id','=','student_fee_tranjection.head_id');
        
       

        if ($this->session_id) {
            $query->where('student_activity.session_id', $this->session_id);
        }
        if ($this->status) {
            $query->where('student_fee_tranjection.status', $this->status);
        }

        if ($this->head_id) {
            $query->where('head_id', $this->head_id);
        }
        if ($this->month) {
            $query->where('month', $this->month);
        }
        if ($this->class_code) {
            $query->where('student_activity.class_code', $this->class_code);
        }
        if ($this->class_code) {
            $query->where('student_activity.class_code', $this->class_code);
        }

        $data = $query->get();
        
        
        return $data;
        
    }
}
