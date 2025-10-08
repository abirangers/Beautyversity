@extends('layouts.admin')

@section('title', 'View Article')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">View Article</h1>
        <div>
            <a href="{{ route('admin.articles.edit', $article->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 mr-2">
                Edit Article
            </a>
            <a href="{{ route('admin.articles.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                Back to Articles
            </a>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <h2 class="text-2xl font-bold mb-2">{{ $article->title }}</h2>
            <p class="text-gray-600 mb-4">by {{ $article->author }} • {{ $article->created_at->format('d M Y') }}</p>
            
            @if($article->thumbnail && $article->thumbnail != 'default-article.jpg')
                <div class="mb-6">
                    <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-64 object-cover rounded-md">
                </div>
            @endif
            
            <div class="prose max-w-none">
                {!! nl2br(e($article->content)) !!}
            </div>
        </div>
    </div>
</div>
@endsection