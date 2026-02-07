@extends('layouts.app')

@section('title', 'ClothesZC - Votre Boutique de Mode')

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-content">
        <span class="hero-tag">Nouvelle Collection 2024</span>
        <h1>Exprimez Votre<br><span>Style Unique</span></h1>
        <p>Découvrez notre sélection de vêtements tendance pour affirmer votre personnalité</p>
        <div class="hero-buttons">
            <a href="{{ route('produits.index') }}" class="btn btn-primary">Découvrir la Collection</a>
            <a href="{{ route('about') }}" class="btn btn-outline btn-outline-white">En Savoir Plus</a>
        </div>
    </div>
    <div class="hero-scroll">
        <span>Scroll</span>
        <div class="scroll-line"></div>
    </div>
</section>

<!-- Features Section -->
<section class="features">
    <div class="container">
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-truck"></i>
                </div>
                <h3>Livraison Gratuite</h3>
                <p>Dès 50€ d'achat</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-undo-alt"></i>
                </div>
                <h3>Retours Gratuits</h3>
                <p>Sous 30 jours</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Paiement Sécurisé</h3>
                <p>100% protégé</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3>Support 24/7</h3>
                <p>À votre écoute</p>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Notre Collection</span>
            <h2 class="section-title">Produits Populaires</h2>
            <p class="section-subtitle">Une sélection soigneusement choisie pour vous</p>
        </div>

        <div class="products-grid">
            @foreach($featuredProducts as $product)
            <article class="product-card">
                <div class="product-image">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                    <div class="product-overlay"></div>
                    @if($product->new)
                    <span class="product-badge badge-new">Nouveau</span>
                    @elseif($product->sale)
                    <span class="product-badge badge-sale">Promo</span>
                    @endif
                    <div class="product-actions">
                        <button class="action-btn" title="Aperçu"><i class="fas fa-eye"></i></button>
                        <button class="action-btn" title="Ajouter au panier"><i class="fas fa-shopping-bag"></i></button>
                        <button class="action-btn" title="Favoris"><i class="fas fa-heart"></i></button>
                    </div>
                </div>
                <div class="product-info">
                    <span class="product-category">{{ ucfirst($product->categorie) }}</span>
                    <h3 class="product-name">
                        <a href="{{ route('produits.show', $product->id) }}">{{ $product->name }}</a>
                    </h3>
                    <div class="product-price">
                        <span class="price-current">{{ number_format($product->price, 2) }}€</span>
                        @if($product->old_price)
                        <span class="price-old">{{ number_format($product->old_price, 2) }}€</span>
                        @endif
                    </div>
                    <div class="product-rating">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star{{ $i <= floor($product->rating) ? '' : '-half-alt' }}"></i>
                        @endfor
                        <span>({{ $product->reviews }})</span>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        <div class="section-cta">
            <a href="{{ route('produits.index') }}" class="btn btn-primary">Voir Tous les Produits</a>
        </div>
    </div>
</section>

<!-- About Preview -->
<section class="about-section">
    <div class="container">
        <div class="about-grid">
            <div class="about-images">
                <div class="about-img-main">
                    <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=600&q=80" alt="Boutique">
                </div>
                <div class="about-img-secondary">
                    <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=400&q=80" alt="Mode">
                </div>
            </div>
            <div class="about-content">
                <span class="section-tag">Notre Histoire</span>
                <h2>À Propos de ClothesZC</h2>
                <p>Chez ClothesZC, nous croyons que la mode est une forme d'expression personnelle. Notre mission est de vous offrir des vêtements de qualité qui reflètent votre style unique.</p>
                <p>Depuis notre création, nous sélectionnons avec soin chaque pièce de notre collection pour garantir style, confort et durabilité.</p>
                <ul class="about-features">
                    <li><i class="fas fa-check-circle"></i> Qualité Premium</li>
                    <li><i class="fas fa-check-circle"></i> Style Tendance</li>
                    <li><i class="fas fa-check-circle"></i> Prix Accessibles</li>
                </ul>
                <a href="{{ route('about') }}" class="btn btn-primary">En Savoir Plus</a>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter -->
<section class="newsletter">
    <div class="container">
        <div class="newsletter-content">
            <span class="section-tag">Newsletter</span>
            <h2>Restez Informé</h2>
            <p>Inscrivez-vous pour recevoir nos dernières offres et nouveautés</p>
            <form class="newsletter-form">
                <input type="email" placeholder="Votre adresse email" required>
                <button type="submit" class="btn btn-primary">S'inscrire</button>
            </form>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
/* ===== HERO ===== */
.hero {
    position: relative;
    height: 100vh;
    min-height: 700px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.hero-bg {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(26, 26, 46, 0.95) 0%, rgba(22, 33, 62, 0.9) 100%),
                url('https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=1920&q=80');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
}

.hero-content {
    position: relative;
    z-index: 1;
    text-align: center;
    color: var(--white);
    max-width: 800px;
    padding: 0 24px;
}

