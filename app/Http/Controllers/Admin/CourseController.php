<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with('category')->latest()->paginate(10);
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = CourseCategory::orderBy('name')->get();

        return view('admin.courses.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:courses,slug',
            'instructor' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|integer|min:0',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'trailer_video_id' => 'required|string',
            'full_video_ids' => 'nullable|string',
            'course_category_id' => 'required|exists:course_categories,id',
            'level' => 'required|in:Beginner,Intermediate,Advanced',
        ]);

        $thumbnail = 'default-course.jpg';
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail')->store('courses', 'public');
        }

        $fullVideoIds = $data['full_video_ids']
            ? array_filter(array_map('trim', explode(',', $data['full_video_ids'])))
            : [];

        Course::create([
            'title' => $data['title'],
            'slug' => $data['slug'] ?? null,
            'instructor' => $data['instructor'],
            'description' => $data['description'],
            'price' => $data['price'],
            'thumbnail' => $thumbnail,
            'trailer_video_id' => $data['trailer_video_id'],
            'full_video_ids' => $fullVideoIds,
            'course_category_id' => $data['course_category_id'],
            'level' => $data['level'],
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = Course::with('category')->findOrFail($id);
        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $course = Course::with('category')->findOrFail($id);
        $categories = CourseCategory::orderBy('name')->get();

        return view('admin.courses.edit', compact('course', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $course = Course::findOrFail($id);
        
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:courses,slug,' . $course->id,
            'instructor' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|integer|min:0',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'trailer_video_id' => 'required|string',
            'full_video_ids' => 'nullable|string',
            'course_category_id' => 'required|exists:course_categories,id',
            'level' => 'required|in:Beginner,Intermediate,Advanced',
        ]);

        $payload = [
            'title' => $data['title'],
            'slug' => $data['slug'] ?? null,
            'instructor' => $data['instructor'],
            'description' => $data['description'],
            'price' => $data['price'],
            'trailer_video_id' => $data['trailer_video_id'],
            'course_category_id' => $data['course_category_id'],
            'level' => $data['level'],
        ];

        if ($request->hasFile('thumbnail')) {
            $payload['thumbnail'] = $request->file('thumbnail')->store('courses', 'public');
        }

        $fullVideoIds = $data['full_video_ids']
            ? array_filter(array_map('trim', explode(',', $data['full_video_ids'])))
            : [];
        $payload['full_video_ids'] = $fullVideoIds;

        $course->update($payload);

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully.');
    }
}
