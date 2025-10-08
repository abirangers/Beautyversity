@extends('layouts.admin')

@section('title', 'Manage Lessons')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Manage Lessons</h1>
                @if (request('course_id'))
                    <p class="text-gray-600">Showing lessons for:
                        {{ \App\Models\Course::find(request('course_id'))->title ?? 'N/A' }}</p>
                @endif
            </div>
            <div class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
                <form method="GET" class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
                    <select name="course_id"
                        class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-50"
                        onchange="this.form.submit()">
                        <option value="">All Courses</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                </form>
                <a href="{{ route('admin.lessons.create') }}"
                    class="bg-primary-600 text-white px-4 py-2 rounded-md hover:bg-primary-700 transition duration-300 text-center">Add
                    New Lesson</a>
            </div>
        </div>

        @if (session('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('message') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Module
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preview
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($lessons as $lesson)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $lesson->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ Str::limit($lesson->course->title ?? 'N/A', 20) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="line-clamp-1" title="{{ $lesson->title }}">{{ $lesson->title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="line-clamp-1" title="{{ $lesson->module }}">
                                    {{ Str::limit($lesson->module, 20) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $lesson->order }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $lesson->duration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($lesson->is_preview)
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Yes</span>
                                @else
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">No</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.lessons.show', $lesson->id) }}"
                                    class="text-blue-600 hover:text-blue-900 mr-2">View</a>
                                <a href="{{ route('admin.lessons.edit', $lesson->id) }}"
                                    class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                                <form action="{{ route('admin.lessons.destroy', $lesson->id) }}" method="POST"
                                    class="inline-block"
                                    onsubmit="return confirm('Are you sure you want to delete this lesson?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">No lessons found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $lessons->links() }}
        </div>
    </div>
@endsection
