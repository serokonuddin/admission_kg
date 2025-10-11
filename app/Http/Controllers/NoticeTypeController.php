<?php

namespace App\Http\Controllers;

use App\Models\Website\NoticeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class NoticeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 10 && Auth::user()->group_id != 6) {
            return 1;
        }
        Session::put('activemenu', 'website');
        Session::put('activesubmenu', 'nt');
        $types = NoticeType::all();
        return view('website.notice.indextype', compact('types'));
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
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 10 && Auth::user()->group_id != 6) {
            return 1;
        }
        $id = $request->id;
        try {

            if ($id == 0) {
                $validated = $request->validate([
                    'title' => 'required',
                ]);
                NoticeType::insert($validated);
                $sms = "Successfully Inserted";
            } else {
                $validated = $request->validate([
                    'title' => 'required',
                ]);
                NoticeType::where('id', $id)->update($validated);
                $sms = "Successfully Updated";
            }
            return redirect(route('notice-type.index'))->with('success', $sms);
        } catch (Exception $e) {

            return redirect(route('notice-type.index'))->with(['msg' => $e]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(NoticeType $noticeType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NoticeType $noticeType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NoticeType $noticeType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NoticeType $noticeType)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 10 && Auth::user()->group_id != 6) {
            return 1;
        }
        try {
            $noticeType->delete();
            return 1;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
