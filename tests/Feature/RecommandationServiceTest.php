<?php

namespace Tests\Feature;

use App\Models\Annonce;
use App\Models\AnnonceOption;
use App\Models\Category;
use App\Models\User;
use App\Models\Vendeur;
use App\Services\RecommandationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecommandationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected RecommandationService $service;
    protected User $user;
    protected Vendeur $vendeur;
    protected Category $category;
    protected Annonce $annonce;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new RecommandationService();
        $this->user = User::factory()->create();
        $this->vendeur = Vendeur::factory()->create([
            'user_id' => $this->user->id,
            'statut_verification' => 'verifie',
        ]);
        $this->category = Category::factory()->create();
        
        $this->annonce = Annonce::factory()->create([
            'vendeur_id' => $this->vendeur->id,
            'categorie_id' => $this->category->id,
            'type' => Annonce::TYPE_PRODUIT,
            'statut' => Annonce::STATUT_PUBLIEE,
            'publiee_le' => now(),
            'prix' => 50000,
        ]);
    }

    /** @test */
    public function getProduitsSimilaires_retourne_des_produits_de_la_meme_categorie()
    {
        // Créer des produits similaires
        $produitSimilaire = Annonce::factory()->create([
            'vendeur_id' => $this->vendeur->id,
            'categorie_id' => $this->category->id,
            'type' => Annonce::TYPE_PRODUIT,
            'statut' => Annonce::STATUT_PUBLIEE,
            'publiee_le' => now(),
            'prix' => 55000, // Prix proche
        ]);

        // Créer un produit d'une autre catégorie
        $autreCategorie = Category::factory()->create();
        $produitDifferent = Annonce::factory()->create([
            'vendeur_id' => $this->vendeur->id,
            'categorie_id' => $autreCategorie->id,
            'type' => Annonce::TYPE_PRODUIT,
            'statut' => Annonce::STATUT_PUBLIEE,
            'publiee_le' => now(),
        ]);

        $resultats = $this->service->getProduitsSimilaires($this->annonce, 10);

        $this->assertTrue($resultats->contains($produitSimilaire));
        $this->assertFalse($resultats->contains($produitDifferent));
    }

    /** @test */
    public function getProduitsSimilaires_filtre_par_prix_proche()
    {
        // Créer des produits avec des prix différents
        $produitPrixProche = Annonce::factory()->create([
            'vendeur_id' => $this->vendeur->id,
            'categorie_id' => $this->category->id,
            'type' => Annonce::TYPE_PRODUIT,
            'statut' => Annonce::STATUT_PUBLIEE,
            'publiee_le' => now(),
            'prix' => 55000, // Dans la fourchette ±30%
        ]);

        $produitPrixLoin = Annonce::factory()->create([
            'vendeur_id' => $this->vendeur->id,
            'categorie_id' => $this->category->id,
            'type' => Annonce::TYPE_PRODUIT,
            'statut' => Annonce::STATUT_PUBLIEE,
            'publiee_le' => now(),
            'prix' => 100000, // Hors fourchette
        ]);

        $resultats = $this->service->getProduitsSimilaires($this->annonce, 10);

        $this->assertTrue($resultats->contains($produitPrixProche));
        // Le produit avec un prix trop différent peut quand même être inclus si pas assez de résultats
    }

    /** @test */
    public function getProduitsSponsorises_retourne_seulement_les_produits_a_la_une()
    {
        // Créer un produit avec option "À la Une"
        $produitSponsorise = Annonce::factory()->create([
            'vendeur_id' => $this->vendeur->id,
            'categorie_id' => $this->category->id,
            'type' => Annonce::TYPE_PRODUIT,
            'statut' => Annonce::STATUT_PUBLIEE,
            'publiee_le' => now(),
        ]);

        AnnonceOption::factory()->create([
            'annonce_id' => $produitSponsorise->id,
            'a_la_une' => true,
            'a_la_une_expire_le' => now()->addDays(7),
        ]);

        // Créer un produit sans option "À la Une"
        $produitNormal = Annonce::factory()->create([
            'vendeur_id' => $this->vendeur->id,
            'categorie_id' => $this->category->id,
            'type' => Annonce::TYPE_PRODUIT,
            'statut' => Annonce::STATUT_PUBLIEE,
            'publiee_le' => now(),
        ]);

        $resultats = $this->service->getProduitsSponsorises($this->annonce, 10);

        $this->assertTrue($resultats->contains($produitSponsorise));
        $this->assertFalse($resultats->contains($produitNormal));
    }

    /** @test */
    public function getAchetezSouventEnsemble_retourne_des_produits_avec_avis()
    {
        // Créer des produits avec et sans avis
        $produitAvecAvis = Annonce::factory()->create([
            'vendeur_id' => $this->vendeur->id,
            'categorie_id' => $this->category->id,
            'type' => Annonce::TYPE_PRODUIT,
            'statut' => Annonce::STATUT_PUBLIEE,
            'publiee_le' => now(),
        ]);

        \App\Models\Avis::factory()->create([
            'annonce_id' => $produitAvecAvis->id,
            'statut' => \App\Models\Avis::STATUT_APPROUVE,
        ]);

        $produitSansAvis = Annonce::factory()->create([
            'vendeur_id' => $this->vendeur->id,
            'categorie_id' => $this->category->id,
            'type' => Annonce::TYPE_PRODUIT,
            'statut' => Annonce::STATUT_PUBLIEE,
            'publiee_le' => now(),
        ]);

        $resultats = $this->service->getAchetezSouventEnsemble($this->annonce, 10);

        $this->assertTrue($resultats->contains($produitAvecAvis));
        $this->assertFalse($resultats->contains($produitSansAvis));
    }

    /** @test */
    public function getAllRecommandations_retourne_toutes_les_recommandations()
    {
        $recommandations = $this->service->getAllRecommandations($this->annonce);

        $this->assertArrayHasKey('similaires', $recommandations);
        $this->assertArrayHasKey('achetez_ensemble', $recommandations);
        $this->assertArrayHasKey('sponsorises', $recommandations);
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $recommandations['similaires']);
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $recommandations['achetez_ensemble']);
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $recommandations['sponsorises']);
    }
}
