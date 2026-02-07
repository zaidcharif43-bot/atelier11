@extends('layouts.app')

@section('title', $product['name'] . ' - ZC 4u Fashion')

@section('content')
<!-- Breadcrumb -->
<section class="product-breadcrumb">
    <div class="container">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Accueil</a>
            <span>/</span>
            <a href="{{ route('produits.index') }}">Collections</a>
            <span>/</span>
            <a href="{{ route('produits.category', $product['category']) }}">{{ ucfirst($product['category']) }}</a>
            <span>/</span>
            <span>{{ $product['name'] }}</span>
        </nav>
    </div>
</section>

<!-- Product Detail -->
<section class="product-detail">
    <div class="container">
        <div class="product-layout">
            <!-- Product Gallery -->
            <div class="product-gallery">
                <div class="gallery-main">
                    <div class="gallery-badges">
                        @if($product['new'])
                        <span class="product-badge badge-new">Nouveau</span>
                        @endif
                        @if($product['sale'])
                        <span class="product-badge badge-sale">-{{ round((($product['old_price'] - $product['price']) / $product['old_price']) * 100) }}%</span>
                        @endif
                    </div>
                    <button class="gallery-zoom" title="Zoom">
                        <i class="fas fa-search-plus"></i>
                    </button>
                    <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" id="mainImage" class="main-image">
                </div>
                <div class="gallery-thumbs">
                    <button class="thumb-item active">
                        <img src="{{ $product['image'] }}" alt="Vue 1">
                    </button>
                    <button class="thumb-item">
                        <img src="https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=400&q=80" alt="Vue 2">
                    </button>
                    <button class="thumb-item">
                        <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=400&q=80" alt="Vue 3">
                    </button>
                    <button class="thumb-item">
                        <img src="https://images.unsplash.com/photo-1479064555552-3ef4979f8908?w=400&q=80" alt="Vue 4">
                    </button>
                </div>
            </div>

            <!-- Product Info -->
            <div class="product-info-detail">
                <div class="product-meta">
                    <span class="product-category-tag">{{ ucfirst($product['category']) }}</span>
                    <div class="product-rating">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($product['rating']))
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                        <span>({{ $product['reviews'] }} avis)</span>
                    </div>
                </div>

                <h1 class="product-title">{{ $product['name'] }}</h1>

                <div class="product-pricing">
                    <span class="price-current">{{ number_format($product['price'], 2) }}€</span>
                    @if($product['old_price'])
                    <span class="price-old">{{ number_format($product['old_price'], 2) }}€</span>
                    <span class="price-save">Économisez {{ number_format($product['old_price'] - $product['price'], 2) }}€</span>
                    @endif
                </div>

                <p class="product-description">
                    {{ $product['description'] ?? 'Découvrez ce produit exceptionnel de notre collection exclusive. Fabriqué avec les meilleurs matériaux et une attention particulière aux détails, ce vêtement allie élégance et confort pour un style intemporel.' }}
                </p>

                <!-- Taille -->
                <div class="option-group">
                    <div class="option-header">
                        <span class="option-label">Taille</span>
                        <a href="#" class="size-guide">Guide des tailles</a>
                    </div>
                    <div class="size-options">
                        <button class="size-btn" data-size="XS">XS</button>
                        <button class="size-btn" data-size="S">S</button>
                        <button class="size-btn active" data-size="M">M</button>
                        <button class="size-btn" data-size="L">L</button>
                        <button class="size-btn" data-size="XL">XL</button>
                    </div>
                </div>

                <!-- Couleur -->
                <div class="option-group">
                    <span class="option-label">Couleur: <strong id="selectedColor">Noir</strong></span>
                    <div class="color-options">
                        <button class="color-btn active" data-color="Noir" style="background: #0a0a0a;"></button>
                        <button class="color-btn" data-color="Blanc" style="background: #f9f7f4;"></button>
                        <button class="color-btn" data-color="Beige" style="background: #d4b87a;"></button>
                        <button class="color-btn" data-color="Gris" style="background: #888888;"></button>
                    </div>
                </div>

                <!-- Quantité et Panier -->
                <div class="product-actions">
                    <div class="quantity-selector">
                        <button class="qty-btn minus"><i class="fas fa-minus"></i></button>
                        <input type="number" value="1" min="1" max="{{ $product['stock'] }}" class="qty-input" id="quantity">
                        <button class="qty-btn plus"><i class="fas fa-plus"></i></button>
                    </div>
                    <button class="btn-add-cart">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Ajouter au panier</span>
                    </button>
                    <button class="btn-wishlist" title="Ajouter aux favoris">
                        <i class="far fa-heart"></i>
                    </button>
                </div>

                <!-- Stock Status -->
                <div class="stock-info">
                    @if($product['stock'] > 10)
                    <span class="stock-status in-stock"><i class="fas fa-check-circle"></i> En stock</span>
                    @elseif($product['stock'] > 0)
                    <span class="stock-status low-stock"><i class="fas fa-exclamation-circle"></i> Plus que {{ $product['stock'] }} en stock</span>
                    @else
                    <span class="stock-status out-stock"><i class="fas fa-times-circle"></i> Rupture de stock</span>
                    @endif
                    <span class="delivery-info"><i class="fas fa-truck"></i> Livraison gratuite dès 50€</span>
                </div>

                <!-- Product Features -->
                <div class="product-features">
                    <div class="feature-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>Garantie 2 ans</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-undo"></i>
                        <span>Retour gratuit 30j</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-lock"></i>
                        <span>Paiement sécurisé</span>
                    </div>
                </div>

                <!-- Accordion -->
                <div class="product-accordion">
                    <div class="accordion-item">
                        <button class="accordion-header">
                            <span>Description</span>
                            <i class="fas fa-plus"></i>
                        </button>
                        <div class="accordion-content">
                            <p>Ce produit est confectionné avec les meilleurs matériaux pour vous offrir un confort optimal et un style intemporel. Sa coupe soignée s'adapte à toutes les morphologies.</p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button class="accordion-header">
                            <span>Composition & Entretien</span>
                            <i class="fas fa-plus"></i>
                        </button>
                        <div class="accordion-content">
                            <p>100% Coton biologique. Lavage à 30°C. Repassage à température moyenne. Ne pas utiliser de sèche-linge.</p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button class="accordion-header">
                            <span>Livraison & Retours</span>
                            <i class="fas fa-plus"></i>
                        </button>
                        <div class="accordion-content">
                            <p>Livraison standard gratuite dès 50€. Livraison express disponible. Retours gratuits sous 30 jours.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
