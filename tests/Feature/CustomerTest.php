<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_route_is_working()
    {
        Sanctum::actingAs($this->user);
        Customer::factory(10)->create();

        $this->getJson('/api/clientes')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'name',
                        'cpf',
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

        $this->postJson('/api/clientes', [
            'name' => fake()->firstName(),
            'cpf' => fake()->cpf(),
        ])->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'name',
                    'cpf',
                ],
            ]);
    }

    public function test_show_route_is_working()
    {
        Sanctum::actingAs($this->user);
        $customer = Customer::factory()->create();

        $this->getJson('/api/clientes/' . $customer->id)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'cpf',
                ],
            ]);
    }

    public function test_update_route_is_working()
    {
        Sanctum::actingAs($this->user);
        $customer = Customer::factory()->create();

        $this->putJson('/api/clientes/' . $customer->id, [
            'name' => fake()->firstName(),
            'cpf' => fake()->cpf(),
        ])->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'name',
                    'cpf',
                ],
            ]);
    }

    public function test_destroy_route_is_working()
    {
        Sanctum::actingAs($this->user);
        $customer = Customer::factory()->create();

        $this->deleteJson('/api/clientes/' . $customer->id)
            ->assertStatus(200)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function test_store_route_requires_authentication()
    {
        $this->postJson('/api/clientes', [
            'name' => fake()->firstName(),
            'cpf' => fake()->cpf(),
        ])->assertStatus(401)
            ->assertJson([
                'message' => 'Usuário não autenticado.',
            ]);
    }

    public function test_store_route_fails_validation()
    {
        Sanctum::actingAs($this->user);

        $this->postJson('/api/clientes', [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name','cpf']);
    }
}
