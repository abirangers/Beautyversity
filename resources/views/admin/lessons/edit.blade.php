@extends('layouts.admin')

@section('title', 'Edit Lesson')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Lesson</h1>

    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <form action="{{ route('admin.lessons.update', $lesson->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="course_id" class="block text-sm font-medium text-gray-700 mb-1">Course</label>
                    <select name="course_id" id="course_id" class="w-full px-3 py-2 border border-gray-30 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500" required>
                        <option value="">Select a course</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id', $lesson->course_id) == $course->id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $lesson->title) }}" class="w-full px-3 py-2 border border-gray-30 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500" required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="youtube_video_id" class="block text-sm font-medium text-gray-700 mb-1">YouTube Video ID</label>
                    <input type="text" name="youtube_video_id" id="youtube_video_id" value="{{ old('youtube_video_id', $lesson->youtube_video_id) }}" class="w-full px-3 py-2 border border-gray-30 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500" required>
                    <p class="mt-1 text-sm text-gray-500">Enter the video ID from the YouTube URL (e.g., for https://www.youtube.com/watch?v=dQw4w9WgXcQ, the ID is dQw4w9WgXcQ)</p>
                    @error('youtube_video_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="module" class="block text-sm font-medium text-gray-700 mb-1">Module</label>
                    <input type="text" name="module" id="module" value="{{ old('module', $lesson->module) }}" class="w-full px-3 py-2 border border-gray-30 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500" required>
                    @error('module')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-1">Order</label>
                    <input type="number" name="order" id="order" value="{{ old('order', $lesson->order) }}" class="w-full px-3 py-2 border border-gray-30 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500" required>
                    @error('order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="duration" class="block text-sm font-medium text-gray-700 mb-1">Duration</label>
                    <input type="text" name="duration" id="duration" value="{{ old('duration', $lesson->duration) }}" class="w-full px-3 py-2 border border-gray-30 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                    <p class="mt-1 text-sm text-gray-500">e.g., 10:30 or 15 minutes</p>
                    @error('duration')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="is_preview" class="flex items-center">
                    <input type="checkbox" name="is_preview" id="is_preview" value="1" {{ old('is_preview', $lesson->is_preview) ? 'checked' : '' }} class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                    <span class="ml-2 block text-sm text-gray-70">Is this lesson a preview? (Available for non-enrolled users)</span>
                </label>
            </div>

            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('admin.lessons.index') }}" class="px-4 py-2 border border-gray-30 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Update Lesson
                </button>
            </div>
        </form>
    </div>
</div>
@endsection