<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Session;

class DocumentController extends Controller
{
    public function index()
    {

        Session::put('activemenu', 'leave');
        Session::put('activesubmenu', 'lv');
        // $documents = Document::with('position.desination')->where('document_for', 5)->where('ref_id', Auth::user()->ref_id)->orderBy('id', 'desc')->get();
        // return view('documents.index', compact('documents'));
        return view('under-development', ['name' => 'Leave']);
    }

    public function create()
    {
        // return view('documents.create');
        Session::put('activemenu', 'leave');
        Session::put('activesubmenu', 'lva');
        return view('under-development', ['name' => 'Leave Application']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'session_id' => 'required|integer',
            'document_for' => 'required|integer',
            'subject' => 'required|string|max:1024',
            'details' => 'required|string',
            'ref_id' => 'required|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'date' => 'required|date',
            'attach_file' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'status' => 'required|integer',
            'created_by' => 'required|integer',
        ]);

        if ($request->hasFile('attach_file')) {
            $validated['attach_file'] = $request->file('attach_file')->store('documents');
        } else {
            $validated['attach_file'] = $request->old_attach_file;
        }
        //dd($validated['attach_file']);
        if ($request->id == 0) {
            Document::create($validated);
        } else {
            $validated['updated_by'] = Auth::user()->id;
            $validated['updated_at'] = date('Y-m-d H:i:s');
            Document::where('id', $request->id)->update($validated);
        }


        return redirect()->route('documents.index')->with('success', 'Document created successfully.');
    }

    public function edit(Document $document)
    {
        return view('documents.edit', compact('document'));
    }

    public function update(Request $request, Document $document)
    {
        $validated = $request->validate([
            'session_id' => 'required|integer',
            'document_for' => 'required|integer',
            'subject' => 'required|string|max:1024',
            'details' => 'required|string',
            'ref_id' => 'required|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'date' => 'required|date',
            'attach_file' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'status' => 'required|integer',
            'created_by' => 'required|integer',
        ]);

        if ($request->hasFile('attach_file')) {
            $validated['attach_file'] = $request->file('attach_file')->store('documents');
        } else {
            $validated['attach_file'] = $request->old_attach_file;
        }

        $document->update($validated);

        return redirect()->route('documents.index')->with('success', 'Document updated successfully.');
    }

    public function destroy(Document $document)
    {
        $document->delete();
        return redirect()->route('documents.index')->with('success', 'Document deleted successfully.');
    }
}
