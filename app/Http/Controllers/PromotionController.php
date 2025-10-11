<?php

namespace App\Http\Controllers;

use App\Exports\StudentsExport;
use App\Http\Controllers\NoticeController;
use App\Http\Requests\Student\StudentStoreRequest;
use App\Models\Attendance\Attendance;
use App\Models\sttings\Sessions;
use App\Models\sttings\Shifts;
use App\Models\Website\Notice;
use App\Models\sttings\Classes;
use App\Models\sttings\Sections;
use App\Models\Employee\EmployeeActivity;
use App\Models\sttings\Versions;
use App\Models\Finance\StudentFeeTansaction;
use App\Models\Finance\StudentHeadWiseFee;
use App\Models\Fee;
use App\Models\Syllabus;
use App\Models\Student\Student;
use App\Models\sttings\ClassWiseSubject;
use App\Models\Student\StudentActivity;
use App\Models\sttings\Category;
use App\Models\User;
use Illuminate\Http\Request;
use App\Imports\StudentPromotion;
use App\Models\Employee\Employee;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Student\StudentSubjects;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

ini_set('max_execution_time', 36000); // 3600 seconds = 60 minutes
set_time_limit(36000);
class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */



    public function index(Request $request)
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'sp');

        $sessions = Sessions::get();
        $versions = Versions::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();


        return view('student.promotion', compact('sessions', 'versions', 'shifts'));
    }
    // public function studentPromotionxl(Request $request)
    // {
    //     if(Auth::user()->group_id!=2){
    //         return 1;
    //     }
    //     try {

    //         if ($request->hasFile('studentXl')) {
    //             $destinationPath = 'studentfile';
    //             $fileName = 'promosion'.$request->class_id .$request->section_id . '_' . $request->studentXl->getClientOriginalName();
    //             $filePath = public_path($destinationPath);

    //             $request->studentXl->move($filePath, $fileName);

    //             // Call saveXLList to process the file
    //             $this->saveXLList($filePath . '/' . $fileName, $request->all());

    //             return redirect()->route('studentPromotion.index')->with('success', 'XL Import Success');
    //         } else {
    //             return redirect()->route('studentPromotion.index')->with('error', 'No file uploaded.');
    //         }
    //     } catch (\Exception $e) {

    //         return redirect()->route('studentPromotion.index')->with('error', 'Error uploading file: ' . $e->getMessage());
    //     }
    // }

    public function saveXLList($file, $input)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        Excel::import(new StudentPromotion, $file);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create() {}
    public function getPromostionStudent(Request $request)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        $session_id = $request->session_id;
        $class_code = $request->class_code;
        $section_id = $request->section_id;

        $version_id = $request->version_id;
        $shift_id = $request->shift_id;


        // Retrieve exam details


        // dd($grades);
        $sectiondata = array();
        $versiondata = array();
        $shiftdata = array();
        if ($section_id) {
            $sectiondata = Sections::find($section_id);
        }
        if ($version_id) {
            $versiondata = Versions::find($version_id);
        }
        if ($shift_id) {
            $shiftdata = Shifts::find($shift_id);
        }
        // Build the student query with necessary joins
        $students = Student::join('student_activity', 'student_activity.student_code', '=', 'students.student_code')
            ->join('sections', 'sections.id', '=', 'student_activity.section_id')
            ->leftJoin('student_attendance', 'student_attendance.student_code', '=', 'student_activity.student_code')
            ->leftJoin('Category', 'Category.id', '=', 'student_activity.category_id')
            ->join('student_total_mark', 'student_total_mark.student_code', '=', 'students.student_code') // Join for student_total_mark
            ->join('sections as nsections', 'nsections.id', '=', 'student_total_mark.next_section');

        $class_name = '';
        $shift_name = '';
        $version_name = '';
        $session_name = '';
        $exam_name = '';
        // Filter based on section, version, and group
        if ($section_id) {
            $students = $students->where('student_total_mark.next_section', $section_id);
        }

        if ($version_id) {
            $students = $students->where('student_total_mark.version_id', $version_id);
            $version_name = Versions::where('id', $version_id)->first()->version_name;
        }




        if ($class_code) {
            $students = $students->where('student_total_mark.next_class', $class_code);
            $class_name = Classes::where('class_code', $class_code)->first()->class_name;
        }

        if ($session_id) {
            $students = $students->where('student_total_mark.session_id', $session_id);
            $students = $students->where('student_activity.session_id', $session_id);
            $session_name = Sessions::where('id', $session_id)->first()->session_name;
        }

        // Apply additional filters and sorting
        $students = $students->whereNotNull('student_total_mark.next_class')
            ->whereNotNull('student_total_mark.next_section') // Ensure student has a class position

            ->select(
                'students.student_code',
                'students.first_name',
                'students.gender',
                'students.religion',
                'students.mobile',
                'category_name',
                'students.sms_notification',
                'student_activity.roll',
                'student_activity.category_id',
                'student_total_mark.position_in_section',
                'student_total_mark.position_in_class',
                'student_total_mark.next_roll',
                'sections.section_name',
                'nsections.section_name as next_section'
            );

        $students = $students->orderBy('student_total_mark.next_roll', 'asc'); // Sort by class position for merit


        $students = $students->get();
        $students = collect($students)->unique('student_code');
        $createdBy = Auth::user()->name;
        // dd($students);
        return view('student.ajaxpromotion', compact('students', 'sectiondata', 'versiondata', 'class_code', 'shiftdata', 'class_name', 'shift_name', 'version_name', 'session_name', 'exam_name', 'createdBy', 'version_id', 'session_id', 'shift_id', 'class_code', 'section_id'));
    }


    public function store(Request $request)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        $session_id = $request->session_id;
        $class_code = $request->class_code;
        $section_id = $request->section_id;

        $version_id = $request->version_id;
        $shift_id = $request->shift_id;


        // Retrieve exam details


        // dd($grades);
        $sectiondata = array();
        $versiondata = array();
        $shiftdata = array();
        if ($section_id) {
            $sectiondata = Sections::find($section_id);
        }
        if ($version_id) {
            $versiondata = Versions::find($version_id);
        }
        if ($shift_id) {
            $shiftdata = Shifts::find($shift_id);
        }
        // Build the student query with necessary joins
        $students = Student::join('student_activity', 'student_activity.student_code', '=', 'students.student_code')
            ->join('sections', 'sections.id', '=', 'student_activity.section_id')
            ->leftJoin('student_attendance', 'student_attendance.student_code', '=', 'student_activity.student_code')
            ->join('student_total_mark', 'student_total_mark.student_code', '=', 'students.student_code') // Join for student_total_mark
            ->join('sections as nsections', 'nsections.id', '=', 'student_total_mark.next_section');

        $class_name = '';
        $shift_name = '';
        $version_name = '';
        $session_name = '';
        $exam_name = '';
        // Filter based on section, version, and group
        if ($section_id) {
            $students = $students->where('student_total_mark.next_section', $section_id);
        }

        if ($version_id) {
            $students = $students->where('student_total_mark.version_id', $version_id);
            $version_name = Versions::where('id', $version_id)->first()->version_name;
        }




        if ($class_code) {
            $students = $students->where('student_total_mark.next_class', $class_code);
            $class_name = Classes::where('class_code', $class_code)->first()->class_name;
        }

        if ($session_id) {
            $students = $students->where('student_total_mark.session_id', $session_id);
            $session_name = Sessions::where('id', $session_id)->first()->session_name;
        }

        // Apply additional filters and sorting
        $students = $students->whereNotNull('student_total_mark.next_class')
            ->whereNotNull('student_total_mark.next_section')  // Ensure student has a class position

            ->select(
                'students.student_code',
                'students.first_name',
                'student_activity.roll',
                'student_total_mark.position_in_section',
                'student_total_mark.position_in_class',
                'student_total_mark.next_roll',
                'sections.section_name',
                'nsections.section_name as next_section',
                'next_class',
                'next_section as section_id',
                'student_activity.version_id',
                'student_activity.shift_id'
            );

        $students = $students->orderBy('student_total_mark.next_roll', 'asc'); // Sort by class position for merit


        $students = $students->get();
        $students = collect($students)->unique('student_code');

        foreach ($students as $student) {
            $studentactivity = array('active' => 0);
            DB::table('student_activity')->where('student_code', $student->student_code)->update($studentactivity);

            $studentactivityupdate = array(
                'student_code' => $student->student_code,
                'session_id' => $session_id + 1,
                'section_id' => $student->section_id,
                'version_id' => $student->version_id,
                'shift_id' => $student->shift_id,
                'roll' => $student->next_roll,
                'active' => 1,
                'class_code' => $student->next_class,
                'class_id' => $student->next_class,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => Auth::user()->id,
            );

            $attributes = array(
                'student_code' => $student->student_code,
                'session_id' => $session_id + 1,
            );
            //dd($studentactivityupdate,$attributes);
            StudentActivity::updateOrCreate($attributes, $studentactivityupdate);
            // DB::table('student_activity')->insert($studentactivityupdate);
        }
        return redirect(route('studentPromotion.index'))->with(['msg' => "Promotion Success"]);
    }


    public function show($id) {}

    /**
     * File Upload Helper Function
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student) {}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        try {
            $Student = Student::find($id);
            $Student->delete();
            return 1;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function userupdate()
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        $users = array(
            array('id' => '11303', 'username' => 'mohuaaktershova@gmail.com', 'password' => '#123456#', 'phone' => '01995607140'),
            array('id' => '11130', 'username' => '01992300670', 'password' => '#123456#', 'phone' => '01992300670'),
            array('id' => '11326', 'username' => 'jyotsna.du.15@gmail.com', 'password' => '#123456#', 'phone' => '01982664021'),
            array('id' => '10927', 'username' => 'purnimasaha06@gmail.com', 'password' => '#123456#', 'phone' => '01963233090'),
            array('id' => '11083', 'username' => 'suraya87akter@gmail.com', 'password' => '#123456#', 'phone' => '01962578794'),
            array('id' => '11199', 'username' => 'nishattamannamumu@gmail.com', 'password' => '#123456#', 'phone' => '01956634724'),
            array('id' => '11036', 'username' => 'antorakabiraj@gmail.com', 'password' => '#123456#', 'phone' => '01954149629'),
            array('id' => '11298', 'username' => 'mahmudaakter8995@gmail.com', 'password' => '#123456#', 'phone' => '01942719088'),
            array('id' => '10949', 'username' => 'kaziarifa984@gmail.com', 'password' => '#123456#', 'phone' => '01941745482'),
            array('id' => '11027', 'username' => 'dumth988@gmail.com', 'password' => '#123456#', 'phone' => '01928592267'),
            array('id' => '10984', 'username' => 'mahbuba.ferdous81@gmail.com', 'password' => '#123456#', 'phone' => '01928085975'),
            array('id' => '11295', 'username' => 'shamimaafrinshammy@gmail.com', 'password' => '#123456#', 'phone' => '01927048125'),
            array('id' => '11245', 'username' => '01921312254', 'password' => '#123456#', 'phone' => '01921312254'),
            array('id' => '11331', 'username' => 'rokib3046@gmail.com', 'password' => '#123456#', 'phone' => '01919441686'),
            array('id' => '11010', 'username' => 'ornilapuja@gmail.com', 'password' => '#123456#', 'phone' => '01918996234'),
            array('id' => '10964', 'username' => 'abma3823@gmail.com', 'password' => '#123456#', 'phone' => '01917563141'),
            array('id' => '11106', 'username' => 'isratshishir80@gmail.com', 'password' => '#123456#', 'phone' => '01916434890'),
            array('id' => '11123', 'username' => 'rakibul.math90@gmail.com', 'password' => '#123456#', 'phone' => '01916211139'),
            array('id' => '11034', 'username' => 'alamsunny1990@gmail.com', 'password' => '#123456#', 'phone' => '01916052007'),
            array('id' => '11048', 'username' => 'sunitizaman@gmail.com', 'password' => '#123456#', 'phone' => '01915491505'),
            array('id' => '11011', 'username' => 'niharikapodder1980@gmail.com', 'password' => '#123456#', 'phone' => '01912085249'),
            array('id' => '10986', 'username' => 'daulatunnesaO3@gmail.com', 'password' => '#123456#', 'phone' => '01912083027'),
            array('id' => '10921', 'username' => 'shabiha.khanam.chinu@gmail.com', 'password' => '#123456#', 'phone' => '01911386919'),
            array('id' => '10939', 'username' => 'nehanuva@gmail.com', 'password' => '#123456#', 'phone' => '01911108969'),
            array('id' => '11336', 'username' => '01906469849', 'password' => '#123456#', 'phone' => '01906469849'),
            array('id' => '11211', 'username' => 'sultanamurshida@gmail.com', 'password' => '#123456#', 'phone' => '0186389563'),
            array('id' => '11118', 'username' => '01860640129', 'password' => '#123456#', 'phone' => '01860640129'),
            array('id' => '10955', 'username' => 'reziyakhatun981@gmail.com', 'password' => '#123456#', 'phone' => '01858077731'),
            array('id' => '11026', 'username' => 'kumkumjinat@gmail.com', 'password' => '#123456#', 'phone' => '01857408618'),
            array('id' => '11134', 'username' => '01857408618', 'password' => '#123456#', 'phone' => '01857408618'),
            array('id' => '11328', 'username' => 'yusufdalia3@gmail.com', 'password' => '#123456#', 'phone' => '01852978246'),
            array('id' => '11231', 'username' => 'akando092du@gmail.com', 'password' => '#123456#', 'phone' => '01837746806'),
            array('id' => '11334', 'username' => 'farhinsanjana@gmail.com', 'password' => '#123456#', 'phone' => '01831192388'),
            array('id' => '11319', 'username' => 'nasreen.akter96@gmail.com', 'password' => '#123456#', 'phone' => '01825223319'),
            array('id' => '11013', 'username' => 'rukshanaakter18@gmail.com', 'password' => '#123456#', 'phone' => '01824905419'),
            array('id' => '11045', 'username' => 'mazad1101133@gmail.com', 'password' => '#123456#', 'phone' => '01817600153'),
            array('id' => '11121', 'username' => 'riaadhikary69@gmail.com', 'password' => '#123456#', 'phone' => '01817562767'),
            array('id' => '11135', 'username' => 'rezowanasafrin72@gmail.com', 'password' => '#123456#', 'phone' => '01817550552'),
            array('id' => '10757', 'username' => 'selina.sultana376@gmail.com', 'password' => '#123456#', 'phone' => '01817106376'),
            array('id' => '10952', 'username' => 'shirinmithila0@gmail.com', 'password' => '#123456#', 'phone' => '01815943738'),
            array('id' => '10952', 'username' => 'shirinmithila0@gmail.com', 'password' => '#123456#', 'phone' => '01815943738'),
            array('id' => '11043', 'username' => 'fahmida5850@gmail.com', 'password' => '#123456#', 'phone' => '01815719134'),
            array('id' => '10925', 'username' => 'faruquenoa123@gmail.com', 'password' => '#123456#', 'phone' => '01813722368'),
            array('id' => '11111', 'username' => 'mahbubaahmed1979@gmail.com', 'password' => '#123456#', 'phone' => '01813365593'),
            array('id' => '11327', 'username' => 'irinonna@gmail.com', 'password' => '#123456#', 'phone' => '01797559343'),
            array('id' => '11191', 'username' => 'imrulkayeskhan@gmail.com', 'password' => '#123456#', 'phone' => '01797552789'),
            array('id' => '11053', 'username' => 'marufamohua2@gmail.com', 'password' => '#123456#', 'phone' => '01797156996'),
            array('id' => '11126', 'username' => 'shaylakhan1318@gmail.com', 'password' => '#123456#', 'phone' => '01796661318'),
            array('id' => '11299', 'username' => 'sumaiyabintenasir1997@gmail.com', 'password' => '#123456#', 'phone' => '01795961513'),
            array('id' => '11278', 'username' => 'devjpi12@gmail.com', 'password' => '#123456#', 'phone' => '01795530586'),
            array('id' => '11058', 'username' => 'islamsufia542@gmail.com', 'password' => '#123456#', 'phone' => '01795275918'),
            array('id' => '11189', 'username' => 'antora1463@gmail.com', 'password' => '#123456#', 'phone' => '01791179419'),
            array('id' => '11031', 'username' => 'sadiakbithi@gmail.com', 'password' => '#123456#', 'phone' => '01791035544'),
            array('id' => '11193', 'username' => 'kanizarsh@gmail.com', 'password' => '#123456#', 'phone' => '01787272898'),
            array('id' => '11007', 'username' => 'mdsadid000@gmail.com', 'password' => '#123456#', 'phone' => '01784005420'),
            array('id' => '10977', 'username' => 'tamalbiswas5@gmail.com', 'password' => '#123456#', 'phone' => '01782308342'),
            array('id' => '11161', 'username' => 'arpitadasbhoumik@gmail.com', 'password' => '#123456#', 'phone' => '01781409373'),
            array('id' => '11016', 'username' => 'salma216789@gmail.com', 'password' => '#123456#', 'phone' => '01775462446'),
            array('id' => '11213', 'username' => 'nidhita060@gmail.com', 'password' => '#123456#', 'phone' => '01770869139'),
            array('id' => '11213', 'username' => 'nidhita060@gmail.com', 'password' => '#123456#', 'phone' => '01770869139'),
            array('id' => '10990', 'username' => 'runa64824@gmail.com', 'password' => '#123456#', 'phone' => '01766659636'),
            array('id' => '11247', 'username' => '01759226422', 'password' => '#123456#', 'phone' => '01759226422'),
            array('id' => '11315', 'username' => 'ayesha0868@gmail.com', 'password' => '#123456#', 'phone' => '01758309396'),
            array('id' => '11042', 'username' => 'torikulislambaf@gmail.com', 'password' => '#123456#', 'phone' => '01756048010'),
            array('id' => '11092', 'username' => 'jannatrain@yahoo.com', 'password' => '#123456#', 'phone' => '01755671493'),
            array('id' => '11047', 'username' => 'rumapervin1972@gmail.com', 'password' => '#123456#', 'phone' => '01755010765'),
            array('id' => '11313', 'username' => 'nayemjannatun97du@gmail.com', 'password' => '#123456#', 'phone' => '01753372265'),
            array('id' => '11333', 'username' => 'sumaia.sau75@gmail.com', 'password' => '#123456#', 'phone' => '01752246818'),
            array('id' => '10941', 'username' => 'santarasul12@gamil.com', 'password' => '#123456#', 'phone' => '01749178875'),
            array('id' => '11287', 'username' => 'maymuna.auw@gmail.com', 'password' => '#123456#', 'phone' => '01742192691'),
            array('id' => '11125', 'username' => 'zohralopa@gmail.com', 'password' => '#123456#', 'phone' => '01740161426'),
            array('id' => '11335', 'username' => '01738168990', 'password' => '#123456#', 'phone' => '01738168990'),
            array('id' => '11227', 'username' => 'faisalahameddu@gmail.com', 'password' => '#123456#', 'phone' => '01737750670'),
            array('id' => '10975', 'username' => 'akber100.aa@gmail.com', 'password' => '#123456#', 'phone' => '01736784626'),
            array('id' => '11289', 'username' => 'nilyeasmin12@gmail.com', 'password' => '#123456#', 'phone' => '01736080410'),
            array('id' => '11312', 'username' => 'aliarshed112@gmail.com', 'password' => '#123456#', 'phone' => '01734957525'),
            array('id' => '11318', 'username' => 'amritatalukdarasha@gmail.com', 'password' => '#123456#', 'phone' => '01733422149'),
            array('id' => '11300', 'username' => 'imamaferdous95@gmail.com', 'password' => '#123456#', 'phone' => '01732143464'),
            array('id' => '10981', 'username' => 'runabaf@gmail.com', 'password' => '#123456#', 'phone' => '01731841269'),
            array('id' => '11044', 'username' => 'aklima.ankhi234@gmail.com', 'password' => '#123456#', 'phone' => '01731123700'),
            array('id' => '10991', 'username' => 'jobayr82@gmail.com', 'password' => '#123456#', 'phone' => '01728321461'),
            array('id' => '10953', 'username' => 'abdulhalimmia83@gmail.com', 'password' => '#123456#', 'phone' => '01728043383'),
            array('id' => '10953', 'username' => 'abdulhalimmia83@gmail.com', 'password' => '#123456#', 'phone' => '01728043383'),
            array('id' => '10936', 'username' => 'haqsamir93@gmail.com', 'password' => '#123456#', 'phone' => '01726533097'),
            array('id' => '11074', 'username' => 'danshador@gmail.com', 'password' => '#123456#', 'phone' => '01726310905'),
            array('id' => '10972', 'username' => 'saymadu88@gmail.com', 'password' => '#123456#', 'phone' => '01725544013'),
            array('id' => '11085', 'username' => 'rashid95116@gmail.com', 'password' => '#123456#', 'phone' => '01724909896'),
            array('id' => '11088', 'username' => '01724444088', 'password' => '#123456#', 'phone' => '01724444088'),
            array('id' => '11102', 'username' => 'najnin.sultana0805@gmail.com', 'password' => '#123456#', 'phone' => '01723000827'),
            array('id' => '11122', 'username' => 'akramhossain63@gmail.com', 'password' => '#123456#', 'phone' => '01721710063'),
            array('id' => '11294', 'username' => 'fouziasharmin93@gmail.com', 'password' => '#123456#', 'phone' => '01721087475'),
            array('id' => '11089', 'username' => 'anamika.hazra@gmail.com', 'password' => '#123456#', 'phone' => '01720611988'),
            array('id' => '10933', 'username' => 'bireshwarmadhu67@gmail.com', 'password' => '#123456#', 'phone' => '01720552437'),
            array('id' => '10968', 'username' => 'o2o81981fatama@gmail.com', 'password' => '#123456#', 'phone' => '01720120318'),
            array('id' => '10935', 'username' => 'absbafsdsiddique738@gmail.com', 'password' => '#123456#', 'phone' => '01718380044'),
            array('id' => '11337', 'username' => 'papiajahan.dsce@gmail.com', 'password' => '#123456#', 'phone' => '01718346287'),
            array('id' => '10938', 'username' => 'momenma264@gmail.com', 'password' => '#123456#', 'phone' => '01718345924'),
            array('id' => '11177', 'username' => 'ankhi151010@gmail.com', 'password' => '#123456#', 'phone' => '01717521585'),
            array('id' => '10946', 'username' => 'mitakabir146@gmail.com', 'password' => '#123456#', 'phone' => '01717171252'),
            array('id' => '11046', 'username' => 'begumrokeya.bafsd20@gmail.com', 'password' => '#123456#', 'phone' => '01717170942'),
            array('id' => '11104', 'username' => 'saymaafroze7@gmail. com', 'password' => '#123456#', 'phone' => '01716771647'),
            array('id' => '11041', 'username' => 'shamsun.gg@gmail.com', 'password' => '#123456#', 'phone' => '01716688916'),
            array('id' => '11195', 'username' => 'shirinkur79@gmail.com', 'password' => '#123456#', 'phone' => '01716303012'),
            array('id' => '10934', 'username' => 'muazzamhossain1978@gmail.com', 'password' => '#123456#', 'phone' => '01716074275'),
            array('id' => '11059', 'username' => 'kamrunneherbafsd@gmail.com', 'password' => '#123456#', 'phone' => '01716040468'),
            array('id' => '11179', 'username' => 'alma.raisa@outlook.com', 'password' => '#123456#', 'phone' => '01715672315'),
            array('id' => '11040', 'username' => 'rezaul70@gmail', 'password' => '#123456#', 'phone' => '01715656618'),
            array('id' => '10922', 'username' => 'tahminaparvinbafsd@gmail.com', 'password' => '#123456#', 'phone' => '01715303109'),
            array('id' => '11120', 'username' => 'shirinabegum801@gmail.com', 'password' => '#123456#', 'phone' => '01715301944'),
            array('id' => '10989', 'username' => 'rukubegum430@gmail.com', 'password' => '#123456#', 'phone' => '01712970296'),
            array('id' => '11292', 'username' => 'sanjidasharafi@gmail.com', 'password' => '#123456#', 'phone' => '01712579711'),
            array('id' => '10928', 'username' => 'ncdas125125@gmail.com', 'password' => '#123456#', 'phone' => '01712125110'),
            array('id' => '10969', 'username' => 'raziasultanaratna2@gmail.com', 'password' => '#123456#', 'phone' => '01711269689'),
            array('id' => '11197', 'username' => 'firoz.ahamed862@gmail.com', 'password' => '#123456#', 'phone' => '01710873862'),
            array('id' => '11280', 'username' => 'mokarroma89@gmail.com', 'password' => '#123456#', 'phone' => '01710519648'),
            array('id' => '11293', 'username' => 'rifatmahzabeen.du@gmail.com', 'password' => '#123456#', 'phone' => '01710289513'),
            array('id' => '11017', 'username' => 'sultanashishir159@gmail.com', 'password' => '#123456#', 'phone' => '01707652580'),
            array('id' => '10997', 'username' => 'aminaayat449@gmail.com', 'password' => '#123456#', 'phone' => '01703845517'),
            array('id' => '10944', 'username' => '01703498784', 'password' => '#123456#', 'phone' => '01703498784'),
            array('id' => '11091', 'username' => 'sirazom.monira15@gmail.com', 'password' => '#123456#', 'phone' => '01683356107'),
            array('id' => '11025', 'username' => 'itsshaylayasmin@gmail.com', 'password' => '#123456#', 'phone' => '01680556210'),
            array('id' => '11090', 'username' => 'mahmudamunni703@gmail.com', 'password' => '#123456#', 'phone' => '01680122718'),
            array('id' => '11931', 'username' => 'mafruhafarzanaemu@gmail.com', 'password' => '#123456#', 'phone' => '01680021303'),
            array('id' => '10996', 'username' => 'kowseruddin142036@gmail.com', 'password' => '#123456#', 'phone' => '01676288573'),
            array('id' => '11153', 'username' => 'sadia.urmi1990@gmail.com', 'password' => '#123456#', 'phone' => '01676152303'),
            array('id' => '10988', 'username' => 'rsharmin1980@gmail.com', 'password' => '#123456#', 'phone' => '01675761487'),
            array('id' => '11114', 'username' => 'laizuakter88@gmail.com', 'password' => '#123456#', 'phone' => '01675582346'),
            array('id' => '11101', 'username' => 'anikafarnajshmed@gmail.com', 'password' => '#123456#', 'phone' => '01674982117'),
            array('id' => '11151', 'username' => 'choton.lalmatia@gmail.com', 'password' => '#123456#', 'phone' => '01674922300'),
            array('id' => '11151', 'username' => 'choton.lalmatia@gmail.com', 'password' => '#123456#', 'phone' => '01674922300'),
            array('id' => '11103', 'username' => 'ssharmin269@gmail.com', 'password' => '#123456#', 'phone' => '01673917538'),
            array('id' => '11316', 'username' => 'sushmitasaha192@gmail.com', 'password' => '#123456#', 'phone' => '01672763768'),
            array('id' => '11155', 'username' => 'arif777mahabub@gmail.com', 'password' => '#123456#', 'phone' => '01670924777'),
            array('id' => '11119', 'username' => 'afsana7nadia@gmail.com', 'password' => '#123456#', 'phone' => '01670353710'),
            array('id' => '11175', 'username' => 'rubiaakter9@gmail.com', 'password' => '#123456#', 'phone' => '01635757143'),
            array('id' => '11301', 'username' => 'suraiya.rakhi0045@gmail.com', 'password' => '#123456#', 'phone' => '01630220045'),
            array('id' => '10993', 'username' => 'mahreezakaria@gmail.com', 'password' => '#123456#', 'phone' => '01627726844'),
            array('id' => '11063', 'username' => 'shahinurmitu02@gmail.com', 'password' => '#123456#', 'phone' => '01627463810'),
            array('id' => '11082', 'username' => 'rmousumi016@gmail.com', 'password' => '#123456#', 'phone' => '01612501602'),
            array('id' => '11187', 'username' => 'sadiakabir@gmail.com', 'password' => '#123456#', 'phone' => '01611777825'),
            array('id' => '11219', 'username' => 'kamrul.math.sust@gmail.com', 'password' => '#123456#', 'phone' => '01611102296'),
            array('id' => '11096', 'username' => 'aniqanusrat@gmail.com', 'password' => '#123456#', 'phone' => '01610610020'),
            array('id' => '11096', 'username' => 'aniqanusrat@gmail.com', 'password' => '#123456#', 'phone' => '01610610020'),
            array('id' => '11107', 'username' => 'sadia89.com@gmail.com', 'password' => '#123456#', 'phone' => '01557387798'),
            array('id' => '10995', 'username' => 'sadia.tuktuki556@gmail.com', 'password' => '#123456#', 'phone' => '01556316473'),
            array('id' => '10995', 'username' => 'sadia.tuktuki556@gmail.com', 'password' => '#123456#', 'phone' => '01556316473'),
            array('id' => '11296', 'username' => 'suzanaredwan.du@gmail.com', 'password' => '#123456#', 'phone' => '01552891105'),
            array('id' => '11321', 'username' => 'n03ahmed@gmail.com', 'password' => '#123456#', 'phone' => '01552551776'),
            array('id' => '11050', 'username' => 'parshataslima@gmail.com', 'password' => '#123456#', 'phone' => '01552413000'),
            array('id' => '11307', 'username' => 'tabassumtasnuva09@gmail.com', 'password' => '#123456#', 'phone' => '01552369770'),
            array('id' => '11014', 'username' => 'salehaahsan90@gmail.com', 'password' => '#123456#', 'phone' => '01551026882'),
            array('id' => '11329', 'username' => 'moshinbarshadu@gmail.com', 'password' => '#123456#', 'phone' => '01531792921'),
            array('id' => '11129', 'username' => 'soniamurshed1608@gmail.com', 'password' => '#123456#', 'phone' => '01521494049'),
            array('id' => '11932', 'username' => 'mdhasibuzzamanrabby@gmail.com', 'password' => '#123456#', 'phone' => '01521458750'),
            array('id' => '11291', 'username' => 'tasnimchowdhury079@gmail.com', 'password' => '#123456#', 'phone' => '01521256991'),
            array('id' => '11304', 'username' => 'pujamohonto14@gmail.com', 'password' => '#123456#', 'phone' => '01518930196'),
            array('id' => '11302', 'username' => 'mahfujaakterchoity@gmail.com', 'password' => '#123456#', 'phone' => '01518688523'),
            array('id' => '10957', 'username' => 'shohanmohammad21@gmail.com', 'password' => '#123456#', 'phone' => '01518339934'),
            array('id' => '10992', 'username' => 'safiakhanam.s@gmail.com', 'password' => '#123456#', 'phone' => '01517054988'),
            array('id' => '11338', 'username' => '01517024674', 'password' => '#123456#', 'phone' => '01517024674'),
            array('id' => '11201', 'username' => 'tawhidpeas@gmail.com', 'password' => '#123456#', 'phone' => '01517006112'),
            array('id' => '11330', 'username' => 'jahanmonira2013@gmail.com', 'password' => '#123456#', 'phone' => '01515600627'),
            array('id' => '11061', 'username' => 'ukh1975@gmail.com', 'password' => '#123456#', 'phone' => '01404379659'),
            array('id' => '11001', 'username' => 'effattahia360@gmail.com', 'password' => '#123456#', 'phone' => '01313902297'),
            array('id' => '11183', 'username' => 'marrium.nur@gmail.com', 'password' => '#123456#', 'phone' => '01312703306')
        );
        foreach ($users as $user) {
            $text = "Dear Teacher, please login https://bafsd.edu.bd/ using provided user id & password. You must change your password after your first login from the 'Change Password' option in the profile section. Please keep your password confidential. User Id: " . $user['username'] . " Password: " . $user['password'];
            $mobile = $user['phone'];
            //$mobile='01913366387';
            $password = array(
                'password' => '$2y$10$8uUtpnQLc7QXWFQVNpQF4.cp.Cx/M7CwoIXaWK9E3enoQe4u.yw9q'
            );
            DB::table('users')->where('id', $user['id'])->update($password);
            if ($mobile) {
                sms_send($mobile, $text);
            }
        }

        //sms_send($mobile, $text);
    }
}