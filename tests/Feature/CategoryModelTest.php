<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_category()
    {
        $category = Category::factory()->create([
            'nom' => 'Test Category',
            'slug' => 'test-category',
        ]);

        $this->assertDatabaseHas('categories', [
            'nom' => 'Test Category',
            'slug' => 'test-category',
        ]);
    }

    /** @test */
    public function it_can_have_a_parent_category()
    {
        $parent = Category::factory()->create(['nom' => 'Parent']);
        $child = Category::factory()->create([
            'nom' => 'Child',
            'parent_id' => $parent->id,
        ]);

        $this->assertEquals($parent->id, $child->parent_id);
        $this->assertTrue($child->parent->is($parent));
    }

    /** @test */
    public function it_can_have_multiple_children()
    {
        $parent = Category::factory()->create(['nom' => 'Parent']);
        $child1 = Category::factory()->create(['parent_id' => $parent->id]);
        $child2 = Category::factory()->create(['parent_id' => $parent->id]);

        $this->assertCount(2, $parent->enfants);
        $this->assertTrue($parent->enfants->contains($child1));
        $this->assertTrue($parent->enfants->contains($child2));
    }

    /** @test */
    public function it_can_determine_if_it_is_a_root_category()
    {
        $root = Category::factory()->create(['parent_id' => null]);
        $child = Category::factory()->create(['parent_id' => $root->id]);

        $this->assertTrue($root->estRacine());
        $this->assertFalse($child->estRacine());
    }

    /** @test */
    public function it_can_determine_if_it_has_children()
    {
        $parent = Category::factory()->create();
        $child = Category::factory()->create(['parent_id' => $parent->id]);

        $this->assertTrue($parent->aEnfants());
        $this->assertFalse($child->aEnfants());
    }

    /** @test */
    public function it_can_generate_unique_slug()
    {
        $slug1 = Category::generateSlug('Test Category');
        $category1 = Category::factory()->create(['nom' => 'Test Category', 'slug' => $slug1]);

        $slug2 = Category::generateSlug('Test Category');
        $this->assertNotEquals($slug1, $slug2);
        $this->assertStringStartsWith('test-category', $slug2);
    }

    /** @test */
    public function it_can_get_ancestors()
    {
        $grandparent = Category::factory()->create(['nom' => 'Grandparent']);
        $parent = Category::factory()->create(['nom' => 'Parent', 'parent_id' => $grandparent->id]);
        $child = Category::factory()->create(['nom' => 'Child', 'parent_id' => $parent->id]);

        $ancestors = $child->ancetres;
        
        $this->assertCount(2, $ancestors);
        $this->assertEquals('Grandparent', $ancestors[0]->nom);
        $this->assertEquals('Parent', $ancestors[1]->nom);
    }

    /** @test */
    public function it_can_get_full_path()
    {
        $grandparent = Category::factory()->create(['nom' => 'Grandparent']);
        $parent = Category::factory()->create(['nom' => 'Parent', 'parent_id' => $grandparent->id]);
        $child = Category::factory()->create(['nom' => 'Child', 'parent_id' => $parent->id]);

        $this->assertEquals('Grandparent > Parent > Child', $child->chemin);
    }

    /** @test */
    public function it_can_scope_active_categories()
    {
        Category::factory()->create(['actif' => true]);
        Category::factory()->create(['actif' => true]);
        Category::factory()->create(['actif' => false]);

        $activeCategories = Category::actives()->get();
        
        $this->assertCount(2, $activeCategories);
        $this->assertTrue($activeCategories->every(fn($cat) => $cat->actif === true));
    }

    /** @test */
    public function it_can_scope_root_categories()
    {
        $root1 = Category::factory()->create(['parent_id' => null]);
        $root2 = Category::factory()->create(['parent_id' => null]);
        $child = Category::factory()->create(['parent_id' => $root1->id]);

        $roots = Category::racines()->get();
        
        $this->assertCount(2, $roots);
        $this->assertTrue($roots->contains($root1));
        $this->assertTrue($roots->contains($root2));
        $this->assertFalse($roots->contains($child));
    }

    /** @test */
    public function it_can_get_arborescence()
    {
        $root1 = Category::factory()->create(['nom' => 'Root 1', 'ordre' => 1]);
        $root2 = Category::factory()->create(['nom' => 'Root 2', 'ordre' => 2]);
        $child1 = Category::factory()->create(['parent_id' => $root1->id, 'ordre' => 1]);
        $child2 = Category::factory()->create(['parent_id' => $root1->id, 'ordre' => 2]);

        $arborescence = Category::getArborescence();

        $this->assertCount(2, $arborescence);
        $this->assertEquals('Root 1', $arborescence[0]->nom);
        $this->assertCount(2, $arborescence[0]->enfantsActifs);
    }

    /** @test */
    public function it_only_returns_active_children_in_enfants_actifs()
    {
        $parent = Category::factory()->create();
        $activeChild = Category::factory()->create(['parent_id' => $parent->id, 'actif' => true]);
        $inactiveChild = Category::factory()->create(['parent_id' => $parent->id, 'actif' => false]);

        $this->assertCount(1, $parent->enfantsActifs);
        $this->assertTrue($parent->enfantsActifs->contains($activeChild));
        $this->assertFalse($parent->enfantsActifs->contains($inactiveChild));
    }
}
