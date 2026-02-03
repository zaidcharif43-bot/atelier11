# 🧪 Scénarios de Test - Authentification et Rôles

## ✅ Test 1: Inscription d'un Nouvel Utilisateur

### Objectif
Vérifier que l'inscription fonctionne et attribue le rôle USER par défaut

### Étapes
1. Aller sur `/register`
2. Remplir le formulaire:
   - Nom: Test User
   - Email: test@example.com
   - Mot de passe: password
   - Confirmation: password
3. Cliquer sur "S'inscrire"

### Résultat Attendu
✅ Utilisateur créé avec rôle USER
✅ Connexion automatique
✅ Redirection vers la page d'accueil
✅ Menu affiche "Espace Client"
✅ Menu n'affiche PAS "Espace Admin" ou "Gérer Produits"

---

## ✅ Test 2: Connexion en tant qu'ADMIN

### Objectif
Vérifier que l'administrateur a accès à toutes les fonctionnalités

### Étapes
1. Aller sur `/login`
2. Se connecter avec:
   - Email: admin@clotheszc.com
   - Mot de passe: admin123
3. Cliquer sur "Se connecter"

### Résultat Attendu
✅ Connexion réussie
✅ Menu affiche "Gérer Produits"
✅ Menu affiche "Espace Admin"
✅ Menu n'affiche PAS "Espace Client"
✅ Accès possible à `/espaceadmin`
✅ Accès possible à `/produits/manage`
✅ Accès possible à `/produits/create`

### Test Négatif
❌ Essayer d'accéder à `/espaceclient` → Erreur 403

---

## ✅ Test 3: Connexion en tant qu'USER

### Objectif
Vérifier que l'utilisateur standard a accès uniquement à son espace

### Étapes
1. Aller sur `/login`
2. Se connecter avec:
   - Email: client@clotheszc.com
   - Mot de passe: client123
3. Cliquer sur "Se connecter"

### Résultat Attendu
✅ Connexion réussie
✅ Menu affiche "Espace Client"
✅ Menu n'affiche PAS "Gérer Produits"
✅ Menu n'affiche PAS "Espace Admin"
✅ Accès possible à `/espaceclient`
✅ Voir uniquement les produits en solde dans l'espace client

### Test Négatif
❌ Essayer d'accéder à `/espaceadmin` → Erreur 403
❌ Essayer d'accéder à `/produits/manage` → Erreur 403
❌ Essayer d'accéder à `/produits/create` → Erreur 403

---

## ✅ Test 4: Accès Non Authentifié

### Objectif
Vérifier que les pages protégées redirigent vers la connexion

### Étapes
1. Se déconnecter (ou utiliser navigation privée)
2. Essayer d'accéder directement à:
   - `/espaceadmin`
   - `/espaceclient`
   - `/produits/manage`
   - `/produits/create`

### Résultat Attendu
✅ Redirection vers `/login` pour chaque URL
✅ Message: "Vous devez être connecté pour accéder à cette page."

---

## ✅ Test 5: Espace Client - Produits en Solde

### Objectif
Vérifier que l'espace client affiche uniquement les produits en promotion

### Étapes
1. Se connecter en tant que USER (client@clotheszc.com)
2. Aller sur `/espaceclient`
3. Observer les produits affichés

### Résultat Attendu
✅ Seuls les produits avec `sale = true` sont affichés
✅ Badge "🔥 PROMO" visible sur chaque produit
✅ Prix avec réduction affiché
✅ Pagination fonctionnelle (6 produits par page)

### Vérification
- Comparer avec la boutique principale `/produits`
- L'espace client doit avoir MOINS de produits
- Tous les produits doivent avoir un badge PROMO

---

## ✅ Test 6: Sécurité des Middlewares

### Objectif
Tenter de contourner les protections

### Scénario A: USER essaie d'accéder aux routes ADMIN
1. Se connecter en tant que USER
2. Dans la barre d'adresse, taper manuellement:
   - `http://localhost:8000/espaceadmin`
   - `http://localhost:8000/produits/manage`
   - `http://localhost:8000/produits/create`

### Résultat Attendu
✅ Erreur 403 Forbidden
✅ Message: "Accès interdit. Vous devez être administrateur."

### Scénario B: ADMIN essaie d'accéder aux routes USER
1. Se connecter en tant que ADMIN
2. Dans la barre d'adresse, taper:
   - `http://localhost:8000/espaceclient`

### Résultat Attendu
✅ Erreur 403 Forbidden
✅ Message: "Accès interdit. Cette page est réservée aux utilisateurs."

---

## ✅ Test 7: Navigation Conditionnelle

### Objectif
Vérifier que le menu s'adapte correctement selon le rôle

