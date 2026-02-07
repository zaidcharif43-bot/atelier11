@extends('layouts.app')

@section('title', $category['name'] . ' - ZC 4u Fashion')

@section('content')
<!-- Category Header -->
<section class="category-header">
    <div class="category-header-bg">
        <img src="{{ $category['image'] }}" alt="{{ $category['name'] }}">
    </div>
    <div class="category-header-overlay"></div>
    <div class="category-header-content">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Accueil</a>
            <span>/</span>
            <a href="{{ route('produits.index') }}">Collections</a>
            <span>/</span>
            <span>{{ $category['name'] }}</span>
        </nav>
        <h1 class="category-title">{{ $category['name'] }}</h1>
        <p class="category-description">{{ $category['description'] ?? 'Découvrez notre sélection exclusive' }}</p>
    </div>
</section>

<!-- Products Section -->
<section class="products-section">
    <div class="container">
        <div class="shop-layout">
            <!-- Sidebar Filters -->
            <aside class="filters-sidebar" id="filtersSidebar">
                <div class="filters-header">
                    <h3>Filtres</h3>
                    <button class="filters-close" id="filtersClose">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- Categories Filter -->
                <div class="filter-group">
                    <h4 class="filter-title">
                        <span>Catégories</span>
                        <i class="fas fa-chevron-down"></i>
                    </h4>
                    <div class="filter-content">
                        <a href="{{ route('produits.index') }}" class="filter-option">
                            <span class="filter-check"><i class="fas fa-check"></i></span>
                            <span>Toutes les collections</span>
                        </a>
                        @foreach($allCategories as $slug => $cat)
                        <a href="{{ route('produits.category', $slug) }}" class="filter-option {{ $slug === $currentCategory ? 'active' : '' }}">
                            <span class="filter-check"><i class="fas fa-check"></i></span>
                            <span>{{ $cat['name'] }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- Price Filter -->
                <div class="filter-group">
                    <h4 class="filter-title">
                        <span>Prix</span>
                        <i class="fas fa-chevron-down"></i>
                    </h4>
                    <div class="filter-content">
                        <div class="price-range">
                            <div class="price-inputs">
                                <input type="number" placeholder="Min" class="price-input" id="priceMin">
                                <span>—</span>
                                <input type="number" placeholder="Max" class="price-input" id="priceMax">
                            </div>
                            <div class="price-slider">
                                <div class="slider-track">
                                    <div class="slider-range"></div>
                                </div>
                                <input type="range" min="0" max="200" value="0" class="slider-thumb" id="sliderMin">
                                <input type="range" min="0" max="200" value="200" class="slider-thumb" id="sliderMax">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rating Filter -->
                <div class="filter-group">
                    <h4 class="filter-title">
                        <span>Évaluation</span>
                        <i class="fas fa-chevron-down"></i>
                    </h4>
                    <div class="filter-content">
                        @for($rating = 5; $rating >= 3; $rating--)
                        <label class="filter-checkbox">
                            <input type="checkbox" name="rating" value="{{ $rating }}">
                            <span class="checkbox-custom"></span>
                            <span class="rating-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $rating ? 'active' : '' }}"></i>
                                @endfor
                            </span>
                            <span>et plus</span>
                        </label>
                        @endfor
                    </div>
                </div>

                <!-- Apply Button -->
                <button class="btn-3d btn-primary apply-filters">
                    <span>Appliquer les filtres</span>
                </button>
            </aside>

            <!-- Products Grid -->
            <div class="products-content">
                <!-- Toolbar -->
                <div class="products-toolbar">
                    <button class="filter-toggle" id="filterToggle">
                        <i class="fas fa-sliders-h"></i>
                        <span>Filtres</span>
                    </button>

                    <div class="toolbar-info">
                        <span>{{ count($products) }} produits</span>
                    </div>

                    <div class="toolbar-right">
                        <div class="sort-dropdown">
                            <span class="sort-label">Trier par:</span>
                            <select class="sort-select" id="sortSelect">
                                <option value="popular">Popularité</option>
                                <option value="newest">Nouveautés</option>
                                <option value="price-low">Prix croissant</option>
                                <option value="price-high">Prix décroissant</option>
                                <option value="rating">Meilleures notes</option>
                            </select>
                        </div>

                        <div class="view-options">
                            <button class="view-btn active" data-view="grid">
                                <i class="fas fa-th"></i>
                            </button>
                            <button class="view-btn" data-view="list">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="products-grid" id="productsGrid">
                    @forelse($products as $index => $product)
                    <div class="product-card animate-on-scroll" data-category="{{ $product['category'] }}" data-price="{{ $product['price'] }}" data-rating="{{ $product['rating'] }}">
                        <div class="product-image-wrapper">
                            <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="product-image">
                            <div class="product-overlay"></div>
                            
                            <div class="product-badges">
                                @if($product['new'])
                                <span class="product-badge badge-new">Nouveau</span>
                                @endif
                                @if($product['sale'])
                                <span class="product-badge badge-sale">-{{ round((($product['old_price'] - $product['price']) / $product['old_price']) * 100) }}%</span>
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
                    <!-- Empty State -->
                    <div class="empty-state" style="grid-column: 1 / -1;">
                        <div class="empty-icon">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <h3>Aucun produit trouvé</h3>
                        <p>Cette catégorie ne contient aucun produit pour le moment.</p>
                        <a href="{{ route('produits.index') }}" class="btn-3d btn-outline">
                            <span>Voir tous les produits</span>
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Categories -->
<section class="related-categories">
    <div class="container">
        <h2 class="section-title">Autres Catégories</h2>
        <div class="categories-slider">
            @foreach($allCategories as $slug => $cat)
                @if($slug !== $currentCategory)
                <a href="{{ route('produits.category', $slug) }}" class="category-slide">
                    <div class="category-slide-image">
                        <img src="{{ $cat['image'] }}" alt="{{ $cat['name'] }}">
                        <div class="category-slide-overlay"></div>
                    </div>
                    <h3>{{ $cat['name'] }}</h3>
                </a>
                @endif
            @endforeach
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
/* ===== CATEGORY HEADER ===== */
.category-header {
    position: relative;
    height: 60vh;
    min-height: 450px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.category-header-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.category-header-bg img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transform: scale(1.1);
    animation: slowZoom 15s ease-in-out infinite alternate;
}

@keyframes slowZoom {
    0% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

.category-header-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to bottom, rgba(10,10,10,0.5), rgba(10,10,10,0.8));
}

