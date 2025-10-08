<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCourses = \App\Models\Course::count();
        $totalUsers = \App\Models\User::count();
        $totalEnrollments = \App\Models\Enrollment::count();
        $pendingPayments = \App\Models\Enrollment::where('payment_status', 'pending')->count();
        
        // Get recent enrollments
        $recentEnrollments = \App\Models\Enrollment::with(['user', 'course'])
            ->latest()
            ->take(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalCourses',
            'totalUsers',
            'totalEnrollments',
            'pendingPayments',
            'recentEnrollments'
        ));
    }
}
