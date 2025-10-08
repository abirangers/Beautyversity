@extends('layouts.admin')

@section('title', 'Create Article')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Create New Article</h1>
        <a href="{{ route('admin.articles.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
            Back to Articles
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="author" class="block text-sm font-medium text-gray-700 mb-1">Author</label>
                    <input type="text" name="author" id="author" value="{{ old('author') }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('author')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-1">Thumbnail</label>
                    <input type="file" name="thumbnail" id="thumbnail"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('thumbnail')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="col-span-2">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                    <textarea name="content" id="content" rows="10" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            
            <div class="mt-6">
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Create Article
                </button>
            </div>
        </form>
    </div>
</div>
@endsection