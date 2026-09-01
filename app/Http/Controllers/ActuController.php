<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActuController extends Controller
{
    public function index()
    {
        $highlights = [
            [
                'id' => 1,
                'title' => 'Georges Weah, de Monrovia au Ballon d\'Or',
                'category' => 'Football',
                'image' => 'WEAH',
                'alt' => 'Georges Weah',
                'type' => 'photo',
                'placeholder' => ''
            ],
            [
                'id' => 2,
                'title' => 'Immersion au cœur du club Africa Sports',
                'category' => 'Football',
                'image' => 'AFRICASPORTS',
                'alt' => 'Africa Sports',
                'type' => 'video',
                'placeholder' => ''
            ],
            [
                'id' => 3,
                'title' => 'Les Éléphants visent la CAN 2027',
                'category' => 'Basketball',
                'image' => '',
                'alt' => 'Basketball',
                'type' => 'photo',
                'placeholder' => 'basket'
            ]
        ];

        $feedItems = [
            [
                'id' => 1,
                'title' => 'Les Éléphants visent la CAN 2027 avec un nouveau staff',
                'category' => 'Basketball',
                'time' => 'Il y a 1h',
                'placeholder' => 'basket'
            ],
            [
                'id' => 2,
                'title' => 'Diallo qualifiée pour les quarts de finale',
                'category' => 'Tennis',
                'time' => 'Il y a 2h',
                'placeholder' => 'tennis'
            ],
            [
                'id' => 3,
                'title' => 'Africa Sports, la légende en quête d\'un second souffle',
                'category' => 'Football',
                'time' => 'Il y a 4h',
                'placeholder' => ''
            ],
            [
                'id' => 4,
                'title' => 'Un premier titre continental pour le poids welter ivoirien',
                'category' => 'Boxe',
                'time' => 'Il y a 5h',
                'placeholder' => 'boxe'
            ],
            [
                'id' => 5,
                'title' => '200m : un nouveau record national tombe à Abidjan',
                'category' => 'Athlétisme',
                'time' => 'Il y a 6h',
                'placeholder' => 'athle'
            ],
            [
                'id' => 6,
                'title' => 'La sélection ivoirienne se qualifie pour le tournoi régional',
                'category' => 'Rugby',
                'time' => 'Il y a 8h',
                'placeholder' => 'rugby'
            ],
            [
                'id' => 7,
                'title' => 'Premier titre continental pour la relève ivoirienne',
                'category' => 'Tennis',
                'time' => 'Il y a 9h',
                'placeholder' => 'tennis'
            ],
            [
                'id' => 8,
                'title' => 'Mercato : deux internationaux ivoiriens courtisés en Europe',
                'category' => 'Football',
                'time' => 'Il y a 11h',
                'placeholder' => ''
            ],
            [
                'id' => 9,
                'title' => 'Basketball féminin : portrait d\'une nouvelle génération',
                'category' => 'Basketball',
                'time' => 'Il y a 13h',
                'placeholder' => 'basket'
            ],
            [
                'id' => 10,
                'title' => 'Le programme complet de la soirée de gala à Abidjan',
                'category' => 'Boxe',
                'time' => 'Il y a 15h',
                'placeholder' => 'boxe'
            ],
            [
                'id' => 11,
                'title' => 'Un nouveau centre de formation ouvre ses portes',
                'category' => 'Rugby',
                'time' => 'Il y a 1j',
                'placeholder' => 'rugby'
            ],
            [
                'id' => 12,
                'title' => 'Jeux africains : la délégation ivoirienne dévoilée',
                'category' => 'Athlétisme',
                'time' => 'Il y a 1j',
                'placeholder' => 'athle'
            ]
        ];

        $sportCats = [
            ['label' => 'Football', 'active' => false],
            ['label' => 'Basketball', 'active' => false],
            ['label' => 'Tennis', 'active' => false],
            ['label' => 'Athlétisme', 'active' => false],
            ['label' => 'Boxe', 'active' => false],
            ['label' => 'Rugby', 'active' => false],
            ['label' => 'Tous les sports', 'active' => true]
        ];

        return view('pages.actu', compact('highlights', 'feedItems', 'sportCats'));
    }

    public function show($id)
    {
        // Pour afficher un article d'actualité spécifique
        $article = [
            'id' => $id,
            'title' => 'Article d\'actualité N°' . $id,
            'content' => 'Contenu de l\'article...',
            'category' => 'Football',
            'date' => 'Il y a 2h',
            'image' => '',
            'alt' => 'Article'
        ];

        return view('actu.show', compact('article'));
    }
}