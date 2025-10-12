<?php

namespace App\Http\Controllers;

use App\Models\sttings\Sessions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SessionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        Session::put('activemenu', 'setting');
        Session::put('activesubmenu', 'se');
        $sessions = Sessions::all();
        return view('setting.session', compact('sessions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        $id = $request->id;
        try {

            if ($id == 0) {

                $validated = $request->validate([
                    'session_name' => 'required|unique:Sessions',
                    'session_code' => 'required',
                    'active' => 'required',
                ]);
            } else {
                $validated = $request->validate([
                    'session_name' => 'required|unique:Sessions,session_code,' . $request->id,
                    'session_code' => 'required',
                    'active' => 'required',
                ]);
            }


            if ($id == 0) {

                Sessions::insert($validated);
                $sms = "Successfully Inserted";
            } else {

                Sessions::where('id', $id)->update($validated);
                $sms = "Successfully Updated";
            }
            return redirect(route('session.index'))->with('success', $sms);
        } catch (Exception $e) {

            return redirect(route('session.index'))->with(['msg' => $e]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sessions $sessions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sessions $sessions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sessions $sessions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        try {
            $Sessions = Sessions::find($id);
            $Sessions->delete();
            return 1;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
