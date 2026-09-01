<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;
use Carbon\Carbon;

class WordPressImportController extends Controller
{
    /**
     * Importer les articles depuis WordPress
     */
    public function import(Request $request)
    {
        $url = $request->input('url', 'https://api.miansports.com');
        $perPage = $request->input('per_page', 100);
        $maxPages = $request->input('max_pages', 10); // Nombre max de pages à importer

        // 1. Récupérer d'abord les catégories
        $categoryMap = $this->getCategoryMap($url);
        
        $allArticles = [];
        $totalWP = 0;
        $importedCount = 0;
        $skippedCount = 0;
        $errors = [];
        $page = 1;
        $hasMore = true;

        // 2. Récupérer TOUS les articles avec pagination
        while ($hasMore && $page <= $maxPages) {
            try {
                $response = Http::withoutVerifying()
                    ->timeout(60)
                    ->get("{$url}/wp-json/wp/v2/posts", [
                        'per_page' => $perPage,
                        'page' => $page,
                        'status' => 'publish',
                        '_embed' => false
                    ]);

                if (!$response->successful()) {
                    return response()->json([
                        'success' => false,
                        'error' => "Impossible de récupérer les articles (page {$page})",
                        'status' => $response->status()
                    ], 500);
                }

                $articles = $response->json();
                
                if (empty($articles)) {
                    $hasMore = false;
                    break;
                }

                $totalWP += count($articles);
                $allArticles = array_merge($allArticles, $articles);

                // Vérifier s'il y a une page suivante
                $totalPages = (int) $response->header('X-WP-TotalPages', 0);
                if ($page >= $totalPages) {
                    $hasMore = false;
                }

                $page++;

            } catch (\Exception $e) {
                $errors[] = [
                    'type' => 'api_error',
                    'page' => $page,
                    'message' => $e->getMessage()
                ];
                break;
            }
        }

        // 3. Importer les articles
        $importedArticles = [];

        foreach ($allArticles as $article) {
            try {
                // ✅ Vérification par TITRE au lieu de wp_id
                $titre = html_entity_decode(
                    strip_tags($article['title']['rendered'] ?? 'Sans titre'), 
                    ENT_QUOTES, 
                    'UTF-8'
                );

                // Vérifier si l'article existe déjà (par titre)
                if (Article::where('titre', $titre)->exists()) {
                    $skippedCount++;
                    continue;
                }

                $slug = $article['slug'];

                $contenu = html_entity_decode(
                    strip_tags($article['content']['rendered'] ?? ''), 
                    ENT_QUOTES, 
                    'UTF-8'
                );
                
                $description = html_entity_decode(
                    strip_tags($article['excerpt']['rendered'] ?? $titre), 
                    ENT_QUOTES, 
                    'UTF-8'
                );
                
                $date = Carbon::parse($article['date'] ?? now());

                // Récupérer les catégories
                $wpCategoryIds = $article['categories'] ?? [];
                $categoryIds = [];
                $categoryNames = [];

                foreach ($wpCategoryIds as $wpCatId) {
                    if (isset($categoryMap[$wpCatId])) {
                        $categoryIds[] = $categoryMap[$wpCatId]->id;
                        $categoryNames[] = $categoryMap[$wpCatId]->nom;
                    }
                }

                // ✅ Créer l'article SANS wp_id
                $newArticle = Article::create([
                    'titre' => $titre,
                    'slug' => $slug,
                    'content' => $contenu,
                    'description' => $description,
                    'datedecreation' => $date,
                    'image' => $article['_embedded']['wp:featuredmedia'][0]['source_url'] ?? null,
                    'alaune' => false,
                    'status' => 'publish',
                    'categorie' => implode(', ', $categoryNames)
                ]);

                // Associer les catégories
                if (!empty($categoryIds)) {
                    $newArticle->categories()->attach($categoryIds);
                    $newArticle->categorie_principale_id = $categoryIds[0];
                    $newArticle->save();
                }

                $importedCount++;
                $importedArticles[] = [
                    'id' => $newArticle->id,
                    'slug' => $newArticle->slug,
                    'titre' => $newArticle->titre,
                    'categories' => $categoryNames,
                    'date' => $newArticle->datedecreation->format('Y-m-d H:i:s')
                ];

            } catch (\Exception $e) {
                $errors[] = [
                    'type' => 'import_error',
                    'wp_id' => $article['id'] ?? 'unknown',
                    'titre' => $article['title']['rendered'] ?? 'Sans titre',
                    'message' => $e->getMessage()
                ];
            }
        }

        // 4. Retourner la réponse avec un résumé complet
        return response()->json([
            'success' => true,
            'message' => "{$importedCount} articles importés sur {$totalWP} trouvés",
            'data' => [
                'total_wp_articles' => $totalWP,
                'pages_processed' => $page - 1,
                'imported' => $importedCount,
                'skipped' => $skippedCount,
                'errors' => count($errors),
                'articles' => $importedArticles
            ],
            'errors_detail' => $errors
        ]);
    }

