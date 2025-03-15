<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestModel; // Your request model
use App\Models\UserReport; // Your report model
use App\Models\User; // Assuming you have a User model for total users

class DashboardController extends Controller
{
    public function showDashboard()
    {
        // Retrieving data for service requests
        $totalRequests = RequestModel::count();
        $pendingRequests = RequestModel::where('status', 'pending')->count();
        $approvedRequests = RequestModel::where('status', 'approved')->count();
        $rejectedRequests = RequestModel::where('status', 'rejected')->count();

        // Retrieving data for user reports
        $totalReports = UserReport::count();
        $pendingReports = UserReport::where('status', 'pending')->count();
        $reviewedReports = UserReport::where('status', 'reviewed')->count();
        $rejectedReports = UserReport::where('status', 'rejected')->count();

        // Retrieving data for users
        $totalUsers = User::count();
        $newUsers = User::where('created_at', '>=', now()->startOfMonth())->count();


        // Query user logins (assuming you have a `logins` table or use `auth()->user()->last_login`)
        $userLogins = User::selectRaw('DATE(created_at) as date, count(*) as logins')
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->take(30) // Fetch last 30 days (you can change this period)
        ->pluck('logins', 'date');

        $loginDates = $userLogins->keys();
        $loginCounts = $userLogins->values();

        // Pass data to the view
        return view('admin.dashboard', compact(
        'totalRequests', 'pendingRequests', 'approvedRequests', 'rejectedRequests',
        'totalReports', 'pendingReports', 'reviewedReports', 'rejectedReports',
        'totalUsers', 'newUsers', 'loginDates', 'loginCounts'
));
}
    }

