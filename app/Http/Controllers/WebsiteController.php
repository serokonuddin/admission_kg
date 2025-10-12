<?php

namespace App\Http\Controllers;

use App\Models\Website\Notice;
use App\Models\Employee\Employee;
use App\Models\Article;
use App\Models\Website\Page;
use App\Models\Website\Slider;
use App\Models\sttings\Sessions;
use App\Models\sttings\Shifts;
use App\Models\sttings\Versions;
use App\Models\sttings\Category;
use App\Models\sttings\Designation;
use App\Models\sttings\Subjects;
use App\Models\sttings\Classes;
use App\Models\sttings\Sections;
use App\Models\AdmissionOpen;
use App\Models\StudentAdmission;
use App\Models\ClassCategoryHeadFee;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\masterSttings\AcademyInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function sessionexpired()
    {
        return view('frontend-new.sessionexpired');
    }
    public function index()
    {
        $pagedata = Page::orderBy('serial', 'asc')->get();
        $parents = $pagedata->where('parent_id', 0);
        $pages = self::tree($parents, $pagedata);
        $categories = Category::where('active', 1)->where('type', 2)->get();
        $managements = Employee::where('active', 1)->with('designation')->whereIn('designation_id', [1, 2, 3])->orderBy('designation_id', 'asc')->get();
        $employees = Employee::where('employees.active', 1)
            ->with('designation')
            ->whereIn('designation_id', [4, 57, 58, 59, 44, 45, 53, 60, 61, 62])
            ->join('designations', 'designations.id', '=', 'employees.designation_id')
            ->orderBy('serial', 'asc')->get();

        $employees = collect($employees)->unique('employee_name');

        $sliders = Slider::where('active', 1)->orderBy('serial', 'asc')->get();
        $notices = Notice::where('publish_date', '<=', date('Y-m-d'))->where('validity_date', '>=', date('Y-m-d'))->orderBy('publish_date', 'desc')->orderBy('id', 'desc')->get();
        //return view('frontend-new.index_new',compact('managements','employees','pages','categories','notices','sliders','employees'));
        return view('frontend.index', compact('managements', 'employees', 'pages', 'categories', 'notices', 'sliders', 'employees'));
    }
    public function indexnew()
    {
        $pagedata = Page::orderBy('serial', 'asc')->where('active', 1)->get();
        $parents = $pagedata->where('parent_id', 0);
        $pages = self::tree($parents, $pagedata);
        $categories = Category::where('active', 1)->where('type', 2)->get();
        $managements = Employee::where('active', 1)->with('designation')->whereIn('designation_id', [1, 2, 3])->orderBy('designation_id', 'asc')->get();
        $employees = Employee::where('employees.active', 1)
            ->with('designation')
            ->whereIn('designation_id', [4, 57, 58, 59, 44, 45, 53, 60, 61, 62])
            ->join('designations', 'designations.id', '=', 'employees.designation_id')
            ->orderBy('serial', 'asc')->get();

        $employees = collect($employees)->unique('employee_name');

        $fromCampus = Article::where('article_type', 'From Campus')
            ->orderBy('publish_date', 'desc')
            ->take(4)
            ->get();

        $studentCorner = Article::where('article_type', 'Student Corner')
            ->orderBy('publish_date', 'desc')
            ->take(4)
            ->get();

        $totalStudents = DB::table('students as s')
            ->join('student_activity as sa', 'sa.student_code', '=', 's.student_code')
            ->where('sa.active', 1)
            ->where('s.active', 1)
            ->where('sa.class_code', '!=', 12)
            ->count();

        $sliders = Slider::where('active', 1)->orderBy('serial', 'asc')->get();
        $notices = Notice::where('publish_date', '<=', date('Y-m-d'))->where('validity_date', '>=', date('Y-m-d'))->orderBy('publish_date', 'desc')->orderBy('id', 'desc')->get();
        return view('frontend-new.index_new', compact('managements', 'employees', 'pages', 'categories', 'notices', 'sliders', 'employees', 'fromCampus', 'studentCorner', 'totalStudents'));
        // return view('frontend.index',compact('managements','employees','pages','categories','notices','sliders','employees'));
    }
    public function admission(Request $request)
    {
        //dd($request->all());
        $pagedata = array();

        $sessions = Sessions::where('active', 1)->first();
        $serial = $request->serial;
        $checkadmission = DB::table('board_list')
            ->where('session_id', $request->session_id)
            ->where('version_id', $request->version_id)
            ->where('class_id', $request->class_id)
            ->where('board', $request->board_id)
            ->where('roll_number', $request->roll_number)
            ->where('status', 1)
            ->first();
        //dd($request->all(),$checkadmission);
        $registration_number = $request->registration_number;
        if (empty($checkadmission)) {
            $text = "You Enter the wrong information. Please provide currect information.<br>আপনি ভুল তথ্য দিয়েছেন. সঠিক তথ্য প্রদান করুন.";
            return redirect()->back()->with('warning', $text);
        }
        DB::table('board_list')->where('id', $checkadmission->id)->update(['registration_number' => $registration_number]);
        $pagedata = Page::orderBy('serial', 'asc')->where('active', 1)->get();
        $parents = $pagedata->where('parent_id', 0);
        $pages = self::tree($parents, $pagedata);
        $notices = Notice::where('publish_date', '<=', date('Y-m-d'))->where('validity_date', '>=', date('Y-m-d'))->orderBy('publish_date', 'desc')->orderBy('id', 'desc')->get();
        return view('frontend-new.admission', compact('pages', 'registration_number', 'pagedata', 'notices', 'serial', 'checkadmission', 'sessions'));
    }
    public function usernamecheck(Request $request)
    {
        $user = DB::table('users')->where('username', $request->username)->first();
        if ($user) {
            return 1;
        } else {
            return 0;
        }
    }
    public function sslredirect()
    {

        $pagedata = array();

        $sessions = Sessions::where('active', 1)->first();

        $parentall = Page::where('active', 1)->orderBy('serial', 'asc')->get();
        $parents = $parentall->where('parent_id', 0);
        $pages = self::tree($parents, $parentall);
        $notices = Notice::where('publish_date', '<=', date('Y-m-d'))->where('validity_date', '>=', date('Y-m-d'))->orderBy('publish_date', 'desc')->orderBy('id', 'desc')->get();
        return view('frontend-new.sslredirect', compact('pages', 'pagedata', 'notices', 'sessions'));
    }
    public function payment(Request $request)
    {

        //dd($request->all());
        $checkadmission = DB::table('board_list')
            ->where('session_id', $request->session_id)
            ->where('version_id', $request->version_id)
            ->where('class_id', $request->class_id)
            ->where('board', $request->board_id)
            ->where('roll_number', $request->roll_number)
            ->first();

        if (empty($checkadmission)) {
            $text = "You Enter the wrong information. Please provide currect information.<br>আপনি ভুল তথ্য দিয়েছেন. সঠিক তথ্য প্রদান করুন.";
            return redirect()->back()->with('warning', $text);
        }
        $sessions = Sessions::where('active', 1)->first();
        $class = Classes::where('active', 1)->where('class_code', 11)->where('class_for', 3)->first();

        $payment = ClassCategoryHeadFee::where('class_category_wise_head_fee.session_id', $request->session_id)
            ->join('classes', 'classes.id', '=', 'class_category_wise_head_fee.class_id')
            ->where('class_category_wise_head_fee.class_code', 11)
            ->where('class_category_wise_head_fee.fee_for', 1)
            ->where('class_category_wise_head_fee.version_id', $request->version_id)
            ->first();

        if (empty($payment)) {
            $text = "Payment does not added for admission";
            return redirect('/admissionview')->with('warning', $text);
        }

        if ($request->group_name == 'Science') {
            $group_id = 1;
        } elseif ($request->group_name == 'Humanities') {
            $group_id = 2;
        } else {
            $group_id = 3;
        }

        $admission = array(

            'session_id' => $request->session_id,
            'version_id' => $request->version_id,
            'student_code' => $checkadmission->student_code,
            'lang' => $request->version_id,
            'class_id' => $request->class_id,
            'full_name' => $request->full_name,
            'registration_number' => null,
            'roll_number' => $request->roll_number,
            'group_name' => $request->group_name,
            'group_id' => $group_id,
            'quota' => $checkadmission->quota,
            'board' => $request->board_id,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'serial' => $request->serial,
            'lang' => 1,
        );
        //dd($admission);
        $admission_id = DB::table('admission_temporary')->insertGetId($admission);

        $tranjection = array(
            'student_code' => $checkadmission->student_code,
            'admission_id' => $admission_id,
            'common_id' => $payment->id,
            'fee_for' => 1,
            'session_id' => $sessions->id,
            'version_id' => 1,
            'shift_id' => 1,
            'payment_date' => date('Y-m-d'),
            'category_id' => $payment->category_id,
            'class_id' => $class->id,
            'class_code' => 11,
            'amount' => $payment->amount
        );
        $tran_id = DB::table('student_fee_tranjection')->insertGetId($tranjection);
        $post_data = array();
        $post_data['total_amount'] = $payment->amount; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = $tran_id; // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $request->full_name;
        $post_data['cus_email'] = $request->email;
        $post_data['cus_add1'] = $request->board;;
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '88' . $request->phone;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "testshahe68ix";
        $post_data['ship_add1'] = "Dhaka Cantonment, Police Station: Kafarul";
        $post_data['ship_add2'] = "Dhaka Cantonment, Police Station: Kafarul";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1206";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Admission";
        $post_data['product_category'] = "Admission";
        $post_data['product_profile'] = "Admission";



        #Before  going to initiate the payment order status need to insert or update as Pending.
        // $update_product = DB::table('orders')
        //     ->where('transaction_id', $post_data['tran_id'])
        //     ->updateOrInsert([
        //         'name' => $post_data['cus_name'],
        //         'email' => $post_data['cus_email'],
        //         'phone' => $post_data['cus_phone'],
        //         'amount' => $post_data['total_amount'],
        //         'status' => 'Pending',
        //         'address' => $post_data['cus_add1'],
        //         'transaction_id' => $post_data['tran_id'],
        //         'currency' => $post_data['currency']
        //     ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }
    function housenumber($param)
    {

        return (($param - 1) % 4) + 1;
    }
    public function autoSection($count, $session_id, $class_code, $version_id, $shift_id, $gender)
    {
        Session::put('activemenu', 'exam');
        Session::put('activesubmenu', 'as');
        $count = DB::table('student_activity')
            ->join('students', 'students.student_code', '=', 'student_activity.student_code')
            ->where('session_id', $session_id)
            ->where('version_id', $version_id)
            ->where('shift_id', $shift_id)
            ->where('gender', $gender)
            ->where('class_code', 0)
            ->count();


        $sections = Sections::where('class_code', $class_code)
            ->where('version_id', $version_id)
            ->where('shift_id', $shift_id)
            ->where('active', 1)
            ->orderBy('id')
            ->pluck('id')
            ->toArray();

        //  dd($sections);

        $sectioncount = count($sections);


        return $sections[$count % $sectioncount];
    }
    public function KgStudentCreate($id)
    {
        $student = DB::table('student_admission')
            ->where('id', $id)
            ->first();

        if ($student) {
            $session_id = (int)$student->session_id + 1;
            $count = DB::table('student_activity')
                ->where('session_id', $session_id)
                ->where('version_id', $student->version_id)
                ->where('shift_id', $student->shift_id)
                ->where('class_code', 0)
                ->count();

            if ($student->shift_id == 1 && $student->version_id == 1) {
                $middel = 1000;
            } else if ($student->shift_id == 2 && $student->version_id == 1) {
                $middel = 3000;
            } else if ($student->shift_id == 1 && $student->version_id == 2) {
                $middel = 2000;
            } else if ($student->shift_id == 2 && $student->version_id == 2) {
                $middel = 4000;
            }
            $serial = $middel + $count + 1;
            $student_code = $session_id . '' . ($serial);
            $section = $this->autoSection($count, $session_id, 0, $student->version_id, $student->shift_id, $student->gender);
            //dd($section);
            $studentdata = array(
                'student_code' => $student_code,
                'first_name' => $student->name_en,
                'bangla_name' => $student->name_bn,
                'email' => $student->email,
                'mobile' => $student->phone,
                'gender' => $student->gender,
                'birthdate' => $student->dob,
                'local_guardian_name' => $student->gurdian_name,
                'local_guardian_mobile' => $student->phone,
                'sms_notification' => $student->phone,
                'photo' => $student->photo,
                'birth_certificate' => $student->birth_image,
                'birth_no' => $student->birth_registration_number,
                'service_number' => $student->service_name,
                'name' => $student->service_holder_name,
                'arms_name' => $student->name_of_service ?? $student->service_name,
                'is_service' => $student->in_service,
                'office_address' => $student->office_address,
                'name_of_staff' => $student->name_of_staff,
                'staff_designation' => $student->staff_designation,
                'staff_id' => $student->staff_id,
                'staff_certification' => $student->staff_certification,
                'arm_certification' => $student->arm_certification,
                'categoryid' => $student->category_id,
                'passing_year' => date('Y'),
                'category_id' => $student->category_id,
                'active' => 1,
            );

            $studentid = DB::table('students')->insertGetId($studentdata);
            DB::table('student_admission')->where('id', $id)->update(['student_code' => $student_code, 'status' => 2]);
            $student_activity = array(
                'student_code' => $student_code,
                'session_id' => $session_id,
                'class_id' => $student->class_id,
                'class_code' => $student->class_id,
                'version_id' => $student->version_id,
                'shift_id' => $student->shift_id,
                'section_id' => $section,
                'group_id' => null,
                'roll' => $student_code,
                'house_id' => $this->housenumber($serial),
                'category_id' => $student->category_id,
                'active' => 1,
                'created_by' => 1,
            );
            DB::table('student_activity')->insertGetId($student_activity);
            $password = $this->generateRandomNumber();
            $user = array(
                'name' => $student->name_en,
                'email' => $student->email,
                'username' => $student->username,
                'phone' => $student->phone,
                'ref_id' => $student_code,
                'password_text' => $password,
                'password' => bcrypt($password),
                'group_id' => 4,
            );
            DB::table('users')->insert($user);

            DB::table('student_admission')
                ->where('id', $student->id)
                ->update(['status' => 3]);


            sms_send($student->phone, 'Your Username is ' . $student->username . ' and Password is ' . $password . '. Please login to following link to complete the admission form. Link: '.env('APP_URL').'/login');
            $text = "KG Admission payment for BAF Shaheen college Dhaka is completed. Please login and enter your admission form.";
            return 1; ///return redirect()->route('sslredirect')->with('warging', $text);
        }
    }
    function generateRandomNumber()
    {
        // Generates a 6-digit random number
        return rand(100000, 999999);
    }
    public function admissionDatakg(Request $request)
    {

        $sessions = Sessions::where('id', date('Y'))->first();
        $class = Classes::where('active', 1)->where('class_code', 0)->first();

        // $payment=AdmissionOpen::with(['class','version','session']);
        // $payment=$payment->where('class_id',0)->where('start_date','<=',date('Y-m-d'))->where('end_date','>=',date('Y-m-d'))
        // ->where('session_id',$request->session_id)
        // ->where('version_id',$request->version_id)
        // ->where('class_id',0)
        // ->first();


        // if(empty($payment)){
        //     $text="Payment does not added for admission";
        //     return redirect('/')->with('warning',$text);
        // }

        //    if($request->group_name=='Science'){
        //     $group_id=1;
        //    }elseif($request->group_name=='Humanities'){
        //     $group_id=2;
        //    }else{
        //     $group_id=3;
        //    }
        //dd($request->all());

        $student = DB::table('student_admission')
            ->where('session_id', ((int)$request->session_id - 1))
            ->where('version_id', $request->version_id)
            ->where('shift_id', $request->shift_id)
            ->where('temporary_id', $request->temporary_id)
            ->where('status', 1)
            ->where('class_id', 0)
            ->first();

        if (empty($student)) {
            $text = "Student Information Mismatch";
            return redirect('/')->with('warning', $text);
        }
        $userdata = DB::table('users')
            ->where('username', $request->username)
            ->select('*')->first();

        if ($userdata) {
            $text = "Username Already Added.";
            return redirect('admissionviewkg')->with('warning', $text);
        }

        $userdata = array(
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->mobile
        );

        DB::table('student_admission')->where('id', $student->id)->update($userdata);

        //    if($request->group_name=='Science'){
        //     $group_id=1;
        //    }elseif($request->group_name=='Humanities'){
        //     $group_id=2;
        //    }else{
        //     $group_id=3;
        //    }
        //dd($request->all());

        // if($request->submit=='Bypass Payemnt'){

        $this->KgStudentCreate($student->id);
        $text = "Payment Successfully Paid";
        return redirect()->route('sslredirect')->with('warging', $text);
        // }
        // dd($request->submit);
        //     $tranjection=array(
        //         'student_code'=>$request->temporary_id,
        //         'admission_id'=>$request->temporary_id,
        //         'common_id'=>$request->temporary_id,
        //         'fee_for'=>1,
        //         'session_id'=>2025,
        //         'version_id'=>$request->version_id,
        //         'shift_id'=>$request->shift_id,
        //         'payment_date'=>date('Y-m-d'),
        //         'category_id'=>3,
        //         'class_id'=>0,
        // 		'class_code'=>0,
        //         'amount'=>$payment->price
        //     );
        //     $tran_id=DB::table('student_fee_tranjection')->insertGetId($tranjection);
        //     $post_data = array();
        //     $post_data['total_amount'] = $payment->price; # You cant not pay less than 10
        //     $post_data['currency'] = "BDT";
        //     $post_data['tran_id'] = $tran_id; // tran_id must be unique

        //     # CUSTOMER INFORMATION
        //     $post_data['cus_name'] = $request->name_en;
        //     $post_data['cus_email'] = $request->email;
        //     $post_data['cus_add1'] = 'Dhaka';
        //     $post_data['cus_add2'] = "";
        //     $post_data['cus_city'] = "";
        //     $post_data['cus_state'] = "";
        //     $post_data['cus_postcode'] = "";
        //     $post_data['cus_country'] = "Bangladesh";
        //     $post_data['cus_phone'] = '88'.$request->mobile;
        //     $post_data['cus_fax'] = "";

        //     # SHIPMENT INFORMATION
        //     $post_data['ship_name'] = "testshahe68ix";
        //     $post_data['ship_add1'] = "Dhaka Cantonment, Police Station: Kafarul";
        //     $post_data['ship_add2'] = "Dhaka Cantonment, Police Station: Kafarul";
        //     $post_data['ship_city'] = "Dhaka";
        //     $post_data['ship_state'] = "Dhaka";
        //     $post_data['ship_postcode'] = "1206";
        //     $post_data['ship_phone'] = "";
        //     $post_data['ship_country'] = "Bangladesh";

        //     $post_data['shipping_method'] = "NO";
        //     $post_data['product_name'] = "Admission";
        //     $post_data['product_category'] = "Admission";
        //     $post_data['product_profile'] = "Admission";



        //     #Before  going to initiate the payment order status need to insert or update as Pending.
        //     // $update_product = DB::table('orders')
        //     //     ->where('transaction_id', $post_data['tran_id'])
        //     //     ->updateOrInsert([
        //     //         'name' => $post_data['cus_name'],
        //     //         'email' => $post_data['cus_email'],
        //     //         'phone' => $post_data['cus_phone'],
        //     //         'amount' => $post_data['total_amount'],
        //     //         'status' => 'Pending',
        //     //         'address' => $post_data['cus_add1'],
        //     //         'transaction_id' => $post_data['tran_id'],
        //     //         'currency' => $post_data['currency']
        //     //     ]);

        //     $sslc = new SslCommerzNotification();
        //     # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        //     $payment_options = $sslc->makePayment($post_data, 'hosted');

        //     if (!is_array($payment_options)) {
        //         print_r($payment_options);
        //         $payment_options = array();
        //     }
    }
    public function clubs()
    {
        $pagedata = Page::where('slug', 'club-activities')->orderBy('serial', 'asc')->first();
        $pagedata->title = "Club Activities";
        $parent = Page::orderBy('serial', 'asc')->where('id', $pagedata->parent_id)->first();
        $subpages = Page::select('slug', 'title')->whereRaw('ifnull(parent_id,0)!=0')->where('slug', '!=', '#')->where('parent_id', $pagedata->parent_id)->orderBy('serial', 'asc')->get();
        $parentall = Page::where('active', 1)->orderBy('serial', 'asc')->get();
        $parents = $parentall->where('parent_id', 0);
        $pages = self::tree($parents, $parentall);
        $notices = Notice::where('publish_date', '<=', date('Y-m-d'))->where('validity_date', '>=', date('Y-m-d'))->orderBy('publish_date', 'desc')->orderBy('id', 'desc')->get();
        return view('frontend-new.clubs', compact('pages', 'pagedata', 'notices', 'subpages', 'parent'));
    }
    public function page(Request $request, $slug)
    {

        $pagedata = Page::orderBy('serial', 'asc')->where('slug', $slug)->first();
        $parent = Page::orderBy('serial', 'asc')->where('active', 1)->where('id', $pagedata->parent_id)->first();
        $subpages = Page::select('slug', 'title')->whereRaw('ifnull(parent_id,0)!=0')->where('slug', '!=', '#')->where('parent_id', $pagedata->parent_id)->orderBy('serial', 'asc')->get();
        $parentall = Page::orderBy('serial', 'asc')->where('active', 1)->get();
        $parents = $parentall->where('parent_id', 0);
        $pages = self::tree($parents, $parentall);
        $notices = Notice::where('publish_date', '<=', date('Y-m-d'))->where('validity_date', '>=', date('Y-m-d'))->orderBy('publish_date', 'desc')->orderBy('id', 'desc')->get();
        if ($slug == 'college-teachers' || $slug == 'administrative-staffs' || $slug == 'school-teachers-(primary)' || $slug == 'school-teachers-(secondary)' || $slug == 'school-teachers-(english-version)') {
            $category_id = 7;
            if ($slug == 'administrative-staffs') {
                $category_id = 8;
            }
            $employee_for = '';
            if ($slug == 'college-teachers') {
                $employee_for = 3;
            } elseif ($slug == 'school-teachers-(primary)') {
                $employee_for = 1;
            } elseif ($slug == 'school-teachers-(english-version)') {
                $employee_for = 4;
            } else {
                $employee_for = 2;
            }
            //dd($employee_for);
            $sessions = Sessions::where('active', 1)->get();
            $versions = Versions::where('active', 1)->get();
            $shifts = Shifts::where('active', 1)->get();
            $classes = Classes::where('active', 1)
                ->where('session_id', $request->session_id)
                ->where('shift_id', $request->shift_id)
                ->where('version_id', $request->version_id)
                ->get();
            $sections = Sections::where('active', 1)
                ->where('class_id', (int)$request->class_id)
                ->get();
            $subjects = Subjects::where('active', 1)
                ->get();

            $designations = Designation::where('active', 1)->orderBy('designation_name', 'asc')->get();

            $version_id = $request->version_id;
            $session_id = $request->session_id;
            $shift_id = $request->shift_id;
            $class_id = $request->class_id;
            $section_id = $request->section_id;
            $subject_id = $request->subject_id;
            $designation_id = $request->designation_id;
            $job_type = $request->job_type;



            $employees = Employee::where('active', 1)
                ->with([
                    'employeeActivity.session',
                    'employeeActivity.version',
                    'employeeActivity.shift',
                    'employeeActivity.classes',
                    'employeeActivity.group',
                    'employeeActivity.section',
                    'designation',
                    'subject',
                    'versionemployee'

                ]);
            if ($session_id || $version_id) {
                $employees = $employees->whereIn('id', function ($row) use ($session_id, $version_id, $shift_id, $class_id, $section_id, $subject_id) {
                    $row->select('id')
                        ->from('employee_activity');
                    // if($session_id){

                    //     $row->whereRaw('session_id = "'.$session_id.'"');
                    // }
                    // if($version_id){
                    //     $row->whereRaw('version_id = "'.$version_id.'"');
                    // }
                    // if($shift_id){
                    //     $row->whereRaw('shift_id = "'.$shift_id.'"');
                    // }
                    // if($class_id){
                    //     $row->whereRaw('class_id = "'.$class_id.'"');
                    // }
                    // if($section_id){
                    //     $row->whereRaw('section_id = "'.$section_id.'"');
                    // }


                });
            }
            if (in_array($employee_for, [1, 2, 3]) && $category_id != 8) {
                $employees = $employees->where('employee_for', $employee_for);
            }
            if ($employee_for == 4  && $category_id != 8) {
                $employees = $employees->where('version_id', 2);
            }

            $employees = $employees->where('category_id', $category_id);
            if ($designation_id) {
                $employees = $employees->where('designation_id', $designation_id);
            }
            if ($job_type) {
                $employees = $employees->where('job_type', $job_type);
            }
            if ($subject_id) {

                $employees = $employees->where('subject_id', 'LIKE', "%{$subject_id}%");
            }
            if ($employee_for == 3) {
                $employees = $employees->whereIn('designation_id', [14, 15, 16])->orderBy('designation_id', 'asc');
            } elseif (($employee_for == 2 || $employee_for == 1) && $category_id != 8) {
                $employees = $employees->whereIn('designation_id', [17, 18, 49])->orderBy('designation_id', 'asc');
            } else {
                $employees = $employees->whereNotIn('designation_id', [1, 2, 3]);
            }

            $employees = $employees->paginate(40);


            return view('frontend-new.teacher', compact(
                'pages',
                'pagedata',
                'notices',
                'version_id',
                'session_id',
                'shift_id',
                'class_id',
                'section_id',
                'subject_id',
                'designation_id',
                'designations',
                'subjects',
                'sections',
                'classes',
                'shifts',
                'versions',
                'sessions',
                'category_id',
                'slug',
                'employees'
            ));
        }
        if ($slug == 'academic-calendar') {
            $data = $this->getCalender(date('Y'));

            return view('frontend-new.calender', compact('pages', 'pagedata', 'parent', 'notices', 'data'));
        }
        if ($slug == 'contact') {
            $data = $this->getCalender(date('Y'));

            return view('frontend-new.contact', compact('pages', 'pagedata', 'notices', 'data'));
        }
        $slug = preg_replace('/[^a-zA-Z0-9_-]/', '', $slug);

        if ($slug == 'students-notice' || $slug == 'teachers-notices' || $slug == 'office-orders' || $slug == 'recruitment-notices' || $slug == 'tender-notices') {

            if ($slug == 'students-notice') {
                $type = 1;
            } elseif ($slug == 'teachers-notices') {
                $type = 2;
            } elseif ($slug == 'office-orders') {
                $type = 3;
            } elseif ($slug == 'tender-notices') {
                $type = 4;
            } elseif ($slug == 'recruitment-notices') {
                $type = 5;
            } elseif ($slug == 'students-downloads') {
                $type = 6;
            }
            $thirtyDaysAgo = Carbon::now()->subDays(30);
            $notices = DB::table('notices')->where('type_id', $type)->where('publish_date', '>=', $thirtyDaysAgo)->orderBy('publish_date', 'desc')->orderBy('id', 'desc')->get();
            return view('frontend-new.notice', compact('pages', 'pagedata', 'notices', 'subpages', 'parent'));
        }
        if ($slug == 'photo-gallery' || $slug == 'video-gallery') {
            $type = ($slug == 'photo-gallery') ? 1 : 2;
            $galleries = DB::table('galleries')
                ->where('active', 1)
                ->where('type_id', $type)
                ->get();
            return view('frontend-new.gallery', compact('pages', 'pagedata', 'galleries', 'notices'));
        }
        return view('frontend-new.common', compact('pages', 'pagedata', 'notices', 'subpages', 'parent'));
    }
    public function gallarydetails($id)
    {

        $parentall = Page::orderBy('serial', 'asc')->get();
        $parents = $parentall->where('parent_id', 0);
        $pages = self::tree($parents, $parentall);
        $notices = Notice::where('publish_date', '<=', date('Y-m-d'))->where('validity_date', '>=', date('Y-m-d'))->orderBy('publish_date', 'desc')->orderBy('id', 'desc')->get();
        $gallery = DB::table('galleries')
            ->where('active', 1)
            ->where('id', $id)
            ->first();
        return view('frontend-new.gallerydetails', compact('pages', 'gallery', 'notices'));
    }
    public function tree($items, $all_items)
    {
        $data_arr = array();
        foreach ($items as $i => $item) {
            $data_arr[$i] = $item->toArray(); //all column attributes
            $find = $all_items->where('parent_id', $item->id);
            //$data_arr[$i]['tree'] = array(); empty array or remove if you dont need it
            if ($find->count()) {
                $data_arr[$i]['tree'] = self::tree($find, $all_items);
            }
        }

        return $data_arr;
    }
    public function monthf($index, $year)
    {
        $month[1] = "Jan";
        $month[2] = "Feb";
        $month[3] = "Mar";
        $month[4] = "Apr";
        $month[5] = "May";
        $month[6] = "Jun";
        $month[7] = "Jul";
        $month[8] = "Aug";
        $month[9] = "Sep";
        $month[10] = "Oct";
        $month[11] = "Nov";
        $month[12] = "Dec";
        return $month[12] . '-' . substr((string)$year, -2);
    }
    public function getAcademicData($start_date, $end_date)
    {
        return DB::select("select number_of_days,title,title_bn,short_title,short_title_bn,start_date,end_date,startvalue from (SELECT *, 1 startvalue FROM `year_calendars` WHERE `start_date` BETWEEN '$start_date' AND '$end_date' UNION ALL SELECT *, 0 startvalue FROM `year_calendars` WHERE `end_date` BETWEEN '$start_date' AND '$end_date' ) t group by number_of_days,title,title_bn,short_title,short_title_bn,start_date,end_date,startvalue order by start_date asc");
    }
    public function getKGX($data, $year, $month, $day)
    {
        if ($month < 10) {
            if ($day < 10) {
                $query_date = $year . '-0' . $month . '-0' . $day;
            } else {
                $query_date = $year . '-0' . $month . '-' . $day;
            }
        } else {
            if ($day < 10) {
                $query_date = $year . '-' . $month . '-0' . $day;
            } else {
                $query_date = $year . '-' . $month . '-' . $day;
            }
        }

        $dayvalue = date('Y-m-d', strtotime($query_date));
        // if($month==9 && $day==8){
        //     dd($data);


        // }



        foreach ($data as $value) {
            if ($value->start_date <= $dayvalue && $value->end_date >= $dayvalue) {

                if ($value->total_day == 0) {
                    return '1-' . $value->total_day . '-' . (($value->number_of_days > 0) ? 1 : 0) . '-' . $value->short_title;
                } else {
                    return '1-' . $value->total_day . '-' . (($value->number_of_days > 0) ? 1 : 0) . '-' . $value->short_title;
                }
            } elseif ($value->start_date == $dayvalue) {
                return '1-1-1-' . $value->short_title;
            }
        }
        if (date('D', strtotime($dayvalue)) == "Fri" || date('D', strtotime($dayvalue)) == "Sat") {
            return '2-1';
        }
        return '0-1';
    }
    public function getCalender($year)
    {
        $days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        $sessions = DB::table('sessions')->where('session_name', $year)->first();
        $result = array();
        $workingday = 0;
        for ($k = 1; $k <= 12; $k++) {
            $j = 0;
            $t = 1;
            $month = $this->monthf($k, $year);
            $data['days'] = [];
            $data['date'] = [];
            $data['KG-X'] = [];
            if ($k < 10) {
                $month_text = "0" . $k;
            } else {
                $month_text = $k;
            }
            $query_date = $year . '-' . $month_text . '-01';

            // First day of the month.
            $first_day = date('Y-m-01', strtotime($query_date));

            // Last day of the month.
            $last_day = date('Y-m-t', strtotime($query_date));
            $AcademicData = $this->getAcademicData($first_day, $last_day);

            $AcademicData =   collect($AcademicData)->unique('title');

            foreach ($AcademicData as $key => $academic) {
                if ($academic->startvalue == 1) {
                    if (empty($academic->end_date)) {
                        $interval = 1;
                    } elseif (strtotime($academic->end_date) < strtotime($last_day)) {
                        $datediff = strtotime($academic->end_date) - strtotime($academic->start_date);
                        $interval = round($datediff / (60 * 60 * 24)) + 1;
                    } else {
                        $datediff = strtotime($last_day) - strtotime($academic->start_date);
                        $interval = round($datediff / (60 * 60 * 24)) + 1;
                    }
                } else {
                    $datediff = strtotime($academic->end_date) - strtotime($first_day);
                    $interval = round($datediff / (60 * 60 * 24)) + 1;
                }
                $AcademicData[$key]->total_day = (int)$interval;
            }


            $first_day = date('D', strtotime($first_day)); // hard-coded '01' for first day
            // //$last_day_number  = date($k.'-t-'.$year);
            $lastday  = date('d', strtotime($last_day));
            $last_day  = date('D', strtotime($last_day));


            // dd($last_day);
            for ($i = 1; $i <= 5; $i++) {
                if ($i == 1) {
                    $firstindex = 0;
                    $firstindex = array_search($first_day, $days);
                    // if($k==3){
                    //     dd($firstindex);
                    // }
                    for ($v = 0; $v < 7; $v++) {

                        if ($v >= $firstindex) {
                            $kgxdata = $this->getKGX($AcademicData, $year, $k, $t);
                            $checkvalue = explode('-', $kgxdata);

                            if ((int)$checkvalue[0] == 0) {
                                $data['KG-X'][$j] = '0-' . ++$workingday;
                            } else {
                                $data['KG-X'][$j] = $kgxdata;
                            }
                            $data['date'][$j] = $t++;
                            $data['days'][$j++] = $days[$v];
                        } else {
                            $data['date'][$j] = '';
                            $data['KG-X'][$j] = '';
                            $data['days'][$j++] = $days[$v];
                        }
                    }
                } else {

                    for ($v = 0; $v < 7; $v++) {

                        if ($i == 5) {
                            $lastindex = array_search($last_day, $days);
                            if ($v <= $lastindex) {
                                $kgxdata = $this->getKGX($AcademicData, $year, $k, $t);
                                $checkvalue = explode('-', $kgxdata);

                                if ((int)$checkvalue[0] == 0) {
                                    $data['KG-X'][$j] = '0-' . ++$workingday;
                                } else {
                                    $data['KG-X'][$j] = $kgxdata;
                                }
                                $data['date'][$j] = $t++;
                                $data['days'][$j++] = $days[$v];
                            } elseif ($v > $lastindex && $lastindex == 0) {

                                $kgxdata = $this->getKGX($AcademicData, $year, $k, $t);
                                $checkvalue = explode('-', $kgxdata);

                                if ((int)$checkvalue[0] == 0) {
                                    $data['KG-X'][$j] = '0-' . ++$workingday;
                                } else {
                                    $data['KG-X'][$j] = $kgxdata;
                                }
                                $data['date'][$j] = $t++;
                                $data['days'][$j++] = $days[$v];
                            } else {
                                $data['KG-X'][$j] = '';
                                $data['date'][$j] = '';
                                $data['days'][$j++] = $days[$v];
                            }
                            if ($v == 6 && (int)$lastday == 30 && $lastindex == 0) {

                                $kgxdata = $this->getKGX($AcademicData, $year, $k, $t);
                                $checkvalue = explode('-', $kgxdata);

                                if ((int)$checkvalue[0] == 0) {
                                    $data['KG-X'][0] = '0-' . ++$workingday;
                                } else {
                                    $data['KG-X'][0] = $kgxdata;
                                }
                                $data['date'][0] = $t++;
                                $data['days'][0] = $days[0];
                            }
                            if ($v == 6 && (int)$lastday == 31 && $lastindex == 0) {

                                $kgxdata = $this->getKGX($AcademicData, $year, $k, $t);
                                $checkvalue = explode('-', $kgxdata);

                                if ((int)$checkvalue[0] == 0) {
                                    $data['KG-X'][0] = '0-' . ++$workingday;
                                } else {
                                    $data['KG-X'][0] = $kgxdata;
                                }
                                $data['date'][0] = $t++;
                                $data['days'][0] = $days[0];
                            }
                        } else {

                            $kgxdata = $this->getKGX($AcademicData, $year, $k, $t);
                            $checkvalue = explode('-', $kgxdata);

                            if ((int)$checkvalue[0] == 0) {
                                $data['KG-X'][$j] = '0-' . ++$workingday;
                            } else {
                                $data['KG-X'][$j] = $kgxdata;
                            }
                            $data['date'][$j] = $t++;
                            $data['days'][$j++] = $days[$v];
                        }
                    }
                }
            }

            $result[$k] = $data;
        }
        // dd($result);
        return $result;
    }
    /**
     * Show the form for creating a new resource.
     */
    public function detiales($id)
    {
        $parentall = Page::orderBy('serial', 'asc')->where('active', 1)->get();
        $parents = $parentall->where('parent_id', 0);
        $pages = self::tree($parents, $parentall);
        $notices = Notice::where('publish_date', '<=', date('Y-m-d'))->where('validity_date', '>=', date('Y-m-d'))->orderBy('publish_date', 'desc')->orderBy('id', 'desc')->get();
        $pagedata = DB::table('notices')->where('id', $id)->first();

        return view('frontend-new.detailsnotice', compact('pages', 'pagedata', 'notices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function checkadmissionstatus(Request $request)
    {
        return 3425456;
    }
    public function admissionPrint($number, $is_save)
    {
        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4', // Set page size to A4
            'orientation' => 'P' // 'P' for Portrait, 'L' for Landscape
        ]);
        $academy_info = AcademyInfo::first();
        // Remove the base URL (domain)
        $logoRelativePath = str_replace(url('/'), '', $academy_info->logo);

        // Convert to local file path
        $logoPath = public_path($logoRelativePath);

        // Set watermark
        $mpdf->SetWatermarkImage($logoPath, 0.1, [75, 65]);
        $mpdf->showWatermarkImage = true;

        // Image path, opacity, and size
        $mpdf->showWatermarkImage = true;
        // $mpdf->SetHTMLHeader('
        //         <div style="text-align: right;z-index: 999;margin-right: 80px;">
        //             <br/>
        //             <br/>
        //             <br/>

        //             <img src="' . asset('public/seal.png') . '" style="max-height: 60px;">
        //         </div>
        //     ');
        $session = DB::table('sessions')->where('active', 1)->first();
        $student = StudentAdmission::where('session_id', $session->id)->where('temporary_id', $number)->where('payment_status', 1)->first();
        //return view('frontend-new.admitcard',compact('student','session'));
        $mpdf->WriteHTML(view('frontend-new.admitcard', compact('student', 'session', 'logoRelativePath', 'academy_info'))->render());

        // Output the PDF to the browser
        if ($is_save == 1) {
            $mpdf->Output($student->name_en . '.pdf', 'D');
        } else {
            $mpdf->Output($student->name_en . '.pdf', 'I');
        }
    }
    public function admissionsearch(Request $request)
    {
        $parentall = Page::orderBy('serial', 'asc')->where('active', 1)->get();
        $parents = $parentall->where('parent_id', 0);
        $pages = self::tree($parents, $parentall);
        $session = DB::table('sessions')->where('active', 1)->first();
        $student = StudentAdmission::where('session_id', $session->id)->where('temporary_id', $request->temporary_id)->where('payment_status', 1)->first();
        $academy_info = AcademyInfo::first();
        return view('frontend-new.admit-card', compact('student', 'session', 'parentall', 'parents', 'pages', 'academy_info'));
    }
    public function admissionSearchByNumber($number)
    {
        $parentall = Page::orderBy('serial', 'asc')->where('active', 1)->get();
        $parents = $parentall->where('parent_id', 0);
        $pages = self::tree($parents, $parentall);
        $session = DB::table('sessions')->where('active', 1)->first();
        $student = StudentAdmission::where('session_id', $session->id)->where('temporary_id', $number)->where('payment_status', 1)->first();
        $academy_info = AcademyInfo::first();
        return view('frontend-new.admit-card', compact('student', 'session', 'parentall', 'parents', 'pages', 'academy_info'));
    }
    public function admissionviewkgadmission(Request $request)
    {
        $parentall = Page::orderBy('serial', 'asc')->where('active', 1)->get();
        $parents = $parentall->where('parent_id', 0);
        $pages = self::tree($parents, $parentall);
        $notices = Notice::where('publish_date', '<=', date('Y-m-d'))->where('validity_date', '>=', date('Y-m-d'))->orderBy('publish_date', 'desc')->orderBy('id', 'desc')->get();
        $session = DB::table('sessions')->where('active', 1)->first();
        $admissiondata = AdmissionOpen::with(['class', 'version', 'session']);
        if (isset($request->test)) {
            $admissiondata = $admissiondata->where('class_id', 11)->where('session_id', $session->id)->get();
        } else {
            $admissiondata = $admissiondata->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))
                ->where('session_id', $session->id)->where('class_id', 11)->get();
        }


        foreach ($admissiondata as $key => $admission) {
            $fee = getClassWiseAdmissionFee($admission->class->class_code, $admission->version_id, 1);
            $admissiondata[$key]->amount = $fee;
            //dd($fee);
        }

        $academy_info = AcademyInfo::first();

        return view('frontend-new.admissionlist', compact('admissiondata', 'session', 'notices', 'pages', 'academy_info'));
    }
    public function admissionview(Request $request)
    {
        $parentall = Page::orderBy('serial', 'asc')->where('active', 1)->get();
        $parents = $parentall->where('parent_id', 0);
        $pages = self::tree($parents, $parentall);
        $notices = Notice::where('publish_date', '<=', date('Y-m-d'))->where('validity_date', '>=', date('Y-m-d'))->orderBy('publish_date', 'desc')->orderBy('id', 'desc')->get();
        $session = DB::table('sessions')->where('active', 1)->first();
        $admissiondata = AdmissionOpen::with(['class', 'version', 'session']);
        $categories = Category::where('active', 1)->get();
        if (isset($request->test)) {
            $admissiondata = $admissiondata->where('session_id', $session->id)->where('class_id', 0)->get();
        } else {
            $admissiondata = $admissiondata->where('class_id', 0)->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))
                ->where('session_id', $session->id)->get();
        }
        
        if(count($admissiondata)==0){
          
            $admissiondata = AdmissionOpen::with(['class', 'version', 'session'])
            ->where('class_id', 0)
            ->where('admission_start_date', '<=', date('Y-m-d'))
            ->where('admission_end_date', '>=', date('Y-m-d'))
            ->where('session_id', $session->id)
            ->first();
                
        }
       
        if($admissiondata->admission_start_date<=date('Y-m-d') && $admissiondata->admission_end_date>=date('Y-m-d')){
            return view('frontend-new.admissionlistkg', compact('admissiondata','categories', 'session', 'notices', 'pages'));
        }

        $academy_info = AcademyInfo::first();

        return view('frontend-new.admissionlist', compact('admissiondata', 'categories', 'session', 'notices', 'pages', 'academy_info'));
    }
    public function admissionviewkg(Request $request)
    {
        $parentall = Page::orderBy('serial', 'asc')->where('active', 1)->get();
        $parents = $parentall->where('parent_id', 0);
        $pages = self::tree($parents, $parentall);
        $notices = Notice::where('publish_date', '<=', date('Y-m-d'))->where('validity_date', '>=', date('Y-m-d'))->orderBy('publish_date', 'desc')->orderBy('id', 'desc')->get();
        $session = DB::table('sessions')->where('active', 1)->orderBy('id', 'desc')->first();

        $admissiondata = AdmissionOpen::with(['class', 'version', 'session']);
        if (isset($request->test)) {
            $admissiondata = $admissiondata->where('session_id', $session->id + 1)->where('class_id', 0)->get();
        } else {
            $admissiondata = $admissiondata->where('class_id', 0)->where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))
                ->where('session_id', $session->id + 1)->get();
        }




        return view('frontend-new.admissionlistkg', compact('admissiondata', 'session', 'notices', 'pages'));
    }
    public function getCategoryView(Request $request)
    {

        if ($request->category_id == 1) {
            return '';
        } elseif ($request->category_id == 2) {
            return view('frontend-new.baf-employee');
        } elseif ($request->category_id == 3) {
            return view('frontend-new.shaheen-employee');
        } elseif ($request->category_id == 4) {
            return view('frontend-new.golden');
        }
        return '';
    }
    public function admissionstore(Request $request)
    {
        $request->validate([
            'staff_certification' => 'nullable|mimes:jpg,jpeg,png,pdf,webp|max:1024', // Optional file with allowed types and max size 2MB
            'arm_certification' => 'nullable|mimes:jpg,jpeg,png,pdf,webp|max:1024', // Optional file with allowed types and max size 2MB
            'birth_image' => 'nullable|mimes:jpg,jpeg,pdf,png,webp|max:1024', // Optional file with allowed types and max size 2MB
            'photo' => 'nullable|mimes:jpg,jpeg,png,pdf,webp|max:1024', // Optional file with allowed types and max size 2MB
        ]);
        $sessions = Sessions::where('id', $request->session_id)->first();

        $admissiondata = AdmissionOpen::where('session_id', $request->session_id)
            ->where('class_id', $request->class_id)->with(['class', 'session', 'version'])->first();
        //dd($request->all());


        if (empty($admissiondata)) {
            $text = "Payment does not added for admission";
            return redirect('/admissionview')->with('warning', $text);
        }

        if ($request->hasFile('staff_certification')) {
            $destinationPath = 'staff_certification/' . $sessions->session_name . '/' . $request->class_id;
            $myimage = date('dmyhis') . $request->staff_certification->getClientOriginalName();
            $request->staff_certification->move(public_path($destinationPath), $myimage);
            $staff_certification = asset('public/' . $destinationPath) . '/' . $myimage;
        } else {
            $staff_certification = '';
        }

        if ($request->hasFile('arm_certification')) {
            $destinationPath = 'arm_certification/' . $sessions->session_name . '/' . $request->class_id;
            $myimage = date('dmyhis') . $request->arm_certification->getClientOriginalName();
            $request->arm_certification->move(public_path($destinationPath), $myimage);
            $arm_certification = asset('public/' . $destinationPath) . '/' . $myimage;
        } else {
            $arm_certification = '';
        }
        if ($request->hasFile('birth_image')) {
            $destinationPath = 'birth_image/' . $sessions->session_name . '/' . $request->class_id;
            $myimage = date('dmyhis') . $request->birth_image->getClientOriginalName();
            $request->birth_image->move(public_path($destinationPath), $myimage);
            $birth_image = asset('public/' . $destinationPath) . '/' . $myimage;
        } else {
            $birth_image = '';
        }
        if ($request->hasFile('photo')) {
            $destinationPath = 'photo/' . $sessions->session_name . '/' . $request->class_id;
            $myimage = date('dmyhis') . $request->photo->getClientOriginalName();
            $request->photo->move(public_path($destinationPath), $myimage);
            $photo = asset('public/' . $destinationPath) . '/' . $myimage;
        } else {
            $photo = '';
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
            'mobile' => $request->mobile,
            'birth_registration_number' => $request->birth_registration_number,
            'birth_image' => $birth_image,
            'photo' => $photo,
        );
        $admissionapplied = StudentAdmission::where('session_id', $request->session_id)
            ->where('version_id', $request->version_id)
            ->where('shift_id', $request->shift_id)
            ->where('class_id', $request->class_id)
            ->where('category_id', $request->category_id)
            ->where('payment_status', 1)
            ->where('birth_registration_number', $request->birth_registration_number)
            ->first();
        if ($admissionapplied) {
            $text = "Already Applied";
            return redirect('/admissionview')->with('warning', $text);
        }
        $studentadmission = StudentAdmission::updateOrCreate(
            [
                'session_id' => $request->session_id,
                'version_id' => $request->version_id,
                'shift_id' => $request->shift_id,
                'class_id' => $request->class_id,
                'category_id' => $request->category_id,
                'birth_registration_number' => $request->birth_registration_number
            ],
            $admission
        );

        $tranjection = array(
            'student_code' => $studentadmission->id,
            'admission_id' => $studentadmission->id,
            'common_id' => $studentadmission->id,
            'fee_for' => 2,
            'session_id' => $request->session_id,
            'version_id' => $request->version_id,
            'shift_id' => $request->shift_id,
            'category_id' => $request->category_id,
            'class_id' => $request->class_id,
            'class_code' => $request->class_id,
            'payment_date' => date('Y-m-d'),
            'amount' => $admissiondata->price
        );
        $tran_id = DB::table('student_fee_tranjection')->insertGetId($tranjection);
        $post_data = array();
        $post_data['total_amount'] = $admissiondata->price; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = $tran_id; // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $request->name_en;
        $post_data['cus_email'] = '';
        $post_data['cus_add1'] = '';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = $request->mobile;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "BAFSD";
        $post_data['ship_add1'] = "Dhaka Cantonment, Police Station: Kafarul";
        $post_data['ship_add2'] = "Dhaka Cantonment, Police Station: Kafarul";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1206";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Admission";
        $post_data['product_category'] = "Admission";
        $post_data['product_profile'] = "Admission";



        #Before  going to initiate the payment order status need to insert or update as Pending.
        // $update_product = DB::table('orders')
        //     ->where('transaction_id', $post_data['tran_id'])
        //     ->updateOrInsert([
        //         'name' => $post_data['cus_name'],
        //         'email' => $post_data['cus_email'],
        //         'phone' => $post_data['cus_phone'],
        //         'amount' => $post_data['total_amount'],
        //         'status' => 'Pending',
        //         'address' => $post_data['cus_add1'],
        //         'transaction_id' => $post_data['tran_id'],
        //         'currency' => $post_data['currency']
        //     ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function checkTemporaryId(Request $request)
    {
        $session = DB::table('sessions')->where('id', date('Y'))->first();
        $admissiondata = DB::table('student_admission')->where('session_id', $session->id);

        $admissiondata = $admissiondata->where('temporary_id', $request->temporary_id)
            //->where('status',1)
            ->first();

        //$admissiondata=$admissiondata->first();
        if ($admissiondata) {

            if ($admissiondata->status == 2) {
                return 0;
            }
            if ($admissiondata->status == 3) {
                return 2;
            }
            if ($admissiondata->status == 1) {
                return json_encode($admissiondata);
            }
        }
        return 0;
        // return 'Roll number or registration number not found in baf shaheen college board list';
    }
    public function checkRollRegistrationNumber(Request $request)
    {
        $session = DB::table('sessions')->where('active', 1)->first();
        $admissiondata = DB::table('board_list')->where('session_id', $session->id);

        $admissiondata = $admissiondata->where('roll_number', $request->roll_number)
            ->where('board', $request->board_id)
            ->first();

        //$admissiondata=$admissiondata->first();
        if ($admissiondata) {
            if ($admissiondata->status == 0) {
                return 2;
            }
            if ($admissiondata->is_admit == 1) {
                return 1;
            }
            return json_encode($admissiondata);
        }
        return 0;
        // return 'Roll number or registration number not found in baf shaheen college board list';
    }
    public function studentcorner()
    {

        $articles = Article::where('article_type', 'Student Corner')->get();
        $pagedata = Page::orderBy('serial', 'asc')->where('active', 1)->get();
        $parents = $pagedata->where('parent_id', 0);
        $pages = self::tree($parents, $pagedata);

        return view('frontend-new.student-corner', compact('pages', 'articles'));
    }
    public function fromCampus()
    {
        $articles = Article::where('article_type', 'From Campus')->get();
        $pagedata = Page::orderBy('serial', 'asc')->where('active', 1)->get();
        $parents = $pagedata->where('parent_id', 0);
        $pages = self::tree($parents, $pagedata);

        return view('frontend-new.our-campus', compact('pages', 'articles'));
    }
    public function details($id)
    {
        $article = Article::find($id);
        $articles = Article::where('id', '!=', $id)->where('article_type', '!=', 'From Campus')->limit(5)->orderBy('id', 'desc')->get();

        $pagedata = Page::orderBy('serial', 'asc')->where('active', 1)->get();
        $parents = $pagedata->where('parent_id', 0);
        $pages = self::tree($parents, $pagedata);

        return view('frontend-new.details', compact('pages', 'article', 'articles'));
    }
}
