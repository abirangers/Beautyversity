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
        $articles = Article::orderBy('created_at', 'desc')->paginate(9, ['*'], 'page', $page);

        // Return only the articles view fragment for AJAX
        $articlesHtml = view('article.partials.articles', compact('articles'))->render();

        return response()->json([
            'articles_html' => $articlesHtml,
            'has_more' => $articles->hasMorePages(),
        ]);
    }
}
