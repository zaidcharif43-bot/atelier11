@extends('layouts.app')

@section('title', 'Produits - ' . ucfirst($categorie))

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Accueil</a>
                <span>/</span>
                <span>Catégories</span>
                <span>/</span>
                <span>{{ ucfirst($categorie) }}</span>
            </nav>
            <h1>Liste des produits de la catégorie : {{ ucfirst($categorie) }}</h1>
            <p>{{ $produits->total() }} produit(s) trouvé(s)</p>
        </div>
    </section>

    <!-- Categories Navigation -->
    <section class="section" style="padding-top: 20px; padding-bottom: 20px;">
        <div class="container">
            <div class="categories-nav"
                style="display: flex; gap: 15px; flex-wrap: wrap; justify-content: center; align-items: center;">
                <a href="{{ route('categories.index') }}"
                    class="btn {{ $categorie == 'Tous' ? 'btn-primary' : 'btn-outline' }}"
                    style="padding: 10px 25px; border-radius: 25px;">
                    Tous les produits
                </a>
                <a href="{{ route('categories.filter', 'homme') }}"
                    class="btn {{ $categorie == 'homme' ? 'btn-primary' : 'btn-outline' }}"
                    style="padding: 10px 25px; border-radius: 25px;">
                    👨 Homme
                </a>
                <a href="{{ route('categories.filter', 'femme') }}"
                    class="btn {{ $categorie == 'femme' ? 'btn-primary' : 'btn-outline' }}"
                    style="padding: 10px 25px; border-radius: 25px;">
                    👩 Femme
                </a>
                <a href="{{ route('categories.filter', 'accessoires') }}"
                    class="btn {{ $categorie == 'accessoires' ? 'btn-primary' : 'btn-outline' }}"
                    style="padding: 10px 25px; border-radius: 25px;">
                    👜 Accessoires
                </a>
                <a href="{{ route('produits.create') }}" class="btn btn-primary"
                    style="padding: 10px 25px; border-radius: 25px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-color: #28a745;">
                    <i class="fas fa-plus"></i> Ajouter un produit
                </a>
            </div>
        </div>
    </section>

    <!-- Products Table (selon le TP) -->
    <section class="section">
        <div class="container">
            <div style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
                <h2 style="margin-bottom: 20px; font-family: 'Playfair Display', serif;">
                    📦 Liste des Produits
                </h2>

                @if(count($produits) > 0)
                    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                        <thead>
                            <tr style="background: #1a1a2e; color: white;">
                                <th style="padding: 15px; text-align: left; border-radius: 10px 0 0 0;">ID</th>
                                <th style="padding: 15px; text-align: left;">Image</th>
                                <th style="padding: 15px; text-align: left;">Nom</th>
                                <th style="padding: 15px; text-align: left;">Catégorie</th>
                                <th style="padding: 15px; text-align: left;">Prix</th>
                                <th style="padding: 15px; text-align: left;">Stock</th>
                                <th style="padding: 15px; text-align: left; border-radius: 0 10px 0 0;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($produits as $p)
                                <tr style="border-bottom: 1px solid #eee; transition: background 0.3s;"
                                    onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='white'">
                                    <td style="padding: 15px;">{{ $p->id }}</td>
                                    <td style="padding: 15px;">
                                        <img src="{{ $p->image_url }}" alt="{{ $p->name }}"
                                            style="width: 60px; height: 60px; object-fit: cover; border-radius: 10px;">
                                    </td>
                                    <td style="padding: 15px; font-weight: 600;">{{ $p->name }}</td>
                                    <td style="padding: 15px;">
                                        <span
                                            style="background: #e94560; color: white; padding: 5px 12px; border-radius: 20px; font-size: 0.85rem;">
                                            {{ ucfirst($p->categorie) }}
                                        </span>
                                    </td>
                                    <td style="padding: 15px;">
                                        <span style="font-weight: 700; color: #e94560;">{{ number_format($p->price, 2) }}€</span>
                                        @if($p->old_price)
                                            <span
                                                style="text-decoration: line-through; color: #999; font-size: 0.85rem; margin-left: 5px;">
                                                {{ number_format($p->old_price, 2) }}€
                                            </span>
                                        @endif
                                    </td>
                                    <td style="padding: 15px;">
                                        @if($p->stock > 20)
                                            <span style="color: green;">✓ {{ $p->stock }} en stock</span>
                                        @elseif($p->stock > 0)
                                            <span style="color: orange;">⚠ {{ $p->stock }} restants</span>
                                        @else
                                            <span style="color: red;">✗ Rupture</span>
                                        @endif
                                    </td>
                                    <td style="padding: 15px;">
                                        <a href="{{ route('produits.show', $p->id) }}"
                                            style="background: #1a1a2e; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-size: 0.85rem;">
                                            Voir détails
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    <div style="margin-top: 30px; display: flex; justify-content: center;">
                        {{ $produits->links() }}
                    </div>
                @else
                    <div style="text-align: center; padding: 50px;">
                        <i class="fas fa-box-open" style="font-size: 4rem; color: #ccc; margin-bottom: 20px;"></i>
                        <h3 style="color: #666;">Aucun produit dans cette catégorie</h3>
                        <p style="color: #999;">Essayez une autre catégorie</p>
                        <a href="{{ route('categories.index') }}" class="btn btn-primary" style="margin-top: 20px;">
                            Voir tous les produits
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Products Grid (Version visuelle) -->
    <section class="section" style="background: #f8f9fa;">
        <div class="container">
            <div class="section-header" style="text-align: center; margin-bottom: 40px;">
                <span class="section-tag">Vue Grille</span>
                <h2 class="section-title">Produits - {{ ucfirst($categorie) }}</h2>
            </div>

            <div class="products-grid">
                @foreach($produits as $p)
                    <article class="product-card">
                        <div class="product-image">
