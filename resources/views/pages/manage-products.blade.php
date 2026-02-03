@extends('layouts.app')

@section('title', 'Gérer les Produits - ClothesZC')

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1><i class="fas fa-cog"></i> Gérer les Produits</h1>
            <p>Supprimer ou modifier vos produits</p>
        </div>
    </section>

    <!-- Products Management -->
    <section class="section" style="padding: 60px 0; background: #f8f9fa;">
        <div class="container">
            {{-- Message de succès --}}
            @if(session('success'))
                <div
                    style="background: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 16px 20px; border-radius: 12px; margin-bottom: 30px; display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-check-circle" style="font-size: 1.2rem;"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            {{-- Message de mise à jour --}}
            @if($message = Session::get('successupdate'))
                <div
                    style="background: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 16px 20px; border-radius: 12px; margin-bottom: 30px; display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-check-circle" style="font-size: 1.2rem;"></i>
                    <strong>{{ $message }}</strong>
                </div>
            @endif

            {{-- Message de suppression --}}
            @if($message = Session::get('successdelete'))
                <div
                    style="background: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 16px 20px; border-radius: 12px; margin-bottom: 30px; display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-check-circle" style="font-size: 1.2rem;"></i>
                    <strong>{{ $message }}</strong>
                </div>
            @endif

            <div style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                    <h2 style="font-family: 'Playfair Display', serif; margin: 0;">
                        📦 Tous les Produits ({{ $products->total() }})
                    </h2>
                    <div style="display: flex; gap: 10px;">
                        <a href="{{ route('produits.cleanup.show') }}" class="btn btn-outline"
                            style="background: #dc3545; color: white; border-color: #dc3545;">
                            <i class="fas fa-broom"></i> Nettoyer la base
                        </a>
                        <a href="{{ route('produits.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Ajouter un produit
                        </a>
                    </div>
                </div>

                @if($products->count() > 0)
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background: #1a1a2e; color: white;">
                                    <th style="padding: 15px; text-align: left; border-radius: 10px 0 0 0;">ID</th>
                                    <th style="padding: 15px; text-align: left;">Image</th>
                                    <th style="padding: 15px; text-align: left;">Nom</th>
                                    <th style="padding: 15px; text-align: left;">Catégorie</th>
                                    <th style="padding: 15px; text-align: left;">Prix</th>
                                    <th style="padding: 15px; text-align: center; border-radius: 0 10px 0 0;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr style="border-bottom: 1px solid #eee;">
                                        <td style="padding: 15px;">{{ $product->id }}</td>
                                        <td style="padding: 15px;">
                                            @if($product->image)
                                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                                    style="width: 60px; height: 60px; object-fit: cover; border-radius: 10px;">
                                            @else
                                                <div
                                                    style="width: 60px; height: 60px; background: #ddd; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-image" style="color: #999;"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td style="padding: 15px; font-weight: 600;">{{ $product->name }}</td>
                                        <td style="padding: 15px;">
                                            <span
                                                style="background: #e94560; color: white; padding: 5px 12px; border-radius: 20px; font-size: 0.85rem;">
                                                {{ ucfirst($product->categorie) }}
                                            </span>
                                        </td>
                                        <td style="padding: 15px;">
                                            <span
                                                style="font-weight: 700; color: #e94560;">{{ number_format($product->price, 2) }}€</span>
                                        </td>
                                        <td style="padding: 15px; text-align: center;">
                                            <div style="display: flex; gap: 8px; justify-content: center;">
                                                {{-- Bouton Voir --}}
                                                <a href="{{ route('produits.show.admin', $product->id) }}"
                                                    style="background: #ffc107; color: white; border: none; padding: 8px 15px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; transition: all 0.3s;"
                                                    onmouseover="this.style.background='#e0a800'"
                                                    onmouseout="this.style.background='#ffc107'">
                                                    <i class="fas fa-eye"></i> Voir
                                                </a>

                                                {{-- Bouton Modifier --}}
                                                <a href="{{ route('produits.edit', $product->id) }}"
                                                    style="background: #007bff; color: white; border: none; padding: 8px 15px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; transition: all 0.3s;"
                                                    onmouseover="this.style.background='#0056b3'"
                                                    onmouseout="this.style.background='#007bff'">
                                                    <i class="fas fa-edit"></i> Modifier
                                                </a>

                                                {{-- Bouton Supprimer avec modale --}}
                                                <button type="button"
                                                    style="background: #dc3545; color: white; border: none; padding: 8px 15px; border-radius: 8px; cursor: pointer; transition: all 0.3s; display: inline-flex; align-items: center; gap: 5px;"
                                                    onmouseover="this.style.background='#c82333'"
                                                    onmouseout="this.style.background='#dc3545'" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal-{{ $product->id }}">
                                                    <i class="fas fa-trash"></i> Supprimer
                                                </button>
                                            </div>

                                            {{-- Modale de confirmation de suppression --}}
                                            <div class="modal fade" id="deleteModal-{{ $product->id }}" tabindex="-1" role="dialog"
                                                aria-labelledby="deleteModalLabel-{{ $product->id }}" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content" style="border-radius: 15px; overflow: hidden;">
                                                        <div class="modal-header"
                                                            style="background: #dc3545; color: white; border: none;">
                                                            <h5 class="modal-title" id="deleteModalLabel-{{ $product->id }}">
                                                                <i class="fas fa-exclamation-triangle"></i> Confirmation de
                                                                suppression
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body" style="padding: 30px;">
                                                            <p style="font-size: 1.1rem; margin-bottom: 15px;">
                                                                Êtes-vous sûr de vouloir supprimer le produit :
                                                            </p>
                                                            <p style="font-weight: 700; color: #e94560; font-size: 1.2rem;">
                                                                {{ $product->name }}
                                                            </p>
                                                            <p style="color: #666; margin-top: 15px;">
                                                                Cette action est irréversible !
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer" style="border: none; padding: 20px 30px;">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                                <i class="fas fa-times"></i> Annuler
                                                            </button>
                                                            <form action="{{ route('produits.delete', $product->id) }}"
                                                                method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">
                                                                    <i class="fas fa-trash"></i> Supprimer définitivement
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div style="margin-top: 30px; display: flex; justify-content: center;">
                        {{ $products->links() }}
                    </div>
                @else
                    <div style="text-align: center; padding: 50px;">
                        <i class="fas fa-box-open" style="font-size: 4rem; color: #ccc; margin-bottom: 20px;"></i>
                        <h3 style="color: #666;">Aucun produit</h3>
                        <p style="color: #999;">Ajoutez votre premier produit</p>
                        <a href="{{ route('produits.create') }}" class="btn btn-primary" style="margin-top: 20px;">
                            <i class="fas fa-plus"></i> Ajouter un produit
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection