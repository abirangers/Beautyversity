@extends('layouts.admin')

@section('title', 'Edit Course')

@section('content')

    <form action="{{ route('admin.courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8">
            <div>
                <a href="{{ route('admin.courses.index') }}"
                    class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
                    <i class="fas fa-arrow-left w-5 h-5 mr-2 text-sm"></i>
                    Back to Courses
                </a>
            </div>
            <div class="mt-4 sm:mt-0 flex items-center space-x-3">
                <a href="{{ route('admin.lessons.index') }}?course_id={{ $course->id }}"
                    class="inline-flex items-center justify-center px-5 py-2.5 bg-white border border-gray-300 text-gray-700 font-semibold text-sm rounded-lg shadow-sm hover:bg-gray-50 transition-colors duration-300">
                    Manage Lessons
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center px-6 py-2.5 bg-primary-600 text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-primary-700 transition-colors duration-300">
                    Update Course
                </button>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6 md:p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <!-- Course Title -->
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Course Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $course->title) }}"
                            required placeholder="e.g., Basic Skincare Routine: From Zero to Hero"
                            class="w-full block px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="instructor" class="block text-sm font-medium text-gray-700 mb-2">Instructor</label>
                        <input type="text" name="instructor" id="instructor"
                            value="{{ old('instructor', $course->instructor) }}" required
                            placeholder="e.g., Dr. Amanda Larasati"
                            class="w-full block px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                        @error('instructor')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price (Rp)</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $course->price) }}"
                            required placeholder="e.g., 150000"
                            class="w-full block px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="course_category_id" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <select name="course_category_id" id="course_category_id" required
                            class="w-full block px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                            <option value="" disabled>-- Select category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('course_category_id', optional($course->category)->id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('course_category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="level" class="block text-sm font-medium text-gray-700 mb-2">Level</label>
                        <select name="level" id="level" required
                            class="w-full block px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                            <option value="Beginner" {{ old('level', $course->level) == 'Beginner' ? 'selected' : '' }}>
                                Beginner</option>
                            <option value="Intermediate"
                                {{ old('level', $course->level) == 'Intermediate' ? 'selected' : '' }}>Intermediate
                            </option>
                            <option value="Advanced" {{ old('level', $course->level) == 'Advanced' ? 'selected' : '' }}>
                                Advanced</option>
                        </select>
                        @error('level')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="trailer_video_id" class="block text-sm font-medium text-gray-700 mb-2">Trailer Video ID
                            (YouTube)</label>
                        <input type="text" name="trailer_video_id" id="trailer_video_id"
                            value="{{ old('trailer_video_id', $course->trailer_video_id) }}" required
                            placeholder="e.g., dQw4w9WgXcQ"
                            class="w-full block px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                        @error('trailer_video_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="full_video_ids" class="block text-sm font-medium text-gray-700 mb-2">Full Video IDs</label>
                        <input type="text" name="full_video_ids" id="full_video_ids"
                            value="{{ old('full_video_ids', implode(',', $course->full_video_ids ?? [])) }}"
                            placeholder="e.g., abcde123, fghij456, klmno789"
                            class="w-full block px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                        <p class="mt-2 text-xs text-gray-500">Enter YouTube video IDs separated by a comma (e.g., abcde123,
                            fghij456).</p>
                        @error('full_video_ids')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-2">Thumbnail</label>
                        <div class="flex items-center space-x-6">
                            @if ($course->thumbnail)
                                <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="Current Thumbnail"
                                    class="h-16 w-16 object-cover rounded-lg">
                            @endif
                            <input type="file" name="thumbnail" id="thumbnail"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Leave blank to keep the current thumbnail.</p>
                        @error('thumbnail')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" id="description" rows="6" required
                            placeholder="Describe what students will learn in this course, the benefits, and what makes it unique..."
                            class="w-full block px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">{{ old('description', $course->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="px-6 md:px-8 py-4 bg-gray-50 border-t border-gray-200 rounded-b-lg flex justify-end">
                <button type="submit"
                    class="inline-flex items-center justify-center px-6 py-2.5 bg-primary-600 text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-primary-700 transition-colors duration-300">
                    Update Course
                </button>
            </div>
        </div>
    </form>

@endsection
