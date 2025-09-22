<?php

namespace App\Http\Controllers;

use App\Models\SMS;
use App\Models\Role;
use App\Models\sttings\AcademySection;
use App\Models\sttings\Sessions;
use App\Models\sttings\Shifts;
use App\Models\sttings\Versions;
use App\Models\sttings\Category;
use App\Models\sttings\Classes;
use App\Models\sttings\Designation;
use App\Models\sttings\Subjects;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class SMSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request->all());
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        Session::put('activemenu', 'sms');
        Session::put('activesubmenu', 'ss');
        $class_code = $request->class_code;
        $session_id = $request->session_id;
        $version_id = $request->version_id;
        $shift_id = $request->shift_id;
        $section_id = $request->section_id;

        $page_size = $request->page_size ?? 10;
        $sessions = Sessions::get();
        $versions = Versions::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $classes = Classes::orderByRaw("CAST(class_code AS UNSIGNED)")->pluck('class_name', 'class_code');
        $subjects = Subjects::where('active', 1)->get();
        $designationes = Designation::where('active', 1)->orderBy('designation_name', 'asc')->get();

        $smss = collect();
        $smss = SMS::with(['session', 'version', 'classes', 'section', 'shift']);
        // if ($session_id) {
        //     $smss = $smss->where('session_id', $session_id);
        // }
        // if ($version_id) {
        //     $smss = $smss->where('version_id', $version_id);
        // }
        // if ($shift_id) {
        //     $smss = $smss->where('shift_id', $shift_id);
        // }
        // if ($class_code) {
        //     $smss = $smss->where('class_id', $class_code);
        // }
        // if ($section_id) {
        //     $smss = $smss->where('section_id', $section_id);
        // }

        if ($request->text_search) {
            $smss = $smss->orWhere('numbers', 'like', '%' . $request->text_search . '%')
                ->orWhere('student_code', 'like', '%' . $request->text_search . '%');
        }

        $smss = $smss->orderBy('id', 'desc')->paginate($page_size);

        // Render AJAX pagination if requested
        if ($request->ajax()) {
            return view('sms.ajaxsearch', compact('smss'))->render();
        }

        return view('sms.index', compact('sessions', 'versions', 'shifts', 'classes', 'subjects', 'designationes', 'smss'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        Session::put('activemenu', 'sms');
        Session::put('activesubmenu', 'smsc');

        $sessions = Sessions::where('active', 1)->first();
        $versions = Versions::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $classes = Classes::orderByRaw("CAST(class_code AS UNSIGNED)")->pluck('class_name', 'class_code');
        $subjects = Subjects::where('active', 1)->get();
        $groups = AcademySection::where('active', 1)->get();
        $designationes = Designation::where('active', 1)->orderBy('designation_name', 'asc')->get();
        $studentcategoris = Category::where('type', 2)->where('active', 1)->get();

        return view('sms.create', compact('sessions', 'groups', 'versions', 'subjects', 'designationes', 'studentcategoris', 'shifts', 'classes', 'subjects', 'designationes'));
    }

    public function sendPassword()
    {
        $roles = Role::orderBy('name', 'asc')->get();
        Session::put('activemenu', 'smsssl');
        Session::put('activesubmenu', 'sp');
        return view('sms.create_teacher', compact('roles'));
    }

    public function getUserDataByRole(Request $request)
    {
        // Validate the role_id input
        $request->validate([
            'role_id' => 'required|exists:roles,id',

        ]);

        $users = DB::table('users')
            ->select('username', 'phone', 'name')
            ->whereNotNull('username')
            ->where('group_id', $request->role_id);
        if ($request->name) {
            $users = $users->where('name', $request->name);
        }
        if ($request->limit) {
            $users = $users->offset($request->limit);
        }
        $users = $users->limit(50)
            ->get();

        // Render the user data in a table row format
        $output = '';
        if ($users->count() > 0) {
            foreach ($users as $key => $user) {
                $output .= '
                <tr>
                    <td>' . ($key + 1) . '</td>
                    <td><input type="hidden" name="name[]" value="' . $user->name . '">' . $user->name . '</td>
                    <td><input type="hidden" name="username[]" value="' . $user->username . '">' . $user->username . '</td>
                    <td><input type="hidden" name="phone[]" value="' . $user->phone . '">' . $user->phone . '</td>

                </tr>
            ';
            }
        } else {
            $output = '<tr><td colspan="4">No users found for the selected role</td></tr>';
        }
        return response()->json($output);
    }

    public function sendData(Request $request)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        $data = $request->all();
        $sessions = Sessions::where('active', 1)->first();
        foreach ($data['username'] as $key => $value) {
            $smsdata = new SMS();
            $smsbody = "Dear Teacher, please login https://bafsd.edu.bd/ using provided user id & password. You must change your password after your first login from the 'Change Password' option in the profile section. Please keep your password confidential.
User Id: " . $value . "
Password: 123456";
            $mobiles = [$data['phone'][$key]];
            // $mobiles=['01913366387'];
            $smsdata->session_id = $sessions->id;
            $smsdata->send_for = 2;
            $smsdata->version_id = null;
            $smsdata->shift_id = null;
            $smsdata->class_id = null;
            $smsdata->section_id = null;
            $smsdata->numbers = implode(',', $mobiles);
            $smsdata->sms_body = $smsbody;
            $smsdata->lang = 1;
            $smsdata->smscount = 2;
            $smsdata->number_of_sms = 2 * 1;
            $smsdata->created_by = Auth::user()->id;
            $status = sms_send(implode(',', $mobiles), $smsbody);

            $status = json_decode($status);



            try {
                $smsdata->status = $status->response_code;
                // dd($smsdata);
                $smsdata->save();
            } catch (Exception $e) {
            }
        }
        if ($data) {
            return back()->with('success', 'Data sent successfully!');
        } else {
            return back()->with('error', 'Something went wrong!');
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {

    //     $request->validate([
    //         'session_id' => 'required',
    //         'sms_for' => 'required',
    //         'mobile' => 'required',
    //         'smsbody' => 'required|max:159',
    //     ], [
    //         'smsbody.max' => 'SMS body cannot exceed 159 characters.',
    //     ]);

    //     if ($request->sendfor == 1) {
    //         $mobiles = explode(",", $request->mobile[0]);
    //         // foreach ($mobiles as $mobile) {
    //         //     DB::table('admission_temporary')->where('phone', $mobile)->update(['send_sms' => 1]);
    //         // }
    //     } else {
    //         $mobiles = explode(",", $request->mobile[0]);
    //     }


    //     $smscount = ($request->text_lang == 1) ? ceil(($request->numberofchar) / 70) : ceil(($request->numberofchar) / 160);

    //     $smsdata = new SMS();
    //     $smsdata->session_id = $request->session_id;
    //     $smsdata->send_for = $request->sms_for;
    //     $smsdata->version_id = $request->version_id;
    //     $smsdata->shift_id = $request->shift_id;
    //     $smsdata->class_id = $request->class_id;
    //     $smsdata->section_id = $request->section_id;
    //     $smsdata->numbers = implode(',', $mobiles);
    //     $smsdata->sms_body = $request->smsbody;
    //     $smsdata->lang = $request->text_lang ?? 1;
    //     $smsdata->smscount = $smscount;
    //     $smsdata->number_of_sms = $smscount * count($mobiles);
    //     $smsdata->created_by = Auth::user()->id;
    //     //dd($mobiles, $request->smsbody);
    //     $status = sms_send(implode(',', $mobiles), $request->smsbody);

    //     $status = json_decode($status);

    //     $smsdata->status = $status->response_code;
    //     // dd($smsdata);
    //     $smsdata->save();
    //     $smstext = "SMS sent successfully";
    //     return redirect(route('sms.index'))->with('success', $smstext);
    // }


    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'session_id' => 'required',
    //         'sms_for' => 'required',
    //         'mobile' => 'required',
    //         'smsbody' => 'required|max:250',
    //     ], [
    //         'smsbody.max' => 'SMS body cannot exceed 159 characters.',
    //     ]);

    //     try {
    //         if ($request->sendfor == 1) {
    //             $mobiles = explode(",", $request->mobile[0]);
    //         } else {
    //             $mobiles = explode(",", $request->mobile[0]);
    //         }

    //         $smscount = ($request->text_lang == 1) ? ceil(($request->numberofchar) / 70) : ceil(($request->numberofchar) / 250);

    //         $smsdata = new SMS();
    //         $smsdata->session_id = $request->session_id;
    //         $smsdata->send_for = $request->sms_for;
    //         $smsdata->version_id = $request->version_id;
    //         $smsdata->shift_id = $request->shift_id;
    //         $smsdata->class_id = $request->class_id;
    //         $smsdata->section_id = $request->section_id;
    //         $smsdata->numbers = implode(',', $mobiles);
    //         $smsdata->sms_body = $request->smsbody;
    //         $smsdata->lang = $request->text_lang ?? 1;
    //         $smsdata->smscount = $smscount;
    //         $smsdata->number_of_sms = $smscount * count($mobiles);
    //         $smsdata->created_by = Auth::user()->id;

    //         $status = sms_send(implode(',', $mobiles), $request->smsbody);
    //         $status = json_decode($status);

    //         $smsdata->status = $status->response_code;
    //         $smsdata->save();

    //         if (Auth::user()->group_id == 7) {
    //             return redirect(route('sms.create'))->with('success', 'SMS sent successfully.');
    //         } else {
    //             return redirect(route('sms.index'))->with('success', 'SMS sent successfully.');
    //         }
    //     } catch (\Exception $e) {
    //         return back()->withInput()->withErrors(['error' => 'Something went wrong. Please try again.']);
    //     }
    // }


    /**
     * Display the specified resource.
     */
    public function show(SMS $sMS)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SMS $sMS)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SMS $sMS)
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
        $sms = SMS::find($id);

        if ($sms) {
            $sms->delete();
            return response()->json(['success' => 'SMS deleted successfully.']);
        } else {
            return response()->json(['error' => 'SMS not found.'], 404);
        }
    }

    public function getAdmissionPhoneWithClass(Request $request)
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        $sessions = Sessions::where('active', 1)->first();
        $phones = DB::table('admission_temporary')
            ->where('session_id', $sessions->id)
            ->where('class_id', 59)
            ->where('send_sms', 0)
            ->where('payment_status', 1)
            ->orderBy('id', 'asc')
            ->pluck('phone')->toArray();
        return implode(",", $phones);
    }
}