<?php

namespace App\Http\Controllers;

use App\Models\Website\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 10 && Auth::user()->group_id != 6) {
            return 1;
        }
        Session::put('activemenu', 'website');
        Session::put('activesubmenu', 'pg');
        $pagedata = Page::orderBy('serial', 'asc')->get();

        $parents = $pagedata->where('parent_id', 0);
        $pages = self::tree($parents, $pagedata);


        return view('website.pages.index', compact('pages'));
    }

    public function tree($items, $all_items)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 10 && Auth::user()->group_id != 6) {
            return 1;
        }
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 10 && Auth::user()->group_id != 6) {
            return 1;
        }
        $pageies = Page::where('is_parent', 1)->get();
        return view('website.pages.create', compact('pageies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 10 && Auth::user()->group_id != 6) {
            return 1;
        }
        if ($request->id != 0) {
            $pages = Page::find($request->id);
            $pages->parent_id = $request->parent_id;
            $pages->title = $request->title;
            $pages->slug = $request->slug;
            $pages->details = $request->details;
            $pages->active = $request->active;
            $pages->serial = $request->serial;
            $pages->images = $request->images;
            $pages->is_parent = $request->is_parent;
            $pages->update();
            $text = 'Pages has been update successfully';
        } else {
            $pages = new Page;
            $pages->parent_id = $request->parent_id;
            $pages->title = $request->title;
            $pages->slug = $request->slug;
            $pages->details = $request->details;
            $pages->active = $request->active;
            $pages->serial = $request->serial;
            $pages->images = $request->images;
            $pages->is_parent = $request->is_parent;
            $pages->save();
            $text = 'Pages has been create successfully';
        }
        return redirect()->route('pages.index')->with('success', $text);
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 10 && Auth::user()->group_id != 6) {
            return 1;
        }
        $pageies = Page::where('is_parent', 1)->get();
        return view('website.pages.create', compact('pageies', 'page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        if (Auth::user()->group_id != 2 && Auth::user()->group_id != 10 && Auth::user()->group_id != 6) {
            return 1;
        }
        try {
            $page->delete();
            return 1;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
