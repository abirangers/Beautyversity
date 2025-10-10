<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article; // Import the Article model

class ArticleController extends Controller
{
    /**
     * Display a listing of the articles.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->paginate(9); // Fetch articles with pagination, 9 per page

        return view('article.index', compact('articles')); // Pass articles to the view
    }

    /**
     * Load more articles via AJAX.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loadMore(Request $request)
    {
        $page = $request->input('page', 1);
        $category = $request->input('category'); // Get category from request if present

        $query = Article::orderBy('created_at', 'desc');
        
        if ($category) {
            $query->where('category', $category); // Filter by category if provided
        }

        $articles = $query->paginate(9, ['*'], 'page', $page);

        // Return only the articles view fragment for AJAX
        $articlesHtml = view('article.partials.articles', compact('articles'))->render();

        return response()->json([
            'articles_html' => $articlesHtml,
            'has_more' => $articles->hasMorePages(),
        ]);
    }

    /**
     * Display articles filtered by category.
     *
     * @param  string $category
     * @return \Illuminate\View\View
     */
    public function showByCategory($category)
    {
        $articles = Article::where('category', $category)
                          ->orderBy('created_at', 'desc')
                          ->paginate(9); // Fetch articles for the specific category, ordered by creation date

        return view('article.category', compact('articles', 'category')); // Pass articles and category to the view
    }
}
