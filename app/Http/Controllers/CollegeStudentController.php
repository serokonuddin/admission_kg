<?php

namespace App\Http\Controllers;

use App\Http\Requests\CollegeStudentStoreRequest;
use App\Models\sttings\Category;
use App\Models\sttings\Classes;
use App\Models\sttings\ClassWiseSubject;
use App\Models\sttings\Sections;
use App\Models\sttings\Sessions;
use App\Models\sttings\Shifts;
use App\Models\sttings\Versions;
use App\Models\Student\Student;
use App\Models\Student\StudentActivity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CollegeStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        Session::put('activemenu', 'student');
        Session::put('activesubmenu', 'cs');
        $sessions = Sessions::pluck('session_name', 'session_code');
        $versions = Versions::pluck('version_name', 'id');
        $shifts = Shifts::pluck('shift_name', 'id');
        $districts = DB::table('districts')->get();
        $groups = DB::table('academygroups')->get();
        $classes = Classes::where('active', 1)
            ->orderByRaw("CAST(class_code AS UNSIGNED)")
            ->pluck('class_name', 'class_code');
        $sections = Sections::where('class_code', 11)->get();
        $categories = Category::where('active', 1)->where('type', 2)->get();
        $houses = DB::table('houses')->get();

        return view('student.collegeAdmission', compact('sessions', 'houses', 'versions', 'groups', 'shifts', 'categories', 'districts', 'sections', 'classes'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        $classdata = Classes::where('id', $request->class_id)->first();
        $sessiondata = Sessions::where('id', $request->session_id)->first();
        if ($request->hasFile('photo')) {
            if (file_exists($request->photo_old)) {
                unlink($request->photo_old);
            }
            $destinationPath = 'sutdent/' . $sessiondata->session_name . '/' . $classdata->class_code;
            $myimage = $request->photo->getClientOriginalName();
            $request->photo->move(public_path($destinationPath), $myimage);
            $photo = asset('public/' . $destinationPath) . '/' . $myimage;
        } else {
            $photo = $request->photo_old;
        }

        if ($request->hasFile('testimonial')) {
            if (file_exists($request->testimonial_old)) {
                unlink($request->testimonial_old);
            }
            $destinationPath1 = 'testimonial/' . $sessiondata->session_name . '/' . $classdata->class_code;
            $myimage1 = $request->testimonial->getClientOriginalName();
            $request->testimonial->move(public_path($destinationPath), $myimage1);
            $testimonial = asset('public/' . $destinationPath) . '/' . $myimage1;
        } else {
            $testimonial = $request->testimonial_old;
        }
        if ($request->hasFile('academic_transcript')) {
            if (file_exists($request->academic_transcript_old)) {
                unlink($request->academic_transcript_old);
            }
            $destinationPath2 = 'academic_transcript/' . $sessiondata->session_name . '/' . $classdata->class_code;
            $myimage2 = $request->academic_transcript->getClientOriginalName();
            $request->academic_transcript->move(public_path($destinationPath), $myimage2);

            $academic_transcript = asset('public/' . $destinationPath) . '/' . $myimage2;
        } else {
            $academic_transcript = $request->academic_transcript_old;
        }

        if ($request->student_code != 0) {

            $activity = StudentActivity::where('student_code', $request->student_code)->where('session_id', $request->session_id)->where('active', 1)->first();
            $sessions = Sessions::where('active', 1)->first();

            DB::table('admission_temporary')->where('session_id', $sessions->id)->where('student_code', $request->student_code)->update(['section_id' => $activity->section_id]);
            if ($activity->class_id == 59) {
                if (isset($request->third_subject) && $request->fourth_subject) {
                } else {
                    return redirect()->route('StudentProfile', $request->id)->with('warning', 'Third And Fourth Subject Choose First');
                }
            }

            $activity->house_id = $this->housenumber($request->class_id, $request->gender);
            $activity->active = 1;
            $student_code = $request->student_code;
            $student = $request->except(['_token', 'student_code', 'photo_old', 'testimonial_old', 'academic_transcript_old', 'roll', 'mainsubject', 'third_subject', 'fourth_subject', '_method', 'session_id', 'version_id', 'shift_id', 'class_id', 'group_id', 'category_id', 'section_id', 'old_photo', 'old_birth_certificate']);
            $student['active'] = 1;
            $activity->updated_by = Auth::user()->id;
            $student['updated_by'] = Auth::user()->id;
            $student['photo'] = $photo;
            $student['testimonial'] = $testimonial;
            $student['academic_transcript'] = $academic_transcript;
            $student['updated_by'] = Auth::user()->id;
            $student['updated_at'] = date('Y-m-d H:s:i');

            DB::table('students')->where('student_code', $request->student_code)->update($student);
            $activity->save();
            $text = 'Student has been update successfully';
        } else {
            $activity = new StudentActivity();
            $activity->session_id = $request->session_id;
            $activity->version_id = $request->version_id;
            $activity->shift_id = $request->shift_id;
            $activity->class_id = $request->class_id;
            $activity->group_id = $request->group_id;
            $activity->section_id = $request->section_id;
            $activity->category_id = $request->category_id;
            $activity->roll = $request->roll;
            $activity->house_id = $this->housenumber($request->class_id, $request->gender);
            $activity->active = 1;
            $student = $request->except(['_token', 'id', 'roll', '_method', 'photo_old', 'testimonial_old', 'academic_transcript_old', 'session_id', 'version_id', 'shift_id', 'class_id', 'group_id', 'section_id', 'old_photo', 'old_birth_certificate']);
            $student['active'] = 1;
            $student['photo'] = $photo;
            $student['testimonial'] = $testimonial;
            $student['academic_transcript'] = $academic_transcript;
            $activity->created_by = Auth::user()->id;
            $id = DB::table('students')->insertGetId($student);
            $activity->student_code = date('Ym') . $id;
            $activity->save();
            $sudentdata = Student::find($id);
            $sudentdata->student_code = date('Ym') . $id;
            $sudentdata->save();
            $text = 'Student has been Save successfully';
        }

        if ($activity->class_id == 59) {
            $this->addsubject($request->mainsubject, $request->third_subject, $request->fourth_subject, $request->student_code, $activity->session_id);
        }
        if (Auth::user()->group_id == 4 && $request->submit == 2) {

            return redirect()->route('getidcard')->with('success', $text);
        }
        if (Auth::user()->group_id == 4 && $request->submit == 1) {
            return redirect()->route('StudentProfile', 0)->with('success', $text);
        }
        return redirect()->route('students.index')->with('success', $text);
    }

    // Ajax request handler
    public function admissionCollegeSave(CollegeStudentStoreRequest $request)
    {

        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        // dd($request->all());
        $session_id = $request->session_id;
        $class_code = $request->class_code;
        $class_id = $request->class_id;
        $version_id = $request->version_id;
        $roll = $request->roll;
        $shift_id = $request->shift_id;
        $group_id = $request->group_id;
        $section_id = $request->section_id;
        $category_id = $request->category_id;
        $studentData = null;
        $photo = null;

        if ($request->hasFile('photo')) {

            $destinationPath = 'sutdent/' . $request->session_id . '/' . $class_code;
            $myimage = $request->student_code . 'photo' . $request->photo->getClientOriginalName();
            $request->photo->move(public_path($destinationPath), $myimage);
            $photo = asset('public/' . $destinationPath) . '/' . $myimage;
        }
        if ($request->hasFile('admit_card')) {

            $destinationPath6 = 'admitcard/' . $request->session_id . '/' . $class_code;
            $myimage = $request->student_code . 'admitcard' . $request->admit_card->getClientOriginalName();
            $request->admit_card->move(public_path($destinationPath6), $myimage);
            $admit_card = asset('public/' . $destinationPath6) . '/' . $myimage;
        }
        if ($request->hasFile('father_nid')) {

            $destinationPath7 = 'nid/' . $request->session_id . '/' . $class_code;
            $myimage = $request->student_code . 'nid' . $request->father_nid->getClientOriginalName();
            $request->father_nid->move(public_path($destinationPath7), $myimage);
            $father_nid = asset('public/' . $destinationPath7) . '/' . $myimage;
        }
        if ($request->hasFile('mother_nid')) {

            $destinationPath8 = 'nid/' . $request->session_id . '/' . $class_code;
            $myimage = $request->student_code . 'nidm' . $request->mother_nid->getClientOriginalName();
            $request->mother_nid->move(public_path($destinationPath8), $myimage);
            $mother_nid = asset('public/' . $destinationPath8) . '/' . $myimage;
        }
        if ($request->hasFile('testimonial')) {

            $destinationPath1 = 'testimonial/' . $request->session_id . '/' . $class_code;
            $myimage1 = $request->student_code . 'testimonial' . $request->testimonial->getClientOriginalName();
            $request->testimonial->move(public_path($destinationPath1), $myimage1);
            $testimonial = asset('public/' . $destinationPath1) . '/' . $myimage1;
        }
        if ($request->hasFile('academic_transcript')) {

            $destinationPath2 = 'academic_transcript/' . $request->session_id . '/' . $class_code;
            $myimage2 = $request->student_code . 'academic_transcript' . $request->academic_transcript->getClientOriginalName();
            $request->academic_transcript->move(public_path($destinationPath2), $myimage2);

            $academic_transcript = asset('public/' . $destinationPath2) . '/' . $myimage2;
        }
        if ($request->hasFile('birth_certificate')) {

            $destinationPath3 = 'birth_certificate/' . $request->session_id . '/' . $class_code;
            $myimage2 = $request->student_code . 'birth_certificate' . $request->birth_certificate->getClientOriginalName();
            $request->birth_certificate->move(public_path($destinationPath3), $myimage2);

            $birth_certificate = asset('public/' . $destinationPath3) . '/' . $myimage2;
        }
        if ($request->hasFile('staff_certification')) {

            $destinationPath4 = 'staff_certification/' . $request->session_id . '/' . $class_code;
            $myimage2 = $request->student_code . 'staff_certification' . $request->staff_certification->getClientOriginalName();
            $request->staff_certification->move(public_path($destinationPath4), $myimage2);

            $staff_certification = asset('public/' . $destinationPath4) . '/' . $myimage2;
        }
        if ($request->hasFile('arm_certification')) {

            $destinationPath5 = 'arm_certification/' . $request->session_id . '/' . $class_code;
            $myimage2 = $request->student_code . 'arm_certification' . $request->arm_certification->getClientOriginalName();
            $request->arm_certification->move(public_path($destinationPath5), $myimage2);

            $arm_certification = asset('public/' . $destinationPath5) . '/' . $myimage2;
        }
        // Create or update based on student id
        if ($request->student_id != 0) {

            // Fetch or create StudentActivity
            $activity = StudentActivity::firstOrNew([
                'student_code' => $request->student_code,
                'session_id' => $request->session_id,
                'active' => 1,
            ]);

            if (in_array($activity->class_code, [11, 12])) {
                if (!empty($request->third_subject) && !empty($request->fourth_subject)) {
                    $this->addsubject(
                        $request->mainsubject,
                        $request->third_subject,
                        $request->fourth_subject,
                        $request->student_code,
                        $activity->session_id
                    );
                } else {
                    // return redirect()->route('StudentProfile', $request->id)->with('warning', 'Third And Fourth Subject Choose First');
                }
            }
            // Update activity based on user group
            $activity->fill([
                'session_id' => $request->session_id,
                'version_id' => $request->version_id,
                'shift_id' => $request->shift_id,
                'class_id' => $request->class_code,
                'class_code' => $request->class_code,
                'group_id' => $request->group_id,
                'section_id' => $request->section_id,
                'category_id' => $request->category_id,
                'house_id' => (Auth::user()->group_id == 2 || Auth::user()->group_id == 5) ? $request->house_id : $this->housenumber($request->class_code, $request->gender),
                'active' => 1,
                'updated_by' => Auth::user()->id,
            ]);
            $activity->save();
            // Student update
            $excludeKeys = ['_token', '_method', 'student_id', 'class_code', 'house_id', 'roll', 'mainsubject', 'third_subject', 'fourth_subject', 'old_photo', 'old_birth_certificate', 'session_id', 'version_id', 'shift_id', 'class_id', 'group_id', 'section_id', 'category_id'];
            $student = $request->except($excludeKeys);
            $student['active'] = 1;
            $student['updated_by'] = Auth::user()->id;
            $student['photo'] = $photo;
            $student['testimonial'] = $testimonial ?? null;
            $student['academic_transcript'] = $academic_transcript ?? null;
            $student['birth_certificate'] = $birth_certificate ?? null;
            $student['arm_certification'] = $arm_certification ?? null;
            $student['staff_certification'] = $staff_certification ?? null;
            $student['admit_card'] = $admit_card ?? null;
            $student['father_nid'] = $father_nid ?? null;
            $student['mother_nid'] = $mother_nid ?? null;
            $student['updated_by'] = Auth::user()->id;
            $student['updated_at'] = date('Y-m-d H:s:i');
            $studentData = DB::table('students')->where('id', $request->id)->update($student);
        } else {

            $activity = new StudentActivity();
            $activity->session_id = $request->session_id;
            $activity->version_id = $request->version_id;
            $activity->shift_id = $request->shift_id;
            $activity->class_id = $request->class_code;
            $activity->class_code = $request->class_code;
            $activity->group_id = $request->group_id;
            $activity->section_id = $request->section_id;
            $activity->category_id = $request->category_id;
            $activity->house_id = $this->housenumber($request->class_code, $request->gender);
            $activity->active = 1;
            $activity->created_by = Auth::user()->id;
            $activity->save();

            $student_code = $this->getStudentCode($activity);
            // Students create
            $excludeKeys = ['_token', '_method', 'student_id', 'class_code', 'house_id', 'roll', 'mainsubject', 'third_subject', 'fourth_subject', 'old_photo', 'old_birth_certificate', 'session_id', 'version_id', 'shift_id', 'class_id', 'group_id', 'section_id', 'category_id'];
            $student = $request->except($excludeKeys);
            $student['active'] = 1;
            $student['photo'] = $photo ?? null;
            $student['testimonial'] = $testimonial ?? null;
            $student['academic_transcript'] = $academic_transcript ?? null;
            $student['birth_certificate'] = $birth_certificate ?? null;
            $student['arm_certification'] = $arm_certification ?? null;
            $student['staff_certification'] = $staff_certification ?? null;
            $student['admit_card'] = $admit_card ?? null;
            $student['father_nid'] = $father_nid ?? null;
            $student['mother_nid'] = $mother_nid ?? null;
            $student['student_code'] = $student_code;
            $student['roll_number'] = $student_code;
            $student['session'] = $request->Session;
            $student['created_by'] = Auth::user()->id;
            $id = DB::table('students')->insertGetId($student);
            $studentData = Student::find($id);

            $activityupdate = StudentActivity::find($activity->id);
            $activityupdate->student_code = $student_code;
            $activityupdate->roll = $student_code;
            $activityupdate->save();
        }
        if (Auth::user()->group_id == 4) {
            $userdata = array('photo' => $photo);
            DB::table('users')->where('ref_id', $request->student_code)->update($userdata);
        } else {
            $userdata = array('photo' => $photo);
            DB::table('users')->where('ref_id', $request->student_code)->update($userdata);
        }

        return response()->json([
            'student' => $studentData,
            'activity' => $activity,

        ]);
    }

    public function addsubject($mainsubject, $third_subject, $fourth_subject, $student_code, $session_id)
    {

        $activity = StudentActivity::where('student_code', $student_code)->where('session_id', $session_id)->where('active', 1)->first();
        $student_subject = array();
        $i = 0;
        DB::table('student_subject')->where('student_code', $student_code)->where('session_id', $session_id)->delete();
        foreach ($mainsubject as $subjectdata) {
            $multisubject = explode('-', $subjectdata);
            $multisubject = array_unique($multisubject);
            foreach ($multisubject as $subject) {
                $student_subject[$i++] = array(
                    'class_id' => $activity->class_id,
                    'class_code' => $activity->class_code,
                    'version_id' => $activity->version_id,
                    'session_id' => $activity->session_id,
                    'subject_id' => $subject,
                    'student_code' => $student_code,
                    'is_fourth_subject' => 0,
                    'created_by' => Auth::user()->id
                );
            }
        }
        foreach ($third_subject as $subjectdata) {
            $multisubject = explode('-', $subjectdata);
            $multisubject = array_unique($multisubject);
            foreach ($multisubject as $subject) {
                $student_subject[$i++] = array(
                    'class_id' => $activity->class_id,
                    'class_code' => $activity->class_code,
                    'version_id' => $activity->version_id,
                    'session_id' => $activity->session_id,
                    'subject_id' => $subject,
                    'student_code' => $student_code,
                    'is_fourth_subject' => 2,
                    'created_by' => Auth::user()->id
                );
            }
        }
        foreach ($fourth_subject as $subjectdata) {
            $multisubject = explode('-', $subjectdata);
            $multisubject = array_unique($multisubject);
            foreach ($multisubject as $subject) {
                $student_subject[$i++] = array(
                    'class_id' => $activity->class_id,
                    'class_code' => $activity->class_code,
                    'version_id' => $activity->version_id,
                    'session_id' => $activity->session_id,
                    'subject_id' => $subject,
                    'student_code' => $student_code,
                    'is_fourth_subject' => 1,
                    'created_by' => Auth::user()->id
                );
            }
        }
        DB::table('student_subject')->insert($student_subject);
    }
    private function getmiddel($activity)
    {
        if ($activity->group_id) {
            if ($activity->group_id == '1' && $activity->version_id == 1) {
                $middel = 1000;
            } else if ($activity->group_id == '1' && $activity->version_id == 2) {
                $middel = 4000;
            } else if ($activity->group_id == '3' && $activity->version_id == 1) {
                $middel = 5000;
            } else if ($activity->group_id == '3' && $activity->version_id == 2) {
                $middel = 6000;
            } else if ($activity->group_id == '2' && $activity->version_id == 1) {
                $middel = 3000;
            } else {
                $middel = 3601;
            }
        } else {
            if ($activity->shift_id == 1 && $activity->version_id == 1) {
                $middel = 1000;
            } else if ($activity->shift_id == 1 && $activity->version_id == 2) {
                $middel = 3000;
            } else if ($activity->shift_id == 2 && $activity->version_id == 1) {
                $middel = 2000;
            } else if ($activity->shift_id == 2 && $activity->version_id == 2) {
                $middel = 4000;
            } else {
                $middel = 1000;
            }
        }
        return $middel;
    }
    public function getStudentCode($activity)
    {
        $count = DB::table('student_activity')
            ->where('session_id', $activity->session_id)
            ->where('version_id', $activity->version_id)
            ->where('class_code', $activity->class_code);

        if ($activity->group_id) {
            $count = $count->where('group_id', $activity->group_id);
        }

        $count = $count->count();
        $middel = $this->getmiddel($activity);
        $student_code = date('y') . ($middel + $count + 1);

        return $student_code;
    }

    public function getCommonSubjects($classCode)
    {
        return ClassWiseSubject::where('class_wise_subject.active', 1)
            ->join('classes', 'classes.id', '=', 'class_wise_subject.class_id')
            ->join('subjects', 'subjects.id', '=', 'class_wise_subject.subject_id')
            ->where('subject_type', 1)
            ->where('class_wise_subject.class_code', $classCode)
            ->select('subjects.*', 'class_wise_subject.subject_code')
            ->orderBy('class_wise_subject.subject_code', 'asc')
            ->get()
            ->groupBy('parent_subject');
    }

    public function getidcard()
    {
        $studentdata = DB::select('SELECT * FROM `students` WHERE `student_code` LIKE "' . Auth::user()->ref_id . '"');

        foreach ($studentdata as $key => $student) {
            $studentdata[$key]->activity = StudentActivity::where('student_code', $student->student_code)
                ->with(['session', 'version', 'classes', 'section', 'group'])
                ->where('active', 1)->first();
            $studentdata[$key]->qrCode   = QrCode::size(100)->style('round')->generate($student->student_code . '-' . $student->first_name);
        }
        return view('student.card', compact('studentdata'));
    }

    public function housenumber($class_id, $gender)
    {
        $session = Sessions::where('active', 1)->first();
        $count = DB::table('student_activity')
            ->join('students', 'students.student_code', '=', 'student_activity.student_code')
            ->where('session_id', $session->id)
            ->where('gender', $gender)
            ->where('class_id', $class_id)
            ->count();
        return (($count - 1) % 4) + 1;
    }

    public function StudentProfile($id)
    {

        if ($id != 0) {

            $studentdata = Student::where('id', $id)->first();

            $activity = StudentActivity::with('classes')->where('student_code', $studentdata->student_code)->orderBy('id', 'desc')->first();
            //$studentdata=array();
            $classes = Classes::where('session_id', $activity->session_id)
                ->where('class_code', $activity->class_code)
                ->get();
            $sections = Sections::where('class_code', $activity->class_code)->get();
        } else {

            // $student=Student::where('local_guardian_mobile',Auth::user()->phone)->get();

            $studentdata = DB::select('SELECT * FROM `students` WHERE `student_code` LIKE "' . Auth::user()->ref_id . '" order by id desc LIMIT 1');
            //dd($studentdata);
            if (count($studentdata) > 1) {
                $student = $studentdata;
            } else {
                $student = $studentdata[0];
            }
            $activity = StudentActivity::where('student_code', $studentdata[0]->student_code)->orderBy('id', 'desc')->first();

            $id = $studentdata[0]->id;
            $classes = Classes::where('session_id', $activity->session_id)
                ->where('class_code', $activity->class_code)
                ->get();
            $sections = Sections::where('class_code', $activity->class_code)->get();
        }

        Session::put('activemenu', 'profile');
        Session::put('activesubmenu', 'sc');
        $sessions = Sessions::where('active', 1)->get();
        $versions = Versions::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $districts = DB::table('districts')->get();
        $groups = DB::table('academygroups')->get();
        $houses = DB::table('houses')->get();

        $categories = Category::where('active', 1)->where('type', 2)->get();
        if ($activity->classes->class_code == '11' || $activity->classes->class_code == '12') {

            $comsubjects = ClassWiseSubject::where('class_wise_subject.active', 1)
                ->join('classes', 'classes.id', '=', 'class_wise_subject.class_id')
                ->join('subjects', 'subjects.id', '=', 'class_wise_subject.subject_id')
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->where('subject_type', 1)->with('subject')->where('class_wise_subject.class_code', $activity->classes->class_code)->orderBy('class_wise_subject.subject_code', 'asc')->get();
            $comsubjects = collect($comsubjects->groupBy('parent_subject'));
            $groupsubjects = ClassWiseSubject::where('class_wise_subject.active', 1)
                ->join('classes', 'classes.class_code', '=', 'class_wise_subject.class_code')
                ->join('subjects', 'subjects.id', '=', 'class_wise_subject.subject_id')
                ->where('group_id', $activity->group_id)
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->where('subject_type', 2)->where('class_wise_subject.class_code', $activity->classes->class_code)->orderBy('class_wise_subject.subject_code', 'asc')->get();

            $groupsubjects = collect($groupsubjects->groupBy('parent_subject'));
            $optionalsubjects = ClassWiseSubject::where('class_wise_subject.active', 1)
                ->join('classes', 'classes.class_code', '=', 'class_wise_subject.class_code')
                ->join('subjects', 'subjects.id', '=', 'class_wise_subject.subject_id')
                ->where('group_id', $activity->group_id)
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->where('subject_type', 3)->where('class_wise_subject.class_code', $activity->classes->class_code)->orderBy('class_wise_subject.serial', 'asc')->get();
            //dd($groupsubjects);
            $optionalsubjects = collect($optionalsubjects->groupBy('parent_subject'));
            $fourthsubjects = ClassWiseSubject::where('class_wise_subject.active', 1)
                ->join('classes', 'classes.class_code', '=', 'class_wise_subject.class_code')
                ->join('subjects', 'subjects.id', '=', 'class_wise_subject.subject_id')
                ->where('group_id', $activity->group_id)
                ->select('subjects.*', 'class_wise_subject.subject_code');
            if ($activity->version_id == 2) {
                $fourthsubjects = $fourthsubjects->whereNotIn('subject_code', [123, 124]);
            }

            $fourthsubjects = $fourthsubjects->where('subject_type', 4)->where('class_wise_subject.class_code', $activity->classes->class_code)->orderBy('class_wise_subject.serial', 'asc')->get();
            //dd($groupsubjects);
            $fourthsubjects = collect($fourthsubjects->groupBy('parent_subject'));

            $student_third_subject = DB::table('student_subject')
                ->join('subjects', 'subjects.id', '=', 'student_subject.subject_id')
                ->join('class_wise_subject', 'class_wise_subject.subject_id', '=', 'student_subject.subject_id')
                ->where('student_subject.session_id', $activity->session_id)
                ->where('student_subject.student_code', $activity->student_code)
                ->where('is_fourth_subject', 2)
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->get();
            $student_third_subject = collect($student_third_subject->groupBy('parent_subject'));

            $student_fourth_subject = DB::table('student_subject')
                ->join('subjects', 'subjects.id', '=', 'student_subject.subject_id')
                ->join('class_wise_subject', 'class_wise_subject.subject_id', '=', 'student_subject.subject_id')
                ->where('student_subject.session_id', $activity->session_id)
                ->where('student_subject.student_code', $activity->student_code)
                ->where('is_fourth_subject', 1)
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->get();
            $student_fourth_subject = collect($student_fourth_subject->groupBy('parent_subject'));
        } else {
            $comsubjects = array();
            $groupsubjects = array();
            $optionalsubjects = array();
            $fourthsubjects = array();
            $student_third_subject = array();
            $student_fourth_subject = array();
        }

        if (isset($studentdata[0]->submit)) {
            $submit = $studentdata[0]->submit;
            $studentdata = $studentdata[0];
            $student = $studentdata[0];
        } else {
            $submit = $studentdata->submit;
            $student = $studentdata;
        }
        if ($activity->classes->class_code == '11' && $submit != 2) {
            return view('student.studentAdmissionNew', compact('sessions', 'houses', 'fourthsubjects', 'student_third_subject', 'student_fourth_subject', 'comsubjects', 'groupsubjects', 'optionalsubjects', 'studentdata', 'groups', 'versions', 'shifts', 'categories', 'districts', 'sections', 'classes', 'student', 'activity', 'id'));
        } elseif ($activity->classes->class_code == '11' || $activity->classes->class_code == '12') {
            return view('student.studentAdmision', compact('sessions', 'houses', 'fourthsubjects', 'student_third_subject', 'student_fourth_subject', 'comsubjects', 'groupsubjects', 'optionalsubjects', 'studentdata', 'groups', 'versions', 'shifts', 'categories', 'districts', 'sections', 'classes', 'student', 'activity', 'id'));
        } else {
            return view('student.student_update', compact('sessions', 'houses', 'fourthsubjects', 'student_third_subject', 'student_fourth_subject', 'comsubjects', 'groupsubjects', 'optionalsubjects', 'studentdata', 'groups', 'versions', 'shifts', 'categories', 'districts', 'sections', 'classes', 'student', 'activity', 'id'));
        }
    }

    public function getSubjectsData(Request $request)
    {

        $group_id = $request->group_id;
        $student_code = $request->student_code;
        $session_id = $request->session_id;
        $class_code = $request->class_code;
        $version_id = $request->version_id;
        $comsubjects = [];
        $groupsubjects = [];
        $optionalsubjects = [];
        $fourthsubjects = [];
        $student_third_subject = array();
        $student_fourth_subject = array();
        // Logic for fetching subjects

        if ($class_code == '11' || $class_code == '12') {

            $comsubjects = ClassWiseSubject::where('class_wise_subject.active', 1)
                ->join('classes', 'classes.id', '=', 'class_wise_subject.class_id')
                ->join('subjects', 'subjects.id', '=', 'class_wise_subject.subject_id')
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->where('subject_type', 1)->with('subject')->where('class_wise_subject.class_code', $class_code)->orderBy('class_wise_subject.subject_code', 'asc')->get();
            $comsubjects = collect($comsubjects->groupBy('parent_subject'));
            $groupsubjects = ClassWiseSubject::where('class_wise_subject.active', 1)
                ->join('classes', 'classes.class_code', '=', 'class_wise_subject.class_code')
                ->join('subjects', 'subjects.id', '=', 'class_wise_subject.subject_id')
                ->where('group_id', $group_id)
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->where('subject_type', 2)->where('class_wise_subject.class_code', $class_code)->orderBy('class_wise_subject.subject_code', 'asc')->get();

            $groupsubjects = collect($groupsubjects->groupBy('parent_subject'));
            $optionalsubjects = ClassWiseSubject::where('class_wise_subject.active', 1)
                ->join('classes', 'classes.class_code', '=', 'class_wise_subject.class_code')
                ->join('subjects', 'subjects.id', '=', 'class_wise_subject.subject_id')
                ->where('group_id', $group_id)
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->where('subject_type', 3)->where('class_wise_subject.class_code', $class_code)->orderBy('class_wise_subject.serial', 'asc')->get();
            //dd($groupsubjects);
            $optionalsubjects = collect($optionalsubjects->groupBy('parent_subject'));
            $fourthsubjects = ClassWiseSubject::where('class_wise_subject.active', 1)
                ->join('classes', 'classes.class_code', '=', 'class_wise_subject.class_code')
                ->join('subjects', 'subjects.id', '=', 'class_wise_subject.subject_id')
                ->where('group_id', $group_id)
                ->select('subjects.*', 'class_wise_subject.subject_code');
            if ($version_id == 2) {
                $fourthsubjects = $fourthsubjects->whereNotIn('subject_code', [123, 124]);
            }

            $fourthsubjects = $fourthsubjects->where('subject_type', 4)->where('class_wise_subject.class_code', $class_code)->orderBy('class_wise_subject.serial', 'asc')->get();
            //dd($groupsubjects);
            $fourthsubjects = collect($fourthsubjects->groupBy('parent_subject'));

            $student_third_subject = DB::table('student_subject')
                ->join('subjects', 'subjects.id', '=', 'student_subject.subject_id')
                ->join('class_wise_subject', 'class_wise_subject.subject_id', '=', 'student_subject.subject_id')
                ->where('student_subject.session_id', $session_id)
                ->where('student_subject.student_code', $student_code)
                ->where('is_fourth_subject', 2)
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->get();
            $student_third_subject = collect($student_third_subject->groupBy('parent_subject'));

            $student_fourth_subject = DB::table('student_subject')
                ->join('subjects', 'subjects.id', '=', 'student_subject.subject_id')
                ->join('class_wise_subject', 'class_wise_subject.subject_id', '=', 'student_subject.subject_id')
                ->where('student_subject.session_id', $session_id)
                ->where('student_subject.student_code', $student_code)
                ->where('is_fourth_subject', 1)
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->get();
            $student_fourth_subject = collect($student_fourth_subject->groupBy('parent_subject'));
        } else {
            $comsubjects = array();
            $groupsubjects = array();
            $optionalsubjects = array();
            $fourthsubjects = array();
            $student_third_subject = array();
            $student_fourth_subject = array();
        }

        // Pass data to the view
        return view('student.dynamic_subjects', compact(
            'comsubjects',
            'groupsubjects',
            'optionalsubjects',
            'fourthsubjects',
            'group_id',
            'class_code',
            'student_third_subject',
            'student_fourth_subject'

        ));
    }

    public function studentConfirm($id)
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        $student = Student::find($id);
        $student->submit = 2;
        $student->save();
        $userdata = User::where('ref_id', $student->student_code)->first();
        //dd($userdata);
        if ($userdata) {
            $userdata->is_admission = 1;
            $userdata->is_profile_update = 1;
            $userdata->save();
        }

        return redirect()->route('dashboard')->with('success', 'Admission process is sucsessfull');
    }
    public function studentpreview(Request $request)
    {
        // dd($request->studentcode);
        $session = Sessions::where('active', 1)->first();
        $student = Student::where('student_code', $request->studentcode)->with(['present', 'permanent', 'studentActivity'])->first();
        $activity = StudentActivity::with(['classes', 'session', 'version', 'shift', 'group', 'section', 'category', 'house'])
            ->where('student_code', $student->student_code)
            ->where('session_id', $student->studentActivity->session_id)
            ->orderBy('id', 'desc')->first();

        $studentdata = array();
        $classes = Classes::where('session_id', $activity->class_id)
            ->get();
        $sections = Sections::where('class_id', $activity->class_id)->get();


        Session::put('activemenu', 'profile');
        Session::put('activesubmenu', 'sc');
        $sessions = Sessions::where('active', 1)->get();
        $versions = Versions::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $districts = DB::table('districts')->get();
        $groups = DB::table('academygroups')->get();
        $houses = DB::table('houses')->get();

        $categories = Category::where('active', 1)->where('type', 2)->get();

        if (!empty($activity->classes->class_code) && $activity->classes->class_code == '11') {

            $comsubjects = ClassWiseSubject::where('class_wise_subject.active', 1)
                ->join('classes', 'classes.id', '=', 'class_wise_subject.class_id')
                ->join('subjects', 'subjects.id', '=', 'class_wise_subject.subject_id')
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->where('subject_type', 1)->with('subject')->where('class_wise_subject.class_code', $activity->classes->class_code)->orderBy('class_wise_subject.subject_code', 'asc')->get();
            $comsubjects = collect($comsubjects->groupBy('parent_subject'));
            $groupsubjects = ClassWiseSubject::where('class_wise_subject.active', 1)
                ->join('classes', 'classes.id', '=', 'class_wise_subject.class_id')
                ->join('subjects', 'subjects.id', '=', 'class_wise_subject.subject_id')
                ->where('group_id', $activity->group_id)
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->where('subject_type', 2)->where('class_wise_subject.class_code', $activity->classes->class_code)->orderBy('class_wise_subject.subject_code', 'asc')->get();

            $groupsubjects = collect($groupsubjects->groupBy('parent_subject'));


            $student_third_subject = DB::table('student_subject')
                ->join('subjects', 'subjects.id', '=', 'student_subject.subject_id')
                ->join('class_wise_subject', 'class_wise_subject.subject_id', '=', 'student_subject.subject_id')
                ->where('student_subject.session_id', $activity->session_id)
                ->where('student_subject.student_code', $activity->student_code)
                ->where('is_fourth_subject', 2)
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->get();
            $student_third_subject = collect($student_third_subject->groupBy('parent_subject'));
            $student_fourth_subject = DB::table('student_subject')
                ->join('subjects', 'subjects.id', '=', 'student_subject.subject_id')
                ->join('class_wise_subject', 'class_wise_subject.subject_id', '=', 'student_subject.subject_id')
                ->where('student_subject.session_id', $activity->session_id)
                ->where('student_subject.student_code', $activity->student_code)
                ->where('is_fourth_subject', 1)
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->get();
            $student_fourth_subject = collect($student_fourth_subject->groupBy('parent_subject'));
        } else {
            $comsubjects = array();
            $groupsubjects = array();
            $student_fourth_subject = array();
            $student_third_subject = array();
        }

        //return view('student.details_view_student',compact('sessions','houses','fourthsubjects','student_third_subject','student_fourth_subject','comsubjects','groupsubjects','optionalsubjects','studentdata','groups','versions','shifts','categories','districts','sections','classes','student','activity','id'));
        return view('student.preview', compact('sessions', 'houses', 'student_third_subject', 'student_fourth_subject', 'comsubjects', 'groupsubjects', 'studentdata', 'groups', 'versions', 'shifts', 'categories', 'districts', 'sections', 'classes', 'student', 'activity'));
    }
}
