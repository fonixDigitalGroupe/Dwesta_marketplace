<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Créer le rôle Administrateur si nécessaire
        if (!Role::where('name', 'Administrateur')->exists()) {
            Role::create(['name' => 'Administrateur']);
        }
    }

    /** @test */
    public function admin_can_view_categories_index()
    {
        $admin = User::factory()->create();
        $admin->assignRole('Administrateur');

        $response = $this->actingAs($admin)->get(route('admin.categories.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.categories.index');
    }

    /** @test */
    public function non_admin_cannot_access_categories_index()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.categories.index'));

        $response->assertForbidden();
    }

    /** @test */
    public function admin_can_view_create_category_form()
    {
        $admin = User::factory()->create();
        $admin->assignRole('Administrateur');

        $response = $this->actingAs($admin)->get(route('admin.categories.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.categories.create');
    }

    /** @test */
    public function admin_can_create_a_category()
    {
        $admin = User::factory()->create();
        $admin->assignRole('Administrateur');

        $data = [
            'nom' => 'Nouvelle Catégorie',
            'description' => 'Description de la catégorie',
            'icone' => 'test-icon',
            'ordre' => 0,
            'actif' => true,
        ];

        $response = $this->actingAs($admin)->post(route('admin.categories.store'), $data);

        $response->assertRedirect(route('admin.categories.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('categories', [
            'nom' => 'Nouvelle Catégorie',
            'actif' => true,
        ]);
    }

    /** @test */
    public function admin_can_create_a_subcategory()
    {
        $admin = User::factory()->create();
        $admin->assignRole('Administrateur');
        
        $parent = Category::factory()->create();

        $data = [
            'nom' => 'Sous-catégorie',
            'parent_id' => $parent->id,
            'description' => 'Description',
            'actif' => true,
        ];

        $response = $this->actingAs($admin)->post(route('admin.categories.store'), $data);

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', [
            'nom' => 'Sous-catégorie',
            'parent_id' => $parent->id,
        ]);
    }

    /** @test */
    public function category_creation_requires_name()
    {
        $admin = User::factory()->create();
        $admin->assignRole('Administrateur');

        $response = $this->actingAs($admin)->post(route('admin.categories.store'), []);

        $response->assertSessionHasErrors('nom');
    }

    /** @test */
    public function admin_can_view_category_details()
    {
        $admin = User::factory()->create();
        $admin->assignRole('Administrateur');
        
        $category = Category::factory()->create();

        $response = $this->actingAs($admin)->get(route('admin.categories.show', $category));

        $response->assertStatus(200);
        $response->assertViewIs('admin.categories.show');
        $response->assertViewHas('category', $category);
    }

    /** @test */
    public function admin_can_view_edit_category_form()
    {
        $admin = User::factory()->create();
        $admin->assignRole('Administrateur');
        
        $category = Category::factory()->create();

        $response = $this->actingAs($admin)->get(route('admin.categories.edit', $category));

        $response->assertStatus(200);
        $response->assertViewIs('admin.categories.edit');
        $response->assertViewHas('category', $category);
    }

    /** @test */
    public function admin_can_update_a_category()
    {
        $admin = User::factory()->create();
        $admin->assignRole('Administrateur');
        
        $category = Category::factory()->create(['nom' => 'Ancien Nom']);

        $data = [
            'nom' => 'Nouveau Nom',
            'description' => 'Nouvelle description',
            'icone' => 'new-icon',
            'ordre' => 5,
            'actif' => true,
        ];

        $response = $this->actingAs($admin)->put(route('admin.categories.update', $category), $data);

        $response->assertRedirect(route('admin.categories.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'nom' => 'Nouveau Nom',
        ]);
    }

    /** @test */
    public function admin_cannot_set_category_as_its_own_parent()
    {
        $admin = User::factory()->create();
        $admin->assignRole('Administrateur');
        
        $category = Category::factory()->create();

        $data = [
            'nom' => $category->nom,
            'parent_id' => $category->id,
            'actif' => true,
        ];

        $response = $this->actingAs($admin)->put(route('admin.categories.update', $category), $data);

        $response->assertSessionHasErrors('parent_id');
    }

    /** @test */
    public function admin_can_delete_a_category_without_children()
    {
        $admin = User::factory()->create();
        $admin->assignRole('Administrateur');
        
        $category = Category::factory()->create();

        $response = $this->actingAs($admin)->delete(route('admin.categories.destroy', $category));

        $response->assertRedirect(route('admin.categories.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    /** @test */
    public function admin_can_delete_a_category_with_children_recursively()
    {
        $admin = User::factory()->create();
        $admin->assignRole('Administrateur');
        
        $parent = Category::factory()->create();
        $child1 = Category::factory()->create(['parent_id' => $parent->id]);
        $child2 = Category::factory()->create(['parent_id' => $parent->id]);
        $grandchild = Category::factory()->create(['parent_id' => $child1->id]);

        $response = $this->actingAs($admin)->delete(route('admin.categories.destroy', $parent));

        $response->assertRedirect(route('admin.categories.index'));
        $response->assertSessionHas('success');
        // La catégorie parent et tous ses descendants doivent être supprimés
        $this->assertDatabaseMissing('categories', ['id' => $parent->id]);
        $this->assertDatabaseMissing('categories', ['id' => $child1->id]);
        $this->assertDatabaseMissing('categories', ['id' => $child2->id]);
        $this->assertDatabaseMissing('categories', ['id' => $grandchild->id]);
    }

    /** @test */
    public function slug_is_automatically_generated_from_name()
    {
        $admin = User::factory()->create();
        $admin->assignRole('Administrateur');

        $data = [
            'nom' => 'Test Category Name',
            'actif' => true,
        ];

        $this->actingAs($admin)->post(route('admin.categories.store'), $data);

        $this->assertDatabaseHas('categories', [
            'nom' => 'Test Category Name',
            'slug' => 'test-category-name',
        ]);
    }

    /** @test */
    public function slug_is_updated_when_name_changes()
    {
        $admin = User::factory()->create();
        $admin->assignRole('Administrateur');
        
        $category = Category::factory()->create(['nom' => 'Ancien Nom', 'slug' => 'ancien-nom']);

        $data = [
            'nom' => 'Nouveau Nom',
            'actif' => true,
        ];

        $this->actingAs($admin)->put(route('admin.categories.update', $category), $data);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'slug' => 'nouveau-nom',
        ]);
    }
}
