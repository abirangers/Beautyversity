<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseCategoryController extends Controller
{
    public function index()
    {
        $categories = CourseCategory::withCount('courses')->latest()->paginate(10);

        return view('admin.course-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.course-categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:course_categories,name',
            'slug' => 'nullable|string|max:255|unique:course_categories,slug',
            'description' => 'nullable|string',
        ]);

        $data['slug'] = Str::slug($data['slug'] ?? $data['name']);

        CourseCategory::create($data);

        return redirect()->route('admin.course-categories.index')->with('success', 'Course category created successfully.');
    }

    public function edit(CourseCategory $courseCategory)
    {
        return view('admin.course-categories.edit', [
            'category' => $courseCategory,
        ]);
    }

    public function update(Request $request, CourseCategory $courseCategory)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:course_categories,name,' . $courseCategory->id,
            'slug' => 'nullable|string|max:255|unique:course_categories,slug,' . $courseCategory->id,
            'description' => 'nullable|string',
        ]);

        $data['slug'] = Str::slug($data['slug'] ?? $data['name']);

        $courseCategory->update($data);

        return redirect()->route('admin.course-categories.index')->with('success', 'Course category updated successfully.');
    }

    public function destroy(CourseCategory $courseCategory)
    {
        $courseCategory->delete();

        return redirect()->route('admin.course-categories.index')->with('success', 'Course category deleted successfully.');
    }
}

