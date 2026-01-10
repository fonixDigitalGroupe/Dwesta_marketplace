# Guide de Test Manuel - Phase 5 : Fiche Produit et Affichage

## 📋 Table des matières
1. [Structure fiche produit](#1-structure-fiche-produit)
2. [Description et détails](#2-description-et-détails)
3. [Système d'avis clients](#3-système-davis-clients)
4. [Recommandations produits](#4-recommandations-produits)
5. [Tests responsive](#5-tests-responsive)

---

## 1. Structure fiche produit

### 1.1 Affichage de base
- [ ] Accéder à une annonce publiée : [http://localhost:8000/annonces/{id}](http://localhost:8000/annonces/1)
- [ ] Vérifier que le titre s'affiche correctement
- [ ] Vérifier que le breadcrumb s'affiche (Accueil / Catégorie / Titre)
- [ ] Vérifier que la description s'affiche

### 1.2 Galerie photos avec lightbox
- [ ] Vérifier que la photo principale s'affiche en grand
- [ ] Si plusieurs photos, vérifier que les miniatures s'affichent en bas
- [ ] Cliquer sur la photo principale → vérifier que le lightbox s'ouvre
- [ ] Dans le lightbox :
  - [ ] Vérifier que l'image s'affiche en grand
  - [ ] Cliquer sur les flèches gauche/droite → vérifier la navigation
  - [ ] Appuyer sur Échap → vérifier que le lightbox se ferme
  - [ ] Utiliser les flèches du clavier (← →) → vérifier la navigation
- [ ] Cliquer sur une miniature → vérifier que la photo principale change
- [ ] Vérifier que la miniature active a une bordure rouge

### 1.3 Intégration vidéo
- [ ] Si l'annonce a une vidéo, vérifier qu'elle s'affiche
- [ ] Vérifier que le lecteur vidéo fonctionne (play, pause, volume)
- [ ] Vérifier le design de la section vidéo

### 1.4 Affichage prix + prix moyen marché
- [ ] Vérifier que le prix s'affiche en grand et en rouge
- [ ] Si l'annonce a un prix moyen marché :
  - [ ] Vérifier que le prix moyen marché s'affiche (barré)
  - [ ] Si le prix est inférieur au prix moyen, vérifier le message "Économisez X FCFA !"

### 1.5 Badges dynamiques
- [ ] Vérifier les badges en haut de la page :
  - [ ] Badge "⭐ À LA UNE" (si option active)
  - [ ] Badge "🔥 URGENT" (si option active)
  - [ ] Badge "✓ Vendeur Vérifié" (si vendeur vérifié)
  - [ ] Badge "🏢 Professionnel" (si vendeur professionnel)

---

## 2. Description et détails

### 2.1 Description formatée
- [ ] Vérifier que la description s'affiche avec un bon formatage
- [ ] Vérifier que les retours à la ligne sont respectés
- [ ] Vérifier la lisibilité (taille de police, espacement)

### 2.2 Options de livraison
- [ ] Vérifier que le type de livraison s'affiche dans la sidebar :
  - [ ] 🚚 Livraison
  - [ ] 📦 Retrait
  - [ ] 🚚📦 Livraison ou Retrait

### 2.3 Informations vendeur
- [ ] Vérifier que le nom du vendeur s'affiche
- [ ] Si vendeur vérifié, vérifier le badge "✓ Compte vérifié"
- [ ] Si page pro existe, vérifier le lien "Voir la page pro →"
- [ ] Cliquer sur le lien → vérifier la redirection

### 2.4 Disponibilité en temps réel
- [ ] Vérifier que la disponibilité s'affiche :
  - [ ] ✓ En stock (vert)
  - [ ] ✗ Rupture de stock (rouge)
  - [ ] ⏳ Sur commande (jaune)

---

## 3. Système d'avis clients

### 3.1 Affichage des avis
- [ ] Vérifier que la section "Avis clients" s'affiche
- [ ] Vérifier que la note moyenne s'affiche (étoiles + note/5)
- [ ] Vérifier que le nombre d'avis s'affiche
- [ ] Si des avis existent :
  - [ ] Vérifier que les 5 premiers avis s'affichent
  - [ ] Vérifier que chaque avis affiche :
    - [ ] Nom de l'utilisateur
    - [ ] Note (étoiles)
    - [ ] Date de publication
    - [ ] Commentaire
    - [ ] Photos si présentes
  - [ ] Si plus de 5 avis, vérifier le lien "Voir tous les avis"

### 3.2 Création d'un avis
- [ ] Se connecter avec un compte utilisateur
- [ ] Accéder à une annonce : [http://localhost:8000/annonces/{id}](http://localhost:8000/annonces/1)
- [ ] Cliquer sur "✍️ Laisser un avis"
- [ ] Vérifier que le formulaire s'affiche
- [ ] Tester la notation par étoiles :
  - [ ] Survoler les étoiles → vérifier que le texte change (Très mauvais, Mauvais, Moyen, Bon, Excellent)
  - [ ] Cliquer sur une étoile → vérifier que la sélection fonctionne
- [ ] Remplir le formulaire :
  - [ ] Note : 5 étoiles
  - [ ] Commentaire : "Excellent produit, je recommande !"
  - [ ] Photos (optionnel) : uploader 1-3 photos
- [ ] Soumettre le formulaire
- [ ] Vérifier le message de succès
- [ ] Vérifier que l'avis est en attente de modération (ne s'affiche pas encore)

### 3.3 Modération des avis (Admin)
- [ ] Se connecter en tant qu'administrateur
- [ ] Accéder à la modération : [http://localhost:8000/admin/avis/moderation](http://localhost:8000/admin/avis/moderation)
- [ ] Vérifier que les avis en attente s'affichent
- [ ] Pour chaque avis :
  - [ ] Vérifier les informations (utilisateur, annonce, note, commentaire, photos)
  - [ ] Cliquer sur "✓ Approuver" → vérifier que l'avis est approuvé
  - [ ] OU cliquer sur "✗ Rejeter" → remplir la raison → confirmer → vérifier que l'avis est rejeté
- [ ] Retourner sur la fiche produit → vérifier que l'avis approuvé s'affiche
- [ ] Vérifier que l'avis rejeté ne s'affiche pas

### 3.4 Liste complète des avis
- [ ] Sur une annonce avec des avis, cliquer sur "Voir tous les avis"
- [ ] Vérifier que la page liste tous les avis : [http://localhost:8000/annonces/{id}/avis](http://localhost:8000/annonces/1/avis)
- [ ] Vérifier la pagination si nécessaire

---

## 4. Recommandations produits

### 4.1 Produits similaires
- [ ] Accéder à une annonce : [http://localhost:8000/annonces/{id}](http://localhost:8000/annonces/1)
- [ ] Scroller jusqu'à la section "Produits similaires"
- [ ] Vérifier que des produits de la même catégorie s'affichent
- [ ] Vérifier le carrousel horizontal (scroll)
- [ ] Pour chaque produit :
  - [ ] Vérifier que la photo s'affiche
  - [ ] Vérifier que le titre s'affiche
  - [ ] Vérifier que le prix s'affiche
  - [ ] Vérifier que la catégorie s'affiche
  - [ ] Cliquer sur le produit → vérifier la redirection vers sa fiche

### 4.2 Produits sponsorisés
- [ ] Vérifier que la section "Produits sponsorisés" s'affiche avec un design distinctif (fond dégradé)
- [ ] Vérifier que seuls les produits avec option "À la Une" s'affichent
- [ ] Vérifier le badge "⭐" sur chaque produit sponsorisé
- [ ] Vérifier le carrousel horizontal

### 4.3 Achetez souvent ensemble
- [ ] Vérifier que la section "Achetez souvent ensemble" s'affiche
- [ ] Vérifier que seuls les produits avec des avis s'affichent
- [ ] Vérifier que les notes moyennes s'affichent (étoiles + nombre d'avis)
- [ ] Vérifier le carrousel horizontal

### 4.4 Test avec différentes annonces
- [ ] Tester avec une annonce produit
- [ ] Tester avec une annonce service
- [ ] Tester avec une annonce immobilier
- [ ] Tester avec une annonce véhicule
- [ ] Vérifier que les recommandations sont adaptées au type d'annonce

---

## 5. Tests responsive

### 5.1 Desktop (≥1200px)
- [ ] Vérifier que la mise en page en 2 colonnes fonctionne
- [ ] Vérifier que la sidebar est sticky
- [ ] Vérifier que les carrousels fonctionnent bien

### 5.2 Tablette (768px - 1199px)
- [ ] Vérifier que la mise en page s'adapte
- [ ] Vérifier que les carrousels restent utilisables

### 5.3 Mobile (<768px)
- [ ] Vérifier que la mise en page passe en une colonne
- [ ] Vérifier que les photos s'affichent correctement
- [ ] Vérifier que le lightbox fonctionne sur mobile
- [ ] Vérifier que les carrousels sont scrollables horizontalement
- [ ] Vérifier que tous les boutons sont accessibles

---

## 🔗 Liens utiles

### Pages principales
- **Accueil** : [http://localhost:8000](http://localhost:8000)
- **Dashboard** : [http://localhost:8000/dashboard](http://localhost:8000/dashboard)
- **Mes annonces** : [http://localhost:8000/annonces](http://localhost:8000/annonces)
- **Créer une annonce** : [http://localhost:8000/annonces/create?type=produit](http://localhost:8000/annonces/create?type=produit)

### Administration
- **Modération avis** : [http://localhost:8000/admin/avis/moderation](http://localhost:8000/admin/avis/moderation)
- **Gestion catégories** : [http://localhost:8000/admin/categories](http://localhost:8000/admin/categories)

### Exemples d'annonces (remplacer {id} par un ID réel)
- **Annonce produit** : [http://localhost:8000/annonces/{id}](http://localhost:8000/annonces/1)
- **Annonce service** : [http://localhost:8000/annonces/{id}](http://localhost:8000/annonces/2)
- **Annonce immobilier** : [http://localhost:8000/annonces/{id}](http://localhost:8000/annonces/3)
- **Annonce véhicule** : [http://localhost:8000/annonces/{id}](http://localhost:8000/annonces/4)

---

## ✅ Checklist finale

- [ ] Toutes les fonctionnalités de la fiche produit fonctionnent
- [ ] Le système d'avis fonctionne (création, modération, affichage)
- [ ] Les recommandations s'affichent correctement
- [ ] Le design est responsive
- [ ] Les performances sont acceptables
- [ ] Aucune erreur dans les logs

---

## 📝 Notes

- Les tests automatisés sont disponibles dans `tests/Feature/AnnonceShowTest.php`, `AvisTest.php`, et `RecommandationServiceTest.php`
- Pour exécuter les tests : `php artisan test --filter=Phase5`
- Les recommandations "Achetez souvent ensemble" utilisent actuellement les notes. Un vrai algorithme basé sur les commandes sera implémenté en Phase 7.

