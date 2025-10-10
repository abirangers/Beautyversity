@extends('layouts.admin')

@section('title', 'Create New Article')

@section('content')

    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8">
            <div>
                <a href="{{ route('admin.articles.index') }}"
                    class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
                    <i class="fas fa-arrow-left w-5 h-5 mr-2 text-sm"></i>
                    Back to Articles
                </a>
            </div>
            <div class="mt-4 sm:mt-0">
                <button type="submit"
                    class="inline-flex items-center justify-center px-6 py-2.5 bg-primary-600 text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-primary-700 transition-colors duration-300">
                    Create Article
                </button>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6 md:p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                            class="w-full block px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="author" class="block text-sm font-medium text-gray-700 mb-2">Author</label>
                        <input type="text" name="author" id="author" value="{{ old('author') }}" required
                            class="w-full block px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                        @error('author')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <input type="text" name="category" id="category" value="{{ old('category') }}"
                            class="w-full block px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                        @error('category')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tags" class="block text-sm font-medium text-gray-700 mb-2">Tags (comma-separated)</label>
                        <input type="text" name="tags" id="tags" value="{{ old('tags') }}"
                            class="w-full block px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                        @error('tags')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="post_type" class="block text-sm font-medium text-gray-700 mb-2">Post Type</label>
                        <input type="text" name="post_type" id="post_type" value="{{ old('post_type', 'post') }}"
                            class="w-full block px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                        @error('post_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-2">Thumbnail</label>
                        <input type="file" name="thumbnail" id="thumbnail"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                        @error('thumbnail')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">Ringkasan Artikel</label>
                        <textarea name="excerpt" id="excerpt" rows="3"
                            class="w-full block px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">{{ old('excerpt') }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">Opsional: Ringkasan singkat dari artikel (akan ditampilkan sebelum isi lengkap artikel)</p>
                        @error('excerpt')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                        <textarea name="content" id="content" rows="12" required
                            class="w-full block px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">{{ old('content') }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="px-6 md:px-8 py-4 bg-gray-50 border-t border-gray-200 rounded-b-lg flex justify-end">
                <button type="submit"
                    class="inline-flex items-center justify-center px-6 py-2.5 bg-primary-600 text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-primary-700 transition-colors duration-300">
                    Create Article
                </button>
            </div>
        </div>
    </form>

@endsection
