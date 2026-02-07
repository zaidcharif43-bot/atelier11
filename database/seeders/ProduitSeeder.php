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

        // Insérer les produits
        $produits = [
            [
                'name' => 'T-Shirt Blanc Classique',
                'categorie' => 'homme',
                'price' => 24.99,
                'old_price' => 34.99,
                'image' => 'https://via.placeholder.com/800x1000/FFFFFF/333333?text=T-Shirt+Blanc',
                'rating' => 4.8,
                'reviews' => 156,
                'description' => 'T-shirt blanc en coton 100% biologique, coupe régulière. Parfait pour un look décontracté et élégant au quotidien.',
                'features' => json_encode(['100% Coton biologique', 'Coupe régulière', 'Lavable à 30°C', 'Disponible en S, M, L, XL']),
                'stock' => 45,
                'new' => false,
                'sale' => true
            ],
            [
                'name' => 'Robe d\'Été Fleurie',
                'categorie' => 'femme',
                'price' => 59.99,
                'old_price' => null,
                'image' => 'https://via.placeholder.com/800x1000/FFB6C1/FFFFFF?text=Robe+Fleurie',
                'rating' => 4.9,
                'reviews' => 89,
                'description' => 'Magnifique robe d\'été avec motifs floraux. Tissu léger et fluide, parfaite pour les journées ensoleillées.',
                'features' => json_encode(['Viscose légère', 'Motifs floraux', 'Coupe évasée', 'Longueur midi']),
                'stock' => 23,
                'new' => true,
                'sale' => false
            ],
            [
                'name' => 'Jean Slim Bleu Foncé',
                'categorie' => 'homme',
                'price' => 49.99,
                'old_price' => 69.99,
                'image' => 'https://via.placeholder.com/800x1000/1E3A8A/FFFFFF?text=Jean+Slim',
                'rating' => 4.6,
                'reviews' => 234,
                'description' => 'Jean slim stretch en denim premium. Coupe moderne et confortable grâce à l\'élasthanne.',
                'features' => json_encode(['98% Coton, 2% Élasthanne', 'Coupe slim', 'Lavage stone wash', 'Tailles 28 à 38']),
                'stock' => 67,
                'new' => false,
                'sale' => true
            ],
            [
                'name' => 'Blazer Noir Élégant',
                'categorie' => 'femme',
                'price' => 89.99,
                'old_price' => 119.99,
                'image' => 'https://via.placeholder.com/800x1000/000000/FFFFFF?text=Blazer+Noir',
                'rating' => 4.7,
                'reviews' => 112,
                'description' => 'Blazer noir classique et intemporel. Coupe ajustée parfaite pour le bureau ou les occasions spéciales.',
                'features' => json_encode(['Polyester premium', 'Doublure satin', 'Coupe ajustée', 'Poches avant']),
                'stock' => 18,
                'new' => true,
                'sale' => true
            ],
            [
                'name' => 'Sac à Main Cuir Marron',
                'categorie' => 'accessoires',
                'price' => 79.99,
                'old_price' => null,
                'image' => 'https://via.placeholder.com/800x1000/8B4513/FFFFFF?text=Sac+Cuir',
                'rating' => 4.8,
                'reviews' => 78,
                'description' => 'Sac à main en cuir véritable avec finitions soignées. Élégant et pratique avec plusieurs compartiments.',
                'features' => json_encode(['Cuir véritable', 'Fermeture éclair', 'Bandoulière ajustable', 'Dimensions: 30x25x12 cm']),
                'stock' => 34,
                'new' => true,
                'sale' => false
            ],
            [
                'name' => 'Montre Sport Noir',
                'categorie' => 'accessoires',
                'price' => 129.99,
                'old_price' => 159.99,
                'image' => 'https://via.placeholder.com/800x1000/2C3E50/FFFFFF?text=Montre+Sport',
                'rating' => 4.5,
                'reviews' => 203,
                'description' => 'Montre sport multifonction avec bracelet silicone. Étanche et résistante aux chocs.',
                'features' => json_encode(['Étanche 50m', 'Chronomètre', 'Rétroéclairage LED', 'Bracelet interchangeable']),
                'stock' => 52,
                'new' => false,
                'sale' => true
            ],
            [
                'name' => 'Chemise Lin Beige',
                'categorie' => 'homme',
                'price' => 44.99,
                'old_price' => null,
                'image' => 'https://via.placeholder.com/800x1000/F5F5DC/333333?text=Chemise+Lin',
                'rating' => 4.4,
                'reviews' => 67,
                'description' => 'Chemise en lin naturel, parfaite pour l\'été. Coupe décontractée et respirante.',
                'features' => json_encode(['100% Lin', 'Coupe décontractée', 'Col classique', 'Manches longues retroussables']),
                'stock' => 29,
                'new' => true,
                'sale' => false
            ],
            [
                'name' => 'Jupe Plissée Rose',
                'categorie' => 'femme',
                'price' => 39.99,
                'old_price' => 49.99,
                'image' => 'https://via.placeholder.com/800x1000/FFC0CB/FFFFFF?text=Jupe+Plissee',
                'rating' => 4.6,
                'reviews' => 91,
                'description' => 'Jupe plissée élégante en satin. Parfaite pour les occasions spéciales ou le quotidien.',
                'features' => json_encode(['Satin polyester', 'Taille élastique', 'Longueur midi', 'Lavable en machine']),
                'stock' => 41,
                'new' => false,
                'sale' => true
            ],
        ];

        foreach ($produits as $produit) {
            Produit::create($produit);
        }
    }
}
