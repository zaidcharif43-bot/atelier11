@extends('layouts.app')

@section('title', $product->name . ' - ClothesZC')

@section('content')
<!-- Page Header -->
<section class="page-header page-header-small">
    <div class="container">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Accueil</a>
            <span>/</span>
            <a href="{{ route('produits.index') }}">Produits</a>
            <span>/</span>
            <span>{{ $product->name }}</span>
        </nav>
    </div>
</section>

<!-- Product Detail -->
<section class="section product-detail-section">
    <div class="container">
        <div class="product-detail-grid">
            <!-- Product Images -->
            <div class="product-gallery">
                <div class="main-image">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" id="mainImage">
                    @if($product->new)
                    <span class="product-badge badge-new">Nouveau</span>
                    @elseif($product->sale && $product->old_price)
                    <span class="product-badge badge-sale">-{{ round((1 - $product->price/$product->old_price) * 100) }}%</span>
                    @endif
                </div>
                <div class="thumbnail-images">
                    <div class="thumbnail active" onclick="changeImage(this)">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                    </div>
                    <div class="thumbnail" onclick="changeImage(this)">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                    </div>
                    <div class="thumbnail" onclick="changeImage(this)">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                    </div>
                </div>
            </div>

            <!-- Product Info -->
            <div class="product-info-detail">
                <span class="product-category-tag">{{ ucfirst($product->categorie) }}</span>
                <h1 class="product-title">{{ $product->name }}</h1>
                
                <div class="product-rating-detail">
                    <div class="stars">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star{{ $i <= floor($product->rating) ? '' : ($i - 0.5 <= $product->rating ? '-half-alt' : '') }}"></i>
                        @endfor
                    </div>
                    <span class="rating-text">{{ $product->rating }}/5</span>
                    <span class="reviews-count">({{ $product->reviews }} avis)</span>
                </div>

                <div class="product-price-detail">
                    <span class="current-price">{{ number_format($product->price, 2) }}€</span>
                    @if($product->old_price)
                    <span class="old-price">{{ number_format($product->old_price, 2) }}€</span>
                    <span class="discount-badge">-{{ round((1 - $product->price/$product->old_price) * 100) }}%</span>
                    @endif
                </div>

                <p class="product-description">{{ $product->description }}</p>

                @if(!empty($product->features) && is_array($product->features))
                <div class="product-features">
                    <h3>Caractéristiques</h3>
                    <ul>
                        @foreach($product->features as $feature)
                        <li><i class="fas fa-check"></i> {{ $feature }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="product-options">
                    <!-- Size Selection -->
                    <div class="option-group">
                        <label>Taille</label>
                        <div class="size-buttons">
                            <button class="size-btn">S</button>
                            <button class="size-btn active">M</button>
                            <button class="size-btn">L</button>
                            <button class="size-btn">XL</button>
                        </div>
                    </div>

                    <!-- Quantity -->
                    <div class="option-group">
                        <label>Quantité</label>
                        <div class="quantity-selector">
                            <button class="qty-btn" onclick="decreaseQty()">-</button>
                            <input type="number" value="1" min="1" id="quantity">
                            <button class="qty-btn" onclick="increaseQty()">+</button>
                        </div>
                    </div>
                </div>

                <div class="stock-info">
                    <i class="fas fa-check-circle"></i>
                    <span>En stock ({{ $product->stock }} disponibles)</span>
                </div>

                <div class="product-actions-detail">
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" style="display: inline-block; width: 100%;">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-lg" style="width: calc(100% - 70px); margin-right: 10px;">
                            <i class="fas fa-shopping-bag"></i> Ajouter au panier
                        </button>
                    </form>
                    <button class="btn btn-outline btn-lg wishlist-btn" style="width: 60px;">
                        <i class="far fa-heart"></i>
                    </button>
                </div>

                <div class="product-meta">
                    <div class="meta-item">
                        <i class="fas fa-truck"></i>
                        <span>Livraison gratuite dès 50€</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-undo"></i>
                        <span>Retours gratuits sous 30 jours</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>Paiement sécurisé</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
@if(count($relatedProducts) > 0)
<section class="section related-section">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Vous aimerez aussi</span>
            <h2 class="section-title">Produits Similaires</h2>
        </div>
        <div class="products-grid related-grid">
            @foreach($relatedProducts as $related)
            <article class="product-card">
                <div class="product-image">
                    <img src="{{ $related->image_url }}" alt="{{ $related->name }}">
                    <div class="product-overlay"></div>
                    @if($related->new)
                    <span class="product-badge badge-new">Nouveau</span>
                    @elseif($related->sale)
                    <span class="product-badge badge-sale">Promo</span>
                    @endif
                    <div class="product-actions">
                        <a href="{{ route('produits.show', $related->id) }}" class="action-btn" title="Voir détails"><i class="fas fa-eye"></i></a>
                        <form action="{{ route('cart.add', $related->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="action-btn" title="Ajouter au panier"><i class="fas fa-shopping-bag"></i></button>
                        </form>
                        <button class="action-btn" title="Favoris"><i class="fas fa-heart"></i></button>
                    </div>
                </div>
                <div class="product-info">
                    <span class="product-category">{{ ucfirst($related->categorie) }}</span>
                    <h3 class="product-name">
                        <a href="{{ route('produits.show', $related->id) }}">{{ $related->name }}</a>
                    </h3>
                    <div class="product-price">
                        <span class="price-current">{{ number_format($related->price, 2) }}€</span>
                        @if($related->old_price)
                        <span class="price-old">{{ number_format($related->old_price, 2) }}€</span>
                        @endif
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

@section('styles')
<style>
/* ===== PRODUCT DETAIL ===== */
.page-header-small {
    padding: 100px 0 30px;
    min-height: auto;
}

.product-detail-section {
    padding-top: 30px;
}

.product-detail-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: start;
}

