@extends('layouts.app')

@section('title', 'Kelas Digital - Platform Belajar Online')

@section('content')
    <section id="hero"
        class="relative bg-primary-500 text-center py-20 md:py-32 flex items-center justify-center min-h-screen max-h-[1000px] h-auto"
        style="background: linear-gradient(rgba(230, 180, 184, 0.8), rgba(230, 180, 184, 0.8)), url('https://images.unsplash.com/photo-1516321497487-e288fb19713f?q=80&w=2070&auto=format&fit=crop') no-repeat center center; background-size: cover;">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight">
                Tingkatkan Skill, Wujudkan Karir Impianmu
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-lg text-white opacity-90">
                Kelas Digital menyediakan kursus online terbaik di bidang teknologi dan kreatif untuk membantumu
                mencapai tujuan.
            </p>
            <div class="mt-8">
                <a href="#"
                    class="px-8 py-3 text-lg font-semibold text-primary-600 bg-white rounded-md hover:bg-gray-100 transition-transform transform hover:scale-105">
                    Lihat Semua Kelas
                </a>
            </div>
        </div>
    </section>
    <section id="popular-courses" class="py-16 md:py-24 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-sm font-bold uppercase tracking-widest text-primary-600">Rekomendasi Kami</h2>
                <p class="mt-2 text-3xl md:text-4xl font-bold text-gray-900">
                    Kelas Paling Populer
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($courses as $course)
                    {{ $course }}
                    <div
                        class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-xl transition-shadow duration-300 border border-gray-100">
                        <a href="{{ route('course.show', $course) }}">
                            <img src="{{ $course->thumbnail_url ?? 'https://via.placeholder.com/600x400.png/E6B4B8/333333?text=' . urlencode($course->title) }}"
                                alt="{{ $course->title }}" class="w-full h-48 object-cover">
                        </a>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2">{{ $course->title }}</h3>
                            <p class="text-gray-600 text-sm mb-4">
                                {{ Str::limit($course->description, 100) }}
                            </p>
                            <div class="flex items-center justify-between">
                                <span
                                    class="text-lg font-bold text-primary-600">Rp{{ number_format($course->price, 0, ',', '.') }}</span>
                                <a href="{{ route('course.show', $course) }}"
                                    class="text-sm font-semibold text-primary-600 hover:underline">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="col-span-3 text-center text-gray-500">Belum ada kelas yang tersedia.</p>
                @endforelse
            </div>
        </div>
    </section>
    <section id="latest-articles" class="py-16 md:py-24 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-sm font-bold uppercase tracking-widest text-primary-600">Artikel Terbaru</h2>
                <p class="mt-2 text-3xl md:text-4xl font-bold text-gray-90">
                    Wawasan & Inspirasi
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
                    class="bg-white rounded-lg shadow-sm hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100">
                    <a href="#">
                        <img src="https://via.placeholder.com/600x400.png" alt="5 Bahan Aktif Terbaru"
                            class="w-full h-48 object-cover">
                    </a>
                    <div class="p-6">
                        <p class="text-sm text-gray-500 mb-2">October 8, 2025</p>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">5 Bahan Aktif Terbaru yang Wajib Dicoba Tahun Ini
                        </h3>
                        <a href="#" class="font-semibold text-primary-600 hover:underline">Baca Selengkapnya</a>
                    </div>
                </div>

            </div>

    </section>
@endsection
