@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<section class="section" style="min-height: 90vh; display: flex; align-items: center; background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div style="background: white; border-radius: 20px; padding: 50px 40px; box-shadow: 0 30px 60px rgba(0,0,0,0.3); animation: slideUp 0.5s ease-out;">
                    
                    <!-- Logo/Icon -->
                    <div style="text-align: center; margin-bottom: 30px;">
                        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #e94560 0%, #ff6b6b 100%); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                            <i class="fas fa-user" style="font-size: 2rem; color: white;"></i>
                        </div>
                        <h1 style="font-family: 'Playfair Display', serif; color: #1a1a2e; font-size: 2rem; margin-bottom: 10px;">
                            Connexion
                        </h1>
                        <p style="color: #6c757d; font-size: 0.95rem;">
                            Bienvenue sur ClothesZC
                        </p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div style="margin-bottom: 25px;">
                            <label for="email" style="display: block; color: #1a1a2e; font-weight: 600; margin-bottom: 8px; font-size: 0.95rem;">
                                <i class="fas fa-envelope" style="color: #e94560; margin-right: 8px;"></i>Adresse Email
                            </label>
                            <input id="email" type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autocomplete="email" 
                                   autofocus
                                   style="padding: 15px; border: 2px solid #e9ecef; border-radius: 10px; font-size: 1rem; transition: all 0.3s; width: 100%;"
                                   onfocus="this.style.borderColor='#e94560'; this.style.boxShadow='0 0 0 3px rgba(233,69,96,0.1)'"
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
                                <i class="fas fa-lock" style="color: #e94560; margin-right: 8px;"></i>Mot de Passe
                            </label>
                            <input id="password" type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   name="password" 
                                   required 
                                   autocomplete="current-password"
                                   style="padding: 15px; border: 2px solid #e9ecef; border-radius: 10px; font-size: 1rem; transition: all 0.3s; width: 100%;"
                                   onfocus="this.style.borderColor='#e94560'; this.style.boxShadow='0 0 0 3px rgba(233,69,96,0.1)'"
                                   onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'">

                            @error('password')
                                <span style="color: #dc3545; font-size: 0.85rem; margin-top: 5px; display: block;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div style="margin-bottom: 25px;">
                            <label style="display: flex; align-items: center; cursor: pointer;">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} 
                                       style="width: 20px; height: 20px; margin-right: 10px; cursor: pointer;">
                                <span style="color: #6c757d; font-size: 0.95rem;">Se souvenir de moi</span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                style="width: 100%; padding: 15px; background: linear-gradient(135deg, #e94560 0%, #ff6b6b 100%); color: white; border: none; border-radius: 10px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; margin-bottom: 15px;"
                                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 25px rgba(233,69,96,0.3)'"
                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                            <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i>Se Connecter
                        </button>

                        <!-- Forgot Password -->
                        @if (Route::has('password.request'))
                            <div style="text-align: center; margin-top: 20px;">
                                <a href="{{ route('password.request') }}" 
                                   style="color: #e94560; text-decoration: none; font-size: 0.9rem; transition: all 0.3s;"
                                   onmouseover="this.style.color='#ff6b6b'"
                                   onmouseout="this.style.color='#e94560'">
                                    <i class="fas fa-question-circle"></i> Mot de passe oublié ?
                                </a>
                            </div>
                        @endif

                        <!-- Register Link -->
                        @if (Route::has('register'))
                            <div style="text-align: center; margin-top: 25px; padding-top: 25px; border-top: 1px solid #e9ecef;">
                                <p style="color: #6c757d; margin-bottom: 10px; font-size: 0.95rem;">
                                    Pas encore de compte ?
                                </p>
                                <a href="{{ route('register') }}" 
                                   style="color: #1a1a2e; text-decoration: none; font-weight: 600; font-size: 1rem; transition: all 0.3s;"
                                   onmouseover="this.style.color='#e94560'"
                                   onmouseout="this.style.color='#1a1a2e'">
                                    <i class="fas fa-user-plus"></i> Créer un compte
                                </a>
                            </div>
                        @endif
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
