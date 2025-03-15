<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestModel; // Import the model

class RequestsController extends Controller
{
    public function index()
    {
        $requests = RequestModel::all(); // Fetch all requests
        return view('admin.Requests.index', compact('requests'));
    }

    public function update(Request $request, $requestID)
    {
        $request->validate([
            'status' => 'required|string',
            'priority' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $requestData = RequestModel::findOrFail($requestID);
        $requestData->update([
            'status' => $request->status,
            'priority' => $request->priority,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Request updated successfully!');
    }
}
