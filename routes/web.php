<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\RproductController;

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
// Routes TP Atelier 8 - Ajout de Produit
// ========================================
// IMPORTANT: Ces routes doivent être AVANT /produits/{category} pour éviter les conflits
Route::get('/produits/cleanup', [RproductController::class, 'showCleanup'])->name('produits.cleanup.show');
Route::post('/produits/cleanup', [RproductController::class, 'cleanup'])->name('produits.cleanup');
Route::get('/produits/manage', [RproductController::class, 'manage'])->name('produits.manage');
Route::get('/produits/create', [RproductController::class, 'create'])->name('produits.create');
Route::post('/produits/store', [RproductController::class, 'store'])->name('produits.store');
Route::delete('/produits/{id}', [RproductController::class, 'destroy'])->name('produits.delete');

// Routes dynamiques (doivent être APRÈS les routes spécifiques)
Route::get('/produits/{category}', [ProductController::class, 'category'])->name('produits.category');
Route::get('/produit/{id}', [ProductController::class, 'show'])->name('produits.show');

// ========================================
// Routes TP Atelier 7 - Filtrage par catégorie
// ========================================
Route::get('/categories', [ProduitController::class, 'index'])->name('categories.index');
Route::get('/categories/{cat}', [ProduitController::class, 'getProductsByCategorie'])->name('categories.filter');

