# 📋 KARNOU / DWESTA MARKETPLACE — Contexte du Projet

> Fichier destiné à un agent IA (Claude, Cursor, etc.).
> À lire en entier avant toute modification.
> Dernière mise à jour : 2026-06-27.

---

## 🧭 Vision

**Karnou** (Dwesta Marketplace) est une marketplace multi-métiers (produit,
service, immobilier, véhicule) avec fintech interne (wallet + séquestre) et
chaîne logistique. L'écosystème est composé de **trois projets** qui
**partagent la même base de données MySQL `marketplace`**.

> ⚠️ Les anciens sous-projets `logistique/` (Laravel 13, port 8001) et
> `karnou-mobile/` (React Native) ont été **supprimés** : ils sont remplacés par
> le module **`karnou-pwa/`**.

---

## 🗂️ Les trois projets

```
temp_laravel/                 ← (1) HUB MARKETPLACE  +  module karnou-pwa
├── app/  resources/  routes/ ← backend principal & admin
├── karnou-pwa/               ← (2) module PWA partenaire (livreurs/transporteurs)
└── (agence/ est un dépôt frère, voir ci-dessous)

agence/                       ← (3) PORTAIL AGENCE / POINTS RELAIS (Laravel autonome)
```

### (1) Hub Marketplace — `temp_laravel/`
- **Rôle** : back-office admin (gestion du marketplace), API publique, fintech, commandes.
- **Stack** : Laravel 12, PHP 8.2+.
- **URL** : `http://127.0.0.1:8000` — admin sous `/admin/*`.
- **Auth** : Sanctum + Socialite (Google/Facebook), OTP, rôles Spatie.
- **Design admin** : style « Amazon » — bleu `#004aad`, fond blanc.
  Référence : `resources/views/admin/categories/index.blade.php`.

### (2) Module PWA Partenaire — `temp_laravel/karnou-pwa/`
- **Rôle** : application mobile-first (PWA) pour **livreurs & transporteurs de colis**.
- **Nature** : module **additif** du hub (même app Laravel, même base, même `.env`),
  branché par `KarnouPwaServiceProvider` (autoload PSR-4 `Karnou\Pwa\`).
- **URL** : `http://127.0.0.1:8000/partenaire` — préfixe de routes `partenaire.*`.
- **Backend réutilisé** : modèles `User`, `Livreur`, `Transporteur`, `Order`,
  `Transaction` ; rôles `livreur` / `transporteur`.
- Détails : voir `karnou-pwa/README.md`.

### (3) Portail Agence / Points Relais — `agence/`
- **Rôle** : gestion des **points relais** (collecte / retrait des colis).
- **Stack** : projet Laravel **autonome** (dépôt frère, vendor/node_modules propres).
- **URL** : `http://0.0.0.0:8002`.
- **Base** : **même base `marketplace`** que le hub (`DB_DATABASE=marketplace`).
- Détails : voir `agence/PROJECT_OVERVIEW.md`.

---

## 🔗 Données partagées

Les trois projets lisent/écrivent la **même base `marketplace`**. La source de
vérité métier reste le **hub** (`temp_laravel/app/Models`). Pour Agence et la PWA,
s'appuyer sur les modèles `User`, `Order`, `Vendeur`, `Transaction` du hub.

> ⚠️ À vérifier : l'`.env` du hub est en `DB_CONNECTION=sqlite` en local, alors
> qu'`agence/` cible MySQL `marketplace`. Aligner les connexions pour un dev cohérent.

### Cycle de vie d'une commande (`Order`)
`Payé` → `Prêt` → `En route` → `Disponible (relais)` → `Livré`
- **Séquestre** : fonds bloqués à l'achat, libérés au vendeur à la livraison.
- **PWA** : le livreur/transporteur accepte une course, la suit, la termine
  (code de livraison 4 chiffres pour le livreur) → libération des fonds.
- **Agence** : gère l'étape « Disponible (relais) ».

---

## 🚀 Lancer les projets

```bash
# Hub marketplace + PWA partenaire (port 8000)
cd temp_laravel && php artisan serve --host=0.0.0.0 --port=8000
#   → admin : http://127.0.0.1:8000/admin
#   → PWA   : http://127.0.0.1:8000/partenaire

# Portail agence / points relais (port 8002)
cd agence && php artisan serve --host=0.0.0.0 --port=8002
```

---

## 🎨 Règles de design (OBLIGATOIRES)

1. **Admin hub** : s'aligner sur `resources/views/admin/categories/index.blade.php`.
2. **PWA partenaire** : coquille mobile sombre, bleu `#004AAD` + orange `#FF6B00`
   (voir `karnou-pwa/resources/views/layouts/partenaire.blade.php`).
3. **Couleur principale** : `#004aad` (Karnou Blue) — ne jamais changer.
4. **Pas de nouvelle dépendance** sans vérifier que le projet compile.

---

## 📌 Instructions pour l'agent IA

1. **Ne jamais casser l'existant** — analyser avant de modifier.
2. **Le module `karnou-pwa/` est additif** : ne pas toucher aux dashboards
   `/logistique/*` du hub (routes dans `temp_laravel/routes/web.php`).
3. **Vérifier la cohérence** routes / controllers / vues.
4. Après tout changement d'autoload : `composer dump-autoload`.
