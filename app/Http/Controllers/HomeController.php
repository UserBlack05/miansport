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

        $portraits = [
            [
                'image' => '1. Arouna Ouattara.png',
                'title' => 'Il a quitté l\'Europe pour former les jeunes à Abidjan',
                'author' => 'JEAN-BERNARD PADARÉ'
            ],
            [
                'image' => '',
                'title' => 'Les bâtisseurs du sport ivoirien racontent leur parcours',
                'author' => 'JEAN-BERNARD PADARÉ'
            ],
            [
                'image' => '',
                'title' => 'La nouvelle génération veut écrire son histoire',
                'author' => 'JEAN-BERNARD PADARÉ'
            ],
            [
                'image' => '',
                'title' => 'Africa Sports : la légende qui cherche son second souffle',
                'author' => 'JEAN-BERNARD PADARÉ'
            ]
        ];

        $category = Category::with('children.articles')->find(20);
       $articles = $category->children
       ->flatMap->articles;
        $raquettemainArticle = $articles->sortByDesc('datedecreation')
       ->first();
       $raquettefeedItems = $articles->where('id', '!=', $raquettemainArticle->id ?? 0)
        ->sortByDesc('datedecreation')
        ->take(6);

        $cyclisme = [
            'feature_kicker' => 'Cyclisme',
            'feature_title' => 'Routes d\'Afrique : les grands défis cyclistes',
            'items' => [
                ['kicker' => 'Courses', 'title' => 'Le Tour d\'Afrique en approche'],
                ['kicker' => 'Équipes', 'title' => 'Les nouvelles formations ivoiriennes'],
                ['kicker' => 'Jeunes', 'title' => 'La relève cycliste se prépare'],
                ['kicker' => 'Infrastructures', 'title' => 'Les vélodromes se modernisent']
            ]
        ];

        $mecaniques = [
            ['kicker' => 'Vitesse', 'title' => 'F1, rallye et grands circuits : la course au sommet'],
            ['kicker' => 'Auto', 'title' => 'Rallye'],
            ['kicker' => 'Moto', 'title' => 'Grand Prix']
        ];

        $univers = [
            ['kicker' => 'Société', 'title' => 'Sport féminin'],
            ['kicker' => 'Inclusion', 'title' => 'Parasport'],
            ['kicker' => 'Transmission', 'title' => 'Jeunesse & formation'],
            ['kicker' => 'Culture', 'title' => 'Sports traditionnels africains']
        ];

        $aquatiques = [
            'main_title' => 'Natation, plongeon et sports nautiques : les compétitions à venir',
            'side' => [
                ['title' => 'La natation ivoirienne se prépare pour les Jeux', 'slug' => 'natation-jeux'],
                ['title' => 'Le plongeon : une discipline en développement', 'slug' => 'plongeon-developpement'],
                ['title' => 'Les sports nautiques gagnent en popularité', 'slug' => 'nautiques-popularite']
            ]
        ];

        $gymnastique = [
            'feature_kicker' => 'Gymnastique',
            'feature_title' => 'Gymnastique et disciplines artistiques : la performance en mouvement',
            'items' => [
                ['kicker' => 'Artistique', 'title' => 'Les compétitions nationales'],
                ['kicker' => 'Rythmique', 'title' => 'L\'élégance en mouvement'],
                ['kicker' => 'Acrobatique', 'title' => 'Des performances spectaculaires'],
                ['kicker' => 'Trampoline', 'title' => 'Une discipline qui prend son envol']
            ]
        ];

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

        $precision = [
            [
                'kicker' => 'Outdoor',
                'title' => 'Glisse, nature et sports urbains',
                'description' => 'Skate, surf, escalade, randonnée et nouvelles pratiques.'
            ],
            [
                'kicker' => 'Urban',
                'title' => 'Skate & street'
            ],
            [
                'kicker' => 'Glisse',
                'title' => 'Surf & glisse'
            ],
            [
                'kicker' => 'Outdoor',
                'title' => 'Outdoor'
            ],
            [
                'kicker' => 'Outdoor',
                'title' => 'Outdoor'
            ]
        ];

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
            'portraits',
            'cyclisme',
            'mecaniques',
            'univers',
            'aquatiques',
            'gymnastique',
            'videos',
            'precision',
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