<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->hasRole('instructor')) {
            // Dashboard khusus untuk instructor
            $totalCourses = \App\Models\Course::where('instructor', $user->name)->count();
            $totalUsers = null; // Hidden untuk instructor
            $totalEnrollments = null; // Hidden untuk instructor
            $pendingPayments = null; // Hidden untuk instructor
            
            // Get enrollments hanya untuk course instructor tersebut
            $recentEnrollments = \App\Models\Enrollment::with(['user', 'course'])
                ->whereHas('course', function($query) use ($user) {
                    $query->where('instructor', $user->name);
                })
                ->latest()
                ->take(5)
                ->get();
                
        } elseif ($user->hasRole('content-manager')) {
            // Dashboard khusus untuk content manager
            $totalCourses = null; // Hidden untuk content manager
            $totalUsers = null; // Hidden untuk content manager
            $totalEnrollments = null; // Hidden untuk content manager
            $pendingPayments = null; // Hidden untuk content manager
            
            // Get recent enrollments - tidak ada untuk content manager
            $recentEnrollments = collect();
            
        } else {
            // Dashboard untuk admin (data lengkap)
            $totalCourses = \App\Models\Course::count();
            $totalUsers = \App\Models\User::count();
            $totalEnrollments = \App\Models\Enrollment::count();
            $pendingPayments = \App\Models\Enrollment::where('payment_status', 'pending')->count();
            
            // Get recent enrollments
            $recentEnrollments = \App\Models\Enrollment::with(['user', 'course'])
                ->latest()
                ->take(5)
                ->get();
        }
        
        // Get article data for content manager
        $totalArticles = null;
        $recentArticles = collect();
        
        if ($user->hasRole('content-manager')) {
            $totalArticles = \App\Models\Article::count();
            $recentArticles = \App\Models\Article::latest()->take(5)->get();
        }
        
        return view('admin.dashboard', compact(
            'totalCourses',
            'totalUsers',
            'totalEnrollments',
            'pendingPayments',
            'recentEnrollments',
            'totalArticles',
            'recentArticles'
        ));
    }
}
