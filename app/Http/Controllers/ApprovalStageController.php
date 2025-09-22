<?php

namespace App\Http\Controllers;

use App\Models\ApprovalStage;
use Illuminate\Http\Request;

class ApprovalStageController extends Controller
{
    public function index()
    {
        $stages = ApprovalStage::all();
        return view('approval_stage.index', compact('stages'));
    }

    public function create()
    {
        return view('approval_stage.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'session_id' => 'required|integer',
            'approval_for' => 'required|integer',
            'designation_id' => 'required|integer',
            'level' => 'required|integer',
            'is_approved' => 'required|integer',
            'status' => 'required|integer',
            'created_by' => 'required|integer',
        ]);

        ApprovalStage::create($validated);

        return redirect()->route('approval_stage.index')->with('success', 'Approval Stage created successfully.');
    }

    public function show(ApprovalStage $approvalStage)
    {
        return view('approval_stage.show', compact('approvalStage'));
    }

    public function edit(ApprovalStage $approvalStage)
    {
        return view('approval_stage.edit', compact('approvalStage'));
    }

    public function update(Request $request, ApprovalStage $approvalStage)
    {
        $validated = $request->validate([
            'session_id' => 'required|integer',
            'approval_for' => 'required|integer',
            'designation_id' => 'required|integer',
            'level' => 'required|integer',
            'is_approved' => 'required|integer',
            'status' => 'required|integer',
            'updated_by' => 'required|integer',
        ]);

        $approvalStage->update($validated);

        return redirect()->route('approval_stage.index')->with('success', 'Approval Stage updated successfully.');
    }

    public function destroy(ApprovalStage $approvalStage)
    {
        $approvalStage->delete();

        return redirect()->route('approval_stage.index')->with('success', 'Approval Stage deleted successfully.');
    }
}

