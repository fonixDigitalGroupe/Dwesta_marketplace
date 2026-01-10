<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vendeur;
use App\Models\VendeurParticulier;
use App\Models\VendeurProfessionnel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VendeurTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test création compte vendeur particulier
     */
    public function test_peut_creer_compte_vendeur_particulier(): void
    {
        Storage::fake('private');

        $user = User::factory()->create();
        $this->actingAs($user);

        $file = UploadedFile::fake()->create('cni.pdf', 1000);

        $response = $this->post(route('vendeur.store.particulier'), [
            'type_document' => 'cni',
            'numero_document' => '123456789',
            'document' => $file,
            'date_emission_document' => '2020-01-01',
            'date_expiration_document' => '2030-01-01',
            'lieu_emission' => 'Paris',
        ]);

        $response->assertRedirect(route('vendeur.show'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('vendeurs', [
            'user_id' => $user->id,
            'type' => 'particulier',
            'statut_verification' => 'en_attente',
        ]);

        $vendeur = Vendeur::where('user_id', $user->id)->first();
        $this->assertNotNull($vendeur->particulier);
        $this->assertEquals('cni', $vendeur->particulier->type_document);
        $this->assertTrue($user->hasRole('Vendeur Particulier'));
    }

    /**
     * Test création compte vendeur professionnel
     */
    public function test_peut_creer_compte_vendeur_professionnel(): void
    {
        Storage::fake('private');

        $user = User::factory()->create();
        $this->actingAs($user);

        $file = UploadedFile::fake()->create('registre.pdf', 2000);

        $response = $this->post(route('vendeur.store.professionnel'), [
            'nom_entreprise' => 'Ma Société SARL',
            'registre_commerce' => $file,
            'numero_registre_commerce' => 'RC123456',
            'date_expiration_registre' => '2030-12-31',
            'adresse_entreprise' => '123 Rue Example',
            'telephone_entreprise' => '+221771234567',
            'email_entreprise' => 'contact@masociete.com',
        ]);

        $response->assertRedirect(route('vendeur.show'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('vendeurs', [
            'user_id' => $user->id,
            'type' => 'professionnel',
            'statut_verification' => 'en_attente',
        ]);

        $vendeur = Vendeur::where('user_id', $user->id)->first();
        $this->assertNotNull($vendeur->professionnel);
        $this->assertEquals('Ma Société SARL', $vendeur->professionnel->nom_entreprise);
        $this->assertTrue($user->hasRole('Vendeur Professionnel'));
    }

    /**
     * Test qu'un utilisateur ne peut avoir qu'un seul compte vendeur
     */
    public function test_utilisateur_ne_peut_avoir_qu_un_compte_vendeur(): void
    {
        Storage::fake('private');

        $user = User::factory()->create();
        $this->actingAs($user);

        // Créer un premier compte vendeur
        $vendeur = Vendeur::factory()->create(['user_id' => $user->id, 'type' => 'particulier']);

        // Essayer de créer un autre compte
        $file = UploadedFile::fake()->create('cni.pdf', 1000);
        $response = $this->post(route('vendeur.store.particulier'), [
            'type_document' => 'cni',
            'numero_document' => '123456789',
            'document' => $file,
            'date_emission_document' => '2020-01-01',
        ]);

        $response->assertRedirect(route('vendeur.show'));
        $response->assertSessionHas('info');

        // Vérifier qu'il n'y a toujours qu'un seul vendeur
        $this->assertEquals(1, Vendeur::where('user_id', $user->id)->count());
    }

    /**
     * Test upload document avec validation
     */
    public function test_upload_document_valide_format_et_taille(): void
    {
        Storage::fake('private');

        $user = User::factory()->create();
        $this->actingAs($user);

        // Test avec fichier trop volumineux
        $file = UploadedFile::fake()->create('document.pdf', 6000); // 6 Mo

        $response = $this->post(route('vendeur.store.particulier'), [
            'type_document' => 'cni',
            'numero_document' => '123456789',
            'document' => $file,
            'date_emission_document' => '2020-01-01',
        ]);

        $response->assertSessionHasErrors('document');

        // Test avec format invalide
        $file = UploadedFile::fake()->create('document.txt', 1000);

        $response = $this->post(route('vendeur.store.particulier'), [
            'type_document' => 'cni',
            'numero_document' => '123456789',
            'document' => $file,
            'date_emission_document' => '2020-01-01',
        ]);

        $response->assertSessionHasErrors('document');
    }

    /**
     * Test affichage compte vendeur
     */
    public function test_peut_afficher_compte_vendeur(): void
    {
        $user = User::factory()->create();
        $vendeur = Vendeur::factory()->create(['user_id' => $user->id, 'type' => 'particulier']);
        VendeurParticulier::factory()->create(['vendeur_id' => $vendeur->id]);

        $this->actingAs($user);

        $response = $this->get(route('vendeur.show'));

        $response->assertStatus(200);
        $response->assertViewIs('vendeur.show');
        $response->assertViewHas('vendeur');
    }
}
