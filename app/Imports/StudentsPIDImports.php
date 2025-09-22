<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Student\Student;
use App\Models\Student\StudentActivity;
use App\Models\Student\StudentSubjects;
use Exception;
use DB;

class StudentsPIDImports implements ToCollection
{
    public function collection(Collection $rows)
    {

        // Process each row
        foreach ($rows as $key => $row) {
            if ($key == 0) {
                // Header row: extract the column names
                $keys = $row->toArray();
            } else {

                $studentupate = array(
                    'PID' => $row[1]
                );
                Student::where('student_code', $row[2])->update($studentupate);
            }
        }

        return 1;
    }
}
