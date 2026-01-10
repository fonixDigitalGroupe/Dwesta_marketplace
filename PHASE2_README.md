# Phase 2 : Gestion des Vendeurs et Abonnements - TERMINÉE ✅

## 📋 Vue d'ensemble
**Durée estimée : 2-3 semaines**

### Objectifs
Mettre en place le système de comptes vendeurs (particuliers/professionnels) avec gestion des abonnements et vérification des documents.

## ✅ Progression
- ✅ 2.1 Modèles Vendeurs - TERMINÉ
- ✅ 2.2 Upload et gestion des documents - TERMINÉ
- ✅ 2.3 Système d'abonnements - TERMINÉ
- ✅ 2.4 Notifications expiration documents - TERMINÉ
- ✅ 2.5 Page Pro vendeur - TERMINÉ
- ✅ 2.6 Tests et validation - TERMINÉ

---

## ✅ 2.1 Modèles Vendeurs - TERMINÉ

### Migrations créées

#### 1. `vendeurs` (table principale)
- `id` - Identifiant unique
- `user_id` - Relation avec l'utilisateur
- `type` - Enum : 'particulier' ou 'professionnel'
- `statut_verification` - Enum : 'en_attente', 'verifie', 'rejete'
- `raison_rejet` - Texte expliquant le rejet (si applicable)
- `verifie_le` - Date de vérification
- `verifie_par` - ID de l'admin qui a vérifié
- `actif` - Boolean pour activer/désactiver le compte vendeur
- `timestamps`

#### 2. `vendeur_particuliers`
- `id` - Identifiant unique
- `vendeur_id` - Relation avec la table vendeurs
- `type_document` - Enum : 'cni', 'passeport', 'recepisse'
- `numero_document` - Numéro du document
- `document_path` - Chemin vers le document uploadé
- `date_expiration_document` - Date d'expiration du document
- `date_emission_document` - Date d'émission
- `lieu_emission` - Lieu d'émission
- `timestamps`

#### 3. `vendeur_professionnels`
- `id` - Identifiant unique
- `vendeur_id` - Relation avec la table vendeurs
- `nom_entreprise` - Nom de l'entreprise
- `numero_registre_commerce` - Numéro du registre de commerce
- `registre_commerce_path` - Chemin vers le document
- `date_expiration_registre` - Date d'expiration du registre
- `numero_identification_fiscale` - NIF
- `adresse_entreprise` - Adresse de l'entreprise
- `telephone_entreprise` - Téléphone de l'entreprise
- `email_entreprise` - Email de l'entreprise
- `description_entreprise` - Description de l'entreprise
- `site_web` - Site web de l'entreprise
- `timestamps`

### Modèles créés

#### 1. `Vendeur` (`app/Models/Vendeur.php`)
**Relations :**
- `user()` - BelongsTo User
- `particulier()` - HasOne VendeurParticulier
- `professionnel()` - HasOne VendeurProfessionnel
- `verificateur()` - BelongsTo User (admin qui a vérifié)

**Méthodes utilitaires :**
- `estVerifie()` - Vérifie si le vendeur est vérifié
- `estParticulier()` - Vérifie si c'est un particulier
- `estProfessionnel()` - Vérifie si c'est un professionnel

#### 2. `VendeurParticulier` (`app/Models/VendeurParticulier.php`)
**Relations :**
- `vendeur()` - BelongsTo Vendeur

**Méthodes utilitaires :**
- `estExpire()` - Vérifie si le document est expiré
- `expireBientot()` - Vérifie si le document expire dans 30 jours

#### 3. `VendeurProfessionnel` (`app/Models/VendeurProfessionnel.php`)
**Relations :**
- `vendeur()` - BelongsTo Vendeur

**Méthodes utilitaires :**
- `registreExpire()` - Vérifie si le registre est expiré
- `registreExpireBientot()` - Vérifie si le registre expire dans 30 jours

### Modèle User mis à jour

**Nouvelles relations :**
- `vendeur()` - HasOne Vendeur

**Nouvelles méthodes :**
- `estVendeur()` - Vérifie si l'utilisateur est vendeur
- `estVendeurVerifie()` - Vérifie si l'utilisateur est vendeur vérifié

### Contrôleur créé
- `VendeurController` - À implémenter pour la conversion utilisateur → vendeur

---

## ✅ 2.2 Upload et gestion des documents - TERMINÉ

