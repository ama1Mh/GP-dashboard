<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserReport; // Ensure you have the correct model

class UserReportsController extends Controller
{
    public function index()
    {
        $reports = UserReport::all(); // Fetch all user reports
        return view('admin.UserReports.index', compact('reports'));
    }

    public function update(Request $request, $reportID)
    {
        $request->validate([
            'status' => 'required|string|max:255',
        ]);

        $report = UserReport::findOrFail($reportID);
        $report->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Report updated successfully!');
    }
}
