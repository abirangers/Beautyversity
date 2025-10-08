@extends('layouts.app')

@section('title', $course->title . ' - Kelas Digital')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Course Header with Rating and Stats -->
    <div class="course-header mb-8">
        <h1 class="text-3xl font-bold mb-2">{{ $course->title }}</h1>
        <div class="flex flex-col sm:flex-row sm:items-center mb-4">
            <div class="flex items-center mb-2 sm:mb-0 sm:mr-6">
                <!-- Rating Stars -->
                <div class="flex text-yellow-400 mr-2">
                    @for($i = 0; $i < 5; $i++)
                        <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                        </svg>
                    @endfor
                </div>
                <span class="text-gray-600">(4.8)</span>
            </div>
            <div class="flex items-center text-gray-600">
                <!-- Video Icon and Count -->
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0 21 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
                <span class="mr-4">{{ $totalVideos }} Video</span>
                
                <!-- Students Icon and Count -->
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span>{{ $enrolledStudentsCount }} Siswa Terdaftar</span>
            </div>
        </div>
        <p class="text-gray-600">Instruktur: {{ $course->instructor }}</p>
    </div>
    
    <!-- Two Column Layout: Video/Curriculum on left, Pricing on right -->
    <div class="course-content grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Left Column: Video Player and Course Curriculum -->
        <div class="lg:col-span-8 space-y-8">
            <!-- Video Player Section -->
            <div class="video-section bg-gray-900 rounded-lg overflow-hidden shadow-lg">
                @if($userHasAccess)
                    <!-- Full video for enrolled users -->
                    <div class="aspect-w-16 aspect-h-9 aspect-video">
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
                    <div class="aspect-w-16 aspect-h-9 aspect-video">
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
            
            <!-- Course Curriculum Section -->
            <div class="course-curriculum bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">Daftar Materi</h2>
                
                @foreach($lessonsByModule as $module => $lessons)
                    <div class="module mb-6 last:mb-0">
                        <div class="module-header bg-gray-100 p-4 rounded-t-lg flex justify-between items-center cursor-pointer module-toggle" data-target="module-{{ Str::slug($module) }}">
                            <h3 class="text-lg font-semibold text-gray-800">{{ $module }}</h3>
                            <svg class="w-5 h-5 text-gray-600 module-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                        
                        <div id="module-{{ Str::slug($module) }}" class="module-content hidden bg-white border border-t-0 border-gray-200 rounded-b-lg p-4">
                            @foreach($lessons as $lesson)
                                <div class="lesson-item py-3 border-b border-gray-100 last:border-0 flex items-center">
                                    <div class="mr-3 flex-shrink-0">
                                        @if($userHasAccess || $lesson->is_preview)
                                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 0-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 0-8 0v4h8z"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="flex-grow">
                                        <div class="flex justify-between items-center w-full">
                                            <span class="text-gray-800">{{ $lesson->title }}</span>
                                            <span class="text-sm text-gray-500">{{ $lesson->duration }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Right Column: Pricing and Benefits Card -->
        <div class="lg:col-span-4 sticky top-4">
            <div class="pricing-card bg-white rounded-lg shadow-lg p-6 sticky top-4 border border-gray-200">
                <div class="price-section mb-6 text-center">
                    <div class="original-price text-gray-500 line-through text-lg mb-1">Rp {{ number_format($course->price * 1.2, 0, ',', '.') }}</div>
                    <div class="current-price text-3xl font-bold text-primary-600">Rp {{ number_format($course->price, 0, ',', '.') }}</div>
                </div>
                
                <ul class="benefits-list mb-6 space-y-3 text-gray-700">
                    <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Akses seumur hidup</li>
                    <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Sertifikat kelulusan</li>
                    <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Video kelas berkualitas</li>
                    <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Akses ke komunitas</li>
                </ul>
                
                <div class="course-action mb-6">
                    @if(auth()->check())
                        @if($userHasAccess)
                            <a href="#" class="bg-primary-600 text-white py-3 px-6 rounded-md hover:bg-primary-700 transition duration-300 block text-center font-semibold">
                                Mulai Belajar
                            </a>
                            <p class="text-success-500 font-semibold mt-3 text-center">Anda sudah terdaftar di kelas ini</p>
                        @elseif($userEnrollment && $userEnrollment->payment_status === 'pending')
                            <p class="text-warning-500 font-semibold text-center">Pembayaran sedang diproses. Tunggu verifikasi dari admin.</p>
                            <p class="text-gray-600 text-center mt-2">Status: Menunggu pembayaran diverifikasi</p>
                        @else
                            <form method="post" action="{{ route('course.enroll', $course->id) }}">
                                @csrf
                                <button type="submit" class="bg-primary-600 text-white py-3 px-6 rounded-md hover:bg-primary-700 transition duration-300 w-full font-semibold">
                                    Gabung Kelas (Rp {{ number_format($course->price, 0, ',', '.') }})
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="bg-primary-600 text-white py-3 px-6 rounded-md hover:bg-primary-700 transition duration-300 block text-center font-semibold">
                            Login untuk Gabung Kelas
                        </a>
                    @endif
                </div>
                
                <div class="course-details text-sm text-gray-600">
                    <p class="mb-2"><strong>Level:</strong> {{ $course->level }}</p>
                    <p class="mb-2"><strong>Kategori:</strong> {{ $course->category }}</p>
                    <p><strong>Terakhir Diperbarui:</strong> {{ $course->updated_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const moduleToggles = document.querySelectorAll('.module-toggle');
    
    moduleToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const targetContent = document.getElementById(targetId);
            const icon = this.querySelector('.module-icon');
            
            // Toggle the content
            targetContent.classList.toggle('hidden');
            
            // Rotate the icon
            if (targetContent.classList.contains('hidden')) {
                icon.style.transform = 'rotate(0deg)';
            } else {
                icon.style.transform = 'rotate(180deg)';
            }
        });
    });
});
</script>
@endsection