.category-header-content {
    position: relative;
    z-index: 1;
    text-align: center;
    max-width: 800px;
    padding: 0 2rem;
}

.breadcrumb {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.8rem;
    margin-bottom: 1.5rem;
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
    color: var(--blanc);
}

.category-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 4.5rem;
    font-weight: 300;
    color: var(--blanc);
    letter-spacing: 8px;
    margin-bottom: 1rem;
    text-transform: uppercase;
}

.category-description {
    color: var(--gris);
    font-size: 1.1rem;
    letter-spacing: 1px;
    line-height: 1.8;
}

/* ===== PRODUCTS SECTION ===== */
.products-section {
    padding: 5rem 0;
    background: var(--blanc-casse);
}

.shop-layout {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 3rem;
}

/* ===== FILTERS SIDEBAR ===== */
.filters-sidebar {
    background: var(--blanc);
    padding: 2rem;
    height: fit-content;
    position: sticky;
    top: 120px;
    border: 1px solid var(--gris-light);
}

.filters-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid var(--gris-light);
}

.filters-header h3 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.5rem;
    font-weight: 500;
    color: var(--noir);
}

.filters-close {
    display: none;
    background: none;
    border: none;
    font-size: 1.2rem;
    cursor: pointer;
    color: var(--noir);
}

.filter-group {
    margin-bottom: 2rem;
}

.filter-title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--noir);
    margin-bottom: 1.2rem;
    cursor: pointer;
}

.filter-title i {
    font-size: 0.7rem;
    transition: transform 0.3s ease;
}

.filter-content {
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
}

