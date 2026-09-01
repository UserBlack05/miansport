<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;


class combatController extends Controller

{
    public function index()
    {
        $category = Category::with('children.articles')->find(6);

$articles = $category->children
    ->flatMap->articles;

$mainArticle = $articles
    ->sortByDesc('datedecreation')
    ->first();

// Fil d'actualité (sidebar)
$feedItems = $articles
    ->where('id', '!=', $mainArticle->id ?? 0)
    ->sortByDesc('datedecreation')
    ->take(6);
            

        // Articles en grille (2x2)
        $autresArticles = $feedItems->pluck('id')->toArray();
        if ($mainArticle) {
            $autresArticles[] = $mainArticle->id;
        }

        $gridItems = $articles
            ->whereNotIn('id', $autresArticles)
            ->sortByDesc('datedecreation');
        // Vidéos
        $videos = [
            [
                'title' => 'Le résumé de la journée en sports collectifs',
                'duration' => '4:02',
                'time' => 'Il y a 5h',
                'image' => '',
                'alt' => 'Résumé sports collectifs'
            ],
            [
                'title' => 'Handball : les temps forts du dernier match',
                'duration' => '3:44',
                'time' => 'Il y a 1j',
                'image' => '',
                'alt' => 'Handball'
            ],
            [
                'title' => 'Volleyball : immersion dans un entraînement',
                'duration' => '2:58',
                'time' => 'Il y a 2j',
                'image' => '',
                'alt' => 'Volleyball'
            ],
            [
                'title' => 'Futsal : les meilleures actions de la saison',
                'duration' => '3:20',
                'time' => 'Il y a 3j',
                'image' => '',
                'alt' => 'Futsal'
            ]
        ];

        // Fil d'actualité complet (grid)
        

        return view('pages.sports.combat', compact(
            'mainArticle',
            'feedItems',
            'gridItems',
            'videos',
            
        ));
    }
}