### Service d'upload créé
- `DocumentUploadService` (`app/Services/DocumentUploadService.php`)
  - Upload sécurisé dans le storage privé
  - Validation des formats (PDF, JPG, PNG)
  - Validation de la taille (max 5 Mo)
  - Génération de noms de fichiers sécurisés
  - URLs temporaires pour téléchargement sécurisé
  - Suppression de documents

### Configuration storage
- Disque `private` configuré dans `config/filesystems.php`
- Stockage dans `storage/app/private/documents/vendeurs/{vendeur_id}/{type}/`

### Contrôleur Vendeur
- `VendeurController` implémenté avec :
  - `create()` - Formulaire de création de compte vendeur
  - `storeParticulier()` - Création compte particulier avec upload document
  - `storeProfessionnel()` - Création compte professionnel avec upload registre
  - `show()` - Affichage du compte vendeur
  - `updateDocumentParticulier()` - Mise à jour document particulier
  - `updateDocumentProfessionnel()` - Mise à jour document professionnel

### Contrôleur Admin
- `VendeurVerificationController` (`app/Http/Controllers/Admin/`) pour :
  - `index()` - Liste des vendeurs en attente de vérification
  - `show()` - Détails d'un vendeur pour vérification
  - `approve()` - Approuver un vendeur
  - `reject()` - Rejeter un vendeur avec raison

### Vues créées
- `vendeur/create.blade.php` - Formulaire de création (particulier/professionnel)
- `vendeur/show.blade.php` - Affichage du compte vendeur avec statut

### Routes configurées
- `/vendeur/create` - Créer un compte vendeur
- `/vendeur` - Voir son compte vendeur
- `/vendeur/{vendeur}/document-particulier` - Mettre à jour document particulier
- `/vendeur/{vendeur}/document-professionnel` - Mettre à jour document professionnel
- `/admin/vendeurs/verification` - Liste vendeurs en attente (admin)
- `/admin/vendeurs/verification/{vendeur}` - Détails vendeur (admin)
- `/admin/vendeurs/verification/{vendeur}/approve` - Approuver (admin)
- `/admin/vendeurs/verification/{vendeur}/reject` - Rejeter (admin)

### Validation
- Formats acceptés : PDF, JPG, JPEG, PNG
- Taille maximale : 5 Mo
- Validation côté serveur et client

### Notes
- ⚠️ Chiffrement des documents sensibles : À implémenter plus tard si nécessaire
- Les documents sont stockés de manière sécurisée dans le storage privé
- Les URLs temporaires expirent après 1 heure

---

## ✅ 2.3 Système d'abonnements - TERMINÉ

### Migrations créées

#### 1. `abonnements`
- `id` - Identifiant unique
- `type` - Type d'abonnement (gratuit, basic, expert)
- `nom` - Nom affiché
- `description` - Description de l'abonnement
- `nombre_annonces` - Nombre d'annonces autorisées (0 = illimité)
- `commission` - Pourcentage de commission
- `prix_mensuel` - Prix mensuel
- `page_pro` - Accès à la page pro (boolean)
- `actif` - Abonnement actif ou non
- `ordre` - Ordre d'affichage
- `timestamps`

#### 2. `vendeur_abonnements`
- `id` - Identifiant unique
- `vendeur_id` - Relation avec vendeur
- `abonnement_id` - Relation avec abonnement
- `date_debut` - Date de début
- `date_fin` - Date de fin
- `actif` - Abonnement actif ou non
- `renouvellement_automatique` - Renouvellement automatique activé
- `nombre_annonces_utilisees` - Nombre d'annonces publiées
- `timestamps`

### Modèles créés

#### 1. `Abonnement`
**Constantes :**
- `TYPE_GRATUIT` = 'gratuit'
- `TYPE_BASIC` = 'basic'
- `TYPE_EXPERT` = 'expert'

**Relations :**
- `vendeurAbonnements()` - HasMany VendeurAbonnement

**Méthodes utilitaires :**
- `estGratuit()` - Vérifie si l'abonnement est gratuit
- `aAnnoncesIllimitees()` - Vérifie si annonces illimitées
- Scopes : `actifs()`, `parOrdre()`

#### 2. `VendeurAbonnement`
**Relations :**
- `vendeur()` - BelongsTo Vendeur
- `abonnement()` - BelongsTo Abonnement

