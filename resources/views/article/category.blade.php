@extends('layouts.app')

@section('title', $category)

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Category: {{ $category }}</h1>

    @if($articles->isEmpty())
        <p class="text-gray-600">No articles available in this category at the moment.</p>
    @else
        <div id="articles-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @include('article.partials.articles', ['articles' => $articles])
        </div>

        @if($articles->hasMorePages())
            <div class="mt-8 text-center">
                <button id="load-more-btn" 
                        class="px-6 py-3 bg-primary-600 text-white font-semibold rounded-md hover:bg-primary-700 transition-colors"
                        data-page="{{ $articles->currentPage() + 1 }}"
                        data-url="{{ route('article.load-more') }}"
                        data-category="{{ $category }}">
                    Load More
                </button>
                <div id="loading-spinner" class="hidden mt-4">
                    <svg class="animate-spin h-8 w-8 text-primary-60 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>
        @endif
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loadMoreBtn = document.getElementById('load-more-btn');
        const articlesContainer = document.getElementById('articles-container');
        const loadingSpinner = document.getElementById('loading-spinner');

        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', function() {
                const page = this.getAttribute('data-page');
                const url = this.getAttribute('data-url');
                const category = this.getAttribute('data-category'); // Get the category for the AJAX request

                // Show loading spinner and disable button
                loadingSpinner.classList.remove('hidden');
                loadMoreBtn.disabled = true;

                // Make AJAX request with category filter
                fetch(`${url}?page=${page}&category=${encodeURIComponent(category)}`)
                    .then(response => response.json())
                    .then(data => {
                        // Append new articles to the container
                        articlesContainer.insertAdjacentHTML('beforeend', data.articles_html);

                        // Update button page number
                        if (data.has_more) {
                            loadMoreBtn.setAttribute('data-page', parseInt(page) + 1);
                        } else {
                            // Hide button if no more articles
                            loadMoreBtn.style.display = 'none';
                        }

                        // Hide loading spinner and enable button
                        loadingSpinner.classList.add('hidden');
                        loadMoreBtn.disabled = false;
                    })
                    .catch(error => {
                        console.error('Error loading more articles:', error);
                        // Hide loading spinner and enable button
                        loadingSpinner.classList.add('hidden');
                        loadMoreBtn.disabled = false;
                    });
            });
        }
    });
</script>
@endsection