@extends('layouts.app')

@section('title', $course->title . ' - Kelas Digital')

@section('content')

    <div class="bg-gray-50 py-8 border-b border-gray-200">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="text-sm mb-4" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex space-x-2">
                    <li class="flex items-center">
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary-600">Home</a>
                        <i class="fas fa-chevron-right text-gray-400 mx-2 text-base"></i>
                    </li>
                    <li class="flex items-center">
                        <span class="text-gray-700 font-semibold">{{ $course->title }}</span>
                    </li>
                </ol>
            </nav>

            <h1 class="text-4xl md:text-5xl font-bold text-gray-900">{{ $course->title }}</h1>
            <p class="mt-2 text-lg text-gray-600">Instruktur: {{ $course->instructor }}</p>

            <div class="flex flex-wrap items-center mt-4 text-gray-600 text-sm">
                <div class="flex items-center mr-6 mb-2 md:mb-0">
                    <div class="flex text-yellow-400 mr-2">
                        @for ($i = 0; $i < 5; $i++)
                            <i class="fas fa-star text-yellow-400 text-xl"></i>
                        @endfor
                    </div>
                    <span>(4.8)</span>
                </div>
                <div class="flex items-center mr-6 mb-2 md:mb-0">
                    <i class="fas fa-video mr-2 text-gray-600 text-base"></i>
                    <span>{{ $totalVideos }} Video</span>
                </div>
                <div class="flex items-center mb-2 md:mb-0">
                    <i class="fas fa-users mr-2 text-gray-600 text-base"></i>
                    <span>{{ $enrolledStudentsCount }} Siswa Terdaftar</span>
                </div>
            </div>
        </div>
    </div>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="lg:grid lg:grid-cols-12 lg:gap-12">

            <div class="lg:col-span-8">
                <div class="rounded-lg overflow-hidden shadow-lg mb-8">
                    <div class="aspect-w-16 aspect-h-9 h-96">
                        <iframe width="100%" height="100%"
                            src="https://www.youtube.com/embed/{{ $userHasAccess && !empty($course->full_video_ids[0]) ? $course->full_video_ids[0] : $course->trailer_video_id }}"
                            title="Course Video" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen class="w-full h-full"></iframe>
                    </div>
                </div>

                <div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">Materi Pembelajaran</h2>
                    <div class="space-y-4">
                        @forelse($lessonsByModule as $module => $lessons)
                            <div class="module border border-gray-200 rounded-lg">
                                <div class="module-header bg-gray-50 hover:bg-gray-100 p-4 flex justify-between items-center cursor-pointer module-toggle"
                                    data-target="module-{{ Str::slug($module) }}">
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $module }}</h3>
                                    <i class="fas fa-chevron-down text-gray-500 module-icon transition-transform duration-300 text-xl"></i>
                                </div>

                                <div id="module-{{ Str::slug($module) }}"
                                    class="module-content hidden border-t border-gray-200 p-4 space-y-3">
                                    @foreach ($lessons as $lesson)
                                        <div class="lesson-item flex items-center">
                                            <div class="flex-shrink-0 mr-4">
                                                @if ($userHasAccess || $lesson->is_preview)
                                                    <i class="fas fa-check-circle text-primary-500 text-xl"></i>
                                                @else
                                                    <i class="fas fa-lock text-gray-400 text-xl"></i>
                                                @endif
                                            </div>
                                            <div class="flex-grow flex justify-between items-center">
                                                <p class="text-gray-800">{{ $lesson->title }}</p>
                                                <span class="text-sm text-gray-500">{{ $lesson->duration }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">Materi pembelajaran akan segera ditambahkan.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="lg:col-span-4 mt-12 lg:mt-0">
                <div class="sticky top-24 bg-white p-6 rounded-lg shadow-lg border border-gray-100">
                    <div class="text-center mb-6">
                        <span class="text-gray-500 line-through text-lg">Rp
                            {{ number_format($course->price * 1.2, 0, ',', '.') }}</span>
                        <h3 class="text-4xl font-bold text-primary-600">Rp{{ number_format($course->price, 0, ',', '.') }}
                        </h3>
                    </div>

                    <div class="mb-6">
                        @if (auth()->check())
                            @if ($userHasAccess)
                                <a href="#"
                                    class="w-full text-center block px-6 py-3 text-lg font-semibold text-white bg-green-500 rounded-lg shadow-md">
                                    Mulai Belajar
                                </a>
                                <p class="text-green-600 font-semibold mt-3 text-center text-sm">Anda sudah terdaftar.</p>
                            @elseif($userEnrollment && $userEnrollment->payment_status === 'pending')
                                <div class="text-center p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <p class="font-semibold text-yellow-800">Menunggu Pembayaran</p>
                                    <p class="text-yellow-700 text-sm mt-1">Pembayaran Anda sedang kami verifikasi.</p>
                                </div>
                            @else
                                <form method="post" action="{{ route('course.enroll', $course->id) }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full px-6 py-3 text-lg font-semibold text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition-all duration-300 shadow-md">
                                        Gabung Kelas Ini
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login') }}"
                                class="w-full text-center block px-6 py-3 text-lg font-semibold text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition-all duration-300 shadow-md">
                                Login untuk Gabung
                            </a>
                        @endif
                    </div>

                    <ul class="space-y-3 text-gray-600 text-sm">
                        <li class="flex items-center"><i class="fas fa-check text-primary-500 mr-3 text-base flex-shrink-0"></i>Akses seumur hidup</li>
                        <li class="flex items-center"><i class="fas fa-check text-primary-500 mr-3 text-base flex-shrink-0"></i>Sertifikat kelulusan</li>
                        <li class="flex items-center"><i class="fas fa-check text-primary-500 mr-3 text-base flex-shrink-0"></i>Video kelas berkualitas</li>
                        <li class="flex items-center"><i class="fas fa-check text-primary-500 mr-3 text-base flex-shrink-0"></i>Akses ke komunitas</li>
                    </ul>
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

                    targetContent.classList.toggle('hidden');

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
