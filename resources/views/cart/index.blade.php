@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">
                <i class="fas fa-shopping-cart"></i> Mon Panier
            </h1>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(empty($cart))
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Votre panier est vide.
                    <a href="{{ route('produits.index') }}" class="alert-link">Continuer vos achats</a>
                </div>
            @else
                <div class="row">
                    <!-- Liste des produits -->
                    <div class="col-lg-8">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Produit</th>
                                            <th>Prix</th>
                                            <th>Quantité</th>
                                            <th>Total</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cart as $id => $item)
                                            <tr data-item-id="{{ $id }}">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if(!empty($item['image']))
                                                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" 
                                                                 class="img-thumbnail me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                                        @endif
                                                        <div>
                                                            <h6 class="mb-0">{{ $item['name'] }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <strong>{{ number_format($item['price'], 2) }} €</strong>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="input-group" style="width: 130px;">
                                                        <button class="btn btn-outline-secondary btn-sm decrease-qty" type="button">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                        <input type="number" class="form-control form-control-sm text-center quantity-input" 
                                                               value="{{ $item['quantity'] }}" min="1" data-item-id="{{ $id }}">
                                                        <button class="btn btn-outline-secondary btn-sm increase-qty" type="button">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <strong class="item-total">{{ number_format($item['price'] * $item['quantity'], 2) }} €</strong>
                                                </td>
                                                <td class="align-middle">
                                                    <form action="{{ route('cart.remove', $id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                                onclick="return confirm('Êtes-vous sûr de vouloir retirer ce produit ?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-between mt-3">
                                    <a href="{{ route('produits.index') }}" class="btn btn-outline-primary">
                                        <i class="fas fa-arrow-left"></i> Continuer mes achats
                                    </a>
                                    
                                    <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" 
                                                onclick="return confirm('Êtes-vous sûr de vouloir vider le panier ?')">
                                            <i class="fas fa-trash-alt"></i> Vider le panier
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Résumé de la commande -->
                    <div class="col-lg-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-receipt"></i> Résumé de la commande
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Sous-total</span>
                                    <strong id="subtotal">{{ number_format($total, 2) }} €</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Livraison</span>
                                    <strong>Gratuite</strong>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-3">
                                    <strong>Total</strong>
                                    <strong class="text-primary" id="total">{{ number_format($total, 2) }} €</strong>
                                </div>

                                <a href="{{ route('checkout.index') }}" class="btn btn-success w-100 mb-2">
                                    <i class="fas fa-lock"></i> Procéder au paiement
                                </a>

                                <div class="text-center mt-3">
                                    <small class="text-muted">
                                        <i class="fas fa-shield-alt"></i> Paiement sécurisé par Stripe
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Informations supplémentaires -->
                        <div class="card shadow-sm mt-3">
                            <div class="card-body">
                                <h6><i class="fas fa-truck"></i> Livraison</h6>
                                <p class="small text-muted mb-2">Livraison gratuite pour toute commande</p>
                                
                                <h6><i class="fas fa-undo"></i> Retours</h6>
                                <p class="small text-muted mb-2">Retours gratuits sous 30 jours</p>
                                
                                <h6><i class="fas fa-lock"></i> Paiement sécurisé</h6>
                                <p class="small text-muted mb-0">Transactions 100% sécurisées</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Script panier chargé');
    
    // Gestion des boutons + et -
    document.querySelectorAll('.increase-qty').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const inputGroup = this.closest('.input-group');
            const input = inputGroup.querySelector('.quantity-input');
            const currentValue = parseInt(input.value) || 1;
            input.value = currentValue + 1;
            updateQuantity(input);
        });
    });

    document.querySelectorAll('.decrease-qty').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const inputGroup = this.closest('.input-group');
            const input = inputGroup.querySelector('.quantity-input');
            const currentValue = parseInt(input.value) || 1;
            if (currentValue > 1) {
                input.value = currentValue - 1;
                updateQuantity(input);
            }
        });
    });

    // Gestion du changement direct dans l'input
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const value = parseInt(this.value) || 1;
            if (value < 1) {
                this.value = 1;
            }
            updateQuantity(this);
        });
    });

    function updateQuantity(input) {
        const itemId = input.dataset.itemId;
        const quantity = parseInt(input.value) || 1;
        const row = input.closest('tr');
        const priceText = row.querySelector('td:nth-child(2) strong').textContent;
        const price = parseFloat(priceText.replace('€', '').replace(',', '.').trim());
        
        console.log('Mise à jour quantité:', { itemId, quantity, price });
        
        // Récupérer le token CSRF
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            console.error('Token CSRF non trouvé');
            alert('Erreur: Token CSRF manquant. Veuillez rafraîchir la page.');
            return;
        }
        
        // Mise à jour visuelle immédiate
        const itemTotal = price * quantity;
        row.querySelector('.item-total').textContent = itemTotal.toFixed(2) + ' €';
        
        // Mise à jour du total général immédiate
        updateTotals();
        
        // Envoi au serveur
        fetch(`/cart/update/${itemId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken.content,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur réseau: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('Réponse serveur:', data);
            if (data.success) {
                // Mise à jour confirmée par le serveur
                row.querySelector('.item-total').textContent = data.itemTotal + ' €';
                document.getElementById('subtotal').textContent = data.total + ' €';
                document.getElementById('total').textContent = data.total + ' €';
                
                // Mettre à jour le compteur du panier dans le header
                updateCartCount();
            } else {
                alert('Erreur lors de la mise à jour: ' + (data.message || 'Erreur inconnue'));
                location.reload();
            }
        })
        .catch(error => {
            console.error('Erreur AJAX:', error);
            // En cas d'erreur, on garde la mise à jour visuelle
            // mais on pourrait recharger la page si nécessaire
        });
    }
    
    function updateTotals() {
        let total = 0;
        document.querySelectorAll('.item-total').forEach(itemTotal => {
            const value = parseFloat(itemTotal.textContent.replace('€', '').replace(',', '.').trim());
            total += value;
        });
        
        document.getElementById('subtotal').textContent = total.toFixed(2) + ' €';
        document.getElementById('total').textContent = total.toFixed(2) + ' €';
    }

    function updateCartCount() {
        fetch('/cart/count', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            const badge = document.querySelector('.cart-count-badge');
            if (badge) {
                badge.textContent = data.count;
                if (data.count > 0) {
                    badge.style.display = 'flex';
                } else {
                    badge.style.display = 'none';
                }
            }
        })
        .catch(error => console.error('Erreur compteur:', error));
    }
});
</script>
@endsection
