<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    /**
     * La table associée au modèle.
     *
     * @var string
     */
    protected $table = 'produits';

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'categorie',
        'price',
        'old_price',
        'image',
        'rating',
        'reviews',
        'description',
        'features',
        'stock',
        'new',
        'sale',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'rating' => 'decimal:1',
        'features' => 'array',
        'new' => 'boolean',
        'sale' => 'boolean',
    ];

    /**
     * Obtenir l'URL complète de l'image (Accesseur Laravel)
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/placeholder.png');
        }
        
        // Si l'image est une URL complète (commence par http), la retourner telle quelle
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        
        // Si l'image commence par 'storage/', c'est un chemin de storage Laravel
        if (str_starts_with($this->image, 'storage/')) {
            return asset($this->image);
        }
        
        // Si l'image est un chemin relatif du storage (ex: produits/image.jpg)
        // C'est le format utilisé par Storage::disk('public')->store()
        if (str_starts_with($this->image, 'produits/')) {
            return asset('storage/' . $this->image);
        }
        
        // Si l'image commence par 'images/', c'est un chemin public direct
        if (str_starts_with($this->image, 'images/')) {
            return asset($this->image);
        }
        
        // Par défaut, considérer que c'est un nom de fichier dans storage/produits/
        return asset('storage/produits/' . $this->image);
    }

    /**
     * Récupérer les produits par catégorie
     *
     * @param string $categorie
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getByCategorie(string $categorie)
    {
        return self::where('categorie', $categorie)->get();
    }

    /**
     * Récupérer toutes les catégories distinctes
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getCategories()
    {
        return self::select('categorie')
            ->distinct()
            ->pluck('categorie');
    }

    /**
     * Récupérer les produits en promotion
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getPromoProducts()
    {
        return self::where('sale', true)->get();
    }

    /**
     * Récupérer les nouveaux produits
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getNewProducts()
    {
        return self::where('new', true)->get();
    }

    /**
     * Récupérer les produits similaires (même catégorie)
     *
     * @param int $excludeId
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRelatedProducts(int $excludeId = 0, int $limit = 4)
    {
        return self::where('categorie', $this->categorie)
            ->where('id', '!=', $excludeId ?: $this->id)
            ->limit($limit)
            ->get();
    }
}
