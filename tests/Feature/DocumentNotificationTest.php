<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vendeur;
use App\Models\VendeurParticulier;
use App\Services\DocumentNotificationService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DocumentNotificationTest extends TestCase
{
    use RefreshDatabase;

    protected DocumentNotificationService $notificationService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->notificationService = app(DocumentNotificationService::class);
    }

    /**
     * Test détection document expirant dans 30 jours
     */
    public function test_detecte_document_expirant_dans_30_jours(): void
    {
        $user = User::factory()->create();
        $vendeur = Vendeur::factory()->create(['user_id' => $user->id]);
        
        $particulier = VendeurParticulier::factory()->create([
            'vendeur_id' => $vendeur->id,
            'date_expiration_document' => Carbon::now()->addDays(30),
        ]);

        $alertes = $this->notificationService->getAlertesActives($vendeur);

        $this->assertCount(1, $alertes);
        $this->assertEquals('particulier', $alertes[0]['type']);
        $this->assertEquals(30, $alertes[0]['jours_restants']);
    }

    /**
     * Test détection document expiré
     */
    public function test_detecte_document_expire(): void
    {
        $user = User::factory()->create();
        $vendeur = Vendeur::factory()->create(['user_id' => $user->id]);
        
        $particulier = VendeurParticulier::factory()->create([
            'vendeur_id' => $vendeur->id,
            'date_expiration_document' => Carbon::now()->subDays(10),
        ]);

        $alertes = $this->notificationService->getAlertesActives($vendeur);

        $this->assertCount(1, $alertes);
        $this->assertTrue($alertes[0]['est_expire']);
    }

    /**
     * Test vérification si notification doit être envoyée
     */
    public function test_verifie_si_notification_doit_etre_envoyee(): void
    {
        $user = User::factory()->create();
        $vendeur = Vendeur::factory()->create(['user_id' => $user->id]);

        $dateExpiration = Carbon::now()->addDays(30);

        // Première vérification - doit envoyer
        $doitEnvoyer = $this->notificationService->doitEnvoyerNotification($vendeur, 'particulier', $dateExpiration);
        $this->assertTrue($doitEnvoyer);

        // Enregistrer la notification
        $this->notificationService->enregistrerNotification($vendeur, 'particulier', $dateExpiration, 30);

        // Deuxième vérification - ne doit pas envoyer (déjà envoyée)
        $doitEnvoyer = $this->notificationService->doitEnvoyerNotification($vendeur, 'particulier', $dateExpiration);
        $this->assertFalse($doitEnvoyer);
    }

    /**
     * Test alertes pour abonnement expirant
     */
    public function test_detecte_abonnement_expirant(): void
    {
        $user = User::factory()->create();
        $vendeur = Vendeur::factory()->create(['user_id' => $user->id]);
        
        $abonnement = \App\Models\Abonnement::factory()->create();
        $vendeurAbonnement = \App\Models\VendeurAbonnement::factory()->create([
            'vendeur_id' => $vendeur->id,
            'abonnement_id' => $abonnement->id,
            'date_fin' => Carbon::now()->addDays(15),
            'actif' => true,
        ]);

        $alertes = $this->notificationService->getAlertesActives($vendeur);

        $this->assertCount(1, $alertes);
        $this->assertEquals('abonnement', $alertes[0]['type']);
    }
}
