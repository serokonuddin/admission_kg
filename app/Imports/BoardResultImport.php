<?php

namespace App\Imports;

use App\Models\Student\BoardResult;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Illuminate\Support\Facades\Auth;

class BoardResultImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        // Process each row
        foreach ($rows as $key => $row) {
            if ($key == 0) {
                // Header row: extract the column names
                $keys = $row->toArray();
            } else {
                $boards = [];

                foreach ($row as $k => $value) {
                    $column_name = $keys[$k];

                    // Board Results Info
                    if (in_array($column_name, [
                        'student_code',
                        'exam_type',
                        'roll_number',
                        'registration_number',
                        'passing_year',
                        'gpa',
                        'grade'

                    ])) {

                        if ($column_name == 'student_code') {

                            $boards['student_code'] = trim($value ?? '');

                            if (empty($boards['student_code'])) {
                                continue 2;
                            }
                        }

                        if ($column_name == 'exam_type') {
                            $boards['exam_type'] = trim($value ?? '');
                        }

                        if ($column_name == 'roll_number') {
                            $boards['roll_number'] = trim($value ?? '');
                        }

                        if ($column_name == 'registration_number') {
                            $boards['registration_number'] = trim($value ?? '');
                        }

                        if ($column_name == 'passing_year') {
                            $boards['passing_year'] = trim($value ?? '');
                        }

                        if ($column_name == 'gpa') {
                            $boards['gpa'] = trim($value ?? '');
                        }

                        if ($column_name == 'grade') {
                            $boards['grade'] = trim($value ?? '');
                        }
                    }
                }

                // Set common fields
                $boards['status'] = 1;
                $boards['created_at'] = Carbon::now(); // Current timestamp
                $boards['updated_at'] = Carbon::now(); // Current timestamp
                $boards['created_by'] = Auth::user()->id; // Authenticated user ID

                // Insert or update Board Results
                BoardResult::updateOrCreate(
                    [
                        'student_code' => $boards['student_code']
                    ],
                    $boards
                );
            }
        }

        return 1;
    }
}