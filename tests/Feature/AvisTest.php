<?php

namespace Tests\Feature;

use App\Models\Annonce;
use App\Models\Avis;
use App\Models\Category;
use App\Models\User;
use App\Models\Vendeur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AvisTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected User $acheteur;
    protected Vendeur $vendeur;
    protected Category $category;
    protected Annonce $annonce;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->acheteur = User::factory()->create();
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
    public function un_utilisateur_connecte_peut_creer_un_avis()
    {
        $this->actingAs($this->acheteur);

        $response = $this->post(route('avis.store', $this->annonce), [
            'note' => 5,
            'commentaire' => 'Excellent produit, je recommande vivement !',
        ]);

        $response->assertRedirect(route('annonces.show', $this->annonce));
        $this->assertDatabaseHas('avis', [
            'annonce_id' => $this->annonce->id,
            'user_id' => $this->acheteur->id,
            'note' => 5,
            'statut' => Avis::STATUT_EN_ATTENTE,
        ]);
    }

    /** @test */
    public function un_utilisateur_ne_peut_pas_creer_deux_avis_pour_la_meme_annonce()
    {
        $this->actingAs($this->acheteur);

        // Créer un premier avis
        Avis::factory()->create([
            'annonce_id' => $this->annonce->id,
            'user_id' => $this->acheteur->id,
        ]);

        // Essayer de créer un deuxième avis
        $response = $this->post(route('avis.store', $this->annonce), [
            'note' => 4,
            'commentaire' => 'Un autre avis',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    /** @test */
    public function un_utilisateur_non_connecte_ne_peut_pas_creer_un_avis()
    {
        $response = $this->get(route('avis.create', $this->annonce));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function un_avis_peut_avoir_des_photos()
    {
        Storage::fake('public');
        $this->actingAs($this->acheteur);

        $photo = UploadedFile::fake()->image('photo.jpg');

        $response = $this->post(route('avis.store', $this->annonce), [
            'note' => 5,
            'commentaire' => 'Excellent produit avec photos !',
            'photos' => [$photo],
        ]);

        $response->assertRedirect();
        $avis = Avis::where('annonce_id', $this->annonce->id)
            ->where('user_id', $this->acheteur->id)
            ->first();
        
        $this->assertNotNull($avis->photos);
        $this->assertCount(1, $avis->photos);
    }

    /** @test */
    public function un_admin_peut_approuver_un_avis()
    {
        $admin = User::factory()->create();
        $admin->assignRole('Administrateur');

        $avis = Avis::factory()->create([
            'annonce_id' => $this->annonce->id,
            'user_id' => $this->acheteur->id,
            'statut' => Avis::STATUT_EN_ATTENTE,
        ]);

        $this->actingAs($admin);

        $response = $this->post(route('admin.avis.approve', $avis));

        $response->assertRedirect();
        $avis->refresh();
        $this->assertEquals(Avis::STATUT_APPROUVE, $avis->statut);
    }

    /** @test */
    public function un_admin_peut_rejeter_un_avis()
    {
        $admin = User::factory()->create();
        $admin->assignRole('Administrateur');

        $avis = Avis::factory()->create([
            'annonce_id' => $this->annonce->id,
            'user_id' => $this->acheteur->id,
            'statut' => Avis::STATUT_EN_ATTENTE,
        ]);

        $this->actingAs($admin);

        $response = $this->post(route('admin.avis.reject', $avis), [
            'raison_rejet' => 'Contenu inapproprié',
        ]);

        $response->assertRedirect();
        $avis->refresh();
        $this->assertEquals(Avis::STATUT_REJETE, $avis->statut);
        $this->assertEquals('Contenu inapproprié', $avis->raison_rejet);
    }

    /** @test */
    public function seuls_les_avis_approuves_sont_affichés()
    {
        // Créer des avis avec différents statuts
        $avisApprouve = Avis::factory()->create([
            'annonce_id' => $this->annonce->id,
            'statut' => Avis::STATUT_APPROUVE,
        ]);

        $avisEnAttente = Avis::factory()->create([
            'annonce_id' => $this->annonce->id,
            'statut' => Avis::STATUT_EN_ATTENTE,
        ]);

        $avisRejete = Avis::factory()->create([
            'annonce_id' => $this->annonce->id,
            'statut' => Avis::STATUT_REJETE,
        ]);

        $response = $this->get(route('annonces.show', $this->annonce));

        $response->assertStatus(200);
        $response->assertSee($avisApprouve->commentaire);
        $response->assertDontSee($avisEnAttente->commentaire);
        $response->assertDontSee($avisRejete->commentaire);
    }

    /** @test */
    public function la_note_moyenne_est_calculee_correctement()
    {
        Avis::factory()->create([
            'annonce_id' => $this->annonce->id,
            'note' => 5,
            'statut' => Avis::STATUT_APPROUVE,
        ]);

        Avis::factory()->create([
            'annonce_id' => $this->annonce->id,
            'note' => 3,
            'statut' => Avis::STATUT_APPROUVE,
        ]);

        $this->annonce->load('avisApprouves');
        $noteMoyenne = $this->annonce->note_moyenne;

        $this->assertEquals(4.0, $noteMoyenne);
    }
}
