@extends('layouts.admin')

@section('title', 'Edit Article')

@section('content')

    <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data" x-data="{ status: '{{ old('status', $article->status ?? 'draft') }}' }">
        @csrf
        @method('PUT')
        <!-- ===== Page Header ===== -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8">
            <div>
                <a href="{{ route('admin.articles.index') }}"
                    class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
                    <i class="fas fa-arrow-left w-5 h-5 mr-2 text-sm"></i>
                    Back to Articles
                </a>
            </div>
            <div class="mt-4 sm:mt-0 flex items-center space-x-3">
                <a href="{{ route('admin.articles.show', $article->id) }}"
                    class="inline-flex items-center justify-center px-5 py-2.5 bg-white border border-gray-300 text-gray-700 font-semibold text-sm rounded-lg shadow-sm hover:bg-gray-50 transition-colors duration-300">
                    View Article
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center px-6 py-2.5 bg-primary-600 text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-primary-700 transition-colors duration-300">
                    Update Article
                </button>
            </div>
        </div>

        <!-- ===== Form Content ===== -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6 md:p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <!-- Article Title & Slug -->
                    <div class="md:col-span-2 space-y-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}"
                                required placeholder="e.g., 5 Tips Skincare untuk Kulit Berminyak"
                                class="w-full block px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                            <input type="text" name="slug" id="slug" value="{{ old('slug', $article->slug) }}"
                                placeholder="e.g., tips-skincare-kulit-berminyak (leave blank to auto-generate from title)"
                                class="w-full block px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                            <p class="mt-1 text-xs text-gray-500">Slug menentukan URL publik. Kosongkan untuk auto-generate dari title, atau gunakan huruf kecil dan tanda hubung untuk manual override.</p>
                            @error('slug')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Author -->
                    <div>
                        <label for="author" class="block text-sm font-medium text-gray-700 mb-2">Author</label>
                        <input type="text" name="author" id="author" value="{{ old('author', $article->author ?? Auth::user()->name) }}"
                            required placeholder="e.g., Dr. Amanda Larasati, Beauty Expert"
                            class="w-full block px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                        <p class="mt-1 text-xs text-gray-500">Keep existing author or update to your name. You can edit if needed.</p>
                        @error('author')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    @php
                        $selectedCategories = old('categories', $article->categories->pluck('id')->toArray());
                        $selectedTags = old('tags', $article->tags->pluck('id')->toArray());
                        $currentFormat = old('content_format', $article->content_format);
                    @endphp

                    <input type="hidden" name="content_format" value="{{ $currentFormat }}">

                    <div>
                        <label for="categories" class="block text-sm font-medium text-gray-700 mb-2">Categories</label>
                        <select name="categories[]" id="categories" multiple required
                            class="select2-categories w-full block px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ in_array($category->id, $selectedCategories) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Pilih satu atau lebih kategori.</p>
                        @error('categories')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @error('categories.*')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tags" class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                        <select name="tags[]" id="tags" multiple
                            class="select2-tags w-full block px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}" {{ in_array($tag->id, $selectedTags) ? 'selected' : '' }}>
                                    {{ $tag->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Opsional: pilih beberapa tag.</p>
                        @error('tags')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @error('tags.*')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="post_type" class="block text-sm font-medium text-gray-700 mb-2">Post Type</label>
                        <input type="text" name="post_type" id="post_type" value="{{ old('post_type', $article->post_type ?? 'post') }}"
                            placeholder="e.g., post, page, tutorial"
                            class="w-full block px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                        @error('post_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" id="status" required x-model="status"
                            class="w-full block px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                            <option value="draft" {{ old('status', $article->status ?? 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $article->status ?? 'draft') === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="scheduled" {{ old('status', $article->status ?? 'draft') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Choose the publication status for this article.</p>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-show="status === 'scheduled'" x-transition>
                        <label for="scheduled_at" class="block text-sm font-medium text-gray-700 mb-2">Schedule Date & Time</label>
                        <input type="datetime-local" name="scheduled_at" id="scheduled_at" 
                            value="{{ old('scheduled_at', $article->scheduled_at ? $article->scheduled_at->format('Y-m-d\TH:i') : '') }}"
                            x-bind:required="status === 'scheduled'"
                            x-init="if (status === 'scheduled') { 
                                const now = new Date();
                                now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
                                $el.min = now.toISOString().slice(0, 16);
                            }"
                            class="w-full block px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                        <p class="mt-1 text-xs text-gray-500">Select when this article should be published.</p>
                        @error('scheduled_at')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Thumbnail -->
                    <div>
                        <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-2">Thumbnail</label>
                        <div class="flex items-center space-x-6">
                            @if ($article->thumbnail)
                                <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="Current Thumbnail"
                                    class="h-16 w-16 object-cover rounded-lg">
                            @endif
                            <input type="file" name="thumbnail" id="thumbnail"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Leave blank to keep the current thumbnail.</p>
                        @error('thumbnail')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Excerpt -->
                    <div class="md:col-span-2">
                        <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">Ringkasan Artikel</label>
                        <textarea name="excerpt" id="excerpt" rows="3"
                            placeholder="Ringkasan singkat artikel yang akan ditampilkan di halaman utama..."
                            class="w-full block px-4 py-2.5 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">{{ old('excerpt', $article->excerpt) }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">Opsional: Ringkasan singkat dari artikel (akan ditampilkan sebelum isi lengkap artikel)</p>
                        @error('excerpt')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Content -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                        @if ($currentFormat === 'rich_text')
                            <x-trix-input id="body" name="body" value="{!! old('body', optional($article->body)->toTrixHtml()) !!}" />
                            @error('body')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        @else
                            <textarea name="content" id="content" rows="12" required
                                class="w-full block px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">{{ old('content', $article->content) }}</textarea>
                            @error('content')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500">Konten ini masih memakai format WordPress. Gunakan migrasi untuk konversi penuh.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Form Footer Actions -->
            <div class="px-6 md:px-8 py-4 bg-gray-50 border-t border-gray-200 rounded-b-lg flex justify-end">
                <button type="submit"
                    class="inline-flex items-center justify-center px-6 py-2.5 bg-primary-600 text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-primary-700 transition-colors duration-300">
                    Update Article
                </button>
            </div>
        </div>
    </form>

@endsection

