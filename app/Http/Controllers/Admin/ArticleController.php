<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Handle tag creation and return array of tag IDs
     */
    private function handleTags($tags)
    {
        if (empty($tags)) {
            return [];
        }

        $tagIds = [];
        
        foreach ($tags as $tag) {
            $tagName = trim($tag);
            if (empty($tagName)) {
                continue;
            }
            
            // Check if tag exists by name first
            $existingTag = Tag::where('name', $tagName)->first();
            if ($existingTag) {
                $tagIds[] = $existingTag->id;
            } else {
                // Create new tag
                $newTag = Tag::create([
                    'name' => $tagName,
                    'slug' => Str::slug($tagName)
                ]);
                $tagIds[] = $newTag->id;
            }
        }
        
        return $tagIds;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::with('categories', 'tags')->latest()->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ArticleCategory::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('admin.articles.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
            'content_format' => 'required|string|in:wordpress,rich_text',
            'content' => 'nullable|required_if:content_format,wordpress',
            'body' => 'nullable|required_if:content_format,rich_text',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'author' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'post_type' => 'nullable|string|max:255',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:article_categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:255', // Allow both existing IDs and new tag names
        ]);

        // Auto-fill author if empty (backup safety)
        if (empty($data['author'])) {
            $data['author'] = Auth::user()->name;
        }

        $thumbnail = 'default-article.jpg';
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail')->store('articles', 'public');
        }

        $article = Article::create([
            'content_format' => $data['content_format'],
            'title' => $data['title'],
            'slug' => $data['slug'],
            'content' => $data['content'] ?? null,
            'body' => $data['body'] ?? null,
            'thumbnail' => $thumbnail,
            'author' => $data['author'],
            'excerpt' => $data['excerpt'] ?? null,
            'post_type' => $data['post_type'] ?? 'post',
        ]);

        $article->categories()->sync($data['categories']);
        
        // Handle tags (both existing and new ones)
        $tagIds = $this->handleTags($data['tags'] ?? []);
        $article->tags()->sync($tagIds);

        return redirect()->route('admin.articles.index')->with('success', 'Article created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $article = Article::with('categories', 'tags')
            ->withRichText('body')
            ->findOrFail($id);
        return view('admin.articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $article = Article::with('categories', 'tags')
            ->withRichText('body')
            ->findOrFail($id);
        $categories = ArticleCategory::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('admin.articles.edit', compact('article', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($request->filled('slug')) {
            $request->merge([
                'slug' => Str::slug($request->input('slug')),
            ]);
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('articles', 'slug')->ignore($id),
            ],
            'content_format' => 'required|string|in:wordpress,rich_text',
            'content' => 'nullable|required_if:content_format,wordpress',
            'body' => 'nullable|required_if:content_format,rich_text',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'author' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'post_type' => 'nullable|string|max:255',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:article_categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:255', // Allow both existing IDs and new tag names
        ]);

        // Auto-fill author if empty (backup safety)
        if (empty($data['author'])) {
            $data['author'] = Auth::user()->name;
        }

        $article = Article::findOrFail($id);

        $payload = [
            'content_format' => $data['content_format'],
            'title' => $data['title'],
            'slug' => $data['slug'],
            'content' => $data['content'] ?? null,
            'body' => $data['body'] ?? null,
            'author' => $data['author'],
            'excerpt' => $data['excerpt'] ?? null,
            'post_type' => $data['post_type'] ?? 'post',
        ];

        if ($request->hasFile('thumbnail')) {
            $payload['thumbnail'] = $request->file('thumbnail')->store('articles', 'public');
        }

        $article->update($payload);
        $article->categories()->sync($data['categories']);
        
        // Handle tags (both existing and new ones)
        $tagIds = $this->handleTags($data['tags'] ?? []);
        $article->tags()->sync($tagIds);

        return redirect()->route('admin.articles.index')->with('success', 'Article updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Article deleted successfully.');
    }
}
