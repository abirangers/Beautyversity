@extends('layouts.app')

@section('title', $course->title . ' - Kelas Digital')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="course-header text-center mb-8">
        <h1 class="text-3xl font-bold mb-2">{{ $course->title }}</h1>
        <p class="text-gray-600 mb-2">Instruktur: {{ $course->instructor }}</p>
        <p class="text-xl font-bold text-blue-600">Rp {{ number_format($course->price, 0, ',', '.') }}</p>
    </div>
    
    <div class="course-content grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="video-section bg-gray-900 rounded-lg overflow-hidden mb-6">
                @if($userHasAccess)
                    <!-- Full video for enrolled users -->
                    <div class="aspect-w-16 aspect-h-9">
                        <iframe
                            width="100%"
                            height="450"
                            src="https://www.youtube.com/embed/{{ $course->full_video_ids[0] ?? $course->trailer_video_id }}"
                            title="Video Kelas Digital"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                            class="w-full">
                        </iframe>
                    </div>
                    <p class="text-center py-2 text-white bg-gray-800">Video Pembelajaran Utama</p>
                @else
                    <!-- Trailer video for non-enrolled users -->
                    <div class="aspect-w-16 aspect-h-9">
                        <iframe
                            width="100%"
                            height="450"
                            src="https://www.youtube.com/embed/{{ $course->trailer_video_id }}"
                            title="Video Trailer Kelas Digital"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                            class="w-full">
                        </iframe>
                    </div>
                    <p class="text-center py-2 text-white bg-gray-800">Video Preview - Daftar kelas untuk mengakses video lengkap</p>
                @endif
            </div>
        
        <div class="course-info-section">
            <h2 class="text-2xl font-bold mb-4">Deskripsi Kelas</h2>
            <p class="mb-6">{{ $course->description }}</p>
            
            <div class="course-action bg-gray-100 p-6 rounded-lg">
                @if(auth()->check())
                    @if($userHasAccess)
                        <a href="#" class="bg-blue-600 text-white py-3 px-6 rounded-md hover:bg-blue-700 transition duration-300 block text-center">
                            Mulai Belajar
                        </a>
                        <p class="text-green-600 font-semibold mt-3 text-center">Anda sudah terdaftar di kelas ini</p>
                    @elseif($userEnrollment && $userEnrollment->payment_status === 'pending')
                        <p class="text-yellow-600 font-semibold text-center">Pembayaran sedang diproses. Tunggu verifikasi dari admin.</p>
                        <p class="text-gray-600 text-center mt-2">Status: Menunggu pembayaran diverifikasi</p>
                    @else
                        <form method="post" action="{{ route('course.enroll', $course->id) }}">
                            @csrf
                            <button type="submit" class="bg-blue-600 text-white py-3 px-6 rounded-md hover:bg-blue-700 transition duration-300 w-full">
                                Beli Kelas (Rp {{ number_format($course->price, 0, ',', '.') }})
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="bg-blue-600 text-white py-3 px-6 rounded-md hover:bg-blue-700 transition duration-300 block text-center">
                        Login untuk Beli Kelas
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection