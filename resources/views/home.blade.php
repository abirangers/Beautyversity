@extends('layouts.app')

@section('title', 'Kelas Digital - Platform Belajar Online')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-indigo-60 to-purple-700 text-white py-20">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl font-bold mb-4">Belajar Lebih Mudah dengan Kelas Digital</h2>
        <p class="text-xl mb-8">Akses berbagai kelas berkualitas dari instruktur terbaik di bidangnya. Belajar kapan saja, di mana saja.</p>
        <a href="#courses" class="bg-white text-indigo-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
            Lihat Kelas
        </a>
    </div>
</section>

<!-- Featured Courses Section -->
<section id="courses" class="py-16 bg-gray-100">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Kelas Pilihan</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($courses as $course)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                        @if($course->thumbnail && $course->thumbnail != 'default-course.jpg')
                            <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="text-gray-500">No Image</div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2 line-clamp-2">{{ $course->title }}</h3>
                        <p class="text-gray-600 mb-2">Instruktur: {{ $course->instructor }}</p>
                        <p class="text-lg font-bold text-blue-600 mb-4">Rp {{ number_format($course->price, 0, ',', '.') }}</p>
                        <a href="{{ route('course.show', $course->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-300 block text-center">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-600">Belum ada kelas tersedia. Silakan cek kembali nanti.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Articles Section -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Artikel Terbaru</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($articles as $article)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                        @if($article->thumbnail && $article->thumbnail != 'default-article.jpg')
                            <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="text-gray-500">No Image</div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2 line-clamp-2">{{ $article->title }}</h3>
                        <p class="text-gray-600 mb-4">Oleh: {{ $article->author }}</p>
                        <a href="#" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 transition duration-300 block text-center">
                            Baca Selengkapnya
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-600">Belum ada artikel tersedia. Silakan cek kembali nanti.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection