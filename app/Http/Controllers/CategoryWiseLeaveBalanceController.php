<?php

namespace App\Http\Controllers;

use App\Models\CategoryWiseLeaveBalance;
use Illuminate\Http\Request;

class CategoryWiseLeaveBalanceController extends Controller
{
    public function index()
    {
        $balances = CategoryWiseLeaveBalance::all();
        return view('category_wise_leave_balance.index', compact('balances'));
    }

    public function create()
    {
        return view('category_wise_leave_balance.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'session_id' => 'required|integer',
            'category_id' => 'required|integer',
            'yearly_total' => 'required|integer',
            'status' => 'required|integer',
            'created_by' => 'required|integer',
        ]);

        CategoryWiseLeaveBalance::create($validated);

        return redirect()->route('category_wise_leave_balance.index')->with('success', 'Record created successfully.');
    }

    public function edit(CategoryWiseLeaveBalance $categoryWiseLeaveBalance)
    {
        return view('category_wise_leave_balance.edit', compact('categoryWiseLeaveBalance'));
    }

    public function update(Request $request, CategoryWiseLeaveBalance $categoryWiseLeaveBalance)
    {
        $validated = $request->validate([
            'session_id' => 'required|integer',
            'category_id' => 'required|integer',
            'yearly_total' => 'required|integer',
            'status' => 'required|integer',
            'updated_by' => 'required|integer',
        ]);

        $categoryWiseLeaveBalance->update($validated);

        return redirect()->route('category_wise_leave_balance.index')->with('success', 'Record updated successfully.');
    }

    public function destroy(CategoryWiseLeaveBalance $categoryWiseLeaveBalance)
    {
        $categoryWiseLeaveBalance->delete();

        return redirect()->route('category_wise_leave_balance.index')->with('success', 'Record deleted successfully.');
    }
}

