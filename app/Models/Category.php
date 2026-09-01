<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'slug',
        'description',
        'parent_id',
        'wp_id',
        'count',
        'color',
        'icon',
        'meta_title',
        'meta_description',
        'order',
        'is_active'
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'count' => 'integer',
        'order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Les attributs qui doivent être inclus dans la sérialisation.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'full_path',
        'is_parent',
        'level',
        'articles_count',
        'all_articles_count'
    ];

    // ============================================
    // RELATIONS
    // ============================================

    /**
     * Relation many-to-many avec les articles.
     */
    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_categories')
            ->withTimestamps()
            ->orderBy('articles.datedecreation', 'desc');
    }

    /**
     * Articles où cette catégorie est principale.
     */
    public function articlesPrincipaux()
    {
        return $this->hasMany(Article::class, 'categorie_principale_id')
            ->orderBy('datedecreation', 'desc');
    }

    /**
     * Relation parent (catégorie mère).
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Relation enfants (sous-catégories).
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')
            ->orderBy('order')
            ->orderBy('nom');
    }

    /**
     * Récupérer tous les descendants avec leur niveau.
     */
    public function descendants()
    {
        return $this->children()->with('descendants');
    }

    /**
     * Récupérer tous les ancêtres.
     */
    public function ancestors()
    {
        $ancestors = collect();
        $parent = $this->parent;

        while ($parent) {
            $ancestors->push($parent);
            $parent = $parent->parent;
        }

        return $ancestors->reverse();
    }

    // ============================================
    // ACCESSORS
    // ============================================

    /**
     * Accesseur pour le chemin complet de la catégorie.
     */
    public function getFullPathAttribute()
    {
        $path = [$this->nom];
        $parent = $this->parent;

        while ($parent) {
            array_unshift($path, $parent->nom);
            $parent = $parent->parent;
        }

        return implode(' → ', $path);
    }

    /**
     * Accesseur pour le niveau de profondeur.
     */
    public function getLevelAttribute()
    {
        $level = 0;
        $parent = $this->parent;

        while ($parent) {
            $level++;
            $parent = $parent->parent;
        }

        return $level;
    }

    /**
     * Vérifier si c'est une catégorie parente.
     */
    public function getIsParentAttribute()
    {
        return $this->children()->count() > 0;
    }

    /**
     * Compter les articles de cette catégorie.
     */
    public function getArticlesCountAttribute()
    {
        return $this->articles()->count();
    }

    /**
     * Compter tous les articles de cette catégorie et de ses enfants.
     */
    public function getAllArticlesCountAttribute()
    {
        $count = $this->articles()->count();
        
        foreach ($this->children as $child) {
            $count += $child->all_articles_count;
        }
        
        return $count;
    }

    /**
     * Récupérer l'URL de la catégorie.
     */
    public function getUrlAttribute()
    {
        return route('categories.show', $this->slug);
    }

    // ============================================
    // MUTATORS
    // ============================================

    /**
     * Définir le nom et générer le slug automatiquement.
     */
    public function setNomAttribute($value)
    {
        $this->attributes['nom'] = $value;
        
        if (empty($this->slug)) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }

    // ============================================
    // SCOPES
    // ============================================

    /**
     * Scope pour les catégories actives.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope pour les catégories parentes (sans parent).
     */
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope pour les catégories enfants.
     */
    public function scopeChildren($query)
    {
        return $query->whereNotNull('parent_id');
    }

    /**
     * Scope pour filtrer par recherche.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nom', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%")
                ->orWhere('slug', 'LIKE', "%{$search}%");
        });
    }

    /**
     * Scope pour ordonner par ordre puis par nom.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('nom');
    }

    // ============================================
    // MÉTHODES UTILITAIRES
    // ============================================

    /**
     * Récupérer les IDs de toutes les catégories enfants (récursif).
     */
    public function getAllChildrenIds()
    {
        $ids = [];
        
        foreach ($this->children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $child->getAllChildrenIds());
        }
        
        return $ids;
    }

    /**
     * Récupérer les IDs de la catégorie et de tous ses descendants.
     */
    public function getSelfAndChildrenIds()
    {
        return array_merge([$this->id], $this->getAllChildrenIds());
    }

    /**
     * Récupérer tous les articles de cette catégorie et de ses enfants.
     */
    public function getAllArticles()
    {
        $categoryIds = $this->getSelfAndChildrenIds();
        
        return Article::whereHas('categories', function ($query) use ($categoryIds) {
            $query->whereIn('categories.id', $categoryIds);
        })->get();
    }

    /**
     * Vérifier si la catégorie a des enfants.
     */
    public function hasChildren()
    {
        return $this->children()->exists();
    }

    /**
     * Vérifier si la catégorie est un descendant d'une autre.
     */
    public function isDescendantOf($categoryId)
    {
        $category = $this->parent;
        
        while ($category) {
            if ($category->id === $categoryId) {
                return true;
            }
            $category = $category->parent;
        }
        
        return false;
    }

    /**
     * Récupérer le chemin complet des slugs.
     */
    public function getSlugPath()
    {
        $slugs = [$this->slug];
        $parent = $this->parent;

        while ($parent) {
            array_unshift($slugs, $parent->slug);
            $parent = $parent->parent;
        }

        return implode('/', $slugs);
    }

    /**
     * Formater les données pour l'API.
     */
    public function toApiResponse($withArticles = false)
    {
        $data = [
            'id' => $this->id,
            'wp_id' => $this->wp_id,
            'nom' => $this->nom,
            'slug' => $this->slug,
            'description' => $this->description,
            'path' => $this->full_path,
            'level' => $this->level,
            'is_parent' => $this->is_parent,
            'articles_count' => $this->articles_count,
            'total_articles' => $this->all_articles_count,
            'color' => $this->color,
            'icon' => $this->icon,
            'url' => $this->url,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString()
        ];

        // Ajouter les enfants si demandé
        if ($this->is_parent) {
            $data['children'] = $this->children->map(function ($child) {
                return $child->toApiResponse();
            });
        }

        // Ajouter les articles si demandé
        if ($withArticles) {
            $data['articles'] = $this->articles->map(function ($article) {
                return $article->toApiResponse();
            });
        }

        return $data;
    }

    /**
     * Récupérer l'arbre complet des catégories.
     */
    public static function getCategoryTree()
    {
        return self::active()
            ->parents()
            ->with('children')
            ->ordered()
            ->get()
            ->map(function ($category) {
                return $category->toApiResponse();
            });
    }

    /**
     * Récupérer toutes les catégories sous forme de tableau plat pour les selects.
     */
    public static function getSelectOptions($withEmpty = true)
    {
        $options = $withEmpty ? ['' => 'Sélectionner une catégorie'] : [];
        $categories = self::active()->parents()->ordered()->get();

        foreach ($categories as $category) {
            $options[$category->id] = $category->nom;
            $options = array_merge($options, $category->getChildrenOptions());
        }

        return $options;
    }

    /**
     * Récupérer les options des enfants (pour les selects).
     */
    protected function getChildrenOptions($prefix = '— ')
    {
        $options = [];
        
        foreach ($this->children as $child) {
            $options[$child->id] = $prefix . $child->nom;
            $options = array_merge($options, $child->getChildrenOptions($prefix . '— '));
        }
        
        return $options;
    }

    // ============================================
    // EVENTS / BOOT
    // ============================================

    /**
     * Boot du modèle.
     */
    protected static function boot()
    {
        parent::boot();

        // Générer le slug avant la création
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->nom);
            }
            
            // S'assurer que le slug est unique
            $originalSlug = $category->slug;
            $counter = 1;
            
            while (static::where('slug', $category->slug)->exists()) {
                $category->slug = $originalSlug . '-' . $counter;
                $counter++;
            }
        });

        // Mettre à jour le compte d'articles après suppression
        static::deleting(function ($category) {
            // Réassigner les articles à une catégorie par défaut ou les supprimer
            // selon votre logique métier
        });
    }
}