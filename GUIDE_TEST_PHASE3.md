# Guide de Test Manuel - Phase 3 : Système de Catégories

Ce guide vous permet de tester manuellement toutes les fonctionnalités de la Phase 3.

## 📋 Prérequis

1. **Base de données à jour**
   ```bash
   php artisan migrate
   php artisan db:seed --class=CategorySeeder
   ```

2. **Serveur Laravel en cours d'exécution**
   ```bash
   php artisan serve
   ```

3. **Compte administrateur créé**
   - Vous devez avoir un compte utilisateur avec le rôle "Administrateur"
   - Si vous n'en avez pas, créez-en un via le seeder ou manuellement

## 🧪 Tests Automatiques

### Exécuter tous les tests de la Phase 3

```bash
php artisan test --filter Category
```

**Résultat attendu :** 34 tests passés (82 assertions)

### Tests par catégorie

```bash
# Tests du modèle
php artisan test --filter CategoryModelTest

# Tests du contrôleur admin
php artisan test --filter Admin/CategoryControllerTest

# Tests du contrôleur public
php artisan test --filter CategoryControllerTest
```

---

## 🔍 Tests Manuels - Back-office Admin

### 1. Accès à la gestion des catégories

**URL :** `http://localhost:8000/admin/categories`

**Test :**
1. Connectez-vous avec un compte administrateur
2. Accédez à `/admin/categories`
3. Vous devriez voir la liste des catégories avec leur arborescence

**Résultat attendu :**
- ✅ Page accessible
- ✅ Liste des 4 catégories principales affichée
- ✅ Sous-catégories visibles sous chaque catégorie principale
- ✅ Bouton "Nouvelle catégorie" visible

---

### 2. Création d'une catégorie principale

**URL :** `http://localhost:8000/admin/categories/create`

**Test :**
1. Cliquez sur "Nouvelle catégorie"
2. Remplissez le formulaire :
   - **Nom :** "Test Catégorie"
   - **Catégorie parente :** Laissez vide (catégorie principale)
   - **Description :** "Description de test"
   - **Icône :** "test-icon"
   - **Ordre :** 0
   - **Actif :** Coché
3. Cliquez sur "Créer la catégorie"

**Résultat attendu :**
- ✅ Redirection vers la liste des catégories
- ✅ Message de succès affiché
- ✅ Nouvelle catégorie visible dans la liste
- ✅ Slug généré automatiquement : "test-categorie"

---

### 3. Création d'une sous-catégorie

**Test :**
1. Cliquez sur "Nouvelle catégorie"
2. Remplissez le formulaire :
   - **Nom :** "Sous-catégorie Test"
   - **Catégorie parente :** Sélectionnez "E-commerce"
   - **Description :** "Sous-catégorie de test"
   - **Actif :** Coché
3. Cliquez sur "Créer la catégorie"

**Résultat attendu :**
- ✅ Catégorie créée avec succès
- ✅ Visible sous "E-commerce" dans la liste
- ✅ Relation parent/enfant correcte

---

### 4. Affichage des détails d'une catégorie

**Test :**
1. Dans la liste des catégories, cliquez sur le nom d'une catégorie
2. Ou accédez directement à `/admin/categories/{id}`

**Résultat attendu :**
- ✅ Page de détails affichée
- ✅ Informations complètes de la catégorie visibles
- ✅ Sous-catégories listées si présentes
- ✅ Boutons "Modifier" et "Supprimer" visibles

---

### 5. Modification d'une catégorie

**Test :**
1. Cliquez sur "Modifier" pour une catégorie
2. Modifiez le nom : "Catégorie Modifiée"
3. Changez la description
4. Cliquez sur "Enregistrer les modifications"

**Résultat attendu :**
- ✅ Redirection vers la liste
- ✅ Message de succès affiché
- ✅ Modifications visibles dans la liste
- ✅ Slug mis à jour automatiquement

---

### 6. Protection contre les boucles

**Test :**
1. Modifiez une catégorie
2. Essayez de la définir comme son propre parent
3. Ou essayez de définir un de ses enfants comme parent

**Résultat attendu :**
- ✅ Message d'erreur affiché
- ✅ Modification refusée
- ✅ Catégorie non modifiée

---

### 7. Suppression d'une catégorie sans enfants

**Test :**
1. Créez une catégorie sans sous-catégories
2. Cliquez sur "Supprimer"
3. Confirmez la suppression

**Résultat attendu :**
- ✅ Catégorie supprimée
- ✅ Message de succès affiché
- ✅ Catégorie disparaît de la liste

