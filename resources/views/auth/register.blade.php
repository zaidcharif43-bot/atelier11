@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
<section class="section" style="min-height: 90vh; display: flex; align-items: center; background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">
                <div style="background: white; border-radius: 20px; padding: 50px 40px; box-shadow: 0 30px 60px rgba(0,0,0,0.3); animation: slideUp 0.5s ease-out;">
                    
                    <!-- Logo/Icon -->
                    <div style="text-align: center; margin-bottom: 30px;">
                        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                            <i class="fas fa-user-plus" style="font-size: 2rem; color: white;"></i>
                        </div>
                        <h1 style="font-family: 'Playfair Display', serif; color: #1a1a2e; font-size: 2rem; margin-bottom: 10px;">
                            Créer un Compte
                        </h1>
                        <p style="color: #6c757d; font-size: 0.95rem;">
                            Rejoignez ClothesZC aujourd'hui
                        </p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div style="margin-bottom: 25px;">
                            <label for="name" style="display: block; color: #1a1a2e; font-weight: 600; margin-bottom: 8px; font-size: 0.95rem;">
                                <i class="fas fa-user" style="color: #28a745; margin-right: 8px;"></i>Nom Complet
                            </label>
                            <input id="name" type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   autocomplete="name" 
                                   autofocus
                                   style="padding: 15px; border: 2px solid #e9ecef; border-radius: 10px; font-size: 1rem; transition: all 0.3s; width: 100%;"
                                   onfocus="this.style.borderColor='#28a745'; this.style.boxShadow='0 0 0 3px rgba(40,167,69,0.1)'"
                                   onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'">

                            @error('name')
                                <span style="color: #dc3545; font-size: 0.85rem; margin-top: 5px; display: block;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div style="margin-bottom: 25px;">
                            <label for="email" style="display: block; color: #1a1a2e; font-weight: 600; margin-bottom: 8px; font-size: 0.95rem;">
                                <i class="fas fa-envelope" style="color: #28a745; margin-right: 8px;"></i>Adresse Email
                            </label>
                            <input id="email" type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autocomplete="email"
                                   style="padding: 15px; border: 2px solid #e9ecef; border-radius: 10px; font-size: 1rem; transition: all 0.3s; width: 100%;"
                                   onfocus="this.style.borderColor='#28a745'; this.style.boxShadow='0 0 0 3px rgba(40,167,69,0.1)'"
                                   onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'">

                            @error('email')
                                <span style="color: #dc3545; font-size: 0.85rem; margin-top: 5px; display: block;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div style="margin-bottom: 25px;">
                            <label for="password" style="display: block; color: #1a1a2e; font-weight: 600; margin-bottom: 8px; font-size: 0.95rem;">
                                <i class="fas fa-lock" style="color: #28a745; margin-right: 8px;"></i>Mot de Passe
                            </label>
                            <input id="password" type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   name="password" 
                                   required 
                                   autocomplete="new-password"
                                   style="padding: 15px; border: 2px solid #e9ecef; border-radius: 10px; font-size: 1rem; transition: all 0.3s; width: 100%;"
                                   onfocus="this.style.borderColor='#28a745'; this.style.boxShadow='0 0 0 3px rgba(40,167,69,0.1)'"
                                   onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'">

                            @error('password')
                                <span style="color: #dc3545; font-size: 0.85rem; margin-top: 5px; display: block;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div style="margin-bottom: 25px;">
                            <label for="password-confirm" style="display: block; color: #1a1a2e; font-weight: 600; margin-bottom: 8px; font-size: 0.95rem;">
                                <i class="fas fa-lock" style="color: #28a745; margin-right: 8px;"></i>Confirmer le Mot de Passe
                            </label>
                            <input id="password-confirm" type="password" 
                                   class="form-control" 
                                   name="password_confirmation" 
                                   required 
                                   autocomplete="new-password"
                                   style="padding: 15px; border: 2px solid #e9ecef; border-radius: 10px; font-size: 1rem; transition: all 0.3s; width: 100%;"
                                   onfocus="this.style.borderColor='#28a745'; this.style.boxShadow='0 0 0 3px rgba(40,167,69,0.1)'"
                                   onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'">
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                style="width: 100%; padding: 15px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border: none; border-radius: 10px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; margin-bottom: 15px;"
                                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 25px rgba(40,167,69,0.3)'"
                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                            <i class="fas fa-user-plus" style="margin-right: 8px;"></i>S'inscrire
                        </button>

                        <!-- Login Link -->
                        <div style="text-align: center; margin-top: 25px; padding-top: 25px; border-top: 1px solid #e9ecef;">
                            <p style="color: #6c757d; margin-bottom: 10px; font-size: 0.95rem;">
                                Vous avez déjà un compte ?
                            </p>
                            <a href="{{ route('login') }}" 
                               style="color: #1a1a2e; text-decoration: none; font-weight: 600; font-size: 1rem; transition: all 0.3s;"
                               onmouseover="this.style.color='#28a745'"
                               onmouseout="this.style.color='#1a1a2e'">
                                <i class="fas fa-sign-in-alt"></i> Se connecter
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    @keyframes slideUp {
        0% {
            transform: translateY(30px);
            opacity: 0;
        }
        100% {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>
@endsection
