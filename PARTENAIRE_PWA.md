# Module PWA Partenaire (livreurs & transporteurs)

Application mobile-first (PWA) pour les chauffeurs Karnou, intégrée à l'app Laravel.
Portage de l'ancienne app React Native `karnou-mobile`. **Approche additive** : ne
touche pas aux dashboards `/logistique/*` existants.

URL d'entrée : **`/partenaire`** · Préfixe de nom de route : **`partenaire.`**

## Carte des fichiers

| Rôle | Emplacement |
|------|-------------|
| **Routes** | `routes/partenaire.php` (chargé via `bootstrap/app.php`) |
| **Controllers** | `app/Http/Controllers/Partenaire/` |
| ↳ Splash / redirection | `PartenaireController.php` |
| ↳ Connexion téléphone + OTP | `AuthController.php` |
| ↳ Onboarding (permissions, métier, KYC) | `OnboardingController.php` |
| ↳ Home chauffeur (carte, en-ligne, position, missions) | `DashboardController.php` |
| ↳ Courses (accept, cycle de vie, livraison) | `CourseController.php` |
| ↳ Profil & gains | `ProfilController.php` |
| **Vues** | `resources/views/partenaire/` |
| **Layout** | `resources/views/layouts/partenaire.blade.php` |
| **Assets PWA** (manifest, icônes, page hors-ligne) | `public/pwa/` |
| **Service worker** | `public/sw.js` (scope `/partenaire`) |

## Backend réutilisé (existant)

- Auth OTP : `SmsOtpNotification` + `App\Channels\OrangeSmsChannel`
- Modèles : `User`, `Livreur`, `Transporteur`, `Order`, `Vendeur`, `Transaction`
- Rôles Spatie : `livreur`, `transporteur`
- Libération des fonds : même logique que `LivreurDashboardController::delivered`

## Migrations ajoutées

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
