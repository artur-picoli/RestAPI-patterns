<?php

namespace Tests\Feature;

use App\Models\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BrandTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_route_is_working()
    {
        Sanctum::actingAs($this->user);
        Brand::factory(10)->create();

        $this->getJson('/api/marcas')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'name',
                    ]
                ],
                'links' => [],
                'meta' => [],
            ])
            ->assertJsonCount(10, 'data');
    }

    public function test_store_route_is_working()
    {
        Sanctum::actingAs($this->user);

        $this->postJson('/api/marcas', [
            'name' => fake()->firstName()
        ])->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'name',
                ],
            ]);
    }

    public function test_show_route_is_working()
    {
        Sanctum::actingAs($this->user);
        $brand = Brand::factory()->create();

        $this->getJson('/api/marcas/' . $brand->id, [
            'name' => fake()->firstName()
        ])->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                ],
            ]);
    }

    public function test_update_route_is_working()
    {
        Sanctum::actingAs($this->user);
        $brand = Brand::factory()->create();

        $this->putJson('/api/marcas/' . $brand->id, [
            'name' => fake()->firstName()
        ])->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'name',
                ],
            ]);
    }

    public function test_destroy_route_is_working()
    {
        Sanctum::actingAs($this->user);
        $brand = Brand::factory()->create();

        $this->deleteJson('/api/marcas/' . $brand->id)
            ->assertStatus(200)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function test_store_route_requires_authentication()
    {
        $this->postJson('/api/marcas', [
            'name' => 'Nova Marca'
        ])->assertStatus(401)
            ->assertJson([
                'message' => 'Usuário não autenticado.',
            ]);
    }

    public function test_store_route_fails_validation()
    {
        Sanctum::actingAs($this->user);

        $this->postJson('/api/marcas', [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }
}
