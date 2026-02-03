@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<section class="section" style="min-height: 80vh; display: flex; align-items: center; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <!-- Message de Bienvenue -->
                <div style="background: white; border-radius: 20px; padding: 50px; box-shadow: 0 20px 60px rgba(0,0,0,0.1); margin-bottom: 30px; text-align: center;">
                    <div style="margin-bottom: 30px;">
                        <i class="fas fa-check-circle" style="font-size: 4rem; color: #28a745; animation: scaleIn 0.5s ease-out;"></i>
                    </div>
                    
                    <h1 style="font-family: 'Playfair Display', serif; color: #1a1a2e; font-size: 2.5rem; margin-bottom: 15px;">
                        🎉 Bienvenue, {{ Auth::user()->name }} !
                    </h1>
                    
                    <p style="color: #6c757d; font-size: 1.1rem; margin-bottom: 10px;">
                        Vous êtes connecté avec succès
                    </p>
                    
                    <div style="display: inline-block; background: linear-gradient(135deg, #e94560 0%, #ff6b6b 100%); color: white; padding: 8px 20px; border-radius: 25px; font-size: 0.9rem; font-weight: 600; margin-top: 10px;">
                        {{ Auth::user()->role }}
                    </div>
                    
                    @if (session('status'))
                        <div style="margin-top: 20px; padding: 15px; background: #d4edda; border-left: 4px solid #28a745; border-radius: 8px; color: #155724;">
                            <i class="fas fa-info-circle"></i> {{ session('status') }}
                        </div>
                    @endif
                </div>

                <!-- Actions Rapides -->
                <div class="row">
                    @if(Auth::user()->isAdmin())
                        <!-- Actions Admin -->
                        <div class="col-md-6 mb-4">
                            <a href="{{ route('espaceadmin') }}" style="text-decoration: none;">
                                <div style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); border-radius: 15px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: all 0.3s; cursor: pointer; height: 100%;" 
                                     onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 20px 40px rgba(0,0,0,0.2)'" 
                                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.1)'">
                                    <i class="fas fa-user-shield" style="font-size: 2.5rem; color: #e94560; margin-bottom: 15px;"></i>
                                    <h3 style="color: white; font-size: 1.5rem; margin-bottom: 10px;">Espace Admin</h3>
                                    <p style="color: #b0b0b0; font-size: 0.95rem;">Gérer tous les produits et le contenu du site</p>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <a href="{{ route('produits.manage') }}" style="text-decoration: none;">
                                <div style="background: linear-gradient(135deg, #e94560 0%, #ff6b6b 100%); border-radius: 15px; padding: 30px; box-shadow: 0 10px 30px rgba(233,69,96,0.3); transition: all 0.3s; cursor: pointer; height: 100%;" 
                                     onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 20px 40px rgba(233,69,96,0.4)'" 
                                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(233,69,96,0.3)'">
                                    <i class="fas fa-boxes" style="font-size: 2.5rem; color: white; margin-bottom: 15px;"></i>
                                    <h3 style="color: white; font-size: 1.5rem; margin-bottom: 10px;">Gérer Produits</h3>
                                    <p style="color: rgba(255,255,255,0.9); font-size: 0.95rem;">Ajouter, modifier ou supprimer des produits</p>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <a href="{{ route('produits.create') }}" style="text-decoration: none;">
                                <div style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-radius: 15px; padding: 30px; box-shadow: 0 10px 30px rgba(40,167,69,0.3); transition: all 0.3s; cursor: pointer; height: 100%;" 
                                     onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 20px 40px rgba(40,167,69,0.4)'" 
                                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(40,167,69,0.3)'">
                                    <i class="fas fa-plus-circle" style="font-size: 2.5rem; color: white; margin-bottom: 15px;"></i>
                                    <h3 style="color: white; font-size: 1.5rem; margin-bottom: 10px;">Ajouter Produit</h3>
                                    <p style="color: rgba(255,255,255,0.9); font-size: 0.95rem;">Créer un nouveau produit dans la boutique</p>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <a href="{{ route('produits.index') }}" style="text-decoration: none;">
                                <div style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); border-radius: 15px; padding: 30px; box-shadow: 0 10px 30px rgba(108,117,125,0.3); transition: all 0.3s; cursor: pointer; height: 100%;" 
                                     onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 20px 40px rgba(108,117,125,0.4)'" 
                                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(108,117,125,0.3)'">
                                    <i class="fas fa-store" style="font-size: 2.5rem; color: white; margin-bottom: 15px;"></i>
                                    <h3 style="color: white; font-size: 1.5rem; margin-bottom: 10px;">Voir Boutique</h3>
                                    <p style="color: rgba(255,255,255,0.9); font-size: 0.95rem;">Parcourir le catalogue public</p>
                                </div>
                            </a>
                        </div>
                    @elseif(Auth::user()->isUser())
                        <!-- Actions User -->
                        <div class="col-md-6 mb-4">
                            <a href="{{ route('espaceclient') }}" style="text-decoration: none;">
                                <div style="background: linear-gradient(135deg, #e94560 0%, #ff6b6b 100%); border-radius: 15px; padding: 30px; box-shadow: 0 10px 30px rgba(233,69,96,0.3); transition: all 0.3s; cursor: pointer; height: 100%;" 
                                     onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 20px 40px rgba(233,69,96,0.4)'" 
                                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(233,69,96,0.3)'">
                                    <i class="fas fa-fire" style="font-size: 2.5rem; color: white; margin-bottom: 15px;"></i>
                                    <h3 style="color: white; font-size: 1.5rem; margin-bottom: 10px;">Espace Client</h3>
                                    <p style="color: rgba(255,255,255,0.9); font-size: 0.95rem;">Découvrez nos produits en promotion !</p>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <a href="{{ route('produits.index') }}" style="text-decoration: none;">
                                <div style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); border-radius: 15px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: all 0.3s; cursor: pointer; height: 100%;" 
                                     onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 20px 40px rgba(0,0,0,0.2)'" 
                                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.1)'">
                                    <i class="fas fa-shopping-bag" style="font-size: 2.5rem; color: #e94560; margin-bottom: 15px;"></i>
                                    <h3 style="color: white; font-size: 1.5rem; margin-bottom: 10px;">Boutique</h3>
                                    <p style="color: #b0b0b0; font-size: 0.95rem;">Explorer tous nos produits</p>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <a href="{{ route('home') }}" style="text-decoration: none;">
                                <div style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); border-radius: 15px; padding: 30px; box-shadow: 0 10px 30px rgba(108,117,125,0.3); transition: all 0.3s; cursor: pointer; height: 100%;" 
                                     onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 20px 40px rgba(108,117,125,0.4)'" 
                                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(108,117,125,0.3)'">
                                    <i class="fas fa-home" style="font-size: 2.5rem; color: white; margin-bottom: 15px;"></i>
                                    <h3 style="color: white; font-size: 1.5rem; margin-bottom: 10px;">Accueil</h3>
                                    <p style="color: rgba(255,255,255,0.9); font-size: 0.95rem;">Retour à la page principale</p>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <a href="{{ route('about') }}" style="text-decoration: none;">
                                <div style="background: linear-gradient(135deg, #d4af37 0%, #f4d03f 100%); border-radius: 15px; padding: 30px; box-shadow: 0 10px 30px rgba(212,175,55,0.3); transition: all 0.3s; cursor: pointer; height: 100%;" 
                                     onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 20px 40px rgba(212,175,55,0.4)'" 
                                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(212,175,55,0.3)'">
                                    <i class="fas fa-info-circle" style="font-size: 2.5rem; color: white; margin-bottom: 15px;"></i>
                                    <h3 style="color: white; font-size: 1.5rem; margin-bottom: 10px;">À Propos</h3>
                                    <p style="color: rgba(255,255,255,0.9); font-size: 0.95rem;">En savoir plus sur nous</p>
                                </div>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    @keyframes scaleIn {
        0% {
            transform: scale(0);
            opacity: 0;
        }
        50% {
            transform: scale(1.1);
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }
</style>
@endsection
