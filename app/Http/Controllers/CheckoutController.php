<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class CheckoutController extends Controller
{
    /**
     * Afficher la page de paiement
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide');
        }
        
        $total = $this->calculateTotal($cart);
        
        return view('checkout.index', compact('cart', 'total'));
    }

    /**
     * Créer une session de paiement Stripe
     */
    public function createSession(Request $request)
    {
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide');
        }

        // Configuration de Stripe
        Stripe::setApiKey(config('services.stripe.secret'));

        // Préparer les items pour Stripe
        $lineItems = [];
        foreach ($cart as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item['name'],
                        'images' => [$item['image'] ?? ''],
                    ],
                    'unit_amount' => (int)($item['price'] * 100), // Stripe utilise les centimes
                ],
                'quantity' => $item['quantity'],
            ];
        }

        try {
            // Créer la session de paiement Stripe
            $checkoutSession = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.cancel'),
                'customer_email' => auth()->user()->email ?? $request->email,
            ]);

            return redirect($checkoutSession->url);
        } catch (\Exception $e) {
            return redirect()->route('checkout.index')
                ->with('error', 'Erreur lors de la création de la session de paiement: ' . $e->getMessage());
        }
    }

    /**
     * Page de succès après paiement
     */
    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        
        if ($sessionId) {
            // Vider le panier après paiement réussi
            Session::forget('cart');
            
            // Vous pouvez ici enregistrer la commande dans la base de données
            // $this->saveOrder($sessionId);
            
            return view('checkout.success', compact('sessionId'));
        }
        
        return redirect()->route('home');
    }

    /**
     * Page d'annulation
     */
    public function cancel()
    {
        return view('checkout.cancel');
    }

    /**
     * Webhook Stripe pour recevoir les événements
     */
    public function webhook(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sigHeader,
                $webhookSecret
            );

            // Traiter les différents types d'événements
            switch ($event->type) {
                case 'checkout.session.completed':
                    $session = $event->data->object;
                    // Traiter la commande validée
                    $this->handleSuccessfulPayment($session);
                    break;
                
                case 'payment_intent.payment_failed':
                    $paymentIntent = $event->data->object;
                    // Gérer l'échec du paiement
                    break;
                
                default:
                    // Type d'événement non géré
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Traiter le paiement réussi
     */
    private function handleSuccessfulPayment($session)
    {
        // Ici vous pouvez:
        // 1. Créer une commande dans la base de données
        // 2. Envoyer un email de confirmation
        // 3. Mettre à jour le stock des produits
        // 4. etc.
        
        \Log::info('Paiement réussi', ['session_id' => $session->id]);
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
