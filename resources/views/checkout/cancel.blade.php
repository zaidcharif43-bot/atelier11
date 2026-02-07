@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
            <div class="card shadow-sm">
                <div class="card-body py-5">
                    <div class="mb-4">
                        <i class="fas fa-times-circle text-warning" style="font-size: 5rem;"></i>
                    </div>
                    
                    <h1 class="mb-3">Paiement annulé</h1>
                    
                    <p class="lead text-muted mb-4">
                        Vous avez annulé le processus de paiement.
                    </p>

                    <p class="mb-4">
                        Votre panier a été conservé et vous pouvez reprendre votre commande à tout moment.
                    </p>

                    <div class="d-flex flex-column gap-2">
                        <a href="{{ route('cart.index') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-shopping-cart"></i> Retour au panier
                        </a>
                        
                        <a href="{{ route('produits.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-shopping-bag"></i> Continuer mes achats
                        </a>

                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-home"></i> Retour à l'accueil
                        </a>
                    </div>

                    <div class="mt-4 pt-4 border-top">
                        <h6 class="mb-3">Besoin d'aide ?</h6>
                        <p class="small text-muted mb-0">
                            Si vous rencontrez des difficultés, contactez-nous:<br>
                            <i class="fas fa-phone"></i> 01 23 45 67 89<br>
                            <i class="fas fa-envelope"></i> support@example.com
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
