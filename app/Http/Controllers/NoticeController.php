<?php

namespace App\Http\Controllers;

use App\Models\Website\Notice;
use App\Models\Website\NoticeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 10) {
            return 1;
        }
        Session::put('activemenu', 'website');
        Session::put('activesubmenu', 'no');
        $notices = Notice::with('type')
            ->orderBy('id', 'desc')
            ->get();
        return view('website.notice.index', compact('notices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 10 && Auth::user()->group_id != 6) {
            return 1;
        }
        Session::put('activemenu', 'website');
        Session::put('activesubmenu', 'no');
        $types = NoticeType::get();
        return view('website.notice.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 10 && Auth::user()->group_id != 6) {
            return 1;
        }
        $image = "";

        if ($request->hasFile('pdf')) {
            // Validate the file
            $request->validate([
                'pdf' => 'nullable|mimes:jpg,jpeg,pdf|max:2048',
            ]);

            // Delete the old photo if it exists
            if (!empty($request->file_old) && file_exists(public_path('notice/' . basename($request->file_old)))) {
                unlink(public_path('notice/' . basename($request->file_old)));
            }

            // Save the new photo
            $destinationPath = 'notice';
            $myimage = $request->id . '_' . $request->pdf->getClientOriginalName();
            $request->pdf->move(public_path($destinationPath), $myimage);

            // Generate the full URL path for the photo
            $image = url('public/' . $destinationPath . '/' . $myimage);
        } else {
            // If no new photo uploaded, retain the old photo
            $image = $request->file_old;
        }

        if ($request->id != 0) {
            $notice = Notice::find($request->id);
            $notice->type_id = $request->type_id;
            $notice->is_notice = $request->is_notice;
            $notice->title = $request->title;
            $notice->details = $request->details;
            $notice->image = $image;
            $notice->active = $request->active;
            $notice->validity_date = $request->validity_date;
            $notice->publish_date = $request->publish_date;
            $notice->update();
            $text = 'Notice has been update successfully';
        } else {
            $notice = new Notice;
            $notice->type_id = $request->type_id;
            $notice->title = $request->title;
            $notice->details = $request->details;
            $notice->image = $image;
            $notice->active = $request->active;
            $notice->validity_date = $request->validity_date;
            $notice->publish_date = $request->publish_date;
            $notice->save();
            $text = 'Notice has been create successfully';
        }
        return redirect()->route('notice.index')->with('success', $text);
    }



    /**
     * Display the specified resource.
     */
    public function show(Notice $notice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notice $notice)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 10 && Auth::user()->group_id != 6) {
            return 1;
        }
        Session::put('activemenu', 'website');
        Session::put('activesubmenu', 'no');
        $types = NoticeType::get();
        return view('website.notice.create', compact('types', 'notice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notice $notice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notice $notice)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 10 && Auth::user()->group_id != 6) {
            return 1;
        }
        try {
            $notice->delete();
            return 1;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
