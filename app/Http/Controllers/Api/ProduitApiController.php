<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProduitApiController extends Controller
{
    /**
     * Récupérer tous les produits
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $produits = Produit::orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'success' => true,
            'data' => $produits
        ], 200);
    }

    /**
     * Filtrer les produits par catégorie
     *
     * @param string $categorie
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter($categorie)
    {
        // Si la catégorie est "tous", retourner tous les produits
        if (strtolower($categorie) === 'tous') {
            $produits = Produit::orderBy('created_at', 'desc')->get();
        } else {
            $produits = Produit::where('categorie', $categorie)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return response()->json([
            'success' => true,
            'categorie' => $categorie,
            'count' => $produits->count(),
            'data' => $produits
        ], 200);
    }

    /**
     * Ajouter un nouveau produit
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'categorie' => 'required|in:homme,femme,accessoires',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'nullable|numeric|min:0|max:5',
            'reviews' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'features' => 'nullable|string',
            'stock' => 'nullable|integer|min:0',
            'new' => 'nullable|boolean',
            'sale' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Upload de l'image si présente
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('produits', 'public');
            }

            // Traitement des features
            $features = null;
            if ($request->filled('features')) {
                $features = array_map('trim', preg_split('/[,\n]+/', $request->features));
            }

            // Création du produit
            $produit = new Produit();
            $produit->name = $request->name;
            $produit->categorie = $request->categorie;
            $produit->price = $request->price;
            $produit->old_price = $request->old_price;
            $produit->image = $imagePath ?? 'https://via.placeholder.com/400x400.png?text=No+Image'; // Image par défaut
            $produit->rating = $request->rating ?? 0;
            $produit->reviews = $request->reviews ?? 0;
            $produit->description = $request->description ?? ''; // Description vide par défaut
            $produit->features = $features;
            $produit->stock = $request->stock ?? 0;
            $produit->new = $request->boolean('new', false);
            $produit->sale = $request->boolean('sale', false);
            $produit->save();

            return response()->json([
                'success' => true,
                'message' => 'Produit ajouté avec succès',
                'data' => $produit
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'ajout du produit',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
