<?php

namespace App\Http\Controllers;

use App\Models\sttings\Sessions;
use App\Models\YearCalendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class YearCalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        Session::put('activemenu', 'activity');
        Session::put('activesubmenu', 'yc');
        $sessions = Sessions::where('active', '1')->first();
        $YearCalendars = YearCalendar::with('session')->where('year', $sessions->id)->get();
        return view('activity.yearcalendar.index', compact('YearCalendars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        Session::put('activemenu', 'activity');
        Session::put('activesubmenu', 'yc');
        $sessions = Sessions::where('active', 1)->get();
        return view('activity.yearcalendar.create', compact('sessions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        if ($request->id != 0) {
            $YearCalendar = YearCalendar::find($request->id);
            $YearCalendar->year = $request->year;
            $YearCalendar->is_exam_date = $request->is_exam_date;
            $YearCalendar->title = $request->title;
            $YearCalendar->title_bn = $request->title_bn;
            $YearCalendar->short_title = $request->short_title;
            $YearCalendar->short_title_bn = $request->short_title_bn;
            $YearCalendar->start_date = $request->start_date;
            $YearCalendar->end_date = $request->end_date;
            $YearCalendar->number_of_days = $request->number_of_days;
            $YearCalendar->update();
            $text = 'Year Calendar has been update successfully';
        } else {
            $YearCalendar = new YearCalendar;
            $YearCalendar->year = $request->year;
            $YearCalendar->is_exam_date = $request->is_exam_date;
            $YearCalendar->title = $request->title;
            $YearCalendar->title_bn = $request->title_bn;
            $YearCalendar->short_title = $request->short_title;
            $YearCalendar->short_title_bn = $request->short_title_bn;
            $YearCalendar->start_date = $request->start_date;
            $YearCalendar->end_date = $request->end_date;
            $YearCalendar->number_of_days = $request->number_of_days;
            $YearCalendar->save();
            $text = 'Year Calendar has been create successfully';
        }
        return redirect()->route('year-calendar.index')->with('success', $text);
    }

    /**
     * Display the specified resource.
     */
    public function show(YearCalendar $yearCalendar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(YearCalendar $yearCalendar)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        Session::put('activemenu', 'activity');
        Session::put('activesubmenu', 'yc');
        $sessions = Sessions::where('active', 1)->get();
        return view('activity.yearcalendar.create', compact('yearCalendar', 'sessions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, YearCalendar $yearCalendar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(YearCalendar $yearCalendar)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        try {
            $yearCalendar->delete();
            return 1;
        } catch (\Exception $e) {
            return $e;
        }
    }
}