**Méthodes utilitaires :**
- `estExpire()` - Vérifie si l'abonnement est expiré
- `expireBientot()` - Vérifie si expire dans 7 jours
- `peutPublierAnnonce()` - Vérifie si peut publier une annonce
- `incrementerAnnonces()` - Incrémente le compteur
- `decrementerAnnonces()` - Décrémente le compteur
- Scopes : `actifs()`, `expires()`

### Service créé
- `AbonnementService` avec méthodes :
  - `souscrire()` - Souscrire à un abonnement
  - `desactiverAbonnementActif()` - Désactiver l'abonnement actif
  - `renouvelerAutomatiquement()` - Renouveler un abonnement
  - `verifierEtRenouvelerAbonnements()` - Vérifier et renouveler tous les abonnements
  - `desactiverAbonnementsExpires()` - Désactiver les abonnements expirés
  - `calculerCommission()` - Calculer la commission pour un montant
  - `peutPublierAnnonce()` - Vérifier si un vendeur peut publier

### Contrôleur créé
- `AbonnementController` avec :
  - `index()` - Liste des abonnements disponibles
  - `show()` - Détails d'un abonnement
  - `souscrire()` - Souscrire à un abonnement
  - `monAbonnement()` - Afficher l'abonnement actuel
  - `toggleRenouvellementAutomatique()` - Activer/désactiver renouvellement auto

### Commande Artisan
- `abonnements:verifier` - Vérifie et renouvelle automatiquement les abonnements
- Planifiée quotidiennement à 02:00 dans `routes/console.php`

### Seeder créé
- `AbonnementSeeder` - Crée les 3 abonnements de base :
  - **Gratuit** : 5 annonces, 10% commission, 0 FCFA
  - **Basic** : 20 annonces, 7.5% commission, 5000 FCFA/mois
  - **Expert** : Illimité, 5% commission, 15000 FCFA/mois, Page Pro incluse

### Modèle Vendeur mis à jour
**Nouvelles relations :**
- `abonnements()` - HasMany VendeurAbonnement
- `abonnementActif()` - HasOne VendeurAbonnement (actif)

**Nouvelles méthodes :**
- `aAbonnementActif()` - Vérifie si a un abonnement actif
- `getAbonnementActuelAttribute()` - Obtient l'abonnement actuel ou gratuit
- `peutPublierAnnonce()` - Vérifie si peut publier une annonce

### Routes configurées
- `/abonnements` - Liste des abonnements
- `/abonnements/mon-abonnement` - Mon abonnement actuel
- `/abonnements/{abonnement}` - Détails d'un abonnement
- `/abonnements/{abonnement}/souscrire` - Souscrire à un abonnement
- `/abonnements/toggle-renouvellement` - Activer/désactiver renouvellement auto

### Fonctionnalités implémentées
- ✅ Système de souscription
- ✅ Gestion renouvellement automatique
- ✅ Limitation annonces selon abonnement
- ✅ Calcul commissions dynamique
- ✅ Commande pour vérification quotidienne

### Notes
- ⚠️ Intégration paiement : À implémenter plus tard
- Les prix sont en FCFA (à adapter selon la devise)
- Le renouvellement automatique nécessite un système de paiement

---

## 📋 Prochaines étapes

## ✅ 2.4 Notifications expiration documents - TERMINÉ

### Migration créée
- `document_notifications` - Table pour tracker les notifications envoyées
  - `vendeur_id` - Relation avec vendeur
  - `type_document` - Type (particulier, professionnel, abonnement)
  - `date_expiration` - Date d'expiration
  - `jours_avant_expiration` - Nombre de jours avant expiration (30, 15, 7, 1)
  - `envoyee` - Notification envoyée ou non
  - `envoyee_le` - Date d'envoi
  - `message` - Message de la notification

### Modèle créé
- `DocumentNotification` - Modèle pour tracker les notifications

### Commande Artisan
- `documents:verifier-expiration` - Vérifie les documents expirant dans 30 jours
  - Planifiée quotidiennement à 03:00 dans `routes/console.php`
  - Vérifie les documents particuliers, registres professionnels et abonnements
  - Envoie des notifications aux vendeurs concernés

### Notification créée
- `DocumentExpirationNotification` - Notification email
  - Envoie un email au vendeur avec les détails de l'expiration
  - Inclut un lien pour mettre à jour les documents ou renouveler l'abonnement
  - Implémente `ShouldQueue` pour traitement asynchrone

