<?php

namespace App\Http\Controllers;

use App\Models\sttings\Classes;
use App\Models\sttings\Shifts;
use App\Models\sttings\Versions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ClassesController extends Controller
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
        Session::put('activesubmenu', 'cl');
        $shifts = Shifts::where('active', 1)->get();
        $versions = Versions::where('active', 1)->get();
        $classvalue = Classes::with('shift')->where('active', 1)->get();
        return view('setting.classes', compact('classvalue', 'shifts', 'versions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function getTypeWiseClass(Request $request)
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        if ($request->type == 'college') {
            $class_for = 3;
            $classvalue = array(
                [
                    'id' => '11',
                    'class_id' => '11',
                    'class_code' => '11',
                    'class_name' => 'XI - Eleven',
                ],
                [
                    'id' => '12',
                    'class_id' => '12',
                    'class_code' => '12',
                    'class_name' => 'XII - Twelve',
                ]
            );
        } elseif ($request->type == 'secondary') {
            $class_for = 2;
            $classvalue = array(
                [
                    'id' => '6',
                    'class_id' => '6',
                    'class_code' => '6',
                    'class_name' => 'VI - Six',
                ],
                [
                    'id' => '7',
                    'class_id' => '7',
                    'class_code' => '7',
                    'class_name' => 'VII - Seven',
                ],
                [
                    'id' => '8',
                    'class_id' => '8',
                    'class_code' => '8',
                    'class_name' => 'VIII - Eight',
                ],
                [
                    'id' => '9',
                    'class_id' => '9',
                    'class_code' => '9',
                    'class_name' => 'IX - Nine',
                ],
                [
                    'id' => '10',
                    'class_id' => '10',
                    'class_code' => '10',
                    'class_name' => 'X - Ten',
                ]
            );
        } else {
            $class_for = 1;
            $classvalue = array(
                [
                    'id' => '0',
                    'class_id' => '0',
                    'class_code' => '0',
                    'class_name' => 'KG',
                ],
                [
                    'id' => '1',
                    'class_id' => '1',
                    'class_code' => '1',
                    'class_name' => 'I - One',
                ],
                [
                    'id' => '2',
                    'class_id' => '2',
                    'class_code' => '2',
                    'class_name' => 'II - Two',
                ],
                [
                    'id' => '3',
                    'class_id' => '3',
                    'class_code' => '3',
                    'class_name' => 'III - Three',
                ],
                [
                    'id' => '4',
                    'class_id' => '4',
                    'class_code' => '4',
                    'class_name' => 'IV - Four',
                ],
                [
                    'id' => '5',
                    'class_id' => '5',
                    'class_code' => '5',
                    'class_name' => 'V - Five',
                ]
            );
        }
        $version_id = $request->version_id;
        $shift_id = $request->shift_id;
        // $classvalue=Classes::where('active',1)->where('shift_id',$shift_id)->where('version_id',$version_id)->where('class_for',$class_for)->get();
        return view('setting.ajaxclasses', compact('classvalue'));
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

            $validated = $request->validate([
                'class_name' => 'required',
                'class_code' => 'required',
                'active' => 'required',
                'shift_id' => 'required',
                'version_id' => 'required',
                'class_for' => 'required',
            ]);





            if ($id == 0) {

                Classes::insert($validated);
                $sms = "Successfully Inserted";
            } else {

                Classes::where('id', $id)->update($validated);
                $sms = "Successfully Updated";
            }
            return redirect(route('classes.index'))->with('success', $sms);
        } catch (\Exception $e) {

            return redirect(route('classes.index'))->with(['msg' => $e]);
        }
    }

    /**
     * Display the specified resource.
     */
    // public function getClass(Request $request)
    // {
    //     $version_id = $request->version_id;
    //     $shift_id = $request->shift_id;

    //     $class_for = Auth::user()->class_id;


    //     $classvalue = Classes::where('active', 1)
    //         ->where('shift_id', $shift_id)
    //         ->where('version_id', $version_id)
    //         ->orderByRaw("CAST(class_code AS UNSIGNED)") // Ensures proper numeric sorting
    //         ->get();

    //     return view('setting.ajaxclasses', compact('classvalue'));
    // }
    public function getClass(Request $request)
    {
        // if(Auth::user()->group_id!=2){
        //     return 1;
        // }
        $version_id = $request->version_id;
        $shift_id = $request->shift_id;

        $class_for = Auth::user()->class_id;

        // Determine the class codes based on class_for value
        $class_codes = [];
        if ($class_for == 1) {
            $class_codes = [0, 1, 2, 3, 4, 5];
        } elseif ($class_for == 2) {
            $class_codes = [6, 7, 8, 9, 10];
        } elseif ($class_for == 3) {
            $class_codes = [11, 12];
        } elseif ($class_for == 4) {
            $class_codes = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        } else {
            $class_codes = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        }

        // Fetch classes based on the determined class codes
        $classvalue = Classes::where('active', 1)
            ->where('shift_id', $shift_id)
            ->where('version_id', $version_id)
            ->whereIn('class_code', $class_codes) // Filter by the class codes
            ->orderByRaw("CAST(class_code AS UNSIGNED)") // Ensures proper numeric sorting
            ->get();

        return view('setting.ajaxclasses', compact('classvalue'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classes $classes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classes $classes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classes $classes)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        try {
            $classes->delete();
            return 1;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
