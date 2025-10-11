<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceReExport implements FromCollection, WithHeadings
{
    protected $section_id;
    protected $class_code;
    protected $version_id;
    protected $shift_id;
    protected $start_date;
    protected $end_date;

    public function __construct($section_id, $class_code, $version_id, $shift_id, $start_date, $end_date)
    {
        $this->section_id = $section_id;
        $this->class_code = $class_code;
        $this->version_id = $version_id;
        $this->shift_id = $shift_id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function collection()
    {

        $session_id = date('Y');

        $m = date('m');
        if ($this->class_code == 11 || $this->class_code == 12) {

            if ($m <= 6) {
                $session_id = date('Y') - 1;
            }
        }
        // Initialize query with base conditions
        $ext = '';
        $extco = '';
        $extc = '';

        // dd($this->class_code, $this->section_id, $this->version_id, $this->shift_id, $this->start_date, $this->end_date);

        // if ($this->class_code == 0) {
        //     $ext = ' and s.submit=2';
        // }
        if ($this->section_id) {
            $extco .= ' and sa.section_id=' . $this->section_id;
            $extc .= ' and section_id=' . $this->section_id;
        }
        if ($this->version_id) {
            $extco .= ' and sa.version_id=' . $this->version_id;
            $extc .= ' and version_id=' . $this->version_id;
        }
        if ($this->shift_id) {
            $extco .= ' and sa.shift_id=' . $this->shift_id;
            $extc .= ' and shift_id=' . $this->shift_id;
        }
        if ($this->class_code) {
            $extco .= ' and sa.class_code=' . $this->class_code;
            $extc .= ' and class_code=' . $this->class_code;
        }

        // dd($ext, $extco, $extc, $this->start_date, $this->end_date, $session_id);

        $sql = "WITH stu AS (
                    SELECT
                        s.student_code,
                        s.first_name,
                        father_name,
                        sms_notification,
                        sa.roll,
                        s.PID,
                        version_name,
                        shift_name,
                        sa.class_code,
                        section_name
                    FROM students s
                    JOIN student_activity sa ON sa.student_code = s.student_code
                    JOIN versions v ON v.id = sa.version_id
                    JOIN shifts sh ON sh.id = sa.shift_id
                    JOIN sections sc ON sc.id = sa.section_id
                    WHERE s.active = 1 AND sa.active = 1 "  . $extco . "
                    AND sa.session_id = " . $session_id . "
                ),
                absentcount AS (
                    SELECT student_code, COUNT(id) AS absentcount
                    FROM attendances a
                    WHERE 1=1 " . $extc . "
                    AND attendance_date BETWEEN '" . $this->start_date . "' AND '" . $this->end_date . "'
                    AND status = 2
                    GROUP BY student_code
                ),
                missingCount AS (
                    SELECT student_code, COUNT(id) AS missingCount
                    FROM attendances a
                    WHERE 1=1 " . $extc . "
                    AND attendance_date BETWEEN '" . $this->start_date . "' AND '" . $this->end_date . "'
                    AND status = 5
                    GROUP BY student_code
                ),
                lateCount AS (
                    SELECT student_code, COUNT(id) AS lateCount
                    FROM attendances a
                    WHERE 1=1 " . $extc . "
                    AND attendance_date BETWEEN '" . $this->start_date . "' AND '" . $this->end_date . "'
                    AND status = 4
                    GROUP BY student_code
                ),
                reconcilation AS (
                    SELECT student_code, final_absent, final_late, final_missing
                    FROM reconcilation_attendance ra
                    JOIN reconcilation_date rd ON rd.id = ra.reconcilation_date_id
                    WHERE start_date = '" . $this->start_date . "'
                )
                SELECT
                    stu.*,
                    COALESCE(reconcilation.final_absent, absentcount.absentcount, 0) AS absent,
                    COALESCE(reconcilation.final_late, lateCount.lateCount, 0) AS late,
                    COALESCE(reconcilation.final_missing, missingCount.missingCount, 0) AS missing
                FROM stu
                LEFT JOIN absentcount ON absentcount.student_code = stu.student_code
                LEFT JOIN missingCount ON missingCount.student_code = stu.student_code
                LEFT JOIN lateCount ON lateCount.student_code = stu.student_code
                LEFT JOIN reconcilation ON reconcilation.student_code = stu.student_code
                WHERE
                    (COALESCE(reconcilation.final_absent, absentcount.absentcount, 0) > 0)
                    OR (COALESCE(reconcilation.final_late, lateCount.lateCount, 0) > 0)
                    OR (COALESCE(reconcilation.final_missing, missingCount.missingCount, 0) > 0)
                order by stu.class_code, stu.section_name, stu.version_name, stu.shift_name, stu.roll";

        // dd($sql);
        $students = DB::select($sql);
        if (empty($this->class_code)) {
            if ($m <= 6) {
                $session_id = date('Y') - 1;
            }
            $sql = "with stu as (select
                version_name
                ,shift_name
                ,sa.class_code
                ,section_name
                ,s.PID
                ,s.student_code
                ,sa.roll
                ,CONCAT_WS(' ',s.first_name,s.last_name) name
                ,father_name
                ,sms_notification
                from students s
                join student_activity sa on sa.student_code =s.student_code
                join versions v on v.id =sa.version_id
                join shifts sh on sh.id =sa.shift_id
                join sections sc on sc.id =sa.section_id
                where s.active=1 and sa.active=1 "  . $extco . " and session_id=" . $session_id . "
                ),
                reconcilation as (
                    select student_code,final_absent,final_late,final_missing from reconcilation_attendance ra
                    JOIN reconcilation_date rd ON rd.id=ra.reconcilation_date_id
                    where start_date='" . $this->start_date . "'
                )
                select stu.*,final_absent,final_late,final_missing from stu

                left join reconcilation on reconcilation.student_code=stu.student_code";
            $student11_12 = DB::select($sql);
            // dd($student11_12);
            if ($student11_12) {
                if ($students) {
                    $students = $students + $student11_12;
                } else {
                    $students = $student11_12;
                }
            }
        }

        return collect($students);
    }

    public function headings(): array
    {
        return [
            'Student Code',
            'Student Name',
            'Father Name',
            'SMS Notification',
            'Roll',
            'Payment ID',
            'Version Name',
            'Shift Name',
            'Class Code',
            'Section Name',
            'Absent',
            'Late',
            'Missing'
        ];
    }
}
