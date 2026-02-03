# ✅ ATELIER 11 - SÉCURISATION DES ROUTES PAR RÔLES - TERMINÉ

## 📋 Ce qui a été réalisé

### 1️⃣ Installation de Laravel UI ✅
```bash
composer require laravel/ui
php artisan ui bootstrap --auth
```

### 2️⃣ Gestion des Rôles ✅

**Migration créée** : `add_role_to_users_table`
- Colonne `role` ajoutée à la table `users`
- Valeur par défaut : `USER`

**Modèle User modifié** :
- Constantes : `USER_ROLE` et `ADMIN_ROLE`
- `role` ajouté dans `$fillable`

**RegisterController** : Attribution automatique du rôle `USER` lors de l'inscription

### 3️⃣ Middlewares de Sécurité ✅

**AdminUserMiddleware** :
- Vérifie que l'utilisateur est connecté
- Vérifie que l'utilisateur a le rôle `ADMIN`
- Redirige vers login si non autorisé

**UserMiddleware** :
- Vérifie que l'utilisateur est connecté
- Vérifie que l'utilisateur a le rôle `USER`
- Redirige vers login si non autorisé

**Configuration** (`bootstrap/app.php`) :
- Alias `adminuser` → AdminUserMiddleware
- Alias `useruser` → UserMiddleware

### 4️⃣ Routes Sécurisées ✅

**Routes ADMIN** (middleware `adminuser`) :
- ✅ `/produits/create` - Ajouter un produit
- ✅ `/produits/{id}/edit` - Modifier un produit
- ✅ `/produits/{id}` (DELETE) - Supprimer un produit
- ✅ `/espaceadmin` - Espace administrateur

**Routes USER** (middleware `useruser`) :
- ✅ `/espaceclient` - Espace client avec produits en solde

**Routes Publiques** (sans middleware) :
- `/` - Page d'accueil
- `/produits` - Liste des produits
- `/categories/{cat}` - Filtrage par catégorie
- `/login` - Connexion
- `/register` - Inscription

### 5️⃣ Vues Créées ✅

**Espace Client** (`espaceclient.blade.php`) :
- Affiche tous les produits en solde (`sale = true`)
- Design en cartes (cards)
- Affichage du pourcentage de réduction
- Badge PROMO et NEW
- Pagination

**Espace Admin** (`espaceadmin.blade.php`) :
- Liste tous les produits dans un tableau
- Actions : Modifier / Supprimer
- Bouton "Ajouter un produit"
- Pagination

---

## 🔐 Comptes de Test

### Administrateur
- **Email** : `admin@test.com`
- **Mot de passe** : `password`
- **Accès** :
  - ✅ Ajouter des produits
  - ✅ Modifier des produits
  - ✅ Supprimer des produits
  - ✅ Espace admin

### Utilisateur Normal
Créez un compte via `/register` :
- **Rôle** : `USER` (automatique)
- **Accès** :
  - ✅ Voir les produits en solde
  - ✅ Espace client
  - ❌ Pas d'accès à la gestion des produits

---

## 🧪 Tester l'Application

### Étape 1 : Démarrer le serveur
```bash
cd c:\Users\dell\OneDrive\Desktop\atelier10-lv\at10
php artisan serve
```

### Étape 2 : Tester les Accès

#### Test Visiteur (non connecté)
1. Allez sur `http://localhost:8000`
2. Essayez d'accéder à `http://localhost:8000/espaceclient`
   - ✅ **Résultat attendu** : Redirection vers `/login`
3. Essayez d'accéder à `http://localhost:8000/espaceadmin`
   - ✅ **Résultat attendu** : Redirection vers `/login`

#### Test Utilisateur USER
1. Inscrivez-vous sur `http://localhost:8000/register`
2. Connectez-vous avec vos identifiants
3. Allez sur `http://localhost:8000/espaceclient`
   - ✅ **Résultat attendu** : Page des produits en solde
4. Essayez d'accéder à `http://localhost:8000/espaceadmin`
   - ✅ **Résultat attendu** : Redirection vers `/login`
5. Essayez d'accéder à `http://localhost:8000/produits/create`
   - ✅ **Résultat attendu** : Redirection vers `/login`

#### Test Administrateur ADMIN
1. Connectez-vous avec :
   - Email: `admin@test.com`
   - Password: `password`
2. Allez sur `http://localhost:8000/espaceadmin`
   - ✅ **Résultat attendu** : Page de gestion des produits
3. Allez sur `http://localhost:8000/produits/create`
   - ✅ **Résultat attendu** : Formulaire d'ajout de produit
4. Essayez d'accéder à `http://localhost:8000/espaceclient`
   - ✅ **Résultat attendu** : Redirection (pas un USER)

---

## 📁 Fichiers Créés/Modifiés

