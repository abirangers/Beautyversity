@extends('layouts.admin')

@section('title', 'Lesson Details')

@section('content')

    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8">
        <div>
            <a href="{{ route('admin.lessons.index', ['course_id' => $lesson->course_id]) }}"
                class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Back to Lessons
            </a>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.lessons.edit', $lesson->id) }}"
                class="inline-flex items-center justify-center px-6 py-2.5 bg-primary-600 text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-primary-700 transition-colors duration-300">
                Edit Lesson
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="aspect-w-16 aspect-h-9 h-96">
                    <iframe src="https://www.youtube.com/embed/{{ $lesson->youtube_video_id }}" title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen class="w-full h-full">
                    </iframe>
                </div>
                <div class="p-6 border-t border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900">{{ $lesson->title }}</h2>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800">Lesson Information</h3>
                </div>
                <div class="p-6">
                    <dl class="space-y-4">
                        <div class="text-sm">
                            <dt class="font-medium text-gray-500">Course</dt>
                            <dd class="text-gray-900 mt-1 font-semibold">{{ $lesson->course->title ?? 'N/A' }}</dd>
                        </div>
                        <div class="text-sm">
                            <dt class="font-medium text-gray-500">Module</dt>
                            <dd class="text-gray-900 mt-1">{{ $lesson->module }}</dd>
                        </div>
                        <div class="text-sm">
                            <dt class="font-medium text-gray-500">Order</dt>
                            <dd class="text-gray-900 mt-1">{{ $lesson->order }}</dd>
                        </div>
                        <div class="text-sm">
                            <dt class="font-medium text-gray-500">Duration</dt>
                            <dd class="text-gray-900 mt-1">{{ $lesson->duration ? $lesson->duration . ' minutes' : 'N/A' }}
                            </dd>
                        </div>
                        <div class="text-sm">
                            <dt class="font-medium text-gray-500">Preview Status</dt>
                            <dd class="mt-1">
                                @if ($lesson->is_preview)
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Yes,
                                        it's a preview</span>
                                @else
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">No,
                                        it's a regular lesson</span>
                                @endif
                            </dd>
                        </div>
                        <div class="text-sm">
                            <dt class="font-medium text-gray-500">Last Updated</dt>
                            <dd class="text-gray-900 mt-1">{{ $lesson->updated_at->format('M d, Y') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>

@endsection
