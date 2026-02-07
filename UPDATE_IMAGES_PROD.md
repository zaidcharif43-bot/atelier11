# Mettre à jour les images en production

## Problème résolu
- ✅ Remplacé Unsplash par placeholder.com (plus fiable)
- ✅ Ajouté une page de debug : `/debug-images`
- ✅ Configuré HTTPS et routes Vercel

## 🚨 ACTION REQUISE : Mettre à jour la base de données de production

### Option 1 : Via PhpMyAdmin AlwaysData (Recommandé)

1. Connectez-vous à PhpMyAdmin sur AlwaysData
2. Sélectionnez votre base `test-app_atelier5`
3. Cliquez sur l'onglet **SQL**
4. Exécutez cette requête :

```sql
UPDATE produits SET 
    image = 'https://via.placeholder.com/800x1000/FFFFFF/333333?text=T-Shirt+Blanc'
WHERE name = 'T-Shirt Blanc Classique';

UPDATE produits SET 
    image = 'https://via.placeholder.com/800x1000/FFB6C1/FFFFFF?text=Robe+Fleurie'
WHERE name = 'Robe d\'Été Fleurie';

UPDATE produits SET 
    image = 'https://via.placeholder.com/800x1000/1E3A8A/FFFFFF?text=Jean+Slim'
WHERE name = 'Jean Slim Bleu Foncé';

UPDATE produits SET 
    image = 'https://via.placeholder.com/800x1000/000000/FFFFFF?text=Blazer+Noir'
WHERE name = 'Blazer Noir Élégant';

UPDATE produits SET 
    image = 'https://via.placeholder.com/800x1000/8B4513/FFFFFF?text=Sac+Cuir'
WHERE name = 'Sac à Main Cuir Marron';

UPDATE produits SET 
    image = 'https://via.placeholder.com/800x1000/2C3E50/FFFFFF?text=Montre+Sport'
WHERE name = 'Montre Sport Noir';

UPDATE produits SET 
    image = 'https://via.placeholder.com/800x1000/F5F5DC/333333?text=Chemise+Lin'
WHERE name = 'Chemise Lin Beige';

UPDATE produits SET 
    image = 'https://via.placeholder.com/800x1000/FFC0CB/FFFFFF?text=Jupe+Plissee'
WHERE name = 'Jupe Plissée Rose';
```

5. Cliquez sur **Exécuter**

### Option 2 : Recréer tous les produits (SUPPRIME TOUT)

Si vous préférez tout réinitialiser :

```sql
TRUNCATE TABLE produits;
```

Puis exécutez le seeder localement et exportez/importez les données.

### Option 3 : Via SSH (Si disponible)

```bash
ssh votre_compte@ssh-votre_compte.alwaysdata.net
cd votre_dossier_laravel
php artisan migrate:fresh --seed
```

## Vérification

Après la mise à jour, visitez :
- **Site principal** : https://at10.vercel.app
- **Page debug** : https://at10.vercel.app/debug-images

Les images devraient maintenant s'afficher correctement !

## Pourquoi placeholder.com ?

- ✅ Toujours disponible (CDN fiable)
- ✅ Pas de limite de requêtes
- ✅ Fonctionne avec HTTPS
- ✅ Compatible Vercel

## Prochaine étape : Utiliser de vraies images

Pour utiliser de vraies images de produits plus tard :

1. Téléchargez des images sur **Cloudinary** (gratuit)
2. Ou uploadez dans `public/images/produits/`
3. Ou utilisez un autre CDN d'images