---

### 8. Tentative de suppression d'une catégorie avec enfants

**Test :**
1. Essayez de supprimer "E-commerce" (qui a des sous-catégories)
2. Cliquez sur "Supprimer"

**Résultat attendu :**
- ✅ Message d'erreur : "Impossible de supprimer une catégorie qui a des sous-catégories"
- ✅ Catégorie non supprimée
- ✅ Sous-catégories toujours présentes

---

### 9. Désactivation d'une catégorie

**Test :**
1. Modifiez une catégorie
2. Décochez "Catégorie active"
3. Enregistrez

**Résultat attendu :**
- ✅ Catégorie désactivée
- ✅ Badge "Inactive" visible dans la liste admin
- ✅ Catégorie non visible dans le menu public

---

### 10. Réorganisation par ordre

**Test :**
1. Modifiez plusieurs catégories
2. Changez leur ordre (0, 1, 2, etc.)
3. Vérifiez l'affichage dans la liste

**Résultat attendu :**
- ✅ Catégories triées par ordre croissant
- ✅ Ordre respecté dans l'affichage

---

## 🌐 Tests Manuels - Front-end Public

### 11. Menu de navigation avec catégories

**URL :** `http://localhost:8000`

**Test :**
1. Accédez à la page d'accueil (connecté ou non)
2. Regardez le header