### Migrations
- ✅ `2026_02_02_134228_add_role_to_users_table.php`

### Modèles
- ✅ `app/Models/User.php` (constantes de rôles + fillable)

### Middlewares
- ✅ `app/Http/Middleware/AdminUserMiddleware.php`
- ✅ `app/Http/Middleware/UserMiddleware.php`

### Contrôleurs
- ✅ `app/Http/Controllers/Auth/RegisterController.php` (rôle par défaut)
- ✅ `app/Http/Controllers/ProduitController.php` (espaceclient + espaceadmin)

### Routes
- ✅ `routes/web.php` (routes sécurisées avec middlewares)

### Configuration
- ✅ `bootstrap/app.php` (alias middlewares)

### Vues
- ✅ `resources/views/espaceclient.blade.php`
- ✅ `resources/views/espaceadmin.blade.php`
- ✅ `resources/views/home.blade.php` (Laravel UI)
- ✅ `resources/views/layouts/app.blade.php` (Laravel UI)
- ✅ `resources/views/auth/login.blade.php` (Laravel UI)
- ✅ `resources/views/auth/register.blade.php` (Laravel UI)

---

## 🎯 Fonctionnalités Implémentées

### Authentification
- ✅ Inscription avec rôle USER par défaut
- ✅ Connexion
- ✅ Déconnexion
- ✅ Mot de passe oublié (Laravel UI)

### Espace Client (USER)
- ✅ Affichage des produits en solde uniquement
- ✅ Cartes produits avec :
  - Image
  - Nom et catégorie
  - Prix actuel et ancien prix
  - Pourcentage de réduction
  - Stock disponible
  - Badge PROMO et NEW
- ✅ Pagination (6 produits par page)
- ✅ Lien vers les détails du produit

### Espace Admin (ADMIN)
- ✅ Liste de tous les produits en tableau
- ✅ Actions : Modifier et Supprimer
- ✅ Bouton "Ajouter un produit"
- ✅ Pagination (10 produits par page)
- ✅ Affichage de l'image, nom, catégorie, prix, stock

### Sécurité
- ✅ Middlewares sur toutes les routes sensibles
- ✅ Vérification du rôle utilisateur
- ✅ Redirection automatique vers login si non autorisé
- ✅ Protection CSRF sur les formulaires

---

## 💡 Points Importants

### Sécurité des Routes
⚠️ **Masquer un lien dans le menu ≠ Sécuriser une page**

La vraie sécurité se fait avec les **middlewares** sur les routes :
```php
Route::middleware(['adminuser'])->group(function () {
    // Routes sécurisées ADMIN
});

Route::get('/espaceclient', ...)->middleware('useruser');
```

### Différence entre AUTH et RÔLES

**Auth::check()** : Vérifie si l'utilisateur est connecté
**Auth::user()->role** : Récupère le rôle de l'utilisateur

```php
// Vérifier si connecté
@if(Auth::check())
    // Utilisateur connecté
@endif

// Vérifier le rôle
@if(Auth::user()->role === 'ADMIN')
    // Utilisateur admin
@endif
```

---

## 🔧 Commandes Utiles

### Créer un admin manuellement
```bash
php artisan tinker
```
Puis :
```php
$user = new App\Models\User();
$user->name = 'Admin Test';
$user->email = 'admin2@test.com';
$user->password = bcrypt('password');
$user->role = 'ADMIN';
$user->save();
```

### Changer le rôle d'un utilisateur existant
```bash
php artisan tinker
```
Puis :
```php
$user = App\Models\User::where('email', 'user@test.com')->first();
$user->role = 'ADMIN';
$user->save();
```

### Voir tous les utilisateurs
```bash
php artisan tinker
```
Puis :
```php
App\Models\User::all(['id', 'name', 'email', 'role']);
```

---

## ✨ Prochaines Étapes (Optionnel)

### Améliorations possibles :
1. **Menu dynamique** : Adapter le menu selon le rôle
2. **Page d'accueil après login** : Rediriger vers l'espace approprié
3. **Profil utilisateur** : Permettre de modifier ses informations
4. **Historique des commandes** : Pour les utilisateurs
5. **Statistiques** : Dashboard admin avec graphiques
6. **Gestion des utilisateurs** : CRUD utilisateurs pour admin
7. **Notifications** : Email de bienvenue, confirmation de commande
8. **Panier** : Ajouter au panier, passer commande

---

## 🎉 Résumé

✅ **Atelier 11 terminé avec succès !**

Vous avez maintenant :
- Un système d'authentification complet
- Une gestion des rôles (USER / ADMIN)
- Des routes sécurisées avec middlewares
- Un espace client avec produits en solde
- Un espace admin pour gérer les produits

**Testez maintenant votre application et profitez de votre système sécurisé !** 🚀
