<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PostalCodeTest extends TestCase
{

    use RefreshDatabase;

    public function test_find_address_route_is_working()
    {
        Sanctum::actingAs($this->user);
        $query = Arr::query(['cep'=> '18990156']);

        $this->getJson("/api/postal-code?{$query}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'cep',
                    'logradouro',
                    'bairro',
                    'cidade',
                    'uf'
                ]
            ]);
    }
}
