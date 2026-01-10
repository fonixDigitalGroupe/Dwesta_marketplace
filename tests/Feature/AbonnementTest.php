<?php

namespace Tests\Feature;

use App\Models\Abonnement;
use App\Models\User;
use App\Models\Vendeur;
use App\Models\VendeurAbonnement;
use App\Services\AbonnementService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AbonnementTest extends TestCase
{
    use RefreshDatabase;

    protected AbonnementService $abonnementService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->abonnementService = app(AbonnementService::class);
    }

    /**
     * Test création abonnements de base
     */
    public function test_abonnements_sont_crees_par_seeder(): void
    {
        $this->artisan('db:seed', ['--class' => 'AbonnementSeeder']);

        $this->assertDatabaseHas('abonnements', ['type' => Abonnement::TYPE_GRATUIT]);
        $this->assertDatabaseHas('abonnements', ['type' => Abonnement::TYPE_BASIC]);
        $this->assertDatabaseHas('abonnements', ['type' => Abonnement::TYPE_EXPERT]);
    }

    /**
     * Test souscription à un abonnement
     */
    public function test_peut_souscrire_a_un_abonnement(): void
    {
        $abonnement = Abonnement::factory()->create(['type' => Abonnement::TYPE_BASIC]);
        $user = User::factory()->create();
        $vendeur = Vendeur::factory()->create([
            'user_id' => $user->id,
            'statut_verification' => 'verifie',
        ]);

        $vendeurAbonnement = $this->abonnementService->souscrire($vendeur, $abonnement, 1, false);

        $this->assertDatabaseHas('vendeur_abonnements', [
            'vendeur_id' => $vendeur->id,
            'abonnement_id' => $abonnement->id,
            'actif' => true,
        ]);

        $this->assertTrue($vendeurAbonnement->actif);
        $this->assertFalse($vendeurAbonnement->renouvellement_automatique);
    }

    /**
     * Test limitation annonces selon abonnement
     */
    public function test_limite_annonces_selon_abonnement(): void
    {
        // Abonnement avec 10 annonces
        $abonnement = Abonnement::factory()->create([
            'type' => Abonnement::TYPE_BASIC,
            'nombre_annonces' => 10,
        ]);

        $user = User::factory()->create();
        $vendeur = Vendeur::factory()->create([
            'user_id' => $user->id,
            'statut_verification' => 'verifie',
        ]);

        $vendeurAbonnement = VendeurAbonnement::factory()->create([
            'vendeur_id' => $vendeur->id,
            'abonnement_id' => $abonnement->id,
            'actif' => true,
            'nombre_annonces_utilisees' => 9,
        ]);

        // Peut encore publier
        $this->assertTrue($vendeurAbonnement->peutPublierAnnonce());

        // Atteindre la limite
        $vendeurAbonnement->incrementerAnnonces();
        $this->assertFalse($vendeurAbonnement->peutPublierAnnonce());
    }

    /**
     * Test abonnement avec annonces illimitées
     */
    public function test_abonnement_illimite_peut_toujours_publier(): void
    {
        $abonnement = Abonnement::factory()->create([
            'type' => Abonnement::TYPE_EXPERT,
            'nombre_annonces' => 0, // Illimité
        ]);

        $user = User::factory()->create();
        $vendeur = Vendeur::factory()->create([
            'user_id' => $user->id,
            'statut_verification' => 'verifie',
        ]);

        $vendeurAbonnement = VendeurAbonnement::factory()->create([
            'vendeur_id' => $vendeur->id,
            'abonnement_id' => $abonnement->id,
            'actif' => true,
            'nombre_annonces_utilisees' => 1000, // Beaucoup d'annonces
        ]);

        $this->assertTrue($vendeurAbonnement->peutPublierAnnonce());
    }

    /**
     * Test calcul commission
     */
    public function test_calcule_commission_correctement(): void
    {
        $abonnement = Abonnement::factory()->create([
            'type' => Abonnement::TYPE_BASIC,
            'commission' => 7.50,
        ]);

        $user = User::factory()->create();
        $vendeur = Vendeur::factory()->create([
            'user_id' => $user->id,
            'statut_verification' => 'verifie',
        ]);

        VendeurAbonnement::factory()->create([
            'vendeur_id' => $vendeur->id,
            'abonnement_id' => $abonnement->id,
            'actif' => true,
        ]);

        $montant = 10000;
        $commission = $this->abonnementService->calculerCommission($vendeur, $montant);

        $this->assertEquals(750, $commission); // 7.5% de 10000
    }

    /**
     * Test renouvellement automatique
     */
    public function test_renouvelle_abonnement_automatiquement(): void
    {
        $abonnement = Abonnement::factory()->create();
        $user = User::factory()->create();
        $vendeur = Vendeur::factory()->create(['user_id' => $user->id]);

        $vendeurAbonnement = VendeurAbonnement::factory()->create([
            'vendeur_id' => $vendeur->id,
            'abonnement_id' => $abonnement->id,
            'actif' => true,
            'renouvellement_automatique' => true,
            'date_fin' => now()->subDay(), // Expiré hier
        ]);

        $nouveau = $this->abonnementService->renouvelerAutomatiquement($vendeurAbonnement);

        $this->assertNotNull($nouveau);
        $this->assertTrue($nouveau->actif);
        $this->assertTrue($nouveau->renouvellement_automatique);
        $this->assertFalse($vendeurAbonnement->fresh()->actif);
    }
}
