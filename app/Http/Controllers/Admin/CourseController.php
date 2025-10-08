<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = \App\Models\Course::latest()->paginate(10);
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'instructor' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|integer|min:0',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trailer_video_id' => 'required|string',
            'full_video_ids' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'level' => 'required|in:Beginner,Intermediate,Advanced',
        ]);

        $thumbnail = 'default-course.jpg';
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail')->store('courses', 'public');
        }

        $fullVideoIds = $request->full_video_ids ? explode(',', $request->full_video_ids) : [];

        \App\Models\Course::create([
            'title' => $request->title,
            'instructor' => $request->instructor,
            'description' => $request->description,
            'price' => $request->price,
            'thumbnail' => $thumbnail,
            'trailer_video_id' => $request->trailer_video_id,
            'full_video_ids' => json_encode($fullVideoIds),
            'category' => $request->category,
            'level' => $request->level,
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = \App\Models\Course::findOrFail($id);
        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $course = \App\Models\Course::findOrFail($id);
        return view('admin.courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'instructor' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|integer|min:0',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trailer_video_id' => 'required|string',
            'full_video_ids' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'level' => 'required|in:Beginner,Intermediate,Advanced',
        ]);

        $course = \App\Models\Course::findOrFail($id);

        $data = [
            'title' => $request->title,
            'instructor' => $request->instructor,
            'description' => $request->description,
            'price' => $request->price,
            'trailer_video_id' => $request->trailer_video_id,
            'category' => $request->category,
            'level' => $request->level,
        ];

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('courses', 'public');
        }

        $fullVideoIds = $request->full_video_ids ? explode(',', $request->full_video_ids) : [];
        $data['full_video_ids'] = json_encode($fullVideoIds);

        $course->update($data);

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = \App\Models\Course::findOrFail($id);
        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully.');
    }
}
