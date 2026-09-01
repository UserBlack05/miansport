<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class magazineController extends Controller
{
    public function index()
    {
        $featuredIssue = [
            'id' => 12,
            'title' => 'Basketball féminin, l\'essor',
            'image' => '',
            'alt' => 'Magazine N°12'
        ];

        $issues = [
            [
                'id' => 12,
                'title' => 'Basketball féminin, l\'essor',
                'image' => '',
                'alt' => 'Magazine N°12'
            ],
            [
                'id' => 11,
                'title' => 'Jeunes talents à suivre',
                'image' => '',
                'alt' => 'Magazine N°11'
            ],
            [
                'id' => 10,
                'title' => 'Spécial CAN 2025',
                'image' => '',
                'alt' => 'Magazine N°10'
            ],
            [
                'id' => 9,
                'title' => 'Portrait : les Éléphants',
                'image' => '',
                'alt' => 'Magazine N°09'
            ],
            [
                'id' => 8,
                'title' => 'Clubs historiques',
                'image' => '',
                'alt' => 'Magazine N°08'
            ],
            [
                'id' => 7,
                'title' => 'Athlétisme, la relève',
                'image' => '',
                'alt' => 'Magazine N°07'
            ]
        ];

        $filters = [
            ['label' => 'Tous les numéros', 'active' => true],
            ['label' => '2026', 'active' => false],
            ['label' => '2025', 'active' => false],
            ['label' => 'Portraits', 'active' => false],
            ['label' => 'Spécial CAN', 'active' => false],
            ['label' => 'Clubs', 'active' => false]
        ];

        return view('pages.magazine.index', compact('featuredIssue', 'issues', 'filters'));
    }

    public function show($id)
    {
        // Pour afficher un magazine spécifique
        $issue = [
            'id' => $id,
            'title' => 'Magazine N°' . $id,
            'description' => 'Découvrez ce numéro exclusif de MianSport',
            'image' => '',
            'alt' => 'Magazine N°' . $id
        ];

        return view('magazine.show', compact('issue'));
    }
}