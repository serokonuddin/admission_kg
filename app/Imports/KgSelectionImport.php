<?php

namespace App\Imports;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class KgSelectionImport implements ToCollection
{
    public function collection(Collection $rows)
    {

        $selectionlist = array();
        $i = 0;
        foreach ($rows as $key => $row) {

            // dd($row);
            $group_name = '';
            $version_id = 0;
            if ($key == 0) {
                $keys = $row;
            } else {

                $student_code = $this->getStudentCode($row[1], $row[2], $row[3], $row[4]);
                $selectionlist = array(
                    'student_code' => $student_code,
                    'class_id' => $row[2],
                    'version_id' => $row[3],
                    'shift_id' => $row[4],
                    'session_id' => $row[1],
                    'status' => 1,
                    'selected' => 1,
                );
                DB::table('student_admission')->where('temporary_id', $row[0])->update($selectionlist);
            }
        }
    }
    public function getStudentCode($session_id, $class_code, $version_id, $shift_id)
    {
        //$groupdata = DB::table('academygroups')->where('group_name', $group_name)->first();
        if ($class_code == 0) {
            $count = DB::table('student_admission')
                ->where('session_id', $session_id)
                ->where('version_id', $version_id)
                ->where('shift_id', $shift_id)
                ->where('class_id', $class_code)
                ->whereNotNull('student_code')
                ->count();
            if ($version_id == 1 && $shift_id == 1) {
                $middel = 1000;
            } else if ($version_id == 2 && $shift_id == 1) {
                $middel = 2000;
            } else if ($version_id == 1 && $shift_id == 2) {
                $middel = 3000;
            } else if ($version_id == 2 && $shift_id == 2) {
                $middel = 4000;
            } else {
                $middel = 1000;
            }
            // $serial = $middel + $count + 1;
            return (date('Y') + 1) . ($middel + $count + 1);
        } else {
            $count = DB::table('student_activity')
                ->where('session_id', ($session_id - 1 + (int)$class_code))
                ->where('shift_id', $shift_id)
                ->where('version_id', $version_id)
                ->where('class_code', $class_code)
                ->max('student_code');
            return  $count + 1;
        }
    }
}