<section class="related-products">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Vous aimerez aussi</h2>
            <a href="{{ route('produits.index') }}" class="section-link">
                <span>Voir plus</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="products-slider">
            @foreach($relatedProducts as $related)
            <div class="product-card animate-on-scroll">
                <div class="product-image-wrapper">
                    <img src="{{ $related['image'] }}" alt="{{ $related['name'] }}" class="product-image">
                    <div class="product-overlay"></div>
                    
                    <div class="product-badges">
                        @if($related['new'])
                        <span class="product-badge badge-new">Nouveau</span>
                        @endif
                        @if($related['sale'])
                        <span class="product-badge badge-sale">Promo</span>
                        @endif
                    </div>

                    <div class="product-quick-actions">
                        <button class="quick-action-btn" title="Aperçu rapide">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="quick-action-btn" title="Ajouter au panier">
                            <i class="fas fa-shopping-bag"></i>
                        </button>
                        <button class="quick-action-btn" title="Favoris">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                </div>

                <div class="product-info">
                    <span class="product-category">{{ ucfirst($related['category']) }}</span>
                    <h3 class="product-name">
                        <a href="{{ route('produits.show', $related['id']) }}">{{ $related['name'] }}</a>
                    </h3>
                    <div class="product-price">
                        <span class="price-current">{{ number_format($related['price'], 2) }}€</span>
                        @if($related['old_price'])
                        <span class="price-old">{{ number_format($related['old_price'], 2) }}€</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
/* ===== BREADCRUMB ===== */
.product-breadcrumb {
    padding: 1.5rem 0;
    background: var(--blanc-casse);
    border-bottom: 1px solid var(--gris-light);
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    flex-wrap: wrap;
}

.breadcrumb a {
    color: var(--gris);
    text-decoration: none;
    font-size: 0.85rem;
    transition: color 0.3s ease;
}

.breadcrumb a:hover {
    color: var(--or);
}

.breadcrumb span {
    color: var(--gris);
    font-size: 0.85rem;
}

.breadcrumb span:last-child {
    color: var(--noir);
}

/* ===== PRODUCT DETAIL ===== */
.product-detail {
    padding: 4rem 0;
    background: var(--blanc);
}

.product-layout {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
}

/* ===== GALLERY ===== */
.product-gallery {
    position: sticky;
    top: 120px;
}

.gallery-main {
    position: relative;
    background: var(--blanc-casse);
    margin-bottom: 1rem;
    overflow: hidden;
}

