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
     * Compatible avec Vercel (système de fichiers read-only)
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'https://via.placeholder.com/800x1000/CCCCCC/666666?text=No+Image';
        }
        
        // Si l'image contient unsplash.com, la remplacer par placeholder (Unsplash peut être bloqué)
        if (str_contains($this->image, 'unsplash.com')) {
            // Créer une image placeholder basée sur le nom du produit
            $text = urlencode(substr($this->name, 0, 20));
            $colors = ['FF6B6B', 'FFD93D', '6BCB77', '4D96FF', 'FFB6C1', '8B4513', 'F5F5DC', 'FFC0CB'];
            $color = $colors[$this->id % count($colors)];
            return "https://via.placeholder.com/800x1000/{$color}/FFFFFF?text={$text}";
        }
        
        // Si l'image est une URL complète (commence par http), la retourner telle quelle
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        
        // Si l'image commence par 'storage/', rediriger vers images/produits pour Vercel
        if (str_starts_with($this->image, 'storage/')) {
            $filename = basename($this->image);
            return asset('images/produits/' . $filename);
        }
        
        // Si l'image est un chemin relatif du storage (ex: produits/image.jpg)
        if (str_starts_with($this->image, 'produits/')) {
            $filename = basename($this->image);
            return asset('images/produits/' . $filename);
        }
        
        // Si l'image commence par 'images/', c'est un chemin public direct
        if (str_starts_with($this->image, 'images/')) {
            return asset($this->image);
        }
        
        // Par défaut, considérer que c'est un nom de fichier dans images/produits/
        return asset('images/produits/' . basename($this->image));
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
