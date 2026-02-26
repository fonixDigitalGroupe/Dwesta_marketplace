<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Setting;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminSettingsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::create(['name' => 'admin', 'guard_name' => 'web']);
    }

    /** @test */
    public function admin_can_access_settings_page()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get(route('admin.settings.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.settings.index');
    }

    /** @test */
    public function non_admin_cannot_access_settings_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.settings.index'));

        $response->assertStatus(403);
    }

    /** @test */
    public function admin_can_update_settings()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->post(route('admin.settings.update'), [
            'site_name' => 'New Site Name',
            'site_description' => 'New Site Description',
            'contact_emails' => ['contact1@example.com', 'contact2@example.com'],
            'contact_phones' => ['+33123456789', '+33987654321'],
        ]);

        $response->assertRedirect();
        $this->assertEquals('New Site Name', Setting::get('site_name'));
        $this->assertEquals('New Site Description', Setting::get('site_description'));
        
        $emails = json_decode(Setting::get('contact_emails'), true);
        $this->assertCount(2, $emails);
        $this->assertContains('contact1@example.com', $emails);

        $phones = json_decode(Setting::get('contact_phones'), true);
        $this->assertCount(2, $phones);
        $this->assertContains('+33123456789', $phones);
    }

    /** @test */
    public function admin_can_upload_logo()
    {
        Storage::fake('public');
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $file = UploadedFile::fake()->image('logo.png');

        $response = $this->actingAs($admin)->post(route('admin.settings.update'), [
            'logo' => $file,
        ]);

        $response->assertRedirect();
        $setting = Setting::where('key', 'logo')->first();
        $this->assertNotNull($setting);
        Storage::disk('public')->assertExists($setting->value);
    }

    /** @test */
    public function settings_are_shared_globally()
    {
        Setting::set('site_name', 'Global Site Name');
        Setting::set('contact_emails', json_encode(['contact@example.com']));

        // Manually trigger the provider boot to simulate a fresh request with data in DB
        (new \App\Providers\SettingsServiceProvider(app()))->boot();

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertViewHas('siteSettings');
        $this->assertEquals('Global Site Name', $response->viewData('siteSettings')['site_name']);
        $this->assertIsArray($response->viewData('siteSettings')['contact_emails']);
    }

    /** @test */
    public function admin_can_remove_logo()
    {
        Storage::fake('public');
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        // First set a logo
        $file = UploadedFile::fake()->image('logo.png');
        $path = $file->store('settings', 'public');
        Setting::set('logo', $path, 'image');
        Storage::disk('public')->assertExists($path);

        // Then remove it
        $response = $this->actingAs($admin)->post(route('admin.settings.update'), [
            'remove_logo' => '1',
        ]);

        $response->assertRedirect();
        $this->assertNull(Setting::get('logo'));
        Storage::disk('public')->assertMissing($path);
    }
}
