<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        $featuredVideo = [
            'id' => 1,
            'title' => 'Interview exclusive : Weah revient sur son sacre au Ballon d\'Or',
            'category' => 'À la une',
            'duration' => '6:42',
            'image' => 'WEAH',
            'alt' => 'Interview Georges Weah'
        ];

        $videos = [
            [
                'id' => 2,
                'title' => 'Immersion au cœur du club Africa Sports',
                'category' => 'Football',
                'duration' => '4:18',
                'image' => 'AFRICASPORTS',
                'alt' => 'Africa Sports',
                'date' => 'Il y a 5h',
                'placeholder' => ''
            ],
            [
                'id' => 3,
                'title' => 'Le résumé du match Éléphants – Sénégal',
                'category' => 'Basketball',
                'duration' => '3:05',
                'image' => '',
                'alt' => 'Basketball',
                'date' => 'Il y a 1j',
                'placeholder' => 'basket'
            ],
            [
                'id' => 4,
                'title' => 'Athlétisme : la relève ivoirienne à l\'entraînement',
                'category' => 'Athlétisme',
                'duration' => '2:40',
                'image' => '',
                'alt' => 'Athlétisme',
                'date' => 'Il y a 2j',
                'placeholder' => 'athle'
            ],
            [
                'id' => 5,
                'title' => 'Diallo qualifiée : les temps forts du quart de finale',
                'category' => 'Tennis',
                'duration' => '5:12',
                'image' => '',
                'alt' => 'Tennis',
                'date' => 'Il y a 2j',
                'placeholder' => 'tennis'
            ],
            [
                'id' => 6,
                'title' => 'Rétrospective : la carrière de Georges Weah au Milan AC',
                'category' => 'Football',
                'duration' => '8:03',
                'image' => 'WEAH',
                'alt' => 'Georges Weah',
                'date' => 'Il y a 3j',
                'placeholder' => ''
            ],
            [
                'id' => 7,
                'title' => 'Basketball féminin : portrait d\'une nouvelle génération',
                'category' => 'Basketball',
                'duration' => '1:58',
                'image' => '',
                'alt' => 'Basketball féminin',
                'date' => 'Il y a 4j',
                'placeholder' => 'basket'
            ]
        ];

        $filters = [
            ['label' => 'Toutes les vidéos', 'active' => true],
            ['label' => 'Football', 'active' => false],
            ['label' => 'Basketball', 'active' => false],
            ['label' => 'Tennis', 'active' => false],
            ['label' => 'Athlétisme', 'active' => false],
            ['label' => 'Interviews', 'active' => false],
            ['label' => 'Résumés', 'active' => false]
        ];

        return view('pages.video', compact('featuredVideo', 'videos', 'filters'));
    }

    public function show($id)
    {
        // Pour afficher une vidéo spécifique
        $video = [
            'id' => $id,
            'title' => 'Vidéo N°' . $id,
            'description' => 'Description de la vidéo',
            'duration' => '5:00',
            'image' => '',
            'alt' => 'Vidéo N°' . $id
        ];

        return view('videos.show', compact('video'));
    }
}