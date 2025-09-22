<?php

namespace App\Exports;

use App\Models\Student\Student;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentsExport implements FromQuery, ShouldAutoSize, WithHeadings, WithMapping, WithStyles
{


    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $class_code=$this->filters['class_code'];
        $query = Student::query()
            ->select('students.*')
            ->join('student_activity', 'students.student_code', '=', 'student_activity.student_code')
            ->where('students.active', 1)
            ->where('student_activity.active', 1)
            ->with([
                'studentActivity.session:id,session_name',
                'studentActivity.version:id,version_name',
                'studentActivity.shift:id,shift_name',
                'studentActivity.classes:class_code,class_name',
                'studentActivity.group:id,group_name',
                'studentActivity.section:id,section_name',
                'studentActivity.category:id,category_name',
                'studentActivity.house:id,house_name'
            ])
            ->with(['studentSubjects.subjectCode' => function ($query) use ($class_code) {
                $query->where('class_code', $class_code);
            }])
            ->orderBy('student_activity.roll', 'asc');

        $query->whereHas('studentActivity', function ($query) {
            $query->where('active', 1);

            if (!empty($this->filters['session_id'])) {
                $query->where('session_id', $this->filters['session_id']);
            }
            if (!empty($this->filters['version_id'])) {
                $query->where('version_id', $this->filters['version_id']);
            }
            if (!empty($this->filters['shift_id'])) {
                $query->where('shift_id', $this->filters['shift_id']);
            }

            // Handle class_code filter
            if (isset($this->filters['class_code'])) {
                if ($this->filters['class_code'] == '0') {
                    $query->where('class_code', 0);
                } else {
                    $query->where('class_code', $this->filters['class_code']);
                }
            }

            if (!empty($this->filters['section_id'])) {
                $query->where('section_id', $this->filters['section_id']);
            }
        });


        if (!empty($this->filters['text_search'])) {
            $query->where(function ($query) {
                $query->where('students.first_name', 'like', '%' . $this->filters['text_search'] . '%')
                    ->orWhere('students.student_code', 'like', '%' . $this->filters['text_search'] . '%')
                    ->orWhere('students.mobile', 'like', '%' . $this->filters['text_search'] . '%')
                    ->orWhere('students.email', 'like', '%' . $this->filters['text_search'] . '%');
            });
        }
       // dd($query->toSql());
        return $query;
    }


    public function headings(): array
    {
        return [
            'Roll',
            'Student Code',
            'Payment ID',
            'First Name',
            'Bangla Name',
            'Father Name',
            'Mother Name',
            'Father NID',
            'Mother NID',
            'Father Mobile',
            'Mother Mobile',
            'Parent Income',
            'Birth Reg. No',
            'Birth Date',
            'Blood Group',
            'Gender',
            'Mobile',
            'SMS Notification',
            'Email',
            'Religion',
            'Nationality',
            'Present Address',
            'Permanent Address',
            'Local Gurdian Name',
            'Local Gurdian NID',
            'Local Gurdian Mobile',
            'Local Gurdian Address',
            'Session',
            'Version',
            'Shift',
            'Class',
            'Section',
            'Group',
            'Category',
            'House',
            'School Name',
            'Exam Center',
            'Roll Number',
            'Registration No',
            'Board',
            'Passing Year',
            'Results',
            'Result Fourth Subject',
            'Total Mark',
            'Compulsory Subject',
            'Third Subject',
            'Fourth Subject',
            'Compulsory Subject Code',
            'Third Subject Code',
            'Fourth Subject Code'
        ];
    }

    public function map($student): array
    {
       // dd($student->studentSubjects);
        $genders = array(1 => 'Male', 2 => 'Female', 3 => 'Others');
        $religions = array(1 => 'Islam', 2 => 'Hindu', 3 => 'Christian', 4 => 'Buddhism', 5 => 'Others');
        $activity = $student->studentActivity ?? null;
        $compulsorySubjectscode = $this->getCompulsorySubjects($student->studentSubjects,'code');
        $thirdSubjectscode = $this->getThirdSubjects($student->studentSubjects,'code');
        $fourthSubjectscode = $this->getFourthSubjects($student->studentSubjects,'code');
        $compulsorySubjects = $this->getCompulsorySubjects($student->studentSubjects,'name');
        $thirdSubjects = $this->getThirdSubjects($student->studentSubjects,'name');
        $fourthSubjects = $this->getFourthSubjects($student->studentSubjects,'name');
        
        return [
            $activity->roll ?? '',
            $student->student_code,
            $student->PID,
            $student->first_name,
            $student->bangla_name,
            $student->father_name,
            $student->mother_name,
            $student->father_nid_number,
            $student->mother_nid_number,
            $student->father_phone,
            $student->mother_phone,
            $student->parent_income,
            $student->birth_no,
            $student->birthdate,
            $student->blood,
            $student->gender ? $genders[$student->gender] : '',
            $student->mobile,
            $student->sms_notification,
            $student->email,
            $student->religion ? $religions[$student->religion] : '',
            $student->nationality ?? 'Bangladeshi',
            $student->present_addr,
            $student->permanent_addr,
            $student->local_guardian_name,
            $student->local_guardian_nid,
            $student->local_guardian_mobile,
            $student->local_guardian_address,
            $activity->session->session_name ?? '',
            $activity->version->version_name ?? '',
            $activity->shift->shift_name ?? '',
            $activity->classes->class_name ?? '',
            $activity->section->section_name ?? '',
            $activity->group->group_name ?? '',
            $activity->category->category_name ?? '',
            $activity->house->house_name ?? '',
            $student->school_name ?? '',
            $student->exam_center ?? '',
            $student->roll_number ?? '',
            $student->registration_number ?? '',
            $student->board ?? '',
            $student->passing_year ?? '',
            $student->result ?? '',
            $student->result_fourth_subject ?? '',
            $student->total_mark ?? '',
            $compulsorySubjects,
            $thirdSubjects,
            $fourthSubjects,
            $compulsorySubjectscode,
            $thirdSubjectscode,
            $fourthSubjectscode,
        ];
    }
    private function getCompulsorySubjects($subjects,$type)
    {
        if($type=='code'){

        return $subjects
            ->where('is_fourth_subject', 0)
            ->map(function ($subject) {
                return $subject->subjectCode->subject_code ?? '';
            })
            ->implode(', ');
        }else{
            return $subjects
            ->where('is_fourth_subject', 0)
            ->map(function ($subject) {
                return $subject->subject->subject_name ?? '';
            })
            ->implode(', ');
        }
        
    }
    private function getThirdSubjects($subjects,$type)
    {
        if($type=='code'){
            return $subjects
            ->where('is_fourth_subject', 2)
            ->map(function ($subject) {
                return $subject->subjectCode->subject_code ?? '';
            })
            ->implode(', ');
        }else{
            return $subjects
            ->where('is_fourth_subject', 2)
            ->map(function ($subject) {
                return $subject->subject->subject_name ?? '';
            })
            ->implode(', ');
        }
        
    }
    private function getFourthSubjects($subjects,$type)
    {
        if($type=='code'){
            return $subjects
            ->where('is_fourth_subject', 1)
            ->map(function ($subject) {
                return $subject->subjectCode->subject_code ?? '';
            })
            ->implode(', ');
        }else{
            return $subjects
            ->where('is_fourth_subject', 1)
            ->map(function ($subject) {
                return $subject->subject->subject_name ?? '';
            })
            ->implode(', ');
        }
        
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
