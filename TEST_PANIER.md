# ✅ Test du système de panier

## Tests à effectuer

1. **Accès au panier**
   - Cliquez sur l'icône du panier (caddie) dans le header
   - Devrait afficher la page du panier (vide au départ)

2. **Ajouter un produit**
   - Allez sur `/produits` ou `/boutique`
   - Cliquez sur l'icône du panier sur une carte produit
   - Message de succès devrait apparaître
   - Le badge du panier devrait se mettre à jour

3. **Voir le panier**
   - Cliquez sur l'icône du panier
   - Vous devriez voir votre produit avec quantité, prix, total

4. **Modifier la quantité**
   - Utilisez les boutons + et - pour changer la quantité
   - Le total devrait se mettre à jour automatiquement

5. **Supprimer un produit**
   - Cliquez sur le bouton poubelle rouge
   - Le produit devrait être retiré

6. **Procéder au paiement**
   - Cliquez sur "Procéder au paiement"
   - Vous devriez voir la page de checkout

## URLs importantes

- Panier: `/cart`
- Produits: `/produits`
- Checkout: `/checkout`

## Problèmes courants

### Le panier ne s'affiche pas
- Vérifiez que les sessions sont activées: `SESSION_DRIVER=file` dans `.env`
- Vérifiez les permissions du dossier `storage/framework/sessions`

### Le badge ne se met pas à jour
- Rafraîchissez la page
- Le compteur s'actualise au chargement de la page

### Erreur 404
- Vérifiez que les routes sont bien enregistrées
- Lancez `php artisan route:list | grep cart`
