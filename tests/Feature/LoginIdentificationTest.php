<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginIdentificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_email()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'login' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/mon-compte');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_can_login_with_phone_number()
    {
        $user = User::factory()->create([
            'telephone' => '+221771234567',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'login' => '+221771234567',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/mon-compte');
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fails_with_invalid_credentials()
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'login' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('login');
        $this->assertGuest();
    }
}
