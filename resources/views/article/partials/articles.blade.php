@foreach($articles as $article)
    <div class="bg-white rounded-lg shadow-sm hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100">
        <a href="{{ route('article.show', $article->id) }}">
            <img src="{{ $article->thumbnail ? asset('storage/' . $article->thumbnail) : 'https://via.placeholder.com/600x400.png' }}" alt="{{ $article->title }}"
                class="w-full h-48 object-cover">
        </a>
        <div class="p-6">
            @if ($article->category)
                <span class="text-xs font-bold uppercase tracking-widest text-primary-600 mb-2 inline-block">
                    {{ $article->category }}
                </span>
            @endif
            <p class="text-sm text-gray-500 mb-2">{{ $article->created_at->format('F j, Y') }}</p>
            <h2 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2">
                <a href="{{ route('article.show', $article->id) }}" class="hover:text-primary-600 transition-colors">
                    {{ $article->title }}
                </a>
            </h2>
            @if ($article->excerpt)
                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $article->excerpt }}</p>
            @endif
            <a href="{{ route('article.show', $article->id) }}"
                class="font-semibold text-primary-600 hover:underline">Baca Selengkapnya</a>
        </div>
    </div>
@endforeach
