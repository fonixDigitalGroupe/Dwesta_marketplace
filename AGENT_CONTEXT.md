# 📋 KARNOU MARKETPLACE — Contexte Complet du Projet
> Ce fichier est destiné à un agent IA (Antigravity, Cursor, Qwen, etc.).
> Lisez-le en intégralité avant de modifier quoi que ce soit.

---

## 🧭 Vision du Projet

**Karnou** est une plateforme marketplace multi-tenant composée de :
1. **Backend principal** (`temp_laravel/`) — Laravel 12, admin + API publique
2. **Module Logistique** (`temp_laravel/logistique/`) — Laravel 13, app chauffeurs/livreurs
3. **Application Mobile** (`temp_laravel/karnou-mobile/`) — React Native / Expo

La philosophie est simple : **le backend web est la source de vérité**. Le mobile et l'API doivent coller exactement à la logique web.

---

## 🗂️ Structure des Projets

```
temp_laravel/
├── app/                    # Laravel principal (port 8000)
├── logistique/             # Sous-projet logistique (port 8001)
├── karnou-mobile/          # App mobile React Native / Expo
├── resources/views/admin/  # Interfaces admin
└── AGENT_CONTEXT.md        # ← CE FICHIER
```

---

## 🖥️ Backend Principal (`temp_laravel/`)

**URL :** `http://127.0.0.1:8000`
**DB :** MySQL — base `marketplace`
**Auth :** Laravel Sanctum + Socialite (Google, Facebook)

### Modules actifs
| Module | Route admin | État |
|---|---|---|
| Catégories (N1, N2, N3) | `/admin/categories/*` | ✅ Fonctionnel |
| Roles & Permissions | `/admin/roles` | ✅ Fonctionnel |
| Pays | `/admin/countries` | ✅ Fonctionnel |
| Abonnements | `/admin/subscriptions` | ✅ Fonctionnel |
| Utilisateurs | `/admin/users` | ✅ Fonctionnel |
| Annonces | `/admin/annonces` | ✅ Fonctionnel |
| Telescope | `/telescope` | ✅ Installé |

### Design UI Admin
- Style "Amazon-style" / Enterprise SaaS
- Palette : bleu Amazon (`#004aad`), fond blanc
- Référence design : `/resources/views/admin/categories/index.blade.php`
- **RÈGLE** : toute nouvelle interface admin doit ressembler à cette référence

### Notifications
- `EmailOtpNotification` → Canal `mail`
- OTP stocké dans `users.otp_code` + `users.otp_expires_at`
- SMTP local sur port 1025 (Mailtrap/MailHog)

---

## 📦 Module Logistique (`logistique/`)

**URL :** `http://127.0.0.1:8001`
**Port :** 8001
**DB :** MySQL — même base `marketplace` (DB_DATABASE=marketplace)

### Ce qui est fait
- Auth par téléphone/email avec OTP
- `OtpSmsNotification` → canal `mail` + `database`
- API `/api/otp/send` opérationnelle (testée et fonctionnelle)
- Telescope installé (migrations partagées avec le projet principal)

### ⚠️ Problème connu
- `MAIL_MAILER=log` dans `.env` (changé pour éviter l'erreur port 1025)
- L'envoi SMS réel n'est pas encore branché (mocké)

### API disponible
```
POST /api/otp/send
Body: { "phone": "+221XXXXXXXX" }
Response: { "success": true, "debug_otp": "XXXX" }
```

---

## 📱 Application Mobile (`karnou-mobile/`)

**Framework :** React Native + Expo
**Lancer :** `npx expo start` depuis `karnou-mobile/`
**Test téléphone :** Scanner le QR code avec l'app Expo Go

### Écrans principaux
| Écran | Fichier | État |
|---|---|---|
| Splash | `SplashScreen.js` | ✅ |
| Onboarding | `OnboardingScreen.js` | ✅ |
| Login Téléphone | `PhoneLoginScreen.js` | ✅ Avec masque |
| OTP | `OTPScreen.js` | ✅ Affiche le bon numéro |
| Dashboard | `DashboardScreen.js` | ✅ |

### Composants
- `CountryCodePicker.js` — Sélecteur de pays restreint aux pays actifs en BDD
- Liste des pays : Sénégal (+221), Côte d'Ivoire (+225), Congo (+242), etc.

### Thème
```javascript
Colors.primary = '#004aad'  // Karnou Blue
Colors.white = '#FFFFFF'
Colors.text = '#1A1A1A'
Colors.textSecondary = '#6B7280'
```

### Connexion Mobile → Backend
- **URL API configurée :** `https://2120a94a1c16aa.lhr.life/api/otp/send` (tunnel temporaire)
- ⚠️ Ce tunnel expire ! En production, utiliser l'IP locale si même réseau Wi-Fi
- Pour tester en local : changer `API_URL` dans `PhoneLoginScreen.js` → `http://IP_ORDI:8001/api/otp/send`
- Le téléphone doit être sur le **même réseau Wi-Fi** que l'ordinateur

---

## 🔧 Problèmes Connus & À Faire

### 🔴 Critique
- [ ] L'envoi SMS réel n'est pas encore implémenté (OTP généré mais pas envoyé par SMS)
- [ ] La connexion mobile → API dépend d'un tunnel temporaire (pas stable)
- [ ] Le bouton "Valider" de l'écran OTP renvoie vers `Onboarding` (non branché à la vraie vérification)

### 🟡 Important
- [ ] Implémenter un vrai fournisseur SMS (ex: Twilio, Orange SMS, etc.)
- [ ] Brancher le flux complet : Login → OTP → Dashboard avec vérification backend
- [ ] Mettre une IP fixe ou variable d'environnement pour l'URL API mobile

### 🟢 Améliorations
- [ ] Ajouter un timer de renvoi d'OTP (actuellement affiche "00:59" figé)
- [ ] Implémenter la persistence de session (AsyncStorage)
- [ ] Ajouter le flux "Compte existant / Nouveau compte"

---

## 🚀 Comment Lancer le Projet

```bash
# Terminal 1 — Backend principal
cd temp_laravel
php artisan serve --host=0.0.0.0 --port=8000

# Terminal 2 — Module logistique
cd temp_laravel/logistique
php artisan serve --host=0.0.0.0 --port=8001

# Terminal 3 — App mobile
cd temp_laravel/karnou-mobile
npx expo start
```

---

## 🎨 Règles de Design (OBLIGATOIRES)

1. **Admin Web** : Toujours s'aligner sur `/resources/views/admin/categories/index.blade.php`
2. **Mobile** : Toujours utiliser les constantes `Colors`, `Spacing`, `Radius` de `src/constants/Theme.js`
3. **Couleur principale** : `#004aad` (Karnou Blue) — jamais changer
4. **Pas de nouvelles dépendances** sans vérification que le projet compile

---

## 📌 Instructions pour l'Agent IA

1. **Lire ce fichier en premier** avant toute action
2. **Ne jamais casser l'existant** — analyser avant de modifier
3. **Toujours vérifier** que les routes, controllers et vues sont cohérents
4. **Style admin** = référence catégories, **style mobile** = constantes Theme.js
5. **L'API logistique (port 8001) est la porte d'entrée** pour le mobile
6. **Git avant chaque grosse modification** : `git add . && git commit -m "backup"`

---

*Dernière mise à jour : 2026-05-20 — État : Développement actif*
