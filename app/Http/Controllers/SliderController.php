<?php

namespace App\Http\Controllers;

use App\Models\Website\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        Session::put('activemenu', 'website');
        Session::put('activesubmenu', 'sl');
        $sliders = Slider::all();
        return view('website.slider.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

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
                    'title' => 'required',
                    'image' => 'required',
                    'active' => 'required',
                    'serial' => 'required',
                ]);
                Slider::insert($validated);
                $sms = "Successfully Inserted";
            } else {
                $validated = $request->validate([
                    'title' => 'required',
                    'image' => 'required',
                    'active' => 'required',
                    'serial' => 'required',
                ]);
                Slider::where('id', $id)->update($validated);
                $sms = "Successfully Updated";
            }
            return redirect(route('slider.index'))->with('success', $sms);
        } catch (\Exception $e) {

            return redirect(route('slider.index'))->with(['msg' => $e]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        try {
            $slider->delete();
            return 1;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
