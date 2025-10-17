<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ArticleController; // Add import for ArticleController
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\LessonController as AdminLessonController;
use App\Http\Controllers\Admin\ArticleCategoryController as AdminArticleCategoryController;
use App\Http\Controllers\Admin\CourseCategoryController as AdminCourseCategoryController;
use App\Http\Controllers\Admin\TagController as AdminTagController;
use App\Http\Controllers\ProfileController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/course/{slug}', [CourseController::class, 'show'])->name('course.show');
Route::post('/course/{slug}/enroll', [CourseController::class, 'enroll'])->name('course.enroll');
Route::get('/article/{slug}', [HomeController::class, 'showArticle'])->name('article.show');
Route::get('/articles', [ArticleController::class, 'index'])->name('article.index'); // Add route for articles index page
Route::get('/articles/load-more', [ArticleController::class, 'loadMore'])->name('article.load-more'); // Add route for loading more articles
Route::get('/articles/category/{slug}', [ArticleController::class, 'showByCategory'])->name('article.category'); // Add route for articles by category
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile management routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

    Route::post('/attachments', function (Request $request) {
        $request->validate([
            'attachment' => ['required', 'file', 'mimes:jpg,jpeg,png,gif,webp,svg', 'max:5120'],
        ]);

        $path = $request->file('attachment')->store('trix-attachments', 'public');

        return [
            'image_url' => '/storage/'.$path,
        ];
    })->name('attachments.store');
});

// Admin routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Routes that require admin panel access
    Route::middleware('can:access admin panel')->name('admin.')->group(function () {
        // Course management routes
        Route::middleware('can:view courses')->group(function () {
            Route::resource('courses', AdminCourseController::class);
        });
        
        // Course category management
        Route::middleware('can:view course categories')->group(function () {
            Route::resource('course-categories', AdminCourseCategoryController::class)->except(['show']);
        });
        
        // Lesson management
        Route::middleware('can:view lessons')->group(function () {
            Route::resource('lessons', AdminLessonController::class);
        });
        
        // User management - only for admins
        Route::middleware('can:view users')->group(function () {
            Route::resource('users', AdminUserController::class);
        });
        
        // Payment management
        Route::middleware('can:manage enrollments')->group(function () {
            Route::get('payments', [AdminPaymentController::class, 'index'])->name('payments.index');
            Route::post('payments/approve/{id}', [AdminPaymentController::class, 'approve'])->name('payments.approve');
        });
        
        // Article management
        Route::middleware('can:view articles')->group(function () {
            Route::resource('articles', AdminArticleController::class);
        });
        
        // Article category management
        Route::middleware('can:view article categories')->group(function () {
            Route::resource('article-categories', AdminArticleCategoryController::class)->except(['show']);
        });
        
        // Tag management
        Route::middleware('can:view tags')->group(function () {
            Route::resource('tags', AdminTagController::class)->except(['show']);
        });
    });
});
