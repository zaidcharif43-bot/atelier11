@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h4 class="mb-0">🔧 Débogage du Panier</h4>
                </div>
                <div class="card-body">
                    <h5>Contenu actuel du panier :</h5>
                    
                    @php
                        $cart = Session::get('cart', []);
                    @endphp
                    
                    @if(empty($cart))
                        <div class="alert alert-info">
                            Le panier est vide ✅
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom</th>
                                        <th>Image (URL)</th>
                                        <th>Prix</th>
                                        <th>Quantité</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart as $id => $item)
                                        <tr>
                                            <td>{{ $id }}</td>
                                            <td>{{ $item['name'] }}</td>
                                            <td>
                                                <small style="word-break: break-all;">{{ $item['image'] ?? 'AUCUNE IMAGE' }}</small>
                                                @if(!empty($item['image']))
                                                    <br>
                                                    <img src="{{ $item['image'] }}" alt="" style="max-width: 100px; margin-top: 5px;">
                                                @endif
                                            </td>
                                            <td>{{ $item['price'] }} €</td>
                                            <td>{{ $item['quantity'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            <h5>Actions :</h5>
                            <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Vider le panier ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-lg">
                                    <i class="fas fa-trash"></i> Vider complètement le panier
                                </button>
                            </form>
                        </div>
                    @endif
                    
                    <div class="mt-4">
                        <a href="{{ route('produits.index') }}" class="btn btn-primary">
                            <i class="fas fa-shopping-bag"></i> Voir les produits
                        </a>
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-shopping-cart"></i> Voir le panier
                        </a>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="alert alert-warning">
                        <h6><i class="fas fa-info-circle"></i> Pourquoi les images ne s'affichent pas ?</h6>
                        <p class="mb-2">Les produits ajoutés <strong>AVANT</strong> la correction utilisent l'ancien format sans l'URL complète.</p>
                        <p class="mb-0"><strong>Solution :</strong> Videz le panier ci-dessus, puis ajoutez de nouveaux produits. Les images s'afficheront correctement !</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
