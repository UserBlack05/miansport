<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
 

class portraitController extends Controller

{
    public function index()
    {
        // Données pour l'article principal
       $category = Category::with('articles')->find(36);
       $article = $category->articles;
       $mainArticle = $article->sortByDesc('datedecreation')
       ->first();
        // Données pour l'article principal
            

        // Fil d'actualité (sidebar)
        $feedItems =  $article
        ->sortByDesc('datedecreation')
        ->take(6);
            
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
        

        return view('pages.portrait', compact(
            'mainArticle',
            'feedItems',
            'videos',
            
        ));
    }
}