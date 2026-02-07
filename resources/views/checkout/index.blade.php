@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="mb-4">
                <i class="fas fa-credit-card"></i> Paiement
            </h1>

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <!-- Résumé de la commande -->
                <div class="col-lg-7">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Résumé de votre commande</h5>
                        </div>
                        <div class="card-body">
                            @foreach($cart as $item)
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="d-flex align-items-center">
                                        @if(!empty($item['image']))
                                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" 
                                                 class="img-thumbnail me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                        @endif
                                        <div>
                                            <h6 class="mb-0">{{ $item['name'] }}</h6>
                                            <small class="text-muted">Quantité: {{ $item['quantity'] }}</small>
                                        </div>
                                    </div>
                                    <strong>{{ number_format($item['price'] * $item['quantity'], 2) }} €</strong>
                                </div>
                            @endforeach
                            
                            <hr>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span>Sous-total</span>
                                <strong>{{ number_format($total, 2) }} €</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Livraison</span>
                                <strong>Gratuite</strong>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong class="h5">Total</strong>
                                <strong class="h5 text-primary">{{ number_format($total, 2) }} €</strong>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Retour au panier
                    </a>
                </div>

                <!-- Formulaire de paiement -->
                <div class="col-lg-5">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-lock"></i> Paiement sécurisé
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('checkout.create-session') }}" method="POST" id="payment-form">
                                @csrf
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ auth()->user()->email ?? '' }}" required>
                                    <small class="text-muted">Pour recevoir la confirmation de commande</small>
                                </div>

                                <div class="alert alert-info">
                                    <small>
                                        <i class="fas fa-info-circle"></i> 
                                        Vous serez redirigé vers une page de paiement sécurisée Stripe
                                    </small>
                                </div>

                                <button type="submit" class="btn btn-success w-100 btn-lg">
                                    <i class="fas fa-lock"></i> Payer {{ number_format($total, 2) }} €
                                </button>
                            </form>

                            <div class="mt-4 text-center">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Stripe_Logo%2C_revised_2016.svg" 
                                     alt="Stripe" style="width: 80px;" class="mb-2">
                                <p class="small text-muted mb-0">
                                    <i class="fas fa-shield-alt"></i> Paiement sécurisé SSL
                                </p>
                                <p class="small text-muted">
                                    Vos informations sont protégées et chiffrées
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm mt-3">
                        <div class="card-body">
                            <h6><i class="fas fa-credit-card"></i> Moyens de paiement acceptés</h6>
                            <div class="d-flex gap-2 mt-2">
                                <i class="fab fa-cc-visa fa-2x text-primary"></i>
                                <i class="fab fa-cc-mastercard fa-2x text-danger"></i>
                                <i class="fab fa-cc-amex fa-2x text-info"></i>
                                <i class="fab fa-cc-discover fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
