# Guide d'Authentification et de Gestion des Rôles

## 🔐 Système d'Authentification

Ce projet utilise **Laravel UI** avec une gestion avancée des rôles pour sécuriser l'accès aux différentes parties de l'application.

## 👥 Rôles Disponibles

### 1. **ADMIN** (Administrateur)
- Accès complet à toutes les fonctionnalités
- Gestion des produits (création, modification, suppression)
- Accès à l'espace administrateur
- Gestion des stocks et des catégories

### 2. **USER** (Utilisateur/Client)
- Accès à l'espace client
- Consultation des produits en solde
- Accès à la boutique publique
- Profil personnel

## 🔑 Comptes de Test

### Administrateur
- **Email**: admin@clotheszc.com
- **Mot de passe**: admin123

### Utilisateur Standard
- **Email**: client@clotheszc.com
- **Mot de passe**: client123

## 🛡️ Middlewares de Sécurité

### IsAdmin Middleware
```php
Route::middleware(['auth', 'admin'])->group(function () {
    // Routes réservées aux administrateurs
});
```

**Protection:**
- Vérifie que l'utilisateur est connecté
- Vérifie que l'utilisateur a le rôle ADMIN
- Retourne une erreur 403 si accès non autorisé

### IsUser Middleware
```php
Route::middleware(['auth', 'user'])->group(function () {
    // Routes réservées aux utilisateurs
});
```

**Protection:**
- Vérifie que l'utilisateur est connecté
- Vérifie que l'utilisateur a le rôle USER
- Retourne une erreur 403 si accès non autorisé

## 📍 Routes Protégées

### Routes ADMIN (nécessitent middleware 'admin')
- `/produits/manage` - Gestion des produits
- `/produits/create` - Ajout de produit
- `/produits/{id}/edit` - Modification de produit
- `/produits/{id}/delete` - Suppression de produit
- `/espaceadmin` - Espace administrateur

### Routes USER (nécessitent middleware 'user')
- `/espaceclient` - Espace client avec produits en solde

### Routes Publiques (sans authentification)
- `/` - Page d'accueil
- `/produits` - Boutique
- `/about` - À propos
- `/contact` - Contact

## 🎨 Navigation Conditionnelle

Le menu de navigation s'adapte automatiquement selon le rôle:

### Utilisateur Non Connecté
- Accueil
- Boutique
- À Propos
- Contact
- Connexion
- Inscription

### Utilisateur ADMIN Connecté
- Accueil
- Boutique
- **Gérer Produits**
- **Espace Admin**
- À Propos
- Contact
- Menu Utilisateur (déconnexion)

### Utilisateur USER Connecté
- Accueil
- Boutique
- **Espace Client**
- À Propos
- Contact
- Menu Utilisateur (déconnexion)

## 🔒 Différence: Affichage vs Sécurité

### ⚠️ Important à Comprendre

**Affichage Conditionnel (Menu):**
```blade
@if(Auth::user()->isAdmin())
    <a href="{{ route('espaceadmin') }}">Espace Admin</a>
@endif
```
➡️ Cache simplement le lien dans le menu
➡️ **NE PROTÈGE PAS** l'accès direct à l'URL

**Sécurité Réelle (Middleware):**
```php
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/espaceadmin', ...);
});
```
➡️ Bloque réellement l'accès à la route
➡️ Retourne une erreur 403 si tentative d'accès non autorisé

### 💡 Règle d'Or
**Toujours protéger les routes sensibles avec des middlewares!**
Le masquage visuel seul n'est pas une sécurité suffisante.

## 📝 Inscription d'un Nouvel Utilisateur

Lors de l'inscription via `/register`:
1. Le formulaire collecte: nom, email, mot de passe
2. Le RegisterController crée automatiquement l'utilisateur
3. **Le rôle USER est attribué par défaut**
4. L'utilisateur est connecté automatiquement
5. Redirection vers la page d'accueil

## 🔧 Configuration Technique

### Enregistrement des Middlewares
Les middlewares sont enregistrés dans `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'admin' => \App\Http\Middleware\IsAdmin::class,
        'user' => \App\Http\Middleware\IsUser::class,
    ]);
})
```

### Méthodes Helper sur le Modèle User

```php
// Vérifier si l'utilisateur est admin
Auth::user()->isAdmin(); // true/false

// Vérifier si l'utilisateur est un utilisateur standard
Auth::user()->isUser(); // true/false
```

## 🎯 Cas d'Usage

### Scénario 1: Utilisateur essaie d'accéder à l'espace admin
1. Utilisateur non-admin clique sur un lien caché
2. Middleware `IsAdmin` intercepte la requête
3. Vérifie le rôle de l'utilisateur
4. Retourne erreur 403: "Accès interdit. Vous devez être administrateur."

### Scénario 2: Utilisateur non connecté essaie d'accéder à l'espace client
1. Middleware `auth` intercepte la requête
2. Redirige vers `/login` avec message d'erreur
3. Après connexion réussie avec rôle USER
4. Middleware `IsUser` autorise l'accès

### Scénario 3: Nouvelle inscription
1. Remplissage du formulaire d'inscription
2. RegisterController crée le compte avec rôle USER
3. Connexion automatique
4. Accès immédiat à l'espace client

## 🚀 Tester le Système

1. **Test Admin:**
   ```
   - Se connecter avec: admin@clotheszc.com / admin123
   - Vérifier l'accès à "Espace Admin" dans le menu
   - Essayer de créer/modifier un produit
   ```

2. **Test User:**
   ```
   - Se connecter avec: client@clotheszc.com / client123
   - Vérifier l'accès à "Espace Client" dans le menu
   - Voir uniquement les produits en solde
   - Essayer d'accéder à /espaceadmin directement → Erreur 403
   ```

3. **Test Inscription:**
   ```
   - Créer un nouveau compte via /register
   - Vérifier que le rôle USER est attribué
   - Accéder à l'espace client
   ```

## 📊 Résumé des Sécurités Mises en Place

✅ Middlewares personnalisés (IsAdmin, IsUser)
✅ Protection des routes sensibles
✅ Attribution automatique du rôle USER à l'inscription
✅ Navigation conditionnelle selon le rôle
✅ Messages d'erreur clairs pour les accès non autorisés
✅ Séparation claire des espaces (Admin / Client)
✅ Gestion sécurisée des sessions utilisateur

---

## 🔍 Commandes Utiles

```bash
# Créer un nouveau middleware
php artisan make:middleware NomDuMiddleware

# Vider le cache des routes
php artisan route:clear

# Voir toutes les routes
php artisan route:list

# Créer un utilisateur via tinker
php artisan tinker
>>> User::create(['name' => 'Test', 'email' => 'test@test.com', 'password' => Hash::make('password'), 'role' => 'USER']);
```
