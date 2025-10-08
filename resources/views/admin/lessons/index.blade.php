@extends('layouts.admin')

@section('title', 'Manage Lessons')

@section('content')

    <!-- ===== Page Header ===== -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6">
        <div>
            @if (request('course_id') && ($course = \App\Models\Course::find(request('course_id'))))
                <p class="text-sm text-gray-600">Showing lessons for:</p>
                <h2 class="text-xl font-bold text-gray-800 -mt-1">{{ $course->title }}</h2>
            @endif
        </div>
        <div class="mt-4 sm:mt-0 flex items-center space-x-3 w-full sm:w-auto">
            <!-- Filter by Course -->
            <form method="GET" class="flex-grow sm:flex-grow-0">
                <select name="course_id" onchange="this.form.submit()"
                    class="w-full block px-4 py-2.5 border border-gray-300 bg-white rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition text-sm">
                    <option value="">Filter by All Courses</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->title }}
                        </option>
                    @endforeach
                </select>
            </form>
            <!-- Add New Lesson Button -->
            <a href="{{ route('admin.lessons.create', ['course_id' => request('course_id')]) }}"
                class="inline-flex items-center justify-center flex-shrink-0 px-5 py-2.5 bg-primary-600 text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-primary-700 transition-colors duration-300">
                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                Add Lesson
            </a>
        </div>
    </div>

    <!-- ===== Success Message ===== -->
    @if (session('message'))
        <div class="bg-green-50 border border-green-200 text-sm text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('message') }}
        </div>
    @endif

    <!-- ===== Lessons Table ===== -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Lesson
                            Title</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Course</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Module</th>
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Order
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Preview
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($lessons as $lesson)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 line-clamp-1" title="{{ $lesson->title }}">
                                    {{ $lesson->title }}</div>
                                <div class="text-xs text-gray-500">{{ $lesson->duration }} mins</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-700 line-clamp-1"
                                    title="{{ $lesson->course->title ?? 'N/A' }}">
                                    {{ Str::limit($lesson->course->title ?? 'N/A', 30) }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-700 line-clamp-1" title="{{ $lesson->module }}">
                                    {{ Str::limit($lesson->module, 25) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="text-sm text-gray-700">{{ $lesson->order }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if ($lesson->is_preview)
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Yes</span>
                                @else
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">No</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-4">
                                <a href="{{ route('admin.lessons.show', $lesson->id) }}"
                                    class="text-gray-500 hover:text-gray-800">View</a>
                                <a href="{{ route('admin.lessons.edit', $lesson->id) }}"
                                    class="text-primary-600 hover:text-primary-800">Edit</a>
                                <form action="{{ route('admin.lessons.destroy', $lesson->id) }}" method="POST"
                                    class="inline"
                                    onsubmit="return confirm('Are you sure you want to delete this lesson?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500">
                                @if (request('course_id'))
                                    No lessons found for this course.
                                @else
                                    No lessons found. Select a course to begin or add a new lesson.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ===== Pagination ===== -->
    <div class="mt-6">
        {{ $lessons->appends(request()->query())->links() }}
    </div>

@endsection
