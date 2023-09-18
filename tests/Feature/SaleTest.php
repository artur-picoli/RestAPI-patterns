<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Customer;
use App\Models\Sale;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SaleTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_route_is_working()
    {
        Sanctum::actingAs($this->user);
        Sale::factory(10)->create();

        $this->getJson('/api/vendas')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'price',
                        'sold_in',
                        'car' => [
                            'id',
                            'model',
                            'year',
                            'color',
                            'brand' => [
                                'id',
                                'name'
                            ]
                        ],
                        'customer' => [
                            'id',
                            'name',
                            'cpf'
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
        $customer = Customer::factory()->create();
        $car = Car::factory()->create();

        $this->postJson('/api/vendas', [
            'customer_id' => $customer->id,
            'car_id' => $car->id,
            'price' => fake()->randomFloat(2, 2000, 500000)
        ])->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'price',
                    'sold_in',
                    'car' => [
                        'id',
                        'model',
                        'year',
                        'color',
                        'brand' => [
                            'id',
                            'name'
                        ]
                    ],
                    'customer' => [
                        'id',
                        'name',
                        'cpf'
                    ]
                ],
            ]);
    }

    public function test_show_route_is_working()
    {
        Sanctum::actingAs($this->user);
        $sale = Sale::factory()->create();

        $this->getJson('/api/vendas/' . $sale->id)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'price',
                    'sold_in',
                    'car' => [
                        'id',
                        'model',
                        'year',
                        'color',
                        'brand' => [
                            'id',
                            'name'
                        ]
                    ],
                    'customer' => [
                        'id',
                        'name',
                        'cpf'
                    ]
                ],
            ]);
    }

    public function test_update_route_is_working()
    {
        Sanctum::actingAs($this->user);
        $sale = Sale::factory()->create();
        $customer = Customer::factory()->create();
        $car = Car::factory()->create();

        $this->putJson('/api/vendas/' . $sale->id, [
            'customer_id' => $customer->id,
            'car_id' => $car->id,
            'price' => fake()->numberBetween(200000, 500000) / 100
        ])->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'price',
                    'sold_in',
                    'car' => [
                        'id',
                        'model',
                        'year',
                        'color',
                        'brand' => [
                            'id',
                            'name'
                        ]
                    ],
                    'customer' => [
                        'id',
                        'name',
                        'cpf'
                    ]
                ],
            ]);
    }

    public function test_destroy_route_is_working()
    {
        Sanctum::actingAs($this->user);
        $sale = Sale::factory()->create();

        $this->deleteJson('/api/vendas/' . $sale->id)
            ->assertStatus(200)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function test_store_route_requires_authentication()
    {
        $customer = Customer::factory()->create();
        $car = Car::factory()->create();

        $this->postJson('/api/vendas', [
            'customer_id' => $customer->id,
            'car_id' => $car->id,
            'price' => fake()->randomFloat(2, 2000, 500000)
        ])->assertStatus(401)
            ->assertJson([
                'message' => 'Usuário não autenticado.',
            ]);
    }

    public function test_store_route_fails_validation()
    {
        Sanctum::actingAs($this->user);

        $this->postJson('/api/vendas', [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['customer_id', 'car_id', 'price']);
    }
}
