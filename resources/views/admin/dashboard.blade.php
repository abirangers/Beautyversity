@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Courses</p>
                <p class="text-3xl font-bold text-gray-900">{{ $totalCourses }}</p>
            </div>
            <div class="flex-shrink-0 h-14 w-14 flex items-center justify-center bg-primary-100 rounded-full">
                <i class="fas fa-book-open text-primary-600 text-2xl"></i>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Users</p>
                <p class="text-3xl font-bold text-gray-900">{{ $totalUsers }}</p>
            </div>
            <div class="flex-shrink-0 h-14 w-14 flex items-center justify-center bg-primary-100 rounded-full">
                <i class="fas fa-users text-primary-600 text-2xl"></i>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Enrollments</p>
                <p class="text-3xl font-bold text-gray-900">{{ $totalEnrollments }}</p>
            </div>
            <div class="flex-shrink-0 h-14 w-14 flex items-center justify-center bg-primary-100 rounded-full">
                <i class="fas fa-clipboard-list text-primary-600 text-2xl"></i>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Pending Payments</p>
                <p class="text-3xl font-bold text-gray-900">{{ $pendingPayments }}</p>
            </div>
            <div class="flex-shrink-0 h-14 w-14 flex items-center justify-center bg-yellow-100 rounded-full">
                <i class="fas fa-coins text-yellow-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="mt-8 bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Recent Enrollments</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">User</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Course</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Date</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentEnrollments as $enrollment)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full"
                                            src="https://ui-avatars.com/api/?name={{ urlencode($enrollment->user->name) }}&background=E6B4B8&color=333333"
                                            alt="">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $enrollment->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $enrollment->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $enrollment->course->title }}</div>
                                <div class="text-sm text-gray-500">by {{ $enrollment->course->instructor }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $enrollment->enrolled_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($enrollment->payment_status === 'completed')
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Completed
                                    </span>
                                @else
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-sm text-gray-500">
                                No recent enrollments found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
