<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use App\Notifications\EmailOtpNotification;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class RegistrationCompletionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Create necessary roles and countries
        Role::create(['name' => 'acheteur']);
        Country::create(['name' => 'Sénégal', 'code' => 'SN', 'is_active' => true]);
    }

    /** @test */
    public function a_user_can_register_with_all_fields()
    {
        Notification::fake();

        $response = $this->post('/register', [
            'civilite' => 'monsieur',
            'prenom' => 'John',
            'nom' => 'Doe',
            'email' => 'john@example.com',
            'birth_day' => '15',
            'birth_month' => '05',
            'birth_year' => '1990',
            'nationalite' => 'Sénégal',
            'adresse' => 'Sacré Coeur, Dakar',
            'telephone' => '771234567',
            'full_telephone' => '+221771234567',
            'password' => 'Password123!',
            'terms_accepted' => 'on',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('otp.verify'));

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'civilite' => 'monsieur',
            'prenom' => 'John',
            'nom' => 'Doe',
            'date_de_naissance' => '1990-05-15 00:00:00',
            'telephone' => '+221771234567',
        ]);

        $user = User::where('email', 'john@example.com')->first();
        $this->assertTrue($user->hasRole('acheteur'));
        
        Notification::assertSentTo($user, EmailOtpNotification::class);
    }

    /** @test */
    public function registration_fails_if_fields_are_missing()
    {
        $response = $this->post('/register', [
            'prenom' => 'John',
            // Missing email, birth date, etc.
        ]);

        $response->assertSessionHasErrors(['civilite', 'email', 'birth_day', 'birth_month', 'birth_year', 'full_telephone', 'password']);
    }

    /** @test */
    public function real_time_email_check_works()
    {
        User::factory()->create(['email' => 'existing@example.com']);

        $response = $this->postJson('/register/check-email', ['email' => 'existing@example.com']);
        $response->assertJson(['exists' => true]);

        $response = $this->postJson('/register/check-email', ['email' => 'new@example.com']);
        $response->assertJson(['exists' => false]);
    }
}
