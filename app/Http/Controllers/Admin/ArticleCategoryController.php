<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleCategoryController extends Controller
{
    public function index()
    {
        $categories = ArticleCategory::withCount('articles')->latest()->paginate(10);

        return view('admin.article-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.article-categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:article_categories,name',
            'slug' => 'nullable|string|max:255|unique:article_categories,slug',
            'description' => 'nullable|string',
        ]);

        $data['slug'] = Str::slug($data['slug'] ?? $data['name']);

        ArticleCategory::create($data);

        return redirect()->route('admin.article-categories.index')->with('success', 'Article category created successfully.');
    }

    public function edit(ArticleCategory $articleCategory)
    {
        return view('admin.article-categories.edit', [
            'category' => $articleCategory,
        ]);
    }

    public function update(Request $request, ArticleCategory $articleCategory)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:article_categories,name,' . $articleCategory->id,
            'slug' => 'nullable|string|max:255|unique:article_categories,slug,' . $articleCategory->id,
            'description' => 'nullable|string',
        ]);

        $data['slug'] = Str::slug($data['slug'] ?? $data['name']);

        $articleCategory->update($data);

        return redirect()->route('admin.article-categories.index')->with('success', 'Article category updated successfully.');
    }

    public function destroy(ArticleCategory $articleCategory)
    {
        $articleCategory->delete();

        return redirect()->route('admin.article-categories.index')->with('success', 'Article category deleted successfully.');
    }
}

