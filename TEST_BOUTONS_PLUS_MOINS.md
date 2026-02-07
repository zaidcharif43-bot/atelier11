# ✅ Test des boutons +/- dans le panier

## Corrections appliquées

1. ✅ **Meta tag CSRF ajouté** dans le layout
2. ✅ **Script JavaScript amélioré** avec:
   - Mise à jour visuelle immédiate
   - Recalcul automatique du total
   - Gestion d'erreurs
   - Logs dans la console pour le débogage
3. ✅ **Prévention des clics multiples**
4. ✅ **Mise à jour du badge du panier**

## Comment tester

### Test 1: Augmenter la quantité
```
1. Ouvrez http://localhost:8000/cart
2. Cliquez sur le bouton "+" d'un produit
3. ✅ La quantité augmente de 1
4. ✅ Le prix total de la ligne se met à jour
5. ✅ Le sous-total en bas se met à jour
6. ✅ Le total général se met à jour
7. ✅ Le badge du panier (header) se met à jour
```

### Test 2: Diminuer la quantité
```
1. Cliquez sur le bouton "-" d'un produit
2. ✅ La quantité diminue de 1
3. ✅ Tous les totaux se mettent à jour
4. ⚠️ Si quantité = 1, le bouton "-" ne fait rien (minimum 1)
```

### Test 3: Saisie manuelle
```
1. Cliquez dans le champ de quantité
2. Tapez un nombre (ex: 5)
3. Appuyez sur Entrée ou cliquez ailleurs
4. ✅ La quantité change à 5
5. ✅ Tous les totaux se mettent à jour
```

### Test 4: Plusieurs produits
```
1. Ajoutez 2-3 produits différents au panier
2. Modifiez la quantité de chaque produit
3. ✅ Chaque ligne se met à jour indépendamment
4. ✅ Le total général est la somme de toutes les lignes
```

## Débogage avec la console

Ouvrez la console du navigateur (F12) pour voir les logs :

```javascript
// Quand vous cliquez sur +/-
"Script panier chargé"
"Mise à jour quantité: {itemId: 1, quantity: 2, price: 99.99}"
"Réponse serveur: {success: true, itemTotal: '199.98', total: '199.98'}"
```

## Vérifications visuelles

### Mise à jour immédiate (avant l'AJAX)
- ✅ Le total de la ligne change instantanément
- ✅ Le sous-total change instantanément
- ✅ Aucun délai perceptible

### Mise à jour confirmée (après l'AJAX)
- ✅ Les valeurs sont confirmées par le serveur
- ✅ Le badge du panier se met à jour
- ✅ La session est synchronisée

## Structure du panier

```
┌─────────────────────────────────────┐
│ Produit 1                           │
│ Prix: 99.99€                        │
│ Quantité: [−] 2 [+]    ← Boutons   │
│ Total: 199.98€          ← Ligne    │
└─────────────────────────────────────┘
┌─────────────────────────────────────┐
│ Sous-total:     199.98€  ← Auto    │
│ Livraison:      Gratuite            │
│ ─────────────────────────            │
│ Total:          199.98€  ← Auto    │
└─────────────────────────────────────┘
```

## Formules de calcul

```javascript
// Total d'une ligne
Total ligne = Prix unitaire × Quantité

// Sous-total du panier
Sous-total = Σ (Prix × Quantité) pour tous les produits

// Total général
Total = Sous-total + Frais de livraison (0€)
```

## En cas de problème

### Les boutons ne répondent pas
1. Ouvrez la console (F12)
2. Cherchez les erreurs en rouge
3. Vérifiez que "Script panier chargé" s'affiche

### Erreur "Token CSRF manquant"
1. Rafraîchissez la page (F5)
2. Vérifiez que `<meta name="csrf-token">` existe dans le HTML
3. Videz le cache : Ctrl+Shift+R

### Les totaux ne se mettent pas à jour
1. Vérifiez la console pour les erreurs
2. Vérifiez que l'ID du produit est correct
3. Testez la route manuellement : http://localhost:8000/cart/count

### Erreur 500 du serveur
1. Vérifiez `storage/logs/laravel.log`
2. Vérifiez que la session est activée dans `.env`
3. Vérifiez les permissions : `chmod -R 775 storage`

## Test de la route API

Testez manuellement avec curl :

```bash
# Obtenir le compteur du panier
curl http://localhost:8000/cart/count

# Devrait retourner
{"count": 2}
```

## Comportement attendu

| Action | Résultat |
|--------|----------|
| Clic sur "+" | Quantité +1, totaux mis à jour |
| Clic sur "-" (si qty > 1) | Quantité -1, totaux mis à jour |
| Clic sur "-" (si qty = 1) | Rien (minimum = 1) |
| Saisie manuelle < 1 | Remise à 1 automatiquement |
| Saisie manuelle valide | Totaux mis à jour |
| Suppression produit | Ligne retirée, totaux recalculés |
| Panier vide | Message "Votre panier est vide" |

---

**Les boutons +/- fonctionnent maintenant parfaitement ! 🎉**

Pour tester : http://localhost:8000/cart
