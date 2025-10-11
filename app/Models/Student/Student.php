<?php

namespace App\Models\Student;

use App\Models\District;
use App\Models\Finance\StudentFeeTansaction;
use App\Models\Attendance\Attendance;
use App\Models\SubjectMark;
use App\Models\Exam\StudentSubjectWiseMark;
use App\Models\Exam\StudentAvarageMark;
use App\Models\Exam\StudentTotalMark;
use App\Models\User;
use App\Models\DisciplinaryIssue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = "students";
    protected $fillable = [
        'student_code',
        'first_name',
        'last_name',
        'bangla_name',
        'birthdate',
        'gender',
        'nationality',
        'blood',
        'mobile',
        'religion',
        'sms_notification',
        'father_name',
        'mother_name',
        'father_contact',
        'father_profession',
        'father_email',
        'mother_contact',
        'mother_profession',
        'mother_email',
        'present_addr',
        'present_police_station',
        'present_district_id',
        'permanent_addr',
        'permanent_police_station',
        'permanent_district_id',
        'email',
        'local_guardian_name',
        'local_guardian_email',
        'local_guardian_mobile',
        'local_guardian_nid',
        'local_guardian_address',
        'local_guardian_police_station',
        'local_guardian_district_id',
        'active',
        'created_by',
        'remark',
        'PID',
        // Add other fillable attributes here
    ];
    public function studentActivities()
    {
        return $this->hasOne(StudentActivity::class, 'student_code', 'student_code');
    }
    public function studentActivity()
    {
        return $this->hasOne(StudentActivity::class, 'student_code', 'student_code')->orderBy('id', 'desc');
    }
    public function studentAllActivity()
    {
        return $this->hasMany(StudentActivity::class, 'student_code', 'student_code');
    }

    public function studentAttendance()
    {
        return $this->hasOne(Attendance::class, 'student_code', 'student_code');
    }
    public function studentExamAttendance()
    {
        return $this->hasOne(StudentAttendance::class, 'student_code', 'student_code');
    }
    public function studentAllAttendance()
    {
        return $this->hasMany(Attendance::class, 'student_code', 'student_code');
    }
    public function studentSubjects()
    {
        return $this->hasMany(StudentSubjects::class, 'student_code', 'student_code');
    }
    public function studentCurrentYearAttendance()
    {
        $end_date = date('Y-01-01');
        $start_date = date('Y-12-31', strtotime('-30 day', strtotime($end_date)));
        return $this->hasMany(Attendance::class, 'student_code', 'student_code')->whereBetween('attendance_date', [$start_date, $end_date])->orderBy('id', 'desc');
    }
    public function studentlastMonthAttendance()
    {
        $end_date = date('Y-m-d');
        $start_date = date('Y-m-d', strtotime('-30 day', strtotime($end_date)));
        return $this->hasMany(Attendance::class, 'student_code', 'student_code')->whereBetween('attendance_date', [$start_date, $end_date])->orderBy('id', 'desc');
    }
    public function studentlastWeekAttendance()
    {
        $end_date = date('Y-m-d');
        $start_date = date('Y-m-d', strtotime('-7 day', strtotime($end_date)));
        return $this->hasMany(Attendance::class, 'student_code', 'student_code')->whereBetween('attendance_date', [$start_date, $end_date])->orderBy('id', 'desc');
    }
    public function present()
    {
        return $this->hasOne(District::class, 'id', 'present_district_id');
    }
    public function permanent()
    {
        return $this->hasOne(District::class, 'id', 'permanent_district_id');
    }
    public function outstaningTuitionFee()
    {
        return $this->hasOne(StudentFeeTansaction::class, 'student_code', 'student_code')->whereIn('status', ['Pending', 'Invalid', 'Canceled', 'Failed'])->where('is_group', 0);
    }

    public function outstaning()
    {
        return $this->hasOne(StudentFeeTansaction::class, 'student_code', 'student_code')->whereIn('status', ['Pending', 'Invalid', 'Canceled', 'Failed'])->where('is_group', 0);
    }

    public function completed()
    {
        return $this->hasOne(StudentFeeTansaction::class, 'student_code', 'student_code')->whereIn('status', ['Complete'])->whereNull('fee_ids');
    }
    public function subjectmark()
    {
        return $this->hasMany(SubjectMark::class, 'student_code', 'student_code');
    }
    public function subjectwisemark()
    {
        return $this->hasMany(StudentSubjectWiseMark::class, 'student_code', 'student_code')
            ->leftJoin('subjects', 'subjects.id', '=', 'student_subject_wise_mark.subject_id')->orderByRaw("FIELD(is_fourth_subject, 0, 2, 1)")->orderBy('serial', 'asc');
    }
    public function subjectwisemarkother()
    {
        return $this->hasMany(StudentSubjectWiseMark::class, 'student_code', 'student_code')
            ->leftJoin('subjects', 'subjects.id', '=', 'student_subject_wise_mark.subject_id')->orderByRaw("FIELD(is_fourth_subject, 0, 2, 1)")->orderBy('serial', 'asc');
    }

    public function halfExam()
    {
        return $this->hasMany(StudentSubjectWiseMark::class, 'student_code', 'student_code');
    }
    public function avaragemark()
    {
        return $this->hasMany(StudentAvarageMark::class, 'student_code', 'student_code');
    }
    public function totalmark()
    {
        return $this->hasOne(StudentTotalMark::class, 'student_code', 'student_code')->leftJoin('sections', 'sections.id', '=', 'student_total_mark.next_section');
    }
    public function totalmark_half()
    {
        return $this->hasOne(StudentTotalMark::class, 'student_code', 'student_code');
    }
    public function subjects()
    {
        return $this->hasMany(StudentSubjects::class, 'student_code', 'student_code')
            ->join('subjects', 'subjects.id', '=', 'student_subject.subject_id')
            ->join('class_wise_subject', 'class_wise_subject.subject_id', '=', 'subjects.id')->orderBy('subjects.serial', 'asc');
    }
    public function boardResult()
    {
        return $this->hasOne(BoardResult::class, 'student_code', 'student_code')->orderBy('id', 'desc');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'tc_generated_by')->orderBy('id', 'desc');
    }
    public function disciplinaryIssues()
    {
        return $this->hasMany(DisciplinaryIssue::class);
    }
}
