<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            'football' => 'Football', 'basketball' => 'Basketball', 'rugby' => 'Rugby', 'handball' => 'Handball', 'volleyball' => 'Volleyball',
            'athletisme' => 'Athlétisme, course et multisports', 'sport-de-course' => 'Sport de course', 'cyclisme' => 'Cyclisme', 'golf' => 'Golf',
            'sports-raquette' => 'Sports de raquette', 'sports-aquatiques' => 'Sports aquatiques et nautiques', 'sport-de-combat' => 'Combat et arts martiaux',
            'esport' => 'E-sport et sports de l’esprit', 'precision' => 'Sports de précision et d’adresse', 'ymnastique' => 'Gymnastique, force et disciplines artistiques',
            'autres-sports-collectifs' => 'Autres sports collectifs', 'competitions' => 'Compétitions', 'univers' => 'Univers',
            'portraits-interviews' => 'Portraits & Interviews', 'dossiers-analyses' => 'Dossiers, analyses et enquêtes', 'sport-business' => 'Sport & Business',
        ];

        foreach ($sections as $slug => $name) {
            $category = Category::create(['name' => $name, 'slug' => $slug, 'description' => "Toute l’actualité $name, les résultats et les grands récits."]);
            foreach (["Les enjeux qui transforment $name", "Les champions et les championnes à suivre", "Le rendez-vous qui anime $name", "Notre analyse : les résultats de la semaine"] as $index => $title) {
                Article::create([
                    'category_id' => $category->id, 'title' => $title, 'slug' => $slug.'-'.($index + 1),
                    'excerpt' => "Décryptage, résultats et témoignages : retrouvez l’essentiel de l’actualité $name.",
                    'body' => "MianSport vous propose une lecture approfondie de cette actualité. Les acteurs du sport partagent leurs ambitions, leurs résultats et les perspectives à venir.",
                    'type' => $index === 2 ? 'video' : 'article', 'published_at' => now()->subDays($category->id + $index),
                    'is_featured' => $slug === 'football' && $index === 0,
                ]);
            }
        }

        Article::create(['category_id' => 1, 'title' => 'MianSport Magazine : les champions de demain', 'slug' => 'miansport-magazine-champions', 'excerpt' => 'Le grand format de la rédaction.', 'body' => 'Une édition à lire dès maintenant.', 'type' => 'magazine', 'published_at' => now()]);
    }
}
