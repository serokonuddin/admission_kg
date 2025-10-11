<?php

namespace App\Exports;

use App\Models\Student\Student;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FailListExport implements FromQuery, ShouldAutoSize, WithHeadings, WithMapping, WithStyles
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function query()
    {

        $session_id = $this->filters['session_id'];
        $class_code = $this->filters['class_code'];
        $section_id = $this->filters['section_id'];
        $exam_id = $this->filters['exam_id'];
        $version_id = $this->filters['version_id'];
        $group_id = $this->filters['group_id'];

        return Student::join('student_activity', 'student_activity.student_code', '=', 'students.student_code')
            ->join('sections', 'sections.id', '=', 'student_activity.section_id')
            ->join('student_total_mark', 'student_total_mark.student_code', '=', 'students.student_code')
            ->where('student_activity.session_id', $session_id)
            ->where('student_activity.class_code', $class_code)
            ->when($section_id, function ($query) use ($section_id) {
                $query->where('student_activity.section_id', $section_id)
                    ->where('student_total_mark.section_id', $section_id);
            })
            ->when($version_id, function ($query) use ($version_id) {
                $query->where('student_activity.version_id', $version_id)
                    ->where('student_total_mark.version_id', $version_id);
            })
            ->when(!is_null($group_id), function ($query) use ($group_id) {
                $query->where('student_activity.group_id', $group_id);
            })
            ->where('student_total_mark.session_id', $session_id)
            ->where('student_total_mark.class_code', $class_code)
            ->whereRaw('ifnull(student_total_mark.position_in_section,0)=0')
            ->with('studentActivity')
            ->with(['subjectwisemark' => function ($query) use ($session_id, $exam_id) {
                $query->where('session_id', $session_id)
                    ->where('exam_id', $exam_id)
                    ->whereRaw('ifnull(gpa_point,0)=0')
                    ->whereNotIn('subject_id', [124, 46]);
            }])
            ->orderBy('student_activity.roll', 'asc');
    }

    public function headings(): array
    {
        return [
            'Sl',
            'Section',
            'Class Roll',
            'Student Name',
            'Mobile',
            'Subjects',
        ];
    }
    public function map($student): array
    {
        static $i = 1;
        $subjectwiseMarks = $student->subjectwisemark ?? [];
        $text = '';
        foreach ($subjectwiseMarks as $subject) {
            $terms = collect($subject->subjectmarkterms)
                ->unique('marks_for') // Remove duplicate terms
                ->sortBy('marks_for'); // Sort by marks type

            $markshow = [];
            foreach ($terms as $term) {
                if ($term->marks_for == 1) {
                    $markshow[] = 'CQ(' . $subject->cq_total . ')';
                }

                if ($term->marks_for == 2) {
                    $markshow[] = 'MCQ(' . $subject->mcq_total . ')';
                }

                if ($term->marks_for == 3) {
                    $markshow[] = 'Practical(' . $subject->practical_total . ')';
                }
            }

            // Join marks and append subject details
            $text .= $subject->subject_name . ': ' . implode(', ', $markshow) . "\n";
        }

        return [
            $i++,
            $student->section_name ?? '',
            $student->studentActivity->roll ?? '',
            $student->first_name ?? '',
            $student->sms_notification ?? '',
            $text

        ];
    }
    public function styles(Worksheet $sheet)
    {
        $highestColumn = $sheet->getHighestColumn(); // Get the last column dynamically
        $range = 'A1:' . $highestColumn . '1'; // e.g., A1:Z1
        // Apply styles to the header row (row 1)
        $sheet->getStyle($range)->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['argb' => '4CAF50'],
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
        ]);

        // Apply default styles to the entire sheet
        $sheet->getStyle($sheet->calculateWorksheetDimension())->applyFromArray([
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
                'wrapText' => true,
            ],
        ]);

        return [];
    }
}