    /**
     * Récupérer le mapping des catégories (avec pagination)
     */
    protected function getCategoryMap($url)
    {
        $categoryMap = [];
        $page = 1;
        $hasMore = true;
        
        while ($hasMore) {
            try {
                $response = Http::withoutVerifying()
                    ->timeout(30)
                    ->get("{$url}/wp-json/wp/v2/categories", [
                        'per_page' => 100,
                        'page' => $page
                    ]);

                if (!$response->successful()) {
                    break;
                }

                $wpCategories = $response->json();
                
                if (empty($wpCategories)) {
                    $hasMore = false;
                    break;
                }

                foreach ($wpCategories as $wpCat) {
                    $category = Category::updateOrCreate(
                        ['wp_id' => $wpCat['id']],
                        [
                            'nom' => $wpCat['name'],
                            'slug' => $wpCat['slug'],
                            'description' => $wpCat['description'] ?? ''
                        ]
                    );
                    $categoryMap[$wpCat['id']] = $category;
                }

                // Vérifier s'il y a une page suivante
                $totalPages = (int) $response->header('X-WP-TotalPages', 0);
                if ($page >= $totalPages) {
                    $hasMore = false;
                }
                
                $page++;

            } catch (\Exception $e) {
                break;
            }
        }

        // Relations parent/enfant
        foreach ($wpCategories ?? [] as $wpCat) {
            if ($wpCat['parent'] != 0 && isset($categoryMap[$wpCat['parent']])) {
                $category = $categoryMap[$wpCat['id']];
                $category->parent_id = $categoryMap[$wpCat['parent']]->id;
                $category->save();
            }
        }

        return $categoryMap;
    }

