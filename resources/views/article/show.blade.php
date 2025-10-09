@extends('layouts.app')

@section('title', $article->title)

@section('content')

    <div class="bg-gray-50 py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-3xl">
            @if (!empty($article->category))
                <a href="#" class="text-sm font-bold uppercase tracking-widest text-primary-600 mb-2 inline-block">
                    {{ $article->category }}
                </a>
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

            <div class="prose prose-lg max-w-none text-gray-800">
                @if (!empty($article->excerpt))
                    <div class="mb-6">
                        <p class="text-lg font-semibold text-gray-700 italic">{{ $article->excerpt }}</p>
                    </div>
                @endif
                {!! $article->processed_content !!}
            </div>

            <div class="mt-12 pt-8 border-t border-gray-200">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    @if (!empty($article->tags))
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-sm font-semibold text-gray-700">Tags:</span>
                            @foreach (explode(',', $article->tags) as $tag)
                                <a href="#"
                                    class="px-3 py-1 text-xs font-semibold text-primary-800 bg-primary-100 rounded-full hover:bg-primary-200 transition">
                                    {{ trim($tag) }}
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
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path
                                        d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.71v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                </svg>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank"
                                class="text-gray-400 hover:text-gray-600">
                                <span class="sr-only">Facebook</span>
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . url()->current()) }}"
                                target="_blank" class="text-gray-400 hover:text-gray-600">
                                <span class="sr-only">WhatsApp</span>
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M18.423 5.577c-1.89-1.89-4.4-2.924-7.023-2.924S6.27 3.688 4.38 5.577a9.886 9.886 0 000 13.98c1.89 1.89 4.4 2.924 7.023 2.924a9.9 9.9 0 007.023-2.924 9.886 9.886 0 000-13.98zM12 20.25a8.25 8.25 0 100-16.5 8.25 8.25 0 000 16.5z"
                                        clip-rule="evenodd" />
                                    <path
                                        d="M12 6.75a.75.75 0 01.75.75v3.75h3.75a.75.75 0 010 1.5h-3.75V15a.75.75 0 01-1.5 0v-2.25H7.5a.75.75 0 010-1.5h3.75V7.5a.75.75 0 01.75-.75z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </article>

    </div>

@endsection
