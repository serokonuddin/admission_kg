<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Imports\StudentsCtMarkImports;
use App\Models\SubjectMark;
use App\Models\Exam\StudentAvarageMark;
use App\Models\Exam\Exam;
use App\Models\Exam\ExamHighestMark;
use App\Models\Exam\StudentSubjectWiseMark;
use App\Models\Exam\StudentTotalMark;
use App\Models\sttings\Sessions;
use App\Models\sttings\Classes;
use App\Models\sttings\Shifts;
use App\Models\sttings\Sections;
use App\Models\Employee\EmployeeActivity;
use App\Models\sttings\AcademySection;
use App\Models\sttings\Subjects;
use App\Models\Student\Student;
use App\Models\sttings\Versions;
use App\Models\Employee\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SubjectMarkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if ((Auth::user()->group_id != 2 && Auth::user()->group_id != 3) || Auth::user()->is_view_user != 0) {
            return 1;
        }
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'sm');
        $session_id = null;
        $version_id = null;
        $shift_id = null;
        $class_code = null;
        $section_id = null;
        $subject_id = null;
        $group_id = null;
        $employee = null;
        $versions = Versions::all();
        $groups = AcademySection::all();
        $sessions = Sessions::pluck('session_name', 'session_code');

        $classes = Classes::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $sections = Sections::get();
        if (Auth::user()->group_id == 3) {

            $employee = Employee::where('id', Auth::user()->ref_id)->first();

            $activity = EmployeeActivity::where('employee_id', $employee->id)
                ->where('is_class_teacher', 1)
                ->latest('id')          // same as ->orderByDesc('id')
                ->first();              // gives the most-recent (last) record

            if (empty($activity)) {
                return redirect()->back();
            }

            $classes = EmployeeActivity::leftJoin('classes', 'classes.class_code', '=', 'employee_activity.class_code')
                ->where([
                    ['employee_id', $employee->id],
                    ['is_class_teacher', 1]
                ])
                ->select('employee_activity.class_code', 'classes.class_name')
                ->with(['version', 'shift'])
                ->distinct()
                ->orderBy('employee_activity.class_code')
                ->get();

            $group_id = Sections::where('id', $activity->section_id)->value('group_id') ?? null;

            $shift_id = $activity->shift_id;
            $class_code = $activity->class_code;
            $section_id = $activity->section_id;
            $version_id = $activity->version_id;
            $session_id  = $activity->session_id;

            if ($activity->class_code == 11 || $activity->class_code == 12) {
                $sessions = Sessions::where('id', $activity->session_id)->pluck('college_session', 'session_code');
            } else {
                $sessions = Sessions::where('id', $activity->session_id)->pluck('session_name', 'session_code');
            }
            // dd($classdata);
            // dd($sessions);
        }
        return view('subject_marks.index', compact('versions', 'classes', 'shifts', 'sections', 'session_id', 'shift_id', 'class_code', 'section_id', 'version_id', 'sessions', 'groups', 'employee', 'group_id'));
    }
    public function subject_marks_others()
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3) {
            return 1;
        }
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'esmo');

        $session_id = null;
        $version_id = null;
        $shift_id = null;
        $class_code = null;
        $section_id = null;
        $subject_id = null;
        $employee = null;
        $versions = Versions::all();
        $groups = AcademySection::all();
        $sessions = Sessions::pluck('session_name', 'session_code');
        $classes = Classes::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $sections = Sections::get();
        if (Auth::user()->group_id == 3) {

            $employee = Employee::where('id', Auth::user()->ref_id)->first();

            $activity = EmployeeActivity::where('employee_id', $employee->id)
                ->where('is_class_teacher', 1)
                ->latest('id')          // same as ->orderByDesc('id')
                ->first();

            if (empty($activity)) {
                return redirect()->back();
            }

            $classes = EmployeeActivity::leftJoin('classes', 'classes.class_code', '=', 'employee_activity.class_code')
                ->where([
                    ['employee_id', $employee->id],
                    ['is_class_teacher', 1]
                ])
                ->select('employee_activity.class_code', 'classes.class_name')
                ->with(['version', 'shift'])
                ->distinct()
                ->orderBy('employee_activity.class_code')
                ->get();

            $shift_id = $activity->shift_id;
            $class_code = $activity->class_code;
            $section_id = $activity->section_id;
            $version_id = $activity->version_id;
            $session_id  = $activity->session_id;

            if ($activity->class_code == 11 || $activity->class_code == 12) {
                $sessions = Sessions::where('id', $activity->session_id)->pluck('college_session', 'session_code');
            } else {
                $sessions = Sessions::where('id', $activity->session_id)->pluck('session_name', 'session_code');
            }
        }

        return view('subject_marks.subject_marks_others', compact('versions', 'classes', 'shifts', 'sections', 'session_id', 'shift_id', 'class_code', 'section_id', 'version_id', 'sessions', 'groups', 'employee'));
    }
    public function subject_marks_ct_upload()
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3) {
            return 1;
        }
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'cmu');
        $subjects = [];
        $exams = [];
        $versions = Versions::all();
        $groups = AcademySection::all();
        $sessions = Sessions::get();
        $classdata = array();
        if (Auth::user()->group_id == 3) {
            $employee = Employee::where('id', Auth::user()->ref_id)->first();
            // dd($employee);
            $session = Sessions::where('active', 1)->first();


            $session = Sessions::where('session_name', date('Y'))->first();

            $classdata = EmployeeActivity::leftJoin('classes', 'classes.class_code', '=', 'employee_activity.class_code')
                // ->join('sections', 'sections.id', '=', 'employee_activity.section_id')
                ->where('employee_id', $employee->id)
                ->where('is_class_teacher', 1)
                //->where('employee_activity.session_id', $session->id)
                //->where('employee_activity.shift_id', $employee->shift_id)
                ->select(
                    'employee_activity.class_code'
                    // ,'class_name'
                    // , 'section_name', 'employee_activity.section_id', 'employee_activity.shift_id', 'employee_activity.version_id'
                )
                ->with(['version', 'shift'])
                ->orderBy('employee_activity.class_code')
                // ->orderBy('employee_activity.section_id')
                // ->groupBy('employee_activity.shift_id')
                // ->groupBy('employee_activity.version_id')
                ->groupBy('employee_activity.class_code')
                ->DISTINCT('class_code')
                //->groupBy('class_name')
                // ->groupBy('employee_activity.section_id')
                // ->groupBy('section_name')
                ->get();
        }
        $session_id = 0;
        $class_code = 0;
        $exam_id = 0;
        $subject_id = 0;
        $xl_type = 0;

        return view('subject_marks.index_ct', compact('versions', 'subjects', 'exams', 'session_id', 'class_code', 'exam_id', 'subject_id', 'xl_type', 'sessions', 'groups', 'classdata'));
    }
    public function subject_marks_ct_upload_xl(Request $request)
    {

        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3) {
            return 1;
        }
        if ($request->hasFile('file')) {
            $destinationPath = 'markfile';
            $myimage = $request->class_code . $request->file->getClientOriginalName();
            $request->file->move(public_path($destinationPath), $myimage);
            $file = public_path($destinationPath) . '/' . $myimage;

            $this->saveXLList($file, $request->all());


            //Excel::import(new StudentsImports, $file);
        }
        $versions = Versions::all();
        $groups = AcademySection::all();
        $sessions = Sessions::get();
        $exams = Exam::with(['session', 'classdata'])->where('session_id', $request->session_id)->where('class_code', $request->class_code)->orderBy('id', 'desc')->get();
        $subjects = DB::table('subjects')
            ->select('subjects.id', 'subject_name')
            ->join('class_wise_subject', 'class_wise_subject.subject_id', '=', 'subjects.id')
            ->where('class_code', $request->class_code)
            ->whereNotIn('subjects.id', [124, 46])
            ->where('subject_name', '!=', 'TIFFIN')
            ->groupBy('id', 'subject_name')
            ->orderBy('subject_name', 'asc')
            ->get();
        $session_id = $request->session_id;
        $class_code = $request->class_code;
        $exam_id = $request->exam_id;
        $subject_id = $request->subject_id;
        $xl_type = $request->xl_type;
        return view('subject_marks.index_ct', compact('versions', 'subjects', 'exams', 'session_id', 'class_code', 'exam_id', 'subject_id', 'xl_type', 'sessions', 'groups'));
        //return redirect()->route('subject_marks_ct_upload')->with('success', 'XL Import Success');
    }
    public function saveXLList($file, $input)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3) {
            return 1;
        }
        $inputvalue = array(
            'session_id' => $input['session_id'],
            'class_code' => $input['class_code'],
            'exam_id' => $input['exam_id'],
            'subject_id' => $input['subject_id'],
            'xl_type' => $input['xl_type'],
        );
        Session::put('inputCt', $inputvalue);

        Excel::import(new StudentsCtMarkImports, $file);
    }
    public function getsubjectMark1112(Request $request)
    {
        $markdata = DB::table('student_subject_wise_mark')
            ->join('students', 'students.student_code', '=', 'student_subject_wise_mark.student_code')
            ->join('student_activity', 'student_activity.student_code', '=', 'student_subject_wise_mark.student_code')
            ->join('sections', 'sections.id', '=', 'student_activity.section_id')
            ->where('student_subject_wise_mark.session_id', $request->session_id)
            ->where('student_subject_wise_mark.class_code', $request->class_code)
            ->where('student_activity.session_id', $request->session_id)
            ->where('student_activity.class_code', $request->class_code);
        if ($request->section_id) {
            $markdata = $markdata->where('student_activity.section_id', $request->section_id);
        }

        $markdata = $markdata->where('subject_id', $request->subject_id)
            ->selectRaw('student_activity.section_id,student_activity.group_id,student_activity.version_id,students.first_name,section_name,students.student_code,student_subject_wise_mark.*')
            ->get();
        $maxMarks = collect($markdata)->max('ct_conv_total');
        $topStudents = collect($markdata)->where('ct_conv_total', $maxMarks)->first();

        $this->saveheightestMark($topStudents);
        return view('subject_marks.ajaxindex_ct', compact('markdata'));
    }
    public function saveheightestMark($topStudents)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3) {
            return 1;
        }
        $hattributes = [
            'session_id' => $topStudents->session_id,
            'class_code' => $topStudents->class_code,
            'exam_id' => $topStudents->exam_id,
            'subject_id' => $topStudents->subject_id,
        ];
        $heighestdata = [
            'session_id' => $topStudents->session_id,
            'class_code' => $topStudents->class_code,
            'exam_id' => $topStudents->exam_id,
            'subject_id' => $topStudents->subject_id,
            'section_id' => $topStudents->section_id,
            'student_code' => $topStudents->student_code,
            'version_id' => $topStudents->version_id,
            'group_id' => $topStudents->group_id,
            'highest_mark' => $topStudents->ct_conv_total,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ];
        return ExamHighestMark::updateOrCreate($hattributes, $heighestdata);
    }
    public function other_subject_marks()
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3) {
            return 1;
        }
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'os');

        $versions = Versions::all();
        $groups = AcademySection::all();
        $sessions = Sessions::where('active', 1)->get();
        $classdata = array();
        if (Auth::user()->group_id == 3) {
            $employee = Employee::where('id', Auth::user()->ref_id)->first();
            // dd($employee);
            $session = Sessions::where('active', 1)->first();


            $session = Sessions::where('session_name', date('Y'))->first();

            $classdata = EmployeeActivity::leftJoin('classes', 'classes.class_code', '=', 'employee_activity.class_code')
                // ->join('sections', 'sections.id', '=', 'employee_activity.section_id')
                ->where('employee_id', $employee->id)
                ->where('is_class_teacher', 1)
                //->where('employee_activity.session_id', $session->id)
                //->where('employee_activity.shift_id', $employee->shift_id)
                ->select(
                    'employee_activity.class_code'
                    // ,'class_name'
                    // , 'section_name', 'employee_activity.section_id', 'employee_activity.shift_id', 'employee_activity.version_id'
                )
                ->with(['version', 'shift'])
                ->orderBy('employee_activity.class_code')
                // ->orderBy('employee_activity.section_id')
                // ->groupBy('employee_activity.shift_id')
                // ->groupBy('employee_activity.version_id')
                ->groupBy('employee_activity.class_code')
                ->DISTINCT('class_code')
                //->groupBy('class_name')
                // ->groupBy('employee_activity.section_id')
                // ->groupBy('section_name')
                ->get();
        }


        return view('subject_marks.index_other', compact('versions', 'sessions', 'groups', 'classdata'));
    }
    public function meritPosition()
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3) {
            return 1;
        }
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'mp');

        $sessions = Sessions::get();

        return view('subject_marks.merit_position', compact('sessions'));
    }
    public function AutoSection()
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3) {
            return 1;
        }
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'ats');

        $sessions = Sessions::where('active', 1)->get();

        return view('subject_marks.section_selection', compact('sessions'));
    }
    public function saveAddSection(Request $request)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3) {
            return 1;
        }
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'as');
        $session_id = $request->session_id;
        $class_code = $request->class_code;
        $exam_id = $request->exam_id;
        $section_id = $request->section_id;



        $sts = StudentTotalMark::where('exam_id', $exam_id)
            ->join('students', 'students.student_code', '=', 'student_total_mark.student_code')
            ->join('student_activity', 'student_activity.student_code', '=', 'student_total_mark.student_code')
            ->where('student_total_mark.session_id', $session_id)
            ->where('student_total_mark.class_code', $class_code)
            ->where('student_activity.session_id', $session_id)
            ->where('student_activity.class_code', $class_code)
            //->where('section_id',$section_id)
            ->where('position_in_class', '>', 0)
            ->orderBy('position_in_class', 'asc')
            // ->orderBy('student_total_mark.version_id','asc')
            // ->orderBy('student_total_mark.shift_id','asc')
            // ->orderBy('student_activity.version_id','asc')
            // ->orderBy('student_activity.shift_id','asc')
            // ->orderBy('student_total_mark.student_code','asc')
            ->selectRaw('student_total_mark.*
            ,student_activity.session_id
            ,student_activity.class_code
            ,student_activity.shift_id
            ,student_activity.version_id
            ,students.gender,student_activity.roll
            ')
            ->get();

        $numberstart[1][1] = 1001;
        $numberstart[1][2] = 3001;
        $numberstart[2][1] = 2001;
        $numberstart[2][2] = 4001;
        $studentsdata = collect($sts)->groupBy(['version_id', 'shift_id']);

        foreach ($studentsdata as $k1 => $students) {

            foreach ($students as $k2 => $student) {
                $roll = 0;

                $sections = Sections::where('class_code', $class_code + 1)
                    ->where('version_id', $k1)
                    ->where('shift_id', $k2)
                    ->orderBy('id')
                    ->pluck('id')->toArray();
                $count = count($sections);


                foreach ($student as $key => $val) {

                    if ($val->class_code == 0) {
                        $updatadata = array(
                            'next_class' => $class_code + 1,
                            'next_roll' => $val->roll,
                            // 'next_section' => $sections[$key % $count]
                        );
                    } else {
                        $updatadata = array(
                            'next_class' => $class_code + 1,
                            'next_roll' => ($roll++) + $numberstart[$k1][$k2],
                            // 'next_section' => $sections[$key % $count]
                        );
                    }


                    StudentTotalMark::where('id', $val->id)->update($updatadata);
                }
            }
        }

        // $studentsgender = collect($sts)->groupBy(['version_id', 'shift_id','gender']);
        // foreach ($studentsgender as $k1 => $students) {

        //     foreach ($students as $k2 => $student) {

        //         foreach ($student as $k3 => $value) {

        //             $sections = Sections::where('class_code', $class_code + 1)
        //                 ->where('version_id', $k1)
        //                 ->where('shift_id', $k2)
        //                 ->orderBy('id')
        //                 ->pluck('id')->toArray();
        //             $count = count($sections);


        //             foreach ($value as $key => $val) {
        //                 $updatadata = array(
        //                     'next_section' => $sections[$key % $count]
        //                 );
        //                 StudentTotalMark::where('id', $val->id)->update($updatadata);
        //             }
        //         }
        //     }
        // }

        return 1;
    }
    public function saveMeritSecondTimePosition(Request $request)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3) {
            return 1;
        }
        $input = $request->all();

        $failstudent = StudentTotalMark::where('session_id', $request->session_id)
            ->where('shift_id', $request->shift_id)
            ->where('exam_id', $request->exam_id)
            ->where('class_code', $request->class_code);
        if ($request->group_id) {
            $failstudent = $failstudent->where('group_id', $request->group_id);
        } else {
            $failstudent = $failstudent->where('version_id', $request->version_id);
        }
        $failstudent = $failstudent->whereNotIn('student_code', $request->studentcode)
            ->where('is_final', 0)
            ->update(['position_in_section' => 0, 'position_in_class' => 0]);
        foreach ($request->studentcode as $key => $studentcode) {
            $pointtext = "point" . $studentcode;
            $sujecta = array(
                'session_id' => $request->session_id,
                'class_code' => $request->class_code,
                'exam_id' => $request->exam_id,
                'student_code' => $studentcode,
            );

            $subjectmark = array(

                'grade_point' => $request->$pointtext ?? 0,
                'is_final' => 1,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            );

            StudentTotalMark::updateOrCreate($sujecta, $subjectmark);
        }
        $this->saveMeritThirdTimePosition($request);
        return redirect()->route('meritPosition')->with('success', 'Merit List Successfully add');
    }
    public function saveMeritThirdTimePosition($request)
    {

        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3) {
            return 1;
        }
        $session_id = $request->session_id;
        $shift_id = $request->shift_id;
        $section_id = $request->section_id;
        $class_code = $request->class_code;
        $version_id = $request->version_id;
        $exam_id = $request->exam_id;
        $group_id = $request->group_id ?? '';
        if ($group_id) {
            $sqlclass = "SELECT
                student_total_mark.session_id,

                sa.group_id,
                student_total_mark.class_code,
                student_total_mark.exam_id,
                student_total_mark.student_code,
                total_mark,
                grade_point,
                RANK() OVER (
                    ORDER BY grade_point DESC, total_mark DESC, student_total_mark.student_code asc
                ) AS rankvalue
            FROM
                student_total_mark
				join student_activity sa on sa.student_code=student_total_mark.student_code
                where position_in_section!=0 and sa.active=1
                            and student_total_mark.session_id=" . $session_id . "

                            and sa.group_id=" . $group_id . "
                            and student_total_mark.class_code=" . $class_code . "
                            and student_total_mark.exam_id=" . $exam_id;

            $sql = "SELECT
                student_total_mark.session_id,

                sa.group_id,
                student_total_mark.class_code,
                student_total_mark.section_id,
                student_total_mark.exam_id,
                student_total_mark.student_code,
                total_mark,
                grade_point,

                RANK() OVER (
                    ORDER BY grade_point DESC, total_mark DESC, student_total_mark.student_code asc
                ) AS rankvalue
            FROM
                student_total_mark
				join student_activity sa on sa.student_code=student_total_mark.student_code
                where position_in_section!=0 and sa.active=1
                            and student_total_mark.session_id=" . $session_id . "

                            and sa.group_id=" . $group_id . "
                            and student_total_mark.class_code=" . $class_code . "
                            and student_total_mark.section_id=" . $section_id . "
                            and student_total_mark.exam_id=" . $exam_id;
        } else {
            $sqlclass = "SELECT
                 student_total_mark.session_id,
                student_total_mark.version_id,
                student_total_mark.shift_id,
                student_total_mark.class_code,
                student_total_mark.exam_id,
                student_total_mark.student_code,
                no_of_working_days,
                total_attendance,
                total_mark,
                grade_point,
                RANK() OVER (
                    ORDER BY grade_point DESC, total_mark DESC,total_attendance desc, student_activity.roll asc
                ) AS rankvalue
            FROM
                student_total_mark
                join student_activity on student_activity.student_code=student_total_mark.student_code
                left join student_attendance on student_attendance.student_code=student_total_mark.student_code
                where position_in_class!=0
                            and student_total_mark.session_id=" . $session_id . "
                            and student_total_mark.version_id=" . $version_id . "
                            and student_total_mark.class_code=" . $class_code . "
                            and student_activity.session_id=" . $session_id . "
                            and student_activity.version_id=" . $version_id . "
                            and student_activity.class_code=" . $class_code . "
                            and student_total_mark.exam_id=" . $exam_id;
            // if ($shift_id) {
            //     $sqlclass .= " and student_activity.shift_id=" . $shift_id;
            // }
            $sqlclass .= " ORDER BY grade_point DESC, total_mark DESC,total_attendance desc, student_activity.roll asc";
            $sql = "SELECT
                student_total_mark.session_id,
                student_total_mark.version_id,
                student_total_mark.shift_id,
                student_total_mark.class_code,
                student_total_mark.section_id,
                student_total_mark.exam_id,
                student_total_mark.student_code,
                no_of_working_days,
                total_attendance,
                total_mark,
                grade_point,

                RANK() OVER (
                    ORDER BY grade_point DESC, total_mark DESC,total_attendance desc, student_activity.roll asc
                ) AS rankvalue
            FROM
                student_total_mark
                join student_activity on student_activity.student_code=student_total_mark.student_code
                left join student_attendance on student_attendance.student_code=student_total_mark.student_code
                where position_in_section!=0
                            and student_total_mark.session_id=" . $session_id . "
                            and student_activity.session_id=" . $session_id . "
                            and student_total_mark.version_id=" . $version_id . "
                            and student_activity.version_id=" . $version_id . "
                            and student_total_mark.class_code=" . $class_code . "
                            and student_total_mark.section_id=" . $section_id . "
                            and student_activity.section_id=" . $section_id . "

                            and student_total_mark.exam_id=" . $exam_id;

            // if ($shift_id) {
            //     $sql .= " and student_total_mark.shift_id=" . $shift_id;
            // }
            $sql .= " ORDER BY grade_point DESC, total_mark DESC,total_attendance desc, student_activity.roll asc";
        }




        $dataclass = DB::select($sqlclass);

        $data = DB::select($sql);

        $data = collect($data)->groupBy('section_id');
        // $updateopsition=array(
        //     'position_in_section'=>'0',
        //     'position_in_class'=>'0',
        // );
        // DB::table('student_total_mark')
        // ->where('session_id', $session_id)
        // ->where('class_code', $class_code)
        // ->where('exam_id',$exam_id)
        // ->where('version_id',$version_id)
        // ->where('group_id',$group_id)
        // ->update($updateopsition);
        $activites = DB::table('student_activity')
            ->where('session_id', $session_id)
            ->where('version_id', $version_id)
            ->where('class_code', $class_code);
        if ($group_id) {
            $activites = $activites->where('group_id', $group_id);
        }
        if ($shift_id) {
            $activites = $activites->where('shift_id', $shift_id);
        }
        $activites = $activites->get();
        $activitdata = collect($activites)->groupBy('student_code');
        //dd($data);
        foreach ($data as $key => $value) {

            $roll = 0;
            foreach ($value as $key1 => $student) {

                $sujecta = array(
                    'session_id' => $session_id,
                    'class_code' => $class_code,
                    'exam_id' => $exam_id,
                    'student_code' => $student->student_code,
                );
                $subjectmark = array(
                    'position_in_section' => ($student->rankvalue > 0) ? ++$roll : 0
                );
                StudentTotalMark::updateOrCreate($sujecta, $subjectmark);
            }
        }
        $roll = 0;
        foreach ($dataclass as $key => $value) {


            // if ($value->rankvalue != 0) {
            //     $roll++;
            // }
            $st_roll = $activitdata[$value->student_code] ?? [];
            $sujecta = array(
                'session_id' => $session_id,
                'class_code' => $class_code,
                'exam_id' => $exam_id,
                'student_code' => $value->student_code,
            );
            $subjectmark = array(
                'position_in_class' => ($value->rankvalue > 0) ? ++$roll : 0,
                'roll' => ($st_roll) ? $st_roll[0]->roll : ''

            );
            StudentTotalMark::updateOrCreate($sujecta, $subjectmark);
        }
        return 1;
    }
    public function saveMeritPosition(Request $request)
    {

        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'am');
        $session_id = $request->session_id;
        $section_id = $request->section_id;
        $class_code = $request->class_code;
        $version_id = $request->version_id;
        $shift_id = $request->shift_id;
        $exam_id = $request->exam_id;
        $group_id = $request->group_id;
        $class_percentage = DB::table('class_wise_percentage')->where('session_id', $request->session_id)
            ->where('class_code', $request->class_code)->first();

        if ($class_code > 3 && $class_code < 9) {
            $sqlclass = "SELECT

                        sswm.student_code,
                        sswm.session_id,
                        student_activity.version_id,
                        sswm.class_code,
                        sswm.exam_id,
                        sum(gpa_point) gpa_point,
                        SUM(ifnull(cq_total,0)+ifnull(mcq_total,0)+ifnull(practical_total,0)) total_marks,
                        CASE
                            WHEN SUM(gpa_point) = 0 THEN 0
                            WHEN SUM(CASE WHEN (is_fourth_subject = 0 OR is_fourth_subject = 2) AND (gpa_point = 0 OR gpa_point IS NULL) THEN 1 ELSE 0 END) > 0 THEN 0
                            ELSE RANK() OVER (
                                PARTITION BY sswm.session_id ,sswm.class_code ,sswm.exam_id
                                -- ORDER BY SUM(CASE WHEN is_fourth_subject = 1 THEN 0 ELSE gpa_point END) DESC,
                                ORDER BY SUM(gpa_point) DESC,
                                        SUM(ifnull(cq_total,0)+ifnull(mcq_total,0)+ifnull(practical_total,0)) DESC
                            )
                        END AS class_position
                    FROM
                        student_subject_wise_mark sswm
                        join student_activity on student_activity.student_code=sswm.student_code
                    WHERE
                        sswm.session_id = " . $session_id . "
                        AND student_activity.version_id = " . $version_id . "
                        AND sswm.class_code = " . $class_code . "
                        AND student_activity.class_code = " . $class_code . "
                        AND sswm.exam_id = " . $exam_id . "
                        AND non_value = 0
                    GROUP BY
                        sswm.session_id,student_activity.version_id, sswm.class_code,sswm.exam_id,sswm.student_code order by 5 desc,6 desc";
            $sql = "SELECT
                    sswm.session_id,
                    sswm.exam_id,
                    sswm.class_code,
                    student_activity.version_id,
                    student_activity.shift_id,
                    student_activity.section_id,
                    sswm.student_code,
                    SUM(sswm.gpa_point) AS gpa_point,
                    SUM(ifnull(cq_total,0)+ifnull(mcq_total,0)+ifnull(practical_total,0)) AS total_marks,
                    CASE
                        WHEN SUM(sswm.gpa_point) = 0 THEN 0
                        WHEN SUM(
                            CASE
                                WHEN (sswm.is_fourth_subject = 0 OR sswm.is_fourth_subject = 2) AND (sswm.gpa_point = 0 OR sswm.gpa_point IS NULL)
                                THEN 1
                                ELSE 0
                            END
                        ) > 0 THEN 0
                        ELSE RANK() OVER (
                            PARTITION BY sswm.session_id, sswm.class_code ,sswm.exam_id,student_activity.section_id
                            ORDER BY SUM(sswm.gpa_point) DESC,
                                    SUM(ifnull(cq_total,0)+ifnull(mcq_total,0)+ifnull(practical_total,0)) DESC
                        )
                    END AS section_position
                FROM
                    student_subject_wise_mark sswm
                JOIN
                    student_activity
                    ON student_activity.student_code = sswm.student_code
                WHERE
                    sswm.session_id = " . $session_id . "
                    AND sswm.class_code = " . $class_code . "
                    AND student_activity.class_code = " . $class_code . "
                    AND sswm.exam_id = " . $exam_id . "
                     AND student_activity.section_id =" . $section_id . "  -- Add a valid condition for `section_id`
                    AND sswm.non_value = 0
                GROUP BY
                    sswm.session_id,
                    student_activity.version_id,
                    student_activity.shift_id,
                    sswm.exam_id,
                    sswm.class_code,
                    student_activity.section_id,
                    sswm.student_code  order by 9 desc,10 desc;
                ";
        } elseif ($class_code > 8) {
            $sqlclass = "SELECT

                        sswm.student_code,
                        sswm.session_id,
                        sswm.class_code,
                        sswm.exam_id,
						student_activity.group_id,
                        sum(gpa_point) gpa_point,
                        SUM(ifnull(cq_total,0)+ifnull(mcq_total,0)+ifnull(practical_total,0)) total_marks,
                        CASE
                            WHEN SUM(gpa_point) = 0 THEN 0
                            WHEN SUM(CASE WHEN (is_fourth_subject = 0 OR is_fourth_subject = 2) AND (gpa_point = 0 OR gpa_point IS NULL) THEN 1 ELSE 0 END) > 0 THEN 0
                            ELSE RANK() OVER (
                                PARTITION BY sswm.session_id,student_activity.group_id ,sswm.class_code ,sswm.exam_id
                                -- ORDER BY SUM(CASE WHEN is_fourth_subject = 1 THEN 0 ELSE gpa_point END) DESC,
                                ORDER BY SUM(gpa_point) DESC,
                                        SUM(ifnull(cq_total,0)+ifnull(mcq_total,0)+ifnull(practical_total,0)) DESC
                            )
                        END AS class_position
                    FROM
                        student_subject_wise_mark sswm
                        join student_activity on student_activity.student_code=sswm.student_code
                    WHERE
                        sswm.session_id = " . $session_id . "
                        AND sswm.class_code = " . $class_code . "
                        AND student_activity.class_code = " . $class_code . "
                        AND sswm.exam_id = " . $exam_id . "
                        AND student_activity.group_id = " . $group_id . "
                        AND non_value = 0
                    GROUP BY
                        sswm.session_id,student_activity.group_id, sswm.class_code,sswm.exam_id,sswm.student_code order by 6 desc,7 desc";

            $sql = "SELECT
                    sswm.session_id,
                    sswm.exam_id,
                    sswm.class_code,
                    student_activity.shift_id,
                    student_activity.group_id,
                    student_activity.section_id,
                    sswm.student_code,
                    SUM(sswm.gpa_point) AS gpa_point,
                    SUM(ifnull(cq_total,0)+ifnull(mcq_total,0)+ifnull(practical_total,0)) AS total_marks,
                    CASE
                        WHEN SUM(sswm.gpa_point) = 0 THEN 0
                        WHEN SUM(
                            CASE
                                WHEN (sswm.is_fourth_subject = 0 OR sswm.is_fourth_subject = 2) AND (sswm.gpa_point = 0 OR sswm.gpa_point IS NULL)
                                THEN 1
                                ELSE 0
                            END
                        ) > 0 THEN 0
                        ELSE RANK() OVER (
                            PARTITION BY sswm.session_id, sswm.class_code ,sswm.exam_id,student_activity.section_id
                            ORDER BY SUM(sswm.gpa_point) DESC,
                                    SUM(ifnull(cq_total,0)+ifnull(mcq_total,0)+ifnull(practical_total,0)) DESC
                        )
                    END AS section_position
                FROM
                    student_subject_wise_mark sswm
                JOIN
                    student_activity
                    ON student_activity.student_code = sswm.student_code
                WHERE
                    sswm.session_id = " . $session_id . "
                    AND sswm.class_code = " . $class_code . "
                    AND student_activity.class_code = " . $class_code . "
                    AND sswm.exam_id = " . $exam_id . "
                    AND student_activity.group_id = " . $group_id . "
                    AND student_activity.section_id =" . $section_id . "  -- Add a valid condition for `section_id`
                    AND sswm.non_value = 0
                GROUP BY
                    sswm.session_id,
                    sswm.exam_id,
                    sswm.class_code,
                    student_activity.shift_id,
                    student_activity.group_id,
                    student_activity.section_id,
                    sswm.student_code  order by 9 desc,10 desc;
                ";
        } else {

            $sqlclass = "SELECT

                    sswm.student_code,
                    sswm.session_id,
                    sswm.class_code,
                    sswm.exam_id,
                    student_activity.version_id,
                    student_activity.shift_id,
                    sum(gpa_point) gpa_point,
                    SUM(ifnull(ct1,0)+ifnull(ct2,0)) total_marks,
                    CASE
                        WHEN SUM(gpa_point) = 0 THEN 0
                        WHEN SUM(CASE WHEN (is_fourth_subject = 0 OR is_fourth_subject = 2) AND (gpa_point = 0 OR gpa_point IS NULL) THEN 1 ELSE 0 END) > 0 THEN 0
                        ELSE RANK() OVER (
                            PARTITION BY sswm.session_id,student_activity.version_id,student_activity.shift_id ,sswm.class_code ,sswm.exam_id
                            -- ORDER BY SUM(CASE WHEN is_fourth_subject = 1 THEN 0 ELSE gpa_point END) DESC,
                            ORDER BY SUM(gpa_point) DESC,
                                    SUM(ifnull(ct1,0)+ifnull(ct2,0)) DESC
                        )
                    END AS class_position
                FROM
                    student_subject_wise_mark sswm
                    join student_activity on student_activity.student_code=sswm.student_code
                WHERE
                    sswm.session_id = " . $session_id . "
                    AND sswm.class_code = " . $class_code . "
                    AND student_activity.class_code = " . $class_code . "
                    AND sswm.exam_id = " . $exam_id . "
                    AND student_activity.version_id = " . $version_id . "
                    AND student_activity.shift_id = " . $shift_id . "
                    AND non_value = 0
                GROUP BY
                    sswm.session_id,student_activity.version_id, student_activity.shift_id,sswm.class_code,sswm.exam_id,sswm.student_code order by 7 desc,8 desc";

            $sql = "SELECT
                sswm.session_id,
                sswm.exam_id,
                sswm.class_code,
                student_activity.shift_id,
                student_activity.version_id,
                student_activity.section_id,
                sswm.student_code,
                SUM(sswm.gpa_point) AS gpa_point,
                SUM(ifnull(ct1,0)+ifnull(ct2,0)) AS total_marks,
                CASE
                    WHEN SUM(sswm.gpa_point) = 0 THEN 0
                    WHEN SUM(
                        CASE
                            WHEN (sswm.is_fourth_subject = 0 OR sswm.is_fourth_subject = 2) AND (sswm.gpa_point = 0 OR sswm.gpa_point IS NULL)
                            THEN 1
                            ELSE 0
                        END
                    ) > 0 THEN 0
                    ELSE RANK() OVER (
                        PARTITION BY sswm.session_id, sswm.class_code ,sswm.exam_id,student_activity.section_id
                        ORDER BY SUM(sswm.gpa_point) DESC,
                               SUM(ifnull(ct1,0)+ifnull(ct2,0)) DESC
                    )
                END AS section_position
            FROM
                student_subject_wise_mark sswm
            JOIN
                student_activity
                ON student_activity.student_code = sswm.student_code
            WHERE
                sswm.session_id = " . $session_id . "
                AND sswm.class_code = " . $class_code . "
                AND student_activity.class_code = " . $class_code . "
                AND sswm.exam_id = " . $exam_id . "
                AND student_activity.section_id =" . $section_id . "  -- Add a valid condition for `section_id`
                AND sswm.non_value = 0
            GROUP BY
                sswm.session_id,
                sswm.exam_id,
                sswm.class_code,
                student_activity.version_id,
				student_activity.shift_id,
                student_activity.section_id,
                sswm.student_code  order by 8 desc,9 desc;
        ";
        }



        //dd($sql);
        $dataclass = DB::select($sqlclass);

        // dd($dataclass);
        $data = DB::select($sql);
        // dd($dataclass, $data);
        $data = collect($data)->groupBy('section_id');
        // dd($data);
        foreach ($data as $key => $value) {
            $roll = 0;
            foreach ($value as $key1 => $student) {
                if ($student->section_position != 0) {
                    $roll++;
                }
                $sujecta = array(
                    'session_id' => $student->session_id,
                    'class_code' => $student->class_code,
                    'exam_id' => $student->exam_id,
                    'student_code' => $student->student_code,
                );
                $subjectmark = array(
                    'session_id' => $student->session_id,
                    'version_id' => $version_id,
                    'shift_id' => $student->shift_id,
                    'class_code' => $student->class_code,
                    'section_id' => $student->section_id,
                    'exam_id' => $student->exam_id,
                    'student_code' => $student->student_code,
                    'total_mark' => $student->total_marks ?? null,
                    'grade_point' => $student->gpa_point ?? null,
                    //'total_avarage_mark'=>$student->total_avarage_mark??null,
                    // 'position_in_class'=>$student->class_position??null,
                    'position_in_section' => ($student->section_position != 0) ? $roll : 0,
                    'created_by' => auth()->user()->id,
                    'updated_by' => auth()->user()->id,
                );
                StudentTotalMark::updateOrCreate($sujecta, $subjectmark);
            }
        }
        $roll = 0;
        foreach ($dataclass as $key => $value) {
            if ($value->class_position != 0) {
                $roll++;
            }
            $sujecta = array(
                'session_id' => $value->session_id,
                'class_code' => $value->class_code,
                'exam_id' => $value->exam_id,
                'student_code' => $value->student_code,
            );
            $subjectmark = array(

                'class_code' => $value->class_code,
                'exam_id' => $value->exam_id,
                'student_code' => $value->student_code,
                'position_in_class' => ($value->class_position != 0) ? $roll : 0,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            );
            StudentTotalMark::updateOrCreate($sujecta, $subjectmark);
        }

        $exam = Exam::find($exam_id);
        $grades = DB::table('grading')->get();

        // Build the student query with necessary joins
        $students = Student::join('student_activity', 'student_activity.student_code', '=', 'students.student_code')
            ->join('sections', 'sections.id', '=', 'student_activity.section_id')
            ->join('student_total_mark', 'student_total_mark.student_code', '=', 'student_activity.student_code') // Join for student_total_mark
            ->where('student_activity.session_id', $session_id)
            ->where('student_activity.class_code', $class_code);

        // Filter based on section, version, and group
        // if ($section_id) {
        //     $students = $students->where('student_activity.section_id', $section_id);
        // }



        if ($group_id) {
            $students = $students->where('student_activity.group_id', $group_id);
        } else {
            if ($version_id) {
                $students = $students->where('student_activity.version_id', $version_id);
            }
        }

        // if ($section_id) {
        //     $students = $students->where('student_activity.section_id', $section_id);
        // }

        if ($shift_id) {
            $students = $students->where('student_activity.shift_id', $shift_id);
        }



        // Apply additional filters and sorting
        $students = $students
            ->where('student_total_mark.position_in_section', '>', 0)
            ->where('student_total_mark.position_in_class', '>', 0)  // Ensure student has a class position
            ->orderBy('student_total_mark.position_in_section', 'asc') // Sort by class position for merit
            ->select(
                'students.student_code',
                'students.first_name',
                'student_activity.roll',
                'student_total_mark.position_in_section',
                'student_total_mark.position_in_class',
                'sections.section_name',
                'student_total_mark.total_mark'
            )
            ->with(['subjectwisemark' => function ($query) use ($session_id, $exam_id) {
                $query->where('session_id', $session_id)->where('exam_id', $exam_id)->whereNotIn('subject_id', [124, 46]);
            }])
            ->get();
        //  dd($students);
        $students = collect($students)->unique('student_code');

        return view('tabulation.ajaxindexmeritinput', compact('students', 'exam', 'grades'));
    }
    public function getMeritPosition(Request $request)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3) {
            return 1;
        }
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'am');
        $session_id = $request->session_id;
        $class_code = $request->class_code;
        $section_id = $request->section_id;
        $exam_id = $request->exam_id;
        $class_percentage = DB::table('class_wise_percentage')->where('session_id', $request->session_id)
            ->where('class_code', $request->class_code)->first();
        $students = Student::join('student_activity', 'student_activity.student_code', '=', 'students.student_code')->select('first_name', 'student_activity.roll', 'student_activity.student_code', 'student_activity.version_id', 'student_activity.group_id')
            ->where('student_activity.session_id', $request->session_id)
            ->where('student_activity.class_code', $request->class_code)
            ->with(['totalmark' => function ($query) use ($session_id, $class_code, $exam_id) {
                $query->where('session_id', $session_id)->where('exam_id', $exam_id)->where('class_code', $class_code);
            }]);
        if ($request->section_id) {
            $students = $students->where('student_activity.section_id', $request->section_id);
        }
        $students = $students->get();

        // foreach($students as $key=>$student){
        //     foreach($student->subjectmark as $subjectmark){
        //         dd($subjectmark);
        //     }
        // }

        return view('subject_marks.ajax_MeritPosition', compact('students'));
    }
    public function avarageMark()
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3) {
            return 1;
        }
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'am');

        $sessions = Sessions::orderBy('id', 'desc')->get();
        $versions = Versions::where('active', 1)->orderBy('version_name', 'asc')->get();

        return view('subject_marks.avarage_mark', compact('sessions', 'versions'));
    }

    public function getAvarageMarks(Request $request)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3) {
            return 1;
        }
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'am');
        $session_id = $request->session_id;
        $class_code = $request->class_code;
        $section_id = $request->section_id;
        $subject_id = $request->subject_id;
        $exam_id = $request->exam_id;
        $class_percentage = DB::table('class_wise_percentage')->where('session_id', $request->session_id)
            ->where('class_code', $request->class_code)
            ->first();

        $subject = Subjects::with(['subjectMarkTerms' => function ($query) use ($session_id, $subject_id, $class_code) {
            $query->where('session_id', $session_id)->where('subject_id', $subject_id)->where('class_code', $class_code);
        }, 'subject_wise_class' => function ($query) use ($class_code) {
            $query->where('class_code', $class_code);
        }])->where('id', $subject_id)->first();

        if ($request->class_code < 11) {
            $students = Student::join('student_activity', 'student_activity.student_code', '=', 'students.student_code')->select('first_name', 'student_activity.roll', 'student_activity.student_code', 'version_id', 'group_id')
                ->where('student_activity.session_id', $request->session_id)
                ->where('student_activity.class_code', $request->class_code)
                ->where('student_activity.section_id', $request->section_id)
                ->with(['avaragemark' => function ($query) use ($session_id, $subject_id, $class_code, $exam_id) {
                    $query->where('session_id', $session_id)->where('subject_id', $subject_id)->where('class_code', $class_code)->where('exam_id', $exam_id);
                }]);


            $students = $students->get();
        } else {
            $students = Student::join('student_activity', 'student_activity.student_code', '=', 'students.student_code')->select('first_name', 'student_activity.roll', 'student_activity.student_code', 'student_activity.version_id', 'student_activity.group_id')
                ->join('student_subject', 'student_subject.student_code', '=', 'students.student_code')
                ->where('student_subject.subject_id', $subject_id)
                ->where('student_activity.session_id', $request->session_id)
                ->where('student_activity.class_code', $request->class_code)
                ->where('student_activity.section_id', $request->section_id)
                ->with(['avaragemark' => function ($query) use ($session_id, $class_code, $subject_id, $exam_id) {
                    $query->where('session_id', $session_id)->where('subject_id', $subject_id)->where('class_code', $class_code)->where('exam_id', $exam_id)->orderBy('marks_for', 'asc');
                }]);

            $students = $students->get();
        }
        // foreach($students as $key=>$student){
        //     foreach($student->subjectmark as $subjectmark){
        //         dd($subjectmark);
        //     }
        // }

        return view('subject_marks.ajax_avarage', compact('students', 'subject'));
    }
    public function saveAvarageMarks(Request $request)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3) {
            return 1;
        }

        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'am');
        $session_id = $request->session_id;
        $class_code = $request->class_code;
        $version_id = $request->version_id;
        $section_id = $request->section_id;
        $subject_id = $request->subject_id;
        $exam_id = $request->exam_id;
        $exam = Exam::find($exam_id);
        $sectiondata = Sections::find($section_id);

        if ($exam->is_final == 1) {
            $sql = "
        SELECT
            sswm.session_id,
            sswm.class_code,
            sswm.student_code,
            subject_id,
            student_activity.version_id,
            student_activity.shift_id,
            ROUND(AVG(ct1)) AS avg_ct1,
            ROUND(AVG(ct2)) AS avg_ct2,
            ROUND(AVG(ct3)) AS avg_ct3,
            ROUND(AVG(ct)) AS avg_ct,
            ROUND(AVG(cq)) AS avg_cq,
            ROUND(AVG(cq_grace)) AS avg_cq_grace,
            ROUND(AVG(cq_total)) AS avg_cq_total,
            ROUND(AVG(mcq)) AS avg_mcq,
            ROUND(AVG(mcq_grace)) AS avg_mcq_grace,
            ROUND(AVG(mcq_total)) AS avg_mcq_total,
            ROUND(AVG(practical)) AS avg_practical,
            ROUND(AVG(practical_grace)) AS avg_practical_grace,
            ROUND(AVG(practical_total)) AS avg_practical_total,
            ROUND(AVG(total)) AS avg_total,
            ROUND(AVG(conv_total)) AS avg_conv_total,
            ROUND(AVG(ct_conv_total)) AS avg_ct_conv_total,
            ROUND(AVG(gpa_point)) AS avg_gpa_point
            ,is_fourth_subject
            ,non_value
        FROM
            student_subject_wise_mark sswm
            join student_activity on student_activity.student_code=sswm.student_code
         WHERE
                sswm.subject_id = " . $subject_id . "  -- Replace with the specific subject_id
                AND sswm.session_id = " . $session_id . "  -- Replace with the specific session_id
                AND sswm.class_code = " . $class_code . "   -- Replace with the specific class_code
                AND student_activity.version_id = " . $version_id . "   -- Replace with the specific version_id

                ";

            $sql .= " GROUP BY session_id,student_activity.version_id,student_activity.shift_id,class_code,subject_id,student_code,is_fourth_subject";
        } else {
            $sql = "
        SELECT
            sswm.session_id,
            sswm.class_code,
            sswm.student_code,
            student_activity.version_id,
            student_activity.shift_id,
            subject_id,
            is_fourth_subject,
            ROUND(AVG(ct1)) AS avg_ct1,
            ROUND(AVG(ct2)) AS avg_ct2,
            ROUND(AVG(ct3)) AS avg_ct3,
            ROUND(AVG(ct)) AS avg_ct,
            ROUND(AVG(cq)) AS avg_cq,
            ROUND(AVG(cq_grace)) AS avg_cq_grace,
            ROUND(AVG(cq_total)) AS avg_cq_total,
            ROUND(AVG(mcq)) AS avg_mcq,
            ROUND(AVG(mcq_grace)) AS avg_mcq_grace,
            ROUND(AVG(mcq_total)) AS avg_mcq_total,
            ROUND(AVG(practical)) AS avg_practical,
            ROUND(AVG(practical_grace)) AS avg_practical_grace,
            ROUND(AVG(practical_total)) AS avg_practical_total,
            ROUND(AVG(total)) AS avg_total,
            ROUND(AVG(conv_total)) AS avg_conv_total,
            ROUND(AVG(ct_conv_total)) AS avg_ct_conv_total,
            ROUND(AVG(gpa_point)) AS avg_gpa_point
            ,is_fourth_subject
            ,non_value
        FROM
            student_subject_wise_mark sswm
            join student_activity on student_activity.student_code=sswm.student_code
         WHERE
                sswm.subject_id = " . $subject_id . "  -- Replace with the specific subject_id
                AND sswm.session_id = " . $session_id . "  -- Replace with the specific session_id
                AND sswm.class_code = " . $class_code . "   -- Replace with the specific class_code
                AND student_activity.section_id = " . $section_id . "  -- Replace with the specific section_id
                AND exam_id = " . $exam_id . "   -- Replace with the specific exam_id

                ";

            $sql .= " GROUP BY session_id,student_activity.version_id,student_activity.shift_id,class_code,subject_id,student_code,is_fourth_subject,non_value";
        }





        $data = DB::select($sql);

        $avmaxvalue = 0;
        $maxvalue = 0;
        $heighestdata = array();
        $avheighestdata = array();
        $hattributes = array();
        //$students=collect($data)->groupBy(['student_code']);
        if ($exam->is_final == 1) {
            $maxvalue = ExamHighestMark::where('session_id', $request->session_id)
                ->where('class_code', $request->class_code)
                ->where('subject_id', $request->subject_id)
                ->whereNull('exam_id')
                ->max('avarage_highest_mark');
        } else {
            $maxvalue = ExamHighestMark::where('session_id', $request->session_id)
                ->where('class_code', $request->class_code)
                ->where('subject_id', $request->subject_id)
                ->where('section_id', $request->section_id)
                ->where('version_id', $request->version_id)
                ->where('exam_id', $exam_id)
                ->max('avarage_highest_mark');
        }

        if (empty($maxvalue)) {
            $maxvalue = 0;
        }
        foreach ($data as $key => $value) {

            $attributes = [
                'session_id' => $request->session_id,
                'class_code' => $request->class_code,
                'exam_id' => $request->exam_id,
                'subject_id' => $request->subject_id,
                'section_id' => $request->section_id,
                'student_code' => $value->student_code,
            ];
            $valu = [
                'session_id' => $request->session_id,
                'version_id' => $value->version_id,
                'shift_id' => $value->shift_id,
                'class_code' => $request->class_code,
                'exam_id' => $request->exam_id,
                'subject_id' => $request->subject_id,
                'section_id' => $request->section_id,
                'group_id' => $sectiondata->group_id,
                'student_code' => $value->student_code,
                'ct1' => $value->avg_ct1,
                'ct2' => $value->avg_ct2,
                'ct3' => $value->avg_ct3,
                'ct' => $value->avg_ct,
                'cq' => $value->avg_cq,
                'cq_grace' => $value->avg_cq_grace,
                'cq_total' => $value->avg_cq_total,
                'mcq' => $value->avg_mcq,
                'mcq_grace' => $value->avg_mcq_grace,
                'mcq_total' => $value->avg_mcq_total,
                'practical' => $value->avg_practical,
                'practical_grace' => $value->avg_practical_grace,
                'practical_total' => $value->avg_practical_total,
                'total' => $value->avg_total,
                'conv_total' => $value->avg_conv_total,
                'ct_conv_total' => $value->avg_ct_conv_total,
                'gpa_point' => $value->avg_gpa_point,
                'gpa' => $this->calculateGpa(($request->class_code > 3) ? $value->avg_ct_conv_total : $value->avg_conv_total),
                'is_fourth_subject' => $value->is_fourth_subject,
                'non_value' => $value->non_value,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ];

            StudentAvarageMark::updateOrCreate($attributes, $valu);
            if ($request->class_code > 5) {
                $avg_ct_conv_total = $value->avg_ct_conv_total;
            } else {
                $avg_ct_conv_total = $value->avg_total;
                // $avg_ct_conv_total = $value->avg_conv_total;
            }

            if ($maxvalue < $avg_ct_conv_total) {
                if ($exam->is_final == 1) {
                    $avheighestdata = [
                        'session_id' => $request->session_id,
                        'version_id' => $value->version_id,
                        'class_code' => $request->class_code,
                        'subject_id' => $request->subject_id,
                        'section_id' => $request->section_id,
                        'student_code' => $value->student_code,
                        'exam_id' =>  $exam_id,
                        'avarage_highest_mark' => $avg_ct_conv_total,
                        'created_by' => auth()->user()->id,
                        'updated_by' => auth()->user()->id,
                    ];
                } else {
                    $avheighestdata = [
                        'session_id' => $request->session_id,
                        'version_id' => $value->version_id,
                        'class_code' => $request->class_code,
                        'subject_id' => $request->subject_id,
                        'section_id' => $request->section_id,
                        'student_code' => $value->student_code,
                        'exam_id' =>  $exam_id,
                        'highest_mark' => $avg_ct_conv_total,
                        'created_by' => auth()->user()->id,
                        'updated_by' => auth()->user()->id,
                    ];
                }

                $maxvalue = $avg_ct_conv_total;
            }
        }


        // dd($avheighestdata);



        if ($avheighestdata) {
            if ($exam->is_final == 1) {
                $highestdata = ExamHighestMark::where('session_id', $request->session_id)
                    ->where('class_code', $request->class_code)
                    ->where('section_id', $request->section_id)
                    ->where('version_id', $request->version_id)
                    ->where('subject_id', $request->subject_id)
                    ->whereNull('exam_id')
                    ->whereNotNull('avarage_highest_mark')
                    ->first();
            } else {
                // dd($request->session_id, $request->class_code, $request->section_id, $request->version_id, $request->subject_id, $exam_id);
                $highestdata = ExamHighestMark::where('session_id', $request->session_id)
                    ->where('class_code', $request->class_code)
                    ->where('section_id', $request->section_id)
                    ->where('version_id', $request->version_id)
                    ->where('subject_id', $request->subject_id)
                    ->where('exam_id', $exam_id)
                    ->first();
                // dd($avheighestdata, $highestdata);
            }


            if ($highestdata) {
                DB::table('exam_highest_mark')
                    ->where('id', $highestdata->id)
                    ->update($avheighestdata);
            } else {
                DB::table('exam_highest_mark')->insert($avheighestdata);
            }
        }

        return 1;
    }
    public function saveAvarageMarksAuto($session_id, $class_code, $subject_id, $section_id, $exam_id)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3) {
            return 1;
        }
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'am');

        $exam = Exam::find($exam_id);
        $sectiondata = Sections::find($section_id);

        if ($exam->is_final == 1) {
            $sql = "
        SELECT
            sswm.session_id,
            sswm.class_code,
            sswm.student_code,
            subject_id,
            student_activity.version_id,
            student_activity.shift_id,
            ROUND(AVG(ct1)) AS avg_ct1,
            ROUND(AVG(ct2)) AS avg_ct2,
            ROUND(AVG(ct3)) AS avg_ct3,
            ROUND(AVG(ct)) AS avg_ct,
            ROUND(AVG(cq)) AS avg_cq,
            ROUND(AVG(cq_grace)) AS avg_cq_grace,
            ROUND(AVG(cq_total)) AS avg_cq_total,
            ROUND(AVG(mcq)) AS avg_mcq,
            ROUND(AVG(mcq_grace)) AS avg_mcq_grace,
            ROUND(AVG(mcq_total)) AS avg_mcq_total,
            ROUND(AVG(practical)) AS avg_practical,
            ROUND(AVG(practical_grace)) AS avg_practical_grace,
            ROUND(AVG(practical_total)) AS avg_practical_total,
            ROUND(AVG(total)) AS avg_total,
            ROUND(AVG(conv_total)) AS avg_conv_total,
            ROUND(AVG(ct_conv_total)) AS avg_ct_conv_total,
            ROUND(AVG(gpa_point)) AS avg_gpa_point
            ,is_fourth_subject
            ,non_value
        FROM
            student_subject_wise_mark sswm
            join student_activity on student_activity.student_code=sswm.student_code
         WHERE
                sswm.subject_id = " . $subject_id . "  -- Replace with the specific subject_id
                AND sswm.session_id = " . $session_id . "  -- Replace with the specific session_id
                AND sswm.class_code = " . $class_code . "   -- Replace with the specific class_code


                ";

            $sql .= " GROUP BY session_id,student_activity.version_id,student_activity.shift_id,class_code,subject_id,student_code,is_fourth_subject";
        } else {
            $sql = "
        SELECT
            sswm.session_id,
            sswm.class_code,
            sswm.student_code,
            student_activity.version_id,
            student_activity.shift_id,
            subject_id,
            is_fourth_subject,
            ROUND(AVG(ct1)) AS avg_ct1,
            ROUND(AVG(ct2)) AS avg_ct2,
            ROUND(AVG(ct3)) AS avg_ct3,
            ROUND(AVG(ct)) AS avg_ct,
            ROUND(AVG(cq)) AS avg_cq,
            ROUND(AVG(cq_grace)) AS avg_cq_grace,
            ROUND(AVG(cq_total)) AS avg_cq_total,
            ROUND(AVG(mcq)) AS avg_mcq,
            ROUND(AVG(mcq_grace)) AS avg_mcq_grace,
            ROUND(AVG(mcq_total)) AS avg_mcq_total,
            ROUND(AVG(practical)) AS avg_practical,
            ROUND(AVG(practical_grace)) AS avg_practical_grace,
            ROUND(AVG(practical_total)) AS avg_practical_total,
            ROUND(AVG(total)) AS avg_total,
            ROUND(AVG(conv_total)) AS avg_conv_total,
            ROUND(AVG(ct_conv_total)) AS avg_ct_conv_total,
            ROUND(AVG(gpa_point)) AS avg_gpa_point
            ,is_fourth_subject
            ,non_value
        FROM
            student_subject_wise_mark sswm
            join student_activity on student_activity.student_code=sswm.student_code
         WHERE
                sswm.subject_id = " . $subject_id . "  -- Replace with the specific subject_id
                AND sswm.session_id = " . $session_id . "  -- Replace with the specific session_id
                AND sswm.class_code = " . $class_code . "   -- Replace with the specific class_code

                AND exam_id = " . $exam_id . "   -- Replace with the specific exam_id

                ";

            $sql .= " GROUP BY session_id,student_activity.version_id,student_activity.shift_id,class_code,subject_id,student_code,is_fourth_subject,non_value";
        }





        $data = DB::select($sql);

        $avmaxvalue = 0;
        $maxvalue = 0;
        $heighestdata = array();
        $avheighestdata = array();
        $hattributes = array();
        //$students=collect($data)->groupBy(['student_code']);
        if ($exam->is_final == 1) {
            $maxvalue = ExamHighestMark::where('session_id', $session_id)
                ->where('class_code', $class_code)
                ->where('subject_id', $subject_id)
                ->whereNull('exam_id')
                ->max('avarage_highest_mark');
        } else {
            $maxvalue = ExamHighestMark::where('session_id', $session_id)
                ->where('class_code', $class_code)
                ->where('subject_id', $subject_id)
                ->where('exam_id', $exam_id)
                ->max('avarage_highest_mark');
        }

        if (empty($maxvalue)) {
            $maxvalue = 0;
        }
        foreach ($data as $key => $value) {

            $attributes = [
                'session_id' => $session_id,
                'class_code' => $class_code,
                'exam_id' => $exam_id,
                'subject_id' => $subject_id,
                'section_id' => $section_id,
                'student_code' => $value->student_code,
            ];
            $valu = [
                'session_id' => $session_id,
                'version_id' => $value->version_id,
                'shift_id' => $value->shift_id,
                'class_code' => $class_code,
                'exam_id' => $exam_id,
                'subject_id' => $subject_id,
                'section_id' => $section_id,
                'group_id' => $sectiondata->group_id,
                'student_code' => $value->student_code,
                'ct1' => $value->avg_ct1,
                'ct2' => $value->avg_ct2,
                'ct3' => $value->avg_ct3,
                'ct' => $value->avg_ct,
                'cq' => $value->avg_cq,
                'cq_grace' => $value->avg_cq_grace,
                'cq_total' => $value->avg_cq_total,
                'mcq' => $value->avg_mcq,
                'mcq_grace' => $value->avg_mcq_grace,
                'mcq_total' => $value->avg_mcq_total,
                'practical' => $value->avg_practical,
                'practical_grace' => $value->avg_practical_grace,
                'practical_total' => $value->avg_practical_total,
                'total' => $value->avg_total,
                'conv_total' => $value->avg_conv_total,
                'ct_conv_total' => $value->avg_ct_conv_total,
                'gpa_point' => $value->avg_gpa_point,
                'gpa' => $this->calculateGpa(($class_code > 3) ? $value->avg_ct_conv_total : $value->avg_conv_total),
                'is_fourth_subject' => $value->is_fourth_subject,
                'non_value' => $value->non_value,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ];

            StudentAvarageMark::updateOrCreate($attributes, $valu);
            if ($class_code > 3) {
                $avg_ct_conv_total = $value->avg_ct_conv_total;
            } else {
                $avg_ct_conv_total = $value->avg_conv_total;
            }
            if ($maxvalue < $avg_ct_conv_total) {
                if ($exam->is_final == 1) {
                    $avheighestdata = [
                        'session_id' => $session_id,
                        'class_code' => $class_code,
                        'subject_id' => $subject_id,
                        'section_id' => $section_id,
                        'student_code' => $value->student_code,
                        'avarage_highest_mark' => $avg_ct_conv_total,
                        'created_by' => auth()->user()->id,
                        'updated_by' => auth()->user()->id,
                    ];
                } else {
                    $avheighestdata = [
                        'session_id' => $session_id,
                        'class_code' => $class_code,
                        'subject_id' => $subject_id,
                        'section_id' => $section_id,
                        'student_code' => $value->student_code,
                        'highest_mark' => $avg_ct_conv_total,
                        'created_by' => auth()->user()->id,
                        'updated_by' => auth()->user()->id,
                    ];
                }

                $maxvalue = $avg_ct_conv_total;
            }
        }






        if ($avheighestdata) {
            if ($exam->is_final == 1) {
                $highestdata = ExamHighestMark::where('session_id', $session_id)
                    ->where('class_code', $class_code)
                    ->where('subject_id', $subject_id)
                    ->whereNull('exam_id')
                    ->whereNotNull('avarage_highest_mark')
                    ->first();
            } else {
                $highestdata = ExamHighestMark::where('session_id', $session_id)
                    ->where('class_code', $class_code)
                    ->where('subject_id', $subject_id)
                    ->where('exam_id', $exam_id)
                    ->whereNotNull('highest_mark')
                    ->first();
            }

            if ($highestdata) {
                DB::table('exam_highest_mark')
                    ->where('id', $highestdata->id)
                    ->update($avheighestdata);
            } else {
                DB::table('exam_highest_mark')->insert($avheighestdata);
            }
        }

        return 1;
    }
    public function calculateGpa($marks)
    {

        if ($marks >= 80) {
            return "A+";  // A+
        } else if ($marks >= 70) {
            return "A";  // A
        } else if ($marks >= 60) {
            return "A-";  // A-
        } else if ($marks >= 50) {
            return "B";  // B
        } else if ($marks >= 40) {
            return "C";  // C
        } else if ($marks >= 33) {
            return "D";  // D
        } else {
            return "F";  // F
        }
    }
    public function calculateGpa200($marks)
    {
        if ($marks >= 160) {
            return "A+";  // A+
        } else if ($marks >= 140) {
            return "A";  // A
        } else if ($marks >= 120) {
            return "A-";  // A-
        } else if ($marks >= 100) {
            return "B";  // B
        } else if ($marks >= 80) {
            return "C";  // C
        } else if ($marks >= 66) {
            return "D";  // D
        } else {
            return "F";  // F
        }
    }
    public function calculateGpaPoint200($marks)
    {
        if ($marks >= 160) {
            return 5;  // A+
        } else if ($marks >= 140) {
            return 4;  // A
        } else if ($marks >= 120) {
            return 3.5;  // A-
        } else if ($marks >= 100) {
            return 3;  // B
        } else if ($marks >= 80) {
            return 2;  // C
        } else if ($marks >= 66) {
            return 1;  // D
        } else {
            return 0;  // F
        }
    }
    public function calculateGpaPoint($marks)
    {
        if ($marks >= 80) {
            return 5;  // A+
        } else if ($marks >= 70) {
            return 4;  // A
        } else if ($marks >= 60) {
            return 3.5;  // A-
        } else if ($marks >= 50) {
            return 3;  // B
        } else if ($marks >= 40) {
            return 2;  // C
        } else if ($marks >= 33) {
            return 1;  // D
        } else {
            return 0;  // F
        }
    }
    public function getSubjectMarks(Request $request)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3) {
            return 1;
        }
        $session_id = $request->session_id;
        $class_code = $request->class_code;
        $section_id = $request->section_id;
        $subject_id = $request->subject_id;
        $version_id = $request->version_id;
        $exam_id = $request->exam_id;
        $exam_type = $request->exam_type;
        $group_id = $request->group_id;
        $subject = Subjects::with(['subjectMarkTerms' => function ($query) use ($session_id, $subject_id, $class_code) {
            $query
                ->where('session_id', $session_id)
                ->where('subject_id', $subject_id)->where('class_code', $class_code)
                ->orderBy('marks_for', 'asc');
        }, 'subject_wise_class' => function ($query) use ($class_code) {
            $query->where('class_code', $class_code);
        }])->where('id', $subject_id)->first();

        $class_percentage = DB::table('class_wise_percentage')
            ->where('session_id', $request->session_id)
            ->where('class_code', $request->class_code)->first();
        // $subjectMarks = SubjectMark::with(['subject','student','session','section','exam','version','subjectmarkterms' => function($query) use($session_id,$class_code) {
        //     $query->where('session_id', $session_id)->where('class_code', $class_code);
        // }])
        // ->where('session_id',$request->session_id)
        // ->where('class_code',$request->class_code)
        // ->where('exam_id',$request->exam_id);
        // if($request->subject_id){
        //     $subjectMarks =$subjectMarks->where('subject_id',$request->subject_id);
        // }
        // if($request->version_id){
        //     $subjectMarks =$subjectMarks->where('version_id',$request->version_id);
        // }
        // if($request->shift_id){
        //     $subjectMarks =$subjectMarks->where('shift_id',$request->shift_id);
        // }
        // if($request->section_id){
        //     $subjectMarks =$subjectMarks->where('section_id',$request->section_id);
        // }
        // if($request->group_id){
        //     $subjectMarks =$subjectMarks->where('group_id',$request->group_id);
        // }
        // $subjectMarks =$subjectMarks->get();
        // if($request->getdata){
        //     return $subjectMarks;
        // }

        $students = array();
        if ($request->class_code > 10) {
            $students = Student::join('student_activity', 'student_activity.student_code', '=', 'students.student_code')
                ->join('student_subject', 'student_subject.student_code', '=', 'student_activity.student_code')
                ->select('first_name', 'student_activity.roll', 'student_activity.student_code', 'student_activity.version_id', 'student_activity.group_id')
                ->where('students.active', 1)
                ->where('student_activity.active', 1)
                ->where('student_activity.session_id', $request->session_id)
                ->where('student_activity.class_code', $request->class_code)
                ->where('student_activity.section_id', $request->section_id)
                ->where('student_subject.session_id', $request->session_id)
                ->where('student_subject.class_code', $request->class_code)
                ->where('student_subject.subject_id', $subject_id)
                ->when($subject_id == 28, fn($q) => $q->where('students.gender', 1))
                ->when($subject_id == 34, fn($q) => $q->where('students.gender', 2))
                ->with(['subjectmark' => function ($query) use ($session_id, $subject_id, $exam_id) {
                    $query->where('session_id', $session_id)->where('subject_id', $subject_id)
                        ->where('exam_id', $exam_id);
                }])
                ->with(['subjectwisemark' => function ($query) use ($session_id, $subject_id, $exam_id) {
                    $query->where('session_id', $session_id)->where('subject_id', $subject_id)
                        ->where('exam_id', $exam_id);
                }]);
            if ($request->version_id) {
                $students = $students->where('student_activity.version_id', $request->version_id);
            }
            if ($request->group_id) {
                $students = $students->where('student_activity.group_id', $request->group_id);
            }
            $students = $students->orderBy('roll', 'asc')->get();
            $students = collect($students)->unique('student_code');
        } else if ($request->class_code <= 10) {
            $students = Student::join('student_activity', 'student_activity.student_code', '=', 'students.student_code')->select('first_name', 'student_activity.roll', 'student_activity.student_code', 'version_id', 'group_id')
                ->where('students.active', 1)
                ->where('student_activity.active', 1)
                ->where('student_activity.session_id', $request->session_id)
                ->where('student_activity.class_code', $request->class_code)
                ->where('student_activity.section_id', $request->section_id)
                ->when($subject_id == 28, fn($q) => $q->where('students.gender', 1))
                ->when($subject_id == 34, fn($q) => $q->where('students.gender', 2))
                ->with(['subjectmark' => function ($query) use ($session_id, $subject_id, $exam_id) {
                    $query->where('session_id', $session_id)->where('subject_id', $subject_id)
                        ->where('exam_id', $exam_id);
                }])
                ->with(['subjectwisemark' => function ($query) use ($session_id, $subject_id, $exam_id) {
                    $query->where('session_id', $session_id)->where('subject_id', $subject_id)
                        ->where('exam_id', $exam_id);
                }]);
            if ($request->version_id) {
                $students = $students->where('student_activity.version_id', $request->version_id);
            }
            if ($request->group_id) {
                $students = $students->where('student_activity.group_id', $request->group_id);
            }
            $students = $students->orderBy('roll', 'asc')->get();
        } else {
            $students = Student::join('student_activity', 'student_activity.student_code', '=', 'students.student_code')->select('first_name', 'student_activity.roll', 'student_activity.student_code', 'student_activity.version_id', 'student_activity.group_id')
                ->join('student_subject', 'student_subject.student_code', '=', 'students.student_code')
                ->where('students.active', 1)
                ->where('student_activity.active', 1)
                ->where('student_subject.subject_id', $subject_id)
                ->where('student_activity.session_id', $request->session_id)
                ->where('student_activity.class_code', $request->class_code)
                ->where('student_activity.section_id', $request->section_id)
                ->with(['subjectmark' => function ($query) use ($session_id, $subject_id, $exam_id) {
                    $query->where('session_id', $session_id)->where('subject_id', $subject_id)->where('exam_id', $exam_id);
                }]);
            // if($request->version_id){
            //     $students =$students->where('student_activity.version_id',$request->version_id);
            // }
            // if($request->group_id){
            //     $students =$students->where('student_activity.group_id',$request->group_id);
            // }
            $students = $students->orderBy('roll', 'asc')->get();
        }

        $students = collect($students)->unique('student_code');
        if ($class_code < 3) {
            // dd($students);
            return view('subject_marks.ajaxkf', compact('subject', 'class_percentage', 'students', 'class_code', 'subject_id', 'exam_type'));
        } else if ($class_code < 6) {
            return view('subject_marks.ajaxthreefive', compact('subject', 'class_percentage', 'students', 'class_code', 'subject_id', 'exam_type'));
        }
        // else if ($class_code == 6) {
        //     // dd($subject->subjectMarkTerms);
        //     return view('subject_marks.ajaxsixeight', compact('subject', 'class_percentage', 'students', 'class_code', 'subject_id', 'exam_type'));
        //     // return view('subject_marks.ajaxnineindex', compact('subject', 'class_percentage', 'students', 'class_code', 'subject_id', 'exam_type'));
        //     // return view('subject_marks.ajaxindexsixeight', compact('subject', 'class_percentage', 'students', 'class_code', 'subject_id'));
        // }
        else if ($class_code == 7 || $class_code == 8 || $class_code == 6) {
            // return view('subject_marks.ajaxsixeight', compact('subject', 'class_percentage', 'students', 'class_code', 'subject_id', 'exam_type'));
            return view('subject_marks.ajaxseveneightindex', compact('subject', 'class_percentage', 'students', 'class_code', 'subject_id', 'exam_type'));
        } else if ($class_code == 9) {
            // return view('subject_marks.ajaxnine', compact('subject', 'class_percentage', 'students', 'class_code', 'subject_id', 'exam_type'));
            return view('subject_marks.ajaxnineindex', compact('subject', 'class_percentage', 'students', 'class_code', 'subject_id', 'exam_type'));
        } else if ($class_code == 10) {
            // return view('subject_marks.ajaxten', compact('subject', 'class_percentage', 'students', 'class_code', 'subject_id', 'exam_type'));
            return view('subject_marks.ajaxnineindex', compact('subject', 'class_percentage', 'students', 'class_code', 'subject_id', 'exam_type'));
        }
        return view('subject_marks.ajaxindex', compact('subject', 'class_percentage', 'students', 'class_code', 'subject_id', 'exam_type'));
    }
    public function getOthersSubjectMarks(Request $request)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3) {
            return 1;
        }
        $session_id = $request->session_id;
        $class_code = $request->class_code;
        $section_id = $request->section_id;
        $subject_id = $request->subject_id;
        $version_id = $request->version_id;
        $exam_id = $request->exam_id;
        $group_id = $request->group_id;
        $subject = Subjects::with(['subjectMarkTerms' => function ($query) use ($session_id, $subject_id, $class_code) {
            $query->where('session_id', $session_id)->where('subject_id', $subject_id)->where('class_code', $class_code)->orderBy('marks_for', 'asc');
        }, 'subject_wise_class' => function ($query) use ($class_code) {
            $query->where('class_code', $class_code);
        }])->where('id', $subject_id)->first();

        $class_percentage = DB::table('class_wise_percentage')->where('session_id', $request->session_id)
            ->where('class_code', $request->class_code)->first();
        // $subjectMarks = SubjectMark::with(['subject','student','session','section','exam','version','subjectmarkterms' => function($query) use($session_id,$class_code) {
        //     $query->where('session_id', $session_id)->where('class_code', $class_code);
        // }])
        // ->where('session_id',$request->session_id)
        // ->where('class_code',$request->class_code)
        // ->where('exam_id',$request->exam_id);
        // if($request->subject_id){
        //     $subjectMarks =$subjectMarks->where('subject_id',$request->subject_id);
        // }
        // if($request->version_id){
        //     $subjectMarks =$subjectMarks->where('version_id',$request->version_id);
        // }
        // if($request->shift_id){
        //     $subjectMarks =$subjectMarks->where('shift_id',$request->shift_id);
        // }
        // if($request->section_id){
        //     $subjectMarks =$subjectMarks->where('section_id',$request->section_id);
        // }
        // if($request->group_id){
        //     $subjectMarks =$subjectMarks->where('group_id',$request->group_id);
        // }
        // $subjectMarks =$subjectMarks->get();
        // if($request->getdata){
        //     return $subjectMarks;
        // }

        $students = array();

        $students = Student::join('student_activity', 'student_activity.student_code', '=', 'students.student_code')
            ->select('first_name', 'student_activity.roll', 'student_activity.student_code', 'student_activity.version_id', 'student_activity.group_id')
            ->where('students.active', 1)
            ->where('student_activity.active', 1)
            ->where('student_activity.session_id', $request->session_id)
            ->where('student_activity.class_code', $request->class_code)
            ->where('student_activity.section_id', $request->section_id)
            ->when($subject_id == 28, fn($q) => $q->where('students.gender', 1))
            ->when($subject_id == 34, fn($q) => $q->where('students.gender', 2))
            ->with(['subjectwisemark' => function ($query) use ($session_id, $subject_id, $exam_id) {
                $query->where('session_id', $session_id)->where('subject_id', $subject_id)
                    ->where('exam_id', $exam_id);
            }]);
        // if($request->version_id){
        //     $students =$students->where('student_activity.version_id',$request->version_id);
        // }
        // if($request->group_id){
        //     $students =$students->where('student_activity.group_id',$request->group_id);
        // }
        $students = $students->orderBy('roll', 'asc')->get();
        $students = collect($students)->unique('student_code');
        //return $students;

        return view('subject_marks.ajaxindexother', compact('subject', 'class_percentage', 'students', 'class_code', 'subject_id'));
    }
    public function getSubjectMarksBlank(Request $request)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3) {
            return 1;
        }
        $session_id = $request->session_id;
        $class_code = $request->class_code;
        $section_id = $request->section_id;
        $subject_id = $request->subject_id;
        $version_id = $request->version_id;
        $exam_id = $request->exam_id;
        $group_id = $request->group_id;
        $subject = Subjects::with(['subjectMarkTerms' => function ($query) use ($session_id, $subject_id, $class_code) {
            $query->where('session_id', $session_id)->where('subject_id', $subject_id)->where('class_code', $class_code)->orderBy('marks_for', 'asc');
        }, 'subject_wise_class' => function ($query) use ($class_code) {
            $query->where('class_code', $class_code);
        }])->where('id', $subject_id)->first();

        $class_percentage = DB::table('class_wise_percentage')->where('session_id', $request->session_id)
            ->where('class_code', $request->class_code)->first();
        // $subjectMarks = SubjectMark::with(['subject','student','session','section','exam','version','subjectmarkterms' => function($query) use($session_id,$class_code) {
        //     $query->where('session_id', $session_id)->where('class_code', $class_code);
        // }])
        // ->where('session_id',$request->session_id)
        // ->where('class_code',$request->class_code)
        // ->where('exam_id',$request->exam_id);
        // if($request->subject_id){
        //     $subjectMarks =$subjectMarks->where('subject_id',$request->subject_id);
        // }
        // if($request->version_id){
        //     $subjectMarks =$subjectMarks->where('version_id',$request->version_id);
        // }
        // if($request->shift_id){
        //     $subjectMarks =$subjectMarks->where('shift_id',$request->shift_id);
        // }
        // if($request->section_id){
        //     $subjectMarks =$subjectMarks->where('section_id',$request->section_id);
        // }
        // if($request->group_id){
        //     $subjectMarks =$subjectMarks->where('group_id',$request->group_id);
        // }
        // $subjectMarks =$subjectMarks->get();
        // if($request->getdata){
        //     return $subjectMarks;
        // }
        $session = Sessions::find($session_id);
        $section = Sections::find($section_id);
        $exam = Exam::find($exam_id);

        $students = array();
        if ($request->class_code > 9) {
            $students = Student::join('student_activity', 'student_activity.student_code', '=', 'students.student_code')
                // ->join('student_subject','student_subject.student_code','=','student_activity.student_code')
                ->select(
                    'students.first_name',
                    'student_activity.roll',
                    'student_activity.student_code',
                    'student_activity.version_id',
                    'student_activity.shift_id', // Fetching shift_id
                    'student_activity.group_id'
                )
                ->where('student_activity.active', 1)
                ->where('students.active', 1)
                ->where('student_activity.session_id', $request->session_id)
                ->where('student_activity.class_code', $request->class_code)
                ->where('student_activity.section_id', $request->section_id)
                ->distinct() // Ensure unique rows
                // ->where('student_subject.session_id',$request->session_id)
                // ->where('student_subject.class_code',$request->class_code)
                // ->where('student_subject.subject_id',$subject_id)
                ->with(['subjectmark' => function ($query) use ($session_id, $subject_id, $exam_id) {
                    $query->where('session_id', $session_id)->where('subject_id', $subject_id)
                        ->where('exam_id', $exam_id);
                }])
                ->with(['subjectwisemark' => function ($query) use ($session_id, $subject_id, $exam_id) {
                    $query->where('session_id', $session_id)->where('subject_id', $subject_id)
                        ->where('exam_id', $exam_id);
                }]);
            if ($request->version_id) {
                $students = $students->where('student_activity.version_id', $request->version_id);
            }
            if ($request->group_id) {
                $students = $students->where('student_activity.group_id', $request->group_id);
            }
            $students = $students->orderBy('roll', 'asc')
                ->get()
                ->map(function ($student) {
                    $student->version_name = $student->version_id == 1 ? 'Bangla' : 'English';
                    $student->shift_name = $student->shift_id == 1 ? 'Morning' : 'Day';
                    return $student;
                });
        } else if ($request->class_code < 10) {
            $students = Student::join('student_activity', 'student_activity.student_code', '=', 'students.student_code')->select('first_name', 'student_activity.roll', 'student_activity.student_code', 'version_id', 'group_id')
                ->select(
                    'students.first_name',
                    'student_activity.roll',
                    'student_activity.student_code',
                    'student_activity.version_id',
                    'student_activity.shift_id', // Fetching shift_id
                    'student_activity.group_id'
                )
                ->where('student_activity.active', 1)
                ->where('students.active', 1)
                ->where('student_activity.session_id', $request->session_id)
                ->where('student_activity.class_code', $request->class_code)
                ->where('student_activity.section_id', $request->section_id)
                ->distinct() // Ensure unique rows
                ->with(['subjectmark' => function ($query) use ($session_id, $subject_id, $exam_id) {
                    $query->where('session_id', $session_id)->where('subject_id', $subject_id)
                        ->where('exam_id', $exam_id);
                }])
                ->with(['subjectwisemark' => function ($query) use ($session_id, $subject_id, $exam_id) {
                    $query->where('session_id', $session_id)->where('subject_id', $subject_id)
                        ->where('exam_id', $exam_id);
                }]);
            if ($request->version_id) {
                $students = $students->where('student_activity.version_id', $request->version_id);
            }
            if ($request->group_id) {
                $students = $students->where('student_activity.group_id', $request->group_id);
            }
            $students = $students->orderBy('roll', 'asc')
                ->get()
                ->map(function ($student) {
                    $student->version_name = $student->version_id == 1 ? 'Bangla' : 'English';
                    $student->shift_name = $student->shift_id == 1 ? 'Morning' : 'Day';
                    return $student;
                });
        } else {
            $students = Student::join('student_activity', 'student_activity.student_code', '=', 'students.student_code')
                ->select(
                    'first_name',
                    'student_activity.roll',
                    'student_activity.student_code',
                    'student_activity.version_id',
                    'student_activity.group_id'
                )
                ->join('student_subject', 'student_subject.student_code', '=', 'students.student_code')
                ->select(
                    'students.first_name',
                    'student_activity.roll',
                    'student_activity.student_code',
                    'student_activity.version_id',
                    'student_activity.shift_id', // Fetching shift_id
                    'student_activity.group_id'
                )
                ->where('student_activity.active', 1)
                ->where('student_subject.subject_id', $subject_id)
                ->where('student_activity.session_id', $request->session_id)
                ->where('student_activity.class_code', $request->class_code)
                ->where('student_activity.section_id', $request->section_id)
                ->distinct()
                ->with(['subjectmark' => function ($query) use ($session_id, $subject_id, $exam_id) {
                    $query->where('session_id', $session_id)->where('subject_id', $subject_id)->where('exam_id', $exam_id);
                }])
                ->orderBy('student_activity.roll', 'asc')
                ->get()
                ->map(function ($student) {
                    $student->version_name = $student->version_id == 1 ? 'Bangla' : 'English';
                    $student->shift_name = $student->shift_id == 1 ? 'Morning' : 'Day';
                    return $student;
                });

            // if($request->version_id){
            //     $students =$students->where('student_activity.version_id',$request->version_id);
            // }
            // if($request->group_id){
            //     $students =$students->where('student_activity.group_id',$request->group_id);
            // }
            // $students = $students->orderBy('roll', 'asc')->get();

        }

        // Filter unique students based on student_code
        $uniqueStudents = [];
        foreach ($students as $student) {
            $uniqueStudents[$student['student_code']] = $student; // Use student_code as the key
        }

        // Convert back to indexed array and sort by roll
        $students = array_values($uniqueStudents); // Remove associative keys
        usort($students, function ($a, $b) {
            return $a['roll'] <=> $b['roll']; // Sort by roll
        });

        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4', // Set page size to A4
            'orientation' => 'P' // 'P' for Portrait, 'L' for Landscape
        ]);
        $mpdf->SetWatermarkImage(asset('public/frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png'), 0.1, [75, 65]); // Image path, opacity, and size
        $mpdf->showWatermarkImage = true;



        if ($class_code < 3) {
            $mpdf->WriteHTML(view('subject_marks.ajaxkfPrint', compact('subject', 'session', 'section', 'exam', 'class_percentage', 'students', 'class_code', 'subject_id')));
            //return view('subject_marks.ajaxkfPrint', compact('subject','exam','class_percentage','students','class_code','subject_id'));
        } else if ($class_code < 6) {
            $mpdf->WriteHTML(view('subject_marks.ajaxthreefivePrint', compact('subject', 'session', 'section', 'exam', 'class_percentage', 'students', 'class_code', 'subject_id')));
            //return view('subject_marks.ajaxkfPrint', compact('subject','exam','class_percentage','students','class_code','subject_id'));
        } else if ($class_code == 10) {
            $mpdf->WriteHTML(view('subject_marks.ajaxindextenPrint', compact('subject', 'session', 'section', 'exam', 'class_percentage', 'students', 'class_code', 'subject_id')));
        } else {
            $mpdf->WriteHTML(view('subject_marks.ajaxindexPrint', compact('subject', 'session', 'section', 'exam', 'class_percentage', 'students', 'class_code', 'subject_id')));
        }
        // return response($mpdf->Output('', 'S'), 200)
        // ->header('Content-Type', 'application/pdf');

        //return view('subject_marks.ajaxindexPrint', compact('subject','exam','class_percentage','students','class_code','subject_id'));
        $filePath = 'public/marksheet/' . $session->session_name . '/' . $section->section_name . '-' . now()->format('Y-m-d_H-i-s') . '.pdf';
        // e.g., public/pdfs/generated_file.pdf

        // Save the PDF file to the public directory
        //$fullPath = public_path($filePath);
        $mpdf->Output($filePath, \Mpdf\Output\Destination::FILE);
        return asset($filePath);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function getGradeByMark($grades, $mark)
    {
        foreach ($grades as $grade) {
            if ($mark >= $grade->start_mark && $mark <= $grade->end_mark) {
                return $grade;
            }
        }
        return null;
    }
    public function store(Request $request)
    {

        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3) {
            return 1;
        }
        $request->validate([
            'session_id' => 'required|integer',
            'class_code' => 'required|integer',
            'exam_id' => 'required|integer',
            'subject_id' => 'required|integer',
            'section_id' => 'required|integer',

        ]);
        Session::put('session_id', $request->session_id);
        Session::put('class_code', $request->class_code);
        Session::put('exam_id', $request->exam_id);
        Session::put('section_id', $request->section_id);
        $grading = DB::table('grading')->get()->toArray();
        $subject = Subjects::find($request->subject_id);
        $section = Sections::find($request->section_id);


        $session_id = $request->session_id;
        $class_code = $request->class_code;
        $subject_id = $request->subject_id;
        $section_id = $request->section_id;
        $exam_id = $request->exam_id;

        $text = 'Something is wrong.';
        $maxvalue = 0;
        $heighestdata = array();
        $hattributes = array();
        $cq = 0;
        $cq_grace = 0;
        $cq_total = 0;
        $mcq = 0;
        $mcq_grace = 0;
        $mcq_total = 0;
        $practical = 0;
        $practical_grace = 0;
        $practical_total = 0;
        $cq = 0;

        $min1 = 0;
        $min2 = 0;
        $min3 = 0;
        $non_value = $request->non_value ?? 0;
        $version_id = $section->version_id;
        $group_id = $section->group_id;
        $i = 1;
        foreach ($request->student_code as $key => $student_code) {
            $i++;
            $pairSubjectdata = array();

            if ($subject->pair_subject) {

                $pairSubjectdata = StudentSubjectWiseMark::where('subject_id', $subject->pair_subject)
                    ->where('student_code', $student_code)
                    ->where('session_id', $request->session_id)
                    ->where('exam_id', $request->exam_id)
                    ->where('class_code', $request->class_code)
                    ->first();
            }
            if (isset($request->marks_for)) {
                foreach ($request->marks_for as $key1 => $marks_for) {
                    $attributes = [
                        'session_id' => $request->session_id,
                        'class_code' => $request->class_code,
                        'exam_id' => $request->exam_id,
                        'subject_id' => $request->subject_id,
                        'section_id' => $request->section_id,
                        'student_code' => $student_code,
                        'marks_for' => $marks_for
                    ];
                    $obtained = 'obtained' . $marks_for . $student_code;
                    $grace = 'grace' . $marks_for . $student_code;
                    $totalmarki = 'totalmark' . $marks_for . $student_code;




                    $obtainedvalue = $request->$obtained;
                    $gracevalue = $request->$grace;
                    $totalmark = (float)$request->$totalmarki;

                    //$totalmark=(int)$obtainedvalue+(int)$gracevalue;
                    if ($marks_for == 1) {
                        $cq = $obtainedvalue;
                        $cq_grace = $gracevalue;
                        $cq_total = $totalmark;
                        $min1 = 'min' . $marks_for . $student_code;
                    } elseif ($marks_for == 2) {
                        $mcq = $obtainedvalue;
                        $mcq_grace = $gracevalue;
                        $mcq_total = $totalmark;
                        $min2 = 'min' . $marks_for . $student_code;
                    } elseif ($marks_for == 3) {
                        $practical = $obtainedvalue;
                        $practical_grace = $gracevalue;
                        $practical_total = $totalmark;
                        $min3 = 'min' . $marks_for . $student_code;
                    }

                    $values = [
                        'session_id' => $request->session_id,
                        'class_code' => $request->class_code,
                        'exam_id' => $request->exam_id,
                        'subject_id' => $request->subject_id,
                        'section_id' => $request->section_id,
                        'student_code' => $student_code,
                        'version_id' => $version_id,
                        'group_id' => $group_id,
                        'marks_for' => $marks_for,
                        'obtained_mark' => $obtainedvalue,
                        'grace_mark' => $gracevalue,
                        'total_mark' => $totalmark,
                        'status' => 1,
                        'created_by' => auth()->user()->id,
                        'updated_by' => auth()->user()->id,
                    ];

                    //SubjectMark::updateOrCreate($attributes, $values);
                }
            }





            $totaltotalmarki = 'ctconv' . $student_code;
            $totaltotalmark = (float)$request->$totaltotalmarki;
            if ($maxvalue < $totaltotalmark) {
                $hattributes = [
                    'session_id' => $request->session_id,
                    'class_code' => $request->class_code,
                    'exam_id' => $request->exam_id,
                    'subject_id' => $request->subject_id,
                ];
                $heighestdata = [
                    'session_id' => $request->session_id,
                    'class_code' => $request->class_code,
                    'exam_id' => $request->exam_id,
                    'subject_id' => $request->subject_id,
                    'section_id' => $request->section_id,
                    'student_code' => $student_code,
                    'version_id' => $version_id,
                    'group_id' => $group_id,
                    'highest_mark' => $totaltotalmark,
                    'created_by' => auth()->user()->id,
                    'updated_by' => auth()->user()->id,
                ];
                $maxvalue = $totaltotalmark;
            }
            $optionalsubject = DB::table('student_subject')
                ->where('session_id', $request->session_id)
                ->where('class_code', $request->class_code)
                ->where('subject_id', $request->subject_id)
                ->where('student_code', $student_code)
                ->where('is_fourth_subject', 1)
                ->first();

            $ct1text = 'ct1' . $student_code;

            $ct2text = 'ct2' . $student_code;
            $ct3text = 'ct3' . $student_code;
            $cttext = 'ct' . $student_code;
            $totalmarkitext = 'totalmark' . $student_code;
            $totalconvitext = 'conv' . $student_code;
            $ctconvitext = 'ctconv' . $student_code;
            $gpapointtext = 'gpapoint' . $student_code;
            $gpatext = 'gpa' . $student_code;
            $is_absent = 'is_absent' . $student_code;


            $total = (float)$request->$totalmarkitext;
            $conv_total = (float)$request->$totalconvitext;
            $ct_conv_total = (float)$request->$ctconvitext;

            $gpa = $request->$gpatext;
            $gpa_point = $request->$gpapointtext;
            $is_pass = 1;
            $is_absent = (int)$request->$is_absent ?? 0;

            if ($pairSubjectdata) {

                $ct11 = ((int)($request->$cttext ?? 0) + ((int)$pairSubjectdata->ct ?? 0));
                //$ct11 = round($ct11);

                $cq_total1 = (((float)$pairSubjectdata->cq_total ?? 0) + ((float)$cq_total ?? 0));
                //$cq_total1 = round($cq_total1);

                if (isset($request->$min1) && $request->$min1 > $cq_total1) {
                    $is_pass = 0;
                }

                $mcq_total1 = (((int)$pairSubjectdata->mcq_total ?? 0) + ((int)$mcq_total ?? 0));
                //$mcq_total1 = round($mcq_total1);

                if (isset($request->$min2) && $request->$min2 > $mcq_total1) {
                    $is_pass = 0;
                }
                $practical_total1 = (((int)$pairSubjectdata->practical_total ?? 0) + ((int)$practical_total ?? 0));
                //$practical_total1 = round($practical_total1);

                if (isset($request->$min3) && $request->$min3 > $practical_total1) {
                    $is_pass = 0;
                }
                $total = round($practical_total1 + $mcq_total1 + $cq_total1, 2);

                $conv_total = round($total * (float)$request->percentage / 100, 2);

                $ct_conv_total = round($conv_total + $ct11, 2);
                $ctavarage = round($ct_conv_total);

                $gpa = ($is_pass) ? $this->calculateGpa200($ctavarage) : 'F';
                $gpa_point = ($is_pass) ? $this->calculateGpaPoint200($ctavarage) : 0;



                $ct_conv_total = round($ct_conv_total / 2, 2);
                $conv_total = round($conv_total / 2, 2);
                $total = round($total / 2, 2);

                $subjectdatapre = [
                    'total' => round($total, 2),
                    'conv_total' => $conv_total,
                    'ct_conv_total' => $ct_conv_total,
                    'gpa_point' => $gpa_point,
                    'gpa' => $gpa,
                ];

                StudentSubjectWiseMark::where('id', $pairSubjectdata->id)->update($subjectdatapre);
            }
            $subjectatt = [
                'session_id' => $request->session_id,
                'class_code' => $request->class_code,
                'exam_id' => $request->exam_id,
                'subject_id' => $request->subject_id,
                'student_code' => $student_code,
            ];

            $subjectdata = [
                'session_id' => $request->session_id,
                'class_code' => $request->class_code,
                'exam_id' => $request->exam_id,
                'subject_id' => $request->subject_id,
                'student_code' => $student_code,
                'ct1' => $request->$ct1text,
                'ct2' => $request->$ct2text,
                'ct3' => $request->$ct3text ?? null,
                'ct' => $request->$cttext,
                'cq' => $cq ?? null,
                'cq_grace' => $cq_grace ?? null,
                'cq_total' => (float)$cq_total ?? null,
                'mcq' => $mcq ?? null,
                'mcq_grace' => $mcq_grace ?? null,
                'mcq_total' => (float)$mcq_total ?? null,
                'practical' => $practical ?? null,
                'practical_grace' => $practical_grace ?? null,
                'practical_total' => (float)$practical_total ?? null,
                'total' => round((float)$total, 2),
                'conv_total' => $conv_total,
                'ct_conv_total' => $ct_conv_total,
                'gpa_point' => $gpa_point,
                'gpa' => $gpa,
                'is_fourth_subject' => ($optionalsubject) ? 1 : 0,
                'status' => ($gpa_point > 0) ? 1 : 0,
                'is_absent' => $is_absent,
                'non_value' => $non_value,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ];

            $data = StudentSubjectWiseMark::updateOrCreate($subjectatt, $subjectdata);

            $text = 'Subject Mark Added successfully.';
        }


        if ($heighestdata && $non_value != 1) {
            $ExamHighestMark = ExamHighestMark::where('session_id', $heighestdata['session_id'])
                ->where('class_code', $heighestdata['class_code'])
                ->where('exam_id', $heighestdata['exam_id'])
                ->where('subject_id', $heighestdata['subject_id'])
                ->where('highest_mark', '>', $totaltotalmark)
                ->whereNull('avarage_highest_mark');
            if ($heighestdata['class_code'] < 9) {
                $ExamHighestMark = $ExamHighestMark->where('version_id', $heighestdata['version_id']);
            }
            $ExamHighestMark = $ExamHighestMark->first();
            if ($heighestdata['class_code'] < 9) {
                $hattributes['version_id'] = $heighestdata['version_id'];
            }

            if (empty($ExamHighestMark) || $ExamHighestMark == null) {

                ExamHighestMark::updateOrCreate($hattributes, $heighestdata);
            }
        }
        //$this->saveAvarageMarksAuto($session_id,$class_code,$subject_id,$section_id,$exam_id);
        if ($non_value == 1) {
            return redirect()->route('other_subject_marks')->with('success', $text);
        }
        return redirect()->route('subject_marks.index')->with('success', $text);
    }
    public function saveStudentSubjectMark(Request $request)
    {

        // dd($request->practical);
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 3) {
            return 1;
        }
        $request->validate([
            'session_id' => 'required|integer',
            'class_code' => 'required|integer',
            'exam_id' => 'required|integer',
            'subject_id' => 'required|integer',
            'section_id' => 'required|integer',

        ]);
        Session::put('session_id', $request->session_id);
        Session::put('class_code', $request->class_code);
        Session::put('exam_id', $request->exam_id);
        Session::put('section_id', $request->section_id);
        $grading = DB::table('grading')->get()->toArray();
        $subject = Subjects::find($request->subject_id);
        $section = Sections::find($request->section_id);

        $session_id = $request->session_id;
        $class_code = $request->class_code;
        $subject_id = $request->subject_id;
        $section_id = $request->section_id;
        $exam_id = $request->exam_id;


        $text = 'Something is wrong.';
        $maxvalue = 0;
        $heighestdata = array();
        $hattributes = array();
        $cq = 0;
        $cq_grace = 0;
        $cq_total = 0;
        $mcq = 0;
        $mcq_grace = 0;
        $mcq_total = 0;
        $practical = 0;
        $practical_grace = 0;
        $practical_total = 0;
        $cq = 0;

        $min1 = 0;
        $min2 = 0;
        $min3 = 0;
        $non_value = $request->non_value ?? 0;
        $version_id = $section->version_id;
        $group_id = $section->group_id;
        $student_code = $request->student_code;


        $pairSubjectdata = array();

        if ($subject->pair_subject) {

            $pairSubjectdata = StudentSubjectWiseMark::where('subject_id', $subject->pair_subject)
                ->where('student_code', $student_code)
                ->where('session_id', $request->session_id)
                ->where('exam_id', $request->exam_id)
                ->where('class_code', $request->class_code)
                ->first();
        }
        if (isset($request->marks_for)) {
            foreach ($request->marks_for as $key1 => $marks_for) {
                $attributes = [
                    'session_id' => $request->session_id,
                    'class_code' => $request->class_code,
                    'exam_id' => $request->exam_id,
                    'subject_id' => $request->subject_id,
                    'section_id' => $request->section_id,
                    'student_code' => $student_code,
                    'marks_for' => $marks_for
                ];
                $obtained = 'obtained' . $marks_for;
                $grace = 'grace' . $marks_for;
                $totalmarki = 'totalmark' . $marks_for;




                $obtainedvalue = $request->$obtained;
                $gracevalue = $request->$grace;
                $totalmark = $request->$totalmarki;

                //$totalmark=(int)$obtainedvalue+(int)$gracevalue;
                if ($marks_for == 1) {
                    $cq = $obtainedvalue;
                    $cq_grace = $gracevalue;
                    $cq_total = $totalmark;
                    $min1 = 'min' . $marks_for;
                } elseif ($marks_for == 2) {
                    $mcq = $obtainedvalue;
                    $mcq_grace = $gracevalue;
                    $mcq_total = $totalmark;
                    $min2 = 'min' . $marks_for;
                } elseif ($marks_for == 3) {
                    $practical = $obtainedvalue;
                    $practical_grace = $gracevalue;
                    $practical_total = $totalmark;
                    $min3 = 'min' . $marks_for;
                }

                $values = [
                    'session_id' => $request->session_id,
                    'class_code' => $request->class_code,
                    'exam_id' => $request->exam_id,
                    'subject_id' => $request->subject_id,
                    'section_id' => $request->section_id,
                    'student_code' => $student_code,
                    'version_id' => $version_id,
                    'group_id' => $group_id,
                    'marks_for' => $marks_for,
                    'obtained_mark' => $obtainedvalue,
                    'grace_mark' => $gracevalue,
                    'total_mark' => $totalmark,
                    'status' => 1,
                    'created_by' => auth()->user()->id,
                    'updated_by' => auth()->user()->id,
                ];

                SubjectMark::updateOrCreate($attributes, $values);
            }
        }

        $totaltotalmarki = 'ctconv';
        $totaltotalmark = (int)$request->$totaltotalmarki;
        if ($maxvalue < $totaltotalmark) {
            $hattributes = [
                'session_id' => $request->session_id,
                'class_code' => $request->class_code,
                'exam_id' => $request->exam_id,
                'subject_id' => $request->subject_id,
            ];
            $heighestdata = [
                'session_id' => $request->session_id,
                'class_code' => $request->class_code,
                'exam_id' => $request->exam_id,
                'subject_id' => $request->subject_id,
                'section_id' => $request->section_id,
                'student_code' => $student_code,
                'version_id' => $version_id,
                'group_id' => $group_id,
                'highest_mark' => $totaltotalmark,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ];
            $maxvalue = $totaltotalmark;
        }
        $optionalsubject = DB::table('student_subject')
            ->where('session_id', $request->session_id)
            ->where('class_code', $request->class_code)
            ->where('subject_id', $request->subject_id)
            ->where('student_code', $student_code)
            ->where('is_fourth_subject', 1)
            ->first();

        $ct1text = 'ct1';

        $ct2text = 'ct2';
        $ct3text = 'ct3';
        $ct4text = 'ct4';
        $cttext = 'ct';
        $totalmarkitext = 'totalmark';
        $totalconvitext = 'conv';
        $ctconvitext = 'ctconv';
        $gpapointtext = 'gpapoint';
        $gpatext = 'gpa';
        $is_absent = 'is_absent';

        if ($request->class_code <= 2) {
            $total = $request->$totalmarkitext;
            $total1 = $request->$totalmarkitext;
            $conv_total = $request->$totalconvitext;
            $conv_total1 = $request->$totalconvitext;
            $ct_conv_total = $request->$ctconvitext;
        } else {
            $total = (int)$request->$totalmarkitext;
            $total1 = (int)$request->$totalmarkitext;
            $conv_total = (int)$request->$totalconvitext;
            $conv_total1 = (int)$request->$totalconvitext;
            $ct_conv_total = (int)$request->$ctconvitext;
        }


        $gpa = $request->$gpatext;
        $gpa_point = $request->$gpapointtext;
        $is_pass = 1;
        $is_absent = $request->$is_absent ?? 0;

        if ($pairSubjectdata) {
            if ($request->class_code >= 6 && $request->class_code <= 8) {
                $ct11 = ((int)($request->$cttext ?? 0) + ((int)$pairSubjectdata->ct ?? 0));
                //$ct11 = round($ct11);

                $cq_total1 = (((int)$pairSubjectdata->cq_total ?? 0) + ((int)$cq_total ?? 0));
                //$cq_total1 = round($cq_total1);
                //dd($request->$min1,$cq_total1);
                if (isset($request->$min1) && ($request->$min1 * 2) > $cq_total1 && $request->class_code != 6) {
                    $is_pass = 0;
                }

                $mcq_total1 = (((int)$pairSubjectdata->mcq_total ?? 0) + ((int)$mcq_total ?? 0));
                //$mcq_total1 = round($mcq_total1);

                if (isset($request->$min2) && ($request->$min2 * 2) > $mcq_total1  && $request->class_code != 6) {
                    $is_pass = 0;
                }
                $practical_total1 = (((int)$pairSubjectdata->practical_total ?? 0) + ((int)$practical_total ?? 0));
                //$practical_total1 = round($practical_total1);

                if (isset($request->$min3) && ($request->$min3 * 2) > $practical_total1 && $request->class_code != 6) {
                    $is_pass = 0;
                }

                // $total = round($practical_total1 + $mcq_total1 + $cq_total1);

                // $conv_total = $total * (int)$request->percentage / 100;
                //dd($pairSubjectdata);
                if ($pairSubjectdata->subject_id == 58 || $pairSubjectdata->subject_id == 61) {
                    $totalmark1 = $pairSubjectdata->ct_conv_total;
                } elseif ($request->subject_id == 58 || $request->subject_id == 61) {
                    $totalmark1 = $request->totalmark;
                }

                if ($pairSubjectdata->subject_id == 59 || $pairSubjectdata->subject_id == 62) {
                    $ftotalmark = ($pairSubjectdata->ct_conv_total / 50) * 100;
                } elseif ($request->subject_id == 59 || $request->subject_id == 62) {
                    $ftotalmark = ($request->totalmark / 50) * 100;
                }
                $ct_conv_total1 = $totalmark1 + $ftotalmark;
                $ctavarage1 = round($ct_conv_total1);

                $gpa = ($is_pass) ? $this->calculateGpa200($ctavarage1) : 'F';
                $gpa_point = ($is_pass) ? $this->calculateGpaPoint200($ctavarage1) : 0;





                $subjectdatapre = [
                    // 'total' => $total,
                    // 'conv_total' => $conv_total,
                    // 'ct_conv_total' => $ct_conv_total,
                    'gpa_point' => $gpa_point,
                    'gpa' => $gpa,
                ];

                StudentSubjectWiseMark::where('id', $pairSubjectdata->id)->update($subjectdatapre);
            } else {
                $ct11 = ((int)($request->$cttext ?? 0) + ((int)$pairSubjectdata->ct ?? 0));
                //$ct11 = round($ct11);

                $cq_total1 = (((int)$pairSubjectdata->cq_total ?? 0) + ((int)$cq_total ?? 0));
                //$cq_total1 = round($cq_total1);
                //dd($request->$min1,$cq_total1);
                if (isset($request->$min1) && ($request->$min1 * 2) > $cq_total1) {
                    $is_pass = 0;
                }

                $mcq_total1 = (((int)$pairSubjectdata->mcq_total ?? 0) + ((int)$mcq_total ?? 0));
                //$mcq_total1 = round($mcq_total1);

                if (isset($request->$min2) && ($request->$min2 * 2) > $mcq_total1) {
                    $is_pass = 0;
                }
                $practical_total1 = (((int)$pairSubjectdata->practical_total ?? 0) + ((int)$practical_total ?? 0));
                //$practical_total1 = round($practical_total1);

                if (isset($request->$min3) && ($request->$min3 * 2) > $practical_total1) {
                    $is_pass = 0;
                }

                $total = round($practical_total1 + $mcq_total1 + $cq_total1);

                $conv_total = $total * (int)$request->percentage / 100;

                $ct_conv_total = $conv_total + $ct11;
                $ctavarage = round($ct_conv_total);

                $gpa = ($is_pass) ? $this->calculateGpa200($ctavarage) : 'F';
                $gpa_point = ($is_pass) ? $this->calculateGpaPoint200($ctavarage) : 0;



                $ct_conv_total = $ct_conv_total / 2;
                $conv_total = $conv_total / 2;
                $total = $total / 2;

                $subjectdatapre = [
                    'total' => $total,
                    'conv_total' => $conv_total,
                    'ct_conv_total' => $ct_conv_total,
                    'gpa_point' => $gpa_point,
                    'gpa' => $gpa,
                ];

                StudentSubjectWiseMark::where('id', $pairSubjectdata->id)->update($subjectdatapre);
            }
        }
        $subjectatt = [
            'session_id' => $request->session_id,
            'class_code' => $request->class_code,
            'exam_id' => $request->exam_id,
            'subject_id' => $request->subject_id,
            'student_code' => $student_code,
        ];

        $subjectdata = [
            'session_id' => $request->session_id,
            'class_code' => $request->class_code,
            'exam_id' => $request->exam_id,
            'subject_id' => $request->subject_id,
            'student_code' => $student_code,
            'ct1' => $request->$ct1text,
            'ct2' => $request->$ct2text,
            'ct3' => $request->$ct3text ?? null,
            'ct4' => $request->$ct4text ?? null,
            'ct' => $request->ct ?? $request->$cttext ?? $request->ct,
            'cq' => $request->cq ?? $cq ?? null,
            'cq_grace' => $cq_grace ?? null,
            'cq_total' => (int)$cq_total ?? null,
            'mcq' => $request->mcq ?? $mcq ?? null,
            'mcq_grace' => $mcq_grace ?? null,
            'mcq_total' => (int)$mcq_total ?? null,
            'practical' => $request->practical ?? $practical ?? null,
            'practical_grace' => $practical_grace ?? null,
            'practical_total' => (int)$practical_total ?? null,
            'total' => $total,
            'conv_total' => $conv_total ?? null,
            'ct_conv_total' => $ct_conv_total ?? null,
            'gpa_point' => $request->gpapoint ?? $gpa_point,
            'gpa' => $request->gpa ?? $gpa,
            'is_fourth_subject' => ($optionalsubject) ? 1 : 0,
            'status' => ($gpa_point > 0) ? 1 : 0,
            'is_absent' => $is_absent,
            'non_value' => $non_value,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ];

        $data = StudentSubjectWiseMark::updateOrCreate($subjectatt, $subjectdata);

        $text = 'Subject Mark Added successfully.';

        // dd($heighestdata, $non_value, $totaltotalmark);

        if ($heighestdata && $non_value != 1) {
            $ExamHighestMark = ExamHighestMark::where('session_id', $heighestdata['session_id'])
                ->where('class_code', $heighestdata['class_code'])
                ->where('exam_id', $heighestdata['exam_id'])
                ->where('subject_id', $heighestdata['subject_id'])
                ->where('highest_mark', '>', $totaltotalmark)
                ->whereNull('avarage_highest_mark');
            if ($heighestdata['class_code'] < 9) {
                $ExamHighestMark = $ExamHighestMark->where('version_id', $heighestdata['version_id']);
            }
            $ExamHighestMark = $ExamHighestMark->first();
            if ($heighestdata['class_code'] < 9) {
                $hattributes['version_id'] = $heighestdata['version_id'];
            }

            if (empty($ExamHighestMark) || $ExamHighestMark == null) {

                ExamHighestMark::updateOrCreate($hattributes, $heighestdata);
            }
        }
        // $this->saveAvarageMarksAuto($session_id,$class_code,$subject_id,$section_id,$exam_id);
        if ($non_value == 1) {
            return 1;
        }
        return 1;
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