    /**
     * Importer UNIQUEMENT les catégories (sans les articles)
     */
    public function importCategories(Request $request)
{
    $url = $request->input('url', 'https://api.miansports.com');
    $allCategories = [];
    $page = 1;
    $hasMore = true;

    // Récupérer TOUTES les catégories avec pagination
    while ($hasMore) {
        $response = Http::withoutVerifying()
            ->timeout(30)
            ->get("{$url}/wp-json/wp/v2/categories", [
                'per_page' => 100,
                'page' => $page
            ]);

        if (!$response->successful()) {
            break;
        }

        $wpCategories = $response->json();
        if (empty($wpCategories)) {
            $hasMore = false;
            break;
        }

        $allCategories = array_merge($allCategories, $wpCategories);

        $totalPages = (int) $response->header('X-WP-TotalPages', 0);
        if ($page >= $totalPages) {
            $hasMore = false;
        }
        $page++;
    }

    $categoryMap = [];
    $imported = 0;

    // 1. Importer toutes les catégories
    foreach ($allCategories as $wpCat) {
        $category = Category::updateOrCreate(
            ['wp_id' => $wpCat['id']],
            [
                'nom' => html_entity_decode($wpCat['name'], ENT_QUOTES, 'UTF-8'),
                'slug' => $wpCat['slug'],
                'description' => $wpCat['description'] ?? ''
            ]
        );
        $categoryMap[$wpCat['id']] = $category;
        $imported++;
    }

    // 2. Définir les relations parent/enfant
    foreach ($allCategories as $wpCat) {
        if ($wpCat['parent'] != 0 && isset($categoryMap[$wpCat['parent']])) {
            $category = $categoryMap[$wpCat['id']];
            $category->parent_id = $categoryMap[$wpCat['parent']]->id;
            $category->save();
        }
    }

    // 3. Récupérer toutes les catégories
    $allCategoriesWithRelations = Category::with('parent', 'children')
        ->orderBy('nom')
        ->get();

    // 4. Construire l'arbre hiérarchique
    $categoriesTree = Category::with('children')
        ->whereNull('parent_id')
        ->orderBy('nom')
        ->get()
        ->map(function ($cat) {
            return $this->formatCategoryTree($cat);
        });

    // 5. ✅ LISTE PLATE : TOUTES les catégories (y compris les enfants)
    // Chaque catégorie apparaît comme une entité indépendante
    $allCategoriesFlat = $allCategoriesWithRelations->map(function ($cat) {
        return [
            'id' => $cat->id,
            'wp_id' => $cat->wp_id,
            'nom' => $cat->nom,
            'slug' => $cat->slug,
            'description' => $cat->description,
            'parent_id' => $cat->parent_id,
            'parent_nom' => $cat->parent?->nom,
            'has_parent' => !is_null($cat->parent_id),
            'level' => $cat->level,
            'full_path' => $cat->full_path,
            'is_parent' => $cat->is_parent,
            'articles_count' => $cat->articles_count,
            'total_articles' => $cat->all_articles_count,
            'children_count' => $cat->children->count(),
            'created_at' => $cat->created_at?->toISOString(),
            'updated_at' => $cat->updated_at?->toISOString()
        ];
    });

    // 6. ✅ CATÉGORIES PARENTES uniquement
    $parentCategories = $allCategoriesWithRelations
        ->whereNull('parent_id')
        ->values()
        ->map(function ($cat) {
            return [
                'id' => $cat->id,
                'wp_id' => $cat->wp_id,
                'nom' => $cat->nom,
                'slug' => $cat->slug,
                'description' => $cat->description,
                'children_count' => $cat->children->count(),
                'articles_count' => $cat->articles_count,
                'total_articles' => $cat->all_articles_count
            ];
        });

    // 7. ✅ CATÉGORIES ENFANTS uniquement (sans leurs parents)
    // Chaque enfant apparaît comme une catégorie à part entière
    $childCategories = $allCategoriesWithRelations
        ->whereNotNull('parent_id')
        ->values()
        ->map(function ($cat) {
            return [
                'id' => $cat->id,
                'wp_id' => $cat->wp_id,
                'nom' => $cat->nom,
                'slug' => $cat->slug,
                'description' => $cat->description,
                'parent_id' => $cat->parent_id,
                'parent_nom' => $cat->parent?->nom,
                'level' => $cat->level,
                'full_path' => $cat->full_path,
                'articles_count' => $cat->articles_count,
                'total_articles' => $cat->all_articles_count,
                'has_sub_children' => $cat->children->count() > 0,
                'sub_children_count' => $cat->children->count(),
                'created_at' => $cat->created_at?->toISOString(),
                'updated_at' => $cat->updated_at?->toISOString()
            ];
        });

    // 8. ✅ Statistiques
    $stats = [
        'total_categories' => $allCategoriesWithRelations->count(),
        'parent_categories' => Category::whereNull('parent_id')->count(),
        'child_categories' => Category::whereNotNull('parent_id')->count(),
        'max_depth' => $allCategoriesWithRelations->max('level') ?? 0,
        'categories_with_articles' => Category::has('articles')->count()
    ];

    return response()->json([
        'success' => true,
        'message' => "{$imported} catégories importées avec succès",
        'data' => [
            'imported' => $imported,
            'stats' => $stats,
            
            // ✅ Arbre hiérarchique (parent → enfants)
            'tree' => $categoriesTree,
            
            // ✅ TOUTES les catégories en liste plate (enfants comme catégories à part entière)
            'all_categories' => $allCategoriesFlat,
            
            // ✅ Catégories parentes uniquement
            'parent_categories' => $parentCategories,
            
            // ✅ Catégories enfants uniquement (à part entière, sans leurs parents)
            'child_categories' => $childCategories
        ]
    ]);
}

/**
 * Formater une catégorie avec son arbre
 */
protected function formatCategoryTree($category)
{
    return [
        'id' => $category->id,
        'wp_id' => $category->wp_id,
        'nom' => $category->nom,
        'slug' => $category->slug,
        'description' => $category->description,
        'level' => $category->level,
        'full_path' => $category->full_path,
        'articles_count' => $category->articles_count,
        'total_articles' => $category->all_articles_count,
        'children_count' => $category->children->count(),
        'children' => $category->children->map(function ($child) {
            return $this->formatCategoryTree($child);
        })
    ];
}

