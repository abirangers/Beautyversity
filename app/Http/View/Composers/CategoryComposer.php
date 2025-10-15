<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\ArticleCategory;

class CategoryComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $categories = ArticleCategory::whereHas('articles')
            ->withCount('articles')
            ->orderBy('name')
            ->limit(7)
            ->get();

        $view->with('articleCategories', $categories);
    }
}
