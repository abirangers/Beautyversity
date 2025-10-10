<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Article;

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
        // Ambil semua kategori unik dari database, filter yang kosong, dan batasi jumlahnya
        $categories = Article::select('category')
                            ->whereNotNull('category')
                            ->where('category', '!=', '')
                            ->distinct()
                            ->limit(7) // Batasi agar tidak terlalu banyak di header
                            ->pluck('category');

        $view->with('articleCategories', $categories);
    }
}