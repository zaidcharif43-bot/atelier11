# Système de Panier et Paiement Stripe - Guide Complet

## 📋 Vue d'ensemble

Ce système implémente un **panier d'achat complet** avec gestion de session et **paiement sécurisé via Stripe**.

### Fonctionnalités principales

✅ **Gestion du panier en session**
- Ajout de produits au panier
- Modification des quantités
- Suppression de produits
- Vidage complet du panier

✅ **Interface utilisateur moderne**
- Panier dynamique avec mise à jour AJAX
- Compteur du panier en temps réel
- Design responsive Bootstrap 5

✅ **Paiement sécurisé Stripe**
- Intégration Stripe Checkout
- Support multi-devises
- Webhooks pour les événements de paiement
- Pages de succès et annulation

---

## 🏗️ Architecture

### Structure des données du panier

Le panier est stocké dans la session Laravel avec la structure suivante:

```php
Session::get('cart') = [
    'product_id' => [
        'id' => 1,
        'name' => 'Nom du produit',
        'price' => 99.99,
        'quantity' => 2,
        'image' => 'url_image'
    ],
    // ...
]
```

### Composants créés

#### 1. **CartController** (`app/Http/Controllers/CartController.php`)

**Méthodes:**

- `index()` - Affiche le panier
- `add($id)` - Ajoute un produit au panier
- `update($id)` - Modifie la quantité d'un produit
- `remove($id)` - Supprime un produit
- `clear()` - Vide le panier
- `count()` - Retourne le nombre d'articles (API)
- `calculateTotal($cart)` - Calcule le total

#### 2. **CheckoutController** (`app/Http/Controllers/CheckoutController.php`)

**Méthodes:**

- `index()` - Page de paiement
- `createSession()` - Crée une session Stripe Checkout
- `success()` - Page de confirmation après paiement
- `cancel()` - Page d'annulation
- `webhook()` - Endpoint pour les webhooks Stripe
- `handleSuccessfulPayment()` - Traite les paiements réussis

#### 3. **Routes** (ajoutées dans `routes/web.php`)

```php
// Panier
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

// Paiement
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/create-session', [CheckoutController::class, 'createSession'])->name('checkout.create-session');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
Route::post('/stripe/webhook', [CheckoutController::class, 'webhook'])->name('stripe.webhook');
```

#### 4. **Vues créées**

- `resources/views/cart/index.blade.php` - Page du panier
- `resources/views/checkout/index.blade.php` - Page de paiement
- `resources/views/checkout/success.blade.php` - Confirmation de paiement
- `resources/views/checkout/cancel.blade.php` - Annulation de paiement

---

## ⚙️ Configuration

### 1. Installer Stripe

```bash
composer require stripe/stripe-php
```

### 2. Configuration des clés Stripe

