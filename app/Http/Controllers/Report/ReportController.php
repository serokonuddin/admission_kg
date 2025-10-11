<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeActivity;
use App\Models\Exam\Exam;
use App\Models\Exam\ExamHighestMark;
use App\Models\sttings\AcademySection;
use App\Models\sttings\Classes;
use App\Models\sttings\Sections;
use App\Models\sttings\Sessions;
use App\Models\sttings\Shifts;
use App\Models\sttings\Subjects;
use App\Models\sttings\Versions;
use App\Models\Student\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Mpdf\Mpdf;

class ReportController extends Controller
{

    // Common version and shift
    public function getVersionAndShift(Request $request)
    {
        $exam = Exam::where('class_code', $request->class_code)->first();
        $classes = Classes::where('class_code', $request->class_code)->get();
        $session = null;
        $currentYear = date('Y');
        $currentMonth = date('n'); // Numeric representation of the current month (1-12)

        // Adjust the year based on the current month
        if ($currentMonth > 6) { // If current month is after June
            $collegeSession = $currentYear . '-' . ($currentYear + 1);
        } else { // If current month is June or earlier
            $collegeSession = ($currentYear - 1) . '-' . $currentYear;
        }

        // Determine the session based on the class level or context
        if ($request->class_code > 10) {
            // For classes 11 and 12, use the `college_session`
            $session = Sessions::where('college_session', $collegeSession)->first();
        } else {
            // For other classes, use the active session
            $session = Sessions::where('active', 1)->orderBy('created_at', 'desc')->first();
        }

        // If no session is found, return an error
        if (!$session) {
            return redirect()->back()->with('error', 'Session not found.');
        }

        session()->put('session_id', $session->session_code);

        if ($request->ajax()) {
            return view('report.average_mark.ajaxversion', compact('classes', 'exam', 'session'))->render();
        }
        return view('report.average_mark.ajaxversion', compact('classes', 'exam', 'session'));
    }

    public function getShiftsForVersion(Request $request)
    {
        $class_code = $request->class_code;
        $version_id = $request->version_id;
        $session_id = $request->session_id;
        $exam_id = $request->exam_id;

        // Fetch distinct shifts for the given class and version
        $shifts = Classes::where('version_id', $version_id)
            ->where('class_code', $class_code)
            ->distinct('shift_id')
            ->select('shift_id')
            ->get();

        // Fetch sections and shift-wise average marks in a single query
        $shiftMarks = Student::join(
            'student_activity as sta',
            'sta.student_code',
            '=',
            'students.student_code'
        )
            ->join('sections', 'sections.id', '=', 'sta.section_id')
            ->join('student_subject_wise_mark as sswm', 'sswm.student_code', '=', 'students.student_code')
            ->where('sta.session_id', $session_id)
            ->where('sta.class_code', $class_code)
            ->where('sta.version_id', $version_id)
            ->where('sswm.session_id', $session_id)
            ->where('sswm.exam_id', $exam_id)
            ->select(
                'sections.shift_id',
                DB::raw('round(AVG(sswm.conv_total), 2) as average_mark')
            )
            ->groupBy('sections.shift_id')
            ->get();

        // $shiftAverageMarks = [];
        // foreach ($shifts as $shift) {
        //     $data = $shiftMarks->firstWhere('shift_id', $shift->shift_id);
        //     $shiftAverageMarks[$shift->shift_id] = $data ? $data->average_mark : '0';
        // }

        $marksByShift = $shiftMarks->keyBy('shift_id');
        // Prepare shiftAttendanceData with default '0' values for all shifts
        $shiftAverageMarks = [];
        foreach ($shifts as $shift) {
            $shiftAverageMarks[$shift->shift_id] = $marksByShift->has($shift->shift_id)
                ? $marksByShift[$shift->shift_id]->average_mark
                : '0';
        }
        session()->put('shiftAverageMarks', $shiftAverageMarks);
        $html = view('report.average_mark.ajaxshift', compact('shifts', 'shiftAverageMarks'))->render();
        return response()->json(['html' => $html]);
    }

    // Average Mark report starts
    public function averagemarkReport()
    {
        Session::put('activemenu', 'report');
        Session::put('activesubmenu', 'mr');
        $session = Sessions::where('active', 1)->first();

        return view('report.average_mark.index', compact('session'));
    }

    public function getClassWiseSection(Request $request)
    {

        $class_code = $request->class_code ?? null;
        $version_id = $request->version_id ?? null;
        $shift_id = $request->shift_id ?? null;
        $session_id = $request->session_id ?? null;
        $exam_id = $request->exam_id ?? null;

        $sections = Sections::join('classes', 'classes.class_code', '=', 'sections.class_code')
            ->join('versions', 'versions.id', '=', 'sections.version_id')
            ->join('shifts', 'shifts.id', '=', 'sections.shift_id')
            ->join('sessions', 'sessions.id', '=', DB::raw($session_id)) // Join session
            ->where('sections.class_code', $class_code)
            ->where('sections.version_id', $version_id)
            ->where('sections.shift_id', $shift_id)
            ->select(
                'sections.id',
                'sections.section_name',
                'classes.class_name',
                'versions.version_name',
                'shifts.shift_name',
                'sessions.session_name' // Fetch session name
            )
            ->distinct() // Ensure unique results
            ->get();


        if ($sections->isEmpty()) {
            return redirect()->back()->with('error', 'No sections found for the selected criteria.');
        }

        $sectionMarks = [];
        foreach ($sections as $section) {

            $section_id = $section->id;

            $students =  Student::join('student_activity as sta', 'sta.student_code', '=', 'students.student_code')
                ->join('sections', 'sections.id', '=', 'sta.section_id')
                ->join('student_subject_wise_mark as sswm', 'sswm.student_code', '=', 'students.student_code')
                ->where('sta.session_id', $request->session_id)
                ->where('sta.class_code', $request->class_code);

            if ($section_id) {
                $students = $students->where('sta.section_id',  $section_id);
            }
            if ($version_id) {
                $students = $students->where('sta.version_id', $version_id);
            }

            $students = $students->where('sswm.session_id', $session_id);

            $averageMarks = $students->where('sswm.class_code', $class_code)
                ->where('sswm.exam_id', $exam_id)
                ->select(DB::raw('round(AVG(sswm.conv_total),2) as average_mark'))
                ->value('average_mark');

            $sectionMarks[$section->id] = $averageMarks ?? 0;

            $headerData = [
                'class_name' => $section->class_name,
                'version_name' => $section->version_name,
                'shift_name' => $section->shift_name,
                'session_name' => $section->session_name,
            ];
        }


        session()->put('sectionMarks', $sectionMarks);
        session()->put('sections', $sections);
        session()->put('headerData', $headerData);

        $redirectUrl = route('all_sections_page', [
            'class_code' => $class_code,
            'version_id' => $version_id,
            'shift_id' => $shift_id,
            'session_id' => $session_id,
            'exam_id' => $exam_id,
        ]);
        return response()->json(['redirect_url' => $redirectUrl]);
    }

    public function showAllSections(Request $request)
    {
        $sections = session()->get('sections', []);
        $sectionMarks = session()->get('sectionMarks', []);
        $headerData = session()->get('headerData', []);
        $class_code = $request->class_code;
        $version_id = $request->version_id;
        $shift_id = $request->shift_id;
        $session_id = $request->session_id;
        $exam_id = $request->exam_id;

        // Define breadcrumbs
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Average Mark Report', 'url' => route('average.mark.report')],
            ['name' => 'Sections', 'url' => ''], // Current page
        ];