.gallery-badges {
    position: absolute;
    top: 1.5rem;
    left: 1.5rem;
    z-index: 2;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.gallery-zoom {
    position: absolute;
    top: 1.5rem;
    right: 1.5rem;
    z-index: 2;
    width: 40px;
    height: 40px;
    background: var(--blanc);
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    color: var(--noir);
    transition: all 0.3s ease;
}

.gallery-zoom:hover {
    background: var(--noir);
    color: var(--blanc);
}

.main-image {
    width: 100%;
    height: auto;
    display: block;
    transition: transform 0.5s ease;
}

.gallery-main:hover .main-image {
    transform: scale(1.05);
}

.gallery-thumbs {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
}

.thumb-item {
    border: 2px solid transparent;
    background: var(--blanc-casse);
    cursor: pointer;
    padding: 0;
    overflow: hidden;
    transition: border-color 0.3s ease;
}

.thumb-item:hover,
.thumb-item.active {
    border-color: var(--noir);
}

.thumb-item img {
    width: 100%;
    height: 100px;
    object-fit: cover;
    display: block;
}

/* ===== PRODUCT INFO ===== */
.product-info-detail {
    padding-top: 1rem;
}

.product-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
}

.product-category-tag {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: var(--or);
}

.product-rating {
    display: flex;
    align-items: center;
    gap: 0.3rem;
    color: var(--or);
    font-size: 0.85rem;
}

.product-rating span {
    color: var(--gris);
    margin-left: 0.3rem;
}

.product-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2.8rem;
    font-weight: 400;
    color: var(--noir);
    line-height: 1.2;
    margin-bottom: 1.5rem;
}

.product-pricing {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}

.product-pricing .price-current {
    font-size: 2rem;
    font-weight: 600;
    color: var(--noir);
}

.product-pricing .price-old {
    font-size: 1.2rem;
    color: var(--gris);
    text-decoration: line-through;
}

.price-save {
    background: var(--or);
    color: var(--noir);
    padding: 0.3rem 0.8rem;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.product-description {
    color: var(--gris);
    line-height: 1.8;
    margin-bottom: 2rem;
}

/* Option Groups */
.option-group {
    margin-bottom: 1.5rem;
}

.option-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.8rem;
}

.option-label {
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--noir);
}

.size-guide {
    font-size: 0.8rem;
    color: var(--gris);
    text-decoration: underline;
}

.size-guide:hover {
    color: var(--or);
}

.size-options {
    display: flex;
    gap: 0.8rem;
    flex-wrap: wrap;
}

.size-btn {
    min-width: 48px;
    height: 48px;
    border: 1px solid var(--gris-light);
    background: var(--blanc);
    font-family: 'Montserrat', sans-serif;
    font-size: 0.85rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.size-btn:hover {
    border-color: var(--noir);
}

.size-btn.active {
    background: var(--noir);
    color: var(--blanc);
    border-color: var(--noir);
}

.color-options {
    display: flex;
    gap: 0.8rem;
}

.color-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: 2px solid var(--gris-light);
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
}

.color-btn:hover,
.color-btn.active {
    border-color: var(--noir);
}

.color-btn.active::after {
    content: '';
    position: absolute;
    top: -5px;
    left: -5px;
    right: -5px;
    bottom: -5px;
    border: 1px solid var(--noir);
    border-radius: 50%;
}

/* Product Actions */
.product-actions {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}

.quantity-selector {
    display: flex;
    border: 1px solid var(--gris-light);
}

.qty-btn {
    width: 48px;
    height: 48px;
    background: var(--blanc);
    border: none;
    cursor: pointer;
    font-size: 0.9rem;
    color: var(--noir);
    transition: all 0.3s ease;
}

.qty-btn:hover {
    background: var(--noir);
    color: var(--blanc);
}

.qty-input {
    width: 60px;
    height: 48px;
    border: none;
    border-left: 1px solid var(--gris-light);
    border-right: 1px solid var(--gris-light);
    text-align: center;
    font-family: 'Montserrat', sans-serif;
    font-size: 1rem;
    -moz-appearance: textfield;
}

.qty-input::-webkit-outer-spin-button,
.qty-input::-webkit-inner-spin-button {
    -webkit-appearance: none;
}

.btn-add-cart {
    flex: 1;
    min-width: 200px;
    height: 48px;
    background: var(--noir);
    color: var(--blanc);
    border: none;
    font-family: 'Montserrat', sans-serif;
    font-size: 0.85rem;
    font-weight: 600;
    letter-spacing: 1px;
    text-transform: uppercase;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.8rem;
    transition: all 0.3s ease;
}

.btn-add-cart:hover {
    background: var(--or);
    color: var(--noir);
}

.btn-wishlist {
    width: 48px;
    height: 48px;
    border: 1px solid var(--gris-light);
    background: var(--blanc);
    cursor: pointer;
    font-size: 1.2rem;
    color: var(--noir);
    transition: all 0.3s ease;
}

.btn-wishlist:hover {
    border-color: var(--noir);
    color: #e74c3c;
}