    /**
     * Importer UNIQUEMENT les articles d'une catégorie spécifique
     */
    public function importByCategory(Request $request)
    {
        $url = $request->input('url', 'https://api.miansports.com');
        $categorySlug = $request->input('category');
        $perPage = $request->input('per_page', 100);
        $maxPages = $request->input('max_pages', 10);

        if (empty($categorySlug)) {
            return response()->json([
                'success' => false,
                'error' => 'Le paramètre "category" est requis'
            ], 400);
        }

        // Trouver la catégorie dans notre base
        $category = Category::where('slug', $categorySlug)->first();
        
        if (!$category || !$category->wp_id) {
            return response()->json([
                'success' => false,
                'error' => "Catégorie '{$categorySlug}' non trouvée"
            ], 404);
        }

        $allArticles = [];
        $page = 1;
        $hasMore = true;
        $totalWP = 0;

        // Récupérer TOUS les articles de la catégorie avec pagination
        while ($hasMore && $page <= $maxPages) {
            $response = Http::withoutVerifying()
                ->timeout(60)
                ->get("{$url}/wp-json/wp/v2/posts", [
                    'per_page' => $perPage,
                    'page' => $page,
                    'categories' => $category->wp_id,
                    'status' => 'publish',
                    '_embed' => true
                ]);

            if (!$response->successful()) {
                break;
            }

            $articles = $response->json();
            if (empty($articles)) {
                $hasMore = false;
                break;
            }

            $totalWP += count($articles);
            $allArticles = array_merge($allArticles, $articles);

            $totalPages = (int) $response->header('X-WP-TotalPages', 0);
            if ($page >= $totalPages) {
                $hasMore = false;
            }
            $page++;
        }

        $imported = 0;
        $importedArticles = [];

        foreach ($allArticles as $article) {
            // Vérifier si l'article existe déjà
            if (Article::where('wp_id', $article['id'])->exists()) {
                continue;
            }

            $titre = html_entity_decode(
                strip_tags($article['title']['rendered'] ?? 'Sans titre'), 
                ENT_QUOTES, 
                'UTF-8'
            );
            
            $contenu = html_entity_decode(
                strip_tags($article['content']['rendered'] ?? ''), 
                ENT_QUOTES, 
                'UTF-8'
            );

            $newArticle = Article::create([
                'wp_id' => $article['id'],
                'titre' => $titre,
                'content' => $contenu,
                'description' => html_entity_decode(
                    strip_tags($article['excerpt']['rendered'] ?? $titre), 
                    ENT_QUOTES, 
                    'UTF-8'
                ),
                'datedecreation' => Carbon::parse($article['date'] ?? now()),
                'categorie' => $category->nom,
                'status' => 'publish',
                'image' => $article['_embedded']['wp:featuredmedia'][0]['source_url'] ?? null
            ]);

            // Associer la catégorie
            $newArticle->categories()->attach($category->id);
            $newArticle->categorie_principale_id = $category->id;
            $newArticle->save();

            $imported++;
            $importedArticles[] = [
                'id' => $newArticle->id,
                'titre' => $newArticle->titre,
                'date' => $newArticle->datedecreation->format('Y-m-d H:i:s')
            ];
        }

        return response()->json([
            'success' => true,
            'message' => "{$imported} articles importés pour la catégorie '{$category->nom}' sur {$totalWP} trouvés",
            'data' => [
                'category' => $category->nom,
                'imported' => $imported,
                'total_wp' => $totalWP,
                'articles' => $importedArticles,
                'total_in_db' => Article::count()
            ]
        ]);
    }