        return view('report.average_mark.all_sections', compact('sections', 'headerData', 'session_id', 'exam_id', 'sectionMarks', 'breadcrumbs', 'class_code', 'version_id', 'shift_id'));
    }

    public function getAverageMarkReport(Request $request)
    {
        $class_code = $request->class_code ?? null;
        $version_id = $request->version_id ?? null;
        $shift_id = $request->shift_id ?? null;
        $section_id = $request->section_id ?? null;
        $session_id = $request->session_id ?? null;
        $exam_id = $request->exam_id ?? null;

        if (!$section_id) {
            return response()->json(['error' => 'Section ID is required'], 400);
        }

        $students = Student::join('student_activity as sta', 'sta.student_code', '=', 'students.student_code')
            ->join('sections', 'sections.id', '=', 'sta.section_id')
            ->join('student_subject_wise_mark as sswm', 'sswm.student_code', '=', 'students.student_code')
            ->join('subjects as sub', 'sswm.subject_id', '=', 'sub.id')
            ->join('versions', 'versions.id', '=', 'sta.version_id')  // Join versions table
            ->join('shifts', 'shifts.id', '=', 'sta.shift_id')        // Join shifts table
            ->join('sessions', 'sessions.id', '=', 'sta.session_id')  // Join sessions table
            ->join('exam', 'exam.id', '=', 'sswm.exam_id')
            ->join('classes', 'classes.class_code', '=', 'sta.class_code')
            ->leftJoin('employee_activity as ea', function ($join) {
                $join->on('ea.section_id', '=', 'sta.section_id')
                    ->where('ea.is_class_teacher', '=', 1)
                    ->where('ea.active', '=', 1);
            })
            ->leftJoin('employees as e', 'e.id', '=', 'ea.employee_id')
            ->where('sta.session_id', $session_id)
            ->where('sta.class_code', $class_code);

        if ($section_id) {
            $students = $students->where('sta.section_id', $section_id);
        }
        if ($version_id) {
            $students = $students->where('sta.version_id', $version_id);
        }

        $students = $students->where('sswm.session_id', $session_id);

        $results = $students->where('sswm.class_code', $class_code)
            ->where('sswm.exam_id', $exam_id)
            ->select(
                'sub.subject_name',
                'classes.class_name',
                'sections.section_name',
                'versions.version_name',
                'shifts.shift_name',
                'sessions.session_name',
                'exam.exam_title',
                // DB::raw('MAX(e.employee_name) as class_teacher_name'),
                DB::raw('round(AVG(sswm.conv_total),2) AS obtained_mark')
            )
            ->groupBy(
                'sta.class_code',
                'sta.section_id',
                'sta.version_id',
                'sswm.subject_id',
                'sswm.exam_id',
                'classes.class_name',
                'sub.subject_name',
                'sections.section_name',
                'versions.version_name',
                'shifts.shift_name',
                'sessions.session_name',
                'exam.exam_title',
                // 'e.employee_name'
            )
            ->orderBy('sswm.subject_id')
            ->get();

        session()->put('results', $results);

        $redirectUrl = route('showAverageMarkReport');
        return response()->json(['redirect_url' => $redirectUrl]);
    }


    public function showAverageMarkReportResults(Request $request)
    {
        $results = session()->get('results', []);

        // Define breadcrumbs
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Average Mark Report', 'url' => route('average.mark.report')],
            ['name' => 'Sections', 'url' =>  route('all_sections_page')], // Current page
            ['name' => 'report', 'url' => ''], // Current page
        ];

        return view('report.average_mark.average_mark_report', compact('breadcrumbs', 'results'));
    }

    // Fail Students report starts
    public function averageFailStudentReport()
    {
        Session::put('activemenu', 'report');
        Session::put('activesubmenu', 'afsr');

        $session = Sessions::where('active', 1)->first();

        return view('report.fail_report.index', compact('session'));
    }
    public function getShiftsForFail(Request $request)
    {

        $class_code = $request->class_code ?? null;
        $version_id = $request->version_id ?? null;
        $session_id = $request->session_id ?? null;
        $exam_id = $request->exam_id ?? null;

        // Fetch shifts grouped by version and class
        $shifts = Classes::where('version_id', $version_id)
            ->where('class_code', $class_code)
            ->distinct('shift_id')
            ->select('shift_id')
            ->get();

        // Calculate shift-wise fail percentages
        $shiftFailPercentages = Sections::join('classes', 'classes.class_code', '=', 'sections.class_code')
            ->join('versions', 'versions.id', '=', 'sections.version_id')
            ->join(
                'shifts',
                'shifts.id',
                '=',
                'sections.shift_id'
            )
            ->join('sessions', 'sessions.id', '=', DB::raw($session_id))
            ->join('student_activity as sta', 'sta.section_id', '=', 'sections.id')
            ->join('student_subject_wise_mark as sswm', 'sswm.student_code', '=', 'sta.student_code')
            ->where('sections.class_code', $class_code)
            ->where('sections.version_id', $version_id)
            ->where('sswm.exam_id', $exam_id)
            ->where('sswm.session_id', $session_id)
            ->select(
                'sections.shift_id',
                DB::raw('COUNT(CASE WHEN sswm.gpa = "F" THEN 1 END) AS failing_students'),
                DB::raw('COUNT(*) AS total_students'),
                DB::raw('ROUND((COUNT(CASE WHEN sswm.gpa = "F" THEN 1 END) / COUNT(*)) * 100, 2) AS fail_percentage')
            )
            ->groupBy('sections.shift_id')
            ->get();

        // Map fail percentages to shifts
        $shiftFailData = [];
        foreach ($shifts as $shift) {
            $failData = $shiftFailPercentages->firstWhere('shift_id', $shift->shift_id);
            $shiftFailData[$shift->shift_id] = $failData ? $failData->fail_percentage : '0';
        }

        // Pass data to session for Blade usage
        session()->put('shiftFailData', $shiftFailData);

        $html = view('report.fail_report.ajaxshift', compact('shifts', 'shiftFailData'))->render();
        return response()->json(['html' => $html]);
    }
    public function getFailSection(Request $request)
    {

        $class_code = $request->class_code ?? null;
        $version_id = $request->version_id ?? null;
        $shift_id = $request->shift_id ?? null;
        $session_id = $request->session_id ?? null;
        $exam_id = $request->exam_id ?? null;

        $sections = Sections::join('classes', 'classes.class_code', '=', 'sections.class_code')
            ->join('versions', 'versions.id', '=', 'sections.version_id')
            ->join('shifts', 'shifts.id', '=', 'sections.shift_id')
            ->join('sessions', 'sessions.id', '=', DB::raw($session_id)) // Join session
            ->where('sections.class_code', $class_code)
            ->where('sections.version_id', $version_id)
            ->where('sections.shift_id', $shift_id)
            ->select(
                'sections.id',
                'sections.section_name',
                'classes.class_name',
                'versions.version_name',
                'shifts.shift_name',
                'sessions.session_name' // Fetch session name
            )
            ->distinct()
            ->get();

        if ($sections->isEmpty()) {
            return redirect()->back()->with('error', 'No sections found for the selected criteria.');
        }

        $sectionMarks = [];
        foreach ($sections as $section) {

            $section_id = $section->id;
            $students =  Student::join('student_activity as sta', 'sta.student_code', '=', 'students.student_code')
                ->join('sections', 'sections.id', '=', 'sta.section_id')
                ->join('student_subject_wise_mark as sswm', 'sswm.student_code', '=', 'students.student_code')
                ->where('sta.session_id', $request->session_id)
                ->where('sta.class_code', $request->class_code);

            if ($section_id) {
                $students = $students->where('sta.section_id', $section_id);
            }
            if ($version_id) {
                $students = $students->where('sta.version_id', $version_id);
            }

            $students = $students->where('sswm.session_id', $session_id);

            // Calculate fail percentage for the section
            $failPercentage = $students->where('sswm.class_code', $class_code)
                ->where('sswm.exam_id', $exam_id)
                ->select(
                    DB::raw('ROUND((SUM(CASE WHEN sswm.gpa = "F" THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) AS fail_percentage')
                )
                ->first();

            $sectionMarks[$section->id] = $failPercentage->fail_percentage ?? 0;
            $headerData = [
                'class_name' => $section->class_name,
                'version_name' => $section->version_name,
                'shift_name' => $section->shift_name,
                'session_name' => $section->session_name,
            ];
        }

        session()->put('sectionMarks', $sectionMarks);
        session()->put('sections', $sections);
        session()->put('headerData', $headerData);

        $redirectUrl = route('show_all_fail_sections_page', [
            'class_code' => $class_code,
            'version_id' => $version_id,
            'shift_id' => $shift_id,
            'session_id' => $session_id,
            'exam_id' => $exam_id,
        ]);
        return response()->json(['redirect_url' => $redirectUrl]);
    }

    public function showAllFailSections(Request $request)
    {
        $sections = session()->get('sections', []);
        $sectionMarks = session()->get('sectionMarks', []);
        $headerData = session()->get('headerData', []);
        $class_code = $request->class_code;
        $version_id = $request->version_id;
        $shift_id = $request->shift_id;
        $session_id = $request->session_id;
        $exam_id = $request->exam_id;

        // Define breadcrumbs
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Fail Students Report', 'url' => route('average.fail.report')],
            ['name' => 'Sections', 'url' => ''], // Current page
        ];

        return view('report.fail_report.all_sections', compact('sections', 'headerData', 'session_id', 'exam_id', 'sectionMarks', 'breadcrumbs', 'class_code', 'version_id', 'shift_id'));
    }

    public function getAverageFailMarkReport(Request $request)
    {
        $class_code = $request->class_code ?? null;
        $version_id = $request->version_id ?? null;
        $shift_id = $request->shift_id ?? null;
        $section_id = $request->section_id ?? null;
        $session_id = $request->session_id ?? null;
        $exam_id = $request->exam_id ?? null;

        if (!$section_id) {
            return response()->json(['error' => 'Section ID is required'], 400);
        }

        $students =  Student::join('student_activity as sta', 'sta.student_code', '=', 'students.student_code')
            ->join('sections', 'sections.id', '=', 'sta.section_id')
            ->join('student_subject_wise_mark as sswm', 'sswm.student_code', '=', 'students.student_code')
            ->join('subjects as sub', 'sswm.subject_id', '=', 'sub.id')
            ->join('versions', 'versions.id', '=', 'sta.version_id')  // Join versions table
            ->join('shifts', 'shifts.id', '=', 'sta.shift_id')        // Join shifts table
            ->join('sessions', 'sessions.id', '=', 'sta.session_id')  // Join sessions table
            ->join('exam', 'exam.id', '=', 'sswm.exam_id')
            ->join('classes', 'classes.class_code', '=', 'sta.class_code')
            ->leftJoin('employee_activity as ea', function ($join) {
                $join->on('ea.section_id', '=', 'sta.section_id')
                    ->where('ea.is_class_teacher', '=', 1)
                    ->where('ea.active', '=', 1);
            })
            ->leftJoin('employees as e', 'e.id', '=', 'ea.employee_id')
            ->where('sta.session_id', $session_id)
            ->where('sta.class_code', $class_code);

        if ($section_id) {
            $students = $students->where('sta.section_id', $section_id);
        }
        if ($version_id) {
            $students = $students->where('sta.version_id', $version_id);
        }

        $students = $students->where('sswm.session_id', $session_id);

        $results = $students->where('sswm.class_code', $class_code)
            ->where('sswm.exam_id', $exam_id)
            ->select(
                'sub.subject_name',
                'classes.class_name',
                'sections.section_name',
                'versions.version_name',
                'shifts.shift_name',
                'sessions.session_name',
                'exam.exam_title',
                DB::raw('COUNT(CASE WHEN sswm.gpa = "F" THEN 1 END) AS failing_students'),
                DB::raw('COUNT(*) AS total_students'),
                DB::raw('ROUND((COUNT(CASE WHEN sswm.gpa = "F" THEN 1 END) / COUNT(*)) * 100, 2) AS fail_percentage'),
                // DB::raw('MAX(e.employee_name) as class_teacher_name'),
            )
            ->groupBy(
                'sta.class_code',
                'sta.section_id',
                'sta.version_id',
                'sswm.subject_id',
                'sswm.exam_id',
                'classes.class_name',
                'sub.subject_name',
                'sections.section_name',
                'versions.version_name',
                'shifts.shift_name',
                'sessions.session_name',
                'exam.exam_title',
                // 'e.employee_name'
            )
            ->orderBy('sswm.subject_id')
            ->get();

        session()->put('results', $results);

        $redirectUrl = route('show.average.fail.mark.report');
        return response()->json(['redirect_url' => $redirectUrl]);
    }

    public function showAverageFailMarkReportResults(Request $request)
    {
        $results = session()->get('results', []);

        // Define breadcrumbs
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Fail Students Report', 'url' => route('average.fail.report')],
            ['name' => 'Sections', 'url' =>  route('show.average.fail.mark.report')],
            ['name' => 'report', 'url' => ''], // Current page
        ];

        return view('report.fail_report.report', compact('breadcrumbs', 'results'));
    }

    // Highest Mark Report starts
    public function averageHighestMarkReport()
    {
        Session::put('activemenu', 'report');
        Session::put('activesubmenu', 'ahmr');
        $session = Sessions::where('active', 1)->first();

        return view('report.highest_mark.index', compact('session'));
    }

    public function getShiftsForHighest(Request $request)
    {

        $class_code = $request->class_code ?? null;
        $version_id = $request->version_id ?? null;
        $session_id = $request->session_id ?? null;
        $exam_id = $request->exam_id ?? null;

        // Fetch shifts grouped by version and class
        $shifts = Classes::where('version_id', $version_id)
            ->where('class_code', $class_code)
            ->distinct('shift_id')
            ->select('shift_id')
            ->get();

        // Calculate shift-wise fail percentages
        $shiftData = Sections::join('classes', 'classes.class_code', '=', 'sections.class_code')
            ->join('versions', 'versions.id', '=', 'sections.version_id')
            ->join(
                'shifts',
                'shifts.id',
                '=',
                'sections.shift_id'
            )
            ->join('sessions', 'sessions.id', '=', DB::raw($session_id))
            ->join('student_activity as sta', 'sta.section_id', '=', 'sections.id')
            ->join('student_subject_wise_mark as sswm', 'sswm.student_code', '=', 'sta.student_code')
            ->where('sections.class_code', $class_code)
            ->where('sections.version_id', $version_id)
            ->where('sswm.exam_id', $exam_id)
            ->where('sswm.session_id', $session_id)
            ->select(
                'sections.shift_id',
                'sswm.subject_id',
                DB::raw('MAX(sswm.conv_total) as highest_mark')
            )
            ->groupBy('sections.shift_id', 'sswm.subject_id')
            ->get();

        $shiftHighestData = [];
        foreach ($shifts as $shift) {
            $shiftHighestData[$shift->shift_id] = $shiftData ?
                $shiftData->where('shift_id', $shift->shift_id)
                ->avg('highest_mark') : '0';
        }
        // Pass data to session for Blade usage
        session()->put('shiftHighestData', $shiftHighestData);

        $html = view('report.highest_mark.ajaxshift', compact('shifts', 'shiftHighestData'))->render();
        return response()->json(['html' => $html]);
    }
    public function highestSection(Request $request)
    {
        $session_id = $request->session_id ?? 2024;
        $class_code = $request->class_code ?? null;
        $version_id = $request->version_id ?? null;
        $shift_id = $request->shift_id ?? null;
        $exam_id = $request->exam_id ?? null;

        $sections = Sections::join('classes', 'classes.class_code', '=', 'sections.class_code')
            ->join('versions', 'versions.id', '=', 'sections.version_id')
            ->join('shifts', 'shifts.id', '=', 'sections.shift_id')
            ->join('sessions', 'sessions.id', '=', DB::raw($session_id)) // Join session
            ->where('sections.class_code', $class_code)
            ->where('sections.version_id', $version_id)
            ->where('sections.shift_id', $shift_id)
            ->select(
                'sections.id',
                'sections.section_name',
                'classes.class_name',
                'versions.version_name',
                'shifts.shift_name',
                'sessions.session_name' // Fetch session name
            )
            ->distinct()
            ->get();

        if ($sections->isEmpty()) {
            return redirect()->back()->with('error', 'No sections found for the selected criteria.');
        }

        // Calculate average highest marks for each section
        $sectionMarks = [];
        foreach ($sections as $section) {

            $section_id = $section->id;
            // Get the highest mark for each subject in the section
            $highestMarks = Student::join('student_activity as sta', 'sta.student_code', '=', 'students.student_code')
                ->join('sections', 'sections.id', '=', 'sta.section_id')
                ->join('student_subject_wise_mark as sswm', 'sswm.student_code', '=', 'students.student_code')
                ->where('sta.session_id', $session_id)
                ->where('sta.version_id', $version_id)
                ->where('sta.class_code', $class_code)
                ->where('sta.section_id', $section_id)
                ->where('sswm.session_id', $session_id)
                ->where('sswm.exam_id', $exam_id)
                ->select('sswm.subject_id', DB::raw('MAX(sswm.conv_total) as highest_mark'))
                ->groupBy('sswm.subject_id')
                ->get();


            $averageHighestMark = $highestMarks->avg('highest_mark');
            $sectionMarks[$section->id] = $averageHighestMark ?? 0;


            $headerData = [
                'class_name' => $section->class_name,
                'version_name' => $section->version_name,
                'shift_name' => $section->shift_name,
                'session_name' => $section->session_name,
            ];
        }

        // Store sections and marks in the session
        session()->put('sectionMarks', $sectionMarks);
        session()->put('sections', $sections);
        session()->put('headerData', $headerData);

        $redirectUrl = route('show_all_sections_page', [
            'class_code' => $class_code,
            'version_id' => $version_id,
            'shift_id' => $shift_id,
            'session_id' => $session_id,
            'exam_id' => $exam_id,
        ]);

        return response()->json(['redirect_url' => $redirectUrl]);
    }


    public function showAllHighestSections(Request $request)
    {
        $sections = session()->get('sections', []);
        $sectionMarks = session()->get('sectionMarks', []);
        $headerData = session()->get('headerData', []);
        $class_code = $request->class_code;
        $version_id = $request->version_id;
        $shift_id = $request->shift_id;
        $session_id = $request->session_id;
        $exam_id = $request->exam_id;

        // Define breadcrumbs
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Highest Mark Report', 'url' => route('average.highest.mark.report')],
            ['name' => 'Sections', 'url' => ''], // Current page
        ];

        return view('report.highest_mark.all_sections', compact('sections', 'headerData', 'session_id', 'exam_id', 'sectionMarks', 'breadcrumbs', 'class_code', 'version_id', 'shift_id'));
    }

    public function getAverageHighestMarkReport(Request $request)
    {
        $class_code = $request->class_code ?? null;
        $version_id = $request->version_id ?? null;
        $shift_id = $request->shift_id ?? null;
        $section_id = $request->section_id ?? null;
        $session_id = $request->session_id ?? null;
        $exam_id = $request->exam_id ?? null;

        if (!$section_id) {
            return response()->json(['error' => 'Section ID is required'], 400);
        }

        $students =  Student::join('student_activity as sta', 'sta.student_code', '=', 'students.student_code')
            ->join('sections', 'sections.id', '=', 'sta.section_id')
            ->join('student_subject_wise_mark as sswm', 'sswm.student_code', '=', 'students.student_code')
            ->join('subjects as sub', 'sswm.subject_id', '=', 'sub.id')
            ->join('versions', 'versions.id', '=', 'sta.version_id')  // Join versions table
            ->join('shifts', 'shifts.id', '=', 'sta.shift_id')        // Join shifts table
            ->join('sessions', 'sessions.id', '=', 'sta.session_id')  // Join sessions table
            ->join('exam', 'exam.id', '=', 'sswm.exam_id')
            ->join('classes', 'classes.class_code', '=', 'sta.class_code')
            ->leftJoin('employee_activity as ea', function ($join) {
                $join->on('ea.section_id', '=', 'sta.section_id')
                    ->where('ea.is_class_teacher', '=', 1)
                    ->where('ea.active', '=', 1);
            })
            ->leftJoin('employees as e', 'e.id', '=', 'ea.employee_id')
            ->where('sta.session_id', $session_id)
            ->where('sta.class_code', $class_code);

        if ($section_id) {
            $students = $students->where('sta.section_id', $section_id);
        }
        if ($version_id) {
            $students = $students->where('sta.version_id', $version_id);
        }

        $students = $students->where('sswm.session_id', $session_id);

        $results = $students->where('sswm.class_code', $class_code)
            ->where('sswm.exam_id', $exam_id)
            ->select(
                'sub.subject_name',
                'classes.class_name',
                'sections.section_name',
                'versions.version_name',
                'shifts.shift_name',
                'sessions.session_name',
                'exam.exam_title',
                // DB::raw('MAX(e.employee_name) as class_teacher_name'),
                DB::raw('MAX(sswm.conv_total) as highest_mark')
            )
            ->groupBy(
                'sta.class_code',
                'sta.section_id',
                'sta.version_id',
                'sswm.subject_id',
                'sswm.exam_id',
                'classes.class_name',
                'sub.subject_name',
                'sections.section_name',
                'versions.version_name',
                'shifts.shift_name',
                'sessions.session_name',
                'exam.exam_title',
                // 'e.employee_name'
            )
            ->orderBy('sswm.subject_id')
            ->get();

        session()->put('results', $results);

        $redirectUrl = route('show.average.highetst.mark.report');
        return response()->json(['redirect_url' => $redirectUrl]);
    }

    public function showAverageHighestMarkReportResults(Request $request)
    {
        $results = session()->get('results', []);

        // Define breadcrumbs
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Highest Mark Report', 'url' => route('average.highest.mark.report')],
            ['name' => 'Sections', 'url' =>  route('show_all_sections_page')], // Current page
            ['name' => 'report', 'url' => ''], // Current page
        ];

        return view('report.highest_mark.report', compact('breadcrumbs', 'results'));
    }

    // Student Attendance Report starts
    public function averageStudentAttendancekReport()
    {
        Session::put('activemenu', 'report');
        Session::put('activesubmenu', 'astr');

        $session = Sessions::where('active', 1)->first();

        return view('report.attendance_report.index', compact('session'));
    }
    //     public function StudentAttendancekStatisticsReport()
    //     {
    //         Session::put('activemenu', 'report');
    //         Session::put('activesubmenu', 'astrs');
    //         $todayDate = date('Y-m-d');
    //         $sql = "WITH att AS (
    //     SELECT
    //     CASE
    //         WHEN a.version_id = 1 THEN 'Bangla'
    //         WHEN a.version_id = 2 THEN 'English'
    //         ELSE 'Unknown'
    //     END AS version_name,
    //     a.version_id,
    //     CASE
    //         WHEN a.shift_id = 1 THEN 'Morning'
    //         WHEN a.shift_id = 2 THEN 'Day'
    //         ELSE 'Unknown'
    //     END AS shift_name,
    //     a.shift_id,
    //     a.class_code,
    //     a.section_id,
    //     s.section_name,
    //     CASE
    //         WHEN a.status = 1 THEN 'Present'
    //         WHEN a.status = 2 THEN 'Absent'
    //         WHEN a.status = 3 THEN 'Leave'
    //         WHEN a.status = 4 THEN 'Late'
    //         WHEN a.status = 5 THEN 'Missing'
    //         ELSE 'Unknown'
    //     END AS status
    // 	FROM
    // 	    attendances a
    // 	JOIN
    // 	    sections s ON s.id = a.section_id
    // 	WHERE
    // 	    a.attendance_date = '{$todayDate}'
    // ),
    // Presentdata AS (
    //     SELECT version_name,version_id,shift_name,shift_id,class_code,section_name,section_id, COUNT(*) AS P
    //     FROM att
    //     WHERE status = 'Present'
    //     GROUP BY version_name,version_id,shift_name,shift_id,class_code,section_name,section_id
    // ),
    // Absentdata AS (
    //     SELECT section_id, COUNT(*) AS A
    //     FROM att
    //     WHERE status = 'Absent'
    //     GROUP BY section_id
    // ),
    // Leavedata AS (
    //     SELECT section_id, COUNT(*) AS Le
    //     FROM att
    //     WHERE status = 'Leave'
    //     GROUP BY section_id
    // ),
    // Latedata AS (
    //     SELECT section_id, COUNT(*) AS L
    //     FROM att
    //     WHERE status = 'Late'
    //     GROUP BY section_id
    // ),
    // Missingdata AS (
    //     SELECT section_id, COUNT(*) AS M
    //     FROM att
    //     WHERE status = 'Missing'
    //     GROUP BY section_id
    // )
    // SELECT
    //     version_name,shift_name,class_code,section_name,
    //     P AS Present,
    //     A AS Absent,
    //     Le AS Leaved,
    //     L AS Late,
    //     M AS Missing
    // FROM
    //     Presentdata p
    // LEFT JOIN
    //     Absentdata a ON p.section_id = a.section_id
    // LEFT JOIN
    //     Leavedata l ON p.section_id = l.section_id
    // LEFT JOIN
    //     Latedata t ON p.section_id = t.section_id
    // LEFT JOIN
    //     Missingdata m ON p.section_id = m.section_id
    // order by p.version_id,p.shift_id,p.section_id";
    //         $data = DB::select($sql);
    //         $studentsummary = collect($data)->groupBy(['version_name', 'shift_name', 'class_code']);
    //         return view('report.attendance_report.indexstatic', compact('studentsummary'));
    //     }
    public function StudentAttendancekStatisticsReport(Request $request)
    {
        // dd($request->all());
        Session::put('activemenu', 'report');
        Session::put('activesubmenu', 'atts');
        $todayDate = date('Y-m-d');
        if ($request->from_date) {
            $todayDate = $request->from_date;
        }
        $classes = '';
        $class_for = $request->class_for;
        $version_id = $request->version_id;
        $shift_id = $request->shift_id;
        $version_for = Auth::user()->version_id;
        $shift_for = Auth::user()->shift_id;

        // dd($version_for, $shift_for);
        $class_id = Auth::user()->class_id;

        if ($request->class_for == 1) {
            $classes = '0,1,2,3,4,5';
        } elseif ($request->class_for == 2) {
            $classes = '6,7,8,9,10';
        } elseif ($request->class_for == 3) {
            $classes = '11,12';
        } elseif ($class_id == 1) {
            $classes = '0,1,2,3,4,5';
        } elseif ($class_id == 2) {
            $classes = '6,7,8,9,10';
        } elseif ($class_id == 3) {
            $classes = '11,12';
        } elseif ($class_id == 4) {
            $classes = '0,1,2,3,4,5,6,7,8,9,10';
        }

        $sql = "WITH att AS (

                SELECT

                    CASE

                        WHEN a.version_id = 1 THEN 'Bangla'

                        WHEN a.version_id = 2 THEN 'English'

                        ELSE 'Unknown'

                    END AS version_name,

                    a.version_id,

                    CASE

                        WHEN a.shift_id = 1 THEN 'Morning'

                        WHEN a.shift_id = 2 THEN 'Day'

                        ELSE 'Unknown'

                    END AS shift_name,

                    a.shift_id,

                    a.class_code,

                    a.section_id,

                    s.section_name,

                    CASE

                        WHEN a.status = 1 THEN 'Present'

                        WHEN a.status = 2 THEN 'Absent'

                        WHEN a.status = 3 THEN 'Leave'

                        WHEN a.status = 4 THEN 'Late'

                        WHEN a.status = 5 THEN 'Missing'

                        ELSE 'Unknown'

                    END AS status

                FROM

                    attendances a

                JOIN

                    sections s ON s.id = a.section_id

                WHERE

                    a.attendance_date = '{$todayDate}'
                ";
        if ($request->version_id) {
            $sql .= " AND a.version_id = {$request->version_id}";
        } elseif ($version_for) {
            $sql .= " AND a.version_id = {$version_for}";
        }
        if ($request->shift_id) {
            $sql .= " AND a.shift_id = {$request->shift_id}";
        } elseif ($shift_for) {
            $sql .= " AND a.shift_id = {$shift_for}";
        }
        if ($classes) {
            $sql .= " AND a.class_code in (" . $classes . ")";
        }


        $sql .= "

                ),
                student as (
                    select section_id,count(sa.id) totalstudent from student_activity sa
                    join students s on s.student_code=sa.student_code
                    where  s.active=1 and sa.active=1";

        if ($request->version_id) {
            $sql .= " AND sa.version_id = {$request->version_id}";
        } elseif ($version_for) {
            $sql .= " AND sa.version_id = {$version_for}";
        }
        if ($request->shift_id) {
            $sql .= " AND sa.shift_id = {$request->shift_id}";
        } elseif ($shift_for) {
            $sql .= " AND sa.shift_id = {$shift_for}";
        }
        if ($classes) {
            $sql .= " AND sa.class_code in (" . $classes . ")";
        }
        $sql .= "        group by section_id
                ),

                Presentdata AS (

                SELECT version_name, version_id, shift_name, shift_id, class_code, section_name, section_id, COUNT(*) AS P

                FROM att

                WHERE status = 'Present'

                GROUP BY version_name, version_id, shift_name, shift_id, class_code, section_name, section_id

                ),

                Absentdata AS (

                SELECT section_id, COUNT(*) AS A

                FROM att

                WHERE status = 'Absent'

                GROUP BY section_id

                ),

                Leavedata AS (

                SELECT section_id, COUNT(*) AS Le

                FROM att

                WHERE status = 'Leave'

                GROUP BY section_id

                ),

                Latedata AS (

                SELECT section_id, COUNT(*) AS L

                FROM att

                WHERE status = 'Late'

                GROUP BY section_id

                ),

                Missingdata AS (

                SELECT section_id, COUNT(*) AS M

                FROM att

                WHERE status = 'Missing'

                GROUP BY section_id

                )

                SELECT

                s.version_id,

                CASE

                    WHEN s.version_id = 1 THEN 'Bangla'

                    WHEN s.version_id = 2 THEN 'English'

                    ELSE 'Unknown'

                END AS version_name,

                s.shift_id,

                CASE

                    WHEN s.shift_id = 1 THEN 'Morning'

                    WHEN s.shift_id = 2 THEN 'Day'

                    ELSE 'Unknown'

                END AS shift_name,

                s.class_code,

                s.section_name,

                totalstudent,

                COALESCE(Presentdata.P, 0) AS Present,

                COALESCE(Absentdata.A, 0) AS Absent,

                COALESCE(Leavedata.Le, 0) AS Leaved,

                COALESCE(Latedata.L, 0) AS Late,

                COALESCE(Missingdata.M, 0) AS Missing

                FROM

                sections s

                left join

                student on student.section_id=s.id

                LEFT JOIN

                Presentdata ON s.id = Presentdata.section_id

                LEFT JOIN

                Absentdata ON s.id = Absentdata.section_id

                LEFT JOIN

                Leavedata ON s.id = Leavedata.section_id

                LEFT JOIN

                Latedata ON s.id = Latedata.section_id

                LEFT JOIN

                Missingdata ON s.id = Missingdata.section_id
                where ifnull(totalstudent,0)>0
                ORDER BY
                s.version_id, s.shift_id, s.class_code, s.section_name ";
        // dd($sql);
        $data = DB::select($sql);

        $studentsummary = collect($data)->groupBy(['version_name', 'shift_name', 'class_code']);

        return view('report.attendance_report.indexstatic', compact('studentsummary', 'class_for', 'version_id', 'shift_id', 'todayDate'));
    }

    public function StudentAttendancekStatisticsReport2(Request $request)
    {
        // dd($request->all());
        Session::put('activemenu', 'report');
        Session::put('activesubmenu', 'atts2');
        $todayDate = date('Y-m-d');
        $toDate = date('Y-m-d');
        if ($request->to_date) {
            $toDate = $request->to_date;
        }
        if ($request->from_date) {
            $todayDate = $request->from_date;
        }
        $classes = '';
        $class_for = $request->class_for;
        $class_code = $request->class_id;
        $version_id = $request->version_id;
        $shift_id = $request->shift_id;
        $version_for = Auth::user()->version_id;
        $shift_for = Auth::user()->shift_id;

        // dd($version_for, $shift_for);
        $class_id = Auth::user()->class_id;

        if ($request->class_for == 1) {
            $classes = '0,1,2,3,4,5';
        } elseif ($request->class_for == 2) {
            $classes = '6,7,8,9,10';
        } elseif ($request->class_for == 3) {
            $classes = '11,12';
        } elseif ($class_id == 1) {
            $classes = '0,1,2,3,4,5';
        } elseif ($class_id == 2) {
            $classes = '6,7,8,9,10';
        } elseif ($class_id == 3) {
            $classes = '11,12';
        } elseif ($class_id == 4) {
            $classes = '0,1,2,3,4,5,6,7,8,9,10';
        }

        if ($request->class_id) {
            $classes = $request->class_id;
        } elseif ($request->class_id != null && $request->class_id == 0) {
            // dd($request->class_id);
            $classes = '0';
        }

        $sql = "WITH section_attendance AS (
                    SELECT
                        a.session_id,
                        a.version_id,
                        CASE
                            WHEN a.version_id = 1 THEN 'Bangla'
                            WHEN a.version_id = 2 THEN 'English'
                            ELSE 'Unknown'
                        END AS version_name,

                        a.shift_id,
                        CASE
                            WHEN a.shift_id = 1 THEN 'Morning'
                            WHEN a.shift_id = 2 THEN 'Day'
                            ELSE 'Unknown'
                        END AS shift_name,

                        a.class_code,
                        a.section_id,
                        s.section_name,

                        COUNT(DISTINCT a.attendance_date) AS working_days,
                        SUM(a.status IN (1, 4)) AS present_count,
                        SUM(a.status IN (2, 5)) AS absent_count,
                        COUNT(*) AS total_count
                    FROM attendances a
                    JOIN sections s ON s.id = a.section_id
                    WHERE
                        a.attendance_date BETWEEN '{$todayDate}' AND '{$toDate}'
                        AND a.active = 1";
        if ($request->version_id) {
            $sql .= " AND a.version_id = {$request->version_id}";
        } elseif ($version_for) {
            $sql .= " AND a.version_id = {$version_for}";
        }
        if ($request->shift_id) {
            $sql .= " AND a.shift_id = {$request->shift_id}";
        } elseif ($shift_for) {
            $sql .= " AND a.shift_id = {$shift_for}";
        }
        if ($classes) {
            $sql .= " AND a.class_code in (" . $classes . ")";
        } elseif ($classes == 0) {
            $sql .= " AND a.class_code = (" . $classes . ")";
        }


        $sql .= "
                GROUP BY a.session_id, a.version_id, a.shift_id, a.class_code, a.section_id, s.section_name
                ),
                max_days AS (
                SELECT
                    class_code,
                    MAX(working_days) AS max_working_days
                FROM section_attendance
                GROUP BY class_code
            )

            SELECT
                sa.session_id,
                sa.version_id,
                sa.version_name,
                sa.shift_id,
                sa.shift_name,
                sa.class_code,
                sa.section_id,
                sa.section_name,
                md.max_working_days AS working_days,
                sa.present_count,
                sa.absent_count,
                sa.total_count,
                ROUND(sa.present_count * 100.0 / sa.total_count, 2) AS present_percentage,
                ROUND(sa.absent_count * 100.0 / sa.total_count, 2) AS absent_percentage
            FROM section_attendance sa
            JOIN max_days md ON sa.class_code = md.class_code
            ORDER BY sa.version_id, sa.shift_id, sa.class_code, sa.section_name";
        // dd($sql);
        $data = DB::select($sql);

        // dd($data);

        $studentsummary = collect($data)->groupBy(['version_name', 'shift_name', 'class_code']);

        // dd($studentsummary);

        return view('report.attendance_report.indexstatic2', compact('studentsummary', 'class_for', 'version_id', 'shift_id', 'todayDate', 'toDate', 'class_code'));
    }
    public function getShiftsForAttendance(Request $request)
    {


        $class_code = $request->class_code ?? null;
        $version_id = $request->version_id ?? null;
        $session_id = $request->session_id ?? null;
        $from_date = $request->from_date ?? date('Y-m-d');
        $to_date = $request->to_date ?? date('Y-m-d');

        // Fetch shifts grouped by version and class
        $shifts = Classes::where('version_id', $version_id)
            ->where('class_code', $class_code)
            ->distinct('shift_id')
            ->select('shift_id')
            ->get();

        // Calculate shift-wise attendance
        $attendanceData = Sections::join('shifts', 'shifts.id', '=', 'sections.shift_id')
            ->join('classes', 'classes.class_code', '=', 'sections.class_code')
            ->join('versions', 'versions.id', '=', 'sections.version_id')
            ->leftJoin('student_activity as sta', 'sta.section_id', '=', 'sections.id')
            ->leftJoin('attendances as at', function ($join) use ($from_date, $to_date) {
                $join->on('at.section_id', '=', 'sections.id')
                    ->whereBetween('at.attendance_date', [$from_date, $to_date]);
            })
            ->where('sections.class_code', $class_code)
            ->where('sections.version_id', $version_id)
            ->where(
                'sta.session_id',
                $session_id
            )
            ->select(
                'sections.shift_id',
                'shifts.shift_name',
                DB::raw('COUNT(at.id) as total_attendance'),
                DB::raw('SUM(CASE WHEN at.status = 1 THEN 1 ELSE 0 END) as present_attendance'),
                DB::raw('ROUND(SUM(CASE WHEN at.status = 1 THEN 1 ELSE 0 END) / COUNT(at.id) * 100, 2) as attendance_percentage')
            )
            ->groupBy('sections.shift_id', 'shifts.shift_name')
            ->get();

        $shiftAttendanceData = [];
        $attendanceByShift = $attendanceData->keyBy('shift_id');
        // Prepare shiftAttendanceData with default '0' values for all shifts
        $shiftAttendanceData = [];
        foreach ($shifts as $shift) {
            $shiftAttendanceData[$shift->shift_id] = $attendanceByShift->has($shift->shift_id)
                ? $attendanceByShift[$shift->shift_id]->attendance_percentage
                : '0';
        }
        session()->put('shiftAttendanceData', $shiftAttendanceData);
        $html = view('report.attendance_report.ajaxshift', compact('shifts', 'shiftAttendanceData'))->render();
        return response()->json(['html' => $html]);
    }
    public function getStudentAttendanceSection(Request $request)
    {
        $session_id = $request->session_id ?? 2024;
        $class_code = $request->class_code ?? null;
        $version_id = $request->version_id ?? null;
        $shift_id = $request->shift_id ?? null;

        $from_date = $request->from_date ?? date('Y-m-d');
        $to_date = $request->to_date ?? date('Y-m-d');

        $sections = Sections::join('classes', 'classes.class_code', '=', 'sections.class_code')
            ->join('versions', 'versions.id', '=', 'sections.version_id')
            ->join('shifts', 'shifts.id', '=', 'sections.shift_id')
            ->join('sessions', 'sessions.id', '=', DB::raw($session_id)) // Join session
            ->where('sections.class_code', $class_code)
            ->where('sections.version_id', $version_id)
            ->where('sections.shift_id', $shift_id)
            ->select(
                'sections.id',
                'sections.section_name',
                'classes.class_name',
                'versions.version_name',
                'shifts.shift_name',
                'sessions.session_name' // Fetch session name
            )
            ->distinct()
            ->get();

        if ($sections->isEmpty()) {
            return redirect()->back()->with('error', 'No sections found for the selected criteria.');
        }

        $sectionAttendance = [];

        foreach ($sections as $section) {
            $section_id = $section->id;
            $attendanceData = Student::join('student_activity as sta', 'sta.student_code', '=', 'students.student_code')
                ->join('attendances as at', 'at.section_id', '=', 'sta.section_id')
                ->where('sta.session_id', $session_id)
                ->where('sta.class_code', $class_code)
                ->where('sta.section_id', $section_id)
                ->whereBetween('at.attendance_date', [$from_date, $to_date])
                ->when($version_id, function ($query) use ($version_id) {
                    $query->where('sta.version_id', $version_id)
                        ->where('at.version_id', $version_id);
                })
                ->when($shift_id, function ($query) use ($shift_id) {
                    $query->where('at.shift_id', $shift_id);
                })
                ->select(
                    DB::raw('COUNT(*) as total_attendance'),
                    DB::raw('SUM(CASE WHEN at.status IS NOT NULL and at.status = 1 THEN 1 ELSE 0 END) as present_attendance')
                )
                ->first();

            // Calculate percentage
            $totalAttendance = $attendanceData->total_attendance ?? 0;
            $presentAttendance = $attendanceData->present_attendance ?? 0;

            $attendancePercentage = $totalAttendance > 0
                ? round(($presentAttendance / $totalAttendance) * 100, 2)
                : 0;

            $sectionAttendance[$section_id] = $attendancePercentage;

            $headerData = [
                'class_name' => $section->class_name,
                'version_name' => $section->version_name,
                'shift_name' => $section->shift_name,
                'session_name' => $section->session_name,
                'from_date' => $from_date,
                'to_date' => $to_date,
            ];
        }

        session()->put('sectionAttendance', $sectionAttendance);
        session()->put('sections', $sections);
        session()->put('headerData', $headerData);
        $redirectUrl = route('show_all_student_attendance_section_page', [
            'class_code' => $class_code,
            'version_id' => $version_id,
            'shift_id' => $shift_id,
            'session_id' => $session_id,
        ]);

        return response()->json(['redirect_url' => $redirectUrl]);
    }


    public function showAllStudentAttendanceSections(Request $request)
    {
        $sections = session()->get('sections', []);
        $sectionAttendance = session()->get('sectionAttendance', []);
        $headerData = session()->get('headerData', []);
        $class_code = $request->class_code;
        $version_id = $request->version_id;
        $shift_id = $request->shift_id;

        // Define breadcrumbs
        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Students Attendance Report', 'url' => route('average.student.attendance.report')],
            ['name' => 'Sections', 'url' => ''], // Current page
        ];

        return view('report.attendance_report.all_sections', compact('sections', 'headerData', 'sectionAttendance', 'breadcrumbs', 'class_code', 'version_id', 'shift_id'));
    }



    // Attendance Report of a student

    public function getStudentsAttendanceReport(Request $request)
    {
        Session::put('activemenu', 'attendance');
        Session::put(
            'activesubmenu',
            'atreport'
        );

        $activity = null;
        $sessions = null;
        $versions = Versions::where('active', 1)->get();
        $sessions = Sessions::all();
        $shifts = Shifts::where('active', 1)->get();
        $sections = Sections::where('active', 1)->get();
        $classes = Classes::orderByRaw("CAST(class_code AS UNSIGNED)")->pluck('class_name', 'class_code');

        // Calculate allowed date range dynamically for the current month
        $currentDate = Carbon::now();
        $allowedStartDate = Carbon::create($currentDate->year, $currentDate->month, 25); // 25th of the month
        $allowedEndDate = $allowedStartDate->copy()->endOfMonth(); // Last day of the month
        $allowedStartDate = $allowedStartDate->format('Y-m-d');
        $allowedEndDate = $allowedEndDate->format('Y-m-d');


        if (Auth::user()->group_id == 3) {
            $employee = Employee::where('id', Auth::user()->ref_id)->first();
            $activity = EmployeeActivity::where('employee_id', $employee->id)
                ->where('is_class_teacher', 1)
                ->where('active', 1)
                ->orderBy('id', 'desc')
                ->first();
            $sessions = Sessions::where('id', $activity->session_id)->orderBy('id', 'desc')->get();
        }

        return view('report.attendance.index', compact(
            'versions',
            'sessions',
            'shifts',
            'classes',
            'sections',
            'allowedStartDate',
            'allowedEndDate',
            'activity',

        ));
    }

    public function attendanceReport(Request $request)
    {

        // dd($request->all());


        $session_id = $request->session_id;
        $version_id = $request->version_id;
        $shift_id = $request->shift_id;
        $class_code = $request->class_code;
        $section_id = $request->section_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $student_code = $request->student_code;

        $conditions = " 1=1";
        $condition = " 1=1";

        if ($session_id) {
            $conditions .= ' and student_activity.session_id=' . $session_id;
            $condition .= ' and attendances.session_id=' . $session_id;
        }
        if ($version_id) {
            $conditions .= ' and student_activity.version_id=' . $version_id;
            $condition .= ' and attendances.version_id=' . $version_id;
        }
        if ($shift_id) {
            $conditions .= ' and student_activity.shift_id=' . $shift_id;
            $condition .= ' and attendances.shift_id=' . $shift_id;
        }
        if ($class_code) {
            $conditions .= ' and student_activity.class_code=' . $class_code;
            $condition .= ' and attendances.class_code=' . $class_code;
        }
        if ($section_id) {
            $conditions .= ' and student_activity.section_id=' . $section_id;
            $condition .= ' and attendances.section_id=' . $section_id;
        }
        if ($student_code) {
            $conditions .= ' and student_activity.student_code=' . $student_code;
            $condition .= ' and attendances.student_code=' . $student_code;
        }

        if ($start_date && $end_date) {
            $condition .= " and attendances.attendance_date BETWEEN '$start_date' AND '$end_date'";
        }

        $query = Student::where('students.active', 1)
            ->join('student_activity', 'student_activity.student_code', '=', 'students.student_code')
            ->join('versions', 'versions.id', '=', 'student_activity.version_id')
            ->join('shifts', 'shifts.id', '=', 'student_activity.shift_id')
            ->join('classes', 'classes.class_code', '=', 'student_activity.class_code')
            ->join('sections', 'sections.id', '=', 'student_activity.section_id')
            ->join('sessions', 'sessions.id', '=', 'student_activity.session_id')
            ->whereRaw($conditions)
            ->with(["studentAttendance" => function ($query) use ($condition) {
                return $query->whereRaw($condition);
            }])
            ->selectRaw('students.*,version_name,shift_name,class_name,section_name,roll,session_name,start_time')
            ->orderBy('student_activity.roll', 'asc');
        $student = $query->first();

        // Generate all dates excluding Fridays and Saturdays
        $startDate = Carbon::parse($start_date);
        $endDate = Carbon::parse($end_date);
        $filteredDateRange = collect();
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            if (!in_array($date->dayOfWeek, [Carbon::FRIDAY, Carbon::SATURDAY])) {
                $filteredDateRange->push($date->toDateString());
            }
        }

        $counts = [
            'present' => 0,
            'absent' => 0,
            'late' => 0,
            'leave' => 0,
            'missing' => 0,
        ];

        $attendance = [];

        if ($student) {

            if (isset($student->studentAttendance)) {

                foreach ($filteredDateRange as $date) {

                    $attendanceRecord = $student->studentAttendance
                        ->where('student_code', $student_code)
                        ->where('attendance_date', $date)
                        ->first();


                    if ($attendanceRecord) {
                        $attendance[$date] = $attendanceRecord;
                        switch ($attendanceRecord->status) {
                            case 1: // Present
                                $counts['present']++;
                                break;
                            case 2: // Absent
                                $counts['absent']++;
                                break;
                            case 3: // Leave
                                $counts['leave']++;
                                break;
                            case 4: // Late
                                $counts['late']++;
                                break;
                                break;
                            case 5: // Late
                                $counts['missing']++;
                                break;
                            default:
                                break;
                        }
                    }
                }
            }

            return view('report.attendance.search', compact('student', 'filteredDateRange', 'attendance', 'counts'));
        } else {
            return response()->json(['message' => 'Student not found.'], 400);
        }
    }
    public function generatePDF(Request $request)
    {

        $filteredDateRange = $request->session()->get('filteredDateRange', []);
        $counts = $request->session()->get('counts', []);
        $attendance = $request->session()->get('attendance', []);
        $student = $request->session()->get('student', []);
        // Prepare the HTML for the PDF
        $html = view('report.attendance.report', compact('filteredDateRange', 'counts', 'attendance', 'student'))->render();
        // Initialize mPDF
        $mpdf = new Mpdf();
        // Write the HTML to the PDF
        $mpdf->WriteHTML($html);
        // Output the PDF for download
        return response()->streamDownload(
            fn() => $mpdf->Output(),
            'attendance_report.pdf'
        );
    }

    public function getAttendanceStudent(Request $request)
    {
        Session::put('activemenu', 'report');
        Session::put(
            'activesubmenu',
            'atsreport'
        );

        $activity = null;
        $sessions = null;
        $versions = Versions::where('active', 1)->get();
        $sessions = Sessions::all();
        $shifts = Shifts::where('active', 1)->get();
        $sections = Sections::where('active', 1)->get();
        $classes = Classes::orderByRaw("CAST(class_code AS UNSIGNED)")->pluck('class_name', 'class_code');

        if (
            Auth::user()->group_id == 3
        ) {
            $employee = Employee::where('id', Auth::user()->ref_id)->first();
            $activity = EmployeeActivity::where('employee_id', $employee->id)
                ->where('is_class_teacher', 1)
                ->where('active', 1)
                ->orderBy('id', 'desc')
                ->first();
            $sessions = Sessions::where('id', $activity->session_id)->get();
        }

        return view('report.attendance_report.attendance', compact(
            'versions',
            'sessions',
            'shifts',
            'classes',
            'sections',
            'activity',
        ));
    }

    public function getAttendanceStudentPercentage(Request $request)
    {
        Session::put('activemenu', 'attendance');
        Session::put(
            'activesubmenu',
            'atspreport'
        );

        $activity = null;
        $sessions = null;
        $versions = Versions::where('active', 1)->get();
        $sessions = Sessions::all();
        $shifts = Shifts::where('active', 1)->get();
        $sections = Sections::where('active', 1)->get();
        $classes = Classes::orderByRaw("CAST(class_code AS UNSIGNED)")->pluck('class_name', 'class_code');

        if (
            Auth::user()->group_id == 3
        ) {
            $employee = Employee::where('id', Auth::user()->ref_id)->first();
            $activity = EmployeeActivity::where('employee_id', $employee->id)
                ->where('is_class_teacher', 1)
                ->where('active', 1)
                ->orderBy('id', 'desc')
                ->first();
            $sessions = Sessions::where('id', $activity->session_id)->get();
        }

        return view('report.attendance_report.attendance_percentage', compact(
            'versions',
            'sessions',
            'shifts',
            'classes',
            'sections',
            'activity',
        ));
    }

    public function getSectionWiseReport(Request $request)
    {
        // dd($request->all());
        $session_id = $request->session_id;
        $version_id = $request->version_id;
        $shift_id = $request->shift_id;
        $class_code = $request->class_code;
        $section_id = $request->section_id;
        $attendance_date = $request->start_date;
        $conditions = " 1=1";
        $condition = " 1=1";
        if ($session_id) {
            $conditions .= ' and student_activity.session_id=' . $session_id;
            $condition .= ' and attendances.session_id=' . $session_id;
        }
        if ($version_id) {
            $conditions .= ' and student_activity.version_id=' . $version_id;
            $condition .= ' and attendances.version_id=' . $version_id;
        }
        if ($shift_id) {
            $conditions .= ' and student_activity.shift_id=' . $shift_id;
            $condition .= ' and attendances.shift_id=' . $shift_id;
        }
        if ($class_code) {
            $conditions .= ' and student_activity.class_code=' . $class_code;
            $condition .= ' and attendances.class_code=' . $class_code;
        }
        if ($section_id) {
            $conditions .= ' and student_activity.section_id=' . $section_id;
            $condition .= ' and attendances.section_id=' . $section_id;
        }
        if ($attendance_date) {
            $condition .= ' and attendance_date="' . $attendance_date . '"';
        }
        // Fetch students with attendance data
        $students = Student::where('students.active', 1)
            ->join('student_activity', 'student_activity.student_code', '=', 'students.student_code')
            ->join('versions', 'versions.id', '=', 'student_activity.version_id')
            ->join('shifts', 'shifts.id', '=', 'student_activity.shift_id')
            ->join('classes', 'classes.class_code', '=', 'student_activity.class_code')
            ->join('sections', 'sections.id', '=', 'student_activity.section_id')
            ->join('sessions', 'sessions.id', '=', 'student_activity.session_id')
            ->whereRaw($conditions)
            ->with(["studentAttendance" => function ($query) use ($condition) {
                return $query->whereRaw($condition);
            }])
            ->selectRaw('students.*,version_name,shift_name,class_name,section_name,roll,session_name,start_time')
            ->orderBy('student_activity.roll', 'asc')
            ->get();
        $students = collect($students)->unique('student_code');
        // Initialize attendance counts
        $counts = [
            'present' => 0,
            'absent' => 0,
            'late' => 0,
            'leave' => 0,
            'missing' => 0,
        ];
        $studentsNew = [];
        // Process attendance
        foreach ($students as $student) {

            $attendanceRecord = $student->studentAttendance ?? null;
            $daily_status = null;
            if ($attendanceRecord && $attendanceRecord != null) {
                switch ($attendanceRecord->status) {
                    case 1:
                        $daily_status = 'present';
                        $counts['present']++;
                        break;
                    case 2:
                        $daily_status = 'absent';
                        $counts['absent']++;
                        break;
                    case 3:
                        $daily_status = 'leave';
                        $counts['leave']++;
                        break;
                    case 4:
                        $daily_status = 'late';
                        $counts['late']++;
                        break;
                    default:
                        $daily_status = 'missing';
                        $counts['missing']++;
                }
                $student->attendance_status = $daily_status ?? null;
                $student->time = $attendanceRecord->time ?? null;
                $student->attendance_date = $attendanceRecord->attendance_date ?? null;
            } else {
                return response()->json(['message' => 'Attendance Not Available'], 400);
            }

            // Append data to the student object

        }

        session()->put('counts', $counts);
        session()->put('students', $students);

        return view('report.attendance_report.section_wise_attendance', compact('students', 'counts'));
    }
    public function sectionWiseAttendancePercentageReport(Request $request)
    {
        // Retrieve all the inputs from the request
        $session_id = $request->session_id;
        $version_id = $request->version_id;
        $shift_id = $request->shift_id;
        $class_code = $request->class_code;
        $section_id = $request->section_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $section_name = Sections::where('id', $section_id)->pluck('section_name')->first();

        // Query to get the total number of attendance days
        $total_days = DB::table('attendances')
            ->select(DB::raw('COUNT(DISTINCT attendance_date) AS total_days'))
            ->whereBetween('attendance_date', [$start_date, $end_date])
            ->where('session_id', $session_id)
            ->where('class_code', $class_code) // You can adjust this range based on your requirements
            ->groupBy(DB::raw('attendance_date'))
            ->get()
            ->sum('total_days');

        $total_days_section = DB::table('attendances')
            ->select(DB::raw('COUNT(DISTINCT attendance_date) AS total_days'))
            ->whereBetween('attendance_date', [$start_date, $end_date])
            ->where('session_id', $session_id)
            ->where('class_code', $class_code)
            ->where('section_id', $section_id) // Ensure to filter by section
            ->groupBy(DB::raw('attendance_date'))
            ->get()
            ->sum('total_days');

        $subQuery = DB::table('reconcilation_attendance')
            ->select(
                'student_code',
                DB::raw('SUM(current_absent) as current_absent'),
                DB::raw('SUM(final_absent) as final_absent')
            )
            ->whereBetween('submit_date', [$start_date, $end_date])
            ->groupBy('student_code');

        // $attendance_details = DB::table('attendances as a')
        //     ->leftJoin('students as s', 's.student_code', '=', 'a.student_code')
        //     ->join('student_activity as sa', 'sa.student_code', '=', 's.student_code')
        //     ->leftJoinSub($subQuery, 'r', function ($join) {
        //         $join->on('r.student_code', '=', 's.student_code');
        //     })
        //     ->select(
        //         'sa.roll',
        //         's.first_name',
        //         'a.student_code',
        //         DB::raw('SUM(CASE WHEN a.status IN (1, 4) THEN 1 ELSE 0 END) as total_present'),
        //         DB::raw('SUM(CASE WHEN a.status IN (2,5) THEN 1 ELSE 0 END) as total_absent'),
        //         DB::raw('SUM(CASE WHEN a.status IN (3) THEN 1 ELSE 0 END) as total_leave'),
        //         DB::raw('COALESCE(r.current_absent, 0) as re_absent'),
        //         DB::raw('COALESCE(r.final_absent, 0) as re_final_absent')
        //     )
        //     ->whereBetween('a.attendance_date', [$start_date, $end_date])
        //     ->where('a.session_id', $session_id)
        //     ->where('a.class_code', $class_code)
        //     ->where('a.section_id', $section_id)
        //     ->where('sa.active', 1)
        //     ->where('s.active', 1)
        //     ->groupBy('a.student_code', 's.first_name', 'sa.roll', 'r.current_absent', 'r.final_absent')
        //     ->orderBy('sa.roll')
        //     ->get();

        $attendance_details = DB::table('attendances as a')
            ->leftJoin('students as s', 's.student_code', '=', 'a.student_code')
            ->join('student_activity as sa', 'sa.student_code', '=', 's.student_code')
            ->leftJoinSub($subQuery, 'r', function ($join) {
                $join->on('r.student_code', '=', 's.student_code');
            })
            ->select(
                'sa.roll',
                's.first_name',
                'a.student_code',
                DB::raw('COUNT(a.id) as total_records'), // 👈 Total attendance entries
                DB::raw('SUM(CASE WHEN a.status IN (1, 4) THEN 1 ELSE 0 END) as total_present'),
                DB::raw('SUM(CASE WHEN a.status IN (2,5) THEN 1 ELSE 0 END) as total_absent'),
                DB::raw('SUM(CASE WHEN a.status = 3 THEN 1 ELSE 0 END) as total_leave'),
                DB::raw('COALESCE(r.current_absent, 0) as re_absent'),
                DB::raw('COALESCE(r.final_absent, 0) as re_final_absent')
            )
            ->whereBetween('a.attendance_date', [$start_date, $end_date])
            ->where('a.session_id', $session_id)
            ->where('a.class_code', $class_code)
            ->where('a.section_id', $section_id)
            ->where('sa.active', 1)
            ->where('s.active', 1)
            ->groupBy(
                'a.student_code',
                's.first_name',
                'sa.roll',
                'r.current_absent',
                'r.final_absent'
            )
            ->orderBy('sa.roll')
            ->get();
        // dd($attendance_details);


        session()->put('total_days', $total_days);
        session()->put('total_days_section', $total_days_section);
        session()->put('attendance_details', $attendance_details);
        session()->put('class_code', $class_code);
        session()->put('section_name', $section_name);
        session()->put('start_date', $start_date);
        session()->put('end_date', $end_date);
        session()->put('session_id', $session_id);
        session()->put('version_id', $version_id);
        session()->put('shift_id', $shift_id);
        session()->put('section_id', $section_id);

        // dd($total_days, $attendance_details);

        // Pass the results to the view
        return view('report.attendance_report.section_wise_attendance_percentage', compact('attendance_details', 'total_days', 'total_days_section'));
    }


    public function generateSectionWisePDF(Request $request)
    {

        $counts = $request->session()->get('counts', []);
        $students = $request->session()->get('students', []);
        // Prepare the HTML for the PDF
        $html = view('report.attendance.section_wise_attendance_report', compact('counts', 'students'))->render();
        // Initialize mPDF
        $mpdf = new Mpdf();
        $footerContent = '
    <div style="font-size: 10px; width: 100%; display: flex; justify-content: space-between;">
        <p style="text-align: left; color: red;">Generated by: ' . Auth()->user()->name . '</p>
        <p style="text-align: right; color: green;">Print Date: ' . now()->format('d-m-Y') . '</p>
    </div>';

        // Set the footer
        $mpdf->SetHTMLFooter($footerContent);
        // Write the HTML to the PDF
        $mpdf->WriteHTML($html);
        // Output the PDF for download
        return response()->streamDownload(
            fn() => $mpdf->Output(),
            'section_wise_attendance_report.pdf'
        );
    }

    public function generateSectionWisePercentPDF(Request $request)
    {

        $total_days = $request->session()->get('total_days', 0);
        $total_days_section = $request->session()->get('total_days_section', 0);
        $attendance_details = $request->session()->get('attendance_details', []);
        $class_code = $request->session()->get('class_code', 0);
        $section_name = $request->session()->get('section_name', 0);
        $start_date = $request->session()->get('start_date', 0);
        $end_date = $request->session()->get('end_date', 0);
        $session_id = $request->session()->get('session_id', 0);
        $version_id = $request->session()->get('version_id', 0);
        $shift_id = $request->session()->get('shift_id', 0);
        $section_id = $request->session()->get('section_id', 0);
        $teacher_name = Employee::where('employees.active', 1)
            ->join('employee_activity', 'employee_activity.employee_id', '=', 'employees.id')
            ->where('employee_activity.section_id', $section_id)
            ->where('employee_activity.is_class_teacher', 1)
            ->where('employee_activity.is_main_teacher', 1)
            ->orderBy('employee_activity.id', 'desc')
            ->pluck('employee_name')
            ->first();
        // dd($teacher_name);

        // Prepare the HTML for the PDF
        $html = view('report.attendance.section_wise_attendance_percentage_report', compact('total_days', 'total_days_section', 'attendance_details', 'class_code', 'section_name', 'start_date', 'end_date', 'session_id', 'version_id', 'shift_id', 'teacher_name'))->render();
        // Initialize mPDF
        $mpdf = new Mpdf();
        $footerContent = '
    <div style="font-size: 10px; width: 100%; display: flex; justify-content: space-between;">
        <p style="text-align: left; color: red;">Generated by: ' . Auth()->user()->name . '</p>
        <p style="text-align: right; color: green;">Print Date: ' . now()->format('d-m-Y') . '</p>
    </div>';

        // Set the footer
        // Write the HTML to the PDF
        $mpdf->WriteHTML($html);
        $mpdf->SetHTMLFooter($footerContent);
        // Output the PDF for download
        return response()->streamDownload(
            fn() => $mpdf->Output(),
            'section_wise_attendance_percentage_report.pdf'
        );
    }
}
