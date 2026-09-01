<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'articles';

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'wp_id',
        'titre',
        'description',
        'content',
        'datedecreation',
        'image',
        'alaune', // Ancien champ gardé pour compatibilité
        'categorie_principale_id',
        'slug',
        'status',
        'author',
        'comment_status',
        'ping_status',
        'sticky',
        'format',
        'yoast_head_json',
        'source_url',
        'views_count',
        'is_published'
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'datedecreation' => 'datetime',
        'alaune' => 'boolean',
        'sticky' => 'boolean',
        'is_published' => 'boolean',
        'views_count' => 'integer',
        'yoast_head_json' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Les attributs qui doivent être cachés pour la sérialisation.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // 'content' // Si vous voulez cacher le contenu par défaut
    ];

    /**
     * Les attributs qui doivent être inclus dans la sérialisation.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'category_names',
        'category_ids',
        'main_category_name',
        'formatted_date',
        'excerpt'
    ];

    // ============================================
    // RELATIONS
    // ============================================

    /**
     * Relation many-to-many avec les catégories.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'article_categories')
            ->withTimestamps()
            ->orderBy('categories.nom');
    }

    /**
     * Relation pour la catégorie principale.
     */
    public function categoriePrincipale()
    {
        return $this->belongsTo(Category::class, 'categorie_principale_id');
    }

    /**
     * Relation avec l'auteur (si vous avez une table users).
     */
    public function auteur()
    {
        return $this->belongsTo(User::class, 'author', 'id');
    }

    /**
     * Relation polymorphique pour les commentaires.
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    // ============================================
    // ACCESSORS
    // ============================================

    /**
     * Récupérer les noms des catégories.
     */
    public function getCategoryNamesAttribute()
    {
        return $this->categories->pluck('nom')->toArray();
    }

    /**
     * Récupérer les IDs des catégories.
     */
    public function getCategoryIdsAttribute()
    {
        return $this->categories->pluck('id')->toArray();
    }

    /**
     * Récupérer le nom de la catégorie principale.
     */
    public function getMainCategoryNameAttribute()
    {
        return $this->categoriePrincipale?->nom ?? $this->categorie;
    }

    /**
     * Récupérer la date formatée.
     */
    public function getFormattedDateAttribute()
    {
        return $this->datedecreation?->format('d/m/Y à H:i') ?? '';
    }

    /**
     * Récupérer l'extrait du contenu.
     */
    public function getExcerptAttribute()
    {
        $maxLength = 150;
        $content = strip_tags($this->content ?? '');
        
        if (strlen($content) <= $maxLength) {
            return $content;
        }
        
        return substr($content, 0, $maxLength) . '...';
    }

    /**
     * Récupérer l'URL complète de l'image.
     */
    public function getImageUrlAttribute()
    {
        if (empty($this->image)) {
            return null;
        }

        // Si c'est déjà une URL complète
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        // Si c'est un chemin local
        return asset('storage/' . $this->image);
    }

    /**
     * Récupérer le temps de lecture estimé.
     */
    public function getReadingTimeAttribute()
    {
        $words = str_word_count(strip_tags($this->content ?? ''));
        $minutes = ceil($words / 200); // 200 mots par minute
        return $minutes;
    }

    /**
     * Récupérer l'URL de l'article.
     */
    public function getUrlAttribute()
    {
        return route('articles.show', $this->slug ?? $this->id);
    }

    // ============================================
    // MUTATORS
    // ============================================

    /**
     * Définir le titre et générer le slug automatiquement.
     */
    public function setTitreAttribute($value)
    {
        $this->attributes['titre'] = $value;
        
        if (empty($this->slug)) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }

    /**
     * Définir le contenu en nettoyant les balises.
     */
    public function setContentAttribute($value)
    {
        // Nettoyer et stocker le contenu
        $this->attributes['content'] = $value;
    }

    // ============================================
    // SCOPES
    // ============================================

    /**
     * Scope pour les articles à la une.
     */
    public function scopeALaUne($query)
    {
        return $query->where('alaune', true);
    }

    /**
     * Scope pour les articles publiés.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'publish')
            ->where('is_published', true);
    }

    /**
     * Scope pour les articles récents.
     */
    public function scopeRecent($query, $limit = 10)
    {
        return $query->latest('datedecreation')->limit($limit);
    }

    /**
     * Scope pour filtrer par catégorie.
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->whereHas('categories', function ($q) use ($categoryId) {
            $q->where('categories.id', $categoryId);
        });
    }

    /**
     * Scope pour filtrer par sport (slug).
     */
    public function scopeBySport($query, $sportSlug)
    {
        return $query->whereHas('categories', function ($q) use ($sportSlug) {
            $q->where('slug', $sportSlug);
        });
    }

    /**
     * Scope pour filtrer par recherche.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('titre', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%")
                ->orWhere('content', 'LIKE', "%{$search}%");
        });
    }

    // ============================================
    // MÉTHODES UTILITAIRES
    // ============================================

    /**
     * Vérifier si l'article est à la une.
     */
    public function isALaUne()
    {
        return (bool) $this->alaune;
    }

    /**
     * Vérifier si l'article est publié.
     */
    public function isPublished()
    {
        return $this->status === 'publish' && $this->is_published;
    }

    /**
     * Incrémenter le compteur de vues.
     */
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    /**
     * Récupérer les articles similaires.
     */
    public function getSimilarArticles($limit = 5)
    {
        $categoryIds = $this->category_ids;

        if (empty($categoryIds)) {
            return collect();
        }

        return self::published()
            ->where('id', '!=', $this->id)
            ->whereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('categories.id', $categoryIds);
            })
            ->limit($limit)
            ->get();
    }

    /**
     * Récupérer l'article suivant.
     */
    public function getNextArticle()
    {
        return self::published()
            ->where('datedecreation', '>', $this->datedecreation)
            ->orderBy('datedecreation', 'asc')
            ->first();
    }

    /**
     * Récupérer l'article précédent.
     */
    public function getPreviousArticle()
    {
        return self::published()
            ->where('datedecreation', '<', $this->datedecreation)
            ->orderBy('datedecreation', 'desc')
            ->first();
    }

    /**
     * Formater les données pour l'API.
     */
    public function toApiResponse()
    {
        return [
            'id' => $this->id,
            'wp_id' => $this->wp_id,
            'titre' => $this->titre,
            'description' => $this->description,
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'date' => $this->formatted_date,
            'datedecreation' => $this->datedecreation?->toISOString(),
            'image' => $this->image_url,
            'alaune' => $this->alaune,
            'slug' => $this->slug,
            'categories' => $this->category_names,
            'categories_detail' => $this->categories->map(function ($category) {
                return [
                    'id' => $category->id,
                    'nom' => $category->nom,
                    'slug' => $category->slug,
                    'path' => $category->full_path
                ];
            }),
            'categorie_principale' => $this->main_category_name,
            'reading_time' => $this->reading_time,
            'views' => $this->views_count,
            'url' => $this->url,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString()
        ];
    }
}