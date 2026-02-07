<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\RproductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

// Page d'accueil
Route::get('/', [PageController::class, 'home'])->name('home');

// Pages statiques
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

// Route pour traiter le formulaire de contact
Route::post('/contact', [PageController::class, 'sendContact'])->name('contact.send');

// Routes produits (version originale)
Route::get('/produits', [ProductController::class, 'index'])->name('produits.index');

// ========================================
// Routes TP Atelier 8 - Ajout de Produit - SÉCURISÉES PAR MIDDLEWARE ADMIN
// ========================================
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/produits/cleanup', [RproductController::class, 'showCleanup'])->name('produits.cleanup.show');
    Route::post('/produits/cleanup', [RproductController::class, 'cleanup'])->name('produits.cleanup');
    Route::get('/produits/manage', [RproductController::class, 'manage'])->name('produits.manage');
    Route::get('/produits/create', [RproductController::class, 'create'])->name('produits.create');
    Route::post('/produits/store', [RproductController::class, 'store'])->name('produits.store');
    Route::get('/produits/{id}/show', [RproductController::class, 'show'])->name('produits.show.admin');
    Route::get('/produits/{id}/edit', [RproductController::class, 'edit'])->name('produits.edit');
    Route::put('/produits/{id}', [RproductController::class, 'update'])->name('produits.update');
    Route::delete('/produits/{id}', [RproductController::class, 'destroy'])->name('produits.delete');
    Route::get('/espaceadmin', [ProduitController::class, 'espaceadmin'])->name('espaceadmin');
});

// Routes dynamiques (doivent être APRÈS les routes spécifiques)
Route::get('/produits/{category}', [ProductController::class, 'category'])->name('produits.category');
Route::get('/produit/{id}', [ProductController::class, 'show'])->name('produits.show');

// ========================================
// Routes TP Atelier 10 - Panier d'achat avec Session
// ========================================
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/debug', function() { return view('cart.debug'); })->name('cart.debug');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

// ========================================
// Routes TP Atelier 10 - Paiement Stripe
// ========================================
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/create-session', [CheckoutController::class, 'createSession'])->name('checkout.create-session');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
Route::post('/stripe/webhook', [CheckoutController::class, 'webhook'])->name('stripe.webhook');

// ========================================
// Routes TP Atelier 7 - Filtrage par catégorie
// ========================================
Route::get('/categories', [ProduitController::class, 'index'])->name('categories.index');
Route::get('/categories/{cat}', [ProduitController::class, 'getProductsByCategorie'])->name('categories.filter');

// ========================================
// Routes TP Atelier 10 - Application React
// ========================================
Route::get('/react-app', function () {
    return view('react-app');
})->name('react.app');

// ========================================
// Routes TP Atelier 11 - Espace Client (SÉCURISÉ PAR MIDDLEWARE USER)
// ========================================
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/espaceclient', [ProduitController::class, 'espaceclient'])->name('espaceclient');
});

// ========================================
// Routes Profil Utilisateur (SÉCURISÉ - AUTH REQUIS)
// ========================================
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes d'authentification Laravel UI
Auth::routes();

// Dashboard après connexion
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
