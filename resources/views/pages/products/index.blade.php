@extends('layouts.app')

@section('title', 'Nos Produits - ClothesZC')

@section('content')
<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1>Nos Produits</h1>
        <p>Découvrez notre collection de vêtements tendance</p>
    </div>
</section>

<!-- Products Section -->
<section class="section">
    <div class="container">
        <div class="products-layout">
            <!-- Sidebar -->
            <aside class="sidebar">
                <div class="filter-group">
                    <h3>Catégories</h3>
                    <ul class="filter-list">
                        <li><a href="{{ route('produits.index') }}" class="active">Tous les produits</a></li>
                        @foreach($categories as $slug => $cat)
                        <li><a href="{{ route('produits.category', $slug) }}">{{ $cat['name'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </aside>

            <!-- Products Grid -->
            <div class="products-main">
                <div class="products-header">
                    <p>{{ count($products) }} produits trouvés</p>
                    <select class="sort-select">
                        <option>Trier par: Popularité</option>
                        <option>Prix: Croissant</option>
                        <option>Prix: Décroissant</option>
                        <option>Nouveautés</option>
                    </select>
                </div>

                <div class="products-grid">
                    @forelse($products as $product)
                    <div class="product-card">
                        <div class="product-image">
                            <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}">
                            @if($product['new'])
                            <span class="product-badge badge-new">Nouveau</span>
                            @endif
                            @if($product['sale'])
                            <span class="product-badge badge-sale">Promo</span>
                            @endif
                            <div class="product-actions">
                                <button title="Aperçu"><i class="fas fa-eye"></i></button>
                                <button title="Panier"><i class="fas fa-shopping-bag"></i></button>
                                <button title="Favoris"><i class="fas fa-heart"></i></button>
                            </div>
                        </div>
                        <div class="product-info">
                            <span class="product-category">{{ ucfirst($product['category']) }}</span>
                            <h3 class="product-name">
                                <a href="{{ route('produits.show', $product['id']) }}">{{ $product['name'] }}</a>
                            </h3>
                            <div class="product-price">
                                <span class="price-current">{{ number_format($product['price'], 2) }}€</span>
                                @if($product['old_price'])
                                <span class="price-old">{{ number_format($product['old_price'], 2) }}€</span>
                                @endif
                            </div>
                            <div class="product-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($product['rating']))
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                                <span>({{ $product['reviews'] }})</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <i class="fas fa-box-open"></i>
                        <h3>Aucun produit trouvé</h3>
                        <p>Revenez bientôt pour découvrir nos nouveautés!</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
/* Page Header */
.page-header {
    background: linear-gradient(rgba(44, 62, 80, 0.9), rgba(44, 62, 80, 0.9)),
                url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1920&q=80');
    background-size: cover;
    background-position: center;
    padding: 80px 0;
    text-align: center;
    color: #fff;
}

.page-header h1 {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.page-header p {
    font-size: 1.1rem;
    opacity: 0.9;
}

/* Products Layout */
.products-layout {
    display: grid;
    grid-template-columns: 250px 1fr;
    gap: 40px;
}

/* Sidebar */
.sidebar {
    background: #f8f9fa;
    padding: 30px;
    border-radius: 10px;
    height: fit-content;
}

.filter-group h3 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e74c3c;
}

.filter-list {
    list-style: none;
}

.filter-list li {
    margin-bottom: 12px;
}

.filter-list li a {
    color: #666;
    font-size: 0.95rem;
    transition: color 0.3s;
}

.filter-list li a:hover,
.filter-list li a.active {
    color: #e74c3c;
    font-weight: 500;
}

/* Products Header */
.products-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid #eee;
}

.products-header p {
    color: #666;
}

.sort-select {
    padding: 10px 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-family: 'Poppins', sans-serif;
    font-size: 0.9rem;
    cursor: pointer;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    grid-column: 1 / -1;
}

.empty-state i {
    font-size: 4rem;
    color: #ddd;
    margin-bottom: 20px;
}

.empty-state h3 {
    font-size: 1.5rem;
    color: #333;
    margin-bottom: 10px;
}

.empty-state p {
    color: #666;
}

/* Responsive */
@media (max-width: 992px) {
    .products-layout {
        grid-template-columns: 1fr;
    }

    .sidebar {
        order: -1;
    }
}

@media (max-width: 576px) {
    .page-header h1 {
        font-size: 2rem;
    }

    .products-header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
}
</style>
@endsection
