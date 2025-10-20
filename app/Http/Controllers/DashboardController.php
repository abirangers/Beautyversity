<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Enrollment;
use App\Models\Course;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Only students can access /dashboard
        if (!$user->hasRole('student')) {
            return redirect()->route('admin.dashboard');
        }
        
        $courses = $user->enrolledCourses;

        return view('dashboard.index', compact('user', 'courses'));
    }
}
