<?php

namespace App\Http\Controllers;

use App\Models\Website\GalleryType;
use App\Models\Website\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class GalleryController extends Controller
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
        Session::put('activesubmenu', 'ga');
        $galleries = Gallery::with('type')->get();
        return view('website.gallery.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 10) {
            return 1;
        }
        Session::put('activemenu', 'website');
        Session::put('activesubmenu', 'ga');
        $types = GalleryType::get();
        return view('website.gallery.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 10) {
            return 1;
        }
        if ($request->id != 0) {
            $Gallery = Gallery::find($request->id);
            $Gallery->type_id = $request->type_id;
            $Gallery->title = $request->title;
            $Gallery->details = $request->details;
            $Gallery->file = $request->file;
            $Gallery->active = $request->active;
            $Gallery->publish_date = $request->publish_date;
            $Gallery->update();
            $text = 'Gallery has been update successfully';
        } else {
            $Gallery = new Gallery;
            $Gallery->type_id = $request->type_id;
            $Gallery->title = $request->title;
            $Gallery->details = $request->details;
            $Gallery->file = $request->file;
            $Gallery->active = $request->active;
            $Gallery->publish_date = $request->publish_date;
            $Gallery->save();
            $text = 'Gallery has been create successfully';
        }
        return redirect()->route('gallery.index')->with('success', $text);
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 10) {
            return 1;
        }
        Session::put('activemenu', 'website');
        Session::put('activesubmenu', 'ga');
        $types = GalleryType::get();
        return view('website.gallery.create', compact('types', 'gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 10) {
            return 1;
        }
        try {
            $gallery->delete();
            return 1;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
