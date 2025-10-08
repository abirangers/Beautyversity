<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $courses = \App\Models\Course::latest()->limit(6)->get();
        $articles = \App\Models\Article::latest()->limit(3)->get();

        return view('home', compact('courses', 'articles'));
    }
    
    public function showArticle($id)
    {
        $article = \App\Models\Article::findOrFail($id);
        
        return view('article.show', compact('article'));
    }
}
