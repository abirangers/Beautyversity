@extends('layouts.admin')

@section('title', 'Lesson Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Lesson Details</h1>

    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900">Basic Information</h3>
                <div class="mt-4 space-y-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">ID</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $lesson->id }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Course</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $lesson->course->title ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Title</p>
                        <p class="mt-1 text-sm text-gray-900 line-clamp-2">{{ $lesson->title }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Module</p>
                        <p class="mt-1 text-sm text-gray-900 line-clamp-2">{{ $lesson->module }}</p>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900">Additional Information</h3>
                <div class="mt-4 space-y-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Order</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $lesson->order }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Duration</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $lesson->duration ?: 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Preview Status</p>
                        <p class="mt-1 text-sm text-gray-900">
                            @if($lesson->is_preview)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Yes</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">No</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Created</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $lesson->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Updated</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $lesson->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-900">YouTube Video</h3>
            <div class="mt-4">
                <p class="text-sm text-gray-500">Video ID: {{ $lesson->youtube_video_id }}</p>
                <div class="mt-2 aspect-w-16 aspect-h-9 aspect-video bg-gray-200 rounded-lg overflow-hidden max-w-2xl">
                    <iframe
                        width="10%"
                        height="315"
                        src="https://www.youtube.com/embed/{{ $lesson->youtube_video_id }}"
                        title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                        class="w-full">
                    </iframe>
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.lessons.index') }}" class="px-4 py-2 border border-gray-30 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Back to Lessons
            </a>
            <a href="{{ route('admin.lessons.edit', $lesson->id) }}" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Edit Lesson
            </a>
        </div>
    </div>
</div>
@endsection