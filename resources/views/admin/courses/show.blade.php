@extends('layouts.admin')

@section('title', 'View Course')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">View Course</h1>
        <div>
            <a href="{{ route('admin.courses.edit', $course->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 mr-2">
                Edit Course
            </a>
            <a href="{{ route('admin.lessons.index') }}?course_id={{ $course->id }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 mr-2">
                Manage Lessons
            </a>
            <a href="{{ route('admin.courses.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                Back to Courses
            </a>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-2xl font-bold mb-4">{{ $course->title }}</h2>
                    <p class="text-gray-600 mb-2"><strong>Instructor:</strong> {{ $course->instructor }}</p>
                    <p class="text-gray-600 mb-2"><strong>Price:</strong> Rp {{ number_format($course->price, 0, ',', '.') }}</p>
                    <p class="text-gray-600 mb-2"><strong>Category:</strong> {{ $course->category ?? 'N/A' }}</p>
                    <p class="text-gray-600 mb-2"><strong>Level:</strong> 
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                            {{ $course->level }}
                        </span>
                    </p>
                </div>
                
                <div>
                    @if($course->thumbnail && $course->thumbnail != 'default-course.jpg')
                        <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-48 object-cover rounded-md">
                    @else
                        <div class="bg-gray-200 border-2 border-dashed rounded-xl w-full h-48 flex items-center justify-center">
                            <span class="text-gray-500">No Thumbnail</span>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="mt-6">
                <h3 class="text-xl font-bold mb-2">Description</h3>
                <p class="text-gray-700">{{ $course->description }}</p>
            </div>
            
            <div class="mt-6">
                <h3 class="text-xl font-bold mb-2">Videos</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h4 class="font-medium mb-1">Trailer Video ID:</h4>
                        <p class="text-gray-700">{{ $course->trailer_video_id }}</p>
                    </div>
                    <div>
                        <h4 class="font-medium mb-1">Full Video IDs:</h4>
                        <p class="text-gray-700">
                            @if($course->full_video_ids)
                                @php
                                    $videoIds = json_decode($course->full_video_ids, true) ?? [];
                                @endphp
                                @if(count($videoIds) > 0)
                                    {{ implode(', ', $videoIds) }}
                                @else
                                    N/A
                                @endif
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection