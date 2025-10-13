<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\BoardListImport;
use App\Models\AdmissionOpen;
use App\Models\BoardList;
use App\Models\KgStudentAdmission;
use App\Models\StudentAdmission;
use App\Models\sttings\Sessions;
use App\Models\sttings\Shifts;
use App\Models\sttings\Classes;
use App\Models\sttings\Sections;
use App\Models\sttings\Versions;
use App\Models\Student\Student;
use App\Models\sttings\ClassWiseSubject;
use App\Models\Student\StudentActivity;
use App\Models\sttings\Category;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Models\Admission;
use App\Exports\AdmissionStudentBySubject;
use App\Exports\AdmissionStudentBySubjectGroup;
use App\Exports\AdmissionStudentBySectionSubject;
use App\Exports\AdmissionExport;
use App\Exports\AdmissionExportMale;
use App\Exports\AdmissionExportFemale;
use App\Exports\AdmissionExportTotal;
use App\Exports\AdmissionExportTotalMale;
use App\Exports\AdmissionExportTotalFemale;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Helpers\Helpers;
use App\Http\Requests\Admission\AdmissionStoreRequest;
use App\Models\AcademyInfo;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

set_time_limit(3000);
class AdmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function boardList(Request $request)
    {
        Session::put('activemenu', 'admission');
        Session::put('activesubmenu', 'bl');
        $sessions = Sessions::where('active', 1)->get();
        $session = Sessions::where('active', 1)->first();
        $versions = Versions::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $classes = Classes::where('active', 1)
            ->where('session_id', $request->session_id)
            ->where('shift_id', $request->shift_id)
            ->where('version_id', $request->version_id)
            ->get();
        $version_id = $request->version_id;
        $session_id = $request->session_id;
        $shift_id = $request->shift_id;
        $class_id = $request->class_id;
        $text_search = $request->text_search;
        $students = [];
        if ($session_id) {
            $students = BoardList::with(['class', 'session', 'version'])->where('session_id', $session_id);
            if ($version_id) {
                $students = $students->whereRaw('version_id = "' . $version_id . '"');
            }

            if ($class_id) {
                $students = $students->whereRaw('class_id = "' . $class_id . '"');
            }
            if (!empty($text_search)) {
                $students = $students->whereRaw("full_name LIKE '%" . $text_search . "%' or mobile LIKE '%" . $text_search . "%' or roll_number LIKE '%" . $text_search . "%'");
            }
            $students = $students->orderBy('id', 'desc')->paginate(20);
        } else {
            $students = BoardList::with(['class', 'session', 'version'])->where('session_id', $session->id);
            $students = $students->orderBy('id', 'desc')->paginate(20);
        }
        return view('admission.boardList', compact('students', 'text_search', 'session_id', 'version_id', 'class_id', 'shift_id', 'classes', 'shifts', 'versions', 'sessions'));
    }
    public function kgadmissionNull($version_id, $shift_id, $id)
    {

        $max = DB::table('student_admission')
            ->where('version_id', $version_id)
            ->where('shift_id', $shift_id)
            ->where('payment_status', 1)
            ->max('temporary_id');
        if ($version_id == 1 && $shift_id == 1) {
            $number = (10000 + (int)$max + 1) - 10000;
        } else if ($version_id == 1 && $shift_id == 2) {
            $number = (30000 + (int)$max + 1) - 30000;
        } else if ($version_id == 2 && $shift_id == 1) {
            $number = (20000 + (int)$max + 1) - 20000;
        } else if ($version_id == 2 && $shift_id == 2) {
            $number = (40000 + (int)$max + 1) - 40000;
        }
        DB::table('student_admission')
            ->where('id', $id)
            ->update(['temporary_id' => $number]);
        return $number;
    }
    // Kg Admission
    public function sendSmsForTemporaryID(Request $request)
    {
        $studentdata = StudentAdmission::find($request->id);
        if ($studentdata) {

            if ($studentdata->mobile && $studentdata->temporary_id) {
                $textdata = 'Your New Temporary Number is ' . $studentdata->temporary_id . '. Please Collect Your Admit Card Link: ' . env('APP_URL') . '/admissionview';

                return  sms_send($studentdata->mobile, $textdata);
            } else {
                return 0;
            }
        }
    }
    public function admissionupdate(Request $request)
    {
        if (empty($request->id) && $request->payment_status == 0) {
            return back()->with('warning', 'No data found');
        }
        $request->validate([
            'staff_certification' => 'nullable|mimes:jpg,jpeg,png,pdf,webp|max:1024', // Optional file with allowed types and max size 2MB
            'arm_certification' => 'nullable|mimes:jpg,jpeg,png,pdf,webp|max:1024', // Optional file with allowed types and max size 2MB
            'birth_image' => 'nullable|mimes:jpg,jpeg,pdf,png,webp|max:1024', // Optional file with allowed types and max size 2MB
            'photo' => 'nullable|mimes:jpg,jpeg,png,webp|max:1024', // Optional file with allowed types and max size 2MB
        ]);
        $sessions = Sessions::where('id', $request->session_id)->first();


        if ($request->hasFile('staff_certification')) {
            $destinationPath = 'staff_certification/' . $sessions->session_name . '/' . $request->class_id;
            $myimage = date('dmyhis') . $request->staff_certification->getClientOriginalName();
            $request->staff_certification->move(public_path($destinationPath), $myimage);
            $staff_certification = asset('public/' . $destinationPath) . '/' . $myimage;
        } else {
            $staff_certification = $request->staff_certification_old;;
        }

        if ($request->hasFile('arm_certification')) {
            $destinationPath = 'arm_certification/' . $sessions->session_name . '/' . $request->class_id;
            $myimage = date('dmyhis') . $request->arm_certification->getClientOriginalName();
            $request->arm_certification->move(public_path($destinationPath), $myimage);
            $arm_certification = asset('public/' . $destinationPath) . '/' . $myimage;
        } else {
            $arm_certification = $request->arm_certification_old;
        }
        if ($request->hasFile('birth_image')) {
            $destinationPath = 'birth_image/' . $sessions->session_name . '/' . $request->class_id;
            $myimage = date('dmyhis') . $request->birth_image->getClientOriginalName();
            $request->birth_image->move(public_path($destinationPath), $myimage);
            $birth_image = asset('public/' . $destinationPath) . '/' . $myimage;
        } else {
            $birth_image = $request->birth_image_old;
        }
        if ($request->hasFile('photo')) {
            $destinationPath = 'photo/' . $sessions->session_name . '/' . $request->class_id;
            $myimage = date('dmyhis') . $request->photo->getClientOriginalName();
            $request->photo->move(public_path($destinationPath), $myimage);
            $photo = asset('public/' . $destinationPath) . '/' . $myimage;
        } else {
            $photo = $request->photo_old;
        }

        if ($request->temporary_id) {
            $temporary_id = $request->temporary_id;
        } else {
            $studentdata = StudentAdmission::find($request->id);
            if (empty($studentdata->temporary_id)) {
                $temporary_id = $this->kgadmissionNull($request->version_id, $request->shift_id, $request->id);
            } else {
                $temporary_id = $studentdata->temporary_id;
            }
        }

        $admission = array(
            'session_id' => $request->session_id,
            'version_id' => $request->version_id,
            'shift_id' => $request->shift_id,
            'class_id' => $request->class_id,
            'category_id' => $request->category_id,
            'name_en' => $request->name_en,
            'name_bn' => $request->name_bn,
            'service_holder_name' => $request->service_holder_name ?? null,
            'service_name' => $request->service_name ?? null,
            'name_of_service' => $request->name_of_service ?? null,
            'in_service' => $request->in_service ?? null,
            'office_address' => $request->office_address ?? null,
            'name_of_staff' => $request->name_of_staff ?? null,
            'staff_designation' => $request->staff_designation ?? null,
            'staff_id' => $request->staff_id ?? null,
            'staff_certification' => $staff_certification ?? null,
            'arm_certification' => $arm_certification ?? null,
            'gen_id' => $request->gen_id ?? null,
            'section' => $request->section ?? null,
            'dob' => date('Y-m-d', strtotime($request->dob)),
            'gender' => $request->gender,
            'gurdian_name' => $request->gurdian_name,
            'payment_status' => $request->payment_status,
            'mobile' => $request->mobile,
            'temporary_id' => $temporary_id,
            'birth_registration_number' => $request->birth_registration_number,
            'birth_image' => $birth_image,
            'photo' => $photo,
        );

        StudentAdmission::where('id', $request->id)->update($admission);

        return back()->with('success', 'Update successful!');
    }
    public function kgAdmitList(Request $request)
    {
        Session::put('activemenu', 'admission');
        Session::put('activesubmenu', 'kl');

        $sessions = Sessions::where('active', 1)->get();
        $session = Sessions::where('active', 1)->first();
        $versions = Versions::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $categories = Category::where('active', 1)->get();
        $classes = Classes::where('active', 1)
            ->where('session_id', $request->session_id)
            ->where('shift_id', $request->shift_id)
            ->where('version_id', $request->version_id)
            ->get();

        $admissiondata = AdmissionOpen::with(['class', 'version', 'session'])
            ->where('class_id', 0)
            ->where('session_id', 2024)
            ->get();

        $version_id = $request->version_id;
        $session_id = $request->session_id;
        $shift_id = $request->shift_id;
        $class_id = $request->class_id;
        $category_id = $request->category_id;
        $temporary_id = $request->temporary_id;
        $birth_registration_number = $request->birth_registration_number;
        $mobile = $request->mobile;
        $text_search = $request->text_search;
        $students = [];

        if ($session_id) {
            $students = KgStudentAdmission::with(['class', 'session', 'version'])
                ->where('session_id', $session_id);

            if ($version_id) {
                $students = $students->where('version_id', $version_id);
            }

            if ($shift_id) {
                $students = $students->where('shift_id', $shift_id);
            }

            if ($class_id) {
                $students = $students->where('class_id', $class_id);
            }

            if ($category_id) {
                $students = $students->where('category_id', $category_id);
            }

            if ($temporary_id) {
                $students = $students->where('temporary_id', 'LIKE', "%{$temporary_id}%");
            }

            if ($birth_registration_number) {
                $students = $students->where('birth_registration_number', 'LIKE', "%{$birth_registration_number}%");
            }

            if ($mobile) {
                $students = $students->where('mobile', 'LIKE', "%{$mobile}%");
            }

            if (!empty($text_search)) {
                $students = $students->where(function ($query) use ($text_search) {
                    $query->where('name_en', 'LIKE', "%{$text_search}%")
                        ->orWhere('mobile', 'LIKE', "%{$text_search}%")
                        ->orWhere('temporary_id', 'LIKE', "%{$text_search}%");
                });
            }

            $students = $students->orderBy('id', 'desc')->paginate(20);
        } else {
            $students = KgStudentAdmission::with(['class', 'session', 'version'])
                ->where('session_id', $session->id)
                ->orderBy('id', 'desc')
                ->paginate(20);
        }

        return view('admission.kgAdmissionList', compact(
            'students',
            'categories',
            'text_search',
            'session_id',
            'version_id',
            'class_id',
            'shift_id',
            'category_id',
            'temporary_id',
            'birth_registration_number',
            'mobile',
            'classes',
            'shifts',
            'versions',
            'sessions',
            'admissiondata'
        ));
    }

    public function storeKgAdmit(Request $request)
    {


        $request->validate([
            'name_en' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'version_id' => 'required|integer',
            'shift_id' => 'required|integer',
            'birth_registration_number' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|integer',
            'mobile' => 'required|string|max:15',
            'payment_status' => 'required|integer',
        ]);

        // Create a new student admission entry
        KgStudentAdmission::create([
            'name_en' => $request->name_en,
            'temporary_id' => $request->temporary_id,
            'category_id' => $request->category_id,
            'version_id' => $request->version_id,
            'shift_id' => $request->shift_id,
            'birth_registration_number' => $request->birth_registration_number,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'mobile' => $request->mobile,
            'payment_status' => $request->payment_status,
        ]);

        return redirect()->back()->with('success', 'Student admission created successfully.')->with(compact('admissiondata'));
    }




    public function updateKgAdmit(Request $request)
    {

        // dd($request->all());
        $request->validate([
            'id' => 'required|exists:student_admission,id',
        ]);

        // Find the student by ID
        $student = KgStudentAdmission::find($request->id);

        if (!$student) {
            return redirect()->back()->with('error', 'Student not found');
        }


        // Update the student data
        $student->update($request->except('_token', 'id'));

        return redirect()->back()->with('success', 'Student updated successfully.');
    }


    public function index(Request $request)
    {
        //dd($request->all());
        Session::put('activemenu', 'admission');
        Session::put('activesubmenu', 'al');
        $sessions = Sessions::where('active', 1)->get();
        $versions = Versions::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $classes = Classes::where('active', 1)
            ->where('session_id', $request->session_id)
            ->where('shift_id', $request->shift_id)
            ->where('version_id', $request->version_id)
            ->get();
        $sections = Sections::where('active', 1);
        if ($request->class_id) {
            $sections = $sections->where('class_id', (int)$request->class_id);
        }

        $sections = $sections->get();
        $version_id = $request->version_id;
        $session_id = $request->session_id;
        $shift_id = $request->shift_id;
        $class_id = $request->class_id;
        $section_id = $request->section_id;
        $text_search = $request->text_search;

        $admissions = Admission::with(['group', 'section'])
            ->selectRaw('admission_temporary.*,11 class_name,student_fee_tranjection.id as tran_id,student_fee_tranjection.created_at as createdat')
            //->join('classes', 'classes.id', '=', 'admission_temporary.class_id')
            ->leftjoin('student_fee_tranjection', 'student_fee_tranjection.admission_id', '=', 'admission_temporary.id')
            ->join('students', 'students.student_code', '=', 'admission_temporary.student_code');

        /// $admissions = $admissions
        //	->whereIn('admission_temporary.student_code', function ($row) use ($session_id, $version_id, $shift_id, $class_id, $section_id) {
        //    $row->select('student_code')
        //        ->from('student_activity');
        // if ($session_id) {
        //     $row->whereRaw('session_id = "' . $session_id . '"');
        // }
        // if ($version_id) {
        //     $row->whereRaw('version_id = "' . $version_id . '"');
        //  }
        //  if ($shift_id) {
        //      $row->whereRaw('shift_id = "' . $shift_id . '"');
        //    }
        //  if ($class_id) {
        //     $row->whereRaw('class_id = "' . $class_id . '"');
        //    }
        //   if ($section_id) {
        //       $row->whereRaw('section_id = "' . $section_id . '"');
        //   }
        //  });

        if (!empty($text_search)) {
            $admissions = $admissions->whereRaw("full_name LIKE '%" . $text_search . "%' or admission_temporary.student_code LIKE '%" . $text_search . "%' or phone LIKE '%" . $text_search . "%' or admission_temporary.email LIKE '%" . $text_search . "%' or admission_temporary.roll_number LIKE '%" . $text_search . "%'");
        }
        $admissions = $admissions->orderBy('student_fee_tranjection.id', 'asc')->get();

        // foreach($admissions as $key=>$admission){
        //     $admissions[$key]->details=DB::table('student_fee_tranjection')
        //     //->join('student_fee_tranjection','student_fee_tranjection.id','=','payment_details.tran_id')
        //     ->where('admission_id',$admission->id)->first();
        // }
        //dd($admissions);
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
            $view = 'print.commonprint';
            $data = compact('admissions', 'text_search', 'section_id', 'session_id', 'version_id', 'class_id', 'shift_id', 'sections', 'classes', 'shifts', 'versions', 'sessions');

            $html = view($view, $data);
            $pdf->WriteHTML($html);
            return  $pdf->Output();
        }
        return view('admission.index', compact('admissions', 'text_search', 'section_id', 'session_id', 'version_id', 'class_id', 'shift_id', 'sections', 'classes', 'shifts', 'versions', 'sessions'));
    }


    public function admissionOpen()
    {
        Session::put('activemenu', 'admission');
        Session::put('activesubmenu', 'oa');
        $session = Sessions::where('active', '1')->first();
        $classes = Classes::where('active', 1)->where('session_id', $session->id)->with(['version'])->get();
        $admissiondata = AdmissionOpen::where('session_id', $session->id)->with(['class', 'session', 'version'])->get();

        return view('admission.admission_open', compact('session', 'classes', 'admissiondata'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Session::put('activemenu', 'admission');
        Session::put('activesubmenu', 'oa');
        $session = Sessions::where('active', '1')->first();
        $versions = Versions::where('active', '1')->get();
        $classes = Classes::where('active', 1)->where('session_id', $session->id)->with(['version'])->distinct('class_code')->orderBy('class_code', 'asc')->get();
        $classes = collect($classes)->unique(['class_code']);
        return view('admission.create', compact('session', 'classes', 'versions'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function saveXLList($file, $input)
    {
        DB::table('board_list')
            ->where('session_id', $input['session_id'])
            ->where('version_id', $input['version_id'])
            ->where('class_id', $input['class_id'])
            ->delete();
        Excel::import(new BoardListImport, $file);
    }

    public function store(AdmissionStoreRequest $request)
    {
        if ($request->hasFile('file')) {
            $destinationPath = 'admissionxl';
            $myimage = $request->file('file')->getClientOriginalName();
            $request->file('file')->move(public_path($destinationPath), $myimage);
            $file = public_path($destinationPath) . '/' . $myimage;
            $this->saveXLList($file, $request->all());
        } else {
            $file = $request->file_old;
        }

        $id = $request->id;
        try {
            $validated = $request->validate([
                'version_id' => 'required',
                'class_id' => 'required',
                'session_id' => 'required',
                'number_of_admission' => 'required',
                'price' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'admission_start_date' => 'required',
                'admission_end_date' => 'required',
                'status' => 'required',
            ]);

            $validated['file'] = $file;
            $user = Auth::user()->id;

            if ($id == 0) {
                $validated['created_by'] = $user;
                AdmissionOpen::insert($validated);
                $sms = "Successfully Inserted";
            } else {
                $validated['updated_by'] = $user;
                AdmissionOpen::where('id', $id)->update($validated);
                $sms = "Successfully Updated";
            }

            return redirect(route('admissionOpen'))->with('success', $sms);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Session::put('activemenu', 'admission');
        Session::put('activesubmenu', 'oa');
        $session = Sessions::where('active', '1')->first();
        $versions = Versions::where('active', '1')->get();
        $classes = Classes::where('active', 1)->where('session_id', $session->id)->with(['version'])->distinct('class_code')->orderBy('class_code', 'asc')->first();
        $admission = AdmissionOpen::where('id', $id)->with(['class', 'session', 'version'])->get();
        $classes = collect($classes)->unique(['class_code']);
        return view('admission.create', compact('session', 'classes', 'versions', 'admission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Session::put('activemenu', 'admission');
        Session::put('activesubmenu', 'oa');
        $session = Sessions::where('active', '1')->first();
        $versions = Versions::where('active', '1')->get();
        $classes = Classes::where('active', 1)->where('session_id', $session->id)->with(['version'])->distinct('class_code')->orderBy('class_code', 'asc')->get();
        $admission = AdmissionOpen::find($id);
        $classes = collect($classes)->unique(['class_code']);

        return view('admission.create', compact('session', 'classes', 'versions', 'admission'));
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
    public function passwordRecovery($student_code, $phone)
    {

        $student = Student::where('student_code', $student_code)->first();

        // $student=Student::where('student_code',$student_code)->first();
        $password = $this->generateRandomNumber();
        $studentdata = array('sms_notification' => $phone);

        // DB::table('students')->where('id',$student->id)->update($studentdata);
        $sms_notification = $student->sms_notification;

        $user = DB::table('users')
            ->where('ref_id', $student_code)
            //->where('phone', $sms_notification)
            ->first();

        $userdata = array('password' => bcrypt($password), 'phone' => $phone);


        DB::table('users')->where('id', $user->id)->update($userdata);
        sms_send($phone, 'Please login and Complete your admission. User: ' . $user->username . ', Pass: ' . $password . '. Link: https://bafsdadmission.com/login');
        return 1;
    }
    function generateRandomNumber()
    {
        // Generates a 6-digit random number
        return rand(100000, 999999);
    }
    public function admissionXl($class_id, $section_id)
    {

        return Excel::download(new AdmissionExport($class_id, $section_id), 'admission2024.xlsx');
    }
    public function admissionXlMale($class_id, $section_id)
    {

        return Excel::download(new AdmissionExportMale($class_id, $section_id), 'admissionMale2024.xlsx');
    }
    public function admissionXlFemale($class_id, $section_id)
    {

        return Excel::download(new AdmissionExportFemale($class_id, $section_id), 'admissionFemale2024.xlsx');
    }
    public function admissionXlTotal($class_id)
    {

        return Excel::download(new AdmissionExportTotal($class_id), 'admission2024.xlsx');
    }
    public function admissionXlTotalMale($class_id)
    {

        return Excel::download(new AdmissionExportTotalMale($class_id), 'admissionMale2024.xlsx');
    }
    public function admissionXlTotalFemale($class_id)
    {

        return Excel::download(new AdmissionExportTotalFemale($class_id), 'admissionFemale2024.xlsx');
    }

    public function getTotalStudentBySubject($subject)
    {

        return Excel::download(new AdmissionStudentBySubject($subject), $subject . date('Y') . '.xlsx');
    }
    public function getTotalStudentBySubjectGroup($subject, $group_id)
    {
        if ($group_id == 1) {
            $text = "Science";
        } elseif ($group_id == 2) {
            $text = "Humanities";
        } else {
            $text = "BusinessStudies";
        }
        return Excel::download(new AdmissionStudentBySubjectGroup($subject, $group_id), $subject . $text . date('Y') . '.xlsx');
    }
    public function getTotalStudentBySectionSubject($section_id, $subject)
    {
        $section = DB::table('sections')->where('id', $section_id)->first();
        return Excel::download(new AdmissionStudentBySectionSubject($subject, $section_id), $subject . $section->section_name . date('Y') . '.xlsx');
    }
    // public function admissionIdCard(Request $request)
    // {
    //     $sql = '';
    //     if ($request->class_id && $request->section_id && $request->session_id) {
    //         $sql = "SELECT * FROM students
    //         join student_activity on student_activity.student_code=students.student_code
    //         left join classes on classes.class_code=student_activity.class_code
    //         left join sections on sections.id=student_activity.section_id
    //         left join academygroups on academygroups.id=student_activity.group_id
    //         left join sessions on sessions.id=student_activity.session_id
    //         left join versions on versions.id=student_activity.version_id
    //         where student_activity.class_code=" . $request->class_id . " and student_activity.section_id=" . $request->section_id . " and student_activity.session_id=" . $request->session_id;
    //     }
    //     if ($request->class_id == 0 && $request->section_id && $request->session_id) {
    //         $sql = "SELECT * FROM students
    //         join student_activity on student_activity.student_code=students.student_code
    //         left join classes on classes.class_code=student_activity.class_code
    //         left join sections on sections.id=student_activity.section_id
    //         left join academygroups on academygroups.id=student_activity.group_id
    //         left join sessions on sessions.id=student_activity.session_id
    //         left join versions on versions.id=student_activity.version_id
    //         where student_activity.class_code=" . $request->class_id . " and student_activity.section_id=" . $request->section_id . " and student_activity.session_id=" . $request->session_id;
    //     }
    //     if ($request->text_search && $sql != '') {
    //         $sql .= " and full_name LIKE '%" . $text_search . "%' or mobile LIKE '%" . $text_search . "%' or roll_number LIKE '%" . $text_search . "%'";
    //     }
    //     if ($sql != '') {
    //         $studentdata = DB::select($sql);
    //     } else {
    //         $studentdata = [];
    //     }

    //     if (count($studentdata) == 0) {
    //         Session::put('activemenu', 'admission');
    //         Session::put('activesubmenu', 'adc');
    //         $sessions = Sessions::orderBy('id', 'desc')->get();
    //         $versions = Versions::where('active', '1')->get();


    //         return view('admission.cardfilter', compact('sessions', 'versions'));
    //     }

    //     foreach ($studentdata as $key => $student) {
    //         $studentdata[$key]->activity = StudentActivity::where('student_code', $student->student_code)
    //             ->with(['session', 'version', 'classes', 'section', 'group'])
    //             ->where('active', 1)->first();
    //         $studentdata[$key]->qrCode   = QrCode::size(100)->style('round')->generate($student->student_code . '-' . $student->first_name);
    //     }
    //     ini_set('max_execution_time', '300');
    //     ini_set("pcre.backtrack_limit", "5000000");


    //     $pdf = new \Mpdf\Mpdf([
    //         'format' => [54, 85.6],
    //         'margin_top' => 0,
    //         'margin_right' => 0,
    //         'margin_bottom' => 0,
    //         'margin_left' => 0,
    //     ]);

    //     $pdf->WriteHTML('');
    //     $no_footer = 0;
    //     // if(!$no_footer){
    //     //     $footer=view('print.pdf_footer',[]);
    //     //     $pdf->setHTMLFooter($footer,'O');
    //     //     $pdf->setHTMLFooter($footer,'E');
    //     // }


    //     $view = 'admission.cardnew';
    //     $data = compact('studentdata');

    //     $html = view($view, $data);
    //     $pdf->WriteHTML($html);
    //     return  $pdf->Output();
    //     // return view('admission.card',compact('studentdata'));
    // }

    public function admissionIdCard(Request $request)
    {
        $sql = '';
        if (!$request->class_id && !$request->section_id && $request->session_id) {
            $sql = "SELECT * FROM students
        JOIN student_activity ON student_activity.student_code = students.student_code
        WHERE student_activity.session_id = " . $request->session_id . "
        AND student_activity.active = 1
        AND students.active = 1";
        }
        if ($request->class_id && $request->section_id && $request->session_id) {
            $sql = "SELECT * FROM students
        JOIN student_activity ON student_activity.student_code = students.student_code
        WHERE student_activity.class_code = " . $request->class_id . "
        AND student_activity.section_id = " . $request->section_id . "
        AND student_activity.session_id = " . $request->session_id . "
        AND student_activity.active = 1
        AND students.active = 1";
        }
        if ($request->class_id == 0 && $request->section_id && $request->session_id) {
            $sql = "SELECT * FROM students
        JOIN student_activity ON student_activity.student_code = students.student_code
        WHERE student_activity.class_code = " . $request->class_id . "
        AND student_activity.section_id = " . $request->section_id . "
        AND student_activity.session_id = " . $request->session_id . "
        AND student_activity.active = 1
        AND students.active = 1";
        }
        if ($request->text_search && $sql != '') {
            $text_search = $request->text_search;
            $sql .= " AND (students.student_code LIKE '%" . $text_search . "%'
        OR first_name LIKE '%" . $text_search . "%'
        OR mobile LIKE '%" . $text_search . "%'
        OR roll_number LIKE '%" . $text_search . "%')";
        }
        if ($sql != '') {
            $sql .= " ORDER BY students.student_code ASC";
        }
        if ($sql != '') {
            $studentdata = DB::select($sql);
        } else {
            $studentdata = [];
        }

        if (count($studentdata) == 0) {
            Session::put('activemenu', 'admission');
            Session::put('activesubmenu', 'adc');
            $sessions = Sessions::orderBy('id', 'desc')->get();
            $versions = Versions::where('active', '1')->get();

            return view('admission.cardfilter', compact('sessions', 'versions'));
        }

        foreach ($studentdata as $key => $student) {
            $studentdata[$key]->activity = StudentActivity::where('student_code', $student->student_code)
                ->with(['session', 'version', 'classes', 'section', 'group'])
                ->where('active', 1)->first();
        }

        ini_set('max_execution_time', '300000');
        ini_set("pcre.backtrack_limit", "50000000");

        $pdf = new \Mpdf\Mpdf([
            'format' => [54, 85.6],
            'margin_top' => 0,
            'margin_right' => 0,
            'margin_bottom' => 0,
            'margin_left' => 0,
        ]);

        $pdf->WriteHTML('');

        //$view = 'admission.cardnew';
        $view = 'student.cardD';
        $data = compact('studentdata');

        $html = view($view, $data);
        $pdf->WriteHTML($html);

        return $pdf->Output();
    }

    public function sectionupdate($class_code)
    {
        $student_activity = DB::table('student_activity')
            ->where('class_code', $class_code)
            ->orderBy('id', 'desc')
            ->get();
        $student_activity_11 = DB::table('student_activity_11')
            ->where('class_code', $class_code)
            ->orderBy('id', 'desc')
            ->get();

        foreach ($student_activity as $key => $student) {

            if (isset($student_activity_11[$key]->section_id)) {
                DB::table('student_activity')->where('id', $student->id)->update(['section_id' => $student_activity_11[$key]->section_id]);
            }
        }
    }
    public function kgadmission($admission)
    {

        $max = DB::table('student_admission')
            ->where('version_id', $admission->version_id)
            ->where('shift_id', $admission->shift_id)
            ->where('payment_status', 1)
            ->max('temporary_id');
        if ($admission->version_id == 1 && $admission->shift_id == 1) {
            $number = (10000 + (int)$max + 1) - 10000;
        } else if ($admission->version_id == 1 && $admission->shift_id == 2) {
            $number = (30000 + (int)$max + 1) - 30000;
        } else if ($admission->version_id == 2 && $admission->shift_id == 1) {
            $number = (20000 + (int)$max + 1) - 20000;
        } else if ($admission->version_id == 2 && $admission->shift_id == 2) {
            $number = (40000 + (int)$max + 1) - 40000;
        }
        //dd($admission,$number);
        DB::table('student_admission')
            ->where('id', $admission->id)
            ->update(['temporary_id' => $number]);
        return $number;
    }
    public function duplicateTemporaryID()
    {
        $sql = "SELECT version_id,shift_id,temporary_id, COUNT(*) as occurrences FROM student_admission where ifnull(temporary_id,0)!=0 GROUP BY version_id,shift_id,temporary_id HAVING occurrences > 1 order by temporary_id asc";
        $temporaryids = DB::select($sql);

        $sql1 = "SELECT version_id,shift_id,temporary_id FROM `student_admission` WHERE ifnull(temporary_id,0)!=0 and ifnull(temporary_id,0)<10";
        $temporaryids1 = DB::select($sql1);
        foreach ($temporaryids as $id) {
            $data = DB::table('student_admission')
                ->where('version_id', $id->version_id)
                ->where('shift_id', $id->shift_id)
                ->where('temporary_id', $id->temporary_id)->orderBy('id', 'desc')->first();

            if ($data) {
                $this->kgadmission($data);
            }
        }

        foreach ($temporaryids1 as $id) {
            $data = DB::table('student_admission')
                ->where('version_id', $id->version_id)
                ->where('shift_id', $id->shift_id)
                ->where('temporary_id', $id->temporary_id)->orderBy('id', 'desc')->get();
            foreach ($data as $value) {
                $this->kgadmission($value);
            }
        }
        //dd($sql);
    }
    public function sendsmsDublicate()
    {
        $student_admission = array(
            array('id' => '111445'),
            array('id' => '111446'),
            array('id' => '111862'),
            array('id' => '112257'),
            array('id' => '111864'),
            array('id' => '112256'),
            array('id' => '111868'),
            array('id' => '112261'),
            array('id' => '111876'),
            array('id' => '112248'),
            array('id' => '111878'),
            array('id' => '112212'),
            array('id' => '111882'),
            array('id' => '112215'),
            array('id' => '111884'),
            array('id' => '112214'),
            array('id' => '111879'),
            array('id' => '112210'),
            array('id' => '111892'),
            array('id' => '112213'),
            array('id' => '111895'),
            array('id' => '112209'),
            array('id' => '111899'),
            array('id' => '112229'),
            array('id' => '111902'),
            array('id' => '112205'),
            array('id' => '111903'),
            array('id' => '112191'),
            array('id' => '111911'),
            array('id' => '112187'),
            array('id' => '111910'),
            array('id' => '112186'),
            array('id' => '111912'),
            array('id' => '112176'),
            array('id' => '111917'),
            array('id' => '112177'),
            array('id' => '111920'),
            array('id' => '112174'),
            array('id' => '111922'),
            array('id' => '112165'),
            array('id' => '111924'),
            array('id' => '112192'),
            array('id' => '111925'),
            array('id' => '112157'),
            array('id' => '111927'),
            array('id' => '112156'),
            array('id' => '111934'),
            array('id' => '112153'),
            array('id' => '111935'),
            array('id' => '112150'),
            array('id' => '111939'),
            array('id' => '112144'),
            array('id' => '111940'),
            array('id' => '112145'),
            array('id' => '111943'),
            array('id' => '112142'),
            array('id' => '111957'),
            array('id' => '112147'),
            array('id' => '111956'),
            array('id' => '112138'),
            array('id' => '111959'),
            array('id' => '112137'),
            array('id' => '111962'),
            array('id' => '112139'),
            array('id' => '111963'),
            array('id' => '112130'),
            array('id' => '111968'),
            array('id' => '112194'),
            array('id' => '111863'),
            array('id' => '112255'),
            array('id' => '111865'),
            array('id' => '112254'),
            array('id' => '111867'),
            array('id' => '112253'),
            array('id' => '111870'),
            array('id' => '112252'),
            array('id' => '111874'),
            array('id' => '112262'),
            array('id' => '111877'),
            array('id' => '112249'),
            array('id' => '111880'),
            array('id' => '112245'),
            array('id' => '111883'),
            array('id' => '112242'),
            array('id' => '111888'),
            array('id' => '112208'),
            array('id' => '111894'),
            array('id' => '112207'),
            array('id' => '111898'),
            array('id' => '112198'),
            array('id' => '111901'),
            array('id' => '112241'),
            array('id' => '111905'),
            array('id' => '112188'),
            array('id' => '111908'),
            array('id' => '112185'),
            array('id' => '111913'),
            array('id' => '112182'),
            array('id' => '111915'),
            array('id' => '112181'),
            array('id' => '111918'),
            array('id' => '112173'),
            array('id' => '111919'),
            array('id' => '112200'),
            array('id' => '111923'),
            array('id' => '112167'),
            array('id' => '111932'),
            array('id' => '112172'),
            array('id' => '111933'),
            array('id' => '112163'),
            array('id' => '111936'),
            array('id' => '112160'),
            array('id' => '111938'),
            array('id' => '112154'),
            array('id' => '111945'),
            array('id' => '112152'),
            array('id' => '111946'),
            array('id' => '112140'),
            array('id' => '111952'),
            array('id' => '112135'),
            array('id' => '111954'),
            array('id' => '112131'),
            array('id' => '111955'),
            array('id' => '112126'),
            array('id' => '111960'),
            array('id' => '112128'),
            array('id' => '111966'),
            array('id' => '112127'),
            array('id' => '111889'),
            array('id' => '112125'),
            array('id' => '111967'),
            array('id' => '112121'),
            array('id' => '111869'),
            array('id' => '112250'),
            array('id' => '111871'),
            array('id' => '112247'),
            array('id' => '111875'),
            array('id' => '112201'),
            array('id' => '111831'),
            array('id' => '112197'),
            array('id' => '111885'),
            array('id' => '112190'),
            array('id' => '111886'),
            array('id' => '112184'),
            array('id' => '111891'),
            array('id' => '112178'),
            array('id' => '111893'),
            array('id' => '112175'),
            array('id' => '111897'),
            array('id' => '112171'),
            array('id' => '111904'),
            array('id' => '112170'),
            array('id' => '111907'),
            array('id' => '112155'),
            array('id' => '111914'),
            array('id' => '112149'),
            array('id' => '111921'),
            array('id' => '112146'),
            array('id' => '111926'),
            array('id' => '112141'),
            array('id' => '111928'),
            array('id' => '112136'),
            array('id' => '111937'),
            array('id' => '112118'),
            array('id' => '111941'),
            array('id' => '112119'),
            array('id' => '111942'),
            array('id' => '112117'),
            array('id' => '111944'),
            array('id' => '112115'),
            array('id' => '111951'),
            array('id' => '112109'),
            array('id' => '111953'),
            array('id' => '112108'),
            array('id' => '111965'),
            array('id' => '112107'),
            array('id' => '111866'),
            array('id' => '112258'),
            array('id' => '111872'),
            array('id' => '112265'),
            array('id' => '111873'),
            array('id' => '112251'),
            array('id' => '111881'),
            array('id' => '112243'),
            array('id' => '111890'),
            array('id' => '112211'),
            array('id' => '111896'),
            array('id' => '112206'),
            array('id' => '111900'),
            array('id' => '112204'),
            array('id' => '111906'),
            array('id' => '112203'),
            array('id' => '111909'),
            array('id' => '112202'),
            array('id' => '111916'),
            array('id' => '112199'),
            array('id' => '111929'),
            array('id' => '112196'),
            array('id' => '111930'),
            array('id' => '112189'),
            array('id' => '111931'),
            array('id' => '112240'),
            array('id' => '111947'),
            array('id' => '112193'),
            array('id' => '111948'),
            array('id' => '112183'),
            array('id' => '111964'),
            array('id' => '112168'),
            array('id' => '111969'),
            array('id' => '112166')
        );

        foreach ($student_admission as $students) {
            foreach ($students as $student) {
                $studentdata = StudentAdmission::find($student);
                dd($studentdata);
                if ($studentdata) {
                    $textdata = 'Your New Temporary Number is ' . $studentdata->temporary_id . '. Please Collect Your Admit Card Link: https://bafsd.edu.bd/admissionview';
                    //  sms_send($studentdata->mobile, $textdata);
                }
            }
        }
    }
    public function kgAdmitLottery()
    {
        Session::put('activemenu', 'admission');
        Session::put('activesubmenu', 'KAL');
        $sessions = Sessions::where('active', '1')->get();
        $versions = Versions::where('active', '1')->get();
        $shifts = Shifts::where('active', '1')->get();

        $admissions = AdmissionOpen::where('class_id', 0)->where('is_lottery', 1)->get();

        $academy_info = AcademyInfo::first();

        return view('admission.lottery', compact('sessions', 'shifts', 'versions', 'admissions', 'academy_info'));
    }
    public function ajaxWinnerLottery(Request $request)
    {
        $request->validate([
            'session_id' => 'required',
            'version_id' => 'required',
            'shift_id' => 'required',
        ]);
        $admission = DB::table('student_admission')->where('session_id', $request->session_id)
            ->where('version_id', $request->version_id)
            ->where('shift_id', $request->shift_id)
            ->where('selected', 1)
            ->count();

        $lottery = DB::table('lottery_rules')->first();

        if ($lottery->random == 1) {
            $sql = "SELECT *
            FROM `student_admission`
            WHERE `temporary_id` IS NOT NULL
            and session_id=" . $request->session_id . "
            and version_id=" . $request->version_id . "
            and shift_id=" . $request->shift_id . "
            AND `payment_status` = 1
            AND `status` = 0
           # AND `category_id` = 1
            and selected!=1
            and watting!=1
            ORDER BY RAND()
            LIMIT 1";
        } elseif ($lottery->random == 2) {
            if ($admission % 2 == 0) {
                $gender = 1;
            } else {
                $gender = 2;
            }
            $sql = "SELECT *
            FROM `student_admission`
            WHERE `temporary_id` IS NOT NULL
            and session_id=" . $request->session_id . "
            and version_id=" . $request->version_id . "
            and shift_id=" . $request->shift_id . "
            AND `payment_status` = 1
            AND `status` = 0
           # AND `category_id` = 1
            AND `gender` = " . $gender . "
            and selected!=1
            and watting!=1
            ORDER BY RAND()
            LIMIT 1";
        } else {
            $cycle = $admission % 3;

            if ($cycle == 0 || $cycle == 1) {
                $gender = 1; // male
            } else {
                $gender = 2; // female
            }
            $sql = "SELECT *
            FROM `student_admission`
            WHERE `temporary_id` IS NOT NULL
            and session_id=" . $request->session_id . "
            and version_id=" . $request->version_id . "
            and shift_id=" . $request->shift_id . "
            AND `payment_status` = 1
            AND `status` = 0
           # AND `category_id` = 1
            AND `gender` = " . $gender . "
            and selected!=1
            and watting!=1
            ORDER BY RAND()
            LIMIT 1";
        }






        $result = DB::select($sql);

        $academy_info = AcademyInfo::first();

        if (count($result)) {
            DB::table('student_admission')->where('id', $result[0]->id)->update(
                [
                    'selected' => 1,
                    'watting' => $request->watting,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id
                ]
            );
            $result[0]->watting = $request->watting;
            return view('admission.ajaxWinnerLottery', compact('result', 'academy_info'));
        } else {
            return 0;
        }
    }
    public function ajaxLottery(Request $request)
    {
        if ($request->mobile) {
            $request->validate([
                'mobile' => 'required',
            ]);
        } else {
            $request->validate([
                'session_id' => 'required',
                'version_id' => 'required',
                'shift_id' => 'required',
            ]);
        }



        $sql = "SELECT *
            FROM `student_admission`
            ";
        if ($request->mobile) {

            $sql .= "WHERE temporary_id=" . $request->mobile;
            $sql .= " or mobile=" . $request->mobile;
            $sql .= " or name_en=" . $request->mobile;
            $sql .= " or birth_registration_number=" . $request->mobile;
        } else {
            $sql .= " WHERE `temporary_id` IS NOT NULL and session_id=" . $request->session_id . "
                and version_id=" . $request->version_id . "
                and shift_id=" . $request->shift_id . "
                AND `payment_status` = 1
                AND `selected` = 1
                AND `category_id` = 1";


            $sql .= " and watting=" . $request->watting;
        }

        $sql .= " order by updated_at desc
            ";

        $studentdata = DB::select($sql);
        // dd($studentdata);
        if ($request->mobile) {
            return view('admission.ajaxStudentAdmissionInfo', compact('studentdata'));
        }
        return view('admission.ajaxlotterylist', compact('studentdata'));
    }

    public function showStudentCounts(Request $request)
    {
        Session::put('activemenu', 'admission');
        Session::put('activesubmenu', 'ks');
        $sessions = Sessions::where('active', '1')->get();
        $versions = Versions::where('active', '1')->get();
        $shifts = Shifts::where('active', '1')->get();
        $session_id = $request->session_id;
        $class_code = $request->class_id;
        $version_id = $request->version_id;
        $shift_id = $request->shift_id;
        // dd(!empty($class_code));
        if ($session_id) {
            $students = DB::table('students')
                ->join('student_activity', 'students.student_code', '=', 'student_activity.student_code')
                ->join('versions', 'versions.id', '=', 'student_activity.version_id')
                ->join('shifts', 'shifts.id', '=', 'student_activity.shift_id')
                ->join('sections', 'sections.id', '=', 'student_activity.section_id')
                ->where('students.active', 1)
                ->where('student_activity.active', 1)
                ->select(
                    'student_activity.class_code',
                    'student_activity.version_id',
                    'student_activity.shift_id',
                    'student_activity.section_id',
                    'versions.version_name',
                    'shifts.shift_name',
                    'sections.section_name',
                    DB::raw('COUNT(students.id) as total'),
                    DB::raw('SUM(CASE WHEN students.gender = 1 THEN 1 ELSE 0 END) as male_count'),
                    DB::raw('SUM(CASE WHEN students.gender = 2 THEN 1 ELSE 0 END) as female_count')
                );
            if ($class_code) {

                $students = $students->where('student_activity.class_code', $class_code);
            }

            if ($class_code == '0') {

                $students = $students->where('student_activity.class_code', 0);
                // $students = $students->where('students.submit', 2);
            }
            if ($version_id) {
                $students = $students->where('student_activity.version_id', $version_id);
            }
            if ($shift_id) {
                $students = $students->where('student_activity.shift_id', $shift_id);
            }

            $students = $students->where('student_activity.session_id', $session_id);



            $students = $students->groupBy('class_code', 'version_id', 'shift_id', 'section_id', 'versions.version_name', 'shifts.shift_name', 'sections.section_name')
                ->orderBy('student_activity.class_code', 'asc')
                ->orderBy('student_activity.version_id', 'asc')
                ->orderBy('student_activity.shift_id', 'asc')
                ->orderBy('student_activity.section_id', 'asc')
                ->get();
        } else {
            $students = array();
        }
        $versiondata = collect($students)->groupBy(['version_name', 'shift_name', 'class_code']);

        return view('admission.kglist', compact('students', 'versiondata', 'sessions', 'versions', 'shifts', 'shift_id', 'version_id', 'session_id'));
    }
    public function collegeAdmission(Request $request)
    {
        Session::put('activemenu', 'admission');
        Session::put('activesubmenu', 'na');
        $activity = null;
        $session_id = null;
        $session_id = $request->session_id;
        $version_id = $request->version_id;
        $division_id = $request->division_id;
        $group_id = $request->group_id;
        $house_id = $request->house_id;
        $shift_id = $request->shift_id;
        $sessions = Sessions::all();
        $versions = Versions::where('active', '1')->get();
        $groups = DB::table('academygroups')->where('active', '1')->get();
        $houses = DB::table('houses')->where('active', '1')->get();
        $divisions = DB::table('divisions')->pluck('name', 'id');

        // Teacher activity data to find exact sessions
        if (Auth::user()->group_id == 3) {
            $employee = Employee::where('id', Auth::user()->ref_id)->first();
            $activity = EmployeeActivity::where('employee_id', $employee->id)
                ->where('is_class_teacher', 1)
                ->where(
                    'active',
                    1
                )
                ->orderBy('id', 'desc')
                ->first();
            $sessions = Sessions::where('id', $activity->session_id)->get();
        } else {
            $students = [];
        }

        $students = DB::table('students')
            ->where('students.active', 1)
            ->join('student_activity', 'students.student_code', '=', 'student_activity.student_code')
            ->join('versions', 'versions.id', '=', 'student_activity.version_id')
            ->join('shifts', 'shifts.id', '=', 'student_activity.shift_id')
            ->join('sections', 'sections.id', '=', 'student_activity.section_id')
            ->leftJoin('academygroups', 'academygroups.id', '=', 'student_activity.group_id')
            ->leftJoin('divisions', 'divisions.id', '=', 'students.division_id')
            ->select(
                'divisions.id',
                'student_activity.version_id',
                'student_activity.shift_id',
                'student_activity.section_id',
                'versions.version_name',
                'shifts.shift_name',
                'students.first_name',
                'section_name',
                'divisions.name as division_name',
                'student_activity.roll',
                'students.student_code',
                'academygroups.group_name',
                'students.mobile',
                DB::raw('CAST(students.submit AS UNSIGNED) as submit')
            )
            // ->where('student_activity.class_code', $activity->class_code)

            ->when(Auth::user()->group_id != 2, function ($query) {
                return $query->where('students.created_by', Auth::user()->id);
            })
            ->limit(300)
            ->orderBy('students.id', 'desc')
            ->get();


        return view('admission.collegeAdmission', compact('students', 'shift_id', 'session_id', 'divisions', 'houses', 'house_id', 'groups', 'sessions', 'versions', 'group_id', 'version_id', 'session_id', 'division_id'));
    }

    protected function getMiddlePart($version_id, $shift_id)
    {
        $middlePart = '';
        if ($version_id == 2) {
            $middlePart = $shift_id == 1 ? '2' : '4';
        } elseif ($version_id == 1) {
            $middlePart = $shift_id == 1 ? '1' : '3';
        }
        return $middlePart;
    }

    public function CollegeAdmisionByTeacher(Request $request)
    {

        // dd($request->all());

        $newStudentCode = 0;
        if ($request->class_code >= 11) {
            $newStudentCode = $request->student_code;
        } else {
            $classPrefix = $request->session_id - $request->class_code;

            // Determine middle part of student_code based on version and shift
            $middlePart = $this->getMiddlePart($request->version_id, $request->shift_id);

            // Find the maximum of the last 3 digits of student_code
            $maxStudentCode = DB::table('student_activity')
                ->where('session_id', $request->session_id)
                ->where('shift_id', $request->shift_id)
                ->where('version_id', $request->version_id)
                ->where('class_code', $request->class_code)
                ->selectRaw("LPAD(MAX(CAST(SUBSTRING(student_code, 6, 3) AS UNSIGNED)), 3, '0') as max_code")
                ->value('max_code');

            $nextStudentCode = str_pad($maxStudentCode + 1, 3, '0', STR_PAD_LEFT);

            // Calculate the new student_code
            $newStudentCode = $classPrefix . $middlePart  . $nextStudentCode;
        }


        if (Student::where('student_code', $newStudentCode)->exists()) {
            return redirect()->route('collegeAdmission')->withInput()
                ->with('error', 'Already exits student code!');
        }

        // if (User::where('username', $request->username)->exists()) {

        //     return redirect()->route('collegeAdmission')->withInput()
        //         ->with('error', 'Already exits User Name!');
        // }

        if ($request->class_code > 8 && !$request->group_id) {

            return redirect()->route('collegeAdmission')->withInput()
                ->with('error', 'Select your group first');
        }
        $studentdata = array(
            'student_code' => $newStudentCode,
            'first_name' => $request->first_name,
            'father_name' => $request->father_name,
            'gender' => $request->gender,
            'mobile' => $request->mobile,
            'sms_notification' => $request->mobile,
            'roll_number' => $request->roll_number,
            'division_id' => $request->division_id,
            'created_by' => Auth::user()->id,
            'active' => 1,
            'created_at' => date('Y-m-d H:i:s')
        );


        $studentactivity = array(
            'student_code' => $newStudentCode,
            'roll' => $request->student_code,
            'shift_id' => $request->shift_id,
            'session_id' => $request->session_id,
            'version_id' => $request->version_id,
            'class_id' => $request->class_code,
            'class_code' => $request->class_code,
            'house_id' => $request->house_id,
            'section_id' => $request->section_id,
            'group_id' => $request->group_id != '0' ? $request->group_id : null,
            'created_by' => Auth::user()->id,
            'active' => 1,
            'created_at' => date('Y-m-d H:i:s')
        );

        $password = $this->generateRandomNumber();
        $user = array(
            'name' => $request->first_name,
            'username' => (string) $newStudentCode,
            'phone' => $request->mobile,
            'ref_id' => $newStudentCode,
            'password' => bcrypt($password),
            'password_text' => $password,
            'group_id' => 4,
            'created_at' => date('Y-m-d H:i:s')
        );
        if ($request->id == 0) {
            if ($request->version_id && $request->mobile) {
                Student::insert($studentdata);
                StudentActivity::insert($studentactivity);
                DB::table('users')->insert($user);
                sms_send($request->mobile, 'Please login and complete your admission form. Usermame: ' . $newStudentCode . ', Password: ' . $password . '. Link: https://bafsd.edu.bd/login');
            } else {
                return redirect()->route('collegeAdmission')->withInput()
                    ->with('error', 'Please select version and group!');
            }
        } else {
            Student::where('id', $request->id)->update($studentdata);
            StudentActivity::where('student_code', $newStudentCode)
                ->where('session_id', $request->session_id)
                ->update($studentactivity);
        }


        return redirect()->route('collegeAdmission')
            ->with('success', 'Save Successfully!');
    }
}