Dans le fichier `.env`, ajoutez vos clés Stripe (disponibles sur [dashboard.stripe.com](https://dashboard.stripe.com)):

```env
STRIPE_KEY=pk_test_votre_cle_publique
STRIPE_SECRET=sk_test_votre_cle_secrete
STRIPE_WEBHOOK_SECRET=whsec_votre_secret_webhook
```

> **Note:** Pour les tests, utilisez les clés de test (`pk_test_` et `sk_test_`).

### 3. Cartes de test Stripe

Pour tester les paiements en mode test:

| Carte | Numéro | Résultat |
|-------|--------|----------|
| Succès | 4242 4242 4242 4242 | Paiement réussi |
| Refusé | 4000 0000 0000 0002 | Carte refusée |
| 3D Secure | 4000 0027 6000 3184 | Authentification requise |

- **Date d'expiration:** N'importe quelle date future
- **CVC:** N'importe quel code à 3 chiffres

---

## 🎯 Utilisation

### 1. Ajouter un produit au panier

Dans vos vues de produits, ajoutez ce formulaire:

```blade
<form action="{{ route('cart.add', $produit->id) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-cart-plus"></i> Ajouter au panier
    </button>
</form>
```

### 2. Afficher le compteur du panier

Dans votre layout (`layouts/app.blade.php`), ajoutez:

```blade
<a href="{{ route('cart.index') }}" class="nav-link">
    <i class="fas fa-shopping-cart"></i>
    <span class="badge bg-danger cart-count-badge">
        {{ count(Session::get('cart', [])) > 0 ? array_sum(array_column(Session::get('cart', []), 'quantity')) : 0 }}
    </span>
</a>
```

### 3. Gestion dynamique du panier

Le JavaScript intégré dans `cart/index.blade.php` permet:
- Mise à jour automatique des quantités via AJAX
- Recalcul automatique des totaux
- Mise à jour du compteur dans le header

---

## 🔒 Sécurité

### Niveaux de sécurité implémentés

1. **Protection CSRF**
   - Tous les formulaires utilisent `@csrf`
   - Token vérifié automatiquement par Laravel

2. **Validation des données**
   ```php
   $request->validate([
       'quantity' => 'required|integer|min:1'
   ]);
   ```

3. **Vérification des produits**
   ```php
   $produit = Produit::findOrFail($id); // Lance une 404 si introuvable
   ```

4. **Session sécurisée**
   - Sessions Laravel avec encryption automatique
   - Configuration dans `config/session.php`

5. **Stripe sécurisé**
   - Clés API jamais exposées côté client
   - Webhooks signés pour authentification
   - PCI DSS compliant (Stripe gère les cartes)

6. **Middleware d'authentification (optionnel)**
   ```php
   Route::middleware(['auth'])->group(function () {
       Route::get('/checkout', [CheckoutController::class, 'index']);
   });
   ```

---

## 🔗 Webhooks Stripe

Les webhooks permettent de recevoir des notifications en temps réel de Stripe.

### Configuration

1. **Dans le dashboard Stripe:**
   - Allez dans "Développeurs" > "Webhooks"
   - Ajoutez un endpoint: `https://votredomaine.com/stripe/webhook`
   - Sélectionnez les événements: `checkout.session.completed`, `payment_intent.payment_failed`

2. **Testez en local avec Stripe CLI:**
   ```bash
   stripe listen --forward-to localhost:8000/stripe/webhook
   ```

### Événements gérés

- `checkout.session.completed` - Paiement réussi
- `payment_intent.payment_failed` - Paiement échoué

---

## 📊 Flux de paiement

```
1. Client consulte produits
   ↓
2. Ajoute au panier (session)
   ↓
3. Consulte le panier (/cart)
   ↓
4. Clique "Procéder au paiement" (/checkout)
   ↓
5. Crée session Stripe
   ↓
6. Redirection vers Stripe Checkout
   ↓
7a. Paiement réussi → /checkout/success (panier vidé)
7b. Paiement annulé → /checkout/cancel (panier conservé)
   ↓
8. Webhook reçu → Traitement asynchrone
```

---

## 🎨 Personnalisation

### Modifier la devise

Dans `CheckoutController.php`:

```php
'currency' => 'usd', // eur, gbp, chf, etc.
```

### Ajouter des frais de livraison

```php
$lineItems[] = [
    'price_data' => [
        'currency' => 'eur',
        'product_data' => ['name' => 'Frais de livraison'],
        'unit_amount' => 500, // 5,00 €
    ],
    'quantity' => 1,
];
```

### Limiter le stock

Dans `CartController@add()`:

```php
if ($produit->stock < 1) {
    return redirect()->back()->with('error', 'Produit en rupture de stock');
}

// Vérifier la quantité disponible
if (isset($cart[$id])) {
    if ($cart[$id]['quantity'] >= $produit->stock) {
        return redirect()->back()->with('error', 'Stock insuffisant');
    }
}
```

---

## 🧪 Tests

### Tester le panier en session

```php
// tests/Feature/CartTest.php
public function test_can_add_product_to_cart()
{
    $produit = Produit::factory()->create();
    
    $response = $this->post(route('cart.add', $produit->id));
    
    $response->assertRedirect();
    $this->assertArrayHasKey($produit->id, session('cart'));
}
```

### Tester Stripe (avec mocks)

```php
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

public function test_creates_stripe_session()
{
    Stripe::setApiKey(config('services.stripe.secret'));
    
    // Utiliser des données de test
    $response = $this->post(route('checkout.create-session'), [
        'email' => 'test@example.com'
    ]);
    
    $response->assertRedirect();
}
```

---

## 📝 Extensions possibles

### 1. Enregistrer les commandes en base de données

Créer une table `orders`:

```bash
php artisan make:migration create_orders_table
```

```php
Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->nullable()->constrained();
    $table->string('stripe_session_id')->unique();
    $table->decimal('total', 10, 2);
    $table->string('status')->default('pending');
    $table->json('items');
    $table->timestamps();
});
```

### 2. Codes promo

```php
// Dans CartController
private function applyPromoCode($cart, $code)
{
    $promo = PromoCode::where('code', $code)
                      ->where('valid_until', '>', now())
                      ->first();
    
    if ($promo) {
        $discount = $this->calculateTotal($cart) * ($promo->percentage / 100);
        return $discount;
    }
    
    return 0;
}
```

### 3. Envoi d'emails de confirmation

```php
use Illuminate\Support\Facades\Mail;

Mail::to($customer->email)->send(new OrderConfirmation($order));
```

---

## 🚀 Mise en production

### Checklist

- [ ] Remplacer les clés Stripe test par les clés production
- [ ] Configurer les webhooks Stripe en production
- [ ] Activer HTTPS (requis par Stripe)
- [ ] Configurer `SESSION_SECURE_COOKIE=true` dans `.env`
- [ ] Tester avec de vraies cartes (petits montants)
- [ ] Implémenter la sauvegarde des commandes en BDD
- [ ] Configurer les emails de confirmation
- [ ] Mettre en place la gestion des stocks

---

## 📚 Ressources

- [Documentation Laravel Sessions](https://laravel.com/docs/11.x/session)
- [Documentation Stripe PHP](https://stripe.com/docs/api/php)
- [Stripe Checkout](https://stripe.com/docs/payments/checkout)
- [Stripe Webhooks](https://stripe.com/docs/webhooks)
- [Stripe Testing](https://stripe.com/docs/testing)

---

## 🆘 Support

Pour toute question ou problème:
1. Vérifiez les logs Laravel: `storage/logs/laravel.log`
2. Vérifiez les événements Stripe dans le dashboard
3. Utilisez `dd()` ou `Log::info()` pour déboguer

---

**Créé pour Atelier 10 - Laravel E-commerce** 🛒
