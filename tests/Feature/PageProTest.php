<?php

namespace Tests\Feature;

use App\Models\Abonnement;
use App\Models\PagePro;
use App\Models\User;
use App\Models\Vendeur;
use App\Models\VendeurAbonnement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PageProTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test création page pro automatique
     */
    public function test_creer_page_pro_automatiquement(): void
    {
        $user = User::factory()->create();
        $vendeur = Vendeur::factory()->create([
            'user_id' => $user->id,
            'statut_verification' => 'verifie',
        ]);

        // Créer un abonnement Expert
        $abonnement = Abonnement::factory()->create([
            'type' => Abonnement::TYPE_EXPERT,
            'page_pro' => true,
        ]);

        VendeurAbonnement::factory()->create([
            'vendeur_id' => $vendeur->id,
            'abonnement_id' => $abonnement->id,
            'actif' => true,
        ]);

        $this->actingAs($user);

        $response = $this->get(route('page-pro.edit'));

        $response->assertStatus(200);
        $this->assertDatabaseHas('page_pro', [
            'vendeur_id' => $vendeur->id,
        ]);
    }

    /**
     * Test accès page pro nécessite abonnement Expert
     */
    public function test_acces_page_pro_necessite_abonnement_expert(): void
    {
        $user = User::factory()->create();
        $vendeur = Vendeur::factory()->create([
            'user_id' => $user->id,
            'statut_verification' => 'verifie',
        ]);

        // Créer un abonnement Basic (sans page pro)
        $abonnement = Abonnement::factory()->create([
            'type' => Abonnement::TYPE_BASIC,
            'page_pro' => false,
        ]);

        VendeurAbonnement::factory()->create([
            'vendeur_id' => $vendeur->id,
            'abonnement_id' => $abonnement->id,
            'actif' => true,
        ]);

        $this->actingAs($user);

        $response = $this->get(route('page-pro.edit'));

        $response->assertRedirect(route('abonnements.index'));
        $response->assertSessionHas('error');
    }

    /**
     * Test mise à jour page pro
     */
    public function test_peut_mettre_a_jour_page_pro(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $vendeur = Vendeur::factory()->create([
            'user_id' => $user->id,
            'statut_verification' => 'verifie',
        ]);

        $abonnement = Abonnement::factory()->create([
            'type' => Abonnement::TYPE_EXPERT,
            'page_pro' => true,
        ]);

        VendeurAbonnement::factory()->create([
            'vendeur_id' => $vendeur->id,
            'abonnement_id' => $abonnement->id,
            'actif' => true,
        ]);

        $pagePro = PagePro::factory()->create(['vendeur_id' => $vendeur->id]);

        $this->actingAs($user);

        $logo = UploadedFile::fake()->image('logo.jpg', 200, 200);

        $response = $this->put(route('page-pro.update'), [
            'description' => 'Nouvelle description',
            'logo' => $logo,
            'telephone_contact' => '+221771234567',
        ]);

        $response->assertRedirect(route('page-pro.edit'));
        $response->assertSessionHas('success');

        $pagePro->refresh();
        $this->assertEquals('Nouvelle description', $pagePro->description);
        $this->assertNotNull($pagePro->logo);
    }

    /**
     * Test affichage public page pro
     */
    public function test_peut_afficher_page_pro_publique(): void
    {
        $pagePro = PagePro::factory()->create(['actif' => true]);

        $response = $this->get(route('page-pro.show', $pagePro->slug));

        $response->assertStatus(200);
        $response->assertViewIs('page-pro.show');
        $response->assertViewHas('pagePro');

        // Vérifier que les vues sont incrémentées
        $this->assertEquals(1, $pagePro->fresh()->vues);
    }

    /**
     * Test génération slug unique
     */
    public function test_generer_slug_unique(): void
    {
        $slug1 = PagePro::generateSlug('Test Vendeur');
        $slug2 = PagePro::generateSlug('Test Vendeur');

        $this->assertNotEquals($slug1, $slug2);
        $this->assertStringStartsWith('test-vendeur', $slug2);
    }
}