    /**
     * Voir le statut de l'importation
     */
    public function status()
    {
        $totalArticles = Article::count();
        $totalCategories = Category::count();

        return response()->json([
            'success' => true,
            'data' => [
                'total_articles' => $totalArticles,
                'total_categories' => $totalCategories,
                'articles_by_category' => Category::withCount('articles')
                    ->whereNull('parent_id')
                    ->get()
                    ->map(function ($category) {
                        return [
                            'id' => $category->id,
                            'nom' => $category->nom,
                            'total' => $category->articles_count,
                            'children' => $category->children->map(function ($child) {
                                return [
                                    'nom' => $child->nom,
                                    'total' => $child->articles()->count()
                                ];
                            })
                        ];
                    }),
                'latest_articles' => Article::with('categories')
                    ->latest('datedecreation')
                    ->limit(5)
                    ->get()
                    ->map(function ($article) {
                        return [
                            'id' => $article->id,
                            'titre' => $article->titre,
                            'date' => $article->datedecreation?->format('Y-m-d H:i:s'),
                            'categories' => $article->categories->pluck('nom')->toArray()
                        ];
                    })
            ]
        ]);
    }

    /**
     * Supprimer tous les articles importés
     */
    public function clear(Request $request)
    {
        $confirm = $request->input('confirm', false);

        if (!$confirm) {
            return response()->json([
                'success' => false,
                'message' => 'Confirmation requise. Ajoutez ?confirm=true pour supprimer tous les articles'
            ], 400);
        }

        $count = Article::count();
        
        // Supprimer les relations
        DB::table('article_categories')->truncate();
        
        // Supprimer les articles
        Article::truncate();

        return response()->json([
            'success' => true,
            'message' => "{$count} articles supprimés avec succès"
        ]);
    }

    /**
     * Vérifier combien d'articles manquent par rapport à WordPress
     */
    public function checkMissing(Request $request)
    {
        $url = $request->input('url', 'https://api.miansports.com');
        $wpIds = [];
        $page = 1;
        $hasMore = true;

        // Récupérer tous les IDs WordPress
        while ($hasMore) {
            $response = Http::withoutVerifying()
                ->timeout(30)
                ->get("{$url}/wp-json/wp/v2/posts", [
                    'per_page' => 100,
                    'page' => $page,
                    'fields' => 'id'
                ]);

            if (!$response->successful()) {
                break;
            }

            $articles = $response->json();
            if (empty($articles)) {
                $hasMore = false;
                break;
            }

            foreach ($articles as $article) {
                $wpIds[] = $article['id'];
            }

            $totalPages = (int) $response->header('X-WP-TotalPages', 0);
            if ($page >= $totalPages) {
                $hasMore = false;
            }
            $page++;
        }

        // Récupérer les IDs déjà importés
        $importedIds = Article::whereNotNull('wp_id')->pluck('wp_id')->toArray();
        
        // IDs manquants
        $missingIds = array_diff($wpIds, $importedIds);

        return response()->json([
            'success' => true,
            'data' => [
                'total_wp' => count($wpIds),
                'total_imported' => count($importedIds),
                'missing_count' => count($missingIds),
                'missing_ids' => array_values($missingIds)
            ]
        ]);
    }
}