@extends('layouts.app')

@section('title', 'Beautyversity.id - Where Beauty Meets Science | Platform Edukasi Kecantikan Berbasis Bukti')

@section('content')
    <section id="hero"
        class="relative bg-primary-500 text-center py-20 md:py-32 flex items-center justify-center min-h-screen max-h-[1000px] h-auto"
        style="background: linear-gradient(rgba(230, 180, 184, 0.8), rgba(230, 180, 184, 0.8)), url('https://images.unsplash.com/photo-1516321497487-e288fb19713f?q=80&w=2070&auto=format&fit=crop') no-repeat center center; background-size: cover;">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight">
                Where Beauty Meets Science
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-lg text-white opacity-90">
                Platform Edukasi Kecantikan Berbasis Bukti dari Mahasiswa S2 Farmasi UNPAD. 
                Pelajari ilmu kecantikan yang benar dari para ahli farmasi dan kosmetik.
            </p>
            <div class="mt-8">
                <a href="#popular-courses"
                    class="px-8 py-3 text-lg font-semibold text-primary-600 bg-white rounded-md hover:bg-gray-100 transition-transform transform hover:scale-105">
                    Mulai Perjalanan Kecantikan Anda
                </a>
            </div>
        </div>
    </section>
    <section id="popular-courses" class="py-16 md:py-24 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-sm font-bold uppercase tracking-widest text-primary-600">Kursus Kecantikan</h2>
                <p class="mt-2 text-3xl md:text-4xl font-bold text-gray-900">
                    Pelajari Ilmu Kecantikan yang Benar
                </p>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">
                    Dari dasar-dasar kulit hingga formulasi produk yang aman. 
                    Semua berdasarkan penelitian ilmiah dan praktik industri.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($courses as $course)
                    <div
                        class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-xl transition-shadow duration-300 border border-gray-100">
                        <a href="{{ route('course.show', $course->slug) }}">
                            <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}"
                                class="w-full h-48 object-cover">
                        </a>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2">{{ $course->title }}</h3>
                            <p class="text-gray-600 text-sm mb-4">
                                {{ Str::limit($course->description, 100) }}
                            </p>
                            <div class="flex items-center justify-between">
                                <span
                                    class="text-lg font-bold text-primary-600">Rp{{ number_format($course->price, 0, ',', '.') }}</span>
                                <a href="{{ route('course.show', $course->slug) }}"
                                    class="text-sm font-semibold text-primary-600 hover:underline">
                                    Pelajari Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="col-span-3 text-center text-gray-500">Kursus kecantikan akan segera hadir. Daftar untuk mendapatkan notifikasi terbaru!</p>
                @endforelse
            </div>
        </div>
    </section>
    <section id="latest-articles" class="py-16 md:py-24 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-sm font-bold uppercase tracking-widest text-primary-600">Artikel Ilmiah</h2>
                <p class="mt-2 text-3xl md:text-4xl font-bold text-gray-900">
                    Wawasan Berbasis Bukti
                </p>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">
                    Temukan fakta-fakta ilmiah di balik produk kecantikan yang Anda gunakan. 
                    Dari penelitian terbaru hingga tips praktis yang aman.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @if ($articles->isEmpty())
                    <p class="col-span-3 text-center text-gray-500">Artikel ilmiah akan segera hadir. Daftar untuk mendapatkan update terbaru!</p>
                @else
                    @include('article.partials.articles', ['articles' => $articles])
                @endif
            </div>

    </section>
@endsection