/* ===== GALLERY ===== */
.product-gallery {
    position: sticky;
    top: 120px;
}

.main-image {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    background: var(--light);
    margin-bottom: 20px;
}

.main-image img {
    width: 100%;
    height: 550px;
    object-fit: cover;
}

.main-image .product-badge {
    position: absolute;
    top: 20px;
    left: 20px;
}

.thumbnail-images {
    display: flex;
    gap: 15px;
}

.thumbnail {
    width: 100px;
    height: 100px;
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
    border: 3px solid transparent;
    transition: var(--transition);
}

.thumbnail.active,
.thumbnail:hover {
    border-color: var(--accent);
}

.thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* ===== PRODUCT INFO ===== */
.product-category-tag {
    display: inline-block;
    background: var(--light);
    padding: 8px 20px;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--accent);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 15px;
}

.product-title {
    font-family: 'Playfair Display', serif;
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 20px;
    line-height: 1.2;
}

.product-rating-detail {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 25px;
}

.product-rating-detail .stars {
    color: #ffc107;
}

.rating-text {
    font-weight: 700;
    color: var(--dark);
}

.reviews-count {
    color: var(--gray);
}

.product-price-detail {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 25px;
}

.current-price {
    font-family: 'Playfair Display', serif;
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--accent);
}

.old-price {
    font-size: 1.3rem;
    color: var(--gray);
    text-decoration: line-through;
}

.discount-badge {
    background: var(--accent);
    color: var(--white);
    padding: 5px 12px;
    border-radius: 5px;
    font-size: 0.85rem;
    font-weight: 600;
}

.product-description {
    color: var(--gray);
    line-height: 1.8;
    margin-bottom: 30px;
}

.product-features {
    margin-bottom: 30px;
    padding: 25px;
    background: var(--light);
    border-radius: 15px;
}

.product-features h3 {
    font-size: 1rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 15px;
}

.product-features ul {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

.product-features li {
    display: flex;
    align-items: center;
    gap: 10px;
    color: var(--gray);
}

.product-features li i {
    color: var(--accent);
}

/* ===== OPTIONS ===== */
.product-options {
    display: flex;
    gap: 30px;
    margin-bottom: 25px;
}

.option-group label {
    display: block;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 12px;
}

.size-buttons {
    display: flex;
    gap: 10px;
}

.size-buttons .size-btn {
    width: 50px;
    height: 50px;
    border: 2px solid var(--gray-light);
    background: var(--white);
    border-radius: 12px;
    font-weight: 600;
    color: var(--gray);
    cursor: pointer;
    transition: var(--transition);
}

.size-buttons .size-btn:hover,
.size-buttons .size-btn.active {
    border-color: var(--accent);
    color: var(--accent);
    background: rgba(233, 69, 96, 0.1);
}

.quantity-selector {
    display: flex;
    align-items: center;
    border: 2px solid var(--gray-light);
    border-radius: 12px;
    overflow: hidden;
}

.qty-btn {
    width: 50px;
    height: 50px;
    border: none;
    background: var(--light);
    font-size: 1.2rem;
    cursor: pointer;
    transition: var(--transition);
}

.qty-btn:hover {
    background: var(--accent);
    color: var(--white);
}

.quantity-selector input {
    width: 60px;
    height: 50px;
    border: none;
    text-align: center;
    font-family: 'Raleway', sans-serif;
    font-size: 1rem;
    font-weight: 600;
}

.stock-info {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #28a745;
    font-weight: 500;
    margin-bottom: 25px;
}

/* ===== ACTIONS ===== */
.product-actions-detail {
    display: flex;
    gap: 15px;
    margin-bottom: 30px;
}

.btn-lg {
    padding: 18px 40px;
    font-size: 1rem;
}

.btn-lg i {
    margin-right: 10px;
}

.wishlist-btn {
    padding: 18px 22px;
}

.wishlist-btn i {
    margin: 0;
    font-size: 1.2rem;
}

/* ===== META ===== */
.product-meta {
    padding-top: 25px;
    border-top: 2px solid var(--light);
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 0;
    color: var(--gray);
}

.meta-item i {
    width: 20px;
    color: var(--accent);
}

/* ===== RELATED ===== */
.related-section {
    background: var(--light);
}

.related-grid {
    grid-template-columns: repeat(4, 1fr);
}

/* ===== RESPONSIVE ===== */
@media (max-width: 992px) {
    .product-detail-grid {
        grid-template-columns: 1fr;
        gap: 40px;
    }

    .product-gallery {
        position: static;
    }

    .main-image img {
        height: 450px;
    }

    .related-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 576px) {
    .product-title {
        font-size: 1.8rem;
    }

    .product-options {
        flex-direction: column;
        gap: 20px;
    }

    .product-features ul {
        grid-template-columns: 1fr;
    }

    .product-actions-detail {
        flex-direction: column;
    }

    .btn-lg {
        width: 100%;
        text-align: center;
    }

    .wishlist-btn {
        width: 100%;
    }

    .related-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection

@section('scripts')
<script>
function changeImage(thumbnail) {
    const thumbnails = document.querySelectorAll('.thumbnail');
    thumbnails.forEach(t => t.classList.remove('active'));
    thumbnail.classList.add('active');
    
    const newSrc = thumbnail.querySelector('img').src;
    document.getElementById('mainImage').src = newSrc;
}

function decreaseQty() {
    const input = document.getElementById('quantity');
    if (input.value > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

function increaseQty() {
    const input = document.getElementById('quantity');
    input.value = parseInt(input.value) + 1;
}
</script>
@endsection