### Service créé
- `DocumentNotificationService` avec méthodes :
  - `doitEnvoyerNotification()` - Vérifie si une notification doit être envoyée
  - `enregistrerNotification()` - Enregistre une notification envoyée
  - `getAlertesActives()` - Récupère les alertes actives pour un vendeur

### Interface vendeur
- Section d'alertes dans `vendeur/show.blade.php`
- Affiche les documents/abonnements expirant dans 30 jours
- Indique le nombre de jours restants
- Liens directs pour mettre à jour les documents ou renouveler l'abonnement

### Fonctionnalités
- ✅ Vérification quotidienne automatique
- ✅ Notifications email à 30, 15, 7 et 1 jour(s) avant expiration
- ✅ Prévention des doublons (une notification par période)
- ✅ Interface de rappel dans l'espace vendeur
- ✅ Support pour documents particuliers, professionnels et abonnements

### Notes
- ⚠️ SMS : À implémenter plus tard (Phase 12 - Notifications)
- Les notifications sont envoyées par email uniquement pour l'instant
- Les alertes sont visibles dans l'espace vendeur même sans email

## ✅ 2.5 Page Pro vendeur - TERMINÉ

### Migration créée
- `page_pro` - Table pour les pages pro des vendeurs
  - `vendeur_id` - Relation unique avec vendeur
  - `slug` - URL unique pour la page pro
  - `logo` - Chemin vers le logo
  - `banniere` - Chemin vers la bannière
  - `description` - Description de la page pro
  - `categories` - Catégories (JSON, pour Phase 3)
  - `telephone_contact` - Téléphone de contact
  - `email_contact` - Email de contact
  - `site_web` - Site web
  - `reseaux_sociaux` - Réseaux sociaux (JSON)
  - `actif` - Page active ou non
  - `vues` - Nombre de vues de la page
  - `timestamps`

### Modèle créé
- `PagePro` avec :
  - Relation `vendeur()` - BelongsTo Vendeur
  - Méthode `generateSlug()` - Génère un slug unique
  - Méthode `incrementerVues()` - Incrémente le compteur de vues
  - Accessor `getUrlAttribute()` - URL de la page pro
  - Scope `actives()` - Pages actives

### Modèle Vendeur mis à jour
**Nouvelles relations :**
- `pagePro()` - HasOne PagePro

**Nouvelles méthodes :**
- `aAccesPagePro()` - Vérifie si le vendeur a accès à la page pro (abonnement Expert)

### Contrôleur créé
- `PageProController` avec :
  - `show($slug)` - Affichage public de la page pro
  - `edit()` - Formulaire d'édition (vendeur)
  - `update()` - Mise à jour de la page pro
  - `creerPagePro()` - Création automatique de la page pro

### Vues créées
- `page-pro/edit.blade.php` - Formulaire d'édition avec upload logo/bannière
- `page-pro/show.blade.php` - Affichage public de la page pro

### Routes configurées
- `/page-pro/{slug}` - Affichage public (accessible sans authentification)
- `/page-pro/edit` - Éditer sa page pro (authentifié)
- `/page-pro/update` - Mettre à jour sa page pro (authentifié)

### Fonctionnalités implémentées
- ✅ Création automatique de la page pro lors de l'accès
- ✅ Upload logo et bannière
- ✅ Gestion description, contacts, réseaux sociaux
- ✅ Génération automatique de slug unique
- ✅ Compteur de vues
- ✅ Vérification d'accès (abonnement Expert requis)
- ✅ Affichage public avec design professionnel

