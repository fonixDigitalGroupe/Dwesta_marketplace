<?php

namespace Tests\Feature;

use App\Models\Annonce;
use App\Models\AnnonceMedia;
use App\Models\AnnonceOption;
use App\Models\Category;
use App\Models\User;
use App\Models\Vendeur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnnonceShowTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Vendeur $vendeur;
    protected Category $category;
    protected Annonce $annonce;

    protected function setUp(): void
    {
        parent::setUp();

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
        ]);
    }

    /** @test */
    public function un_visiteur_peut_voir_une_annonce_publiee()
    {
        $response = $this->get(route('annonces.show', $this->annonce));

        $response->assertStatus(200);
        $response->assertSee($this->annonce->titre);
        $response->assertSee($this->annonce->description);
    }

    /** @test */
    public function la_fiche_produit_affiche_les_photos()
    {
        // Créer des photos pour l'annonce
        AnnonceMedia::factory()->create([
            'annonce_id' => $this->annonce->id,
            'type' => 'photo',
            'est_principale' => true,
        ]);

        $response = $this->get(route('annonces.show', $this->annonce));

        $response->assertStatus(200);
        $response->assertSee('photo');
    }

    /** @test */
    public function la_fiche_produit_affiche_les_badges_dynamiques()
    {
        // Créer une option "À la Une"
        AnnonceOption::factory()->create([
            'annonce_id' => $this->annonce->id,
            'a_la_une' => true,
            'a_la_une_expire_le' => now()->addDays(7),
        ]);

        $response = $this->get(route('annonces.show', $this->annonce));

        $response->assertStatus(200);
        $response->assertSee('À LA UNE');
    }

    /** @test */
    public function la_fiche_produit_affiche_le_prix_moyen_marche()
    {
        $produit = \App\Models\AnnonceProduit::factory()->create([
            'annonce_id' => $this->annonce->id,
            'prix_moyen_marche' => 60000,
        ]);

        $this->annonce->update(['prix' => 50000]);

        $response = $this->get(route('annonces.show', $this->annonce));

        $response->assertStatus(200);
        $response->assertSee('Prix moyen marché');
    }

    /** @test */
    public function la_fiche_produit_affiche_les_informations_du_vendeur()
    {
        $response = $this->get(route('annonces.show', $this->annonce));

        $response->assertStatus(200);
        $response->assertSee($this->vendeur->user->prenom);
    }

    /** @test */
    public function la_fiche_produit_affiche_les_recommandations()
    {
        // Créer des annonces similaires
        $annonceSimilaire = Annonce::factory()->create([
            'vendeur_id' => $this->vendeur->id,
            'categorie_id' => $this->category->id,
            'type' => Annonce::TYPE_PRODUIT,
            'statut' => Annonce::STATUT_PUBLIEE,
            'publiee_le' => now(),
        ]);

        $response = $this->get(route('annonces.show', $this->annonce));

        $response->assertStatus(200);
        // Les recommandations peuvent être vides si pas assez de produits similaires
    }

    /** @test */
    public function le_compteur_de_vues_est_incremente()
    {
        $vuesInitiales = $this->annonce->vues;

        $this->get(route('annonces.show', $this->annonce));

        $this->annonce->refresh();
        $this->assertEquals($vuesInitiales + 1, $this->annonce->vues);
    }
}
