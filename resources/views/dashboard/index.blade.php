@extends('layouts.app')

@section('title', 'Dashboard - Kelas Digital')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Dashboard Pengguna</h1>
    
    <div class="dashboard-info bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-2xl font-bold mb-4">Profil Saya</h2>
        <p><strong>Nama:</strong> {{ auth()->user()->name }}</p>
        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
        <p><strong>Member sejak:</strong> {{ auth()->user()->created_at->format('d M Y') }}</p>
    </div>
    
    <div class="dashboard-courses">
        <h2 class="text-2xl font-bold mb-4">Kelas Saya</h2>
        
        @if($courses->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($courses as $course)
                    <div class="bg-white rounded-lg shadow-md p-4 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-bold">{{ $course->title }}</h3>
                            <p>oleh {{ $course->instructor }}</p>
                        </div>
                        <a href="{{ route('course.show', $course->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-300">
                            Akses Kelas
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <p>Anda belum terdaftar di kelas manapun. <a href="{{ route('home') }}" class="text-blue-600 hover:underline">Jelajahi kelas</a></p>
        @endif
    </div>
</div>
@endsection