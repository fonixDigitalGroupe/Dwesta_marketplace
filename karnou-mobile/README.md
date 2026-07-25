# Karnou Mobile (React Native / Expo)

Application mobile de la marketplace Karnou. Elle consomme l'**API Laravel**
(`routes/api.php`, auth Sanctum) du projet principal.

## Prérequis
- Node.js 18+
- `npm i -g expo` (optionnel)
- L'API Laravel accessible (prod : `https://karnou.com/api`, ou en local `php artisan serve`)

## Installation
```bash
cd karnou-mobile
npm install
npx expo start
```
Puis scannez le QR code avec **Expo Go** (Android/iOS), ou lancez un émulateur.

## Configuration de l'API
L'URL de l'API est dans `app.json` → `expo.extra.apiBaseUrl` (défaut : `https://karnou.com/api`).

En développement local, remplacez-la par :
- **Android (émulateur)** : `http://10.0.2.2:8000/api`
- **iOS (simulateur)** : `http://127.0.0.1:8000/api`
- **Téléphone physique** : `http://<IP-de-votre-PC>:8000/api`

## Structure
```
app/
  _layout.tsx          # racine (QueryClient, navigation, bootstrap auth)
  (tabs)/
    _layout.tsx        # barre d'onglets (Accueil / Compte)
    index.tsx          # accueil : liste + recherche d'annonces
    compte.tsx         # profil / déconnexion
  (auth)/login.tsx     # connexion (token Sanctum)
  annonce/[id].tsx     # détail d'une annonce
src/
  config.ts            # URL de l'API
  api/client.ts        # axios + token SecureStore
  store/auth.ts        # état auth (zustand)
```

## Endpoints API utilisés
| Méthode | Endpoint | Rôle |
|---|---|---|
| POST | `/register` | Inscription (retourne un token) |
| POST | `/login` | Connexion (email ou téléphone) |
| GET | `/me` | Profil (token requis) |
| POST | `/logout` | Déconnexion |
| GET | `/annonces` | Liste (params: `search`, `categorie_id`, `famille`) |
| GET | `/annonces/{id}` | Détail |
| GET | `/categories` | Catégories (params: `parent_id`, `famille`) |

## Prochaines étapes (roadmap)
1. Catégories par famille + filtres sur l'accueil
2. Favoris ❤️, signaler une annonce
3. Panier + checkout (PayDunya WebView + Stripe SDK)
4. Messagerie + notifications push (Expo Notifications)
5. Espace vendeur (publier, abonnement, wallet)
6. Auth sociale (Google/Facebook via expo-auth-session) + OTP