.filter-option {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    text-decoration: none;
    color: var(--noir);
    padding: 0.6rem;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.filter-option:hover {
    background: var(--blanc-casse);
}

.filter-option.active {
    background: var(--noir);
    color: var(--blanc);
}

.filter-check {
    width: 18px;
    height: 18px;
    border: 1px solid var(--gris-light);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.6rem;
    transition: all 0.3s ease;
}

.filter-option.active .filter-check {
    background: var(--or);
    border-color: var(--or);
    color: var(--noir);
}

/* Price Range */
.price-range {
    padding: 1rem 0;
}

.price-inputs {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.price-input {
    width: 100%;
    padding: 0.8rem;
    border: 1px solid var(--gris-light);
    font-family: 'Montserrat', sans-serif;
    font-size: 0.85rem;
    text-align: center;
}

.price-input:focus {
    outline: none;
    border-color: var(--or);
}

.price-slider {
    position: relative;
    height: 30px;
}

.slider-track {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 100%;
    height: 4px;
    background: var(--gris-light);
    border-radius: 2px;
}

.slider-range {
    position: absolute;
    height: 100%;
    background: var(--or);
    left: 0%;
    right: 0%;
}

.slider-thumb {
    position: absolute;
    width: 100%;
    pointer-events: none;
    -webkit-appearance: none;
    background: transparent;
    top: 50%;
    transform: translateY(-50%);
}

.slider-thumb::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 18px;
    height: 18px;
    background: var(--noir);
    border-radius: 50%;
    cursor: pointer;
    pointer-events: auto;
    border: 2px solid var(--blanc);
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}

/* Filter Checkbox */
.filter-checkbox {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    cursor: pointer;
    font-size: 0.9rem;
    color: var(--noir);
}

.filter-checkbox input {
    display: none;
}

.checkbox-custom {
    width: 18px;
    height: 18px;
    border: 1px solid var(--gris-light);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.checkbox-custom::after {
    content: '';
    width: 8px;
    height: 8px;
    background: var(--or);
    transform: scale(0);
    transition: transform 0.2s ease;
}

.filter-checkbox input:checked + .checkbox-custom {
    border-color: var(--or);
}

.filter-checkbox input:checked + .checkbox-custom::after {
    transform: scale(1);
}

.rating-stars i {
    color: var(--gris-light);
    font-size: 0.8rem;
}

.rating-stars i.active {
    color: var(--or);
}

.apply-filters {
    width: 100%;
    margin-top: 1rem;
}

/* ===== PRODUCTS CONTENT ===== */
.products-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid var(--gris-light);
}

.filter-toggle {
    display: none;
    align-items: center;
    gap: 0.5rem;
    background: var(--noir);
    color: var(--blanc);
    border: none;
    padding: 0.8rem 1.5rem;
    font-family: 'Montserrat', sans-serif;
    font-size: 0.8rem;
    font-weight: 500;
    letter-spacing: 1px;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.3s ease;
}

.filter-toggle:hover {
    background: var(--or);
    color: var(--noir);
}

.toolbar-info {
    color: var(--gris);
    font-size: 0.9rem;
}

.toolbar-right {
    display: flex;
    align-items: center;
    gap: 2rem;
}

.sort-dropdown {
    display: flex;
    align-items: center;
    gap: 0.8rem;
}

.sort-label {
    font-size: 0.85rem;
    color: var(--gris);
}

.sort-select {
    padding: 0.8rem 2.5rem 0.8rem 1rem;
    border: 1px solid var(--gris-light);
    font-family: 'Montserrat', sans-serif;
    font-size: 0.85rem;
    background: var(--blanc);
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23888'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.8rem center;
    background-size: 18px;
}

.sort-select:focus {
    outline: none;
    border-color: var(--or);
}

.view-options {
    display: flex;
    border: 1px solid var(--gris-light);
}

.view-btn {
    padding: 0.8rem 1rem;
    background: var(--blanc);
    border: none;
    cursor: pointer;
    color: var(--gris);
    transition: all 0.3s ease;
}

.view-btn:first-child {
    border-right: 1px solid var(--gris-light);
}

.view-btn.active,
.view-btn:hover {
    background: var(--noir);
    color: var(--blanc);
}

/* ===== PRODUCTS GRID ===== */
.products-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
}

/* ===== RELATED CATEGORIES ===== */
.related-categories {
    padding: 5rem 0;
    background: var(--noir);
}

