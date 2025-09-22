<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Website\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PasswordChangeController extends Controller
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

    public function showChangePasswordForm()
    {
        $parentall = Page::where('active', 1)->orderBy('serial', 'asc')->get();
        $parents = $parentall->where('parent_id', 0);
        $pages = self::tree($parents, $parentall);
        return view('auth.change-password', compact('pages'));
    }

    public function changePassword(Request $request)
    {
        // Validate the request
        $request->validate([
            'current_password' => 'required',
            'new_password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&#]/',
            ],
            'new_password_confirmation' => 'required|same:new_password',
        ]);

        $current_user = Auth::user();
        // dd($current_user);

        // Check if the provided current password is correct
        if (Hash::check($request->current_password, $current_user->password)) {

            // $current_user->update([
            //     'password' => Hash::make($request->new_password),
            // ]);
            $current_user->password = $request->new_password;
            $current_user->password_text = $request->new_password;
            $current_user->save();

            return redirect()->route('dashboard')->with('success', 'Password changed successfully.');
        } else {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }
    }
}