/* Stock Info */
.stock-info {
    display: flex;
    align-items: center;
    gap: 2rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.stock-status {
    font-size: 0.85rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.stock-status.in-stock {
    color: #4caf50;
}

.stock-status.low-stock {
    color: #ff9800;
}

.stock-status.out-stock {
    color: #f44336;
}

.delivery-info {
    font-size: 0.85rem;
    color: var(--gris);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Product Features */
.product-features {
    display: flex;
    gap: 2rem;
    padding: 1.5rem 0;
    border-top: 1px solid var(--gris-light);
    border-bottom: 1px solid var(--gris-light);
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    font-size: 0.85rem;
    color: var(--gris);
}

.feature-item i {
    color: var(--or);
}

/* Accordion */
.product-accordion {
    border-top: 1px solid var(--gris-light);
}

.accordion-item {
    border-bottom: 1px solid var(--gris-light);
}

.accordion-header {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.2rem 0;
    background: none;
    border: none;
    font-family: 'Montserrat', sans-serif;
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--noir);
    cursor: pointer;
}

.accordion-header i {
    font-size: 0.8rem;
    transition: transform 0.3s ease;
}

.accordion-item.active .accordion-header i {
    transform: rotate(45deg);
}

.accordion-content {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
}

.accordion-item.active .accordion-content {
    max-height: 200px;
}

.accordion-content p {
    padding-bottom: 1.2rem;
    color: var(--gris);
    line-height: 1.8;
}

/* ===== RELATED PRODUCTS ===== */
.related-products {
    padding: 5rem 0;
    background: var(--blanc-casse);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 3rem;
}

.section-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2.5rem;
    font-weight: 400;
    color: var(--noir);
    letter-spacing: 2px;
}

.section-link {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    color: var(--noir);
    font-size: 0.85rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: color 0.3s ease;
}

.section-link:hover {
    color: var(--or);
}

.products-slider {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 2rem;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 1200px) {
    .products-slider {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 992px) {
    .product-layout {
        grid-template-columns: 1fr;
        gap: 3rem;
    }

    .product-gallery {
        position: static;
    }

    .product-title {
        font-size: 2.2rem;
    }

    .products-slider {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .product-pricing .price-current {
        font-size: 1.6rem;
    }

    .product-actions {
        flex-direction: column;
    }

    .quantity-selector {
        width: 100%;
        justify-content: center;
    }

    .btn-add-cart {
        width: 100%;
    }

    .btn-wishlist {
        width: 100%;
    }

    .product-features {
        flex-direction: column;
        gap: 1rem;
    }

    .stock-info {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.8rem;
    }

    .section-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .products-slider {
        grid-template-columns: 1fr;
    }

    .gallery-thumbs {
        grid-template-columns: repeat(4, 1fr);
    }

    .thumb-item img {
        height: 80px;
    }
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gallery Thumbnails
    const thumbs = document.querySelectorAll('.thumb-item');
    const mainImage = document.getElementById('mainImage');

    thumbs.forEach(thumb => {
        thumb.addEventListener('click', function() {
            thumbs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            mainImage.src = this.querySelector('img').src;
        });
    });

    // Size Selection
    const sizeBtns = document.querySelectorAll('.size-btn');
    sizeBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            sizeBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Color Selection
    const colorBtns = document.querySelectorAll('.color-btn');
    const selectedColorText = document.getElementById('selectedColor');
    
    colorBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            colorBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            selectedColorText.textContent = this.dataset.color;
        });
    });

    // Quantity Selector
    const qtyInput = document.getElementById('quantity');
    const minusBtn = document.querySelector('.qty-btn.minus');
    const plusBtn = document.querySelector('.qty-btn.plus');

    minusBtn.addEventListener('click', () => {
        if (qtyInput.value > 1) {
            qtyInput.value = parseInt(qtyInput.value) - 1;
        }
    });

    plusBtn.addEventListener('click', () => {
        if (qtyInput.value < parseInt(qtyInput.max)) {
            qtyInput.value = parseInt(qtyInput.value) + 1;
        }
    });

    // Accordion
    const accordionHeaders = document.querySelectorAll('.accordion-header');
    accordionHeaders.forEach(header => {
        header.addEventListener('click', function() {
            const item = this.parentElement;
            item.classList.toggle('active');
        });
    });

    // Add to Cart Animation
    const addCartBtn = document.querySelector('.btn-add-cart');
    addCartBtn.addEventListener('click', function() {
        this.innerHTML = '<i class="fas fa-check"></i><span>Ajouté!</span>';
        this.style.background = '#4caf50';
        
        setTimeout(() => {
            this.innerHTML = '<i class="fas fa-shopping-bag"></i><span>Ajouter au panier</span>';
            this.style.background = '';
        }, 2000);
    });

    // Wishlist Toggle
    const wishlistBtn = document.querySelector('.btn-wishlist');
    wishlistBtn.addEventListener('click', function() {
        const icon = this.querySelector('i');
        icon.classList.toggle('far');
        icon.classList.toggle('fas');
        this.style.color = icon.classList.contains('fas') ? '#e74c3c' : '';
    });
});
</script>
@endsection
