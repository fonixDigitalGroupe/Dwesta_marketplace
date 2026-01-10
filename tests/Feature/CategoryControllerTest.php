<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anyone_can_view_a_category()
    {
        $category = Category::factory()->create([
            'nom' => 'Test Category',
            'slug' => 'test-category',
            'actif' => true,
        ]);

        $response = $this->get(route('categories.show', $category->slug));

        $response->assertStatus(200);
        $response->assertViewIs('categories.show');
        $response->assertViewHas('category', $category);
        $response->assertSee('Test Category');
    }

    /** @test */
    public function category_page_shows_breadcrumbs()
    {
        $parent = Category::factory()->create(['nom' => 'Parent']);
        $child = Category::factory()->create([
            'nom' => 'Child',
            'parent_id' => $parent->id,
        ]);

        $response = $this->get(route('categories.show', $child->slug));

        $response->assertStatus(200);
        $response->assertSee('Parent');
        $response->assertSee('Child');
    }

    /** @test */
    public function category_page_shows_subcategories()
    {
        $parent = Category::factory()->create(['nom' => 'Parent']);
        $child1 = Category::factory()->create([
            'nom' => 'Child 1',
            'parent_id' => $parent->id,
            'actif' => true,
        ]);
        $child2 = Category::factory()->create([
            'nom' => 'Child 2',
            'parent_id' => $parent->id,
            'actif' => true,
        ]);

        $response = $this->get(route('categories.show', $parent->slug));

        $response->assertStatus(200);
        $response->assertSee('Child 1');
        $response->assertSee('Child 2');
    }

    /** @test */
    public function inactive_subcategories_are_not_shown()
    {
        $parent = Category::factory()->create(['nom' => 'Parent']);
        $activeChild = Category::factory()->create([
            'nom' => 'Active Child',
            'parent_id' => $parent->id,
            'actif' => true,
        ]);
        $inactiveChild = Category::factory()->create([
            'nom' => 'Inactive Child',
            'parent_id' => $parent->id,
            'actif' => false,
        ]);

        $response = $this->get(route('categories.show', $parent->slug));

        $response->assertStatus(200);
        $response->assertSee('Active Child');
        $response->assertDontSee('Inactive Child');
    }

    /** @test */
    public function inactive_category_returns_404()
    {
        $category = Category::factory()->create([
            'nom' => 'Inactive Category',
            'slug' => 'inactive-category',
            'actif' => false,
        ]);

        $response = $this->get(route('categories.show', $category->slug));

        $response->assertStatus(404);
    }

    /** @test */
    public function non_existent_category_returns_404()
    {
        $response = $this->get(route('categories.show', 'non-existent-slug'));

        $response->assertStatus(404);
    }

    /** @test */
    public function category_page_shows_description()
    {
        $category = Category::factory()->create([
            'nom' => 'Test Category',
            'description' => 'This is a test description',
            'actif' => true,
        ]);

        $response = $this->get(route('categories.show', $category->slug));

        $response->assertStatus(200);
        $response->assertSee('This is a test description');
    }

    /** @test */
    public function category_page_shows_icon_if_present()
    {
        $category = Category::factory()->create([
            'nom' => 'Test Category',
            'icone' => 'test-icon',
            'actif' => true,
        ]);

        $response = $this->get(route('categories.show', $category->slug));

        $response->assertStatus(200);
        $response->assertSee('test-icon');
    }
}
