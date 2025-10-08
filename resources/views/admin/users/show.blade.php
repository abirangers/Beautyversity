@extends('layouts.admin')

@section('title', 'View User')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">View User</h1>
        <div>
            <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 mr-2">
                Edit User
            </a>
            <a href="{{ route('admin.users.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                Back to Users
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-2xl font-bold mb-4">{{ $user->name }}</h2>
                    <p class="text-gray-600 mb-2"><strong>Email:</strong> {{ $user->email }}</p>
                    <p class="text-gray-600 mb-2"><strong>Role:</strong> 
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </p>
                    <p class="text-gray-600 mb-2"><strong>Member Since:</strong> {{ $user->created_at->format('d M Y') }}</p>
                    @if($user->last_login)
                        <p class="text-gray-600"><strong>Last Login:</strong> {{ $user->last_login->format('d M Y H:i') }}</p>
                    @endif
                </div>
                
                <div>
                    <h3 class="text-xl font-bold mb-4">Enrolled Courses</h3>
                    @if($user->enrollments->count() > 0)
                        <div class="space-y-3">
                            @foreach($user->enrollments as $enrollment)
                                <div class="border border-gray-200 rounded-md p-3">
                                    <p class="font-medium">{{ $enrollment->course->title }}</p>
                                    <p class="text-sm text-gray-600">Instructor: {{ $enrollment->course->instructor }}</p>
                                    <p class="text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $enrollment->payment_status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ ucfirst($enrollment->payment_status) }}
                                        </span>
                                        <span class="ml-2 text-gray-500 text-xs">{{ $enrollment->enrolled_at->format('d M Y') }}</span>
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No enrolled courses.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection