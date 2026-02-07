@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="avatar-circle mx-auto" style="width: 100px; height: 100px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 2.5rem; font-weight: bold;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    </div>
                    <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                    <p class="text-muted small mb-3">{{ Auth::user()->email }}</p>
                    <span class="badge bg-{{ Auth::user()->role === 'admin' ? 'danger' : 'primary' }}">
                        {{ ucfirst(Auth::user()->role) }}
                    </span>
                </div>
            </div>

            <div class="card shadow-sm mt-3">
                <div class="list-group list-group-flush">
                    <a href="#informations" class="list-group-item list-group-item-action active">
                        <i class="fas fa-user me-2"></i> Informations
                    </a>
                    <a href="#password" class="list-group-item list-group-item-action">
                        <i class="fas fa-lock me-2"></i> Mot de passe
                    </a>
                    <a href="#danger" class="list-group-item list-group-item-action text-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i> Zone dangereuse
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Informations personnelles -->
            <div class="card shadow-sm mb-4" id="informations">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-edit text-primary me-2"></i>
                        Informations personnelles
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nom complet</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Adresse email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Rôle</label>
                            <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" disabled>
                            <small class="text-muted">Le rôle ne peut pas être modifié</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Membre depuis</label>
                            <input type="text" class="form-control" value="{{ $user->created_at->format('d/m/Y') }}" disabled>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Enregistrer les modifications
                        </button>
                    </form>
                </div>
            </div>

            <!-- Changer le mot de passe -->
            <div class="card shadow-sm mb-4" id="password">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-key text-warning me-2"></i>
                        Changer le mot de passe
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Mot de passe actuel</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                   id="current_password" name="current_password" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Nouveau mot de passe</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Minimum 8 caractères</small>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-lock me-2"></i>Modifier le mot de passe
                        </button>
                    </form>
                </div>
            </div>

            <!-- Zone dangereuse -->
            <div class="card shadow-sm border-danger" id="danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Zone dangereuse
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        Une fois votre compte supprimé, toutes vos données seront définitivement effacées. 
                        Cette action est irréversible.
                    </p>

                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        <i class="fas fa-trash-alt me-2"></i>Supprimer mon compte
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteAccountModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Confirmer la suppression
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('profile.destroy') }}" method="POST">
                @csrf
                @method('DELETE')
                
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Attention !</strong> Cette action est irréversible.
                    </div>
                    
                    <p>Êtes-vous sûr de vouloir supprimer votre compte ? Toutes vos données seront définitivement perdues.</p>
                    
                    <div class="mb-3">
                        <label for="delete_password" class="form-label">Confirmez avec votre mot de passe</label>
                        <input type="password" class="form-control" id="delete_password" name="password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Oui, supprimer mon compte</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .list-group-item.active {
        background-color: var(--primary);
        border-color: var(--primary);
    }
    
    .list-group-item-action:hover {
        background-color: var(--gray-light);
    }
</style>

<script>
// Smooth scroll pour les ancres
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
            
            // Mettre à jour l'élément actif
            document.querySelectorAll('.list-group-item').forEach(item => {
                item.classList.remove('active');
            });
            this.classList.add('active');
        }
    });
});
</script>
@endsection
