<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\sttings\Shifts;
use App\Models\sttings\Versions;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Exception;
use App\Models\SMS;
use App\Models\Student\Student;
use App\Models\Model_has_roles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /**
     * Display all users
     *
     * @return \Illuminate\Http\Response
     */
    public function createusers($request)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        $students = Student::join('student_activity', 'student_activity.student_code', '=', 'students.student_code')
            ->select(
                'first_name',
                'email',
                'sms_notification',
                'student_activity.roll',
                'student_activity.student_code',
                'photo'
            )
            ->where('version_id', $request->version_id)
            ->where('session_id', 2025)
            ->where('students.active', 1)
            ->where('student_activity.active', 1)
            ->get();
        //dd($students);
        foreach ($students as $student) {
            //$user=DB::table('users')->where('ref_id',$student->student_code)->first();
            // if($user){
            //     DB::table('users')->where('id',$user->id)->update(['username'=>$student->student_code,'password'=>bcrypt('#12456#')]);
            // }else{
            //     $userdata = [
            //         'name' => $student->first_name,
            //         'username' => $student->student_code,
            //         'email' => $student->email,
            //         'phone' => $student->sms_notification,
            //         'photo' => $student->photo,
            //         'group_id' => 4,
            //         'ref_id' => $student->student_code,
            //         'is_admission'=>1,
            //         'is_profile_update'=>1,
            //         'created_at'=>date('Y-m-d H:i:s'),
            //         'password' => bcrypt('#12456#'),
            //         'password_text' => '#12456#'
            //     ];
            //     $id = DB::table('users')->insert($userdata);
            //     //$user->create(array_merge($request->validated()));
            //     //$user->syncRoles($request->get('group_id'));
            //     //dd($user);
            //     // $usersyncroles = array(
            //     //     'role_id' => 4,
            //     //     'model_type' => 'App\Models\User',
            //     //     'model_id' => $id
            //     // );
            //     // Model_has_roles::updateOrCreate(['role_id'=>4,'model_id'=>$id],$usersyncroles);

            if ($student->sms_notification) {
                $smsbody = "Dear Student, Your Login details to the Shaheen Soft system as follows ID is " . $student->student_code . " and Password is #123456#. Please login via BAFSD website";

                sms_send($student->sms_notification, $smsbody);
            }
        }
    }
    // public function index(Request $request)
    // {
    //     Session::put('activemenu', 'users');
    //     Session::put('activesubmenu', 'ul');

    //     // dd($request->all());

    //     $version_id = $request->version_id;
    //     $shift_id = $request->shift_id;
    //     $class_id = $request->class_id;
    //     $is_teacher = $request->is_teacher;
    //     $search_input = $request->search_input;
    //     $section_id = $request->section_id;
    //     if ($request && $request->offset) {
    //         $this->createusers($request);
    //     }
    //     $users = User::with('role');

    //     if ($is_teacher == 1) {
    //         $users = $users->join('employees', 'employees.id', '=', 'users.ref_id')->where('group_id', 3);

    //         if ($version_id) {
    //             $users = $users->whereRaw('version_id = "' . $version_id . '"');
    //         }
    //         if ($shift_id) {
    //             $users = $users->whereRaw('shift_id = "' . $shift_id . '"');
    //         }
    //     } else {

    //         $users = $users->select('users.*', 'section_name')->join('student_activity', 'student_activity.student_code', '=', 'users.ref_id')
    //             ->join('sections', 'sections.id', '=', 'student_activity.section_id');
    //         if ($version_id) {
    //             $users = $users->whereRaw('student_activity.version_id = "' . $version_id . '"');
    //         }
    //         if ($shift_id) {
    //             $users = $users->whereRaw('student_activity.shift_id = "' . $shift_id . '"');
    //         }
    //         if ($class_id != 'null') {
    //             $users = $users->whereRaw('student_activity.class_code = "' . $class_id . '"');
    //         }
    //     }

    //     $users = $users->paginate(50);
    //     $shifts = Shifts::all();
    //     $versions = Versions::all();

    //     return view('users.index', compact('users', 'shifts', 'versions', 'class_id', 'shift_id', 'version_id', 'teacher_for', 'is_teacher'));
    // }

    public function index(Request $request)
    {

        // dd($request->all());
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 7) {
            return 1;
        }
        Session::put('activemenu', 'users');
        Session::put('activesubmenu', 'ul');

        $version_id = $request->version_id;
        $shift_id = $request->shift_id;
        $class_code = $request->class_code;
        $is_teacher = $request->is_teacher;
        $search_input = $request->search_input;
        $section_id = $request->section_id;
        if ($request && $request->offset) {
            $this->createusers($request);
        }

        $users = User::with('role');

        if ($request->is_teacher == 1) {
            // If teacher, join employees table and filter by group_id = 3
            $users = $users->select('users.*')->join('employees', 'employees.id', '=', 'users.ref_id')
                ->whereIn('group_id', [3, 12])
                ->when($request->version_id, fn($query, $version_id) => $query->where('employees.version_id', $version_id))
                ->when($request->shift_id, fn($query, $shift_id) => $query->where('employees.shift_id', $shift_id))
                ->when($request->class_code, fn($query, $class_code) => $query->where('employees.employee_for', $class_code));

            if ($request->filled('search_input')) {
                $users = $users->where(function ($query) use ($request) {
                    $query->where('employees.employee_name', 'like', "%{$request->search_input}%")
                        ->orWhere('employees.mobile', 'like', "%{$request->search_input}%");
                });
            }
        } else {
            // If student, join student_activity and sections
            $users = $users->select('users.*', 'section_name', 'students.sms_notification')
                ->join('student_activity', 'student_activity.student_code', '=', 'users.ref_id')
                ->join('students', 'students.student_code', '=', 'users.ref_id')
                ->join('sections', 'sections.id', '=', 'student_activity.section_id')
                ->where('students.active', 1)->where('student_activity.active', 1);

            if ($request->version_id) {
                $users = $users->where('student_activity.version_id', $request->version_id);
            }
            if ($request->shift_id) {
                $users = $users->where('student_activity.shift_id', $request->shift_id);
            }
            if ($request->class_code) {
                $users = $users->where('student_activity.class_code', $request->class_code);
            }
            if ($request->class_code ==  0 && $request->class_code != null) {
                $users = $users->where('student_activity.class_code', 0);
            }
            if ($request->section_id) {
                $users = $users->where('student_activity.section_id', $request->section_id);
            }

            if ($request->filled('search_input')) {
                $users = $users->where(function ($query) use ($request) {
                    $query->where('students.first_name', 'like', "%{$request->search_input}%")
                        ->orWhere('students.student_code', 'like', "%{$request->search_input}%")
                        ->orWhere('students.mobile', 'like', "%{$request->search_input}%")
                        ->orWhere('students.sms_notification', 'like', "%{$request->search_input}%");
                });
            }
            // dd($users);
        }
        $users = $users->paginate(50);
        $shifts = Shifts::all();
        $versions = Versions::all();
        $sections = DB::table('sections')->get();

        // dd($users);

        return view('users.index', compact('users', 'shifts', 'versions', 'class_code', 'shift_id', 'version_id', 'is_teacher', 'sections', 'section_id', 'search_input'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/admissionview');
    }

    /**
     * Show form for creating user
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        Session::put('activemenu', 'users');
        Session::put('activesubmenu', 'ul');
        $userRole = array();
        $roles = Role::orderBy('name', 'ASC')->get();
        return view('users.create', compact('roles', 'userRole'));
    }

    /**
     * Store a newly created user
     *
     * @param User $user
     * @param StoreUserRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        $request->validated();

        $userdata = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'photo' => $request->photo,
            'group_id' => $request->group_id,
            'password' => bcrypt($request->password),
            'password_text' => $request->password
        ];
        $id = DB::table('users')->insert($userdata);
        //$user->create(array_merge($request->validated()));
        //$user->syncRoles($request->get('group_id'));
        //dd($user);
        $usersyncroles = array(
            'role_id' => $request->get('group_id'),
            'model_type' => 'App\Models\User',
            'model_id' => $id
        );
        DB::table('model_has_roles')->insert($usersyncroles);

        return redirect()->route('users.index')
            ->withSuccess(__('User created successfully.'));



        // $validator = Validator::make($request->all(), [
        //     'name' => 'required',
        //     'email' => 'required|email:rfc,dns|unique:users,email',
        //     'phone' => 'required',
        //     'password' => 'required',
        //     'group_id' => 'required',
        //     'photo' => 'nullable',
        // ]);
        // try {
        //     if ($validator->passes()) {
        //         $user = new User;
        //         $user->name = $request->name;
        //         $user->email = $request->email;
        //         $user->phone = $request->phone;
        //         // $user->photo = $request->photo;
        //         $user->group_id = $request->group_id;
        //         $user->password = bcrypt($request->password);
        //         $user->password_text = $request->password;
        //         $user->save();
        //         // Assign role to user
        //         $user->assignRole($request->group_id);
        //         return redirect()->route('users.index')->with('success', 'User added successfully');
        //     } else {
        //         return redirect()->back()->withInput()->withErrors($validator->errors());
        //     }
        // } catch (Exception $e) {
        //     return redirect()->back()->withInput()->with('error', $e->getMessage());
        // }
    }

    /**
     * Show user data
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', [
            'user' => $user
        ]);
    }

    /**
     * Edit user data
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function sendSmsUser(Request $request)
    {
        // dd($request->all());
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        if ($request->is_teacher == 1) {
            // $users = User::select('users.*')->join('employees', 'employees.id', '=', 'users.ref_id')->where('employees.version_id', $request->version_id)->where('employees.shift_id', '=', $request->shift_id)->where('employees.employee_for', '=', $request->class_code)->where('users.group_id', 3)->where('users.status', 'Active')->get();
            // $users = User::select('users.*')->where('users.group_id', 3)->where('users.status', 'Active')->get();
            $users = User::with('role');
            $users = $users->select('users.*', 'employees.mobile as sms_notification')
                ->join('employees', 'employees.id', '=', 'users.ref_id')
                ->where('employees.version_id', $request->version_id)
                ->where('employees.shift_id', $request->shift_id)
                ->where('employees.employee_for', $request->class_code)->get();
            // dd($users[1]->sms_notification);
            foreach ($users as $user) {
                $password = $this->generateRandomNumber();
                $userpassword = array(
                    'password_text' => $password,
                    'password' => bcrypt($password)
                );
                DB::table('users')->where('id', $user->id)->update($userpassword);
                $smsdata = new SMS();
                $smsbody = "Dear Teacher,Your Login details to the Shaheen Soft system as follows Username is " . $user->username . " and Password is " . $password . ".";

                $mobiles = [$user->sms_notification];
                //  $mobiles=['01913366387'];
                $smsdata->session_id = date('Y');
                $smsdata->student_code = $user->ref_id;
                $smsdata->send_for = 2;
                $smsdata->version_id = $request->version_id;
                $smsdata->shift_id = $request->shift_id;
                $smsdata->class_id = $request->class_code;
                $smsdata->section_id = $request->section_id;
                $smsdata->numbers = implode(',', $mobiles);
                $smsdata->sms_body = $smsbody;
                $smsdata->lang = 1;
                $smsdata->smscount = 1;
                $smsdata->number_of_sms = 1 * 1;
                $smsdata->created_by = Auth::user()->id;
                // dd($smsdata);
                $status = sms_send(implode(',', $mobiles), $smsbody);

                $status = json_decode($status);



                try {
                    $smsdata->status = $status->response_code;
                    // dd($smsdata);
                    $smsdata->save();
                } catch (Exception $e) {
                    $smsdata->status = 0;
                    // dd($smsdata);
                    $smsdata->save();
                }
            }
        } else {
            $users = User::with('role');
            $users = $users->select('users.*', 'section_name', 'students.sms_notification')
                ->join('student_activity', 'student_activity.student_code', '=', 'users.ref_id')
                ->join('students', 'students.student_code', '=', 'users.ref_id')
                ->join('sections', 'sections.id', '=', 'student_activity.section_id')
                ->where('students.active', 1)->where('student_activity.active', 1)
                ->where('student_activity.version_id', $request->version_id)
                ->where('student_activity.shift_id', $request->shift_id)
                ->where('student_activity.class_code', $request->class_code)
                ->where('student_activity.section_id', $request->section_id)->get();
            // dd($users[0]->sms_notification);
            foreach ($users as $user) {
                $passowrd = $this->generateRandomNumber();
                $userpassword = array(
                    'password_text' => $passowrd,
                    'password' => bcrypt($passowrd)
                );
                DB::table('users')->where('id', $user->id)->update($userpassword);
                $smsdata = new SMS();
                $smsbody = "Dear Student,Your Login details to the Shaheen Soft system as follows Username is " . $user->ref_id . " and Password is " . $passowrd . ".";

                $mobiles = [$user->sms_notification];
                //  $mobiles=['01913366387'];
                $smsdata->session_id = date('Y');
                $smsdata->student_code = $user->ref_id;
                $smsdata->send_for = 2;
                $smsdata->version_id = $request->version_id;
                $smsdata->shift_id = $request->shift_id;
                $smsdata->class_id = $request->class_code;
                $smsdata->section_id = $request->section_id;
                $smsdata->numbers = implode(',', $mobiles);
                $smsdata->sms_body = $smsbody;
                $smsdata->lang = 1;
                $smsdata->smscount = 1;
                $smsdata->number_of_sms = 1 * 1;
                $smsdata->created_by = Auth::user()->id;
                //dd($smsdata);
                $status = sms_send(implode(',', $mobiles), $smsbody);

                $status = json_decode($status);



                try {
                    $smsdata->status = $status->response_code;
                    // dd($smsdata);
                    $smsdata->save();
                } catch (Exception $e) {
                    $smsdata->status = 0;
                    // dd($smsdata);
                    $smsdata->save();
                }
            }
        }

        return redirect()->route('users.index')->withSuccess(__('Send Sms successfully.'));
    }
    public function edit(User $user)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        $roles = Role::orderBy('name', 'ASC')->get();
        $hasRole = $user->roles->pluck('id');

        return view('users.edit', [
            'user' => $user,
            'hasRole' => $hasRole,
            'roles' => $roles
        ]);
    }

    /**
     * Update user data
     *
     * @param User $user
     * @param UpdateUserRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, Request $request)
    {

        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        $user = User::findOrFail($user->id);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['required', 'string', 'max:15'],
            'group_id' => ['required', 'integer'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        if ($validator->passes()) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            // $user->photo = $request->photo;
            $user->group_id = $request->group_id;
            $user->password = bcrypt($request->password);
            $user->password_text = $request->password;
            $user->save();
            try {
                $user->syncRoles($request->group_id);
            } catch (Exception $e) {
                return redirect()->back()->withInput()->with('error', $e->getMessage());
            }

            return redirect()->route('users.index')->withSuccess(__('User updated successfully.'));
        } else {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
    }

    /**
     * Delete user data
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        $user->delete();
        return 1;
        return redirect()->route('users.index')
            ->withSuccess(__('User deleted successfully.'));
    }

    private function generateRandomNumber()
    {
        // Generates a 6-digit random number
        return rand(100000, 999999);
    }
    public function resetPassword($id)
    {

        try {
            $password = $this->generateRandomNumber();
            $user = DB::table('users')->where('id', $id)->first();

            if (!$user) {
                return redirect()->route('users.index')->withErrors(__('User not found.'));
            }

            // Update user password and pasword_text
            $updateData = [
                'password' => bcrypt($password),
                'password_text' => $password,
            ];

            $update = DB::table('users')->where('id', $user->id)->update($updateData);

            if ($update) {
                $message = sprintf(
                    'User password has been reset successfully. User: %s, Pass: %s. Link: https://bafsd.edu.bd/login',
                    $user->group_id == 4 ? $user->ref_id : $user->username,
                    $password
                );

                if ($user->group_id == 4) {
                    $phone = DB::table('students')->where('student_code', $user->ref_id)->value('sms_notification') ?? $user->phone;
                } else {
                    $phone = $user->phone;
                }

                sms_send($phone, $message);

                return redirect()->route('users.index')->withSuccess(__('User password has been reset successfully.'));
            }
            return redirect()->route('users.index')->withErrors(__('Failed to reset user password.'));
        } catch (\Exception $e) {

            return redirect()->route('users.index')->withErrors(__($e->getMessage() ?? 'An error occurred while resetting the password.'));
        }
    }
    public function updatePassword()
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        $array = array(
            20241375 => 314429,
            20243221 => 230310,
            20243302 => 550820,
            20243323 => 429082,
            20243301 => 469991,
            20243202 => 981408,
            20243260 => 443168,
            20241130 => 311338,
            20241203 => 642805,
            20241106 => 394020,
            20241175 => 966892,
            20241087 => 769711,
            20241143 => 240085,
            20241011 => 570427,
            20241101 => 218640,
            20241113 => 949160,
            20241196 => 278545,
            20241005 => 742571,
            20241053 => 740889,
            20241035 => 295902,
            20241092 => 569193,
            20241141 => 792911,
            20241108 => 606133,
            20241128 => 615838,
            20241112 => 332473,
            20241197 => 303543,
            20241177 => 789768,
            20241220 => 337733,
            20241099 => 432219,
            20241154 => 292964,
            20241174 => 386536,
            20241052 => 151665,
            20241136 => 543651,
            20241131 => 361899,
            20241127 => 516870,
            20241186 => 424076,
            20241210 => 788814,
            20241145 => 510547,
            20241046 => 914263,
            20241218 => 590046,
            20241374 => 778290,
            20241369 => 663287,
            20241363 => 282034,
            20241360 => 923051,
            20241359 => 758770,
            20243116 => 945762,
            20243207 => 716122,
            20243041 => 641316,
            20243102 => 466012,
            20243210 => 610785,
            20241110 => 368253,
            20241118 => 331779,
            20241007 => 536402,
            20241025 => 123098,
            20241094 => 740276,
            20241167 => 807250,
            20241102 => 757479,
            20241049 => 209683,
            20241187 => 448441,
            20241164 => 529636,
            20241116 => 165765,
            20241009 => 159703,
            20241100 => 561157,
            20241169 => 322008,
            20241165 => 183910,
            20241161 => 209744,
            20241029 => 655507,
            20241064 => 818037,
            20241148 => 337527,
            20241216 => 395884,
            20241058 => 615837,
            20241133 => 884061,
            20241018 => 189930,
            20241178 => 140187,
            20241138 => 474875,
            20241016 => 121195,
            20241054 => 717397,
            20241123 => 968140,
            20241206 => 561181,
            20241105 => 384447
        );

        foreach ($array as $key => $value) {
            $updateData = [
                'password' => bcrypt($value),
                'password_text' => $value,
            ];

            $update = DB::table('users')->where('ref_id', $key)->update($updateData);
        }
    }

    public function createStudentUser()
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        $students = [

            "20243345" => [
                "first_name" => "Md. Tashrif Abrar Zayan",
                "father_name" => "Md. Monjur Morshed",
                "father_phone" => "nan",
                "sms_notification" => "1323230737",
                "mobile" => "1323230737.0",
            ],
        ];
        $studentsData = [];
        $i = 0;
        foreach ($students as $key => $s) {

            // dd($s['sms_notification']);
            // $passowrd = mt_rand(100000, 999999);
            // $studentsData[$i++] = array(
            //     'name' => $s['first_name'],
            //     'username' => $key,
            //     'phone' => ($s['sms_notification']) ? '0' . $s['sms_notification'] : null,
            //     'password' => bcrypt($passowrd),
            //     'password_text' => $passowrd,
            //     'ref_id' => $key,
            //     'group_id' => 4,
            //     'status' => 'Active',
            //     'is_admission' => 1,
            //     'is_profile_update' => 1,
            // );
            // $smsdata = new SMS();
            // $smsbody = "Dear Student,Your Login details to the Shaheen Soft system as follows Username is " . $key . " and Password is " . $passowrd . ". login link https://bafsd.edu.bd/login";

            // // $mobiles = [$s->sms_notification];
            // //  $mobiles=['01913366387'];
            // $smsdata->session_id = date('Y');
            // $smsdata->student_code = $key;
            // $smsdata->send_for = 2;
            // $smsdata->version_id = 0;
            // $smsdata->shift_id = 0;
            // $smsdata->class_id = 0;
            // $smsdata->section_id = 0;
            // $smsdata->numbers = $s['sms_notification'];
            // $smsdata->sms_body = $smsbody;
            // $smsdata->lang = 1;
            // $smsdata->smscount = 2;
            // $smsdata->number_of_sms = 2 * 1;
            // $smsdata->created_by = Auth::user()->id;
            // //dd($smsdata);
            // $status = sms_send($s['sms_notification'], $smsbody);

            // $status = json_decode($status);



            // try {
            //     $smsdata->status = $status->response_code;
            //     // dd($smsdata);
            //     $smsdata->save();
            // } catch (Exception $e) {
            //     $smsdata->status = 0;
            //     // dd($smsdata);
            //     $smsdata->save();
            // }
        }
        // dd($studentsData);
        $update = DB::table('users')->insert($studentsData);
    }
}