### Test avec ADMIN
1. Se connecter en tant qu'ADMIN
2. Observer le menu de navigation

### Résultat Attendu
✅ Liens visibles:
   - Accueil
   - Boutique
   - Gérer Produits
   - Espace Admin
   - À Propos
   - Contact
   - Icône utilisateur avec dropdown

✅ Liens INVISIBLES:
   - Espace Client
   - Connexion
   - Inscription

### Test avec USER
1. Se connecter en tant que USER
2. Observer le menu de navigation

### Résultat Attendu
✅ Liens visibles:
   - Accueil
   - Boutique
   - Espace Client
   - À Propos
   - Contact
   - Icône utilisateur avec dropdown

✅ Liens INVISIBLES:
   - Gérer Produits
   - Espace Admin
   - Connexion
   - Inscription

### Test sans authentification
1. Se déconnecter
2. Observer le menu de navigation

### Résultat Attendu
✅ Liens visibles:
   - Accueil
   - Boutique
   - À Propos
   - Contact
   - Connexion (icône)
   - Inscription (icône)

✅ Liens INVISIBLES:
   - Gérer Produits
   - Espace Admin
   - Espace Client
   - Menu utilisateur

---

## ✅ Test 8: Déconnexion

### Objectif
Vérifier que la déconnexion fonctionne correctement

### Étapes
1. Se connecter (peu importe le rôle)
2. Cliquer sur l'icône utilisateur dans le menu
3. Cliquer sur "Déconnexion"

### Résultat Attendu
✅ Déconnexion réussie
✅ Redirection vers la page d'accueil
✅ Menu revient à l'état "non connecté"
✅ Tentative d'accès aux pages protégées → Redirection vers login

---

## ✅ Test 9: Gestion des Produits (ADMIN uniquement)

### Objectif
Vérifier que l'administrateur peut gérer les produits

### Étapes
1. Se connecter en tant qu'ADMIN
2. Aller sur "Gérer Produits"
3. Essayer de:
   - Créer un nouveau produit
   - Modifier un produit existant
   - Supprimer un produit

### Résultat Attendu
✅ Accès à toutes les fonctionnalités CRUD
✅ Formulaires fonctionnels
✅ Redirections correctes après actions
✅ Messages de succès affichés

---

## ✅ Test 10: Images des Produits

### Objectif
Vérifier que les images s'affichent correctement partout

### Étapes
1. Vérifier les images dans:
   - Page d'accueil (`/`)
   - Boutique (`/produits`)
   - Espace Admin (`/espaceadmin`)
   - Espace Client (`/espaceclient`)
   - Gestion des produits (`/produits/manage`)

### Résultat Attendu
✅ Toutes les images utilisent l'accesseur `image_url`
✅ Les images sont visibles partout
✅ Pas d'erreur 404 sur les images
✅ Format correct: `asset('storage/produits/...')`

---

## 📋 Checklist Complète

### Authentification
- [ ] Inscription fonctionne
- [ ] Connexion fonctionne
- [ ] Déconnexion fonctionne
- [ ] Rôle USER attribué par défaut

### Middlewares
- [ ] Middleware `admin` bloque les non-ADMIN
- [ ] Middleware `user` bloque les non-USER
- [ ] Middleware `auth` redirige les non-connectés

### Navigation
- [ ] Menu s'adapte pour ADMIN
- [ ] Menu s'adapte pour USER
- [ ] Menu s'adapte pour invités
- [ ] Dropdown utilisateur fonctionne

### Espaces Sécurisés
- [ ] Espace Admin accessible aux ADMIN uniquement
- [ ] Espace Client accessible aux USER uniquement
- [ ] Produits en solde affichés dans espace client
- [ ] Gestion produits réservée aux ADMIN

### Sécurité
- [ ] Pas d'accès direct par URL aux pages protégées
- [ ] Erreurs 403 correctes
- [ ] Messages d'erreur clairs
- [ ] Sessions sécurisées

### Interface
- [ ] Images affichées correctement
- [ ] Styles cohérents
- [ ] Responsive
- [ ] Pagination fonctionnelle

---

## 🐛 Problèmes Connus et Solutions

### Problème: Erreur 403 au lieu de redirection vers login
**Solution**: Vérifier que `auth` middleware est bien ajouté avant `admin` ou `user`

### Problème: Images ne s'affichent pas
**Solution**: 
```bash
php artisan storage:link
```

### Problème: Middleware non reconnu
**Solution**: Vérifier `bootstrap/app.php` et vider le cache
```bash
php artisan optimize:clear
```

### Problème: Utilisateur ne peut pas s'inscrire
**Solution**: Vérifier que la migration `add_role_to_users_table` a été exécutée
