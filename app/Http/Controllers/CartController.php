<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Afficher le panier
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        $total = $this->calculateTotal($cart);
        
        return view('cart.index', compact('cart', 'total'));
    }

    /**
     * Ajouter un produit au panier
     */
    public function add(Request $request, $id)
    {
        $produit = Produit::findOrFail($id);
        
        $cart = Session::get('cart', []);
        
        // Récupérer la quantité demandée (par défaut 1)
        $quantity = $request->input('quantity', 1);
        
        // Si le produit existe déjà dans le panier, on augmente la quantité
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            // Sinon, on ajoute le produit au panier
            $cart[$id] = [
                'id' => $produit->id,
                'name' => $produit->name,
                'price' => $produit->price,
                'quantity' => $quantity,
                'image' => $produit->image_url  // Utiliser l'accesseur pour l'URL complète
            ];
        }
        
        Session::put('cart', $cart);
        
        return redirect()->back()->with('success', 'Produit ajouté au panier avec succès!');
    }

    /**
     * Mettre à jour la quantité d'un produit dans le panier
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);
        
        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            Session::put('cart', $cart);
            
            if ($request->ajax()) {
                $total = $this->calculateTotal($cart);
                $itemTotal = $cart[$id]['price'] * $cart[$id]['quantity'];
                
                return response()->json([
                    'success' => true,
                    'message' => 'Quantité mise à jour',
                    'itemTotal' => number_format($itemTotal, 2),
                    'total' => number_format($total, 2)
                ]);
            }
            
            return redirect()->back()->with('success', 'Quantité mise à jour!');
        }
        
        return redirect()->back()->with('error', 'Produit introuvable dans le panier');
    }

    /**
     * Supprimer un produit du panier
     */
    public function remove($id)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
            
            return redirect()->back()->with('success', 'Produit retiré du panier!');
        }
        
        return redirect()->back()->with('error', 'Produit introuvable dans le panier');
    }

    /**
     * Vider le panier
     */
    public function clear()
    {
        Session::forget('cart');
        
        return redirect()->back()->with('success', 'Panier vidé avec succès!');
    }

    /**
     * Obtenir le nombre d'articles dans le panier (pour l'affichage dans le header)
     */
    public function count()
    {
        $cart = Session::get('cart', []);
        $count = array_sum(array_column($cart, 'quantity'));
        
        return response()->json(['count' => $count]);
    }

    /**
     * Calculer le total du panier
     */
    private function calculateTotal($cart)
    {
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return $total;
    }
}