.hero-tag {
    display: inline-block;
    background: rgba(233, 69, 96, 0.2);
    border: 1px solid var(--accent);
    color: var(--accent);
    padding: 10px 25px;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 25px;
}

.hero-content h1 {
    font-family: 'Playfair Display', serif;
    font-size: 4.5rem;
    font-weight: 700;
    line-height: 1.1;
    margin-bottom: 25px;
}

.hero-content h1 span {
    color: var(--accent);
}

.hero-content p {
    font-size: 1.2rem;
    opacity: 0.9;
    margin-bottom: 40px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.hero-buttons {
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-outline-white {
    border-color: var(--white);
    color: var(--white);
}

.btn-outline-white:hover {
    background: var(--white);
    color: var(--primary);
}

.hero-scroll {
    position: absolute;
    bottom: 40px;
    left: 50%;
    transform: translateX(-50%);
    text-align: center;
    color: var(--white);
    opacity: 0.7;
}

.hero-scroll span {
    font-size: 0.75rem;
    letter-spacing: 2px;
    text-transform: uppercase;
}

.scroll-line {
    width: 1px;
    height: 60px;
    background: linear-gradient(to bottom, var(--white), transparent);
    margin: 10px auto 0;
    animation: scrollPulse 2s infinite;
}

@keyframes scrollPulse {
    0%, 100% { opacity: 0.3; height: 60px; }
    50% { opacity: 1; height: 80px; }
}

/* ===== FEATURES ===== */
.features {
    background: var(--light);
    padding: 50px 0;
    margin-top: -50px;
    position: relative;
    z-index: 10;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
}

.feature-card {
    text-align: center;
    padding: 30px 20px;
    background: var(--white);
    border-radius: 15px;
    box-shadow: var(--shadow);
    transition: var(--transition);
}

.feature-card:hover {
    transform: translateY(-5px);
}

.feature-icon {
    width: 70px;
    height: 70px;
    margin: 0 auto 20px;
    background: linear-gradient(135deg, var(--accent) 0%, var(--accent-light) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.feature-icon i {
    font-size: 1.5rem;
    color: var(--white);
}

.feature-card h3 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 5px;
}

.feature-card p {
    font-size: 0.9rem;
    color: var(--gray);
}

/* ===== SECTION CTA ===== */
.section-cta {
    text-align: center;
    margin-top: 50px;
}

/* ===== ABOUT SECTION ===== */
.about-section {
    padding: 100px 0;
    background: var(--light);
}

.about-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 80px;
    align-items: center;
}

.about-images {
    position: relative;
}

.about-img-main {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: var(--shadow-hover);
}

.about-img-main img {
    width: 100%;
    height: 500px;
    object-fit: cover;
}

.about-img-secondary {
    position: absolute;
    bottom: -40px;
    right: -40px;
    width: 200px;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: var(--shadow-hover);
    border: 5px solid var(--white);
}

.about-img-secondary img {
    width: 100%;
    height: 250px;
    object-fit: cover;
}

.about-content h2 {
    font-family: 'Playfair Display', serif;
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--dark);
    margin: 15px 0 25px;
}

.about-content p {
    color: var(--gray);
    margin-bottom: 20px;
    line-height: 1.8;
}

.about-features {
    margin: 30px 0;
}

.about-features li {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 15px;
    font-weight: 500;
    color: var(--dark);
}

.about-features i {
    color: var(--accent);
    font-size: 1.2rem;
}

/* ===== NEWSLETTER ===== */
.newsletter {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    padding: 100px 0;
}

.newsletter-content {
    text-align: center;
    max-width: 600px;
    margin: 0 auto;
    color: var(--white);
}

.newsletter-content h2 {
    font-family: 'Playfair Display', serif;
    font-size: 2.5rem;
    margin: 15px 0;
}

.newsletter-content p {
    opacity: 0.9;
    margin-bottom: 30px;
}

.newsletter-form {
    display: flex;
    gap: 15px;
    max-width: 500px;
    margin: 0 auto;
}

.newsletter-form input {
    flex: 1;
    padding: 16px 24px;
    border: none;
    border-radius: 50px;
    font-family: 'Raleway', sans-serif;
    font-size: 1rem;
}

.newsletter-form input:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(233, 69, 96, 0.3);
}

/* ===== RESPONSIVE ===== */
@media (max-width: 992px) {
    .hero-content h1 {
        font-size: 3rem;
    }

    .features-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .about-grid {
        grid-template-columns: 1fr;
        gap: 60px;
    }

    .about-img-secondary {
        right: 20px;
    }
}

@media (max-width: 576px) {
    .hero-content h1 {
        font-size: 2.5rem;
    }

    .features-grid {
        grid-template-columns: 1fr;
    }

    .hero-buttons {
        flex-direction: column;
        align-items: center;
    }

    .newsletter-form {
        flex-direction: column;
    }
}
</style>
@endsection
