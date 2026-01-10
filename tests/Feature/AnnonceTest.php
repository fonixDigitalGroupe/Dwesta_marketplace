<?php

namespace Tests\Feature;

use App\Models\Annonce;
use App\Models\Category;
use App\Models\User;
use App\Models\Vendeur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AnnonceTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Vendeur $vendeur;
    protected Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->vendeur = Vendeur::factory()->create([
            'user_id' => $this->user->id,
            'statut_verification' => 'verifie',
        ]);
        $this->category = Category::factory()->create();
    }

    /** @test */
    public function un_vendeur_peut_creer_une_annonce_produit()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('annonces.store'), [
            'type' => Annonce::TYPE_PRODUIT,
            'categorie_id' => $this->category->id,
            'titre' => 'Produit de test',
            'description' => 'Description détaillée du produit de test avec au moins 20 caractères',
            'prix' => 50000,
            'marque' => 'Marque Test',
            'modele' => 'Modèle Test',
            'etat' => 'Neuf',
            'quantite' => 1,
            'statut' => 'brouillon',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('annonces', [
            'titre' => 'Produit de test',
            'type' => Annonce::TYPE_PRODUIT,
            'vendeur_id' => $this->vendeur->id,
        ]);
    }

    /** @test */
    public function un_vendeur_peut_creer_une_annonce_service()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('annonces.store'), [
            'type' => Annonce::TYPE_SERVICE,
            'categorie_id' => $this->category->id,
            'titre' => 'Service de test',
            'description' => 'Description détaillée du service de test avec au moins 20 caractères',
            'type_tarification' => 'fixe',
            'prix' => 10000,
            'duree_estimee' => '2 heures',
            'statut' => 'brouillon',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('annonces', [
            'titre' => 'Service de test',
            'type' => Annonce::TYPE_SERVICE,
        ]);
    }

    /** @test */
    public function un_vendeur_peut_creer_une_annonce_immobilier()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('annonces.store'), [
            'type' => Annonce::TYPE_IMMOBILIER,
            'categorie_id' => $this->category->id,
            'titre' => 'Appartement de test',
            'description' => 'Description détaillée de l\'appartement de test avec au moins 20 caractères',
            'type_transaction' => 'vente',
            'prix_vente' => 50000000,
            'surface' => 100,
            'pieces' => 3,
            'chambres' => 2,
            'statut' => 'brouillon',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('annonces', [
            'titre' => 'Appartement de test',
            'type' => Annonce::TYPE_IMMOBILIER,
        ]);
    }

    /** @test */
    public function un_vendeur_peut_creer_une_annonce_vehicule()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('annonces.store'), [
            'type' => Annonce::TYPE_VEHICULE,
            'categorie_id' => $this->category->id,
            'titre' => 'Véhicule de test',
            'description' => 'Description détaillée du véhicule de test avec au moins 20 caractères',
            'prix' => 5000000,
            'marque' => 'Toyota',
            'modele' => 'Corolla',
            'annee' => 2020,
            'kilometrage' => 50000,
            'carburant' => 'Essence',
            'boite_vitesse' => 'Manuelle',
            'statut' => 'brouillon',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('annonces', [
            'titre' => 'Véhicule de test',
            'type' => Annonce::TYPE_VEHICULE,
        ]);
    }

    /** @test */
    public function un_vendeur_peut_publier_une_annonce_en_brouillon()
    {
        $this->actingAs($this->user);

        $annonce = Annonce::factory()->create([
            'vendeur_id' => $this->vendeur->id,
            'statut' => Annonce::STATUT_BROUILLON,
        ]);

        $response = $this->post(route('annonces.publier', $annonce));

        $response->assertRedirect();
        $this->assertDatabaseHas('annonces', [
            'id' => $annonce->id,
            'statut' => Annonce::STATUT_PUBLIEE,
        ]);
    }

    /** @test */
    public function un_vendeur_peut_modifier_sa_propre_annonce()
    {
        $this->actingAs($this->user);

        $annonce = Annonce::factory()->create([
            'vendeur_id' => $this->vendeur->id,
        ]);

        $response = $this->put(route('annonces.update', $annonce), [
            'categorie_id' => $this->category->id,
            'titre' => 'Titre modifié',
            'description' => 'Description modifiée avec au moins 20 caractères',
            'prix' => 60000,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('annonces', [
            'id' => $annonce->id,
            'titre' => 'Titre modifié',
        ]);
    }

    /** @test */
    public function un_vendeur_ne_peut_pas_modifier_une_annonce_dun_autre_vendeur()
    {
        $autreUser = User::factory()->create();
        $autreVendeur = Vendeur::factory()->create([
            'user_id' => $autreUser->id,
        ]);

        $this->actingAs($this->user);

        $annonce = Annonce::factory()->create([
            'vendeur_id' => $autreVendeur->id,
        ]);

        $response = $this->put(route('annonces.update', $annonce), [
            'titre' => 'Titre modifié',
            'description' => 'Description modifiée',
        ]);

        $response->assertRedirect(route('annonces.index'));
        $this->assertDatabaseMissing('annonces', [
            'id' => $annonce->id,
            'titre' => 'Titre modifié',
        ]);
    }

    /** @test */
    public function un_vendeur_peut_supprimer_sa_propre_annonce()
    {
        $this->actingAs($this->user);

        $annonce = Annonce::factory()->create([
            'vendeur_id' => $this->vendeur->id,
        ]);

        $response = $this->delete(route('annonces.destroy', $annonce));

        $response->assertRedirect(route('annonces.index'));
        $this->assertDatabaseMissing('annonces', [
            'id' => $annonce->id,
        ]);
    }

    /** @test */
    public function une_annonce_publiee_est_accessible_publiquement()
    {
        $annonce = Annonce::factory()->publiee()->create([
            'vendeur_id' => $this->vendeur->id,
        ]);

        $response = $this->get(route('annonces.show', $annonce));

        $response->assertStatus(200);
        $response->assertSee($annonce->titre);
    }

    /** @test */
    public function le_compteur_de_vues_est_incremente()
    {
        $annonce = Annonce::factory()->publiee()->create([
            'vendeur_id' => $this->vendeur->id,
            'vues' => 0,
        ]);

        $this->get(route('annonces.show', $annonce));
        $this->get(route('annonces.show', $annonce));

        $annonce->refresh();
        $this->assertEquals(2, $annonce->vues);
    }
}
