<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student\Student;
use App\Models\User;
use App\Models\Employee\Employee;
use Illuminate\Http\Request;
use App\Models\Website\Page;
use Illuminate\Support\Facades\Session;

class ForgotPasswordController extends Controller
{

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
    public function verify(Request $request)
    {
        $request->validate([
            'birthdate' => 'required|date',  // Ensure valid date input
        ]);

        $birthdate = $request->input('birthdate');

        // Try to find the student first
        $student = Student::where('birthdate', $birthdate)->first();

        // If not found in students, try employees
        $employee = Employee::where('dob', $birthdate)->first();

        // Determine the user based on the student or employee records
        if ($student) {
            // If the student is found, retrieve the associated user from the users table
            $user = User::where('ref_id', $student->student_code)->first();
        } elseif ($employee) {
            // If the employee is found, retrieve the associated user from the users table
            $user = User::where('ref_id', $employee->id)->first();
        } else {
            return redirect()->back()->withErrors(['birthdate' => 'No matching record found for this birthdate.']);
        }

        if ($user) {
            // Store the user ID in the session for resetting the password
            Session::put('user_id', $user->id);
            // return redirect()->route('password.reset.custom');  // Redirect to password reset form
            return view('auth.reset_password_form');
        }

        return redirect()->back()->withErrors(['birthdate' => 'No user found with this birthdate.']);
    }

    public function showResetForm()
    {
        $parentall = Page::where('active', 1)->orderBy('serial', 'asc')->get();
        $parents = $parentall->where('parent_id', 0);
        $pages = self::tree($parents, $parentall);
        return view('auth.reset_password_form', compact('pages'));
    }

    public function resetPassword(Request $request)
    {
        // Validate the new password and confirmation
        $request->validate([
            'new_password' => 'required|confirmed',
        ]);

        // Retrieve the user ID from session
        $user_id = Session::get('user_id');

        if (!$user_id) {
            return redirect()->route('login')->withErrors(['error' => 'Session expired, please try again']);
        }

        // Find the user and update the password
        $user = User::find($user_id);
        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'User not found']);
        }

        $user->password = $request->new_password;
        $user->password_text = $request->new_password;
        $user->save();

        // Clear session and redirect to login
        Session::forget('user_id');

        return redirect()->route('login')->with('status', 'Password reset successfully, please log in');
    }
}
