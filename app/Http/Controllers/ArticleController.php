<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Afficher un article (Solution 1 : Route dynamique avec slug)
     */
    public function show($slug)
    {
        $article = Article::with('categories')
        ->where('slug', $slug)
            ->first();

        // 1. Récupérer l'article avec ses catégories
        // 3. Récupérer les articles similaires (même catégories)
        $categoryIds = $article->categories->pluck('id')->toArray();
        
        $similarArticles = Article::whereHas('categories', function ($query) use ($categoryIds) {
            $query->whereIn('categories.id', $categoryIds);
        })
        ->where('id', '!=', $article->id)
        ->where('status', 'publish')
        ->latest('datedecreation')
        ->limit(6)
        ->get();

        // 4. Retourner la vue
        return view('articles.show', compact('article', 'similarArticles'));
    }
}