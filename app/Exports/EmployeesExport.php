<?php

namespace App\Exports;

use App\Models\Employee\Employee;
use App\Models\Student\Student;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmployeesExport implements FromQuery, ShouldAutoSize, WithHeadings, WithMapping, WithStyles
{


    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }


    public function query()
    {
        $query = Employee::query()->select(
            'employees.id',
            'employees.employee_name',
            'employees.employee_name_bn',
            'employees.father_name',
            'employees.mother_name',
            'employees.gender',
            'employees.religion',
            'employees.blood',
            'employees.mobile',
            'employees.email',
            'employees.nid',
            'employees.present_address',
            'employees.permanent_address',
            'employees.join_date',
            'employees.designation_id',
            'employees.category_id',
            'employees.shift_id',
            'employees.employee_for',
            'employees.version_id',
            'Category.category_name',
            'designations.designation_name',
            'subjects.subject_name',
        )
            ->leftjoin('Category', 'employees.category_id', '=', 'Category.id')
            ->leftjoin('designations', 'employees.designation_id', '=', 'designations.id')
            ->leftjoin('subjects', 'employees.subject_id', '=', 'subjects.id')->where('employees.active', 1);

        if (!empty($this->filters['shift_id'])) {
            $query->where('employees.shift_id', $this->filters['shift_id']);
        }
        if (!empty($this->filters['version_id'])) {
            $query->where('employees.version_id', $this->filters['version_id']);
        }

        if (!empty($this->filters['category_id'])) {
            $query->where('employees.category_id', $this->filters['category_id']);
        }

        if (!empty($this->filters['designation_id'])) {
            $query->where('employees.designation_id', $this->filters['designation_id']);
        }

        if (!empty($this->filters['for_id'])) {
            $query->where('employees.employee_for', $this->filters['for_id']);
        }

        if (!empty($this->filters['text_search'])) {
            $query->where(function ($query) {
                $query->where('employees.employee_name', 'like', '%' . $this->filters['text_search'] . '%')
                    ->orWhere('employees.emp_id', 'like', '%' . $this->filters['text_search'] . '%')
                    ->orWhere('employees.mobile', 'like', '%' . $this->filters['text_search'] . '%')
                    ->orWhere('employees.email', 'like', '%' . $this->filters['text_search'] . '%');
            });
        }

        return $query;
    }


    public function headings(): array
    {
        return [
            'Employee ID',
            'First Name',
            'Bangla Name',
            'Father Name',
            'Mother Name',
            'Gender',
            'Religion',
            'Blood Group',
            'Mobile',
            'Email',
            'NID',
            'Present Address',
            'Permanent Address',
            'Joining Date',
            'Designation',
            'Category',
            'Version',
            'Shift',
            'Subject',
        ];
    }

    public function map($employee): array
    {

        // dd($employee->toArray());

        $genders = array(1 => 'Male', 2 => 'Female', 3 => 'Others');
        $religions = array(1 => 'Islam', 2 => 'Hindu', 3 => 'Christian', 4 => 'Buddhism', 5 => 'Others');
        $shifts = array(1 => 'Morning', 2 => 'Day');
        $versions = array(1 => 'Bangla', 2 => 'English');
        return [
            $employee->id,
            $employee->employee_name,
            $employee->employee_name_bn,
            $employee->father_name,
            $employee->mother_name,
            $employee->gender ? $genders[$employee->gender] : null,
            $employee->religion ? $religions[$employee->religion] : null,
            $employee->blood_group,
            $employee->mobile,
            $employee->email,
            $employee->nid,
            $employee->present_address,
            $employee->permanent_address,
            $employee->join_date,
            $employee->designation_name,
            $employee->category_name,
            $employee->version_id ? $versions[$employee->version_id] : null,
            $employee->shift_id ? $shifts[$employee->shift_id] : null,
            $employee->subject_name,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Apply styles to the header row (row 1)
        $sheet->getStyle('1:1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFF'], // White text
                'size' => 12,
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['argb' => '4CAF50'], // Green background
            ],
            'alignment' => [
                'horizontal' => 'center', // Center horizontally for headers
                'vertical' => 'center', // Center vertically for headers
            ],
        ]);

        // Apply default styles to the entire sheet
        $sheet->getStyle($sheet->calculateWorksheetDimension())->applyFromArray([
            'alignment' => [
                'horizontal' => 'left', // Left-align horizontally
                'vertical' => 'center', // Center-align vertically
                'wrapText' => true, // Enable text wrapping
            ],
        ]);

        return [];
    }
}
