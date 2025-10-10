@extends('layouts.admin')

@section('title', 'Edit Lesson')

@section('content')

<form action="{{ route('admin.lessons.update', $lesson->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8">
        <div>
            <a href="{{ url()->previous() }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
                <i class="fas fa-arrow-left w-5 h-5 mr-2 text-sm"></i>
                Back to Lessons
            </a>
        </div>
        <div class="mt-4 sm:mt-0">
            <button type="submit" class="inline-flex items-center justify-center px-6 py-2.5 bg-primary-600 text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-primary-700 transition-colors duration-300">
                Update Lesson
            </button>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 md:p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                <div class="md:col-span-2">
                    <label for="course_id" class="block text-sm font-medium text-gray-700 mb-2">Course</label>
                    <select name="course_id" id="course_id" required class="w-full block px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                        <option value="">Select a course</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id', $lesson->course_id) == $course->id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('course_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Lesson Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $lesson->title) }}" required class="w-full block px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                    @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                
                <div class="md:col-span-2">
                    <label for="youtube_video_id" class="block text-sm font-medium text-gray-700 mb-2">YouTube Video ID</label>
                    <input type="text" name="youtube_video_id" id="youtube_video_id" value="{{ old('youtube_video_id', $lesson->youtube_video_id) }}" required class="w-full block px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                    <p class="mt-2 text-xs text-gray-500">e.g., for https://www.youtube.com/watch?v=dQw4w9WgXcQ, the ID is dQw4w9WgXcQ</p>
                    @error('youtube_video_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="module" class="block text-sm font-medium text-gray-700 mb-2">Module</label>
                    <input type="text" name="module" id="module" value="{{ old('module', $lesson->module) }}" required class="w-full block px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                    <p class="mt-2 text-xs text-gray-500">Group lessons under a module name (e.g., "Introduction").</p>
                    @error('module') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Order</label>
                    <input type="number" name="order" id="order" value="{{ old('order', $lesson->order) }}" required class="w-full block px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                    <p class="mt-2 text-xs text-gray-500">The display order of the lesson (e.g., 1, 2, 3).</p>
                    @error('order') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">Duration (in minutes)</label>
                    <input type="number" name="duration" id="duration" value="{{ old('duration', $lesson->duration) }}" class="w-full block px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                     @error('duration') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center h-full">
                     <div class="mt-4">
                        <label for="is_preview" class="flex items-center">
                            <input type="checkbox" name="is_preview" id="is_preview" value="1" {{ old('is_preview', $lesson->is_preview) ? 'checked' : '' }} class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            <span class="ml-3 block text-sm font-medium text-gray-700">Make this a preview lesson</span>
                        </label>
                        <p class="ml-7 text-xs text-gray-500">Preview lessons are available for non-enrolled users.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="px-6 md:px-8 py-4 bg-gray-50 border-t border-gray-200 rounded-b-lg flex justify-end space-x-3">
            <a href="{{ url()->previous() }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-white border border-gray-300 text-gray-700 font-semibold text-sm rounded-lg shadow-sm hover:bg-gray-50 transition-colors">
                Cancel
            </a>
            <button type="submit" class="inline-flex items-center justify-center px-6 py-2.5 bg-primary-600 text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-primary-700 transition-colors duration-300">
                Update Lesson
            </button>
        </div>
    </div>
</form>

@endsection
