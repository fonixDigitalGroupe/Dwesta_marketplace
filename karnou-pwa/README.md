# Karnou PWA — Module Partenaire (livreurs & transporteurs)

Application mobile-first (PWA) pour les chauffeurs Karnou. Portage de l'ancienne
app React Native `karnou-mobile`. **Approche additive** : ne touche pas aux
dashboards `/logistique/*` existants.

Ce dossier `karnou-pwa/` regroupe tout le code du module (controllers, routes,
vues) hors de `app/` et `resources/`. Il est branché à Laravel par un
ServiceProvider — voir « Câblage » plus bas.

URL d'entrée : **`/partenaire`** · Préfixe de nom de route : **`partenaire.`**

## Structure du module (`karnou-pwa/`)

```
karnou-pwa/
├── README.md                         ← ce fichier
├── routes/partenaire.php             ← toutes les routes (prefixe /partenaire)
├── src/
│   ├── KarnouPwaServiceProvider.php  ← enregistre routes + vues
│   └── Http/Controllers/             ← namespace Karnou\Pwa\Http\Controllers
│       ├── PartenaireController.php   (splash / redirection)
│       ├── AuthController.php         (connexion téléphone + OTP)
│       ├── OnboardingController.php   (permissions, métier, KYC)
│       ├── DashboardController.php    (home : carte, en-ligne, position, missions)
│       ├── CourseController.php       (accept + cycle de vie + livraison)
│       └── ProfilController.php       (profil & gains)
└── resources/views/                  ← namespace de vues « partenaire »
    ├── layouts/partenaire.blade.php   → partenaire::layouts.partenaire
    ├── splash, placeholder, home, metier, permissions, profil, gains
    ├── auth/{phone,otp}
    ├── inscription/{livreur,transporteur}
    └── partials/upload
```

### Hors du module (obligatoire)

Les **assets statiques de la PWA restent dans `public/`** car ils doivent être
servis depuis la racine web du navigateur :

- `public/pwa/` — `manifest.webmanifest`, icônes, `offline.html`
- `public/sw.js` — service worker (scope `/partenaire`)

## Câblage (comment Laravel trouve le module)

| Mécanisme | Où |
|-----------|-----|
| Autoload PSR-4 `Karnou\Pwa\` → `karnou-pwa/src/` | `composer.json` |
| Enregistrement du provider | `bootstrap/providers.php` |
| Chargement routes + vues | `karnou-pwa/src/KarnouPwaServiceProvider.php` |
| Scan Tailwind des vues | `resources/css/app.css` (`@source`) |

Référencement des vues : `view('partenaire::home')`,
`@extends('partenaire::layouts.partenaire')`, `@include('partenaire::partials.upload')`.

> Après tout changement d'autoload : `composer dump-autoload`.

## Backend réutilisé (existant, dans `app/`)

- Auth OTP : `SmsOtpNotification` + `App\Channels\OrangeSmsChannel`
- Modèles : `User`, `Livreur`, `Transporteur`, `Order`, `Vendeur`, `Transaction`
- Rôles Spatie : `livreur`, `transporteur`
- Libération des fonds : même logique que `LivreurDashboardController::delivered`

## Migrations ajoutées (dans `database/migrations/`)

- `2026_06_27_000001_add_en_ligne_to_partenaires` — `en_ligne` (livreurs/transporteurs) + `position_updated_at` (users)
- `2026_06_27_000002_add_code_livraison_to_orders` — `code_livraison` (orders)

## Tester en local

```bash
./start_server.sh                 # http://0.0.0.0:8000
# puis ouvrir http://127.0.0.1:8000/partenaire
```

En `APP_ENV=local`, le code OTP s'affiche à l'écran (contrat SMS Orange expiré).
GPS / installation PWA / service worker exigent un contexte sécurisé
(`localhost` toléré ; sinon HTTPS requis en production).
