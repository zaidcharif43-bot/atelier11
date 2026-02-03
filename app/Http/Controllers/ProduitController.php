<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    /**
     * Affiche tous les produits avec pagination
     */
    public function index()
    {
        $produits = Produit::paginate(3);
        return view('produits', [
            'produits' => $produits,
            'categorie' => 'Tous'
        ]);
    }

    /**
     * Récupérer la liste des produits dont la colonne 'categorie' = $cat avec pagination
     */
    public function getProductsByCategorie($cat)
    {
        // Récupérer la liste des produits dont la colonne 'categorie' = $cat avec pagination
        $produits = Produit::where('categorie', $cat)->paginate(3);

        // Retourner la vue 'produits' avec la liste filtrée
        return view('produits', [
            'produits' => $produits,
            'categorie' => $cat
        ]);
    }

    /**
     * Affiche un produit spécifique
     */
    public function show($id)
    {
        $produit = Produit::findOrFail($id);
        return view('produit-detail', [
            'produit' => $produit
        ]);
    }

    /**
     * Espace client - Affiche les produits en solde
     */
    public function espaceclient()
    {
        // Récupérer tous les produits en solde
        $produitsEnSolde = Produit::where('sale', true)->paginate(6);
        
        return view('espaceclient', [
            'produits' => $produitsEnSolde
        ]);
    }

    /**
     * Espace admin - Gestion des produits
     */
    public function espaceadmin()
    {
        $produits = Produit::orderBy('created_at', 'desc')->paginate(10);
        return view('espaceadmin', [
            'produits' => $produits
        ]);
    }
}
