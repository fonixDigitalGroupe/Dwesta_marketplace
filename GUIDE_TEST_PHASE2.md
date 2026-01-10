# 🧪 Guide de Test - Phase 2

## 📋 Prérequis

Avant de commencer les tests, assurez-vous d'avoir :
- ✅ Laravel installé et configuré
- ✅ Base de données configurée dans `.env`
- ✅ Serveur de développement lancé (`php artisan serve`)

---

## 🚀 Étape 1 : Exécuter les migrations

```bash
# Exécuter toutes les migrations
php artisan migrate

# Vérifier le statut des migrations
php artisan migrate:status
```

**Résultat attendu :** Toutes les migrations doivent être marquées comme "Ran"

---

## 🌱 Étape 2 : Exécuter les seeders

```bash
# Créer les rôles (si pas déjà fait)
php artisan db:seed --class=RoleSeeder

# Créer les abonnements
php artisan db:seed --class=AbonnementSeeder

# Créer l'admin par défaut (si pas déjà fait)
php artisan db:seed --class=DatabaseSeeder
```

**Vérification :**
```bash
# Vérifier que les abonnements sont créés
php artisan tinker
>>> \App\Models\Abonnement::all();
# Devrait afficher 3 abonnements (Gratuit, Basic, Expert)
```

---

## 🔗 Étape 3 : Créer le lien symbolique pour le storage

```bash
php artisan storage:link
```

**Résultat attendu :** Lien symbolique créé dans `public/storage`

---

## ✅ Étape 4 : Exécuter les tests automatiques

```bash
# Exécuter tous les tests
php artisan test

# Exécuter un test spécifique
php artisan test --filter VendeurTest
php artisan test --filter AbonnementTest
php artisan test --filter DocumentNotificationTest
php artisan test --filter PageProTest
```

**Résultat attendu :** Tous les tests doivent passer (PASS)

---

## 🧪 Étape 5 : Tests manuels dans le navigateur

### 5.1 Test création compte vendeur particulier

1. **Lancer le serveur :**
   ```bash
   php artisan serve
   ```

2. **Créer un compte utilisateur :**
   - Aller sur `http://localhost:8000/register`
   - Remplir le formulaire d'inscription
   - Se connecter

3. **Créer un compte vendeur particulier :**
   - Aller sur `http://localhost:8000/vendeur/create`
   - Cliquer sur "Particulier"
   - Remplir le formulaire :
     - Type de document : CNI
     - Numéro : 123456789
     - Document : Uploader un PDF ou image (max 5 Mo)
     - Date d'émission : 2020-01-01
     - Date d'expiration : 2030-01-01
   - Soumettre

4. **Vérifier :**
   - Redirection vers `/vendeur`
   - Message de succès affiché
   - Statut "En attente de vérification"

### 5.2 Test création compte vendeur professionnel

1. **Créer un nouveau compte utilisateur** (ou utiliser un autre navigateur en navigation privée)

2. **Créer un compte vendeur professionnel :**
   - Aller sur `http://localhost:8000/vendeur/create`
   - Cliquer sur "Professionnel"
   - Remplir le formulaire :
     - Nom entreprise : Ma Société SARL
     - Registre de commerce : Uploader un document
     - Numéro registre : RC123456
     - Date expiration : 2030-12-31
     - Adresse, téléphone, email, etc.
   - Soumettre

3. **Vérifier :**
   - Redirection vers `/vendeur`
   - Message de succès affiché
   - Informations professionnelles affichées

### 5.3 Test vérification vendeur (Admin)

1. **Se connecter en tant qu'admin :**
   - Email : `admin@madymarket.com`
   - Mot de passe : `password`

2. **Vérifier un vendeur :**
   - Aller sur `http://localhost:8000/admin/vendeurs/verification`
   - Voir la liste des vendeurs en attente
   - Cliquer sur un vendeur pour voir les détails
   - Cliquer sur "Approuver" ou "Rejeter"

3. **Vérifier :**
   - Le statut du vendeur change
   - Le vendeur peut voir son nouveau statut

### 5.4 Test système d'abonnements

1. **Voir les abonnements disponibles :**
   - Se connecter en tant que vendeur vérifié
   - Aller sur `http://localhost:8000/abonnements`
   - Voir les 3 abonnements (Gratuit, Basic, Expert)

2. **Souscrire à un abonnement :**
   - Cliquer sur un abonnement
   - Remplir le formulaire de souscription
   - Soumettre

