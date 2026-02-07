# 🛒 Installation et test du système de panier

## Installation rapide

### 1. Installer Stripe
```bash
composer require stripe/stripe-php
```

### 2. Configuration Stripe
Créez un compte gratuit sur [stripe.com](https://stripe.com) et récupérez vos clés API dans [dashboard.stripe.com/test/apikeys](https://dashboard.stripe.com/test/apikeys)

Ajoutez dans votre `.env`:
```env
STRIPE_KEY=pk_test_votre_cle_publique_ici
STRIPE_SECRET=sk_test_votre_cle_secrete_ici
STRIPE_WEBHOOK_SECRET=whsec_votre_secret_webhook
```

### 3. Test rapide

#### Ajouter le bouton au panier dans vos vues produits

Dans `resources/views/produits.blade.php` ou `resources/views/pages/produit-detail.blade.php`:

```blade
<!-- Bouton Ajouter au panier -->
<form action="{{ route('cart.add', $produit->id) }}" method="POST" class="d-inline">
    @csrf
    <button type="submit" class="btn btn-success btn-lg">
        <i class="fas fa-cart-plus"></i> Ajouter au panier
    </button>
</form>
```

#### Ajouter le lien panier dans le header

Dans `resources/views/layouts/app.blade.php`, ajoutez dans la navbar:

```blade
<li class="nav-item">
    <a class="nav-link position-relative" href="{{ route('cart.index') }}">
        <i class="fas fa-shopping-cart fa-lg"></i>
        @php
            $cart = Session::get('cart', []);
            $count = !empty($cart) ? array_sum(array_column($cart, 'quantity')) : 0;
        @endphp
        @if($count > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-count-badge">
                {{ $count }}
            </span>
        @endif
    </a>
</li>
```

### 4. Testez !

1. Démarrez votre serveur:
   ```bash
   php artisan serve
   ```

2. Allez sur une page produit et cliquez sur "Ajouter au panier"

3. Allez sur `/cart` pour voir votre panier

4. Cliquez sur "Procéder au paiement"

5. Utilisez une carte de test Stripe:
   - Numéro: `4242 4242 4242 4242`
   - Date: n'importe quelle date future
   - CVC: n'importe quel code à 3 chiffres

## 🎯 Routes disponibles

- `/cart` - Voir le panier
- `/checkout` - Page de paiement
- `/checkout/success` - Confirmation après paiement
- `/checkout/cancel` - Annulation du paiement

## 🔧 Fonctionnalités

✅ Ajout de produits au panier
✅ Modification des quantités (+ / -)
✅ Suppression de produits
✅ Vidage du panier
✅ Calcul automatique des totaux
✅ Mise à jour AJAX en temps réel
✅ Paiement sécurisé Stripe
✅ Pages de succès et annulation

## 📱 Responsive

Toutes les vues sont responsive et utilisent Bootstrap 5.

## 🔒 Sécurité

- Protection CSRF sur tous les formulaires
- Validation des données côté serveur
- Clés Stripe sécurisées (jamais exposées côté client)
- Sessions Laravel chiffrées

## 🐛 Dépannage

Si vous rencontrez des problèmes:

1. **Le panier n'apparaît pas:**
   - Vérifiez que les sessions sont activées: `SESSION_DRIVER=file` dans `.env`
   - Vérifiez les permissions du dossier `storage/framework/sessions`

2. **Erreur Stripe:**
   - Vérifiez vos clés API dans `.env`
   - Assurez-vous d'utiliser les clés TEST (pk_test_ et sk_test_)
   - Vérifiez que composer a bien installé stripe/stripe-php

3. **Compteur du panier ne se met pas à jour:**
   - Vérifiez que jQuery est chargé
   - Ouvrez la console du navigateur pour voir les erreurs JavaScript

## 📖 Pour plus de détails

Consultez le guide complet: [PANIER_STRIPE_GUIDE.md](PANIER_STRIPE_GUIDE.md)
