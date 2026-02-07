<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug Images</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .product { background: white; padding: 15px; margin: 10px 0; border-radius: 8px; }
        .product h3 { margin: 0 0 10px 0; color: #333; }
        .product p { margin: 5px 0; color: #666; }
        .product img { max-width: 200px; margin-top: 10px; border: 2px solid #ddd; }
        .url { word-break: break-all; font-family: monospace; background: #f0f0f0; padding: 5px; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <h1>Debug Images - ClothesZC</h1>
    <p>Total produits: {{ $produits->count() }}</p>
    
    @foreach($produits as $produit)
    <div class="product">
        <h3>{{ $produit->name }} (ID: {{ $produit->id }})</h3>
        <p><strong>Colonne 'image' en DB:</strong> <span class="url">{{ $produit->image }}</span></p>
        <p><strong>Accesseur 'image_url':</strong> <span class="url">{{ $produit->image_url }}</span></p>
        <p><strong>Catégorie:</strong> {{ $produit->categorie }}</p>
        <p><strong>Prix:</strong> {{ $produit->price }}€</p>
        
        <img src="{{ $produit->image_url }}" alt="{{ $produit->name }}" 
             onerror="this.style.border='2px solid red'; this.alt='❌ ERREUR CHARGEMENT'">
    </div>
    @endforeach
    
    <hr>
    <h2>Test Images Externes</h2>
    <div class="product">
        <h3>Test Unsplash Direct</h3>
        <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800&q=80" alt="Test Unsplash">
    </div>
    
    <div class="product">
        <h3>Test Logo Local</h3>
        <img src="{{ asset('logojpeg.jpeg') }}" alt="Logo">
    </div>
</body>
</html>
