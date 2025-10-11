<?php

namespace App\Http\Controllers;

use App\Models\sttings\AcademySection;
use App\Models\sttings\Sections;
use App\Models\sttings\ClassSectionMapping;
use App\Models\sttings\Shifts;
use App\Models\sttings\Sessions;
use App\Models\sttings\Versions;
use App\Models\sttings\Classes;
use App\Models\Student\Student;
use App\Models\Student\StudentActivity;
use App\Models\sttings\ClassWiseSubject;

use App\Models\Employee\EmployeeActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        Session::put('activemenu', 'class');
        Session::put('activesubmenu', 'sc');
        $classvalue = Classes::where('active', 1)->get();
        $groups = AcademySection::where('active', 1)->get();
        $sections = Sections::with('classvalue')->with('version')->with('group')->orderBy('serial', 'asc')->get();
        $versions = Versions::where('active', 1)->get();
        return view('setting.section', compact('classvalue', 'versions', 'sections', 'groups'));
    }
    public function sectionWiseMapping(){
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        Session::put('activemenu', 'class');
        Session::put('activesubmenu', 'scm');
        $classSectionMapping=ClassSectionMapping::get();
        $versions = Versions::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        return view('setting.section_mapping', compact('classSectionMapping','versions','shifts'));
    }
    public function sectionmappingDestroy(Request $request,$id){
        dd($id);
    }
    public function sectionMappingStore(Request $request){
       // return $request->all();
        // if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
        //      return redirect(route('sectionWiseMapping'))->with(['msg' => 'Page Not Found']);
        // }
        $validated = $request->validate([
                    'class_code' => 'required',
                    'version_id' => 'required',
                    'shift_id' => 'required',
                    'ratio' => 'required',
                    'is_male_female' => 'required',
        ]);
        
        $id = $request->id;
        
        try {

             


            if ($id == 0) {
                $validated['created_by']=Auth::user()->id;
                ClassSectionMapping::insert($validated);
                $sms = "Successfully Inserted";
            } else {
                $validated['updated_by']=Auth::user()->id;
                ClassSectionMapping::where('id', $id)->update($validated);
                $sms = "Successfully Updated";
            }
            
            $this->sectionRatioMapping($validated);
            return redirect(route('sectionWiseMapping'))->with('success', $sms);
        } catch (\Exception $e) {

            return redirect(route('sectionWiseMapping'))->with(['msg' => $e]);
        }
    }
    public function sectionRatioMapping($mappingdata){
        
        $sections=Sections::where('shift_id',$mappingdata['shift_id'])
                    ->where('class_code',$mappingdata['class_code'])
                    ->where('version_id',$mappingdata['version_id'])->where('active',1)->get();
        //dd($sections);
        foreach($sections as $section){
            $sectiondata=[];
            if($mappingdata['is_male_female']==1){
                if($mappingdata['ratio']>0){
                    $sectiondata['male']=round($section->student_number*$mappingdata['ratio']/100);
                    $sectiondata['female']=round($section->student_number*(100-$mappingdata['ratio'])/100);
                }
            }elseif($mappingdata['is_male_female']==1){
                $sectiondata['male']=$section->student_number;
            }else{
                $sectiondata['female']=$section->student_number;
            }
            //dd($sectiondata);
            if($sectiondata){
                Sections::where('id',$section->id)->update($sectiondata);
            }
            return 1;
        }
    }
    /**
     * Show Section wise Student .
     */
    public function sectionWiseStudent(Request $request)
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        Session::put('activemenu', 'admission');
        Session::put('activesubmenu', 'scws');
        $groupData = [];
        $class_id = $request->class_id;
        $session_id = $request->session_id;
        $version_id = $request->version_id;
        $shift_id = $request->shift_id;
        $section_id = $request->section_id;

        $classes = Classes::where('active', 1)->get();
        $sections = Sections::where('sections.active', 1);
        if ($request->class_id) {
            $sections = $sections->where('class_id', $request->class_id)->orWhere('class_code', $request->class_id);
        }
        $sections = $sections->select('sections.*')->get();
        $sectiondata = [];
        if ($request->section_id) {
            $sectiondata = Sections::find($request->section_id);
        }
        //dd($sections);
        $students = [];
        $employees = [];

        if ($class_id && $section_id && $version_id  && $shift_id && $session_id) {
            $students = StudentActivity::where('session_id', $session_id)
                ->with('student')
                ->select('student_activity.*', 'students.gender')
                ->join('students', 'students.student_code', '=', 'student_activity.student_code')
                ->where('session_id', $session_id)
                ->where('version_id', $version_id)
                ->where('shift_id', $shift_id)
                ->where('section_id', $section_id)
                ->where('class_code', $class_id)
                ->get();

            $employees = EmployeeActivity::where('session_id', $session_id)
                ->select('employee_id')
                ->with('employee.designation')
                ->where('version_id', $version_id)
                ->where('shift_id', $shift_id)
                ->where('section_id', $section_id)
                ->where('class_code', $class_id)
                ->where('is_class_teacher', 1)
                ->groupBy('employee_id')
                ->get();
        } elseif ($class_id == 0 && $section_id && $version_id  && $shift_id && $session_id) {
            $students = StudentActivity::where('session_id', $session_id)
                ->with('student')
                ->select('student_activity.*', 'students.gender')
                ->join('students', 'students.student_code', '=', 'student_activity.student_code')
                ->where('session_id', $session_id)
                ->where('version_id', $version_id)
                ->where('shift_id', $shift_id)
                ->where('section_id', $section_id)
                ->where('class_code', $class_id)
                ->get();

            $employees = EmployeeActivity::where('session_id', $session_id)
                ->select('employee_id')
                ->with('employee.designation')
                ->where('version_id', $version_id)
                ->where('shift_id', $shift_id)
                ->where('section_id', $section_id)
                ->where('class_code', $class_id)
                ->where('is_class_teacher', 1)
                ->groupBy('employee_id')
                ->get();
        }


        $versions = Versions::where('active', 1)->get();
        $sessions = Sessions::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        if (isset($request->print)) {
            ini_set('max_execution_time', '300');
            ini_set("pcre.backtrack_limit", "5000000");

            $pdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8',
            ]);


            $pdf->WriteHTML('');
            $no_footer = 0;
            if (!$no_footer) {
                $footer = view('print.pdf_footer', []);
                $pdf->setHTMLFooter($footer, 'O');
                $pdf->setHTMLFooter($footer, 'E');
            }
            // $pdf->SetWatermarkImage(
            //     'https://bafsd.edu.bd/public/frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png',
            //     1,
            //     '',
            //     [160, 10]
            // );
            // $pdf->showWatermarkImage = true;
            $view = 'print.section_wise_student';
            $data = compact('classes', 'employees', 'sectiondata', 'sections', 'shifts', 'session_id', 'class_id', 'shift_id', 'version_id', 'section_id', 'students', 'sessions', 'versions');

            $html = view($view, $data);
            $pdf->WriteHTML($html);
            return  $pdf->Output();
        }
        return view('section.section_wise_student', compact('classes', 'employees', 'sectiondata', 'sections', 'shifts', 'session_id', 'class_id', 'shift_id', 'version_id', 'section_id', 'students', 'sessions', 'versions'));
    }
    /**
     * Show Subject wise Student .
     */
    public function subjectWiseStudent(Request $request)
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        Session::put('activemenu', 'admission');
        Session::put('activesubmenu', 'sws');
        $groupData = [];
        $class_id = $request->class_id;
        $session_id = $request->session_id;
        $version_id = $request->version_id;
        $shift_id = $request->shift_id;
        $section_id = $request->section_id;
        $session = Sessions::where('active', 1)->orderBy('id', 'desc')->first();
        $classes = Classes::where('active', 1)->get();
        $sections = Sections::where('sections.active', 1);
        if ($request->class_id) {
            $sections = $sections->where('class_id', $request->class_id)->orWhere('class_code', $request->class_id);
        }
        $sections = $sections->select('sections.*')->get();
        $sectiondata = [];
        if ($request->section_id) {
            $sectiondata = Sections::find($request->section_id);
        }
        //dd($sections);
        $students = [];
        $employees = [];
        if ($class_id && $session_id) {
            $groupData = DB::select("select id,class_id,group_id,version_id,section_name from sections
                            where class_code=11 and ifnull(group_id,0)!=0 order by version_id asc,group_id asc");


            foreach ($groupData as $key => $sectiondata) {
                //dd($sectiondata->id);
                $sqlsubject = "select subject_id,short_subject,count(sa.student_code) subject_number from student_subject
                     join student_activity sa on sa.student_code=student_subject.student_code
                     join subjects s on s.id=student_subject.subject_id
                     where sa.session_id=" . $session->id . " and sa.section_id=" . $sectiondata->id . "
                    group by subject_id,short_subject order by s.serial";

                $subjectdata = DB::select($sqlsubject);

                //dd($subjectdata);
                $subjectdata = collect($subjectdata)->groupBy('short_subject');
                // dd($subjectdata);
                $groupData[$key]->subject = $subjectdata;

                $groupData[$key]->total_student = StudentActivity::where('session_id', $session->id)->where('section_id', $sectiondata->id)->count();
            }
        }


        $versions = Versions::where('active', 1)->get();
        $sessions = Sessions::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        if (isset($request->print)) {
            ini_set('max_execution_time', '300');
            ini_set("pcre.backtrack_limit", "5000000");

            $pdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8',
            ]);


            $pdf->WriteHTML('');
            $no_footer = 0;
            if (!$no_footer) {
                $footer = view('print.pdf_footer', []);
                $pdf->setHTMLFooter($footer, 'O');
                $pdf->setHTMLFooter($footer, 'E');
            }
            $pdf->SetWatermarkImage(
                'https://bafsd.edu.bd/public/frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png',
                1,
                '',
                [160, 10]
            );
            $pdf->showWatermarkImage = true;
            $view = 'print.subject_wise_student';
            $data = compact('classes', 'sectiondata', 'sections', 'shifts', 'session_id', 'class_id', 'shift_id', 'version_id', 'section_id', 'groupData', 'sessions', 'versions');

            $html = view($view, $data);
            $pdf->WriteHTML($html);
            return  $pdf->Output();
        }
        return view('section.subject_wise_student', compact('classes', 'sectiondata', 'sections', 'shifts', 'session_id', 'class_id', 'shift_id', 'version_id', 'section_id', 'groupData', 'sessions', 'versions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        $id = $request->id;
        try {

            if ($id == 0) {

                $validated = $request->validate([
                    'section_name' => 'required',
                    'active' => 'required',
                    'serial' => 'required',
                    'class_code' => 'required',
                    'group_id' => 'nullable',
                    'version_id' => 'required',
                    'shift_id' => 'required',
                    'student_number' => 'required',
                ]);
            } else {
                $validated = $request->validate([
                    'section_name' => 'required',
                    'active' => 'required',
                    'serial' => 'required',
                    'class_code' => 'required',
                    'group_id' => 'nullable',
                    'version_id' => 'required',
                    'shift_id' => 'required',
                    'student_number' => 'required',
                ]);
            }


            if ($id == 0) {
                //$validated['student_number']=$validated['male']+$validated['female'];
                Sections::insert($validated);
                $sms = "Successfully Inserted";
            } else {
                //$validated['student_number']=$validated['male']+$validated['female'];
                Sections::where('id', $id)->update($validated);
                $sms = "Successfully Updated";
            }
            return redirect(route('section.index'))->with('success', $sms);
        } catch (\Exception $e) {

            return redirect(route('section.index'))->with(['msg' => $e]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sections $sections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sections $sections)
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
            $Sessions = Sections::find($id);
            $Sessions->delete();
            return 1;
        } catch (\Exception $e) {
            return $e;
        }
    }
}