<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $courses = \App\Models\Course::with('category')->latest()->limit(6)->get();
        $articles = \App\Models\Article::with('categories', 'tags')->latest()->limit(3)->get();

        return view('home', compact('courses', 'articles'));
    }
    
    public function showArticle(string $slug)
    {
        $article = \App\Models\Article::with('categories', 'tags')
            ->withRichText('body')
            ->where('slug', $slug)
            ->firstOrFail();
        
        return view('article.show', compact('article'));
    }
}
