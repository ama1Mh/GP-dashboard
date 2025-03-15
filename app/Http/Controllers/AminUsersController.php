<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AminUser; // Make sure to import the correct model

class AminUsersController extends Controller
{
    public function index()
    {
        $users = AminUser::all(); // Fetch all records from aminusers table
        return view('admin.AminUsers.index', compact('users'));
    }

    public function update(Request $request, $userID)
{
    // Validate the request
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
    ]);

    // Find the user and update
    $user = AminUser::findOrFail($userID);
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
    ]);

    return redirect()->back()->with('success', 'User updated successfully!');
}
}