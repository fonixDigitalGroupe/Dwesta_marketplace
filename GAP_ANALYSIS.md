# Analyse d'Écart : Cahier des Charges vs Implémentation Actuelle

Ce document compare le Cahier des Charges (CDC) fourni avec l'état actuel du projet pour identifier les fonctionnalités manquantes ou à améliorer.

## 🟢 1. Fonctionnalités Bien Avancées / Complètes

| Module | Statut | Observations |
| :--- | :--- | :--- |
| **Inscription / Auth** | ✅ Complet | Email, Social (Google/FB prêt), Rôles de base. |
| **Comptes Vendeurs** | ✅ Complet | Particulier vs Pro, KYC (Documents), Page Pro personnalisable. |
| **Catalogue & Annonces** | ✅ Complet | CRUD Annonces, Catégories, Photos, Options (Une/Urgent). |
| **Panier & Commande** | ✅ Fonctionnel | Gestion panier mutli-vendeurs, Checkout en 3 étapes. |
| **Messagerie** | ✅ Complet | Chat temps réel (polymorphe) entre utilisateurs. |
| **Admin Back-office** | ✅ Fonctionnel | Dashboard, Modération (Annonces/Vendeurs), Litiges. |
| **UX / UI** | ✅ Avancé | Design Rakuten-style, Mobile menu, Favoris AJAX, Toaster. |

---

## 🟡 2. Fonctionnalités Partiellement Implémentées (À affiner)

| Module | Ce qui est fait | Ce qui manque (GAP) |
| :--- | :--- | :--- |
| **Paiement** | Simulation de paiement réussie. | **Intégration réelle** (OM, Momo, Stripe/PayPal). Gestion des erreurs réelles. |
| **Abonnements** | Structure de base et plans. | **Calibrage des prix** exacts (3000/5000 FCFA) et limites strictes (5 annonces gratuit). |
| **Logistique** | Génération de tokens, Scan Controller. | **Flux complet** : Interface dédiée "Transporteur" et "Relais" pour scanner et changer les statuts étape par étape. |
| **Recherche** | Mot clé et Catégorie. | **Filtres avancés** (Prix min/max, Livraison, Tri par pertinence/prix). Auto-complétion. |

---

## 🔴 3. Fonctionnalités Manquantes (Prioritaires selon CDC)

### A. Séquestre & Libération des Fonds (Crucial)
*   **CDC** : "Libération des fonds vendeur après 14 jours ou résolution litige."
*   **Actuel** : Le paiement est marqué "payé" et l'argent est théoriquement chez le vendeur.
*   **Besoin** : Un système de **Wallet** intermédiaire où les fonds sont bloqués ("Pending") et un Cron Job qui les libère après 14 jours si aucun litige.

### B. Règles Spécifiques Immo / Auto
*   **CDC** : "Annonce Immobilière : 25 000 FCFA / an", "Véhicules : 50 000 FCFA / an".
*   **Actuel** : Les options payantes sont génériques.
*   **Besoin** : Logique de **paiement obligatoire** à la publication pour ces catégories spécifiques.

### C. Recommandations & Cross-selling
*   **CDC** : "Produits similaires", "Achetez souvent ensemble".
*   **Actuel** : Aucune recommandation sur la fiche produit.
*   **Besoin** : Algorithme simple de suggestion basé sur la catégorie ou les tags.

### D. Notifications Avancées & SMS
*   **CDC** : "Rappel automatique expiration document", "Inscription avec SMS obligatoire".
*   **Actuel** : Notifications toast (session). Pas de SMS, pas d'emails transactionnels (expiration).
*   **Besoin** : Intégration Twilio ou autre pour SMS, et Jobs planifiés pour les emails de rappel.

---

## Plan d'Action Recommandé

Je propose de traiter ces écarts dans l'ordre de priorité (Business Value) :

1.  **Phase "Fintech"** : Implémenter le **Séquestre (Escrow)** et les règles de paiement Immo/Auto. C'est le cœur du business model.
2.  **Phase "Supply Chain"** : Finaliser les interfaces **Transporteur/Relais** pour que le QR Code serve réellement à tracer le colis.
3.  **Phase "Intelligence"** : Moteur de recherche avancé et Recommandations.
