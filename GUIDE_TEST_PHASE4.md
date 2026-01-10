# Guide de Test Manuel - Phase 4 : Gestion des Annonces

Ce guide vous permet de tester manuellement toutes les fonctionnalités de la Phase 4 du projet Mady Market.

## Prérequis

1. **Base de données migrée et seedée**
   ```bash
   php artisan migrate
   php artisan db:seed --class=CategorySeeder
   php artisan db:seed --class=AbonnementSeeder
   ```

2. **Serveur de développement lancé**
   ```bash
   php artisan serve
   ```

3. **Compte vendeur vérifié**
   - [Créer un compte utilisateur](http://localhost:8000/register)
   - [Créer un compte vendeur](http://localhost:8000/vendeur/create) (particulier ou professionnel)
   - [Se connecter en tant qu'administrateur](http://localhost:8000/login) et [vérifier le vendeur](http://localhost:8000/admin/vendeurs/verification)

---

## 1. Tests de Création d'Annonces

### 1.1 Créer une Annonce Produit

1. **Se connecter** en tant que vendeur vérifié
2. **Accéder** à [Créer annonce produit](http://localhost:8000/annonces/create?type=produit)
3. **Remplir le formulaire** :
   - Catégorie : Sélectionner une catégorie
   - Titre : "iPhone 13 Pro Max 256GB"
   - Description : "iPhone 13 Pro Max en excellent état, 256GB, avec accessoires"
   - Prix : 800000
   - Marque : "Apple"
   - Modèle : "iPhone 13 Pro Max"
   - État : "Occasion"
   - Quantité : 1
   - Type de livraison : "les_deux"
   - Disponibilité : "en_stock"
4. **Uploader des photos** (au moins 1, maximum 8)
5. **Sélectionner le statut** : "brouillon" ou "publiee"
6. **Cliquer** sur "Enregistrer"

**Résultat attendu** :
- ✅ Redirection vers la page d'édition ou de visualisation
- ✅ Message de succès
- ✅ L'annonce apparaît dans [Liste des annonces](http://localhost:8000/annonces)
- ✅ Les détails du produit sont enregistrés

### 1.2 Créer une Annonce Service

1. **Accéder** à [Créer annonce service](http://localhost:8000/annonces/create?type=service)
2. **Remplir le formulaire** :
   - Catégorie : Sélectionner une catégorie de service
   - Titre : "Réparation de smartphones"
   - Description : "Service de réparation pour tous types de smartphones, remplacement d'écran, batterie, etc."
   - Type de tarification : "fixe"
   - Prix : 15000
   - Durée estimée : "2 heures"
   - Déplacement inclus : Oui
   - Zone d'intervention : "Bamako"
3. **Uploader des photos** (optionnel mais recommandé)
4. **Enregistrer** en brouillon

**Résultat attendu** :
- ✅ L'annonce service est créée
- ✅ Les détails du service sont enregistrés
- ✅ Le prix est correctement associé

### 1.3 Créer une Annonce Immobilier

1. **Accéder** à [Créer annonce immobilier](http://localhost:8000/annonces/create?type=immobilier)
2. **Remplir le formulaire** :
   - Catégorie : Sélectionner une catégorie immobilière
   - Titre : "Appartement 3 pièces à Badalabougou"
   - Description : "Bel appartement de 3 pièces, 2 chambres, salon, cuisine équipée, balcon"
   - Type de transaction : "vente"
   - Prix de vente : 50000000
   - Surface : 100
   - Pièces : 3
   - Chambres : 2
3. **Uploader des photos** de l'appartement
4. **Enregistrer** en brouillon

**Résultat attendu** :
- ✅ L'annonce immobilier est créée
- ✅ Les détails immobiliers sont enregistrés
- ✅ Le prix de vente est correct

### 1.4 Créer une Annonce Véhicule

1. **Accéder** à [Créer annonce véhicule](http://localhost:8000/annonces/create?type=vehicule)
2. **Remplir le formulaire** :
   - Catégorie : Sélectionner une catégorie véhicule
   - Titre : "Toyota Corolla 2020"
   - Description : "Toyota Corolla 2020, excellent état, entretien régulier, 50000 km"
   - Prix : 8000000
   - Marque : "Toyota" (obligatoire)
   - Modèle : "Corolla" (obligatoire)
   - Année : 2020
   - Kilométrage : 50000
   - Carburant : "Essence"
   - Boîte de vitesses : "Manuelle"
   - État : "Occasion"
   - Couleur : "Blanc"
   - Nombre de portes : 4
   - Nombre de places : 5
3. **Uploader des photos** du véhicule
4. **Enregistrer** en brouillon

**Résultat attendu** :
- ✅ L'annonce véhicule est créée
- ✅ Les détails du véhicule sont enregistrés
- ✅ Tous les champs obligatoires sont présents

---

## 2. Tests de Gestion des Médias

### 2.1 Upload de Photos

1. **Créer ou éditer** une annonce
2. **Uploader plusieurs photos** (1 à 8)
3. **Vérifier** :
   - Les photos s'affichent correctement
   - Les thumbnails sont générés
   - L'ordre des photos peut être modifié
   - Une photo principale peut être définie

**Résultat attendu** :
- ✅ Maximum 8 photos acceptées
- ✅ Formats acceptés : JPG, PNG, WEBP
- ✅ Taille maximale : 5 Mo par photo
- ✅ Thumbnails générés automatiquement

### 2.2 Upload de Vidéo

1. **Créer ou éditer** une annonce
2. **Uploader une vidéo** (si l'option vidéo est activée)
3. **Vérifier** :
   - La vidéo s'affiche correctement
   - Un seul fichier vidéo par annonce

**Résultat attendu** :
- ✅ Formats acceptés : MP4, MOV, AVI
- ✅ Taille maximale : 50 Mo
- ✅ Une seule vidéo par annonce

### 2.3 Gestion des Photos

1. **Éditer** une annonce avec plusieurs photos
2. **Réorganiser** l'ordre des photos
3. **Définir** une photo principale
4. **Supprimer** une photo

**Résultat attendu** :
- ✅ L'ordre des photos peut être modifié
- ✅ La photo principale peut être changée
- ✅ La suppression fonctionne correctement

---

## 3. Tests des Options Payantes

### 3.1 Acheter l'Option "À la Une"

1. **Créer ou éditer** une annonce
2. **Cocher** l'option "À la Une"
3. **Vérifier** le coût affiché (5000 FCFA)
4. **Enregistrer** l'annonce

**Résultat attendu** :
- ✅ L'option "À la Une" est activée
- ✅ Durée : 7 jours
- ✅ L'annonce apparaît en haut des résultats

### 3.2 Acheter l'Option "Urgent"

1. **Créer ou éditer** une annonce
2. **Cocher** l'option "Urgent"
3. **Vérifier** le coût affiché (3000 FCFA)
4. **Enregistrer** l'annonce

**Résultat attendu** :
- ✅ Le badge "Urgent" apparaît sur l'annonce
- ✅ Durée : 7 jours

### 3.3 Acheter l'Option "Vidéo"

1. **Créer ou éditer** une annonce
2. **Cocher** l'option "Vidéo"
3. **Vérifier** le coût affiché (10000 FCFA)
4. **Uploader** une vidéo
5. **Enregistrer** l'annonce

**Résultat attendu** :
- ✅ L'option vidéo est activée
- ✅ Durée : 30 jours
- ✅ La vidéo peut être uploadée

### 3.4 Activer la Republication Automatique

1. **Créer ou éditer** une annonce
2. **Cocher** l'option "Republication automatique"
3. **Vérifier** le coût affiché (2000 FCFA)
4. **Enregistrer** l'annonce

**Résultat attendu** :
- ✅ L'option est activée
- ✅ L'annonce sera automatiquement republiée à l'expiration

### 3.5 Vérifier l'Expiration des Options

1. **Créer** une annonce avec option "À la Une"
2. **Attendre** 7 jours (ou modifier manuellement la date d'expiration en base)
3. **Exécuter** la commande :
   ```bash
   php artisan annonces:verifier-options-expiration
   ```
4. **Vérifier** que l'option est désactivée

**Résultat attendu** :
- ✅ Les options expirées sont désactivées automatiquement
- ✅ Le badge "À la Une" disparaît

---

## 4. Tests de Publication et Gestion

### 4.1 Publier une Annonce en Brouillon

1. **Créer** une annonce en brouillon
2. **Ajouter** au moins une photo
3. **Accéder** à la page de l'annonce (ex: [Annonce exemple](http://localhost:8000/annonces/1))
4. **Cliquer** sur "Publier" ou utiliser [Publier directement](http://localhost:8000/annonces/1/publier) (POST)

**Résultat attendu** :
- ✅ L'annonce passe au statut "publiée"
- ✅ Date de publication enregistrée
- ✅ Date d'expiration définie (30 jours)
- ✅ L'annonce est visible publiquement

### 4.2 Modifier une Annonce

1. **Accéder** à [Éditer annonce](http://localhost:8000/annonces/1/edit) (remplacer 1 par l'ID de votre annonce)
2. **Modifier** le titre, la description, le prix
3. **Ajouter** des photos supplémentaires
4. **Sauvegarder** les modifications

**Résultat attendu** :
- ✅ Les modifications sont enregistrées
- ✅ Le slug est mis à jour si le titre change
- ✅ Les nouvelles photos sont ajoutées

### 4.3 Supprimer une Annonce

1. **Accéder** à la [liste des annonces](http://localhost:8000/annonces)
2. **Cliquer** sur "Supprimer" pour une annonce
3. **Confirmer** la suppression

**Résultat attendu** :
- ✅ L'annonce est supprimée
- ✅ Tous les médias associés sont supprimés
- ✅ Les données spécifiques sont supprimées (cascade)

### 4.4 Prévisualiser une Annonce

1. **Créer ou éditer** une annonce
2. **Cliquer** sur "Prévisualiser"
3. **Vérifier** l'affichage

**Résultat attendu** :
- ✅ L'aperçu s'affiche correctement
- ✅ Tous les détails sont visibles
- ✅ Les photos s'affichent

---

## 5. Tests d'Affichage Public

### 5.1 Afficher une Annonce Publique

1. **Se déconnecter** (ou utiliser un navigateur privé)
2. **Accéder** à [Annonce publique](http://localhost:8000/annonces/1) (remplacer 1 par l'ID de votre annonce)
3. **Vérifier** l'affichage

**Résultat attendu** :
- ✅ L'annonce s'affiche correctement
- ✅ Toutes les informations sont visibles
- ✅ Les photos s'affichent
- ✅ Le compteur de vues est incrémenté

### 5.2 Vérifier les Badges

1. **Afficher** une annonce avec option "Urgent"
2. **Vérifier** que le badge "Urgent" est visible
3. **Afficher** une annonce avec option "À la Une"
4. **Vérifier** qu'elle apparaît en haut des résultats

**Résultat attendu** :
- ✅ Les badges sont visibles
- ✅ Les annonces "À la Une" sont prioritaires

---

## 6. Tests d'Import CSV

### 6.1 Télécharger un Template CSV

1. **Accéder** à [Télécharger template produit](http://localhost:8000/annonces/template?type=produit)
   - [Template service](http://localhost:8000/annonces/template?type=service)
   - [Template immobilier](http://localhost:8000/annonces/template?type=immobilier)
   - [Template véhicule](http://localhost:8000/annonces/template?type=vehicule)
2. **Télécharger** le template
3. **Ouvrir** le fichier CSV

**Résultat attendu** :
- ✅ Le fichier CSV est téléchargé
- ✅ Les colonnes appropriées sont présentes
- ✅ Un exemple de ligne est fourni

### 6.2 Préparer un Fichier CSV

1. **Ouvrir** le template téléchargé
2. **Remplir** plusieurs lignes avec des données d'annonces :
   ```
   type,titre,description,categorie,prix,marque,modele,etat,quantite
   produit,Produit Test 1,Description du produit test 1,electronique,50000,Marque1,Modèle1,Neuf,1
   produit,Produit Test 2,Description du produit test 2,electronique,75000,Marque2,Modèle2,Occasion,2
   ```
3. **Sauvegarder** le fichier

### 6.3 Importer le Fichier CSV

1. **Accéder** à [Page d'import CSV](http://localhost:8000/annonces/import)
2. **Sélectionner** le fichier CSV
3. **Choisir** le statut (brouillon ou publiée)
4. **Cocher** "Ignorer les erreurs" si nécessaire
5. **Cliquer** sur "Importer"

**Résultat attendu** :
- ✅ Le fichier est uploadé
- ✅ Les annonces sont créées
- ✅ Un rapport d'import est affiché
- ✅ Les erreurs sont listées si présentes

### 6.4 Importer via Commande Artisan

1. **Préparer** un fichier CSV
2. **Exécuter** la commande :
   ```bash
   php artisan annonces:import-csv chemin/vers/fichier.csv --vendeur=email@example.com --statut=brouillon
   ```
3. **Vérifier** le rapport d'import

**Résultat attendu** :
- ✅ Les annonces sont importées
- ✅ Un rapport détaillé est affiché
- ✅ Les erreurs sont listées

---

## 7. Tests de Validation et Erreurs

### 7.1 Test de Validation - Champs Obligatoires

1. **Essayer** de créer une annonce sans titre
2. **Essayer** de créer une annonce sans description
3. **Essayer** de créer une annonce sans catégorie

**Résultat attendu** :
- ✅ Des messages d'erreur s'affichent
- ✅ L'annonce n'est pas créée

### 7.2 Test de Validation - Types d'Annonces

1. **Créer** une annonce véhicule sans marque
2. **Créer** une annonce véhicule sans modèle
3. **Créer** une annonce service sans type de tarification

**Résultat attendu** :
- ✅ Des messages d'erreur spécifiques s'affichent
- ✅ Les champs obligatoires sont indiqués

### 7.3 Test de Limites

1. **Essayer** d'uploader plus de 8 photos
2. **Essayer** d'uploader une photo de plus de 5 Mo
3. **Essayer** d'uploader une vidéo de plus de 50 Mo

**Résultat attendu** :
- ✅ Des messages d'erreur s'affichent
- ✅ Les fichiers ne sont pas acceptés

### 7.4 Test de Permissions

1. **Créer** une annonce avec le vendeur A
2. **Se connecter** avec le vendeur B
3. **Essayer** de modifier l'annonce du vendeur A

**Résultat attendu** :
- ✅ Accès refusé
- ✅ Redirection vers la liste des annonces
- ✅ Message d'erreur approprié

---

## 8. Tests de Performance

### 8.1 Test avec Plusieurs Annonces

1. **Créer** 50 annonces différentes
2. **Accéder** à [Liste des annonces](http://localhost:8000/annonces)
3. **Vérifier** le temps de chargement

**Résultat attendu** :
- ✅ La pagination fonctionne
- ✅ Le temps de chargement est acceptable (< 2 secondes)

### 8.2 Test avec Beaucoup de Photos

1. **Créer** une annonce avec 8 photos
2. **Accéder** à la page de l'annonce
3. **Vérifier** le temps de chargement

**Résultat attendu** :
- ✅ Les photos se chargent rapidement
- ✅ Les thumbnails sont utilisés pour l'affichage

---

## 9. Tests de Commandes Artisan

### 9.1 Vérifier l'Expiration des Options

1. **Créer** des annonces avec options expirées
2. **Exécuter** :
   ```bash
   php artisan annonces:verifier-options-expiration
   ```
3. **Vérifier** que les options sont désactivées

**Résultat attendu** :
- ✅ Les options expirées sont désactivées
- ✅ Un rapport est affiché

### 9.2 Republier les Annonces Expirées

1. **Créer** des annonces expirées avec republication automatique
2. **Exécuter** :
   ```bash
   php artisan annonces:republier-expirees
   ```
3. **Vérifier** que les annonces sont republiées

**Résultat attendu** :
- ✅ Les annonces sont republiées
- ✅ Un rapport est affiché

---

## 10. Checklist de Validation Complète

### Fonctionnalités de Base
- [ ] [Création d'annonce produit](http://localhost:8000/annonces/create?type=produit)
- [ ] [Création d'annonce service](http://localhost:8000/annonces/create?type=service)
- [ ] [Création d'annonce immobilier](http://localhost:8000/annonces/create?type=immobilier)
- [ ] [Création d'annonce véhicule](http://localhost:8000/annonces/create?type=vehicule)
- [ ] [Modification d'annonce](http://localhost:8000/annonces/1/edit)
- [ ] [Suppression d'annonce](http://localhost:8000/annonces)
- [ ] [Publication d'annonce](http://localhost:8000/annonces/1/publier)

### Gestion des Médias
- [ ] Upload de photos (1-8) - [Créer annonce](http://localhost:8000/annonces/create?type=produit)
- [ ] Upload de vidéo - [Créer annonce](http://localhost:8000/annonces/create?type=produit)
- [ ] Réorganisation des photos - [Éditer annonce](http://localhost:8000/annonces/1/edit)
- [ ] Définition photo principale - [Éditer annonce](http://localhost:8000/annonces/1/edit)
- [ ] Suppression de médias - [Éditer annonce](http://localhost:8000/annonces/1/edit)
- [ ] Génération de thumbnails - Automatique

### Options Payantes
- [ ] Option "À la Une" - [Créer annonce](http://localhost:8000/annonces/create?type=produit)
- [ ] Option "Urgent" - [Créer annonce](http://localhost:8000/annonces/create?type=produit)
- [ ] Option "Vidéo" - [Créer annonce](http://localhost:8000/annonces/create?type=produit)
- [ ] Republication automatique - [Créer annonce](http://localhost:8000/annonces/create?type=produit)
- [ ] Expiration des options - Commande Artisan (voir section 3.5)

### Import CSV
- [ ] [Téléchargement template](http://localhost:8000/annonces/template?type=produit)
- [ ] [Import via interface web](http://localhost:8000/annonces/import)
- [ ] Import via commande Artisan (voir section 6.4)
- [ ] Gestion des erreurs

### Validation et Sécurité
- [ ] Validation des champs obligatoires
- [ ] Validation des types de fichiers
- [ ] Validation des tailles de fichiers
- [ ] Vérification des permissions

### Affichage Public
- [ ] [Affichage des annonces publiées](http://localhost:8000/annonces/1)
- [ ] [Affichage des badges](http://localhost:8000/annonces/1)
- [ ] [Incrémentation des vues](http://localhost:8000/annonces/1) (automatique)
- [ ] [Affichage des médias](http://localhost:8000/annonces/1)

---

## Notes Importantes

1. **Base de données** : Assurez-vous que toutes les migrations sont exécutées
2. **Permissions** : Les vendeurs doivent être vérifiés pour publier des annonces
   - [Créer compte vendeur](http://localhost:8000/vendeur/create)
   - [Vérifier vendeur (Admin)](http://localhost:8000/admin/vendeurs/verification)
3. **Abonnements** : Vérifiez les limites d'annonces selon l'abonnement
   - [Voir abonnements](http://localhost:8000/abonnements)
   - [Mon abonnement](http://localhost:8000/abonnements/mon-abonnement)
4. **Stockage** : Les fichiers sont stockés dans `storage/app/public/annonces/`
5. **Commandes** : Les commandes Artisan peuvent être planifiées dans `routes/console.php`

---

## Commandes Utiles

```bash
# Lancer les migrations
php artisan migrate

# Lancer les seeders
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=AbonnementSeeder

# Vérifier les options expirées
php artisan annonces:verifier-options-expiration

# Republier les annonces expirées
php artisan annonces:republier-expirees

# Importer des annonces CSV
php artisan annonces:import-csv fichier.csv --vendeur=email@example.com

# Lancer les tests
php artisan test --filter=AnnonceTest
```

## Liens Rapides

### Pages Principales
- [Accueil](http://localhost:8000/)
- [Connexion](http://localhost:8000/login)
- [Inscription](http://localhost:8000/register)
- [Dashboard](http://localhost:8000/dashboard)

### Gestion des Annonces
- [Liste des annonces](http://localhost:8000/annonces)
- [Créer annonce produit](http://localhost:8000/annonces/create?type=produit)
- [Créer annonce service](http://localhost:8000/annonces/create?type=service)
- [Créer annonce immobilier](http://localhost:8000/annonces/create?type=immobilier)
- [Créer annonce véhicule](http://localhost:8000/annonces/create?type=vehicule)
- [Import CSV](http://localhost:8000/annonces/import)

### Templates CSV
- [Template produit](http://localhost:8000/annonces/template?type=produit)
- [Template service](http://localhost:8000/annonces/template?type=service)
- [Template immobilier](http://localhost:8000/annonces/template?type=immobilier)
- [Template véhicule](http://localhost:8000/annonces/template?type=vehicule)

### Vendeur
- [Créer compte vendeur](http://localhost:8000/vendeur/create)
- [Mon compte vendeur](http://localhost:8000/vendeur)
- [Abonnements](http://localhost:8000/abonnements)
- [Mon abonnement](http://localhost:8000/abonnements/mon-abonnement)

### Admin
- [Vérification vendeurs](http://localhost:8000/admin/vendeurs/verification)
- [Gestion catégories](http://localhost:8000/admin/categories)

---

**Date de création** : Décembre 2025  
**Version** : 1.0  
**Phase** : Phase 4 - Gestion des Annonces

