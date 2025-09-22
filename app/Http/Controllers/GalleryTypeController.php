<?php

namespace App\Http\Controllers;

use App\Models\Website\GalleryType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class GalleryTypeController extends Controller
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
        Session::put('activesubmenu', 'gt');
        $types = GalleryType::all();
        return view('website.gallery.indextype', compact('types'));
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
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 10) {
            return 1;
        }
        $id = $request->id;
        try {

            if ($id == 0) {
                $validated = $request->validate([
                    'title' => 'required',
                ]);
                GalleryType::insert($validated);
                $sms = "Successfully Inserted";
            } else {
                $validated = $request->validate([
                    'title' => 'required',
                ]);
                GalleryType::where('id', $id)->update($validated);
                $sms = "Successfully Updated";
            }
            return redirect(route('gallery-type.index'))->with('success', $sms);
        } catch (Exception $e) {

            return redirect(route('gallery-type.index'))->with(['msg' => $e]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(GalleryType $galleryType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GalleryType $galleryType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GalleryType $galleryType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GalleryType $galleryType)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 10) {
            return 1;
        }
        try {
            $galleryType->delete();
            return 1;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
