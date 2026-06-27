# 📋 KARNOU / DWESTA MARKETPLACE — Contexte du Projet

> Fichier destiné à un agent IA (Claude, Cursor, etc.).
> À lire en entier avant toute modification.
> Dernière mise à jour : 2026-06-27.

---

## 🧭 Vision

**Karnou** (Dwesta Marketplace) est une marketplace multi-métiers (produit,
service, immobilier, véhicule) avec fintech interne (wallet + séquestre) et
chaîne logistique. L'écosystème est composé de **trois projets Laravel autonomes**
qui **partagent la même base de données MySQL `marketplace`**.

> ⚠️ Les anciens `logistique/` (Laravel 13, port 8001) et `karnou-mobile/`
> (React Native) ont été **supprimés** : remplacés par le projet `karnou-pwa/`.

---

## 🗂️ Les trois projets (dossiers frères dans `Dwesta_marketplace/`)

```
Dwesta_marketplace/
├── karnou/         ← (1) HUB MARKETPLACE  (ex-temp_laravel)   port 8000
├── karnou-pwa/     ← (2) PWA livreurs & transporteurs          port 8001
└── agence/         ← (3) PORTAIL AGENCE / POINTS RELAIS         port 8002
```

Chaque projet a son propre `vendor/`, `node_modules/`, `.env` et **dépôt git**.
Ils se rejoignent uniquement par la **base `marketplace`** partagée.

### (1) Hub Marketplace — `karnou/`
- **Rôle** : back-office admin (gestion du marketplace), API publique, fintech, commandes.
- **Stack** : Laravel 12, PHP 8.2+. **URL** : `http://127.0.0.1:8000` — admin sous `/admin/*`.
- **Auth** : Sanctum + Socialite (Google/Facebook), OTP, rôles Spatie.
- **Source de vérité métier** : modèles dans `karnou/app/Models`.
- **Design admin** : style « Amazon » — bleu `#004aad`, fond blanc.
  Référence : `resources/views/admin/categories/index.blade.php`.

### (2) PWA Partenaire — `karnou-pwa/`
- **Rôle** : application mobile-first (PWA) pour **livreurs & transporteurs de colis**.
- **Stack** : projet **Laravel autonome** (cloné depuis agence). **URL** : `http://0.0.0.0:8001/partenaire`.
- **Auth** : téléphone + OTP (`OrangeSmsChannel`). Routes `partenaire.*`, controllers `App\Http\Controllers\Partenaire\*`.
- **Base** : même base `marketplace` (modèles `User`, `Livreur`, `Transporteur`, `Order`, `Transaction`).
- Détails : voir `karnou-pwa/README.md`.

### (3) Portail Agence / Points Relais — `agence/`
- **Rôle** : gestion des **points relais** (collecte / retrait des colis).
- **Stack** : Laravel 13 autonome. **URL** : `http://0.0.0.0:8002`. Base `marketplace`.
- Détails : voir `agence/PROJECT_OVERVIEW.md`.

---

## 🔗 Données partagées (base `marketplace`)

La source de vérité reste le **hub** (`karnou/app/Models`). Agence et karnou-pwa
ont des **copies locales** des modèles, mappées sur les mêmes tables.

> ⚠️ À vérifier : l'`.env` du hub est en `DB_CONNECTION=sqlite` en local, alors
> qu'`agence/` et `karnou-pwa/` ciblent MySQL `marketplace`. Aligner pour un dev cohérent.
>
> ⚠️ Sessions : les 3 apps utilisent `SESSION_DRIVER=database` sur la base partagée.
> Garder un `SESSION_COOKIE` distinct par app (déjà fait pour karnou-pwa).

### Cycle de vie d'une commande (`Order`)
`pret_expedition` → `en_route` → `disponible (relais)` → `livre`
- **Séquestre** : fonds bloqués à l'achat, libérés au vendeur à la livraison.
- **karnou-pwa** : le livreur/transporteur accepte une course, la suit, la termine
  (code 4 chiffres pour le livreur → libération des fonds).
- **agence** : gère l'étape « disponible (relais) ».

---

## 🚀 Lancer les projets

```bash
cd karnou     && php artisan serve --host=0.0.0.0 --port=8000   # hub + admin
cd karnou-pwa && php artisan serve --host=0.0.0.0 --port=8001   # PWA partenaire (/partenaire)
cd agence     && php artisan serve --host=0.0.0.0 --port=8002   # portail agence
```

---

## 🎨 Règles de design (OBLIGATOIRES)

1. **Admin hub** : s'aligner sur `karnou/resources/views/admin/categories/index.blade.php`.
2. **PWA partenaire** : coquille mobile sombre, bleu `#004AAD` + orange `#FF6B00`.
3. **Couleur principale** : `#004aad` (Karnou Blue) — ne jamais changer.
4. **Pas de nouvelle dépendance** sans vérifier que le projet compile.

---

## 📌 Instructions pour l'agent IA

1. **Ne jamais casser l'existant** — analyser avant de modifier.
2. **3 projets, 3 dépôts** : un changement dans l'un ne touche pas les autres,
   sauf via le schéma de la base partagée `marketplace`.
3. **Vérifier la cohérence** routes / controllers / vues.
4. Après tout changement d'autoload : `composer dump-autoload`.
