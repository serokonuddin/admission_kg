<?php

namespace App\Exports;

use App\Models\Student\Student;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PassListExport implements FromQuery, ShouldAutoSize, WithHeadings, WithMapping, WithStyles
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
            ->where('student_total_mark.position_in_section', '>', 0)
            ->with(['subjectwisemark' => function ($query) use ($session_id, $exam_id) {
                $query->where('session_id', $session_id)
                    ->where('exam_id', $exam_id)
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
            'Total',
            'Grade',
            'Grade Point',
        ];
    }

    public function map($student): array
    {
        static $i = 1;

        $subjectwiseMarks = $student->subjectwisemark ?? [];
        $total = 0;
        $isnegative = 0;
        $gpa_point = 0;
        foreach ($subjectwiseMarks as $key1 => $subject) {
            $pair_name = $subject->parent_subject;

            if (
                $pair_name != null &&
                isset($subjectwiseMarks[$key1 + 1]->parent_subject) &&
                $pair_name == $subjectwiseMarks[$key1 + 1]->parent_subject
            ) {
            } elseif (
                $pair_name != null &&
                isset($subjectwiseMarks[$key1 - 1]->parent_subject) &&
                $pair_name == $subjectwiseMarks[$key1 - 1]->parent_subject
            ) {
                if ($subject->gpa_point == 0) {
                    $gpa_point = -1;
                    $isnegative = -1;
                }

                if ($gpa_point != -1) {
                    $gpa_point += (float) $subject->gpa_point;
                }
            } else {
                if ($gpa_point != -1) {
                    if (
                        $subject->gpa_point == 0 ||
                        $subject->gpa_point == '' ||
                        $subject->gpa_point == null
                    ) {
                        if ($subject->is_fourth_subject != 1) {
                            $gpa_point = -1;
                            $isnegative = -1;
                        }
                    }
                    if ($subject->is_fourth_subject == 1) {
                        if ($subject->gpa_point > 2) {
                            $gpa_point += (float) ($subject->gpa_point - 2);
                        }
                    } else {
                        $gpa_point += (float) $subject->gpa_point;
                    }
                }
            }

            $total += (int) $subject->ct_conv_total;
        }

        $point = round($gpa_point / (count($subjectwiseMarks) - 3), 2);

        return [
            $i++,
            $student->section_name ?? '',
            $student->studentActivity->roll ?? '',
            $student->first_name ?? '',
            $student->sms_notification ?? '',
            $student->total_mark,
            $this->getGrade($point, $isnegative),
            $point > 5 ? '5' : $point,
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

    private function getGrade($point, $isNegative): string
    {
        if ($isNegative) {
            return 'F';
        }
        if ($point >= 5) {
            return 'A+';
        } elseif ($point >= 4) {
            return 'A';
        } elseif ($point >= 3.5) {
            return 'A-';
        } elseif ($point >= 3) {
            return 'B';
        } elseif ($point >= 2) {
            return 'C';
        } elseif ($point >= 1) {
            return 'D';
        }
        return 'F';
    }
}