.related-categories .section-title {
    text-align: center;
    font-family: 'Cormorant Garamond', serif;
    font-size: 2.5rem;
    font-weight: 300;
    color: var(--blanc);
    letter-spacing: 3px;
    margin-bottom: 3rem;
}

.categories-slider {
    display: flex;
    gap: 2rem;
    overflow-x: auto;
    padding-bottom: 1rem;
    scroll-snap-type: x mandatory;
}

.categories-slider::-webkit-scrollbar {
    height: 4px;
}

.categories-slider::-webkit-scrollbar-track {
    background: var(--noir-light);
}

.categories-slider::-webkit-scrollbar-thumb {
    background: var(--or);
}

.category-slide {
    flex: 0 0 280px;
    text-decoration: none;
    scroll-snap-align: start;
}

.category-slide-image {
    position: relative;
    height: 350px;
    overflow: hidden;
    margin-bottom: 1rem;
}

.category-slide-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.category-slide:hover img {
    transform: scale(1.05);
}

.category-slide-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to top, rgba(10,10,10,0.6), transparent);
}

.category-slide h3 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.3rem;
    font-weight: 400;
    color: var(--blanc);
    text-align: center;
    letter-spacing: 2px;
}

/* ===== EMPTY STATE ===== */
.empty-state {
    text-align: center;
    padding: 5rem 2rem;
}

.empty-icon {
    width: 100px;
    height: 100px;
    margin: 0 auto 2rem;
    border: 2px solid var(--gris-light);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: var(--gris);
}

.empty-state h3 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.8rem;
    margin-bottom: 0.5rem;
    color: var(--noir);
}

.empty-state p {
    color: var(--gris);
    margin-bottom: 2rem;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 1200px) {
    .products-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 992px) {
    .shop-layout {
        grid-template-columns: 1fr;
    }

    .filters-sidebar {
        position: fixed;
        top: 0;
        left: -100%;
        width: 320px;
        height: 100vh;
        z-index: 2000;
        overflow-y: auto;
        transition: left 0.4s ease;
    }

    .filters-sidebar.active {
        left: 0;
    }

    .filters-close {
        display: block;
    }

    .filter-toggle {
        display: flex;
    }

    .category-title {
        font-size: 2.5rem;
        letter-spacing: 4px;
    }
}

@media (max-width: 768px) {
    .products-toolbar {
        flex-wrap: wrap;
        gap: 1rem;
    }

    .toolbar-info {
        order: -1;
        width: 100%;
    }

    .toolbar-right {
        width: 100%;
        justify-content: space-between;
    }

    .products-grid {
        grid-template-columns: 1fr;
    }

    .category-header {
        height: 50vh;
        min-height: 350px;
    }

    .category-title {
        font-size: 2rem;
    }
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter Toggle
    const filterToggle = document.getElementById('filterToggle');
    const filtersSidebar = document.getElementById('filtersSidebar');
    const filtersClose = document.getElementById('filtersClose');

    if (filterToggle) {
        filterToggle.addEventListener('click', () => {
            filtersSidebar.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    }

    if (filtersClose) {
        filtersClose.addEventListener('click', () => {
            filtersSidebar.classList.remove('active');
            document.body.style.overflow = '';
        });
    }

    // View Options
    const viewBtns = document.querySelectorAll('.view-btn');
    const productsGrid = document.getElementById('productsGrid');

    viewBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            viewBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            if (this.dataset.view === 'list') {
                productsGrid.style.gridTemplateColumns = '1fr';
            } else {
                productsGrid.style.gridTemplateColumns = '';
            }
        });
    });

    // Sort Products
    const sortSelect = document.getElementById('sortSelect');
    sortSelect.addEventListener('change', function() {
        const products = Array.from(productsGrid.children);
        
        products.sort((a, b) => {
            const priceA = parseFloat(a.dataset.price);
            const priceB = parseFloat(b.dataset.price);
            const ratingA = parseFloat(a.dataset.rating);
            const ratingB = parseFloat(b.dataset.rating);

            switch(this.value) {
                case 'price-low':
                    return priceA - priceB;
                case 'price-high':
                    return priceB - priceA;
                case 'rating':
                    return ratingB - ratingA;
                default:
                    return 0;
            }
        });

        products.forEach(product => productsGrid.appendChild(product));
    });
});
</script>
@endsection
