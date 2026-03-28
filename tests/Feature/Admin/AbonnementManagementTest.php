<?php

namespace Tests\Feature\Admin;

use App\Models\Abonnement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AbonnementManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->seed(\Database\Seeders\RoleSeeder::class);
        
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
    }

    /**
     * Test listing abonnements for admin
     */
    public function test_admin_can_list_abonnements(): void
    {
        Abonnement::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)->get(route('admin.abonnements.index'));

        $response->assertStatus(200);
        $response->assertViewHas('abonnements');
        $response->assertSee('Packs d\'Abonnement');
    }

    /**
     * Test create abonnement
     */
    public function test_admin_can_create_abonnement(): void
    {
        $data = [
            'type' => 'basic',
            'description' => 'A great new pack',
            'prix_mensuel' => 9000,
            'commission' => 2.5,
            'nombre_annonces' => 50,
            'actif' => 1,
            'page_pro' => 1,
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.abonnements.store'), $data);

        $response->assertRedirect(route('admin.abonnements.index'));
        $this->assertDatabaseHas('abonnements', [
            'nom' => 'Basic',
            'type' => 'basic',
            'prix_mensuel' => 9000,
            'page_pro_personnalisable' => false,
        ]);
    }

    /**
     * Test create abonnement with invalid type
     */
    public function test_admin_cannot_create_abonnement_with_invalid_type(): void
    {
        $data = [
            'type' => 'invalid-type',
            'description' => 'Should fail',
            'prix_mensuel' => 5000,
            'commission' => 5,
            'nombre_annonces' => 10,
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.abonnements.store'), $data);

        $response->assertSessionHasErrors('type');
    }

    /**
     * Test edit abonnement
     */
    public function test_admin_can_edit_abonnement(): void
    {
        $abonnement = Abonnement::all()->first() ?: Abonnement::factory()->create();

        $data = [
            'type' => $abonnement->type,
            'description' => 'Updated description',
            'prix_mensuel' => 12000,
            'commission' => 1.5,
            'nombre_annonces' => 100,
            'actif' => 1,
            'page_pro' => 1,
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.abonnements.update', $abonnement), $data);

        $response->assertRedirect(route('admin.abonnements.index'));
        $this->assertDatabaseHas('abonnements', [
            'id' => $abonnement->id,
            'nom' => ucfirst($abonnement->type),
            'prix_mensuel' => 12000,
            'page_pro_personnalisable' => ($abonnement->type === 'expert'),
        ]);
    }

    /**
     * Test delete abonnement
     */
    public function test_admin_can_delete_unused_abonnement(): void
    {
        $abonnement = Abonnement::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.abonnements.destroy', $abonnement));

        $response->assertRedirect(route('admin.abonnements.index'));
        $this->assertDatabaseMissing('abonnements', ['id' => $abonnement->id]);
    }
}