**Résultat attendu :**
- ✅ Menu "Catégories :" visible dans le header
- ✅ 4 catégories principales affichées (E-commerce, Services, Immobilier, Véhicules)
- ✅ Icônes visibles si définies
- ✅ Menu responsive (s'adapte sur mobile)

---

### 12. Affichage d'une catégorie principale

**URL :** `http://localhost:8000/categories/e-commerce`

**Test :**
1. Cliquez sur "E-commerce" dans le menu
2. Ou accédez directement à l'URL

**Résultat attendu :**
- ✅ Page de catégorie affichée
- ✅ Nom de la catégorie visible
- ✅ Description affichée si présente
- ✅ Icône affichée si présente
- ✅ Breadcrumb : "Accueil / E-commerce"
- ✅ Liste des sous-catégories affichée (8 sous-catégories)
- ✅ Section "Annonces dans cette catégorie" visible (vide pour l'instant)

---

### 13. Affichage d'une sous-catégorie

**URL :** `http://localhost:8000/categories/electronique`

**Test :**
1. Cliquez sur "Électronique" dans la liste des sous-catégories
2. Ou accédez directement à l'URL

**Résultat attendu :**
- ✅ Page de sous-catégorie affichée
- ✅ Breadcrumb complet : "Accueil / E-commerce / Électronique"
- ✅ Informations de la catégorie affichées
- ✅ Pas de sous-catégories (ou liste si présentes)

---

### 14. Breadcrumbs (fil d'Ariane)

**Test :**
1. Naviguez vers une sous-catégorie profonde
2. Vérifiez le breadcrumb

**Résultat attendu :**
- ✅ Breadcrumb affiché en haut de la page
- ✅ Liens cliquables vers chaque niveau
- ✅ Format : "Accueil / Parent / Enfant"
- ✅ Navigation possible via les breadcrumbs

---

### 15. Catégories inactives non visibles

**Test :**
1. Désactivez une catégorie dans l'admin
2. Rechargez la page d'accueil
3. Essayez d'accéder directement à l'URL de la catégorie

**Résultat attendu :**
- ✅ Catégorie absente du menu
- ✅ Sous-catégories inactives absentes
- ✅ Accès direct retourne 404
- ✅ Catégorie toujours visible dans l'admin (avec badge "Inactive")

---

### 16. Navigation hiérarchique

**Test :**
1. Partez de la page d'accueil
2. Cliquez sur "E-commerce"
3. Cliquez sur "Électronique"
4. Utilisez le breadcrumb pour revenir à "E-commerce"
5. Utilisez le breadcrumb pour revenir à "Accueil"

**Résultat attendu :**
- ✅ Navigation fluide entre les niveaux
- ✅ Breadcrumbs fonctionnels
- ✅ Pas d'erreurs 404
- ✅ URLs correctes générées

---

### 17. Responsive design

**Test :**
1. Ouvrez le site sur mobile (ou réduisez la fenêtre)
2. Vérifiez le menu des catégories

**Résultat attendu :**
- ✅ Menu des catégories s'adapte
- ✅ Sous-menus accessibles
- ✅ Navigation fonctionnelle sur mobile
- ✅ Pas de débordement horizontal

---

## 🔐 Tests de Sécurité

### 18. Accès non autorisé à l'admin

**Test :**
1. Connectez-vous avec un compte non-admin
2. Essayez d'accéder à `/admin/categories`

**Résultat attendu :**
- ✅ Accès refusé (403 Forbidden)
- ✅ Redirection ou message d'erreur approprié

---

### 19. Accès non authentifié à l'admin

**Test :**
1. Déconnectez-vous
2. Essayez d'accéder à `/admin/categories`

**Résultat attendu :**
- ✅ Redirection vers la page de connexion
- ✅ Accès refusé

---

### 20. Validation des données

**Test :**
1. Essayez de créer une catégorie sans nom
2. Essayez de créer une catégorie avec un parent invalide
3. Essayez de créer une catégorie avec des données invalides

**Résultat attendu :**
- ✅ Messages d'erreur de validation affichés
- ✅ Catégorie non créée
- ✅ Formulaire pré-rempli avec les données valides

---

## 📊 Tests de Performance

### 21. Chargement de l'arborescence

**Test :**
1. Créez plusieurs niveaux de catégories (3-4 niveaux)
2. Vérifiez le temps de chargement de la page admin

**Résultat attendu :**
- ✅ Page charge rapidement (< 2 secondes)
- ✅ Arborescence complète affichée
- ✅ Pas de ralentissement visible

---

### 22. Menu des catégories

**Test :**
1. Vérifiez le temps de chargement de la page d'accueil
2. Vérifiez que le menu des catégories ne ralentit pas la page

**Résultat attendu :**
- ✅ Page charge rapidement
- ✅ Menu des catégories visible immédiatement
- ✅ Pas de délai perceptible

---

## ✅ Checklist de Validation

Cochez chaque test au fur et à mesure :

### Back-office Admin
- [ ] Accès à la gestion des catégories
- [ ] Création d'une catégorie principale
- [ ] Création d'une sous-catégorie
- [ ] Affichage des détails
- [ ] Modification d'une catégorie
- [ ] Protection contre les boucles
- [ ] Suppression d'une catégorie sans enfants
- [ ] Tentative de suppression avec enfants
- [ ] Désactivation d'une catégorie
- [ ] Réorganisation par ordre

### Front-end Public
- [ ] Menu de navigation avec catégories
- [ ] Affichage d'une catégorie principale
- [ ] Affichage d'une sous-catégorie
- [ ] Breadcrumbs fonctionnels
- [ ] Catégories inactives non visibles
- [ ] Navigation hiérarchique
- [ ] Responsive design

### Sécurité
- [ ] Accès non autorisé à l'admin
- [ ] Accès non authentifié à l'admin
- [ ] Validation des données

### Performance
- [ ] Chargement de l'arborescence
- [ ] Menu des catégories

---

## 🐛 Problèmes Courants et Solutions

### Problème : Les catégories ne s'affichent pas dans le menu

**Solution :**
1. Vérifiez que les catégories sont actives : `actif = true`
2. Vérifiez que les catégories principales ont `parent_id = null`
3. Videz le cache : `php artisan cache:clear`
4. Vérifiez que le seeder a été exécuté

---

### Problème : Erreur 404 sur une catégorie

**Solution :**
1. Vérifiez que la catégorie existe dans la base de données
2. Vérifiez que le slug est correct
3. Vérifiez que la catégorie est active
4. Vérifiez les routes : `php artisan route:list | grep categories`

---

### Problème : Impossible de supprimer une catégorie

**Solution :**
1. Vérifiez que la catégorie n'a pas d'enfants
2. Supprimez d'abord les sous-catégories
3. Vérifiez les contraintes de clé étrangère

---

### Problème : Slug dupliqué

**Solution :**
1. Le système génère automatiquement des slugs uniques
2. Si problème persiste, vérifiez la méthode `generateSlug()` dans le modèle
3. Vérifiez l'index unique sur la colonne `slug`

---

## 📝 Notes de Test

**Date du test :** _______________

**Testeur :** _______________

**Environnement :**
- Laravel version : _______________
- PHP version : _______________
- Navigateur : _______________

**Résultats :**
- Tests réussis : _______________
- Tests échoués : _______________
- Remarques : _______________

---

## 🎯 Prochaines Étapes

Une fois tous les tests validés, vous pouvez :
1. Passer à la Phase 4 : Publication d'Annonces
2. Intégrer les catégories avec les annonces
3. Ajouter des filtres par catégorie dans la recherche

---

**Bon test ! 🚀**

