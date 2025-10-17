@extends('layouts.app')

@section('title', 'Articles')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Articles</h1>

    @if($articles->isEmpty())
        <p class="text-gray-600">No articles available at the moment.</p>
    @else
        <div x-data="articleLoader()" class="space-y-8">
            <div id="articles-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @include('article.partials.articles', ['articles' => $articles])
            </div>

            @if($articles->hasMorePages())
                <div class="mt-8 text-center">
                    <button @click="loadMore()"
                            :disabled="loading"
                            class="px-6 py-3 bg-primary-600 text-white font-semibold rounded-md hover:bg-primary-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        <span x-show="!loading">Load More</span>
                        <span x-show="loading">Loading...</span>
                    </button>
                    <div x-show="loading" class="mt-4">
                        <svg class="animate-spin h-8 w-8 text-primary-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>
            @endif
        </div>
    @endif

    <script>
        function articleLoader(categorySlug = null) {
            return {
                loading: false,
                page: {{ $articles->currentPage() + 1 }},
                hasMore: {{ $articles->hasMorePages() ? 'true' : 'false' }},
                categorySlug: categorySlug,
                
                async loadMore() {
                    if (this.loading || !this.hasMore) return;
                    
                    this.loading = true;
                    
                    try {
                        const params = { page: this.page };
                        if (this.categorySlug) {
                            params.category_slug = this.categorySlug;
                        }
                        
                        const response = await axios.get('{{ route("article.load-more") }}', { params });
                        const data = response.data;
                        
                        // Append new articles to the container
                        document.getElementById('articles-container').insertAdjacentHTML('beforeend', data.articles_html);
                        
                        // Update state
                        if (data.has_more) {
                            this.page++;
                        } else {
                            this.hasMore = false;
                        }
                        
                    } catch (error) {
                        console.error('Error loading more articles:', error);
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }
    </script>
</div>
@endsection