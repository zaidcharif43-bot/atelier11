@extends('layouts.app')

@section('title', $product->name . ' - Détails - ClothesZC')

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1><i class="fas fa-box-open"></i> Détails du Produit</h1>
            <p>Informations complètes sur le produit</p>
        </div>
    </section>

    <!-- Product Detail Admin -->
    <section class="section" style="padding: 60px 0; background: #f8f9fa;">
        <div class="container">
            <div style="max-width: 1000px; margin: 0 auto;">
                <div
                    style="background: white; border-radius: 15px; padding: 40px; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">

                    <!-- Back Button -->
                    <div style="margin-bottom: 30px;">
                        <a href="{{ route('produits.manage') }}" class="btn btn-outline">
                            <i class="fas fa-arrow-left"></i> Retour à la gestion
                        </a>
                    </div>

                    <!-- Product Header -->
                    <div style="display: grid; grid-template-columns: 300px 1fr; gap: 40px; margin-bottom: 40px;">
                        <!-- Image -->
                        <div style="border-radius: 15px; overflow: hidden; background: #f8f9fa;">
                            @if($product->image)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                    style="width: 100%; height: 300px; object-fit: cover;">
                            @else
                                <div
                                    style="width: 100%; height: 300px; display: flex; align-items: center; justify-content: center; background: #e9ecef;">
                                    <i class="fas fa-image" style="font-size: 4rem; color: #999;"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Basic Info -->
                        <div>
                            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
                                <h1 style="font-family: 'Playfair Display', serif; font-size: 2rem; margin: 0;">
                                    {{ $product->name }}
                                </h1>
                                @if($product->new)
                                    <span
                                        style="background: #28a745; color: white; padding: 5px 12px; border-radius: 20px; font-size: 0.85rem;">
                                        Nouveau
                                    </span>
                                @endif
                                @if($product->sale)
                                    <span
                                        style="background: #e94560; color: white; padding: 5px 12px; border-radius: 20px; font-size: 0.85rem;">
                                        Promo
                                    </span>
                                @endif
                            </div>

                            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                                <span
                                    style="background: #e94560; color: white; padding: 8px 16px; border-radius: 20px; font-size: 0.9rem;">
                                    {{ ucfirst($product->categorie) }}
                                </span>
                                <span style="color: #666;">
                                    <i class="fas fa-hashtag"></i> ID: {{ $product->id }}
                                </span>
                            </div>

                            <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 20px;">
                                <div>
                                    <span
                                        style="font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700; color: #e94560;">
                                        {{ number_format($product->price, 2) }}€
                                    </span>
                                    @if($product->old_price)
                                        <span
                                            style="font-size: 1.2rem; color: #999; text-decoration: line-through; margin-left: 10px;">
                                            {{ number_format($product->old_price, 2) }}€
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 20px;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="color: #ffc107;">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i
                                                class="fas fa-star{{ $i <= floor($product->rating) ? '' : ($i - 0.5 <= $product->rating ? '-half-alt' : '') }}"></i>
                                        @endfor
                                    </div>
                                    <span style="font-weight: 600;">{{ $product->rating }}/5</span>
                                    <span style="color: #666;">({{ $product->reviews }} avis)</span>
                                </div>
                            </div>

                            <div style="display: flex; align-items: center; gap: 10px;">
                                @if($product->stock > 0)
                                    <i class="fas fa-check-circle" style="color: #28a745;"></i>
                                    <span style="color: #28a745; font-weight: 500;">
                                        En stock ({{ $product->stock }} disponibles)
                                    </span>
                                @else
                                    <i class="fas fa-times-circle" style="color: #dc3545;"></i>
                                    <span style="color: #dc3545; font-weight: 500;">Rupture de stock</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Product Details -->
                    <div style="border-top: 2px solid #f0f0f0; padding-top: 30px;">
                        <!-- Description -->
                        @if($product->description)
                            <div style="margin-bottom: 30px;">
                                <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 15px; color: #1a1a2e;">
                                    <i class="fas fa-align-left" style="color: #e94560;"></i> Description
                                </h3>
                                <p style="color: #666; line-height: 1.8; padding-left: 30px;">
                                    {{ $product->description }}
                                </p>
                            </div>
                        @endif

                        <!-- Features -->
                        @if($product->features && count($product->features) > 0)
                            <div style="margin-bottom: 30px;">
                                <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 15px; color: #1a1a2e;">
                                    <i class="fas fa-list-ul" style="color: #e94560;"></i> Caractéristiques
                                </h3>
                                <ul style="padding-left: 30px; color: #666; line-height: 2;">
                                    @foreach($product->features as $feature)
                                        <li style="margin-bottom: 8px;">
                                            <i class="fas fa-check" style="color: #28a745; margin-right: 10px;"></i>
                                            {{ $feature }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Additional Info -->
                        <div>
                            <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 15px; color: #1a1a2e;">
                                <i class="fas fa-info-circle" style="color: #e94560;"></i> Informations supplémentaires
                            </h3>
                            <div
                                style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; padding-left: 30px;">
                                <div style="padding: 15px; background: #f8f9fa; border-radius: 10px;">
                                    <div style="font-weight: 600; color: #1a1a2e; margin-bottom: 5px;">Date d'ajout</div>
                                    <div style="color: #666;">{{ $product->created_at->format('d/m/Y H:i') }}</div>
                                </div>
                                <div style="padding: 15px; background: #f8f9fa; border-radius: 10px;">
                                    <div style="font-weight: 600; color: #1a1a2e; margin-bottom: 5px;">Dernière modification
                                    </div>
                                    <div style="color: #666;">{{ $product->updated_at->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div
                        style="margin-top: 40px; padding-top: 30px; border-top: 2px solid #f0f0f0; display: flex; gap: 15px;">
                        <a href="{{ route('produits.edit', $product->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Modifier ce produit
                        </a>
                        <form action="{{ route('produits.delete', $product->id) }}" method="POST"
                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')"
                            style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </form>
                        <a href="{{ route('produits.show', $product->id) }}" class="btn btn-outline" target="_blank">
                            <i class="fas fa-external-link-alt"></i> Voir sur le site
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection