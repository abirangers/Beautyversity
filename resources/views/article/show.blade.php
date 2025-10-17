@extends('layouts.app')

@section('seo')
    {!! seo($article) !!}
@endsection

@section('content')

    <div class="bg-gray-50 py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-3xl">
            @if ($article->categories->isNotEmpty())
                @foreach ($article->categories as $category)
                    <a href="{{ route('article.category', $category->slug) }}" class="text-sm font-bold uppercase tracking-widest text-primary-600 mb-2 inline-block">
                        {{ $category->name }}
                    </a>
                @endforeach
            @endif
            @if (!empty($article->post_type) && $article->post_type !== 'post')
                <a href="#" class="text-sm font-bold uppercase tracking-widest text-primary-600 mb-2 inline-block ml-2">
                    {{ ucfirst($article->post_type) }}
                </a>
            @endif

            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight">
                {{ $article->title }}
            </h1>
            <p class="mt-4 text-base text-gray-500">
                Ditulis oleh <span class="font-semibold text-gray-700">{{ $article->author ?? 'Admin' }}</span>
                <span class="mx-2">&bull;</span>
                Dipublikasikan pada {{ $article->created_at->format('d F Y') }}
            </p>
        </div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <article class="max-w-4xl mx-auto">
            @if ($article->thumbnail)
                <div class="mb-8 rounded-lg overflow-hidden shadow-lg">
                    <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}"
                        class="w-full h-auto md:h-96 object-cover">
                </div>
            @endif

            <div class="rich-text-content">
                @if (!empty($article->excerpt))
                    <div class="mb-6">
                        <p class="text-lg font-semibold text-gray-700 italic">{{ $article->excerpt }}</p>
                    </div>
                @endif
                {!! $article->processed_content !!}
            </div>

            <div class="mt-12 pt-8 border-t border-gray-200">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    @if ($article->tags->isNotEmpty())
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-sm font-semibold text-gray-700">Tags:</span>
                            @foreach ($article->tags as $tag)
                                <a href="#"
                                    class="px-3 py-1 text-xs font-semibold text-primary-800 bg-primary-100 rounded-full hover:bg-primary-200 transition">
                                    {{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                    <div class="flex items-center gap-3">
                        <span class="text-sm font-semibold text-gray-700">Share this post:</span>
                        <div class="flex space-x-2">
                            <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ urlencode($article->title) }}"
                                target="_blank" class="text-gray-400 hover:text-gray-600">
                                <span class="sr-only">Twitter</span>
                                <i class="fab fa-twitter text-xl" aria-hidden="true"></i>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank"
                                class="text-gray-400 hover:text-gray-600">
                                <span class="sr-only">Facebook</span>
                                <i class="fab fa-facebook-f text-xl" aria-hidden="true"></i>
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . url()->current()) }}"
                                target="_blank" class="text-gray-400 hover:text-gray-600">
                                <span class="sr-only">WhatsApp</span>
                                <i class="fab fa-whatsapp text-xl" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </article>

    </div>

@endsection
