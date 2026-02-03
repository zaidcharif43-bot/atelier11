@extends('layouts.app')

@section('title', 'Espace Admin')

@section('content')
<div class="container" style="margin-top: 30px;">
    <div class="row">
        <div class="col-12">
            <h1 style="text-align: center; margin-bottom: 30px; color: #1a1a2e; font-family: 'Playfair Display', serif;">
                🔧 Espace Administrateur
            </h1>
            
            <div style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                    <h2 style="margin: 0; font-family: 'Playfair Display', serif;">
                        📦 Gestion des Produits
                    </h2>
                    <a href="{{ route('produits.create') }}" class="btn btn-success" style="padding: 12px 30px; border-radius: 25px; font-weight: 700;">
                        <i class="fas fa-plus"></i> Ajouter un produit
                    </a>
                </div>
                
                @if(count($produits) > 0)
                    <p style="margin-bottom: 20px; color: #666; font-size: 16px;">
                        Total: <strong>{{ $produits->total() }}</strong> produit(s)
                    </p>
                    
                    <div class="table-responsive">
                        <table class="table" style="border-collapse: collapse;">
                            <thead style="background: #1a1a2e; color: white;">
                                <tr>
                                    <th style="padding: 15px; border-radius: 10px 0 0 0;">ID</th>
                                    <th style="padding: 15px;">Image</th>
                                    <th style="padding: 15px;">Nom</th>
                                    <th style="padding: 15px;">Catégorie</th>
                                    <th style="padding: 15px;">Prix</th>
                                    <th style="padding: 15px;">Stock</th>
                                    <th style="padding: 15px; border-radius: 0 10px 0 0;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($produits as $produit)
                                    <tr style="border-bottom: 1px solid #eee; transition: background 0.3s;" 
                                        onmouseover="this.style.background='#f8f9fa'" 
                                        onmouseout="this.style.background='white'">
                                        <td style="padding: 15px;">{{ $produit->id }}</td>
                                        <td style="padding: 15px;">
                                            <img src="{{ $produit->image_url }}" 
                                                 alt="{{ $produit->name }}"
                                                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 10px;">
                                        </td>
                                        <td style="padding: 15px; font-weight: 600;">{{ $produit->name }}</td>
                                        <td style="padding: 15px;">
                                            <span style="background: #e94560; color: white; padding: 5px 12px; border-radius: 20px; font-size: 0.85rem;">
                                                {{ ucfirst($produit->categorie) }}
                                            </span>
                                        </td>
                                        <td style="padding: 15px;">
                                            <span style="font-weight: 700; color: #e94560;">{{ number_format($produit->price, 2) }}€</span>
                                            @if($produit->old_price)
                                                <br>
                                                <span style="text-decoration: line-through; color: #999; font-size: 0.85rem;">
                                                    {{ number_format($produit->old_price, 2) }}€
                                                </span>
                                            @endif
                                        </td>
                                        <td style="padding: 15px;">
                                            @if($produit->stock > 0)
                                                <span style="color: #28a745; font-weight: 600;">
                                                    {{ $produit->stock }}
                                                </span>
                                            @else
                                                <span style="color: #dc3545; font-weight: 600;">
                                                    {{ $produit->stock }}
                                                </span>
                                            @endif
                                        </td>
                                        <td style="padding: 15px;">
                                            <div style="display: flex; gap: 5px;">
                                                <a href="{{ route('produits.edit', $produit->id) }}" 
                                                   class="btn btn-sm btn-warning" 
                                                   style="border-radius: 8px; padding: 5px 12px;">
                                                    ✏️ Modifier
                                                </a>
                                                <form action="{{ route('produits.delete', $produit->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-danger" 
                                                            style="border-radius: 8px; padding: 5px 12px;"
                                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                                                        🗑️ Supprimer
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div style="margin-top: 25px; display: flex; justify-content: center;">
                        {{ $produits->links('pagination::bootstrap-4') }}
                    </div>
                @else
                    <div class="alert alert-info" style="text-align: center; padding: 40px;">
                        Aucun produit trouvé.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
