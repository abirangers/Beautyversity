@extends('layouts.app')

@section('title', 'Cari Kelas & Artikel')

@section('content')
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center mb-12">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Temukan Materi yang Kamu Butuhkan</h1>
                <p class="text-gray-600">Cari kelas atau artikel berdasarkan kata kunci untuk mempercepat proses belajar kamu.</p>
            </div>

            <form action="{{ route('search') }}" method="GET" class="max-w-3xl mx-auto mb-16">
                <label for="search" class="sr-only">Kata kunci</label>
                <div class="flex flex-col sm:flex-row gap-4 bg-white shadow-sm rounded-lg p-4 border border-gray-100">
                    <input
                        type="search"
                        id="search"
                        name="q"
                        value="{{ old('q', $keyword) }}"
                        placeholder="Cari kelas atau artikel..."
                        class="flex-1 border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-gray-700"
                        autocomplete="off"
                    >
                    <button type="submit" class="bg-primary-600 text-white font-semibold px-6 py-3 rounded-lg hover:bg-primary-700 transition">
                        Cari
                    </button>
                </div>
            </form>

            @if ($keyword === '')
                <div class="max-w-2xl mx-auto text-center text-gray-500">
                    Masukkan kata kunci untuk mulai menelusuri kelas dan artikel.
                </div>
            @else
                <div class="space-y-16">
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-semibold text-gray-900">Kelas</h2>
                            <span class="text-sm text-gray-500">{{ $courses->count() }} hasil</span>
                        </div>

                        @if ($courses->isEmpty())
                            <p class="text-gray-500">Tidak ada kelas yang cocok dengan pencarian "<strong>{{ $keyword }}</strong>".</p>
                        @else
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                                @foreach ($courses as $course)
                                    <div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-xl transition-shadow duration-300 border border-gray-100">
                                        <a href="{{ route('course.show', $course) }}">
                                            <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-48 object-cover">
                                        </a>
                                        <div class="p-6 flex flex-col gap-3">
                                            <div class="text-xs font-semibold uppercase tracking-widest text-primary-600">
                                                {{ optional($course->category)->name ?? 'Tanpa Kategori' }}
                                            </div>
                                            <h3 class="text-lg font-semibold text-gray-900 leading-tight line-clamp-2">
                                                <a href="{{ route('course.show', $course) }}" class="hover:text-primary-600 transition-colors">
                                                    {{ $course->title }}
                                                </a>
                                            </h3>
                                            @if ($course->instructor)
                                                <p class="text-sm text-gray-500">Instruktur: {{ $course->instructor }}</p>
                                            @endif
                                            <p class="text-sm text-gray-600 line-clamp-3">{{ \Illuminate\Support\Str::limit($course->description, 120) }}</p>
                                            <div class="flex items-center justify-between mt-auto pt-1">
                                                <span class="text-primary-600 font-bold">Rp{{ number_format($course->price, 0, ',', '.') }}</span>
                                                <a href="{{ route('course.show', $course) }}" class="text-sm font-semibold text-primary-600 hover:underline">
                                                    Lihat Detail
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-semibold text-gray-900">Artikel</h2>
                            <span class="text-sm text-gray-500">{{ $articles->count() }} hasil</span>
                        </div>

                        @if ($articles->isEmpty())
                            <p class="text-gray-500">Tidak ada artikel yang cocok dengan pencarian "<strong>{{ $keyword }}</strong>".</p>
                        @else
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                @include('article.partials.articles', ['articles' => $articles])
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