3. **Vérifier l'abonnement actif :**
   - Aller sur `http://localhost:8000/abonnements/mon-abonnement`
   - Voir les détails de l'abonnement
   - Vérifier les dates de début et fin

### 5.5 Test page pro

1. **Souscrire à l'abonnement Expert :**
   - Le vendeur doit avoir l'abonnement Expert pour accéder à la page pro

2. **Créer/Éditer la page pro :**
   - Aller sur `http://localhost:8000/page-pro/edit`
   - Uploader un logo
   - Uploader une bannière
   - Remplir la description
   - Ajouter les informations de contact
   - Ajouter les réseaux sociaux
   - Enregistrer

3. **Voir la page pro publique :**
   - Copier l'URL de la page pro
   - Ouvrir dans un navigateur en navigation privée (sans être connecté)
   - Vérifier que la page s'affiche correctement

### 5.6 Test notifications expiration

1. **Créer un document avec expiration proche :**
   - Modifier un document vendeur avec une date d'expiration dans 30 jours
   - Ou créer un vendeur avec un document expirant bientôt

2. **Exécuter la commande de vérification :**
   ```bash
   php artisan documents:verifier-expiration
   ```

3. **Vérifier :**
   - Les notifications sont envoyées (vérifier les logs)
   - Les alertes apparaissent dans l'espace vendeur (`/vendeur`)

---

## 🔧 Étape 6 : Tester les commandes planifiées

```bash
# Tester la vérification des abonnements
php artisan abonnements:verifier

# Tester la vérification des documents
php artisan documents:verifier-expiration
```

**Résultat attendu :** Messages de succès avec le nombre d'éléments traités

---

## 📊 Étape 7 : Vérifications dans la base de données

```bash
# Ouvrir Tinker
php artisan tinker
```

**Commandes de vérification :**

```php
// Vérifier les vendeurs
\App\Models\Vendeur::count();
\App\Models\Vendeur::with('user')->get();

// Vérifier les abonnements
\App\Models\Abonnement::all();
\App\Models\VendeurAbonnement::with('vendeur', 'abonnement')->get();

// Vérifier les pages pro
\App\Models\PagePro::all();

// Vérifier les notifications
\App\Models\DocumentNotification::all();
```

---

## ✅ Checklist de validation

### Fonctionnalités de base
- [ ] Création compte vendeur particulier fonctionne
- [ ] Création compte vendeur professionnel fonctionne
- [ ] Upload de documents fonctionne
- [ ] Validation des formats de fichiers fonctionne
- [ ] Validation de la taille des fichiers fonctionne

### Système d'abonnements
- [ ] Les 3 abonnements sont créés par le seeder
- [ ] Souscription à un abonnement fonctionne
- [ ] Limitation d'annonces fonctionne
- [ ] Calcul de commission fonctionne
- [ ] Renouvellement automatique fonctionne

### Vérification admin
- [ ] Liste des vendeurs en attente s'affiche
- [ ] Détails d'un vendeur s'affichent
- [ ] Approbation d'un vendeur fonctionne
- [ ] Rejet d'un vendeur fonctionne

### Page Pro
- [ ] Création automatique de la page pro fonctionne
- [ ] Vérification d'accès (Expert uniquement) fonctionne
- [ ] Upload logo et bannière fonctionne
- [ ] Mise à jour de la page pro fonctionne
- [ ] Affichage public fonctionne

### Notifications
- [ ] Détection des documents expirants fonctionne
- [ ] Alertes dans l'espace vendeur s'affichent
- [ ] Commandes de vérification fonctionnent

---

## 🐛 Résolution de problèmes

### Erreur : "Class not found"
```bash
# Vider le cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### Erreur : "Migration already exists"
```bash
# Réinitialiser les migrations (ATTENTION : supprime les données)
php artisan migrate:fresh
php artisan db:seed
```

### Erreur : "Storage link not found"
```bash
# Recréer le lien
php artisan storage:link
```

### Erreur : "Route not found"
```bash
# Vérifier les routes
php artisan route:list
```

---

## 📝 Notes importantes

- Les tests utilisent une base de données de test (SQLite par défaut)
- Les fichiers uploadés dans les tests sont simulés (Storage::fake())
- Pour les tests manuels, utilisez de vrais fichiers
- Les notifications email ne seront pas réellement envoyées en développement (vérifier les logs)

---

## 🎯 Prochaines étapes après les tests

Une fois tous les tests validés :
1. ✅ Phase 2 est complète
2. ➡️ Passer à la Phase 3 (Système de Catégories)

