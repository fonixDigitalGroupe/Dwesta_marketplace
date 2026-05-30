# Dwesta Marketplace : Architecture & État du Projet

Ce document présente une vue d'ensemble complète de l'écosystème **Dwesta Marketplace**, incluant le hub central et les modules spécialisés (Logistique & Agence).

---

## 🏗️ Architecture Globale

L'écosystème est conçu comme une **Micro-Application Suite** basée sur Laravel 11.x.

1.  **Hub Central (Marketplace)** : Gère les utilisateurs, le catalogue, les transactions financières et les commandes.
2.  **Portail Logistique** : Application dédiée à la gestion des trajets, des transporteurs et du suivi "Dernier Kilomètre".
3.  **Portail Agence** : Application dédiée aux agences immobilières et aux services professionnels.

---

## 🔑 Authentification & Sécurité

Le système utilise un moteur d'authentification hybride et sécurisé :
-   **Multi-Identifiants** : Inscription par Email ou Téléphone.
-   **Vérification OTP** : Système de code à 4 chiffres par email/SMS pour les actions sensibles.
-   **Social Auth** : Intégration Google et Facebook via Laravel Socialite.
-   **Gestion des Rôles** : Propulsé par Spatie Permissions.
    -   `Acheteur` (Défaut)
    -   `Vendeur` (Particulier ou Professionnel)
    -   `Livreur / Transporteur`
    -   `Admin` (Back-office complet)

---

## 🏪 Écosystème Vendeur

Un système robuste pour transformer des acheteurs en commerçants :
-   **Vérification d'Identité** : Upload de CNI/Passeport (Particuliers) ou Registre de Commerce (Pro).
-   **Système d'Abonnements** :
    -   `Gratuit` : 5 annonces, commission standard.
    -   `Basic` : 20 annonces, commission réduite.
    -   `Expert` : Annonces illimitées, commission minimale, accès à la **Page Pro**.
-   **Page Pro** : Mini-site personnalisable (Logo, Bannière, Description) pour les vendeurs certifiés.
-   **Alertes Expiration** : Rappels automatiques pour le renouvellement des documents et abonnements.

---

## 📢 Moteur d'Annonces (Ads Core)

C'est le cœur du catalogue, supportant 4 types de métiers différents :
1.  **Produit** : E-commerce classique (Marque, État, Quantité).
2.  **Service** : Prestations (Tarification fixe/heure, Zone d'intervention).
3.  **Immobilier** : Vente/Location (Surface, Pièces, Type de transaction).
4.  **Véhicule** : Vente (Kilométrage, Année, Boîte, Carburant).

**Options de Visibilité (Payantes) :**
-   `À la Une` : Mise en avant prioritaire (7 jours).
-   `Urgent` : Badge distinctif pour accélérer la vente.
-   `Vidéo` : Support multimédia enrichi.
-   `Republication Auto` : Remontée automatique en tête de liste.

---

## 💳 Fintech & Wallet (Système de Crédits)

Dwesta utilise un système de **Fintech Interne** pour sécuriser les échanges :
-   **Portefeuille (Wallet)** : Chaque utilisateur possède un `credit_balance`.
-   **Frais de Publication** : Certaines catégories (ex: Véhicules) requièrent un paiement en crédits pour publier.
-   **Séquestre (Escrow)** : Lors d'un achat, les fonds sont bloqués par la plateforme et libérés au vendeur seulement après validation de la livraison (délai de 14 jours par défaut).
-   **Transactions** : Historique complet des entrées/sorties et gestion des remboursements.

---

## 🚚 Supply Chain & Logistique

Le flux de commande est entièrement tracé :
-   **Cycle de Vie** : `Payé` → `Prêt` → `En route` → `Disponible (Relais)` → `Livré`.
-   **Tracking Direct** : Utilisation de tokens de suivi et de QR Codes pour les remises en main propre.
-   **Points Relais** : Gestion des lieux de collecte et de retrait sécurisés.
-   **Scan System** : Interface mobile pour les livreurs afin de scanner les colis à chaque étape.

---

## 💬 Confiance & Communication

-   **Messagerie Transactionnelle** : Système de chat inspiré de WhatsApp pour discuter autour d'une annonce.
-   **Avis & Notations** : Système d'évaluation avec photos, soumis à modération Admin.
-   **Gestion des Litiges** : Module permettant de bloquer le paiement en cas de problème de livraison.

---

## 🛠️ État Technique Actuel

-   **Backend** : Laravel 11.x, PHP 8.2+, MySQL/MariaDB.
-   **Frontend** : Design "Apex Executive" (Minimaliste, Typographie Inter, Glassmorphism).
-   **Mobile** : Interface "Responsive-First" optimisée pour les écrans tactiles.
-   **Tests** : Couverture complète des phases 1 à 5 via PHPUnit.

---

> [!TIP]
> Pour le développement des parties **Agence** et **Logistique**, basez-vous sur les modèles `Vendeur` et `Order` du hub central pour assurer la cohérence des données.
