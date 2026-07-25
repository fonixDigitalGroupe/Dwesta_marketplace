# Mise en production — Karnou Mobile

Publier l'app se fait **depuis votre machine** avec un compte **Expo (EAS)** et les
comptes développeurs des stores. Voici la marche à suivre.

## 0. Prérequis (une seule fois)
- **Compte Expo** (gratuit) : https://expo.dev/signup
- **Google Play Console** : 25 $ (paiement unique) → https://play.google.com/console
- **Apple Developer** (si iOS) : 99 $/an → https://developer.apple.com/programs
- Outils : `npm i -g eas-cli` puis `eas login`
- ⚠️ **L'API doit être en ligne** : déployez le backend Laravel (routes/api.php),
  puis vérifiez `https://karnou.com/api/annonces` renvoie du JSON.

## 1. Vérifier l'URL de l'API (prod)
Dans `app.json` → `expo.extra.apiBaseUrl` doit pointer sur la prod :
```json
"apiBaseUrl": "https://karnou.com/api"
```

## 2. Lier le projet à EAS
```bash
cd karnou-mobile
npm install
eas init          # crée le projet sur votre compte Expo (génère un projectId)
```

## 3. Build Android (le plus simple pour démarrer)

### a) APK de test (installable directement, partageable)
```bash
eas build -p android --profile preview
```
→ EAS renvoie un **lien de téléchargement de l'APK** : installez-le sur n'importe quel
téléphone Android (ou partagez le lien à vos testeurs). **C'est la façon la plus rapide
d'avoir l'app "en prod" en interne**, sans passer par le Play Store.

### b) Build de production (Play Store — fichier .aab)
```bash
eas build -p android --profile production
```
Puis soumission au Play Store :
```bash
eas submit -p android --latest
```
(nécessite un compte Play Console + une fiche app créée)

## 4. Build iOS (optionnel)
```bash
eas build -p ios --profile production
eas submit -p ios --latest
```
(nécessite un compte Apple Developer ; build possible sans Mac grâce à EAS)

## 5. Mises à jour rapides (OTA, sans re-publier)
Pour les changements JS/UI (pas les libs natives) :
```bash
eas update --branch production --message "Correctif X"
```
L'app récupère la mise à jour au prochain lancement (aucune validation store).

## Résumé du chemin le plus rapide vers "en prod"
1. Déployer l'API Laravel sur karnou.com ✅
2. `eas init` + `eas build -p android --profile preview` → **APK partageable** (prod interne immédiate)
3. Ensuite, quand prêt : `--profile production` + `eas submit` → **Play Store / App Store**

## Icône & splash (avant publication store)
Ajoutez vos visuels et référencez-les dans `app.json` :
```json
"icon": "./assets/icon.png",
"splash": { "image": "./assets/splash.png", "backgroundColor": "#004aad" },
"android": { "adaptiveIcon": { "foregroundImage": "./assets/adaptive-icon.png", "backgroundColor": "#004aad" } }
```
