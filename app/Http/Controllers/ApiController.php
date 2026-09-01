<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    // Récupérer des données d'une API externe
    public function fetchPosts()
    {
               $response = Http::withoutVerifying()
            ->get('https://api.miansports.com/wp-json/wp/v2/posts');

        if (!$response->successful()) {
            return response()->json(['error' => 'Impossible de récupérer les articles'], 500);
        }

        // ✅ Les données sont un tableau d'objets
        $articles = $response->json();

        foreach ($articles as $article) {
            // ✅ Accès direct aux propriétés
            $id = $article['id'];                           // 15459
            $titre = html_entity_decode($article['title']['rendered'], ENT_QUOTES, 'UTF-8');         // "Sénégal : Patrick Vieira..."
            $contenu = html_entity_decode($article['content']['rendered'], ENT_QUOTES, 'UTF-8'); 
            $description = $article['slug'];    // "<p>Le Sénégal ouvre..."
            $date = $article['date']; 
            $img =   
            
            
            
            // Créer l'article dans la base
            Article::create([
                'titre' => $titre,
                'contenu' => $contenu,
                'description' => $description,
                'datedecreation' => $date,
            ]);
        }
        
    return response()->json([
            'message' => count($articles) . ' articles importés avec succès'
        ]);
        }

    

}