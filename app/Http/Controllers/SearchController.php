<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Course;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle keyword search for courses and articles.
     */
    public function index(Request $request)
    {
        $keyword = trim((string) $request->input('q', ''));

        $courses = collect();
        $articles = collect();

        if ($keyword !== '') {
            $courses = Course::with('category')
                ->where(function ($query) use ($keyword) {
                    $query->where('title', 'like', "%{$keyword}%")
                        ->orWhere('description', 'like', "%{$keyword}%")
                        ->orWhere('instructor', 'like', "%{$keyword}%");
                })
                ->orderByDesc('created_at')
                ->limit(12)
                ->get();

            $articles = Article::with('categories', 'tags')
                ->where(function ($query) use ($keyword) {
                    $query->where('title', 'like', "%{$keyword}%")
                        ->orWhere('excerpt', 'like', "%{$keyword}%")
                        ->orWhere('content', 'like', "%{$keyword}%")
                        ->orWhere('author', 'like', "%{$keyword}%");
                })
                ->orderByDesc('created_at')
                ->limit(12)
                ->get();
        }

        return view('search.index', [
            'keyword' => $keyword,
            'courses' => $courses,
            'articles' => $articles,
        ]);
    }
}
