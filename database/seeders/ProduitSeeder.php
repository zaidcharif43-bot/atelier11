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

        // Insérer les produits (4 produits originaux uniquement)
        $produits = [
            [
                'name' => 'Robe d\'Été Fleurie',
                'categorie' => 'femme',
                'price' => 59.99,
                'old_price' => null,
                'image' => 'https://via.placeholder.com/800x600/FFB6C1/FFFFFF?text=Robe+Ete+Fleurie',
                'rating' => 4.9,
                'reviews' => 89,
                'description' => 'Magnifique robe d\'été avec motifs floraux. Tissu léger et fluide, parfaite pour les journées ensoleillées.',
                'features' => json_encode(['Viscose légère', 'Motifs floraux', 'Coupe évasée', 'Longueur midi']),
                'stock' => 23,
                'new' => true,
                'sale' => false
            ],
            [
                'name' => 'T-Shirt Blanc Classique',
                'categorie' => 'homme',
                'price' => 24.99,
                'old_price' => 34.99,
                'image' => 'https://via.placeholder.com/800x600/FFFFFF/000000?text=T-Shirt+Blanc',
                'rating' => 4.8,
                'reviews' => 156,
                'description' => 'T-shirt blanc en coton 100% biologique, coupe régulière. Parfait pour un look décontracté et élégant au quotidien.',
                'features' => json_encode(['100% Coton biologique', 'Coupe régulière', 'Lavable à 30°C', 'Disponible en S, M, L, XL']),
                'stock' => 45,
                'new' => false,
                'sale' => true
            ],
            [
                'name' => 'Sac à Main Cuir Marron',
                'categorie' => 'accessoires',
                'price' => 79.99,
                'old_price' => null,
                'image' => 'https://via.placeholder.com/800x600/8B4513/FFFFFF?text=Sac+Cuir+Marron',
                'rating' => 4.8,
                'reviews' => 78,
                'description' => 'Sac à main en cuir véritable avec finitions soignées. Élégant et pratique avec plusieurs compartiments.',
                'features' => json_encode(['Cuir véritable', 'Fermeture éclair', 'Bandoulière ajustable', 'Dimensions: 30x25x12 cm']),
                'stock' => 34,
                'new' => true,
                'sale' => false
            ],
            [
                'name' => 'Blazer Noir Élégant',
                'categorie' => 'femme',
                'price' => 89.99,
                'old_price' => 119.99,
                'image' => 'https://via.placeholder.com/800x600/000000/FFFFFF?text=Blazer+Noir',
                'rating' => 4.7,
                'reviews' => 112,
                'description' => 'Blazer noir classique et intemporel. Coupe ajustée parfaite pour le bureau ou les occasions spéciales.',
                'features' => json_encode(['Polyester premium', 'Doublure satin', 'Coupe ajustée', 'Poches avant']),
                'stock' => 18,
                'new' => true,
                'sale' => true
            ],
        ];

        foreach ($produits as $produit) {
            Produit::create($produit);
        }
    }
}
