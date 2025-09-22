<?php

namespace App\Imports;


use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Employee\EmployeeActivity;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use DB;
use Auth;

class RoutineImport implements ToCollection
{
    public function collection(Collection $rows)
    {



        foreach ($rows as $key => $row) {
            $i = 0;
            if ($key == 0) {
            } else {
                $attributes = array();
                $routines = array();

                $attributes['session_id'] = $row[1];
                $attributes['version_id'] = $row[2];
                $attributes['shift_id'] = $row[3];
                $attributes['class_code'] = $row[4];
                $attributes['section_id'] = $row[6];
                $attributes['day_name'] = $row[8];
                $attributes['start_time'] = Date::excelToDateTimeObject($row[9])->format('H:i:s');
                $attributes['end_time'] = Date::excelToDateTimeObject($row[10])->format('H:i:s');

                $routines['employee_id'] = ($row[0] === "" || empty($row[0]) || strtolower($row[0]) == 'null') ? null : $row[0];
                $routines['session_id'] = $row[1];
                $routines['version_id'] = $row[2];
                $routines['shift_id'] = $row[3];
                $routines['class_code'] = $row[4];
                $routines['class_id'] = $row[5];
                $routines['section_id'] = $row[6];
                $routines['subject_id'] = $row[7];
                $routines['day_name'] = $row[8];
                $routines['start_time'] = Date::excelToDateTimeObject($row[9])->format('H:i:s');
                $routines['end_time'] = Date::excelToDateTimeObject($row[10])->format('H:i:s');
                $routines['is_class_teacher'] = (isset($row[11]) && in_array(trim($row[11]), [0, 1])) ? $row[11] : 0;

                $routines['created_by'] = Auth::user()->id;
                $routines['active'] = 1;
                if ($routines['employee_id'] == null) {

                    $routines['employee_id'] = null;
                }
                if (strtolower($routines['subject_id']) == 'null') {

                    $routines['subject_id'] = null;
                }
                EmployeeActivity::updateOrCreate($attributes, $routines);
            }
        }
        return 1;
    }
}
