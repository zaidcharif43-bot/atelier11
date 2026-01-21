@extends('layouts.app')

@section('title', 'Ajouter un Produit - ClothesZC')

@section('styles')
    <style>
        .form-section {
            padding: 140px 0 80px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
        }

        .form-container {
            max-width: 800px;
            margin: 0 auto;
            background: var(--white);
            border-radius: 20px;
            box-shadow: var(--shadow);
            padding: 50px;
        }

        .form-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .form-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .form-header p {
            color: var(--gray);
            font-size: 1.1rem;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-group label .required {
            color: var(--accent);
        }

        .form-control {
            width: 100%;
            padding: 14px 18px;
            font-size: 1rem;
            border: 2px solid var(--gray-light);
            border-radius: 12px;
            transition: var(--transition);
            font-family: 'Raleway', sans-serif;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(233, 69, 96, 0.1);
        }

        .form-control::placeholder {
            color: var(--gray);
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-row-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .checkbox-group {
            display: flex;
            gap: 30px;
            margin-top: 10px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .checkbox-item input[type="checkbox"] {
            width: 20px;
            height: 20px;
            accent-color: var(--accent);
            cursor: pointer;
        }

        .checkbox-item label {
            margin: 0;
            cursor: pointer;
        }

        .file-upload {
            position: relative;
            border: 2px dashed var(--gray-light);
            border-radius: 12px;
            padding: 40px;
            text-align: center;
            transition: var(--transition);
            cursor: pointer;
        }

        .file-upload:hover {
            border-color: var(--accent);
            background: rgba(233, 69, 96, 0.02);
        }

        .file-upload input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
        }

        .file-upload i {
            font-size: 3rem;
            color: var(--gray);
            margin-bottom: 15px;
        }

        .file-upload p {
            color: var(--gray);
            margin-bottom: 5px;
        }

        .file-upload .file-types {
            font-size: 0.85rem;
            color: var(--gray);
        }

        .btn-submit {
            width: 100%;
            padding: 18px;
            font-size: 1.1rem;
            margin-top: 20px;
        }

        /* Messages Flash */
        .alert {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert i {
            font-size: 1.2rem;
        }

        /* Validation Errors */
        .error-message {
            color: var(--accent);
            font-size: 0.85rem;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .error-message i {
            font-size: 0.8rem;
        }

        .form-control.is-invalid {
            border-color: var(--accent);
        }

        @media (max-width: 768px) {
            .form-container {
                padding: 30px 20px;
                margin: 0 15px;
            }

            .form-row,
            .form-row-3 {
                grid-template-columns: 1fr;
            }

            .checkbox-group {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
@endsection

@section('content')
    <section class="form-section">
        <div class="container">
            <div class="form-container">
                <div class="form-header">
                    <h1><i class="fas fa-plus-circle" style="color: var(--accent);"></i> Ajouter un Produit</h1>
                    <p>Remplissez le formulaire pour ajouter un nouveau produit à la boutique</p>
                </div>

                {{-- Message de succès --}}
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Affichage des erreurs de validation --}}
                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>
                            <strong>Veuillez corriger les erreurs suivantes :</strong>
                            <ul style="margin: 10px 0 0 20px;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form action="{{ route('produits.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Nom du produit --}}
                    <div class="form-group">
                        <label for="name">Nom du produit <span class="required">*</span></label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                            placeholder="Ex: Robe d'été fleurie" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Catégorie et Prix --}}
                    <div class="form-row">
                        <div class="form-group">
                            <label for="categorie">Catégorie <span class="required">*</span></label>
                            <input type="text" id="categorie" name="categorie"
                                class="form-control @error('categorie') is-invalid @enderror"
                                placeholder="Ex: Femme, Homme, Enfant..." value="{{ old('categorie') }}"
                                list="categories-list" required>
                            <datalist id="categories-list">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}">
                                @endforeach
                            </datalist>
                            @error('categorie')
                                <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="price">Prix (€) <span class="required">*</span></label>
                            <input type="number" id="price" name="price"
                                class="form-control @error('price') is-invalid @enderror" placeholder="Ex: 49.99"
                                value="{{ old('price') }}" step="0.01" min="0" required>
                            @error('price')
                                <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Ancien prix, Note, Stock --}}
                    <div class="form-row-3">
                        <div class="form-group">
                            <label for="old_price">Ancien prix (€)</label>
                            <input type="number" id="old_price" name="old_price"
                                class="form-control @error('old_price') is-invalid @enderror" placeholder="Ex: 69.99"
                                value="{{ old('old_price') }}" step="0.01" min="0">
                            @error('old_price')
                                <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="rating">Note (0-5)</label>
                            <input type="number" id="rating" name="rating"
                                class="form-control @error('rating') is-invalid @enderror" placeholder="Ex: 4.5"
                                value="{{ old('rating') }}" step="0.1" min="0" max="5">
                            @error('rating')
                                <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input type="number" id="stock" name="stock"
                                class="form-control @error('stock') is-invalid @enderror" placeholder="Ex: 50"
                                value="{{ old('stock') }}" min="0">
                            @error('stock')
                                <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="Décrivez le produit en détail...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Caractéristiques --}}
                    <div class="form-group">
                        <label for="features">Caractéristiques</label>
                        <textarea id="features" name="features" class="form-control @error('features') is-invalid @enderror"
                            placeholder="Entrez les caractéristiques séparées par des virgules ou des nouvelles lignes...&#10;Ex: 100% Coton, Lavable en machine, Made in France"
                            style="min-height: 100px;">{{ old('features') }}</textarea>
                        @error('features')
                            <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Upload Image --}}
                    <div class="form-group">
                        <label>Image du produit</label>
                        <div class="file-upload">
                            <input type="file" id="image" name="image"
                                accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p><strong>Cliquez pour télécharger</strong> ou glissez-déposez</p>
                            <span class="file-types">JPEG, PNG, JPG, GIF, WEBP (max. 2 Mo)</span>
                        </div>
                        @error('image')
                            <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Options (Nouveau, Promotion) --}}
                    <div class="form-group">
                        <label>Options</label>
                        <div class="checkbox-group">
                            <div class="checkbox-item">
                                <input type="checkbox" id="new" name="new" value="1" {{ old('new') ? 'checked' : '' }}>
                                <label for="new"><i class="fas fa-sparkles" style="color: var(--accent);"></i> Nouveau
                                    produit</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="sale" name="sale" value="1" {{ old('sale') ? 'checked' : '' }}>
                                <label for="sale"><i class="fas fa-tag" style="color: var(--gold);"></i> En
                                    promotion</label>
                            </div>
                        </div>
                    </div>

                    {{-- Bouton Soumettre --}}
                    <button type="submit" class="btn btn-primary btn-submit">
                        <i class="fas fa-plus"></i> Ajouter le produit
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        // Afficher le nom du fichier sélectionné
        document.getElementById('image').addEventListener('change', function (e) {
            const fileName = e.target.files[0]?.name;
            const uploadDiv = this.parentElement;

            if (fileName) {
                uploadDiv.querySelector('p').innerHTML = '<strong>' + fileName + '</strong>';
                uploadDiv.style.borderColor = 'var(--accent)';
                uploadDiv.style.background = 'rgba(233, 69, 96, 0.05)';
            }
        });
    </script>
@endsection