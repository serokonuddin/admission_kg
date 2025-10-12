<?php

namespace App\Http\Controllers;

use App\Models\sttings\Versions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class VersionsController extends Controller
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
        Session::put('activesubmenu', 'vr');
        $versions = Versions::all();
        return view('setting.version', compact('versions'));
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
                    'version_name' => 'required|unique:Versions,version_name',
                    'version_code' => 'required|unique:Versions,version_code',
                    'active' => 'required',
                ]);
                Versions::insert($validated);
                $sms = "Successfully Inserted";
            } else {
                $validated = $request->validate([
                    'version_name' => 'required|unique:Versions,version_name,' . $request->id,
                    'version_code' => 'required|unique:Versions,version_code,' . $request->id,
                    'active' => 'required',
                ]);
                Versions::where('id', $id)->update($validated);
                $sms = "Successfully Updated";
            }
            return redirect(route('version.index'))->with('success', $sms);
        } catch (Exception $e) {

            return redirect(route('version.index'))->with(['msg' => $e]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Versions $versions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Versions $versions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Versions $versions)
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
            $versions = Versions::find($id);
            $versions->delete();
            return 1;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
