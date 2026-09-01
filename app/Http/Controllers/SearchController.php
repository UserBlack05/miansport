<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = $request->validate(['q' => ['nullable', 'string', 'max:100']])['q'] ?? '';
        $articles = Article::with('category')->when($query, fn ($builder) => $builder->where('title', 'like', "%{$query}%"))->latest('published_at')->paginate(12)->withQueryString();
        return view('pages.list', ['title' => $query ? "Recherche : {$query}" : 'Recherche', 'articles' => $articles]);
    }
}
