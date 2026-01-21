<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddProductRequest;
use App\Models\Produit;
use Illuminate\Support\Facades\Storage;

class RproductController extends Controller
{
    /**
     * Afficher le formulaire d'ajout de produit.
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Récupérer les catégories existantes pour le select
        $categories = Produit::getCategories();

        return view('pages.addproduit', compact('categories'));
    }

    /**
     * Enregistrer un nouveau produit en base de données.
     * 
     * @param AddProductRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AddProductRequest $request)
    {
        // Valider les données
        $request->validated();

        // Configuration Cloudinary
        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key' => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
        ]);

        // Upload de l'image vers Cloudinary
        $imageUrl = null;
        if ($request->hasFile('image')) {
            $result = $cloudinary->uploadApi()->upload(
                $request->file('image')->getRealPath(),
                [
                    'folder' => 'ClothesZC/produits',
                ]
            );
            $imageUrl = $result['secure_url'];
        }

        // Traiter les features (convertir en tableau si c'est une chaîne)
        $features = null;
        if ($request->filled('features')) {
            $features = array_map('trim', preg_split('/[,\n]+/', $request->input('features')));
        }

        // Créer le produit
        $produit = new Produit();
        $produit->name = $request->input('name');
        $produit->categorie = $request->input('categorie');
        $produit->price = $request->input('price');
        $produit->old_price = $request->input('old_price');
        $produit->image = $imageUrl;
        $produit->rating = $request->input('rating') ?? 0;
        $produit->reviews = $request->input('reviews') ?? 0;
        $produit->description = $request->input('description');
        $produit->features = $features;
        $produit->stock = $request->input('stock') ?? 0;
        $produit->new = $request->has('new') ? true : false;
        $produit->sale = $request->has('sale') ? true : false;

        $produit->save();

        // Rediriger vers la liste des produits
        return redirect()->route('produits.index')
            ->with('success', 'Le produit a été ajouté avec succès !');
    }

    /**
     * Afficher la page de gestion des produits.
     * 
     * @return \Illuminate\View\View
     */
    public function manage()
    {
        $products = Produit::orderBy('created_at', 'desc')->paginate(10);
        return view('pages.manage-products', compact('products'));
    }

    /**
     * Supprimer un produit.
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $product = Produit::findOrFail($id);

        // Supprimer l'image si elle existe
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        $product->delete();

        return redirect()->route('produits.manage')
            ->with('success', 'Le produit a été supprimé avec succès !');
    }

    /**
     * Afficher la page de nettoyage.
     * 
     * @return \Illuminate\View\View
     */
    public function showCleanup()
    {
        $count = Produit::count();
        return view('pages.cleanup', compact('count'));
    }

    /**
     * Supprimer tous les produits.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cleanup()
    {
        $products = Produit::all();

        // Supprimer toutes les images
        foreach ($products as $product) {
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
        }

        // Supprimer tous les produits
        Produit::truncate();

        return redirect()->route('produits.cleanup.show')
            ->with('success', 'Tous les produits ont été supprimés avec succès !');
    }
}
