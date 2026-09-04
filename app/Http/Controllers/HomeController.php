<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $heroSlides = $articles = Article::with('categories')
        ->orderBy('datedecreation', 'desc')->limit(3)->get();


        $articles = Article::with('categories')
        ->orderBy('datedecreation', 'desc')->limit(3)->get();

        $une = $articles->first();
        
        $uneArticles = $articles->skip(1)->take(2)->values();

        $category = Category::with('articles')->find(8);
        $article = $category->articles;
        $footballmainArticle = $article->sortByDesc('datedecreation')
        ->first();
        $footballfeedItems = $article->where('id', '!=', $footballmainArticle->id ?? 0)
        ->sortByDesc('datedecreation')
        ->take(3);


         $category = Category::with('articles')->find(4);
        $article = $category->articles;
        $basketmainArticle = $article
         ->sortByDesc('datedecreation')
         ->first();
        $basketfeedItems = $article->where('id', '!=', $basketmainArticle->id ?? 0)
        ->sortByDesc('datedecreation')
        ->take(3);


        $magazine = [
            'id' => 1,
            'edition' => '12',
            'title' => 'Georges Weah, de Monrovia au Ballon d\'Or',
            'cover' => '',
            'covers' => [
                ['id' => 1, 'alt' => 'Magazine Africa Sports', 'image' => '', 'class' => 'left'],
                ['id' => 2, 'alt' => 'Portrait associé à l\'édition', 'image' => '', 'class' => 'center portrait'],
                ['id' => 3, 'alt' => 'Magazine Africa Sports', 'image' => '', 'class' => 'right']
            ]
        ];

        $category = Category::with('children.articles')->find(3);
       $articles = $category->children
    ->flatMap->articles;
        $collectifmainArticle = $articles->sortByDesc('datedecreation')
       ->first();
       $collectiffeedItems = $articles->where('id', '!=', $collectifmainArticle->id ?? 0)
        ->sortByDesc('datedecreation')
        ->take(6);

       $category = Category::with('children.articles')->find(6);
       $articles = $category->children
       ->flatMap->articles;
        $combatmainArticle = $articles->sortByDesc('datedecreation')
        ->take(2);
       $combatfeedItems = $articles->whereNotIn(
        'id',
        $combatmainArticle->pluck('id')
    )
        ->sortByDesc('datedecreation')
        ->take(2);

        $category = Category::with('children.articles')->find(2);
       $articles = $category->children
    ->flatMap->articles;
        $athletismemainArticle = $articles->sortByDesc('datedecreation')
       ->first();
       $athletismefeedItems = $articles->where('id', '!=', $athletismemainArticle->id ?? 0)
        ->sortByDesc('datedecreation')
        ->take(6);

        $competitions = [
            [
                'title' => 'Coupe de monde de rugby',
                'description' => 'La sélection ivoirienne se qualifie pour le tournoi régional.',
                'image' => '1. Arouna Ouattara.png',
                'alt' => 'Compétition'
            ],
            [
                'title' => 'CAN',
                'description' => 'La sélection ivoirienne se prépare pour les grands rendez-vous.',
                'image' => '',
                'alt' => 'CAN'
            ],
            [
                'title' => 'CAN',
                'description' => 'Les échéances africaines et internationales à suivre.',
                'image' => '',
                'alt' => 'Compétition'
            ]
        ];

        $category = Category::with('articles')->find(36);
       $articles = $category->articles;
       $portraitfeedItems = $articles->sortByDesc('datedecreation')
        ->take(4);


        $category = Category::with('children.articles')->find(20);
       $articles = $category->children
       ->flatMap->articles;
        $raquettemainArticle = $articles->sortByDesc('datedecreation')
       ->first();
       $raquettefeedItems = $articles->where('id', '!=', $raquettemainArticle->id ?? 0)
        ->sortByDesc('datedecreation')
        ->take(6);

       $category = Category::with('children.articles')->find(7);
       $articles = $category->articles;
        $cyclismemainArticle = $articles->sortByDesc('datedecreation')
       ->first();
       $cyclismefeedItems = $articles->where('id', '!=', $cyclismemainArticle->id ?? 0)
        ->sortByDesc('datedecreation')
        ->take(4);


        $category = Category::with('children.articles')->find(21);
       $articles = $category->children
       ->flatMap->articles;
       $mecaniquefeedItems = $articles->sortByDesc('datedecreation')
        ->take(3);

        $univers = [
            ['kicker' => 'Société', 'title' => 'Sport féminin'],
            ['kicker' => 'Inclusion', 'title' => 'Parasport'],
            ['kicker' => 'Transmission', 'title' => 'Jeunesse & formation'],
            ['kicker' => 'Culture', 'title' => 'Sports traditionnels africains']
        ];

         $category = Category::with('children.articles')->find(18);
       $articles = $category->children
       ->flatMap->articles;
        $aquatiquemainArticle = $articles->sortByDesc('datedecreation')
       ->first();
       $aquatiquefeedItems = $articles->where('id', '!=', $aquatiquemainArticle->id ?? 0)
        ->sortByDesc('datedecreation')
        ->take(6);


         $category = Category::with('children.articles')->find(10);
       $articles = $category->children
       ->flatMap->articles;
        $gymnastiquemainArticle = $articles->sortByDesc('datedecreation')
       ->first();
       $gymnastiquefeedItems = $articles->where('id', '!=', $gymnastiquemainArticle->id ?? 0)
        ->sortByDesc('datedecreation')
        ->take(4);


        $videos = [
            [
                'title' => 'Interview exclusive : Weah revient sur son sacre',
                'duration' => '6:42',
                'image' => '',
                'alt' => 'Interview Weah',
                'placeholder' => 'athle'
            ],
            [
                'title' => 'Immersion au cœur du club Africa Sports',
                'duration' => '4:18',
                'image' => '',
                'alt' => 'Africa Sports',
                'placeholder' => 'athle'
            ],
            [
                'title' => 'Le résumé du match Éléphants – Sénégal',
                'duration' => '3:05',
                'image' => '',
                'alt' => 'Match Éléphants Sénégal',
                'placeholder' => 'basket'
            ],
            [
                'title' => 'Athlétisme : la relève ivoirienne à l\'entraînement',
                'duration' => '2:40',
                'image' => '',
                'alt' => 'Athlétisme',
                'placeholder' => 'athle'
            ]
        ];

         $category = Category::with('children.articles')->find(19);
       $articles = $category->children
       ->flatMap->articles;
       $precisionfeedItems = $articles->sortByDesc('datedecreation')
        ->take(5);


        $dossiers = [
            ['kicker' => 'Dossier', 'title' => 'Les grandes mutations du sport africain'],
            ['kicker' => 'Analyse', 'title' => 'Économie, clubs et nouvelles ambitions'],
            ['kicker' => 'Enquête', 'title' => 'Dans les coulisses des grandes compétitions']
        ];

        $category = Category::with('children.articles')->find(17);
       $articles = $category->articles;
        $buisnessmainArticle = $articles->sortByDesc('datedecreation')
       ->first();
       $buisnessfeedItems = $articles->where('id', '!=', $buisnessmainArticle->id ?? 0)
        ->sortByDesc('datedecreation')
        ->take(4);

        return view('pages.home', compact(
            'heroSlides',
            'une',
            'uneArticles',
            'magazine',
            'competitions',
            'portraitfeedItems',
            'cyclismemainArticle',
            'cyclismefeedItems',
            'mecaniquefeedItems',
            'univers',
            'aquatiquemainArticle',
            'aquatiquefeedItems',
            'gymnastiquemainArticle',
            'gymnastiquefeedItems',
            'videos',
            'precisionfeedItems',
            'dossiers',
            'buisnessfeedItems',
            'buisnessmainArticle',
            'raquettefeedItems',
            'raquettemainArticle',
            'athletismefeedItems',
            'athletismemainArticle',
            'combatfeedItems',
            'combatmainArticle',
            'collectiffeedItems',
            'collectifmainArticle',
            'basketfeedItems',
            'basketmainArticle',
            'footballfeedItems',
            'footballmainArticle'

        ));
    }
}