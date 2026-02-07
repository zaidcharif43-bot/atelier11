<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Produit;

class ProduitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Supprimer les produits existants
        Produit::truncate();

        // Insérer les nouveaux produits avec images fonctionnelles
        $produits = [
            [
                'name' => 'T-Shirt Blanc Premium',
                'categorie' => 'homme',
                'price' => 29.99,
                'old_price' => 39.99,
                'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800&h=600&fit=crop',
                'rating' => 4.8,
                'reviews' => 156,
                'description' => 'T-shirt blanc en coton premium, coupe moderne et confortable. Parfait pour toutes les occasions.',
                'features' => json_encode(['100% Coton premium', 'Coupe moderne', 'Lavable à 30°C', 'Tailles S-XXL']),
                'stock' => 45,
                'new' => false,
                'sale' => true
            ],
            [
                'name' => 'Robe d\'Été Fleurie',
                'categorie' => 'femme',
                'price' => 59.99,
                'old_price' => null,
                'image' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=800&h=600&fit=crop',
                'rating' => 4.9,
                'reviews' => 89,
                'description' => 'Magnifique robe d\'été avec motifs floraux. Tissu léger et fluide pour les beaux jours.',
                'features' => json_encode(['Viscose légère', 'Motifs floraux', 'Coupe évasée', 'Longueur midi']),
                'stock' => 23,
                'new' => true,
                'sale' => false
            ],
            [
                'name' => 'Jean Slim Bleu',
                'categorie' => 'homme',
                'price' => 49.99,
                'old_price' => 69.99,
                'image' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=800&h=600&fit=crop',
                'rating' => 4.7,
                'reviews' => 234,
                'description' => 'Jean slim stretch en denim premium. Coupe moderne et très confortable.',
                'features' => json_encode(['98% Coton, 2% Élasthanne', 'Coupe slim', 'Lavage stone', 'Tailles 28-38']),
                'stock' => 67,
                'new' => false,
                'sale' => true
            ],
            [
                'name' => 'Blazer Noir Élégant',
                'categorie' => 'femme',
                'price' => 89.99,
                'old_price' => 119.99,
                'image' => 'https://images.unsplash.com/photo-1591369822096-ffd140ec948f?w=800&h=600&fit=crop',
                'rating' => 4.8,
                'reviews' => 112,
                'description' => 'Blazer noir classique et intemporel. Parfait pour le bureau ou les soirées.',
                'features' => json_encode(['Polyester premium', 'Doublure satin', 'Coupe ajustée', 'Poches avant']),
                'stock' => 18,
                'new' => true,
                'sale' => true
            ],
            [
                'name' => 'Sac à Main Cuir',
                'categorie' => 'accessoires',
                'price' => 79.99,
                'old_price' => null,
                'image' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=800&h=600&fit=crop',
                'rating' => 4.9,
                'reviews' => 78,
                'description' => 'Sac à main en cuir véritable. Élégant et pratique avec plusieurs compartiments.',
                'features' => json_encode(['Cuir véritable', 'Fermeture éclair', 'Bandoulière ajustable', '30x25x12 cm']),
                'stock' => 34,
                'new' => true,
                'sale' => false
            ],
            [
                'name' => 'Sneakers Sport',
                'categorie' => 'homme',
                'price' => 69.99,
                'old_price' => 89.99,
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=800&h=600&fit=crop',
                'rating' => 4.6,
                'reviews' => 203,
                'description' => 'Baskets sport modernes et confortables. Design tendance et semelle amortissante.',
                'features' => json_encode(['Mesh respirant', 'Semelle amortie', 'Design moderne', 'Pointures 39-46']),
                'stock' => 52,
                'new' => false,
                'sale' => true
            ],
            [
                'name' => 'Montre Classique',
                'categorie' => 'accessoires',
                'price' => 129.99,
                'old_price' => null,
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800&h=600&fit=crop',
                'rating' => 4.7,
                'reviews' => 145,
                'description' => 'Montre élégante avec bracelet en cuir. Parfaite pour toutes les occasions.',
                'features' => json_encode(['Mouvement quartz', 'Bracelet cuir', 'Étanche 50m', 'Garantie 2 ans']),
                'stock' => 29,
                'new' => true,
                'sale' => false
            ],
            [
                'name' => 'Robe Soirée',
                'categorie' => 'femme',
                'price' => 99.99,
                'old_price' => 129.99,
                'image' => 'https://images.unsplash.com/photo-1566174053879-31528523f8ae?w=800&h=600&fit=crop',
                'rating' => 4.9,
                'reviews' => 67,
                'description' => 'Robe de soirée élégante et raffinée. Parfaite pour les événements spéciaux.',
                'features' => json_encode(['Tissu satiné', 'Coupe ajustée', 'Zip invisible', 'Longueur longue']),
                'stock' => 15,
                'new' => true,
                'sale' => true
            ],
        ];

        foreach ($produits as $produit) {
            Produit::create($produit);
        }
    }
}