<img src="{{ $p->image_url }}" alt="{{ $p->name }}" width="150">
                            <div class="product-overlay"></div>
                            @if($p->new)
                                <span class="product-badge badge-new">Nouveau</span>
                            @elseif($p->sale)
                                <span class="product-badge badge-sale">Promo</span>
                            @endif
                            <div class="product-actions">
                                <a href="{{ route('produits.show', $p->id) }}" class="action-btn" title="Aperçu">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('cart.add', $p->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="action-btn" title="Ajouter au panier">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </form>
                                <button class="action-btn" title="Favoris"><i class="fas fa-heart"></i></button>
                            </div>
                        </div>
                        <div class="product-info">
                            <span class="product-category">{{ ucfirst($p->categorie) }}</span>
                            <h3 class="product-name">
                                <a href="{{ route('produits.show', $p->id) }}">{{ $p->name }}</a>
                            </h3>
                            <div class="product-price">
                                <span class="price-current">{{ number_format($p->price, 2) }}€</span>
                                @if($p->old_price)
                                    <span class="price-old">{{ number_format($p->old_price, 2) }}€</span>
                                @endif
                            </div>
                            <div class="product-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star{{ $i <= floor($p->rating) ? '' : '-half-alt' }}"></i>
                                @endfor
                                <span>({{ $p->reviews }})</span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination Links (Vue Grille) -->
            <div style="margin-top: 40px; display: flex; justify-content: center;">
                {{ $produits->links() }}
            </div>
        </div>
    </section>
@endsection

@section('styles')
    <style>
        .categories-nav .btn-outline {
            background: white;
            border: 2px solid #1a1a2e;
            color: #1a1a2e;
        }

        .categories-nav .btn-outline:hover {
            background: #1a1a2e;
            color: white;
        }

        .categories-nav .btn-primary {
            background: #e94560;
            border: 2px solid #e94560;
            color: white;
        }

        /* Styles de pagination */
        nav[aria-label="Pagination Navigation"] {
            display: flex;
            justify-content: center;
        }

        nav[aria-label="Pagination Navigation"] .flex {
            display: flex;
            gap: 5px;
            align-items: center;
        }

        nav[aria-label="Pagination Navigation"] span[aria-current="page"] span {
            background: #e94560;
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 600;
        }

        nav[aria-label="Pagination Navigation"] a {
            background: white;
            color: #1a1a2e;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            border: 2px solid #e0e0e0;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        nav[aria-label="Pagination Navigation"] a:hover {
            background: #1a1a2e;
            color: white;
            border-color: #1a1a2e;
        }

        .pagination-info {
            text-align: center;
            margin-top: 15px;
            color: #666;
            font-size: 0.9rem;
        }
    </style>
@endsection