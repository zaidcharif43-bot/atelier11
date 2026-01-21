@extends('layouts.app')

@section('title', 'Nettoyage Base de Données - ClothesZC')

@section('content')
    <section class="page-header">
        <div class="container">
            <h1><i class="fas fa-broom"></i> Nettoyage de la Base de Données</h1>
            <p>Supprimer tous les produits et recommencer</p>
        </div>
    </section>

    <section class="section" style="padding: 60px 0; background: #f8f9fa;">
        <div class="container">
            <div
                style="max-width: 600px; margin: 0 auto; background: white; border-radius: 15px; padding: 40px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); text-align: center;">

                @if(session('success'))
                    <div
                        style="background: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 16px 20px; border-radius: 12px; margin-bottom: 30px;">
                        <i class="fas fa-check-circle" style="font-size: 1.5rem; margin-bottom: 10px;"></i>
                        <p style="margin: 0;">{{ session('success') }}</p>
                    </div>
                @endif

                <i class="fas fa-trash-alt" style="font-size: 5rem; color: #dc3545; margin-bottom: 20px;"></i>

                <h2 style="font-family: 'Playfair Display', serif; margin-bottom: 15px;">Supprimer TOUS les produits</h2>

                <p style="color: #666; margin-bottom: 30px;">
                    Cette action va supprimer <strong>{{ $count }} produit(s)</strong> de la base de données.<br>
                    Les images associées seront également supprimées.
                </p>

                <div
                    style="background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 10px; margin-bottom: 30px;">
                    <i class="fas fa-exclamation-triangle" style="color: #f39c12;"></i>
                    <strong>Attention :</strong> Cette action est irréversible !
                </div>

                @if($count > 0)
                    <form action="{{ route('produits.cleanup') }}" method="POST"
                        onsubmit="return confirm('Êtes-vous VRAIMENT sûr de vouloir supprimer TOUS les produits ?')">
                        @csrf
                        <button type="submit"
                            style="background: #dc3545; color: white; border: none; padding: 15px 40px; border-radius: 50px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s;">
                            <i class="fas fa-trash"></i> Supprimer tous les produits
                        </button>
                    </form>
                @else
                    <p style="color: #28a745; font-weight: 600;">✓ Aucun produit dans la base de données</p>
                @endif

                <div style="margin-top: 30px;">
                    <a href="{{ route('produits.manage') }}" class="btn btn-outline" style="margin-right: 10px;">
                        <i class="fas fa-arrow-left"></i> Retour à la gestion
                    </a>
                    <a href="{{ route('produits.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Ajouter un produit
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection