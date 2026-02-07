@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
            <div class="card shadow-sm">
                <div class="card-body py-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                    </div>
                    
                    <h1 class="mb-3">Paiement réussi !</h1>
                    
                    <p class="lead text-muted mb-4">
                        Votre commande a été confirmée avec succès.
                    </p>

                    @if(isset($sessionId))
                        <div class="alert alert-info">
                            <small>
                                <strong>Numéro de transaction:</strong> {{ $sessionId }}
                            </small>
                        </div>
                    @endif

                    <div class="mb-4">
                        <p class="mb-2">
                            <i class="fas fa-envelope text-primary"></i> 
                            Un email de confirmation a été envoyé à votre adresse
                        </p>
                        <p>
                            <i class="fas fa-box text-success"></i> 
                            Votre commande sera expédiée dans les prochaines 24-48h
                        </p>
                    </div>

                    <div class="d-flex flex-column gap-2">
                        <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-home"></i> Retour à l'accueil
                        </a>
                        
                        <a href="{{ route('produits.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-shopping-bag"></i> Continuer mes achats
                        </a>

                        @auth
                            <a href="{{ route('espaceclient') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-user"></i> Voir mon espace client
                            </a>
                        @endauth
                    </div>

                    <div class="mt-4 pt-4 border-top">
                        <h6 class="mb-3">Besoin d'aide ?</h6>
                        <p class="small text-muted mb-0">
                            Contactez notre service client au:<br>
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
