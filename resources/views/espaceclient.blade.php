@extends('layouts.app')

@section('title', 'Espace Client')

@section('content')
<div class="container" style="margin-top: 30px;">
    <div class="row">
        <div class="col-12">
            <h1 style="text-align: center; margin-bottom: 30px; color: #e94560; font-family: 'Playfair Display', serif;">
                🛍️ Espace Client - Produits en Solde
            </h1>
            
            @if(count($produits) > 0)
                <div class="alert alert-success" style="text-align: center; margin-bottom: 30px;">
                    ✨ <strong>{{ $produits->total() }} produits en promotion</strong> rien que pour vous!
                </div>
                
                <div class="row">
                    @foreach($produits as $produit)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100" style="border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1); transition: transform 0.3s;" 
                                onmouseover="this.style.transform='translateY(-10px)'" 
                                onmouseout="this.style.transform='translateY(0)'">
                                
                                <div style="position: relative; height: 250px; overflow: hidden; background: #f8f9fa;">
                                    <img src="{{ $produit->image_url }}" 
                                         alt="{{ $produit->name }}"
                                         style="width: 100%; height: 100%; object-fit: cover;">
                                    
                                    @if($produit->sale)
                                        <span style="position: absolute; top: 10px; right: 10px; background: #e94560; color: white; padding: 8px 15px; border-radius: 25px; font-weight: 700; font-size: 14px;">
                                            🔥 PROMO
                                        </span>
                                    @endif
                                    
                                    @if($produit->new)
                                        <span style="position: absolute; top: 10px; left: 10px; background: #28a745; color: white; padding: 8px 15px; border-radius: 25px; font-weight: 700; font-size: 14px;">
                                            ⭐ NEW
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="card-body">
                                    <h5 class="card-title" style="font-weight: 700; color: #1a1a2e;">
                                        {{ $produit->name }}
                                    </h5>
                                    
                                    <p style="margin-bottom: 10px;">
                                        <span style="background: #e94560; color: white; padding: 3px 10px; border-radius: 15px; font-size: 12px; font-weight: 600;">
                                            {{ ucfirst($produit->categorie) }}
                                        </span>
                                    </p>
                                    
                                    <div style="margin-bottom: 15px;">
                                        <span style="font-size: 28px; font-weight: 700; color: #e94560;">
                                            {{ number_format($produit->price, 2) }}€
                                        </span>
                                        @if($produit->old_price)
                                            <span style="text-decoration: line-through; color: #999; font-size: 18px; margin-left: 10px;">
                                                {{ number_format($produit->old_price, 2) }}€
                                            </span>
                                            @php
                                                $reduction = round((($produit->old_price - $produit->price) / $produit->old_price) * 100);
                                            @endphp
                                            <span style="color: #28a745; font-weight: 700; margin-left: 10px;">
                                                -{{ $reduction }}%
                                            </span>
                                        @endif
                                    </div>
                                    
                                    @if($produit->description)
                                        <p class="card-text" style="color: #666; font-size: 14px;">
                                            {{ Str::limit($produit->description, 100) }}
                                        </p>
                                    @endif
                                    
                                    <div style="margin-top: 15px;">
                                        @if($produit->stock > 0)
                                            <span style="color: #28a745; font-weight: 600; font-size: 14px;">
                                                ✓ En stock ({{ $produit->stock }})
                                            </span>
                                        @else
                                            <span style="color: #dc3545; font-weight: 600; font-size: 14px;">
                                                ✗ Rupture de stock
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <a href="{{ route('produits.show', $produit->id) }}" 
                                       class="btn btn-primary" 
                                       style="width: 100%; margin-top: 15px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 12px; border-radius: 25px; font-weight: 700;">
                                        Voir les détails
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div style="margin-top: 30px; display: flex; justify-content: center;">
                    {{ $produits->links('pagination::bootstrap-4') }}
                </div>
            @else
                <div class="alert alert-info" style="text-align: center; padding: 50px; font-size: 18px;">
                    😔 Aucun produit en solde pour le moment. Revenez bientôt!
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
