<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Car;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CarTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_route_is_working()
    {
        Sanctum::actingAs($this->user);
        Car::factory(10)->create();

        $this->getJson('/api/carros')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'model',
                        'year',
                        'color',
                        'brand' => [
                            'id',
                            'name'
                        ]
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
        $brand = Brand::factory()->create();

        $this->postJson('/api/carros', [
            'model' => fake()->firstName(),
            'year' => fake()->year(),
            'color' => fake()->colorName(),
            'brand_id' => $brand->id
        ])->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'model',
                    'year',
                    'color',
                    'brand' => [
                        'id',
                        'name'
                    ]
                ],
            ]);
    }

    public function test_show_route_is_working()
    {
        Sanctum::actingAs($this->user);
        $car = Car::factory()->create();

        $this->getJson('/api/carros/' . $car->id)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'model',
                    'year',
                    'color',
                    'brand' => [
                        'id',
                        'name'
                    ]
                ],
            ]);
    }

    public function test_update_route_is_working()
    {
        Sanctum::actingAs($this->user);
        $car = Car::factory()->create();
        $brand = Brand::factory()->create();

        $this->putJson('/api/carros/' . $car->id, [
            'model' => fake()->firstName(),
            'year' => fake()->year(),
            'color' => fake()->colorName(),
            'brand_id' => $brand->id
        ])->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'model',
                    'year',
                    'color',
                    'brand' => [
                        'id',
                        'name'
                    ]
                ],
            ]);
    }

    public function test_destroy_route_is_working()
    {
        Sanctum::actingAs($this->user);
        $car = Car::factory()->create();

        $this->deleteJson('/api/carros/' . $car->id)
            ->assertStatus(200)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function test_store_route_requires_authentication()
    {
        $brand = Brand::factory()->create();

        $this->postJson('/api/carros', [
            'model' => fake()->firstName(),
            'year' => fake()->year(),
            'color' => fake()->colorName(),
            'brand_id' => $brand->id
        ])->assertStatus(401)
            ->assertJson([
                'message' => 'Usuário não autenticado.',
            ]);
    }

    public function test_store_route_fails_validation()
    {
        Sanctum::actingAs($this->user);

        $this->postJson('/api/carros', [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['model', 'year', 'color', 'brand_id']);
    }
}