### Notes
- ⚠️ Liste produits : À implémenter dans Phase 4 (Annonces)
- ⚠️ Évaluations : À implémenter dans Phase 5 (Système d'évaluation)
- ⚠️ Catégories : À implémenter dans Phase 3 (Catégories)
- La page pro est accessible uniquement avec l'abonnement Expert
- Les images sont stockées dans `storage/app/public/page-pro/`

## ✅ 2.6 Tests et validation - TERMINÉ

### Tests créés

#### 1. `VendeurTest` (`tests/Feature/VendeurTest.php`)
**Tests :**
- ✅ `test_peut_creer_compte_vendeur_particulier()` - Création compte particulier
- ✅ `test_peut_creer_compte_vendeur_professionnel()` - Création compte professionnel
- ✅ `test_utilisateur_ne_peut_avoir_qu_un_compte_vendeur()` - Un seul compte par utilisateur
- ✅ `test_upload_document_valide_format_et_taille()` - Validation upload documents
- ✅ `test_peut_afficher_compte_vendeur()` - Affichage compte vendeur

#### 2. `AbonnementTest` (`tests/Feature/AbonnementTest.php`)
**Tests :**
- ✅ `test_abonnements_sont_crees_par_seeder()` - Vérification seeder
- ✅ `test_peut_souscrire_a_un_abonnement()` - Souscription abonnement
- ✅ `test_limite_annonces_selon_abonnement()` - Limitation annonces
- ✅ `test_abonnement_illimite_peut_toujours_publier()` - Abonnement illimité
- ✅ `test_calcule_commission_correctement()` - Calcul commission
- ✅ `test_renouvelle_abonnement_automatiquement()` - Renouvellement auto

#### 3. `DocumentNotificationTest` (`tests/Feature/DocumentNotificationTest.php`)
**Tests :**
- ✅ `test_detecte_document_expirant_dans_30_jours()` - Détection expiration
- ✅ `test_detecte_document_expire()` - Détection document expiré
- ✅ `test_verifie_si_notification_doit_etre_envoyee()` - Prévention doublons
- ✅ `test_detecte_abonnement_expirant()` - Détection abonnement expirant

#### 4. `PageProTest` (`tests/Feature/PageProTest.php`)
**Tests :**
- ✅ `test_creer_page_pro_automatiquement()` - Création automatique
- ✅ `test_acces_page_pro_necessite_abonnement_expert()` - Vérification accès
- ✅ `test_peut_mettre_a_jour_page_pro()` - Mise à jour page pro
- ✅ `test_peut_afficher_page_pro_publique()` - Affichage public
- ✅ `test_generer_slug_unique()` - Génération slug unique

### Factories créées

- ✅ `VendeurFactory` - Factory pour vendeurs
- ✅ `VendeurParticulierFactory` - Factory pour vendeurs particuliers
- ✅ `VendeurProfessionnelFactory` - Factory pour vendeurs professionnels
- ✅ `AbonnementFactory` - Factory pour abonnements
- ✅ `VendeurAbonnementFactory` - Factory pour abonnements vendeurs
- ✅ `PageProFactory` - Factory pour pages pro
- ✅ `UserFactory` - Mis à jour avec les champs du modèle

### TestCase mis à jour

- ✅ Ajout de `RefreshDatabase` pour réinitialiser la base de données entre les tests

### Commandes de test

```bash
# Exécuter tous les tests
php artisan test

# Exécuter un test spécifique
php artisan test --filter VendeurTest
php artisan test --filter AbonnementTest
php artisan test --filter DocumentNotificationTest
php artisan test --filter PageProTest

# Exécuter avec couverture (si configuré)
php artisan test --coverage
```

---

## 🚀 Commandes à exécuter

```bash
# Exécuter les migrations
php artisan migrate

# Exécuter les seeders (abonnements)
php artisan db:seed --class=AbonnementSeeder

# Créer le lien symbolique pour le storage public
php artisan storage:link

# Vérifier les migrations
php artisan migrate:status

# Tester les commandes planifiées
php artisan abonnements:verifier
php artisan documents:verifier-expiration

# Exécuter les tests
php artisan test

# Exécuter un test spécifique
php artisan test --filter VendeurTest
php artisan test --filter AbonnementTest
```

---

## 📝 Notes importantes

- Les documents sont stockés dans `storage/app/private/documents/vendeurs/`
- Les images de page pro sont stockées dans `storage/app/public/page-pro/`
- Les vendeurs doivent être vérifiés par un admin avant de pouvoir publier des annonces
- Les dates d'expiration sont utilisées pour les notifications automatiques
- Un utilisateur peut avoir un seul compte vendeur (particulier OU professionnel)
- La page pro est accessible uniquement avec l'abonnement Expert
- Les commandes de vérification sont planifiées quotidiennement (abonnements à 02:00, documents à 03:00)

## 🔄 À compléter dans les phases suivantes

- Liste produits sur page pro (Phase 4 - Annonces)
- Évaluations vendeur (Phase 5 - Système d'évaluation)
- Catégories sur page pro (Phase 3 - Catégories)
- Intégration paiement pour abonnements (Phase 6 - Paiements)
- SMS pour notifications (Phase 12 - Notifications)

